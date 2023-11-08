
package hsh.Java.jb;

public final class rg_n37496 {

    public static boolean rg_n37497 (java.util.List<java.lang.Object> rg_n37498, int rg_n37499, java.lang.Object rg_n37500) {
        if (rg_n37499 < 0)
        {
            try {
                rg_n37498.add (rg_n37500);
                return true;
            } catch (Exception e) {
                return false;
            }
        }
        else
        {
            try {
                rg_n37498.add (rg_n37499, rg_n37500);
                return true;
            } catch (Exception e) {
                return false;
            }
        }
    }
}
