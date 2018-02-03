<?php $this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<?php 
$rurl = $this->input->get('rurl');
$rrurl = $this->input->get('rrurl');
?>
	<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/student/viewnav.html">学生查看</a> > <a href="/aroomv2/student/view.html">班级列表</a> > <a href="/<?=$rurl?>.html?rurl=<?=$rrurl?>">学生列表</a> > 学生作业查看
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato"  style="line-height:28px;padding-left:20px;position: relative;">
	该学生共有作业&nbsp;<span style="color:blue;font-weight:bold;"><?=$examcount?></span>&nbsp;个
	<a href="/<?=$rurl?>.html?rurl=<?=$rrurl?>" class="tfanhui" style="left: 640px;_top:13px;width:90px;position: absolute;">返回上一页</a>
	</div>
	

<table class="datatab" width="100%" style="border:none !important;">
<thead class="tabhead">
<tr >
<th>作业名称</th>
<th>出题教师</th>
<th>出题时间</th>
<th>总分</th>
<th>操作</th>
</tr>
</thead>
	<tbody>
		<?php if(!empty($examlist)){
			foreach($examlist as $el){
		?>
		<tr>
			<td width="30%"><?=shortstr($el['title'],80)?></td>
			<td width="25%"><?=empty($el['realname'])?$el['username']:$el['realname']?></td>
			<td width="20%"><?=Date('Y-m-d H:i:s',$el['dateline'])?></td>
			<td width="5%"><?=$el['score']?></td>
			<td width="20%">
				<?php $target = stripos($_SERVER['HTTP_USER_AGENT'],'android') != false ?'_parent':'_blank'?>
			<?php if(!empty($el['aid'])){?>
			<a class="previewBtn " href="http://exam.ebanhui.com/?aeview/<?=$el['aid']?>.html" target="<?=$target?>">查看结果</a>
			<?php }else{?>
			<a class="previewBtn" href="http://exam.ebanhui.com/?ado/<?=$el['eid']?>.html" target="<?=$target?>">查看作业</a>
			<?php }?>
			</td>
		</tr>
		<?php }}else{?>

 		<tr>
			<td colspan="6" align="center">暂无记录</td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<?=$pagestr?>

<?php $this->display('aroomv2/page_footer')?>
