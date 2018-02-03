<?php $this->display('troomv2/room_header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/feedback.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/bubbletip/bubbletip.js"></script>

<?php
$uername = empty($user['realname']) ? $user['username'] : $user['realname'] ;
$this->assign("uername",$uername);
//获取优惠码
$mycoupon = $this->model('coupons')->getOne(array('uid'=>$user['uid']));
$this->assign("mycoupon",$mycoupon);
if ($this->input->cookie('refer')) {
	$refer = urldecode($this->input->cookie('refer'));
	$curhost = getdomain();
	if(substr($refer,0,7) != 'http://' || substr($refer,0,strlen($curhost)) == $curhost) {	//非相同域名则止加载默认页面,如当前域名为 xiaoxue.ebh.net 而需要加载的为rqzx.ebh.net 则不进行加载 避免数据错乱
		$idefurl = $refer;
	}
}
$refurl = $this->input->get('url');
if(!empty($refurl))
    $idefurl = $refurl;
$this->input->setCookie('refer','');
?>
<style>
.fxz2{
    height: 54px;
    line-height: 54px;
    padding-left: 10px;
}
a.hdjhk {
    color: #00aaf0 !important;
    font-family: Microsoft Yahei;
    font-size: 12px;
}
	.ui-dialog-footer{
		padding:20px;
	}
.ui-dialog-footer .ui-dialog-button{
	text-align:center;
	float:inherit !important;
}
.rigpxiang .mypurses {
	top:22px;
}
	#jquery-overlay{z-index:10000}
	#jquery-lightbox{z-index:10001}
.ui-dialog-header{
	border-radius: 14px 14px 0 0;
}
.ui-dialog-title{
	font-size: 16px;
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

object{
	visibility:hidden;
}


div.classes-panel{text-align:left;}
div.choosed{border-bottom:1px dashed #999;padding:20px 0;height:160px;overflow-y:auto;text-align:left;}
		div.choosed span{
		font-size:14px;
			margin-right: 5px;
			margin-bottom: 5px;
 padding:2px 5px;

 border-radius:4px;
 box-sizing:border-box;
 border:1px solid transparent;
 background-color:rgba(32,160,255,.1);
 border-color:rgba(32,160,255,.2);
 color:#20a0ff;
display:inline-block;
}
div.choosed span i{border-radius: 50%;
text-align: center;
position: relative;
cursor: pointer;
transform: scale(.75);
height: 18px;
width: 18px;
line-height: 18px;
vertical-align: middle;
top: -1px;
right: -2px;font-family: element-icons !important;
font-style: normal;
font-weight: 400;
font-variant: normal;
text-transform: none;
display: inline-block;
}

div.choosed span i:hover {
    background-color: #20a0ff;
    color: #fff;
}
.search {padding:10px 0;line-height:30px;text-align:left;}
.search label{text-align: right;
vertical-align: middle;
font-size: 14px;
color: #48576a;
line-height: 1;
box-sizing: border-box;}
.search input{   vertical-align: middle;
    border: 1px solid #39f;height: 30px;-webkit-appearance: none;
-moz-appearance: none;
appearance: none;
background-color: #fff;
margin:0 10px;
background-image: none;
border-radius: 4px;
border: 1px solid #bfcbd9;
box-sizing: border-box;
color: #1f2d3d;
font-size: inherit;
height: 26px;
line-height: 1;
outline: 0;
padding: 3px 10px;
transition: border-color .2s cubic-bezier(.645,.045,.355,1);
display:inline-block;
}
.search input::placeholder {
    color: #97a8be;
}
.search input:hover{border-color: #8391a5;box-shadow: 0 0 3px 2px #39f;}
.search button::-moz-focus-inner{
border:0 none;
}
.search button{vertical-align: middle;display: inline-block;
line-height: 1;
white-space: nowrap;
cursor: pointer;
background: #fff;
border: 1px solid #c4c4c4;
    border-top-color: rgb(196, 196, 196);
    border-right-color: rgb(196, 196, 196);
    border-bottom-color: rgb(196, 196, 196);
    border-left-color: rgb(196, 196, 196);
color: #1f2d3d;
padding: 5px 15px;
border-radius: 4px;
}

.search button:focus, div.classes-panel .search button:hover {
    color: #20a0ff;
    border-color: #20a0ff;
}
div.candidate {padding:10px 0;height:300px;overflow-y:auto;text-align:left;}
div.candidate label{display:inline-block;margin-bottom:10px;margin-right:15px;}
div.candidate label span{padding:5px;}
</style>


<div class="wrap" >
	<div style="position:relative; width:980px; margin:0 auto; height:0px;">
		<div class="titles fl">
			<span class="spans" style="left:130px; top:-50px; *top:-40px;"><?=$room['crname']?></span>
		</div>
	</div>
	<div class="cmain">
    	<div class="cmain_top mt10">
        	<div class="cmain_top_l fl" style="z-index:2;position:relative;width:297px;">
        	<?php
	            $roominfo = Ebh::app()->room->getcurroom();
		        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
		        if(!empty($roominfo['crid'])){
		        	$appsetting = Ebh::app()->getConfig()->load('othersetting');
			        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
			        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
			        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
			        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
		        }
    		?>
        		<?php if($roominfo['domain'] != 'bndx' && (!$is_zjdlr)){ ?>
            	<div class="xiutgt fr mt10"><a class="cla" href="/homev2/score/description.html" ><span style="padding-left:15px;color:#fff;"><?=$clinfo['title']?></span></a></div>
                <?php }else{ ?>
                <div style="margin-top:30px"></div>
                <?php } ?>
                <div class="clear"></div>
				<?php
					if($user['sex'] == 1)
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					else
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
						$face = empty($user['face']) ? $defaulturl:$user['face'];
						$face = str_replace('.jpg','_78_78.jpg',$face);
				?>
                <div class="gerenxinxi">
                	<div class="touxiang fl"><a class="listbr" href="/homev2/profile/avatar.html" ></a><img src="<?=$face?>" height="78" width="78" /></div>
                    <div class="rigpxiang ml10 fl" style="position:relative;">
                    	<div>
                        	<a href="<?=geturl('homev2/profile/profile')?>"><p class="name fl" title="<?=$uername?>"><?=shortstr($uername, 6)?></p></a>
                        	<?php if(!$is_zjdlr){ ?>
                            <p class="jifen fl"><a href="/homev2/score/credit.html" ><?=$user['credit']?></a></p>
                            <?php }else{ ?>
                            	<p class="jifen fl"><a href="/homev2.html" ><?=$user['credit']?></a></p>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
					<?php if($roominfo['domain'] != 'bndx' && (!$is_zjdlr)){ ?>
						<div class="mypurse mt10" id="mypurse">
							<div class="mypico fl"></div>
							<div class="fl mypu"><a href="javascript:;">我的钱包</a></div>
						</div>
					<?php } ?>
						<div class="clear"></div>
						<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
						<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
						<div class="mypurses mt10" id="mypurses" style="background:<?=($room_type==1) ? 'url(http://static.ebanhui.com/ebh/tpl/2016/images/mypbj_qy.png)':'url(http://static.ebanhui.com/ebh/tpl/2016/images/mypbj.png)'?> no-repeat center;display:none;height:<?=($room_type==1) ? '78px':'184px'?>;">
							<div class="mypurse" id="mypurse2">
								<div class="mypico fl"></div>
								<div class="fl mypu"><a href="/homev2/purse.html">我的钱包</a></div>
							</div>
							<div class="clear"></div>
							<div class="zhye">账户余额：<span><?=$user['balance']?></span> 元<a href="http://pay.ebh.net/" target="_blank" style="padding-left:10px; color:#00aaf0 ;font-family: Microsoft Yahei;">充值</a><!--<a href="#" style="padding-left:10px;">提现</a>--></div>

							<div class="clear"></div>

							<iframe style="display: <?=($room_type==1) ? "none":"block"?>;" id="couponFrame" name="couponFrame" scrolling="no" width="227" height="46" frameborder="0" src="<?=geturl('college/coupon')?>"></iframe>
<?php if (!empty($mycoupon)){?>
							<div class="fxz" style="display: <?=($room_type==1) ? "none":"block"?>;">
								<div class="fl">分享至：</div>
								<div class="share-bar fl">
								</div>
							</div>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script>
	//积分超过万的时候保留1位小数用中文万表示，如1.0万
   	var $jifen = $(".jifen a");
   	var $xiutgt = $(".xiutgt span");
    var jifen = $jifen.html();
    if( jifen >= 10000 ){
    	$xiutgt.html("文曲星");
    }
   	if(parseInt(jifen / 10000) > 0){
   		var jifenStr = jifen+"";
		jifen = parseInt(jifen / 10000);
		$jifen.html(jifen+"."+jifenStr[jifenStr.length-4]+"万");
   	}
$('.share-bar').share({
	url: 'http://www.ebh.net/coupon.html?code=<?=$mycoupon['code']?>',
	source: 'e板会',
	title: '优惠专享！网校优惠任你拿！',
	description: '分享学习，分享快乐！我从<?=empty($roominfo['crname']) ? 'e板会' : $roominfo['crname'] ?>获得了优惠码：<?=$mycoupon['code']?>，开通任意课程服务都能享受优惠价哦，一起来吧！',
	summary: '好友使用你的优惠码购买课程，尊享网校优惠！你也可以获得现金奖励哦！快快行动吧！',
	image: 'http://static.ebanhui.com/ebh/tpl/2016/images/ebh_coupon.jpg',
	sites: ['qzone','wechat','weibo']
});
</script>
<?php } else {?>
		<div class="fxz2" style="display: <?=($room_type==1) ? "none":"block"?>;">
			<a class="hdjhk" href="http://www.ebh.net/coupon.html" target="_blank">查看优惠码规则</a>
		</div>
<?php }?>
						</div>
						<div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
               <div class="qianming">
            	<p style="width:230px; text-align:left;" class="qianmings">
                	<span title="<?=empty($user['mysign']) ? '点击修改签名' : $user['mysign']?>" style="display:block;width:235px;cursor:text; text-align:left;" id="mysign_span"><?=empty($user['mysign']) ? '暂无签名' : shortstr($user['mysign'])?></span>
                    <input type="text" style="display:none;width:195px;border:1px solid #9eb7cb;height:20px;line-height:20px;padding:0 5px;margin-top:5px;margin-bottom:1px;" id="mysign" maxlength="140">
                </p>
            	</div>
                <?php if($roominfo['domain'] != 'bndx'){ ?>
                <div class="gzfs">
                	<div class="fl"><a class="snsa" href="http://sns.ebh.net/follow.html" target="_blank"><span class="span1s"><?=empty($myfavoritcount)?0:$myfavoritcount?></span><br /><span class="span2s">关注</span></a></div>
                    <div class="fr"><a class="snsa" href="http://sns.ebh.net/follow/fans.html" target="_blank"><span class="span1s"><?=empty($myfanscount)?0:$myfanscount?></span><br /><span class="span2s">粉丝</span></a></div>
                </div>
                <?php } ?>
            </div>
            <div class="cmain_top_r fr" style="z-index:1;position:relative;">
            	<div>
                    <div class="titles fl" style="width:695px;">
                        <span>Hello！<?=!empty($user['realname']) ? $user['realname'] : $user['username']?><?php if($roominfo['domain'] != 'bndx'){ ?>&nbsp;<?=!empty($rolename) ? $rolename : '老师' ?>，欢迎使用<?=$roominfo['crname']?>。<?php } ?></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="esukang modulediv">
					<?php $count = 0;
						foreach($modulelist as $k=>$module){
						$count++;
						$mname = empty($module['nickname'])?$module['modulename_t']:$module['nickname'];
						$modulename = shortstr($mname,8,'');
						?>
						<a title="<?=$mname?>" class="<?=$module['classname']?> fl dfocus" href="<?=$module['url_t']=='/troomv2/myask.html'?'/troomv2/myask/allquestion.html':$module['url_t']?>" target="<?=empty($module['target'])?'mainFrame':$module['target']?>">
						<img src="http://static.ebanhui.com/ebh/tpl/2016/images/titleico/troom/47/<?=$module['classname']?>.png"/>
						<p class="jisrers"><?=$modulename?></p>
						</a>
						<?php
						unset($modulelist[$k]);
						if($count == 7)
							break;
					}?>

				</div>
            </div>
        </div>
        <div class="clear"></div>

		<?php //if(in_array($this->uri->uri_domain(),array('xiaoxue','rzjt'))) {
	if(!empty($modulelist)){?>
	<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-top:1px;padding-bottom:0;">
		<!--
		<h3>微题>></h3>
		<ul>
			<li class="smartexamenew fl"><a href="/smartexam/smartexam/qlist.html"></a></li>
		</ul>
		-->
		<div class="esukangs modulediv">
		<?php
		foreach($modulelist as $module){
			$target = empty($module['target'])?'mainFrame':$module['target'];
			$mname = empty($module['nickname'])?$module['modulename_t']:$module['nickname'];
			$modulename = shortstr($mname,8,'');
		?>
			<a title="<?=$mname?>" href="<?=$module['url_t']?>" target="<?=$target?>"  class="subtop <?=$module['classname']?> fl">
				<img class="tyrtrew" src="http://static.ebanhui.com/ebh/tpl/2016/images/titleico/troom/32/<?=$module['classname']?>.png"/>
				<p class="jisrers"><?=$modulename?></p>
			</a>

		<?php }?>
		</div>
	</div>
	<?php }?>


		<div class="rigksts" style="background:white;float:right;margin-top:10px;display:none;border:none">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/colleger.jpg"/>

</div>
<?php
	if(empty($idefurl))
		$idefurl = "/troomv2/troom.html";
	// if($this->input->cookie('refer')) {
		// $idefurl = urldecode($this->input->cookie('refer'));
		// $this->input->setCookie('refer','');
	// }
	if(!empty($url))
		$idefurl = $url;

$qcode_lib = Ebh::app()->lib('Qcode');
$qcode = $qcode_lib->get_qcode();
?>

		<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width="100%" height="100%" frameborder="0" src="<?=$idefurl?>" style="margin-top:10px;"></iframe>
        <!--意见反馈start-->
        <div style="width:100%;position:fixed;top:55%;display: none" id="ujdkgj" >
            <ul class="toolbarx">
                <li class="tool tFeedback"><a style="display:none" onclick="feedback()">意见反馈</a></li>
				<li class="tool tWechat"><a style="display:none">微信学习</a><div class="tQRCode"><img src="<?=htmlspecialchars($qcode, ENT_COMPAT)?>" width="141" height="141" /></div></li>
            </ul>
        </div>
        <!--意见反馈end-->
    </div>
</div>
<style>
.esukang a.onhover {
    border: 1px solid #ccc;
    border-radius: 2px;
    box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.3);
	width:84px;
	height:89px;
	padding-top:9px;
}
.esukangs a.onhover {
    border: 1px solid #ccc;
    border-radius: 2px;
    box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.3);
	height: 38px;
	line-height:38px;
    *width: 112px;
	padding:5px 7px 0 7px;
}

li.t-student-b{position:relative;}
.ui-dialog-footer .ui-dialog-button{
	text-align:center;
	float:inherit !important;
	width:260px;
	margin:0 auto;
}
.ui-dialog-footer button.ui-dialog-autofocus{
	height: 32px;
    line-height: 31px;
    width: 112px;
	background: #5e8cf1 !important;
    border: 1px solid #5e8cf1;
    border-radius: 3px;
    color: #fff;
    /* display: block;
    float: left; */
    font-size: 16px;
    text-align: center;
}
.ui-dialog-footer button.ui-dialog-autofocus:hover{
	border: 1px solid #5e8cf1;
}
.ui-dialog-footer button{
	background: #ececec !important;
    border: 1px solid #e7e7e7;
    border-radius: 3px;
    color: #666;
    /* display: block;
    float: right; */
    font-size: 16px;
    text-align: center;
	height: 32px;
    line-height: 31px;
    width: 112px;
	padding:0;
	font-family:微软雅黑;
	font-family::Microsoft Yahei;
}
.ui-dialog-footer button:hover{
	border: 1px solid #e7e7e7;
}
.xzkctsxx{
	font-size:16px;
	padding-top:25px;
	margin-top:0;
    color: #333;
    text-align: center;
	width:260px;
	margin:0 auto;
}
.ui-dialog-grid{
	font-family:微软雅黑;
	font-family::Microsoft Yahei;
}
</style>
<script>
 function resetmain () {
        try {
            var mainFrame = document.getElementById("mainFrame");
            var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight) + 1;
            iframeHeight = iframeHeight < 700 ? 700 : iframeHeight;
            	if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){
								var mainH =  mainFrame.contentWindow.document.getElementById('Main');
								if(mainH){
									iframeHeight += 618;
								}
						 	 }
            $(mainFrame).height(iframeHeight);
        } catch (e) {

        }
    }
function getUrlParam(name)
{
var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
var r = window.location.search.substr(1).match(reg);  //匹配目标参数
if (r!=null) return unescape(r[2]); return null; //返回参数值
}
$(function(){
	var furl = getUrlParam('url');
	$.each($('.dfocus'),function(k,v){
		if($(this).attr('href') == furl)
			$(this).addClass('onhover');
	});

	//$(".zzhuye").addClass('onhover');
	var ajaxurl = '/troomv2/default/getmsgAjax.html';
	$.ajax({
		type:'POST',
		url:ajaxurl,
		data:{},
		dataType:"json",
		success:function(data) {
				if(data != undefined && data['total'] != undefined && data['total'] > 0) {
					var askcount = data['total'] > 99 ? 99 : data['total'];
					$(".ttiwen").append("<span>" + askcount + "</span>");
				}
			}
	});

});
$(".modulediv a").click(function(){
	$(".modulediv a").removeClass('onhover');
	$(this).addClass('onhover');
})
	//滚动条初始化
    function scrollInit(){
       $(window).scroll(function(){
           var pageC = pageCondition();
           try{
               window.frames['mainFrame'].pageCondition(pageC);
           }catch(e){
           }
        })
    }
    //分页条件
    function pageCondition(){
        var windowHeight =  $(window).height();
        var scrollheight = $(this).scrollTop();
        var documentHeight = $(document).height();
        var pageHeight = 10;//距底部的分页高度
        if(windowHeight<documentHeight){
            if( windowHeight+scrollheight >= documentHeight -pageHeight ){
                return 1;
            }
        }
        return 0;
    }
    //滚动条置顶
    function topSet(){
        $(window).scrollTop(0);
    }
</script>
<!-- 播放视频 -->
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>

 <!-- 上传音频 -->
 <div style="display:none;">
	<div id="tandaandiv" class="tandaan" style="float:left;display:none;width:676px;padding:20px;">
	<div class="zhumai">
	<?php
        EBH::app()->lib('UMEditor')->xEditor('message','775px','310px');
	?>
<!--上传音频-->
	<div id="audio"></div>
	<div>
		 <div style="clear:both" id="showcourseware">&nbsp;</div>
        <div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传附件：</div>
        <div id="courseware" style="float:left;margin-left:0px;width:455px;margin-top:10px; ">
            <!-- <a href="javascript:void(0)" id="uploadcw" onclick="course.uploadCourseware(1);">上传解析附件</a> -->
            <button class="uploadbtn" id="uploadcw" onclick="course.uploadCourseware(1);">上传附件</button>
            <span id="showcw"></span>
        </div>
        <div style="clear:both" id="showcoursewareend">
        	<a class="tijiaobtn" onclick="sendMessage()" style="margin-right:20px;">提  交</a>
        </div>
		<div style="clear:both">&nbsp;</div>
		<input type="hidden" value="" name="cwid" id="cwid" />
        <input type="hidden" value="" name="cwsource" id="cwsource" />
	</div>
<!--结束-->
	</div>
   </div>
</div>

<!-- 暂时不知道 -->
<div style="display:none;width:790px;height:auto;overflow-x:hidden;">
<iframe  width=788 height=570 src="#" id="course_forlink" frameborder="0"></iframe>
</div>
<div style="display:none;width:790px;height:auto;overflow-x:hidden;">
<iframe  width=810 height=580 src="#" id="course_forlink_list" frameborder="0"></iframe>
</div>

<?php
$this->display('common/player');
?>
<?php
$_UP = Ebh::app()->getConfig()->load('upconfig');
$icp = '浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-'.date('Y').' ebh.net All Rights Reserved';
if(!empty($roominfo) && !empty($roominfo['icp']))
	$icp = $roominfo['icp'];
?>
<div class="foot">
<P style="color: #666666"><?=$icp?></P>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/troomv2.js?v=20161108"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js?v=15"></script>
<!-- 微销通 -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/eth.js"></script>
<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
<link href="https://cdn.bootcss.com/layer/3.1.0/mobile/need/layer.css" rel="stylesheet">
<script type="text/javascript">
	loadaudioDialog('audio');
	var xPhoto2 = function(param){
		if(typeof param == "undefined"){
			param = {};
		}
		this.xurl = param.url || '/static/flash/RES/PhotoOnLine2.xml?v=8';
		this.xresurl = param.resurl || '/static/flash/RES/RES.swf';
		this.xpicurl = param.upurl || '<?=$_UP['xk']['server'][0]?>';
		this.xinitpicurl = param.initpicurl || '';
		this.recsize = param.sizearr;
		this.recsizemsg = param.sizemsgarr;
		this.xcallback = param.callback || (function(msg){alert(msg);});
		this.xcancelcallback = param.cancelcallback || (function(msg){alert("取消了");});
		this.uid = param.id;
		this.height = param.height || 510;
		this.width = param.width || 757;
		this.title = param.title || "图片上传";
		if(typeof this.uid == "undefined"){
			alert('没有传入弹窗id!');
			return;
		}
		this.config();
	};
	xPhoto2.prototype.config = function(){
		this.setSize(this.recsize);
		this.setSizeMsg(this.recsizemsg);
	}
	xPhoto2.prototype.setSize = function(xsize){
		if(typeof xsize == "undefined"){
			var xsize = new Array();
			xsize.push("100_100");
			xsize.push("200_200");
			this.recsize = xsize;
		}
		this.xsize = '[\''+xsize.join('\',\'')+'\']';
	}
	xPhoto2.prototype.setSizeMsg = function(sizemsg){
		if(typeof sizemsg == "undefined"){
			var sizemsg = new Array();
			sizemsg.push("图片尺寸为100*100");
			sizemsg.push("图片尺寸为200*200");
			this.recsizemsg = sizemsg;
		}
		this.xsizemsg = '[\''+sizemsg.join('\',\'')+'\']';
	}
	xPhoto2.prototype.renderDialog = function(){
		var flash = HTools.pFlash({
			id:this.uid,
			width:this.width,
			height:this.height,
			uri:'/static/flash/PhotoOnline_2.swf',
			vars:{url:this.xurl,resurl:this.xresurl,picurl:this.xpicurl,initpicurl:this.xinitpicurl,size:this.xsize,sizemsg:this.xsizemsg,callback:this.xcallback,cancelcallback:this.xcancelcallback}
		});

		H.create(new P({
			id:this.uid,
			title:this.title,
			flash:flash,
			easy:true,
			padding:5
		}));

	}
	xPhoto2.prototype.doClose = function(){
		H.get(this.uid).exec('close');
	}
	xPhoto2.prototype.doShow = function(){
		H.get(this.uid).exec('show');
	}
	xPhoto2.prototype.getFlash = function(){
		return HTools.getFlash(this.uid);
	}
	xPhoto2.prototype.render = function(){
		if(typeof this.uid == "undefined"){
			alert("容器ID没有传入");
			return;
		}
		if($("#"+this.uid).length == 0){
			alert("Flash容器不存在");
			return;
		}
		var flash = HTools.rFlash({
			id:this.uid,
			width:this.width,
			height:this.height,
			uri:'/static/flash/PhotoOnline_2.swf',
			vars:{url:this.xurl,resurl:this.xresurl,picurl:this.xpicurl,initpicurl:this.xinitpicurl,size:this.xsize,sizemsg:this.xsizemsg,callback:this.xcallback,cancelcallback:this.xcancelcallback}
		});
	}
	function preparexMulPhoto(id,callback,initpicurl,upurl,width,height){
		var upurl = upurl || 'http://up.ebh.net/savemultipic.html';
		var w = width || 180;
		var h = height || 110;
		var vh = parseInt((320 * h) / w);
		window.xmulphoto = new xPhoto2({
			id:id,
			title:'课程图片上传',
			callback:callback,
			initpicurl:initpicurl,
			upurl:encodeURIComponent(upurl),
			cancelcallback:function(){
				window.xmulphoto.doClose();
			},
			xpicurl:upurl,
			//sizearr:new Array('320_196'),
			//sizemsgarr:new Array('课程图片尺寸比例为180:110')
			sizearr:new Array('320_' + vh),
			sizemsgarr:new Array('课程图片尺寸比例为' + w + ':'+ h)
		});
		window.xmulphoto.renderDialog();
	}
	function prev(jo) {
		jo.each(function() {
			$(this).lightBox();
		});
	}
	//选课调整（删除学生）
	function deleteXkStudent(callback) {
		var d = dialog({
			title: '信息提示',
			content: '<div class="xzkctsxx" style="text-align:center;">确定删除选中的学生？</div><div class="qsryy"><p class="pqsryy">请输入原因：</p><textarea id="del-fail-msg" class="sckcyysr" placeholder="由于课程名额有限，未能成功报名，请积极参与第二轮选课。"></textarea></div>',
			id:'del-xk-one-student',
            width:410,
			fixed:true,
			'okValue':'确定',
			'ok':function() {
				var msg = $.trim($("#del-fail-msg").val());
                callback(msg);
			},
			'cancelValue':'取消',
			'cancel':function() {}
		});
		d.showModal();
	}
    //加载学生
    var page = 1;
    var preData;
    var courseid = 0;
	var more = null;
    var tmpId = 0;
    var tmpType = 1;
    var studentids = [];
    //筛选类型：0选年级班级，1选学生
    var filterType = 0;
	function ajaxStudent(postData) {
	    if(courseid > 0) {
	        postData['cid'] = courseid;
        }
	    preData = postData;
		more.hide();
	    $.ajax({
	       'url':'/troomv2/xuanke/ajax_students.html',
            'type':'POST',
            'dataType':'json',
            'data':postData,
            'success':function(d) {
                if(d.errno == 0) {
                    page = d.page;
                    var l = d.data.length;
                    var studentsBox = $("#filter-ajax-students");
                    var dl = studentids.length;
                    for(var i = 0; i < l; i++) {
                    	var ch = '';
                        var htmlf = '';
                        var title = '';
						if(filterType === 1) {
							ch = '<a href="javascript:;" class="t-student fr xuanzq1s" ></a>';
							if(d.data[i].signed || d.data[i].overflow) {
								ch += '<div style="background:#000;width:100%;height:100%;position:absolute;top:0;left:0;opacity:0.5;filter:alpha(opacity=50); "></div>';
							}
						}
						if(d.data[i].lab) {
						    title = ' title="'+d.data[i].realname+'"';
                            htmlf = '<p class="xingmingl t-student">'+d.data[i].lab+'</p>';
                        } else {
							title = ' title="'+d.data[i].realname+'"';
                            htmlf = '<p class="xingmingl t-student">'+d.data[i].realname+'</p>';
                        }
                        studentsBox.append('<li class="fl t-student-b grade'+d.data[i].grade + ' class' +
                            d.data[i].classid + '" d='+d.data[i].uid+title+'><div class="t-student"><img style="width:50px;height:50px;" class="t-student" src="'+d.data[i].face+'" />'
                            +'</div>'+htmlf+ch+'</li>');
                    }
                    for(var i = 0; i < dl; i++) {
                        //$("li.fl.t-student-b[d='"+studentids[i]+"'] a.fr").addClass('onhover');
                        $("li.fl.t-student-b[d='"+studentids[i]+"']").append('<div style="background:#000;width:100%;height:100%;position:absolute;top:0;left:0;opacity:0.5;filter:alpha(opacity=50); "></div>');
                    }
                    if(d.finish) {
						more.hide();
                    } else {
						more.show();
                    }
					more.html('加载更多...');
                    if($("li.fl.t-student-b").size() == 0) {
                        studentsBox.append('<li class="fl t-student-b nodata"></li>');
                    }
                    return;
                }
            }
        });
    }
	//绑定年级、班级、学生选择事件

    function resetArg(ifilterType, cid) {
        filterType = ifilterType;
        if (filterType == 1) {
            $(".search-oper").show();
        } else {
            $(".search-oper").hide();
        }
        if (cid) {
	        courseid = cid;
        }
        page = 1;
    }
	function init(content, id, ifilterType, cid) {
	    if($("#"+id)) {
	        $("#"+id).unbind('click');
            $("#"+id).remove();
        }
	    $("body").append(content);
        page = 1;
        courseid = cid;
        filterType = ifilterType;
        if (filterType == 1) {
            $(".search-oper").show();
        } else {
            $(".search-oper").hide();
        }
		more = $("#filterDialog a.jzgds");
		$("#filterDialog").find(".hovered").each(function(e){
			$(e).removeClass('hovered');
		});
        $("#filterDialog").bind("click", function(e){
            var t = $(e.target);
            if(t.hasClass('qbxs2') || t.hasClass('qbxs1span')) {
                //年级菜单点击事件
                var menu = t;
                if(t.hasClass('qbxs1span')) {
                    menu = t.parent('div.qbxs2');
                }
                var id = menu.attr('d');
                if(menu.hasClass('ex')) {
                    menu.removeClass('ex');
                    menu.children('span.qbxs1span').removeClass('selct');
					menu.nextAll(".qbxs3.class[p='"+id+"']").hide();
                } else {
                    menu.addClass('ex');
                    menu.children('span.qbxs1span').addClass('selct');
					menu.nextAll(".qbxs3.class[p='"+id+"']").show();
                }
                $("div.hovered").removeClass('hovered');
                menu.addClass('hovered');
                if(tmpType != 1 || tmpId !== id) {
                    tmpType = 1;
                    tmpId = id;
                    page = 1
                    $("li.fl.t-student-b").remove();

                    if(courseid == 0) {
                        var ids = [];
                        $("div.qbxs3.class[p='"+id+"']").each(function() {
                            ids.push($(this).attr('d'));
                        });
                        ajaxStudent({
                            'filterType':2,
                            'id':ids,
                            'page':1
                        });
                    } else {
                        ajaxStudent({
                            'filterType':1,
                            'id':id,
                            'page':1
                        });
                    }
                }

                return;
            }

            if(t.hasClass('qbxs3') || t.hasClass('qbxs3-lab')) {
                //班级菜单点击事件
                var menu = t;
                if(t.hasClass('qbxs3-lab')) {
                    menu = t.parent('div.qbxs3');
                }
                $("div.hovered").removeClass('hovered');
                menu.addClass('hovered');

                var id = menu.attr('d');
                if(tmpType != 2 || tmpId != id) {
                    tmpType = 2;
                    tmpId = id;
                    page = 1
                    $("li.fl.t-student-b").remove();
                    ajaxStudent({
                        'filterType':2,
                        'id':id,
                        'page':1
                    });
                }
                return;
            }

            if(t.hasClass('fr') && t.hasClass('mt5') && t.hasClass('xuanzq')) {
                //选择图标点击事件
                if(t.hasClass('hovered')) {
                    t.removeClass('hovered');
                } else {
                    t.addClass('hovered');
                }
                return;
            }

            if(t.hasClass('jzgds')) {
                //加载更多学生
                if(t.html() == "正在加载中...") {
                    return;
                }
                t.html('正在加载中...');
                preData.page = page;
                ajaxStudent(preData, 1);
                return;
            }

            if(t.hasClass('soulico1s')) {
                //搜索学生
                var keyword = $.trim($("#s-keyword").val());
                if(!keyword) {
                    //return;
                }
                $("li.fl.t-student-b").remove();
                var ho = $(".qbxsabjnj div.hovered");
                var d = {
                    'page': 1,
                    'keyword': keyword
                };
                if(tmpType == 2) {
                    var ids = [];
                    $("div.qbxs3.class.hovered").each(function() {
                        ids.push($(this).attr('d'));
                    });
                    ajaxStudent({
                        'filterType':2,
                        'id':ids,
                        'keyword':keyword,
                        'page':1
                    });
                    return;
                }
                if(tmpType == 1) {
                    var ids = [];
                    $("div.qbxs2.grade.hovered").each(function() {
                        ids.push($(this).attr('d'));
                    });
                    ajaxStudent({
                        'filterType':1,
                        'id':ids,
                        'keyword':keyword,
                        'page':1
                    });
                    return;
                }
                ajaxStudent({
                    'filterType':0,
                    'keyword':keyword,
                    'page':1
                });
                return;
            }
            if(t.hasClass('t-student')) {
                //选择学生
				var student = $(t.parents('li.t-student-b').find('a.xuanzq1s').get(0));
				if(student.hasClass('onhover')) {
					student.removeClass('onhover');
				} else {
					student.addClass('onhover');
				}
                return;
            }
        });
    }
    //选择年级、班级、学生
	function filterStudentWindow(title, filterType, data, callback, cancel) {
		more.hide();
		$("li.fl.t-student-b").remove();
		$(".qbxs3.class.hovered").removeClass('hovered');
		$(".qbxs2.grade.hovered").removeClass('hovered');
		$(".qbxs3.class a.hovered").removeClass('hovered');
		$(".qbxs2.grade a.hovered").removeClass('hovered');
		$(".qbxs2.grade.ex").removeClass('ex');
		$("span.selct").removeClass('selct');
		$(".qbxs3.class").hide();
		tmpId = 0;
		tmpType = 1;
        studentids.length = 0;
	    if(filterType == 1) {
	        //年级
            $(".qbxs3.class a.fr.mt5.xuanzq").hide();
            $(".qbxs2.grade a.fr.mt5.xuanzq").show();
			var dl = data.length;
			for(var i = 0; i < dl; i++) {
				$(".qbxs2.grade[d='"+data[i]+"'] a.fr").addClass('hovered');
			}
        } else if(filterType == 2) {
            //班级
            $(".qbxs3.class a.fr.mt5.xuanzq").show();
            $(".qbxs2.grade a.fr.mt5.xuanzq").hide();
			var dl = data.length;
			var item = null;
			var parents = {};
			for(var i = 0; i < dl; i++) {
				item = $(".qbxs3.class[d='"+data[i]+"']");
				item.find("a.fr").addClass('hovered');
				if(parents['d'+item.attr('p')] == undefined) {
					$(".qbxs2.grade[d='"+item.attr('p')+"'] a.fr").addClass('ex');
					$(".qbxs2.grade[d='"+item.attr('p')+"'] span.fl").addClass('selct');
					$(".qbxs3.class[p='"+item.attr('p')+"']").show();
				}
				parents['d'+item.attr('p')] = true;
			}

        } else {
            studentids = data || [];
			$(".qbxs3.class a.fr.mt5.xuanzq").hide();
			$(".qbxs2.grade a.fr.mt5.xuanzq").hide();
		}

		var d = dialog({
			title: title,
			content: document.getElementById('filterDialog'),
			id:'filter_window',
			padding:0,
			fixed:true,
			'okValue':'确定',
            'onshow': function() {
                $("#s-keyword").val('');
            },
			'ok':function() {
                var retValue = [];
			    if(courseid > 0) {
			        $("a.t-student.fr.xuanzq1s.onhover").parent('li').each(function() {
			            retValue.push($(this).attr('d'));
                    });
                } else if(window.filterType == 1) {
                    $("a.t-student.fr.xuanzq1s.onhover").parent('li').each(function() {
                        var that = $(this);
                        retValue.push({id:that.attr('d'),'name':that.attr('title')});
                    });

                } else {
                    $("a.fr.mt5.xuanzq.hovered").parent('div').each(function() {
                        retValue.push({v:$(this).attr('d'),k:$(this).attr('lab')});
                    });
                }

			    callback(retValue);
				this.close();
			},
			'cancelValue':'取消',
			'cancel':function() {
			    cancel();
				this.close();
			}
		});
		d.showModal();
	}

	function showMsg(strMsg, callback) {
		var d = dialog({
			title: '信息提示',
			content: '<div class="sckj1s"><div class="xzkctsxx" style="">'+strMsg+'</div></div>',
			id:'alert',
			padding:0,
			fixed:true,
			quickClose:true
		});
		d.show();
        setTimeout(function () {
            if(callback) {
                callback();
            }
            d.close().remove();
        }, 2000);
	}

    function configMsg(strMsg, callback) {
        var d = dialog({
            title: '信息提示',
            content: '<div class="sckj1s"><div class="xzkctsxx" style="">'+strMsg+'</div></div>',
            id:'alert',
            padding:0,
            fixed:true,
            'okValue':'确定',
            'ok':function() {
                callback();
                this.close();
            }
        });
        d.showModal();
    }
	//页面加载完成后 设置object 为可见状态
	$(document).ready(function(){
　　	$('object').css('visibility','visible');
	});
	//注册授课管理点击事件
    $(document).on('click','.esukang a[href*="/troomv2/classsubject/courses.html"]',function () {

        layer.load();
    });
    //iframe加载完成事件
    var iframe = document.getElementById('mainFrame');
    iframe.onload =function () {
        resetmain();
        layer.closeAll();
    }





</script>

</body>
</html>