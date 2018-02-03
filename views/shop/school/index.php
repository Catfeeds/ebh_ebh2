<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?=$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css?v=0617" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
    var sitecpurl = '#getsitecpurl()#';
//-->
</script>
<style type="text/css">
.qtlol .gekrjty {
	font-size:16px;
	font-family:微软雅黑;
	color:#808080;
	font-weight:bold;
	margin-left:45px;
}
.qtlol a {
	margin-top:3px;
}
.qtlol {
	height: 27px;
	padding-top: 8px;
	margin-left:12px; 
	display:inline;
}
.toptem .rigkic {width:820px;}
.toptem .rigkic .dianhua {min-width:310px;overflow: hidden;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/dzumico0626.jpg) no-repeat 0 10px;word-wrap: break-word;overflow: hidden;}
.toptem .rigkic .elanbn {min-width:180px;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/homepage.jpg) no-repeat 0 10px;overflow: hidden;margin-right:8px;}
.toptem .rigkic .deteme {overflow: hidden;width:630px;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/tadaico0626.jpg) no-repeat 0 8px;}
.weixin{ float:right; display:inline; height:100px; width:100px; position:relative; top:-8px; color:#666;}
.weixin > span {display: block;text-align: center;width: 103px;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>"></script>
<!--系统更新提示>
<div style="background:#ff8800;font-size:14px;color:#fff;z-index: 10;height:30px;line-height:30px;width:100%;text-align:center;font-family: Microsoft Yahei;"><img style="vertical-align: text-bottom;" src="http://static.ebanhui.com/ebh/tpl/2016/images/zhuyi01.jpg" />亲爱的用户：为了给您提供更优质的服务，系统将于06月28号22点30分进行升级，期间可能会出现服务中断情况，敬请谅解！</div><!-->
<?php $this->display('common/public_header'); ?>
<?php $logo = empty($room['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg' : $room['cface']; ?>
<div class="toptem">
    <div class="keaie"><img width="100" height="100" src="<?= $logo ?>" alt="<?= $room['crname'] ?>"/></div>
    <div class="rigkic">
        <h2 class="kichtwo"><?= $room['crname'] ?></h2>
		<?php $cremail=substr($room['cremail'],0,7); ?>
		<p class="elanbn"><?php if (!empty($room['cremail'])) { ?><a href="<?= ($cremail=='http://')?$room['cremail']:'http://'.$room['cremail'] ?>" target="_blank" style="color:#2aa0e6;"><?= $room['cremail'] ?></a><?php }else{echo 'http://'.$room['domain'].'.'.$this->uri->curdomain;} ?></p>
        <p class="dianhua"><?= $room['crphone'] ?></p>
        
        <p class="deteme"><?= $room['craddress'] ?></p>
    </div>
	<?php if($room['domain'] == 'zjgxedu') { ?>
	<div class="weixin"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/zjgxedu.jpg"/><span>微信听课平台</span></div>
	<?php } ?>
</div>

<div class="adsolma">
    <div class="recdis">
        <div class="reclef">
            <h2 class="gongs" title="<?= $send['message']?>">公告：<?= shortstr($send['message'],86)?></h2>
            <div class="admamm">
                <?php
				$randindex = rand(0,5);
				$imgsrc = 'http://static.ebanhui.com/ebh/citytpl/stores/images/laistdg'.$randindex.'.jpg';
				if(!empty($adlist))
					$imgsrc = $adlist[0]['thumb'];
 
                ?>
<img width="640" height="132" src=" <?=$imgsrc?>">
            </div>
            <div class="thren">
			<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/ebh/flash/circlefect.swf" width="639"
				height="106" id="blog_index_flash_ff">
				<param name="quality" value="high" />
				<param name="wmode" value="transparent" />
				<param name="menu" value="false">
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="true" />
				<param name="movie" value="http://static.ebanhui.com/ebh/flash/circlefect.swf" /><!--兼容ie6-->
			</object>
		</div>
        </div>
        <!--登录后-->
        <?php if(!empty($user)) { 
            $sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
			if($room['uid'] == $user['uid']){
				$url = geturl('aroomv2');
			}else{
				$troomurl = gettroomurl($room['crid']);
				$url = $user['groupid'] == 5 ? $troomurl : geturl('myroom');
            }
        ?>
        <div class="recrig">
            <div class="usouter">
                <div class="figlef">
                    <img src="<?= $facethumb ?>" /></div>
                <div class="showrig">
                    <h2 style="font-weight:bold; font-size:14px; color:#3195c6;width:110px;max-height: 22px;overflow:hidden;"><?= $user['username'] ?></h2>
                    <p>上次登录时间：</p>
                    <p><?= $user['lastlogintime']?></p>
                </div>
            </div>
            <input class="logbtn3" type="submit" onclick="window.location.href='<?= $url ?>'" value="" name="Submit">
			
			<?php $hszcrid = 10420; ?>
                <div class="jky"><p><?php if($user['groupid'] == 6 && $room['crid']!=$hszcrid) { ?><a href="<?= geturl('member') ?>">个人中心</a><em style="margin-left:20px; margin-right:20px;">|</em><?php }else{ ?><em style="margin-left:20px; margin-right:20px;"> </em><?php }?><a href="/logout.html">退出</a></p></div>
                <div class="eiwje">

                </div>
        <?php } else { ?>
                <form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
                    <input type="hidden" name="loginsubmit" value="1" />

                    <div class="recrig">
                        <span class="qianle">帐号：</span>
                        <input class="txtuser" id="username" name="username" type="text" value="" />
                        <span class="qianle">密码：</span>
                        <input class="txtpass" id="password" name="password" type="password" value=""/>
                        <p class="zidong">
                            <input type="checkbox" id="cookietime" style="vertical-align: middle;" name="cookietime" value="1"  checked='checked'/>
                            <label for="cookietime" class="rybtnat">下次自动登录</label>
							<a href="<?=geturl('forget')?>" class="lgaidst">忘记密码？</a>
                        </p>
                        <input class="denglubtn" type="submit" name="Submit" value="" />
                        <div class="eiwje">
                            <div class="qtlol" style="width:270px;float:left;">
                                <span class="gekrjty">用其他账号登录：</span>
                                <a href="<?=getopenloginurl('qq',$currentdomain)?>">
                                    <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/qqico0925.jpg">
                                </a>
                                <a href="<?=getopenloginurl('sina',$currentdomain)?>">
                                    <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/sianico0925.jpg">
                                </a>
                                <a href="<?=getopenloginurl('wx',$currentdomain)?>">
                                <img src="https://open.weixin.qq.com/zh_CN/htmledition/res/assets/res-design-download/icon16_wx_logo.png">
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
        <?php } ?>
        </div>
    </div></div>
    <div style="clear:both;"></div>
    <?php
    $this->display('common/footer');
    ?>