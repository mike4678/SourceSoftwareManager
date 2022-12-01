
package hsh.anzh.wl.HPSocket;

import com.voldev.hpsocket.Client.HPClientBaseApi;
import com.voldev.hpsocket.Client.HPClientBaseApi.HPClientListener;
import com.voldev.hpsocket.Client.HPClientBaseApi.HPClientReceiveListener;
import com.voldev.hpsocket.Client.TcpClient;

public class rg_n25646 extends rg_n25473 {

    public rg_n25646 ()  { }

        public HPClientBaseApi hClientObj;
        public void setlistener (HPClientBaseApi client) {
             setClientBaseListener (client);
             setClientReceive (client);
        }
        public void setClientReceive (HPClientBaseApi obj) {
             obj.SetReceiveListener(new HPClientReceiveListener() {
                @Override public int OnReceive(final int dwConnID, final byte[] pData) {
                    if (useMainThreadEvent){
                        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
                            try {
                                mEventResult = rg_n25707 (pData.length, pData);
                            } catch (Exception e) { }
                        } else {
                            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                                @Override public void run () {
                                    try {
                                        mEventResult = rg_n25707 (pData.length, pData);
                                    } catch (Exception e) { }
                                } } );
                        }
                    }else {
                        mEventResult = rg_n25707 (pData.length, pData);
                    }
                    return mEventResult;
                 }
             });
        }
        public void setClientBaseListener (HPClientBaseApi obj) {
            obj.SetHPClientListener(new HPClientListener() {
                @Override public int OnClose(final int dwConnID, final int enOperation, final int iErrorCode) {
                    if (useMainThreadEvent){
                        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
                            try {
                                mEventResult = rg_n25699 (enOperation, iErrorCode);
                            } catch (Exception e) { }
                        } else {
                            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                                @Override public void run () {
                                    try {
                                        mEventResult = rg_n25699 (enOperation, iErrorCode);
                                    } catch (Exception e) { }
                                } } );
                        }
                    }else {
                        mEventResult = rg_n25699 (enOperation, iErrorCode);
                    }
                    return mEventResult;
                }
                @Override public int OnSend(final int dwConnID, final byte[] pData) {
                    if (useMainThreadEvent){
                        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
                            try {
                                mEventResult = rg_n25705 (pData);
                            } catch (Exception e) { }
                        } else {
                            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                                @Override public void run () {
                                    try {
                                        mEventResult = rg_n25705 (pData);
                                    } catch (Exception e) { }
                                } } );
                        }
                    }else {
                        mEventResult = rg_n25705 (pData);
                    }
                    return mEventResult;
                }
                @Override public int OnPrepareConnect(final int dwConnID) {
                    if (useMainThreadEvent){
                        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
                            try {
                                mEventResult = rg_n25704 ();
                            } catch (Exception e) { }
                        } else {
                            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                                @Override public void run () {
                                    try {
                                        mEventResult = rg_n25704 ();
                                    } catch (Exception e) { }
                                } } );
                        }
                    }else {
                        mEventResult = rg_n25704 ();
                    }
                    return mEventResult;
                }
                @Override public int OnHandShake(final int dwConnID) {
                    if (useMainThreadEvent){
                        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
                            try {
                                mEventResult = rg_n25703 ();
                            } catch (Exception e) { }
                        } else {
                            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                                @Override public void run () {
                                    try {
                                        mEventResult = rg_n25703 ();
                                    } catch (Exception e) { }
                                } } );
                        }
                    }else {
                        mEventResult = rg_n25703 ();
                    }
                    return mEventResult;
                }
                @Override public int OnConnect(final int dwConnID) {
                    if (useMainThreadEvent){
                        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
                            try {
                                mEventResult = rg_n25702 ();
                            } catch (Exception e) { }
                        } else {
                            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                                @Override public void run () {
                                    try {
                                        mEventResult = rg_n25702 ();
                                    } catch (Exception e) { }
                                } } );
                        }
                    }else {
                        mEventResult = rg_n25702 ();
                    }
                    return mEventResult;
                }
            });
        }

    public boolean rg_n25647 (String rg_n25648, int rg_n25649, boolean rg_n25650) {
        if (hClientObj == null || hClientObj.TIsConnected() == true) return false;
        hClientObj.isConnected = false;
        final boolean isSyn = rg_n25650;
        Runnable r = new Runnable () {
           @Override public void run () {
               long startTime = System.currentTimeMillis ();
               while (hClientObj.TIsConnected() == false ) {
                   if (System.currentTimeMillis () - startTime > hClientObj.maxConnectDuration) {
                       hClientObj.TStop();
                       break;
                   }
               }
           }
        };
        new Thread (r).start ();
        hClientObj.isConnected = hClientObj.TStart (rg_n25648, rg_n25649, rg_n25650);
        return hClientObj.isConnected;
    }

    public boolean rg_n25658 (byte [] rg_n25659, int rg_n25660) {
        if (rg_n25660 != -1)
            return hClientObj.TSend (rg_n25659, rg_n25660);
        else
            return hClientObj.TSend (rg_n25659);
    }

    public void rg_n25678 (int rg_n25679) {
        hClientObj.maxConnectDuration = rg_n25679;
    }

    public static interface re_n25699 { int dispatch (rg_n25646 objSource, int nTagNumber, int rg_n25700, int rg_n25701); }
    private re_n25699 rd_n25699;
    private int rd_n25699_tag;
    public void rl_n25646_n25699 (re_n25699 objListener, int nTagNumber) {
        synchronized (this) { rd_n25699 = objListener;  rd_n25699_tag = nTagNumber; }
    }
    public int rg_n25699 (int rg_n25700, int rg_n25701) {
        re_n25699 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n25699;  nTagNumber = rd_n25699_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n25700, rg_n25701) : 0);
    }

    public static interface re_n25702 { int dispatch (rg_n25646 objSource, int nTagNumber); }
    private re_n25702 rd_n25702;
    private int rd_n25702_tag;
    public void rl_n25646_n25702 (re_n25702 objListener, int nTagNumber) {
        synchronized (this) { rd_n25702 = objListener;  rd_n25702_tag = nTagNumber; }
    }
    public int rg_n25702 () {
        re_n25702 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n25702;  nTagNumber = rd_n25702_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n25703 { int dispatch (rg_n25646 objSource, int nTagNumber); }
    private re_n25703 rd_n25703;
    private int rd_n25703_tag;
    public void rl_n25646_n25703 (re_n25703 objListener, int nTagNumber) {
        synchronized (this) { rd_n25703 = objListener;  rd_n25703_tag = nTagNumber; }
    }
    public int rg_n25703 () {
        re_n25703 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n25703;  nTagNumber = rd_n25703_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n25704 { int dispatch (rg_n25646 objSource, int nTagNumber); }
    private re_n25704 rd_n25704;
    private int rd_n25704_tag;
    public void rl_n25646_n25704 (re_n25704 objListener, int nTagNumber) {
        synchronized (this) { rd_n25704 = objListener;  rd_n25704_tag = nTagNumber; }
    }
    public int rg_n25704 () {
        re_n25704 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n25704;  nTagNumber = rd_n25704_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n25705 { int dispatch (rg_n25646 objSource, int nTagNumber, byte [] rg_n25706); }
    private re_n25705 rd_n25705;
    private int rd_n25705_tag;
    public void rl_n25646_n25705 (re_n25705 objListener, int nTagNumber) {
        synchronized (this) { rd_n25705 = objListener;  rd_n25705_tag = nTagNumber; }
    }
    public int rg_n25705 (byte [] rg_n25706) {
        re_n25705 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n25705;  nTagNumber = rd_n25705_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n25706) : 0);
    }

    public static interface re_n25707 { int dispatch (rg_n25646 objSource, int nTagNumber, int rg_n25708, byte [] rg_n25709); }
    private re_n25707 rd_n25707;
    private int rd_n25707_tag;
    public void rl_n25646_n25707 (re_n25707 objListener, int nTagNumber) {
        synchronized (this) { rd_n25707 = objListener;  rd_n25707_tag = nTagNumber; }
    }
    public int rg_n25707 (int rg_n25708, byte [] rg_n25709) {
        re_n25707 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n25707;  nTagNumber = rd_n25707_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n25708, rg_n25709) : 0);
    }
}
