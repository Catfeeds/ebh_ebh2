<?php $this->display('myroom/page_header'); ?>
<style type="text/css">
li.txkel:hover{background:#FF8040;}
.lefrig .txkel{margin:10px 0 0 5px;height:80px;width: 190px;}
.egory {float:left;width:95px;margin:10px 10px 0 10px;font-weight:bold;;color: #505050;}
a .egory:hover{ text-decoration: underline;}
.txkel .span1s{font-size:12px; color:#008080;float:left; display:inline; height:40px;line-height:22px; width:95px; word-wrap: break-word;overflow:hidden;margin-left:10px;}
.rtyutyt {display: inline;float: left;margin: 10px 0 0 10px;}
</style>

	<div class="ter_tit">
	当前位置 > 我的同学 <?= !empty($myclass) ? $myclass['classname'] : '' ?>
	</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
	<?php if(!empty($students)) { ?>
<ul style="width:786px;float:left;">
			 <?php foreach($students as $student) { 
			 if($student['sex'] == 1) {
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			 } else {
				 $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			 }
			$face = empty($student['face']) ? $defaulturl : $student['face'];
			$face = getthumb($face,'50_50');
			 ?>
<li class="txkel">
<a class="rtyutyt" href="http://sns.ebh.net/<?=$student['uid']?>/main.html" target="_blank"><img style="width:58px;height:58px; float:left;" src="<?= $face ?>" title="<?= !empty($student['realname'])?$student['realname']:$student['username'] ?>"/></a>
	<a href="http://sns.ebh.net/<?=$student['uid']?>/main.html" target="_blank"><p class="egory" title="<?= !empty($student['realname'])?$student['realname']:$student['username']?>"><?= !empty($student['realname'])?shortstr($student['realname'] ,8,''):shortstr($student['username'] ,8,'') ?></p></a>
	
	<p class="span1s" title="<?= empty($student['mysign'])?'暂无签名':$student['mysign'] ?>"><?= empty($student['mysign'])?'暂无签名':shortstr($student['mysign'],30) ?></p>
</li>
<?php } ?>
</ul>
<?= $pagestr ?>
<?php } else { ?>
		对不起，您还有没加入任何班级。
		<?php } ?>
</div>
<?php $this->display('myroom/page_footer'); ?>