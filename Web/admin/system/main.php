<?php
/* ---------------------------------------------------- */
/* 后台首页（系统参数概览）
/* 安全修订说明（2026）：未登录直接中断；所有服务器变量输出前先判断存在性并转义
/* ---------------------------------------------------- */
if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}
?>
<div class="row">
	<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="box-content">
            	<div class="box-title"><strong>关于我们</strong></div>
				<table class="table">
                    <tr><td width="110" align="right">开发：</td><td>Source</td></tr>
                    <tr><td width="110" align="right">官网：</td><td><a href="http://bbs.csource.com.cn" target="_blank">点击访问</a></td></tr>
                    <tr><td width="110" align="right">技术参考：</td><td>界面：NinjaAdmin<br />探针：<a href="http://www.yahei.net/tz/" target="_blank">雅黑系统探针</a><br />上传：<a href="https://www.helloweba.com/view-blog-189.html" target="_blank">Helloweba</a></td></tr>
                </table>
            <br />
        </div>
	</div>
        <div class="col-lg-8 col-md-6 col-xs-12">
            <div class="box-content">
           	  <div class="box-title"><strong>系统参数</strong></div>
              <table class="table">
                	<tr><th colspan="2">服务器信息</th><th colspan="2">系统信息</th></tr>
                    <tr><td width="110" align="right">操作系统：</td><td><?php echo h(PHP_OS); ?></td>
                      <td align="right">登录IP：</td>
                      <td><?php echo h((string)$dou->Get_LocalIP()); ?></td>
                    </tr>
                    <tr><td align="right">Web服务器：</td><td><?php echo h(isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '未知'); ?></td>
                      <td align="right">CPU：</td>
                      <td><?php echo h(isset($_SERVER['PROCESSOR_IDENTIFIER']) ? $_SERVER['PROCESSOR_IDENTIFIER'] : '未知'); ?></td>
                    </tr>
                    <tr><td align="right">程序语言：</td><td>PHP(<?php echo h(PHP_VERSION); ?>)</td>
                      <td align="right">系统版本:</td>
                      <td><?php echo h((string)$dou->Info('version')); ?>&nbsp;&nbsp;( 最新版本：<?php echo h((string)$dou->CheckUpdate()); ?> )</td>
                    </tr>
                    <tr><td align="right">数据库：</td><td>MySQL</td>
                    <td colspan="2" align="right"><a href='index.php?/system/info'>More...</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
