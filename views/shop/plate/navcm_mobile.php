<?php
/**
 * 自定义富文本链接
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/11/8
 * Time: 16:21
 */

?>
<div class="navcm group" style="margin-bottom:0">
    <?php if (!empty($varpool['subnav'])) { ?>
        <ul class="navcm-sub">
            <?php foreach ($varpool['subnav'] as $subnav) { ?>
                <li<?php if ($subnav['index'] == $varpool['subid']) { echo ' class="cur"'; } ?>><a href="<?=htmlspecialchars($subnav['url'], ENT_COMPAT)?>"><?=$subnav['subnickname']?></a></li>
            <?php } ?>
        </ul>
    <?php } ?>

    <?php if (!empty($varpool['sublist'])) {
        if (count($varpool['sublist']) == 1) { ?>
            <div class="navcm-float-content" style="width:1140px;">
                <?php if (!empty($varpool['sublist'][0])) { ?>
                    <h2 style="font-size:26px;margin:0;padding:10px 0;letter-spacing:3px;text-align:center;"><?=htmlspecialchars($varpool['sublist'][0]['subject'], ENT_NOQUOTES) ?></h2>
                    <div class="timeb">
                        <span>时间：<?=Date('Y-m-d H:i',$varpool['sublist'][0]['dateline'])?></span>
                        <span>人气：<?=$varpool['sublist'][0]['viewnum']+1?></span>
                    </div>
                    <!-- Baidu Button BEGIN -->
                    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>
                    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    <!-- Baidu Button END -->
                    <?=stripslashes(str_replace('&lt;str&gt;', '', $varpool['sublist'][0]['message']))?>
                <?php } else { ?>
                    <div class="nodata"></div>
                <?php } ?>
            </div>
        <?php } else {
            $max_index = count($varpool['sublist']) - 1;?>
            <div class="navcm-list">
                <?php foreach($varpool['sublist'] as $index => $v) {
                    $newsurl = geturl('dyinformation/'.$v['itemid']);?>
                            <div class="newszihe"<?php if ($index++ == $max_index) { echo ' style="border-bottom:0 none;"'; } ?>>
                                <h2 class="hnsies" style="display:block;height:42px;overflow:hidden;"><a href="<?= $newsurl?>" title="<?= $v['subject']?>"  target="_blank"><?= shortstr($v['subject'],78, '')?></a></h2>
                                <?php if(!empty($v['thumb'])) { ?>
                                    <div class="medlef">
                                        <a href="<?= $newsurl?>" target="_blank"><img class="lefsrs" src="<?= !empty($v['thumb']) ? htmlspecialchars($this->show_plate_news_img($v['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg?v=1' ?>"  width="300" height="180"/></a>
                                    </div>
                                <?php } ?>
                                <div<?php if(!empty($v['thumb'])) { ?> class="medrig"<?php } ?>>
                                    <div class="jisrrtse"><?= preg_replace('/<img[^>]*?>/i', '', preg_replace('/style\s*?=.+?[\'|\"]/i', '', $v['note']))?></div>
                                    <p class="zfudete">发表于：<?= date('Y-m-d H:i:s',$v['dateline'])?><span style="margin-left:20px;">阅读 <span style="color:#ffaf28;"><?= $v['viewnum']?></span> 次</span></p>
                                </div>
                            </div>
                        <?php } ?>
                <div style="clear:both;" class="group"><?=!empty($varpool['pagestr']) ? $varpool['pagestr'] : ''?></div>
            </div>
        <?php }
     } ?>

    <?php if (!empty($varpool['list'])) {
        $max_index = count($varpool['list']) - 1;?>
        <div class="navcm-list navcm-mainlist">
            <?php foreach($varpool['list'] as $index => $v) {
                    $newsurl = geturl('dyinformation/'.$v['itemid']);?>
                    <div class="newszihe"<?php if ($index++ == $max_index) { echo ' style="border-bottom:0 none;"'; } ?>>
                            <h2 class="hnsies" style="display:block;height:42px;overflow:hidden;"><a href="<?= $newsurl?>" title="<?= $v['subject']?>"  target="_blank"><?= shortstr($v['subject'],78, '')?></a></h2>
                            <?php if(!empty($v['thumb'])) { ?>
                                <div class="medlef">
                                    <a href="<?= $newsurl?>" target="_blank"><img class="lefsrs" src="<?= !empty($v['thumb']) ? htmlspecialchars($this->show_plate_news_img($v['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg?v=1' ?>"  width="300" height="180"/></a>
                                </div>
                            <?php } ?>
                            <div<?php if(!empty($v['thumb'])) { ?> class="medrig"<?php } ?>>
                                <div class="jisrrtse"><?= preg_replace('/<img[^>]*?>/i', '', preg_replace('/style\s*?=.+?[\'|\"]/i', '', $v['note']))?></div>
                                <p class="zfudete">发表于：<?= date('Y-m-d H:i:s',$v['dateline'])?><span style="margin-left:20px;">阅读 <span style="color:#ffaf28;"><?= $v['viewnum']?></span> 次</span></p>
                            </div>
                        </div>
                <?php } ?>
            <div style="clear:both;" class="group"><?=!empty($varpool['pagestr']) ? $varpool['pagestr'] : '' ?></div>
        </div>
    <?php } ?>

    <?php if (empty($varpool['sublist']) && empty($varpool['list'])) { ?>
        <div style="width:1140px;" class="<?=empty($varpool['subnav']) ? 'navcm-content' : 'navcm-float-content'?>">
            <?php if (!empty($varpool['custommessage'])) {
                echo stripslashes(str_replace('&lt;str&gt;', '', $varpool['custommessage']));
            } else { ?>
                <div class="nodata"></div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
