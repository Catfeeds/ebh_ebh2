<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>选课中心</title>
</head>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=20160322"/>

<style>
html,body {background:#f9f9f9;}
.see{ background: #fff;border: 1px solid #e2e2e2;display: inline-block;left: 10px;padding: 10px 20px 20px;margin-top:10px;width: 919px;}
.see .titled{ font-size:24px; color:#333; text-align:center;}
.see .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;}
#actor p{
	display:none!important;
}

.append_new{
	float:left;
}
.cannotpaybtn{
	background:#888;
	cursor:default;
    border: none;
    color: #FFFFFF;
    font-size: 14px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    width: 77px;
    margin-top: 60px;
}
.krtfel .li{
	line-height:28px;
	font-family: 微软雅黑;
	font-size: 16px;
	color: #626262;
}
.salb{
	width:719px;
}
.salb .enidet,.salb .enidets{
	width:717px;
}
.salb .paybtn{
	float:right!important;;
	margin-right:10px!important;
}
.salb .rigxiaox, .salb .fottpp{
	width:460px!important;
}
.salb .zhutk{
	width:450px!important;
}
.salb .viewnumblock{
	position:absolute;
	right:150px;
	bottom:14px;
}
.salb .longimg{
	width:240px!important;
}
.salb .longsummary,.salb .longsummary .fottpp{
	width:550px!important;
}
.salb .kjname{
	width:700px;
}
.sbs{
	display:none;
}
.leraten a {
	color:#299de6;
}
.krtfel {background:#fff;}
.ryfrig .lefzong .xiaotiter{ height:21px; line-height:21px;padding-bottom:10px; }
</style>

<body>
<?php $this->display('shop/drag/topbar');?>
	
    <div class="banner" style="background:none;height:auto">
	<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
		<?php $navlib = Ebh::app()->lib('Navigator');
		$navlib->getnavigator();
		?>
	<div style="clear:both;"></div>
	
<div class="kehtty">
	<?php 
	$spshowcount = 0;
	if(!empty($splist)){?>
    <div class="krtfel" style="border:none;">
	
		<ul>
		<?php 
		$i = 0;
		foreach($splist as $spkey=>$sp) { 
			if(!empty($sp['itemlist'])) {
			?>
			<div class="lawit" style="<?= $i == 0 ?'':'margin-top:8px;'?>">
			<div  id="sp_<?= $sp['pid'] ?>" class="sp_div li <?= $i == 0 ?'leraten':''?>">
				<a href="javascript:void(0)"><?= $sp['pname'] ?></a>
			</div>
			</div>
			
			<!--
			<div class="dianst"><a href="#">水墨基础班</a></div>
        <div class="bistfe">少儿绘画基础班</div>
		-->
		<?php 
			$sid = 0;
				foreach($sp['itemlist'] as $item){
					if($item['sid'] != $sid){
						$sid = $item['sid'];
					?>
					<div class="dianst ss_div" id="ss_<?=$item['sid']?>" spid="<?= $sp['pid'] ?>"><a href="javascript:void(0)"><?= empty($item['sname'])?'其他分类':$item['sname'] ?></a></div>
					<?php
					}
				}
			}
		$i ++;
		} ?>
		</ul>
    </div>

    <div class="ryfrig">
	<div class="lefzong">
    <?php 
	$i = 0;
	//foreach($termlist as $splist){
	$spstr = '';
	foreach($splist as $spkey=>$sp) { 
		if(empty($sp['itemlist']) || !is_array($sp))
			continue;
		$spshowcount ++;
		
$spstr.='<div id="itempid_'.$sp['pid'].'" class="append_new " '.($i == 0? '' : 'style="display:none;"' ).' >';

	$itemi = 0;
	$lastsid = '';
	foreach($sp['itemlist'] as $k=>$item) {
		$furl = '';
		if($item['fprice'] == 0 || isset($mylist[$item['folderid']])) {
			if(empty($room['iscollege']))
				$furl = '/myroom/stusubject/'.$item['folderid'].'.html';
			else
				$furl = '/myroom.html?url=/myroom/college/study/cwlist/'.$item['folderid'].'.html';
		} else {
			
			$furl = '/ibuy.html?itemid='.$item['itemid'];
			if(!empty($item['sid']) && isset($sortlist[$item['sid']])) {
				$furl .= '&sid='.$item['sid'];
			}
			if($room['domain'] == 'yxwl') {	//易学yxwl
				$furl = '/classactive/bank.html';
			}
		}
		
		
		if($item['sid']!=$lastsid){
			$itemcount = count($sp['itemlist']);
			$speakers = '';
			for($i=$k;$i<$itemcount;$i++){
				if($item['sid'] == $sp['itemlist'][$i]['sid'])
					$speakers .= ' '.$sp['itemlist'][$i]['speaker'];
				else
					break;
			}
			
			if(empty($item['showbysort'])){
		$spstr .= '
		<h2 class="xiaotiter zizhans itemsid_'.$item['sid'].'" style="float:left">
			<span style="float: left; width: 719px;color:blue">'.(empty($item['sname'])?(empty($sp['itemlist'][0]['sname'])==1?'所有课程':'其他课程'):$item['sname']).'</span>
		</h2>';
			}else{
				
				
				if(empty($user))
					$fsurl = 'href="javascript:void(0);"class="dologin" name="/ibuy.html?sid='.$item['sid'].'"';
				elseif($user['groupid'] == 6)
					$fsurl = 'href="/ibuy.html?sid='.$item['sid'].'" target="_blank"';
				else
					$fsurl = 'href="javascript:void(0);" onclick="alert(\'对不起，您是教师账号，不允许进行此操作。\')"';
				
			
			
		$spstr.='
	<div class="huanqiu linewline zizhans itemsid_'.$item['sid'].'" style="width:719px;margin:0;height:195px; padding-bottom:10px;">
		<div onmouseover="this.className=\'enidets\'" onmouseout="this.className=\'enidet\'" class="enidet" style="width:717px;height:190px;">
		<div style="display:inline;width:230px;height:170px;" class="dettu" >
		<a href="javascript:void(0)" onclick="showundersort('.$item['sid'].')">
		<img width="230" height="170" style="opacity: 1;" src="'.$item['simg'].'">
		</a>
		</div>
<div class="rigxiaox" style="width:460px;">
		<h3 class="kjname" style="width:440px;">
		<a style="color:blue;font-size:16px;" href="javascript:void(0)" onclick="showundersort('.$item['sid'].')" title="'.$item['sname'].'">'.$sp['pname'].' '.$item['sname'].'</a>
		</h3>
	<p><a class="zhutk" style="width:460px;" href="javascript:void(0)" onclick="showundersort('.$item['sid'].')">'.$speakers.'</a></p>
	<div class="fottpp" style="width:460px;font-size:13px;">'.$item['content'].'</div>

		</div>
				<a '.$fsurl.' style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: right;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;margin-right:10px;">报 名</a>
				</div>
		</div>';
			
			}
		$lastsid = $item['sid'];
		$itemi = 0;
		}
		if(empty($user)) {
			$sbsstr = '';
			if($item['showbysort']==1)
				$sbsstr = 'sbs sbs'.$item['sid'];
			$salbstr = '';
			if($item['showaslongblock']==1)
				$salbstr = ' salb ';
			$longimg = true;
			if(empty($item['longblockimg']) || empty($item['showaslongblock']))
				$longimg = false;
	$spstr .='
		<div class="huanqiu linewline zizhans itemsid_'.$item['sid'].' '.$sbsstr.$salbstr.'" '. ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') .'>
		<div class="enidet" onmouseout="this.className=\'enidet\'" onmouseover="this.className=\'enidets\'" style="position:absolute">
		<h3 class="kjname">
		<a href="'. geturl('courseinfo/'.$item['itemid']) .'" target="_blank" title="'. $item['iname'] .'" class="" name="'. $furl .'">'. $item['iname'] .'</a>
		</h3>
		<div class="dettu '.(!$longimg?'':'longimg').'" style="display:inline;">
		<a class="" target="_blank" href="'. geturl('courseinfo/'.$item['itemid']) .'" name="'. $furl .'">';
		if(!$longimg){
			$spstr .= '<img width="114" height="159" src="'.(empty($item['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' :$item['img']).' " style="opacity: 1;">';
		}else{
			$spstr .= '<img width="230" height="159" src="'.$item['longblockimg'].' " style="opacity: 1;">';
		}
	$spstr .='	</a>
		</div>
	<div class="rigxiaox '.($longimg?'':'longsummary').'" style="font-size:13px;">
	<p><a href="'. geturl('courseinfo/'.$item['itemid']) .'" target="_blank" class="zhutk">'.(!empty($item['speaker'])?$item['speaker']:'').'</a></p>
	<p class="fottpp">'. ssubstrch($item['isummary'],0,empty($item['showaslongblock'])?150:300) .'</p>

		</div>
		<div class="viewnumblock" style="width:90px;height:40px;float:left;display:block">
		';
			$viewnumlib = Ebh::app()->lib('Viewnum');
			$viewnum = $viewnumlib->getViewnum('folder',$item['folderid']);
		
		 if(!empty($item['coursewarenum']) && !empty($viewnum)){
		$spstr.='	<p class="botthui" style="width:82px;">
	课 时：
	<span>'. $item['coursewarenum'].'</span>
	</p>
	<p class="botthui">
	人 气：
	<span>'. $viewnum.'</span>
	</p>';
	}
	$spstr.='
	</div>';
		if($item['fprice']==0) { 
		$spstr.='
		<a href="javascript:void(0);" class="paybtn dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;border-radius:5px;">试听课程</a>
		'; } else { 
			if(empty($item['cannotpay'])){
				$spstr.='<a href="javascript:void(0);" class="paybtn dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;border-radius:5px">报 名</a>';
			}else{
			$spstr.='
			<a href="javascript:void(0);" class="paybtn dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #888888;color: #ffffff;cursor: default;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #888888;margin-top:10px;border-radius:5px">报 名</a>
			'; }
		} 
	$spstr .='
		</div>
		</div>';
	
		} else {
			if($user['groupid'] != 6) {
				$isteacher = 1;
				$furl = "javascript:alert('对不起，您是教师账号，不允许进行此操作。');";
			}
			$sbsstr = '';
			if($item['showbysort']==1)
				$sbsstr = 'sbs sbs'.$item['sid'];
			$salbstr = '';
			if($item['showaslongblock']==1)
				$salbstr = ' salb ';
			$longimg = true;
			if(empty($item['longblockimg']) || empty($item['showaslongblock']))
				$longimg = false;
	$spstr .='
	<div class="huanqiu linewline zizhans itemsid_'.$item['sid'].' '.$sbsstr.$salbstr.'" '. ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') .'>
		<div class="enidet" onmouseout="this.className=\'enidet\'" onmouseover="this.className=\'enidets\'" style="position:relative">
		<h3 class="kjname">
		<a title="'. $item['iname'] .'" target="_blank" href="'. geturl('courseinfo/'.$item['itemid']) .'">'.$item['iname'].'</a>
		</h3>
		<div class="dettu '.(!$longimg?'':'longimg').'" style="display:inline;">
		<a class="" target="_blank" href="'. geturl('courseinfo/'.$item['itemid']) .'">';
		if(!$longimg){
			$spstr .= '<img width="114" height="159" src="'.(empty($item['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' :$item['img']).' " style="opacity: 1;">';
		}else{
			$spstr .= '<img width="230" height="159" src="'.$item['longblockimg'].' " style="opacity: 1;">';
		}
	$spstr .='	</a>
		</div>
<div class="rigxiaox '.($longimg?'':'longsummary').'">
	<p><a href="'. geturl('courseinfo/'.$item['itemid']) .'" target="_blank" class="zhutk">'.(!empty($item['speaker'])?$item['speaker']:'').'</a></p>
	<p class="fottpp">'. ssubstrch($item['isummary'],0,empty($item['showaslongblock'])?150:300) .'</p>


		</div>
		<div class="viewnumblock" style="width:90px;height:40px;float:left;display:block;">
		';
			$viewnumlib = Ebh::app()->lib('Viewnum');
			$viewnum = $viewnumlib->getViewnum('folder',$item['folderid']);
		 if(!empty($item['coursewarenum']) && !empty($viewnum)){
		$spstr.='
		<p class="botthui" style="width:82px;">
	课 时：
	<span>'. $item['coursewarenum'].'</span>
	</p>
	<p class="botthui">
	人 气：
	<span>'. $viewnum.'</span>
	</p>
	'; }
	$spstr.='
	</div>';
		 if($item['fprice']==0) { 
		 $spstr.='
		<a class="paybtn" href="'. $furl .'" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;border-radius:5px;">试听课程</a>
		';} else { 
			if(!isset($mylist[$item['folderid']])) {
				if(empty($item['cannotpay'])){
					$spstr.='<a class="paybtn" href="'. $furl .'" '.(empty($isteacher)?'target="_blank"':'').' style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;border-radius:5px;">报 名</a>';
				}else{
					$spstr.='
					<a class="paybtn" href="javascript:void(0)" '.(empty($isteacher)?'target="_blank"':'').' style="background: none repeat scroll 0 0 #888888;color: #ffffff;cursor: default;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #888888;margin-top:10px;border-radius:5px;">报 名</a>
				'; }
			} else {
			$spstr .='
		<a class="paybtn" href="'. $furl .'" '.(empty($isteacher)?'target="_blank"':'').'target="_blank" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;border-radius:5px;">进 入</a>
		'; } 
		}
		$spstr.='
		</div>
		</div>';
			}
		$itemi ++;
		}
$spstr .='
</div>'; 
	$i ++;
	}
	echo $spstr;
	?>
    </div>
	</div>
	<?php }else{ ?>
<img src="http://static.ebanhui.com/ebh/tpl/default/images/wuzizhan2.jpg" />
<?php } ?>
</div>
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->
<script>
var curid = 0;
$(function(){
	$(".dologin").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
	$(".sp_div").click(function(){
		var sp_id = $(this).attr("id");
		if(sp_id != "" && sp_id != undefined) {
			sp_id = sp_id.substring(3);
			// if(sp_id != curid) {
				$(".sp_div").removeClass("leraten");
				$(".ss_div").removeClass("leraten");
				$(this).addClass("leraten");
				$(".append_new").hide();
				$(".zizhans:not(.sbs)").show();
				$("#itempid_" + sp_id).show();
				// curid = sp_id;
			// }
			setCookie('ebh_spselected',sp_id);
		}
	});
	$('.ss_div').click(function(){
		var ss_id = $(this).attr('id');
		var sp_id = $(this).attr('spid');
		ss_id = ss_id.substring(3);
		$(".sp_div").removeClass("leraten");
		$(".ss_div").removeClass("leraten");
		$(this).addClass("leraten");
		$(".append_new").hide();
		$(".zizhans").hide();
		$("#itempid_" + sp_id).show();
		$(".itemsid_" + ss_id+":not(.sbs)").show();
		setCookie('ebh_spselected',sp_id);
		// console.log(ss_id);
	});
	
	
	var spcounthistory =  getcookie('ebh_spcount');
	if(spcounthistory == '' || spcounthistory != <?=$spshowcount?>){
		setCookie('ebh_spcount',<?=$spshowcount?>);
		setCookie('ebh_spselected','');
	}else{
		var historyspid = getcookie('ebh_spselected');
		if(historyspid!=''){
			$("#sp_"+historyspid).click();
		}
	}
});
function showundersort(sid){
	var showed = $('.sbs'+sid).css('display');
	if(showed == 'none')
		$('.sbs'+sid).show();
	else
		$('.sbs'+sid).hide();
}
var tologin = function(url){
	url = url.replace('__url__',encodeURIComponent(location.href));
	location.href=url;
}
var toregister = function(url){
	url = url.replace('__url__',encodeURIComponent(location.href));
	location.href=url;
}
</script>
<?php $this->display('common/footer')?>
