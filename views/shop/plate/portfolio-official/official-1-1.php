<?php
/**
 * 微信公众号模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:14
 */
$default_qcode = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/qcode.jpg';
$qcode = !empty($varpool['custom_data']['options'][0]['image']) ? $varpool['custom_data']['options'][0]['image'] : $default_qcode;
if (!empty($setting)) { ?>
    <div class="public"><img id="qcode" width="212" height="212" src="<?=$qcode?>" alt="微信公众号二维码" /></div>
    <input type="hidden" id="h-official-default-qcode" value="<?=$default_qcode?>" />
    <input type="hidden" id="h-official-qcode" value="<?=$qcode?>" />
    <div id="qcode-dialog" style="display:none">
        <div class="addcode">
            <div class="becareful">注意：图片大小不超过1M，支持JPG、JPEG、GIF、PNG</div>
            <div class="uploadpic"><img class="prev" src="<?=$qcode?>" /></div>
			<div class="uploadpic-wx">点击图片修改二维码</div>
        </div>
    </div>
    <?php
    return;
} ?>

<div class="plate-module md-public" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <h2 class="titsign"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></h2>
    <div class="public"><img width="212" height="212" src="<?=$qcode?>" alt="微信公众号二维码" /></div>
</div>