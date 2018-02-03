<?php $this->display('common/forget_header')?>
<div class="awmbg">
  <div class="main" style="background:#fff;border:solid 1px #cdcdcd;width:820px;height:550px;">
  <p style="float:left;width:700px;font-size:24px;font-family: 微软雅黑;margin-left:85px;margin-top:20px;">忘记密码</p>
  	<div class="login_main">
		<div class="findpw">
			<div class="zhaohui">找回密码 <span>找回步骤：1、填写邮箱 > 2、邮箱确认 > <em>3、重设密码</em> > 4、找回成功</span></div>
			<p class="zhts">设置您的新密码</p>
			<p class="login_f">
			<form action="" method="post" onsubmit="return chkform(password,passwordtrue)">
			<input type="hidden" name="action" value="pwd">
				<div class="field">
					<label>　　　　　新密码：</label>
					<input id="password" name="password" type="password" onblur="pwd(this.value)"/>
					<em style="font-style: normal; padding-left: 15px" id="password1"></em>
				</div>
				<div class="field">
					<label>　　　　确认密码：</label>
					
					<input id="passwordtrue" name="passwordtrue" type="password" onblur="pwdtrue(this.value)" />
					<em style="font-style: normal; padding-left: 15px" id="passwordtrue1"></em>
				</div>
			<p class="tijiao"><input id="submitpwd" name="submitpwd" type="submit" style="cursor: pointer;" value="提交" /></p>
			</form>
		</div>
	</div>
	<?php $this->display('common/forget_right')?>
	<div class="clear"></div>
  </div>
  <div style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/fotbottg.jpg) no-repeat;margin:0 auto;width:820px;height:16px;"></div>
  </div>

<script type="text/javascript">
function pwd(password){
	if(password == ""){
		$("#password1").html("<font color=red>请输新密码！</font>");
		return false;
	}
	if(password.length < 6 ){
		$("#password1").html("<font color=red>密码位数不能低于6位！</font>");
		return false;
	}
	$("#password1").html("");
	return true;
}
function pwdtrue(passwordtrue){
	if(passwordtrue == ""){
		$("#passwordtrue1").html("<font color=red>请输入确认密码！</font>");
		return false;
	}
	if(passwordtrue.length < 6 ){
		$("#passwordtrue1").html("<font color=red>密码位数不能低于6位！</font>");
		return false;
	}
	 if(document.getElementById('password').value  != passwordtrue){
		$("#passwordtrue1").html("<font color=red>两次密码输入不一致！</font>");
		return false;
	}
	
	$("#passwordtrue1").html("");
	return true;
}
function chkform(password,passwordtrue){
	var password = $("#password").val();
	var passwordtrue = $("#passwordtrue").val();
	if(pwd(password)!=true || pwdtrue(passwordtrue)!=true){
		return false;
	}
	return true;
}
</script>
<?php $this->display('common/site_footer')?>