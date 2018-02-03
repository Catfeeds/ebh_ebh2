<?php $folderid = $this->uri->itemid?>
<?php $title= $this->input->get('q');
?>
<?php $this->display('shop/stores/stores_header'); ?>
<div class="main">
<div class="dtzhix">

<div class="topkuang"></div>
<div class="zixun">
<div class="leflist">
<h2 style="margin-bottom:10px;">所有课程</h2>
<p style="margin-left:10px; font-weight:bold;"><a href="<?= geturl('studyline')?>">查看所有课件>></a></p>
<ul>
<?php foreach($folderlist as $v){ ?>
	<?php if($v['coursewarenum']!=0){ ?>
	<li class="lister">
	<a href="<?= geturl('studyline/'.$v['folderid'])?>" style="cursor:pointer;" title="<?=$v['foldername']?>"><p <?= $folderid==$v['folderid'] ?'style="color: #838383;"':'style="color: #3D3D3D;"'?> class="titming"><?= ssubstrch($v['foldername'],0,18)?> 
	<span style="color:#838383;font-weight:normal;">(<?= $v['coursewarenum']?>)</span></p>
	</a>
	<p class="sizele"><?= shortstr($v['summary'],88)?></p>
	</li>
	<?php } ?>
<?php } ?>
</ul>
</div>

<div class="rigxiang">
	<?php if(!empty($title)){?>
		<h3 class="rigxiang_h3">找到关于“<span style="color:#FF0000;"><?= $title?></span>”的课件&nbsp;<span style="color:#FF0000;"><?= intval($coursecount)?></span>&nbsp;件</h3>
	<?php }else{ ?>
		<h3 class="rigxiang_h3">所有课件&nbsp;<span style="color:#FF0000;"><?= intval($coursecount)?></span>&nbsp;件</h3>
	<?php } ?>
 <div class="rigbtn"><a href="<?= geturl('studyline')?>" class="quankj">全部课件</a><a href="<?= geturl('freed')?>" class="shiting">免费试听</a>
 <?php if($roominfo['isschool']==2){ ?>
 <a href="<?= geturl('onlinexam')?>" class="zuoye">在线试听</a>
 <?php } ?>
 </div>


<!--<?php if(!empty($courselist)){ ?>-->
<!--<?php if(!empty($sectionlist)) { ?>
    <?php foreach($sectionlist as $section) { 
	//print_r($section);
   
	?>
				<?php foreach($section as $course){ ?>
				
			<ul>

					<li class="kelist">

						<span style="color:red;">目录:<?= $course['sname'] ?></span>

						<h4 style="height:27px; line-height:27px;">
							<a style="cursor:pointer;" href="<?= geturl('course/'.$course['cwid'])?>" title="<?= $course['title']?>" target="_blank"><span class="hsiz"><?= $course['title']?></span></a>
							<?php if($course['isfree']==1){ ?>
								<i class="mianfei"></i>
							<?php } ?>
							<?php if($course['examnum']>0 && $roominfo['isschool'] == 2){ ?>
								<i class="ermen" title="这个图标表示此课件有作业"></i>
							<?php } ?>
						</h4>
					<p style="margin-left:10px; color:#9c9c9c;">主讲：<span style="margin-right:20px;"><?= $course['realname']?></span>时间：<span><?= date('Y-m-d H:i:s',$course['dateline'])?></span></p>
					<p class="paddie" style="text-indent: 30px;"><?= shortstr($course['summary'],266)?></p>
					</li>
				<?php } ?>
			
			</ul>
		<?php } ?>
<?php } ?>	
		</div>
		<?= $pagestr ?>-->

<!--<?php }else{ ?>
	<br>抱歉,没有找到相关的结果！</br>
	</div>
<?php } ?>-->


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
	<a class="sa" style="width:600px;" href="<?= geturl('course/'.$course['cwid'])?>" title="<?= $course['title']?>" target="_blank" ><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema" ><?= $i++ ?></em></li>
	<?php } ?>


	</ul>
	<?php } ?>
</div>

<?php } else { ?>
		   <div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
	  <?php } ?>
	<?= $pagestr ?>



</div>
<div class="fltkuang" style="margin-left:-10px;_margin-left:-5px;">
</div>
</div>
</div>

<div style="text-align:center;clear:both;">
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>

