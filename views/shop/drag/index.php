<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript">
		if (self != top) {
			top.location.href = "/";
		}
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?= empty($systemsetting['metakeywords']) ? $roomdetail['crlabel'] : $systemsetting['metakeywords'] ?>" />
<meta name="description" content="<?= empty($systemsetting['metadescription']) ? $roomdetail['summary'] : $systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$roomdetail['crname']?></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2016092701"/>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/courses/css/jisrn.css" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>"></script>
<style>
.scroll_div {width:958px;margin:0 auto;overflow: hidden;white-space: nowrap;height:38px}
#scroll_begin, #scroll_end, #scroll_begin ul, #scroll_end ul, #scroll_begin ul li, #scroll_end ul li{display:inline;}
#scroll_begin ul li {margin-left:15px;}
.mo{height:auto;}
.mo h1{background:#ECF9FF;height:18px;cursor:move}
.mo .nr{height:80px;}
.gyxjkcs {
    background-color: #ffffff;
    height: auto;
    width: 679px;
	padding:20px;
}
.sbs{
	display:none;
}
.mb10{
	margin-bottom:10px;
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
.biaoqians a{
	cursor:default;
	text-decoration:none;
	max-width:166px;
	line-height:28px;
	height:28px;
	overflow:hidden;
	padding-top:0!important;
	padding-bottom:0!important;
	word-break:break-all;
}
#actor p{
	display:none!important;
}

ul, li,div{word-wrap: normal;}
.wxzixun,.newsdongtai{position:relative;}
.kcbj img{
	width:167px;
	height:100px;
}
#edrghgh a.fenstbtn {
	float:left;
	display:block;
	width:50%;
	height:149px;
}
.freesees_son ul li img {
	width:167px;
	height:100px;
	float:left;
}
.freesees_son .shichang {
	left:0px;
}
.freesees_son a.opens {
	top:0px;
	left:0px;
}
.freesees_son a.opens:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png) no-repeat;
	cursor: pointer;
}
.jisrtde {
	width:717px;
    background:#fff;
}
.jisrtde .dkmars {
    margin: 0 4px 20px 3px;
    padding: 0px;
}
.iuhni:hover {
    border-color: #fff;
    box-shadow: 0px 0px 0px 0px #fff;
}
.wrnssrs {
	top:118px;
	left:0px;
}
.enidet, .enidets{
	overflow:hidden;
}
</style>

<?php
function inflate($view,$context) {
    $viewpath = VIEW_PATH.$view.'.php';
    if(!file_exists($viewpath)) {
        echo 'error view not exists:'.$viewpath;
        return;
    }
    ob_start();
    if(is_object($context)){
        $context = (array)$context;
    }
    extract($context);
    include $viewpath;
    $outputstr = ob_get_contents();
    @ob_end_clean();
    return $outputstr;
}
//动态资讯
$mitemstr = '';
if(!empty($mitemstr_s)){
	$mitemstr = '<div class="mo" id="m0">
					<div class="wxzixun mb10" >
					<div class="title" style="width:230px;"><span class="span2s">网校资讯</span></div>
						<div>
							<ul class="mt10">';
	foreach($mitemlist as $mitem){
		$mitemstr .= '<li title="'.$mitem['subject'].'"><a target="_blank" href="/dyinformation/'.$mitem['itemid'].'.html">'.$mitem['subject'].'</a></li>';
	}
	$mitemstr .= '</ul>
					</div>
					<div><a href="/dyinformation.html" target="_blank" style="position:absolute;bottom:5px;right:8px;color: #18a8f7;display: block;height: 25px;  width:60px; border:none;cursor:pointer;text-align:center;line-height:25px">更多>></a></div>
				</div>
				</div>';
}
//新闻动态
$newsstr = '';
if(!empty($newsstr_s)){
	$newsstr = '<div class="mo" id="m1">
					<div class="newsdongtai mb10">
					
						<div class="title" style="width:230px;"><span class="span2s">新闻动态</span></div>
						<div>
							<ul class="mt10">
							';
	foreach($newslist as $news){
		$newsstr.='<li title="'.$news['subject'].'"><a target="_blank" href="/dyinformation/o/'.$news['itemid'].'.html">'.$news['subject'].'</a></li>';
	}
	$newsstr.=						'
							</ul>
						</div>
					</div>
					</div>';
}
//广告
$adstr = '';
if(!empty($adstr_s)){
$adstr = '<div  class="mo" id="m2">
                <div class="weike ml10 mb10">'.inflate('widget/ad_widget',array('data'=>$adlistm,'property'=>array('_width'=>'478','_height'=>'240','_id'=>'headf','default'=>'http://static.ebanhui.com/ebh/tpl/2014/images/adcenter.jpg'))).'</div>
				</div>';
}

//学校介绍
$roomstr = '';
if(!empty($roomstr_s)){
$roomstr = '<div class="mo" id="m3">
                <div class="xiaoshanjs ml10 mb10">
                	<div class="title" style="width:480px;"><span class="span2s">'.$roomdetail['crname'].'</span></div>
                    <div class="xiaoshanjs_son" style="height:200px">
                    	<div class="xiaoshanjs_sonl fl">
                        	<div><img src="'.(empty($roomdetail['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$roomdetail['cface']).'" width="100" height="100" /></div>
                            
                        </div>
                        <div class="xiaoshanjs_sonr fl">
                        	<p>'.shortstr($roomdetail['summary'],400).'</p>
                        </div>
                    </div>
                </div>
				</div>';
}
//用户登录
$loginstr = '';
if(!empty($loginstr_s)){
	if(empty($user)){
	    $othersetting = Ebh::app()->getConfig()->load('othersetting');
	    //是否禁用用户注册功能
	    $open_register = true;
	    if (isset($othersetting['dis_registerable']) && is_array($othersetting['dis_registerable']) && in_array($roomdetail['crid'], $othersetting['dis_registerable'])) {
            $open_register = false;
        }
	$loginstr = '
	<div class="mo" id="m4">
	<div class="yhdl mb10">
					<div class="title"><span class="span2s">用户登录</span></div>
					<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
					<input type="hidden" name="loginsubmit" value="1" />				
					<div><input value="请输入账号" name="username" id="username" class=" mt10" onfocus="if ($(this).val() == \'请输入账号\'){$(this).val(\'\').css(\'color\', \'#000000\'); }" onblur="if ($(this).val() == \'\'){$(this).val(\'请输入账号\').css(\'color\', \'#C3C3C3\'); }" maxlength="20"></div>
					<div><input value="" name="password" id="password" type="password" maxlength="20" class="mt10" style="color:#000000"></div>
					 <p class="zidong mt5">
						<input type="checkbox" checked="checked" value="1" name="cookietime" style="vertical-align: middle;" id="cookietime">
						<label class="rybtnat" for="cookietime">下次自动登录</label>
					</p>
					<input type="submit" value="" name="Submit" class="denglubtn logobtn">
					<div style="height:20px; width:210px;'.($open_register?'':'display:none').'" class="qtlol fr">
						<span style="color:#808080;" class="fl">用其他账号登录：</span>
						<a href="' . getopenloginurl('qq',$currentdomain) . '"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg"></a>
						<a href="' . getopenloginurl('sina',$currentdomain) . '"><img src="http://static.ebanhui.com/ebh/tpl/default/images/sianico0925.jpg"></a>
						<a href="' . getopenloginurl('wx',$currentdomain) . '"><img src="https://open.weixin.qq.com/zh_CN/htmledition/res/assets/res-design-download/icon16_wx_logo.png"></a>
					</div>
					<div class="fotlog fl">
						'.($open_register ? '<a href="javascript:void(0)" class="reginpage" style="color:#808080;">用户注册</a> |' : '')
						.'<a href="/forget.html" style="color:#808080;">忘记密码？</a>
					</div>
					</form>
				</div>
			</div>';
	}else{
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
		$troomurl = gettroomurl($room['crid']);
		$url = $user['groupid'] == 6 ? geturl('myroom') : $troomurl;

		$loginstr = '
		<div class="mo" id="m4">
		<div class="yhdl mb10">
		<div class="title"><span class="span2s">用户登录</span></div>
		<div class="tukuang" style="margin-left:20px;margin-top:18px;_margin-left:10px;">
		<img src="'.$facethumb.'"/></div>
		<div style="float:left;margin-top:20px;"><p style="font-weight:bold;font-size:14px; width:100px;height:21px; overflow:hidden;">'.(empty($user['realname'])?$user['username']:$user['realname']).'</p><p>上次登录时间:</p><p>'.$user['lastlogintime'].'</p></div>
		<input class="msjinr" type="submit" name="Submit" value="马上进入" onclick="window.location.href=\''.$url.'\'" />
		
		<div class="fotlog">
		<a href="/logout.html" style="color:#808080;">退出</a>
		</div>
		</div>
		</div>
		';
	}
}
//获取用户名
$getusernamestr = '';
if(!empty($getusernamestr_s)){
	$getusernamestr = '<div class="mo" id="m5">
		<div class="shcidenglu mb10">
            	<div class="title"><span class="span2s">首次登录请点击</span></div>
                <div class="shcidenglu_son "><a href="javascript:void(0)" id="getusername"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/shoucidenglu.png" height="29" width="110" style="border-radius:5px;" /></a></div>
            </div>
		</div>';
}

//热门标签
$hotlabelstr = '';
if(!empty($hotlabelstr_s)){
	if(!empty($roomdetail['crlabel']))
		$labelarr = explode(',',$roomdetail['crlabel']);
	$hotlabelstr = '<div class="mo" id="m6">
				<div class="remenbq mb10">
					<div class="title"><span class="span2s">热门标签</span></div>
					<div class="biaoqians">
						';
						if(!empty($labelarr)){
							foreach($labelarr as $label){
	$hotlabelstr .='		<div class="fl biaoqianson"><a href="javascript:void(0)">'.$label.'</a></div>';
					}
				}
	$hotlabelstr .='	
					</div>
				</div>
			</div>';
}

//开通列表
$opencountstr = '';
if(!empty($opencountstr_s)){
	$opencountstr = '<div class="mo" id="m7">
			<div class="newbaoming mb10">
            	<div class="title"><span class="span2s">最新报名</span></div>
                <div class="newbaomingson">
                	<ul>
                    	';
	$liclass = '';
	foreach($opencountlist as $k=>$opencount){
		$sex = empty($opencount['sex']) ? 'man' : 'woman';
		$facethumb40 = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
		$face40 = empty($opencount['face']) ? $facethumb40 : $opencount['face'];
		$facethumb40 = getthumb($face40,'40_40');

		$rnlength = strlen($opencount['realname']);
		$realname = '*'.mb_substr($opencount['realname'],-($rnlength/3-1),2,'utf-8');
		$oname = shortstr($opencount['oname'],10);
		$listyle = '';
		if($k == 0)
			$listyle = 'margin-top:10px';
		if($k == count($opencountlist)-1)
			$liclass = 'last';
		$opencountstr .='<li class="'.$liclass.'" style="'.$listyle.'">
                        	<div class="fl"><img src="'.$facethumb40.'" width="40" height="40" /></div>
                            <div style="padding-left:10px; line-height:18px;" class="fl">
                            	<span style="color:#0092e2; font-size:12px;">'.shortstr($opencount['username'], 2, '***').substr($opencount['username'],-2).'('.$realname.')'.'</span><br />
                                <p style="color:#999;">开通<span style="color:#333;" title="'.$opencount['oname'].'">'.$oname.'</span>服务</p>
                            </div>
                        </li>';
	}

	$opencountstr .='</ul>
                </div>
            </div>
			</div>';
}

//学员动态
$studystr = '';
if(!empty($studystr_s)){
	$liclass = '';
	$studystr = '
	<div class="mo" id="m8">
            <div class="xydongtai mb10">
            	<div class="title"><span class="span2s">学员动态</span></div>
                <div class="xydongtaison">
                	<ul>
                    	';
	foreach($studylist as $k=>$dyuser){
		$sex = empty($dyuser['sex']) ? 'man' : 'woman';
		// $type = $user['groupid'] == 5 ? 't' : 'm';
		$facethumb40 = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
		$face40 = empty($dyuser['face']) ? $facethumb40 : $dyuser['face'];
		$facethumb40 = getthumb($face40,'40_40');
		// if($i == 4)
			// $liclass = 'last';
		$studystr .= '<li class="'.$liclass.'" '.($k==count($studylist)-1?'style="border-bottom:none"':'').'>
                        	<div>
                                <div class="fl"><img src="'.$facethumb40.'" width="40" height="40" /></div>
                                <div style="padding-left:20px; line-height:40px;" class="fl">
                                    <span style="color:#999; font-size:12px;float:left;width:82px;*width:62px;overflow: hidden; height: 28px;">'.$dyuser['realname'].'</span>
                                    <span style="color:#999; float:right">'.timetostr($dyuser['lastdate'],'m-d').'</span>
									<div class="clear"></div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div><p style="color:#333;"><span style="color:#999;">学习课程 </span>'.shortstr($dyuser['title'],20,'').'</p></div>
                        </li>';
	}
	$studystr .= '
                        
                    </ul>
                </div>
            </div>
			</div>';
}

//积分排名
$creditstr = '';
if(!empty($creditstr_s)){
	$creditstr = '
	<div class="mo" id="m9">
            <div class="jifenlist mb10">
            	<div class="title"><span class="span2s">积分排名</span></div>
                <div class="jifenlistson">
                	<ul>
                    	';
	foreach($creditlist as $credit){
		$sex = empty($credit['sex']) ? 'man' : 'woman';
		// $type = $user['groupid'] == 5 ? 't' : 'm';
		$facethumb50 = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
		$face50 = empty($credit['face']) ? $facethumb50 : $credit['face'];
		$facethumb50 = getthumb($face50,'50_50');
		$creditstr .= '<li class="ml20 fl ">
                        	<div><img src="'.$facethumb50.'" height="50" width="50" /></div>
                            <div class="touxiangt"><span style="color:#fff;">'.shortstr($credit['realname'],6,'').'</span></div>
                            <div style="text-align:center;"><span style="color:#ea732f; position:relative; top:-20px;">'.$credit['credit'].'</span></div>
                        </li>';
	}
	$creditstr .= '</ul>
                </div>
            </div>
			</div>';
}

//课件排名
$cwrankstr = '';
if(!empty($cwrankstr_s)){
	$cwrankstr = '<div class="mo" id="m10">
            <div class="kechengph mb10">
            	<div class="title"><span class="span2s">课程排行榜</span></div>
                <div class="kechengphson">
                	<ul>
                    	';
	foreach($courseranklist as $k=>$cw){
		$rank = $k+1;
		if($rank<10)
			$rank = '0'.$rank;
		$cwrankstr .= '<li title="'.$cw['title'].'"><a href="javascript:void(0)" style="cursor:default"><b style="font-size:14px;font-family:Arial;">'.$rank.'</b>　'.shortstr($cw['title'],24,'').'</a></li>
							';
	}
	$cwrankstr .= '</ul>
                </div>
            </div>
			</div>';
}
//服务包
$spstr = '';
if(!empty($spstr_s)){
	$spcount = 0;
	foreach($splist as $spkey=>$sp) {
		if(!empty($sp['itemlist']) && is_array($sp)) {
			$spcount++;
		}
	}
$spstr = '<div class="mo" style="width:720px;float:left" id="m11">
		<div class="clear"></div>
		
       <div class="zizhan" style="'.($spcount>1?'':'display:none').'">
	<div class="fewof">
		<ul>
	';
	$i = 0;
	$inittid = 0;
		foreach($splist as $spkey=>$sp) {
			if(!empty($sp['itemlist']) && is_array($sp)) {
	$spstr .='
			<li class="tsub" '.( ($inittid !=0) ? 'style="display:none;"':'').'>
			<div itype="'.$sp['itype'].'" id="sp_'.$sp['pid'].'" class="sp_div '.($i == 0 ?'leraten':'').'">
				<a href="javascript:void(0)" >'. ssubstrch($sp['pname'],0,24).'</a>
			</div>
			</li>';
		$i ++;
			}
		}
$spstr .='
		</ul>
	</div>
</div>';




	$i = 0;
	//foreach($termlist as $splist){
	$spshowcount = 0;
	foreach($splist as $spkey=>$sp) {
		if(empty($sp['itemlist']) || !is_array($sp) || $sp['itype'] == 1)
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
			elseif($item['showmode'] == 3)
				$furl = '/myroom/college/study/introduce/'.$item['folderid'].'.html';
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
		<h2 class="xiaotiter" style="float:left">
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
	<div class="huanqiu linewline" style="width:719px;margin:0;height:195px;">
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
		<div class="huanqiu linewline '.$sbsstr.$salbstr.'" '. ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') .'>
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
	<p class="fottpp">'. shortstr($item['isummary'],empty($item['showaslongblock'])?110:300) .'</p>

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
		<a href="javascript:void(0);" class="paybtn dologin" name="'. $furl .'" '.(empty($isteacher)?'':'').' style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;border-radius:5px;">试听课程</a>
		'; } else {
			if(empty($item['cannotpay'])){
				$spstr.='<a href="javascript:void(0);" class="paybtn dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;border-radius:5px;">报 名</a>';
			}else{
			$spstr.='
			<a href="javascript:void(0);" class="paybtn dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #888888;color: #ffffff;cursor: default;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #888888;margin-top:10px;border-radius:5px;">报 名</a>
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
	<div class="huanqiu linewline '.$sbsstr.$salbstr.'" '. ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') .'>
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
	<p class="fottpp">'. shortstr($item['isummary'],empty($item['showaslongblock'])?110:300) .'</p>


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
		<a class="paybtn" href="'. $furl .'" '.(empty($isteacher)?'target="_blank"':'').' style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;border-radius:5px;">试听课程</a>
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
		<a class="paybtn" href="'. $furl .'" '.(empty($isteacher)?'target="_blank"':'').' style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;border-radius:5px;">进 入</a>
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

$spstr.='</div>';
}


//分离精品课堂模板
$viewnumlib = Ebh::app()->lib('Viewnum');
if (!empty($splist)){
	foreach ($splist as $skey=>$sp){
		if($sp['itype'] == 0 || !is_array($sp) || empty($sp['itemlist'])){
			continue;
		}
		$spstr .= '<div class="mo" style="width:720px;float:left;">
				   <div class="jisrtde" id="itempid_'.$sp['pid'].'" style="margin-top:0;display:none">';
		foreach ($sp['sids'] as $jkey=>$jsname){
			$jpsname = empty($jsname) ? '其他课程' : $jsname;
			$spstr .= '
				   <h2 class="xiaotiter" style="float:left;background:#f9f9f9;margin-bottom:5px">
				   <span style="float: left; width: 719px;color:blue">'.$jpsname.'</span>
				   </h2>
	        	<ul>';
			$jingpinlist = '';
			foreach ($sp['itemlist'] as $jplist){
				if($jplist['sid'] != $jkey){
					continue;
				}
				if($jplist['iprice'] == 0 || isset($mylist[$jplist['folderid']])) {
					if(empty($room['iscollege'])){
						$ffurl = '/myroom/stusubject/'.$item['folderid'].'.html';
					}elseif($jplist['showmode'] == 3){
						$ffurl = '/myroom/college/study/introduce/'.$jplist['folderid'].'.html';
					}else{
						$ffurl = '/myroom.html?url=/myroom/college/study/cwlist/'.$jplist['folderid'].'.html';
					}
				} else {
					$ffurl = '/ibuy.html?itemid='.$jplist['itemid'];
					if(!empty($jplist['sid']) && isset($sortlist[$jplist['sid']])) {
						$ffurl .= '&sid='.$jplist['sid'];
					}
					if($room['domain'] == 'yxwl') {	//易学yxwl
						$ffurl = '/classactive/bank.html';
					}
				}
				//购买按钮
				if(empty($user)){
					$fbbtn = '<a class="paybtn dologin" href="javascript:void(0);" name="/ibuy.html?sid='.$jplist['sid'].'" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 24px;line-height: 24px;text-align: center;text-decoration: none;width: 80px;font-size:14px;border:solid 1px #d6682a;margin-top:0px;margin-left:50px;border-radius:5px;">报 名</a>';
				}elseif($user['groupid'] == 6){
					if(!isset($mylist[$jplist['folderid']])) {
						if(!empty($item['cannotpay'])){
							$fbbtn ='<a class="paybtn" href="javascript:void(0)"'.' style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;border-radius:5px;">报 名</a>';
						}else{
							if($jplist['iprice'] == 0){
								$fbbtn = '<a class="paybtn" href="'.$ffurl.'" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 24px;line-height: 24px;text-align: center;text-decoration: none;width: 80px;font-size:14px;border:solid 1px #0d9be9;margin-top:0px;margin-left:50px;border-radius:5px;">进 入</a>';
							}else{
								$fbbtn = '<a class="paybtn" href="/ibuy.html?itemid='.$jplist['itemid'].'&sid='.$jplist['sid'].'" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 24px;line-height: 24px;text-align: center;text-decoration: none;width: 80px;font-size:14px;border:solid 1px #d6682a;margin-top:0px;margin-left:50px;border-radius:5px;">报 名</a>';
							}
						}
					}else{
						$fbbtn = '<a class="paybtn" href="'.$ffurl.'" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 24px;line-height: 24px;text-align: center;text-decoration: none;width: 80px;font-size:14px;border:solid 1px #0d9be9;margin-top:0px;margin-left:50px;border-radius:5px;">进 入</a>';
					}
				}else{
					$fbbtn = '<a class="paybtn" href="javascript:void(0);" onclick="alert(\'对不起，您是教师账号，不允许进行此操作。\')"'.' class="dologin" name="/ibuy.html?sid='.$jplist['sid'].'" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 24px;line-height: 24px;text-align: center;text-decoration: none;width: 80px;font-size:14px;border:solid 1px #d6682a;margin-top:0px;margin-left:50px;border-radius:5px;">报 名</a>';
				}
				$viewnum = $viewnumlib->getViewnum('folder',$jplist['folderid']);
				$viewnum = $viewnum == false || empty($viewnum) ? 0 : $viewnum;
				$jingpinlist .='
	            	<li class="iuhni dkmars">
	                	<a target="_blank" class="kuetgf" href="/courseinfo/'.$jplist['itemid'].'.html">
	                    	<img width="230px" height="136px" src="'.(empty($jplist['longblockimg']) ? 'http://static.ebanhui.com/ebh/tpl/courses/images/shtisut.jpg' : $jplist['longblockimg']).'">
	                    </a>
	                    <span class="wrnssrs">共'.$jplist['coursewarenum'].'课时</span>
	                    <h2 class="klejts"><a title="'.$jplist['iname'].'" href="/courseinfo/'.$jplist['itemid'].'.html">'.shortstr($jplist['iname'],50).'</a></h2>
	                    <span class="renares">'.$viewnum.'</span>
	                    <span class="euitsd">'.shortstr($sp['crname'],24).'</span>'.($jplist['iprice'] > 0 ? '<p class="lsirse">￥'.$jplist['iprice'].'</p>' : '<p class="lbsrver">免费</p>').
			                    '<div class="egbdet">'
			                    		.$fbbtn.
			                    		'</div>
	                </li>';
			}
			$spstr .= $jingpinlist.'</ul>';
		}
		$spstr .= '</div></div>';
	}
}

//微信二维码
$wechatstr = '';
if(!empty($wechatstr_s)){
	$wechatstr = '<div class="weixingzh mb10">
            	<div class="title"><span class="span2s">微信公众号</span></div>
                <div class="weixingzh_son "><img width="190" height="190" src="'.(empty($roomdetail['wechatimg'])?'http://static.ebanhui.com/ebh/tpl/2014/images/ebh_wx.png':$roomdetail['wechatimg']).'"></div>
            </div>';
}
//自定义富文本
$custommessagestr = '';
if(!empty($custommessagestr_s)){
$custommessagestr = '<div class="fl mo" id="m14">
			<div style="position:relative;" id="cmblock">
				<div class="gyxjkcs mb10">
						'.(empty($custommessage[0]['custommessage'])?'':$custommessage[0]['custommessage']).'
				</div>
			</div>
			</div>';
}

//应用
$appstr = '';
if(!empty($appstr_s)){
	$appstr = '<div class="mo" id="m15">
			<div class="appd mb10">
            	<div class="title"><span class="span2s">应用</span></div>
                <div class="appd_son">';
	if(!empty($applist)){
	foreach($applist as $k=>$app){
		($k == 0)?$marginclass = 'first': $marginclass ='mt10';
		$appstr .= '<div class="'.$marginclass.' appd_sons">
						<div class="fl tupian">
						<a target="_blank" href="'.$app['url'].'" title="'.$app['title'].'"><img width="32" height="32" src="'.(empty($app['img'])?'http://static.ebanhui.com/ebh/tpl/2014/images/app.png':$app['img']).'"></a></div>
						<a target="_blank" href="'.$app['url'].'" title="'.$app['title'].'" class="fl biaoti"><p>'.$app['title'].'</p></a>
					</div>';
		}
	}
	$appstr .= '</div>
			
		</div>
	</div>';
}

//免费试看片
$freeviewstr = '';
if(!empty($freeviewstr_s)){
$freeviewstr = '<div class="fl mo" id="m16">
			<div style="position:relative;" id="">
				<div class="freesees mb10" id="">
					<div style="width:719px; text-align:left;" class="title"><span class="span2s" style="padding-left:15px;">免费学习</span></div>
					<div class="freesees_son">
						<ul>'
						;
			if(!empty($freelist)){
				foreach($freelist as $freecw){
					// if(empty($user)){
						// $tclass = 'dologin';
					// }elseif($user['groupid'] == 6){
						$tclass = 'viewc';
					// }else{
						// $tclass = '';
					// }
					$freeviewstr .= '<li class=" fl " title="'.$freecw['title'].'">
								<a href="javascript:void(0);" title="'.$freecw['title'].'" class="opens '.$tclass.'" name="/course/'.$freecw['cwid'].'.html"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png" /></a>
								<img title="'.$freecw['title'].'" src="'.(empty($freecw['logo'])?'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png':$freecw['logo']).'" />
								<div class="shichang">'.$freecw['title'].'</div>
							</li>';
				}
			}
$freeviewstr .= '			
						</ul>
					</div>
				</div>				
			</div>
			</div>';
}

//调查问卷
$surveystr = '';
if(!empty($surveystr_s)){
$surveystr = '<div class="mo" id="m17">
            	<div class="newsdongtai mb10">
				
                	<div class="title" style="width:230px;"><span class="span2s">调查问卷</span></div>
                    <div>
                    	<ul class="mt10">
                        	';
foreach($surveylist as $survey){
	$surveystr.='<li title="'.strip_tags($survey['title']).'"><a target="_blank" href="/survey/'.$survey['sid'].'.html">'.strip_tags($survey['title']).'</a></li>';
}
$surveystr.=						'
                        </ul>
                    </div>
                </div>
			</div>';
}
//页面动态广告
$adpstr = '';
if(!empty($adpstr_s)){
$adpstr = '<div  class="mo" id="m18">
			<div class="weike mb10" style="position:relative">
			'.inflate('widget/ad_widget',array('data'=>$adlistp,'property'=>array('_width'=>'230','_height'=>'240','_id'=>'pagesmall','default'=>'http://static.ebanhui.com/ebh/tpl/2014/images/ad_pagesmall.jpg'))).'</div>
		</div>';
}
//自定义富文本(大)
$custommessagebbstr = '';
if(!empty($custommessagebbstr_s)){
$custommessagebbstr = '<div class="fl mo" id="m19">
			<div style="position:relative;" id="cmbbblock">
				<div class="gyxjkcs mb10" style="width:920px">
						'.(empty($custommessagebb[0]['custommessage'])?'':$custommessagebb[0]['custommessage']).'
				</div>
			</div>
			</div>';
}

if(!empty($mArr)){
	$modulearr = array('mitemstr','newsstr','adstr','roomstr','loginstr','getusernamestr','hotlabelstr','opencountstr','studystr','creditstr','cwrankstr','spstr','thespacexxx','wechatstr','custommessagestr','appstr','freeviewstr','surveystr','adpstr','custommessagebbstr');

	$mleft = explode(',',$mArr['mleft']);
	$leftstr = '<div class="fl left" id="dom0"  level="2" style="min-height:40px;min-width:200px">';
	foreach($mleft as $left){
		$leftstr .= $$modulearr[$left];
	}
	$leftstr .= '</div>';
	$mcenter = explode(',',$mArr['mcenter']);
	$centerstr = '<div class="fr center" id="dom1"  level="2">';
	foreach($mcenter as $center){
		$centerstr .= $$modulearr[$center];
	}
	$centerstr .= '</div>';
	// $lv1bottom = $spstr;
	$mlv1 = explode(',',$mArr['mlv1']);
	$lv1str = '';
	foreach($mlv1 as $lv1){
		if(!empty($lv1)){
			if($lv1 == '11'){
				$tempstr = $spstr;
			}elseif($lv1 == '12'){
				$tempstr = '<div class="xiaoshan_l fl mo" id="m12" style="height:auto">';
				$tempstr .= $leftstr;
				$tempstr .= $centerstr;
				$tempstr .= '</div>';
			}else{
				$tempstr = $$modulearr[$lv1];
			}
			$lv1str .= $tempstr;
		}
	}
}
?>

<body>
<?php $this->display('common/up_header'); ?>
<div class="xiaoshans">
	<div class="xiaoshan_t">
    	<div class="topbar">
		    <div class="top-bd clearfix">
            	<div class="login-info">
				<?php if(empty($user)){?>
				<span style="width:170px; ">您好 欢迎来到<?= $room['crname']?>！ </span>
				<?php if($room['domain'] != 'victor') { ?>
				<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
				<a href="javascript:void(0)" class="reginpage">注册</a>
				<?php } ?>
				<?php }else{?>
				<span style="width:170px; ">您好 <?=$user['username']?> 欢迎来到<?= $room['crname']?>！ </span><a href="/logout.html">安全退出</a>
				<?php }?>
					</div>
		    </div>
		</div>
    </div>
    <div class="clear"></div>
	<div class="banner" style="height:auto">
		<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960 , '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
	<div class="clear"></div>

		<?php $navlib = Ebh::app()->lib('Navigator');
		$navlib->getnavigator();
		?>

	<div class="clear"></div>
<?php
if(!empty($roomdetail['floatadimg']) && !empty($roomdetail['floatadurl'])) {
	// $syurl = "http://static.ebanhui.com/ebh/file/syjiazhang.htm";
	// $syimg = "http://static.ebanhui.com/ebh/tpl/default/images/syjiazhangshu.jpg";
	// $syimg2 = "http://static.ebanhui.com/ebh/tpl/default/images/syjiazhangshu.jp";
	$syurl = $roomdetail['floatadurl'];
	$syimg = $roomdetail['floatadimg'];
	if(substr($syurl,0,7)!='http://')
		$syurl = 'http://'.$syurl;

?>
<?php if($roomdetail['domain'] == 'mst') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="<?= "http://static.ebanhui.com/ebh/file/mstyi.htm" ?>" _fcksavedurl="/" target="_blank" title="致高一学生家长的一封信">
</a>
<a class="fenstbtn" href="<?= "http://static.ebanhui.com/ebh/file/mstsan.htm" ?>" _fcksavedurl="/" target="_blank" title="致高三学生家长的一封信">
</a>
</div>
<?php } else if($roomdetail['domain'] == 'rqzx') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:510px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/xszx.htm" _fcksavedurl="/" target="_blank" title="高一">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/xszxer.htm" _fcksavedurl="/" target="_blank" title="高二">
</a>
</div>
<?php } else if($roomdetail['domain'] == 'hztmhs') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hztmhsone.htm" _fcksavedurl="/" target="_blank" title="新高一课程安排">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hztmhs.htm" _fcksavedurl="/" target="_blank" title="新高二课程安排">
</a>
</div>
<?php } else if($roomdetail['domain'] == 'gdtzzx') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/gdtzzx.htm" _fcksavedurl="/" target="_blank" title="家长书">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/gdkb.htm" _fcksavedurl="/" target="_blank" title="课表">
</a>
</div>
<?php } else if($roomdetail['domain'] == 'fhjx') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/fhjx2.htm" _fcksavedurl="/" target="_blank" title="浙江名师中考初三冲刺告家长书">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/fhjx.htm" _fcksavedurl="/" target="_blank" title="省特级教师助你高考加分">
</a>
</div>
<?php } elseif($roomdetail['domain'] == 'yywz'){?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/yywz.htm" _fcksavedurl="/" target="_blank" title="新高一网络暑假学习班">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/yywz2.htm" _fcksavedurl="/" target="_blank" title="新高二网络暑假学习班">
</a>
</div>
<?php } elseif($roomdetail['domain'] == 'nhzx'){?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/nhzx_gaoyi.htm" _fcksavedurl="/" target="_blank" title="新高一网络暑假学习班">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/nhzx.htm" _fcksavedurl="/" target="_blank" title="新高二网络暑假学习班">
</a>
</div>
<?php }else { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;">
<!--链接地址--><a href="<?= $syurl ?>" _fcksavedurl="/" target="_blank">
<!--图片地址--><img src="<?= $syimg ?>" _fcksavedurl="<?= $syimg ?>" border="0">
</a>
</div>
<?php } ?>
<script>
var x = 398,y = 124
var xin = true, yin = true
var step = 1
var delay = 10
var obj=document.getElementById("edrghgh")
function floatwww_qpsh_com() {
var L=T=0
var R= $("body").width()-$("#edrghgh").width();
//var B = $("body").height()-$("#edrghgh").height();
var B = 768;
//obj.style.left = x + document.body.scrollLeft
//obj.style.top = y + document.body.scrollTop
$("#edrghgh").css("left",x+$("body").scrollLeft());
$("#edrghgh").css("top",y+$("body").scrollTop());
x = x + step*(xin?1:-1)
if (x < L) { xin = true; x = L}
if (x > R){ xin = false; x = R}
y = y + step*(yin?1:-1)
if (y < T) { yin = true; y = T }
if (y > B) { yin = false; y = B }
}
var itl= setInterval("floatwww_qpsh_com()", delay)
obj.onmouseover=function(){clearInterval(itl)}
obj.onmouseout=function(){itl=setInterval("floatwww_qpsh_com()", delay)}
</script>
<?php } ?>
<div style="clear:both"></div>
<?php
if(empty($announcementlist)) {
	$announcementlist = array();
	$announcementlist[] = array('message'=>'各位同学家长，网上学习课堂已经正式开始，还未报名的家长，抓紧时间报名，之前的课程仍然可以观看。');
	$announcementlist[] = array('message'=>'网络课堂最大的优点是时间自由，地点自由，可以在任何时间任何地点反复学习。同学们可以好好利用这一点更加高效的学习。');
	$announcementlist[] = array('message'=>'同学们，听完课后有不懂的地方，老师在答疑专区等着你来提问哦。');
}
if(!empty($announcementlist)){?>
<div class="tishis" style="color: #000000;font-size: 14px;height: 38px;line-height: 38px;margin: 4px auto 4px auto;text-align: center;width: 958px;">
    <!--#####滚动区域#####-->
    <div id="scroll_div" class="scroll_div">
      <div id="scroll_begin">
        <ul>
			<?php foreach($announcementlist as $announcement){?>
          <li><?=$announcement['message']?></li>
		  <?php }?>
        </ul>
      </div>
      <div id="scroll_end"></div>
    </div>
    <!--#####滚动区域#####-->
	<script type="text/javascript">
	function ScrollImgLeft(){
	var speed=30;
		var scroll_begin = document.getElementById("scroll_begin");
		//alert(scroll_begin.scrollWidth);
		var scroll_end = document.getElementById("scroll_end");
		var scroll_div = document.getElementById("scroll_div");
		if ($(scroll_begin).width() > (parseInt(document.body.clientWidth) / 2)) {
			scroll_end.innerHTML = scroll_begin.innerHTML;
			function Marquee() {
				if (scroll_end.offsetWidth - scroll_div.scrollLeft <= 0)
					scroll_div.scrollLeft -= scroll_begin.offsetWidth;
				else
					scroll_div.scrollLeft++;
			}
			var MyMar = setInterval(Marquee, speed);
			scroll_div.onmouseover = function() { clearInterval(MyMar); }
			scroll_div.onmouseout = function() { MyMar = setInterval(Marquee, speed); }
		}
	}
	$(function(){
		ScrollImgLeft();
	});
	</script>
</div>
<?php }?>
    <div class="xiaoshan" id="">
	<?php if(!empty($mArr)){?>
	<div id="dom3" class="lv1" level="1" style="float:left;width:720px">

		<?=$lv1str?>

	</div> <!--dom-->

        <div class="xiaoshan_r fr right" id="dom2" level="2">


	<?php
	$mright = explode(',',$mArr['mright']);
	foreach($mright as $right){
		if($right != ''){
			echo $$modulearr[$right];
		}
	}
	?>

        </div>

            <!--课程列表
		<div id="dom4" class="lv1" level="1" style="float:left">

		</div>-->
	<?php }else{?>
	<div id="dom3" class="lv1" level="1" style="float:left;width:720px">

        <div class="xiaoshan_l fl mo" id="m12" style="height:auto">

            <div class="fl left" id="dom0" level="2">
            	<!--网校资讯-->
                <?=$mitemstr?>

                <!--新闻动态-->
				<?=$newsstr?>

            </div>

            <div class="fr center" id="dom1" level="2">
            	<!--微课制作器-->
				<?=$adstr?>

                <!--萧山中学介绍-->
				<?=$roomstr?>
            </div>

        </div>
		<?=$custommessagestr?>
		<?=$freeviewstr?>
		<?=$spstr?>
		<?=$custommessagebbstr?>
	</div> <!--dom-->

        <div class="xiaoshan_r fr right" id="dom2" level="2">

        	<!--用户登录-->
        	<?=$loginstr?>

            <div class="clear"></div>

			<!--微信公众号-->
			<?=$wechatstr?>

			<div class="clear"></div>

			<!--页面动态广告-->
			<?=$adpstr?>

			<div class="clear"></div>

			<!--微信公众号-->
			<?=$appstr?>

			<div class="clear"></div>

            <!--首次登录-->
            <?=$getusernamestr?>

			<!--调查问卷-->
			<?=$surveystr?>

            <!--热门标签-->
            <?=$hotlabelstr?>

            <div class="clear"></div>


            <!--最新报名-->
            <?=$opencountstr?>

            <div class="clear"></div>
            <!--学员动态-->
			<?=$studystr?>

            <div class="clear"></div>
            <!--积分排名-->
			<?=$creditstr?>

            <div class="clear"></div>
            <!--课程排行榜-->
			<?=$cwrankstr?>

        </div>

            <!--课程列表
		<div id="dom4" class="lv1" level="1" style="float:left">

		</div>-->
	<?php }?>
    </div>
</div>
	<!--增加客服系统sta-->
	<div class="clear"></div>
	<div class="kfxt">
        <?php $this->display('shop/drag/kf')?>
	</div>
	<!--增加客服系统end-->
	<div class="clear"></div>
	<!--底部-->
	<div class="footer">
		<div style="width:960px; margin:0 auto;">
			<div style="width:720px; line-height:32px;">
				<?php if(!empty($roomdetail['crname'])){?>
				<div><p class="pp1"> <?=empty($roomdetail['craddress'])?$roomdetail['crname']:$roomdetail['craddress']?></p></div>
				<div class="clear"></div>
				<?php }
				if(!empty($roomdetail['crphone'])){?>
				<div><p class="pp2"> <?=$roomdetail['crphone']?></p></div>
				<div class="clear"></div>
				<?php }
				if(!empty($roomdetail['cremail'])){?>
				<div><p class="pp3"> <?=$roomdetail['cremail']?></p></div>
				<div class="clear"></div>
				<?php }?>
			</div>
		</div>
	</div>
<!--用户名查询系统-->
<style type="text/css">
.fl{float:left;}
.fr{float:right;}
.clear{clear:both;}
.mt20 {margin-top: 20px;}
.ui-dialog-title{padding: 11px 15px; font-weight: normal;}
</style>
<div id="dialogdetail" style="display:none;">
	<div style="width:665px;">
		<div class="yhcxxtf">
		    <div class="yhcxxt">
		        <div>
		            <div class="tishi"><span style="color:#ff0000;">*</span>如果你已经取得账号并且修改过密码，那么用你的账号及你的密码<a id="login_btn" href="javascript:;" style="color:#ff0000;">登录</a>或者<a href="/forget.html" style="color:#ff0000;">取回密码</a></div>
		            <div class="chaxun">
		                <div class="szschool mt20">
		                    <span class="elxian fl">所在学校：</span>
		                    <select id="crname" onchange="hided()" class="fl ertyu"></select>
		                </div>
		                <div class="clear"></div>
		                <div class="names mt20">
		                    <span class="elxian fl">姓名：</span>
		                    <input class="ertyu ertyus" id="search_name" type="text" onchange="hided()" />
		                </div>
		                <a href="javascript:;" id="dosearch" class="chabtn">查&nbsp;询</a>
		            </div>
		        </div>

		        <div style="height:133px;">
		        	<input id="default_password" type="hidden" />
			        <!--查询成功-->
			        <div class="cxright" style="display:none;">
			            <p class="chenggbtn">查询成功！<span id="result_realname" style="color:#ff0000;"></span>&nbsp;同学您好，</p>
			            <p class="chenggbtns"><span class="chenggbtn1">您的账号：</span><span id="result_username" style="padding:0 8px;color:#18a8f7; font-size:30px; font-family:微软雅黑;"></span>(牢记此账号用于登录学习）</p>
			            <p class="chenggbtns p1s"><span id="result_password_span" class="chenggbtn1 fl">默认密码：</span><span id="result_password" class="span1s fl" style="padding:0 8px;"></span><a id="logbtn" href="javascript:;" class="chabtns fl">立即登录</a>&nbsp;(登录后请及时修改密码）</p>
			        </div>
			        <!--查询失败-->
			        <div class="cxfalse" style="display:none;">
			            <p class="p1">查询错误！</p>
			            <p>没有您的账号信息，请核对学校及姓名，如有</p>
			            <p>问题请及时联系客服。</p>
			        </div>
			    </div>

		        <div class="relation">
		            <div class="relation_son">
		            <?php if($room['domain'] == 'anhui') { ?>
		                <div class="yxdh">
		                    <div class="phone fl">0556-5358377 / 5275114</div>
		                    <div class="email fr">邮箱：543349578@qq.com</div>
		                </div>
		                <div class="clear"></div>
		                <div class="qq">
		                    <span class="fl" style="color:#626262; display:block;">咨询:&nbsp;</span>
		                    <a href="http://wpa.qq.com/msgrd?v=3&uin=543349578&site=qq&menu=yes" target="_blank" class="qqlx fl">客服01</a>
		                </div>
		            <?php } else { ?>
		                <div class="yxdh">
		                    <div class="phone fl">0571-88252183 / 88252153</div>
		                    <div class="email fr">ebanhui@qq.com</div>
		                </div>
		                <div class="clear"></div>
		                <div class="qq">
		                    <span class="fl" style="color:#626262; display:block;">咨询:&nbsp;</span>
		                    <a href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" target="_blank" class="qqlx fl">客服01</a>
		                    <a href="http://wpa.qq.com/msgrd?v=3&uin=15335667&site=qq&menu=yes" target="_blank" class="qqlx fr">客服02</a>
		                </div>
		            <?php } ?>
		            </div>
		        </div>
		    </div>
		</div>

	</div>
</div>

<script>
$(".dologin").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
	var curid = 0;
	var curidt = 0;
	var firstclick = 0;
	$(document).ready(function () {
            <?php if(!empty($splist)){?>
			$(".sp_div").click(function(){
				var sp_id = $(this).attr("id");
				if(sp_id != "" && sp_id != undefined) {
					sp_id = sp_id.substring(3);
					if(sp_id != curid) {
						$(".sp_div").removeClass("leraten");
						$(this).addClass("leraten");
						$(".append_new, .jisrtde").hide();
						$("#itempid_" + sp_id).show();
						curid = sp_id;
					}
				}
				setCookie('ebh_spselected',sp_id);
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
			<?php }?>
        });

	function showreg(url,title){
		height = 530;
		width = 645;
		var html = '<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id:'artdialogreg',
			title:title,
			content:html,
			easy:true,
			padding:10
		}),'common').exec('show');
	}
	function showundersort(sid){
		var showed = $('.sbs'+sid).css('display');

		if(showed == 'none')
			$('.sbs'+sid).show();
		else
			$('.sbs'+sid).hide();
	}

$(function(){
	if(parent == parent.parent) {
		if(top.document != document)
			top.location.reload();
	}
	//打开查询对话框
	$("#getusername").click(function(){
		if(!H.get('dialogdetail')){
			H.create(new P({
				id : 'dialogdetail',
				title: '用户名查询系统',
				easy:true,
				width:665,
				padding:0,
				content:$('#dialogdetail')[0]
			}),'common');
		}

		//初始化学校列表和默认密码
		$.post("<?=geturl('getusername/getinfo')?>", function(data){
			if(data != undefined && data.crlist != undefined && data.defaultpass != undefined ){
				$("#crname").html('');
				$.each(data.crlist, function(i, n){
					$("#crname").append('<option value="'+n+'">'+n+'</option>');
				});
				if ($("#crname option").size()>1)
				{
					$("#crname").get(0).selectedIndex=0;
				}
				$("#default_password").val(data.defaultpass);
			}
		}, "json");
		H.get('dialogdetail').exec('show');
	});

	//立即登录
	$("#logbtn,#login_btn").click(function(){
		H.get('dialogdetail').exec('close');
		$.loginDialog();
		var result_username = $("#result_username").html();
		if (result_username != '') {
			$("#uname").val(result_username);
		}
	});

	//查询
	$("#dosearch").click(function(){
		var crname = $('#crname').val();
		var search_name = $('#search_name').val();
		var defaultpass = $("#default_password").val();
		$.ajax({
			url:'/getusername.html',
			type:'post',
			data:{'crname':crname,'realname':search_name},
			success:function(data){
				if(data != undefined && data == 0){
					$('.cxright').css('display','none');
					$('.cxfalse').css('display','block');
				}else{
					res = eval('('+(data)+')');
					$('.cxfalse').css('display','none');
					$('.cxright').css('display','block');
					$('#result_username').html(res.username);
					$('#result_realname').html(res.realname);
					if(res.password){
						$('#result_password_span').html('您的密码：');
						$('#result_password').html(res.password);
					}
					else{
						$('#result_password_span').html('默认密码：');
						$('#result_password').html(defaultpass);
					}
				}
			}
		});
	});

	//如果有自定义富文本(大)时,调整位置
	rightfix();
});

function hided(){
	$('.cxright').css('display','none');
	$('.cxfalse').css('display','none');
}
$('.viewc').click(function(){
	window.open($(this).attr('name'));
});
$(".reginpage").click(function(){

			height = 600;
			width = 650;
			url = '/register/inpage.html';
			title = '注册账号';
			var html = '<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'" style="border-radius:6px;"></iframe>';
			H.create(new P({
				id : 'artdialogreg',
				title : title,
				width : width,
				height : height,
				content : html,
				easy:true
			}),'common').exec('show');

		});
function rightfix(){
	$('#dom2>.mo').css('margin-top','0px');
	if(!$('#dom3>#m19').length)
		return;
	var cmbbtop = $('#m19')[0].offsetTop;
	var cmbbheight = $('#m19')[0].offsetHeight;
	var lastbottom = 322;

	$.each($('#dom2>.mo'),function(k,v){
		if(v.offsetTop+v.offsetHeight>cmbbtop && cmbbtop+cmbbheight>v.offsetTop){
			$(v).css('margin-top',cmbbtop+cmbbheight-lastbottom+'px');
			return false;
		}
		lastbottom = v.offsetTop+v.offsetHeight;
	});
}
</script>
<?php $this->display('common/footer')?>
