<?php $this->display('aroomv2/page_header')?>

<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<body>
<div>
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> >
        教师统计
    </div>
    <div class="teacherstatistics">
    	<div class="teacherstatistics_top">
        	<div class="teacherstatistics_top_l mt10 fl">
            	<div class="fl">
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="startdate" class="readonly inp" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'enddate\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400)?>\'}'});" value="<?=empty($startdate)?'':$startdate?>"/>
                    <span style="font-size:14px; color:#333;">到</span>
					<input id="enddate" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\',{d:1})}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});" value="<?=empty($enddate)?'':$enddate?>"/>
					
                </div>
                <div class=" fl ml20"><a href="javascript:void(0)" onclick="_search()" class="workBtns workBtns-1">确 定</a></div>
				<div class="fl ml20"><a href="javascript:void(0)" onclick="_clear()" class="workBtns workBtns-1">清 空</a></div>
            </div>
            <div class="diles diles-1">
				<input type="text" id="searchkey" value="<?=empty($q)?'请输入教师账号或姓名':$q?>" id="search" class="newsous" name="title" style="color:#999;background:#fff;" onfocus="if($(this).val()=='请输入教师账号或姓名')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入教师账号或姓名');$(this).css('color','#999')}"/>
				<input type="button" class="soulico" onclick="_search()">
			</div>
        </div>
        <div class="clear"></div>
        <div class="teacherstatistics_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr  class="first">
                	<td width="173">教师</td>
                    <td width="56">任教班级</td>
                    <td width="37">签到</td>
                    <td width="41">积分</td>
                    <td width="42">累计</td>
                    <td width="42">课程</td>
                    <td width="42">课件</td>
                    <td width="42">作业</td>
                    <td width="42">试题</td>
                    <td width="42">定提</td>
                    <td width="42">答疑</td>
                    <td width="42">评论</td>
                </tr>
                <?php 
				$rurl = $this->uri->path;
				$sumarr = array('classnum'=>0,'sumsign'=>0,'credit'=>0,'sumcredit'=>0,'foldernum'=>0,'cwnum'=>0,'examnum'=>0,'examquesnum'=>0,'asknum'=>0,'answernum'=>0,'reviewnum'=>0,);
				// var_dump($teacherlist);exit;
				if(!empty($teacherlist)){
				foreach($teacherlist as $teacher){
					$face = getthumb($teacher['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($teacher['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
					foreach($sumarr as $key=>$value){
						$$key = !empty($teacher[$key])?$teacher[$key]:0;
						$sumarr[$key]+= $$key;
					}
					?>
                <tr >
                	<td width="173"><div class="fl"> <img style="height:50px;width:50px" src="<?=$face?>" /></div><p class="p2s"><?=$teacher['realname']?>(<?=empty($teacher['sex'])?'男':'女'?>)<br /><?=$teacher['username']?></p></td>
                    <td width="56"><a href="<?=geturl('aroomv2/teacher/classes/'.$teacher['uid']).'?rurl='.$rurl?>"><?=$classnum?></a></td>
                    <td width="37"><?=$sumsign?></td>
                    <td width="41"><?=$credit?></td>
                    <td width="42"><?=$sumcredit?></td>
                    <td width="42"><a href="<?=geturl('aroomv2/teacher/course/'.$teacher['uid']).'?rurl='.$rurl?>"><?=$foldernum?></a></td>
                    <td width="42"><a href="<?=geturl('aroomv2/teacher/courseware/'.$teacher['uid']).'?rurl='.$rurl?>"><?=$cwnum?></a></td>
                    <td width="42"><?=$examnum?></td>
                    <td width="42"><?=$examquesnum?></td>
                    <td width="42"><a href="<?=geturl('aroomv2/teacher/askme/'.$teacher['uid']).'?rurl='.$rurl?>"><?=$asknum?></a></td>
                    <td width="42"><a href="<?=geturl('aroomv2/teacher/answer/'.$teacher['uid']).'?rurl='.$rurl?>"><?=$answernum?></a></td>
                    <td width="42"><a href="<?=geturl('aroomv2/teacher/review/'.$teacher['uid']).'?rurl='.$rurl?>"><?=$reviewnum?></a></td>
                </tr>
				<?php }?>
                <tr>
                    <td width="173"><b>合计:</b></td>
                    <td width="56"><?=$sumarr['classnum']?></td>
                    <td width="37"><?=$sumarr['sumsign']?></td>
                    <td width="41"><?=$sumarr['credit']?></td>
                    <td width="42"><?=$sumarr['sumcredit']?></td>
                    <td width="42"><?=$sumarr['foldernum']?></td>
                    <td width="42"><?=$sumarr['cwnum']?></td>
                    <td width="42"><?=$sumarr['examnum']?></td>
                    <td width="42"><?=$sumarr['examquesnum']?></td>
                    <td width="42"><?=$sumarr['asknum']?></td>
                    <td width="42"><?=$sumarr['answernum']?></td>
                    <td width="65"><?=$sumarr['reviewnum']?></td>
                    
        		</tr>
				<?php }else{?>
					<tr>
						<td colspan="12" align="center">暂无记录</td>
					</tr>
				<?php }?>
            </table>
        </div>
    </div>
    <?=$pagestr?>
</div>
</body>
<script>
function _search(){
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入教师账号或姓名')
		searchkey = '';
	location.href = '/aroomv2/report/teacher.html?startdate='+startdate+'&enddate='+enddate+'&q='+searchkey;
}
function _clear(){
	$('#startdate').val('');
	$('#enddate').val('');
}
</script>
</html>
