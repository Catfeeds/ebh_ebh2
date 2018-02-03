<?php
$this->display('troomv2/page_header');
?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<!--<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>-->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="lefrig">
<div class="waitite">
	<div class="work_menu" style="position:relative;margin-top:0">
		<ul>
			<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">新建互动</span></a></li>
		</ul>
	</div>
</div>  
		<form id="upform">
			<span class="lsstspa">标题：</span>
				<div class="rsirhe">
					<textarea style="font-size:14px;color:#999;line-height: 1.5;padding: 5px;height:160px;width:820px;resize: none;border:solid 1px #e6e6e6;" name="title" id="message" rows="10" maxlength="500" onblur="submit_check('message')" onfocus="if(value=='请输入互动标题'){value=''}">请输入互动标题</textarea>
					<p style="line-height:22px;color:#999999;padding-left:5px;"id="no" >字数控制在5-100个字之间。</p>
				</div>
				<div style="clear:both;"></div>
			  <!-- ================ -->
			<span class="lsstspa">班级选择：</span>
			<div id="xuanban" class="xuanban" style="background:#fff;">
				<ul class="ulclass">
					<?php if(count($classes) == 1){?>
							<li><span style="display:inline-block;white-space:nowrap;border:1px solid #fff;"><input id="class_<?=$classes[0]['classid']?>" class="goxua"  type="checkbox" checked="checked" name="classes[]" title="" value="<?=$classes[0]['classid']?>"><label for="class_<?=$classes[0]['classid']?>"><?=$classes[0]['classname']?></label></span></li>
					<?php }else{?>
						<?php foreach ($classes as $class) {?>
							<li><span><input id="class_<?=$class['classid']?>" class="goxua"  type="checkbox" name="classes[]" title="" value="<?=$class['classid']?>"><label for="class_<?=$class['classid']?>"><?=$class['classname']?></label></span></li>
						<?php }?>
					<?php }?>
				</ul>
				<br style="clear:both" />
				<p class="fueetai" id="no" style="line-height:32px;">如果不选择班级，则您所教班级下的所有学生都能看到。</p>
			</div>
			<div style="clear:both;"></div>
			  <!-- ================ -->
			<span class="lsstspa">图片上传：</span>
			<div class="rsirhe">
					<?php
					    $Upcontrol->upcontrol('thumb',1,null,'iroom');
					?>
			</div>
			<div class="rsirhe">
				<input id="savebtn" class="fstiewes" name="" value="提交" type="button" />
				<input class="wrkrshui" name="" value="返回" type="button" onclick="window.location='javascript:history.go(-1)'"/>
			</div>
		 </form>
		 <div style="clear:both;"></div>
<script type="text/javascript">
<!--
var subje = false;
var not = false;
function checkansilen(inputString){
	return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
}

function submit_check(message){
	
	var message = $("#"+message).val();
	if(message == "" || checkansilen(message)<5 || checkansilen(message)>200 || message == '请输入互动标题'){
		$("#no").html("请输入互动标题，字数控制在5-100个字之间。");
		$("#no").css('color','red');
        if(message == ""){
            $("#message").val("请输入互动标题");
        }
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
		var submit_enabled = true;
		$("#savebtn").click(function(){
			if(submit_check('message')) {
				if (submit_enabled === false) {
					return false;
				}
				submit_enabled = false;
				var url="<?= geturl('troomv2/iaclassroom/add')?>";
				$.ajax({
					url:url,
					type: "POST",
					data:$("#upform").serialize(),
					dataType:"text",
					success:function(data){
						if(data > 0) {
							dialog({
								skin:"ui-dialog2-tip",
								content:"<div class='TPic'></div><p>添加成功！</p>",
								width:350,
								onshow:function () {
									var that=this;
									setTimeout(function () {
										document.location.href = "<?= geturl('troomv2/iaclassroom/view') ?>";
										that.close().remove();
									}, 1000);
								}
							}).show();
						} else {
							dialog({
								skin:"ui-dialog2-tip",
								content:"<div class='FPic'></div><p>添加失败，请稍后再试或联系管理员！</p>",
								width:350,
								onshow:function () {
									var that=this;
									setTimeout(function () {
										submit_enabled = true;
										that.close().remove();
									}, 1000);
								}
							}).show();

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