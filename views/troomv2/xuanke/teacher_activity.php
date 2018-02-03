<?php $this->display('aroomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
<div class="lefrig lefrig1s">
	<div class="work_menu" style="position:relative;margin-top:0">
		<ul>
			<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
		</ul>
	</div>
    <?php if(isset($list) === true && is_array($list) === true): ?>
    <table class="xuklist tables" cellspacing="0" cellpadding="0">
        <tbody>
        <?php foreach ($list as $index => $item): ?>
        <tr<?php if($index > 0): ?> class="last"<?php endif; ?>>
            <td width="828"<?php if($index == 0):?> style="border-top:none;"<?php endif; ?>>
                <p class="kebitit" style="margin-left:10px;"><?=htmlspecialchars($item['name'], ENT_NOQUOTES)?></p>
                <p class="nsires1s" style="width:800px;"><?=htmlspecialchars($item['explains'], ENT_NOQUOTES)?></p>
                <p class="fbsjzt">
                    <?=date('Y-m-d H:i', $item['datetime'])?>&nbsp;发布&nbsp;&nbsp;|&nbsp;&nbsp;活动状态：
                    <span style="color:#ffaf28;"><?=empty($item['ispause']) || in_array($item['status'], array(3, 5)) ? $this->activityStatus($item) : '选课已暂停'?></span>
                </p>
            </td>
            <td width="148"<?php if($index == 0): ?> style="border-top:none;"<?php endif; ?>><a class="nuifase" href="/troomv2/xuanke/msglist.html?aid=<?=$item['xkid']?>" style="margin-left:45px;">查 看</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?=$pagestr?>
    <?php else: ?>
        <div style="text-align:center;" class="nodata"></div>
    <?php endif; ?>
</div>
<script type="text/javascript">
 $(function(){
	 $(".xuklist td:first").css("border-top","none");
 })
</script>
<?php $this->display('aroomv2/page_footer'); ?>