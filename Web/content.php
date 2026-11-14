<?php
/* ---------------------------------------------------- */
/* 前台软件列表 / 详情页
/* 安全修订说明（2026）：
/*  1. 搜索词、分类名进入 SQL 前统一 quote()，消除注入
/*  2. 输出到表格的字段统一 h() 转义，消除存储型 XSS
/*  3. 页码与分页链接重写，修复“翻页即丢分类 / 页码恒为 1”的问题
/*  4. 分页地址不再直接拼接 HTTP_HOST，避免 Host 头注入
/*  5. 新增：列表显示软件 Logo 缩略图，点击“详情”查看截图与介绍
/*     · Logo / 截图来自后台“软件Logo / 运行截图”上传（存于 zd_imgdata）
/*     · 图片统一由 pic.php 按随机码输出，URL 经白名单校验后才拼进 src
/*     · 详情数据以 JSON 放入 data 属性，前端用 text() 渲染，杜绝二次注入
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

/* ---------- 图片地址解析 ---------- */
/** 过滤历史脏值（空 / NULL / 0 都视为无图） */
function sm_pic_value($v)
{
    $v = trim((string)$v);
    if ($v === '' || $v === 'NULL' || $v === 'null' || $v === '0') {
        return '';
    }
    return $v;
}

/** 是否为可直接使用的网络图片地址（只认 http/https） */
function sm_is_remote($v)
{
    return (bool)preg_match('#^https?://[^\s"\'<>]+$#i', (string)$v);
}

/** 本地图片文件名是否安全（允许相对路径但禁止 ../ 穿越） */
function sm_is_safe_file($v)
{
    $v = (string)$v;
    if ($v === '' || strpos($v, '..') !== false || strpos($v, "\0") !== false) {
        return false;
    }
    return (bool)preg_match('#^[A-Za-z0-9_\-./]+\.(png|jpe?g|gif|bmp|ico)$#i', $v);
}

/** 计算 Logo 的 img src */
function sm_logo_src($row)
{
    $code = sm_pic_value(isset($row['logodata']) ? $row['logodata'] : '');
    if ($code === '') {
        return '';
    }
    $type = isset($row['logotype']) ? (int)$row['logotype'] : 0;
    $id   = to_int(isset($row['id']) ? $row['id'] : 0);
    if ($type === 1) {
        if (sm_is_remote($code)) {
            return $code;
        }
        return sm_is_safe_file($code) ? $code : '';
    }
    // 少数历史数据直接存的是图片文件名
    if (strpos($code, '.') !== false) {
        return sm_is_safe_file($code) ? $code : '';
    }
    // 正常情况：5 位随机码，由 pic.php 输出
    if (preg_match('/^[A-Za-z0-9]{1,40}$/', $code)) {
        return 'pic.php?code=' . rawurlencode($code) . '&sid=' . $id;
    }
    return '';
}

/** 计算运行截图列表 */
function sm_shots_list($row)
{
    $out = array();
    $raw = sm_pic_value(isset($row['runpic']) ? $row['runpic'] : '');
    if ($raw === '') {
        return $out;
    }
    $type = isset($row['runpictype']) ? (int)$row['runpictype'] : 0;
    $id   = to_int(isset($row['id']) ? $row['id'] : 0);

    foreach (explode(',', $raw) as $x) {
        $x = sm_pic_value($x);
        if ($x === '') {
            continue;
        }
        if ($type === 1) {
            if (sm_is_remote($x)) {
                $out[] = $x;
            }
        } elseif (strpos($x, '.') !== false) {
            if (sm_is_safe_file($x)) {
                $out[] = $x;
            }
        } elseif (preg_match('/^[A-Za-z0-9]{1,40}$/', $x)) {
            $out[] = 'pic.php?code=' . rawurlencode($x) . '&sid=' . $id;
        }
    }
    return $out;
}

$sc = isset($_COOKIE['setclient']) ? (string)$_COOKIE['setclient'] : '';
$isAndroid = ($sc === 'android');

/* 列表行模板：{logo} 为缩略图，{detail} 为详情按钮 */
if ($isAndroid) {
    $table = "<tr><td class=\"mailbox-subject\">{logo}<span class=\"mailbox-subject-title\">{softname}(版本号:{version} 大小:{size} KB)</span><br><br>简介：{synopsis}</td><td>{updatetime}</td><td style=\"text-align:center\">{detail}<a class='ico-item mdi mdi-download' style='display:block;margin:0 auto' href='d.php?pid={id}' title='下载'></a></td></tr>";
} else {
    $table = "<tr><td class=\"mailbox-subject\">{logo}<span class=\"mailbox-subject-title\">{softname}</span><br><br>简介：{synopsis}</td><td style=\"text-align:center\">{version}</td><td style=\"text-align:center\">{size} KB</td><td>{updatetime}</td><td style=\"text-align:center\">{detail}<a class='ico-item mdi mdi-download' style='display:block;margin:0 auto' href='d.php?pid={id}' title='下载'></a></td></tr>";
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
<style>
.soft-logo{display:inline-block;width:42px;height:42px;margin-right:10px;vertical-align:middle;border-radius:6px;background:#f2f4f7;object-fit:contain;border:1px solid #e6e9ef;}
.soft-logo-empty{display:inline-block;width:42px;height:42px;margin-right:10px;vertical-align:middle;border-radius:6px;background:#f2f4f7;border:1px solid #e6e9ef;text-align:center;line-height:42px;color:#b9c0cc;font-size:18px;}
.soft-detail-btn{display:block;margin:0 auto 4px;color:#3b8cff;cursor:pointer;font-size:18px;line-height:1;}
.sm-detail{display:block;font-size:13px;color:#333;max-height:400px;overflow:auto;padding:2px 4px;width:720px;max-width:100%;text-align:left;box-sizing:border-box;}
.sm-detail-row{margin-bottom:8px;line-height:1.7;}
.sm-detail-label{display:inline-block;min-width:64px;color:#888;}
.sm-detail-intro{white-space:pre-wrap;word-break:break-word;background:#f7f9fc;border:1px solid #eef1f6;border-radius:4px;padding:8px;margin-top:4px;}
.sm-shots{display:flex;flex-wrap:wrap;gap:8px;margin-top:8px;}
.sm-shots img{width:150px;height:100px;object-fit:contain;border:1px solid #e6e9ef;border-radius:4px;cursor:pointer;background:#f2f4f7;}
</style>
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
            echo '<thead><tr><th style="text-align:center">软件名</th><th style="text-align:center">更新时间</th><th style="text-align:center;white-space:nowrap">操作</th></tr></thead>';
        } else {
            echo '<thead><tr><th style="text-align:center">软件名</th><th style="text-align:center">版本</th><th style="text-align:center">容量</th><th style="text-align:center">更新时间</th><th style="text-align:center;white-space:nowrap">操作</th></tr></thead>';
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

        $softId = to_int($row['id']);

        // ---------- Logo 缩略图 ----------
        $logoSrc = sm_logo_src($row);
        if ($logoSrc !== '') {
            $logoHtml = '<img class="soft-logo" src="' . h($logoSrc) . '" alt="' . h((string)$row['softname']) . '"'
                . ' onerror="this.style.display=\'none\';this.nextSibling.style.display=\'inline-block\';">';
            $logoHtml .= '<span class="soft-logo-empty" style="display:none">&nbsp;</span>';
        } else {
            $logoHtml = '<span class="soft-logo-empty">?</span>';
        }

        // ---------- 详情数据（JSON 放 data 属性，前端只做文本渲染） ----------
        $introRaw = (string)$row['introduce'];
        $introTxt = str_replace('@#cr#@', "\n", $introRaw);
        $detail = array(
            'name'  => (string)$row['softname'],
            'ver'   => (string)$row['version'],
            'size'  => (string)$row['size'],
            'time'  => $showTime,
            'syn'   => (string)$row['synopsis'],
            'intro' => $introTxt,
            'logo'  => $logoSrc,
            'shots' => sm_shots_list($row),
            'down'  => 'd.php?pid=' . $softId,
        );
        $detailJson = json_encode($detail, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $detailBtn  = '<a class="soft-detail-btn mdi mdi-information-outline" href="javascript:void(0);" title="查看详情" onclick="smSoftDetail(this)"'
            . ' data-soft="' . h($detailJson) . '"></a>';

        $html = $table;
        $html = str_replace('{logo}', $logoHtml, $html);
        $html = str_replace('{detail}', $detailBtn, $html);
        $html = str_replace('{softname}', h($row['softname']), $html);
        $html = str_replace('{version}', h($row['version']), $html);
        $html = str_replace('{size}', h($row['size']), $html);
        $html = str_replace('{synopsis}', h($row['synopsis']), $html);
        $html = str_replace('{updatetime}', h($showTime), $html);
        $html = str_replace('{id}', $softId, $html);
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
            $max_p  = $page + $pageoffset;
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
<script>
/* 详情弹窗：所有字段来自 data-soft（JSON），文本一律走 escapeText / textContent 方式渲染 */
(function () {
	if (typeof art === 'undefined' || !art.dialog) { return; }

	function esc(s) {
		return String(s == null ? '' : s)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
	}

	window.smSoftDetail = function (el) {
		var raw = el.getAttribute('data-soft');
		var d;
		try { d = JSON.parse(raw); } catch (e) { return; }

		var logo = d.logo ? '<img src="' + esc(d.logo) + '" style="width:64px;height:64px;object-fit:contain;border:1px solid #e6e9ef;border-radius:6px;background:#f2f4f7;vertical-align:middle;margin-right:12px;">' : '';
		var html = '<div class="sm-detail">'
			+ '<div class="sm-detail-row">' + logo
			+ '<span style="font-size:16px;font-weight:600;">' + esc(d.name) + '</span></div>'
			+ '<div class="sm-detail-row"><span class="sm-detail-label">版本</span>' + esc(d.ver)
			+ '&nbsp;&nbsp;<span class="sm-detail-label">容量</span>' + esc(d.size) + ' KB'
			+ '&nbsp;&nbsp;<span class="sm-detail-label">更新时间</span>' + esc(d.time) + '</div>'
			+ '<div class="sm-detail-row"><span class="sm-detail-label">简介</span>' + esc(d.syn) + '</div>'
			+ '<div class="sm-detail-row"><span class="sm-detail-label">详细介绍</span>'
			+ '<div class="sm-detail-intro">' + esc(d.intro || '暂无') + '</div></div>';

		if (d.shots && d.shots.length) {
			html += '<div class="sm-detail-row" style="margin-top:6px;">运行截图（' + d.shots.length + ' 张，点击看大图）'
				+ '<div class="sm-shots">';
			for (var i = 0; i < d.shots.length; i++) {
				html += '<img src="' + esc(d.shots[i]) + '" onclick="smShowShot(this.src)">';
			}
			html += '</div></div>';
		}

		html += '<div class="sm-detail-row" style="margin-top:12px;text-align:right;">'
			+ '<a href="' + esc(d.down) + '" class="btn btn-primary btn-sm">下载</a></div></div>';

		art.dialog({
			title: d.name,
			content: html,
			width: 760,
			height: 480,
			lock: true,
			fixed: true
		});
	};

	window.smShowShot = function (src) {
		art.dialog({
			title: '查看截图',
			content: '<div style="text-align:center;background:#f2f4f7;padding:6px;">'
				+ '<img src="' + esc(src) + '" style="max-width:900px;max-height:640px;"></div>',
			width: 'auto',
			height: 'auto',
			lock: true,
			fixed: true
		});
	};
})();
</script>
</div>
