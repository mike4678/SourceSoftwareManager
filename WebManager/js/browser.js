function Init()
{
//查询方式位置校正
	console["\x6c\x6f\x67"]('\x43\x6f\x70\x79\x72\x69\x67\x68\x74 \xa9 \x32\x30\x30\x31\x2d\x32\x30\x32\x32 \x53\x6f\x75\x72\x63\x65\x2e \x41\x6c\x6c \x52\x69\x67\x68\x74\x73 \x52\x65\x73\x65\x72\x76\x65\x64\x2e\n \x57\x65\x62\x73\x69\x74\x65\x3a \x68\x74\x74\x70\x3a\x2f\x2f\x62\x62\x73\x2e\x63\x73\x6f\x75\x72\x63\x65\x2e\x63\x6f\x6d\x2e\x63\x6e');	 //输出版权信息
	if( IEVersion() > 9 ) 
	{
		ScreenWidth(true); //是IE浏览器
	} else { ScreenWidth(false); }
	
}


function ScreenWidth(IE) {
	switch(IE)
	{
		case false:
			if (screen.width >= 1024 & screen.width < 2560)
			{
		      document.getElementById("search_fs").style.padding = "9px";
				console.log('Success！') ;
			}else if (screen.width >= 2560) {
			  document.getElementById("search_fs").style.padding = "8px";
				console.log('Success！') ;
         	}else {
                  alert("获取分辨率失败！");
         	}
			break;
			
		case true:
			if (screen.width >= 1024 & screen.width < 2560)
			{
              document.getElementById("search_fs").style.padding = "9px 9px 8px 0px"; //搜索选项位置定位
			  document.getElementById("submit").style.margin = "-1px 0px 0px -14px";  //搜索按钮定位	
				console.log('Success！') ;
			}else if (screen.width >= 2560) {
              document.getElementById("search_fs").style.padding = "9px 9px 7px 0px";
			  document.getElementById("submit").style.margin = "-1px 0px 0px -14px";
				console.log('Success！') ;
         	}else {
                  alert("获取分辨率失败！");
         	}
			break;
			
		default:
			location.replace("../kernl/error.php?code=195");
			break;
	}	

}


function IEVersion()  
{  
     switch(IEValue())
	 {
		 case '5.0':
			 location.replace("../kernl/error.php?code=195");
			 break;
		
		 case '6.0':
			 location.replace("../kernl/error.php?code=195");
		 	break;	 
			 
		 case '7.0':
			 location.replace("../kernl/error.php?code=195");
		 	break;	
			 
		 case '8.0':
			 location.replace("../kernl/error.php?code=195");
		 	break;				 
			 
		 case '9.0':
			 location.replace("../kernl/error.php?code=195");
			 //return 9;
		 	break;	
			 
		 case '10.0':
			 return 10;
		 	break;		
			 
		 case '11.0':
			 return 11;
		 	break;	
			 
		 default:
			 return -1;
			 break;
			 
	 }

}  


function IEValue()  
{  
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        var s;
        (s = ua.match(/rv:([\d.]+)\) like gecko/)) ? Sys.ie = s[1] :
    	(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
        (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
        (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
        (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
        (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;

        //以下进行测试
        if (Sys.ie) return Sys.ie;
        if (Sys.firefox) console.log('Firefox: ' + Sys.firefox);
        if (Sys.chrome) console.log('Chrome: ' + Sys.chrome);
        if (Sys.opera) console.log('Opera: ' + Sys.opera);
        if (Sys.safari) console.log('Safari: ' + Sys.safari);
}