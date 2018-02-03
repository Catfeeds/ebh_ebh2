<?php $this->display('troomv2/page_header')?>

<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<body>
<div>
	<div class="ter_tit">
        当前位置 > <a href="/troomv2/statisticanalysis.html">统计分析</a> >
        教师统计
    </div>
    <div class="teacherstatistics">
    <!--<div class="teacherstatistics_top">
       		<div class="teacherstatistics_top_l fl">
            	<div class="fl">
                    <span style="font-size:13px;">时间段：</span>
                    <input id="startdate" class="readonly" readonly="readonly" type="text" style="height:20px;line-height:20px;width:125px; padding-left:5px;border:1px solid #cdcdcd; background:#fff" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'enddate\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400)?>\'}'});" value="<?=empty($startdate)?'':$startdate?>"/>
                    <span>--</span>
					<input id="enddate" class="readonly" readonly="readonly" type="text" style="height:20px;line-height:20px;width:125px; padding-left:5px;border:1px solid #cdcdcd; background:#fff" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\',{d:1})}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});" value="<?=empty($enddate)?'':$enddate?>"/>
					
                </div>
                <div class=" fl ml10"><a href="javascript:void(0)" onclick="_search()" class="workBtns">确 定</a></div>
				<div class="fl ml10"><a href="javascript:void(0)" onclick="_clear()" class="workBtns">清 空</a></div>
            </div>
            <div class="diles">
				<input type="text" id="searchkey" value="<?=empty($q)?'请输入教师账号或姓名':$q?>" id="search" class="newsou" name="title" style="color:#999;background:#fff;" onfocus="if($(this).val()=='请输入教师账号或姓名')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入教师账号或姓名');$(this).css('color','#999')}"/>
				<input type="button" class="soulico" onclick="_search()">
			</div>
        </div>-->
        <div class="clear"></div>
        <div class="teacherstatistics_bottom mt15">
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
                    <td width="56"><?=$classnum?></td>
                    <td width="37"><?=$sumsign?></td>
                    <td width="41"><?=$credit?></td>
                    <td width="42"><?=$sumcredit?></td>
                    <td width="42"><?=$foldernum?></td>
                    <td width="42"><?=$cwnum?></td>
                    <td width="42"><?=$examnum?></td>
                    <td width="42"><?=$examquesnum?></td>
                    <td width="42"><?=$asknum?></td>
                    <td width="42"><?=$answernum?></td>
                    <td width="42"><?=$reviewnum?></td>
                </tr>
				<?php }?>
              <!--  <tr>
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
                    
        		</tr>-->
				<?php }else{?>
					<tr>
						<td colspan="12" align="center">暂无记录</td>
					</tr>
				<?php }?>
            </table>
        </div>
    </div>
  <!--  <?=$pagestr?>-->
</div>
</body>
<script>
function _search(){
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入教师账号或姓名')
		searchkey = '';
	location.href = '/troomv2/report/teacher.html?startdate='+startdate+'&enddate='+enddate+'&q='+searchkey;
}
function _clear(){
	$('#startdate').val('');
	$('#enddate').val('');
}
</script>
</html>
