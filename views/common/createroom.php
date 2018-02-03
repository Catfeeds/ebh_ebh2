<?php $this->display('common/header')?>
<style>
	.hit{
		color: #999;
	}
	#fixsendHtml{
		font-size: 18px;
		font-weight: bold;
		color: #444;
	}
	#fixsendHtml p,#fixsendHtml p span{
		float: left;
	}
	#fixsendHtml p{
		height:36px;
		line-height: 36px;
	}
	#kanjia{
		position:fixed;
		left:0;
		top:38%; 
		margin-top:-90px;
		z-index:1;
		font-size:16px;
		color:#333;
	}
	
	.foot {
	    line-height: 26px;
	    padding-bottom: 30px;
	    padding-top: 18px;
	    text-align: center;
	    width: 100%;
	}
	
	.netschooltype,.netschooltype_3{
		width: 115px;
		height: 30px;
		line-height: 30px;
		text-align: center;	
		float: left;
		color: #333333;
		margin-right: 35px;
		background: #f2f2f2;
		cursor: pointer;
		font-family: "微软雅黑";
	}
	.netschooltype_bg{
		background: #199ed8;
		color: #FFFFFF;
	}
	.smscode_msg2:focus{
		outline: none;
	}
</style>
<!--内容!-->
<div class="rushen">
<div class="rhrots">

<!--网校注册表单-->
<form id="createform"  method="post">
	
	<div class="kfhhty">
		<label class="netschooltype netschooltype_bg" onclick="differfun($(this),0)" style="margin-left: 20px;">网校版
			<input style="display: none;" type="radio" name="property" id="property" value="0" checked="checked"/>
		</label>
		<div class="netschooltype" onclick="differfun($(this),0)">企业版</div>
	</div>
	
	<div class="kfhhty">
		<span class="lweastp">网校名称</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="crname" type="text" id="crname" x_hit="例如：杭州市学军小学" x_func="check_crname" value="" />
		</div>
		<span id="crname_msg" zero="tips_0"></span>
	</div>

	<div class="kfhhty" style="height:50px;">
		<div class="dkxiatu">
			<span class="lweastp">网校域名</span>
			<div class="kdswaiy">
				<span class="kdtnfe">http://</span><input class="txtxtb" name="domain" type="text" id="domain" x_hit="例如：hzxjxx" x_func="check_domain" value="" /><span class="kdtnfe">.ebh.net</span>
			</div>
		</div>
		<span id="domain_msg" zero="tips_0"></span>
	</div>

	<div class="kfhhty">
		<span class="lweastp">姓名</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="realname" type="text" id="realname" x_hit="与身份证姓名一致" x_func="check_realname" value="" />
		</div>
		<span id="realname_msg" zero="tips_0"></span>
	</div>

	<div class="kfhhty">
		<span class="lweastp">手机号码</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="mobile" type="text" id="mobile" x_hit="手机号即为管理员账号" x_func="check_mobile" value="" />
		</div>
		<span id="mobile_msg" zero="tips_0"></span>
	</div>
	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=892357903&site=qq&menu=yes" style="float:left;margin-left: 617px;margin-top: -60px;">
	<img src="http://static.ebanhui.com/ebh/tpl/default/images/counselingQQ.jpg?v=20160405001">
	</a>
	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" style="float:left;margin-left: 755px;margin-top: -60px;">
	<img src="http://static.ebanhui.com/ebh/tpl/default/images/counselingQQ.jpg?v=20160405001">
	</a>

	<div class="kfhhty">
		<span class="lweastp">登录密码</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="password" type="text" id="password" x_hit="该密码为网校登录密码" x_func="check_password" value="" />
		</div>
		<span id="password_msg" zero="tips_0"></span>
	</div>

	<div class="kfhhty">
		<span class="lweastp">验证码</span>
			<div class="kdswaiy">
			  	<input class="yantes" name="smscode" x_hit="请输入验证码" type="text" id="smscode" x_func="checkcode" value="" />
			  	<a href="javascript:void(0)" id="sendmsg_0" onclick="getcode();" class="kwrybtn"></a>
				<a class="smscode_msg2" style="border: 0 none;color:#999;margin-left:138px;width:150px;height:30px;float:left;color:#f66175;display:none;" href="javascript:void(0)" onclick="fixsend()">收不到短信单击这里</a>
			</div>
		<span id="smscode_msg" zero="tips_0"></span>
	</div>
</form>

<!--企业注册表单-->
<form id="createform_3" style="display: none;"  method="post">
	
	<div class="kfhhty">
		<div class="netschooltype_3" onclick="differfun($(this),3)" style="margin-left: 20px;">网校版</div>
		<div class="netschooltype_3 netschooltype_bg" onclick="differfun($(this),3)">企业版
			<input style="display: none;" type="radio" name="property" id="property_3" value="3" checked="checked"/>
		</div>
	</div>
	
	<div class="kfhhty">
		<span class="lweastp">企业名称</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="crname" type="text" id="crname_3" x_hit="例如：山东一诺集团" x_func="check_crname" value="" />
		</div>
		<span id="crname_3_msg" three="tips_3"></span>
	</div>

	<div class="kfhhty" style="height:50px;">
		<div class="dkxiatu">
			<span class="lweastp">企业域名</span>
			<div class="kdswaiy">
				<span class="kdtnfe">http://</span><input class="txtxtb" name="domain" type="text" id="domain_3" x_hit="例如：sdynjt" x_func="check_domain" value="" /><span class="kdtnfe">.ebh.net</span>
			</div>
		</div>
		<span id="domain_3_msg" three="tips_3"></span>
	</div>

	<div class="kfhhty">
		<span class="lweastp">姓名</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="realname" type="text" id="realname_3" x_hit="与身份证姓名一致" x_func="check_realname" value="" />
		</div>
		<span id="realname_3_msg" three="tips_3"></span>
	</div>

	<div class="kfhhty">
		<span class="lweastp">手机号码</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="mobile" type="text" id="mobile_3" x_hit="手机号即为管理员账号" x_func="check_mobile" value="" />
		</div>
		<span id="mobile_3_msg" three="tips_3"></span>
	</div>
	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=892357903&site=qq&menu=yes" style="float:left;margin-left: 617px;margin-top: -60px;">
	<img src="http://static.ebanhui.com/ebh/tpl/default/images/counselingQQ.jpg?v=20160405001">
	</a>
	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" style="float:left;margin-left: 755px;margin-top: -60px;">
	<img src="http://static.ebanhui.com/ebh/tpl/default/images/counselingQQ.jpg?v=20160405001">
	</a>

	<div class="kfhhty">
		<span class="lweastp">登录密码</span>
		<div class="kdswaiy">
		  <input class="txtktb" name="password" type="text" id="password_3" x_hit="该密码为网校登录密码" x_func="check_password" value="" />
		</div>
		<span id="password_3_msg" three="tips_3"></span>
	</div>

	<div class="kfhhty">
		<span class="lweastp">验证码</span>
			<div class="kdswaiy">
			  	<input class="yantes" name="smscode" x_hit="请输入验证码" type="text" id="smscode_3" x_func="checkcode" value="" />
			  	<a href="javascript:void(0)" id="sendmsg_3" onclick="getcode();" class="kwrybtn"></a>
				<a class="smscode_msg2" hidefocus="true" style="border: 0 none;color:#999;margin-left:138px;width:150px;height:30px;float:left;color:#f66175;display:none;" href="javascript:void(0)" onclick="fixsend()">收不到短信单击这里</a>
			</div>
		<span id="smscode_3_msg" three="tips_3"></span>
	</div>
</form>





<div class="kfhhty">
<span class="lweastp"></span>
<div class="kdswaiy">
<input type="checkbox" class="ltsyx" name="checkbox" id="readpaper" />
我已阅读，并同意。<a target="_blank"  href="<?=geturl('intro/schagreement')?>" class="etktgds">创建网校服务协议</a>
</div>

</div>

<a id="docreate" href="javascript:void(0);" onclick="docreate()" class="scuhtn"></a>
</div>
</div>
<script>
	var property = 0;		//上传的判断网校还是企业的参数，0为网校，3为企业
	function differfun(domobj,type){	//网校还是企业判断函数
		$(".smscode_msg2").hide();
		if(type == 0){
			if(domobj.text() == "企业版"){
				$("#createform_3").show();
				$("#createform").hide();
				property = 3;
				var threelen = $("span[three='tips_3']");
				for(var i=0;i<threelen.length;i++){
					$(threelen[i]).html("");
					$(threelen[i]).removeClass("cuotic");
					$(threelen[i]).removeClass("zhengtic");
				}
			}else{
				property = 0;
				return false;
			}
		}else{
			if(domobj.text() == "网校版"){
				$("#createform").show();
				$("#createform_3").hide();
				property = 0;
				var zerolen = $("span[zero='tips_0']");
				for(var i=0;i<zerolen.length;i++){
					$(zerolen[i]).html("");
					$(zerolen[i]).removeClass("cuotic");
					$(zerolen[i]).removeClass("zhengtic");
				}
			}else{
				property = 3;
				return false;
			}
		}
	}
	
	function docreate(){
		if(!$("#readpaper").prop('checked')){
			alert("同意创建网校协议未勾选");
			return;
		}
		if(property == 0){
			var formname = _xform;
			var ret = _xform.check();
			var cong = "恭喜您，您已成为校长！您的网校名称为："
		}else{
			var formname = _xform_3;
			var ret = _xform_3.check();
			var cong = "恭喜您，您的企业已创建成功！企业名称为："
		}
		if(ret){
			$.ajax({
				url: "/createroom/create.html",
				type:"post",
				dataType:"json",
				data:formname.getdata(),
			 	success: function(res){
			 		if(res.status != -1){
			 			dosso(res.attr.durl,function(){
			 				HTools.hShow(getDialogHtml(res.attr,cong));
			 			});
			 		}else{
			 			HTools.hShow('创建失败，原因是：'+res.msg,0,3000);
			 		}
	    		}
			});
		}
	}

	function check_domain(obj){
		if(property == 0){
			var formname = _xform;
			var data = _xform.getdata();
		}else{
			var formname = _xform_3;
			var data = _xform_3.getdata();
		}
		if(!data.domain){
			obj.res = -1;
			obj.msg = '域名不能为空';
			return false;
		}
		if(!formname.xCheck(this,'isDomain')){
			obj.res = -1;
			obj.msg = '域名必须由5-12位字母组成';
			return false;
		}
		$.ajax(
			{
				url: "/createroom/domain_check.html",
				type:"post",
				dataType:"json",
				data:data,
				async:false,
			 	success: function(res){
			 		obj.res = res.status;
			 		obj.msg = res.msg;
	    		}
			}
		);
	}

	function check_mobile(obj){
		if(property == 0){
			var data = _xform.getdata();
			var ret = _xform.xCheck(this,'isTel');
		}else{
			var data = _xform_3.getdata();
			var ret = _xform_3.xCheck(this,'isTel');
		}
		if(!ret){
			obj.res = -1;
			obj.msg = '手机号码填写不正确';
			return false;
		}
		var ret = false;
		$.ajax(
			{
				url: "/createroom/is_user_exists.html",
				type:"post",
				dataType:"json",
				data:data,
				async:false,
			 	success: function(res){
			 		obj.res = res.status;
			 		obj.msg = res.msg;
			 		obj.callback = function(){
						$("#domain").blur();//这里可能有问题
			 		}
	    		}
			}
		);
	}

	function check_realname(obj){
		if(property == 0){
			var formname = _xform;
			var data = _xform.getdata();
		}else{
			var formname = _xform_3;
			var data = _xform_3.getdata();
		}
		var realname = data.realname;
		if(!realname){
			obj.res = -1;
			obj.msg = '姓名不能为空';
			return;
		}
		if(formname.xCheck(this,'isRealname')){
			obj.res = 0;
		}else{
			obj.res = -1;
			obj.msg = '姓名不符合规范';
		}
	}


	function check_crname(obj){
		if(property == 0){
			var data = _xform.getdata();
		}else{
			var data = _xform_3.getdata();
		}
		var crname = data.crname;
		if(!crname){
			obj.res = -1;
			obj.msg = '名称不能为空';
		}else{
			obj.res = 0;
			obj.msg = '名称正确';
		}
		if(obj.res != 0){
			return;
		}
		$.ajax(
			{
				url: "/createroom/is_crname_exists.html",
				type:"post",
				dataType:"json",
				data:data,
				async:false,
			 	success: function(res){
			 		obj.res = res.status;
			 		obj.msg = res.msg;
	    		}
			}
		);
	}

	function check_password(obj){
		if(property == 0){
			var data = _xform.getdata();
		}else{
			var data = _xform_3.getdata();
		}
		
		
		var password = data.password;
		if(password.length < 6 || password.length > 16){
			obj.res = -1;
			obj.msg = '密码位数为6-16个字符，区分大小写';
		}else{
			obj.res = 0;
			obj.msg = '密码格式正确';
		}
//		obj.callback = function(){
//			//这里需要判断
//			$("#domain").blur();
//			$("#mobile").blur();
//		}
	}

	function getcode(fix){
		//这里还需要修改
		if(property == 0){
			var check_ret = _xform.check({not:"#smscode"});
			if(!check_ret){
				_xform.errorhtml($("#smscode_msg"),"请先填写正确的信息，只有信息全部校验通过才能获取验证码");
				return false;
			}
			if(fix){
				var url = "/createroom/getcode.html?fix=1";
			}else{
				var url = "/createroom/getcode.html";
			}
			$.ajax({
				url: url,
				type:"post",
				dataType:"json",
				data:_xform.getdata(),
				async:false,
			 	success: function(res){
			 		if(res.status == 0){
			 			if(fix){
			 				fixsend_after(res);
			 			}else{
			 				countdown($("#sendmsg_0"));
			 				_xform.okhtml($("#smscode_msg"),"短信校验码获取成功,请勿修改当前填写信息，否则校验码失效");
			 			}
			 		}else{
			 			if(fix){
			 				fixsend_after(res);
			 			}else{
			 				countdown($("#sendmsg_0"));
			 				_xform.errorhtml($("#smscode_msg"),res.msg);
			 			}
			 		}
	    		}
			});
		}else{
			var check_ret = _xform_3.check({not:"#smscode_3"});
			if(!check_ret){
				_xform_3.errorhtml($("#smscode_3_msg"),"请先填写正确的信息，只有信息全部校验通过才能获取验证码");
				return false;
			}
			if(fix){
				var url = "/createroom/getcode.html?fix=1";
			}else{
				var url = "/createroom/getcode.html";
			}
			$.ajax({
				url: url,
				type:"post",
				dataType:"json",
				data:_xform_3.getdata(),
				async:false,
			 	success: function(res){
			 		if(res.status == 0){
			 			if(fix){
			 				fixsend_after(res);
			 			}else{
			 				countdown($("#sendmsg_3"));
			 				_xform.okhtml($("#smscode_3_msg"),"短信校验码获取成功,请勿修改当前填写信息，否则校验码失效");
			 			}
			 		}else{
			 			if(fix){
			 				fixsend_after(res);
			 			}else{
			 				countdown($("#sendmsg_3"));
			 				_xform.errorhtml($("#smscode_3_msg"),res.msg);
			 			}
			 		}
	    		}
			});
		}
	}

	function chkrealname(obj){
		if(property == 0){
			var formname = _xform;
			var data = _xform.getdata();
		}else{
			var formname = _xform_3;
			var data = _xform_3.getdata();
		}
		var realname = data.realname;
		if(!realname){
			obj.res = -1;
			obj.msg = '姓名不能为空';
			return;
		}
		if(formname.xCheck(this,'isRealname')){
			obj.res = 0;
		}else{
			obj.res = -1;
			obj.msg = '姓名不符合规范';
		}
	}

	function checkcode(obj){
		if(property == 0){
			var formname = _xform;
			var data = _xform.getdata();
		}else{
			var formname = _xform_3;
			var data = _xform_3.getdata();
		}
		var smscode = data.smscode;
		if(!smscode){
			obj.res = -1;
			obj.msg = '请填写手机验证码';
			return;
		}
		$.ajax(
			{
				url: "/createroom/sms_check.html",
				type:"post",
				dataType:"json",
				data:formname.getdata(),
				async:false,
			 	success: function(res){
			 		obj.res = res.status;
					obj.msg = res.msg;
	    		}
			}
		);
	}
	var _xform = new xForm({
		domid:'createform',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});
	
	var _xform_3 = new xForm({
		domid:'createform_3',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});
	

	function countdown(dom,noinit){
		if(!noinit){
			dom.removeClass();
			dom.addClass('kwrybtnji');
			dom.attr('cnum',60);
			dom.html(dom.attr('cnum')+'秒后可重新获取');
			dom.removeAttr('onclick');
		}
		dom.html(dom.attr('cnum')-1+'秒后可重新获取');
		dom.attr('cnum',dom.attr('cnum')-1);
		if(dom.attr('cnum') == 20){
			$(".smscode_msg2").show();
		}
		if(dom.attr('cnum') <= 0){
			dom.attr('onclick',"getcode()");
			dom.html('');
			dom.removeClass();
			dom.addClass('kwrybtn');
			return;
		}
		setTimeout(function(){
			countdown(dom,true)
		},1000);
	};

	//创建网校成功之后的弹出层
	function getDialogHtml(obj,cong){
		var date1 = new Date();
        var date2 = new Date(date1);
        date2.setDate(date1.getDate()+7);
        var starttime = date1.getFullYear()+"-"+(date1.getMonth()+1)+"-"+date1.getDate();
        var endtime = date2.getFullYear()+"-"+(date2.getMonth()+1)+"-"+date2.getDate();
        
		var html = new Array();
		html.push('<div class="lsgegdr">');
		html.push('<div class="suctitle">创建成功</div>');
		html.push('<div class="kshtht">'+cong+'');
		html.push('<p class="oschoolname">'+obj.crname+'</p>');
		html.push('</div>');
		html.push('<div class="ljustd">');
		html.push('<p class="sitename">网址：http://'+obj.domain+'.ebh.net</p>');
		html.push('<span class="accpsd" style="margin-right:34px;">账号：'+obj.mobile+'</span>');
		html.push('<span class="accpsd">密码：'+obj.password+'</span>');
		html.push('</div>');
		html.push('<div class="usefullife">有效期：');
		html.push('<span>'+starttime+'</span><span>至</span><span>'+endtime+'</span>');
		html.push('</div>');
		html.push('<p class="timetip">（到期后请购买正式版继续享受服务，联系人：靳老师：</p>');
		html.push('<p class="timetip">13757168929，陈老师：13957170417）</p>');
		html.push('<a class="lstjdy" href="http://'+obj.domain+'.ebh.net/homev2.html">进入个人中心 &gt;&gt;</a>');
		html.push('</div>');
		return html.join('');
	}
	

	//同步登录
	function dosso(durl,callback){
		var img = new Image();
		img.src =durl;
		img.onload = function(){callback()};
	}

	function fixsend(){
		H.create(new P({
			id:'fixsend',
			content:$("#fixsendHtml")[0],
			title:'收不到短信？',
			easy:true,
			padding:5
		})).exec('show');
	}

	function fixsend_after(res){
		$dom = $("#sendmsg2");
		$dom.unbind('click');
		$dom.attr('onclick','');
		$dom.bind('click',function(){
			alert('无法重复获取');
			return;
		});
		$dom.removeClass();
		$dom.addClass('kwrybtnji');
		if(res.status == 0){
			$dom.html("发送成功");
		}else{
			$dom.html("发送失败");
		}
	}
</script>
<div id="fixsendHtml" style="display:none;width:440px;overflow:hidden;padding:40px 0px 60px 70px;">
	<p style="height:72px;overflow:hidden;clear:both;"><span>您可以尝试点击右侧　</span> <a href="javascript:void(0)" id="sendmsg2" onclick="getcode(1);" class="kwrybtn" style="margin-left:40px;"></a> <span>重新获取短信验证码</span><br/> </p>
	<p>如您还无法收到短信，您可以联系以下电话</p>
	<p>服务热线 : 0571-88252183</p>
	<p>靳老师 : 13757168928 陈老师 : 13957170417</p>
</div>
<!--尾部!-->
<div style="clear:both;"></div>
<?php debug_info();?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
<!-- 统计代码结束 -->

<?php $this->display('common/icp_footer'); ?>