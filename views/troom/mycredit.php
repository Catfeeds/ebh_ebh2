<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<div class="ter_tit">
	当前位置 > 学分统计
	<div class="diles">
	<?php
		$title= empty($title)?'':$title;
		if(!empty($title)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=$title?>" type="text" />
	<input type="button" class="soulico" value="" onclick="searchs();return false;">
</div>
</div>
<div class="lefrig">
	<div class="annuato" style="line-height:28px;padding-left:20px;border:solid 1px #cdcdcd;background:#fff;position: relative;text-align:center;">达标学分&nbsp;<span style="color:blue;font-weight:bold;"><?=$stuOkScore?></span>&nbsp;分，您已获取&nbsp;<span style="color:blue;font-weight:bold;"><?=$totalScore?></span>&nbsp;分，&nbsp;<span style="color:red;font-weight:bold;"><?=($totalScore>=$stuOkScore)?'恭喜您获取所有学分！':'请再接再厉！'?></span>&nbsp;</div>

	<div class="workol">

		    <div class="workdata" style="width:788px;">
		    	<table width="100%" class="datatab">
					<thead class="tabhead">
						<tr>
							<th>课件名称</th>
							<th>所属课程</th>
							<th>获取</th>
							<th>获取时间</th>
							<!-- <th>操作</th> -->
						</tr>
					</thead>
					 <tbody>

					 <?php if(!empty($creditlogList)) { ?>
						 <?php foreach($creditlogList as $creditlog) { ?>
						 <?php $creditlog['title'] = empty($creditlog['title'])?'课件已删除':$creditlog['title']?>
						 <?php $creditlog['foldername'] = empty($creditlog['foldername'])?'课程已删除':$creditlog['foldername']?>
						  <tr>
							<td style="width:40%" title="<?= $creditlog['title'] ?>"><?= shortstr($creditlog['title'],50) ?></td>
							<td style="width:20%;"><?= shortstr($creditlog['foldername'],50) ?></td>
							<td style="width:15%;"><?= $creditlog['score'] ?>分</td>
							<td style="width:25%"><?= date('Y-m-d H:i:s',$creditlog['dateline']) ?></td>
							<!-- <td style="width:60px;"><a class="lviewbtn" href="http://exam.ebanhui.com/emark/<?= $creditlog['eid']?>.html" target="_blank">查看作业</a></td> -->
						  </tr>
						 <?php } ?>
						 
					 <?php } else { ?>
							 <tr>
					 		<td colspan="6" align="center">暂无记录</td>
					 	</tr>
					 <?php } ?>
						</tbody>
					</table>
					<?= $pageStr ?>
		    </div>
	</div>
</div>
<script>
	$(function(){
		var searchText = "请输入搜索关键字";
		initsearch("title",searchText);
	});
	function searchs(){
		var title = $.trim($("#title").val());
		if(title == '请输入搜索关键字'){
			title = "";
		}
		var foldername = $.trim($("#foldername").val());
		var url = '/myroom/mycredit.html?title='+title+'&foldername='+foldername;
		location.href = url;
	}
</script>
<?php $this->display('myroom/page_footer'); ?>