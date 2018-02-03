<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('aroom/datasetting')?>">公告管理</a> > 修改公告</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<?php $this->display('aroom/datasetting_menu'); ?>
				<br/> 
		<form id="upform">
			<input type="hidden" name="infoid" value="<?= $send['infoid']?>" />		
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th><label>公告内容：</label></th>
				<td colspan="3">
					<textarea style="padding-left: 5px;line-height: 1.5;padding: 5px;height:190px;width:630px;" name="message" id="message" cols="80" rows="9" maxlength="500"  onblur="submit_check('message')"><?= $send['message'] ?></textarea>
					<p style="line-height:22px;color:#999999;padding-left:5px;"id="no">请输入公告内容，字数控制在5-500个字之间。</p>
				</td>
			  </tr>
			  <tr>
			  	<th></th>
				<td colspan="3"><input id="savebtn" class="huangbtn marrig" name="" value="保存" type="button" /><input type="button" onclick="window.location='javascript:history.go(-1)'" value="返回" name="" class="lanbtn">
			  </tr>
			 </table>
		 </form>
	</div>
<script type="text/javascript">
<!--
var subje = false;
var not = false;
function checkansilen(inputString){
	return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
}

function submit_check(message){
	
	var message = $("#"+message).val();
	if(message == "" || checkansilen(message)<5){
		$("#no").html("请输入公告内容，字数控制在5-500个字之间。");
		$("#no").css('color','red');
		return false;
	}
	else{
		$("#no").html("请输入公告内容，字数控制在5-500个字之间。");
		$("#no").css('color','#999999');
		return true;
	}
}
//-->
</script>
<script type="text/javascript">
<!--
$(function(){
		$("#message").keyup(function(){
			var num =$("#message").val();
			if(num.length>500){
			document.getElementById("message").value = document.getElementById("message").value.substring(0, 500);
			}
			return false;
		});
		$("#savebtn").click(function(){
			if(submit_check('message')) {
				var url="<?= geturl('aroom/datasetting/announcement/edit')?>";
				$.ajax({
					url:url,
					type: "POST",
					data:$("#upform").serialize(),
					dataType:"text",
					success:function(data){
						if(data == 'success') {
							$.showmessage({
								img : 'success',
								message:'修改公告成功',
								title:'修改公告',
								callback :function(){
									 document.location.href = "<?= geturl('aroom/datasetting') ?>";
								}
							});
						} else {
							$.showmessage({
								img : 'error',
								message:'修改公告失败，请稍后再试或联系管理员',
								title:'修改公告'
							});
						}
					}
				});
			}
		});
})
//-->
$(function(){
	$("div.tab_menu ul li:eq(0)").attr('class','workcurrent');
});
</script>
<?php $this->display('aroom/page_footer'); ?>