<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
	body {
		margin:0;
	}
.baidutu{
	width: 925px;
	height: 315px;
}
.iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
.iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
</style>
</head>
<body>
<div class="baidutu">
	<div id="container" style="height:100%" >
	</div>

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

</body>
</html>