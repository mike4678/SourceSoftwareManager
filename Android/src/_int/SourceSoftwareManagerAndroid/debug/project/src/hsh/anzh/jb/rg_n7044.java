
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n7044 extends AndroidView {

    public rg_n7044 ()  { }

    public rg_n7044 (android.content.Context context, TextView view, Object objInitData) { super (context, view, objInitData); }
    public rg_n7044 (android.content.Context context, TextView view) { this (context, view, null); }
    public TextView GetTextView () { return (TextView)GetView (); }
    public static rg_n7044 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new TextView (context), null);
    }
    public static rg_n7044 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new TextView (context), objInitData);
    }
    public static rg_n7044 sNewInstanceAndAttachView (android.content.Context context, TextView viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n7044 sNewInstanceAndAttachView (android.content.Context context, TextView viewAttach, Object objInitData) {
        rg_n7044 objControl = new rg_n7044 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    protected int rg_n7102 = 0;
    protected int rg_n7103 = 0;
    android.text.TextWatcher m_objTextWatcher;

    public void rg_n7064 (final String rg_n7065) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setText (rg_n7065);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setText (rg_n7065);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7068 (final android.text.Spanned rg_n7069) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setText (rg_n7069);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setText (rg_n7069);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7073 (final boolean rg_n7074) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setSingleLine (rg_n7074);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setSingleLine (rg_n7074);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7114 (final double rg_n7115) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setTextSize ((float)rg_n7115);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setTextSize ((float)rg_n7115);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7120 (final int rg_n7121) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setTextColor (rg_n7121);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setTextColor (rg_n7121);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7127 (final int rg_n7128) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setGravity (rg_n7128 |
                    (GetTextView ().getGravity () & ~(android.view.Gravity.RELATIVE_HORIZONTAL_GRAVITY_MASK | android.view.Gravity.CLIP_HORIZONTAL)));
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setGravity (rg_n7128 |
                                (GetTextView ().getGravity () & ~(android.view.Gravity.RELATIVE_HORIZONTAL_GRAVITY_MASK | android.view.Gravity.CLIP_HORIZONTAL)));
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7129 (final int rg_n7130) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setGravity (rg_n7130 |
                    (GetTextView ().getGravity () & ~(android.view.Gravity.VERTICAL_GRAVITY_MASK | android.view.Gravity.CLIP_VERTICAL)));
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setGravity (rg_n7130 |
                                (GetTextView ().getGravity () & ~(android.view.Gravity.VERTICAL_GRAVITY_MASK | android.view.Gravity.CLIP_VERTICAL)));
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n7181 (final int rg_n7182, final int rg_n7183) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetTextView ().setGravity (rg_n7182 | rg_n7183);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetTextView ().setGravity (rg_n7182 | rg_n7183);
                    } catch (Exception e) { }
                } } );
        }
    }
}
