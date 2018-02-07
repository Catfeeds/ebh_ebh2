<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php
        $systemsetting = Ebh::app()->room->getSystemSetting();
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
        if (empty($varpool['currentdomain'])) {
            $varpool['currentdomain'] = getdomain();
        }
    //是否禁用用户注册功能
    $open_register = true;
    if (isset($appsetting['dis_registerable']) && is_array($appsetting['dis_registerable']) && in_array($roomdetail['crid'], $appsetting['dis_registerable'])) {
        $open_register = false;
    }
    ?>
    <script type="text/javascript">
        if (self != top) {
            top.location.href = "/";
        }
        var surveyMessage = "<?= $appsetting['szlz'] != $systemsetting['crid'] ? false:true ?>";
        //var is
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?= empty($systemsetting['metakeywords']) ? $roomdetail['crlabel'] : $systemsetting['metakeywords'] ?>" />
	<!-- 微信端 过来查看 允许缩放 -->
	<meta name="viewport" content="width=1200, user-scalable=<?=(is_weixin()==true)?"yes":"no"?>" />
    <meta name="description" content="<?= empty($systemsetting['metadescription']) ? $roomdetail['summary'] : $systemsetting['metadescription']?>" />
    <?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
    <?php }?>
    <title><?=!empty($inner_data['title']) ? $inner_data['title'] : $roomdetail['crname']?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/module.css?v=201708290001" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/js/html5.hack.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160614001"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/courseware.css?v=201705130001" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/newindex.css?v=201705250004" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/course_type_menu_theme.css?v=201705130001" />
    <?php if (!empty($has_slide)) { ?>
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/flexslider/css/flexslider.css?v=201705160002" />
        <script src="http://static.ebanhui.com/ebh/js/flexslider/js/jquery.flexslider-min.js"></script>
    <?php } ?>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate.js?v=201708290001"></script>
    <?php if (!empty($roomdetail['isdesign'])) { ?>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/design/css/common.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/design/css/module.css" />
        <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160614001"></script>
        <style>
            body {
                <?php if (!empty($settings['bg'])) { ?>background-color: <?=$settings['bg'];?> !important; /*page.bg*/<?php } ?>
                <?php if (!empty($settings['bgImage'])) { ?>background-image:<?=stripcslashes($settings['bgImage']['backgroundImage'])?> !important;<?php } ?>
                <?php if (!empty($settings['bgImage']['backgroundSize'])) { ?>background-size:<?=$settings['bgImage']['backgroundSize']?> !important;<?php } ?>
                <?php if (!empty($settings['bgImage']['backgroundRepeat'])) { ?>background-repeat:<?=$settings['bgImage']['backgroundRepeat']?> !important;<?php } ?>
                <?php if (!empty($settings['bgImage']['backgroundAttachment'])) { ?>background-attachment:<?=$settings['bgImage']['backgroundAttachment']?> !important;<?php } ?>
                background-position:top center !important;
            }
            .module a[href]:hover{
                <?php if (!empty($settings['fontHover'])) { ?>color:<?=$settings['fontHover']?>;<?php } ?>
            }
            .content {
                <?php if (!empty($settings['width'])) { ?>width: <?=$settings['width'];?>; /*page.width*/<?php } ?>
                <?php if (!empty($settings['height'])) { ?>height: <?=$settings['height'];?>; /*page.height*/<?php } ?>
                <?php if (!empty($settings['pg'])) { ?>background-color: <?=$settings['pg'];?>; /*page.pg*/<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundImage'])) { ?>background-image:<?=stripcslashes($settings['pgImage']['backgroundImage'])?>;<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundSize'])) { ?>background-size:<?=$settings['pgImage']['backgroundSize']?>;<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundRepeat'])) { ?>background-repeat:<?=$settings['pgImage']['backgroundRepeat']?>;<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundAttachment'])) { ?>background-attachment:<?=$settings['pgImage']['backgroundAttachment']?>;<?php } ?>
                background-position:top center;
            }
            .head {
                <?php if (!empty($settings['top'])) { ?>height: <?=$settings['top'];?>; /*page.top*/<?php } ?>
            }
            .middle {
                <?php if (!empty($settings['body'])) { ?>height: <?=$settings['body'];?>; /*page.body*/<?php } ?>
            }
            .foot {
                <?php if (!empty($settings['foot'])) { ?>height: <?=$settings['foot'];?>; /*page.foot*/<?php } ?>
            }
            .plate-top {
                <?php if (!empty($settings['width'])) { ?>width: <?=$settings['width'];?>; /*page.width*/<?php } ?>
                <?php if (!empty($settings['pg'])) { ?>background-color: <?=$settings['pg'];?>; /*page.pg*/<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundImage'])) { ?>background-image:<?=stripcslashes($settings['pgImage']['backgroundImage'])?>;<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundSize'])) { ?>background-size:<?=$settings['pgImage']['backgroundSize']?>;<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundRepeat'])) { ?>background-repeat:<?=$settings['pgImage']['backgroundRepeat']?>;<?php } ?>
                <?php if (!empty($settings['pgImage']['backgroundAttachment'])) { ?>background-attachment:<?=$settings['pgImage']['backgroundAttachment']?>;<?php } ?>
                background-position:top center;
                margin:0 auto;
            }
        </style>
        <script>
            //全部变量设置
            var islogin = <?=!empty($user) ? 1 : 0?>;
            var lguser  = <?=!empty($user) ? json_encode($user) : '{}';?>;
            var roominfo = <?=!empty($roominfo) ? json_encode($roominfo):'{}'?>;
            var loginUrl ='<?=geturl('room/design/getajaxhtml')?>';
        </script>
    <?php } ?>
</head>
<body>


    <div id="window-login" style="display:none;">
        <div class="logDialog" >
            <div><input type="hidden" id="plate-login-arg" /></div>
            <div id="msg_log" style="display:none;position:absolute;z-index:12;margin-left:50px;top:24px;color:#c00;width:235px;">
                <div style="background:url(http://static.ebanhui.com/ebh/images/errorLayer_03.gif) no-repeat 0 0;height:2px;overflow:hidden;"></div>
                <div style="padding:10px 8px;background:url(http://static.ebanhui.com/ebh/images/errorLayer_14.gif) repeat;">
                    <div class="msg_close" style="float:left;position:absolute;top:0px;right:10px;cursor:pointer;color:#666;font-family:黑体;font-weight:bold;font-size:16px;">x</div>
                    <div><p id="msg_log_main" style="z-index:14px;background:url(http://static.ebanhui.com/ebh/images/tips_error.gif) no-repeat 0 0px;padding-left:20px;font-size:12px;font-weight:bold;">帐号不能为空</p></div>
                </div>
                <div style="background:url(http://static.ebanhui.com/ebh/images/errorLayer_16.gif) no-repeat;height:7px;"></div>
            </div>

            <form style="padding:0 13px;text-align:left;" id="form2" action="/login&amp;inajax=1" name="form2" method="post">
                <input value="df493206" name="formhash" type="hidden">
                <input value="1" name="loginsubmit" type="hidden">
                <input value="login" name="action" type="hidden">
                <p style="font-size:14px;color:#808080;line-height:40px;height:40px;">帐号：</p>
                <input style="height: 31px; line-height: 31px; border: medium none; font-size: 14px;  padding-left: 8px; padding-right: 20px; width: 223px; background: transparent url(&quot;http://static.ebanhui.com/ebh/images/zhanghtxt0218.jpg&quot;) repeat scroll 0% 0%; color: #000" id="uname" placeholder="请输入账号/手机号/邮箱" title="请输入账号/手机号/邮箱" tabindex="1" name="username" type="text">
                <p style="font-size:14px;color:#808080;line-height:40px;height:40px;">密码：</p>
                <input style="height:31px;line-height:31px;border:none;font-size:14px;color:#000;padding-left:8px;padding-right:20px;width:223px;background:url(http://static.ebanhui.com/ebh/images/passtxt0218.jpg);color:#000;" id="pword" class="txtpass" maxlength="20" value="" tabindex="1" name="password" type="password">
                <div style="margin:8px 0;"><input id="rememberme" style="float:left;height:20px;line-height:20px;margin:15px 2px 15px 20px;" value="checkbox" name="checkbox" type="checkbox"><span style="float:left;color:#888;margin:15px 0 15px 0;"><label for="rememberme">下次自动登录</label></span></div>
                <div style="clear:both"></div><input class="isubmit" style="background:url(http://static.ebanhui.com/ebh/images/logobtn0218.jpg) no-repeat;width:251px;height:32px;border:none;margin-bottom:10px;cursor:pointer;" value="" type="button">
                <?php 
                    //获取网校的配置
                    $systemsetting = Ebh::app()->room->getSystemSetting();
                    $isregister = empty($systemsetting['isregister']) ? 0 : 1;//禁用注册
                ?>
                <?php if ($open_register || !$isregister) { ?><div style="width:215px;margin:8px 0;"><span style="color:#000;">用其他账号登录：</span><a href="<?=getopenloginurl('qq', $varpool['currentdomain'])?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg"></a><a href="<?=getopenloginurl('sina', $varpool['currentdomain'])?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg"></a><a href="<?=getopenloginurl('wx', $varpool['currentdomain'])?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="https://open.weixin.qq.com/zh_CN/htmledition/res/assets/res-design-download/icon16_wx_logo.png"></a></div><?php } ?>
                <div class="fotlogs" style="width:251px;border-top:1px solid #ccc;padding-top:12px;text-align:center;"><?php if($open_register || !$isregister) { ?><a style="margin-left:10px;height:20px;line-height20px;color:#808080; " href="javascript:void(0)" class="reginpage">用户注册</a><?php } ?><a style="margin-left:10px;height:20px;line-height20px;color:#808080; " href="http://www.ebh.net/forget.html">忘记密码？</a></div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate-login-window.js<?=getv()?>"></script>

<div class="baoke" id="free-dialog" style="display:none">
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
        <?php if ($appsetting['szlz'] != $systemsetting['crid']) {?>
        价格：<span class="cshortr">免费</span>
        <?php } ?>
    </div>
</div>
<!--系统更新提示>
<div style="background:#ff8800;font-size:14px;color:#fff;z-index: 10;height:30px;line-height:30px;width:100%;text-align:center;font-family: Microsoft Yahei;"><img style="vertical-align: text-bottom;" src="http://static.ebanhui.com/ebh/tpl/2016/images/zhuyi01.jpg" />亲爱的用户：为了给您提供更优质的服务，系统将于06月28号22点30分进行升级，期间可能会出现服务中断情况，敬请谅解！</div><!-->
<?php if (!empty($head)) { ?><div class="plate-top"><div style="height:<?=$settings['top']?>;position:relative;width:<?=$settings['width']?>;margin:0 auto;"><?=$head?></div><?php } ?>
<div class="wraps group">
    <?php
    $currentdomain = getdomain();
    $room_cache = Ebh::app()->lib('Roomcache');
    if (!empty($top_modules)) {
        foreach($top_modules as $module) {
            $view_name = sprintf('shop/plate/portfolio-%s', $module['code']);
            if (!empty($module['cache'])) {
                $htmlfragment = $room_cache->getCache($roomdetail['crid'], $module['code'], 'view');
                if (!empty($htmlfragment)) {
                    echo $htmlfragment;
                    continue;
                }
                $htmlfragment = $this->partial($view_name, false, $module);
                $expire = !empty($module['expire']) ? intval($module['expire']) : 0;
                $room_cache->setCache($roomdetail['crid'], $module['code'], 'view', $htmlfragment, $expire, true);
                echo $htmlfragment;
                continue;
            }
            if ($module['mid'] == 2) {
                $module['allways_show_course_menus'] = !empty($allways_show_course_menus);
            }
            $this->partial($view_name, true, $module);
        }
    }
    ?>

    <div class="clear"></div>
    <div style="position:relative;background-color:#fff;width:1200px;margin:-10px auto 0 ;">
        <?php $this->partial($inner_view, true, $inner_data); ?>
    </div>

    <script type="text/javascript">
        (function($) {
            //$.surveyNext();
        })(jQuery);
    </script>
</div>
<?php if (!empty($foot)) { ?><div style="height:<?=$settings['foot']?>;position:relative;width:<?=$settings['width']?>;margin:0 auto;"><?=$foot?></div></div>
    <script type="text/javascript" src="http://static.ebanhui.com/design/js/main.js?v=<?=getv()?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/design/js/home.js?v=<?=getv()?>"></script>
	<?php
$room = Ebh::app()->room->getcurroom();
$icp = '浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-'.date('Y').' ebh.net All Rights Reserved';
if(!empty($room) && !empty($room['icp']))
	$icp = $room['icp'];
?>
<div style="clear:both;"></div>
<div class="fldty">
<div style="text-align:center">
  <span style="color:#666"><?= $icp ?></span>&nbsp;&nbsp;    <br>
    <br>
</div>
</div>
<!-- 统计代码开始 --
8185(黄福生（主管）) 15:55:00
>
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>
<!-- 统计代码结束 -->
<?php } else { ?>
    <!--底部-->
    <?php
    $room = Ebh::app()->room->getcurroom();
    $icp = sprintf('浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-%d ebh.net All Rights Reserved', date('Y'));
    if(!empty($room) && !empty($room['icp'])) {
        $icp = $room['icp'];
    }
    if (empty($global_qcode) && !empty($roomdetail)) {
        $global_qcode = $roomdetail['wechatimg'];
    }

    if(empty($room['cremail'])){
        $prename = '主页';
        $pre = '';
        $room['cremail'] = !empty($room['fulldomain']) ? $room['fulldomain'] : $room['domain'].'.ebh.net';
        if (strpos($room['cremail'], 'http://') !== 0) {
            $room['cremail'] = 'http://'.$room['cremail'];
        }
    } else {
        if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
            $prename = "邮箱";
            $pre = 'mailto:';
        } else{
            $prename = '主页';
            $pre = '';
            if (strpos($room['cremail'], 'http://') !== 0) {
                $room['cremail'] = 'http://'.$room['cremail'];
            }
        }
    }

    ?>
    <div class="wrap_footer">
        <div class="wrap_footerson">
            <div class="footersonleft">
                <div class="leftimages"><img width="120" height="120" src="<?=!empty($global_qcode) ? $global_qcode : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/weixin.jpg'?>"/></div>
                <p class="p2s">微信学习</p>
            </div>
            <div class="footersonright">
                <div class="address">联系地址：<?=!empty($roomdetail['craddress']) ? $roomdetail['craddress']:'暂无'?></div>
                <div class="address hotline">电话：<?=!empty($roomdetail['crphone']) ? $roomdetail['crphone']:'暂无'?></div>
                <div class="address home"><?=$prename?>：<?=$room['cremail']?></div>
            </div>
        </div>
        <div class="clear"></div>
        <p class="p1s"><?=$icp?></p>
    </div>
<?php debug_info();?>
    <!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
    echo $systemsetting['analytics'];
} else {
    EBH::app()->lib('Analytics')->get('baidu');
}
?>
    <!-- 统计代码结束 -->

    <!--增加客服系统sta-->
    <div class="kfxt">
        <?php $this->display('shop/plate/kf')?>
    </div>
    <!--增加客服系统end-->
<?php } ?>
</body>
</html>