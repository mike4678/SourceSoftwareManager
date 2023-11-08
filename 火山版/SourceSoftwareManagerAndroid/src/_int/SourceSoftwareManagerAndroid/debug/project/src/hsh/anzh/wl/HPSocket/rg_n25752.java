
package hsh.anzh.wl.HPSocket;

import com.voldev.hpsocket.Client.HPClientBaseApi;
import com.voldev.hpsocket.Client.TcpClient;
import com.voldev.hpsocket.Client.TcpPackClient;

public class rg_n25752 extends rg_n25745 {

    public rg_n25752 () {
        rg_n25753 ();
    }

    protected void rg_n25753 () {
        hClientObj = new TcpPackClient (false);
        setlistener ((TcpClient)hClientObj);
    }
}
