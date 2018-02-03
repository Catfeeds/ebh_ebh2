<?php
/**
 * 课程排行榜模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:15
 */
$viewnumlib = Ebh::app()->lib('Viewnum');
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 6 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'foldername' => "***",
                'coursewarenum' => '***',
                'viewnum' => '***',
                'img' => 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png'
            );
        }
    }
    ?>
    <div class="courserankinglist">
        <?php
        $chunk = array_chunk($varpool['data'], 3);
        $class_arr = array(
            1 => 'second',
            2 => 'third'
        );
        if (isset($chunk[0])) { ?>
            <ul class="floatleft">
                <?php foreach ($chunk[0] as $index => $ci) {
                    $img = show_plate_course_cover($ci['img']);
                    $img = !empty($img) ? show_thumb($img, '129_77') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg' ?>
                    <li<?php if ($index > 0) { echo ' class="'.$class_arr[$index].'"'; } ?>>
                        <div class="pxlist"><?=$index + 1 ?></div>
                        <a href="javascript:;"><img src="<?=htmlspecialchars($img, ENT_COMPAT) ?>" width="93" height="55" class="plate-course-rank-cover fl mt5" /></a>
                        <div class="coursedetail">
                            <a href="javascript:;" class="courraanktitle"><?=htmlspecialchars(shortstr($ci['foldername'], 20), ENT_NOQUOTES)?></a>
                        </div>
                        <div class="courserankingnumber"><?=$ci['coursewarenum']?></div>
                        <div class="rankingpopularity" title="<?=$ci['viewnum']?>"><?=big_number($ci['viewnum'])?></div>
                    </li>
                <?php } ?>
            </ul>
        <?php }
        if (isset($chunk[1])) { ?>
            <ul class="floatright">
                <?php foreach ($chunk[1] as $index => $ci) {
                    $img = show_plate_course_cover($ci['img']);
                    $img = !empty($img) ? show_thumb($img, '129_77') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg'?>
                    <li<?php if ($index > 0) { echo ' class="'.$class_arr[$index].'"'; } ?>>
                        <div class="pxlist"><?=$index + 4 ?></div>
                        <a href="javascript:;"><img class="plate-course-rank-cover fl mt5" src="<?=htmlspecialchars($img, ENT_COMPAT) ?>" width="93" height="55" /></a>
                        <div class="coursedetail">
                            <a href="javascript:;" class="courraanktitle"><?=htmlspecialchars(shortstr($ci['foldername'], 20), ENT_NOQUOTES)?></a>
                        </div>
                        <div class="courserankingnumber"><?=$ci['coursewarenum']?></div>
                        <div class="rankingpopularity" title="<?=$ci['viewnum']?>"><?=big_number($ci['viewnum'])?></div>
                    </li>
                <?php } ?>
            </ul>
        <?php }
        ?>
    </div>
    <?php return;
} ?>

<div class="plate-module courseranking-2" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="freeauditiontitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="courserankinglist">
        <?php
        $chunk = array_chunk($varpool['data'], 3);
        $class_arr = array(
            1 => 'second',
            2 => 'third'
        );
        if (isset($chunk[0])) { ?>
            <ul class="floatleft">
                <?php foreach ($chunk[0] as $index => $ci) {
                    $img = show_plate_course_cover($ci['img']);
                    $img = !empty($img) ? show_thumb($img, '129_77') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg'; ?>
                    <li<?php if ($index > 0) { echo ' class="'.$class_arr[$index].'"'; } ?>>
                        <div class="pxlist"><?=$index + 1 ?></div>
                        <a href="javascript:;"><img src="<?=htmlspecialchars($img, ENT_COMPAT) ?>" width="93" height="55" class="plate-course-rank-cover fl mt5" /></a>
                        <div class="coursedetail">
                            <a href="javascript:;" class="courraanktitle"><?=htmlspecialchars(shortstr($ci['foldername'], 20), ENT_NOQUOTES)?></a>
                        </div>
                        <div class="courserankingnumber"><?=$ci['coursewarenum']?></div>
                        <?php
                        $viewnum = $viewnumlib->getViewnum('folder', $ci['folderid']);
                        if (empty($viewnum)) {
                            $viewnum = $ci['viewnum'];
                        }
                        ?>
                        <div class="rankingpopularity" title="<?=$viewnum?>"><?=big_number($viewnum)?></div>
                    </li>
                <?php } ?>
            </ul>
        <?php }
        if (isset($chunk[1])) { ?>
            <ul class="floatright">
                <?php foreach ($chunk[1] as $index => $ci) {
                    $img = show_plate_course_cover($ci['img']);
                    $img = !empty($img) ? show_thumb($img, '129_77') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg';?>
                    <li<?php if ($index > 0) { echo ' class="'.$class_arr[$index].'"'; } ?>>
                        <div class="pxlist"><?=$index + 4 ?></div>
                        <a href="javascript:;"><img class="plate-course-rank-cover fl mt5" src="<?=htmlspecialchars($img, ENT_COMPAT) ?>" width="93" height="55" /></a>
                        <div class="coursedetail">
                            <a href="javascript:;" class="courraanktitle"><?=htmlspecialchars(shortstr($ci['foldername'], 20), ENT_NOQUOTES)?></a>
                        </div>
                        <div class="courserankingnumber"><?=$ci['coursewarenum']?></div>
                        <?php
                        $viewnum = $viewnumlib->getViewnum('folder', $ci['folderid']);
                        if (empty($viewnum)) {
                            $viewnum = $ci['viewnum'];
                        }
                        ?>
                        <div class="rankingpopularity" title="<?=$viewnum?>"><?=big_number($viewnum)?></div>
                    </li>
                <?php } ?>
            </ul>
        <?php }
        ?>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        $("img.plate-course-rank-cover").bind('error', function() {
            var src = $(this).attr("src");
            src = src.replace('_129_77', '');
            $(this).attr('src', src);
            var errnum = $(this).attr('errnum') || 0;
            if (errnum > 0) {
                $(this).unbind('error');
                return;
            }
            errnum++;
            $(this).attr('errnum', errnum);
        });
    })(jQuery);
</script>