<?php $this->display('common/header');?>
<style>
	body {
		background:#fff;
	}
</style>
<div class="wrapper">
<?php if(!empty($ads_nav[0])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"  href="<?=$ads_nav[0]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[0]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="clearbox">
<div class="wenshuo">
<ul>
<?php foreach ($importantnews as $newskey => $onenews) {?>
	<li <?=$newskey==3?'style="border-bottom:none;"':''?>>
		<h2><a target="_blank" style="color:#3a4276" title="<?=$onenews['subject']?>" href="/<?=$upcode?>/<?=$onenews['itemid']?>.html"><?=shortstr($onenews['subject'],36,'')?></a></h2>
		<p>	
			<a target="_blank" href="/<?=$upcode?>/<?=$onenews['itemid']?>.html"><?=shortstr(trim(strip_tags($onenews['note'])),100,'')?></a>
		</p>
	</li>
<?php }?>

</ul>
</div>
<div class="tushuo">
<?php foreach ($top2_2 as $top22key => $top22value) {?>
	<div style="margin-top:<?=($top22key+1)*10?>px;float:left;">
	<a target="_blank" title="<?=$top22value['subject']?>" href="/<?=$upcode?>/<?=$top22value['itemid']?>.html"><img alt="<?=$top22value['subject']?>" width=277px height=161px src="<?=$top22value['thumb']?>" /></a>
	<h3 class="etkt"><a target="_blank" title="<?=$top22value['subject']?>" href="/<?=$upcode?>/<?=$top22value['itemid']?>.html"><?=shortstr($top22value['subject'],36,'')?></a></h3>
	</div>
<?php }?>

</div>
<div class="newre">
<h2 class="tiweser">最新资讯<a target="_blank" class="huimore" style="font-size:12px;" href="/news-1-0-0-49.html">更多</a></h2>
<?php if(!empty($importantEnews[0])){?>
	<p class="tolep"><a target="_blank" title="<?=$importantEnews[0]['subject']?>" href="/<?=$upcode?>/<?=$importantEnews[0]['itemid']?>.html"><?=shortstr($importantEnews[0]['subject'],36,'')?></a></p>
	<a target="_blank" style="float:left;" href="/<?=$upcode?>/<?=$importantEnews[0]['itemid']?>.html"><img alt="<?=$importantEnews[0]['subject']?>" width=100px height=62px src="<?=empty($importantEnews[0]['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$importantEnews[0]['thumb']?>" /></a>
	<a target="_blank" href="/<?=$upcode?>/<?=$importantEnews[0]['itemid']?>.html" class="fxiat"><?=shortstr($importantEnews[0]['note'],76,'')?>[详细]</a>
<?php }?>
<ul>
<?php if(!empty($importantEnews[1])){?>
<li class="content" style="width:290px;">
<a target="_blank" href="/<?=$upcode?>/<?=$importantEnews[1]['itemid']?>.html" title="<?=$importantEnews[1]['subject']?>" ><?=shortstr($importantEnews[1]['subject'],36,'')?></a>
</li>
<?php }?>
<?php if(!empty($importantEnews[2])){?>
<li class="content" style="width:290px;">
<a target="_blank" href="/<?=$upcode?>/<?=$importantEnews[2]['itemid']?>.html" title="<?=$importantEnews[2]['subject']?>" ><?=shortstr($importantEnews[2]['subject'],36,'')?></a>
</li>
<?php }?>
</ul>
<h2 class="tiweser" style="margin-top:15px;">热门话题</h2>
<ul style="margin-top:4px;float:left;">

<?php foreach ($hot1_6 as $hot16key => $hot16value) {?>
<li class="yuedulese">
<span class="liebiaose"><?=1+$hot16key?></span>
<a target="_blank" href="/<?=$upcode?>/<?=$hot16value['itemid']?>.html" style="font-size:14px;" title="<?=$hot16value['subject']?>" ><?=shortstr($hot16value['subject'],36,'')?></a>
</li>
<?php }?>

</ul>
</div>


</div>
<?php if(!empty($ads_nav[1])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"  href="<?=$ads_nav[1]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[1]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="kaonews">
<div class="newsdong">
<h2 class="newtit kaotit">
<span class="tit200">
<a target="_blank" class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,2)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?=aHelper($cateTree,0,2,5,1)?>
</ul>
</div>
</div>
<div class="xiaoxian">
<h2 class="xiaotit zhengfatit">
<span class="tit540">
<a target="_blank" class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,0)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-right:20px;">
<ul>
<?=aHelper($cateTree,0,0,5,1)?>
</ul>
</div>
<div class="xindong nonhet">
	<div class="gkkdiv">
		<?=aHelper($cateTree,0,0,1,9,-1)?>
	</div>
	<div class="gkkdiv" style="margin-bottom:0;">
		<?=aHelper($cateTree,0,0,1,9,-2)?>
	</div>
</div>
</div>
</div>
<div class="kaonews">
<div class="newsdong">
<?php $adsname = 'ads_news_bottomnavzuoshang_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"  class="adtop20" href="<?=$ads[0]['linkurl']?>">
	<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
<div class="xiaoxian">
<h2 class="xiaotit zgkaotit">
<span class="tit540">
<a target="_blank" class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,4)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-right:20px;">
<ul>
<?=aHelper($cateTree,0,4,5,1)?>
</ul>
</div>
<div class="xindong nonhet">
	<div class="gkkdiv">
		<?=aHelper($cateTree,0,4,1,9,-1)?>
	</div>
	<div class="gkkdiv" style="margin-bottom:0;">
		<?=aHelper($cateTree,0,4,1,9,-2)?>
	</div>
</div>
</div>
</div>
<?php if(!empty($ads_nav[2])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"  href="<?=$ads_nav[2]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[2]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="kaonews">
<div class="xiaoxian" style="margin-left:0;margin-right:20px;">
<h2 class="xiaotit xiaonewtit">
<span class="tit540">
<a target="_blank" class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,5)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-right:20px;">
<ul>
<?=aHelper($cateTree,0,5,5,1)?>
</ul>
</div>
<div class="xindong nonhet">
<div class="gkkdiv">
<?=aHelper($cateTree,0,5,1,9,-1)?>
</div>
<div class="gkkdiv" style="margin-bottom:0;">
<?=aHelper($cateTree,0,5,1,9,-2)?>
</div>
</div>
</div>
<div class="newsdong">
<?php $adsname = 'ads_news_bottomnavyouxia_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"  class="adtop20" style="float:right;" href="<?=$ads[0]['linkurl']?>">
	<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
</div>
<div class="kaonews">
<div class="newsdong" style="margin-right:20px;">
<h2 class="newtit jiaoyantit">
<span class="tit200">
<a target="_blank" class="huimore" href="<?=aMore($cateTree,-1,1)?>" style="font-size:12px;">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?=aHelper($cateTree,0,1,5,1)?>
</ul>
</div>
</div>																																																																																																																																																																																																																																																																																																																																					

<div class="newsdong">
<h2 class="newtit zhengfatit">
<span class="tit200">
<a target="_blank" class="huimore" href="<?=aMore($cateTree,-1,3)?>" style="font-size:12px;">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?=aHelper($cateTree,0,3,5,1);?>
</ul>
</div>
</div>
<!-- ==== -->
<div class="newsdong" style="margin-left:20px;">
<h2 class="newtit ebhnews">
<span class="tit200">
<a target="_blank" class="huimore"  href="/news-1-0-0-49.html" style="font-size:12px;">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?php foreach ($newslist as $nk => $nv) {?>
<li class="content"><a target="_blank" title="<?=$nv['subject']?>" href="/news/<?=$nv['itemid']?>.html" ><?=$nv['subject']?></a></li>
<?php }?>
</ul>
</div>
</div>
<!-- ==== -->
</div>
<?php if(!empty($ads_nav[3])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"  href="<?=$ads_nav[3]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[3]['thumb']?>" />
</a>
</div>
<?php }?>
<!-- =================================== -->
<div class="clearbox">
<div class="lefquwei" style="margin-top:10px;margin-bottom:10px">
<!-- ---- -->
<div class="newsdong">
<h2 class="newtit gjzss">
<span class="tit200">
<a target="_blank" class="huimore" style="font-size:12px;" href="/<?=$upcode?>-1-1-0-<?=$catid?>.html">更多</a>
</span>
</h2>
<div class="titwemu">
<ul>
<?php foreach ($hotkeywords as $hotkeyword) {?>
	<li><a target="_blank" href=""><?=$hotkeyword?></a></li>
<?php }?>

</ul>
</div>

</div>
<!-- ---- -->
<div class="newsdong">
<h2 class="newtit yueduopai">
<span class="tit200">
<a target="_blank" class="huimore" style="font-size:12px;" href="/<?=$upcode?>-1-1-0-<?=$catid?>-0-1.html">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-top:10px;height:auto;">
<ul>
<?php foreach ($vtop10 as $key => $value) {?>
	<li class="yuedule">
	<span class="liebiao"><?=++$key?></span><a target="_blank" title="<?=$value['subject']?>" href="/<?=$upcode?>/<?=$value['itemid']?>.html"><?=$value['subject']?></a>
	</li>
<?php }?>
</ul>
</div>

</div>

<div class="newsdong" style="margin-bottom:20px;margin-top:20px">
<?php $adsname = 'ads_lfk_left_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"   href="<?=$ads[0]['linkurl']?>">
	<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
<!-- ====== -->
<div style="clear:both"></div>
<div>
<h2 class="xiaobiao">
<span class="jiejefu"><a target="_blank" href="/free.html" >免费试听</a></span>
</h2>
<ul>
<?php foreach ($ads_free as $key => $free) {?>
    <?php 
      $freeurl = empty($free['linkurl'])?'#':$free['linkurl'];
      $thumb = empty($free['thumb'])?'#':$free['thumb'];
    ?>
     <li class="mianting" <?php if($key==1){echo 'style="width:150px"';}?> >
            <a target="_blank"  title="<?=$free['subject']?>" class="linkting"  href="<?=$freeurl?>"><div class="kewent"><img width="144px" height="90px" src="<?=$thumb?>" /></div>
                  <p><span>免</span><?=shortstr($free['subject'],20,'')?></p>
                  <p><?=shortstr(strip_tags($free['message']),20)?></p>
            </a>
      </li>
<?php }?>
</ul>
</div>
<!-- ===== -->
</div>

<div class="rigquwei">
<div class="stleft" style="margin:0;">
<h2 class="quweilit">
<span class="tit540">
<a target="_blank" class="huimore" href="/<?=$upcode?>-1-0-0-<?=$catid?>.html" style="font-size:12px;">更多</a>
</span>
</h2>
<ul>
<?php foreach ($articleList as $article) { ?>
	<li class="navlie">
	<h2 class="navlietit"><a target="_blank" title="<?=$article['subject']?>" href="/<?=$upcode?>/<?=$article['itemid']?>.html" ><?=shortstr($article['subject'],50,'')?></a></h2>
	<p class="martopbtm">发表于：<?=date("Y-m-d",$article['dateline'])?>  阅读<?=$article['viewnum']?>次  <?=$article['reviewnum']?>条评论</p>
	<a target="_blank" title="<?=$article['subject']?>" href="/<?=$upcode?>/<?=$article['itemid']?>.html" ><img width="130px" height="98px" src="<?=empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb']?>" /></a>
	<p class="tiwes"><?=shortstr($article['note'],260)?></p>
	<p style="width:120px;height:24px;line-height:24px;font-size:16px;color:#666">类别：<?=$article['name']?></p>
	<a target="_blank" href="/<?=$upcode?>/<?=$article['itemid']?>.html" class="yuedubtn">阅读全文</a>
	</li>
<? }?>
</ul>

</div>
</div>
</div>
</div>
<!-- ===================================== -->
</div>

<script>
/*鼠标移过，左右按钮显示*/
$(".rugwumar").hover(function(){
	$(this).find(".prev,.next").fadeTo("show",0.2);
},function(){
	$(this).find(".prev,.next").hide();
})
/*鼠标移过某个按钮 高亮显示*/
$(".prev,.next").hover(function(){
	$(this).fadeTo("show",0.7);
},function(){
	$(this).fadeTo("show",0.2);
})
$(".rugwumar").slide({ titCell:".num ul" , mainCell:".buypic" , effect:"fade", autoPlay:true, delayTime:1200 , autoPage:true });
$(".rugwumar div.cwrap").click(function(){
	var url = $(this).siblings('a').attr('href');
	window.open(url,'_blank');
});
$(function(){
	$('div.newsdong h2,div.xiaoxian h2')
	.click(function(){
		var url = $(this).find("a").attr("href");
		window.open(url,"_blank");
	})
	.css("cursor","pointer");
});

$(function(){
	$("div.titwemu:first li a").click(function(){
		var q = $(this).html()
		location.href = "<?=$this->uri->codepath?>-1-0-0-<?=$catid?>.html?q="+q;
		return false;
	});		
});
</script>

<!-- 代码 结束 -->
<?php $this->display('common/footer');?>
