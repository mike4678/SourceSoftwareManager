
package hsh.anzh.zj;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n21610 extends hsh.anzh.jb.AndroidView {

    public rg_n21610 ()  { }

    public rg_n21610 (android.content.Context context, rg_n21609 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n21610 (android.content.Context context, rg_n21609 view) { this (context, view, null); }
    public rg_n21609 GetUserGuide () { return (rg_n21609)GetView (); }
    public static rg_n21610 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n21609 (context), null);
    }
    public static rg_n21610 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n21609 (context), objInitData);
    }
    public static rg_n21610 sNewInstanceAndAttachView (android.content.Context context, rg_n21609 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n21610 sNewInstanceAndAttachView (android.content.Context context, rg_n21609 viewAttach, Object objInitData) {
        rg_n21610 objControl = new rg_n21610 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public void setHighLightView(final hsh.anzh.jb.AndroidView... views){
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetUserGuide().setHighLightView(views);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetUserGuide().setHighLightView(views);
                    } catch (Exception e) { }
                } } );
        }
    }

    public boolean rg_n21677 () {
        return GetUserGuide().isListener();
    }
}
