<?php $this->display('shop/stores/stores_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>

<script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/yinan.css" />



<script type="text/javascript">
$(function() {
	$('.dengtu a').lightBox();
});
</script>


<?php 
	$uid = $user['uid'];
	$reurl="javascript:tologinn('".'/login.html?returnurl=__url__'."');";
?>
<script type="text/javascript">
<!--
	 var tologinn = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
		}
//-->
</script>

<div class="main">
	<div class="dtzhix">
		<div class="topkuang"></div>
		<div class="zixun">
			<div class="leflist">
			<h2 style="margin-bottom:10px;">所有课程</h2>
			<p style="margin-left:10px; font-weight:bold;">
			<a href="/askquestion.html">查看所有答疑 >></a>
			</p>
			<ul>
		
			<?php $folderid = $this->uri->itemid;
			foreach($courqlist as $v){ ?>
					<li class="lister">
					<a style="cursor:pointer;" href="/askquestion.html?folderid=<?= $v['folderid']?>">
					<p class="titming" <?= $folderid==$v['folderid'] ?'style="color: #838383;"':'style="color: #3D3D3D;"'?> ><?= shortstr($v['foldername'],16)?>
					<span style="color:#838383;font-weight:normal;">(<?= $v['count']?>)</span>
					</p>
					</a>
					<p class="sizele"><?= shortstr($v['summary'],88)?></p>
					</li>
			<?php } ?>
			</ul>
			</div>
			
			<div class="waimin" style="width:740px;float:left;margin:0;">
				<div  class="titbgts" style="margin:0px 0px 10px 10px;">
					<h2>答题专区</h2>
					<div id="playercontainer"></div>
				</div>
				<div class="lefyuan">
							<div class="wenkuang" style="width: 720px;">
							<h2 class="wentit" ><?= $qdetail['title']?></h2>
							<div class="quanwen">
							<p class="xiangs"><span class="renwusou"><?= !empty($qdetail['realname'])?$qdetail['realname']:$qdetail['username']?></span><span class="fenge">|</span><span>所属课程：</span><span><?= $qdetail['catpath']?></span><span class="fenge">|</span><span><?= date('Y-m-d',$qdetail['dateline'])?></span></p>
							<p class="wenwen" style="overflow: hidden;
    word-wrap: break-word;"><?= $qdetail['message']?></p>
								<?php if(!empty($qdetail['audiosrc'])){?>
									<div class="waibo" id="waibo_q_<?= $qid?>" status="0">
									<a id="start_q_<?= $qid?>" class="akaishi start" href="javascript:start('<?= $qdetail['audiosrc']?>','q_<?= $qid?>')"></a>
									<a id="pause_q_<?= $qid?>" class="azanting" href="javascript:pause('q_<?= $qid?>')"></a>
									<a id="stop_q_<?= $qid?>" class="atingzhi" href="javascript:stop('q_<?= $qid?>')"></a>
									<p class="pingtiao">
									<span class="bartebg">
									<span id="votebars_q_<?= $qid?>" class="votebars" style="width:0%;"></span>
									</span>
									</p>
									</div>
								<?php } ?>
								<?php if(!empty($qdetail['imagesrc'])){?>
									<div class="dengtu">
										<ul>
											<li>
												<div class="bg photo_photolist_inner">
													<p class="photo_photolist_img">
													<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $qdetail['imagesrc']?>">
													<img id="img1" src="<?= getThumb($qdetail['imagesrc'],'277_195')?>" style="margin-top: 0px; margin-left: 0px; width:277px;height:195px"/>
													</a>
													</p>
												</div>
											</li>
										</ul>
									</div>
								<?php }?>
								<div style="width: 670px; float: left;margin-bottom:10px;">
									
								</div>
									<div class="gaokuz">
									<span class="kanwenti">
									<?php if(!empty($user)){?>
										<?php if(empty($qdetail['aid'])){ ?>
										<a href="javascript:addfavorite(<?= $qid?>,1)">关注问题</a>
										<?php }else{ ?>
										<a href="javascript:addfavorite(<?= $qid?>,0)">取消关注</a>
										<?php } ?>
									<?php }else{ ?>
										<?php if(empty($qdetail['aid'])){ ?>
										<a href="<?= $reurl?>">关注问题</a>
										<?php }else{ ?>
										<a href="<?= $reurl?>">取消关注</a>
										<?php } ?>
									<?php } ?>
									</span>
									<span class="fenge">|</span>
									<span class="terks">
									<?php if(!empty($user)){ ?>
										<a href="javascript:addthank(<?= $qid?>)">感谢(<span id="qtknum"><?= $qdetail['thankcount']?></span>)</a>
									<?php }else{ ?>
										<a href="<?= $reurl?>">感谢(<span id="qtknum"><?= $qdetail['thankcount']?></span>)</a>
									<?php } ?>
									</span ><span class="fenge">|
									</span>
									<span class="fenxiang">
								
											<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'text':'<?= $qdetail['title']?>-答疑专区-e板会','desc':'<?= shortstr(filterhtml($qdetail['message']),160)?>'}">
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
									</span>
								</div>
							<?php if(empty($user)){ ?>
							<a href="<?= $reurl?>" class="txtjiebtn">解 答</a>
							<?php }elseif($qdetail['status'] == 1){ ?>
							<span style="float:right;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jiejuebtn0507.jpg"></span>
							<?php }elseif($qdetail['uid'] != $uid){ ?>
							<a href="javascript:showdialog('tandaandiv');" class="txtjiebtn">解 答</a>
							<?php }else{ ?>
								<?php if($user['groupid'] == 6){ ?>
								<a href="<?= geturl('myroom')?>" class="xiugaibtn">修改问题</a>
								<?php }else{ ?>
								<a href="<?= geturl('troom')?>" class="xiugaibtn">修改问题</a>
								<?php } ?>
							<a href="javascript:degroup(<?= $qdetail['qid']?>,'<?= $qdetail['title']?>');" class="shanchubtn">删除问题</a>
							<?php } ?>
						</div>
					</div>
					<div class="tithui">
					
					<span class="heida">回答</span><span>默认排序</span> 
					</div>
				<div class="sixists" >
					<ul>
					<?php foreach($question as $answerdetail){ 
						 if(!empty($answerdetail['vitae']['avater'])){
							$face=$answerdetail['vitae']['avater'];
						 }elseif(!empty($answerdetail['mface'])){ 
							$face=$answerdetail['mface'];
						 }else{ 
							 if($answerdetail['sex']==1){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
							 }else{ 
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
							 }
							 $face = empty($answerdetail['face']) ? $defaulturl : $user['face'];
							 $facethumb = getthumb($face,'50_50');
							// $face = getThumbValue($answerdetail['face'],'50_50',$defaulturl);
						 } ?>
						<?php if($answerdetail['isbest']==1){?>
							<li class="xianda zuijiaico" id="detail_<?= $answerdetail['aid']?>" style="	background-color:#f7f7f7;width: 700px;">
						<?php }else{ ?>
							<li class="xianda" id="detail_<?= $answerdetail['aid']?>" style="width: 700px;">
						<?php } ?>
						<div class="rentuwai">
						<img src="<?= $facethumb?>" /></div>
						<div class="twoxiang">
						<p class="huirenw"><?= empty($answerdetail['realname'])?$answerdetail['username']:$answerdetail['realname']?></p>
						<p class="huitime"><?= date('Y-m-d',$answerdetail['dateline'])?></p>
						</div>
						<div class="rietitsize">
						<span class="fenge">|</span>
						<span class="terks">
						<?php if(!empty($user)){?>
						<a href="javascript:addthankanswer(<?= $qid?>,<?= $answerdetail['aid']?>)">感谢(<span id="detailthkcount_<?= $answerdetail['aid']?>"><?= $answerdetail['thankcount']?></span>)</a>
						<?php }else{ ?>
						<a href="<?= $reurl?>">感谢(<span id="detailthkcount_<?= $answerdetail['aid']?>"><?= $answerdetail['thankcount']?></span>)</a>
						<?php } ?>
						</span><span class="fenge">|</span>
						<span class="fenxiang">
				
							<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
							<span class="bds_more">分享到：</span>
							<a class="bds_tsina"></a>
							<a class="bds_qzone"></a>
							<a class="bds_tqq"></a>
							<a class="bds_renren"></a>
							</div>
							<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6704542" ></script>
							<script type="text/javascript" id="bdshell_js"></script>
							<script type="text/javascript">
							document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
							</script>
			
						</span><span class="fenge">|</span></div>
						<div class="huide" style="overflow: hidden;word-wrap: break-word;"><?= $answerdetail['message']?></div>
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
								</div><span class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</span>
							</div>
						<?php } ?>
						<?php if(!empty($answerdetail['imagesrc'])){?>
						<div class="dengtu">
										<ul>
											<li>
											<div class="bg photo_photolist_inner">
											<p class="photo_photolist_img">
											<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $answerdetail['imagesrc']?>">
											<img id="img2" src="<?= getthumb($answerdetail['imagesrc'],'277_195')?>" style="margin-top: 0px; margin-left: 0px; width:277px;height:195px"/>
											</a>
											</p>
											</div>
											</li>
										</ul>
									</div>
						<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>
						<?php } ?>
						<?php if($answerdetail['uid'] == $uid && $answerdetail['isbest'] != 1){ ?>
						<a href="javascript:delanswer(<?= $qid?>,<?= $answerdetail['aid']?>)" class="shandaanbtn" style="margin-left:10px;">删除答案</a>
						<?php } ?>
						<?php if( $qdetail['status'] != 1 && $qdetail['uid'] == $uid ){?> 
						<a href="javascript:setbest(<?= $qid?>,<?= $answerdetail['aid']?>)" class="zuijiabtn">最佳答案</a>
						<?php } ?>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>

		</div>
		<div class="fltkuang"> </div>
	</div>

</div>
</div>
<div id="tandaandiv" class="tandaan" style="float:left;display:none;height:570px;">
	<div class="topjies"><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a>
	</div>
	<div class="zhumai">

	<?php
        $editor->simpleEditor('message','598px','230px');
	?>

	 <!--上传音频-->
	<div style="background:#fff;float:left;min-height: 53px;height:230px;">
		<div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传音频：</div>
		<div style="float:left;margin-left:0px;width:378px;margin-top:10px; " id="audio_float">
	 		<a href="javascript:void(0)" id="startrecord" style="width:63px;height:27px;line-height:27px;background:#E3F2FF;border:solid 1px #A2D1F1;display:block;text-align:center;text-decoration: none;font-size:14px;" >录制</a>
		</div>
    <a qid="<?=$qid?>" class="tijiaobtn" style="margin-right:20px;">提  交</a>
	
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
			<div class="upprogressbox" id="image_upprogressbox" style="display: block;width:445px;background-color:#fff;">
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
function addfavorite(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
	$.ajax({
		url:'<?= geturl('askquestion/addfavorit')?>',
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
function addthankanswer(qid,aid) {
	var tips = "感谢";
        var url = '<?= geturl('askquestion/addthankanswer') ?>';
	$.ajax({
		url:url,
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
//var titletips = "请在这里输入问题标题";
//$(function(){
//	settips("title",titletips);
//        $(".tijibtn").click(function(){
//            if(checkquestion()) {
//                addquestion();
//            }
//        });
        $("#startrecord").click(function(){
        	  $('#showrecorder').toggle();
        	  $(".recoderSwf").remove();
        	  $("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
              });
//});
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


$(function(){
    $(".tijiaobtn").click(function(){
        submitanswer($(this).attr("qid"),$(this));
    })
})

    function submitanswer(qid,dom) {
        var tips = "提交解答";
        var message = UM.getEditor('message').getContent();
		var audio = $("#audio").val();
        if($.trim(HTMLDeCode(message)) == "") {
            alert("请输入回答内容");
            return false;
        }
        var url = '<?= geturl('askquestion/addanswer') ?>';
        $.ajax({
            url:url,
            type:'post',
            data:{'qid':qid,'message':message,'audio':audio},
            dataType:'text',
            success:function(data){
            if(data=='success'){
					// var num = parseInt($("#qtknum").html());
					// $("#qtknum").html(num+1);
                    $.showmessage({
                    img		 :'success',
                    message  :tips+'成功',
                    title    :tips,
                    callback :    function(){
                        closeWindow('tandaandiv');
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
function setbest(qid,aid) {
	var tips = "设置最佳答案";
	$.ajax({
		url:'<?=geturl('askquestion/setbest')?>',
		type:'post',
		data:{'qid':qid,'aid':aid,'op':'setbest','inajax':1},
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
//删除答案
function delanswer(qid,aid) {
    var url = '<?= geturl('askquestion/delanswer') ?>';
	$.confirm("您确定要删除您的问题答案吗？",function(){
		$.ajax({
			url:url,
			type:'post',
			data:{'qid':qid,'aid':aid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'答案删除成功！'});
					//document.location.href =  document.location.href;
                                        $("#detail_"+aid).remove();
                                        
				}else{
					$.showmessage({message:'对不起，答案删除失败，请稍后再试！'});
				}
			}
		});

	});
}
function degroup(qid,title) {
	var conf =  window.confirm("您确定要删除问题 【" + title + "】 吗？");
	if (conf)
	{
		$.ajax({
			url:'<?= geturl('askquestion/delask')?>',
			type:'post',
			data:{'qid':qid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'问题删除成功！'});
					document.location.href = "<?=geturl('askquestion')?>";
				}else{
					$.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
				}
			}
		});
	}
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php
	$this->display('common/footer');
?>