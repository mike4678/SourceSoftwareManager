
package hsh.anzh.hcwjgjl;

class rg_n14801 {

    public rg_n14801 ()  { }

    protected java.io.File rg_n14802;
    protected long rg_n14803;
    protected int rg_n14804;
    protected java.util.concurrent.atomic.AtomicLong rg_n14805 = new java.util.concurrent.atomic.AtomicLong ();
    protected java.util.concurrent.atomic.AtomicInteger rg_n14806 = new java.util.concurrent.atomic.AtomicInteger ();
    protected java.util.Map<java.io.File, java.lang.Long> rg_n14807;
    public rg_n14801(java.io.File cacheDir,long sizeLimit,int countLimit)
    {
        rg_n14807 = java.util.Collections.synchronizedMap(new java.util.HashMap<java.io.File, Long>());
        rg_n14802 = cacheDir;
        rg_n14803 = sizeLimit;
        rg_n14804 = countLimit;
        rg_n14812();
    }

    protected void rg_n14812 () {
        hsh.Java.jb.rg_n36080 rg_n14813 = new hsh.Java.jb.rg_n36080 ();
        rg_n14813.rl_n36080_n36084 (new hsh.Java.jb.rg_n36080.re_n36084 () {
            public int dispatch (hsh.Java.jb.rg_n36080 objSource, int nTagNumber, java.lang.Object rg_n36085, java.lang.Object rg_n36086) {
                return rg_n14814 (objSource, nTagNumber, rg_n36085, rg_n36086);
            }
        }, 666);
        rg_n14813.rg_n36081 (null, null);
    }

    protected int rg_n14814 (hsh.Java.jb.rg_n36080 rg_n14815, int rg_n14816, java.lang.Object rg_n14817, java.lang.Object rg_n14818) {
        if (rg_n14816 == 666)
        {
            int rg_n14819 = 0;
            int rg_n14820 = 0;
            java.io.File [] rg_n14821;
            rg_n14821 = rg_n14802.listFiles ();
            if (rg_n14821 != null)
            {
                int rg_n14822 = 0;
                for (rg_n14822 = 0; rg_n14822 < rg_n14821.length; rg_n14822++)
                {
                    rg_n14819 = (int)(rg_n14819 + (rg_n14821 [rg_n14822].length ()));
                    rg_n14820 = rg_n14820 + 1;
                    rg_n14595.rg_n14615 (rg_n14807, rg_n14821 [rg_n14822], new java.lang.Long (rg_n14821 [rg_n14822].length ()));
                }
                hsh.Java.jb.rg_n36375.rg_n36384 (rg_n14805, rg_n14819);
                hsh.Java.jb.rg_n36274.rg_n36283 (rg_n14806, rg_n14820);
            }
        }
        return (0);
    }

    public long rg_n14839 () {
        if (rg_n14807.isEmpty())
        {
            return (0);
        }
        java.lang.Long rg_n14840;
        java.io.File rg_n14841 = null;
        java.util.Set<java.util.Map.Entry<java.io.File, java.lang.Long>> rg_n14842;
        rg_n14840 = new java.lang.Long (0);
        rg_n14842 = rg_n14807.entrySet();
        synchronized(rg_n14807)
        {
            for(java.util.Map.Entry<java.io.File,Long> entry : rg_n14842)
            {
                if (rg_n14841 == null)
                {
                    rg_n14841 = entry.getKey();
                    rg_n14840 = entry.getValue();
                }
                else
                {
                    java.lang.Long rg_n14843 = null;
                    rg_n14843 = entry.getValue();
                    if (rg_n14843.longValue () < rg_n14840.longValue ())
                    {
                        rg_n14840 = rg_n14843;
                        rg_n14841 = entry.getKey();
                    }
                }
            }
        }
        long rg_n14844;
        rg_n14844 = rg_n14841.length ();
        if (rg_n14841.exists ())
        {
            rg_n14595.rg_n14619 (rg_n14807, rg_n14841);
        }
        return (rg_n14844);
    }
}
