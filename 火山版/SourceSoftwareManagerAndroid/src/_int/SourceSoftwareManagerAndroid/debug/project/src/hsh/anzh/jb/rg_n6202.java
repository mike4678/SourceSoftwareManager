
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n6202 extends AndroidViewGroup {

    public rg_n6202 ()  { }

    public rg_n6202 (android.content.Context context, FrameLayout view, Object objInitData) { super (context, view, objInitData); }
    public rg_n6202 (android.content.Context context, FrameLayout view) { this (context, view, null); }
    public FrameLayout GetFrameLayout () { return (FrameLayout)GetView (); }
    public static rg_n6202 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new FrameLayout (context), null);
    }
    public static rg_n6202 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new FrameLayout (context), objInitData);
    }
    public static rg_n6202 sNewInstanceAndAttachView (android.content.Context context, FrameLayout viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n6202 sNewInstanceAndAttachView (android.content.Context context, FrameLayout viewAttach, Object objInitData) {
        rg_n6202 objControl = new rg_n6202 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    private AndroidLayout m_objLayout;
    public AndroidLayout SetLayoutContent (AndroidLayout objLayout, boolean blListenWindowAttachState, Object objUserData1, Object objUserData2) {
        m_objLayout = objLayout.initAndAddIntoViewGroup (this, blListenWindowAttachState, null, objUserData1, objUserData2, true);
        return m_objLayout;
    }

    public void rg_n6210 (final AndroidView rg_n6211, int rg_n6212, int rg_n6213) {
        ViewGroup.LayoutParams pmLayout = rg_n6211.GetView ().getLayoutParams ();
        if (pmLayout instanceof FrameLayout.LayoutParams) {
            FrameLayout.LayoutParams pm = (FrameLayout.LayoutParams)pmLayout;
            final int nNewGravity = (rg_n6212 | rg_n6213);
            if (pm.gravity != nNewGravity) {
                pm.gravity = nNewGravity;
                final FrameLayout.LayoutParams pmNew = pm;
                if (rg_n2195.sIsUiThread ()) {
                    try {
                        rg_n6211.GetView ().setLayoutParams (pmNew);
                    } catch (Exception e) { }
                } else {
                    rg_n2195.sRunOnUiThread (new Runnable () {
                        @Override public void run () {
                            try {
                                rg_n6211.GetView ().setLayoutParams (pmNew);
                            } catch (Exception e) { }
                        } } );
                }
            } }
    }
}
