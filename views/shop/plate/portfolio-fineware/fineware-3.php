<?php
/**
 * 精品课件
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/2/14
 * Time: 11:57
 */
//print_r(get_defined_vars());
$viewnumlib = Ebh::app()->lib('Viewnum');
if (!empty($setting)) { ?>
    <div class="plate-fineware">
        <ul class="group">
            <li><a href="javascript:;" class="onhover">全部</a></li>
            <?php if (!empty($varpool['data']['courses'])) {
                foreach ($varpool['data']['courses'] as $courseid => $course) { ?>
                    <li><a href="javascript:;"><?=htmlspecialchars($course['foldername'], ENT_NOQUOTES)?></a></li>
                <?php }
            } ?>
        </ul>
        <?php if (!empty($varpool['data']['finewares'])) { ?>
            <table class="datatabes">
                <tbody>
                <?php foreach ($varpool['data']['finewares'] as $cid => $item) { ?>
                    <tr>
                        <td>
                            <div class="ettuese">
                                <a class="fsutrert" style="color:#666" href="javascript:;" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>">
                                    <img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
                                </a>
                                <img src="<?=htmlspecialchars($this->show_courseware($item['logo']), ENT_COMPAT)?>">
                            </div>

                            <div class="chisrt">
                                <div>
                                    <h2 class="hrerses">
                                        <a class="hudrter" href="javascript:;" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 26), ENT_NOQUOTES)?></a>
                                    </h2>
                                    <?php if (!empty($item['islive'])) { ?><i class="label-live" title="直播课件">直播</i><?php } ?>
                                    <span class="kkjssjes">开课：<?=date('Y-m-d H:i', $item['truedateline'] > 0 ? $item['truedateline'] : $item['dateline'])?><?php if ($item['endat'] > 0) { ?>   结束：<?=date('Y-m-d H:i', $item['endat'])?><?php } ?></span>
                                </div>
                                <div class="clear"></div>
                                <p class="busrrts"><?=htmlspecialchars(shortstr($item['summary'], 160), ENT_NOQUOTES)?></p>
                                <div>
                                    <?php if (!empty($varpool['data']['publishers'][$item['uid']])) { ?>
                                        <div class="zbteon">
                                            <img style="width:30px;height:30px; border-radius:15px;float:left;" src="<?=getavater($varpool['data']['publishers'][$item['uid']], '50_50')?>">
                                        </div>
                                    <?php } ?>
                                    <p class="lsfbsjes" style="width:500px;">
                                        <span style="width:75px; display:block;" title="<?=htmlspecialchars($this->show_name($varpool['data']['publishers'][$item['uid']]), ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($this->show_name($varpool['data']['publishers'][$item['uid']])), ENT_NOQUOTES)?></span>
                                        <span class="fbsjes" style="width:145px; margin-left:0;"><?=date('Y-m-d H:i', $item['dateline'])?>发布 </span>
                                        <span class="fbsjes">
                            <span class="fbsj2es"></span>
                                            <?=$viewnumlib->getViewnum('courseware', $item['cwid'], $item['viewnum'])?>
                            </span>
                                        <span class="fbsjes">
                            <span class="fbsj1es" style="padding-left:20px;"></span>
                                            <?=intval($item['reviewnum'])?>
                            </span>
                                        <a href="javascript:;" class="removebtn"><?php if ($item['cprice'] == 0) { ?>免费开通<?php } else { ?><span class="sizle">￥<?=intval($item['cprice'])?></span>开通<?php } ?></a>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <?php return;
} ?>
<div class="plate-fineware" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;">
    <h3>精品课件</h3>
    <ul class="group">
        <li><a href="/fineware.html" target="_blank" class="onhover">全部</a></li>
        <?php if (!empty($varpool['data']['courses'])) {
            foreach ($varpool['data']['courses'] as $courseid => $course) { ?>
                <li><a href="/fineware-1-0-<?=$courseid?>.html" target="_blank"><?=htmlspecialchars($course['foldername'], ENT_NOQUOTES)?></a></li>
            <?php }
        } ?>
    </ul>
    <?php if (!empty($varpool['data']['finewares'])) { ?>
    <table class="datatabes" id="fineware-list">
        <tbody>
        <?php
        $logined = !empty($varpool['data']['user']);
        $allowed = true;
        $btn_type = '';
        if (!$logined) {
            //未登录
            $btn_type = ' fineware-sign-unlogin';
        } else if($varpool['data']['user']['groupid'] == 5) {
            //教师用户不允许操作
            $btn_type = ' plate-sign-unallow';
            $allowed = false;
        }
        foreach ($varpool['data']['finewares'] as $cid => $item) {
            $signed = isset($varpool['data']['course_permisions'][$item['folderid']]) || isset($varpool['data']['courseware_permisions'][$cid]);
            $courseware_url = $signed ? "/myroom/mycourse/{$cid}.html" : "/ibuy.html?cwid={$cid}";
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
                        <a data-id="<?=$cid?>" class="courseware-link fsutrert<?=$btn_type?>" style="color:#666" href="<?=$courseware_url?>" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>">
                            <img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
                        </a>
                        <img src="<?=htmlspecialchars($this->show_courseware($item['logo']), ENT_COMPAT)?>">
                    </div>

                    <div class="chisrt">
                        <div>
                            <h2 class="hrerses">
                                <a data-id="<?=$cid?>" class="courseware-link hudrter<?=$btn_type?>" href="<?=$courseware_url?>" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 26), ENT_NOQUOTES)?></a>
                            </h2>
                            <?php if (!empty($item['islive'])) { ?><i class="label-live" title="直播课件">直播</i><?php } ?>
                            <span class="kkjssjes">开课：<?=date('Y-m-d H:i', $item['truedateline'] > 0 ? $item['truedateline'] : $item['dateline'])?><?php if ($item['endat'] > 0) { ?>   结束：<?=date('Y-m-d H:i', $item['endat'])?><?php } ?></span>
                        </div>
                        <div class="clear"></div>
                        <p class="busrrts"><?=htmlspecialchars(shortstr($item['summary'], 160), ENT_NOQUOTES)?></p>
                        <div>
                            <?php if (!empty($varpool['data']['publishers'][$item['uid']])) { ?>
                            <div class="zbteon">
                                <img style="width:30px;height:30px; border-radius:15px;float:left;" src="<?=getavater($varpool['data']['publishers'][$item['uid']], '50_50')?>">
                            </div>
                            <?php } ?>
                            <p class="lsfbsjes" style="width:500px;">
                                <span style="width:75px; display:block;" title="<?=htmlspecialchars($this->show_name($varpool['data']['publishers'][$item['uid']]), ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($this->show_name($varpool['data']['publishers'][$item['uid']])), ENT_NOQUOTES)?></span>
                                <span class="fbsjes" style="width:145px; margin-left:0;"><?=date('Y-m-d H:i', $item['dateline'])?>发布 </span>
                                <span class="fbsjes">
                            <span class="fbsj2es"></span>
                                    <?=$viewnumlib->getViewnum('courseware', $item['cwid'], $item['viewnum'])?>
                            </span>
                                <span class="fbsjes">
                            <span class="fbsj1es" style="padding-left:20px;"></span>
                                    <?=intval($item['reviewnum'])?>
                            </span>
                                <a data-id="<?=$cid?>" href="<?=$courseware_url?>" class="courseware-link removebtn<?=$btn_type?>"><?php if ($signed) { ?>进入学习<?php } else if($item['cprice'] == 0) { ?>免费开通<?php } else { ?><span class="sizle">￥<?=intval($item['cprice'])?></span>开通<?php } ?></a>
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</div>
<script type="text/javascript">
    (function($) {
        $("#fineware-list").bind('click', function(e) {
            var node = e.target.nodeName.toLowerCase();
            var t = $(e.target);
            if (node != 'a') {
                t = t.parent('a.courseware-link');
                if (t.size() == 0) {
                    return false;
                }
            }
            if (t.hasClass('fineware-sign-unlogin')) {
                //未登录处理
                $.loginByWindow(t.data('id'), 'sign-courseware');
                return false;
            }
            if (t.hasClass('plate-sign-unallow')) {
                //教师账号处理
                $.note('教师账号，不允许进行此操作。');
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