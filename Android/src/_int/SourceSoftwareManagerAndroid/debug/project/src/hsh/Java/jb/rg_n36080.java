
package hsh.Java.jb;

public class rg_n36080 extends java.lang.Thread {

    private Object m_objUserData1, m_objUserData2;
    @Override
    public void run () {
        rg_n36084 (m_objUserData1, m_objUserData2);
        m_objUserData1 = m_objUserData2 = null;
    }

    public boolean rg_n36081 (java.lang.Object rg_n36082, java.lang.Object rg_n36083) {
        m_objUserData1 = rg_n36082;
        m_objUserData2 = rg_n36083;
        try {
            start ();
            return true;
        } catch (Exception e) { }
        m_objUserData1 = m_objUserData2 = null;
        return false;
    }

    public static interface re_n36084 { int dispatch (rg_n36080 objSource, int nTagNumber, java.lang.Object rg_n36085, java.lang.Object rg_n36086); }
    private re_n36084 rd_n36084;
    private int rd_n36084_tag;
    public void rl_n36080_n36084 (re_n36084 objListener, int nTagNumber) {
        synchronized (this) { rd_n36084 = objListener;  rd_n36084_tag = nTagNumber; }
    }
    public int rg_n36084 (java.lang.Object rg_n36085, java.lang.Object rg_n36086) {
        re_n36084 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n36084;  nTagNumber = rd_n36084_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n36085, rg_n36086) : 0);
    }
}
