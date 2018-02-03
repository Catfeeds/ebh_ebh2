<?php
	echo $this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>广告分类设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody>
				<tr>
					<td class="active"><a href="/admin/padstypes.html">浏览分类</a></td>
					<td><a href="/admin/padstypes/add.html" class="add">添加分类</a></td>
				</tr>
			</tbody></table>
		</td>
	</tr></tbody>
</table>

<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.name" width="30%">分类名称</th>
<!-- <th fieldname="i.type">类型</th> -->
<th fieldname="i.identifier">模块标识</th>
<th fieldname="i.[top]">描述</th>
<th fieldname="i.[best]">可见模块</th>
<th fieldname="i.[lang]">排列顺序</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
<?php foreach ($padstypes as $k=>$v){?>

<tr class="tr_module_0" tab="0" id="<?=$v['tid']?>" />
<th class="sn"><?=$k+1?></th>
<td class="sn"><input type="checkbox" name="item[]" value="<?=$v['tid']?>" /></td>
<td class="name"><?=$v['name']?></td>
<!-- <td class="type"></td> -->
<td class="identifier"><?=$v['code']?></td>
<td class="system"><?=$v['description']?></td>
<td class="visible"><?php if($v['visible']==1){echo '可见';}else{echo '隐藏';}?></td>
<?php if($v['upid']!=0){?>
<td class="sn"><input type="text" name="order<?=$v['tid']?>" class="w50" value="<?=$v['displayorder']?>"></td><td class="sn">&nbsp;&nbsp;[<a href="/admin/padstypes/edit.html?tid=<?=$v['tid']?>&upid=<?=$v['upid']?>">编辑</a>]&nbsp;&nbsp;[<a onclick="_del(<?=$v['tid']?>)" href="#">删除</a>]</td>
<?php }else{?>
<td class="sn"><input type="text" name="order<?=$v['tid']?>" class="w50" value="<?=$v['displayorder']?>"></td><td class="sn">[<a href="/admin/padstypes/add.html?tid=<?=$v['tid']?>">添加子分类</a>]&nbsp;&nbsp;[<a href="/admin/padstypes/edit.html?tid=<?=$v['tid']?>&upid=<?=$v['upid']?>">编辑</a>]&nbsp;&nbsp;[<a onclick="_del(<?=$v['tid']?>)" href="#">删除</a>]</td>
<?php }?>
</tr>
<?php }?>
</tbody>
</table>
<form method="post" name="listform" id="theform" action="" onsubmit="return whatOp();">
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tbody>
	<tr>
		<th width="12%">批量操作</th>
		<th><input id="chkall" type="checkbox" name="chkall" onclick="checkAll(this)">全选 <input id="noop" name="optype" type="radio" value="0" checked=""><label for="noop">不操作</label>&nbsp;&nbsp;<input id="sortop" name="optype" type="radio" value="1"> <label for="sortop">排序</label>&nbsp;&nbsp;<input id="moveop" name="optype" type="radio" value="2"> <label for="moveop">移动</label></th></tr>

<tr id="typetr" style="display: none;">
<th>选择目标分类</th><td>
<?=$pselect?>
&nbsp;&nbsp;
<input id="inside" type="radio" checked="" value="2" name="position"><label for="inside">指定分类的里面</label>&nbsp;
<input id="before" type="radio" value="1" name="position"><label for="before">指定分类的前面</label>&nbsp;
<input id="after" type="radio" value="3" name="position"><label for="after">指定分类的后面</label>&nbsp;
</td>
</tr>

</tbody></table>
<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>
<form>
</table>

<script type='text/javascript'>
	
	function _del(tid){
		$.messager.prompt('确认','请输入验证码'+tid,function(data){
			if(data==tid){
				$.post(
					'/admin/padstypes/delete.html',
					{tid:tid},
					function(message){
						window.document.write(message);
					}
				);  
			}else{
				$.messager.alert('操作提示','验证码有误!');
			}
		});
		return false;
	}	
	function checkAll(e){
		$("input[name='item[]']").prop('checked',$(e).prop('checked'));
	}
	


	function _move(tid,displayorder,upordown){
		$.post(
				'/admin/category/moveHandle.html',
				{tid:tid,upordown:upordown,displayorder:displayorder},
				function(message){
						window.document.write(message);
					}
				);
		return false;
	}


	$("#moveop").click(function(){
		$("#typetr").show();
	});
	$("#noop").click(function(){
		$("#typetr").hide();
	});
	$("#sortop").click(function(){
		$("#typetr").hide();
	});

	//批量操作路由器
    function whatOp(){
        var opTag = $(":radio[name='optype']:checked").attr('id');
        var op = opTag+'All';
        eval(op+'(opTag)');
        return false;
    }

    function sortopAll(){
    	var res=';';
    	var allChecked = $(":checkbox[name='item[]']:checked");
    	$.each(allChecked,function(i,v){
            res+=$(v).val()+','+$("input[name=order"+$(v).val()+"]").val()+';';
        });
        $.post('/admin/padstypes/sortopAll.html',{param:res},function(message){
        		window.document.write(message);}
        		);
    }
    function noopAll(){
    	return false;
    }
    function moveopAll(){
    	var res='';
    	var allChecked = $(":checkbox[name='item[]']:checked");
    	$.each(allChecked,function(i,v){
            res+=$(v).val()+';';
        });
        var tag = $(":radio[name=position]:checked").val();
        var category = $("select[name=upid]").val();
        $.post('/admin/padstypes/moveAll.html',
        	{param:res,tag:tag,category:category},
        	function(message){
        		window.document.write(message);
        	}
        	);
    	return false;
    }

</script>
<?php
	$this->display('admin/footer');
?>