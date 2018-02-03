<?php $this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

	<div class="ter_tit">
		当前位置 > 教师所教班级 > 班级作业
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<div class="workol">


<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;"> 该教师在此班级共有作业 <span style="color:blue;font-weight:bold;"><?=$examcount?></span> 个.
<a class="tfanhui" style="left: 640px;_top:13px;position: absolute;width:90px;" href="<?=geturl('aroomv2/ateaexam/class/'.$uid)?>">返回上一页</a>
</div>
<div class="workdata" style="float:left;margin-top:0px;">
	<table width="100%" class="datatab" style="border:none;">
		<thead class="tabhead">
		  <tr>
			<th>作业名称</th>
			<th>时间</th>
			<th>分数</th>
			<th>答题人数</th>
			<th>查看作业</th>
		  </tr>
		</thead>
		 <tbody>
	
		<?php if(!empty($examlist)){
			foreach($examlist as $el){
		?>
			  <tr>
				<td width="30%"><?=shortstr($el['title'],60)?></td>
				<td width="20%"><?=Date('Y-m-d H:i:s',$el['dateline'])?></td>
				<td width="10%"><?=$el['score']?></td>
				<td width="10%"><?=$stunum?>/<?=$el['answercount']?></td>
				<td width="15%">
					<a class="previewBtn" href="http://exam.ebanhui.com/?ado/<?=$el['eid']?>.html" target="$target">查看作业</a>
				</td>
			  </tr>
			<?php }}else{?>
			
			<tr>
				<td colspan="8" align="center">暂无记录</td>
			</tr>
			<?php }?>
		 
		</tbody>
	</table>
	<div style="margin-top:20px;">
	<?=show_page($examcount)?>
	</div>
</div>
</div>
</div>
<?php $this->display('aroomv2/page_footer')?>