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
width=48;//Ԥ�����õ��������Ŀ��ֵ 
height=48;//Ԥ�����õ��������ĸߵ�ֵ 
if(image.width>width||image.height>height){//����ͼƬֻ�п��߳���Ԥ��ֵ�ͽ���js���� 
w=image.width/width; 
h=image.height/height; 
if(w>h){//��ֵ�Ƚϴ�==>��ȸߴ� 
//���¿��Ϊwidth�Ŀ�� 
Img.width=width; 
//����Ϊ����߶� 
Img.height=image.height/w; 

}else{//�߱ȿ�� 
//���¿��Ϊheight�߶� 
Img.height=height; 
//����Ϊ����߶� 
Img.width=image.width/h; 
 } 
} 
}
var flag=false;  
function avatar2(Img){  
var image=new Image();  
image.src=Img.src;  
width=80;//Ԥ�����õ��������Ŀ��ֵ 
height=80;//Ԥ�����õ��������ĸߵ�ֵ 
if(image.width>width||image.height>height){//����ͼƬֻ�п��߳���Ԥ��ֵ�ͽ���js���� 
w=image.width/width; 
h=image.height/height; 
if(w>h){//��ֵ�Ƚϴ�==>��ȸߴ� 
//���¿��Ϊwidth�Ŀ�� 
Img.width=width; 
//����Ϊ����߶� 
Img.height=image.height/w; 

}else{//�߱ȿ�� 
//���¿��Ϊheight�߶� 
Img.height=height; 
//����Ϊ����߶� 
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

	play("���ڼ��ظ��..");

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
            setTimeout('play("���޸��")',1000);
          }

        }
        
    }