<?php
$this->display('admin/header');
?>
<style>
    .toptable td{
        padding:0;
        background: none;
    }
</style>
<body>
    <div id="toolbar">
    <form id="search">
	<table  cellspacing="0" cellpadding="0" class="toptable">
		<tr>
            <td width=200px;>
                &nbsp;&nbsp;&nbsp;&nbsp;<label for="catid">选择类型</label><?=$selectobj?>
            </td>            
            <td  width=500px;>
                 <label for="catid">所属学校</label>
                <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
                <input type="button" id="drop" value="选择" />
                <input type="button" id="clear" value="清除" />
                <input type="hidden" name="crid" id="mediaid"  value="0" />
            </td>
            <td>
		      <label>关键字: </label>
		      <input id="search-input" name='q' type="text" />
		      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
		    </td>
        </tr>
	</table>
    </form>
	</div>
    <table id="dg" cellspacing="0" cellpadding="0" width="100%"  class="listtable">
		<tbody class="reviewtbody">
			<tr>
			<th>序号</th>
			<th>选择</th>
			<th fieldname="i.username" width="8%">提问人</th>
			<th fieldname="i.toid" width="8%">提问标题</th>
            <th fieldname="i.toid" width="3%">回答数</th>
            <th fieldname="i.toid" width="3%">感谢数</th>
			<th fieldname="i.message" width="40%">内容</th>
			<th fieldname="i.fromip">问题状态</th>
			<th fieldname="i.fromip">操作IP</th>
			<th fieldname="i.dateline">提交日期</th>
            <th fieldname="i.dateline">查看回答</th>
			<th width="9%">操作</th>
			</tr>
		</tbody>
		<tbody class="moduletbody"></tbody>
	</table>
	<form method="post" name="listform" id="theform" action="" onsubmit="return whatOp();">
		<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
		<tbody><tr><th width="12%">批量操作</th><th>
		<input type="checkbox" name="chkall" id="ckhead"><label for="chkall">全选</label>
		<input type="radio" name="operation" value="noop" checked="" id="noop"><label for="noop">不操作</label>
		<input type="radio" name="operation" value="del" id="del"><label for="del">删除</label>
		<!-- <input type="radio" name="operation" value="plock" id="plock"><label for="plock">锁定</label>
		<input type="radio" name="operation" value="punlock" id="punlock"><label for="punlock">解锁</label> -->
		</th></tr>
		<tr id="divnoop" style="display:none"><td></td><td></td></tr>
		
		</tbody></table>
		<span id="pp"></span> 
		<div class="buttons">
		<input type="submit" name="listsubmit" value="提交保存" class="submit">
		<input type="reset" name="listreset" value="重置">

		</div>
	   
	</form>
<span id="pp"></span> 
<div id="winwrap" style="display:none">
    <iframe id="win" ></iframe>
</div>
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<script type="text/javascript">
	$(function(){
        $(".pagination-page-list").trigger('change');
    });
    function _search(){
        $(".pagination-page-list").trigger('change');
        return false;
    }
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_review" />'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="ckbox[]" value="'+v.qid+'" /></td>');
        row.push('<td class="username">'+v.username+'</td>');
        row.push('<td class="tousername">'+v.title+'</td>');
        row.push('<td class="tousername">'+v.answercount+'</td>');
        row.push('<td class="tousername">'+v.thankcount+'</td>');
        row.push('<td class="message">'+(v.message||'')+'</td>');
        if(v.status==0){
        	row.push('<td class="fromip">初始状态</td>');	
        }else{
        	row.push('<td class="fromip">结束状态</td>');
        }
       
        row.push('<td class="fromip">'+(v.fromip||'')+'</td>');
        row.push('<td class="datetime">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="op" style="text-align:center">[<a href="#" onclick="return showdialog('+v.qid+',\''+v.title+'\')" >查看回答</a>]</td>');
        // row.push('<td class="op" style="text-align:center">[<a href="/admin/askanswer.html?title='+v.title+'&qid='+v.qid+'">查看回答</a>]</td>');
        row.push('<td class="op">[<a target="_blank" href="/question/'+v.qid+'.html" >查看详情</a>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href="javascript:void(0);" onclick="del('+v.qid+')">删除</a>]</td>');
        
        row.push('</tr>');
        return row.join('');
    }

	$('#pp').pagination({
	pageSize:20,
	onSelectPage:function(pageNumber, pageSize){
        var query = $("#search").serialize();
		$.post("/admin/question/getListAjax.html",
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

	function del(qid){
        if (qid){
            $.messager.confirm('确认','确定要删除该评论么？',function(r){
                if (r){
                    $.post('/admin/question/delOneAjax.html',{qid:qid},function(result){
                        if (result>0){
							$.messager.show({
                                title: '操作提示',
                                msg: '删除成功',
								timeout:800
                            });
							$('.pagination-page-list').trigger('change');
                        } else {
                            $.messager.show({
                                title: 'Error',
                                msg: '操作失败'
                            });
                        }
                    });
                }
            });
        }
	}

	
//批量按钮点击展现子选项
    $(function(){
        $(":radio[name='operation']").click(function(){
            var showDiv = 'div'+$(this).attr('value');
            if(showDiv=='divnoop'){
                $("tr[id^=div]").hide();
                return;
            }
            $("tr[id^=div]").hide();
            $('#'+showDiv).show();

        });
    })

    //批量操作路由器
    function whatOp(){
        var opTag = $(":radio[name='operation']:checked").val()
        var op = opTag+'All';
        eval(op+'(opTag)');
        return false;
    }
   

    function delAll(){
        $.messager.confirm('确认','您确认想要删除所选记录吗？',function(r){
            if(r){
                var ckboxs = $(":checkbox[name='ckbox[]']:checked");
                var res='';
                $.each(ckboxs,function(i,v){
                    res+=';'+v.value;
                });
                $.post('/admin/question/deleteAll.html',{param:res},
                    function(message){
                        if(message>0){
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "批量删除成功!！",
                                    showType: 'slide',
                                    timeout: 800
                                });
                            
                        }
                        $('.pagination-page-list').trigger('change');
                    });

                return false;
            }else{
                return false;
            }
        });
        
    }

    $(function(){
        $('.pagination-page-list').change(function(){
            $('#ckhead').prop('checked',false);
        });
    });
    function plockAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        $.post('/admin/previews/changeStatus.html',{param:res,status:2},
            function(message){
                $.messager.show({
                    title: "操作提示",
                    msg: "批量锁定成功!！",
                    showType: 'slide',
                    timeout: 800
                });
                $('.pagination-page-list').trigger('change');
        });
        return false;
    }
    function punlockAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        $.post('/admin/previews/changeStatus.html',{param:res,status:1},
            function(message){
                $.messager.show({
                    title: "操作提示",
                    msg: "批量解锁成功!！",
                    showType: 'slide',
                    timeout: 800
                });
                $('.pagination-page-list').trigger('change');
        });
        return false;
    }

    $("#ckhead").click(function(){
        $("input[name='ckbox[]']").prop('checked',$("#ckhead").prop('checked'));
    });

    function showdialog(qid,title){
        var url = '/admin/askanswer.html?title='+title+'&qid='+qid;
        var width = $(window).width();
        var height = $(window).height();
        $('#win')
        .attr('width',width/5*3)
        .attr('height',height/5*3)
        .attr('src',url);
        $('#winwrap').show();
        $('#winwrap').dialog({    
            title: '<span style="color:red">'+title+'</span>的回答列表', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        // $('#win').window('refresh', );  
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
        // $('#win').window('refresh', );  
        return false;
    }
    $('#drop').click(function(){
       showcr();  
    });
    $('#clear').click(function(){
        $('#mediaid').val("");
        $('#crname').val("");
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    } 
</script>
</body>
<?php
$this->display('admin/footer');
?>