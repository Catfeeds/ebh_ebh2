<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>联系我们</title>
</head>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css?v=20150413"/>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20150827001" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2015121401"/>
<style>
.see{ background: #fff;border: 1px solid #e2e2e2;display: inline-block;left: 10px;padding: 10px 20px 20px;margin-top:10px;width: 919px;}
.see .title{ font-size:24px; color:#333; text-align:center;}
.see .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;}
#actor p{
	display:none!important;
}
.navlie {
	width: 920px;
	clear: #555;
	height: 220px;
	float: left;
	}
	.navlie .navlietit {
	height: 42px;
	line-height: 42px;
	border-bottom: dashed 1px #e7e7e7;
	font-size: 20px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
}
.martopbtm {
	margin: 10px 0;
}
.navlie img {
	float: left;
}
.navlie .tiwes {
	width: 775px;
	margin-left: 15px;
	float: left;
	font-size: 14px;
	display: inline;
	line-height: 1.8;
}
.yuedubtn {
	float: right;
	font-size: 14px;
	display: block;
	width: 60px;
	margin-right: 10px;
	height: 24px;
	line-height: 24px;
	background: url(http://static.ebanhui.com/portal/images/quanico.jpg) no-repeat left center;
	padding-left: 20px;
}
html,body {background:#f9f9f9;}
.dizitu{display:inline-block; height:auto !important;}
.zzind .lefzong{ width:960px;}
.lefzong .dizitu{ width:930px; border:none;}
.baidutu{width:926px;}
.lefzong .dizitu li{width:900px;}
.fontxian{ margin-top:10px; margin-bottom:15px;}
.lefzong .dizitu .elain {
    background:url("http://static.ebanhui.com/ebh/tpl/default/images/elain150629.jpg") no-repeat left 10px;
}
.tsqq1s{
	background:url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/qqkfico.png") no-repeat left 7px;
}
a.qqlx{
	background:url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/qqhtbj.png") no-repeat left center;
	display:block;
	float:left;
	width:65px;
	padding-left:25px;
	font-family:微软雅黑;
	font-size:12px;
	color:#215fc9;
	margin-right:15px;
}
</style>

<body>
<?php $this->display('shop/drag/topbar');?>
	
    <div class="banner" style="background:none;height:auto">
	<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
	<div style="clear:both;"></div>

		<?php $navlib = Ebh::app()->lib('Navigator');
		$navlib->getnavigator();
		?>
		
	<div style="clear:both;"></div>
	<div style="width:960px; margin:0 auto;">		
		<div class="zzind" style="margin-top:0;">
		<div class="fontxian">
		<div class="lefzong">
		<div class="dizitu" >

		<ul>
		<li class="stes"> 地址：<?= $room['craddress']?></li>
		<li class="paees">电话：<?= $room['crphone']?></li>
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
		if(empty($room['cremail'])){
			$room['cremail'] = $room['domain'].'.ebh.net';
		}
		?>
		<?= $prename ?>：<a href="<?= $pre.$room['cremail']?>"><?= $room['cremail']?></a>
		
		</li>

		<!--<li class="tsqq">
		<span style="float:left;">Q  Q：</span>
		<span class="qqwaik">
		<a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes">
		<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqtan1123.jpg"></a>
		</span>
		</li>-->
		<li class="tsqq1s">
		<span style="float:left;">客服：</span>
		<span class="qqwaik">
          <?php if(!empty($kefu)){foreach($kefu['kefuqq'] as $k=>$v){?>
		<a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v?>&amp;site=qq&amp;menu=yes">
            <?php echo !empty($kefu['kefu'][$k])?ssubstrch($kefu['kefu'][$k],0,8):'在线客服'?></a>
            <?php }} ?>
		</span>
		</li>
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
		
		</div>
		</div>
</div>
<script>
var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
</script>
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->
<?php $this->display('common/footer')?>




