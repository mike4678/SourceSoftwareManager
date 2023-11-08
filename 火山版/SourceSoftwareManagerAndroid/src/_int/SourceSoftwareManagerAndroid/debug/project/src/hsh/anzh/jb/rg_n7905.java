
package hsh.anzh.jb;

public class rg_n7905 {

    public static void rg_n7908 (final android.graphics.drawable.Drawable rg_n7909, final android.graphics.Rect rg_n7910) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                rg_n7909.setBounds (rg_n7910);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        rg_n7909.setBounds (rg_n7910);
                    } catch (Exception e) { }
                } } );
        }
    }
}
