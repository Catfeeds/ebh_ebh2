<?php
    //print_r(get_defined_vars());exit;
$viewnumlib = Ebh::app()->lib('Viewnum');
?>
<style type="text/css">
    div.finewall{width:1200px;background-color:#fff;margin:0 auto;padding-top:20px;}
    div.finewall ul.filter{border-radius:2px;background-color:#f6f6f6;margin:0 20px 20px 20px;padding-bottom:10px;}
    div.finewall ul.filter li{float:left;}
    div.finewall div.kjutes{margin:10px 20px 20px 20px;}
    .datatabes tr:last-child td{border-bottom:0 none;}
    <?php if (!empty($varpool['design'])) { ?>.denser{margin:0 !important;}<?php }?>
</style>
<div class="finewall group">
    <?php if (!empty($varpool['courses'])) { ?>
        <ul class="filter group">
            <li><a href="/fineware-1-0-0.html" class="courseall<?php if (empty($varpool['courseid'])) { echo ' onhover'; }?>">全部</a></li>
            <?php foreach ($varpool['courses'] as $courseid => $course) { ?>
                <li><a href="/fineware-1-0-<?=$courseid?>.html" class="courseall<?php if ($varpool['courseid'] == $courseid) { echo ' onhover'; } ?>"><?=htmlspecialchars($course['foldername'], ENT_NOQUOTES)?></a></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <div class="kjutes group">
        <a class="<?=empty($varpool['order_sign']) ? 'lisrhe' : 'luiets' ?>" href="/fineware-1-<?=!empty($varpool['isfree']) ? $varpool['isfree'] : ''?>0-<?=intval($varpool['courseid'])?>.html">最新</a>
        <a class="<?=$varpool['order_sign'] == 1 ? 'lisrhe' : 'luiets' ?>" href="/fineware-1-<?=!empty($varpool['isfree']) ? $varpool['isfree'] : ''?>1-<?=intval($varpool['courseid'])?>.html">最热</a>
        <a class="<?=$varpool['order_sign'] == 2 || $varpool['order_sign']== 3 ? 'lisrhe' : 'luiets' ?>" id="price" href="javascript:;">价格 <img src="http://static.ebanhui.com/ebh/tpl/courses/images/lisrne.png"><ul id="order-by-price" class="order-by-price">
                <li d="/fineware-1-<?=!empty($varpool['isfree']) ? $varpool['isfree'] : ''?>2-<?=intval($varpool['courseid'])?>.html">从高到低</li>
                <li d="/fineware-1-<?=!empty($varpool['isfree']) ? $varpool['isfree'] : ''?>3-<?=intval($varpool['courseid'])?>.html">从低到高</li>
            </ul>
        </a>
        <span><label><input class="kuiets" name="isfree" value="1" id="filter-isfree" type="checkbox"<?php if(!empty($varpool['isfree'])) { echo ' checked="checked"'; } ?>>只看免费课件</label></span>
    </div>
    <?php if (!empty($varpool['items'])) { ?>
        <table class="datatabes" id="fineware-list">
            <tbody>
            <?php
            $logined = !empty($varpool['user']);
            $allowed = true;
            $btn_type = '';
            if (!$logined) {
                //未登录
                $btn_type = ' fineware-sign-unlogin';
            } else if($varpool['user']['groupid'] == 5) {
                //教师用户不允许操作
                $btn_type = ' plate-sign-unallow';
                $allowed = false;
            }
            foreach ($varpool['items'] as $cwid => $item) {
                $signed = isset($varpool['course_permisions'][$item['folderid']]) || isset($varpool['courseware_permisions'][$cwid]);
                $courseware_url = $signed ? "/myroom/mycourse/{$cwid}.html" : "/ibuy.html?cwid={$cwid}";
                if ($logined && $allowed) {
                    if ($signed) {
                        //已开通
                        $btn_type = ' blank';
                    } else if($item['cprice'] == 0) {
                        //免费开通
                        $btn_type = ' fineware-sign-isfree';
                    } else {
                        $btn_type = ' blank';
                    }
                }
                ?>
                <tr>
                    <td>
                        <div class="ettuese">
                            <a class="courseware-link fsutrert<?=$btn_type?>" style="color:#666" data-id="<?=$cwid?>" href="<?=$courseware_url?>" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>">
                                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
                            </a>
                            <img src="<?=htmlspecialchars($this->show_courseware($item['logo']), ENT_COMPAT)?>">
                        </div>

                        <div class="hueders">
                            <div>
                                <h2 class="hrerses">
                                    <a class="courseware-link hudrter<?=$btn_type?>" data-id="<?=$cwid?>" href="<?=$courseware_url?>" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 54), ENT_COMPAT)?></a>
                                </h2>
                                <?php if(!empty($item['islive'])) { ?><i class="label-live" title="直播课件">直播</i><?php } ?>
                            </div>
                            <div class="clear"></div>
                            <p class="bsrtetes"><?=htmlspecialchars(shortstr($item['summary'], 240), ENT_NOQUOTES)?></p>
                            <div>
                                <?php if (isset($varpool['publishers'][$item['uid']])) { ?>
                                <div class="zbteon">
                                    <img style="width:30px;height:30px; border-radius:15px;float:left;" src="<?=getavater($varpool['publishers'][$item['uid']], '50_50')?>">
                                </div>
                                <?php } ?>
                                <p class="lsfbsjes">
                                    <span style="width:75px; display:block;" title="<?=htmlspecialchars($this->show_name($varpool['publishers'][$item['uid']]), ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($this->show_name($varpool['publishers'][$item['uid']]), 8), ENT_NOQUOTES)?></span>
                                    <span class="fbsjes" style="width:145px; margin-left:0;"><?=date('Y-m-d H:i', $item['dateline'])?>发布 </span>
                                    <span class="fbsjes">
                            <span class="fbsj2es"></span>
                            <?=$viewnumlib->getViewnum('courseware', $item['cwid'], $item['viewnum'])?>
                            </span>
                                    <span class="fbsjes">
                            <span class="fbsj1es" style="padding-left:20px;"></span>
                            <?=$item['reviewnum']?>
                            </span>
                                    <span class="kkjssjes" style="width:430px">开课：<?=date('Y-m-d H:i', $item['truedateline'] > 0 ? $item['truedateline'] : $item['dateline'])?><?php if($item['endat'] > 0) { ?>   结束：<?=date('Y-m-d H:i', $item['endat'])?><?php } ?></span>
                                    <a data-id="<?=$cwid?>" href="<?=$courseware_url?>" class="courseware-link removebtn<?=$btn_type?><?php if(!empty($varpool['surveyid'])) { echo ' survey'; } ?>"><?php if ($signed) { ?>进入学习<?php } else if($item['cprice'] == 0) { ?>免费开通<?php } else { ?><span class="sizle">￥<?=intval($item['cprice'])?></span>开通<?php } ?></a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="nodata" style="float:left;"></div>
    <?php } ?>
    <?php if (!empty($varpool['pagestr'])) { ?><div style="clear:both;" class="group"><?=$varpool['pagestr']?></div><?php } ?>
</div>
<script type="text/javascript">
    (function($) {
        var surveyId = <?=!empty($varpool['surveyid']) ? intval($varpool['surveyid']) : '0'?>;
        $.surveyId = surveyId;
        var viewholder = "<?=$this->course_viewholder?>";
        var sort = <?=empty($varpool['order_sign']) ? 0 : $varpool['order_sign']?>;
        var courseid = <?=empty($varpool['courseid']) ? 0 : $varpool['courseid']?>;
        $("#price").bind('mouseenter', function() {
            $("#order-by-price").show();
        }).bind('mouseleave', function() {
            $("#order-by-price").hide();
        }).bind('click', function(e) {
            if (e.target.nodeName.toLowerCase() != 'li') {
                return false;
            }
            location.href = $(e.target).attr('d');
        });
        $("#filter-isfree").bind('change', function() {
            var i = $(this).is(':checked') ? 1 : 0;
            var url = "/fineware-1-" + (i > 0 ? '1' : '') + sort + "-" + courseid + ".html";
            location.href=url;
        });
        $("#fineware-list").bind('click', function(e) {
            var node = e.target.nodeName.toLowerCase();
            var t = $(e.target);
            if (node != 'a') {
                t = t.parent('a.courseware-link');
                if (t.size() == 0) {
                    return true;
                }
            }
            if (t.hasClass('fineware-sign-unlogin')) {
                //未登录处理
                if (t.hasClass('survey')) {
                    $.loginByWindow(t.data('id'), 'survey-courseware');
                    return false;
                }
                $.loginByWindow(t.data('id'), 'sign-courseware');
                return false;
            }
            if (t.hasClass('plate-sign-unallow')) {
                //教师账号处理
                $.note('教师账号，不允许进行此操作。');
                return false;
            }
            if (t.hasClass('survey')) {
                $.getCourseware(t.data('id'), function(item) {
                    $.surveyCourseware(item);
                });
                return false;
            }
            if (t.hasClass('fineware-sign-isfree')) {
                //免费课件处理
                $.getCourseware(t.data('id'), function(item) {
                    $.buyFreeCourseware(item);
                });
                return false;
            }
            if (t.hasClass('blank')) {
                //打开新标签页
                $.blank(t.attr('href'));
                return false;
            }
        });
    })(jQuery);
</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>