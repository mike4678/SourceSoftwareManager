
package hsh.anzh.zj.gjlbk;

import android.support.v7.widget.GridLayoutManager;

public class rg_n19291 extends rg_n19203 {

    public rg_n19291 ()  { }

        private rg_n19291 create (android.content.Context c, int co, int o, boolean f, rg_n19291 thiz) {
            thiz.layoutObj = new NativeGridLayoutManager (c, co, o, f);
            return thiz;
        }
        class NativeGridLayoutManager extends GridLayoutManager {
            public NativeGridLayoutManager (android.content.Context c, int co, int o, boolean f) {
                super (c, co, o, f);
            }
            @Override
            public void onItemsRemoved (android.support.v7.widget.RecyclerView recyclerView, int positionStart, int itemCount) {
                rg_n19209 ((rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView (recyclerView), positionStart, itemCount);
                super.onItemsRemoved (recyclerView, positionStart, itemCount);
            }
            @Override
            public void onItemsAdded (android.support.v7.widget.RecyclerView recyclerView, int positionStart, int itemCount) {
                rg_n19213 ((rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView (recyclerView), positionStart, itemCount);
                super.onItemsAdded (recyclerView, positionStart, itemCount);
            }
            @Override
            public void onItemsUpdated (android.support.v7.widget.RecyclerView recyclerView, int positionStart, int itemCount) {
                rg_n19217 ((rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView (recyclerView), positionStart, itemCount);
                super.onItemsUpdated (recyclerView, positionStart, itemCount);
            }
            @Override
            public void onItemsMoved (android.support.v7.widget.RecyclerView recyclerView, int form, int to, int itemCount) {
                rg_n19221 ((rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView (recyclerView), form, to,  itemCount);
                super.onItemsMoved (recyclerView, form, to, itemCount);
            }
            @Override
            public void onItemsChanged (android.support.v7.widget.RecyclerView recyclerView) {
                rg_n19226 ((rg_n19032) hsh.anzh.jb.AndroidView.sSafeGetVolView (recyclerView));
                super.onItemsChanged (recyclerView);
            }
        }

    public void rg_n19297 (int rg_n19298) {
        ((NativeGridLayoutManager)layoutObj).setSpanCount (rg_n19298);
    }

    public static rg_n19291 rg_n19299 (android.content.Context rg_n19300, int rg_n19301, int rg_n19302, boolean rg_n19303) {
        rg_n19291 rg_n19304;
        rg_n19304 = new rg_n19291 ();
        return rg_n19304.create (rg_n19300, rg_n19301, rg_n19302, rg_n19303, rg_n19304);
    }
}
