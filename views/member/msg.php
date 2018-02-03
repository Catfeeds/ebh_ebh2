
<?php
$this->display('common/header');
?>
<style>
.datatab td {
	border:none;
	border-top:solid 1px #cdcdcd;
	border-bottom:solid 1px #cdcdcd;
}
</style>
<div class="topbaad">
<div class="user-main clearfix">
		
	<?php
	$this->display('member/left');
	?>
	<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
	<div class="cright_cher">
	<div class="ter_tit" style="position: relative;">
	当前位置 > <a href="<?=geturl('member')?>">个人信息</a> > 站内信息
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">
	<?php
	$this->assign('type','setting');
	$this->display('member/simplate_menu');
	?>

<div class="center">
<div style="float:left;width:786px;">
<table class="datatab" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;width:786px;">
<tbody class="tabhead">
<tr>
<th align="left" width="15%" style="padding-left: 15px">发布者</th>
<th align="left" width="">主题</th>
<th align="center" width="25%">时间</th>
</tr>
</tbody>
<?php
if(!empty($loglist)){
?>
<tbody class="tabcont">

<?php foreach($loglist as $ll){?>
  <tr>
    <td><?=$ll['username']?></td>
    <td><a style="text-decoration:none; color: #666666" title="<?=$ll['message']?>"><?=shortstr($ll['message'],38)?></a></td>
    <td><?=Date('Y-m-d H:i:s',$ll['dateline'])?></td>
  </tr>
  <?php }?>

</tbody>
<?php }else{?>

<tbody class="tabnone">
	<tr>
		<th colspan="3">暂无任何信息</th>
	</tr>
</tbody>
<?php }?>
</table>
</div>

</div>
<div  class="clear"></div>
</div>
</div>
</div>
</div>
<?php
$this->display('common/footer');
?>


