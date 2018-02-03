<?php
/**
 * 学员动态模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:12
 */
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 3 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'username' => "***",
                'groupid' => 6,
                'sex' => $i % 2,
                'realname' => '***',
                'title' => '***'
            );
        }
    } ?>
    <div class="latestregistrlist">
        <ul class="floatleft">
            <?php
            if (!empty($varpool['data'])) {
                $max_index = count($varpool['data']) - 1;
                foreach ($varpool['data'] as $index => $dynamic) {
                    ?>
                    <li<?php if ($index == $max_index) { echo " class='last'"; }?>>
                        <div class="touxiang fl">
                            <div class="headportrait"><img src="<?=getavater($dynamic,'50_50')?>" style="width:50px;height:50px;" /></div>
                            <div class="newheadimg"></div>
                        </div>
                        <div class="newsignup fl">
                            <p><?=half_hide_username($dynamic['username'])?>(<?=half_hide_name($dynamic['realname'])?>)</p>
                            <div class="openservice">学习课件：<a href="javascript:;" title="<?=htmlspecialchars($dynamic['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($dynamic['title'], 8), ENT_NOQUOTES)?></a></div>
                        </div>
                    </li>
                <?php    }
            } ?>
        </ul>
    </div>
    <?php return;
} ?>


<div class="plate-module dynamics-1" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="latestregistrtitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="latestregistrlist">
        <ul class="floatleft">
            <?php
            if (!empty($varpool['data'])) {
                $max_index = count($varpool['data']) - 1;
                foreach ($varpool['data'] as $index => $dynamic) {
                    ?>
                    <li<?php if ($index == $max_index) { echo " class='last'"; }?>>
                        <div class="touxiang fl">
                            <div class="headportrait"><img src="<?=getavater($dynamic,'50_50')?>" style="width:50px;height:50px;" /></div>
                            <div class="newheadimg"></div>
                        </div>
                        <div class="newsignup fl">
                            <p><?=half_hide_username($dynamic['username'])?>(<?=half_hide_name($dynamic['realname'])?>)</p>
                            <div class="openservice">学习课件：<a href="javascript:;" title="<?=htmlspecialchars($dynamic['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($dynamic['title'], 8), ENT_NOQUOTES)?></a></div>
                        </div>
                    </li>
                <?php    }
            } ?>
        </ul>
    </div>
</div>
