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
</style>

<link type="text/css" href="/static/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troomv2/statisticanalysis') ?>">统计分析</a> > 成绩统计
	<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="search" <?=$stylestr?> class="newsou" id="search" value="<?=$q?>" type="text" />
	<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
</div>
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

<div id="icategory" class="clearfix" style="border:none;">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?= empty($classid) ? 'class="curr"':'' ?> href="<?= geturl('troomv2/statisticanalysis/scorecount') ?>">所有学生</a>
			</div>
			
			<?php foreach($classlist as $myclass) { ?>
			<div>
				<a <?= $classid==$myclass['classid']?'class="curr"':'' ?> href="<?= geturl('troomv2/statisticanalysis/scorecount-0-0-0-'.$myclass['classid']) ?>"><?= $myclass['classname'] ?></a>
			</div>
			<?php } ?>
		</div>
	</dd>
</div>

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>作业名称</th>
<th>出题时间</th>
<th>总分</th>
<th>平均分</th>
<th>答题人数</th>
<th>详情</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($exams)) { ?>
		<?php foreach($exams as $exam) { 
		$stunum = 0;
		if($classid > 0 && isset($classlist[$classid]) )  {
			$stunum = $classlist[$classid]['stunum'];
		} else {
			$stunum = isset($classlist[$exam['classid']]) ? $classlist[$exam['classid']]['stunum'] : 0;
		}
		?>
		<tr>
			<td width="40%" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],44) ?></td>
			<td width="20%"><?= date("Y-m-d H:i",$exam['dateline']) ?></td>
			<td width="10%"><?= $exam['score'] ?></td>
			<td width="10%"><?= sprintf("%.2f", $exam['avgscore']) ?></td>
			<td width="10%"><?= $stunum.'/'.$exam['answercount'] ?></td>
			<td width="10%">
				<?php if($classid > 0) { ?>
				<a class="previewBtn" title="查看详情" href="<?= geturl('troomv2/statisticanalysis/scorecount/'.$exam['eid'].'----'.$classid) ?>"><span>查看详情</span></a>
				<?php } else { ?>
				<a class="previewBtn" title="查看详情" href="<?= geturl('troomv2/statisticanalysis/scorecount/'.$exam['eid']) ?>"><span>查看详情</span></a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>

	<?php } else { ?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php } ?>

</tbody>
</table>
</div>
<?= $pagestr ?>
<script type="text/javascript">
var tip = '请输入作业名称';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		if($("#search").val()=='请输入作业名称'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入作业名称'){
			searchvalue='';
		}
		var href = '<?= geturl('troomv2/statisticanalysis/scorecount-0-0-0-'.$classid)?>?q='+searchvalue;
		
		location.href = href ;
	});

});
</script>

<?php $this->display('troomv2/page_footer'); ?>