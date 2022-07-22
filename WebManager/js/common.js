function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
var t_id = setInterval(animate,20);
var pos=0;
var dir=2;
var len=0;
function animate()
{
    var elem = document.getElementById('progress');
    if(elem != null) {
    if (pos==0) len += dir;
    if (len>32 || pos>79) pos += dir;
    if (pos>79) len -= dir;
    if (pos>79 && len==0) pos=0;
    elem.style.left = pos;
    elem.style.width = len;
    }
}
var flag=false;  
function MyImage(Img){  
var image=new Image();  
image.src=Img.src;  
width=48;//预先设置的所期望的宽的值 
height=48;//预先设置的所期望的高的值 
if(image.width>width||image.height>height){//现有图片只有宽或高超了预设值就进行js控制 
w=image.width/width; 
h=image.height/height; 
if(w>h){//比值比较大==>宽比高大 
//定下宽度为width的宽度 
Img.width=width; 
//以下为计算高度 
Img.height=image.height/w; 

}else{//高比宽大 
//定下宽度为height高度 
Img.height=height; 
//以下为计算高度 
Img.width=image.width/h; 
 } 
} 
}
var flag=false;  
function avatar2(Img){  
var image=new Image();  
image.src=Img.src;  
width=80;//预先设置的所期望的宽的值 
height=80;//预先设置的所期望的高的值 
if(image.width>width||image.height>height){//现有图片只有宽或高超了预设值就进行js控制 
w=image.width/width; 
h=image.height/height; 
if(w>h){//比值比较大==>宽比高大 
//定下宽度为width的宽度 
Img.width=width; 
//以下为计算高度 
Img.height=image.height/w; 

}else{//高比宽大 
//定下宽度为height高度 
Img.height=height; 
//以下为计算高度 
Img.width=image.width/h; 
 } 
} 
}  

function r_loading() {
    this.clearInterval(t_id);
    var targelem = document.getElementById('loader_container');
    targelem.style.display='none';
    targelem.style.visibility='hidden';
}


function GetData()
{
url="xml.asp";

var http = new ActiveXObject("Microsoft.XMLHTTP");
http.open("GET",url,false);
http.send();
var str = http.responseText;
bb.innerHTML=str;
setTimeout("GetData()",1000);
}

function getlrc(x) {

	if (typeof(lrcClass.tim)!=="undefined"){clearInterval(lrcClass.tim)};

	play("正在加载歌词..");

        createXmlHttpRequest();

        var url = "op"+"enl"+"rcx.as"+"p?i"+"d="+x;

        XmlHttp.open("POST", url, true);

        XmlHttp.onreadystatechange = startCallback;

        XmlHttp.send(null);
}
function startCallback() {
        if (XmlHttp.readyState == 4) {
          if (XmlHttp.status == 200||XmlHttp.status == 0) {
            setTimeout('play(XmlHttp.responseText)',1000);
          }
          else {
            setTimeout('play("暂无歌词")',1000);
          }

        }
        
    }