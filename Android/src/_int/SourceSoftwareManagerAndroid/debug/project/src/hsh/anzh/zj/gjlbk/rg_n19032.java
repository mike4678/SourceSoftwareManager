
package hsh.anzh.zj.gjlbk;

import android.app.Activity;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n19032 extends hsh.anzh.jb.AndroidViewGroup {

    public rg_n19032 ()  { }

    public rg_n19032 (android.content.Context context, rg_n19031 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n19032 (android.content.Context context, rg_n19031 view) { this (context, view, null); }
    public rg_n19031 GetRecyclerView () { return (rg_n19031)GetView (); }
    public static rg_n19032 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n19031 (context), null);
    }
    public static rg_n19032 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n19031 (context), objInitData);
    }
    public static rg_n19032 sNewInstanceAndAttachView (android.content.Context context, rg_n19031 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n19032 sNewInstanceAndAttachView (android.content.Context context, rg_n19031 viewAttach, Object objInitData) {
        rg_n19032 objControl = new rg_n19032 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
     private rg_n19203 mLayoutManager = null;
     private android.content.Context mContext;
     protected void OnInitView (android.content.Context context, Object objInitData) {
         super.OnInitView (context, objInitData);
         GetRecyclerView ().setRecyclerListener (new RecyclerView.RecyclerListener () {
                @Override public void onViewRecycled (RecyclerView.ViewHolder viewHolder) {
                    rg_n19045 ((android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder) viewHolder);
                }
         });
         GetRecyclerView ().setChildDrawingOrderCallback (new RecyclerView.ChildDrawingOrderCallback () {
                @Override public int onGetChildDrawingOrder (int childCount, int i) {
                    int result = rg_n19039 (childCount, i + 1);
                    return result == 0 ? i : result - 1;
                }
         });
         GetRecyclerView ().addOnItemTouchListener (new RecyclerView.OnItemTouchListener () {
                @Override public boolean onInterceptTouchEvent (RecyclerView rv, android.view.MotionEvent e) {
                    return rg_n19037 (e) == 0 ? false : true;
                }
                @Override public void onRequestDisallowInterceptTouchEvent (boolean disallowIntercept) { }
                @Override public void onTouchEvent (RecyclerView rv, android.view.MotionEvent e) { }
         });
         GetRecyclerView ().addOnScrollListener(new android.support.v7.widget.RecyclerView.OnScrollListener() {
                @Override public void onScrollStateChanged(android.support.v7.widget.RecyclerView recyclerView, int newState) {
                    rg_n19047 (newState);
                }
                @Override public void onScrolled(android.support.v7.widget.RecyclerView recyclerView, int dx, int dy) {
                    rg_n19049 (dx, dy);
                }
         });
         GetRecyclerView ().addOnChildAttachStateChangeListener(new android.support.v7.widget.RecyclerView.OnChildAttachStateChangeListener() {
                @Override public void onChildViewAttachedToWindow(android.view.View view) {
                    rg_n19033 (hsh.anzh.jb.AndroidView.sSafeGetVolView(view));
                }
                @Override public void onChildViewDetachedFromWindow(android.view.View view) {
                    rg_n19035 (hsh.anzh.jb.AndroidView.sSafeGetVolView(view));
                }
         });
     }

    public static interface re_n19033 { int dispatch (rg_n19032 objSource, int nTagNumber, hsh.anzh.jb.AndroidView rg_n19034); }
    private re_n19033 rd_n19033;
    private int rd_n19033_tag;
    public void rl_n19032_n19033 (re_n19033 objListener, int nTagNumber) {
        synchronized (this) { rd_n19033 = objListener;  rd_n19033_tag = nTagNumber; }
    }
    public int rg_n19033 (hsh.anzh.jb.AndroidView rg_n19034) {
        re_n19033 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19033;  nTagNumber = rd_n19033_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19034) : 0);
    }

    public static interface re_n19035 { int dispatch (rg_n19032 objSource, int nTagNumber, hsh.anzh.jb.AndroidView rg_n19036); }
    private re_n19035 rd_n19035;
    private int rd_n19035_tag;
    public void rl_n19032_n19035 (re_n19035 objListener, int nTagNumber) {
        synchronized (this) { rd_n19035 = objListener;  rd_n19035_tag = nTagNumber; }
    }
    public int rg_n19035 (hsh.anzh.jb.AndroidView rg_n19036) {
        re_n19035 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19035;  nTagNumber = rd_n19035_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19036) : 0);
    }

    public static interface re_n19037 { int dispatch (rg_n19032 objSource, int nTagNumber, android.view.MotionEvent rg_n19038); }
    private re_n19037 rd_n19037;
    private int rd_n19037_tag;
    public void rl_n19032_n19037 (re_n19037 objListener, int nTagNumber) {
        synchronized (this) { rd_n19037 = objListener;  rd_n19037_tag = nTagNumber; }
    }
    public int rg_n19037 (android.view.MotionEvent rg_n19038) {
        re_n19037 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19037;  nTagNumber = rd_n19037_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19038) : 0);
    }

    public static interface re_n19039 { int dispatch (rg_n19032 objSource, int nTagNumber, int rg_n19040, int rg_n19041); }
    private re_n19039 rd_n19039;
    private int rd_n19039_tag;
    public void rl_n19032_n19039 (re_n19039 objListener, int nTagNumber) {
        synchronized (this) { rd_n19039 = objListener;  rd_n19039_tag = nTagNumber; }
    }
    public int rg_n19039 (int rg_n19040, int rg_n19041) {
        re_n19039 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19039;  nTagNumber = rd_n19039_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19040, rg_n19041) : 0);
    }

    public static interface re_n19045 { int dispatch (rg_n19032 objSource, int nTagNumber, android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19046); }
    private re_n19045 rd_n19045;
    private int rd_n19045_tag;
    public void rl_n19032_n19045 (re_n19045 objListener, int nTagNumber) {
        synchronized (this) { rd_n19045 = objListener;  rd_n19045_tag = nTagNumber; }
    }
    public int rg_n19045 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19046) {
        re_n19045 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19045;  nTagNumber = rd_n19045_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19046) : 0);
    }

    public static interface re_n19047 { int dispatch (rg_n19032 objSource, int nTagNumber, int rg_n19048); }
    private re_n19047 rd_n19047;
    private int rd_n19047_tag;
    public void rl_n19032_n19047 (re_n19047 objListener, int nTagNumber) {
        synchronized (this) { rd_n19047 = objListener;  rd_n19047_tag = nTagNumber; }
    }
    public int rg_n19047 (int rg_n19048) {
        re_n19047 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19047;  nTagNumber = rd_n19047_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19048) : 0);
    }

    public static interface re_n19049 { int dispatch (rg_n19032 objSource, int nTagNumber, int rg_n19050, int rg_n19051); }
    private re_n19049 rd_n19049;
    private int rd_n19049_tag;
    public void rl_n19032_n19049 (re_n19049 objListener, int nTagNumber) {
        synchronized (this) { rd_n19049 = objListener;  rd_n19049_tag = nTagNumber; }
    }
    public int rg_n19049 (int rg_n19050, int rg_n19051) {
        re_n19049 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n19049;  nTagNumber = rd_n19049_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n19050, rg_n19051) : 0);
    }

    public void rg_n19072 (final rg_n19203 rg_n19073) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                mLayoutManager = rg_n19073;
                GetRecyclerView ().setLayoutManager (rg_n19073.layoutObj);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        mLayoutManager = rg_n19073;
                            GetRecyclerView ().setLayoutManager (rg_n19073.layoutObj);
                    } catch (Exception e) { }
                } } );
        }
    }

    public rg_n19203 rg_n19074 () {
        mLayoutManager.layoutObj = GetRecyclerView ().getLayoutManager ();
        return mLayoutManager;
    }

    public void rg_n19075 (final rg_n19462 rg_n19076) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetRecyclerView ().setItemAnimator (rg_n19076);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetRecyclerView ().setItemAnimator (rg_n19076);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n19078 (final rg_n19514 rg_n19079) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetRecyclerView ().setAdapter (rg_n19079);
                rg_n19079.rg_n19515 = (rg_n19032)hsh.anzh.jb.AndroidView.sSafeGetVolView (GetRecyclerView ());
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetRecyclerView ().setAdapter (rg_n19079);
                            rg_n19079.rg_n19515 = (rg_n19032)hsh.anzh.jb.AndroidView.sSafeGetVolView (GetRecyclerView ());
                    } catch (Exception e) { }
                } } );
        }
    }

    public hsh.anzh.jb.AndroidView rg_n19112 (hsh.anzh.jb.AndroidView rg_n19113) {
        try {
            return hsh.anzh.jb.AndroidView.sSafeGetVolView(GetRecyclerView().findContainingItemView (rg_n19113.GetView ()));
        } catch (Exception e) {
            return null;
        }
    }

    public android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19114 (hsh.anzh.jb.AndroidView rg_n19115) {
        try {
            return (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder)GetRecyclerView().findContainingViewHolder (rg_n19115.GetView ());
        } catch (Exception e) {
            return null;
        }
    }

    public int rg_n19127 (hsh.anzh.jb.AndroidView rg_n19128) {
        try {
            return GetRecyclerView().getChildAdapterPosition (rg_n19128.GetView ());
        } catch (Exception e) {
            return -1;
        }
    }
}
