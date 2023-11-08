
package anzh.mmmk.lbzj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n43536 extends hsh.anzh.zj.gjlbk.rg_n19032 {

    public rg_n43536 ()  { }

    public rg_n43536 (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n43536 (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 view) { this (context, view, null); }
    public hsh.anzh.zj.gjlbk.rg_n19031 Getvol_WuMingLieBiaoKuang () { return (hsh.anzh.zj.gjlbk.rg_n19031)GetView (); }
    public static rg_n43536 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.zj.gjlbk.rg_n19031 (context), null);
    }
    public static rg_n43536 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new hsh.anzh.zj.gjlbk.rg_n19031 (context), objInitData);
    }
    public static rg_n43536 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n43536 sNewInstanceAndAttachView (android.content.Context context, hsh.anzh.zj.gjlbk.rg_n19031 viewAttach, Object objInitData) {
        rg_n43536 objControl = new rg_n43536 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public boolean rg_n43537 = false;
    public double rg_n43538 = 2;
    public double rg_n43539 = 2;
    public double rg_n43540 = 0;
    public double rg_n43541 = 5;
    public boolean rg_n43542 = true;
    public int rg_n43543;
    public int rg_n43544;
    public boolean rg_n43545 = false;
    public int rg_n43546 = -1118482;
    public int rg_n43547 = hsh.anzh.jb.rg_n7843.rg_n7847;
    public int rg_n43548 = hsh.anzh.jb.rg_n7843.rg_n7855;
    public int rg_n43549 = 1;
    public int rg_n43550 = 14;
    public int rg_n43551 = 16;
    public int rg_n43552 = hsh.anzh.rg_n16635.rg_n16637;
    public int rg_n43553 = hsh.anzh.jb.rg_n7843.rg_n7844;
    public int rg_n43554 = hsh.anzh.jb.rg_n7843.rg_n7846;
    public boolean rg_n43555 = true;
    public int rg_n43556 = 1;
    public double rg_n43557 = 14;
    public double rg_n43558 = 12;
    public double rg_n43559 = 12;
    public double rg_n43560 = 0.5;
    public int rg_n43561 = hsh.anzh.jb.rg_n6064.rg_n6065;
    protected boolean rg_n43564 = false;
    protected rg_n43976 rg_n43886 = new rg_n43976 ();
    protected hsh.anzh.zj.gjlbk.rg_n19497 rg_n43887 = new hsh.anzh.zj.gjlbk.rg_n19497 ();
    protected hsh.anzh.zj.gjlbk.rg_n19340 rg_n43888 = new hsh.anzh.zj.gjlbk.rg_n19340 ();
    protected rg_n43907 rg_n43889 = new rg_n43907 ();
    protected hsh.anzh.zj.gjlbk.rg_n19360 rg_n43890 = new hsh.anzh.zj.gjlbk.rg_n19360 ();
    protected hsh.anzh.jb.rg_n7044 rg_n43891;

    {
        rg_n43887.rg_n19473 (0);
        rg_n43887.rg_n19479 (0);
        rg_n43887.rg_n19476 (0);
        rg_n43887.rg_n19470 (0);
        rg_n43888.rg_n19342 (hsh.anzh.jb.rg_n6150.rg_n6152);
        rg_n43888.rg_n19349 (true);
        hsh.anzh.zj.gjlbk.rg_n19360.rg_n19371 (rg_n43890, hsh.anzh.jb.rg_n6150.rg_n6152);
    }

    {
        rl_n19032_n19049 (new hsh.anzh.zj.gjlbk.rg_n19032.re_n19049 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19032 objSource, int nTagNumber, int rg_n19050, int rg_n19051) {
                return rg_n43875 (objSource, nTagNumber, rg_n19050, rg_n19051);
            }
        }, 0);
        rl_n19032_n19033 (new hsh.anzh.zj.gjlbk.rg_n19032.re_n19033 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19032 objSource, int nTagNumber, hsh.anzh.jb.AndroidView rg_n19034) {
                return rg_n43880 (objSource, nTagNumber, rg_n19034);
            }
        }, 0);
        rg_n43890.rl_n19360_n19362 (new hsh.anzh.zj.gjlbk.rg_n19360.re_n19362 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19360 objSource, int nTagNumber, android.graphics.Canvas rg_n19363, hsh.anzh.zj.gjlbk.rg_n19032 rg_n19364, android.support.v7.widget.RecyclerView.State rg_n19365) {
                return rg_n43894 (objSource, nTagNumber, rg_n19363, rg_n19364, rg_n19365);
            }
        }, 0);
    }

    public int rg_n43567 () {
        return (rg_n43889.rg_n43915);
    }

    public boolean rg_n43579 () {
        return (rg_n43889.rg_n43914);
    }

    protected int rg_n43603 (hsh.Java.jb.rg_n36080 rg_n43604, int rg_n43605, java.lang.Object rg_n43606, java.lang.Object rg_n43607) {
        com.bumptech.glide.Glide.get(rg_n5581 ()).clearDiskCache();
        return (0);
    }

    public void rg_n43730 (String rg_n43731, String rg_n43732, String rg_n43733, int rg_n43734, String rg_n43735, int rg_n43736, String rg_n43737, int rg_n43738, int rg_n43739, java.lang.Object rg_n43740, boolean rg_n43741, String rg_n43742) {
        rg_n43962 rg_n43743 = new rg_n43962 ();
        if (rg_n43731.startsWith ((android.os.Environment.getExternalStorageDirectory ().getPath ()), 0) == true || rg_n43731.startsWith (anzh.mmmk.wjmlcz.rg_n46134.rg_n46175 (), 0) == true)
        {
            rg_n43743.rg_n43966 = anzh.mmmk.txchl.rg_n44889.rg_n44900 (rg_n43731);
        }
        else if ((rg_n43731.toUpperCase ().startsWith ("HTTP://", 0)) == false && (rg_n43731.toUpperCase ().startsWith ("HTTPS://", 0)) == false)
        {
            rg_n43743.rg_n43966 = anzh.mmmk.wjmlcz.rg_n45829.rg_n45850 (rg_n43731);
        }
        else if ((rg_n43731.toUpperCase ().startsWith ("HTTP://", 0)) == true || (rg_n43731.toUpperCase ().startsWith ("HTTPS://", 0)) == true)
        {
            rg_n43743.rg_n43966 = (Object)rg_n43731;
        }
        rg_n43743.rg_n43967 = rg_n43732;
        rg_n43743.rg_n43969 = rg_n43733;
        rg_n43743.rg_n43970 = rg_n43734;
        rg_n43743.rg_n43971 = rg_n43735;
        rg_n43743.rg_n43972 = rg_n43736;
        rg_n43743.rg_n43973 = rg_n43737;
        rg_n43743.rg_n43974 = rg_n43738;
        rg_n43743.rg_n43965 = rg_n43740;
        rg_n43743.rg_n43975 = rg_n43742;
        rg_n43886.rg_n19552 (rg_n43743, rg_n43739, rg_n43741);
    }

    public void rg_n43744 () {
        rg_n43886.rg_n19558 ();
    }

    public static interface re_n43827 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43828, boolean rg_n43829, int rg_n43830, int [] rg_n43831, rg_n43962 rg_n43832); }
    private re_n43827 rd_n43827;
    private int rd_n43827_tag;
    public void rl_n43536_n43827 (re_n43827 objListener, int nTagNumber) {
        synchronized (this) { rd_n43827 = objListener;  rd_n43827_tag = nTagNumber; }
    }
    public int rg_n43827 (int rg_n43828, boolean rg_n43829, int rg_n43830, int [] rg_n43831, rg_n43962 rg_n43832) {
        re_n43827 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43827;  nTagNumber = rd_n43827_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43828, rg_n43829, rg_n43830, rg_n43831, rg_n43832) : 0);
    }

    public static interface re_n43833 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43834, String rg_n43835, String rg_n43836, rg_n43962 rg_n43837, hsh.anzh.rg_n16552 rg_n43838, hsh.anzh.jb.rg_n6158 rg_n43839); }
    private re_n43833 rd_n43833;
    private int rd_n43833_tag;
    public void rl_n43536_n43833 (re_n43833 objListener, int nTagNumber) {
        synchronized (this) { rd_n43833 = objListener;  rd_n43833_tag = nTagNumber; }
    }
    public int rg_n43833 (int rg_n43834, String rg_n43835, String rg_n43836, rg_n43962 rg_n43837, hsh.anzh.rg_n16552 rg_n43838, hsh.anzh.jb.rg_n6158 rg_n43839) {
        re_n43833 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43833;  nTagNumber = rd_n43833_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43834, rg_n43835, rg_n43836, rg_n43837, rg_n43838, rg_n43839) : 0);
    }

    public static interface re_n43840 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43841, String rg_n43842, String rg_n43843, rg_n43962 rg_n43844, hsh.anzh.jb.rg_n6158 rg_n43845); }
    private re_n43840 rd_n43840;
    private int rd_n43840_tag;
    public void rl_n43536_n43840 (re_n43840 objListener, int nTagNumber) {
        synchronized (this) { rd_n43840 = objListener;  rd_n43840_tag = nTagNumber; }
    }
    public int rg_n43840 (int rg_n43841, String rg_n43842, String rg_n43843, rg_n43962 rg_n43844, hsh.anzh.jb.rg_n6158 rg_n43845) {
        re_n43840 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43840;  nTagNumber = rd_n43840_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43841, rg_n43842, rg_n43843, rg_n43844, rg_n43845) : 0);
    }

    public static interface re_n43846 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43847, String rg_n43848, String rg_n43849, rg_n43962 rg_n43850, hsh.anzh.jb.rg_n6072 rg_n43851, hsh.anzh.jb.rg_n6158 rg_n43852); }
    private re_n43846 rd_n43846;
    private int rd_n43846_tag;
    public void rl_n43536_n43846 (re_n43846 objListener, int nTagNumber) {
        synchronized (this) { rd_n43846 = objListener;  rd_n43846_tag = nTagNumber; }
    }
    public int rg_n43846 (int rg_n43847, String rg_n43848, String rg_n43849, rg_n43962 rg_n43850, hsh.anzh.jb.rg_n6072 rg_n43851, hsh.anzh.jb.rg_n6158 rg_n43852) {
        re_n43846 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43846;  nTagNumber = rd_n43846_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43847, rg_n43848, rg_n43849, rg_n43850, rg_n43851, rg_n43852) : 0);
    }

    public static interface re_n43853 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43854, String rg_n43855, String rg_n43856, rg_n43962 rg_n43857, hsh.anzh.rg_n16552 rg_n43858, hsh.anzh.jb.rg_n6158 rg_n43859); }
    private re_n43853 rd_n43853;
    private int rd_n43853_tag;
    public void rl_n43536_n43853 (re_n43853 objListener, int nTagNumber) {
        synchronized (this) { rd_n43853 = objListener;  rd_n43853_tag = nTagNumber; }
    }
    public int rg_n43853 (int rg_n43854, String rg_n43855, String rg_n43856, rg_n43962 rg_n43857, hsh.anzh.rg_n16552 rg_n43858, hsh.anzh.jb.rg_n6158 rg_n43859) {
        re_n43853 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43853;  nTagNumber = rd_n43853_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43854, rg_n43855, rg_n43856, rg_n43857, rg_n43858, rg_n43859) : 0);
    }

    public static interface re_n43860 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43861, String rg_n43862, String rg_n43863, rg_n43962 rg_n43864, hsh.anzh.jb.rg_n6158 rg_n43865); }
    private re_n43860 rd_n43860;
    private int rd_n43860_tag;
    public void rl_n43536_n43860 (re_n43860 objListener, int nTagNumber) {
        synchronized (this) { rd_n43860 = objListener;  rd_n43860_tag = nTagNumber; }
    }
    public int rg_n43860 (int rg_n43861, String rg_n43862, String rg_n43863, rg_n43962 rg_n43864, hsh.anzh.jb.rg_n6158 rg_n43865) {
        re_n43860 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43860;  nTagNumber = rd_n43860_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43861, rg_n43862, rg_n43863, rg_n43864, rg_n43865) : 0);
    }

    public static interface re_n43866 { int dispatch (rg_n43536 objSource, int nTagNumber, int rg_n43867, String rg_n43868, String rg_n43869, rg_n43962 rg_n43870, hsh.anzh.jb.rg_n6072 rg_n43871, hsh.anzh.jb.rg_n6158 rg_n43872); }
    private re_n43866 rd_n43866;
    private int rd_n43866_tag;
    public void rl_n43536_n43866 (re_n43866 objListener, int nTagNumber) {
        synchronized (this) { rd_n43866 = objListener;  rd_n43866_tag = nTagNumber; }
    }
    public int rg_n43866 (int rg_n43867, String rg_n43868, String rg_n43869, rg_n43962 rg_n43870, hsh.anzh.jb.rg_n6072 rg_n43871, hsh.anzh.jb.rg_n6158 rg_n43872) {
        re_n43866 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43866;  nTagNumber = rd_n43866_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n43867, rg_n43868, rg_n43869, rg_n43870, rg_n43871, rg_n43872) : 0);
    }

    public static interface re_n43873 { int dispatch (rg_n43536 objSource, int nTagNumber); }
    private re_n43873 rd_n43873;
    private int rd_n43873_tag;
    public void rl_n43536_n43873 (re_n43873 objListener, int nTagNumber) {
        synchronized (this) { rd_n43873 = objListener;  rd_n43873_tag = nTagNumber; }
    }
    public int rg_n43873 () {
        re_n43873 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43873;  nTagNumber = rd_n43873_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n43874 { int dispatch (rg_n43536 objSource, int nTagNumber); }
    private re_n43874 rd_n43874;
    private int rd_n43874_tag;
    public void rl_n43536_n43874 (re_n43874 objListener, int nTagNumber) {
        synchronized (this) { rd_n43874 = objListener;  rd_n43874_tag = nTagNumber; }
    }
    public int rg_n43874 () {
        re_n43874 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n43874;  nTagNumber = rd_n43874_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    protected int rg_n43875 (hsh.anzh.zj.gjlbk.rg_n19032 rg_n43876, int rg_n43877, int rg_n43878, int rg_n43879) {
        if ((rg_n43876.GetView ().canScrollVertically (-1)) == false)
        {
            rg_n43873 ();
        }
        else if ((rg_n43876.GetView ().canScrollVertically (1)) == false)
        {
            rg_n43874 ();
        }
        return (0);
    }

    protected int rg_n43880 (hsh.anzh.zj.gjlbk.rg_n19032 rg_n43881, int rg_n43882, hsh.anzh.jb.AndroidView rg_n43883) {
        rg_n43946 rg_n43884 = new rg_n43946 ();
        rg_n43884 = (rg_n43946)hsh.anzh.zj.gjlbk.rg_n19187.rg_n19190 (rg_n19114 (rg_n43883));
        rg_n43884.rg_n43958.rg_n42283 (rg_n43889.rg_n43909);
        rg_n43884.rg_n43958.rg_n42285 (rg_n43889.rg_n43908);
        int rg_n43885;
        rg_n43885 = rg_n19127 (rg_n43883);
        if (rg_n43889.rg_n43910.indexOf (Integer.valueOf (rg_n43885)) != -1)
        {
            if (rg_n43884.rg_n43958.rg_n42301 () != true)
            {
                rg_n43884.rg_n43958.rg_n42299 (true);
            }
        }
        else
        {
            if (rg_n43884.rg_n43958.rg_n42301 () != false)
            {
                rg_n43884.rg_n43958.rg_n42299 (false);
            }
        }
        return (0);
    }

    protected void rg_n4112 (android.content.Context rg_n43892, java.lang.Object rg_n43893) {
        rg_n43536 rp_3 = this;
        rp_3.rl_n19032_n19049 (new hsh.anzh.zj.gjlbk.rg_n19032.re_n19049 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19032 objSource, int nTagNumber, int rg_n19050, int rg_n19051) {
                return rg_n43875 (objSource, nTagNumber, rg_n19050, rg_n19051);
            }
        }, 0);
        rp_3.rl_n19032_n19033 (new hsh.anzh.zj.gjlbk.rg_n19032.re_n19033 () {
            public int dispatch (hsh.anzh.zj.gjlbk.rg_n19032 objSource, int nTagNumber, hsh.anzh.jb.AndroidView rg_n19034) {
                return rg_n43880 (objSource, nTagNumber, rg_n19034);
            }
        }, 0);
        rg_n19072 (rg_n43888);
        rg_n19078 (rg_n43886);
        rg_n19075 (rg_n43887);
        rg_n43891 = hsh.anzh.jb.rg_n7044.sNewInstance (this.GetView ().getContext (), null);
        rg_n5482 (hsh.anzh.jb.rg_n7843.rg_n7848);
        rg_n43555 = false;
        rg_n43889.rg_n43930 = hsh.anzh.jb.rg_n12424.rg_n12465 (60);
        rg_n43889.rg_n43929 = hsh.anzh.jb.rg_n12424.rg_n12465 (30);
        rg_n43889.rg_n43924 = hsh.anzh.jb.rg_n12424.rg_n12465 (50);
        rg_n43889.rg_n43923 = hsh.anzh.jb.rg_n12424.rg_n12465 (50);
        rg_n43886.rg_n43982 (this, rg_n43889);
    }

    protected int rg_n43894 (hsh.anzh.zj.gjlbk.rg_n19360 rg_n43895, int rg_n43896, android.graphics.Canvas rg_n43897, hsh.anzh.zj.gjlbk.rg_n19032 rg_n43898, android.support.v7.widget.RecyclerView.State rg_n43899) {
        int rg_n43900 = 0;
        hsh.anzh.zj.gjlbk.rg_n19203 rg_n43901;
        android.graphics.Paint rg_n43902 = new android.graphics.Paint ();
        hsh.anzh.jb.rg_n3183.rg_n3298 (rg_n43902, true);
        rg_n43901 = rg_n43898.rg_n19074 ();
        if (rg_n43579 ())
        {
            hsh.anzh.jb.rg_n3183.rg_n3195 (rg_n43902, rg_n43567 ());
        }
        else
        {
            hsh.anzh.jb.rg_n3183.rg_n3195 (rg_n43902, hsh.anzh.jb.rg_n7843.rg_n7855);
        }
        for (rg_n43900 = 0; rg_n43900 < (rg_n43898.GetViewGroup ().getChildCount ()); rg_n43900++)
        {
            hsh.anzh.jb.AndroidView rg_n43903;
            int rg_n43904;
            int rg_n43905 = 0;
            rg_n43903 = hsh.anzh.jb.AndroidView.sSafeGetVolView (rg_n43898.GetViewGroup ().getChildAt (rg_n43900));
            rg_n43904 = rg_n43901.rg_n19253 (rg_n43903);
            rg_n43905 = rg_n43901.rg_n19259 (rg_n43903) - rg_n43905;
            int rg_n43906;
            rg_n43906 = (rg_n43903.GetView ().getBottom ()) + rg_n43905;
            rg_n43897.drawRect ((float)rg_n43904, (float)(rg_n43903.GetView ().getBottom ()), (float)(rg_n43903.GetView ().getRight ()), (float)rg_n43906, rg_n43902);
        }
        return (1);
    }
}
