<?php $this->display('troomv2/page_header'); ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/calendar.js"></script>
	<style type="text/css">
	.hmain{height: 45px;padding-right: 3px;}
	.year,.month{float:left;width:70px;height:28px;line-height:28px;background:url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -20px -225px;font-size:12px;padding-left:12px;cursor: pointer;}
	.hselect div.htab{float: right;height:33px;line-height:33px;width:262px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -16px -138px;}
	.htab li{float: left;font-size:12px;width: 87px;text-align: center;cursor: pointer;}
	.htab li a{text-decoration: none;}
	.htab li.cur{height:30px;margin:1px 0;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -15px -80px;}
	.mmain{clear: both;font-size: 12px;text-align: center;font-weight:bold;}
	.mmain ul li{width:111px;height: 78px;float:left;border: 1px solid #e9e9e9;border-left: none;border-bottom: none;}
	.mmain ul li p{padding:5px 0 0 5px;text-align: left;float:left;width:100px;}
	.yangli{margin-right:8px;}
	.mmain ul li a.manswer{display:inline-block;text-align:center;width:24px;height:42px;text-decoration: none;padding:0 5px;margin-top: 3px;}
	.mmain ul li a.msubject{display:inline-block;text-align:center;width:24px;height:42px;text-decoration: none;padding:0 5px;margin-top: 3px;}
	.mmain ul li a.mexam{display:inline-block;text-align:center;width:24px;height:42px;text-decoration: none;padding:0 5px;margin-top: 3px;}
	.mmain ul li a.errors{display:inline-block;text-align:center;width:24px;height:42px;text-decoration: none;padding:0 5px;margin-top: 3px;}
	.mmain ul li a.note{display:inline-block;text-align:center;width:24px;height:42px;text-decoration: none;padding:0 5px;margin-top: 3px;}
	.mmain ul li a span{margin-bottom: 5px;float:left;}
	.mmain ul li a em{display:inline-block;width:23px;height:13px;line-height:13px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -142px -184px;color:#5084d7;font-weight: bold;}
	.msubject span{clear:both;display:inline-block;width:24px;height:24px;line-height:24px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -57px -187px;}
	.mexam span{display:inline-block;width:24px;height: 24px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -110px -186px;}
	.manswer span{display:inline-block;width:24px;height: 24px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -19px -185px;}
	.mmain .chead{border-top: 1px solid #ccc;border-bottom:none;border-right: solid 1px #e9e9e9;width:786px;height: 34px;line-height: 34px;margin-top:10px;;background: url('http://static.ebanhui.com/ebh/images/titlanbiao.jpg') repeat-x;}
	.mmain .chead span{text-align:center;display:block;float:left;width:108px;color: #555;}
	.errors span{display:inline-block;width:24px;height: 24px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -216px -185px;}
	.note span{display:inline-block;width:24px;height: 24px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -250px -185px;}
	.quan{display:inline-block;float:right;width:7px;height:25px;background: url('http://static.ebanhui.com/ebh/images/scbg.png') no-repeat -18px -35px;position: absolute;top:59px;right: 0px;}
	.selyear{background:#f3f3f3;margin-left:2px;width:76px;height:150px;border: 1px solid #ccc;position: absolute;left: 10px;top: 53px;border-top:none;overflow: auto;font-size: 12px;z-index:100;}
	.selyear li{text-align: center;height:24px;line-height: 24px;cursor: pointer;}
	.selyear li.curYea{background: blue;color: #fff;}
	.selmonth{background:#f3f3f3;margin-left:2px;width:76px;height:150px;border: 1px solid #ccc;position: absolute;left:102px;top: 53px;border-top:none;overflow: auto;font-size: 12px;z-index:100;}
	.selmonth li{text-align: center;line-height: 24px;cursor: pointer;}
	.selmonth li.curMon{background: blue;color: #fff;}
	#mainContent li.curDate{background: #2cabee;}
	.pmdate a,.nmdate a{color:#aaa;}
	#mainContent .disnone{display: none;}
	#mainContent a{cursor: pointer;}
	.curDate span {color:#fff;}
	.mmain ul li a.huaqian {display:block;width:108px;height:78px;}
	.mmain ul li a.huaqian:hover {background:#deeefd;}
	.mmain ul li.curDate a.huaqian:hover {background:#2CABEE;}
</style>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.menubox ul li i,.bottom,.cservice img,.mmain span,.htab li,.mmain ul li a span,'); 
</script>  
<![endif]-->
<div class="ter_tit">
当前位置 > <a href="<?=geturl('troomv2/tastulog') ?>">学生监察</a> >
	 <a href="<?= geturl('troomv2/scalendar-0-0-0-0-'.$type) ?>"><?= $typename ?></a> > <?= empty($student['realname'])?$student['username']:$student['realname'] ?>的<?= $typename ?>
</div>
<div class="main" style="width:786px;height:573px;border:solid 1px #cdcdcd;margin-top:15px;position:relative;background:url('http://static.ebanhui.com/ebh/images/dihuise.jpg') no-repeat bottom #fff;">
	<div class="hmain">
		<div class="hselect" style="padding:10px;">
			<div class="date">
				<div style="float:left;margin-right:10px;" class="year">2013年</div>
				<div class="month" style="padding-left:17px;">11月</div>
				<div style="width:120px;float:left;" class="backToday">
					<span style="margin-top:1px;margin-left:20px;display:inline-block;border:1px solid #ccc;height:24px;line-height:24px;padding:0 18px;cursor:pointer;">今天</span> 
				</div>
			</div>
			<div class="htab">
				<ul>
					<li class="cur"><a href="<?= geturl('myroom/studycalendar/studylog') ?>">学习记录</a></li>
					<li><a href="<?= geturl('myroom/myexam') ?>">作业记录</a></li>
					<li><a href="<?= geturl('myroom/myask') ?>">答疑记录</a></li>
				</ul>
			</div>
		</div>	
	</div>
	<div class="dquan">
		<span class="quan" style="right:245px;"></span>
		<span class="quan" style="right:193px;"></span>
		<span class="quan" style="right:141px;"></span>
		<span class="quan" style="right:87px;"></span>
		<span class="quan" style="right:35px;"></span>
	</div>
	<div class="mmain">
		<div class="chead">
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

<input type="hidden" id="uid" value="<?= $student['uid'] ?>">
<input type="hidden" id="numid" value="<?= $type ?>">
<script type="text/javascript">
	var uid = document.getElementById('uid').value;
	var numid = document.getElementById('numid').value;
	var Calendar = new Calendar();
	Calendar.init({"uid":uid,"numid":numid,"t":1});
</script>
<?php $this->display('troomv2/page_footer'); ?>