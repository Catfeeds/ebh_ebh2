<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
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
</style>

</head>

<body>
<div class="lsitit" >
<div class="lefstr" style="padding-bottom:20px;background:white; width:998px;">
<?php 
if(!empty($folder)){
$this->assign('selidx',0);
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20160422" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
<style>
body{
	background: white;
}
.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
.work_mes a.workbtns{ margin-left:245px;}
</style>
	<?php 
		//$idx = $this->input->get('selidx');
		for($i=0;$i<7;$i++){
			if($i==0)
				$selclass[$i] = 'class="sel"';
			else
				$selclass[$i] = '';
		}
		$itemid = $this->input->get('itemid');
		$itemstr1 = empty($itemid)?'':('?itemid='.$itemid);
		$itemstr2 = empty($itemid)?'':('&itemid='.$itemid);
	?>
	<div class="nav_list">
		<div class="nav_listson">
			<li><a <?=$selclass[0]?> href="<?=geturl('ke/study/cwlist/'.$folder['folderid']) ?>">课程目录</a></li>
			<li><a <?=$selclass[1]?> href="<?=geturl('ke/study/introduce/undercourse/'.$folder['folderid'])?>">课程介绍</a></li>
			<li><a <?=$selclass[5]?> href="<?=geturl('jingpin/cwteacher').'?folderid='.$folder['folderid'] ?>">任课教师</a></li>
			<li><a <?=$selclass[2]?> href="<?=geturl('jingpin/myexam/all').'?folderid='.$folder['folderid']?>">相关作业</a></li>
			<li><a <?=$selclass[3]?> href="<?=geturl('jingpin/myask/all').'?folderid='.$folder['folderid']?>">互动答疑</a></li>
			<li><a <?=$selclass[4]?> href="<?=geturl('jingpin/attachment').'?folderid='.$folder['folderid']?>">资料下载</a></li>
			<li><a <?=$selclass[6]?> href="<?=geturl('ke/surveylist').'?folderid='.$folder['folderid']?>">调查问卷</a></li>
		</div>
	</div>
<?php }else{
	?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20160422" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>

	<?php 
}
$itemid = $this->input->get('itemid');
$showmode = $this->input->cookie('cwsmode');
?>
<div class="kstfrt" style="width:998px;">

<p class="stketi" style="margin-top:0;"></p>

</div>
<!--网格模式-->
<div class="gridmode" style="display:<?=(empty($showmode)||$showmode=='list')?'none':'block'?>">
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

$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
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
			<?php if($enabled){
				$cwurl = empty($itemid)?'/myroom/mycourse/'.$cw['cwid'].'.html':'/ibuy.html?itemid='.$itemid;
				?>
				<a class="kustgd" target="<?=$target?>" href="<?=$cwurl?>" title="<?=$cw['title']?>">
			<?php }else{?>
				<div class="kustgd">
			<?php }?>
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png" />
			
			<?php if($enabled){?>
				</a>
			<?php }else{?>
				</div>
			<?php }?>
			
				<div class="fskpctd">
					<img src="<?=$logo?>" onerror="errorHandler.call(this)" class="imgst" cwid="<?=$cw['cwid']?>">
				</div>
				<!-- ===进度条逻辑开始=== -->
				<div style="border:none;height:16px;" class="kewate" >
					<span style="width:167px;background:none;z-index:2;height:16px;line-height:16px;"><?=$cw['percent']?>%</span>
					<span style="height:16px;z-index:1;width:<?=$cw['percent']?>%;"></span>
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
}}else{?>
<div style="width:998px;text-align:center" class="nonejunr">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"/>
</div>
<?php }?>
</div>
<!--结束-->


<!--列表模式-->
<div class="listmode" style="display:<?=(empty($showmode)||$showmode=='list')?'block':'none'?>">

<?php 
if(!empty($sectionlist)){
foreach($sectionlist as $k=>$section) {
	$keys = array_keys($section);
	?>
	<div style="font-size:16px;font-weight:bold;padding:10px 6px;float:left;width:986px">
		<a href="javascript:void(0)" style="color:#18a8f7;text-decoration:none" onclick="showcws('2c<?=$k?>')"><?=$section[$keys[0]]['sname']?>(<?=count($sectionlist[$k])//$section[0]['sectioncount']?>)</a>
	</div>
	<ul id="tb2c<?=$k?>">
	<?php
	$enabled = true;
	$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
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
		$defaulturl = ($cw['sex'] == 1)?$base_avatar."t_woman.jpg" : $base_avatar."t_man.jpg";
		$face = empty($cw['face']) ? $defaulturl : $cw['face'];
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
<img style="border-radius:25px;" src="<?=$face?>" />
<p><?=$cw['realname']?></p>
</div>
<div class="ettyusr">
<?php if($enabled){
	$date = Date('Y-m-d',$cw['dateline']);
	$datenow = date('Y-m-d');
	$cwurl = empty($itemid)?'/myroom/mycourse/'.$cw['cwid'].'.html':'/ibuy.html?itemid='.$itemid;
	?>
<a class="fusrets" style="color:<?= $date==$datenow?'red':'#666'?>"  href="javascript:void">
	<img src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>"/>
</a>
<img src="<?=$logo?>" />
<?php }?>
</div>
<div class="sktgte">
<?php if($cw['attachmentnum'] > 0) { ?>
	<i class="fujianico" title="此课件包含附件" ></i>
<?php } ?>
<?php if($cwtype=='live'){?>
<i class="label-live" title="直播课件">直播</i>
<?php }?>

<?php if($enabled){
	
	if((empty($limitdate) || $cw['dateline']>$limitdate) && SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){
	?>
<?=$cw['title']?>
	<?php }elseif(SYSTIME<$cw['submitat'] || !empty($cw['endat'])){?>
	<s>
	<?=$cw['title']?>
	</s>
	<?php }else{?>
		<span style="color:#B5B2B2">
		<?=$cw['title']?>
		</span>(往期课件)
	<?php }?>
	
<?php }else{?>
<span style="color:#ccc" onmouseover="$('#studyalert2c<?=$cw['cwid']?>').show()" onmouseout="$('#studyalert2c<?=$cw['cwid']?>').hide()"><?=$cw['title']?></span>
<?php }?>

<span class="ksytde">


	<?php if(SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
		<?=timetostr($cw['dateline'])?> 发布 
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
		<span class="<?=$enabled?'disbl':''?>">已于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束! </span>
	<?php }?>
					
					
</span><span class="ksytde">人气：<?=$cw['viewnum']?></span><?=empty($cw['reviewnum'])?'':'评论：'.$cw['reviewnum']?>
<p><?=$cw['summary']?></p>
</div>
</li>
<?php 
if($folder['playmode'] == 1 && ($cw['percent'] != 100 || !empty($cw['disabled'])))
	$enabled = false;
}
?>
	</ul>
<?php 
}}else{?>
<div style="width:998px;text-align:center" class="nonejunr">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"/>
</div>
<?php }?>
</div>
<!--结束-->



</div>


</div>
</body>
<script>

var init;
$(function(){
	
	
	// <?php if(empty($myfavorite)) { ?>
	// 	$("#favorite").html("收藏");
	// 	$("#favorite").unbind().click(function(){
	// 		$("#favorite").html("已收藏");
	// 		$("#favorite").removeClass('shoutie');
	// 		$("#favorite").addClass('yishout');
	// 		$("#favorite").removeAttr('onclick');
	// 		addfavorite('<?= $folder['folderid'] ?>','<?= $folder['foldername']?>',location.href);
	// 	});
	// <?php } else { ?>
	// 	$("#favorite").html("已收藏");
	// 	$("#favorite").removeClass('shoutie');
	// 	$("#favorite").addClass('yishout');
	// <?php } ?>
	
	
	var showmode = getcookie('ebh_cwsmode');
	if(showmode!=''){
		$('.to'+showmode).click();
	}
		
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
});
// function addfavorite(folderid,title,url){
// 		var purl = "<?= geturl('myroom/favorite/add')?>";
// 		$.ajax({
// 			type	:'POST',
// 			url		:purl,
// 			data	:{'folderid':folderid,'title':title,'url':url,'type':2},
// 			dataType:'text',
// 			success	:function(data){
// 				if(data=='success'){
// 					$("#favorite").html("已收藏");
// 					$("#favorite").unbind();
// 				}
// 			}
// 		});
// 	}
$('.togrid').click(function(){
	$('.gridmode').show();
	$('.listmode').hide();
	$('.togrid').addClass('sel');
	$('.tolist').removeClass('sel');
	top.resetmain();
	setCookie('ebh_cwsmode','grid');
});
$('.tolist').click(function(){
	$('.listmode').show();
	$('.gridmode').hide();
	$('.tolist').addClass('sel');
	$('.togrid').removeClass('sel');
	top.resetmain();
	setCookie('ebh_cwsmode','list');
});
function showcws(tbid){
	if($('#tb'+tbid).css('display')=='none')
		$('#tb'+tbid).show();
	else
		$('#tb'+tbid).hide();
	top.resetmain();
}

// var searchtext = "请输入搜索关键字";
// $(function(){
// 	initsearch("title",searchtext);
// });
// $("#ser").click(function(){
// 		var title = $("#title").val();
// 		if(title == searchtext) 
// 			title = "";
// 		var url = '<?= geturl('myroom/college/study/cwlist/'.$folder['folderid']) ?>' + '?q='+title;
// 		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
// 		document.location.href = url;
// 	});
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
</script>
</html>
