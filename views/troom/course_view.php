<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico');
</script>
<![endif]-->
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=2015111801" rel="stylesheet" type="text/css" />
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
	.classboxmore{
		border:none;
	}
	.workcurrent a span {background:none;padding:0;}
.workcurrent a {padding:0;background:url(http://static.ebanhui.com/ebh/tpl/default/images/intit_02.jpg) no-repeat;width:118px;height:33px;line-height:33px;text-align:center;}
.work_mes ul li{font-size:14px;}
.classbox h1.rygers {font-weight: bold; color:#666;margin-top:10px;height:20px;line-height:20px;}
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
</style>
</head>
<body>
<?php $domain=$this->uri->uri_domain();?>
<input type="hidden" value="1" id="ist" />
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<input type="hidden" value="<?=$domain?>" id="domain">

<div style="margin:0 auto;width:980px;">
<div class="cright_cher" style="width:980px;margin-bottom:20px;">
<div class="ter_tit" >
    当前位置 > 课程列表 > <?= $course['foldername'] ?> >  <?= $course['title'] ?>
</div>
<div class="lefrig" style="padding:0;">
    <div class="classbox" style="margin-top:5px;width:978px;background: #FFF;">
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
        <h1 style="font-weight: bold;color:#666;"><?= $course['title'] ?></h1>
        <div class="classboxmore">
            <p><?= $course['realname'] ?>
				<?php $viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);?>
                <span><?= date('Y.m.d', $course['dateline']) ?></span>发布<span>人气：<?= $viewnum?></span>
            </p>
            <p><?= $course['summary'] ?></p>

            <p style="padding:10px;">
                <?php if (!empty($course['cwurl']) && $ext != 'flv' && $ext != 'mp3') { ?>
                    <a class="huangbtn marrig" href = "<?= $course['cwsource'] . 'attach.html?cwid=' . $course['cwid'] ?>">下 载</a>
					<?php if($course['ispreview']) { ?>
					<a class="huangbtn marrig" href = "<?= $course['cwsource'].'preview/'.$course['cwid'].'.html' ?>" target="_blank">预 览</a>
					<?php } ?>
                <?php } ?>
                 <!--   <a class="huangbtn" href = "<?= geturl('troom/course/upattach-0-0-0-' . $course['cwid']) ?>">上传附件</a>-->
            </p>
            </div>
        
        
		<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
				<div style=" position: relative;height:740px;margin-left:10px;z-index:601;float:left;">
				<div id="playcontrol" style="width:700px;height:428px;"></div>
				</div>
		<?php } ?>
		<?php if ($ext == 'flv' || $ext == 'mp3') { ?>
			<?php if($ext == 'mp3') {?>
                <div style=" float:left;position: relative;height:410px;margin-left:10px;z-index:601;">
    		<?php } else { ?>
    			<div style=" float:left;position: relative;height:600px;margin-left:10px;z-index:601;">
    		<?php } ?>
                    <div id="flvcontrol" style="width:700px;height:400px;">
    				</div>
            	</div>
        <?php } ?>

        <div id='atsrc' style="display: none;"></div>
</div>
<?php $domain=$this->uri->uri_domain();
					$cloudurl='http://'.$domain.'.ebanhui.com';?>
		<?php if(preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])){ ?>
			<?php if(!empty($user)){ ?>
					
				 <?php if($domain=='www' || !empty($free)){ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
					<?php }else{ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')"  class="borlanbtn" value="播放"></div>
					<?php } ?>	
			<?php }else{ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
			<?php } ?>
			<div class="tieziss" style="font-size:14px;line-height:26px;">您也可以切换到ebh播放器,更方便快捷</div>
		<?php } ?>

		<?php if(!empty($course['message'])){ ?>
        <div class="introduce" style="padding-top: 10px;float:left;width:978px;">
            <div class="intitle" style="width:978px;"><h2><a id="rid">课件介绍</a></h2></div>
            <div class="inconts" style="width:978px;">
                <?= $course['message'] ?>
            </div>
        </div>
		<?php } ?>

		<?php if(!empty($exams)) { ?>
        <div class="introduce" style="width:978px;padding-top: 10px;float:left;">
		<div class="intitle" style=" width: 978px;"><h2><a id="rid">在线作业</a></h2></div>
            <div class="incont" style="width:978px;">
		<table width="100%" class="datatab" style="border:none;width: 978px;">
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
					<td width="65%"><?= $exam['title'] ?></td>
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
            <div class="introduce" style="padding-top: 10px;float:left;width:978px;">
                 <div class="intitle" style="width:978px;"><h2><a id="rid">附件介绍</a></h2></div>
                <div class="incont">
                    <table width="100%" class="datatab" style="border:none;width: 978px;">
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
                                            <td width="65%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
                                        <?php } else { ?>
                                            <td width="65%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] ?></a></span></td>
                                        <?php } ?>
                                    <?php } ?>
                                    <td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
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
        <div class="introduce" style="width:978px;padding-top: 10px;float:left;">
            <div class="work_mes" style="width:977px;margin-bottom:10px">
				<ul>
					<li class="workcurrent reviewtab" onclick="showreview()"><a name="reviewanc" href="javascript:void(0)"><span>课件评论 (<font color="red" id="reviewcount"><?=$reviewcount?></font>)</span></a></li>
					<li class="asktab" onclick="showask()"><a href="javascript:void(0)"><span>相关问题 (<font color="red"><?=$askcount?></font>)</span></a></li>
				</ul>
			</div>
			<div id="reviewdiv">
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
                            <dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
                            <dd style="width:870px;">
                                <div class="apptit"><span><a style="margin-right:10px;color:#999999;" href="javascript:shield(<?= $course['cwid']?>,<?= $review['logid']?>)">屏蔽</a><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
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
                                <?php if (!empty($review['replysubject'])) { ?>
                                    <div class="restore">
                                        <div class="restore_arrow">◆</div>
                                        <div class="restore_cont"><h1>我的回复：</h1><?= $review['replysubject'] ?></div>
                                    </div>
                                <?php } else { ?>
                                    <div id="replay_<?= $review['logid'] ?>">
                                        <?php if ($course['uid'] == $user['uid']) {
											$subject = str_replace('"','\"',$review['subject']);
											$subject = str_replace("\n","",$subject);
											$subject = str_replace("\r","",$subject);
										?>
                                            <input class="replyBtn" style="cursor:pointer;"  type="button" onclick='reply("<?= str_replace('"', '\"', $review['subject']) ?>", "<?= $course['title'] ?>", "<?= $review['logid'] ?>", "courseware", "<?= $course['cwid'] ?>")' value="回复" />
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
			</div>
			<div id="askdiv" style="float:left;width:970px;display:none">
				<div style="text-align:center;">
					<span style="font-size:14px;line-height:30px;" id="noask">
						暂无相关问题
					</span>
				</div>
				<div class="tweytr" style="margin-left:10px">
							
				</div>
						
			</div>
        <div style="height:200px; position:relative;float:left;" id="cmdiv">			  
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
							<textarea x_hit="请输入评论内容" id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext"></textarea>
							<!--<div contenteditable="true" id="comm" name="comm" cols="" style="resize:none;overflow-y:scroll;height:150px;" rows="" class="pltext">-->
							</div>

							</p>
							<p class="plogin" style="width:946px;margin-left:20px;float:left;">
							<span><a href="javascript:;" onclick="comment();" id="submit" style="margin-right:100px;background: none repeat scroll 0 0 #18a8f7;color: #fff;float: right;height: 29px;line-height: 29px;margin-right: 9px;text-align: center;text-decoration: none;width: 96px;font-size:14px; border-radius:4px;" name="review">评论</a></span>
							<span style="float:left;font-size:14px;">(1-100字)</span> </p>
					  </div>
					<?php } ?>
				  </div>

			</div>
		<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>
				<div class="introduce" style="width:978px;padding-top: 10px;float:left;">
            <div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
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
                            <dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
                            <dd style="width:650px;">
                                <div class="apptit" style="width:850px;"><span><a style="margin-right:10px;color:#999999;" href="javascript:shield(<?= $course['cwid']?>,<?= $review['logid']?>)">屏蔽</a><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
                                <div class="grade">总体评分: 
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
                                </div>
                                <p id="review_<?= $review['logid'] ?>"><?= $review['subject'] ?></p>
                                <?php if (!empty($review['replysubject'])) { ?>
                                    <div class="restore">
                                        <div class="restore_arrow">◆</div>
                                        <div class="restore_cont"><h1>我的回复：</h1><?= $review['replysubject'] ?></div>
                                    </div>
                                <?php } else { ?>
                                    <div id="replay_<?= $review['logid'] ?>">
                                        <?php if ($course['uid'] == $user['uid']) { ?>
                                            <input class="replyBtn" style="cursor:pointer;"  type="button" onclick='reply("<?= str_replace('"', '\"', $review['subject']) ?>", "<?= $course['title'] ?>", "<?= $review['logid'] ?>", "courseware", "<?= $course['cwid'] ?>")' value="回复" />
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
					  <div class="fill" style="width:956px;height:auto;padding-left: 20px;margin:0;padding-bottom:0px;" id="rev">
							<p class="pl">满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
							<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
							</em></p>
							<p><textarea id="comm" name="comm" cols="" style="resize:none;height:80px;font-size:14px;width:885px;padding-left:45px;" rows="" class="pltext" x_hit="请输入评论内容"></textarea></p>
							<p class="plogin" style="width:946px;margin-left:20px;float:left;">
							<span><input name="review" class="plBtn" value="评论" type="button" onclick="comment()" /></span>
							<span style="float:left;">(1-100字)</span> </p>
					  </div>
					<?php } ?>
				  </div>

			</div>
			<?php } ?>

		<?php } ?>

</div>
<div id="moreask" style="display:none;float:left;text-align:center;background:#fff;border:1px solid #cdcdcd;width:981px;height:35px;line-height:35px;font-size:14px;margin-top:-10px;">
	<a target="_blank" href="/troom/myask/allquestion.html?cwid=<?=$course['cwid']?>" style="width:978px;display:block">更多>></a>
</div>
</div></div>
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

				//评论成功后初始化
				$("#mark").val("0");
				$('#comm').val("");
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
	//播放
   $(function (){
			var cwid = <?= $course['cwid'] ?>;
			var isfree = 1;
			var num = 1;//教室内
			var lastsuffix = 'flv';
			<?php if(!empty($ext)){?>
				lastsuffix = '<?= $ext ?>';
			<?php } ?>
			if(lastsuffix == 'flv'){
				//flv
				<?php 
					if(!empty($course['m3u8url'])) {
				?>
					playmu('<?= $course['m3u8url'] ?>',cwid,'',isfree,num,'562','958',0,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>);
				<?php 
					} else if(!empty($course['rtmpurl'])) {
				?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','958',0,'<?= $course['thumb'] ?>');
				<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','958',0);
				<?php } ?>

			}else if (lastsuffix == 'mp3'){
				//ebh
				playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','958',0);
			}else if (lastsuffix == 'ebh' || lastsuffix == 'ebhp'){
				//ebh
				freeebh('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'700','958',1);
			}
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
		if($("#repcontent").val()==''){
			$("#msg").text('回复内容不能为空！');
			return;
		}else if($("#repcontent").val().length >70){
			$("#msg").text('回复内容应为1-70个字符！');
			return;
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
		var cwid = <?= $course['cwid'] ?>;
		if(askloaded == false){
			$.ajax({
				url : '/troom/course/linkask.html',
				type : 'post',
				data : {cwid:cwid},
				success : function(data){
					if(askloaded == false)
					result = eval('('+data+')');
					if(result['list'].length>0){
						$('#noask').hide();
						$.each(result['list'],function(idx,obj){
							$('.tweytr').append(formatasklist(obj));
						});
						if(result['count']>10){
							moreask = true;
							$('#moreask').show();
						}
					}
					askloaded = true;
				}
			});
		}
		else if(moreask)
			$('#moreask').show();
	}
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
		html+= '	<div style="float:left;margin-right:15px;"><img title="'+name+'" src="'+list.face+'" /></div>';
		html+= '	<div style="float:left;width:840px;font-family:Microsoft YaHei;">';
		html+= '		<p style="width:720px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">';
		if(list.reward>0){
		html+= '<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏'+list.reward+'积分">悬赏'+list.reward+'<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/></span>&nbsp';
		}
		html+= '		<a target="_blank" href="/troom.html?url=/troom/myask/'+list.qid+'.html" style="color:#777;font-weight:bold;">';
		if(list.status == 1){
		html+= '		<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>';
		}
		html+= shortstr(list.title);
		html+= '		</a>';
		html+= '		</p>';
		html+= '	<span class="dashu">回答数<br/>'+list.answercount+'</span>';
		html+= '		<div style="float:left;width:730px;">';
		html+= '	<span style="width:180px;float:left;">'+getformatdate(list.dateline)+'</span>';
		html+= '	<span class="huirenw" style="width:150px;float:left;">'+name+'</span>';
		html+= '	<span class="ketek" style="width:330px">'+list.foldername+'</span>';
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
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001?v=0629"></script>
    <?php $this->display('troom/page_footer'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>