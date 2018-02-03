<?php $hideebhinfo = false;
if($roominfo['domain'] == 'jx')
	$hideebhinfo = true;?>
<?php $this->display('common/site_header');?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css" rel="stylesheet" type="text/css" />
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat-y scroll 0 0; height:auto;">
<div class="main" <?php if($roominfo['domain']=='xsyz'){echo 'style="height:auto;overflow:hidden;"';}else{echo 'style="height:500px;overflow:hidden;"';}?>>
<div class="aed"><p>欢迎开通<?=$hideebhinfo?'':'e板会'?>【<?= $roominfo['crname']?>】服务</p></div>
  <div class="slst" <?php if($roominfo['domain']=='xsyz'){echo 'style="height:auto;padding-bottom:65px;"';}else{echo 'style="height:420px;"';}?>><p style="font-weight: bold;padding-top: 15px;padding-left: 35px; color:#666666">帐号开通流程： </p>
    <label>
    <input class="tianxie2" style="cursor:pointer" type="submit" name="tianxie" value="1、填写个人资料" />
    <img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />    </label>
    <label>
    <input class="xuanze" style="cursor:pointer" type="submit" name="xuanze" value="2、选择开通方式" />
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />
    </label>
    <label>
    <input class="kaitong2" style="cursor:pointer" type="submit" name="kaitong" value="3、开通成功" />
    </label>

	<?php if($roominfo['domain']=='xsyz'){?>
			<div class="suc" style="height:auto"><p style="padding-top:80px;">您好 <?= $user['username'] ?> ，您已成功开通<?= $roominfo['crname']?>服务。</p>
			      <p style="line-height:3">现在您可以点击<label>
					  	<input style="cursor:pointer;margin:0;" type="button" onclick="window.location.href='<?= 'http://'.$roominfo['domain'].'.ebanhui.com/myroom.html'?>'" name="dengl" class="dengl"  value="马上学习" />
				  </label> 进入学习中心。</p>
				  
				  <div style="text-align:center;margin:40px 0 80px 0;"><img src="http://static.ebanhui.com/ebh/tpl/xsyz/xsyz.png"></div>
				  
			</div>
			</div>
	<?php }else{?>
			<div class="suc"><p style="padding-top:80px;">您好 <?= $user['username'] ?> ，您已成功开通<?= $roominfo['crname']?>服务。</p>
			     <p style="line-height:3">现在您可以点击<label>
					  	<input style="cursor:pointer;margin:0;" type="button" onclick="window.location.href='<?= 'http://'.$roominfo['domain'].'.ebanhui.com/myroom.html'?>'" name="dengl" class="dengl"  value="马上学习" />
				  </label> 进入学习中心。</p>
				 
			</div>
			</div>
	<?php }?>
	 <?php if($hideebhinfo)
		$this->display('common/site_right_jx');
	else
		$this->display('common/site_right'); ?>
</div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2012/images/doot5111.jpg">
</div>
</div>
<div style="clear:both;"></div>
<?php $this->display('common/site_footer'); ?>