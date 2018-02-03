<?php $this->display('aroomv2/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

		<div class="ter_tit">
		当前位置 > 教师课件查看
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
		<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个</div>
<span style="float:left;height:22px;line-height:22px;margin-left:20px;">查看教师：</span>
<input type="text" class="kipt" style="float:left;color:black" oninput="hlteacher()" onpropertychange="hlteacher()" id="tsearch"/>
<input class="souhuang" type="button" id="searchbutton" onclick="clearsearch()" value="清 除">

<table class="datatab" width="100%" style="border:none;margin-top:10px;float:left;">
<thead class="tabhead">
<tr>
<th>用户名</th>
<th>教师姓名</th>
<th>上传课件</th>
<th>查看</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($roomteacherlist)){
		$cwsum = 0;
		foreach($roomteacherlist as $tl){
			$cwsum+=$tl['cwcount'];
		?>
		<tr>
		<td width="200px" id="un"><?=$tl['username']?></td>
		<td width="200px" id="rn"><?=$tl['realname']?></td>
		<td width="100px"><?=$tl['cwcount']?></td>
		<td width="100px"><a href="<?=geturl('aroomv2/ateacourse/course/'.$tl['uid'])?>" class="workBtn" title="查看">查看</a></td>
		</tr>
		<?php }?>
	<tr>
		<td width="200px">合计</td>
		<td width="200px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=count($roomteacherlist)?></span>&nbsp;个教师</td>
		<td width="100px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$cwsum?></span>&nbsp;个</td>
		<td></td>
		</tr>
		<?php }else{?>
	<tr><td colspan="3" align="center">暂无记录</td></tr>
		<?php }?>
</tbody>
</table>
<script>
function hlteacher(){
	var username;
	var realname;
	var search = $('#tsearch').val();
	$('.datatab tr').each(function(i){
		username = $(this).children("td:#un");
		realname = $(this).children("td:#rn");
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
<?php $this->display('aroomv2/page_footer')?>
