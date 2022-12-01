
package hsh.anzh.wl.HPSocket;

import com.voldev.hpsocket.Client.HPClientBaseApi.HPClientPullReceiveListener;
import com.voldev.hpsocket.Client.TcpPackClient;

public class rg_n25745 extends rg_n25710 {

    public rg_n25745 ()  { }

    public void rg_n25746 (int rg_n25747) {
        ((TcpPackClient)hClientObj).TSetMaxPackSize (rg_n25747);
    }
}
