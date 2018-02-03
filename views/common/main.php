<?php $menuactiveid=2 ?>	
<?php
$this->display('common/header');
?>
<?php 
	$sortmode = $this->uri->sortmode;
	$sortmode = empty($sortmode)?0:$sortmode;
	$q = $this->input->get('q');
	$page = $this->uri->page;
?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/yinan.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.wrap,.bottom,.cservice img,.cbuyclass,.log');   
</script>
<![endif]-->
<div class="toptitnew"><a href="/">首页</a> > 课件搜索</div>
<div class="waimin">
<div class="lefyuan">
<div class="icategry" style="border-top:none;width:760px;">
<div class="etryk" style="border-bottom:solid 1px #e3e3e3;width:758px;">
<dt style="line-height:30px;width:60px;padding-left:15px;">排序：</dt>
<dd style="margin-top: 3px;width:666px;">
<div class="tit_wenti">
<ul>
<li class="buty <?=$sortmode==0?'selectBtnd':''?>">
<a style="text-decoration:none;" href="/main-1-0-0-0-0-0.html?q=<?=$q?>">默认推荐</a>
</li>
<li class="buty <?=$sortmode==1?'selectBtnd':''?>">
<a style="text-decoration:none;" href="/main-1-1-0-0-0-0.html?q=<?=$q?>">更新时间</a>
</li>
<li class="buty <?=$sortmode==2?'selectBtnd':''?>">
<a style="text-decoration:none;" href="/main-1-2-0-0-0-0.html?q=<?=$q?>">课件人气</a>
</li>
</ul>
<!-- <a class="tijibtn dialogLogin" href="javascript:;" name="/member/myask/addquestion.html">我要提问</a> -->
</div>
</dd>
</div>
<div class="ptjia" style="width: 740px;">
<p style="float:left;margin-top:6px;color:#969696;">课件索引（共有<span style="color:#398dcb;" id="count"><?=$courselistCount?></span>个符合条件的课件）</p>
<div style="float:right">
<?php
	if(($q=='输入要搜索的课件')||empty($q)){
		$color = '#c8c8c8';
	}else{
		$color = '#000';
	}
?>
<input class="iptsou" id="title" type="text" style="color:<?=$color?>" value="<?=empty($q)?'输入要搜索的课件':$q?>">
<a class="alinkbtn"  href="javascript:" onclick="return mysearch();return false;">确 定</a>
</div>
</div>
</div>
<div class="xuekhen">
<ul>
<?php if(!empty($courselist)){?>
<?php 
	foreach($courselist as $course){
 		$roomurl = 'http://'.$course['domain'].'.ebh.net';
?>

<li class="lixuet">
<div class="flefxue">
<h2 class="kenamt"><a href="javascript:void(0)" title="<?=$course['title']?>">课件：<?=shortstr(strip_tags($course['title']),60,'')?></a></h2>
<p class="plett"><span style="float:left;height:30px;">摘要：</span><?=shortstr(strip_tags($course['summary']),150,'...')?></p>
<p class="plett" style="margin-top:15px;">时间：<?=date('Y-m-d H:s',$course['dateline'])?>  讲师：<?=empty($course['realname'])?$course['username']:$course['realname']?></p>
</div>
<div class="frigxue">
<h2 class="xuemant"><a href="<?=$roomurl?>" title="<?=$course['crname']?>" ><?=shortstr($course['crname'],36,'')?></a></h2>
<a href="<?=$roomurl?>" title="<?=$course['crname']?>" class="jinrubtn">马上进入</a>
</div>
</li>
<?php }?>

</ul>
<?=$showpage?>
<?php }else{?>
	无符合条件的课件
<?php }?>
</div>

</div>
<div class="rigaddt">
<div class="adauto">
<a href="/down.html">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/ad140818001.jpg">
</a>
</div>
<div class="kuanga">
<h2 class="twohei">最新课件</h2>
<div class="addt">
<ul>
<?php foreach ($latestlist as $lkey => $lvalue) {?>
	<li class="datidt">
		<span class="liebiao" style="background:#a9bd44;"><?=1+$lkey?></span>
		<a href="/course/<?=$lvalue['cwid']?>.html"><?=shortstr(strip_tags($lvalue['title']),24,'...')?></a>
	</li>
<?php }?>


</ul>
</div>
</div>
</div>

</div>


<div style="clear:both;"></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/effect_commonv1.1.js"></script>
<script type="text/javascript" >new dk_slideplayer("#actor",{width:"500px",height:"273px",fontsize:"12px",time:"5000"});</script>
<script type="text/javascript">
	function mysearch(){
		var title = $("#title").val();
		title = (title=='输入要搜索的课件'?'':title);
		var url = '/main-1-<?=$sortmode?>.html?q='+title;
		location.href = url;
	}

	$("#title")
		.focus(function(){
			$(this).val($.trim($(this).val()));
			if($(this).val()=="输入要搜索的课件"){
				this.style.color = "#000"; 
				$(this).val('');
			}
		})
		.blur(function(){
			$(this).val($.trim($(this).val()));
			if($(this).val()==""){
				this.style.color = "#c8c8c8";
				$(this).val('输入要搜索的课件');
			}
		});

</script>
<?php
    $this->display('common/footer');
?>