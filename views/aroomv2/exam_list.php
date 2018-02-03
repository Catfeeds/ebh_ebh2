<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<body>
<div>
	<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
?>
	<?php
	if($rurl == 'aroomv2/teacher/teacherlist'){?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/teacher/viewnav')?>"> 教师查看 </a> > <a href="<?=geturl('aroomv2/teacher/teacherlist')?>"> 教师列表 </a> > 作业查看
	<?php }else{?>
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> > 作业查看
	<?php }?>
    </div>
    <div class="workcheck">
    	<div class="workcheck_top">
        	<div class="workcheck_top_l fl">
            	<div class="fl">
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="startdate" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'enddate\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400)?>\'}'});" value="<?=empty($startdate)?'':$startdate?>"/>
                    <span style="font-size:14px; color:#333;">到</span>
					<input id="enddate" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\',{d:1})}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});" value="<?=empty($enddate)?'':$enddate?>"/>
                </div>
                <div class=" fl ml20"><a href="javascript:void(0)" onclick="_search()" class="workBtns workBtns-1">确 定</a></div>
				<div class=" fl ml20"><a href="javascript:void(0)" onclick="clearsearch()" class="workBtns workBtns-1">清 空</a></div>
            </div>
            <div class="diles diles-1 fr" style="margin-top:0;">
                <input type="text" value="<?=empty($q)?'请输入作业名称':$q?>" id="searchkey" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入作业名称')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入作业名称');$(this).css('color','#999')}">
                <input type="button" value="" class="soulico" onclick="_search()">
            </div>
        </div>
        <div class="clear"></div>
        <div class="workcheck_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
			<tr class="first">
				<td width="245">作业名称</td>
				<td width="148">布置时间</td>
				<td width="75">分数</td>
				<td width="75">应答人数</td>
				<td width="75">已答人数</td>
				<td width="96">查看</td>
			</tr>
			<?php 
			$grademap = $askreward = EBH::app()->getConfig()->load('grademap');
			if(!empty($examlist)){
			foreach($examlist as $exam){?>
			<tr>
				<td width="245"><p style="width:240px;word-wrap: break-word;float:left;"><b><?=$exam['title']?><br /><?=!empty($exam['classname'])?$exam['classname']:(!empty($exam['grade'])?$grademap[$exam['grade']]:'')?></b></p><br/><!--<p style="width:240px;word-wrap: break-word;float:left;">浙教版七上第二章 有理数的运算综合测试卷</p>--></td>
				<td width="148"><?=Date('Y-m-d H:i:s',$exam['dateline'])?></td>
				<td width="75"><?=$exam['score']?>分</td>
				<td width="75"><?=empty($exam['stunum'])?0:$exam['stunum']?></td>
				<td width="75"><?=$exam['answercount']?></td>
				<td width="96"><a target="_blank" href="http://exam.ebanhui.com/?ado/<?=$exam['eid']?>.html">查看</a></td>
			</tr>
            <?php }}else{?>
				<tr><td colspan="6" style="text-align:center"><?=empty($q)?'暂无数据':'没有关于 "'.$q.'" 的搜索结果'?></td></tr>
			<?php }?>
		</table>
		</div>
	</div>
	<?=$pagestr?>
</div>
</body>
<script>

function _search(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入作业名称')
		searchkey = '';
	var href='/aroomv2/exam.html?startdate='+sdate+'&enddate='+edate+'&q='+searchkey+'&rurl=<?=$rurl?>';
	location.href = href;
}
function clearsearch(){
	// $('#startdate').val('');
	// $('#enddate').val('');
	var href='/aroomv2/exam.html';
	location.href = href;
}
</script>
</html>
