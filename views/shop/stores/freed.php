<?php $this->display('shop/stores/stores_header'); ?>
<?php $folderid = $this->uri->itemid?>
<div class="main">
<div class="dtzhix">

<div class="topkuang"></div>
<div class="zixun">
<div class="leflist">
<h2 style="margin-bottom:10px;">所有课程</h2>
<p style="margin-left:10px; font-weight:bold;"><a href="<?= geturl('freed')?>">查看所有免费课件>></a></p>
<ul>

<?php foreach($folderlist as $v){ ?>
	<?php if($v['count']){ ?>
		<li class="lister">
		<a href="<?= geturl('freed/'.$v['folderid'])?>" style="cursor:pointer;"><p title="<?= $v['foldername']?>" <?= $folderid==$v['folderid'] ?'style="color: #838383;"':'style="color: #3D3D3D;"'?> class="titming"><?= shortstr($v['foldername'],22)?> <span style="color:#838383;font-weight:normal;">(<?= $v['count']?>)</span></p></a>
		<p class="sizele"><?= shortstr($v['summary'],88)?></p>
		</li>
	<?php } ?>
<?php } ?>
</ul>
</div>
	<div class="rigxiang">


	<h3 class="rigxiang_h3">免费试听课件&nbsp;<span style="color:#FF0000;"><?= intval($coursecount)?></span>&nbsp;件</h3>
 <div class="rigbtn"><a href="<?= geturl('studyline')?>" class="quankj">全部课件</a><a href="<?= geturl('freed')?>" class="shiting">免费试听</a>
  <?php if($roominfo['isschool']==2){ ?>
 <a href="<?= geturl('onlinexam')?>" class="zuoye">在线试听</a>
 <?php } ?>
 </div>
<div class="cqmain">
<?php if(!empty($sectionlist)) { ?>
<?php $i = 1; ?>
<?php foreach($sectionlist as $section) { ?>
		<h2 class="lanbiaot"><?= $section[0]['sname']?></h2>
		<ul>
	<?php foreach($section as $course) { 
	$color = $course['examnum'] > 0 ? 'style="color:red;"' : '';
	?>
	<li class="liess">
		<span style="float:left;width:42px;">
			<?php if ($course['examnum']>0 && $roominfo['isschool']==2) { ?>
				<i class="zuoyeico" title="此课件包含作业"></i>
			<?php } else { ?>
				<i></i>
			<?php } ?>

			<?php if($course['attachmentnum'] > 0 ) { ?>
				<i class="fujianico" title="此课件包含附件"></i>
			<?php } else { ?>
				<i></i>
			<?php } ?>
		</span>
		<?php $arr = explode('.',$course['cwurl']);
			$type = $arr[count($arr)-1]; ?>
		<a class="sa" style="width:600px;" href="<?= geturl('course/'.$course['cwid'])?>" title="<?= $course['title']?>" target="_blank"><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema"><?= $i++ ?></em>
	</li>
	<?php } ?>


	</ul>
	<?php } ?>
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
