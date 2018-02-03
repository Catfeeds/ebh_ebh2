<?php $this->display('troomv2/page_header'); ?>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
</style>

	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troomv2/tastulog') ?>">学生监察</a> > <?= $typename ?>
		<div class="diles">
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="title" <?=$stylestr?> class="newsou" id="search" value="<?=$q?>" type="text" />
			<input name="searchbutton" id="searchbutton" type="button" class="soulico" value="">
		</div>
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">

<div id="icategory" class="clearfix" style="border:none;">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?= empty($classid) ? 'class="curr"':''?> href="<?= geturl('troomv2/scalendar-0-0-0-0-'.$type) ?>">所有学生</a>
			</div>
	
                        <?php foreach ($classlist as $myclass) { ?>
			<div>
				<a <?= ($myclass['classid'] == $classid)? 'class="curr"':''?> href="<?= geturl('troomv2/scalendar-0-0-0-'.$myclass['classid'].'-'.$type)?>"><?= $myclass['classname'] ?></a>
			</div>
                        <?php } ?>

		</div>
	</dd>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>学生班级</th>
<th>登录账号</th>
<th>学生姓名</th>
<th>性别</th>
<th>邮箱</th>
<th>操作</th>
</tr>
</thead>


<tbody>
	
        <?php if(!empty($students)) { ?>

                <?php foreach ($students as $student) { ?>
		<tr>
			<td width="20%"><?= $student['classname'] ?></td>
			<td width="20%"><span class="huirenw"><?= $student['username'] ?></span></td>
			<td width="18%"><?= $student['realname'] ?></td>
			<td width="10%"><?= $student['sex']==1?'女':'男' ?></td>
			<td width="25%"><?= $student['email'] ?></td>
			<td width="7%"><a class="workBtn" style="color:#fff;text-decoration: none;" href="<?= geturl('troomv2/scalendar/'.$student['uid'].'-0-0-0-'.$type) ?>"/>查看</a></td>
		</tr>
                <?php } ?>
		
        <?php } else { ?>

		<tr><td colspan="6" align="center">暂无记录</td></tr>
        <?php } ?>

</tbody>
</table>
</div>
<?= $pagestr ?>
<script type="text/javascript">

$(function(){
    initsearch("search","请输入学生姓名或登录帐号");
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/scalendar-0-0-0-'.$classid.'-'.$type) ?>';
                var searchvalue = $.trim($("#search").val());
		if(searchvalue=='请输入学生姓名或登录帐号'){
			searchvalue = '';
		}
		if(searchvalue=='请输入老师姓名或登录帐号'){
			searchvalue='';
		}
		href = href + "?q=" + searchvalue;
		location.href = href;
	});

});
</script>

<?php $this->display('troomv2/page_footer'); ?>