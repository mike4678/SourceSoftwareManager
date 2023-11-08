
package hsh.Java.jb;

public final class rg_n35692 {

    public static int rg_n35701 (String rg_n35702) {
        try {
            return Integer.parseInt (rg_n35702);
        } catch (Exception e) {
            return 0;
        }
    }

    public static boolean rg_n35711 (String rg_n35712) {
        return (rg_n35712 == null || rg_n35712.isEmpty ());
    }

    public static String rg_n35713 (byte [] rg_n35714) {
        try {
            return new String (rg_n35714);
        } catch (Exception e) {
            return "";
        }
    }

    public static String rg_n35719 (byte [] rg_n35720, String rg_n35721) {
        try {
            return new String (rg_n35720, rg_n35721);
        } catch (Exception e) {
            return "";
        }
    }

    public static byte [] rg_n35771 (String rg_n35772, String rg_n35773) {
         try {
             return rg_n35772.getBytes (rg_n35773);
         } catch (Exception e) {
             return null;
         }
    }
}
