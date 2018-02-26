<?php $this->display('college/page_header'); ?>
<style type="text/css">
li.txkel:hover{background:#FF8040;}
.lefrig .txkel{margin:10px 0 0 5px;height:80px;width: 190px;}
.egory {float:left;width:95px;margin:10px 10px 0 10px;font-weight:bold;;color: #505050;}
a .egory:hover{ text-decoration: underline;}
.txkel .span1s{font-size:12px; color:#008080;float:left; display:inline; height:40px;line-height:22px; width:95px; word-wrap: break-word;overflow:hidden;margin-left:10px;}
.rtyutyt {display: inline;float: left;margin: 10px 0 0 10px;}
</style>

	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:1000px;">
		<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
			<ul>
				 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span><?=$roominfo['property'] == 3?'我的同事':'我的同学'?></span></a></li>
			</ul>
		</div>
	<?php if(!empty($students)) { ?>
<ul style="width:998px;float:left;">
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
<a class="rtyutyt" href="/sns/feeds/<?=$student['uid']?>.html"><img style="width:58px;height:58px; float:left;" src="<?= $face ?>" title="<?= !empty($student['realname'])?$student['realname']:$student['username'] ?>"/></a>
	<a href="/sns/feeds/<?=$student['uid']?>.html"><p class="egory" title="<?= !empty($student['realname'])?$student['realname']:$student['username']?>"><?= !empty($student['realname'])?shortstr($student['realname'] ,8,''):shortstr($student['username'] ,8,'') ?></p></a>

	<p class="span1s" title="<?= empty($student['mysign'])?'暂无签名':$student['mysign'] ?>"><?= empty($student['mysign'])?'暂无签名':shortstr($student['mysign'],30) ?></p>
</li>
<?php } ?>
</ul>
<?= $pagestr ?>
<?php } else { ?>
		<div style="margin: 20px;">对不起，您还有没加入任何班级。</div>
		<?php } ?>
</div>
<?php $this->display('myroom/page_footer'); ?>
