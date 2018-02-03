<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>主页装扮 -PC模板</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
			<td  class=""><a href="<?php echo geturl('admin/templates/templatesmanage');?>?clienttype=<?php echo $clienttype;?>">分类管理</a></td>
            <td  class=""><a href="javascript:void(0)" onclick="showedit('/admin/templates/addtemplates.html?clienttype=<?php echo $clienttype;?>','添加模板')" class="add">添加模板</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="toptable">
<input type="hidden" id="clienttype" name="clienttype" value="<?=$clienttype?>">
<tr>
<td>
	<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >查询</a>
	<label>主类:</label><select id="selectp" name="systype" onChange="selectgallery(this.value)" style="width: 200px;">
		<option name="0" value="0" >请选择</option>
	<?php if(!empty($gallerys)){ foreach($gallerys as $gallery){?>
		<option name="<?=$gallery['systype']?>" value="<?=$gallery['aid']?>"><?=$gallery['alname']?></option>
	<?php }}?>
	</select>
	<label>子类:</label><select id="sidsecond" name="aid" style="width: 200px;" onchange="_search();">
	 	<option  value="" >请选择</option>
	</select>
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
	var clienttype = <?=$clienttype?>;
    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        var topname = (v.toptime>0)?'取消精选':'设为精选';
        var istop = (v.toptime>0)?0:1;
        var ischeck = (v.ishide==1)?'':'checked';
        var designurl = (clienttype && (clienttype==1)) ? '/room/design/mobile/'+v.did+'.html#?/did='+v.did : '/room/design/'+v.did+'.html#?/did='+v.did;
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.pid+'" /></td>');
		row.push('<td class="">'+(v.topalname)+'</td>');
		row.push('<td class="">'+(v.alname)+'</td>');
		row.push('<td class=""  align="left">'+(v.photoname)+'</td>');
		row.push('<td class=""><img src="'+(v.imgurl)+'"style="width:'+(v.picwidth)+'px;height:'+(v.picheight)+'px;max-width:245px"/></td>');
		row.push('<td class=""><input type="checkbox" '+ischeck+' id="ischeck'+v.pid+'" onchange="check_chang('+v.pid+')"/></td>');
		if(v.did==0){
			row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showedit(\'/admin/templates/edittemplates.html?pid='+v.pid+'&clienttype='+clienttype+'\',\'修改模板\')">修改</a>]'
        	+'&nbsp;&nbsp;[<a href="#" onclick="return delitem('+v.pid+')" >删除</a>]'
        	+'&nbsp;&nbsp;[<a href="#" onclick="return topitem('+v.pid+','+istop+')" >'+topname+'</a>]</td>');			
		}else{
			row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showedit(\'/admin/templates/edittemplates.html?pid='+v.pid+'&clienttype='+clienttype+'\',\'修改模板\')">修改</a>]'
	        +'&nbsp;&nbsp;[<a href="#" onclick="return delitem('+v.pid+')" >删除</a>]'
	        +'&nbsp;&nbsp;[<a href="'+designurl+'" target="_blank">'+'开始装扮'+'</a>]'
	        +'&nbsp;&nbsp;[<a href="#" onclick="return topitem('+v.pid+','+istop+')" >'+topname+'</a>]</td>');
		}
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="10%" >主类</th>
<th width="20%" >子类</th>
<th width="20%" >模板名称</th>
<th width="15%" >效果图</th>
<th width="15%" >是否显示</th>
<th >操作</th>
</tr>
<tbody class="moduletbody" style="text-align:center;">
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input type="checkbox" name="chkall" id="chkall" >
<label for="chkall">全选</label>
<a href="javascript:void(0)" onclick="return delmore()">批量删除</a>
</tr>
<tr id="divnoop" style="display: none">
<td></td>
<td></td>
</tr>
</table>
<div id="pp"></div>
<br>
</body>
<script type="text/javascript">
$(function(){	
    $(".pagination-page-list").trigger('change');
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	var aid = $('#sidsecond').val();
	var systype = $('#selectp').val();
	$(".pagination-page-list").trigger('change');
	return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
		var paid = $('#selectp').val();
		var aid = $('#sidsecond').val();
		var clienttype = $('#clienttype').val();
		var toplevel = (aid==0)?1:0;
		aid = (aid==0)?paid:aid;
		var systype = $("#selectp option:selected").attr("name");
        $.post("/admin/templates/gettemplates.html",
            {q:query,aid:aid,systype:systype,page:pageNumber,pagesize:pageSize,toplevel:toplevel,clienttype:clienttype},
            function(message){
                message = JSON.parse(message);
            	$('#pp').pagination('refresh',{total: message.data.count});
             	_render(message.data.photos);
         	});
        return false;
    }
});
	function selectgallery(paid){
		var palname = $("#sidsecond");
		var clienttype = $('#clienttype').val();
		$(' option',palname).remove('');
		palname.append('<option value="0">请选择</option>');
		$.ajax({
			type:"post",
			url:"/admin/templates/gettemplatesclass.html",
			async:true,
			data:{paid:paid,clienttype:clienttype},
			dataType:'json',
			success:function(data){
				var gallerys = data.data;
				if(gallerys && (paid != 0)){
					$.each(gallerys,function(i,item){
						palname.append('<option value="'+item.aid+'">'+item.alname+'</option>');
						
					})
				}
				_search()
			}
		});
	}


function delitem(pid){
    if (pid){
        $.messager.confirm('确认','确定要删除该模板么？',function(r){
            if (r){
               $.post('/admin/templates/deltemplates.html',{pids:[pid]},function(result){
                   if (result.code==0){
                   		$.messager.alert('成功',result.msg,'info');
                       $('.pagination-page-list').trigger('change');
                   } else {
                   		$.messager.alert('Error',result.msg,'info');
                   }
               },'json');
            }
        });
    }
    return false;
}
function delmore(){
    var checkid = document.getElementsByName("item[]");  
    var pids = new Array();  
    for (var j = 0; j < checkid.length; j++) {  
        if (checkid[j].checked == true) {  
            pids.push(checkid[j].value);  
        }  
    }
    if (pids.length<1){
    	$.messager.show({   
                           title: 'Error',
                           msg: '请选择要删除的模板'
                       });
    }else{
        $.messager.confirm('确认','确定要删除所选模板么？',function(r){
            if (r){
               $.post('/admin/templates/deltemplates.html',{pids:pids},function(result){
                   if (result.code==0){
                   		$.messager.alert('成功',result.msg,'info');
                       $('.pagination-page-list').trigger('change');
                   } else {
                   		$.messager.alert('Error',result.msg,'info');
                   }
               },'json');
            }
        });
    }
    return true;
}
$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});
	function topitem(pid,istop){
	    if (pid){
	    	var topname = (istop==1)?'设为精选':'取消精选';
	        $.messager.confirm('确认','确定要'+topname+'么？',function(r){
	            if (r){
	               $.post('/admin/templates/toptemplates.html',{pid:pid,istop:istop},function(result){
	                   if (result.code==0){
	                   		$.messager.alert('成功',result.msg,'info');
	                       $('.pagination-page-list').trigger('change');
	                   } else {
	                   		$.messager.alert('Error',result.msg,'info');
	                   }
	               },'json');
	            }
	        });
	    }
	    return false;
	}
	function showedit(url,title){
		height = 270;
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
	function check_chang(pid){
		if(pid){
		    var status = $("#ischeck"+pid).prop('checked');
		    var ishide = (status) ? 0 : 1;
		    var ishidename = (ishide==1)?'隐藏':'显示';
			$.messager.confirm('确认','确定要'+ishidename+'该模板么？',function(r){
				if(r){
	           		$.post('/admin/templates/edittemplates.html',{pid:pid,ishide:ishide});					
				}
	        });
	    }
	    return false;
	}
</script>
<?php
$this->display('admin/footer');
?>