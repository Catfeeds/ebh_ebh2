<?php
$menuactiveid=5;
$this->display('common/header');
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/mtop.css" />
<div class="mtop">
<div class="rollad" id="imgPlay">
<ul class="imgs" id="actor" style="height:225px;">
			<?php foreach($adlist as $adkey=>$ad) {?>
			<li<?= $adkey==0?'':' style="display:none"'?>>
			<a title="" href="javascript:void(0);">
				<img width="960" height="260"  alt="<?= $ad['subject']?>" title="<?= $ad['subject']?>" src="<?= $ad['thumb']?>" /><p style="color:#ffffff;" ><?= $ad['subject']?></p>
			</a>
			</li>
			<?php } ?>
		</ul>
 </div>
  <div class="swot">
  <h2 class="tit" style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/tit_swot.png) no-repeat;"></h2>
  <ul>
 	<li class="ad01" onmouseover="this.className='sweep1'" onmouseout="this.className='ad01'"></li>
 	<li class="ad02" onmouseover="this.className='sweep2'" onmouseout="this.className='ad02'"></li>
	<li class="ad03" onmouseover="this.className='sweep3'" onmouseout="this.className='ad03'"></li>
	<li class="ad04" onmouseover="this.className='sweep4'" onmouseout="this.className='ad04'"></li>
  </ul>
  </div>
  <div class="flow">
  <h2 class="tit" style=" background:url(http://static.ebanhui.com/ebh/tpl/2012/images/tit_flow.png) no-repeat;"></h2>
  <img src="http://static.ebanhui.com/ebh/tpl/2012/images/flow_tu.png" />
  </div>
  <div class="fot">
  <div class="fot_left">
  <div class="introd">
  <h2 class="tit" style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/tit_introd.png) no-repeat;"></h2>
  <p>e板会·开放平台是一个基于e板会云计算中心的对外开放的资识库分享、课件调度、双向交互、信息订阅平台。为合作企业提供海量的资源、精准的学习用户群体、以及随时随地交互性信息传播渠道。您可以登录平台创建应用，使用“e板会”提供的接口，创建个性化应用，让您的应用系统、网站具有更广的在线资源交流。</p>
  </div>
  <div class="coop">
  <h2 class="tit" style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/tit_coop.png) no-repeat;"></h2>
  <ul>
  <li class="ico_log">
  <h3>1、账号登录</h3>
  <p>使用“e板会”账号访问你的网站，分享内容，同步信息。可以带入“e板会”学习平台中的活跃用户，提升网站的用户数和访问量。</p></li>
    <li class="ico_module">
  <h3>2、e板组件</h3>
  <p>将“e板会”的内容输出到第三方网站，用户在第三方网站互动和创造内容，同时分享内容、同步信息到“e板会”。快速部署，零开发成本的接入方案，适合绝大多数网站。</p></li>
    <li class="ico_port">
  <h3>3、移动接口</h3>
  <p>“e板会”提供接口，第三方wap和客户端可以通过“e板会”提供的移动接口，随时随地获得知识、分享信息，满足手机用户和平板电脑用户的需求。</p></li>
    <li class="ico_use">
  <h3>4、站内应用</h3>
  <p>直接嵌入“e板会”网站，以http://apps.ebanhui.com/个性域名的地址被用户访问，并可深度整合“e板会”众多推广资源和传播渠道帮助你构建互动社会关系。</p></li>
  </ul>
  </div>
  </div>
  
  <div class="fot_rig">
  <div class="fae">
  <h2 class="tit" style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/tit_fae.png) no-repeat;"></h2>
  <ul>
  <li class="ico_api">
  <h3>API文档</h3>
  <p>API接口描述及说明文档，包括基础数据API、搜索API和位置信息API。</p></li>
    <li class="ico_sdk">
  <h3>SDK下载：</h3>
  <p>开发工具包，包括Adobe Air、PHP、Python、Java等流行语言。</p></li>
    <li class="ico_isuse">
  <h3>常见问题：</h3>
  <p>开发，审核，接口权限、应用调优等常见问题。</p></li>
    <li class="ico_luntan">
  <h3>交流论坛：</h3>
  <p>开发者技术交流园地，提供运营商务支持。</p></li>
  </ul>
  </div>
  <div class="faq">
    <h2 class="tit" style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/tit_faq.png) no-repeat;"></h2>
	<h3>“e板会”提供专业的技术支持，帮助您解决应用创建中的各类问题。</h3>
	<p>1、24小时客服代表服务，解决基本问题。</p>
	<p>2、8*5工作时间直接上门，解决个性化问题。</p>
	<p>3、“e板会”论坛在线互动交流，解决典型疑难问题。</p>
  </div>
  </div>
  </div>
</div>
<div style="clear:both;"></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/effect_commonv1.1.js" ></script>
<script type="text/javascript" >new dk_slideplayer("#actor",{width:"960px",height:"260px",fontsize:"12px",time:"5000"});</script>
<?php
	$this->display('common/footer');	
?>