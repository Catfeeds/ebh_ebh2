<?php
/**
 * 热门标签模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:14
 */
if (!empty($setting)) { ?>
    <div class="hotlabel">
        <?php if (!empty($varpool['data'])) {
            foreach ($varpool['data'] as $crlabel) { ?>
                <a class="bsinson" href="javascript:;"><?=htmlspecialchars($crlabel, ENT_NOQUOTES)?></a>
            <?php    }
        } ?>
    </div>
    <?php return;
} ?>

<div class="plate-module md-hotlabel" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <h2 class="titsign"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></h2>
    <div class="hotlabel">
        <?php if (!empty($varpool['data'])) {
            foreach ($varpool['data'] as $crlabel) { ?>
                <a class="bsinson" href="javascript:;"><?=htmlspecialchars($crlabel, ENT_NOQUOTES)?></a>
            <?php    }
        } ?>
    </div>
</div>