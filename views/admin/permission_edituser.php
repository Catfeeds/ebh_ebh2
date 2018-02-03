<?php
$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>功能模块管理 - 模块列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="admin.php?token=3afb633e50cdf1b2&action=permission">浏览模块</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>全选</th>
<th>模块名称</th>
<th>权限</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
<?php
$plen = count($permissionlist);
//var_dump($operationlist);

for($i=0;$i<$plen;$i++)
{
	$pstr = '';
	foreach($operationlist as $op){
	//echo $permissionlist[$i]['opvalue'];
	//echo 1&63;
	//var_dump($op['opid']);
		if(intval($permissionlist[$i]['opvalue'])&intval($op['opid']))
		{
			if(intval($permissionlist[$i]['popvalue'])&intval($op['opid']))
				$pstr.= '<label class="checked"><input type="checkbox" checked="checked" value="'.$op['opid'].'">'.$op['opname'].'</label>';
			else
				$pstr.= '<label class="unchecked"><input type="checkbox" value="'.$op['opid'].'">'.$op['opname'].'</label>';
		}
		else{
			$pstr.= '<label><input type="checkbox" value="'.$op['opid'].'" disabled="true">'.$op['opname'].'</label>';
		}
	}
	echo '<tr>';
	echo '<td>'.($i+1).'</td>';
	echo '<td><input type="checkbox"/></td>';
	echo '<td>'.$permissionlist[$i]['name'].'</td>';
	echo '<td>'.$pstr.'</td>';
	echo '<td><input type="button" value="全选"/> <input type="button" value="更新"/></td>';
	echo '</tr>';
}
?>
</table>
<style>
.checked{color:blue;}
.unchecked{color:red;}
</style>
<?php
$this->display('admin/footer');
?>