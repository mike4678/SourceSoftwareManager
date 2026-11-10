<?php
/* ---------------------------------------------------- */
/* 后台列表页（日志 / 意见 / 软件）
/* 安全修订说明（2026）：
/*  1. 表名经 safeIdent 白名单校验，搜索词 quote() 转义，消除注入
/*  2. 模板字段统一转义：普通字段 h()，嵌入 JS 字符串的 data 字段 js_text()
/*  3. 页码与分页链接重写，修复页码恒为 1 且链接拼接 HTTP_HOST 的问题
/*  4. 删除请求先校验再执行，失败不再继续渲染页面
/* ---------------------------------------------------- */
if (!defined('source')) {
    header("Location: ../login.php");
    exit;
}

$FilePath = str_replace('\\', '/', __FILE__) ?: (isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '');

$listKey = isset($addr[2]) ? $addr[2] : '';

if ($dou->content($listKey, 'list_name') == 'error') {
    echo $dou->Admin_ErrorPage(isset($addr[1]) ? $addr[1] : '', $listKey, $FilePath);
    exit;
}

$table_name = $dou->content($listKey, 'list_name');
$tableTpl   = $dou->content($listKey, 'table');
$tableTpl   = $tableTpl == 'error' ? '' : $tableTpl;
$validTable = $dou->safeIdent($table_name);

if ($validTable === false) {
    echo $dou->Admin_ErrorPage(isset($addr[1]) ? $addr[1] : '', $listKey, $FilePath);
    exit;
}

// ---------- 页码 ----------
$tab  = isset($addr[1]) ? $addr[1] : 'system';
$page = 1;
if (isset($addr[3]) && is_numeric($addr[3])) {
    $page = to_int($addr[3], 1);
}
if ($page < 1) {
    $page = 1;
}

$search = '';
$where  = '';

// ---------- 请求处理 ----------
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // 兼容 /id12 形式的删除
        $last = end($addr);
        if (is_string($last) && strpos($last, 'id') === 0) {
            $dou->DelData($validTable, 'id', substr($last, 2), 'GET');
            exit;
        }
        break;

    case 'POST':
        if (!empty($_POST['search']) && is_string($_POST['search'])) {
            $search = trim($_POST['search']);
            if (function_exists('mb_substr')) {
                $search = mb_substr($search, 0, 50, 'UTF-8');
            }
            if ($search !== '') {
                $where = " WHERE `softname` LIKE " . $dou->quote('%' . $search . '%');
            }
        } elseif (!empty($_POST['id'])) {
            $ids = is_array($_POST['id']) ? $_POST['id'] : array($_POST['id']);
            $dou->DelData($validTable, 'id', implode(',', array_map('strval', $ids)), 'POST');
            exit;
        }
        break;
}
?>
<script>
<?php echo $dou->content($listKey, 'script'); ?>
</script>
<form method="post" action="#">
	<div class="row">
<?php
echo $dou->content($listKey, 'table_head');

$Page_size = to_int($dou->Info('pagedisplay'), 20);
if ($Page_size < 1 || $Page_size > 200) {
    $Page_size = 20;
}

$count    = (int)$dou->get_one("SELECT COUNT(*) FROM `" . $validTable . "`" . $where);

if ($count < 1) {
    echo '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;没有更多的数据了</td></tr>';
    $key = '';
} else {
    $page_count = (int)ceil($count / $Page_size);
    if ($page > $page_count) {
        $page = $page_count;
    }
    $offset = ($page - 1) * $Page_size;

    $result = $dou->query("SELECT * FROM `" . $validTable . "`" . $where
        . " ORDER BY `id` DESC LIMIT " . $offset . "," . $Page_size);
    while ($row = $dou->fetch_array($result)) {
        $html = $tableTpl;
        preg_match_all('/{([A-Za-z0-9_^&]+)}/', $tableTpl, $out, PREG_PATTERN_ORDER);
        if (!empty($out[1])) {
            foreach (array_unique($out[1]) as $token) {
                $phpTpl = '{' . $token . '}';
                if (strpos($token, '^&') !== false) {
                    $parts  = explode('^&', $token);
                    $field  = $parts[0];
                    $mode   = isset($parts[1]) ? $parts[1] : '';
                    $value  = isset($row[$field]) ? $row[$field] : '';
                    if ($mode === 'data') {
                        if (is_numeric($value) && (int)$value > 0) {
                            $show = date('Y-m-d H:i:s', (int)$value);
                        } else {
                            $ts   = strtotime((string)$value);
                            $show = $ts ? date('Y-m-d H:i:s', $ts) : (string)$value;
                        }
                    } elseif ($mode === 'ipdata') {
                        $show = (string)$value . ' ( ' . $dou->Get_IPData((string)$value) . ' )';
                    } else {
                        $show = (string)$value;
                    }
                    $html = str_replace($phpTpl, h($show), $html);
                } else {
                    $value = isset($row[$token]) ? $row[$token] : '';
                    // data 字段常被放进 javascript:info("...") 的字符串里
                    $html = str_replace($phpTpl, $token === 'data' ? h(js_text($value)) : h($value), $html);
                }
            }
        }
        // 删除链接里的占位替换（相对地址，避免 Host 注入）
        $html = str_replace('$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]', h('index.php?/' . $tab . '/' . $listKey), $html);
        echo $html;
    }

    // ---------- 分页 ----------
    $basePath = 'index.php?/' . rawurlencode($tab) . '/' . rawurlencode($listKey) . '/';
    $page_len = 7;
    $pageoffset = 3;
    $init  = 1;
    $max_p = $page_count;
    if ($page_count > $page_len) {
        if ($page <= $pageoffset) {
            $init  = 1;
            $max_p = $page_len;
        } elseif ($page + $pageoffset >= $page_count + 1) {
            $init  = $page_count - $page_len + 1;
            $max_p = $page_count;
        } else {
            $init  = $page - $pageoffset;
            $max_p = $page + $pageoffset;
        }
    }

    $key = '<ul class="pagination">';
    if ($page > 1) {
        $key .= '<li><a href="' . h($basePath . ($page - 1)) . '">上一页</a></li>';
    } else {
        $key .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">上一页</span></a></li>';
    }
    for ($i = $init; $i <= $max_p; $i++) {
        if ($i == $page) {
            $key .= '<li class="active"><a>' . $i . '</a></li>';
        } else {
            $key .= '<li><a href="' . h($basePath . $i) . '">' . $i . '</a></li>';
        }
    }
    if ($page < $page_count) {
        $key .= '<li><a href="' . h($basePath . ($page + 1)) . '">下一页 </a></li>';
    } else {
        $key .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">下一页 </span></a></li>';
    }
    $key .= '</ul>';
}
?>
		</table>
		<nav style="text-align:center;">
			<?php echo $key; ?>
		</nav>
	</div>
</form>
</div>
