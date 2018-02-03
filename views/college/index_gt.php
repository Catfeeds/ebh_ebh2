<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css<?=getv()?>"/>
<style>
.jjikk_sons_l{
	background: url(http://static.ebanhui.com/ebh/tpl/2016/images/dates_gt.jpg) no-repeat center;
	font-size:15px;
}
.commenttabtitle{
	position:relative;
}
a.blue{
	color:#999; 
	line-height:25px;
	position:absolute;
	bottom:5px;
	right:10px;
}
a.blue:hover{
	color:#4a92f8;
}
</style>
</head>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<body style="background:url(http://static.ebanhui.com/ebh/tpl/2016/images/bg_gt.jpg?v=20161128) no-repeat center -386px">

<!-- 判断是否有购买记录 -->
<?php 
if(($paycount>0) || (in_array($roominfo['isschool'], array(6,7))==false)){?>
	
<?php
	$iszjdlr = empty($iszjdlr)?false:true;
	$isnewzjdlr = empty($isnewzjdlr)?false:true;
?>
		
<?php //最新课程
	if(!empty($newcwlist)){
?>
<div class="jijiangkk" style="margin-bottom:10px;">
	<h2>最新课件</h2>
	<div class="jijiangkk_son">
		<?php $i=0;
		$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
		// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
		foreach($newcwlist as $k=>$cw){
			// $find = array('x','y','z');
			// $replace = '';
			// $k = str_replace($find,$replace,$k);
			$i++;
				$arr = explode('.',$cw['cwurl']);
				$type = $arr[count($arr)-1];
				$isVideotype = in_array($type,$mediatype) || $cw['islive'] == 1;
				// $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
				$target = '_blank';
				$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($isVideotype?($cw['islive']?'livelogo.jpg':'defaultcwimggray.png'):'kustgd2.png');
				if($isVideotype){
					$playimg = 'kustgd2';
				}elseif(strstr($type,'ppt')){
					$playimg = 'ppt';
				}elseif(strstr($type,'doc')){
					$playimg = 'doc';
				}elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
					$playimg = 'rar';
				}elseif($type == 'mp3'){
					$playimg = 'mp3';
				}elseif($cw['islive'] == 1){
					$playimg = 'kustgd';
				}else{
					$playimg = 'attach';
				}
				
				$logo = (!empty($cw['logo']) && $isVideotype)?$cw['logo']:$deflogo;
			
		?>
		<div class="jjikk_sons newscourse-1">
			<div class="jjikk_sons_r" style="width:190px">
				<div class="fl jjkkkc"	>
					<a class="kustgd" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank" class="opens viewc">
					<?php if(!empty($cw['cwtoid']) && $cw['cwtoid'] == 1){?>
						<?php if(empty($cw['logo'])){?>
							<img width="190" height="114" src="http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png?v=20160504001">
						<?php }else{?>
							<img width="190" height="114" src="<?=$cw['logo']?>">
						<?php }?>
					<?php }else{?>
					<img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png">
					<?php }?>
					</a>
					<div class="kcbj"><img width="190" height="114" src="<?=$logo?>"></div>
				</div>
				<div class="kcjsnr fl" style="width:190px;padding-left:0;">
					<h2><a href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank"><?=shortstr($cw['title'],24)?></a></h2>
					<?php if(empty($cw['cwrealname']) && empty($cw['cwusername'])){?>
					<p><span class="zjlsp-1 fl"><?php if(empty($cw['realname'])){echo shortstr($cw['username'],12);}else{echo shortstr($cw['realname'],12);}?></span>
					<?php }else{ ?>
					<p><span class="zjlsp-1 fl"><?php if(empty($cw['cwrealname'])){echo shortstr($cw['cwusername'],12);}else{echo shortstr($cw['cwrealname'],12);}?></span>
					<?php }?>
					<span class="zjlsp-1 fr"><?=Date('Y-m-d',$cw['dateline'])?></span></p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php 
		}?>
		
	</div>
</div>
<?php }?>
		
		
	<div class="clear"></div>
		
		<?php if(!empty($folders)){?>
		<div class="cmain_bottom" style="float:left;margin-bottom:10px;">
			<!--学习-->
			<div class="study" style="<?=$roominfo['isschool']==7?'background:none;':''?>border-bottom:none; padding-bottom:0px;">
				<div class="study_top" style="background:#fff;">
					<div class="fl"><h3>学习</h3></div>
					<div class="fr" style="width:230px;">
						<a href="/college/record.html" class="studyjl">学习记录</a>
						<a href="/myroom/favorite.html" class="shoucang">收藏夹</a>
						<a href="javascript:void(0)" class="more ml15">更多</a>
					</div>
					<div class="clear"></div>
					<div class="xialas xialas<?=$roominfo['isschool']==7?'2':'4'?>" style="*top:-12px;display:none;">
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
				<div class="study_bottom">
				<?php if($roominfo['isschool'] != 7){?>
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

						if($folder['folderid'] == 12870){
							$folderurl = '/college/myask/all.html';
							$target = 'target="mainFrame"';
						}
						if (intval($folder['credit']) == 0) {
							$percent = 0;
						} else {
							if(empty($folder['creditmode'])){
	                    		$getscore = empty($folder['creditget'])?'0':$folder['creditget'];
	                        }else{
	                            if($folder['sumtime']>=$folder['credittime']){
	                                $getscore = $folder['credit'];
	                            }else{
	                                $getscore = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
	                            }
	                        }
	                        $percent = round($getscore/$folder['credit']*100);
	                        $percent = $percent>=100?100:$percent;
						}
                       
						?>
						<li class="fl">
							<div class=" danke2s">
								<div class="title">
								<a href="<?=$folderurl?>" <?=$target?> style="font-size:14px; color:#333;" title="<?=$folder['foldername']?>"><?=shortstr($folder['foldername'],16,'')?></a>
								</div>
								<div class="imges mt5">
								<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" height="159" width="114" /></a>
								</div>
								<div class="kewates mt5" style="position: absolute;left: 10px;top: 166px;<?php if($folder['folderid'] == 12870) { echo 'display: none;';} ?>"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>

								 <?php if($folder['folderid'] == 12870){
                                    $user = Ebh::app()->user->getloginuser();
                                    $askscore = $this->model('Roomcourse')->getNotFoldersScore($user['uid'],$roominfo['crid']);
                                ?>
                                        <div class="mt5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span2ss"><?=empty($askscore['score'])?'0':$askscore['score']?>分</span></div>

                                <?php } else {?>
                                   <?php if(empty($folder['creditmode'])){?>
									<div class="mt5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?0:$folder['creditget']?>分</span></div>
									<?php }else{?>
										<div class="mt5" style="text-align:left;margin-left:26px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=($folder['sumtime']>=$folder['credittime'])?$folder['credit']:round($folder['sumtime']/$folder['credittime']*$folder['credit'],2)?>分</span></div>
										<div class="clear"></div>
										<?php if(!empty($folder['sumtime'])){?>
										<div style="color:#777;padding-left:25px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>
									<?php }?>

                                <?php }?>
								
							</div>
						</li>
					<?php
					}?>
					</ul>
				<?php }else{//7,全校课程?>
					<div class="work_mes" style="width:1000px; ">
						<ul>
							<?php 
								$idx = 0;
								$curp = 0;
								foreach($folders as $h=>$package){
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
					foreach($folders as $j=>$package){
					?>
					<div class="kejian package package<?=$j?>" style="margin-top:0; width:1000px; border:none;<?=($curp!=$j)?'display:none;':''?>">
					
					<ul class="liss">
					<?php 
					$folderi = 0;
					$hasArr = array();
					if (!empty($package['itemlist'])) {foreach($package['itemlist'] as $folder) {
					if(!in_array($folder['folderid'],$hasArr)){
						if($folder['showmode'] !=3 ){
							$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
							$target = '';
						}
						else{
							$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
							$target = 'target="_blank"';
						}
						if($folder['folderid'] == 12870){
							$folderurl = '/college/myask/all.html';
							$target = 'target="mainFrame"';
						}
						$folderi ++;
						if (intval($folder['credit']) == 0) {
							$percent = 0;
						} else {
							if(empty($folder['creditmode'])){
	                    		$getscore = empty($folder['creditget'])?'0':$folder['creditget'];
	                        }else{
	                            if($folder['sumtime']>=$folder['credittime']){
	                                $getscore = $folder['credit'];
	                            }else{
	                                $getscore = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
	                            }
	                        }
	                        $percent = round($getscore/$folder['credit']*100);
	                        $percent = $percent>=100?100:$percent;
						}
						?>

							<li class="fl danke" style="margin-left:11px; _margin-left:2px;height:255px; text-align:left;margin-right:9px;">
							<div class="danke2s"><span class="spne" style="height:25px;font-size:14px"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><?= shortstr($folder['foldername'],16,'')?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
							<div class="clear"></div>
							<div class="showimg"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
							<div style="clear:both;"></div>
							<div class="kewates mt5 ml5" style="position:absolute;margin-left:15px;left:0;top:169px;"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>
							<?php if(empty($folder['creditmode'])){?>
								<div class="mt5 ml5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?0:$folder['creditget']?>分</span></div>
							<?php }else{?>
								<div class="mt5 ml5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=($folder['sumtime']>=$folder['credittime'])?$folder['credit']:round($folder['sumtime']/$folder['credittime']*$folder['credit'],2)?>分</span></div>
								<div class="clear"></div>
								<?php if(!empty($folder['sumtime'])){?>
									<div style="color:#777;padding-left:10px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
								<?php }?>
							<?php }?>
							</div>
							</li>
					<?php $hasArr[]= $folder['folderid'];}}} ?>
					</ul>
					</div>
					<?php }
					}?>
				</div>
			</div>
		</div>
		<?php }?>

	<div class="cmain_center" style="margin-bottom:10px;float:left;">
	
	<!--最新评论-->
	<div class="freeaudition-1">
		<div class="rankingtitle commenttabtitle">学员交流<a href="/college/review/showReview.html" class="fr blue">更多&nbsp;>></a></div>
		<div class="freeauditionlist">
			<table class="commenttab">
				<?php if(!empty($reviews)){foreach($reviews as $k=>$v){ ?>
					<tr>
						<td width="140" style="padding-bottom: 5px;">
							<?php
								$avater['face'] = $v['face'];
							    $avater['sex'] = $v['sex'];
							    $face = getavater($avater);
							?>
							<img class="inground" src="<?= $face ?>" width="40" height="40" />
							<?php
							$length =  mb_strlen($v['realname'], 'UTF8');
							if($length > 5){
								$realname =  mb_substr($v['realname'],0,4,'utf-8').'...';
							} else {
								$realname =  $v['realname'];
							}
							?>
							<span title="<?= $v['realname'] ?>"><?= $realname ?></span>

							<?php
							$length =  mb_strlen($v['classname'], 'UTF8');
							if($length > 5){
								$classname =  mb_substr($v['classname'],0,4,'utf-8').'...';
							} else {
								$classname =  $v['classname'];
							}
							?>
							<span class="classes" title="<?= $v['classname'] ?>"><?= $classname ?></span>
						</td>
						<td width="178" style="padding-bottom: 5px;" title="<?= $orireviews[$k]['subject'] ?>">
							<a href="/myroom/mycourse/<?=$v['toid']?>.html" target="_blank" style="font-size: 14px;">
							<?php
								$subject = $v['subject'];
								preg_match_all('/(<img.*?>)/', $subject, $imgArr);
								if (!empty($imgArr[0])) {
									foreach($imgArr[0] as $v) {
										$subject = str_replace($v,'@',$subject);
									}
								}

								$subjectStr  = '';
								$length =  mb_strlen($subject, 'UTF8');
								if($length > 13){
									$subject =  mb_substr($subject,0,13,'utf-8').'...';
									$subjectArr = explode('@',$subject);
									$subjectArrLen = count($subjectArr);
									foreach ($subjectArr as $k=>$v) {
										if (($k+1) < $subjectArrLen) {
											$subjectStr .= $v.$imgArr[0][$k];
										} else {
											$subjectStr .= $v;
										}
									}
								} else {
									$subjectArr = explode('@',$subject);
									$subjectArrLen = count($subjectArr);
									foreach ($subjectArr as $k=>$v) {
										if (($k+1) < $subjectArrLen) {
											$subjectStr .= $v.$imgArr[0][$k];
										} else {
											$subjectStr .= $v;
										}
									}
								}
								echo $subjectStr;
							?>
							</a>
						</td>
					<tr>
				<?php }} ?>
			</table>
		</div>
	</div>
	<!--个人排名star-->
	<div class="bsieres">
		<?php if(!$isnewzjdlr){?>
		<div class="navigation-1">
            <ul>
                <li><a href="javascript:void(0)" class="curr" id="aurank">个人排名</a></li>
                <!--<li><a href="javascript:void(0)" style="color:#333;" class="" id="acrank">单位排名</a></li>-->
            </ul>
        </div>
		 <ul id="rank-list">
		 <?php 
		$curuser = 0; 
		foreach($ranklist as $ruser){
			$curuser ++;
			$stylenum = $curuser > 3 ? 4 : $curuser;
			$name = empty($ruser['realname'])?$ruser['username']:$ruser['realname'];
			?>
			<li class="hturse" style="">
				<span class="dsure<?= $stylenum ?>"><?=$curuser?></span>
				<span class="dhsure"><?//shortstr($name,24,'')?></span>
				<span class="dsuoren"><? //$ruser['credit'] ?></span>
			</li>
		<?php }?>
		</ul>
		<!--<ul id="crank-list">
		 <?php 
			$curclass = 0; 
			foreach($classranklist as $rclass){
				$curclass ++;
				$stylenum = $curclass > 3 ? 4 : $curclass;
				$name = $rclass['classname'];
			?>
			<li class="hturse" style="">
				<span class="dsure<?= $stylenum ?>"><?= $curclass ?></span>
				<span class="dhsure" style="text-align: left;"><?=shortstr($name,24,'')?></span>
				<span class="dsuoren"><?= $rclass['credit'] ?></span>
			</li>
		<?php }?>
		</ul>-->
		<?php }?>
    </div>
	<!--个人排名end-->
		
	
		<!--通知-->
		<div class="cmain_center_r fl" style="height:361px;width:275px;margin-left:11px;">
				<h3 style="height:45px;line-height:45px;border-bottom:1px solid #ddd; position:relative;">通知<a href="<?=geturl('college/notice')?>" class="fr blue">更多&nbsp;>></a></h3>
				<?php if(!empty($notices)){?>
				<ul>
					<?php 
					$typearr = array('','');
					foreach($notices as $notice){
						$titlestyle = '';
						if((SYSTIME-$notice['dateline'])<86400*7){
							$titlestyle = 'color:red';
						}?>
					<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
					<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
					<li>
						<a target="_blank" style="<?=$titlestyle?>" title="<?=$notice['title']?>" href="<?=geturl('college/notice/'.$notice['noticeid'])?>"><?=shortstr($notice['title'],30,'')?></a>
						<p class="p2s"><?=timetostr($notice['dateline'],'Y-m-d H:i')?>（<?= $notice['type']==1?$notice['realname']:(($room_type==1) ? "公司":"学校")?>）</p>
					</li>
					<?php }?>
				</ul>
				
				
				<?php }else{?>
				<div style="text-align:center;margin-top:30px">
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/nonotice.jpg"/>
				</div>
				<?php }?>
		</div>
	</div>
<?php }else{?>
<style>
.qltbtn{
	width:127px;
	height:34px;
	line-height:34px;
	color:#fff;
	font-family:微软雅黑;
	text-align:center;
	background:#5e96f5;
	border-radius:3px;
	display:block;
	margin:0 auto;
	margin-top:30px;
	margin-bottom:55px;
	font-size:14px;
}
.zwtp{
	text-align:center; 
	margin-top:45px; 
	height:182px;
	overflow:hidden;
}
.zwktrykc{
	font-family:微软雅黑;
	font-size:20px; 
	color:#666; 
	text-align:center;
}
</style>
		<!--没有开通课程-->
		<div class="cmain_bottom ">
			<div style=" border-bottom:none; padding-bottom:0;" class="study fl">
				<div class="nodata"></div>
				<p class="zwktrykc">暂未开通任何课程</p>
				<a href="/myroom/college/study.html"  target="mainFrame" class="qltbtn">去开通</a>
			</div>
		</div>
<?php }?>
</body>
<style>
a {color: #3d3d3d;text-decoration: none;}
.workcurrent a span {background: url("http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg") no-repeat left 0;color: #2696f0;display: block;padding: 0 0 0 12px;}
.work_mes ul li{ width:auto !important;}
.cmain_bottom .study .xialas{top:-5px;}
.cmain_bottom .study_bottom ul li{ margin-bottom:10px;}
.kejian .showimg{ margin-left:15px;}
.kejian .liss .danke .spne{ margin-left:10px; line-height:30px;}
.showimg > a{display:block; height:155px;}
.spne a:hover{ color:#3095c6; text-decoration:underline;}
.danke2s{ display:inline-block; width:146px;  padding-top:3px;}
.imges img,.kewates{ margin-left:15px;}
.danke2s:hover{ box-shadow:0 0 5px #ccc;}
.cmain_center_r ul li{display:block!important;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar3.js?v=116061301"></script>
<script>
var Calendar = new Calendar("<?=SYSTIME?>");
$(function(){
	Calendar.init();
	
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();

});

$('.more,.xialas').mouseover(function(){
	$('.xialas').show();
});
$('.more,.xialas').mouseout(function(){
	$('.xialas').hide();
});

$(function(){
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
//	$("#aurank").on("click",function(){
//		$("#acrank").removeClass("curr");
//		$("#crank-list").hide();
//		$("#aurank").addClass("curr");
//		$("#rank-list").show();
//	});
//	$("#acrank").on("click",function(){
//		$("#aurank").removeClass("curr");
//		$("#rank-list").hide();
//		$("#acrank").addClass("curr");
//		$("#crank-list").show();
//	});
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