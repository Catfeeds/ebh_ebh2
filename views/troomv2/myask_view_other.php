
<?php $this->display('troomv2/room_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troomv2','window_type' => 'self')); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
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
<div class="lefrig" style="float:none;background:none;">
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
            <a href="javascript:void(0);" onclick="qshield(<?= $ask['qid'];?>)" style="color:#999;font-size:13px;line-height:25px;float:right;">屏蔽提问</a>
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
        <?php if(!empty($answer['cwid']) && !empty($answer['cwsource'])) { ?>
            <div class="bowaid mt5">
                <button class="playbtn" onclick='showplayDialog("<?=$answer['cwsource']?>",<?=$answer['cwid']?>)'>查看附件</button>
            </div>
        <?php } ?>
        <div class="clear"></div>
        <div class="attentionanswer">
        <div class="attention" style="display:inline-block;">
        <?php if(!empty($ask['aid'])){?>
            <a href="javascript:addfavorit(<?php echo $ask['qid'];?>,0);" class="attention-1 on">已关注</a>
        <?php }else{ ?>
            <a href="javascript:addfavorit(<?php echo $ask['qid'];?>,1)" class="attention-1">关注</a>
        <?php }?>
        </div>
        <?php if(!empty($ask['status'])){ ?>
            <a href="javascript:void(0)" class="answer-1 on">已解答</a>
        <?php }else{?>
            <a href="javascript:UDialogv2('tandaandiv');" class="answer-1">解答</a>
        <?php }?>
        </div>
    </div>
    <div class="lefrig-3">
        <h2 class="answerall-1">全部回答</h2>
        <?php if(!empty($answers)){ ?>
            <?php foreach ($answers as $answer) { ?>
        <div class="answerallist">
            <div class="answerallistson">
                <img class="questionerhead-1" src="<?php echo getavater($answer);?>"  title="<?= $answer['fromip'].'('.$answer['IPaddress'].')'; ?>" />
                <span class="questioner-1"  title="<?= $answer['fromip'].'('.$answer['IPaddress'].')'; ?>"><?php echo getusername($answer);?></span>
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
            <div class="problemdetail-1" >
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
            <div class="clear"></div>
            <?php if($answer['isbest']){ ?>
            <div class="bestanswer"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/zjda.png" /></div>
            <?php } ?>
            <?php if($user['uid'] == $answer['uid']){ ?>
            <div class="deleteanswer"><span onclick="delanswer(<?php echo $qid;?>,<?php echo $answer['aid']?>,<?=$answer['isbest']?>)">删除答案</span></div>
            <?php }else{ ?>
            <div class="deleteanswer"><span onclick="shield(<?php echo $qid;?>,<?php echo $answer['aid']?>,<?=$answer['isbest']?>)">屏蔽解答</span></div> 
            <?php }?>
        </div>
        <?php }?>
		
		<?php } else { ?>
		<div class="nodata"></div>

        <?php } ?>
        <?php echo $pagestr;?>
    </div>
</div>
<div style="display:none;">
    <div id="tandaandiv" class="tandaan2" style="float:left;display:none;width:676px;padding:20px;text-align:left;">
    <div class="zhumai">
    <?php
        EBH::app()->lib('UEditor')->xEditor('message','775px','310px');
    ?>
<!--上传音频-->
    <div id="audio"></div>
    <a qid="<?=$qid?>" class="tijiaobtn">提  交</a>
    </div> 
<!--结束-->
    </div>
   </div>
</div>
</body>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js<?=getv()?>"></script>
<script type="text/javascript">
loadaudioDialog('audio');
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
function showDialog(dom,qid){
        window.dom = dom;
        if(H.get(dom)){
            H.get(dom).exec('show');
            return;
        }

        H.create(new P({
            title:"解答编辑器",
            content:$("#"+dom)[0],
            id:dom,
            width:820,
            easy:true
        },{
            'onclose':function(){
                //UE.reset();
                UE.getEditor('message').reset();
                closeAduio();
                return false;
            },
            'onshow':function(){
                
                UE.getEditor('message').focus();
                UE.getEditor('message').setContent("");
                //UE.setContent("");
                return false;
            }
        }),'common').exec('show');
    }
function UDialogv2(dom){
    var qid = $("#"+dom).attr('qid');
    showDialog(dom,qid);
}
function letter(dom,which){
    window.dom = dom;
    if(H.get(dom)){
        H.get(dom).exec('show');
        return;
    }
    H.create(new P({
        title:"发送私信",
        content:$("#"+dom)[0],
        id:dom,
        width:642,
        height:530,
        easy:true
    }),'common').exec('show');
    $('.foot').css('display','none');
    $('#qbsx').val(which);
}
function sendMessage(){
        callback();
        try{
            UE.getEditor('message').reset();
            //ue.reset();
            closeAduio();
            H.get(dom).exec('close');
        }catch(e){

        }
    }
$(function(){
    $(".tijiaobtn").click(function(){
        submitanswer($(this).attr("qid"),$(this));
    });
});
function submitanswer(qid,dom) {
    var tips = "提交解答";
    var message = UE.getEditor('message').getContent();
    var audio  = new Array();
    $(".hiddenaudio input").each(function(){
        audio.push($(this).val());
    });
    if($.trim(HTMLDeCode(message)) == "") {
        var d = dialog({
            title: '提示',
            content: '请输入内容！',
            okValue: '确定',
            cancel: false,
            ok: function () {}
        });
        d.showModal();
        return false;
    }
    var url = '<?= geturl('troomv2/myask/addanswer') ?>';
    $.ajax({
        url:url,
        type:'post',
        data:{'qid':qid,'message':message,'audio':audio},
        dataType:'json',
        success:function(data){
        if(data.status==1){
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='TPic'></div><p>"+tips+"成功</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function () {
                            closeWindow('tandaandiv');
                            location.reload();
                            that.close().remove();
                        }, 1000);
                    }
                }).show();
            }else if(data.status == -1){
                var str = '';
                    $.each(data.Sensitive,function(name,value){
                        str+=value+'&nbsp;';
                    });
                    var d = dialog({
                        title: '提示',
                        content: '答案包含敏感词汇'+str+'！请修改后重试...',
                        cancel: false,
                        okValue: '确定',
                        ok: function () {  
                                  
                        }
                    });
                    d.showModal();
                    return false;
            }else{
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='FPic'></div><p>"+tips+"失败</p>",
                    width:350,
                    onshow:function () {
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
function sendletter(tid){
    var msg =  $.trim($("textarea.txttiantl").val());
    var tid = tid;
    if(msg.length==0){
var d = dialog({
    title: '提示',
    content: '请输入内容！',
    okValue: '确定',
    cancel: false,
    ok: function () {}
});
d.showModal();
        return;
    } else if(msg.length>500){
    var d = dialog({
    title: '提示',
    content: '内容不超过500字！',
    okValue: '确定',
    cancel: false,
    ok: function () {}
});
d.showModal();
        return;
    }
    $.ajax({
        type: "POST",
        url: "<?=geturl('troomv2/msg/do_send')?>",
        data:{tid:tid, msg:msg},
        success:function(res){
            if(res=="1"){
                var d = dialog({
                    title: '发送成功',
                    content: '发送成功！',
                    cancel: false,
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                setTimeout("location.reload();",800);
            }else{
                var d = dialog({
                    title: '发送失败',
                    content: '发送失败！',
                    cancel: false,
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
            }
        }
    });
}
function addfavorit(qid,flag) {
    var tips = "取消关注";
    if(flag == 1) {
        tips = "关注问题";
    }
        var url = '<?= geturl('troomv2/myask/addfavorit') ?>';
    $.ajax({
        url:url,
        type:'post',
        data:{'qid':qid,'flag':flag},
        dataType:'text',
        success:function(data){
            if(data=='success'){
                changefavorite(qid,flag);
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
            }else{
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='FPic'></div><p>"+tips+"失败</p>",
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
function changefavorite(qid,flag) {
    var html = "";
    if(flag == 1) {
        html = '<a href="javascript:addfavorit('+qid+',0);" class="attention-1 on">已关注</a>';  
    } else {
        html = '<a href="javascript:addfavorit('+qid+',1)" class="attention-1">关注</a>';
    }
    $(".attention").html(html);
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
$(".answerallist").last().css('border-bottom','0px');
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php $this->display('common/player'); ?>
<?php $this->display('myroom/page_footer'); ?>
<?php $this->display('myroom/room_footer'); ?>
