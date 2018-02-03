<?php
/**
 * 名师详情
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/10
 * Time: 17:47
 */
?>
<style type="text/css">
    .famous {
        margin: 10px auto 0;
        width: 1200px;
    }
    .famous_main {
        background: #fff none repeat scroll 0 0;
        display: inline-block;
        padding: 20px;
        height:200px;
        width:1160px;
    }
    .famous_left {
        border-right:solid 1px #eee;
        width:470px;
        float:left;
        height:200px;
    }
    .famous_left img {
        margin:0 45px 0 65px;
        border-radius:100%;
        float:left;
        width:182px;
        height:182px;
    }
    .famous_left_ptit {
        margin-top:30px;
        font-size:20px;
        float:left;
        width:176px;
        color:#333;
        font-weight:bold;
    }
    .famous_left_ptxt {
        font-size:14px;
        color:#999;
        float:left;
        margin-top:20px;
        line-height:1.8;
        height:125px;
        overflow:hidden;
        width:145px;
    }
    .famous_right {
        width:520px;
        float:left;
        margin-left:40px;
        height:200px;
    }
    .famous_right_ptit {
        margin-top:30px;
        font-size:20px;
        float:left;
        width:176px;
        color:#333;
        font-weight:bold;
    }
    .famous_right_ptxt {
        font-size:14px;
        color:#999;
        float:left;
        margin-top:20px;
        line-height:1.8;
        height:125px;
        overflow:hidden;
        width:100%;
    }
    .famous_det {
        background: #fff none repeat scroll 0 0;
        display: inline-block;
        height:auto;
        width:1200px;
        margin-top:10px;
    }
    <?php if (!empty($varpool['design'])) { ?>
    .denser{margin:0 !important;}
    <?php } ?>
</style>
<div class="famous ">
    <div class="famous_main">
        <div class="famous_left">
        <?php $varpool['master']['groupid']=5;?>
            <img src="<?=getavater($varpool['master'], '120_120')?>" />
            <p class="famous_left_ptit"><?=htmlspecialchars($varpool['master']['realname'], ENT_NOQUOTES)?></p>
            <p class="famous_left_ptxt"><?=htmlspecialchars($varpool['master']['professionaltitle'], ENT_NOQUOTES)?></p>
        </div>
        <div class="famous_right">
            <p class="famous_right_ptit">个人简介</p>
            <p class="famous_right_ptxt"><?=htmlspecialchars(shortstr($varpool['master']['profile'],360), ENT_NOQUOTES)?></p>
        </div>
    </div>
    <div class="lefstr-1 group" style="width:1200px;margin-top:0;padding-top:10px;">
        <div class="nav_list">
            <ul class="nav_listson">
                <li><a href="javascript:;" class="tab" index="0">详细介绍</a></li>
                <li><a href="javascript:;" class="tab sel" index="1">所教课程</a></li>
                <li><a href="javascript:;" class="tab" index="2">所教课程包</a></li>
            </ul>
        </div>
        <div id="couses-box" class="courselistdouleson group" style="padding:20px;">
            <div class="item-group" style="display:none;">
                <?=$varpool['master']['message']?>
                <?php if(empty($varpool['master']['message'])) { ?><div class="nodata" style="float:left;"></div><?php } ?>
            </div>
            <ul class="item-group">
                <?php if (!empty($varpool['items'])) { ?>
                    <ul>
                        <?php foreach ($varpool['items'] as $itemid => $item) {
                            $cannotpay = !empty($item['cannotpay']);
                            $free = $item['iprice'] == 0 || !empty($varpool['isalumni']) && $item['isschoolfree'] == 1;
                            if ($free) {
                                $item['iprice'] = 0;
                            }
                            $url = $this->format_pay_item_url($item, !empty($varpool['userpermisions']) ? $varpool['userpermisions'] : false);
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
                            $img = show_plate_course_cover($showimg);
                            $img = show_thumb($img);

                            $detail_url = !empty($item['showbysort']) ? '/room/portfolio/bundle/'.$item['sid'].'.html' : '/courseinfo/'.$item['itemid'].'.html';
                            ?>
                            <li itemid="<?=$item['itemid']?>" t="0">
                                <div class="courseimg">
                                    <a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>" target="_blank"><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($img, ENT_COMPAT)?>"></a>
                                    <div class="introduction" style="display: none; opacity: 0.996441;"><a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>" target="_blank"><?=shortstr(strip_tags($item['summary']), 120, '')?></a></div>
                                </div>
                                <div class="registernow<?php if (!empty($item['allow'])) { ?> registered<?php } elseif(!empty($cannotpay)) { echo ' disabled'; } elseif ($free){
                                    $systemsetting = Ebh::app()->room->getSystemSetting();
                                    $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                    $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                    if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';}
                                }
                                ?>"><a href="<?=!empty($url) ? htmlspecialchars($url, ENT_COMPAT) : 'javascript:;'?>" class="sign<?php if(!empty($varpool['surveyid'])) { echo ' survey'; } ?><?=$this->sign_status($url)?>"<?php if (!empty($url) && empty($varpool['surveyid'])){ ?> target="_blank" <?php }?>></a></div>
                                <div class="coursetitle" style="height:32px;overflow:hidden;"><a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>" target="_blank"><?=htmlspecialchars(shortstr($item['iname'], 30, ''), ENT_NOQUOTES)?></a></div>
                                <div class="popularity">
                                    <span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : ''?></span>
                                    <?php if (!empty($item['viewnum'])) { ?><span class="popule"><?=$item['viewnum']?></span><?php } ?>
                                    <?php if (!empty($item['coursewarenum'])) { ?><span class="number"><?=$item['coursewarenum']?></span><?php } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="nodata" style="float:left;"></div>
                <?php } ?>

            </ul>
            <ul class="item-group" style="display:none;">
                <?php if (!empty($varpool['bundles'])) { ?>
                    <ul>
                        <?php foreach ($varpool['bundles'] as $bundle) {
                            $btnClass = array();
                            $free = false;
                            if (empty($varpool['szlz'])) {
                                $btnClass[] = 'szlz';
                            }
                            if (empty($varpool['user'])) {
                                $btnClass[] = 'plate-sign-unlogin';
                            } else if($varpool['user']['groupid'] == 5) {
                                $btnClass[] = 'plate-sign-unallow';
                            }
                            if (!empty($bundle['hasPower'])) {
                                $btnClass[] = 'allow';
                            } else if ($bundle['bprice'] == 0) {
                                $free = true;
                                $btnClass[] = 'free';
                            }
                            if (!empty($bundle['url'])) {
                                $url = $bundle['url'];
                            }
                            $detail_url = '/room/portfolio/tagged/'.$bundle['bid'].'.html';
                            ?>
                            <li itemid="<?=$bundle['bid']?>" t="2">
                                <div class="courseimg">
                                    <a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>" target="_blank"><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($bundle['cover'], ENT_COMPAT)?>"></a>
                                    <div class="introduction" style="display: none; opacity: 0.996441;"><a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>" target="_blank"><?=shortstr(strip_tags($bundle['remark']), 120, '')?></a></div>
                                </div>
                                <div class="bundle-btn registernow<?php if (!empty($bundle['hasPower'])) { ?> registered<?php } elseif ($free){
                                    $systemsetting = Ebh::app()->room->getSystemSetting();
                                    $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                    $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                    if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';}
                                }
                                ?>"><a href="<?=!empty($url) ? htmlspecialchars($url, ENT_COMPAT) : 'javascript:;'?>" class="sign<?php if(!empty($varpool['surveyid'])) { echo ' survey'; } ?> <?=implode(' ', $btnClass)?>"<?php if (!empty($url) && empty($varpool['surveyid'])){ ?> target="_blank" <?php }?>></a></div>
                                <div class="coursetitle" style="height:32px;overflow:hidden;"><a href="<?=htmlspecialchars($detail_url, ENT_COMPAT)?>" title="<?=htmlspecialchars($bundle['name'], ENT_COMPAT)?>" target="_blank"><?=htmlspecialchars(shortstr($bundle['name'], 30, ''), ENT_NOQUOTES)?></a></div>
                                <div class="popularity">
                                    <span class="name"<?php if(!empty($bundle['speaker'])) { ?> title="<?=htmlspecialchars($bundle['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($bundle['speaker']) ? htmlspecialchars(shortstr($bundle['speaker'], 18, ''), ENT_NOQUOTES) : ''?></span>
                                    <?php if (!empty($bundle['viewnum'])) { ?><span class="popule"><?=$bundle['viewnum']?></span><?php } ?>
                                    <?php if (!empty($bundle['coursewarenum'])) { ?><span class="number"><?=$bundle['coursewarenum']?></span><?php } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="nodata" style="float:left;"></div>
                <?php } ?>

            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        var viewholder = "<?=$this->course_viewholder?>";
        $("a.tab").bind('click', function() {
            $("a.tab.sel").removeClass('sel');
            $(this).addClass('sel');
            $("#couses-box .item-group").hide();
            $($("#couses-box .item-group").get($(this).attr('index'))).show();
        });

        $("img.plate-cover").bind('error', function() {
            var src = $(this).attr("src");
            var errnum = $(this).attr('errnum') || 0;
            if (errnum > 0) {
                $(this).unbind('error');
                $(this).attr('src', viewholder);
                return;
            }
            errnum++;
            $(this).attr('errnum', errnum);
            src = src.replace('_243_144', '');
            $(this).attr('src', src);
        });
        function initEvent() {
            $(".courseimg").mouseenter(function(){
                $(this).find(".introduction").show();
            });
            $(".courseimg").mouseleave(function(){
                $(this).find(".introduction").hide();
            });
        }
        initEvent();
        $.surveyId = <?=!empty($varpool['surveyid']) ? intval($varpool['surveyid']) : '0'?>;
        $("#couses-box").bind('click', function(e) {
            var node = e.target.nodeName.toLowerCase();
            var t = $(e.target);
            var li = t.parents('li');
            if (t.hasClass('plate-sign-disabled')) {
                return false;
            }
            var argType = li.attr('t');
            if (node == 'a' && t.hasClass('plate-sign-unlogin')) {
                //未登录处理
                if (t.hasClass('survey')) {
                    $.loginByWindow(li.attr('itemid'), argType, 'survey');
                    return false;
                }
                $.loginByWindow(li.attr('itemid'), argType);
                return false;
            }
            if (node == 'a' && t.hasClass('plate-sign-unallow')) {
                //教师账号处理
                $.note('教师账号，不允许进行此操作。', function() {
                    location.reload();
                });
                return false;
            }
            if (node == 'a' && t.hasClass('survey')) {
                $.logArg = li.attr('itemid');
                $.argType = li.attr('t');
                $.checkSurveyed();
                return false;
            }
            if (node == 'a' && t.hasClass('plate-sign-free')) {
                //免费课程处理
                if (argType == 2) {
                    $.getSort(li.attr('itemid'), function(sort) {
                        $.buyFreeSort(sort);
                    });
                    return false;
                }
                $.getSingleItem(li.attr('itemid'), function(item) {
                    $.buyFreeItem(item);
                });
                return false;
            }
        });
    })(jQuery);
</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>

