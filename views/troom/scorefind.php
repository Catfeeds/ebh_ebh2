<?php $this->display('troom/page_header'); ?>
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
		当前位置 > <a href="<?= geturl('troom/statisticanalysis') ?>">统计分析</a> > <a href="<?= geturl('troom/tastulog') ?>">学生监察</a> > 作业记录 > <?= $membername?>
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

		<div class="weaktil" style=" margin-bottom:10px;">
			<ul >
				<?php $uid=$this->uri->itemid; ?>
				<li ><a href="<?= geturl('troom/statisticanalysis/scorefind/'.$uid) ?>"><span class="datek" >作业记录</span></a></li>
				<li ><a href="<?= geturl('troom/statisticanalysis/question/'.$uid) ?>"><span>答疑记录</span></a></li>
				<li ><a href="<?= geturl('troom/statisticanalysis/studylogs/'.$uid) ?>"><span>学习记录</span></a></li>
				<li ><a href="<?= geturl('troom/statisticanalysis/errorlogs/'.$uid) ?>"><span>错题集</span></a></li>
			</ul>
		</div>

<table class="datatab" width="100%" style="border:none;">
	<?php if(!empty($exams)) { ?>
<thead class="tabhead">
<tr>
<th>作业名称</th>
<th>出题时间</th>
<th>答题时间</th>
<th>用时</th>
<th>总分/得分</th>
<th>答题人数</th>
<th>详情</th>
</tr>
</thead>
<tbody>
		<?php foreach($exams as $exam) { 
		$stunum = 0;
		if($classid > 0 && isset($classlist[$classid]) )  {
			$stunum = $classlist[$classid]['stunum'];
		} else {
			$stunum = isset($classlist[$exam['classid']]) ? $classlist[$exam['classid']]['stunum'] : 0;
		}
		?>
		<tr>
			<td width="20%" title="<?= $exam['title'] ?>"><?= shortstr($exam['title'],44) ?></td>
			<td width="20%"><?= date("Y-m-d H:i",$exam['dateline']) ?></td>
			<td width="20%"><?= date("Y-m-d H:i",$exam['sdateline']) ?></td>
			<td width="10%"><?= ceil($exam['completetime']/60)?>分钟</td>
			<td width="10%"><?= $exam['score'] ?>/<?= sprintf("%.2f", $exam['totalscore']) ?></td>
			<td width="10%"><?= $stunum.'/'.$exam['answercount'] ?></td>
			<td width="10%">
				<a class="previewBtn" title="查看结果" target="_blank;" href="http://exam.ebanhui.com/eview/<?= $exam['aid']?>.html"><span>查看结果</span></a>
			</td>
		</tr>
		<?php } ?>

	<?php } else { ?>
		<tr><div style="clear:both;padding-top:10px;text-align: center;">暂无作业记录</div></tr>
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
		var href = '<?= geturl('troom/statisticanalysis/scorefind/'.$uid)?>?q='+searchvalue;
		location.href = href ;
	});

});
</script>

<?php $this->display('troom/page_footer'); ?>