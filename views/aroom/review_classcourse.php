<?php $this->display('aroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>

.appraise dl dd {
    border-left: 0px solid #eeeeee;
    border-top: 1px solid #eeeeee;
    float: left;
    height: auto !important;
    min-height: 98px;
    width: 691px;
}
</style>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--账号类型-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<div class="ter_tit">
    当前位置 > <a href="<?= geturl('aroom/review') ?>" >评论查看</a> > <?= $course['title'] ?>
</div>
<div class="lefrig">
    <div class="classbox" style="margin-top:10px;">
        <h1 style="font-weight: bold;color:#666;">课件名:<?= $course['title'] ?></h1>
        <div class="classboxmore">
            <p>主讲：<?= $course['realname'] ?>
                <span>时间：<?= date('Y.m.d', $course['dateline']) ?></span>
            </p>
            <p>摘要：<?= $course['summary'] ?></p>

            <p style="padding:10px;">
                 <?php if (preg_match("/.*(\.ebh|\.ebhp)$/", $course['cwurl'])) { ?>

                    <input type="button" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>, '<?= str_replace("'", " ", $course['title']) ?>');" class="huangbtn marrig" value="开始播放" name="" />
                <?php } else if (preg_match("/.*(\.flv)$/", $course['cwurl'])) { ?>

                <?php } else if (!empty($course['cwurl'])) { ?>
                    <a class="huangbtn marrig" href = "<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>">下载文件</a>
                    <? } ?>

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
        <div class="introduce" style="padding-top: 10px;float:left;width:786px;">
            <div class="intitle"><h2><a id="rid">课件介绍</a></h2></div>
            <div class="incont">
                <?= $course['message'] ?>
            </div>
        </div>

        <?php if (!empty($attachments)) { ?>
            <div class="introduce" style="padding-top: 0px;float:left;width:786px;">
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
                                            <td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= $course['cwsource'].'attach.html?attid='.$atta['attid'] ?>" ><?= $atta['title'] .'.'.$atta['suffix'] ?></a></span></td>
                                        <?php } else { ?>
                                            <td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= $atta['source'] ?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] .'.'. $atta['suffix'] ?></a></span></td>
                                        <?php } ?>
                                    <?php } ?>
                                    <td width="17%"><?= Date('Y-m-d H:i', $atta['dateline']) ?></td>
                                    <td width="10%">
                                        <?php if ($atta['status'] == 0) { ?>
                                            <font color="#ff6600">未审核</font>
                                        <?php } else if ($atta['status'] == 1) { ?>
                                            <font color="#008000">审核通过</font>

                                        <?php } else if ($atta['status'] == -1) { ?>
                                            <font color="#a7a7a7">审核未通过</font>
                                        <?php } ?>
  
                                    </td>

                                    <?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
                                        <td width="10%">
                                            <?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
                                                <input class="previewBtn" onclick="location.href = '<?= $course['cwsource'].'attach.html?attid='.$atta['attid'] ?>'" name="" value="下载附件" type="button" />
                                            <?php } else { ?>
                                                <input type="hidden" id="aid<?= $atta['attid'] ?>" value="<?= $atta['attid'] ?>" />
                                                <a class="atfalsh" href="javascript:void(0);" title="<?= $atta['title']?>" source="<?= $atta['source'] ?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
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

       <?php if($roominfo['crid']!=10420){ ?>
        <div class="introduce" style="width:786px;">
            <div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
            <div class="appraise">
              
                <?php if(!empty($reviews)) { ?>
               
                <?php foreach($reviews as $review) { ?>
                <?php
                        if ($review['sex'] == 1)
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                        else
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                        $face = empty($review['face']) ? $defaulturl : $review['face'];
                        $face = getthumb($face, '50_50');
                        ?>
                <dl>
                            <dt style="width:65px;"><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
                            <dd>
                                <div class="apptit"><span><a style="margin-right:10px;color:red;" href="javascript:shield(<?= $course['cwid']?>,<?= $review['logid']?>);">屏蔽</a><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
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
                                        <?php if ($course['uid'] == $user['uid']) { 
										$subject = str_replace('"','\"',$review['subject']);
										$subject = str_replace("\n","",$subject);
										$subject = str_replace("\r","",$subject);
										?>
											<?php if($user['uid']!=$review['uid']){ ?>
												<input class="replyBtn" style="cursor:pointer;"  type="button" onclick='reply("<?=$subject ?>", "<?= $course['title'] ?>", "<?= $review['logid'] ?>", "courseware", "<?= $course['cwid'] ?>")' value="回复" />
											<?php } ?>
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
        </div>
		<?php }else{ ?>
			<?php if($roominfo['isschool']!=3){ ?>
				 <div class="introduce">
					<div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
					<div class="appraise">
					  
						<?php if(!empty($reviews)) { ?>
					   
						<?php foreach($reviews as $review) { ?>
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
										<div class="apptit"><span><a style="margin-right:10px;color:#999999;" href="javascript:shield(<?= $course['cwid']?>,<?= $review['logid']?>)">屏蔽</a><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
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
							<div id="nocommentdiv" style="width:100%;height:200px;">暂无任何评论</div>
						</dl>
						<?php } ?>
						

					</div>
				<?= $pagestr ?>
				</div>
			<?php } ?>

	<?php } ?>
		</div>


    <script type="text/javascript">
    $(function(){
        $('#atsrc').dialog({
			autoOpen: false,
            resizable:false,
			draggable:false,
            type:'post',
            zIndex:"400",
			modal: false//模式对话框
         });
         $(".atfalsh").click(function(){
			var attid = $(this).attr('aid');
			var source = $(this).attr('source');
			var suffix = $(this).attr('suffix');
			var title = $(this).attr('title');
			playatt(source,attid,suffix,title);
		});
	});
	function playatt(source,attid,suffix,title) {
		var width = 600;
		var height = 540;
		if (suffix == 'swf'){
			$("#atsrc").html(playtype(source,'swf', attid));
        } else if (suffix == 'flv') {
			$("#atsrc").html(playtype(source,'flv', attid,width, height));
        } else {
			width = 250;
			height = 100;
			$("#atsrc").html(playtype(source,'mp3', attid));
        }

		$('#atsrc').dialog("option", "title", title);
        if (suffix == 'flv'){
			$('#atsrc').dialog("option", "width", width + 10);
			$('#atsrc').dialog("option", "height", height + 50);
        } else {
			var isMobile = false;
            if (isMobile){
				$('#atsrc').dialog("option", "width", 310);
				$('#atsrc').dialog("option", "height", 81);
            } else{
				$('#atsrc').dialog("option", "width", width);
                $('#atsrc').dialog("option", "height", height);
            }
		}

        $("#atsrc").dialog({
			close: function() {
				$("#atsrc").html('');
            }
        });
        $('#atsrc').dialog("open");
			return;
	}
    $(function (){
            var cwid = <?= $course['cwid'] ?>;
            var isfree = <?= $course['isfree'] ?>;
            var num = 1;//教室内
            playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','750');
    	
    });
     
    function playtype(source,type, attid, width, height){
		var url = source + "attach.html?attid=" + attid;
		if (type == 'swf'){
			var objhtml = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="Main">'
			objhtml += '<param name="movie" value="' + url + '" />'
			objhtml += '<param name="quality" value="high" />'
			objhtml += '<param name="bgcolor" value="#869ca7" />'
			objhtml += '<param name="allowScriptAccess" value="sameDomain" />'
			objhtml += '<param name="allowFullScreen" value="true" />'
			objhtml += '<!--[if !IE]>-->'
			objhtml += '<object type="application/x-shockwave-flash" data="' + url + '" width="100%" height="100%">'
			objhtml += '<param name="quality" value="high" />'
			objhtml += '<param name="bgcolor" value="#869ca7" />'
			objhtml += '<param name="allowScriptAccess" value="sameDomain" />'
			objhtml += '<param name="allowFullScreen" value="true" />'
			objhtml += '<!--<![endif]-->'
			objhtml += '<!--[if gte IE 6]>-->'
			objhtml += '<p>'
			objhtml += 'Either scripts and active content are not permitted to run or Adobe Flash Player version'
			objhtml += '10.0.0 or greater is not installed.'
			objhtml += '</p>'
			objhtml += '<!--<![endif]-->'
			objhtml += '<a href="http://www.adobe.com/go/getflashplayer">'
			objhtml += '<img src="/static/images/get_flash_player.gif" alt="Get Adobe Flash Player" />'
			objhtml += '</a>'
			objhtml += '<!--[if !IE]>-->'
			objhtml += '</object>'
			objhtml += '<!--<![endif]-->'
			objhtml += '</object>'
		} else if (type == 'flv'){
			var objhtml = ''
			objhtml += '<object id=flvcontrol style="VISIBILITY: visible" height=' + height + ' width=' + width + ' classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000>'
			objhtml += '<param name="FlashVars" value="source=' + encodeURIComponent(url) + '&classover=0">'
			objhtml += '<param name="movie" value="http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf">'
			objhtml += '<param name="src" value="http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf">'
			objhtml += '<param name="quality" value="high">'
			objhtml += '<param name="allowScriptAccess" value="always" />'
			objhtml += '<param name="allowFullScreen" value="true" />'
			objhtml += '<!--[if !IE]>-->'
			objhtml += '<object id="blog_index_flash_ff" data="http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf" style="visibility: visible;" width="' + width + 'px" height="' + height + 'px">'
			objhtml += '<param name="movie" value="http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf">'
			objhtml += '<param name="quality" value="high">'
			objhtml += '<param name="allowFullScreen" value="true" />'
			objhtml += '<param name="FlashVars" value="source=' + encodeURIComponent(url) + '&classover=0"/>'
			objhtml += '<param name="allowScriptAccess" value="sameDomain" />'
			objhtml += '<param name="allowFullScreen" value="true" />'
			objhtml += '<!--<![endif]-->'
			objhtml += '</object>'
		} else{
			var isMobile = false;
			var browser = 'iPad';
			if(isMobile){
				var style = ((browser=='iPad' || browser=='iPhone'|| browser=='iPod')?'style="height:40px"':'');
				var objhtml ='<audio src="'+url+attid+'" autoplay="autoplay" controls="controls" preload="preload" '+style+'></audio>';
			}else{
				var objhtml ='<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/ebh/flash/rect.swf?mp3='+url+'&autostart=1&autoplay=1" width="240" height="20" id="dewplayer-rect">'
					objhtml +='<param name="wmode" value="transparent" />'
					objhtml +='<param name="movie" value="http://static.ebanhui.com/ebh/flash/rect.swf?mp3='+url+'" />'
					objhtml +='</object>'
			}
		}
		return objhtml;
    }
    function ablank(url){
            window.open(url);
    }


    function closeLightFun(opens){	//开关灯方法
            //if(opens==1){
            //	parent.closeLFun(opens);  
            //	$("#flvcontrol").toggle();
            //}
            //else if((opens==2)){
            //	parent.closeLFun(opens);
            //	$("#flvcontrol").toggle();
            //}
            $("#showdiv").css("height", $(document).height());
                    if(opens==1){
                            $("#showdiv").toggle();  
                    }
                    else if((opens==2)){
                            $("#showdiv").toggle(); 
                    }
    }
    $(function(){
		buttons = {"确定": function() {submit_refuse();$(this).dialog("close");},"取消": function() {$("#repcontent").val(""); $(this).dialog("close");   }};
		$('.commentdiv').dialog({
			autoOpen: false,
			title:'回复评论',
			buttons:buttons,
			width: 480,
			resizable:false,
			type:'post',
			close:function(){$("#repcontent").val("");},
			modal: true//模式对话框
		});
	});

    function reply(content,target,logid,type,toid)
	{

		$("#type").val(type);
		$("#toid").val(toid);
		$("#target").text(target);
		$("#logid").val(logid);
		var reg = /<[^>]+>/gi;  // 正则表达式
		$("#content").text(content.replace(reg,''));
		$(".commentdiv").dialog("open");	
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
				} else {
					$("#msg").text(_json.msg);
				} 
							
			}
		})		
	}

	//屏蔽
	function shield(cwid,logid){
		$.confirm("您确定要屏蔽该评论吗？屏蔽后不可查看该评论!", function() {
				var url = "<?= geturl('aroom/review/shield')?>";
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
    <?php $this->display('common/player'); ?>
    <?php $this->display('troom/page_footer'); ?>