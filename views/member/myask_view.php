<?php
$this->display('common/header');
?>


<div id="tandaandiv" class="tandaan" style="float:left;display:none;width:676px;padding:20px;">
<div class="topjies"><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a></div>
<div class="zhumai">

<?php
        $editor->simpleEditor('message','675px','310px');
?>
 <a  qid="<?=$qid?>" class="tijiaobtn">提  交</a>
</div>
</div>
<div class="topbaad">
<div class="user-main clearfix" >
	<?php
	$this->assign('menuid',5);
	$this->display('member/left');
	?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
	$('.dengtu a').lightBox();
});
</script>
<style>
em{
	font-style: italic;
	
}
.dengtu {
    border:none;
    height: 195px;
    margin: 10px 0;
    width: 277px;
}
.huide strong em{
	font-weight: bold;
}
.huide em strong{
	font-style: italic;
}
strong{
	font-weight: bold;
}
</style>
<div class="cright">
<div class="ter_tit">
	当前位置 > <a href="<?=geturl('member/myask')?>">我的答疑</a> > 
	<?php 
	if($qdetail['uid'] == $uid)
		echo '查看问题';
	else
		echo '解答问题';
	?>
	</div>
	<div class="lefrig">
<div style="height:16px;">
<div id="playercontainer"></div>
</div>
<div class="wenkuang" style="width:786px;">
<div class="quanwen">
<?php 
$defaulturl = $qdetail['sex'] == 1 ? 'm_woman.jpg' : 'm_man.jpg';
$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
$face =  empty($qdetail['face']) ? $defaulturl:$qdetail['face'];
$face = getthumb($face,'50_50');
?>
<p class="xiangs" style="margin:0;float:left;width:740px;">
<img src="<?= $face ?>" style="width:50px;height:50px;float:left;"/>
<span class="wentit" style="float:left;"><?= $qdetail['title'] ?></span>

<span class="renwusou"><?= empty($qdetail['realname']) ? $qdetail['username'] : $qdetail['realname'] ?></span><span class="fenge">|</span><?php if(!empty($qdetail['foldername'])) {?><span>学科分类：</span><span><?= $qdetail['foldername'] ?></span><span class="fenge">|</span><?php } ?><span><?= date('Y-m-d H:i:s',$qdetail['dateline']) ?></span></p>
<div class="wenwen" style="width:730px;"><?= $qdetail['message'] ?>&nbsp;</div>
<?php if(!empty($qdetail['audiosrc'])){
?>
<div class="waibo" id="waibo_q_<?=$qid?>" status="0">
<a id="start_q_<?=$qid?>" class="akaishi start" href="javascript:start('<?=$qdetail['audiosrc']?>','q_<?=$qid?>')"></a>
<a id="pause_q_<?=$qid?>" class="azanting" href="javascript:pause('q_<?=$qid?>')"></a>
<a id="stop_q_<?=$qid?>" class="atingzhi" href="javascript:stop('q_<?=$qid?>')"></a>
<p class="pingtiao">
<span class="bartebg">
<span id="votebars_q_<?=$qid?>" class="votebars" style="width:0%;"></span>
</span>
</p>
</div>

<?php }if(!empty($qdetail['imagesrc'])){
?>
<div class="dengtu">
<ul>
<li style="width:auto;height:auto;padding:2px">
<div class="bg photo_photolist_inner">
<p class="photo_photolist_img" style="width:auto;height:auto;">
<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?=$qdetail['imagesrc']?>">
<img id="img1" src="<?=getthumb($qdetail['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px;"/>
</a>
</p>
</div>
</li>
</ul>
</div>
<?php
}
?>
<!--<div style="width: 670px; float: left;margin-bottom:10px;">
	<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$qdetail['attsrc'])){?>
	<a href="javascript:;" class="bofang" onclick="playfile('http://www.ebanhui.com<?=$qdetail['attsrc']?>','<?=$qdetail['attname']?>')">播放解析课件</a>
	<?php }else{?>
	<a href="<?=$qdetail['attsrc']?>" class="bofang" target="_blank">下载解析课件</a>
	<?php }?>
</div>-->
<div class="gaokuz">
<span class="kanwenti"><?php if(empty($qdetail['aid'])){?><a href="javascript:addfavorite(<?=$qid?>,1)">关注问题</a><?php }else{?><a href="javascript:addfavorite(<?=$qid?>,0)">取消关注</a><?php }?></span><span class="fenge" style="margin-top:5px;">|</span><span class="terks"><a href="javascript:addthank(<?=$qid?>)">感谢(<span id="qtknum"><?=$qdetail['thankcount']?></span>)</a></span><span class="fenge" style="margin-top:5px;">|</span>
<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
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

</div>
<?php if($qdetail['status'] == 1){?>
	<?php if(($user['groupid']==5)&&($qdetail['uid'] != $uid)){?>
		<a href="javascript:showdialog('tandaandiv');" class="xiugaibtn">解 答</a>
	<?php }else{?>
		<span style="float:right;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jiejuebtn0507.jpg"></span>
	<?php }?>
<?php }elseif($qdetail['uid'] != $uid){?>
	<a href="javascript:showdialog('tandaandiv');" class="xiugaibtn">解 答</a>
<?php }else{?>
	<a href="<?=geturl('member/myask/edit/'.$qdetail['qid'])?>" class="xiugaibtn">修改问题</a>
	<a href="javascript:degroup(<?=$qdetail['qid']?>,'<?=$qdetail['title']?>')" class="shanchubtn">删除问题</a>
<?php }?>
</div>
</div>
<div class="tithui" style="font-size:20px;font-weight:bold;">
回答　<span style="font-size:12px;font-weight:normal;">默认排序</span>
</div>

<div class="sixists">
<ul>

<?php foreach($answerlist as $answerdetail){
		if(!empty($answerdetail['face']))
			$face = getthumb($answerdetail['face'],'50_50');
		else{
			if($answerdetail['sex']==1)
				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			else
				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
		$face = getthumb($defaulturl,'50_50');
		}
		if($answerdetail['isbest']==1){?>
<li class="xianda" id="detail_<?=$answerdetail['qid']?>">
<img style="position: absolute;bottom:0px;right:0px;width:168px;height:168px;" src="http://static.ebanhui.com/ebh/tpl/default/images/zuijiaico0507.png" />
<?php }else{?>
<li class="xianda" id="detail_<?=$answerdetail['qid']?>">
<?php }?>
<div class="rentuwai">
<img src="<?=$face?>" style="width:50px;height:50px;"/></div>
<div class="twoxiang">
<p class="huirenw">
<?= !empty($answerdetail['realname'])?$answerdetail['realname']:$answerdetail['username']?>
</p>
<p class="huitime"><?=Date('Y-m-d H:m:i',$answerdetail['dateline'])?></p>
</div>
<div class="rietitsize" style=" position: relative;">
<span class="fenge">|</span><span class="terks"><a href="javascript:addthankanswer(<?=$qid?>,<?=$answerdetail['aid']?>)">感谢(<span id="detailthkcount_<?=$answerdetail['aid']?>"><?=$answerdetail['thankcount']?></span>)</a></span>
</div>
<div class="huide">
	<?=$answerdetail['message']?>
</div>
<?php if(!empty($answerdetail['audiosrc'])){?>
<div class="bowaid">
	<div class="waibo" id="waibo_$answerdetail['aid']" style="float:left" status="0">
	<a id="start_<?=$answerdetail['aid']?>" class="akaishi start" href="javascript:start('<?=$answerdetail['audiosrc']?>','<?=$answerdetail['aid']?>')"></a>
	<a id="pause_<?=$answerdetail['aid']?>" class="azanting" href="javascript:pause('<?=$answerdetail['aid']?>')"></a>
	<a id="stop_<?=$answerdetail['aid']?>" class="atingzhi" href="javascript:stop('<?=$answerdetail['aid']?>')"></a>
	<p class="pingtiao">
	<span class="bartebg">
	<span id="votebars_<?=$answerdetail['aid']?>" class="votebars" style="width:0%;"></span>
	</span>
	</p>
	</div><span class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</span>
</div>
<?php }?>
<?php $cssname = !empty($answerdetail['imagesrc'])?'haspic':''?>
<div style="width: 688px;min-height:50px;_height:50px;float:left" class="<?=$cssname?>">
<?php if(!empty($answerdetail['imagesrc'])){?>
<div class="dengtu">
<ul>
<li style="width:auto;height:auto;">
<div class="bg photo_photolist_inner">
<p class="photo_photolist_img" style="width:auto;height:auto;">
<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?=$answerdetail['imagesrc']?>">
<img id="img2" src="<?=getthumb($answerdetail['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px;"/>
</a>
</p>
</div>
</li>
</ul>
</div>
<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>

<?php }if($answerdetail['uid'] == $uid && $answerdetail['isbest'] != 1){?>
<a href="javascript:delanswer(<?=$qid?>,<?=$answerdetail['aid']?>)" class="shandaanbtn">删除答案</a>
<? }?>
</div>

<?php if($qdetail['status'] == 0 && $qdetail['uid'] == $uid && $qdetail['hasbest'] != 1){?>
<a href="javascript:setbest(<?=$qid?>,<?=$answerdetail['aid']?>)" class="zuijiabtn">最佳答案</a>
<?php }?>
</li>
<?php
}
?>
</ul>
</div>
<?=show_page($count,10)?>
</div>

</div>
</div>

<script type="text/javascript">
function addfavorite(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
	$.ajax({
		url:"<?=geturl('member/myask/addfavorit')?>",
		type:'post',
		data:{'qid':qid,'flag':flag},
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
		url:"<?=geturl('member/myask/addthank')?>",
		type:'post',
		data:{'qid':qid},
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
function addthankanswer(qid,aid) {
	var tips = "感谢";
	$.ajax({
		url:"<?=geturl('member/myask/addthankanswer')?>",
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
		url:"<?=geturl('member/myask/addanswer')?>",
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
function setbest(qid,aid) {
	var tips = "设置最佳答案";
	$.ajax({
		url:"<?=geturl('member/myask/setbest')?>",
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

function degroup(qid,title) {
	var conf =  window.confirm("您确定要删除问题 【" + title + "】 吗？");
	if (conf)
	{
		$.ajax({
			url:"<?=geturl('member/myask/delask')?>",
			type:'post',
			data:{'qid':qid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'问题删除成功！'});
					document.location.href = "<?=geturl('member/myask')?>";
				}else{
					$.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
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
			url:"<?=geturl('member/myask/delanswer')?>",
			type:'post',
			data:{'qid':qid,'aid':aid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'答案删除成功！'});
					document.location.href =  document.location.href;
				}else{
					$.showmessage({message:'对不起，答案删除失败，请稍后再试！'});
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