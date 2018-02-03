<?php
/**
 * 自选课程模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/05/23
 * Time: 10:06
 */
if (!empty($setting)) { ?>
    <div class="courselistdoule">
        <?php if (!empty($varpool['data'])) {  ?>
            <div class="courselistdouleson group">
                <?php if (!empty($varpool['data'])) {
                    foreach ($varpool['data'] as $package) {
                        if (!empty($package['children'])) { ?>
                            <div class="coursetitlenew"><a href="javascript:;"><?=htmlspecialchars($package['pname'], ENT_COMPAT)?></a></div>
                            <ul class="group">
                                <?php foreach ($package['children'] as $item) {
                                    $cannotpay = !empty($item['cannotpay']);
                                    $free = $item['iprice'] == 0;
                                    if ($free) {
                                        $item['iprice'] = 0;
                                    }
                                    $url = 'javascript:;';
                                    $deal_by_js = false;
                                    $showimg = $item['img'];
                                    if (empty($showimg)) {
                                        $showimg = $this->course_viewholder;
                                    }
                                    $detail_url = !empty($item['showbysort']) ? '/room/portfolio/bundle/'.$item['sid'].'.html' : '/courseinfo/'.$item['itemid'].'.html';
                                    $img = show_plate_course_cover($showimg);
                                    $img = show_thumb($img);?>
                                    <li itemid="<?=$item['itemid']?>"><a href="javascript:;" class="del-manualcourse"></a>
                                        <div class="courseimg">
                                            <a href="javascript:;"><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($img, ENT_COMPAT)?>" /></a>
                                            <div class="introduction" style="display:none;"><a href="javascript:;"><?=shortstr(strip_tags($item['summary']), 200, '')?></a></div>
                                        </div>
                                        <div class="registernow<?php if (!empty($item['allow'])) { ?> registered<?php } elseif(!empty($cannotpay)) { echo ' disabled'; } elseif ($free) {
                                            $systemsetting = Ebh::app()->room->getSystemSetting();
                                            $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                            $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                            if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';}
                                        }
                                        ?>"><a href="javascript:;" class="sign<?=$this->sign_status($url)?>"></a></div>
                                        <div class="coursetitle" style="overflow:hidden;height:32px;"><a href="javascript:;" title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 30, ''), ENT_NOQUOTES)?></a></div>
                                        <div class="popularity">
                                            <?php $item['viewnum'] = $this->getViewnum('folder', $item['folderid'], $item['viewnum']); ?>
                                            <span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : '' ?></span>
                                            <?php if (!empty($item['viewnum']) && $item['viewnum'] != '0') { ?><span class="popule"><?=big_number($item['viewnum'])?></span><?php } ?>
                                            <?php if (!empty($item['coursewarenum']) && $item['viewnum'] != '0') { ?><span class="number"><?=big_number($item['coursewarenum'])?></span><?php } ?>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li><img pid="<?=$package['pid']?>" class="choose-courses" style="cursor:pointer;margin-left:8px;margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/addfree.png" height="144" width="243" /></li>
                            </ul>
                        <?php }
                    }
                }  ?>
            </div>
        <?php  } ?>
        <div class="courselistdouleson group"><ul><li><img pid="0" class="choose-courses" style="cursor:pointer;margin-left:8px;margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/addfree.png" height="144" width="243" /></li></ul></div>
    </div>
    <?php return;
}

if (empty($varpool['data'])) {
    return;
}
?>

<div id="course-content-manual" class="plate-module courselist-2" style="margin-right:auto;margin-left:auto;<?php if (empty($varpool['ajax'])) { ?><?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?><?php } ?>width:<?=$varpool['width']?>px;<?php } ?>;<?php if (!empty($varpool['margin_top'])) { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>">
    <div class="courselistdoule" style="padding-top:0;padding-bottom:5px;">
        <?php if (!empty($varpool['data'])) { ?>
            <div class="courselistdouleson group" id="couses-box">
                <?php if(!empty($varpool['data']['manualcourses'])) {
                    foreach ($varpool['data']['manualcourses'] as $pid => $package) {
                        if (!empty($package['children'])) { ?>
                            <div class="coursetitlenew"><a href="/platform-1-0-0.html?pid=<?=$pid?>"><?=htmlspecialchars($package['pname'], ENT_COMPAT)?></a></div>
                            <ul class="group">
                                <?php foreach ($package['children'] as $item) {
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
                                    $showimg = $item['img'];
                                    if (empty($showimg)) {
                                        $showimg = $this->course_viewholder;
                                    }
                                    $img = show_plate_course_cover($showimg);
                                    $img = show_thumb($img);

                                    //第三方网校的课程禁止进入详情页
                                    $other = false;
                                    if (!empty($item['crid']) && $item['crid'] != $varpool['data']['crid']) {
                                        /*$other = true;
                                        $detail_url = !$free || !empty($item['allow']) ? $url : 'javascript:;';*/
                                    }
                                    ?>
                                    <li itemid="<?=$item['itemid']?>">
                                        <div class="courseimg">
                                            <a<?php if($other){ ?> class="sign<?=$this->sign_status($url)?><?php if(!empty($varpool['data']['surveyid'])) { echo ' survey'; } ?>"<?php } ?> href="<?=htmlspecialchars($detail_url, ENT_COMPAT) ?>"<?php if ($detail_url != 'javascript:;'){ ?> target="_blank"<?php } ?>><img class="plate-cover" width="243" height="144" src="<?=htmlspecialchars($img, ENT_COMPAT)?>" /></a>
                                            <div class="introduction" style="display:none;"><a<?php if($other){ ?> class="sign<?=$this->sign_status($url)?><?php if(!empty($varpool['data']['surveyid'])) { echo ' survey'; } ?>"<?php } ?> href="<?=htmlspecialchars($detail_url, ENT_COMPAT) ?>" <?php if ($detail_url != 'javascript:;'){ ?> target="_blank"<?php } ?>><?=shortstr(strip_tags($item['summary']), 200, '')?></a></div>
                                        </div>
                                        <div class="registernow<?php if (!empty($item['allow'])) { ?> registered<?php } elseif(!empty($cannotpay)) { echo ' disabled'; } elseif ($free) {
                                            $systemsetting = Ebh::app()->room->getSystemSetting();
                                            $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                            $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                            if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';} } ?>"><a href="<?=!empty($url) ? htmlspecialchars($url, ENT_COMPAT) : 'javascript:;'?>" class="sign<?=$this->sign_status($url)?><?php if(!empty($varpool['data']['surveyid'])) { echo ' survey'; } ?>"<?php if (!empty($url) && empty($varpool['data']['surveyid'])){ ?> target="_blank" <?php }?>></a></div>
                                        <div class="coursetitle" style="overflow:hidden;height:32px;"><a<?php if($other){ ?> class="sign<?=$this->sign_status($url)?><?php if(!empty($varpool['data']['surveyid'])) { echo ' survey'; } ?>"<?php } ?> href="<?=htmlspecialchars($detail_url, ENT_COMPAT) ?>"<?php if ($detail_url != 'javascript:;'){ ?>  target="_blank"<?php } ?> title="<?=htmlspecialchars($item['iname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['iname'], 30, ''), ENT_NOQUOTES)?></a></div>
                                        <div class="popularity">
                                            <span class="name"<?php if(!empty($item['speaker'])) { ?> title="<?=htmlspecialchars($item['speaker'], ENT_COMPAT)?>"<?php } ?>><?=!empty($item['speaker']) ? htmlspecialchars(shortstr($item['speaker'], 18, ''), ENT_NOQUOTES) : '' ?></span>
                                            <?php $item['viewnum'] = $this->getViewnum('folder', $item['folderid'], $item['viewnum']); ?>
                                            <?php if (!empty($item['viewnum']) && $item['viewnum'] != '0') { ?><span class="popule"><?=big_number($item['viewnum'])?></span><?php } ?>
                                            <?php if (!empty($item['coursewarenum']) && $item['coursewarenum'] != '0') { ?><span class="number"><?=big_number($item['coursewarenum'])?></span><?php } ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php }
                    }
                } ?>
            </div>

        <?php  } if (empty($varpool['ajax']) && !empty($varpool['data'])) { ?>
            <script type="text/javascript">
                (function($) {
                    var viewholder = "<?=$this->course_viewholder?>";
                    function initEvent() {
                        $(".courseimg").mouseenter(function(){
                            $(this).find(".introduction").show();
                        });
                        $(".courseimg").mouseleave(function(){
                            $(this).find(".introduction").hide();
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
                    }
                    initEvent();
                    $.surveyId = <?=!empty($varpool['data']['surveyid']) ? intval($varpool['data']['surveyid']) : '0'?>;
                    $("#course-content-manual").bind('click', function(e) {
                        var node = e.target.nodeName.toLowerCase();
                        var t = $(e.target);
                        var li = t.parents('li');
                        if (t.hasClass('plate-sign-disabled')) {
                            return false;
                        }
                        if (node == 'a' && t.hasClass('plate-sign-unlogin')) {
                            //未登录处理
                            if (t.hasClass('survey')) {
                                $.loginByWindow(li.attr('itemid'), 'survey');
                                return false;
                            }
                            $.loginByWindow(li.attr('itemid'));
                            return false;
                        }
                        if (node == 'a' && t.hasClass('plate-sign-unallow')) {
                            //教师账号处理
                            $.note('教师账号，不允许进行此操作。');
                            return false;
                        }
                        if (node == 'a' && t.hasClass('survey')) {
                            $.getSingleItem(li.attr('itemid'), function(item) {
                                $.survey(item);
                            });
                            return false;
                        }
                        if (node == 'a' && t.hasClass('plate-sign-free')) {
                            //免费课程处理
                            $.getSingleItem(li.attr('itemid'), function(item) {
                                $.buyFreeItem(item);
                            });
                            return false;
                        }
                    });
                })(jQuery);
            </script>
        <?php } ?>
    </div>
</div>
