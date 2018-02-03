<?php $this->display('home/page_header'); ?>
<div class="topbaad">
<?php
$this->assign('menuid',3);
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<style>
.datatabs td {
    border-bottom: 1px solid #efefef;
    border-top: 1px solid #efefef;
    color: #666666;
    padding: 10px 6px;
}
</style>
<div class="rule">
		<div class="lefrig" style="background:#fff;margin-top:15px;float:left;">
	<?php
	$this->assign('type','score');
	$this->display('home/simplate_menu');
	?>
			<div style="float:left;width:786px;">
			<table class="datatabs" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody class="tabhead">
					<tr>
					<th align="center" width="20%">日期</th>
					<th align="left" width="15%" >积分</th>
					<th align="center" width="65%">积分说明</th>
					
					</tr>
					</tbody>
					
					<?php
					foreach($creditlist as $cl){
					$description = str_replace('[w]','<span style="color:blue">'.$cl['detail'].'</span>',$cl['description']);
						if(strpos($cl['detail'],'售')){
							$cl['action'] = '+';
						}
					?>
					<?php if($cl['type'] != 6){ ?>
						<tbody class="tabcont">
						
						  <tr >
							<td style="height: 35px;"><?=Date('Y-m-d H:i:s',$cl['dateline'])?></td>
							<?php if($cl['action']=='+'){?>
									<td style="height: 35px;color: green;padding-left: 10px;">
									+<?=$cl['credit']?>
									</td>
							<?php }else{?>
									<td style="height: 35px;color: red;padding-left: 10px;">
									-<?=$cl['credit']?>
									</td>
							<?php }?>
							<td style="height: 35px;"><?=$description.' '.$cl['credit'].' 积分'?></td>
						  </tr>
						</tbody>
					<?php }else{?>
						<tbody class="tabcont">
						
						  <tr >
							<td style="height: 35px;"><?=Date('Y-m-d H:i:s',$cl['dateline'])?></td>
							<?php if($cl['action']=='+'){?>
									<td style="height: 35px;color: green;padding-left: 10px;">
									+<?=$cl['credit']?>
									</td>
							<?php }else{?>
									<td style="height: 35px;color: red;padding-left: 10px;">
									-<?=$cl['credit']?>
									</td>
							<?php }?>
							<td style="height: 35px;"><?=$cl['detail']?></td>
						  </tr>
						</tbody>
					<?php } ?>
					<?php
					}
					?>
					
					
					</table>
					<?php
					echo show_page($creditcount,$pagesize);
					?>
			</div>
		</div>
	</div>
</div>
<div style="clear:both;"></div>