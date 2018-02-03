<?php $this->display('aroomv2/page_header')?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/teacher')?>">教师管理</a> > 添加教师
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:766px;padding-left:20px;">
<form action="" method="post" onsubmit="return add_teacher()">

<div class="field">
<span class="inpqian">登录账号：</span>
<input class="shutxt" type="text" value="" name="tname" id="tname">
<a class="previewBtn marlef" href="javascript:;">检测帐号</a>
<em id="tname_msg" style="width:auto;"></em>
</div>
<div class="field pwd" style="display:none;">
<span class="inpqian">密　　码：</span>
<input class="shutxt" type="password" value="" name="pwd" id="pwd">
<em id="pwd_msg"></em>
</div>
<div class="field pwd" style="border-bottom:dashed 1px #cdcdcd;display:none;">
<span class="inpqian">确认密码：</span>
<input class="shutxt" type="password" value="" name="confirmpwd" id="confirmpwd">
<em id="confirmpwd_msg"></em>
</div>
<div class="field">
<span class="inpqian" style="background:none;">教师姓名：</span>
<input class="shutxt" type="text" value="" name="realname" id="realname"/>
<em id="realname_msg"></em>
</div>
<div class="field">
<span class="inpqian" style="background:none;">联系方式：</span>
<input class="shutxt" type="text" value="" name="mobile" id="mobile" maxlength="25">
<em id="mobile_msg"></em>
</div>
<div class="field pwd" style="display:none;">
<span class="inpqian" style="background:none;">性　　别：</span>
<label style="">
<input type="radio" style="width:15px;height:15px;line-height:15px;top:4px;position:relative" checked="checked" value="0" name="sex">男
</label>
<label>
<input type="radio" style="width:15px;height:15px;line-height:15px;top:4px;position:relative" value="1" name="sex">女
</label>
<em id="mobile_msg"></em>
</div>
<input type="submit" class="huangbtn marlef75" value="确 认"/>
<input class="lanbtn marlef" type="button" onclick="window.history.back(-1);" value="返 回" />
</form>
</div>
<script type="text/javascript">
var _bname = false;
var _bpwd = true;
var _bcpwd = true;
var _rname = false;
var _mobile = false;
$(function(){
	$("#tname").blur(function(){
		checktname('tname');
	});
	$(".jiance").click(function(){
		checktname('tname');
	});
	$("#pwd").blur(function(){
		checkpwd(this);
	});
	$("#confirmpwd").blur(function(){
		checkcpwd(this);
	});
	$("#realname").blur(function(){
		checktrealname();
	});
	//$("#mobile").blur(function(){
	//	checkmobile();
	//});
});

function checktname(_this){
	var _value = $("#tname").val();
	if(_value == ''){
		$("#tname_msg").attr('class','emacuo');
		$("#tname_msg").html('<font color="red">登录账号不能为空！</font>');
		_bname = false;
	}else if(!_value.match(/^[a-zA-Z][a-z0-9A-Z_]{5,15}$/)){
		$("#tname_msg").attr('class','emails');
		$("#tname_msg").html('<font color="red">6~16个字符，包括字母、数字、下划线，以字母开头</font>');
		_bname = false;
	}else{
		$.ajax({
			type:'post',
			url:'<?=geturl('aroomv2/teacher/add')?>',
			dataType:'json',
			data:{'tname':_value,'checkonly':1},
			async:false,
			success:function(_json){
				if(_json.code == 1){
					$("#tname_msg").attr('class','emadui');
					$("#tname_msg").html('<font color="green">'+_json.message+'</font>');
					$(".pwd").show();
					top.resetmain();
					_bname = true;
					_bpwd = false;
					_bcpwd = false;
				}else if(_json.code == 2){
					$("#tname_msg").attr('class','emacuo');
					$("#tname_msg").html('<font color="red">'+_json.message+'</font>');
					$(".pwd").hide();
					top.resetmain();
					_bname = false;
					_bpwd = false;
					_bcpwd = false;
				}else{
					$("#tname_msg").attr('class','emadui');
					$("#tname_msg").html('');
					$(".pwd").hide();
					top.resetmain();
					_bname = true;
					_bpwd = true;
					_bcpwd = true;
				}
			},
			error:function(){
				$("#tname_msg").attr('class','emails');
				$("#tname_msg").html('<font color="red">服务器请求出错了,请稍后重试</font>');
				_bname = false;
			}
		});
	}
}

function checkpwd(_this){
	var _value = '';
	if(typeof(_this) == 'object'){
		_value = $(_this).val();
	}else{
		_value = $("#"+_this).val();
	}
	if(_value.length < 6){
		$("#pwd_msg").attr('class','emacuo');
		$("#pwd_msg").html("<font color='red'>密码不能少于6位</font>");
		_bpwd = false;
	}else{
		$("#pwd_msg").attr('class','emadui');
		$("#pwd_msg").html("");
		_bpwd = true;
	}
}
function checkcpwd(_this){
	var _value = '';
	if(typeof(_this) == 'object'){
		_value = $(_this).val();
	}else{
		_value = $("#"+_this).val();
	}
	if(_value == ''){
		$("#confirmpwd_msg").attr('class','emacuo');
		$("#confirmpwd_msg").html("<font color='red'>请确认密码</font>");
		_bcpwd = false;
	}else if(_value != $("#pwd").val()){
		$("#confirmpwd_msg").attr('class','emacuo');
		$("#confirmpwd_msg").html("<font color='red'>两次密码不同，请重新确认</font>");
		_bcpwd = false;
	}else{
		$("#confirmpwd_msg").attr('class','emadui');
		$("#confirmpwd_msg").html("");
		_bcpwd = true;
	}
}
function checktrealname(){
	var _value = $.trim(HTMLDeCode($("#realname").val()));
	// var _value = _value.replace(/(^\s+)|(\s+$)/g,"");

	if(_value == ''){
		$("#realname_msg").attr('class','emacuo');
		$("#realname_msg").html('<font color="red">教师姓名不能为空</font>');
		_rname = false;
	} else {
		$("#realname_msg").attr('class','emadui');
		$("#realname_msg").html('');
		_rname = true;
	}
}

//function checkmobile(){
//	var mobile =$("#mobile").val(); 

//	if(mobile == "")
//		_mobile = true;
//	else{
//		var ab = /^(((13[0-9]{1})|159|153)+\d{8})$/;
//		if(!ab.test(mobile)){
//			$("#mobile_msg").attr('class','emails');
//			$("#mobile_msg").html("<font color=#f00>联系方式不正确！</font>");
//			_mobile = false;
//		}else{
//			$("#mobile_msg").attr('class','emadui');
//			$("#mobile_msg").html("");
//			_mobile = true;
//		}
//	}
//}
function add_teacher(){
	checktname("tname");
	if($($(".pwd")[0]).css("display") != 'none'){
		checkpwd("pwd");
		checkcpwd("confirmpwd");
	}
	checktrealname();
//checkmobile();
	if(!(_bname && _bpwd && _bcpwd && _rname )){
		return false;
	}
	return true;
}

</script>
<?php $this->display('aroomv2/page_footer')?>

