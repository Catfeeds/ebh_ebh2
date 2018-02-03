<?php
/**
 * 应用模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:12
 */
if (!empty($setting)) { ?>
    <div class="apply">
        <?php if (!empty($varpool['data'])) {
            foreach ($varpool['data'] as $app) { ?>
                <a href="javascript:;" class="apply-class">
                    <img src="<?=htmlspecialchars($app['img'], ENT_COMPAT)?>" width="60" height="60" />
                    <span class="hdsntr"><?=htmlspecialchars(shortstr($app['title'], 18), ENT_NOQUOTES)?></span>
                </a>
            <?php    }
        } ?>
    </div>
    <?php return;
} ?>

<div class="plate-module md-apply" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <h2 class="titsign"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></h2>
    <div class="apply">
        <?php if (!empty($varpool['data'])) {
            foreach ($varpool['data'] as $app) { ?>
                <a href="<?=htmlspecialchars($app['url'], ENT_COMPAT)?>" class="apply-class" title="<?=htmlspecialchars($app['title'], ENT_COMPAT)?>" target="_blank">
                    <img src="<?=htmlspecialchars($app['img'], ENT_COMPAT)?>" width="60" height="60" />
                    <span class="hdsntr"><?=htmlspecialchars(shortstr($app['title'], 18), ENT_NOQUOTES)?></span>
                </a>
            <?php    }
        } ?>
    </div>
</div>
