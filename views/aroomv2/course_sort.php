<?php
$this->display('aroomv2/page_header')?>
<?php $v=getv();?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/coursesort.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/simpletree.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<style>


</style>

	<div class="ter_tit">
        当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; 课程分类管理
	</div>
	<div class="banjiguanli_top fr">
		<ul>
			<li class="fl">
			<a href="javascript:void(0)" class="theaddbtn" idtype="splist">新建一级分类</a>
			</li>
		</ul>
	</div>
	
	<div class="sortmainc">
		<div id="splist" class="splist">
		</div>
	</div>
	<div id="dialogdel" style="margin-top:20px;display:none">该分类下的课程将自动转移到未分类的类别中</div>

<script>
var simpletree = new Simpletree();
simpletree.init('splist',true).start();
</script>
</body>
<html>