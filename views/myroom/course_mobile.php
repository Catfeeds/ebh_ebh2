<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js?v=11"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>

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
	}
	div.aui_inner{
		background: #fff;
	}
	.lefrig{
		background: #fff;
	}
	.onlinework{display: block;width: 118px;float: left;margin-left: 12px; text-align: center; background: url('http://static.ebanhui.com/ebh/tpl/default/images/intit.jpg') no-repeat; background-position: -142px 0px;}
	.active{background-position: -11px 0px;}
	#examworkList table.datatab tbody{text-align: center;}
</style>
<script type="text/javascript">
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
					showDivModel(".nelame");
					$(".nelame").css("top","300px");
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
					?>
					playmu('<?= $course['m3u8url'] ?>',cwid,'',isfree,num,'562','978',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,<?=$autoplay?>,<?=$mode?>,<?=$seek?>);
					<?php 
						} else if(!empty($course['rtmpurl'])) {
					?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','978',1,'<?= $course['thumb'] ?>');
					<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','978',1);
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
					playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','978',1,'',<?= $mode ?>,<?= $seek ?>);
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
</script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
</head>
<body>
<?php
    if($type == 'flv'){
        if(!empty($course['m3u8url'])) {
            $purl = $course['m3u8url'];
        } else if(!empty($course['rtmpurl'])) {
            $purl = $course['rtmpurl'];
        } else {
            $purl = $course['cwsource'].'attach.html?cwid='.$course['cwid'];
        } 
    }else{
         $purl = $course['cwsource'].'attach.html?cwid='.$course['cwid'].'&.mp3';
    }
?>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->

<div class="cright" style="float:none;display: block;margin: 0 auto;width:980px;margin-bottom:20px;">
<div style="width:980px;margin:0 auto;">
<div class="cright" style="display: block;margin: 0 auto;width:980px;margin-bottom:20px;">

		<?php $domain=$this->uri->uri_domain();
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
			<div class="ter_tit">
			当前位置 > 所有课程 > <?= $course['foldername'] ?> > <?= $course['title']?>
			</div>
		<?php } ?>
<div class="lefrig" style="margin-top:5px;float:none;background:#FFF;">
			<div class="classbox" style="width:978px;background: #FFF;border:solid 1px #cdcdcd;min-height:100px;">
				<h1 style="font-weight: bold; color:#666;text-align: center;"><?= $course['title']?></h1>
				<div class="classboxmore" style="width:928px;">
				<?php
						$viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);
						$dateline = empty($course['submitat'])?$course['dateline']:$course['submitat'];
						?>
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$dateline)?></span><span>人气：<?= $viewnum?></span>					
					<?php if(!empty($course['rtmpurl'])) { ?>

					<span style="float:right;">如您无法正常播放，也可以 <a href="<?= geturl('myroom/mycourse/'.$course['cwid']).'?$type=1' ?>" style="color:blue">点击这里</a></span>
					<?php } ?>
					</p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;float:left;margin-left:-10px;">
					<?php if($type == 'ebh' || $type == 'ebhp') {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE ) { ?>
							<?php if($course['isfree']==1){ ?>
							<input class="huangbtn marrig" value="开始听课" type="button"  onclick="freeplay('<?= $course['cwsource']?>','<?= $course['cwid']?>','<?php str_replace("'"," ",$course['title'])?>',1,0,showdialogs)"/>
							<?php }else{ ?>
							<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
							<?php } ?>
						<?php } ?>
					
					<?php } elseif (!empty($course['cwurl']) && $type != 'flv' && $type != 'mp3') { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下载文件</a>
					<?php } ?>
					</p>
					<?php if(empty($course['cwurl'])){ ?>
						<div style="*margin-bottom:10px;">
							<a class="lanbtn" href="javascript:void(0)" id="favorite" style=" height:30px; margin-top:10px;margin-bottom:10px;"></a>
							<a id="notebtn" class="lanbtn" name="notes" href="javascript:void(0)" style="margin-left:10px;height:30px; margin-top:10px;margin-bottom:10px;">录入笔记</a>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php if(($type != 'flv' && $type != 'mp3')){ ?>
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
					<a href="javascript:;" id="cancel" style="margin-right:80px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;">取消</a>
					<a href="javascript:;" onclick="submitnote(<?= $course['cwid']?>);" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;">提交</a>
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
			<?php if($type == 'flv' || $type == 'mp3') { ?>
				<?php if($type == 'mp3') {?>
				<div style="color:red;position: relative;height:400px;z-index:601;float:left;margin-left:1px;margin-top:5px;">
				<?php } else {?>
				<div style="color:red;position: relative;height:560px;z-index:601;float:left;margin-left:1px;margin-top:5px;">
				<?php } ?>
				<?php if(SYSTIME>=$course['submitat'] && (empty($course['endat']) || SYSTIME<=$course['endat'])){?>
				<div id="flvcontrol2" style="width:980px;height:560px;">
					 <video id="_video" src="<?=$purl?>" poster="<?=$course['thumb']?>" width="980px" height="560px"  controls="controls">
                        您的浏览器不支持播放该视频！
                    </video>
				</div>
				<?php }elseif(empty($course['endat']) || SYSTIME<=$course['endat']){?>
				<div style="width:977px;height:560px;background:white;border:1px solid #DDDDDD;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</span>
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">倒计时：<span id="countdown"><?=secondToStr($course['submitat']-SYSTIME)?></span></span> 
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">请耐心等候...</span>
				</div>
				<?php }else{?>
				<div style="width:977px;height:560px;background:white;border:1px solid #DDDDDD;text-align:center">
				<span style="font-size:50px;width:970px;float:left;margin-top:50px">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
				
				</div>
				<?php }?>
				</div>


				<div id='atsrc' style="display: none;"></div>
			<div class="flaoter" style="margin-top:8px;"> 
			<div class="ieyin" style="_display:block;"><br/><br/></div>
				<?php if((empty($hasnobtn) || $hasnobtn != TRUE) && $user['groupid'] == 6 && $domain != 'www') { ?>
					<a href="javascript:;" class="<?= empty($myfavorite)?'shoutie':'yishout'?>" id="favorite" ></a>
				<?php } ?>
					

			<div class="tksile">
				<a href="javascript:showfeedback();" class="tingfan">听课反馈</a>
				<?php if(($roominfo['isschool']!=2) && ($type == 'flv' || $type == 'mp3' )&& $domain!='www'){ ?>
					<a id="notebtn" href="javascript:;" class="lubij" name="notes">录入笔记</a>
					<a href="javascript:;" onclick="document.getElementById('flvcontrol').callflashvideo()"  class="tixuetime">提交学习时间</a>
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
					<a href="javascript:;" id="cancel" style="margin-right:80px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;">取消</a>
					<a href="javascript:;" onclick="submitnote(<?= $course['cwid']?>);" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;">提交</a>
				  </div>
			</div>
			<?php } ?>
			
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:20px;width:978px;">
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
			  	<div class="incont" style="width:928px;">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>
			<?php if(($domain!='www')) { ?>
			<div id="examworkList" class="introduce" style="width:978px;">
					<div class="intitle">
					<h2><a class="onlinework active" id="rid" onclick="parse_Joblist()">在线作业</a></h2>
				</div>
				<div class="incont" style="width:980px;">
						<table width="978px;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th>&nbsp;作业名称</th>
									<th  style="text-align: center;">出题时间</th>
									<th style="text-align:center;">总分</th>
									<th style="text-align: right;">操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							 	</tr>
							  </thead>
								<tbody>

								
								
							  </tbody>
						</table>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($survey) && ($domain!='www')) { ?>
			<div class="introduce" style="width:978px;">
					<div class="intitle">
					<h2>调查问卷</h2>
				</div>
				<div class="incont" style="width:980px;">
						<table width="978px;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th>&nbsp;问卷名称</th>
									<th>发布时间</th>
									<th style="text-align: right;">操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							 	</tr>
							  </thead>
								<tbody>
								  <tr>
									<td width="65%" style="font-weight:bolder;color:#666;padding:3px 6px;">&nbsp;<?=strip_tags($survey['title']) ?></td>
									<td><?= date('Y-m-d H:i:s',$survey['dateline'])?></td>
									<td>
											<?php if($survey['allowview']){?>
												<a class="previewBtn" style="float:right;" href="/college/survey/stat/<?= $survey['sid'] ?>.html" target="_blank">统&nbsp;&nbsp;计</a>
											<?php }?>
											<?php if($survey['answered']){?>
												<a class="previewBtn" style="float:right;" href="/college/survey/answer/<?= $survey['sid'] ?>.html" target="_blank"><span>查看详情</span></a>
											<?php }else{?>
												<a class="previewBtn" style="float:right;" href="/college/survey/fill/<?= $survey['sid'] ?>.html" target="_blank">参与调查</a>
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
				<div class="introduce" style="width:978px;">
					<div class="intitle">
						<h2>附件下载</h2>
					</div>
							
					<div class="incont" style="width:980px;">
							<table width="978px;" class="datatab" style="border:none;">
								<thead class="tabhead">
									<tr>
										<th>附件名称</th>
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
											<td width="65%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
										<?php } else { ?>
											<td width="65%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
										<?php } ?>
									<?php } ?>
										<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
										<td><?= getsize($atta['size'])?></td>
										<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<td>
											<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载附件" type="button" />
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
	<div class="introduce" style="float:left;width:978px;">
		<div class="work_mes" style="width:977px;margin-bottom:10px">
			<ul>
				<li class="workcurrent reviewtab" onclick="showreview()"><a href="javascript:void(0)"><span><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?> (<font color="red" id="reviewcount"><?=$reviewcount?></font>)</span></a></li>
				<li class="asktab" onclick="showask()"><a href="javascript:void(0)"><span>相关问题 (<font color="red" id="relativeask"><?=$askcount?></font>)</span></a></li>
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
					<dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
					<dd>
					<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b style="font-weight: bold;"><?= empty($review['realname'])?$review['username']:$review['realname']?></b></div>
					<div class="grade">总体评分: 
					<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
					<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
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
					<div id="nocommentdiv" style="width:100%;height:50px;">暂无任何评论</div>
				</dl>
			<?php } ?>
				<div id="commentlastdiv" class="clear"></div>	
				 
			</div>
		<?= $pagestr ?>
		</div>
		<div id="askdiv" style="float:left;width:970px;display:none;padding-bottom:30px">
			<div style="text-align:center;" id="noask">
			<span style="font-size:14px;line-height:30px;width:978px;height:30px;float:left" >
			暂无问题
			</span>
			<input class="tijibtn" type="button" value="马上提问" onclick="showAskDialog()">
			
			</div>
			<div class="tweytr" style="margin-left:10px">
				
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
					<p class="pl">满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
					<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
					</em></p>
					<div style="background:#f9f9f9;width:40px;height:89px;position: absolute;top:33px;left:21px;"><a style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/smeil.png) no-repeat;display:block;margin:30px 0 0 8px;height:24px;line-height:24px;overflow: hidden;width:24px;" href="javascript:;" id="showface" ></a></div>
					<p>
					<textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext"></textarea>
			</div>

					</p>
					<p class="plogin" style="width:946px;margin-left:20px;float:left;">
					<span style="float:left;">(1-100字)</span> 
					<span>
					<a href="javascript:;" onclick="comment();" id="submit" style="margin-right:100px;background:#18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px;" name="review">评论</a>
					</span>
					</p>
			</div>
			<?php } ?>
		  </div>
			</div>
		<?php }else { ?>
		<?php if($roominfo['isschool']!= 3){ ?>
		<div class="introduce" style="float:left;width:980px;">
					<div class="intitle"><h2><a id="rid"><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?></a></h2></div>
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
								<dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
								<dd>
								<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b style="font-weight: bold;"><?= empty($review['realname'])?$review['username']:$review['realname']?></b></div>
								<div class="grade">总体评分:  
								<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
								<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
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
								<div id="nocommentdiv" style="width:100%;height:50px;">暂无任何评论</div>
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
						<p><textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext"></textarea></p>
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
<?php $this->display('myroom/page_footer'); ?>
<script defer="defer" type="text/javascript">

	parse_Joblist();
	function parse_Joblist(bol){  //在线作业
		var exampower = "<?=$examPower?>";
		if(exampower ==0){
			url = '/college/mycourse/getCwidExamsAjax.html';
		}else if(exampower ==1){
			url = '/college/examv2/getCwidExamsAjax.html';
		};
		$.ajax({
			url:url,
			type:'post',
			data:{
				'cwid': <?= $course['cwid'] ?>
			},
			dataType:'json',
			success:function(result){
				var list = '';
				if(exampower ==0){
					if(result.length > 0){
						for(var i=0;i<result.length;i++){
							var isapple = '<?=$isapple?>';
							if(isapple != '0'){
								$dourl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid=<?=$roominfo['crid']?>&k=<?=urlencode($key)?>&eid='+ result[i].eid;
								$viewurl = 'http://www.ebanhui.com/sitecp.html?action=ctlogin&type=ebhexam&from=ebh&flag=1&rid=<?=$roominfo['crid']?>&k=<?=urlencode($key)?>&eid='+ result[i].eid;
							}else{
								$dourl = 'http://exam.ebanhui.com/edo/'+result[i].eid+'.html';
								$viewurl = 'http://exam.ebanhui.com/emark/'+result[i].eid+'.html';
							}
							list += '<tr>';
							list += '<td width="65%" style="font-weight:bolder;color:#666;padding:3px 6px;">&nbsp;'+ result[i].title+'</td>';
							list += '<td >'+new Date(parseInt(result[i].dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>';
							list += '<td style="text-align:center;">'+ result[i].score+'</td>';
							list += '<td>';
							if(result[i].status == null){
							list += '<a class="previewBtn"  style="float:right;" href="'+$dourl+'" target="_blank"><span>在线答题</span></a>';
							}else if(result[i].status == 1){
							list += '<a class="lviewbtn"  style="float:right;" href="'+ $viewurl+'" target="_blank">查看结果</a>';
							}else{
							list += '<a class="previewBtn"  style="float:right;" href="'+ $dourl+'" target="_blank">继续答题</a>';
							}
							list += '</td>';
							list += '</tr>';
						}
						$('#examworkList table.datatab tbody').empty().append(list);
					}else{
						$('#examworkList').remove();
					};
				}else if(exampower ==1){
					var examList = result.datas.examList;
					if(examList){
						
						for(var i=0;i<examList.length;i++){
							list += '<tr>';
							list += '<td width="65%" style=""><p class="bzzytitle">&nbsp;'+ examList[i].exam.esubject+'</p></td>';
							list += '<td >'+new Date(parseInt(examList[i].exam.dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>';
							list += '<td  style="text-align:center;">'+ examList[i].exam.examtotalscore+'</td>';
							list += '<td>';
							if(examList[i].userAnswer.status == null){
							list += '<a class="previewBtn" style="float:right;" href="/college/examv2/doexam/'+examList[i].exam.eid+'.html" target="_blank"><span>做作业</span></a>';
							}else if(examList[i].userAnswer.status == 1){
							list += '<a class="lviewbtn" style="float:right;" href="/college/examv2/doneexam/'+examList[i].exam.eid+'.html" target="_blank">查看结果</a>';
							}else{
							list += '<a class="previewBtn" style="float:right;" href="/college/examv2/doexam/'+examList[i].exam.eid+'.html" target="_blank">继续做作业</a>';
							}
							list += '</td>';
							list += '</tr>';
						}
						$('#examworkList table.datatab tbody').empty().append(list);
					}else{
						$('#examworkList').remove();
					}
			}
			}
		});	
		Date.prototype.format = function(format) 
			{ 
				var o = 
				{ 
				"M+" : this.getMonth()+1, //month 
				"d+" : this.getDate(), //day 
				"h+" : this.getHours(), //hour 
				"m+" : this.getMinutes(), //minute 
				"s+" : this.getSeconds(), //second 
				"q+" : Math.floor((this.getMonth()+3)/3), //quarter 
				"S" : this.getMilliseconds() //millisecond 
				}
				
				if(/(y+)/.test(format)){ 
					format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
				}
				
				for(var k in o){ 
					if(new RegExp("("+ k +")").test(format)){ 
						format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length)); 
					} 
				} 
				return format; 
			} 
	}
//发表评论
	function comment(){
		var comm = $.trim($("#comm").val());
		var mark = $("#mark").val();
		if(comm==''){
			alert('发表内容不能为空。');
			$("#comm").focus();
			return false;
		}else if($.trim($('#comm').val().replace(/<[^>]*>/g,'')).length>100){
	            alert("发表内容不能大于100字。");
				$("#comm").focus();
	            return false;
	        }
		var url = "<?= geturl('myroom/review/add')?>";
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
					var username = "<?= empty($user['realname'])?$user['username']:$user['realname']?>";
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
							+"<dt><div class=\"userimg\"><img width=\"50px\" height=\"50px\" src="+face+" /></div></dt>"
							+'<dd>'
							+"<div class=\"apptit\"><span>"+CurentTime()+"</span><b>"+username+"</b></div>"
							+'<div class="grade">总体评分:'+getstar(document.getElementById('mark').value) 
							+'</div>'
							+'<p>'+str+'</p>'
							+'</dd></dl>');
					$("#comm").val("");
					$("#mark").val("0");
					$(".cstar").attr("src","http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif");
					var reviewcount = $('#reviewcount')[0].innerText;
					$('#reviewcount')[0].innerText = parseInt(reviewcount)+1;
					
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
		$('#askdiv').show();
		getAskListAjax();
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
					$('.tweytr').empty();
					$("#relativeask").html(result['count']);
					$.each(result['list'],function(idx,obj){
						$('.tweytr').append(formatasklist(obj));
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
		html+= '	<div style="float:left;margin-right:15px;"><a target="_blank" href="/myroom/myask/all.html?aq='+name+'"><img title="'+name+'" src="'+list.face+'" /></a></div>';
		html+= '	<div style="float:left;width:840px;font-family:Microsoft YaHei;">';
		html+= '		<p style="width:720px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">';
		html+= '		<a target="_blank" href="/myroom/myask/'+list.qid+'.html" style="color:#777;font-weight:bold;">';
		if(list.status == 1){
		html+= '		<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>';
		}
		html+= shortstr(list.title);
		html+= '		</a>';
		html+= '		</p>';
		html+= '	<span class="dashu">回答数<br/>'+list.answercount+'</span>';
		html+= '		<div style="float:left;width:730px;">';
		html+= '	<span style="width:180px;float:left;">'+getformatdate(list.dateline)+'</span>';
		html+= '	<span class="huirenw" style="width:150px;float:left;"><a target="_blank" href="/myroom/myask/all.html?aq='+name+'">'+name+'</a></span>';
		html+= '	<span class="ketek" style="width:330px"><a target="_blank" href="/myroom/myask/all.html?fid='+list.folderid+'">'+list.foldername+'</a></span>';
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
.nelame {
	width:530px;
	height:306px;
	margin:10px;
	float:left;
	display:inline;
	border: 8px solid rgba(255, 255, 255, 0.2);
	border-radius: 8px;
	box-shadow: 0 0 20px #333333;
	opacity: 1;
}
.nelame .leficos {
	width:125px;
	height:265px;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0104.jpg) no-repeat 30px 32px;
}
.nelame .rigsize {
	width:375px;
	float:left;
	margin-top:25px;
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
.nelame a.kaitongbtn {
	display:block;
	width:147px;
	height:50px;
	line-height:50px;
	background-color:#ff9c00;
	color:#fff;
	text-decoration:none;
	text-align:center;
	font-size:20px;
	float:left;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-top:20px;
	border-radius:5px;
}
.nelame a.guanbibtn {
	float:left;
	color:#939393;
	font-size:14px;
	margin:40px 0 0 12px;
}
</style>

<script type="text/javascript">
function openonline() {
	if($("#agreement").is(':checked') !=true) {
		alert("请先阅读并同意《e板会用户支付协议》。");
		return;
	}
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
<div class="nelame" style="display:none;">
	<div style="width:530px;height:300px;background:#fff;">
		<div class="leficos">
		</div>
		<div class="rigsize">
		<h2 class="tishitit">对不起，您还未开通 <?= empty($payitem) ? '学习和作业功能' : $payitem['iname'] ?> 或服务已到期。</h2>
		<p style="font-weight:bold;">开通后您可以在学习课程和我的作业里进行在线学习和作业。</p>
		<p class="phuilin">在云教学网校，您可以随时随地在线学习、预习新课，复习旧知、记录和向老师提交笔记、在线做作业、在错题集里巩固错题、在线答疑、查看学习表、与老师，同学互动交流等。</p>
			<div class="czxy" style="padding-left:0px;padding-top:10px;">
				<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked" />
				<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="<?= geturl('agreement/payment') ?>" target="_blank" style="color:#00AEE7;">e板会用户支付协议</a>》
				</label>
			 </div>
		</div>

		<a href="javascript:openonline();" class="kaitongbtn">在线开通</a>
		<a href="<?= geturl('myroom') ?>" class="guanbibtn">返回首页</a>
	</div>
</div>
<?php } ?>
<script>
	function showAskDialog(){
		if($("#askdialog").length == 0){
			$('body').append('<iframe id="askdialog" style="display:none;overflow:hidden;" width=795 height=720 src="" frameborder="0"></iframe>');
		}
		var url = "/myroom/myask/addquestion.html?forcoursedialog=1&folderid=<?= $course['folderid'] ?>&cwid=<?=$course['cwid']?>&tid=<?=$course['uid']?>&v="+Math.random();
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

  	//记录学习时间
var study_data = {
	'end':0,
	'start':0,
	'total':0,
	'logid':0,
	'timer':{}
};
var hastryget = 0;
var video = $('#_video');
$(function(){
	video.on('pause', function() {
		clearInterval(study_data.timer);
		study_data.end = new Date().getTime();
		study_data.total += study_data.end-study_data.start;
		xmessfun("<?=$course['cwid']?>",video[0].duration,(Math.ceil(study_data.total/1000)),study_data.logid);
	});
	video.on('playing',function(){
			study_data.start = new Date().getTime();
			study_data.timer = setInterval(function(){
			study_data.end = new Date().getTime();
			study_data.total += study_data.end-study_data.start;
			study_data.start = study_data.end;
			xmessfun("<?=$course['cwid']?>",video[0].duration,(Math.ceil(study_data.total/1000)),study_data.logid);
		},60000);
	});
});

function xmessfun(id,ctime,ltime,lid){
	if( ctime <= ltime ){
		study_data.logid = messfun(ctime,ltime,0,lid);
	}else{
		study_data.logid = messfun(ctime,ltime,1,lid);
	}
}
</script>