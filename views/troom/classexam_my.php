<?php $this->display('troom/page_header'); ?>
<style>
.lefrig .annotate a:hover {
	color:#fff;
}
.lefrig a.previewBtn:hover {font-weight:normal;}
</style>

<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classexam') ?>">班级作业</a> > <a href="<?= geturl('troom/classexam/cor') ?>">批改作业</a> > <?= $myclass['classname'] ?>
</div>
<input type="hidden" id="claid" value="{$_SBLOCK['myclass']['classid']}">
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">


<div class="workdata" style="float:left;margin:0;">
<table width="100%" class="datatab" style="border:none;">
		 <tbody>
		 
		 <?php if(!empty($exams)) { ?>
	
			<?php foreach($exams as $exam) { ?>
			  <tr>
				<td>
					<p style="width:768px;float:left;word-wrap: break-word;font-size: 14px;margin-bottom: 10px;font-weight: bold;"><?= shortstr($exam['title'],60) ?></p>
					<div style="float:left;width:520px;">
						<span style="float:left;width:150px;"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></span>
						
						<span style="width:150px;float:left;"><?= $exam['score'] ?>分</span>

						<span style="width:100px;float:left;">答题数 <?= $myclass['stunum'].'/'.$exam['answercount'] ?></span>
					</div>
					<div style="float:left;width:238px;">
						<?php if($exam['uid'] == $uid) { ?>
						<?php if($exam['status'] == 1){?>
							<?php if(in_array($exam['type'],array(2,3))){?>
							<a class="workBtn" href="http://exam.ebanhui.com/smarteedit/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">编辑</a>
							<?php }else{?>
							<a class="workBtn" href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">编辑</a>
							<?php }?>
						<? }?>
						<a class="workBtn" href="javascript:void(0)" onclick="delexam(<?= $exam['eid'] ?>,<?= $roominfo['crid'] ?>)">删除</a>
						<?php } ?>
						<?php if($exam['status'] == 0) { ?>
							<?php if(in_array($exam['type'],array(2,3))){?>
								<a class="previewBtn" href="http://exam.ebanhui.com/smarteedit/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">编辑草稿</a>
							<?php }else{?>
								<a class="previewBtn" href="http://exam.ebanhui.com/eedit/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">编辑草稿</a>
							<?php }?>
						<?php } else { ?>
						<a class="previewBtn" href="<?= geturl('troom/classexam/all-0-0-0-'.$myclass['classid'].'-'.$exam['eid']) ?>" >作业批阅</a>
						<?php } ?>
						<?php if($exam['uid'] == $uid && 0) {//此功能隐藏 ?>
							<a class="previewBtn" href="javascript:void(0)" onclick="changetype(<?= $exam['eid'] ?>)">转成试卷</a>
						<?php }?>
						<a class="previewBtn" href="http://exam.ebanhui.com/outword/<?= $roominfo['crid'] ?>/<?= $exam['eid'] ?>.html" target="_blank">导成Word</a>
					</div>
				</td>	
			  </tr>
			  <?php } ?>

		 <?php } else { ?>
			<tr>
				<td colspan="8" align="center">暂无记录</td>
			</tr>

		 <?php } ?>
		 
		</tbody>
	</table>


	<div style="margin-top:20px;"><?= $pagestr ?></div>
</div>
</div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	var cur_eid = $(".datatab tbody tr:eq(0) td:eq(0)").attr("name");
	var cid = $("#claid").val();
});

function delexam(eid,crid) {
	$.confirm("作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？",function(){
		var url = '<?= geturl('troom/classexam/del') ?>';
		$.ajax({
			url:url,
			type:'post',
			data:{'eid':eid},
			dataType:'text',
			success:function(data){
				if(data==1){
					$.showmessage({
						img		 : 'success',
						message  :  '作业删除成功',
						title    :      '作业删除      成功',
						timeoutspeed    :       500,
						callback :    function(){
							location.reload();
						}
					});
				}else{
					$.showmessage({
						img		 : 'error',
						message  :  '作业删除失败',
						title    :      '作业删除      失败',
						timeoutspeed    :       500
					});
				}
			}
		});
	});
	
}
function changetype(eid){
	$.ajax({
			url:"<?=geturl('troom/classexam/changeType')?>",
			type:'post',
			data:{'eid':eid},
			dataType:'json',
			success:function(res){
				$.showmessage({
					img		 : 'success',
					message  :  res.msg,
					title    :      '操作提示',
					timeoutspeed    :       500,
					callback :    function(){
						location.reload();
					}
				});
			}
		});
}
</script>
<?php $this->display('troom/page_footer'); ?>