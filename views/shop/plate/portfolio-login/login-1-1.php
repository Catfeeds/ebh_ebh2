<?php
/**
 * 用户登录模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/11
 * Time: 17:31
 */

//获取网校的配置
$systemsetting = Ebh::app()->room->getSystemSetting();
$isbanregister = empty($systemsetting['isbanregister']) ? 0 : 1;//禁用注册
$isbanthirdlogin = empty($systemsetting['isbanthirdlogin']) ? 0 : 1;//禁用第三方登入
if (!empty($setting)) { ?>
    <div class="denser">
        <input type="hidden" name="loginsubmit" value="1" />
        <div class="chorejrxtxtarea"><input name="username" id="username" class="txtarea" placeholder="请输入用户名" maxlength="20"></div>
        <div class="chorejrxtxtpass"><input name="password" id="password" type="password" maxlength="20" class="txtpass" placeholder="请输入密码"></div>
        <div class="dhsure">
            <input style="vertical-align: sub;" type="checkbox" name="cookietime" id="cookietime" /><label class="rybtnat" for="cookietime">下次自动登录</label>
            <div class="derase">
                <?php if (!$isbanregister) { ?><a href="javascript:;" class="reginpage">用户注册</a> | 
                  <?php }?>  
                <a href="javascript:;">忘记密码</a>
            </div>
        </div>
        <input class="signbtn" value="立即登录" name="Submit" type="button">
        <div class="aerire">
            <span class="fl">用其他账号登录：</span>
            <a class="md-qq" href="javascript:;"></a>
            <a class="md-sina" href="javascript:;"></a>
            <a class="md-weixin" href="javascript:;"></a>
        </div>
    </div>

    <?php
    return;
}
?>

<div class="md-sign plate-module" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <h2 class="titsign"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></h2>
    <?php if (empty($varpool['data']) || !in_array($varpool['data']['groupid'], array(5, 6))) {
        $othersetting = Ebh::app()->getConfig()->load('othersetting');
        //是否禁用用户注册功能
        $open_register = true;
        $roomdetail = Ebh::app()->room->getcurroom();
        if (isset($othersetting['dis_registerable']) && is_array($othersetting['dis_registerable']) && in_array($roomdetail['crid'], $othersetting['dis_registerable'])) {
            $open_register = false;
        }?>
    <form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
        <div class="denser">
            <input type="hidden" name="loginsubmit" value="1" />
            <div class="chorejrxtxtarea"><span class="chorejrx"></span><input name="username" id="username" class="txtarea" placeholder="请输入用户名/手机号/邮箱"></div>
            <div class="chorejrxtxtpass"><input name="password" id="password" type="password" maxlength="20" class="txtpass" placeholder="请输入密码"></div>
            <div class="dhsure">
                <input style="vertical-align: middle;" type="checkbox" name="cookietime" id="cookietime" /><label class="rybtnat" for="cookietime">下次自动登录</label>
                <div class="derase">
                    <?php if (($open_register && !$isbanregister) || !$isbanregister) { ?><a href="javascript:;" class="reginpage">用户注册</a> | <?php } ?><a href="/forget.html">忘记密码</a>
                </div>
            </div>
            <input class="signbtn" value="立即登录" name="Submit" type="submit">
            <?php if (($open_register && !$isbanthirdlogin) || !$isbanthirdlogin) { ?><div class="aerire">
                <span class="fl">用其他账号登录：</span>
                <a class="md-qq" href="<?=getopenloginurl('qq', $varpool['currentdomain'])?>"></a>
                <a class="md-sina" href="<?=getopenloginurl('sina', $varpool['currentdomain'])?>"></a>
                <a class="md-weixin" href="<?=getopenloginurl('wx', $varpool['currentdomain'])?>"></a>
            </div><?php } ?>
        </div>
        </form>
        <script type="text/javascript">
            (function($) {
                $("#form1").placeholder();
            })(jQuery);
        </script>
    <?php } else {
        $troomurl = gettroomurl($varpool['room']['crid']);
        //$troomurl = geturl('aroomv3');
        $url = $varpool['data']['groupid'] == 6 ? geturl('myroom') : $troomurl; 
    ?>
        <div class="denser">
            <div class="risfgr">
                <img width="100" height="100" src="<?=getavater($varpool['data'],'120_120')?>" style="border-radius:50px;" />
            </div>
            <div class="erseasd">
                <h2 class="waisrd"><?=htmlspecialchars(!empty($varpool['data']['realname']) ? shortstr($varpool['data']['realname'],8) : shortstr($varpool['data']['username'], 10), ENT_NOQUOTES)?></h2>
                <p class="mdistr">上次登录时间：</p>
                <p class="mdistr"><?=$varpool['data']['lastlogintime']?></p>
            </div>
            <input class="signbtn" value="马上进入" name="Submit" type="submit" id="enter">
            <div class="flosret"><a href="/logout.html">退出</a></div>
        </div>
        <script type="text/javascript">
            (function($) {
                $("#enter").bind('click', function() {
                   window.location.href = '<?=$url?>';
                });
            })(jQuery);
        </script>
    <?php } ?>
</div>