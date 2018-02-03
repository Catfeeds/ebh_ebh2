<?php
$this->display('admin/header');
?>
<body id="main">
<form method="post" action="/admin/schsource/add.html" onsubmit="return $(this).form('validate')" id="itemform">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">

<tr>
	<th>所属网校<p>请选择服务项所属网校</p></th>
	<td>
	<input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
	<input type="button" id="selcr" value="选择" onclick="selectcr(7)"/>
	<input type="button" id="clearcr" value="清除" />
	<input type="hidden" name="crid" id="mediaid"  value="" />
	</td>
</tr>

<tr>
	<th>来源网校<p>请选择课程内容来源网校</p></th>
	<td>
	<input type="text" class="w300" readonly="readonly" value="" id="providercrname" name="providercrname">
	<input type="button" id="selscr" value="选择" onclick="selectpcr(7)"/>
	<input type="button" id="clearpcr" value="清除" />
	<input type="hidden" name="sourcecrid" id="providercrid"  value="" />
	</td>
</tr>

<tr>
	<th>别名<p>别名</p></th>
	<td>
	<input type="text" class="w300" value="" id="name" name="name">
	</td>
</tr>

<tr>
	<th>分成比例</th>
	<td>
	公司<input type="text" class="w300" style="width:50px;" value=""  name="compercent" id="compercent"><span style="margin-right:50px;">%</span>
	所属网校<input type="text" class="w300" style="width:50px;" value=""  name="roompercent" id="roompercent"><span style="margin-right:50px;">%</span>
	来源网校<input type="text" class="w300" style="width:50px;" value=""  name="providerpercent" id="providerpercent"><span style="margin-right:50px;">%</span>
	</td>
</tr>
</table>

<div>
<select id="searchpid" name="pid" onchange="filterdata()"><option value="0">选择主类</option></select>
<select id="searchsid" name="sid" onchange="filterdata()"><option value="0">选择子类</option></select>
<input type="text" class="w200" value="" id="searchc" name="q">
<input type="button" id="searchbtn" onclick="filterdata()" value="搜索" />
</div>

<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th width="18%" >主类</th>
<th width="18%" >子类</th>
<th width="24%" >课程名称</th>
<th width="8%" >价格(元)</th>
<th width="8%" >有效期(月)</th>
<th width="8%" >公司分成(%)</th>
<th width="8%" >所属网校分成(%)</th>
<th width="8%" >来源网校分成(%)</th>
</tr>
<tbody class="coursetbody">
</tbody>
</table>
</form>
<div class="buttons">
<input type="button" onclick="save()" value="提交保存" class="submit">

</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
	$(function(){
	});
	
	$('#clearsp').click(function(){
		$('#pid').val("");
		$('#pname').val("");
		$('#crid').val("");
	});
	$('#clearcr').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
	});
	$('#clearpcr').click(function(){
		$('#providercrid').val("");
		$('#providercrname').val("");
		$('#searchpid').html('<option value="0">选择主类</option>');
		$('#searchsid').html('<option value="0">选择子类</option>');
		$('.coursetbody').empty();
	});
	
	
	function selectpcr(){
		$('#dialog').dialog({
			title: '选择来源网校',
			width:700,
			height:450,
			closed: false,
			cache: false,
			href: '/admin/common/classroom_search_provider.html?isschool=7',
			modal: true
		});
	}
	function getsplist(){
		var crid = $('#providercrid').val();
		$.ajax({
			url:'/admin/servicepack/getListAjax.html',
			type:'POST',
			data:{'pageSize':10000,'crid':crid},
			async:false,
			success:function(data){
				$('#searchpid').html('');
				sparr = JSON.parse(data);
				sparr.shift();
				$('#searchpid').append('<option value="0">选择主类</option>');
				$.each(sparr,function(i,sp){
					$('#searchpid').append('<option value="'+sp.pid+'">'+sp.pname+'</option>');
				})
			}
		});
	}
	var sortarr = new Array(new Array());
	$('#searchpid').change(function(){
		var pid = $(this).val();
		if(sortarr[pid]){
			sortdata = sortarr[pid];
		} else {
			$.ajax({
				url:'/admin/spsort/getListAjax.html',
				type:'POST',
				data:{'pageSize':10000,'pid':pid},
				async:false,
				success:function(data){
					sortdata = JSON.parse(data);
					sortdata.shift();
					sortarr[pid] = sortdata;
				}
			});
		}
		
		$('#searchsid').html('');
		$('#searchsid').append('<option value="0">选择子类</option>');
		$.each(sortdata,function(i,s){
			$('#searchsid').append('<option value="'+s.sid+'">'+s.sname+'</option>');
		})
	})
	
	function itemsearch(){
		var crid = $('#providercrid').val();
		
		$.ajax({
			url:'/admin/schsource/getitemlist.html',
			type:'POST',
			data:{'pageSize':10000,'crid':crid},
			async:false,
			success:function(data){
				data = JSON.parse(data);
				data.shift();
				_crender(data);
			}
		});
		filterdata();
	}
	function _crender(_data){
		$(".coursetbody").html('');
		$.each($(_data),function(k,v){
			$(_crenderRow(k,v)).appendTo(".coursetbody");
		});
		var row = '<tr class=""><td colspan="8"><label><input class="selall" type="checkbox"/>全选<label></td></tr>';
		$(row).appendTo('.coursetbody');
	}
	function _crenderRow(k,v){
		var row = ['<tr class="tr_course" pid="'+v.pid+'" sid="'+v.sid+'" iname="'+v.iname+'" itemid="'+v.itemid+'" folderid="'+v.folderid+'">'];
		row.push('<td class=""><label><input class="available" type="checkbox"/>'+(v.pname)+'</label></span></td>');
		row.push('<td class="">'+(v.sname||'')+'</a></td>');
		row.push('<td class="">'+(v.iname)+'</td>');
		row.push('<td class=""><input class="input_price" type="text" style="width:50px;" value="'+parseInt(v.iprice)+'"/></td>');
		row.push('<td class=""><input class="input_month" type="text" style="width:50px;" value="'+parseInt(v.imonth)+'"/></td>');
		row.push('<td class=""><input class="input_compercent" type="text"  style="width:50px;" style="width:50px;" value="'+((typeof(v.compercent)=="undefined")?0:parseInt(v.compercent))+'"/></td>');
		row.push('<td class=""><input class="input_roompercent" type="text" style="width:50px;" value="'+((typeof(v.roompercent)=="undefined")?0:parseInt(v.roompercent))+'"/></td>');
		row.push('<td class=""><input class="input_providerpercent" type="text" style="width:50px;" value="'+((typeof(v.providerpercent)=="undefined")?0:parseInt(v.providerpercent))+'"/></td>');
		row.push('</tr>');
		return row.join('');
	}
	
	function filterdata(){
		var query = $('#searchc').val();
		var pid = $('#searchpid').val();
		var sid = $('#searchsid').val();
		$('.tr_course').hide();

		if(query == ''){
			sel_query = '';
		} else {
			sel_query = '[iname*='+query+']';
		}
		
		if(pid == 0){
			sel_pid = "";
		} else {
			sel_pid = '[pid='+pid+']';
		}
		
		if(sid == 0){
			sel_sid = "";
		} else {
			sel_sid = '[sid='+sid+']';
		}
	
		$('.tr_course'+sel_pid+sel_sid+sel_query+'').show();
		checkselall();
	}
	$('#crname,#providercrname,#name').validatebox({	
		required: true
	});
	$('#crname,#providercrname').validatebox({	
		required: true,
		validType:'samecr',
	});
	
	function p_callback(e,crname){
		$('#providercrname').focus();
		$('#providercrname').val(crname);
		$('#providercrid').val($(e).attr('id'));
		$('.panel-tool-close').trigger('click');
		if($('#mediaid').val()!=''){
			compare_cr();
		}
		getsplist();
		itemsearch();
	}
	function c_callback(e,crname){
		$('#crname').val(crname);
		$('#mediaid').val($(e).attr('id'));
		$('#crname').focus();
		$('.panel-tool-close').trigger('click');
		if($('#providercrid').val()!=''){
			compare_cr();
		}
	}
	function compare_cr(){
		var crid = $('#mediaid').val();
		var sourcecrid = $('#providercrid').val();
		if(crid == sourcecrid){
			alert('所属和来源网校不能相同');
		} else {
			$.ajax({
				url:'/admin/schsource/getListAjax.html',
				type:'POST',
				dataType:'json',
				async:false,
				data:{crid:crid,sourcecrid:sourcecrid},
				success:function(data){
					crinfo = data[1];
					if(crinfo){
						alert('已有数据，将跳转到编辑.');
						sourceid = crinfo.sourceid;
						window.parent.showaddin('/admin/schsource/edit.html?sourceid='+sourceid,'编辑','editdialog');
						window.parent.adddialog.close();
					}
				}
			})
		}
	}
	function save(){
		var compercent = parseInt($('#compercent').val());
		var roompercent = parseInt($('#roompercent').val());
		var providerpercent = parseInt($('#providerpercent').val());
		var percenttotal = compercent+roompercent+providerpercent;
		if((percenttotal != 100) && (percenttotal != 0)){
			alert("注意：总分成比例之和为0或100。");
			return false;
		}
		var selitem = $('.available:checked');
		$('.input_month').validatebox({
			required:false,
			validType:''
		})
		selitem.parents('.tr_course').find('.input_month').validatebox({
			required:true,
			validType:'notzero[$(this)]'
		})
		if(!$('#itemform').form('validate')){
			return false;
		}
		
		var itemlist = [];
		var isitemTrue = true;
		$.each(selitem,function(k,v){
			var p = $(this).parents('.tr_course');
			var item = new Object();
			item.itemid = p.attr('itemid');
			item.folderid = p.attr('folderid');
			item.price = p.find('.input_price').val();
			item.month = p.find('.input_month').val();
			item.compercent = p.find('.input_compercent').val();
			item.roompercent = p.find('.input_roompercent').val();
			item.providerpercent = p.find('.input_providerpercent').val();
			var itemtotal = parseInt(item.compercent)+parseInt(item.roompercent)+parseInt(item.providerpercent);
			if((itemtotal != 100) && (itemtotal != 0)){
				alert("注意：单分成比例之和为0或者100。");
				isitemTrue = false;
			}
			itemlist.push(item);
		});
		if(!isitemTrue){
			return false;
		}
		var crid = $('#mediaid').val();
		var sourcecrid = $('#providercrid').val();
		var name = $('#name').val();
		var compercent = $('#compercent').val();
		var roompercent = $('#roompercent').val();
		var providerpercent = $('#providerpercent').val();
		$.ajax({
			url:'/admin/schsource/add.html',
			type:'POST',
			dataType:'json',
			async:false,
			data:{crid:crid,name:name,sourcecrid:sourcecrid,itemlist:itemlist,compercent:compercent,roompercent:roompercent,providerpercent:providerpercent},
			success:function(data){
				if(data.code==1){
					alert(data.msg);
				} else if(data.code == 0){
					parent.$.messager.show({	
						timeout:1500,
						title: '成功',
						msg: '添加成功'
					});
					parent.$(".pagination-page-list").trigger('change');
					parent.adddialog.close();
				} else {
					alert('出错了');
				}
			}
		})
	}
	$.extend($.fn.validatebox.defaults.rules, {
		samecr: {
			validator: function(value){
				var crid = $('#mediaid').val();
				var sourcecrid = $('#providercrid').val();
				return !(crid==sourcecrid);
			},
			message:"所属和来源网校不能相同"
		},
		notzero: {
			validator: function(value,p){
				return !(value==0);
			},
			message:"不能为0"
		}
	});
	$(document).on('keyup','.input_month,.input_price,.input_compercent,.input_roompercent,.input_providerpercent',function(){
		$(this).val($(this).val().replace(/[^\d]/g,'').replace(/0*(\d+)/g,"$1"));
	});
	$(document).on('keyup','#compercent,#roompercent,#providerpercent',function(){
		$(this).val($(this).val().replace(/[^\d]/g,'').replace(/0*(\d+)/g,"$1"));
	});
	$(document).on('click','.selall',function(){
		$('.tr_course:visible .available').attr('checked',$(this).prop('checked'));
		$('.tr_course:visible .available').prop('checked',$(this).prop('checked'));
	}).on('click','.available',function(){
		checkselall();
	})
	function checkselall(){
		if($('.tr_course:visible .available').length == $('.tr_course:visible .available:checked').length ){
			$('.selall').attr('checked',true);
			$('.selall').prop('checked',true);
		} else {
			$('.selall').attr('checked',false);
			$('.selall').prop('checked',false);
		}
	}
</script>
<?php
$this->display('admin/footer');
?>