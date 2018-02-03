<?php $folderid = $this->uri->itemid?>
<?php $this->display('shop/stores/stores_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/dialog.js"></script>
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

//-->
</script>
<div class="main">
<div class="dtzhix">

<div class="topkuang"></div>
<div class="zixun">
<div class="leflist">
<h2 style="margin-bottom:10px;">所有课程</h2>
<p style="margin-left:10px; font-weight:bold;"><a href="<?= geturl('onlinexam')?>">查看所有在线作业>></a></p>

<ul>

<?php foreach($folderlist as $folder){ ?>
	<?php if($folder['count']!=0){?>
		<li class="lister">
		<a href="<?= geturl('onlinexam/'.$folder['folderid'])?>" style="cursor:pointer;"><p <?= $folderid==$folder['folderid'] ?'style="color: #838383;"':'style="color: #3D3D3D;"'?> class="titming"><?= shortstr($folder['foldername'],22)?> <span style="color:#838383;font-weight:normal;">(<?= $folder['count']?>)</span></p></a>
		<p class="sizele"><?= shortstr($folder['summary'],88)?></p>
		</li>
	<?php } ?>
<?php } ?>
</ul>
</div>


<div class="rigxiang">
<h3 class="rigxiang_h3" style="width:430px;">
全部作业 

<span style="color:#FF0000;"><?= $examcount?></span> 件</h3>
 <div class="rigbtn">
 <a href="<?= geturl('studyline')?>" class="quankj">全部课件</a>
 <a href="<?= geturl('freed')?>" class="shiting">免费试听</a>
 <?php if($roominfo['isschool']==2){ ?>
 <a href="<?= geturl('onlinexam')?>" class="zuoye">在线试听</a>
 <?php } ?>
 </div><div class="cqmain">



<?php if(!empty($courselist)){ ?>

		<?php foreach($courselist as $course){ ?>
			<?php if(!empty($course['examlist'])){ ?>
				<h2 class="lanbiaot" ><a class="lanbiaot"  style="cursor:pointer;text-decoration:none;color:#0033FF " href="<?= geturl('course/'.$course['cwid'])?>" title="<?= $course['title']?>" target="_blank"><?= $course['title']?></a><?php if($course['isfree']==1){ ?>
				<span style="height: 23px;width: 30px; margin-left: 5px;"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/tuico11232.jpg" /></span>
				<?php } ?></h2>
				
				<ul>
				<?php foreach($course['examlist'] as $exam){ ?>
						<li class="liess">
						<?php if($course['isfree']==1){ ?>
							<a class="sa" href="http://exam.ebanhui.com/freedo/<?= $exam['eid']?>.html" title="<?= $exam['title']?>" target="_blank"><?= $exam['title']?><span style="color:#FF0000;">（免费）</span>
						<?php }else{ ?>
							<a class="sa" href="javascript:;" onclick="showdialogs()" ><?= $exam['title']?>
						<?php } ?>
							<span style="color:#cfcfcf;margin-left: 10px;">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</span>
							</a>
							<em class="yema"><?= $exam['score']?>分</em>
						</li>
				<?php } ?>
				</ul>
			<?php } ?>
		<?php } ?>
	<?= $pagestr ?>
<?php }else{ ?>
	<br>抱歉,没有找到相关的结果！</br>
</div>
<?php } ?>

</div>

	</div>

<div class="fltkuang">

</div>
</div>
</div>
<div style="text-align:center;clear:both;">
</div>
<!--弹出框-->
<div id="dialogdivs">
	<div class="tisku">
	<p class="top50">对不起，此课件不是免费课件，<br>您无法查看该课件下的作业。</p>
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
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>
