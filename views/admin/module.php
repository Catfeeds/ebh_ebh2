<?php $this->display('admin/header'); ?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>功能模块管理 - 模块列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/module.html">浏览模块</a></td>
			<td ><a href="/admin/module/add.html" class="add">添加模块</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
<li>此模块为后台操作的功能模块，标记为“可见”的模块将在后台管理中显示。</li>
<li>在同一级别下，模块标识不能相同。模块标识会应用在后台 action= 后面的参数串中。</li>
<li>如果创建时指定为“系统”模块，那么该模块不能删除。</li>
<li>包含<img src="/images/icon/icon_arrow1.gif">图标的模块表示有重定向。</li>
</ul></td></tr></table><form method="post" name="listform" id="theform" action="" onsubmit="">
<input type="hidden" name="order" value="">
<input type="hidden" name="sc" value="">
</form>
<form method="post" name="listform" id="theform" action="" onsubmit="return whatOP(this)">
<input type="hidden" name="formhash" value="52b016b0" /><table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>展开</th>
<th>序号</th>
<th>选择</th>
<th>模块ID</th>
<th>上级ID</th>
<th fieldname="i.name" width="30%">模块名称</th>
<th fieldname="i.identifier">模块标识</th>
<th fieldname="i.[top]">系统</th>
<th fieldname="i.[best]">可见</th>
<th fieldname="i.[lang]">排列顺序</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">

<?php foreach ($modules as $k=>$value) {?>
<tr class="<?php if($value['visible']==0){echo 'darkrow5';}?>" />
<td class='zk' style='text-align:center;cursor:pointer' moduleid=<?=$value['moduleid']?> upid=<?=$value['upid']?>>╋</td>
<th class="sn"><?=$k+1?></th>
<td class="sn"><input type="checkbox" name="item[]" value="<?=$value['moduleid']?>" /></td>
<td class="name"><?=$value['moduleid']?></td>
<td class="name"><?=$value['upid']?></td>
<td class="name"> <a name="<?=$value['moduleid']?>"><?=$value['name']?></a> 
	<?php if(!empty($value['redir'])){?><img src="/images/icon/icon_arrow1.gif" title="重定向到<?=$value['redir']?>"></td><?php }?>
<td class="identifier"><?=$value['identifier']?></td>
<td class="sn"><?php if($value['system']==1){echo '是';}else{echo '否';} ?></td>
<td class="sn"><?php if($value['visible']==1){echo '显示';}else{echo '隐藏';} ?></td>
<td class="displayorder"><input type="text" name="displayorder[<?=$value['moduleid']?>]" value="<?=$value['displayorder']?>"></td>
<td class="op">
[<a href="/admin/module/add.html?moduleid=<?=$value['moduleid']?>">添加子模块</a>]
[<a href="/admin/module/add.html?moduleid=<?=$value['moduleid']?>&upid=<?=$value['upid']?>&op=edit">编辑</a>]
[<a href="#" onclick="_move(<?=$value['moduleid']?>)">移动</a>]
[<a href="/admin/module/moveupordown.html?moduleid=<?=$value['moduleid']?>&tag=-1">上移</a>]
[<a href="/admin/module/moveupordown.html?moduleid=<?=$value['moduleid']?>&tag=1">下移</a>]
[<a href="#" onclick="return del(<?=$value['moduleid']?>)">删除</a>]
</td>
</tr>
<?php }?>
</tbody>
</table><table cellspacing="0" cellpadding="0" width="100%"  class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input type="checkbox" name="chkall" id="chkall" onclick="checkall(this.form, 'item')"><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label for="noop">不操作</label>
<input type="radio" name="operation" value="delete" id="delete"><label for="delete">删除</label>
<input type="radio" name="operation" value="movecat" id="movecat"><label for="movecat">移动</label>
<input type="radio" name="operation" value="save" id="save"><label for="save">排序</label>
</th></tr>
<tr style="display: none;" id="divdelete"><th>删除</th><td>
<input type="radio" id="opdelete_0" checked value="0" name="opdelete"><label for="opdelete_0">隐藏分类</label>&nbsp;&nbsp;
<input type="radio" id="opdelete_1" value="1" name="opdelete"><label for="opdelete_1">直接删除</label>&nbsp;&nbsp;
<input type="radio" id="opdelete_2" value="2" name="opdelete"><label for="opdelete_2">强制删除（慎重操作，本操作有可能删除系统模块与所有子分类）</label>&nbsp;&nbsp;</td>
</tr>
<tr style="display: none;" id="divmovecat"><th>选择分类</th><td><select name="opcatid">
<option value="0" selected='selected'>根目录</option>
<?php foreach($modules as $v){?>
	<option value="<?=$v['moduleid']?>"><?=$v['name']?></option>
<?php }?>
</select>
</td></tr>

<tr id="divnoop" style="display:none"><td></td><td></td></tr>
</table>

<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</form>
<script type='text/javascript'>
	$(function(){
		$(".zk[upid!=0]").parent('tr').hide();
		$(".zk").click(function(){
			if($(this).html()=='╋'){
				$(this).html('─');
			}else{
				$(this).html('╋');
			}
			
			
			var upid = $(this).attr('moduleid');
			$(".zk[upid="+upid+"]").parent('tr').toggle();
		});
	});

	function del(moduleid){
		$.messager.prompt('提示信息:',"<div style='color:red'>此操作也同时删除该类下面的子类,请慎重!</div>\r\n请输入验证码:"+moduleid,function(data){
			if(data==moduleid){
				location.href='/admin/module/del.html?moduleid='+moduleid;
			}else{
				$.messager.alert('提示信息','验证失败');
				return false;
			}
		});
		return false;
	}


	function checkall(form, prefix, checkall, type) {

		var checkall = checkall ? checkall : 'chkall';
		var type = type ? type : 'name';
		for(var i = 0; i < form.elements.length; i++) {
			var e = form.elements[i];
			
			if(type == 'value' && e.type == "checkbox" && e.name != checkall) {
				if(e.name != checkall && (prefix && e.value == prefix)) {
					e.checked = form.elements[checkall].checked;
				}
			}else if(type == 'name' && e.type == "checkbox" && e.name != checkall) {
				if((!prefix || (prefix && e.name.match(prefix)))) {
					e.checked = form.elements[checkall].checked;
				}
			}
			
			
		}

	}
	$(function(){
		$(":radio[name=operation]").click(function(){
			$("[id^=div]").hide();
			$("#div"+$(this).val()).show();

		});
	});

	//操作路由器
	function whatOP(e){
		var op = $(":radio[name=operation]:checked").val()+'All';
		eval(op+'()');
		return false;
	}
	function deleteAll(){
		var res='';
		var tag=$(":radio[name=opdelete]:checked").val();
		var allchecked = $(":checkbox[name='item[]']:checked");
		$.each(allchecked,function(i,n){
			res+=';'+$(n).val();
		});
		$.post('/admin/module/delAll.html',{moduleids:res,tag:tag},function(message){
			if(message!=0){
				window.document.write(message);
			}else{
				$.messager.alert('提示信息','批量删除失败!');
			}
		});
		return false;
	}
	function movecatAll(){
		var res='';
		var toWhere=$("select[name=opcatid] option:selected").val();
		var allchecked = $(":checkbox[name='item[]']:checked");
		$.each(allchecked,function(i,n){
			res+=';'+$(n).val();
		});
		$.post('/admin/module/movecatAll.html',{moduleids:res,toWhere:toWhere},function(message){
			if(message!=0){
				window.document.write(message);
			}else{
				$.messager.alert('提示信息','批量移动失败!');
			}
		});
		return false;

	}
	function saveAll(){
		var res='';
		var allchecked = $(":checkbox[name='item[]']:checked");
		$.each(allchecked,function(i,n){
			res+=';'+$(n).val()+','+$("input[name='displayorder["+$(n).val()+"]']").val();
		});
		$.post('/admin/module/saveAll.html',{data:res},function(message){
			if(message!=0){
				window.document.write(message);
			}else{
				$.messager.alert('提示信息','批量排序失败!');
			}
			
		});
		return false;
	}

	function _move(moduleid){
		var order = $(":input[name='displayorder["+moduleid+"]']").val();
		location.href = '/admin/module/moveorder.html?moduleid='+moduleid+'&order='+order;
	}

</script>
<br>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
<?php $this->display('admin/footer');
?>

