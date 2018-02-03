<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/tastulog') ?>">学生监察</a> > <a href="<?= geturl('troom/scalendar-0-0-0-0-0-2') ?>">学生作业</a> > <a href="<?= geturl('troom/scalendar/'.$memberid.'-0-0-0-2') ?>"><?= $membername ?>的作业记录</a>
<div class="diles">
					<input type="hidden" id="uid" name="uid" value="<?=$memberid?>" />
					<input name="begintime" class="newsou" id="stardateline" value="<?= $begintime ?>" onclick="WdatePicker()"/>
					<input onclick="ser()" type="button" class="soulico" value="">
			</div>
</div>
<div class="lefrig" style="margin-top:15px;">
	<div class="ecenter" style="padding:0;">
		<table width="100%" class="datatab">
			<thead class="tabhead">
			  <tr>
				<th>序号</th>
				<th>作业名称</th>
				<th>答题时间</th>
				<th>得分</th>
				<th>操作</th>
			  </tr>
			 </thead>
			 
			 <tbody>
			
                         <?php if(empty($exams)) { ?>
			 	<tr><td colspan="5" align="center">目前没有答题记录</td></tr>
	
                         <?php } else { ?>
	
                                 <?php foreach($exams as $key=>$exam) { ?>
				 	<tr>
				  	<td><?= $key + 1 ?></td>
				  	<td style="color: #3366cc;"><?= $exam['title'] ?></td>
					<td style="color: #3366cc;"><?= date('Y-m-d H:i:s',$exam['adateline'])?></td>
					<td><?= $exam['totalscore'] ?></td>
					<td><a class="previewBtn" href="http://exam.ebanhui.com/eview/<?= $exam['aid'] ?>.html" target="_blank">查看结果</a></td>
				  </tr>

                                 <?php } ?>
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
	var url = '<?= geturl('troom/myexam') ?>';
  	var uid = $("#uid").val();
	var begintime = $("#stardateline").val();
	var param = 'uid='+uid+'&begintime='+begintime;
        url = url + "?" + param;
	window.location.href=url;
}
</script>

<?php 
$this->display('common/player'); 
$this->display('troom/page_footer'); 
?>