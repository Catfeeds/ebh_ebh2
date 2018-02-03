<?php $this->display('troom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/subject') ?>">课程列表</a> > <a href="<?= geturl('troom/subject/'.$course['folderid'])?>"><?= $course['foldername'] ?></a> > 上传附件
</div>
<div class="lefrig">
<div class="annotate">在此页面中，教师可以上传附件。</div>
	<div class="user_config">
	<form id="upform">
	<input type="hidden" value="<?= $course['cwid'] ?>" name="cwid" />
	<table class="user_config_tab" width="100%">
	  <tr>
		<th>课件名称：</th>
		<td>
			<p style="font-size:14px; padding-top:4px; _padding-top:1px;"><?= $course['title'] ?></p>
			
		</td>
	  </tr>
	  <tr>
		<th>附件名称：</th>
		<td><input class="uipt w340" id="title" onblur="checktit();" name="title" maxlength="25" type="text" />
		<span class="ts2" id="atttitle_msg">请输入附件标题。</span>
		</td>
	  </tr>
	  <tr>
		<tr>
		<th valign="top">附件上传：</th>
		<td>
			<?php $upcontrol->upcontrol('up',4); ?>
			<span class="ts2" id="att_msg">请上传附件文件，文件大小不超过300M。</span>
		</td>
	  </tr>
	  
		<tr>
		<th valign="top">附件介绍：</th>
		<td style="padding-top:14px"><textarea id="message" style="resize:none;" name="message" rows="5" onblur="checkmessage(this.value)" maxlength="280"></textarea>
		<p class="ts" id="message_msg">请输入附件的摘要信息，字数控制在10-280个字符之间。</p>
		</td>
	  </tr>
		 <tr>
		 <th></th>
		<td style="padding-bottom:5px;padding-top:5px;">
		<input class="huangbtn" name="" type="button" value="提 交" />
		<input type="button" value="返 回" onclick="window.location='javascript:history.go(-1)'"  class="lanbtn marlef">
		</td>
		</tr>
	</table>
</form>
</div>
</div>
<script type="text/javascript">
<!--
	function checkatt(){
		var path = $("#up\\[upfilesize\\]").val();
			if(path==''){
				$("#att_msg").html("<font color='red'>请上传附件文件。</font>");
				return false;	
			}
			$("#att_msg").html("请上传附件文件。");
			return true;
		}
		function checktit(){
			var title = $.trim(HTMLDeCode($("#title").val()));
			if(title==''){
				$("#atttitle_msg").html("<font color='red'>附件标题不能为空。</font>");
				return false;
			}
			$("#atttitle_msg").html("请输入附件标题。");
			return true;
		}
//		function checkansilen(inputString){
//			return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
//		}
		function checkmessage(message){
			var mess = false;
			var message = $.trim(HTMLDeCode($("#message").val()));
			var len = message.length;
			if(message == "" || len<10 || len>280){
				$("#message_msg").html("请输入附件的摘要信息，字数控制在10-280个字符之间。");
				$("#message_msg").css('color','red');
				mess = false;
			}
			else{
				$("#message_msg").html("请输入附件的摘要信息，字数控制在10-280个字符之间。");
				$("#message_msg").css('color','#999999');
				mess = true;
			}
			return mess;
		}
		function check_attachment(noattmsg){
			if(noattmsg == 'noatt'){
				if(checktit()!=true){
					return false;
				}
			}else{
				if(checkatt()!=true || checktit()!=true || checkmessage($('#message').val()) !=true){
					return false;
				}
			}

			return true;
		}

		var uploadComplete = function(file){
			var showname = file['name'].replace(file['type'],'');
			var title = $('#title');
			if(title.length>0 && title.val()==''){
				title.val(showname);
			}
			top.resetmain();
		}
		$(function(){
			$(".huangbtn").click(function(){
				if(check_attachment()) {
					submitform();
				}
			});
		});
		function submitform() {
			var url="<?= geturl('troom/course/upattach') ?>";
			$.ajax({
				url:url,
				type:"post",
				dataType:"json",
				data:$("#upform").serialize(),
				success:function(data){
					if(data != undefined && data.status == 1) {
						$.showmessage({
							img		 : 'success',
							message  :  '附件上传成功',
							title    :      '附件上传',
							callback :    function(){
								var backurl = "<?= geturl('troom/subject/'.$course['folderid'])?>";
								document.location.href = backurl;
							}
						});
					} else {
						var message = "附件上传失败";
						$.showmessage({
							img		:'error',
							message :message,
							title   :'附件上传'
						});

					}
				}
			});
		}
//-->
		var fileQueued = function(file){
			if(file['size'] > 1024*1024*300){
				$.showmessage({
                    img : 'error',
                    message:'上传失败，文件大小不能超过300M。',
                    title:'上传课件'
                });
				up_swfu.cancelUpload(file['id']);
			}
		}
var fileQueueError = function(file,code,message){
			$.showmessage({
                    img : 'error',
                    message:'上传失败，文件大小不能超过300M。',
                    title:'上传课件'
                });
		}
</script>
<?php $this->display('troom/page_footer'); ?>