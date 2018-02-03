<?php $this->display('home/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>

<script type="text/javascript">
$(function() {
	try{
	window.parent.showimage('.dengtu a');
	}catch(err){}
});
</script>
<style type="text/css">

.dengtu {
    border:none;
    height: 195px;
    margin: 10px 0;
    width: 277px;
}
.dengtu li {
    border-style: solid;
    border-width: 1px;
    float: left;
    height: 195px;
    margin: 0 17px 40px 0;
    position: relative;
    width: 277px;
    z-index: 2;
	border-color: #CDCDCD;
}
.photo_photolist_inner {
    position: relative;
}
.photo_photolist_img {
    height: 195px;
    overflow: hidden;
    width: 277px;
}
.photo_photolist_img a {
    height: 195px;
    width: 277px;
}
fieldset, img, a img, iframe {
    border-style: none;
    border-width: 0;
}
.bofang {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/download.png) no-repeat scroll ;
	color: #FFFFFF;
    float: left;
    height: 23px;
    line-height: 23px;
    text-align: center;
    width: 105px;
}
em{
	font-style: italic;
	
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
<div class="ter_tit" style="margin-bottom:10px;">
当前位置 > <a href="<?= geturl('home/largedb') ?>">历史数据</a> > 答疑详情</div>
<div class="lefrig">
<div style="height:16px;">
<div id="playercontainer"></div>
</div>
<div class="wenkuang" style="width:786px;">

<div class="quanwen" style="width:740px;">
<?php 
$defaulturl = $ask['sex'] == 1 ? ($ask['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($ask['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
$face =  empty($ask['face']) ? $defaulturl:$ask['face'];
$face = getthumb($face,'50_50');
?>
<p class="xiangs" style="margin:0;float:left;">
<img src="<?= $face ?>" style="width:50px;height:50px;float:left;"/>
<span class="wentit" style="float:left;"><?= $ask['title'] ?></span>

<span class="renwusou"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></span><span class="fenge">|</span><span>所属学科：</span><span><?= $ask['foldername'] ?></span><span class="fenge">|</span><span>人气：</span><span><?= $ask['viewnum'] ?></span><span class="fenge">|</span><span><?= date('Y-m-d H:i:s',$ask['dateline']) ?></span></p>
<div class="wenwen"><?= $ask['message'] ?>&nbsp;</div>

<?php if(!empty($ask['audiosrc'])) { ?>
<div class="waibo" id="waibo_q_<?= $ask['qid'] ?>" status="0">
<a id="start_q_<?= $ask['qid'] ?>" class="akaishi start" href="javascript:start('<?= $ask['audiosrc'] ?>','q_<?= $ask['qid'] ?>')"></a>
<a id="pause_q_<?= $ask['qid'] ?>" class="azanting" href="javascript:pause('q_<?= $ask['qid'] ?>')"></a>
<a id="stop_q_<?= $ask['qid'] ?>" class="atingzhi" href="javascript:stop('q_<?= $ask['qid'] ?>')"></a>
<p class="pingtiao">
<span class="bartebg">
<span id="votebars_q_<?= $ask['qid'] ?>" class="votebars" style="width:0%;"></span>
</span>
</p>
</div>
<?php } ?>
<?php if(!empty($ask['imagesrc'])) { ?>
<div class="dengtu">
	<ul>
		<li style="width:auto;height:auto;">
			<div class="bg photo_photolist_inner">
			<p class="photo_photolist_img" style="width:auto;height:auto;">
			<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $ask['imagesrc'] ?>">
			<img id="img1" src="<?= getthumb($ask['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px;"/>
			</a>
			</p>
			</div>
		</li>
	</ul>
</div>
<?php } ?>

<div class="gaokuz" >
<span class="kanwenti">
    <?php if(empty($ask['aid'])) { ?>
    <a href="javascript:addfavorit(<?= $ask['qid'] ?>,1)">关注问题</a>
    <?php } else { ?>
    <a href="javascript:addfavorit(<?= $ask['qid'] ?>,0)">取消关注</a>
    <?php } ?>

</span>
    <span class="fenge" style="margin-top:5px;">|</span>
    <span class="terks"><a href="javascript:addthank(<?= $ask['qid']?>)">感谢(<span id="qtknum"><?= $ask['thankcount'] ?></span>)</a>
        </span>
    
</div>

<?php if($ask['status'] == 1) { ?>
<span style="float:right;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jiejuebtn0507.jpg"></span>
<?php } else if($ask['uid'] != $user['uid']) { ?>
<a href="javascript:showdialog('tandaandiv');" class="xiugaibtn">解 答</a>
<?php } else { ?>
<a href="<?= geturl('home/largedb/edit/'.$qid) ?>" class="xiugaibtn">修改问题</a>
<a href="javascript:delask(<?= $qid ?>,'<?= $ask['title'] ?>');" class="shanchubtn">删除问题</a>
<?php } ?>

</div>
</div>
<div class="tithui">
<span class="heida">回答</span><span>默认排序</span>
</div>

<div class="sixists">
<ul>

<?php foreach ($answers as $answer) { 
$defaulturl = $answer['sex'] == 1 ? ($answer['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($answer['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
$face = empty($answer['face']) ? $defaulturl : $answer['face'];
$face = getthumb($face,'50_50');
?>

<?php if($answer['isbest'] == 1) { ?>
<li class="xianda" id="detail_<?= $answer['aid'] ?>">
<img style="position: absolute;bottom:0px;right:0px;width:168px;height:168px;" src="http://static.ebanhui.com/ebh/tpl/default/images/zuijiaico0507.png" />
<?php } else { ?>
<li class="xianda" id="detail_<?= $answer['aid'] ?>">
<?php } ?>

<div class="rentuwai">
<img src="<?= $face ?>" style="width:50px;height:50px;"/></div>
<div class="twoxiang">
<p class="huirenw"><?= empty($answer['realname']) ?  $answer['username'] : $answer['realname'] ?></p>
<p class="huitime"><?= date('Y-m-d H:i:s',$answer['dateline']) ?></p>
</div>
<div class="rietitsize" style=" position: relative;">
<span class="fenge">|</span><span class="terks"><a href="javascript:addthankanswer(<?= $ask['qid']?>,<?= $answer['aid'] ?>)">感谢(<span id="detailthkcount_<?= $answer['aid'] ?>"><?= $answer['thankcount'] ?></span>)</a></span>
</div>
<div class="huide">
	<?= $answer['message'] ?>
</div>

<?php if(!empty($answer['audiosrc'])) { ?>
<div class="bowaid">
	<div class="waibo" id="waibo_<?= $answer['aid'] ?>" style="float:left" status="0">
	<a id="start_<?= $answer['aid'] ?>" class="akaishi start" href="javascript:start('<?= $answer['audiosrc'] ?>','<?= $answer['aid'] ?>')"></a>
	<a id="pause_<?= $answer['aid'] ?>" class="azanting" href="javascript:pause('<?= $answer['aid'] ?>')"></a>
	<a id="stop_<?= $answer['aid'] ?>" class="atingzhi" href="javascript:stop('<?= $answer['aid'] ?>')"></a>
	<p class="pingtiao">
	<span class="bartebg">
	<span id="votebars_<?= $answer['aid'] ?>" class="votebars" style="width:0%;"></span>
	</span>
	</p>
	</div><span class="sizeyin" style="margin-top:12px;">点击播放按钮听听他的讲解</span>
</div>
<?php } ?>

<?php if(!empty($answer['imagesrc'])) { ?>
<div style="width: 720px;min-height:50px;_height:50px;float:left">
<div class="dengtu" style="float: left;">
	<ul>
		<li style="width:auto;height:auto;padding:2px">
			<div class="bg photo_photolist_inner">
			<p class="photo_photolist_img" style="width:auto;height:auto;">
			<a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $answer['imagesrc'] ?>">
			<img id="img1" src="<?= getthumb($answer['imagesrc'],'277_195') ?>"  style="margin-top: 0px; margin-left: 0px;"/>
			</a>
			</p>
			</div>
		</li>
	</ul>
	
</div>
<span class="sizeyin" style="margin-top:190px;">单击图片查看清晰大图</span>
</div>
<?php } ?>

<?php if($answer['uid'] == $user['uid'] && $answer['isbest'] != 1) { ?>
<a href="javascript:delanswer(<?= $qid ?>,<?= $answer['aid'] ?>)" class="shandaanbtn" style="margin-left:10px;">删除答案</a>
<?php } ?>

<?php if($ask['status'] != 1 && $ask['uid'] == $user['uid']) { ?>
<a href="javascript:setbest(<?= $ask['qid'] ?>,<?= $answer['aid'] ?>)" class="zuijiabtn">最佳答案</a>
<?php } ?>

</li>
<?php } ?>

</ul>
</div>
<?= $pagestr ?>

</div>
<div id="tandaandiv" class="tandaan" style="float:left;display:none;width:676px;height:680px;padding:20px;">
<div class="topjies"><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a></div>
<div class="zhumai">

<?php
        $editor->simpleEditor('message','675px','360px');
?>

  <!--上传音频-->
	<div style="background:#fff;float:left;min-height: 53px;height:230px;">
		<div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传音频：</div>
		<div style="float:left;margin-left:0px;width:455px;margin-top:10px; " id="audio_float">
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


<script type="text/javascript">
function addfavorit(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
        var url = '<?= geturl('home/largedb/addfavorit') ?>';
	$.ajax({
		url:url,
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
		html = '<a href="javascript:addfavorit('+qid+',0)">取消关注</a>';	
	} else {
		html = '<a href="javascript:addfavorit('+qid+',1)">关注问题</a>';
	}
	$(".kanwenti").html(html);
}
function addthank(qid) {
	var tips = "感谢";
        var url = '<?= geturl('home/largedb/addthank') ?>';
	$.ajax({
		url:url,
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
        var url = '<?= geturl('home/largedb/addthankanswer') ?>';
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
        var url = '<?= geturl('home/largedb/addanswer') ?>';
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
	var url = '<?= geturl('home/largedb/setbest') ?>';
	$.ajax({
		url:url,
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

function delask(qid,title) {
    var url = '<?= geturl('home/largedb/delask') ?>';
    var successurl = '<?= geturl('home/largedb/myquestion') ?>';
	$.confirm("您确定要删除问题 【" + title + "】 吗？",function(){
		$.ajax({
			url:url,
			type:'post',
			data:{'qid':qid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'问题删除成功！'});
					document.location.href = successurl;
				}else{
					$.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
				}
			}
		});
	});
}

//删除答案
function delanswer(qid,aid) {
    var url = '<?= geturl('home/largedb/delanswer') ?>';
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
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php $this->display('common/player'); ?>
<?php $this->display('home/page_footer'); ?>