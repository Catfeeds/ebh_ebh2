<?php $this->display('troom/page_header'); ?>
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
		当前位置 > <a href="<?= geturl('troom/statisticanalysis') ?>">统计分析</a> > 学生监察 
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
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

<div id="icategory" class="clearfix" style="border:none;">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?= empty($classid) ? 'class="curr"':''?> href="<?= geturl('troom/tastulog') ?>">所有学生</a>
			</div>
	
                        <?php foreach ($classlist as $myclass) { ?>
			<div>
				<a <?= ($myclass['classid'] == $classid)? 'class="curr"':''?> href="<?= geturl('troom/tastulog-0-0-0-'.$myclass['classid'])?>"><?= $myclass['classname'] ?></a>
			</div>
                        <?php } ?>

		</div>
	</dd>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th style="padding-left:15px;">学生</th>
<th>班级</th>
<th>邮箱</th>
<th>操作</th>
</tr>
</thead>


<tbody>
	
        <?php if(!empty($students)) { ?>

                <?php foreach ($students as $student) { ?>
		<tr>
			<?php 
			if(!empty($student['face']))
				$face = getthumb($student['face'],'50_50');
			else{
				if($student['sex']==1){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				}else{
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
				}
				$face = getthumb($defaulturl,'50_50');
			} 
			?>
							
			<td width="40%"><a style="float:left;" href="javascript:;" title="<?= $student['username'] ?>"><img src="<?= $face ?>"></a><p class="ghjut"><?= $student['username'] ?>(<?= $student['sex']==1?'女':'男' ?>)</p><p  class="ghjut"><?= $student['realname'] ?></p></td>
			<td width="25%"><?= $student['classname'] ?></td>
			<td width="25%"><?= $student['email'] ?></td>
			<td width="25%"><a class="workBtn" style="color:#fff;text-decoration: none;" href="<?= geturl('troom/statisticanalysis/scorefind/'.$student['uid']) ?>"/>查看</a></td>
		</tr>
                <?php } ?>
		
        <?php } else { ?>

		<tr><td colspan="4" align="center">暂无记录</td></tr>
        <?php } ?>

</tbody>
</table>
</div>
<?= $pagestr ?>
<script type="text/javascript">

$(function(){
    initsearch("search","请输入学生姓名或登录帐号");
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troom/tastulog-0-0-0-'.$classid) ?>';
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

<?php $this->display('troom/page_footer'); ?>