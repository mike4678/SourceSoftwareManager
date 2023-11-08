
package hsh.anzh.jb;

public class rg_n6030 extends android.widget.LinearLayout {

    private rg_n6158 m_layouter;
    public rg_n6030 (android.content.Context context) {
        this (context, null, 0);
    }
    public rg_n6030 (android.content.Context context, android.util.AttributeSet attrs) {
        this (context, attrs, 0);
    }
    public rg_n6030 (android.content.Context context, android.util.AttributeSet attrs, int defStyle) {
        super (context, attrs, defStyle);
        setOrientation (android.widget.LinearLayout.VERTICAL);
        m_layouter = new rg_n6158 (context, this);
    }
    public rg_n6158 GetLayouter () {
        return m_layouter;
    }
}
