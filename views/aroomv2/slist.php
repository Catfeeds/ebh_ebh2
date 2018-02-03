<?php $this->display('aroomv2/page_header');
	$classid = !empty($classid)?$classid:0;
?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
		当前位置 > 学生列表
		</div>
	<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
此页为学生列表页面。
</div>
<div id="icategory" class="clearfix">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroomv2/slist-0-0-0-0')?>">所有学生</a>
			</div>
			<?php foreach($classlist as $cl){?>
			<div>
				<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroomv2/slist-0-0-0-'.$cl['classid'])?>"><?=$cl['classname']?></a>
			</div>
			<?php }?>
		</div>
	</dd>
</div>
<div class="key_word" style="height:30px;">
<span style="float:left;height:22px;line-height:22px;">关键词：</span>
		<input id="search" class="kipt" style="float:left;" type="text" name="search" value="<?= $search ?>">
		<input class="souhuang" type="button" name="searchbutton" id="searchbutton" value="搜 索">
</div>
<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>学生班级</th>
<th>登录账号</th>
<th>学生姓名</th>
<th>性别</th>
<th>邮箱</th>
<th>电话</th>
</tr>
</thead>

<tbody>
		<?php
			if(!empty($roomuserlist)){
			foreach($roomuserlist as $v){?>
		<tr>
			<td width="15%"><span style="word-wrap: break-word;float:left;width:75px;"><?=$v['classname']?></span></td>
			<td width="15%"><?=$v['username']?></td>
			<td width="25%"><?=ssubstrch($v['cnname'],0,20)?></td>
			<td width="5%"><?=$v['sex']==1?'女':'男'?></td>
			<td width="20%"><span style="word-wrap: break-word;float:left;width:135px;"><?=$v['email']?></span></td>
			<td width="20%"><?=$v['mobile']?></td>
		</tr>

		<?php }}else{?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
		<?php }?>
</tbody>
</table>
</div>
<?= $pagestr ?>
<script type="text/javascript">
var tips = '请输入学生姓名或登录帐号';
$(function(){
	initsearch('search',tips);
	$('#searchbutton').click(function(){
		<?php $classid = empty($classid)?'0':$classid?>
		var url = '<?=geturl('aroomv2/slist-0-0-0-'.$classid)?>';
		var searchvalue = $.trim($("#search").val());

		if(searchvalue==tips){
			var searchvalue = '';
		}
		location.href = url + "?q=" + searchvalue;
	});

});
</script>
<?php $this->display('aroomv2/page_footer')?>
