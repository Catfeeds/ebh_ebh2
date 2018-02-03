<?php 
$this->assign('notop',TRUE);
$this->display('myroom/page_header'); ?>
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
			var isfree = 1;
			var num = 1;//教室内
			playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','750',1);
		});
		//听课完成回调
		function messfun(ctime,ltime){
			var cwid = <?= $course['cwid'] ?>;
			return studyfinish(cwid,ctime,ltime);
		}
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
	当前位置 > 学习课程 > <?= $course['foldername'] ?> > <?= $course['title']?>
</div>
<div class="lefrig" style="margin-top:10px;">
			<div class="classbox">
				<h1>课件名:<?= $course['title']?></h1>
				<div class="classboxmore">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;">
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
						<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
						<?php } ?>
					<?php } elseif (!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下载文件</a>
					<?php } ?>
					<?php if(empty($hasnobtn) || $hasnobtn != TRUE) { ?>
					<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返回" type="button" />
					<input type="button" class="lanbtn" value="收藏" id="favorite" />
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
			<div class="introduce" style="padding-top:0px;">
				<div class="intitle">
					<h2>课件介绍<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){ ?><div class="tieziss"><a href="javascript:void(0)" onclick="document.getElementById('flvcontrol').callflashvideo()" class="borlanbtn">提交学习时间</a></div><?php } ?></h2>
				</div>
			  	<div class="incont">
					<?= $course['message'] ?>
				</div>
			</div>
			<a name="fujian" href="javascript:void(0);"></a>

			<?php if (!empty($attachments)) { ?>
			<div class="introduce">
				<div class="intitle">
					<h2>附件下载</h2>
				</div>
						
				<div class="incont">
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
										<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= $atta['source'] . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } else { ?>
										<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
									<?php } ?>
								<?php } ?>
									<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
									<td></td>
									<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
									<td>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<input class="previewBtn" onclick="location.href = '<?= $atta['source'] . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载附件" type="button" />
										<?php } else { ?>
						   					<a class="atfalsh" href="javascript:void(0);" source="<?= $atta['source'] ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
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
			
			
			<div class="introduce">
				<div class="intitle"><h2><?= ($roominfo['domain'] != 'bndx')?'课件评论':'课程评论' ?></h2></div>
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

<script defer="defer" type="text/javascript">

function CurentTime()
{ 
    var now = new Date();
   
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
   
    var hh = now.getHours();            //时
    var mm = now.getMinutes();          //分
    var ss = now.getSeconds();          //秒
    var clock = year + "-";
   
    if(month < 10)
        clock += "0";
   
    clock += month + "-";
   
    if(day < 10)
        clock += "0";
       
    clock += day + " ";
   
    if(hh < 10)
        clock += "0";
       
    clock += hh + ":";
    if (mm < 10) clock += '0'; 
    clock += mm+":"; 
    clock+= ss;
    return(clock); 
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
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                        else
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                        $face = empty($user['face']) ? $defaulturl : $user['face'];
                        $face = getthumb($face, '50_50');
				?>
				var face = "<?= $face ?>";
				var username = "<?= empty($user['realname']) ? $user['username'] : $user['realname'] ?>";
				$("#nocommentdiv").remove();	
				$(".appraise").prepend('<dl>'
						+"<dt><div class=\"userimg\"><img width=\"50px\" height=\"50px\" src="+face+" /></div></dt>"
						+'<dd>'
						+"<div class=\"apptit\"><span>"+CurentTime()+"</span><b>"+username+"</b></div>"
						+'<div class="grade">总体评分:'+getstar(document.getElementById('mark').value) 
						+'</div>'
						+'<p>'+fiterscr($.trim(comm).substr(0,100))+'</p>'
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
<?php if ($roominfo['isschool'] == 6 && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		window.parent.showDivModel(".nelame");
	}
});
<?php } ?>
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>
<?php $this->display('myroom/player'); ?>
<?php $this->display('myroom/page_footer'); ?>