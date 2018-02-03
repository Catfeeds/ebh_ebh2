<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topbaad">

<style>
.datatabs td {
    border-bottom: 1px solid #e3e3e3;
    border-top: 1px solid #cdcdcd;
    color: #666666;
    padding: 10px 6px;
}
</style>
<div class="rule">
		
		<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;float:left;">
	
			<div style="float:left;width:998px;">
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
					?>
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
</body>
</html>