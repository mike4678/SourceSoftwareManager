
package source.SoftwareManagerAndroid;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n15 extends hsh.anzh.jb.rg_n1705 {

    public rg_n15 ()  { }

    protected anzh.mmmk.chkzj.rg_n42470 rg_n16;
    protected hsh.anzh.wl.HPSocket.rg_n25752 rg_n17 = new hsh.anzh.wl.HPSocket.rg_n25752 ();
    protected hsh.anzh.jb.rg_n6072 rg_n18;
    protected hsh.anzh.jb.rg_n7265 rg_n19;
    protected static final int rg_n20 = R.drawable.a1;
    protected static final int rg_n21 = R.drawable.a2;
    protected static final int rg_n22 = R.drawable.b1;
    protected static final int rg_n23 = R.drawable.b2;
    protected static final int rg_n24 = R.drawable.c1;
    protected static final int rg_n25 = R.drawable.c2;
    protected static final int rg_n26 = R.drawable.d1;
    protected static final int rg_n27 = R.drawable.d2;
    protected static final int rg_n28 = -12206054;
    protected anzh.mmmk.lbzj.rg_n43536 rg_n71;

    {
        rg_n17.rg_n25678 (3000);
        rg_n17.rg_n25718 (3000);
        rg_n17.rg_n25746 (102400);
        rg_n17.rg_n25715 (102400);
    }

    {
        rg_n17.rl_n25646_n25699 (new hsh.anzh.wl.HPSocket.rg_n25646.re_n25699 () {
            public int dispatch (hsh.anzh.wl.HPSocket.rg_n25646 objSource, int nTagNumber, int rg_n25700, int rg_n25701) {
                return rg_n44 ((hsh.anzh.wl.HPSocket.rg_n25752)objSource, nTagNumber, rg_n25700, rg_n25701);
            }
        }, 0);
        rg_n17.rl_n25646_n25702 (new hsh.anzh.wl.HPSocket.rg_n25646.re_n25702 () {
            public int dispatch (hsh.anzh.wl.HPSocket.rg_n25646 objSource, int nTagNumber) {
                return rg_n49 ((hsh.anzh.wl.HPSocket.rg_n25752)objSource, nTagNumber);
            }
        }, 0);
        rg_n17.rl_n25646_n25704 (new hsh.anzh.wl.HPSocket.rg_n25646.re_n25704 () {
            public int dispatch (hsh.anzh.wl.HPSocket.rg_n25646 objSource, int nTagNumber) {
                return rg_n52 ((hsh.anzh.wl.HPSocket.rg_n25752)objSource, nTagNumber);
            }
        }, 0);
        rg_n17.rl_n25646_n25705 (new hsh.anzh.wl.HPSocket.rg_n25646.re_n25705 () {
            public int dispatch (hsh.anzh.wl.HPSocket.rg_n25646 objSource, int nTagNumber, byte [] rg_n25706) {
                return rg_n55 ((hsh.anzh.wl.HPSocket.rg_n25752)objSource, nTagNumber, rg_n25706);
            }
        }, 0);
        rg_n17.rl_n25646_n25707 (new hsh.anzh.wl.HPSocket.rg_n25646.re_n25707 () {
            public int dispatch (hsh.anzh.wl.HPSocket.rg_n25646 objSource, int nTagNumber, int rg_n25708, byte [] rg_n25709) {
                return rg_n59 ((hsh.anzh.wl.HPSocket.rg_n25752)objSource, nTagNumber, rg_n25708, rg_n25709);
            }
        }, 0);
    }

    protected hsh.anzh.jb.rg_n6158 rp_2;
    @Override public hsh.anzh.jb.AndroidViewGroup GetAndroidActivityContainer () {
        return rp_2;
    }

    @Override
    protected boolean onInitAndroidActivity () {
        if (super.onInitAndroidActivity () == false)
            return false;

        setContentView (R.layout.rg_n15);
        rp_2 = new hsh.anzh.jb.rg_n6158 (this, (LinearLayout)findViewById (R.id.rg_n15));
        rp_2.onInitControlContent (this, null);

        hsh.anzh.jb.AndComActivity.rg_n4490 (this, hsh.anzh.jb.rg_n7843.rg_n7848);
        rg_n16 = new anzh.mmmk.chkzj.rg_n42470 (this, (anzh.mmmk.chkzj.rg_n42319)findViewById (R.id.rg_n16));
        rg_n16.onInitControlContent (this, null);
        rg_n16.rg_n42544 (true);
        rg_n18 = new hsh.anzh.jb.rg_n6072 (this, (ImageView)findViewById (R.id.rg_n18));
        rg_n18.onInitControlContent (this, null);
        rg_n19 = new hsh.anzh.jb.rg_n7265 (this, (Button)findViewById (R.id.rg_n19));
        rg_n19.onInitControlContent (this, null);
        rg_n19.rg_n7064 ("这是一个新窗口");
        return true;
    }

    public void rg_n8 (android.content.Intent rg_n29, java.lang.Object [] rg_n30, int rg_n31) {
        super.rg_n8 (rg_n29, rg_n30, rg_n31);
        cat.ereza.customactivityoncrash.CustomActivityOnCrash.install(hsh.anzh.jb.rg_n2195.sGetApp ());
        rg_n16.rg_n42486 (rg_n21, "软件管理", hsh.anzh.jb.rg_n7843.rg_n7844, rg_n20, "", rg_n28, true, rg_n72 (), 0);
        rg_n16.rg_n42486 (rg_n23, "已安装管理", hsh.anzh.jb.rg_n7843.rg_n7844, rg_n22, "", rg_n28, true, rg_n75 ("已安装管理"), 0);
        rg_n16.rg_n42486 (rg_n25, "意见建议", hsh.anzh.jb.rg_n7843.rg_n7844, rg_n24, "", rg_n28, true, rg_n79 ("意见建议"), 0);
        rg_n16.rg_n42486 (rg_n27, "关于", hsh.anzh.jb.rg_n7843.rg_n7844, rg_n26, "", rg_n28, true, rg_n83 ("关于"), 0);
    }

    protected void rg_n32 (String rg_n33, String rg_n34) {
        String rg_n35;
        rg_n35 = "@system|{\"type\":\"" + rg_n33 + "\",\"data\":\"" + rg_n34 + "\"}#Succ";
        hsh.anzh.jb.rg_n14019.dbg_log (("Send Message Length:" + String.valueOf (rg_n35.length ())), "");
        hsh.anzh.jb.rg_n14019.dbg_log (("Send Message:" + rg_n35), "");
        rg_n17.rg_n25658 (hsh.Java.jb.rg_n35692.rg_n35771 (rg_n35, hsh.Java.jb.rg_n35646.rg_n35652), -1);
    }

    protected void rg_n36 (byte [] rg_n37) {
        java.util.ArrayList<java.lang.Byte> rg_n38 = new java.util.ArrayList<java.lang.Byte> ();
        int rg_n39;
        String rg_n40;
        String rg_n41;
        String rg_n42;
        rg_n39 = (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).size());
        rg_n40 = hsh.Java.jb.rg_n35692.rg_n35713 (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).get (0));
        if (rg_n39 > 2)
        {
        }
        if (rg_n40.equals ("system"))
        {
            rg_n41 = (hsh.Java.gn.JSON.rg_n41171.rg_n41176 (hsh.Java.jb.rg_n35692.rg_n35719 (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).get (1), "GBK")).optString("type", ""));
            if (rg_n41.equals ("Downloadlink"))
            {
                rg_n65 (hsh.Java.gn.JSON.rg_n41171.rg_n41176 (hsh.Java.jb.rg_n35692.rg_n35719 (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).get (1), "GBK")).optString("msg", ""));
            }
            if (rg_n41.equals ("softwarelist"))
            {
                rg_n42 = (hsh.Java.gn.JSON.rg_n41171.rg_n41176 (hsh.Java.jb.rg_n35692.rg_n35719 (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).get (1), "GBK")).optString("data", ""));
                hsh.anzh.jb.rg_n14019.rg_n14027 (rg_n42);
                rg_n67 ("NULL");
            }
            if (rg_n41.equals ("type"))
            {
                rg_n65 (hsh.Java.gn.JSON.rg_n41171.rg_n41176 (hsh.Java.jb.rg_n35692.rg_n35719 (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).get (1), "GBK")).optString("data", ""));
            }
        }
        if (rg_n40.equals ("logo"))
        {
            rg_n18.rg_n6110 (android.graphics.drawable.Drawable.createFromStream (new java.io.ByteArrayInputStream (hsh.Java.jb.rg_n32268.rg_n32269 (hsh.Java.shjcz.ysjy.rg_n41765.rg_n41775 (rg_n37),  "#data#".getBytes ()).get (1)), ""));
        }
    }

    public void rg_n43 () {
        rg_n64 ();
    }

    protected int rg_n44 (hsh.anzh.wl.HPSocket.rg_n25752 rg_n45, int rg_n46, int rg_n47, int rg_n48) {
        if (rg_n47 == hsh.anzh.wl.HPSocket.rg_n25760.rg_n25766)
        {
        }
        else if (rg_n47 == hsh.anzh.wl.HPSocket.rg_n25760.rg_n25765)
        {
        }
        return (0);
    }

    protected int rg_n49 (hsh.anzh.wl.HPSocket.rg_n25752 rg_n50, int rg_n51) {
        return (0);
    }

    protected int rg_n52 (hsh.anzh.wl.HPSocket.rg_n25752 rg_n53, int rg_n54) {
        return (0);
    }

    protected int rg_n55 (hsh.anzh.wl.HPSocket.rg_n25752 rg_n56, int rg_n57, byte [] rg_n58) {
        return (0);
    }

    protected int rg_n59 (hsh.anzh.wl.HPSocket.rg_n25752 rg_n60, int rg_n61, int rg_n62, byte [] rg_n63) {
        rg_n36 (rg_n63);
        return (0);
    }

    protected void rg_n64 () {
        if (rg_n17.rg_n25647 ("service.csource.com.cn", (short)hsh.Java.jb.rg_n35692.rg_n35701 ("7777"), false) == false)
        {
            hsh.anzh.rg_n32151.rg_n32159 ("连接服务器失败！", false);
            System.exit (0);
        }
        rg_n32 ("logo", "");
        rg_n32 ("typelist", "");
        rg_n32 ("softwarelist", "");
    }

    protected void rg_n65 (String rg_n66) {
    }

    protected void rg_n67 (String rg_n68) {
        hsh.anzh.jb.rg_n14019.dbg_log (rg_n68, "");
        hsh.anzh.jb.rg_n14019.dbg_log ((hsh.Java.gn.JSON.rg_n41171.rg_n41176 (rg_n68).optString("synopsis", "")), "");
    }

    protected hsh.anzh.jb.rg_n6158 rg_n72 () {
        hsh.anzh.jb.rg_n6158 rg_n73 = new hsh.anzh.jb.rg_n6158 (this, new LinearLayout (this));
        rg_n73.onInitControlContent (this, null);
        rg_n71 = anzh.mmmk.lbzj.rg_n43536.sNewInstance (this, null);
        rg_n73.rg_n5745 (rg_n71, null);
        rg_n71.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        int rg_n74 = 0;
        for (rg_n74 = 0; rg_n74 < 3; rg_n74++)
        {
            rg_n71.rg_n43730 ("http://q1.qlogo.cn/g?b=qq&nk=8592101&s=100", "飞翔的企鹅", "测试信息", 0xFF8C8C8C, "信息2", 0xFFB2B2B2, "按钮", hsh.anzh.jb.rg_n7843.rg_n7845, -1, null, false, "");
        }
        rg_n71.rg_n43744 ();
        return (rg_n73);
    }

    protected hsh.anzh.jb.rg_n6158 rg_n75 (String rg_n76) {
        hsh.anzh.jb.rg_n6158 rg_n77 = new hsh.anzh.jb.rg_n6158 (this, new LinearLayout (this));
        rg_n77.onInitControlContent (this, null);
        rg_n77.rg_n6176 (hsh.anzh.jb.rg_n6128.rg_n6132);
        rg_n77.rg_n6178 (hsh.anzh.jb.rg_n6141.rg_n6145);
        hsh.anzh.jb.rg_n7044 rg_n78 = new hsh.anzh.jb.rg_n7044 (this, new TextView (this));
        rg_n78.onInitControlContent (this, null);
        rg_n78.rg_n7127 (hsh.anzh.jb.rg_n6128.rg_n6132);
        rg_n78.rg_n7129 (hsh.anzh.jb.rg_n6141.rg_n6145);
        rg_n77.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        rg_n77.rg_n5745 (rg_n78, null);
        rg_n78.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        rg_n78.rg_n7114 (22);
        rg_n78.rg_n7120 (hsh.anzh.jb.rg_n7843.rg_n7844);
        rg_n78.rg_n7064 (rg_n76);
        return (rg_n77);
    }

    protected hsh.anzh.jb.rg_n6158 rg_n79 (String rg_n80) {
        hsh.anzh.jb.rg_n6158 rg_n81 = new hsh.anzh.jb.rg_n6158 (this, new LinearLayout (this));
        rg_n81.onInitControlContent (this, null);
        rg_n81.rg_n6176 (hsh.anzh.jb.rg_n6128.rg_n6132);
        rg_n81.rg_n6178 (hsh.anzh.jb.rg_n6141.rg_n6145);
        hsh.anzh.jb.rg_n7044 rg_n82 = new hsh.anzh.jb.rg_n7044 (this, new TextView (this));
        rg_n82.onInitControlContent (this, null);
        rg_n82.rg_n7127 (hsh.anzh.jb.rg_n6128.rg_n6132);
        rg_n82.rg_n7129 (hsh.anzh.jb.rg_n6141.rg_n6145);
        rg_n81.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        rg_n81.rg_n5745 (rg_n82, null);
        rg_n82.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        rg_n82.rg_n7114 (22);
        rg_n82.rg_n7120 (hsh.anzh.jb.rg_n7843.rg_n7844);
        rg_n82.rg_n7064 (rg_n80);
        return (rg_n81);
    }

    protected hsh.anzh.jb.rg_n6158 rg_n83 (String rg_n84) {
        hsh.anzh.jb.rg_n6158 rg_n85 = new hsh.anzh.jb.rg_n6158 (this, new LinearLayout (this));
        rg_n85.onInitControlContent (this, null);
        rg_n85.rg_n6176 (hsh.anzh.jb.rg_n6128.rg_n6132);
        rg_n85.rg_n6178 (hsh.anzh.jb.rg_n6141.rg_n6145);
        hsh.anzh.jb.rg_n7044 rg_n86 = new hsh.anzh.jb.rg_n7044 (this, new TextView (this));
        rg_n86.onInitControlContent (this, null);
        rg_n86.rg_n7127 (hsh.anzh.jb.rg_n6128.rg_n6132);
        rg_n86.rg_n7129 (hsh.anzh.jb.rg_n6141.rg_n6145);
        rg_n85.rg_n5533 (hsh.anzh.jb.AndroidView.rg_n5525, hsh.anzh.jb.AndroidView.rg_n5525);
        rg_n85.rg_n5745 (rg_n18, null);
        rg_n85.rg_n5745 (rg_n86, null);
        rg_n18.rg_n5533 (240, 120);
        rg_n86.rg_n5533 (240, 120);
        rg_n86.rg_n7114 (18);
        rg_n86.rg_n7120 (hsh.anzh.jb.rg_n7843.rg_n7844);
        rg_n86.rg_n7064 ("Source 软件管家" + anzh.mmmk.jbshjlx.rg_n46235.rg_n46643 (1, true) + "版权所有(C)2009 - 2023 Source Inc." + anzh.mmmk.jbshjlx.rg_n46235.rg_n46643 (1, true) + "http://bbs.csource.com.cn");
        return (rg_n85);
    }
}
