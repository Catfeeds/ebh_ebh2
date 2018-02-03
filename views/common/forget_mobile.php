<?php $this->display('common/forget_header')?>
<style>
	.txtktb{
		color:#000;
	}
	.hit{
		color:#999;
	}
a.hui{
	background: #e9e9e9;
	color:#666;
}
.huibg{
	background: #eee;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js"></script>
<form id="forgetform" method="post" action=""  autocomplete="off">
<div class="awmbg">
  <div class="main lidtgd">

<div class="retpassword">
	<div class="title">找回密码</div>
	<div class="repawlist">
		<ul>
			<li class="emails"><a  href="/forget.html">通过邮箱找回密码</a></li>
			<li class="phone"><a class="cur" href="/forget/mobile.html">通过手机找回密码</a></li>
		</ul>
	</div>
</div>

<div class="yznr">
		<div class="sjzhts" id="showinfo" style="display:none"></div>

        <div class="lidet">
            <span class="gkswey">请输入您的手机号码：</span>
            <input type="text" x_hit="请输入您的手机号" x_func="checkmobile" value="" class="txtktb" id="mobile" name="mobile">
            <p  id="mobile_msg"></p>
        </div>
        <div class="clear"></div>
        <div class="lidet">
            <span class="gkswey">验证码：</span>
            <input type="text" x_hit="请输入验证码" x_func="checkverify" value="" class="yantes txtktb" id="verify" name="verify">
            <a class="sendyzm" href="javascript:;" id="getcode" onclick="getcode()">点击发送</a>
            <p id="verify_msg"></p>
        </div>
        <div class="clear"></div>
        <div style="margin-left:140px;">
            <a class="ieurgrs" href="javascript:;" onclick="dofind()">找回密码</a>
        </div>
    </div>
	<div class="clear"></div>
  </div>
  <div style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/fotbottg.jpg) no-repeat;margin:0 auto;width:820px;height:16px; position: relative; top: -1px;"></div>
  </div>
 </form>

<script>

var timer = null;//计时器
var flag = false;//手机号验证通过标识
var iswait = false;//等待标识
var nums = 60;//计时器等待60s
var sendsms = false;//短信发送标识

var _xform = new xForm({
	domid:'forgetform',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});

//获取验证码
function getcode(){
	var mobile = $('#mobile').val();
	if(mobile!='' && /^1[0-9]{10}$/.test(mobile)){
		if(iswait){
			return false;
			}
		if(!flag){
			return false;
			}
		$("#getcode").addClass('hui');
		$("#mobile").prop("disabled",true);
		$("#mobile").addClass('huibg');
		timer = setInterval(function(){
				if(nums <= 0){
					iswait = false;
					$("#getcode").removeClass('hui');
					$("#getcode").html("重新发送");
					$("#mobile").prop("disabled",false);
					$("#mobile").removeClass('huibg');
					
					clearInterval(timer);
					nums = 60;
				}else{
					iswait = true;
					$("#getcode").html(nums+' s');
					nums-- ;
					}
			},800);

		sendsmscode();
	}else{
		$('#mobile').trigger('blur');
	};
}


//调用短信接口,发送短信
function sendsmscode(){
	var mobile = $.trim($("#mobile").val());
	$.ajax({
		async: false,
		url:'/forget/getsmscode.html',
		type:'post',
		dataType:'json',
		data:{'mobile':mobile,'check':true},
		success:function(json){
			response = json ; 
			if(!response.status){//发送成功
				sendsms = true;
				$('#showinfo').html(response.msg);
				$('#showinfo').show();
			}else{//发送失败
				setTimeout(function(){
					clearInterval(timer);
					iswait = false;
					sendsms = false;
					nums = 60;
					
					$('#showinfo').html(response.msg);
					$('#showinfo').show();
					},800);
				}
			},
		error:function(){
			alert('服务器返回错误!!!');
			}		

		});
	}

function checkmobile(obj){
	obj.res = -1;
	var mobile = _xform.getdata().mobile;
	if(mobile==''){
		flag = false;
		obj.msg = '请输入手机号！';
		return false;
	}else{
		var reg = /^1[0-9]{10}$/;
		if(!reg.test(mobile)){
			flag = false;
			obj.msg = '请输入有效的手机号';
			return false;
		}else{
			$.ajax({
				type:"POST",
				url:'<?=geturl('forget/checkmobile')?>',
			    data: { 'mobile': mobile },
			    dataType:'json',
			    async:false,
                success: function (json) {
                    if (!json.code) {
                    	flag = false;
                    	obj.msg = '该手机号尚未绑定,请更换一个,重新再试！';
						return false;
					}else{
						flag = true;
						obj.res = 0;						
					}
				}
			});
		}
	}
}

function checkverify(obj){
	obj.res = -1;
	var code = _xform.getdata().verify;
	if(code==''){
		obj.msg = '请输入验证码！';
		return false;
	}
	var regsms = /^\d{6}$/;
    if(!regsms.test(code)){
    	obj.msg = '请输入6位验证码！';
     }else{
    	 obj.res = 0;
     }
}

//找回密码
function dofind(){
	if(!_xform.check()){
		return;
	}
	if(!sendsms){
		$("#verify_msg").removeClass('zhengtic')
						.addClass("cuotic");
		$("#verify_msg").text("请先点击发送!");
		return;
	}
	var mobile = $('#mobile').val();
	var verify = $('#verify').val();
	
	$.ajax({
		url:"<?=geturl('forget/sms_check')?>",
		type:'post',
		data:{'mobile':mobile,'smscode':verify},
		dataType:'json',
		success:function(json){
			if(!json.status){
				//验证成功
				location.href="/forget/mobile_reset.html?codekey="+json.attr.codekey;
			}else{
				//验证失败
				$('#showinfo').text(json.msg);
				$('#showinfo').show();
			}
		}
	});
	
}
</script>
<?php $this->display('common/site_footer')?>
