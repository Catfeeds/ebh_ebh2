<?php $this->display('admin/header');?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>功能模块管理 - 模块列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/module.html">浏览模块</a></td>
			<td  class="active"><a href="/admin/moudle/add.html" class="add">添加模块</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable">
	<tr>
		<td>
			<ul>
				<li>此模块为后台操作的功能模块，标记为“可见”的模块将在后台管理中显示。</li>
				<li>在同一级别下，模块标识不能相同。模块标识会应用在后台 action= 后面的参数串中。</li>
				<li>如果创建时指定为“系统”模块，那么该模块不能删除。</li>
				<li>包含<img src="/images/icon/icon_arrow1.gif">图标的模块表示有重定向。</li>
			</ul>
		</td>
	</tr>
</table>
<form id='_form' method="post" action="/admin/module/handle.html" >
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="moduleid" value="<?=empty($module)?0:$module['moduleid']?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
	<th>上级模块<p>指定该模块隶属于哪个模块下面。</p></th>
	<td>
	<select name="upid"  id="upid">
		<option value="0">根目录</option>
		<?php $this->widget('module_widget',array('selected'=>$upid,'tag'=>'upid')); ?>
	</select>
	</td>
</tr>
<tr>
	<th>模块名称<span>＊</span></th>
	<td><input type="text" class="w300" name="name" value="<?=$module['name']?>"></input></td>
</tr>
<tr>
	<th>模块标识<span>＊</span><p>即功能模块 action= 后的链接路径</p></th>
	<td><input type="text" class="w300" name="identifier"  value="<?=$module['identifier']?>"></input></td>
</tr>
<tr>
	<th>模块描述</th><td><input type="text" class="w300" name="description" value="<?=$module['description']?>"></input></td>
</tr>
<tr>
	<th>重定向<p>当定义此属性时，链接路径为相对网站根目录的路径。例如: /admin.php?action=ad</p></th>
	<td><input type="text" class="w300" name="redir" value="<?=$module['redir']?>"></input></td>
</tr>
<tr>
	<th>是否为系统模块<p>注意：当指定为“系统”模块时，不可删除。</p></th>
	<td>
	<input type="radio" name="system" value="1"   <?php  if($module['system']==1){echo 'checked=checked';}?> />系统模块
	<input type="radio" name="system" value="0"   <?php  if($module['system']==0){echo 'checked=checked';}?> />非系统模块
	<em></em>
	</td>
</tr>
<tr>
	<th>是否为可见模块<p>您可以使模块在后台功能管理中不可见。</p></th>
	<td>
		<input type="radio" name="visible" value="1"  <?php  if($module['visible']==1){echo 'checked=checked';}?> />可见
		<input type="radio" name="visible" value="0"  <?php  if($module['visible']==0){echo 'checked=checked';}?> />不可见
		<em></em>
	</td>
</tr>
<tr>
	<th>适用操作</th>
	<td>
		<?php $this->widget('operation_widget',array('opvalue'=>$module['opvalue'],'position'=>'2,3'))?>
	</td>
</tr>
<tr>
	<th>显示顺序</th>
	<td><input type="text" class="w150" name="displayorder" value="<?=$module['displayorder']?>" /></td>
</tr>
<tr>
	<th>完成后是否继续添加</th>
<td>	
<input type="checkbox"   name="nextop" value="1">继续添加
</td>	
</tr>
</table><div class="buttons">

<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
</div>

</form>
<script type='text/javascript'>
	$.extend($.fn.validatebox.defaults.rules, {    
	    isNumber: {    
	        validator: function(value, param){
	        	if(/^\d+$/.test(value)){
	        		return true;
	        	}else{
	        		return false;
	        	}      
	        },    
	        message: '排序必须为数字,且前后不能有空格!'   
	    }    
	});  


	$("input[name=name]").validatebox({    
   	 	required:true,
   	 	missingMessage:'名称不能为空!',
   	 	invalidMessage:'名称长度为2-10之间!',   
    	validType:'length[2,10]'  
	});
	$("input[name=identifier]").validatebox({    
   	 	required:true,
   	 	missingMessage:'模块标识不能为空!'  
	});
	$(":radio[name=system]").validatebox({
		required:true,
		missingMessage:'系统模块为空!'
	});
	$(":radio[name=visible]").validatebox({
		required:true,
		missingMessage:'可见模块为空!'
	});
	$("input[name=valuesubmit]").click(function(){
		return $("#_form").form('validate');
	});
	$("input[name=displayorder]").validatebox({    
   	 	required:true,
   	 	validType:'isNumber',
   	 	missingMessage:'显示顺序不能为空!'  
	});	
	
</script>
</body>
<?php 
	$this->display('admin/footer');
?>