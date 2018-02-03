<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />		
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/subject') ?>">课程列表</a> > <a href="<?= geturl('troom/subject/'.$course['folderid'])?>"><?= $course['foldername']?></a> > 修改附件
</div>
<div class="lefrig">
<div class="annotate">在此页面中,教师可对课件的附件进行修改、删除等操作.</div>
<form id="upform">
<input type="hidden" name="attid" value="<?= $attach['attid']?>" />
<table class="upload_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<th><span class="star" style="margin-right:5px;"></span><label style="float: left; height: 45px; line-height: 20px;">附件标题：</label></th>
		<td><input class="uipt w295" id="title" onblur="checktit();" name="title" value="<?= $attach['title']?>" type="text" />
		<p class="ts" id="atttitle_msg" style="margin-bottom:5px;">请输入附件标题。</p>
		</td>
	  </tr>
	  <tr>
		<th>&nbsp;&nbsp;<label>附件介绍：</label></th>
		<td><textarea class="w545 txt" id="message" name="message" style="resize:none;" rows="5" onblur="checkmessage(this.value)" maxlength="280"><?= $attach['message']?></textarea>
		<p class="ts" id="message_msg" style="margin-bottom:5px;">请输入附件的摘要信息，字数控制在10-280个字符之间。</p>
		</td>
	  </tr>
		 <tr>
		 <th></th>
		<td><input class="huangbtn" name="" type="button" value="保存修改" />
			<input class="lanbtn marlef" onclick="window.location='javascript:history.go(-1)'" name="" value="返回" type="button" />
		</td>
	  </tr>
</table>
</form>
<div class="clear"></div>
<script type="text/javascript">
<!--
		function checktit(){
			var title = $.trim(HTMLDeCode($("#title").val()));
			if(title==''){
				$("#atttitle_msg").html("<font color='red'>附件标题不能为空。</font>");
				return false;
			}
			$("#atttitle_msg").html("请输入附件标题。");
			return true;
		}

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
		function check_attachment(){
				if(checktit()!=true || checkmessage($('#message').val()) !=true){
					return false;
				}
//		}

			return true;
		}
		$(function(){
			$(".huangbtn").click(function(){
				if(check_attachment()) {
					submitform();
				}
			});
		});
		function submitform() {
			var url="<?= geturl('troom/course/editattach') ?>";
			$.ajax({
				url:url,
				type:"post",
				dataType:"json",
				data:$("#upform").serialize(),
				success:function(data){
					if(data != undefined && data.status == 1) {
						$.showmessage({
							img		 : 'success',
							message  :  '附件修改成功',
							title    :      '附件修改',
							callback :    function(){
								var backurl = "<?= geturl('troom/subject/'.$course['folderid'])?>";
								document.location.href = backurl;
							}
						});
					} else {
						var message = "附件修改失败";
						$.showmessage({
							img		:'error',
							message :message,
							title   :'附件修改'
						});

					}
				}
			});
		}

</script>
</div>
<?php $this->display('troom/page_footer'); ?>