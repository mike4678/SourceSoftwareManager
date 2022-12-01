
package hsh.Java.shjk.JDBC;

public class rg_n38903 {

    public static boolean rg_n38976 (java.sql.Connection rg_n38977, int rg_n38978) {
        try {
            java.sql.DatabaseMetaData data = rg_n38977.getMetaData();
            if (data == null || data.getJDBCMajorVersion() < 4) return false;
            return rg_n38977.isValid(rg_n38978);
        }catch (Exception e){ return false; }
    }
}
