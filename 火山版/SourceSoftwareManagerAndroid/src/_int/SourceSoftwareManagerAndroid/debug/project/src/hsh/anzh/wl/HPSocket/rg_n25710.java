
package hsh.anzh.wl.HPSocket;

import com.voldev.hpsocket.Client.HPClientBaseApi.HPClientListener;
import com.voldev.hpsocket.Client.HPClientBaseApi.HPClientReceiveListener;
import com.voldev.hpsocket.Client.TcpClient;

public class rg_n25710 extends rg_n25646 {

    public rg_n25710 ()  { }

    public void rg_n25715 (int rg_n25716) {
        ((TcpClient)hClientObj).TSetSocketBufferSize (rg_n25716);
    }

    public void rg_n25718 (int rg_n25719) {
        ((TcpClient)hClientObj).TSetKeepAliveTime (rg_n25719);
    }
}
