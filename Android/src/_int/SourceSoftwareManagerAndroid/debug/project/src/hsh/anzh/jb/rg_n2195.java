
package hsh.anzh.jb;

public class rg_n2195 extends android.app.Application {

    protected java.util.HashMap<String, java.lang.Object> rg_n2196 = new java.util.HashMap<String, java.lang.Object> ();
    private static rg_n2195 ms_objApp;
    protected rg_n2262 rg_n2260 = new rg_n2262 ();
    protected rg_n2263 rg_n2261 = new rg_n2263 ();
    public void onCreate () {
        super.onCreate ();
        sPermitDiskAndNetworkOperInsideUIThread ();
        ms_objApp = this;
        rg_n2261.init ();
        rg_n2197 ();
    }
    public static void sPermitDiskAndNetworkOperInsideUIThread () {
        android.os.StrictMode.setThreadPolicy (new android.os.StrictMode.ThreadPolicy.Builder ().permitAll ().build ());
    }
    public static void sRunOnUiThread (Runnable action) {
        ms_objApp.rg_n2261.RunOnUiThread (action);
    }
    public static rg_n2195 sGetApp () {
        return ms_objApp;
    }
    public static rg_n2262 sGetGlobalDataCache () {
        return ms_objApp.rg_n2260;
    }
    public static boolean sIsUiThread () {
        return ms_objApp.rg_n2261.IsUiThread ();
    }
    private void CleanupGlobalData () {
        rg_n2198 ();
        rg_n2196.clear ();
        rg_n2260.Cleanup ();
    }
    private int m_nStartupState = 0;
    private static int ms_nStartupState = 0;
    public static void sOnStartupClassEnter () {
        ms_objApp.m_nStartupState = ms_nStartupState = 1;
        ms_objApp.CleanupGlobalData ();
    }
    public static boolean sCheckRestart (android.content.Context context) {
        if (ms_objApp.m_nStartupState == 1 && ms_nStartupState == 1)
            return true;
        Class<?> clsStartup = source.SoftwareManagerAndroid.rg_n.class;
        if (android.app.Activity.class.isAssignableFrom (clsStartup)) {
            try {
                android.content.Intent intent = new android.content.Intent (context, clsStartup);
                intent.addFlags (android.content.Intent.FLAG_ACTIVITY_CLEAR_TOP |
                        android.content.Intent.FLAG_ACTIVITY_CLEAR_TASK |
                        android.content.Intent.FLAG_ACTIVITY_NEW_TASK);
                context.startActivity (intent);
            } catch (Exception e) { }
        }
        return false;
    }
    public static void sForceRestart () {
        ms_objApp.m_nStartupState = ms_nStartupState = -1;
    }
    private static final String cs_strServiceStartUserData = "@service_start_user_data";
    public static int sGetServiceStartUserData (android.content.Intent objIntent) {
        return objIntent.getIntExtra (cs_strServiceStartUserData, 0);
    }
    public static final String cs_strServiceStartParams = "@service_start_params";
    public static boolean sMyStartService (Class clsService, android.os.Bundle bundle, Object... params) {
        rg_n2262 objCache = sGetGlobalDataCache ();
        int nParamDataIdentifier = 0;
        try {
            android.content.Intent objIntent = new android.content.Intent (ms_objApp, clsService);
            if (bundle != null)
                objIntent.putExtras (bundle);
            if (params != null && params.length > 0) {
                nParamDataIdentifier = objCache.Push (params);
                objIntent.putExtra (cs_strServiceStartParams, nParamDataIdentifier);
            }
            if (ms_objApp.startService (objIntent) != null)
                return true;
        } catch (Exception e) { }
        objCache.Remove (nParamDataIdentifier);
        return false;
    }
    public static boolean sMyStopService (Class clsService) {
        android.content.Intent objIntent = new android.content.Intent (ms_objApp, clsService);
        try {
            return ms_objApp.stopService (objIntent);
        } catch (Exception e) {
            return false;
        }
    }

    public void rg_n2197 () {
    }

    public void rg_n2198 () {
    }

    public static android.content.res.Resources rg_n2245 () {
        return ms_objApp.getResources ();
    }

    public static android.content.res.AssetManager rg_n2246 () {
        return ms_objApp.getAssets ();
    }
}
