<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<style type="text/css">
.tisku {
	height: 185px;
	width: 385px;
}
.tisku p {
	float: left;
	width: 230px;
	margin-left: 25px;
	_margin-left: 12px;
	font-size: 14px;
	color: #666;
	font-weight: bold;
	line-height: 1.8;
}
.top50 {
	margin-top:50px;
}
.tisku img {
	float:right;
	margin-right:20px;
	margin-top:20px;
}

</style>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
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

			//flv播放
			$(function (){
				var cwid = <?= $course['cwid'] ?>;
				var isfree = <?= isset($isfree) ? $isfree : $course['isfree'] ?>;;
				var num = 1;//教室内
				var cwname = '<?= $course['cwname'] ?>';
				var suffix = cwname.split('.');
				var lastsuffix = suffix[suffix.length-1];
				if (lastsuffix == 'ebh' || lastsuffix == 'ebhp'){
					//ebh
					freeebh('<?= $course['cwsource'] ?>',cwid,isfree,cwname,isfree);
				}
			});

		//听课完成回调
		function messfun(ctime,ltime){
			var cwid = <?= $course['cwid'] ?>;
			return studyfinish(cwid,ctime,ltime);
		}
		$(function(){
			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/courseebhp/getajaxpage.html";
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
<div class="cright" style="float:none;display: block;margin: 0 auto;width:980px;margin-bottom:20px;">
		<?php $domain=$this->uri->uri_domain();
		$cloudurl='http://'.$domain.'.ebh.net';?>
		<?php if($domain == 'www'){ ?>
			<div class="ter_tit">
				>
				<a href="<?= $cloudurl?>" title="<?= $coursedetail['crname']?>"><?= $coursedetail['crname']?></a>
				>
				<?= $coursedetail['foldername']?>
				> <?= $coursedetail['title']?>
			</div>
		<?php }else{ ?>
			<div class="ter_tit">
			当前位置 > 所有课程 > <?= $course['foldername'] ?> > <?= $course['title']?>
			</div>
		<?php } ?>
<div class="lefrig" style="margin-top:5px;float:left;">
			<div class="classbox" style="width:980px;background:#FFF">
				<h1 style="font-weight: bold;color:#666;"><?= $course['title']?></h1>
				<div class="classboxmore" style="width:950px;">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $course['viewnum']?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;">
					<?php if(!empty($course['cwurl']) && !preg_match('/.*(\.ebh|\.ebhp|\.flv)$/',$course['cwurl'])) {?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下载文件</a>
					<?php } ?>
					<?php if((empty($hasnobtn) || $hasnobtn != TRUE) && $user['groupid'] == 6 && $domain != 'www') { ?>
					<!--<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返回" type="button" />-->
					<input type="button" class="lanbtn" value="收藏" id="favorite" />
					<?php } ?>
		
					<!-- Baidu Button BEGIN -->
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-top:-7px;">
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
					</p>
				</div>
			</div>
			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])) { ?>
				<div style=" position: relative;height:600px;z-index:601;float:left;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
			<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
				<div style="float:left;width:968px;border:solid 1px #cdcdcd;background:#fff;padding-left:10px;margin-top:5px;">
				<div id="playcontrol" style="width:700px;height:428px;"></div>
				</div>
			<?php } ?>
				<div id='atsrc' style="display: none;"></div>
			<div style="float:left;width:958px;margin-top:5px;margin-bottom: 10px;"> 
			<div class="ieyin" style="_display:block;"><br/><br/></div>
				<?php if(($roominfo['isschool']!=2) && (preg_match("/.*(\.flv)$/",$course['cwurl'])) && $domain!='www'){ ?>
				<div class="tieziss"><input type="button" onclick="document.getElementById('flvcontrol').callflashvideo()" class="borlanbtn" value="提交学习时间"></div>
				<?php } ?>
				<?php if(($roominfo['isschool']!=2) && (preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])) && $domain!='www' && !empty($user)){ ?>
				<div class="tieziss"><input type="button" onclick="document.getElementById('playcontrol').callflashvideo()" class="borlanbtn" value="提交学习时间"></div>
				<?php } ?>
				<?php if(preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])){ ?>
					<?php if(!empty($user)){ ?>
							<?php if($domain=='www' || !empty($free)){ ?>
							<div class="tieziss" style="margin-top:10px;"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
							<?php }else{ ?>
							<div class="tieziss" style="margin-top:10px;"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')"  class="borlanbtn" value="播放"></div>
							<?php } ?>	
					<?php }else{ ?>
							<div class="tieziss" style="margin-top:10px;"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
					<?php } ?>
					<div class="tieziss" style="font-size:14px;line-height:26px;margin-top:10px;">您也可以切换到ebh播放器,更方便快捷</div>
				<?php } ?>
					
			</div>
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:0px;width:980px;">
				<div class="intitle" style="width:980px;">
					<h2>课件介绍</h2>
				</div>
			  	<div class="incont" style="width:928px;float:none">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>

			<?php if( $roominfo['isschool'] == 2 && ($domain!='www')) { ?>
			<?php if(!empty($examlist)){ ?>
			<div class="work_menuss" style="width:980px;">
					<div class="intitle" style="width:980px;">
					<h2>在线测评</h2>
				</div>
			</div>
				<div class="incont" style="width:958px;">
						<table width="958px;" class="datatab">
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
										<?php if(!empty($user)){ ?>
											<?php if($course['isfree']==1){ ?>
											<a class="previewBtn" href="http://exam.ebanhui.com/freedo/<?= $exam['eid'] ?>.html" target="_blank"><span>在线答题</span></a>
											<?php }else{ ?>
											<a class="previewBtn" href="http://exam.ebanhui.com/do/<?= $exam['eid'] ?>.html" target="_blank"><span>在线答题</span></a>
											<?php } ?>
										<?php }else{ ?>
											<a class="previewBtn" href="http://exam.ebanhui.com/freedo/<?= $exam['eid'] ?>.html" target="_blank"><span>在线答题</span></a>
										<?php } ?>
									</td>
								  </tr>
								  <?php } ?>
								
							  </tbody>
						</table>
					
				</div>
			<?php } ?>
			<?php } ?>

			

				<?php if (($domain!='www') && (!empty($attachments))) { ?>
				<div class="introduce" style="width:980px;">
					<div class="intitle" style="width:980px;">
						<h2>附件下载</h2>
					</div>
							
					<div class="incont">
							<table width="958px;" class="datatab">
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
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载附件" type="button" />
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
								<dd>
								<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></div>
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
				   <?php if($domain!='www'){ ?>
					  <div class="fill" style="width:700px;">
							<p class="pl">我来评论  　　满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<p style="background:#e7e7e7;width:470px;height:24px;border:1px solid #c2c2c2;border-bottom:none;"><a style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/smeil.jpg) no-repeat;display:block;font-size:0;height:24px;line-height:24px;overflow: hidden;width:24px;" href="javascript:;" id="showface" ></a></p>
							<p>
							<textarea id="comm" name="comm" cols="" style="resize:none;height:150px;" rows="" class="pltext"></textarea>
							<!--<div contenteditable="true" id="comm" name="comm" cols="" style="resize:none;overflow-y:scroll;height:150px;" rows="" class="pltext">
							</div>-->

							</p>
							<p class="plogin" style="width:470px;">
							<span><a href="javascript:;" onclick="comment();" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px;" name="review">评论</a></span>
							<span style="float:left;">(1-100字)</p>
					  </div>
					<?php } ?>
					<?php } ?>
				  </div>
	</div>
			</div>
		<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>	
				<div class="introduce" style="width:980px;">
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
								<dd>
								<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></div>
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
				   <?php if($domain!='www'){ ?>
					    <div class="fill">
							<p class="pl">我来评论  　　满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<p><textarea id="comm" name="comm" cols="" style="resize:none;height:150px;" rows="" class="pltext"></textarea></p>
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

<?php $this->display('common/player'); ?>
<?php $this->display('myroom/page_footer'); ?>
<script defer="defer" type="text/javascript">

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
						+'<dd>'
						+"<div class=\"apptit\"><span>"+CurentTime()+"</span><b>"+username+"</b></div>"
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
</script>
<script src="http://static.ebanhui.com/ebh/js/reviewspage.js" type="text/javascript"></script>