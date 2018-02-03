<?php $this->display('admin/header'); ?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>频道设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
				<tr>
					<td  class="active"><a href="/admin/category/channel.html" class="view">频道设置</a></td>
					<td ><a href="/admin/channel/add.html?position=<?=$position?>" class="add">创建频道</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
	<li>系统内置了课件、平台平台、平台展示频道、资讯等频道。您可以为这些频道进行重新命名，并确定是否显示在站点菜单上面。</li>
	<li>如果您在站点<u>系统设置</u>里面未开启某个频道功能，则该频道不会显示在站点菜单上面。</li>
</ul></td></tr></table><script type="text/javascript" language="javascript">
function checkAll()
{	
if($("#chkall").attr("checked"))
{
$("input[name='item[]']").each(function(){this.checked=true;});  
}
else
{
$("input[name='item[]']").each(function(){this.checked=false;});  
}

}
$(function(){

$("#moveop").click(function(){
$("#typetr").show();

})
$("#noop").click(function(){
$("#typetr").hide();

})
$("#sortop").click(function(){
$("#typetr").hide();

})
})
</script>
<form method="post" name="listform" id="theform" action="#" onsubmit="return whatOp()";>
<div id="newslisttab">
<ul>
<li <?php if($position==1)echo 'class="active"'?>><a href="/admin/channel.html?position=1">页头栏目</a></li>
<li <?php if($position==2)echo 'class="active"'?>><a href="/admin/channel.html?position=2">页脚栏目</a></li>
<li <?php if($position==3)echo 'class="active"'?>><a href="/admin/channel.html?position=3">顶部栏目</a></li>
<li <?php if($position==4)echo 'class="active"'?>><a href="/admin/channel.html?position=4">云平台栏目</a></li>
<li <?php if($position==5)echo 'class="active"'?>><a href="/admin/channel.html?position=5">答疑分类</a></li>
</ul>
</div>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.name" width="30%">频道名称</th>
<th fieldname="i.type">类型</th>
<th fieldname="i.identifier">模块标识</th>
<th fieldname="i.[top]">位置</th>
<th fieldname="i.[best]">显示</th>
<th fieldname="i.[lang]">排列顺序</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
<?php foreach ($category as $k=>$v){?>

<tr class="tr_module_0" tab="0" id="<?=$v['catid']?>" />
<th class="sn"><?=$k+1?></th>
<td class="sn"><input type="checkbox" name="item[]" value="<?=$v['catid']?>" /></td>
<td class="name"> <a target="<?=$v['target']?>" href="/<?=$v['code']?>.html"><?=$v['name']?></a></td>
<td class="type"></td>
<td class="identifier"><?=$v['code']?></td>
<td class="system"><?php echo getPosition($v['position']);?></td>
<td class="visible"><?php if($v['visible']==1){echo '可见';}else{echo '隐藏';}?></td>
<td class="sn"><input type="text" name="order<?=$v['catid']?>" class="w50" value="<?=$v['displayorder']?>"></td><td class="sn">[<a href="/admin/category/edit.html?type=channel&op=insert&catid=<?=$v['catid']?>&position=<?=$position?>">添加子分类</a>]&nbsp;&nbsp;[<a href="/admin/category/edit.html?type=channel&op=update&catid=<?=$v['catid']?>&position=<?=$position?>">编辑</a>]&nbsp;&nbsp;[<a onclick="return _move(<?=$v['catid']?>,<?=$v['displayorder']?>,1)" href="#">上移</a>]&nbsp;&nbsp;[<a onclick="return _move(<?=$v['catid']?>,<?=$v['displayorder']?>,-1)" href="#">下移</a>]&nbsp;&nbsp;[<a onclick="return _del(<?=$v['catid']?>,<?=$v['system']?>)" href="#">删除</a>]</td>
</tr>
<?php }?>
</tbody>

</table><table cellspacing="0" cellpadding="0" width="100%"  class="btmtable">
<tr><th><input id="chkall" type="checkbox" name="chkall" onclick="checkAll(this)">全选 <input id="noop" name="optype" type="radio" value="0" checked /><label for="noop">不操作</label>&nbsp;&nbsp;<input id="sortop" name="optype" type="radio" value="1" /> <label for="sortop">排序</label>&nbsp;&nbsp;<input id="moveop" name="optype" type="radio" value="2" /> <label for="moveop">移动分类</label></th></tr>
<tr id="typetr" style="display:none">
<th>选择分类：
<select name="opcatid" id='category'>
<option value="0">根目录</option>
 <?php $this->widget('category_widget',array('tag'=>'category','selected'=>'')); ?>
</select>
&nbsp;&nbsp;
<input id="inside" type="radio" checked value="inside" name="position"><label for="inside">指定栏目的里面</label>&nbsp;
<input id="before" type="radio" value="before" name="position"><label for="before">指定栏目的前面</label>&nbsp;
<input id="after" type="radio" value="after" name="position"><label for="after">指定栏目的后面</label>&nbsp;
</th>
</tr>
</table>

<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</form><br>
<script type='text/javascript'>
	
	function _del(catid,system){
		$.messager.prompt('确认','请输入验证码'+catid,function(data){
			if(data==catid){
				$.post(
					'/admin/category/delete.html',
					{catid:catid,system:system,type:"channel"},
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
				{catid:catid,upordown:upordown,displayorder:displayorder,type:"channel",position:"<?=$position?>"},
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
        
        $.post('/admin/category/sortopAll.html',{param:res,type:"channel",position:"<?=$position?>"},function(message){
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
        	{param:res,tag:tag,category:category,type:"channel",position:"<?=$position?>"},
        	function(message){
        		window.document.write(message);
        	}
        	);
    	return false;
    }

</script>

</body>
<?php $this->display('admin/footer'); ?>
