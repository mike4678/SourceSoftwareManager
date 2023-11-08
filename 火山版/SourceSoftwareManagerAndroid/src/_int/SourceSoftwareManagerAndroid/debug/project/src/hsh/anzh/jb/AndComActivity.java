
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class AndComActivity {

    public static final int rg_n4702 = android.R.attr.colorForeground;
    public static final int rg_n4704 = android.R.attr.colorBackground;
    private static final String cs_strActivityLoadParams = "@activity_params";
    public static void sStartNewActivity (final android.content.Context context, final Class clsActivity,
            final android.os.Bundle bundle, final int nRequestCode, final int nAddFlags, final Object... params) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                _sStartNewActivity (context, clsActivity, bundle, nRequestCode, nAddFlags,  params);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        _sStartNewActivity (context, clsActivity, bundle, nRequestCode, nAddFlags,  params);
                    } catch (Exception e) { }
                } } );
        }
    }
    public static boolean _sStartNewActivity (android.content.Context context, Class clsActivity,
            android.os.Bundle bundle, int nRequestCode, int nAddFlags, Object... params) {
        rg_n2262 objCache = rg_n2195.sGetGlobalDataCache ();
        int nParamDataIdentifier = 0;
        try {
            android.content.Intent objIntent = new android.content.Intent (context, clsActivity);
            if (nAddFlags != 0)
                objIntent.addFlags (nAddFlags);
            if (bundle != null)
                objIntent.putExtras (bundle);
            if (params != null && params.length > 0) {
                nParamDataIdentifier = objCache.Push (params);
                objIntent.putExtra (cs_strActivityLoadParams, nParamDataIdentifier);
            }
            if (nRequestCode != 0 && context instanceof android.app.Activity)
                ((android.app.Activity)context).startActivityForResult (objIntent, nRequestCode);
            else
                context.startActivity (objIntent);
            return true;
        } catch (Exception e) { }
        objCache.Remove (nParamDataIdentifier);
        return false;
    }

    public static void rg_n4490 (final android.app.Activity rg_n4491, final int rg_n4492) {
        if (rg_n4491.getWindow () != null)
        {
            if (rg_n2195.sIsUiThread ()) {
                try {
                    rg_n4491.getWindow ().setBackgroundDrawable (new android.graphics.drawable.ColorDrawable (rg_n4492));
                } catch (Exception e) { }
            } else {
                rg_n2195.sRunOnUiThread (new Runnable () {
                    @Override public void run () {
                        try {
                            rg_n4491.getWindow ().setBackgroundDrawable (new android.graphics.drawable.ColorDrawable (rg_n4492));
                        } catch (Exception e) { }
                    } } );
            }
        }
    }

    public static void rg_n4563 (final android.app.Activity rg_n4564) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                rg_n4564.finish ();
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        rg_n4564.finish ();
                    } catch (Exception e) { }
                } } );
        }
    }
}
