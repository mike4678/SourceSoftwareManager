
package anzh.mmmk.lbzj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n44369 extends hsh.anzh.zj.gjlbk.rg_n19032 {

    public rg_n44369 ()  { }

    public rg_n44369 (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n44369 (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 view) { this (context, view, null); }
    public hsh.anzh.zj.gjlbk.rg_n19031 Getvol_QingLiangTuPianLieBiaoKuang () { return (hsh.anzh.zj.gjlbk.rg_n19031)GetView (); }
    public static rg_n44369 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.zj.gjlbk.rg_n19031 (context), null);
    }
    public static rg_n44369 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.zj.gjlbk.rg_n19031 (context), objInitData);
    }
    public static rg_n44369 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n44369 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 viewAttach, Object objInitData) {
        rg_n44369 objControl = new rg_n44369 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public int rg_n44568 = hsh.anzh.jb.rg_n7843.rg_n7848;
    public double rg_n44569 = 10;
    public boolean rg_n44570 = false;
    public double rg_n44571 = -1;
    public double rg_n44572 = 50;
    public double rg_n44573 = 50;
    public boolean rg_n44574 = false;
    public double rg_n44575 = -1;
    public int rg_n44576 = hsh.anzh.jb.AndroidView.rg_n5526;
    public int rg_n44577;
    public double rg_n44578 = 10;
    public boolean rg_n44579 = false;
    public boolean rg_n44580 = false;
    public int rg_n44581 = hsh.anzh.jb.rg_n6128.rg_n6132;
    public int rg_n44582 = hsh.anzh.jb.rg_n6141.rg_n6145;
    public double rg_n44583 = 0;
    public double rg_n44584 = 2;
    public boolean rg_n44585 = false;
    public boolean rg_n44586 = false;
    public int rg_n44587 = hsh.anzh.jb.rg_n6128.rg_n6132;
    public int rg_n44588 = hsh.anzh.jb.rg_n6141.rg_n6145;
    public boolean rg_n44589 = false;
    public boolean rg_n44590 = true;
    public int rg_n44591;
    public int rg_n44592;
    protected rg_n44629 rg_n44593 = new rg_n44629 ();
    protected hsh.anzh.zj.gjlbk.rg_n19291 rg_n44594;
    protected hsh.anzh.zj.gjlbk.rg_n19497 rg_n44595 = new hsh.anzh.zj.gjlbk.rg_n19497 ();
    protected rg_n44599 rg_n44596 = new rg_n44599 ();

    {
        rg_n44595.rg_n19473 (0);
        rg_n44595.rg_n19479 (0);
        rg_n44595.rg_n19476 (0);
        rg_n44595.rg_n19470 (0);
    }

    {
        rl_n19032_n19049 (new hsh.anzh.zj.gjlbk.rg_n19032.re_n19049 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19032 objSource, int nTagNumber, int rg_n19050, int rg_n19051) {
                return rg_n44563 (objSource, nTagNumber, rg_n19050, rg_n19051);
            }
        }, 0);
    }

    public void rg_n44375 (int rg_n44376) {
        rg_n44594.rg_n19297 (rg_n44376);
    }

    public void rg_n44388 (boolean rg_n44389) {
        rg_n44596.rg_n44609 = rg_n44389;
    }

    protected int rg_n44398 (hsh.Java.jb.rg_n36080 rg_n44399, int rg_n44400, java.lang.Object rg_n44401, java.lang.Object rg_n44402) {
        com.bumptech.glide.Glide.get(rg_n5581 ()).clearDiskCache();
        return (0);
    }

    public void rg_n44410 (double rg_n44411, double rg_n44412, boolean rg_n44413) {
        rg_n44573 = (rg_n44570 ? rg_n44411 : hsh.anzh.jb.rg_n12424.rg_n12465 (rg_n44411));
        rg_n44572 = (rg_n44570 ? rg_n44412 : hsh.anzh.jb.rg_n12424.rg_n12465 (rg_n44412));
        if (rg_n44413)
        {
            rg_n44593.rg_n19558 ();
        }
    }

    public void rg_n44414 (double rg_n44415, double rg_n44416, boolean rg_n44417) {
        rg_n44596.rg_n44604 = (rg_n44570 ? rg_n44415 : hsh.anzh.jb.rg_n12424.rg_n12465 (rg_n44415));
        rg_n44596.rg_n44605 = (rg_n44570 ? rg_n44416 : hsh.anzh.jb.rg_n12424.rg_n12465 (rg_n44416));
        if (rg_n44417)
        {
            rg_n44593.rg_n19558 ();
        }
    }

    public void rg_n44466 () {
        rg_n44593.rg_n19558 ();
    }

    public void rg_n44474 (String rg_n44475, String rg_n44476, int rg_n44477, String rg_n44478, int rg_n44479, int rg_n44480, int rg_n44481, java.lang.Object rg_n44482, boolean rg_n44483) {
        rg_n44610 rg_n44484 = new rg_n44610 ();
        if ((rg_n44475.toUpperCase ().startsWith ("HTTP://", 0)) == false && (rg_n44475.toUpperCase ().startsWith ("HTTPS://", 0)) == false)
        {
            rg_n44484.rg_n44612 = anzh.mmmk.wjmlcz.rg_n45829.rg_n45850 (rg_n44475);
        }
        else if ((rg_n44475.toUpperCase ().startsWith ("HTTP://", 0)) == true || (rg_n44475.toUpperCase ().startsWith ("HTTPS://", 0)) == true || rg_n44475.startsWith ((android.os.Environment.getExternalStorageDirectory ().getPath ()), 0) == true || rg_n44475.startsWith (anzh.mmmk.wjmlcz.rg_n46134.rg_n46175 (), 0) == true)
        {
            rg_n44484.rg_n44612 = (Object)rg_n44475;
        }
        rg_n44484.rg_n44613 = rg_n44476;
        rg_n44484.rg_n44615 = rg_n44477;
        rg_n44484.rg_n44614 = rg_n44478;
        rg_n44484.rg_n44616 = rg_n44479;
        rg_n44484.rg_n44617 = rg_n44480;
        rg_n44484.rg_n44611 = rg_n44482;
        rg_n44593.rg_n19552 (rg_n44484, rg_n44481, rg_n44483);
    }

    public void rg_n44495 (android.graphics.drawable.Drawable rg_n44496, String rg_n44497, int rg_n44498, String rg_n44499, int rg_n44500, int rg_n44501, int rg_n44502, java.lang.Object rg_n44503, boolean rg_n44504) {
        rg_n44610 rg_n44505 = new rg_n44610 ();
        rg_n44505.rg_n44612 = rg_n44496;
        rg_n44505.rg_n44613 = rg_n44497;
        rg_n44505.rg_n44615 = rg_n44498;
        rg_n44505.rg_n44614 = rg_n44499;
        rg_n44505.rg_n44616 = rg_n44500;
        rg_n44505.rg_n44617 = rg_n44501;
        rg_n44505.rg_n44611 = rg_n44503;
        rg_n44593.rg_n19552 (rg_n44505, rg_n44502, rg_n44504);
    }

    public int rg_n44542 () {
        return (rg_n44593.rg_n19536 ());
    }

    public rg_n44610 rg_n44543 (int rg_n44544) {
        return ((rg_n44610)rg_n44593.rg_n19556 (rg_n44544));
    }

    public String rg_n44545 (int rg_n44546) {
        return (rg_n44543 (rg_n44546).rg_n44613);
    }

    public static interface re_n44549 { int dispatch (rg_n44369 objSource, int nTagNumber, int rg_n44550, String rg_n44551, String rg_n44552, rg_n44610 rg_n44553, hsh.anzh.jb.rg_n6158 rg_n44554); }
    private re_n44549 rd_n44549;
    private int rd_n44549_tag;
    public void rl_n44369_n44549 (re_n44549 objListener, int nTagNumber) {
        synchronized (this) { rd_n44549 = objListener;  rd_n44549_tag = nTagNumber; }
    }
    public int rg_n44549 (int rg_n44550, String rg_n44551, String rg_n44552, rg_n44610 rg_n44553, hsh.anzh.jb.rg_n6158 rg_n44554) {
        re_n44549 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n44549;  nTagNumber = rd_n44549_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n44550, rg_n44551, rg_n44552, rg_n44553, rg_n44554) : 0);
    }

    public static interface re_n44555 { int dispatch (rg_n44369 objSource, int nTagNumber, int rg_n44556, String rg_n44557, String rg_n44558, rg_n44610 rg_n44559, hsh.anzh.jb.rg_n6158 rg_n44560); }
    private re_n44555 rd_n44555;
    private int rd_n44555_tag;
    public void rl_n44369_n44555 (re_n44555 objListener, int nTagNumber) {
        synchronized (this) { rd_n44555 = objListener;  rd_n44555_tag = nTagNumber; }
    }
    public int rg_n44555 (int rg_n44556, String rg_n44557, String rg_n44558, rg_n44610 rg_n44559, hsh.anzh.jb.rg_n6158 rg_n44560) {
        re_n44555 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n44555;  nTagNumber = rd_n44555_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n44556, rg_n44557, rg_n44558, rg_n44559, rg_n44560) : 0);
    }

    public static interface re_n44561 { int dispatch (rg_n44369 objSource, int nTagNumber); }
    private re_n44561 rd_n44561;
    private int rd_n44561_tag;
    public void rl_n44369_n44561 (re_n44561 objListener, int nTagNumber) {
        synchronized (this) { rd_n44561 = objListener;  rd_n44561_tag = nTagNumber; }
    }
    public int rg_n44561 () {
        re_n44561 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n44561;  nTagNumber = rd_n44561_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n44562 { int dispatch (rg_n44369 objSource, int nTagNumber); }
    private re_n44562 rd_n44562;
    private int rd_n44562_tag;
    public void rl_n44369_n44562 (re_n44562 objListener, int nTagNumber) {
        synchronized (this) { rd_n44562 = objListener;  rd_n44562_tag = nTagNumber; }
    }
    public int rg_n44562 () {
        re_n44562 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n44562;  nTagNumber = rd_n44562_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    protected int rg_n44563 (hsh.anzh.zj.gjlbk.rg_n19032 rg_n44564, int rg_n44565, int rg_n44566, int rg_n44567) {
        if ((rg_n44564.GetView ().canScrollVertically (-1)) == false)
        {
            rg_n44561 ();
        }
        else if ((rg_n44564.GetView ().canScrollVertically (1)) == false)
        {
            rg_n44562 ();
        }
        return (0);
    }

    protected void rg_n4112 (android.content.Context rg_n44597, java.lang.Object rg_n44598) {
        rg_n44594 = hsh.anzh.zj.gjlbk.rg_n19291.rg_n19299 (rg_n44597, 3, hsh.anzh.jb.rg_n6150.rg_n6152, false);
        rg_n44594.rg_n19297 (3);
        rg_n44369 rp_8 = this;
        rp_8.rl_n19032_n19049 (new hsh.anzh.zj.gjlbk.rg_n19032.re_n19049 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19032 objSource, int nTagNumber, int rg_n19050, int rg_n19051) {
                return rg_n44563 (objSource, nTagNumber, rg_n19050, rg_n19051);
            }
        }, 0);
        rg_n5482 (hsh.anzh.jb.rg_n7843.rg_n7848);
        rg_n19072 (rg_n44594);
        rg_n19078 (rg_n44593);
        rg_n19075 (rg_n44595);
        rg_n44596.rg_n44604 = hsh.anzh.jb.rg_n12424.rg_n12465 (15);
        rg_n44596.rg_n44605 = hsh.anzh.jb.rg_n12424.rg_n12465 (10);
        rg_n44573 = hsh.anzh.jb.rg_n12424.rg_n12465 (50);
        rg_n44572 = hsh.anzh.jb.rg_n12424.rg_n12465 (50);
        rg_n44593.rg_n44633 (this, rg_n44596);
        rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5526);
        rg_n44577 = anzh.mmmk.txchl.rg_n44709.rg_n44710 ("wmmk_ripple_bg");
    }
}
