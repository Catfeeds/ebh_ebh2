<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>章节管理</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
</head>
<body>
<input type="hidden" id="folderid" value="<?= $folderid ?>" />
<script type="text/javascript">
var flag = true;
function edittitle(val){
	var title = $("#"+val+"name").val();
	$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="20" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction('+val+');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\')" class="bcun" value="取消" /><div></div>');
}
function editclose(title,val){
	$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">[<cite>向下</cite>]</a></div></span><div></div>');
}
//编辑章节
function saction(val){
	var title =$('#'+val+'title').val();
	$.ajax({
		url:"<?= geturl('troomv2/section/edit') ?>",
		type:'post',
		data:{'sid':val,'title':title},
		dataType:'json',
		success:function(data){
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">[<cite>向下</cite>]</a></div></span><div></div>');
			$("#sname").val("");
		}
	});
}
//删除目录
function delsction(val){
	dialog({
		title:"提示信息",
		content:"确认要删除该目录？",
		ok:function () {
			$.ajax({
				url:"<?= geturl('troomv2/section/del') ?>",
				type:'post',
				data:{'sid':val},
				dataType:'json',
				success:function(data){
					if(data.status==1){
						$("#tr"+data.sid).html('');
						updatesection();
						$("#sname").val("");
					}
				}
			});
		},
		okValue:"确定",
		cancelValue:"取消"
	}).showModal();
}
//添加章节
function addsction(val){
	var sname = $('#'+val).val();
	if (!sname.match(/^[\u4E00-\uFA29\uE7C7-\uE7F3a-z0-9A-Z]{1,20}$/)) {
		$(".SG_txtc").html('<font color="red">1-20个字符，包括中文,字母,数字</font>');
		return false;
	};
        var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troomv2/section/add') ?>",
		type:'post',
		data:{'sname':sname,'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+data.sid+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+data.sid+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+data.sid+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+data.sid+')">[<cite>向下</cite>]</a></div></span><div></div></li>');
				$("#sname").val("");
			}
		}
	});
}

function moveup(val){
	if($("#tr"+val).prev().size()==0){
		return;
	}
	$.ajax({
		url:"<?= geturl('troomv2/section/moveup') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

function movedown(val){
	if($("#tr"+val).next().size()==0){
		return;
	}
        var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troomv2/section/movedown') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

var updatesection = function(){
    var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troomv2/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			var objhtml='<div style="width:520px;">'
				objhtml+='<div id="categoryBody" style="width:485px">'
				objhtml+='<div id="categoryHead">'
				objhtml+='<table>'
				objhtml+='<tbody>'
				objhtml+='<tr>'
				objhtml+='<td>'
				objhtml+='<input class="categoryName" style="height:22px;padding:0px;" type="text" name="sname" id="sname" maxlength="20">'
				objhtml+='</td>'
				objhtml+='<td width="80">'
				objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
				objhtml+='<cite>创建目录</cite>'
				objhtml+='</a>'
				objhtml+='</td>'
				objhtml+='<td>'
				objhtml+='<span class="SG_txtc" style="margin-left:5px;width:240px;display:block;color:#999;">请用中文,英文或数字.1-20个字符!</span>'
				objhtml+='</td>'
				objhtml+='</tr>'
				objhtml+='</tbody>'
				objhtml+='</table>'
				objhtml+='<div id="errTips"></div>'
				objhtml+='</div>'
				objhtml+='<form name="form" method="post">'
				objhtml+='<div id="categoryList">'
				objhtml+='<ul class="clearfix" id="tsection">'
				$.each(data,function(k,v){
					objhtml+='<li id="tr'+v.sid+'">'
					objhtml+='<span class="htit" id="'+v.sid+'catitle" ><input type="hidden" id="'+v.sid+'name" value="'+v.sname+'" />'+v.sname+'</span>'
					objhtml+='<span class="control" STYLE="FLOAT:RIGHT">'
					objhtml+='<div class="manage">'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+v.sid+')">'
					objhtml+='[<cite>编辑</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
					objhtml+='[<cite>删除</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
					objhtml+='[<cite>向上</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
					objhtml+='[<cite>向下</cite>]</a>'
					objhtml+='</div>'
					objhtml+='</span>'
					objhtml+='</li>'
				});
				objhtml+='</ul>'
				objhtml+='<div class="SG_j_linedot"></div>'
				objhtml+='</div>'
				objhtml+='</form>'
				objhtml+='</div>'
				objhtml+='</div>'
				$("#sectiondiv").html(objhtml);
			return;
		}
	});
}
$(function(){
	var fid = $('#folderid').val();
	//section()
	updatesection();
	$("#addsection").click(function(){
		updatesection();
	});
});
</script>
</head>

<body>
<div id="sectiondiv">
</div>
</body>
</html>