<?php $this->display('myroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">
<div class="busehir">
    <div class="cmain_bottom ">
        <div class="study_top" style="background:#fff;">
            <div class="fl">
                <h3>学习</h3>
            </div>
        </div>
    </div>
    <?php if(isset($list) === true && is_array($list) === true): ?>
    <table cellspacing="0" cellpadding="0" class="tabless datatab2s">
        <tbody>
        <?php foreach ($list as $item): ?>
        <tr>
            <td width="88%">
                <p class="kebitit"><?=htmlspecialchars($item['name'], ENT_NOQUOTES)?></p>
                <p class="nsires" style="width:840px"><?=htmlspecialchars($item['explains'], ENT_NOQUOTES)?></p>
                <p class="nsires" style="color:#999;"><?=date('Y-m-d H:i', $item['datetime'])?>发布 | 活动状态：<span class="chencolor"><?=$this->activityStatus($item)?></span></p>
            </td>
            <td width="12%"><a href="/myroom/xuanke/msgs.html?xkid=<?=$item['xkid']?>" class="nuifase">查 看</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?=$pagestr?>
    <?php else: ?>
        <div style="text-align:center;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu3.png" /></div>
    <?php endif; ?>
</div>

<?php $this->display('myroom/page_footer'); ?>
