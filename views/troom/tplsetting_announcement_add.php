<?php
$this->display('troom/page_header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/tplsetting/announcement/add') ?>">公告管理</a> > 添加公告</div>
<div class="lefrig">
<?php $this->display('troom/tplsetting_menu'); ?>
				<div class="annotate" style="color:#888888; margin-left: 20px;">在此页面中，您可以发布公告。</div>
				<br/>      
		<form id="upform">	
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<th><label>公告内容：</label></th>
				<td colspan="3">
					<textarea style="padding-left: 5px;line-height: 1.5;padding: 5px;height:190px;width:630px;" name="message" id="message" rows="10" maxlength="500" onblur="submit_check('message')"></textarea>
					<p style="line-height:22px;color:#999999;padding-left:5px;"id="no" >请输入公告内容，字数控制在5-500个字之间。</p>
				</td>
			  </tr>
			  <tr>
			  	<th></th>
				<td colspan="3"><input id="savebtn" class="huangbtn marrig" name="" value="提交" type="button" /><input class="lanbtn" name="" value="返回" type="button" onclick="window.location='javascript:history.go(-1)'"/></td>
			  </tr>
			 </table>
		 </form>
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
				var url="<?= geturl('troom/tplsetting/announcement/add')?>";
				$.ajax({
					url:url,
					type: "POST",
					data:$("#upform").serialize(),
					dataType:"text",
					success:function(data){
						if(data == 'success') {
							$.showmessage({
								img : 'success',
								message:'添加公告成功',
								title:'添加公告',
								callback :function(){
									 document.location.href = "<?= geturl('troom/tplsetting') ?>";
								}
							});
						} else {
							$.showmessage({
								img : 'error',
								message:'添加公告失败，请稍后再试或联系管理员',
								title:'添加公告'
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
<?php $this->display('troom/page_footer'); ?>