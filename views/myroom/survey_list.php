<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<div class="ter_tit">
	当前位置 > 调查问卷
	<div class="diles">
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
<div class="lefrig" style="margin-top:15px;">

	<table class="datatab" width="100%">
		<thead class="tabhead">
			<tr>
			<th>名称</th>
			<th>关联课件</th>
			<th>开放时间</th>
			<th>操作</th>
			</tr>
		</thead>
		<tbody>
<?php
if(!empty($surveylist)){
	foreach($surveylist as $survey){?>
			<tr>
				<td width="245" style="word-break: break-all; word-wrap:break-word;"><?php if(empty($survey['aid'])){?><a href="/myroom/survey/fill/<?=$survey['sid']?>.html" style="color:#666;"><?php }else{?><a href="/myroom/survey/answer/<?=$survey['sid']?>.html" style="color:#666;"><?php }?><?=strip_tags($survey['title'])?></a></td>
				<td width="245"><?=$survey['cwname']?></td>
				<td width="124"><?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至<br />'.date('Y-m-d',$survey['enddate'])?></td>
				<td width="124"><?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?><a class="liuibtn" style="width:60px;" href="/myroom/survey/fill/<?=$survey['sid']?>.html">参与调查</a><?php }else{?><a class="liuibtn" style="width:60px;" href="/myroom/survey/answer/<?=$survey['sid']?>.html">查看详情</a><?php }?>
				<?php if (!empty($survey['allowview'])) {?><a class="liuibtn" href="/myroom/survey/stat/<?=$survey['sid']?>.html">统计</a><?php }?></td>
			</tr>
<?php
	}
} else {?>
			<tr>
				<td colspan="4" align="center" style="border-top:none;">暂无记录</td>
			</tr>
<?php }?>
		</tbody>
	</table>

<?=$pagestr?>
</div>
<script type="text/javascript">
function searchs(strname){
	var sname = $('#'+strname).val();
	if(sname=='请输入搜索关键字'){
		sname = "";
	}
	location.href='<?= geturl('myroom/survey/surveylist')?>?q='+sname;
}
$(function(){
	var searchText = "请输入搜索关键字";
	initsearch("txtname",searchText);
});
</script>
<?php $this->display('myroom/page_footer'); ?>