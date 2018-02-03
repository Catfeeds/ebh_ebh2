<?php
/**
 * 网校LOG模块(页头)
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/11
 * Time: 15:51
 */
$default_bgcolor = '#8493af';//#f7f7f7";
$default_logo = "http://static.ebanhui.com/ebh/tpl/newschoolindex/images/module_header_logo.jpg";
$bgcolor = !empty($varpool['custom_data']['bgcolor']) ? $varpool['custom_data']['bgcolor'] : $default_bgcolor;
$logo = !empty($varpool['custom_data']['options'][0]) ? show_plate_img($varpool['custom_data']['options'][0]['image']) : $default_logo;
if (!empty($setting)) { ?>
    <div style="background-color:<?=$bgcolor?>;text-align:center;" id="logo-background"><img id="logo-holder" width="1200" height="148" src="<?=$logo?>" /></div>
    <input type="hidden" id="h-top-default-log" value="<?=$default_logo?>" />
    <input type="hidden" id="h-top-bgcolor" value="<?=$bgcolor?>" />
    <input type="hidden" id="h-top-logo" value="<?=$logo?>" />
    <div id="logo-dialog" style="display:none">
        <div class="becarefulfa" style="width:inherit">
            <div class="becareful group">注意：图片大小不超过2M，支持JPG、JPEG、GIF、PNG，<span>最佳尺寸1200*140</span><div class="fr ebtn top-slide-uploader"><a href="javascript:;" class="deletepicture">替换图片</a></div></div>
            <div class="uploadpic" style="background-color:<?=$bgcolor?>;">
                <img src="<?=$logo?>" class="prev" />
            </div>
            <div class="custombackground group">
                <span class="fl">自定义图片背景色</span><input type="text" class="fl logo-color-picker" />
                <span class="fr ebtn del"><a href="javascript:;" class="deletepicture del">使用默认图</a></span>
            </div>
        </div>
    </div>

    <?php return; }
    if (!empty($varpool['forfreeware'])) {
//        $bgcolor = '#f3f3f3';
    }
    ?>


<div class="wrap_header" style="background-color:<?=$bgcolor?>">
	<?php if(is_mobile()){ ?>
	<div class="wrap_headerson" style="width:1200px;">
		<img style="width:1200px;height:140px;" src="<?=$logo?>" />
	</div>
	<?php }else{ ?>
	<div class="wrap_headerson">
		<img src="<?=$logo?>" />
	</div>
	<?php } ?>
	</div>

</div>