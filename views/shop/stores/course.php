<?php $this->display('shop/stores/stores_header'); ?>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<style type="text/css">
.tisku {
	height: 185px;
	width: 385px;
}
.tisku p {
	float: left;
	width: 230px;
	margin-left: 25px;
	_margin-left: 12px;
	font-size: 14px;
	color: #666;
	font-weight: bold;
	line-height: 1.8;
}
.top50 {
	margin-top:50px;
}
.tisku img {
	float:right;
	margin-right:20px;
	margin-top:20px;
}
 #dialogdivs {
	display:none;
}
</style>
<script type="text/javascript">
<!--
	function back() {
		var theurl = "<?= geturl('studyline')?>";
		document.location.href = theurl;
	}
	function showdialogs(){
		$("#dialogdivs").dialog("open");
	}
			
	$(function(){
		$("#dialogdivs").dialog({
			modal: true, 
			autoOpen:false,
			bgiframe:true,
			draggable:false,
			title:'温馨提示',
			width:400,
			height:270
		});
		var cwid = <?= $coursedetail['cwid'] ?>;
		var source = "<?= $coursedetail['cwsource'] ?>";
        var isfree = <?= $coursedetail['isfree'] ?>;
        var num = 0; //教室内
		playflv(source,cwid, '', isfree, num, '562', '900');
	});
	function closeLightFun(opens){	//开关灯方法
	
	$("#showdiv").css("height", $(document).height());
		if(opens==1){
			$("#showdiv").toggle();  
		}
		else if((opens==2)){
			$("#showdiv").toggle(); 
		}
}
//-->
</script>

<div style="display:none;" class="Offl" id="showdiv"></div>
<div class="main">
<div class="dtzhix">

<div class="topkuang"></div>
<div class="zixun">

<!--xiangqing start-->

<?php 
if(empty($user)){
	$cloudaddurl="/classactive.html";
}else{
	if($user['groupid'] == 6){
		$cloudaddurl="/classactive.html";
	}else{
		$cloudaddurl="javascript:alert('您是云教育网校的教师，不可以加入');";
	}	
}
?>
<div class="rigxiang">
<h3 class="rigxiang_h3">课件详情</h3>

<?php if(preg_match("/.*(\.flv)$/",$coursedetail['cwurl'])){ ?>
<div class="xiangqy" style="padding-bottom:572px;float:left;">
<?php }else{ ?>
<div class="xiangqy" style="float:left;">
<?php } ?>
<h4 class="xiangqy_h4" style="color:#2668e3;"><?= $coursedetail['title']?></h4>
<p class="tilie">主讲：<span style="margin-right:10px;"><?= $coursedetail['realname']?></span> 时间：<span><?= date('Y-m-d',$coursedetail['dateline'])?></span>
<?php if($coursedetail['isfree']!=1){ ?>
<?php if($room['isschool'] == 4){ ?>
<span style="color:red;">&nbsp;&nbsp;（注：播放本课件需扣除<?= round($coursedetail['fprice'],2)?>学点，30分钟内可以免费重复播放学习。<a href="/sitecp.php?action=classrbalance" title="购买学点" style="color:blue" target="_blank">购买学点</a>）</span>
<?php }else{ ?>
<span style="color:red;">&nbsp;&nbsp;（注：此课件需要开通本平台服务后才能播放。<a href="<?= $cloudaddurl?>" title="在线购买" style="color:blue">在线购买</a>）</span>
<?php } ?>
</p>
<?php } ?>
<p class="zitiao">摘要：<?= $coursedetail['summary']?></p>
<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$coursedetail['cwurl'])){ ?>
	<?php if($coursedetail['isfree']!=1){ ?>
		<input name="" type="button" value="开始听课" class="fabubtn" onclick="showdialogs()"/>
	<?php }else{ ?>
		<?php if($room['isschool'] == 4){ ?>
		<input name="" type="button" value="开始听课" class="fabubtn" onclick="playdemand('<?= $coursedetail['cwsource']?>','<?= $coursedetail['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$coursedetail['title']))?>',1,0,showdialogs)"/>
		<?php }else{ ?>
		<input name="" type="button" value="开始听课" class="fabubtn" onclick="freeplay('<?= $coursedetail['cwsource']?>','<?= $coursedetail['cwid']?>','<?= str_replace("'"," ",$coursedetail['title'])?>',1,0,showdialogs);"/>
		<?php } ?>
	<?php } ?>
	<input name="" type="button" value="返回" class="fabubtn" onclick="back()"/>
<?php }else{ ?>
	<?php if(preg_match("/.*(\.flv)$/",$coursedetail['cwurl'])){ ?>
	<?php }else{ ?>
		<?php if($coursedetail['isfree']!=1){ ?>
		<input name="" type="button" value="下载课件" class="fabubtn" onclick="downfile(<?= $coursedetail['cwid']?>,showdialogs);"/>
		<input name="" type="button" value="返回" class="fabubtn" onclick="back()"/>
		<?php }else{ ?>
		<input name="" type="button" value="下载课件" class="fabubtn" 
		onclick="location.href='<?= $coursedetail['cwsource'].'attach.html?cwid='.$coursedetail['cwid'].'&uid='.$user['uid'].'&isfree=1'?>'"/>
		<input name="" type="button" value="返回" class="fabubtn" onclick="back()"/>
		<?php } ?>
	<?php } ?>
<?php } ?>

<?php if(preg_match("/.*(\.flv)$/",$coursedetail['cwurl'])){ ?>
<div style="position: relative;z-index:1">
<div id="flvcontrol" ></div>
</div>
<?php } ?>

<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="margin-top:10px;">
<a class="bds_qzone"></a>
<a class="bds_tsina"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_t163"></a>
<span class="bds_more"></span>
<a class="shareCount"></a>
</div>
<!-- Baidu Button END -->
</div>
<?php if(!empty($examlist)){ ?>
<div class="ceping">
<h2 class="lantit">在线测评</h2>
<table class="datatab" width="100%" style="font-size:14px;">
<thead class="tabhead">
<tr style="color:#3093e4;">
<th>作业名称</th>
<th>出题时间</th>
<th>总分</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($examlist as $exam){ ?>
<tr>
<td width="55%"><?= shortstr($exam['title'],50)?></td>
<td width="22%"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
<td width="8%"><?= $exam['score']?></td>
	<?php if($coursedetail['isfree']==1){ ?>
	<td><a style="text-decoration:none;color:#FFFFFF;" class="cepingbtn" type="button" value="" name="" target="_blank" href="http://exam.ebanhui.com/freedo/<?= $exam['eid']?>.html">在线测评</a></td>
	<?php }else{ ?>
	<td><img src="http://static.ebanhui.com/ebh/tpl/2012/images/ceping.jpg"/></td>
	<?php } ?>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<?php } ?>

<div class="xiangqy" style="font-size:14px;padding-bottom:10px;float:left;">
<h4 class="xiangqy_h4" style="color:#3093e4;">课件介绍</h4>
<?= $coursedetail['message']?>
</div>
<div class="dianp" style="width:915px;float:left;">
<h4 style="color:#3093e4;">课件点评</h4>
</div>
<div class="xianshi">

<?php if(empty($reviewdetail)){ ?>
<div class="rigjie">
<p style="color:#58adfd;width: 820px;">暂无任何评论</p>
</div>
<?php }else{ ?>
<ul>
<?php foreach($reviewdetail as $review){ ?>
<?php 
	if($review['sex'] == 1){
		$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman_78_78.jpg';
	}else{
		$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man_78_78.jpg';
	}
	$face = getthumb($review['face'],'78_78',$defaulturl);
?>
<li style="width:915px;">
<div class="tuxiang">
<img src="<?= $face?>" />
</div>
<div class="rigjie">
<p style="color:#58adfd;"><?= $review['username']?>:</p><?php $score=($review['score']/5)*100?>
<p>学习效果：<span class="xianbg"><span class="xianbar" style="width:<?= $score?>%;"></span></span></p>
<p><?= $review['subject']?></p>
<p style="color:#b5b9bc;"><?= date('Y-m-d H:i:s',$review['dateline'])?></p>
</div>
</li>
<?php } ?>
</ul>
<?php } ?>
</div>
</div>

</div>
<div class="fltkuang">
</div>
</div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>
</div>
<!--弹出框-->
<div id="dialogdivs">
	<div class="tisku">
	<p class="top50">对不起，此课程不是免费课程，您无法学习该课程。</p>
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/elog0913.jpg" />
	<?php 
			$cloudaddurl="/classactive.html";
	?>
	<p>您可以点击&nbsp;<a style="color:#337fb6;" href="<?= $cloudaddurl?>" >开通</a>&nbsp;进行学习。</p>
	</div>
	<div>
		<p style="text-align:center;">如果您已经开通此平台的服务，请点击&nbsp;<a style="color:#CD2626;" href='<?= geturl('myroom')?>'" >进入学习</a>&nbsp;.</p>
	</div>
</div>