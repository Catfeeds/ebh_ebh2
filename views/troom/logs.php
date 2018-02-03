<?php $this->display('troom/page_header');?>
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

	<div class="ter_tit">
		当前位置 >  <a href="<?= geturl('troom/statisticanalysis') ?>">统计分析</a> > 学习记录汇总
		<div class="diles">
				<?php
					$q= empty($q)?'':$q;
					if(!empty($q)){
						$stylestr = 'style="color:#000"';
					}else{
						$stylestr = "";
					}
				?>
			<input name="search" <?=$stylestr?> class="newsou" id="search" value="<?= $q ?>" type="text" />
			<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
		</div>
	</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
		<div id="icategory" class="clearfix" style="border:none;">
			<dt>所属班级：</dt>
			<dd>
				<div class="category_cont1">
					<div>
						<a <?= empty($classid)?'class="curr"':'' ?> href="<?= geturl('troom/statisticanalysis/logs') ?>">所有学生</a>
					</div>
					
					<?php foreach($classlist as $myclass) { ?>
					<div>
						<a <?= $classid==$myclass['classid']?'class="curr"':''?> href="<?= geturl('troom/statisticanalysis/logs-0-0-0-'.$myclass['classid']) ?>"><?= $myclass['classname'] ?></a>
					</div>
					<?php } ?>

				</div>
			</dd>
		</div>
		

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>课件名称</th>
<th>学生姓名</th>
<th>课件时长</th>
<th>学习持续时间</th>
<th>首次学习时间</th>
<th>末次学习时间</th>
</tr>
</thead>
<tbody>
	
	<?php if(!empty($logs)) { ?>
		
		<?php foreach($logs as $mylog) { ?>
		<tr>
			<td width="28%"><?= $mylog['title'] ?></td>
			<td width="10%"><?= empty($mylog['realname'])?$mylog['username']:$mylog['realname'] ?></td>
			<td width="10%"><?= $this->getltimestr($mylog['ctime']) ?></td>
			<td width="12%"><?= $this->getltimestr($mylog['ltime']) ?></td>
			<td width="20%"><?= date('Y-m-d H:i:s',$mylog['startdate']) ?></td>
			<td width="20%"><?= date('Y-m-d H:i:s',$mylog['lastdate']) ?></td>
		</tr>
		<?php } ?>
		
	<?php } else { ?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php } ?>
</tbody>
</table>
</div>
<?=$pagestr?>
</body>
</html>
<script type="text/javascript">
var tip='请输入课件名称';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troom/statisticanalysis/logs-0-0-0-'.$classid) ?>';
		if($("#search").val()=='请输入课件名称'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入课件名称'){
			searchvalue='';
		}

		location.href = href+"?q="+searchvalue;
	});

});

</script>
