<?php
/**
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/7
 * Time: 17:59
 */
$viewnumlib = Ebh::app()->lib('Viewnum');
?>
<?php if (!empty($varpool['design'])) { ?>
    <style type="text/css">
        .denser{margin:0 !important;}
    </style>
<?php } ?>
<div class="coursecenter group">
    <div class="coursedetailson group">
        <div class="ter_tits"><a href="/">首页</a>&nbsp;&gt;&nbsp;<a href="/platform-1-0-0.html?pid=<?=$varpool['pay_sort']['pid']?>&sid=<?=$varpool['pay_sort']['sid']?>"><?=htmlspecialchars($varpool['pay_sort']['sname'], ENT_NOQUOTES)?></a></div>
        <div class="coursedetailson-1">
            <img class="kluisr" width="560" height="336" src="<?=htmlspecialchars($varpool['pay_sort']['imgurl'], ENT_COMPAT)?>">
            <div class="ietjsd" style="margin-bottom: 25px;">
                <h2 class="kuwres single-row" title="<?=htmlspecialchars($varpool['pay_sort']['sname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($varpool['pay_sort']['sname'], 40, ''), ENT_NOQUOTES)?></h2>
                <span class="ketebn">人气：<?=$varpool['pay_sort']['viewnum']?></span>
                <span class="kheter">总课时：<?=$varpool['pay_sort']['coursewarenum']?>课时</span>
                <div class="lectureteachfa">
                    <?php if (!empty($varpool['pay_sort']['summary'])) { ?>
                        <div class="lectureteach">
                            <p title="<?=$varpool['pay_sort']['summary']?>"><?=shortstr($varpool['pay_sort']['summary'], 260)?></p>
                            <span>课程介绍</span>
                        </div>
                    <?php }?>
                </div>

                <?php if ($varpool['pay_sort']['price'] == 0) { ?>
                    <p class="egrdze-1">免费</p>
                <?php } else { ?>
                    <p class="egrdze"><span class="hrewrd">￥</span><?=sprintf("%01.2f", $varpool['pay_sort']['price'])?></p>
                <?php } ?>
                <?php
                $systemsetting = Ebh::app()->room->getSystemSetting();
                $appsetting = Ebh::app()->getConfig()->load('othersetting');
                $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                $szlz = $appsetting['szlz'] == $systemsetting['crid'];
                if (!empty($varpool['pay_sort']['hasPower'])) {
                    $label = $szlz ? '立即观看' : '进入学习';
                } else if ($varpool['pay_sort']['price'] == 0) {
                    $label = $szlz ? '点击观看' : '免费开通';
                } else {
                    $label = '点击报名';
                }
                ?>

                <p class="rryfge">自报名之日起<span class="ndejtr"><?php if ($varpool['pay_sort']['imonth'] > 0) { echo $varpool['pay_sort']['imonth'].'个月'; } else {echo $varpool['pay_sort']['iday'].'天';} ?></span>有效期</p>
                <a href="<?php if (!empty($varpool['pay_sort']['url'])) { ?><?=htmlspecialchars($varpool['pay_sort']['url'], ENT_COMPAT)?><?php } else { ?>javascript:;<?php } ?>" class="kehtfs<?=!empty($varpool['pay_sort']['sign_status']) ? $varpool['pay_sort']['sign_status']:''?>" itemid="<?=$varpool['pay_sort']['sid']?>"><?=$label?></a>
                <div class="msired">
                    <!-- Baidu Button BEGIN -->
                    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>
                    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    <!-- Baidu Button END -->
                </div>
            </div>
        </div>
    </div>
    <!--课程列表-->
    <div class="group bundle">
        <h3>课程介绍</h3>
        <?php if (!empty($varpool['pay_items'])) { ?>
        <ul class="folders group">
            <?php foreach ($varpool['pay_items'] as $item) {
                $img = !empty($item['img']) ? $item['img'] : $this->course_viewholder;
                $img = show_plate_course_cover($img);
                $img = show_thumb($img);
                ?>
                <li><a target="_blank" href="/courseinfo/<?=$item['itemid']?>.html">
                        <div class="cover"><img src="<?=$img?>" width="243" height="144" /></div>
                    <h4 class="single-row"><?=htmlspecialchars($item['foldername'], ENT_NOQUOTES)?></h4>
                    <div class="info group">
                        <span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : ''?></span>
                        <?php
                        $viewnum = $viewnumlib->getViewnum('folder', $item['folderid']);
                        if (empty($viewnum)) {
                            $viewnum = $item['viewnum'];
                        }
                        ?>
                        <?php if (!empty($viewnum)) { ?><span class="popule"><?=$this->large($viewnum, 6)?></span><?php } ?>
                        <?php if (!empty($item['coursewarenum'])) { ?><span class="number"><?=$this->large($item['coursewarenum'], 2)?></span><?php } ?>
                    </div>
                    </a></li>
            <?php } ?>
        </ul>
        <?php } ?>
        <div class="content"><?=h($varpool['pay_sort']['content'])?></div>
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
                                <div class="headportrait"><img src="<?=getavater($item,'50_50')?>" style="width:50px;height:50px;"></div>
                                <div class="headimg"></div>
                                <div class="rankname"><?=half_hide_name(getusername($item))?></div>
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
                                    <div class="headportrait"><img src="<?=getavater($item,'50_50')?>" style="width:50px;height:50px;"></div>
                                    <div class="newheadimg"></div>
                                </div>
                                <div class="newsignup fl">
                                    <p><?=half_hide_name(getusername($item))?></p>
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
                                <?php
                                $viewnum = $viewnumlib->getViewnum('folder', $item['folderid']);
                                if (empty($viewnum)) {
                                    $viewnum = $item['viewnum'];
                                }
                                ?>
                                <div class="rankingpopularity"><?=big_number($viewnum)?></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        $("a.kehtfs").bind('click', function() {
            var t = $(this);
            if (t.hasClass('plate-sign-unlogin')) {
                //未登录处理
                if (t.hasClass('survey')) {
                    $.loginByWindow(t.attr('itemid'), 1, 'survey');
                    return false;
                }
                $.loginByWindow(t.attr('itemid'), 1);
                return false;
            }
            if (t.hasClass('plate-sign-unallow')) {
                //教师账号处理
                $.note('教师账号，不允许进行此操作。', function() {
                    location.reload();
                });
                return false;
            }
            if (t.hasClass('survey')) {
                $.logArg = t.attr('itemid');
                $.argType = 1;
                $.checkSurveyed();
                return false;
            }
            if (t.hasClass('plate-sign-free')) {
                $.getSort(t.attr('itemid'), function(sort) {
                    $.buyFreeSort(sort);
                });
                return false;
            }
        });
    })(jQuery);
</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>
