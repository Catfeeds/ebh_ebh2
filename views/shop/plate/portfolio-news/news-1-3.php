<?php
/**
 * 网校资讯模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/12
 * Time: 10:09
 */
if (!empty($setting)) {
    if(!empty($varpool['viewholder'])) {
        $count = !empty($varpool['data']) ? count($varpool['data']) : 0;
        $pad_len = 6 - $count;
        for ($i = 0; $i < $pad_len; $i++) {
            $varpool['data'][] = array(
                'subject' => '***',
                'thumb' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg',
                'note' => '***'
            );
        }
    }?>

    <div class="newslist">
        <?php if (!empty($varpool['data'])) {
            $chunk = array_chunk($varpool['data'], 3);
            if (!empty($chunk[0])) { ?>
                <ul class="fl">
                    <?php foreach ($chunk[0] as $nitem) { ?>
                        <li>
                            <a href="javascript:;"><div class="fl"><img width="90" height="68" src="<?=!empty($nitem['thumb']) ? htmlspecialchars($this->show_plate_news_img($nitem['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg' ?>" /></div></a>
                            <div class="fl newson">
                                <a href="javascript:;"><div class="newstitle"><?=htmlspecialchars(shortstr($nitem['subject'], 16), ENT_NOQUOTES)?></div></a>
                                <a href="javascript:;"><div class="newsmain"><?=shortstr($nitem['note'], 40)?></div></a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php }
            if (!empty($chunk[1])) { ?>
                <ul class="fr">
                    <?php foreach ($chunk[1] as $nitem) { ?>
                        <li>
                            <a href="javascript:;"><div class="fl"><img width="90" height="68" src="<?=!empty($nitem['thumb']) ? htmlspecialchars($this->show_plate_news_img($nitem['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg' ?>" /></div></a>
                            <div class="fl newson">
                                <a href="javascript:;"><div class="newstitle"><?=htmlspecialchars(shortstr($nitem['subject'], 16), ENT_NOQUOTES)?></div></a>
                                <a href="javascript:;"><div class="newsmain"><?=shortstr($nitem['note'], 40)?></div></a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php }
        } ?>
    </div>
    <?php return;
} ?>


<div class="plate-module news-3" style="<?php if (empty($varpool['float'])) { ?>position:absolute;top:<?=$varpool['top']?>px;left:<?=$varpool['left']?>px;<?php } else { ?>margin-top:<?=$varpool['margin_top']?>px;<?php } ?>width:<?=$varpool['width']?>px;height:<?=$varpool['height']?>px">
    <div class="questionnairetitle"><?=htmlspecialchars($varpool['ititle'], ENT_NOQUOTES)?></div>
    <div class="newslist">
        <?php if (!empty($varpool['data'])) {
            $chunk = array_chunk($varpool['data'], 3);
            if (!empty($chunk[0])) { ?>
                <ul class="fl">
                    <?php foreach ($chunk[0] as $nitem) { ?>
                        <li>
                            <a href="/dyinformation/<?=$nitem['itemid']?>.html" target="_blank"><div class="fl"><img width="90" height="68" src="<?=!empty($nitem['thumb']) ? htmlspecialchars($this->show_plate_news_img($nitem['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg' ?>" /></div></a>
                            <div class="fl newson">
                                <a href="/dyinformation/<?=$nitem['itemid']?>.html" target="_blank"><div class="newstitle"><?=htmlspecialchars(shortstr($nitem['subject'], 16), ENT_NOQUOTES)?></div></a>
                                <a href="/dyinformation/<?=$nitem['itemid']?>.html" target="_blank"><div class="newsmain"><?=shortstr($nitem['note'], 40)?></div></a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php }
            if (!empty($chunk[1])) { ?>
                <ul class="fr">
                    <?php foreach ($chunk[1] as $nitem) { ?>
                        <li>
                            <a href="/dyinformation/<?=$nitem['itemid']?>.html" target="_blank"><div class="fl"><img width="90" height="68" src="<?=!empty($nitem['thumb']) ? htmlspecialchars($this->show_plate_news_img($nitem['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg' ?>" /></div></a>
                            <div class="fl newson">
                                <a href="/dyinformation/<?=$nitem['itemid']?>.html" target="_blank"><div class="newstitle"><?=htmlspecialchars(shortstr($nitem['subject'], 16), ENT_NOQUOTES)?></div></a>
                                <a href="/dyinformation/<?=$nitem['itemid']?>.html" target="_blank"><div class="newsmain"><?=shortstr($nitem['note'], 40)?></div></a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php }
        } ?>
    </div>
</div>
