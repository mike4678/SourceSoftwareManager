
package hsh.Java.jb;

public class rg_n32268 {

    public rg_n32268 ()  { }

    static byte[] byteToArray(java.util.List<Byte> byteList){
        if(byteList != null && byteList.size() > 0){
            byte[] bytes = new byte[byteList.size()];
            for (int i = 0; i < byteList.size(); i++) {
                bytes[i] = byteList.get(i);
            }
            return bytes;
        }else{
            return null;
        }
    }
    static java.util.List<byte[]> byteSplit(byte[] array, byte[] split){
        java.util.List<byte[]> newArray = new java.util.ArrayList<byte[]>();
        java.util.List<Byte> newByte = new java.util.ArrayList<Byte>();
        boolean bol;
        for (int i = 0; i < array.length; i++) {
            bol = false;
            if(i < array.length + 1 - split.length){
                bol = true;
                for (int k = 0; k < split.length; k++) {
                    if(array[i + k] != split[k]){
                        bol = false;
                        break;
                    }
                }
            }
            if(bol){
                if(newByte.size() > 0){
                    newArray.add(byteToArray(newByte));
                }
                newByte = new java.util.ArrayList<Byte>();
                i += split.length - 1;
            }else{
                newByte.add(array[i]);
            }
        }
        if(newByte.size() > 0){
            newArray.add(byteToArray(newByte));
        }
        return newArray;
    }

    public static java.util.List<byte[]> rg_n32269 (byte [] rg_n32270, byte [] rg_n32271) {
        return byteSplit(rg_n32270, rg_n32271);
    }

    public static byte [] rg_n32330 (byte [] rg_n32331, int rg_n32332) {
        byte[] aryResult = new byte [rg_n32332];
        System.arraycopy (rg_n32331, rg_n32331.length - rg_n32332, aryResult, 0, rg_n32332);
        return aryResult;
    }
}
