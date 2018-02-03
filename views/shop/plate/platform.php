<?php
/**
 * 选课中心
 * Created by PhpStorm.
 * User: app
 * Date: 2016/11/4
 * Time: 15:43
 */
extract($varpool);
unset($varpool);
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/plate.css" />
<style type="text/css">
    .kjutes{margin-left:10px;margin-bottom:15px;}
    #price:hover ul.order-by-price{display:block;}
    .plate-content{margin-top:10px;}
    .plate-content .plate-nav{background-color:#fff;margin-bottom:0;margin-top:0;}
    .nodata{margin-top:20px;}
</style>
<div class="plate-content full">
        <?php if (!empty($packages)) { ?><div class="plate-nav">
            <?php if (count($packages) > 1) { ?><a href="/platform.html"<?php if (empty($pid)) { ?> class="cur"<?php } ?>>全部</a><?php } ?>
            <?php foreach ($packages as $package) { ?>
                <a<?php if(!empty($package['cur'])) { ?> class="cur"<?php } ?> href="/platform.html<?php if (!empty($package['pid'])) { echo '?pid='.$package['pid']; } ?>"><?=htmlspecialchars($package['pname'], ENT_NOQUOTES)?></a>
            <?php } ?></div>
        <?php }?>
        <?php if (!empty($pid) && !empty($sorts)) { ?><div class="plate-nav">
            <?php if (count($sorts) > 1) { ?><a href="/platform.html?pid=<?=$pid?>"<?php if (!isset($sid)) { ?> class="cur"<?php } ?>>全部</a><?php } ?>
            <?php foreach ($sorts as $sort) { ?>
                <a<?php if(!empty($sort['cur'])) { ?> class="cur"<?php } ?> href="/platform.html?pid=<?=$sort['pid']?><?php if (isset($sort['sid'])) { echo '&sid='.$sort['sid']; } ?>"><?=htmlspecialchars($sort['sname'], ENT_NOQUOTES)?></a>
            <?php } ?></div>
        <?php }?>
        <div class="kjutes">
            <a class="<?=$ordertype == 0 ? 'lisrhe' : 'luiets'?>" href="/platform-<?=$page?>-0-<?=$isfree?>.html<?=$query?>">最新</a>
            <a class="<?=$ordertype == 1 ? 'lisrhe' : 'luiets'?>" href="/platform-<?=$page?>-1-<?=$isfree?>.html<?=$query?>">最热</a>
            <a class="<?=$ordertype > 1 ? 'lisrhe' : 'luiets'?>" id="price" href="javascript:;">价格 <img src="http://static.ebanhui.com/ebh/tpl/courses/images/lisrne.png"><ul id="order-by-price" class="order-by-price">
                    <li d="/platform-<?=$page?>-2-<?=$isfree?>.html<?=$query?>">从高到低</li>
                    <li d="/platform-<?=$page?>-3-<?=$isfree?>.html<?=$query?>">从低到高</li>
                </ul>
            </a>
            <span><label><input class="kuiets" name="free" value="1" id="filter-free" type="checkbox"<?php if (!empty($isfree)) { ?> checked="checked"<?php } ?>>只看免费课</label></span>
        </div>
        <?php if (empty($items)) { ?><div class="nodata"></div><?php } else { ?>
            <ul class="plate-course-item group"><?php foreach ($items as $course) { $this->partial2('shop/plate/pay_item', $course); } ?></ul>
            <div class="group"><?=$pagestr?></div>
        <?php } ?></div>
<script type="text/javascript">
    (function($) {
        var page = <?=$page?>;
        var otype = <?=$ordertype?>;
        var query = '<?=$query?>';
        $.surveyId = <?=!empty($surveyid) ? $surveyid : '0'?>;
        $("#price").bind('click', function(e) {
            if (e.target.nodeName.toLowerCase() != 'li') {
                return false;
            }
            var li = $(e.target);
            location.href = li.attr('d');
        });
        $("#filter-free").bind('change', function() {
            var checked = $(this).prop('checked') ? 1 : 0;
            var url = '/platform-' + page + '-' + otype + '-' + checked + '.html' + query;
            location.href = url
        });
        $(".plate-course-item").bind('click', function(e) {
            var t = $(e.target);
            if (t.hasClass('course-oper')) {
                if (t.hasClass('plate-allow')) {
                    //已购买，直接进入学习页
                    t.attr('target', '_blank');
                    return true;
                }
                if (t.hasClass('plate-sign-disabled')) {
                    //禁止报名
                    return false;
                }
                if (t.hasClass('plate-sign-unallow')) {
                    //教师不允许报名
                    $.note('教师账号，不允许进行此操作。');
                    return false;
                }
                if (t.hasClass('szlz')) {
                    $.titleType = 1;
                }

                if (t.hasClass('plate-sign-unlogin')) {
                    //未登录
                    if (t.hasClass('survey')) {
                        $.loginByWindow(t.attr('id'), t.attr('t'), 'survey');
                        return false;
                    }
                    $.loginByWindow(t.attr('id'), t.attr('t'), null);
                    return false;
                }
                if (t.hasClass('survey')) {
                    //报名前需要填写问卷调查
                    $.logArg = t.attr('id');
                    $.argType = t.attr('t');
                    $.checkSurveyed();
                    return false;
                }
                if (t.hasClass('plate-sign-free')) {
                    //免费课程
                    if (t.attr('t') == '2') {
                        //课程包处理
                        $.getBundle(t.attr('id'), function(bundle) {
                            $.buyFreeBundle(bundle);
                        });
                        return true;
                    }
                    if (t.attr('t') == '1') {
                        //打包课程
                        $.getSort(t.attr('id'), function(sort) {
                            $.buyFreeSort(sort);
                        });
                        return false;
                    }
                    //免费课程处理
                    $.getSingleItem(t.attr('id'), function(item) {
                        $.buyFreeItem(item);
                    });
                    return false;
                }
                t.attr('target', '_blank');
                return true;
            }
        });
        $.surveyNext();
    })(jQuery);
</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>