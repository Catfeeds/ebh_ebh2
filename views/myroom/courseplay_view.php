<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>

</head>
<body>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js"></script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
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
			var cwid = <?= $course['cwid']?>;
			var isfree = <?= $course['isfree'] ?>;
			var num = 1;//教室内
			var cwname = '<?= $course['cwname'] ?>';
			var suffix = cwname.split('.');
			var lastsuffix = suffix[suffix.length-1];
			if(lastsuffix == 'flv'){
				var abc = '<?= $course['cwsource'] ?>';
				//flv
				playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','958',1);
			}else if (lastsuffix == 'ebh' || lastsuffix == 'ebhp'){
				//ebh
				freeebh('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'700','958',1);
			}
		});

	//听课完成回调
	function messfun(ctime,ltime){//ctime:总时间；ltime：有效时间
		var cwid = <?= $course['cwid'] ?>;
		return studyfinish(cwid,ctime,ltime);
	}
		</script>
		
<div class="cright" style="float:none;display: block;margin: 0 auto;width:980px;">
		<div class="ter_tit">
		当前位置 > 所有课程 > <?=$course['foldername']?> > <?= $course['title'] ?>
		</div>
	<div class="lefrig" style="margin-top:10px;">

			<div class="classbox" style="width:958px;">
				<h1>课件名:<?= $course['title'] ?></h1>
				<div class="classboxmore" style="width:929px;">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname']?>    <span>时间：<?=  date('Y.m.d',$course['dateline'])?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px 0;">
					<?php if(!empty($course['cwurl']) && !preg_match('/.*(\.flv|\.ebh|\.ebhp)$/',$course['cwurl'])) { ?>
		
						<input name="" onclick="location.href='<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>'" class="lanbtn marrig" value="下载文件" type="button" />
		
					<?php } ?>
					<input type="button" class="lanbtn" value="收藏" id="favorite" />
					</p>
				</div>
			</div>
			<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
				<div style=" position: relative;height:700px;z-index:601;float:left;">
				<div id="playcontrol" style="width:960px;height:400px;"></div>
				</div>
			<?php } ?>
			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){?>
				<div style=" position: relative;height:600px;z-index:601;float:left;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
	
			<?php if(!empty($exams)) { ?>
			<div class="work_menuss" style="width:958px;">
					<ul>
					<li class="workcurrent"><a style="font-size:12px;"><span>在线测评</span></a></li>
					</ul>
			</div>
				<div class="incont" style="width:958px;">
						<table width="100%" class="datatab">
							<thead class="tabhead">
								<tr>
									<th>作业名称</th>
									<th>出题时间</th>
									<th>总分</th>
									<th>操作</th>
							 	</tr>
							  </thead>
								<tbody>
											 <?php foreach($exams as $exam) { ?>
											  <tr>
												<td width="60%"><?= $exam['title'] ?></td>
												<td width="20%"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
												<td width="5%"><?= $exam['score'] ?></td>
												<td width="15%">
														<a class="previewBtn" href="http://exam.ebanhui.com/do/<?= $exam['eid'] ?>.html" target="_blank"><span>在线答题</span></a>
												</td>
											  </tr>
											  <?php } ?>
							  </tbody>
						</table>
					
				</div>
			<?php } ?>
			<div class="work_menuss" style="float:left;width:958px;margin-top:20px;">
					<div class="intitle">
					<h2>课件介绍
					<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){ ?><div class="tieziss"><input type="button" onclick="document.getElementById('flvcontrol').callflashvideo()" class="borlanbtn" value="提交学习时间"></div><?php } ?>
					<?php if(preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])){ ?><div class="tieziss"><input type="button" onclick="document.getElementById('playcontrol').callflashvideo()" class="borlanbtn" value="提交学习时间"></div><?php } ?>
					<?php if(preg_match("/.*(\.ebh|\.ebhp)$/",$course['cwurl'])){ ?><div class="tieziss"><input type="button" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')"  class="borlanbtn" value="开始播放"></div><?php } ?>
					
					<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
					<div class="tieziss" style="font-size:14px;line-height:26px;"><span style="float:left;">可以用ebh播放器播放(如未安装，请点击</span><a style="display:block;width:40px;float:left;text-align:center;" href="http://soft.ebanhui.com/ebhsetup.exe">下载</a>安装)</div>
					<?php } ?>
					</h2>
				</div>
			</div>
			<div class="incont" style="width:958px;">
					<?= $course['message'] ?>
			</div>
			<a name="fujian" href="javascript:void(0);"></a>

			<?php if (!empty($attachments)) { ?>
			<div class="introduce">
				<div class="intitle">
					<h2>附件下载</h2>
				</div>
						
				<div class="incont" style="width:958px;">
						<table width="100%" class="datatab">
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
			<div id='atsrc' style="display: none;"></div>
			<div class="introduce">
				<div class="intitle"><h2>课件评论</h2></div>
			  <div class="appraise" >
			  		
				<?php if (!empty($reviews)) { ?>
					<?php foreach ($reviews as $review) { ?>
                       <?php
                        if ($review['sex'] == 1)
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg';
                        else
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg';
                        $face = empty($review['face']) ? $defaulturl : $review['face'];
                        $face = getthumb($face, '50_50');
                        ?>
			  		<dl>
						<dt><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['username'] ?>" /></div></dt>
						<dd>
						<div class="apptit"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['username'] . '(' . $review['realname'] . ')' ?></b></div>
						<div class="grade">总体评分: 
						<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
                        <?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
						</div>
						<p><?= $review['subject'] ?></p>
						<?php if (!empty($review['rsubject'])) { ?>
						<div class="restore" style="margin-left:35px;">
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
				  <div class="fill">
						<p class="pl">我来评论  　　满意度：<input id="mark" name="mark" type="hidden" value="0"><em onmouseover="rate(this,event)">
						<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很烂">
						<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="一般">
						<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="还好">
						<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="较好">
						<img style="cursor: pointer;" class="cstar" src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif" title="很好">
						</em></p>
						<p><textarea id="comm" name="comm" cols="" style="resize:none;" rows="" class="pltext"></textarea></p>
						<p class="plogin" style="width:470px;">
						<span><input name="review" class="plBtn" value="评论" type="button" onclick="comment()" /></span>
						(1-100字) </p>
				  </div>
			  </div>
</div>

<div style="display:none;" class="Offl" id="showdiv"></div>
<?php 
	$this->display('myroom/player');
	$this->display('myroom/page_footer');
?>

</div>
<script defer="defer" type="text/javascript">	
$(function(){
        $('#atsrc').dialog({
			autoOpen: false,
            resizable:false,
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
			$("#atsrc").html(playtype('mp3', attid));
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
			objhtml += '<object type="application/x-shockwave-flash" data="' + url + attid + '" width="100%" height="100%">'
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
			var objhtml ='<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/ebh/flash/rect.swf?mp3='+encodeURIComponent(url)+'&autostart=1&autoplay=1" width="240" height="20" id="dewplayer-rect">'
				objhtml +='<param name="wmode" value="transparent" />'
				objhtml +='<param name="movie" value="http://static.ebanhui.com/ebh/flash/rect.swf?mp3='+encodeURIComponent(url)+'" />'
				objhtml +='</object>'
		}
		return objhtml;
    }
function closeLightFun(opens){	//开关灯方法
	
	$("#showdiv").css("height", $(document).height());
		if(opens==1){
			$("#showdiv").toggle();  
		}
		else if((opens==2)){
			$("#showdiv").toggle(); 
		}
}

//取星星
function getstar(num)
{	
	var starword='';
	num=parseInt(num);
	if(num>5)
	{
		num=5;
	}
	for(i =0;i<num;i++)
	{
		starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif'/>";
	}
	if(5-num>0)
	{
		for(j =0;j<5-num;j++)
		{
			starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif'/>";
		}
	}
	return starword;
	
}
	

//发表评论

function comment(){
	var comm = $.trim($("#comm").val());
	var mark = $("#mark").val();
	if(comm==''){
		alert('发表内容不能为空。');
		$("#comm").focus();
		return false;
	}else if(comm.length>100){
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
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg';
                        else
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg';
                        $face = empty($user['face']) ? $defaulturl : $user['face'];
                        $face = getthumb($face, '50_50');
				?>
				var face = "<?= $face ?>";
				var username = "<?= empty($user['realname']) ? $user['username'] : $user['realname'] ?>";
				$("#nocommentdiv").remove();	
				$(".appraise").prepend('<dl>'
						+"<dt><div class=\"userimg\"><img width=\"50px\" height=\"50px\" src="+face+" /></div></dt>"
						+'<dd>'
						+"<div class=\"apptit\"><b>"+username+"</b></div>"
						+'<div class="grade">总体评分:'+getstar(document.getElementById('mark').value) 
						+'</div>'
						+'<p>'+fiterscr($.trim(comm).substr(0,100))+'</p>'
						+'</dd></dl>');
				$("#comm").val("");
				$("#mark").val("0");
				$(".cstar").attr("src","http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif");
				//top.resetmain();
				 window.location.reload();
			}
			else
			{
				alert(result.msg);
			}
		}
	});
}

//chose star
function rate(obj,oEvent){
	var imgSrc = 'http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif';
	var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif';
	if(obj.rateFlag) return;
	var e = oEvent || window.event;
	var target = e.target || e.srcElement;
	var imgArray = obj.getElementsByTagName("img");
	for(var i=0;i<imgArray.length;i++){
	   imgArray[i]._num = i;
	   imgArray[i].onclick=function(){
	    if(obj.rateFlag) return;
		var inputid=this.parentNode.previousSibling
		inputid.value=this._num+1;
	   }
	}
	if(target.tagName=="IMG"){
	   for(var j=0;j<imgArray.length;j++){
	    if(j<=target._num){
	     imgArray[j].src=imgSrc_2;
	    } else {
	     imgArray[j].src=imgSrc;
	    }
		target.parentNode.onmouseout=function(){
		var imgnum=parseInt(target.parentNode.previousSibling.value);
			for(n=0;n<imgArray.length;n++){
				imgArray[n].src=imgSrc;
			}
			for(n=0;n<imgnum;n++){
				imgArray[n].src=imgSrc_2;
			}
		}
	   }
	} else {
		 return false;
	}
	}	
function fiterscr(str)
{	
		
	while (str.indexOf('>') >= 0)
	{
	   str = str.replace('>', '&gt');
	}
	while (str.indexOf('<') >= 0)
	{
	   str = str.replace('<', '&lt');
	}
	return str;
}

</script>