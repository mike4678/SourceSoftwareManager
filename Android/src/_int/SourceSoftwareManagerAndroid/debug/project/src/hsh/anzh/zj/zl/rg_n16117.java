
package hsh.anzh.zj.zl;

public class rg_n16117 extends android.support.v4.view.ViewPager {

    public boolean isCanScroll = true;
    private int currentIndex;
    private int height = 0;
    private java.util.HashMap<Integer, android.view.View> mChildrenViews = new java.util.LinkedHashMap<Integer, android.view.View>();
    private boolean isWrapContentHeight;
    public rg_n16117 (android.content.Context context) {
        this(context, null);
    }
    public rg_n16117 (android.content.Context context, android.util.AttributeSet attrs) {
        super(context, attrs);
    }
    @Override
    public boolean onTouchEvent(android.view.MotionEvent ev) {
        try {
            return isCanScroll && super.onTouchEvent(ev);
        } catch (IllegalArgumentException ex) {
            ex.printStackTrace();
        }
        return false;
    }
    @Override
    public boolean onInterceptTouchEvent(android.view.MotionEvent ev) {
        try {
            return isCanScroll && super.onInterceptTouchEvent(ev);
        } catch (IllegalArgumentException ex) {
            ex.printStackTrace();
        }
        return false;
    }
    @Override
    protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
        if (!isWrapContentHeight){
            super.onMeasure(widthMeasureSpec, heightMeasureSpec);
            return;
        }
        if (mChildrenViews.size() > currentIndex && mChildrenViews.get(currentIndex) != null) {
            android.view.View child = mChildrenViews.get(currentIndex);
            child.measure(widthMeasureSpec, android.view.View.MeasureSpec.makeMeasureSpec(0, android.view.View.MeasureSpec.UNSPECIFIED));
            height = child.getMeasuredHeight();
        }
        if (mChildrenViews.size() != 0) {
            heightMeasureSpec = android.view.View.MeasureSpec.makeMeasureSpec(height, android.view.View.MeasureSpec.EXACTLY);
        }
        super.onMeasure(widthMeasureSpec, heightMeasureSpec);
    }
    public void resetHeight(int current) {
        currentIndex = current;
        if (mChildrenViews.size() > current) {
            android.view.ViewGroup.LayoutParams layoutParams = getLayoutParams();
            if (layoutParams == null) {
                layoutParams = new android.view.ViewGroup.LayoutParams(android.view.ViewGroup.LayoutParams.MATCH_PARENT, height);
            } else {
                layoutParams.height = height;
            }
            setLayoutParams(layoutParams);
        }
    }
    public void setViewForPosition(android.view.View view, int position) {
        mChildrenViews.put(position, view);
    }
    public void setWrapContentHeight(boolean isWrapContentHeight){
        this.isWrapContentHeight = isWrapContentHeight;
    }
    public boolean getWrapContentHeight(){
        return this.isWrapContentHeight;
    }
}
