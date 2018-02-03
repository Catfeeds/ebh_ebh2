<?php
$this->display('admin/header');
?>
<body id="main">

<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务项名称<em>*</em><p>服务项的名称。</p></th>
    <td><?=$itemdetail['iname']?></td>
</tr>
<tr>
    <th>所属服务包<em>*</em><p>请选择服务项所属服务包。</p></th>
    <td>
	<?=$itemdetail['pname']?>
	
	</td>
</tr>

<tr>
	<th>所属学校<p>请选择服务项所属学校,不选则与服务包相同</p></th>
    <td>
	<?=$itemdetail['crname']?>
	
	</td>
</tr>

<tr>
	<th>所属课程</th>
	<td>
	<select id="flist" name="folderid" disabled="disabled">
		
	</select>
	</td>
</tr>

<tr>
    <th>价格</th>
    <td><?=$itemdetail['iprice']?></td>
</tr>

<tr>
    <th>服务项时长</th>
    <td>
		<?php if(!empty($itemdetail['imonth'])){?>
        <label><input type="radio" name="bywhich" <?= !empty($itemdetail['imonth'])?'checked="checked"':''?> value="0" onclick="changedm(this.value)">按月：</label><?= !empty($itemdetail['imonth'])?$itemdetail['imonth']:''?> 个月
		<?php }else{?>
        <label><input type="radio" name="bywhich" <?= !empty($itemdetail['iday'])?'checked="checked"':''?> value="1" onclick="changedm(this.value)">按日：</label><?= !empty($itemdetail['iday'])?$itemdetail['iday']:''?> 日
		<?php }?>
    </td>
</tr>


<tr>
    <th>摘要</th>
    <td><?=$itemdetail['isummary']?></td>
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
		showfolder(<?=$itemdetail['crid']?>,<?=$itemdetail['folderid']?>);
    });
	
	function showfolder(crid,folderid){
		$.ajax({
			type:'post',
			url:'/admin/spitem/getroomfolders.html',
			data:{crid:crid},
			success:function(data){
				var folderlist = eval('('+data+')');
				$('#flist option').remove('');
				$('#flist').append('<option value="0">不选</option>');
				$.each(folderlist,function(i,item){
					if(item.folderid==folderid)
						$('#flist').append('<option value="'+item.folderid+'" selected="selected">'+item.foldername+'</option>');
					else
						$('#flist').append('<option value="'+item.folderid+'">'+item.foldername+'</option>');
				})
			}
		});
	}
	function closethis(){
		parent.$('.aui_close')[0].click();
	}
</script>
<?php
$this->display('admin/footer');
?>