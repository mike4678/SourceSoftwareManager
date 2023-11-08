
package hsh.anzh;

public class rg_n32151 {

    public rg_n32151 ()  { }

    public static void rg_n32159 (final String rg_n32160, final boolean rg_n32161) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                es.dmoral.toasty.Toasty.info (hsh.anzh.jb.rg_n2195.sGetApp (), rg_n32160,
                    (rg_n32161 ? android.widget.Toast.LENGTH_LONG : android.widget.Toast.LENGTH_SHORT), true).show ();
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        es.dmoral.toasty.Toasty.info (hsh.anzh.jb.rg_n2195.sGetApp (), rg_n32160,
                                (rg_n32161 ? android.widget.Toast.LENGTH_LONG : android.widget.Toast.LENGTH_SHORT), true).show ();
                    } catch (Exception e) { }
                } } );
        }
    }
}
