<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>服务期管理 - 服务期列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/spterm');?>">浏览</a></td>
            <td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/spterm/add.html','添加服务期')" class="add">添加服务期</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>

 <label for="catid">所属平台</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />
		<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />

		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
	</td>
</tr>
</table>




<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="8%" >服务期名称</th>
<th width="20%" >所属平台</th>
<th >创建日期</th>
<th>排序</th>
<th width="5%">状态</th>
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




	<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savesort()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-sort').dialog('close')">取消</a>
    </div>
	
	
	<div id="dlg-sort" class="easyui-dialog" style="width:900px;height:660px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle" id="ftitle">添加分类</div>
        <form id="form_sort" method="post">
            <div class="fitem">
                <label>服务包名：</label>
                <input name="pname" class="easyui-validatebox" readonly>
				<input type="hidden" name="pid"/>
            </div>
            <div class="fitem">
                <label>分类名：</label>
				<select id="slist" style="display:none" onchange="fillSortform()" name="sid">
				</select>
                <input name="sname" id="sname" class="easyui-validatebox" required="true" type="text">
            </div>
			<div class="fitem">
                <label>排序：</label>
                <input name="tdisplayorder" id="tdisplayorder" type="text">
            </div>
            <div class="fitem">
                <label>富文本：</label>
				<div style="margin-left:80px">
				</div>
            </div>
			
        </form>
    </div>
	<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
</body>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.uid+'" /></td>');
        row.push('<td class=username><a href="/admin/servicepack.html?tid='+v.tid+'"><span style=\'color:red\'>'+v.tname+'</span></a></td>');
        row.push('<td class="realname">'+(v.crname||'')+'</td>');
		
		
        row.push('<td class="i.dateline">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="i.dateline">'+v.tdisplayorder+'</td>');
		row.push('<td >'+(v.status==0?'不显示':'显示')+'</td>');
        if(v.status == 0){
			row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/spterm/view.html?tid='+v.tid+'\',\'服务期\')">详情</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/spterm/edit.html?tid='+v.tid+'\',\'编辑服务期\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delterm('+v.tid+')" >删除</a>]&nbsp;&nbsp;[<a href="#" onclick="showaddin(\'/admin/servicepack/add.html?tid='+v.tid+'\',\'添加服务包\')">添加服务包</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.tid+',1)">解锁</a>]&nbsp;&nbsp;</td>');
		}else{
			row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/spterm/view.html?tid='+v.tid+'\',\'服务期\')">详情</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/spterm/edit.html?tid='+v.tid+'\',\'编辑服务期\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delterm('+v.tid+')" >删除</a>]&nbsp;&nbsp;[<a href="#" onclick="showaddin(\'/admin/servicepack/add.html?tid='+v.tid+'\',\'添加服务包\')">添加服务包</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.tid+',0)">锁定</a>]&nbsp;&nbsp;</td>');
		}
        row.push('</tr>');
        return row.join('');
    }
$(function(){
    $(".pagination-page-list").trigger('change');
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	var s_crid = $('#mediaid').val();
	$('#addbtn').attr('onclick',"showaddin('/admin/spterm/add.html?crid="+s_crid+"','添加服务期')");
	return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
		var crid = $('#mediaid').val();
        $.post("/admin/spterm/getListAjax.html",
            {query:query,crid:crid,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});

function delterm(tid){
    if (tid){
        $.messager.confirm('确认','确定要删除该服务包期么？',function(r){
            if (r){
                $.post('/admin/spterm/del.html',{tid:tid},function(result){
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

function showaddsort(pid,pname){
	UM.getEditor("content").setContent('');
	$('#slist').hide();
	$('#ftitle').text('添加分类');
	$('#dlg-sort').dialog('open').dialog('setTitle','分类');
	$('#form_sort').form('clear');
	$('#form_sort').form('load',{pid:pid,pname:pname,sdisplayorder:0});
	
}
function showsorts(pid,pname){
	showaddsort(pid,pname);
	$('#ftitle').text('管理分类');
	$('#slist').show();
	getsorts(pid);
}
function getsorts(pid){
	$.ajax({
		type:"post",
		url:"/admin/spsort/getListAjax.html",
		data:{pid:pid},
		success:function(data){
			data = JSON.parse(data);
			data.shift();
			$('#slist option').remove();
			$('#slist').append('<option value="0"></option>');
			$.each(data,function(i,sort){
				$('#slist').append('<option value="'+sort.sid+'" sdisplayorder="'+sort.sdisplayorder+'">'+sort.sname+'</option>');
			})
		}
	});
}


function savesort(){
	var url = '/admin/spsort/add.html';
	var savetype = '添加';
	var sortdata = $('#form_sort').serialize();
	if($('#sname').val()==''){
		alert('请填写分类名称');
		return ;
	}
	if($('#slist').css('display')!='none'){
		if($('#slist').val()=='0'){
			alert('请先选择要编辑的分类');
			return ;
		}
		url = '/admin/spsort/edit.html';
		savetype = '编辑';
	}
	$.ajax({
		type:"post",
		url:url,
		data:{sortdata:sortdata},
		success:function(data){
			if(data=="1"){
				showmessage(savetype+'分类成功','成功');
				$('#dlg-sort').dialog('close');
			}else{
				showmessage(savetype+'分类失败','失败');
			}
		}
	});
}
function showmessage(msg,title){
            $.messager.show({
                title:title,
                msg:msg,
				timeout:1500,
                showType:'show',
				style:{
                    left:'',
                    right:0,
                    top:document.body.scrollTop+document.documentElement.scrollTop,
                    bottom:''
                }
            });
    }
function fillSortform(){
	$('#form_sort').form('validate');
	var option = $('#slist option:selected');
	var sid = option.val();
	var sname = option.text();
	var sdisplayorder = option.attr('sdisplayorder');
	$.ajax({
		type:"post",
		url:"/admin/spsort/getDetail.html",
		data:{sid:sid},
		success:function(data){
			if(data!="null"){
				sdata = JSON.parse(data);
				$('#sname').val(sname);
				$('#sdisplayorder').val(sdisplayorder);
				UM.getEditor("content").setContent(sdata.content);
			}else{
				$('#sname').val('');
				$('#sdisplayorder').val(0);
				UM.getEditor("content").setContent('');
			}
		}
	});
}
$('#drop').click(function(){
       showcr();  
    });
function delsort(sid){
	if (sid){
        $.messager.confirm('确认','确定要删除该分类么？',function(r){
            if (r){
                $.post('/admin/spsort/del.html',{sid:sid},function(result){
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
	function showcr(){
        var url = '/admin/classroom/roomselect.html';
        var width = $(window).width();
        var height = $(window).height();
        $('#cr')
        .attr('width',width/5*3)
        .attr('height',height/5*3)
        .attr('src',url);
        $('#crwrap').show();
        $('#crwrap').dialog({    
            title: '请选择教室', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        return false;
    }
	$('#clear').click(function(){
        $('#mediaid').val("");
        $('#crname').val("");
		_search();
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    } 
	
function changestatus(tid,status){
    if (tid){
        $.post('<?php echo geturl('admin/spterm/changestatus');?>',
            {tid:tid,status:status},
            function(result){
                    if (result==1){
                    
                       $('.pagination-page-list').trigger('change');
                    } else {
                        $.messager.show({    // show error message
                            title: 'Error',
                            msg: result
                        });
                    }
            });
    }
    return false;
}
function showaddin(url,title){
    // var width = $(window).width();
    // var height = $(window).height();
    // $('#cr')
    // .attr('width',800)
    // .attr('height',400)
    // .attr('src',url);
    // $('#crwrap').show();
    // $('#crwrap').dialog({    
        // title: title, 
        // closed: false,    
        // cache: false,   
        // modal: true   
    // });
	height = 500;
	width = 800;
	var html = '<iframe scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	artDialog({
		id : 'adialog',
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
<style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
    </style>


<?php
$this->display('admin/footer');
?>