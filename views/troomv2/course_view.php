<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $v=getv();?>
<?php $isapp = isApp();
if($isapp){	?>
<meta name="viewport" content="<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){?>width=1310,<?php } ?>user-scalable=no" />
<?php } ?>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();
if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= empty($subtitle) ? $this->get_title() : $subtitle ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<!--[if lte IE 6]>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico');
</script>
<![endif]-->
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/qqFace/css/jquery.mCustomScrollbar.min.css"/>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/qqFace/css/jquery.emoji.css"/>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=2015111801" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css?v=2016101301" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery-browser.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.qqFace.js"></script>
<!--新版表情!-->
<script src="http://static.ebanhui.com/ebh/js/qqFace/js/highlight.pack.js"></script>
<script src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.mCustomScrollbar.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.emoji.min.js?v=2017092101"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=getv()?>"/>
<script>
$(function(){
	//分页开始加载
	var page = 1;
	var cwid = $("#cwid").attr("value");
	var url = "/troomv2/course/getajaxpage.html";
	page_load(page,url);
})
</script>
<?php
    if($ext == 'flv'){
        if(!empty($course['m3u8url'])) {
            $purl = $course['m3u8url'];
        } else if(!empty($course['rtmpurl'])) {
            $purl = $course['rtmpurl'];
        } else {
            $purl = $course['cwsource'].'attach.html?cwid='.$course['cwid'];
        }
    }else{
         $purl = $course['cwsource'].'attach.html?cwid='.$course['cwid'].'&.mp3';
    }
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/iconfont.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/demo.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/chatroom/font/iconfont.js"></script>
<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){
	$input = EBH::app()->getInput();
    $auth = $input->cookie('auth');
?>
<link rel="stylesheet" href="http://static.ebanhui.com/chatroom/layui/css/layui.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/chatroom.css?v=20180117001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/web_socket.js"></script>


<script type="text/javascript">
  	if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
    WEB_SOCKET_SWF_LOCATION = "/static/flash/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    var ws;
	var auth = '<?=$auth?>';
	var room_id = <?=$course['cwid']?>;
	<?php
		$websocket_config = Ebh::app()->getConfig()->load('websocket');
	?>
	var WebSocketAddr = '<?=$websocket_config[0]?>';
</script>
<script src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
<script src="http://static.ebanhui.com/chatroom/js/main.js?v=20180117001"></script>
<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js"></script>
<?php } ?>
<style>
a.review_zan{background: url(http://static.ebanhui.com/ebh/tpl/default/images/viedo_zan01.png) no-repeat 20px center;
font-size: 16px;
color: #999;
height: 35px;
line-height: 35px;
padding: 0 20px 0 50px;}
a.review_zan:hover,a.review_zaned{background: url(http://static.ebanhui.com/ebh/tpl/default/images/viedo_zan02.png) no-repeat 20px center;}
.zjdlr-hot{margin-left:10px;}
.thin{font-weight:400;cursor:pointer;}
.mCSB_container {
    margin-right: 0px;
}
.work_mes a.hrelh2s{
	background:#5E8CF1 url(http://static.ebanhui.com/ebh/tpl/2016/images/sxico.png) no-repeat 10px center;
	color: #fff;
	float: right;
	height: 28px;
	line-height: 28px;
	margin-right: 22px;
	text-align: center;
	text-decoration: none;
	width: 70px;
	font-size:14px;
	border-radius:3px;
	padding:0;
	padding-left:20px;
	font-family:微软雅黑;
}

	.classboxmore{
		border:none;
	}
	.workcurrent a span {background:none;padding:0;}
.workcurrent a {padding:0;background:url(http://static.ebanhui.com/ebh/tpl/default/images/intit_02.jpg) no-repeat;width:118px;height:33px;line-height:33px;text-align:center;}
.work_mes ul li{font-size:14px;}
.classbox h1.rygers {width:820px; overflow:hidden;color:#333;height:36px;line-height:36px; padding-left:0; font-family:微软雅黑;font-size:20px;}
.classboxmore p {line-height:20px;}
.classboxmore {padding:0;width:860px;border:none;}
em{
	font-style:italic;
	font-weight:inherit;
}
strong{
	font-style:inherit;
	font-weight:bold;
}
.datatab td{
	border:none;
	padding:10px;
}
.fill{
	border-top:none;
}
.appraise dl dt{
	border-top:none;
}
.appraise dl dd{
	border-top:none;
}
a.atfalsh1s{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left 4px;
    color: #fff;
    display: block;
    float: right;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 43px;
    text-align: center;
    width: 90px;
	font-weight:normal;
}
a.atfalsh1s:hover{
	color:#fff;
}
.lefrig a.lanbtn, .lefrig a.huangbtn , .lefrig a.lanbtn:hover, .lefrig a.huangbtn:hover{
    background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left center;
    color: #fff;
    display: block;
    float: right;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 35px;
    text-align: center;
    width: 90px;
	font-weight:normal;
}
.lefrig a.previewBtn, .lefrig input.previewBtn,.lefrig a.previewBtn:hover, .lefrig input.previewBtn:hover{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left 4px;
    color: #fff;
    display: block;
    float: right;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 43px;
    text-align: center;
    width: 90px;
	font-weight:normal;
	margin-right: 0px;
}
.rqzs{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png") no-repeat left center;
    padding-left: 15px;
	color:#999;
}
p.lsxm{
	color:#666;
	font-family:微软雅黑;
	line-height:20px;
}
.userimg img{
	border-radius:20px;
}
.datatab th{
	font-family: 微软雅黑;
    font-size: 14px;
	color:#333;
	font-weight:normal;
	padding: 0;
}
.bzzytitle{
    padding-left: 25px;
    font-family: 微软雅黑;
    font-weight: bold;
    color: rgb(51, 51, 51);
    font-size: 16px;
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/bzzyico.jpg) left center no-repeat !important;
}
.bzzytitle1s{
	width:14px;
	height:18px;
	margin-top:8px;
	float:left;
	display:inline;
	padding-left:10px;
}
.apptit{
	line-height:35px;
	margin-top:10px;
}
.userimg{
	width:80px;
	text-align:center;
	height:auto;
	position:relative;
}
.userimg a{
	display:block;
}
.userimg a b{
	display:block;
	width:65px;
	font-family:微软雅黑;
	font-size:14px;
	color:#333;
	font-weight:normal;
}
.xingbie {
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png) no-repeat left center;
    display: block;
    width: 15px;
    height: 18px;
    margin-left: 5px;
	position:absolute;
	top:47px;
	right:0;
}
span.renming1 {
    font-family: 微软雅黑;
    font-size: 12px;
    color: #999;
	display:block;
	overflow:hidden;
}
.xingbie1 {
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png) no-repeat left center;
    display: block;
    width: 15px;
    height: 18px;
    margin-left: 5px;
	position:absolute;
	top:47px;
	right:0;
}
.grade{
	padding-left:8px;
}
.appraise dl{
	float:left;
}
input,textarea:focus{
	outline: none;
	background:none;
}
.dashu{
	line-height:25px;
}
.qqFace{margin-top:4px;background:#fff;padding:2px;border:1px #dfe6f6 solid;}
.qqFace table td{padding:0px;}
.qqFace table td img{cursor:pointer;border:1px #fff solid;}
.qqFace table td img:hover{border:1px #0066cc solid;}
.onlinework{display: block;width: 118px;float: left;margin-left: 12px; text-align: center; background: url('http://static.ebanhui.com/ebh/tpl/default/images/intit.jpg') no-repeat; background-position: -142px 0px;}
.active{background-position: -11px 0px;}
body{ background:#8493af;}
.video-play {margin-top:5px;width:auto;}
.shade {background:#fff;position: absolute;width:100%;height:100%;top:0px;left:0px;z-index:1009;text-align:center;line-height:562px;font-size:24px;background-color:#3c3c3c;opacity:0.8;filter:alpha(opacity=80);color:#fff;}

a.tiewes {
    border: medium none;
    color: #5e96f5;
    cursor: pointer;
    display: block;
    float: left;
    font-size: 15px;
    font-weight: bold;
    padding: 5px 0;
    text-decoration: none;
	left: 890px;
    line-height: 1.5;
	position: absolute;
	top:0;
}
a.reviews {color:#fff;}
</style>
</style>
<style type="text/css">
#icategory{
	background:#fff;
	padding:6px 10px;
}
.category_cont1 div{
	height:40px;
	line-height:40px;

}
.fbsjkc .kkjssj{
	width:auto;
	float:left;
}
.fbsjkc .cyrss{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png) no-repeat left center;
	padding-left: 15px;
}
.fbsjkc .cyrus{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renyuan.png) no-repeat left center;
	padding-left: 15px;
}
.bzzytitle a{
    font-family: 微软雅黑;
    font-weight: bold;
    color: #333;
    font-size: 16px;
}
.diles{
	top:55px;
}
.cuotiji{
	margin-right:11px !important;
}
div::after, ul::after, dl::after{
	display: inline;
}
i.TSicon,i.PTicon,i.homeicon,i.classicon,i.examinicon{
	display: inline-block!important;
	width:20px;
	height: 20px;
	background: #19a6f8;
	color:#fff;
	border-radius: 2px;
	margin: 0 5px;
	font-style:normal;
	text-align: center;
	line-height: 20px;
	font-weight: 400;
	font-size: 11px;

}
.category_cont1 div a{
	padding: 3px 10px;
	font-size: 14px;
}
.fbsjkc{
	line-height: 32px;
}
.workdatabzylist1{
	border-bottom: 1px solid #efefef;
}
a:hover{text-decoration: none}
a.filterF{
	color: #999;
	cursor: default;
}
a.filterF:hover{
	color: #999;
	cursor: default;
}
.workdatabzylist1{
	width: 948px;
}
.ml25{
	margin-left: 20px;
}
.newTip_btn{
	bottom:200px!important;
}
</style>
</head>
<?php $this->widget('sendallmessage_widget', array(), array('room_type' => 'troomv2','window_type' => 'self')); ?>
<body>



<?php $domain=$this->uri->uri_domain();?>
<input type="hidden" value="1" id="ist" />
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<input type="hidden" value="<?=$domain?>" id="domain">
<input type="hidden" value="<?=$course['ism3u8']?>" id="ism3u8"> <!-- 转码完成标志 -->
<input type="hidden" value="<?=strtolower($ext)?>" id="cwtype"> <!-- 课件类型 -->


<div <?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){ ?>style="width:1310px;margin:0 auto;position: relative;" <?php }else{?>style="margin:0 auto;width:978px;" <?php }?>>

<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){ ?>
	<?php $this->display('common/chatroom'); ?>
<?php } ?>

<div class="cright_cher" style="width:978px;margin-bottom:20px;margin-top:0px;background:#fff;<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){ ?>float:none; margin-top:0px!important;<?php }?>">

<div class="lefrig" style="padding:0;width:978px;">
    <div class="classbox" style="width:978px;background: #FFF;min-height: auto;">
				<div style="float:left;margin:5px 15px 0 18px; text-align:center;">
    				<?php
    					if(!empty($iszjdlr)){
    						if($cwuser['sex'] == 1) {
    						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
	    					} else {
	    						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
	    					}
	    					$face = empty($cwuser['face']) ? $defaulturl : $cwuser['face'];
    					}else{
    						if($course['sex'] == 1) {
    						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
	    					} else {
	    						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
	    					}
	    					$face = empty($course['face']) ? $defaulturl : $course['face'];
    					}
    					$face = getthumb($face,'50_50');
                	?>

                <?php if(!empty($iszjdlr)){?>
                	<?php if(empty($cwuser['realname'])){$cwuser['realname'] = $cwuser['username'];}?>
					<img src="<?=$face?>" style="width:30px;height:30px; border-radius:20px;" title="<?=$cwuser['realname']?>">
				<?php }else{?>
					<img src="<?=$face?>" style="width:30px;height:30px; border-radius:20px;" title="<?=$course['realname']?>">
				<?php }?>
                </div>
        <h1 class="rygers"><?= $course['title'] ?></h1>
        <div class="classboxmore">
            <p style="">
                <?php if (!empty($course['cwurl']) && $ext != 'flv' && $ext != 'mp3'&&$ext !='swf') { ?>
                    <a class="huangbtn marrig" href = "<?= $course['cwsource'] . 'attach.html?cwid=' . $course['cwid'] ?>">下 载</a>

					<!--
					<?php if($course['ispreview']) { ?>
					<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank">预 览</a>
					<?php } ?>
					 -->

                <?php } ?>
                 <!--   <a class="huangbtn" href = "<?= geturl('troomv2/course/upattach-0-0-0-' . $course['cwid']) ?>">上传附件</a>-->
            </p>
            </div>
		<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
			<div class="video-ebhp video-play">
				<div id="video">
					<div class="wraps">
						<div class="video-floatswf-topbg"></div>
						<div class="video-floatswf-top">
							<span class="video-floatswf-title js-title"><?= $course['title'] ?></span>
							<b class="video-float-close" onclick="closew()"></b>
						</div>
						<div id="playcontrol"></div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($ext == 'flv' || $ext == 'mp3' || $ext == 'swf') { ?>
		<?php if(empty($is_mobile)){ ?>
			<?php if($ext == 'mp3') {?>
			<div class="video-mp3 video-play">
                <div id="video">
    		<?php } else { ?>
			<div class="video-swf video-play">
    			<div id="video">
    			<!-- flv转码 判断是否转码完成 -->
    			<?php if(($ext == 'flv') && ($course['ism3u8'] != 1)){?>
				<div class="shade">视频正在转码加密，请稍后<span id="randnums">...</span></div>
				<?php }?>
    		<?php } ?>
<!--                    --><?php //if($ext!='swf'){?>
					<div class="wraps">
					<div class="video-floatswf-topbg"></div>
<div class="video-floatswf-top">
<span class="video-floatswf-title js-title"><?= $course['title'] ?></span>
<b class="video-float-close" onclick="closew()"></b>
</div>
						<div id="flvcontrol">
						</div>
					</div>
<!--                    --><?php //}else{?>
<!--                    <object width="900" height="600">-->
<!--                        <param name="allowScriptAccess" value ="always" />-->
<!--                        <param name="movie" value="--><?//= $course['cwsource'] . 'attach.html?cwid=' . $course['cwid'] ?><!--"/>-->
<!--                        <param name="allowFullScreen" value="true" />-->
<!--                        <embed style="margin-left: 28px;margin-top: 20px;" height="600" width="900" src="--><?//= $course['cwsource'] . 'attach.html?cwid=' . $course['cwid'] ?><!--" type="application/x-shockwave-flash" allowNetworking="all" ></embed>-->
<!--                    </object>-->
<!--                    --><?php //}?>
            	</div>

		</div>
		<?php }else{ ?>
			<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
					<div style=" position: relative;height:740px;margin-left:10px;z-index:601;float:left;">
					<div id="playcontrol" style="width:700px;height:428px;"></div>
					</div>
			<?php } ?>
			<?php if ($ext == 'flv' || $ext == 'mp3') { ?>
				<?php if($ext == 'mp3') {?>
	            <div style=" float:left;position: relative;height:410px;margin-left:10px;z-index:601;">
				<?php } else { ?>
				<div style=" float:left;position: relative;height:600px;margin-left:10px;z-index:601;">
				<?php } ?>
	                <div id="flvcontrol2" style="width:700px;height:400px;">
	                    <video id="_video" src="<?=$purl?>" poster="<?=$course['thumb']?>" width="980px" height="560px"  controls="controls">
	                        您的浏览器不支持播放该视频！
	                    </video>
					</div>

	            </div>
				</div>
	        <?php } ?>
		<?php } ?>
        <?php } ?>

        <div id='atsrc' style="display: none;"></div>
</div>

<?php $domain=$this->uri->uri_domain();
					$cloudurl='http://'.$domain.'.ebanhui.com';?>
		<?php if(preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])){ ?>
			<?php if(!empty($user)){ ?>

				 <?php if($domain=='www' || !empty($free)){ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
					<?php }else{ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')"  class="borlanbtn" value="播放"></div>
					<?php } ?>
			<?php }else{ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
			<?php } ?>
			<div class="tieziss" style="font-size:14px;line-height:26px;">您也可以切换到ebh播放器,更方便快捷</div>
		<?php } ?>

		<!-- 课件 ppt/word等预览 开始 -->
		<?php $this->assign('course',$course);?>
		<?php $this->display('common/previewv2');?>
		<!-- 课件 ppt/word等预览  结束 -->

		<?php if(!empty($course['message'])){ ?>
        <div class="introduce" style="padding-top: 10px;float:left;width:978px;">
        	<?php if($iszjdlr && $cwuser['toid'] == 1){?>

            <?php }else{?>
            	<div class="intitle" style="width:978px;"><h2><a id="rid">课件介绍</a></h2></div>
            <?php }?>
            <div class="inconts" style="width:978px;">
                <?= $course['message'] ?>
            </div>
        </div>
		<?php } ?>
        <div class="introduce" id="examworkList" style="width:978px;padding-top: 10px;float:left;">
			<div class="intitle" style=" width: 978px;">
				<h2 style="padding: 0;">
					<a class="onlinework active" id="rid" onclick="parse_Joblist()">在线作业</a>
				</h2>
			</div>
            <div class="incont" style="width:978px;">
				<table width="100%" class="datatab powerfalse" style="border:none;width: 978px;">
					<thead class="tabhead">
						<tr>
							<th>作业名称</th>
							<th>出题时间</th>
							<th>总分</th>
							<th>已答人数</th>
							<th>操作</th>
					 	</tr>
					  </thead>
						<tbody>


					  </tbody>
				</table>
				<div class="workdatabzylist" id="exams">
				</div>
            </div>
        </div>
        <?php if (!empty($attachments)) { ?>
            <div class="introduce" style="padding-top: 10px;float:left;width:978px;">
				<a name="upduce"> </a>
                <div class="intitle" style="width:978px;position: relative;"><h2><a id="rid">附件管理</a><a class="tiewes upattach" title="上传附件" url="<?= geturl('troomv2/classcourse/upattach-0-0-0-'.$course['cwid']) ?>?dialog=1&selfrefresh=1" href="javascript:;">上传附件</a></h2></div>
                <div class="incont">
                    <table width="100%" class="datatab" style="border:none;width: 978px;">
                        <thead class="tabhead">
                            <tr>
                                <th>附件名称</th>
                                <th>上传时间</th>
                                <th>审核状态</th>
                                <th>附件大小</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php EBH::app()->helper('fileico');
							foreach ($attachments as $atta) {
								$ico = format_ico($atta['suffix']);?>
                                <tr>
                                    <?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
                                        <?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
                                            <td width="35%"><i class=" icont <?=$ico?>" style="margin: 3px 4px 0 22px"></i><span style="width:270px;word-wrap: break-word;float:left; padding-left:5px;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
                                        <?php } else { ?>
                                            <td width="35%"><i class=" icont <?=$ico?>" style="margin: 3px 4px 0 22px"></i><span style="width:270px;word-wrap: break-word;float:left; padding-left:5px;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
                                        <?php } ?>
                                    <?php } ?>
                                    <td width="15%"><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
                                    <td width="12%" style="text-align:center">
                                        <?php if ($atta['status'] == 0) { ?>
                                            <font color="#ff6600">未审核</font>
                                        <?php } else if ($atta['status'] == 1) { ?>
                                            <font color="#008000">审核通过</font>
                                        <?php } else if ($atta['status'] == -1) { ?>
                                            <font color="#a7a7a7">审核未通过</font>
                                        <?php } ?>
                                    </td>
									<td width="12%" style="text-align:center"><?= getsize($atta['size'])?></td>
									<td width="26%" style="padding-right:22px;">
									<?php if($atta['uid'] == $user['uid']){?>
											<a href="javascript:;" class="lasrnwe ml20 upattach" title="编辑附件" small="1" url="/troomv2/classcourse/editattach/<?=$atta['attid']?>.html?dialog=1&selfrefresh=1" style="margin-top:8px;float:left;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png" /></a>
											<a href="javascript:;" onclick="delattachment(<?=$atta['attid']?>)" class="lasrnwe ml20" title="删除附件" style="margin-top:8px;float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png" /></a>
											<?php }?>
                                    <?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<?php if($atta['ispreview'] && $atta['suffix']!= 'mp4' && $atta['suffix']!= 'avi') { ?>
												<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" target="_blank">预览</a>
											<?php }else { ?>
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载" type="button" />
												<?php }?>
                                            <?php } else { ?>
                                                <a class="atfalsh atfalsh1s" href="javascript:void(0);" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
                                        <?php } ?>
                                    <?php } ?>
									</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        <?php } ?>

	<?php if($roominfo['crid'] != 10420){ ?>
        <div class="introduce" style="width:978px;padding-top: 10px;float:left;">
            <div class="work_mes" style="width:978px;margin-bottom:10px">
				<ul>
					<li class="workcurrent reviewtab" onclick="showreview()"><a name="reviewanc" href="javascript:void(0)"><span>课件评论 (<font color="red" id="reviewcount"><?=$reviewcount?></font>)</span></a></li>
					<li class="asktab" onclick="showask()"><a href="javascript:void(0)"><span>相关问题 (<font color="red"><?=$askcount?></font>)</span></a></li>
                    <li style="float: right;" id="sixin"><span><a class="hrelh hrelh2s" href="javascript:;" id="submit"  name="review" cwid="<?= $course['cwid']?>">发私信</a></span></li>
				</ul>
			</div>
			<div id="reviewdiv">
            	<!--评论-->
            	<!--新评论开始-->
				<div class="coursewareview">
					<div class="satisfaction">
				    	<span class="span1s">满意度：</span>
				    			<input id="mark_score" name="mark" type="hidden" value="0">
				        <span class="span2s" onmouseover="chose_star(this,event)">

				        	<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="1" title="很烂">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="2" title="一般">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="3" title="还好">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="4" title="较好">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="5" title="很好">
				        </span>
				    </div>
				    <textarea class="inputrating" id="comment-input"></textarea>
				    <div class="facecomments">
						<input class="emoji_btn" id="emoji_btn_1" src="http://static.ebanhui.com/ebh/js/qqFace/index.png" style="" type="image">
				        <a href="javascript:;" style="margin-right:28px;" onclick="comment();" class="reviews">评&nbsp;论</a>
				        <p class="inputprompt inputprompt-bottom">你还可以输入<span>100</span>字</p>
				    </div>
				    <div class="clear"></div>
				    <div class="allcomments">

				    </div>
				</div>
				<?= $pagestr ?>
				<!--新评论结束-->

			</div>
			<div id="askdiv" style="float:left;width:970px;display:none">
				<div style="text-align:center;">
					<span style="font-size:14px;line-height:30px;" id="noask">
						暂无相关问题
					</span>
				</div>
				<div class="tweytr" style="margin-left:10px">

				</div>

			</div>

			</div>
		<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>
				<div class="introduce" style="width:978px;padding-top: 10px;float:left;">
            <div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
            	<!--新评论开始-->
				<div class="coursewareview">
					<div class="satisfaction">
				    	<span class="span1s">满意度：</span>
				    			<input id="mark_score" name="mark" type="hidden" value="0">
				        <span class="span2s" onmouseover="chose_star(this,event)">

				        	<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="1" title="很烂">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="2" title="一般">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="3" title="还好">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="4" title="较好">
				            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="5" title="很好">
				        </span>
				    </div>
				    <textarea class="inputrating" id="comment-input"></textarea>
				    <div class="facecomments">
				    	<a href="javascript:;" class="face"></a>
				        <div class="qqface1" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qqbq.jpg" /></div>
				        <a href="javascript:;" onclick="comment();" style="margin-right:28px;" class="reviews">评&nbsp;论</a>
				        <p class="inputprompt inputprompt-bottom">你还可以输入<span>100</span>字</p>
				    </div>
				    <div class="clear"></div>
				    <div class="allcomments">

				    </div>
				</div>
				<?= $pagestr ?>
				<!--新评论结束-->
			</div>
			<?php } ?>

		<?php } ?>

</div>
<div id="moreask" style="display:none;float:left;text-align:center;background:#fff;border:1px solid #cdcdcd;width:998px;height:35px;line-height:35px;font-size:14px;margin-top:-10px;">
	<a target="_blank" href="/troomv2.html?url=troomv2/myask.html" style="">更多>></a>
</div>


</div></div>
<!--新评论JS-->
<script type="text/javascript">
	$('#mark_score').val(0);
	//用于记录回复记录
	var reply_log = {};
	var isnewzjdlr = <?=!empty($isnewzjdlr) ? 'true' : 'false'?>;
	//字符统计
	$('#comment-input').bind('keyup', function() {
		if(100-$('#comment-input').val().length <= 0){
			$('#comment-input').val($('#comment-input').val().substring(0,100));
		}
		$('.inputprompt-bottom span').html(100-$('#comment-input').val().length);
	})
	//置顶评论
	function top_comment(log_id,obj,topdown){
		$.ajax({
			type:"post",
			url:"/troomv2/course/ajax_topreview.html",
			data:{'logid':log_id,'topstatus':topdown},
			async:true,
			dataType:'json',
			success:function(result){
				if(result.status == 0){
					window.location.reload();
				}
			}
		});
	};
	//删除评论
	function del_comment(log_id,obj){
		var d = dialog({
			title: '删除评论',
			content: '您确定要删除该评论吗？删除后不可查看该评论!',
			okValue: '确定',
			ok: function () {
				var url = "<?= geturl('troomv2/review/del')?>";
				$.ajax({
					url:url,
					type:'post',
					data:{'logid':log_id,'cwid':'<?= $course['cwid'] ?>'},
					dataType:'json',
					success:function(result){
						if(result.status == '1'){
							var url = "/troomv2/course/getajaxpage.html";
							var $curr_page_a = $('#reviewdiv .pages .listPage a.none');
							for(var i=0;i<$('.emoji_btn').length;i++){
								if(i!=0){
									$($('.emoji_btn')[i]).remove();
								}
							}
							if($curr_page_a.html() == undefined){
								page_load(1,url);
							}else{
								if($curr_page_a.length == 1){
									page = $curr_page_a.html()?$curr_page_a.html():1;
								}else{
									page = 1;
								}
								var count = $("#reviewcount").html();
								if((count-1) <= 10){
									page = 1
								}
								page_load(page,url);
							}

						}else{
							alert(result.msg);
						}
					}
				});

			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}
	function get_now_tiem(){
		var unixTimestamp = new Date().getTime();

		return get_time(unixTimestamp/1000);
	}
	function replace_em(str){
		var emo = (str.match(/\[emo(\S{1,2})\]/g));
		var emo2 = str.match(/\[em_(\S{1,2})\]/g);
		if(emo != null){
			$.each(emo, function(i,item){
				var temp = emo[i].replace('[emo','');
				temp = temp.replace(']','');

				str2 = '<img src="http://static.ebanhui.com/ebh/tpl/default/images/'+temp+'.gif">';
				str = str.replace(emo[i],str2);
			});
		}

		if(emo2 != null){
			$.each(emo2, function(i,item){
				var temp = emo2[i].replace('[em_','');
				temp = temp.replace(']','');

				str2 = '<img src="http://static.ebanhui.com/ebh/js/qqFace/arclist/'+temp+'.gif">';
				str = str.replace(emo2[i],str2);
			});
		}
	//贴吧或者qq新表情匹配
		if(str.match(/\[(tieba|qq)_(\d+)\]/g)!= null){
			str = str.replace(/\[(tieba|qq)_(\d+)\]/g,'<img src="http://static.ebanhui.com/ebh/js/qqFace/$1/$2.gif" />')
		}

		str = str.replace(/<([^i][^m][^g])/g,'&lt;$1');
		return str;
	}
	//发表评论
	function comment(){
		var msg = $.trim($("#comment-input").val());
		var mark = $("#mark_score").val();
		if(msg=='' || msg==''){
			var d = dialog({
		    title: '提示',
		    content: '发表内容不能为空。',
		    cancel: false,
			okValue: '确定',
		    ok: function () {}
			});
			d.showModal();
			$("#comment-input").focus();
			return false;

		}else if($.trim($('#comment-input').val().replace(/<[^>]*>/g,'')).length>100){
			var d = dialog({
				title: '提示',
				content: '发表内容不能大于100字',
				cancel: false,
				okValue: '确定',
				ok: function () {}
			});
			d.showModal();
			$("#comment-input").focus();
			return false;
		}
		var url = "<?= geturl('troomv2/review/add')?>";
		var domain = "<?=$domain?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'cwid':'<?= $course['cwid'] ?>','mark':mark,'type':'courseware'},
			dataType:'json',
			success:function(result){
				if(result.status == '1'){
					$("#comment-input").val('');
					$('.inputprompt-bottom span').html(100);
					$('#reviewcount').html(parseInt($('#reviewcount').html())+1);
					for(var i=0;i<$('.emoji_btn').length;i++){
						if(i!=0){
							$($('.emoji_btn')[i]).remove();
						}
					}
					page_load(1,"/troomv2/course/getajaxpage.html");
				}else if(result.status == -1){
					var str = '';
                    $.each(result.Sensitive,function(name,value){
                    	str+=value+'&nbsp;';
                    });
                    var d = dialog({
						title: '提示',
						content: '评论包含敏感词汇'+str+'！请修改后重试...',
						cancel: false,
						okValue: '确定',
						ok: function () {
						}
					});
					d.showModal();
				}else{
					alert(result.msg);
				}
			}
		})
	}

	 //满意度单选点击事件

    $('.cstar').click(function(){

    	$('#mark_score').val($(this).attr('score'));
    })
	function chose_star(obj,oEvent){
		var imgSrc = 'http://static.ebanhui.com/ebh/tpl/2016/images/stars.png';
    	var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/2016/images/stars1.png';
    	if(obj.rateFlag) return;
    	var e = oEvent || window.event;
	    var target = e.target || e.srcElement;
	    var imgArray = obj.getElementsByTagName("img");
	    for(var i=0;i<imgArray.length;i++){
	       imgArray[i]._num = i;
	       imgArray[i].onclick=function(){
	        if(obj.rateFlag) return;
	        var inputid=this.parentNode.previousSibling
	        inputid.value=this._num+1;
	       }
	    }
	    if(target.tagName=="IMG"){
	       for(var j=0;j<imgArray.length;j++){
	        if(j<=target._num){
	         imgArray[j].src=imgSrc_2;
	        } else {
	         imgArray[j].src=imgSrc;
	        }
	        target.parentNode.onmouseout=function(){
	        var imgnum=parseInt(target.parentNode.previousSibling.value);
	            for(n=0;n<imgArray.length;n++){
	                imgArray[n].src=imgSrc;
	            }
	            for(n=0;n<imgnum;n++){
	                imgArray[n].src=imgSrc_2;
	            }
	        }
	       }
	    } else {
	         return false;
	    }
	}
	hljs.initHighlightingOnLoad();
        $("#comment-input").emoji({
            showTab: true,
            animation: 'fade',
            icons: [{
                name: "贴吧表情",
                path: "http://static.ebanhui.com/ebh/js/qqFace/tieba/",
                maxNum: 50,
                file: ".gif",
                placeholder: "[tieba_{alias}]",
                title: {
                    1: "呵呵",
                    2: "哈哈",
                    3: "吐舌",
                    4: "啊",
                    5: "酷",
                    6: "怒",
                    7: "开心",
                    8: "汗",
                    9: "泪",
                    10: "黑线",
                    11: "鄙视",
                    12: "不高兴",
                    13: "真棒",
                    14: "钱",
                    15: "疑问",
                    16: "阴脸",
                    17: "吐",
                    18: "咦",
                    19: "委屈",
                    20: "花心",
                    21: "呼~",
                    22: "笑脸",
                    23: "冷",
                    24: "太开心",
                    25: "滑稽",
                    26: "勉强",
                    27: "狂汗",
                    28: "乖",
                    29: "睡觉",
                    30: "惊哭",
                    31: "生气",
                    32: "惊讶",
                    33: "喷",
                    34: "爱心",
                    35: "心碎",
                    36: "玫瑰",
                    37: "礼物",
                    38: "彩虹",
                    39: "星星月亮",
                    40: "太阳",
                    41: "钱币",
                    42: "灯泡",
                    43: "茶杯",
                    44: "蛋糕",
                    45: "音乐",
                    46: "haha",
                    47: "胜利",
                    48: "大拇指",
                    49: "弱",
                    50: "OK"
                }
            }, {
                path: "http://static.ebanhui.com/ebh/js/qqFace/qq/",
                maxNum: 91,
                excludeNums: [41, 45, 54],
                file: ".gif",
                placeholder: "[qq_{alias}]"
            }]
        });

    $("#btnLoad2").click(function () {
        $("#editor").emoji({
            button: "#btn",
            showTab: false,
            animation: 'slide',
            icons: [{
                name: "QQ表情",
                path: "dist/img/qq/",
                maxNum: 91,
                excludeNums: [41, 45, 54],
                file: ".gif"
            }]
        });
    });


	$('.face').click(function(){
		if($('#comment-input').val() == ''){
			$(this).css('color','#000');
			$('#comment-input').val('');
		}

	});

	$('#comment-input').focus(function(){
		if($(this).val() == ''){
			$(this).css('color','#000');
			$(this).val('');
		}
	});
	$('#comment-input').blur(function(){
		if($(this).val() == ''){
			$(this).css('color','#999');
			$(this).val('');
		}
	});

	//格式化时间
	function get_time(timestamp){
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	//显示所有三级评价
	function show_all(obj){
		$(obj).parent().siblings('ul').find('.replycommentli1').show();
		$(obj).parent().hide();
	}
	//获取头像
	function get_avatar(obj){
		var defaulturl = '';
		var face = '';
		if (obj.sex == 1){
			if(obj.groupid == 5){
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
			}else{
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			}
		}else{
			if(obj.groupid == 5){
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
			}else{
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			}
		}

		face = obj.face=='' ? defaulturl : obj.face;

		var path = face.substring(0,face.lastIndexOf('.'));
		var ext = face.substring(face.lastIndexOf('.'));
		return path+'_50_50'+ext;

	}
	//打开二级回复
	function open_reply_dialog(obj){
		//$('.commentlistsonbottom').show();
		$(obj).parent().parent().siblings('.commentlistsonbottom').show();
		$(obj).parent().hide();
		$(obj).parent().siblings('.close-reply-btn').show();
		//修复IE下重绘延迟
		$('.ul1').css('visibility','visible');
	}
	//关闭二级回复
	function close_reply_dialog(obj){
		$(obj).parent().parent().siblings('.commentlistsonbottom').hide();
		$(obj).parent().hide();
		$(obj).parent().siblings('.open-reply-btn').show();
		//修复IE下重绘延迟
		$('.ul1').css('visibility','inherit');
	}
	//弹出发送私信
	$('.hrelh1s').click(function(e){
		window.H.get('wxDialog').exec('show');
		$("#wrap2").html("");
        $("textarea.txttiantl").val("");
        //添加收件人
        var tid = $(this).attr("tid");
        var tname = $(this).attr("tname");
        $("#wrap2").append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');
        //焦点对话框
        $("textarea.txttiantl").focus();
	});

	parse_Joblist();
	function parse_Joblist(bol){ //在线作业
		var exampower = "<?=$examPower?>";
		if(exampower ==0){
			url = '/troomv2/course/getCwidExamsAjax.html';
		}else if(exampower ==1){
			url = '/troomv2/examv2/elistAjax.html';
		};
		$.ajax({
			url:url,
			type:'post',
			data:{
				'cwid': $('#cwid').val(),
				'recuid':"<?=$recuid?>"

			},
			dataType:'json',
			success:function(result){
				var list = '';
				var useruid = '<?=$user['uid']?>';
				var isschool = <?=$roominfo['isschool']?>;
				if(exampower ==0){
					if(result.length > 0){
						for(var i=0;i<result.length;i++){
							list += '<tr id="exam_'+result[i].eid +'>">';
							list += '<td width="65%">'+ result[i].title+'</td>';
							list += '<td>'+new Date(parseInt(result[i].dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>';
							list += '<td>'+result[i].score+'</td>';
							list += '<td style="text-align:center;">'+result[i].answercount+'</td>';
							list += '<td>';
							if(useruid != result[i].uid){
								list += '<a  style="    margin-left: 20px;" class="workBtn" href="http://exam.ebanhui.com/ado/'+result[i].eid+'.html" target="_blank"><span>查看</span></a>';
							}else{
								if(isschool ==2){
									list +=	'<a class="workBtn" href="http://exam.ebanhui.com/edit/'+result[i].eid+'.html" target="_blank"><span>编辑</span></a>';
			        				list +=	'<a class="workBtn" href="javascript:void(0)" onclick="delexam('+result[i].eid+',<?= $course['cwid']?>,'+ result[i].title.replace("'","")+')"><span>删除</span></a>';
								}else{
									list += '<a class="workBtn" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/'+result[i].eid+'.html" target="_blank"><span>编辑</span></a>';
			                    	list += '<a class="workBtn" href="javascript:void(0)" onclick="delexam2('+result[i].eid+',<?= $roominfo['crid']?>)"><span>删除</span></a>';
								}
							};
		                    list +='</td>';
						  	list +='</tr>';
						}
						$('#examworkList table.datatab tbody').empty().append(list);
						$('#errortext').hide();
					}else{

						$('#examworkList').remove()
					};
				}else if(exampower == 1){
					var crid = <?= $roominfo['crid']?>;
					$("#exams").empty();
					$('.powerfalse').hide();
					var examList = result.datas.examList;
					if(examList){
						for(var i=0;i<examList.length;i++){
							var data = examList[i];
							if(data.esubject.length>40){
							    var  sesubject = data.esubject.substring(0,40)+"...";
							}else{
								var  sesubject = data.esubject;
							}
							var userAnswer = examList[i].userAnswer;
							var classarr = '';
							var classlist = [];
				    		for(var j=0;j<data.relationSet.length;j++){
				    			if(data.relationSet[j].ttype == 'CLASS'){
				    				classlist.push(data.relationSet[j].tid)
				    				if(j+1 != data.relationSet.length ){
				    					classarr += data.relationSet[j].relationname+','
				    				}else{
				    					classarr += data.relationSet[j].relationname+''
				    				}
				    			}
				    		}
				    		if (data.status == 0){
				    			var status = '<a class="bjcgs" target="_blank" href="/troomv2/examv2/edit/'+data.eid+'.html">编辑草稿</a>';
				    			str = '(草稿)';
				    		} else {
				    			var status = '<a class="bjcgs" target="_blank" href="/troomv2/examv2/alist/'+data.eid+'.html">批阅</a>';
				    			str = '';
				    		}
				    		var answercount = data.answercount;
				    		if (data.count != undefined) {
				    			var count = data.count;
				    		} else {
				    			var count = 0;
				    		}
					    	/* 构造中间的*/
					    	if (data.datelineStr == null)
					    		data.datelineStr = '刚刚';
					    	var etype = '普通作业';
					    	/*构造tile*/
					    	if(data.etype == 'COMMON'){
					    		if(data.estype == ''){
					    			var icontext = '';
					    		}else{
					    			var icontext ='<i class="classicon">'+data.estype.substr(0,1) +'</i>' ;
					    		};

								if(useruid != examList[i].uid){
									var title = '<div class="bzzytitle"><a href="/troomv2/examv2/courseexam/'+data.eid+'.html" title="'+data.esubject +'" target="_blank">'+sesubject+'<span>'+str+'</span></a><i class="PTicon">普</i>'+icontext+'</div>';
						    		var fr = '<div class="fr ml25" style="width:190px;"><a class="bjcgs" target="_blank" href="/troomv2/examv2/courseexam/'+data.eid+'.html">查看</a></div>'
						    	}else{
						    		var title = '<div class="bzzytitle"><a href="/troomv2/examv2/edit/'+data.eid+'.html" title="'+data.esubject +'" target="_blank">'+sesubject+'<span>'+str+'</span></a><i class="PTicon">普</i>'+icontext+'</div>';
						    		var fr = '<div class="fr ml25" style="width:190px;"><a href="/troomv2/examv2/edit/'+data.eid+'.html" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png" /></a><a href="javascript:;" onclick="delexamss('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;margin-left:10px;margin-right:10px;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png" /></a>'+status+'</div>';
						    	}
							};

					    	if (data.etype == 'TSMART') {
					    		if (data.status == 0){
					    			var tstatus = '编辑草稿';
					    			str = '(草稿)';
					    		} else {
					    			var tstatus = '批阅';
					    			str = '';
					    		}
					    		var etype = '智能作业';
					    		if(data.estype == ''){
					    			var icontext = '';
					    		}else{
					    			var icontext ='<i class="classicon">'+data.estype.substr(0,1) +'</i>' ;
					    		};
					    		var title = '<div class="bzzytitle"><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html" title="'+data.esubject +'" target="_blank">'+sesubject+'<span>'+str+'</span></a><i class="TSicon">智</i>'+icontext+'</div>';
					    		if(useruid != examList[i].uid){
					    			var fr = '<div class="fr ml25" style="width:190px;"><a class="bjcgs" target="_blank" href="/troomv2/examv2/previewsmart.html?eid='+examList[i].eid+'">查看</a></div>'
						    	}else{
						    		var fr = '<div class="fr ml25" style="width:190px;"><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;margin-left:10px;margin-right:10px;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png"></a><a class="bjcgs" target="_blank" href="/troomv2/examv2/smartalist/'+data.eid+'.html">'+tstatus+'</a></div>';
						    	}
					    	}

					    	var  relationname = '' ;
							var folderid = '';
				    		if(data.relationSet.length >=2 && data.relationSet[0].ttype == 'FOLDER'){
								if(data.relationSet[1].ttype == 'COURSE'){
					    			FOLDER = data.relationSet[0].relationname;
					    			COURSE = data.relationSet[1].relationname?data.relationSet[1].relationname:'';
					    			relationname = FOLDER+ '>' + COURSE;
					    			folderid = data.relationSet[0].tid;
					    		}else{
					    			relationname = data.relationSet[0].relationname;
			    					folderid = data.relationSet[0].tid;
					    		}
						    }else{
						    	if(data.relationSet[0].ttype == 'FOLDER'){
						    			relationname = data.relationSet[0].relationname;
				    					folderid = data.relationSet[0].tid;
					    		}else{
					    			relationname = '';
				    				folderid = '';
					    		}
						    };

					    	if(relationname.length>30){
							    var  relationnames = relationname.substring(0,30)+"...";
							}else{
								var  relationnames = relationname;
							};
							var classmiddle = '';
							if(classarr != ''){
								classmiddle = '<span title="'+classarr+'" style="margin-left:10px">关联班级：' + classarr + ' </span>'
							}
					    	var middle = '<div class="fl" style="width:100%;"><div class="fbsjkc fl ml25"><p class="fl" style="width:150px;">'+data.datelineStr+ '发布</p><p class="fl" style="color:#999;">总分:'+data.examscore+'分<span style="padding:0 10px;"></span></p><p class="kkjssj">计时:'+(data.limittime == 0?'不限时':data.limittime +'分钟')+'<span style="padding:0 10px;"></span></p><p class="kkjssj cyrss">参与人数：'+answercount+'/'+(count == 0?answercount:count)+'<span style="padding:0 10px;"></span></p><p class="kkjssj cyrus">'+etype+'</p><br /><p style="    width: 700px;display: inline-block; white-space: nowrap; height: 22px;line-height:22px; overflow: hidden;text-overflow: ellipsis;" class="">关联课程：<a class="filterF" folderid="'+folderid+'" href="javascript:void(0);" title="'+relationname+'">'+ relationnames +'</a><a class="glkc" target="_blank"></a>'+classmiddle+'</p></div>'+fr+'</div><div class="clear:both;"></div><div class="clear:both;"></div>';

							/* 构造下面的*/
							var bottom = '';
					    	if(answercount <= 0 && data.status == 1){
					    		var bottom = '<div class="hsidts1s ml25" style="float:left;display:inline;width:100%;"><a href="javascript:void(0)" onclick="getDSword('+data.eid+')"  class="lasrnwe">导出为word</a></div>';
					    	}else if (data.status == 1) {
					    		var bottom = '<div class="hsidts1s ml25" style="float:left;display:inline;width:100%;"><a href="javascript:void(0)" onclick="getDSword('+data.eid+')"  class="lasrnwe">导出为word</a><a class="lasrnwe" target="_blank" href="/troomv2/examv2/efenxi/'+ data.eid + '.html">统计分析</a><a href="/troomv2/examv2/errorRanking/'+ data.eid + '.html" target="_blank" class="lasrnwe">错题排名</a></div>';
					    	}
							var $dom = $('<div class="workdatabzylist1">'+title + middle + bottom + '</div>');
							$("#exams").append($dom);
						}
						$('.workdatabzylist1:last').css('border-bottom','none');
					}else{
						$('#examworkList').remove();
					}
			}
			}
		});
	}
	function delexamss(eid,crid) {
	        var url = '<?= geturl('troomv2/examv2/del') ?>';
			var d = top.dialog({
			title: '删除确认',
			content: '作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？',
			okValue: '确定',
			ok: function () {
	        $.ajax({
	            url:url,
	            type:'post',
	            data:{'eid':eid},
	            dataType:'text',
	            success:function(data){
	                if(data==1){
	                    var d = dialog({
								title: '作业删除',
								content: '作业删除成功！',
								cancel: false
							});
						d.show();
						setTimeout(function () {
							location.reload();
							d.close().remove();
						}, 2000);
	                }else{
	                    var d = dialog({
							title: '作业删除',
							content: '作业删除失败，请稍后再试或联系管理员！',
							cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
	                }
	            }
	        });
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}

	function getDSword(eid){
		var wordsel = '<p style="text-align:left">生成视频解析二维码</p><ul  style="text-align:left;font-size:13px;"><li style="line-height: 36px;"><input id="FullVolume" name="asdas" type="checkbox"/><label for="FullVolume">整卷二维码（扫码查看本卷所有视频解析）</lable></li><li><input id="SingleItem" type="checkbox"/><label  for="SingleItem">单题二维码（扫码查看试题对应的视频解析）</lable></li></ul>';
		var d = top.dialog({
			title: '导出为word',
			content: wordsel,
			okValue: '导出',
			ok: function () {
				var flag = 0;
				if(parent.$('#FullVolume').prop('checked') == true && parent.$('#SingleItem').prop('checked') == true ){
					flag = 3;
				}else if(parent.$('#FullVolume').prop('checked') == true && parent.$('#SingleItem').prop('checked') == false){
					flag = 1;
				}else if(parent.$('#FullVolume').prop('checked') == false && parent.$('#SingleItem').prop('checked') == true){
					flag = 2;
				};
	            window.open('/troomv2/word/outword/'+eid+'.html?flag='+ flag);
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}
	function make_reply_dialog(upid,toid,obj){
		if($(obj).parent().parent().find('.commentreply').html() == undefined){
			$('.commentreply').remove();
            for(var i=0;i<$('.emoji_btn').length;i++){
                if(i!=0){
                    $($('.emoji_btn')[i]).remove();
                }
            }
			var html = '';
			html+='<div class="commentreply">';
	        html+='<div class="restore_arrow1 restore_arrow1tea"></div>';
	        html+='<textarea id="inputrating" class="inputrating inputrating-reply" tips="'+$(obj).attr('tips')+'">'+$(obj).attr('tips')+'</textarea>'
			html+='<a href="javascript:;" onclick="reply_review('+upid+','+toid+',this);" class="reviews publish" type="'+$(obj).attr('type')+'">发&nbsp;布</a>';
	        html+='</div>';
	        html+='<div class="clear"></div>';

	        $(obj).parents('.commentsright-bottom').after(html);
			hljs.initHighlightingOnLoad();
		        /*$("#inputrating").emoji({
		            showTab: true,
		            animation: 'fade',
		            icons: [{
		                name: "贴吧表情",
		                path: "http://static.ebanhui.com/ebh/js/qqFace/tieba/",
		                maxNum: 50,
		                file: ".gif",
		                placeholder: "[tieba_{alias}]",
		                title: {
		                    1: "呵呵",
		                    2: "哈哈",
		                    3: "吐舌",
		                    4: "啊",
		                    5: "酷",
		                    6: "怒",
		                    7: "开心",
		                    8: "汗",
		                    9: "泪",
		                    10: "黑线",
		                    11: "鄙视",
		                    12: "不高兴",
		                    13: "真棒",
		                    14: "钱",
		                    15: "疑问",
		                    16: "阴脸",
		                    17: "吐",
		                    18: "咦",
		                    19: "委屈",
		                    20: "花心",
		                    21: "呼~",
		                    22: "笑脸",
		                    23: "冷",
		                    24: "太开心",
		                    25: "滑稽",
		                    26: "勉强",
		                    27: "狂汗",
		                    28: "乖",
		                    29: "睡觉",
		                    30: "惊哭",
		                    31: "生气",
		                    32: "惊讶",
		                    33: "喷",
		                    34: "爱心",
		                    35: "心碎",
		                    36: "玫瑰",
		                    37: "礼物",
		                    38: "彩虹",
		                    39: "星星月亮",
		                    40: "太阳",
		                    41: "钱币",
		                    42: "灯泡",
		                    43: "茶杯",
		                    44: "蛋糕",
		                    45: "音乐",
		                    46: "haha",
		                    47: "胜利",
		                    48: "大拇指",
		                    49: "弱",
		                    50: "OK"
		                }
		            }, {
		                path: "http://static.ebanhui.com/ebh/js/qqFace/qq/",
		                maxNum: 91,
		                excludeNums: [41, 45, 54],
		                file: ".gif",
		                placeholder: "[qq_{alias}]"
		            }]
		        });*/

		    $("#btnLoad2").click(function () {
		        $("#editor").emoji({
		            button: "#btn",
		            showTab: false,
		            animation: 'slide',
		            icons: [{
		                name: "QQ表情",
		                path: "dist/img/qq/",
		                maxNum: 91,
		                excludeNums: [41, 45, 54],
		                file: ".gif"
		            }]
		        });
			var thetop1 = parseInt($('#emoji_btn_1').css("top")) - 90;
	var thetop2 = parseInt($('#emoji_container_1').css("top")) - 90;
	$('#emoji_btn_1').css({"top":thetop1+"px"});
	$('#emoji_container_1').css({"top":thetop2+"px"});
	$('.face').qqFace({
		id : 'facebox',
		assign:'comment-input',
		top:'-160px',
		path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
	});
			});

	        $('.inputrating-reply').focus(function(){
				if($(this).val() == $(this).attr('tips')){
					$(this).css('color','#000');
					$(this).val('');
				}
			});
			$('.inputrating-reply').blur(function(){
				if($(this).val() == ''){
					$(this).css('color','#999');
					$(this).val($(this).attr('tips'));
				}
			});

			$('.rate-face').qqFace({
				id : 'facebox',
				assign:'inputrating',
				top:'-100px',
				path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
			});

			$('.rate-face').click(function(){
				if($('.inputrating-reply').val() == $('.inputrating-reply').attr('tips')){
					$('.inputrating-reply').val('');
				}

			})
			//修复IE下重绘延迟
			$('.commentsright').css('visibility','visible');
		}else{
			$('.commentreply').remove();
            for(var i=0;i<$('.emoji_btn').length;i++){
                if(i!=0){
                    $($('.emoji_btn')[i]).remove();
                }
            }
			//修复IE下重绘延迟
			$('.commentsright').css('visibility','inherit');
		}


	}


	//回复评论
	function reply_review(upid,toid,objx){
		var msg = $(objx).siblings('.inputrating').val()
		if(msg == '' || msg == $(objx).siblings('.inputrating').attr('tips')){
			var d = dialog({
			    title: '提示',
			    content: '回复内容不能为空。',
			    cancel: false,
				okValue: '确定',
			    ok: function () {}
			});
			d.showModal();
			$(objx).siblings('.inputrating').focus();
			return false;
		}else if(msg.replace(/<[^>]*>/g,'').length>100){
			var d = dialog({
				title: '提示',
				content: '回复内容不能大于100字',
				cancel: false,
				okValue: '确定',
				ok: function () {}
			});
			d.showModal();
			$(objx).siblings('.inputrating').focus();
			return false;
		}


		var url = "<?= geturl('troomv2/review/reply')?>";

		var type = $(objx).attr('type');
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'upid':upid,'toid':toid,'type':type},
			dataType:'json',
			success:function(result){
				if(result.status == 1){
					var avatar_src = '<?=getavater($user,'50_50')?>';
					if(type == 'courseware_reply'){
						if($(objx).parent().siblings('.commentlist').html() == undefined){
							reply_log[upid] = {
								<?=$user['uid']?>:{
									avatar : avatar_src
								},
								count:1
							}
							var html = '';
							html+= '<div class="commentlist">';
							html+='<div class="restore_arrow2"></div>';
							html+='<div class="commentlistson">';
							html+='<div class="commentlistsontop">';
							html+='<div class="peoplereplied"><span class="reply_count">1</span>个人回复：</div>';
							html+='<ul>';
							html+='<li><img src="'+avatar_src+'" class="circular"></li>';
							html+='</ul>';
							html+='<div style="display:none;"  class="open-reply-btn"><a href="javascript:;" onclick="open_reply_dialog(this)" class="studentname open">展开&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/zhankai.png" class="openico"></a></div>';
							html+='<div class="close-reply-btn"><a href="javascript:;" onclick="close_reply_dialog(this)" class="studentname open">收起&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/shouqi.png" class="openico"></a></div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='<div class="commentlistsonbottom"">';
							html+='<ul>';
							html+='<li>';
							html+='<div class="replycomment">';
							html+='<ul>';
							html+='<li class="replycommentli last" id="comment_'+result.logid+'">';
							html+='<div class="replycommentliright">';
							html+='<a href="javascript:void(0);" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);" >删除</a>';
							html+='</div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='</li></ul></div></li></ul></div></div></div>';
							$(objx).parent().next().after(html);
						}else{
							if(reply_log[upid][<?=$user['uid']?>] == undefined){
								reply_log[upid][<?=$user['uid']?>] = {
									avatar : avatar_src
								}
								reply_log[upid].count++;

								if(reply_log[upid].count <= 9){
									$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsontop').children('ul').append('<li><img src="'+avatar_src+'" class="circular" /></li>')
								}


							}
							var html='';
							html+='<li class="replycommentli last" id="comment_'+result.logid+'">';
							html+='<div class="replycommentliright">';
							html+='<a href="javascript:void(0);" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>';
							html+='</div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='</li>';
							$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsonbottom').find('.replycomment').children('ul').append(html);

							$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsontop').children('.peoplereplied').children('.reply_count').html(reply_log[upid].count);

							$('#comment_'+result.logid).prev().removeClass('last');
						}
					}else{
						var toname = $(objx).parent().siblings('.studentname').html();
						if($(objx).parents('.replycommentli').find('.replycommentson').html() == undefined){
							var html = '';
							html = '<div class="replycommentson">'
							+'<ul>'
							+'<li class="replycommentli1 first" id="comment_'+result.logid+'">'
							+'<div class="replycommentliright">'
							+'<a href="javascript:void(0);" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							+'<span class="comment">回复</span>'
							+'<a href="javascript:void(0);" class="studentname">'+toname+'</a>'
							+' <span class="totalscore">'+get_now_tiem()+'</span>'
							+'<div class="commentsright-center">'
							+replace_em(msg)
							+'</div>'
							+'<div class="commentsright-bottom">'
							+'<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>'
							+'</div></div></li></ul></div>'
							$(objx).parents('.replycommentli').append(html);
						}else{
							var html = '';
							html = '<li class="replycommentli1 first" id="comment_'+result.logid+'">'
							+'<div class="replycommentliright">'
							+'<a href="javascript:void(0);" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							+'<span class="comment">回复</span>'
							+'<a href="javascript:void(0);" class="studentname">'+toname+'</a>'
							+' <span class="totalscore">'+get_now_tiem()+'</span>'
							+'<div class="commentsright-center">'
							+replace_em(msg)
							+'</div>'
							+'<div class="commentsright-bottom">'
							+'<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>'
							+'</div></div></li>'
							$(objx).parents('.replycommentli').find('.replycommentson>ul').append(html);
						}
					}
					$('.commentsright').css('visibility','inherit');
					//回复完成后移除回复窗口
					$('.commentreply').remove();
					for(var i=0;i<$('.emoji_btn').length;i++){
						if(i!=0){
							$($('.emoji_btn')[i]).remove();
						}
					}

				}else if(result.status == -1){
				var str = '';
                    $.each(result.Sensitive,function(name,value){
                    	str+=value+'&nbsp;';
                    });
                    var d = dialog({
						title: '提示',
						content: '评论包含敏感词汇'+str+'！请修改后重试...',
						cancel: false,
						okValue: '确定',
						ok: function () {
						}
					});
					d.showModal();
				}
				else
				{
					alert(result.msg);
				}
			}
		});

	}
	//点赞评论
	function votereview(e,logid) {
		var t = $(e);
		$.ajax({
			'url': '/troomv2/course/ajax_upvote.html',
			'type': 'post',
			'dataType': 'json',
			'data': { 'logid' : logid },
			'success': function(ret) {
				if (ret && ret.errno == 0) {
					t.addClass('review_zaned');
					var votenum = parseInt(t.html());
					t.html(votenum + 1);
				}
				t = null;
			}
		});
		e.onclick = null;
	}
	var upvote = 0;
	//切换评论
	function changeOrder(e, ordertype) {
		var t = $(e);
		if (t.hasClass('thin')) {
            for(var i=0;i<$('.emoji_btn').length;i++){
                if(i!=0){
                    $($('.emoji_btn')[i]).remove();
                }
            }
			t.removeClass('thin');
			upvote = ordertype;
			$(t.siblings('span')).addClass('thin');

			var page = 1;
			var url = "/troomv2/course/getajaxpage.html";
			page_load(page,url);
		}
	}

	//课件评论异步加载
	function page_load(pagetxt,url){
		var cwid = $("#cwid").val();//课件id
        var pagetext = pagetxt;//分页按钮txt文本
        var page = 1;
        var groupid = $("#groupid").val();//用于判断是老师还是学生
        var curdomain = $("#domain").val();
        //检查文本格式 *数字 * 上一页 * 下一页 * 跳转
        if(!isNaN(pagetext)){
                page = pagetext;
       	}else if(pagetext=='下一页&gt;&gt;'){
            lastp = parseInt($(".none").html());
            page = lastp+1;
        }else if(pagetext=='&lt;&lt;上一页'){
            lastp = parseInt($(".none").html());
            var np = lastp-1;
            page = ((np)<=0)?1:np;
        }else if(pagetext=='跳转'){
            page = $("#gopage").attr("value");
        }

        /**ajax后台读取json数据*/
        $.post(url,{'cwid':cwid,'page':page, 'upvote': upvote},function(data){
        	var demohtml = '';
        	var json = data.reviews;
        	var domaina = window.location.href;
            var domain = domaina.replace("http://", "");
            var maina = domain.split('/');
            maina.splice(0, 1);
            maina.splice(maina.length - 1, 1);
            var last = maina.join("/");

            if(json!=''){
            	demohtml += '<div class="allcomments">'
            		+'<div class="alltitle"><span onclick="changeOrder(this, 0)" class="'+(upvote ? 'thin' : '')+'">全部评论</span>'+(isnewzjdlr ? '<span class="zjdlr-hot '+(!upvote ? 'thin' : '')+'" onclick="changeOrder(this, 1)">热门评论</span>' : '')+'</div>'
            		+'<div class="allcommentslist">'
            		+'<ul class="ul1">';
            	//$('.allcomments').html('');
            	for (var i=0;i<json.length;i++){
 					if(i==(json.length-1)){
 						demohtml+='<li id="comment_'+json[i].logid+'" class="last">';
 					}else{
 						demohtml+='<li id="comment_'+json[i].logid+'">';
 					}
            		demohtml+='<div class="avatar-1"><img src="'+get_avatar(json[i])+'" class="circular" title="'+json[i].fromip+'('+json[i].ipaddress+')" /></div>'
            		+'<div class="commentsright">'
            		+'<div class="commentsright-top">';
					var zan = '';
            		<?php if($isnewzjdlr){?>
            		demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].realname+'</a>';
					if (json[i].upvoted) {
						zan = '<a href="javascript:;" class="review_zan review_zaned">'+json[i].upvotenum+'</a>';
					} else {
						zan = '<a href="javascript:;" class="review_zan" onclick="votereview(this,'+json[i].logid+')">'+json[i].upvotenum+'</a>';
					}
					<?php }else{?>
					demohtml+='<a href="javascript:void(0);" class="studentname" title="'+json[i].fromip+'('+json[i].ipaddress+')">'+json[i].username+'（'+json[i].realname+'）</a>';
					<?php }?>
            		<?php if(!$iszjdlr){?>
            		demohtml+=getstar_new(json[i].score);
            		<?php }?>
            		demohtml+='<span class="totalscore time">'+get_time(json[i].dateline)+'</span>'
            		+'</div>'
            		+'<div class="commentsright-center">'
            		+replace_em(json[i].subject)
            		+'</div>'
            		+'<div class="commentsright-bottom">';
            		//置顶
            		<?php if(!empty($isnewzjdlr) && !empty($roominfo['uid']) && !empty($user['uid']) && ($roominfo['uid']==$user['uid'])){ ?>
		            		if(json[i].toptime > 0){
		            			demohtml += '<a href="javascript:;" class="shield" onclick="top_comment('+json[i].logid+',this,0)">取消置顶</a>'
		            		}else{
		            			demohtml += '<a href="javascript:;" class="shield" onclick="top_comment('+json[i].logid+',this,1)">置顶</a>'
		            		}
            		<?php }?>
            		demohtml += zan;
            		if(json[i].uid != <?=$user['uid']?>){
            			demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].logid+','+json[i].uid+',this)" tips="回复给'+json[i].realname+'：" type="courseware_reply">回复</a>'
            		}
            		if(json[i].uid == <?=$user['uid']?>){
            			demohtml+='<a href="javascript:;" style="margin-left: 0;" class="shield delatereviews" onclick="del_comment('+json[i].logid+',this);">删除</a>';

            		}else{
						<?php
						if (empty($isnewzjdlr)) { ?>
							demohtml+='<a href="javascript:shield(<?=$course['cwid']?>,'+json[i].logid+');" class="shield">屏蔽</a>';
						<?php }	?>
            		}
            		demohtml+='</div>';
            		//评论回复开始
            		if(json[i].children.length > 0){
            			demohtml+='<div class="commentlist">'
            			+'<div class="restore_arrow2"></div>'
            			+'<div class="commentlistson">'
            			+'<div class="commentlistsontop">';
            			var reply_arr = {count:0};
            			for (var second=0;second<json[i].children.length;second++){
            				if(typeof(reply_arr[json[i].children[second].uid]) == 'undefined'){
            					reply_arr[json[i].children[second].uid] = {
	            					avatar:get_avatar(json[i].children[second])
	            				}
	            				reply_arr.count++
            				}
            			}
            			reply_log[json[i].logid] = reply_arr;
            			demohtml+='<div class="peoplereplied"><span class="reply_count">'+reply_arr.count+'</span>个人回复：</div>'
            			+'<ul>';
            			var round = 0;
            			$.each(reply_arr,function(i,n){
            				if(i != 'count'){

            					demohtml+='<li><img src="'+n.avatar+'" class="circular" /></li>'

            					if(round == 9){
            						demohtml+=' <li><img src="http://static.ebanhui.com/ebh/tpl/2016/images/more.png" class="circular" /></li>';
            						return false;
            					}
            					round++;
            				}
            			});
            			demohtml+='</ul>'
            			+'<div  class="open-reply-btn"><a href="javascript:;" onclick="open_reply_dialog(this)" class="studentname open">展开&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/zhankai.png" class="openico" /></a></div>'
            			+' <div style="display:none;" class="close-reply-btn"><a href="javascript:;" onclick="close_reply_dialog(this)" class="studentname open">收起&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/shouqi.png" class="openico" /></a></div>'
            			+'</div>'
            			+'<div class="clear"></div>'
            			+'<div class="commentlistsonbottom" style="display:none;" >'
            			+'<ul><li><div class="replycomment"><ul>';
            			//二级评论开始
            			for (var second=0;second<json[i].children.length;second++){
            				if(second == (json[i].children.length-1)){
            					demohtml+='<li class="replycommentli last" id="comment_'+json[i].children[second].logid+'">';
            				}else{
            					demohtml+='<li class="replycommentli" id="comment_'+json[i].children[second].logid+'">';
            				}
            				demohtml+='<div class="replycommentliright">'
            				<?php if (empty($isnewzjdlr)) { ?>
            					demohtml+='<a href="javascript:void(0);"  class="studentname">'+json[i].children[second].username+'（'+json[i].children[second].realname+'）</a>'
							<?php }else{ ?>
								demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].children[second].realname+'</a>'
            				<?php } ?>
            				demohtml+='<span class="totalscore">'+get_time(json[i].children[second].dateline)+'</span>'
            				+'<div class="commentsright-center">'
            				+replace_em(json[i].children[second].subject)
            				+'</div>'
            				+'<div class="commentsright-bottom">';
            				if(<?=$user['uid']?> == json[i].children[second].toid){
            					demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].children[second].logid+','+json[i].children[second].uid+',this)" tips="回复给'+json[i].children[second].realname+'：" type="courseware_reply_son">回复</a>'
		            		}
		            		if(json[i].children[second].uid == <?=$user['uid']?>){
		            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].children[second].logid+',this);">删除</a>';

		            		}
		            		demohtml+='</div></div><div class="clear"></div>';
		            		//三级评论开始
		            		if(json[i].children[second].children.length > 0){
		            			demohtml+='<div class="replycommentson">'
		            			+'<ul>';
		            			for (var third=0;third<json[i].children[second].children.length;third++){

		            				if(third > 2){
		            					demohtml+='<li class="replycommentli1 first" style="display:none;" id="comment_'+json[i].children[second].children[third].logid+'">';
		            				}else{
		            					demohtml+='<li class="replycommentli1 first" id="comment_'+json[i].children[second].children[third].logid+'">';
		            				}
		            				demohtml+='<div class="replycommentliright">'
		            				<?php if (empty($isnewzjdlr)) { ?>
		            					demohtml+='<a href="javascript:void(0);" class="studentname">'+json[i].children[second].children[third].username+'（'+json[i].children[second].children[third].realname+'）</a>'
									<?php }else{ ?>
										demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].children[second].children[third].realname+'</a>'
		            				<?php } ?>
		            				demohtml+='<span class="comment">回复</span>'
		            				<?php if (empty($isnewzjdlr)) { ?>
		            					demohtml+='<a href="javascript:void(0);" class="studentname">'+json[i].children[second].children[third].tousername+'（'+json[i].children[second].children[third].torealname+'）</a>'
									<?php }else{ ?>
										demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].children[second].children[third].torealname+'</a>'
									<?php } ?>
		            				demohtml+='<span class="totalscore">'+get_time(json[i].children[second].children[third].dateline)+'</span>'
		            				+'<div class="commentsright-center">'
		            				+replace_em(json[i].children[second].children[third].subject)
		            				+'</div>'
		            				+'<div class="commentsright-bottom">';
		            				if(<?=$user['uid']?> == json[i].children[second].children[third].toid){
		            					demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].children[second].logid+','+json[i].children[second].children[third].uid+',this)" tips="回复给'+json[i].children[second].children[third].realname+'：" type="courseware_reply_son">回复</a>'
				            		}
				            		if(json[i].children[second].children[third].uid == <?=$user['uid']?>){
				            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].children[second].children[third].logid+',this);">删除</a>';

				            		}
				            		demohtml+='</div>'
				            		+'</div>'
				            		+'</li>';

		            			}
		            			demohtml+='</ul>';
		            			if(json[i].children[second].children.length > 3){
		            				demohtml+='<div class="viewall"><a href="javascript:;"  onclick="show_all(this)">点击查看全部</a></div>';
		            			}


		            			demohtml+='</div>';
		            		}
		            		//三级评论结束
		            		demohtml+='</li>';


            			}
            			//二级评论结束
		            	demohtml+='</ul></div></li> </ul> </div></div> </div>'
            		}
            		//评论回复结束
            		demohtml+='</div></li>';



            	}
            	demohtml+='</ul></div></div>';

            }
            $('.allcomments').html(demohtml);
            $('.allcomments').css('visibility','visible');
            	$('#reviewcount').html(data.count);
            	//弹出发送私信
				$('.hrelh1s').click(function(e){
					window.H.get('wxDialog').exec('show');
					$("#wrap2").html("");
			        $("textarea.txttiantl").val("");
			        //添加收件人
			        var tid = $(this).attr("tid");
			        var tname = $(this).attr("tname");
			        $("#wrap2").append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');
			        //焦点对话框
			        $("textarea.txttiantl").focus();
				});
            //分页处理
            $(".pages").html(data.pagestr);
            $(".pages a").unbind();

            $(".pages a").each(function(){
                $(this).removeAttr("href");
                $(this).css("cursor",'pointer');
                $(this).bind("click",function(){var pagetxt = $(this).html();page_load(pagetxt,url)});
                    //显示当前页
                var ptxt =$(this).html();
                if(!isNaN(ptxt) && ptxt == page){
                    $(this).addClass("none");
                }else{
                    $(this).removeClass("none");
                }
            })

        },'json')
	}

	//取星星
    function getstar_new(num)
    {
        var starword='';
        num=parseInt(num);
        if(num>5)
        {
            num=5;
        }
        for(i =0;i<num;i++)
        {
            starword+='<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars1.png">';
        }
        if(5-num>0)
        {
            for(j =0;j<5-num;j++)
            {
                starword+='<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png">';
            }
        }
        return starword;
    }
</script>
<!--新评论JS结束-->
<script type="text/javascript">
var _xform = new xForm({
		domid:'rev',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});



	//播放
   $(function (){
			var cwid = <?= $course['cwid'] ?>;
			var isfree = 1;
			var num = 1;//教室内
			var lastsuffix = 'flv';
			<?php if(!empty($ext)){?>
				lastsuffix = '<?= $ext ?>';
			<?php } ?>
			if(lastsuffix == 'flv'){
				//flv
				<?php
					if(!empty($course['m3u8url'])) {
				?>
					playmu('<?= $course['m3u8url'] ?>',cwid,'',isfree,num,'562','958',0,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>);
				<?php
					} else if(!empty($course['rtmpurl'])) {
				?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','958',0,'<?= $course['thumb'] ?>');
				<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','958',0);
				<?php } ?>

			}else if (lastsuffix == 'mp3'){
				//ebh
				playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','958',0);
			}else if (lastsuffix == 'ebh' || lastsuffix == 'ebhp'){
				//ebh
				freeebh('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'700','958',1);
			}else if(lastsuffix == 'swf'){
                playswf('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','958',0)
            }
	});

    function ablank(url){
		window.open(url);
    }

    $(function(){
        var button = new xButton();
        button.add({
            value:'确定',
            callback:function(){
                submit_refuse();
                $("#repcontent").val("");
                return false;
            },
            autofocus:true
        });
        button.add({
            value:'取消',
            callback:function(){
                $("#repcontent").val("");
				$("#msg").html("");
                H.get('commentdiv').exec('close');
                return false;
            }
        });
        H.create(new P({
            id:'commentdiv',
            title:'回复评论',
            content:$(".commentdiv")[0],
            easy:true,
            width:480,
            button:button,
            padding:5
        },{
			'onclose':function(){
				$("#repcontent").val("");
				return false;
			},
			'onshow':function(){
				$("#msg").html("");
				return false;
			}
		}));
	});

    function reply(content,target,logid,type,toid)
	{

		$("#type").val(type);
		$("#toid").val(toid);
		$("#target").text(target);
		$("#logid").val(logid);
		$("#content").text(content);
        H.get('commentdiv').exec('show');
	}
    function submit_refuse(){
		if($("#repcontent").val()==''){
			$("#msg").text('回复内容不能为空！');
			return;
		}else if($("#repcontent").val().length >70){
			$("#msg").text('回复内容应为1-70个字符！');
			return;
		}else{
			$("#msg").text('');
		}
		var _logid = $("#logid").val();
		var _type = $("#type").val();
		var _toid = $("#toid").val();
			var _repcontent = $("#repcontent").val();
			var url = '<?= geturl('troomv2/review/reply') ?>';
		$.ajax({
			type:'post',
			url:url,
			dataType:'json',
			data:{'logid':_logid,'type':_type,'toid':_toid,'repcontent':_repcontent},
			success:function(_json){
				if(_json.status == 1){
					var htmlcontent = '<div class="restore"><div class="restore_arrow">◆</div><div class="restore_cont"><h1>我的回复：</h1>'+_repcontent+'</div></div>';
					$("#review_" + _logid).after(htmlcontent);
					$("#replay_" + _logid).remove();

					H.get('commentdiv').exec('close');
				} else if(_json.status == -1){
					var str = '';
                    $.each(_json.Sensitive,function(name,value){
                    	str+=value+'&nbsp;';
                    });
                    var d = dialog({
						title: '提示',
						content: '评论包含敏感词汇'+str+'！请修改后重试...',
						cancel: false,
						okValue: '确定',
						ok: function () {
						}
					});
					d.showModal();
				}
				else{
					$("#msg").text(_json.msg);
				}
			}
		})
	}
	function delexam(eid,cwid,title) {
		$.confirm("确认要删除作业 [" + title + "] 吗？", function() {
			var url = "<?= geturl('troomv2/course/delexam')?>";
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'cwid':cwid,'eid':eid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
						$.showmessage({
                            img : 'success',
                            message:'删除作业成功',
                            title:'删除作业',
                            callback :function(){
                                 $("#exam_"+eid).remove();
                            }
                        });
					} else {
						var msg = '上传失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
						$.showmessage({
                            img : 'error',
                            message:msg,
                            title:'删除作业'
                        });
					}
				}
			});
		});
	}

	//屏蔽
	function shield(cwid,logid){
			var url = "<?= geturl('troomv2/course/shield')?>";
            var obj = $("#comment_"+logid);
            var count = $("#reviewcount").html();
			var d = dialog({
			title: '屏蔽评论',
			content: '您确定要屏蔽该评论吗？屏蔽后不可查看该评论!',
			okValue: '确定',
			ok: function () {
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'cwid':cwid,'logid':logid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>屏蔽评论信息成功！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									that.close().remove();
                                    for(var i=0;i<$('.emoji_btn').length;i++){
                                        if(i!=0){
                                            $($('.emoji_btn')[i]).remove();
                                        }
                                    }
								}, 1000);
							}
						}).show();
						if(obj.hasClass('last')){
                        	obj.prev().addClass('last');
                        }
                        obj.remove();

                        $("#reviewcount").html(count-1);
                        if(count == 1){
                           // alert(11);
                            var html = '<dl>';
                            html+= '<div id="nocommentdiv" style="width:100%;height:50px;">暂无任何评论</div>'
                            html+= '</dl>';
                            $(".appraise").append(html);
                        }
					} else {
						var msg = '屏蔽评论失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>"+msg+"</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									that.close().remove();
                                    for(var i=0;i<$('.emoji_btn').length;i++){
                                        if(i!=0){
                                            $($('.emoji_btn')[i]).remove();
                                        }
                                    }
								}, 1000);
							}
						}).show();
					}
				}
			});
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}
    function delexam2(eid,crid) {
        dialog({
        title:"提示信息",
        content:"作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？",
        cancelValue:"取消",
        cancel:function () {
        	this.close().remove();
        },
        okValue:"确定",
        ok:function(){
        	var url = '<?= geturl('troomv2/classexam/del') ?>';
            $.ajax({
                url:url,
                type:'post',
                data:{'eid':eid},
                dataType:'text',
                success:function(data){
                    if(data==1){
                        top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>作业删除成功</p>",
                        onshow:function () {
	                        var that=this;
	                        setTimeout(function() {
		                        that.close().remove();
		                        location.reload();
	                        }, 1000);
                        }
                        }).showModal();
                    }else{
/*                        $.showmessage({
                            img      : 'error',
                            message  :  '作业删除失败',
                            title    :      '作业删除      失败',
                            timeoutspeed    :       500
                        });*/
                        top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>作业删除失败</p>",
                        onshow:function () {
	                        setTimeout(function() {
		                        that.close().remove();
	                        }, 2000);
                        }
                        }).showModal();
                    }
                }
            });
        this.close().remove();
        }
        }).show();

    }
     function delexamNew(eid) {
        dialog({
        title:"提示信息",
        content:"作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？",
        cancelValue:"取消",
        cancel:function () {
        	this.close().remove();
        },
        okValue:"确定",
        ok:function(){
        	var url = '/troomv2/examv2/del.html';
            $.ajax({
                url:url,
                type:'post',
                data:{'eid':eid},
                dataType:'text',
                success:function(data){
                    if(data==1){
                        top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>作业删除成功</p>",
                        onshow:function () {
	                        var that=this;
	                        setTimeout(function() {
		                        that.close().remove();
		                        location.reload();
	                        }, 1000);
                        }
                        }).showModal();
                    }else{
/*                        $.showmessage({
                            img      : 'error',
                            message  :  '作业删除失败',
                            title    :      '作业删除      失败',
                            timeoutspeed    :       500
                        });*/
                        top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>作业删除失败</p>",
                        onshow:function () {
	                        setTimeout(function() {
		                        that.close().remove();
	                        }, 2000);
                        }
                        }).showModal();
                    }
                }
            });
        this.close().remove();
        }
        }).show();

    }
	$('.reviewtab,.asktab').click(function(){
		$('.workcurrent').removeClass('workcurrent');
		$(this).addClass('workcurrent');
		$('.emoji_btn').hide();
	});
	$('.asktab').click(function(){
		$('.emoji_btn').hide();
	});
	$('.reviewtab').click(function(){
		$('.emoji_btn').show();
	});
	var askloaded = false;
	var moreask = false;
	function showask(){
		$('#reviewdiv').hide();
		$('#cmdiv').hide();
		$('#askdiv').show();
        $('#sixin').hide();
		var cwid = <?= $course['cwid'] ?>;
		if(askloaded == false){
			$.ajax({
				url : '/troomv2/course/linkask.html',
				type : 'post',
				data : {cwid:cwid},
				success : function(data){
					if(askloaded == false)
					result = eval('('+data+')');
					if(result['list'].length>0){
						$('#noask').hide();
						$.each(result['list'],function(idx,obj){
							$('.tweytr').append(formatasklist(obj));
						});
						if(result['count']>10){
							moreask = true;
							$('#moreask').show();
						}
					}
					askloaded = true;
				}
			});
		}
		else if(moreask)
			$('#moreask').show();
	}
	function showreview(){
		$('#askdiv').hide();
		$('#moreask').hide();
		$('#cmdiv').show();
		$('#reviewdiv').show();
        $('#sixin').show();
	}

	function formatasklist(list){

		var name = '';
		if(list.realname == '')
			name = list.username;
		else
			name = list.realname;

		var html = '<tr>';
		html+= '	<td style="border-top:none;padding: 20px 10px;">';
		html+= '	<div style="float:left;margin-right:15px;"><img title="'+name+'" src="'+list.face+'"style="width:40px;height:40px;border-radius:20px;" /></div>';
		html+= '	<div style="float:left;width:840px;font-family:Microsoft YaHei;">';
		html+= '		<p style="width:690px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">';
		if(list.reward>0){
		html+= '<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏'+list.reward+'积分">悬赏'+list.reward+'<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/></span>&nbsp';
		}
		html+= '		<a target="_blank" href="/troomv2/myask/'+list.qid+'.html" style="color:#777;font-weight:bold;">';
		if(list.status == 1){
		html+= '		<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>';
		}
		html+= shortstr(list.title);
		html+= '		</a>';
		html+= '		</p>';
		html+= '	<p class="dashu">回答数<br/><span style="">'+list.answercount+'</span></p>';
		html+= '		<div style="float:left;width:730px;">';
		html+= '	<span style="width:180px;float:left;">'+getformatdate(list.dateline)+'</span>';
		html+= '	<span class="huirenw" style="width:150px;float:left;">'+name+'</span>';
		html+= '	<span class="ketek" style="width:330px">'+list.foldername+'</span>';
		html+= '	</div>';
		html+= '	</div>';
		html+= '	</td>';
		html+= '</tr>';
		return html;
	}
	function getformatdate(timestamp)
	{
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	function frontzero(str)
	{
		str = str.toString();
		str.length==1?str="0"+str:str;
		return str;
	}
	function shortstr(str){
		var result = str.substr(0,46);
		if(result.length<str.length)
			result+= '...';
		return result;
	}
    //-->
    </script>
    <div class="commentdiv" style="display:none;overflow:hidden;text-align:left;">
        <input type="hidden" id="logid" value="" name="logid" />
        <input type="hidden" id="type" value="" name="type" />
        <input type="hidden" id="toid" value="" name="toid" />
        <table border="0" cellspacing="0" cellpadding="0" width="100%" style="text-align:left;">
            <tr><td colspan=2><span style="color: #D0304F">温馨提示：每条评论只能回复一次，请谨慎操作</span></td></tr>
            <tr>
                <td colspan=2>评论对象：<label id="target"></label></td>
            </tr>
            <tr style="margin:8px 0;">
                <td colspan=2>评论内容：<span style="word-wrap:break-word;width:370px;display:inline-block;" id="content"></span></td>
            </tr>
            <tr>
                <td colspan=2>回复内容：<textarea cols="50" rows="5"  id="repcontent" name="repcontent" style="width:380px;padding:5px;"></textarea></td>
            </tr>
            <tr>
                <td width="80"></td><td><em id="msg" style="color: #ff0000"></em></td>
            </tr>

        </table>
    </div>
    <div style="display:none;" class="Offl" id="showdiv"></div>
	<script type="text/javascript">
         /*
*评论
*/
    $(function(){

//  $(document).bind("click", function(e) {
//      if($(e.target).closest("#face").attr('id')=="face")
//      {
//          $("#face").hide();
//      }
//  });
    $("#showface").click(function(e){
        if($("#comm").val()=='请输入评论内容'){
            $("#comm").val("");
        }
        $('#face').toggle();
    })
    //展示效果
    $(".emotionbtn").parent().parent().hover(function(){
        $("#showimg").attr("src",$(this).find(".emotionbtn").attr("src"));
        $("#showtitle").html($(this).find("a").attr("title"));
        $("#showimg").show();
        $("#showtitle").show();
    },function(){
        $("#showimg").attr("src","");
        $("#showimg").hide();
        $("#showtitle").hide();
    });
    //点击事件
    $('.emotionbtn').parent().parent().click(function(){
        var code = $(this).find(".emotionbtn").attr("code");
        var title =$(this).find("a").attr("title");
        //just show text
        //$("#comm").append("["+title+"]");
        //just show image
        $("#comm").val($("#comm").val()+code);
        $('#face').toggle();
        $('#comm').focus();
    })
    //满意度单选点击事件
    $('input[name=cstar]').on('change',function(){
        var mark = $(this).val();
        $('#mark').val(mark);
    })
})



function CurentTime()
    {
        var now = new Date();

        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日

        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
        var ss = now.getSeconds();          //秒
        var clock = year + "-";

        if(month < 10)
            clock += "0";

        clock += month + "-";

        if(day < 10)
            clock += "0";

        clock += day + " ";

        if(hh < 10)
            clock += "0";

        clock += hh + ":";
        if (mm < 10) clock += '0';
        clock += mm+":";
        clock+= ss;
        return(clock);
    }

    //取星星
    function getstar(num)
    {
        var starword='';
        num=parseInt(num);
        if(num>5)
        {
            num=5;
        }
        for(i =0;i<num;i++)
        {
            starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif'/>";
        }
        if(5-num>0)
        {
            for(j =0;j<5-num;j++)
            {
                starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif'/>";
            }
        }
        return starword;
    }
    //取3个星星
    function getstar_3(num)
    {
        var starword='';
        num=parseInt(num);
        if(num>3)
        {
            num=3;
        }
        for(i =0;i<num;i++)
        {
            starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif'/>";
        }
        if(3-num>0)
        {
            for(j =0;j<3-num;j++)
            {
                starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif'/>";
            }
        }
        return starword;
    }
    //取评价文字
    function getstar_txt(num){
        var txt = '';
        if(num == 1){
            txt = '一般';
        }else if(num == 2){
            txt = '好';
        }else if(num == 3){
            txt = '很好';
        }
        return txt;
    }
//chose star
function rate(obj,oEvent){
    var imgSrc = 'http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif';
    var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif';
    if(obj.rateFlag) return;
    var e = oEvent || window.event;
    var target = e.target || e.srcElement;
    var imgArray = obj.getElementsByTagName("img");
    for(var i=0;i<imgArray.length;i++){
       imgArray[i]._num = i;
       imgArray[i].onclick=function(){
        if(obj.rateFlag) return;
        var inputid=this.parentNode.previousSibling
        inputid.value=this._num+1;
       }
    }
    if(target.tagName=="IMG"){
       for(var j=0;j<imgArray.length;j++){
        if(j<=target._num){
         imgArray[j].src=imgSrc_2;
        } else {
         imgArray[j].src=imgSrc;
        }
        target.parentNode.onmouseout=function(){
        var imgnum=parseInt(target.parentNode.previousSibling.value);
            for(n=0;n<imgArray.length;n++){
                imgArray[n].src=imgSrc;
            }
            for(n=0;n<imgnum;n++){
                imgArray[n].src=imgSrc_2;
            }
        }
       }
    } else {
         return false;
    }
    }
function fiterscr(str)
{

    while (str.indexOf('>') >= 0)
    {
       str = str.replace('>', '&gt');
    }
    while (str.indexOf('<') >= 0)
    {
       str = str.replace('<', '&lt');
    }
    return str;
}



    </script>
	<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
	<?php $this->display('common/player'); ?>
	<?php } ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=2016101301"></script>
    <?php $this->display('troomv2/page_footer'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript">
	$(function(){
		//拖拽
		dragAndDrop();
		//初始化位置
		initPosition();
	});
	//拖拽
	function dragAndDrop(){
		var _move=false;//移动标记
		var _x,_y;//鼠标离控件左上角的相对位置
		$(".video-play").mousedown(function(e){
			_move=true;
			_x=e.pageX-parseInt($(".video-float").css("left"));
			_y=e.pageY-parseInt($(".video-float").css("top"));
			//$(".wTop").fadeTo(20,0.5);//点击开始拖动并透明显示
		});
		$(document).mousemove(function(e){
			if(_move){
				var x=e.pageX-_x;//移动时鼠标位置计算控件左上角的绝对位置
				var y=e.pageY-_y;
				$(".video-float").css({top:y,left:x});//控件新位置
			}
		}).mouseup(function(){
			_move=false;
			//$(".wTop").fadeTo("fast",1);//松开鼠标后停止移动并恢复成不透明
		});
	}
	//初始化拖拽div的位置
	function initPosition(){
		//计算初始化位置
		var itop=($(document).height()-$(".video-float").height())/2;
		var ileft=($(document).width()-$(".video-float").width())/1.8;
		//设置被拖拽div的位置
		$(".video-float").css({top:itop,left:ileft});
	}
</script>
<script type="text/javascript">
$(function() {
	$(".upattach").on("click", function() {
		if($(this).attr('small') == 1){
			dheight = 110;
			dwidth = 550;
		} else {
			dheight = 460;
			dwidth = 960;
		}
		top.dialog({
			id:"coleck",
			title: $(this).attr('title'),
			url: $(this).attr('url'),
			width: dwidth,
			height: dheight,
			padding: 10
		}).showModal(); //show:无遮罩层,showModal:有遮罩层，需要全屏显示请在dialog前加上top,例：top.dialog({....}).showModal()
	});
});
function delattachment(attid){
	var url = "<?= geturl('troomv2/classcourse/delattach') ?>";
	var d2 = top.dialog({
			title: '删除确认',
			content: '确认删除该附件吗',
			okValue: '确定',
			ok: function () {
	        $.ajax({
	            url:url,
	            type:'post',
	            data:{'attid':attid},
	            dataType:'text',
	            success:function(data){
	                if($.trim(data) == 'success'){
	                    var d2 = dialog({
								title: '附件删除',
								content: '附件删除成功！',
								cancel: false
							});
						d2.show();
						setTimeout(function () {
							location.reload();
						}, 500);
	                }else{
	                    var d2 = dialog({
							title: '附件删除',
							content: '附件删除失败，请稍后再试或联系管理员！',
							cancel: false
						});
						d2.show();
						setTimeout(function () {
							d2.close().remove();
						}, 2000);
	                }
	            }
	        });
			},
			cancelValue: '取消',
			cancel: function () {}
		});
	d2.showModal();
}
	window.onscroll = function(){
	    var t = document.documentElement.scrollTop || document.body.scrollTop;
	    var top_div = document.getElementById( "video" );
	    if( t >= 720 ) {
			$("#video").addClass("video-float")
	    } else {
			$("#video").removeClass("video-float")
			$("#videotemp").attr('id','video');
	    }
	    return t;
	}
function closew(){
	$("#video").removeClass("video-float");
	$("#video").attr('id','videotemp');
}
Date.prototype.format = function(format)
{
	var o =
	{
	"M+" : this.getMonth()+1, //month
	"d+" : this.getDate(), //day
	"h+" : this.getHours(), //hour
	"m+" : this.getMinutes(), //minute
	"s+" : this.getSeconds(), //second
	"q+" : Math.floor((this.getMonth()+3)/3), //quarter
	"S" : this.getMilliseconds() //millisecond
	}

	if(/(y+)/.test(format)){
		format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
	}

	for(var k in o){
		if(new RegExp("("+ k +")").test(format)){
			format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
		}
	}
	return format;
}





/***************************************检查课件转码状态 start**********************************************************/
//获取课件转码状态
var ki = 1,kj=0;//...计数器从第一个.开始
var cwid = parseInt($('#cwid').val());
var ism3u8 = parseInt($('#ism3u8').val());
var cwtype = $('#cwtype').val();
var numTimer = null;
var ckTimer = null;
if(ism3u8!=1 && cwtype=='flv' ){
	//开启...滚动
	numTimer = setInterval('changenum()',500);
	//开启定时器,检查状态
	ckTimer = setTimeout('getCourseStatus()',5000);
}
//检查课件转码是否完成
function getCourseStatus(){
	$.post('/course/getstatus.html',{'cwid':cwid},function(json){
			if(json.code){
				//转码成功
				clearTimeout(ckTimer);
				clearInterval(numTimer);
				//刷新页面
				location.reload();
			}else{
				clearTimeout(ckTimer);
				ckTimer = setTimeout('getCourseStatus()',5000);
				}
		},'json');
}
/**
 * nums...数字变换
 */
function changenum(){
	tmp = '';
	for(kj=0;kj<ki;kj++){
		tmp += '.';
	}
	$('#randnums').html(tmp);
	ki++;
	if(ki>3) ki=0;
}
/*************************************检查课件转码状态 end************************************************************/
</script>