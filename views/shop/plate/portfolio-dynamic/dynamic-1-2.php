<?php
/**
 * 学员动态模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:12
 */
if (!empty($setting)) { if(!empty($varpool['viewholder'])) {
    $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
    $pad_len = 6 - $count;
    for ($i = 0; $i < $pad_len; $i++) {
        $varpool['data'][] = array(
            'username' => "***",
            'groupid' => 6,
            'sex' => $i % 2,
            'realname' => '***',
            'title' => '***'
        );
    }
}?>
    <div class="plate-module latestregistrlist">
        <?php if (!empty($varpool['data'])) {
            $chunk = array_chunk($varpool['data'], 3);
            if (!empty($chunk[0])) {
                $max_index = count($chunk[0]) - 1;
                ?>
                <ul class="fl">
                    <?php foreach ($chunk[0] as $index => $dynamic) { ?>
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
                    <?php } ?>
                </ul>
            <?php }
            if (!empty($chunk[1])) { ?>
                <ul class="fr">
                    <?php $max_index = count($chunk[1]) - 1;
                    foreach ($chunk[1] as $index => $dynamic) {
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
                    <?php } ?>
                </ul>
            <?php }
        } ?>
    </div>
    <?php return;
} ?>


<div class="dynamics-2" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="latestregistrtitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="latestregistrlist">
        <?php if (!empty($varpool['data'])) {
            $chunk = array_chunk($varpool['data'], 3);
            if (!empty($chunk[0])) {
                $max_index = count($chunk[0]) - 1;
                ?>
                <ul class="fl">
                    <?php foreach ($chunk[0] as $index => $dynamic) { ?>
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
                    <?php } ?>
                </ul>
            <?php }
            if (!empty($chunk[1])) { ?>
                <ul class="fr">
                    <?php $max_index = count($chunk[1]) - 1;
                    foreach ($chunk[1] as $index => $dynamic) {
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
                    <?php } ?>
                </ul>
            <?php }
        } ?>
    </div>
</div>
