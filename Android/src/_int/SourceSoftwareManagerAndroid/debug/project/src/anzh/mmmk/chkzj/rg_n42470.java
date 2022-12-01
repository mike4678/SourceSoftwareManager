
package anzh.mmmk.chkzj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n42470 extends hsh.anzh.jb.rg_n6202 {

    public rg_n42470 ()  { }

    public rg_n42470 (android.content.Context context, rg_n42319 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n42470 (android.content.Context context, rg_n42319 view) { this (context, view, null); }
    public rg_n42319 Getvol_GaoJiDiBuDaoHang () { return (rg_n42319)GetView (); }
    public static rg_n42470 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n42319 (context), null);
    }
    public static rg_n42470 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n42319 (context), objInitData);
    }
    public static rg_n42470 sNewInstanceAndAttachView (android.content.Context context, rg_n42319 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n42470 sNewInstanceAndAttachView (android.content.Context context, rg_n42319 viewAttach, Object objInitData) {
        rg_n42470 objControl = new rg_n42470 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public boolean rg_n42471 = true;
    public boolean rg_n42472 = false;
    protected rg_n42350 rg_n42581;
    protected hsh.anzh.zj.zl.rg_n16118 rg_n42582;

    public void rg_n42486 (int rg_n42487, String rg_n42488, int rg_n42489, int rg_n42490, String rg_n42491, int rg_n42492, boolean rg_n42493, hsh.anzh.jb.AndroidViewGroup rg_n42494, int rg_n42495) {
        if (this instanceof rg_n42320 && rg_n42472 == true)
        {
            if (rg_n42471)
            {
                if ((rg_n42582.GetViewPager().getAdapter().getCount()) == 4)
                {
                    hsh.anzh.jb.rg_n14019.rg_n14027 ("设置了“导航样式”属性，导航只能添加四个");
                    return;
                }
                else if ((rg_n42582.GetViewPager().getAdapter().getCount()) == 2)
                {
                    rg_n42581.rg_n42421 ("", "", hsh.anzh.jb.rg_n7843.rg_n7855, "", "", hsh.anzh.jb.rg_n7843.rg_n7855, false, 0);
                }
            }
            else
            {
                if ((rg_n42582.GetViewPager().getAdapter().getCount()) == 2)
                {
                    hsh.anzh.jb.rg_n14019.rg_n14027 ("设置了“导航样式”属性，导航只能添加两个");
                    return;
                }
                else if ((rg_n42582.GetViewPager().getAdapter().getCount()) == 1)
                {
                    rg_n42581.rg_n42421 ("", "", hsh.anzh.jb.rg_n7843.rg_n7855, "", "", hsh.anzh.jb.rg_n7843.rg_n7855, false, 0);
                }
            }
            rg_n42581.rg_n42432 (rg_n42487, rg_n42488, rg_n42489, rg_n42490, rg_n42491, rg_n42492, rg_n42493, rg_n42495);
            rg_n42582.rg_n16154 (rg_n42494);
        }
        else
        {
            rg_n42581.rg_n42432 (rg_n42487, rg_n42488, rg_n42489, rg_n42490, rg_n42491, rg_n42492, rg_n42493, rg_n42495);
            rg_n42582.rg_n16154 (rg_n42494);
        }
    }

    public void rg_n42544 (boolean rg_n42545) {
        rg_n42581.rg_n42454 = rg_n42545;
    }

    protected int rg_n42559 (hsh.anzh.zj.zl.rg_n16118 rg_n42560, int rg_n42561, int rg_n42562) {
        if (this instanceof rg_n42320 && rg_n42472 == true)
        {
            if (rg_n42471 && (rg_n42582.GetViewPager().getCurrentItem()) > 1)
            {
                rg_n42562 = rg_n42562 + 1;
                rg_n42591 (rg_n42562 - 1);
            }
            else if (rg_n42471 == false && (rg_n42582.GetViewPager().getCurrentItem()) == 1)
            {
                rg_n42562 = 2;
                rg_n42591 (rg_n42562 - 1);
            }
            else
            {
                rg_n42591 (rg_n42562);
            }
            rg_n42581.rg_n42353 (rg_n42562);
        }
        else
        {
            rg_n42581.rg_n42353 (rg_n42562);
            rg_n42591 (rg_n42562);
        }
        return (0);
    }

    protected int rg_n42563 (hsh.anzh.zj.zl.rg_n16118 rg_n42564, int rg_n42565, int rg_n42566) {
        rg_n42593 (rg_n42566);
        return (0);
    }

    protected int rg_n42567 (rg_n42350 rg_n42568, int rg_n42569, int rg_n42570, String rg_n42571, boolean rg_n42572) {
        if (rg_n42572)
        {
            if (this instanceof rg_n42320 && rg_n42472 == true)
            {
                if (rg_n42471 && rg_n42570 > 2)
                {
                    rg_n42570 = rg_n42570 - 1;
                }
                else if (rg_n42471 == false && rg_n42570 == 2)
                {
                    rg_n42570 = 1;
                }
                rg_n42582.rg_n16136 (rg_n42570);
                rg_n42585 (rg_n42570, rg_n42571);
            }
            else
            {
                rg_n42582.rg_n16136 (rg_n42570);
                rg_n42585 (rg_n42570, rg_n42571);
            }
        }
        return (0);
    }

    protected int rg_n42573 (rg_n42350 rg_n42574, int rg_n42575, int rg_n42576, String rg_n42577) {
        if (this instanceof rg_n42320 && rg_n42472 == true)
        {
            if (rg_n42471 && rg_n42576 > 3)
            {
                rg_n42588 (rg_n42576 - 1, rg_n42577);
            }
            else if (rg_n42576 == 2)
            {
                rg_n42588 (1, rg_n42577);
            }
        }
        else
        {
            rg_n42588 (rg_n42576, rg_n42577);
        }
        return (0);
    }

    protected int rg_n42578 (rg_n42350 rg_n42579, int rg_n42580) {
        if ((rg_n42579.GetView ().getMeasuredHeight ()) > 0 && (this.GetView ().getMeasuredHeight ()) > 0)
        {
            rg_n42579.rg_n5281 (false);
            rg_n42582.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, (this.GetView ().getMeasuredHeight ()) - (rg_n42579.GetView ().getMeasuredHeight ()) + (int)hsh.anzh.jb.rg_n12424.rg_n12465 (4));
        }
        return (0);
    }

    protected void rg_n4112 (android.content.Context rg_n42583, java.lang.Object rg_n42584) {
        super.rg_n4112 (rg_n42583, rg_n42584);
        rg_n42582 = hsh.anzh.zj.zl.rg_n16118.sNewInstance (this.GetView ().getContext (), null);
        rg_n42581 = rg_n42350.sNewInstance (this.GetView ().getContext (), null);
        rg_n5745 (rg_n42582, null);
        rg_n5745 (rg_n42581, null);
        rg_n42581.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5526);
        rg_n42582.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        rg_n6210 (rg_n42581, hsh.anzh.jb.rg_n6128.rg_n6132, hsh.anzh.jb.rg_n6141.rg_n6146);
        rg_n42581.rg_n5281 (true);
        rg_n42581.rl_n42350_n42373 (new rg_n42350.re_n42373 () {
            public int dispatch (rg_n42350 objSource, int nTagNumber, int rg_n42374, String rg_n42375, boolean rg_n42376) {
                return rg_n42567 (objSource, nTagNumber, rg_n42374, rg_n42375, rg_n42376);
            }
        }, 0);
        rg_n42581.rl_n42350_n42377 (new rg_n42350.re_n42377 () {
            public int dispatch (rg_n42350 objSource, int nTagNumber, int rg_n42378, String rg_n42379) {
                return rg_n42573 (objSource, nTagNumber, rg_n42378, rg_n42379);
            }
        }, 0);
        rg_n42581.rl_AndroidView_n5258 (new hsh.anzh.jb.AndroidView.re_n5258 () {
            public int dispatch (hsh.anzh.jb.AndroidView objSource, int nTagNumber) {
                return rg_n42578 ((rg_n42350)objSource, nTagNumber);
            }
        }, 0);
        rg_n42582.rl_n16118_n16178 (new hsh.anzh.zj.zl.rg_n16118.re_n16178 () {
            public int dispatch (hsh.anzh.zj.zl.rg_n16118 objSource, int nTagNumber, int rg_n16179) {
                return rg_n42559 (objSource, nTagNumber, rg_n16179);
            }
        }, 0);
        rg_n42582.rl_n16118_n16172 (new hsh.anzh.zj.zl.rg_n16118.re_n16172 () {
            public int dispatch (hsh.anzh.zj.zl.rg_n16118 objSource, int nTagNumber, int rg_n16173) {
                return rg_n42563 (objSource, nTagNumber, rg_n16173);
            }
        }, 0);
        rg_n42582.rg_n16147 (true);
        rg_n42582.rg_n5482 (hsh.anzh.jb.rg_n7843.rg_n7848);
    }

    public static interface re_n42585 { int dispatch (rg_n42470 objSource, int nTagNumber, int rg_n42586, String rg_n42587); }
    private re_n42585 rd_n42585;
    private int rd_n42585_tag;
    public void rl_n42470_n42585 (re_n42585 objListener, int nTagNumber) {
        synchronized (this) { rd_n42585 = objListener;  rd_n42585_tag = nTagNumber; }
    }
    public int rg_n42585 (int rg_n42586, String rg_n42587) {
        re_n42585 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42585;  nTagNumber = rd_n42585_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42586, rg_n42587) : 0);
    }

    public static interface re_n42588 { int dispatch (rg_n42470 objSource, int nTagNumber, int rg_n42589, String rg_n42590); }
    private re_n42588 rd_n42588;
    private int rd_n42588_tag;
    public void rl_n42470_n42588 (re_n42588 objListener, int nTagNumber) {
        synchronized (this) { rd_n42588 = objListener;  rd_n42588_tag = nTagNumber; }
    }
    public int rg_n42588 (int rg_n42589, String rg_n42590) {
        re_n42588 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42588;  nTagNumber = rd_n42588_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42589, rg_n42590) : 0);
    }

    public static interface re_n42591 { int dispatch (rg_n42470 objSource, int nTagNumber, int rg_n42592); }
    private re_n42591 rd_n42591;
    private int rd_n42591_tag;
    public void rl_n42470_n42591 (re_n42591 objListener, int nTagNumber) {
        synchronized (this) { rd_n42591 = objListener;  rd_n42591_tag = nTagNumber; }
    }
    public int rg_n42591 (int rg_n42592) {
        re_n42591 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42591;  nTagNumber = rd_n42591_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42592) : 0);
    }

    public static interface re_n42593 { int dispatch (rg_n42470 objSource, int nTagNumber, int rg_n42594); }
    private re_n42593 rd_n42593;
    private int rd_n42593_tag;
    public void rl_n42470_n42593 (re_n42593 objListener, int nTagNumber) {
        synchronized (this) { rd_n42593 = objListener;  rd_n42593_tag = nTagNumber; }
    }
    public int rg_n42593 (int rg_n42594) {
        re_n42593 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42593;  nTagNumber = rd_n42593_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42594) : 0);
    }
}
