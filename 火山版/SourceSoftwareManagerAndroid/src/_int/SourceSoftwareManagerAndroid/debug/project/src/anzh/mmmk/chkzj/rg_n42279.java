
package anzh.mmmk.chkzj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n42279 extends hsh.anzh.jb.rg_n6031 {

    public rg_n42279 ()  { }

    public rg_n42279 (android.content.Context context, hsh.anzh.jb.rg_n6030 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n42279 (android.content.Context context, hsh.anzh.jb.rg_n6030 view) { this (context, view, null); }
    public hsh.anzh.jb.rg_n6030 Getvol_GaoJiDuoXuanKuang () { return (hsh.anzh.jb.rg_n6030)GetView (); }
    public static rg_n42279 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.jb.rg_n6030 (context), null);
    }
    public static rg_n42279 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.jb.rg_n6030 (context), objInitData);
    }
    public static rg_n42279 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.jb.rg_n6030 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n42279 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.jb.rg_n6030 viewAttach, Object objInitData) {
        rg_n42279 objControl = new rg_n42279 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    protected static final String rg_n42305 = "\uf058";
    protected static final String rg_n42306 = "\uf1db";
    protected static final String rg_n42307 = "\uf14a";
    protected static final String rg_n42308 = "\uf096";
    protected String rg_n42309 = "\uf058";
    protected String rg_n42310 = "\uf1db";
    protected hsh.anzh.rg_n16552 rg_n42311;
    protected boolean rg_n42312 = false;
    protected boolean rg_n42313 = true;

    public void rg_n42283 (int rg_n42284) {
        rg_n42311.rg_n16600 (rg_n42284);
    }

    public void rg_n42285 (int rg_n42286) {
        rg_n42311.rg_n16566 (rg_n42286);
    }

    public void rg_n42293 (String rg_n42294) {
        rg_n42311.rg_n16557 (rg_n42294);
    }

    public void rg_n42299 (boolean rg_n42300) {
        rg_n42311.rg_n16564 (rg_n42300 ? rg_n42309 : rg_n42310);
        if (rg_n42300 != rg_n42312)
        {
            rg_n42302 (false, rg_n42300);
            rg_n42312 = rg_n42300;
        }
    }

    public boolean rg_n42301 () {
        return (rg_n42312);
    }

    public static interface re_n42302 { int dispatch (rg_n42279 objSource, int nTagNumber, boolean rg_n42303, boolean rg_n42304); }
    private re_n42302 rd_n42302;
    private int rd_n42302_tag;
    public void rl_n42279_n42302 (re_n42302 objListener, int nTagNumber) {
        synchronized (this) { rd_n42302 = objListener;  rd_n42302_tag = nTagNumber; }
    }
    public int rg_n42302 (boolean rg_n42303, boolean rg_n42304) {
        re_n42302 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42302;  nTagNumber = rd_n42302_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42303, rg_n42304) : 0);
    }

    protected void rg_n4112 (android.content.Context rg_n42314, java.lang.Object rg_n42315) {
        super.rg_n4112 (rg_n42314, rg_n42315);
        rg_n42311 = hsh.anzh.rg_n16552.sNewInstance (this.GetView ().getContext (), null);
        rg_n6032 ().rg_n5745 (rg_n42311, null);
        rg_n42311.rl_AndroidView_n5238 (new hsh.anzh.jb.AndroidView.re_n5238 () {
            public int dispatch (hsh.anzh.jb.AndroidView objSource, int nTagNumber) {
                return rg_n42316 ((hsh.anzh.rg_n16552)objSource, nTagNumber);
            }
        }, 0);
        rg_n42311.rg_n16557 ("");
        rg_n42311.rg_n16564 (rg_n42306);
        rg_n42311.rg_n5482 (hsh.anzh.jb.rg_n7843.rg_n7855);
        rg_n5482 (hsh.anzh.jb.rg_n7843.rg_n7855);
        rg_n42311.rg_n5512 (0, 0, 0, 0);
        rg_n42311.rg_n16620 (0, 0, 0, 0);
        rg_n6032 ().rg_n5512 (0, 0, 0, 0);
    }

    protected int rg_n42316 (hsh.anzh.rg_n16552 rg_n42317, int rg_n42318) {
        rg_n42311.rg_n16564 (rg_n42312 ? rg_n42310 : rg_n42309);
        rg_n42312 = (rg_n42312 ? false : true);
        rg_n42302 (true, rg_n42312);
        return (0);
    }
}
