<?php $this->display('admin/header');?>

<body>
<h2>积分设置</h2>
<form action="/admin/setting/saveCreditRule.html" method="POST">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">


<tr id="tr_thumbbgcolor">
	<th>积分策略<p>会员执行相关操作将产生的积分</p><p>如需开启更多积分功能操作，请到 <a href="/admin/operation.html">基本设置 -> 用户组权限 -> 操作管理</a> 中设置。</p></th>
	<td>		
		<div style="position: relative;" >
				<div id="credit_preview"  style="position:absolute;z-index: 1; top: 0px; right: 0px; background-color: green; width:0px; height:0px;"></div>
				<div id="div_option" style="position:relative; z-index: 1000; top: 0px;left: 0px; ">
					<?php
						foreach($creditlist as $cl){
							unset($activechecked);
							unset($achecked);
							$activechecked[$cl['action']=='-'?'2':'1'] = ' checked="checked"';
							$achecked[$cl['actiontype']]=' selected="selected"';
					?>
					
					<div style="margin:4px 0" id="div_option_<?=$cl['ruleid']?>" onmouseover=" $('#credit_preview').css('width',this.className+'px');$('#credit_preview').css('height',this.lang+'px');" class="<!--{eval echo $creditval[0]}-->" lang="<!--{eval echo $creditval[1]}-->">
						<label style="width:100px;float:left;">
						<input type='text' name='creditrule[<?=$cl['ruleid']?>][rulename]' size='8' maxlength=20 style="width:80px;" value="<?=$cl['rulename']?>">
						
						</label>:
						<input type="radio" name="creditrule[<?=$cl['ruleid']?>][action]" <?=empty($activechecked['1'])?'':$activechecked['1']?> value="+" id="action_p_<?=$cl['ruleid']?>"><label for="action_p_<?=$cl['ruleid']?>">加分</label>
						<label>
						<input type="radio" name="creditrule[<?=$cl['ruleid']?>][action]" <?=empty($activechecked['2'])?'':$activechecked['2']?> value="-" id="action_m_<?=$cl['ruleid']?>">减分</label>
						
						<input type="text" name="creditrule[<?=$cl['ruleid']?>][credit]" size="3" value="<?=$cl['credit']?>" maxlength=4 onkeyup="value=value.replace(/[^\d]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" > 积分, 
					 		<input type="button" value="删除" onclick="del_input('div_option_<?=$cl['ruleid']?>');">
						操作类型:<select name="creditrule[<?=$cl['ruleid']?>][actiontype]" class="actiontype">
								<option value="0" <?=empty($achecked[0])?'':$achecked[0]?> >每次操作更改积分</option>
								<option value="-1" <?=empty($achecked[-1])?'':$achecked[-1]?> >操作只更改一次</option>
								<option value="-2" <?=empty($achecked[-2])?'':$achecked[-2]?> >当天操作更改积分</option>
								<?php if($cl['ruleid'] == 5){?>
								<option value="1" <?=empty($achecked[1])?'':$achecked[1]?> >每个课件只获得一次积分</option>
								<?php }?>
							</select>
						操作次数：<input type="text" name="creditrule[<?=$cl['ruleid']?>][maxaction]" size="3" value="<?=$cl['maxaction']?>" maxlength=4 onkeyup="value=value.replace(/[^\d]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" >
						操作描述：<input type="text" name="creditrule[<?=$cl['ruleid']?>][description]" size="60" value="<?=$cl['description']?>">
					</div>
					<?php
						}
					?>
					<span id="credit"/>
				</div>
				<input type="button" name="Submit" value="添加积分规格" onClick="add_credit()" />
			</div>
	</td>
</tr>
</table>
<div class="buttons">
	<input type="submit" value=" 保存 " class="submit">
	<input type="reset" value="重置">
</div>

</form>
</body>
	<script>
	
	var branchindex = 0; 
		function add_credit() {
			//document.getElementById("div_option").innerHTML += '<div style="margin:4px 0">宽度 <input type="text" name="thumbarr[]" size="5" value=""> 像素, 高度 <input type="text" name="thumbarr[]" size="5" value=""> 像素 <input type="button" value="删除" onclick="del_inputthis(this);"</div>';
			i=0;
			$("#credit").before("<div style='margin:4px 0' id='div_option_new_"+branchindex+"'>"+
						"<label style='width:100px;float:left;'><input type='text' name='newcreditrule["+branchindex+"][rulename]' size='8' maxlength=20 style='width:80px;'></label>"+
						": "+
						'<label><input type="radio" name="newcreditrule['+branchindex+'][action]" checked="checked" value="+" id="action_p_'+branchindex+'">增分</label> '+
						'<label><input type="radio" name="newcreditrule['+branchindex+'][action]" value="-" id="action_m_'+branchindex+'">减分</label> '+
						
						"<input type='text' name='newcreditrule["+branchindex+"][credit]' size='3' maxlength=4 onkeyup='value=value.replace(/[^\\d]/g,\"\") ' onbeforepaste='clipboardData.setData(\"text\",clipboardData.getData(\"text\").replace(/[^\\d]/g,\"\"))' > "+
						"积分, "+
						"<input type='button' value='删除' onclick='del_input(\"div_option_new_"+branchindex+"\");' > 操作类型:"+
						"<select name='newcreditrule["+branchindex+"][actiontype]' class='actiontype'>"+
							"<option value='0'>每次操作增加积分</option>"+
							"<option value='-1'>操作只增加一次</option>"+
							"<option value='-2'>当天操作增加积分</option>"+
						"</select> 操作次数：<input type='text' name='newcreditrule["+branchindex+"][maxaction]' size='3' maxlength=4 onkeyup='value=value.replace(/[^\\d]/g,\"\") ' onbeforepaste='clipboardData.setData(\"text\",clipboardData.getData(\"text\").replace(/[^\\d]/g,\"\"))' >"+
						" 操作描述：<input type='text' name='newcreditrule["+branchindex+"][description]' size='60' >"+
					"</div>");
			branchindex++;
		}
		function del_input(opid) {
			document.getElementById(opid).innerHTML='';		
		}
	</script>
<?php $this->display('admin/footer');?>