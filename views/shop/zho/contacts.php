<?php $this->display('shop/zho/header'); ?>
<div class="dhtopes">
<ul class="reygtds">
<li class="dhdanes" style="margin-left:90px;"><a href="/"></a></li>
<li class="dhdanes"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdanes"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdanes"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
<div style="clear:both"></div>
<div class="zzind">
<div class="fontxian">
<div class="lefzong">
<div class="dizitu">

<ul>
<li class="stes"> 地址：<?= $room['craddress']?></li>
<li class="paees">电话：<?= $room['crphone']?></li>
<!--
<li class="elain">
<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$prename = "邮箱";
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$prename = "主页";
	$pre = 'http://';
}else{
	$prename = '主页';
	$pre = '';
}
?>
<?= $prename ?>：<a href="<?= $pre.$room['cremail']?>"><?= $room['cremail']?></a>
<?php if($jx){?>
<a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3108282289&amp;site=qq&amp;menu=yes">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqtan1123.jpg"></a>
<a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2726192487&amp;site=qq&amp;menu=yes">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqtan1123.jpg"></a>
<?php }?>
</li>-->
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
<?php if(!empty($room['lng']) && !empty($room['lat']) && empty($room['fulldomain'])){?>
<div class="baidutu">
	<div id="container" style="height:100%" >
</div>
<style type="text/css">
.iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
.iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
</style>
<script type="text/javascript">
var defaultZoom = 16;	//默认缩放比例
var mp;//地图
var lng = '<?= $room['lng']?>';
var lat = '<?= $room['lat']?>';
var crname = '<?= $room['crname']?>';
var address = '<?=$room['craddress'] ?>';
lng = lng ? lng : 120.137383;
lat = lat ? lat : 30.279108;
crname = crname ? crname : 'e板会网校';
address = address ? address : '浙江省杭州市西湖区德力西大厦1号楼802F';

//标注json
var json = {title:crname,content:address,point:{lng:lng,lat:lat},isOpen:1,icon:{w:35,h:25,l:0,t:0,x:6,lb:10}};
//异步加载
function loadScript() {
  var script = document.createElement("script");
  script.src = "http://api.map.baidu.com/api?v=2.0&ak=H8Y9OO2Gt8C584uRpzC4LED4&callback=initialize";
  document.body.appendChild(script);
}
$(function(){
	loadScript();
});
//异步加载后回调 初始化
function initialize() {
  mp = new BMap.Map('container');
  addMarker(json);//向地图中添加marker
  mp.enableScrollWheelZoom();
	//右上角，仅包含平移和缩放按钮
  mp.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_SMALL})); 
   
}

////////////////////////////////

//创建marker
function addMarker(json){
      var point = new BMap.Point(json.point.lng,json.point.lat);
	  var iconImg = createIcon(json);
      //var marker = new BMap.Marker(point,{icon:iconImg});
	  var marker = new BMap.Marker(point);
      var info = createInfoWindow(json);
	  var label = new BMap.Label(json.content,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
	  mp.centerAndZoom(point, defaultZoom);
	  mp.addOverlay(marker);
	  marker.setLabel(label);
      label.setStyle({
                  borderColor:"#808080",
                  color:"#333",
                  cursor:"pointer"
      });
     
	marker.addEventListener("click",function(){
	    this.openInfoWindow(info);
    });
    info.addEventListener("open",function(){
	    marker.getLabel().hide();
    })
    info.addEventListener("close",function(){
	    marker.getLabel().show();
    })
	label.addEventListener("click",function(){
	    marker.openInfoWindow(info);
    })
	if(json.isOpen){
		label.hide();
		marker.openInfoWindow(info);
	}
}
//创建InfoWindow
function createInfoWindow(json){
  var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
  return iw;
}
//创建一个Icon
function createIcon(json){
	var icon = json.icon;
	//http://api0.map.bdimg.com/images/marker_red_sprite.png
	//http://map.baidu.com/image/us_cursor.gif
	var icons = new BMap.Icon("http://api0.map.bdimg.com/images/marker_red_sprite.png", new BMap.Size(icon.w,icon.h),{imageOffset: new BMap.Size(-icon.l,-icon.t),infoWindowOffset:new BMap.Size(icon.lb+5,10),offset:new BMap.Size(icon.x,icon.h)})
	return icons;
}
</script>
</div>
<?php } elseif(!empty($room['fulldomain']) && !empty($room['lng']) && !empty($room['lat'])) {?>
        <iframe src="http://<?=$room['domain']?>.ebh.net/map.html" height="320px" width="100%">
        </iframe>
        <?php }?>
</div>
</div>
<div class="lefadlo">
  <div class="xiaosa">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian01.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian02.jpg" />
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian03.jpg" />
</div>
<?php if(!$jx) { ?>
<div class="fontsa">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/adlian04.jpg" />
</div>
<?php } ?>
</div>
</div>
</div>
<div style="clear:both"></div>
<?php
$this->display('common/footer');
?>
