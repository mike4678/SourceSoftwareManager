<?php
/* ---------------------------------------------------- */
/* 程序名称: 后台入口
/* 安全修订说明（2026）：
/*  1. 删除 ?/phpinfo 与 ?/Function 两个调试后门（未授权即可枚举环境与函数）
/*  2. 登录态改由会话 + HMAC 令牌判定，Cookie 不再存放可逆密码
/*  3. 备份下载的文件名做白名单校验并限制在备份目录内
/*  4. 模块文件包含增加路径白名单与 realpath 校验，杜绝任意文件包含
/*  5. 模板变量统一转义
/* ---------------------------------------------------- */
require("../kernl/Init.php");

$dou->WSCS_Check();                    // 安全检查，防护系统
$state = $dou->AccountState();
$addr  = $dou->AddrConvery($_GET);     // 初始化参数

// ---------- 登录状态 ----------
if ($state === 'Access denied') {
    $ref = '';
    if (isset($addr[1]) && $addr[1] !== '' && $addr[1] !== 'exit') {
        $ref = '/' . rawurlencode($addr[1]) . '/' . rawurlencode(isset($addr[2]) ? $addr[2] : '');
    }
    header("Location: login.php" . ($ref === '' ? '' : '?ref=' . urlencode($ref)));
    exit;
}

// ---------- 特殊请求 ----------
switch (isset($addr[1]) ? $addr[1] : '') {
    case 'exit':
        $dou->LoginAudit('退出登录', $dou->CurrentUser(), '成功');
        $dou->Logout();
        echo '<script language="JavaScript">SystemBox(3,"您已成功退出系统！");</script>';
        echo '<script language="JavaScript">location.replace("login.php");</script>';
        exit;

    case 'downbackup':
        $file = isset($_SESSION['sm_backup_filename']) ? (string)$_SESSION['sm_backup_filename'] : '';
        unset($_SESSION['sm_backup_filename']);
        if ($file === '' || !preg_match('/^[A-Za-z0-9_\-\.]{1,80}$/', $file)) {
            header('HTTP/1.1 400 Bad Request');
            exit('非法请求');
        }
        $dir  = 'backup';
        $path = ROOT_PATH . 'admin/' . $dir . '/' . $file;
        $real = realpath($path);
        $root = realpath(ROOT_PATH . 'admin/' . $dir);
        if ($real === false || $root === false || strpos($real, $root . DIRECTORY_SEPARATOR) !== 0) {
            header('HTTP/1.1 404 Not Found');
            exit('文件不存在');
        }
        $size = filesize($real);
        $name = str_replace(array("\r", "\n", '"', "'"), '', $file);
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . $size);
        header("Content-Disposition: attachment; filename=\"" . $name . "\"");
        header("X-Content-Type-Options: nosniff");
        $fp = fopen($real, 'rb');
        if ($fp) {
            fpassthru($fp);
            fclose($fp);
        }
        exit;

    default:
        // ---------- 生成顶部导航与左侧导航参数 ----------
        if (($addr[1] ?? '') !== '' && ($addr[2] ?? '') !== '') {
            $data = $dou->convert($addr[1], $addr[2]);
            if (empty($data['table']) || empty($data['menu'])) {
                $data = $dou->convert('start', 'index');
            }
        } else {
            $data = $dou->convert('start', 'index');
        }
        $tab  = isset($data['table']) ? $data['table'] : '';
        $list = isset($data['menu']) ? $data['menu'] : '';

        if ($tab === '' || $list === '') {
            header('HTTP/1.1 404 Not Found');
            echo $dou->Admin_ErrorPage($addr[1] ?? '', $addr[2] ?? '', 'zd_adminlist');
            exit;
        }
}

// ---------- 生成后台 Head 部分 ----------
$value = (string)$dou->Info('Index_head_New');
preg_match_all('/{([A-Za-z0-9_]+)}/', $value, $out, PREG_PATTERN_ORDER);
if (!empty($out[1])) {
    foreach (array_unique($out[1]) as $tag) {
        switch ($tag) {
            case 'table_list':
                $HeadData = $dou->table_list_new($tab, $list);
                break;
            case 'table_name':
                $HeadData = h($list);
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
echo $value;

// ---------- 生成后台页面主体 ----------
$bottom = $dou->PageLoading($tab, $list);
$adminRoot = realpath(dirname(__FILE__));
$isSafe = $bottom !== ''
    && preg_match('#^[A-Za-z0-9_\-/.]+\.php$#', $bottom)
    && strpos($bottom, '..') === false;

$realFile = $isSafe ? realpath(dirname(__FILE__) . '/' . $bottom) : false;

if ($realFile === false || $adminRoot === false || strpos($realFile, $adminRoot) !== 0 || !is_file($realFile)) {
    echo $dou->Admin_ErrorPage(isset($addr[1]) ? $addr[1] : '', isset($addr[2]) ? $addr[2] : '', $bottom);
} else {
    // 让被包含页面可以读取 $addr/$tab/$list
    include $realFile;
}
?>

		<footer class="footer">
			<ul class="list-inline" style="text-align:center">
				<li><?php echo h((string)$dou->Info('bottom')); ?></li>
			</ul>
		</footer>
	</div>
</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/modernizr.min.js"></script>
	<script src="../plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="../plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="../plugin/nprogress/nprogress.js"></script>
	<script src="../plugin/sweet-alert/sweetalert.min.js"></script>
	<script src="../plugin/waves/waves.min.js"></script>
	<script src="../plugin/moment/moment.js"></script>
	<script src="../js/main.min.js"></script>
</body>
</html>
