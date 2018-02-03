<?php $this->display('admin/header');?>
<script type="text/javascript" language="javascript" src="http://static.ebanhui.com/ebh/admin/include/itemjs.js"></script>
<style type="text/css">
.tandaan {
	height: 165px;
	width: 297px;
	color: #6d6d6d;
	padding:20px 25px;
	border:solid 1px #a5a5a5;
	float:left;
}
.tandaan .waixu {
	float:left;
	width:290px;
	margin:10px 0;
}
.tandaan .waixu span {
	float:left;
	width:85px;
	text-align:right;
	height:28px;
	line-height:28px;
}
.putxt {
	float:left;
	height:28px;
	line-height:28px;
}
.tandaan .waixu .txtshur {
	float:left;
	height:26px;
	line-height:28px;
	border:solid 1px #a5a5a5;
	width:194px;
	padding-left:6px;
}
.btnadd {
	color: #993300;
	cursor:pointer;
}
</style>
<body>
<!--{eval $gradeselect[$grade] = 'selected="selected"'}-->
<!--{eval $subjectselect[$subject] = 'selected="selected"'}-->
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">章节管理 - 章节列表</h1></td>
		
	</tr>
</table>

<table cellspacing="0" cellpadding="0" class="toptable">
	<tr>
		<td>
			<select name="grade" id="grade" style="width：100px" >
				<option value="">选择年级</option>
				<?php 
					foreach($gradelist as $value){
				?>
				<option value="<?=$value['gradeid']?>"><?=$value['gradename']?></option>
				<?php
				}
				?>
			</select>
			<select name="subject" id="subject" style="width：100px" >
				<option value="">选择科目</option>
				<?php 
					foreach($subjectlist as $value){
				?>
				<option value="<?=$value['subjectid']?>"><?=$value['subjectname']?></option>
				<?php
				}
				?>
				<!--{/loop}-->
			</select>
			<a href="javascript:addchapter()" class="easyui-linkbutton" iconCls="icon-add" plain="true">添加章节</a>
		</td>
	</tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%"  class="listtable" id="listtable">
<tr>
<th fieldname="i.name" width="30%">章节名称</th>
<th fieldname="i.note" width="20%">所属年级</th>
<th fieldname="i.type" width="15%">所属科目</th>
<th fieldname="i.type" width="15%">排序号</th>
<th width="10%">操作</th>
</tr>
<tbody class="moduletbody">
<?php
foreach($chapterlist as $cl){
?>
<tr class="tr_pchapter_<?=$cl['pid']?>" id="tr_chapter_<?=$cl['chapterid']?>">
<td><span id="chaptername_<?=$cl['chapterid']?>" data="<?=$cl['chaptername']?>"><?=str_repeat('┣━',$cl['level']-1).$cl['chaptername']?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btnadd" onclick="addsubchapter(<?=$cl['chapterid']?>,'<?=$cl['chaptername']?>',<?=$cl['gradeid']?>,<?=$cl['subjectid']?>)">[添加子类]</span></td>
<td><?=$cl['gradename']?></td>
<td><?=$cl['subjectname']?></td>
<td><?=$cl['displayorder']?></td>
<td class="op">[<a href="javascript:upchapter(<?=$cl['chapterid']?>,'<?=$cl['chaptername']?>',<?=$cl['pid']?>,<?=$cl['gradeid']?>,<?=$cl['subjectid']?>,<?=$cl['displayorder']?>);" >编辑</a>]&nbsp;&nbsp;[<a href="javascript:delchapter(<?=$cl['chapterid']?>,'<?=$cl['chaptername']?>');" >删除</a>]</td>
</tr>
<?php
}
?>
</table>


<div id="dlg-chapter" class="easyui-dialog" style="width:380px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">章节信息</div>
        <form id="form_chapter" method="post">
			<div class="fitem">
                <label>父章节：</label>
                <input name="pname" style="border:0px;font-weight:bold;width:200px;" readonly />
				<input type="hidden" name="pid"/>
            </div>
            <div class="fitem">
                <label>章节名：</label>
                <input name="chaptername" id="chaptername" class="easyui-validatebox" required="true" missingMessage="请输入章节名">
            </div>
            <div class="fitem">
                <label>排序：</label>
                <input name="displayorder" id="displayorder" class="easyui-validatebox" value="10" required="true" missingMessage="请输入排序号">
            </div>
            
        </form>
    </div>
	<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savechapter()" id="savebtn">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-chapter').dialog('close')">取消</a>
    </div>
<script type="text/javascript">
	var curpid = 0;
	var curpchapter;
	var curpgrade;
	var curpsubject;
	var curchapterid;
	var type=0;
	function addsubchapter(pid,pchapter,pgradeid,psubjectid) {
		curpid = pid;
		curpchapter = pchapter;
		curpgrade = pgradeid;
		curpsubject = psubjectid;
		type=0;
		showaddchapter();
	}
	function showaddchapter() {
		$('#form_chapter').form('load',{pname:curpchapter,pid:curpid,chaptername:'',displayorder:10});
		$('#dlg-chapter').dialog('open').dialog('setTitle','添加章节');
		$("#dlg-chapter").panel("move",{top:$(document).scrollTop() + ($(window).height()-280) * 0.5}); 
		// $("#pchapter").html(curpchapter);
		// $("#displayorder").val(10);
		// $("#chapter").val('');
		// $("#chapter-form").dialog("open");

	}
	$("#grade,#subject").change(function(){
		var gradeid = $('#grade').val();
		var subjectid = $('#subject').val();
		curpgrade = gradeid;
		curpsubject = subjectid;
		$.ajax({
			url: "/admin/chapter/getlist.html",
			type:"post",
			data:{gradeid:gradeid,subjectid:subjectid},
			async:false,
			success:function(data){
				_data = JSON.parse(data);
				_render(_data);
			}
		});
	});
	function _render(_data){
		$(".moduletbody").html('');
		$.each($(_data),function(k,v){
			$(_renderRow(k,v)).appendTo(".moduletbody");
		});
	}
	String.prototype.repeat = function( num )
	{
		return new Array( isNaN(num)? 1 : ++num ).join( this );
	}
	function _renderRow(k,v){
		var pre = '┣━';
		var row = ['<tr class="tr_pchapter_'+v.pid+'" id="tr_chapter_'+v.chapterid+'" >'];
		row.push('<td><span id="chaptername_'+v.chapterid+'" data="'+v.chaptername+'">'+pre.repeat(v.level-1)+v.chaptername+'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btnadd" onclick="addsubchapter('+v.chapterid+',\''+v.chaptername+'\','+v.gradeid+','+v.subjectid+')">[添加子类]</span></td>');
		row.push('<td>'+v.gradename+'</td>');
		row.push('<td>'+v.subjectname+'</td>');
		row.push('<td>'+v.displayorder+'</td>');
		row.push('<td class="op">[<a href="javascript:void" onclick="upchapter('+v.chapterid+',\''+v.chaptername+'\','+v.pid+','+v.gradeid+','+v.subjectid+','+v.displayorder+');type=1;" >编辑</a>]&nbsp;&nbsp;[<a href="javascript:delchapter('+v.chapterid+',\''+v.chaptername+'\');" >删除</a>]</td>');
		row.push('</tr>');
		return row.join('');
	}
	
	function addchapter(){
		var gradeid = $('#grade').val();
		var subjectid = $('#subject').val();
		if(gradeid==''){
			alert('请先选择年级');
			return;
		}
		if(subjectid==''){
			alert('请先选择科目');
			return;
		}
		curpchapter = '无';
		type=0;
		showaddchapter();
	}
	function upchapter(chapterid,chaptername,pid,gradeid,subjectid,displayorder){
		$('#savebtn').attr("disabled",false); 
		var pname = $('#chaptername_'+pid).attr('data');
		pname = pname?pname:'无';
		curpgrade = gradeid;
		curpsubject = subjectid;
		curchapterid = chapterid;
		type=1;
		$('#form_chapter').form('load',{pname:pname,chaptername:chaptername,pid:curpid,displayorder:displayorder});
		$('#dlg-chapter').dialog('open').dialog('setTitle','编辑章节');
		$("#dlg-chapter").panel("move",{top:$(document).scrollTop() + ($(window).height()-280) * 0.5});
	}
	
	function savechapter(){
		
		var method = type?'editchapter':'addchapter';
		var methodtext = type?'编辑':'添加';
		var chaptername = $('#chaptername').val();
		var displayorder = $('#displayorder').val();
		$('#form_chapter').form('validate');
		if(chaptername=='' || displayorder=='')
			return false;
		$('#savebtn').attr("disabled",true); 
		$.ajax({
			url:'/admin/chapter/'+method+'.html',
			type:'post',
			data:{pid:curpid,chapterid:curchapterid,gradeid:curpgrade,subjectid:curpsubject,chaptername:chaptername,displayorder:displayorder},
			success:function(result){
				$('#dlg-chapter').dialog('close');
				if (result==1){
					$('#grade').trigger('change');
					$.messager.show({    
                        timeout:1000,
                        title: '成功',
                        msg: methodtext+'成功'
                    });
                        
                } else {
					$.messager.show({   
                        title: 'Error',
                        msg: result
                    });
                }
					
			}
		});
	}
	function delchapter(chapterid,chaptername){
		var p = $('.tr_pchapter_'+chapterid);
		if(p.length>0){
			$.messager.alert('错误','此章节包含子章节，不能直接删除','info');
			return;
		}
		$.messager.confirm('确认','确定要删除章节【'+chaptername+'】吗？',function(r){
            if (r){
                $.post('/admin/chapter/deletechapter.html',{chapterid:chapterid},function(result){
                    if (result==1){
						$('#grade').trigger('change');
                        $.messager.show({    
                            timeout:1000,
                            title: '成功',
                            msg: '删除成功'
                        });
                        
                    } else {
                        $.messager.show({   
                            title: 'Error',
                            msg: result
                        });
                    }
                });
            }
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
			font-size:13px;
        }
    </style>
</body>
<?php $this->display('admin/footer');?>