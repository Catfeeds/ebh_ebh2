<?php $this->display('troomv2/page_header'); ?>
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
	</script>
	<style type="text/css">
.user_config_tab tr th {
float:left; padding: 15px 0;
}
	</style>

	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troomv2/subject') ?>">课程列表</a> > <a href="<?= geturl('troomv2/subject/'.$folder['folderid']) ?>"><?= $folder['foldername'] ?></a> > 上传课件
		</div>
	<div class="lefrig">

	<div id='adddiv' style="display: none;"></div>
	<div id='sectiondiv' style="display: none;"></div>
	<div class="user_config">
	<form id="courseform">
	<input type="hidden" name="isclass" value="1" />
        <input type="hidden" id="folderid"  name="folderid" value="<?= $folder['folderid']?> "/>
	<table class="user_config_tab" width="100%">
	<tr>
		<th>课件标题：</th>
		<td>
			<input class="uipt w340" id="title" maxlength="25" type="text" onblur="teacher(this,'课件标题','title','','n','','','请输入课件标题。',25)" name="title" value="" />
			<span class="ts2" id="title_msg">请输入课件标题,控制在1-25个字符之间</span>
		</td>
	</tr>
	<input type="hidden" name="foldername" id="foldername" value="$folderid" />
	<tr id ="dnone">
		<th>所属目录：</th>
		<input type="hidden" id="sfolderid" name="sfolderid"/>
		<td>
			<select name="sectionid" id="sectionid" onblur="teacher(this,'所属目录','sectionid','','n','','','所属目录不能为空')">
				<option value="">请选择</option>
			</select>
			<a id="addsection" class="addsection" onclick="return false;" href="javascript:void(0);"  style="color:#CD2626;font-size: 16px;">课程目录</a>
			<span class="ts2">请选择课件所属目录,如果目录为空请添加新目录。</span>
		</td>
	</tr>
	<tr>
	<th>课件标签：</th>
	<td>
		<input class="uipt w340" id="tag" type="text" name="tag" value="" onblur="teacher(this,'所属标签','tag','','n','','','多个标签之间请用逗号隔开')" />
		<span class="ts2" id="tag_msg">多个标签之间请用逗号隔开。</span>
	</td>
	</tr>
	<tr>
	<th valign="top">课件摘要：</th>
	<td style="padding-top:15px">
		<textarea class="w545 txt" id="summary" style="resize:none;" onblur="teacher(this,'课件摘要','summary','','n',10,'','请输入课件的摘要信息，字数控制在10-280个字符之间。',280)" name="summary"></textarea>
		<p style="line-height:22px; color:#999999;"id="summary_msg">请输入课件的摘要信息，字数控制在10-280个字符之间。</p>
	</td>
	</tr>
	<tr>
            <th valign="top">课件详情：</th><td></td>
        </tr>
        <tr>
            <td colspan="2">
	
        <div style="width:100%;padding-left:30px">
           
            <?php
        $editor->xEditor('message','100%','300px');
        ?>
        </div>
	</td>
	</tr>
	<tr>
	<th valign="top">文件上传：</th>
	<td>
		<div style="float:left;display:block;min-height:40px;margin-top: 10px;">
			<?php $upcontrol->upcontrol('up',3); ?>
			</div>
	</td>
	</tr>
	
	<tr style="display:none;">
	<th valign="top">是否免费开放：</th>
	<td>
		<input type="radio" name="isfree" id="noisfree" value="0" checked="checked">不免费<input type="radio" id="isfree" name="isfree" value="1">免费<em style="color: #ADADAD">(如果选择免费，该课件将显示在首页的免费试听栏目中，且学员无需登录即可免费学习)</em>
	</td>
	</tr>
	
	<tr class="dis">
		<th>课件封面：</th>
		<td>
                        <?php $upcontrol->upcontrol('logo',1); ?>
		</td>
	</tr>
	<tr class="dis">
		<th>课件封面：</th>
		<td>
		<table class="covertab">
		
		<tr>
		<td>
			<table class="cover">
				<tr>
					<td style="width:200px;height:200px;text-align:center;vertical-align:middle;">
						<a id="a$val" target="_blank" class="sn" href="http://static.ebanhui.com/ebh/tpl/default/images/nopic.gif">
							<img id="i$val" width="200px" height="200px" src="http://static.ebanhui.com/ebh/tpl/default/images/nopic.gif" />
						</a>
					</td>
				</tr>
				<tr>
					<td align="center" style="padding:0px;height:40px">
						<span style="display:block;padding:5px;border-bottom:1px solid #B8D4E8">尺寸：</span>
			
					</td>
				</tr>
			</table>
		</td>
		</tr>
		
		</table>
		</td>
	</tr>
	<tr>
		<th>排序编号：</th>
		<td>																				   
			<input class="uipt w100" id="cdisplayorder" name="cdisplayorder" type="text" onblur="teacher(this,'排序编号','cdisplayorder','^[0-9]*$','n',null,'','请输入排序编号,排序号越小越靠前。')" value="50" />
			<span class="ts2" id="cdisplayorder_msg">请输入排序编号,排序号越小越靠前,默认为50。</span>
		</td>
	</tr>
	
	<tr>
     	<th></th>
        <td><input class="huangbtn" name="" type="button" value="确认发布" onclick="course_submit()"/><input class="lanbtn marlef" name="" onclick="window.history.back(-1)" value="取 消" type="button" /></td>
    </tr>
	</table>
	</form>
	</div>
<script type="text/javascript">
    function course_submit() {
        if(teacher_submit('course',param='cdisplayorder')) {
            $.ajax({
                url:"<?= geturl('troomv2/classcourse/add') ?>",
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
                                 document.location.href = "<?= geturl('troomv2/subject/'.$folder['folderid']) ?>";
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
	    	easy:true,
	    	padding:5,
	    	content:$('#sectiondiv')[0]
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
		url:"<?= geturl('troomv2/section') ?>",
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
						section()
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
				H.get('sectiondiv').exec('show');
			return;
		}
	});
}
</script>		
<?php $this->display('troomv2/page_footer'); ?>