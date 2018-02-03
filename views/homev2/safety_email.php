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
  <!-- 邮箱绑定 start -->
<div class="ryedbd send_befer_div">
<h2 class="etjudt">验证邮箱，以便找回支付密码，我们将对您的信息保密。</h2>
		<span class="krjstt">邮箱：</span>
		<input class="textste" name="email" type="text" id="email" value="" autocomplete="off"  />
		<span style="margin-left:10px;padding-top:5px;display:none" class="load_img">
		<img style="height:20px;width:20px;vertical-align:-10px" src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif" />
		</span>
		<p class="kjasht emailspn">您的邮箱会收到验证，请点击链接完成邮箱验证。</p>
		<span class="errormsg  kjasht email_error" style="display:none">请输入正确格式的邮箱地址!!!</span>
		<div class="etygdr" style="margin:0;">
			<a href="javascript:;" class="ryetgu dosent">发送邮件</a>
		</div>
</div>

<div class="send_back_div" style="display:none">
	<div class="ryedbd">
		<h2 class="etjudt">验证邮箱，以便找回支付密码，我们将对您的信息保密。</h2>
		<p class="efhrtu">我们已将验证邮件发送至：<a href="javascript:;" class="etkjre curemail" ></a></p>
		<p class="efhrtu">点击邮件内的链接即可完成绑定，并可使用网校内的所有功能</p>
		<div class="etygdr">
			<a href="javascript:;" class="klsktet loginbtn" data-url="">登录邮箱验证</a>
		</div> 
	</div>
	<div class="stbrys">
		<h3 class="rjyer">没有收到验证邮件，怎么办？</h3>
		<p class="khghdf">1、邮箱地址填写错误？  <a href="javascript:goBack()" class="etkjre resetemail">重新填写邮箱地址</a></p>
		<p class="khghdf">2、看看是否在邮箱的垃圾邮件、广告邮件目录内</p>
		<p class="khghdf">3、稍等几分钟，若还未收到验证邮件， <a href="javascript:goBack()" class="etkjre resetemail">重新发送验证邮件</a></p>
	</div>
</div>
  <!-- 邮箱绑定 end -->
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
	$(".dosent").bind("click",function(){
		//邮箱验证
		var email = $.trim($("#email").val());
        var emailreg = new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
		if(emailreg.test(email)){
			//发送邮件
			$(".email_error").hide();
			$(".emailspn").show();
			$(".load_img").show();
			$("#email").prop('disabled',true);
			
			$.ajax({
				async: false,
				url:'/homev2/safety/sendmsg.html',
				type:'post',
				dataType:'json',
				data:{'email':email},
				success:function(json){
					response = json ; 
					if(!response.status){
						//发送成功
						dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>已成功向您的邮箱发送一封邮件,请登录后验证!</p>",	
						onshow:function () {
							var that=this;
							setTimeout(function () {
								that.close().remove();
								//显示在网页email
								$(".curemail").html(email);
								$(".loginbtn").data("url","http://"+gotoEmail(email));
								
								$(".send_befer_div").hide();
								$(".send_back_div").fadeIn();
							},1000);
						}
						}).show();


					}else{
						/*//发送失败	
						$.showmessage({
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

						$(".load_img").hide();
						$("#email").prop('disabled',false);
						
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

		}else{
			//验证错误
			$(".email_error").show();
			$(".emailspn").hide();
			}
        
	});

	//重新绑定
	$(".resetemail").bind("click",function (){
		location.href="/homev2/safety/bind.html?type=email&op=bind";
		});
	//登录邮箱
	$(".curemail,.loginbtn").bind("click",function(){
			var login_email_url = $(".loginbtn").data('url');
			//location.href = login_email_url;
			//模拟新窗口打开
			var el = document.createElement("a");
			document.body.appendChild(el);
			el.href = login_email_url; //url 是你得到的连接
			el.target = '_blank'; //指定在新窗口打开
			el.click();
			document.body.removeChild(el);
		});
	//功能：根据用户输入的Email跳转到相应的电子邮箱首页
    function gotoEmail($mail) {
        $t = $mail.split('@')[1];
        $t = $t.toLowerCase();
        if ($t == '163.com') {
            return 'mail.163.com';
        } else if ($t == 'vip.163.com') {
            return 'vip.163.com';
        } else if ($t == '126.com') {
            return 'mail.126.com';
        } else if ($t == 'qq.com' || $t == 'vip.qq.com' || $t == 'foxmail.com') {
            return 'mail.qq.com';
        } else if ($t == 'gmail.com') {
            return 'mail.google.com';
        } else if ($t == 'sohu.com') {
            return 'mail.sohu.com';
        } else if ($t == 'tom.com') {
            return 'mail.tom.com';
        } else if ($t == 'vip.sina.com') {
            return 'vip.sina.com';
        } else if ($t == 'sina.com.cn' || $t == 'sina.com') {
            return 'mail.sina.com.cn';
        } else if ($t == 'tom.com') {
            return 'mail.tom.com';
        } else if ($t == 'yahoo.com.cn' || $t == 'yahoo.cn') {
            return 'mail.cn.yahoo.com';
        } else if ($t == 'tom.com') {
            return 'mail.tom.com';
        } else if ($t == 'yeah.net') {
            return 'www.yeah.net';
        } else if ($t == '21cn.com') {
            return 'mail.21cn.com';
        } else if ($t == 'hotmail.com') {
            return 'www.hotmail.com';
        } else if ($t == 'sogou.com') {
            return 'mail.sogou.com';
        } else if ($t == '188.com') {
            return 'www.188.com';
        } else if ($t == '139.com') {
            return 'mail.10086.cn';
        } else if ($t == '189.cn') {
            return 'webmail15.189.cn/webmail';
        } else if ($t == 'wo.com.cn') {
            return 'mail.wo.com.cn/smsmail';
        } else if ($t == '139.com') {
            return 'mail.10086.cn';
        } else {
            return '';
        }
    };
});
	function goback(){
		location.href = '/homev2/safety/bind.html?type=email&op=bind';
	};
</script>
<?php $this->display('homev2/footer');?>