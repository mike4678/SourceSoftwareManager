
package hsh.anzh.jb;

import android.app.Activity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.*;

public class AndroidView extends hsh.Java.jb.rg_n34310 {

    public AndroidView ()  { }

    public static final int rg_n5525 = -1;
    public static final int rg_n5526 = -2;
    protected static final int rg_n5615 = source.SoftwareManagerAndroid.R.id.rg_n5615;
    private View m_view;
    private rg_n5778 m_animator;
    private View.OnAttachStateChangeListener m_stateChangeListener;
    private android.view.ViewTreeObserver.OnDrawListener m_drawListener;
    private android.view.ViewTreeObserver.OnGlobalLayoutListener m_layoutListener;
    public AndroidView (android.content.Context context, View view, Object objInitData) {
        m_view = view;
        m_view.setTag (rg_n5615, this);
    }
    public AndroidView (android.content.Context context, View view) {
        this (context, view, null);
    }
    public void onInitControlContent (android.content.Context context, Object objInitData) {
        OnInitView (context, objInitData);
        rg_n4112 (context, objInitData);
    }
    public View GetView () { return m_view; }
    public static AndroidView sNewInstance (android.content.Context context) {
        return sNewInstanceAndAttachView (context, new View (context), null);
    }
    public static AndroidView sNewInstance (android.content.Context context, Object objInitData) {
        return sNewInstanceAndAttachView (context, new View (context), objInitData);
    }
    public static AndroidView sNewInstanceAndAttachView (android.content.Context context, View viewAttach) {
        return sNewInstanceAndAttachView (context, viewAttach, null);
    }
    public static AndroidView sNewInstanceAndAttachView (android.content.Context context, View viewAttach, Object objInitData) {
        AndroidView objControl = new AndroidView (context, viewAttach, objInitData);
        objControl.onInitControlContent (context, objInitData);
        return objControl;
    }
    public static AndroidView sSafeGetVolView (View view) {
        if (view != null) {
            Object obj = view.getTag (rg_n5615);
            if (obj != null && obj instanceof AndroidView)
                return (AndroidView)obj;
        }
        return null;
    }
    protected void OnInitView (android.content.Context context, Object objInitData) {
    }

    public static interface re_n5238 { int dispatch (AndroidView objSource, int nTagNumber); }
    private re_n5238 rd_n5238;
    private int rd_n5238_tag;
    public void rl_AndroidView_n5238 (re_n5238 objListener, int nTagNumber) {
        synchronized (this) { rd_n5238 = objListener;  rd_n5238_tag = nTagNumber; }
    }
    public int rg_n5238 () {
        re_n5238 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5238;  nTagNumber = rd_n5238_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n5239 { int dispatch (AndroidView objSource, int nTagNumber); }
    private re_n5239 rd_n5239;
    private int rd_n5239_tag;
    public void rl_AndroidView_n5239 (re_n5239 objListener, int nTagNumber) {
        synchronized (this) { rd_n5239 = objListener;  rd_n5239_tag = nTagNumber; }
    }
    public int rg_n5239 () {
        re_n5239 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5239;  nTagNumber = rd_n5239_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public static interface re_n5242 { int dispatch (AndroidView objSource, int nTagNumber, android.view.MotionEvent rg_n5243); }
    private re_n5242 rd_n5242;
    private int rd_n5242_tag;
    public void rl_AndroidView_n5242 (re_n5242 objListener, int nTagNumber) {
        synchronized (this) { rd_n5242 = objListener;  rd_n5242_tag = nTagNumber; }
    }
    public int rg_n5242 (android.view.MotionEvent rg_n5243) {
        re_n5242 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5242;  nTagNumber = rd_n5242_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber, rg_n5243) : 0);
    }

    public static interface re_n5258 { int dispatch (AndroidView objSource, int nTagNumber); }
    private re_n5258 rd_n5258;
    private int rd_n5258_tag;
    public void rl_AndroidView_n5258 (re_n5258 objListener, int nTagNumber) {
        synchronized (this) { rd_n5258 = objListener;  rd_n5258_tag = nTagNumber; }
    }
    public int rg_n5258 () {
        re_n5258 objDispatcher;  int nTagNumber;
        synchronized (this) { objDispatcher = rd_n5258;  nTagNumber = rd_n5258_tag; }
        return (objDispatcher != null ? objDispatcher.dispatch (this, nTagNumber) : 0);
    }

    public void rg_n5260 (final boolean rg_n5261) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setClickable (rg_n5261);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setClickable (rg_n5261);
                    } catch (Exception e) { }
                } } );
        }
        try {
            if (rg_n5261) {
               m_view.setOnClickListener (new View.OnClickListener () {
                       @Override public void onClick (View v) {
                           rg_n5238 ();
                       } } );
            } else {
                m_view.setOnClickListener (null);
            };
        } catch (Exception e) { }
    }

    public void rg_n5262 (final boolean rg_n5263) {
        try {
            if (rg_n5263) {
               m_view.setOnTouchListener (new View.OnTouchListener () {
                       @Override public boolean onTouch (View v, android.view.MotionEvent event) {
                           return (rg_n5242 (event) != 0);
                       } } );
            } else {
                m_view.setOnTouchListener (null);
            };
        } catch (Exception e) { }
    }

    public void rg_n5265 (final boolean rg_n5266) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setLongClickable (rg_n5266);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setLongClickable (rg_n5266);
                    } catch (Exception e) { }
                } } );
        }
        try {
            if (rg_n5266) {
                m_view.setOnLongClickListener (new View.OnLongClickListener () {
                    @Override public boolean onLongClick (View v) {
                        return (rg_n5239 () != 0);
                    } } );
            } else {
                m_view.setOnLongClickListener (null);
            };
        } catch (Exception e) { }
    }

    public void rg_n5281 (boolean rg_n5282) {
        android.view.ViewTreeObserver observer = m_view.getViewTreeObserver();
        if (!observer.isAlive()) return;
        if (rg_n5282){
            if (m_layoutListener == null){
                m_layoutListener = new android.view.ViewTreeObserver.OnGlobalLayoutListener() {
                    @Override public void onGlobalLayout() { rg_n5258(); }
                };
                observer.addOnGlobalLayoutListener (m_layoutListener);
            }
        }
        else if (m_layoutListener != null) {
            observer.removeOnGlobalLayoutListener (m_layoutListener);
            m_layoutListener = null;
        }
    }

    public void rg_n5287 (final int rg_n5288) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setVisibility (rg_n5288);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setVisibility (rg_n5288);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5378 (final int rg_n5379) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setPadding (rg_n5379, m_view.getPaddingTop (), m_view.getPaddingRight (), m_view.getPaddingBottom ());
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setPadding (rg_n5379, m_view.getPaddingTop (), m_view.getPaddingRight (), m_view.getPaddingBottom ());
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5381 (final int rg_n5382) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setPadding (m_view.getPaddingLeft (), m_view.getPaddingTop (), rg_n5382, m_view.getPaddingBottom ());
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setPadding (m_view.getPaddingLeft (), m_view.getPaddingTop (), rg_n5382, m_view.getPaddingBottom ());
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5396 (final double rg_n5397) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setRotationY ((float)rg_n5397);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setRotationY ((float)rg_n5397);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5423 (int rg_n5424) {
        rg_n5520 (-1, -1, -1, rg_n5424);
    }

    public void rg_n5480 (final int rg_n5481) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setBackgroundResource (rg_n5481);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setBackgroundResource (rg_n5481);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5482 (final int rg_n5483) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setBackgroundColor (rg_n5483);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setBackgroundColor (rg_n5483);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5512 (final int rg_n5513, final int rg_n5514, final int rg_n5515, final int rg_n5516) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                m_view.setPadding (rg_n5513, rg_n5514, rg_n5515, rg_n5516);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        m_view.setPadding (rg_n5513, rg_n5514, rg_n5515, rg_n5516);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5520 (int rg_n5521, int rg_n5522, int rg_n5523, int rg_n5524) {
        ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
        if (pmLayout == null || pmLayout instanceof ViewGroup.MarginLayoutParams == false)
            return;
        ViewGroup.MarginLayoutParams pmMargin = (ViewGroup.MarginLayoutParams)pmLayout;
        final android.graphics.Rect rtNew = new android.graphics.Rect (
                (rg_n5521 == -1 ?  pmMargin.leftMargin : rg_n5521),
                (rg_n5522 == -1 ?  pmMargin.topMargin : rg_n5522),
                (rg_n5523 == -1 ?  pmMargin.rightMargin : rg_n5523),
                (rg_n5524 == -1 ?  pmMargin.bottomMargin : rg_n5524));
        if (rg_n2195.sIsUiThread ()) {
            try {
                ViewGroup.MarginLayoutParams pmNewMargin = (ViewGroup.MarginLayoutParams)m_view.getLayoutParams ();
                pmNewMargin.setMargins (rtNew.left, rtNew.top, rtNew.right, rtNew.bottom);
                m_view.setLayoutParams (pmNewMargin);
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        ViewGroup.MarginLayoutParams pmNewMargin = (ViewGroup.MarginLayoutParams)m_view.getLayoutParams ();
                            pmNewMargin.setMargins (rtNew.left, rtNew.top, rtNew.right, rtNew.bottom);
                            m_view.setLayoutParams (pmNewMargin);
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5527 (final int rg_n5528) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
                if (pmLayout == null)
                    pmLayout = new ViewGroup.LayoutParams (rg_n5528, -2);
                else
                    pmLayout.width = rg_n5528;
                m_view.setLayoutParams (pmLayout);;
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
                            if (pmLayout == null)
                                pmLayout = new ViewGroup.LayoutParams (rg_n5528, -2);
                            else
                                pmLayout.width = rg_n5528;
                            m_view.setLayoutParams (pmLayout);;
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5530 (final int rg_n5531) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
                if (pmLayout == null)
                    pmLayout = new ViewGroup.LayoutParams (-2, rg_n5531);
                else
                    pmLayout.height = rg_n5531;
                m_view.setLayoutParams (pmLayout);;
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
                            if (pmLayout == null)
                                pmLayout = new ViewGroup.LayoutParams (-2, rg_n5531);
                            else
                                pmLayout.height = rg_n5531;
                            m_view.setLayoutParams (pmLayout);;
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5533 (final int rg_n5534, final int rg_n5535) {
        if (rg_n2195.sIsUiThread ()) {
            try {
                ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
                if (pmLayout != null) {
                    pmLayout.width = rg_n5534;
                    pmLayout.height = rg_n5535;
                    m_view.setLayoutParams (pmLayout);
                } else {
                   m_view.setLayoutParams (new ViewGroup.LayoutParams (rg_n5534, rg_n5535));
                };
            } catch (Exception e) { }
        } else {
            rg_n2195.sRunOnUiThread (new Runnable () {
                @Override public void run () {
                    try {
                        ViewGroup.LayoutParams pmLayout = m_view.getLayoutParams ();
                            if (pmLayout != null) {
                                pmLayout.width = rg_n5534;
                                pmLayout.height = rg_n5535;
                                m_view.setLayoutParams (pmLayout);
                            } else {
                               m_view.setLayoutParams (new ViewGroup.LayoutParams (rg_n5534, rg_n5535));
                            };
                    } catch (Exception e) { }
                } } );
        }
    }

    public void rg_n5536 (final int rg_n5537, final int rg_n5538) {
        rg_n5533 ((int)rg_n12424.rg_n12465 (rg_n5537), (int)rg_n12424.rg_n12465 (rg_n5538));
    }

    public void rg_n5539 (int rg_n5540, int rg_n5541, int rg_n5542, int rg_n5543) {
        rg_n5520 ((int)rg_n12424.rg_n12465 (rg_n5540), (int)rg_n12424.rg_n12465 (rg_n5541), (int)rg_n12424.rg_n12465 (rg_n5542), (int)rg_n12424.rg_n12465 (rg_n5543));
    }

    public android.app.Activity rg_n5581 () {
        android.content.Context ct = m_view.getContext ();
        return ((ct != null && ct instanceof android.app.Activity) ? (android.app.Activity)ct : null);
    }

    protected void rg_n4112 (android.content.Context rg_n5616, java.lang.Object rg_n5617) {
    }
}
