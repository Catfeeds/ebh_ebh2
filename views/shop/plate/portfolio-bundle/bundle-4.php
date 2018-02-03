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
        <div class="courselistdouleson group">
            <ul class="group">
                <?php if (!empty($varpool['list'])) {
                    foreach ($varpool['list'] as $bundle) { ?>
                        <li bid="<?=$bundle['bid']?>"><a href="javascript:;" class="del-bundle"></a>
                            <div class="courseimg">
                                <a href="javascript:;"><img class="plate-cover" width="243" height="144" src="<?=$bundle['cover']?>" /></a>
                                <div class="introduction" style="display:none;"><a href="javascript:;"><?=shortstr($bundle['remark'], 200)?></a></div>
                            </div>
                            <div class="registernow<?php if ($bundle['bprice'] == 0) {
                                $systemsetting = Ebh::app()->room->getSystemSetting();
                                $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';}
                            }
                            ?>"><a href="javascript:;" class="sign<?=$this->sign_status(0)?>"></a></div>
                            <div class="coursetitle" style="overflow:hidden;height:32px;"><a href="javascript:;" title="<?=$bundle['name']?>"><?=shortstr($bundle['name'], 30, '')?></a></div>
                            <div class="popularity">
                                <span class="name" title="<?=$bundle['speaker']?>"><?=shortstr($bundle['speaker'], 18, '')?></span>
                                <span class="popule"><?=$bundle['viewnum']?></span>
                                <span class="number"><?=$bundle['coursewarenum']?></span>
                            </div>
                        </li>
                    <?php }
                } ?>
                <li><img class="choose-bundle" style="cursor:pointer;margin-left:8px;margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/addfree.png" height="144" width="243" /></li>
            </ul>
        </div>
    </div>
    <?php return;
}
if (empty($varpool['data']['bundles'])) {
    return;
}
$user = Ebh::app()->user->getloginuser();
?>

<div id="course-content-bundles" class="plate-module courselist-2" style="margin-right:auto;margin-left:auto;<?php if (empty($varpool['ajax'])) { ?><?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?><?php } ?>width:<?=$varpool['width']?>px;<?php } ?>;<?php if (!empty($varpool['margin_top'])) { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>">
    <div class="courselistdoule" style="padding-top:0;padding-bottom:5px;">
        <?php if (!empty($varpool['data']['bundles'])) { ?>
            <div class="courselistdouleson group">
                <h3 class="bundle-title"><?=$varpool['ititle']?></h3>
                <ul class="group">
                    <?php if (!empty($varpool['data']['bundles'])) {
                        foreach ($varpool['data']['bundles'] as $bundle) { ?>
                            <li bid="<?=$bundle['bid']?>">
                                <div class="courseimg">
                                    <a href="/room/portfolio/tagged/<?=$bundle['bid']?>.html" target="_blank"><img class="plate-cover" width="243" height="144" src="<?=$bundle['cover']?>" /></a>
                                    <div class="introduction" style="display:none;"><a href="/room/portfolio/tagged/<?=$bundle['bid']?>.html" target="_blank"><?=shortstr($bundle['remark'], 200)?></a></div>
                                </div>
                                <div class="registernow<?php if (!empty($bundle['hasPower'])) { echo ' registered'; } else if ($bundle['bprice'] == 0) {
                                    $systemsetting = Ebh::app()->room->getSystemSetting();
                                    $appsetting = Ebh::app()->getConfig()->load('othersetting');
                                    $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                                    if ($appsetting['szlz'] != $systemsetting['crid']) {echo ' free';} else { echo ' szlzfree';}
                                }
                                $url = false;
                                if (!empty($user)) {
                                    if ($user['groupid'] == 5) {
                                        //教师用户不允许开通
                                        $url = '';
                                    } else if (!empty($bundle['hasPower'])) {
                                        //包中的课程都已开通
                                        $url = $bundle['url'];
                                    } else if ($bundle['bprice'] == 0) {
                                        $url = 0;
                                    } else {
                                        $url = '/ibuy.html?bid='.$bundle['bid'];
                                    }
                                }
                                ?>"><a<?php if(!empty($url)) { ?> target="_blank"<?php } ?> href="<?=empty($url) ? 'javascript:;' : $url?>" class="sign<?=$this->sign_status($url)?><?php if(!empty($varpool['data']['surveyid'])) { echo ' survey'; } ?>"></a></div>
                                <div class="coursetitle" style="overflow:hidden;height:32px;"><a href="javascript:;" title="<?=$bundle['name']?>"><?=shortstr($bundle['name'], 30, '')?></a></div>
                                <div class="popularity">
                                    <span class="name" title="<?=$bundle['speaker']?>"><?=shortstr($bundle['speaker'], 18, '')?></span>
                                    <?php if ($bundle['viewnum'] > 0){ ?><span class="popule"><?=$bundle['viewnum']?></span><?php } ?>
                                    <?php if ($bundle['coursewarenum'] > 0) { ?><span class="number"><?=$bundle['coursewarenum']?></span><?php } ?>
                                </div>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>

        <?php  } if (empty($varpool['ajax']) && !empty($varpool['data']['bundles'])) { ?>
            <script type="text/javascript">
                (function($) {
                    var crname = "<?=$varpool['data']['crname']?>";
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
                    $("#course-content-bundles").bind('click', function(e) {
                        var node = e.target.nodeName.toLowerCase();
                        var t = $(e.target);
                        var li = t.parents('li');
                        if (t.hasClass('plate-sign-disabled')) {
                            return false;
                        }
						if (t.hasClass('szlz')) {
							$.titleType = 1;
						}
                        if (node == 'a' && t.hasClass('plate-sign-unlogin')) {
                            //未登录处理
                            if (t.hasClass('survey')) {
                                $.loginByWindow(li.attr('bid'), 2, 'survey');
                                return false;
                            }
                            $.loginByWindow(li.attr('bid'), 2);
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
                            $.logArg = li.attr('bid');
                            $.argType = 2;
                            $.checkSurveyed();
                            return false;
                        }
                        if (node == 'a' && t.hasClass('plate-sign-free')) {
                            //免费课程处理
                            $.getBundle(li.attr('bid'), function(bundle) {
                                $.buyFreeBundle(bundle);
                            });
                            return false;
                        }
                    });
                })(jQuery);
            </script>
        <?php } ?>
    </div>
</div>
