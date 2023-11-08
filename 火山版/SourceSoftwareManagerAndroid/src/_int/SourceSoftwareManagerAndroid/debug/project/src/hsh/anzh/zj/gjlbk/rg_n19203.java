
package hsh.anzh.zj.gjlbk;

import android.support.v7.widget.RecyclerView;

public class rg_n19203 {

    public rg_n19203 ()  { }

        public RecyclerView.LayoutManager layoutObj = null;
        public class NativeLayoutManager extends RecyclerView.LayoutManager {
            @Override
            public RecyclerView.LayoutParams generateDefaultLayoutParams() {
                return new RecyclerView.LayoutParams(android.view.ViewGroup.LayoutParams.WRAP_CONTENT, android.view.ViewGroup.LayoutParams.WRAP_CONTENT);
            }
            @Override
            public void onMeasure(RecyclerView.Recycler recycler, RecyclerView.State state, int widthSpec, int heightSpec) {
                rg_n19168 size = new rg_n19168 ();
                size.rg_n19169 = widthSpec;
                size.rg_n19170 = heightSpec;
                rg_n19204 (state, widthSpec, heightSpec, size);
                super.onMeasure(recycler, state, size.rg_n19169, size.rg_n19170);
            }
            @Override
            public boolean supportsPredictiveItemAnimations () {
                return false;
            }
        }

    public static interface re_n19204 { int dispatch (rg_n19203 objSource, int nTagNumber, android.support.v7.widget.RecyclerView.State rg_n19205, int rg_n19206, int rg_n19207, rg_n19168 rg_n19208); }
    private re_n19204 rd_n19204;
    private int rd_n19204_tag;
    public void rl_n19203_n19204 (re_n19204 objListener, int nTagNumber) {
        synchronized (this) { rd_n19204 = objListener;  rd_n19204_tag = nTagNumber; }
    }
    public int rg_n19204 (android.support.v7.widget.RecyclerView.State rg_n19205, int rg_n19206, int rg_n19207, rg_n19168 rg_n19208) {
        re_n19204 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19204;  nTagNumber = rd_n19204_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19205, rg_n19206, rg_n19207, rg_n19208) : 0);
    }

    public static interface re_n19209 { int dispatch (rg_n19203 objSource, int nTagNumber, rg_n19032 rg_n19210, int rg_n19211, int rg_n19212); }
    private re_n19209 rd_n19209;
    private int rd_n19209_tag;
    public void rl_n19203_n19209 (re_n19209 objListener, int nTagNumber) {
        synchronized (this) { rd_n19209 = objListener;  rd_n19209_tag = nTagNumber; }
    }
    public int rg_n19209 (rg_n19032 rg_n19210, int rg_n19211, int rg_n19212) {
        re_n19209 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19209;  nTagNumber = rd_n19209_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19210, rg_n19211, rg_n19212) : 0);
    }

    public static interface re_n19213 { int dispatch (rg_n19203 objSource, int nTagNumber, rg_n19032 rg_n19214, int rg_n19215, int rg_n19216); }
    private re_n19213 rd_n19213;
    private int rd_n19213_tag;
    public void rl_n19203_n19213 (re_n19213 objListener, int nTagNumber) {
        synchronized (this) { rd_n19213 = objListener;  rd_n19213_tag = nTagNumber; }
    }
    public int rg_n19213 (rg_n19032 rg_n19214, int rg_n19215, int rg_n19216) {
        re_n19213 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19213;  nTagNumber = rd_n19213_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19214, rg_n19215, rg_n19216) : 0);
    }

    public static interface re_n19217 { int dispatch (rg_n19203 objSource, int nTagNumber, rg_n19032 rg_n19218, int rg_n19219, int rg_n19220); }
    private re_n19217 rd_n19217;
    private int rd_n19217_tag;
    public void rl_n19203_n19217 (re_n19217 objListener, int nTagNumber) {
        synchronized (this) { rd_n19217 = objListener;  rd_n19217_tag = nTagNumber; }
    }
    public int rg_n19217 (rg_n19032 rg_n19218, int rg_n19219, int rg_n19220) {
        re_n19217 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19217;  nTagNumber = rd_n19217_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19218, rg_n19219, rg_n19220) : 0);
    }

    public static interface re_n19221 { int dispatch (rg_n19203 objSource, int nTagNumber, rg_n19032 rg_n19222, int rg_n19223, int rg_n19224, int rg_n19225); }
    private re_n19221 rd_n19221;
    private int rd_n19221_tag;
    public void rl_n19203_n19221 (re_n19221 objListener, int nTagNumber) {
        synchronized (this) { rd_n19221 = objListener;  rd_n19221_tag = nTagNumber; }
    }
    public int rg_n19221 (rg_n19032 rg_n19222, int rg_n19223, int rg_n19224, int rg_n19225) {
        re_n19221 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19221;  nTagNumber = rd_n19221_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19222, rg_n19223, rg_n19224, rg_n19225) : 0);
    }

    public static interface re_n19226 { int dispatch (rg_n19203 objSource, int nTagNumber, rg_n19032 rg_n19227); }
    private re_n19226 rd_n19226;
    private int rd_n19226_tag;
    public void rl_n19203_n19226 (re_n19226 objListener, int nTagNumber) {
        synchronized (this) { rd_n19226 = objListener;  rd_n19226_tag = nTagNumber; }
    }
    public int rg_n19226 (rg_n19032 rg_n19227) {
        re_n19226 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19226;  nTagNumber = rd_n19226_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19227) : 0);
    }

    public int rg_n19253 (hsh.anzh.jb.AndroidView rg_n19254) {
        try {
            return layoutObj.getLeftDecorationWidth (rg_n19254.GetView ());
        } catch (Exception e) {
            return -1;
        }
    }

    public int rg_n19259 (hsh.anzh.jb.AndroidView rg_n19260) {
        try {
            return layoutObj.getBottomDecorationHeight (rg_n19260.GetView ());
        } catch (Exception e) {
            return -1;
        }
    }
}
