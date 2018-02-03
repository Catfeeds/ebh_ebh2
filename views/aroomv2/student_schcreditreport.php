<?php $this->display('aroomv2/page_header')?>
<style>
.category_cont1 div a:hover, .category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
    background: #66a0f8;
    color: #ffffff;
    padding: 2px;
    text-decoration: none;

}
.category_cont1 div a{
	padding:2px !important;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    padding: 0 10px;
    white-space: nowrap;
    word-wrap: break-word;
}
.tabhead th{
	font-weight:normal !important;
}
</style>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/student/viewnav.html">学生查看</a> > 学分统计
	<!-- ============= -->
	<?php
		$defaultColor = empty($q)?'#CBCBCB':'#000';
		$q = empty($q)?'输入关键字搜索':$q;
	?>
	<!-- =============== -->
<div class="diles diles-1" style="top:-1px;">
	<input name="title" class="newsou" style="color:<?= $defaultColor ?>" value="<?= isset($q) ? $q : '输入关键字搜索' ?>" onblur="if($('#search').val()==''){$('#search').val('输入关键字搜索').css('color','#d9d9d9');}" onfocus="if($('#search').val()=='输入关键字搜索'){$('#search').val('').css('color','#d9d9d9');}" id="search" value="输入关键字搜索"  />
	<input type="button" class="soulico" value="" id="searchbutton">
</div>
</div>
<div class="lefrig" style="float:left;width:788px;">
	<!-- === -->
	<div class="annuato" style="line-height:28px;padding-left:20px;background:#fff;position: relative; margin-top:15px;">
	本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
	<div class="tiezitoolss">
	<a class="workBtns workBtns-1" href = "/aroomv2/student/schcreditlogexcel.html"> 导出excel</a>
	</div>
	</div>
	<!-- === -->
<div style="background:#fff;margin-bottom:10px;">
	<div id="icategory" class="clearfix" style="background:#fff;border-top:none;">
		<dt>所属班级：</dt>
		<dd style="width:680px;">
			<div class="category_cont1">
				<div>
					<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroomv2/student/schcreditreport-0-0-0-0')?>">所有学生</a>
				</div>
				<?php foreach($classlist as $cl){?>
				<div>
					<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroomv2/student/schcreditreport-0-0-0-'.$cl['classid'])?>"><?=$cl['classname']?></a>
				</div>
				<?php }?>
			</div>
		</dd>
	</div>
	<div id="icategory" class="clearfix" style="background:#fff">
		<dt>所属年级：</dt>
		<dd style="width:680px;">
			<div class="category_cont1">
				<div>
					<a <?php if(empty($grade)){?>class="curr"<?php }?> href="<?=geturl('aroomv2/student/schcreditreport-0-0-0-0')?>">所有学生</a>
				</div>
				<?php foreach($gradeList as $key=>$gl){?>
				<div>
					<a <?php if($grade==$key){?>class="curr"<?php }?>href="<?=geturl('aroomv2/student/schcreditreport-0-0-0-0-'.$key)?>"><?=$gl?></a>
				</div>
				<?php }?>
			</div>
		</dd>
	</div>
	</div>
	<div id="p_fct" style="display:none;"><div id="fct"></div></div>
<div style="background:#fff;float:left;width:788px;">
	<table class="datatab" width="100%" style="border:none;">
	<thead class="tabhead">
		<tr>
			<th width="20%">学生账号</th>
			<th width="30%">姓名</th>
			<th width="30%">班级</th>
			<th width="20%">获取学分</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($schcreditlog)){?>
			<?php foreach ($schcreditlog as $svalue) {?>
			<tr>
				<td width="20%"><?=!empty($svalue['username'])?$svalue['username']:''?></td>
				<td width="30%"><?=!empty($svalue['realname'])?$svalue['realname']:''?></td>
				<td width="30%"><?=!empty($svalue['classname'])?$svalue['classname']:''?></td>
				<td width="20%"><?=!empty($svalue['score'])?$svalue['score']:0?></td>
			</tr>
			<?php }?>
			<tr><td colspan="6" style="border-bottom:none;" align="center"></td></tr>
		<?php }else{?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
		<?php }?>
	</tbody>
	</table>
</div>
</div>
<div style="clear:both"></div>
<?=$pageStr?>
<script>
	$("#searchbutton").click(function(){
		var q = $("#search").val();
		if(q=="输入关键字搜索"){
			q="";
		}
		var url = '/aroomv2/student/schcreditreport-0-0-0-<?=$classid?>-<?=$grade?>'+'.html?q='+q;
		location.href=url;
	});
</script>
