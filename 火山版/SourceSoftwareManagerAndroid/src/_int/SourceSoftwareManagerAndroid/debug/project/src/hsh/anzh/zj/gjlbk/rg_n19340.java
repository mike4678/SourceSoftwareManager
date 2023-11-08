
package hsh.anzh.zj.gjlbk;

import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;

public class rg_n19340 extends rg_n19203 {

    public rg_n19340 () {
        rg_n19341 ();
    }

        class NativeLinearManager extends LinearLayoutManager {
            public NativeLinearManager (android.content.Context c, int o, boolean f) {
                super (c, o, f);
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
            @Override
            public void onMeasure(RecyclerView.Recycler recycler, RecyclerView.State state, int widthSpec, int heightSpec) {
                rg_n19168 size = new rg_n19168 ();
                size.rg_n19169 = widthSpec;
                size.rg_n19170 = heightSpec;
                rg_n19204 (state, widthSpec, heightSpec, size);
                super.onMeasure(recycler, state, size.rg_n19169, size.rg_n19170);
            }
        }

    public void rg_n19341 () {
        layoutObj = new NativeLinearManager (hsh.anzh.jb.rg_n2195.sGetApp (), 1, false);
    }

    public void rg_n19342 (int rg_n19343) {
        ((NativeLinearManager)layoutObj).setOrientation (rg_n19343);
    }

    public void rg_n19349 (boolean rg_n19350) {
        ((NativeLinearManager)layoutObj).setSmoothScrollbarEnabled (rg_n19350);
    }
}
