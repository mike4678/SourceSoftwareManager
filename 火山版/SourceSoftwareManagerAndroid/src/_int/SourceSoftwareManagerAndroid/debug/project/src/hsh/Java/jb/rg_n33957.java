
package hsh.Java.jb;

public class rg_n33957 {

    public static void rg_n33958 (java.io.OutputStream rg_n33959) {
        try {
            rg_n33959.close ();
        } catch (Exception e) { }
    }

    public static boolean rg_n33963 (java.io.OutputStream rg_n33964, byte [] rg_n33965, int rg_n33966, int rg_n33967, rg_n34312 rg_n33968) {
        if (rg_n33968 == null || rg_n33968.rg_n34323 () == false) {
           try {
               rg_n33964.write (rg_n33965, rg_n33966, rg_n33967);
               return true;
           } catch (Exception e) {
               if (rg_n33968 != null)
                   rg_n33968.rg_n34320 (rg_n34312.rg_n34314);
           }
        }
        return false;
    }
}
