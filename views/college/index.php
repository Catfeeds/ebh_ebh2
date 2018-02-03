<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $v=getv();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20161110001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=$v?>" />

</head>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2016/css/titlecs.css<?=$v?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/courseware.css<?=$v?>" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.silver_track.js"></script>
<body style="background:#f3f3f3;">
<!--巴南党校一些文字调整-->
<?php $curdomain = $this->uri->uri_domain();?>


<!-- 判断是否有购买记录 -->
<?php 
if(($paycount>0) || (in_array($roominfo['isschool'], array(6,7))==false)){?>
	<?php
if(!empty($surveys)){
?>
<div class="cmain_bottom mb10">
	<div class="study" style=" padding-bottom:0;">
		<div class="study_top" style="background:#fff;">
			<div class="fl"><h3>调查问卷</h3></div>
			<div class="fr">
			<a href="<?=geturl('college/survey/surveylist')?>" style="padding-right:12px;color:#999;">更多&nbsp;>></a>
			</div>
		</div>
		<div class="clear"></div>
		<div class="lrytur">
			<ul>
<?php foreach($surveys as $k => $survey){?>
				<li class="rtlewe">
					<div class="rtdixu">
					<?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
						<a href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank" class="lsneit">
					<?php }else{?>
						<a href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank" class="lsneit">
					<?php }?><?=strip_tags($survey['title'])?></a>
						<p class="lnstre">管理员 <?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d',$survey['enddate'])?></p>
					</div>
				<?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
					<a class="wenbtn" href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank">参与调查</a>
				<?php }else{?>
					<a class="wenbtn" href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank">查看详情</a>
				<?php }?>
				<?php if (!empty($survey['allowview'])) {?><a class="wenbtn" href="/college/survey/stat/<?=$survey['sid']?>.html" target="_blank">统计</a>
				<?php }?>
				</li>
<?php }?>
			</ul>
		</div>
	</div>
</div>
<?php }?>
	<div class="cmain_center">
        	<!--日历-->
            <div class="cmain_center_l fl">
                <div><h2><?=$curdomain == 'bndx' ? '教学安排' : '日历'?></h2></div>
                <div class="mmain" onselectstart="return false">
				<div class="leftrl">
					<div class="chead" style="">
						<span>周日</span>
						<span>周一</span>
						<span>周二</span>
						<span>周三</span>
						<span>周四</span>
						<span>周五</span>
						<span>周六</span>
					</div>
					<ul id="mainContent">
						
						
					</ul>
					</div>
					<div class="overview">
						<div class="header"><span class="year" style="font-size:16px"></span><span class="month" style="font-size:16px"></span>
						<i class="icon icon-chevron-left prev lefrty" >&lt;</i>
						<i class="icon icon-chevron-right nexts rigrty" >&gt;</i>
						</div>
						<div style="line-height:normal">
						<strong class="active-date"></strong><strong class="active-day"></strong>
						</div>
						<div class="studyinfo">
							
						</div>
						
						
					</div>
				</div>
            </div>
            <!--通知-->
            <div class="cmain_center_r fr">
            	<h3>通知</h3>
				<?php if(!empty($notices)){?>
                <ul>
					<?php 
					$typearr = array('','');
					foreach($notices as $notice){
						$titlestyle = '';
						if((SYSTIME-$notice['dateline'])<86400*7){
							$titlestyle = 'color:red';
						}?>
                	<li>
                		<a target="_blank" style="<?=$titlestyle?>" title="<?=$notice['title']?>" href="<?=geturl('college/notice/'.$notice['noticeid'])?>"><?=shortstr($notice['title'],30,'')?></a>
                		<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
						<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
                		<p class="p2s"><?=timetostr($notice['dateline'],'Y-m-d H:i')?>（<?= $notice['type']==1?shortstr($notice['realname'],12):(($room_type==1) ? "公司":"学校")?>）</p>
                	</li>
					<?php }?>
                </ul>
				
                <a href="<?=geturl('college/notice')?>" class="fr" style="color:#999; line-height:25px;position:absolute;bottom:5px;right:10px">更多&nbsp;>></a>
				<?php }else{?>
				<div style="text-align:center;margin-top:30px">
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/nonotice.jpg"/>
				</div>
				<?php }?>
            </div>
        </div>
        <div class="clear"></div>
		
<?php //最新课程,今天起的7天内
	if(!empty($newcwlist)){
?>
<div class="jijiangkk" style="margin-top:10px">
	<h2>最新课程</h2>
    <div class="jijiangkk_son">
		<?php $i=0;
		$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
		// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
		foreach($newcwlist as $k=>$listbyday){
			$find = array('x','y','z');
			$replace = '';
			$k = str_replace($find,$replace,$k);
			foreach($listbyday as $cw){$i++;
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
    	<div class="jjikk_sons">
			<?php if($k=='今天'){?>
        	<div class="fl jjikk_sons_l"><?=Date('H:i',$cw['truedateline'])?></div>
			<?php }else{?>
        	<div class="fl jjikk_sons_l jjikk_sons_ls"><span style="font-family:微软雅黑;"><?=$k?></span><br /><?=Date('H:i',$cw['truedateline'])?></div>
			<?php }?>
			<div class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/jijiangkk<?=$i==1?($k=='今天'?1:4):($k=='今天'?3:2)?>.png?v=20160718001" width="24" height="143" /></div>
            <div class="fl jjikk_sons_r">           	
            	<div class="fl jjkkkc">
					<a class="kustgd" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank" class="opens viewc"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png"></a>
					<div class="kcbj"><img width="167" height="100" src="<?=$logo?>"></div>
				</div>
                <div class="kcjsnr fl">
                	<h2><a href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank"><?=$cw['title']?></a></h2>
                    <p><?=$cw['summary']?></p>
                    <p class="zjlsp">主讲：<?=$cw['realname']?></p>
                </div>
            </div>
        </div>
		<div class="clear"></div>
		<?php }
		}?>
        
    </div>
</div>
<?php }?>
		
		
		<?php if(!empty($folders) || !empty($cwlist)){?>
        <div class="cmain_bottom mt10">
        	<!--学习-->
            <div class="study" style="<?=$roominfo['isschool']==7?'background:none;':''?>border-bottom:none; padding-bottom:10px;">
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
                <div style="padding-bottom:20px;" class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-2' : 'study_bottom' ?>">
				<?php if($roominfo['isschool'] != 7){?>
                	<ul class="mt15">
					<?php
					if ($roominfo['template'] == 'plate') {
						foreach($folders as $folder){
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
							$img = show_plate_course_cover($folder['img']);
							$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
							?>
							<li class="fl">
								<div class=" danke2s-1">
									<a href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>" class="coursrtitle-1"><?=$folder['foldername']?><div class="bordershadow"></div></a>
									<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?= $img?>" height="125" width="212" /></a>
									<div class="rateoflearnfa">
										<p class="rateoflearning" style="width:<?=$percent?>%;">
											<span class="rateoflearnspan"><?=$percent?>%</span>
										</p>
									</div>
									<?php if(empty($folder['creditmode'])){?>
										<div><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=empty($folder['creditget'])?0:$folder['creditget']?>分</span></div>
									<?php }else{?>
										<div><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=($folder['sumtime']>=$folder['credittime'])?$folder['credit']:round($folder['sumtime']/$folder['credittime']*$folder['credit'],2)?>分</span></div>
										<div class="clear"></div>
										<!--<?php if(!empty($folder['sumtime'])){?>
											<div style="color:#777;text-align:left;line-height:18px;">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>-->
									<?php }?>
								</div>
							</li>
							<?php
						}
					} else {
						foreach($folders as $folder){
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
							<li class="fl">
								<div class=" danke2s">
									<div class="title">
										<a href="<?=$folderurl?>" <?=$target?> style="font-size:14px; color:#333;" title="<?=$folder['foldername']?>"><?=shortstr($folder['foldername'],16,'')?></a>
									</div>
									<div class="imges mt5">
										<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" height="159" width="114" /></a>
									</div>
									<div class="kewates mt5" style="position: absolute;left: 10px;top: 166px;"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>
									<?php if(empty($folder['creditmode'])){?>
										<div class="mt5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?0:$folder['creditget']?>分</span></div>
									<?php }else{?>
										<div class="mt5" style="text-align:left;margin-left:26px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=($folder['sumtime']>=$folder['credittime'])?$folder['credit']:round($folder['sumtime']/$folder['credittime']*$folder['credit'],2)?>分</span></div>
										<div class="clear"></div>
										<?php if(!empty($folder['sumtime'])){?>
											<div style="color:#777;padding-left:25px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>
									<?php }?>
								</div>
							</li>
							<?php
						}
					}?>
                    </ul>
				<?php }else{//7,我开通的课程?>
					<div class="track example-1">
						<div class="inner">
							<div class="view-port">
								<div class="slider-container"  id="example-1">
								<?php if(!empty($cwlist)){?>
								<div class="packatab packagetab item" onclick="showpackage('cwlist')"><a href="javascript:void(0)"><span>我的单课列表</span></a></div>
								<?php }?>
							<?php 
								$idx = 0;
								$curp = 0;
								foreach($folders as $h=>$package){
									if(count($package['itemlist'])>0){
							?>
								<div class="<?=($idx==0 && empty($cwlist))?'packatab':''?> packagetab item" onclick="showpackage(<?=$h?>)"><a href="javascript:void(0)"><span><?=$package['pname']?></span></a></div>
									
						
							<?php $idx++;
									if($curp == 0 && empty($cwlist))
									$curp=$h;
								}
							}?>
								</div>
							</div>
						</div>
						<div class="pagination">
							<a href="#" class="prev disabled"></a>
							<a href="#" class="next disabled"></a>
						</div>
					</div>
					<?php if(!empty($cwlist)){
						$this->assign('my',true);//我的课件列表
					$this->display('college/cwlist_cwpay');}?>
					<?php 
					foreach($folders as $j=>$package){
					?>
					<div class="kejian package package<?=$j?>" style="margin-top:0; width:1000px; border:none;<?=($curp!=$j)?'display:none;':''?>">
					
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


						if ($roominfo['template'] == 'plate') {
							$img = show_plate_course_cover($folder['img']);
							$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg'; ?>
							<li class="fl">
								<div class=" danke2s-1">
									<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>" class="coursrtitle-1"><?= $folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?>
									<div class="bordershadow"></div></a>
									<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><img src="<?= $img?>" height="125" width="212" /></a>
									<div class="rateoflearnfa">
										<p class="rateoflearning" style="width:<?=$percent?>%;">
											<span class="rateoflearnspan"><?=$percent?>%</span>
										</p>
									</div>
									<?php if(empty($folder['creditmode'])){?>
										<div class=""><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=empty($folder['creditget'])?0:$folder['creditget']?>分</span></div>
									<?php }else{?>
										<div class=""><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=($folder['sumtime']>=$folder['credittime'])?$folder['credit']:round($folder['sumtime']/$folder['credittime']*$folder['credit'],2)?>分</span></div>
										<div class="clear"></div>
										<!--<?php if(!empty($folder['sumtime'])){?>
											<div style="color:#777;line-height:18px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>-->
									<?php }?>
								</div>
							</li>
						<?php } else { ?>
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
						<?php }
						?>




					<?php $hasArr[]= $folder['folderid'];}} ?>
					</ul>
					</div>
					<?php }
					}?>
                </div>
            </div>
        </div>
		<?php }?>
	
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
.workcurrent a span {background: url("http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg") no-repeat left 0;color: #4c88ff ;display: block;padding: 0 0 0 12px;}
.work_mes ul li{ width:auto !important; margin:0 15px;}
.cmain_bottom .study .xialas{top:-5px;}
.cmain_bottom .study_bottom ul li{ margin-bottom:10px;}
.kejian .showimg{ margin-left:15px;}
.kejian .liss .danke .spne{ margin-left:10px; line-height:30px;}
.showimg > a{display:block; height:155px;}
.spne a:hover{ color:#3095c6; text-decoration:underline;}
.danke2s{ display:inline-block; width:146px;  padding-top:3px;}
.imges img,.kewates{ margin-left:15px;}
.danke2s:hover{ box-shadow:0 0 5px #ccc;}

</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar3.js?v=116061301"></script>
<script>
var Calendar = new Calendar("<?=SYSTIME?>");
$(function(){
	Calendar.init();
	
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
	if($('.slider-container').width()<960)
		$('.pagination .next').addClass('disabled');
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
					$('#folder'+v.folderid).append('<span  class="coursetishi">'+v.count+'</span>');
				});
			}
		});
	}
});

$('.packagetab').click(function(){
	$('.packatab').removeClass('packatab');
	$(this).addClass('packatab');
	parent.resetmain();
});
function showpackage(pid){
	$('.package').hide();
	$('.package'+pid).show();
}
var track = $(".slider-container").silverTrack();
var terparent = track.container.parents(".track");
 
// 左右箭头
track.install(new SilverTrack.Plugins.Navigator({
  prev: $("a.prev", terparent),
  next: $("a.next", terparent)
}));

track.start();
</script>
</html>