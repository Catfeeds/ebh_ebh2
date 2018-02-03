<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
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
	<div class="annuato" style="line-height:28px;padding-left:20px;border:solid 1px #cdcdcd;background:#fff;position: relative;text-align:center;">达标学分&nbsp;<span style="color:blue;font-weight:bold;"><?=$stuOkScore?></span>&nbsp;分，您已获取&nbsp;<span style="color:blue;font-weight:bold;"><?=$totalScore?></span>&nbsp;分，&nbsp;<span style="color:red;font-weight:bold;"><?=($totalScore>=$stuOkScore)?'恭喜您获取所有学分！':'请再接再厉！'?></span>&nbsp;<span>如果学分有误请点击同步学分：<a style="color:red;font-weight:bold;" href="javascript:void(0)" onclick="updateschredit()">同步学分</a></span></div>

	<div class="workol" style="background:none;">

		    <div class="workdata" style="width:788px;background:none;">
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
						  </tr>
						 <?php } ?>
						 
					 <?php } else { ?>
							 <tr>
					 		<td colspan="6" align="center" style="border-bottom: 1px solid #cdcdcd;">暂无记录</td>
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
	function updateschredit(){
		$.post('/myroom/mycredit/creditSync.html',
			{},
			function(res){
				if(res == -1){
					msg = "用户没有登录";
				}else if(res == -2){
					msg = "没有满分作业！";
				}else if(res == -3){
					msg = "没有已经看完未加分的课件！";
				}else if(res == -4){
					msg = "学分已是最新，无需同步！";
				}else{
					msg = "同步学分成功！";
				}
				$.showmessage({
                    message  :msg,
                    title    :"操作提示",
                    callback:function(){
                    	location.reload();
                    }
                });
			}
		);
	}
</script>
<?php $this->display('myroom/page_footer'); ?>