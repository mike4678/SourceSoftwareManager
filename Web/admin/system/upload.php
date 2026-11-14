<?php
//*******************************
// Upload 上传模块
// 回传参数
// 旧版 frame=module
// 新版 act=del|add&ifr=xxx(对应数据库)
//*******************************
/* 安全修订说明（2026）：
/*  1. 原代码未加载 Init.php，且用 $state == '1' 判断登录（永远不成立）
/*     导致上传接口完全未授权；现改为统一登录校验，未登录直接 401
/*  2. 上传目录沿用后台配置，但文件名改为随机生成，杜绝用文件名穿越目录
/*  3. 删除文件只允许删除该框架目录下的文件，且文件名必须为白名单字符
/*  4. 模块解压增加目录名校验与路径越界检查
/*  5. 图片 BLOB 不再先 addslashes 再入库（原写法会二次转义破坏数据）
/* ---------------------------------------------------- */
require_once '../../kernl/Init.php';

$dou = $dou ?? null; // 由 Init.php 提供

//******* 处理登陆状态
$state = $dou->AccountState();
if ($state === 'Access denied') {
    http_response_code(401);
    echo json_encode(array('status' => '-1', 'message' => '未登录或登录已失效，请重新登录'));
    exit;
}

// 初始化参数列表
$select   = array();
$filepath = array();
$fileico  = array();
$UData    = $dou->UploadFrame();
foreach ($UData as $value) {
    $select[]   = $value[0];
    $filepath[] = $value[2];
    $fileico[]  = $value[1];
}

$action  = isset($_GET['act']) ? (string)$_GET['act'] : '';
$frame   = isset($_GET['ifr']) ? (string)$_GET['ifr'] : '';
$syssize = (float)$dou->Info('upload_size');

if ($action === '' || $frame === '') {
    echo json_encode(array('status' => '-1', 'message' => '请求参数错误'));
    exit;
}

$key = array_search($frame, $select, true);
if ($key === false) {
    echo json_encode(array('status' => '-1', 'message' => '未知的上传框架'));
    exit;
}

// 解析该框架允许的扩展名（配置格式：系统;.png、.jpg;../../images/）
$allowExt = array();
foreach (explode('、', (string)$fileico[$key]) as $x) {
    $x = strtolower(trim(str_replace('.', '', $x)));
    if ($x !== '') {
        $allowExt[] = $x;
    }
}
$targetDir = (string)$filepath[$key];

/** 把配置里的相对目录转成绝对路径，并确认不越出站点根目录
 *  配置中的路径以 admin/system 为基准（如 ../../images/），
 *  因此先按 admin/system 解析，失败再按站点根解析。
 */
function sm_resolve_dir($dir)
{
    $dir = str_replace('\\', '/', $dir);
    if ($dir === '' || strpos($dir, '..') === false && strpos($dir, '/') === false) {
        return false;
    }
    $root = realpath(ROOT_PATH);
    if ($root === false) {
        return false;
    }
    $candidates = array(
        ROOT_PATH . 'admin/system/' . $dir,
        ROOT_PATH . $dir,
    );
    foreach ($candidates as $cand) {
        $abs = realpath($cand);
        if ($abs === false || !is_dir($abs)) {
            continue;
        }
        if (strpos($abs . DIRECTORY_SEPARATOR, $root . DIRECTORY_SEPARATOR) !== 0) {
            continue;
        }
        return rtrim(str_replace('\\', '/', $abs), '/') . '/';
    }
    return false;
}

$absDir = sm_resolve_dir($targetDir);
if ($absDir === false) {
    echo json_encode(array('status' => '-1', 'message' => '上传目录配置异常'));
    exit;
}

if ($action === 'add') {
    // 上传内容超过 post_max_size 时，PHP 会丢弃整个请求体，$_FILES/$_POST 都是空的，
    // 此时给出准确提示，避免误报为“未接收到上传文件”
    if (empty($_FILES) && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && (int)$_SERVER['CONTENT_LENGTH'] > 0) {
        echo json_encode(array('status' => '-1', 'message' => '上传内容超过服务器限制（post_max_size），请压缩文件或调大 PHP 配置'));
        exit;
    }
    if (empty($_FILES['mypic']) || !isset($_FILES['mypic']['error'])) {
        echo json_encode(array('status' => '-1', 'message' => '未接收到上传文件'));
        exit;
    }
    if ($_FILES['mypic']['error'] === UPLOAD_ERR_INI_SIZE || $_FILES['mypic']['error'] === UPLOAD_ERR_FORM_SIZE) {
        echo json_encode(array('status' => '-1', 'message' => '文件超过服务器 upload_max_filesize 限制'));
        exit;
    }
    if ($_FILES['mypic']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(array('status' => '-1', 'message' => '上传失败，错误码：' . (int)$_FILES['mypic']['error']));
        exit;
    }

    $picname = (string)$_FILES['mypic']['name'];
    $picsize = (int)$_FILES['mypic']['size'];

    if ($picsize > $syssize * 1024 * 1024) {
        echo json_encode(array('status' => '-1', 'message' => '文件大小超过限制'));
        exit;
    }
    if ($picsize <= 0) {
        echo json_encode(array('status' => '-1', 'message' => '文件内容为空'));
        exit;
    }

    $parts = explode('.', $picname);
    $type  = strtolower(end($parts));
    if ($type === '' || !preg_match('/^[a-z0-9]{1,10}$/', $type)) {
        echo json_encode(array('status' => '-1', 'message' => '文件格式错误！'));
        exit;
    }
    if (!in_array($type, $allowExt, true)) {
        echo json_encode(array('status' => '-1', 'message' => '文件格式错误！仅允许：' . implode('、', $allowExt)));
        exit;
    }

    $modulename = preg_replace('/[^A-Za-z0-9_\-]/', '', pathinfo($picname, PATHINFO_FILENAME));
    $pics       = date("YmdHis") . random_int(100, 999) . '.' . $type;

    $pic_path  = $absDir . $pics;
    if (!@move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path)) {
        echo json_encode(array('status' => '-1', 'message' => '文件保存失败，请检查目录权限'));
        exit;
    }
    @chmod($pic_path, 0644);

    $moduledata = '';

    switch ($frame) {
        case 'system':
            // 通用图片上传（后台 Logo 等），文件已保存在配置目录，直接返回文件名
            $moduledata = '';
            break;

        case 'module':
            if ($modulename === '') {
                echo json_encode(array('status' => '-1', 'message' => '模块名称非法'));
                exit;
            }
            $zip = new ZipArchive();
            if ($zip->open($pic_path) !== true) {
                $moduledata = 'Could not open Module Files';
            } else {
                $extractTo = ROOT_PATH . 'module/' . $modulename;
                // 防 Zip Slip：逐条校验条目路径
                $safe = true;
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = str_replace('\\', '/', (string)$zip->getNameIndex($i));
                    if (strpos($entry, '..') !== false || $entry[0] === '/') {
                        $safe = false;
                        break;
                    }
                }
                if (!$safe) {
                    $zip->close();
                    @unlink($pic_path);
                    echo json_encode(array('status' => '-1', 'message' => '压缩包内含非法路径，已拒绝'));
                    exit;
                }
                $zip->extractTo($extractTo);
                $zip->close();
                $dou->ModuleInstall('module/' . $modulename);
                $moduledata = 'Module File Install Complete!';
            }
            break;

        case 'softlogo':
            $imgBlob = file_get_contents($pic_path);
            $dou->UpdateSoftwareLogo($imgBlob);
            @unlink($pic_path);   // 已写入数据库，落地文件不再保留
            break;

        case 'logoview':
            $imgBlob = file_get_contents($pic_path);
            $dou->UpdateSoftwareLogoData('local', $imgBlob, isset($_GET['id']) ? $_GET['id'] : 0);
            @unlink($pic_path);
            break;

        case 'imgview':
            $imgBlob = file_get_contents($pic_path);
            $dou->UpdateSoftwareImgData('local', $imgBlob, isset($_GET['id']) ? $_GET['id'] : 0);
            @unlink($pic_path);
            break;

        case 'program':
            $sourceDir = rtrim(str_replace('\\', '/', LocalSource), '/');
            if (!is_dir($sourceDir)) {
                @mkdir($sourceDir, 0755, true);
            }
            $safeName = preg_replace('/[^A-Za-z0-9_\-\.\p{Han}]/u', '', $picname);
            if ($safeName === '' || strpos($safeName, '..') !== false) {
                @unlink($pic_path);
                echo json_encode(array('status' => '-1', 'message' => '文件名非法'));
                exit;
            }
            $dest = $sourceDir . '/' . $safeName;
            if (!@rename($pic_path, $dest)) {
                @unlink($pic_path);
                echo json_encode(array('status' => '-1', 'message' => '文件移动失败'));
                exit;
            }
            $pics = $safeName;
            break;

        default:
            @unlink($pic_path);
            echo json_encode(array('status' => '-1', 'message' => '不支持的操作'));
            exit;
    }

    $dou->OpLog('上传文件', '接口 ' . $frame . '，保存为 ' . $picname . '（' . round($picsize / 1024, 2) . 'KB）');
    echo json_encode(array(
        'name'    => $picname,
        'pic'     => $pics,
        'size'    => round($picsize / 1024, 2),
        'status'  => '0',
        'message' => $moduledata,
    ));
    exit;

} elseif ($action === 'del') {
    $filename = isset($_POST['imagename']) ? basename((string)$_POST['imagename']) : '';
    if ($filename === '' || !preg_match('/^[A-Za-z0-9_\-\.\p{Han}]{1,150}$/u', $filename) || strpos($filename, '..') !== false) {
        echo json_encode(array('status' => '-1', 'message' => '删除失败！'));
        exit;
    }

    if ($frame === 'program') {
        $dir = rtrim(str_replace('\\', '/', LocalSource), '/');
    } else {
        $dir = rtrim($absDir, '/');
    }

    $path = $dir . '/' . $filename;
    $real = realpath($path);
    $realRoot = realpath($dir);
    if ($real === false || $realRoot === false || strpos($real, $realRoot . DIRECTORY_SEPARATOR) !== 0) {
        echo json_encode(array('status' => '-1', 'message' => '删除失败！'));
        exit;
    }
    if (@unlink($real)) {
        $dou->OpLog('删除上传文件', '接口 ' . $frame . '，文件 ' . $filename);
        echo json_encode(array('status' => '0', 'message' => ''));
    } else {
        $dou->OpLog('删除上传文件', '接口 ' . $frame . '，文件 ' . $filename, '失败');
        echo json_encode(array('status' => '-1', 'message' => '删除失败！'));
    }
    exit;
}

echo json_encode(array('status' => '-1', 'message' => '不支持的操作'));
