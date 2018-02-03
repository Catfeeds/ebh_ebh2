<?php $this->display('college/page_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<style>
.work_menu ul li a {
    color: #666;
    font-family: 微软雅黑;
    font-size: 16px;
}
.workcurrent a span {
    color: #4c88ff !important;
}
</style>
<body>
<div class="allcou">
	<?php $this->assign('index',3);
	$this->display('college/activity_menu');?>
    <div class="match matchs">
    	<div style="width:940px;">
		<?php if(!empty($creditlist)){?>
			<table class="datatabss" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th width="35%">时间</th>
					<th width="20%">积分</th>
					<th width="45%">说明</th>
				</tr>
				<?php
					
				foreach($creditlist as $cl){
					$description = str_replace('[w]','<span style="color:blue">'.$cl['detail'].'</span>',$cl['description']);
					?>
				<tr>
					<td style="height: 35px;"><?=Date('Y-m-d H:i:s',$cl['dateline'])?></td>
					
					<td style="height: 35px;color: <?=$cl['action']=='+'?'green':'red'?>;padding-left: 10px;">
						<?=$cl['action'].$cl['credit']?>
					</td>
					<td style="height: 35px;"><?=$description.' '.$cl['credit'].' 积分'?></td>
				</tr>
				<?php }?>
			</table>
			<?=$pagestr?>
		<?php }else{?>
		
		<div class="nodata"></div>
		
		<?php }?>
		</div>
    </div>
</div>
</body>
</html>
