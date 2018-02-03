<?php $this->display('troom/page_header'); ?>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script>
$(function(){
	//分页开始加载
	var page = 1;
	var cwid = $("#cwid").attr("value");
	var url = "/troom/course/getajaxpage.html";
	page_load(page,url);
})
</script>
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
<?php $domain=$this->uri->uri_domain();?>
<input type="hidden" value="1" id="ist" />
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<input type="hidden" value="<?=$domain?>" id="domain">

<div class="ter_tit">
    当前位置 > <a href="<?= geturl('troom/classsubject/courses') ?>" >课程管理</a> > <a href="<?= geturl('troom/classsubject/' . $course['folderid']) ?>"><?= $course['foldername'] ?></a> >  <?= $course['title'] ?>
</div>
<div class="lefrig">
    <div class="classbox" style="margin-top:5px;">
        <h1 style="font-weight: bold;color:#666;text-align: center;"><?= $course['title'] ?></h1>
        <div class="classboxmore">
            <p>主讲：<?= $course['realname'] ?>
			<?php $viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);?>
                <span>时间：<?= date('Y.m.d', $course['dateline']) ?></span>
				<span>人气：<?= $viewnum?>人</span>
            </p>
            <p>摘要：<?= $course['summary'] ?></p>

            <p style="padding:10px;margin-left:-10px;">
                <?php if (preg_match("/.*(\.ebh|\.ebhp)$/", $course['cwurl'])) { ?>

                    <input type="button" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>, '<?= str_replace("'", " ", $course['title']) ?>');" class="huangbtn marrig" value="开始播放" name="" />
                <?php } else if (preg_match("/.*(\.flv)$/", $course['cwurl'])) { ?>

                <?php } else if (!empty($course['cwurl'])) { ?>
                    <a class="huangbtn marrig" href = "<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>">下载</a>
					<?php if($course['ispreview']) { ?>
					<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank">预览</a>
					<?php } ?>
                    <?php } ?>
				<?php if($course['uid'] == $user['uid']){ ?>
                    <a class="huangbtn" href="<?= geturl('troom/classcourse/upattach-0-0-0-'.$course['cwid'])?>">上传附件</a>
				<?php } ?>

				<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<a href="<?= geturl('troom/course/'.$course['cwid']) ?>" class="huangbtn marrig" target="_blank" style="float:right;margin-right:50px;">网页播放</a>
						<?php } ?>
					<?php } ?>
                </p>
            </div>
        </div>
        <?php if (preg_match("/.*(\.flv)$/", $course['cwurl'])) { ?>
            <div style=" float:left;position: relative;height:600px;z-index:601;">
                <div id="flvcontrol" style="width:700px;height:400px;"></div>

            </div>
        <?php } ?>
        <div id='atsrc' style="display: none;"></div>
		<?php if(!empty($course['message'])){ ?>
        <div class="introduce" style="padding-top: 10px;float:left;">
            <div class="intitle"><h2><a id="rid">课件介绍</a></h2></div>
            <div class="inconts">
                <?= $course['message'] ?>
            </div>
        </div>
		<?php } ?>

		<?php if(!empty($exams)) { ?>
        <div class="introduce" style="padding-top: 10px;float:left;">
		<div class="intitle"><h2><a id="rid">在线作业</a></h2></div>
            <div class="incont">
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
					<td width="58%"><?= $exam['title'] ?></td>
					<td><?= date('Y-m-d H:i',$exam['dateline']) ?></td>
					<td>
						<?= $exam['score']?>
					</td>
					<td><?= $exam['answercount'] ?></td>
					<td>
                        <?php if($user['uid']!=$exam['uid']){?>
                             <a class="workBtn" href="http://exam.ebanhui.com/ado/<?=$exam['eid']?>.html" target="_blank"><span>查看</span></a>
                        <?php }else{?>
                            <?php if($roominfo['isschool']==2){?>
    						  <a class="workBtn" href="http://exam.ebanhui.com/edit/<?=$exam['eid']?>.html" target="_blank"><span>编辑</span></a>
    						  <a class="workBtn" href="javascript:void(0)" onclick="delexam(<?=$exam['eid']?>,<?= $course['cwid']?>,'<?= str_replace('\'','',$exam['title'])?>')"><span>删除</span></a>
    					   <?php }else{?>
                              <a class="workBtn" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/<?=$exam['eid']?>.html" target="_blank"><span>编辑</span></a>
                              <a class="workBtn" href="javascript:void(0)" onclick="delexam2(<?=$exam['eid']?>,<?= $roominfo['crid']?>)"><span>删除</span></a>
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

        <?php if (!empty($attachments)) { ?>
            <div class="introduce" style="padding-top: 10px;float:left;">
               <div class="intitle"><h2><a id="rid">附件下载</a></h2></div>
                <div class="incont">
                    <table width="100%" class="datatab" style="border:none;">
                        <thead class="tabhead">
                            <tr>
                                <th>附件名称</th>
                                <th>上传时间</th>
                                <th>审核状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                 
                            <?php foreach ($attachments as $atta) { ?>
                                <tr>
                                    <?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
                                       
                                        <?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
                                            <td width="58%"><span style="width:350px;word-wrap: break-word;float:left;"><a title="<?= $atta['title']?>" href="<?= $course['cwsource'].'attach.html?attid='.$atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
                                          
                                        <?php } else { ?>
                                            <td width="58%"><span style="width:350px;word-wrap: break-word;float:left;"><a title="<?= $atta['title']?>" href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
                                        <?php } ?>
                                       
                                    <?php } ?>
                                    <td><?= Date('Y-m-d H:i', $atta['dateline']) ?></td>
                                    <td>
                                       
                                        <?php if ($atta['status'] == 0) { ?>
                                            <font color="#ff6600">未审核</font>
                                        <?php } else if ($atta['status'] == 1) { ?>
                                            <font color="#008000">审核通过</font>
                                        <?php } else if ($atta['status'] == -1) { ?>
                                            <font color="#a7a7a7">审核未通过</font>
                                        <?php } ?>
                                    </td>

                                    <?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
                                        <td>
                                          
                                            <?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
                                                <input class="previewBtn" onclick="location.href = '<?= $course['cwsource'].'attach.html?attid='.$atta['attid'] ?>'" name="" value="下载附件" type="button"/>
												<?php if($atta['ispreview']) { ?>
												<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" style="margin-right:0px;" target="_blank">预览</a>
												<?php } ?>
                                            <?php } else { ?>
                                                <input type="hidden" id="aid<?= $atta['attid'] ?>" value="<?= $atta['attid'] ?>" />
                                                <a class="atfalsh" href="javascript:void(0);" title="<?= $atta['title']?>" source="<?= (empty($source) ?$atta['source']:$source) ?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
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

<?php $domain=$this->uri->uri_domain();
		$cloudurl='http://'.$domain.'.ebanhui.com';?>
	<?php if($roominfo['crid']!=10420){ ?>
        <div class="introduce">
            <div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
            <div class="appraise">
              
                <?php if(!empty($reviews)) { ?>
               
                <?php foreach($reviews as $review) { ?>
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
                <dl id="review_<?= $review['logid'] ?>">
                            <dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
                            <dd>
                                <div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
                                <div class="grade">总体评分: 
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
                                </div>
                                <p><?= $review['subject'] ?></p>
                                <?php if (!empty($review['rsubject'])) { ?>
                                    <div class="restore">
                                        <div class="restore_arrow">◆</div>
                                        <div class="restore_cont"><h1>我的回复：</h1><?= $review['rsubject'] ?></div>
                                    </div>
                                <?php } else { ?>
                                    <div id="replay_<?= $review['logid'] ?>">
                                        <?php if ($course['uid'] == $user['uid']) { 
										$subject = str_replace('"','\"',$review['subject']);
										$subject = str_replace("\n","",$subject);
										$subject = str_replace("\r","",$subject);
										?>
                                            <input class="replyBtn" style="cursor:pointer;"  type="button" onclick='reply("<?=$subject ?>", "<?= $course['title'] ?>", "<?= $review['logid'] ?>", "courseware", "<?= $course['cwid'] ?>")' value="回复" />
                                        <?php } else { ?>
                                            <input class="noreplyBtn" type="button" value="回复" />
                                        <?php } ?>
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
                

            </div>
		<?= $pagestr ?>
       <div style="height:390px; position:relative;float:left;">			  
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
					  <div class="fltats" style="float:left;" id="rev">
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
						<div class="lefyt"><a href="javascript:;" id="showface" ></a></div>
							<p>
							<textarea x_hit="请输入评论内容" id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:690px;padding-left:45px;color: #000 !important;" rows="" class="pltext"></textarea>
							<!--<div contenteditable="true" id="comm" name="comm" cols="" style="resize:none;overflow-y:scroll;height:150px;" rows="" class="pltext">-->
							</div>

							</p>
							<p class="plogin" style="width:770px;float:left;">
							<span style="float:left;margin-left:20px;margin-top:4px;font-size:14px;">(1-100字)</span> 
							<span>
							<a style="	margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px; border-radius:4px;" href="javascript:;" onclick="comment()" id="submit" name="review">评论</a>
							</span>
							</p>
					  </div>
					<?php } ?>
				  </div>

			</div>
		<?php }else{ ?>
			<?php if($roominfo['isschool']!=3){ ?>
				 <div class="introduce">
					<div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
					<div class="appraise">
					  
						<?php if(!empty($reviews)) { ?>
					   
						<?php foreach($reviews as $review) { ?>
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
						<dl id="review_<?= $review['logid'] ?>">
									<dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
									<dd>
										<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
										<?php if($domain == 'bndx'){ $reviewtxtarr = array('','一般','好','很好');?>
										<div class="grade">总体评分:<?=$reviewtxtarr[$review['score']]?>
										</div>
										<?php }else{ ?>
										<div class="grade">总体评分: 
											<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
											<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
										</div>
										<?php } ?>
										<p id="review_<?= $review['logid'] ?>"><?= $review['subject'] ?></p>
										<?php if (!empty($review['rsubject'])) { ?>
											<div class="restore">
												<div class="restore_arrow">◆</div>
												<div class="restore_cont"><h1>我的回复：</h1><?= $review['rsubject'] ?></div>
											</div>
										<?php } else { ?>
											<div id="replay_<?= $review['logid'] ?>">
												<?php if ($course['uid'] == $user['uid']) { 
												$subject = str_replace('"','\"',$review['subject']);
												$subject = str_replace("\n","",$subject);
												$subject = str_replace("\r","",$subject);
												?>
													<input class="replyBtn" style="cursor:pointer;"  type="button" onclick='reply("", "<?= $course['title'] ?>", "<?= $review['logid'] ?>", "courseware", "<?= $course['cwid'] ?>")' value="回复" />
												<?php } else { ?>
													<input class="noreplyBtn" type="button" value="回复" />
												<?php } ?>
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
						

					</div>
				<?= $pagestr ?>
				<div style="height:390px; position:relative;float:left;">			  
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
					  <div class="fltats" style="float:left;" id="rev">
							<p class="pl">满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<p><textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:690px;padding-left:45px;" rows="" class="pltext"></textarea></p>
							<p class="plogin"style="width:770px;float:left;">
							<span style="float:left;margin-left:20px;margin-top:4px;font-size:14px;">(1-100字)</span> 
							<span>
							<a href="javascript:;" onclick="comment()" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px;" name="review">评论</a>
							</span> </p>
					  </div>
					<?php } ?>
				  </div>

			</div>
			<?php } ?>

	<?php } ?>
		</div>


    <script type="text/javascript">
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
	var url = "<?= geturl('troom/review/add')?>";
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
					if ($user['sex'] == 1){
						$defaulturl = '';
							if($user['groupid']==5){
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
								}else{
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
								}
							}else{
								if($user['groupid']==5){
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
								}else{
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
								}
							}
							$face = empty($user['face']) ? $defaulturl : $user['face'];
							$face = getthumb($face, '50_50');
				?>
				var face = "<?= $face ?>";
				var username = "<?= $user['realname']?>";
				var realname = "<?= $user['username']?>";
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
						+"<div class=\"apptit\"><span>"+CurentTime()+"</span><b>"+realname+"("+username+")</b></div>"
						+'<div class="grade">总体评分:'+(domain == 'bndx' ? getstar_txt(document.getElementById('mark').value) : getstar(document.getElementById('mark').value)) 
						+'</div>'
						+'<p>'+str+'</p>'
						+'</dd></dl>');
				$("#comm").val("");
				$("#mark").val("0");
				$('input[name=cstar]').attr('checked',false);
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

    $(function (){
            var cwid = <?= $course['cwid'] ?>;
            var isfree = <?= $course['isfree'] ?>;
            var num = 1;//教室内
            playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','750');
    	
    });

    function ablank(url){
            window.open(url);
    }

    $(function(){
        var button = new xButton();
        button.add({
            value:'确定',
            callback:function(){
                submit_refuse();
                $("#repcontent").val("");
                return false;
            },
            autofocus:true
        });
        button.add({
            value:'取消',
            callback:function(){
                $("#repcontent").val("");
				$("#msg").html("");
                H.get('commentdiv').exec('close');
                return false;
            }
        });
        H.create(new P({
            id:'commentdiv',
            title:'回复评论',
            content:$(".commentdiv")[0],
            easy:true,
            width:480,
            button:button,
            padding:5
        },{
			'onclose':function(){
				$("#repcontent").val("");
				return false;
			},
			'onshow':function(){
				$("#msg").html("");
				return false;
			}
		}));
	});

    function reply(content,target,logid,type,toid)
	{

		$("#type").val(type);
		$("#toid").val(toid);
		$("#target").text(target);
		$("#logid").val(logid);
		$("#content").text(content);
        H.get('commentdiv').exec('show');
	}
    function submit_refuse(){
		if($.trim($("#repcontent").val())==''){
			$("#msg").text('回复内容不能为空！');
			return false;
		}else if($("#repcontent").val().length >70){
			$("#msg").text('回复内容应为1-70个字符！');
			return false;
		}else{
			$("#msg").text('');
		}
		var _logid = $("#logid").val();
		var _type = $("#type").val();
		var _toid = $("#toid").val();
			var _repcontent = $("#repcontent").val();
			var url = '<?= geturl('troom/review/reply') ?>';
		$.ajax({
			type:'post',
			url:url,
			dataType:'json',
			data:{'logid':_logid,'type':_type,'toid':_toid,'repcontent':_repcontent},
			success:function(_json){
				if(_json.status == 1){
					var htmlcontent = '<div class="restore"><div class="restore_arrow">◆</div><div class="restore_cont"><h1>我的回复：</h1>'+_repcontent+'</div></div>';
					$("#review_" + _logid).after(htmlcontent);
					$("#replay_" + _logid).remove();
					
					H.get('commentdiv').exec('close');
				} else {
					$("#msg").text(_json.msg);
				}
			}
		})		
	}

		//屏蔽
	function shield(cwid,logid){
	
		$.confirm("您确定要屏蔽该评论吗？屏蔽后不可查看该评论!", function() {
			var url = "<?= geturl('troom/course/shield')?>";
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'cwid':cwid,'logid':logid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
						$.showmessage({
                            img : 'success',
                            message:'屏蔽评论信息成功！',
                            title:'屏蔽评论',
                            callback :function(){
							   document.location.href = document.location.href;
                            }
                        });
					} else {
						var msg = '屏蔽评论失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
						$.showmessage({
                            img : 'error',
                            message:msg,
                            title:'屏蔽评论'
                        });
					}
				}
			});	
		});
	}
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
	function delexam(eid,cwid,title) {
		$.confirm("确认要删除作业 [" + title + "] 吗？", function() {
			var url = "<?= geturl('troom/course/delexam')?>";
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'cwid':cwid,'eid':eid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
						$.showmessage({
                            img : 'success',
                            message:'删除作业成功',
                            title:'删除作业',
                            callback :function(){
                               $("#exam_"+eid).remove();
                            }
                        });
					} else {
						var msg = '上传失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
						$.showmessage({
                            img : 'error',
                            message:msg,
                            title:'删除作业'
                        });
					}
				}
			});	
		});
	}
    //-->
    </script>
    <div class="commentdiv" style="display:none;overflow:hidden;">
        <input type="hidden" id="logid" value="" name="logid" />
        <input type="hidden" id="type" value="" name="type" />
        <input type="hidden" id="toid" value="" name="toid" />
        <table border="0" cellspacing="0" cellpadding="0" width="400">
            <tr><td colspan=2><span style="color: #D0304F">温馨提示：每条评论只能回复一次，请谨慎操作</span></td></tr>
            <tr>
                <td colspan=2>评论对象：<label id="target"></label></td>
            </tr>
            <tr style="margin:8px 0;">
                <td colspan=2>评论内容：<span style="word-wrap:break-word;width:370px;display:inline-block;" id="content"></span></td>
            </tr>
            <tr>
                <td colspan=2>回复内容：<textarea cols="50" rows="5" id="repcontent" name="repcontent"></textarea></td>
            </tr>
            <tr>
                <td width="80"></td><td><em id="msg" style="color: #ff0000"></em></td>
            </tr>

        </table>
    </div>
    <div style="display:none;" class="Offl" id="showdiv"></div>
	<script src="http://static.ebanhui.com/ebh/js/reviewspage.js" type="text/javascript"></script>

	<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
	<?php $this->display('common/player'); ?>
	<?php } ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001"></script>
    <?php $this->display('troom/page_footer'); ?>