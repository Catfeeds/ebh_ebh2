<link href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css?v=<?=getv()?>" rel="stylesheet" type="text/css" /><?php if(!empty($cwlist)){$curfolder = 0;?>
	<table id="" class="datatabes packagecwlist package" width="100%">
	<?php 
	foreach($cwlist as &$cw){
		$nextcw = current($cwlist);
		$playimg = '';
		$logo = '';
		getcwlogo($cw,$playimg,$logo,$showprogress);
		if($my){//首页
            $href = 'href="'.geturl('myroom/mycourse/'.$cw['cwid']).'" target="_blank"';
		}else{//学习页
            if (!empty($survey_id)) {
                $href = 'href="javascript:;" price="'.$cw['cprice'].'" cwid="'.$cw['cwid'].'"';
            } else {
                $href = 'href="javascript:;" onclick="paycw('.$cw['cwid'].')"';
            }
		}
		$percent = empty($cw['percent'])?0:(intval($cw['percent']*100));
		if($curfolder != $cw['folderid']){
		?>
		<thead class="tabheades">
			<tr class="">
				<th>
					<div class="biaotises">
						<a href="javascript:void(0)" style="color:#fff;" onclick="showcws(<?=$cw['folderid']?>)"><?=$cw['foldername']?><?=!empty($foldernumarr[$cw['folderid']])?('('.$foldernumarr[$cw['folderid']].')'):''?></a>
					</div>
				</th>
			</tr>
		</thead>
		<?php $curfolder = $cw['folderid'];
					}?>
		<tbody style="width:1000px;float:left;" class="cwlist<?=$cw['folderid']?>">
			<tr class="">
				<td style="<?=(empty($nextcw) || $nextcw['folderid'] != $cw['folderid'])?'border-bottom:none':''?>">
					<div class="ettyusre" style="width:138px;height:83px;margin-top:7px;">
						<a class="fusretse" style="width:138px;height:83px;color:#666;" <?=$href?> title="<?=$cw['title']?>">
						<img style="width:138px;height:83px;" src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>">
						</a>
						<img style="width:138px;height:83px;" src="<?=$logo?>">
					</div>
					<div class="huetdres" style="width:820px;">
						<div>
							<h2 class="hrerses">
								<a class="hudrter" <?=$href?> title="<?=$cw['title']?>"><?=$cw['title']?></a>
							</h2>
							<?php if($cw['islive']){?>
							<i class="label-live" title="直播课件">直播</i>
							<?php }?>
							<?php if($my){//首页,我的课件页
								if($showprogress){?>
							<div class="wsktgstes">
								<span class="lfdtes">学习进度</span>
								<span class="swriowtes">
								<span class="sktdsytes" style="width:<?=$percent?>%;"></span>
								</span>
								<?=$percent?>%
							</div>
								<?php }
								}else{//学习页?>
								<span class="kkjssjes"><?=!empty($cw['submitat'])?('开课：'.Date('Y-m-d H:i',$cw['submitat'])):''?>   <?=!empty($cw['endat'])?('结束：'.Date('Y-m-d H:i',$cw['endat'])):''?></span>
							<?php }?>
						</div>
						<div class="clear"></div>
						<p class="ernsres"><?=$cw['summary']?></p>
						<div>
							<div class="zbteon">
								<img style="width:30px;height:30px; border-radius:15px;float:left;" src="<?=getavater($cw)?>">
							</div>
							<p class="lsfbsjes">
							<?php $realname = $cw['realname']?$cw['realname']:$cw['username']?>
								<span style="width:150px; display:block;" title="<?=$realname?>"><?=$realname?></span>
								<span class="fbsjes" style="width:165px; margin-left:0;"><?=Date('Y-m-d H:i',$cw['dateline'])?> 发布 </span>
								<span class="fbsjes">
								<span class="fbsj2es"></span>
								<?=$cw['viewnum']?>
								</span>
								<span class="fbsjes">
								<span class="fbsj1es" style="padding-left:20px;"></span>
								<?=$cw['reviewnum']?>
								</span>
								<?php if($my){?>
								<span class="kkjssjes"><?=!empty($cw['submitat'])?('开课：'.Date('Y-m-d H:i',$cw['submitat'])):''?>   <?=!empty($cw['endat'])?('结束：'.Date('Y-m-d H:i',$cw['endat'])):''?></span>
								<?php }else{?>
								<a <?=$href?> class="removebtn<?php if(!empty($survey_id)) { echo ' survey'; } ?>"><span class="sizle"><?=($cw['cprice']==0)?'免费':('￥'.intval($cw['cprice']))?></span>开通</a>
								<?php }?>
							</p>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	<?php }?>
	</table>
	
<?php echo empty($pagestr)?'':$pagestr;}else{
	?>
<div class="nodata">
</div>
<?php }?>
<script>
function showcws(folderid){
	$('.cwlist'+folderid).toggle();
	top.resetmain();
}

</script>