
package hsh.anzh.zj.gjlbk;

public class rg_n19031 extends android.support.v7.widget.RecyclerView {

    private boolean canHorScroll, betterGesture;
    private int mScrollPointerId;
    private int mInitialTouchX, mInitialTouchY;
    private int mTouchSlop;
    public rg_n19031(android.content.Context context) {
        this(context, null);
    }
    public rg_n19031(android.content.Context context, android.util.AttributeSet attrs) {
        this(context, attrs, 0);
    }
    public rg_n19031(android.content.Context context, android.util.AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        android.view.ViewConfiguration vc = android.view.ViewConfiguration.get(getContext());
        this.mTouchSlop = vc.getScaledTouchSlop();
    }
    @Override
    public boolean canScrollHorizontally(int direction) {
        if (!canHorScroll) return super.canScrollHorizontally(direction);
        return true;
    }
    public void setHorScroll(boolean can){
        this.canHorScroll = can;
    }
    public void setBetterGesture(boolean better){
        this.betterGesture = better;
    }
    @Override
    public void setScrollingTouchSlop(int slopConstant) {
        super.setScrollingTouchSlop(slopConstant);
        android.view.ViewConfiguration vc = android.view.ViewConfiguration.get(this.getContext());
        switch (slopConstant) {
            case 0:
                this.mTouchSlop = vc.getScaledTouchSlop();
                break;
            case 1:
                this.mTouchSlop = vc.getScaledPagingTouchSlop();
                break;
        }
    }
    @Override
    public boolean onInterceptTouchEvent(android.view.MotionEvent e) {
        if (!this.betterGesture) return super.onInterceptTouchEvent(e);
        boolean canScrollHorizontally = getLayoutManager().canScrollHorizontally();
        boolean canScrollVertically = getLayoutManager().canScrollVertically();
        int action = e.getActionMasked();
        int actionIndex = e.getActionIndex();
        switch (action) {
            case 0:
                mScrollPointerId = e.getPointerId(0);
                this.mInitialTouchX = (int) (e.getX() + 0.5F);
                this.mInitialTouchY = (int) (e.getY() + 0.5F);
                return super.onInterceptTouchEvent(e);
            case 2:
                int index = e.findPointerIndex(this.mScrollPointerId);
                if (index < 0) {
                    return false;
                }
                int x = (int) (e.getX(index) + 0.5F);
                int y = (int) (e.getY(index) + 0.5F);
                if (getScrollState() != 1) {
                    int dx = x - this.mInitialTouchX;
                    int dy = y - this.mInitialTouchY;
                    boolean startScroll = false;
                    if (canScrollHorizontally && Math.abs(dx) > this.mTouchSlop && Math.abs(dx) > Math.abs(dy)) {
                        startScroll = true;
                    }
                    if (canScrollVertically && Math.abs(dy) > this.mTouchSlop && Math.abs(dy) > Math.abs(dx)) {
                        startScroll = true;
                    }
                    return startScroll && super.onInterceptTouchEvent(e);
                }
                return super.onInterceptTouchEvent(e);
            case 5:
                this.mScrollPointerId = e.getPointerId(actionIndex);
                this.mInitialTouchX = (int) (e.getX(actionIndex) + 0.5F);
                this.mInitialTouchY = (int) (e.getY(actionIndex) + 0.5F);
                return super.onInterceptTouchEvent(e);
        }
        return super.onInterceptTouchEvent(e);
    }
}
