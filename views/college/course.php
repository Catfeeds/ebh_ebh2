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
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<style>
	.workcurrent a span {background:none;padding:0;}
.workcurrent a {padding:0;background:url(http://static.ebanhui.com/ebh/tpl/default/images/intit_02.jpg) no-repeat;width:118px;height:33px;line-height:33px;text-align:center;}
.work_mes ul li{font-size:14px;}
.classbox h1.rygers {font-weight: bold; color:#666;margin-top:10px;height:20px;line-height:20px;}
.classboxmore p {line-height:20px;}
.classboxmore {padding:0;width:860px;border:none;}
.lefrig input.lanbtn{background:url("http://static.ebanhui.com/ebh/tpl/2014/images/shoucangico.jpg") no-repeat left center;color: #626262;font-family: "微软雅黑";font-size: 14px;padding-left: 20px;width:65px;}
.lefrig input.lanbtn:hover{background:url("http://static.ebanhui.com/ebh/tpl/2014/images/shoucangico.jpg") no-repeat left center;}
.classbox h1{ height:24px; line-height:32px;}
.introduce{ border:none;}
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
		$(function(){
		<?php if(empty($myfavorite)) { ?>
			$("#favorite").val("收藏");
			$("#favorite").unbind().click(function(){
				$("#favorite").removeAttr('onclick');
					addfavorite('<?= $course['cwid'] ?>','<?= str_replace('\'','',$course['title']) ?>',location.href);
			});
		<?php } else { ?>
			$("#favorite").val("已收藏");
		<?php } ?>
		});

		<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
			$(function(){
				if(window != undefined) {
					showDivModel(".nelame");
				//	$(".nelame").css("left","100px");
				//	$(".nelame").css("top","100px");
				}
			});
		<?php }else{ ?>
			//flv播放
			$(function (){
				var cwid = <?= $course['cwid'] ?>;
				var isfree = <?= isset($isfree) ? $isfree : $course['isfree'] ?>;
				var num = 1;
				var cwname = '<?= $course['cwname'] ?>';
				var suffix = cwname.split('.');
				var lastsuffix = suffix[suffix.length-1];
				<?php if(!empty($type)){?>
				lastsuffix = '<?= $type ?>';
				<?php } ?>
				if(lastsuffix == 'flv'){
					//flv
					<?php 
						if(!empty($course['m3u8url'])) {
						$autoplay = $this->input->get('autoplay');
						$autoplay = !empty($autoplay)?$autoplay:0;
					?>
					playmu('<?= $course['m3u8url'] ?>',cwid,'',isfree,num,'562','980',0,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,<?=$autoplay?>);
					<?php 
						} else if(!empty($course['rtmpurl'])) {
					?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','980',0,'<?= $course['thumb'] ?>');
					<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','980',0);
					<?php } ?> 
				} else if(lastsuffix == 'mp3'){
					playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','980',0);
				}
			});
		<?php } ?>
		//听课完成回调
		function messfun(ctime,ltime,finished,plid){
			var cwid = <?= $course['cwid'] ?>;
			var res = studyfinish(cwid,ctime,ltime,finished,plid);
			if(finished==1){
				showHomeWork();
			}
			return res;
		}
		$(function(){
			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/course/getajaxpage.html";
			page_load(page,url);
		})
		</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>

</head>
<body>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<div style="width:960px;margin:0 auto;">
<div class="cright" style="display: block;margin: 0 auto;width:980px;margin-bottom:20px;">
		<?php $domain=$this->uri->uri_domain();
		 $roominfo = Ebh::app()->room->getcurroom();
		$cloudurl='http://'.$domain.'.ebh.net';?>
		<?php if(empty($roominfo['crid'])){ ?>
			<div class="ter_tit">
				>
				<a href="<?= $cloudurl?>" title="<?= $coursedetail['crname']?>"><?= $coursedetail['crname']?></a>
				>
				<?= $coursedetail['foldername']?>
				> <?= $coursedetail['title']?>
			</div>
		<?php }else{ ?>
			<div class="ter_tit" style=" border:none; border-bottom:1px solid #f1f1f1;">
			当前位置 > 所有课程 > <?= $course['foldername'] ?> > <?= $course['title']?>
			</div>
		<?php } ?>
<div class="lefrig">
			<div class="classbox" style="width:980px;background: #FFF;min-height:75px;border:none;">
				<div style="float:left;margin:10px 15px 0 18px;">
				<?php 					
					if($course['sex'] == 1) {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					} else {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}
					$face = empty($course['face']) ? $defaulturl : $course['face'];
					$face = getthumb($face,'50_50');
			?>
<img src="<?=$face?>" style="width:50px;height:50px;">
</div>
				<h1 style="font-weight: bold;color:#666;"><?= $course['title']?></h1>
				<div class="classboxmore">
						
					<div style="width:595px; float:left;display:inline;">
						<p><?= empty($course['realname'])?$course['username']:$course['realname'] ?><span><?= date('Y.m.d',$course['dateline'])?>发布</span><span>人气：<?= $course['viewnum']?></span></p>
						<p><?= $course['summary'] ?></p>
					</div>
					<div style="width:265px; float:left;display:inline;"><p style="padding:5px 0 10px;float:left;">
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

					<?php if((empty($hasnobtn) || $hasnobtn != TRUE) && $user['groupid'] == 6 && !empty($roominfo['crid'])) { ?>
					<!--<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返回" type="button" />-->
					<input type="button" class="lanbtn" value="收藏" id="favorite" />
					<?php } ?>
					
					<!-- Baidu Button BEGIN -->
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="float:left;margin-top:10px;width:190px;">
					<span class="bds_more">分享到：</span>
					<a class="bds_tsina"></a>
					<a class="bds_qzone"></a>
					<a class="bds_tqq"></a>
					<a class="shareCount"></a>
					</div>
					<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6704542" ></script>
					<script type="text/javascript" id="bdshell_js"></script>
					<script type="text/javascript">
					document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
					</script>
					<!-- Baidu Button END -->
					<?php if(preg_match('/.*(\.flv)$/',$course['cwurl']) || $user['groupid'] == 6){ ?>
						<?php if(!empty($course['rtmpurl'])) { ?>
						<div style="float:right;">
						<span style="float:left;margin:16px 10px 0 20px;">如您无法正常播放，也可以 <a href="<?= geturl('course/'.$course['cwid']).'?type=1' ?>" style="color:blue">点击这里</a></span>
						
						</div>
						<?php } ?>
					<?php } ?>
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<a href="<?= geturl('courseebhp/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank" style="float:right;margin-right:50px;margin-top:10px;">网页播放</a>
					<?php } ?>
					</p>
					</div>
				</div>
			</div>
			<?php if($type == 'flv') { ?>
				<div style=" position: relative;height:560px;z-index:1;float:left;">
				<div id="flvcontrol" style="width:980px;height:562px;"></div>
				</div>
			<?php } ?>
			
			<?php if($type == 'mp3') { ?>
				<div id="flvcontrol" style="width:980px;height:400px;"></div>
			<?php } ?>

				<div id='atsrc' style="display: none;"></div>
			<div style="float:left;width:958px;margin-bottom: 5px;"> 
			<div class="ieyin" style="_display:block;"></div>
				
			</div>
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:0px;width:980px;">
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
			  	<div class="incont" style="width:928px;">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>

			<?php if(!empty($examlist) && $roominfo['isschool'] == 2 && (!empty($roominfo['crid']))) { ?>
			<div class="work_menuss" style="width:978px;float:left;">
					<div class="intitle">
					<h2>在线测评</h2>
				</div>
			</div>
				<div class="incont" style="width:978px;">
						<table width="100%;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th>作业名称</th>
									<th>出题时间</th>
									<th>总分</th>
									<th>操作</th>
							 	</tr>
							  </thead>
								<tbody>

											
								 <?php foreach($examlist as $exam) { ?>
								  <tr>
									<td width="60%"><?= $exam['title'] ?></td>
									<td width="20%"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
									<td width="5%"><?= $exam['score'] ?></td>
									<td width="15%">
											<a class="previewBtn" href="http://exam.ebanhui.com/freedo/<?= $exam['eid'] ?>.html" target="_blank"><span>答题</span></a>
									</td>
								  </tr>
								  <?php } ?>
								
							  </tbody>
						</table>
					
				</div>
			<?php } ?>

			<a name="fujian" href="javascript:void(0);"></a>

				<?php if ((!empty($roominfo['crid'])) && (!empty($attachments))) { ?>
				<div class="introduce" style="width:980px;">
					<div class="intitle" >
						<h2>附件下载</h2>
					</div>
							
					<div class="incont" style="width:978px;">
							<table width="100%;" class="datatab" style="border:none;">
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
											<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
										<?php } else { ?>
											<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
										<?php } ?>
									<?php } ?>
										<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
										<td></td>
										<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<td>
											<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载" type="button" />
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
				<div class="introduce" style="width:980px;">
					<div class="intitle" style="width:978px;"><h2><a id="rid">课件评论</a></h2></div>
					  <div class="appraise">
							
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
								<dd style="width:871px;">
								<div class="apptit" style="width:850px;"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></div>
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
								<div id="nocommentdiv" style="width:100%;height:50px;margin-left:20px;">暂无任何评论</div>
							</dl>
						<?php } ?>
							<div id="commentlastdiv" class="clear"></div>	
							 
					  </div>
				   <?= $pagestr ?>

	<div style="height:400px;float:left;position: relative;">
				  
			<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:248px;height:163px;">

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

				   <?php if(!empty($user)){ ?>
				   <?php if(!empty($roominfo['crid'])){ ?>
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
					<textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext"  x_hit="请输入评论内容"></textarea>
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
					<?php } ?>
				  </div>
	</div>
			</div>
		<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>	
				<div class="introduce">
					<div class="intitle" style="width:980px;"><h2><a id="rid">课件评论</a></h2></div>
					  <div class="appraise">
							
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
								<dd style="width:815px;">
								<div class="apptit" style="width:850px;"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></div>
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
								<div id="nocommentdiv" style="width:100%;height:50px;margin-left:20px;">暂无任何评论</div>
							</dl>
						<?php } ?>
							<div id="commentlastdiv" class="clear"></div>	
							 
					  </div>
				   <?= $pagestr ?>


			<div style="height:400px;float:left;position: relative;">
				  
			<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:248px;height:163px;">
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

				   <?php if(!empty($user)){ ?>
				   <?php if(!empty($roominfo['crid'])){ ?>
					    <div class="fill">
							<p class="pl">我来评论  　　满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<p><textarea id="comm" name="comm" cols="" style="resize:none;height:150px;" rows="" class="pltext" x_hit="请输入评论内容"></textarea></p>
							<p class="plogin" style="width:470px;">
							<span><input name="review" class="plBtn" value="评论" type="button" onclick="comment()" /></span>
							(1-100字) </p>
					  </div>
					<?php } ?>
					<?php } ?>
	</div>

				  </div>

			</div>
			<?php } ?>
		<?php } ?>

<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
	<?php $this->display('common/player'); ?>
<?php }else{ ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001"></script>
<?php } ?>
<?php $this->display('myroom/page_footer'); ?>
<script defer="defer" type="text/javascript">

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
	<?php if($user['groupid']==6){ ?>
	var url = "<?= geturl('myroom/review/add')?>";
	<?php }else{ ?>
	var url = "<?= geturl('troom/review/add')?>";
	<?php } ?>
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
						+'<dd style="width:815px;">'
						+"<div class=\"apptit\" style=\"width:790px;\"><span>"+CurentTime()+"</span><b>"+username+"</b></div>"
						+'<div class="grade">总体评分:'+getstar(document.getElementById('mark').value) 
						+'</div>'
						+'<p>'+str+'</p>'
						+'</dd></dl>');
				$("#comm").val("");
				$("#mark").val("0");
				$(".cstar").attr("src","http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif");
				//top.resetmain();
				// window.location.reload();
			}
			else
			{
				alert(result.msg);
			}
		}
	});
}

    //-->
    </script>
<script src="http://static.ebanhui.com/ebh/js/reviewspage.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
</div>
</div>
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>

	<style type="text/css">
.waigme {
	width:550px;
	height:290px;
	background-color:gray;
	border-radius:10px;
	display:none;
}
.nelame {
	width:530px;
	height:270px;
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
	var url = "<?= empty($checkurl) ? 'http://'.$roominfo['domain'].'.ebh.net/classactive.html' : $checkurl ?>";
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
	<div style="width:530px;height:270px;background:#fff;">
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