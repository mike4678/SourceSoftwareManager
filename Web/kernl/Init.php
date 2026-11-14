<?PHP
/* ---------------------------------------------------- */
/* 程序名称: 系统初始化
/* 程序功能: 载入配置、核心类、会话与错误处理
/* ---------------------------------------------------- */
/* 安全修订说明（2026）：
/*  1. 错误信息统一关闭回显，避免泄露路径/表结构
/*  2. 会话统一在入口处初始化，Cookie 加 HttpOnly / SameSite
/*  3. 修正 $GLOBALS[$_G] 在 $_G 定义之前访问的顺序错误
/*  4. 表结构校验改为轻量检查，避免全表扫描
/* ---------------------------------------------------- */

// ---------- 错误处理（必须在任何业务代码之前） ----------
@ini_set('display_errors', 'Off');
@ini_set('display_startup_errors', 'Off');
@ini_set('log_errors', 'On');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING & ~E_STRICT);

// 调整时区
if (PHP_VERSION >= '5.1') {
    date_default_timezone_set('PRC');
}

// ---------- 全局通用数组（必须先定义再使用） ----------
$_G = array();

// 框架运行的目录路径（项目根目录，保持原大小写，避免 Linux 下路径失效）
$_G['SYSTEM']['PATH'] = str_replace('\\', '/', dirname(dirname(__FILE__))) . '/';
define('ROOT_PATH', $_G['SYSTEM']['PATH']);

// 取得当前站点所在的根目录
$root_url = strtolower(dirname(HttpsCheck() . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])) . '/';

// 检测是否为 https 模式
function HttpsCheck()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return 'https://';
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return 'https://';
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return 'https://';
    }
    return 'http://';
}

// ---------- 会话初始化（统一入口，避免各页面 session_start 顺序错乱） ----------
function SmSessionStart()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = (HttpsCheck() === 'https://');
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params(array(
            'lifetime' => 0,
            'path'     => '/',
            'httponly' => true,
            'secure'   => $secure,
            'samesite' => 'Lax',
        ));
    } else {
        session_set_cookie_params(0, '/', '', $secure, true);
    }
    @session_name('SMSESSID');
    @session_start();
}
SmSessionStart();

// ---------- CSRF 令牌（会话级，配合后台表单使用） ----------
if (empty($_SESSION['sm_csrf'])) {
    $_SESSION['sm_csrf'] = bin2hex(random_bytes(16));
}
define('SM_CSRF', $_SESSION['sm_csrf']);

/** 输出隐藏的 CSRF 字段 */
function sm_csrf_field()
{
    return '<input type="hidden" name="csrf" value="' . h(SM_CSRF) . '">';
}

// ---------- 同源校验：拦截跨站发起的 POST（CSRF）
// 说明：受后台“安全防御 → CSRF 防护”开关控制（defense_csrf），
// 由于需要读取设置表，实际执行放在实例化 $dou 之后（见下方）。

// ---------- 配置文件检查 ----------$confFile = ROOT_PATH . 'kernl/Conf.php';
if (!file_exists($confFile)) {
    // 兼容小写文件名
    $confFile = ROOT_PATH . 'kernl/conf.php';
}

if (!file_exists($confFile)) {
    // 如果不存在则跳转到安装界面
    $jump = HttpsCheck() . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/install/index.php';
    header('Location: ' . $jump);
    exit;
} else {
    require_once $confFile;
}

// ---------- 初始化核心模块 ----------
$arr = array('Connect', 'FileUtil', 'System', 'Account', 'Mobile', 'ip');
foreach ($arr as $module) {
    $file = ROOT_PATH . 'kernl/' . $module . '.Class.php';
    if (!file_exists($file)) {
        $file = ROOT_PATH . 'kernl/' . $module . '.class.php';
    }
    if (file_exists($file)) {
        require_once $file;
    }
}

// 兼容个别大小写不一致的文件名
if (!class_exists('Utils_Caption') && file_exists(ROOT_PATH . 'kernl/Caption.Class.php')) {
    require_once ROOT_PATH . 'kernl/Caption.Class.php';
}

// ---------- 实例化类 ----------
$dou        = new System(DBSERVER, USER, PASSWORD, DB, 'utf8mb4');
$FileControl = new FileUtil();

// ---------- 同源校验（可后台开关：安全防御 → CSRF 防护） ----------
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && $dou->Defense('csrf')) {
    $selfHost = isset($_SERVER['HTTP_HOST']) ? strtolower((string)$_SERVER['HTTP_HOST']) : '';
    $origin   = isset($_SERVER['HTTP_ORIGIN']) ? (string)$_SERVER['HTTP_ORIGIN'] : '';
    $referer  = isset($_SERVER['HTTP_REFERER']) ? (string)$_SERVER['HTTP_REFERER'] : '';
    $bad      = false;
    if ($origin !== '') {
        $h = parse_url($origin, PHP_URL_HOST);
        $p = parse_url($origin, PHP_URL_PORT);
        $src = $h ? strtolower($h) . ($p ? ':' . $p : '') : '';
        $bad = ($src !== '' && $src !== $selfHost);
    } elseif ($referer !== '' && $selfHost !== '') {
        $h = parse_url($referer, PHP_URL_HOST);
        $p = parse_url($referer, PHP_URL_PORT);
        $src = $h ? strtolower($h) . ($p ? ':' . $p : '') : '';
        $bad = ($src !== '' && $src !== $selfHost);
    }
    if ($bad) {
        $dou->WriteLog('POST', '【安全】跨站 POST 请求被同源校验拦截', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '-');
        http_response_code(403);
        echo '非法来源的请求已被拦截';
        exit;
    }
}

// ---------- 校验基础表是否存在（轻量检查，不做全表遍历） ----------
$requiredTables = array('zd_admin_user', 'zd_adminlist', 'zd_content_data', 'zd_system_log', 'zd_system_setting');
$missing        = array();
foreach ($requiredTables as $t) {
    if (!$dou->table_exist($t)) {
        $missing[] = $t;
    }
}
if (!empty($missing)) {
    // 只在调试模式下提示具体缺失表，避免泄露表结构
    if (defined('Debug') && Debug === 'on') {
        die('数据表缺失：' . implode(', ', $missing));
    }
    die('系统初始化出现异常错误，请与管理员联系！');
}

define('source', 'service.csource.com.cn');

// 初始化加密 key（做空值兜底，避免全站因空 key 崩溃）
$smKey = $dou->Info('encrypted');
define('key', $smKey === null || $smKey === '' ? 'softmanager' : $smKey);

// ---------- 输出安全响应头 ----------
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Cache-Control:no-cache,must-revalidate');
    header('Pragma:no-cache');
}

// ---------- 登录框架参数 ----------
$_G['Login']['MaxNumber'] = (int)$dou->Info('MaxCount');
if ($_G['Login']['MaxNumber'] < 1) {
    $_G['Login']['MaxNumber'] = 4;
}
$_G['IPS']['ClientIP'] = $dou->Get_LocalIP();

