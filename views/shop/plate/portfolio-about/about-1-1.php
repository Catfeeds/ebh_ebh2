<?php
/**
 * 网校简介模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/11
 * Time: 17:31
 */
$default_logo = $varpool['room_type'] == 'com' ? 'http://static.ebh.net/ebh/tpl/newschoolindex/images/com_logo.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg';
$classroom_logo = !empty($varpool['data']['cface']) ? $varpool['data']['cface'] : $default_logo;
if (!empty($setting)) { ?>
    <div class="schoolprofilemain">
        <img src="<?=htmlspecialchars($classroom_logo, ENT_COMPAT)?>" style="width:80px;height:80px" class="fl imgleft" />
        <?=shortstr($varpool['data']['summary'], 240)?>
    </div>
    <?php return;
} ?>

<!--网校简介-->
<div class="plate-module schoolprofile-1" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="rankingtitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="schoolprofilemain">
        <img src="<?=htmlspecialchars($classroom_logo, ENT_COMPAT)?>" style="width:80px;height:80px" class="fl imgleft" />
        <?=shortstr($varpool['data']['summary'], 240)?>
    </div>
</div>
