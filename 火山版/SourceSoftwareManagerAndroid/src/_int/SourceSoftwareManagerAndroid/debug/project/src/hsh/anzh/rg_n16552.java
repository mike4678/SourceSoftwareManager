
package hsh.anzh;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n16552 extends hsh.anzh.jb.rg_n6158 {

    public rg_n16552 ()  { }

    public rg_n16552 (android.content.Context context, rg_n16551 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n16552 (android.content.Context context, rg_n16551 view) { this (context, view, null); }
    public rg_n16551 GetFancyButton () { return (rg_n16551)GetView (); }
    public static rg_n16552 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n16551 (context), null);
    }
    public static rg_n16552 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n16551 (context), objInitData);
    }
    public static rg_n16552 sNewInstanceAndAttachView (android.content.Context context, rg_n16551 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n16552 sNewInstanceAndAttachView (android.content.Context context, rg_n16551 viewAttach, Object objInitData) {
        rg_n16552 objControl = new rg_n16552 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    private hsh.anzh.jb.rg_n7044 volText;
    private hsh.anzh.jb.rg_n6072 volImage;
    private hsh.anzh.jb.rg_n7044 volImageText;

    public void rg_n16557 (final String rg_n16558) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setText (rg_n16558);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setText (rg_n16558);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16564 (final String rg_n16565) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setIconResource (rg_n16565);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setIconResource (rg_n16565);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16566 (final int rg_n16567) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setFontIconSize (rg_n16567);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setFontIconSize (rg_n16567);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16569 (final int rg_n16570) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setIconPosition (rg_n16570);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setIconPosition (rg_n16570);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16576 (final int rg_n16577) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setTextSize (rg_n16577);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setTextSize (rg_n16577);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16583 (final int rg_n16584) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setTextColor (rg_n16584);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setTextColor (rg_n16584);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16600 (final int rg_n16601) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setIconColor (rg_n16601);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setIconColor (rg_n16601);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16603 (final int rg_n16604) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setBorderWidth (rg_n16604);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setBorderWidth (rg_n16604);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16606 (final int rg_n16607) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setBorderColor (rg_n16607);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setBorderColor (rg_n16607);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16612 (final int rg_n16613) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setFocusBackgroundColor (rg_n16613);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setFocusBackgroundColor (rg_n16613);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16620 (final int rg_n16621, final int rg_n16622, final int rg_n16623, final int rg_n16624) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setIconPadding (rg_n16621, rg_n16622, rg_n16623, rg_n16624);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setIconPadding (rg_n16621, rg_n16622, rg_n16623, rg_n16624);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16625 (int rg_n16626, int rg_n16627, int rg_n16628, int rg_n16629) {
        final int[] i = new int[4];
        i[0] = rg_n16626;
        i[1] = rg_n16627;
        i[2] = rg_n16628;
        i[3] = rg_n16629;
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetFancyButton ().setRadius (i);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetFancyButton ().setRadius (i);
                    } catch (Exception e) { }
                } } );
        }
    }

    protected void rg_n4112 (android.content.Context rg_n16630, java.lang.Object rg_n16631) {
        super.rg_n4112 (rg_n16630, rg_n16631);
        rg_n5260 (true);
    }
}
