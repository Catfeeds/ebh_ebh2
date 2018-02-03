<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/jingpin/add.html" onsubmit="return $(this).form('validate')" id="itemform">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>精品课堂名称<p>精品课堂的名称。</p></th>
    <td><input name="iname" id="iname" class="easyui-validatebox w300" required missingMessage="请输入精品课堂名称" /></td>
</tr>

<tr>
	<th>来源网校<p>请选择课程内容来源网校</p></th>
    <td>
	<input type="text" class="w300" readonly value="" id="providercrname" name="providercrname">
	<input type="button" id="selscr" value="选择" onClick="selectpcr()"/>
	<input type="button" id="clearpcr" value="清除" />
	<input type="hidden" name="providercrid" id="providercrid"  value="" />
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
	</select>
		 二级分类：
	<select id="sidsecond" name="msid" onChange="showsort(this.value,'#sidthird')">
	 <option value="-1">请选择分类</option>
	</select>
		三级分类：
	<select id="sidthird" name="ssid" onChange="showlabel(this.value)">
		<option value="-1">请选择分类</option>
	</select>
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
    <td><input type="text" class="easyui-validatebox w300" maxlength="50" name="iprice" id="iprice" required onKeyUp="value=value.replace(/[^\d.]/g,'')" validType="pricesum"></td>
</tr>

<tr>
    <th>分成价格</th>
    <td>
	公司
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="comfee" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="comfee">
	网校方
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="roomfee" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="roomfee">
	内容来源方
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="providerfee" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="providerfee">
	</td>
</tr>

<tr>
	<th>是否有优惠<p>优惠后用户需支付价格</p></th>
	<td>
		<input type="checkbox" id="isyouhui" name="isyouhui" value="1" >
	</td>
</tr>

<tr>
    <th>优惠价格</th>
    <td><input type="text" class="easyui-validatebox w300" maxlength="50" name="iprice_yh" id="iprice_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" value="" ></td>
</tr>

<tr>
    <th>优惠后分成价格<p>优惠后分成总额=总价格-(总价格-优惠价)*2</p></th>
    <td>
	分成总额 <span id="feeafter">【0】</span><br/><br/>
	公司
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="comfee_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="comfee_yh" >
	网校方
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="roomfee_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="roomfee_yh" >
	内容来源方
	<input type="text" class="easyui-validatebox w100" maxlength="50" name="providerfee_yh" onKeyUp="value=value.replace(/[^\d.]/g,'')" id="providerfee_yh" >
	</td>
</tr>


<tr>
    <th>精品课堂时长</th>
    <td>
        <label><input type="radio" name="bywhich" checked="checked" value="0" onClick="changedm(this.value)">按月：</label><input id="bym_input" type="text" style="width:50px" name="imonth" onKeyUp="value=value.replace(/[^\d]/g,'')" class="easyui-validatebox" required/> 个月
        <label><input type="radio" name="bywhich" value="1" onClick="changedm(this.value)">按日：</label><input id="byd_input" type="text" style="width:50px" readonly name="iday" onKeyUp="value=value.replace(/[^\d]/g,'')"/> 日
    </td>
</tr>


<tr>
    <th>摘要</th>
    <td><textarea cols="55" rows="3" name="isummary" id="isummary"></textarea></td>
</tr>
<tr>
	<th>大图片<p>按长条显示时的大图片,建议大小414*245</p></th>
	<td><?php $Upcontrol = Ebh::app()->lib('UpcontrolLib');
	$Upcontrol->upcontrol('longblockimg',1,array(),'pic');?></td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">

</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
var comfeepercent;
var roomfeepercent;
var providerfeepercent;

    $(function(){
		parent.$('.aui_titleBar .aui_title').html('添加精品课堂');
		showsort(0);	
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
					$('#showlabel').append('<input value="'+item.id+'" onClick="addlabelname('+ '\'' + item.label + '\','+ item.id +')" name="label[]" type="checkbox">'+item.label+'</input>');
				})
			}
		});
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
		if(!$('#providercrid').val())
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
	
	function showfolder(crid){
		
		$.ajax({
			type:'post',
			url:'/admin/jingpin/getroomfolders.html',
			data:{crid:crid},
			success:function(data){
				var folderlist = eval('('+data+')');
				$('#flist option').remove('');
				$('#flist').append('<option value="0">不选</option>');
				$.each(folderlist,function(i,item){
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
	$('#iprice').blur(function(){
		if($('#iprice').val()){
			var crid = $('#providercrid').val();
			if(comfeepercent == undefined && roomfeepercent == undefined && roomfeepercent == undefined && crid!=''){
				$.ajax({
					url:'/admin/common/getFeePercent.html',
					data:{'crid':crid},
					type:'post',
					async:false,
					success: function(data){
						var v = eval('('+data+')');
						comfeepercent = v.comfeepercent;
						roomfeepercent = v.roomfeepercent;
						providerfeepercent = v.providerfeepercent;
					}
				});
			}
			
			var price = $('#iprice').val();
			var providercrid = $('#providercrid').val();
			if(comfeepercent != undefined)
				$('#comfee').val(price*comfeepercent/100);
			
			if(providercrid){
				if(roomfeepercent != undefined)
					$('#roomfee').val(price*roomfeepercent/100);
				if(providerfeepercent != undefined)
					$('#providerfee').val(price*providerfeepercent/100);
			}else{
				$('#roomfee').val(price*(100-comfeepercent)/100);
				$('#providerfee').val(0);
			}
			
				
			$('#itemform').form('validate');
		}
	});
	
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