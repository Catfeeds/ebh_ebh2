<?php $this->display('aroomv2/page_header');?>
<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/more')?>">更多应用</a> > <a href="<?=geturl('aroomv2/ethsetting')?>">微校通设置</a> > 提交配置

    </div>
    <div id="hitdiv" class="tijiaopz mt15">
<?php
$inputstyle = empty($config['isvalid']) ? '' : 'style="display:none;" ';
$spanstyle = empty($config['isvalid']) ? 'style="display:none;"' : '';
?>
    	<p class="tjpzts" style="padding-top:0;">第一步：请准确填写下列信息，确认无误后点击提交，您的网校及微信服务号就成功开通微校通功能了。</p>
        <div class="tjpzts">一、基本信息</div>
        <div class="tjpzjbxxson">
			<span class="lxfs">联系方式：</span>
			<input type="text" class="lxfsinput" id="phone" value="<?=empty($config['phone'])?'请输入与您微信绑定的手机号码':$config['phone']?>" onfocus="if($(this).val()=='请输入与您微信绑定的手机号码')$(this).val('');" onblur="if($.trim($(this).val())==''){$(this).val('请输入与您微信绑定的手机号码');}" <?=$inputstyle?>/>
			<span class="lxfs" id="phone_span" <?=$spanstyle?>><?=empty($config['phone'])?'':$config['phone']?></span>
            <p class="lxfsts">用于开通微校通功能时联系微信服务号的管理员。请务必准确填写。</p>
			<span class="lxfs">网校名称：</span>
			<input type="text" class="lxfsinput" id="marks" value="<?=empty($config['marks'])?$roominfo['crname']:$config['marks']?>" onfocus="if($(this).val()=='请输入您的网校名称')$(this).val('');" onblur="if($.trim($(this).val())==''){$(this).val('请输入您的网校名称');}" <?=$inputstyle?>/>
			<span class="lxfs" id="marks_span" <?=$spanstyle?>><?=empty($config['marks'])?'':$config['marks']?></span>
        </div>
        <div class="tjpzts">二、配置信息
        	<span class="pzxxts">提示：打开<a href="https://mp.weixin.qq.com/" target="_blank">微信公众平台</a>，登陆您的服务号。查找相关信息填入下表即可。</span>
        </div>
        <div class="tjpzjbxxson tjpzxxson">
            <span class="lxfs lxfs1s">AppID：</span>
			<input type="text" class="lxfsinput fl" id="appID" value="<?=empty($config['appID'])?'':$config['appID']?>" <?=$inputstyle?>/>
			<span class="lxfs" id="appID_span" <?=$spanstyle?>><?=empty($config['appID'])?'':$config['appID']?></span>
            <div class="clear"></div>
            <p class="lxfst1s">在 "开发" ＞ "基本配置"页面中查看。<a href="<?=geturl('aroomv2/ethsetting/help')?>#appid" target="_blank">查看使用帮助</a></p>
			<span class="lxfs lxfs1s">AppSecret：</span>
			<input type="text" class="lxfsinput fl" id="appsecret" value="<?=empty($config['appsecret'])?'':$config['appsecret']?>" <?=$inputstyle?>/>
			<span class="lxfs" id="appsecret_span" <?=$spanstyle?>><?=empty($config['appsecret'])?'':$config['appsecret']?></span>
            <div class="clear"></div>
            <p class="lxfst1s">在 "开发" ＞ "基本配置"页面中查看。<a href="<?=geturl('aroomv2/ethsetting/help')?>#appid" target="_blank">查看使用帮助</a></p>
            <span class="lxfs lxfs1s">模板ID：</span>
			<input type="text" class="lxfsinput fl" id="tempid" value="<?=empty($config['template']['tempid'])?'':$config['template']['tempid']?>" <?=$inputstyle?>/>
			<span class="lxfs" id="tempid_span" <?=$spanstyle?>><?=empty($config['template']['tempid'])?'':$config['template']['tempid']?></span>
            <div class="clear"></div>
            <p class="lxfst1s">在 "开发" ＞ "基本配置"页面中查看。<a href="<?=geturl('aroomv2/ethsetting/help')?>#tplid" target="_blank">查看使用帮助</a></p>
        </div>
    	<a href="javascript:;" class="tjbtn" id="savesetting" <?=$inputstyle?>>提交</a>
        <a href="javascript:;" class="xiugaibtn" id="editsetting" <?=$spanstyle?>>修改</a>
        <div class="lines1"></div>
        <p class="tjpzts" style="padding-top:0;">第二步：点击"创建"按钮，就能在您的微信服务号中自动创建如图自定义菜单。</p>
        <div class="tjpzts">
        	<span class="fl">图例：</span>
        	<img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/xjzdycd.jpg" class="fl" />
        </div>
        <div class="clear"></div>
        <?php if (empty($config['ismenu'])){?>
        <a href="javascript:;" id="makemenu" class="tjbtn xiugaibtn1s">创建</a>
        <? } else {?>
        <a href="javascript:;" class="xiugaibtn xiugaibtn1s">已创建</a>
        <?php }?>
    </div>
</div>

<!--弹框提示-->
<div id="tipsuccess" class="pzcg" style="display: none">
	<p class="pzcgs">配置成功!</p>
    <a href="javascript:;" onclick="window.location.reload();" class="tjbtn" style="width:115px; margin-top:45px;">确定</a>
</div>
<div id="tiperror" class="pzcg" style="display: none">
	<p class="pzcgs">配置失败!</p>
    <p class="pzsbts">请检查配置信息是否输入无误。</p>
    <a href="javascript:;" onclick="H.get('dialogtip').exec('close');" class="tjbtn" style="width:115px; margin-top:25px;">确定</a>
</div>
<div id="menusuccess" class="pzcg" style="display: none">
	<p class="pzcgs">创建成功!</p>
    <p class="pzsbts">可打开您的微信服务号进行查看。</p>
    <a href="javascript:;" onclick="window.location.reload();" class="tjbtn" style="width:115px; margin-top:25px;">确定</a>
</div>
<div id="menuerror" class="pzcg" style="display: none">
	<p class="pzcgs">创建失败!</p>
    <a href="javascript:;" onclick="H.get('dialogtip').exec('close');" class="tjbtn" style="width:115px; margin-top:25px;">确定</a>
</div>
<script type="text/javascript">
if(!H.get('dialogtip')){
	H.create(new P({
		id : 'dialogtip',
		easy:true,
		padding:0
	}),'common');
}
//保存配置
$("#savesetting").click(function(){
	var phone = $("#phone").val();
	var marks = $("#marks").val();
	var appID = $("#appID").val();
	var appsecret = $("#appsecret").val();
	var tempid = $("#tempid").val();

	if (phone == '请输入与您微信绑定的手机号码')
		phone = '';
	if (marks == '请输入您的网校名称')
		marks = '';

	//validate
	if (phone == ''){
		alert('请输入与您微信绑定的手机号码');
		$("#phone").focus();
		return false;
	}
	if (marks == ''){
		alert('请输入您的网校名称');
		$("#marks").focus();
		return false;
	}
	if (appID == ''){
		alert('请输入AppID');
		$("#appID").focus();
		return false;
	}
	if (appsecret == ''){
		alert('请输入AppSecret');
		$("#appsecret").focus();
		return false;
	}
	if (tempid == ''){
		alert('请输入模板ID');
		$("#tempid").focus();
		return false;
	}

	$.ajax({
		type: 'POST',
		url: '/aroomv2/ethsetting/savesetting.html',
		data: {phone:phone,marks:marks,appID:appID,appsecret:appsecret,tempid:tempid},
		dataType: 'json',
		success: function(data){
			if(data != undefined && data != null & data.code != null){
				if (data.code == 1) {
					H.get('dialogtip').exec('setContent',$('#tipsuccess')[0]).exec('show');
				} else {
					H.get('dialogtip').exec('setContent',$('#tiperror')[0]).exec('show');
				}
			}
		}
	});
});

//修改配置
$("#editsetting").click(function(){
	$("#phone_span").hide();
	$("#marks_span").hide();
	$("#appID_span").hide();
	$("#appsecret_span").hide();
	$("#tempid_span").hide();
	$("#editsetting").hide();

	$("#phone").show();
	$("#marks").show();
	$("#appID").show();
	$("#appsecret").show();
	$("#tempid").show();
	$("#savesetting").show();
});

//创建菜单
$("#makemenu").click(function(){
	$.ajax({
		type: 'POST',
		url: '/aroomv2/ethsetting/makemenu.html',
		dataType: 'json',
		success: function(data){
			if(data != undefined && data != null & data.code != null){
				if (data.code == 1) {
					H.get('dialogtip').exec('setContent',$('#menusuccess')[0]).exec('show');
				} else {
					H.get('dialogtip').exec('setContent',$('#menuerror')[0]).exec('show');
				}
			}
		}
	});
});
</script>

<?php $this->display('aroomv2/page_footer');?>