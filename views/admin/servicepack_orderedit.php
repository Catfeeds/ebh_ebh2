<?php
$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>服务项管理 - 修改服务项</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td ><a href="/admin/spitem.html">浏览</a></td>
            <td  class="active"><a href="/admin/spitem/add.html" class="add">添加服务项</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form method="post" action="/admin/spitem/edit.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="itemid" value="<?=$itemdetail['itemid']?>"/>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务项名称<em>*</em><p>服务项的名称。</p></th>
    <td><input name="iname" id="username" class="easyui-validatebox w300" required="true" missingMessage="请输入服务项名称" value="<?=$itemdetail['iname']?>"/></td>
</tr>
<tr>
    <th>所属服务包<em>*</em><p>请选择服务项所属服务包。</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" value="<?=$itemdetail['pname']?>" id="pname" name="pname">
	<input type="button" id="selsp" value="选择" />
	<input type="button" id="clearsp" value="清除" />
	<input type="hidden" name="pcrid" id="crid"  value="<?=$itemdetail['pcrid']?>" />
	<input type="hidden" name="pid" id="pid"  value="<?=$itemdetail['pid']?>" />
	</td>
</tr>

<tr>
	<th>所属学校<p>请选择服务项所属学校,不选则与服务包相同</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" value="<?=$itemdetail['crname']?>" id="crname" name="crname">
	<input type="button" id="selcr" value="选择" />
	<input type="button" id="clearcr" value="清除" />
	<input type="hidden" name="crid" id="mediaid"  value="<?=$itemdetail['crid']?>" />
	</td>
</tr>

<tr>
	<th>所属课程</th>
	<td>
	<select id="flist" name="folderid">
		
	</select>
	</td>
</tr>

<tr>
    <th>价格</th>
    <td><input type="text" class="w300" maxlength="50" name="iprice" value="<?=$itemdetail['iprice']?>"></td>
</tr>

<tr>
    <th>服务项时长</th>
    <td>
        <label><input type="radio" name="bywhich" <?= !empty($itemdetail['imonth'])?'checked="checked"':''?> value="0" onclick="changedm(this.value)">按月：</label><input id="bym_input" type="text" style="width:50px" name="imonth" value="<?= !empty($itemdetail['imonth'])?$itemdetail['imonth']:''?>"/> 个月
        <label><input type="radio" name="bywhich" <?= !empty($itemdetail['iday'])?'checked="checked"':''?> value="1" onclick="changedm(this.value)">按日：</label><input id="byd_input" type="text" style="width:50px" readonly="readonly" name="iday" value="<?= !empty($itemdetail['iday'])?$itemdetail['iday']:''?>"/> 日
    </td>
</tr>


<tr>
    <th>摘要</th>
    <td><textarea cols="55" rows="3" name="isummary" ><?=$itemdetail['isummary']?></textarea></td>
</tr>
</table>
</table>
<div class="buttons">
<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">

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
	function changedm(type){
		if(type==0){
			$('#byd_input').attr('readonly','readonly');
			$('#bym_input').removeAttr('readonly');
			$('#byd_input').val('');
		}else if(type==1){
			$('#byd_input').removeAttr('readonly');
			$('#bym_input').attr('readonly','readonly');
			$('#bym_input').val('');
		}
	}
	$('#selsp').click(function(){
		$('#dialog').dialog({    
	    title: '选择服务包',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/servicepack/servicepack_search.html',    
	    modal: true   
		});
		// $("#ck").trigger('click');    
	});
	$('#selcr').click(function(){
		$('#dialog').dialog({    
	    title: '选择学校',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/common/classroom_search.html',    
	    modal: true   
		});
		// $("#ck").trigger('click');    
	});
	$('#clearsp').click(function(){
		$('#pid').val("");
		$('#pname').val("");
		$('#crid').val("");
	});
	$('#clearcr').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
		$('#flist').val("0");
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
</script>
<?php
$this->display('admin/footer');
?>