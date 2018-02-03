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
		当前位置 > <a href="<?= geturl('troomv2/statisticanalysis') ?>">查询统计</a> > 学生笔记统计
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
			<input type="button" id="searchbutton" class="soulico" value="">
		</div>
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">

<div id="icategory" class="clearfix" style="border:none;">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?= empty($classid)?'class="curr"':''?> href="<?= geturl('troomv2/statisticanalysis/notessum') ?>">所有学生</a>
			</div>

			<?php foreach($classlist as $myclass) { ?>
			<div>
				<a <?= $classid==$myclass['classid']?'class="curr"':'' ?> href="<?= geturl('troomv2/statisticanalysis/notessum-0-0-0-'.$myclass['classid']) ?>"><?= $myclass['classname'] ?></a>
			</div>
			<?php } ?>

		</div>
	</dd>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>序号</th>
<th>课件名称</th>
<th>学生姓名</th>
<th>学习时间</th>
<th>操作</th>
</tr>
</thead>

<tbody>

	<?php if(empty($notes)) { ?>
		<tr><td colspan="5" align="center">暂无数据信息</td></tr>
	<?php } else { ?>
		<?php foreach($notes as $key=>$note) { ?>
		<tr>
			<td><?= $key + 1 ?></td>
			<td style="color: #3366cc;"><a href="javascript:;" style="cursor: pointer;" onclick="freeplay('<?= $note['cwsource'] ?>',<?= $note['cwid'] ?>,'<?= str_replace("'"," ",$note['title'])?>',0,<?= $note['noteid']?>)"><?= $note['title'] ?></a></td>
			<td><?= empty($note['realname'])?$note['username']:$note['realname'] ?></td>
			<td><?= date('Y-m-d H:i:s',$note['dateline']) ?></td>
			<td><a href="javascript:;" style="cursor: pointer;" onclick="freeplay('<?= $note['cwsource'] ?>',<?= $note['cwid'] ?>,'<?= str_replace("'"," ",$note['title'])?>',0,<?= $note['noteid']?>)">查看</a></td>
		</tr>
		<?php } ?>
	<?php } ?>
</tbody>
</table>
</div>
	<?= $pagestr ?>
<script type="text/javascript">
var tip = '请输入笔记名称';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/statisticanalysis/notessum-0-0-0-'.$classid)?>';
		if($("#search").val()=='请输入笔记名称'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入笔记名称'){
			searchvalue='';
		}
		location.href = href + "?q="+searchvalue;
	});

});
</script>
<?php 
$this->display('common/player');
$this->display('troomv2/page_footer');
?>