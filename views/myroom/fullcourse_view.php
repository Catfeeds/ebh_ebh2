<?php $this->display('myroom/page_header');?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js"></script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>

		<div class="ter_tit">
		当前位置 > <?php if($helpcrid != $moduleid) { ?><a href="<?= geturl('myroom/fullcourse-0-0-0-'.$moduleid) ?>">所有课程</a> > <?php } ?><?=$course['foldername']?> > <?= $course['title'] ?>
		</div>
	<div class="lefrig" style="margin-top:10px;">

			<div class="classbox">
				<h1>课件名:<?= $course['title'] ?></h1>
				<div class="classboxmore">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname']?>    <span>时间：<?=  date('Y.m.d',$course['dateline'])?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px 0;">
					<?php if( preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) { ?>
						<?php if ($roominfo['isschool'] == 4) { ?>
						<input name="" onclick="playdemand('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',1,0)" class="huangbtn marrig" value="开始听课" type="button" />
						<?php } else { ?>
						<input name="" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
						<?php } ?>
					<?php } else if(!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<input name="" onclick="location.href='<?= $course['cwsource'].'attach.html?cwid='.$course['cwid'].'&fromid='.$roominfo['crid']?>'" class="lanbtn marrig" value="下载文件" type="button" />
					<?php } ?>
					<input name="" class="lanbtn" onclick="javascript:history.back();" value="返回" type="button" />
					</p>
				</div>
			</div>
			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){?>
				<div style=" position: relative;height:600px;z-index:601;float:left;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
			<?php if(!empty($exams)) { ?>
			<div class="work_menuss" style="float:left;">
					<ul>
					<li class="workcurrent"><a style="font-size:12px;"><span>在线测评</span></a></li>
					</ul>
			</div>
				<div class="incont">
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
			<div class="work_menuss" style="float:left;">
					<ul>
					<li class="workcurrent"><a style="font-size:12px;"><span>课件介绍</span></a></li>
					</ul>
			</div>
			<div class="incont" style="margin-left:15px;">
					<?= $course['message'] ?>
			</div>
			<div id='atsrc' style="display: none;"></div>
			

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
			height = 65;
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
    $(function(){
		var cwid = <?= $course['cwid'] ?>;
		var source = "<?= $course['cwsource'] ?>";
        var isfree = <?= $course['isfree'] ?>;
        var num = 1; //教室内
        playflv(source,cwid, '', isfree, num, '562', '747');
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
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
$(function(){
	if(window.parent != undefined) {
		window.parent.showDivModel(".nelame");
	}
});
<?php } ?>
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>
<?php 
$this->display('myroom/player');
$this->display('troom/page_footer');
?>