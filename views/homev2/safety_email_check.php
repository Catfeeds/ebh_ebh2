<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/personal.css<?=getv()?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>e板会-邮箱验证</title>
</head>
<body>
<?php if($info['code']==1){?>
<div class="khster">
	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/yansche1.jpg" />
	<div class="klretes">
    	<p class="ystzhi">您的邮箱验证成功，<span class="yanslan"><em id="nums">3</em>s</span>后直接跳转</p>
        <a href="javascript:;" class="astbtn doskipbtn">安全设置</a><span class="diansrh">点击可直接跳转</span>
    </div>
</div>
<?php }else{?>

<div class="khster">
	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/aynse1.jpg" />
	<div class="klretes">
    	<p class="ystzhi"><?=$info['msg']?> ，请重新操作，<span class="yanslan"><em id="nums">3</em>s</span>后直接跳转</p>
        <a href="javascript:;" class="astbtn doskipbtn">安全设置</a><span class="diansrh">点击可直接跳转</span>
    </div>
</div>

<?php }?>
<script type="text/javascript">
$(function(){

	$(".doskipbtn").bind("click",function(){
		location.href="/homev2/safety/index.html";
	});
	$(document).ready(function(){
		var timer = setInterval(function(){
			var nums = parseInt($("#nums").html());
			if(nums==0){
				clearInterval(timer);
				$(".doskipbtn").trigger("click");
				}else{
					nums--;
					$("#nums").html(nums);
					}
			},800);
	});

});
</script>
</body>
</html>
