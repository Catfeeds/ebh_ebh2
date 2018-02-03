<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
	<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />	
	<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
        <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	<script type="text/javascript">
		var uploadComplete = function(file){
			var showname = file['name'].replace(file['type'],'');
			var title = $('#title');
			if(title.length>0 && title.val()==''){
				title.val(showname);
			}
			top.resetmain();
		}
		var fileQueueError = function(file,code,message){
			$.showmessage({
                    img : 'error',
                    message:'上传失败，文件大小不能超过500M。',
                    title:'上传课件'
                });
			up_swfu.cancelUpload(file['id']);
		}
	</script>

	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classsubject') ?>">班级课程</a> > <a href="<?= geturl('troom/classsubject/'.$folder['folderid']) ?>"><?= $folder['foldername'] ?></a> > 批量上传
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:778px;padding-left:10px;">

	<div id='adddiv' style="display: none;"></div>
	<div id='sectiondiv' style="display: none;"></div>
	    
	
	<div style="margin-top:15px">
		<?php $upcontrol->upcontrol('up',3,array(),'courseware',array(),true); ?>
		<span class="ts2">可以直接选取多个文件,单次最多选取10个，且单个文件大小不超过500M。</span>
	</div>
	<form id="courseform">
        <input type="hidden" id="folderid"  name="folderid" value="<?= $folder['folderid']?> "/>
		<div id="tables"></div>
	</form>
	<div id="buttonbar" style="display:none;margin-left:100px;">
	<input class="huangbtn" type="button" value="确认发布" onclick="course_submit()"/><input class="lanbtn marlef" onclick="window.history.back(-1)" value="取 消" type="button" />
	</div>
	</div>
	
	<div id="sampletable" style="display:none">	
	<table class="user_config_tab" id="user_config_tab" width="100%" id="uptable">
	<tbody>
	<tr>
		<th></th>
		<td>
			<input class="uipt w340" id="title" maxlength="40" type="text" name="title[]" value="" />
			<span class="ts2" id="title_msg">控制在1-40个字符之间</span>
		</td>
	</tr>
	<tr id ="dnone">
		<th></th>
		<td style="padding-top:5px;">
			<select name="sectionid[]" id="sectionid" style="width:470px;">
				<option value="">请选择</option>
			</select>
			
			<!-- <a id="addsection" class="addsection" onclick="return false;" href="javascript:void(0);"  style="color:#CD2626;font-size: 16px;">课程目录</a>
			<span class="ts2">请选择课件所属目录,如果目录为空请添加新目录。</span> -->
			
		</td>
	</tr>
	<tr>
	<th></th>
	<td style="padding-top:5px;">
		<input class="uipt w340" id="tag" type="text" name="tag[]" value="" />
		<span class="ts2" id="tag_msg">多个标签之间请用逗号隔开。</span>
	</td>
	</tr>
	<tr>
	<th valign="top"></th>
	<td style="padding-top:5px">
		<textarea id="summary" style="resize:none;width:469px;min-height:36px" name="summary[]"></textarea>
		<span class="ts2">课件的摘要信息，字数控制在10-280个字之间。</span>
	</td>
	</tr>
	
	
	</tbody>
	</table>
	</div>
	
	<div id="sampleup_upprogressbox" class="upprogressbox" >
	<div class="upfileinfo">
	<span class="upstatusinfo"><img src="http://static.ebanhui.com/ebh/images/upload.gif"/></span>
	<span id="up_spanUpfilename" class="spanUpfilename">
	</span>
	<span id="up_spanUppercent"></span>
	<span><a href="javascript:void(0);" onclick="deleteUpload('up')">&nbsp;删除</a></span>
	</div>
	<div class="upprogressbar">
	<span class="upprogressstext">上传总进度：</span>
	<span id="up_spanUppercentBox" class="spanUppercentBox">
	<span id="up_spanUpShowPercent" class="spanUpShowPercent"></span>
	</span>
	<span id="up_spanUppercentinfo"  class="spanUppercentinfo">0%</span>
	<span id="up_spanUpInfo" class="spanUpInfo"></span>
	</div>
	</div>
	<div id="samplefileinfo">
	<input type="hidden" id="up[upfilename]" name="upfilename[]" value=""/>
    <input type="hidden" id="up[upfilepath]" name="upfilepath[]" value=""/>
    <input type="hidden" id="up[upfilesize]" name="upfilesize[]" value=""/>
	</div>
<script type="text/javascript">
    function course_submit() {
		$(".huangbtn").val('上传中');
		$(".huangbtn").attr('disabled',true);
		$(".huangbtn").css('cursor','default');
		$(".huangbtn").css('background','#cdcdcd');
        if(1) {
            $.ajax({
                url:"<?= geturl('troom/classcourse/addmulti') ?>",
                type: "POST",
                data:$("#courseform").serialize(),
                dataType:"json",
                success: function(data){
                    if(data != null && data != undefined && data.status == 1) {
                         $.showmessage({
                            img : 'success',
                            message:'上传课件成功',
                            title:'上传课件',
                            callback :function(){
                                 document.location.href = "<?= geturl('troom/classsubject/'.$folder['folderid']) ?>";
                            }
                        });
                    } else {
                        $.showmessage({
                            img : 'error',
                            message:'上传失败，请稍后再试或联系管理员。',
                            title:'上传课件'
                        });
                    }
                }
            });
        }
        return false;
    }
	$(function(){
		$(".dis").hide();
		$("#isfree").click(function(){
			$(".dis").show();
			top.resetmain();
		});
		$("#noisfree").click(function(){
			$(".dis").hide();
			top.resetmain();
			
		});
		H.create(new P({
			id:'sectiondiv',
			title:'课程目录',
			content:$("#sectiondiv")[0],
			easy:true,
			padding:10
		}),'common');

            var fid = $('#folderid').val();
            section();
            $("#addsection").click(function(){
                    updatesection();
            });
	});
	function section(){
    var folderid = $('#folderid').val();
	$.ajax({
		url:"<?= geturl('troom/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			$('#dnone').css('display',"");
			$('#sectionid').empty();
			$.each(data,function(key,value){
				$('#sectionid').append('<option value="'+value.sid+'">'+value.sname+'</option>');
			});
			top.resetmain();
		}
	});
}

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
		url:"<?= geturl('troom/section/edit') ?>",
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
	if (!confirm("确认要删除该目录？")) {
		return false;
	}
	$.ajax({
		url:"<?= geturl('troom/section/del') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tr"+data.sid).html('');
				updatesection();
				$("#sname").val("");
				section()
			}
		}
	});
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
		url:"<?= geturl('troom/section/add') ?>",
		type:'post',
		data:{'sname':sname,'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+data.sid+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+data.sid+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+data.sid+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+data.sid+')">[<cite>向下</cite>]</a></div></span><div></div></li>');
				$("#sname").val("");
				section();
			}
		}
	});
}

function moveup(val){
	if($("#tr"+val).prev().size()==0){
		return;
	}
	$.ajax({
		url:"<?= geturl('troom/section/moveup') ?>",
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
		url:"<?= geturl('troom/section/movedown') ?>",
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
		url:"<?= geturl('troom/section') ?>",
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
				H.get('sectiondiv').exec('show');
			return;
		}
	});
}
function uploadComplete(){
	this.startUpload();
}
function fileQueued(file){
	if(file['size'] > 1024*1024*500){
		$.showmessage({
            img : 'error',
            message:'上传失败，文件大小不能超过500M。',
            title:'上传课件'
        });
		up_swfu.cancelUpload(file['id']);
		return;
	}
	
}
function createHtml(index){
	$('#tables').append('<div id="tablediv'+(index)+'" class="tablediv"><hr/>'+(index)+'.'+$('#sampletable').html()+'</div>');
	$('#user_config_tab')[0].id = $('#user_config_tab')[0].id + (index);
	
	$('#buttonbar').css('display','block');
	parent.resetmain();
}
function uploadcallback(t){
	var tarr = t.fileProgressID.split('_');
	_index = parseInt(tarr[2])+1;
	createHtml(_index);
	var boxcontent = $('#sampleup_upprogressbox').html();
	boxcontent = boxcontent.replace("deleteUpload('up')","deleteUpload('up',"+ _index +")");
	
	$('#user_config_tab'+_index).after('<div id="up_upprogressbox" style="margin-left:100px">'+ boxcontent +'</div>');
	
	$('#up_upprogressbox')[0].id = $('#up_upprogressbox')[0].id + _index;
	$('#up_spanUpfilename')[0].id = $('#up_spanUpfilename')[0].id + _index;
	$('#up_spanUppercent')[0].id = $('#up_spanUppercent')[0].id + _index;
	$('#up_spanUppercentBox')[0].id = $('#up_spanUppercentBox')[0].id + _index;
	$('#up_spanUpShowPercent')[0].id = $('#up_spanUpShowPercent')[0].id + _index;
	$('#up_spanUppercentinfo')[0].id = $('#up_spanUppercentinfo')[0].id + _index;
	$('#up_spanUpInfo')[0].id = $('#up_spanUpInfo')[0].id + _index;
	
	$('#tablediv'+_index).append($('#samplefileinfo').html());
	// console.log ($('#up\\[upfilename\\]')[1].id);
	
	$('#up\\[upfilename\\]')[0].id = $('#up\\[upfilename\\]')[0].id + _index;
	$('#up\\[upfilepath\\]')[0].id = $('#up\\[upfilepath\\]')[0].id + _index;
	$('#up\\[upfilesize\\]')[0].id = $('#up\\[upfilesize\\]')[0].id + _index;
	var filename = $('#up\\[upfilename\\]'+_index).val();
	var farr = filename.split('.');
	var title = filename.replace('.'+farr[farr.length-1],'');
	$('#user_config_tab'+_index+' #title').val(title);
	
	parent.resetmain();
}
function deleteUpload(name,i) {
	var progress = new FileProgress("",name + "_upprogressbox" + i);
	progress.reset(name);
	$('#up_upprogressbox'+i).remove();
	$('#tablediv'+i).remove();
	parent.resetmain();
	if($('.tablediv')[0] == undefined){
		$('#buttonbar').css('display','none');
	}
}
</script>		
<?php $this->display('troom/page_footer'); ?>