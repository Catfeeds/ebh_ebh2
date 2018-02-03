<?php $this->display('troomv2/page_header'); ?>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
	<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css?v=0826003" rel="stylesheet" />
	<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
	<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css"/>
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
		#assistant{margin-top:0;}
		.lantewu span{cursor:pointer;font-size:1.2em;}
		.lantewu span.la{color:#3399ff;}
		.htit{
			text-align:left;
		}
	</style>
	<div class="lefrig">
		<?php $this->display('troomv2/course_menu');?>
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
				<?php if($folder['showmode'] != 3 && $cwtype != 'live'){?>
				<tr>
					<th valign="top">开启聊天室：</th>
					<td>
						<label style=" "><input type="radio" name="open_chatroom" id="noopen_chatroom" value="0" <?php if($course['open_chatroom'] == 0){ ?> checked="checked" <?php } ?>>不开启</label> <label style=" "><input type="radio" id="open_chatroom" name="open_chatroom" value="1" <?php if($course['open_chatroom'] == 1){ ?> checked="checked" <?php } ?>>开启</label><em style="color: #ADADAD"></em>
					</td>
				</tr>
				<?php } ?>
				<?php if($iszjdlr){?>
				<tr>
					<th valign="top">指定讲课人：</th>
					<td>
						<div class="eeret" id="ask-for-students" style="background:url(http://static.ebanhui.com/ebh/images/xuanter.jpg) no-repeat;width:130px;padding-left:8px;height:30px;line-height:30px;">
							<a class="ekiyt" href="javascript:void(0)"><span class="show_studentname"><?=empty($userinfo['realname'])?'无':$userinfo['realname']?></span></a>
							<input type="hidden" name="tid" value="<?=empty($userinfo['uid'])?'':$userinfo['uid']?>" />
						</div>
					</td>
				</tr>
				<?php }?>
				<tr>
					<th style="padding-top:35px;"></th>
					<td><input class="fakstbttn" name="" type="button" value="" onclick="course_submit()"/><input class="qeutbtn" name="" onclick="window.history.back(-1)" value="" type="button" /></td>
				</tr>
			</table>
		</form>
		<br /><br />
	</div>
	<?php if($assistant_enabled === true) { ?>
	<div id="wxDialog" class="taneret" style="display:none">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
		<style>
			.choose_user_list{
				background: #fff none repeat scroll 0 0;
				border-bottom: 0 none;
				height: 475px;
				overflow-y: auto;
				padding: 10px 0 0 10px;
			}
			.titkets {
				border-bottom: 1px solid #f5f5f5;
				margin: 0 10px;
				min-height: 86px;
				overflow-y: auto;
			}
			.leftkes {
				color: #666;
				float: left;
				font-weight: bold;
				padding: 10px 0 0 10px;
				width: 100px;
			}
			.rigleis {
				float: left;
				padding: 2px 0;
				width: 820px;
			}
			.etklys {
				float: left;
				padding: 5px;
			}
			.etklys a.auttdss {
				color: #888;
				display: block;
				padding: 5px;
			}
			.auttdss img{width:50px;height:50px;}
			.xuanz {
				background: #4fcffd none repeat scroll 0 0;
				color: #fff;
				float: left;
				height: 22px;
				line-height: 22px;
				margin-bottom: 8px;
				margin-right: 6px;
				padding: 0 7px;
			}
			.xuanz a{color:#fff}
			.wxselected{background-color: #4fcffd;}
			.atfwt{padding:0px; margin:0 5px 5px; display: block;}
			input.txtshout{color:#666;font-size:14px;}
			li.etklys{width:84px;margin:0;padding:0;}

		</style>
		<div class="rtyres">
			<div class="workmet">
				<ul>
					<li id="chooseTeacherTag" class="workrent">
						<a href="javascript:;">
							选择教师
						</a>
					</li>
				</ul>
				<div class="etshout">
					<input class="txtshout" name="textarea" type="text" id="a_title" placeholder="请输入关键字" />
					<a href="javascript:;" class="shoutbtn">搜 索</a>
				</div>
			</div>
			<div id="choose-teacher" class="choose_user_list">
				<?php
				$index = count($grouparray);
				foreach($grouparray as $group){
					$index--;
					if (!empty($group['teacherlist'])) {?>
						<div class="titkets"<?php if($index === 0) { ?> style="border:0 none;"<?php } ?>>
							<div class="leftkes"><?=$group['groupname']?>：</div>
							<div class="rigleis">
								<ul>
									<?php foreach($group['teacherlist'] as $teacher){
										if(empty($teacher['face'])){
											if($teacher['sex'] == 1) {
												$teacher['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
											} else {
												$teacher['face'] ='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
											}
										}
										$teacher['face'] = getthumb($teacher['face'],'50_50');
										$teacher['showname'] = empty($teacher['realname']) ? $teacher['username'] : $teacher['realname'];
										?>
										<li class="etklys" title="<?=htmlspecialchars($teacher['showname'], ENT_COMPAT)?>">
											<a id="face_<?=$teacher['uid']?>" class="auttdss" tid="<?=$teacher['uid']?>" tname="<?=$teacher['showname']?>" href="javascript:;"><img src="<?=$teacher['face']?>"></a>
											<a class="atfwt" tid="<?=$teacher['uid']?>" tname="<?=$teacher['showname']?>" href="javascript:;"><?=htmlspecialchars(shortstr($teacher['showname'], 8), ENT_NOQUOTES)?></a>
										</li>
									<?php }?>
								</ul>
							</div>
						</div>
					<?php    }
				}?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if($iszjdlr){?>
	<div class="trekt" id="studentdiv" style="display:none">
		<div class="designatedstudent" style="padding:0 0 15px 15px;">
			<div class="designatedstudent-left">
				<?php if (!empty($classes)) { foreach ($classes as $index => $classitem) { ?>
					<a href="javascript:;" class="class-1<?php if($index == 0) { ?> on<?php } ?>"<?php if(strlen($classitem['classname']) > 14){ ?> title="<?=htmlspecialchars($classitem['classname'], ENT_COMPAT)?>"<?php } ?> cid="<?=$classitem['classid']?>"><?=htmlspecialchars(shortstr($classitem['classname'], 14), ENT_NOQUOTES)?></a>
				<?php }} ?>
			</div>
			<div class="designatedstudent-right">
				<div class="diles-1">
					<input class="newsou-1" placeholder="请输入学生姓名" style="color:#999;" type="text">
					<input class="soulico-1" value="" type="button">
				</div>
				<div class="clear"></div>
				<ul>
					<?php if (!empty($students)){ foreach ($students as $student) {
						$show_name = !empty($student['realname']) ? $student['realname'] : $student['username']; ?>
						<li uid="<?=$student['uid']?>" username="<?=htmlspecialchars($show_name, ENT_COMPAT)?>">
							<div><img class="designatedstudenthead" src="<?=getavater($student,'50_50')?>"></div>
							<p class="designatedstudentname"<?php if(strlen($show_name) > 6) { ?> title="<?=htmlspecialchars(shortstr($show_name, 8), ENT_COMPAT)?>"<?php } ?>><?=shortstr($show_name, 6)?></p>
						</li>
					<?php }} ?>
				</ul>
				<div class="clear"></div>
				<div class="loading-1" style="display:none">
					<div class="loadingson-1">
						<img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif">
						<span>正在加载</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
	<?php
		$upconfig = Ebh::app()->getConfig()->load('upconfig');
		$baseurl = $upconfig['pic']['showpath'];
	?>
	<script type="text/javascript">
		var imageServer = '<?=$baseurl?>';
		$(function(){
			initsearch("title","请输入课件标题");
			initsearch("tag","请输入标签");
			initsearch("summary","请输入摘要");
		});

		function course_submit() {
			if(teacher_submit('course',param='cdisplayorder')) {
				var cwtype = $('#cwtype').val();
				var uploadfile = document.getElementById("up[sid]");
				course_submit2(cwtype);
			}
			return false;
		}
		function course_submit2(cwtype) {
				if($("#submitat").val() == "") {
					dialog({
						title:"提示",
						content:"开课时间不能为空。",
						cancel:false,
						okValue:"确定",
						ok:function () {
							this.close().remove();
						}
					}).show();
					return false;
				}
				<?php if($iszjdlr){?>
					if($("input[name=tid]").val() == ''){
						var d = dialog({
							title: '提示信息',
							content: '请选择讲课人',
							okValue: '确定',
							cancel: false,
							ok: function () {}
						});
						d.showModal();
						$(".fakstbttn").attr('disabled',false);
						return false;
					}
				<?php }?>
				$.ajax({
					url:"<?php if($iszjdlr){echo '/troomv2/classcourse/edit.html?toid='.$toid;}else{echo '/troomv2/classcourse/edit.html';} ?>",
					type: "POST",
					data:$("#courseform").serialize(),
					dataType:"json",
					success: function(data){
						if(data != null && data != undefined && data.status == 1) {
							dialog({
								skin:"ui-dialog2-tip",
								content:"<div class='TPic'></div><p>修改课件成功</p>",
								width:350,
								onshow:function () {
									var that=this;
									setTimeout(function () {
										document.location.href = "<?= geturl('troomv2/classsubject/'.$folder['folderid']) ?>";
										that.close().remove();
									}, 2000);
								}
							}).show();
						} else {
							dialog({
								skin:"ui-dialog2-tip",
								content:"<div class='FPic'></div><p>修改失败，请稍后再试或联系管理员。</p>",
								width:350,
								onshow:function () {
									var that=this;
									setTimeout(function () {
										that.close().remove();
									}, 2000);
								}
							}).show();
						}
					}
				});
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

			//课程输入
			$(document).on("click",'#sname',function(){
				if($(this).val()=="请输入课程目录"){
					$(this).val('');
				}
				$(this).on("blur",function(){
					if($.trim($(this).val())==''){
						$(this).val('请输入课程目录');
					}
				})
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
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+val+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+val+')"></a></div></span><div></div>');
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
					$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+val+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+val+')"></a></div></span><div></div>');
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
				},
				okValue:"确定",
				cancelValue:"取消"
			}).showModal();
		}
		//添加章节
		function addsction(val){
			var sname = $('#'+val).val();
			if(sname=='请输入课程目录'){
				$('#'+val ).val('');
				$('#'+val ).focus();
				return false;
			}

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
						$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+data.sid+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+data.sid+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+data.sid+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+data.sid+')"></a></div></span><div></div></li>');
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
					objhtml+='<input class="categoryName" value="请输入课程目录" type="text" name="sname" id="sname" maxlength="50">'
					objhtml+='</td>'
					objhtml+='<td width="80">'
					objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
					objhtml+='<cite>创建目录</cite>'
					objhtml+='</a>'
					objhtml+='</td>'
					objhtml+='</tr>'
					objhtml+='<tr colspan="2">'
					objhtml+='<td>'
					objhtml+='<span class="SG_txtc" style="margin-left:5px;width:265px;display:block;color:#999; text-align:left;">输入1-50个中文、英文、数字字符！</span>'
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
						objhtml+='<a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+v.sid+')">'
						objhtml+='编辑</a>'
						objhtml+='<a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
						objhtml+='删除</a>'
						objhtml+='<a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
						objhtml+='</a>'
						objhtml+='<a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
						objhtml+='</a>'
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
			parent.window.preparexMulPhoto("photouploader",callback, null, 'http://up.ebh.net/uploadimageandthumb.html', 178, 103);
		});
		function uploadlogo(){
			parent.window.xmulphoto.doShow();
		}
		//flash消息通知处理接口(处理此函数的执行环境是父级框架,也就是说this为 parent.window)
		function callback(res){
			res = $.parseJSON(res);
			document.getElementById('mainFrame').contentWindow.msghandle(res);
		};
		function msghandle(res){
			if(res && res.status == 0){
				$('#showclog').attr('src',imageServer+res.data.thumb);
				$('a.jnlihrey').attr('title','点我重新上传');
				$("#logo").val(imageServer+res.data.thumb);
				$("#showlogo,#dellogo").show();
			    dialog({
				skin:"ui-dialog2-tip",
				content:"<div class='TPic'></div><p>上传成功！</p>",
				width:350,
				onshow:function () {
					var that=this;
					setTimeout(function() {
						that.close().remove();
					}, 1000);
				}
				}).show();
			}else{
				dialog({
				skin:"ui-dialog2-tip",
				content:"<div class='FPic'></div><p>上传失败！</p>",
				width:350,
				onshow:function () {
					var that=this;
					setTimeout(function() {
						that.close().remove();
					}, 2000);
				}
				}).show();
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
				var d = dialog({
					title: '上传课件',
					content: '上传失败，文件大小不能超过500M。',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				up_swfu.cancelUpload(file['id']);
			}
		}
		var fileQueueError = function(file,code,message){
			var d = dialog({
				title: '上传课件',
				content: '上传失败，文件大小不能超过500M。',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
		}
		<?php if($assistant_enabled === true) { ?>
		var deleteBtn =  $("#assistant span.languan");
		var assistantBox = deleteBtn.next();
		var assistantValue = $("#assistant input[name='assistantid']");
		//创建dialog
		$("#choose-teacher").bind('click', function(e) {
			var otarget = null;
			var nodeName = e.target.nodeName.toLowerCase();
			if (nodeName == 'a') {
				otarget = $(e.target);
			} else if(nodeName == 'img') {
				otarget = $(e.target).parent('a');
			}

			if (otarget) {
				if (otarget.hasClass('auttdss') || otarget.hasClass('atfwt')) {
					var name = otarget.attr('tname');
					var tid = otarget.attr('tid');
					assistantBox.html(name);
					assistantValue.val(tid);
					$("#assistant").css('background-color', '#ffa631');
					assistantBox.removeClass('la');
					deleteBtn.show();
					parent.window.H.get('wxDialog').exec('close');
					return false;
				}
			}
		});
		//搜索
		var wx = '';
		$(".shoutbtn").bind('click', function(){
			var uname = $("#a_title", parent.document).val().replace(/\s+/g,"");
			$('li.etklys', parent.document).show();
			$("div.titkets",parent.document).show();
			if(uname == wx){
				return;
			}
			var faceid = '';//第一个搜索到的名字
			$.each($(".atfwt",parent.document),function(idx,obj){
				if($(obj).html().replace(/\s+/g,"").indexOf(uname)!=-1){
					if (faceid == '') {
						faceid = "face_"+$(obj).attr("tid");
					}
					//$(obj).addClass('wxselected');
					$(obj).parent('li').show();
				} else {
					$(obj).parent('li').hide();
				}
			});
			$("div.titkets",parent.document).each(function() {
				var target = $(this);
				if(target.find('ul li:visible').size() == 0) {
					target.hide();
				} else {
					target.show();
				}
			});
			if (faceid != '') {
				parent.window.location.hash = faceid;//定位到第一个人的位置
			}

		});
		$("#a_title").bind('keypress', function(e) {
			if(e.keyCode == 13) {
				$(".shoutbtn", parent.document).trigger('click');
			}
			return false;
		});

		parent.window.H.remove('wxDialog');
		$('#wxDialog',parent.window.document.body).remove();
		parent.window.H.create(new P({
			id:'wxDialog',
			title:'选择助教',
			easy:true,
			content:$("#wxDialog")[0]
		}),'common');


		$("#assistant").bind('click', function(e) {
			if (e.target.nodeName.toLowerCase() == 'span') {
				var oTarget = $(e.target);
				var assistant = $(this).find("input[name='assistantid']");
				if (oTarget.hasClass('languan')) {
					$(this).css('background-color', '#fff');
					assistantBox.addClass('la');
					assistantBox.html('添加');
					assistantValue.val('');
					deleteBtn.hide();
					return false;
				}
				parent.window.H.get('wxDialog').exec('show');

			}
		});
		<?php } ?>
				//向学生提问，选学生
(function($) {
	var page = 1;
	var finished = false;
	var loading = false;
	function ajaxStudents(args, box) {
		if (args.page > 1) {
			loading = true;
		}
		$.ajax({
			url: '/troomv2/classcourse/ajax_students.html',
			data: args,
			dataType: 'json',
			type: 'get',
			cache: false,
			success: function(ret) {
				var ul = box.find('div.designatedstudent-right ul');
				if (ret) {
					var l = ret.length;
					var html = [];
					for(var i = 0; i < l; i++) {
						html[i] = '<li uid="' + ret[i].uid + '" username="' + ret[i].showname + '">'
							+ '	<div><img class="designatedstudenthead" src="' + ret[i].photo + '"></div>'
							+ '	<p class="designatedstudentname"'+ (ret[i].showname ? ' title="'+ ret[i].showname + '"' : '') + '>' + ret[i].shortname + '</p>'
							+ '</li>';
					}

					if (l < 35) {
						finished = true;
					}
					box.find('div.loading-1').hide();
					if (page == 1) {
						ul.html(html.join(''));
						return;
					}
					if (loading == false) {
						return;
					}
					loading = false;
					ul.append(html.join(''));
					return;
				}
				if (args.page == 1) {
					ul.empty();
				}
				box.find('div.loading-1').hide();
				ul.html('没有该学生！');
				finished = true;
			}
		});
	}
	$("#ask-for-students").bind('click', function() {
		finished = loading = false;
		page = 1;
		var studentDialog = dialog({
			id: 'student-dialog',
			title: '指定学生',
			content: $("#studentdiv").html(),
			fixed: true,
			padding: 0,
			onshow: function() {
				//绑定事件
				var that = this;
				var dia = $(this.node);
				finished = dia.find('div.designatedstudent-right ul li').size() < 35;
				dia.find("div.designatedstudent-right").scrollTop(0);
				dia.find("div.designatedstudent-left").scrollTop(0);
				dia.bind('click', function(e) {
					var t = $(e.target);
					//选择班级
					if (t.hasClass('class-1')) {
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						dia.find('.designatedstudent-left a.on').removeClass('on');
						t.addClass('on');
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						ajaxStudents({ 'cid': t.attr('cid'), 'page': page }, dia);
						return true;
					}
					//选择学生
					if (t.hasClass('designatedstudenthead') || t.hasClass('designatedstudentname')) {
						var li = t.parents('li');
						$("#ask-for-students span.show_studentname").html(li.attr('username').substring(0,8));
						$("#ask-for-students input[name='tid']").val(li.attr('uid'));
						that.close().remove();
						return true;
					}
					//点击搜索
					if (t.hasClass('soulico-1')) {
						//搜索学生
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						dia.find('.designatedstudent-left a.on').removeClass('on');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'page': page }, dia);
						return true;
					}
					return false;
				});
				//回车搜索
				dia.find('input.newsou-1').bind('keypress', function(e) {
					if (e.keyCode == 13) {
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						dia.find('.designatedstudent-left a.on').removeClass('on');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'page': page }, dia);
					};
				});
				//加载更多
				dia.find("div.designatedstudent-right").scroll(function(){
					if (finished || loading) {
						return;
					}
					dia.find('div.loading-1').show();
					var nScrollHight = $(this)[0].scrollHeight;
					var nScrollTop = $(this)[0].scrollTop;
					if(nScrollTop + $(this).height() >= nScrollHight)   {
						page++;
						var cid = dia.find('.designatedstudent-left a.on').attr('cid');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'cid': cid, 'page': page }, dia);
					}
				});
			}
		});
		studentDialog.showModal();
	});
})(jQuery);
	</script>
<?php $this->display('troomv2/page_footer'); ?>