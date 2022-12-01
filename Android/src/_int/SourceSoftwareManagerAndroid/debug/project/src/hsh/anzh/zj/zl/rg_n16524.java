
package hsh.anzh.zj.zl;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n16524 extends hsh.anzh.jb.rg_n6202 {

    public rg_n16524 ()  { }

    public rg_n16524 (android.content.Context context, rg_n16523 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n16524 (android.content.Context context, rg_n16523 view) { this (context, view, null); }
    public rg_n16523 GetHCardView () { return (rg_n16523)GetView (); }
    public static rg_n16524 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n16523 (context), null);
    }
    public static rg_n16524 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n16523 (context), objInitData);
    }
    public static rg_n16524 sNewInstanceAndAttachView (android.content.Context context, rg_n16523 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n16524 sNewInstanceAndAttachView (android.content.Context context, rg_n16523 viewAttach, Object objInitData) {
        rg_n16524 objControl = new rg_n16524 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }

    public void rg_n16537 (final double rg_n16538) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetHCardView ().setRadius ((float)Math.max (0.01, rg_n16538));
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetHCardView ().setRadius ((float)Math.max (0.01, rg_n16538));
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16540 (final int rg_n16541) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetHCardView ().setCardBackgroundColor (rg_n16541);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetHCardView ().setCardBackgroundColor (rg_n16541);
                    } catch (Exception e) { }
                } } );
        }
    }
}
