<?php
/**
 * 课程服务项
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/10
 * Time: 17:43
 */
if (isset($view_mode) && $view_mode == 2) {
    if (!empty($haspower)) {
        $btn = '进入学习';
    } else if ($price == 0) {
        $btn = !empty($szlz) ? '点击观看' : '免费开通';
    } else {
        $btn = !empty($szlz) ? '点击开通' : '点击报名';
    }
} else {
    if (!empty($haspower)) {
        $btn = '进入';
    } else if ($price == 0) {
        $btn = !empty($szlz) ? '观看' : '免费';
    } else {
        $btn = !empty($szlz) ? '开通' : '报名';
    }
}
?>
<li>
    <a class="item-name" href="<?=$detailurl?>" target="_blank" title="<?=htmlspecialchars($title, ENT_COMPAT)?>"><?=htmlspecialchars($title, ENT_NOQUOTES)?></a>
    <div class="course-cover">
        <a class="course-link" href="<?=$detailurl?>" target="_blank">
            <img src="<?=htmlspecialchars($cover, ENT_COMPAT)?>">
            <div><p><?=$summary?></p></div>
        </a>
        <a class="course-oper <?=$css?>" href="<?=$url?>" t="<?=$t?>" id="<?=$id?>"><?=$btn?></a>
    </div>
    <div class="course-remark"><?=htmlspecialchars($summary, ENT_NOQUOTES)?></div>
    <div class="course-info">
        <span class="speaker" title="<?=htmlspecialchars($speaker, ENT_COMPAT)?>"><?=htmlspecialchars($speaker, ENT_NOQUOTES)?></span>
        <span class="number"><?php if ($coursewarenum > 0) { ?><span class="cn" title="<?=htmlspecialchars($coursewarenum, ENT_COMPAT)?>"><label>课时：</label><?=htmlspecialchars($coursewarenum, ENT_NOQUOTES)?></span><?php } ?>
        <?php if ($viewnum > 0) { ?><span class="vn" title="<?=htmlspecialchars($viewnum, ENT_COMPAT)?>"><label>人气：</label><?=htmlspecialchars($viewnum, ENT_NOQUOTES)?></span><?php } ?></span>
    </div>
</li>