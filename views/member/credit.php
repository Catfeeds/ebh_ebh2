<?php
$this->display('common/header');
?>
<div class="topbaad">
<?php
$this->assign('menuid',3);
$this->display('member/left');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<style>
.tabhead th {
	background:#fff;
}
</style>
<div class="rule">
	<div class="cright_cher">
		<div class="ter_tit" style="position: relative;">
		当前位置 > <a href="<?=geturl('member/score/routinetask')?>">我的积分</a> > 积分明细
		</div>
		<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">
	<?php
	$this->assign('type','score');
	$this->display('member/simplate_menu');
	?>
			<div class="mingxi" style="float:left;width:786px;">
			<table class="datatabs" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
					<tbody class="tabhead">
					<tr>
					<th align="left" width="35%" style="padding-left: 15px;border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">来源/用途</th>
					<th align="left" width="10%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">收入</th>
					<th align="center" width="15%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">支出</th>
					<th align="center" width="25%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">日期</th>
					<th align="center" width="15%"  style="border-bottom: 1px solid #CDCDCD;border-top: 1px solid #CDCDCD;">备注</th>
					</tr>
					</tbody>
					
					<?php
					
					foreach($creditlist as $cl){
					?>
					<tbody class="tabcont">
					
					  <tr >
						<td style="border-bottom: 1px solid #CDCDCD;height: 35px;color:blue;padding-left: 15px;"><?=$cl['username']?></td>
						
						<td style="border-bottom: 1px solid #CDCDCD;height: 35px;color: green;padding-left: 10px;"><?php if($cl['action']=='+'){echo '+'.$cl['credit'];}?></td>
						<td style="border-bottom: 1px solid #CDCDCD;height: 35px;color:red;padding-left: 10px;"><?php if($cl['action']=='-'){echo '-'.$cl['credit'];}?></td>
						<td style="border-bottom: 1px solid #CDCDCD;height: 35px;"><?=Date('Y-m-d H:i:s',$cl['dateline'])?></td>
						<td style="border-bottom: 1px solid #CDCDCD;height: 35px;"><?=$cl['rulename']?></td>
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
</div>
<div style="clear:both;"></div>
<?php
$this->display('common/player');
$this->display('common/footer');
?>