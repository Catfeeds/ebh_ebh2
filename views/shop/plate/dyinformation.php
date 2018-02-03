<?php if(!empty($varpool['design'])) { ?>
    <style type="text/css">
        .denser{margin:0 !important;}
    </style>
<?php }?>
<div class="subpage" style="margin:10px auto;">
    <div class="nseeate" style="min-height:800px;_height:800px;">
            <?php
            $mitemlist = $varpool['newlist']['mitemlist'];
                if(!empty($mitemlist)){
                    $max_index = count($mitemlist) - 1;
                    foreach($mitemlist as $index => $v){
                        $newsurl = geturl('dyinformation/'.$v['itemid']);
             ?>
            <div class="newszihe"<?php if ($index == $max_index) { echo ' style="border-bottom:0 none;"'; } ?>>
				<?php if(!empty($v['isinternal'])){?>
				    <div style="position: absolute;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nbinformation.png"></div>
				<?php }?>
					<h2 class="hnsies" style="display:block;height:42px;overflow:hidden;<?=!empty($v['isinternal'])?'padding-left:60px;':''?> "><a href="<?= $newsurl?>" title="<?= $v['subject']?>"  target="_blank"><?= shortstr($v['subject'],78, '')?></a></h2>
                    <?php if(!empty($v['thumb'])) { ?>
                        <div class="medlef">
						<a href="<?= $newsurl?>" target="_blank"><img class="lefsrs" src="<?= !empty($v['thumb']) ? htmlspecialchars($this->show_plate_news_img($v['thumb']), ENT_COMPAT) : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg?v=1' ?>"  width="210" height="126"/></a>
                        </div>
                    <?php } ?>
                    <div<?php if(!empty($v['thumb'])) { ?> class="medrig"<?php } ?>>
                        <div class="jisrrtse"><?= preg_replace('/<img[^>]*?>/i', '', preg_replace('/style\s*?=.+?[\'|\"]/i', '', $v['note']))?></div>
                        <p class="zfudete">发表于：<?= date('Y-m-d H:i:s',$v['dateline'])?><span style="margin-left:20px;">阅读 <span style="color:#ffaf28;"><?= $v['viewnum']?></span> 次</span></p>
                    </div>
            </div>
             <?php
                    } ?>
                    <?=$varpool['newlist']['pagestr']?>
                <?php } else { ?>
                    <div class="nodata"></div>
                <?php }
            ?>


    </div>
</div>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>