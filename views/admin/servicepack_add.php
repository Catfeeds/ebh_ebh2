<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/servicepack/add.html" onsubmit="return $(this).form('validate')">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务包名称<em>*</em><p>服务包的名称。</p></th>
    <td><input name="pname" id="pname" class="easyui-validatebox w300" required="true" missingMessage="请输入服务包名称" /></td>
</tr>
<tr>
    <th>所属学校<em>*</em><p>请选择服务包所属的学校。</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" required="true" value="" id="crname" name="crname">
	<input type="button" id="drop" value="选择" onclick="selectcr()"/>
	<input type="button" id="clear" value="清除" />
	<input type="hidden" name="crid" id="mediaid"  value="" />
	</td>
</tr>

<tr>
	<th>限制开课时间<p>用于区分包含相同课程的服务包</p></th>
	<td>
	<input type="checkbox" id="limitdatecb" name="limitchecked" value="1"/>
	<div id="limitdate" style="display:none">
	<input type="text" name="limitdate" class="w150 easyui-datebox" value="<?=Date('Y-m-d',SYSTIME)?>"/>
	</div>
	</td>
</tr>

<tr>
    <th>摘要</th>
    <td><textarea cols="80" rows="10" name="summary" id="summary"></textarea></td>
</tr>

<tr>
    <th>排序<p>序号小的排在前面</p></th>
    <td><input type="text" name="displayorder" id="displayorder" value="0">提示：排序号为-1，首页课程列表默认选中全部，否则选中第一个服务包</td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">

</div>
</form>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
	$(function(){
		$(".datebox :text").attr("readonly","readonly");
		parent.$('.aui_titleBar .aui_title').html('添加服务包');
	});
	
	$('#clear').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
	});
	$('#clearterm').click(function(){
		$('#tid').val("");
		$('#tname').val("");
	});
	$('#crname').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'请选择所属学校'
	});
	$('#limitdatecb').click(function(){
		if($(this).prop('checked')==true)
			$('#limitdate').show();
		else
			$('#limitdate').hide();
	});
</script>
<?php
$this->display('admin/footer');
?>