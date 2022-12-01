
package hsh.anzh.jb;

public class rg_n8104 {

    static int computeSampleSize (final int nBitmapWidth, final int nBitmapHeight, int nReqMinSideLength) {
        if (nReqMinSideLength < 0)
            return 1;
        if (nReqMinSideLength <= 1) {
            android.util.DisplayMetrics infDisplay = rg_n2195.rg_n2245 ().getDisplayMetrics ();
            if (nReqMinSideLength == 0)
                nReqMinSideLength = Math.min (infDisplay.widthPixels, infDisplay.heightPixels);
            else
                nReqMinSideLength = Math.max (infDisplay.widthPixels, infDisplay.heightPixels);
        }
        return computeSampleSize (nBitmapWidth, nBitmapHeight, nReqMinSideLength, nReqMinSideLength * nReqMinSideLength);
    }
    static int computeSampleSize (final int nBitmapWidth, final int nBitmapHeight, int nReqMinSideLength, int nReqMaxNumOfPixels) {
        if (nReqMaxNumOfPixels == -1 && nReqMinSideLength == -1)
            return 1;
        double w = nBitmapWidth;
        double h = nBitmapHeight;
        int nSampleSize1 = (nReqMaxNumOfPixels == -1) ? 1 : (int) Math.ceil (Math.sqrt (w * h / nReqMaxNumOfPixels));
        int nSampleSize2 = (nReqMinSideLength == -1) ? 128 :
                (int)Math.min (Math.floor (w / nReqMinSideLength), Math.floor (h / nReqMinSideLength));
        int initialSize;
        if (nReqMaxNumOfPixels == -1)
            initialSize = nSampleSize2;
        else if (nReqMinSideLength == -1)
            initialSize = nSampleSize1;
        else
            initialSize = Math.max (nSampleSize1, nSampleSize2);
        int roundedSize;
        if (initialSize <= 8 ) {
            roundedSize = 1;
            while (roundedSize < initialSize)
                roundedSize <<= 1;
        }
        else
            roundedSize = (initialSize + 7) / 8 * 8;
        return roundedSize;
    }

    public static boolean rg_n8174 (android.graphics.Bitmap rg_n8175, int rg_n8176, int rg_n8177, java.io.OutputStream rg_n8178) {
        android.graphics.Bitmap.CompressFormat format;
        switch (rg_n8176) {
            case rg_n7990.rg_n7991:  format = android.graphics.Bitmap.CompressFormat.JPEG; break;
            case rg_n7990.rg_n7993:  format = android.graphics.Bitmap.CompressFormat.WEBP; break;
            default:  format = android.graphics.Bitmap.CompressFormat.PNG; break;
        }
        return rg_n8175.compress (format, Math.max (0, Math.min (100, rg_n8177)), rg_n8178);
    }
}
