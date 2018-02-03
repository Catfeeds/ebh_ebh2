<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css">
<link href="http://static.ebanhui.com/portal/css/ebhportal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/portal/js/jquery-1.7.2.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>
<meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport" />
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
.htitle{
	width: 98%;
	float:left;
	margin:10px 0 0 20px;
	height: 100px;
}
.dengtu li{
	border:0;
}
.eftisb {
	border-bottom:solid 1px #dde4ef;
	float:left;
	width:100%;
	padding:10px 0;
}
.sdgtgsd {
	float:left;
	/*margin:0 20px;*/
	margin:0 10px 0 0;
	height:40px;
	width:40px;
}
.dhfreg {
	float:left;
}
.regeb {
	background:url(http://static.ebanhui.com/wap/images/stname.jpg) no-repeat left center;
	height:20px;
	line-height:20px;
	font-size:14px;
	text-indent:20px;
	color:#999;
}
.dfhrsd {
	background:url(http://static.ebanhui.com/wap/images/sttimes.jpg) no-repeat left center;
	height:20px;
	line-height:20px;
	font-size:14px;
	color:#999;
	text-indent:20px;
}
.dgeregh {
	float:right;
}
.rgkddgf {
	background:url(http://static.ebanhui.com/wap/images/shtsdd.jpg) no-repeat left center;
	height:20px;
	line-height:20px;
	font-size:14px;
	text-indent:20px;
	padding-left:20px;
	color:#999;
}
.fgjjr {
	width:100%;
	font-size:14px;
	float:left;
}
.dsgjkre {
	padding:10px;
}
.stdftgu {
  margin: 2px;
  border-radius: 25px;
  float: left;
  width: 40px;
  height: 40px;
}
.best {
  width: 100%;
  float: left;
  background: url(http://static.ebanhui.com/wap/images/best.png) no-repeat right bottom;
}
</style>
</head>
<body>


<?php 
	$qid = $this->uri->itemid;
	if(!empty($qdetail['face'])){
		$qface = getthumb($qdetail['face'],'50_50');
	}else{
		 if($qdetail['sex']==1){
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
		 }else{ 
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
		 }

		 $qface = getthumb($defaulturl,'50_50');
	 }
?>
	<div class="waimin" style="margin: 0px auto; width: 100%;">
		<div class="lefyuan" style="width:100%;float:none;">
			<div class="wentix" style="width:99%;">
			<div class="wenkuang" style="width:100%;float:none;">
			<!-- 新版标题头部开始 -->
			<div class="htitle">
				<div style="float:left;height:98%;width:50px;">
					<div style="width:50px;height:50px;">
						<img width=50px height=50px src="<?=$qface?>"  />
					</div>
				</div>
				<div style="float:left;height:100%;width:auto;padding-left:10px;">
					<span style="color:#1c5bd0;font-weight:bold;font-size:14px;line-height:24px;"><?= $qdetail['title']?></span><br>
					<span style="color:#747474;line-height:26px;"><?= empty($qdetail['realname']) ?  $qdetail['username'] : $qdetail['realname'] ?>　<span style="color:#ddd">|</span>　所属学科：<?=$qdetail['foldername']?></span><br>
					<span style="color:#747474;line-height:26px;">人气：<?= $qdetail['viewnum']?>　<span style="color:#ddd">|</span>　<?=date("Y-m-d H:i",$qdetail['dateline'])?></span><br>
				</div>
			</div>
			<!-- 新版标题头部结束 -->
			</div>
			<div class="quanwen" style="width:auto;">
				<?=$qdetail['message']?>
				<!-- ==== -->

				<?php if(!empty($qdetail['audiosrc'])){ ?>
					<div class="bowaid" style="margin-top:10px;">
					
						<audio controls="controls">
						  <source src="<?= $qdetail['audiosrc']?>" type="audio/mpeg">
						Your browser does not support the audio element.
						</audio>
						<p class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</p>
					</div>
					<?php } ?>
					<?php if(!empty($qdetail['imagename'])){ ?>
					<div class="dengtu">
						<ul>
							<li style="width:auto;height:auto;">
							<div class="bg photo_photolist_inner">
							<p class="photo_photolist_img" style="width:auto;height:auto;">
							
							<img id="img2" width=277px height=195px src="<?= getthumb($qdetail['imagesrc'],'277_195')?>"  style="margin:0"/>
							
							</p>
							</div>
							</li>
						</ul>
					</div>
					
					<?php } ?>
				<!-- ==== -->
			</div>
		
				<div class="botfen" style="width:100%;border-top:0;">
				<span style="margin-left:15px;"><?=$qdetail['answercount']?>个回答</span>
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
		


			<?php foreach($askanswers as $answerdetail){?>
			<?php 
				if(!empty($answerdetail['face'])){
					$face = getthumb($answerdetail['face'],'50_50');
				}else{
					 if($answerdetail['sex']==1){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					 }else{ 
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					 }

					 $face = getthumb($defaulturl,'50_50');
				 }
			?>
		<div id="content" class="eftisb">
			<div class=<?=$answerdetail['isbest']?'best':''?>>
				<div class="sdgtgsd">
					<img class="stdftgu" src="<?=$face?>">
				</div>
				<div class="dhfreg">
					<p class="regeb"><?= empty($answerdetail['realname']) ?  $answerdetail['username'] : $answerdetail['realname'] ?></p>
					<p class="dfhrsd"><?= date('Y-m-d',$answerdetail['dateline'])?></p>
				</div>
				<div class="dgeregh">
 					<?php if($qdetail['status'] != 1 && $qdetail['uid'] == $user['uid']){ ?>
						<a href="javascript:setbest(<?= $qid?>,<?= $answerdetail['aid']?>)"  class="rgkddgf setbest">设为最佳</a>
					<?php } ?>
				</div>
				<div class="fgjjr">
				<div class="dsgjkre">
					<p><?= $answerdetail['message']?></p>
					<?php if(!empty($answerdetail['audiosrc'])){ ?>
						<div class="bowaid">
							<audio controls="controls" style="margin-top:10px;">
							  <source src="<?= $answerdetail['audiosrc']?>" type="audio/mpeg">
							Your browser does not support the audio element.
							</audio>
							<p class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</p>
						</div>
					<?php } ?>
					<?php if(!empty($answerdetail['imagename'])){ ?>
					<div class="dengtu">
						<ul>
							<li style="width:auto;height:auto;">
							<div class="bg photo_photolist_inner">
							<p class="photo_photolist_img" style="width:auto;height:auto;">
							
							<img id="img2" src="<?= getthumb($answerdetail['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px; width:277px;height:195px"/>
					
							</p>
							</div>
							</li>
						</ul>
					</div>
					<?php }?>
				</div>
				</div>
			</div>
		</div>
			<?php }?>
		</div>

</div>
<div id="tandaandiv" class="tandaan" style="float:left;display:none;">
	<div class="topjies"><h2 class="tithuit">请写下您的解答，您也可以试试功能强大的 <a class="ejieda" href="javascript:playask(<?=$qdetail['qid']?>)">e板会解答</a>。</h2><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a>
	</div>
	<div class="zhumai">
	<link href="http://static.ebanhui.com/um/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet"></link><script src="/lib/um/umeditor.config.js" type="text/javascript"></script><script src="/lib/um/umeditor.js" type="text/javascript"></script><script src="http://static.ebanhui.com/ebh/js/formulav2.js" type="text/javascript"></script><link href="http://static.ebanhui.com/ebh/tpl/default/css/public.bak.css" type="text/css" rel="stylesheet"></link><script type="text/javascript" src="/lib/um/lang/zh-cn/zh-cn.js"></script><script type="text/plain" id="message" style="width:598px;height:210px"></script><script type="text/javascript">var ue = UM.getEditor("message",{textarea:"message",imageUrl:"/uploadimage.html",autoHeightEnabled:false,imagePath:"",toolbar:['undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |',
            'insertorderedlist insertunorderedlist | fontsize' ,
            '| justifyleft justifycenter justifyright justifyjustify |',
            'image formula'
        ]});</script>	
	<a  qid="<?=$qdetail['qid']?>" class="tijiaobtn">提交解答</a>
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
		url:"<?= geturl('iask/addfavorit')?>",
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
		url:"<?= geturl('iask/addthank')?>",
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
		url:"<?=geturl('iask/addanswer')?>",
		type:'post',
		data:{'qid':qid,'message':message},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				
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
//评论添加感谢
function addthankanswer(qid,aid) {
	var tips = "感谢";
	$.ajax({
		url:"<?=geturl('iask/addthankanswer')?>",
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
			url:"<?=geturl('iask/delask')?>",
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
		url:"<?=geturl('iask/setbest')?>",
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
</script>
