
package hsh.anzh.jb;

import android.util.Log;
import android.widget.Toast;

public class rg_n14019 {

    public rg_n14019 ()  { }

    public static void dbg_log (String format, Object... args) {
       if (args == null || args.length == 0 || args [0] == "")
           rg_n14019.rg_n14027 (format);
       else
           rg_n14019.rg_n14027 (String.format (format, args));
    }

    public static void rg_n14027 (String rg_n14028) {
        {
            Log.d ("VolDev", rg_n14028);
        }
    }
}
