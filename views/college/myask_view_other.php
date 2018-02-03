<?php $this->display('college/room_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'college','window_type' => 'self')); ?>
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
function loaderr(t) {
    var that = $(t);
    var sourceUrl = that.attr('src');
    var reg = sourceUrl.match(/_(\d+)_(\d+)/);
    if (reg) {
        sourceUrl = sourceUrl.replace(/_\d+_\d+/, '');
        that.attr('src', sourceUrl).css('width', reg[1]+"px").css('height', reg[2]+'px');
    }
    that.unbind('error');
}
</script>
<style type="text/css">
#rewardmain{
    position: relative;
}
.qrcode_big{position: absolute;left: 5px;top:-30px;background: #fff;z-index: 99;border:solid 1px #ccc;width: 312px;height: 312px;}
.qrcode_big img{width: 310px;height: 310px;}
.triangle {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/triangle.jpg) no-repeat;
    width:13px;
    height:12px;
    position: absolute;
    z-index: 101;
    top:312px;
    left:60px;
}
#alipayqrcode iframe{width: 250px;height: 250px;margin-top:35px;margin-left:10px;}
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
.answerbtn{
	display: none;
    width: 98px;
    height: 42px;
    line-height: 40px;
    color: #fff;
    background: #999;
    font-size: 15px;
    font-weight: bold;
    border-radius: 2px;
    text-align: center;
}
.lefrig img{
    max-width:920px;
}
.problemdetail {
	line-height:normal;
}
</style>
<body>
<div class="lefrig" style="float:none;">
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
                    <img class="q-pic" src="<?= getthumb($img,'277_195')?>" onerror="loaderr(this)" />
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
            <a href="javascript:UDialogv2('tandaandiv');" class="answer-1" id="answerbtn0">解答</a>
            <span class="answerbtn" id="answerbtn1">解答 <span id="answernum"></span>s</span>
        <?php }?>
        </div>
    </div>
    <div class="lefrig-3">
        <h2 class="answerall-1">全部回答</h2>
        <?php if(!empty($answers)){ ?>
            <?php foreach ($answers as $answer) { ?>
        <div class="answerallist">
            <div class="answerallistson">
            <?php $ipaddress = !empty($answer['ipaddress'])? $answer['ipaddress']: $answer['fromip'];?>
                <img class="questionerhead-1" src="<?php echo getavater($answer);?>"  title="<?= $answer['fromip'].'('.$ipaddress.')';?>" />
                <span class="questioner-1" title="<?= $answer['fromip'].'('.$ipaddress.')';?>"><?php echo getusername($answer);?></span>
                <?php if($answer['uid'] != $user['uid']){?>
                <a href="javascript:void(0)" class="privateletter privateletter-1 hrelh" tid="<?php echo $answer['uid'];?>" tname="<?php echo getusername($answer);?>" style="background:url(http://static.ebanhui.com/ebh/tpl/2016/images/fsx-ico.png) no-repeat center;height:36px;margin:0px;padding-left:0px;"></a>
                <?php }?>
                <span  class="questiontime-3"><?php echo timetostr($answer['dateline'],'Y-m-d');?></span>
                <?php if(empty($answer['thatday'])){?>
                <span class="thank-1 atk_<?php echo $answer['aid']?>" onclick="addthankanswer(<?php echo $qid;?>,<?php echo $answer['aid'];?>)">感谢(<span class="thank_<?php echo $answer['aid']?>"><?php echo $answer['thankcount'];?></span>)</span>
                <?php }else{ ?>
                <span class="thank-1 on atk_<?php echo $answer['aid']?>" onclick="addthankanswer(<?php echo $qid;?>,<?php echo $answer['aid'];?>)">感谢(<?php echo $answer['thankcount'];?>)</span>
                <?php }?>
            </div>
            <?php if(!empty($answer['audio'])){ ?>
                <?php foreach ($answer['audio'] as $ak => $audio) { ?>
                    <div id="answer_<?php echo $answer['aid'];?>_<?php echo $ak;?>" class="audioplayer-1" style="float:left;margin-left:10px;"></div>
                    <script>$(function(){
                        voicePlayer({
                            box: $("#answer_<?php echo $answer['aid'];?>_<?php echo $ak;?>"),
                            src: "<?php echo $audio['audiosrc'];?>",
                            time: <?php if(empty($audio['audiotime'])){echo 0;}else{echo $audio['audiotime'];}?>
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
            <div class="deleteanswer"><span onclick="delanswer(<?php echo $qid;?>,<?php echo $answer['aid']?>,<?= $answer['isbest']?>)">删除答案</span></div>
            <?php } else {?>
                 <div class="rewardpraise" style="top:60px;z-index:2;width:auto;right: -6px;">
                <?php if(!$iszjdlr){ ?>
                    <div class="reward">
                        <a href="javascript:rewardfa(<?=$answer['aid']?>,'<?php echo getavater($answer);?>')" class="rewarda">赞赏<span id="rewarda_count_<?=$answer['aid']?>" style="margin-left: 5px;"><?=empty($answer['c'])?0:$answer['c']?></span></a>

                    </div>
                </div>
                 <?php } ?>
                <?php }?>

        </div>
        <?php }?>

		<?php } else { ?>
		<div class="nodata"></div>

        <?php } ?>
        <?php echo $pagestr;?>
    </div>
</div>


 <div id="rewardmain" style="display:none;">
    <div id="wxqrcode" class="qrcode_big" style="display: none;">
        <div class="triangle"></div>
        <img src="">
    </div>
    <div id="alipayqrcode" class="qrcode_big"  style="display: none;">
        <div class="triangle"></div>
        <iframe src="" style="border:none!important;border-radius: 0px;" scrolling="no" frameborder="0"></iframe>
    </div>
    <img id="gface" src=""/>
    <div class="tximage"></div>
    <p class="p1s">“你的赞赏，是对我回答的最大鼓励”</p>
    <div class="choosemoney">
        <div class="cmtitle">选择支付金额</div>
        <div class="cmcontent">
            <input type="text" value="18.88" class="inputmoney" onkeyup="Num(this);"/>
            <span class="monyuan">元</span>
            <a href="javascript:;" class="random" style="padding-left:5px;" onclick="randomMoney();">随机</a>
            <span class="ydico">.</span>
            <a href="javascript:;" class="random" onclick="doubled();">加倍</a>
        </div>
    </div>
    <div class="choosemoney">
        <div class="cmtitle">选择支付方式</div>
        <div class="paylist">
            <form>
                <input type="radio" name="payway" id="wechat" class="paywechat" value="wechat" style="margin-left:0;" checked  onclick="paybywechat();"/>
                <label for="wechat">微信</label>
                <input type="radio" name="payway" id="alipay" class="paywechat" value="alipay" onclick="paybyali();" />
                <label for="alipay">支付宝</label>
                <input type="radio" name="payway" id="wallet" class="paywechat" value="wallet" onclick="paybywallet();" />
                <label for="wallet" >我的钱包</label>
            </form>
        </div>
        <div class="wechatpay"  style="display:block;">
            <div class="loading"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif"></div>
            <iframe id="wechatwindow" class="fl" style="border:none;border-radius:0px;width:115px;height:115px;" frameborder="no" border="0" scrolling="no">
            </iframe>
            <p class="wxts" style="width:175px;line-height:20px;padding-left:20px;padding-top:10px;"><span style="color:#f00;">微信</span>扫码完成赞赏<br/><br/>
            更改金额后按住“<span style="color:#f00;">Enter</span>”或<span style="color:#f00;">鼠标单击</span>网页任意空白处完成刷新</p>
        </div>
        <div class="alipay"  style="display:block;">
        <div class="loading"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif"></div>
            <iframe id="alipaywindow" class="fl" style="border:none;border-radius:0px;width:93px;height:93px; padding:11px;" frameborder="no" border="0" scrolling="no">
            </iframe>
            <p class="wxts" style="width:175px;line-height:20px;padding-left:20px;padding-top:10px;"><span style="color:#f00;">支付宝</span>扫码完成赞赏<br/><br/>
            更改金额后按住“<span style="color:#f00;">Enter</span>”或<span style="color:#f00;">鼠标单击</span>网页任意空白处完成刷新</p>
        </div>

        <div style="clear:both;"></div>
        <div class="walletpay">
            <div class="wallete" style="display:none;">
                <input type="button" class="ljzf" value="立即支付"/>
                <span class="balance">我的余额：<b><?php echo $user['balance'];?></b>元</span>
            </div>
            <div class="yebz" style="display:none;">
                <div class="fl yebzimg"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/yebzico.png"/></div>
                <div class="fl yebzwall">钱包余额不足，请先<a href="http://pay.ebh.net/" target="_blank" class="random">充值</a>。<br/>或使用其他方式赞赏。</div>
            </div>
        </div>
    </div>
</div>



<div style="display:none;">
    <div id="tandaandiv" class="tandaan2" style="float:left;display:none;width:676px;padding:20px;text-align:left;">
    <div class="zhumai">
    <?php
        $editor->xEditor('message','775px','310px');
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
<script type="text/javascript">
<?php if(!empty($audioque)){ ?>
    $(function(){
    <?php foreach ($audioque as $ado) { ?>
    voicePlayer({
            box: $("#questionaudio"),
            src: "<?php echo $ado['audiosrc'];?>",
            time: <?php if(empty($ado['audiotime'])){echo 0;}else{echo $ado['audiotime'];}?>
        }).show();
<?php } ?>
})
<?php } ?>
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/recorder.js<?=getv()?>"></script>
<script type="text/javascript">

var timerpay;
var $inp = $('.inputmoney');
$inp.keypress(function (e) {
    var key = e.which;
    if (key == 13) {
        var payway = $('.paywechat:checked').val();
        if(payway == 'wechat'){
            paybywechat();
        }
        if(payway == 'alipay'){
            paybyali();
        }
    }
});
/*打赏点赞*/
function rewardfa(aid,face){
    gaid = aid;
    $("#gface").attr('src',face);
    randomMoney();
    var d=dialog({
        id:"rewardpraise",
        title:"赞赏",
        content:document.getElementById("rewardmain"),
        padding: 20,
        height:440,
        onclose:function(){
            $('.inputmoney').val('0.00');
            $("#wechat").trigger('click');
        }
    });
    d.showModal();
    $(document).keypress(function(e){
        if(d.open&&e.keyCode == 13){
            return false;
        }
    })

}
//随机生成打赏数额
function randomMoney(){
    var moneyarr = new Array('0.66', '1.66', '5.20', '6.66', '8.88', '18.88');
    var index = Math.floor((Math.random()*moneyarr.length));
    var money = $('.inputmoney').val();
    if(money == moneyarr[index]){
        randomMoney();
        return false;
    }
    $('.inputmoney').val(moneyarr[index]);
    var checkboxid = $(".paylist").find('input:checked').attr('id');
    if(checkboxid == 'wechat'){
        paybywechat();
    }else if(checkboxid == 'alipay'){
        paybyali();
    }else{
        $('.ljzf').show();
    }
}
//加倍处理
function doubled(){
    var money = $('.inputmoney').val();
    moneydouble = money*2;
    if(moneydouble > 500){
        $('.inputmoney').val('0.00');
        $(".ljzf").hide();
        $(".wallete").hide();
        $(".alipay").hide();
        $(".wechatpay").hide();
        top.dialog({
            title: '提示信息',
            content: '打赏不能超过500元',
            width:370,
            okValue: '确定',
            cancel: false,
            ok: function () {
            }
        }).showModal();
        return false;
    }
    $('.inputmoney').val(moneydouble);
    var checkboxid = $(".paylist").find('input:checked').attr('id');
    if(checkboxid == 'wechat'){
        paybywechat();
    }else if(checkboxid == 'alipay'){
        paybyali();
    }else{
        $('.ljzf').show();
    }
}
//检验是否选中钱包付款
function checkwallet(){
    return $("#wallet").is(":checked");
}
//限制输入的金额为数字，且最多有两位小数
function Num(obj){
obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
obj.value = obj.value.replace(/^[0]{2,}/g,'0');
if(obj.value >500){
    obj.value = 500;
}
if(obj.value < 0.1 && obj.value >0){
    obj.value = 0.10;
}
}
//使用钱包付款
function paybywallet(){
    clearInterval(timerpay);
    //使用钱包进行付款
        //检查钱包中的钱是否足够支付
        $(".wechatpay").hide();
        $(".alipay").hide();
        var money = $('.inputmoney').val();
        if(money == '0.00'){
            $(".wallete").show();
            $(".yebz").hide();
            return false;
        }else if(money > 500){
            $('.inputmoney').val('0.00');
            $(".ljzf").hide();
            $(".wallete").hide();
            $(".alipay").hide();
            $(".wechatpay").hide();
            top.dialog({
                title: '提示信息',
                content: '打赏不能超过500元',
                width:370,
                okValue: '确定',
                cancel: false,
                ok: function () {
                }
            }).showModal();
            return false;
        }
        setTimeout(function(){
            var url = '/myroom/rewards/checkWallet.html';
        $.ajax({
            url:url,
            data:{money:money},
            type:'post',
            dataType:'json',
            success:function(data){
                if(data.status == 1){//钱足够
                    $(".ljzf").show();
                    $(".wallete").show();
                    $(".balance b").html(data.balance);
                    $(".yebz").hide();
                    $(".wechatpay").hide();
                    $(".alipay").hide();
                }else if(data.status == -2){//钱不够
                    $(".wallete").hide();
                    $(".yebz").show();
                    $(".wechatpay").hide();
                    $(".alipay").hide();
                }else{
                    $(".wechatpay").hide();
                    $(".alipay").hide();
                    $(".wallete").hide();
                    $(".yebz").hide();
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        width:350,
                        content: "<div class='FPic'></div><p>"+data.message+"</p>",
                        onshow:function(){
                            var that=this;
                            setTimeout(function () {
                            that.close().remove();
                            }, 1000);
                        }
                    }).show();
                }
            }
        });
    },100);

}
//使用钱包支付
$(".ljzf").on('click',function(){

    var money = $('.inputmoney').val();
    var url = '/myroom/rewards/rewardByWallet.html';
    var aid = gaid;
    $.ajax({
            url:url,
            data:{money:money,cwid:aid,type:3},
            type:'post',
            dataType:'json',
            success:function(data){
                if(data.status == 1){
                    var moneyhave = $(".balance b").html();
                    var moneyleft = moneyhave - money;
                    $(".balance b").html(moneyleft);
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        title: '',
                        content: "<div class='TPic'></div><p>赞赏成功</p>",
                        width:200,
                        cancel: false,
                        onshow:function(){
                            var that=this;
                            setTimeout(function () {
                            that.close().remove();
                            }, 1000);
                        }
                    }).showModal();
                    $('#rewarda_count_'+gaid).html(parseInt($('#rewarda_count_'+gaid).html())+1)
                    return false;
                }else{
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        width:350,
                        content: "<div class='FPic'></div><p>"+data.message+"</p>",
                        onshow:function(){
                            var that=this;
                            setTimeout(function () {
                            that.close().remove();
                            }, 1000);
                        }
                    }).show();
                    return false;
                }
            }
        });
    if (self.frameElement && self.frameElement.tagName == "IFRAME") {
        dialog.get("rewardpraise").close();
    }else{
        top.dialog.get("rewardpraise").close();
    }

});

//检验打赏金额为空 或者0的时候
$(".inputmoney").on('blur',function(){
    var zeroarr = new Array('',undefined,'0','0.','0.0','0.00');
    var money = $('.inputmoney').val();
    if(zeroarr.indexOf(money) != -1){
        $('.inputmoney').val('0.00');
        $(".ljzf").hide();
        $(".wallete").hide();
        $(".alipay").hide();
        $(".wechatpay").hide();
    } else if(money > 500){
        $('.inputmoney').val('0.00');
        $(".ljzf").hide();
        $(".wallete").hide();
        $(".alipay").hide();
        $(".wechatpay").hide();
        top.dialog({
            title: '提示信息',
            content: '打赏不能超过500元',
            width:370,
            okValue: '确定',
            cancel: false,
            ok: function () {
            }
        }).showModal();
        return false;
    }
    else{
        setTimeout("reflashqr()",100);



    }
});
function reflashqr(){
    var checkboxid = $(".paylist").find('input:checked').attr('id');
    if(checkboxid == 'wechat'){
            paybywechat();
        }else if(checkboxid == 'alipay'){
            paybyali();
        }else{
            $('.ljzf').show();
        }
}
//点击支付宝支付
function paybyali(){
    clearInterval(timerpay);
    $(".wallete").hide();
    $(".yebz").hide();
    $(".wechatpay").hide();
    $(".loading").show();
    var money = $('.inputmoney').val();
    var zeroarr = new Array('',undefined,'0','0.','0.0','0.00');
    if(zeroarr.indexOf(money) != -1){
        return false;
    }
    if(money >500){
        $('.inputmoney').val('0.00');
        $(".ljzf").hide();
        $(".wallete").hide();
        $(".alipay").hide();
        $(".wechatpay").hide();
        top.dialog({
            title: '提示信息',
            content: '打赏不能超过500元',
            width:370,
            okValue: '确定',
            cancel: false,
            ok: function () {
            }
        }).showModal();
        return false;
    }
    setTimeout(function(){
    var aid = gaid;
    var url = '/myroom/rewards/alipayOrder.html';
    $.ajax({
            url:url,
            data:{money:money,cwid:aid,type:3},
            type:'post',
            dataType:'json',
            success:function(data){
                $(".wallete").hide();
                $(".yebz").hide();
                $(".wechatpay").hide();
                if(data.status ==1){
                    var url = '/myroom/rewards/alipayQRDate.html?ordernum='+data.ordernum+'&ordername='+data.ordername+'&money='+data.money;
                    $("#alipaywindow").attr('src',url);
                    $('#alipayqrcode iframe').attr('src',url + '&w=245');
                    $(".alipay").show();
                    var oFrm = document.getElementById('alipaywindow');
                    oFrm.onload = oFrm.onreadystatechange = function() {
                         if (this.readyState && this.readyState != 'complete') return;
                         else {

                            $('#alipaywindow').hover(function(){

                                $('#alipayqrcode').show();
                            },function(){
                                $('#alipayqrcode').hide();
                            })
                            $(".loading").hide();
                         }
                    }
                    clearInterval(timerpay);
                    timerpay = setInterval(function(){
                    $.ajax({
                        url:"/myroom/rewards/getpaystatus.html",
                        type:'POST',
                        data:{ordernum:data.ordernum},
                        dataType:'JSON',
                        success:function(json){
                                if(json.code){
                                    clearInterval(timerpay);
                                    if (self.frameElement && self.frameElement.tagName == "IFRAME") {
                                            dialog.get("rewardpraise").close();
                                        }else{
                                            top.dialog.get("rewardpraise").close();
                                        }
                                    top.dialog({
                                        skin:"ui-dialog2-tip",
                                        title: '',
                                        content: "<div class='TPic'></div><p>赞赏成功</p>",
                                        width:200,
                                        cancel: false,
                                        onshow:function(){
                                            var that=this;
                                            setTimeout(function () {
                                            that.close().remove();
                                            }, 1000);
                                        }
                                    }).showModal();
                                    $('#rewarda_count_'+gaid).html(parseInt($('#rewarda_count_'+gaid).html())+1)
                                    return false;
                                }
                            }
                        });
                    },2000);

                }else{
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        width:350,
                        content: "<div class='FPic'></div><p>"+data.message+"</p>",
                        onshow:function(){
                            var that=this;
                            setTimeout(function () {
                            that.close().remove();
                            }, 1000);
                        }
                    }).show();
                    return false;
                }
            }
        });
},100);
}
//使用微信支付
function paybywechat(){
    clearInterval(timerpay);
    $(".wallete").hide();
    $(".yebz").hide();
    $(".alipay").hide();
    $(".loading").show();
    var zeroarr = new Array('',undefined,'0','0.','0.0','0.00');
    var money = $('.inputmoney').val();
    if(zeroarr.indexOf(money) != -1){
        return false;
    }
    if(money >500){
        $('.inputmoney').val('0.00');
        $(".ljzf").hide();
        $(".wallete").hide();
        $(".alipay").hide();
        $(".wechatpay").hide();
        top.dialog({
            title: '提示信息',
            content: '打赏不能超过500元',
            width:370,
            okValue: '确定',
            cancel: false,
            ok: function () {
            }
        }).showModal();
        return false;
    }
    setTimeout(function(){
    var aid = gaid;
    var url = '/myroom/rewards/wechatOrder.html';
    $.ajax({
            url:url,
            data:{money:money,cwid:aid,type:3},
            type:'post',
            dataType:'json',
            success:function(data){
                $(".wallete").hide();
                $(".yebz").hide();
                $(".alipay").hide();
                if(data.status ==1){
                    var url = '/myroom/rewards/wxpayQRcode.html?ordernum='+data.ordernum+'&ordername='+data.ordername+'&money='+data.money;
                    $("#wechatwindow").attr('src',url);
                    $("#wechatwindow_big").attr('src',url);
                    $(".wechatpay").show();
                    var oFrm = document.getElementById('wechatwindow');
                    oFrm.onload = oFrm.onreadystatechange = function() {
                         if (this.readyState && this.readyState != 'complete') return;
                         else {
                            var img = $(document.getElementById('wechatwindow').contentWindow.document.body).find('img');
                            $(img[0]).hover(function(){

                                $('#wxqrcode>img').attr('src',$(img[0]).attr('src'));
                                $('#wxqrcode').show();

                            },function(){
                                $('#wxqrcode>img').attr('src','')
                                $('#wxqrcode').hide();
                            })
                             $(".loading").hide();
                         }
                    }
                    clearInterval(timerpay);
                    timerpay = setInterval(function(){
                    $.ajax({
                        url:"/myroom/rewards/getpaystatus.html",
                        type:'POST',
                        data:{ordernum:data.ordernum},
                        dataType:'JSON',
                        success:function(json){
                                if(json.code){
                                    clearInterval(timerpay);
                                    if (self.frameElement && self.frameElement.tagName == "IFRAME") {
                                        dialog.get("rewardpraise").close();
                                    }else{
                                        top.dialog.get("rewardpraise").close();
                                    }
                                    top.dialog({
                                        skin:"ui-dialog2-tip",
                                        title: '',
                                        content: "<div class='TPic'></div><p>赞赏成功</p>",
                                        width:200,
                                        cancel: false,
                                        onshow:function(){
                                            var that=this;
                                            setTimeout(function () {
                                            that.close().remove();
                                            }, 1000);
                                        }
                                    }).showModal();
                                    $('#rewarda_count_'+gaid).html(parseInt($('#rewarda_count_'+gaid).html())+1)
                                    return false;
                                }
                            }
                        });
                    },2000);
                    //top.dialog.get("rewardpraise").close();
                }else{
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        width:350,
                        content: "<div class='FPic'></div><p>"+data.message+"</p>",
                        onshow:function(){
                            var that=this;
                            setTimeout(function () {
                            that.close().remove();
                            }, 1000);
                        }
                    }).show();
                    return false;
                }
            }
        });
},100);
}





	var timelag3;
	$.ajax({
		type: "GET",
		url: '/register/getbindstatus.html',
		dataType: 'json',
		async: false,
		success:function(json){
			timelag3 = json.data.review_interval;
		},
		error: function(){
			console.log("接口错误！");
		}
	});
	if(timelag3 == undefined){
		timelag3 = 0;
	}


	function setCookie(name, value, expiredays, path) {
	    var Days = 30;
	    var exp = new Date();
	    exp.setTime(exp.getTime() + expiredays*1000);
	    var path = (path == null) ? ";path=/" : ";path="+path;
	    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + path;
	}
	//读取cookies
	function getCookie(name){
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	    if(arr=document.cookie.match(reg))
	        return (arr[2]);
	    else
	        return null;
	}

	//删除cookies
	function delCookie(name){
	    var exp = new Date();
	    exp.setTime(exp.getTime() - 1);
	    var cval=getCookie(name);
	    if(cval!=null)
	        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}
	var $answerbtn0 = $("#answerbtn0");
	var $answerbtn1 = $("#answerbtn1");
	var $answernum = $("#answernum");

	jiedatime();
	function jiedatime(){
		var endtimejieda = getCookie("jiedacookie");
		var nowtimejieda = Date.parse(new Date())/1000;
		var resttimejieda = endtimejieda - nowtimejieda;
		if(endtimejieda == null){
			$answerbtn1.css("display","none");
			$answerbtn0.css("display","inline-block");
		}else{
			if(resttimejieda <= 0){
				$answerbtn1.css("display","none");
				$answerbtn0.css("display","inline-block");
			}else{
				$answerbtn1.css("display","inline-block");
				$answerbtn0.css("display","none");
				$answernum.html(resttimejieda);
				var timebackfatie = setInterval(function(){
					nowtimejieda = Date.parse(new Date())/1000;
					resttimejieda = endtimejieda - nowtimejieda;
					$answernum.html(resttimejieda);
					if(resttimejieda <= 0){
						clearInterval(timebackfatie); //清除计时器
						delCookie('jiedacookie');//删除cookie
						$answerbtn1.css("display","none");
						$answerbtn0.css("display","inline-block");
					}
				},1000);
			}
		}
	}




<?php if(!$iszjdlr){?>
loadaudioDialog('audio');
<?php }?>
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
                ue.reset();
                closeAduio();
                return false;
            },
            'onshow':function(){
                ue.focus();
                ue.setContent("");
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
            ue.reset();
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
    var url = '<?= geturl('college/myask/addanswer') ?>';
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
                        setTimeout(function () {//todo:关闭悬浮框
                            //closeWindow('tandaandiv');
                            location.reload();
                            that.close().remove();
                        }, 1000);
                    }
                }).show();
                var timestamp = Date.parse(new Date())/1000;
                timelag3 = parseInt(timelag3);
				var timeend = timestamp + timelag3;
                setCookie('jiedacookie', timeend , timelag3, "/");
                jiedatime();

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
        url: "<?=geturl('college/msg/do_send')?>",
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
                setTimeout("location.href='/college/myask/"+<?= $qid?>+".html'",800);
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
        var url = '<?= geturl('college/myask/addfavorit') ?>';
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
    var url = '<?= geturl('college/myask/delanswer') ?>';
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
function addthankanswer(qid,aid) {
    var tips = "感谢";
        var url = '<?= geturl('college/myask/addthankanswer') ?>';
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
$(".answerallist").last().css('border-bottom','0px');

</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<?php $this->display('common/player'); ?>
<?php $this->display('myroom/page_footer'); ?>
<?php $this->display('common/icp_footer'); ?>
