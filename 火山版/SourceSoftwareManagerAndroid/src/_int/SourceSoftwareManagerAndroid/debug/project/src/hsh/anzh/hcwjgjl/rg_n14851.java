
package hsh.anzh.hcwjgjl;

class rg_n14851 {

    public rg_n14851 ()  { }

    protected static final char rg_n14852 = ' ';

    protected static boolean rg_n14881 (byte [] rg_n14882) {
        return (rg_n14882 != null && rg_n14882.length > 15 && rg_n14882 [13] == '-' && rg_n14883 (rg_n14882, rg_n14852) > 14);
    }

    protected static int rg_n14883 (byte [] rg_n14884, char rg_n14885) {
        for (int i = 0; i < rg_n14884.length; i++)
            if (rg_n14884[i] == rg_n14885)
                 return i;
        return -1;
    }
}
