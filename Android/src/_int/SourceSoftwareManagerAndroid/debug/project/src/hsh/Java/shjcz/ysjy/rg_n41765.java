
package hsh.Java.shjcz.ysjy;

public class rg_n41765 {

    public rg_n41765 ()  { }

    public static byte [] rg_n41775 (byte [] rg_n41776) {
        java.util.zip.Inflater rg_n41777;
        rg_n41777 = new java.util.zip.Inflater(false);
        if (rg_n41777 == null)
        {
            return (new byte [0]);
        }
        rg_n41777.reset();
        rg_n41777.setInput(hsh.Java.jb.rg_n32268.rg_n32330 (rg_n41776, rg_n41776.length - 8));
        java.io.ByteArrayOutputStream rg_n41778;
        rg_n41778 = new java.io.ByteArrayOutputStream (Math.max (0, rg_n41776.length));
        if (rg_n41778 == null)
        {
            return (new byte [0]);
        }
        byte [] rg_n41779 = new byte [1024];
        while (rg_n41777.finished() == false)
        {
            int rg_n41780;
            rg_n41780 = rg_n41782.rg_n41799 (rg_n41777, rg_n41779);
            hsh.Java.jb.rg_n33957.rg_n33963 (rg_n41778, rg_n41779, 0, rg_n41780, null);
        }
        byte [] rg_n41781;
        rg_n41781 = rg_n41778.toByteArray ();
        rg_n41777.end();
        return (rg_n41781);
    }
}
