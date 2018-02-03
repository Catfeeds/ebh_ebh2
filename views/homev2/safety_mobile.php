<?php
$ht = $this->input->get('ht');
if ($ht == 1) {
	$this->display('homev2/header1');
} else {
	$this->display('homev2/header');
}
?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
	<div class="conentlft">
	<div class="topbaad">
	<div class="user-main clearfix">
	<div class="lefrig" style="background:#fff;margin-top:10px;width:1000px;">
	<?php $this->display('homev2/small_menu');?>
  <div class="clear"></div>
  <!-- 手机绑定 start -->
  <div class="ryedbd">
	<h2 class="etjudt">请设置新手机号，并验证</h2>
			<span class="krjstt">新手机号：</span>
			<input class="textste" name="mobile" id="mobile" type="text"  value="" autocomplete="off"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />
			<a href="javascript:;" class="huswoat getcode">获取验证码</a>
			<a href="javascript:;" class="stkurw seconds_a" style="display:none"><em class="seconds">60</em>s</a>
			<!-- <a href="javascript:;" class="asthzt">重新获取</a> -->
			<span class="kjasht respan">更改手机后，原号码将无法使用。</span>
			<span class="errormsg kjasht mobile_error" style="display:none">请先输入正确的手机号!!!</span>
			<div style="clear:both;"></div>
			<span class="krjstt">验证码：</span>
			<input class="textste" name="verify" type="text" id="verify" value="" />
			<span class="errormsg verify_error" style="margin-left:10px;display:none">请输入6位数字验证码!!!</span>
			<div class="etygdr">
				<a href="javascript:;" class="ryetgu bindbtn">绑定</a>
			</div>
  </div>
  <!-- 手机绑定 end -->
</div>
</div>
</div>
</div>
    <!--<div class="cotentrgt">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
    </div>-->
</div>
<style>
.errormsg{
	background:url(http://static.ebanhui.com/portal/images/ebh_cohtk.jpg) no-repeat center left;
	padding-left:20px;
	float:left;
	color:#f66175;
	height:30px;
	line-height:30px;
}
.rightmsg{
	background:url(http://static.ebanhui.com/portal/images/ebh_queht.jpg) no-repeat center left;
	padding-left:20px;
	float:left;
	color:#f66175;
	height:36px;
	line-height:36px;
}
a.hui{
	background: #e9e9e9;
	color:#666;
}
</style>
<script type="text/javascript">
$(function(){
	var timer = null;//计时器
	var flag = false;//手机号验证通过标识
	var iswait = false;//等待标识
	var nums = 60;//计时器等待60s
	var sendsms = false;//短信发送标识
	
	//获取验证码--事件绑定
	$(".getcode").bind("click",function(){
		checkmobile();
		if(iswait){
			return false;
			}
		if(flag){
			sendsmscode();
			
			$("#mobile").prop('disabled',true);
			$(this).addClass("hui");
			//$(".seconds_a").fadeIn(300);
			//定时器
			timer = setInterval(function(){
				iswait = true;
				console.log(nums);
				//$(".seconds").html(nums);
				$(".getcode").html(nums);
				nums--;
				if(nums == 0){
					nums = 60;
					iswait = false;
					clearInterval(timer);
					//$(".seconds_a").fadeOut();
					$(".getcode").removeClass("hui");
					$(".getcode").html("重新获取");
					$("#mobile").prop('disabled',false);
				}
				
			},800);

			
			}else{
			$(this).removeClass("hui");
			}
		});
	//绑定处理
	$(".bindbtn").bind("click",function(){
		var ck1 = checkmobile();
		var ck2 = checkverify();
		if(ck1&&ck2){
			var mobile = $.trim($("#mobile").val()); 
			var verify = $.trim($("#verify").val());
			todocheck(mobile,verify);
			}
		});


	
	//验证手机号
	function checkmobile(){
		var mobile = $.trim($("#mobile").val());
		var reg = /^1[0-9]{10}$/;
		if((mobile!='')&&(reg.test(mobile)==true)){
			flag =  true;
			$(".respan").show();
			$(".mobile_error").hide();
		}else{
			$(".respan").hide();
			$(".mobile_error").show();
			$("#mobile").focus();
			flag =  false;
		}
		return flag;
	}

	//验证码检验
	function checkverify(){
		var ckverify = false;
		var verify = $.trim($("#verify").val());
		if(verify == ''){
			ckverify = false;
			$(".verify_error").show();
		}else{
			//6位数字
			var regsms = /^\d{6}$/;
            if(regsms.test(verify)){
    			ckverify = true;
    			$(".verify_error").hide();
             }else{
      			ckverify = false;
    			$(".verify_error").show();
                }
		}

		return 	ckverify;
	}

	//调用短信接口,发送短信
	function sendsmscode(){
		var mobile = $.trim($("#mobile").val());
		$.ajax({
			async: false,
			url:'/homev2/safety/getsmscode.html',
			type:'post',
			dataType:'json',
			data:{'mobile':mobile,'check':true},
			success:function(json){
				response = json ; 
				if(!response.status){
					sendsms = true;
					$(".mobile_error").addClass('rightmsg');
					$(".mobile_error").removeClass('errormsg');
					$(".mobile_error").html(response.msg);
					$(".mobile_error").show();
					$(".respan").hide();
					}else{
						//console.log(timer);
						setTimeout(function(){
							clearInterval(timer);
							iswait = false;
							$("#mobile").prop("disabled",false);
							$(".seconds_a").fadeOut();
							$(".getcode").removeClass("hui");

							sendsms = false;
							nums = 60;
							$(".mobile_error").addClass('errormsg');
							$(".mobile_error").removeClass('rightmsg');
							$(".mobile_error").html(response.msg);
							$(".mobile_error").show();
							$(".respan").hide();
							
							},800);
						
						
						}
				},
			error:function(){
				alert('服务器返回错误!!!');
				}		

			});
		}
	//后台验证
	function todocheck(mobile,verify){
		var response = null;
		$.ajax({
			async: false,
			url:'/homev2/safety/sms_check.html',
			type:'post',
			dataType:'json',
			data:{'mobile':mobile,'smscode':verify},
			success:function(json){
				response = json ; 
				if(!response.status){
						//验证成功
						dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>恭喜您,手机绑定成功!</p>",
						onshow:function () {
							var that=this;
							setTimeout(function () {
								that.close().remove();
								<?php if($ht==1){?>
								location.href="/homev2/safety/index.html?ht=1";
								<?php }else{?>
								location.href="/homev2/safety/index.html";
								<?php }?>
							},1000);
						}
						}).show();
					}else{
						/*$.showmessage({
							img		 :'error',
							message  :response.msg,
							title    :'消息通知'
						});*/

						dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+response.msg+"</p>",
						onshow:function () {
							var that=this;
							setTimeout(function () {
								that.close().remove();
							},2000);
						}
						}).show();
					}
				},
			error:function(){
				// alert('服务器返回错误!!!');

						dialog({
						title:"消息通知",
						content:"服务器返回错误!!!",
						cancel:false,
						okValue:"确定",
						ok:function () {
							this.close().remove();
						}
						}).show();
				}		

			});

		
		return response;
	}
	
})
</script>
<?php $this->display('homev2/footer');?>