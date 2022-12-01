
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n7265 extends rg_n7044 {

    public rg_n7265 ()  { }

    public rg_n7265 (android.content.Context context, Button view, Object objInitData) { super (context, view, objInitData); }
    public rg_n7265 (android.content.Context context, Button view) { this (context, view, null); }
    public Button GetButton () { return (Button)GetView (); }
    public static rg_n7265 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new Button (context), null);
    }
    public static rg_n7265 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new Button (context), objInitData);
    }
    public static rg_n7265 sNewInstanceAndAttachView (android.content.Context context, Button viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n7265 sNewInstanceAndAttachView (android.content.Context context, Button viewAttach, Object objInitData) {
        rg_n7265 objControl = new rg_n7265 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    protected void OnInitView (android.content.Context context, Object objInitData) {
        super.OnInitView (context, objInitData);
        rg_n5260 (true);
    }
}
