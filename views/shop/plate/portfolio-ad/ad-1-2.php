<?php
/**
 * 轮播广告模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:08
 */
$index = !empty($varpool['index']) ? $varpool['index'] : 1;
$view_holder = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/ad_2.jpg';

if (!empty($setting)) {
    if (!empty($varpool['custom_data']['options'])) {
        $first_item = current($varpool['custom_data']['options']);
    }
    $first_image = !empty($first_item['image']) ? $first_item['image'] : $view_holder;
    ?>
    <img class="ad" viewholder="<?=htmlspecialchars($view_holder, ENT_COMPAT)?>" src="<?=htmlspecialchars($first_image, ENT_COMPAT)?>" width="590" height="318" />
    <?php if (!empty($varpool['custom_data']['options'])) {
        foreach ($varpool['custom_data']['options'] as $ad) { ?>
            <img class="hd" l="<?= htmlspecialchars($ad['href'], ENT_COMPAT) ?>" z="<?= $ad['zindex'] ?>"
                 src="<?= htmlspecialchars($ad['image'], ENT_COMPAT) ?>" style="display:none;"/>
        <?php }
    }
    return;
} ?>

<?php
//未设置广告
if (empty($varpool['custom_data']['options'])) { ?>
    <div class="plate-module" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
        <img src="<?=$view_holder?>" width="590" height="320" />
    </div>
    <?php return; }
?>

<?php
//单项广告
if (count($varpool['custom_data']['options']) == 1) {
    $ad = $varpool['custom_data']['options'][0];
    if (empty($ad['href'])) { ?>
        <div class="plate-module" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
            <img src="<?=$ad['image']?>" width="590" height="320" />
        </div>
    <?php } else { ?>
        <div class="plate-module" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
            <a href="<?=htmlspecialchars($ad['href'], ENT_COMPAT)?>" target="_blank"><img src="<?=$ad['image']?>" width="590" height="320" /></a>
        </div>
    <?php } return; } ?>


<style type="text/css">
    .slide-<?=$index?>.flexslider .flex-control-nav{bottom:20px;z-index:200}
</style>
<div class="plate-module" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="flexslider slide-<?=$index?>">
        <ul class="slides">
            <?php foreach ($varpool['custom_data']['options'] as $slide) {
                if (!empty($slide['href'])) { ?>
                    <li><a href="<?=htmlspecialchars($slide['href'], ENT_COMPAT)?>" target="_blank"><img width="<?=$varpool['width']?>" height="<?=($varpool['height'] - 8)?>" src="<?=htmlspecialchars($slide['image'], ENT_COMPAT)?>" /></a></li>
                <?php } else { ?>
                    <li><img width="<?=$varpool['width']?>" height="<?=($varpool['height'] - 8)?>" src="<?=htmlspecialchars($slide['image'], ENT_COMPAT)?>" /></li>
                <?php }
            } ?>
        </ul>
        <script type="text/javascript">
            $('.slide-<?=$index?>').flexslider({
                animation: "fade",
                animationSpeed:400,
                slideshowSpeed:3000,
                animationLoop:true,
                pauseOnHover:true,
                initDelay:0
            });
        </script>
    </div>
</div>