<?php $this->display('common/header')?>
<style>
	.silder4 { width: 300px; height:230px; margin:0 auto; position: relative; overflow:hidden;}
  
  /*数字按钮样式*/
  .silder4 .num { overflow:hidden; height: 6px; position: absolute; bottom:10px; left: 73px; zoom:1; z-index:3 }
  .silder4 .num li { width: 6px; height: 6px;background: #E3E3E3; margin-right: 22px;  cursor:pointer; float: left; text-indent: -999px}
  .silder4 .num li.on { background: #0087FF; } /*当前项*/
  /*上一个  下一个*/
  .silder4 .prev,
  .silder4 .next { width: 19px; height: 18px;background: url(http://static.ebanhui.com/portal/images/btn.png) no-repeat;position: absolute; bottom: 4px;z-index: 99}
  .silder4 .prev { left: 36px;background-position:-14px -19px; }
  .silder4 .next { right: 42px; background-position: -40px -19px;  }
  .brandList li{float:left;}

  .silder3 { width: 310px; height:170px; margin:0 auto; position: relative; overflow:hidden;}
  .silder3 .prev,
  .silder3 .next{ width :35px; height: 35px; position: absolute; top: 70px;z-index: 99}
  .silder3 .prev{ background: url(http://static.ebanhui.com/portal/images/btnprev.png) no-repeat; left: 0px;}
  .silder3 .next{ background: url(http://static.ebanhui.com/portal/images/btnnext.png) no-repeat; right: 0px;}
  .silder3 .num { overflow:hidden; height: 6px; position: absolute; bottom:22px; left: 20; zoom:1; z-index:999 }
  .silder3 .msg,.silder3 .msgbackground { position:absolute; left:0; bottom:5px; z-index:99; text-align:center;width:310px;height: 26px;line-height: 26px;}
  .silder3 .msg{ color:#F0F6F8;}
  .silder3 .msgbackground{background-color: #000;z-index: 98}
  .silder3 .msgbackground{ 
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=20)"; /* ie8  */
    filter:alpha(opacity=20);    /* ie5-7  */
    opacity: 0.2;    /* css standard, currently it works in most modern browsers  */}
  .silder3 .msg a{ text-decoration: none;}
</style>
<?php
	$cssArr = array(
		'cat_css_29'=>'leico1',//新闻动态
		'cat_css_8'=>'leico2',//新闻动态
		'cat_css_15'=>'leico3',//校园在线
		'cat_css_22'=>'leico4',//趣味百科
		'cat_css_33'=>'leico5'//成长励志
	);
?>
<div class="wrapper">
<div class="gmrthd" style="margin-top:10px;">
<div class="lefjyrf">
<div class="eglieg">

<?php foreach ($menues as $key=>$menue) {?>
<?php if($key == 3){?>
<div class="ekgfer">
<a target="_blank" href="/itschool.html"><h2 class="leico1">网络教学 <span style="color:#ff851e;">></span></h2></a>
<ul style="width:200px;">
<li><a target="_blank" href="/cloudlist-1-4-0.html">
教学平台
</a></li>
<li><a target="_blank" href="/question.html">
互动答疑
</a></li>
<li><a target="_blank" href="/space.html">
原创空间
</a></li>
<li><a target="_blank" href="/free.html">
试听课件
</a></li>
<li><a target="_blank" href="/files.html">
常用工具
</a></li>
<li><a target="_blank" href="/itschool.html">
网络教学
</a></li>
</ul>
</div>
<?php }?>

<div class="ekgfer">
<a target="_blank" href="/<?=$menue['code']?>.html"><h2 class="<?=$cssArr['cat_css_'.$menue['catid']]?>"><?=$menue['name']?> <span style="color:#ff851e;">></span></h2></a>
<ul style="width:200px;">
<?php foreach ($menue['child'] as $subcat) {?>
<li><a target="_blank" href="/<?=$menue['code']?>-1-0-0-<?=$subcat['catid']?>.html">
<?=$subcat['name']?>
</a></li>
<?php }?>
</ul>
</div>
<?php }?>
</div>
<div class="egrths">
<h2 class="thrkd">教师风采</h2><a class="rguefd" target="_blank" href="/school-1-0-0-18.html">更多>></a>
<?php if(!empty($cat_img_18)){
	$catinfo = $cat_img_18[0];
?>
<a class="bfduid" target="_blank" href="/school/<?=$catinfo['itemid']?>.html" ><img width=130px height=98px  src="<?=$catinfo['thumb']?>">
</a>
<p class="regeg" style="border:none;margin:0;"><a target="_blank" href="/school/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>"><?=shortstr($catinfo['note'],74)?></a></p>
<?php }?>
<h2 class="thrkd" style="background-color:#fff;">状元心声</h2><a class="rguefd" style=" background:#fff;" target="_blank" href="/school-1-0-0-17.html">更多>></a>
<?php if(!empty($cat_img_17)){
	$catinfo = $cat_img_17[0];
?>
<a class="bfduid" target="_blank" href="/school/<?=$catinfo['itemid']?>.html"><img width=130px height=98px  src="<?=$catinfo['thumb']?>">
</a>
<p class="regeg" style="border:none;margin:0;"><a target="_blank" href="/school/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>"><?=shortstr($catinfo['note'],80)?></a></p>
<?php }?>
</div>
</div>
<div class="rightdk">
<div class="efkrteg">
<h2 class="thrkd" style="width:706px;">最新资讯</h2><a class="rguefd" href="/news.html">更多>></a>
<div class="rgjegd">
<div class="silder4">
    <ul class="buypic">
       <?php foreach ($ads_portal_gundong as $aad) {?>
          <li><a target="_blank"  href="<?=$aad['linkurl']?>" ><img width="300px" height="200px" src="<?=$aad['thumb']?>" alt="<?=$aad['subject']?>" /></a></li>
        <?php }?>
    </ul>
    <a target="_blank" class="prev" href="javascript:void(0)"></a>
    <a target="_blank" class="next" href="javascript:void(0)"></a>
    <div class="num">
      <ul></ul>
    </div>
</div>
</div>
<div class="rtige">
<?php if(!empty($cat_img_49)){
  $catinfo = $cat_img_49[0];
?>
<h2><a href="/news/<?=$catinfo['itemid']?>.html"><?=shortstr($catinfo['subject'],60)?></a></h2>
<p class="eggrvb" style="line-height:1.7"><?=shortstr($catinfo['note'],170,'……')?><a href="/news/<?=$catinfo['itemid']?>.html">>>查看详情</a></p>
<?php }?>
<ul>
<?php foreach ($eachNewOne as $key => $article) {?>
     <li>
            <a target="_blank" class="wectah"  href="<?=$upurl[$key]?>" title="<?=$upidname[$key]?>"><?=$upidname[$key]?></a>
            |
            <a target="_blank" title="<?=$article['subject']?>"  href="/<?=$upcode[$key]?>/<?=$article['itemid']?>.html" title="<?=$article['subject']?>"><?=shortstr($article['subject'],32,'')?></a>
      </li>
<?php }?>
</ul>
</div>
</div>
<div class="egfkgbb" style="margin-right:14px;">
<h2 class="thrkd" style="width:314px;">教育资讯</h2><a class="rguefd" target="_blank" href="/news-1-0-0-9.html">更多>></a>
<div class="ergoer">
<?php if(!empty($cat_img_9)){
	$catinfo = $cat_img_9[0];
?>
<a class="gkkimg" href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_9 as $catinfo) {?>
<p class="grgrgsd">
<a href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
<div class="egfkgbb">
<h2 class="thrkd" style="width:314px;">考试资讯</h2><a class="rguefd" target="_blank" href="/news-1-0-0-13.html">更多>></a>
<div class="ergoer">
<?php if(!empty($cat_img_13)){
	$catinfo = $cat_img_13[0];
?>
<a class="gkkimg" href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_13 as $catinfo) {?>
<p class="grgrgsd">
<a href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
<div class="egfkgbb" style="margin-right:14px;">
<h2 class="thrkd" style="width:314px;">校园之星</h2><a class="rguefd" target="_blank" href="/school-1-0-0-20.html">更多>></a>
<div class="ergoer">
<?php if(!empty($cat_img_20)){
	$catinfo = $cat_img_20[0];
?>
<a class="gkkimg" href="/itschool/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/itschool/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_20 as $catinfo) {?>
<p class="grgrgsd">
<a href="/itschool/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
<div class="egfkgbb">
<h2 class="thrkd" style="width:314px;">考试新政</h2><a class="rguefd" target="_blank" href="/news-1-0-0-11.html">更多>></a>
<div class="ergoer">
<?php if(!empty($cat_img_11)){
	$catinfo = $cat_img_11[0];
?>
<a class="gkkimg" href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_11 as $catinfo) {?>
<p class="grgrgsd">
<a href="/news/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
<div class="gnklgh">
<h2 class="thrkd" style="width:706px;">校园生活</h2><a class="rguefd" target="_blank" href="/school.html">更多>></a>
<div class="gvrhre">
<div class="ergoer">
<?php if(!empty($cat_img_21)){
	$catinfo = $cat_img_21[0];
?>
<a class="gkkimg" href="/school/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/school/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_21 as $catinfo) {?>
<p class="grgrgsd">
<a href="/school/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
<div class="grjesd">
<div class="silder3">
    <ul class="buypic">
       <?php foreach ($cat_scrollpic_21 as $catinfo) {?>
          <li><a target="_blank"  href="/school/<?=$catinfo['itemid']?>.html" ><img width="310px" height="170px" src="<?=$catinfo['thumb']?>" alt="<?=$catinfo['subject']?>" /></a></li>
        <?php }?>
    </ul>
    <a target="_blank" class="prev" href="javascript:void(0)"></a>
    <a target="_blank" class="next" href="javascript:void(0)"></a>
    <div class="num">
      <ul></ul>
    </div>
</div>
</div>
</div>
</div>
</div>
<?php if(!empty($ads_nav[0])){?>
<div class="kgrewg">
<!-- 通栏广告 -->
<a target="_blank"  href="<?=$ads_nav[0]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[0]['thumb']?>" />
</a>
</div>
<?php }?>
<div class="gmrthd">
<div class="lefjyrf">
<div class="efewewg">
<h2 class="thrkd" style="width:150px;">国学经典</h2><a class="rguefd" href="/motivation-1-0-0-34.html">更多>></a>
<ul style="margin:9px 0;float:left;">
<?php foreach ($cat_34 as $catinfo) {?>
<li style="height:25px;margin-left:10px;width:180px;" class="sdgtui"><a href="/motivation/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],29,'')?></a></li>
<?php }?>
</ul>
<h2 class="thrkd" style="width:150px;background-color:#fff;">感悟人生</h2><a class="rguefd" target="_blank" href="/motivation-1-0-0-35.html" style="background:#fff;">更多>></a>
<ul style="margin:9px 0;float:left;">
<?php foreach ($cat_35 as $catinfo) {?>
<li style="height:25px;margin-left:10px;width:180px;" class="sdgtui"><a href="/motivation/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],29,'')?></a></li>
<?php }?>
</ul>
</div>
<div class="egrths" style="height:224px;">
<h2 class="thrkd">创业故事</h2><a class="rguefd" target="_blank" href="/motivation-1-0-0-36.html">更多>></a>
<?php if(!empty($cat_img_36)){
	$catinfo = $cat_img_36[0];
?>
<a class="bfduid" target="_blank" href="/motivation/<?=$catinfo['itemid']?>.html"><img width=130px height=98px  src="<?=$catinfo['thumb']?>">
</a>
<p class="regeg" style="border:none;margin:0;"><a target="_blank" href="/motivation/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>"><?=shortstr($catinfo['note'],80)?></a></p>
<?php }?>
</div>
</div>
<div class="rightdk">
<div class="regkieu">
<h2 class="thrkd" style="width:706px;">千奇百怪</h2><a class="rguefd" target="_blank" href="/lfk-1-0-0-23.html">更多>></a>
<?php foreach ($cat_img_23 as $catinfo) {?>
<div class="cvgbiwe" style="margin:12px 0 6px 15px">
<a class="lektrs" href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=142px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="kigres">
<a href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],53)?></a>
</p>
<p class="ewgfkjs">
<?=shortstr($catinfo['note'],96)?>
</p>
</div>
<?php }?>
<?php foreach ($cat_23 as $k=>$catinfo) {?>
<p class="triudg" <?= $k<2?'style="margin-top:5px;"':''?> >
<a target="_blank" title="<?=$catinfo['subject']?>" href="/lfk/<?=$catinfo['itemid']?>.html"><?=shortstr($catinfo['subject'],54)?></a>
</p>
<?php }?>
</div>
<div class="egfkgbb" style="margin-right:14px;">
<h2 class="thrkd" style="width:314px;">糗事百科</h2><a class="rguefd" target="_blank" href="/lfk-1-0-0-24.html">更多>></a>
<div class="ergoer">
<?php if(!empty($cat_img_24)){
	$catinfo = $cat_img_24[0];
?>
<a class="gkkimg" href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_24 as $catinfo) {?>
<p class="grgrgsd">
<a href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
<div class="egfkgbb">
<h2 class="thrkd" style="width:314px;">百科杂谈</h2><a class="rguefd"  target="_blank" href="/lfk-1-0-0-25.html">更多>></a>
<div class="ergoer">
<?php if(!empty($cat_img_25)){
	$catinfo = $cat_img_25[0];
?>
<a class="gkkimg" href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank">
<img width=130px height=98px src="<?=$catinfo['thumb']?>">
</a>
<p class="hgersx">
<a href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],60)?></a>
</p>
<p class="gkergd">
<?=shortstr($catinfo['note'],96)?>
</p>
<?php }?>
</div>
<?php foreach ($cat_25 as $catinfo) {?>
<p class="grgrgsd">
<a href="/lfk/<?=$catinfo['itemid']?>.html" title="<?=$catinfo['subject']?>" target="_blank"><?=shortstr($catinfo['subject'],52)?></a>
</p>
<?php }?>
</div>
</div>
</div>
</div>
<script>
/*鼠标移过，左右按钮显示*/
$(".silder3").find(".prev,.next").hide();
$(".silder3").hover(function(){
  $(this).find(".prev,.next").fadeTo("show",0.2);
},function(){
  $(this).find(".prev,.next").hide();
});

/*鼠标移过某个按钮 高亮显示*/
$(".silder3 .prev,.silder3 .next").hover(function(){
  $(this).fadeTo("show",0.7);
},function(){
  $(this).fadeTo("show",0.2);
});
/*鼠标移过某个按钮 高亮显示*/
$(".silder4 .prev").hover(function(){
  $(this).css({ left: '36px',backgroundPosition:'-14px -1px'});
},function(){
  $(this).css({ left: '36px',backgroundPosition:'-14px -19px'});
});
$(".silder4 .next").hover(function(){
  $(this).css({ right: '42px',backgroundPosition:'-40px -1px'});
},function(){
  $(this).css({ right: '42px',backgroundPosition:'-40px -19px'});
});

$(".silder4").slide({ titCell:".num ul" , mainCell:".buypic" , effect:"fold", autoPlay:true, delayTime:1200 , autoPage:true });
$(".silder3").slide({ titCell:".num ul" , mainCell:".buypic" , effect:"leftLoop", autoPlay:true, delayTime:1200 , autoPage:true });

$(".newtit,.xiaotit,.titcheng,.quweitit")
.css('cursor','pointer')
.click(function(){
  var url = $(this).find('a[href!=""]').attr('href');
  if(url){
     window.open(url,'_blank');
  }
 
});
</script>
<?php $this->display('common/footer');?>
