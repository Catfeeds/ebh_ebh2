<?php
$this->display('admin/header');
?>
<style>
    .questiondiv{
        font-size:16px;
        width:100%;
        height:30px;
        color: red;
        text-align: center;
        line-height:30px;
        font-weight:bolder;
        background: #FFF5E6;
        border-top: 3px solid #ffac30;
    }
</style>
<body>
    
    <div id="toolbar">
    <form id="search">
	<table  cellspacing="0" cellpadding="0" class="toptable">
        <input type="hidden" name="qid" value="<?=$qid?>">
      
		<tr <?php if(!empty($qid)){echo 'style="display:none"';}?>>
            <td width=200px;>
                <label for="catid">选择类型</label><?=$selectobj?>
            </td>
            <td>
		      <label>关键字: </label>
		      <input id="search-input" name='q' type="text" />
		      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
		    </td>
        </tr>
	</table>
    </form>
   
     <div  <?php if(empty($qid)){echo 'style="display:none"';}?> class="questiondiv"><span>问题标题:</span><?=urldecode($xtitle)?></div>
	</div>

    <table id="dg" cellspacing="0" cellpadding="0" width="100%"  class="listtable">
		<tbody class="reviewtbody">
			<tr>
			<th>序号</th>
			<th>选择</th>
			<th fieldname="i.username" width="8%">提问人</th>
			<th fieldname="i.toid" width="8%">提问标题</th>
            <th fieldname="i.toid" width="3%">回答类型</th>
            <th fieldname="i.toid" width="3%">感谢数</th>
			<th fieldname="i.message" width="40%">内容</th>
			<!-- <th fieldname="i.fromip">评论状态</th> -->
			<th fieldname="i.fromip">操作IP</th>
			<th fieldname="i.dateline">提交日期</th>
			<th width="3%">操作</th>
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
        row.push('<td class="sn"><input type="checkbox" name="ckbox[]" value="'+v.aid+'" qid="'+v.qid+'" uid="'+v.uid+'" /></td>');
        row.push('<td class="username">'+v.username+'</td>');
        row.push('<td class="tousername">'+v.message+'</td>');
        row.push('<td class="tousername">'+(v.answercount==1?'播放器解答':'解 答')+'</td>');
        row.push('<td class="tousername">'+v.thankcount+'</td>');
        row.push('<td class="message">'+(v.message||'')+'</td>');
        // if(v.status==0){
        // 	row.push('<td class="fromip">初始状态</td>');	
        // }else{
        // 	row.push('<td class="fromip">结束状态</td>');
        // }
       
        row.push('<td class="fromip">'+(v.fromip||'')+'</td>');
        row.push('<td class="datetime">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="op">[<a href="javascript:void(0);" onclick="del('+v.qid+','+v.aid+','+v.uid+')">删除</a>]</td>');
        row.push('</tr>');
        return row.join('');
    }

	$('#pp').pagination({
	pageSize:20,
	onSelectPage:function(pageNumber, pageSize){
        var query = $("#search").serialize();
		$.post("/admin/askanswer/getListAjax.html",
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

	function del(qid,aid,uid){
        if (qid){
            $.messager.confirm('确认','确定要删除该评论么？',function(r){
                if (r){
                    $.post('/admin/askanswer/delOneAjax.html',{qid:qid,aid:aid,uid:uid},function(result){
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
                    res+=','+$(v).attr('qid');
                    res+=','+$(v).attr('uid');
                });
                $.post('/admin/askanswer/deleteAll.html',{param:res},
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
</script>
</body>
<?php
$this->display('admin/footer');
?>