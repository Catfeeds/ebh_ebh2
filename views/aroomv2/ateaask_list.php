<?php $this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

	<div class="ter_tit">
		当前位置 > 教师答疑查看 > 查看答疑
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">该教师共回答了&nbsp;<span style="color:blue;font-weight:bold;"><?=$answercount?></span>&nbsp;次问题
<a href="<?=geturl('aroomv2/ateaask')?>" style="width:90px;" class="tfanhui">返回上一页</a>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>问题名称</th>
<th>所属学科</th>
<th>提问时间 </th>
<th width="8%">回答数</th>
<th width="12%">操作</th>
</tr>
</thead>
<tbody>
<?php if(empty($answerlist)){?>
			  		<tr><td colspan="5" align="center">目前没有问题记录</td></tr>
				<?php }else{
					foreach($answerlist as $al){
				?>
				 		<tr>
				 			<td width="300px;"><p style="width:298px;word-wrap: break-word;float:left;"><?=$al['title']?></p></td>
					  		<td><p style="width:145px;word-wrap: break-word;float:left;"><?=$al['foldername']?></p></td>
					    	<td><?=Date('Y-m-d H:i:s',$al['dateline'])?></td>
					    	<td width="8%"><?=$al['answercount']?></td>
							<td width="12%"><a class="previewBtn-1" target="_blank" href="<?=geturl('question/'.$al['qid'])?>">查看详情</a></td>
				    	</tr>

		<?php }}?>
</tbody>
</div>
</table>
		<?= $pagestr ?>
<?php $this->display('aroomv2/page_footer')?>