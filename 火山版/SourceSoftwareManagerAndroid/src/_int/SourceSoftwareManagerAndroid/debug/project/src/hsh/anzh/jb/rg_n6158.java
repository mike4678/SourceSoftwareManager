
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n6158 extends AndroidViewGroup {

    public rg_n6158 ()  { }

    public rg_n6158 (android.content.Context context, LinearLayout view, Object objInitData) { super (context, view, objInitData); }
    public rg_n6158 (android.content.Context context, LinearLayout view) { this (context, view, null); }
    public LinearLayout GetLinearLayout () { return (LinearLayout)GetView (); }
    public static rg_n6158 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new LinearLayout (context), null);
    }
    public static rg_n6158 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new LinearLayout (context), objInitData);
    }
    public static rg_n6158 sNewInstanceAndAttachView (android.content.Context context, LinearLayout viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n6158 sNewInstanceAndAttachView (android.content.Context context, LinearLayout viewAttach, Object objInitData) {
        rg_n6158 objControl = new rg_n6158 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }

    public void rg_n6160 (final int rg_n6161) {
        if ((this.GetLinearLayout ().getOrientation ()) != rg_n6161)
        {
            if (rg_n2195.sIsUiThread ()) {
                try {
                    GetLinearLayout ().setOrientation (rg_n6161);
                } catch (Exception e) { }
            } else {
                rg_n2195.sRunOnUiThread (new Runnable () {
                    @Override public void run () {
                        try {
                            GetLinearLayout ().setOrientation (rg_n6161);
                        } catch (Exception e) { }
                    } } );
            }
        }
    }

    public void rg_n6176 (final int rg_n6177) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetLinearLayout ().setHorizontalGravity (rg_n6177);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetLinearLayout ().setHorizontalGravity (rg_n6177);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n6178 (final int rg_n6179) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetLinearLayout ().setVerticalGravity (rg_n6179);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetLinearLayout ().setVerticalGravity (rg_n6179);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n6189 (final AndroidView rg_n6190, double rg_n6191) {
        ViewGroup.LayoutParams pmLayout = rg_n6190.GetView ().getLayoutParams ();
        if (pmLayout instanceof LinearLayout.LayoutParams) {
            LinearLayout.LayoutParams pm = (LinearLayout.LayoutParams)pmLayout;
            if (hsh.Java.jb.rg_n33129.rg_n33141 (pm.weight, rg_n6191) == false) {
                pm.weight = (float)rg_n6191;
                final LinearLayout.LayoutParams pmNew = pm;
                if (rg_n2195.sIsUiThread ()) {
                    try {
                        rg_n6190.GetView ().setLayoutParams (pmNew);
                    } catch (Exception e) { }
                } else {
                    rg_n2195.sRunOnUiThread (new Runnable () {
                        @Override public void run () {
                            try {
                                rg_n6190.GetView ().setLayoutParams (pmNew);
                            } catch (Exception e) { }
                        } } );
                }
            } }
    }
}
