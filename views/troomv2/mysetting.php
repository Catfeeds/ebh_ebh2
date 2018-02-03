<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20151014001">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/wangind.css?version=20151014001">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js?version=20150825001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
</head>
<body>
<script>

$(function(){
	<?php if(empty($notop)){?>
	if (top.location == self.location) {
		setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
		top.location='/troom.html';
    }
	<?php }?>
});
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>

<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style type="text/css">
	
	.mmain{clear: both;font-size: 12px;text-align: center;font-weight:bold;width:788px;float:left;background:#fff;border-top:none}
	.mmain ul li{width:80px;height: 40px;float:left;}
	.mmain ul li a span{float:left;width:80px;}
	
	.mmain .chead{border-bottom: solid 1px #f1f1f1;width:560px;float:left;height: 45px;line-height: 45px;background:#fff;font-family: PingHei,'Hiragino Sans GB','Microsoft YaHei',arial,sans-serif;}
	.mmain .chead span{text-align:center;display:block;float:left;width:80px;color: #555;font-size:12px}

	#mainContent li.curDate{background: #2cabee;}
	.pmdate a,.nmdate a{color:#aaa;}
	#mainContent .disnone{display: none;}
	#mainContent a{cursor: pointer;}
	.curDate span {color:#000;}
	.mmain ul li a.huaqian {display:block;width:80px;height:40px;line-height:40px;background:#fff;}
	.mmain ul li a.huaqian0 {display:block;width:80px;height:40px;line-height:40px;background:#fff;}
	.mmain ul li.curDate a.huaqian{background: #cbf1ff;}
	.mmain ul li a.huaqian:hover {background:#e4f8ff;}
	.mmain ul li.curDate a.huaqian:hover {background:#cbf1ff;}
	
	
	.mmain ul li a em{display:inline-block;width:23px;height:13px;line-height:13px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -142px -184px;color:#5084d7;font-weight: bold;}
	.tietyk {
		background:#80d1fc;
		width:788px;
		height:38px;
		line-height:38px;
		font-weight:bold;
		color:#fff;
		font-size:14px;
		text-align:center;
		position:relative;
	}
	
	.datable td {
		border-bottom: 1px dashed #D2D2D2;
		padding: 6px 6px;
		text-align: left;
	}
	.aenbh{
		*margin-top:8px;
	}
	.wangind .timike{
		margin-bottom:0px;
	}
	.timike h2 span{
	}
	.mmain ul li a.hasinfo{
	background:#FFCFDD;
}
.mmain ul li a.daysel{
	background:#e4f8ff;
}
.msubject span {
    background: url("http://static.ebanhui.com/ebh/tpl/2014/images/ico_1.jpg") no-repeat left center;
    clear: both;
    display: inline-block;
    height: 31px;
    line-height: 31px;
    width: 26px;

	}
	.msubject1 span {
    background: url("http://static.ebanhui.com/ebh/tpl/2014/images/ico_2.jpg") no-repeat left center;
    clear: both;
    display: inline-block;
    height: 31px;
    line-height: 31px;
    width: 26px;
	
	}
	.msubject2 span {
    background: url("http://static.ebanhui.com/ebh/tpl/2014/images/ico_3.jpg") no-repeat left center;
    clear: both;
    display: inline-block;
    height: 31px;
    line-height: 31px;
    width: 26px;
	
	}
	.kusts {
		position: relative;
	}
	a.luist {
		position: absolute;
		top:5px;
		right:0px;
	}
	.msubject > em{margin-left: 5px;position: relative;top: -10px;}
	.msubject1 > em{margin-left: 5px;position: relative;top: -10px;}
	.msubject2 > em{margin-left: 5px; position: relative;top: -10px;}
	.studyinfo{text-align:center; margin-top:25px;display: inline-block;}
	.studyinfo_son{display:inline; width:55px; margin-left:5px; margin-right:10px;}
</style>

<div class="wangind">
	<div style="background:#fff;float:left;width: 788px;border-bottom:none;">
        <div class="cmain_top_r fr">
            <div class="titles fl">
                <span>Hello！<?=$user['realname']?>&nbsp;老师，欢迎使用e板会。</span>
            </div>
			<?php if(!empty($signed)){
					$showsign[0] = ' style="display:none"';
					$showsign[1] = '';
				}else{
					$showsign[0] = '';
					$showsign[1] = ' style="display:none"';
				}
				$weekarr = array('日','一','二','三','四','五','六');
			?>
        	<div class="grkgee fr">
				<p class="dgrtwe"><span style="font-size:16px; display:block; height:25px;"><?=Date('Y-m-d',SYSTIME)?></span><span class="dates"><?=Date('d',SYSTIME)?></span>&nbsp;星期<?=$weekarr[Date('w',SYSTIME)]?></p>
				<span id="creditplus" style="display:none;position:absolute;color:orange;right:57px;top:-2px;z-index:100">+1积分</span>
				<a href="javascript:void(0)" class="daotqian" onclick="signin()" <?=$showsign[0]?>>签到<br><span style="font-size:14px; line-height:5px; *line-height:12px;"><?=$continuous?>天</span></a>
				<p class="daotqian2" <?=$showsign[1]?> title="已经连续签到<?=$continuous?>天" day="<?=$continuous?>">已签到<br><span style="font-size:14px; line-height:5px;*line-height:12px;" class="afsign"><?=$continuous?>天</span></p>
			</div>
        </div>
		<div class="esukang">
			<a href="http://exam.ebanhui.com/enew/<?=$room['crid']?>.html" class="addexam" id="zuoye" target="_blank"></a>
			<a href="<?=geturl('troomv2/classsubject/courses')?>" class="addcourse" id="course"></a>
			<a href="<?=geturl('troomv2/myask')?>" class="addanswer" id="ask">
			<?php if($count>0 && $count<=99 ){ ?><span style="top:15px;" title="未回答的课程问题数量"><?= $count?></span>
			<?php }elseif($count>99){ ?><span style="top:15px;">99+</span>
			<?php } ?>
			</a>
			<a href="<?=geturl('troomv2/notice/send')?>" class="addnotice"></a>
			<a href="<?=geturl('troomv2/review')?>" class="review">

			<?php if($creview>0 && $creview<=99 ){ ?><span style="top:15px;" title="未回复课件评论的评论数量"><?= $creview?></span>
			<?php }elseif($creview>99){ ?><span style="top:15px;">99+</span>
			<?php } ?>
			</a>
		</div>
    </div>
	<div style="width:788px;height:40px;line-height:40px;background:white;border-bottom:1px solid #e1e1e1; border-top:1px solid #e1e1e1;float:left;font-size:16px;cursor:pointer;" onclick="mmshowhide()">
	<span style="margin-left:10px">教学日历</span>
	<span style="float:right;margin-right:10px;*margin-top:-40px">
	<img id="arrow_down" style="display:none;margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/2014/images/arrow_down.png"/>
	
	<img id="arrow_up" style="margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/2014/images/arrow_up.png"/>
	</span>
	</div>

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
			<div class="">
			<strong class="active-date"></strong><strong class="active-day"></strong>
			</div>
			<div class="studyinfo">
				
			</div>
			
			
		</div>
	</div>
<?php if($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) { ?>
	<?php if(!empty($notices)) { ?>
    <div class="liattop">
        <h2 class="kusts">
            <span>通知</span>
            <div class="aenbh">
            	<a class="luist" href="<?= geturl('troomv2/notice/receive') ?>">更多 >></a>
            </div>
        </h2>

	<?php foreach($notices as $k=>$notice) {?>
        <div class="brftg">
            <span class="lanyuan" style="width:345px;">
            	<a target="_blank" href="<?= geturl('troomv2/notice/'.$notice['noticeid'])?>"><?= shortstr($notice['title'],44)?></a>
            </span>
            <span class="liswtg"><?= date('Y-m-d H:i',$notice['dateline'])?> <?= $notice['type']==1?$notice['realname']:"学校"?></span>
        </div>
    <?php }?>
    </div>
<?php }
} ?>

<?php if($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) { ?>
	<?php if(!empty($courses)) { ?>
	<div class="liattop">
        <h2 class="kusts">
            <span>课件</span>
            <div class="aenbh">
            	<a class="luist" href="<?= geturl('troomv2/classsubject/courses') ?>">更多 >></a>
            </div>
        </h2>
    <?php 
	$redis = Ebh::app()->getCache('cache_redis');
	foreach($courses as $k=>$cw) { 
		$viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);		
		if(empty($viewnum))
			$viewnum = $cw['viewnum'];
		$arr = explode('.',$cw['cwurl']);
		$type = $arr[count($arr)-1]; 
		if($type != 'flv' && $cw['ism3u8'] == 1 || $type == 'mp3' || $type == 'mov')
			$type = 'flv';
		$date = Date('Y-m-d',$cw['dateline']);
		$datenow = date('Y-m-d');
    ?>
        <div class="kustke">
            <div class="ndtete">
                <a target="<?= (empty($cw['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($cw['cwurl']) || $type == 'flv') ? geturl('troomv2/course/'.$cw['cwid']) : geturl('troomv2/classcourse/'.$cw['cwid']) ?>" class="stgeke">
                    <img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png">
                </a>
                <div class="fskpctd">
                    <?php if(!empty($cw['logo'])){?><img src="<?=getthumb($cw['logo'],'178_103')?>" onerror="errorHandler.call(this)" cwid="<?=$cw['cwid']?>"/><?php }?>
                </div>
            </div>
            <div class="ristke">
                <h3 class="stfton"><a target="<?= (empty($cw['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($cw['cwurl']) || $type == 'flv') ? geturl('troomv2/course/'.$cw['cwid']) : geturl('troomv2/classcourse/'.$cw['cwid']) ?>"><?=$cw['title']?></a></h3>
                <p><?=Date('Y-m-d H:i',$cw['dateline'])?>（发布）</p>
                <p><span style="margin-right:20px;">评论：<?=$cw['reviewnum']?></span>人气：<?=$viewnum?></p>
            </div>
        </div>
    <?php }?>
    </div>
<?php }
} ?>

<?php if($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) { ?>
	<?php if(!empty($exams)) { ?>
	<div class="liattop">
        <h2 class="kusts">
            <span>作业</span>
            <div class="aenbh">
            	<a class="luist" href="<?= geturl('troomv2/classexam/cor') ?>">更多 >></a>
            </div>
        </h2>
        <table width="100%" class="datable">
            <tbody>
            <?php foreach($exams as $k=>$exam) {
            $noticeclass = "";
            if($exam['dateline'] + 604800 > SYSTIME)
                $noticeclass = 'lately';
            ?>
                <tr class="">
                    <td width="60%" style="text-align:left;">
                        <span style="width:400px;line-height:15px;" class="laitico"><?= shortstr($exam['title'],54)?></span>
                    </td>
                    <td width="20%" style="color:<?=$noticeclass?'#e2681d':'#999'?>"><?= date('Y-m-d H:i',$exam['dateline']) ?></td>
                    <td width="1%" style="">
                    <a href="<?= geturl('troomv2/classexam/cor')?>" class="jinxuexi">作业批阅</a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
	</div>
<?php }
} ?>

<?php if($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) { ?>
	<?php if(!empty($asks)) { ?>
	<div class="liattop">
        <h2 class="kusts">
            <span>问题</span>
            <div class="aenbh">
            	<a class="luist" href="<?= geturl('troomv2/myask/askme') ?>">更多 >></a>
            </div>
        </h2>
        <table class="datable" width="100%">
            <tbody>
            <?php foreach($asks as $k=>$ask) {
				if(!empty($ask['face']))
					$face = getthumb($ask['face'],'50_50');
				else{
					if($ask['sex']==1){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					}
					$face = getthumb($defaulturl,'50_50');
				}
	            $noticeclass = "";
	            if($ask['dateline'] + 604800 > SYSTIME)
	                $noticeclass = 'lately';
	            $name=empty($ask['realname'])?$ask['username']:$ask['realname']
	        ?>
                <tr class="">
                    <td width="45%" style="text-align:left;">
                        <div class="<?= $noticeclass ?>" style="float:left;margin-right:15px;">
                            <a href="/troomv2/myask/askme.html?aq=<?= $name?>">
                            	<img src="<?=$face?>" title="<?= $name?>">
                            </a>
                        </div>
                        <div class="kneit">
                            <p class="tsiter">
								<?php if(!empty($requiredTeacher) && ($ask['answered']==1) ){ ?>
									<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;" title="已回答"/>
								<?php }else if(empty($requiredTeacher) && $ask['status']==1){?>
									<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;" title="已有最佳答案"/>
								<?php }?>
								<a  href="<?= geturl('troomv2/myask/'.$ask['qid']) ?>" style="color:
								<?= (!empty($requiredTeacher) && ($ask['answered']==1)) ?'#2696f0':'#777' ?>
								;font-weight:bold;"><?= $ask['title'] ?></a>
                            </p>
                            <span class="listet">
                            <p class="drgrt">回答：<?= $ask['answercount'] ?></p>
                            <p class="borts">人气：<?=$ask['viewnum']?></p>
                            </span>
                            <div style="float:left;width:550px;">
                                <span style="width:280px;float:left;"><?= Date('Y-m-d H:i:s',$ask['dateline']) ?></span>
                                <span class="lisrht"><?= $name?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
	</div>
<?php }
} ?>
</div>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar2.js?v=15051902"></script>
	
<script type="text/javascript">
<!--
	var Calendar = new Calendar("<?=SYSTIME?>");
	var calendarloaded = false;
	var param = new Object();
	param.uid = 1;
	$(function(){
		Calendar.init(param);
		calendarloaded = true;
		getcreditstat();
	});
	function signin(){
		$.ajax({
			type:'POST',
			'url':'/troomv2/mysetting/sign.html',
			data:{'signin':1},
			success:function(data){
				$('.daotqian2').attr('title','已经连续签到'+(1+parseInt($('.daotqian2').attr('day')))+'天');
				$('.afsign').html((1+parseInt($('.daotqian2').attr('day')))+'天');
				$('.daotqian').hide();
				$('.daotqian2').show();
				$('#creditplus').fadeTo(1000,1);
				$('#creditplus').fadeTo(2000,0);
			}
		});
		
	}
	
	function mmshowhide(){
		if(!calendarloaded){
			Calendar.init(param);
			calendarloaded = true;
		}
		if($('.mmain').css('display') == 'none'){
			$('.mmain').show();
			$('#arrow_down').hide();
			$('#arrow_up').show();
		}
		else{
			$('.mmain').hide();
			$('#arrow_up').hide();
			$('#arrow_down').show();
		}
		parent.resetmain()
	}
	
	function getcreditstat(dp){
		if(dp){
			if(dp.srcEl.id=='dayfrom'){
				dayfromobj = dp.cal.newdate;
				var dayfrom = dayfromobj.y+'-'+dayfromobj.M+'-'+dayfromobj.d;
				var dayto = $('#dayto').val();
				if(!dayto)
					return;
			}else{
				daytoobj = dp.cal.newdate;
				var dayfrom = $('#dayfrom').val();
				var dayto = daytoobj.y+'-'+daytoobj.M+'-'+daytoobj.d;
				if(!dayfrom)
					return;
			}
			
		}
		else{
			var dayfrom = $('#dayfrom').val();
			var dayto = $('#dayto').val();
		}
		$.getJSON('/troomv2/mysetting/creditStat.html?dayfrom='+dayfrom+'&dayto='+dayto+'&rnd='+Math.random(), function (csv) {
        $('#chartcontainer').highcharts({
            data: {
                csv: csv
            },

            credits:{
				enabled:false 
			},
			navigation: {
				buttonOptions: {
					enabled: false
				}
			}
            ,
			title: {
				text: null
			},
			legend: {
				enabled: false
			},
			yAxis: {
				floor: -1,
				allowDecimals: false,
				
				title: {
					text: null
				}
			},
			xAxis: {
				labels: {
					x:-5,
					step:2,
					formatter: function() {
						return  Highcharts.dateFormat('%m-%d', this.value);
					}
				}
			},
			tooltip: {
				dateTimeLabelFormats:{
					day:"%A, %m-%e"
				}
				
			},
			colors:['#aed1f4','#f5d86a'],
			plotOptions: {
                    series: {
                        marker: {
                            radius: 2,  
                            symbol: 'diamond'
                        }
                    }
                }
        });
    });
	}
//-->
function errorHandler(){
	var cwid = $(this).attr('cwid');
	var size = '178_103';
	var me = this;
	$.ajax({
		type: "POST",
		url: "<?=geturl('imghandler')?>",
		data: {cwid:cwid,size:size,type:'courseware_logo'},
		dataType: "json",
		success: function(data){
			if(data && (data.status == 0) ){
				$(me).attr('src',data.url+'?v=1');//v=1 你猜这是干什么的 O(∩_∩)O哈哈~
			}
			$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
		    $(me).unbind('error');
		},
		error:function(){
			$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
			$(me).unbind('error');
		}
	});
}
</script>
<?php $this->display('troomv2/page_footer'); ?>