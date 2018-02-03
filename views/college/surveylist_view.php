<?php $this->display('college/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
<style type="text/css">
.datatab{border:none;}
.datatab td{border}
}
</style>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;">
<?php
if(!empty($folder)){
	$this->assign('selidx', 6);
	$this->display('college/course_nav');
}
?>
	<table class="datatab" width="100%">
		<thead class="tabhead">
			<tr>
			<th>名称</th>
			<th>关联课件</th>
			<th>时间</th>
			<th>操作</th>
			</tr>
		</thead>
		<tbody>
<?php if(!empty($surveylist)){
		foreach($surveylist as $survey){?>
			<tr>
				<td width="200px"><?=strip_tags($survey['title'])?></td>
				<td width="200px"><?=$survey['cwname']?></td>
				<td width="100px"><?=date('Y-m-d H:i:s',$survey['dateline'])?></td>
				<td width="100px"><?php if(empty($survey['aid'])){?><a class="previewBtn" href="/college/survey/fill/<?=$survey['sid']?>.html">答卷</a><?php }else{?><a class="previewBtn" href="/college/survey/answer/<?=$survey['sid']?>.html">查看</a><?php }?>
				<?php if (!empty($survey['allowview'])) {?><a class="previewBtn" href="/college/survey/stat/<?=$survey['sid']?>.html">统计</a><?php }?></td>
			</tr>
		<?php }
	}?>
		</tbody>
	</table>

<?=$pagestr?>
</div>
<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
	initsearch("title",searchtext);
	$("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('college/survey/surveylist') ?>' + '?q='+title;
	   <?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
	   <?php }?>
       document.location.href = url;
	});
});

</script>
<?php $this->display('myroom/page_footer'); ?>