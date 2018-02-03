<?php
$this->display('admin/header');
?>
<body id="main">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务期名称<em>*</em><p>服务期的名称。</p></th>
    <td><?=$termdetail['tname']?></td>
</tr>
<tr>
    <th>所属学校<em>*</em><p>请选择服务期所属的学校。</p></th>
    <td>
	<?=$termdetail['crname']?>
	
	</td>
</tr>


<tr>
    <th>摘要</th>
    <td><?=$termdetail['tsummary']?></td>
</tr>

<tr>
    <th>排序<p>序号小的排在前面</p></th>
    <td><?=$termdetail['tdisplayorder']?></td>
</tr>
</table>
<div class="buttons">
<input type="button" value="关闭" class="submit" onclick="closethis()"/>
</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
    $(function(){
        $("#birthdate").trigger('focus');
        $("#username").blur(function(){
            $(this).val($(this).val().replace(/\s+/g,''));
        });
    });
	
	$('#drop').click(function(){
		$('#dialog').dialog({    
	    title: '选择教室',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/common/classroom_search.html',    
	    modal: true   
		});
		$("#ck").trigger('click');    
	});
	$('#clear').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
	});
	$('#crname').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'请选择所属学校'
	});
	function closethis(){
		parent.$('.aui_close')[0].click();
	}
</script>
<?php
$this->display('admin/footer');
?>