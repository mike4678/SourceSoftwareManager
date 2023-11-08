
package hsh.anzh.jb;

import android.app.Activity;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n6072 extends AndroidView {

    public rg_n6072 ()  { }

    public rg_n6072 (android.content.Context context, ImageView view, Object objInitData) { super (context, view, objInitData); }
    public rg_n6072 (android.content.Context context, ImageView view) { this (context, view, null); }
    public ImageView GetImageView () { return (ImageView)GetView (); }
    public static rg_n6072 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new ImageView (context), null);
    }
    public static rg_n6072 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new ImageView (context), objInitData);
    }
    public static rg_n6072 sNewInstanceAndAttachView (android.content.Context context, ImageView viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n6072 sNewInstanceAndAttachView (android.content.Context context, ImageView viewAttach, Object objInitData) {
        rg_n6072 objControl = new rg_n6072 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }

    public void rg_n6099 (int rg_n6100) {
        final ImageView.ScaleType s =
            (rg_n6100 == rg_n6064.rg_n6065 ? ImageView.ScaleType.FIT_XY :
            rg_n6100 == rg_n6064.rg_n6066 ? ImageView.ScaleType.FIT_START :
            rg_n6100 == rg_n6064.rg_n6067 ? ImageView.ScaleType.FIT_CENTER :
            rg_n6100 == rg_n6064.rg_n6068 ? ImageView.ScaleType.FIT_END :
            rg_n6100 == rg_n6064.rg_n6069 ? ImageView.ScaleType.CENTER_CROP :
            rg_n6100 == rg_n6064.rg_n6070 ? ImageView.ScaleType.CENTER :
            rg_n6100 == rg_n6064.rg_n6071 ? ImageView.ScaleType.CENTER_INSIDE :
            ImageView.ScaleType.FIT_CENTER);
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetImageView ().setScaleType (s);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetImageView ().setScaleType (s);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n6110 (final android.graphics.drawable.Drawable rg_n6111) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                GetImageView ().setImageDrawable (rg_n6111);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetImageView ().setImageDrawable (rg_n6111);
                    } catch (Exception e) { }
                } } );
        }
    }
}
