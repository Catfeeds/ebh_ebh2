<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
	<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>企业选课 - 企业选课列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="<?php echo geturl('admin/schsource');?>">浏览</a></td>
			<td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/schsource/add.html','新增选课','adddialog')" class="add">新增选课</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
	<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
	function _render(_data){
		$(".moduletbody").html('');
		$.each($(_data),function(k,v){
			$(_renderRow(k,v)).appendTo(".moduletbody");
		});
	}

	function _renderRow(k,v){
		var row = ['<tr class="tr_module_">'];
		row.push('<th class="sn">'+(k+1)+'</th>');
		row.push('<td class=>'+(v.crname)+'</span></td>');
		row.push('<td class="">'+(v.scrname)+'</a></td>');
		row.push('<td class="">'+(v.name)+'</td>');
		row.push('<td class="">'+(v.coursecount)+'</td>');
		row.push('<td class="">'+getformatdate(v.dateline)+'</td>');
	   
		row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/schsource/edit.html?sourceid='+v.sourceid+'\',\'编辑选课\',\'editdialog\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delsource('+v.sourceid+')" >删除</a>]</td>');
		
		row.push('</tr>');
		return row.join('');
	}
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th width="20%" >课程所属网校</th>
<th width="20%" >课程来源网校</th>
<th width="15%" >别名</th>
<th width="12%" >课程数</th>
<th >创建日期</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table>

<div id="pp"></div>

<br>
<div id="crwrap" style="display:none">
	<iframe id="cr" ></iframe>
</div>
</body>
<script type="text/javascript">



var s_pid = 0;
var s_crid = 0;
$(function(){
	parent.leftframe.$('a').removeClass();
	parent.leftframe.$('#schsource_a').addClass('current');
	
	$(".pagination-page-list").trigger('change');
	
	
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	
	return false;
}
$('#pp').pagination({
	pageSize:50,
	onSelectPage:function(pageNumber, pageSize){
		var query = $('#searchkey').val();
		
		$.post("/admin/schsource/getListAjax.html",
			{query:query,pageNumber:pageNumber,pageSize:pageSize},
			function(message){
				message = JSON.parse(message);
				$('#pp').pagination('refresh',message.shift());
				 _render(message);
				
			}
		);
		return false;
	}
});


function delsource(sourceid){
	if (sourceid){
		$.messager.confirm('确认','确定要删除吗？',function(r){
			if (r){
				$.post('/admin/schsource/del.html',{sourceid:sourceid},function(result){
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
							msg: result
						});
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

function showaddin(url,title,type){
	
	height = 666;
	width = 1000;
	var html = '<iframe scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	window[type] = artDialog({
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