<?php
/**
 * 免费试听模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:09
 */
$count = !empty($varpool['data']) ? count($varpool['data']) : 0;
$show_add_btn = $count == 0 || $count % 6 > 0;
$show_more_btn = $count > 0 && $count % 6 == 0;
$height = 237 + (max(ceil($count / 6.0), 1) - 1) * 320;
if (!empty($setting)) { ?>
    <div class="freeauditionlist" id="free-e" style="height:<?=$height?>px">
        <ul>
            <?php if (!empty($varpool['data'])) {
                foreach ($varpool['data'] as $item) { ?>
                    <li><a href="javascript:;" class="del-free-item" d="<?=$item['cwid']?>"></a>
                        <div class="imagemin"><a href="javascript:;"><img src="<?=!empty($item['logo']) ? htmlspecialchars($item['logo'], ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png'?>" width="180" height="108" /></a></div>
                        <a href="javascript:;"><div class="coursename" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 24), ENT_NOQUOTES)?></div></a>
                    </li>
                <?php }
            } ?>
            <li class="add"<?php if (!$show_add_btn){ echo ' style="display:none;"'; } ?>>
                <div class="imagemin"><a href="javascript:;" class="s" d="0"></a><a href="javascript:;"><img class="add-free-courseware" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/addfree.png" /></a></div>
            </li>
        </ul>
        <div class="exp-more"<?php if (!$show_more_btn){ echo ' style="display:none;"'; } ?>>继续添加>><input type="hidden" value="6" id="freesize" /></div>
    </div>
    <?php return;
} ?>

<div class="plate-module freeaudition-2" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;height:<?=$varpool['height']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;">
    <div class="freeauditiontitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="freeauditionlist" style="<?php if(empty($varpool['float'])) { ?>height:<?=$height?>px<?php } else { ?>float:inherit;<?php }?>">
        <ul>
            <?php if (!empty($varpool['data'])) {
                $height = $varpool['height'];
                $line = ($varpool['height'] - 320) / 330 + 1;
                $max_count = 6 * $line;
                if ($max_count > 0) {
                    $varpool['data'] = array_slice($varpool['data'], 0, $max_count);
                }
                foreach ($varpool['data'] as $item) { ?>
                    <li>
                        <div class="imagemin">
							<img class="scrimg" src="<?=!empty($item['logo']) ? htmlspecialchars($item['logo'], ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png'?>" />
						<a class="play-courseware playscal" href="/course/<?=$item['cwid']?>.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png"></a>
						</div>
                        <a href="/course/<?=$item['cwid']?>.html" target="_blank"><div class="coursename" title="<?=htmlspecialchars($item['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($item['title'], 24), ENT_NOQUOTES)?></div></a>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>
</div>