<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>e板会管理系统</title>
<style type="text/css">
	* { margin: 0; padding: 0;}
	body { background-color: #428dca; font: normal 12px Arial, Helvetica, sans-serif, "宋体";}
	#header { height: 80px; width: 411px; margin: 135px auto 0;}
	#container { background: url(http://static.ebanhui.com/ebh/admin/skins/orange/images/login_line_bg.gif) repeat-x center; height: 229px;}
	#footer { margin: 0.5em 0; text-align: center; font-size: 11px;}
	#formBox { margin: 0 auto; width: 411px; height: 229px; background: url(http://static.ebanhui.com/ebh/admin/skins/orange/images/login_bg.jpg) no-repeat; position: relative;}
	dl { width: 245px; position: absolute; left: 160px; top: 60px;}
	dl dt { margin-bottom: 10px; width: 65px; float: left; color: #3c5d88; padding: 2px 0; height: 18px; line-height: 18px;}
	dl dd { margin-bottom: 10px; width: 160px; float: left;}
	dl dd#btnWrap { padding-left: 65px;}
	input.text { border: 1px solid #bfd7f0; font-size: 12px; height: 18px; padding: 2px 3px; line-height: 18px; background: url(http://static.ebanhui.com/ebh/admin/skins/orange/images/login_input_text_bg.gif) no-repeat; width: 135px;}
	input#checkCode { width: 52px;}
	input.button,button.button { border: 0; width: 105px; height: 25px; background: url(http://static.ebanhui.com/ebh/admin/skins/orange/images/login_btn_bg.png) no-repeat; cursor: pointer; font-size: 13px; color: #3c5d88;}
	/*** 验证码 ***/
	#img_seccode{
		width:100px;
		height:30px;
		margin-left:7px;
	}
</style>
<script type="text/javascript">
var siteUrl = "";
if(self!=top){
	top.location=self.location;         //判断是否是顶层，不是则将当前页设置为顶层
} 
</script>
<script src="http://static.ebanhui.com/ebh/include/script/common.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
</head>
<body>
	<div id="header"><img src="http://static.ebanhui.com/ebh/admin/skins/orange/images/login_title.jpg" alt="" /></div>
	<div id="container">
		<div id="formBox">
		
		<form method="post" name="login" id="loginform" onsubmit="submitform();return false;"  action="">
		<input type="hidden" name="dologin" value="yes" />
			<dl>
				<dt>登录账号：</dt>
				<dd><input name="admin_username" type="text" id="admin_username" class="text" tabindex="1" /></dd><br style="clear: left;" />
				<dt>登录密码：</dt>
				<dd><input name="admin_password" type="password" id="admin_password" class="text" tabindex="2" /></dd><br style="clear: left;" />
				<dt>验 证 码：</dt>
				<dd style="width:170px"><input  name="seccode" type="text" id="checkCode" class="text" tabindex="3"><img style="cursor:pointer;" title="点击刷新" onclick="updatesecode()" border="0" id="img_seccode" src="<?php echo geturl('verify/getCode')?>" align="absmiddle"><br />
<a style="color:#2C629E;" href="javascript:updatesecode()">更换一张</a></dd><br style="clear: left;" />
                
				<dd id="btnWrap">
				<input name="dologinbtn" type="hidden" value="1" />
				<input type="submit" class="button" value="登录管理平台" /></dd>
			</dl><input type="hidden" name="returnurl" value="<?=$returnurl?>" />
		</form>
		</div>	
	</div>
	<div id="footer"><a href="http://www.ebanhui.com" target="_blank" style="color: #006"><b>e板会</b></a> {S_VER} &nbsp;&nbsp;&copy;2011 <a href="http://www.svnlan.com" target="_blank" style="color: #006">ZHEJIANG NEW SVNLAN TECHNOLOGY CO.,LTD.</a></p>
	<script>
	</script>
    <script type="text/javascript">
    function submitform(){
	
		if($("#admin_username").val()=='' || $("#admin_username").val()==null)
		{
			alert('账号不能为空！');
			$("#admin_username").focus();
			return false;
		}
		if($("#admin_password").val()=='' || $("#admin_password").val()==null)
		{
			alert('登录密码不能为空！');
			$("#admin_password").focus();
			return false;
		}
		if($("#checkCode").val()=='' || $("#checkCode").val()==null)
		{
			alert('验证码不能为空！');
			$("#checkCode").focus();
			return false;
		}
		var url = '<?php echo geturl('admin/login')?>';
		$.ajax({
			url:url,
			data:$("#loginform").serialize(),
			type:"POST",
			dataType:"json",
			success:function(json){
				if(json['code'] == 1){
					location.href = json['returnurl'];
				}else{
					updatesecode();
					alert(json['message']);
				}
				return false;
			}
		});
       
	};

	function updatesecode(){
		$("#img_seccode").attr('src',"<?php echo geturl('verify/getcode');?>"+'?'+Math.random());
		return ;
	}
    </script>
<?php
debug_info();
?>
</body>
</html>