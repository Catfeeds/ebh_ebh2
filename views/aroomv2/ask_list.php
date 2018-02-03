<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style>
span{
	font-size:12px;
}
</style>
<body>
<div>
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> > 答疑查看
    </div>
    <div class="checkqueansw ">
    	<div class="fr expteaqasta_top1">
             <ul>
                <li class="fl "><a href="javascript:void(0)" class="workBtns workBtns-1" onclick="selecttpye()" style="margin-right:2px">导出excel</a></li>
            </ul>
        </div>
        <div class="clear"></div>
    	<div class="checkqueansw_top mt10">
        	<div class="checkqueansw_top_l fl">
            	<div class="fl">
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="startdate" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'enddate\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400)?>\'}'});" value="<?=empty($startdate)?'':$startdate?>"/>
                    <span style="font-size:14px; color:#333;">到</span>
					<input id="enddate" class="readonly inp" readonly="readonly" type="text"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'startdate\',{d:1})}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});" value="<?=empty($enddate)?'':$enddate?>"/>
                </div>
                <div class=" fl ml20" style="margin-top:1px;"><a href="javascript:void(0)" onclick="_search()" class="workBtns workBtns-1">确 定</a></div>
				<div class=" fl ml20" style="margin-top:1px;"><a href="javascript:void(0)" onclick="clearsearch()" class="workBtns workBtns-1">清 空</a></div>
            </div>
            <div class="diles diles-1 fr" style="margin-top:0;">
                <input type="text" value="<?=empty($q)?'请输入教师账号或姓名':$q?>" id="searchkey" class="newsous" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入教师账号或姓名')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入教师账号或姓名');$(this).css('color','#999')}">
                <input type="button" value="" onclick="_search()" class="soulico" id="searchbutton">
            </div>
        </div>
        <div class="clear"></div>
        <div class="checkqueansw_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr  class="first">
                	<td width="220">教师</td>
                    <td width="110">定提数</td>
                    <td width="114">答疑数</td>
                    <td width="109">采纳数</td>
                    <td width="172">查看</td>
                </tr>
				<?php if(!empty($teacherlist)){
					$rurl = $this->uri->path;
					foreach($teacherlist as $teacher){
						$face = getthumb($teacher['face'],'50_50');
						if(empty($face))
							$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($teacher['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
						
						?>
                <tr >
                	<td width="220"><div class="fl"><img src="<?=$face?>" style="height:50px; width:50px;"/></div><p class="p2s" style="width:165px !important;"><b style="font-size:14px;"><?=$teacher['realname']?>(<?=empty($teacher['sex'])?'男':'女'?>)<br /><?=$teacher['username']?></b></p></td>
                    <td width="110"><?=$teacher['asknum']?></td>
                    <td width="114"><?=empty($teacher['answernum'])?'0':$teacher['answernum']?></td>
                    <td width="109"><?=empty($teacher['bestnum'])?'0':$teacher['bestnum']?></td>
                    <td width="172"><a href="<?=geturl('aroomv2/teacher/askme/'.$teacher['uid']).'?rurl='.$rurl.'&startdate='.$startdate.'&enddate='.$enddate?>">查看答疑</a></td>
                </tr>
				<?php }
				}else{
				?>
				<tr><td colspan="5" style="text-align:center"><?=empty($q)?'暂无数据':'没有关于 "'.$q.'" 的搜索结果'?></td></tr>
				<?php }?>
            </table>
        </div>
    </div>
	<?=$pagestr?>
</div>
</body>

<div id="typediv" style="display:none;position:absolute;z-index:999;border:1px solid #E8E8E8;left:707px;top:74px;background:white;width:82px;">
	
	<div>
		<span style="display:block;text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;cursor:pointer" onclick="toexcel(0)">教师分组</span>
	</div>
	
	<div>
		<span style="display:block;text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;cursor:pointer" onclick="toexcel(1)">年　　级</span>
	</div>
</div>
<script>
function searchbydate(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var href='/aroomv2/ask.html?startdate='+sdate+'&enddate='+edate;
	location.href = href;
}
function clearsearch(){
	$('#startdate').val('');
	$('#enddate').val('');
	var href='/aroomv2/ask.html?startdate=&enddate=';
	location.href = href;
}
var showtd = false;
function selecttpye(){
	if($('#typediv').css('display') != 'block'){
		$('#typediv').show();
		showtd = true;
	}
}
function toexcel(stype){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var href='/aroomv2/report/taexcel.html?stype='+stype+'&sdate='+sdate+'&edate='+edate;
	location.href = href;
}
$('body').click(function(e){
	obj = e.srcElement ? e.srcElement : e.target;
	if(obj.parentNode == $('#typediv')[0] || obj == $('#typediv')[0])
		;
	else if(showtd == false){
		$('#typediv').hide();
	}
	showtd = false;
});
function _search(){
	var startdate = $('#startdate').val();
	var enddate = $('#enddate').val();
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入教师账号或姓名')
		searchkey = '';
	location.href = '/aroomv2/ask.html?startdate='+startdate+'&enddate='+enddate+'&q='+searchkey;
}
</script>
</html>
