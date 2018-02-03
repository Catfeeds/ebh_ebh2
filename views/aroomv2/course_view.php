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
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script>
$(function(){
	//分页开始加载
	var page = 1;
	var cwid = $("#cwid").attr("value");
	var url = "/troom/course/getajaxpage.html";
	page_load(page,url);
})
</script>
</head>
<body>

<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--账号类型-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<div style="margin:0 auto;width:980px;">
<div class="cright_cher" style="width:980px;margin-bottom:20px;">
<div class="ter_tit" >
    当前位置 > <a href="<?= geturl('troom/subject') ?>" >课程列表</a> > <a href="<?= geturl('troom/subject/' . $course['folderid']) ?>"><?= $course['foldername'] ?></a> >  <?= $course['title'] ?>
</div>
<div class="lefrig">
    <div class="classbox" style="margin-top:10px;width:978px;background: #FFF;">
        <h1 style="font-weight: bold;color:#666;text-align: center;"><?= $course['title'] ?></h1>
        <div class="classboxmore" style="width:925px;">
            <p>主讲：<?= $course['realname'] ?>
			<?php $viewnumlib = Ebh::app()->lib('Viewnum');
					$viewnum = $viewnumlib->getViewnum('courseware',$course['cwid']);?>
                <span>时间：<?= date('Y.m.d', $course['dateline']) ?></span><span>人气：<?= $viewnum?></span>
            </p>
            <p>摘要：<?= $course['summary'] ?></p>

            <p style="padding:10px;">
                <?php if (!empty($course['cwurl']) && $type != 'flv' && $type != 'mp3' && $type != 'ebh' && $type != 'ebhp') { ?>
                    <a class="huangbtn marrig" href = "<?= $course['cwsource'] . 'attach.html?cwid=' . $course['cwid'] ?>">下载</a>
                <? } ?>
                 <!--   <a class="huangbtn" href = "<?= geturl('troom/course/upattach-0-0-0-' . $course['cwid']) ?>">上传附件</a>-->
                </p>
            </div>
        </div>
        
		<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
				<div style=" position: relative;height:740px;z-index:601;float:left;">
				<div id="playcontrol" style="width:700px;height:428px;"></div>
				</div>
		<?php } ?>
		<?php if ($type == 'flv' || $type == 'mp3') { ?>
			<?php if($type == 'mp3') {?>
            <div style="color:red;position: relative;height:400px;z-index:601;float:left;;margin-top:5px;">
			<?php } else { ?>
			<div style="color:red;position: relative;height:560px;z-index:601;float:left;margin-top:5px;">
			<?php } ?>
                <div id="flvcontrol" style="width:980px;height:560px;">
				<span style="margin-left:200px;font-size:18px;line-height:300px;color:#000">您还没有安装flash播放器,请点击<a href="http://www.adobe.com/go/getflash" target="_blank" style="color:red;font-weight:bold;">这里</a>安装</span>
				</div>

            </div>
        <?php } ?>
        <div id='atsrc' style="display: none;"></div>

		<?php if(preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])){ ?>
			<?php if(!empty($user)){ ?>
					<?php $domain=$this->uri->uri_domain();
					$cloudurl='http://'.$domain.'.ebanhui.com';
				 if($domain=='www' || !empty($free)){ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
					<?php }else{ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')"  class="borlanbtn" value="播放"></div>
					<?php } ?>	
			<?php }else{ ?>
					<div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',<?= $course['isfree']?>)"  class="borlanbtn" value="播放"></div>
			<?php } ?>
			<div class="tieziss" style="font-size:14px;line-height:26px;">您也可以切换到ebh播放器,更方便快捷</div>
		<?php } ?>

<?php if(!empty($exams)) { ?>
        <div class="introduce" style="width:978px;">
		<div class="intitle" style=" width: 978px;"><h2><a id="rid">在线作业</a></h2></div>
            <div class="incont" style="width:978px;">
		<table width="100%" class="datatab" style="width:978px;border:none;">
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
                        <?php if($roominfo['isschool']==2){?>
						    <a class="workBtn" href="http://exam.ebanhui.com/edit/<?=$exam['eid']?>.html" target="_blank"><span>编辑</span></a>
						    <a class="workBtn" href="javascript:void(0)" onclick="delexam(<?=$exam['eid']?>,<?= $course['cwid']?>,'<?= str_replace('\'','',$exam['title'])?>')"><span>删除</span></a>
					    <? }else{?>
                            <?php if($user['uid']==$exam['uid']){?>
                                <a class="workBtn" href="http://exam.ebanhui.com/eedit/<?=$roominfo['crid']?>/<?=$exam['eid']?>.html" target="_blank"><span>编辑</span></a>
                                <a class="workBtn" href="javascript:void(0)" onclick="delexam2(<?=$exam['eid']?>,<?= $roominfo['crid']?>)"><span>删除</span></a>
                            <?php }else{?>
                                <a class="workBtn" href="http://exam.ebanhui.com/ado/<?=$exam['eid']?>.html" target="_blank"><span>查看</span></a>
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
		 <?php if(!empty($course['message'])){ ?>
        <div class="introduce" style="width:978px;padding-top: 10px;float:left;">
            <div class="intitle" style="width:978px;"><h2><a id="rid">课件介绍</a></h2></div>
            <div class="incont" style="width:978px;">
                <?= $course['message'] ?>
            </div>
        </div>
		<?php } ?>
        <?php if (!empty($attachments)) { ?>
            <div class="introduce" style="width:978px;padding-top: 10px;float:left;">
                <div class="intitle" style="width:978px;"><h2><a id="rid">附件下载</a></h2></div>
                <div class="incont">
                    <table width="100%" class="datatab" style="width:978px;border:none;">
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
                                            <td width="65%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
                                        <?php } else { ?>
                                            <td width="65%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
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
        <div class="introduce" style="width:978px;">
            <div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
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
                            <dd style="width:870px;">
                                <div class="apptit"><span><a style="margin-right:10px;color:#999999;" href="javascript:shield(<?= $course['cwid']?>,<?= $review['logid']?>);">屏蔽</a><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
                                <div class="grade">总体评分: 
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
                                </div>
                                <p id="review_<?= $review['logid'] ?>"><?= $review['subject'] ?></p>
                                <?php if (!empty($review['rsubject'])) { ?>
                                    <div class="restore">
                                        <div class="restore_arrow">◆</div>
                                        <div class="restore_cont"><h1>我的回复：</h1><?= $review['rsubject'] ?></div>
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
                        <div id="nocommentdiv" style="width:100%;height:200px;">暂无任何评论</div>
                    </dl>
                <?php } ?>
            </div>
            <?= $pagestr ?>

        </div></div>
		<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>
				<div class="introduce" style="width:978px;">
            <div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
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
                            <dd style="width:650px;">
                                <div class="apptit"><span><a style="margin-right:10px;color:#999999;" href="javascript:shield(<?= $course['cwid']?>,<?= $review['logid']?>);">屏蔽</a><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
                                <div class="grade">总体评分: 
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
                                    <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
                                </div>
                                <p id="review_<?= $review['logid'] ?>"><?= $review['subject'] ?></p>
                                <?php if (!empty($review['rsubject'])) { ?>
                                    <div class="restore">
                                        <div class="restore_arrow">◆</div>
                                        <div class="restore_cont"><h1>我的回复：</h1><?= $review['rsubject'] ?></div>
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
                        <div id="nocommentdiv" style="width:100%;height:200px;">暂无任何评论</div>
                    </dl>
                <?php } ?>
            </div>
            <?= $pagestr ?>

        </div></div>
			<?php } ?>
		<?php } ?>
</div>
</div>
    <script type="text/javascript">
  

	//播放
   $(function (){
			var cwid = <?= $course['cwid'] ?>;
			var isfree = 1;
			var num = 1;//教室内
			if(<?= $user['groupid']?> == 6){
				var hasbtn = 1;
			}else{
				var hasbtn = 0;
			}
			<?php if($type == 'flv') { ?>
				//flv
				<?php 
					if(!empty($course['m3u8url'])) {
				?>
					playmu('<?= $course['m3u8url'] ?>',cwid,'',isfree,num,'562','978',hasbtn,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>);
				<?php 
					} else if(!empty($course['rtmpurl'])) {
				?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','978',hasbtn,'<?= $course['thumb'] ?>');
				<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','978',hasbtn);
				<?php } ?>
			<?php } else if($type == 'mp3'){ ?>
				//ebh
				playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','978',1);
			<?php } else if($type == 'ebh' || $type == 'ebhp'){ ?>
				//ebh
				freeebh('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'700','978',1);
			<?php } ?>
	});

   

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
	//屏蔽
	function shield(cwid,logid){
		$.confirm("您确定要屏蔽该评论吗？屏蔽后不可查看该评论!", function() {
				var url = "<?= geturl('aroomv2/review/shield')?>";
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
	<?php }else{ ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js?v=0207"></script>
	<?php } ?>
    <?php $this->display('troom/page_footer'); ?>