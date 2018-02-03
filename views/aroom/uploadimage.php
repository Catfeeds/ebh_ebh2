<?php
$this->display('aroom/page_header');
$roominfo = Ebh::app()->room->getcurroom();
?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=3"></script>
<?php if($roominfo['template'] == 'plate'){ ?><script type="text/javascript" src="http://static.ebanhui.com/ebh/js/UploadImageAndThumb.js"></script><?php } ?>
<style type="text/css">
body { font-size:12px;background:#fff;}
.czhy_zx {
	margin:0;
	padding:0px 0px 20px 0px;
	line-height:19px;
	text-align:left;
	word-wrap:break-word;
}
.l {
	float:left;
}
.bb1d8 {
	border-bottom:1px solid #D8DFEA;
}
.mb10 {
	margin-bottom:10px;
}
.f13 {
	font-size:13px;
}
.yl1 {
	background:url(http://static.ebanhui.com/ebh/images/avatar/yltx_bg_120.gif) no-repeat scroll 0 0;
	float:left;
	padding:7px 12px 12px 7px;
}
.mb5 {
	margin-bottom:5px;
}
.xzhy1 {
	background:#FFFFFF;
	padding:4px 0;
}
.c9, a.c9 {
	color:#999999;
	font-family:Arial;
}
input, textarea {
	font-size:12px;
	padding:3px;
}
.rb1, .rb2 {
	background:none repeat scroll 0 0 #3D89BD;
	border-color:#3D89BD;
	border-left:1px solid #3D89BD;
	border-style:solid;
	border-width:1px;
	color:#FFFFFF;
	cursor:pointer;
	font-size:14px;
	height:25px;
	padding:3px 10px;
	padding:3px 0px \9;
}
.gb1, .gb2 {
	background:none repeat scroll 0 0 #E5E5E5;
	border-color:#FFFFFF #6A6A6A #6A6A6A #FFFFFF;
	border-left:1px solid #FFFFFF;
	border-style:solid;
	border-width:1px;
	color:#333333;
	cursor:pointer;
	font-size:14px;
	height:25px;
	padding:3px 10px;
	padding:3px 0px \9;
}
img {
	border: none;
}
table, td {
	border:0 none;
	border-collapse:collapse;
	font-size:12px;
	margin:0;
	padding:0;
}
.Overlay {
	background-color:#CCCCCC;
}
.Canvas {
	border:2px solid #888888;
	cursor:pointer;
	height:266px;
	margin-left:4px;
	overflow:hidden;
	position:relative;
	width:284px;
}
.upipt{
	width:228px;
}
.upiptfile{
	height:30px;
	width:310px;
	position:absolute;
	top:55px;
}
.upipt,.upiptfile{
	cursor:pointer;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(function(){
		var img = '';
		if(img.length>0){
			parent.changeimg(img);
		}
	});

//-->
</SCRIPT>
<?php
if(!empty($fname)){
	$newimg = true;
}else{
	$newimg = false;
}
if(!empty($sourceimg)){
	$_UP = Ebh::app()->getConfig()->load('upconfig');
	$showpath = $_UP['pic']['showpath'];
	$sourcepath = $showpath.$sourceimg;
}
else
	$sourcepath = 'http://static.ebanhui.com/ebh/images/nopic.jpg';

?>
<div class="uploadimg">
	<div id="photowrap"></div>
</div>
<div class="clear"></div>
<script language="javascript" type="text/javascript">

function saveimg(jres){
	jres = $.parseJSON(jres);
	if(jres.status != 0){
		alert('上传失败');
		return;
	}
	parent.changeimg(jres.url);
}
function goback(){
	var framewindow = parent.document.getElementById("imgFrame").contentWindow//.history.go(-1);
	framewindow.location.href = "<?=geturl('uploadimage/img')?>";
}

function cancelcallback(){
	parent.document.getElementById("cqbc").click();
}
//准备一个xPhoto实例(用时调用)
<?php if ($roominfo['template'] == 'plate') {
$config = Ebh::app()->getConfig()->load('upconfig');
$baseurl = $config['pic']['showpath'];
?>
var baseUrl = '<?=$baseurl?>';

function preparexPhoto(id,callback,initpicurl){
	var upurl = 'http://up.ebh.net/uploadimageandthumb.html';
	window.xphoto = new UploadImageAndThumb({
		id:id,
		title:'课程图片上传',
		callback:callback,
		height:500,
		initpicurl:initpicurl,
		upurl:encodeURIComponent(upurl),
		cancelcallback:function(){

		},
		/*sizearr:new Array('320_196'),
		 sizemsgarr:new Array('课程图片尺寸比例为180:110')*/
		sizearr:new Array('320_192'),
		sizemsgarr:new Array('课程图片尺寸比例为35:21')
	});
	window.xphoto.render();
}
preparexPhoto("photowrap", callback);

function msghandle(res){
	if(res && res.status == 0){
		parent.changeimg(res.data.thumb, baseUrl+res.data.thumb);
	}else{
		alert("上传失败");
	}
}

//flash消息通知处理接口(处理此函数的执行环境是父级框架,也就是说this为 parent.window)
function callback(res){
	res = $.parseJSON(res);
	msghandle(res);
};
<?php } else { ?>
$(function(){
	preparexPhoto("photowrap",saveimg,"<?=!empty($initurl)?$initurl:''?>");
});
function preparexPhoto(id,callback,initpicurl){
	var upurl = 'http://up.ebh.net/imghandler.html?type=pic&subtype=folderlogo';
	window.xphoto = new xPhoto({
		id:id,
		title:'封面上传',
		callback:callback,
		initpicurl:initpicurl,
		cancelcallback:cancelcallback,
		upurl:encodeURIComponent(upurl),
		sizearr:new Array('114_159'),
		sizemsgarr:new Array('图片尺寸为114*159'),
		height:500
	});
	window.xphoto.render();
}
<?php } ?>
</script>
</div>
</body>
</html>