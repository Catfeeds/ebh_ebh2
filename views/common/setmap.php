
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150518001" rel="stylesheet" type="text/css" />
<!-- <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20151103001"></script> -->
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xDialog.js?v=20150701001"></script>
	<style type="text/css">
	body {
		margin:0;
		background: #fff;
	}
	.scbtn{
	height:29px;
	line-height:25px;
	background:#6489ac;
	color:#fff;
	border:1px solid #6489ac;
	width:92px;
	letter-spacing: 3px;
	margin:7px 10px 10px 10px;
	cursor:pointer;
	float:right;
}
.iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
.iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
</style>
</head>
<body>
<p style="display: none;"><span class="kstgds">联系地址</span><span class="kstgds" id="craddress"><?= shortstr($myroom['craddress'],50) ?></span>
<input type="hidden" value="<?=$myroom['crphone']?>" id="fullphone"/>
<input type="hidden" value="<?=$myroom['craddress']?>" id="fulladdress"/>
<input type="hidden" id="lng" value="<?= $myroom['lng'] ?>" />
<input type="hidden" id="lat" value="<?= $myroom['lat'] ?>" />
<?php if(!empty($myroom['lng']) && !empty($myroom['lat'])) { ?>
	<a class="fkwtf" id="maptip" href="javascript:void(0)" onclick="setmap()">已标注</a>
<?php }else{?>
	<a class="fkwtf" id="maptip" href="javascript:void(0)" onclick="setmap()">未标注</a>
<?php }?>
</p>

	<div style="margin-bottom:5px;background: white;">
		地址：<input type="text" value="" id="txtMapSearchKey" name="txtMapSearchKey" class="binput" style="width:360px;height:22px;line-height:22px;margin-top:0px;font-size:12px;border: 1px solid #cdcdcd;" />&nbsp;&nbsp;<input type="button" value="" style="cursor:pointer;background:url(http://static.ebanhui.com/ebh/tpl/2012/images/dingwei1206.png) no-repeat;width:68px;height:22px;border:none;margin-top:0px;" onclick="search()" />
		
	</div>
	<div id="map" style="width:500px;height:325px"></div>
<div>
		  <div class="main_bot"></div>
		</div>
<input class="scbtn" style="" type="button" value="取消" onclick="closedialog('divMapLayer')" />
<input class="scbtn" style="" type="button" onclick="savemap('divMapLayer')" value="确定" />
<script>
$(function(){
	loadBdMap();
});

function closedialog(id){
	parent.H.get(id).exec('close');
}

/*****************百度地图2.0 eker**********************************/
var ismapinit = 0;	//是否已加载地图
var defaultZoom = 16;	//默认缩放比例
var mp;	//地图变量
var marker;
var oldaddress = '<?=$myroom['craddress']?>';
var addresschanged = false;

//异步加载 百度地图js
function loadBdMap(){
  var script = document.createElement("script");
  script.src = "http://api.map.baidu.com/api?v=2.0&ak=H8Y9OO2Gt8C584uRpzC4LED4&callback=initialize";
  document.body.appendChild(script);
}
	

//异步加载 初始化回调
function initialize() {
	mp = new BMap.Map('map');
	if ($("#lat").val() == "" || $("#lng").val() == "")
	{
		if ($("#fulladdress").val() != "")
		{
			$("#txtMapSearchKey").val($("#fulladdress").val());
			mp.centerAndZoom("杭州市",defaultZoom);
			//search();
		}
	} else {
		mp.centerAndZoom(new BMap.Point($("#lng").val(), $("#lat").val()),defaultZoom);
		marker = new BMap.Marker(new BMap.Point($("#lng").val(), $("#lat").val()),{enableDragging:true});
		mp.addOverlay(marker);
		$("#txtMapSearchKey").val($("#fulladdress").val());
	}


	//添加带有定位的导航控件
	// 添加定位控件
	var geolocationControl = new BMap.GeolocationControl();
	geolocationControl.addEventListener("locationSuccess", function(e){
	  // 定位成功事件
	  var address = '';
	  address += e.addressComponent.province;
	  address += e.addressComponent.city;
	  address += e.addressComponent.district;
	  address += e.addressComponent.street;
	  address += e.addressComponent.streetNumber;
	  console.log("当前定位地址为：" + address);
	});
	geolocationControl.addEventListener("locationError",function(e){
	  // 定位失败事件
	  alert(e.message);
	});
	mp.addControl(geolocationControl);
	
	mp.enableScrollWheelZoom();
	mp.setDefaultCursor("pointer");
	mp.addEventListener("click", setmarker);
	ismapinit = 1;
}
//点击事件
function setmarker(e) {
	$("hdnSetLng").val(e.point.lng);
	$("hdnSetLat").val(e.point.lat);
	if (marker != null)
	{
		mp.removeOverlay(marker);
	}
	marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat),{enableDragging:true});
	mp.addOverlay(marker);
}

function savemap(id){
	if (marker != null)
	{
		var curpoint = marker.getPosition();
		var lng = curpoint.lng;
		var lat = curpoint.lat;
		$("#lng").val(curpoint.lng);
		$("#lat").val(curpoint.lat);
		$.ajax({
			url:"<?= geturl('map/upinfo') ?>",
			type:'post',
			data:{'lng':lng,'lat':lat},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$("#maptip").html("已标注");
					location.reload(true);
				}else{
					alert('没有控制权');
				}
			}
		});
	}else{
		alert('请先快速定位');
	}
}
//搜索定位
function search() {
	var searchTxt = $("#txtMapSearchKey").val();
	if ( searchTxt== ""){
		alert("请输入要搜索的地址！");
		$("#txtMapSearchKey").focus();
	} else {
		// 创建地址解析器实例
    	var myGeo = new BMap.Geocoder();
    	// 将地址解析结果显示在地图上，并调整地图视野
    	myGeo.getPoint(searchTxt, function (point) {
    		if (point) {
    			mp.centerAndZoom(point, defaultZoom);
    			mp.removeOverlay(marker);
				marker = new BMap.Marker(new BMap.Point(point.lng, point.lat),{enableDragging:true});
				mp.addOverlay(marker);
    		}else{
    			alert("搜索不到结果");
    			}
    		}, "全国");
	}
}
function shortstr(str){
	var result = str.substr(0,25);
	if(result.length<str.length)
		result+= '...';
	return result;
}
</script>
</body>
</html>