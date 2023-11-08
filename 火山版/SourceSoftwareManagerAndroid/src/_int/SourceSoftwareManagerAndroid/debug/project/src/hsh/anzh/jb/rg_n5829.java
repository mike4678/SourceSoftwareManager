
package hsh.anzh.jb;

public class rg_n5829 {

    public rg_n5829 ()  { }

    public android.support.v4.view.ViewPropertyAnimatorCompat mViewPropertyAnim;
    public rg_n5829 (android.support.v4.view.ViewPropertyAnimatorCompat  m) {
       mViewPropertyAnim = m;
    }

    public static interface re_n5830 { int dispatch (rg_n5829 objSource, int nTagNumber, AndroidView rg_n5831); }
    private re_n5830 rd_n5830;
    private int rd_n5830_tag;
    public void rl_n5829_n5830 (re_n5830 objListener, int nTagNumber) {
        synchronized (this) { rd_n5830 = objListener;  rd_n5830_tag = nTagNumber; }
    }
    public int rg_n5830 (AndroidView rg_n5831) {
        re_n5830 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5830;  nTagNumber = rd_n5830_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n5831) : 0);
    }

    public static interface re_n5832 { int dispatch (rg_n5829 objSource, int nTagNumber, AndroidView rg_n5833); }
    private re_n5832 rd_n5832;
    private int rd_n5832_tag;
    public void rl_n5829_n5832 (re_n5832 objListener, int nTagNumber) {
        synchronized (this) { rd_n5832 = objListener;  rd_n5832_tag = nTagNumber; }
    }
    public int rg_n5832 (AndroidView rg_n5833) {
        re_n5832 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5832;  nTagNumber = rd_n5832_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n5833) : 0);
    }

    public static interface re_n5834 { int dispatch (rg_n5829 objSource, int nTagNumber, AndroidView rg_n5835); }
    private re_n5834 rd_n5834;
    private int rd_n5834_tag;
    public void rl_n5829_n5834 (re_n5834 objListener, int nTagNumber) {
        synchronized (this) { rd_n5834 = objListener;  rd_n5834_tag = nTagNumber; }
    }
    public int rg_n5834 (AndroidView rg_n5835) {
        re_n5834 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5834;  nTagNumber = rd_n5834_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n5835) : 0);
    }

    public static rg_n5829 rg_n5836 (AndroidView rg_n5837) {
        final rg_n5829 result = new rg_n5829 ();
        result.mViewPropertyAnim = android.support.v4.view.ViewCompat.animate (rg_n5837.GetView ());
        result.mViewPropertyAnim.setListener(new android.support.v4.view.ViewPropertyAnimatorListener() {
            @Override
            public void onAnimationStart(android.view.View view) {
                result.rg_n5830 (AndroidView.sSafeGetVolView (view));
            }
            @Override
            public void onAnimationEnd(android.view.View view) {
                result.rg_n5834 (AndroidView.sSafeGetVolView (view));
            }
            @Override
            public void onAnimationCancel(android.view.View view) {
                result.rg_n5832 (AndroidView.sSafeGetVolView (view));
            }
        });
        return result;
    }

    public rg_n5829 rg_n5847 (double rg_n5848, boolean rg_n5849) {
        if (rg_n5849 == true) mViewPropertyAnim.rotationYBy ((float)rg_n5848); else mViewPropertyAnim.rotationY ((float)rg_n5848);
        return this;
    }

    public rg_n5829 rg_n5856 (long rg_n5857) {
        mViewPropertyAnim.setDuration (rg_n5857);
        return this;
    }

    public rg_n5829 rg_n5859 (android.view.animation.Interpolator rg_n5860) {
        mViewPropertyAnim.setInterpolator (rg_n5860);
        return this;
    }

    public rg_n5829 rg_n5862 (long rg_n5863) {
        mViewPropertyAnim.setStartDelay (rg_n5863);
        return this;
    }
}
