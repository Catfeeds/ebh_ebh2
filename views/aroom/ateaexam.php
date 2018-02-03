<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

	<div class="ter_tit">
		当前位置 > 教师作业查看
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个</div>

<span style="float:left;height:22px;line-height:22px;margin-left:20px;">查看教师：</span>
<input type="text" class="kipt" style="float:left;color:black" oninput="hlteacher()" onpropertychange="hlteacher()" id="tsearch"/>
<input class="souhuang" type="button" id="searchbutton" onclick="clearsearch()" value="清 除">

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>用户名</th>
<th>教师姓名</th>
<th>布置作业</th>
<th>布置试题</th>
<th>查看</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($teacherlist)){
		$coursenum = 0;
		$quesnum = 0;
		foreach($teacherlist as $tl){
		$coursenum += $tl['count'];
		$quesnum += $tl['quescount'];
	?>
	<tr>
		<td width="200px" id="un"><?=$tl['username']?></td>
		<td width="200px" id="rn"><?=$tl['realname']?></td>
		<td width="100px"><?=empty($tl['count'])?'0':$tl['count']?></td>
		<td width="100px"><?=empty($tl['quescount'])?'0':$tl['quescount']?></td>
		<td width="100px">
		<a class="workBtn" title="查看" href="<?=geturl('aroom/ateaexam/class/'.$tl['uid'])?>">查看</a>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td width="200px">合计</td>
		<td width="200px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=count($teacherlist)?></span>&nbsp;个教师</td>
		<td width="100px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$coursenum?></span>&nbsp;个</td>
		<td width="100px" colspan="2">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$quesnum?></span>&nbsp;个</td>
	</tr>
	<?php }else{?>

	<tr><td colspan="3" align="center">暂无记录</td></tr>
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
</script>
<?php $this->display('aroom/page_footer')?>