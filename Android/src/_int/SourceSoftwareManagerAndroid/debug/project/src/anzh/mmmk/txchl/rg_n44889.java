
package anzh.mmmk.txchl;

import android.graphics.drawable.Drawable;
import android.support.v4.graphics.drawable.DrawableCompat;

public class rg_n44889 {

    public rg_n44889 ()  { }

    public static byte [] rg_n44890 (android.graphics.drawable.Drawable rg_n44891, int rg_n44892, int rg_n44893) {
        if (rg_n44891 instanceof android.graphics.drawable.BitmapDrawable)
        {
            android.graphics.drawable.BitmapDrawable rg_n44894;
            rg_n44894 = (android.graphics.drawable.BitmapDrawable)rg_n44891;
            return (rg_n44726.rg_n44835 (rg_n44894.getBitmap (), rg_n44893, rg_n44892));
        }
        else if (rg_n44891 instanceof com.bumptech.glide.load.resource.bitmap.GlideBitmapDrawable)
        {
            com.bumptech.glide.load.resource.bitmap.GlideBitmapDrawable rg_n44895;
            rg_n44895 = (com.bumptech.glide.load.resource.bitmap.GlideBitmapDrawable)rg_n44891;
            return (rg_n44726.rg_n44835 (rg_n44895.getBitmap (), rg_n44893, rg_n44892));
        }
        else
        {
            return (new byte [0]);
        }
    }

    public static android.graphics.drawable.Drawable rg_n44900 (String rg_n44901) {
        return (android.graphics.drawable.Drawable.createFromPath (rg_n44901));
    }

    public static android.graphics.drawable.Drawable rg_n44912 (android.graphics.drawable.Drawable rg_n44913, int rg_n44914) {
        Drawable wrappedDrawable = DrawableCompat.wrap(rg_n44913).mutate();
        DrawableCompat.setTint(wrappedDrawable, rg_n44914);
        return wrappedDrawable;
    }
}
