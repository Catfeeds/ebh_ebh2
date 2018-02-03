<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>服务包管理 - 服务包列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/servicepack');?>">浏览</a></td>
            <td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/servicepack/add.html','添加服务包')" class="add">添加服务包</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
<label >所属平台</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />
按服务期搜索: <select id="searchtid" name="tid" onchange="_search()"></select>
	
	
<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
	</td>
    </td>
</tr>
</table>




<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="8%" >服务包名称</th>
<th width="20%" >所属平台</th>
<th width="12%">服务期</th>
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
				<input id="delbtn" style="display:none" type="button" value="删除该分类" onclick="delsort($('#slist').val())"> 
            </div>
            <div class="fitem">
                <label>隐藏：</label>
                <label style="width:400px">
                    <input type="checkbox" id="ishide" name="ishide" value="1"/>
                    隐藏后分类下的服务项不显示

                </label>


            </div>
			<div class="fitem">
				<label>按分类收费：</label>
				<label style="width:400px">
					<input type="checkbox" id="showbysort" name="showbysort" value="1"/>
					如果按分类收费，则分类下的课程不显示
					
				</label>
				
				
			</div>
			<div class="fitem">
				<label>按长条显示：</label>
				<label style="width:400px">
					<input type="checkbox" id="showaslongblock" name="showaslongblock" value="1"/>
					分类下的课程按长条显示
					
				</label>
				
				
			</div>
			
			<div class="fitem">
			<label style="height:20px">　</label>
				<div style="float:left">
				<?php $upcontrol = Ebh::app()->lib('UpcontrolLib');?>
				<?php $upcontrol->upcontrol('image',1,false,'askimage'); ?>
				</div>
			</div>
			
			
			<div class="fitem">
                <label>排序：</label>
                <input name="sdisplayorder" id="sdisplayorder" type="text">
            </div>
            <div class="fitem">
                <label>富文本：</label>
				<div style="margin-left:80px">
                <?php $editor->simpleEditor('content','720px','290px');?>
				</div>
            </div>
			
        </form>
    </div>
	<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
</body>
<script type="text/javascript">
<?php
$tid = $this->input->get('tid');
?>
var inittid = <?=empty($tid)?0:$tid?>;
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
        row.push('<td class=username><a href="/admin/spitem.html?pid='+v.pid+'"><span style=\'color:red\'>'+v.pname+'</span></a></td>');
        row.push('<td class="realname">'+(v.crname||'')+'</td>');
		row.push('<td class="realname">'+(v.tname||'')+'</td>');
        row.push('<td class="i.dateline">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="i.dateline">'+v.displayorder+'</td>');
        row.push('<td class="realname">'+(v.status==0?'不显示':'显示')+'</td>');
		if(v.status == 0){
			row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/servicepack/view.html?pid='+v.pid+'\',\'服务包\')">详情</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/servicepack/edit.html?pid='+v.pid+'\',\'编辑服务包\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delpack('+v.pid+')" >删除</a>]&nbsp;&nbsp;[<a href="#" onclick="showaddin(\'/admin/spitem/add.html?pid='+v.pid+'\',\'添加服务项\')">添加服务项</a>]&nbsp;&nbsp;[<a href="#" onclick="showaddsort('+v.pid+',\''+v.pname+'\')" >添加分类</a>]&nbsp;&nbsp;[<a href="#" onclick="showsorts('+v.pid+',\''+v.pname+'\')" >管理分类</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.pid+',1,'+v.crid+')">解锁</a>]</td>');
		}else{
			row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/servicepack/view.html?pid='+v.pid+'\',\'服务包\')">详情</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/servicepack/edit.html?pid='+v.pid+'\',\'编辑服务包\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delpack('+v.pid+')" >删除</a>]&nbsp;&nbsp;[<a href="#" onclick="showaddin(\'/admin/spitem/add.html?pid='+v.pid+'\',\'添加服务项\')">添加服务项</a>]&nbsp;&nbsp;[<a href="#" onclick="showaddsort('+v.pid+',\''+v.pname+'\')" >添加分类</a>]&nbsp;&nbsp;[<a href="#" onclick="showsorts('+v.pid+',\''+v.pname+'\')" >管理分类</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.pid+',0,'+v.crid+')">锁定</a>]</td>');
        }
        row.push('</tr>');
        return row.join('');
    }
var s_tid = 0;
var s_crid = 0;
$(function(){
	getstlist();
    $(".pagination-page-list").trigger('change');
	try{
		parent.leftframe.$('a').removeClass();
		parent.leftframe.$('#servicepack_a').addClass('current');
	}catch(e){}
	s_tid = $('#searchtid').val();
	s_crid = $('#mediaid').val();
	$('#addbtn').attr('onclick',"showaddin('/admin/servicepack/add.html?crid="+s_crid+"&tid="+s_tid+"','添加服务包')");
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	s_tid = $('#searchtid').val();
	s_crid = $('#mediaid').val();
	$('#addbtn').attr('onclick',"showaddin('/admin/servicepack/add.html?crid="+s_crid+"&tid="+s_tid+"','添加服务包')");
	return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
		var crid = $('#mediaid').val();
		if(inittid){
			var tid=inittid;
			$('#searchtid').find("option[value="+tid+"]").attr('selected',true);
			inittid=0;
		}else{
			var tid = $('#searchtid').val();
		}
        $.post("/admin/servicepack/getListAjax.html",
            {query:query,crid:crid,tid:tid,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});

function delpack(pid){
    if (pid){
        $.messager.confirm('确认','确定要删除该服务包么？',function(r){
            if (r){
                $.post('/admin/servicepack/del.html',{pid:pid},function(result){
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
	deleteUpload('image');
	UM.getEditor("content").setContent('');
	$('#slist').hide();
	$('#delbtn').hide();
	$('#ftitle').text('添加分类');
	$('#dlg-sort').dialog('open').dialog('setTitle','分类');
	$('#form_sort').form('clear');
	$('#form_sort').form('load',{pid:pid,pname:pname,sdisplayorder:0});
	
}
function showsorts(pid,pname){
	showaddsort(pid,pname);
	$('#delbtn').show();
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
				$('#slist').append('<option value="'+sort.sid+'" ishide="' + sort.ishide + '" sdisplayorder="'+sort.sdisplayorder+'" showbysort="'+sort.showbysort+'" showaslongblock="'+sort.showaslongblock+'">'+sort.sname+'</option>');
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
	var showbysort = option.attr('showbysort');
	var showaslongblock = option.attr('showaslongblock');
    var ishide = option.attr('ishide');
	$.ajax({
		type:"post",
		url:"/admin/spsort/getDetail.html",
		data:{sid:sid},
		success:function(data){
			if(data!="null"){
				sdata = JSON.parse(data);
				$('#sname').val(sname);
				$('#sdisplayorder').val(sdisplayorder);
				if(showbysort == 1){
					$('#showbysort').prop('checked','checked');
				}else{
					$('#showbysort').prop('checked',false);
				}
				if(showaslongblock == 1){
					$('#showaslongblock').prop('checked','checked');
				}else{
					$('#showaslongblock').prop('checked',false);
				}
                if(ishide == 1){
                    $('#ishide').prop('checked','checked');
                }else{
                    $('#ishide').prop('checked',false);
                }
				if(sdata.imgurl != ''){
					$("#image\\[upfilepath\\]").val(sdata.imgurl);
					$("#image\\[upfilename\\]").val(sdata.imgname);
					$("#image_spanUpfilename").html(sdata.imgname);
					$("#image_spanUpShowPercent").css('width','100%');
					$("#image_spanUppercentinfo").html('100%');
					$("#image_spanShowButton").html("<a target=\"_blank\" href=\"" + sdata.imgurl + "\">查看</a>&nbsp;");
					$("#image_upprogressbox").show();
				}
				UM.getEditor("content").setContent(sdata.content);
			}else{
				$('#sname').val('');
				$('#sdisplayorder').val(0);
				UM.getEditor("content").setContent('');
				deleteUpload('image');
				// $("#image_upprogressbox").hide();
			}
		}
	});
}
function delsort(sid){
	if (sid!=0){
        $.messager.confirm('确认','确定要删除该分类么？',function(r){
            if (r){
                $.post('/admin/spsort/del.html',{sid:sid},function(result){
                    if (result.success){
                        $.messager.show({    
							timeout:800,
							title: '成功',
							msg: '删除成功'
                        });
						// getsort($('input name='));
						// getsorts($('input[name="pid"]').val());
						$('#slist option:selected').remove();
						fillSortform();
                        // $('.pagination-page-list').trigger('change');
                    } else {
						// alert();
						$.messager.alert('Error',result.msg);
                    }
                },'json');
            }
        });
    }else{
		$.messager.alert('Error','请选择分类后再进行删除操作');
	}
    return false;
}
function getstlist(crid){
	$.ajax({
		url:'/admin/spterm/getListAjax.html',
		type:'POST',
		data:{'pageSize':10000,'crid':crid},
		async:false,
		success:function(data){
			$('#searchtid').html('');
			sparr = JSON.parse(data);
			sparr.shift();
			$('#searchtid').append('<option value="0">不选</option>');
			$.each(sparr,function(i,st){
				$('#searchtid').append('<option value="'+st.tid+'">'+st.tname+'</option>');
			})
		}
	});
}
function changestatus(pid,status,crid){
    if (pid){
        $.post('<?php echo geturl('admin/servicepack/changestatus');?>',
            {pid:pid,status:status,crid:crid},
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
		getstlist();
		_search();
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
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
	height = 570;
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
function showprogress(){
	$("#image\\[upfilepath\\]").val(fileinfo.url_path);
	$("#image\\[upfilename\\]").val(this.fileName);

	$("#image_spanShowButton").html("<a target=\"_blank\" href=\"" + fileinfo.url_path + "\">查看</a>&nbsp;");
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
			float:left;
            margin-bottom:5px;
			width:840px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
			float:left;
        }
    </style>


<?php
$this->display('admin/footer');
?>