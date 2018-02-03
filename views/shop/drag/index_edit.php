<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$roomdetail['crname']?></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2016012801"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150813001"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.vticker-min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
.scroll_div {width:958px;margin:0 auto;overflow: hidden;white-space: nowrap;height:38px}
#scroll_begin, #scroll_end, #scroll_begin ul, #scroll_end ul, #scroll_begin ul li, #scroll_end ul li{display:inline;}  
#scroll_begin ul li {margin-left:15px;}
.mo{height:auto;}
.mo h1{background:#efefef;height:28px;cursor:move; font-size:21px; line-height:28px; padding-left:5px; color:#444;}
.mo .nr{height:80px;}
.mo h1 span{ font-size:18px; font-weight:bold;cursor:pointer; color:#f00;}
.addto{
	z-index:100;
	top:6px;
	right:10px;
}
.delbtn{
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    color: #f00;
}
#deletedblocks .delbtn{
	display:none;
}
#dom2 ,#dom0{
	min-height:100px;
	min-width:230px;
}
#deletedblocks>.mo{
	margin-top:10px;
	margin:10px;
}
.upprogressbox,.upfileinfo,.upprogressbar{
	width:255px;
	height:auto;
	text-align:left;
	padding-left:10px;
	padding-right:5px;
	 margin-bottom:10px;
}
.spanUpfilename{
	width:180px;
}
.gyxjkcs {
    background-color: #ffffff;
    height: auto;
	min-height:190px;
    width: 679px;
	padding: 20px;
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
}
.mo>h1{
	color:#f00;
}
.mo .title,#m2{
	cursor:move;
}
#deletedblocks .mo .title,#deletedblocks #m2,#deletedblocks .mo h1{
	cursor:default;
}
.ui-dialog{
	font-size:12px;
}
.wxzixun,.newsdongtai{position:relative;}
.kcbj img{
	width:167px;
	height:100px;
}
.frdel{
	position:absolute;
	right:2px;
	top:2px;
	color:red;
	z-index:10;
	cursor:pointer;
	font-size:18px;
}
.freesees_son a.opens{
	cursor:default;
}
#summary_div{
	display:none;
}
#summary_edit{
	height:190px;
	width:330px;
	resize:none;
	font-size: 12px;
    color: #626262;
    margin-top: 5px;
    line-height: 25px;
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
//动态资讯 #ECF9FF
$mitemstr = '<div class="mo" id="m0">
				<div class="wxzixun mb10" ><span class="fr delbtn" >×</span>
				<div class="title" style="width:230px;"><span class="span2s">网校资讯</span></div>
					<div>
						<ul class="mt10">';
foreach($mitemlist as $mitem){
	$mitemstr .= '<li title="'.$mitem['subject'].'"><a href="#" itemid="'.$mitem['itemid'].'">'.$mitem['subject'].'</a></li>';
}
$mitemstr .= '</ul>
				</div>
				<div><a href="#" style="position:absolute;bottom:5px;right:8px;color: #18a8f7;display: block;height: 25px;  width:60px; border:none;cursor:pointer;text-align:center;line-height:25px">更多>></a></div>
			</div>			
			</div>';

//新闻动态
$newsstr = '<div class="mo" id="m1">
            	<div class="newsdongtai mb10"><span class="fr delbtn" >×</span>
				
                	<div class="title" style="width:230px;"><span class="span2s">新闻动态</span></div>
                    <div>
                    	<ul class="mt10">
                        	';
foreach($newslist as $news){
	$newsstr.='<li title="'.$news['subject'].'"><a href="#">'.$news['subject'].'</a></li>';
}
$newsstr.=						'
                        </ul>
                    </div>
                </div>
			</div>';
//广告
$adstr = '<div  class="mo" id="m2">
                <div class="weike ml10 mb10" style="position:relative"><span class="fr delbtn" style="position:absolute;right:5px;z-index:10">×</span>
				'.inflate('widget/ad_widget',array('data'=>array(),'property'=>array('_width'=>'478','_height'=>'240','_id'=>'headf','default'=>'http://static.ebanhui.com/ebh/tpl/2014/images/adcenter.jpg'))).'</div>
				</div>';

//学校介绍
$roomstr = '<div class="mo" id="m3">
                <div class="xiaoshanjs ml10 mb10"><span class="fr delbtn" >×</span>
                	<div class="title" style="width:480px;"><span class="span2s">'.$roomdetail['crname'].'</span></div>
                    <div class="xiaoshanjs_son" style="height:200px">
                    	<div class="xiaoshanjs_sonl fl">
                        	<div><img src="'.(empty($roomdetail['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$roomdetail['cface']).'" width="100" height="100" /></div>
                            <div><span class="span1s" >'.$roomdetail['domain'].'.ebh.net</span></div>
                        </div>
                        <div class="xiaoshanjs_sonr fl">
                        	<p id="summary_p" title="点击进行编辑">'.shortstr($roomdetail['summary'],400).'</p>
							<div id="summary_div">
								<textarea id="summary_edit"></textarea>
							</div>
                        </div>
                    </div>
                </div>
				</div>';

//用户登录
if(empty($user)){
$loginstr = '
<div class="mo" id="m4">
<div class="yhdl mb10"><span class="fr delbtn" >×</span>
            	<div class="title"><span class="span2s">用户登录</span></div>
				<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
				<input type="hidden" name="loginsubmit" value="1" />				
                <div><input value="请输入账号" name="username" id="username" class=" " onfocus="if ($(this).val() == \'请输入账号\'){$(this).val(\'\').css(\'color\', \'#000000\'); }" onblur="if ($(this).val() == \'\'){$(this).val(\'请输入账号\').css(\'color\', \'#C3C3C3\'); }" maxlength="20"></div>
                <div><input value="" name="password" id="password" type="password" maxlength="20" class="" style="color:#000000"></div>
                 <p class="zidong mt5">
                 	<input type="checkbox" checked="checked" value="1" name="cookietime" style="vertical-align: middle;" id="cookietime">
                    <label class="rybtnat" for="cookietime">下次自动登录</label>
                </p>
                <input type="submit" value="" name="Submit" class="denglubtn logobtn">
                <div style="height:20px" class="qtlol fr">
					<span style="color:#808080;" class="fl">用其他账号登录：</span>
					<a href="#"><img src="http://static.ebanhui.com/ebh/tpl/default/images/qqico0925.jpg"></a>
					<a href="#"><img src="http://static.ebanhui.com/ebh/tpl/default/images/sianico0925.jpg"></a>
				</div>
                <div class="fotlog fl">
					<a href="#" style="color:#808080;">用户注册</a> |
					<a href="#" style="color:#808080;">忘记密码？</a>
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
	$url = $user['groupid'] == 6 ? geturl('myroom') : geturl('troom');
	
	$loginstr = '
	<div class="mo" id="m4">
	<div class="yhdl mb10"><span class="fr delbtn" >×</span>
	<div class="title"><span class="span2s">用户登录</span></div>
	<div class="tukuang" style="margin-left:20px;margin-top:18px;_margin-left:10px;">
	<img src="'.$facethumb.'"/></div>
	<div style="float:left;margin-top:20px;"><p style="font-weight:bold;font-size:14px;">'.(empty($user['realname'])?$user['username']:$user['realname']).'</p><p>上次登录时间:</p><p>'.$user['lastlogintime'].'</p></div>
	<input class="msjinr" type="submit" name="Submit" value="马上进入" onclick="window.location.href=\''.$url.'\'" />
	
	<div class="fotlog">
	<a href="/logout.html" style="color:#808080;">退出</a>
	</div>
	</div>
	</div>
	';
}

//获取用户名
$getusernamestr = '<div class="mo" id="m5">
		<div class="shcidenglu mb10"><span class="fr delbtn" >×</span>
            	<div class="title"><span class="span2s">首次登录请点击</span></div>
                <div class="shcidenglu_son "><a href="/getusername.html"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/shoucidenglu.png" height="29" width="110" /></a></div>
            </div>
		</div>';
		

//热门标签
if(!empty($roomdetail['crlabel']))
	$labelarr = explode(',',$roomdetail['crlabel']);	
$hotlabelstr = '<div class="mo" id="m6">
			<div class="remenbq mb10"><span class="fr delbtn" >×</span>
				<div class="title"><span class="span2s">热门标签</span></div>
				<div class="biaoqians">';
				if(!empty($labelarr)){
				foreach($labelarr as $label){
$hotlabelstr .='		<div class="fl biaoqianson"><a href="javascript:void(0)">'.$label.'</a></div>';
				}
				}
$hotlabelstr .=		'
				</div>
			</div>
		</div>';

			
//开通列表
$opencountstr = '<div class="mo" id="m7">
			<div class="newbaoming mb10"><span class="fr delbtn" >×</span>
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
			
			
//学员动态
$liclass = '';
$studystr = '
<div class="mo" id="m8">
            <div class="xydongtai mb10"><span class="fr delbtn" >×</span>
            	<div class="title"><span class="span2s">学员动态</span></div>
                <div class="xydongtaison">
                	<ul>
                    	';
foreach($studylist as $dyuser){
	$sex = empty($dyuser['sex']) ? 'man' : 'woman';
	// $type = $user['groupid'] == 5 ? 't' : 'm';
	$facethumb40 = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
	$face40 = empty($dyuser['face']) ? $facethumb40 : $dyuser['face'];
	$facethumb40 = getthumb($face40,'40_40');
	// if($i == 4)
		// $liclass = 'last';
	$studystr .= '<li class="'.$liclass.'">
                        	<div>
                                <div class="fl"><img src="'.$facethumb40.'" width="40" height="40" /></div>
                                <div style="padding-left:20px; line-height:40px;" class="fl">
                                    <span style="color:#999; font-size:12px;float:left;width:82px;*width:62px;overflow: hidden; height: 28px;">'.$dyuser['realname'].'</span>
                                    <span style="color:#999; float:right">'.timetostr($dyuser['lastdate'],'m-d').'</span>
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

//积分排名
$creditstr = '
<div class="mo" id="m9">
            <div class="jifenlist mb10"><span class="fr delbtn" >×</span>
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
//课件排名
$cwrankstr = '<div class="mo" id="m10">
            <div class="kechengph mb10"><span class="fr delbtn" >×</span>
            	<div class="title"><span class="span2s">课程排行榜</span></div>
                <div class="kechengphson">
                	<ul>
                    	';
foreach($courseranklist as $k=>$cw){
	$rank = $k+1;
	if($rank<10)
		$rank = '0'.$rank;
	$cwrankstr .= '<li title="'.$cw['title'].'"><a href="#"><b style="font-size:14px;font-family:Arial;">'.$rank.'</b>　'.shortstr($cw['title'],24,'').'</a></li>
                        ';
}	
$cwrankstr .= '</ul>
                </div>
            </div>
			</div>';	


//服务包
$spcount = 0;
	foreach($splist as $spkey=>$sp) {
		if(!empty($sp['itemlist']) && is_array($sp)) {
			$spcount++;
		}
	}
$spstr = '<div class="mo" style="width:720px;float:left" id="m11">
		<h1>拖动<span class="fr delbtn" >×</span></h1>
		<div class="clear"></div>
		
       <div class="zizhan" style="'.($spcount>1?'':'display:none').'">
	<div class="fewof" style="margin:0px;height:auto">
		<ul style="display:inline-block">
	';
	$i = 0;
	$inittid = 0;
		foreach($splist as $spkey=>$sp) { 
			if(!empty($sp['itemlist']) && is_array($sp)) {
	$spstr .='
			<li class="tsub" '.( ($inittid !=0) ? 'style="display:none;"':'').'>
			<div id="sp_'.$sp['pid'].'" class="sp_div '.($i == 0 ?'leraten':'').'">
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
		if(empty($sp['itemlist']) || !is_array($sp))
			continue;
		$spshowcount ++;
		
$spstr.='<div id="itempid_'.$sp['pid'].'" class="append_new " '.($i == 0? '' : 'style="display:none;"' ).' >';

	$itemi = 0;
	$lastsid = '';
	foreach($sp['itemlist'] as $k=>$item) {
		$furl = '';
		if($item['fprice'] == 0 || isset($mylist[$item['folderid']])) {
			$furl = '/myroom/stusubject/'.$item['folderid'].'.html';
		} else {
			
			$furl = '/ibuy.html?itemid='.$item['itemid'];
			if(!empty($item['sid']) && isset($sortlist[$item['sid']])) {
				$furl .= '&sid='.$item['sid'];
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
				
			
			
		$spstr.='	<div class=""  style="margin-top:15px;width:719px;height:195px;">
			<ul>
	<li class="huanqiu linewline" style="width:719px;margin:0;height:195px;">
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
	<p class="fottpp" style="width:460px;">'.$item['content'].'</p>

		</div>
				<a '.$fsurl.' style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: right;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;margin-right:10px;">报 名</a>
				</div>
		</li>
		</ul>
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
		<div class="enidet" onmouseout="this.className=\'enidet\'" onmouseover="this.className=\'enidets\'" style="position:relative">
		<h3 class="kjname">
		<a href="'. geturl('courseinfo/'.$item['itemid']) .'" target="_blank" title="'. $item['iname'] .'" class="" name="'. $furl .'">'. ssubstrch($item['iname'],0,28) .'</a>
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
	<div class="rigxiaox '.($longimg?'':'longsummary').'">
	<p><a href="'. geturl('courseinfo/'.$item['itemid']) .'" class="zhutk">'.(!empty($item['speaker'])?$item['speaker']:'').'</a></p>
	<p class="fottpp">'. ssubstrch($item['isummary'],0,150) .'</p>

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
		<a href="javascript:void(0);" class="dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;">试听课程</a>
		'; } else { 
		$spstr.='
		<a href="javascript:void(0);" class="dologin" name="'. $furl .'" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;">报 名</a>
		'; } 
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
		<a title="'. $item['iname'] .'" target="_blank" href="'. geturl('courseinfo/'.$item['itemid']) .'">'. ssubstrch($item['iname'],0,28) .'</a>
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
	<p><a href="'. geturl('courseinfo/'.$item['itemid']) .'" class="zhutk">'.(!empty($item['speaker'])?$item['speaker']:'').'</a></p>
	<p class="fottpp">'. ssubstrch($item['isummary'],0,150) .'</p>


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
		<a class="paybtn" href="'. $furl .'" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;">试听课程</a>
		';} else { 
			if(!isset($mylist[$item['folderid']])) {
		$spstr.='
		<a class="paybtn" href="'. $furl .'" '.(empty($isteacher)?'target="_blank"':'').' style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;">报 名</a>
		';} else {
			$spstr .='
		<a class="paybtn" href="'. $furl .'" '.(empty($isteacher)?'target="_blank"':'').'target="_blank" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;">进 入</a>
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

//微信二维码
$wechatstr = '<div class="mo" id="m13">
			<div class="weixingzh mb10" style="height:266px"><span class="fr delbtn" >×</span>
            	<div class="title"><span class="span2s">微信公众号</span></div>
                <div class="weixingzh_son "><img class="wcupdate" id="wcimage" width="200" height="200" style="cursor:pointer" src="'.(empty($roomdetail['wechatimg'])?'http://static.ebanhui.com/ebh/tpl/2014/images/ebh_wx.png':$roomdetail['wechatimg']).'">
				<br><span class="wcupdate" style="color:#666;cursor:pointer" >点击更改二维码</span></div>
            </div>
		</div>';

		
//自定义富文本
$custommessagestr = '<div class="fl mo" id="m14">
			<h1>拖动<span class="fr delbtn" >×</span></h1>
			<div style="position:relative;" id="cmblock">
				<div class="gyxjkcs mb10" id="cmcontent">
						'.(empty($custommessage[0]['custommessage'])?'':$custommessage[0]['custommessage']).'
				</div>
				<a class="cmupdate" style="position:absolute;bottom:10px;right:10px;background:#18a8f7;color:#fff;display:block;height:25px;width:60px;border:none;cursor:pointer;text-align:center;line-height:25px">点击编辑</a>
			</div>
			</div>';
			
		
//应用
$appstr = '<div class="mo" id="m15">
			<div class="appd mb10"><span class="fr delbtn" >×</span>
				<div class="title"><span class="span2s">应用下载</span></div>
				<div class="appd_son">';
					if(!empty($applist)){
						foreach($applist as $k=>$app){
				($k == 0)?$marginclass = 'first': $marginclass ='mt10';
		$appstr .= '<div class="'.$marginclass.' appd_sons">
						<div class="fl tupian"><img width="32" height="32" src="'.(empty($app['img'])?'http://static.ebanhui.com/ebh/tpl/2014/images/app.png':$app['img']).'"></div>
						<a href="'.$app['url'].'" title="'.$app['title'].'" class="fl biaoti"><p>'.$app['title'].'</p></a>
					</div>';
		}}
$appstr .= '
				</div>
			</div>
		</div>';
		
//免费试看片
$freeviewstr = '<div class="fl mo" id="m16">
			<h1>拖动<span class="fr delbtn" >×</span></h1>
			<div style="position:relative;" id="">
				<div class="freesees mb10" id="">
					<div style="width:719px; text-align:left;" class="title"><span class="span2s" style="padding-left:15px;">免费试看影片</span></div>
					<div class="freesees_son">
						<ul>'
						;
			if(!empty($freelist)){
				foreach($freelist as $freecw){
					$freeviewstr .= '<li class=" fl ">
								<a href="#" class="opens"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png" /></a>
								<div class="kcbj" title="'.$freecw['title'].'"><img src="'.(empty($freecw['logo'])?'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png':$freecw['logo']).'" /></div>
								<div class="shichang">'.$freecw['title'].'</div>
								<input type="hidden" value="'.$freecw['cwid'].'">
								<span class="frdel" title="点击取消免费试看"> × </span>
							</li>';
				}
			}
$freeviewstr .= '			<li class=" fl ">
								<a href="#" class="mores">点击编辑</a>
							</li>
						</ul>
					</div>
				</div>				
			</div>
			</div>';

//调查问卷
$surveystr = '<div class="mo" id="m17">
            	<div class="survey newsdongtai mb10"><span class="fr delbtn" >×</span>
				
                	<div class="title"><span class="span2s">调查问卷</span></div>
                    <div>
                    	<ul class="mt10">
                        	';
foreach($surveylist as $survey){
	$surveystr.='<li title="'.strip_tags($survey['title']).'"><a href="#">'.strip_tags($survey['title']).'</a></li>';
}
$surveystr.=						'
                        </ul>
                    </div>
                </div>
			</div>';

//页面动态广告
$adpstr = '<div  class="mo" id="m18">
			<div class="weike mb10" style="position:relative"><span class="fr delbtn" style="position:absolute;right:5px;z-index:10">×</span>
			'.inflate('widget/ad_widget',array('data'=>array(),'property'=>array('_width'=>'230','_height'=>'240','_id'=>'pagesmall','default'=>'http://static.ebanhui.com/ebh/tpl/2014/images/ad_pagesmall.jpg'))).'</div>
		</div>';
		
//超长自定义富文本
$custommessagebbstr = '<div class="fl mo" id="m19">
			<h1 style="position:relative">拖动<span class="fr delbtn">×</span></h1>
			<div style="position:relative;" id="cmbbblock">
				<div class="gyxjkcs mb10" id="cmbbcontent" style="width:920px">
						'.(empty($custommessagebb[0]['custommessage'])?'':$custommessagebb[0]['custommessage']).'
				</div>
				<a class="cmbbupdate" style="position:absolute;bottom:10px;right:10px;background:#18a8f7;color:#fff;display:block;height:25px;width:60px;border:none;cursor:pointer;text-align:center;line-height:25px">点击编辑</a>
			</div>
			</div>';
if(empty($mArr)){
	$mArr = array('mlv1'=>'12',
					'mleft'=>'0',
					'mcenter'=>'3',
					'mright'=>'4',
					'mdeleted'=>'2,1,14,16,11,13,18,15,5,17,6,7,8,9,10,19'
				);

}
if(!empty($mArr)){
	$modulearr = array('mitemstr','newsstr','adstr','roomstr','loginstr','getusernamestr','hotlabelstr','opencountstr','studystr','creditstr','cwrankstr','spstr','thespacexxx','wechatstr','custommessagestr','appstr','freeviewstr','surveystr','adpstr','custommessagebbstr');
	
	$mleft = explode(',',$mArr['mleft']);
	$leftstr = '<div class="fl left" id="dom0"  level="2">';
	foreach($mleft as $left){
		if($left != ''){
			$leftstr .= $$modulearr[$left];
			$modulearr[$left] = 'thespacexxx';
		}
	}
	$leftstr .= '</div>';
	$mcenter = explode(',',$mArr['mcenter']);
	$centerstr = '<div class="fr center" id="dom1"  level="2">';
	foreach($mcenter as $center){
		if($center != ''){
			$centerstr .= $$modulearr[$center];
			$modulearr[$center] = 'thespacexxx';
		}
	}
	$centerstr .= '</div>';
	
	// $lv1bottom = $spstr;
	$mlv1 = explode(',',$mArr['mlv1']);
	$lv1str = '';
	// $middlestr = '';
	// $bottomstr = '';
	foreach($mlv1 as $lv1){
		if(!empty($lv1)){
			if($lv1 == '11'){
				$tempstr = $spstr;
			}elseif($lv1 == '12'){
				$tempstr = '<div class="xiaoshan_l fl mo" id="m12" style="height:auto">
					<h1>拖动<span class="fr delbtn" >×</span></h1>';
				$tempstr .= $leftstr;
				$tempstr .= $centerstr;
				$tempstr .= '</div>';
			}else{
				$tempstr = $$modulearr[$lv1];
			}
			$modulearr[$lv1] = 'thespacexxx';
			$lv1str .= $tempstr;
			// if(empty($topstr))
				// $topstr = $tempstr;
			// elseif(empty($middlestr))
				// $middlestr = $tempstr;
			// elseif(empty($bottomstr))
				// $bottomstr = $tempstr;
		}
	}
	
}
?>

<body>
<div class="xiaoshans">
	<div class="xiaoshan_t">
    	<div class="topbar">
		    <div class="top-bd clearfix">
			<div class="login-info">
			<?php if(empty($user)){?>
			<span style="width:170px; ">您好 欢迎来到e板会！ </span>
			<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
			<a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
			<?php }else{?>
			<span style="width:170px; ">您好 <?=$user['username']?> 欢迎来到e板会！ </span><a href="/logout.html">安全退出</a><a href="http://www.ebh.net" >e板会首页</a>
			<?php }?>
            	</div>
				
		    </div>
		</div>
    </div>
    <div class="clear"></div>
	<div class="banner" style="height:auto">
		<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
	<div class="clear"></div>
	
		<?php $navlib = Ebh::app()->lib('Navigator');
		$navlib->getnavigator();
		?>
	<div class="clear"></div>
	
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
		if ($(scroll_begin).width() > parseInt(document.body.clientWidth) / 2) {    
			scroll_end.innerHTML = scroll_begin.innerHTML;    
			function Marquee() {    
				if (scroll_end.offsetWidth - scroll_div.scrollLeft <= 0)    
					scroll_div.scrollLeft -= scroll_begin.offsetWidth    
				else    
					scroll_div.scrollLeft++    
			}    
			var MyMar = setInterval(Marquee, speed);    
			scroll_div.onmouseover = function() { clearInterval(MyMar) }    
			scroll_div.onmouseout = function() { MyMar = setInterval(Marquee, speed) }    
		}    
	}    
	ScrollImgLeft();</script>    
</div>
<?php }?>
    <div class="xiaoshan">
	<?php 
	// var_dump($mArr);
	if(!empty($mArr)){?>
	<div id="dom3" class="lv1" level="1" style="float:left;width:720px">
		
		<?=$lv1str?>
		
	</div> <!--dom-->
		
	<div class="xiaoshan_r fr right" id="dom2" level="2">
		
	<?php 
	$mright = explode(',',$mArr['mright']);
	foreach($mright as $right){
		if($right != ''){
			echo $$modulearr[$right];
			$modulearr[$right] = 'thespacexxx';
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
		<h1>拖动<span class="fr delbtn" >×</span></h1>
            <div class="fl left" id="dom0" level="2">
            	<!--网校资讯-->
                <?=$mitemstr?>
				
                <!--新闻动态-->
				<?=$newsstr?>
				
            </div>
			
            <div class="fl center" id="dom1" level="2">
            	<!--微课制作器--> 
				<?=$adstr?>
				
                <!--萧山中学介绍-->
				<?=$roomstr?>
            </div>
            <div class="clear"></div>
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
			
			<!--应用-->
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

	<div class="clear"></div>
	<!--底部-->
	<div class="footer">
		<div style="margin:0 auto; width:960px;">
			<div style="width:720px;  line-height:32px;">
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
	
<input type="button" id="savebtn" value="保存" style="position:fixed;background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:10px;left:90px;cursor:pointer"/>
<input type="button" id="cancelbtn" value="取消" style="position:fixed;background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:10px;left:182px;cursor:pointer"/>
<input type="button" id="initbtn" value="初始化" style="position:fixed;background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:10px;left:2px; cursor:pointer;"/>


<div id="deletedblocks" class="deleted" style="display:none;border:2px solid #eee;width:1300px;height:700px;background:#f9f9f9;overflow:auto; box-shadow:0 0 5px #e1e1e1;">
<?php 
if(!empty($mArr['mdeleted'])){
	$mdeleted = explode(',',$mArr['mdeleted']);
	// var_dump($mdeleted);
	foreach($mdeleted as $deleted){
		if($deleted != '' && $deleted != 11 && $deleted != 12){
			echo $$modulearr[$deleted];
			$modulearr[$deleted] = 'thespacexxx';
		}elseif($deleted == 11){
			echo $spstr;
		}elseif($deleted == 12){
			$m12str = '<div class="xiaoshan_l fl mo" id="m12" style="height:auto">
				<h1>拖动<span class="fr delbtn" >×</span></h1>';
			$m12str .= $leftstr;
			// if($centerstr != ''){
				$m12str .= $centerstr;
			// }
			$m12str .= '</div>';
			echo $m12str;
		}
	}
	
}
	$newaddmodules = false;
	if(!empty($modulearr)){
		foreach($modulearr as $k=>$module){
			if($module!= 'thespacexxx' && $k != 11 && $k !=12 ){
				echo $$module;
				$newaddmodules = true;
			}
		}
	}
	?>
</div>
<input type="button" id="tdb" class="dbin" value="添加模块" style="top:50px;left:2px;position:fixed;background:#18a8f7;color: #fff;height: 25px;  width:100px; border:none;cursor:pointer;<?=(empty($mArr['mdeleted']) && empty($newaddmodules))?'display:none':'display:block'?>"/>

<div id="wcupdateblock" style="border:1px solid #e1e1e1;width:270px;height:200px;position:absolute;display:none;background:white;">
<form id="wechatform">
	<div style="text-align:center; margin-top:15px;"><?php $Upcontrol = Ebh::app()->lib('UpcontrolLib');
	$Upcontrol->upcontrol('wechatimg',1,array(),'pic');?></div>
	<div style="position:absolute; bottom:10px; left:15px;"><input type="button" value="保存" class="wcsavebtn" style="background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:100px;left:2px;cursor:pointer" /></div>
	<div style="position:absolute; bottom:10px; right:15px;"><input type="button" value="取消" class="wccancelbtn" style="background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:100px;left:2px;cursor:pointer" /></div>
</form>
</div>

<div id="cmupdateblock" style="width:718px;height:380px;position:absolute;display:none;background:white;border:1px solid #dadada">
	<?php
	$editor = Ebh::app()->lib('UMEditor');
	$editor->xEditor('cmeditor','716px','290px',empty($custommessage[0]['custommessage'])?'':$custommessage[0]['custommessage']);
	?>
	<div style="position:absolute; bottom:10px; right:100px;"><input type="button" value="保存" class="cmsavebtn" style="background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:100px;left:2px;cursor:pointer" /></div>
	<div style="position:absolute; bottom:10px; right:15px;"><input type="button" value="取消" class="cmcancelbtn" style="background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:100px;left:2px;cursor:pointer" /></div>
</div>
<div id="cmbbupdateblock" style="width:959px;height:380px;position:absolute;display:none;background:white;border:1px solid #dadada">
	<?php
	$editor->xEditorNoimport('cmbbeditor','957px','290px',empty($custommessagebb[0]['custommessage'])?'':$custommessagebb[0]['custommessage']);
	?>
	<div style="position:absolute; bottom:10px; right:100px;"><input type="button" value="保存" class="cmbbsavebtn" style="background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:100px;left:2px;cursor:pointer" /></div>
	<div style="position:absolute; bottom:10px; right:15px;"><input type="button" value="取消" class="cmbbcancelbtn" style="background: #18a8f7;color: #fff;display: block;height: 25px;  width:60px; border:none;top:100px;left:2px;cursor:pointer" /></div>
</div>

<div style="display:none;width:790px;height:auto;overflow-x:hidden;">
<iframe  width=805 height=760 src="#" id="course_forfree" frameborder="0"></iframe>
</div>

<script src="http://static.ebanhui.com/ebh/js/drag/Sortable.js"></script>
	
<script>

$.each($('#deletedblocks>.mo'),function(){
		var imgc = document.createElement('img');
		imgc.setAttribute('src','http://static.ebanhui.com/ebh/tpl/2014/images/moduleadd.png');
		imgc.setAttribute('class','addto');
		
		imgc.style.position = 'absolute';
		imgc.style.cursor = 'pointer';
		
		$(this).prepend(imgc);
		$(this).css('position','relative');
		$(this).css('float','left');
		// console.log();
	});
	
$('.delbtn').click(function(e){
	// objlength --;
	////////////////////var a = document.createElement('div');
	var pnode = e.target.parentNode.parentNode;
	////////////////////var level = pnode.parentNode.getAttribute('level');
	///////////////////a.setAttribute('level',level);
	var imgc = document.createElement('img');
	imgc.setAttribute('src','http://static.ebanhui.com/ebh/tpl/2014/images/moduleadd.png');
	imgc.setAttribute('class','addto');
	
	// console.log(pnode.firstChild);
	
	imgc.style.position = 'absolute';
	imgc.style.cursor = 'pointer';
	// pnode.appendChild(imgc);
	pnode.insertBefore(imgc,pnode.firstChild);
	// imgc.insertBefore();
	// a.appendChild(imgc);
	// a.style.position = 'absolute';
	pnode.style.position = 'relative';
	pnode.style.float = 'left';
	pnode.style.top = '0px';
	pnode.style.left = 'auto';
	/////////////////a.appendChild(pnode);
	
	
	// console.log( e.target.parentNode.parentNode.parentNode);
	// $('#deletedblocks')[0].appendChild(a);
	// e.target.parentNode.parentNode.style.position = 'absolute';
	// e.target.parentNode.parentNode.style.bottom = '0px';
	$('#deletedblocks').append(pnode);
	checknomodule();
});
function savemodule(){
	var mlv1 = '';
	var mleft = '';
	var mcenter = '';
	var mright = '';
	var mdeleted = '';
	var mArr = Array('left','center','right','deleted');
	
	$.each($('#dom3>.mo'),function(k,v){
		mlv1 = jointStr(mlv1,v.id.replace("m",""));
	});

	for(var i=0;i<4;i++){
		$.each($('.'+mArr[i]+'>.mo'),function(k,v){
			eval('m'+mArr[i]+'= jointStr(m'+mArr[i]+',v.id.replace("m",""))');
		});
	}
	$.ajax({
		url:'/aroomv2/module/saveindexmodule.html',
		type:'post',
		data:{'mlv1':mlv1,'mleft':mleft,'mcenter':mcenter,'mright':mright,'mdeleted':mdeleted},
		success:function(data){
			location.href = '/aroomv2/module/custommodule.html';
		}
	});
}
function jointStr(target,str){
	if(target=='')
		target = str;
	else
		target+= ','+str;
	return target;
}



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
            
			$(".sp_div").click(function(){
				var sp_id = $(this).attr("id");
				if(sp_id != "" && sp_id != undefined) {
					sp_id = sp_id.substring(3);
					if(sp_id != curid) {
						$(".sp_div").removeClass("leraten");
						$(this).addClass("leraten");
						$(".append_new").hide();
						// $("#itempid_" + sp_id).show();
						$("#itempid_" + sp_id).css('display','inline-block');
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
        });
		
		
	function showundersort(sid){
		var showed = $('.sbs'+sid).css('display');
	
		if(showed == 'none')
			$('.sbs'+sid).show();
		else
			$('.sbs'+sid).hide();
	}
$('h1').mouseover(function(e){
	// console.log(e);
});
// $('#m11').mouseover(function(){
	// $('#m12').css('opacity','0.2');
// });
$('.addto').live("click",function(){
	$(this).parent().css('position','');
	$(this).parent().css('float','');
	$(this).parent().css('border','none');
	$(this).parent().css('margin','0');
	
	var theid = $(this).parent().attr('id');
	if(theid == 'm3' || theid == 'm2'){
		$('#dom1').append($(this).parent());
	}
	else if(theid == 'm11' || theid == 'm12' || theid == 'm14' || theid == 'm16' || theid == 'm19'){
		$('#dom3').append($(this).parent());
	}else if($('#deletedblocks #dom1').length == 1){
		$('#dom2').append($(this).parent());
	}else{
		$('#dom0').append($(this).parent());
	}
	$(this).parent().focus();
	$(this).remove();
	
	checknomodule();
});
// $('.mo').mouseover(function(){
	// if($(this).parents('#deletedblocks').length == 0)
		// $(this).find('.delbtn:first').show();
// });
// $('.mo').mouseout(function(){
	// $(this).find('.delbtn:first').hide();
// });

// Sortable.create(dom4, { group:'a3' ,animation:150});
$('#tdb').click(function(){
	toggledb();
});
$('#savebtn').click(function(){
	savemodule();
});
$('#initbtn').click(function(){
	location.href='?init=1';
});
$('#cancelbtn').click(function(){
	location.href='/aroomv2/module/custommodule.html';
});
function toggledb(){
	H.create(new P({
		title:'添加模块',
		id:'ddd',
		content:$("#deletedblocks")[0],
		easy:true,
		padding:5
	}),'common').exec('show');
	/*
	if($('#tdb').attr('class') == 'dbin'){
		$('#deletedblocks').css('width','760px');
		$('#tdb').attr('class','dbout');
	}else{
		$('#deletedblocks').css('width','0px');
		$('#tdb').attr('class','dbin');
	}*/
}
$(function(){
	$('a').attr('href','javascript:void(0)');
	$('a').attr('target','');
	$('input').attr('onclick','');
	rightfix();
});
function checknomodule(){
	if($('#deletedblocks').children().length == 0){
		$('#tdb').hide();
		// $('#deletedblocks').css('width','0px');
		$('#tdb').attr('class','dbin');
		H.remove('ddd');
	}
	else{
		$('#tdb').show();
	}
	rightfix();
}



var showwc = false;
$('.wcupdate').click(function(e){
	$('#wcupdateblock').css('top',e.pageY+20);
	$('#wcupdateblock').css('left',e.pageX+10);
	if($('#wcupdateblock').css('display') == 'none'){
		$('#wcupdateblock').show();
	}else{
		$('#wcupdateblock').hide();
	}
	
});
// $('body').click(function(e){
	// obj = e.srcElement ? e.srcElement : e.target;
	// if(obj.parentNode == $('#wcupdateblock')[0] || obj == $('#wcupdateblock')[0])
		// ;
	// else if(showwc == false){
		// $('#wcupdateblock').hide();
	// }
	// showwc = false;
// });
$('.wcsavebtn').click(function(){
	$.ajax({
		url:'/aroomv2/module/savewechat.html',
		type:'post',
		data:$("#wechatform").serialize(),
		success:function(){
			var wbi = $("#wechatimg\\[upfilepath\\]").val();
			if(wbi == '')
				wbi = 'http://static.ebanhui.com/ebh/tpl/2014/images/ebh_wx.png';
			$('#wcimage').attr('src',wbi);
		}
	});
	$('#wcupdateblock').hide();
});
$('.wccancelbtn').click(function(){
	$('#wcupdateblock').hide();
});
$('.xiaoshan .cmupdate').live('click',function(e){
	// console.log($('#cmblock')[0].offsetTop);
	
	$('#cmupdateblock').css('top',$('#cmblock')[0].offsetTop-38);
	$('#cmupdateblock').css('left',$('#cmblock')[0].offsetLeft);
	$('#cmupdateblock').show();
	$('#m14').css('height','385px');
	$('#cmcontent,.cmupdate').hide();
});
$('.xiaoshan .cmbbupdate').live('click',function(e){
	// console.log($('#cmblock')[0].offsetTop);
	
	$('#cmbbupdateblock').css('top',$('#cmbbblock')[0].offsetTop-38);
	$('#cmbbupdateblock').css('left',$('#cmbbblock')[0].offsetLeft);
	$('#cmbbupdateblock').show();
	$('#m19').css('height','385px');
	$('#cmbbcontent,.cmbbupdate').hide();
});
$('.cmsavebtn').click(function(){
	var custommessage = UM.getEditor('cmeditor').getContent();
	$.ajax({
		url:'/aroomv2/module/savecustommessage.html',
		type:'post',
		data:{'custommessage':custommessage,'index':1},
		success:function(){
			$('#cmblock>div').html(custommessage);
		}
	});
	$('#cmupdateblock').hide();
	$('#m14').css('height','auto');
	$('#cmcontent,.cmupdate').show();
});
$('.cmbbsavebtn').click(function(){
	var custommessage = UM.getEditor('cmbbeditor').getContent();
	$.ajax({
		url:'/aroomv2/module/savecustommessage.html',
		type:'post',
		data:{'custommessage':custommessage,'index':2},
		success:function(){
			$('#cmbbblock>div').html(custommessage);
		}
	});
	$('#cmbbupdateblock').hide();
	$('#m19').css('height','auto');
	$('#cmbbcontent,.cmbbupdate').show();
});
$('.cmcancelbtn').click(function(){
	$('#cmupdateblock').hide();
	$('#m14').css('height','auto');
	$('#cmcontent,.cmupdate').show();
});
$('.cmbbcancelbtn').click(function(){
	$('#cmbbupdateblock').hide();
	$('#m19').css('height','auto');
	$('#cmbbcontent,.cmbbupdate').show();
});
$('.banner').click(function(){
	window.open('/aroomv2/information/ad.html?type=2');
});
$('.xiaoshan #m2 img').live('click',function(){
	window.open('/aroomv2/information/ad.html?type=1');
});
$('.xiaoshan #m18 img').live('click',function(){
	window.open('/aroomv2/information/ad.html?type=3');
});
$('.appd>div').click(function(){
	window.open('/aroomv2/information/app.html');
});
$('.wxzixun>div').click(function(){
	window.open('/aroomv2/information/datainfor.html');
});
$('.wxzixun a').click(function(){
	var itemid = $(this).attr('itemid');
	window.open('/aroomv2/information/datainfor/edit.html?itemid='+itemid);
});
$('.survey>div').click(function(){
	window.open('/aroomv2/more/survey.html');
});

$('.freesees .mores').live('click',function(){
	freecourse();
});
function freecourse(){
	$("#course_forfree").attr('src','/aroomv2/module/freecourse.html');
	H.create(new P({
		title:'设置免费试看片',
		id:'freec',
		content:$("#course_forfree")[0],
		easy:true,
		padding:5
	}),'common').exec('show');
}
function showsuccess(){
	$.showmessage({
		message:'设置完成',
		callback:function(){
			realoadfreecourse();
		}
	});
}
function realoadfreecourse(){
	$.ajax({
		type:'get',
		url:'/aroomv2/module/getfreecourse.html',
		success:function(data){
			var freelist = eval('('+data+')');
			// $('.freesees_son ul').html('');
			listhtml = '';
			$.each(freelist,function(k,v){
				listhtml += '<li class=" fl "><a href="javascript:void(0)" class="opens"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png" /></a>								<div class="kcbj"><img src="'+(v.logo?v.logo:'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png')+'" /></div><div class="shichang">'+v.title+'</div><input type="hidden" value="'+v.cwid+'"><span class="frdel" title="点击取消免费试看"> × </span></li>';
			});
			listhtml += '<li class=" fl "><a href="javascript:void(0)" class="mores">点击编辑</a></li>';
			$('.freesees_son ul').html(listhtml);
		}
		
	});
}
$('.frdel').live('click',function(){
	setfree($(this).prev().val());
	$(this).parent().remove();
});
function setfree(cwid){
	var dataarr = new Array();
		dataarr[0] = new Object();
		dataarr[0].cwid = cwid;
		dataarr[0].isfree = 0;

	$.ajax({
		type:'post',
		url:'/aroomv2/module/savefreecourse.html',
		data:{'checkarr':dataarr},
		success:function(data){
		}
	});
}
function rightfix(){
	$('#dom2>.mo').css('margin-top','0px');
	if(!$('#dom3>#m19').length)
		return;
	var cmbbtop = $('#m19')[0].offsetTop;
	var cmbbheight = $('#m19')[0].offsetHeight;
	var lastbottom = 322;
	
	$.each($('#dom2>.mo'),function(k,v){
		// console.log(v.offsetHeight+v.offsetTop);
		// console.log(cmbbtop);
		// console.log(cmbbtop+cmbbheight);
		// console.log(v.offsetTop);
		// console.log('---------------------');
		if(v.offsetTop+v.offsetHeight>cmbbtop && cmbbtop+cmbbheight>v.offsetTop){
			// console.log(cmbbtop+cmbbheight);
			// console.log(lastbottom);
			
			$(v).css('margin-top',cmbbtop+cmbbheight-lastbottom+'px');
			return false;
		}
		lastbottom = v.offsetTop+v.offsetHeight;
	});
}
$('#deletedblocks .mo').live('mouseover',function(){
	$(this).css('border','2px solid red');
	$(this).css('margin','8px');
});
$('#deletedblocks .mo').live('mouseout',function(){
	$(this).css('border','none');
	$(this).css('margin','10px');
});
Sortable.create(dom2, { group:'a1', animation:0, onUpdate:function(){rightfix()}});
Sortable.create(dom1, { group:'a2', animation:0, onUpdate:function(){rightfix()}});
Sortable.create(dom0, { group:'a1', animation:0, onUpdate:function(){rightfix()}});
Sortable.create(dom3, { group:'a3', animation:0, onUpdate:function(){rightfix()}});
/*
$('#summary_p').live('click',function(){
	$(this).hide();
	$('#summary_div').show();
});
$('#summary_div').live('blur',function(){
	$(this).hide();
	$('#summary_p').show();
});
*/
</script>
<?php $this->display('common/footer')?>