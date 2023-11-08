
package hsh.anzh.zj.zl;

import android.app.Activity;
import android.support.v4.view.ViewPager;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class rg_n16118 extends hsh.anzh.jb.AndroidViewGroup {

    public rg_n16118 () {
        rg_n16123 ();
    }

    public rg_n16118 (android.content.Context context, rg_n16117 view, Object objInitData) { super (context, view, objInitData); }
    public rg_n16118 (android.content.Context context, rg_n16117 view) { this (context, view, null); }
    public rg_n16117 GetViewPager () { return (rg_n16117)GetView (); }
    public static rg_n16118 sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new rg_n16117 (context), null);
    }
    public static rg_n16118 sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new rg_n16117 (context), objInitData);
    }
    public static rg_n16118 sNewInstanceAndAttachView (android.content.Context context, rg_n16117 viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static rg_n16118 sNewInstanceAndAttachView (android.content.Context context, rg_n16117 viewAttach, Object objInitData) {
        rg_n16118 objControl = new rg_n16118 (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    private android.support.v4.view.PagerAdapter adapter;
        protected void OnInitView (android.content.Context context, Object objInitData) {
            super.OnInitView (context, objInitData);
            rg_n16123();
        }
    protected java.util.List<hsh.anzh.jb.AndroidView> rg_n16122;

    protected void rg_n16123 () {
        rg_n16122 = new java.util.ArrayList<hsh.anzh.jb.AndroidView> ();
        adapter = new android.support.v4.view.PagerAdapter() {
            @Override public int getCount() { return rg_n16122.size(); }
            @Override public boolean isViewFromObject(View view, Object object) { return view == object; }
            @Override public void destroyItem(android.view.ViewGroup container, int position, Object object) { container.removeView((android.view.View)object); }
            @Override public Object instantiateItem(android.view.ViewGroup container, int position) {
                android.view.View view = rg_n16122.get(position).GetView();
                container.addView(view);
                return view;
                }
            @Override public int getItemPosition(Object object) {
                return POSITION_NONE;
                }
        };
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetViewPager ().setAdapter (adapter);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetViewPager ().setAdapter (adapter);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16136 (final int rg_n16137) {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetViewPager().setCurrentItem(rg_n16137);
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetViewPager().setCurrentItem(rg_n16137);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n16147 (boolean rg_n16148) {
        if(rg_n16148){
            android.support.v4.view.ViewPager.OnPageChangeListener listener = new android.support.v4.view.ViewPager.OnPageChangeListener(){
                @Override public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels){ rg_n16174(position, (double)positionOffset, positionOffsetPixels); }
                @Override public void onPageScrollStateChanged(int state) { rg_n16172(state); }
                @Override public void onPageSelected(int position) { rg_n16178(position); } };
            GetViewPager().addOnPageChangeListener(listener);
        }else{
            GetViewPager().clearOnPageChangeListeners();
        }
    }

    public void rg_n16154 (hsh.anzh.jb.AndroidView rg_n16155) {
        hsh.anzh.jb.rg_n5668.rg_n5672 (rg_n16122, rg_n16155);
        rg_n16171 ();
    }

    public void rg_n16171 () {
        if (hsh.anzh.jb.rg_n2195.sIsUiThread ()) {
            try {
                GetViewPager().getAdapter().notifyDataSetChanged();
            } catch (Exception e) { }
        } else {
            hsh.anzh.jb.rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        GetViewPager().getAdapter().notifyDataSetChanged();
                    } catch (Exception e) { }
                } } );
        }
    }

    public static interface re_n16172 { int dispatch (rg_n16118 objSource, int nTagNumber, int rg_n16173); }
    private re_n16172 rd_n16172;
    private int rd_n16172_tag;
    public void rl_n16118_n16172 (re_n16172 objListener, int nTagNumber) {
        synchronized (this) { rd_n16172 = objListener;  rd_n16172_tag = nTagNumber; }
    }
    public int rg_n16172 (int rg_n16173) {
        re_n16172 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n16172;  nTagNumber = rd_n16172_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n16173) : 0);
    }

    public static interface re_n16174 { int dispatch (rg_n16118 objSource, int nTagNumber, int rg_n16175, double rg_n16176, int rg_n16177); }
    private re_n16174 rd_n16174;
    private int rd_n16174_tag;
    public void rl_n16118_n16174 (re_n16174 objListener, int nTagNumber) {
        synchronized (this) { rd_n16174 = objListener;  rd_n16174_tag = nTagNumber; }
    }
    public int rg_n16174 (int rg_n16175, double rg_n16176, int rg_n16177) {
        re_n16174 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n16174;  nTagNumber = rd_n16174_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n16175, rg_n16176, rg_n16177) : 0);
    }

    public static interface re_n16178 { int dispatch (rg_n16118 objSource, int nTagNumber, int rg_n16179); }
    private re_n16178 rd_n16178;
    private int rd_n16178_tag;
    public void rl_n16118_n16178 (re_n16178 objListener, int nTagNumber) {
        synchronized (this) { rd_n16178 = objListener;  rd_n16178_tag = nTagNumber; }
    }
    public int rg_n16178 (int rg_n16179) {
        re_n16178 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n16178;  nTagNumber = rd_n16178_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n16179) : 0);
    }
}
