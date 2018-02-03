<?php $this->display('college/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<style type="text/css">
    a.btn-base{
        border-radius: 4px;
        color:#fff !important;
        font-size: 14px;
        padding: 6px 16px !important;
        text-decoration: none;
        float:left;
    }
    a.btn-status{
        background-color: #999;
    }
</style>
<div class="busehir">
	<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
		<ul>
			 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span>选课系统</span></a></li>
		</ul>
	</div>
    <?php if(isset($list) === true && is_array($list) === true): ?>
    <table cellspacing="0" cellpadding="0" class="tabless datatab2s">
		<tbody>
			<?php $i = 0;
			foreach ($list as $item): ?>
			<tr>
				<td width="88%" style="<?=$i==0?'border-top:none':''?>">
					<p class="kebitit"><?=htmlspecialchars($item['name'], ENT_NOQUOTES)?></p>
					<p class="nsires" style="width:840px"><?=htmlspecialchars($item['explains'], ENT_NOQUOTES)?></p>
					<p class="nsires" style="color:#999;"><?=date('Y-m-d H:i', $item['datetime'])?>发布 | 活动状态：<span class="chencolor"><?=empty($item['ispause']) || in_array($item['status'], array(3, 5)) ? $this->activityStatus($item) : '选课已暂停'?></span></p>
				</td>
				<td width="12%" style="<?=$i==0?'border-top:none':''?>"><a href="<?php if (empty($item['ispause'])) { ?>/college/xuanke/msgs.html?xkid=<?=$item['xkid']?><?php } else { ?>javascript:;<?php } ?>" class="<?=empty($item['ispause']) ? 'nuifase' : 'btn-base btn-status' ?>">查 看</a></td>
			</tr>
			<?php $i++;
			endforeach; ?>
        </tbody>
    </table>
    <?=$pagestr?>
    <?php else: ?>
        <div class="nodata"></div>
    <?php endif; ?>
</div>

<?php $this->display('myroom/page_footer'); ?>
