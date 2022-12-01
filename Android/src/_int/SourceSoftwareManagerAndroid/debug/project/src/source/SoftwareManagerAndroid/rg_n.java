
package source.SoftwareManagerAndroid;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n extends hsh.anzh.jb.rg_n1705 {

    public rg_n ()  { }

    protected hsh.anzh.zj.zl.rg_n16524 rg_n1;
    protected hsh.anzh.jb.rg_n7044 rg_n2;
    protected hsh.anzh.jb.rg_n14035 rg_n3 = new hsh.anzh.jb.rg_n14035 ();
    protected static final String rg_n4 = "<. android:theme = \"@style/Theme.AppCompat.Splash\" />";

    {
        rg_n3.rg_n14037 = 1000;
    }

    {
        rg_n3.rl_n14035_n14036 (new hsh.anzh.jb.rg_n14035.re_n14036 () {
            public int dispatch (hsh.anzh.jb.rg_n14035 objSource, int nTagNumber) {
                return rg_n12 (objSource, nTagNumber);
            }
        }, 0);
    }

    protected hsh.anzh.jb.rg_n6158 rp_1;
    @Override public hsh.anzh.jb.AndroidViewGroup GetAndroidActivityContainer () {
        return rp_1;
    }

    @Override
    protected boolean onInitAndroidActivity () {
        if (super.onInitAndroidActivity () == false)
            return false;

        setContentView (R.layout.rg_n);
        rp_1 = new hsh.anzh.jb.rg_n6158 (this, (LinearLayout)findViewById (R.id.rg_n));
        rp_1.onInitControlContent (this, null);

        hsh.anzh.jb.AndComActivity.rg_n4490 (this, hsh.anzh.jb.rg_n7843.rg_n7848);
        rg_n1 = new hsh.anzh.zj.zl.rg_n16524 (this, (hsh.anzh.zj.zl.rg_n16523)findViewById (R.id.rg_n1));
        rg_n1.onInitControlContent (this, null);
        rg_n1.rg_n16540 (0xE6FFFFFF);
        rg_n2 = new hsh.anzh.jb.rg_n7044 (this, (TextView)findViewById (R.id.rg_n2));
        rg_n2.onInitControlContent (this, null);
        rg_n2.rg_n5260 (true);
        rg_n2.rg_n7064 ("跳过(2)");
        rg_n2.rg_n7120 (0xFF222222);
        rg_n2.rl_AndroidView_n5238 (new hsh.anzh.jb.AndroidView.re_n5238 () {
            public int dispatch (hsh.anzh.jb.AndroidView objSource, int nTagNumber) {
                return rg_n5 ((hsh.anzh.jb.rg_n7044)objSource, nTagNumber);
            }
        }, 0);
        return true;
    }

    protected int rg_n5 (hsh.anzh.jb.rg_n7044 rg_n6, int rg_n7) {
        if (rg_n6 == rg_n2)
        {
            rg_n3.rg_n14044 ();
            hsh.anzh.jb.AndComActivity.sStartNewActivity (this, rg_n15.class, null, 0, 0);
            hsh.anzh.jb.AndComActivity.rg_n4563 (this);
        }
        return (0);
    }

    public void rg_n8 (android.content.Intent rg_n9, java.lang.Object [] rg_n10, int rg_n11) {
        super.rg_n8 (rg_n9, rg_n10, rg_n11);
        cat.ereza.customactivityoncrash.CustomActivityOnCrash.install(hsh.anzh.jb.rg_n2195.sGetApp ());
        rg_n3.rg_n14043 ();
    }

    protected int rg_n12 (hsh.anzh.jb.rg_n14035 rg_n13, int rg_n14) {
        if (rg_n13 == rg_n3)
        {
            if (rg_n13.rg_n14039 () == 2)
            {
                rg_n2.rg_n7064 ("跳过");
                rg_n3.rg_n14044 ();
                hsh.anzh.jb.AndComActivity.sStartNewActivity (this, rg_n15.class, null, 0, 0);
                hsh.anzh.jb.AndComActivity.rg_n4563 (this);
            }
            else
            {
                rg_n2.rg_n7064 ("跳过(" + String.valueOf (2 - rg_n13.rg_n14039 ()) + ")");
            }
        }
        return (0);
    }
}
