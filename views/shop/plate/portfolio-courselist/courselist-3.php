<?php
/**
 * 课程列表模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:06
 */
if (!empty($setting)) { ?>
    <div class="courselistdoule">
        <div id="course-content">
            <?php if (!empty($varpool['data'])) { if (!empty($varpool['data']['packages'])) { ?>
                <div class="courselisttitle group">
                    <ul class="fl allson">
                        <li><a href="javascript:;" class="courseall<?php if (0 == $varpool['data']['pid']) { echo ' onhover';} ?>">全部</a></li>
                        <?php if (!empty($varpool['data']['packages'])) {
                            foreach ($varpool['data']['packages'] as $index => $package) {
                                ?>
                                <li><a href="javascript:;" class="courseall<?php if ($index == $varpool['data']['pid']) { echo ' onhover';} ?>"><?=htmlspecialchars($package['pname'], ENT_NOQUOTES)?></a></li>
                                <?php
                            }
                        } ?>
                    </ul>
                    <?php if (!empty($varpool['data']['sorts'])) { ?>
                        <ul class="fl allsondouble">
                            <?php $c = count($varpool['data']['sorts']); if ($c > 1) { ?>
                                <li><a href="javascript:;" class="courseall onhover">全部</a></li>
                            <?php } ?>
                            <?php foreach ($varpool['data']['sorts'] as $sid => $sort) { ?>
                                <li><a href="javascript:;" class="courseall<?php if($c == 1){ echo ' onhover'; } ?>"><?= htmlspecialchars($sort['sname'], ENT_NOQUOTES) ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            <?php } ?>
                <div class="courselistdouleson group">
                    <?php if (!empty($varpool['data']['group_by_package'])) {
                        if (!empty($varpool['data']['packages'])) {
                            foreach ($varpool['data']['packages'] as $package) {
                                if (!empty($package['items'])) { ?>
                                    <div class="coursetitlenew"><?=htmlspecialchars($package['pname'], ENT_NOQUOTES)?></div>
                                    <ul class="group">
                                        <?php foreach ($package['items'] as $item) {
                                            $cannotpay = !empty($item['cannotpay']);
                                            $free = $item['iprice'] == 0 || !empty($varpool['data']['isalumni']) && $item['isschoolfree'] == 1;
                                            if ($free) {
                                                $item['iprice'] = 0;
                                            }
                                            $url = $this->format_pay_item_url($item, $varpool['data']['userpermisions']);
                                            if (empty($item['showbysort']) || !empty($item['allow']) || !empty($item['cannotpay'])) {
                                                $detail_url = "/courseinfo/{$item['itemid']}.html";
                                                $deal_by_js = false;
                                            } else {
                                                $detail_url = $url;
                                                $deal_by_js = empty($url);
                                            }
                                            if (empty($item['longblockimg']) || empty($item['showaslongblock'])) {
                                                $showimg = $item['img'];
                                            } else {
                                                $showimg = $item['longblockimg'];
                                            }
                                            if (empty($showimg)) {
                                                $showimg = $this->course_viewholder;
                                            }
                                            $detail_url = 'javascript:;';
                                            $deal_by_js = true;
                                            $img = show_plate_course_cover($showimg);
                                            $img = show_thumb($img);?>
                                            <li itemid="<?=$item['itemid']?>">
                                                <div class="courseimg">
                                                    <a href="<?=htmlspecialchars($detail_url, ENT_COMPAT) ?>"><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($img, ENT_COMPAT)?>" /></a>
                                                    <div class="introduction" style="display:none;"><a href="<?=htmlspecialchars($detail_url, ENT_COMPAT) ?>"><?=shortstr(strip_tags($item['summary']), 200, '')?></a></div>
                                                </div>
                                                <div class="registernow<?php if (!empty($item['allow'])) { ?> registered<?php } elseif(!empty($cannotpay)) { echo ' disabled'; } elseif($free) {

                                                    $systemsetting = Ebh::app()->room->getSystemSetting();
                                                    $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                                    $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                                    if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';}

                                                } ?>"><a href="<?=!empty($url) ? htmlspecialchars($url, ENT_COMPAT) : 'javascript:;'?>" class="sign<?=$this->sign_status($url)?>" itemid="<?=$item['itemid']?>"></a></div>
                                                <div class="coursetitle" style="overflow:hidden;height:32px;"><a href="<?=htmlspecialchars($detail_url, ENT_COMPAT) ?>" target="_blank" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 30, ''), ENT_NOQUOTES)?></a></div>
                                                <div class="popularity"><?php
                                                    if (!empty($item['speaker'])) {
                                                        $speakers = explode(',', $item['speaker']);
                                                        //$speakers = array_unique($speakers);
                                                        $item['speaker'] = $speakers[0];
                                                    }
                                                    ?>
                                                    <span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : '' ?></span>
                                                    <?php if (!empty($item['viewnum'])) { ?><span class="popule"><?=big_number($item['viewnum'])?></span><?php } ?>
                                                    <?php if (!empty($item['coursewarenum'])) { ?><span class="number"><?=big_number($item['coursewarenum'])?></span><?php } ?>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php }
                            }
                        }
                    } else {
                        if (!empty($varpool['data']['group'])) {
                            foreach ($varpool['data']['group'] as $group) {
                                if ($group['view_mode'] == 2) { ?>
                                    <ul class="ul1 group" id="group-1">
                                        <?php foreach ($group['data'] as $item) {
                                            if (empty($item['longblockimg']) || empty($item['showaslongblock'])) {
                                                $showimg = $item['img'];
                                            } else {
                                                $showimg = $item['longblockimg'];
                                            }
                                            if (empty($showimg)) {
                                                $showimg = $this->course_viewholder;
                                            }
                                            $img = show_plate_course_cover($showimg);
                                            $img = show_thumb($img); ?>
                                            <li>
                                                <div class="courseimg fl"><a href="javascript:;"><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($img, ENT_COMPAT)?>" /></a></div>
                                                <div class="coursemain fl">
                                                    <div class="coursetitle" style="overflow:hidden;height:32px;"><a href="javascript:;" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 68, ''), ENT_NOQUOTES)?></a></div>
                                                    <div class="courseware"><?=shortstr(strip_tags($item['summary']), 300, '')?></div>
                                                    <div class="popularity ">
                                                        <span>课时：<?=big_number($item['coursewarenum'])?></span>
                                                        <span>人气：<?=big_number($item['viewnum'])?></span>
                                                        <a href="javascript:;" class="sign">点击报名</a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <?php continue;
                                }
                                if ($group['view_mode'] == 0) { ?>
                                    <ul id="group-2" class="group">
                                        <?php foreach ($group['data'] as $item) {
                                            if (empty($item['longblockimg']) || empty($item['showaslongblock'])) {
                                                $showimg = $item['img'];
                                            } else {
                                                $showimg = $item['longblockimg'];
                                            }
                                            if (empty($showimg)) {
                                                $showimg = $this->course_viewholder;
                                            }
                                            $img = show_plate_course_cover($showimg);
                                            $img = show_thumb($img); ?>
                                            <li>
                                                <div class="courseimg">
                                                    <a href="javascript:;"><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($img, ENT_COMPAT)?>" /></a>
                                                    <div class="introduction" style="display:none;"><a href="javascript:;"><?=shortstr(strip_tags($item['summary']), 200, '')?></a></div>
                                                </div>
                                                <div class="registernow"><a href="javascript:;" class="sign"></a></div>
                                                <div class="coursetitle" style="overflow:hidden;height:32px;"><a href="javascript:;" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 30, ''), ENT_NOQUOTES)?></a></div>
                                                <div class="popularity"><?php
                                                    if (!empty($item['speaker'])) {
                                                        $speakers = explode(',', $item['speaker']);
                                                        //$speakers = array_unique($speakers);
                                                        $item['speaker'] = $speakers[0];
                                                    }
                                                    ?>
                                                    <span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : '' ?></span>
                                                    <span class="popule"><?=big_number($item['viewnum'])?></span>
                                                    <span class="number"><?=big_number($item['coursewarenum'])?></span>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <?php continue;
                                }
                                if ($group['view_mode'] == 1) { ?>
                                    <ul class="ul1 ul2 group" id="group-3">
                                        <?php foreach ($group['data'] as $item) {
                                            if (empty($item['longblockimg']) || empty($item['showaslongblock'])) {
                                                $showimg = $item['img'];
                                            } else {
                                                $showimg = $item['longblockimg'];
                                            }
                                            if (empty($showimg)) {
                                                $showimg = $this->course_viewholder;
                                            }
                                            $img = show_plate_course_cover($showimg);
                                            $img = show_thumb($img); ?>
                                            <li>
                                                <div class="coursetitle" style="height:32px;overflow:hidden;"><a href="javascript:;" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 48, ''), ENT_NOQUOTES)?></a></div>
                                                <div class="courseimg fl"><a href="javascript:;"><img class="plate-cover" width="200" height="120" src="<?=htmlspecialchars($img, ENT_COMPAT)?>" /></a></div>
                                                <div class="coursemain fl">
                                                    <div class="courseware"><?=shortstr(strip_tags($item['summary']), 94, '')?></div>
                                                    <div class="popularity">
                                                        <div class="fl">
                                                            <span>课时：<?=big_number($item['coursewarenum'])?></span>
                                                            <br/><span>人气：11111111111<?=big_number($item['viewnum'])?></span>
                                                        </div>
                                                        <a href="javascript:;" class="sign" itemid="<?=$item['itemid']?>">报名</a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <?php continue;
                                }
                            }
                        }
                    } ?>
                    <?php if (!empty($varpool['data']['more'])) { ?><div class="courselist-more"><a href="javascript:;">更多</a></div><?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php return;
}
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/plate.css" />
<div class="plate-module-v courselist <?=$varpool['columns'] == 3 ? 'triple' : 'full'?>" style="<?php if (empty($varpool['ajax'])) { ?><?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?><?php } ?>width:<?=($varpool['width'] - 20)?>px;<?php } ?>position:inherit;">
    <?php if (!empty($varpool['data']['packages'])) { ?><div class="plate-nav">
        <?php if (count($varpool['data']['packages']) > 1) { ?><a href="/platform.html"<?php if (empty($varpool['data']['pid'])) { ?> class="cur"<?php } ?>>全部</a><?php } ?>
        <?php foreach ($varpool['data']['packages'] as $package) { ?>
            <a href="/platform.html?pid=<?=$package['pid']?>"<?php if (!empty($package['cur'])) { ?> class="cur"<?php } ?>><?=$package['pname']?></a>
        <?php } ?></div>
    <?php }
     if (!empty($varpool['data']['pid']) && !empty($varpool['data']['sorts'])) { ?><div class="plate-nav sub">
         <?php if (count($varpool['data']['sorts']) > 1) { ?><a href="/platform.html" class="cur">全部</a><?php } ?>
        <?php foreach ($varpool['data']['sorts'] as $sort) { ?>
            <a href="/platform.html?pid=<?=$sort['pid']?>&sid=<?=$sort['sid']?>"<?php if (!empty($sort['cur'])) { ?> class="cur"<?php } ?>><?=$sort['sname']?></a>
        <?php } ?></div>
    <?php }
    if (!empty($varpool['data']['items'])) {
        $groupCsses = array('plate-course-item', 'plate-course-list', 'plate-course-detail');
        foreach ($varpool['data']['items'] as $group) {
            $viewMode = isset($group['view_mode']) ? $group['view_mode'] : 0;
            if (!empty($group['pname'])) { ?>
                <div class="group-name"><?=$group['pname']?></div>
            <?php } ?><ul class="course-service <?=$groupCsses[$viewMode]?> group">
            <?php foreach ($group['services'] as $item) {
                $item['szlz'] = $varpool['data']['szlz'];
                $this->partial2('shop/plate/pay_item', $item);
            } ?></ul>
        <?php }
    } ?>
</div>
<script type="text/javascript">
    (function($) {
        $.surveyId = <?=!empty($surveyid) ? $surveyid : '0'?>;
        $(".course-service").bind('click', function(e) {
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