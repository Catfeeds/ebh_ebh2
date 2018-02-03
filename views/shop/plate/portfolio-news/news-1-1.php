<?php
/**
 * 网校资讯模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:09
 */
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 6 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'subject' => '***'
            );
        }
    }?>
    <div class="newslist">
        <?php if (!empty($varpool['data'])) {
            $max_index = count($varpool['data']) - 1; ?>
            <ul class="floatleft">
                <?php foreach ($varpool['data'] as $index => $ci) { ?>
                    <li<?php if($max_index == $index){ echo ' class="last"'; } ?>>
                        <div class="fl newson">
                            <a href="javascript:;"><div class="newstitle"><?=htmlspecialchars(shortstr($ci['subject'], 30), ENT_NOQUOTES)?></div></a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <?php return;
} ?>

<div class="plate-module news-1" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="questionnairetitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="newslist">
        <?php if (!empty($varpool['data'])) {
            $varpool['data'] = array_slice($varpool['data'], 0, 5);
            $max_index = count($varpool['data']) - 1; ?>
            <ul class="floatleft">
                <?php foreach ($varpool['data'] as $index => $ci) { ?>
                    <li<?php if($max_index == $index){ echo ' class="last"'; } ?>>
                        <div class="fl newson">
                            <a href="/dyinformation/<?=$ci['itemid']?>.html" target="_blank" title="<?=htmlspecialchars($ci['subject'], ENT_COMPAT)?>"><div class="newstitle"><?=htmlspecialchars(shortstr($ci['subject'], 30, ''), ENT_NOQUOTES)?></div></a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>