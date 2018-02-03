<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>权限管理 - 操作管理</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/operation.html">浏览操作</a></td>
			<td ><a href="/admin/operation/add.html" class="add">添加操作</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
<li>操作值采用二进制编码方式，即2的n次方递增编码。</li>
</ul></td></tr></table>
<form method="post" action="/admin/operation/handle.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="opid" value="<?=$p['opid']?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
	<th>操作码<p>2的N次方，此值由系统自动生成。</p></th>
	<td><input type="text" class="w150 disabled" readonly="true" value="<?=$p['opid']?>" /></td>
</tr>
<tr>
	<th>操作标识<p>请填写英文标识，不可以重复，供其它模块调用<p></th>
	<td><input name="opcode" type="text"  <?php if($op=='edit'){echo 'readonly="true"','class="w150 disabled"';}else{echo 'class="w150';}?>  value="<?=$p['opcode']?>"   onblur="" /></td>
</tr>
<tr>
	<th>操作名称<p></p></th>
	<td><input type="text" class="w150" name="opname" value="<?=$p['opname']?>"   onblur="" /></td>
</tr>
<tr>
	<th>操作描述<p>对该操作的详细描述。</p></th>
	<td><input type="text" class="w300" name="description" value="<?=$p['description']?>"></input></td>
</tr>
<tr><th>积分操作</th><td>
<input type="radio" name="iscredit" value="0" <?php if($p['iscredit']==0){echo 'checked=checked';}?>  >无操作
<input type="radio" name="iscredit" value="1" <?php if($p['iscredit']==1){echo 'checked=checked';}?> >加分
<input type="radio" name="iscredit" value="2" <?php if($p['iscredit']==2){echo 'checked=checked';}?> >减分
<em></em>
</td></tr>
<tr><th>适用位置</th><td>
<input type="checkbox" name="opvalue[]" value="1" <?php if($p['position']&1){echo 'checked=checked';}?> >前台
<input type="checkbox" name="opvalue[]" value="2" <?php if($p['position']&2){echo 'checked=checked';}?> >后台
<input type="checkbox" name="opvalue[]" value="4" <?php if($p['position']&4){echo 'checked=checked';}?> >系统
</td></tr>	
</table><div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
</div>

</form>
<br>
<script type='text/javascript'>
$.extend($.fn.validatebox.defaults.rules, {    
    checklen: {    
        validator: function(value){  
            return /^[a-zA-Z]{1,20}$/.test(value);       
        }  
    }    
});
$(function(){
	$('input').blur(function(){
		$(this).val($.trim($(this).val()));
	});
});
$(function(){
	$('input[name=opcode]').validatebox({    
	    required: true,
	    validType:'checklen',
	    missingMessage:'操作标识不能为空',
	    invalidMessage:'操作标识必须为长度1-20的英文'  
	});  
});
$(function(){
	$('input[name=opname]').validatebox({    
	    required: true,
	    missingMessage:'操作名称不能为空',
	    validType:'length[1,20]',
	    invalidMessage:'操作名称长度为1-20' 
	});  
});
</script>
</body>

<?php $this->display('admin/footer');?>