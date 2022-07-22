<?php 
if (!defined('source'))
	header("Location: ../login.php"); //重定向浏览器
$data = array
(
  "TabName"=>array("TabName"=>"数据库设置"), //第一个为标题
   array("Name"=>"数据库管理","tab"=>'#tab-set',"active"=>'active'), //往后的为选项夹
);
$dou->FormCreate($data);
?>
      <div class="tab-body">
        <br />
        <div class="tab-panel active" id="tab-set">
        	<form method="post" class="form-x" action="#">
            <div class="form-group">
                	<div class="label"><label>备份文件列表</label></div>
                	<div class="field">
                        <div class="button-group button-group-small radio">
                        <select name="tableSelect" size="10" id="tableSelect" class='select' style="margin-top:6px">
            <?php
			$arr = array();
if (!file_exists('backup')) {
    mkdir("backup");
    echo "<option value=>第一次使用请先备份数据</option>";
} else {
    $d = dir("backup");
    while (false !== ($e = $d->read())) {
		$arr[] = $e; } 
	 if (count($arr) > 2) {   //判断文件数量是否大于2，如果不大于则认为不存在备份文件
	 unset($arr[0],$arr[1]);
              foreach ($arr as $v=>$a)  {
                echo "<option value=" . $a . ">" . $a . "</option>";
            }   
	    } else {echo "<option value=>无可用备份数据</option>";}
}

?>

            </select></div>
                    </div>
                </div>
				<div class="form-group" style="margin-top:6px" >
                	<div class="label"><label>数据库操作</label></div>
                	<div class="field">
                       <input name="databasebak" type="submit" class="button" id="databasebak" value="备份数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="恢复数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="清空数据库" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="删除备份" />&nbsp;&nbsp;<input name="databasebak" type="submit" class="button" id="databasebak" value="下载备份" />
                    </div>
                </div>
            
        </div>
      </div>
    </div>
</div>
</form>
<script>
$(function(){
	$(".button").on('click',  function(event) {
		event.preventDefault();
		var ControlType = $(event.target).val();
		var name = $('#tableSelect').val();		
		$.ajax({
			url: 'system/databasecontrol.php',
			type: 'POST',
			dataType: 'json',
			data: {control: ControlType,filename: name},
			success: function(res)
			{
				var code = res.status;
				var message = res.message;
				SystemBox(3,message,'','','','',30);
				if(code == 0)
				{
					history.go(0);
				}
				if(code == 99)
				{
					SystemBox(2,'http://'+ document.domain + ':' + window.location.port + window.location.pathname + '?/downbackup','','','','','1');
					
				}
			}
		});
	});
});
</script>	