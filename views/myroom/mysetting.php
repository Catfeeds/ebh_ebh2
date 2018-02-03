<?php $this->display('myroom/page_header'); ?>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/wangind.css?v=0525" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/myind.css?v=0520" />
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style type="text/css">
	
	.mmain{clear: both;font-size: 12px;text-align: center;font-weight:bold;width:786px;float:left;background:#fff;border: solid 1px #d9d9d9;border-top:none}
	.mmain ul li{width:80px;height: 40px;float:left;}
	.mmain ul li a span{float:left;width:80px;}
	
	.mmain .chead{border-bottom: solid 1px #d9d9d9;width:560px;float:left;height: 45px;line-height: 45px;background:#fff;font-family: PingHei,'Hiragino Sans GB','Microsoft YaHei',arial,sans-serif;}
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
.lanyuan {
	background:url('http://static.ebanhui.com/ebh/tpl/2014/images/tongzhi_03.jpg') no-repeat left center;
	font-size:14px;
	line-height:14px;
}
.brftg {
	float:left;
	width:392px;
	margin:5px 0;
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
	.grkgee {
	height:34px;
	background:#f3f3f3;
	border:solid 1px #666;
	border-radius: 2px;
	float:left;
	padding:1px;
	margin-top:20px;
	width:110px;
}
.grkgee a.daotqian {
	background:#36b8ff;
	width:66px;
	height:34px;
	line-height:34px;
	color:#fff;
	text-align:center;
	display:block;
	float:left;
	font-size:16px;
}
.daotqian2 {
	background:#36b8ff;
	width:66px;
	font-size:16px;
	height:34px;
	line-height:34px;
	color:#fff;
	text-align:center;
	display:block;
	float:left;
}
.dgrtwe {
	width:44px;
	float:left;
	line-height:1.5;
	text-align:center;
	color:#787878;
}
	.msubject > em{margin-left: 5px;position: relative;top: -10px;}
	.msubject1 > em{margin-left: 5px;position: relative;top: -10px;}
	.msubject2 > em{margin-left: 5px; position: relative;top: -10px;}
	.studyinfo{text-align:center; margin-top:25px;display: inline-block;}
	.studyinfo_son{float:left; width:55px; margin-left:5px;}

</style>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.menubox ul li i,.bottom,.cservice img,.sukan .xinke span,.sukan .zuoye span,.sukan .zhibo span,.sukan .jieda span'); 
</script>  
<![endif]-->

	<?php 
		if(empty($roominfo['cface']))
			$cface = 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg';
		else
			$cface = $roominfo['cface'];
	?>
<div class="wangind">
<div style="background:#fff;float:left;border: 1px solid #ddd;width: 786px;border-bottom:none;">
<h2 style="height:40px;line-height:40px;text-align:center;font-size:18px;color:#808080;font-weight:bold;"><?= $roominfo['crname']; ?></h2>
		<div class="titop">
			<div class="rtkege">
				<div class="rekyjger">
				<div class="xiutgt" style="left:<?=520*$clinfo['percent']/100-7?>px"><?=$clinfo['title']?> <?=$user['credit']?></div>
				<span class="kehgd">书童<br />0</span>
				<div class="rgkerg"><span class="gregdf" style="width:<?=$clinfo['percent']?>%;"></span></div>
				<span class="kehgd">文曲星<br />10000</span>
				</div>
				<div class="retykgd">
				<input name="" id="dayfrom" style="cursor:pointer" class="grjrlqt" type="text" readonly="readonly" value="<?=Date('Y-m-d',SYSTIME-86400*30)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'<?=Date('Y-m-d',SYSTIME-86400*30)?>',maxDate:'#F{$dp.$D(\'dayto\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400*2)?>\'}'});"/>
				<span class="etgregd">至</span>
				<input name="" id="dayto" style="cursor:pointer" class="grjrlqt" type="text" readonly="readonly" value="<?=Date('Y-m-d',SYSTIME-86400)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dayfrom\',{d:1})||\'<?=Date('Y-m-d',SYSTIME-86400*29)?>\'}',maxDate:'<?=Date('Y-m-d',SYSTIME-86400)?>'});"/>
				<div class="wegkw"><span class="mydes"></span><span class="flost">我的</span>
				<span class="xiaodes"></span><span class="flost">全校平均</span></div>
				</div>
				<div id="chartcontainer" class="chartcontainer" style="height: 200px;">
				</div>
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
			<div class="lgtrer">
			<div class="grkgee">
			<span class="dgrtwe">周<?=$weekarr[Date('w',SYSTIME)]?><p><?=Date('m/d',SYSTIME)?></p></span>
			<span id="creditplus" style="display:none;position:absolute;color:orange;right:35px;top:72px;">+1积分</span>
			<a href="javascript:void(0)" class="daotqian" onclick="signin()" <?=$showsign[0]?>>签到</a>
			<span class="daotqian2" <?=$showsign[1]?> title="已经连续签到<?=$continuous?>天" day="<?=$continuous?>">已签到</span>
		</div>
		<a href="<?=geturl('home/score/lottery')?>" class="luckys">积分抽奖</a>
			<h2 class="ertjtyh">排行榜 <span style="color:#e10601;">TOP3</span></h2>
			<ul>
				<?php foreach($ranklist as $rank){
					$face = '';
					if($rank['sex'] == 1)
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					else
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					$face = empty($rank['face']) ? $defaulturl:$rank['face'];
					$face = str_replace('.jpg','_40_40.jpg',$face);
					$face = str_replace('.png','_40_40.png',$face);
					?>
				<li class="ewtreg">
					<img src="<?=$face?>" />
					<p class="jetrtif"><?=empty($rank['realname'])?$rank['username']:$rank['realname']?></p>
					<p class="jetrtif"><?=$rank['credit']?>分</p>
				</li>
				<?php }?>
			</ul>
		</div>
</div>
<div class="esukang">
<a href="<?=geturl('myroom/myexam/all')?>" class="zzuoye" id="zuoye"></a>
<a href="<?=geturl('myroom/stusubject/newcourse')?>" class="xxuexi" id="course"></a>
<a href="<?=geturl('myroom/myask/all')?>" class="ddayi" id="ask"></a>
<a href="<?=geturl('myroom/myask/addquestion')?>" class="ttiwen"></a>
<a href="<?=geturl('myroom/classmate')?>" class="ttongxue"></a>
</div>
</div>
<div style="width:786px;height:40px;line-height:40px;background:white;border:1px solid #cdcdcd;float:left;font-size:16px;cursor:pointer;" onclick="mmshowhide()">
	<span style="margin-left:10px">学习日历</span>
	<span style="float:right;margin-right:10px;*margin-top:-40px">
	<img style="margin-top:10px;" id="arrow_down" src="http://static.ebanhui.com/ebh/tpl/2014/images/arrow_down.png"/>
	
	<img  id="arrow_up" style="display:none;margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/2014/images/arrow_up.png"/>
	</span>
	</div>

	<div class="mmain" style="display:none;" onselectstart="return false">
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

	<!-- 最新收到的通知 -->
		<?php if(!empty($notices)) { ?>
		<div class="timike" style="margin-top:16px">
			<h2>收到通知<div class="aenbh"><a class="gengduo" href="<?= geturl('myroom/notice') ?>">更多</a></div></h2>
					<?php foreach($notices as $k=>$notice) {
						$borderstr = '';
						if($k==count($notices)-1) 
							$borderstr = 'border:none';
					?>
					<?php if(($notice['dateline'] + 604800 )>SYSTIME) {?>
					<?php } else { ?>
					<?php } ?>
			<div class="brftg">
				<span style="width:345px;" class="lanyuan"><a href="<?= geturl('myroom/notice/'.$notice['noticeid'])?>" target="_blank"><?= shortstr($notice['title'],44)?></a></span>
				<span style="margin-left:35px;float:left;color:#888;"><?= date('Y-m-d H:i',$notice['dateline'])?><?= $notice['type']==1?$notice['realname']:"学校"?></span>
			</div>
					<?php } ?>
		</div>
		<?php }?>

	<?php $this->display('myroom/newcourseinindex');?>
	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar2.js?v=15051902"></script>
<script type="text/javascript">
<!--
	$("#showdate").html(tips());
	 function tips() {
		now = new Date(), hour = now.getHours()
		if (hour < 6) { return "凌晨好！"; }
           else if (hour >= 6 && hour < 9) { return ("早上好！") }
           else if (hour >= 9 && hour < 12) { return ("上午好！") }
           else if (hour >= 12 && hour < 14) { return ("中午好！") }
           else if (hour >= 14 && hour < 17) { return ("下午好！") }
           else if (hour >= 17 && hour < 19) { return ("傍晚好！") }
           else if (hour >= 19 && hour < 22) { return ("晚上好！") }
           else { return ("夜里好！") }
	 }
	 <?php if(($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
		function showneitip() {
			if(window.parent != undefined) {
				<?php if(!empty($payitem)) { ?>
					if(window.parent.setiinfo != undefined) {
						window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
					}
				<? } ?>
				window.parent.showDivModel(".nelame");
			}
		}
		<?php } ?>
		<?php if(empty($nophoto) && empty($user['face']) && ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $roominfo['crid']!=10420) { ?>
		$(function(){
			if(window.parent != undefined) {
				try{
					window.parent.phototip(".waigmes");
				}catch(err){}
			}
		});
		<?php } ?>

	$(function(){
   var url = '<?= geturl('myroom/userstate')?>';
   <?php if(!empty($stumodulelist) && in_array(780,$stumodulelist)) { ?>
   var type =[1,2,780,4];
   <?php } else { ?>
	var type =[1,2,4];
   <?php } ?>
   var folderids = '<?=empty($folderids)?'':$folderids?>';
   $.ajax({
		type:'POST',
		url:url,
		data:{"type":type,'folderids':folderids},
			dataType:"json",
			success:function(data) {
				if(data != undefined && data[1] != undefined && data[1] > 0) {
					var examcount = data[1] > 99 ? 99 : data[1];
					$("#zuoye").append("<span>" + examcount + "</span>");
				}
				if(data != undefined && data[2] != undefined && data[2] > 0) {
					var askcount = data[2] > 99 ? 99 : data[2];
					$("#course").append("<span>" + askcount + "</span>");
				}
				if(data != undefined && data[780] != undefined && data[780] > 0) {
					var onlinecount = data[780] > 99 ? 99 : data[780];
					$("#online").append("<span>" + onlinecount + "</span>");
				}
				if(data != undefined && data[4] != undefined && data[4] > 0) {
					var askcount = data[4] > 99 ? 99 : data[4];
					$("#ask").append("<span>" + askcount + "</span>");
				}
			}
		});
	
	getcreditstat();
	});
	//-->
	
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
		$.getJSON('/myroom/mysetting/creditStat.html?dayfrom='+dayfrom+'&dayto='+dayto+'&rnd='+Math.random(), function (csv) {
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
	function signin(){
		$.ajax({
			type:'POST',
			'url':'/myroom/mysetting/sign.html',
			data:{'signin':1},
			success:function(data){
				$('.daotqian2').attr('title','已经连续签到'+(1+parseInt($('.daotqian2').attr('day')))+'天');
				$('.daotqian').hide();
				$('.daotqian2').show();
				$('#creditplus').fadeTo(1000,1);
				$('#creditplus').fadeTo(2000,0);
			}
		});
		
	}
	var Calendar = new Calendar("<?=$dateoflast?>");
	var calendarloaded = false;
	function mmshowhide(){
		if(!calendarloaded){
			Calendar.init();
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
	
</script>
<?php $this->display('myroom/page_footer');?>