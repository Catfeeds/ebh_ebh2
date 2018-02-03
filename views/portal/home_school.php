<?php $this->display('common/header');?>
<style>
	body {
		background:#fff;
	}
	.rugwumar { width: 659px; height:240px; margin:0 auto; position: relative; overflow:hidden;}
	/*数字按钮样式*/
	.rugwumar .num { overflow:hidden; height: 12px; position: absolute; bottom:12px; left: 488px; zoom:1; z-index:3 }
	.rugwumar .num li { width: 12px; height: 12px; line-height: 12px; text-align: center; font-weight: 400; font-family: "微软雅黑", Arial; color: #FFFFFF; background: #38b6f0; margin-right: 16px; border-radius:50%; cursor:pointer; float: left; text-indent: -999px}
	.rugwumar .num li.on { background: #3D3122; } /*当前项*/
	/*上一个  下一个*/
	.rugwumar .prev,
	.rugwumar .next { display: none; width: 40px; height: 100px; background: url(http://static.ebanhui.com/ebh/tpl/2012/images/btn.png) no-repeat; position: absolute; top: 70px;z-index: 99}
	.rugwumar .prev { left: 0; }
	.rugwumar .next { right: 0; background-position: right }
	.rugwumar div.cwrap{ position:absolute;right:0px;top:0px;width:247px;height:240px;background-color:#ededed;cursor: pointer;}
	.rugwumar p.ctitle{width: 200px;height:60px;position:absolute;left:24px;top:20px;overflow:hidden;font-size: medium;font-weight:bold;color:#000;line-height:30px;}
	.rugwumar p.ccontent{width: 200px;height:75px;position:absolute;left:24px;top:105px;line-height: 25px;font-size:12px;overflow:hidden;}
</style>
<div class="wrapper">
<?php if(!empty($ads_nav[0])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"   href="<?=$ads_nav[0]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[0]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="clearbox">
<div class="part_top2">
<div class="zehnne">
<h2 class="tittou"><a target="_blank"  style="color:#666;" title="<?=$top3_1[0]['subject']?>" href="/<?=$upcode?>/<?=$top3_1[0]['itemid']?>.html" style="color:#333;"><?=$top3_1[0]['subject']?></a></h2>
<p class="touxiang"><a target="_blank"  title="<?=$top3_1[0]['subject']?>" href="/<?=$upcode?>/<?=$top3_1[0]['itemid']?>.html"><?=shortstr($top3_1[0]['note'],80,'……[详情]')?></a></p>
</div>
<div class="tabcon">
<ul>
<?php foreach ($top1_5 as $value) {?>
	<li>
		<a target="_blank"  title="<?=$value['subject']?>" href="/<?=$upcode?>/<?=$value['itemid']?>.html" ><?=ssubstrch($value['subject'],0,40)?></a>
	</li>
<?php }?>
</ul>
</div>
</div>
<div class="rugwumar">
    <ul class="buypic">
        <?php foreach ($top2_4 as $article) {?>
    		 <li><a target="_blank"  href="/<?=$upcode?>/<?=$article['itemid']?>.html" ><img width="412px" height="240px" src="<?=$article['thumb']?>" /></a><div class="cwrap"><p class="ctitle"><?=strip_tags($article['subject'])?></p><p class="ccontent"><?=strip_tags($article['note'])?></p></div></li>
    	<?php }?>
    </ul>
    <a  class="prev" href="javascript:void(0)"></a>
    <a  class="next" href="javascript:void(0)"></a>
    <div class="num">
    	<ul></ul>
    </div>
</div>
</div>
<div class="kaonews">
<div class="newsdong">
<h2 class="newtit xsjy">
<span class="tit200">
<a target="_blank"  class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,0)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?=aHelper($cateTree,0,0,5,1)?>
</ul>
</div>
</div>
<div class="xiaoxian">
<h2 class="xiaotit zyxs">
<span class="tit540">
<a target="_blank"  class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,1)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-right:20px;">
<ul>
<?=aHelper($cateTree,0,1,5,1)?>
</ul>
</div>
<div class="xindong nonhet">
	<div class="gkkdiv">
		<?=aHelper($cateTree,0,1,1,9,-1)?>
	</div>
	<div class="gkkdiv" style="margin-bottom:0;">
		<?=aHelper($cateTree,0,1,1,9,-2)?>
	</div>
</div>
</div>
</div>
<div class="kaonews">
<div class="newsdong">
<?php $adsname = 'ads_news_bottomnavzuoshang_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"   class="adtop20" href="<?=$ads[0]['linkurl']?>">
	<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
<div class="xiaoxian">
<h2 class="xiaotit jsfc">
<span class="tit540">
<a target="_blank"  class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,2)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-right:20px;">
<ul>
<?=aHelper($cateTree,0,2,5,1)?>
</ul>
</div>
<div class="xindong nonhet">
	<div class="gkkdiv">
		<?=aHelper($cateTree,0,2,1,9,-1)?>
	</div>
	<div class="gkkdiv" style="margin-bottom:0;">
		<?=aHelper($cateTree,0,2,1,9,-2)?>
	</div>
</div>
</div>
</div>
<?php if(!empty($ads_nav[1])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"   href="<?=$ads_nav[1]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[1]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="kaonews">
<div class="xiaoxian" style="margin-left:0;margin-right:20px;">
<h2 class="xiaotit xymj">
<span class="tit540">
<a target="_blank"  class="huimore" style="font-size:12px;" href="<?=aMore($cateTree,-1,3)?>">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-right:20px;">
<ul>
<?=aHelper($cateTree,0,3,5,1)?>
</ul>
</div>
<div class="xindong nonhet">
<div class="gkkdiv">
<?=aHelper($cateTree,0,3,1,9,-1)?>
</div>
<div class="gkkdiv" style="margin-bottom:0;">
<?=aHelper($cateTree,0,3,1,9,-2)?>
</div>
</div>
</div>
<div class="newsdong">
<?php $adsname = 'ads_news_bottomnavyouxia_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"   class="adtop20" style="float:right;" href="<?=$ads[0]['linkurl']?>">
	<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
</div>
<div class="kaonews">
<div class="newsdong" style="margin-right:20px;">
<h2 class="newtit xyzx">
<span class="tit200">
<a target="_blank"  class="huimore" href="<?=aMore($cateTree,-1,4)?>" style="font-size:12px;">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?=aHelper($cateTree,0,4,5,1)?>
</ul>
</div>
</div>																																																																																																																																																																																																																																																																																																																																					

<div class="newsdong">
<h2 class="newtit xysh">
<span class="tit200">
<a target="_blank"  class="huimore" href="<?=aMore($cateTree,-1,5)?>" style="font-size:12px;">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?=aHelper($cateTree,0,5,5,1);?>
</ul>
</div>
</div>
<!-- ==== -->
<div class="newsdong" style="margin-left:20px;">
<h2 class="newtit ebhnews">
<span class="tit200">
<a target="_blank"  class="huimore"  href="/news-1-0-0-49.html" style="font-size:12px;">更多</a>
</span>
</h2>
<div class="xindong nonhet">
<ul>
<?php foreach ($newslist as $nk => $nv) {?>
<li class="content"><a target="_blank"  title="<?=$nv['subject']?>" href="/news/<?=$nv['itemid']?>.html" ><?=$nv['subject']?></a></li>
<?php }?>
</ul>
</div>
</div>
<!-- ==== -->
</div>
<?php if(!empty($ads_nav[2])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target="_blank"   href="<?=$ads_nav[2]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[2]['thumb']?>" />
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
<a target="_blank"  class="huimore" style="font-size:12px;" href="/<?=$upcode?>-1-1-0-<?=$catid?>.html">更多</a>
</span>
</h2>
<div class="titwemu">
<ul>
<?php foreach ($hotkeywords as $hotkeyword) {?>
	<li><a target="_blank"  href=""><?=$hotkeyword?></a></li>
<?php }?>

</ul>
</div>

</div>
<!-- ---- -->
<div class="newsdong">
<h2 class="newtit yueduopai">
<span class="tit200">
<a target="_blank"  class="huimore" style="font-size:12px;" href="/<?=$upcode?>-1-1-0-<?=$catid?>-0-1.html">更多</a>
</span>
</h2>
<div class="xindong nonhet" style="margin-top:10px;height:auto;">
<ul>
<?php foreach ($vtop10 as $key => $value) {?>
	<li class="yuedule">
	<span class="liebiao"><?=++$key?></span><a target="_blank"  title="<?=$value['subject']?>" href="/<?=$upcode?>/<?=$value['itemid']?>.html"><?=$value['subject']?></a>
	</li>
<?php }?>
</ul>
</div>

</div>

<div class="newsdong" style="margin-bottom:20px;margin-top:20px">
<?php $adsname = 'ads_lfk_left_'.$catid;$ads = $$adsname;?>
<?php if(!empty($ads[0]['thumb'])){?>
<a target="_blank"    href="<?=$ads[0]['linkurl']?>">
	<img width="320px" height="180px" src="<?=$ads[0]['thumb']?>" />
</a>
<?php }?>
</div>
<!-- ====== -->
<div style="clear:both"></div>
<div>
<h2 class="xiaobiao">
<span class="jiejefu"><a target="_blank"  href="/free.html" >免费试听</a></span>
</h2>
<ul>
<?php foreach ($ads_free as $key => $free) {?>
    <?php 
      $freeurl = empty($free['linkurl'])?'#':$free['linkurl'];
      $thumb = empty($free['thumb'])?'#':$free['thumb'];
    ?>
     <li class="mianting" <?php if($key==1){echo 'style="width:150px"';}?> >
            <a target="_blank"   title="<?=$free['subject']?>" class="linkting"  href="<?=$freeurl?>"><div class="kewent"><img width="144px" height="90px" src="<?=$thumb?>" /></div>
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
<a target="_blank"  class="huimore" href="/<?=$upcode?>-1-0-0-<?=$catid?>.html" style="font-size:12px;">更多</a>
</span>
</h2>
<ul>
<?php foreach ($articleList as $article) { ?>
	<li class="navlie">
	<h2 class="navlietit"><a target="_blank"  title="<?=$article['subject']?>" href="/<?=$upcode?>/<?=$article['itemid']?>.html" ><?=shortstr($article['subject'],50,'')?></a></h2>
	<p class="martopbtm">发表于：<?=date("Y-m-d",$article['dateline'])?>  阅读<?=$article['viewnum']?>次  <?=$article['reviewnum']?>条评论</p>
	<a target="_blank"  title="<?=$article['subject']?>" href="/<?=$upcode?>/<?=$article['itemid']?>.html" ><img width="130px" height="98px" src="<?=empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb']?>" /></a>
	<p class="tiwes"><?=shortstr($article['note'],260)?></p>
	<p style="width:120px;height:24px;line-height:24px;font-size:16px;color:#666">类别：<?=$article['name']?></p>
	<a target="_blank"  href="/<?=$upcode?>/<?=$article['itemid']?>.html" class="yuedubtn">阅读全文</a>
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
