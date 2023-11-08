
package hsh.anzh.wl.HPSocket;

public class rg_n25473 extends com.voldev.hpsocket.HPBaseApi {

    static { System.loadLibrary("voldevhp-lib"); }
    public String getHPForVolDPVersion () { return getVersion (); }
    public String getHpSocketVersion   () { return getHpVersion (); }
    public int mEventResult = 0;
    public boolean useMainThreadEvent = true;
}
