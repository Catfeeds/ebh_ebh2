<?php
/**
 * 轮播大图模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/11
 * Time: 16:07
 */
$default_bgcolor = '#8493af';//'#f7f7f7';
if (!empty($varpool['room_type']) && $varpool['room_type'] == 'edu') {
	$default_slides = array(
		array('image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/slide_banner1.jpg', 'bgcolor' => '#8493af'),
		array('image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/slide_banner2.jpg', 'bgcolor' => '#8493af'),
		array('image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/slide_banner3.jpg', 'bgcolor' => '#8493af')
	);
} else {
	$default_slides = array(
		array('image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_banner_1.jpg', 'bgcolor' => '#8493af'),
		array('image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_banner_2.jpg', 'bgcolor' => '#8493af'),
		array('image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/enterprise_banner_3.jpg', 'bgcolor' => '#8493af')
	);
}
//$bgcolor = !empty($varpool['custom_data']['bgcolor']) ? $varpool['custom_data']['bgcolor'] : $default_bgcolor;
if (!empty($varpool['custom_data']['options'][0]['bgcolor'])) {
    $bgcolor = $varpool['custom_data']['options'][0]['bgcolor'];
}
$slides = !empty($varpool['custom_data']['options']) ? $varpool['custom_data']['options'] : $default_slides;
if (!empty($setting)) {
    $first_item = current($slides);
    $bgcolor = $first_item['bgcolor'];
    ?>
    <div style="background-color:<?=$bgcolor?>;text-align:center;" id="slide-background"><img id="slide-holder" src="<?=htmlspecialchars($first_item['image'], ENT_COMPAT)?>"  /></div>
    <input type="hidden" id="h-top-slide-bgcolor" value="" />
    <input type="hidden" id="h-top-slide-slides" value='<?=json_encode($slides, true)?>' />
    <div id="top-slide-dialog" style="display:none;">
        <div class="slide-edit-ex group unselectabled">注意：图片大小不超过2M，支持JPG、JPEG、GIF、PNG，<span class="n">最佳尺寸1200*320</span>，最多上传8张<div class="fr ebtn top-slide-uploader"><a href="javascript:;" class="deletepicture">添加图片</a></div></div>
        <div class="slide-edit" style="background-color:<?=$bgcolor?>">
            <div class="pl ebtn unselectabled"></div>
            <div class="ms top-slide-edit unselectabled"></div>
            <div class="pr ebtn unselectabled"></div>
        </div>
        <div class="slide-edit-ex group unselectabled">
            <span>自定义图片背景色：</span><input type="text" class="top-slide-color-picker" />
            <input type="text" class="link" placeholder="请输入链接地址" />
            <lable class="ml20">图片排序</lable>
            <input type="number" min="0" class="order" maxlength="4" />
            <span class="fr ebtn del">删除图片</span>
        </div>
    </div>
    <?php return; }

if (count($slides) == 0) {
    $current_item = $slides[0]; ?>
    <div class="wrap_banner" style="<?php if(!empty($current_item['bgcolor'])) { ?>background-color:<?=$current_item['bgcolor']?><?php } ?>">
        <div class="top-slide" style="text-align:center;">
            <?php if (empty($current_item['href'])) { ?>
                <img src="<?=htmlspecialchars($current_item['image'], ENT_NOQUOTES)?>" />
            <?php } else { ?>
                <a href="<?=htmlspecialchars($current_item['href'], ENT_COMPAT)?>" target="_blank"><img src="<?=htmlspecialchars($current_item['image'], ENT_NOQUOTES)?>" /></a>
            <?php } ?>
        </div>
    </div>
<?php return; }
?>
<!--banner轮播-->
<style type="text/css">
    .top-slide.flexslider{height:320px;margin:0 auto;width:100%;border:0 none;-webkit-box-shadow: none;-moz-box-shadow:none;box-shadow:none;}
    .top-slide.flexslider .flex-control-nav{bottom:20px;}
    ul.top-slides-with-bg{border:0 none;width:100%;height:320px;padding:0;margin:0;}
    ul.top-slides-with-bg li{border:0 none;width:100%;left:0;top:0;margin:0;height:320px;padding:0;cursor:default;}
    ul.top-slides-with-bg li div{width:100%;text-align:center;}
    ul.top-slides-with-bg li a{display:block;width:1200px;margin:0 auto;}
    ul.top-slides-with-bg li div img{margin:0 auto;}
    .flexslider.top-slide{background:none;}
</style>
<div class="wrap_banner" style="height:320px;">
    <div class="flexslider top-slide">
        <ul class="slides top-slides-with-bg">
            <?php foreach ($slides as $slide) {
                if (!empty($slide['href'])) { ?>
                    <li><div style="background-color:<?=$slide['bgcolor']?>"><a href="<?=htmlspecialchars($slide['href'], ENT_COMPAT)?>" target="_blank">
						<?php if(is_mobile()){ ?>
						<img style="width:1200px;height:320px;" src="<?=$slide['image']?>" />
						<?php }else{ ?>
						<img src="<?=$slide['image']?>" />
						<?php } ?></a></div></li>
                <?php } else { ?>
                    <li><div style="background-color:<?=$slide['bgcolor']?>">
						<?php if(is_mobile()){ ?>
						<img style="width:1200px;height:320px;" src="<?=$slide['image']?>" />
						<?php }else{ ?>
						<img src="<?=$slide['image']?>" />
						<?php } ?>
					</div></li>
                <?php }
            } ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $('.top-slide').flexslider({
        animation: "fade",
        animationSpeed:400,
        slideshowSpeed:3000,
        animationLoop:true,
        pauseOnHover:true,
        directionNav: false,
        initDelay:0,
        after:function() {
            /*var r = (parseInt(Math.random() * 10) + 1) % 2;
            console.log(r);
            this.animation = r == 0 ? 'fade' : 'slide'*/
        }
    });
</script>
