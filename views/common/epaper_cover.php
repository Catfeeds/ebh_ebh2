<?php $this->display('common/header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/epaper/jiaoxue.css" media="screen" />
<div class="xueziyuan">
<div class="toptitnew"><a href="/">首页</a> > 精品题库</div>
<div class="soulan">
  <input class="txtsole" name="textarea" type="text" id="keyword" value="<?=empty($keyword)?'输入您要搜索的试卷':$keyword?>" />
  <a href="/epaper/eplist.html" onclick="return dosearch()" class="dlosle">搜索</a>
</div>
<div class="xiaosj">
<h2 class="xiaoh2"><img src="http://static.ebanhui.com/ebh/images/epaper/titxiao0326.jpg" /></h2>
<ul>
<?php foreach ($primarySchool as $key=>$primarySchoolGrade){
		 if($key ==5 || $key == 11 || $key == 17 || $key == 23 ){ ?>
<li style="margin-right:0px;">
	<?php }else{ ?>
    	<li>
	<?php } ?> 
	<a href="/epaper/eplist-0-0-0-1-<?=$primarySchoolGrade['gid']?>.html"><div class="fewioe"><img src="http://static.ebanhui.com/ebh<?=$primarySchoolGrade['img']?>" /></div></a>
	<p><a href="/epaper/eplist-0-0-0-1-<?=$primarySchoolGrade['gid']?>.html"><?=$primarySchoolGrade['groupname']?>（<?=$primarySchoolGrade['lnum']?>）</a></p>
</li>	
<?php }?>
</ul>
</div>
<div class="xiaosj">
<h2 class="xiaoh2"><img src="http://static.ebanhui.com/ebh/images/epaper/titchu0326.jpg" /></h2>
<ul>
<?php foreach ($middleSchool as $key=>$middleSchoolGrade){
		 if($key ==5 || $key == 11 || $key == 17 || $key == 23 ){ ?>
<li style="margin-right:0px;">
	<?php }else{ ?>
    	<li>
	<?php } ?> 
	<a href="/epaper/eplist-0-0-0-7-<?=$middleSchoolGrade['gid']?>.html"><div class="fewioe"><img src="http://static.ebanhui.com/ebh<?=$middleSchoolGrade['img']?>" /></div></a>
	<p><a href="/epaper/eplist-0-0-0-7-<?=$middleSchoolGrade['gid']?>.html"><?=$middleSchoolGrade['groupname']?>（<?=$middleSchoolGrade['lnum']?>）</a></p>
</li>	
<?php }?>
</ul>
</div>
<div class="xiaosj">
<h2 class="xiaoh2"><img src="http://static.ebanhui.com/ebh/images/epaper/titgao0326.jpg" /></h2>
<ul>
<?php foreach ($highSchool as $key=>$highSchoolGrade){
		 if($key ==5 || $key == 11 || $key == 17 || $key == 23 ){ ?>
<li style="margin-right:0px;">
	<?php }else{ ?>
    	<li>
	<?php } ?> 
	<a href="/epaper/eplist-0-0-0-10-<?=$highSchoolGrade['gid']?>.html"><div class="fewioe"><img src="http://static.ebanhui.com/ebh<?=$highSchoolGrade['img']?>" /></div></a>
	<p><a href="/epaper/eplist-0-0-0-10-<?=$highSchoolGrade['gid']?>.html"><?=$highSchoolGrade['groupname']?>（<?=$highSchoolGrade['lnum']?>）</a></p>
</li>	
<?php }?>
</ul>
</div>

</div>
<script type="text/javascript">
	function dosearch(){
		var keyword = $('#keyword').val();
		if(keyword=='输入您要搜索的试卷'){
			return false;
		}
		window.location.href="/epaper/eplist.html?keyword="+keyword;
		return false;
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
	});
</script>
<div style="clear:both"></div>
<?php $this->display('common/footer');?>
