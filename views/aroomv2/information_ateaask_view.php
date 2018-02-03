<?php $this->display('aroomv2/page_header')?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
$(function() {
	try{
	window.parent.showimage('.dengtu a');
	}catch(error){}
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
.playbtn{
  background: #18a8f7;
  padding: 6px;
  border: 1px solid #eee;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
  color: #fff;
}
a.hrelh {
	display: block;
    margin: 2px 0 0 10px;
    background:url(http://static.ebanhui.com/ebh/tpl/2014/images/xiudty_s.jpg) no-repeat left center;
    color: #2796f0;
    cursor: pointer;
    float: left;
    height: 14px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
	padding-left:20px;
}
</style>

<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
$rrurl = $this->input->get('rrurl');
?>
	<?php
	if(!empty($rurl)){?>
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/<?=$rurl?>.html?rurl=<?=$rrurl?>">指定提问 </a> > 答疑详情
	<?php }else{?>
当前位置 > <a href="<?= geturl('aroomv2/information/ateaask') ?>">答疑管理</a> > 答疑详情
	<?php }?>
	</div>
<div class="lefrig">
<div style="height:16px;">
<div id="playercontainer"></div>
</div>
<div class="wenkuang" style="width:788px;">
<div class="quanwen" style="width:740px">
<?php 
$defaulturl = $ask['sex'] == 1 ? ($ask['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($ask['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
$face =  empty($ask['face']) ? $defaulturl:$ask['face'];
$face = getthumb($face,'50_50');
?>
<p class="xiangs" style="float:left;width:730px;">
<img src="<?= $face ?>" style="width:50px;height:50px;float:left;"/>
<span class="wentit"><?= $ask['title'] ?></span>
<?php if(!empty($ask['reward'])){?>
	<span style="color:red;font-weight:bold;float:left;margin-left:10px" title="此题悬赏<?=$ask['reward']?>积分">
	悬赏<?=$ask['reward']?>
	<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
	</span><span class="fenge">|</span>
<?php }?>
<?php if($ask['tid'] > 0){?>
	<span class="renwusou"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></span>
	<?php if($ask['uid'] != $user['uid']){?>
	<a class="hrelh" href="javascript:showMsgDialog();" tid="<?=$ask['uid']?>" tname="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>" title="给<?=$ask['sex'] == 1 ? '她' : '他'?>发私信"></a>
	<?php }?>
	<span class="fenge">|</span><span>所属学科：</span><span><?= $ask['foldername'] ?></span><span class="fenge">|</span><span><?= date('Y-m-d H:i:s',$ask['dateline']) ?></span><span class="fenge">|</span><a style="text-decoration: underline;color:#3195c6;" href="javascript:qshield(<?= $ask['qid']?>)">屏蔽问题</a></p>
<?php }else{?>
	<span class="renwusou"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></span>
		<?php if($ask['uid'] != $user['uid']){?>
		<a class="hrelh" href="javascript:showMsgDialog();" tid="<?=$ask['uid']?>" tname="<?= empty($ask['realname'])?$ask['username']:$ask['realname'] ?>" title="给<?=$ask['sex'] == 1 ? '她' : '他'?>发私信"></a>
		<?php }?>
	<span class="fenge">|</span><span>所属学科：</span><span><?= $ask['foldername'] ?></span><span class="fenge">|</span><span><?= date('Y-m-d H:i:s',$ask['dateline']) ?></span><span class="fenge">|</span><a href="javascript:qshield(<?= $ask['qid']?>)" style="text-decoration: underline;color:#3195c6;" >屏蔽问题</a></p>
<?php }?>
<div class="wenwen" style="width:740px"><?= $ask['message'] ?>&nbsp;</div>

<?php if(!empty($ask['audiosrc'])) { ?>
<div class="waibo" id="waibo_q_<?= $ask['qid'] ?>" status="0" style="height:83px;width:740px;float:left">
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
<div class="dengtu" style="float:left;width:740px">
	<ul>
		<li style="width:auto;height:auto;padding:2px">
			<div class="bg photo_photolist_inner">
			<p class="photo_photolist_img" style="width:auto;height:auto;">
			<a style="display:block;height: 100%;overflow: hidden;" href="<?= $ask['imagesrc'] ?>">
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
<?php if($ask['reqid']){?><span><a class="xiugaibtn" href="/troom/myask/<?=$ask['reqid']?>.html">查看关联问题</a></span><?php }?>
<?php if($ask['status'] == 1) { ?>
	<?php if(($user['groupid']==5)&&($ask['uid'] != $user['uid'])){?>
		<!--<a href="javascript:UDialog('tandaandiv');" class="xiugaibtn">解 答</a>-->
	<?php }else{ ?>
		<span style="float:right;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/jiejuebtn0507.jpg"></span>
	<?php } ?>
<?php } else if($ask['uid'] != $user['uid']) { ?>
	<!--<a href="javascript:UDialog('tandaandiv');" class="xiugaibtn">解 答</a>-->
<?php } else { ?>
<!--	<a href="<?= geturl('troom/myask/editquestion/'.$qid) ?>" class="xiugaibtn">修改问题</a>
	<a href="javascript:delask(<?= $qid ?>,'<?= $ask['title'] ?>');" class="shanchubtn">删除问题</a>-->
<?php } ?>
</div>
</div>
<div class="tithui">
<span class="heida">回答</span><span>默认排序</span>
</div>

<?php if(!empty($answers)){ ?>
	<div class="sixists" style="">
	<ul>

	<?php foreach ($answers as $answer) { ?>

	<?php 
	$defaulturl = $answer['sex'] == 1 ? ($answer['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($answer['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
	$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
	$face =  empty($answer['face']) ? $defaulturl:$answer['face'];
	$face = getthumb($face,'50_50');
	?>

	<li class="xianda" id="detail_<?= $answer['aid'] ?>">
	<?php if($answer['isbest'] == 1) { ?>
	<img style="position: absolute;bottom:0px;right:0px;width:168px;height:168px;" src="http://static.ebanhui.com/ebh/tpl/default/images/zuijiaico0507.png" />
	<?php } ?>

	<div class="rentuwai">
	<img src="<?= $face ?>" style="width:50px;height:50px;"/></div>
	<div class="twoxiang">
	<p class="huirenw"><?= empty($answer['realname']) ?  $answer['username'] : $answer['realname'] ?></p>
<?php if($answer['uid'] != $user['uid']){?>
	<a class="hrelh" href="javascript:;" tid="<?=$answer['uid']?>" tname="<?= empty($answer['realname'])?$answer['username']:$answer['realname'] ?>" title="给<?=$answer['sex'] == 1 ? '她' : '他'?>发私信"></a>
<?php }?>
	<p class="huitime"><?= date('Y-m-d H:i:s',$answer['dateline']) ?></p>
	</div>
	<div class="rietitsize" style=" position: relative;">
		<span class="fenge">|</span>
		<span class="terks"><a href="javascript:addthankanswer(<?= $ask['qid']?>,<?= $answer['aid'] ?>)">感谢(<span id="detailthkcount_<?= $answer['aid'] ?>"><?= $answer['thankcount'] ?></span>)</a></span>
	<?php if($answer['shield']==0){ ?>
		<span class="fenge">|</span>
		<span style=" height: 30px;line-height: 30px;">
		<a href="javascript:shield(<?= $ask['qid']?>,<?= $answer['aid']?>)">屏蔽</a>
		</span>
		
	<?php }else{ ?>
		<span class="fenge">|</span>
		<span style=" height: 30px;line-height: 30px;">
		<a href="javascript:cancelshield(<?= $ask['qid']?>,<?= $answer['aid']?>)">取消屏蔽</a>
		</span>
	<?php }?>
	</div>
	<div class="huide">
	<?php if($answer['shield']==0){ ?>
		<?= $answer['message'] ?>
	<?php }else{ ?>
		<span style="color:red">该回答已被屏蔽</span>
	<?php } ?>
	</div>

	<?php if(!empty($answer['audiosrc'])) { ?>
	<div class="bowaid" style="float:none">
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
			<li style="width:auto;height:auto;">
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

	<?php if(!empty($answer['cwid']) && !empty($answer['cwsource'])) { ?>
	<div class="bowaid" style="width:700px">
		<br>
		<button class="playbtn" onclick='parent.showplayDialog("<?=$answer['cwsource']?>",<?=$answer['cwid']?>)'>查看附件</button>
	</div>
	<?php } ?>

	<?php if($answer['uid'] == $user['uid'] && $answer['isbest'] != 1) { ?>
	<a href="javascript:delanswer(<?= $qid ?>,<?= $answer['aid'] ?>)" class="shandaanbtn" style="margin-left:10px;">删除答案</a>
	<?php } ?>

	<?php if($answer['isbest'] != 1) { ?>
	<a href="javascript:setbest(<?= $ask['qid'] ?>,<?= $answer['aid'] ?>)" class="zuijiabtn">最佳答案</a>
	<?php } ?>

	</li>
	<?php } ?>

	</ul>
	</div>
	<?= $pagestr ?>
<?php } ?>

</div>
<div id="tandaandiv" qid="<?= $ask['qid'] ?>" class="tandaan" style="float:left;display:none;width:676px;padding:20px;">
<div class="topjies"><h2 class="tithuit">请写下您的解答，您也可以试试功能强大的 <a class="ejieda" href="javascript:playask(<?= $ask['qid'] ?>)">e板会解答</a>。</h2><a class="rigguan" href="javascript:closeWindow('tandaandiv')"><img src="http://static.ebanhui.com/ebh/tpl/default/images/guanbi0508.jpg" /></a></div>
<!--<div class="zhumai">

<?php
        $editor->xEditor('message','675px','310px');
?>
    <a  qid="<?=$qid?>" class="tijiaobtn">提  交</a>
</div>-->
</div>

<!--发送私信dialog start-->
<div class="waiyry" id="msgDialog" style="display:none;width:698px;">
<div class="chouad" style="height:auto">
<span class="shyten">收件人：</span>
<div class="ewater" style="height:36px;">
<ul id="wrap2"><li tid="<?=$ask['uid']?>" class="lvtewu"><?= empty($ask['realname']) ? $ask['username'] : $ask['realname'] ?></li></ul>
</div>
</div>
<textarea class="txttiantl" name="summary"></textarea>
<div class="wtkkr" style="padding-bottom:15px;">
内容不超过500字
<a id="clearmessge" class="reler" style="color:white !important;cursor:pointer">清 空</a>
<a id="sendmessage" class="tjewkc" style="color:white !important;cursor:pointer">发 送</a>
</div>

</div>

<!--屏蔽问题提示框-->
<div id="shquestion" class="tanchukuang" style="display:none;height:160px;">
    <div class="tishi" style="padding-top:20px;"><span>你确定要屏蔽该问题吗？</span></div>
</div>
<!--屏蔽回答提示框-->
<div id="shanswer" class="tanchukuang" style="display:none;height:160px;">
    <div class="tishi" style="padding-top:20px;"><span>你确定要屏蔽该回答吗？</span></div>
</div>
<!--取消屏蔽回答提示框-->
<div id="cancelanswer" class="tanchukuang" style="display:none;height:160px;">
    <div class="tishi" style="padding-top:20px;"><span>你确定要取消该回答的屏蔽吗？</span></div>
</div>
<!--删除答案-->
<div id="delanswer" class="tanchukuang" style="display:none;height:160px;">
    <div class="tishi" style="padding-top:20px;"><span>你确定要删除该答案吗？</span></div>
</div>

<script type="text/javascript">
$(function(){
	$("#clearmessge").click(function(){
		$("textarea.txttiantl",parent.document).val("");
	});
	
	$("#sendmessage").click(function(){
		var msg =  $.trim($("textarea.txttiantl",parent.document).val());
		var tid = $("#wrap2 li:first",parent.document).attr("tid");
		
		if($("#wrap2",parent.document).html() == ''){
			alert("收件人错误");
			return;
		}
		if(msg.length==0){
			alert('请输入内容');
			return;
		} else if(msg.length>500){
			alert('内容不超过500字');
			return;
		}
		$.ajax({
			type: "POST",
		    url: "<?=geturl('troom/msg/do_send')?>",
		    data:{tid:tid, msg:msg},
		    success:function(res){
		        if(res=="1"){
					$.showmessage({
						message:'发送成功！',
						callback :function(){
							parent.window.H.get('msgDialog').exec('close');
						}
					});
				}else{
					$.showmessage({message:'发送失败'});
				} 
		 	}
		});
	});
	
	$(".hrelh").click(function(){
		parent.window.H.get('msgDialog').exec('show');
		//每次打开重置收件人和信息内容
		$("#wrap2",parent.document).html("");
		$("textarea.txttiantl",parent.document).val("");
		//添加收件人
		var tid = $(this).attr("tid");
		var tname = $(this).attr("tname");
		$("#wrap2",parent.document).append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');	
		//焦点对话框
		$("textarea.txttiantl",parent.document).focus();
	});

	//创建dialog
    parent.window.H.remove('msgDialog');
	$('#msgDialog',parent.window.document.body).remove();
    parent.window.H.create(new P({
        id:'msgDialog',
        title:'发私信',
        easy:true,
        content:$("#msgDialog")[0]
      }),'common');
	
});
function showMsgDialog(){
	parent.window.H.get('msgDialog').exec('show');
}
</script>
<!--发送私信dialog end-->

<script type="text/javascript">
function addfavorit(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
        var url = '<?= geturl('aroomv2/information/addfavorit') ?>';
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
        var url = '<?= geturl('aroomv2/information/addthank') ?>';
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
        var url = '<?= geturl('aroomv2/information/addthankanswer') ?>';
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

$(function(){
    $(".tijiaobtn").click(function(){
        submitanswer($(this).attr("qid"),$(this));
    })
})
	function callback(){
		var qid = $(".tijiaobtn").attr("qid");
		var dom = $(".tijiaobtn");
		submitanswer(qid,dom);
	}
	
    function submitanswer(qid,dom) {
        var tips = "提交解答";
        var message = UM.getEditor('message').getContent();
		var audio = window.parent.document.getElementById('audio').value;
		var cwid = window.parent.document.getElementById('cwid').value;
		var cwsource = window.parent.document.getElementById('cwsource').value;
        if($.trim(HTMLDeCode(message)) == "") {
            alert("请输入回答内容");
            return false;
        }
        var url = '<?= geturl('aroomv2/information/addanswer') ?>';
        $.ajax({
            url:url,
            type:'post',
            data:{'qid':qid,'message':message,'audio':audio,'cwid':cwid,'cwsource':cwsource},
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
                        // document.location.href = document.location.href;
                        location.reload();
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
	var url = '<?= geturl('aroomv2/information/setbest') ?>';
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
    var url = '<?= geturl('aroomv2/information/delask') ?>';
    var successurl = '<?= geturl('troom/myask') ?>';
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
function delanswer(qid,aid){
	var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				delanswerd(qid,aid);
				H.get('delanswer').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('delanswer').exec('close');
				return false;
			}
		});

		if(!H.get('delanswer')){
			H.create(new P({
				id : 'delanswer',
				title: '删除答案',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#delanswer')[0]
			}),'common').exec('show');
			
		}else{
			H.get('delanswer').exec('show');
		}
}
function delanswerd(qid,aid){
	$.ajax({
			type:'post',
			url:'<?= geturl('aroomv2/information/delanswer')?>',
			dataType:'text',
			data:{'qid':qid,'aid':aid},
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'答案删除成功！'});
					document.location.href =  document.location.href;
                                        $("#detail_"+aid).remove();
                                        
				}else{
					$.showmessage({message:'对不起，答案删除失败，请稍后再试！'});
				}
			},
			error:function(){
				alert("删除答案失败，请稍后再试或联系管理员。");
			}
		});	
}



//屏蔽问题
function qshield(qid){
	var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				questionshield(qid);
				H.get('shquestion').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('shquestion').exec('close');
				return false;
			}
		});

		if(!H.get('shquestion')){
			H.create(new P({
				id : 'shquestion',
				title: '屏蔽问题',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#shquestion')[0]
			}),'common').exec('show');
			
		}else{
			H.get('shquestion').exec('show');
		}
			
}
	function questionshield(qid){
	
		$.ajax({

			type:'post',
			url:'<?= geturl('aroomv2/information/qshield')?>',
			dataType:'json',
			data:{'qid':qid,'shield':1},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					document.location.href = "<?= geturl('aroomv2/information/ateaask')?>";
				}else{
					alert("屏蔽问题失败");
				}
			},
			error:function(){
				alert("屏蔽问题失败，请稍后再试或联系管理员。");
			}
		});	
}

//屏蔽回答
function shield(qid,aid){
	var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				answershield(qid,aid);
				H.get('shanswer').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('shanswer').exec('close');
				return false;
			}
		});

		if(!H.get('shanswer')){
			H.create(new P({
				id : 'shanswer',
				title: '屏蔽回答',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#shquestion')[0]
			}),'common').exec('show');
			
		}else{
			H.get('shanswer').exec('show');
		}
}
function answershield(qid,aid){
	$.ajax({
			type:'post',
			url:'<?= geturl('aroomv2/information/ashield')?>',
			dataType:'json',
			data:{'qid':qid,'aid':aid,'shield':1},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					alert("屏蔽回答成功");
					location.reload(true);
				}else{
					alert("屏蔽回答失败");
				}
			},
			error:function(){
				alert("屏蔽回答失败，请稍后再试或联系管理员。");
			}
		});	
}
//取消屏蔽的回答
function cancelshield(qid,aid){
	var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				cancelanswershield(qid,aid);
				H.get('cancelanswer').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('cancelanswer').exec('close');
				return false;
			}
		});

		if(!H.get('cancelanswer')){
			H.create(new P({
				id : 'cancelanswer',
				title: '屏蔽评论',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#cancelanswer')[0]
			}),'common').exec('show');
			
		}else{
			H.get('cancelanswer').exec('show');
		}
}
function cancelanswershield(qid,aid){
	$.ajax({
			type:'post',
			url:'<?= geturl('aroomv2/information/ashield')?>',
			dataType:'json',
			data:{'qid':qid,'aid':aid,'shield':0},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					alert("取消屏蔽回答成功");
					location.reload(true);
				}else{
					alert("取消屏蔽回答失败");
				}
			},
			error:function(){
				alert("取消屏蔽回答失败，请稍后再试或联系管理员。");
			}
		});	
}


</script>
<?php $this->display('aroomv2/page_footer')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
