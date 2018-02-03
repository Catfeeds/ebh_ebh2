<?php $this->display('common/forget_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<style>
	.txtktb{
		color:#000;
	}
	.hit{
		color:#999;
	}
	.yantes{margin-right:0;}
</style>
<div class="awmbg">
  <div class="main lidtgd">

<div class="retpassword">
	<div class="title">找回密码</div>
	<div class="repawlist">
		<ul>
			<li class="emails"><a   href="/forget.html">通过邮箱找回密码</a></li>
			<li class="phone"><a class="cur" href="/forget/mobile.html">通过手机找回密码</a></li>
		</ul>
	</div>
</div>

<?php if($flag){?>
<form id="resetform" name="resetform">
<input type="hidden" name="codekey" value="<?=$codekey?>" />
<input type="hidden" name="doreset" value="1" />
<div class="yznr">
<div class="sjzhts">手机验证成功，请输入新密码</div>
<div class="clear"></div>
<div style="margin-top:25px;" class="lidet">
<span class="gkswey gksweys">请输入新密码：</span>
<input type="password" x_hit="请输入6~16位密码" x_func="checkpwd"  value="" class="txtktb txtktbs hit" id="pwd" name="pwd" />
<p  id="pwd_msg"></p>
</div>
<div class="clear"></div>
<div style="margin-top:25px;" class="lidet">
<span class="gkswey gksweys">确认密码：</span>
<input type="password" x_hit="请再次输入新密码" x_func="checkrpwd" value="" class="yantes txtktb txtktbs  hit" id="rpwd" name="rpwd">
		<p  id="rpwd_msg"></p>
</div>
<div class="clear"></div>
<div style="margin-left:140px;">
<a class="ieurgrs" href="javascript:;" onclick="myset()">确认</a>
</div>
</div>
</form>	
<?php }else{?>
<div class="yznr">
    	<div>
        	<div class="fl yzsbimg"><img width="101" height="125" src="http://static.ebanhui.com/ebh/tpl/2016/images/aynse2.jpg"></div>
            <div class="yzsb fl">
            	<p>验证失败，请重新操作，<span style="color:#0273ff;" id="nums">3s</span>后直接跳转</p>
                <div style="margin-left:20px;">
            		<a style="margin-top:25px;" class="ieurgrs" id="doback" href="/forget/mobile.html">验证手机</a>
        		</div>  
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var nums = 3;
	var timer = setInterval(function(){
		$("#nums").text(nums+'s');
		nums--;
		if(nums<=0){
			clearInterval(timer);
			var href = $("#doback").attr("href");
			location.href = href;
			//$("#doback").trigger("click");
			}
		},800);
    </script>
<?php }?>
	<div class="clear"></div>
  </div>
  <div style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/fotbottg.jpg) no-repeat;margin:0 auto;width:820px;height:16px; position: relative; top: -1px;"></div>
  </div>
<script type="text/javascript">
var _xform = new xForm({
	domid:'resetform',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});

function checkpwd(obj){
	var password = _xform.getdata().pwd;
	obj.res = -1;
	if (password == '') {
		obj.msg = '请输入密码！';
	} else if (password.length < 6 || password.length > 16 ) {
		obj.msg = '密码位数不正确。';
	}else {
		obj.res = 0;
	}
}
function checkrpwd(obj){
	obj.res = -1;
	var password = _xform.getdata().pwd;
	var password2 = _xform.getdata().rpwd;
	
	if (password2 == '') {
		obj.msg = '请再次输入密码！';
	} else if (password2.length < 6 || password2.length > 16) {
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
function myset(){
	var ret = _xform.check();
	if(!ret){
		return false;
	}
	$.ajax({
		type:"POST",
		url:'<?=geturl('forget/mobile_reset')?>',
	    data: $('#resetform').serialize(),
	    dataType:'json',
	    async:false,
        success: function (json) {
            if (json.code) {
				//修改成功
				$.showmessage({
					img		 :'success',
					message  :"恭喜您,密码设置成功",
					title    :'消息通知',
					callback  :function(){
						//console.log(json);
						if(json['durl'] != undefined) {
							dosso(json['durl'],json["backurl"]);
						} else {
							location.href = json["backurl"];
						}
					}      
				});
			}else{
				//修改失败		
				$.showmessage({
					img		 :'error',
					message  :"密码设置失败,不能与旧密码相同,请刷新后重试",
					title    :'消息通知'
				});				
			}
		}
	});
}

//同步登陆
function dosso(durl,returnurl,callback) {
	var img = new Image();
	img.src = durl;
	$(img).appendTo("body");
	if(img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
		return; // 直接返回，不用再处理onload事件
	}
	img.onload = function () { //图片下载完毕时异步调用callback函数。
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
	};
}
</script>
<?php $this->display('common/site_footer')?>
