<?php $this->display('admin/header');?>
<div id="showdialog" style="width:90%;height:90%;">
    <iframe id="diframe" width=800px height=500px src="" frameborder="0" ></iframe>
</div>



<!-- ===== -->
<script type="text/javascript">
    var _status={'_-1':'已退审','_0':'待审核','_1':'正常','_-2':'已禁用','_-3':'已删除'};
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.cwid+'" />');
        row.push('<td class="title">'+v.title+'</th>');
        row.push('<td class="realname">'+v.realname+'</td>');
        row.push('<td>'+(getformatdate(v.dateline)||'')+'</td>');
        row.push('<td class="viewnum">'+v.viewnum+'</td>');
        row.push('<td class="status">'+_status['_'+v.status]+'</td>');
        // row.push('<td class="nowrap" >');
        // row.push('[<a href="javascript:void(0)" onclick="freeplay(\''+v.cwsource+'\','+v.cwid+',\''+v.title+'\','+v.status+')">播放</a>]');
        // row.push('&nbsp;[<a href="/admin/courseware/view.html?crid='+v.cwid+'">详情</a>]&nbsp;[<a href="/admin/courseware/edit.html?crid='+v.cwid+'">编辑</a>]&nbsp;[<a href="#" onclick="return destroy('+v.cwid+')">删除</a>]&nbsp;');
        // if(v.status==1){
        //     row.push('[<a href="#" onclick="return changestatus('+v.cwid+',0)">锁定</a>]&nbsp;');
        //  }else if(v.status==0||v.status==-1){
        //     row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">审核</a>]&nbsp;');
        //  }else if(v.status==-2){
        //     row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">解禁</a>]&nbsp;');
        //  }else if(v.status==-3){
        //     row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">恢复</a>]&nbsp;');
        //  }
       
        // row.push('</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody><tr>
        <td><h1 style="width:550px;">课件管理 -  课件复制</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tbody><tr>
           <!--  <td><a href="/admin/courseware.html">浏览课件信息</a></td>
            <td><a href="/admin/courseware/add.html" class="add">添加课件</a></td> -->
            </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
<form id='ck' onsubmit="return _search()">
<input type="hidden" id="status" name="status" value="" />

<table cellspacing="0" cellpadding="0" class="toptable"><tr><td>        
源学校：
<input type="text" disabled=true id="sourcecrname">
<input type="hidden" name="crid" value=0 id="sourcecrid">
<input type="button" value="选择" onclick="showdialog('s')" />
&nbsp;&nbsp;&nbsp;
源课程：
<select num="1" tag="s" name="folderid" id="s_folder" onchange="getSectionList(this)">
    <option  value=0>请选择</option>
</select>
&nbsp;&nbsp;&nbsp;
源章节：
<select num="2" tag="s" name="sid" id="s_section" onchange="getCoursewareList(this)">
    <option  value=0>请选择</option>
</select>
&nbsp;&nbsp;&nbsp;
<label>关键字: <input type="text" name="q" id="searchkey" value="" size="20" />

<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
</table>
</form>
<br>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.title" width="41%">课件标题</th>
<th fieldname="i.realname">所属教师</th>
<th fieldname="i.dateline" width="15%">添加时间</th>
<th fieldname="i.viewnum" width="3%">点播数</th>
<th fieldname="i.status" width="12%">状态</th>
<!-- <th>操作</th> -->
</tr>
<tbody class="moduletbody"></tbody>
</table>

<div id="pp"></div>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall"><label for="chkall">全选</label><span style="display:none;color:red;font-weight:bolder;">[如果不勾选全选则默认为选中的课件，如果一个课件都没有选中则默认为源课程下的所有课件，如果勾选了全选则为所有选中的课件]</span>
</th></tr>
<!-- ------ -->
<tr>
<th colspan=2>

<form id="descform">
<table cellspacing="0" cellpadding="0" class="toptable">
<tr>
<td style="background:none">        
复制到：
目标学校：
<input type="text" disabled=true id="desccrname">
<input type="hidden" name="crid" value=0 id="desccrid">
<input type="button" value="选择" onclick="showdialog('d')" />
&nbsp;&nbsp;&nbsp;
目标课程：
<select num="1" tag="d" name="folderid" id="d_folder" onchange="getSectionList(this)">
    <option  value=0>请选择</option>
</select>
&nbsp;&nbsp;&nbsp;
目标老师：
<select tag="d" name="tid" id="d_teacher">
    <option  value=0>请选择</option>
</select>
&nbsp;&nbsp;&nbsp;
目标章节：
<select num="2" tag="d" name="sid" id="d_section">
    <option  value=0>请选择</option>
</select>
&nbsp;&nbsp;&nbsp;
是否复制章节名：<input name="copysname" type="checkbox">
&nbsp;&nbsp;&nbsp;
<input type="button" name="copysubmit" id="copysubmit" onclick="docopy()" value="开始复制" class="submit">
</td></tr>
</table>
</th>
</tr>
</form>
<!-- ------- -->

</table>


<!-- ========== -->

<script>

    function showdialog(type){
        $("#diframe").attr("src","/admin/courseware/roomselect.html?type="+type);
        $('#showdialog').dialog({
            autoOpen: false,
            width: "90%",
            height: "90%",
            title: '选择学校',
            modal: true,
            resizable:false
        });
        return false;
    }
    function getFolderList(data_package){
        $.ajax({
           url: "/admin/courseware/getSchoolFolder.html",
           data:{crid:data_package.crid},
           type:"post",
           dataType:'json',
           success: function(res){
               var len = res.length;
                var optionArr = new Array();
                optionArr.push("<option value=0>请选择</option>");
                for(var i =0;i<len;i++){
                    optionArr.push("<option value="+res[i]['folderid']+">"+res[i]['foldername']+"</option>");
                }
                $("#"+data_package.type+"_folder").html(optionArr.join(""));
           }
        });
    }
    function getSectionList(e){
        getTeacherList(e);
        var type = $(e).attr('tag');
        $.ajax({
           url: "/admin/courseware/getSections.html",
           data:{folderid:$(e).val()},
           type:"post",
           dataType:'json',
           success: function(res){
                var len = res.length;
                var optionArr = new Array();
                optionArr.push("<option value=0>请选择</option>");
                for(var i =0;i<len;i++){
                    optionArr.push("<option value="+res[i]['sid']+">"+res[i]['sname']+"</option>");
                }
                $("#"+type+"_section").html(optionArr.join(""));
                if(type == "s"){
                    _search();
                }
           }
        });
    }

    function getTeacherList(e){
        $.ajax({
           url: "/admin/courseware/getFolderTeacher.html",
           data:{folderid:$(e).val()},
           type:"post",
           dataType:'json',
           success: function(res){
                var len = res.length;
                var optionArr = new Array();
                optionArr.push("<option value=0>请选择</option>");
                for(var i =0;i<len;i++){
                    optionArr.push("<option value="+res[i]['tid']+">"+res[i]['tid_name']+"</option>");
                }
                $("#d_teacher").html(optionArr.join(""));
           }
        });
    }

    function getCoursewareList(e){
        _search();
    }

    function classroom_dialog_callback(data_package){
        if(data_package.type=="s"){
            $("#sourcecrid").val(data_package.crid);
            $("#sourcecrname").val(data_package.crname);
            $('#showdialog').dialog("close");
            $("#s_folder").html("<option value=0>请选择</option>");
            $("#s_section").html("<option value=0>请选择</option>");
            _search();
            getFolderList(data_package);
        }else{
            $("#desccrid").val(data_package.crid);
            $("#desccrname").val(data_package.crname);
            $('#showdialog').dialog("close");
            getFolderList(data_package);
        }
    }
    $(function(){
        showdialog('s')
        // $(".pagination-page-list").trigger('change');
    });
    function _search(){
       if($("#sourcecrid").val() == 0){
         alert("请先选择源学校");
         return false;
       } 
       $('#pp').pagination({pageNumber:1});
       $(".pagination-page-list").trigger('change');
       return false;
    }
    $('#pp').pagination({
        pageSize:50,
        pageList:[10,20,30,50,100,200,500,1000],
        onSelectPage:function(pageNumber, pageSize){
            var query = $('#ck').serialize();
            $.post("/admin/courseware/getCoursewareListAjax.html",
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
    $("#chkall").click(function(){
        $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
    });

    function before_docopy(acwids){
        $("#copysubmit").prop("disabled",true);
        var sourcecrid = $("#sourcecrid").val();
        if(isNaN(sourcecrid) || (sourcecrid == 0) ){
            alert("必须选择来源学校");
            return false;
        }

        var desccrid = $("#desccrid").val();
        if(isNaN(desccrid) || (desccrid == 0) ){
            alert("必须选择目标学校");
            return false;
        }

        //目标课程
        var d_folderid = $("#d_folder").val();
        if(isNaN(d_folderid) || (d_folderid == 0) ){
            alert("目标课程没有选择");
            return false;
        }
        
         //目标课程
        var d_tid = $("#d_teacher").val();
        if(isNaN(d_tid) || (d_tid == 0) ){
            alert("目标老师没有选择");
            return false;
        }

        var s_folderid = $("#s_folder").val();
        if(isNaN(s_folderid) || (s_folderid == 0) ){
            if(acwids.length == 0){
                alert("源课程或者源课件必须选择一个");
                return false;
            }
        }
        return true;
    }

    function docopy(){
        var $checkdom = $("input[name='item[]']:checked");
        if($checkdom.size() == 0){
            alert("请选择课件！");
            return;
        }
        var acwids = $.map($checkdom,function(obj,index){
            return $(obj).val();
        });
        if(!before_docopy(acwids)){
            $("#copysubmit").prop("disabled",false);
            return;
        }
        $.ajax({
           url: "/admin/courseware/docopy.html",
           data:{source:$("#ck").serialize(),desction:$("#descform").serialize(),copysname:$("#copysname").val(),scwids:acwids.join(",")},
           type:"post",
           dataType:'text',
           success: function(res){
                after_docopy();
                $.messager.show({
                    title: "操作提示",
                    msg: "操作成功！",
                    showType: 'slide',
                    timeout: 1000
                });
           }
        });
        return false;
    }
    function after_docopy(){
        $("input[name='item[]']").prop("checked",false);
         $("#copysubmit").prop("disabled",false);
    }
</script>
<div style="margin-bottom:30px">&nbsp;</div>
