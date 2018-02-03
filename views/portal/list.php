<?php $this->display('common/header');?>
<style>
	.stleft .newsxiao li{
		margin: 0 18px;
	}
	body {
		background:#fff;
	}
</style>
<div class="wrapper">
<?php $q = safeHtml($this->input->get('q'));?>
<?php if(!empty($ads_nav[0])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"   href="<?=$ads_nav[0]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[0]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="clearbox">
<div class="stleft">
<div class="newsxiao" style="height:auto;overflow:hidden;">
<ul>
<?php $familyCates = $this->getChildrenCates(false);?>
<li><a target="_blank"  <?php if(!empty($familyCates) && $catid==$familyCates[0]['upid']){echo 'style="color:#0085f6"';}?> href="/<?=$upcode?>-1-0-0-<?=$familyCates[0]['upid']?>.html">所有类别</a></li>
<?php foreach($familyCates as $fcate) {?>
	<li><a target="_blank"  <?php if($catid==$fcate['catid']){echo 'style="color:#0085f6"';}?> href="/<?=$upcode?>-1-0-0-<?=$fcate['catid']?>.html"><?=$fcate['name']?></a></li>
<?php }?>

</ul>
</div>
<div class="soudiv">
<input id="listsearch" class="txtsou" name="textarea" type="text" value="<?=empty($q)?'请输入要查找的关键字':$q?>" />
<a target="_blank"  href="#" onclick="_search()" class="liesoubtn">搜索</a>
</div>
<ul>
	<?php if(empty($articleList)){?>
		<li  style="width:auto;text-align: center;border-bottom: 1px none #D1D1D1; margin-top: 40px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuzixun_03.jpg" /></li>
	<?php }else{ ?>
		<?php foreach ($articleList as $article) { ?>
			<li class="navlie">
			<h2 class="navlietit"><a target="_blank"  title="<?=$article['subject']?>" href="/<?=$upcode?>/<?=$article['itemid']?>.html"><?=shortstr($article['subject'],50,'')?></a></h2>
			<p class="martopbtm">发表于：<?=date("Y-m-d",$article['dateline'])?>  阅读<?=$article['viewnum']?>次  <?=$article['reviewnum']?>条评论</p>
			<a target="_blank"  href="/<?=$upcode?>/<?=$article['itemid']?>.html"><img width="130px" height="98px" src="<?=empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb']?>" /></a>
			<p class="tiwes"><?=shortstr($article['note'],180,'...')?></p>
			<a target="_blank"  href="/<?=$upcode?>/<?=$article['itemid']?>.html" class="yuedubtn">阅读全文</a>
			</li>
		<?php }?>
	<?php }?>
</ul>
<?=$pageStr?>
</div>
<div class="strig">
<div class="newsdong" style="margin-bottom:10px;">
<?php $adsname = 'ads_list_youshang_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"   href="<?=$ads[0]['linkurl']?>">
<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
<div class="newsdong">
<h2 class="newtit zuixintuijian">
<span class="tit200">
<a target="_blank"  class="huimore" style="font-size:12px;" href="/<?=$upcode?>-1-4-0-<?=$catid?>.html">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-top:10px;height:195px;">
<ul>
<?php foreach ($top6 as $key => $value) {?>
	<li class="yuedule">
		<span class="liebiao"><?=++$key?></span><a target="_blank"  title="<?=$value['subject']?>" href="/<?=$upcode?>/<?=$value['itemid']?>.html"><?=ssubstrch($value['subject'],0,44)?></a>
	</li>
<?php }?>
</ul>
</div>
</div>
<div class="newsdong" style="margin-top:20px;margin-bottom:10px;">
<?php $adsname = 'ads_list_youxia_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"   title="<?=$ads[0]['subject']?>" href="<?=$ads[0]['linkurl']?>">
<img alt="<?=$ads[0]['subject']?>" width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
<div class="newsdong">
<h2 class="newtit yuedupaihang">
<span class="tit200">
<a target="_blank"  class="huimore" style="font-size:12px;" href="/<?=$upcode?>-1-1-0-<?=$catid?>.html">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-top:10px;height:195px;">
<ul>
<?php foreach ($vtop6 as $key => $value) {?>
	<li class="yuedule">
		<span class="liebiao"><?=++$key?></span><a target="_blank"  title="<?=$value['subject']?>" href="/<?=$upcode?>/<?=$value['itemid']?>.html"><?=ssubstrch($value['subject'],0,44)?></a>
	</li>
<?php }?>
</ul>
</div>
</div>
</div>
</div>
</div>
<script>
	$(function(){
		initsearch("listsearch","请输入要查找的关键字");
	});
	function _search(){
		var q = $("#listsearch").val();
		if(q=='请输入要查找的关键字'){
			location.href="/<?=$this->uri->codepath?>"+"-1-0-0-<?=$catid?>.html";
		}else{
			location.href="/<?=$this->uri->codepath?>"+"-1-0-0-<?=$catid?>.html?q="+q;
		}
		
	}
</script>
<?php $this->display('common/footer');?>