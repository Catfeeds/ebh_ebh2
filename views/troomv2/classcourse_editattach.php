<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />
<div class="lefrig">
<?php 
$dialog = $this->input->get('dialog');
if(empty($dialog)){
	$this->display('troomv2/course_menu');
}?>
<style>
.lanbtn,.huangbtn{
	line-height:21px !important;
	font-family: "宋体",Verdana,Arial,sans-serif;
	width:92px !important;
}
</style>
<form id="upform">
<input type="hidden" name="attid" value="<?= $attach['attid']?>" />
<table class="upload_tab" style="margin-top:20px;float:left;width:600px" width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<th><span class="star" style="margin-right:5px;"></span><label style="float: left; height: 45px; line-height: 20px;">附件名称：</label></th>
		<td><input class="uipt w295" id="title" onblur="checktit();" name="title" value="<?= $attach['title']?>" type="text" />
		<p class="ts" id="atttitle_msg" style="margin-bottom:5px;">请输入附件名称。</p>
		</td>
	  </tr>
	  <?php if(empty($dialog)){?>
	  <tr>
		<th><label style="float:right;margin-right:12px;">附件介绍：</label></th>
		<td><textarea class="w545 txt" id="message" name="message" style="resize:none;" rows="5" onblur="checkmessage(this.value)" maxlength="280"><?= $attach['message']?></textarea>
		<p class="ts" id="message_msg" style="margin-bottom:5px;">请输入附件的摘要信息，字数控制在10-280个字符之间。</p>
		</td>
	  </tr>
	  <?php }?>
		 <tr>
		 <th></th>
		<td>
			<input class="huangbtn" name="" type="button" value="保存修改" />
			<?php if(empty($dialog)){?>
			<input class="lanbtn marlef" onclick="window.location='javascript:history.go(-1)'" name="" value="返回" type="button" />
			<?php } else {?>
			<input class="lanbtn marlef" onclick="javascript:parent.window.dialog.get('coleck').remove();" name="" value="取消" type="button" />
			<?php }?>
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
				$("#atttitle_msg").html("<font color='red'>附件名称不能为空。</font>");
				return false;
			}
			$("#atttitle_msg").html("请输入附件名称。");
			return true;
		}

		function checkmessage(message){
			<?php if(empty($dialog)){?>
			var mess = false;
			<?php }else {?>
			return true;
			<?php }?>
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
			var url="<?= geturl('troomv2/classcourse/editattach') ?>";
			$.ajax({
				url:url,
				type:"post",
				dataType:"json",
				data:$("#upform").serialize(),
				success:function(data){
					if(data != undefined && data.status == 1) {
						dialog({
							skin:"ui-dialog2-tip",
							content: "<div class='TPic'></div><p>附件名称修改成功！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									<?php $selfrefresh = $this->input->get('selfrefresh');
									if(empty($selfrefresh)){?>
									var backurl = "<?= geturl('troomv2/classsubject/'.$course['folderid'])?>?classid=<?=$this->input->get('classid')?>";
									document.location.href = backurl;
									that.close().remove();
									<?php }else {?>
									window.parent.location.reload();
									<?php }?>
								}, 1000);
							}
						}).show();
					} else {
						dialog({
							skin:"ui-dialog2-tip",
							content: "<div class='FPic'></div><p>附件名称修改失败！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									that.close().remove();
								}, 2000);
							}
						}).show();
					}
				}
			});
		}

</script>
</div>
<?php $this->display('troomv2/page_footer'); ?>