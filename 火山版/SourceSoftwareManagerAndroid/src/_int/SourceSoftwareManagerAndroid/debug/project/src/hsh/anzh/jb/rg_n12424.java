
package hsh.anzh.jb;

public class rg_n12424 {

    public static double LP2DP (final int nUnitType, final double dbLPSize) {
        android.util.DisplayMetrics metrics = rg_n2195.rg_n2245 ().getDisplayMetrics ();
        switch (nUnitType) {
            case rg_n12417.rg_n12418:
                return dbLPSize;
            case rg_n12417.rg_n12419:
                return dbLPSize * metrics.density;
            case rg_n12417.rg_n12420:
                return dbLPSize * metrics.scaledDensity;
            case rg_n12417.rg_n12421:
                return dbLPSize * metrics.xdpi * (1.0 / 72);
            case rg_n12417.rg_n12422:
                return dbLPSize * metrics.xdpi;
            case rg_n12417.rg_n12423:
                return dbLPSize * metrics.xdpi * (1.0 / 25.4);
            }
        return 0;
    }
    public static double DP2LP (final int nUnitType, final double dbDPSize) {
        android.util.DisplayMetrics metrics = rg_n2195.rg_n2245 ().getDisplayMetrics ();
        switch (nUnitType) {
            case rg_n12417.rg_n12418:
                return dbDPSize;
            case rg_n12417.rg_n12419:
                return dbDPSize / metrics.density;
            case rg_n12417.rg_n12420:
                return dbDPSize / metrics.scaledDensity;
            case rg_n12417.rg_n12421:
                return dbDPSize * 72 / metrics.xdpi;
            case rg_n12417.rg_n12422:
                return dbDPSize / metrics.xdpi;
            case rg_n12417.rg_n12423:
                return dbDPSize * 25.4 / metrics.xdpi;
            }
        return 0;
    }

    public static android.graphics.drawable.Drawable rg_n12449 (int rg_n12450) {
        if (rg_n12450 == (int)0)
            return null;
        try {
            return rg_n2195.rg_n2245 ().getDrawable (rg_n12450);
        } catch (Exception e) {
            return null;
        }
    }

    public static double rg_n12459 (int rg_n12460, double rg_n12461) {
        return LP2DP (rg_n12460, rg_n12461);
    }

    public static double rg_n12465 (double rg_n12466) {
        return (rg_n12459 (rg_n12417.rg_n12419, rg_n12466));
    }

    public static double rg_n12469 (double rg_n12470) {
        return (rg_n12459 (rg_n12417.rg_n12420, rg_n12470));
    }
}
