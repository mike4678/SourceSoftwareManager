
package hsh.anzh.zj.gjlbk;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.animation.ObjectAnimator;
import android.animation.ValueAnimator;
import android.content.res.Resources;
import android.graphics.Canvas;
import android.graphics.Rect;
import android.os.Build;
import android.support.v4.view.ViewCompat;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.helper.*;
import android.util.Log;
import android.view.GestureDetector;
import android.view.HapticFeedbackConstants;
import android.view.MotionEvent;
import android.view.VelocityTracker;
import android.view.View;
import android.view.ViewConfiguration;
import android.view.ViewGroup;
import android.view.ViewParent;
import android.view.animation.Interpolator;
import android.voldp.support.recyclerview.RecyclerAdapter;
import cn.bjtime.helper.ItemTouchUIUtilImpl;
import java.util.ArrayList;
import java.util.List;

public class rg_n19577 extends android.support.v7.widget.RecyclerView.ItemDecoration implements android.support.v7.widget.RecyclerView.OnChildAttachStateChangeListener {

    protected int rg_n19581 = 1;
        public static final int SWIPE_ITEM_TYPE = 0x3;
        public static final int SWIPE_ITEM_TYPE_DEFAULT = 0x1;
        public static final int SWIPE_ITEM_TYPE_FLOWING = SWIPE_ITEM_TYPE_DEFAULT << 1;
        public static final int UP = 1;
        public static final int DOWN = 1 << 1;
        public static final int LEFT = 1 << 2;
        public static final int RIGHT = 1 << 3;
        public static final int START = LEFT << 2;
        public static final int END = RIGHT << 2;
        public static final int ACTION_STATE_IDLE = 0;
        public static final int ACTION_STATE_SWIPE = 1;
        public static final int ACTION_STATE_DRAG = 2;
        public static final int ANIMATION_TYPE_SWIPE_SUCCESS = 1 << 1;
        public static final int ANIMATION_TYPE_SWIPE_CANCEL = 1 << 2;
        public static final int ANIMATION_TYPE_DRAG = 1 << 3;
        static final boolean DEBUG = false;
        static final int ACTIVE_POINTER_ID_NONE = -1;
        static final int DIRECTION_FLAG_COUNT = 8;
        private static final int ACTION_MODE_IDLE_MASK = (1 << DIRECTION_FLAG_COUNT) - 1;
        static final int ACTION_MODE_SWIPE_MASK = ACTION_MODE_IDLE_MASK << DIRECTION_FLAG_COUNT;
        static final int ACTION_MODE_DRAG_MASK = ACTION_MODE_SWIPE_MASK << DIRECTION_FLAG_COUNT;
        private static final int PIXELS_PER_SECOND = 1000;
        private final int SWIPE_FLAG_MASK = 0x1;
        final List<View> mPendingCleanup = new ArrayList<View>();
        private final float[] mTmpPosition = new float[2];
        RecyclerView.ViewHolder mSelected = null;
        float mInitialTouchX;
        float mInitialTouchY;
        float mSwipeEscapeVelocity;
        float mMaxSwipeVelocity;
        float mDx;
        float mDy;
        float mSelectedStartX;
        float mSelectedStartY;
        int mActivePointerId = ACTIVE_POINTER_ID_NONE;
        rg_n19577.Callback mCallback;
        int mActionState = ACTION_STATE_IDLE;
        int mSelectedFlags;
        private List<RecoverAnimation> mRecoverAnimations = new ArrayList <RecoverAnimation>();
        private int mSlop;
        RecyclerView mRecyclerView;
        final Runnable mScrollRunnable = new Runnable() {
            @Override
            public void run() {
                if (mSelected != null && scrollIfNecessary()) {
                    if (mSelected != null) {
                        moveIfNecessary(mSelected);
                    }
                    mRecyclerView.removeCallbacks(mScrollRunnable);
                    ViewCompat.postOnAnimation(mRecyclerView, this);
                }
            }
        };
        public void setMenuStyle (int type) {
            rg_n19581 = type;
        }
        public boolean checkSwipeViewBounds (MotionEvent event) {
            View view = getViewOnScreen(mPreOpened);
            if (null == view)
                return false;
            int[] location = new int[2];
            Rect screen = getViewRectForScreen(view, location);
            return screen.contains((int) event.getRawX(), (int) event.getRawY());
        }
        VelocityTracker mVelocityTracker;
        private List<RecyclerView.ViewHolder> mSwapTargets;
        private List<Integer> mDistances;
        private RecyclerView.ChildDrawingOrderCallback mChildDrawingOrderCallback = null;
        View mOverdrawChild = null;
        int mOverdrawChildPosition = -1;
        private boolean mCloseAnimaIsFinish = true;
        private boolean mClick;
        private RecyclerView.ViewHolder mPreOpened = null;
        private View mClickOtherView;
        float mLastX = 0;
        private boolean swipeTypeIsFollowing() {
            return ((rg_n19581 & SWIPE_ITEM_TYPE_FLOWING) != 0);
        }
        private final RecyclerView.OnItemTouchListener mOnItemTouchListener = new RecyclerView.OnItemTouchListener() {
            @Override
            public boolean onInterceptTouchEvent(RecyclerView recyclerView, MotionEvent event) {
                final int action = event.getActionMasked();
                if (action == MotionEvent.ACTION_DOWN) {
                    mClick = true;
                    mLastX = event.getX();
                    mActivePointerId = event.getPointerId(0);
                    mInitialTouchX = event.getX();
                    mInitialTouchY = event.getY();
                    obtainVelocityTracker();
                    if (null != mPreOpened) {
                        boolean swipeViewBounds = checkSwipeViewBounds (event);
                        boolean isMe = false;
                        mClickOtherView = findChildView(event);
                        if (null == mClickOtherView) {
                            isMe = false;
                        } else if (mClickOtherView != mPreOpened.itemView) {
                            isMe = true;
                        }
                        mCloseAnimaIsFinish = false;
                        if (swipeViewBounds || isMe) {
                            mClick = false;
                            recoveryOpenedPreItem(mPreOpened);
                            return true;
                        }
                    }
                } else if (action == MotionEvent.ACTION_CANCEL || action == MotionEvent.ACTION_UP) {
                    if (mClick) {
                        doChildClickEvent(event.getRawX(), event.getRawY());
                    }
                    mActivePointerId = ACTIVE_POINTER_ID_NONE;
                    select(null, ACTION_STATE_IDLE, false);
                } else if (mActivePointerId != ACTIVE_POINTER_ID_NONE && mCloseAnimaIsFinish) {
                    final int index = event.findPointerIndex(mActivePointerId);
                    if (index >= 0) {
                        checkSelectForSwipe(action, event, index);
                    }
                }
                if (mVelocityTracker != null) {
                    mVelocityTracker.addMovement(event);
                }
                return mSelected != null;
            }
            @Override
            public void onTouchEvent(RecyclerView recyclerView, MotionEvent event) {
                if (mVelocityTracker != null) {
                    mVelocityTracker.addMovement(event);
                }
                if (mActivePointerId == ACTIVE_POINTER_ID_NONE || !mCloseAnimaIsFinish) {
                    return;
                }
                final int action = event.getActionMasked();
                final int activePointerIndex = event.findPointerIndex(mActivePointerId);
                if (activePointerIndex >= 0) {
                    checkSelectForSwipe(action, event, activePointerIndex);
                }
                RecyclerView.ViewHolder viewHolder = mSelected;
                if (viewHolder == null) {
                    return;
                }
                switch (action) {
                    case MotionEvent.ACTION_MOVE: {
                        if (activePointerIndex >= 0) {
                            if (Math.abs(event.getX() - mLastX) > mSlop) {
                                mClick = false;
                            }
                            mLastX = event.getX();
                            updateDxDy(event, mSelectedFlags, activePointerIndex);
                            moveIfNecessary(viewHolder);
                            mRecyclerView.removeCallbacks(mScrollRunnable);
                            mScrollRunnable.run();
                            mRecyclerView.invalidate();
                        }
                        break;
                    }
                    case MotionEvent.ACTION_CANCEL:
                        if (mVelocityTracker != null)
                            mVelocityTracker.clear();
                    case MotionEvent.ACTION_UP:
                        if (mClick)
                            doChildClickEvent(event.getRawX(), event.getRawY());
                        boolean needRecovery = false;
                        int swiped = swipeIfNecessary(viewHolder);
                        if (swiped <= 0) {
                            View swipeView = getNeedSwipeLayout(viewHolder);
                            if (null != swipeView) {
                                float swipeWidth = getSwipeWidth(viewHolder) / 2;
                                float translationX = swipeView.getTranslationX();
                                if (Math.abs(translationX) >= swipeWidth) {
                                    needRecovery = true;
                                }
                            }
                        }
                        select(null, ACTION_STATE_IDLE, needRecovery);
                        mActivePointerId = ACTIVE_POINTER_ID_NONE;
                        break;
                    case MotionEvent.ACTION_POINTER_UP: {
                        mClick = false;
                        final int pointerIndex = event.getActionIndex();
                        final int pointerId = event.getPointerId(pointerIndex);
                        if (pointerId == mActivePointerId) {
                            final int newPointerIndex = pointerIndex == 0 ? 1 : 0;
                            mActivePointerId = event.getPointerId(newPointerIndex);
                            updateDxDy(event, mSelectedFlags, pointerIndex);
                        }
                        break;
                    }
                    default:
                        mClick = false;
                        break;
                }
            }
            @Override
            public void onRequestDisallowInterceptTouchEvent(boolean disallowIntercept) {
                if (!disallowIntercept)
                    return;
                select(null, ACTION_STATE_IDLE, false);
            }
        };
        private Rect mTmpRect;
        private long mDragScrollStartTimeInMs;
        public rg_n19577 (rg_n19577.Callback callback) {
            mCallback = callback;
        }
        public Callback getCallback() {
            return mCallback;
        }
        public boolean swipeEnable(){
            return mCallback.isItemViewSwipeEnabled();
        }
        private boolean hitTest(View child, float x, float y, float left, float top, RecyclerView.ViewHolder vh) {
            return x >= left
                    && x <= left + child.getWidth()
                    && y >= top
                    && y <= top + child.getHeight();
        }
        public void attachToRecyclerView( RecyclerView recyclerView) {
            if (mRecyclerView == recyclerView) {
                return;
            }
            if (mRecyclerView != null) {
                destroyCallbacks();
            }
            mRecyclerView = recyclerView;
            if (mRecyclerView != null) {
                final Resources resources = recyclerView.getResources();
                mSwipeEscapeVelocity = resources
                        .getDimension(android.support.v7.recyclerview.R.dimen.item_touch_helper_swipe_escape_velocity);
                mMaxSwipeVelocity = resources
                        .getDimension(android.support.v7.recyclerview.R.dimen.item_touch_helper_swipe_escape_max_velocity);
                setupCallbacks();
                mRecyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {
                    @Override
                    public void onScrollStateChanged(RecyclerView recyclerView, int newState) {
                        super.onScrollStateChanged(recyclerView, newState);
                        if (newState == RecyclerView.SCROLL_STATE_DRAGGING && mPreOpened != null) {
                            recoveryOpenedPreItem(mPreOpened);
                        }
                    }
                });
            }
        }
        private void doChildClickEvent(float x, float y) {
            RecyclerView.ViewHolder viewHolder;
            if (null == mSelected && null == mPreOpened)
                return;
            if (null != mPreOpened)
                viewHolder = mPreOpened;
            else
                viewHolder = mSelected;
            View consumeEventView = viewHolder.itemView;
            if (consumeEventView instanceof ViewGroup) {
                consumeEventView = findConsumeView((ViewGroup) consumeEventView, x, y);
            }
            if (consumeEventView != null) {
                consumeEventView.performClick();
                mClick = false;
                recoveryOpenedPreItem(viewHolder);
            }
        }
        private View findConsumeView(ViewGroup parent, float x, float y) {
            for (int i = 0; i < parent.getChildCount(); i++) {
                View child = parent.getChildAt(i);
                if (child instanceof ViewGroup && child.getVisibility() == View.VISIBLE) {
                    View view = findConsumeView((ViewGroup) child, x, y);
                    if (view != null) {
                        return view;
                    }
                } else if (child.getVisibility() == View.VISIBLE
                        && child.isClickable()
                        && child.isEnabled()) {
                    if (isInBoundsClickable(x, y, child)) {
                        return child;
                    }
                }
            }
            if (isInBoundsClickable(x, y, parent))
                return parent;
            return null;
        }
        private boolean isInBoundsClickable(float x, float y, View child) {
            int[] location = new int[2];
            Rect screen = getViewRectForScreen(child, location);
            if (screen.contains((int) x, (int) y)
                    && child.isClickable()
                    && child.getVisibility() == View.VISIBLE) {
                return true;
            }
            return false;
        }
        private Rect getViewRectForScreen(View view, int[] location) {
            view.getLocationOnScreen(location);
            return new Rect(location[0], location[1], location[0] + view.getWidth(), location[1] + view.getHeight());
        }
        public View getItemFrontView(RecyclerView.ViewHolder viewHolder) {
            if (viewHolder instanceof SwipeLayoutTypeCallBack) {
                SwipeLayoutTypeCallBack callBack = (SwipeLayoutTypeCallBack) viewHolder;
                return callBack.needSwipeLayout();
            }
            return null;
        }
        private void setupCallbacks() {
            ViewConfiguration vc = ViewConfiguration.get(mRecyclerView.getContext());
            mSlop = vc.getScaledTouchSlop();
            mRecyclerView.addItemDecoration(this);
            mRecyclerView.addOnItemTouchListener(mOnItemTouchListener);
            mRecyclerView.addOnChildAttachStateChangeListener(this);
        }
        private void destroyCallbacks() {
            mRecyclerView.removeItemDecoration(this);
            mRecyclerView.removeOnItemTouchListener(mOnItemTouchListener);
            mRecyclerView.removeOnChildAttachStateChangeListener(this);
            final int recoverAnimSize = mRecoverAnimations.size();
            for (int i = recoverAnimSize - 1; i >= 0; i--) {
                final rg_n19577.RecoverAnimation recoverAnimation = mRecoverAnimations.get(0);
                mCallback.clearView(mRecyclerView, recoverAnimation.mViewHolder);
            }
            mRecoverAnimations.clear();
            mOverdrawChild = null;
            mOverdrawChildPosition = -1;
            releaseVelocityTracker();
        }
        private void getSelectedDxDy(float[] outPosition) {
            if ((mSelectedFlags & (LEFT | RIGHT)) != 0) {
                outPosition[0] = mSelectedStartX + mDx - mSelected.itemView.getLeft();
            } else {
                outPosition[0] = mSelected.itemView.getTranslationX();
            }
            if ((mSelectedFlags & (UP | DOWN)) != 0) {
                outPosition[1] = mSelectedStartY + mDy - mSelected.itemView.getTop();
            } else {
                outPosition[1] = mSelected.itemView.getTranslationY();
            }
        }
        @Override
        public void onDrawOver(Canvas c, RecyclerView parent, RecyclerView.State state) {
            float dx = 0, dy = 0;
            if (mSelected != null) {
                getSelectedDxDy(mTmpPosition);
                dx = mTmpPosition[0];
                dy = mTmpPosition[1];
            }
            mCallback.onDrawOver(c, parent, mSelected,
                    mRecoverAnimations, mActionState, dx, dy);
        }
        @Override
        public void onDraw(Canvas c, RecyclerView parent, RecyclerView.State state) {
            mOverdrawChildPosition = -1;
            float dx = 0, dy = 0;
            if (mSelected != null) {
                getSelectedDxDy(mTmpPosition);
                dx = mTmpPosition[0];
                dy = mTmpPosition[1];
            }
            mCallback.onDraw(c, parent, mSelected,
                    mRecoverAnimations, mActionState, dx, dy);
        }
        private static float getSwipeWidth(RecyclerView.ViewHolder viewHolder) {
            if (!(viewHolder instanceof SwipeLayoutTypeCallBack)) {
                return 0;
            }
            return ((SwipeLayoutTypeCallBack) viewHolder).getSwipeWidth();
        }
        private static View getNeedSwipeLayout(RecyclerView.ViewHolder viewHolder) {
            if (!(viewHolder instanceof SwipeLayoutTypeCallBack)) {
                return null;
            }
            return ((SwipeLayoutTypeCallBack) viewHolder).needSwipeLayout();
        }
        private static View getViewOnScreen(RecyclerView.ViewHolder viewHolder) {
            if (!(viewHolder instanceof SwipeLayoutTypeCallBack)) {
                return null;
            }
            return ((SwipeLayoutTypeCallBack) viewHolder).onScreenView();
        }
        private void recoveryOpenedPreItem(RecyclerView.ViewHolder viewHolder) {
            if (viewHolder == null) {
                return;
            }
            final View view = getItemFrontView(viewHolder);
            if (view == null) {
                return;
            }
            float translationX = view.getTranslationX();
            ObjectAnimator objectAnimator = ObjectAnimator.ofFloat(view, "translationX", translationX, 0f);
            objectAnimator.clone();
            objectAnimator.setDuration(mCallback.getRecoveryAnimationDuration());
            objectAnimator.addListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationStart(Animator animation) {
                    super.onAnimationStart(animation);
                    endRecoverAnimation(mPreOpened, true);
                    if (mPendingCleanup.remove(mPreOpened)) {
                        mCallback.clearView(mRecyclerView, mPreOpened);
                    }
                    mPreOpened = null;
                }
                @Override
                public void onAnimationEnd(Animator animation) {
                    super.onAnimationEnd(animation);
                    mCloseAnimaIsFinish = true;
                }
            });
            objectAnimator.start();
        }
        void select(RecyclerView.ViewHolder selected, int actionState, boolean needOpen) {
            if (selected == mSelected && actionState == mActionState) {
                return;
            }
            mDragScrollStartTimeInMs = Long.MIN_VALUE;
            final int prevActionState = mActionState;
            endRecoverAnimation(selected, true);
            mActionState = actionState;
            int actionStateMask = (1 << (DIRECTION_FLAG_COUNT + DIRECTION_FLAG_COUNT * actionState))
                    - 1;
            boolean preventLayout = false;
            if (mSelected != null) {
                final RecyclerView.ViewHolder prevSelected = mSelected;
                if (prevSelected.itemView.getParent() != null) {
                    final int swipeDir;
                    if (needOpen) {
                        swipeDir = 16;
                    } else {
                        swipeDir = prevActionState == ACTION_STATE_DRAG ? 0
                                : swipeIfNecessary(prevSelected);
                    }
                    releaseVelocityTracker();
                    final float targetTranslateX, targetTranslateY;
                    final int animationType;
                    switch (swipeDir) {
                        case LEFT:
                        case RIGHT:
                        case START:
                        case END:
                            targetTranslateY = 0;
                            float swipeWidth = mRecyclerView.getWidth();
                            if (swipeTypeIsFollowing()) {
                                swipeWidth += getSwipeWidth(mSelected);
                            }
                            targetTranslateX = Math.signum(mDx) * swipeWidth;
                            break;
                        case UP:
                        case DOWN:
                            targetTranslateX = 0;
                            targetTranslateY = Math.signum(mDy) * mRecyclerView.getHeight();
                            break;
                        default:
                            targetTranslateX = 0;
                            targetTranslateY = 0;
                    }
                    if (prevActionState == ACTION_STATE_DRAG) {
                        animationType = ANIMATION_TYPE_DRAG;
                    } else if (swipeDir > 0) {
                        animationType = ANIMATION_TYPE_SWIPE_SUCCESS;
                    } else {
                        animationType = ANIMATION_TYPE_SWIPE_CANCEL;
                    }
                    getSelectedDxDy(mTmpPosition);
                    final float currentTranslateX = mTmpPosition[0];
                    final float currentTranslateY = mTmpPosition[1];
                    final rg_n19577.RecoverAnimation rv = new rg_n19577.RecoverAnimation(prevSelected, animationType,
                            prevActionState, currentTranslateX, currentTranslateY,
                            targetTranslateX, targetTranslateY) {
                        @Override
                        public void onAnimationEnd(Animator animation) {
                            super.onAnimationEnd(animation);
                            if (this.mOverridden) {
                                return;
                            }
                            if (swipeDir <= 0) {
                                mPreOpened = null;
                                mCallback.clearView(mRecyclerView, prevSelected);
                            } else {
                                mPreOpened = prevSelected;
                                mPendingCleanup.add(prevSelected.itemView);
                                mIsPendingCleanup = true;
                                if (swipeDir > 0) {
                                    postDispatchSwipe(this, swipeDir);
                                }
                            }
                            if (mOverdrawChild == prevSelected.itemView) {
                                removeChildDrawingOrderCallbackIfNecessary(prevSelected.itemView);
                            }
                        }
                        @Override
                        public void onAnimationStart(Animator animation) {
                            super.onAnimationStart(animation);
                        }
                    };
                    final long duration = mCallback.getAnimationDuration(mRecyclerView, animationType,
                            targetTranslateX - currentTranslateX, targetTranslateY - currentTranslateY);
                    rv.setDuration(duration);
                    mRecoverAnimations.add(rv);
                    rv.start();
                    preventLayout = true;
                } else {
                    removeChildDrawingOrderCallbackIfNecessary(prevSelected.itemView);
                    mCallback.clearView(mRecyclerView, prevSelected);
                }
                mSelected = null;
            }
            if (selected != null) {
                mSelectedFlags =
                        (mCallback.getAbsoluteMovementFlags(mRecyclerView, selected) & actionStateMask)
                                >> (mActionState * DIRECTION_FLAG_COUNT);
                mSelectedStartX = selected.itemView.getLeft();
                mSelectedStartY = selected.itemView.getTop();
                mSelected = selected;
                if (actionState == ACTION_STATE_DRAG) {
                    mSelected.itemView.performHapticFeedback(HapticFeedbackConstants.LONG_PRESS);
                }
            }
            final ViewParent rvParent = mRecyclerView.getParent();
            if (rvParent != null) {
                rvParent.requestDisallowInterceptTouchEvent(mSelected != null);
            }
            if (!preventLayout) {
                mRecyclerView.getLayoutManager().requestSimpleAnimationsInNextLayout();
            }
            mCallback.onSelectedChanged(mSelected, mActionState);
            mRecyclerView.invalidate();
        }
        void postDispatchSwipe(final rg_n19577.RecoverAnimation anim, final int swipeDir) {
            mRecyclerView.post(new Runnable() {
                @Override
                public void run() {
                    if (mRecyclerView != null && mRecyclerView.isAttachedToWindow()
                            && !anim.mOverridden
                            && anim.mViewHolder.getAdapterPosition() != RecyclerView.NO_POSITION) {
                        final RecyclerView.ItemAnimator animator = mRecyclerView.getItemAnimator();
                        if ((animator == null || !animator.isRunning(null))
                                && !hasRunningRecoverAnim()) {
                            mCallback.onSwiped(anim.mViewHolder, swipeDir);
                        } else {
                            mRecyclerView.post(this);
                        }
                    }
                }
            });
        }
        boolean hasRunningRecoverAnim() {
            final int size = mRecoverAnimations.size();
            for (int i = 0; i < size; i++) {
                if (!mRecoverAnimations.get(i).mEnded) {
                    return true;
                }
            }
            return false;
        }
        boolean scrollIfNecessary() {
            if (mSelected == null) {
                mDragScrollStartTimeInMs = Long.MIN_VALUE;
                return false;
            }
            final long now = System.currentTimeMillis();
            final long scrollDuration = mDragScrollStartTimeInMs
                    == Long.MIN_VALUE ? 0 : now - mDragScrollStartTimeInMs;
            RecyclerView.LayoutManager lm = mRecyclerView.getLayoutManager();
            if (mTmpRect == null) {
                mTmpRect = new Rect();
            }
            int scrollX = 0;
            int scrollY = 0;
            lm.calculateItemDecorationsForChild(mSelected.itemView, mTmpRect);
            if (lm.canScrollHorizontally()) {
                int curX = (int) (mSelectedStartX + mDx);
                final int leftDiff = curX - mTmpRect.left - mRecyclerView.getPaddingLeft();
                if (mDx < 0 && leftDiff < 0) {
                    scrollX = leftDiff;
                } else if (mDx > 0) {
                    final int rightDiff =
                            curX + mSelected.itemView.getWidth() + mTmpRect.right
                                    - (mRecyclerView.getWidth() - mRecyclerView.getPaddingRight());
                    if (rightDiff > 0) {
                        scrollX = rightDiff;
                    }
                }
            }
            if (lm.canScrollVertically()) {
                int curY = (int) (mSelectedStartY + mDy);
                final int topDiff = curY - mTmpRect.top - mRecyclerView.getPaddingTop();
                if (mDy < 0 && topDiff < 0) {
                    scrollY = topDiff;
                } else if (mDy > 0) {
                    final int bottomDiff = curY + mSelected.itemView.getHeight() + mTmpRect.bottom
                            - (mRecyclerView.getHeight() - mRecyclerView.getPaddingBottom());
                    if (bottomDiff > 0) {
                        scrollY = bottomDiff;
                    }
                }
            }
            if (scrollX != 0) {
                scrollX = mCallback.interpolateOutOfBoundsScroll(mRecyclerView,
                        mSelected.itemView.getWidth(), scrollX,
                        mRecyclerView.getWidth(), scrollDuration);
            }
            if (scrollY != 0) {
                scrollY = mCallback.interpolateOutOfBoundsScroll(mRecyclerView,
                        mSelected.itemView.getHeight(), scrollY,
                        mRecyclerView.getHeight(), scrollDuration);
            }
            if (scrollX != 0 || scrollY != 0) {
                if (mDragScrollStartTimeInMs == Long.MIN_VALUE) {
                    mDragScrollStartTimeInMs = now;
                }
                mRecyclerView.scrollBy(scrollX, scrollY);
                return true;
            }
            mDragScrollStartTimeInMs = Long.MIN_VALUE;
            return false;
        }
        private List<RecyclerView.ViewHolder> findSwapTargets(RecyclerView.ViewHolder viewHolder) {
            if (mSwapTargets == null) {
                mSwapTargets = new ArrayList<RecyclerView.ViewHolder>();
                mDistances = new ArrayList<Integer>();
            } else {
                mSwapTargets.clear();
                mDistances.clear();
            }
            final int margin = mCallback.getBoundingBoxMargin();
            final int left = Math.round(mSelectedStartX + mDx) - margin;
            final int top = Math.round(mSelectedStartY + mDy) - margin;
            final int right = left + viewHolder.itemView.getWidth() + 2 * margin;
            final int bottom = top + viewHolder.itemView.getHeight() + 2 * margin;
            final int centerX = (left + right) / 2;
            final int centerY = (top + bottom) / 2;
            final RecyclerView.LayoutManager lm = mRecyclerView.getLayoutManager();
            final int childCount = lm.getChildCount();
            for (int i = 0; i < childCount; i++) {
                View other = lm.getChildAt(i);
                if (other == viewHolder.itemView) {
                    continue;
                }
                if (other.getBottom() < top || other.getTop() > bottom
                        || other.getRight() < left || other.getLeft() > right) {
                    continue;
                }
                final RecyclerView.ViewHolder otherVh = mRecyclerView.getChildViewHolder(other);
                if (mCallback.canDropOver(mRecyclerView, mSelected, otherVh)) {
                    final int dx = Math.abs(centerX - (other.getLeft() + other.getRight()) / 2);
                    final int dy = Math.abs(centerY - (other.getTop() + other.getBottom()) / 2);
                    final int dist = dx * dx + dy * dy;
                    int pos = 0;
                    final int cnt = mSwapTargets.size();
                    for (int j = 0; j < cnt; j++) {
                        if (dist > mDistances.get(j)) {
                            pos++;
                        } else {
                            break;
                        }
                    }
                    mSwapTargets.add(pos, otherVh);
                    mDistances.add(pos, dist);
                }
            }
            return mSwapTargets;
        }
        void moveIfNecessary(RecyclerView.ViewHolder viewHolder) {
            if (mRecyclerView.isLayoutRequested())
                return;
            if (mActionState != ACTION_STATE_DRAG)
                return;
            final float threshold = mCallback.getMoveThreshold(viewHolder);
            final int x = (int) (mSelectedStartX + mDx);
            final int y = (int) (mSelectedStartY + mDy);
            if (Math.abs(y - viewHolder.itemView.getTop()) < viewHolder.itemView.getHeight() * threshold
                    && Math.abs(x - viewHolder.itemView.getLeft())
                    < viewHolder.itemView.getWidth() * threshold) {
                return;
            }
            List<RecyclerView.ViewHolder> swapTargets = findSwapTargets(viewHolder);
            if (swapTargets.size() == 0) {
                return;
            }
            RecyclerView.ViewHolder target = mCallback.chooseDropTarget(viewHolder, swapTargets, x, y);
            if (target == null) {
                mSwapTargets.clear();
                mDistances.clear();
                return;
            }
            final int toPosition = target.getAdapterPosition();
            final int fromPosition = viewHolder.getAdapterPosition();
            if (mCallback.onMove(mRecyclerView, viewHolder, target)) {
                mCallback.onMoved(mRecyclerView, viewHolder, fromPosition,
                        target, toPosition, x, y);
            }
        }
        @Override
        public void onChildViewAttachedToWindow(View view) {  }
        @Override
        public void onChildViewDetachedFromWindow(View view) {
            removeChildDrawingOrderCallbackIfNecessary(view);
            final RecyclerView.ViewHolder holder = mRecyclerView.getChildViewHolder(view);
            if (holder == null) {
                return;
            }
            if (mSelected != null && holder == mSelected) {
                select(null, ACTION_STATE_IDLE, false);
            } else {
                endRecoverAnimation(holder, false);
                if (mPendingCleanup.remove(holder.itemView)) {
                    mCallback.clearView(mRecyclerView, holder);
                }
            }
        }
        int endRecoverAnimation(RecyclerView.ViewHolder viewHolder, boolean override) {
            final int recoverAnimSize = mRecoverAnimations.size();
            for (int i = recoverAnimSize - 1; i >= 0; i--) {
                final rg_n19577.RecoverAnimation anim = mRecoverAnimations.get(i);
                if (anim.mViewHolder == viewHolder) {
                    anim.mOverridden |= override;
                    if (!anim.mEnded) {
                        anim.cancel();
                    }
                    mRecoverAnimations.remove(i);
                    return anim.mAnimationType;
                }
            }
            return 0;
        }
        @Override
        public void getItemOffsets(Rect outRect, View view, RecyclerView parent, RecyclerView.State state) {
            outRect.setEmpty();
        }
        void obtainVelocityTracker() {
            if (mVelocityTracker != null) {
                mVelocityTracker.recycle();
            }
            mVelocityTracker = VelocityTracker.obtain();
        }
        private void releaseVelocityTracker() {
            if (mVelocityTracker != null) {
                mVelocityTracker.recycle();
                mVelocityTracker = null;
            }
        }
        private RecyclerView.ViewHolder findSwipedView(MotionEvent motionEvent) {
            final RecyclerView.LayoutManager lm = mRecyclerView.getLayoutManager();
            if (mActivePointerId == ACTIVE_POINTER_ID_NONE) {
                return null;
            }
            final int pointerIndex = motionEvent.findPointerIndex(mActivePointerId);
            final float dx = motionEvent.getX(pointerIndex) - mInitialTouchX;
            final float dy = motionEvent.getY(pointerIndex) - mInitialTouchY;
            final float absDx = Math.abs(dx);
            final float absDy = Math.abs(dy);
            if (absDx < mSlop && absDy < mSlop) {
                return null;
            }
            if (absDx > absDy && lm.canScrollHorizontally()) {
                return null;
            } else if (absDy > absDx && lm.canScrollVertically()) {
                return null;
            }
            View child = findChildView(motionEvent);
            if (child == null) {
                return null;
            }
            return mRecyclerView.getChildViewHolder(child);
        }
        boolean checkSelectForSwipe(int action, MotionEvent motionEvent, int pointerIndex) {
            if (mSelected != null || action != MotionEvent.ACTION_MOVE || mActionState == ACTION_STATE_DRAG || !mCallback.isItemViewSwipeEnabled()) {
                return false;
            }
            if (mRecyclerView.getScrollState() == RecyclerView.SCROLL_STATE_DRAGGING) {
                return false;
            }
            final RecyclerView.ViewHolder vh = findSwipedView(motionEvent);
            if (vh == null) {
                return false;
            }
            final int movementFlags = mCallback.getAbsoluteMovementFlags(mRecyclerView, vh);
            final int swipeFlags = (movementFlags & ACTION_MODE_SWIPE_MASK) >> (DIRECTION_FLAG_COUNT * ACTION_STATE_SWIPE);
            if (swipeFlags == 0)
                return false;
            final float x = motionEvent.getX(pointerIndex);
            final float y = motionEvent.getY(pointerIndex);
            final float dx = x - mInitialTouchX;
            final float dy = y - mInitialTouchY;
            final float absDx = Math.abs(dx);
            final float absDy = Math.abs(dy);
            if (absDx < mSlop && absDy < mSlop) {
                return false;
            }
            if (absDx > absDy) {
                if (dx < 0 && (swipeFlags & LEFT) == 0) {
                    return false;
                }
                if (dx > 0 && (swipeFlags & RIGHT) == 0) {
                    return false;
                }
            } else {
                if (dy < 0 && (swipeFlags & UP) == 0) {
                    return false;
                }
                if (dy > 0 && (swipeFlags & DOWN) == 0) {
                    return false;
                }
            }
            mDx = mDy = 0f;
            mActivePointerId = motionEvent.getPointerId(0);
            select(vh, ACTION_STATE_SWIPE, false);
            return true;
        }
        View findChildView(MotionEvent event) {
            final float x = event.getX();
            final float y = event.getY();
            if (mSelected != null) {
                final View selectedView = mSelected.itemView;
                if (hitTest(selectedView, x, y, mSelectedStartX + mDx, mSelectedStartY + mDy, mSelected)) {
                    return selectedView;
                }
            }
            for (int i = mRecoverAnimations.size() - 1; i >= 0; i--) {
                final rg_n19577.RecoverAnimation anim = mRecoverAnimations.get(i);
                final View view = anim.mViewHolder.itemView;
                boolean hitTest = hitTest(view, x, y, anim.mX, anim.mY, anim.mViewHolder);
                if (hitTest) {
                    return view;
                }
            }
            View childViewUnder = mRecyclerView.findChildViewUnder(x, y);
            return childViewUnder;
        }
        public void startDrag(RecyclerView.ViewHolder viewHolder) {
            if (!mCallback.hasDragFlag(mRecyclerView, viewHolder)) {
                return;
            }
            if (viewHolder.itemView.getParent() != mRecyclerView) {
                return;
            }
            obtainVelocityTracker();
            mDx = mDy = 0f;
            select(viewHolder, ACTION_STATE_DRAG, false);
        }
        public void startSwipe(RecyclerView.ViewHolder viewHolder) {
            if (!mCallback.hasSwipeFlag(mRecyclerView, viewHolder)) {
                return;
            }
            if (viewHolder.itemView.getParent() != mRecyclerView) {
                return;
            }
            obtainVelocityTracker();
            mDx = mDy = 0f;
            select(viewHolder, ACTION_STATE_SWIPE, false);
        }
        void updateDxDy(MotionEvent ev, int directionFlags, int pointerIndex) {
            final float x = ev.getX(pointerIndex);
            final float y = ev.getY(pointerIndex);
            mDx = x - mInitialTouchX;
            mDy = y - mInitialTouchY;
            if ((directionFlags & LEFT) == 0) {
                mDx = Math.max(0, mDx);
            }
            if ((directionFlags & RIGHT) == 0) {
                mDx = Math.min(0, mDx);
            }
            if ((directionFlags & UP) == 0) {
                mDy = Math.max(0, mDy);
            }
            if ((directionFlags & DOWN) == 0) {
                mDy = Math.min(0, mDy);
            }
        }
        private int swipeIfNecessary(RecyclerView.ViewHolder viewHolder) {
            if (mActionState == ACTION_STATE_DRAG) {
                return 0;
            }
            final int originalMovementFlags = mCallback.getMovementFlags(mRecyclerView, viewHolder);
            final int absoluteMovementFlags = mCallback.convertToAbsoluteDirection(
                    originalMovementFlags,
                    ViewCompat.getLayoutDirection(mRecyclerView));
            final int flags = (absoluteMovementFlags
                    & ACTION_MODE_SWIPE_MASK) >> (ACTION_STATE_SWIPE * DIRECTION_FLAG_COUNT);
            if (flags == 0) {
                return 0;
            }
            final int originalFlags = (originalMovementFlags
                    & ACTION_MODE_SWIPE_MASK) >> (ACTION_STATE_SWIPE * DIRECTION_FLAG_COUNT);
            int swipeDir;
            if (Math.abs(mDx) > Math.abs(mDy)) {
                if ((swipeDir = checkHorizontalSwipe(viewHolder, flags)) > 0) {
                    if ((originalFlags & swipeDir) == 0) {
                        return rg_n19577.Callback.convertToRelativeDirection(swipeDir,
                                ViewCompat.getLayoutDirection(mRecyclerView));
                    }
                    return swipeDir;
                }
                if ((swipeDir = checkVerticalSwipe(viewHolder, flags)) > 0) {
                    return swipeDir;
                }
            } else {
                if ((swipeDir = checkVerticalSwipe(viewHolder, flags)) > 0) {
                    return swipeDir;
                }
                if ((swipeDir = checkHorizontalSwipe(viewHolder, flags)) > 0) {
                    if ((originalFlags & swipeDir) == 0) {
                        return rg_n19577.Callback.convertToRelativeDirection(swipeDir,
                                ViewCompat.getLayoutDirection(mRecyclerView));
                    }
                    return swipeDir;
                }
            }
            return 0;
        }
        private int checkHorizontalSwipe(RecyclerView.ViewHolder viewHolder, int flags) {
            if ((flags & (LEFT | RIGHT)) != 0) {
                final int dirFlag = mDx > 0 ? RIGHT : LEFT;
                if (mVelocityTracker != null && mActivePointerId > -1) {
                    mVelocityTracker.computeCurrentVelocity(PIXELS_PER_SECOND,
                            mCallback.getSwipeVelocityThreshold(mMaxSwipeVelocity));
                    final float xVelocity = mVelocityTracker.getXVelocity(mActivePointerId);
                    final float yVelocity = mVelocityTracker.getYVelocity(mActivePointerId);
                    final int velDirFlag = xVelocity > 0f ? RIGHT : LEFT;
                    final float absXVelocity = Math.abs(xVelocity);
                    if ((velDirFlag & flags) != 0 && dirFlag == velDirFlag
                            && absXVelocity >= mCallback.getSwipeEscapeVelocity(mSwipeEscapeVelocity)
                            && absXVelocity > Math.abs(yVelocity)) {
                        return velDirFlag;
                    }
                }
                int width = mRecyclerView.getWidth();
                if (swipeTypeIsFollowing()) {
                    float swipeWidth = getSwipeWidth(viewHolder);
                    width += (int) swipeWidth;
                }
                final float threshold = width * mCallback
                        .getSwipeThreshold(viewHolder);
                if ((flags & dirFlag) != 0 && Math.abs(mDx) > threshold) {
                    return dirFlag;
                }
            }
            return 0;
        }
        private int checkVerticalSwipe(RecyclerView.ViewHolder viewHolder, int flags) {
            if ((flags & (UP | DOWN)) != 0) {
                final int dirFlag = mDy > 0 ? DOWN : UP;
                if (mVelocityTracker != null && mActivePointerId > -1) {
                    mVelocityTracker.computeCurrentVelocity(PIXELS_PER_SECOND,
                            mCallback.getSwipeVelocityThreshold(mMaxSwipeVelocity));
                    final float xVelocity = mVelocityTracker.getXVelocity(mActivePointerId);
                    final float yVelocity = mVelocityTracker.getYVelocity(mActivePointerId);
                    final int velDirFlag = yVelocity > 0f ? DOWN : UP;
                    final float absYVelocity = Math.abs(yVelocity);
                    if ((velDirFlag & flags) != 0 && velDirFlag == dirFlag
                            && absYVelocity >= mCallback.getSwipeEscapeVelocity(mSwipeEscapeVelocity)
                            && absYVelocity > Math.abs(xVelocity)) {
                        return velDirFlag;
                    }
                }
                final float threshold = mRecyclerView.getHeight() * mCallback
                        .getSwipeThreshold(viewHolder);
                if ((flags & dirFlag) != 0 && Math.abs(mDy) > threshold) {
                    return dirFlag;
                }
            }
            return 0;
        }
        void removeChildDrawingOrderCallbackIfNecessary(View view) {
            if (view == mOverdrawChild) {
                mOverdrawChild = null;
                if (mChildDrawingOrderCallback != null) {
                    mRecyclerView.setChildDrawingOrderCallback(null);
                }
            }
        }
        public interface SwipeLayoutTypeCallBack {
            float getSwipeWidth();
            View needSwipeLayout();
            View onScreenView();
        }
        public interface ViewDropHandler {
            void prepareForDrop(View view, View target, int x, int y);
        }
        public abstract static class Callback {
            public static final int DEFAULT_DRAG_ANIMATION_DURATION = 200;
            public static final int DEFAULT_SWIPE_ANIMATION_DURATION = 250;
            static final int RELATIVE_DIR_FLAGS = START | END
                    | ((START | END) << DIRECTION_FLAG_COUNT)
                    | ((START | END) << (2 * DIRECTION_FLAG_COUNT));
            private static final ItemTouchUIUtil sUICallback;
            private static final int ABS_HORIZONTAL_DIR_FLAGS = LEFT | RIGHT
                    | ((LEFT | RIGHT) << DIRECTION_FLAG_COUNT)
                    | ((LEFT | RIGHT) << (2 * DIRECTION_FLAG_COUNT));
            private static final Interpolator sDragScrollInterpolator = new Interpolator() {
                @Override
                public float getInterpolation(float t) {
                    return t * t * t * t * t;
                }
            };
            private static final Interpolator sDragViewScrollCapInterpolator = new Interpolator() {
                @Override
                public float getInterpolation(float t) {
                    t -= 1.0f;
                    return t * t * t * t * t + 1.0f;
                }
            };
            private static final long DRAG_SCROLL_ACCELERATION_LIMIT_TIME_MS = 2000;
            private int mCachedMaxScrollSpeed = -1;
            static {
                if (Build.VERSION.SDK_INT >= 21) {
                    sUICallback = new ItemTouchUIUtilImpl.Lollipop();
                } else {
                    sUICallback = new ItemTouchUIUtilImpl.Honeycomb();
                }
            }
            public static ItemTouchUIUtil getDefaultUIUtil() {
                return sUICallback;
            }
            public static int convertToRelativeDirection(int flags, int layoutDirection) {
                int masked = flags & ABS_HORIZONTAL_DIR_FLAGS;
                if (masked == 0) {
                    return flags;
                }
                flags &= ~masked;
                if (layoutDirection == ViewCompat.LAYOUT_DIRECTION_LTR) {
                    flags |= masked << 2;
                    return flags;
                } else {
                    flags |= ((masked << 1) & ~ABS_HORIZONTAL_DIR_FLAGS);
                    flags |= ((masked << 1) & ABS_HORIZONTAL_DIR_FLAGS) << 2;
                }
                return flags;
            }
            public static int makeMovementFlags(int dragFlags, int swipeFlags) {
                return makeFlag(ACTION_STATE_IDLE, swipeFlags | dragFlags)
                        | makeFlag(ACTION_STATE_SWIPE, swipeFlags)
                        | makeFlag(ACTION_STATE_DRAG, dragFlags);
            }
            public static int makeFlag(int actionState, int directions) {
                return directions << (actionState * DIRECTION_FLAG_COUNT);
            }
            public abstract int getMovementFlags(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder);
            public int convertToAbsoluteDirection(int flags, int layoutDirection) {
                int masked = flags & RELATIVE_DIR_FLAGS;
                if (masked == 0) {
                    return flags;
                }
                flags &= ~masked;
                if (layoutDirection == ViewCompat.LAYOUT_DIRECTION_LTR) {
                    flags |= masked >> 2;
                    return flags;
                } else {
                    flags |= ((masked >> 1) & ~RELATIVE_DIR_FLAGS);
                    flags |= ((masked >> 1) & RELATIVE_DIR_FLAGS) >> 2;
                }
                return flags;
            }
            final int getAbsoluteMovementFlags(RecyclerView recyclerView,
                                               RecyclerView.ViewHolder viewHolder) {
                final int flags = getMovementFlags(recyclerView, viewHolder);
                return convertToAbsoluteDirection(flags, ViewCompat.getLayoutDirection(recyclerView));
            }
            boolean hasDragFlag(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder) {
                final int flags = getAbsoluteMovementFlags(recyclerView, viewHolder);
                return (flags & ACTION_MODE_DRAG_MASK) != 0;
            }
            boolean hasSwipeFlag(RecyclerView recyclerView,
                                 RecyclerView.ViewHolder viewHolder) {
                final int flags = getAbsoluteMovementFlags(recyclerView, viewHolder);
                return (flags & ACTION_MODE_SWIPE_MASK) != 0;
            }
            public boolean canDropOver(RecyclerView recyclerView, RecyclerView.ViewHolder current,
                                       RecyclerView.ViewHolder target) {
                return true;
            }
            public abstract boolean onMove(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder, RecyclerView.ViewHolder target);
            public boolean isLongPressDragEnabled() {
                return true;
            }
            public boolean isItemViewSwipeEnabled() {
                return true;
            }
            public int getBoundingBoxMargin() {
                return 0;
            }
            public float getSwipeThreshold(RecyclerView.ViewHolder viewHolder) {
                return .5f;
            }
            public float getMoveThreshold(RecyclerView.ViewHolder viewHolder) {
                return .5f;
            }
            public float getSwipeEscapeVelocity(float defaultValue) {
                return defaultValue;
            }
            public float getSwipeVelocityThreshold(float defaultValue) {
                return defaultValue;
            }
            public RecyclerView.ViewHolder chooseDropTarget(RecyclerView.ViewHolder selected,
                                                            List<RecyclerView.ViewHolder> dropTargets, int curX, int curY) {
                int right = curX + selected.itemView.getWidth();
                int bottom = curY + selected.itemView.getHeight();
                RecyclerView.ViewHolder winner = null;
                int winnerScore = -1;
                final int dx = curX - selected.itemView.getLeft();
                final int dy = curY - selected.itemView.getTop();
                final int targetsSize = dropTargets.size();
                for (int i = 0; i < targetsSize; i++) {
                    final RecyclerView.ViewHolder target = dropTargets.get(i);
                    if (dx > 0) {
                        int diff = target.itemView.getRight() - right;
                        if (diff < 0 && target.itemView.getRight() > selected.itemView.getRight()) {
                            final int score = Math.abs(diff);
                            if (score > winnerScore) {
                                winnerScore = score;
                                winner = target;
                            }
                        }
                    }
                    if (dx < 0) {
                        int diff = target.itemView.getLeft() - curX;
                        if (diff > 0 && target.itemView.getLeft() < selected.itemView.getLeft()) {
                            final int score = Math.abs(diff);
                            if (score > winnerScore) {
                                winnerScore = score;
                                winner = target;
                            }
                        }
                    }
                    if (dy < 0) {
                        int diff = target.itemView.getTop() - curY;
                        if (diff > 0 && target.itemView.getTop() < selected.itemView.getTop()) {
                            final int score = Math.abs(diff);
                            if (score > winnerScore) {
                                winnerScore = score;
                                winner = target;
                            }
                        }
                    }
                    if (dy > 0) {
                        int diff = target.itemView.getBottom() - bottom;
                        if (diff < 0 && target.itemView.getBottom() > selected.itemView.getBottom()) {
                            final int score = Math.abs(diff);
                            if (score > winnerScore) {
                                winnerScore = score;
                                winner = target;
                            }
                        }
                    }
                }
                return winner;
            }
            public abstract void onSwiped(RecyclerView.ViewHolder viewHolder, int direction);
            public void onSelectedChanged(RecyclerView.ViewHolder viewHolder, int actionState) {
                if (viewHolder != null) {
                    sUICallback.onSelected(viewHolder.itemView);
                }
            }
            private int getMaxDragScroll(RecyclerView recyclerView) {
                if (mCachedMaxScrollSpeed == -1) {
                    mCachedMaxScrollSpeed = recyclerView.getResources().getDimensionPixelSize(
                            android.support.v7.recyclerview.R.dimen.item_touch_helper_max_drag_scroll_per_frame);
                }
                return mCachedMaxScrollSpeed;
            }
            public void onMoved(final RecyclerView recyclerView,
                                final RecyclerView.ViewHolder viewHolder, int fromPos, final RecyclerView.ViewHolder target, int toPos, int x,
                                int y) {
                final RecyclerView.LayoutManager layoutManager = recyclerView.getLayoutManager();
                if (layoutManager instanceof rg_n19577.ViewDropHandler) {
                    ((rg_n19577.ViewDropHandler) layoutManager).prepareForDrop(viewHolder.itemView,
                            target.itemView, x, y);
                    return;
                }
                if (layoutManager.canScrollHorizontally()) {
                    final int minLeft = layoutManager.getDecoratedLeft(target.itemView);
                    if (minLeft <= recyclerView.getPaddingLeft()) {
                        recyclerView.scrollToPosition(toPos);
                    }
                    final int maxRight = layoutManager.getDecoratedRight(target.itemView);
                    if (maxRight >= recyclerView.getWidth() - recyclerView.getPaddingRight()) {
                        recyclerView.scrollToPosition(toPos);
                    }
                }
                if (layoutManager.canScrollVertically()) {
                    final int minTop = layoutManager.getDecoratedTop(target.itemView);
                    if (minTop <= recyclerView.getPaddingTop()) {
                        recyclerView.scrollToPosition(toPos);
                    }
                    final int maxBottom = layoutManager.getDecoratedBottom(target.itemView);
                    if (maxBottom >= recyclerView.getHeight() - recyclerView.getPaddingBottom()) {
                        recyclerView.scrollToPosition(toPos);
                    }
                }
            }
            void onDraw(Canvas c, RecyclerView parent, RecyclerView.ViewHolder selected,
                        List<RecoverAnimation> recoverAnimationList,
                        int actionState, float dX, float dY) {
                final int recoverAnimSize = recoverAnimationList.size();
                for (int i = 0; i < recoverAnimSize; i++) {
                    final rg_n19577.RecoverAnimation anim = recoverAnimationList.get(i);
                    anim.update();
                    final int count = c.save();
                    float swipeWidth = getSwipeWidth(anim.mViewHolder);
                    View swipeView = getNeedSwipeLayout(anim.mViewHolder);
                    onChildDraw(c, parent, anim.mViewHolder, swipeView, anim.mX, anim.mY, anim.mActionState,
                            false, swipeWidth);
                    c.restoreToCount(count);
                }
                if (selected != null) {
                    final int count = c.save();
                    float swipeWidth = getSwipeWidth(selected);
                    View swipeView = getNeedSwipeLayout(selected);
                    onChildDraw(c, parent, selected, swipeView, dX, dY, actionState, true, swipeWidth);
                    c.restoreToCount(count);
                }
            }
            void onDrawOver(Canvas c, RecyclerView parent, RecyclerView.ViewHolder selected,
                            List<RecoverAnimation> recoverAnimationList,
                            int actionState, float dX, float dY) {
                final int recoverAnimSize = recoverAnimationList.size();
                for (int i = 0; i < recoverAnimSize; i++) {
                    final rg_n19577.RecoverAnimation anim = recoverAnimationList.get(i);
                    final int count = c.save();
                    onChildDrawOver(c, parent, anim.mViewHolder, anim.mX, anim.mY, anim.mActionState,
                            false);
                    c.restoreToCount(count);
                }
                if (selected != null) {
                    final int count = c.save();
                    onChildDrawOver(c, parent, selected, dX, dY, actionState, true);
                    c.restoreToCount(count);
                }
                boolean hasRunningAnimation = false;
                for (int i = recoverAnimSize - 1; i >= 0; i--) {
                    final rg_n19577.RecoverAnimation anim = recoverAnimationList.get(i);
                    if (anim.mEnded && !anim.mIsPendingCleanup) {
                        recoverAnimationList.remove(i);
                    } else if (!anim.mEnded) {
                        hasRunningAnimation = true;
                    }
                }
                if (hasRunningAnimation) {
                    parent.invalidate();
                }
            }
            public void clearView(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder) {
                sUICallback.clearView(viewHolder.itemView);
            }
            public void onChildDraw(Canvas c, RecyclerView recyclerView,
                                    RecyclerView.ViewHolder viewHolder, View swipeView,
                                    float dX, float dY, int actionState, boolean isCurrentlyActive, float swipeWidth) {
                sUICallback.onDraw(c, recyclerView, viewHolder.itemView, dX, dY, actionState,
                        isCurrentlyActive);
            }
            public void onChildDrawOver(Canvas c, RecyclerView recyclerView,
                                        RecyclerView.ViewHolder viewHolder,
                                        float dX, float dY, int actionState, boolean isCurrentlyActive) {
                sUICallback.onDrawOver(c, recyclerView, viewHolder.itemView, dX, dY, actionState,
                        isCurrentlyActive);
            }
            public long getAnimationDuration(RecyclerView recyclerView, int animationType,
                                             float animateDx, float animateDy) {
                final RecyclerView.ItemAnimator itemAnimator = recyclerView.getItemAnimator();
                if (itemAnimator == null) {
                    return animationType == ANIMATION_TYPE_DRAG ? DEFAULT_DRAG_ANIMATION_DURATION
                            : DEFAULT_SWIPE_ANIMATION_DURATION;
                } else {
                    return animationType == ANIMATION_TYPE_DRAG ? itemAnimator.getMoveDuration()
                            : itemAnimator.getRemoveDuration();
                }
            }
            public long getRecoveryAnimationDuration() {
                return 250;
            }
            public int interpolateOutOfBoundsScroll(RecyclerView recyclerView,
                                                    int viewSize, int viewSizeOutOfBounds,
                                                    int totalSize, long msSinceStartScroll) {
                final int maxScroll = getMaxDragScroll(recyclerView);
                final int absOutOfBounds = Math.abs(viewSizeOutOfBounds);
                final int direction = (int) Math.signum(viewSizeOutOfBounds);
                float outOfBoundsRatio = Math.min(1f, 1f * absOutOfBounds / viewSize);
                final int cappedScroll = (int) (direction * maxScroll
                        * sDragViewScrollCapInterpolator.getInterpolation(outOfBoundsRatio));
                final float timeRatio;
                if (msSinceStartScroll > DRAG_SCROLL_ACCELERATION_LIMIT_TIME_MS) {
                    timeRatio = 1f;
                } else {
                    timeRatio = (float) msSinceStartScroll / DRAG_SCROLL_ACCELERATION_LIMIT_TIME_MS;
                }
                final int value = (int) (cappedScroll * sDragScrollInterpolator
                        .getInterpolation(timeRatio));
                if (value == 0) {
                    return viewSizeOutOfBounds > 0 ? 1 : -1;
                }
                return value;
            }
        }
        public abstract static class SimpleCallback extends rg_n19577.Callback {
            private int mDefaultSwipeDirs;
            private int mDefaultDragDirs;
            public SimpleCallback(int dragDirs, int swipeDirs) {
                mDefaultSwipeDirs = swipeDirs;
                mDefaultDragDirs = dragDirs;
            }
            public void setDefaultSwipeDirs(int defaultSwipeDirs) {
                mDefaultSwipeDirs = defaultSwipeDirs;
            }
            public void setDefaultDragDirs(int defaultDragDirs) {
                mDefaultDragDirs = defaultDragDirs;
            }
            public int getSwipeDirs(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder) {
                return mDefaultSwipeDirs;
            }
            public int getDragDirs(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder) {
                return mDefaultDragDirs;
            }
            @Override
            public int getMovementFlags(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder) {
                return makeMovementFlags(getDragDirs(recyclerView, viewHolder),
                        getSwipeDirs(recyclerView, viewHolder));
            }
        }
        private static class RecoverAnimation implements Animator.AnimatorListener {
            final float mStartDx;
            final float mStartDy;
            final float mTargetX;
            final float mTargetY;
            final RecyclerView.ViewHolder mViewHolder;
            final int mActionState;
            private final ValueAnimator mValueAnimator;
            final int mAnimationType;
            public boolean mIsPendingCleanup;
            float mX;
            float mY;
            boolean mOverridden = false;
            boolean mEnded = false;
            private float mFraction;
            RecoverAnimation(RecyclerView.ViewHolder viewHolder, int animationType,
                             int actionState, float startDx, float startDy, float targetX, float targetY) {
                mActionState = actionState;
                mAnimationType = animationType;
                mViewHolder = viewHolder;
                mStartDx = startDx;
                mStartDy = startDy;
                mTargetX = targetX;
                mTargetY = targetY;
                mValueAnimator = ValueAnimator.ofFloat(0f, 1f);
                mValueAnimator.addUpdateListener(
                        new ValueAnimator.AnimatorUpdateListener() {
                            @Override
                            public void onAnimationUpdate(ValueAnimator animation) {
                                setFraction(animation.getAnimatedFraction());
                            }
                        });
                mValueAnimator.setTarget(viewHolder.itemView);
                mValueAnimator.addListener(this);
                setFraction(0f);
            }
            public void setDuration(long duration) {
                mValueAnimator.setDuration(duration);
            }
            public void start() {
                mViewHolder.setIsRecyclable(false);
                mValueAnimator.start();
            }
            public void cancel() {
                mValueAnimator.cancel();
            }
            public void setFraction(float fraction) {
                mFraction = fraction;
            }
            public void update() {
                if (mStartDx == mTargetX) {
                    mX = mViewHolder.itemView.getTranslationX();
                } else {
                    mX = mStartDx + mFraction * (mTargetX - mStartDx);
                }
                if (mStartDy == mTargetY) {
                    mY = mViewHolder.itemView.getTranslationY();
                } else {
                    mY = mStartDy + mFraction * (mTargetY - mStartDy);
                }
            }
            @Override
            public void onAnimationStart(Animator animation) { }
            @Override
            public void onAnimationEnd(Animator animation) {
                if (!mEnded) {
                    mViewHolder.setIsRecyclable(true);
                }
                mEnded = true;
            }
            @Override
            public void onAnimationCancel(Animator animation) {
                setFraction(1f);
            }
            @Override
            public void onAnimationRepeat(Animator animation) { }
        }
}
