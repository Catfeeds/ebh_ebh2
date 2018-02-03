<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/servicepack/edit.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="pid" value="<?=$packdetail['pid']?>" />
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务包名称<em>*</em><p>服务包的名称。</p></th>
    <td><?=$packdetail['pname']?></td>
</tr>
<tr>
    <th>所属学校<em>*</em><p>请选择服务包所属的学校。</p></th>
    <td>
	<?=$packdetail['crname']?>
	
	</td>
</tr>


<tr>
    <th>摘要</th>
    <td><?=$packdetail['summary']?></td>
</tr>
</table>
<div class="buttons">
<input type="button" value="关闭" class="submit" onclick="closethis()"/>
</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
    function closethis(){
		parent.$('.aui_close')[0].click();
	}
</script>
<?php
$this->display('admin/footer');
?>