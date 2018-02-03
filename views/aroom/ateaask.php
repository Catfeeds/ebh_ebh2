<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style>
.sortlabel{
	float:left;
	margin-top:8px;
	margin-left:10px;
}
.sortradio{
	float:left;
	margin-top:2px;
}
</style>
	<div class="ter_tit">
		当前位置 > 教师答疑查看
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
	<div class="tiezitoolss">
	<a class="excelbtn" onclick="selecttpye()"> 导出excel</a>
	</div>
	</div>
	

<!--
<label style="" class="sortlabel">
<input type="radio" name="stype" class="sortradio" value="0" checked="checked"/>
<span style="float:left;">
教师分组
</span>
</label>
<label class="sortlabel">
<input type="radio" name="stype" class="sortradio" value="1"/>
<span style="float:left;">
年级
</span>
</label>
-->
<div id="typediv" style="display:none;position:absolute;z-index:999;border:1px solid #E8E8E8;left:688px;top:104px;background:white;width:82px;">
	
	<div class="" >
		<span style="display:block;text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;cursor:pointer" onclick="toexcel(0)">教师分组</span>
	</div>
	
	<div>
		<span style="display:block;text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;cursor:pointer" onclick="toexcel(1)">年　　级</span>
	</div>
</div>
<div style="float:left;margin-top:-5px;margin-left:20px">
<span style="float:left;margin-top:10px">
时间: 
</span>
<input type="text" id="startdate" readonly="readonly" style="float:left;text-indent:10px;width:80px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$startdate?>"/>
<span style="float:left;margin-top:10px;margin-left:3px">
-
</span>
<input type="text" id="enddate" readonly="readonly" style="float:left;text-indent:10px;width:80px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$enddate?>"/>


</div>
<input class="souhuang" type="button" id="" onclick="searchbydate()" value="搜 索"/>

<span style="float:left;height:22px;line-height:22px;margin-left:20px;">查看教师：</span>
<input type="text" class="kipt" style="float:left;color:black;width:120px" oninput="hlteacher()" onpropertychange="hlteacher()" id="tsearch"/>
<input class="souhuang" type="button" id="searchbutton" onclick="clearsearch()" value="清 除">

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>用户名</th>
<th>教师姓名</th>
<th>指定次数</th>
<th>回答数</th>
<th>查看</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($teacherlist)){
		$answernum = 0;
		$asknum = 0;
			foreach($teacherlist as $tl){
			$answernum+=$tl['answernum'];
			$asknum+=$tl['asknum'];
			
	?>
		<tr>
		<td width="200px" id="un"><?=$tl['username']?></td>
		<td width="200px" id="rn"><?=$tl['realname']?></td>
		<td width="200px"><?=$tl['asknum']?></td>
		<td width="100px"><?=empty($tl['answernum'])?0:$tl['answernum']?></td>
		<td width="100px"><a href="<?=geturl('aroom/ateaask/ateaasklist-0-0-0-'.$tl['uid'])?>" class="previewBtn" title="查看答疑">查看答疑</a></td>
		</tr>
	<?php }?>
	<tr>
		<td width="200px">合计</td>
		<td width="200px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=count($teacherlist)?></span>&nbsp;个教师</td>
		<td width="200px" colspan="1">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$asknum?></span>&nbsp;次指定</td>
		<td width="200px" colspan="2">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$answernum?></span>&nbsp;次回答</td>
		</tr>
	<? }else{?>
	<tr><td colspan="5" align="center">暂无记录</td></tr>
	<?php }?>
</tbody>
</table>
</div>
<script>
function hlteacher(){
	var username;
	var realname;
	var search = $('#tsearch').val();
	$('.datatab tr').each(function(i){
		username = $(this).children("#un");
		realname = $(this).children("#rn");
		if(username.text().indexOf(search)>=0 || realname.text().indexOf(search)>=0 || search == ""){
			$(this).show();
		}else if(i!=0){
			$(this).hide();
		}
	});
}
function clearsearch(){
	$('#tsearch').val('');
	hlteacher();
	$('#tsearch').focus();
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
	var href='/aroom/report/taexcel.html?stype='+stype+'&sdate='+sdate+'&edate='+edate;
	location.href = href;
}
function searchbydate(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var href='/aroom/ateaask.html?sdate='+sdate+'&edate='+edate;
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
</script>
<?php $this->display('aroom/page_footer')?>