<?php $this->display('college/room_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'college','window_type' => 'self')); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js<?=getv()?>"></script>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css<?=getv()?>" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css<?=getv()?>"/>

<script type="text/javascript">
$(function() {
    try{
    $('.dengtu a').lightBox();
    }catch(error){}
});
</script>
<style type="text/css">
body{
	background:#f2f2f2;
}
.voice-player{
    margin-left: 10px;
}
.rewardinfo{
    font-size:26px;
    
    text-align:center;
}
.infospan{
    float:left;
    margin-left:20px;
}
.initreward{
    background: #18a8f7;
    width: 58px;
    height: 22px;
    line-height: 22px;
    display: inline-block;
    color: #fff;
    text-decoration: none;
    font-size: 12px;
    cursor: pointer;
    margin-top:8px;
}
.rewarddes{

    float:left;
    margin-left:30px;
    width:500px;
    color:#666;
}
.answererface{
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/rentubg0507.jpg) no-repeat;
    width: 60px;
    height: 60px;
    float: left;
    padding: 4px;
    margin-top: -7px;
    margin-left: -6px
}
.aface{
    float:left;
    width:50px;
    height:50px;
    border:solid 1px #dcdcdc;
}
.whoans{
    float:left;
    height:14px;
    width:90px;
    line-height:14px;
    font-size:14px;
    
}
.numinput{
    float:left;
    width:70px;
    height:28px;
    line-height:28px;
    font-size:24px;
    border: 1px solid #72C2F4;
    text-indent:10px;
    background:white;
    margin-top:5px;
}
.updown{
    width:14px;
    float:left;
    margin-left:10px;
    margin-top:5px;
}
.upbtn{
    height:14px;
    width:14px;
    border:none;
    background:url(http://static.ebanhui.com/ebh/tpl/2014/images/up.png);
    float:left;
    margin-bottom:2px;
}
.downbtn{
    height:14px;
    width:14px;
    border:none;
    background:url(http://static.ebanhui.com/ebh/tpl/2014/images/down.png);
    float:left;
}
.playbtn{
    float:left;
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
.surebtn {
    float: left;
    background: #18a8f7;
    width: 190px;
    height: 32px;
    display: inline;
    float: left;
    line-height: 32px;
    text-align: center;
    margin-left: 175px;
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
    border: none;
}
.lefrig-3{
	width:920px;
	padding:0 40px;
	display:inline-block;
}
.problemdetail {
	line-height:normal;
}
</style>
<body>
<div class="lefrig" style="background:none;">
    <div class="lefrig-2">
        <h2 class="problemstitle-1"><a href="javascript:void(0)"><?php echo $ask['title'];?></a></h2>
        <div class="questinformation-1 questinformationline">
            <span  class="questiontime-2"><?php echo timetostr($ask['dateline'],'Y-m-d');?></span>
            <img class="questionerhead" src="<?php echo getavater($ask);?>" />
            <span class="questioner" title="<?php echo getusername($ask);?>"><?php echo getusername($ask,8);?></span>
            <?php if($user['uid'] != $ask['uid']){?>
            <a href="javascript:void(0)" class="hrelh privateletter" tid="<?php echo $ask['uid'];?>" tname = "<?php echo getusername($ask);?>" style="background:url(http://static.ebanhui.com/ebh/tpl/2016/images/fsx-ico.png) no-repeat center;height:25px;margin:0px;padding-left:0px;"></a>
            <?php }?>
            <p class="coursewarelink"><?php if(!empty($ask['foldername'])){?><?php echo $ask['foldername'];?><?php }?> <?php if(!empty($ask['cwname'])){ ?> > <?php echo $ask['cwname'];?><?php }?></p>
        </div>
        <div class="audioplayer-1" id="questionaudio"></div>
        <div class="problemdetail">
        	<?php 
            if(!empty($ask['message'])){
                $pattern = '/<img.*?src="(.*?zuijiaico0507.png)".*?>/is';
                $pattern_new = '/<img.*?src="(.*?zjda.png)".*?>/is';
                if(preg_match($pattern, $ask['message'])){
                    $ask['message'] = preg_replace($pattern,'',$ask['message']);
                }
                if(preg_match($pattern, $ask['message'])){
                    $ask['message'] = preg_replace($pattern_new,'',$ask['message']);
                }
                echo $ask['message'];
            }
            ?>
        </div>
        <?php 
        if(!empty($ask['imagesrc'])){
            $imgs = explode(',',$ask['imagesrc']);
            ?>
        <div class="dengtu" style="width:auto;">
            
        <ul class="questionerpic-2 ">
        <?php foreach ($imgs as $key => $img) { $v= $key%3; ?>
            <?php if($v == 0){?>
            <li class="first">
            <?php }else{?>
            <li>
            <?php }?>
            <div class="bg photo_photolist_inner">
            <p class="photo_photolist_img" style="width:auto;height:auto;">
                <a href="<?= $img ?>">
                    <img src="<?= getthumb($img,'277_195')?>" />
                </a>
            </p>
            </div>
            </li>
        <?php } ?>
        </ul>
        </div>
        <?php }?>
        <div class="clear"></div>
        <div class="attentionanswer">
        <?php if($ask['reward'] && empty($rewardlist)){?>
        <a href="javascript:void(0)" onclick="reward()" class="offerreward-1">悬赏积分</a>
        <?php }?>
        <?php if($ask['status'] == 0){?>
			
        	<a href="<?= geturl('troomv2/myask/editquestion/'.$qid) ?>" class="modify-1">修改</a>
            <a href="javascript:delask(<?= $qid ?>,'<?= $ask['title'] ?>');" class="delete-1">删除</a>
        <?php }else{?>
            <a href="javascript:void(0)" class="answer-1 on">已解答</a>
        <?php }?>
        </div>
    </div>
    <div class="lefrig-3">
		<h2 class="answerall-1">全部回答</h2>
        <?php if(!empty($answers)){ ?>
            <?php foreach ($answers as $answer) { ?>
        <div class="answerallist">
            <div class="answerallistson">
                <img class="questionerhead-1" src="<?php echo getavater($answer);?>" title="<?= $answer['fromip'].'('.$answer['IPaddress'].')'; ?>" />
                <span class="questioner-1" title="<?= $answer['fromip'].'('.$answer['IPaddress'].')'; ?>"><?php echo getusername($answer);?></span>
                <?php if($answer['uid'] != $user['uid']){?>
                <a href="javascript:void(0)" class="privateletter privateletter-1 hrelh" tid="<?php echo $answer['uid'];?>" tname="<?php echo getusername($answer);?>" style="background:url(http://static.ebanhui.com/ebh/tpl/2016/images/fsx-ico.png) no-repeat center;height:36px;margin:0px;padding-left:0px;"></a>
                <?php }?>
                <span  class="questiontime-3"><?php echo timetostr($answer['dateline'],'Y-m-d');?></span>
                <?php if(empty($answer['thatday'])){?>
                <span class="thank-1 atk_<?php echo $answer['aid']?>" onclick="addthankanswer(<?php echo $qid;?>,<?php echo $answer['aid'];?>)">感谢(<span class="thank_<?php echo $answer['aid']?>"><?php echo $answer['thankcount'];?></span>)</span>
                <?php }else{ ?>
                <span class="thank-1 on atk_<?php echo $answer['aid']?>" onclick="addthankanswer(<?php echo $qid;?>,<?php echo $answer['aid'];?>)">感谢(<?php echo $answer['thankcount'];?>)</span>
                <?php }?>
                <?php if($ask['status'] == 0 && !empty($bestpower)){?>
                <span class="setbestanswer" onclick="setbest(<?php echo $qid?>,<?php echo $answer['aid']?>)">设为最佳答案</span>
                <?php }?>
            </div>
            <?php if(!empty($answer['audio'])){ ?>
                <?php foreach ($answer['audio'] as $ak => $audio) { ?>
                    <div id="answer_<?php echo $answer['aid'];?>_<?php echo $ak;?>" class="audioplayer-1" style="float:left;margin-left:10px;"></div>
                    <script>$(function(){
                        voicePlayer({
                            box: $("#answer_<?php echo $answer['aid'];?>_<?php echo $ak;?>"),
                            src: "<?php echo $audio['audiosrc'];?>",
                            time: <?php echo $audio['audiotime'];?>
                        }).show();
                    })</script>
                <?php }?>
            <?php }?>
            <div class="clear"></div>
            <div class="problemdetail-1">
                <?php 
                    $message = $answer['message'];
                    $pattern = '/<img.*?src="(.*?zuijiaico0507.png)".*?>/is';
                    $pattern_new = '/<img.*?src="(.*?zjda.png)".*?>/is';
                    if(preg_match($pattern, $message)){
                        $message = preg_replace($pattern,'',$message);
                    }
                    if(preg_match($pattern, $message)){
                        $message = preg_replace($pattern_new,'',$message);
                    }
                    echo $message;
                ?>
            </div>
            <?php if(!empty($answer['cwid']) && !empty($answer['cwsource'])) { ?>
            <div class="bowaid mt5">
                <button class="playbtn" onclick='showplayDialog("<?=$answer['cwsource']?>",<?=$answer['cwid']?>)'>查看附件</button>
            </div>
            <?php } ?>
            <div class="clear"></div>
            <?php if($answer['isbest']){ ?>
            <div class="bestanswer"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/zjda.png" /></div>
            <?php } ?>
            <?php if($user['uid'] == $answer['uid']){ ?>
            <div class="deleteanswer"><span onclick="delanswer(<?php echo $qid;?>,<?php echo $answer['aid']?>,<?=$answer['isbest']?>)">删除解答</span></div>
            <?php }else{?>
            <div class="deleteanswer"><span onclick="shield(<?php echo $qid;?>,<?php echo $answer['aid']?>,<?=$answer['isbest']?>)">屏蔽解答</span></div>    
            <?php }?>
        </div>
        <?php }?>
		
		<?php } else { ?>
		<div class="nodata"></div>
		
        <?php }?>
        <?php echo $pagestr;?>
    </div>
</div>
</body>
<script type="text/javascript">
<?php if(!empty($audioque)){ ?>
    $(function(){
    <?php foreach ($audioque as $ado) { ?>
    voicePlayer({
            box: $("#questionaudio"),
            src: "<?php echo $ado['audiosrc'];?>",
            time: <?php echo $ado['audiotime'];?>
        }).show();
<?php } ?>
})
<?php } ?>
function delask(qid,title) {
    var url = '<?= geturl('troomv2/myask/delask') ?>';
    var successurl = '<?= geturl('troomv2/myask') ?>';
    var d = dialog({
        title: '删除确认',
        content: '您确定要删除问题【' + title + '】吗？',
        okValue: '确定',
        ok: function () {
            $.ajax({
                url:url,
                type:'post',
                data:{'qid':qid},
                dataType:'text',
                success:function(data){
                    if(data=='success'){
                        dialog({
                            skin:"ui-dialog2-tip",
                            content:"<div class='TPic'></div><p>问题删除成功！正在关闭页面...</p>",
                            width:350,
                            onshow:function () {
                                var that=this;
                                setTimeout(function () {
                                    closePage();
                                    that.close().remove();
                                }, 2000);
                            }
                        }).show();                  
                    }else{
                        dialog({
                            skin:"ui-dialog2-tip",
                            content:"<div class='FPic'></div><p>对不起，问题删除失败，请稍后再试！</p>",
                            width:350,
                            onshow:function () {
                                var that=this;
                                setTimeout(function () {
                                    document.location.href =  document.location.href;
                                    that.close().remove();
                                }, 2000);
                            }
                        }).show();  
                    }
                }
            });
        },
        cancelValue: '取消',
        cancel: function () {}
    });
    d.showModal();
}
function addthankanswer(qid,aid) {
    var tips = "感谢";
        var url = '<?= geturl('troomv2/myask/addthankanswer') ?>';
    $.ajax({
        url:url,
        type:'post',
        data:{'qid':qid,'aid':aid},
        dataType:'text',
        success:function(data){
            if(data=='success'){
                var num = parseInt($(".thank_"+aid).html());
                $(".thank_"+aid).html(num+1);
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='TPic'></div><p>"+tips+"成功！</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function () {
                            that.close().remove();
                        }, 1000);
                    }
                }).show();
                $('.atk_'+aid).addClass('on');
            }else if(data == 'fail'){
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='FPic'></div><p>"+tips+"失败！</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function () {
                            that.close().remove();
                        }, 1000);
                    }
                }).show();
            }else if(data == 'thatday'){
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='PPic'></div><p>您今天已经感谢过了！</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function () {
                            that.close().remove();
                        }, 1000);
                    }
                }).show();
            }
        }
    });
}
//删除答案
function delanswer(qid,aid,isbest) {
    var url = '<?= geturl('troomv2/myask/delanswer') ?>';
    var d = dialog({
        title: '删除确认',
        content: '您确定要删除您的问题答案吗？',
        okValue: '确定',
        ok: function () {
        $.ajax({
            url:url,
            type:'post',
            data:{'qid':qid,'aid':aid,'isbest':isbest},
            dataType:'text',
            success:function(data){
                if(data=='success'){
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='TPic'></div><p>答案删除成功！</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function () {
                                document.location.href =  document.location.href;
                                that.close().remove();
                            }, 2000);
                        }
                    }).show();  
                }else{
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='FPic'></div><p>对不起，答案删除失败，请稍后再试！</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function () {
                                document.location.href =  document.location.href;
                                that.close().remove();
                            }, 2000);
                        }
                    }).show();  
                }
            }
        });
    },
 cancelValue: '取消',
        cancel: function () {}
    });
    d.showModal();
}
function setbest(qid,aid) {
    var tips = "设置最佳答案";
    var url = '<?= geturl('troomv2/myask/setbest') ?>';
    $.ajax({
        url:url,
        type:'post',
        data:{'qid':qid,'aid':aid},
        dataType:'json',
        success:function(data){
            if(data=='success'){
                document.location.href = document.location.href;    
            }else{
                top.dialog({
                    skin:"ui-dialog2-tip",
                    width:350,
                    content: "<div class='FPic'></div><p>"+tips+"失败！</p>",                  
                    onshow:function(){
                        var that=this;
                        setTimeout(function () {
                            that.close().remove();
                        }, 2000);
                    }
                }).show();
            }
        }
    });
}
//屏蔽回答
function shield(qid,aid,isbest){
            var url = "<?= geturl('troomv2/myask/shield')?>";
            var d = dialog({
                title: '屏蔽回答',
                content: '您确定要屏蔽该回答吗？屏蔽后不可查看该回答！',
                okValue: '确定',
                ok: function () {
            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data:{'qid':qid,'aid':aid,'isbest':isbest},
                success:function(data){
                    if(data !== undefined && data.status !== undefined && data.status == 1) {
                        dialog({
                            skin:"ui-dialog2-tip",
                            content:"<div class='TPic'></div><p>屏蔽回答信息成功！</p>",
                            width:350,
                            onshow:function () {
                                var that=this;
                                setTimeout(function () {
                                    document.location.href =  document.location.href;
                                    that.close().remove();
                                }, 1000);
                            }
                        }).show();
                    } else {
                        dialog({
                            skin:"ui-dialog2-tip",
                            content:"<div class='FPic'></div><p>屏蔽回答失败，请稍后再试或联系管理员！</p>",
                            width:350,
                            onshow:function () {
                                var that=this;
                                setTimeout(function () {
                                    document.location.href =  document.location.href;
                                    that.close().remove();
                                }, 2000);
                            }
                        }).show();
                    }
                }
            }); 
        },
    cancelValue: '取消',
    cancel: function () {}
    });
    d.showModal();
}
//播放课件或者下载附件
function showplayDialog(source,cwid){
    if(typeof courseObj == "undefined"){
        courseObj = new Course();
    }
    if(!source || !cwid){
        return false;
    }
    courseObj.userplay(source,cwid);return false;
}
//屏蔽问题

var tips =dialog({
    title: '提示信息',
    content: '',
    cancel: false
});


function qshield(qid){
    var d = dialog({
    title: '提示',
    content: '您确定要屏蔽该问题吗？屏蔽后不可查看该问题!',
    okValue: '确定',
    ok: function () {
            d.close();
            var url = "<?= geturl('troomv2/myask/qshield')?>";
            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data:{'qid':qid},
                success:function(data){
                    if(data != undefined && data.status != undefined && data.status == 1) {
                            u = 'http://'+"<?php echo $roominfo['domain'];?>"+'.ebh.net/troomv2.html?url=';
                            document.location.href = u+"<?= geturl('troomv2/myask/allquestion')?>";
                    } else {
                        var msg = '屏蔽问题失败，请稍后再试或联系管理员。';
                        if(data != undefined && data.msg != undefined)
                            msg = data.msg;
                            tips.content(msg);
                            tips.show();
                            setTimeout(function () {
                                tips.close();
                            }, 2000);
                    }
                }
            });
        return false;
    },
    cancelValue: '取消',
    cancel: function () {}
});
d.showModal();
}
function closePage() {
    var Browser = navigator.appName;
    var indexB = Browser.indexOf('Explorer');

    if (indexB > 0) {
        var indexV = navigator.userAgent.indexOf('MSIE') + 5;
        var Version = navigator.userAgent.substring(indexV, indexV + 1);

        if (Version >= 7) {
            window.open('', '_self', '');
            window.close();
        }
        else if (Version == 6) {
            window.opener = null;
            window.close();
        }
        else {
            window.opener = '';
            window.close();
        }

    }
    else {
        window.close();
    }
}
$(".answerallist").last().css('border-bottom','0px');
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php $this->display('common/player'); ?>
<?php $this->display('myroom/page_footer'); ?>
<?php $this->display('myroom/room_footer'); ?>
