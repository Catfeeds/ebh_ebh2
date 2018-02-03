<?php $this->display('common/forget_header')?>
<div class="awmbg">
  <div class="main" style="background:#fff;border:solid 1px #cdcdcd;width:820px;height:550px;">
  <p style="float:left;width:700px;font-size:24px;font-family: 微软雅黑;margin-left:85px;margin-top:20px;">忘记密码</p>
  	<div class="login_main">
		<div class="findpw">
			<div class="zhaohui">找回密码 <span>找回步骤：1、填写邮箱 > 2、邮箱确认 > 3、重设密码 > <em>4、找回成功</em></span></div>
			<p class="zhts">恭喜您，密码已经修改成功，请重新登录！<span>如有其他问题，请及时联系客服。</span></p>
			</p>
			<?php
			$url = geturl('login');
			if(!empty($returnurl)) {
				$url = $returnurl;
			}
			?>
			<p class="tijiao"><input style="cursor: pointer;" name="" type="button" value="重新登录" onclick="javascript:window.location.href='<?=$url?>'" /></p>
		</div>
	</div>
	<?php $this->display('common/forget_right')?>
	<div class="clear"></div>
  </div>
  <div style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/fotbottg.jpg) no-repeat;margin:0 auto;width:820px;height:16px;"></div>
  </div>

<?php $this->display('common/site_footer')?>