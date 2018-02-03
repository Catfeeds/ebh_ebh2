<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css?v=0826002" rel="stylesheet" />	
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150518001" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style type="text/css">
.control .manage a.CP_a_fuc {
	background: #18a8f7;
	color: #ffffff;
	display:block;
	margin-right:4px;
	padding:4px 6px;
	margin-top:4px;
	float:left;
	line-height:normal;
}
.control .manage a.CP_a_fuc:hover {
	background: #0d9be9;
	color:#fff;
	text-decoration: none;
}
em{
	font-style:italic;
	font-weight:inherit;
}
strong{
	font-style:inherit;
	font-weight:bold;
}
</style>
	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classsubject') ?>">班级课程</a> > <a href="<?= geturl('troom/classsubject/'.$folder['folderid']) ?>"><?= $folder['foldername'] ?></a> > <?= $course['title']?>
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div id='adddiv' style="display: none;"></div>
	<div id='sectiondiv' style="display: none;"></div>
	
	<form id="courseform" name="form">
		<input type="hidden" name="isclass" value="1" />
        <input type="hidden" id="cwid"  name="cwid" value="<?= $course['cwid']?> "/>
        <input type="hidden" id="folderid" value="<?= $course['folderid'] ?>" />
		<input type="hidden" id="sfolderid" name="sfolderid"/>
		<input type="hidden" id="cwtype" name="cwtype" value="<?=$cwtype?>" />
		
	<table class="user_config_tab" width="100%">
	<tr>
		<th>&nbsp;</th>
		<td>
			<input class="uipt w340" id="title" maxlength="40" type="text" onblur="teacher(this,'课件标题','title','','n','','','控制在1-40个字之间',40)" name="title" value="<?= $course['title'] ?>" />
			<span class="ts2" id="title_msg">控制在1-40个字之间</span>
		</td>
	</tr>

	<tr id ="dnone">
		<th>&nbsp;</th>
		<td>
			<select name="sectionid" id="sectionid" onblur="teacher(this,'所属目录','sectionid','','n','','','所属目录不能为空')" value="<?= $course['sid']?>" style="width:470px;">
				<option value="">请选择</option>
			</select>
			<a id="addsection" class="addsection" onclick="return false;" href="javascript:void(0);"  style="color:#315aaa;font-size: 14px;">课程目录</a>
			<span class="ts2">如果目录为空请添加新目录。</span>
		</td>
	</tr>
	<tr>
	<th>&nbsp;</th>
	<td>
		<input class="uipt w340" id="tag" type="text" name="tag" value="<?= $course['tag']?>" onblur="teacher(this,'所属标签','tag','','n','','','多个标签之间请用逗号隔开')" />
		<span class="ts2" id="tag_msg">多个标签之间请用逗号隔开。</span>
	</td>
	</tr>
	<tr>
	<th valign="top">&nbsp;</th>
	<td style="padding-top:15px">
		<textarea class="w545 txt" id="summary" style="resize:none;" onblur="teacher(this,'课件摘要','summary','','n',10,'','请输入课件的摘要信息，字数控制在10-280个字符之间。',280)" name="summary"><?= $course['summary']?></textarea>
		<p style="line-height:22px; color:#999999;"id="summary_msg">请输入课件的摘要信息，字数控制在10-280个字符之间。</p>
	</td>
	</tr>
	<?php if($cwtype != 'live') { ?>
        <tr>
	<td colspan="2">
        <div style="width:100%;padding-left:30px;margin-top:13px;">
        <?php $editor->xEditor('message','725px','300px',$course['message']);?>
        </div>
	</td>
	</tr>
	<?php } ?>
	
</table>
<table class="user_config_tab" width="100%" style="margin-top:10px;">
	<tr style="<?=($cwtype=='live') ? "display:none" : ""?>">
	<th valign="top" style="width:90px;padding:21px 5px 15px 0">文件上传：</th>
	<td><br />
		<?php 
			if(empty($course['sourceid']) || empty($course['checksum']))
				$filelist = array();
			else
				$filelist = array(array('sid'=>$course['sourceid'],'checksum'=>$course['checksum'],'filename'=>$course['cwname'],'filesize'=>$course['cwsize']));

			Ebh::app()->lib('Webuploader')->renderHtml('up',false,$filelist); 
        ?>
        <span class="ts2" style="padding-left:0;">请选择要上传的文件，文件大小不超过500M。</span>
	</td>
	</tr>
	
	<tr style="display:none;">
	<th valign="top" >是否免费开放：</th>
	<td>
		<input type="radio" name="isfree" id="noisfree" value="0" checked="checked">不免费<input type="radio" id="isfree" name="isfree" value="1">免费<em style="color: #ADADAD">(如果选择免费，该课件将显示在首页的免费试听栏目中，且学员无需登录即可免费学习)</em>
	</td>
	</tr>
	<!-- 上传封面逻辑开始 -->
	<?php if(!empty($folder['coursewarelogo']) || !empty($roominfo['iscollege']) ){?>
	<tr style="display:none;">
	<th valign="top" style="width:90px;">上传封面：</th>
	<td>
		<?php 
			$style = empty($course['logo'])?'style="display:none;"':'';
		?>
		<a href="javascript:void(0)" onclick="uploadlogo()">点我上传</a>
		<a id="showlogo" <?=$style?> href="javascript:void(0)" onclick="showlogo()">查看</a>
		<a id="dellogo" <?=$style?> href="javascript:void(0)" onclick="dellogo()">删除</a>
		<input type="hidden" value="<?=$course['logo']?>" name="logo" id="logo" />
	</td>
	</tr>
	<!-- 上传封面逻辑结束 -->
	<!-- 上传课程封面 -->
	<?php
		$style = !empty($course['logo'])?'style="background:url('.$course['logo'].');"':'';
	?>
	<tr>
		<th valign="top" style="width:90px;padding-top:22px;">课件封面：</th>
		<td>
			<?php if(empty($course['logo'])){?>
				<a title="点我上传课件封面" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width=178px height=103px src="http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg"/></a>
			<?php }else{?>
				<a title="点我重新上传课件封面" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width=178px height=103px src="<?=$course['logo']?>"/></a>
			<?php }?>
			<span class="ts2" style="float:left;clear:both;">限JPG、PNG、GIF格式，图片清晰，单张图片小于1M，尺寸178px*103px</span>
		</td>
	</tr>
	<?php }?>
	<?php if($cwtype == 'live') { ?>
	<tr>
		<th valign="top" style="width:90px;padding:21px 5px 15px 0">开课时间：</th>
		<td>
		<div style="margin-top:11px;">
		<div style="float:left; display:inline;"><input type="text" id="submitat" name="submitat" class="readonly" readonly="readonly" style="text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" value="<?= Date('Y-m-d H:i',$course['submitat']) ?>" />&nbsp;&nbsp;&nbsp;&nbsp;</div>
		
		<div style="clear:both;"></div>
		<span class="ts2" style="float:left;">学生在此时间段内才能学习该课件，此设置只对视频和直播课件有效</span>
		</div>
		</td>
	</tr>
	
	<tr>
		<th valign="top" style="width:90px;padding:21px 5px 15px 0">持续时间：</th>
		<td>
		<div style="margin-top:11px;">
		<div style="float:left; display:inline;"><span style="display:block;height:33px; line-height:33px; float:left;"></span>
		<select class="uipt w175" type="text"  maxlength="100" name="cwlength" value="" >
				<option value="10" <?= ($course['cwlength'] / 60 == 10) ? 'selected="selected"' : ''?> >10分钟</option>
				<option value="20" <?= $course['cwlength'] / 60 == 20 ? 'selected="selected"' : ''?> >20分钟</option>
				<option value="30" <?= $course['cwlength'] / 60 == 30 ? 'selected="selected"' : ''?> >30分钟</option>
				<option value="40" <?= $course['cwlength'] / 60 == 40 ? 'selected="selected"' : ''?> >40分钟</option>
				<option value="45" <?= $course['cwlength'] / 60 == 45 ? 'selected="selected"' : ''?> >45分钟</option>
				<option value="50" <?= $course['cwlength'] / 60 == 50 ? 'selected="selected"' : ''?> >50分钟</option>
				<option value="60" <?= $course['cwlength'] / 60 == 60 ? 'selected="selected"' : ''?> >60分钟</option>
				<option value="80" <?= $course['cwlength'] / 60 == 80 ? 'selected="selected"' : ''?> >80分钟</option>
				<option value="90" <?= $course['cwlength'] / 60 == 90 ? 'selected="selected"' : ''?> >90分钟</option>
				<option value="100" <?= $course['cwlength'] / 60 == 100 ? 'selected="selected"' : ''?> >100分钟</option>
				<option value="120" <?= $course['cwlength'] / 60 == 120 ? 'selected="selected"' : ''?> >120分钟</option>
				<option value="150" <?= $course['cwlength'] / 60 == 150 ? 'selected="selected"' : ''?> >150分钟</option>
				<option value="180" <?= $course['cwlength'] / 60 == 180 ? 'selected="selected"' : ''?> >3小时</option>
				</select>

		&nbsp;&nbsp;&nbsp;&nbsp;</div>
		
		<div style="clear:both;"></div>
		</div>
		</td>
	</tr>
	<?php } ?>
	<tr>
     	<th style="padding-top:35px;"></th>
        <td><input class="fakstbttn" name="" type="button" value="" onclick="course_submit()"/><input class="qeutbtn" name="" onclick="window.history.back(-1)" value="" type="button" /></td>
    </tr>
	</table>
	</form>
	<br /><br />
	</div>
<script type="text/javascript">
	$(function(){
		initsearch("title","请输入课件标题");
		initsearch("tag","请输入标签");
		initsearch("summary","请输入摘要");
	});

    function course_submit() {
        if(teacher_submit('course',param='cdisplayorder')) {
        	var cwtype = $('#cwtype').val();
			var uploadfile = document.getElementById("up[sid]");
			if (cwtype=='course' && (uploadfile == null || uploadfile.value == '' || uploadfile.value == null)) {
				if (!confirm("您还没有上传课件文件，确定要发布吗？")) {
					return false;
				}
			}
			if($("#submitat").val() == "") {
				alert("开课时间不能为空。");
				return false;
			}
            $.ajax({
                url:"<?= geturl('troom/classcourse/edit') ?>",
                type: "POST",
                data:$("#courseform").serialize(),
                dataType:"json",
                success: function(data){
                    if(data != null && data != undefined && data.status == 1) {
                         $.showmessage({
                            img : 'success',
                            message:'修改课件成功',
                            title:'修改课件',
                            callback :function(){
                                 document.location.href = "<?= geturl('troom/classsubject/'.$folder['folderid']) ?>";
                            }
                        });
                    } else {
                        $.showmessage({
                            img : 'error',
                            message:'修改失败，请稍后再试或联系管理员。',
                            title:'修改课件'
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
			easy:true,
			padding:10,
			content:$("#sectiondiv")[0]
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
			if(data.length==0){
				$('#sectionid').append('<option value="">请选择</option>');
				$('#sectionid').css('color','#999999');
			}else{
				$('#sectionid').css('color','#3d3d3d');
			}
			$.each(data,function(key,value){
				$('#sectionid').append('<option value="'+value.sid+'">'+value.sname+'</option>');
			});
                        if(flag){
                            document.getElementById("sectionid").value="<?= $course['sid'] ?>";
                            flag = false;
                           }
			top.resetmain();
		}
	});
}
var flag = true;
function edittitle(val){
	var title = $("#"+val+"name").val();
	$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="50" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction('+val+');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\')" class="bcun" value="取消" /><div></div>');
}
function editclose(title,val){
	$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">向上</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">向下</a></div></span><div></div>');
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
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">向上</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">向下</a></div></span><div></div>');
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
	if (sname.length>50 || sname.length<1) {
		$(".SG_txtc").html('<font color="red">1-50个字符，包括中文,字母,数字</font>');
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
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+data.sid+')">编辑</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+data.sid+')">删除</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+data.sid+')">向上</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+data.sid+')">向下</a></div></span><div></div></li>');
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
				objhtml+='<input class="categoryName" style="height:22px;padding:0px;" type="text" name="sname" id="sname" maxlength="50">'
				objhtml+='</td>'
				objhtml+='<td width="80">'
				objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
				objhtml+='<cite>创建目录</cite>'
				objhtml+='</a>'
				objhtml+='</td>'
				objhtml+='<td>'
				objhtml+='<span class="SG_txtc" style="margin-left:5px;width:240px;display:block;color:#999;">请用中文,英文或数字.1-50个字符!</span>'
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
					objhtml+='编辑</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
					objhtml+='删除</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
					objhtml+='向上</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
					objhtml+='向下</a>'
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
$(function(){
	parent.window.preparexPhoto("photouploader",callback,"<?=$course['logo']?>");
});
function uploadlogo(){
	parent.window.xphoto.doShow();
}
//flash消息通知处理接口(处理此函数的执行环境是父级框架,也就是说this为 parent.window)
function callback(res){
	res = $.parseJSON(res);
	document.getElementById('mainFrame').contentWindow.msghandle(res);
};
function msghandle(res){
	if(res && res.status == 0){
		$('#showclog').attr('src',res.url);
		$('a.jnlihrey').attr('title','点我重新上传');
		$("#logo").val(res.url);
		$("#showlogo,#dellogo").show();
		alert("上传成功");
	}else{
		alert("上传失败");
	}
	parent.window.xphoto.doClose();
}

function showlogo(){
	var src = $("#logo").val();
	parent.window.HTools.hShow("<img src='"+src+"'>",true);
}
function dellogo(){
	$("#logo").val('');
	$("#showlogo,#dellogo").hide();
}

//flash上传处理 移到下面 eker 2016年1月28日17:24:53
var uploadComplete = function(file){
	var showname = file['name'].replace(file['type'],'');
	var title = $('#title');
	if(title.length>0 && title.val()=='请输入课件标题'){
		title.val(showname);
	}
	top.resetmain();
}

var fileQueued = function(file){
	if(file['size'] > 1024*1024*500){
		$.showmessage({
            img : 'error',
            message:'上传失败，文件大小不能超过500M。',
            title:'上传课件'
        });
		up_swfu.cancelUpload(file['id']);
	}
}
var fileQueueError = function(file,code,message){
	$.showmessage({
            img : 'error',
            message:'上传失败，文件大小不能超过500M。',
            title:'上传课件'
        });
}
</script>
<?php $this->display('troom/page_footer'); ?>