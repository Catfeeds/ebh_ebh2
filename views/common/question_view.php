<?php
$this->display('common/header');
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/yinan.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
	$('.photo_photolist_img a').lightBox();
});
</script>
<style>
	.zhumai a.tijiaobtn {
    background:#18a8f7;
    display: block;
    float: right;
    height: 32px;
	line-height:32px;
	text-align:center;
	text-decoration: none;
	color: #FFFFFF;
    cursor: pointer;
	font-size: 14px;
    font-weight: bold;
	margin-top:10px;
    width: 116px;
}
.zhumai a.tijiaobtn:hover {
	color:fff;
	background:#0d9be9;
}
</style>
</head>
<body>


<?php $qid = $this->uri->itemid; ?>

<div class="toptitnew" style="margin: 0 auto;"><a href="/yun1.html">云教学平台</a> > 互动答疑</div>
	<div class="waimin">
		<div class="lefyuan">
			<div class="wentix">
				<div style="height:16px;">
					<div id="playercontainer"></div>
				</div>
			<div class="wenkuang">
				<h2 class="wentit"><?= $qdetail['title']?></h2>
				<p style="color:#797979;margin-left:10px;">提问者：<?= empty($qdetail['realname']) ?  $qdetail['username'] : $qdetail['realname'] ?>&nbsp&nbsp&nbsp<?php if($qdetail['foldername']){ ?>学科分类：<?=$qdetail['foldername']?><?php } ?>&nbsp&nbsp&nbsp <?=date("Y-m-d H:i",$qdetail['dateline'])?></p>

			</div>
			<div class="quanwen">
				<?=$qdetail['message']?>
				<!-- ==== -->

				<?php if(!empty($qdetail['audiosrc'])){ ?>
					<div class="bowaid">
						<div class="waibo" id="waibo_<?= $qdetail['qid']?>" style="float:left" status="0">
							<a id="start_<?= $qdetail['qid']?>" class="akaishi start" href="javascript:start('<?= $qdetail['audiosrc']?>','<?= $qdetail['qid']?>')"></a>
							<a id="pause_<?= $qdetail['qid']?>" class="azanting" href="javascript:pause('<?= $qdetail['qid']?>')"></a>
							<a id="stop_<?= $qdetail['qid']?>" class="atingzhi" href="javascript:stop('<?= $qdetail['qid']?>')"></a>
							<p class="pingtiao">
							<span class="bartebg">
							<span id="votebars_<?= $qdetail['qid']?>" class="votebars" style="width:0%;"></span>
							</span>
							</p>
						</div>
						<div style="padding:10px;color:#cdcdcd;"><span class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</span></div>
					</div>
					<?php } ?>
					<?php if(!empty($qdetail['imagename'])){ ?>
					<div class="dengtu">
						<ul>
							<li style="width:auto;height:auto;">
							<div class="bg photo_photolist_inner">
							<p class="photo_photolist_img" style="width:auto;height:auto;">
							<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $qdetail['imagesrc']?>">
							<img id="img2" src="<?= getthumb($qdetail['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px; width:277px;height:195px"/>
							</a>
							</p>
							</div>
							</li>
						</ul>
					</div>
					
					<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>
					<?php } ?>
				<!-- ==== -->
			</div>
			<?php if(!empty($user)){?>			
			<a class="txtjiebtn" tag="wenben" href="javascript:showdialog2('tandaandiv');">解 答</a>
			<?php }else{?>
			<a class="txtjiebtn dialogLogin" tag="wenben" >解 答</a>
			<?php }?>
				<div class="botfen">
					<!-- Baidu Button BEGIN -->
						<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-left:20px;" data="{'text':'<?= $qdetail['title']?>-答疑专区-e板会','desc':'<?= shortstr(filterhtml($qdetail['message']),160)?>'}">
						<span class="bds_more">分享到：</span>
						<a class="bds_tsina"></a>
						<a class="bds_qzone"></a>
						<a class="bds_tqq"></a>
						<a class="bds_renren"></a>
						</div>
						<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6564321" ></script>
						<script type="text/javascript" id="bdshell_js"></script>
						<script type="text/javascript">
						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
						</script>
					<!-- Baidu Button END -->
					<div class="gaokuz">
						<span class="kanwenti">
							<?php if(!empty($user)){ ?>
								<?php if(empty($qdetail['aid'])){ ?>
								<a href="javascript:addfavorite(<?= $qid?>,1)">关注问题</a>
								<?php }else{ ?>
								<a href="javascript:addfavorite(<?= $qid?>,0)">取消关注</a>
								<?php } ?>
							<?php }else{ ?>
								<a href="javascript:void(0);" class="dialogLogin">关注问题</a>
							<?php } ?>
						</span>
						<span class="fenge">|</span>
						<span class="terks">
							<?php if(!empty($user)){?>
								<a href="javascript:addthank(<?=$qdetail['qid']?>)">
							<?php }else{?>
								<a class="dialogLogin" href="javascript:void(0)">
							<?php }?>
						感谢(
						<span id="qtknum"><?=$qdetail['thankcount']?></span>
						)
						</a>
						</span>
					</div>
			</div>
			</div>
			<div class="tithui">
				<span><?=$qdetail['answercount']?>个回答</span>
			</div>


			<?php foreach($askanswers as $answerdetail){?>
			<?php 
				if(!empty($answerdetail['face'])){
					$face = getthumb($answerdetail['face'],'50_50');
				}else{
					 if($answerdetail['sex']==1){
						if($answerdetail['groupid']==5){
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
						}else{
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
						}
					}else{
						if($answerdetail['groupid']==5){
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
						}else{
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
						}
					 }

					 $face = getthumb($defaulturl,'50_50');
				 }
			?>
			<!-- <div class="sixists zuijiaico"> -->
			<div class="sixists" style="position: relative;">
			<?php if($answerdetail['isbest']==1){ ?>
				<img style="position: absolute;bottom:0px;right:0px;width:168px;height:168px;" src="http://static.ebanhui.com/ebh/tpl/default/images/zuijiaico0507.png" />
			<?php } ?>
				<div class="wenkuang" style="padding-bottom:5px;">
					<div class="rentuwai">
						<img src="<?=$face?>">
					</div>
					<div class="twoxiang">
						<p><?= empty($answerdetail['realname']) ?  $answerdetail['username'] : $answerdetail['realname'] ?></p>
					</div>
					<div class="rietitsize">
						<span style="float:left;"><?= date('Y-m-d',$answerdetail['dateline'])?></span>
						<span class="terks">
						<?php if(!empty($user)){ ?>
								<a href="javascript:addthankanswer(<?= $qid?>,<?= $answerdetail['aid']?>)">感谢(<span id="detailthkcount_<?= $answerdetail['aid']?>"><?= $answerdetail['thankcount']?></span>)</a>
								<?php }else{ ?>
								<a href="javascript:void(0);" class="dialogLogin">感谢(<span id="detailthkcount_<?= $answerdetail['aid']?>"><?= $answerdetail['thankcount']?></span>)</a>
						<?php } ?>
						</span>
					</div>
					<?php if($qdetail['status'] != 1 && $qdetail['uid'] == $user['uid']){ ?> 
					<div style="float:left;width:650px;margin-top:10px;">
						<a href="javascript:setbest(<?= $qid?>,<?= $answerdetail['aid']?>)"  class="caizui">采纳为最佳</a>
					</div>
					<?php } ?>
				<?php if(!empty($answerdetail['audiosrc'])){ ?>
					<div class="bowaid">
						<div class="waibo" id="waibo_<?= $answerdetail['aid']?>" style="float:left" status="0">
							<a id="start_<?= $answerdetail['aid']?>" class="akaishi start" href="javascript:start('<?= $answerdetail['audiosrc']?>','<?= $answerdetail['aid']?>')"></a>
							<a id="pause_<?= $answerdetail['aid']?>" class="azanting" href="javascript:pause('<?= $answerdetail['aid']?>')"></a>
							<a id="stop_<?= $answerdetail['aid']?>" class="atingzhi" href="javascript:stop('<?= $answerdetail['aid']?>')"></a>
							<p class="pingtiao">
							<span class="bartebg">
							<span id="votebars_<?= $answerdetail['aid']?>" class="votebars" style="width:0%;"></span>
							</span>
							</p>
						</div>
						<div style="margin-top:10px;color:#cdcdcd;"><span class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</span></div>
					</div>
					<?php } ?>
					<?php if(!empty($answerdetail['imagename'])){ ?>
					<div class="dengtu">
						<ul>
							<li style="width:auto;height:auto;">
							<div class="bg photo_photolist_inner">
							<p class="photo_photolist_img" style="width:auto;height:auto;">
							<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $answerdetail['imagesrc']?>">
							<img id="img2" src="<?= getthumb($answerdetail['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px; width:277px;height:195px"/>
							</a>
							</p>
							</div>
							</li>
						</ul>
					</div>
					
					<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>
					<?php } ?>
				</div>
					<div class="quanwen">
						<?= $answerdetail['message']?>
					</div>
			</div>
			<?php }?>
		</div>
<div class="rigaddt">
<div class="adauto">
<a href="<?= geturl('question')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/ad130513.jpg" /></a>
</div>
<div class="kuanga">
<h2 class="twohei">答题动态</h2>
<div class="addt">
<ul>
<?php if(!empty($askanswer)){
	foreach($askanswer as $key=>$va){ ?>
	<li class="datidt">
	<span class="liebiao" style="background:#a9bd44;"><?=1+$key?></span><a href="<?= geturl('question/'.$va['qid'])?>"><?= shortstr($va['wr'],4)?> 解答了 <?= shortstr($va['qr'],4)?> 的问题</a>
	</li>
<?php } }?>
</ul>
</div>
</div>
<div class="adauto">
<a href="<?= geturl('down')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/ad140818.jpg" /></a>
</div>
<div class="kuanga">
<h2 class="twohei">答题动态</h2>
<div class="addt">
<ul>
<?php foreach($askquestion as $key=>$v){ ?>
<li class="datidt">
<span class="liebiao" style="background:#a9bd44;"><?=1+$key?></span><a href="/question/<?= $v['qid']?>.html"><?= shortstr($v['title'],18)?></a>
</li>
<?php } ?>
</ul>
</div>
</div>
</div>
</div>
<div id="tandaandiv" style="display:none;">
	<div class="zhumai">
<?php
    $editor->xEditor('message','775px','310px');
?>
<!--上传音频-->
	<div style="background:#fff;float:left;min-height: 53px;height:230px;width:776px;">
		<div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传音频：</div>
		<div style="float:left;margin-left:0px;width:455px;margin-top:10px; " id="audio_float">
	 		<a href="javascript:void(0)" id="startrecord" style="width:63px;height:27px;line-height:27px;background:#E3F2FF;border:solid 1px #A2D1F1;display:block;text-align:center;text-decoration: none;font-size:14px;" >录制</a>
		</div>
    <a qid="<?=$qdetail['qid']?>" class="tijiaobtn" style="margin-right:20px;">提  交</a>
	
		 <div style="float:left;width:560px;height:200px;display:none" id="showrecorder">
			<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" >
			<param value="transparent" name="wmode">
			<param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie">
			<param value="high" name="quality">
			<param value="false" name="menu">
			<param value="always" name="allowScriptAccess">
			</object>
		  </div>  
		<div style="float:left;width:455px;height:50px;_margin-top:20px;display:none" id="audio_show">
			<div class="upprogressbox" id="image_upprogressbox" style="display: block;width:475px;background-color:#fff;">
				<div class="upfileinfo" style="width:475px;">
				<span class="upstatusinfo">
				<img src="http://static.ebanhui.com/ebh/images/upload.gif"></span>
				<span class="spanUpfilename" id="audio_name"></span>
				<span id="image_spanUppercent">100%</span>
				<span><a onclick="deleteaudio()" href="javascript:void(0);">&nbsp;删除</a></span>
				</div>
				<div class="upprogressbar" style="width:475px;"><span class="upprogressstext">上传总进度：</span>
				<span class="spanUppercentBox" id="image_spanUppercentBox">
				<span class="spanUpShowPercent" id="image_spanUpShowPercent" style="width: 100%;"></span></span>
				<span class="spanUppercentinfo" id="image_spanUppercentinfo">100%</span></div>
			</div>
		</div>
		<input type="hidden" value="" name="audio" id="audio" />
		
	</div> 
<!--结束-->

	</div>
</div>

<div style="clear:both;"></div>
<script type="text/javascript">
function showLoginFram(){
	$.loginDialog();
	return false;
};
function addfavorite(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
	$.ajax({
		url:"<?= geturl('question/addfavorit')?>",
		type:'post',
		data:{'qid':qid,'op':'addfavorite','flag':flag,'inajax':1},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				changefavorite(qid,flag);
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips
				});
				
			}else{
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}
		}
	});
}
function changefavorite(qid,flag) {
	var html = "";
	if(flag == 1) {
		html = '<a href="javascript:addfavorite('+qid+',0)">取消关注</a>';	
	} else {
		html = '<a href="javascript:addfavorite('+qid+',1)">关注问题</a>';
	}
	$(".kanwenti").html(html);
}
function addthank(qid) {
	var tips = "感谢";
	$.ajax({
		url:"<?= geturl('question/addthank')?>",
		type:'post',
		data:{'qid':qid,'op':'addthank','inajax':1},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				var num = parseInt($("#qtknum").html());
				$("#qtknum").html(num+1);
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips
				});
				
			}else if(data == 'fail'){
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}else if(data == 'thatday'){
				$.showmessage({
					img		 :'error',
					message  :'您今天已经感谢过了！',
					title    :tips
				});
			}
		}
	});
}

//接受flash返回的audiosrc
function getURL(url){
	//alert(url);
	var audioname = url.substring(url.lastIndexOf('/')+1);
	$("#audio").attr("value",url);
	$("#showrecorder").hide();
	$("#audio_float").hide();
	
	$("#audio_name").html(audioname);
	$("#audio_show").show();
}
//删除录制上传的音频
function deleteaudio(){
	$("#audio_show").hide();
	$("#audio_float").show();
	$("#audio").attr("value",'');
}

$("#startrecord").click(function(){
	  $('#showrecorder').toggle();
	  $(".recoderSwf").remove();
	  $("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
});
function settips(id,tips) {
	if($.trim($("#"+id).val()) == "") {
		$("#"+id).val(tips);
		$("#"+id).addClass("titwentigray");
	}
	$("#"+id).click(function(){
		if($.trim($(this).val()) == tips) {
			$(this).val("");
			$(this).removeClass("titwentigray");
		}
	});
	$("#"+id).blur(function(){
		if($.trim($(this).val()) == "") {
			$(this).val(tips);
			$(this).addClass("titwentigray");
		}
	});
}

function submitanswer(qid,dom) {
	var tips = "提交解答";
	var message = UM.getEditor('message').getContent();
	var audio = $("#audio").val();
	if($.trim(message) == "") {
		alert("请输入回答内容");
		return false;
	}else{
            dom.unbind();    
        }
	$.ajax({
		url:"<?=geturl('question/addanswer')?>",
		type:'post',
		data:{'qid':qid,'message':message,'audio':audio},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips,
					callback :    function(){
						H.get('tandaandiv').exec('close');
						document.location.href = document.location.href;
					}
				});
				
			}else{
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}
		}
	});
}
//评论添加感谢
function addthankanswer(qid,aid) {
	var tips = "感谢";
	$.ajax({
		url:"<?=geturl('question/addthankanswer')?>",
		type:'post',
		data:{'qid':qid,'aid':aid},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				var num = parseInt($("#detailthkcount_"+aid).html());
				$("#detailthkcount_"+aid).html(num+1);
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips
				});
				
			}else if(data == 'thatday'){
				$.showmessage({
					img		 :'error',
					message  :'您今天已经感谢过了！',
					title    :tips
				});
			}else{
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}
		}
	});
}
$(function(){
    $(".tijiaobtn").click(function(){
        submitanswer($(this).attr("qid"),$(this));
    })
})
function degroup(qid,title) {
	var conf =  window.confirm("您确定要删除问题 【" + title + "】 吗？");
	if (conf)
	{
		$.ajax({
			url:"<?=geturl('question/delask')?>",
			type:'post',
			data:{'qid':qid,'op':'del','title':title},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					alert("问题删除成功！");
					document.location.href = "<?= geturl('question')?>";
				}else{
					alert("对不起，问题删除失败，请稍后再试！");
				}
			}
		});
	}
}
function setbest(qid,aid) {
	var tips = "设置最佳答案";
	$.ajax({
		url:"<?=geturl('question/setbest')?>",
		type:'post',
		data:{'qid':qid,'aid':aid},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips,
					callback :    function(){
						
						document.location.href = document.location.href;
					}
				});
				
			}else{
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}
		}
	});
}
$(".dialogLogin").click(function(){
	if ($(this).attr("name") != '') {
		$.loginDialog($(this).attr("name"));
	}else{
		$.loginDialog();
	}
	
});
function showdialog2(){
	H.create(new P({
		id:'tandaandiv',
		title:'问题解答',
		content:$("#tandaandiv")[0],
		easy:true,
		padding:5
	}),'common').exec('show');
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php
	$this->display('common/footer');
?>
