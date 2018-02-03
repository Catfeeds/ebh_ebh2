<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<style type="text/css">
.toptem .rigkic {width:800px;}
.toptem .rigkic .dianhua {width:580px;overflow: hidden;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/dzumico0626.jpg) no-repeat 0 10px;word-wrap: break-word;overflow: hidden;}
.toptem .rigkic .elanbn {width:180px;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/homepage.jpg) no-repeat 0 10px;overflow: hidden;}
.toptem .rigkic .deteme {overflow: hidden;width:780px;background:url(http://static.ebanhui.com/ebh/citytpl/stores/images/tadaico0626.jpg) no-repeat 0 8px;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<?php $this->display('common/public_header'); ?>
<?php $logo = empty($room['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg' : $room['cface']; ?>
<div class="toptem">
    <div class="keaie"><img width="100" height="100" src="<?= $logo ?>" alt="<?= $room['crname'] ?>"/></div>
    <div class="rigkic">
        <h2 class="kichtwo"><?= $room['crname'] ?></h2>
        
        <p class="elanbn"><?php if (!empty($room['cremail'])) { ?><a href="http://<?= $room['cremail'] ?>" target="_blank" style="color:#2aa0e6;"><?= $room['cremail'] ?></a><?php } ?></p>
		<p class="dianhua"><?= $room['crphone'] ?></p>
        <p class="deteme"><?= $room['craddress'] ?></p>
    </div>


		  <?php if(empty($user)){
				$cloudaddurl=geturl('classactive');
		  }else{
				if($user['groupid']==6){
					$cloudaddurl=geturl('classactive');
				}else{
					$cloudaddurl="javascript:alert('对不起，您是教师账号，不可以进行在线购买。');";
				 }	
		  } ?>
			<?php if(!empty($user)){ ?>
			<a class="tijibtn" href="<?= $cloudaddurl?>">在线购买</a>
			<?php }else{ ?>
			<a class="tijibtn dialogLogin" name='<?= $cloudaddurl ?>' href="javascript:;">在线购买</a>
			<?php } ?>

</div>


<div class="adsolma">
    <div class="recdis">
        <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/huiyit0626.jpg" />
        <div class="reclef">
            <h2 class="gongs" title="<?= $send['message']?>">公告：<?= shortstr($send['message'],86)?></h2>
            <div class="admamm">
                <?php
                $this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 640, '_height' => 132, 'default' => 'http://static.ebanhui.com/ebh/citytpl/stores/images/adzhong0626.jpg'));
                ?>
            </div>
            <div class="thren">
			<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/ebh/flash/circlefect.swf" width="639"
				height="106" id="blog_index_flash_ff">
				<param name="quality" value="high" />
				<param name="FlashVars" value="url=<?= empty($url)?'':$url?>" />
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
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
            
        ?>
        <div class="recrig">
            <div class="usouter">
                <div class="figlef">
                    <img src="<?= $facethumb ?>" /></div>
                <div class="showrig">
                    <h2 style="font-weight:bold; font-size:14px; color:#3195c6;"><?= $user['username'] ?></h2>
                    <p>上次登录时间：</p>
                    <p><?= $user['lastlogintime']?></p>
                </div>
            </div>
            <input class="logbtn3" value="" name="Submit">
                <div class="jky"><p><?php if($user['groupid'] == 6) { ?><a href="<?= geturl('member') ?>">个人中心</a><?php } ?><em style="margin-left:20px; margin-right:20px;">|</em><a href="/logout.html">退出</a></p></div>
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
                            <input type="checkbox" id="cookietime" name="cookietime" value="1"  checked='checked'/>
                            <label for="cookietime">下次自动登录</label>
                        </p>
                        <input class="denglubtn" type="submit" name="Submit" value=""/>
                        <div class="eiwje">
                            <div class="qtlol" style="border-right:solid 1px #dcd8d8;float:left;height: 27px;padding-top: 12px;margin-left:12px; display:inline;">
                                <span style="color:#808080;">用其他账号登录：</span>
                                <a href="<?=geturl('otherlogin/qq')?>">
                                    <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/qqico0925.jpg">
                                </a>
                                <a href="<?=geturl('otherlogin/sina')?>">
                                    <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/sianico0925.jpg">
                                </a>
                            </div>
                            <a class="wrent" href="<?= geturl('forget')?>">忘记密码？</a>
                        </div>
                    </div>
                </form>
        <?php } ?>
        </div>
    </div>
	<div style="clear:both;"></div>
	</div>
<div style="width: 960px;padding:15px 0;margin:0 auto;color:#787878;border-bottom:solid 1px #f7f7f7;">
    <h2 style="background:#f7f7f7;height22px;line-height:22px;border-left:solid 2px #3bb6fa;padding-left:10px;font-size:16px;">学校简介</h2>
    <p style="width:910px;float:left;margin:15px 0 30px 25px;;text-indent: 25px;word-break: break-all;overflow: hidden;display:inline;font-size:14px;line-height:1.8;word-break : normal;">
      <?= $roominfo['summary'] ?>
    <p>
</div>

    <div style="clear:both;"></div>
	<script type="text/javascript">
<!--
	$(".dialogLogin").click(function(){
	if ($(this).attr("name") != '') {
		$.loginDialog($(this).attr("name"));
	}else{
		$.loginDialog();
	}
	
});
//-->
</script>
    <?php
    $this->display('common/footer');
    ?>