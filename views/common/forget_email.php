<?php $this->display('common/forget_header')?>
<div class="awmbg">
  <div class="main" style="background:#fff;border:solid 1px #cdcdcd;width:820px;height:550px;">
  <p style="float:left;width:700px;font-size:24px;font-family: 微软雅黑;margin-left:85px;margin-top:20px;">忘记密码</p>
  	<div class="login_main">
		<div class="findpw">
			<div class="zhaohui">找回密码 <span>找回步骤：1、填写邮箱 > <em>2、邮箱确认</em> > 3、重设密码 > 4、找回成功</span></div>
			<p class="zhts">请到邮箱地址<b><?=$email?></b>收取来自e板会的邮件，按照提示继续下一步操作。感谢您对e板会的支持！</p>
			<?php 
			$url ='/';
			if(!empty($returnurl))
				$url = $returnurl;
			if($filename_name=='gmail.com'){?>
			<p class="here"><a href="http://www.gmail.com" target="_blank">马上去邮箱查看</a></p>
			<?php }else{?>
			<p class="here"><a href="http://mail.<?=$filename_name?>" target="_blank">马上去邮箱查看</a></p>
			<?php }?>
			<p class="tijiao"><input name="" style="cursor: pointer;" type="button" value="返回首页" onclick="javascript:window.location.href='<?=$url?>'" /></p>
		</div>
	</div>
	<?php $this->display('common/forget_right')?>
	<div class="clear"></div>
  </div>
  <div style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/fotbottg.jpg) no-repeat;margin:0 auto;width:820px;height:16px;"></div>
  </div>
<?php $this->display('common/site_footer')?>
