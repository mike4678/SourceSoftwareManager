
package anzh.mmmk.chkzj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n42320 extends rg_n42470 {

    public rg_n42320 ()  { }

    public rg_n42320 (android.content.Context context, rg_n42319 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n42320 (android.content.Context context, rg_n42319 view) { this (context, view, null); }
    public rg_n42319 Getvol_DiBuCaiDanDaoHang () { return (rg_n42319)GetView (); }
    public static rg_n42320 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n42319 (context), null);
    }
    public static rg_n42320 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n42319 (context), objInitData);
    }
    public static rg_n42320 sNewInstanceAndAttachView (android.content.Context context, rg_n42319 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n42320 sNewInstanceAndAttachView (android.content.Context context, rg_n42319 viewAttach, Object objInitData) {
        rg_n42320 objControl = new rg_n42320 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public hsh.anzh.jb.rg_n6072 rg_n42341;

    public static interface re_n42337 { int dispatch (rg_n42320 objSource, int nTagNumber, hsh.anzh.jb.rg_n6072 rg_n42338); }
    private re_n42337 rd_n42337;
    private int rd_n42337_tag;
    public void rl_n42320_n42337 (re_n42337 objListener, int nTagNumber) {
        synchronized (this) { rd_n42337 = objListener;  rd_n42337_tag = nTagNumber; }
    }
    public int rg_n42337 (hsh.anzh.jb.rg_n6072 rg_n42338) {
        re_n42337 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42337;  nTagNumber = rd_n42337_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42338) : 0);
    }

    public static interface re_n42339 { int dispatch (rg_n42320 objSource, int nTagNumber, hsh.anzh.jb.rg_n6072 rg_n42340); }
    private re_n42339 rd_n42339;
    private int rd_n42339_tag;
    public void rl_n42320_n42339 (re_n42339 objListener, int nTagNumber) {
        synchronized (this) { rd_n42339 = objListener;  rd_n42339_tag = nTagNumber; }
    }
    public int rg_n42339 (hsh.anzh.jb.rg_n6072 rg_n42340) {
        re_n42339 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42339;  nTagNumber = rd_n42339_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42340) : 0);
    }

    protected void rg_n4112 (android.content.Context rg_n42342, java.lang.Object rg_n42343) {
        super.rg_n4112 (rg_n42342, rg_n42343);
        rg_n42472 = true;
        rg_n42341 = hsh.anzh.jb.rg_n6072.sNewInstance (this.GetView ().getContext (), null);
        rg_n5745 (rg_n42341, null);
        rg_n6210 (rg_n42341, hsh.anzh.jb.rg_n6128.rg_n6132, hsh.anzh.jb.rg_n6141.rg_n6146);
        rg_n42341.rg_n5423 ((int)hsh.anzh.jb.rg_n12424.rg_n12465 (10));
        rg_n42341.rg_n5536 (60, 60);
        rg_n42341.rg_n5260 (true);
        rg_n42341.rg_n5265 (true);
        rg_n42341.rl_AndroidView_n5238 (new hsh.anzh.jb.AndroidView.re_n5238 () {
            public int dispatch (hsh.anzh.jb.AndroidView objSource, int nTagNumber) {
                return rg_n42344 ((hsh.anzh.jb.rg_n6072)objSource, nTagNumber);
            }
        }, 0);
        rg_n42341.rl_AndroidView_n5239 (new hsh.anzh.jb.AndroidView.re_n5239 () {
            public int dispatch (hsh.anzh.jb.AndroidView objSource, int nTagNumber) {
                return rg_n42347 ((hsh.anzh.jb.rg_n6072)objSource, nTagNumber);
            }
        }, 0);
    }

    protected int rg_n42344 (hsh.anzh.jb.rg_n6072 rg_n42345, int rg_n42346) {
        rg_n42337 (rg_n42345);
        return (0);
    }

    protected int rg_n42347 (hsh.anzh.jb.rg_n6072 rg_n42348, int rg_n42349) {
        rg_n42339 (rg_n42348);
        return (1);
    }
}
