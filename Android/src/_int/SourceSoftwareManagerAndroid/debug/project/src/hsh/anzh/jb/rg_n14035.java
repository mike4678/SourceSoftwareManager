
package hsh.anzh.jb;

public class rg_n14035 {

    public rg_n14035 ()  { }

    public int rg_n14037 = 1000;
    protected long rg_n14038;
    protected boolean rg_n14040;
    protected boolean rg_n14041;
    private android.os.Handler m_objHandler;
    private static final int c_nMessageID = 2;

    public static interface re_n14036 { int dispatch (rg_n14035 objSource, int nTagNumber); }
    private re_n14036 rd_n14036;
    private int rd_n14036_tag;
    public void rl_n14035_n14036 (re_n14036 objListener, int nTagNumber) {
        synchronized (this) { rd_n14036 = objListener;  rd_n14036_tag = nTagNumber; }
    }
    public int rg_n14036 () {
        re_n14036 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n14036;  nTagNumber = rd_n14036_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public long rg_n14039 () {
        return (rg_n14038);
    }

    public boolean rg_n14043 () {
        if (rg_n14040)
        {
            return (true);
        }
        if (rg_n14037 <= 0)
        {
            return (false);
        }
        if (m_objHandler == null)
        {
            if (android.os.Looper.myLooper () == null)
            {
                return (false);
            }
            m_objHandler = new android.os.Handler () {
                public void handleMessage (android.os.Message m) {
                    rg_n14041 = false;
                    if (rg_n14040 &&
                            rg_n14037 > 0 &&
                            rg_n14036 () != 1) {
                        if (rg_n14040 &&
                                rg_n14041 == false) {
                            rg_n14038 = rg_n14038 + 1;
                            rg_n14041 = true;
                            sendMessageDelayed (android.os.Message.obtain (this, c_nMessageID), rg_n14037);
                        }
                    }
                    else rg_n14040 = false;
                } };
        }
        rg_n14040 = true;
        rg_n14038 = 0;
        rg_n14041 = true;
        m_objHandler.sendMessageDelayed (android.os.Message.obtain (m_objHandler, c_nMessageID), rg_n14037);
        return (true);
    }

    public void rg_n14044 () {
        if (rg_n14040)
        {
            rg_n14040 = false;
            rg_n14041 = false;
            if (m_objHandler != null)
            {
                m_objHandler.removeMessages (c_nMessageID);
            }
        }
    }
}
