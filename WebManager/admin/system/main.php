<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器
?>  
<div class="admin">
	<div class="line-big">
    	<div class="xm3">
        	<div class="panel">
            	<div class="panel-head"><strong>关于我们</strong></div>
				<table class="table">
                    <tr><td width="110" align="right">开发：</td><td>Source</td></tr>
                    <tr><td width="110" align="right">官网：</td><td><a href="http://bbs.csource.com.cn" target="_blank">点击访问</a></td></tr>
                    <tr><td width="110" align="right">技术参考：</td><td>界面：<a href="http://www.pintuer.com/" target="_blank">拼图框架</a><br >探针：<a href="http://www.yahei.net/tz/" target="_blank">雅黑系统探针</a><br >上传：<a href="https://www.helloweba.com/view-blog-189.html" target="_blank">Helloweba</a><td></tr>
                </table>
            </div>
            <br />
        </div>
        <div class="xm9">
            <div class="panel">
           	  <div class="panel-head"><strong>系统参数</strong></div>
              <table class="table">
                	<tr><th colspan="2">服务器信息</th><th colspan="2">系统信息</th></tr>
                    <tr><td width="110" align="right">操作系统：</td><td><?PHP echo PHP_OS ?></td>
                      <td align="right">登录IP：</td>
                      <td><?PHP echo $dou->Get_LocalIP(); ?></td>
                    </tr>
                    <tr><td align="right">Web服务器：</td><td><?PHP echo $_SERVER['SERVER_SOFTWARE'] ?></td>
                      <td align="right">CPU：</td>
                      <td><?php echo  $_SERVER['PROCESSOR_IDENTIFIER'] ?></td>
                    </tr>
                    <tr><td align="right">程序语言：</td><td>PHP(<?PHP echo PHP_VERSION ?>)</td>
                      <td align="right">系统版本:</td>
                      <td><?php echo $dou->Info('version'); ?>&nbsp;&nbsp;( 最新版本：<?php echo $dou->CheckUpdate(); ?> )</a></td>
                    </tr>
                    <tr><td align="right">数据库：</td><td>MySQL</td>
                    <td colspan="2" align="right"><a href='admin.php?/system/info'>More...</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>    
</div>
