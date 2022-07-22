$(function(){
	//获取导航距离页面顶部的距离
	var toTopHeight = $("#nav").offset().top;
	
	//监听页面滚动
	$(window).scroll(function() {
		//判断页面滚动超过导航时执行的代码
		if( $(document).scrollTop() > toTopHeight ){
			//检测是否为IE6。jQuery1.9中去掉了msie的方法，所以只好这样写
			if ('undefined' == typeof(document.body.style.maxHeight)) {
				//页面滚动的距离
				var scrollTop = $(document).scrollTop();
				//IE6下，用absolute定位，并设置Top值为距离页面顶部的距离
				$("#nav").css({'position':'absolute','top':scrollTop+'px'});
			}else{
				//IE6以上浏览器采用fixed定位
				$("#nav").addClass("nav_fixed");
			}
		}else{//判断页面滚动没有超过导航时执行的代码
			if ('undefined' == typeof(document.body.style.maxHeight)) {
				//设置Top值为导航距页面顶部的初始值。（IE6为了防止浏览器一下滚动过多，所以不能采用直接去掉定位的方法）
				$("#nav").css({'position':'absolute','top':toTopHeight+'px'});
			}else{
				//IE6以上浏览器移除fixed定位，采用默认流布局
				$("#nav").removeClass("nav_fixed");
			}
		}
	});
});
