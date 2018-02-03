<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
	<div class="ter_tit">
		当前位置 > 我的听课记录 
			<div class="diles">
					<input name="sdate" class="newsou" id="sdate" value="<?= $d ?>" onclick="WdatePicker()"/>
					<input id="searchbutton" type="button" class="soulico" value="">
			</div>
	</div>
	<div class="lefrig" style="margin-top:15px;">
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
	<?php if(!empty($playlogs)) { ?>
		<?php
		$url = 'myroom/mycourse/';
		?>
		<?php foreach($playlogs as $log) { 
		  $arr = explode('.',$log['cwurl']);
		  $type = $arr[count($arr)-1];
		  if($type != 'flv' && $log['ism3u8'] == 1)
			$type = 'flv';
		  if($type == 'mp3')
			$type = 'flv';
		?>
		<tr>
			<td width="30%"><a target="<?= (empty($log['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= geturl($url.$log['cwid'])?>" ><?= $log['title'] ?></a></td>
			<td width="15%"><?= $this->getltimestr($log['ctime'])?></td>
			<td width="15%"><?= $this->getltimestr($log['ltime'])?></td>
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
<script type="text/javascript">

var tip = '请输入课件名称';
$(function(){
	initsearch('txtname',tip);
	$('#searchbutton').click(function(){
		if($("#txtname").val()==tip){
			var searchvalue = '';
		}else{
			var searchvalue = $("#txtname").val();
		}
		if(searchvalue==tip){
			searchvalue='';
		}
		var d = $("#sdate").val();
		location.href = '<?= geturl('myroom/studycalendar/studylog')?>?d='+d;
	});
});

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}

</script>
<?php $this->display('myroom/page_footer'); ?>