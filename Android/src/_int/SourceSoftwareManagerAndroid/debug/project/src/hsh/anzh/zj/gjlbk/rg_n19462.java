
package hsh.anzh.zj.gjlbk;

import android.support.v4.view.ViewCompat;
import android.support.v4.view.ViewPropertyAnimatorCompat;
import android.support.v4.view.ViewPropertyAnimatorListener;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.ViewHolder;
import android.support.v7.widget.SimpleItemAnimator;
import android.view.View;
import android.view.animation.DecelerateInterpolator;
import android.view.animation.Interpolator;
import java.util.ArrayList;
import java.util.List;

public class rg_n19462 extends android.support.v7.widget.SimpleItemAnimator {

      private long addDelay = 0;
      private long RemoveDelay = 0;
      private ArrayList<RecyclerView.ViewHolder> mPendingRemovals = new ArrayList<RecyclerView.ViewHolder>();
      private ArrayList<RecyclerView.ViewHolder> mPendingAdditions = new ArrayList<RecyclerView.ViewHolder>();
      private ArrayList<MoveInfo> mPendingMoves = new ArrayList<MoveInfo>();
      private ArrayList<ChangeInfo> mPendingChanges = new ArrayList<ChangeInfo>();
      private ArrayList<ArrayList<RecyclerView.ViewHolder>> mAdditionsList = new ArrayList<ArrayList<RecyclerView.ViewHolder>>();
      private ArrayList<ArrayList<MoveInfo>> mMovesList = new ArrayList<ArrayList<MoveInfo>>();
      private ArrayList<ArrayList<ChangeInfo>> mChangesList = new ArrayList<ArrayList<ChangeInfo>>();
      protected ArrayList<RecyclerView.ViewHolder> mAddAnimations = new ArrayList<RecyclerView.ViewHolder>();
      private ArrayList<ViewHolder> mMoveAnimations = new ArrayList<ViewHolder>();
      protected ArrayList<ViewHolder> mRemoveAnimations = new ArrayList<ViewHolder>();
      private ArrayList<ViewHolder> mChangeAnimations = new ArrayList<ViewHolder>();
      protected Interpolator mInterpolator = new DecelerateInterpolator();
      private static class MoveInfo {
        public ViewHolder holder;
        public int fromX, fromY, toX, toY;
        private MoveInfo(ViewHolder holder, int fromX, int fromY, int toX, int toY) {
          this.holder = holder;
          this.fromX = fromX;
          this.fromY = fromY;
          this.toX = toX;
          this.toY = toY;
        }
      }
      private static class ChangeInfo {
        public ViewHolder oldHolder, newHolder;
        public int fromX, fromY, toX, toY;
        private ChangeInfo(ViewHolder oldHolder, ViewHolder newHolder) {
          this.oldHolder = oldHolder;
          this.newHolder = newHolder;
        }
        private ChangeInfo(ViewHolder oldHolder, ViewHolder newHolder, int fromX, int fromY, int toX, int toY) {
          this(oldHolder, newHolder);
          this.fromX = fromX;
          this.fromY = fromY;
          this.toX = toX;
          this.toY = toY;
        }
      }
      public void setInterpolator(Interpolator mInterpolator) {
        this.mInterpolator = mInterpolator;
      }
      @Override public void runPendingAnimations() {
        boolean removalsPending = !mPendingRemovals.isEmpty();
        boolean movesPending = !mPendingMoves.isEmpty();
        boolean changesPending = !mPendingChanges.isEmpty();
        boolean additionsPending = !mPendingAdditions.isEmpty();
        if (!removalsPending && !movesPending && !additionsPending && !changesPending) {
          return;
        }
        for (ViewHolder holder : mPendingRemovals) {
          doAnimateRemove(holder);
        }
        mPendingRemovals.clear();
        if (movesPending) {
          final ArrayList<MoveInfo> moves = new ArrayList<MoveInfo>();
          moves.addAll(mPendingMoves);
          mMovesList.add(moves);
          mPendingMoves.clear();
          Runnable mover = new Runnable() {
            @Override public void run() {
              boolean removed = mMovesList.remove(moves);
              if (!removed) {
                return;
              }
              for (MoveInfo moveInfo : moves) {
                animateMoveImpl(moveInfo.holder, moveInfo.fromX, moveInfo.fromY, moveInfo.toX,moveInfo.toY);
              }
              moves.clear();
            }
          };
          if (removalsPending) {
            View view = moves.get(0).holder.itemView;
            ViewCompat.postOnAnimationDelayed(view, mover, getRemoveDuration());
          } else {
            mover.run();
          }
        }
        if (changesPending) {
          final ArrayList<ChangeInfo> changes = new ArrayList<ChangeInfo>();
          changes.addAll(mPendingChanges);
          mChangesList.add(changes);
          mPendingChanges.clear();
          Runnable changer = new Runnable() {
            @Override public void run() {
              boolean removed = mChangesList.remove(changes);
              if (!removed) {
                return;
              }
              for (ChangeInfo change : changes) {
                animateChangeImpl(change);
              }
              changes.clear();
            }
          };
          if (removalsPending) {
            ViewHolder holder = changes.get(0).oldHolder;
            ViewCompat.postOnAnimationDelayed(holder.itemView, changer, getRemoveDuration());
          } else {
            changer.run();
          }
        }
        if (additionsPending) {
          final ArrayList<ViewHolder> additions = new ArrayList<ViewHolder>();
          additions.addAll(mPendingAdditions);
          mAdditionsList.add(additions);
          mPendingAdditions.clear();
          Runnable adder = new Runnable() {
            public void run() {
              boolean removed = mAdditionsList.remove(additions);
              if (!removed) {
                return;
              }
              for (ViewHolder holder : additions) {
                doAnimateAdd(holder);
              }
              additions.clear();
            }
          };
          if (removalsPending || movesPending || changesPending) {
            long removeDuration = removalsPending ? getRemoveDuration() : 0;
            long moveDuration = movesPending ? getMoveDuration() : 0;
            long changeDuration = changesPending ? getChangeDuration() : 0;
            long totalDelay = removeDuration + Math.max(moveDuration, changeDuration);
            View view = additions.get(0).itemView;
            ViewCompat.postOnAnimationDelayed(view, adder, totalDelay);
          } else {
            adder.run();
          }
        }
      }
      private void preAnimateRemove(final RecyclerView.ViewHolder holder) {
        rg_n19496.clear(holder.itemView);
        if (holder instanceof AnimateViewHolder) {
          ((AnimateViewHolder) holder).preAnimateRemoveImpl(holder);
        } else {
          rg_n19488 ((android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder) holder);
        }
      }
      private void preAnimateAdd (final RecyclerView.ViewHolder holder) {
        rg_n19496.clear(holder.itemView);
        if (holder instanceof AnimateViewHolder) {
          ((AnimateViewHolder) holder).preAnimateAddImpl(holder);
        } else {
          rg_n19490 ((android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder) holder);
        }
      }
      private void doAnimateRemove(final RecyclerView.ViewHolder holder) {
        if (holder instanceof AnimateViewHolder) {
          ((AnimateViewHolder) holder).animateRemoveImpl(holder, new DefaultRemoveVpaListener(holder));
        } else {
          rg_n19492 ((android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder) holder);
        }
        mRemoveAnimations.add(holder);
      }
      private void doAnimateAdd(final RecyclerView.ViewHolder holder) {
        if (holder instanceof AnimateViewHolder) {
          ((AnimateViewHolder) holder).animateAddImpl(holder, new DefaultAddVpaListener(holder));
        } else {
          rg_n19494((android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder) holder);
        }
        mAddAnimations.add(holder);
      }
      @Override public boolean animateRemove(final ViewHolder holder) {
        endAnimation(holder);
        preAnimateRemove(holder);
        mPendingRemovals.add(holder);
        return true;
      }
      @Override public boolean animateAdd(final ViewHolder holder) {
        endAnimation(holder);
        preAnimateAdd(holder);
        mPendingAdditions.add(holder);
        return true;
      }
      @Override
      public boolean animateMove (final ViewHolder holder, int fromX, int fromY, int toX, int toY) {
        final View view = holder.itemView;
        fromX += holder.itemView.getTranslationX();
        fromY += holder.itemView.getTranslationY();
        endAnimation(holder);
        int deltaX = toX - fromX;
        int deltaY = toY - fromY;
        if (deltaX == 0 && deltaY == 0) {
          dispatchMoveFinished(holder);
          return false;
        }
        if (deltaX != 0) {
          view.setTranslationX(-deltaX);
        }
        if (deltaY != 0) {
          view.setTranslationY(-deltaY);
        }
        mPendingMoves.add(new MoveInfo(holder, fromX, fromY, toX, toY));
        return true;
      }
      private void animateMoveImpl(final ViewHolder holder, int fromX, int fromY, int toX, int toY) {
        final View view = holder.itemView;
        final int deltaX = toX - fromX;
        final int deltaY = toY - fromY;
        if (deltaX != 0) {
          ViewCompat.animate(view).translationX(0);
        }
        if (deltaY != 0) {
          ViewCompat.animate(view).translationY(0);
        }
        mMoveAnimations.add(holder);
        final ViewPropertyAnimatorCompat animation = ViewCompat.animate(view);
        animation.setDuration(getMoveDuration()).setListener(new VpaListenerAdapter() {
          @Override public void onAnimationStart(View view) {
            dispatchMoveStarting(holder);
          }
          @Override public void onAnimationCancel(View view) {
            if (deltaX != 0) {
              view.setTranslationX(0);
            }
            if (deltaY != 0) {
              view.setTranslationY( 0);
            }
          }
          @Override public void onAnimationEnd(View view) {
            animation.setListener(null);
            dispatchMoveFinished(holder);
            mMoveAnimations.remove(holder);
            dispatchFinishedWhenDone();
          }
        }).start();
      }
      @Override
      public boolean animateChange(ViewHolder oldHolder, ViewHolder newHolder, int fromX, int fromY,
          int toX, int toY) {
        final float prevTranslationX = oldHolder.itemView.getTranslationX();
        final float prevTranslationY = oldHolder.itemView.getTranslationY();
        final float prevAlpha = oldHolder.itemView.getAlpha();
        endAnimation(oldHolder);
        int deltaX = (int) (toX - fromX - prevTranslationX);
        int deltaY = (int) (toY - fromY - prevTranslationY);
        oldHolder.itemView.setTranslationX(prevTranslationX);
        oldHolder.itemView.setTranslationY(prevTranslationY);
        oldHolder.itemView.setAlpha(prevAlpha);
        if (newHolder != null && newHolder.itemView != null) {
          endAnimation(newHolder);
          newHolder.itemView.setTranslationX( -deltaX);
          newHolder.itemView.setTranslationY(-deltaY);
          newHolder.itemView.setAlpha( 0);
        }
        mPendingChanges.add(new ChangeInfo(oldHolder, newHolder, fromX, fromY, toX, toY));
        return true;
      }
      private void animateChangeImpl(final ChangeInfo changeInfo) {
        final ViewHolder holder = changeInfo.oldHolder;
        final View view = holder == null ? null : holder.itemView;
        final ViewHolder newHolder = changeInfo.newHolder;
        final View newView = newHolder != null ? newHolder.itemView : null;
        if (view != null) {
          mChangeAnimations.add(changeInfo.oldHolder);
          final ViewPropertyAnimatorCompat oldViewAnim = ViewCompat.animate(view).setDuration(getChangeDuration());
          oldViewAnim.translationX(changeInfo.toX - changeInfo.fromX);
          oldViewAnim.translationY(changeInfo.toY - changeInfo.fromY);
          oldViewAnim.alpha(0).setListener(new VpaListenerAdapter() {
            @Override public void onAnimationStart(View view) {
              dispatchChangeStarting(changeInfo.oldHolder, true);
            }
            @Override public void onAnimationEnd(View view) {
              oldViewAnim.setListener(null);
              view.setAlpha(1);
              view.setTranslationX( 0);
              view.setTranslationY( 0);
              dispatchChangeFinished(changeInfo.oldHolder, true);
              mChangeAnimations.remove(changeInfo.oldHolder);
              dispatchFinishedWhenDone();
            }
          }).start();
        }
        if (newView != null) {
          mChangeAnimations.add(changeInfo.newHolder);
          final ViewPropertyAnimatorCompat newViewAnimation = ViewCompat.animate(newView);
          newViewAnimation.translationX(0).translationY(0).setDuration(getChangeDuration()).
              alpha(1).setListener(new VpaListenerAdapter() {
            @Override public void onAnimationStart(View view) {
              dispatchChangeStarting(changeInfo.newHolder, false);
            }
            @Override public void onAnimationEnd(View view) {
              newViewAnimation.setListener(null);
              newView.setAlpha(1);
              newView.setTranslationX(0);
              newView.setTranslationY(0);
              dispatchChangeFinished(changeInfo.newHolder, false);
              mChangeAnimations.remove(changeInfo.newHolder);
              dispatchFinishedWhenDone();
            }
          }).start();
        }
      }
      private void endChangeAnimation(List<ChangeInfo> infoList, ViewHolder item) {
        for (int i = infoList.size() - 1; i >= 0; i--) {
          ChangeInfo changeInfo = infoList.get(i);
          if (endChangeAnimationIfNecessary(changeInfo, item)) {
            if (changeInfo.oldHolder == null && changeInfo.newHolder == null) {
              infoList.remove(changeInfo);
            }
          }
        }
      }
      private void endChangeAnimationIfNecessary(ChangeInfo changeInfo) {
        if (changeInfo.oldHolder != null) {
          endChangeAnimationIfNecessary(changeInfo, changeInfo.oldHolder);
        }
        if (changeInfo.newHolder != null) {
          endChangeAnimationIfNecessary(changeInfo, changeInfo.newHolder);
        }
      }
      private boolean endChangeAnimationIfNecessary(ChangeInfo changeInfo, ViewHolder item) {
        boolean oldItem = false;
        if (changeInfo.newHolder == item) {
          changeInfo.newHolder = null;
        } else if (changeInfo.oldHolder == item) {
          changeInfo.oldHolder = null;
          oldItem = true;
        } else {
          return false;
        }
        item.itemView.setAlpha( 1);
        item.itemView.setTranslationX(0);
        item.itemView.setTranslationY(0);
        dispatchChangeFinished(item, oldItem);
        return true;
      }
      @Override public void endAnimation(ViewHolder item) {
        final View view = item.itemView;
        ViewCompat.animate(view).cancel();
        for (int i = mPendingMoves.size() - 1; i >= 0; i--) {
          MoveInfo moveInfo = mPendingMoves.get(i);
          if (moveInfo.holder == item) {
            view.setTranslationY(0);
            view.setTranslationX(0);
            dispatchMoveFinished(item);
            mPendingMoves.remove(i);
          }
        }
        endChangeAnimation(mPendingChanges, item);
        if (mPendingRemovals.remove(item)) {
          rg_n19496.clear(item.itemView);
          dispatchRemoveFinished(item);
        }
        if (mPendingAdditions.remove(item)) {
          rg_n19496.clear(item.itemView);
          dispatchAddFinished(item);
        }
        for (int i = mChangesList.size() - 1; i >= 0; i--) {
          ArrayList<ChangeInfo> changes = mChangesList.get(i);
          endChangeAnimation(changes, item);
          if (changes.isEmpty()) {
            mChangesList.remove(i);
          }
        }
        for (int i = mMovesList.size() - 1; i >= 0; i--) {
          ArrayList<MoveInfo> moves = mMovesList.get(i);
          for (int j = moves.size() - 1; j >= 0; j--) {
            MoveInfo moveInfo = moves.get(j);
            if (moveInfo.holder == item) {
              view.setTranslationY(0);
              view.setTranslationX(0);
              dispatchMoveFinished(item);
              moves.remove(j);
              if (moves.isEmpty()) {
                mMovesList.remove(i);
              }
              break;
            }
          }
        }
        for (int i = mAdditionsList.size() - 1; i >= 0; i--) {
          ArrayList<ViewHolder> additions = mAdditionsList.get(i);
          if (additions.remove(item)) {
            rg_n19496.clear(item.itemView);
            dispatchAddFinished(item);
            if (additions.isEmpty()) {
              mAdditionsList.remove(i);
            }
          }
        }
        dispatchFinishedWhenDone();
      }
      @Override public boolean isRunning() {
        return (!mPendingAdditions.isEmpty() ||
            !mPendingChanges.isEmpty() ||
            !mPendingMoves.isEmpty() ||
            !mPendingRemovals.isEmpty() ||
            !mMoveAnimations.isEmpty() ||
            !mRemoveAnimations.isEmpty() ||
            !mAddAnimations.isEmpty() ||
            !mChangeAnimations.isEmpty() ||
            !mMovesList.isEmpty() ||
            !mAdditionsList.isEmpty() ||
            !mChangesList.isEmpty());
      }
      private void dispatchFinishedWhenDone() {
        if (!isRunning()) {
          dispatchAnimationsFinished();
        }
      }
      @Override public void endAnimations() {
        int count = mPendingMoves.size();
        for (int i = count - 1; i >= 0; i--) {
          MoveInfo item = mPendingMoves.get(i);
          View view = item.holder.itemView;
          view.setTranslationY(0);
          view.setTranslationX(0);
          dispatchMoveFinished(item.holder);
          mPendingMoves.remove(i);
        }
        count = mPendingRemovals.size();
        for (int i = count - 1; i >= 0; i--) {
          ViewHolder item = mPendingRemovals.get(i);
          dispatchRemoveFinished(item);
          mPendingRemovals.remove(i);
        }
        count = mPendingAdditions.size();
        for (int i = count - 1; i >= 0; i--) {
          ViewHolder item = mPendingAdditions.get(i);
          rg_n19496.clear(item.itemView);
          dispatchAddFinished(item);
          mPendingAdditions.remove(i);
        }
        count = mPendingChanges.size();
        for (int i = count - 1; i >= 0; i--) {
          endChangeAnimationIfNecessary(mPendingChanges.get(i));
        }
        mPendingChanges.clear();
        if (!isRunning()) {
          return;
        }
        int listCount = mMovesList.size();
        for (int i = listCount - 1; i >= 0; i--) {
          ArrayList<MoveInfo> moves = mMovesList.get(i);
          count = moves.size();
          for (int j = count - 1; j >= 0; j--) {
            MoveInfo moveInfo = moves.get(j);
            ViewHolder item = moveInfo.holder;
            View view = item.itemView;
            view.setTranslationY(0);
            view.setTranslationX(0);
            dispatchMoveFinished(moveInfo.holder);
            moves.remove(j);
            if (moves.isEmpty()) {
              mMovesList.remove(moves);
            }
          }
        }
        listCount = mAdditionsList.size();
        for (int i = listCount - 1; i >= 0; i--) {
          ArrayList<ViewHolder> additions = mAdditionsList.get(i);
          count = additions.size();
          for (int j = count - 1; j >= 0; j--) {
            ViewHolder item = additions.get(j);
            View view = item.itemView;
            view.setAlpha(1);
            dispatchAddFinished(item);
            if (j < additions.size()) {
              additions.remove(j);
            }
            if (additions.isEmpty()) {
              mAdditionsList.remove(additions);
            }
          }
        }
        listCount = mChangesList.size();
        for (int i = listCount - 1; i >= 0; i--) {
          ArrayList<ChangeInfo> changes = mChangesList.get(i);
          count = changes.size();
          for (int j = count - 1; j >= 0; j--) {
            endChangeAnimationIfNecessary(changes.get(j));
            if (changes.isEmpty()) {
              mChangesList.remove(changes);
            }
          }
        }
        cancelAll(mRemoveAnimations);
        cancelAll(mMoveAnimations);
        cancelAll(mAddAnimations);
        cancelAll(mChangeAnimations);
        dispatchAnimationsFinished();
      }
      void cancelAll(List<ViewHolder> viewHolders) {
        for (int i = viewHolders.size() - 1; i >= 0; i--) {
          ViewCompat.animate(viewHolders.get(i).itemView).cancel();
        }
      }
      private static class VpaListenerAdapter implements ViewPropertyAnimatorListener {
        @Override public void onAnimationStart(View view) {}
        @Override public void onAnimationEnd(View view) {}
        @Override public void onAnimationCancel(View view) {}
      }
      protected class DefaultAddVpaListener extends VpaListenerAdapter {
        RecyclerView.ViewHolder mViewHolder;
        public DefaultAddVpaListener(final RecyclerView.ViewHolder holder) {
          mViewHolder = holder;
        }
        @Override public void onAnimationStart(View view) {
          dispatchAddStarting(mViewHolder);
        }
        @Override public void onAnimationCancel(View view) {
          rg_n19496.clear(view);
        }
        @Override public void onAnimationEnd(View view) {
          rg_n19496.clear(view);
          dispatchAddFinished(mViewHolder);
          mAddAnimations.remove(mViewHolder);
          dispatchFinishedWhenDone();
        }
      }
      protected class DefaultRemoveVpaListener extends VpaListenerAdapter {
        RecyclerView.ViewHolder mViewHolder;
        public DefaultRemoveVpaListener(final RecyclerView.ViewHolder holder) {
          mViewHolder = holder;
        }
        @Override public void onAnimationStart(View view) {
          dispatchRemoveStarting(mViewHolder);
        }
        @Override public void onAnimationCancel(View view) {
          rg_n19496.clear(view);
        }
        @Override public void onAnimationEnd(View view) {
          rg_n19496.clear(view);
          dispatchRemoveFinished(mViewHolder);
          mRemoveAnimations.remove(mViewHolder);
          dispatchFinishedWhenDone();
        }
      }
    interface AnimateViewHolder {
      void preAnimateAddImpl    (final RecyclerView.ViewHolder holder);
      void preAnimateRemoveImpl (final RecyclerView.ViewHolder holder);
      void animateAddImpl       (final RecyclerView.ViewHolder holder, ViewPropertyAnimatorListener listener);
      void animateRemoveImpl    (final RecyclerView.ViewHolder holder, ViewPropertyAnimatorListener listener);
    }

    public void rg_n19470 (long rg_n19471) {
        setRemoveDuration (rg_n19471);
    }

    public void rg_n19473 (long rg_n19474) {
        setMoveDuration (rg_n19474);
    }

    public void rg_n19476 (long rg_n19477) {
        setChangeDuration (rg_n19477);
    }

    public void rg_n19479 (long rg_n19480) {
        setAddDuration (rg_n19480);
    }

    public hsh.anzh.jb.rg_n5829 rg_n19482 (final android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19483) {
        hsh.anzh.jb.rg_n5829 rg_n19484;
        rg_n19484 = hsh.anzh.jb.rg_n5829.rg_n5836 (rg_n19187.rg_n19188 (rg_n19483));
        rg_n19484.mViewPropertyAnim.setListener(new DefaultAddVpaListener (rg_n19483));
        return (rg_n19484);
    }

    public hsh.anzh.jb.rg_n5829 rg_n19485 (final android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19486) {
        hsh.anzh.jb.rg_n5829 rg_n19487;
        rg_n19487 = hsh.anzh.jb.rg_n5829.rg_n5836 (rg_n19187.rg_n19188 (rg_n19486));
        rg_n19487.mViewPropertyAnim.setListener(new DefaultRemoveVpaListener (rg_n19486));
        return (rg_n19487);
    }

    public void rg_n19488 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19489) {
    }

    public void rg_n19490 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19491) {
    }

    public void rg_n19492 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19493) {
    }

    public void rg_n19494 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19495) {
    }
}
