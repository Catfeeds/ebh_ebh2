<?php
/**
 * 自选课程面板
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/26
 * Time: 10:12
 */
?>
<dl class="manual-panel group">
    <dt>
        <?php foreach ($classrooms as $scrid => $classroom) { ?>
            <span crid="<?=$scrid?>"<?php if ($scrid == $crid){ ?> class="cur"<?php } ?>><?=$classroom['name']?></span>
        <?php } ?>
    </dt>
    <dd>
        <ul class="group menu packages">
            <li class="a package-btn" pid="0" crid="<?=$crid?>">全部</li>
            <?php foreach ($packages as $pid => $package) { ?>
                <li class="item package-btn <?=!empty($package['cur']) ? 'cur' : ''?>" crid="<?=$package['crid']?>" pid="<?=$pid?>"<?php if ($crid != $package['crid']) { ?> style="display:none;"<?php } ?>><?=$package['pname']?></li>
            <?php } ?>
        </ul>
        <ul class="group menu sorts">
            <li class="a sort-btn" sid="0" pid="<?=$firstPid?>">全部</li>
            <?php foreach ($sorts as $sid => $sort) { ?>
                <li class="item sort-btn <?=!empty($sort['cur']) ? 'cur' : ''?>" crid="<?=$sort['crid']?>" pid="<?=$sort['pid']?>" sid="<?=$sid?>"<?php if (empty($sort['show'])) { ?> style="display:none;"<?php } ?>><?=$sort['sname']?></li>
            <?php } ?>
        </ul>
        <ul class="group course-items">
            <?php foreach ($datas as $data) { ?>
                <li title="<?=$data['foldername']?>" sta="<?=intval($data['ati'])?>" ati="<?=intval($data['ati'])?>" crid="<?=$data['sourcecrid']?>" pid="<?=$data['pid']?>" sid="<?=$data['pid'].'-'.$data['sid']?>" itemid="<?=$data['itemid']?>" fid="<?=$data['folderid']?>"<?php if(empty($data['show'])) { ?> style="display:none;"<?php } ?>>
                    <img class="manual-cover" width="147" height="86" src="<?=$data['img']?>" />
                    <div><?=shortstr($data['foldername'], 16)?></div>
                    <img<?php if(empty($data['ati'])) { ?> style="display:none"<?php } ?> class="manual-icon" width="20" height="20" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/selectedico.png"/>
                </li>
            <?php } ?>
            <?php foreach ($others as $other) { ?>
                <li title="<?=$other['foldername']?>" sta="<?=intval($other['ati'])?>" ati="<?=intval($other['ati'])?>" crid="<?=$other['sourcecrid']?>" pid="<?=$other['pid']?>" sid="<?=$other['pid'].'-'.$other['sid']?>" itemid="<?=$other['itemid']?>" fid="<?=$other['folderid']?>" style="display:none">
                    <img class="manual-cover" width="147" height="86" src="<?=$other['img']?>" />
                    <div><?=shortstr($other['foldername'], 16)?></div>
                    <img<?php if(empty($other['ati'])) { ?> style="display:none"<?php } ?> class="manual-icon" width="20" height="20" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/selectedico.png"/>
                </li>
            <?php } ?>
        </ul>
    </dd>
</dl>
<?php return;?>
<dl class="manual-panel group" style="display:none;">
    <dt pid="0">全部</dt>
    <?php if (!empty($data)) { ?>
        <?php foreach ($data as $pid => $dt) { ?>
            <dt pid="<?=$pid?>" title="<?=$dt['pname']?>"><?=shortstr($dt['pname'], 20)?></dt>
        <?php } ?>
        <dd></dd>
    <dd><ul class="group">
        <?php foreach ($data as $pid => $dd) { ?>
            <?php foreach ($dd['children'] as $item) {
                $showimg = $item['img'];
                if (empty($showimg)) {
                    $showimg = $this->course_viewholder;
                }
                $img = show_plate_course_cover($showimg);
                $img = show_thumb($img);
                ?>
                <li sta="<?=intval($item['choosed'])?>" ati="<?=intval($item['choosed'])?>"<?php if($pid != 379){ ?> style="display:none;"<?php }?> pid="<?=$pid?>" itemid="<?=$item['itemid']?>"><img<?php if(empty($item['choosed'])){ ?> style="display:none;"<?php }?> class="m-sign" width="20" height="20" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/selectedico.png" /><img class="m-cover" src="<?=$img?>" width="147" height="86" /><div title="<?=$item['foldername']?>"><?=shortstr($item['foldername'], 16)?></div></li>
            <?php }
         } ?>
        </ul></dd>
    <?php } ?>
</dl>
