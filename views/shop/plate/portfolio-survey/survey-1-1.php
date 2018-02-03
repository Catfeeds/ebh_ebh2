<?php
/**
 * 调查问卷模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:07
 */
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 6 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'title' => '***'
            );
        }
    }?>
    <div class="questionnairelist width245">
        <ul>
            <?php if (!empty($varpool['data'])) {
                $max_index = count($varpool['data']) - 1;
                foreach ($varpool['data'] as $index => $survey) { ?>
                    <li<?php if($max_index == $index) { echo ' class="last"'; } ?>><a href="javascript:;"><?=htmlspecialchars(shortstr($survey['title'], 28), ENT_NOQUOTES)?></a></li>
                <?php }} ?>
        </ul>
    </div>
    <?php
    return;
} ?>

<div class="plate-module questionnaire-1" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="questionnairetitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="questionnairelist width245">
        <ul>
            <?php if (!empty($varpool['data'])) {
                $max_index = count($varpool['data']) - 1; ?>
                <?php foreach ($varpool['data'] as $index => $survey) { ?>
                    <li<?php if($max_index == $index) { echo ' class="last"'; } ?>><a href="/survey/<?=$survey['sid']?>.html" target="_blank"><?=htmlspecialchars(shortstr($survey['title'], 28), ENT_NOQUOTES)?></a></li>
                <?php }
            } ?>
        </ul>
    </div>
</div>
