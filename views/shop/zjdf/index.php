<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title><?=$room['crname']?></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<style>
.ybsf_son_bottom .vip{
	width:25px;
}
</style>
<body style="background:#f9f9f9;">
<div class="wrap">
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
            <ul class="quick-menu">
                <li><a href="http://jiazhang.ebh.net/" target="_blank" class="cent">家长监控平台</a> | </li>
				<li><a target="_blank" class="cent" href="http://soft.ebh.net/ebhbrowser.exe">锁屏浏览器</a> | </li>
				<li><a href="javascript:void(0);" onclick="SetHome(this,window.location);" class="cent">设为主页</a></li>
            </ul>
		</div>
	</div>
    <div class="clear"></div>
    <div class="banner"></div>
    <!--平台简介和用户登录-->
    <div style="width:960px; margin:0 auto;">
    <!--平台简介-->
    	<div class="ptjj fl">
        	<div><a href="/introduce.html"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/ptjj.png" /></a></div>
            <div class="ptjj_son">
            	<h1>浙江东方文化艺术院</h1>
                <p>浙江东方文化艺术院与浙江新盛蓝科技有限公司合作，通过e板会云教学平台，开设了快学快写黄金双宫格硬笔书法网上学校，域名为：zjdf.ebh.net。以浙江东方文化艺术院在组织编写的《黄金双宫格硬笔书法教材》作为授课教材，聘请省书法家协会有丰富教学经验的书法家授课，使学生们在家就能得到名师的写字指导。内容有：</p><p>1、向“小书法家”免费开放黄金双宫格硬笔书法基本课程 (5节课)</p><p>2、黄金双宫格硬笔书法初级班，主要讲述汉字的书写规则、笔画的行笔要点 (16节课)</p><p>3、黄金双宫格硬笔书法中级班，主要讲述硬笔书法的间架结构及黄金双宫格的书写要点 (16节课)</p><p>浙江东方文化艺术院后续还将开发硬笔书法高级班、毛笔书法班、篆刻班等。在课程教学活动中教师和学生进行互动，学生可以在线提问，老师可以在线回答或者离线回复。进行作业点评等。对学完阶段性课程的学生，由浙江东...<a href="/introduce.html" style="color:#646464;">更多》</a></p>
            </div>
        </div>
        <!--用户登录-->
        <div class="yhdl">
		<?php if(!empty($user)) { 
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
			if($room['uid'] == $user['uid']){
				$url = geturl('aroomv2');
			}else{
				$url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
            }
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
            <input class="logbtn3" type="submit" onclick="window.location.href='<?= $url ?>'" value="" name="Submit">
			
			<?php $hszcrid = 10420; ?>
                <div class="jky"><p><?php if($user['groupid'] == 6) { ?><a href="<?= geturl('member') ?>">个人中心</a><em style="margin-left:20px; margin-right:20px;">|</em><?php }else{ ?><em style="margin-left:20px; margin-right:20px;"></em><?php }?><a href="/logout.html">退出</a></p></div>
                <div class="eiwje">

                </div>
		</div>
        <?php }else{?>
		<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
		<input type="hidden" name="loginsubmit" value="1" />
        	<div class="recrig">
            	<span class="qianle">帐号：</span>
                <input type="text" value="" name="username" id="username" class="txtuser">
                <span class="qianle">密码：</span>
                <input type="password" value="" name="password" id="password" class="txtpass">
                <p class="zidong">
					<input type="checkbox" checked="checked" value="1" name="cookietime" style="vertical-align: middle;" id="cookietime">
					<label class="rybtnat" for="cookietime">下次自动登录</label>
					<a class="lgaidst" href="/forget.html" target="_blank">忘记密码？</a>
                </p>
                <input type="submit" value="" name="Submit" class="denglubtn">
                <div class="eiwje">
                	<div style="width:270px;float:left;" class="qtlol">
                    	<span class="gekrjty">用其他账号登录：</span>
                        <a href="/otherlogin/qq.html"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/qqico0925.jpg"></a>
                        <a href="/otherlogin/sina.html"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/sianico0925.jpg"> </a>
                    </div>
                </div>
    		</div>
		</form>
		<?php }?>
        </div>
    </div>
    <div class="clear"></div>
    <!--硬笔书法-->
    <div class="ybsf">
        <div class="title1"></div>
        <div class="ybsf_son">
        	<div class="title2">试听课程</div>
            <div class="ybsf_son_top mt5" style="height: 112px;">
                <div class="pics fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kecheng.jpg" /></div>
                <div class="fl" style="width:676px;">
                    <h2>周乃威老师（浙江省书法家协会会员、浙江东方文化艺术院特聘书法老师、西泠印社教育培训中心书法老师）</h2>
                    <p>主要介绍了黄金双宫格的书写要点，通过黄金双宫格硬笔书法写字练习，快速掌握写字技巧，结合平时练习，相信大家能够写出漂亮的钢笔字。</p>
                </div>
            </div>
            <div class="clear"></div>
            <!--试听课程-->
			<?php if(empty($user)){
					$tclass = 'dologin';
				}elseif($user['groupid'] == 6){
					$tclass = 'viewc';
				}else{
					$tclass = '';
				}
			?>
				
            <div class="ybsf_son_bottom">
                <div class="mt15">
                    <ul>
                        <li class="fl first">
                            <div><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/29183.html" class="<?=$tclass?>"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kecheng1.jpg" height="91" width="158" /></a></div>
                            <div>
                                <div class="mian fl"><span class="span1">免</span> </div>
                                <div class="mians fl">第一课</div>
                            </div>
                            <div class="clear"></div>
                            <div class="hjsggjs"><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/29183.html" class="<?=$tclass?>">黄金双宫格介绍</a></div>
                        </li>
                        <li class="fl">
                            <div><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34449.html" class="<?=$tclass?>"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kecheng2.jpg" height="91" width="158" /></a></div>
                            <div>
                                <div class="mian fl vip"><span class="span1">vip</span> </div>
                                <div class="mians fl">第二课</div>
                            </div>
                            <div class="clear"></div>
                            <div class="hjsggjs"><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34449.html" class="<?=$tclass?>">黄金双宫格的书写要领 </a></div>
                        </li>
                        <li class="fl">
                            <div><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34417.html" class="<?=$tclass?>"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kecheng3.jpg" height="91" width="158" /></a></div>
                            <div>
                                <div class="mian fl vip"><span class="span1">vip</span> </div>
                                <div class="mians fl">第三课</div>
                            </div>
                            <div class="clear"></div>
                            <div class="hjsggjs"><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34417.html" class="<?=$tclass?>">硬笔书法之突主笔</a></div>
                        </li>
                        <li class="fl">
                            <div><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34418.html" class="<?=$tclass?>"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kecheng4.jpg" height="91" width="158" /></a></div>
                            <div>
                                <div class="mian fl vip"><span class="span1">vip</span> </div>
                                <div class="mians fl">第四课</div>
                            </div>
                            <div class="clear"></div>
                            <div class="hjsggjs"><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34418.html" class="<?=$tclass?>">硬笔书法之勾的伸展</a></div>
                        </li>
                        <li class="fl">
                            <div><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34419.html" class="<?=$tclass?>"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kecheng5.jpg" height="91" width="158" /></a></div>
                            <div>
                                <div class="mian fl vip"><span class="span1">vip</span> </div>
                                <div class="mians fl">第五课</div>
                            </div>
                            <div class="clear"></div>
                            <div class="hjsggjs"><a href="javascript:void(0);" name="http://zjdf.ebh.net/myroom/mycourse/34419.html" class="<?=$tclass?>">硬笔书法之点的外延和框形的外延</a></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
			<?php 
				$first = true;
				foreach($splist as $sp){
				$lastsid = '';
				foreach($sp['itemlist'] as $k=>$item) {
					if($first){
						$first = false;
						continue;
					}
					if(empty($user))
						$fsurl = 'href="javascript:void(0);" class="dologin previewBtn" name="/ibuy.html?itemid='.$item['itemid'].'"';
					elseif($user['groupid'] == 6){
						if($item['fprice'] == 0 || isset($mylist[$item['folderid']])) {
							$fsurl = 'href="/myroom/stusubject/'.$item['folderid'].'.html" target="_blank" class="scbtnBtn"';
						}else{
							$fsurl = 'href="/ibuy.html?itemid='.$item['itemid'].'" target="_blank" class="previewBtn"';
						}
					}
						
					else
						$fsurl = 'href="javascript:void(0);" onclick="alert(\'对不起，您是教师账号，不允许进行此操作。\')" class="previewBtn"';
					
					?>
				
					<div class="ybsf_son_top mt20 fl">
					<?php 
					if($item['sid'] != $lastsid){
						$lastsid = $item['sid'];
				?>
            
            	<div class="title2"><?=$item['sname']?></div>
					<?php }?>
                <div class="pics fl" style="height:131px;"><img style="height:131px;width:230px" src="<?=$item['simg']?>" /></div>
                <div class="fl" style="width:676px;">
                    <h2>
					<?=$item['speaker']?>
					</h2>
                    <p><?=$item['summary']?></p>
					<?php if(!isset($mylist[$item['folderid']]) && $item['fprice'] != 0 || $user['groupid']!=6) {?>
						<span style="float:right;width:102px; margin-right:10px;"><a <?=$fsurl?> style="font-family: 宋体;" >报&nbsp;名</a></span>
					<?php }else{?>
						<span style="float:right;width:102px; margin-right:10px;"><a <?=$fsurl?> style="font-family: 宋体;" >进&nbsp;入</a></span>
					<?php }?>
                </div>
            </div>
			<?php 
				}
			}?>
        </div> 
    </div>
    <div class="clear"></div>
    <!--动态资讯-->
    <div class="dtzx">
        <div><a href="/dyinformation.html"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/dtzx.png" /></a></div>
        <div class="dtzx_son">
        	<div>
                <div class="dtzx_son_t">
                    <div class="title4 fl">《黄金双宫格配套教材及练习纸》</div>
                    <div class="times fr">2015-06-12 10:22:18</div>
                </div>
                <div class="clear"></div>
                <div class="dtzx_son_c" style="height: 138px;">
                    <div class="fl" style="margin-right:40px;">
                        <div class="fl mt10" style="margin-left:15px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/jiaocai1.png" height="128" width="100" /></div>
                        <div class="fl" style="margin-top:20px; font-size:14px;">
                            <span style="padding-left:10px;">学生用书</span>
                            <br />
                            <img src="http://static.ebanhui.com/ebh/tpl/2014/images/pj.png" width="92" height="26" />
                            <p class="pps1">价格：<span style="color:#f50c0c;">12元/本</span></p>
                            <p class="pps">（注：购买50本以上8.8折优惠）</p>
                        </div>
                    </div>
                    <div class="fl ml45">
                        <div class="fl mt10" style="margin-left:15px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/jiaocai2.png" height="128" width="100" /></div>
                        <div class="fl" style="margin-top:20px; font-size:14px;">
                            <span style="padding-left:10px;">教师用书</span>
                            <br />
                            <img src="http://static.ebanhui.com/ebh/tpl/2014/images/pj.png" width="92" height="26" />
                            <p class="pps1">价格：<span style="color:#f50c0c;">10元/本</span></p>
                            <p class="pps">（注：购买50本以上8.8折优惠）</p>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="margin-left:40px; margin-top:20px;"><p class="pps2">购买联系方式：0571-85533381    18267161857    18258152965</p></div>
            </div>
            <div class="clear"></div>
			<?php foreach($mitemlist as $mitem){?>
        	<div >
                <div class="dtzx_son_t mt30">
                    <div class="title4 fl"><?=$mitem['subject']?></div>
                    <div class="times fr"><?=Date('Y-m-d H:i:s',$mitem['dateline'])?></div>
                </div>
                <div class="clear"></div>
                <div class="dtzx_son_c"><p class="p1s"><?=$mitem['note']?></p></div>
                <div class="dtzx_son_b">
                    <div class="ydqw fr"><a target="_blank" href="<?=geturl('dyinformation/'.$mitem['itemid'])?>">阅读全文</a></div>
                </div>
            </div>
			<?php }?>
            
        </div>
    </div>
    <div class="clear"></div>
    <!--底部-->
    <div class="footer">
    	<div style="width:960px; margin:0 auto; line-height:32px;">
    		<div><p class="pp1">: 浙江东方文化艺术院书画艺术中心</p></div>
            <div class="clear"></div>
            <div><p class="pp2">: 0571-85533381</p></div>
            <div class="clear"></div>
            <div><p class="pp3">: zjdf85533381@yeah.net </p></div>
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
var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
$('.viewc').click(function(){
	window.open($(this).attr('name'));
});
</script>
<?php $this->display('common/footer');?>
