<?php
/**
 * 积分排名模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:10
 */
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 24 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'username' => "***",
                'groupid' => 6,
                'sex' => $i % 2,
                'realname' => '***',
                'credit' => '***'
            );
        }
    }
    ?>
    <div class="rankinglist">
        <ul>
            <?php if (!empty($varpool['data'])) {
                foreach ($varpool['data'] as $index => $student) {
                    $is_last = $index % 8 == 7; ?>
                    <li<?php if ($is_last) { echo ' class="last"'; } ?>>
                        <div class="headportrait"><img src="<?=getavater($student,'50_50')?>" style="width:50px;height:50px;" /></div>
                        <div class="headimg"></div>
                        <div class="rankname"><?=!empty($student['realname']) ? half_hide_name($student['realname']) : half_hide_username($student['username'])?></div>
                        <div class="integral"><?=$student['credit']?></div>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>
    <?php return;
} ?>

<div class="plate-module ranking-2" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="rankingtitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="rankinglist">
        <ul>
            <?php if (!empty($varpool['data'])) {
                foreach ($varpool['data'] as $index => $student) {
                    $is_last = $index % 8 == 7; ?>
                    <li<?php if ($is_last) { echo ' class="last"'; } ?>>
                        <div class="headportrait"><img src="<?=getavater($student,'50_50')?>" style="width:50px;height:50px;" /></div>
                        <div class="headimg"></div>
                        <div class="rankname"><?=!empty($student['realname']) ? half_hide_name($student['realname']) : half_hide_username($student['username'])?></div>
                        <div class="integral"><?=$student['credit']?></div>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>
</div>
