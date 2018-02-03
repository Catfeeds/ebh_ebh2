<?php
$this->display('admin/header');
?>

<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody><tr>
        <td><h1 style="width:550px;">教室管理 -  教室课件管理</h1></td>
        <td class="actions">
            
        </td>
    </tr>
</tbody></table>
<form id="ck" onsubmit="return _search()">
<input type="hidden" name="status" id="status" value="">
<div id="newslisttab">
<ul>
<li class="active"><a href="">所有状态</a></li>
<li class=""><a href="#" status="0">待审箱</a></li>
<li class=""><a href="#" status="1">已审箱</a></li>
<li class=""><a href="#" status="-1">锁定箱</a></li>
<li class=""><a href="#" status="-2">禁用箱</a></li>
<li class=""><a href="#" status="-3">已删除</a></li>
  </ul>
</div>
<table cellspacing="0" cellpadding="0" class="toptable">
    <tbody>
        <tr>
            <td width="320px;" style="background:none;">
                <label>关键字: <input type="text" name="q" id="searchkey" value="" size="40"></label>
            </td>
            <td width="500px;" style="background:none;">
                <label for="catid">所属学校</label>
                <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
                <input type="button" id="drop" value="选择" />
                <input type="button" id="clear" value="清除" />
                <input type="hidden" name="crid" id="mediaid"  value="0" />
            </td>

<td>
    <input type="submit" name="selectsubmit"  value="查询" class="submit">
</td>

</tr>
</tbody></table>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.cwid+'" /></td>');
        row.push('<td class="title">'+v.title+'</td>');
        row.push('<td class="realname">'+v.username+'</td>');
        row.push('<td>'+v.crname+'</td>');
        row.push('<td>'+v.foldername+'</td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="viewnum">'+v.viewnum+'</td>');
        if(v.status==1){
            row.push('<td class="status">正常</td>');
        }else if(v.status==-1){
            row.push('<td class="status">锁定</td>');
        }else if(v.status==0){
            row.push('<td class="status">待审核</td>');
        }else if(v.status==-2){
            row.push('<td class="status">已禁用</td>');
        }else if(v.status==-3){
            row.push('<td class="status">已删除</td>');
        }
       
        row.push('<td class="displayorder"><input type="input" width="30" name="displayorder['+v.cwid+']" value="'+v.displayorder+'" /></td>');
        row.push('<td class="nowrap" >');
        if(/\.ebhp$/.test(v.cwurl)){
            if(v.status==-3){
                row.push('<span style="color:#ccc">[播放]</span>&nbsp;');
            }else{
                row.push('[<a href="javascript:freeplay(\''+v.cwsource+'\','+v.cwid+',\''+v.title+'\');">播放</a>]&nbsp;');
            }
           
        }else{
            if(v.status==-3){
                row.push('<span style="color:#ccc">[下载]</span>&nbsp;');
            }else{
                row.push('[<a href="'+v.cwsource+'attach.html?cwid='+v.cwid+'">下载</a>]&nbsp;');
            }
            
        }
        if(v.status==1||v.status==-3||v.status==-2||v.status==-1){
            row.push('<span style="color:#ccc">[审核]</span>&nbsp;');
        }else{
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">审核</a>]&nbsp;');
        }
        if(v.status==-1){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">解锁</a>]&nbsp;');
        }else if(v.status==-3){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">恢复</a>]&nbsp;');
        }else if(v.status==-2){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">解禁</a>]&nbsp;');
        }else{
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',-1)">锁定</a>]&nbsp;');
        }
        
        row.push('[<a href="#" onclick="return destroy('+v.cwid+')">删除</a>]&nbsp;');
        row.push(' </td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
    <table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
    <tr>
    <th>序号</th>
    <th>选择</th>
    <th fieldname="i.title" width="21%">课件标题</th>
    <th fieldname="i.realname">所属教师</th>
    <th>所属教室</th>
    <th>所属分类</th>
    <th fieldname="i.dateline" width="15%">添加时间</th>
    <th fieldname="i.viewnum" width="3%">点播数</th>
    <th fieldname="i.status" width="12%">状态</th>
    <th fieldname="i.displayorder" width="5%">排序</th>
    <th>操作</th>
    </tr>
    <tbody class="moduletbody">
    <tr class="tr_module" />
    <th class="sn">1</th>
    <td class="sn"><input type="checkbox" name="item[]" value="4281" />
    <input type="hidden" name="mnum[4281]" value="" />
    </td>
    <td class="title">如何快速制作课件</td>
    <td class="realname">tsvnlan</td>
    <td>e板会课堂</td>
    <td>软件帮助</td>
    <td>2012-12-10 17:13:53</td>
    <td class="viewnum">257</td>
    <td class="status">正常</td>
    <td class="displayorder"><input type="input" width="30" name="displayorder[4281]" value="500" /></td>
    <td class="nowrap" >[<a href="javascript:freeplay('http://www.ebanhui.com/',4281,'如何快速制作课件');">播放</a>]&nbsp;

    <span style="color:#ccc">[审核]</span>&nbsp;

    [<a href="#">锁定</a>]&nbsp;

    [<a href="#">删除</a>]&nbsp;
    </td>
    </tr>
    </tbody>
</table>
<div id="pp"></div>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tbody><tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall" onclick="#"><label for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="0" checked=""><label for="noop">不操作</label>&nbsp;&nbsp;
<input id="sortop" name="optype" type="radio" value="1"><label for="sortop">排序</label>&nbsp;&nbsp;
</th></tr>
</tbody></table>
<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<script type="text/javascript">
$(function(){
    $("#begintime,#endtime").trigger('focus');
    $(".pagination-page-list").trigger('change');
});
function _search(){
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:10,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ck').serialize();
        $.post("/admin/classroomcourse/getListAjax.html",
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
$(function(){
    $("#newslisttab a").click(function(){
        $('#status').val($(this).attr('status'));
        $("#newslisttab li").prop('class','');
        $(this).parent('li').prop('class','active');
        $(".pagination-page-list").trigger('change');
        return false;
    });

});
        
        function destroy(cwid){
            if (cwid){
                $.messager.confirm('确认','确定要删除该课件么？',function(r){
                    if (r){
                        $.post('/admin/classroomcourse/del.html',{cwid:cwid},function(result){
                            if (result.success){
								$.messager.show({    // show error message
                                    timeout:2000,
									title: '成功',
                                    msg: '删除成功'
                                });
								$('.pagination-page-list').trigger('change');
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
            return false;
        }
		function changestatus(cwid,status){
            if (cwid){
                $.post('<?php echo geturl('admin/classroomcourse/editclassroomcourse');?>',
					{cwid:cwid,status:status},
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
	$("#chkall").click(function(){
        $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
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
	<object classid="clsid:D8EA7D11-F23E-4B03-96C5-99EC0C9FB84C" id="ebhplayer" width="0" height="0" tabindex="2"><embed type="application/ebhplay" id="ebhplayer_noie" tabindex="2" width="0" height="0" />
    <param name="Visible" value="0">
    <param name="AutoScroll" value="0">
    <param name="AutoSize" value="0">
    <param name="AxBorderStyle" value="1">
    <param name="Caption" value>
    <param name="Color" value="4278190095">
    <param name="Font" value="MS Sans Serif">
    <param name="KeyPreview" value="0">
    <param name="PixelsPerInch" value="96">
    <param name="PrintScale" value="1">
    <param name="Scaled" value="-1">
    <param name="DropTarget" value="0">
    <param name="HelpFile" value>
    <param name="ScreenSnap" value="0">
    <param name="SnapBuffer" value="10">
    <param name="DoubleBuffered" value="0">
    <param name="Enabled" value="-1"></object>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?ver=20121214"></script>
<?php
$this->display('admin/footer');
?>