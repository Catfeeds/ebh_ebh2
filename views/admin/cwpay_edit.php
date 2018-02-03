<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/cwpay/edit.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="cwid" value="<?=$cw['cwid']?>" />
<input type="hidden" name="crid" value="<?=$cw['crid']?>" />
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>课件名称<em>*</em><p>课件的名称</p></th>
    <td><input name="title" id="title" class="easyui-validatebox w300" required="true" value="<?=$cw['title']?>"/></td>
</tr>
<tr>
    <th>价格<p></p></th>
    <td><input type="text" name="cprice" class="intinput" id="cprice" value="<?=intval($cw['cprice'])?>"></td>
</tr>
<tr>
    <th>分成价格<p></p></th>
    <td>公司<input type="text" name="comfee" id="comfee" value="<?=$cw['comfee']?>" maxlength="9"> 网校<input type="text" name="roomfee" id="roomfee" value="<?=$cw['roomfee']?>"></td>
</tr>
<tr>
    <th>有效期<p></p></th>
    <td><label>
		<span class="	">课件有效期：<input class="bywhich" style="vertical-align:middle;margin-right:5px;" type="radio" name="bywhich" value="0" checked="checked"/>按月：</span><input class="husrrt intinput" name="cmonth" type="text" id="bym_input" value="<?=empty($cw['cmonth'])?'':$cw['cmonth']?>" maxlength="3" irequired="true"/><span class="huisprt">个月</span>
		</label>
		<label>
		<span class=""><input class="bywhich" style="vertical-align:middle;margin-right:5px;margin-left:20px;" type="radio" name="bywhich" value="1" />按日：</span><input class="husrrt intinput" name="cday" type="text" id="byd_input" value="<?=empty($cw['cday'])?'':$cw['cday']?>" maxlength="3" readonly="readonly" style="background:#CCC"/>日
		</label></td>
</tr>


</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">

</div>
<div id="dialog"></div>
</form>
</body>
<script type="text/javascript">
    $(function(){
		var cday = <?=empty($cw['cday'])?0:1?>;
		$('.bywhich[value='+cday+']').trigger('click');
	});
	
	$('.bywhich').click(function(){
		if($(this).val() == 0){
			$('#byd_input').attr('readonly','readonly').attr('irequired',false).css('background','#CCC');
			$('#bym_input').attr('irequired',true).removeAttr('readonly').css('background','#fff');
			validatewhich($('#bym_input'),$('#byd_input'));
		}else{
			$('#bym_input').attr('readonly','readonly').attr('irequired',false).css('background','#CCC');
			$('#byd_input').attr('irequired',true).removeAttr('readonly').css('background','#fff');
			validatewhich($('#byd_input'),$('#bym_input'));
		}
	});
	$('#title,#cprice,#comfee,#roomfee').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'不能为空'
	});
	function validatewhich(need,not){
		need.validatebox({
			required:true,
			validType: 'text',
			missingMessage:'不能为空'
		});
		not.validatebox({
			required:false
		});
	}
	$(document).on('keyup','.intinput',function(){
		$(this).val($(this).val().replace(/[^\d]/g,'').replace(/0*(\d+)/g,"$1"));
	});
</script>
<?php
$this->display('admin/footer');
?>