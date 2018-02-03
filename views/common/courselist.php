<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151015001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css" />

<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20150822" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
</head>
<style>
.cmain_bottom .study .xialas{top:-5px;}
a.sees{display:block; width:114px; margin:5px auto 0; text-align:center; height:24px; line-height:24px; background:#0099ff; color:#fff; }
.cmain_bottom .study_top{ }
.other_room_tit{ border-bottom:1px solid #efefef;}
.showimg > a{display:block; height:155px;}
.kejian .showimg{ margin-left:15px;}
.kejian .liss .danke .spne{ margin-left:10px; line-height:30px;}
.piaoyin{ left:15px;}
.danke2s:hover{ box-shadow:0 0 5px #ccc;}
.cmain_bottom {padding-bottom:10px;}
.danke2s{ padding-bottom:10px; display:inline-block; width:146px;}
.piaoyin{ position:relative; *position:absolute;top:5px; min-height:159px; height:auto;opacity: 0.8;}
.imges img,.kewates{ margin-left:15px;}
</style>
<body>
	<div class="lsitit" >
		<div class="clear"></div>
		<div class="cmain_bottom ">
        	<!--学习-->
            <div class="study fl" style="<?=$roominfo['isschool']==7?'background:none;':''?> border-bottom:none; padding-bottom:0;">
            	<div class="study_top" style="background:#fff;">
                	<div class="fl"><h3><?=empty($all)?'学习':'全校课程'?></h3></div>
                    <div class="fr" style="width:230px;">
						<a href="/college/record.html" class="studyjl">学习记录</a>
                    	<a href="/myroom/favorite.html" class="shoucang">收藏夹</a>
                        <a href="javascript:void(0)" class="more ml15">更多</a>
                    </div>
                    <div class="clear"></div>
                    <div class="xialas xialas<?=$roominfo['isschool']==7?'2':'4'?>" style="display:none;">
                		<ul >
                            <li style="padding-top:8px;"><a href="/college/notes.html">听课笔记</a></li>
							<li><a href="/college/review/student.html">我的评论</a></li>
							<?php if($roominfo['isschool']!=7){?>
							<li><a href="/myroom/college/allcourse.html">全校课程</a></li>
							<li><a href="/myroom/college/allteachers.html">全校老师</a></li>
							<?php }?>
                        </ul>
                	</div>
                </div>
                <div class="clear"></div>
                <div class="study_bottom" style="">
				<?php 
				if(!empty($schoolfreelist)){
					?>
					<div class="kejian" style="margin-top:0px; width:1000px; border:none;">
						<div class="other_room_tit"><h2>全校免费</h2></div>
						<ul class="liss">
						<?php 
						foreach($schoolfreelist as $sf){
							if($sf['showmode'] !=3 ){
							$folderurl = geturl('myroom/college/study/cwlist/'.$sf['folderid']);
							$target = '';
							}
							else{
								$folderurl = geturl('myroom/college/study/introduce/'.$sf['folderid']);
								$target = 'target="_blank"';
							}
							?>
							<li class="danke" style="margin-left:11px; _margin-left:2px;height:auto; text-align:left;margin-right:9px;">
							<div class="danke2s" style="height:auto;"><span class="spne" style="height:25px;font-size:14px"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>"><?= shortstr($sf['foldername'],16,'')?><?=!empty($sf['coursewarenum'])?'('.$sf['coursewarenum'].')':''?></a></span>
							<div class="clear"></div>
							<div class="showimg"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>"><img src="<?= empty($sf['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$sf['img']?>" width="114" height="159" border="0" /></a></div>
							<div style="clear:both;"></div>
							
							
							</div>
							</li>
						<?php
						}
						?>
						</ul>
						</div>
					</div>
				<?php }
				?>
				<?php 
					if($roominfo['isschool'] != 7){//非7,我的课程
						$allclear = true;?>
                	<ul class="mt15">
					<?php foreach($folders as $folder){
						if($folder['showmode'] !=3 ){
							$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
							$target = '';
						}
						else{
							$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
							$target = 'target="_blank"';
						}
						if(empty($folder['creditmode'])){
							$percent = empty($folder['percent'])?'0':$folder['percent'];
						}else{
							$percent = round($folder['sumtime']/$folder['credittime']*100,2);
							$percent = $percent>=100?100:$percent;
						}
						?>
                    	<li class="fl" style="height:auto;">
                        	<div class="danke2s">
                            	<div class="title" style="line-height:27px;">
								<a href="<?=$folderurl?>" <?=$target?> style="font-size:14px; color:#333;" title="<?=$folder['foldername']?>"><?=shortstr($folder['foldername'],16,'')?></a>
								</div>
                                <div class="imges">
								<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" height="159" width="114" /></a>
								</div>
                                <div class="kewates mt5" style="position:relative"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>
								<?php if(empty($folder['creditmode'])){
									if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
										$allclear = false;
									}
									?>
									<div class="mt5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span></div>
								<?php }else{
									if($folder['sumtime']>=$folder['credittime']){
										$creditget = $folder['credit'];
									}else{
										$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
										$allclear = false;
									}?>
									<div class="mt5" style="text-align:left;margin-left:26px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=$creditget?>分</span></div>
									<div class="clear"></div>
									<?php if(!empty($folder['sumtime'])){?>
										<div style="color:#777;padding-left:25px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
									<?php }?>
								<?php }?>
                            </div>
                        </li>
					<?php 
					
					}?>
                    </ul>
					<?php }//else{//7,全校课程
					$allclear = true;
					if(!empty($spfolders))
					foreach($spfolders as $k=>$package){
					?>
					<div class="kejian" style="margin-top:0px; width:1000px; border:none;">
					<div class="other_room_tit"><h2><?=$package['pname']?></h2>
					
					</div>
					<ul class="liss">
					<?php 
					$folderi = 0;
					$hasArr = array();
					foreach($package['itemlist'] as $folder) { 
					if(!in_array($folder['folderid'],$hasArr)){
						if($folder['showmode'] !=3 ){
							$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
							$target = '';
						}
						else{
							$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
							$target = 'target="_blank"';
						}
						$folderi ++;
						if(empty($folder['creditmode'])){
							$percent = empty($folder['percent'])?'0':$folder['percent'];
						}else{
							$percent = round($folder['sumtime']/$folder['credittime']*100,2);
							$percent = $percent>=100?100:$percent;
						}
						?>

							<li class="danke" style="margin-left:11px; _margin-left:2px;height:auto;*height:auto; text-align:left;margin-right:9px;">
							<div class="danke2s" style="height:auto;"><span class="spne" style="height:25px;font-size:14px; line-height:30px;"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><?= shortstr($folder['foldername'],16,'')?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
							<div class="clear"></div>
							<div class="showimg"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
							<div style="clear:both;"></div>
							<div class="kewates mt5 ml5" style="position:relative;margin-left:15px"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>
							<?php if(empty($folder['creditmode'])){
								if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
									$allclear = false;
								}
								?>
								<div class="mt5 ml5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span></div>
							<?php }else{
								if($folder['sumtime']>=$folder['credittime']){
									$creditget = $folder['credit'];
								}else{
									$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
									$allclear = false;
								}
								?>
								<div class="mt5 ml5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=$creditget?>分</span></div>
								<div class="clear"></div>
								<?php if(!empty($folder['sumtime'])){?>
									<div style="color:#777;padding-left:10px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
								<?php }?>
							<?php }?>
							</div>
							
							</li>
					<?php $hasArr[]= $folder['folderid'];}} ?>
					</ul>
					</div>
					<?php }
					//}?>
				</div>
                </div>
				
				
				<?php  
				// var_dump($splist);
			if(!empty($splist)){
				$showunopen = false;
				foreach($splist as $h=>$package){
					if(count($package['itemlist'])>0){
						$showunopen = true;
						break;
					}
				}
				?>
		<div class="kejian unopen" style="margin-top:10px; width:1000px; border:none;<?=empty($showunopen)?'display:none':''?>">
		<a name="classactive" style="display：none"></a>
<ul class="liss" <?= ( !empty($folderi) && $folderi > 0) ?'style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/folderline.png) no-repeat top left;padding-top:10px;padding-bottom:10px;"' : '' ?>>
				<div class="work_mes" style="width:1000px;margin-bottom:10px">
					<ul>
				<?php 
					$idx = 0;
					$curp = 0;
					foreach($splist as $h=>$package){
						if(count($package['itemlist'])>0){
				?>
					<li class="<?=($idx==0)?'workcurrent':''?> packagetab" onclick="showpackage(<?=$h?>)"><a href="javascript:void(0)"><span><?=$package['pname']?></span></a></li>
						
			
				<?php $idx++;
						if($curp == 0)
						$curp=$h;
				}
				}?>
					</ul>
				</div>
				<?php 
					foreach($splist as $j=>$package){ ?>
					<div class="package package<?=$j?>" style="<?=($curp!=$j)?'display:none;':''?>">
					<?php 
					foreach($package['itemlist'] as $k=>$folder) {
						
						// $folderurl = empty($from) ? geturl('myroom/stusubject/'.$folder['folderid']):geturl('myroom/stusubject/'.$folder['folderid'].'-0-0-0-'.$from);
						$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']).'?itemid='.$folder['itemid'];
				?>
					<li class="danke" style="margin-left:11px; _margin-left:2px;height:auto;">
					<div class="danke2s"><span class="spne" style="height:25px;font-size:14px"><a href="<?= $folderurl ?>" title="<?= $folder['foldername']?>"><?= shortstr($folder['foldername'],16,'')?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
					<div style="clear:both;"></div>
					<?php if(empty($folder['cannotpay'])){?>
					<div class="showimg"><a href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
					<?php }else{?>
					<div class="showimg"><a href="javascript:voiwd(0)" style="cursor:default" title="点击立即开通"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
					<?php }?>
						<div class="piaoyin" style="*top:30px;<?=empty($folder['cannotpay'])?'background:url(http://static.ebanhui.com/ebh/tpl/default/images/diceng_2.png)':'background:url(http://static.ebanhui.com/ebh/tpl/default/images/diceng_1.png)'?>">
						<?php if(empty($folder['cannotpay'])){?>
							<a href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通" class="tuslick"></a>
							<a class="btnxlick" href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通"></a>
						<?php }else{?>
							<a href="javascript:void(0)" style="cursor:default" title="点击立即开通" class="tuslick"></a>
							<a class="btnxlick" href="javascript:void(0)" style="cursor:default" title="点击立即开通"></a>
							<a target="_blank" href="/courseinfo/college/<?=$folder['itemid']?>.html" class="sees">课程介绍</a>
						<?php }?>
							
						</div>
					</div>
					</li>
					<?php } ?>
					</div>
					<?php }?>
				
				</ul>
				</div>
	<?php }?>
				
				
				
            </div>
        </div>


</div>
</body>
<script>
$('.more,.xialas').mouseover(function(){
	$('.xialas').show();
});
$('.more,.xialas').mouseout(function(){
	$('.xialas').hide();
});
$(function(){
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
	
	var url = '<?= geturl('myroom/userstate/folder')?>';
	var type = 6;
	var folderids = '<?=empty($folderids)?'':$folderids?>';
	if (folderids != '')
	{
		$.ajax({
			type:'POST',
			url:url,
			data:{"type":type,'folderids':folderids},
			dataType:"json",
			success:function(data) {
				$.each(data,function(k,v){
					if (v.count > 99) {
						v.count = 99;
					}
					$('#folder'+v.folderid).append('<span>'+v.count+'</span>');
				});
			}
		});
	}
		
	<?php if($allclear && $roominfo['domain']=='zjgxedu'){?>
		if(top.showallclear != undefined){
			top.showallclear();
		}
	<?php }?>
});

$('.packagetab').click(function(){
	$('.workcurrent').removeClass('workcurrent');
	$(this).addClass('workcurrent');
	parent.resetmain();
});
function showpackage(pid){
	$('.package').hide();
	$('.package'+pid).show();
}

</script>
</html>
