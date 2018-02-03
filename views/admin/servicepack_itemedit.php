<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/spitem/edit.html" onsubmit="return $(this).form('validate')" id="itemform">
<input type="hidden" name="itemid" value="<?=$itemdetail['itemid']?>"/>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>服务项名称<em>*</em><p>服务项的名称。</p></th>
    <td><input name="iname" id="iname" class="easyui-validatebox w300" required="true" missingMessage="请输入服务项名称" value="<?=$itemdetail['iname']?>"/></td>
</tr>
<tr>
    <th>所属服务包<em>*</em><p>请选择服务项所属服务包。</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" value="<?=$itemdetail['pname']?>" id="pname" name="pname">
	<input type="button" id="selsp" value="选择" onclick="selectsp($('#mediaid').val())"/>
	<input type="button" id="clearsp" value="清除" />
	<input type="hidden" name="pcrid" id="crid"  value="<?=$itemdetail['pcrid']?>" />
	<input type="hidden" name="pid" id="pid"  value="<?=$itemdetail['pid']?>" />
	</td>
</tr>

<tr>
	<th>所属学校<p>请选择服务项所属学校,不选则与服务包相同</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" value="<?=$itemdetail['crname']?>" id="crname" name="crname">
	<input type="button" id="selcr" value="选择" onclick="selectcr()"/>
	<input type="button" id="clearcr" value="清除" />
	<input type="hidden" name="crid" id="mediaid"  value="<?=$itemdetail['crid']?>" />
	</td>
</tr>

<tr>
	<th>来源网校<p>请选择课程内容来源网校</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" value="<?=!empty($itemdetail['providercrname'])?$itemdetail['providercrname']:''?>" id="providercrname" name="providercrname">
	<input type="button" id="selscr" value="选择" onclick="selectpcr()"/>
	<input type="button" id="clearpcr" value="清除" />
	<input type="hidden" name="providercrid" id="providercrid"  value="<?=!empty($itemdetail['providercrid'])?$itemdetail['providercrid']:0?>" />
	</td>
</tr>

<tr>
	<th>所属课程</th>
	<td>
	<select id="flist" name="folderid" onchange="fillForm()">
		
	</select>
	</td>
</tr>

<tr>
	<th>所属分类</th>
	<td>
	<select id="slist" name="sid">
		
	</select>
	</td>
</tr>
	<tr>
		<th>展示模式</th>
		<td>
			<select name="view_mode">
				<option value="0"<?php if ($itemdetail['view_mode'] == 0) { echo ' selected="selected"'; } ?>>纯图</option>
				<option value="1"<?php if ($itemdetail['view_mode'] == 1) { echo ' selected="selected"'; } ?>>图文(小)</option>
				<option value="2"<?php if ($itemdetail['view_mode'] == 2) { echo ' selected="selected"'; } ?>>图文(大)</option>
			</select>
		</td>
	</tr>
	<th>课程排序</th>
	<td><input type="text" name="fdisplayorder" value="<?=!empty($itemdetail['fdisplayorder']) ? $itemdetail['fdisplayorder'] : 0 ?>" /></td>
<tr>
    <th>价格</th>
    <td><input type="text" class="easyui-validatebox w300" maxlength="50" name="iprice" id="iprice" required="true" onkeyup="value=value.replace(/[^\d.]/g,'')" value="<?=$itemdetail['iprice']?>" validType="pricesum"></td>
</tr>

<tr>
    <th>分成价格</th>
    <td>
	公司
	<input type="text" class="easyui-validatebox w100 " maxlength="50" name="comfee" onkeyup="value=value.replace(/[^\d.]/g,'')" id="comfee" value="<?=empty($itemdetail['comfee'])?'':$itemdetail['comfee']?>">
	网校方
	<input type="text" class="easyui-validatebox w100 " maxlength="50" name="roomfee" onkeyup="value=value.replace(/[^\d.]/g,'')" id="roomfee" value="<?=empty($itemdetail['roomfee'])?'':$itemdetail['roomfee']?>">
	内容来源方
	<input type="text" class="easyui-validatebox w100 " maxlength="50" name="providerfee" onkeyup="value=value.replace(/[^\d.]/g,'')" id="providerfee" value="<?=empty($itemdetail['providerfee'])?'':$itemdetail['providerfee']?>">
	</td>
</tr>
<tr>
    <th>附加权限<p>课程查看:能看课件列表 课件查看:能播放课件 作业查看:课程 课件 作业都能看能做，但是答案解析需要收费 </p></th>
    <td>
		<label><input type="radio" name="ptype" value="0" <?= $itemdetail['ptype'] == 0 ? 'checked':''?> >默认</label>
        <label><input type="radio" name="ptype" value="1" <?= $itemdetail['ptype'] == 1 ? 'checked':''?> >课程查看</label>
		<label><input type="radio" name="ptype" value="2" <?= $itemdetail['ptype'] == 2 ? 'checked':''?> >课件查看</label>
		<label><input type="radio" name="ptype" value="3" <?= $itemdetail['ptype'] == 3 ? 'checked':''?> >做作业</label>
	</td>
</tr>
<tr>
	<th>是否有优惠</th>
	<td>
		<input type="checkbox" id="isyouhui" name="isyouhui" value="1" <?=empty($itemdetail['isyouhui'])?'':'checked="checked"'?>>
	</td>
</tr>

<tr>
    <th>优惠价格<p>优惠后用户需支付价格</p></th>
    <td><input type="text" class="easyui-validatebox w300" maxlength="50" name="iprice_yh" id="iprice_yh" onkeyup="value=value.replace(/[^\d.]/g,'')" value="<?=empty($itemdetail['iprice_yh'])?'':$itemdetail['iprice_yh']?>" ></td>
</tr>

<tr>
    <th>优惠后分成价格<p>优惠后分成总额=总价格-(总价格-优惠价)*2</p></th>
    <td>
	分成总额 <span id="feeafter">【<?=empty($itemdetail['isyouhui'])?0:($itemdetail['iprice_yh']*2-$itemdetail['iprice'])?>】</span><br/><br/>
	公司
	<input type="text" class="easyui-validatebox w100 setcount" maxlength="50" name="comfee_yh" onkeyup="value=value.replace(/[^\d.]/g,'')" id="comfee_yh" value="<?=empty($itemdetail['comfee_yh'])?'':$itemdetail['comfee_yh']?>">
	网校方
	<input type="text" class="easyui-validatebox w100 setcount" maxlength="50" name="roomfee_yh" onkeyup="value=value.replace(/[^\d.]/g,'')" id="roomfee_yh" value="<?=empty($itemdetail['roomfee_yh'])?'':$itemdetail['roomfee_yh']?>">
	内容来源方
	<input type="text" class="easyui-validatebox w100 setcount" maxlength="50" name="providerfee_yh" onkeyup="value=value.replace(/[^\d.]/g,'')" id="providerfee_yh" value="<?=empty($itemdetail['providerfee_yh'])?'':$itemdetail['providerfee_yh']?>">
	</td>
</tr>


<tr>
    <th>服务项时长</th>
    <td>
		<?php 
		$a = 1;
		$feetype = array('imonth','iday');
		if(!empty($itemdetail['imonth']))
			$a = 0;
		$checkedstr[$a] = 'checked="checked"';
		$checkedstr[!$a] = '';
		$valuestr[$a] = 'value="'.$itemdetail[$feetype[$a]].'"';
		$valuestr[!$a] = '';
		$requiredstr[$a] = 'class="easyui-validatebox" required="true"';
		$requiredstr[!$a] = '';
		
		?>
        <label><input type="radio" name="bywhich" <?=$checkedstr[0]?> value="0" onclick="changedm(this.value)">按月：</label><input id="bym_input" type="text" style="width:50px" name="imonth" <?=$valuestr[0]?> <?=$requiredstr[0]?>/> 个月
        <label><input type="radio" name="bywhich" <?=$checkedstr[1]?> value="1" onclick="changedm(this.value)">按日：</label><input id="byd_input" type="text" style="width:50px" readonly="readonly" name="iday" <?=$valuestr[1]?> <?=$requiredstr[1]?>/> 日
    </td>
</tr>
	<tr>
		<th><label for="isschoolfree">对全校学员免费</label></th>
		<td><input type="checkbox" id="isschoolfree" name="isschoolfree" value="1" <?=empty($itemdetail['isschoolfree'])?'': 'checked="checked"'?> /></td>
	</tr>
<tr>
	<th>不能报名</th>
	<td>
		<input type="checkbox" name="cannotpay" value="1" <?=empty($itemdetail['cannotpay'])?'':'checked="checked"'?>>
	</td>
</tr>

<tr>
    <th>摘要</th>
    <td><textarea cols="55" rows="3" name="isummary" id="isummary"><?=$itemdetail['isummary']?></textarea></td>
</tr>
<tr>
	<th>大图片<p>按长条显示时的大图片,建议大小230*159</p></th>
	<td><?php $Upcontrol = Ebh::app()->lib('UpcontrolLib');
	$Upcontrol->upcontrol('longblockimg',1,array('upfilepath'=>$itemdetail['longblockimg']),'pic');?></td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">

</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
	
    $(function(){
   		$('.setcount').blur(function(){
   			if (isyouhui()) {
   				$('#iprice_yh').validatebox({    
			    	required: true,
			    	validType:'pricesum_hy' 
				}); 
   			}	
   		});
		showfolder(<?=empty($itemdetail['providercrid'])?$itemdetail['crid']:$itemdetail['providercrid']?>,<?=$itemdetail['folderid']?>);
		showsort(<?=$itemdetail['pid']?>,<?=$itemdetail['sid']?>);
		<?php if(!empty($itemdetail['providercrid'])){?>
		$('#comfee,#roomfee,#providerfee').validatebox({    
			required: true,
			validType:'needfee',
			missingMessage:'选择了来源网校,必须填写此项'
		});
		<?php }?>
		validate_yh();
    });
	function changedm(type){
		if(type==0){
			$('#byd_input').attr('readonly','readonly');
			$('#bym_input').removeAttr('readonly');
			$('#byd_input').val('');
			$('#bym_input').validatebox({
				required:true,
				validType: 'text'
			});
			$('#byd_input').validatebox({
				required:false,
				validType: 'text'
			});
		}else if(type==1){
			$('#byd_input').removeAttr('readonly');
			$('#bym_input').attr('readonly','readonly');
			$('#bym_input').val('');
			$('#bym_input').validatebox({
				required:false,
				validType: 'text'
			});
			$('#byd_input').validatebox({
				required:true,
				validType: 'text'
			});
		}
	}
	
	$('#clearsp').click(function(){
		$('#pid').val("");
		$('#pname').val("");
		$('#crid').val("");
	});
	$('#clearcr').click(function(){
		// $('#mediaid').val("");
		$('#crname').val("");
		$('#flist option').remove('');
	});
	
	$('#clearpcr').click(function(){
		$('#providercrid').val("");
		$('#providercrname').val("");
		$('#flist option').remove('');
		showfolder($('#mediaid').val());
		$('#comfee,#roomfee,#providerfee').validatebox({    
			required: false 
		}); 
		$('#comfee,#roomfee,#providerfee').val('');
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
						$('#flist').append('<option value="'+item.folderid+'" fsummary="'+item.summary+'" selected="selected">'+item.foldername+'</option>');
					else
						$('#flist').append('<option value="'+item.folderid+'" fsummary="'+item.summary+'">'+item.foldername+'</option>');
				})
			}
		});
	}
	function showsort(pid,sid){
		$.ajax({
			type:'post',
			url:'/admin/spsort/getListAjax.html',
			data:{pid:pid},
			success:function(data){
				var sortlist = eval('('+data+')');
				sortlist.shift();
				$('#slist option').remove('');
				$('#slist').append('<option value="0">不选</option>');
				$.each(sortlist,function(i,item){
					if(item.sid==sid)
						$('#slist').append('<option value="'+item.sid+'" selected="selected">'+item.sname+'</option>');
					else
						$('#slist').append('<option value="'+item.sid+'">'+item.sname+'</option>');
				})
			}
		});
	}
	$('#pname').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'请选择所属服务包'
	});
	$('#flist').validatebox({    
        required: true,
        validType:'needfolder' 
    });  

	$.extend($.fn.validatebox.defaults.rules, { 
		needfolder:{
			validator:function(value){
				if(value==0){
					$.fn.validatebox.defaults.rules.needfolder.message = '请选择课程';
					return false;
				}
				return true;
				
			}
		},
		pricesum:{
			validator:function(value){
				var comfee = parseFloat($('#comfee').val());
				var roomfee = parseFloat($('#roomfee').val());
				var providerfee = parseFloat($('#providerfee').val());
				var iprice = parseFloat($('#iprice').val());
				if((comfee+roomfee+providerfee).toFixed(2) != iprice.toFixed(2)){
					$.fn.validatebox.defaults.rules.pricesum.message = '三方分成总和与总价格不符';
					return false;
				}
				return true;
			}
		},
		pricesum_hy:{
			validator:function(value){
				if($('#iprice_yh').val() < $('#iprice').val()/2){
					$.fn.validatebox.defaults.rules.pricesum_hy.message = '优惠价格不得少于原始价格的一半';
					return false;
				}
				var comfee_yh = parseFloat($('#comfee_yh').val());
				var roomfee_yh = parseFloat($('#roomfee_yh').val());
				var providerfee_yh = parseFloat($('#providerfee_yh').val());
				var after_yh = parseFloat(Subtr($('#iprice_yh').val()*2,$('#iprice').val()));
				if((comfee_yh+roomfee_yh+providerfee_yh).toFixed(2) != after_yh.toFixed(2)){
					$.fn.validatebox.defaults.rules.pricesum_hy.message = '优惠后三方分成总和与总价格不符';
					return false;
				}
				return true;
			}
		}
	}); 
	function fillForm(){
		var option = $('#flist option:selected');
		var fname = option.text();
		var fsummary = option.attr('fsummary');
		// if($.trim($('#iname').val())==''){
			$('#iname').val(fname);
		// }
		if(fname=="不选")
			$('#iname').val('');
		if(fsummary=='' || fsummary=='null')
			fsummary = fname;
		$('#isummary').val(fsummary);		
		$('#itemform').form('validate');
	}
	
	function selectpcr(){
		$('#dialog').dialog({    
	    title: '选择来源网校',    
	    width:700,
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/common/classroom_search_provider.html',    
	    modal: true   
		});   
	}
	
	$('#isyouhui').click(function(){
		validate_yh();
	});
	
	function validate_yh(){
		if(isyouhui()){
			$('#iprice_yh').validatebox({
				required:true,
				validType: 'pricesum_hy'
			});
		}else{
			$('#iprice_yh').validatebox({
				required:false,
				validType: 'text'
			});
		}
	
	}
	function isyouhui(){
		return $('#isyouhui').prop('checked');
	}
	$('#iprice_yh,#iprice').blur(function(){
		if(isyouhui()){
			$('#feeafter').html(Subtr($('#iprice_yh').val()*2,$('#iprice').val()));
		}
	});
	
//除法
function accDiv(arg1, arg2) {
	var t1 = 0,
	    t2 = 0,
	    r1, r2;
	try {
	    t1 = arg1.toString().split(".")[1].length
	} catch (e) {}
	try {
	    t2 = arg2.toString().split(".")[1].length
	} catch (e) {}
	with(Math) {
	    r1 = Number(arg1.toString().replace(".", ""))
	    r2 = Number(arg2.toString().replace(".", ""))
	    return accMul((r1 / r2), pow(10, t2 - t1));
	}
}
	
//乘法 
function accMul(arg1, arg2) {
	var m = 0,
	    s1 = arg1.toString(),
	    s2 = arg2.toString();
	try {
	    m += s1.split(".")[1].length
	} catch (e) {}
	try {
	    m += s2.split(".")[1].length
	} catch (e) {}
	return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m)
}
	
//加法 
function accAdd(arg1, arg2) {
	var r1, r2, m;
	try {
	    r1 = arg1.toString().split(".")[1].length
	} catch (e) {
	    r1 = 0
	}
	try {
	    r2 = arg2.toString().split(".")[1].length
	} catch (e) {
	    r2 = 0
	}
	m = Math.pow(10, Math.max(r1, r2))
	return (arg1 * m + arg2 * m) / m
}
	
//减法 
function Subtr(arg1, arg2) {
    var r1, r2, m, n;
    try {
		r1 = arg1.toString().split(".")[1].length
    } catch (e) {
		r1 = 0
    }
    try {
		r2 = arg2.toString().split(".")[1].length
    } catch (e) {
		r2 = 0
    }
    m = Math.pow(10, Math.max(r1, r2));
    n = (r1 >= r2) ? r1 : r2;
    return ((arg1 * m - arg2 * m) / m).toFixed(n);
}	
</script>
<?php
$this->display('admin/footer');
?>