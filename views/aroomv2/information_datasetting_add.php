<?php
$this->display('troom/page_header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>


<div class="">
	<div class="ter_tit">
        当前位置 > <a href="<?= geturl('aroomv2/information/datasetting') ?>">信息管理</a> > 公告设置
    </div>
	<form id="upform">	
    <div class="gonggao mt15">
    	<textarea class="khstfd" name="message" id="message" maxlength="500" onblur="submit_check('message')"></textarea>
        <p id="no" style="line-height: 22px; padding-left: 5px; color: #999;">请输入公告内容，字数控制在5-500个字之间。</p>
     	<div class="button" style="margin-top:0;">
     		<input id="savebtn" class="huangbtn" type="button" value="确定">
			<input class="lanbtn ml15" type="button"value="取消" onclick="window.location='javascript:history.go(-1)'">
     	</div>        
    </div>
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
				var url="<?= geturl('aroomv2/information/datasetting/add')?>";
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
									 document.location.href = "<?= geturl('aroomv2/information/datasetting') ?>";
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
<?php $this->display('aroomv2/page_footer'); ?>