<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20151118001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20150805001" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160704002"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0704"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js?v=1105"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>

<style>
	.datatab td{
		border: 0;
		padding: 3px 6px;
	}
	.tabhead th{
		padding:1px 6px;
	}
	.ewtkey{
		width:200px
	}
	.tweytr a{
		color : #3366CC;
	}
	.tijibtn {
		float: left;
		background: #18a8f7;
		width: 190px;
		height: 32px;
		display: inline;
		float: left;
		line-height: 32px;
		text-align: center;
		margin-left: 394px;
		color: #fff;
		font-size: 14px;
		text-decoration: none;
		cursor: pointer;
		border: none;
		border-radius:3px;
	}
	div.aui_inner{
		background: #fff;
	}
	.bq-set-show{
		display: none;
	}
	.classboxmore{
		border:none;
	}
.workcurrent a span {background:none;padding:0;}
.workcurrent a {padding:0;background:url(http://static.ebanhui.com/ebh/tpl/default/images/intit_02.jpg) no-repeat;width:118px;height:33px;line-height:33px;text-align:center;}
.work_mes ul li{font-size:14px;}
.classbox h1.rygers {width:820px; overflow:hidden;color:#333;margin-top:10px;height:20px;line-height:20px; padding-left:0; font-family:微软雅黑;font-size:16px;}
.classboxmore p {line-height:20px;}
.classboxmore {padding:0;width:860px;border:none;}
em{
	font-style:italic;
	font-weight:inherit;
}
strong{
	font-style:inherit;
	font-weight:bold;
}
.fill{ border-top:none;}
.flaoter{ width:960px; border:none; }
.ter_tit{border:1px solid #e1e1e1;}
.lefrig a.huangbtn, .lefrig input.huangbtn{ border-radius:3px !important;}
.lefrig a.lanbtn, .lefrig input.lanbtn{border-radius:3px !important;}
.lefrig a.liaskt {background:#ffaf28;}
.lefrig a.liaskt:hover {background:#fea000;}

.appraise dl dt{
	border-top:none;
}
.appraise dl dd{
	border-top:none;
}

.lefrig a.lanbtn, .lefrig a.huangbtn , .lefrig a.lanbtn:hover, .lefrig a.huangbtn:hover{
    background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left center;
    color: #fff;
    display: block;
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 35px;
    text-align: center;
    width: 90px;
	font-weight:normal;
}
.lefrig a.previewBtn, .lefrig input.previewBtn,.lefrig a.previewBtn:hover, .lefrig input.previewBtn:hover{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left 4px;
    color: #fff;
    display: block;
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 43px;
    text-align: center;
    width: 90px;
	font-weight:normal;
}
.rqzs{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png") no-repeat left center;
    padding-left: 15px;
	color:#999;
}
p.lsxm{
	color:#666;
	font-family:微软雅黑;
	line-height:20px;
	margin-top:-5px;
}
.userimg img{
	border-radius:20px;
}
.datatab th{
	font-family: 微软雅黑;
    font-size: 14px;
	color:#333;
	font-weight:normal;
}
.bzzytitle{
    font-family: 微软雅黑;
    color: #333;
    font-size: 14px;
	padding:3px 6px;
	float:left;
	display:inline;
	margin-left:10px !important;
}
.bzzytitle1s{
	width:14px;
	height:18px;
	margin-top:8px;
	float:left;
	display:inline;
	padding-left:10px;
}
.apptit{
	line-height:35px;
	margin-top:10px;
}
.userimg{
	width:80px;
	text-align:center;
	height:auto;
	position:relative;
}
.userimg a{
	display:block;
}
.userimg a b{
	display:block;
	width:65px;
	font-family:微软雅黑;
	font-size:14px;
	color:#333;
	font-weight:normal;
}
.xingbie {
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png) no-repeat left center;
    display: block;
    width: 15px;
    height: 18px;
    margin-left: 5px;
	position:absolute;
	top:47px;
	right:0;
}
span.renming1 {
    font-family: 微软雅黑;
    font-size: 12px;
    color: #999;
	display:block;
	overflow:hidden;
}
.xingbie1 {
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png) no-repeat left center;
    display: block;
    width: 15px;
    height: 18px;
    margin-left: 5px;
	position:absolute;
	top:47px;
	right:0;
}
.grade{
	padding-left:8px;
}
.appraise dl{
	float:left;
}
input,textarea:focus{
	outline: none;
	background:none;
}
.wdtkcs{
    color:#434348;
    font-family:微软雅黑;
}
.wdtkcs1s{
    padding:0 70px;
}
.zhqks1s{
    text-align:center;
    padding-bottom:20px;
    width:910px;
}
.nnbl {
    border-left: 4px solid #5e96f5;
    color: #333333;
    font-family: "微软雅黑";
    font-size: 16px;
    line-height: 18px;
    padding-left: 8px;
}
.qzsjlb {
    display: inline-block;
    padding-left: 45px;
}
.lefrig a.lviewbtn, .lefrig input.lviewbtn,.lefrig a.lviewbtn:hover, .lefrig input.lviewbtn:hover{
	background:url("http://static.ebanhui.com/ebh/tpl/troomv2/images/pybico.png") no-repeat left 4px;
    color: #fff;
    display: block;
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 43px;
    line-height: 43px;
    text-align: center;
    width: 90px;
	font-weight:normal;
}
.bzzytitle {
    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/bzzyico.jpg) no-repeat left center !important;
    padding-left: 25px;
    font-family: 微软雅黑;
    font-weight: bold;
    color: #333;
    font-size: 16px;
	margin-left:10px;
}
<<<<<<< .mine
=======

.tksile a.tingdian{
    background: url("http://static.ebanhui.com/ebh/tpl/2016/images/dianzan.png") no-repeat left center;
    color: #bbb;
    float: left;
    margin-right: 15px;
    padding-left: 25px;
}
.tksile a.tingdian:hover,.tksile a.tingdian.onhover{
    background: url("http://static.ebanhui.com/ebh/tpl/2016/images/dianzan1.png") no-repeat left center;
    color:#18a8f7 !important;
}
.flaoter a.tingfan, .flaoter a.shoutie, .flaoter a.lubij, .flaoter a.tiwenti{
	color:#bbb;
	font-family: 微软雅黑;
	font-size:14px;
}
.flaoter a:hover{
	color:#18a8f7 !important;
}
>>>>>>> .r5965
<?php $fromintro = $this->input->get('fromintro');
if(empty($fromintro)){?>
.cright{
	margin-top:20px !important;
}
<?php }?>
</style>
<script type="text/javascript">
function opencountdiv(){
	if(!H.get('dialogoc')){
		H.create(new P({
			id : 'dialogoc',
			title: '信息提示',
			easy:true,
			width:420,
			padding:5,
			content:$('#opencount')[0]
		}),'common').exec('show');
	}else{
		H.get('dialogoc').exec('show')
	}
}
	function addfavorite(cwid,title,url){
		var purl = "<?= geturl('myroom/favorite/add')?>";
		$.ajax({
			type	:'POST',
			url		:purl,
			data	:{'cwid':cwid,'title':title,'url':url,'type':1},
			dataType:'text',
			success	:function(data){
				if(data=='success'){
					$("#favorite").val("已收藏");
					$("#favorite").unbind();
				}
			}
		});
	}
	

	var countdown = <?=$course['submitat']-SYSTIME?>;
	var intid;
	var isclose;	//是否关闭弹幕
	$(function (){
			<?php if(empty($myfavorite)) { ?>
				$("#favorite").html("收藏");
				$("#favorite").unbind().click(function(){
					$("#favorite").html("已收藏");
					$("#favorite").removeClass('shoutie');
					$("#favorite").addClass('yishout');
					$("#favorite").removeAttr('onclick');
					addfavorite('<?= $course['cwid'] ?>',"<?= str_replace('\'','',$course['title']) ?>",location.href);
				});
			<?php } else { ?>
				$("#favorite").html("已收藏");
				$("#favorite").removeClass('shoutie');
				$("#favorite").addClass('yishout');
			<?php } ?>

			<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
				if(window != undefined) {
					opencountdiv();
				}
			<?php }else{ ?>
				//flv播放
				var cwid = <?= $course['cwid'] ?>;
				var isfree = <?= isset($isfree) ? $isfree : $course['isfree'] ?>;;
				var num = 1;//教室内
				var lastsuffix = 'flv';
				<?php if(!empty($type)){?>
				lastsuffix = '<?= $type ?>';
				<?php } ?>
				if(lastsuffix == 'flv'){
					//flv
					<?php 
						if(!empty($course['m3u8url'])) {
						$autoplay = $this->input->get('autoplay');
						$autoplay = !empty($autoplay)?$autoplay:0;
						// $jx = $roominfo['domain'] == 'jx';
						$mode = 0;
						$seek = -1;
						if(SYSTIME>= $course['submitat'] && SYSTIME<= $course['endat']){
							$mode = 1;
							$seek = SYSTIME - $course['submitat'];
							if(!empty($course['cwlength']) && SYSTIME >= ($course['submitat']+$course['cwlength'])){
								$mode = 0;
								$seek = 1;
							}
							if($seek <= 0)
								$seek = 1;
							$autoplay = 1;
						}
						$isremind = $course['isremind'];
						$remindtime = $course['remindtime'];
						$remindmsg = $course['remindmsg'];
					?>
					playmu('<?=$course['m3u8url']?>',cwid,'',isfree,num,'562','980',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,<?=$autoplay?>,<?=$mode?>,<?=$seek?>,<?= $isremind ?>,'<?=$remindtime?>','<?=$remindmsg?>');
					<?php 
						} else if(!empty($course['rtmpurl'])) {
					?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','980',1,'<?= $course['thumb'] ?>');
					<?php } else if($isliverun){?>
					<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','980',1);
					<?php } ?>
				} else if(lastsuffix == 'mp3'){
					<?php
						$mode = 0;
						$seek = -1;
						if(SYSTIME>= $course['submitat'] && SYSTIME<= $course['endat'] && SYSTIME < ($course['submitat']+$course['cwlength'])){
							$mode = 1;
							$seek = SYSTIME - $course['submitat'];
							if($seek <= 0)
								$seek = 1;
						}
					?>
					playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','980',1,'',<?= $mode ?>,<?= $seek ?>);
				}else if(lastsuffix == 'swf'){
                    playswf('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','980',1);
                }
			<?php } ?>

			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/myroom/mycourse/getajaxpage.html";
			page_load(page,url);

			
			var str=window.location.href.substring(window.location.href.indexOf('#')+1);
		    if(str!==undefined && str!=='' && window.location.href.indexOf('#')>0){  
		        $("#notecontent").show();
		    }  
			$("#notebtn").click(function(){
				$("#notecontent").show();
			});
			$("#cancel").click(function(){
				$("#notecontent").hide();
			});	
			<?php if(SYSTIME<$course['submitat']){?>
				intid = setInterval('counttime()',1000);
			<?php }?>
		});

	//听课完成回调
	function messfun(ctime,ltime,finished,plid){
		var cwid = <?= $course['cwid'] ?>;
		var res = studyfinish(cwid,ctime,ltime,finished,plid);
		if(finished==1){
			showHomeWork();
		}
		return res;
	}
	//听完课打开第一个未做或者未做完的作业
	function showHomeWork(){
		var eid = "<?=empty($examlist[0])?0:$examlist[0]['eid'];?>";
		//已经打开过作业则不重复打开
		if(window.hasOpenHomeWork == true){
			return;
		}
		//升级学分
		updateCredit();
		if(eid!=0){
			var status = "<?=!empty($examlist[0])?$examlist[0]['status']:null?>"; //作业状态
			if(status!=1){
				$.confirm("操作提示","本课下还有作业未完成，请点击确定进行答题。",function(r) {
					window.hasOpenHomeWork = true; //标记作业为已打开过状态
					<?php
						$hmeid = empty($examlist[0])?0:$examlist[0]['eid'];
					if(!empty($isapple)) {
									$homewdourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$hmeid;
								} else {
									$homewdourl = 'http://exam.ebanhui.com/edo/'.$hmeid.'.html';
								}
					?>
					window.open("<?= $homewdourl ?>",'_blank');
				});
				
			}
		}
	}
	//视频播放完毕处理学分
	function updateCredit(){
		$.getJSON('/schcredit.html',
			{'cwid':<?=$course['cwid']?>,'crid':<?=$roominfo['crid']?>},
			function(res){
				return;
			}
		);
	}
	function showfeedback(){
		var isfeedback = 0;
		$.ajax({
			url : '/feedback/isfeedback/<?=$course['cwid']?>.html?ddd='+Math.random(),
			async : false,
			success : function(data){
				if(data==0)
					openfbdialog();
				else
					isfeedback = 1;
			}
		});
		if(isfeedback)
			window.open("/feedback/<?=$course['cwid']?>.html");
	}
	function closedialog(){
		H.get('artdialogfb').exec('close');
		window.open("/feedback/<?=$course['cwid']?>.html");
	}
	function openfbdialog(){
		height = 555;
		width = 870;
		url = '/feedback/<?=$course['cwid']?>.html';
		title = '听课反馈';
		var html = '<iframe marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id : 'artdialogfb',
			title : title,
			width : width,
			height : height,
			content : html,
			easy:true
		}),'common').exec('show');
	}
	function showAskDialog(){
		if($("#askdialog").length == 0){
			$('body').append('<iframe id="askdialog" style="display:none;overflow:hidden;" width=800 height=720 src="" frameborder="0"></iframe>');
		}
		var url = "/college/myask/addquestion.html?forcoursedialog=1&folderid=<?= $course['folderid'] ?>&cwid=<?=$course['cwid']?>&tid=<?=$course['uid']?>&v="+Math.random();
		$("#askdialog").attr('src',url);
		H.create(new P({
			title:'提问',
			height:740,
			id:'askDialog',
			content:$("#askdialog")[0],
			easy:true
		}),'common').exec('show');
	}

	function closeAskDialog(){
		H.get('askDialog').exec('close');
		$("#relativeask").html($("#relativeask").html()-0+1);
		getAskListAjax();
	}
	
	var url = "/myroom/mycourse/getajaxpage.html";
  	function getAjaxPage_Task(){
		var $curr_page_a = $('#reviewdiv .pages .listPage a.none');
		if($curr_page_a.length == 1){
			page = $curr_page_a.html()?$curr_page_a.html():1;
		}else{
			page = 1;
		}
		page_load(page,url);
		setTimeout(getAjaxPage_Task,60000);
  	}
  	setTimeout(getAjaxPage_Task,60000);

  	
  	function Mu(){
  		this.tag = 1;
  	}
  	Mu.prototype = {
  		callflash:function(data){
  			if(!isNaN(data.pos)){
  				data.pos = this.parsePos(data.pos);
  			}
  			this.checkSwf();
  			this.swf.setTxt(data.msg,data.isSelf,data['size'],data['color'],data.alpha,data.pos);
  		},
  		send:function(data){
  			var _data = {
  				'msg':data.msg || '',
  				'isSelf':data.isSelf || 0,
  				'size':data['size'] || 30,
  				'color':data['color'] || '#000000',
  				'alpha':data.alpha || 1,
  				'pos':data.pos || 0
  			}
  			_data.pos = this.parsePos(_data.pos);
  			if(data.isSelf == 1 && data.isFromPage == 1){
  				_data.pos = data.pos;
  				this.writeDb(_data);
  			}
  			this.callflash(_data);
  		},
  		writeDb:function(data){
  			var time = this.getplaytime();
  			if(time == 0){
  				return;
  			}
  			$.ajax({
				url:'/mu/addMuAjax.html',
				type:'post',
				data:{'cwid':'<?=$course['cwid']?>','msg':data.msg,'size':data['size'],'color':data['color'],'alpha':(data['alpha']*100),'pos':data['pos'],'time':time},
				dataType:'text',
				success:function(result){
					if(result == 0){
						$("#tanmu_msg").attr('placeholder','发送成功，再次发送');
					}else{
						$("#tanmu_msg").attr('placeholder','发送失败');
					}
				}
			});

  		},
  		getDuringList:function(){
  			var me = this;
  			var time = me.getplaytime();
  			var starttime = time-11;
  			if(starttime<0){
  				starttime = 0;
  			}
  			var endtime = time;
  			$.ajax({
				url:'/mu/getMusAjax.html',
				type:'post',
				data:{'cwid':'<?=$course['cwid']?>','starttime':starttime,'endtime':endtime},
				dataType:'json',
				success:function(mus){
					for(var i =0,length=mus.length;i<length;i++){
						if(mus[i].uid == '<?=$user['uid']?>'){
							mus[i].isSelf = 1;
						}
						me.send(mus[i]);
					}
					if(me.tag == 0){
						return;
					}
					clearTimeout(me.timer);
					me.timer = setTimeout(function(){
		  				me.getDuringList();
		  			},10000);
				}
			});
  		},
  		getplaytime:function(){
  			this.checkSwf();
  			//获取flash视频当前的播放时间
  			var time = this.swf.getplaytime();
  			if(isNaN(time)){
  				return 0;
  			}
  			return parseInt(time);
  		},
  		stopMu:function(){
  			this.checkSwf();
  			clearTimeout(this.timer);
  			if(this.tag == 0){
  				return;
  			}
  			this.tag = 0;
  			this.swf.hideScreen(0);
  		},
  		startMu:function(){
  			this.checkSwf();
  			if(this.tag == 1){
  				return;
  			}
  			this.tag = 1;
  			this.swf.hideScreen(1);
  		},
  		checkSwf:function(){
  			if(typeof this.swf == 'undefined'){
  				this.swf = document.getElementById('flvcontrol');
            }
  		},
  		parsePos:function(pos){
  			var retpos = 'default';
  			if(pos == 1){
  				retpos = 'top';
  			}else if(pos == 2){
  				retpos = 'center';
  			}else if(pos == 3){
  				retpos = 'bottom';
  			}
  			return retpos;
  		},
  		setTag:function(tag){
  			this.tag = tag;
  		},
  		pauseMu:function(){
  			this.checkSwf();
  			clearTimeout(this.timer);
  		}
  	}

  	function dosend(data){
		if($("#muswitch").attr("isclose") == "1" || isclose == 1 || typeof playevent.status == 'undefined' || playevent.status == 0) {
            return;
		}
  		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
  		if(typeof data == 'undefined'){
  			var msg = $("#tanmu_msg").val();
  			msg = $.trim(msg);
  			if(msg == ''){
  				return;
  			}
  			$("#tanmu_msg").val('');
	  		var size = $(".setFontSize li.selected a").attr('data-barrage-size');
	  		var color = $("#colorholder").val();
	  		var pos= $("#shlocation a.selected").attr('data-barrage-position');
	  		var alpha = document.getElementById('persent').pernum;
	  		var isFromPage = 1;
	  		alpha = alpha/100;
	  		var isSelf = 1;
  		}else{
  			var msg = data.msg;
  			var size = data['size'];
  			var color = data['color'];
  			var pos = data.pos;
  			var alpha = data.alpha;
  			alpha = alpha/100;
  			var isSelf = 0;
  			var isFromPage = 0;
	  		if(data.uid == '<?=$user['uid']?>'){
	  			isSelf = 1;
	  		}
  		}
  		dosend.mu.send({
  			'msg':msg,
  			'size':size,
  			'color':color,
  			'pos':pos,
  			'alpha':alpha,
  			'isSelf':isSelf,
  			'isFromPage':isFromPage
  		});
  	}

  	function startMu(startnow){
  		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
		dosend.mu.startMu();
		clearTimeout(dosend.mu.timer);
		dosend.mu.timer = setTimeout(function(){
	  		dosend.mu.getDuringList();
		},10000);
  	}

  	function stopMu(){
		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
  		dosend.mu.stopMu();
  	}

  	function pauseMu(){
  		if(typeof dosend.mu == 'undefined'){
  			dosend.mu = new Mu();
  		}
  		dosend.mu.pauseMu();
  	}


  	$(function(){
  		$('body').bind('click',function(){
  			$('.danmu-set-v').hide();
  		});
  		$(".danmu-set-v *").bind('click',function(){
  			return false;
  		});
  		$('#danmu_set').bind('click',function(){
  			$('.danmu-set-v').toggle();
  			$("#cancel").triggerHandler('click');
  			return false;
  		});
  		$("div.setFontSize li a").unbind().bind('click',function(){
  			$(this).parent('li').addClass('selected');
  			$(this).parent('li').siblings().removeClass('selected');
  			return false;
  		}).bind('dblclick',function(){
  			$('.danmu-set-v').hide();
  		});
  		$("#colorSetBd *").unbind();
  		$("#colorSetBd li a").bind('click',function(){
  			var color = $(this).attr('data-barrage-color');
  			color = '#'+color;
  			$("#colorholder").val(color);
  			$("#colorshow").attr('style','background: '+color+' none repeat scroll 0% 0%;');
  			$('i.hoverBor').hide();
  			$(this).find('i.hoverBor').show();
  			return false;
  		}).bind('dblclick',function(){
  			$('.danmu-set-v').hide();
  		});

  		$("#shlocation *").unbind();
  		$("#shlocation a").bind('click',function(){
  			$(this).addClass('selected');
  			$(this).siblings().removeClass('selected');
  		}).bind('dblclick',function(){
  			$('.danmu-set-v').hide();
  		});
  		$("#tanmu_msg").unbind().bind('keyup',function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
		    if(keycode == '13'){
		       dosend();
			}
  		});

  		// 拖动条开始
  		var handle=$("#draghandle");
	    var dragbar=$("#dragbar");
	    var persent = $("#persent");
	    var maxlen = dragbar.width()-handle.width()+1;
	    dragbar.unbind().bind('mousemove',function(e){
	    	if(handle.ismoving == 1){
	    		handle.curX = e.pageX;
	    		handle.offsetX = handle.startX-handle.curX;
	    		handle.startX = handle.curX;
	    		var left = handle.position().left-handle.offsetX;
	    		if(left <= 0 || left >= maxlen){
	    			return;
	    		}
	    		var pernum = (left/maxlen*100).toFixed(0)-0+1;
	    		persent.html( pernum + '%' );
	    		persent[0].pernum= pernum;
	    		handle.attr('style','left:'+left+'px');
	    	}
	    });
	    handle.bind('mousedown',function(e){
	    	handle.ismoving= 1;
	    	handle.startX = e.pageX;
	    });
	    handle.bind('mouseup',function(e){
	    	handle.ismoving = 0;
	    });
	    dragbar.bind('mouseup',function(e){
	    	handle.ismoving = 0;
	    });
	    dragbar.bind('mouseenter',function(){
	    	handle.ismoving = 0;
	    });
	    // 拖动条结束
	    $("#muswitch").bind('click',function(){
	    	if($(this).attr('isclose') == 1){
	    		this.isclose = 1;
				isclose = 1;
	    		$(this).removeAttr('isclose');
	    	}
//	    	var isclose = this.isclose;
	    	if(typeof isclose == 'undefined' || isclose == 0){
	    		$(this).removeClass('switch_open');
	    		delcookie('showmu');
	    		this.isclose = 1;
				isclose = 1;
	    		setCookie('ebh_showmu',0,30);
	    		stopMu();
	    	}else{
	    		$(this).addClass('switch_open');
	    		this.isclose = 0;
				isclose = 0;
	    		startMu(1);
	    		setCookie('ebh_showmu',1,30);
	    	}
	    	
	    })
  	});
	//flash播放状态改变回调函数
	function playevent(status){
		if($("#muswitch").attr('isclose') == 1){
    		$("#muswitch")[0].isclose = 1;
    		$("#muswitch").removeAttr('isclose');
			isclose = 1;
    	}
//		isclose = $("#muswitch")[0].isclose;
		if(isclose == 1){
			if(status == 0){
				playevent.status = 0;
			}else if(status == 1 && (playevent.status == 0 || (typeof playevent.status == 'undefined') )  ){
				playevent.status = 1;
			}
			return;
		}
		if(status == 0){
			playevent.status = 0;
			pauseMu();
		}else if(status == 1 && (playevent.status == 0 || (typeof playevent.status == 'undefined') )  ){
			playevent.status = 1;
			startMu();
		}
	}
</script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
</head>
<body>
<div class="xkcg1s" id="opencount" style="display:none;">
    <div class="mycjkclb1s tishitit">对不起，您尚未开通 <?= empty($payitem) ? '学习和作业功能' : $payitem['iname'] ?> 或课程已到期</div>
    <p class="p1s">开通课程后，您就可以随时地在网校使用在线学习、</p>
    <p class="p1s">做作业、互动答疑等所有功能了。</p>
    <div class="xuanbtn2s">
        <a href="javascript:void(0)" onclick="openonline()" class="jxxk1s">去开通</a>
    </div>
</div>
<?php
$domain=$this->uri->uri_domain();//测试用
?>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<input type="hidden" value="<?=$domain?>" id="domain">

<div style="width:980px;margin:0 auto;">
<div class="cright" style="display: block;margin: 0 auto;width:980px;margin-bottom:20px;">

		<?php
		$cloudurl='http://'.$domain.'.ebanhui.com';?>
		<?php if($domain == 'www'){ ?>
			<div class="ter_tit">
				>
				<a href="<?= $cloudurl?>" title="<?= $coursedetail['crname']?>"><?= $coursedetail['crname']?></a>
				>
				<span style="color:#3D3D3D;"><?= $coursedetail['foldername']?></span>
				> <?= $coursedetail['title']?>
			</div>
		<?php }else{ ?>
			<div class="ter_tit" style="border:none;">
			当前位置 > 所有课程 > <?= $course['foldername'] ?> > <?= $course['title']?>
			</div>
		<?php } ?>
<div class="lefrig" style="margin-top:0;float:none;width: 980px">
			<div class="classbox" style="width:980px;border:none;background: #FFF;border-top:1px solid #f1f1f1;border-bottom:1px solid #f1f1f1;min-height:75px;">
			<div style="float:left;margin:10px 15px 0 18px; width:60px; text-align:center;">
			<?php 					
					if($course['sex'] == 1) {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					} else {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}
					$face = empty($course['face']) ? $defaulturl : $course['face'];
					$face = getthumb($face,'50_50');
			?>
<img src="<?=$face?>" style="width:40px;height:40px; border-radius:20px;">
<p class="lsxm"><?= shortstr(empty($course['realname'])?$course['username']:$course['realname'],8)?></p>
</div>
				<h1 class="rygers"><?= $course['title']?></h1>
				<div class="classboxmore">
				<?php
						$viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);
						$dateline = empty($course['submitat'])?$course['dateline']:$course['submitat'];
						?>
					<p style="font-size:13px;color:#999;"><?= $course['summary'] ?></p>
					<p  style="color:#999;font-family:微软雅黑;"><span style="margin-left:0;"><?= date('Y-m-d',$dateline)?> 发布</span><span class="rqzs"><?= $viewnum?></span>		
					<?php if(!empty($course['rtmpurl'])) { ?>

					<span style="float:right;">如您无法正常播放，也可以 <a href="<?= geturl('myroom/mycourse/'.$course['cwid']).'?$type=1' ?>" style="color:blue">点击这里</a></span>
					<?php } ?>
					</p>
					<p style="">
					<?php if($type == 'ebh' || $type == 'ebhp') {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE ) { ?>
							<?php if($course['isfree']==1){ ?>
							<input class="huangbtn marrig" value="开始听课" type="button"  onclick="freeplay('<?= $course['cwsource']?>','<?= $course['cwid']?>','<?php str_replace("'"," ",$course['title'])?>',1,0,showdialogs)"/>
							<?php }else{ ?>
							<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
							<?php } ?>
							<?php if($domain == 'bndx'){ ?>
							<input class="huangbtn marrig" value="录入笔记" type="button"  onclick="javascript:$('#notecontent').show()"/>
							<?php } ?>
						<?php } ?>
					
					<?php } elseif (!empty($course['cwurl']) && $type != 'flv' && $type != 'mp3'&& $type!='swf') { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig"style=" ">下载文件</a>
						<!-- 
						<?php if($course['ispreview']) { ?>
						<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank" style="">预 览</a>
						<?php } ?>
						 -->
						<!-- 巴南网校附加普通课件录入笔记功能 -->
						<div style="*margin-bottom:10px;">
							<a class="lanbtn" href="javascript:void(0)" id="favorite" style=""></a>
							<?php if($domain == 'bndx'){ ?>
							<a id="notebtn" class="lanbtn" name="notes" href="javascript:void(0)" style="margin-left:10px;">录入笔记</a>
							<?php } ?>
						</div>
					<?php }else{ ?>
						<!-- 巴南网校没有任何课件时录入笔记功能(全部网校) -->
						<?php if(empty($course['cwurl'])){ ?>
						<div style="*margin-bottom:10px;">
							<a class="lanbtn" href="javascript:void(0)" id="favorite" style=""></a>
							<a id="notebtn" class="lanbtn" name="notes" href="javascript:void(0)" style="margin-left:10px;">录入笔记</a>
						</div>
						<?php } ?>
					<?php } ?>
					</p>
				</div>
			</div>
			<?php if(($type != 'flv' && $type != 'mp3'&&$type!='swf')){ ?>
			<!-- 巴南网校普通课件加入录入笔记功能 (全部网校)-->			
			<div id="notecontent" style="display:none">
					<div class="txtxdaru" style="float:left;width:980px;display: inline;margin-top:5px;">
					<?php if(empty($mynote['ftext'])){ ?>
						  <?php $editor->xEditor('message','978px','300px'); ?>
					<?php }else{ ?>
						  <?php $editor->xEditor('message','978px','300px',$mynote['ftext']); ?>
					<?php } ?>
					</div>
				  <div style="float:right;margin-top:5px;">
					<a href="javascript:;" id="cancel" style="margin-right:80px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px; border-radius:4px;">取消</a>
					<a href="javascript:;" onclick="submitnote(<?= $course['cwid']?>);" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;border-radius:4px;">提交</a>
				  </div>
			</div>
			<?php } ?>
			
			<?php if(isset($checkip) && $checkip === FALSE) {?>
			<div class="classbox" style="width:978px;background: #FFF;border:solid 1px #cdcdcd;min-height:30px;margin-top:5px;">
				<div class="classboxmore" style="width:928px;color:red;font-size:14px;">
				重要通知： 为了同学们账号密码安全，经常在不同场所同一时间上线的账号会被系统找出，并且限制登陆甚至封号，建议单独使用账号并妥善更改密码和保管密码。
				</div>
			</div>
			<?php } ?>
			<?php if($type == 'flv' || $type == 'mp3'|| $type == 'swf') { ?>
				<?php if($type == 'mp3') {?>
				<div style="color:red;position: relative;height:400px;z-index:601;float:left;" class="mp3block">
				<?php } else {?>
				<div style="color:red;position: relative;height:560px;z-index:601;float:left;">
				<?php } ?>
				<?php if(SYSTIME>=$course['submitat'] && (empty($course['endat']) || SYSTIME<=$course['endat'])){?>
				<div id="flvcontrol" style="width:980px;height:560px;">
				
				</div>
				<?php }elseif(empty($course['endat']) || SYSTIME<=$course['endat']){?>
				<div style="width:978px;height:558px;background:white;border:1px solid #DDDDDD;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</span>
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">倒计时：<span id="countdown"><?=secondToStr($course['submitat']-SYSTIME)?></span></span> 
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">请耐心等候...</span>
				</div>
				<script>
					$('.mp3block').css('height','560px');
				</script>
				<?php }else if($isliverun){?>
				<div style="width:978px;height:558px;background:white;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
				</div>
				<script>
					$('.mp3block').css('height','560px');
				</script>
				<?php }else{?>
				<div style="width:978px;height:558px;background:white;border:1px solid #DDDDDD;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
				</div>
				<script>
					$('.mp3block').css('height','560px');
				</script>
				<?php }?>
				</div>


				<div id='atsrc' style="display: none;"></div>
			<div class="flaoter" style="margin-top:0px;height:27px;background:#2a2a2a;width:960px; border:none;"> 
			

<?php //if($type!='swf'){?>
<div class="mod-func">
<div class="play-danmuWrap play-danmuWrap_close" data-widget-barrage1_5="play" data-barrage1_5-type="short" style="display:<?php if($type=='swf') echo 'none'?>">
<qchunk style="display: block;" data-barrage-ele="barrage" id="block-tucaou" data-asyn-pb="true">
                              <!-- 弹幕开关 -->
                              <div class="danmu-close fl">
                                <div class="clearfix">
                                  <h3 class="fl danmuTit">弹幕</h3>
									<?php
										$showmu = $this->input->cookie('showmu');
									?>
									<?php if($showmu === '0'){?>
                                		<a href="javascript:void(0);" id="muswitch" rseat="140743_opn" data-barrage-status="show" isclose=1 class="switch  fl" data-pb="qpid=384616000"></a> </div>
                              		<?php }else{?>
                              			<a href="javascript:void(0);" id="muswitch" rseat="140743_opn" data-barrage-status="show" class="switch  fl switch_open" data-pb="qpid=384616000"></a> </div>
                              		<?php }?>
                              </div>
                              <!-- 弹幕开关 end-->
                              <!-- 弹幕主内容区 -->
                              <div id="danmu" class="danmu-main fl">
                                <div data-barrage-panel="config" class="tucao-static pr"> <a id="danmu_set" href="javascript:void(0);" class="fl pr tucao-btn" data-barrage-config="config">设置</a>
                                  <!-- 开关引导 -->
                                  <div class="guide-switch" style="display: none;" data-barrage-btntip="wrap" data-private-display="block">
                                    <p class="p-tip1"></p>
                                    <p class="p-tip2"></p>xcxc
                                  </div>
                                  <!-- 开关引导 end-->
                                  <!-- 关闭引导 class替换为guide-switch-close -->
                                  <!-- 设置模块v1.4 -->
                                  <span data-barrage-module="config" data-rendertype="2" data-render="1"><div data-barrage-panel="panel" class="danmu-set-v "><div class="danmu-set_arrowWrap"><i class="danmu-set_arrow"></i><i class="danmu-set_arrowInner"></i></div><div class="set-bd-v"><div class="danmuSet-lt fl"><div class="set-bd-tit"><h4>我的弹幕<em>编辑自己发送的弹幕</em></h4></div><div class="set-bd-container clearfix"><!-- 字号 --><div class="setFontSize fl"><h3>字号</h3><ul><li class="selected"><a rseat="140826_zihao" data-barrage-size="30" class="fs18" href="javascript:void(0);">大</a></li><li class=""><a rseat="140826_zihao" data-barrage-size="20" class="fs16" href="javascript:void(0);">中</a></li><li><a rseat="140826_zihao" data-barrage-size="10" class="fs12" href="javascript:void(0);">小</a></li></ul></div><!-- 字号 end--><!-- 颜色 --><div class="danmu-set-colorHd-v fl"><div class="danmu-set-colorHd-tit clearfix"><span class="tag-fs fl">颜色</span><span class="colBox fl"><input id="colorholder" type="text" data-barrage-customcolor="color" placeholder="#000000"></span><span id="colorshow" data-barrage-preview="color" class="save-color-box fl" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;"></span></div><div class="color-set-bd mt5"><ul id="colorSetBd"><li><a rseat="140826_yanse" data-barrage-color="FFFFFF" href="javascript:void(0);" class="col-FFFFFF" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li  class="hover"><a rseat="140826_yanse" data-barrage-color="000000" href="javascript:void(0);" class="col-000000" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF0000" href="javascript:void(0);" class="col-FF0000" style="background: rgb(255, 0, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF9900" href="javascript:void(0);" class="col-FF9900" style="background: rgb(255, 153, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FFF100" href="javascript:void(0);" class="col-FFF100" style="background: rgb(255, 241, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="00FF12" href="javascript:void(0);" class="col-00FF12" style="background: rgb(0, 255, 18) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="00FCFF" href="javascript:void(0);" class="col-00FCFF" style="background: rgb(0, 252, 255) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="008CEE" href="javascript:void(0);" class="col-008CEE" style="background: rgb(0, 140, 238) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="8600FF" href="javascript:void(0);&quot;&quot;" class="col-8600FF" style="background: rgb(134, 0, 255) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF6600" href="javascript:void(0);&quot;&quot;" class="col-FF6600" style="background: rgb(255, 102, 0) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="FF0096" href="javascript:void(0);" class="col-FF0096" style="background: rgb(255, 0, 150) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="920683" href="javascript:void(0);" class="col-920683" style="background: rgb(146, 6, 131) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="601886" href="javascript:void(0);" class="col-601886" style="background: rgb(96, 24, 134) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="1D24A4" href="javascript:void(0);" class="col-1D24A4" style="background: rgb(29, 36, 164) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="804E21" href="javascript:void(0);" class="col-804E21" style="background: rgb(128, 78, 33) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="9D6A3C" href="javascript:void(0);" class="col-9D6A3C" style="background: rgb(157, 106, 60) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="DE8A3E" href="javascript:void(0);" class="col-DE8A3E" style="background: rgb(222, 138, 62) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="90C41E" href="javascript:void(0);" class="col-90C41E" style="background: rgb(144, 196, 30) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="21AC38" href="javascript:void(0);" class="col-21AC38" style="background: rgb(33, 172, 56) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li><li><a rseat="140826_yanse" data-barrage-color="009139" href="javascript:void(0);" class="col-009139" style="background: rgb(0, 145, 57) none repeat scroll 0% 0%;"><i class="hoverBor"></i></a></li></ul></div></div><div class="mod-location fl"><h3>位置</h3><div id="shlocation" class="mod-location-bd"><a rseat="140826_weizhi" data-barrage-position="1" href="javascript:void(0);" class=""><i class="dt_top"></i><span>顶部</span></a><a rseat="140826_weizhi" data-barrage-position="2" class="" href="javascript:void(0);"><i class="dt_center"></i><span ata-barrage-position="2">中间</span></a><a rseat="140826_weizhi" data-barrage-position="3" class="" href="javascript:void(0);"><i class="dt_bottom"></i><span ata-barrage-position="3">底部</span></a><a rseat="140826_weizhi" data-barrage-position="0" class="selected" href="javascript:void(0);"><i class="dt_random "></i><span ata-barrage-position="0">随机</span></a></div></div></div></div><div data-barrage-wrap="danmusetrt" class="danmuSet-rt fl"><div class="set-bd-tit"><h4>弹幕显示设置</h4></div><!-- 透明度 --><div data-barrage-opacity="wrap" class="mod-opac-set"><h3>透明度</h3><div class="opac-block mt5 clearfix"><div id="dragbar" rseat="140826_toumin" data-barrage-opacity="btn" class="opacBg-outer-v fl pr"><span id="draghandle" class="opacBg-inner-v" style="left: 70px;" data-barrage-opacity="trigger"></span></div><div id="persent" class="opac-block-num fl ml5" data-barrage-opacity="value"> 82%</div></div></div><!-- 透明度 --><div class="bq-set-show"><h3>弹幕显示</h3><a class="disabled-pic" data-barrage-filter="image" href="javascript:void(0);" rseat="14090901_bqkq"><i class="disPic-ico"></i><span>屏蔽图片表情</span></a></div></div></div></div></span>
                                  <!-- 设置模块v1.4 end-->
                                </div>
                                <span  data-barrage-wrap="input" class="conduct-bar pr conduct-bar-v2 tucao-input-default"> <span class="inputAdd-smile">
                                  <input id="tanmu_msg" type="text" maxlength="20" class="fl tucao-input" placeholder="发送弹幕一起high！" data-barrage-input="barrage" style="width:235px;overflow:hidden;">
                                  <!-- 输入引导 -->
                                  <span style="display: none;" data-barrage-guide="tip" data-private-display="block"></span>
                                  <!-- 输入引导 end-->
                                  </span> <span data-pb="qpid=384616000" class="fl pr tucao-bqBtn" style="display:none;" rseat="140730_0" data-barrage-face="barrage"> <i class="smile-lightIco"></i>
                                  <!-- 笑脸上方TIPS -->
                                  <!-- 表情引导 -->
                                  <div class="guide-smile" style="display: none;" data-barrage-facetip="wrap" data-private-display="block">
                                    <p class="p-tip1"></p>
                                    <p class="p-tip2"></p>
                                  </div>
                                  <!-- 表情引导 end-->
                                  <iframe frameborder="0" style="display:none;" class="frame-smile" data-barrage-iframe="face"></iframe>
                                  <!-- 笑脸上方TIPS end-->
                                  <!-- 表情 -->


                                  <!-- 表情 end-->
                                  </span> </span> <a data-pb="qpid=384616000" href="javascript:dosend();" class="fl send-btn " data-barrage-send="barrage" rseat="140730_set" style="display: block;">发送</a> </div>
                              <!-- 弹幕主内容区 end-->
                            </qchunk>
                            </div>
                            </div>
<!--            --><?php //}?>






			<div class="ieyin" style="_display:block;"><br/><br/></div>

			<div class="tksile" style="width:435px;">
							<?php if((empty($hasnobtn) || $hasnobtn != TRUE) && $user['groupid'] == 6 && $domain != 'www') { ?>
					<a href="javascript:;" class="<?= empty($myfavorite)?'shoutie':'yishout'?>" id="favorite" style="height:17px;line-height:17px;" ></a>
				<?php } ?>
				<a href="javascript:showfeedback();" class="tingfan">听课反馈</a>
				<?php if(($roominfo['isschool']!=2) && ($type == 'flv' || $type == 'mp3' ||$type=='swf')&& $domain!='www'){ ?>
					<a id="notebtn" href="javascript:;" class="lubij" name="notes">录入笔记</a>
					<a href="javascript:;" onclick="document.getElementById('flvcontrol').callflashvideo()"  class="tixuetime" style="display:<?php if($type=='swf') echo 'none'?>">提交学习时间</a>
				<?php } ?>
				<a href="javascript:void(0)" onclick="showAskDialog()" class="tiwenti" name="notes">提问</a>
			</div>

			</div>
			<div id="notecontent" style="display:none">
					<div class="txtxdaru" style="float:left;width:980px;display: inline;margin-top:5px;">
					<?php if(empty($mynote['ftext'])){ ?>
						  <?php $editor->xEditor('message','978px','300px'); ?>
					<?php }else{ ?>
						  <?php $editor->xEditor('message','978px','300px',$mynote['ftext']); ?>
					<?php } ?>
					</div>
				  <div style="float:right;margin-top:5px;">
					<a href="javascript:;" id="cancel" style="margin-right:80px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px; border-radius:4px;">取消</a>
					<a href="javascript:;" onclick="submitnote(<?= $course['cwid']?>);" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;border-radius:4px;">提交</a>
				  </div>
			</div>
			<?php } else if($course['islive']) {?>
				<div style="color:red;position: relative;height:558px;z-index:601;float:left;">
				<?php if($isliverun){?>
				<div style="width:980px;height:558px;background:white;text-align:center">
				<span style="font-size:36px;width:970px;float:left;margin-top:150px">上课进行中...</span>
				<span style="font-size:50px;width:970px;float:left;margin-top:10px"><a id="notebtn" class="lanbtn liaskt" name="notes" href="/myroom/mycourse/<?= $course['cwid'] ?>.html?flag=1" style="font-family: 微软雅黑;font-weight:normal;margin-left:330px;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:36px;width:300px;background:#18a8f7;">进入学习</a></span> 
				</div>
				<?php }elseif(empty($course['endat']) || SYSTIME<=$course['endat']){?>
				<div style="width:978px;height:558px;background:white;border:1px solid #DDDDDD;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</span>
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">倒计时：<span id="countdown"><?=secondToStr($course['submitat']-SYSTIME)?></span></span> 
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">请耐心等候...</span>
				</div>
				<?php }else{?>
				<div style="width:978px;height:558px;background:white;border:1px solid #DDDDDD;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
				</div>
				<?php }?>
				</div>
			<?php } ?>
			
			
		<!-- 课件 ppt/word等预览 开始 -->
		<?php $this->assign('course',$course);?>
		<?php $this->display('common/previewv2');?>
		<!-- 课件 ppt/word等预览  结束 -->
		
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:20px;width:980px;border:none;">
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
			  	<div class="inconts" style="width:928px;">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>
			
			
			<?php if(!empty($examlist) && ($domain!='www')) { ?>
			<div class="introduce" style="width:980px; border:none;">
					<div class="intitle">
					<h2>在线作业</h2>
				</div>
				<div class="incont" style="width:980px;">
						<table width="978px;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th width="55%" style="padding-left:35px;" >&nbsp;作业名称</th>
									<th width="13%" >出题时间</th>
									<th width="10%" style="text-align:center;">总分</th>
									<th width="22%" style="text-align:left;">操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							 	</tr>
							  </thead>
								<tbody>

								 <?php $firstHomeWork?>			
								 <?php foreach($examlist as $exam) { 
								if(!empty($isapple)) {
									$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
									$viewurl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid='.$roominfo['crid'].'&k='.urlencode($key).'&eid='.$exam['eid'];
								} else {
									$dourl = 'http://exam.ebanhui.com/edo/'.$exam['eid'].'.html';
									$viewurl = 'http://exam.ebanhui.com/emark/'.$exam['eid'].'.html';
								}
								 
								 ?>
								  <tr>
									<td width="55%" style=""><p class="bzzytitle">&nbsp;<?= $exam['title'] ?></p></td>
									<td width="13%"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
									<td width="10%" style="text-align:center;"><?= $exam['score'] ?></td>
									<td width="22%">
											<?php if($exam['status']==null){?>
												<a class="previewBtn" style="" href="<?= $dourl ?>" target="_blank"><span>做作业</span></a>
											<?php }else if($exam['status']==1){?>
												<a class="lviewbtn" style="" href="<?= $viewurl ?>" target="_blank">查看结果</a>
											<?php }else{?>
												<a class="previewBtn" style="" href="<?= $dourl ?>" target="_blank">继续做作业</a>
											<?php }?>
									</td>
								  </tr>
								  <?php } ?>
								
							  </tbody>
						</table>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($survey) && ($domain!='www')) { ?>
			<div class="introduce" style="width:980px;border:none;">
					<div class="intitle">
					<h2>调查问卷</h2>
				</div>
				<div class="incont" style="width:980px;">
						<table width="978px;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th style="padding-left:35px;">问卷名称</th>
									<th style="padding-left:50px;">开放时间</th>
									<th style="padding-left:80px;">操作</th>
							 	</tr>
							  </thead>
								<tbody>
								  <tr>
									<td width="55%" style="font-family:微软雅黑;color:#333;padding:3px 6px;font-size:14px;">&nbsp;<?=strip_tags($survey['title']) ?></td>
									<td width="23%"><?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d',$survey['enddate'])?></td>
									<td width="22%">
											<?php if(!$survey['answered'] && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME-86400)){?>
												<a class="previewBtn" style="" href="/college/survey/fill/<?= $survey['sid'] ?>.html" target="_blank">参与调查</a>
											<?php }else{?>
												<a class="previewBtn" style="" href="/college/survey/answer/<?= $survey['sid'] ?>.html" target="_blank"><span>查看详情</span></a>
											<?php }?>
											<?php if($survey['allowview']){?>
												<a class="previewBtn" style="" href="/college/survey/stat/<?= $survey['sid'] ?>.html" target="_blank">统&nbsp;&nbsp;计</a>
											<?php }?>
									</td>
								  </tr>
							  </tbody>
						</table>
					</div>
				</div>
			<?php } ?>

			<a name="fujian" href="javascript:void(0);"></a>

				<?php if (($domain!='www') && (!empty($attachments))) { ?>
				<div class="introduce" style="width:980px; border:none;">
					<div class="intitle">
						<h2>附件下载</h2>
					</div>
							
					<div class="incont" style="width:980px;">
							<table width="978px;" class="datatab" style="border:none;">
								<thead class="tabhead">
									<tr>
										<th style="padding-left:35px;">附件名称</th>
										<th>上传时间</th>
										<th>附件大小</th>
										<th>操作</th>
									</tr>
								  </thead>
									<tbody>
									 <?php foreach ($attachments as $atta) { ?>
									  <tr>
									  
									  
									<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<td width="55%"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/fjico.png" style="width:13px;height:13px;float:left;padding-left:10px;padding-top:5px;"><span style="width:400px;word-wrap: break-word;float:left;padding-left:5px"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
										<?php } else { ?>
											<td width="55%"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/fjico.png" style="width:13px;height:13px;float:left;padding-left:10px;padding-top:5px;"><span style="width:400px;word-wrap: break-word;float:left;padding-left:10px"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
										<?php } ?>
									<?php } ?>
										<td width="13%"><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
										<td width="10%"><?= getsize($atta['size'])?></td>
										<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<td width="22%">
											<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载" type="button" />
												<?php if($atta['ispreview']) { ?>
												<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" target="_blank">预览</a>
												<?php } ?>
											<?php } else { ?>
												<a class="atfalsh" href="javascript:void(0);" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
											<?php } ?>
										</td>
										<?php } ?>
									  </tr>
									  <?php } ?>
								  </tbody>
							</table>
					</div>
				</div>
				<?php } ?>
			
<?php if($roominfo['crid'] != 10420){ ?>
	<div class="introduce" style="float:left;width:980px; border:none;padding-bottom:120px;">
		<div class="work_mes" style="width:978px;margin-bottom:10px">
			<ul>
				<li class="workcurrent reviewtab" onclick="showreview()"><a href="javascript:void(0)"><span><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?>(<font color="red" id="reviewcount"><?=$reviewcount?></font>)</span></a></li>
				<li class="asktab" onclick="showask()"><a href="javascript:void(0)"><span>相关问题 (<font color="red" id="relativeask"><?=$askcount?></font>)</span></a></li>
				<?php if($type == 'flv'){?>
				<li class="reviewtab" id="analysis"><a href="javascript:void(0)"><span>分析统计</span></a></li>
				<?php }?>
			</ul>
		</div>
		<div id="reviewdiv">
			<div class="appraise" style="margin-left:30px;">
				
			<?php if (!empty($reviews)) { ?>
				<?php foreach ($reviews as $review) { ?>
				   <?php
					if ($review['sex'] == 1)
						$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					else
						$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					$face = empty($review['face']) ? $defaulturl : $review['face'];
					$face = getthumb($face, '50_50');
					?>
				<dl>
					<dt><div class="userimg">
					<a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><img width="40px" height="40px" src="<?= $face ?>" alt="<?= shortstr($review['username'],8)?>" /></a>
					<a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></a>
					<span class="<?=($review['sex']==1)?"xingbie":"xingbie1" ?>"></span>
					<div style="clear:both;"></div>
					<span class="renming1"><?= $review['username'] ?></span>
					</div></dt>
					<dd>
					<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span>
					<?php if($domain == 'bndx'){ $reviewtxtarr = array('','一般','好','很好');?>
					<div class="grade">总体评分:<?=$reviewtxtarr[$review['score']]?>
					</div>
					<?php }else{ ?>
					<div class="grade">总体评分: 
					<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
					<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
					</div>
					</div>
					<?php } ?>
					<p><?= $review['subject'] ?></p>
					<?php if (!empty($review['rsubject'])) { ?>
					<div class="restore">
						<div class="restore_arrow">◆</div>
						<div class="restore_cont"><h1>老师回复：</h1><?= $review['rsubject'] ?></div>
					</div>
					<?php } ?>
					</dd>
				</dl>
				<?php } ?>
			<?php } else { ?>
				<dl>
					<div id="nocommentdiv" style="width:910px;min-height:50px;text-align:center;"><img style="margin-top: 45px;" src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"></div>
				</dl>
			<?php } ?>
				<div id="commentlastdiv" class="clear"></div>	
				 
			</div>
		<?= $pagestr ?>
		</div>
		<div id="askdiv" style="float:left;width:970px;display:none;padding-bottom:30px">
			<div style="text-align:center;" id="noask">
			<span style="font-size:14px;line-height:30px;width:978px;height:200px;float:left;margin-bottom:20px;margin-top:20px;" >
			<img src="http://static.ebanhui.com/ebh/tpl/default/images/noask.png" >
			</span>
			<input class="tijibtn" type="button" value="提&nbsp;&nbsp;问" onclick="showAskDialog()">
			
			</div>
			<div class="tweytr" style="margin-left:10px">
				<table>
				
				</table>
			</div>
			
		</div>
			<div class="qzsjlb" id='analysisdiv' style="display: none">
				<div class="zhqks mt35">
					<div class="nnbl">课件听课人数</div>
					<div class="ml20 mt30" id="chartcontainer1" style="text-align:center;width:875px;height:400px"></div>
				</div>
		        <div class="zhqks mt35">
					<div class="nnbl">我的听课数据</div>
					<div class="ml20 mt30" id="chartcontainer2" style="text-align:center;width:875px;"></div>
				</div>
		        <div class="zhqks zhqks1s mt35">
		        	<span class="wdtkcs times">我的听课次数：次</span>
		            <span class="wdtkcs wdtkcs1s totaltime">我的听课时长：分钟</span>
		            <span class="wdtkcs ord">排名：名</span>
		        </div>
			</div>		
<div style="min-height:200px; position:relative;float:left;" id="cmdiv">			  
	<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:20px;height:163px;height:163px;">
		<div id="b2">
			<div>
				<table class="datamis" cellspacing="0">
				<thead class="tabdmis">
					<?php
						foreach($emotionarr as $k=>$emotion){
							if(($k)%13==0){
								echo '<tr>';
							}
					?>
					<td><a href="javascript:;" title="<?=$emotion?>"><img class="emotionbtn" width="24" height="24" src="http://static.ebanhui.com/ebh/tpl/default/images/<?=$k?>.gif" code="[emo<?=$k?>]"></a></td>
					
					<?php if(($k+1)%13==0){
							echo '</tr>';
						}
					}
					?>
				  
					<tr>
					<td colspan="13" style="height:63px;">
					<span style="float:right;margin:5px 10px 5px 0;"><span id="showtitle" style="float: left;font-size: 16px;font-weight: bold;margin-right: 5px;margin-top: 18px;display:none;"></span>
						<img id="showimg" style="width:48px;height:48px;display:none;" src=""> </span></td>
					</tr>
				  </thead>
				</table>
			</div>
		</div>
	</div>
		<?php if($domain!='www'){ ?>
			<div class="fill" style="width:956px;height:auto;padding-left: 20px;margin:0;padding-bottom:0px;" id="rev">
					<p class="pl" <?php if($domain == 'bndx'){ ?>style="color:#000;font-weight:bold"<?php } ?>>满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
					<?php if($domain == 'bndx'){ ?>
					<!-- 评价满意度改为单选 -->
					<input name='cstar' type="radio" value=3>很好
					&nbsp;&nbsp;<input name='cstar' type="radio" value=2>好
					&nbsp;&nbsp;<input name='cstar' type="radio" value=1>一般
					<?php }else{ ?>
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
					<?php } ?>
					</em></p>
					<div style="background:#f9f9f9;width:40px;height:89px;position: absolute;top:33px;left:21px;"><a style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/smeil.png) no-repeat;display:block;margin:30px 0 0 8px;height:24px;line-height:24px;overflow: hidden;width:24px;" href="javascript:;" id="showface" ></a></div>
					<p>
					<textarea id="comm" x_hit="请输入评论内容" name="comm" cols="" style="resize:none;height:81px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext"></textarea>
			</div>

					</p>
					<p class="plogin" style="width:946px;margin-left:20px;float:left;">
					<span style="float:left;">(1-100字)</span> 
					<span>
					<a href="javascript:;" onclick="comment();" id="submit" style="margin-right:100px;background:#18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px; border-radius:3px;" name="review">评论</a>
					</span>
					</p>
			</div>
			<?php } ?>
		  </div>
			</div>
		<?php }else { ?>
		<?php if($roominfo['isschool']!= 3){ ?>
		<div class="introduce" style="float:left;width:980px;">
					<div class="intitle"><h2><a id="rid"><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论'?></a></h2></div>
					  <div class="appraise" style="margin-left:30px;">
							
						<?php if (!empty($reviews)) { ?>
							<?php foreach ($reviews as $review) { ?>
							   <?php
								if ($review['sex'] == 1)
									$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
								else
									$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
								$face = empty($review['face']) ? $defaulturl : $review['face'];
								$face = getthumb($face, '50_50');
								?>
							<dl>
								<dt><div class="userimg">
								<a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><img width="40px" height="40px" src="<?= $face ?>" alt="<?= shortstr($review['username'],8) ?>" /></a>
								<a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></a>
								<span class="<?=($review['sex']==1)?"xingbie":"xingbie1" ?>"></span>
								<div style="clear:both;"></div>
								<span class="renming1"><?= $review['username'] ?></span>
								</div></dt>
								<dd>
								<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span>
								<div class="grade">总体评分:  
								<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
								<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
								</div>
								</div>
								<p><?= $review['subject'] ?></p>
								<?php if (!empty($review['rsubject'])) { ?>
								<div class="restore">
									<div class="restore_arrow">◆</div>
									<div class="restore_cont"><h1>老师回复：</h1><?= $review['rsubject'] ?></div>
								</div>
								<?php } ?>
								</dd>
							</dl>
							<?php } ?>
						<?php } else { ?>
							<dl>
								<div id="nocommentdiv" style="width:910px;min-height:50px; text-align:center;"><img style="margin-top: 45px;" src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu.png"></div>
							</dl>
						<?php } ?>
							<div id="commentlastdiv" class="clear"></div>	
							 
					  </div>
				   <?= $pagestr ?>
				  
			<div style="min-height:390px; position:relative;float:left;">			  
				<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:20px;height:163px;height:163px;">
					<div id="b2">
						<div>
						<table class="datamis" cellspacing="0">
						<thead class="tabdmis">
						  <?php
								foreach($emotionarr as $k=>$emotion){
									if(($k)%13==0){
										echo '<tr>';
									}
							?>
							<td><a href="javascript:;" title="<?=$emotion?>"><img class="emotionbtn" width="24" height="24" src="http://static.ebanhui.com/ebh/tpl/default/images/<?=$k?>.gif" code="[emo<?=$k?>]"></a></td>
							
							<?php if(($k+1)%13==0){
									echo '</tr>';
								}
							}
							?>
							<tr>
							<td colspan="13" style="height:63px;">
							<span style="float:right;margin:5px 10px 5px 0;"><span id="showtitle" style="float: left;font-size: 16px;font-weight: bold;margin-right: 5px;margin-top: 18px;display:none;"></span>
								<img id="showimg" style="width:48px;height:48px;display:none;" src=""> </span></td>
							</tr>
						  </thead>
						</table>
						</div>
					</div>
				</div>	   
				<?php if($domain!='www'){ ?>
				  	<div class="fill" id="rev" style="width:956px;height:auto;padding-left: 20px;margin:0;padding-bottom:0px;" >
						<p class="pl">我来评论  　　满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em>
						</p>
						<p><textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext" x_hit="请输入评论内容"></textarea></p>
						<p class="plogin" style="width:946px;margin-left:20px;float:left;">
							<span style="float:left;">(1-100字)</span> 
							<span><a href="javascript:;" onclick="comment();" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px;" name="review">评论</a>
							</span>
						</p>
				  	</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
<?php } ?>
</div>
<div id="moreask" style="display:none;float:left;text-align:center;background:#fff;border:1px solid #cdcdcd;width:978px;height:35px;line-height:35px;font-size:14px;margin-top:-10px;">
	<a target="_blank" href="/myroom/myask/all.html?cwid=<?=$course['cwid']?>" style="width:978px;display:block">更多>></a>
</div>
</div></div>
<?php 
if($type == 'ebhp') {
	$this->display('myroom/player'); 
}
?>
<?php $this->display('myroom/page_footer'); ?>

<script defer="defer" type="text/javascript">
$(function(){
	$('#analysis').click(function(){
		var cwid = <?=$course['cwid']?>;
		var url = '/myroom/mycourse/getanalysisajax.html'
		$.ajax({
			url:url,
			type:'post',
			data:{'cwid':cwid},
			dataType:'json',
			success:function(result){
				$('#chartcontainer1').highcharts({
					chart: {
						type: 'pie'
					},
					series:[{
						name:'百分比',
						data: [
							['已听课人数',Math.ceil(parseInt(result.studycount)/parseInt(result.userscount)*100)],
							['未听课人数',Math.ceil(100-parseInt(result.studycount)/parseInt(result.userscount)*100)]
							
						]
					}],
					
					title: {
						text: null
					},
					credits:{
						enabled:false 
					}
				});
				$('#chartcontainer2').highcharts({
					chart: {
						type: 'column'
					},
					series:[
						{
							name:'课件时长',
							data: [
								{color:'#434348',y:parseInt(result.cwtime)},parseInt(result.ltimeave),parseInt(result.ltimemine)
							]
						}
					],
					xAxis: {
						categories: [
							'课件时长',
							'同学平均听课时长',
							'我的听课时长'
			            ]
			        },
					yAxis: {
						min: 0,
						title: {
							text: '时<br>长<br>︵<br>分<br>钟<br>︶',
							rotation:0,
							margin:40,
							align:'high'
						}
					},
					plotOptions: {
						column: {
							pointWidth: 85,
							dataLabels: {
								enabled: true
							}
						}
			        },
					title: {
						text: null
					},
					credits:{
						enabled:false 
					},
					legend:{
						enabled:false 
					}
				});
				$(".times").html("我的听课次数："+parseInt(result.times)+"次");
				$(".totaltime").html("我的听课时长："+Math.ceil(parseInt(result.ltimemine))+"分钟");
				$(".ord").html("排名：第"+parseInt(result.ord)+"名");
				showanalysis();
			}
		});
	});	
});

var _xform = new xForm({
		domid:'rev',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});
//发表评论
	function comment(){
		var comm = $.trim($("#comm").val());
		var mark = $("#mark").val();
		if(comm=='' || comm=='请输入评论内容'){
			alert('发表内容不能为空。');
			$("#comm").focus();
			return false;
		}else if($.trim($('#comm').val().replace(/<[^>]*>/g,'')).length>100){
	            alert("发表内容不能大于100字。");
				$("#comm").focus();
	            return false;
	        }
		var url = "<?= geturl('myroom/review/add')?>";
		var domain = "<?=$domain?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':comm,'cwid':'<?= $course['cwid'] ?>','mark':mark,'type':'courseware'},
			dataType:'json',
			success:function(result){
				if(result.status == '1')
				{
					alert(result.msg);
					<?php
						if ($user['sex'] == 1)
	                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
	                        else
	                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
	                        $face = empty($user['face']) ? $defaulturl : $user['face'];
	                        $face = getthumb($face, '50_50');
					?>
					var face = "<?= $face ?>";
					var username = "<?= $user['username']?>";
					var realname = "<?= empty($user['realname'])?$user['username']:$user['realname']?>";
					var uid = <?= $user['uid']?>;
					var sex = <?= $user['sex']?>;
					$("#nocommentdiv").remove();
				//转成图片
					var str= $.trim(comm);
					var emo = (str.match(/\[emo(\S{1,2})\]/g));
					if(emo != null){
						$.each(emo, function(i,item){     
							var temp = emo[i].replace('[emo','');
							temp = temp.replace(']','');

							str2 = '<img src="http://static.ebanhui.com/ebh/tpl/default/images/'+temp+'.gif">';
							str = str.replace(emo[i],str2);
						 }); 
					}

					$(".appraise").prepend('<dl>'
							+'<dt><div class="userimg"><a href="http://sns.ebh.net/'+uid+'/main.html" target="_blank"><img width="40px" height="40px" src="'+face+'" /></a><a href="http://sns.ebh.net/'+uid+'/main.html" target="_blank"><b>'+realname.substring(0,4)+'</b></a><span class="'+(sex==1?'xingbie':'xingbie1')+'"></span><div style="clear:both;"></div><span class="renming1">'+username+'</span></div></dt>'
							+'<dd>'
							+'<div class="apptit"><span>'+CurentTime()+'</span>'
							+'<div class="grade">总体评分:'+(domain == 'bndx' ? getstar_txt(document.getElementById('mark').value) : getstar(document.getElementById('mark').value)) 
							+'</div></div>'
							+'<p>'+str+'</p>'
							+'</dd></dl>');
					//评论成功后初始化
					$("#mark").val("0");
					$('#comm').val("");
					$('input[name=cstar]').attr('checked',false);
					
					$(".cstar").attr("src","http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif");
					var reviewcount = $('#reviewcount').html();
					$('#reviewcount').html(parseInt(reviewcount)+1);
				}
				else
				{
					alert(result.msg);
				}
			}
		});
	}
	
	function counttime(){
		countdown --;
		if(countdown%60 == 0){
			$.ajax({
				url:'/time/gettime.html?d='+Math.random(),
				success:function(data){
					countdown = <?=$course['submitat']?> - data;
				}
			});
		}
		if(countdown <= 0)
			location.href = location.href + '?autoplay=1';
			
		$('#countdown').html(secondToStr(countdown));
	}
	var timearr = new Object();
	timearr[1] = '秒';
	timearr[60] = '分';
	timearr[3600] = '小时';
	timearr[86400] = '天';
	
	keyarr = Array();
	keyarr[1] = 86400;
	keyarr[60] = 3600;
	keyarr[3600] = 60;
	keyarr[86400] = 1;
	function secondToStr(time){
		var str = '';
		$.each(timearr,function(key,value){
			key = keyarr[key];
			value = timearr[key]; 
			if (time >= key){
				str += Math.floor(time/key) +value;
			}
			time %= key;
		});
		return str;
	}

	function submitnote(cwid) {
	    var tips = "提交笔记";
	    var message = UM.getEditor('message').getContent();
	    var url = '<?= geturl('myroom/mycourse/addnote') ?>';
	    $.ajax({
	        url:url,
	        type:'post',
	        data:{'cwid':cwid,'message':message},
	        dataType:'text',
	        success:function(data){
	        if(data=='success'){
	                $.showmessage({
	                img		 :'success',
	                message  :tips+'成功',
	                title    :tips
	              
	                });
	            }else{
	                $.showmessage({
	                img		 :'error',
	                message  :tips+'失败',
	                title    :tips
	                });
	            }
	            
	        }
	    });
	}
	$('.reviewtab,.asktab').click(function(){
		$('.workcurrent').removeClass('workcurrent');
		$(this).addClass('workcurrent');
	});
	var askloaded = false;
	var moreask = false;
	function showask(){
		$('#reviewdiv').hide();
		$('#cmdiv').hide();
		$('#analysisdiv').hide();
		$('#askdiv').show();
		getAskListAjax();
	}
	function showanalysis(){
		$('#reviewdiv').hide();
		$('#cmdiv').hide();
		$('#moreask').hide();
		$('#askdiv').hide();
		$('#analysisdiv').show();
	}
	// 每分钟获取一次问题信息问题
	function getAskListAjax(){
		var cwid = <?= $course['cwid'] ?>;
		$.ajax({
			url : '/myroom/mycourse/linkask.html',
			type : 'post',
			data : {cwid:cwid},
			success : function(data){
				result = eval('('+data+')');
				if(result['list'].length>0){
					$('#noask').hide();
					$('.tweytr table').empty();
					$("#relativeask").html(result['count']);
					$.each(result['list'],function(idx,obj){
						$('.tweytr table').append(formatasklist(obj));
					});
					if(result['count']>10){
						moreask = true;
						$('#moreask').show();
					}
				}
				setTimeout(getAskListAjax,60000);
			}
		});
	}
	setTimeout(getAskListAjax,60000);

	function showreview(){
		$('#askdiv').hide();
		$('#moreask').hide();
		$('#analysisdiv').hide();
		$('#cmdiv').show();
		$('#reviewdiv').show();
	}
	
	function formatasklist(list){
				
		var name = '';
		if(list.realname == '')
			name = list.username;
		else
			name = list.realname;
			
		var html = '<tr>';
		html+= '	<td style="border-top:none;padding: 6px 10px;">';
		html+= '	<div style="float:left;margin-right:15px;"><a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/all.html?aq='+name+'"><img title="'+name+'" src="'+list.face+'" style="width:40px; height:40px; border-radius:20px;"/></a></div>';
		html+= '	<div style="float:left;width:840px;font-family:Microsoft YaHei;">';
		html+= '		<p style="width:720px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">';
		if(list.reward>0){
		html+= '<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏'+list.reward+'积分">悬赏'+list.reward+'<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/></span>&nbsp';
		}
		html+= '		<a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/'+list.qid+'.html" style="color:#777;font-weight:bold;">';
		if(list.status == 1){
		html+= '		<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>';
		}
		html+= shortstr(list.title);
		html+= '		</a>';
		html+= '		</p>';
		html+= '	<span class="dashu">回答数<br/>'+list.answercount+'</span>';
		html+= '		<div style="float:left;width:730px;">';
		html+= '	<span style="width:180px;float:left;">'+getformatdate(list.dateline)+'</span>';
		html+= '	<span class="huirenw" style="width:150px;float:left;"><a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/all.html?aq='+name+'">'+name+'</a></span>';
		html+= '	<span class="ketek" style="width:330px"><a target="_blank" href="'+(<?php echo $roominfo['iscollege']?>==1?'/college':'/myroom')+'/myask/all.html?fid='+list.folderid+'">'+list.foldername+'</a></span>';
		html+= '	</div>';
		html+= '	</div>';
		html+= '	</td>';
		html+= '</tr>';
		return html;
	}
	function getformatdate(timestamp)
	{
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	function frontzero(str)
	{
		str = str.toString();
		str.length==1?str="0"+str:str;
		return str;
	}
	function shortstr(str){
		var result = str.substr(0,46);
		if(result.length<str.length)
			result+= '...';
		return result;
	}
    //-->
    </script>
<script src="http://static.ebanhui.com/ebh/js/reviewspage.js?version=20150420001" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
	</div>
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>

<style type="text/css">
.waigme {
	width:550px;
	height:230px;
	background-color:gray;
	border-radius:10px;
	display:none;
}

.rigsize .tishitit {
	font-size:14px;
	color:#d31124;
	font-weight:bold;
	line-height:30px;
}
.rigsize .phuilin {
	line-height:2;
	color:#6f6f6f;
}


.xkcg1s{
	width:412px;
	height:175px;
	font-family:微软雅黑;
	float:left;
}
.mycjkclb1s{
	font-size:16px;
	color:#333;
	text-align:center;
	margin-top:20px;
}
.xkcg1s .p1s{
	color:#999;
	font-size:12px;
	text-align:center;
	margin:0;
	padding-top:10px;
}
a.jxxk1s {
    background: #5e8cf1;
    border: 1px solid #5e8cf1;
    border-radius: 3px;
    color: #fff;
    display: block;
	margin:0 auto;
    font-size: 14px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    width: 110px;
	text-decoration:none;
}
.xuanbtn2s{
	margin-top:20px;
}
</style>

<script type="text/javascript">
function openonline() {
	// if($("#agreement").is(':checked') !=true) {
		// alert("请先阅读并同意《e板会用户支付协议》。");
		// return;
	// }
	var url = "<?= empty($checkurl) ? 'http://'.$roominfo['domain'].'.ebanhui.com/classactive.html' : $checkurl ?>";
	document.location.href = url;
}
function closeWindows() {
         var browserName = navigator.appName;
         var browserVer = parseInt(navigator.appVersion);
         if(browserName == "Microsoft Internet Explorer"){
             var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;  
             if (ie7)
             {  
               window.open('','_parent','');
               window.close();
             }
            else
             {
               this.focus();
               self.opener = this;
               self.close();
             }
        }else{  
            try{
                this.focus();
                self.opener = this;
                self.close();
            }
            catch(e){

            }

            try{
                window.open('','_self','');
                window.close();
            }
            catch(e){

            }
        }
    }
</script>

<?php } ?>