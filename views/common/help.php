<?php
	$this->display('common/helps_common');
?>
<div class="details">
<?php
	$this->display('common/helps_left');
?>
<div class="rigku" style="border:none;">	
<script type="text/javascript">
<!--
	function toOrangeStep(step){
		outOrangeStep();
		$("#orangesetbar").addClass('step'+step);
	}
	function outOrangeStep(){
		$("#orangesetbar").removeClass('step1').removeClass('step2').removeClass('step3');
	}
	function toBlueStep(step){
		outOrangeStep();
		$("#Bluesetbar").addClass('step'+step);
	}
	function outBlueStep(){
		$("#Bluesetbar").removeClass('step1').removeClass('step2').removeClass('step3').removeClass('step4');
	}
//-->
</script>
<div class="blanknav">
<a class="blankmain" target="_blank" href="http://static.ebanhui.com/help/cz_issue.htm">
<span class="blanktitle">如何开通服务</span>
</a>
<a class="blankxue" target="_blank" href="http://static.ebanhui.com/help/bz_kech.htm">
<span class="blanktitle">如何学习课程</span>
</a>
<a class="blankzuo" target="_blank" href="http://static.ebanhui.com/help/bz_zuoye.htm">
<span class="blanktitle">如何完成作业</span>
</a>
<a class="blankdayi" target="_blank" href="http://static.ebanhui.com/help/dayiru.htm">
<span class="blanktitle">如何答疑</span>
</a>
<a class="blankczhi" target="_blank" href="http://static.ebanhui.com/help/bz_chzh.htm">
<span class="blanktitle">如何充值</span>
</a>
<a class="blankjifen" target="_blank" href="#">
<span class="blanktitle">积分计划</span>
</a>

</div>
	</div>
	<div class="yind">
	  <div class="modaas">
		<h2>快速引导</h2>
	  </div>
	<div class="ksyd">
	<h3 class="logmad">登录与密码</h3>
	<?php $reurl="javascript:tologin('".'/login.html?returnurl=__url__'."');"?>
	<p style="margin-top:5px;"><a href="<?= geturl('register')?>">注册</a> | <a href="<?= $reurl?>">登录</a> | <a href="<?= geturl('help/1361')?>">帐号开通</a> | <a href="/forget.html">忘记密码</a> | <a href="/member/setting/pass.html">修改密码</a></p>
	</div>
	<div class="ksyd">
	<h3 class="yunpingt">云教育网校</h3>
	<p style="margin-top:5px;"><a href="<?= geturl('cloudlist-1')?>">搜索教室</a> | <a href="<?= geturl('help/1384')?>">购买年卡</a> | <a href="<?= geturl('help/1361')?>">使用年卡</a> | <a href="<?= geturl('help/1364')?>">点击学习</a> | <a href="<?= geturl('help/1365')?>">续缴费用</a></p>
	</div>
	<div class="ksyd">
	<h3 class="yunzhongxin">云教育中心</h3>
	<p style="margin-top:5px;"><a href="<?= geturl('help/1377')?>">作业</a> | <a href="<?= geturl('help/1378')?>">批阅结果</a> | <a href="<?= geturl('help/1376')?>">听课笔记</a> | <a href="<?= geturl('help/1368')?>">原创作品</a> | <a href="<?= geturl('help/1366')?>">点评课件</a></p>
	</div>
	<div class="ksyd">
	<h3 class="qtwenti">其他问题</h3>
	<p style="margin-top:5px;"><a href="/down.html" target="_blank">下载播放器</a> | <a href="http://soft.ebanhui.com/ebhProjectV.zip">课件制作软件</a> | <a target="_blank" href="#">论坛</a> | <a href="/aboutus.html">关于e板会</a></p>
	</div>
	</div>
	<div class="yind">
	<a href="http://pay.ebh.net" target="_blank">
		<img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/2014/images/payad.jpg" />
	</a>
	</div>
	<div class="yind">
	<div class="modaas" style="float:left;width:730px;margin-bottom:0px;position: relative;">
			<h2>热点问题<a href="<?= geturl('faq')?>" style="position: absolute;right:10px;font-weight:normal;">+ 更多</a></h2>
	</div>
	
	<div class="maos rigku" style="border:none;padding-top:0px;">
	<?php foreach($itemlist as $value){ ?>
		<div class="wenti">
			<h3 class="wentit"><a href="<?= geturl('help/'.$value['itemid'])?>" title="<?= $value['subject']?>"><?= shortstr($value['subject'],30,'')?></a></h3>
			<p><span><?= shortstr($value['note'],30,'')?></span><a href="<?= geturl('help/'.$value['itemid'])?>">[阅读全文]</a></p>
		</div>
	<?php } ?>
	</div>
	</div>
	</div>	
</div>
<div style="clear:both;"></div>
<script type="text/JavaScript">
	var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
</script>
<?php
	$this->display('common/footer');
?>



