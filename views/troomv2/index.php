<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160422001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=20160718001"/>
 <link type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" rel="stylesheet"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=getv()?>" />
</head>
<body>
<?php //最新课程,今天起的7天内
	if(!empty($newcwlist)){
?>
<div class="jijiangkk" style="margin-bottom:10px">
	<h2 style="border-bottom: 1px solid #efefef;">最新课程</h2>
    <div class="jijiangkk_son">
		<?php $i=0;
		$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
		// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
		$lineimgarr[1]['todayunstart'] = 1;
		$lineimgarr[1]['now'] = 7;
		$lineimgarr[1]['unstart'] = 4;
		$lineimgarr[1]['end'] = 5;
		
		$lineimgarr[0]['todayunstart'] = 3;
		$lineimgarr[0]['now'] = 8;
		$lineimgarr[0]['unstart'] = 2;
		$lineimgarr[0]['end'] = 6;
		foreach($newcwlist as $k=>$listbyday){
			$find = array('x','y','z');
			$replace = '';
			$k = str_replace($find,$replace,$k);
			foreach($listbyday as $cw){
				$i++;
				$lineimgtype = intval($i==1); //第一位还是其他
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
			<!-- 正在上课 当前时间在课程发布时间+课件时间范围内 显示正在上课 -->
			<!-- 即将开始上课  当前时间还未到课件发布时间的 显示橙色 -->
			<!-- 已经结束的  当前时间已经超过课件发布+播放时间 显示灰色-->
			<?php 
			$starttime = $cw['truedateline'];
			$cwlenth = $cw['cwlength'];//课件时长
			$nowtime = SYSTIME;
			$html = '';
			if($nowtime <= $starttime){
			    //即将开始
			    $html = '<div class="fl jjikk_sons_l">'.date('H:i',$starttime).'&nbsp;</div>';
				$lineimg = $lineimgarr[$lineimgtype]['todayunstart'];
			}elseif(!empty($cwlenth) && ($nowtime>=$starttime) && (($starttime+$cwlenth) >= $nowtime) && (empty($cw['endat']) || $cw['endat']>=$nowtime)){
			    //正在上课
			    $html = '<div class="fl jjikk_sons_l starting">正在上课...&nbsp;</div>';
				$lineimg = $lineimgarr[$lineimgtype]['now'];
			}elseif($nowtime > ($starttime+$cwlenth) || (!empty($cw['endat']) && $nowtime>$cw['endat'])){
			    //已结束
			    $html = '<div class="fl jjikk_sons_l '.(($starttime<SYSTIME)?'expired':'').'">'.date('H:i',$starttime).'&nbsp;</div>';
				$lineimg = $lineimgarr[$lineimgtype]['end'];
			}
 
			echo  $html;
			?>
        	
        	
			<?php }else{
				$lineimg = $lineimgarr[$lineimgtype]['unstart'];?>
        	<div class="fl jjikk_sons_l jjikk_sons_ls"><span style="font-family:微软雅黑;font-size:12px;"><?=$k?>&nbsp;</span><br /><?=Date('H:i',$cw['truedateline'])?>&nbsp;</div>
			<?php }?>
			<div class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/jijiangkk<?=$lineimg?>.png?v=20170718001" width="24" height="143" /></div>
            <div class="fl jjikk_sons_r">           	
            	<div class="fl jjkkkc">
					<a class="kustgd" href="<?=geturl('troomv2/course/'.$cw['cwid'])?>" target="_blank" class="opens viewc"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png"></a>
					<div class="kcbj"><img width="167" height="100" src="<?=$logo?>"></div>
				</div>
                <div class="kcjsnr fl">
                	<h2><a href="<?=geturl('troomv2/course/'.$cw['cwid'])?>" target="_blank"><?=$cw['title']?></a></h2>
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
<!--巴南党校一些文字调整-->
<?php $curdomain = $this->uri->uri_domain();?>

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
						<?php if(empty($survey['aid'])){?><a href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank" class="lsneit"><?php }else{?><a href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank" class="lsneit"><?php }?><?=strip_tags($survey['title'])?></a>
						<p class="lnstre">管理员 <?=date("Y-m-d H:i", $survey['dateline'])?></p>
					</div>
					<?php if(empty($survey['aid'])){?><a class="wenbtn" href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank">参与调查</a><?php }else{?><a class="wenbtn" href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank">查看详情</a><?php }?><?php if (!empty($survey['allowview'])) {?><a class="wenbtn" href="/college/survey/stat/<?=$survey['sid']?>.html" target="_blank">统计</a><?php }?>
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
                <div><h2>签到</h2></div>
                <div class="mmain" onselectstart="return false">
					<div class="ketsdsr">
						<div class="kuelrwr"><span class="dairer"><?php echo date('m',SYSTIME)?></span>月</div>
						<div class="lisnimisnr">
							<p>签到有礼</p>
                            <?php $weekarr = array('日','一','二','三','四','五','六');?>
							<p>今天是<?php echo date('m',SYSTIME)?>月<?php echo date('d',SYSTIME)?>日【星期<?=$weekarr[Date('w',SYSTIME)]?>】,当月已签到<span class="ewrewse" day = <?php echo $monnum?>><?php echo $monnum?></span>天</p>
						</div>
                        <span id="creditplus" style="display:none;position:absolute;color:orange;right:417px;top:25px;z-index:100">+1积分</span>
						<a style="display: <?=!empty($signed)?'none':''?>" href="javascript:;" onclick="signin()" class="dasores" id="qd" title="已连续签到<?php echo $continuous?>天">签到</a>

                        <p id="yqd" style="display: <?=empty($signed)?'none':''?>;opacity: 0.5;filter:alpha(opacity=50)" day="<?php echo $continuous?>"><a href="javascript:;" class="dasores" style="cursor: default;" title="已连续签到<?php echo $continuous?>天">已签到</a></p>

					</div>
					<div class="leftrl">
						<div class="tisrzher"></div>
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
				</div>
            </div>
            <!--通知-->
            <div class="cmain_center_r t fr">
            	<h3><span class="erksretd">通知</span><a href="/troomv2/notice/send.html" class="klasner">发通知</a></h3>
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
                		<a target="_blank" style="<?=$titlestyle?>" title="<?=$notice['title']?>" href="<?=geturl('troomv2/notice/'.$notice['noticeid'])?>"><?=shortstr($notice['title'],33,'')?></a>
                		<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
						<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>
                		<p class="p2s"><?=timetostr($notice['dateline'],'Y-m-d H:i')?>（<?=$notice['type']==1?shortstr($notice['realname'],12):(($room_type==1) ? "公司":"学校")?>）</p>
                		
                	</li>
					<?php }?>
                </ul>
				
                <a href="<?=geturl('troomv2/notice')?>" class="fr" style="color:#999; line-height:25px;position:absolute;bottom:5px;right:10px">更多&nbsp;>></a>
				<?php }else{?>
				<div style="text-align:center;margin-top:30px">
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/nonotice.jpg"/>
				</div>
				<?php }?>
            </div>
        </div>
        <div class="clear"></div>
		<div class="trobottom" style="background:#fff;">
			
				<h3 class="waitite1s"><span>教学记录</span></h3>
				<div class="trobottomleft">
				<div class="jxjlsyt" style="overflow: hidden">
					<div id="container" style="width: 240px;height: 240px;margin-top: 10px;"></div>
				</div>
				<div class="plwtsx">
                    <?php $queryarr['crid'] = $roominfo['crid'];
                    $queryarr['toid'] = $user['uid'];$queryarr['fromid']=-1?>
					<a href="<?=geturl('troomv2/msg/review')?>" target="mainFrame" class="plwtsxa">评论(<?php $queryarr['type']=4; $m = $this->model('message')->getMsgCount($queryarr);echo $m;?>)</a>
					<a href="<?=geturl('troomv2/msg/question')?>" target="mainFrame" class="plwtsxa">问题(<?php $queryarr['type']=5; echo $this->model('message')->getMsgCount($queryarr);?>)</a>
					<a href="<?=geturl('troomv2/msg/message')?>" target="mainFrame" class="plwtsxa" style="padding-right:0;">私信(<?php unset($queryarr['type']); $queryarr['typelist']='1,3'; echo $this->model('message')->getMsgCount($queryarr);?>)</a>
				</div>								
			</div>
			<div class="trobottomright">
					<div class="jfphsyt">
						<div id="container1" style="height: 280px;margin-right: 30px;margin-top: 50px;"></div>
					</div>
				</div>
		<div class="clear"></div>		
            <?php if(!empty($subjectlist)) {
                if($roominfo['isschool'] != 7){?>
                    <div class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-1' : 'kejian' ?>" style="padding:10px 0 20px 0;">
                        <ul class="<?=$roominfo['template'] == 'plate' ? '' : 'liss' ?>">
							<?php if ($roominfo['template'] == 'plate') {
								foreach($subjectlist as $subject) {
									$img = show_plate_course_cover($subject['img']);
									?>
									<li>
										<a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img class="courseimg-2" src="<?= empty($img) ? 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg' : show_thumb($img, '212_125') ?>" width="212" height="125" /></a>
										<a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>" class="coursrtitle-2"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)
										<div class="bordershadow"></div></a>
									</li> 
								<?php }
							} else {
								 foreach($subjectlist as $subject) { ?>
									<li class="danke">
										<div class="showimg"><a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></a></div>
										<span class="spne"><a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" style="text-decoration: none;" title="<?= $subject['foldername'] ?>"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)</a></span>
									</li>
								<?php }
							 } ?>
                        </ul>
                    </div>
                <?php }else{?>
                    <div class="work_mes">
                        <ul>
                            <?php $i=0;foreach($folderbypid as $k=>$package){?>
                                <li class="<?=$i==0?'workcurrent':''?> ptab" id="tab<?=$k?>"><a href="javascript:void(0)" title="<?=$package[0]['pname']?>" onclick="changetab(<?=$k?>)"><span><?=$package[0]['pname']?></span></a></li>
                                <?php $i++;}?>
                        </ul>
                    </div>
                    <?php
                    $i=0;foreach($folderbypid as $k=>$package){?>
                        <div class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-1' : 'kejian' ?>" style="padding:10px 0 20px 0;<?=$i==0?'':'display:none'?>" id="pack<?=$k?>">


                            <ul class="<?=$roominfo['template'] == 'plate' ? '' : 'liss' ?>">
								<?php if ($roominfo['template'] == 'plate') {
									foreach($package as $subject) {
										$img = show_plate_course_cover($subject['img']); ?>
										<li>
											<a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img class="courseimg-2" src="<?= empty($img) ? 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg' : show_thumb($img, '212_125') ?>" width="212" height="125" /></a>
											<a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>" class="coursrtitle-2"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)
											<div class="bordershadow"></div></a>
										</li>
									<?php }
								} else {
									foreach($package as $subject) { ?>
										<li class="danke">
											<div class="showimg"><a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></a></div>
											<span class="spne"><a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" style="text-decoration: none;" title="<?= $subject['foldername'] ?>"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)</a></span>
										</li>
									<?php }
								 } ?>
                            </ul>
                        </div>
                        <?php $i++;}
                }
            } else { ?>

                <div class="noke" style="border:none; margin:0 auto; width:1000px;"><p>您还没有<span>开设任何课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>

            <?php } ?>
		</div>
		<div class="clear"></div>
</body>
<style>
a {color: #666;text-decoration: none;}
.cmain_bottom .study .xialas{top:-5px;}
.cmain_bottom .study_bottom ul li{ margin-bottom:10px;}
.lefrig{
	padding-bottom:10px;
	margin-top:10px;
}
.kejian {
	width: 1000px;
	background:#fff;
	float:left;
	border:none;
	margin-top:0;
	padding-top:15px;
}
.kejian .showimg {
	margin-top: 10px;
	margin-left: 14px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-left:20px;
	display:inline;
	margin-top: 8px;
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 135px;
	height: 36px;
	line-height:15px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}
.showimg { float:left;}
.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid;}
.noke {
	height: 480px;
	width: 786px;
	float: left;
	border: 1px solid #cdcdcd;
	background: #fff;
}
.noke p {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
	height: 120px;
	margin-top: 90px;
	margin-left: 251px;
	padding-left: 140px;
	font-size: 16px;
	padding-top: 30px;
    width: 307px;
}
.noke span {
	color: #e94f29;
}
.work_mes {
	border-bottom:solid 1px #ffffff;
	background:#fff;
}
.danke:hover{ box-shadow:0 0 5px #ccc;}
.showimg img:hover{
	border:1px solid #5e96f5;
}
.highcharts-tooltip {
    z-index: 9998 !important;
}
.bordershadow{
	top:135px;
	height:24px;
}
.expired {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dates2.png?v=02) no-repeat scroll center center;
    color: #fff;
    font-family: Arial;
    font-size: 14px;
    font-weight: bold;
    height: 28px;
    left: 2px;
    line-height: 28px;
    position: relative;
    text-align: center;
    top: 50px;
    width: 93px;
}
.starting {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dates3.png?v=02) no-repeat scroll center center;
    color: #fff;
    font-family: Arial;
    font-size: 12px;
    font-weight: bold;
    height: 28px;
    left: 2px;
    line-height: 28px;
    position: relative;
    text-align: center;
    top: 50px;
    width: 93px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar3.js?v=16061301"></script>
<!--<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar2.js?v=15051902"></script>-->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-more.js"></script>
<script>
var Calendar = new Calendar("<?=SYSTIME?>");
$(function(){
	var p = new Object();
	p.uid = 1;
	Calendar.init(p);

	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
    $('.mmain ul li.curDate a.huaqian').addClass('daysel');
});

//签到
function signin(){
    $.ajax({
        type:'POST',
        'url':'/troomv2/mysetting/sign.html',
        data:{'signin':1},
        success:function(data){
            var title = parseInt($('#yqd').attr('day'))+1;
            $('.ewrewse').html((1+parseInt($('.ewrewse').attr('day'))));
            $('.dasores').attr('title','已连续签到'+title+'天');
            $('#qd').hide();
            $('#yqd').show();
            $('#creditplus').fadeTo(1000,1);
            $('#creditplus').fadeTo(2000,0)
            $('.mmain ul li.curDate a.huaqian').addClass('hasinfo');
        }
    });

}
    $(function () {
        $('#container').highcharts({
            chart: {
                polar: true,
                type: 'line'
            },
//            plotOptions: {
//                line: {
//                    dataLabels: {
//                        enabled: true
//                    }
//                }
//            },
            title: {
                text: '',
                x: -80
            },
            pane: {
                size: '80%'
            },
            credits:{
                enabled:false
            },
//            legend:{
//                enabled:false
//            },
            xAxis: {
                categories: ['作业', '互动', '附件', '评论',
                    '答疑', '课件'],
                tickmarkPlacement: 'on',
                lineWidth: 0
            },
            tooltip: {
                valueSuffix: '%',
                useHTML: true,
                style:{
                    zIndex:1
                }

            },
            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 0,
                min: 0,
                tickPositions: [0,25,50],
                labels: {
                    enabled: false        //Y轴标签不显示
                }
            },
            legend: {
                enabled:false
            },
            series: [ {
                name:'数量',
                data: [<?php echo $recordinfo?>],
                pointPlacement: 'on'
            }]

        });
    });
$(function () {
    $('#container1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        credits: {
            text: ''
        },
        xAxis: {
            categories: [
               <?php echo $rank['name']?>
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: '教<br>学<br>积<br>分',
                rotation:0,
                align:'high'
            }
//            gridLineWidth: 0
        },
        credits:{
            enabled:false
        },
        //隐藏注释
        legend:{
            enabled:false
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '积分',
            data: [<?php echo $rank['credit']?>]

        }]
    });
});
function changetab(pid){
    $('.ptab').removeClass('workcurrent');
    $('#tab'+pid).addClass('workcurrent');
    $('.kejian').hide();
	$('.studycourse.studycourse-1').hide();
    $('#pack'+pid).show();
    parent.resetmain();
}
    //定义Cookie  
    function setCookie(name, value, expire) {  
        window.document.cookie = name + "=" + escape(value) + ((expire == null) ? "" : ("; expires=" + expire.toGMTString()));  
    }  
    function getCookie(Name) {  
        var search = Name + "=";  
        if (window.document.cookie.length > 0) {   
        // 如果没有则下一个   
            offset = window.document.cookie.indexOf(search);  
            if (offset != -1) {  
             // 如果找到   
                offset += search.length;  
                // 设置开始   
                end = window.document.cookie.indexOf(";", offset)  
                // 结束  
                if (end == -1)  
                    end = window.document.cookie.length;  
                return unescape(window.document.cookie.substring(offset, end));  
            }  
        }  
        return null;  
    }  
    function register(name) {  
        var today = new Date();  
        var expires = new Date();  
        expires.setTime(today.getTime() + 1000 * 60 * 60 * 24);  
        setCookie("ItDoor", name, expires);  
    }  
   
    function openWin() {  
        var c = getCookie("ItDoor");  
        if (c != null) {  
            return;  
        }  
        register();  
		//通知弹窗
	 $.ajax({  
			dataType:"json",
			type:"get",  
			url:"<?=geturl('troomv2/default/getnoticeRemind')?>",//接口服务器地址  
			success:function(data){
				if (data.code == 1) {
					//console.log(data);
					top.dialog({
						id: "abc", //可选
						title: "通知",
						content: "您有新的通知还未查看",
						okValue: "前往查看",
						ok: function() {
							window.location.href="/troomv2/notice.html"
						},
						cancelValue: "",
					}).showModal(); //show:无遮罩层,showModal:有遮罩层，需要全屏显示请在dialog前加上top,例：top.dialog({....}).showModal()
				}
				else {
					return false;
				}
			}
		})
    }  
    openWin();  
    window.focus()  
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/loginlog.js<?=getv()?>" crid="<?=$roominfo['crid']?>" id="loginlogjs"></script>
</html>