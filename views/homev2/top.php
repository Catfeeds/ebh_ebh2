<?php
if(empty($hidetop)){
$uername = empty($user['realname']) ? $user['username'] : $user['realname'] ;
$this->assign("uername",$uername);
?>
<div class="divcontent">
	<div class="cmaint">
		<div class="cmaintlp" style="width:297px;">
		<?php
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(!empty($roominfo['crid'])){
        	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']); 
        }else{
        	$is_zjdlr = false;
	        $is_newzjdlr = false;
        }
		?>
		<?php if(!$is_zjdlr){ ?>
        	<div class="xiutgt fr mt10">
            	<a href="/homev2/score/description.html" class="clsra"><span style="padding-left:15px;"><?=$clinfo['title']?></span></a>
            </div>
        <?php }else{ ?>
        	<div style="margin-top:30px"></div>
        <?php }?>
            <div class="clear"></div>
			<div class="reyuhdr">
            	<div class="touxiang">
					<a class="listbr" href="/homev2/profile/<?=!$is_zjdlr?'avatar':'profile'?>.html"></a>
                	<img width="78" height="78" src="<?=getavater($user,'78_78')?>">
            	</div>
                <div class="rigang">
                    <div class="mt5">
                        <a href="<?=geturl('homev2/profile/profile')?>"><p class="name" title="<?=$uername?>"><?=shortstr($uername, 6)?></p></a>
                        <?php if(!$is_zjdlr){ ?><p class="jifen"><a href="/homev2/score/credit.html"><?=$user['credit']?></a></p><?php }?>
                    </div>
                    <div class="clear"></div>
                    <div class="ents">
                    	<p class="gerenxx"><a href="/homev2/profile.html">个人信息</a></p>
						<div>
                            <div class="kewar">
                                <span style="width:<?=$percent?>%;" class="jifenico"></span>
                            </div>
                            <div class="frel">
                                <span style="float:left; line-height:10px; color: #999;font-family: Arial; padding-left:5px;"><?=$percent?>%</span>
                            </div>
                        </div>
					</div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="qrhuhs">
            	<p style="width:230px; text-align:left;" class="qianmings">
                	<span title="<?=empty($user['mysign']) ? '点击修改签名' : $user['mysign']?>" style="display:block;width:235px;cursor:text; text-align:left;" id="mysign_span"><?=empty($user['mysign']) ? '暂无签名' : shortstr($user['mysign'])?></span>
                    <input type="text" style="display:none;width:195px;border:1px solid #9eb7cb;height:20px;line-height:20px;padding:0 5px;margin-top:5px;margin-bottom:1px;" id="mysign" maxlength="140">
                </p>
            </div>
            <?php if( isset($enable_sns) && $enable_sns && !$is_zjdlr && $roominfo['crid'] > 0){ ?>
            <div class="gzfs">
            	<div class="ferl">
                	<a target="_blank" href="/myroom.html?url=/sns/follow.html" class="snsa"><span class="span1s"><?=$myfavoritcount?></span><br><span class="span2s">关注</span></a>
                </div>
                <div class="frrye">
                	<a target="_blank" href="/myroom.html?url=/sns/follow/fans.html" class="snsa"><span class="span1s"><?=$myfanscount?></span><br><span class="span2s">粉丝</span></a>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="cmainfr">
            <div>
                <div class="titler">
                	<span>Hello！<?=$uername?> <?php if($user['groupid'] == 5) {?>老师<?php }else {?> 同学<?php }?>。</span>
                </div>
            </div>
            <div class="clear"></div>
            <div class="esukang">
                <a class="zzhuye <?=($controller=='default')?"onhover":""?>" href="/homev2/default/index.html" title="我的网校">我的网校</a>
                <a class="wttruy <?=($controller=='profile'||$controller=='safety')?"onhover":""?>" href="/homev2/profile/profile.html" title="个人信息">个人信息</a>
                <?php if(!$is_zjdlr){ ?>
                <a class="bstkma <?=($controller=='purse')?"onhover":""?>" href="/homev2/purse/index.html" title="钱包管理">钱包管理</a>
                <a class="sitrtu <?=($controller=='score')?"onhover":""?>" href="/homev2/score.html" title="积分计划">积分计划</a>
                <?php } ?>
                <a class="sttryu <?=($controller=='notice')?"onhover":""?>" href="/homev2/notice.html" title="消息通知">消息通知</a>
                <?php if(isset($enable_sns) && $enable_sns && (!$is_zjdlr) && $roominfo['crid'] > 0){?>
                <a class="mykong" target="_blank" href="/myroom.html?url=/sns/feeds.html" title="我的空间">我的空间</a>
                <?php }?>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
$(function(){
	//积分超过万的时候保留1位小数用中文万表示，如1.0万
   	var $jifen = $(".jifen a");
   	var $xiutgt = $(".xiutgt span");
    var jifen = $jifen.html();
    if( jifen >= 10000 ){
    	$xiutgt.html("文曲星");
    }
   	if(parseInt(jifen / 10000) > 0){
   		var jifenStr = jifen+"";
		jifen = parseInt(jifen / 10000);
		$jifen.html(jifen+"."+jifenStr[jifenStr.length-4]+"万");
   	}
	//修改签名
	$("#mysign_span").click(function(){
		var mytitle = $("#mysign_span").attr("title");
		if (mytitle == '点击修改签名') mytitle = '';
		//显示输入框
		$("#mysign_span").hide();
		$("#mysign").show();
		$("#mysign").focus();
		$("#mysign").val(mytitle);
	});

	$("#mysign").blur(function(){
		var mysign = $("#mysign").val();
		var mytitle = $("#mysign_span").attr("title");
		if (mytitle == '点击修改签名') mytitle = '';
		//判断长度小于140字符
		if (mysign.length>140) {
			alert("签名请不要超过140个字");
			$("#mysign").focus();
			return false;
		};
		//有修改时保存
		if (mysign != mytitle)
		{
			//ajax保存
			$.ajax({
				url:"<?=geturl('home/profile/editmysign')?>",
				type:"post",
				data:{mysign:mysign},
				dataType:"json",
				success: function(data){
					if(data.code == 1){
						$("#mysign_span").html(data.mysign);
						if (mysign == '') mysign = '点击修改签名';
						$("#mysign_span").attr("title", mysign);
						$("#mysign").hide();
						$("#mysign_span").show();
					}
					else if(data.code == -1){
					var str = '';
                    	$.each(data.Sensitive,function(name,value){
                    		str+=value+'&nbsp;';
                    	});
                    	var d = dialog({
							title: '提示',
							content: '签名包含敏感词汇'+str+'！请修改后重试...',
							cancel: false,
							okValue: '确定',
							ok: function () {
							}
						});
						d.showModal();
						return false;
				}
					else
					{
						var msg = data.Sensitive ? "编辑失败,签名包含有敏感字<br>"+ data.Sensitive: "编辑失败";
						dialog({
							title:"提示信息",
							content:msg,
							cancel:false,
							onshow:function () {
								var that=this;
								setTimeout(function () {
									that.close().remove();
								},2000);
							}
							}).show();

						$("#mysign").hide();
						$("#mysign_span").show();
					}
				}
			});
		}
		else
		{
			//显示签名
			$("#mysign").hide();
			$("#mysign_span").show();
		}
	});
});
</script>
<?php }?>