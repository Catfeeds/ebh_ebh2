<?php $this->display('aroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
		<script type="text/javascript">
		
		
		//flv播放
		$(function (){
			var cwid = <?= $course['cwid'] ?>;
			var isfree = 1;
			var num = 1;//教室内
			playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','750');
		});
		//听课完成回调
		function messfun(ctime,ltime){
			var cwid = <?= $course['cwid'] ?>;
			return studyfinish(cwid,ctime,ltime);
		}
	
		<?php if(($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7 ) && $ckresult == 2) { ?>
		$(function(){
			if(window.parent != undefined) {

				window.parent.showDivModel(".nelame");
			}
		});
		<?php } ?>
		</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
		
		<div class="ter_tit">
	当前位置 > <a href="<?= geturl('aroom/ateacourse') ?>" >教师课件查看</a> > <?= $course['title']?>
</div>
<div class="lefrig" style="margin-top:10px;">
			<div class="classbox">
				<h1>课件名:<?= $course['title']?></h1>
				<div class="classboxmore">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;">
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
					<?php } elseif (!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下载</a>
					<?php } ?>
					<input name="" class="lanbtn marrig" onclick="javascript:history.back();" value="返回" type="button" />
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
					<h2>课件介绍<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){ ?><div class="tieziss"></div><?php } ?></h2>
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
			
			
			<div class="introduce">
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
function closeLightFun(opens){	//开关灯方法
	
	$("#showdiv").css("height", $(document).height());
		if(opens==1){
			$("#showdiv").toggle();  
		}
		else if((opens==2)){
			$("#showdiv").toggle(); 
		}
}
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>
<?php $this->display('common/player'); ?>
<?php $this->display('myroom/page_footer'); ?>