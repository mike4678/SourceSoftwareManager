
package anzh.mmmk.zqzb;

public class rg_n47996 {

    public rg_n47996 ()  { }

    public static void rg_n48025 (hsh.anzh.jb.rg_n6072 rg_n48026, android.graphics.drawable.Drawable rg_n48027, android.graphics.drawable.Drawable rg_n48028, android.graphics.drawable.Drawable rg_n48029, android.graphics.drawable.Drawable rg_n48030, boolean rg_n48031, boolean rg_n48032, boolean rg_n48033) {
        if (rg_n48026 != null && rg_n48027 != null)
        {
            com.bumptech.glide.DrawableTypeRequest rg_n48034;
            rg_n48034 = (com.bumptech.glide.DrawableTypeRequest)((((com.bumptech.glide.Glide.with(rg_n48026.rg_n5581 ()).load(anzh.mmmk.txchl.rg_n44889.rg_n44890 (rg_n48027, hsh.anzh.jb.rg_n7990.rg_n7992, 100))).placeholder(rg_n48028)).error(rg_n48029)).fallback(rg_n48030));
            if (rg_n48031 == false)
            {
                rg_n48034 = (com.bumptech.glide.DrawableTypeRequest)rg_n48034.dontAnimate();
            }
            if (rg_n48032)
            {
                com.bumptech.glide.GifTypeRequest rg_n48035;
                rg_n48035 = rg_n48034.asGif();
                com.bumptech.glide.GenericRequestBuilder rg_n48036 = null;
                if (rg_n48033)
                {
                    rg_n48036 = rg_n48035.transform(new com.hsh.circle.Glide.GlideCircleTransform (rg_n48026.rg_n5581 ()));
                }
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48036, rg_n48026);
            }
            else
            {
                if (rg_n48033)
                {
                    rg_n48034 = (com.bumptech.glide.DrawableTypeRequest)rg_n48034.transform(new com.hsh.circle.Glide.GlideCircleTransform (rg_n48026.rg_n5581 ()));
                }
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48034, rg_n48026);
            }
        }
    }

    public static void rg_n48037 (hsh.anzh.jb.rg_n6072 rg_n48038, android.graphics.drawable.Drawable rg_n48039, android.graphics.drawable.Drawable rg_n48040, android.graphics.drawable.Drawable rg_n48041, android.graphics.drawable.Drawable rg_n48042, boolean rg_n48043, boolean rg_n48044, int rg_n48045) {
        if (rg_n48038 != null && rg_n48039 != null)
        {
            com.bumptech.glide.DrawableTypeRequest rg_n48046;
            rg_n48046 = (com.bumptech.glide.DrawableTypeRequest)(((((com.bumptech.glide.Glide.with(rg_n48038.rg_n5581 ()).load(anzh.mmmk.txchl.rg_n44889.rg_n44890 (rg_n48039, hsh.anzh.jb.rg_n7990.rg_n7992, 100))).placeholder(rg_n48040)).error(rg_n48041)).fallback(rg_n48042)).transform(new com.hsh.circle.Glide.GlideRoundTransform (rg_n48038.rg_n5581 (), rg_n48045)));
            if (rg_n48043 == false)
            {
                rg_n48046 = (com.bumptech.glide.DrawableTypeRequest)rg_n48046.dontAnimate();
            }
            if (rg_n48044)
            {
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48046.asGif(), rg_n48038);
            }
            else
            {
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48046, rg_n48038);
            }
        }
    }

    public static void rg_n48047 (hsh.anzh.jb.rg_n6072 rg_n48048, String rg_n48049, android.graphics.drawable.Drawable rg_n48050, android.graphics.drawable.Drawable rg_n48051, android.graphics.drawable.Drawable rg_n48052, boolean rg_n48053, boolean rg_n48054, int rg_n48055, int rg_n48056, double rg_n48057, boolean rg_n48058, boolean rg_n48059) {
        if (rg_n48048 != null)
        {
            com.bumptech.glide.DrawableTypeRequest rg_n48060;
            rg_n48060 = (com.bumptech.glide.DrawableTypeRequest)((((com.bumptech.glide.Glide.with(rg_n48048.rg_n5581 ()).load(rg_n48049)).placeholder(rg_n48050)).error(rg_n48051)).fallback(rg_n48052));
            if (rg_n48053 == false)
            {
                rg_n48060 = (com.bumptech.glide.DrawableTypeRequest)rg_n48060.dontAnimate();
            }
            if (rg_n48058)
            {
                com.bumptech.glide.GifTypeRequest rg_n48061;
                rg_n48061 = rg_n48060.asGif();
                com.bumptech.glide.GenericRequestBuilder rg_n48062 = null;
                if (rg_n48059)
                {
                    rg_n48062 = hsh.anzh.gn.txjz.rg_n25381.rg_n25393 (hsh.anzh.gn.txjz.rg_n25381.rg_n25396 (rg_n48061.transform(new com.hsh.circle.Glide.GlideCircleTransform (rg_n48048.rg_n5581 ())), hsh.anzh.gn.txjz.rg_n25381.rg_n25387).skipMemoryCache(rg_n48054), rg_n48055);
                }
                if (rg_n48057 > 0)
                {
                    rg_n48062 = hsh.anzh.gn.txjz.rg_n25381.rg_n25393 (hsh.anzh.gn.txjz.rg_n25381.rg_n25396 (rg_n48062.thumbnail((float)rg_n48057), hsh.anzh.gn.txjz.rg_n25381.rg_n25387).skipMemoryCache(rg_n48054), rg_n48055);
                }
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48062, rg_n48048);
            }
            else
            {
                if (rg_n48059)
                {
                    rg_n48060 = (com.bumptech.glide.DrawableTypeRequest)hsh.anzh.gn.txjz.rg_n25381.rg_n25393 (hsh.anzh.gn.txjz.rg_n25381.rg_n25396 (rg_n48060.transform(new com.hsh.circle.Glide.GlideCircleTransform (rg_n48048.rg_n5581 ())), hsh.anzh.gn.txjz.rg_n25381.rg_n25387).skipMemoryCache(rg_n48054), rg_n48055);
                }
                if (rg_n48057 > 0)
                {
                    rg_n48060 = (com.bumptech.glide.DrawableTypeRequest)hsh.anzh.gn.txjz.rg_n25381.rg_n25393 (hsh.anzh.gn.txjz.rg_n25381.rg_n25396 (rg_n48060.thumbnail((float)rg_n48057), hsh.anzh.gn.txjz.rg_n25381.rg_n25387).skipMemoryCache(rg_n48054), rg_n48055);
                }
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48060, rg_n48048);
            }
        }
    }

    public static void rg_n48063 (hsh.anzh.jb.rg_n6072 rg_n48064, String rg_n48065, android.graphics.drawable.Drawable rg_n48066, android.graphics.drawable.Drawable rg_n48067, android.graphics.drawable.Drawable rg_n48068, boolean rg_n48069, boolean rg_n48070, int rg_n48071, int rg_n48072, double rg_n48073, boolean rg_n48074, int rg_n48075) {
        if (rg_n48064 != null)
        {
            com.bumptech.glide.DrawableTypeRequest rg_n48076;
            rg_n48076 = (com.bumptech.glide.DrawableTypeRequest)hsh.anzh.gn.txjz.rg_n25381.rg_n25393 (hsh.anzh.gn.txjz.rg_n25381.rg_n25396 (((((com.bumptech.glide.Glide.with(rg_n48064.rg_n5581 ()).load(rg_n48065)).placeholder(rg_n48066)).error(rg_n48067)).fallback(rg_n48068)).transform(new com.hsh.circle.Glide.GlideRoundTransform (rg_n48064.rg_n5581 (), rg_n48075)), hsh.anzh.gn.txjz.rg_n25381.rg_n25387).skipMemoryCache(rg_n48070), rg_n48071);
            if (rg_n48069 == false)
            {
                rg_n48076 = (com.bumptech.glide.DrawableTypeRequest)rg_n48076.dontAnimate();
            }
            if (rg_n48074)
            {
                com.bumptech.glide.GifTypeRequest rg_n48077;
                rg_n48077 = rg_n48076.asGif();
                com.bumptech.glide.GenericRequestBuilder rg_n48078 = null;
                if (rg_n48073 > 0)
                {
                    rg_n48078 = rg_n48078.thumbnail((float)rg_n48073);
                }
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48078, rg_n48064);
            }
            else
            {
                if (rg_n48073 > 0)
                {
                    rg_n48076 = (com.bumptech.glide.DrawableTypeRequest)rg_n48076.thumbnail((float)rg_n48073);
                }
                hsh.anzh.gn.txjz.rg_n25381.rg_n25432 (rg_n48076, rg_n48064);
            }
        }
    }
}
