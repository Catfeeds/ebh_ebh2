<?php $this->display('troomv2/page_header'); ?>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
.tiezitoolss{ float:right;margin-top:5px;_margin-top:-20px;*margin-top:-30px;}
.tiezitoolss a.excelbtn{
	background: #f57b24;
	height: 24px;
	line-height: 22px;
	width: 82px;
	border: solid 1px #e86b12;
	color: #fff;
	cursor: pointer;
	margin-right: 10px;
	text-align: center;
	text-decoration: none;
	display: block;
}
</style>

	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troomv2/statisticanalysis') ?>">统计分析</a> > <a href="<?= geturl('troomv2/statisticanalysis/scorecount') ?>">成绩统计</a> > <?= $myclass['classname']?>
		<div class="tiezitoolss" >
		<a class="excelbtn" href="/troomv2/statisticanalysis/scexcel.html?eid=<?=$eid?>"> 导出excel</a>
		</div>
	</div>
	<div class="lefrig">
	</div>
	<table class="datatab" width="100%" style="margin:10px 0; margin-top:0">
		<thead class="tabhead">
		<tr>
		<th>作业名称</th>
		<th>出题时间</th>
		<th>题数</th>
		<th>总分</th>
		<th>平均分</th>
		<th>最高分</th>
		<th>最低分</th>
		<th>答题人数</th>
		</tr>
		</thead>
		<tbody>
				<tr>
					<td width="32%" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],35) ?></td>
					<td width="18%"><?= date("Y-m-d H:i",$exam['dateline']) ?></td>
					<td width="8%"><?= $exam['quescount'] ?></td>
					<td width="8%"><?= $exam['score'] ?></td>
					<td width="8%"><?= sprintf("%.2f", $exam['avgscore']) ?></td>
					<td width="8%"><?= $exam['maxscore'] ?></td>
					<td width="8%"><?= $exam['minscore'] ?></td>
					<td width="10%"><?= $myclass['stunum'].'/'.$exam['answercount'] ?></td>
				</tr>
		</tbody>
	</table>
	<table class="datatab" width="100%">
		<thead class="tabhead">
		<tr>
			<th>账号</th>
			<th>姓名</th>
			<th>答题时间</th>
			<th id="sortscore">得分</th>
			<th>操作</th>
		</tr>
		</thead>

		<tbody>
			<?php if(!empty($answers)) { ?>
				<?php foreach($answers as $answer) { ?>
				<tr>
				<?php if(!empty($answer['aid'])) { ?>
					<td width="24%" title="<?= $answer['username'] ?>"><span class="huirenw"><?= $answer['username'] ?></span></td>
					<td width="19%"><?= $answer['realname'] ?></td>
					<td width="19%"><?= date("Y-m-d H:i",$answer['dateline'])?></td>
					<td width="19%"><?= $answer['totalscore'] ?></td>
					<td width="10%">
			
							<?php if(!empty($answer['tid'])) { ?>
							<a class="workBtn" href="http://exam.ebanhui.com/eview/<?= $answer['aid']?>.html" target="_blank">查看</a>
							<?php } else { ?>
						
							<a class="workBtn" href="http://exam.ebanhui.com/etmark/<?= $answer['aid']?>.html" target="_blank">批阅</a>
							<?php } ?>
					
					</td>
					<?php } else { ?>
					<td width="24%" title="<?= $answer['username'] ?>"><span class="huirenw"><?= $answer['username'] ?></span></td>
					<td width="19%"><?= $answer['realname'] ?></td>
					<td width="19%"><font style='color:red;'>未答</font></td>
					<td width="19%"><font style='color:red;'>未答</font></td>
					<td width="10%">
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr><td colspan="6" align="center">暂无记录</td></tr>
			<?php } ?>
		</tbody>
	</table>

<?php $this->display('troomv2/page_footer'); ?>