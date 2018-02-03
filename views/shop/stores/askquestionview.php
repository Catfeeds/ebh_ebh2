<?php $this->display('shop/stores/stores_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
</script><script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
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
			<a href="/askquestion.html">查看所有课件答疑>></a>
			</p>
			<ul>
		
			<?php foreach($courqlist as $v){ ?>
					<li class="lister">
					<a style="cursor:pointer;" href="<?= geturl('askquestion/'.$v['folderid'])?>">
					<p class="titming" <?= $folderid==$v['folderid'] ?'style="color: #838383;"':'style="color: #3D3D3D;"'?> ><?= $v['foldername']?>
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
							<p class="xiangs"><span class="renwusou"><?= $qdetail['username']?></span><span class="fenge">|</span><span>所属课程：</span><span><?= $qdetail['catpath']?></span><span class="fenge">|</span><span><?= date('Y-m-d',$qdetail['dateline'])?></span></p>
							<p class="wenwen"><?= $qdetail['message']?></p>
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
													<img id="img1" src="<?= getThumbValue($qdetail['imagesrc'],'277_195')?>" style="margin-top: 0px; margin-left: 0px; width:277px;height:195px"/>
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
								
											<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'text':'<?= $values['title']?>-答疑专区-e板会','desc':'<?= shortstr(filterhtml($values['message']),160)?>'}">
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
							<a href="<?= $reurl?>" class="txtjiebtn">文本解答</a>
							<a href="<?= $reurl?>" class="ejiebtn">e板会解答</a>
							<?php }elseif($qdetail['status'] == 1){ ?>
							<span style="float:right;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jiejuebtn0507.jpg"></span>
							<?php }elseif($qdetail['uid'] != $uid){ ?>
							<a href="javascript:showdialog('tandaandiv');" class="txtjiebtn">文本解答</a>
							<a href="javascript:playask(<?= $qid?>);" class="ejiebtn">e板会解答</a>
							<?php }else{ ?>
							<a href="<?= geturl('myroom/myask/editquestion/'.$qdetail['qid'])?>" class="xiugaibtn"></a>
							<a href="javascript:degroup(<?= $qdetail['qid']?>,'<?= $qdetail['title']?>');" class="shanchubtn"></a>
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
							<li class="xianda zuijiaico" id="detail_{<?= $answerdetail['qid']?>}" style="	background-color:#f7f7f7;width: 664px;">
						<?php }else{ ?>
							<li class="xianda" id="detail_{<?= $answerdetail['qid']?>}" style="width: 664px;">
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
						<a href="javascript:addthankanswer(<?= $qid?>,<?= $answerdetail['aid']?>)">感谢(<span id="detailthkcount_{<?= $answerdetail['aid']?>}"><?= $answerdetail['thankcount']?></span>)</a>
						<?php }else{ ?>
						<a href="<?= $reurl?>">感谢(<span id="detailthkcount_{<?= $answerdetail['aid']?>}"><?= $answerdetail['thankcount']?></span>)</a>
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
						<div class="huide"><?= $answerdetail['message']?></div>
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
<div id="tandaandiv" class="tandaan" style="float:left;display:none;">
	<div class="topjies"><h2 class="tithuit">请写下您的解答，您也可以试试功能强大的 <a class="ejieda" href="javascript:playask(<?= $qid?>)">e板会解答</a>。</h2><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a>
	</div>
	<div class="zhumai">

	<textarea id="rich_message" name="rich_message" style="width:598px; height: 500px;"></textarea>

	<a  qid="<?= $qid?>" class="tijiaobtn">提交解答</a>
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
		url:'<?= geturl('question/addfavorit')?>',
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
		url:'<?= geturl('question/addthank')?>',
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
function addthankanswer(qid,aid) {
	var tips = "感谢";
	$.ajax({
		url:'<?=geturl('question/addthankanswer')?>',
		type:'post',
		data:{'qid':qid,'aid':aid,'op':'addthankanswer','inajax':1},
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
function submitanswer(qid,dom) {
	var tips = "提交解答";
	var message = UM.getEditor('message').getContent();
	if($.trim(message) == "") {
		alert("请输入回答内容");
		return false;
	}else{
            dom.unbind();    
        }
	$.ajax({
		url:"<?=geturl('question/addanswer')?>",
		type:'post',
		data:{'qid':qid,'message':message},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				var num = parseInt($("#qtknum").html());
				$("#qtknum").html(num+1);
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
		url:"<?=geturl('question/setbest')?>",
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

function degroup(qid,title) {
	var conf =  window.confirm("您确定要删除问题 【" + title + "】 吗？");
	if (conf)
	{
		$.ajax({
			url:'<?=geturl('question/delask')?>',
			type:'post',
			data:{'qid':qid,'op':'del','title':title},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					alert("问题删除成功！");
					document.location.href = "<?= geturl('myroom/myask')?>";
				}else{
					alert("对不起，问题删除失败，请稍后再试！");
				}
			}
		});
	}
}

//删除答案
function delanswer(qid,aid) {
	var conf =  window.confirm("您确定要删除您的问题答案吗？");
	if (conf)
	{
		$.ajax({
			url:"<?=geturl('question/delask')?>",
			type:'post',
			data:{'qid':qid,'aid':aid,'op':'delanswer'},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					alert("答案删除成功！");
					document.location.href =  document.location.href;
				}else{
					alert("对不起，答案删除失败，请稍后再试！");
				}
			}
		});
	}
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php
	$this->display('common/player');
	$this->display('common/footer');
?>