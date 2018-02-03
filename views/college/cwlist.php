<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css<?=getv()?>" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate.js<?=getv()?>"></script>
<style>
.studyalert{
	background:white;position:absolute;display:none;border:1px solid;width:130px;text-align:center;z-index:100
}


.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
.redbl {
    color: red;
    font-weight: bold;
}
.disbl {
	color:#666;
    font-weight: bold;
}
.kewate {
    background: #eee!important;
    border: 1px solid #dcdcdc;
    display: inline;
    float: left;
    height: 24px;
    position: relative;
    width: 167px!important;
}
.label-live{
	float:left;
	padding:1px 5px;
	height: 18px;
	width: 30px;
	border: 1px solid #dbdbdb;
    margin-right: 10px;
	margin-left:5px;
	margin-top:3px;
	background-color: #18a8f7;
	border-radius: 0.25em;
    color: #fff;
    display: inline;
    text-align: center;
	font-style: normal ;
}
.fujianico{
	margin-top:3px;
}
.kettshe:hover {
	background:#f5faff;
}
.wsktgst{
	width:220px !important;
}
</style>

</head>

<body style="background:none">
<div class="lsitit" >
<div class="lefstr" style="padding-bottom:20px;background:white; width:998px;">
<?php
if(!empty($folder)){
$this->assign('selidx',0);
$this->assign('showmodeselection',true);
$this->display('college/course_nav');
}else{
	?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>

	<?php
}
// $showmode = $this->input->cookie('cwsmode');
$showmode = $folder['showmode'];
?>
<div class="kstfrt" style="width:998px;">

<p class="stketi" style="margin-top:0;"></p>

</div>
<!--网格模式-->
<?php if($showmode == 1){?>
<div class="gridmode">
<?php
if(!empty($sectionlist)){
foreach($sectionlist as $k=>$section) {
	$keys = array_keys($section);
	$enabled = true;
	?>
	<div style="font-size:16px;font-weight:bold;padding:10px 6px;float:left;width:986px;padding-bottom:0px;margin-top:5px">
		<a href="javascript:void(0)" style="color:#18a8f7;text-decoration:none" onclick="showcws('1c<?=$k?>')"><?=$section[$keys[0]]['sname']?>(<?=count($sectionlist[$k])?>)</a>
	</div>
<div id="tb1c<?=$k?>">
<?php

$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov','swf');
// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
$emptylogo = true;
	foreach($section as $cw){
		$arr = explode('.',$cw['cwurl']);
		$type = $arr[count($arr)-1];
		$isVideotype = in_array($type,$mediatype) || $cw['islive'];
		// $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
		$target = '_blank';
		$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($cw['islive']?'livelogo.jpg':'defaultcwimggray.png?v=20160504001');
		if($isVideotype){
			$playimg = 'kustgd2';
		}elseif(strstr($type,'ppt')){
			$playimg = 'ppt';
		}elseif(strstr($type,'doc')){
			$playimg = 'doc';
		}elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
			$playimg = 'rar';
		}elseif($type == 'mp3'){
			$playimg = 'mp3';
		}elseif($cw['islive'] == 1){
			$playimg = 'kustgd2';
		}else{
			$playimg = 'attach';
		}

		if(!empty($cw['logo']) && $isVideotype) {
			$logo = $cw['logo'];
			$emptylogo = false;
		}
		else{
			$logo = $deflogo;
		}
		if($enabled && empty($cw['disabled']) || empty($folder['playmode']))
			$enabled = true;
		else
			$enabled = false;
	?>
		<div class="gdydht" style="height:178px;">
			<div style="overflow: hidden;position:relative;<?=!$enabled?'cursor:default':''?>" class="wraps" <?php if(!$enabled){?> onmouseover="$('#studyalert1c<?=$cw['cwid']?>').show()" onmouseout="$('#studyalert1c<?=$cw['cwid']?>').hide()"<?php }?>>
			<div id="studyalert1c<?=$cw['cwid']?>" class="studyalert">请按课件顺序学习</div>
			<?php if($enabled){
				if (!empty($itemid)) {
					$cwurl = !empty($haspower) ? '/myroom/mycourse/'.$cw['cwid'].'.html?itemid='.$itemid : '/ibuy.html?itemid='.$itemid;
					if (!empty($haspower)) {
						$cwurl = '/myroom/mycourse/'.$cw['cwid'].'.html?itemid='.$itemid;
					} else {
						$cwurl = !empty($free) ? 'javascript:;' : '/ibuy.html?itemid='.$itemid;
					}
				} else {
					$cwurl = '/myroom/mycourse/'.$cw['cwid'].'.html';
				}
				if ($cwurl == 'javascript:;') {
					$target = '_self';
				}
				?>
				<a class="kustgd<?php if(!empty($free)) { echo ' free-u';} ?>" target="<?=$target?>" href="<?=$cwurl?>" title="<?=$cw['title']?>">
			<?php }else{?>
				<div class="kustgd">
			<?php }?>
				<?php if($iszjdlr){?>
					<?php if(!empty($cw['cwtoid']) && $cw['cwtoid'] == 1){?>
					<?php if(empty($cw['logo'])){?>
						<img src="http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png?v=20160504001" />
					<?php }else{?>
						<img src="<?= $cw['logo'];?>" />
					<?php }?>
					<?php }?>
				<?php }else{?>
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png" />
				<?php }?>
			<?php if($enabled){?>
				</a>
			<?php }else{?>
				</div>
			<?php }?>

				<div class="fskpctd">
					<img src="<?=$logo?>" onerror="errorHandler.call(this)" class="imgst" cwid="<?=$cw['cwid']?>">
				</div>
				<!-- ===进度条逻辑开始=== -->
				<?php $showprogress = true;
					if(empty($isVideotype) || !empty($cw['islive']) || $type == 'swf')
						$showprogress = false;?>
				<div style="border:none;height:16px;<?=$showprogress?'':'background:white!important'?>" class="kewate" >
					<?php if($showprogress){?>
					<span style="width:167px;background:none;z-index:2;height:16px;line-height:16px;"><?=$cw['percent']?>%</span>
					<span style="height:16px;z-index:1;width:<?=$cw['percent']?>%;"></span>
					<?php }?>
				</div>
			<!-- ===进度条逻辑结束=== -->
				<div class="titel">
					<h2 style="color:<?=$enabled?'#666':'#ccc'?>;overflow:hidden;" class="lihett f-thide"><?=shortstr($cw['title'],18,'')?></h2>
				</div>
				<div style="margin:5px 0 0;" class="orgname">
					<span class="texrig" ><?=shortstr($cw['realname'],14,'')?></span>
					<span style="text-align: right;float:right;" class="texrig"><?=Date('Y-m-d',$cw['dateline'])?></span>
				</div>
		</div>
	</div>

<?php
if($folder['playmode'] == 1 && ($cw['percent'] != 100 || !empty($cw['disabled'])))
	$enabled = false;
}?>
</div>
<?php
} ?><div style="clear:both;" class="group"><?=$pagestr?></div><?php }else{?>
<div class="nodata">
</div>
<?php }?>
</div>
<?php }?>
<!--结束-->


<!--列表模式-->
<?php if(empty($showmode) || $showmode == 2){?>
<div class="listmode">

<?php
if(!empty($sectionlist)){
foreach($sectionlist as $k=>$section) {
	$keys = array_keys($section);
	?>
	<div style="font-size:16px;font-weight:bold;padding:10px 6px;float:left;width:986px">
		<a href="javascript:void(0)" style="color:#18a8f7;text-decoration:none" onclick="showcws('2c<?=$k?>')"><?=$section[$keys[0]]['sname']?>(<?=count($sectionlist[$k])//$section[0]['sectioncount']?>)</a>
	</div>
	<ul id="tb2c<?=$k?>"<?php if ($iszjdlr){ echo ' style="display:none"'; }?>>
	<?php
	$enabled = true;
	$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov','swf');
	// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png';
	$emptylogo = true;
	foreach($section as $cw){

		$arr = explode('.',$cw['cwurl']);
		$type = $arr[count($arr)-1];
		$isVideotype = in_array($type,$mediatype) || $cw['islive'];
		// $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
		$target = '_blank';
		$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($isVideotype?($cw['islive']?'livelogo.jpg':'defaultcwimggray.png?v=20160504001'):'kustgd2.png');
		if($isVideotype){
			$playimg = 'kustgd2';
		}elseif(strstr($type,'ppt')){
			$playimg = 'ppt';
		}elseif(strstr($type,'doc')){
			$playimg = 'doc';
		}elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
			$playimg = 'rar';
		}elseif($type == 'mp3'){
			$playimg = 'mp3';
		}else{
			$playimg = 'attach';
		}

		if(!empty($cw['logo']) && $isVideotype){
			$logo = $cw['logo'];
			$emptylogo = false;
		}
		else{
			$logo = $deflogo;//'http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png';
		}

		$base_avatar = 'http://static.ebanhui.com/ebh/tpl/default/images/';
		if($iszjdlr){
			$defaulturl = ($cw['sex'] == 1)?$base_avatar."t_woman.jpg" : $base_avatar."t_man.jpg";
			$face = empty($cw['face']) ? $defaulturl : $cw['face'];
		}else{
			$defaulturl = ($cw['sex'] == 1)?$base_avatar."t_woman.jpg" : $base_avatar."t_man.jpg";
			$face = empty($cw['face']) ? $defaulturl : $cw['face'];
		}
		$face = getthumb($face,'50_50');

		//直播与普通课件 eker
		$cwtype = ($cw['islive'] == 1 )? 'live' : 'course';
		if($enabled && empty($cw['disabled']) || empty($folder['playmode'])){
			$enabled = true;
		}else{
			$enabled = false;
		}
?>
<li class="setud kettshe" style="width:970px;">
<div class="skthgd">
	<?php if (!$iszjdlr) { ?><img style="border-radius:25px;" src="<?=$face?>" /><?php } ?>
<?php if($iszjdlr){
	if(empty($cw['cwusername']) && empty($cw['cwrealname'])){
		$cw['cwusername'] = $cw['username'];
		$cw['cwrealname'] = $cw['realname'];
	}
	if(empty($cw['cwrealname'])){
		$cw['cwrealname'] = $cw['cwusername'];
	}
	?>

<?php }else{?>
	<p><?=$cw['realname']?></p>
<?php }?>
</div>
<div class="ettyusr"<?php if ($iszjdlr && $folderid != $other_config['lecture']){ echo ' style="display:none;"'; } ?>>
<?php if($enabled){
	$date = Date('Y-m-d',$cw['truedateline']);
	$datenow = date('Y-m-d');
	if (!empty($itemid)) {
		$cwurl = !empty($haspower) ? '/myroom/mycourse/'.$cw['cwid'].'.html?itemid='.$itemid : '/ibuy.html?itemid='.$itemid;
		if (!empty($haspower)) {
			$cwurl = '/myroom/mycourse/'.$cw['cwid'].'.html?itemid='.$itemid;
		} else {
			$cwurl = !empty($free) ? 'javascript:;' : '/ibuy.html?itemid='.$itemid;
		}
	} else {
		$cwurl = '/myroom/mycourse/'.$cw['cwid'].'.html';
	}
	if ($cwurl == 'javascript:;') {
		$target = '_self';
	}
	?>
<a class="fusrets<?php if (!empty($free)) { echo ' free-u'; } ?>" style="color:<?= $date==$datenow?'red':'#666'?>" target="<?=$target?>" href="<?=$cwurl?>" title="<?=$cw['title']?>">
	<?php if($iszjdlr && !empty($cw['cwtoid']) && $cw['cwtoid'] == 1){?>
		<?php if(!empty($cw['logo'])){?>
			<img src="<?= $cw['logo'];?>" />
		<?php }else{?>
			<img src="http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png?v=20160504001" />
		<?php }?>
	<?php }else{?>
	<img src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>"/>
	<?php }?>
</a>
<img src="<?=$logo?>" />
<?php }else{?>
	<img src="<?=$logo?>" onmouseover="$('#studyalert3c<?=$cw['cwid']?>').show()" onmouseout="$('#studyalert3c<?=$cw['cwid']?>').hide()"/>
	<div id="studyalert3c<?=$cw['cwid']?>" class="studyalert" style="top:-10px">请按课件顺序学习</div>
<?php }?>
</div>
<div class="sktgte">
<?php if($cw['attachmentnum'] > 0) { ?>
	<i class="fujianico" title="此课件包含附件" ></i>
<?php } ?>
<?php if($cwtype=='live'){?>
<i class="label-live" title="直播课件" style="<?= ($cwtype=='live'&&$cw['truedateline']+$cw['cwlength']<=SYSTIME)?'background:#999999 !important':''?>">直播</i>
<?php }?>
<h2 class="" style="position:relative">
<?php if($enabled){
	if($cwtype != 'live'){
		if((empty($limitdate) || $cw['dateline']>$limitdate) && SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){
		?>
		<a <?php if(!empty($free)) { echo ' class="free-u"'; } ?> style="color:<?= $date==$datenow?'red':'#666'?>" target="<?=$target?>" href="<?=$cwurl?>" title="<?=$cw['title']?>"><?=$cw['title']?></a>
		<?php }elseif(SYSTIME<$cw['submitat'] || !empty($cw['endat'])){?>
		<a style="color:<?= $date==$datenow?'red':'#666'?>" target="<?=$target?>" href="<?=$cwurl?>" title="<?=$cw['title']?>"><?=$cw['title']?></a>
		<?php }else{?>
			<span style="color:#B5B2B2">
			<?=$cw['title']?>
			</span>(往期课件)
		<?php }
	} else {?>
	<a style="color:<?= ($cwtype=='live'&&$cw['truedateline']+$cw['cwlength']<=SYSTIME)?'#999':($date==$datenow?'red':'#666')?>" target="<?=$target?>" href="<?=$cwurl?>" title="<?=$cw['title']?>"><?=$cw['title']?></a>
	<?php }?>
<?php }else{?>
<span style="color:#ccc" onmouseover="$('#studyalert2c<?=$cw['cwid']?>').show()" onmouseout="$('#studyalert2c<?=$cw['cwid']?>').hide()"><?=$cw['title']?></span>
<div id="studyalert2c<?=$cw['cwid']?>" class="studyalert">请按课件顺序学习</div>
<?php }?>
</h2>
<span class="ksytde">


	<?php if(SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
		<?=$iszjdlr && in_array($folderid, array($other_config['transaction'], $other_config['regulations'])) ? $this->format_date($cw['dateline']) : timetostr($cw['dateline']).' 发布' ?>
		<?php if(SYSTIME<=$cw['endat']){?>
			<span class="disbl">将于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
		<?php }?>
	<?php }elseif(empty($cw['endat']) || SYSTIME<=$cw['endat']){?>
		<span class="redbl">于&nbsp;<?=Date('Y-m-d H:i',$cw['submitat'])?> 开课,敬请期待!
		<?php if(SYSTIME<=$cw['endat']){?>
			<span class="redbl">将于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
		<?php }?>
		</span>
	<?php }else{?>
		<span class="<?=$enabled?'disbl':''?>" style="color:#999">已于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束! </span>
	<?php }?>


</span>
	<?php if ($iszjdlr && in_array($folderid, array($other_config['transaction'], $other_config['regulations']))) { ?>
	<span class="ksytde"><?=!empty($cw['cwrealname']) ? $cw['cwrealname'] : $default_author ?></span>
		<?php if(isset($cw['cwuid']) && isset($student_classes[$cw['cwuid']])) { ?><span class="ksytde"><?=$student_classes[$cw['cwuid']]['classname']?></span><?php } ?>
	<?php } else { ?>
		<span class="ksytde">人气：<?=$cw['viewnum']?></span>

		<?php
		$arr = explode('.',$cw['cwurl']);
		$type = $arr[count($arr)-1];
		if($type != 'flv' && $cw['ism3u8'] == 1) {
			$type = 'flv';
		}?>
		<?php if($type == 'flv'){ ?>
			<span class="ksytde">赞：<?=$cw['zannum']?></span>
		<?php }
	 } ?>

	<?=empty($cw['reviewnum'])?'评论：0':'评论：'.$cw['reviewnum']?>
<?php if(!$iszjdlr || isset($other_config['lecture']) && $folderid == $other_config['lecture']) { ?>
	<p><?=$cw['summary']?></p>
<?php } ?>
</div>
<?php if($cw['ism3u8']){?>
<div class="wsktgst">
<span class="lfdte">学习进度</span><span class="swriowt"><span class="sktdsyt" style="width:<?=$cw['percent']?>%;"></span></span><?=$cw['percent']?>%
</div>
<?php }?>
</li>
<?php
if($folder['playmode'] == 1 && ($cw['percent'] != 100 || !empty($cw['disabled'])))
	$enabled = false;
}
?>
	</ul>
<?php
} ?><div style="clear:both;" class="group"><?=$pagestr?></div><?php }else{?>
<div class="nodata">
</div>
<?php }?>
</div>
<?php }?>
<!--结束-->



</div>


</div>
<?php if (!empty($free)) { ?>
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
<?php } ?>
</body>
<script>
var itemid = <?=!empty($itemid) ? "$itemid" : "0" ?>;
var folderid = <?=$folderid?>;
var init;
$(function(){
	function freeBuySuccess() {
		var freeWindow = top.dialog({
			id: 'free-window',
			title: '免费开通成功',
			fixed: true,
			content: "开通成功，重新点击课件进入学习页。",
			padding: 20,
			onshow: function() {
				var box = $(this.node);
				box.find('.ui-dialog2-footer').css('text-align', 'right');
			},
			okValue: '确定',
			ok: function() {

			},
			onclose: function() {
				location.href = "/myroom/college/study/cwlist/"+folderid+".html";
			}
		});
		freeWindow.showModal();
	}
	function getSingleItem(itemid, callback) {
		$.ajax({
			'url' : '/room/portfolio/ajax_check_userpermisions.html',
			'type': 'post',
			'dataType': 'json',
			'data': { 'itemid': itemid },
			'success': function(d) {
				if (d.errno > 0) {
					alert(d.msg)
					return;
				}
				if (typeof(callback) == 'function') {
					callback(d.data.item);
				}
			}
		});
	}
	function buyFreeItem(item) {
		if (item == null) {
			return;
		}
		$.logArg = item.itemid;
		if (item.url) {
			location.href = item.url;
			return;
		}
		var freeWindow = top.dialog({
			id: 'free-window',
			title: '报名',
			fixed: true,
			content: $("#free-dialog").html(),
			padding: 20,
			onshow: function() {
				var box = $(this.node);
				box.find('.ui-dialog2-footer').css('text-align', 'right');
				box.find('img.imgrts').attr('src', item.showimg);
				box.find('div.suitrna h2').html(item.iname);
				box.find('div.suitrna p.p1').html(item.crname);
				box.find('div.nasirte div.paewes').html(item.summary);
			},
			okValue: '去报名',
			ok: function() {
				var itemid = [];
				if (item['group_members']) {
					$.each(item['group_members'], function(index, ob) {
						itemid.push(ob.itemid);
					});
				} else {
					itemid.push(item.itemid);
				}
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
						freeBuySuccess();
					}
				});
			},
			cancelValue: '取消',
			cancel: function() {

			}
		});
		freeWindow.showModal();
	}

	<?php if(empty($myfavorite)) { ?>
		$("#favorite").html("收藏");
		$("#favorite").unbind().click(function(){
			$("#favorite").html("已收藏");
			$("#favorite").removeClass('shoutie');
			$("#favorite").addClass('yishout');
			$("#favorite").removeAttr('onclick');
			addfavorite('<?= $folder['folderid'] ?>','<?= $folder['foldername']?>',location.href);
		});
	<?php } else { ?>
		$("#favorite").html("已收藏");
		$("#favorite").removeClass('shoutie');
		$("#favorite").addClass('yishout');
	<?php } ?>


	// var showmode = getcookie('ebh_cwsmode');
	// if(showmode!=''){
		// $('.to'+showmode).click();
	// }

	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();

	$("a.free-u").bind('click', function() {
		if (itemid == 0) {
			return;
		}
		var t = $(this);
		if (t.attr('href') == 'javascript:;') {
			getSingleItem(itemid, buyFreeItem);
		}
	});
});
function addfavorite(folderid,title,url){
		var purl = "<?= geturl('myroom/favorite/add')?>";
		$.ajax({
			type	:'POST',
			url		:purl,
			data	:{'folderid':folderid,'title':title,'url':url,'type':2},
			dataType:'text',
			success	:function(data){
				if(data=='success'){
					$("#favorite").html("已收藏");
					$("#favorite").unbind();
				}
			}
		});
	}
$('.togrid').click(function(){
	$('.gridmode').show();
	$('.listmode').hide();
	$('.togrid').addClass('sel');
	$('.tolist').removeClass('sel');
	//top.resetmain();
	resetheight();
	setCookie('ebh_cwsmode','grid');
});
$('.tolist').click(function(){
	$('.listmode').show();
	$('.gridmode').hide();
	$('.tolist').addClass('sel');
	$('.togrid').removeClass('sel');
	//top.resetmain();
	resetheight();
	setCookie('ebh_cwsmode','list');
});
function showcws(tbid){
	if($('#tb'+tbid).css('display')=='none')
		$('#tb'+tbid).show();
	else
		$('#tb'+tbid).hide();
	//top.resetmain();
	resetheight();
}

 
	
var searchtext = "请输入搜索关键字";
$(function(){
	initsearch("title",searchtext);
});
$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext)
			title = "";
		var url = '<?= geturl('myroom/college/study/cwlist/'.$folder['folderid']) ?>' + '?q='+title;
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
		document.location.href = url;
	});
function setCookie(name, value) {
    var exdate = new Date();
	exdate.setTime(exdate.getTime() + (arguments.length>2?arguments[2]:7)*24*60*60*1000);
    // exdate.setDate(exdate.getDate()+(arguments.length>2?arguments[2]:7));
    var cookie = name+"="+encodeURIComponent(value)+"; expires="+exdate.toGMTString();
    cookie += ((arguments.length>3?("; path="+arguments[3]):"") + (arguments.length>4?("; domain="+arguments[4]):""));
    document.cookie = cookie;
}

function getcookie(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null){
        return unescape(arr[2]);
    }else{
        return "";
    }
}

function initsearch(id,value) {
   if($("#"+id).val() == "") {
       $("#"+id).val(value);
       $("#"+id).css("color","#A5A5A5");
   }
   if($("#"+id).val() == value) {
       $("#"+id).css("color","#A5A5A5");
   }
   $("#"+id).click(function(){
       if($("#"+id).val() == value) {
           $("#"+id).val("");
           $("#"+id).css("color","#323232");
       }
   });
   $("#"+id).blur(function(){
       if($("#"+id).val() == "") {
           $("#"+id).val(value);
           $("#"+id).css("color","#A5A5A5");
       }
   });
}

function errorHandler(){
	var cwid = $(this).attr('cwid');
	var size = '178_103';
	var me = this;
	$.ajax({
		type: "POST",
		url: "<?=geturl('imghandler')?>",
		data: {cwid:cwid,size:size,type:'courseware_logo'},
		dataType: "json",
		success: function(data){
			if(data && (data.status == 0) ){
				$(me).attr('src',data.url+'?v=1');//v=1 你猜这是干什么的 O(∩_∩)O哈哈~
			}
			$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
		    $(me).unbind('error');
		},
		error:function(){
			$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
			$(me).unbind('error');
		}
	});
}

//修复学习中心-课程目录列表页高度读取不到bug
function resetheight(){
	var subheight = $(".lefstr").height();
	top.resetmain(subheight);
	//console.log(subheight);
}
</script>
</html>
