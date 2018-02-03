<?php $this->display('homev2/header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<?php $this->display('homev2/top'); ?>
<div class="divcontent">
	<div class="conentlft">
<div class="topbaad">
	<div class="rule">
			<div class="lefrig" style="background:#fff;margin-top:10px;float:left;">
				<div class="work_menu" style="width:786px; position:relative;margin-top:0px;margin-bottom:10px;">
					<ul>
						 <li><a href="/homev2/score/routinetask.html" style="font-size:16px;"><span>常规任务</span></a></li>
						 <li class="workcurrent"><a href="/homev2/score/credit.html" style="font-size:16px;"><span>积分明细</span></a></li>
						 <li><a href="/homev2/score/record.html" style="font-size:16px;"><span>兑换记录</span></a></li>
						<li><a href="/homev2/score/description.html" style="font-size:16px;"><span>积分说明</span></a></li>
						<!-- <li><a href="/homev2/score/lottery.html" style="font-size:16px;"><span>积分兑换</span></a></li> -->
					</ul>
				</div>
			<div style="float:left;width:786px;">
			<table class="datatabs" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody class="tabhead">
					<tr>
					<th align="center" width="30%">日期</th>
					<th align="left" width="25%" >积分</th>
					<th align="center" width="45%">积分说明</th>
					
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
</div>
<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>
</div>
<script type="text/javascript">
$(function(){
		$('.datatabs tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('homev2/footer');?>