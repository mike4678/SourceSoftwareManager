
package hsh.anzh.gn.txjz;

public class rg_n25381 {

    public static final int rg_n25382 = 0;
    public static final int rg_n25384 = 2;
    public static final int rg_n25387 = 1;
    public static final int rg_n25388 = 2;

    public static com.bumptech.glide.GenericRequestBuilder rg_n25393 (com.bumptech.glide.GenericRequestBuilder rg_n25394, int rg_n25395) {
        com.bumptech.glide.load.engine.DiskCacheStrategy diskCacheStrategy =
            (rg_n25395 == 0 ? com.bumptech.glide.load.engine.DiskCacheStrategy.SOURCE :
            rg_n25395 == 1 ? com.bumptech.glide.load.engine.DiskCacheStrategy.RESULT :
            rg_n25395 == 2 ? com.bumptech.glide.load.engine.DiskCacheStrategy.NONE :
            rg_n25395 == 3 ? com.bumptech.glide.load.engine.DiskCacheStrategy.ALL :
            com.bumptech.glide.load.engine.DiskCacheStrategy.ALL);
        return rg_n25394.diskCacheStrategy(diskCacheStrategy);
    }

    public static com.bumptech.glide.GenericRequestBuilder rg_n25396 (com.bumptech.glide.GenericRequestBuilder rg_n25397, int rg_n25398) {
        com.bumptech.glide.Priority priority =
            (rg_n25398 == 0 ? com.bumptech.glide.Priority.IMMEDIATE :
            rg_n25398 == 1 ? com.bumptech.glide.Priority.HIGH :
            rg_n25398 == 2 ? com.bumptech.glide.Priority.NORMAL :
            rg_n25398 == 3 ? com.bumptech.glide.Priority.LOW :
            com.bumptech.glide.Priority.NORMAL);
        return rg_n25397.priority(priority);
    }

    public static void rg_n25432 (final com.bumptech.glide.GenericRequestBuilder rg_n25433, final hsh.anzh.jb.rg_n6072 rg_n25434) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                rg_n25433.into((android.widget.ImageView)rg_n25434.GetView());
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        rg_n25433.into((android.widget.ImageView)rg_n25434.GetView());
                    } catch (Exception e) { }
                } } );
        }
    }
}
