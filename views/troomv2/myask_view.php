
<?php $this->display('troomv2/room_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troomv2','window_type' => 'self')); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js<?=getv()?>"></script>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css<?=getv()?>" rel="stylesheet" />
<script type="text/javascript">
$(function() {
	try{
	$('.dengtu a').lightBox();
	}catch(error){}
});
</script>
<style type="text/css">

.dengtu {
    border:none;
    height: auto;
    margin: 10px 0;
    width: 277px;
}
.dengtu li {
    border-style: solid;
    border-width: 1px;
    float: left;
    height: 195px;
    margin: 0 20px 20px 0;
    position: relative;
    width: 277px;
    z-index: 2;
	border-color: #CDCDCD;
}
.photo_photolist_inner {
    position: relative;
}
.photo_photolist_img {
    height: 195px;
    overflow: hidden;
    width: 277px;
}
.photo_photolist_img a {
    height: 195px;
    width: 277px;
}
fieldset, img, a img, iframe {
    border-style: none;
    border-width: 0;
}
.bofang {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/download.png) no-repeat scroll ;
	color: #FFFFFF;
    float: left;
    height: 23px;
    line-height: 23px;
    text-align: center;
    width: 105px;
}
em{
	font-style: italic;
	
}
.huide strong em{
	font-weight: bold;
}
.huide em strong{
	font-style: italic;
}
strong{
	font-weight: bold;
}
.playbtn{
  background: #18a8f7;
  padding: 6px;
  border: 1px solid #eee;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
  color: #fff;
}
a.hrelh2 {
	display: block;
    margin: 1px 0 0 8px;
    background:url(http://static.ebanhui.com/ebh/tpl/2014/images/xiudty_s.jpg) no-repeat left center;
    color: #2796f0;
    cursor: pointer;
    float: left;
    height: 14px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
	padding-left:20px;
}
.sixists .xianda{width:955px; border-bottom:none !important;}
.wenkuang .wentit{width:885px;}
.sixists{width:1000px; background:#fff;}
.sixists .huide{
	width:920px;
	margin:1px 0 5px;
}
.xianda a.zuijiabtn{
	margin-right:15px;
}
	.terks{
	padding-left: 20px;
	background:none;
}
.quanwen a.xiugaibtn {
    background:#4c88ff;
    border-radius:4px;
    color:#fff;
    cursor:pointer;
    display:block;
    float:right;
    font-size:14px;
    height:36px;
    line-height:36px;
    margin-right:10px;
    text-align:center;
    text-decoration:none;
    width:100px;
}
.quanwen a.xiugaibtn:hover{
	background:#4c88ff;
}
.kanwenti a , .terks a{
	font-size:14px;
	font-family:微软雅黑;
	color:#999;
	
}
.quanwen .gaokuz{
	width:215px;
}
.kanwenti a{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/gzwtico.png) no-repeat left center;
	display:block;
	width:60px;
	padding-left:20px;
	float:left
}
.terks a{
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/gxico.png) no-repeat left center;
	display:block;
	width:60px;
	padding-left:20px;
	float:left;
	color:#ffa64c;
}
.xianda a.zuijiabtn{
	background:#4c88ff;
	color:#fff;
	border-radius:4px;
	margin-top:70px;
}
.xianda a.zuijiabtn:hover{
	background:#4c88ff;
	margin-top:70px;
}
.xianda a.shandaanbtn{
	height:29px;
	line-height:29px;
	background:#ffa64c;
	margin-top:70px;
}
.xianda a.shandaanbtn:hover{
	background:#ffa64c;
	margin-top:70px;
}
body{background:#f3f3f3}
</style>


<?php 
$rrurl = $this->input->get('rrurl');
?>
	<?php
	if($rrurl == 'troomv2/statisticanalysis/teach'){?>
		<div class="ter_tit">当前位置 > <a href="/troomv2/statisticanalysis.html">查询统计</a> > <a href="/troomv2/statisticanalysis/teach.html"> 教师统计 </a> > 答疑查看 > 答疑详情</div>
	<?php }else{?>
		<!--当前位置 > <a href="<?= geturl('troomv2/myask') ?>">师生答疑</a> > 答疑详情-->
	<?php }?>
<div style="width:1000px;margin:0 auto;">
<div class="lefrig" style=" background:none;">
<div style="height:16px;">
<div id="playercontainer"></div>
</div>
<div class="wenkuang" style="width:1000px;">
<div class="quanwen" style="width:965px">
<?php 
$defaulturl = $ask['sex'] == 1 ? ($ask['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($ask['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
$face =  empty($ask['face']) ? $defaulturl:$ask['face'];
$face = getthumb($face,'50_50');
$hasspower = 1;//教师是否有屏蔽权限,1表示有其它表示没有
?>
<p class="xiangs" style="float:left;width:950px;">
<a href="http://sns.ebh.net/<?=$ask['uid']?>/main.html" target="_blank"><img title="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>的个人空间" src="<?= $face ?>" style="width:50px;border-radius:25px;height:50px;float:left;"/></a>
<span class="wentit"><?= $ask['title'] ?></span>
<?php if(!empty($ask['reward'])){?>
	<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏<?=$ask['reward']?>积分">
	悬赏<?=$ask['reward']?>
	<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
	</span><span class="fenge">|</span>
<?php }?>
<?php if($ask['tid'] > 0){?>
<span class="renwusou"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></span>
<?php if($ask['uid'] != $user['uid']){?>
<a class="hrelh" href="javascript:" id="letters" tid="<?=$ask['uid']?>" tname="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>" title="给<?=$ask['sex'] == 1 ? '她' : '他'?>发私信"></a>
<?php }?>
<span class="fenge">|</span><span>所属学科：</span><span><?= $ask['foldername'] ?></span><span class="fenge">|</span><span><?= date('Y-m-d H:i:s',$ask['dateline']) ?></span><?php if( ($ask['tid']>0) &&($user['uid'] == $ask['tid'])){?><span class="fenge">|</span><a style="text-decoration: underline;color:#3195c6;" href="javascript:qshield(<?= $ask['qid']?>)">屏蔽问题</a><?php }else{$hasspower = 0;}?></p>
<?php }else{?>
<span class="renwusou"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></span>
<?php if($ask['uid'] != $user['uid']){?>
<a class="hrelh" href="javascript:;" tid="<?=$ask['uid']?>" tname="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>" title="给<?=$ask['sex'] == 1 ? '她' : '他'?>发私信"></a>
<?php }?>
<span class="fenge">|</span><span>所属学科：</span><span><?= $ask['foldername'] ?></span><span class="fenge">|</span><span><?= date('Y-m-d H:i:s',$ask['dateline']) ?></span><span class="fenge">|</span><a href="javascript:qshield(<?= $ask['qid']?>)" style="text-decoration: underline;color:#3195c6;float:left;display:inline;" >屏蔽问题</a></p>
<?php }?>
<div class="wenwen" style="width:960px"><?= $ask['message'] ?>&nbsp;</div>
<?php if(!empty($ask['imagesrc'])) { ?>
	<div class="dengtu" style="float:left;width:960px">
	<ul>
	<?php 
		$ask['imagesrc'] = explode(',',$ask['imagesrc']); 
		foreach ($ask['imagesrc'] as $img) {
	?>
	
		<li style="width:auto;padding:2px;border:none;float:left;">
			<div class="bg photo_photolist_inner">
			<p class="photo_photolist_img" style="width:auto;height:auto;">
			<a style="display:block;height: 100%;overflow: hidden;" href="<?= $img ?>">
			<img id="img1" src="<?= getthumb($img,'277_195')?>"  style="margin-top: 0px; margin-left: 0px;"/>
			</a>
			</p>
			</div>
		</li>

<?php } ?>
	</ul>
</div>
<?php }?>
<div id="questionaudio"></div>
<div class="gaokuz" >
<span class="kanwenti" style="background:none;">
    <?php if(empty($ask['aid'])) { ?>
    <a href="javascript:addfavorit(<?= $ask['qid'] ?>,1)">关注问题</a>
    <?php } else { ?>
    <a href="javascript:addfavorit(<?= $ask['qid'] ?>,0)" style="background:url(http://static.ebanhui.com/ebh/tpl/2016/images/ygzico.png) no-repeat left center;color:#ffa64c;">已关注</a>
    <?php } ?>
</span>
<?php if($ask['thatday'] == 1){ ?>
    <span class="terks"><a class="thankcount" href="javascript:addthank(<?= $ask['qid']?>)" style="background: url(http://static.ebanhui.com/ebh/tpl/2016/images/gxico1.png) no-repeat left center">感谢(<span id="qtknum"><?= $ask['thankcount'] ?></span>)</a>
        </span>
<?php }else{ ?>
	<span class="terks"><a class="thankcount" href="javascript:addthank(<?= $ask['qid']?>)" style="color:#999;">感谢(<span id="qtknum"><?= $ask['thankcount'] ?></span>)</a>
        </span>
<?php }?>
</div>
<?php if($ask['reqid']){?><span><a class="xiugaibtn" href="/troomv2/myask/<?=$ask['reqid']?>.html">查看关联问题</a></span><?php }?>
<?php if($ask['status'] == 1) { ?>
	<?php if(($user['groupid']==5)&&($ask['uid'] != $user['uid'])){?>
		<a href="javascript:UDialogv2('tandaandiv');" class="xiugaibtn">解 答</a>
	<?php }else{ ?>
		<span style="float:right;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jiejuebtn0507.jpg"></span>
	<?php } ?>
<?php } else if($ask['uid'] != $user['uid']) { ?>
	<a href="javascript:UDialogv2('tandaandiv');" class="xiugaibtn">解 答</a>
<?php } else { ?>
	<a href="<?= geturl('troomv2/myask/editquestion/'.$qid) ?>" class="xiugaibtn">修改问题</a>
	<a href="javascript:delask(<?= $qid ?>,'<?= $ask['title'] ?>');" class="shanchubtn">删除问题</a>
<?php } ?>

<?php
$rewardarray = array();
if (!empty($rewardlist)){
	echo '<div style="width:950px;clear:both;font-size:14px;color:#747474;"><span style="color:red">悬赏得分：</span>';
	foreach ($rewardlist as $value) {
		$rewardstr = empty($value['realname']) ? $value['username'] : $value['realname'];
		$rewardstr .= ' ' . $value['credit'] . '积分';
		$rewardarray[] = $rewardstr;
	}
	echo implode('、', $rewardarray) . '。';
	echo '</div>';
}
?>
</div>
</div>
<div class="tithui">
<span class="heida">回答</span><span>默认排序</span>
</div>

<?php if(!empty($answers)){ ?>
	<div class="sixists">
	<ul>

	<?php foreach ($answers as $f=>$answer) { ?>

	<?php 
	$defaulturl = $answer['sex'] == 1 ? ($answer['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($answer['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
	$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
	$face =  empty($answer['face']) ? $defaulturl:$answer['face'];
	$face = getthumb($face,'50_50');
	?>

	<li class="xianda" id="detail_<?= $answer['aid'] ?>" <?php if($f == ($ask['answercount']-1)) echo 'style="border-bottom:1px solid #cdcdcd;"';?>>
	<?php if($answer['isbest'] == 1) { ?>
	<img style="position: absolute;bottom:0px;right:0px;width:168px;height:168px;" src="http://static.ebanhui.com/ebh/tpl/default/images/zuijiaico0507.png" />
	<?php } ?>

	<div class="rentuwai">
		<a href="http://sns.ebh.net/<?=$answer['uid']?>/main.html" target="_blank"><img title="<?= empty($answer['realname'])?$answer['username']:$answer['realname'] ?>的个人空间" src="<?= $face ?>" style="width:50px;border-radius:25px;height:50px;"/></a>
    </div>
	<div class="twoxiang">
	<?php 
		$ip = '';
		if(!empty($answer['fromip'])){
			$ip.='ip:'.$answer['fromip'];
		}
		if(!empty($answer['IPaddress'])){
			$ip.='&nbsp;&nbsp;'.'地址:'.$answer['IPaddress'];
		}
	?>
	<?php if(!empty($user) && $user['groupid'] == 5){?>
	<a title="<?php echo $ip;?>" style="color: #299de6" class="huirenw"><?= empty($answer['realname']) ?  $answer['username'] : $answer['realname'] ?></a>
	<?php }else{ ?>
	<p class="huirenw"><?= empty($answer['realname']) ?  $answer['username'] : $answer['realname'] ?></p>
		<?php }?>
<?php if($answer['uid'] != $user['uid']){?>
	<a class="hrelh" href="javascript:" id="letters2" tid="<?=$answer['uid']?>" tname="<?= empty($answer['realname'])?$answer['username']:$answer['realname'] ?>" title="给<?=$answer['sex'] == 1 ? '她' : '他'?>发私信"></a>
<?php }?>
	<p class="huitime"><?=timetostr($answer['dateline'])?></p>
	</div>
	<div class="rietitsize" style=" position: relative;">
	<!--<span class="fenge">|</span>-->
	<?php if($answer['thatday'] == 1){?>
	<span class="terks"><a class="atk_<?= $answer['aid'] ?>" style="background: url(http://static.ebanhui.com/ebh/tpl/2016/images/gxico1.png) no-repeat left center" href="javascript:addthankanswer(<?= $ask['qid']?>,<?= $answer['aid'] ?>)">感谢(<span id="detailthkcount_<?= $answer['aid'] ?>"><?= $answer['thankcount'] ?></span>)</a></span>
	<?php }else{ ?>
	<span class="terks"><a class="atk_<?= $answer['aid'] ?>" style="color:#999;" href="javascript:addthankanswer(<?= $ask['qid']?>,<?= $answer['aid'] ?>)">感谢(<span id="detailthkcount_<?= $answer['aid'] ?>"><?= $answer['thankcount'] ?></span>)</a></span>
	<?php }?>
	<!--<span class="fenge">|</span>-->
	<?php if($answer['groupid']==6 && $hasspower == 1){?>
		<span style=" height: 30px;line-height: 30px;">
		<a href="javascript:shield(<?= $ask['qid']?>,<?= $answer['aid']?>)">屏蔽</a>
		</span>
	<?php } ?>
	</div>
	<div class="huide">
	<?php 
	//正则过滤下页面复制过来的html 主要过滤下面这张图片
	$message = $answer['message'];
	$pattern = '/<img.*?src="(.*?zuijiaico0507.png)".*?>/is';
	$pattern_new = '/<img.*?src="(.*?zjda.png)".*?>/is';
	if(preg_match($pattern, $message)){
		$message = preg_replace($pattern,'',$message);
	}
	if(preg_match($pattern, $message)){
                    $message = preg_replace($pattern_new,'',$message);
                }
	echo $message;
	?>
	</div>
	<div style="clear:both"></div>

	

	<?php if(!empty($answer['imagesrc'])) { ?>
	<div style="width: 940px;min-height:50px;_height:50px;float:left">
	<div class="dengtu" style="float: left;">
		<ul>
			<li style="width:auto;">
				<div class="bg photo_photolist_inner">
				<p class="photo_photolist_img" style="width:auto;height:auto;">
				<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $answer['imagesrc'] ?>">
				<img id="img1" src="<?= getthumb($answer['imagesrc'],'277_195') ?>"  style="margin-top: 0px; margin-left: 0px;"/>
				</a>
				</p>
				</div>
			</li>
		</ul>
		
	</div>
	<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>
	</div>
	<?php } ?>
	<?php if(!empty($answer['audio'])){ ?>
		<?php foreach ($answer['audio'] as $ak => $audio) { ?>
			<div id="answer_<?php echo $answer['aid'];?>_<?php echo $ak;?>" style="float:left;"></div>
			<script>$(function(){
				voicePlayer({
		            box: $("#answer_<?php echo $answer['aid'];?>_<?php echo $ak;?>"),
		            src: "<?php echo $audio['audiosrc'];?>",
		            time: <?php echo $audio['audiotime'];?>
		        }).show();
			})</script>
		<?php }?>
	<?php }?>
	<?php if(!empty($answer['cwid']) && !empty($answer['cwsource'])) { ?>
	<div class="bowaid" style="width:920px">
		<br>
		<button class="playbtn" onclick='showplayDialog("<?=$answer['cwsource']?>",<?=$answer['cwid']?>)'>查看附件</button>
	</div>
	<?php } ?>

	<?php if($answer['uid'] == $user['uid'] && $answer['isbest'] != 1) { ?>
	<a href="javascript:delanswer(<?= $qid ?>,<?= $answer['aid'] ?>)" class="shandaanbtn" style="margin-left:10px;">删除答案</a>
	<?php } ?>

	<?php if(($answer['isbest'] != 1) && ($ask['status']!=1)) { ?>
	<a href="javascript:setbest(<?= $ask['qid'] ?>,<?= $answer['aid'] ?>)" class="zuijiabtn">最佳答案</a>
	<?php } ?>

	</li>
	<?php } ?>

	</ul>
	</div>
	<?= $pagestr ?>
<?php } ?>

</div>
</div>
<!-- <div id="tandaandiv" qid="<?= $ask['qid'] ?>" class="tandaan" style="float:left;display:none;width:896px;padding:20px;">
<div class="topjies"><h2 class="tithuit">请写下您的解答，您也可以试试功能强大的 <a class="ejieda" href="javascript:playask(<?= $ask['qid'] ?>)">e板会解答</a>。</h2><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a></div>
<div class="zhumai">

<?php
        $editor->simpleEditor('message','675px','310px');
?>

    <a  qid="<?=$qid?>" class="tijiaobtn">提  交</a>
</div>
</div> -->
<!-- <div id="letter" style="display: none">
    <input type="hidden" value="" id="qbsx">
    <textarea class="txttiantl" name="summary" style="position:relative; *left:-45px;width:620px;"></textarea>
    <div class="wtkkr" style="margin-left: 20px;">
        内容不超过500字
        <a id="sendmessage" href="javascript:;" onclick="sendletter($('#qbsx').val())" class="msgsendbtn" style="margin-right: 90px;">发 送</a>
</div> -->
<script>
<?php if(!empty($audioque)){ ?>
	$(function(){
	<?php foreach ($audioque as $ado) { ?>
	voicePlayer({
            box: $("#questionaudio"),
            src: "<?php echo $ado['audiosrc'];?>",
            time: <?php echo $ado['audiotime'];?>
        }).show();
<?php } ?>
})
<?php } ?>
function letter(dom,which){
    window.dom = dom;
    if(H.get(dom)){
        H.get(dom).exec('show');
        return;
    }
    H.create(new P({
        title:"发送私信",
        content:$("#"+dom)[0],
        id:dom,
        width:642,
        height:530,
        easy:true
    }),'common').exec('show');
    $('.foot').css('display','none');
    $('#qbsx').val(which);
}
function sendletter(tid){
    var msg =  $.trim($("textarea.txttiantl").val());
    var tid = tid;
    if(msg.length==0){
var d = dialog({
    title: '提示',
    content: '请输入内容！',
	okValue: '确定',
    cancel: false,
    ok: function () {}
});
d.showModal();
        return;
    } else if(msg.length>500){
    var d = dialog({
    title: '提示',
    content: '内容不超过500字！',
	okValue: '确定',
    cancel: false,
    ok: function () {}
});
d.showModal();
        return;
    }
    $.ajax({
        type: "POST",
        url: "<?=geturl('troomv2/msg/do_send')?>",
        data:{tid:tid, msg:msg},
        success:function(res){
            if(res=="1"){
                var d = dialog({
					title: '发送成功',
					content: '发送成功！',
					cancel: false,
				});
				d.show();
				setTimeout(function () {
					d.close().remove();
				}, 2000);
                setTimeout("location.reload();",800);
            }else{
                var d = dialog({
					title: '发送失败',
					content: '发送失败！',
					cancel: false,
				});
				d.show();
				setTimeout(function () {
					d.close().remove();
				}, 2000);
            }
        }
    });
}


function UDialogv2(dom){
	var qid = $("#"+dom).attr('qid');
	showDialog(dom,qid);
}

//播放课件或者下载附件
function showplayDialog(source,cwid){
	if(typeof courseObj == "undefined"){
		courseObj = new Course(showCourseware,delCourseware);
	}
	if(!source || !cwid){
		return false;
	}
	courseObj.userplay(source,cwid);return false;
}

var showCourseware = function(source,cwid,qid,cwurl){
	H.get('upCoursewareDialog').exec('close');
    $('#showcw').html('<a id="playbutton" class="uploadbtn" onclick="course.userplay(\''+source+'\',\''+cwid+'\');return false;" href="javascript:void(0);">查看附件</a>&nbsp;<a id="delbutton" class="delbutton" title="删除解析附件" onclick="course.delCourseware(\''+qid+'\')" href="javascript:;">x</a>');
    $('#uploadcw').hide();
    $('#cwid').val(cwid);
    $('#cwsource').val(source);
}
var delCourseware = function(){
	H.get('upCoursewareDialog').exec('close');
    $("#uploadcw").show();
    $('#showcw').empty();
    $('#cwid').val(0);
    $('#cwsource').val("");
}
var course = new Course(showCourseware,delCourseware);
</script>
<!-- =============== -->
<div style="display:none;">
	<div id="tandaandiv" class="tandaan2" style="float:left;display:none;width:676px;padding:20px;text-align:left;">
	<div class="zhumai">
	<?php
        EBH::app()->lib('UMEditor')->xEditor('message','775px','310px');
	?>
<!--上传音频-->
	<div id="audiodiv"></div>
	<div>
		 <div style="clear:both" id="showcourseware">&nbsp;</div>
        <div style="float:left;margin-left:15px;margin-top:16px; ">上传附件：</div>
        <div id="courseware" style="float:left;margin-left:0px;width:455px;margin-top:10px; ">
            <!-- <a href="javascript:void(0)" id="uploadcw" onclick="course.uploadCourseware(1);">上传解析附件</a> -->
            <button class="uploadbtn" id="uploadcw" onclick="course.uploadCourseware(1);">上传附件</button>
            <span id="showcw"></span>
        </div>
        <div style="clear:both" id="showcoursewareend">
        	<a class="tijiaobtn" qid="<?=$qid?>" onclick="sendMessage()" style="margin-right:20px;">提  交</a>
        </div>
		<div style="clear:both">&nbsp;</div>
		<input type="hidden" value="" name="cwid" id="cwid" />
        <input type="hidden" value="" name="cwsource" id="cwsource" />
	</div> 
<!--结束-->
	</div>
   </div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js<?=getv()?>"></script>
<script>
loadaudioDialog('audiodiv');
	function showDialog(dom,qid){
		window.dom = dom;
		if(H.get(dom)){
			H.get(dom).exec('show');
			return;
		}

		H.create(new P({
			title:"解答编辑器",
			content:$("#"+dom)[0],
			id:dom,
			width:820,
			easy:true
		},{
			'onclose':function(){
				H.get('upCoursewareDialog').exec('close');
				$("#delbutton").trigger("click");
		    	ue.reset();
				return false;
			},
			'onshow':function(){
				ue.focus();
				ue.setContent("");
				return false;
			}
		}),'common').exec('show');
	}
	function sendMessage(){
		//var content = UM.getEditor('message').getContent();
		//var requestWindow = document.getElementById('mainFrame').contentWindow;
		//ue.setContent(content);
		callback();
		try{
			ue.reset();
			deleteaudio();
			H.get('upCoursewareDialog').exec('close');
			//H.get(dom).exec('close');
		}catch(e){

		}
	}

function settips(id,tips) {
	if($.trim($("#"+id).val()) == "") {
		$("#"+id).val(tips);
		$("#"+id).addClass("titwentigray");
	}
	$("#"+id).click(function(){
		if($.trim($(this).val()) == tips) {
			$(this).val("");
			$(this).removeClass("titwentigray");
		}
	});
	$("#"+id).blur(function(){
		if($.trim($(this).val()) == "") {
			$(this).val(tips);
			$(this).addClass("titwentigray");
		}
	});
}

</script>





<div style="clear:both;"></div>

<script type="text/javascript">
function addfavorit(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
        var url = '<?= geturl('troomv2/myask/addfavorit') ?>';
	$.ajax({
		url:url,
		type:'post',
		data:{'qid':qid,'flag':flag},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				changefavorite(qid,flag);
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>"+tips+"成功！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
			}else{
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='FPic'></div><p>"+tips+"失败</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
			}
		}
	});
}
function changefavorite(qid,flag) {
	var html = "";
	if(flag == 1) {
		html = '<a href="javascript:addfavorit('+qid+',0)" style="background:url(http://static.ebanhui.com/ebh/tpl/2016/images/ygzico.png) no-repeat left center;color:#ffa64c;">已关注</a>';	
	} else {
		html = '<a href="javascript:addfavorit('+qid+',1)">关注问题</a>';
	}
	$(".kanwenti").html(html);
}
function addthank(qid) {
	var tips = "感谢";
        var url = '<?= geturl('troomv2/myask/addthank') ?>';
	$.ajax({
		url:url,
		type:'post',
		data:{'qid':qid},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				var num = parseInt($("#qtknum").html());
				$("#qtknum").html(num+1);
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>"+tips+"成功！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();

				$('.thankcount').css('background','url(http://static.ebanhui.com/ebh/tpl/2016/images/gxico1.png) no-repeat left center');
				$('.thankcount').css('color','#ffa64c');
			}else if(data == 'fail'){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='FPic'></div><p>"+tips+"失败！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
			}else if(data == 'thatday'){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='PPic'></div><p>您今天已经感谢过了！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
			}
		}
	});
}
function addthankanswer(qid,aid) {
	var tips = "感谢";
        var url = '<?= geturl('troomv2/myask/addthankanswer') ?>';
	$.ajax({
		url:url,
		type:'post',
		data:{'qid':qid,'aid':aid},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				var num = parseInt($("#detailthkcount_"+aid).html());
				$("#detailthkcount_"+aid).html(num+1);
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>"+tips+"成功！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
				$('.atk_'+aid).css('background','url(http://static.ebanhui.com/ebh/tpl/2016/images/gxico1.png) no-repeat left center');
				$('.atk_'+aid).css('color','#ffa64c');
			}else if(data == 'fail'){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='FPic'></div><p>"+tips+"失败！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
			}else if(data == 'thatday'){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='PPic'></div><p>您今天已经感谢过了！</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 1000);
					}
				}).show();
			}
		}
	});
}

/*$(function(){
    $(".tijiaobtn").click(function(){
        submitanswer($(this).attr("qid"),$(this));
    })
})*/
	function callback(){
		var qid = $(".tijiaobtn").attr("qid");
		var dom = $(".tijiaobtn");
		submitanswer(qid,dom);
	}
	
    function submitanswer(qid,dom) {
        var tips = "提交解答";
        var message = UM.getEditor('message').getContent();
		var audio  = new Array();
		$(".hiddenaudio input").each(function(){
			audio.push($(this).val());
		});
		var cwid = document.getElementById('cwid').value;
		var cwsource = document.getElementById('cwsource').value;
        if($.trim(HTMLDeCode(message)) == "") {
            var d = dialog({
				title: '提示',
				content: '请输入内容！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
            return false;
        }
        var url = '<?= geturl('troomv2/myask/addanswer') ?>';
        $.ajax({
            url:url,
            type:'post',
            data:{'qid':qid,'message':message,'audio':audio,'cwid':cwid,'cwsource':cwsource},
            dataType:'json',
            success:function(data){
            if(data.status==1){
					dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='TPic'></div><p>"+tips+"成功</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								closeWindow('tandaandiv');
		                        location.reload();
								that.close().remove();
							}, 1000);
						}
					}).show();
                }else if(data.status == -1){
                	var str = '';
                    	$.each(data.Sensitive,function(name,value){
                    		str+=value+'&nbsp;';
                    	});
                    	var d = dialog({
							title: '提示',
							content: '答案包含敏感词汇'+str+'！请修改后重试...',
							cancel: false,
							okValue: '确定',
							ok: function () {  
								      
							}
						});
						d.showModal();
						return false;
                }else{
					dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='FPic'></div><p>"+tips+"失败</p>",
						width:350,
						onshow:function () {
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
function setbest(qid,aid) {
	var tips = "设置最佳答案";
	var url = '<?= geturl('troomv2/myask/setbest') ?>';
	$.ajax({
		url:url,
		type:'post',
		data:{'qid':qid,'aid':aid},
		dataType:'text',
		success:function(data){
            var data = eval('('+data+')');
			if(data=='success'){
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='TPic'></div><p>"+tips+"成功</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							document.location.href = document.location.href;
							that.close().remove();
						}, 1000);
					}
				}).show();
			}else{
				dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='FPic'></div><p>"+tips+"失败</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							document.location.href = document.location.href;
							that.close().remove();
						}, 2000);
					}
				}).show();
			}
		}
	},'json');
}

function closePage() {
	var Browser = navigator.appName;
	var indexB = Browser.indexOf('Explorer');

	if (indexB > 0) {
		var indexV = navigator.userAgent.indexOf('MSIE') + 5;
		var Version = navigator.userAgent.substring(indexV, indexV + 1);

		if (Version >= 7) {
			window.open('', '_self', '');
			window.close();
		}
		else if (Version == 6) {
			window.opener = null;
			window.close();
		}
		else {
			window.opener = '';
			window.close();
		}

	}
	else {
		window.close();
	}
}

function delask(qid,title) {
    var url = '<?= geturl('troomv2/myask/delask') ?>';
    var successurl = '<?= geturl('troomv2/myask') ?>';
    var d = dialog({
        title: '删除确认',
        content: '您确定要删除问题【' + title + '】吗？',
        okValue: '确定',
        ok: function () {
    		$.ajax({
    			url:url,
    			type:'post',
    			data:{'qid':qid},
    			dataType:'text',
    			success:function(data){
    				if(data=='success'){
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>问题删除成功！正在关闭页面...</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									closePage();
									that.close().remove();
								}, 2000);
							}
						}).show();					
    				}else{
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>对不起，问题删除失败，请稍后再试！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									document.location.href =  document.location.href;
									that.close().remove();
								}, 2000);
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
//删除答案
function delanswer(qid,aid) {
    var url = '<?= geturl('troomv2/myask/delanswer') ?>';
	var d = dialog({
        title: '删除确认',
        content: '您确定要删除您的问题答案吗？',
        okValue: '确定',
        ok: function () {
		$.ajax({
			url:url,
			type:'post',
			data:{'qid':qid,'aid':aid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='TPic'></div><p>答案删除成功！</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								document.location.href =  document.location.href;
								that.close().remove();
							}, 2000);
						}
					}).show();	
				}else{
					dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='FPic'></div><p>对不起，答案删除失败，请稍后再试！</p>",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								document.location.href =  document.location.href;
								that.close().remove();
							}, 2000);
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

//屏蔽回答
function shield(qid,aid){
			var url = "<?= geturl('troomv2/myask/shield')?>";
			var d = dialog({
				title: '屏蔽回答',
				content: '您确定要屏蔽该回答吗？屏蔽后不可查看该回答！',
				okValue: '确定',
				ok: function () {
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'qid':qid,'aid':aid},
				success:function(data){
					if(data !== undefined && data.status !== undefined && data.status == 1) {
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>屏蔽回答信息成功！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									document.location.href =  document.location.href;
									that.close().remove();
								}, 1000);
							}
						}).show();
					} else {
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>屏蔽回答失败，请稍后再试或联系管理员！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									document.location.href =  document.location.href;
									that.close().remove();
								}, 2000);
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
//屏蔽问题

var tips =dialog({
	title: '提示信息',
	content: '',
	cancel: false
});


function qshield(qid){
	var d = dialog({
    title: '提示',
    content: '您确定要屏蔽该问题吗？屏蔽后不可查看该问题!',
    okValue: '确定',
    ok: function () {
			d.close();
			var url = "<?= geturl('troomv2/myask/qshield')?>";
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'qid':qid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
							u = 'http://'+"<?php echo $roominfo['domain'];?>"+'.ebh.net/troomv2.html?url=';
							document.location.href = u+"<?= geturl('troomv2/myask/allquestion')?>";
					} else {
						var msg = '屏蔽问题失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
							tips.content(msg);
							tips.show();
							setTimeout(function () {
								tips.close();
							}, 2000);
					}
				}
			});
        return false;
    },
    cancelValue: '取消',
    cancel: function () {}
});
d.showModal();
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php $this->display('common/player'); ?>
<?php if(isset($hashead) && $hashead==1){ $this->display('troomv2/room_footer');} ?>