<?php
$this->display('troom/page_header');
?>
<style>
	.xuanban {width:620px;min-height:20px;background:url(http://static.ebanhui.com/static/images/topbgj1203.jpg) no-repeat;border:solid 1px #b1d1e7;padding:10px;overflow: hidden;}
	.xuanban .rbxht {height:38px;line-height:38px;font-weight:bold;border-bottom:solid 1px #e5e5e5;color:#2f59ab;}
	.xuanban li{color:#646464;height:35px;line-height:35px;font-size:14px;float:left;font-weight:bold;white-space: nowrap;margin-right:18px;display:inline;width:188px;}
	.goxua {float:left;margin-top:10px;_margin-top:6px;margin-right:5px;_margin-right:0px;cursor: pointer;}
	#upform td label{color:#646464;cursor: pointer;}
</style>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > 互动课堂 > 创建互动</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div style="margin-bottom:30px;"></div>   
		<form id="upform">	
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<th><label>互动标题：</label></th>
				<td colspan="3">
					<textarea style="padding-left: 5px;line-height: 1.5;padding: 5px;height:80px;width:630px;" name="title" id="message" rows="10" maxlength="500" onblur="submit_check('message')"></textarea>
					<p style="line-height:22px;color:#999999;padding-left:5px;"id="no" >请输入互动标题，字数控制在5-100个字之间。</p>
				</td>
			  </tr>
			  <!-- ================ -->
		<tr>
		<th><label>班级选择：</label></th>
			<td style="padding-top:14px">
	            	<div id="xuanban" class="xuanban" style="background:#fff;">
						<ul class="ulclass">
							<?php if(count($classes) == 1){?>
									<li><span><input id="class_<?=$classes[0]['classid']?>" class="goxua"  type="checkbox" checked="checked" name="classes[]" title="" value="<?=$classes[0]['classid']?>"><label for="class_<?=$classes[0]['classid']?>"><?=$classes[0]['classname']?></label></span></li>
							<?php }else{?>
								<?php foreach ($classes as $class) {?>
									<li><span><input id="class_<?=$class['classid']?>" class="goxua"  type="checkbox" name="classes[]" title="" value="<?=$class['classid']?>"><label for="class_<?=$class['classid']?>"><?=$class['classname']?></label></span></li>
								<?php }?>
							<?php }?>
						</ul>
						
					</div>
					 <p style="line-height:22px;color:#999999;padding-left:5px;"id="no" >如果不选择班级，则您所教班级下的所有学生都能看到。</p>
	        </td>
	       
   		 </tr>
			  <!-- ================ -->
			<tr>
				<th><label>图片上传：</label></th>
				<td>
					<?php
					    $Upcontrol->upcontrol('thumb',1,null,'iroom');
					?>
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
		$("#no").html("请输入互动标题，字数控制在5-100个字之间。");
		$("#no").css('color','red');
		return false;
	}else{
		$("#no").html("请输入互动标题，字数控制在5-100个字之间。");
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
				var url="<?= geturl('troom/iaclassroom/add')?>";
				$.ajax({
					url:url,
					type: "POST",
					data:$("#upform").serialize(),
					dataType:"text",
					success:function(data){
						if(data > 0) {
							$.showmessage({
								img : 'success',
								message:'添加成功',
								title:'操作提示',
								callback :function(){
									 document.location.href = "<?= geturl('troom/iaclassroom') ?>";
								}
							});
						} else {
							$.showmessage({
								img : 'error',
								message:'添加失败，请稍后再试或联系管理员',
								title:'操作提示'
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