<?php
/**
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/7
 * Time: 17:59
 */
$user = Ebh::app()->user->getloginuser();
$url = false;
if (!empty($user)) {
    if ($user['groupid'] == 5) {
        //教师用户不允许开通
        $url = '';
    } else if (!empty($varpool['bundle']['hasPower'])) {
        //包中的课程都已开通
        $url = $varpool['bundle']['url'];
    } else if($varpool['bundle']['url'] === NULL){
		$url = NULL;
	} else if ($varpool['bundle']['bprice'] == 0) {
        $url = 0;
    } else {
        $url = '/ibuy.html?bid='.$varpool['bundle']['bid'];
    }
}
$systemsetting = Ebh::app()->room->getSystemSetting();
$appsetting = Ebh::app()->getConfig()->load('othersetting');
$appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
$szlz = $appsetting['szlz'] == $systemsetting['crid'];
if (!empty($varpool['bundle']['hasPower']) && $user['groupid'] == 6) {
    $label = $szlz ? '立即观看' : '进入学习';
} else if ($varpool['bundle']['bprice'] == 0) {
    $label = $szlz ? '点击观看' : '免费开通';
} else {
    $label = '点击报名';
}
?>
<?php if (!empty($varpool['design'])) { ?>
    <style type="text/css">
        .denser{margin:0 !important;}
    </style>
<?php } ?>
<style type="text/css">
    .kehtfs.plate-sign-disabled {
        background-color: #e7e7e7;
        color: #999;
    }
</style>
<div class="coursecenter group">
    <div class="coursedetailson group">
        <div class="ter_tits"><a href="/">首页</a>&nbsp;&gt;&nbsp;<a href="/platform-1-0-0.html?pid=<?=$varpool['bundle']['pid']?>&sid=<?=$varpool['bundle']['sid']?>"><?=htmlspecialchars($varpool['bundle']['pname'], ENT_NOQUOTES)?></a></div>
        <div class="coursedetailson-1">
            <img class="kluisr" width="560" height="336" src="<?=htmlspecialchars($varpool['bundle']['cover'], ENT_COMPAT)?>">
            <div class="ietjsd" style="margin-bottom: 25px;">
                <h2 class="kuwres single-row" title="<?=htmlspecialchars($varpool['bundle']['name'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($varpool['bundle']['name'], 40, ''), ENT_NOQUOTES)?></h2>
                <span class="ketebn">人气：<?=$varpool['bundle']['viewnum']?></span>
                <span class="kheter">总课时：<?=$varpool['bundle']['coursewarenum']?>课时</span>
                <div class="lectureteachfa">
                    <?php if (!empty($varpool['bundle']['remark'])) { ?>
                        <div class="lectureteach">
                            <p title="<?=$varpool['bundle']['remark']?>"><?=shortstr($varpool['bundle']['remark'], 260)?></p>
                            <span>课程包介绍</span>
                        </div>
                    <?php }?>
                </div>

                <?php if ($varpool['bundle']['bprice'] == 0) { ?>
                    <p class="egrdze-1">免费</p>
                <?php } else { ?>
                    <p class="egrdze"><span class="hrewrd">￥</span><?=sprintf("%01.2f", $varpool['bundle']['bprice'])?></p>
                <?php } ?>


                <p class="rryfge">自报名之日起<span class="ndejtr"><?php if ($varpool['bundle']['imonth'] > 0) { echo $varpool['bundle']['imonth'].'个月'; } else {echo $varpool['bundle']['iday'].'天';} ?></span>有效期</p>
                <?php if ($varpool['bundle']['hasPower'] && $user['groupid'] == 6) { ?>
                    <a class="kehtfs" href="<?=$varpool['bundle']['url']?>">进入学习</a>
                <?php } else { ?>
                    <a href="<?=empty($url) ? 'javascript:;' : $url?>" class="kehtfs<?php if(!empty($varpool['bundle']['cannotpay'])) { ?> plate-sign-disabled <?php } ?><?=$this->sign_status($url)?><?php if(!empty($varpool['bundle']['surveyid'])) { echo ' survey'; } ?>" bid="<?=$varpool['bundle']['bid']?>"><?=$label?></a>
                <?php } ?>
                <?php //限制报名人数的
				if(!empty($varpool['bundle']['islimit']) && $varpool['bundle']['limitnum']>0){
					$color = $varpool['bundle']['opencount'] == $varpool['bundle']['limitnum']?'green':'red';
					?>
				<span style="float:left;font-size:16px;color:#999;margin-top:10px">
				已报名：<span style="color:<?=$color?>;font-weight:bold;"><?=$varpool['bundle']['opencount']?></span>/<span style="font-weight:bold"><?=$varpool['bundle']['limitnum']?></span>
				</span>
				<?php }?>
            </div>
        </div>
    </div>
    <!--课程列表-->
    <div class="lefstr-1 group" style="overflow:hidden;">
        <div class="nav_list">
            <ul id="tagged-tab" class="nav_listson" style="float: left;">
                <li class="sel"><a href="javascript:;" class="sel">课程目录</a></li>
                <li><a href="javascript:;">课程介绍</a></li>
                <li><a href="javascript:;">任课教师</a></li>
            </ul>
        </div>

        <div class="listmode">
            <div class="tagged-tab-content list-content" loaded="1">
                <ul><?php foreach ($varpool['bundle']['courses'] as $course) { ?>
                        <li class="setud kettshe">
                            <div class="ettyusr">
                                <a class="fusrets" style="color:#666" href="/courseinfo/<?=$course['itemid']?>.html" target="_blank">
                                    <img src="<?=$course['img']?>">
                                </a>
                                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png">
                            </div>
                            <div class="sktgte" style="width:440px;">
                                <p style="color: rgb(250, 83, 83); font-size: 15px; font-weight: bold; height: 30px; overflow: hidden;" title="<?=$course['foldername']?>"><?=shortstr($course['foldername'], 50)?></p>
                                <p style="height: 42px; line-height: 1.6; width: 440px;overflow: hidden;"><?=$course['summary']?></p>
                            </div>
                            <div class="fr">
                                <span class="ketebn">人气：<?=$course['viewnum']?></span>
                                <span class="kheter">总课时：<?=$course['coursewarenum']?>课时</span>
                                <p style="font-size: 18px; color: rgb(250, 83, 83); margin-top: 20px; text-align: right; font-weight: bold;">
                                    ￥<?=sprintf("%01.2f", $course['iprice'])?>
                                    <span class="ndejtr" style="font-size:14px">/<?php if ($course['imonth'] > 0) { echo $course['imonth'].'个月'; } else { echo $course['iday'].'天'; } ?></span>
                                </p>
                            </div>

                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tagged-tab-content list-content" loaded="1" style="display:none">
                <div class="coursecatson">
                    <div class="lvjies">
                        <h1><?=$varpool['bundle']['name']?></h1>
                    </div>
                    <div class="courselists"><?php if (!empty($varpool['bundle']['detail'])) { echo h($varpool['bundle']['detail']); } else { ?><div class="nodata"></div><?php } ?></div>
                </div>
            </div>
            <div class="tagged-tab-content list-content" loaded="0" style="display:none"></div>
        </div>
    </div>
    <div class="mainright group">
        <!--最新报名-->
        <?php if (!empty($varpool['latest_sign'])) { ?>
            <div class="ranking-1 ranking1s-1">
                <div class="rankingtitle-1">最新报名</div>
                <div class="rankinglist">
                    <ul>
                        <?php foreach ($varpool['latest_sign'] as $index => $item) { ?>
                            <li<?php if ($index % 5 == 4) { echo ' class="last"'; } ?>>
                                <div class="headportrait"><img width="50" height="50" src="<?=getavater($item,'50_50')?>"></div>
                                <div class="headimg"></div>
                                <div class="rankname"><?=half_hide_name($item['realname'])?></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        <?php } ?>
        <!--最新动态-->
        <?php if (!empty($varpool['dynamic'])) {
            $max_index = count($varpool['dynamic']) - 1; ?>
            <div class="dynamics-1 ranking2s-1">
                <div class="rankingtitle-1">最新动态</div>
                <div class="latestregistrlist">
                    <ul class="floatleft">
                        <?php foreach ($varpool['dynamic'] as $index => $item) { ?>
                            <li<?php if ($index == $max_index) { echo ' class="last"'; } ?>>
                                <div class="touxiang fl">
                                    <div class="headportrait"><img width="50" height="50" src="<?=getavater($item,'50_50')?>"></div>
                                    <div class="newheadimg"></div>
                                </div>
                                <div class="newsignup fl">
                                    <p><?=half_hide_name($item['realname'])?></p>
                                    <div class="openservice">学习课件：<a href="javascript:;" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 10), ENT_NOQUOTES)?></a></div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        <?php } ?>
        <!--热门课程-->
        <?php if (!empty($varpool['courselist'])) { ?>
            <div class="courseranking-1 ranking3s-1">
                <div class="rankingtitle-1">热门课程</div>
                <div class="courserankinglist">
                    <ul class="floatleft">
                        <?php
                        $class_arr = array(
                            1 => 'second',
                            2 => 'third',
                            3 => 'four',
                            4 => 'four',
                            5 => 'four'
                        );
                        foreach ($varpool['courselist'] as $index => $item) {
                            $img = show_plate_course_cover($item['img']);
                            $img = !empty($img) ? show_thumb($img, '129_77') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg' ?>
                            <li<?php if ($index > 0) { echo ' class="'.$class_arr[$index].'"'; } ?>>
                                <div class="pxlist"><?=$index + 1 ?></div>
                                <a href="javascript:;"><div><img src="<?=htmlspecialchars($img, ENT_COMPAT) ?>" class="fl mt5 list-cover" height="55" width="93"></div></a>
                                <div class="coursedetail">
                                    <a href="javascript:;" class="courraanktitle"><?=htmlspecialchars(shortstr($item['foldername'], 20), ENT_NOQUOTES)?></a>
                                </div>
                                <div class="courserankingnumber"><?=$item['coursewarenum']?></div>
                                <div class="rankingpopularity"><?=big_number($item['viewnum'])?></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    var bid = <?=$varpool['bundle']['bid']?>;
    (function($) {
        $("#tagged-tab").bind('click', function(e) {
            if (e.target.nodeName.toLowerCase() != 'a') {
                return false;
            }
            var t = $(e.target);
            $(this).find('a.sel').removeClass('sel');
            var index = $(t.parent('li')).index();
            $("div.tagged-tab-content.list-content").hide();
            var content = $($("div.tagged-tab-content.list-content").get(index));
            if (index == 2 && content.attr('loaded') == '0') {
                content.attr('loaded', '1');
                $.ajax({
                    'url': '/room/portfolio/ajax_teacherinfo.html',
                    'type': 'get',
                    'data': { 'bid': bid },
                    'dataType': 'html',
                    'success': function(h) {
                        content.html(h);
                    }
                });
            }
            content.show()
            t.addClass('sel');
        });
        $("a.kehtfs").bind('click', function() {
            var t = $(this);
            if (t.hasClass('plate-sign-unlogin')) {
                //未登录处理
                if (t.hasClass('survey')) {
                    $.loginByWindow(bid, 2, 'survey');
                    return false;
                }
                $.loginByWindow(bid, 2);
                return false;
            }
            if (t.hasClass('plate-sign-unallow')) {
                //教师账号处理
                $.note('教师账号，不允许进行此操作。', function() {
                    location.reload();
                });
                return false;
            }
            if (t.hasClass('plate-sign-disabled')) {
                //不能报名
                return false;
            }
            if (t.hasClass('survey')) {
                $.logArg = bid;
                $.argType = 2;
                $.checkSurveyed();
                return false;
            }
            if (t.hasClass('plate-sign-free')) {
                //免费课程处理
                $.getBundle(bid, function(bundle) {
                    $.buyFreeBundle(bundle);
                });
                return false;
            }
        });
    })(jQuery);
</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>
