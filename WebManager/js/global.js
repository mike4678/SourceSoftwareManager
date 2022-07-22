/*!
 * Source Global Function
 * Date: 2019-01-01
 * 
 * (c) 2009-2029 Source, http://bbs.csource.com.cn
 *
 */
var script=document.createElement("script"); 
	script.type="text/javascript"; 
	script.src="../js/jquery-1.9.1.js"; 
	document.getElementsByTagName('head')[0].appendChild(script); 

//var arr = Array('iframeTools.js','artDialog.js?skin=default');
//for (i = 0 ; i < arr.length; i++)
//{
	///var script=document.createElement("script"); 
	//script.type="text/javascript"; 
	//script.src="../js/" + arr[i]; 
	//document.getElementsByTagName('head')[0].appendChild(script); 
//}

// 后台登陆界面核心处理函数
function LoginStatus(value)
{
	if(value == 1) //Normal
	{
		document.getElementById("code").style='display:none;';
		document.getElementById("login_boder").style.backgroundImage="url(../images/login_m_bg.png)";
		document.getElementById("login_boder").style.height='302px';
		document.getElementById("rem_sub").style='margin-top: 0px;';
		document.getElementById("corp").style='margin-top: 0px;';
		
	} else if(value == 2) {
		
		document.getElementById("code").style='';
		document.getElementById("login_boder").style.backgroundImage="url(../images/logincode_m_bg.png)";
		document.getElementById("login_boder").style.height='350px';
		document.getElementById("rem_sub").style='margin-top: -10px;';
		document.getElementById("corp").style='margin-top: 60px;';
	}
	
}

function XZSelect() 
{
    if (document.getElementById('Select').options[2].selected == true) 
	{
		document.getElementById('w').style.display = '';
			
    } else if (document.getElementById('Select').options[2].selected == false) 
	
	{
       document.getElementById('w').style.display = 'none';
		
    } 
}

function GetCode() 
{
	var obj = document.getElementById("showcode");
	obj.src = "../admin/code.php?"+ Math.random();
}	

//后台消息框函数
//type 类型 : 1.信息框 2.网页框  3.弹窗
//data 内容 : 信息框对应弹出内容，网页框则为网址
//icon 图标，type为1生效
//title 标题
//height 高度
//weight 宽度

function SystemBox(type,data,icon,title,height,width) 
{
	switch(type)
	{
		case 1:
			var dialog = art.dialog({
									title: title,
    								content: data,
									icon: icon,
									});
			break;
			
		case 2:
			art.dialog.open( data, {
									title: title, 
									width: width, 
									height: height
							});
			break;
		
		case 3:
			art.dialog.tips(data);
			break;
			
	}
}

function StatusEdit(value,fvalue,svalue)
{
	//value 返回值
	//fvalue 为0执行
	//svalue 为1执行
	if(value == 0)
	{
		document.getElementById(fvalue).className = "button active";
		
	} else {
		
		document.getElementById(svalue).className = "button active";
		
	}
	
}

function Tips(data) //名单提示信息
{
	if(data == 1)
	{
		document.getElementsByName("info")[0].innerHTML='&nbsp;&nbsp;&nbsp;白名单：仅允许特定IP访问&nbsp;';
		
	} else { 
		
		document.getElementsByName("info")[0].innerHTML='&nbsp;&nbsp;&nbsp;黑名单：不允许特定IP访问&nbsp;';
	}
}
