<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
	<div class="conentlft">
	<div class="topbaad">
	<div class="user-main clearfix">
	<div class="lefrig" style="background:#fff;margin-top:10px;width:1000px;">
	<?php $this->display('homev2/small_menu');?>
	<div class="eertrew" id="myform" style="height:510px">
	<div class="khrtye">
		<h2 class="redtjet">忘记支付密码</h2>
		<p>定期更换密码可以让你的账户更加安全。</p>
		<p>请确保登录密码与支付密码不同！</p>
		<p>建议密码采用字母和数字混合，并且不短于6位。</p>
	</div>
	<div class="ksert">
		<span>手机号码：</span>
		<input type="text" id="mobile" name="mobile" value="<?php
		$jsonBind = json_decode($bind['mobile_str'],true);
		echo $jsonBind['mobile'];
		?>" autocomplete ="off" style="width:150px;" class="hterys xinput inpfocus" readonly   />
		<a href="javascript:;" class="huswoat getcode" onclick="getcode()">点击发送</a>
		<span  class="errormsg mobile_error " style="margin-left:0px;width:620px;display: none"></span>
	</div>
	<div class="ksert">
		<span class="krjstt">验证码：</span>
		<input type="text" id="verify"  name="verify"  x_func="chkverify" value="" style="width:88px;" class="textste xinput" >
	</div>
	
	<div id="setdiv" style="display:none">
	<div class="ksert">
		<span>新支付密码：</span>
		<input type="password" name="paypwd" id="paypwd" onkeyup="pwStrength(this.value)" x_hit="请输入6-16位新密码" x_func="chkpwd" value="" class="hterys xinput" >
	</div>
	<div class="danties">
		<span class="redxs">安全级别：</span><div class="entern_i"><span style="width:0%;" id="level"></span></div><span id="leveltip">弱</span>
		<input type="hidden" name="level" id="levelid" value="0" />
	</div>
	<div class="ksert">
		<span>确认新支付密码：</span>
		<input type="password" name="rpaypwd" id="rpaypwd" onkeyup="pwStrength(this.value)" x_hit="再次输入新密码" x_func="chkpwd2" value="" class="hterys xinput" >
	</div>
	<div class="ksert">
		<a class="askter"  href="javascript:;" onclick="docheck()">确认</a>
	</div>
	</div>
	</div>
</div>
</div>
</div>
</div>
    <!--<div class="cotentrgt">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
    </div>-->
</div>
<style>
span.errormsg{
	background:url(http://static.ebanhui.com/portal/images/ebh_cohtk.jpg) no-repeat center left;
	padding-left:20px;
	float:left;
	color:#f66175;
	height:30px;
	line-height:30px;
	margin-left:250px;
	text-align:left;
	width:350px;
}
span.rightmsg{
	background:url(http://static.ebanhui.com/portal/images/ebh_queht.jpg) no-repeat center left;
	padding-left:20px;
	float:left;
	color:#f66175;
	height:30px;
	line-height:30px;
}
a.hui{
	background: #e9e9e9;
	color:#666;
}
</style>
<script type="text/javascript">
	var _xform = new xForm({
		domid:'myform',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});


	var timer = null;//计时器
	var flag = false;//手机号验证通过标识
	var iswait = false;//等待标识
	var nums = 60;//计时器等待60s
	var sendsms = false;//短信发送标识
	var isverify = false;//验证码验证标识
	
	//获取验证码
	function getcode(){
		if(iswait){
			return false;
			}
		if(isverify){
			return false;
			}
		$(".getcode").addClass('hui');
		$("#mobile").prop("disabled",true);
		timer = setInterval(function(){
				if(nums <= 0){
					iswait = false;
					$(".getcode").removeClass('hui');
					$(".getcode").html("重新发送");
					$("#mobile").prop("disabled",false);
					clearInterval(timer);
					nums = 60;
				}else{
					iswait = true;
					$(".getcode").html(nums+' s');
					nums-- ;
					}
			},800);

		sendsmscode();
		
		}

	//调用短信接口,发送短信
	function sendsmscode(){
		var mobile = $.trim($("#mobile").val());
		$.ajax({
			async: false,
			url:'/homev2/safety/getsmscode.html',
			type:'post',
			dataType:'json',
			data:{'mobile':mobile,'check':false},
			success:function(json){
				response = json ; 
				if(!response.status){//发送成功
					sendsms = true;
					$(".mobile_error").html(response.msg);
					$(".mobile_error").addClass('rightmsg');
					$(".mobile_error").show();
				}else{//发送失败
					setTimeout(function(){
						clearInterval(timer);
						iswait = false;
						sendsms = false;
						nums = 60;
						
						$(".mobile_error").html(response.msg);
						$(".mobile_error").removeClass('rightmsg');
						$(".mobile_error").show();
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
				},
			error:function(){
				alert('服务器返回错误!!!');
				}		

			});
		return response;
	}
	//验证手机号
	function chkmobile(){
		var mobile = $.trim($("#mobile").val());
		var reg = /^1[0-9]{10}$/;
		if((mobile!='')&&(reg.test(mobile)==true)){
			flag = true;
			$(".mobile_error").hide();
		}else{
			flag = false;
			$(".mobile_error").show();
			$(".mobile_error").removeClass('rightmsg');
			$(".mobile_error").html('请输入正确的手机号！');
			$("#mobile").focus();
		}
	}

	//验证码检验
	function chkverify(obj){
		obj.res = -1;
		var verify = $.trim($("#verify").val());
		var mobile = $.trim($("#mobile").val());
		if(verify == ''){
			obj.msg = '请输入验证码！';
		}else{
			//6位数字
			var regsms = /^\d{6}$/;
            if(regsms.test(verify)){
                if(!isverify){
                    //验证码后台验证
                	var response = todocheck(mobile,verify);
                	try{
                		if(response.status==0){//验证成功
                			obj.res = 0;
                			isverify = true;
                			$("#setdiv").show();
                    		}else{//验证失败
                    			isverify = false;
                    			obj.msg = response.msg;
                    			$("#setdiv").hide();
                        		}
                    }catch(e){
                        alert('服务器验证错误');
                        return false;
                        }
                   }else{
                	   obj.res = 0;
                       }
             }else{
            	 obj.msg = '请输入6位验证码！';
                }
		}

		return 	obj;
	}
	
	function chkpwd(obj){
		var password = _xform.getdata().paypwd;
		var oldpaypwd = _xform.getdata().rpaypwd;
		obj.res = -1;
		if (password == '') {
			obj.msg = '请输入支付密码！';
		} else if (password.length < 6 || password.length > 16 ) {
			obj.msg = '密码位数不正确。';
		}else {
			//验证是否与登录密码相同
			$.ajax({
				async: false,
				url:'/homev2/safety/paypass.html',
				data:{op:'checkuserpwd',password:password},
				dataType:'json',
				type:'GET',
				success:function(json){
					if(json.code){
						obj.msg = '支付密码不能与用户密码相同。';
					}else{
						obj.res = 0;
						}

					}
				});
		}
	}

	function chkpwd2(obj){
		var password = _xform.getdata().paypwd;
		var password2 = _xform.getdata().rpaypwd;
		obj.res = -1;
		if (password == '') {
			obj.msg = '请输入支付密码！';
		} else if (password2.length < 6) {
			obj.msg = '密码位数不正确。';
		} else {
			obj.res = 0;
		}
		if(obj.res == -1){
			return;
		}
		if(password == password2){
			obj.res = 0;
		}else{
			obj.res = -1;
			obj.msg = "两次密码不一致";
		}
	}

	function docheck(){
		var ret = _xform.check();
		if(!ret && (isverify == false)){
			return false;
		}
		var password = _xform.getdata().paypwd;
		var level = $('#levelid').val();
		//设置支付密码
		$.ajax({
			url:'/homev2/safety/paypass.html',
			data:{op:'save',password:password,level:level},
			dataType:'json',
			type:'GET',
			success:function(json){
				if(json.code){
					/*dialog({
			        skin:"ui-dialog2-tip",
			        width:350,
			        content: "<div class='TPic'></div><p>恭喜您,支付密码设置成功</p>",
					onshow:function () {
						var that=this;
						setTimeout(function() {
							that.close().remove();
							location.href="/homev2/safety/paypass.html";
						}, 1000);
					}
					}).show();*/
					location.href="/homev2/safety/paypass.html";
				}else{
					var msg = json.msg? json.msg: '支付密码设置失败,请刷新后重试';
					dialog({
			        skin:"ui-dialog2-tip",
			        width:350,
			        content: "<div class='FPic'></div><p>"+msg+"</p>",
					onshow:function () {
						var that=this;
						setTimeout(function() {
							that.close().remove();
						}, 1000);
					}
					}).show();
					}

				}
			});
	}

	$(function(){
		$(".xinput").bind("focus",function(){
			$(this).addClass("inpfocus");
		}).bind("blur",function(){
			var inpid = $(this).attr("id");
			if(/_clone/.test(inpid)==false){
				$("#"+inpid+'_clone').removeClass("inpfocus");
				}
			//$(this).removeClass("inpfocus");
		});

		//绑定验证码keyup事件
		$("#verify").bind("keyup",function(){
			if($("#verify").val().length==6){
				$("#verify").trigger("blur");
				}
			})
	});

	// ========密码强弱检测=======
	function CharMode(ch){
	   if (ch>=48 && ch <=57) //数字   
	    return 1;   
	   if (ch>=65 && ch <=90) //大写字母   
	    return 2;   
	   if (ch>=97 && ch <=122) //小写   
	    return 4;   
	   else   
	    return 8; //特殊字符 
	}
	function bitTotal(num){
	   var modes=0;   
	   for (i=0;i<4;i++){ 
	    if (num & 1) modes++;   
	    num>>>=1;   
	   }   
	   return modes;
	}
	function checkStrong(pwd){ //返回密码的强度级别 
	   if(pwd.length < 6)
	    return 0;
	   var Modes=0;   
	   for (i=0;i<pwd.length;i++){   
	    //测试每一个字符的类别并统计一共有多少种模式. 
	    Modes |= CharMode(pwd.charCodeAt(i)); 
	   }   
	   return bitTotal(Modes); 
	}

	function pwStrength(pwd){
		var level = 0;
		var color = '';
		var leveltip = '弱';
		var type = checkStrong(pwd);
		switch(type){
			case 0:level=25;leveltip='弱';color='#f0e54b';break;
			case 1:level=50;leveltip='一般';color='#1e91ce';break;
			case 2:level=75;leveltip='很好';color='#0000FF';break;
			case 3:level=100;leveltip='极好';color='#ff0000';break;
		}
		$("#level").show();
		$("#level").css({width:level+'%',background:color}); 
		$("#leveltip").html(leveltip);
		$("#levelid").val(type);
	}
	// ============

</script>
<?php $this->display('homev2/footer');?>