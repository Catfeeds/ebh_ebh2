<?php $this->display('troom/page_header'); ?>

	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classpaper') ?>">在线考试</a> > 批改试卷
		</div>
	<div class="lefrig" style="margin-top:15px;">

<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>班级名称</th>
<th>人数</th>
<th>试卷数</th>
<th>试题数</th>
<th>最近试卷</th>
<th></th>
</tr>
</thead>
<tbody>

        <?php if(!empty($cexams)) { ?>
	
                <?php 
                    $classsum = count($cexams);
                    $stunumsum = 0;
                    $examcountsum = 0;
                    $quescountsum = 0;
                    foreach($cexams as $cexam) { 
                        $stunumsum += $cexam['stunum'];
                        $examcountsum += $cexam['examscount'];
                        $quescountsum += $cexam['quescount'];
                        ?>
		<tr>
			<td width="20%"><?= $cexam['classname'] ?></td>
			<td width="15%"><?= $cexam['stunum'] ?></td>
			<td width="15%"><?= $cexam['examscount'] ?></td>
			<td width="15%"><?= $cexam['quescount'] ?></td>
			<td width="20%"><?= !empty($cexam['lastexamdate']) ? date('Y-m-d H:i:s',$cexam['lastexamdate']) : ''?></td>
			<td width="20%"><a href="<?= geturl('troom/classpaper/my-0-0-0-'.$cexam['classid']) ?>" class="previewBtn" title="班级试卷">班级试卷</a></td>
		</tr>
                <?php } ?>

		<tr>
			<td width="25%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?= $classsum?></span>&nbsp;班</td>
			<td width="15%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?= $stunumsum ?></span>&nbsp;人</td>
			<td width="15%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?= $examcountsum ?></span>&nbsp;</td>
			<td width="15%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?= $quescountsum ?></span>&nbsp;</td>
			<td width="20%"></td>
			<td width="10%"></td>
		</tr>

        <?php } else { ?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
        <?php } ?>

</tbody>
</table>
</div>
<?php $this->display('troom/page_footer'); ?>