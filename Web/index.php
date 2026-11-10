<?php
/* ---------------------------------------------------- */
/* 程序名称: 首页入口
/* 安全修订说明（2026）：
/*  1. 删除 print_r($_GET['type']) 调试输出（会破坏页面结构）
/*  2. 模板改为从本地文件读取，不再用 HTTP 自请求
/*     （原写法受 Host 头控制，可被用于 SSRF / 请求伪造）
/*  3. 模板变量只允许白名单，且统一做 HTML 转义
/*  4. Cookie 不再写入不可控的 domain，去掉 .SERVER_NAME 反射
/* ---------------------------------------------------- */
require("kernl/Init.php");

$dou->WSCS_Check();               // 安全检查，防护系统
$addr = $dou->AddrConvery($_GET); // 初始化参数

// ---------- 客户端类型切换 ----------
$client = 'pc';
switch (isset($_GET['type']) ? $_GET['type'] : '') {
    case 'android':
        $client = 'android';
        break;
    case 'pc':
        $client = 'pc';
        break;
    default:
        $client = isset($_COOKIE['setclient']) && $_COOKIE['setclient'] === 'android' ? 'android' : 'pc';
        break;
}
if (isset($_GET['type']) && in_array($_GET['type'], array('android', 'pc'), true)) {
    $_COOKIE['setclient'] = $client;
    $dou->cookie('setclient', $client === 'android' ? 'android' : '', time() + 3600, '/');
}
// 隐藏字段用于前端选择客户端下载包，注入到 <body> 内，避免出现在 DOCTYPE 之前
$clientInput = '<input type="text" hidden id="setclient" value="' . h($client) . '">';

// ---------- 读取首页模板（本地读取，避免自请求与 SSRF） ----------
$templateFile = ROOT_PATH . 'template/index.html';
if (!is_file($templateFile)) {
    // 兼容 conf 中配置的模板路径
    if (defined('Templater')) {
        $t = str_replace('\\', '/', (string)Templater);
        $t = preg_replace('#^' . preg_quote(parse_url((string)HttpsCheck() . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_PATH), '#') . '#', '', $t);
        $t = preg_replace('#^/[^/]+/#', '/', $t);
        $templateFile = ROOT_PATH . ltrim($t, '/');
    }
}
if (!is_file($templateFile)) {
    echo $dou->Index_ErrorPage(301);
    exit;
}
$value = @file_get_contents($templateFile);
if ($value === false) {
    echo $dou->Index_ErrorPage(307);
    exit;
}

// ---------- 模板变量替换（白名单 + 转义） ----------
preg_match_all('/{([A-Za-z0-9_]+)}/', $value, $out, PREG_PATTERN_ORDER);
if (!empty($out[1])) {
    foreach (array_unique($out[1]) as $tag) {
        switch ($tag) {
            case 'table_list':
                $HeadData = $dou->front_table_list();
                break;
            case 'table_name':
                $HeadData = '';
                break;
            case 'bottom':
            case 'corp':
            case 'name':
            case 'version':
            case 'logo':
                $HeadData = h((string)$dou->Info($tag));
                break;
            default:
                $HeadData = '';
                break;
        }
        $value = str_replace('{' . $tag . '}', $HeadData, $value);
    }
}

// 注入隐藏字段（放在 body 起始处，保证文档结构合法）
$value = preg_replace('/<body([^>]*)>/i', '<body$1>' . $clientInput, $value, 1);

// 顶部 <title> 里的 {corp} 已替换；不再输出调试内容
echo $value;

// ---------- 首页数据（列表 / 详情） ----------
$file = dirname(__FILE__) . '/content.php';
if (!file_exists($file)) {
    echo $dou->Admin_ErrorPage(isset($addr[1]) ? $addr[1] : '', isset($addr[2]) ? $addr[2] : '', 'content.php');
} else {
    include $file;
}
?>

		<footer class="footer">
			<ul class="list-inline" style="text-align:center">
				<li><?php echo h((string)$dou->Info('bottom')); ?></li>
			</ul>
		</footer>
	</div>
</div>
	<script src="js/jquery.min1.js"></script>
	<script src="js/modernizr.min.js"></script>
	<script src="plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="plugin/nprogress/nprogress.js"></script>
	<script src="plugin/sweet-alert/sweetalert.min.js"></script>
	<script src="plugin/waves/waves.min.js"></script>
	<script src="plugin/moment/moment.js"></script>
	<script src="js/main.min.js"></script>
	<script>
	function GetClient()
	{
		var el = document.getElementById("setclient");
		var cid = document.getElementById("clientid");
		if (!el || !cid) { return; }
		if (el.value == 'android') {
			cid.href = 'Client/Client.apk';
		} else {
			cid.href = 'Client/Client.zip';
		}
	};

	function ShowAll(n)
	{
		switch (n)
		{
			case 'pc':
				document.cookie = "setclient=pc;path=/";
				window.location.href = "index.php?type=pc";
				break;
			case 'android':
				document.cookie = "setclient=android;path=/";
				window.location.href = "index.php?type=android";
				break;
			default:
				document.cookie = "setclient=;path=/";
				window.location.href = "index.php?";
				break;
		}
	};

	GetClient();
	</script>
</body>
</html>
