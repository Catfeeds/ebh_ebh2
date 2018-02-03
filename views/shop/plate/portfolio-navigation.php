<?php
/**
 * 导航模块(选项卡)
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/11
 * Time: 15:54
 */
$systemsetting = Ebh::app()->room->getSystemSetting();
$isbanregister = empty($systemsetting['isbanregister']) ? 0 : 1;//禁用注册
$allways_show_child = !empty($varpool['allways_show_course_menus']);
$is_platform = $this->uri->uri_control() == 'platform' || $this->uri->uri_control() == 'courseinfo';
$is_fineware = $this->uri->uri_control() == 'fineware';
$is_news = $this->uri->uri_control() == 'dyinformation' && !empty($varpool['navcode']) && $varpool['navcode'] == 'news';
$request_uri = explode('?', $_SERVER['REQUEST_URI']);
$here = $request_uri[0];//print_r($varpool['menu']);exit;
if (!empty($setting)) { ?>
    <div class="wrap_navlist" style="height:50px !important;">
        <div class="w1200">
            <div id="top-menu" class="navleft" style="height:50px;line-height:50px;">
                <?php if (!empty($varpool['menu'])) {
                    foreach ($varpool['menu'] as $index => $item) { ?>
                        <a href="javascript:;" class="navlista<?php if ($index == 0) { echo ' cur'; } ?>"><?=htmlspecialchars($item['nickname'] == '精品课件' ? '单课列表' : $item['nickname'], ENT_NOQUOTES)?></a>
                    <?php }} ?>
                <a id="more-top-menu" href="javascript:;" class="navsMemu" style="visibility: hidden">
                    <div class="navmore" style="display:none;">
                        <div class="navmoretop"></div>
                        <div class="navmorelist">
                        </div>
                        <div class="navmorebo"></div>
                    </div>
                </a>
            </div>

            <div class="wrap_login">
               <?php if (!$isbanregister) { ?> <a href="javascript:;">注册</a><?php }?>
                <a href="javascript:;">登录</a>
                <a href="javascript:;" style=" display:none;">退出</a>
            </div>
            <div class="diles-search"><form method="get">
                    <input name="txtname" class="plate-newsou" id="search" placeholder="搜索关键字" type="text">
                    <input class="plate-soulico" value="" type="button"></form>
            </div>
        </div>
	</div>
    <?php return;
} ?>

<!--导航-->
<div class="wrap_nav">
    <div class="wrap_navlist">
		<div class="w1200">
			<div id="top-menu" class="navleft" style="height:50px;">
                <?php if (!empty($varpool['arg_sign'])) { $this->display('shop/plate/portfolio-courses-menu'); } ?>
				<?php if (!empty($varpool['menu'])) {
					foreach ($varpool['menu'] as $item) { ?>
						<a<?php if(!empty($item['target']) && $item['target']== '_blank') { echo ' target="_blank"'; } ?>  href="<?=htmlspecialchars($item['url'], ENT_COMPAT)?>" class="navlista<?php if ($here == $item['url'] || $item['code'] == 'platform' && $is_platform || !empty($varpool['navcode']) && $item['code'] == $varpool['navcode'] || $is_news && $item['code'] == 'news' || $is_fineware && $item['code'] == 'fineware'){ echo ' cur'; }?>"><?=htmlspecialchars($item['nickname'] == '精品课件' ? '单课列表' : $item['nickname'], ENT_NOQUOTES)?></a>
					<?php }} ?>
                <a id="more-top-menu" href="javascript:;" class="navsMemu" style="visibility: hidden">
                    <div class="navmore" style="display:none;">
                        <div class="navmoretop"></div>
                        <div class="navmorelist">
                        </div>
                        <div class="navmorebo"></div>
                    </div>
                </a>
			</div>
			<div class="wrap_login">
				<?php if (empty($varpool['logined']) || !in_array($varpool['user']['groupid'], array(5, 6))) {
                    $othersetting = Ebh::app()->getConfig()->load('othersetting');
                    //是否禁用用户注册功能
                    $open_register = true;
                    $roomdetail = Ebh::app()->room->getcurroom();
                    if (isset($othersetting['dis_registerable']) && is_array($othersetting['dis_registerable']) && in_array($roomdetail['crid'], $othersetting['dis_registerable'])) {
                        $open_register = false;
                    }?>
					 <?php if (($open_register && !$isbanregister) || !$isbanregister) { ?><a href="javascript:;" class="reginpage">注册</a><?php } ?>
					<a id="nav-login" href="javascript:;">登录</a>
				<?php } else { if (!empty($varpool['is_admin'])) { ?>
					<a href="/room/portfolio/custportal.html">首页装扮</a>
				<?php } else {
				    $user_center_url = $varpool['user']['groupid'] == 6 ? '/myroom.html': '/troomv2.html'; ?>
                    <a style="margin-right:0;" href="<?=$user_center_url?>"><?=!empty($varpool['user']['realname']) ? shortstr($varpool['user']['realname'], 8, '') : shortstr($varpool['user']['username'], 8, '')?></a>
				<?php } ?>
                    <a href="/logout.html" style="">退出</a>
				<?php }?>
			</div>
            <div class="diles-search"><form method="get" action="/platform.html" id="search-course">
                    <input name="q" class="plate-newsou" id="search-keyword" placeholder="搜索关键字" type="text" autocomplete="off" value="<?=!empty($varpool['q']) ? $varpool['q'] : ''?>">
                    <input class="plate-soulico" value="" type="submit"></form>
            </div>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    (function($) {
        var showChild = <?=!empty($varpool['arg_sign']) ? 'true' : 'false' ?>;
        var allwaysShowChild = <?=$allways_show_child ? 'true' : 'false'?>;
        $("#search-course").placeholder();
        $("#search-course").bind('submit', function() {
            if ($("#search-keyword").val()=='') {
                $("#search-keyword").focus();
                return false;
            }
        });
        function setMenu() {
            var baseLine = $("#top-menu").position().top;
            var hiddenIndexArr = [];
            var hiddenMenuHtml = [];
            var menu = $("#top-menu > a.navlista");
            var delStartIndex = -1;
            menu.each(function(index) {
                var that = $(this);
                if (that.position().top > baseLine) {
                    hiddenIndexArr.push(index);
                    if (that.attr('target') == '_blank') {
                        hiddenMenuHtml.push('<span class="navlista"><a target="'+that.attr('target')+'" href="'+that.attr('href')+'">' + that.html() + '</a></span>')
                    } else {
                        hiddenMenuHtml.push('<span class="navlista"><a href="'+that.attr('href')+'">' + that.html() + '</a></span>')
                    }
                }
            });
            var hl = hiddenIndexArr.length;
            if (hl > 0) {
                var moreMenu = $("#more-top-menu");
                var moreMenuBox = moreMenu.find("div.navmorelist");
                moreMenu.css('visibility', 'visible');
                hl--;
                var delStartIndex = -1;
                for (var i = hl; i >= 0; i--) {
                    $(menu.get(hiddenIndexArr[i])).remove();
                    delStartIndex = hiddenIndexArr[i];
                }
                if (moreMenu.position().top > baseLine) {
                    delStartIndex--;
                    var that = $(menu.get(delStartIndex));
                    if (that.attr('target') == '_blank') {
                        hiddenMenuHtml.unshift('<span class="navlista"><a target="'+that.attr('target')+'" href="' + that.attr('href') + '">' + that.html() + '</a></span>');
                    } else {
                        hiddenMenuHtml.unshift('<span class="navlista"><a href="' + that.attr('href') + '">' + that.html() + '</a></span>');
                    }

                    that.remove();
                }
                moreMenuBox.html(hiddenMenuHtml.join(''));
                moreMenu = null;
                moreMenuBox = null;
            }
        }

        setMenu();

        $(".navsMemu").mouseenter(function(){
            $(".navmore").css("display","block");
        });
        $(".navsMemu").mouseleave(function(){
            $(".navmore").css("display","none");
        });

        if (showChild && !allwaysShowChild) {
            $("#nav").bind('mouseenter', function() {
                $("#second_mune_ul").show();
            }).bind('mouseleave', function() {
               $("#second_mune_ul").hide();
            });
        }
        //立即登录
        $("#nav-login").bind('click', function() {
            $.loginDialogSmall();
        });
		$.loginDialogSmall = function(){
			var loginWindow = new dialog({
                id:'login-small-window',
                title:'用户登录',
                fixed:true,
                content:$("#window-login")
            });
            loginWindow.showModal();
		}
    })(jQuery);
</script>
