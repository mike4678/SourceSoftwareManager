
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n1705 extends android.support.v7.app.AppCompatActivity {

    private static final String cs_strActivityLoadParams = "@activity_params";
    protected boolean onInitAndroidActivity () {
        if (rg_n2195.sCheckRestart (this) == false)
            return false;
        rg_n1717 ();
        return true;
    }
    protected void onStart ()    {  super.onStart ();  m_blCleanupMethodCalled = false;  rg_n43 ();  }
    protected void onRestart ()  {  super.onRestart ();  rg_n1709 ();  }
    protected void onResume ()   {  super.onResume ();  rg_n1712 ();  }
    protected void onPause ()    {  super.onPause ();  rg_n1713 ();  }
    protected void onNewIntent(android.content.Intent intent) { super.onNewIntent(intent); rg_n1710 (intent);  }
    protected void onStop () {
        super.onStop ();
        rg_n1715 ();
        if (isChangingConfigurations ())
            rg_n2195.sForceRestart  ();
        if (isFinishing ())
            SendCleanupNotify ();
    }
    protected void onDestroy () {
        super.onDestroy ();
        SendCleanupNotify ();
        rg_n1716 ();
    }
    private boolean m_blCleanupMethodCalled;
    void SendCleanupNotify () {
        if (m_blCleanupMethodCalled == false) {
            m_blCleanupMethodCalled = true;
            rg_n1714 ();
        }
    }
    @Override protected void onCreate (android.os.Bundle savedInstanceState) {
        super.onCreate (savedInstanceState);
        rg_n2195.sPermitDiskAndNetworkOperInsideUIThread ();
        if (getClass ().equals (source.SoftwareManagerAndroid.rg_n.class))
            rg_n2195.sOnStartupClassEnter ();
        android.content.Intent objIntent = getIntent ();
        final int nParamDataIdentifier = objIntent.getIntExtra (cs_strActivityLoadParams, 0);
        Object[] aryParams = rg_n2195.sGetGlobalDataCache ().Pop (nParamDataIdentifier);
        if (nParamDataIdentifier != 0 && aryParams == null)
            rg_n2195.sForceRestart ();
        if (onInitAndroidActivity () == false) {
            finish ();
            return;
        }
        rg_n8 (objIntent, aryParams, (aryParams == null ? 0 : aryParams.length));
    }
    @Override public boolean onCreateOptionsMenu (android.view.Menu menu) {
        final boolean blDisplay = rg_n1718 (menu);
        return (super.onCreateOptionsMenu (menu) && blDisplay);
    }
    @Override public boolean onPrepareOptionsMenu (android.view.Menu menu) {
        final boolean blDisplay = rg_n1720 (menu);
        return (super.onPrepareOptionsMenu (menu) && blDisplay);
    }
    @Override public boolean onOptionsItemSelected (android.view.MenuItem item) {
        if (rg_n1725 (item, false))
            return true;
        return super.onOptionsItemSelected (item);
    }
    @Override public void onOptionsMenuClosed (android.view.Menu menu) {
        rg_n1728 (menu, false);
         super.onOptionsMenuClosed (menu);
    }
    @Override public boolean onContextItemSelected (android.view.MenuItem item) {
        if (rg_n1725 (item, true))
            return true;
        return super.onContextItemSelected (item);
    }
    @Override public void onContextMenuClosed (android.view.Menu menu) {
        rg_n1728 (menu, true);
        super.onContextMenuClosed (menu);
    }
    @Override public void onCreateContextMenu (android.view.ContextMenu menu, View v, android.view.ContextMenu.ContextMenuInfo menuInfo) {
        AndroidView volView = AndroidView.sSafeGetVolView (v);
        if (volView != null)
            rg_n1722 (volView, menu);
        super.onCreateContextMenu (menu, v, menuInfo);
    }
    protected void onActivityResult (int requestCode, int resultCode, android.content.Intent data) {
        super.onActivityResult (requestCode, resultCode, data);
        rg_n1731 (requestCode, resultCode, data);
    }
    @Override public boolean dispatchKeyEvent (android.view.KeyEvent event) {
        if (rg_n1739 (event))
            return true;
        return super.dispatchKeyEvent (event);
    }
    @Override public boolean dispatchKeyShortcutEvent (android.view.KeyEvent event) {
        if (rg_n1741 (event))
            return true;
        return super.dispatchKeyShortcutEvent (event);
    }
    @Override public boolean dispatchTouchEvent (android.view.MotionEvent event) {
        if (rg_n1747 (event))
            return true;
        return super.dispatchTouchEvent (event);
    }
    @Override public boolean dispatchTrackballEvent (android.view.MotionEvent event) {
        if (rg_n1751 (event))
            return true;
        return super.dispatchTrackballEvent (event);
    }
    @Override public boolean dispatchGenericMotionEvent (android.view.MotionEvent event) {
        if (rg_n1735 (event))
            return true;
        return super.dispatchGenericMotionEvent (event);
    }
    @Override public boolean onTouchEvent (android.view.MotionEvent event) {
        if (rg_n1749 (event))
            return true;
        return super.onTouchEvent (event);
    }
    @Override public boolean onGenericMotionEvent (android.view.MotionEvent event) {
        if (rg_n1737 (event))
            return true;
        return super.onGenericMotionEvent (event);
    }
    @Override public boolean onTrackballEvent (android.view.MotionEvent event) {
        if (rg_n1753 (event))
            return true;
        return super.onTrackballEvent (event);
    }
    @Override public boolean onKeyDown (int keyCode, android.view.KeyEvent event) {
        if (rg_n1743 (rg_n14348.rg_n14349, keyCode, event))
            return true;
        return super.onKeyDown (keyCode, event);
    }
    @Override public boolean onKeyLongPress (int keyCode, android.view.KeyEvent event) {
        if (rg_n1743 (rg_n14348.rg_n14351, keyCode, event))
            return true;
        return super.onKeyLongPress (keyCode, event);
    }
    @Override public boolean onKeyMultiple (int keyCode, int repeatCount, android.view.KeyEvent event) {
        if (rg_n1743 (rg_n14348.rg_n14352, keyCode, event))
            return true;
        return super.onKeyMultiple (keyCode, repeatCount, event);
    }
    @Override public boolean onKeyShortcut (int keyCode, android.view.KeyEvent event) {
        if (rg_n1743 (rg_n14348.rg_n14353, keyCode, event))
            return true;
        return super.onKeyShortcut (keyCode, event);
    }
    @Override public boolean onKeyUp (int keyCode, android.view.KeyEvent event) {
        if (rg_n1743 (rg_n14348.rg_n14350, keyCode, event))
            return true;
        return super.onKeyUp (keyCode, event);
    }
    @Override public void onBackPressed () {
        if (rg_n1755 ())
            return;
        super.onBackPressed ();
    }
    @Override public void onUserInteraction () {
        super.onUserInteraction ();
        rg_n1757 ();
    }
    @Override public void onUserLeaveHint () {
        rg_n1758 ();
        super.onUserLeaveHint ();
    }
    @Override public void onWindowFocusChanged (boolean hasFocus) {
        super.onWindowFocusChanged (hasFocus);
        rg_n1759 (hasFocus);
    }
    @Override public CharSequence onCreateDescription () {
        final String strDesc = rg_n1756 ();
        return (strDesc != null ? strDesc : super.onCreateDescription ());
    }

    public void rg_n8 (android.content.Intent rg_n1706, java.lang.Object [] rg_n1707, int rg_n1708) {
    }

    public void rg_n43 () {
    }

    public void rg_n1709 () {
    }

    public void rg_n1710 (android.content.Intent rg_n1711) {
    }

    public void rg_n1712 () {
    }

    public void rg_n1713 () {
    }

    public void rg_n1714 () {
    }

    public void rg_n1715 () {
    }

    public void rg_n1716 () {
    }

    public void rg_n1717 () {
    }

    public boolean rg_n1718 (android.view.Menu rg_n1719) {
        return (true);
    }

    public boolean rg_n1720 (android.view.Menu rg_n1721) {
        return (true);
    }

    public void rg_n1722 (AndroidView rg_n1723, android.view.ContextMenu rg_n1724) {
    }

    public boolean rg_n1725 (android.view.MenuItem rg_n1726, boolean rg_n1727) {
        return (false);
    }

    public void rg_n1728 (android.view.Menu rg_n1729, boolean rg_n1730) {
    }

    public void rg_n1731 (int rg_n1732, int rg_n1733, android.content.Intent rg_n1734) {
    }

    public boolean rg_n1735 (android.view.MotionEvent rg_n1736) {
        return (false);
    }

    public boolean rg_n1737 (android.view.MotionEvent rg_n1738) {
        return (false);
    }

    public boolean rg_n1739 (android.view.KeyEvent rg_n1740) {
        return (false);
    }

    public boolean rg_n1741 (android.view.KeyEvent rg_n1742) {
        return (false);
    }

    public boolean rg_n1743 (int rg_n1744, int rg_n1745, android.view.KeyEvent rg_n1746) {
        return (false);
    }

    public boolean rg_n1747 (android.view.MotionEvent rg_n1748) {
        return (false);
    }

    public boolean rg_n1749 (android.view.MotionEvent rg_n1750) {
        return (false);
    }

    public boolean rg_n1751 (android.view.MotionEvent rg_n1752) {
        return (false);
    }

    public boolean rg_n1753 (android.view.MotionEvent rg_n1754) {
        return (false);
    }

    public boolean rg_n1755 () {
        return (false);
    }

    public String rg_n1756 () {
        return (null);
    }

    public void rg_n1757 () {
    }

    public void rg_n1758 () {
    }

    public void rg_n1759 (boolean rg_n1760) {
    }

    @Override public void onRequestPermissionsResult (int rg_n1761, String [] rg_n1762, int [] rg_n1763) {
    }

    public AndroidViewGroup GetAndroidActivityContainer () {
        return (null);
    }
}
