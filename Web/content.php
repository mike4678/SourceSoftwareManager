<?php
/* ---------------------------------------------------- */
/* 前台软件列表 / 详情页
/* 安全修订说明（2026）：
/*  1. 搜索词、分类名进入 SQL 前统一 quote()，消除注入
/*  2. 输出到表格的字段统一 h() 转义，消除存储型 XSS
/*  3. 页码与分页链接重写，修复“翻页即丢分类 / 页码恒为 1”的问题
/*  4. 分页地址不再直接拼接 HTTP_HOST，避免 Host 头注入
/* ---------------------------------------------------- */

/* ---------------------------------------------------- */
/* 说明：本文件既可由 index.php 包含渲染，也允许被直接访问；
/* 直接访问时先补齐运行环境（原代码直接访问会因缺少 Init 而致命报错） */
/* ---------------------------------------------------- */
if (!function_exists('to_int')) {
    require_once dirname(__FILE__) . '/kernl/Init.php';
}
if (!isset($dou) || !is_object($dou)) {
    require_once dirname(__FILE__) . '/kernl/Connect.Class.php';
    $dou = new System(DBSERVER, USER, PASSWORD, DB, 'utf8mb4');
}
if (!isset($addr)) {
    $addr = $dou->AddrConvery($_GET);
}

$sc = isset($_COOKIE['setclient']) ? (string)$_COOKIE['setclient'] : '';
$isAndroid = ($sc === 'android');

if ($isAndroid) {
    $table = "<tr><td class=\"mailbox-subject\"><span class=\"mailbox-subject-title\">{softname}(版本号:{version} 大小:{size} KB)</span><br><br>简介：{synopsis}</td><td>{updatetime}</td><td style=\"text-align:center\"><a class='ico-item mdi mdi-download' href='d.php?pid={id}'>下载</a></td></tr>";
} else {
    $table = "<tr><td class=\"mailbox-subject\"><span class=\"mailbox-subject-title\">{softname}</span><br><br>简介：{synopsis}</td><td style=\"text-align:center\">{version}</td><td style=\"text-align:center\">{size} KB</td><td>{updatetime}</td><td style=\"text-align:center\"><a class='ico-item mdi mdi-download' href='d.php?pid={id}'>下载</a></td></tr>";
}

$Page_size = to_int($dou->Info('pagedisplay'), 20);
if ($Page_size < 1 || $Page_size > 200) {
    $Page_size = 20;
}

// ---------- 解析分类与页码（兼容 ?/分类/页码 与 ?/页码） ----------
$type = '';
$page = 1;
if (isset($addr[1]) && $addr[1] !== '') {
    if (is_numeric($addr[1])) {
        $page = to_int($addr[1], 1);
    } else {
        $type = $addr[1];
        if (isset($addr[2]) && is_numeric($addr[2])) {
            $page = to_int($addr[2], 1);
        }
    }
}
if ($page < 1) {
    $page = 1;
}

// ---------- 组装查询条件 ----------
$where = array();
if ($sc === 'android') {
    $where[] = "`softwaretype` = 'mobile'";
} elseif ($sc === 'pc') {
    $where[] = "`softwaretype` = 'pc'";
}
if ($type !== '') {
    $where[] = "`type` = " . $dou->quote($type);
}

$search = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = trim((string)$_POST['search']);
    if (function_exists('mb_substr')) {
        $search = mb_substr($search, 0, 50, 'UTF-8');
    }
    if ($search !== '') {
        $where[] = "`softname` LIKE " . $dou->quote('%' . $search . '%');
    }
}

$whereSql = empty($where) ? '' : ' WHERE ' . implode(' AND ', $where);

// ---------- 统计与分页 ----------
$count    = (int)$dou->get_one("SELECT COUNT(*) FROM `zd_software`" . $whereSql);
$pageCount = $count > 0 ? (int)ceil($count / $Page_size) : 1;
if ($page > $pageCount) {
    $page = $pageCount;
}
$offset = ($page - 1) * $Page_size;

// ---------- 分页基础地址（相对路径，不含 Host） ----------
$basePath = 'index.php?/';
if ($type !== '') {
    $basePath .= rawurlencode($type) . '/';
    $pageLink = function ($n) use ($basePath) {
        return $basePath . $n;
    };
} else {
    $pageLink = function ($n) use ($basePath) {
        return $basePath . $n;
    };
}
?>
<form method="POST" action="#">
	<div class="row">
	<div class="box"><div class="box-header with-border"><h3 class="box-title">软件下载</h3><div class="box-tools"><div class="has-feedback"><input type="text" class="form-control input-sm" name='search' placeholder="输入软件名称搜索" value="<?php echo h($search); ?>"><span class="fa fa-search form-control-feedback"></span></div></div></div>
          <div class="box-body no-padding"><div class="mailbox-controls">
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" title="刷新" onclick="location.reload();"><i class="fa fa-refresh"></i></button>
				<button type="button" class="btn btn-default btn-sm waves-effect waves-light" title="查看全部" onclick="javascript:ShowAll('all');"><i class="fa fa-cubes"></i></button>
				<button type="button" class="btn btn-default btn-sm waves-effect waves-light" title="仅查看PC软件" onclick="javascript:ShowAll('pc');"><i class="fa fa-desktop"></i></button>
				<button type="button" class="btn btn-default btn-sm waves-effect waves-light" title="仅查看手机软件" onclick="javascript:ShowAll('android');"><i class="fa fa-tablet"></i></button>
        </div>
        <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
		<?php
        if ($isAndroid) {
            echo '<thead><tr><th style="text-align:center">软件名</th><th style="text-align:center">更新时间</th><th>操作</th></tr></thead>';
        } else {
            echo '<thead><tr><th style="text-align:center">软件名</th><th style="text-align:center">版本</th><th style="text-align:center">容量</th><th style="text-align:center">更新时间</th><th>操作</th></tr></thead>';
        }

$key = '';
if ($count < 1) {
    echo '<tr><td>&nbsp;</td><td>&nbsp;&nbsp;没有更多的数据了</td></tr>';
} else {
    $result = $dou->query("SELECT * FROM `zd_software`" . $whereSql . " ORDER BY `id` DESC LIMIT " . $offset . "," . $Page_size);
    while ($row = $dou->fetch_array($result)) {
        // 时间字段兼容 Unix 时间戳与日期字符串两种历史数据
        $t = $row['updatetime'];
        if (is_numeric($t) && (int)$t > 0) {
            $showTime = date('Y-m-d H:i:s', (int)$t);
        } elseif (is_string($t) && $t !== '') {
            $ts = strtotime($t);
            $showTime = $ts ? date('Y-m-d H:i:s', $ts) : $t;
        } else {
            $showTime = '';
        }

        $html = $table;
        $html = str_replace('{softname}', h($row['softname']), $html);
        $html = str_replace('{version}', h($row['version']), $html);
        $html = str_replace('{size}', h($row['size']), $html);
        $html = str_replace('{synopsis}', h($row['synopsis']), $html);
        $html = str_replace('{updatetime}', h($showTime), $html);
        $html = str_replace('{id}', to_int($row['id']), $html);
        echo $html;
    }

    // ---------- 分页 ----------
    $page_len   = 7;
    $pageoffset = 3;
    $init  = 1;
    $max_p = $pageCount;
    if ($pageCount > $page_len) {
        if ($page <= $pageoffset) {
            $init  = 1;
            $max_p = $page_len;
        } elseif ($page + $pageoffset >= $pageCount + 1) {
            $init  = $pageCount - $page_len + 1;
            $max_p = $pageCount;
        } else {
            $init  = $page - $pageoffset;
            $max_p = $page + $pageoffset;
        }
    }

    $key = '<ul class="pagination">';
    if ($page > 1) {
        $key .= "<li><a href=\"" . h($pageLink($page - 1)) . "\">上一页</a></li>";
    } else {
        $key .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">上一页</span></a></li>';
    }
    for ($i = $init; $i <= $max_p; $i++) {
        if ($i == $page) {
            $key .= '<li class="active"><a>' . $i . '</a></li>';
        } else {
            $key .= "<li><a href=\"" . h($pageLink($i)) . "\">" . $i . "</a></li>";
        }
    }
    if ($page < $pageCount) {
        $key .= "<li><a href=\"" . h($pageLink($page + 1)) . "\">下一页 </a></li>";
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
