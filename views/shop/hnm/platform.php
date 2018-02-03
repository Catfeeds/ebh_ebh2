<?php
$this->display('shop/hnm/header');
?>


<div style="clear:both"></div>
<div class="derfl" style="margin-bottom:20px;">
<div class="wigkhr">
<div class="zzind">
<div class="fontxian"  style="margin:0;padding:0;background:none;">
<div class="lefzong">


<?php $crid = $room['crid']?>

<?php if(!empty($zwxlist)){?>
<?php foreach($zwxlist as $k){ ?>
<div class="zizhans">
<div class="neiku" onmouseout="this.className='neiku'" onmouseover="this.className='lanku'">
<div class="lefke">

<?php 
	$logo=empty($k['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$k['cface'];
    $cloudurl='http://'.$k['domain'].'.ebanhui.com';
?>
<a href="<?= $cloudurl?>"><img src="<?= $logo?>" style="width:100px;height:100px;" ></a>

</div>
<div class="rigsize">
<a style="cursor: pointer;" href="<?= $cloudurl?>">
<span class="titke"><?= $k['crname']?></span>
</a>
<p class="pingf">
<?php 
if($k['template']==='stores'){
	$url="http://".$k['domain'].".ebanhui.com".geturl('cloudscore');
?>
<a href="<?= $url?>" style="cursor: pointer;" >
<span class="barbg">
<span class="votebar" style="width:<?= round($k['score'])?>0%;"></span>
</span>
</a>
<?php }else{ ?>
<span class="barbg">
<span class="votebar" style="width:<?= round($k['score'])?>0%;"></span>
</span>
<?php } ?>
</p>
<p class="kuanpa"><?= shortstr($k['summary'],120)?></p>

<p class="fotsis">
课件数：
<span style="margin-right:20px;"><?= ($k['coursenum'])?></span>

作业数：
<span style="margin-right:20px;"><?= ($k['examcount'])?></span>
直播数：
<span><?= $k['rucount']?></span>
</p>
</div>
<?php 
	$cloudaddurl="http://".$k['domain'].".ebanhui.com/classactive.html";
?>

	<?php if($user['groupid'] == 5){ ?>
	<a target="_blank">
	<input class="kaitongbtn" type="submit" onclick="location.href='<?= $cloudurl?>'" value="马上进入" name="Submit2">
	</a>
	<?php }else{ ?>
		<?php if(!empty($rmuser)){ ?>
		<a target="_blank">
	<input class="kaitongbtn" type="submit" onclick="location.href='<?= $cloudurl?>'" value="开始学习" name="Submit2">
	</a>
		<?php }else{ ?>
		<a target="_blank">
	<input class="kaitongbtn" type="submit" href="javascript:;" value="立即开通" name='<?= $cloudaddurl?>'>
	</a>
		<?php } ?>
	<?php } ?>

</div>
</div>
<?php } ?>
	<?= show_page($count['count'],$pagesize);?>
<?php }else{ ?>
<img src="http://static.ebanhui.com/ebh/tpl/default/images/wuzizhan.jpg" />
<?php } ?>


</div>
<div class="lefadlo">
<div class="sanad">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/ad010411.jpg" />
</div>
</div>
</div>
</div>
</div>
</div>
<div style="clear: both"></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript">
<!--
	$(".kaitongbtn").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
//-->
</script>
<?php
    $this->display('common/footer');
?>