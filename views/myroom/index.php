<?php $this->display('myroom/room_header');
 if($this->input->cookie('refer')) {
	$mainurl = urldecode($this->input->cookie('refer'));
 }
else {
	if($roominfo['isschool'] == 2){
		$mainurl = geturl('myroom/setting');
	}else{
		$mainurl = geturl('myroom/mysetting');
	}
	if(!empty($showfirst)){
		if(!empty($modulelist[0]))
			$mainurl = geturl('myroom/'.$modulelist[0]['code']);
		else
			$mainurl = geturl('myroom/mysetting');
	}
	if(!empty($modulelist[0]) && $modulelist[0]['code'] == 'stusubject'){
		if($roominfo['isschool'] == 7)
			$mainurl = geturl('myroom/stusubject/allcourse');
		else
			$mainurl = geturl('myroom/stusubject/mycourse');
	}

	if($roominfo['crid'] == 10631){
		$mainurl = geturl('myroom/stusubject/allcourse');
	}
	// $mainurl = ($room['isschool'] == 3 || $room['isschool'] == 6) ? geturl('myroom/mysetting') : geturl('myroom/setting');
	// if($room['domain'] == 'sxyz' || $room['domain'] =='szzhzx')
	// if($room['isschool'] == 7)
		// $mainurl = geturl('myroom/stusubject/allcourse');
}
$this->input->setCookie('refer','');
 ?>
<!--[if lte IE 6]>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
  DD_belatedPNG.fix('.menubox ul li i,.bottom,.cservice img,.sukan .xinke span,.sukan .zuoye span,.sukan .zhibo span,.sukan .jieda span');
</script>
<![endif]-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/feedback.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css"/>
	<script type="text/javascript">
		var resetmain = function(){
			var mainFrame = document.getElementById("mainFrame");
			var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+1;
			iframeHeight = iframeHeight<830?830:iframeHeight;
			$(mainFrame).height(iframeHeight);
		}
		var tofolder = function(folderid){
			var mainFrame = document.getElementById("mainFrame");
			var theurl = '<!--{eval echo geturl("myroom/coursewarelist-1-0-0-".$crid."-'+folderid+'-find")}-->';
			mainFrame.src=theurl;
			//.tofolder(folderid);
		}
		function showimage(selector) {
			$(selector,document.getElementById('mainFrame').contentWindow.document).lightBox();
		}
	</script>

<?php if (($roominfo['isschool'] == 6 && $check != 1) || ($roominfo['isschool'] == 7) ) { ?>
	<style type="text/css">
.waigme {
	width:550px;
	height:290px;
	background-color:gray;
	border-radius:10px;
	display:none;
}
.nelame {
	width:530px;
	height:306px;
	margin:10px;
	float:left;
	display:inline;
	border: 8px solid rgba(255, 255, 255, 0.2);
	border-radius: 8px;
	box-shadow: 0 0 20px #333333;
	opacity: 1;
}
.nelame .leficos {
	width:125px;
	height:265px;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0104.jpg) no-repeat 30px 32px;
}
.nelame .rigsize {
	width:375px;
	float:left;
	margin-top:25px;
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
.nelame a.kaitongbtn {
	display:block;
	width:147px;
	height:50px;
	line-height:50px;
	background-color:#ff9c00;
	color:#fff;
	text-decoration:none;
	text-align:center;
	font-size:20px;
	float:left;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-top:20px;
	border-radius:5px;
}
.nelame a.guanbibtn {
	float:left;
	color:#939393;
	font-size:14px;
	margin:40px 0 0 12px;
}
</style>
<script type="text/javascript">
var iname = "";
var iurl = "";
function setiinfo(siname,siurl) {
	if(siname != undefined)
		iname = siname;
	if(siurl != undefined)
		iurl = siurl;
	if(iname != "") {
		$(".tishitit").html("对不起，您还未开通 " + iname + " 或服务已到期。");
	}
}
function openonline() {
	if($("#agreement").is(':checked') !=true) {
		alert("请先阅读并同意《e板会用户支付协议》。");
		return;
	}
	var url = "/myroom/stusubject/allcourse.html#classactive";
	if(iurl != "")
		url = iurl;
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
<div class="nelame" style="display:none;">
	<div style="width:530px;height:300px;background:#fff;">
		<div class="leficos">
		</div>
		<div class="rigsize">
		<h2 class="tishitit">对不起，您还未开通学习和作业功能或服务已到期。</h2>
		<p style="font-weight:bold;">开通后您可以在学习课程和我的作业里进行在线学习和作业。</p>
		<p class="phuilin">在云教学网校，您可以随时随地在线学习、预习新课，复习旧知、记录和向老师提交笔记、在线做作业、在错题集里巩固错题、在线答疑、查看学习表、与老师，同学互动交流等。</p>
			<div class="czxy" style="padding-left:0px;padding-top:10px;">
				<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked" />
				<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="<?= geturl('agreement/payment') ?>" target="_blank" style="color:#00AEE7;">e板会用户支付协议</a>》
				</label>
			 </div>
		</div>

		<a href="javascript:openonline();" class="kaitongbtn">在线开通</a>
		<a href="<?= geturl('myroom') ?>" class="guanbibtn">返回首页</a>
	</div>
</div>
<?php } ?>
        <?php if(!isApp() && empty($nophoto) && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7)) { ?>
	<style type="text/css">
.waigmes {
	width:355px;
	height:190px;
	background-color:gray;
	opacity: .80;
	filter:Alpha(Opacity=80);
	border-radius:10px;
}
.nelames {
	width:335px;
	height:170px;
	background-color:#FFFFFF;
	margin:10px;
	float:left;
	display:inline;
}
.nelames .leficoss {
	width:135px;
	height:128px;
	float:left;
	margin:10px 0 0 10px;
}
.nelames .rigsizes{
	width:170px;
	float:left;
	margin-top:10px;
}
.rigsizes .tishitits {
	font-size:14px;
	color:#212121;
	font-weight:bold;
	line-height:22px;
}
.rigsizes .phuilin {
	line-height:1.8;
	color:#6f6f6f;
}
.czxy input {
    vertical-align: middle;
}
.toptites {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/titbgt.jpg) repeat-x;
	height:28px;
	line-height:28px;
	font-size:14px;
	font-weight:bold;
	padding-left:5px;
	position:relative;
	width:330px;
	color:#212121;
}
.toptites a.guanbtn {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/guanbibtn.jpg) no-repeat;
	display:block;
	width:24px;
	height:24px;
	right:2px;
	top:2px;
	position:absolute;
}
.rigsizes a.chuanicobtn {
	display:block;
	width:152px;
	color:#212121;
	height:30px;
	line-height:30px;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/chuanbtnbg.jpg) repeat-x;
	font-size:14px;
	text-align:center;
	text-decoration:none;
}
.tQRCode{
	display:none;
	left: -162px;
	position: absolute;
	top: -82px;
	padding-right:19px;
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/wxxx2.png) right bottom no-repeat;
}
.tQRCode img{background-color:#fff;}
</style>
<script type="text/javascript">
var hastip = 0;
function phototip(div) {
	if(hastip == 0) {
		showDivModel(div);
	}
	hastip = 1;
}
function closeDivModel(div) {
	$('.logDialog').remove();
	$('.waigmes').remove();
}

$(function(){
	$(".guanbtn").click(function(){
		closeDivModel(".waigmes");
	});
	$("#phptotip").click(function(){
		if($("#phptotip").is(':checked')) {
			setCookie('ebh_nophoto',1,360);
		} else {
			setCookie('ebh_nophoto',0,360);
		}
	});
});
</script>

<?php
	if($user['sex'] == 1)
		$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
	else
		$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';

?>
<div class="waigmes" style="display:none">
<div class="nelames">
<div class="toptites">系统消息<a href="javascript:void(0);" class="guanbtn"></a></div>
<div class="leficoss">
<a href="<?= geturl('/home/profile/avatar.html') ?>" title="上传我的头像" target="mainFrame" onclick="closeDivModel('.waigmes');"><img src="<?= $defaulturl ?>" /></a>
</div>
<div class="rigsizes">
<h2 class="tishitit"><?= empty($user['realname']) ? $user['username'] : $user['realname'] ?>您好：</h2>
<p class="phuilin">系统建议你修改自己的头像，<br />以便老师、同学更好的找到你。</p>
<a href="<?= geturl('/home/profile/avatar.html')?>" target="mainFrame" class="chuanicobtn" onclick="closeDivModel('.waigmes');">上传我的头像</a>

<div class="czxy" style="padding-left:0px;padding-top:10px;">
<input id="phptotip" type="checkbox" value="1" name="phptotip">
<label for="phptotip" style="font-weight:bold;">
下次不再提示
</label>
</div>
</div>
</div>
</div>
        <?php } ?>
	<div class="wrap">
		<div class="cmain clearfix">
            <!--意见反馈start-->
			<?php
			$qcode_lib = Ebh::app()->lib('Qcode');
			$qcode = $qcode_lib->get_qcode();
			?>
            <div style="width:100%;position:fixed;top:55%;display: none" id="ujdkgj" >
                <ul class="toolbarx">
                    <li class="tool tFeedback"><a style="display:none" onclick="feedback()">意见反馈</a></li>
					<li class="tool tWechat"><a style="display:none">微信学习</a><div class="tQRCode"><img src="<?=htmlspecialchars($qcode, ENT_COMPAT)?>" width="141" height="141" /></div></li>
                </ul>
            </div>
            <!--意见反馈end-->
			<?php $this->display('myroom/room_left'); ?>
			<div class="cright">
						<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="<?= $mainurl ?>"></iframe>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<!-- <script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script> -->
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>
<script>

/**
*播放视频
*/

function playflv_top(source,cwid,title,isfree,num,height,width,hasbtn,callback){
	var url = source+"attach.html?examcwid="+cwid;
	url = encodeURIComponent(url);
	if(hasbtn == undefined)
		hasbtn = 0;
	var vars = {
		source: url,
		type: "video",
		streamtype: "file",
		server: "",
		duration: "52",
		poster: "",
		autostart: "false",
		logo: "",
		logoposition: "top left",
		logoalpha: "30",
		logowidth: "130",
		logolink: "http://www.ebanhui.com",
		hardwarescaling: "false",
		darkcolor: "000000",
		brightcolor: "4c4c4c",
		controlcolor: "FFFFFF",
		hovercolor: "67A8C1",
		controltype: 1,
		classover: hasbtn
	};
	H.create(new P({
		title:'视频播放',
		easy:true,
		flash:HTools.pFlash({'id':'playflv','uri':"http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf",'vars':vars})
	}),'common').exec('show');
}

//播放课件或者下载附件
function showplayDialog(source,cwid){
	if(typeof courseObj == "undefined"){
		courseObj = new Course();
	}
	if(!source || !cwid){
		return false;
	}
	courseObj.userplay(source,cwid);return false;
}

</script>
<?php
$this->display('myroom/room_footer');
?>