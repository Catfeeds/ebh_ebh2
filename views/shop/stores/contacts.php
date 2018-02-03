<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/contacts_common'); ?>
<div class="rigbian">
<h2 class="htitg">联系方式</h2>

<div class="dizi" style="padding:0;margin-top:10px;">
<ul>
<?php $url='http://'.$room['domain'].'.ebanhui.com'?>
<li class="jiage">
原价：<span style="text-decoration: line-through;">￥<?= $room['crprice']*2?></span>元<span style="color:red;margin-left:10px;">现价：</span><strong style="font-weight:bold;color:red;">￥<span><?= $room['crprice']*1?></span>元</strong>
</li>
<li class="stes">
地址：<?= $room['craddress']?>
</li>
<li class="paees">电话：<?= $room['crphone']?></li>
<li class="uilian">网址：<a href="<?= $url?>"><?= $url?></a></li>
<li class="elain">邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="tsqq"><span style="float:left;">Q&nbsp;&nbsp;Q：</span>
<?php if(!empty($room['crqq'])){ ?>
<span class="qqwaik"><a class="qqlx" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes" target="_blank"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/qqtan1123.jpg" /></a></span>
<?php } ?>
</li>
</ul>
<?php if(!empty($room['lng']) && !empty($room['lat']) && empty($room['fulldomain'])){?>
<div class="map">
	<div id="container">
	</div>
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
<?php } elseif(!empty($room['fulldomain']) && !empty($room['lng']) && !empty($room['lat'])) {?>
        <iframe src="http://<?=$room['domain']?>.ebh.net/map.html" height="320px" width="100%">
        </iframe>
        <?php }?>
</div>
</div>
</div>
<div class="fltkuang"></div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>