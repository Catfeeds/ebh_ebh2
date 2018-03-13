<?php $this->display('college/room_header'); ?>
<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'college','window_type' => 'self')); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
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
.lefrig img{
    max-width:920px;
}
.problemdetail {
	line-height:normal;
}
.problemdetail-1 {
	width:840px;
	line-height:normal;
}
<?php 
	$islive = $this->input->get("islive");
?>
<?php if($islive == 1){?>
	.clay_topfixed{
		display:none;
	}
	.reward{
		display:none;
	}
	.ctop{
		display:none;
	}
	.lefrig-2{
		margin-top:0;
	}
<?php } ?>	
</style>
<body>
<div class="lefrig">
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
			
        	<a href="<?= geturl('college/myask/editquestion/'.$qid) ?>" class="modify-1">修改</a>
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
            <?php $ipaddress = !empty($answer['ipaddress'])? $answer['ipaddress']: $answer['fromip'];?>
                <img class="questionerhead-1" src="<?php echo getavater($answer);?>" title="<?= $answer['fromip'].'('.$ipaddress.')';?>" />
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
		
        <?php }?>
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


<div id="rewarddiv" style="display:none;">
<form id="rewardform">
    <input type="hidden" name="qid" value="<?=$ask['qid']?>"/>
    <div id="revalidate" style="background:#fff;height:450px;width:550px;overflow-y:auto">
    
    <div class="rewardinfo">
    <span class="infospan">总悬赏积分：<span><?=$ask['reward']?></span></span>
    <span class="infospan">未分配积分：<span style="color:red" id="unassign"><?=$ask['reward']?></span></span>
    <span class="initreward infospan">初始化</span>
    </div>
    <span class="rewarddes">* 积分可以分配给多人,积分和不超过总悬赏积分</span>
    <?php 
    if(!empty($answerers)){
    foreach($answerers as $k=>$answerer){
        $defaulturl = $answerer['sex'] == 1 ? ($answerer['groupid']==5 ? 't_woman.jpg' : 'm_woman.jpg') : ($answerer['groupid']==5 ? 't_man.jpg' : 'm_man.jpg');
        $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
        $face =  empty($answerer['face']) ? $defaulturl:$answerer['face'];
        $face = getthumb($face,'50_50');
    ?>
    
    <div style="float:left;width:250px;margin-left:10px;margin-top:15px">
        <div style="float:left;width:80px;margin-left:25px">
            <div class="answererface">
                <img class="aface" src="<?=$face?>" />
            </div>
        </div>
        
        <div style="float:left;width:105px">
            <span class="whoans" title="<?=!empty($answerer['realname'])?$answerer['realname']:$answerer['username']?>"><?=!empty($answerer['realname'])?shortstr($answerer['realname'],10):shortstr($answerer['username'],10)?></span>
            
            <input type="text" value="0" name="rewards[]" class="numinput" id="numinput<?=$k?>" maxlength="3"/>
            <div class="updown">
                <input type="button" class="upbtn" id="up<?=$k?>"/>
                <input type="button" class="downbtn" id="down<?=$k?>"/>
            </div>
            <input type="hidden" name="aids[]" value="<?=$answerer['aid']?>"/>
            
        </div>
        
        
    </div>
    <?php }?>
        
    <?php }?>
    </div>
</form>
<div style="float:left;width:550px;text-align:center;background:#C7EBFF">
            <input type="button" class="surebtn" value="确定"/>
        </div>
</div>
</body>
<script type="text/javascript">
if(window.parent.ws != undefined){
	var myWs = window.parent.ws;
	var parentAddView = window.parent.addView;
	parentAddView("<?php echo $qid;?>");
	var myAddview = {type:"asksync",dtype:"addview",qid:"<?php echo $qid;?>"};
	myWs.send(JSON.stringify(myAddview));
}
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


    (function($) {
        //图片加载失败处理
        $("ul.questionerpic-2 img").bind('error', function() {
            var that = $(this);
            var sourceUrl = that.attr('src');
            var reg = sourceUrl.match(/_(\d+)_(\d+)/);
            if (reg) {
                sourceUrl = sourceUrl.replace(/_\d+_\d+/, '');
                that.attr('src', sourceUrl).css('width', reg[1]+"px").css('height', reg[2]+'px');
            }
            that.unbind('error');
        });
    })(jQuery);
<?php if(!empty($audioque)){ ?>
    $(function(){
    <?php foreach ($audioque as $ado) {?>
    voicePlayer({
            box: $("#questionaudio"),
            src: "<?php echo $ado['audiosrc'];?>",
            time: <?php if(empty($ado['audiotime'])){echo 0;}else{echo $ado['audiotime'];}?>
        }).show();
<?php } ?>
})
<?php } ?>
function delask(qid,title) {
    var url = '<?= geturl('college/myask/delask') ?>';
    var successurl = '<?= geturl('college/myask/all') ?>';
    top.dialog({
        title: '删除确认',
        content: '您确定要删除问题 【 '+ title +'】 吗？',
        width:370,
        okValue: '确定',
        ok: function () {
        $.ajax({
            url:url,
            type:'post',
            data:{'qid':qid},
            dataType:'text',
            success:function(data){
                if(data=='success'){
                	if(window.parent.ws != undefined){
                		var data = {type:"asksyncinit"}
						myWs.send(JSON.stringify(data));
						$("#askView_" + <?php echo $qid;?>,parent.document).remove();
                	}else{
                		document.location.href = successurl;
                	}
                }else{
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        width:350,
                        content: "<div class='FPic'></div><p>对不起，问题删除失败，请稍后再试！</p>",
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
    },
 cancelValue: '取消',
        cancel: function () {}
    }).showModal();
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
function setbest(qid,aid) {
    var tips = "设置最佳答案";
    var url = '<?= geturl('college/myask/setbest') ?>';
    $.ajax({
        url:url,
        type:'post',
        data:{'qid':qid,'aid':aid},
        dataType:'text',
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
function reward(){
    H.create(new P({
        id : 'artdialogcourse',
        title: '发布悬赏积分',
        easy : true,
        padding:10,
        content: $('#rewarddiv')[0]
    }),'common').exec('show');
}
$('.upbtn').click(function(){
    var id = $(this).attr('id');
    id = id.replace('up','');
    var num = parseInt($('#numinput'+id).val())+1;
    var leftreward = countall($('#numinput'+id)[0]);
    if(num<=leftreward){
        $('#numinput'+id).val(num);
        leftreward -= num;
    }else{
        leftreward = 0;
    }
    $('#unassign').html(leftreward);
});
$('.downbtn').click(function(){
    var id = $(this).attr('id');
    id = id.replace('down','');
    var num = parseInt($('#numinput'+id).val())-1;
    var leftreward = countall($('#numinput'+id)[0]);
    if(num>=0){
        $('#numinput'+id).val(num);
        leftreward -= num;
    }else{
        // leftreward = <?=$ask['reward']?>;
    }
    $('#unassign').html(leftreward);
});
$('.surebtn').click(function(){
    if($('#unassign').html()!=0)
    {
        alert('请分配完所有的积分再按确定。');
        return ;
    }
    $.ajax({
        type:'post',
        url:'/college/myask/reward.html',
        data:$('#rewardform').serialize(),
        success:function(data){
            var res = eval('('+data+')');
            if(res.status ==1){
                $.showmessage({
                    img      :'success',
                    message  :res.msg,
                    callback :function(){
                        location.reload();
                    }
                });
                
            }else{
                $.showmessage({
                    img      :'error',
                    message  :res.msg
                });
            }
        }
    })
});
$('.initreward').click(function(){
    $.each($('.numinput'),function(k,v){
        $(this).val(0);
    });
    $('#unassign').html(<?=$ask['reward']?>);
});
$(".numinput").on('blur',function(){
    var score = $(this).val();
    if(isNaN(score) || score < 0){
        score = 0;
        $(this).val(score);
    }
    var unassign = $(".infospan span").html();
    $(".numinput").each(function(){
        unassign = unassign - $(this).val();
    });
    unassign = parseInt(unassign) + parseInt(score);
    if(score > unassign){
        score = unassign;
        $(this).val(score);
    }
    var scoreleft = parseInt(unassign) - parseInt(score);
    $("#unassign").html(scoreleft);
});
function countall(target){
    var leftreward = <?=$ask['reward']?>;
    $.each($('.numinput'),function(k,v){
            if(target == v)
                curinput = $(this);
            else{
                var tr = parseInt($(this).val());
                if(tr<=leftreward){
                    $(this).val(tr);
                    leftreward -= tr;
                }else{
                    $(this).val(leftreward);
                    leftreward = 0;
                }
            }
            
        });
    return leftreward;
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
