<?php $this->display('shop/mainschool/header'); ?>

<div class="dhtop">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhlianxi0411.jpg" /></a></li>
</ul>
</div>
</div>
<div style="clear:both"></div>
<div class="zzind">
<div class="fontxian">
<div class="lefzong">
<div class="dizitu">

<ul>
<li class="stes"> 地址：<?= $room['craddress']?></li>
<li class="paees">电话：<?= $room['crphone']?></li>
<!--<li class="uilian">
网址：<a href="<?= $room['url']?>"><?= $room['url']?></a>
</li>-->
<li class="elain">
邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a>
</li>
<?php if(!empty($room['crqq'])){?>
<li class="tsqq">
<span style="float:left;">Q  Q：</span>
<span class="qqwaik">
<a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqtan1123.jpg"></a>
</span>
</li>
<?php } ?>
</ul>
<?php if(!empty($room['lng']) && !empty($room['lat'])){?>
<div class="baidutu">
<div class="map">
	<div id="container">
	</div>
</div>
<script type="text/javascript">
var defaultZoom = 16;	//默认缩放比例
function loadScript() {
  var script = document.createElement("script");
  script.src = "http://api.map.baidu.com/api?v=1.4&callback=initialize";
  document.body.appendChild(script);
}
function initialize() {
  var mp = new BMap.Map('container');
  var point = new BMap.Point(<?= $room['lng']?>, <?= $room['lat']?>);
  mp.centerAndZoom(point, defaultZoom);
  mp.enableScrollWheelZoom();
  var marker = new BMap.Marker(point);
  mp.addOverlay(marker);
  mp.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //右上角，仅包含平移和缩放按钮
}
$(function(){
	loadScript();
});
</script>
</div>
<?php } ?>
</div>
</div>
<div class="lefadlo">
  <div class="xiaosa">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian01.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian02.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian03.jpg" />
</div>
<div class="fontsa">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian04.jpg" />
</div>
</div>
</div>
</div>
<div style="clear:both"></div>
<?php
$this->display('common/footer');
?>
