
package anzh.mmmk.chkzj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n42350 extends hsh.anzh.jb.rg_n6031 {

    public rg_n42350 ()  { }

    public rg_n42350 (android.content.Context context, hsh.anzh.jb.rg_n6030 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n42350 (android.content.Context context, hsh.anzh.jb.rg_n6030 view) { this (context, view, null); }
    public hsh.anzh.jb.rg_n6030 Getvol_DiBuDaoHang () { return (hsh.anzh.jb.rg_n6030)GetView (); }
    public static rg_n42350 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.jb.rg_n6030 (context), null);
    }
    public static rg_n42350 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.jb.rg_n6030 (context), objInitData);
    }
    public static rg_n42350 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.jb.rg_n6030 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n42350 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.jb.rg_n6030 viewAttach, Object objInitData) {
        rg_n42350 objControl = new rg_n42350 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public boolean rg_n42454 = false;
    public anzh.mmmk.lbzj.rg_n44369 rg_n42455;
    protected java.util.ArrayList<java.lang.Object> rg_n42456 = new java.util.ArrayList<java.lang.Object> ();
    protected int rg_n42457 = -1;
    protected int rg_n42458 = -1;
    protected hsh.anzh.jb.rg_n7044 rg_n42459;
    private static final int rg_n42462 = source.SoftwareManagerAndroid.R.drawable.wm_yinying;

    public void rg_n42353 (int rg_n42354) {
        rg_n42380 (rg_n42455, 0, rg_n42354, rg_n42455.rg_n44545 (rg_n42355 ()), "1", null, null);
    }

    public int rg_n42355 () {
        return (rg_n42458);
    }

    public static interface re_n42373 { int dispatch (rg_n42350 objSource, int nTagNumber, int rg_n42374, String rg_n42375, boolean rg_n42376); }
    private re_n42373 rd_n42373;
    private int rd_n42373_tag;
    public void rl_n42350_n42373 (re_n42373 objListener, int nTagNumber) {
        synchronized (this) { rd_n42373 = objListener;  rd_n42373_tag = nTagNumber; }
    }
    public int rg_n42373 (int rg_n42374, String rg_n42375, boolean rg_n42376) {
        re_n42373 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42373;  nTagNumber = rd_n42373_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42374, rg_n42375, rg_n42376) : 0);
    }

    public static interface re_n42377 { int dispatch (rg_n42350 objSource, int nTagNumber, int rg_n42378, String rg_n42379); }
    private re_n42377 rd_n42377;
    private int rd_n42377_tag;
    public void rl_n42350_n42377 (re_n42377 objListener, int nTagNumber) {
        synchronized (this) { rd_n42377 = objListener;  rd_n42377_tag = nTagNumber; }
    }
    public int rg_n42377 (int rg_n42378, String rg_n42379) {
        re_n42377 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n42377;  nTagNumber = rd_n42377_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n42378, rg_n42379) : 0);
    }

    protected int rg_n42380 (anzh.mmmk.lbzj.rg_n44369 rg_n42381, int rg_n42382, int rg_n42383, String rg_n42384, String rg_n42385, anzh.mmmk.lbzj.rg_n44610 rg_n42386, hsh.anzh.jb.rg_n6158 rg_n42387) {
        if (rg_n42457 != rg_n42383)
        {
            rg_n42463 rg_n42388;
            rg_n42388 = (rg_n42463)rg_n42456.get (rg_n42383);
            anzh.mmmk.lbzj.rg_n44610 rg_n42389;
            rg_n42389 = rg_n42455.rg_n44543 (rg_n42383);
            {
                rg_n42389.rg_n44612 = rg_n42388.rg_n42467;
                rg_n42389.rg_n44613 = rg_n42388.rg_n42468;
                rg_n42389.rg_n44615 = rg_n42388.rg_n42469;
                rg_n42463 rg_n42390;
                rg_n42390 = (rg_n42463)rg_n42456.get (rg_n42457);
                anzh.mmmk.lbzj.rg_n44610 rg_n42391;
                rg_n42391 = rg_n42455.rg_n44543 (rg_n42457);
                if (rg_n42390 != null && rg_n42391 != null)
                {
                    rg_n42391.rg_n44612 = rg_n42390.rg_n42464;
                    rg_n42391.rg_n44613 = rg_n42390.rg_n42465;
                    rg_n42391.rg_n44615 = rg_n42390.rg_n42466;
                    rg_n42457 = rg_n42383;
                    rg_n42458 = rg_n42383;
                    rg_n42455.rg_n44466 ();
                    if (rg_n42385.equals ("1"))
                    {
                        rg_n42373 (rg_n42383, rg_n42388.rg_n42468, false);
                    }
                    else
                    {
                        rg_n42373 (rg_n42383, rg_n42388.rg_n42468, true);
                    }
                }
            }
        }
        else
        {
            if (rg_n42454 == true)
            {
                if (rg_n42385.equals ("1"))
                {
                    rg_n42373 (rg_n42383, rg_n42384, false);
                }
                else
                {
                    rg_n42373 (rg_n42383, rg_n42384, true);
                }
            }
        }
        return (0);
    }

    protected int rg_n42392 (anzh.mmmk.lbzj.rg_n44369 rg_n42393, int rg_n42394, int rg_n42395, String rg_n42396, String rg_n42397, anzh.mmmk.lbzj.rg_n44610 rg_n42398, hsh.anzh.jb.rg_n6158 rg_n42399) {
        rg_n42377 (rg_n42395, rg_n42396);
        return (0);
    }

    public void rg_n42421 (String rg_n42422, String rg_n42423, int rg_n42424, String rg_n42425, String rg_n42426, int rg_n42427, boolean rg_n42428, int rg_n42429) {
        rg_n42463 rg_n42430 = new rg_n42463 ();
        if (rg_n42422.startsWith ((android.os.Environment.getExternalStorageDirectory ().getPath ()), 0) == true || rg_n42422.startsWith (anzh.mmmk.wjmlcz.rg_n46134.rg_n46175 (), 0) == true)
        {
            rg_n42430.rg_n42464 = anzh.mmmk.txchl.rg_n44889.rg_n44900 (rg_n42422);
        }
        else if ((rg_n42422.toUpperCase ().startsWith ("HTTP://", 0)) == false)
        {
            rg_n42430.rg_n42464 = anzh.mmmk.wjmlcz.rg_n45829.rg_n45850 (rg_n42422);
        }
        rg_n42430.rg_n42465 = rg_n42423;
        rg_n42430.rg_n42466 = rg_n42424;
        if (hsh.Java.jb.rg_n35692.rg_n35711 (rg_n42425))
        {
            rg_n42425 = rg_n42422;
        }
        if (rg_n42422.equals (rg_n42425) || hsh.Java.jb.rg_n35692.rg_n35711 (rg_n42425))
        {
            if (rg_n42422.startsWith ((android.os.Environment.getExternalStorageDirectory ().getPath ()), 0) == true || rg_n42422.startsWith (anzh.mmmk.wjmlcz.rg_n46134.rg_n46175 (), 0) == true)
            {
                android.graphics.drawable.Drawable rg_n42431;
                rg_n42431 = anzh.mmmk.txchl.rg_n44889.rg_n44900 (rg_n42422);
                if (rg_n42431 != null)
                {
                    rg_n42430.rg_n42467 = anzh.mmmk.txchl.rg_n44889.rg_n44912 (rg_n42431, rg_n42427);
                }
            }
            else
            {
                rg_n42430.rg_n42467 = anzh.mmmk.wjmlcz.rg_n45829.rg_n45850 (rg_n42422);
            }
        }
        else
        {
            if (rg_n42425.startsWith ((android.os.Environment.getExternalStorageDirectory ().getPath ()), 0) == true || rg_n42425.startsWith (anzh.mmmk.wjmlcz.rg_n46134.rg_n46175 (), 0) == true)
            {
                rg_n42430.rg_n42467 = anzh.mmmk.txchl.rg_n44889.rg_n44900 (rg_n42425);
            }
            else
            {
                rg_n42430.rg_n42467 = anzh.mmmk.wjmlcz.rg_n45829.rg_n45850 (rg_n42425);
            }
        }
        if (rg_n42426.equals (""))
        {
            rg_n42426 = rg_n42423;
        }
        rg_n42430.rg_n42468 = rg_n42426;
        rg_n42430.rg_n42469 = rg_n42427;
        hsh.Java.jb.rg_n37113.rg_n37117 (rg_n42456, rg_n42430);
        if (rg_n42428)
        {
            if (rg_n42457 == -1)
            {
                rg_n42457 = rg_n42455.rg_n44542 ();
                rg_n42458 = rg_n42457;
                rg_n42455.rg_n44474 (rg_n42425, rg_n42426, rg_n42427, "", hsh.anzh.jb.rg_n7843.rg_n7846, rg_n42429, -1, null, true);
            }
            else
            {
                rg_n42455.rg_n44474 (rg_n42422, rg_n42423, rg_n42424, "", hsh.anzh.jb.rg_n7843.rg_n7846, rg_n42429, -1, null, true);
            }
        }
        else
        {
            rg_n42455.rg_n44474 (rg_n42422, rg_n42423, rg_n42424, "", hsh.anzh.jb.rg_n7843.rg_n7846, rg_n42429, -1, null, true);
        }
        rg_n42455.rg_n44375 (rg_n42455.rg_n44542 ());
    }

    public void rg_n42432 (int rg_n42433, String rg_n42434, int rg_n42435, int rg_n42436, String rg_n42437, int rg_n42438, boolean rg_n42439, int rg_n42440) {
        int rg_n42441;
        rg_n42441 = ((rg_n42436 == (int)0) ? rg_n42433 : rg_n42436);
        rg_n42442 (hsh.anzh.jb.rg_n12424.rg_n12449 (rg_n42433), rg_n42434, rg_n42435, (rg_n42436 == (int)0) ? anzh.mmmk.txchl.rg_n44889.rg_n44912 (hsh.anzh.jb.rg_n12424.rg_n12449 (rg_n42441), rg_n42438) : hsh.anzh.jb.rg_n12424.rg_n12449 (rg_n42441), rg_n42437, rg_n42438, rg_n42439, rg_n42440);
    }

    public void rg_n42442 (android.graphics.drawable.Drawable rg_n42443, String rg_n42444, int rg_n42445, android.graphics.drawable.Drawable rg_n42446, String rg_n42447, int rg_n42448, boolean rg_n42449, int rg_n42450) {
        rg_n42463 rg_n42451 = new rg_n42463 ();
        rg_n42451.rg_n42464 = rg_n42443;
        rg_n42451.rg_n42465 = rg_n42444;
        rg_n42451.rg_n42466 = rg_n42445;
        if (rg_n42446 == null && rg_n42443 != null)
        {
            rg_n42446 = rg_n42443;
            rg_n42451.rg_n42467 = anzh.mmmk.txchl.rg_n44889.rg_n44912 (rg_n42446, rg_n42448);
        }
        else
        {
            rg_n42451.rg_n42467 = rg_n42446;
        }
        rg_n42447 = (rg_n42447.equals ("") ? rg_n42444 : rg_n42447);
        rg_n42451.rg_n42468 = rg_n42447;
        rg_n42451.rg_n42469 = rg_n42448;
        hsh.Java.jb.rg_n37113.rg_n37117 (rg_n42456, rg_n42451);
        if (rg_n42449)
        {
            if (rg_n42457 == -1)
            {
                rg_n42457 = rg_n42455.rg_n44542 ();
                rg_n42458 = rg_n42457;
                rg_n42455.rg_n44495 (rg_n42446, rg_n42447, rg_n42448, "", hsh.anzh.jb.rg_n7843.rg_n7846, rg_n42450, -1, null, true);
            }
            else
            {
                rg_n42455.rg_n44495 (rg_n42443, rg_n42444, rg_n42445, "", hsh.anzh.jb.rg_n7843.rg_n7846, rg_n42450, -1, null, true);
            }
        }
        else
        {
            rg_n42455.rg_n44495 (rg_n42443, rg_n42444, rg_n42445, "", hsh.anzh.jb.rg_n7843.rg_n7846, rg_n42450, -1, null, true);
        }
        rg_n42455.rg_n44375 (rg_n42455.rg_n44542 ());
    }

    protected void rg_n4112 (android.content.Context rg_n42460, java.lang.Object rg_n42461) {
        super.rg_n4112 (rg_n42460, rg_n42461);
        rg_n42455 = anzh.mmmk.lbzj.rg_n44369.sNewInstance (this.GetView ().getContext (), null);
        rg_n42455.rl_n44369_n44549 (new anzh.mmmk.lbzj.rg_n44369.re_n44549 () {
            public int dispatch (anzh.mmmk.lbzj.rg_n44369 objSource, int nTagNumber, int rg_n44550, String rg_n44551, String rg_n44552, anzh.mmmk.lbzj.rg_n44610 rg_n44553, hsh.anzh.jb.rg_n6158 rg_n44554) {
                return rg_n42380 (objSource, nTagNumber, rg_n44550, rg_n44551, rg_n44552, rg_n44553, rg_n44554);
            }
        }, 0);
        rg_n42455.rl_n44369_n44555 (new anzh.mmmk.lbzj.rg_n44369.re_n44555 () {
            public int dispatch (anzh.mmmk.lbzj.rg_n44369 objSource, int nTagNumber, int rg_n44556, String rg_n44557, String rg_n44558, anzh.mmmk.lbzj.rg_n44610 rg_n44559, hsh.anzh.jb.rg_n6158 rg_n44560) {
                return rg_n42392 (objSource, nTagNumber, rg_n44556, rg_n44557, rg_n44558, rg_n44559, rg_n44560);
            }
        }, 0);
        rg_n5482 (hsh.anzh.jb.rg_n7843.rg_n7855);
        rg_n42459 = hsh.anzh.jb.rg_n7044.sNewInstance (this.GetView ().getContext (), null);
        rg_n42459.rg_n5480 (rg_n42462);
        rg_n6032 ().rg_n6160 (hsh.anzh.jb.rg_n6150.rg_n6152);
        rg_n6032 ().rg_n5745 (rg_n42459, null);
        rg_n42459.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, (int)hsh.anzh.jb.rg_n12424.rg_n12465 (4));
        rg_n6032 ().rg_n5745 (rg_n42455, null);
        rg_n42455.rg_n44590 = false;
        rg_n42455.rg_n44574 = true;
        rg_n42455.rg_n44388 (false);
        rg_n42455.rg_n44410 (30, 30, false);
        rg_n42455.rg_n44414 (2, 2, false);
    }
}
