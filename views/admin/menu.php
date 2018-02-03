<?php
$this->display('admin/header');
?>
<body id="main">

	<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:800px">菜单管理 - <?=$roominfo['crname']?> <?=$roominfo['crid']==0?'':'网校菜单'?></h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/menu/add.html?crid=<?=$roominfo['crid']?>','新增菜单')" class="add">新增菜单</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
	<table cellspacing="0" cellpadding="0" class="toptable">
	<tbody><tr><td>
		<label>关键字: <input type="text" name="q" id="searchkey" value="" size="20">
		<input type="submit" name="selectsubmit" onclick="return _search()" value="查询" class="submit">
		<?php if($roominfo['crid'] == 0){?>
		选择网校类型:
			<select id="roomtypesel" style="width:300px">
				<option value="0">教育版</option>
				<option value="1">企业版</option>
			</select>
		<?php }?>
	</td></tr></tbody>
	</table>
<script type="text/javascript">
	var numindex = 0;
	function _render(_data,prestr,resetindex){
		numindex = resetindex?0:numindex;
		prestr=prestr?prestr:'';
		$.each($(_data),function(k,v){
			$(_renderRow(k,v,prestr)).appendTo(".moduletbody");
			if(v.children){
				_render(v.children,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---- ',0);
			}
		});
	}
	function _renderRow(k,v,prestr){
		var trstyle = prestr==''?'style="background:#eee"':' ';
		var row = ['<tr class="tr_menu" '+trstyle+' mtitle="'+v.mtitle+'">'];
		row.push('<th class="sn">'+(++numindex)+'</th>');
		row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.mid+'" /></td>');
		row.push('<td class=username><span style=\'color:red\'>'+prestr+v.mtitle+'</span></td>');
		row.push('<td class="mobile"><span >'+v.url+'</span></td>');
		row.push('<td class="mobile"><input mid="'+v.mid+'" crid="<?=$roominfo['crid']?>" class="changestatus" type="checkbox" '+(v.status==1?'checked="checked"':'')+'></td>');
		row.push('<td class="nickname">'+getformatdate(v.dateline)+'</td>');
		row.push('<td class="nickname">'+v.mdisplayorder+'</td>');
		
		
		row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/menu/edit.html?mid='+v.mid+'&crid='+<?=$roominfo['crid']?>+'\',\'编辑菜单\')">编辑</a>]&nbsp;&nbsp;'+(v.crid==0?'':'[<a href="#" onclick="return delmenu('+v.mid+',<?=$roominfo['crid']?>)" >删除</a>]'));

		row.push('</td></tr>');
		return row.join('');
	}
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="20%" >菜单名称</th>
<th width="17%" >跳转地址</th>
<th width="10%" >是否显示</th>
<th width="10%" >修改时间</th>
<th width="6%" >排序号</th>

<th>操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input type="checkbox" name="chkall" id="chkall" >
<label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label
for="noop">不操作</label></th>
</tr>
<tr id="divnoop" style="display: none">
<td></td>
<td></td>
</tr>
</table>
<div id="pp"></div>
<div class="buttons"><input type="submit" name="listsubmit"
value="提交保存" class="submit"> <input type="reset"
name="listreset" value="重置"></div>
<br>
<div id="crwrap" style="display:none">
	<iframe id="cr" ></iframe>
</div>

</body>
<script type="text/javascript">


$(function(){
	$(".pagination-page-list").trigger('change');
});
$('#searchkey').keyup(function(){
	$('.tr_menu').show();
	var q = $.trim($('#searchkey').val());
	$.each($('.tr_menu'),function(k,v){
		var mtitle = $(this).attr('mtitle');
		if(mtitle.indexOf(q) == -1){
			$(this).hide();
		}
	});
});
$('#roomtypesel').change(function(){
	roomtype = $(this).val();
	$('.pagination-page-list').trigger('change');
});
$(document).on('click','.changestatus',function(){
	var status = $(this).prop('checked')?1:0;
	var crid = $(this).attr('crid');
	var mid = $(this).attr('mid');
	$.ajax({
		url:'/admin/menu/edit.html',
		data:{'status':status,'crid':crid,'mid':mid,'isajax':1,'statusonly':1},
		type:'post',
		dataType:'json',
		success:function(result){
			$.messager.show({	
				timeout:800,
				title: '成功',
				msg: '修改成功'
			});
			$('.pagination-page-list').trigger('change');
		}
	})
})

function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	return false;
}
var roomtype=0;
$('#pp').pagination({
	pageSize:50,
	onSelectPage:function(pageNumber, pageSize){
		$.post("/admin/menu/getListAjax.html",
			{pageNumber:pageNumber,pageSize:pageSize,crid:<?=$roominfo['crid']?>,roomtype:roomtype},
			function(message){
				message = JSON.parse(message);
				var count = new Object();
				count.total = message.menucount;
				$('#pp').pagination('refresh',count);
				$(".moduletbody").html('');
				_render(message.menulist,'',1);
				$('#searchkey').trigger('keyup');
			}
		);
		return false;
	}
});


function delmenu(mid,crid){
	if (mid && crid){
		$.messager.confirm('确认','确定要删除该菜单么？',function(r){
			if (r){
				$.post('/admin/menu/del.html',{mid:mid,crid:crid},function(result){
					if (result.success){
						$.messager.show({	
							timeout:800,
							title: '成功',
							msg: '删除成功'
						});
						$('.pagination-page-list').trigger('change');
					} else {
						$.messager.show({   
							title: 'Error',
							msg: '删除失败，可能有二级菜单未删除'
						});
						$('.pagination-page-list').trigger('change');
					}
				},'json');
			}
		});
	}
	return false;
}


$("#chkall").click(function(){
	$("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});

	var closedialog = function (){
		$("#crwrap").dialog('close');
	}
function showaddin(url,title){
	
	height = 550;
	width = 900;
	var html = '<iframe scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+(url+'&roomtype='+roomtype)+'"></iframe>';
	artDialog({
		title : title,
		width : width,
		height : height,
		content : html,
		padding : 10,
		resize : false,
		lock : true,
		opacity : 0.2,
		
	});
}
</script>
<?php
$this->display('admin/footer');
?>