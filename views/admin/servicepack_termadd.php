<?php
$this->display('admin/header');
?>
<body id="main">

<form method="post" action="/admin/spterm/add.html" onsubmit="return $(this).form('validate')">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务期名称<em>*</em><p>服务期的名称。</p></th>
    <td><input name="tname" id="tname" class="easyui-validatebox w300" required="true" missingMessage="请输入服务期名称" /></td>
</tr>
<tr>
    <th>所属学校<em>*</em><p>请选择服务期所属的学校。</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" required="true" value="<?=$roomdetail['crname']?>" id="crname" name="crname">
	<input type="button" id="drop" value="选择" onclick="selectcr()"/>
	<input type="button" id="clear" value="清除" />
	<input type="hidden" name="crid" id="mediaid"  value="<?=$roomdetail['crid']?>" />
	</td>
</tr>


<tr>
    <th>摘要</th>
    <td><textarea cols="80" rows="10" name="tsummary" id="tsummary"></textarea></td>
</tr>

<tr>
    <th>排序<p>序号小的排在前面</p></th>
    <td><input type="text" name="displayorder" id="displayorder" value="0"></td>
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
    
	$('#clear').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
	});
	$('#crname').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'请选择所属学校'
	});
</script>
<?php
$this->display('admin/footer');
?>