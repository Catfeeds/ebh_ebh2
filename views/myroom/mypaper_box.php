<?php $this->display('myroom/page_header'); ?>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/mypaper') ?>">我的试卷</a> > 草稿箱
	</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<div class="workol">
<div class="work_menu">
    <ul>
		 <li><a href="<?= geturl('myroom/mypaper/all') ?>"><span>待做试卷</span></a></li>
         <li><a href="<?= geturl('myroom/mypaper/my') ?>"><span>我做过的试卷</span></a></li>
		 <li class="workcurrent"><a href="<?= geturl('myroom/mypaper/box') ?>"><span>草稿箱</span></a></li>
    </ul>
</div>

    <div class="workdata">
         <table width="100%" class="datatab" style="border:none;">
				<thead class="tabhead">
					  <tr>
						<th>试卷名称</th>
						<th>出题教师</th>
						<th>出题时间</th>
						<th>总分/得分</th>
						<th>答题时间</th>
                        <th>已答人数</th>
						<th>操作</th>
					  </tr>
			  	</thead>
				<tbody>
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
						  <tr>
							<td style="width:240px;" title="<?= $exam['title']?>"><span style="width:200px;word-wrap: break-word;float:left;"><?= shortstr($exam['title'],30)?></span></td>
							<td style="width:60px;"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
							<td style="width:100px;"><?= date('Y-m-d H:i',$exam['dateline'])?></td>
							<td style="width:60px;"><?= $exam['score'] ?>/<?= round($exam['totalscore'],2)?></td>
							<td style="width:100px;"><?= date('Y-m-d H:i',$exam['adateline'])?></td>
							<td style="width:60px;"><?= $exam['answercount'] ?></td>
							<td style="width:76px;">
							<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'; ?>
								<a class="previewBtn" href="http://exam.ebanhui.com/edo/<?= $exam['eid'] ?>.html" target="<?= $target ?>">继续考试</a>
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
				<? } ?>
				window.parent.showDivModel(".nelame");
			}
		});
		<?php } ?>
</script>
<?php $this->display('myroom/page_footer'); ?>