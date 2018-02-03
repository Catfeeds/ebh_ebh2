<?php $this->display('aroomv2/page_header'); ?>
<style>
.ui-dialog{border:none; background-color: transparent;}
</style>

<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/systemsetting')?>">系统设置</a> > 账号登录限制
    </div>
    <div class="xitongshezhis mt15">
    	<div class="titles">
            <a href="<?=geturl('aroomv2/systemsetting/login')?>" class="aalls curs">登录限制设置</a>
            <a href="<?=geturl('aroomv2/systemsetting/client')?>" class="aalls">限制情况查看</a>
    	</div>
        <div class="xtsznr">
        	<p class="p1s">-开启账号登录限制后，则一个账号登录的设备数量最多不能超过所限制的数量。</p>
            <p class="p1s">-登录限制可按照自身需求进行设置，方便网校进行各种营销活动。</p>
            <div class="sfxianz">
                <span class="span1s">是否限制：
                <label style="font-size: 13px;"><input type="radio" checked="checked" value="0" name="loginlimit"<?php if(empty($systemsetting['limitnum'])){ echo ' checked="checked"';}?> /> 不限制</label><label style="font-size: 13px;margin-left:10px"><input type="radio" value="1" name="loginlimit"<?php if(!empty($systemsetting['limitnum'])){ echo ' checked="checked"';}?> /> 限制</label>
                </span>
                <div id="loginlimitmore"<?php if(empty($systemsetting['limitnum'])){ echo ' style="display:none;"';}?>>
                	<span class="span1s xzsl">限制数量：</span>
                	<div class="xzsls"><input id="limitnum" class="inputs" value="<?=empty($systemsetting['limitnum'])?'推荐数量为3':$systemsetting['limitnum']?>" onfocus="if($(this).val()=='推荐数量为3')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('推荐数量为3');$(this).css('color','#18a8f7')}" /></div>
                </div>
            </div>
            <div class="clear"></div>
            <div style="display:inline-block;">
                <a href="javascript:;" class="savebtn">保&nbsp;存</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
	$("input[name='loginlimit']").click(function(){
		if ($(this).val() == 0){
			$("#loginlimitmore").hide();
		} else {
			$("#loginlimitmore").show();
		}
	});
});

$(".savebtn").click(function(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:0
		}),'common');
	}

	var loginlimit = $("input[name='loginlimit']:checked").val();
	var limitnum = $("#limitnum").val();
	if (loginlimit == 0){
		limitnum = 0;
	}
	else if (limitnum == '推荐数量为3'){
		alert('请填写限制数量');
		$("#limitnum").focus();
		return false;
	}


	$.ajax({
		type: 'POST',
		url: '/aroomv2/systemsetting/savelogin.html',
		data: {limitnum:limitnum},
		dataType: 'json',
		success: function(data){
			if(data != undefined && data != null & data.status == 1){
				H.get('xtips').exec('setContent','<div class="bccg2">'+data.msg+'</div>').exec('show').exec('close',500);
			}else{
				H.get('xtips').exec('setContent','<div class="bccg2">'+data.msg+'</div>').exec('show').exec('close',500);
			}
		}
	});

});
</script>
<?php $this->display('aroomv2/page_footer'); ?>