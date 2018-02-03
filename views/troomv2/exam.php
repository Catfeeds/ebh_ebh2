<?php $this->display('troomv2/page_header'); ?>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troomv2/exam') ?>">在线作业</a> > 录入作业
</div>
<div class="lefrig">
<div class="workol">
<div class="work_menuss">
	<ul>
		<li class="workcurrent"><a href="<?= geturl('troomv2/exam') ?>"><span>录入的作业</span></a></li>
		<li><a href="<?= geturl('troomv2/exam/all') ?>"><span>批阅作业</span></a></li>
	</ul>
</div>

<div class="workdata">
	<table width="100%" class="datatab">
		<thead class="tabhead">
		  <tr>
			<th>作业名称</th>
			<th>所属课件</th>
			<th>出题时间</th>
			<th>总分</th>
			<th>已答人数</th>
			<th>操作</th>
		  </tr>
		</thead>
		 <tbody>
		 
                 <?php if(!empty($exams)) { ?>
                        <?php foreach($exams as $exam) { ?>
			  <tr>
				<td width="20%"><?= shortstr($exam['title'],60) ?></td>
				<td width="30%"><?= shortstr($exam['ctitle'],80) ?></td>
				<td width="12%"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></td>
				<td width="5%"><?= $exam['score'] ?></td>
				<td width="8%"><?= $exam['answercount'] ?></td>
				<td width="15%">
					<a class="workBtn" href="http://exam.ebanhui.com/edit/<?= $exam['eid'] ?>.html" target="_blank"><span>编辑</span></a>
					<a class="btnshan" href="javascript:void(0)" onclick="delexam(<?= $exam['eid'] ?>,'<?= str_replace('\'','',$exam['title']) ?>',<?= $exam['cwid'] ?>)"><span>删除</span></a>
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
	<div style="margin-top:20px;"></div>
</div>
</div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
function delexam(eid,title,cwid) {
    var url = "<?= geturl('troomv2/exam/del') ?>";
	$.confirm("确认删除作业 [" + title + "] 吗？",function(){
		$.ajax({
			url:"<?= geturl('troomv2/exam/del') ?>",
			type:'post',
			data:{'eid':eid,'cwid':cwid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({
						img		 : 'success',
						message  :  '作业删除成功',
						title    :      '作业删除      成功',
						timeoutspeed    :       500,
						callback :    function(){
							location.href='<?= geturl('troomv2/exam') ?>';
							//location.reload();
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
</script>
<?php $this->display('troomv2/page_footer'); ?>