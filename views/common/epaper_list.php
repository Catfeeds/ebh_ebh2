<?php $this->display('common/header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/epaper/jiaoxue.css" media="screen" />
<div class="xueziyuan">
<div class="toptitnew"><a href="/">首页</a> > <a href="/epaper.html">精品题库</a> > <?=$gradeName?></div>
<div class="weurrrje">
<a href="javascript:void(0)"><img src="http://static.ebanhui.com/ebh/images/epaper/banner.jpg" /></a>
</div>
<div class="soulan" style="margin-top:0px;">
  <input class="txtsole" name="textarea" type="text" id="keyword" value="<?=$keyword?>" />
  <a href="javascript:dosearch()" class="dlosle">搜索</a>
</div>
<div class="xiaosj" style="margin-top:10px;">
<table class="datatab" style="width:100%;">
<thead class="tabhead">
<tr class="">
<th>试卷名称</th>
<th>浏览/下载</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($epList as $onePaper){?>
<tr>
<td width="75%"><?=$onePaper['libname']?></td>
<td width="8%"><?=$onePaper['viewnum']?>/<?=$onePaper['downnum']?></td>
<td width="17%"><a href="/epaper/<?=$onePaper['lid']?>.html" class="erwkjsf" style="margin-right:5px;">预览</a><a href="/epaper/attach.html?lid=<?=$onePaper['lid']?>" class="erwkjsf">下载</a></td>
</tr>
<tr>
<?php }?>
<tr>
<tr><td colspan="4" align="center">共&nbsp;&nbsp;<?=$epCount?>&nbsp;&nbsp;条记录</td></tr>
</tbody>
</table>
</div>
<?=$showpage?>
</div>
<script type="text/javascript">
	function dosearch(){
		var keyword = $('#keyword').val();
		if(keyword=='输入您要搜索的试卷'){
			window.location.href="/<?=$uriPath?>.html";
		}else{
			window.location.href="/<?=$uriPath?>.html?keyword="+keyword;
		}
		
	}
	$(function(){
		$('#keyword').focus(function(){
			if($(this).val()=='输入您要搜索的试卷'){
				$(this).val('');
			}
		}).blur(function(){
			if($(this).val()==''){
				$(this).val('输入您要搜索的试卷');
			}
		});
		$('#keyword').trigger('blur');
	});
</script>
<div style="clear:both">
	
</div><!-- / -->
<?php $this->display('common/footer'); ?>
