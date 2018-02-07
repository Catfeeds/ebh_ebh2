<div id="window-login">
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
                $isbanregister = empty($systemsetting['isbanregister']) ? 0 : 1;//禁用注册
                $isbanthirdlogin = empty($systemsetting['isbanthirdlogin']) ? 0 : 1;//禁用第三方登入
            ?>
            <?php if (($open_register && !$isbanthirdlogin) || !$isbanthirdlogin) { ?><div style="width:215px;margin:8px 0;"><span style="color:#000;">用其他账号登录：</span><a href="<?=getopenloginurl('qq', $varpool['currentdomain'])?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg"></a><a href="<?=getopenloginurl('sina', $varpool['currentdomain'])?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg"></a><a href="<?=getopenloginurl('wx', $varpool['currentdomain'])?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="https://open.weixin.qq.com/zh_CN/htmledition/res/assets/res-design-download/icon16_wx_logo.png"></a></div><?php } ?>
            <div class="fotlogs" style="width:251px;border-top:1px solid #ccc;padding-top:12px;text-align:center;"><?php if(($open_register && !$isbanregister) || !$isbanregister) { ?><a style="margin-left:10px;height:20px;line-height20px;color:#808080; " href="javascript:void(0)" class="reginpage">用户注册</a><?php } ?><a style="margin-left:10px;height:20px;line-height20px;color:#808080; " href="http://www.ebh.net/forget.html">忘记密码？</a></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate-login-window.js<?=getv()?>"></script>
