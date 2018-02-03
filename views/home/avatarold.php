<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改头像</title>
	<link href="http://static.ebanhui.com/ebh/tpl/2012/css/user.css" rel="stylesheet" type="text/css" />
	<link href="http://static.ebanhui.com/ebh/tpl/2014/css/werke.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
</head>
<body>
<div class="topbaad">
<div class="user-main clearfix" style="background:none;">
	<div class="ter_tit" style="position: relative;">
	当前位置 > 个人信息 > 修改头像
	</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
	
<?php
	$this->assign('type','setting');
	$this->display('home/simplate_menu');
	?>
<div style="clear:both"></div>

<link href="http://static.ebanhui.com/ebh/tpl/2012/css/user.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
		<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
		
		<?php 
			if(!empty($fname)){
				$newimg = true;
			}else{
				$newimg = false;
			}
			
			if(!empty($sourceimg)){
				$_UP = Ebh::app()->getConfig()->load('upconfig');
				$showpath = $_UP['avatar']['showpath'];
				$sourcepath = $showpath.$sourceimg;
			}
			elseif(!empty($sourcepath))
			;
			else
				$sourcepath = 'http://static.ebanhui.com/ebh/tpl/default/images/tx120.jpg';

		?>
		
		
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
		</style>
		<div class="center">
			<div class="uploadimg">
			<form name="uploadfile" id="uploadfile" enctype="multipart/form-data" method="post" action="<?=geturl('home/profile/avatarold')?>">
				<input class="upipt" id="upipt" type="text" readonly="readonly" value="<?=!empty($fname)?$fname:''?>" />
				<div class="fileinput">
					<input type="file" class="upiptfile" id="UpFile" name="UpFile" />
					<input type="button" onclick="document.getElementById('UpFile').click()" value="浏览" class="upFileBtn" />
				</div>
				<input type="hidden" value="<?=geturl('home/profile/avatarold')?>" name="returnurl" />
				<input type="hidden" value="member" name="action" />
				<input type="hidden" value="setavatar" name="op" />
				<input type="hidden" value="upload" name="uptype" />仅支持JPG，PNG，GIF图片文件，且文件小于1M
			</form>
		</div>
		<div class="upimgl">
			<div style="width:290px; margin-right:20px;" class="l" id="step2">
			<form name="setavatar" id="setavatar" action="" method="post" >
				<input type="hidden" value="member" name="action" />
				<input type="hidden" value="setavatar" name="op" />
				<div class="bb1d8 mb5 f13"><b>裁切头像照片</b></div>
				<div  class="c9 xzhy1">您可以拖动照片以裁剪满意的头像</div>
				<div id="cut_div" class="Canvas">
					<table style="border-collapse: collapse; z-index: 10; filter: alpha(opacity=75); position: relative; left: 0px; top: 0px; width: 284px;  height: 266px; opacity: 0.75;" cellspacing="0" cellpadding="0" border="0" unselectable="on">
					<tbody>
						<tr>
							<td class="Overlay" colspan="3" style="height: 73px;"></td>
						</tr>
						<tr>
							<td class="Overlay" style="width: 82px;"></td>
							<td style="width: 120px; height: 120px; border: 1px solid white;"></td>
							<td class="Overlay" style="width: 82px;"></td>
						</tr>
						<tr>
							<td class="Overlay" colspan="3" style="height: 73px;"></td>
						</tr>
					</tbody></table>
					<img src="<?=$sourcepath?>" style="position:relative; top:-266px; left:0px" id="cut_img" />
				</div>
				
				<table cellspacing="0" cellpadding="0" <?php if(!$newimg)echo 'style="display:none;"'?>>
				<tbody>
					<tr>
						<td><img style="margin-top: 5px; cursor:pointer;"  src="http://static.ebanhui.com/ebh/images/avatar/less_c.gif" title="缩小" alt="图片缩小" onmouseover="this.src='http://static.ebanhui.com/ebh/images/avatar/less_h.gif'" onmouseout="this.src='http://static.ebanhui.com/ebh/images/avatar/less_c.gif'" onclick="imageresize(false)" /></td>
						<td><img id="img_track" style="width: 250px; height: 18px; margin-top: 5px" src="http://static.ebanhui.com/ebh/images/avatar/track.gif" /></td>
						<td><img style="margin-top: 5px; cursor:pointer;" src="http://static.ebanhui.com/ebh/images/avatar/add_c.gif" alt="图片放大" title="放大" onmouseover="this.src='http://static.ebanhui.com/ebh/images/avatar/add_h.gif'" onmouseout="this.src='http://static.ebanhui.com/ebh/images/avatar/add_c.gif'" onclick="imageresize(true)" /></td>
					</tr>
				</tbody></table>
				
				<img  id="img_grip" style="<?php if(!$newimg)echo 'display:none;'?>position:absolute; z-index:100; left:-1000px; top:-1000px; cursor:pointer;" src="http://static.ebanhui.com/ebh/images/avatar/grip.gif" />
				
				<div style="padding-top:15px; padding-left:5px;<?php if(!$newimg)echo 'display:none;'?>">
				<input type="hidden" name="actionc" id="actionc" value="cutsave" />
				<input type="hidden" name="cut_pos" id="cut_pos" value="" />
				<input type="hidden" name="url" value="<?=!empty($sourceimg)?$sourceimg:''?>" />
				<input type="hidden" value="update" name="uptype" />
				<input type="button" class="Btn118 pointer" id="submit" onclick="saveimg()" value=" 确认裁剪并提交 " />
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="centerBtn2 pointer" class="rb1" name="cancel" id="cancel" value="取消" onclick="javascript:history.back(1);"  />
				</div>
				
			</form>
			</div>
			
		</div>
		<div class="explanation">
			<h3>上传说明:</h3>
			<p>图片格式：支持jpg/png/jpeg/gif格式的图片</p>
			<p>图片大小：大小不要超过1M</p>
			<p>操作说明：选择你喜欢的照片，裁剪并提交即可</p>
			<h3>头像照片示例：</h3>
			<div class="Sample">
				<div class="tox120">
					<img class="tx120" src="http://static.ebanhui.com/ebh/tpl/default/images/tx120.jpg" alt="头像" />
				</div>
				<div class="samp">
					<h3>本人真实头像</h3>
					<p>清晰、正面、免冠</p>
					<p>近期拍摄</p>
					<p>登记照、生活照</p>
				</div>
			</div>
		</div>
		</div>
				<span style="margin-left:-50px;margin-top:200px;float:left;">如果无法上传头像,请尝试使用<a style="color:#49a0cb;" href="<?=geturl('home/profile/avatar')?>">摄像头上传模式</a></span>
		</div>

	</div>
	
<script language="javascript" type="text/javascript">
	var cut_div;  //裁减图片外框div
	var cut_img;  //裁减图片
	var imgdefw;  //图片默认宽度
	var imgdefh;  //图片默认高度
	var offsetx = 82; //图片位置位移x
	var offsety = -193; //图片位置位移y
	var divx = 284; //外框宽度
	var divy = 266; //外框高度
	var cutx = 120;  //裁减宽度
	var cuty = 120;  //裁减高度
	var zoom = 1; //缩放比例

	var zmin = 0.1; //最小比例
	var zmax = 10; //最大比例
	var grip_pos = 5; //拖动块位置0-最左 10 最右
	var img_grip; //拖动块
	var img_track; //拖动条
	var grip_y; //拖动块y值
	var grip_minx; //拖动块x最小值
	var grip_maxx; //拖动块x最大值
	
	
//图片初始化
function imageinit(){
	cut_div = document.getElementById('cut_div');
	cut_img = document.getElementById('cut_img');
	imgdefw = cut_img.width;
	imgdefh = cut_img.height;
	if(imgdefw > divx){
		zoom = divx / imgdefw;
		cut_img.width = divx;
		cut_img.height = Math.round(imgdefh * zoom);
	}

	cut_img.style.left = Math.round((divx - cut_img.width) / 2);
	cut_img.style.top = Math.round((divy - cut_img.height) / 2) - divy;
	var cutmin = (imgdefw>imgdefh?imgdefh:imgdefw);
//	if(cutmin > cutx){
	zmin = cutx / cutmin;
//}else{
//	zmin = 1;
//}
var cutmax = (imgdefw>imgdefh?imgdefh:imgdefw);
var zmax =  zmin > 0.25 ? 8.0: 4.0 / Math.sqrt(zmin);
//if(cutmin > cutx){
//	zmin = cutx / cutmin;
	grip_pos = 5 * (Math.log(zoom * zmax) / Math.log(zmax));
//}else{
//	zmin = 1;
//	grip_pos = 5;
//}
	Drag.init(cut_div, cut_img);
	cut_img.onDrag = when_Drag;
	
}

//图片逐步缩放
function imageresize(flag){
    if(flag){
		zoom = zoom * 1.5;
	}else{
		zoom = zoom / 1.5;
	}
	if(zoom < zmin) zoom = zmin;
	if(zoom > zmax) zoom = zmax;
	cut_img.width = Math.round(imgdefw * zoom);
	cut_img.height = Math.round(imgdefh * zoom);
	checkcutpos();
	grip_pos = 5 * (Math.log(zoom * zmax) / Math.log(zmax));
	img_grip.style.left = (grip_minx + (grip_pos / 10 * (grip_maxx - grip_minx))) + "px";
}

//获得style里面定位
function getStylepos(e){
	return {x:parseInt(e.style.left), y:parseInt(e.style.top)}; 
}

//获得绝对定位
function getPosition(e){
	var t=e.offsetTop;  
	var l=e.offsetLeft;  
	while(e=e.offsetParent){  
		if( $(e).css("position")=='absolute' ||  $(e).css("position")=='relative' ){
			break;
		}  
		t+=e.offsetTop;  
		l+=e.offsetLeft;  
	}
	return {x:l, y:t}; 
}
//检查图片位置
function checkcutpos(){
	var imgpos = getStylepos(cut_img);
	
	max_x = Math.max(offsetx, offsetx + cutx - cut_img.clientWidth);
	min_x = Math.min(offsetx + cutx - cut_img.clientWidth, offsetx);
	if(imgpos.x > max_x) cut_img.style.left = max_x + 'px';
	else if(imgpos.x < min_x) cut_img.style.left = min_x + 'px';

	max_y = Math.max(offsety, offsety + cuty - cut_img.clientHeight);
	min_y = Math.min(offsety + cuty - cut_img.clientHeight, offsety);
	if(imgpos.y > max_y) cut_img.style.top = max_y + 'px';
	else if(imgpos.y < min_y) cut_img.style.top = min_y + 'px';
}

//图片拖动时触发
function when_Drag(clientX , clientY){
	checkcutpos();
}

//获得图片裁减位置
function getcutpos(){
	var src = $("#cut_img").attr("src");
	if(src.match(/static\/tpl\/default\/images/)){
		alert("请先选择本地图片");
		return false;
	}
	var imgpos = getStylepos(cut_img);
	var x = offsetx - imgpos.x;
	var y = offsety - imgpos.y;
	var cut_pos = document.getElementById('cut_pos');
	cut_pos.value = x + ',' + y + ',' + cut_img.width + ',' + cut_img.height;
	return true;
}

//缩放条初始化
function gripinit(){
	img_grip = document.getElementById('img_grip');
	img_track = document.getElementById('img_track');
	track_pos = getPosition(img_track);

	grip_y = track_pos.y;
	grip_minx = track_pos.x + 4;
	grip_maxx = track_pos.x + img_track.clientWidth - img_grip.clientWidth - 5;

	img_grip.style.left = (grip_minx + (grip_pos / 10 * (grip_maxx - grip_minx))) + "px";
	img_grip.style.top = grip_y + "px";

	<?php if($newimg){?>
	Drag.init(img_grip, img_grip);
	img_grip.onDrag = grip_Drag;
	<?php }?>
	imageresize(true);
	imageresize(false);
}

//缩放条拖动时触发
function grip_Drag(clientX , clientY){
	var posx = clientX;
	img_grip.style.top = grip_y + "px";
	if(clientX < grip_minx){
		img_grip.style.left = grip_minx + "px";
		posx = grip_minx;
	}
	if(clientX > grip_maxx){
		img_grip.style.left = grip_maxx + "px";
		posx = grip_maxx;
	}

	grip_pos = (posx - grip_minx) * 10 / (grip_maxx - grip_minx);
	zoom = Math.pow(zmax, grip_pos / 5) / zmax;
	if(zoom < zmin) zoom = zmin;
	if(zoom > zmax) zoom = zmax;
	cut_img.width = Math.round(imgdefw * zoom);
	cut_img.height = Math.round(imgdefh * zoom);
	checkcutpos();
}

//页面载入初始化
function avatarinit(){
	var path = "$sourepath";
	if(path!='')
	{
		imageinit();
		gripinit();
	}
}

if (document.all){
	window.attachEvent('onload',avatarinit);
}else{
	window.addEventListener('load',avatarinit,false);
}


function checktype(val){
	if(!val.match(/.*\.(jpg|jpeg|gif|png)/i)){
		alert("仅支持JPG，PNG，GIF图片文件，且文件小于1M ");
		return ;
	}
	document.uploadfile.submit();
}
function saveimg(){
	getcutpos();
	_data = $('#setavatar').serialize();
	
	$.ajax({
		url:'<?=geturl('home/profile/avatarupdate')?>',
		type:'post',
		data:_data,
		success:function(data){
			if(data=="1"){
				alert('上传成功');

				window.open('/home/profile/profile.html','_self');
			}else{
				alert('上传失败，你可以选择尝试其他方式');
			}
		}
	});
}
$(document).ready(function(){
	$('#UpFile').change(function(){checktype($('#UpFile').val())});
})
</script>
</body>
</html>