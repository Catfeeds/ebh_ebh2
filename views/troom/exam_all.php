<?php $this->display('troom/page_header'); ?>

<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/exam') ?>">在线作业</a> > 批阅作业</div>
<div class="lefrig">
<div class="workol">

<div class="work_menuss">
	<ul>
		<li><a href="<?= geturl('troom/exam') ?>"><span>录入的作业</span></a></li>
		<li class="workcurrent"><a href="<?= geturl('troom/exam/all') ?>"><span>批阅作业</span></a></li>
	</ul>
</div>
<div class="annotate">
<div class="work_search">
    <form id="searchform" action="<?= geturl('troom/exam/all-0-0-0-'.$menuid)?>" method="get">
	<table>
		<tr>
			<td width="250"><div class="piyue"><a style="font-weight:normal;" <?= $menuid == 0 ? 'class="pcurrent"':''?> href="<?= geturl('troom/exam/all')?>">待批阅</a><span>|</span><a style="font-weight:normal;" <?= $menuid == 1 ? 'class="pcurrent"':''?> href="<?= geturl('troom/exam/all-0-0-0-1') ?>">已批阅</a></div></td>
			<td><label>习题名称</label><input name="q" id="title" value="<?= $q ?>" type="text" /></td>
			<td><label>学生</label><input name="name" id="name" value="<?= $name ?>" type="text" /></td>
			<td><input type="submit" class="souhuang" value="搜 索" /></td>
		</tr>
	</table>
    </form>
</div>
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
			<th>学生名</th>
			<th>操作</th>
		  </tr>
		</thead>
		<tbody>
	
                <?php if(!empty($exams)) { ?>
                 <?php foreach ($exams as $exam) { ?>
		 <tr>
			<td width="120px"><?= shortstr($exam['title'],30)?></td>
			<td width="200px"><?= shortstr($exam['ctitle'],46)?></td>
			<td width="80px"><?= date('Y-m-d H:i:s',$exam['edateline'])?></td>
			<td><?= $exam['score'] ?></td>
			<td width="80px"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
			<td width="60px"><?= empty($exam['realname'])?$exam['username']:$exam['realname'] ?></td>
			<td>
				<a class="workBtn" href="http://exam.ebanhui.com/tmark/<?= $exam['aid']?>.html" target="_blank"><span><?= $menuid == 0 ?'批阅':'查看' ?></span></a>
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
<?php $this->display('troom/page_footer'); ?>