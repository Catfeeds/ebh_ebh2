<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$iszjdlr = empty($iszjdlr)?0:1;
	$isnewzjdlr = empty($isnewzjdlr)?0:1;
?>
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
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/qqFace/css/jquery.mCustomScrollbar.min.css"/>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/qqFace/css/jquery.emoji.css"/>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css<?=$v?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=$v?>" />

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=$v?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0704"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery-browser.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.qqFace.js"></script>
<!--新版表情!-->
<script src="http://static.ebanhui.com/ebh/js/qqFace/js/highlight.pack.js"></script>
<script src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.mCustomScrollbar.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.emoji.min.js?v=2017092101"></script>


<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/iconfont.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/demo.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/chatroom/font/iconfont.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate.js<?=$v?>"></script>
<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && isset($folder_detail['showmode']) && $folder_detail['showmode'] != 3){
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
<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016112401"></script>
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
#rewardmain{
	position: relative;
}
.qrcode_big{position: absolute;left: 5px;top:-30px;background: #fff;z-index: 99;border:solid 1px #ccc;width: 312px;height: 312px;}
.qrcode_big img{width: 310px;height: 310px;}
.triangle {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/triangle.jpg) no-repeat;
	width:13px;
	height:12px;
	position: absolute;
	z-index: 101;
	top:312px;
	left:60px;
}
#alipayqrcode iframe{width: 250px;height: 250px;margin-top:35px;margin-left:10px;}
	.datatab td{
		border: 0;
		padding: 3px 6px;
	}
	.tabhead th{
		padding:1px 6px;
	}
	.ewtkey{
		width:200px
	}
	.tweytr a{
		color : #3366CC;
	}
	.tijibtn {
		float: left;
		background: #18a8f7;
		width: 190px;
		height: 32px;
		display: inline;
		float: left;
		line-height: 32px;
		text-align: center;
		margin-left: 394px;
		color: #fff;
		font-size: 14px;
		text-decoration: none;
		cursor: pointer;
		border: none;
		border-radius:3px;
	}
	div.aui_inner{
		background: #fff;
	}
	.bq-set-show{
		display: none;
	}
	.classboxmore{
		border:none;
	}
.workcurrent a span {background:none;padding:0;}
.workcurrent a {padding:0;background:url(http://static.ebanhui.com/ebh/tpl/default/images/intit_02.jpg) no-repeat;width:118px;height:33px;line-height:33px;text-align:center;}
.work_mes ul li{font-size:14px;}
.classbox h1.rygers {width:820px; overflow:hidden;color:#333;margin-top:0px;height:36px;line-height:36px; padding-left:0; font-family:微软雅黑;font-size:20px;}
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
.fill{ border-top:none;}
.flaoter{ width:960px; border:none;z-index:1; }
.ter_tit{border:1px solid #e1e1e1;}
.lefrig a.huangbtn, .lefrig input.huangbtn{ border-radius:3px !important;}
.lefrig a.lanbtn, .lefrig input.lanbtn{border-radius:3px !important;}
.lefrig a.liaskt {background:#ffaf28;}
.lefrig a.liaskt:hover {background:#fea000;}

.appraise dl dt{
	border-top:none;
}
.appraise dl dd{
	border-top:none;
}
a.atfalsh1s{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left center;
    color: #fff;
    display: block;
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 35px;
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
    float: left;
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
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 43px;
    text-align: center;
    width: 90px;
	font-weight:normal;
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
}
.bzzytitle{
    font-family: 微软雅黑;
    color: #333;
    font-size: 14px;
	padding:3px 6px;
	float:left;
	display:inline;
	margin-left:10px !important;
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
.wdtkcs{
    color:#434348;
    font-family:微软雅黑;
}
.wdtkcs1s{
    padding:0 70px;
}
.zhqks1s{
    text-align:center;
    padding-bottom:20px;
    width:910px;
}
.nnbl {
    border-left: 4px solid #5e96f5;
    color: #333333;
    font-family: "微软雅黑";
    font-size: 16px;
    line-height: 18px;
    padding-left: 8px;
}
.qzsjlb {
    display: inline-block;
    padding-left: 45px;
}
.lefrig a.lviewbtn, .lefrig input.lviewbtn,.lefrig a.lviewbtn:hover, .lefrig input.lviewbtn:hover{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left 4px;
    color: #fff;
    display: block;
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 43px;
    text-align: center;
    width: 90px;
	font-weight:normal;
}
.bzzytitle {
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/bzzyico.jpg) no-repeat left center !important;
    padding-left: 25px;
    font-family: 微软雅黑;
    font-weight: bold;
    color: #333;
    font-size: 16px;
	margin-left:10px;
}
.flaoter a.tingfan, .flaoter a.shoutie, .flaoter a.lubij, .flaoter a.tiwenti, .flaoter a.yishout{
	color:#bbb;
	font-family: 微软雅黑;
	font-size:14px;
}
.flaoter a.yishout{
	width:42px;
	color:#18a8f7 !important;
}
.flaoter a:hover{
	color:#18a8f7 !important;
}
.qqFace{margin-top:4px;background:#fff;padding:2px;border:1px #dfe6f6 solid;}
.qqFace table td{padding:0px;}
.qqFace table td img{cursor:pointer;border:1px #fff solid;}
.qqFace table td img:hover{border:1px #0066cc solid;}
.edui-container{
	z-index:0!important;
}
body{ background:#8493af;}
.dashu{
	line-height:25px;
}
.video-float .wraps {
	margin-bottom:0px;
}
.onlinework{display: block;width: 118px;float: left;margin-left: 12px; text-align: center; background: url('http://static.ebanhui.com/ebh/tpl/default/images/intit.jpg') no-repeat; background-position: -142px 0px;}
.active{background-position: -11px 0px;}
#examworkList table.datatab tbody{text-align: center;}
a.errorbjsgs{
	background: #DEDEDE!important;
	color: #9F9F9F!important;
	height: 26px!important;
	width: 86px;
	border-radius: 3px;
	line-height: 26px!important;

}
a.errorbjsgs:hover{
	text-decoration:none;
}
.datatab a.jxzzy , .datatab a.jxzzy:hover{
    background: url(http://static.ebanhui.com/ebh/tpl/2016/images/jxzzy.png) no-repeat left 4px;
}
.shade {background:#fff;position: absolute;width:100%;height:100%;top:0px;left:0px;z-index:1009;text-align:center;line-height:562px;font-size:24px;background-color:#3c3c3c;opacity:0.8;filter:alpha(opacity=80);color:#fff;}
<?php $fromintro = $this->input->get('fromintro');
if(empty($fromintro)){?>
.cright{
	min-height:auto;
	background:#fff;
}
<?php }?>


</style>
<div id="flvcontrol1"></div>
    <style type="text/css">
        .baoke {
            font-family: "Microsoft YaHe";
            width: 515px;
            text-align:left;
        }
        .imgrts {
            float: left;
            height: 54px;
            width: 90px;
        }
        .suitrna {
            float: left;
            margin-left: 10px;
            width: 400px;
        }
        .suitrna h2 {
            font-size: 18px;
        }
        .suitrna .p1 {
            color: #999;
            font-size: 14px;
        }
        .nasirte {
            border: 1px solid #e3e3e3;
            float: left;
            height: 120px;
            margin: 30px 0 20px;
            position: relative;
            width: 510px;
        }
        .titses {
            background: #fff none repeat scroll 0 0;
            font-size: 16px;
            left: 20px;
            padding: 0 3px;
            position: absolute;
            top: -15px;
        }
        .paewes {
            color: #666;
            font-size: 14px;
            height: 96px;
            line-height: 1.8;
            overflow-y: auto;
            padding: 12px 16px;
            width: 478px;
        }
        .jduste {
            color: #666;
            float: left;
            font-size: 14px;
            width: 100%;
        }
        .cshortr {
            color: #21b200;
            font-size: 22px;
            font-weight: bold;
        }
        .ansirrt {
            float: left;
            height: 35px;
            margin-top: 25px;
            text-align: right;
            width: 100%;
        }
        a.baodbtn {
            background: #619bff none repeat scroll 0 0;
            color: #fff;
            float: left;
            font-size: 14px;
            height: 32px;
            line-height: 32px;
            margin-left: 260px;
            text-align: center;
            width: 112px;
        }
        a.qsrbtn {
            background: #eee none repeat scroll 0 0;
            border: 1px solid #dcdcdc;
            color: #999;
            float: left;
            font-size: 14px;
            height: 30px;
            line-height: 30px;
            margin-left: 30px;
            text-align: center;
            width: 110px;
        }

		.reviewstime{					/*...................................................................*/
			font-family: 微软雅黑;
		    font-size: 14px;
		    color: #fff;
		    height: 28px;
		    line-height: 27px;
		    padding: 0 25px;
		    float: right;
		    display: block;
		    background: #999;
		    border-radius: 3px;
		    text-decoration: none;
		    margin-right: 30px;
		    margin-left: 10px;
		    display: none;
		}
		.layui-tab-title{
			margin-bottom: 0;
		}
		.newTip_btn{
			bottom:200px!important;
		}
    </style>
<script type="text/javascript">
    var isFree = <?=!empty($is_free) ? 'true' : 'false'?>;
    var signType = '<?=!empty($sign_type) ? $sign_type : "" ?>';
    var coursewareid = <?=$course['cwid']?>;
    var courseid = <?=!empty($payitem['itemid']) ? $payitem['itemid'] : '0' ?>;

function opencountdiv(){
	if(!H.get('dialogoc')){
	    if (isFree) {
            if (signType == 'course') {
                //开通课程
                var freeWindow = top.dialog({
                    id: 'free-window',
                    title: '报名',
                    fixed: true,
                    content: $("#free-dialog").html(),
                    padding: 20,
                    onshow: function() {
                        var box = $(this.node);
                        box.find('.ui-dialog2-footer').css('text-align', 'right');
                        box.find('img.imgrts').attr('src', "<?=h($course['flogo'])?>");
                        box.find('div.suitrna h2').html("<?=h($course['foldername'])?>");
                        box.find('div.suitrna p.p1').html("<?=h($roominfo['crname'])?>");
                        box.find('div.nasirte div.paewes').html("<?=h($course['fsummary'])?>");
                    },
                    okValue: '去报名',
                    ok: function() {
                        var itemid = [];
                        itemid.push(courseid);
                        $.ajax({
                            url: '/ibuy/bpay.html',
                            type: 'post',
                            data: { 'itemid': itemid, 'totalfee': 0},
                            dataType: 'json',
                            success: function(ret) {
                                if (ret.status == '0') {
                                    $.note(ret.msg);
                                    return;
                                }
                                //报名成功
                                location.reload();
                            }
                        });
                    },
                    cancelValue: '取消',
                    cancel: function() {
                        location.href="/myroom.html";
                    }
                });
                freeWindow.showModal();
                return;
            }
            if (signType == 'courseware') {
                //开通课件
                var data = {
                    cwid: coursewareid,
                    itemid: coursewareid,
                    totalfee: 0,
                    totalyhfee: 0,
                    isusecoupon: 0,
                    couponverify: 0
                };
                var freeWindow = top.dialog({
                    id: 'free-window',
                    title: '报名',
                    fixed: true,
                    content: $("#free-dialog").html(),
                    padding: 20,
                    onshow: function() {
                        var box = $(this.node);
                        box.find('.ui-dialog2-footer').css('text-align', 'right');
                        box.find('img.imgrts').attr('src', "<?=h($course['logo'])?>");
                        box.find('.titses').html('课件简介');
                        box.find('div.suitrna h2').html("<?=h($course['title'])?>");
                        box.find('div.suitrna p.p1').html("<?=h($roominfo['crname'])?>");
                        box.find('div.nasirte div.paewes').html("<?=h($course['summary'])?>");
                    },
                    okValue: '去报名',
                    ok: function() {
                        $.ajax({
                            url: '/ibuy/bpay.html',
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function(ret) {
                                if (ret.status == '0') {
                                    $.note(ret.msg);
                                    return;
                                }
                                //报名成功
                                location.reload();
                            }
                        });
                    },
                    cancelValue: '取消',
                    cancel: function() {
                        location.href="/myroom.html";
                    }
                });
                freeWindow.showModal();
                return;
            }
            return;
        }
		H.create(new P({
			id : 'dialogoc',
			title: '信息提示',
			easy:true,
			width:420,
			padding:5,
			content:$('#opencount')[0]
		}),'common').exec('show');
        dialog.get('dialogoc').addEventListener('close', function() {
	       location.href="/myroom.html";
        });
	}else{
		H.get('dialogoc').exec('show')
	}
}
	function addfavorite(cwid,title,url){
		var purl = "<?= geturl('myroom/favorite/add')?>";
		$.ajax({
			type	:'POST',
			url		:purl,
			data	:{'cwid':cwid,'title':title,'url':url,'type':1},
			dataType:'text',
			success	:function(data){
				if(data=='success'){
					$("#favorite").val("已收藏");
					$("#favorite").unbind();
				}
			}
		});
	}


	var countdown = <?=$course['submitat']-SYSTIME?>;
	var intid;
	var isclose;	//是否关闭弹幕
	$(function (){
			<?php if(empty($myfavorite)) { ?>
				$("#favorite").html("收藏");
				$("#favorite").unbind().click(function(){
					$("#favorite").html("已收藏");
					$("#favorite").removeClass('shoutie');
					$("#favorite").addClass('yishout');
					$("#favorite").removeAttr('onclick');
					addfavorite('<?= $course['cwid'] ?>',"<?= str_replace('\'','',$course['title']) ?>",location.href);
				});
			<?php } else { ?>
				$("#favorite").html("已收藏");
				$("#favorite").removeClass('shoutie');
				$("#favorite").addClass('yishout');
			<?php } ?>

			<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
				if(window != undefined) {
					opencountdiv();
				}
			<?php }else{ ?>
				//flv播放
				var cwid = <?= $course['cwid'] ?>;
				var isfree = <?= isset($isfree) ? $isfree : $course['isfree'] ?>;;
				var num = 1;//教室内
				var lastsuffix = 'flv';
				<?php if(!empty($type)){?>
				lastsuffix = '<?= $type ?>';
				<?php } ?>
				if(lastsuffix == 'flv'){
					//flv
					<?php
						if(!empty($course['m3u8url'])) {
						$autoplay = $this->input->get('autoplay');
						$autoplay = !empty($autoplay)?$autoplay:0;
						// $jx = $roominfo['domain'] == 'jx';
						$mode = 0;
						$seek = -1;
						if((SYSTIME>= $course['submitat'] && SYSTIME<= $course['endat']) || SYSTIME < $course['submitat']){
							$mode = 1;
							$seek = SYSTIME - $course['submitat'];
							if(!empty($course['cwlength']) && SYSTIME >= ($course['submitat']+$course['cwlength'])){
								$mode = 0;
								$seek = 1;
							}
							if($seek <= 0)
								$seek = 1;
							$autoplay = 1;
						}
						$isremind = $course['isremind'];
						$remindtime = $course['remindtime'];
						$remindmsg = $course['remindmsg'];
						if (!empty($intro)) {
							//播放开场动画，视频暂停
							$autoplay = 0;
						}
					?>
					playmu('<?=$course['m3u8url']?>',cwid,'',isfree,num,'562','980',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,<?=$autoplay?>,<?=$mode?>,<?=$seek?>,<?= $isremind ?>,'<?=$remindtime?>','<?=$remindmsg?>');

					//playmu('http://r1.ebh.net/2231.m3u8',cwid,'',isfree,num,'562','980',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,<?=$autoplay?>,<?=$mode?>,<?=$seek?>,<?= $isremind ?>,'<?=$remindtime?>','<?=$remindmsg?>');
					<?php
						} else if(!empty($course['rtmpurl'])) {
					?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','980',1,'<?= $course['thumb'] ?>');
					<?php } else if($isliverun){?>
					<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','980',1);
					<?php } ?>
				} else if(lastsuffix == 'mp3'){
					<?php
						$mode = 0;
						$seek = -1;
						if(SYSTIME>= $course['submitat'] && SYSTIME<= $course['endat'] && SYSTIME < ($course['submitat']+$course['cwlength'])){
							$mode = 1;
							$seek = SYSTIME - $course['submitat'];
							if($seek <= 0)
								$seek = 1;
						}
					?>
					playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','980',1,'',<?= $mode ?>,<?= $seek ?>);
				}else if(lastsuffix == 'swf'){
                    playswf('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','980',1);
                }
			<?php } ?>

			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/myroom/mycourse/getajaxpage.html";
			<?php if($course['islive'] != 1){ ?>		
			page_load(page,url);
			<?php } ?>
			var str=window.location.href.substring(window.location.href.indexOf('#')+1);
		    if(str!==undefined && str!=='' && window.location.href.indexOf('#')>0){
		        $("#notecontent").show();
		    }
			$("#notebtn").click(function(){
				$("#notecontent").show();
			});
			$("#cancel").click(function(){
				$("#notecontent").hide();
			});
			<?php if(SYSTIME<$course['submitat']){?>
				intid = setInterval('counttime()',1000);
			<?php }?>
		});

	//听课完成回调
	var _plid = 0;
	function messfun(ctime,ltime,finished,plid,curtime){
		var cwid = <?= $course['cwid'] ?>;
		var crid = <?=$roominfo['crid']?>;
		var res = studyfinish(cwid,ctime,ltime,finished,plid,curtime,crid);
		_plid = res;
		if(finished==1){
			addwordscore();
			showCommentDialog();
			var exampower = "<?=$examPower?>";
			if(exampower == '1'){		
				newshowHomeWork();
			}else{
				showHomeWork();
			}

		}
		return res;
	}

	//国土看课件加积分处理
	function addwordscore(){
		var wordcwid = "<?=empty($course['cwid'])?0:$course['cwid'];?>";
		var wordfolderid = "<?=empty($course['folderid']) ? 0 : $course['folderid'];?>";
		var isnewzjdlr = <?=$isnewzjdlr?>;
		if(isnewzjdlr){
	        $.ajax({
	            type:"post",
	            url:"/studyscorelogs/addScore.html",
	            data:{
	                "type":4,
	                "cwid":wordcwid,
	                "folderid":wordfolderid,
	            },
	            success:function(json){
	                //console.log("成功");
	            },
	            error:function(json){
	            }
			});
		}
	}



	//听完课打开第一个未做或者未做完的作业
	function showHomeWork(){
		var eid = "<?=empty($examlist[0])?0:$examlist[0]['eid'];?>";
		//已经打开过作业则不重复打开
		if(window.hasOpenHomeWork == true){
			return;
		}
		//升级学分
		updateCredit();
		if(eid!=0){
			var status = "<?=!empty($examlist[0])?$examlist[0]['status']:null?>"; //作业状态
			if(status!=1){
				top.dialog({
				title:"操作提示",
				content:"本课下还有作业未完成，请点击确定进行答题。",
				cancel:function () {
					this.close().remove();
				},
				cancelValue:"取消",
				okValue:"确定",
				ok:function(){
					window.hasOpenHomeWork = true; //标记作业为已打开过状态
					<?php
						$hmeid = empty($examlist[0])?0:$examlist[0]['eid'];
					if(!empty($isapple)) {
									$homewdourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$hmeid;
								} else {
									$homewdourl = 'http://exam.ebanhui.com/edo/'.$hmeid.'.html';
								}
					?>
					window.open("<?= $homewdourl ?>",'_blank');
					this.close().remove();
				}
				}).showModal();
			}
		}
	}
	function newshowHomeWork(){
		url = '/college/examv2/getCwidExamsAjax.html';
		$.ajax({
			url:url,
			type:'post',
			data:{
				'cwid': <?= $course['cwid'] ?>
			},
			dataType:'json',
			success:function(result){
				var examList = result.datas.examList;
				var eid = examList[0]?examList[0].exam.eid:0;
				//已经打开过作业则不重复打开
				if(window.hasOpenHomeWork == true){
					return;
				}
				//升级学分
				updateCredit();
				if(eid!=0){
					var status = examList[0]?examList[0].userAnswer.status:0;
					if(status!=1){
						top.dialog({
						title:"操作提示",
						content:"本课下还有作业未完成，请点击确定进行答题。",
						cancel:function () {
							this.close().remove();
						},
						cancelValue:"取消",
						okValue:"确定",
						ok:function(){
							window.hasOpenHomeWork = true; //标记作业为已打开过状态
							homewdourl = '/college/examv2/doexam/'+eid+'.html';

							window.open(homewdourl,'_blank');
							this.close().remove();
						}
						}).showModal();
					}
				}
			}
		});
	};
	//视频播放完毕处理学分
	function updateCredit(){
		$.getJSON('/schcredit.html',
			{'cwid':<?=$course['cwid']?>,'crid':<?=$roominfo['crid']?>},
			function(res){
				return;
			}
		);
	}
	function showfeedback(){
		var isfeedback = 0;
		$.ajax({
			url : '/feedback/isfeedback/<?=$course['cwid']?>.html?ddd='+Math.random(),
			async : false,
			success : function(data){
				if(data==0)
					openfbdialog();
				else
					isfeedback = 1;
			}
		});
		if(isfeedback)
			window.open("/feedback/<?=$course['cwid']?>.html");
	}
	function closedialog(){
		H.get('artdialogfb').exec('close');
		window.open("/feedback/<?=$course['cwid']?>.html");
	}
	function openScreenShotDialog()
	{
		var flashObj = document.getElementById('flvcontrol');
		flashObj.setScreenUpload('<?php echo  empty($uppicapi)?'':$uppicapi; ?>');
	}
	function setImageUrl(path){
		imgsrc = path;
		height = 490;
		width = 665;
		url = '/screenshot/view.html?imgsrc='+imgsrc;
		title = '截图预览';
		var html = '<iframe id="artdialogss" name="artdialogss" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id : 'artdialogss',
			title : title,
			width : width,
			height : height,
			content : html,
			easy:true
		},{onclose:function(){
			var flashObj = document.getElementById('flvcontrol');
			flashObj._play();
			H.get('artdialogss').exec('destroy');
		}}),'common').exec('show');
	}
	function testPlay(){
		var flashObj = document.getElementById('flvcontrol');
			flashObj._play();
	}
	function setImageUrl2(path){
		imgsrc = path;
		height = 900;
		width = 1050;
		var cwid = <?= $course['cwid'] ?>;
		var cwname = '<?= $course['cwname'] ?>';
		var folderid = <?= $course['folderid'] ?>;
		var foldername = '<?= $course['foldername'] ?>';
		url = '/college/myask/addquestion.html?imgsrc='+imgsrc+'&cwid='+cwid+'&cwname='+cwname+'&folderid='+folderid+'&foldername='+foldername; //调用获取图片地址接口
		title = '提问';
		var html = '<iframe id="askQuestionDialog" name="askQuestionDialog" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id : 'askQuestionDialog',
			title : title,
			width : width,
			height : height,
			content : html,
			easy:true
		},{onclose:function(){
			H.get('askQuestionDialog').exec('destroy');
			H.get('artdialogss').exec('destroy');
		}}),'common').exec('show');
		// H.get('artdialogss').exec('destroy');
	}
	function openfbdialog(){
		height = 555;
		width = 870;
		url = '/feedback/<?=$course['cwid']?>.html';
		title = '听课反馈';
		var html = '<iframe marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id : 'artdialogfb',
			title : title,
			width : width,
			height : height,
			content : html,
			easy:true
		}),'common').exec('show');
	}
	function showAskDialog(){
		if($("#askdialog").length == 0){
			$('body').append('<iframe id="askdialog" style="display:none;overflow:hidden;" width=920 height=800 src="" frameborder="0"></iframe>');
		}
		var url = "/college/myask/addquestion.html?forcoursedialog=1&folderid=<?= $course['folderid'] ?>&cwid=<?=$course['cwid']?>&tid=<?=$course['uid']?>&v="+Math.random();
		$("#askdialog").attr('src',url);
		H.create(new P({
			title:'提问',
			height:820,
			id:'askDialog',
			content:$("#askdialog")[0],
			easy:true
		}),'common').exec('show');
	}

	function closeAskDialog(){
		H.get('askDialog').exec('close');
		$("#relativeask").html($("#relativeask").html()-0+1);
		//getAskListAjax();
	}



  	function Mu(){
  		this.tag = 1;
  	}
  	Mu.prototype = {
  		callflash:function(data){
  			if(!isNaN(data.pos)){
  				data.pos = this.parsePos(data.pos);
  			}
  			this.checkSwf();
  			this.swf.setTxt(data.msg,data.isSelf,data['size'],data['color'],data.alpha,data.pos);
  		},
  		send:function(data){
  			var _data = {
  				'msg':data.msg || '',
  				'isSelf':data.isSelf || 0,
  				'size':data['size'] || 30,
  				'color':data['color'] || '#000000',
  				'alpha':data.alpha || 1,
  				'pos':data.pos || 0
  			}
  			_data.pos = this.parsePos(_data.pos);
  			if(data.isSelf == 1 && data.isFromPage == 1){
  				_data.pos = data.pos;
  				this.writeDb(_data);
  			}
  			this.callflash(_data);
  		},
  		writeDb:function(data){
  			var time = this.getplaytime();
  			if(time == 0){
  				return;
  			}
  			$.ajax({
				url:'/mu/addMuAjax.html',
				type:'post',
				data:{'cwid':'<?=$course['cwid']?>','msg':data.msg,'size':data['size'],'color':data['color'],'alpha':(data['alpha']*100),'pos':data['pos'],'time':time},
				dataType:'text',
				success:function(result){
					if(result == 0){
						$("#tanmu_msg").attr('placeholder','发送成功，再次发送');
					}else{
						$("#tanmu_msg").attr('placeholder','发送失败');
					}
				}
			});

  		},
  		getDuringList:function(){
  			var me = this;
  			var time = me.getplaytime();
  			var starttime = time-11;
  			if(starttime<0){
  				starttime = 0;
  			}
  			var endtime = time;
  			$.ajax({
				url:'/mu/getMusAjax.html',
				type:'post',
				data:{'cwid':'<?=$course['cwid']?>','starttime':starttime,'endtime':endtime},
				dataType:'json',
				success:function(mus){
					for(var i =0,length=mus.length;i<length;i++){
						if(mus[i].uid == '<?=$user['uid']?>'){
							mus[i].isSelf = 1;
						}
						me.send(mus[i]);
					}
					if(me.tag == 0){
						return;
					}
					clearTimeout(me.timer);
					me.timer = setTimeout(function(){
		  				me.getDuringList();
		  			},10000);
				}
			});
  		},
  		getplaytime:function(){
  			this.checkSwf();
  			//获取flash视频当前的播放时间
  			var time = this.swf.getplaytime();
  			if(isNaN(time)){
  				return 0;
  			}
  			return parseInt(time);
  		},
  		stopMu:function(){
  			this.checkSwf();
  			clearTimeout(this.timer);
  			if(this.tag == 0){
  				return;
  			}
  			this.tag = 0;
  			this.swf.hideScreen(0);
  		},
  		startMu:function(){
  			this.checkSwf();
  			if(this.tag == 1){
  				return;
  			}
  			this.tag = 1;
  			this.swf.hideScreen(1);
  		},
  		checkSwf:function(){
  			if(typeof this.swf == 'undefined'){
  				this.swf = document.getElementById('flvcontrol');
            }
  		},
  		parsePos:function(pos){
  			var retpos = 'default';
  			if(pos == 1){
  				retpos = 'top';
  			}else if(pos == 2){
  				retpos = 'center';
  			}else if(pos == 3){
  				retpos = 'bottom';
  			}
  			return retpos;
  		},
  		setTag:function(tag){
  			this.tag = tag;
  		},
  		pauseMu:function(){
  			this.checkSwf();
  			clearTimeout(this.timer);
  		}
  	}

  	function dosend(data){
		if($("#muswitch").attr("isclose") == "1" || isclose == 1 || typeof playevent.status == 'undefined' || playevent.status == 0) {
            return;
		}
  		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
  		if(typeof data == 'undefined'){
  			var msg = $("#tanmu_msg").val();
  			msg = $.trim(msg);
  			if(msg == ''){
  				return;
  			}
  			$("#tanmu_msg").val('');
	  		var size = $(".setFontSize li.selected a").attr('data-barrage-size');
	  		var color = $("#colorholder").val();
	  		var pos= $("#shlocation a.selected").attr('data-barrage-position');
	  		var alpha = document.getElementById('persent').pernum;
	  		var isFromPage = 1;
	  		alpha = alpha/100;
	  		var isSelf = 1;
  		}else{
  			var msg = data.msg;
  			var size = data['size'];
  			var color = data['color'];
  			var pos = data.pos;
  			var alpha = data.alpha;
  			alpha = alpha/100;
  			var isSelf = 0;
  			var isFromPage = 0;
	  		if(data.uid == '<?=$user['uid']?>'){
	  			isSelf = 1;
	  		}
  		}
  		dosend.mu.send({
  			'msg':msg,
  			'size':size,
  			'color':color,
  			'pos':pos,
  			'alpha':alpha,
  			'isSelf':isSelf,
  			'isFromPage':isFromPage
  		});
  	}
	var autoPlay = true;
	<?php if(!empty($intro) && !empty($intro['introtype'])) { ?>
		autoPlay = false;
	<?php } ?>
  	function startMu(startnow){
		if (!autoPlay) {
			//document.getElementById('flvcontrol')._pause();
		}

  		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
		dosend.mu.startMu();
		clearTimeout(dosend.mu.timer);
		dosend.mu.timer = setTimeout(function(){
	  		//dosend.mu.getDuringList();
		},10000);
  	}

  	function stopMu(){
		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
  		dosend.mu.stopMu();
  	}

  	function pauseMu(){
  		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
  		dosend.mu.pauseMu();
  	}


  	$(function(){
  		$('body').bind('click',function(){
  			$('.danmu-set-v').hide();
  		});
  		$(".danmu-set-v *").bind('click',function(){
  			return false;
  		});
  		$('#danmu_set').bind('click',function(){
  			$('.danmu-set-v').toggle();
  			$("#cancel").triggerHandler('click');
  			return false;
  		});
  		$("div.setFontSize li a").unbind().bind('click',function(){
  			$(this).parent('li').addClass('selected');
  			$(this).parent('li').siblings().removeClass('selected');
  			return false;
  		}).bind('dblclick',function(){
  			$('.danmu-set-v').hide();
  		});
  		$("#colorSetBd *").unbind();
  		$("#colorSetBd li a").bind('click',function(){
  			var color = $(this).attr('data-barrage-color');
  			color = '#'+color;
  			$("#colorholder").val(color);
  			$("#colorshow").attr('style','background: '+color+' none repeat scroll 0% 0%;');
  			$('i.hoverBor').hide();
  			$(this).find('i.hoverBor').show();
  			return false;
  		}).bind('dblclick',function(){
  			$('.danmu-set-v').hide();
  		});

  		$("#shlocation *").unbind();
  		$("#shlocation a").bind('click',function(){
  			$(this).addClass('selected');
  			$(this).siblings().removeClass('selected');
  		}).bind('dblclick',function(){
  			$('.danmu-set-v').hide();
  		});
  		$("#tanmu_msg").unbind().bind('keyup',function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
		    if(keycode == '13'){
		       dosend();
			}
  		});

  		// 拖动条开始
  		var handle=$("#draghandle");
	    var dragbar=$("#dragbar");
	    var persent = $("#persent");
	    var maxlen = dragbar.width()-handle.width()+1;
	    dragbar.unbind().bind('mousemove',function(e){
	    	if(handle.ismoving == 1){
	    		handle.curX = e.pageX;
	    		handle.offsetX = handle.startX-handle.curX;
	    		handle.startX = handle.curX;
	    		var left = handle.position().left-handle.offsetX;
	    		if(left <= 0 || left >= maxlen){
	    			return;
	    		}
	    		var pernum = (left/maxlen*100).toFixed(0)-0+1;
	    		persent.html( pernum + '%' );
	    		persent[0].pernum= pernum;
	    		handle.attr('style','left:'+left+'px');
	    	}
	    });
	    handle.bind('mousedown',function(e){
	    	handle.ismoving= 1;
	    	handle.startX = e.pageX;
	    });
	    handle.bind('mouseup',function(e){
	    	handle.ismoving = 0;
	    });
	    dragbar.bind('mouseup',function(e){
	    	handle.ismoving = 0;
	    });
	    dragbar.bind('mouseenter',function(){
	    	handle.ismoving = 0;
	    });
	    // 拖动条结束
	    $("#muswitch").bind('click',function(){
	    	if($(this).attr('isclose') == 1){
	    		this.isclose = 1;
				isclose = 1;
	    		$(this).removeAttr('isclose');
	    	}
//	    	var isclose = this.isclose;
	    	if(typeof isclose == 'undefined' || isclose == 0){
	    		$(this).removeClass('switch_open');
	    		delcookie('showmu');
	    		this.isclose = 1;
				isclose = 1;
	    		setCookie('ebh_showmu',0,30);
	    		stopMu();
	    	}else{
	    		$(this).addClass('switch_open');
	    		this.isclose = 0;
				isclose = 0;
	    		startMu(1);
	    		setCookie('ebh_showmu',1,30);
	    	}

	    })
  	});
	//flash播放状态改变回调函数
	function playevent(status){
		if($("#muswitch").attr('isclose') == 1){
    		$("#muswitch")[0].isclose = 1;
    		$("#muswitch").removeAttr('isclose');
			isclose = 1;
    	}
//		isclose = $("#muswitch")[0].isclose;
		if(isclose == 1){
			if(status == 0){
				playevent.status = 0;
			}else if(status == 1 && (playevent.status == 0 || (typeof playevent.status == 'undefined') )  ){
				playevent.status = 1;
			}
			return;
		}
		if(status == 0){
			playevent.status = 0;
			pauseMu();
		}else if(status == 1 && (playevent.status == 0 || (typeof playevent.status == 'undefined') )  ){
			playevent.status = 1;
			startMu();
		}
	}


</script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<?php
    if($type == 'flv'){
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
</head>
<body>
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1 && !empty($is_free)) {
    if ($sign_type == 'course') { ?>
<div id="free-dialog" style="display:none">
    <div class="baoke">
        <img class="imgrts" src="" />
        <div class="suitrna">
            <h2></h2>
            <p class="p1"></p>
        </div>
        <div class="nasirte">
            <span class="titses">课程介绍</span>
            <div class="paewes"></div>
        </div>
        <div class="jduste">
            价格：<span class="cshortr">免费</span>
        </div>
    </div>
</div>
<?php } else { ?>
        <div id="free-dialog" style="display:none">
            <div class="baoke">
                <img class="imgrts" src="" />
                <div class="suitrna">
                    <h2></h2>
                    <p class="p1"></p>
                </div>
                <div class="nasirte">
                    <span class="titses">课件介绍</span>
                    <div class="paewes"></div>
                </div>
                <div class="jduste">
                    价格：<span class="cshortr">免费</span>
                </div>
            </div>
        </div>
<?php }} ?>
<div class="xkcg1s" id="opencount" style="display:none;">
    <div class="mycjkclb1s tishitit">对不起，您尚未开通 <?= empty($payitem) ? '学习和作业功能' : $payitem['iname'] ?> 或课程已到期</div>
    <p class="p1s">开通课程后，您就可以随时地在网校使用在线学习、</p>
    <p class="p1s">做作业、互动答疑等所有功能了。</p>
    <div class="xuanbtn2s">
        <a href="javascript:void(0)" onclick="openonline()" class="jxxk1s">去开通</a>
    </div>
</div>
<?php
$domain=$this->uri->uri_domain();//测试用
?>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<input type="hidden" value="<?=$domain?>" id="domain">
<input type="hidden" value="<?=$course['ism3u8']?>" id="ism3u8"> <!-- 转码完成标志 -->
<input type="hidden" value="<?=strtolower($type)?>" id="cwtype"> <!-- 课件类型 -->

<input type="hidden" value='' id='screenShotPath'>
<input type="hidden" value='' id='screenShotPath2'>
<div id="main-box" <?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){ ?>style="width:1310px;margin:0 auto;position: relative;" <?php }else{?>style="margin:0 auto;width:980px;" <?php }?>>

<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){ ?>
<?php $this->display('common/chatroom'); ?>
<?php } ?>

<div class="cright" style="display: block;margin: 0 auto;width:980px;margin-bottom:20px;<?php if($course['open_chatroom'] > 0 && $course['islive'] == 0 && $folder_detail['showmode'] != 3){ ?>float:left;margin-top:0px!important; <?php }?>">


<div class="lefrig" style="margin-top:0;float:none;padding:0px;width: 980px">
			<div class="classbox" style="width:980px;border:none;background: #FFF;min-height:0;">
			<div style="float:left;margin:5px 15px 0 18px; text-align:center;">
			<?php
					if($iszjdlr){
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
<?php if($iszjdlr){ ?>
<img src="<?=$face?>" style="width:30px;height:30px; border-radius:20px;" title="<?=empty($cwuser['realname'])?$cwuser['username']:$cwuser['realname']?>">
<?php }else{?>
<img src="<?=$face?>" style="width:30px;height:30px; border-radius:20px;" title="<?=empty($course['realname'])?$course['username']:$course['realname']?>">
<?php }?>
</div>
				<h1 class="rygers"><?= $course['title']?></h1>
				<div class="classboxmore">
				<?php
						$viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);
						$dateline = empty($course['submitat'])?$course['dateline']:$course['submitat'];
						?>
					<p  style="color:#999;font-family:微软雅黑;">
					<?php if(!empty($course['rtmpurl'])) { ?>

					<span style="float:right;">如您无法正常播放，也可以 <a href="<?= geturl('myroom/mycourse/'.$course['cwid']).'?$type=1' ?>" style="color:blue">点击这里</a></span>
					<?php } ?>
					</p>
					<p style="">
					<?php if($type == 'ebh' || $type == 'ebhp') {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE ) { ?>
							<?php if($course['isfree']==1){ ?>
							<input class="huangbtn marrig" value="开始听课" type="button"  onclick="freeplay('<?= $course['cwsource']?>','<?= $course['cwid']?>','<?php str_replace("'"," ",$course['title'])?>',1,0,showdialogs)"/>
							<?php }else{ ?>
							<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
							<?php } ?>
							<?php if($domain == 'bndx'){ ?>
							<input class="huangbtn marrig" value="录入笔记" type="button"  onclick="javascript:$('#notecontent').show();"/>
							<?php } ?>
						<?php } ?>

					<?php } elseif (!empty($course['cwurl']) && $type != 'flv' && $type != 'mp3'&& $type!='swf' && $course['islive'] != 1) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig"style=" ">下载文件</a>
						<!--
						<?php if($course['ispreview']) { ?>
						<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank" style="">预 览</a>
						<?php } ?>
						 -->
						<!-- 巴南网校附加普通课件录入笔记功能 -->
						<div style="*margin-bottom:10px;">
							<a class="lanbtn" href="javascript:void(0)" id="favorite" style=""></a>
							<?php if($domain == 'bndx'){ ?>
							<a id="notebtn" class="lanbtn" name="notes" href="javascript:void(0)" style="margin-left:10px;">录入笔记</a>
							<?php } ?>
						</div>
					<?php }else{ ?>
						<!-- 巴南网校没有任何课件时录入笔记功能(全部网校) -->
						<?php if(empty($course['cwurl'])){ ?>
						<div style="*margin-bottom:10px;">
							<a class="lanbtn" href="javascript:void(0)" id="favorite" style=""></a>
							<a id="notebtn" class="lanbtn" name="notes" href="javascript:void(0)" style="margin-left:10px;">录入笔记</a>
						</div>
						<?php } ?>
					<?php } ?>
					</p>
				</div>
			</div>
			<?php if(($type != 'flv' && $type != 'mp3'&&$type!='swf')){ ?>
			<!-- 巴南网校普通课件加入录入笔记功能 (全部网校)-->
			<div id="notecontent" style="display:none">
					<div class="txtxdaru" style="float:left;width:980px;display: inline;margin-top:5px;">
					<?php if(empty($mynote['ftext'])){ ?>
						  <?php $editor->xEditor('message','978px','300px'); ?>
					<?php }else{ ?>
						  <?php $editor->xEditor('message','978px','300px',$mynote['ftext']); ?>
					<?php } ?>
					</div>
				  <div style="float:right;margin-top:5px;">
					<a href="javascript:;" id="cancel" style="margin-right:80px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px; border-radius:4px;">取消</a>
					<a href="javascript:;" onclick="submitnote(<?= $course['cwid']?>);" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;border-radius:4px;">提交</a>
				  </div>
			</div>
			<?php } ?>

			<?php if(isset($checkip) && $checkip === FALSE) {?>
			<div class="classbox" style="width:978px;background: #FFF;border:solid 1px #cdcdcd;min-height:30px;margin-top:5px;">
				<div class="classboxmore" style="width:928px;color:red;font-size:14px;">
				重要通知： 为了同学们账号密码安全，经常在不同场所同一时间上线的账号会被系统找出，并且限制登陆甚至封号，建议单独使用账号并妥善更改密码和保管密码。
				</div>
			</div>
			<?php } ?>
			<?php
				if($course['islive'] == 1){
					$allowReview = ($liveinfo['review_start'] == 0 || $liveinfo['review_start'] < SYSTIME ) && ($liveinfo['review_end'] == 0 || $liveinfo['review_end'] > SYSTIME) && $this->input->get('review') == 1;
				}else{
					$allowReview = false;
				}
				
				
			?>
			<?php if(($type == 'flv' || $type == 'mp3'|| $type == 'swf') && ($course['islive'] != 1 || $allowReview )) { ?>


				<?php if(empty($course['endat']) || SYSTIME<=$course['endat'] || $course['islive'] == 1) {?>
									<?php if(empty($is_mobile)){ ?>
					<!--电脑端播放器开始-->
					<?php if($type == 'mp3') {?>
					<div class="video-mp3 video-play" <?php if(SYSTIME<$course['submitat']){?>style="display:none;"<?php }?>>
	                <div id="video">
					<?php } else {?>
					<div class="video-swf video-play" <?php if( SYSTIME<$course['submitat']){?>style="display:none;"<?php }?>>
	    			<div id="video">
						<?php if(!empty($intro) && $intro['introtype'] == 1) { ?>
							<div class="advertising" style="width:100%;height:100%;background: #000;position:absolute;left:0;top:0;z-index: 1002;">

			<video id="advertising_video" width="100%" height="100%" autoplay="autoplay" src="<?=$intro['sourceurl']?>">
				<source src="video.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
			</video>
		</div>
				<script type="text/javascript">
						var videos = $("#advertising_video");
						videos[0].addEventListener("ended",function(){
							$(".advertising").remove();
							document.getElementById('flvcontrol')._play();
						})
							$(".advertising").bind("contextmenu",function(){//取消右键事件
							return false;
						});
					</script>
			<?php } else if (!empty($intro) && $intro['introtype'] == 2 && !empty($intro['slides'])) { ?>
			<div id="adsing" style="width:100%;height:100%;background: #000;position:absolute;left:0;top:0;z-index: 1002;">
				<?php
							$zindex = 6;
							$maxK = count($intro['slides']) - 1;
							foreach ($intro['slides'] as $k => $slide) { ?>
							<img interval="<?=$slide['interval']?>" src="<?=$slide['src']?>" width="100%" height="100%" style="z-index:<?=$zindex--?>;opacity:1;position:absolute;left:0;top:0;<?php if ($k < $maxK) { ?>transition: all 1s ease-out 0s;<?php } ?>">
						<?php } ?>

			</div>
			<script type="text/javascript">
(function($) {
		var slides = $("#adsing img");
		var index = 0;
		var slideCount = slides.size();
		function slide(interval) {
			setTimeout(function() {
				$(slides.get(index)).css('opacity','0');
				index++;
				if (index >= slideCount) {
					$("#adsing").hide();
					document.getElementById('flvcontrol')._play();
					return;
				}
				slide(parseInt($(slides.get(index)).attr('interval')) * 1000);
			}, interval);
		}
		$(document).bind('ready', function() {
			slide(parseInt($(slides.get(index)).attr('interval')) * 1000);
		});
	})(jQuery);
			</script>
			<?php } ?>
        	    		<!-- flv转码 判断是否转码完成 -->
            			<?php if(($type== 'flv') && ($course['ism3u8'] != 1)){?>
        				<div class="shade">视频正在转码加密，请稍候<span id="randnums">...</span></div>
        				<?php }?>
					<?php } ?>
						<div class="wraps">
							<div class="video-floatswf-topbg"></div>
							<div class="video-floatswf-top">
								<span class="video-floatswf-title js-title"><?= $course['title'] ?></span>
								<b class="video-float-close" onclick="closew()"></b>
							</div>
					<div id="flvcontrol" style="width:980px;height:560px;">

					</div>
					</div></div>
					<style>
						.popup{position: absolute;z-index: 1023!important;top:0px;background: rgba(0,0,0,.7);height:525px;}
					</style>
					<div class="popup" style="display:none;">
					    <div class="popupson">
					    	<div class="closedel" onclick="closeCommentDialog();"></div>
					        <div class="courseover">课程已结束</div>
					        <?php
									if($course['sex'] == 1) {
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									} else {
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}
									$face = empty($course['face']) ? $defaulturl : $course['face'];

							?>
					        <div class="popupimages"><img src="<?=$face?>" /></div>
					        <div class="teaname"><?= empty($course['realname'])?$course['username']:$course['realname']?></div>

							<?php if(!$iszjdlr){ ?>
					        <div class="fivestars">如果觉得我讲的好，就给我五星好评吧！</div>
					        <div class="fivestarslist" onmouseover="chose_popup_star(this,event)">
					        	<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/fivestar.png" score="1" title="很烂">
					            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/fivestar.png" score="2" title="一般">
					            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/fivestar.png" score="3" title="还好">
					            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/fivestar.png" score="4" title="较好">
					            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/fivestar.png" score="5" title="很好">
					        </div>
					        <?php }?>
					        <textarea class="inputrating" id="pop-comment-input" maxlength="800">亲，给这节课写个评价吧...</textarea>
					        <div class="facecomments">
					            <a href="javascript:;" class="face face-pop"></a>
					            <div class="qqface"></div>
					            <a href="javascript:;" class="reviews" onclick="popup_comment()">评论</a>
					            <?php if(!$isnewzjdlr){?>
					            <p class="inputprompt inputprompt-pop"><?=$iszjdlr?'您还需输入':'你还可以输入'?><span>100</span>字</p>
								<?php }?>
								<p class="inputprompt pop-commentava" style="display:none">点击右侧按钮发布评论</p>
					        </div>
					    </div>
					</div>


					</div>

				<!--电脑端播放器结束-->
				<?php }else{ ?>
					<?php if($type == 'flv' || $type == 'mp3') { ?>
						<?php if($type == 'mp3') {?>
						<div class="video-play" style="color:red;position: relative;height:400px;z-index:601;float:left;margin-left:1px;margin-top:5px;<?php if(SYSTIME<$course['submitat']){?>display:none;<?php }?>">
						<?php } else {?>
						<div class="video-play" style="color:red;position: relative;height:560px;z-index:601;float:left;margin-left:1px;margin-top:5px;<?php if(SYSTIME<$course['submitat']){?>display:none;<?php }?>">
						<?php } ?>
						<div id="flvcontrol2" style="width:980px;height:560px;">
							 <video id="_video" src="<?=$purl.getv()?>" poster="<?=$course['thumb']?>" width="980px" height="560px"  controls="controls">
		                        您的浏览器不支持播放该视频！
		                    </video>
						</div>

						</div>
					<?php } ?>

				<?php } ?>

				<!--还没开始显示-->
				<div class="wraps nostart"  style="float:left;<?php if(SYSTIME>$course['submitat']){?>display:none;<?php }?>">
					<div style="width:980px;height:560px;background:white;text-align:center" id="notava">
					<span style="font-size:50px;width:970px;float:left;margin-top:200px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</span>
					<span style="font-size:50px;width:970px;float:left;margin-top:50px">倒计时：<span id="countdown"><?=secondToStr($course['submitat']-SYSTIME)?></span></span>
					<span style="font-size:50px;width:970px;float:left;margin-top:50px">请耐心等候...</span>
					</div>
				<script>
					$('.mp3block').css('height','560px');
				</script>
				</div>
				<?php }else if($isliverun){?>
				<div class="wraps" style="float:left;">
				<div style="width:978px;height:558px;background:white;text-align:center" id="notava">
				<span style="font-size:50px;width:970px;float:left;margin-top:200px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
				</div>
				<script>
					$('.mp3block').css('height','560px');
				</script>
				</div>
				<?php }else{?>
				<div class="wraps" style="float:left;">
				<div style="width:980px;height:560px;background:white;text-align:center" id="notava">
				<span style="font-size:50px;width:970px;float:left;margin-top:200px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
				</div>
				<script>
					$('.mp3block').css('height','560px');
				</script>
				</div>
				<?php }?>

				<div id='atsrc' style="display: none;"></div>
			<div class="flaoter" style="margin-top:0px;height:27px;background:#2a2a2a;width:960px; border:none; position:relative;">
<?php if($course['islive'] != 1){ ?>				
				<div class="rewardpraise" style="top:60px;z-index:2;width:auto;">
				<?php if($type == 'flv' && !$iszjdlr){ ?>
					<div class="reward">
						<a href="javascript:rewardfa()" class="rewarda">赞赏<span id="rewarda_count" style="margin-left: 5px;"><?=$course_detail['rewardcount']?></span></a>
						<div id="rewardmain" style="display:none;">
							<div id="wxqrcode" class="qrcode_big" style="display: none;">
								<div class="triangle"></div>
								<img src="">
							</div>
							<div id="alipayqrcode" class="qrcode_big"  style="display: none;">
								<div class="triangle"></div>
								<iframe src="" style="border:none!important;border-radius: 0px;" scrolling="no" frameborder="0"></iframe>
							</div>
						<?php
							if($course['sex'] == 1) {
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
							} else {
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
							}
							$face_rewards = empty($course['face']) ? $defaulturl : $course['face'];
							$face_rewards = getthumb($face_rewards,'78_78');
						?>
							<img src="<?=$face_rewards?>"/>
							<div class="tximage"></div>
							<p class="p1s">“你的赞赏，是对我授课的最大鼓励”</p>
							<div class="choosemoney">
								<div class="cmtitle">选择支付金额</div>
								<div class="cmcontent">
									<input type="text" value="18.88" class="inputmoney" onkeyup="Num(this);"/>
									<span class="monyuan">元</span>
									<a href="javascript:;" class="random" style="padding-left:5px;" onclick="randomMoney();">随机</a>
									<span class="ydico">.</span>
									<a href="javascript:;" class="random" onclick="doubled();">加倍</a>
								</div>
							</div>
							<div class="choosemoney">
								<div class="cmtitle">选择支付方式</div>
								<div class="paylist">
									<form>
										<input type="radio" name="payway" id="wechat" class="paywechat" value="wechat" style="margin-left:0;" checked  onclick="paybywechat();"/>
										<label for="wechat">微信</label>
										<input type="radio" name="payway" id="alipay" class="paywechat" value="alipay" onclick="paybyali();" />
										<label for="alipay">支付宝</label>
										<input type="radio" name="payway" id="wallet" class="paywechat" value="wallet" onclick="paybywallet();" />
										<label for="wallet" >我的钱包</label>
									</form>
								</div>
								<div class="wechatpay"  style="display:block;">
									<div class="loading"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif"></div>
									<iframe id="wechatwindow" class="fl" style="border:none;border-radius:0px;width:115px;height:115px;" frameborder="no" border="0" scrolling="no">
									</iframe>
									<p class="wxts" style="width:175px;line-height:20px;padding-left:20px;padding-top:10px;"><span style="color:#f00;">微信</span>扫码完成赞赏<br/><br/>
									更改金额后按住“<span style="color:#f00;">Enter</span>”或<span style="color:#f00;">鼠标单击</span>网页任意空白处完成刷新</p>
								</div>
								<div class="alipay"  style="display:block;">
								<div class="loading"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif"></div>
									<iframe id="alipaywindow" class="fl" style="border:none;border-radius:0px;width:93px;height:93px; padding:11px;" frameborder="no" border="0" scrolling="no">
									</iframe>
									<p class="wxts" style="width:175px;line-height:20px;padding-left:20px;padding-top:10px;"><span style="color:#f00;">支付宝</span>扫码完成赞赏<br/><br/>
									更改金额后按住“<span style="color:#f00;">Enter</span>”或<span style="color:#f00;">鼠标单击</span>网页任意空白处完成刷新</p>
								</div>

								<div style="clear:both;"></div>
								<div class="walletpay">
									<div class="wallete" style="display:none;">
										<input type="button" class="ljzf" value="立即支付"/>
										<span class="balance">我的余额：<b><?php echo $user['balance'];?></b>元</span>
									</div>
									<div class="yebz" style="display:none;">
										<div class="fl yebzimg"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/yebzico.png"/></div>
										<div class="fl yebzwall">钱包余额不足，请先<a href="http://pay.ebh.net/" target="_blank" class="random">充值</a>。<br/>或使用其他方式赞赏。</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					<div class="praise">
						<?php if($type == 'flv'){?>
							<?php if($zan == 1){?>
								<a href="javascript:;" class="tingdian onhover"><?php echo $course['zannum']?></a>
							<?php }else{?>
								<a href="javascript:;" class="tingdian" onclick="addzan()"><?php echo $course['zannum']?></a>
							<?php }?>
						<?php }?>
					</div>
				</div>
<?php } ?>				
				<div style="clear:both;"></div>
				<!--打赏点赞功能end-->

<?php //if($type!='swf'){?>
<div class="mod-func">
<div class="play-danmuWrap play-danmuWrap_close" data-widget-barrage1_5="play" data-barrage1_5-type="short" style="display:<?php if($type=='swf') echo 'none'?>">
<qchunk style="display: block;" data-barrage-ele="barrage" id="block-tucaou" data-asyn-pb="true">
                              <!-- 弹幕开关 -->
                              <div class="danmu-close fl">
                                <div class="clearfix">
                                  <h3 class="fl danmuTit">弹幕</h3>
									<?php
										$showmu = $this->input->cookie('showmu');
									?>
									<?php if($showmu === '0'){?>
                                		<a href="javascript:void(0);" id="muswitch" rseat="140743_opn" data-barrage-status="show" isclose=1 class="switch  fl" data-pb="qpid=384616000"></a> </div>
                              		<?php }else{?>
                              			<a href="javascript:void(0);" id="muswitch" rseat="140743_opn" data-barrage-status="show" class="switch  fl switch_open" data-pb="qpid=384616000"></a> </div>
                              		<?php }?>
                              </div>
                              <!-- 弹幕开关 end-->
                              <!-- 弹幕主内容区 -->
                              <div id="danmu" class="danmu-main fl">
                                <div data-barrage-panel="config" class="tucao-static pr"> <a id="danmu_set" href="javascript:void(0);" class="fl pr tucao-btn" data-barrage-config="config">设置</a>
                                  <!-- 开关引导 -->
                                  <div class="guide-switch" style="display: none;" data-barrage-btntip="wrap" data-private-display="block">
                                    <p class="p-tip1"></p>
                                    <p class="p-tip2"></p>xcxc
                                  </div>
                                  <!-- 开关引导 end-->
                                  <!-- 关闭引导 class替换为guide-switch-close -->
                                  <!-- 设置模块v1.4 -->
                                  <span data-barrage-module="config" data-rendertype="2" data-render="1"><div data-barrage-panel="panel" class="danmu-set-v "><div class="danmu-set_arrowWrap"><i class="danmu-set_arrow"></i><i class="danmu-set_arrowInner"></i></div><div class="set-bd-v"><div class="danmuSet-lt fl"><div class="set-bd-tit"><h4>我的弹幕<em>编辑自己发送的弹幕</em></h4></div><div class="set-bd-container clearfix"><!-- 字号 --><div class="setFontSize fl"><h3>字号</h3><ul><li class="selected"><a rseat="140826_zihao" data-barrage-size="30" class="fs18" href="javascript:void(0);">大</a></li><li class=""><a rseat="140826_zihao" data-barrage-size="20" class="fs16" href="javascript:void(0);">中</a></li><li><a rseat="140826_zihao" data-barrage-size="10" class="fs12" href="javascript:void(0);">小</a></li></ul></div><!-- 字号 end--><!-- 颜色 --><div class="danmu-set-colorHd-v fl"><div class="danmu-set-colorHd-tit clearfix"><span class="tag-fs fl">颜色</span><span class="colBox fl"><input id="colorholder" type="text" data-barrage-customcolor="color" placeholder="#000000"></span><span id="colorshow" data-barrage-preview="color" class="save-color-box fl" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;"></span></div><div class="color-set-bd mt5"><ul id="colorSetBd"><li><a rseat="140826_yanse" data-barrage-color="FFFFFF" href="javascript:void(0);" class="col-FFFFFF" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li  class="hover"><a rseat="140826_yanse" data-barrage-color="000000" href="javascript:void(0);" class="col-000000" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF0000" href="javascript:void(0);" class="col-FF0000" style="background: rgb(255, 0, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF9900" href="javascript:void(0);" class="col-FF9900" style="background: rgb(255, 153, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FFF100" href="javascript:void(0);" class="col-FFF100" style="background: rgb(255, 241, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="00FF12" href="javascript:void(0);" class="col-00FF12" style="background: rgb(0, 255, 18) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="00FCFF" href="javascript:void(0);" class="col-00FCFF" style="background: rgb(0, 252, 255) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="008CEE" href="javascript:void(0);" class="col-008CEE" style="background: rgb(0, 140, 238) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="8600FF" href="javascript:void(0);&quot;&quot;" class="col-8600FF" style="background: rgb(134, 0, 255) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF6600" href="javascript:void(0);&quot;&quot;" class="col-FF6600" style="background: rgb(255, 102, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF0096" href="javascript:void(0);" class="col-FF0096" style="background: rgb(255, 0, 150) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="920683" href="javascript:void(0);" class="col-920683" style="background: rgb(146, 6, 131) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="601886" href="javascript:void(0);" class="col-601886" style="background: rgb(96, 24, 134) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="1D24A4" href="javascript:void(0);" class="col-1D24A4" style="background: rgb(29, 36, 164) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="804E21" href="javascript:void(0);" class="col-804E21" style="background: rgb(128, 78, 33) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="9D6A3C" href="javascript:void(0);" class="col-9D6A3C" style="background: rgb(157, 106, 60) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="DE8A3E" href="javascript:void(0);" class="col-DE8A3E" style="background: rgb(222, 138, 62) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="90C41E" href="javascript:void(0);" class="col-90C41E" style="background: rgb(144, 196, 30) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="21AC38" href="javascript:void(0);" class="col-21AC38" style="background: rgb(33, 172, 56) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="009139" href="javascript:void(0);" class="col-009139" style="background: rgb(0, 145, 57) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li></ul></div></div><div class="mod-location fl"><h3>位置</h3><div id="shlocation" class="mod-location-bd"><a rseat="140826_weizhi" data-barrage-position="1" href="javascript:void(0);" class=""><i class="dt_top"></i><span>顶部</span></a><a rseat="140826_weizhi" data-barrage-position="2" class="" href="javascript:void(0);"><i class="dt_center"></i><span ata-barrage-position="2">中间</span></a><a rseat="140826_weizhi" data-barrage-position="3" class="" href="javascript:void(0);"><i class="dt_bottom"></i><span ata-barrage-position="3">底部</span></a><a rseat="140826_weizhi" data-barrage-position="0" class="selected" href="javascript:void(0);"><i class="dt_random "></i><span ata-barrage-position="0">随机</span></a></div></div></div></div><div data-barrage-wrap="danmusetrt" class="danmuSet-rt fl"><div class="set-bd-tit"><h4>弹幕显示设置</h4></div><!-- 透明度 --><div data-barrage-opacity="wrap" class="mod-opac-set"><h3>透明度</h3><div class="opac-block mt5 clearfix"><div id="dragbar" rseat="140826_toumin" data-barrage-opacity="btn" class="opacBg-outer-v fl pr"><span id="draghandle" class="opacBg-inner-v" style="left: 70px;" data-barrage-opacity="trigger"></span></div><div id="persent" class="opac-block-num fl ml5" data-barrage-opacity="value"> 82%</div></div></div><!-- 透明度 --><div class="bq-set-show"><h3>弹幕显示</h3><a class="disabled-pic" data-barrage-filter="image" href="javascript:void(0);" rseat="14090901_bqkq"><i class="disPic-ico"></i><span>屏蔽图片表情</span></a></div></div></div></div></span>
                                  <!-- 设置模块v1.4 end-->
                                </div>
                                <span  data-barrage-wrap="input" class="conduct-bar pr conduct-bar-v2 tucao-input-default"> <span class="inputAdd-smile">
                                  <input id="tanmu_msg" type="text" maxlength="20" class="fl tucao-input" placeholder="发送弹幕一起high！" data-barrage-input="barrage" style="width:235px;overflow:hidden;">
                                  <!-- 输入引导 -->
                                  <span style="display: none;" data-barrage-guide="tip" data-private-display="block"></span>
                                  <!-- 输入引导 end-->
                                  </span> <span data-pb="qpid=384616000" class="fl pr tucao-bqBtn" style="display:none;" rseat="140730_0" data-barrage-face="barrage"> <i class="smile-lightIco"></i>
                                  <!-- 笑脸上方TIPS -->
                                  <!-- 表情引导 -->
                                  <div class="guide-smile" style="display: none;" data-barrage-facetip="wrap" data-private-display="block">
                                    <p class="p-tip1"></p>
                                    <p class="p-tip2"></p>
                                  </div>
                                  <!-- 表情引导 end-->
                                  <iframe frameborder="0" style="display:none;" class="frame-smile" data-barrage-iframe="face"></iframe>
                                  <!-- 笑脸上方TIPS end-->
                                  <!-- 表情 -->


                                  <!-- 表情 end-->
                                  </span> </span> <a data-pb="qpid=384616000" href="javascript:dosend();" class="fl send-btn " data-barrage-send="barrage" rseat="140730_set" style="display: block; color:#fff!important;">发送</a> </div>
                              <!-- 弹幕主内容区 end-->
                            </qchunk>
                            </div>
                            </div>
<!--            --><?php //}?>






			<div class="ieyin" style="_display:block;"><br/><br/></div>
			<div class="tksile" style="width:355px;">
			<!--	<a href="javascript:openScreenShotDialog();" class="screenshot" id="screenshot">截图</a>-->
							<?php if((empty($hasnobtn) || $hasnobtn != TRUE) && $user['groupid'] == 6 && $domain != 'www') { ?>
					<a href="javascript:;" class="<?= empty($myfavorite)?'shoutie':'yishout'?>" id="favorite" style="height:21px;line-height:21px;" ></a>
				<?php } ?>
				<a href="javascript:showfeedback();" class="tingfan">听课反馈</a>
				<?php if(($roominfo['isschool']!=2) && ($type == 'flv' || $type == 'mp3' ||$type=='swf')&& $domain!='www'){ ?>
					<a id="notebtn" href="javascript:;" class="lubij" name="notes">录入笔记</a>
					<!--<a href="javascript:;" onclick="document.getElementById('flvcontrol').callflashvideo()"  class="tixuetime" style="display:<?php if($type=='swf') echo 'none'?>">提交学习时间</a>-->
				<?php } ?>
				<a href="javascript:void(0)" onclick="showAskDialog()" class="tiwenti" name="notes">提问</a>
			</div>

			</div>
			<div id="notecontent" style="display:none">
					<div class="txtxdaru" style="float:left;width:980px;display: inline;margin-top:5px;">
					<?php if(empty($mynote['ftext'])){ ?>
						  <?php $editor->xEditor('message','978px','300px'); ?>
					<?php }else{ ?>
						  <?php $editor->xEditor('message','978px','300px',$mynote['ftext']); ?>
					<?php } ?>
					</div>
				  <div style="float:right;margin-top:5px;">
					<a href="javascript:;" id="cancel" style="margin-right:80px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px; border-radius:4px;">取消</a>
					<a href="javascript:;" onclick="submitnote(<?= $course['cwid']?>);" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;border-radius:4px;">提交</a>
				  </div>
			</div>
			<?php } else if($course['islive']) {?>
				<div style="color:red;position: relative;height:558px;z-index:601;float:left;">
				<?php if($isliverun){?>
				<div style="width:980px;height:558px;background:white;text-align:center">
				<?php if(!empty($is_mobile)){?>
					<?php if(!empty($is_app) && $is_app){?>
					<span style="font-size:36px;width:970px;float:left;margin-top:200px">上课进行中...</span>
					<span style="font-size:50px;width:970px;float:left;margin-top:10px">

					<a id="notebtn" class="lanbtn liaskt" name="notes" href="<?=$runlink?>" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:36px;width:300px;background:#18a8f7;">进入学习</a>

					</span>
					<?}else{?>

					<span style="font-size:36px;width:970px;float:left;margin-top:200px">上课进行中...</span>
					<span style="font-size:50px;width:970px;float:left;margin-top:10px">

					<a id="notebtn" class="lanbtn liaskt" name="notes" href="/myroom/mycourse/<?= $course['cwid'] ?>.html?flag=1" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:36px;width:300px;background:#18a8f7;">进入学习</a>

					</span>
		            <?php } ?>
				<?php }else{ ?>
				<span style="font-size:36px;width:970px;float:left;margin-top:200px">上课进行中...</span>
				<span style="font-size:50px;width:970px;float:left;margin-top:10px">

				<a id="notebtn" class="lanbtn liaskt isPC" name="notes" href="<?php if($showebhbrowser){?>javascript:void(0);<?php }else{ ?>/myroom/mycourse/<?= $course['cwid'] ?>.html?flag=1 <?php } ?>" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:36px;width:300px;background:#18a8f7;">进入学习</a>

				</span>
				<?php } ?>
				</div>
				<?php }elseif(empty($course['endat']) || SYSTIME<=$course['endat']){?>
				<div style="width:980px;height:560px;background:white;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:200px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</span>
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">倒计时：<span id="countdown"><?=secondToStr($course['submitat']-SYSTIME)?></span></span>
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">请耐心等候...</span>
				</div>
				<?php }else{?>
				<?php if($liveinfo['review'] == 1){?>
					<?php if($liveinfo['review_start'] != 0 && $liveinfo['review_start'] > SYSTIME){ ?>
					<div style="width:980px;height:560px;background:white;text-align:center">
					<span style="font-size:30px;width:970px;float:left;margin-top:200px;color:#000;">回看将于 <?=Date('Y-m-d H:i',$liveinfo['review_start'])?> 开始,敬请期待</span>
					</div>
					<?php }else if($liveinfo['review_end'] != 0 && $liveinfo['review_end'] < SYSTIME){ ?>
					<div style="width:980px;height:560px;background:white;text-align:center">
					<span style="font-size:50px;width:970px;float:left;margin-top:200px">已于 <?=Date('Y-m-d H:i',$liveinfo['review_end'])?> 结束</span>
					</div>
					<?php }else{ ?>
					<?if ( $course['ism3u8'] == 1){ ?>
						<div style="width:980px;height:560px;background:white;text-align:center">
							<span style="font-size:20px;font-weight:bold;width:970px;float:left;margin-top:200px;color:#000;">直播结束</span>
							<span style="font-size:50px;width:970px;float:left;margin-top:10px">
								<a class="lanbtn liaskt" name="notes" href="/myroom/mycourse/<?= $course['cwid'] ?>.html?review=1" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#18a8f7;">进入回看</a>
							</span>
						</div>
					<?php }else{ ?>
						<div style="width:980px;height:560px;background:white;text-align:center">
							<span style="font-size:20px;font-weight:bold;width:970px;float:left;margin-top:200px;color:#000;">直播已结束，视频正在转码中，请稍候...</span>
							<span style="font-size:50px;width:970px;float:left;margin-top:10px">
								<a class="lanbtn liaskt" name="notes" href="javascript:;" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#999;">进入回看</a>
							</span>
						</div>
					<?php } ?>
					<?php } ?>
					
				<?php } else{ ?>
					<div style="width:980px;height:560px;background:white;text-align:center">
					<span style="font-size:50px;width:970px;float:left;margin-top:200px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
					</div>
				<?php } ?>
				
				
				
				<?php }?>
				
				<!--
					<div style="width:980px;height:560px;background:white;text-align:center">
						<span style="font-size:20px;font-weight:bold;width:970px;float:left;margin-top:200px;color:#000;">直播已结束，视频正在转码中，请稍候...</span>
						<span style="font-size:50px;width:970px;float:left;margin-top:10px">
							<a id="notebtn" class="lanbtn liaskt" name="notes" href="javascript:;" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#999;">进入回看</a>
						</span>
					</div>
					-->
					<!--
					<div style="width:980px;height:560px;background:white;text-align:center">
						<span style="font-size:20px;font-weight:bold;width:970px;float:left;margin-top:200px;color:#000;">直播结束</span>
						<span style="font-size:50px;width:970px;float:left;margin-top:10px">
							<a id="notebtn" class="lanbtn liaskt" name="notes" href="javascript:;" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#18a8f7;">进入回看</a>
						</span>
					</div>
					-->
				
				
				
				</div>
			<?php } ?>


		<!-- 课件 ppt/word等预览 开始 -->
		<!-- word预览加上每頁等待 -->
		<?php $this->assign('course',$course);?>
		<?php $this->assign('stime',$stime);?>
		<?php $this->display('common/previewv2');?>
		<!-- 课件 ppt/word等预览  结束 -->
		<?php if($course['islive'] != 1 || $course['endat'] < SYSTIME){ ?>
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:20px;width:980px;border:none;position:relative;">
				<?php if($iszjdlr && $cwuser['toid'] == 1){?>
				<?php }else{?>
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
				<?php }?>
			  	<div class="inconts" style="width:928px;">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>


		<?php if($domain!='www') { ?>
			<div class="introduce" id="examworkList" style="width:980px; border:none;">
					<div class="intitle">
					<h2 style="padding: 0;">
						<a class="onlinework active" id="rid" onclick="parse_Joblist()">在线作业</a>
					</h2>
				</div>
				<div  class="incont" style="width:980px;">
						<table width="978px;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th width="55%" style="padding-left:35px;" >&nbsp;作业名称</th>
									<th width="13%"  style="text-align: center;">出题时间</th>
									<th width="10%" style="text-align:center;">总分</th>
									<th width="22%" style="text-align:left;">操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							 	</tr>
							  </thead>
								<tbody>
							  </tbody>
						</table>
					</div>

				</div>
			<?php } ?>

			<?php if(!empty($survey) && ($domain!='www')) { ?>
			<div class="introduce" style="width:980px;border:none;">
					<div class="intitle">
					<h2>调查问卷</h2>
				</div>
				<div class="incont" style="width:980px;">
						<table width="978px;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th style="padding-left:35px;">问卷名称</th>
									<th style="padding-left:50px;">开放时间</th>
									<th style="padding-left:80px;">操作</th>
							 	</tr>
							  </thead>
								<tbody>
								  <tr>
									<td width="55%" style="font-family:微软雅黑;color:#333;padding:3px 6px;font-size:14px;">&nbsp;<?=strip_tags($survey['title']) ?></td>
									<td width="23%"><?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d',$survey['enddate'])?></td>
									<td width="22%">
											<?php if(!$survey['answered'] && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
												<a class="previewBtn" style="" href="/college/survey/fill/<?= $survey['sid'] ?>.html" target="_blank">参与调查</a>
											<?php }else{?>
												<a class="previewBtn" style="" href="/college/survey/answer/<?= $survey['sid'] ?>.html" target="_blank"><span>查看详情</span></a>
											<?php }?>
											<?php if($survey['allowview']){?>
												<a class="previewBtn" style="" href="/college/survey/stat/<?= $survey['sid'] ?>.html" target="_blank">统&nbsp;&nbsp;计</a>
											<?php }?>
									</td>
								  </tr>
							  </tbody>
						</table>
					</div>
				</div>
			<?php } ?>

			<a name="fujian" href="javascript:void(0);"></a>

				<?php if (($domain!='www') && (!empty($attachments))) { ?>
				<div class="introduce" style="width:980px; border:none;">
					<div class="intitle">
						<h2>附件下载</h2>
					</div>

					<div class="incont" style="width:980px;">
							<table width="978px;" class="datatab" style="border:none;">
								<thead class="tabhead">
									<tr>
										<th style="padding-left:35px;">附件名称</th>
										<th>上传时间</th>
										<th>附件大小</th>
										<th>操作</th>
									</tr>
								  </thead>
									<tbody>
									 <?php foreach ($attachments as $atta) { ?>
									  <tr>


									<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<td width="55%"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/fjico.png" style="width:13px;height:13px;float:left;padding-left:10px;padding-top:5px;"><span style="width:400px;word-wrap: break-word;float:left;padding-left:5px"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
										<?php } else { ?>
											<td width="55%"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/fjico.png" style="width:13px;height:13px;float:left;padding-left:10px;padding-top:5px;"><span style="width:400px;word-wrap: break-word;float:left;padding-left:10px"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
										<?php } ?>
									<?php } ?>
										<td width="13%"><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
										<td width="10%"><?= getsize($atta['size'])?></td>
										<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<td width="22%">
											<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载" type="button" />
												<?php if($atta['ispreview']) { ?>
												<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" target="_blank">预览</a>
												<?php } ?>
											<?php } else { ?>
												<a class="atfalsh atfalsh1s" href="javascript:void(0);" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
											<?php } ?>
										</td>
										<?php } ?>
									  </tr>
									  <?php } ?>
								  </tbody>
							</table>
					</div>
				</div>
				<?php } ?>
<?php if($course['islive'] != 1){ ?>
<?php if($roominfo['crid'] != 10420){ ?>
	<div class="introduce" style="float:left;width:980px; border:none;padding-bottom:120px; position:relative;">
		<div class="work_mes" style="width:978px;margin-bottom:10px">
			<ul>
				<li class="workcurrent reviewtab" onclick="showreview()" id="commentTag"><a href="javascript:void(0)"><span><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?> (<font color="red" id="reviewcount"><?=$reviewcount?></font>)</span></a></li>
				<li class="asktab" onclick="showask()"><a href="javascript:void(0)"><span>相关问题 (<font color="red" id="relativeask"><?=$askcount?></font>)</span></a></li>
				<?php if($type == 'flv' && !$iszjdlr){?>
				<li class="reviewtab" id="analysis"><a href="javascript:void(0)"><span>分析统计</span></a></li>
				<?php }?>
			</ul>
		</div>

		<div id="reviewdiv">
				<!--新评论开始-->
				<div class="coursewareview">
				<?php if(!$iszjdlr){?>
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
				<?php }?>
				    <textarea class="inputrating" id="comment-input" maxlength="800" ></textarea>

				    <div class="facecomments">
						<input class="emoji_btn" id="emoji_btn_1" src="http://static.ebanhui.com/ebh/js/qqFace/index.png" style="" type="image">
						<!--<a href="javascript:;" class="face face-comment"></a>-->
				        <!--<div class="qqface1" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qqbq.jpg" /></div>-->
				        <a style="display: block;" href="javascript:;" onclick="comment();" class="reviews" id="reviews">评&nbsp;论</a>
				        <span class="reviewstime" id="reviewstime">评论&nbsp;<span id="talktime"></span> s</span>
				        <?php if(!$isnewzjdlr){?>
				        <p class="inputprompt inputprompt-bottom"><?=$iszjdlr?'您还需输入':'你还可以输入'?><span>100</span>字</p>
				        <?php }?>
						<p class="inputprompt commentava" style="display:none">点击右侧按钮发布评论</p>
				    </div>
				    <div class="clear"></div>
				    <div class="allcomments">

				    </div>
				</div>
				<?= $pagestr ?>
				<!--新评论结束-->
		</div>
		<div id="askdiv" style="float:left;width:970px;display:none;padding-bottom:30px">
			<div style="text-align:center;" id="noask">
			<span style="font-size:14px;line-height:30px;width:978px;height:200px;float:left;margin-bottom:20px;margin-top:20px;" >
			<img src="http://static.ebanhui.com/ebh/tpl/default/images/noask.png" >
			</span>
			<input class="tijibtn" type="button" value="提&nbsp;&nbsp;问" onclick="showAskDialog()">

			</div>
			<div class="tweytr" style="margin-left:10px">
				<table>

				</table>
			</div>

		</div>
			<div class="qzsjlb" id='analysisdiv' style="display: none">
				<div class="zhqks mt35">
					<div class="nnbl">课件听课人数</div>
					<div class="ml20 mt30" id="chartcontainer1" style="text-align:center;width:875px;height:400px"></div>
				</div>
		        <div class="zhqks mt35">
					<div class="nnbl">我的听课数据</div>
					<div class="ml20 mt30" id="chartcontainer2" style="text-align:center;width:875px;"></div>
				</div>
		        <div class="zhqks zhqks1s mt35">
		        	<span class="wdtkcs times">我的听课次数：次</span>
		            <span class="wdtkcs wdtkcs1s totaltime">我的听课时长：分钟</span>
		            <span class="wdtkcs ord">排名：名</span>
		        </div>
			</div>
			</div>
		<?php }else { ?>
		<?php if($roominfo['isschool']!= 3){ ?>
		<div class="introduce" style="float:left;width:980px;">
					<div class="intitle"><h2><a id="rid"><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论'?></a></h2></div>
					  <!--评论-->
					  <!--新评论开始-->
				<div class="coursewareview">
				<?php if(!$iszjdlr){?>
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
				   <?php } ?>
				    <textarea class="inputrating" id="comment-input"></textarea>
				    <div class="facecomments">
				    	<a href="javascript:;" class="face face-comment"></a>
				        <div class="qqface1" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qqbq.jpg" /></div>
				        <a href="javascript:;" onclick="comment();" class="reviews">评&nbsp;论</a>
				        <?php if(!$isnewzjdlr){?>
				        <p class="inputprompt inputprompt-bottom">你还可以输入<span>100</span>字</p>
				        <?php }?>
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
<?php } ?>
<?php } ?>			
</div>
<div id="moreask" style="display:none;float:left;text-align:center;background:#fff;border:1px solid #cdcdcd;width:978px;height:35px;line-height:35px;font-size:14px;margin-top:-10px;">
	<a target="_blank" href="/myroom.html?url=college/myask/all.html?cwid=<?=$course['cwid']?>" style="width:978px;display:block;">更多>></a>
</div>
</div></div>



<?php
if($type == 'ebhp') {
	$this->display('myroom/player');
}
?>
<?php $this->display('myroom/page_footer'); ?>

<?php if(!empty($is_mobile)){?>
<script>

  	//记录学习时间
	var study_data = {
		'end':0,
		'start':0,
		'total':0,
		'logid':0,
		'timer':{}
	};
	var video = $('#_video');

	$(function(){
		video.on('pause', function() {
			clearInterval(study_data.timer);
			study_data.end = new Date().getTime();
			study_data.total += study_data.end-study_data.start;
			xmessfun("<?=$course['cwid']?>",video[0].duration,(Math.ceil(study_data.total/1000)),study_data.logid);

		});
		video.on('playing',function(){
				study_data.start = new Date().getTime();
				study_data.timer = setInterval(function(){
				study_data.end = new Date().getTime();
				study_data.total += study_data.end-study_data.start;
				study_data.start = study_data.end;
				xmessfun("<?=$course['cwid']?>",video[0].duration,(Math.ceil(study_data.total/1000)),study_data.logid);

			},60000);
		});
	});

	function xmessfun(id,ctime,ltime,lid){
		if( ctime <= ltime ){
			study_data.logid = messfun(ctime,ltime,0,lid);
		}else{
			study_data.logid = messfun(ctime,ltime,1,lid);
		}
	}
</script>
<?php } ?>
<?php if($showebhbrowser){?>
<script type="text/javascript">
	$(function(){
 		$(".isPC").on("click",function(){
			var tips = top.dialog({
				id: 'free-window',
				title: '学习浏览器',
				fixed: true,
				content: '本直播课不支持使用其他浏览器学习，请使用平台专属的 “ 学习浏览器 ” 进行学习，也可点击下方 “ 立即下载 ” 进行安装',
				padding: 20,
				width:300,
				okValue: '立即下载',
				ok: function() {
				  location.href = "http://soft.ebh.net/ebhbrowser.zip";
				}
			});
			tips.showModal();
		});
	})
</script>
<?php } ?>
<!--新评论JS-->
<script type="text/javascript">
	$('#mark_score').val(0);
	//播放结束弹窗
	//用于记录回复记录
	var reply_log = new Object();
	<?php if($course['islive'] != 1 || $course['endat'] < SYSTIME){ ?>
	parse_Joblist();
	<?php } ?>
	function parse_Joblist(bol){ //在线作业
		var exampower = "<?=$examPower?>";
		if(exampower ==0){
			url = '/college/mycourse/getCwidExamsAjax.html';
		}else if(exampower ==1){
			url = '/college/examv2/getCwidExamsAjax.html';
		};
		$.ajax({
			url:url,
			type:'post',
			data:{
				'cwid': <?= $course['cwid'] ?>
			},
			dataType:'json',
			success:function(result){
				var list = '';
				if(exampower ==0){
					if(result.length > 0){
						for(var i=0;i<result.length;i++){
							var isapple = '<?=(!empty($isapple)?$isapple:0)?>';
							if(isapple != '0'){
								$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid=<?=$roominfo['crid']?>&k=<?=urlencode(!empty($key)?$key:0)?>&eid='+ result[i].eid;
								$viewurl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid=<?=$roominfo['crid']?>&k=<?=urlencode(!empty($key)?$key:0)?>&eid='+ result[i].eid;
							}else{
								$dourl = 'http://exam.ebanhui.com/edo/'+result[i].eid+'.html';
								$viewurl = 'http://exam.ebanhui.com/emark/'+result[i].eid+'.html';
							}
							list += '<tr>';
							list += '<td width="55%" style=""><p class="bzzytitle">&nbsp;'+ result[i].title+'</p></td>';
							list += '<td width="13%">'+new Date(parseInt(result[i].dateline)* 1000).format("yyyy-MM-dd hh:mm:ss") +'</td>';
							list += '<td width="10%" style="text-align:center;">'+ result[i].score+'</td>';
							list += '<td width="22%">';
							if(result[i].status == null){
							list += '<a class="previewBtn" style="" href="'+$dourl+'" target="_blank"><span>做作业</span></a>';
							}else if(result[i].status == 1){
							list += '<a class="lviewbtn" style="" href="'+ $viewurl+'" target="_blank">查看结果</a>';
							}else{
							list += '<a class="previewBtn" style="" href="'+ $dourl+'" target="_blank">继续做作业</a>';
							}
							list += '</td>';
							list += '</tr>';
						}
						$('#examworkList table.datatab tbody').empty().append(list);
					}else{
						$('#examworkList').remove();
					};
				}else if(exampower ==1){
					var examList = result.datas.examList;
					if(examList.length > 0){

						for(var i=0;i<examList.length;i++){
							list += '<tr>';
							list += '<td width="55%" style=""><p class="bzzytitle">&nbsp;'+ examList[i].exam.esubject+'</p></td>';
							list += '<td width="13%">'+new Date(parseInt(examList[i].exam.dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>';
							list += '<td width="10%" style="text-align:center;">'+ examList[i].exam.examtotalscore+'</td>';
							list += '<td width="22%">';
							if(examList[i].exam.examstarttime > examList[i].exam.nowtime){
								list +='<a  class="bjcgs errorbjsgs" href="javascript:void(0)">等待开放</a>'
							}else if(examList[i].exam.examendtime && examList[i].exam.examendtime<examList[i].exam.nowtime){
								list +='<a  class="bjcgs errorbjsgs" href="javascript:void(0)">已过期</a>'
							}else{
								if(!examList[i].userAnswer){
								list += '<a class="previewBtn" style="" href="/college/examv2/doexam/'+examList[i].exam.eid+'.html" target="_blank"><span>做作业</span></a>';
								}else if(examList[i].userAnswer.status == 1){
								list += '<a class="lviewbtn" style="" href="/college/examv2/doneexam/'+examList[i].exam.eid+'.html" target="_blank">查看结果</a>';
								}else{
								list += '<a class="previewBtn jxzzy" style="" href="/college/examv2/doexam/'+examList[i].exam.eid+'.html" target="_blank">继续做作业</a>';
								}
							}


							list += '</td>';
							list += '</tr>';
						}
						$('#examworkList table.datatab tbody').empty().append(list);
					}else{
						$('#examworkList').remove();
					}
			}
			}
		});
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
	}
	function popup_comment(){
		var msg = $.trim($("#pop-comment-input").val());
		var mark = $("#mark_score").val();
		if(msg=='' || msg=='亲，给这节课写个评价吧...'){
			var d = dialog({
		    title: '提示',
		    content: '发表内容不能为空。',
		    cancel: false,
			okValue: '确定',
		    ok: function () {}
			});
			d.showModal();
			$("#pop-comment-input").focus();
			return false;

		}
		<?php if(!$iszjdlr){?>
		else if($.trim($('#pop-comment-input').val().replace(/<[^>]*>/g,'')).length>100){
			var d = dialog({
				title: '提示',
				content: '发表内容不能大于100字',
				cancel: false,
				okValue: '确定',
				ok: function () {}
			});
			d.showModal();
			$("#pop-comment-input").focus();
			return false;
		}
		<?php }else{?>
			<?php if(!$isnewzjdlr){?>
				else if($.trim($('#pop-comment-input').val()).length<100){
					var d = dialog({
						skin: "ui-dialog2-tip",
						content: "<div class='FPic'></div><p>字数不足，评论失败</p>", //三种图片，TPic:勾,FPic:叉,PPic:感叹号
						onshow: function() { //此事件在弹层显示后执行
							var that = this;
							setTimeout(function() {
								that.close().remove();
							}, 2000);
						}
					});
					d.showModal();
					$("#pop-comment-input").focus();
					return false;
				}
			<?php }?>
		<?php }?>
		var url = "<?= geturl('myroom/review/add')?>";
		var domain = "<?=$domain?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'cwid':'<?= $course['cwid'] ?>','mark':mark,'type':'courseware'},
			dataType:'json',
			success:function(result){
				if(result.status == '1'){
					dialog({
						id: "endabc", //可选
						skin: "ui-dialog2-tip",//想要调用图片这个是必须的
						<?php if($iszjdlr){?>
						content: "<div class='TPic'></div><p>评论成功，等待审核...</p>", //三种图片，TPic:勾,FPic:叉,PPic:感叹号
						width: 350,
						<?php }else{?>
						content: "<div class='TPic'></div><p>评论成功</p>",
						width: 150,
						<?php }?>
						onshow: function() { //此事件在弹层显示后执行
							var that = this;
							setTimeout(function() {
								that.close().remove();
								for(var i=0;i<$('.emoji_btn').length;i++){
									if(i!=0){
										$($('.emoji_btn')[i]).remove();
									}
								}
							}, 2000);
						}
					}).show();
					$("#pop-comment-input").val('');
					$('.popup').hide();
					page_load(1,"/myroom/mycourse/getajaxpage.html");
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

	$('#pop-comment-input').bind('keyup', function() {
		<?php if(!$iszjdlr){?>
		if(100-$('#pop-comment-input').val().length <= 0){
			$('#pop-comment-input').val($('#pop-comment-input').val().substring(0,100));
		}
		$('.inputprompt-pop span').html(100-$('#pop-comment-input').val().length);
		<?php }else{?>
		if($.trim($('#pop-comment-input').val()).length<100){
			$('.pop-commentava').hide();
			$('.inputprompt-pop').show();
			$('.inputprompt-pop span').html(100-$.trim($('#pop-comment-input').val()).length);
		}
		else{
			$('.inputprompt-pop').hide();
			$('.pop-commentava').show();
		}
		<?php }?>
	})

	function chose_popup_star(obj,oEvent){
		var imgSrc = 'http://static.ebanhui.com/ebh/tpl/2016/images/fivestar.png';
    	var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/2016/images/fivestar1.png';
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
	if($('.face-pop').html() != undefined){
		$('.face-pop').qqFace({
			id : 'facebox',
			assign:'pop-comment-input',
			top:'-250px',
			left:'200px',
			path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
		});
	}



	$('.face-pop').click(function(){
		if($('#pop-comment-input').val() == '亲，给这节课写个评价吧...'){
			$('#pop-comment-input').val('');
		}

	});

	$('#pop-comment-input').focus(function(){
		if($(this).val() == '亲，给这节课写个评价吧...'){
			$(this).val('');
		}
	});
	$('#pop-comment-input').blur(function(){
		if($(this).val() == ''){
			$(this).val('亲，给这节课写个评价吧...');
		}
	});
	//播放结束弹窗
	function showCommentDialog(){
		$('.popup').show();
	}
	//关闭结束弹窗
	function closeCommentDialog(){
		$('.popup').hide();
	}
	//删除评论
	function del_comment(log_id,obj){
		var d = dialog({
			title: '删除评论',
			content: '您确定要删除该评论吗？删除后不可查看该评论!',
			okValue: '确定',
			ok: function () {
				var url = "<?= geturl('myroom/review/del')?>";
				$.ajax({
					url:url,
					type:'post',
					data:{'logid':log_id,'cwid':'<?= $course['cwid'] ?>'},
					dataType:'json',
					success:function(result){
						if(result.status == '1'){
							for(var i=0;i<$('.emoji_btn').length;i++){
								if(i!=0){
									$($('.emoji_btn')[i]).remove();
								}
							}
							//$('#comment_'+log_id).remove();
							var url = "/myroom/mycourse/getajaxpage.html";
							var $curr_page_a = $('#reviewdiv .pages .listPage a.none');

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
									page = 1;
								}
								page_load(page,url,true);
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

	var isnewzjdlr = <?=!empty($isnewzjdlr) ? 'true' : 'false'?>;
	$('#comment-input').bind('keyup', function() {
		<?php if(!$iszjdlr){?>
		if(100-$('#comment-input').val().length <= 0){
			$('#comment-input').val($('#comment-input').val().substring(0,100));
		}
		$('.inputprompt-bottom span').html(100-$('#comment-input').val().length);
		<?php }else{?>
		if($.trim($('#comment-input').val()).length<100){
			$('.commentava').hide();
			$('.inputprompt-bottom').show();
			$('.inputprompt-bottom span').html(100-$.trim($('#comment-input').val()).length);
		}
		else{
			$('.inputprompt-bottom').hide();
			$('.commentava').show();
		}
		<?php }?>

	})
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
			str = str.replace(/\[(tieba|qq)_(\d+)\]/g,'<img src="http://static.ebanhui.com/ebh/js/qqFace/$1/$2.jpg" />')
		}

		str = str.replace(/<([^i][^m][^g])/g,'&lt;$1');
		return str;
	}


	//设置cookie
	function setCookie(name, value, expiredays) {
	    var Days = 30;
	    var exp = new Date();
	    exp.setTime(exp.getTime() + expiredays*1000);
	    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
	}
	//读取cookies
	function getCookie(name){
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	    if(arr=document.cookie.match(reg))
	        return (arr[2]);
	    else
	        return null;
	}

	//删除cookies
	function delCookie(name){
	    var exp = new Date();
	    exp.setTime(exp.getTime() - 1);
	    var cval=getCookie(name);
	    if(cval!=null)
	        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}


	var timelag1;
	$.ajax({
		type: "GET",
		url: '/register/getbindstatus.html',
		dataType: 'json',
		async: false,
		success:function(json){
			timelag1 = json.data.review_interval;
		},
		error: function(){
			//console.log("接口错误！");
		}
	});
	if(timelag1 == undefined){
		timelag1 = 0;
	}
	var $reviewstime = $("#reviewstime");
	var $reviews = $("#reviews");
	var $talktime = $("#talktime");

	thecookie();
	function thecookie(){
		var endtimecuo = getCookie('timepinlun');
		var nowtimecuo; //当前时间
		var resttime;	//剩余时间

		if(endtimecuo == null){
			$reviews.css("display","block");
			$reviewstime.css("display","none");
			return false;
		}else{
			$reviews.css("display","none");
			$reviewstime.css("display","block");
			nowtimecuo = Date.parse(new Date())/1000;
			resttime = endtimecuo - nowtimecuo;
			if(resttime<=0){
				$reviews.css("display","block");
				$reviewstime.css("display","none");
				return false;
			}else{
				$talktime.html(resttime);
				var time1 = setInterval(function(){
					nowtimecuo = Date.parse(new Date())/1000;
					resttime = endtimecuo - nowtimecuo;
					$talktime.html(resttime);
					if(resttime <= 0){
						clearInterval(time1); //清除计时器
						delCookie('timepinlun');//删除cookie
						$reviews.css("display","block");
						$reviewstime.css("display","none");
					}
				},1000);
			}
		};
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

		}
		<?php if(!$iszjdlr){?>
		else if($.trim($('#comment-input').val().replace(/<[^>]*>/g,'')).length>100){
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
		<?php }else{?>
			<?php if(!$isnewzjdlr){?>
				else if($.trim($('#comment-input').val()).length<100){
					var d = dialog({
						skin: "ui-dialog2-tip",
						content: "<div class='FPic'></div><p>字数不足，评论失败</p>", //三种图片，TPic:勾,FPic:叉,PPic:感叹号
						onshow: function() { //此事件在弹层显示后执行
							var that = this;
							setTimeout(function() {
								that.close().remove();
							}, 2000);
						}
					});
					d.showModal();
					$("#comment-input").focus();
					return false;
				}
			<?php }?>
		<?php }?>
		var url = "<?= geturl('myroom/review/add')?>";
		var domain = "<?=$domain?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'cwid':'<?= $course['cwid'] ?>','mark':mark,'type':'courseware'},
			dataType:'json',
			success:function(result){
				for(var i=0;i<$('.emoji_btn').length;i++){
                if(i!=0){
                    $($('.emoji_btn')[i]).remove();
                }
            }
				if(result.status == '1'){
					dialog({
						id: "abc", //可选
						skin: "ui-dialog2-tip",//想要调用图片这个是必须的
						<?php if($iszjdlr){?>
						content: "<div class='TPic'></div><p>评论成功，等待审核...</p>", //三种图片，TPic:勾,FPic:叉,PPic:感叹号
						width: 350,
						<?php }else{?>
						content: "<div class='TPic'></div><p>评论成功</p>",
						width: 150,
						<?php }?>
						onshow: function() { //此事件在弹层显示后执行
							var that = this;
							setTimeout(function() {
								that.close().remove();
							}, 2000);
						},
						onclose: function(){	//在弹窗回调中读取cookie
							var timestamp = Date.parse(new Date())/1000;
							timelag1 = parseInt(timelag1);
							var timeend = timestamp + timelag1;
							setCookie('timepinlun',timeend,timelag1);
							thecookie();
						}
					}).show();
					$("#comment-input").val('');
					$('.inputprompt-bottom span').html(100);
					$('#reviewcount').html(parseInt($('#reviewcount').html())+1);
					page_load(1,"/myroom/mycourse/getajaxpage.html");
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
	<?php if($course['islive'] != 1){ ?>
	$('.face-comment').qqFace({
		id : 'facebox',
		assign:'comment-input',
		top:'-160px',
		path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
	});
	<?php } ?>
	$('.face-comment').click(function(){
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
	        html+='<div class="restore_arrow1 restore_arrow1tea" style="right:10px;"></div>';
	        html+='<textarea id="inputrating" class="inputrating inputrating-reply" tips="'+$(obj).attr('tips')+'">'+$(obj).attr('tips')+'</textarea>'
			html+='<a href="javascript:;" onclick="reply_review('+upid+','+toid+',this);" class="reviews publish" type="'+$(obj).attr('type')+'">发&nbsp;布</a>';
	        html+='</div>';
	        html+='<div class="clear"></div>';


	        $(obj).parents('.commentsright-bottom').after(html);        
	        hljs.initHighlightingOnLoad();
		        $("#inputrating").emoji({
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


		var url = "<?= geturl('myroom/review/reply')?>";

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
							<?php if (empty($iszjdlr)) { ?>
								html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							<?php }else{ ?>
								html+='<a href="javascript:void(0)" class="studentname"><?=$user['realname']?></a>';
            				<?php } ?>
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>';
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
							<?php if (empty($iszjdlr)) { ?>
								html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							<?php }else{ ?>
								html+='<a href="javascript:void(0)" class="studentname"><?=$user['realname']?></a>';
            				<?php } ?>
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
							+'<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							html+='<span class="comment">回复</span>'
							<?php if (empty($iszjdlr)) { ?>
								html+='<a href="http://sns.ebh.net/'+toid+'/main.html" target="_blank" class="studentname">'+toname+'</a>'
							<?php }else{ ?>
								html+='<a href="javascript:void(0)" class="studentname">'+toname+'</a>';
            				<?php } ?>
							html+=' <span class="totalscore">'+get_now_tiem()+'</span>'
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
							html+='<div class="replycommentliright">'
							<?php if (empty($iszjdlr)) { ?>
								html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
								html+='<span class="comment">回复</span>'
								html+='<a href="http://sns.ebh.net/'+toid+'/main.html" target="_blank" class="studentname">'+toname+'</a>'
							<?php }else{ ?>
								html+='<a href="javascript:void(0)" class="studentname"><?= $user['realname']?></a>'
								html+='<span class="comment">回复</span>'
								html+='<a href="javascript:void(0)" class="studentname">'+toname+'</a>'
							<?php } ?>
							html+=' <span class="totalscore">'+get_now_tiem()+'</span>'
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
			'url': '/myroom/mycourse/ajax_upvote.html',
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
			t.removeClass('thin');
			upvote = ordertype;
			$(t.siblings('span')).addClass('thin');

			var page = 1;
			var url = "/myroom/mycourse/getajaxpage.html";
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
        var cache = arguments[2]?1:0;
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
        $.post(url,{'cwid':cwid,'page':page,'flushcache':cache, 'upvote': upvote},function(data){
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
            		//评论的名字信息国土非国土有区分
					var zan = '';
            		<?php if($iszjdlr){?>
            		demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].realname+'</a>';
            			<?php if($isnewzjdlr){?>
						if (json[i].upvoted) {
							zan = '<a href="javascript:;" class="review_zan review_zaned">'+json[i].upvotenum+'</a>';
						} else {
							zan = '<a href="javascript:;" class="review_zan" onclick="votereview(this,'+json[i].logid+')">'+json[i].upvotenum+'</a>';
						}
						<?php }?>
					<?php }else{?>
					demohtml+='<a href="http://sns.ebh.net/'+json[i].uid+'/main.html" target="_blank" class="studentname" title="'+json[i].fromip+'('+json[i].ipaddress+')">'+json[i].username+'（'+json[i].realname+'）</a>';
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
            		if(json[i].uid != <?=$user['uid']?>){
            			demohtml+=zan+'<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].logid+','+json[i].uid+',this)" tips="回复给'+json[i].realname+'：" type="courseware_reply">回复</a>'
            		}
            		if(json[i].uid == <?=$user['uid']?>){
            			demohtml+=zan + '<a href="javascript:;" class="shield delatereviews" style="margin:0" onclick="del_comment('+json[i].logid+',this);">删除</a>';

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
            			//for(var second in json[i].children){
            			for (var second=0;second<json[i].children.length;second++){
            				if(second == (json[i].children.length-1)){
            					demohtml+='<li class="replycommentli last" id="comment_'+json[i].children[second].logid+'">';
            				}else{
            					demohtml+='<li class="replycommentli" id="comment_'+json[i].children[second].logid+'">';
            				}

            				demohtml+='<div class="replycommentliright">'
            				<?php if (empty($iszjdlr)) { ?>
            					demohtml+='<a href="http://sns.ebh.net/'+json[i].children[second].uid+'/main.html" target="_blank" class="studentname">'+json[i].children[second].username+'（'+json[i].children[second].realname+'）</a>'
            				<?php }else{ ?>
            					demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].children[second].realname+'</a>'
            				<?php } ?>
            				demohtml+='<span class="totalscore">'+get_time(json[i].children[second].dateline)+'</span>'
            				+'<div class="commentsright-center">'
            				+replace_em(json[i].children[second].subject)
            				+'</div>'
            				+'<div class="commentsright-bottom ">';
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
		            			//for(var third in json[i].children[second].children){
		            			for (var third=0;third<json[i].children[second].children.length;third++){
		            				if(third > 2){
		            					demohtml+='<li class="replycommentli1 first" style="display:none;" id="comment_'+json[i].children[second].children[third].logid+'" >';
		            				}else{
		            					demohtml+='<li class="replycommentli1 first" id="comment_'+json[i].children[second].children[third].logid+'" >';
		            				}
		            				demohtml+='<div class="replycommentliright">'
		            				<?php if (empty($iszjdlr)) { ?>
			            				demohtml+='<a href="http://sns.ebh.net/'+json[i].children[second].children[third].uid+'/main.html" target="_blank"  class="studentname">'+json[i].children[second].children[third].username+'（'+json[i].children[second].children[third].realname+'）</a>'
										demohtml+='<span class="comment">回复</span>'
			            				demohtml+='<a href="http://sns.ebh.net/'+json[i].children[second].children[third].toid+'/main.html" target="_blank" class="studentname">'+json[i].children[second].children[third].tousername+'（'+json[i].children[second].children[third].torealname+'）</a>'
									<?php }else{ ?>
										demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].children[second].children[third].realname+'</a>'
			            				demohtml+='<span class="comment">回复</span>'
			            				demohtml+='<a href="javascript:void(0)" class="studentname">'+json[i].children[second].children[third].torealname+'</a>'
		            				<?php } ?>
		            				+'<span class="totalscore">'+get_time(json[i].children[second].children[third].dateline)+'</span>'
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
<script defer="defer" type="text/javascript">

$(function(){
	$('#analysis').click(function(){
		$('#emoji_btn_1').hide();
		var cwid = <?=$course['cwid']?>;
		var url = '/myroom/mycourse/getanalysisajax.html'
		$.ajax({
			url:url,
			type:'post',
			data:{'cwid':cwid},
			dataType:'json',
			success:function(result){
				$('#chartcontainer1').highcharts({
					chart: {
						type: 'pie'
					},
					series:[{
						name:'百分比',
						data: [
							['已听课人数',Math.ceil(parseInt(result.studycount)/parseInt(result.userscount)*100)],
							['未听课人数',Math.ceil(100-parseInt(result.studycount)/parseInt(result.userscount)*100)]

						]
					}],

					title: {
						text: null
					},
					credits:{
						enabled:false
					}
				});
				$('#chartcontainer2').highcharts({
					chart: {
						type: 'column'
					},
					series:[
						{
							name:'课件时长',
							data: [
								{color:'#434348',y:parseInt(result.cwtime)},parseInt(result.ltimeave),parseInt(result.ltimemine)
							]
						}
					],
					xAxis: {
						categories: [
							'课件时长',
							'同学平均听课时长',
							'我的听课时长'
			            ]
			        },
					yAxis: {
						min: 0,
						title: {
							text: '时<br>长<br>︵<br>分<br>钟<br>︶',
							rotation:0,
							margin:40,
							align:'high'
						}
					},
					plotOptions: {
						column: {
							pointWidth: 85,
							dataLabels: {
								enabled: true
							}
						}
			        },
					title: {
						text: null
					},
					credits:{
						enabled:false
					},
					legend:{
						enabled:false
					}
				});
				$(".times").html("我的听课次数："+parseInt(result.times)+"次");
				$(".totaltime").html("我的听课时长："+Math.ceil(parseInt(result.ltimemine))+"分钟");
				$(".ord").html("排名：第"+parseInt(result.ord)+"名");
				showanalysis();
			}
		});
	});
});

var _xform = new xForm({
		domid:'rev',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});




	function counttime(){
		countdown --;
		if(countdown%60 == 0){
			$.ajax({
				url:'/time/gettime.html?d='+Math.random(),
				success:function(data){
					countdown = <?=$course['submitat']?> - data;
				}
			});
		}
		if(countdown <= 0){
			$('.video-play').show();
			$('.nostart').hide();
			clearInterval(intid);
			<?php if($course['live_type'] == 4){?>
				window.location.reload();
			<?php } ?>
			
			/*
			flash 加载的时候会自动播放视频 所以删除这一段
			setTimeout(function () {
			    <?php if(empty($is_mobile)){ ?>
				document.getElementById('flvcontrol')._play();
				<?php }else{?>
				document.getElementById('_video').play();
				<?php } ?>
			  }, 3000);*/


		}
		$('#countdown').html(secondToStr(countdown));
		
	}
	var timearr = new Object();
	timearr[1] = '秒';
	timearr[60] = '分';
	timearr[3600] = '小时';
	timearr[86400] = '天';

	keyarr = Array();
	keyarr[1] = 86400;
	keyarr[60] = 3600;
	keyarr[3600] = 60;
	keyarr[86400] = 1;
	function secondToStr(time){
		var str = '';
		$.each(timearr,function(key,value){
			key = keyarr[key];
			value = timearr[key];
			if (time >= key){
				str += Math.floor(time/key) +value;
			}
			time %= key;
		});
		return str;
	}

	function submitnote(cwid) {
	    var tips = "提交笔记";
	    var message = UE.getEditor('message').getContent();
	    var url = '<?= geturl('myroom/mycourse/addnote') ?>';
	    $.ajax({
	        url:url,
	        type:'post',
	        data:{'cwid':cwid,'message':message},
	        dataType:'text',
	        success:function(data){
	        if(data=='success'){
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>"+tips+"成功</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 1000);
						},
						onclose:function(){
							$("#notecontent").hide();
						}
					}).show();
	            }else{
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+tips+"失败</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 2000);
						}
					}).show();
	            }

	        }
	    });
	}
	$('.reviewtab,.asktab').click(function(){
		$('.workcurrent').removeClass('workcurrent');
		$(this).addClass('workcurrent');
		$('#emoji_btn_1').hide();
		$(this).addClass('workcurrent');
	});
	$('.asktab').click(function(){
		$('#emoji_btn_1').hide();
	});
	$('.reviewtab').click(function(){
		$('#emoji_btn_1').show();
	});
	var askloaded = false;
	var moreask = false;
	function showask(){
		$('#reviewdiv').hide();
		$('#cmdiv').hide();
		$('#analysisdiv').hide();
		$('#askdiv').show();
		//getAskListAjax();
	}
	function showanalysis(){
		$('#reviewdiv').hide();
		$('#cmdiv').hide();
		$('#moreask').hide();
		$('#askdiv').hide();
		$('#analysisdiv').show();
	}



	//////////////////////linkask定时器处理 eker-huang/////////////////////////////////

	// 每分钟获取一次问题信息问题
	function getAskListAjax(){
		var cwid = <?= $course['cwid'] ?>;
		$.ajax({
			url : '/myroom/mycourse/linkask.html',
			type : 'post',
			data : {cwid:cwid},
			success : function(data){
				result = eval('('+data+')');
				if(result['list'].length>0){
					$('#noask').hide();
					$('.tweytr table').empty();
					$("#relativeask").html(result['count']);
					$.each(result['list'],function(idx,obj){
						$('.tweytr table').append(formatasklist(obj));
					});
					if(result['count']>10){
						moreask = true;
						if(!$("#commentTag").hasClass('workcurrent')){
							$('#moreask').show();
						}
					}
				}
			}
		});

		setTimeout(getAskListAjax,60000);
	}
	//setTimeout(getAskListAjax,60000);
	<?php if($course['islive'] != 1){ ?>
    $(function(){
    	getAskListAjax();
    })
    <?php } ?>
	//////////////////////linkask定时器处理 eker-huang///////////////////////////////////




	function showreview(){
		$('#askdiv').hide();
		$('#moreask').hide();
		$('#analysisdiv').hide();
		$('#cmdiv').show();
		$('#reviewdiv').show();
	}

	function formatasklist(list){

		var name = '';
		if(list.realname == '')
			name = list.username;
		else
			name = list.realname;

		var html = '<tr>';
		html+= '	<td style="border-top:none;padding: 6px 10px;">';
		html+= '	<div style="float:left;margin-right:15px;"><a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/all.html?aq='+name+'"><img title="'+name+'" src="'+list.face+'" style="width:40px; height:40px; border-radius:20px;"/></a></div>';
		html+= '	<div style="float:left;width:840px;font-family:Microsoft YaHei;">';
		html+= '		<p style="width:720px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">';
		if(list.reward>0){
		html+= '<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏'+list.reward+'积分">悬赏'+list.reward+'<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/></span>&nbsp';
		}
		html+= '		<a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/'+list.qid+'.html" style="color:#777;font-weight:bold;">';
		if(list.status == 1){
		html+= '		<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>';
		}
		html+= shortstr(list.title);
		html+= '		</a>';
		html+= '		</p>';
		html+= '	<p class="dashu">回答数<br/><span style="">'+list.answercount+'</span></p>';
		html+= '		<div style="float:left;width:730px;">';
		html+= '	<span style="width:180px;float:left;">'+getformatdate(list.dateline)+'</span>';
		html+= '	<span class="huirenw" style="width:150px;float:left;"><a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/all.html?aq='+name+'">'+name+'</a></span>';
		html+= '	<span class="ketek" style="width:330px"><a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/all.html?fid='+list.folderid+'">'+list.foldername+'</a></span>';
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
	var zanflag = true;
	function addzan(){
		if(zanflag === false)
			return false;
		zanflag = false;
		var url = '<?= geturl('myroom/mycourse/addzan') ?>';
		var cwid = <?= $course['cwid'] ?>;
		var count = $(".tingdian").html();
		count = parseInt(count) + 1;
		$.ajax({
	        url:url,
	        data:{cwid:cwid},
	        type:'post',
	        dataType:'json',
	        success:function(data){
				zanflag = true;
	        	if(data.status){
					$(".tingdian").html(count);
					$(".tingdian").addClass('onhover');
	        	}else{
	        		top.dialog({
						title: '提示信息',
						content: '您已经点赞过了！',
						width:370,
						okValue: '确定',
						cancel: false,
						ok: function () {
						}
					}).showModal();
					return false;
	        	}
	        }
	    });
	}
    //-->
    </script>
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


var $inp = $('.inputmoney');
$inp.keypress(function (e) {
    var key = e.which;
    if (key == 13) {
		var payway = $('.paywechat:checked').val();
		if(payway == 'wechat'){
			paybywechat();
		}
		if(payway == 'alipay'){
			paybyali();
		}
    }
});
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
if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}
var timerpay;
/*打赏点赞*/
function rewardfa(){
	randomMoney();
	var d=dialog({
		id:"rewardpraise",
		title:"赞赏",
		content:document.getElementById("rewardmain"),
		padding: 20,
		height:440,
		onclose:function(){
			$('.inputmoney').val('0.00');
			$("#wechat").trigger('click');
		}
	});
	d.showModal();
	$(document).keypress(function(e){
		if(d.open&&e.keyCode == 13){
			return false;
		}
	})

}
//随机生成打赏数额
function randomMoney(){
	var moneyarr = new Array('0.66', '1.66', '5.20', '6.66', '8.88', '18.88');
	var index = Math.floor((Math.random()*moneyarr.length));
	var money = $('.inputmoney').val();
	if(money == moneyarr[index]){
		randomMoney();
		return false;
	}
	$('.inputmoney').val(moneyarr[index]);
	var checkboxid = $(".paylist").find('input:checked').attr('id');
	if(checkboxid == 'wechat'){
		paybywechat();
	}else if(checkboxid == 'alipay'){
		paybyali();
	}else{
		$('.ljzf').show();
	}
}
//加倍处理
function doubled(){
	var money = $('.inputmoney').val();
	moneydouble = money*2;
	if(moneydouble > 500){
		$('.inputmoney').val('0.00');
		$(".ljzf").hide();
		$(".wallete").hide();
		$(".alipay").hide();
		$(".wechatpay").hide();
		top.dialog({
			title: '提示信息',
			content: '打赏不能超过500元',
			width:370,
			okValue: '确定',
			cancel: false,
			ok: function () {
			}
		}).showModal();
		return false;
	}
	$('.inputmoney').val(moneydouble);
	var checkboxid = $(".paylist").find('input:checked').attr('id');
	if(checkboxid == 'wechat'){
		paybywechat();
	}else if(checkboxid == 'alipay'){
		paybyali();
	}else{
		$('.ljzf').show();
	}
}
//检验是否选中钱包付款
function checkwallet(){
	return $("#wallet").is(":checked");
}
//限制输入的金额为数字，且最多有两位小数
function Num(obj){
obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
obj.value = obj.value.replace(/^[0]{2,}/g,'0');
if(obj.value >500){
	obj.value = 500;
}
if(obj.value < 0.1 && obj.value >0){
	obj.value = 0.10;
}
}
//使用钱包付款
function paybywallet(){
	clearInterval(timerpay);
	//使用钱包进行付款
		//检查钱包中的钱是否足够支付
		$(".wechatpay").hide();
		$(".alipay").hide();
		var money = $('.inputmoney').val();
		if(money == '0.00'){
			$(".wallete").show();
			$(".yebz").hide();
			return false;
		}else if(money > 500){
			$('.inputmoney').val('0.00');
			$(".ljzf").hide();
			$(".wallete").hide();
			$(".alipay").hide();
			$(".wechatpay").hide();
			top.dialog({
				title: '提示信息',
				content: '打赏不能超过500元',
				width:370,
				okValue: '确定',
				cancel: false,
				ok: function () {
				}
			}).showModal();
			return false;
		}
		setTimeout(function(){
			var url = '/myroom/rewards/checkWallet.html';
		$.ajax({
	        url:url,
	        data:{money:money},
	        type:'post',
	        dataType:'json',
	        success:function(data){
	        	if(data.status == 1){//钱足够
	        		$(".ljzf").show();
	        		$(".wallete").show();
	        		$(".balance b").html(data.balance);
	        		$(".yebz").hide();
	        		$(".wechatpay").hide();
					$(".alipay").hide();
	        	}else if(data.status == -2){//钱不够
	        		$(".wallete").hide();
	        		$(".yebz").show();
	        		$(".wechatpay").hide();
					$(".alipay").hide();
	        	}else{
	        		$(".wechatpay").hide();
					$(".alipay").hide();
	        		$(".wallete").hide();
	        		$(".yebz").hide();
	        		top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+data.message+"</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 1000);
						}
					}).show();
	        	}
	        }
	    });
	},100);

}
//使用钱包支付
$(".ljzf").on('click',function(){

	var money = $('.inputmoney').val();
	var url = '/myroom/rewards/rewardByWallet.html';
	var teacherid = <?php echo $course['uid'];?>;
	var cwid = <?php echo $course['cwid'];?>;
	$.ajax({
	        url:url,
	        data:{money:money,teacherid:teacherid,cwid:cwid},
	        type:'post',
	        dataType:'json',
	        success:function(data){
	        	if(data.status == 1){
	        		var moneyhave = $(".balance b").html();
	        		var moneyleft = moneyhave - money;
	        		$(".balance b").html(moneyleft);
	        		top.dialog({
	        			skin:"ui-dialog2-tip",
						title: '',
						content: "<div class='TPic'></div><p>赞赏成功</p>",
						width:200,
						cancel: false,
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 1000);
						}
					}).showModal();
					$('#rewarda_count').html(parseInt($('#rewarda_count').html())+1)
					return false;
	        	}else{
	        		top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+data.message+"</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 1000);
						}
					}).show();
					return false;
	        	}
	        }
	    });
	if (self.frameElement && self.frameElement.tagName == "IFRAME") {
        dialog.get("rewardpraise").close();
	}else{
		top.dialog.get("rewardpraise").close();
	}

});

//检验打赏金额为空 或者0的时候
$(".inputmoney").on('blur',function(){
	var zeroarr = new Array('',undefined,'0','0.','0.0','0.00');
	var money = $('.inputmoney').val();
	if(zeroarr.indexOf(money) != -1){
		$('.inputmoney').val('0.00');
		$(".ljzf").hide();
		$(".wallete").hide();
		$(".alipay").hide();
		$(".wechatpay").hide();
	} else if(money > 500){
		$('.inputmoney').val('0.00');
		$(".ljzf").hide();
		$(".wallete").hide();
		$(".alipay").hide();
		$(".wechatpay").hide();
		top.dialog({
			title: '提示信息',
			content: '打赏不能超过500元',
			width:370,
			okValue: '确定',
			cancel: false,
			ok: function () {
			}
		}).showModal();
		return false;
	}
	else{
		setTimeout("reflashqr()",100);



	}
});
function reflashqr(){
	var checkboxid = $(".paylist").find('input:checked').attr('id');
	if(checkboxid == 'wechat'){
			paybywechat();
		}else if(checkboxid == 'alipay'){
			paybyali();
		}else{
			$('.ljzf').show();
		}
}
//点击支付宝支付
function paybyali(){
	clearInterval(timerpay);
	$(".wallete").hide();
	$(".yebz").hide();
	$(".wechatpay").hide();
	$(".loading").show();
	var money = $('.inputmoney').val();
	var zeroarr = new Array('',undefined,'0','0.','0.0','0.00');
	if(zeroarr.indexOf(money) != -1){
		return false;
	}
	if(money >500){
		$('.inputmoney').val('0.00');
		$(".ljzf").hide();
		$(".wallete").hide();
		$(".alipay").hide();
		$(".wechatpay").hide();
		top.dialog({
			title: '提示信息',
			content: '打赏不能超过500元',
			width:370,
			okValue: '确定',
			cancel: false,
			ok: function () {
			}
		}).showModal();
		return false;
	}
	setTimeout(function(){
		var teacherid = <?php echo $course['uid'];?>;
	var cwid = <?php echo $course['cwid'];?>;
	var url = '/myroom/rewards/alipayOrder.html';
	$.ajax({
	        url:url,
	        data:{money:money,teacherid:teacherid,cwid:cwid},
	        type:'post',
	        dataType:'json',
	        success:function(data){
	        	$(".wallete").hide();
				$(".yebz").hide();
				$(".wechatpay").hide();
	        	if(data.status ==1){
	        		var url = '/myroom/rewards/alipayQRDate.html?ordernum='+data.ordernum+'&ordername='+data.ordername+'&money='+data.money;
					$("#alipaywindow").attr('src',url);
					$('#alipayqrcode iframe').attr('src',url + '&w=245');
					$(".alipay").show();
					var oFrm = document.getElementById('alipaywindow');
					oFrm.onload = oFrm.onreadystatechange = function() {
					     if (this.readyState && this.readyState != 'complete') return;
					     else {

					     	$('#alipaywindow').hover(function(){

					     		$('#alipayqrcode').show();
					     	},function(){
					     		$('#alipayqrcode').hide();
					     	})
					        $(".loading").hide();
					     }
					}
					clearInterval(timerpay);
					timerpay = setInterval(function(){
					$.ajax({
						url:"/myroom/rewards/getpaystatus.html",
						type:'POST',
						data:{ordernum:data.ordernum},
						dataType:'JSON',
						success:function(json){
								if(json.code){
									clearInterval(timerpay);
									if (self.frameElement && self.frameElement.tagName == "IFRAME") {
									        dialog.get("rewardpraise").close();
										}else{
											top.dialog.get("rewardpraise").close();
										}
									top.dialog({
					        			skin:"ui-dialog2-tip",
										title: '',
										content: "<div class='TPic'></div><p>赞赏成功</p>",
										width:200,
										cancel: false,
										onshow:function(){
											var that=this;
											setTimeout(function () {
											that.close().remove();
											}, 1000);
										}
									}).showModal();
									$('#rewarda_count').html(parseInt($('#rewarda_count').html())+1)
									return false;
								}
							}
						});
					},2000);

	        	}else{
	        		top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+data.message+"</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 1000);
						}
					}).show();
					return false;
	        	}
	        }
	    });
},100);
}
//使用微信支付
function paybywechat(){
	clearInterval(timerpay);
	$(".wallete").hide();
	$(".yebz").hide();
	$(".alipay").hide();
	$(".loading").show();
	var zeroarr = new Array('',undefined,'0','0.','0.0','0.00');
	var money = $('.inputmoney').val();
	if(zeroarr.indexOf(money) != -1){
		return false;
	}
	if(money >500){
		$('.inputmoney').val('0.00');
		$(".ljzf").hide();
		$(".wallete").hide();
		$(".alipay").hide();
		$(".wechatpay").hide();
		top.dialog({
			title: '提示信息',
			content: '打赏不能超过500元',
			width:370,
			okValue: '确定',
			cancel: false,
			ok: function () {
			}
		}).showModal();
		return false;
	}
	setTimeout(function(){
		var teacherid = <?php echo $course['uid'];?>;
	var cwid = <?php echo $course['cwid'];?>;
	var url = '/myroom/rewards/wechatOrder.html';
	$.ajax({
	        url:url,
	        data:{money:money,teacherid:teacherid,cwid:cwid},
	        type:'post',
	        dataType:'json',
	        success:function(data){
	        	$(".wallete").hide();
				$(".yebz").hide();
				$(".alipay").hide();
	        	if(data.status ==1){
	        		var url = '/myroom/rewards/wxpayQRcode.html?ordernum='+data.ordernum+'&ordername='+data.ordername+'&money='+data.money;
					$("#wechatwindow").attr('src',url);
					$("#wechatwindow_big").attr('src',url);
					$(".wechatpay").show();
					var oFrm = document.getElementById('wechatwindow');
					oFrm.onload = oFrm.onreadystatechange = function() {
					     if (this.readyState && this.readyState != 'complete') return;
					     else {
					     	var img = $(document.getElementById('wechatwindow').contentWindow.document.body).find('img');
					     	$(img[0]).hover(function(){

					     		$('#wxqrcode>img').attr('src',$(img[0]).attr('src'));
					     		$('#wxqrcode').show();

					     	},function(){
					     		$('#wxqrcode>img').attr('src','')
					     		$('#wxqrcode').hide();
					     	})
					         $(".loading").hide();
					     }
					}
					clearInterval(timerpay);
					timerpay = setInterval(function(){
					$.ajax({
						url:"/myroom/rewards/getpaystatus.html",
						type:'POST',
						data:{ordernum:data.ordernum},
						dataType:'JSON',
						success:function(json){
								if(json.code){
									clearInterval(timerpay);
									if (self.frameElement && self.frameElement.tagName == "IFRAME") {
								        dialog.get("rewardpraise").close();
									}else{
										top.dialog.get("rewardpraise").close();
									}
									top.dialog({
					        			skin:"ui-dialog2-tip",
										title: '',
										content: "<div class='TPic'></div><p>赞赏成功</p>",
										width:200,
										cancel: false,
										onshow:function(){
											var that=this;
											setTimeout(function () {
											that.close().remove();
											}, 1000);
										}
									}).showModal();
									$('#rewarda_count').html(parseInt($('#rewarda_count').html())+1)
									return false;
								}
							}
						});
					},2000);
					//top.dialog.get("rewardpraise").close();
	        	}else{
	        		top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+data.message+"</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
							that.close().remove();
							}, 1000);
						}
					}).show();
					return false;
	        	}
	        }
	    });
},100);


}

	var curtime = -1;
	var norecord = 0;
	<?php if($roominfo['domain'] == 'cszx') {?>
		norecord = 1;
	<?php } ?>
	$(function(){
		getcurtime();
	})
	function getcurtime(){
		if(typeof(norecord) != "undefined" && norecord == 1) {
			return 0;
		}
		$.ajax({
			url:'/myroom/mycourse/getcurtimeajax.html',
			type:'post',
			data:{uid:<?=$user['uid']?>,'cwid':<?=$course['cwid']?>},
			async:false,
			success:function(data){
				curtime = data;
			}
		})
	}
	function returncurtime(){

		if(typeof(norecord) != "undefined" && norecord == 1) {
			return 0;
		}
		if(curtime == -1)
			getcurtime();

		return curtime;
	}


	/***************************************检查课件转码状态 start**********************************************************/
	//获取课件转码状态
	var i = 1;//...计数器从第一个.开始
	var cwid = parseInt($('#cwid').val());
	var ism3u8 = parseInt($('#ism3u8').val());
	var cwtype = $('#cwtype').val();
	var numTimer = null;
	var ckTimer = null;
	if(ism3u8!=1 && cwtype=='flv'){
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
					location.href = window.location.href;
					//location.reload();
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
		for(j=0;j<i;j++){
			tmp += '.';
		}
		$('#randnums').html(tmp);
		i++;
		if(i>3) i=0;
	}
	/*************************************检查课件转码状态 end************************************************************/

</script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
	</div>
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>

<style type="text/css">
.waigme {
	width:550px;
	height:230px;
	background-color:gray;
	border-radius:10px;
	display:none;
}

.rigsize .tishitit {
	font-size:14px;
	color:#d31124;
	font-weight:bold;
	line-height:30px;
}
.rigsize .phuilin {
	line-height:2;
	color:#6f6f6f;
}


.xkcg1s{
	width:412px;
	height:175px;
	font-family:微软雅黑;
	float:left;
}
.mycjkclb1s{
	font-size:16px;
	color:#333;
	text-align:center;
	margin-top:20px;
}
.xkcg1s .p1s{
	color:#999;
	font-size:12px;
	text-align:center;
	margin:0;
	padding-top:10px;
}
a.jxxk1s {
    background: #5e8cf1;
    border: 1px solid #5e8cf1;
    border-radius: 3px;
    color: #fff;
    display: block;
	margin:0 auto;
    font-size: 14px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    width: 110px;
	text-decoration:none;
}
.xuanbtn2s{
	margin-top:20px;
}
</style>



<script type="text/javascript">

function openonline() {
	// if($("#agreement").is(':checked') !=true) {
		// alert("请先阅读并同意《e板会用户支付协议》。");
		// return;
	// }
	var url = "<?= empty($checkurl) ? 'http://'.$roominfo['domain'].'.ebanhui.com/classactive.html' : $checkurl ?>";
	document.location.href = url;
}
function closeWindows() {
         var browserName = navigator.appName;
         var browserVer = parseInt(navigator.appVersion);
         if(browserName == "Microsoft Internet Explorer"){
             var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
             if (ie7)
             {
               window.open('','_parent','');
               window.close();
             }
            else
             {
               this.focus();
               self.opener = this;
               self.close();
             }
        }else{
            try{
                this.focus();
                self.opener = this;
                self.close();
            }
            catch(e){

            }

            try{
                window.open('','_self','');
                window.close();
            }
            catch(e){

            }
        }
    }


</script>
<?php } ?>