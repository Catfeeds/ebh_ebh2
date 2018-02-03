<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>收费课件管理 - 课件列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/cwpay');?>">浏览</a></td>
            
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
	
	<label >所属平台</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />
		按服务包搜索: <select id="searchpid" name="pid" ></select>
		按服务项搜索: <select id="searchitemid" name="itemid" onchange="_search();"></select>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.uid+'" /></td>');
		
		row.push('<td class="mobile"><span href="javascript:void(0)" style="color:red">'+v.title+'</span></td>');
        row.push('<td class=username><a href="javascript:showsp('+v.pid+','+v.itemid+')">'+(v.iname||'')+'</a></td>');
        row.push('<td class="realname"><a href="javascript:showsp('+v.pid+',0)">'+(v.pname||'')+'</a></td>');
		row.push('<td class="mobile">'+(v.crname||'')+'</td>');
        row.push('<td class="nickname">'+(v.cprice||'')+'</td>');
        
		
        row.push('<td class="i.dateline">'+((v.cmonth>0)?v.cmonth+'月':v.cday+'天')+'</td>');
		row.push('<td class="status">'+getformatdate(v.dateline)+'</td>');
       
        row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/cwpay/edit.html?cwid='+v.cwid+'\',\'编辑服务包\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delitem('+v.cwid+')" >删除</a>]</td>');
        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="10%" >课件名称</th>
<th width="10%" >所属服务项</th>
<th width="10%" >所属服务包</th>
<th width="12%" >所属学校</th>
<th width="5%" >价格</th>
<th >持续时间</th>
<th >创建日期</th>

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
<?php
$pid = $this->input->get('pid');
?>
var initpid = <?=empty($pid)?0:$pid?>;
var addurl = '/admin/spitem/add.html';
var s_pid = 0;
var s_crid = 0;
$(function(){
	parent.leftframe.$('a').removeClass();
	parent.leftframe.$('#cwpay_a').addClass('current');
	getsplist();
	
    $(".pagination-page-list").trigger('change');
	s_pid = $('#searchpid').val();
	s_crid = $('#mediaid').val();
	$('#addbtn').attr('onclick',"showaddin('/admin/spitem/add.html?crid="+s_crid+"&pid="+s_pid+"','添加服务项')");
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	s_pid = $('#searchpid').val();
	s_crid = $('#mediaid').val();
	
	$('#addbtn').attr('onclick',"showaddin('/admin/spitem/add.html?crid="+s_crid+"&pid="+s_pid+"','添加服务项')");
	return false;
}
function showsp(pid,itemid){
	$('#searchpid').find("option[value="+pid+"]").attr('selected',true);
	// if(itemid){
		getitemlist();
		$('#searchitemid').find("option[value="+itemid+"]").attr('selected',true);
	// }else{
		_search();
	// }
}
$('#searchpid').change(function(){
	getitemlist();
	_search();
})
function showitem(pid,itemid){
	showsp(pid,itemid);
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
		var crid = $('#mediaid').val();
		var itemid = $('#searchitemid').val();
		if(initpid){
			var pid=initpid;
			$('#searchpid').find("option[value="+pid+"]").attr('selected',true);
			initpid=0;
		}else{
			var pid = $('#searchpid').val();
		}
        $.post("/admin/cwpay/getListAjax.html",
            {query:query,crid:crid,pid:pid,itemid:itemid,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});


function delitem(itemid){
    if (itemid){
        $.messager.confirm('确认','确定要删除该服务项么？',function(r){
            if (r){
                // $.post('/admin/spitem/del.html',{itemid:itemid},function(result){
                    // if (result.success){
                        // $.messager.show({    
                            // timeout:800,
                            // title: '成功',
                            // msg: '删除成功'
                        // });
                        // $('.pagination-page-list').trigger('change');
                    // } else {
                        // $.messager.show({   
                            // title: 'Error',
                            // msg: result
                        // });
                    // }
                // },'json');
            }
        });
    }
    return false;
}
$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});





function getsplist(){
	var crid = $('#mediaid').val();
	$.ajax({
		url:'/admin/servicepack/getListAjax.html',
		type:'POST',
		data:{'pageSize':10000,'crid':crid},
		async:false,
		success:function(data){
			$('#searchpid').html('');
			sparr = JSON.parse(data);
			sparr.shift();
			$('#searchpid').append('<option value="0">不选</option>');
			$.each(sparr,function(i,sp){
				$('#searchpid').append('<option value="'+sp.pid+'">'+sp.pname+'</option>');
			})
		}
	});
}
function getitemlist(){
	var crid = $('#mediaid').val();
	var pid = $('#searchpid').val();
	if(pid == 0){
		$('#searchitemid').html('');
		return ;
	}
	$.ajax({
		url:'/admin/spitem/getListAjax.html',
		type:'POST',
		data:{'pageSize':10000,'crid':crid,'pid':pid},
		async:false,
		success:function(data){
			$('#searchitemid').html('');
			itemarr = JSON.parse(data);
			itemarr.shift();
			$('#searchitemid').append('<option value="0">不选</option>');
			$.each(itemarr,function(i,item){
				$('#searchitemid').append('<option value="'+item.itemid+'">'+item.iname+'</option>');
			})
		}
	});
}

$('#drop').click(function(){
       showcr();  
    });
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
		getsplist();
		getitemlist();
		_search();
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    }
function showaddin(url,title){
    
	height = 666;
	width = 800;
	var html = '<iframe scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
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