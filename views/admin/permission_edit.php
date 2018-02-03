<?php
$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
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
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
<th>用户组<p></p></th>
<td><?php echo $permissionlist[0]['groupname'];?></td>
</tr>

<tr>
<th>适用操作</th>
<td><input type="checkbox" name="opvalue[0][]" value="128" >登录<input type="checkbox" name="opvalue[0][]" value="131072" >管理后台</td>
</tr>
</table>

<div class="buttons">
<input type="submit" name="sysubmit" value="提交保存" class="submit">
<input type="reset" name="sysreset" value="重置">
</div>

<form action="<?php echo geturl('admin/permission/edit');?>" method="post" id="valuesubmit">
<div class="hidrow"></div>
<input type="hidden" value="<?php echo $groupid;?>" name="groupid"/>
</form>


<form action="<?php echo geturl('admin/permission/edit');?>" method="post" id="main_form">
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

for($i=0;$i<$plen;$i++)
{
	$pstr = '';
	foreach($operationlist as $op){
	
		if(intval($permissionlist[$i]['opvalue'])&intval($op['opid']))
		{
			if(intval($permissionlist[$i]['popvalue'])&intval($op['opid']))
				$pstr.= '<label class="checked"><input name="opvalue['.intval($permissionlist[$i]['moduleid']).'][]" type="checkbox" checked="checked" value="'.$op['opid'].'">'.$op['opname'].'</label>';
			else
				$pstr.= '<label class="unchecked"><input name="opvalue['.intval($permissionlist[$i]['moduleid']).'][]" type="checkbox" value="'.$op['opid'].'">'.$op['opname'].'</label>';
		}
		else{
			$pstr.= '<label class="disabled"><input type="checkbox" value="'.$op['opid'].'" disabled="true">'.$op['opname'].'</label>';
		}
	}
	echo '<tr id="'.$permissionlist[$i]['moduleid'].'">';
	echo '<th class="sn">'.($i+1).'</th>';
	echo '<td class="sn"><input type="checkbox"/></td>';
	echo '<td>'.$permissionlist[$i]['name'].'</td>';
	echo '<td>'.$pstr.'</td>';
	echo '<td><input class="chkallbtn" type="button" value="全选"/> <input class="subbtn" type="button" value="更新"/></td>';
	echo '</tr>';
}
?>
</table>
</form>
<script>
$(function(){
	$(".subbtn").click(function(){
		$dom = $(this);
		$(".hidrow").html($(this).parent("td").parent("tr").clone());
		if( $(".hidrow input:checked").length == 0){
			var id = $(this).parent("td").parent("tr").attr('id');
			var key = 'opvalue['+id+'][]';
			var data = {};
			data['groupid'] = "<?=$groupid?>";
			data['opvalue'] = {};
			data['opvalue'][id] = {};
			data['opvalue'][id][0] = 0;
		}else{
			var data = $("#valuesubmit").serialize();
		}	
		$.ajax({
		   type: "POST",
		   url: "<?=geturl('admin/permission/edit');?>",
		   data: data,
		   success: function(msg){
		   		if(msg>0){
		   			alert("更新成功");
		   		}else{
		     		alert("没有记录改变");
		   		}
		   		$.each($dom.parent('td').prev().find('label'),function(i,o){
	   				if($(o).find('input:enabled').length == 1){
	   					if($(o).find('input').prop('checked')){
	   						$(this).removeClass().addClass('checked');
	   					}else{
	   						$(this).removeClass().addClass('unchecked');
	   					}
	   				}
	   			});
		   }
		});
	});
	$(".chkallbtn").bind('click',function(){
		$(this).parent('td').prev().find('input:enabled').prop('checked',true);
	});
})
</script>
<style>
.hidrow{display:none;}
.checked{color:blue;}
.unchecked{color:red;}
</style>
<?php
$this->display('admin/footer');
?>