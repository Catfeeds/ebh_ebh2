<?php $this->display('myroom/page_header'); ?>
<div class="topbaad">
<div class="user-main clearfix">

	<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
	<div class="ter_tit" style="position: relative;">
	当前位置 > 个人信息 > 站内信息
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;">
	<?php
	$this->assign('type','setting');
	$this->display('member/simplate_menu');
	?>

<div class="center" style="padding:0;">

<table class="datatab" style="border:none;float:left;" width="100%" border="0" cellspacing="0" cellpadding="0">
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
<div  class="clear"></div>
</div>
</div>
</div>
<?php
$this->display('common/footer');
?>


