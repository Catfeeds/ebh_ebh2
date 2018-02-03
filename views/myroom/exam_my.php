<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/exam') ?>">在线作业</a> > 我做过的习题
	</div>
	<div class="lefrig">
<div class="work_menu">
    <ul>
		 <li><a href="<?= geturl('myroom/exam') ?>"><span>所有习题</span></a></li>
         <li class="workcurrent"><a href="<?= geturl('myroom/exam/my') ?>"><span>我做过的习题</span></a></li>
         <li><a href="<?= geturl('myroom/exam/errorbook') ?>"><span>我的错题本</span></a></li>
        
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
						<th>答题时间</th>
                        <th>已答人数</th>
						<th>操作</th>
					  </tr>
			  	</thead>
				<tbody>
				<?php if(!empty($exams)) { ?>
					<?php foreach($exams as $exam) { ?>
						  <tr>
							<td width="20%" style="color:blue;"><?= shortstr($exam['title'],60) ?></td>
							<td width="25%"><?= shortstr($exam['ctitle'],80) ?></td>
							<td width="15%"><?= date('Y-m-d H:i:s',$exam['adateline']) ?></td>
							<td width="5%"><?= $exam['totalscore'] ?></td>
							<td width="10%"><?= date('Y-m-d H:i:s',$exam['dateline']) ?></td>
							<td width="10%"><?= $exam['answercount'] ?></td>
							<td width="15%">
							<?php if($exam['astatus'] == 1) {?>
								<a class="previewBtn" href="http://exam.ebanhui.com/mark/<?= $exam['eid']?>.html" target="_blank"><span>查看结果</span></a>
							<?php } else { ?>
								<a class="previewBtn" href="http://exam.ebanhui.com/do/<?= $exam['eid']?>.html" target="_blank"><span>在线测评</span></a>
							<?php } ?>
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
</body>
</html>