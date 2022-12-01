
package hsh.anzh.zj.gjlbk;

import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.ItemDecoration;

public class rg_n19360 extends android.support.v7.widget.DividerItemDecoration {

    public int rg_n19361 = -6381408;
        public rg_n19360 () {
            super (hsh.anzh.jb.rg_n2195.sGetApp(), 0);
        }
        public rg_n19360 (android.content.Context context, int ovr) {
            super (context, ovr);
        }
        @Override public void onDraw (android.graphics.Canvas canvas, RecyclerView recyclerView, RecyclerView.State state) {
            super.onDraw (canvas, recyclerView, state);
            if(rg_n19362 (canvas, (rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView(recyclerView), state) == 0) {
                if (rg_n19361 != -1) {
                    canvas.drawColor (rg_n19361);
                }
            }
        }
        @Override public void getItemOffsets(android.graphics.Rect outRect, android.view.View view, RecyclerView parent, RecyclerView.State state) {
            super.getItemOffsets (outRect, view, parent, state);
            rg_n19366 (outRect, hsh.anzh.jb.AndroidView.sSafeGetVolView(view), (rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView(parent), state);
        }

    public static interface re_n19362 { int dispatch (rg_n19360 objSource, int nTagNumber, android.graphics.Canvas rg_n19363, rg_n19032 rg_n19364, android.support.v7.widget.RecyclerView.State rg_n19365); }
    private re_n19362 rd_n19362;
    private int rd_n19362_tag;
    public void rl_n19360_n19362 (re_n19362 objListener, int nTagNumber) {
        synchronized (this) { rd_n19362 = objListener;  rd_n19362_tag = nTagNumber; }
    }
    public int rg_n19362 (android.graphics.Canvas rg_n19363, rg_n19032 rg_n19364, android.support.v7.widget.RecyclerView.State rg_n19365) {
        re_n19362 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19362;  nTagNumber = rd_n19362_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19363, rg_n19364, rg_n19365) : 0);
    }

    public static interface re_n19366 { int dispatch (rg_n19360 objSource, int nTagNumber, android.graphics.Rect rg_n19367, hsh.anzh.jb.AndroidView rg_n19368, rg_n19032 rg_n19369, android.support.v7.widget.RecyclerView.State rg_n19370); }
    private re_n19366 rd_n19366;
    private int rd_n19366_tag;
    public void rl_n19360_n19366 (re_n19366 objListener, int nTagNumber) {
        synchronized (this) { rd_n19366 = objListener;  rd_n19366_tag = nTagNumber; }
    }
    public int rg_n19366 (android.graphics.Rect rg_n19367, hsh.anzh.jb.AndroidView rg_n19368, rg_n19032 rg_n19369, android.support.v7.widget.RecyclerView.State rg_n19370) {
        re_n19366 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19366;  nTagNumber = rd_n19366_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19367, rg_n19368, rg_n19369, rg_n19370) : 0);
    }

    public static void rg_n19371 (rg_n19360 rg_n19372, int rg_n19373) {
        rg_n19372.setOrientation (rg_n19373);
    }
}
