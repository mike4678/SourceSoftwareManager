
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class AndroidViewGroup extends AndroidView {

    public AndroidViewGroup ()  { }

    public AndroidViewGroup (android.content.Context context, ViewGroup view, Object objInitData) { super (context, view, objInitData); }
    public AndroidViewGroup (android.content.Context context, ViewGroup view) { this (context, view, null); }
    public ViewGroup GetViewGroup () { return (ViewGroup)GetView (); }
    public static AndroidViewGroup sNewInstance (android.content.Context context) {
        return null;
    }
    public static AndroidViewGroup sNewInstance (android.content.Context context, Object objInitData) {
        return null;
    }

    public void rg_n5745 (AndroidView rg_n5746, AndroidView rg_n5747) {
        final ViewGroup vg = GetViewGroup ();
        final View viewAdd = rg_n5746.GetView ();
        final int nIndex = (rg_n5747 == null ? -1 : vg.indexOfChild (rg_n5747.GetView ()));
        if (rg_n2195.sIsUiThread ()) {
            try {
                if (nIndex < 0)
                    vg.addView (viewAdd);
                else
                    vg.addView (viewAdd, nIndex);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        if (nIndex < 0)
                                vg.addView (viewAdd);
                            else
                                vg.addView (viewAdd, nIndex);
                    } catch (Exception e) { }
                } } );
        }
    }
}
