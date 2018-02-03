<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title>动态资讯</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>


<body>
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
	<div class="dtzxs">
    	<div class="title1"></div>
        <div class="dtzxs_son">
        	<div class="fr"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/fhsy.jpg" /></a></div> 
         	<div class="clear"></div>
            <div>
                <div class="dtzxs_son_t">
                    <div class="title4 ">《黄金双宫格配套教材及练习纸》</div>
                    <div class="times ">发表于：2015-06-12 10:22:18 阅读(298)次</div>
                </div>
                <div class="dtzxs_son_c" style="height: 138px;">
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
			<?php foreach($mitemlist as $mitem){?>
            <div class="clear"></div>
            <div style="min-height:165px; height:auto;">
                <div class="dtzxs_son_t mt30">
                    <div class="title4 "><a title="<?= $mitem['subject']?>" href="<?=geturl('dyinformation/'.$mitem['itemid'])?>" target="_blank"><?= shortstr($mitem['subject'],50)?></a></div>
                    <div class="times ">发表于：<?= date('Y-m-d H:i:s',$mitem['dateline'])?> 阅读(<?= $mitem['viewnum']?>)次</div>
                </div>
                <div style="margin-top:10px;">
                    <div class="fl"><img width="130px" height="98px" src="<?=empty($mitem['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$mitem['thumb']?>" /></div>
                    <div class="fl" style="width:760px;">
                        <div class="dtzxs_son_c"><p class="p1s"><?= shortstr($mitem['note'],350)?></p></div>
                        <div class="dtzxs_son_b">
                            <div class="ydqw fr"><a target="_blank" href="<?=geturl('dyinformation/'.$mitem['itemid'])?>">阅读全文</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
<script>
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
