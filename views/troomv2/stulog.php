<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troomv2/tastulog') ?>">学生监察</a> > <a href="<?= geturl('troomv2/scalendar-0-0-0-0-0-3') ?>">学习记录</a> > <a href="<?= geturl('troomv2/scalendar/'.$memberid.'-0-0-0-3') ?>"><?= $membername ?>的学习记录</a>
			<div class="diles">
					<input type="hidden" id="uid" name="uid" value="<?=$memberid?>" />
					<input name="begintime" class="newsou" id="stardateline" value="<?= $begintime ?>" onclick="WdatePicker()"/>
					<input onclick="ser()" type="button" class="soulico" value="">
			</div>
</div>
<div class="lefrig" style="margin-top:15px;">
	<div class="ecenter" style="padding:0;">
		<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>课件名称</th>
<th>课件时长</th>
<th>学习持续时间</th>
<th>首次学习时间</th>
<th>末次学习时间</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($logs)) { ?>

		<?php foreach($logs as $log) { ?>
		<tr>
			<td width="30%"><?= $log['title'] ?></td>
			<td width="15%"><?= $this->getltimestr($log['ctime']) ?></td>
			<td width="15%"><?= $this->getltimestr($log['ltime']) ?></td>
			<td width="20%"><?= date('Y-m-d H:i:s',$log['startdate']) ?></td>
			<td width="20%"><?= date('Y-m-d H:i:s',$log['lastdate']) ?></td>
		</tr>
		<?php } ?>

	<?php } else { ?>
		<tr><td colspan="5" align="center">暂无记录</td></tr>
	<?php } ?>

</tbody>
</table>
		
	</div>
	<?= $pagestr ?>
	</div>
<script type="text/javascript">
document.onkeydown=function(event) 
{ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){ 
		$("#ser").click();
		e.returnValue = false;
	} 
}
function ser(){
	var url = '<?= geturl('troomv2/stulog') ?>';
	var uid = $("#uid").val();
	var begintime = $("#stardateline").val();
	var param = 'uid='+uid+'&begintime='+begintime;
        url = url + "?" + param;
	window.location.href=url;
}
</script>

<?php 
$this->display('common/player'); 
$this->display('troomv2/page_footer'); 
?>