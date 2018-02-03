<?php
	echo $this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td><h1>栏目设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td class="active"><a href="/admin/category/<?=$type?>.html">浏览分类</a></td>
			<td><a href="/admin/category/edit.html?type=<?=$type?>&op=insert" class="add">添加分类</a></td>
			</tr>
			</tbody></table>
		</td>
	</tr></tbody>
</table>

<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.name" width="30%">栏目名称</th>
<th fieldname="i.type">类型</th>
<th fieldname="i.identifier">模块标识</th>
<th fieldname="i.[top]">位置</th>
<th fieldname="i.[best]">可见模块</th>
<th fieldname="i.[lang]">排列顺序</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
<?php foreach ($category as $k=>$v){?>

<tr class="tr_module_0" tab="0" id="<?=$v['catid']?>" />
<th class="sn"><?=$k+1?></th>
<td class="sn"><input type="checkbox" name="item[]" value="<?=$v['catid']?>" /></td>
<td class="name"> <a target="<?=empty($v['target'])?'':$v['target']?>" href="/<?=$v['code']?>.html"><?=$v['name']?></a></td>
<td class="type"></td>
<td class="identifier"><?=$v['code']?></td>
<td class="system"><?php echo getPosition($v['position']);?></td>
<td class="visible"><?php if($v['visible']==1){echo '可见';}else{echo '隐藏';}?></td>
<td class="sn"><input type="text" name="order<?=$v['catid']?>" class="w50" value="<?=$v['displayorder']?>"></td><td class="sn">[<a href="/admin/category/edit.html?type=<?=$type?>&op=insert&catid=<?=$v['catid']?>">添加子分类</a>]&nbsp;&nbsp;[<a href="/admin/category/edit.html?type=<?=$type?>&op=update&catid=<?=$v['catid']?>">编辑</a>]&nbsp;&nbsp;[<a onclick="return _move(<?=$v['catid']?>,<?=$v['displayorder']?>,1)" href="#">上移</a>]&nbsp;&nbsp;[<a onclick="return _move(<?=$v['catid']?>,<?=$v['displayorder']?>,-1)" href="#">下移</a>]&nbsp;&nbsp;[<a onclick="return _del(<?=$v['catid']?>,<?=$v['system']?>)" href="#">删除</a>]</td>
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
<select name="category" id="category">
 <?php $this->widget('category_widget',array('where'=>array('type'=>$type),'tag'=>'category','selected'=>'')); ?>
</select>
&nbsp;&nbsp;
<input id="inside" type="radio" checked="" value="inside" name="position"><label for="inside">指定分类的里面</label>&nbsp;
<input id="before" type="radio" value="before" name="position"><label for="before">指定分类的前面</label>&nbsp;
<input id="after" type="radio" value="after" name="position"><label for="after">指定分类的后面</label>&nbsp;
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
	
	function _del(catid,system){
		$.messager.prompt('确认','请输入验证码'+catid,function(data){
			if(data==catid){
				$.post(
					'/admin/category/delete.html',
					{catid:catid,system:system,type:"<?=$type?>"},
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
	


	function _move(catid,displayorder,upordown){
		$.post(
				'/admin/category/moveHandle.html',
				{catid:catid,upordown:upordown,displayorder:displayorder,type:"<?=$type?>"},
				function(message){
						window.document.write(message);
					}
				);
		return false;
	}

	
	$(function(){
		$.post(
		'/admin/category/newsCategories.html',
		{_tag:'html'},
		function(message){
			$('#opcatid').html(message);
			},
		'text/html'
		)
	});



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
    	var res='';
    	var allChecked = $(":checkbox[name='item[]']:checked");
    	$.each(allChecked,function(i,v){
            res+=$(v).val()+','+$("input[name=order"+$(v).val()+"]").val()+';';
        });
        
        $.post('/admin/category/sortopAll.html',{param:res,type:"<?=$type?>"},function(message){
        		window.document.write(message);}
        		);
    }
    function moveopAll(){
    	var res='';
    	var allChecked = $(":checkbox[name='item[]']:checked");
    	$.each(allChecked,function(i,v){
            res+=$(v).val()+';';
        });
        var tag = $(":radio[name=position]:checked").val();
        var category = $("#category").val();
        $.post('/admin/category/moveopAll.html',
        	{param:res,tag:tag,category:category,type:"<?=$type?>"},
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