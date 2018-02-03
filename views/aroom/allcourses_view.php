<?php $this->display('aroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript">
	<?php if(empty($ckresult)){$ckresult=0;}?>
	<?php if(($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $ckresult == 2) { ?>
	$(function(){
		if(window.parent != undefined) {

			window.parent.showDivModel(".nelame");
		}
	});
	<?php } ?>
</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
		<div class="ter_tit">
	当前位置 > <a href="<?= geturl('aroom/allcourses') ?>" >学校所有课程</a> > <a href="<?= geturl('aroom/allcourses/'.$course['folderid'])?>"><?= $course['foldername'] ?></a> > <?= $course['title']?>
</div>
<div class="lefrig" style="margin-top:10px;">
			<div class="classbox">
				<h1 style="font-weight: bold;color:#666;text-align: center;"><?= $course['title']?></h1>
				<div class="classboxmore">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $course['viewnum']?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;margin-left:-10px;">
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
					<?php } elseif (!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下载</a>
					<?php } ?>
					<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返回" type="button" />
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<a href="<?= geturl('aroom/course/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank" style="float:right;margin-right:50px;">网页播放</a>
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
			<div class="introduce" style="padding-top:10px;width:788px;">
				<div class="intitle">
					<h2>课件介绍<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){ ?><div class="tieziss"><a href="javascript:void(0)" onclick="document.getElementById('flvcontrol').callflashvideo()" class="borlanbtn">提交学习时间</a></div><?php } ?></h2>
				</div>
			  	<div class="incont">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>
					<?php if(!empty($exams)) { ?>
        <div class="introduce" style="width:788px;">
		<div class="intitle" style=" width: auto;"><h2><a id="rid">在线作业</a></h2></div>
            <div class="incont" style="width:788px;">
		<table width="100%" class="datatab" style="border:none;">
			<thead class="tabhead">
				<tr>
					<th>作业名称</th>
					<th>出题时间</th>
					<th>总分</th>
					<th>已答人数</th>
					<th>操作</th>
			 	</tr>
			  </thead>
				<tbody>
				<?php foreach($exams as $exam) {?>
				  <tr id="exam_<?= $exam['eid'] ?>">
					<td width="60%"><?= $exam['title'] ?></td>
					<td><?= date('Y-m-d H:i',$exam['dateline']) ?></td>
					<td>
						<?= $exam['score']?>
					</td>
					<td><?= $exam['answercount'] ?></td>
					<td>
                        <?php if($roominfo['isschool']==2){?>
							<a class="workBtn" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/<?=$exam['eid']?>.html" target="_blank"><span style="padding:0">编辑</span></a>
                            <a class="workBtn" href="javascript:void(0)" onclick="delexam(<?=$exam['eid']?>,<?= $roominfo['crid']?>)"><span style="padding:0">删除</span></a>
					   <?php }else{?>
                          <?php if($user['uid']==$exam['uid']){?>
                                <a class="workBtn" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/<?=$exam['eid']?>.html" target="_blank"><span style="padding:0">编辑</span></a>
                                <a class="workBtn" href="javascript:void(0)" onclick="delexam2(<?=$exam['eid']?>,<?= $roominfo['crid']?>)"><span style="padding:0">删除</span></a>
                            <?php }else{?>
                                <a class="workBtn" href="http://exam.ebanhui.com/ado/<?=$exam['eid']?>.html" target="_blank"><span style="padding:0">查看</span></a>
                            <?php }?>
                       <?php }?>
                    </td>
				  </tr>
				  <?php } ?>
			  </tbody>
		</table>
		
            </div>
        </div>

<?php } ?>
			<a name="fujian" href="javascript:void(0);"></a>
			<?php if (!empty($attachments)) { ?>
			<div class="introduce" style="width:788px;">
				<div class="intitle">
					<h2>附件下载</h2>
				</div>
						
				<div class="incont">
						<table width="100%" class="datatab" style="border:none;">
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
										<td width="60%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } else { ?>
										<td width="60%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } ?>
								<?php } ?>
									<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
									<td><?= getSize($atta['size']) ?></td>
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
			<div class="introduce" style="width:788px;">
				<div class="intitle"><h2>课件评论</h2></div>
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
						<dt style="width:60px;"><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
						<dd style="width:691px;">
						<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
						<div class="grade">总体评分: 
						<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
                        <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
						</div>
						<p><?= $review['subject'] ?></p>
						<?php if (!empty($review['rsubject'])) { ?>
						<div class="restore" style="width:810px;">
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
			<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>
					<div class="introduce" style="width:786px;">
					<div class="intitle"><h2>课件评论</h2></div>
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
							<dd style="width:691px;">
							<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
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
			<?php } ?>
		<?php } ?>

			  </div>
		<div style="display:none;" class="Offl" id="showdiv"></div>
<script defer="defer" type="text/javascript">

    function delexam2(eid,crid) {
        $.confirm("作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？",function(){
            var url = '<?= geturl('troom/classexam/del') ?>';
            $.ajax({
                url:url,
                type:'post',
                data:{'eid':eid},
                dataType:'text',
                success:function(data){
                    if(data==1){
                        $.showmessage({
                            img      : 'success',
                            message  :  '作业删除成功',
                            title    :      '作业删除      成功',
                            timeoutspeed    :       500,
                            callback :    function(){
                                location.reload();
                            }
                        });
                    }else{
                        $.showmessage({
                            img      : 'error',
                            message  :  '作业删除失败',
                            title    :      '作业删除      失败',
                            timeoutspeed    :       500
                        });
                    }
                }
            });
        });
        
    }
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>
<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
<?php $this->display('common/player'); ?>
<?php }else{ ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js"></script>
<?php } ?>
<?php $this->display('myroom/page_footer'); ?>