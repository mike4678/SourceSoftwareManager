
package hsh.anzh.zj.gjlbk;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.animation.ObjectAnimator;
import android.animation.ValueAnimator;
import android.content.res.Resources;
import android.graphics.Canvas;
import android.graphics.Rect;
import android.os.Build;
import android.support.v4.view.ViewCompat;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.helper.*;
import android.util.Log;
import android.view.GestureDetector;
import android.view.HapticFeedbackConstants;
import android.view.MotionEvent;
import android.view.VelocityTracker;
import android.view.View;
import android.view.ViewConfiguration;
import android.view.ViewGroup;
import android.view.ViewParent;
import android.view.animation.Interpolator;
import android.voldp.support.recyclerview.RecyclerAdapter;
import java.util.ArrayList;
import java.util.List;

public class rg_n19514 extends android.voldp.support.recyclerview.RecyclerAdapter {

    public rg_n19032 rg_n19515;
    public java.util.ArrayList<java.lang.Object> rg_n19516 = new java.util.ArrayList<java.lang.Object> ();
        private Object mResult = null;
        public class SWRecyclerViewViewHolder extends RecyclerAdapter.RecyclerViewViewHolder implements rg_n19577.SwipeLayoutTypeCallBack {
            private android.content.Context context;
            private android.view.View mItemView;
            public SWRecyclerViewViewHolder (android.view.View itemView) {
                super (itemView);
                mItemView = itemView;
            }
            @Override
            public float getSwipeWidth() {
                return (float) rg_n19539 ();
            }
            @Override
            public View needSwipeLayout () {
                return mItemView.findViewById (rg_n19537 ());
            }
            @Override
            public View onScreenView () {
                return mItemView.findViewById (rg_n19538 ());
            }
            public int dip2px(android.content.Context context, float dpValue) {
                float scale = context.getResources().getDisplayMetrics().density;
                return (int) (dpValue * scale + 0.5f);
            }
        }
        public rg_n19514 () {
            rg_n19520 ();
        }
        @Override
        public Object ViewHolderBackCall (android.view.View itemView) {
            return mResult;
        }
        @Override
        public RecyclerAdapter.RecyclerViewViewHolder onCreateViewHolder(android.view.ViewGroup parent, int viewType) {
            rg_n19163 result = new rg_n19163 ();
            hsh.anzh.jb.AndroidView mView = rg_n19521 ((hsh.anzh.jb.AndroidViewGroup) hsh.anzh.jb.AndroidView.sSafeGetVolView (parent), viewType, result);
            if (mView == null || mView.GetView () == null){
                hsh.anzh.jb.rg_n6158 linearLayout = hsh.anzh.jb.rg_n6158.sNewInstance (parent.getContext(), null);
                linearLayout.GetView ().setId (1);
                return new SWRecyclerViewViewHolder(linearLayout.GetView());
            }
            mResult = result.rg_n19164;
            return new SWRecyclerViewViewHolder (mView.GetView ());
        }
        @Override
        public void onBindViewHolder(RecyclerAdapter.RecyclerViewViewHolder holder, int position) {
            if (holder == null || holder.mViewClass == null)
                return;
            rg_n19525 (holder, position);
        }
        @Override
        public void onViewRecycled (RecyclerAdapter.RecyclerViewViewHolder holder) {
            rg_n19532 (holder);
        }
        @Override
        public void onViewAttachedToWindow(RecyclerAdapter.RecyclerViewViewHolder holder) {
            rg_n19534 (holder);
        }
        @Override
        public long getItemId (int position) {
            long result = rg_n19530 (position);
            return result == 0 ? position + 1 : result;
        }
        @Override
        public int getItemCount() {
            return rg_n19536 ();
        }
        @Override
        public int getItemViewType(int position) {
            return rg_n19528 (position);
        }

    public void rg_n19520 () {
    }

    public hsh.anzh.jb.AndroidView rg_n19521 (hsh.anzh.jb.AndroidViewGroup rg_n19522, int rg_n19523, rg_n19163 rg_n19524) {
        return (null);
    }

    public void rg_n19525 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19526, int rg_n19527) {
    }

    public int rg_n19528 (int rg_n19529) {
        return (0);
    }

    public long rg_n19530 (int rg_n19531) {
        return (0);
    }

    public void rg_n19532 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19533) {
    }

    public void rg_n19534 (android.voldp.support.recyclerview.RecyclerAdapter.RecyclerViewViewHolder rg_n19535) {
    }

    public int rg_n19536 () {
        return (rg_n19516.size ());
    }

    public int rg_n19537 () {
        return (-1);
    }

    public int rg_n19538 () {
        return (-1);
    }

    public double rg_n19539 () {
        return (0.0);
    }

    public void rg_n19552 (java.lang.Object rg_n19553, int rg_n19554, boolean rg_n19555) {
        if (rg_n19554 > -1 && rg_n19554 < rg_n19536 ())
        {
            hsh.Java.jb.rg_n37496.rg_n37497 (rg_n19516, rg_n19554, rg_n19553);
            if (rg_n19555)
            {
                rg_n19561 (rg_n19554);
            }
        }
        else
        {
            hsh.Java.jb.rg_n37113.rg_n37117 (rg_n19516, rg_n19553);
            if (rg_n19555)
            {
                rg_n19561 (rg_n19516.size ());
            }
        }
    }

    public java.lang.Object rg_n19556 (int rg_n19557) {
        if (rg_n19557 > rg_n19536 () || rg_n19557 < 0)
        {
            return (null);
        }
        return (rg_n19516.get (rg_n19557));
    }

    public void rg_n19558 () {
        try {
            notifyDataSetChanged();
        } catch (Exception e) { }
    }

    public void rg_n19561 (int rg_n19562) {
        try {
            notifyItemInserted(rg_n19562);
        } catch (Exception e) { }
    }
}
