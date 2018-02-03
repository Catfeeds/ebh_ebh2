<?php $this->display('myroom/page_header'); ?>
<style>
.appraise dl dd {
    border-left: 0px solid #eeeeee;
    border-top: 1px solid #eeeeee;
    float: left;
    height: auto !important;
    min-height: 98px;
    width: 650px;
}
.fltats {
	width:766px;padding-left:20px;border-top: 1px solid #ededed;float: left;
}
.lefyt {
	position: absolute;
	top:33px;
	left:21px;
	background:#f9f9f9;
	height:89px;
	width:40px;
}
.lefyt a {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/smeil.png) no-repeat;
	display:block;
	font-size:0;
	height:24px;
	line-height:24px;
	overflow: hidden;
	width:24px;
	margin-top:30px;
	margin-left:8px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/reviewspage.js" type="text/javascript"></script>
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
			$("#favorite").val("收 藏");
			$("#favorite").unbind().click(function(){
				$("#favorite").removeAttr('onclick');
					addfavorite('<?= $course['cwid'] ?>','<?= str_replace('\'','',$course['title']) ?>',location.href);
			});
		<?php } else { ?>
			$("#favorite").val("已收藏");
		<?php } ?>
		});

		$(function(){
			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/courseebhp/getajaxpage.html";
			page_load(page,url);
		})
		
		</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>

<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
		<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/stusubject') ?>" >学习课程</a> > <a href="<?= geturl('myroom/stusubject/'.$course['folderid'])?>"><?= $course['foldername'] ?></a> > <?= $course['title']?>
</div>
<div class="lefrig" style="margin-top:5px;float:left;">
			<div class="classbox">
				<h1 style="font-weight: bold;color:#666;text-align: center;"><?= $course['title']?></h1>
				<div class="classboxmore">
						<?php $viewnumlib = Ebh::app()->lib('Viewnum');
							$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);
						?>
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $viewnum?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;margin-left:-10px;">
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
						<!--<a href="<?= geturl('myroom/course/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank">网页播放</a>-->
						<?php } ?>
					<?php } elseif (!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下 载</a>
						<?php if($course['ispreview']) { ?>
						<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank">预 览</a>
						<?php } ?>
					<?php } ?>
					<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
					<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返 回" type="button" />
					<input type="button" class="lanbtn" value="收 藏" id="favorite" />
					<?php } ?>
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<a href="<?= geturl('myroom/course/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank" style="float:right;margin-right:30px;">网页播放</a>
						<?php } ?>
					<?php } ?>
					</p>
				</div>
			</div>
			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])) { ?>
				<div style=" position: relative;height:600px;z-index:601;float:left;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
				<div id='atsrc' style="display: none;"></div>
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:20px;">
				<div class="intitle">
					<h2>课件介绍<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){ ?><div class="tieziss"><a href="javascript:void(0)" onclick="document.getElementById('flvcontrol').callflashvideo()" class="borlanbtn">提交学习时间</a></div><?php } ?></h2>
				</div>
			  	<div class="inconts">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>
			<a name="fujian" href="javascript:void(0);"></a>
			<?php $domain=$this->uri->uri_domain();
				$cloudurl='http://'.$domain.'.ebanhui.com';?>
				
			<div id="examworkList" class="introduce" style="width:786px;">
					<div class="intitle">
					<h2><a class="onlinework active" id="rid" onclick="parse_Joblist()">在线测评</a></h2>
				</div>
			
				<div class="incont" style="float:left;">
						<table width="100%;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th>作业名称</th>
									<th style="text-align: center;">出题时间</th>
									<th>总分</th>
									<th>操作</th>
							 	</tr>
							  </thead>
								<tbody>
							  </tbody>
						</table>
					
				</div>
				</div>



			<?php if (!empty($attachments)) { ?>
			<div class="introduce">
				<div class="intitle">
					<h2>附件下载</h2>
				</div>
						
				<div class="incont">
						<table width="100%" style="border:none;" class="datatab">
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
										<td width="57%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } else { ?>
										<td width="57%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } ?>
								<?php } ?>
									<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
									<td><?= getsize($atta['size'])?></td>
									<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
									<td>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载附件" type="button" />
											<?php if($atta['ispreview']) { ?>
											<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" target="_blank">预 览</a>
											<?php } ?>
										<?php } else { ?>
						   					<a class="atfalsh" href="javascript:void(0);" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播 放</a>
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
				<div class="introduce">
					<div class="intitle"><h2><a id="rid"><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?></a></h2></div>
					  <div class="appraise">
							
						<?php if (!empty($reviews)) { ?>
							<?php foreach ($reviews as $review) { ?>
							   <?php
								if ($review['sex'] == 1){
									if($review['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($review['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
								$face = empty($review['face']) ? $defaulturl : $review['face'];
								$face = getthumb($face, '50_50');
								?>
							<dl>
								<dt><div class="userimg"><a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></a></div></dt>
								<dd>
								<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></a></div>
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
								<div id="nocommentdiv" style="width:100%;height:50px;text-align:center;">暂无任何评论</div>
							</dl>
						<?php } ?>
							<div id="commentlastdiv" class="clear"></div>	
							 
					  </div>
				   <?= $pagestr ?>

	<div style="min-height:390px;width:785px; position:relative;float:left;">			  
			<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:20px;height:163px;">
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
					  <div class="fltats" id="rev" style="float:left;">
							<p class="pl">满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<div class="lefyt"><a href="javascript:;" id="showface" ></a></div>
							<p>
							<textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:690px;padding-left:45px;" rows="" class="pltext"></textarea>
							<!--<div contenteditable="true" id="comm" name="comm" cols="" style="resize:none;overflow-y:scroll;height:150px;" rows="" class="pltext">-->
							</div>

							</p>
							<p class="plogin" style="width:770px;float:left;">
							<span style="float:left;margin-left:20px;margin-top:4px;font-size:14px;">(1-100字)</span> 
							<span>
							<a style="	margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px;" href="javascript:;" onclick="comment()" id="submit" name="review">评论</a>
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
					<div class="intitle"><h2><a id="rid"><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?></a></h2></div>
					  <div class="appraise">
							
						<?php if (!empty($reviews)) { ?>
							<?php foreach ($reviews as $review) { ?>
							   <?php
								if(!empty($review['face']))
									$face = getthumb($review['face'],'50_50');
								else{
									if($review['sex']==1){
										if($review['groupid']==5){
											$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
										}else{
											$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
										}
									}else{
										if($review['groupid']==5){
											$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
										}else{
											$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
										}
									}
								
									$face = getthumb($defaulturl,'50_50');
								}
								?>
							<dl>
								<dt><div class="userimg"><a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></a></div></dt>
								<dd>
								<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><a href="http://sns.ebh.net/<?=$review['uid']?>/main.html" target="_blank"><b><?= empty($review['realname'])?$review['username']:$review['realname']?></b></a></div>
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


	<div style="min-height:390px;width:785px; position:relative;float:left;">			  
			<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:20px;height:163px;">
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
					    <div class="fltats" style="float:left;" id="rev">
							<p class="pl">满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<p><textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:690px;padding-left:45px;" rows="" class="pltext"></textarea></p>
							<p class="plogin" style="width:770px;float:left;">
							<span style="float:left;margin-left:20px;margin-top:4px;font-size:14px;">(1-100字)</span> 
							<span>
							<a href="javascript:;" onclick="comment()" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px;" name="review">评论</a>
							</span>
							</p>
					  </div>
					<?php } ?>
					<?php } ?>
	</div>

				  </div>

			</div>
			<?php } ?>
		<?php } ?>

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
							var isschool = '<?=$roominfo['isschool']?>';
							var isfree =  '<?=$course['isfree']?>';
							var $user = '<?=$user?>';
							
							list += '<tr>';
							list += '<td width="57%" style="font-weight:bolder;color:#666;padding:3px 6px;">&nbsp;'+ result[i].title+'</td>';
							list += '<td>'+ new Date(parseInt(result[i].dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>';
							list += '<td>'+ result[i].score+'</td>';
							list += '<td>';
							if($user != null){
								if(isfree == 1){
									list +=	'<a class="previewBtn" href="http://exam.ebanhui.com/freedo/'+result[i].eid+'.html" target="_blank"><span>做作业</span></a>';
								}else{
									if(isschool == 2){
										list +=	'<a class="previewBtn" href="http://exam.ebanhui.com/do/'+result[i].eid+'.html" target="_blank"><span>做作业</span></a>';
									}else{
										if(result[i].status == null){
											list +=	'<a class="previewBtn" href="http://exam.ebanhui.com/edo/'+result[i].eid+'.html" target="_blank"><span>做作业</span></a>';
										}else if(result[i].status == 1){
											list +=	'<a class="lviewbtn" href="http://exam.ebanhui.com/emark/'+result[i].eid+'.html" target="_blank"><span>查看结果</span></a>';
										}else{
											list +=	'<a class="previewBtn" href="http://exam.ebanhui.com/edo/'+result[i].eid+'.html" target="_blank"><span>继续做作业</span></a>';
										}
									}
								}
							}else{
								list +=	'<a class="previewBtn" href="http://exam.ebanhui.com/freedo/'+result[i].eid+'.html" target="_blank"><span>做作业</span></a>';
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
							list += '<td width="57%" style="font-weight:bolder;color:#666;padding:3px 6px;">&nbsp;'+  examList[i].exam.esubject+'</td>';
							list += '<td>'+ new Date(parseInt(examList[i].exam.dateline)* 1000).format("yyyy-MM-dd hh:mm:ss")+'</td>';
							list += '<td>'+ examList[i].exam.examtotalscore+'</td>';
							list += '<td>';
							if(examList[i].userAnswer.status == null){
								list +=	'<a class="previewBtn" href="/college/examv2/doexam/'+examList[i].exam.eid+'.html" target="_blank"><span>做作业</span></a>';
							}else if(examList[i].userAnswer.status == 1){
								list +=	'<a class="lviewbtn" href="/college/examv2/doneexam/'+examList[i].exam.eid+'.html" target="_blank"><span>查看结果</span></a>';
							}else{
								list +=	'<a class="previewBtn" href="/college/examv2/doexam/'+examList[i].exam.eid+'.html" target="_blank"><span>继续做作业</span></a>';
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
	//comm = comm.replace("<img width=\"24\" height=\"24\" src=\"http://static.ebanhui.com/ebh/tpl/default/images/29.gif\" title=\"享受\">","[享受]");
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
					if ($user['sex'] == 1){
						$defaulturl = '';
						if($user['groupid'] == 5){
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
						}else{
							$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
						}
					}else{
						if($user['groupid'] == 5){
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
						}else{
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
						}
					}
                        $face = empty($user['face']) ? $defaulturl : $user['face'];
                        $face = getthumb($face, '50_50');
				?>
				var face = "<?= $face ?>";
				var username = "<?= empty($user['realname'])?$user['username']:$user['realname']?>";
				var uid = <?= $user['uid'] ?>;
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
						+"<dt><div class=\"userimg\"><a href=\"http://sns.ebh.net/"+uid+"/main.html\" target=\"_blank\"><img width=\"50px\" height=\"50px\" src="+face+" /></a></div></dt>"
						+'<dd>'
						+"<div class=\"apptit\"><span>"+CurentTime()+"</span><a href=\"http://sns.ebh.net/"+uid+"/main.html\" target=\"_blank\"><b>"+username+"</b></a></div>"
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

<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7 ) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		<?php if(!empty($payitem)) { ?>
			if(window.parent.setiinfo != undefined) {
				window.parent.setiinfo("<?= $payitem['iname'] ?>","<?= empty($checkurl) ? '' : $checkurl ?>");
			}
		<?php } ?>
		window.parent.showDivModel(".nelame");
	}
});
<?php } ?>

$(function(){
	if(top.intro)
		$(".ter_tit a").contents().unwrap();
});
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>
<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
	<?php $this->display('myroom/player'); ?>
<?php }else{ ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js"></script>
<?php } ?>
<?php $this->display('myroom/page_footer'); ?>