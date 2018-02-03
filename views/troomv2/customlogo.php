<?php $this->display('troomv2/page_header')?>

<?php 
	if(!empty($fname)){
		$newimg = true;
	}else{
		$newimg = false;
		$fname = '';
		}
			
	if(!empty($sourceimg)){
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$showpath = $_UP['avatar']['showpath'];
		$sourcepath = $showpath.$sourceimg;
		}
	else if(!empty($sourcepath))
		;
	else
		$sourcepath = 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg';
?>

<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=6"></script>

<style type="text/css">
body { font-size:12px;}
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
	padding:3px 0px;
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
	top:80px;
}
.upipt,.upiptfile{
	cursor:pointer;
}
</style>
<script type="text/javascript">
<!--

$(document).ready(function(){
	var displays = "<?=$sourcepath?>";
	if(displays!='')
	{
		$("#caijian").show();
		$("#step2").show();
	}else
	{
		$("#choosePic").show();
		$("#step1").show();
	}
});

function up()
{
	var upfile = $("#UpFile").val();
	if(upfile == ''){
		return false;
	}
	alert(upfile);
	return true;
}
//-->
</script>

<div class="ter_tit">
当前位置 > <a href="<?=geturl('troomv2/setting/avatarold')?>">教室头像</a> > 自定义头像
</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">				
<div class="workol">

<div class="work_menu">
						<ul>
							<li class="workcurrent"><a href="<?=geturl('troomv2/setting/avatarold')?>"><span>自定义头像</span></a></li>
							<li><a href="<?=geturl('troomv2/setting/roomlogo')?>"><span>系统头像</span></a></li>
						</ul>
					</div>
			<div class="tab_box" style="border:none;">
		<div class="ecenter">
				<div id="photowrap"></div>

				<div class="clear"></div>
		</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
	
function saveimg(jres){
	jres = $.parseJSON(jres);
	if(jres.status != 0){
		alert('上传失败，你可以选择尝试其他方式');
		return;
	}
	$.ajax({
		url:'<?=geturl('troomv2/setting/avatarupdate')?>',
		type:'post',
		data:{'op':'logo','destshowpath':jres.url},
		success:function(res){
			parseres(res);
		}
	});
}

function parseres(res){
	if(res){
		alert("上传成功");
		location.reload();
	}else{
		alert("上传失败");
		location.reload();
	}
}

$(function(){
	preparexPhoto("photowrap",saveimg,"<?=$sourcepath?>");
});
function cancelcallback(){
	location.reload();
}
//准备一个xPhoto实例(用时调用)
function preparexPhoto(id,callback,initpicurl){
	window.xphoto = new xPhoto({
		id:id,
		title:'封面上传',
		callback:callback,
		initpicurl:initpicurl,
		cancelcallback:cancelcallback,
		upurl:'http://up.ebh.net/imghandler.html?type=avatar',
		sizearr:new Array('100_100'),
		sizemsgarr:new Array('图片尺寸为100*100')
	});
	window.xphoto.render();
}
</script>
<?php $this->display('aroom/page_footer')?>