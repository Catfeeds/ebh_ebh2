<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/jingpin/edit.html" onsubmit="return $(this).form('validate')" id="itemform">
<input type="hidden" name="itemid" value="<?=$itemdetail['itemid']?>"/>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>精品课堂名称<em>*</em><p>精品课堂的名称。</p></th>
    <td><input name="iname" id="iname" class="easyui-validatebox w300" required missingMessage="请输入服务项名称" value="<?=$itemdetail['iname']?>"/></td>
</tr>

<tr>
	<th>来源网校<p>请选择课程内容来源网校</p></th>
    <td>
	<input type="text" class="w300" readonly value="<?=!empty($itemdetail['providercrname'])?$itemdetail['providercrname']:''?>" id="providercrname" name="providercrname">
	<input type="button" id="selscr" value="选择" onClick="selectpcr()"/>
	<input type="button" id="clearpcr" value="清除" />
	<input type="hidden" name="providercrid" id="providercrid"  value="<?=!empty($itemdetail['providercrid'])?$itemdetail['providercrid']:0?>" />
	</td>
</tr>

<tr>
	<th>所属课程</th>
	<td>
	<select id="flist" name="folderid" onChange="fillForm()">
		
	</select>
	</td>
</tr>

<tr>
	<th>所属分类</th>
	<td>
		一级分类：
	<select id="slist" name="bsid" onChange="showsort(this.value,'#sidsecond')">
		<option value="<?=$itemdetail['bsid']?>"><?=$itemdetail['bsid']?></option>
	</select>
		 二级分类：
	<select id="sidsecond" name="msid" onChange="showsort(this.value,'#sidthird')" >
		<option value="<?=$itemdetail['msid']?>"><?=$itemdetail['msid']?></option>
	</select>
		三级分类：
	<select id="sidthird" name="ssid" onChange="showlabel(this.value)">
		<option value="<?=$itemdetail['ssid']?>"><?=$itemdetail['ssid']?></option>
	</select>
	<input type="button" value="修改分类" onClick="showsort(0);dohid();">
	<input type="button" value="重置分类" onClick="set()">
	</td>
</tr>
<tr>
	<th>所属标签</th>
	<td>
		<div id='showlabel'> </div>
	</td>
</tr>
<tr>
    <th>价格</th>
    <td><input type="text" class="easyui-validatebox w300" maxlength="50" name="iprice" id="iprice" required onKeyUp="value=value.replace(/[^\d.]/g,'')" value="<?=$itemdetail['iprice']?>" validType="pricesum"></td>
</tr>

<tr>
    <th>分成价格</th>
    <td>
	公司
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="comfee" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="comfee" value="<?=empty($itemdetail['comfee'])?'':$itemdetail['comfee']?>">
	网校方
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="roomfee" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="roomfee" value="<?=empty($itemdetail['roomfee'])?'':$itemdetail['roomfee']?>">
	内容来源方
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="providerfee" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="providerfee" value="<?=empty($itemdetail['providerfee'])?'':$itemdetail['providerfee']?>">
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
    <td><input type="text" class="easyui-validatebox w300" maxlength="50" name="iprice_yh" id="iprice_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" value="<?=empty($itemdetail['iprice_yh'])?'':$itemdetail['iprice_yh']?>" ></td>
</tr>

<tr>
    <th>优惠后分成价格<p>优惠后分成总额=总价格-(总价格-优惠价)*2</p></th>
    <td>
	分成总额 <span id="feeafter">【<?=empty($itemdetail['isyouhui'])?0:($itemdetail['iprice_yh']*2-$itemdetail['iprice'])?>】</span><br/><br/>
	公司
	<input type="text" class="easyui-validatebox w100 setcount" maxlength="50" name="comfee_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="comfee_yh" value="<?=empty($itemdetail['comfee_yh'])?'':$itemdetail['comfee_yh']?>">
	网校方
	<input type="text" class="easyui-validatebox w100 setcount" maxlength="50" name="roomfee_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="roomfee_yh" value="<?=empty($itemdetail['roomfee_yh'])?'':$itemdetail['roomfee_yh']?>">
	内容来源方
	<input type="text" class="easyui-validatebox w100 setcount" maxlength="50" name="providerfee_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="providerfee_yh" value="<?=empty($itemdetail['providerfee_yh'])?'':$itemdetail['providerfee_yh']?>">
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
        <label><input type="radio" name="bywhich" <?=$checkedstr[0]?> value="0" onClick="changedm(this.value)">按月：</label><input id="bym_input" type="text" style="width:50px" name="imonth" <?=$valuestr[0]?> <?=$requiredstr[0]?>/> 个月
        <label><input type="radio" name="bywhich" <?=$checkedstr[1]?> value="1" onClick="changedm(this.value)">按日：</label><input id="byd_input" type="text" style="width:50px" readonly name="iday" <?=$valuestr[1]?> <?=$requiredstr[1]?>/> 日
    </td>
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
	<th>大图片<p>按长条显示时的大图片,建议大小414*245</p></th>
	<td><?php $Upcontrol = Ebh::app()->lib('UpcontrolLib');
	$Upcontrol->upcontrol('longblockimg',1,array('upfilepath'=>$itemdetail['longblockimg']),'pic');?></td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置" onClick="set()">

</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
	if (!Array.indexOf) {
   		Array.prototype.indexOf = function(obj){
        for(var i=0; i<this.length; i++){
            if(this[i]==obj){
                return i;
            }
        }
        return -1;
   		}
	}
    $(function(){
    	$('.setcount').blur(function(){
   			if (isyouhui()) {
   				$('#iprice_yh').validatebox({    
			    	required: true,
			    	validType:'pricesum_hy' 
				}); 
   			}	
   		});
    	showlabel(<?=$itemdetail['ssid']?>);
    	showsortbysid(<?=$itemdetail['bsid']?>,'#slist');
    	showsortbysid(<?=$itemdetail['msid']?>,'#sidsecond');
    	showsortbysid(<?=$itemdetail['ssid']?>,'#sidthird');
		showfolder(<?=empty($itemdetail['providercrid'])?$itemdetail['providercrid']:$itemdetail['providercrid']?>,<?=$itemdetail['folderid']?>);
		<?php if(!empty($itemdetail['providercrid'])){?>
		$('#comfee,#roomfee,#providerfee').validatebox({    
			required: true,
			validType:'needfee',
			missingMessage:'选择了来源网校,必须填写此项'
		});
		<?php }?>
		validate_yh();
    });
     function showlabel(sid) {
    	$('#showlabel').html('');
    	$.ajax({
			type:'post',
			url:'/admin/bestlabel/getListAjax.html',
			data:{sid:sid},
			success:function(data){
				var folderlist = eval('('+data+')');
				$.each(folderlist,function(i,item){
					var ids = '<?=$itemdetail['labelids']?>'.split(",");
					if(ids.indexOf(item.id) != -1) {
						$('#showlabel').append('<input value="'+item.id+'" onClick="dellabelname('+ '\'' + item.label + '\','+ item.id +')" name="label[]" type="checkbox" checked="true">'+item.label+'</input>');
					}	else {
						$('#showlabel').append('<input value="'+item.id+'" onClick="addlabelname('+ '\'' + item.label + '\','+ item.id +')" name="label[]" type="checkbox" >'+item.label+'</input>');
					}
				})
			}
		});
    }

    function dohid() {
    	$('#sidsecond option').remove('');
    	$('#sidthird option').remove('');
    }

     function addlabelname(label, id){
    	var idname = '#name' + id;
    	var name = $(idname);
    	if (name.val() == undefined) {
    		$('#showlabel').append('<input id="name'+ id +'" type="hidden" value="'+ label +'" name="labelname[]" type="checkbox">');
    	} else {
    		$(idname).remove();
    	}
    }

    function dellabelname(label, id) {
    	var idname = '#name' + id;
    	var name = $(idname);
		if (name.val() == undefined) {
    		$('#showlabel').append('<input id="name'+ id +'" type="hidden" value="'+ label +'" name="dellabelname[]" type="checkbox">');
    	} else {
    		$(idname).remove();
    	}
   
    }

    function set(){
    	showsortbysid(<?=$itemdetail['bsid']?>,'#slist');
    	showsortbysid(<?=$itemdetail['msid']?>,'#sidsecond');
    	showsortbysid(<?=$itemdetail['ssid']?>,'#sidthird');
    }
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
	function showsortbysid(sid,idname){
		$.ajax({
			type:'post',
			url:'/admin/bestsort/getsortbysid.html',
			data:{sid:sid},
			success:function(data){
				var item = eval('('+data+')');
				//sortlist.shift();
				$(idname + ' option').remove('');
				
				$(idname).append('<option value="'+item.sid+'">'+item.sname+'</option>');
			
			}
		});
	}
	function showfolder(crid,folderid){
		$.ajax({
			type:'post',
			url:'/admin/jingpin/getroomfolders.html',
			data:{crid:crid,ifshowself:folderid},
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
	function showsort(psid,idname){
		if (idname == undefined) {
			var idname = '#slist';
		}
		$.ajax({
			type:'post',
			url:'/admin/bestsort/getListAjax.html',
			data:{psid:psid},
			success:function(data){
				var sortlist = eval('('+data+')');
				//sortlist.shift();
				$(idname + ' option').remove('');
				$(idname).append('<option value="-1">请选择分类</option>');
				$.each(sortlist,function(i,item){
					$(idname).append('<option value="'+item.sid+'">'+item.sname+'</option>');
				})
			}
		});
	}
	$('#flist').validatebox({    
        required: true,
        validType:'needfolder' 
    });  
	$('#sidthird').validatebox({    
        required: true,
        validType:'sidthird' 
    });
    $('#slist').validatebox({    
        required: true,
        validType:'sidthird' 
    });
    $('#sidsecond').validatebox({    
        required: true,
        validType:'sidthird' 
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
		sidthird:{
			validator:function(value){
				if(value==-1){
					$.fn.validatebox.defaults.rules.sidthird.message = '请选择分类';
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
				var after_yh = parseFloat($('#iprice_yh').val()*2-$('#iprice').val());
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
			$('#feeafter').html($('#iprice_yh').val()*2-$('#iprice').val());
		}
	});
</script>
<?php
$this->display('admin/footer');
?>