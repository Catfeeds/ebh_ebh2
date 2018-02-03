<?php $this->display('college/page_header'); ?>


	<div class="lefrig" style="background:#fff;float:left;width:1000px;font-family: 微软雅黑;">
<div class="workol" style="margin-top:0px;">
<div class="work_menu" style="width:998px; position:relative;margin-top:0px;">
    <ul>
		 <li><a href="<?= geturl('college/mypaper/all') ?>"><span>考试</span></a></li>
         <li class="workcurrent"><a href="<?= geturl('college/mypaper/my')?>"><span>查看结果</span></a></li>
		 
    </ul>
	<div class="diles" >
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="txtname" <?=$stylestr?> class="newsou" id="txtname" value="<?= $q?>" type="text" />
			<input type="button" onclick="searchs('txtname');return false;" class="soulico" value="">
		</div>
</div>
    <div class="workdata" style="width:1000px;">
         <table width="100%" class="datatab" style="border:none;">
				<thead class="tabhead">
					  <tr>
						<th>试卷名称</th>
						<th>出题教师</th>
						<th>出题时间</th>
						<th>答题时间</th>
						<th>用时</th>
						<th>总分/得分</th>
                        <th>已答人数</th>
						<th>操作</th>
					  </tr>
			  	</thead>
				<tbody>
					
				
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) {?>
						  <tr class="kettshe">
							<td style="width:200px;" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],30) ?></td>
							<td style="width:70px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
							<td style="width:70px;"><?= date('Y-m-d H:i',$exam['dateline']) ?></td>
							<td style="width:70px;"><?= date('Y-m-d H:i',$exam['adateline'])?></td>
							<td style="width:70px;"><?= ceil($exam['completetime']/60)?>分钟</td>
							<td style="width:70px;"><?= $exam['score']?>/<?= round($exam['totalscore'],2) ?></td>
							<td style="width:60px;"><?= $exam['answercount'] ?></td>
							<td style="width:76px;">
							<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
							<?php if($exam['astatus'] == 1) { ?>
								<a class="lviewbtn" href="http://exam.ebanhui.com/emark/<?= $exam['eid'] ?>.html" target="<?= $target?>">查看结果</a>
							<?php } else { ?>
								<a class="previewBtn" href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html" target="<?= $target?>">继续考试</a>
							<?php } ?>

							</td>
						  </tr>
					<?php } ?>
					
				<?php } else { ?>
 					<tr>
						<td colspan="8" class="nonejunrs" align="center"><div class="nodata"></div></td>
					</tr>
				<?php } ?>
			  	</tbody>
		  </table>
		  <?= $pagestr ?>
    </div>
</div>
</div>
<script type="text/javascript">
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { 
					?>
		$(function(){
			if(window.parent != undefined) {
				<?php if(!empty($payitem)) { ?>
					if(window.parent.setiinfo != undefined) {
						window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
					}
				<?php } ?>
				// window.parent.showDivModel(".nelame");
				window.parent.opencountdiv();
			}
		});
		<?php } ?>
$(function(){
		var searchText = "请输入搜索关键字";
		initsearch("txtname",searchText);
});
function searchs(strname){
	var sname = $('#'+strname).val();
	if(sname=='请输入搜索关键字'){
		sname = "";
	}
	
	location.href='<?= geturl('college/mypaper/my')?>?q='+sname;
}
</script>
<?php $this->display('myroom/page_footer'); ?>