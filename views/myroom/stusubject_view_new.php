<?php $this->display('myroom/page_header'); ?>
<style>
	.dtkywe {
	  height: 35px;
	  position: absolute;
	  right: 0px;
	  top: 5px;
	  width: 110px;
	}
	a.gkstgws.sel{
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaostds.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
	a.stutes.sel {
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/tyistyts.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
	a.stutes {
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/tyistyt.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
	a.gkstgws{
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaostd.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/liets.css" />
	<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/stusubject') ?>">学习课程</a> > <?=$folder['foldername']?>
	<div class="dtkywe">
		<a href="?cwsmod=list" class="stutes <?=($cwsmod=='list')?' sel':'' ?>"></a>
		<a href="?cwsmod=grid" class="gkstgws  <?=($cwsmod=='grid')?' sel':'' ?>"></a>
	</div>
	</div>
	<div class="lefrig">
	<div style="margin-top:15px;">
	<?php if(!empty($subfolderlist)){?>
		<div class="kejian">
		<ul class="liss">
			<?php foreach($subfolderlist as $subfolder){ ?>
		<li class="danke" style="margin-left:4px; _margin-left:2px;list-style: none;">
		<div class="showimg"><a href="<?=geturl('myroom/stusubject/'.$subfolder['folderid'].'-0-0-0-'.$from)?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
		<span class="spne"><a href="<?= geturl('myroom/stusubject/'.$subfolder['folderid'].'-0-0-0-'.$from) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= ssubstrch($subfolder['foldername'],0,20) ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
		</li>
			<?php } ?>

		</ul>
		</div>
	<?php }else{?>
	<?php if(!empty($onlinelist)) { 
			$i = 0;
			if(empty($user['realname'])) {
				$uname = $user['username'];
			} else {
				$u1 = substr($user['username'],0,2);
				$u2 = substr($user['username'],-2,2);
				$uname = $user['realname'].'('.$u1.'**'.$u2.')';
			}
		?>
		<div class="cqliebiao">
		<div class="cqmain">
		<h2 class="lanbiaot">直播课列表</h2>
		<ul>
		<?php foreach($onlinelist as $myonline) { 
		$i ++;
		$haspower = 1;
		$ourl = "";
		if($roominfo['isschool'] == 7 && $check != 1) {
			$ourl = "javascript:openonline();";
			$haspower = 0;
		} else {
			$tname = $myonline['realname'];
			$ourl = "http://chat.ebh.net/webconf/room.htm?id=".$myonline['id']."&user=".$uname."&teach=".$tname."&type=u&key=".$key;
		}
		
		?>
			<li class="liess">
	<span style="float:left;width:50px;">
		<i class="onlineico" title="直播课"></i>
			</span>
		<a class="sa" <?= empty($haspower) ? '' :'target="_blank"'?> href="<?= $ourl ?>"><span style="float:left"><?= $myonline['title'] ?>&nbsp;&nbsp;</span><span  class="cspant"><?= date('Y年m月d日 H:i',$myonline['cdate']) ?> 开始，课长 <?= $myonline['ctime'] ?> 分钟&nbsp;&nbsp;</span>
		<?php if($myonline['status'] == 1) { ?>
		<span class="cspant">即将开始&nbsp;&nbsp;</span>
		<?php } else if($myonline['status'] == -1) { ?>
		<span class="cspant">已经过期&nbsp;&nbsp;</span>
		<?php } else { ?>
		<span class="cspant">正在进行&nbsp;&nbsp;</span>
		<?php } ?>
		<span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema"><?= $i ?></em></li>
		<?php } ?>
		</ul>

</div></div><?php } ?>
		<?php 
		
		if(!empty($sectionlist)){?>
		<div class="rtygder">
		<span class="kjherf">
		<?=$folder['foldername']?>
		</span>
		<div class="kdtrer">
		<span style="font-size:14px">
		<a href="javascript:;" class="<?= empty($myfavorite)?'shoutie':'yishout'?>" id="favorite"></a>
		</span>
		</div>
		</div>
		<?php
		foreach($sectionlist as $k=>$section) {
		?>
		
		<table width="100%" class="datatab" id="tb<?=$k?>">
			<thead class="tabhead">
				<tr>
					
					<th>
					<a href="javascript:void(0)" style="color:#18a8f7;text-decoration:none" onclick="showcws('<?=$k?>')"><?=$section[0]['sname']?>(<?=$section[0]['sectioncount']?>)</a>
					</th>
					
					
				</tr>
			</thead>
			<?php 
				foreach($section as $cw) { 
				$arr = explode('.',$cw['cwurl']);
				$type = $arr[count($arr)-1];
				?>
			<tbody>
				<tr>
					<td>
					
					<?php 					
					if($cw['sex'] == 1) {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					} else {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}
					$face = empty($cw['face']) ? $defaulturl : $cw['face'];
					$face = getthumb($face,'50_50');
					?>
					<div class="rykgd">

<img src="<?=$face?>">

</div>

<div style="float:left;width:690px">
<?php if ($cw['examnum']>0 && $roominfo['isschool']==2) { ?>
						<i class="zuoyeico" title="此课件包含作业"></i>
					<?php } else { ?>
						<i></i>
					<?php } ?>

					<?php if($cw['attachmentnum'] > 0 ) { ?>
						<i class="fujianico" title="此课件包含附件"></i>
					<?php } else { ?>
						<i></i>
					<?php } ?>
					<?php if($cw['dateline']>strtotime("-7 days")){ ?>
						<i class="fujianweek" title="此课件为一周内新传课件" ></i>
					<?php } else { ?>
						<i></i>
					<?php } ?>
					
					<?php if((empty($limitdate) || $cw['dateline']>$limitdate) && SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
					<h2 class="lisizft">
					<?php $date = Date('Y-m-d',$cw['dateline']);
						  $datenow = date('Y-m-d');
					?>
					<a style="color:<?= $date==$datenow?'red':'#666'?>;text-decoration:none" target="<?= (empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))) ? '_blank' : '_blank' ?>" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>"><?=$cw['title']?></a>
					</h2>
					<?php }elseif(SYSTIME<$cw['submitat'] || !empty($cw['endat'])){?>
						<h2 class="lisizft">
						<?php $date = Date('Y-m-d',$cw['dateline']);
							  $datenow = date('Y-m-d');
						?>
						<s>
						<a style="color:<?= $date==$datenow?'red':'#666'?>;text-decoration:none" target="<?= (empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))) ? '_blank' : '_blank' ?>" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>"><?=$cw['title']?></a></s>
						</h2>
					<?php }else{?>
					<span style="color:#B5B2B2">
					<?=$cw['title']?>
					</span>(往期课件)
					<?php }?>
					<?php if(SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
					<p class="fkhspty"><?=$cw['realname']?>  <?=timetostr($cw['dateline'])?> 发布 
					<?php if(SYSTIME<=$cw['endat']){?>
						<span class="disbl">将于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
					<?php }?>
					<?php }elseif(empty($cw['endat']) || SYSTIME<=$cw['endat']){?>
						<p class="fkhspty"><span class="redbl"><?=$cw['realname']?> 于&nbsp;<?=Date('Y-m-d H:i',$cw['submitat'])?> 开课,敬请期待! 
						<?php if(SYSTIME<=$cw['endat']){?>
						<span class="redbl">将于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
						
					<?php }?>
						</span>
					<?php }else{?>
						<p class="fkhspty"><span class="disbl"><?=$cw['realname']?> 已于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束! </span>
					<?php }?>
					
					<?=!empty($cw['viewnum'])?'&nbsp; 人气:'.$cw['viewnum']:''?> <?=!empty($cw['reviewnum'])?'&nbsp; 评论:'.$cw['reviewnum']:''?>
					</p>
					<p class="ljstgd"><?=$cw['summary']?></p>
		</div>
					</td>
				</tr>
	
			</tbody>
			<?php }}
			}elseif(empty($onlinelist)){
			?>
			<div class="lstugv"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/stuhope.jpg" /></div>
			<?php }
			?>
		</table>
		<div>
			<?=$pagestr?>
		</div>
	<?php }?>
	</div>
</div>
<script type="text/javascript">
function showcws(tbid){
	if($('#tb'+tbid+' tbody').css('display')=='none')
		$('#tb'+tbid+' tbody').show();
	else
		$('#tb'+tbid+' tbody').hide();
}
$(function(){
	<?php if(empty($myfavorite)) { ?>
			$("#favorite").html("收藏");
			$("#favorite").unbind().click(function(){
				$("#favorite").html("已收藏");
				$("#favorite").removeClass('shoutie');
				$("#favorite").addClass('yishout');
				$("#favorite").removeAttr('onclick');
			addfavorite('<?= $folder['folderid'] ?>','<?= $folder['foldername']?>',location.href);
		});
	<?php } else { ?>
		$("#favorite").html("已收藏");
			$("#favorite").removeClass('shoutie');
			$("#favorite").addClass('yishout');
	<?php } ?>
})
function addfavorite(folderid,title,url){
		var purl = "<?= geturl('myroom/favorite/add')?>";
		$.ajax({
			type	:'POST',
			url		:purl,
			data	:{'folderid':folderid,'title':title,'url':url,'type':2},
			dataType:'text',
			success	:function(data){
				if(data=='success'){
					$("#favorite").html("已收藏");
					$("#favorite").unbind();
				}
			}
		});
	}
</script>
<?php $this->display('myroom/player'); ?>
<?php $this->display('myroom/page_footer'); ?>