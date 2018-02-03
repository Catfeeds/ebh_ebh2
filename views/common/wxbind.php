<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/bdwei.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/stbact.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript">
function tip_message(message){
var left = $(".lbtbtn").offset().left - 10;
$(".warn").text(message);
$(".popflat").css("left",left);
$(".popflat").fadeIn("slow",function(){
window.setTimeout("$('.popflat').fadeOut('slow')",1000);
});
}

function form_submit(){
	var username=$.trim($("#username").val());
	if(username == ''|| username == '请输入e板会账号'){
		tip_message('帐号不能为空！');
		$('#username').focus();
		return;
	}
	var password=$.trim($("#password").val());
	if(password == ''){
		tip_message('密码不能为空。');
		$('#password').focus();
		return;
	}
	$.ajax({
		url		:'/wxbind/do_bind.html',
		data	: "code=<?= $code ?>&username="+username+"&password="+password,
		type	:'POST',
		dataType:'json',
		success	:function(json){
		if(json['code']==1){
			var html = 	'<div class="weibang">' +
						'账号绑定成功' +
						'</div>' +
						'<div class="bdico">' +
						'</div>' +
						'<div class="folten">' +
						'<p>最新的消息，您将可以通过微信来接收了。</p>' +
						'</div>';
			$("#ecp").html(html);
		}else{
			tip_message(json["message"]);
		}
			return false;
		}
	});
}
</script>
<title>手机详细消息</title>
</head>

<body>
<div id="ecp">
<div class="totls">
家长绑定
</div>
<div class="tefdt">
</div>
<form id="form1" name="form1"  onsubmit="form_submit();return false;">
<input class="txters" name="username" id="username" type="text" value="" />
<input type="hidden" value="1" name="loginsubmit">
<input type="hidden" value="<?= $code ;?>" name="code">
<input class="txtpadd" name="password" id="password" type="text" value="" />
<div class="popflat" style="display:none;">
<div class="mode">
<div class="warn">请输入账户名！</div>
</div>
</div>
<input class="lbtbtn" type="submit" value="立即绑定" name="submit">
</form>
</div>
</body>
</html>
