<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<div class="divcontent">
	<div class="conentlft">
	<div class="topbaad">
	<div class="user-main clearfix">
	<div class="lefrig" style="background:#fff;margin-top:10px;width:1000px;">
	<?php $this->display('homev2/small_menu');?>
	<div class="clear"></div>
	<div class="eertrew" id="myform">
	<div class="khrtye">
		<h2 class="redtjet">设置支付密码</h2>
		<p>定期更换密码可以让你的账户更加安全。</p>
		<p>请确保登录密码与支付密码不同！</p>
		<p>建议密码采用字母和数字混合，并且不短于6位。</p>
	</div>
	<div class="ksert">
		<span>设置支付密码：</span>
		<input type="password" name="paypassword" id="paypassword"  onKeyUp="pwStrength(this.value)" class="hterys xinput" value=""   x_hit="请输入6-16位密码" x_func="chkpwd"/>
	</div>
	<div class="danties">
	<span class="redxs">安全级别：</span><div class="entern_i"><span style="width:0%;" id="level"></span></div><span id="leveltip">弱</span>
	<input type="hidden" name="level" id="levelid" value="0" />
	</div>

	<div class="ksert">
		<span>确认支付密码：</span>
		<input type="password"  name="rpaypassword" id="rpaypassword"  onKeyUp="pwStrength(this.value)"  class="hterys xinput"  value="" x_hit="再次输入密码" x_func="chkpwd2" />
	</div>
	<div class="ksert">
		<a class="askter" href="javascript:;" onclick="docheck()">确认</a>
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
<script type="text/javascript">
	var _xform = new xForm({
		domid:'myform',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});

	function chkpwd(obj){
		var password = _xform.getdata().paypassword;
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
		var password = _xform.getdata().paypassword;
		var password2 = _xform.getdata().rpaypassword;
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
		if(!ret){
			return false;
		}
		var password = _xform.getdata().paypassword;
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
			        content: "<div class='TPic'></div><p>恭喜您,支付密码设置成功!</p>",
					onshow:function () {
						var that=this;
						setTimeout(function() {
							that.close().remove();
							location.href="/homev2/safety/paypass.html";
						}, 1000);
					}
					}).showModal();*/
					location.href="/homev2/safety/paypass.html";
				}else{
					dialog({
			        skin:"ui-dialog2-tip",
			        width:350,
			        content: "<div class='FPic'></div><p>支付密码设置失败,请刷新后重试</p>",
					onshow:function () {
						var that=this;
						setTimeout(function() {
							that.close().remove();
						}, 1000);
					}
					}).showModal();
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
			$(this).removeClass("inpfocus");
		});
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