<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroom/tlist')?>">教师列表</a>
		</div>
	<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
<input type="text"  class="soutxt" name="search" id="search" value="<?=$search?>" style="width:200px;height:20px; float:left;line-height:22px; font-size:14px;padding-left: 5px;color:#666;"><input class="souhuang" type="button" value="搜 索" name="searchbutton" id="searchbutton">
</div>



<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>登录账号</th>
<th>教师姓名</th>
<th>联系方式</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($roomteacherlist)){
		foreach($roomteacherlist as $value){?>
		<tr>
		<td width="150px"><?=$value['username']?><?php if($room['uid'] == $value['uid']){?><span style="color:red">(管理员)</span><?php }?></td>
		<td width="150px"><?=$value['realname']?></td>
		<td width="150px"><?=$value['mobile']?></td>
		</tr>
	<?php }}else{?>
	<tr><td colspan="3" align="center">暂无记录</td></tr>
	<?php }?>
</tbody>
</table>
<?= $pagestr ?>
</div>
<script type="text/javascript">
var tip = '请输入教师姓名或登录帐号';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		var href = '<?=geturl('aroom/tlist')?>';
		var searchvalue = $.trim($("#search").val());
		if(searchvalue=='请输入教师姓名或登录帐号'){
			searchvalue='';
		}
		location.href = href + "?q="+searchvalue;
	});
});
</script>
<?php $this->display('aroom/page_footer')?>
