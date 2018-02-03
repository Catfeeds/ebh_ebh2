<?php $this->display('aroomv2/page_header')?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/easyui/themes/default/easyui.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/student')?>">学生管理</a> > 添加学生
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:766px;padding-left:20px;">
<form action="" method="post" onsubmit="return add_student()">
	<div class="field">
	<span class="inpqian">登录账号：</span>
	<input class="shutxt" type="text" value="" name="username" id="username"/>
	<a class="previewBtn marlef" href="javascript:void(0);" id="sname">检测账号</a>
	<em id="username_msg" style="width:auto;"></em>
	</div>
	<div class="field pwd_block" style="display:none;">
	<span class="inpqian">密　　码：</span>
	<input class="shutxt" type="password" value="" name="password" id="pwd">
	<em id="pwd_msg"></em>
	</div>
	<div class="field pwd_block" style="border-bottom:dashed 1px #cdcdcd;display:none;">
	<span class="inpqian">确认密码：</span>
	<input class="shutxt" type="password" value="" name="confirmpwd" id="confirmpwd">
	<em id="confirmpwd_msg"></em>
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">学生姓名：</span>
	<input class="shutxt" type="text" value="" onblur="checkrealname()" name="realname" id="realname"/>
	<em id="realname_msg"></em>
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">性　　别：</span>
	  <input name="sex" type="radio" id="sex" style="top:3px;position:relative;" value="0" checked="checked" />男
	  <input style="top:3px;position:relative;" type="radio" name="sex" id="sex" value="1" />女
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">出生年月：</span>
	<input id="datebox" name="birthdate" class="easyui-datebox" value="1991-01-01">
	
	<em id="birthdate_msg">
	</em>
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">手机号码：</span>
	<input class="shutxt" type="text" value="" name="mobile" id="mobile">
	<em id="mobile_msg"></em></div>
	<div class="field">
	<span class="inpqian" style="background:none;">电子邮箱：</span>
	<input class="shutxt" type="text" value="" name="email" id="email">
	<em id="email_msg"></em>
	</div>
	
	<div class="field">
	<span class="inpqian" style="background:none;">所属班级：</span>
	
	<select class="selects" name="classid" id="classid">
		<?php foreach($classlist as $v){?>
		    	<option <?php if($classid==$v['classid']){?>selected="selected"<?php }?> value="<?=$v['classid']?>"><?=$v['classname']?></option>
		<?php }?>		
	</select>
	</div>
	<input type="submit" class="huangbtn marlef75" value="确 认"/>
	<a class="lanbtn marlef" href="javascript:window.history.back(-1);">返回上页</a>
	
</form>
</div>
<script type="text/javascript">
var checkMobile = true;
var checkEmail = true;
var checkBirth = true;
$(function(){
	$(".datebox :text").attr("readonly","readonly");
    $("#mobile").blur(function(){
        var reg = /^1[3-8]+\d{9}/; 
        var mobile = $(this).val();
	    if(!reg.test(mobile) && mobile !=""){
            $("#mobile_msg").empty();
            $("#mobile_msg").css({color:"red"});
            $("#mobile_msg").html("手机号码格式不正确！");
            checkMobile = false;
        }else{
            $("#mobile_msg").empty();
            checkMobile = true;
        }
    })
    $("#email").blur(function(){
        var reg = /^[a-zA-Z0-9][a-zA-Z0-9_]{4,13}@[a-zA-Z0-9_]{2,8}\.[a-zA-Z]{2,5}/; 
        var email = $(this).val();
        if(!reg.test(email) && email !=""){
            $("#email_msg").empty();
            $("#email_msg").css({color:"red"});
            $("#email_msg").html("邮箱格式不正确！");
            checkEmail = false;
        }else{
            $("#email_msg").empty();
            checkEmail = true;
        }
    })
    $("#birthdate").blur(function(){
    	var choose = $(this).val();
    	var date = choose.split('-');
        var now = new Date();
        if(date[0]>=now.getYear()+1900 && choose != ""){
            $("#birthdate_msg").empty();
            $("#birthdate_msg").css({color:"red"});
            $("#birthdate_msg").html("出生日期不正确，请核对！");
            checkBirth = false;
        }else{
            $("#birthdate_msg").empty();
            checkBirth = true;
        }
        //console.log(now.getYear()+1900-5,'nian',now.getMonth()+1,'yue',now.getDate());
    })
})
var _bsname = false;
var _bpwd = true;
var _bnewpwd = true;
var _rname = true;
$(function(){
	$("#checkopen").click(function(){
		if($(this).attr("checked")){
			$(".checkopen").show();
		}else{
			$(".checkopen").hide();
		}
		top.resetmain();
	});
	$("#sname").click(function(){
		checksname(); 	
		top.resetmain();
	});
	$("#pwd").blur(function(){
		chknewpwd();
	});
	$("#confirmpwd").blur(function(){
		chkconfirmnewpwd();
	});
	$("#mobile").blur(function(){
		checkmobile();
	});
	$("#email").blur(function(){
		checkemail();
	});
});
function checksname(){
	var _crid = $("#crid").val();
	var _value = $("#username").val();
	if(_value == ''){
		$("#username_msg").attr('class','emacuo');
		$("#username_msg").html("<font color='red'>学员帐号不能为空！</font>");
		_bsname = false;
	}else if(!_value.match(/^[a-zA-Z][a-z0-9A-Z_]{5,15}$/)){
		$("#username_msg").attr('class','emails');
		$("#username_msg").html("<font color='red'>6~16个字符，包括字母、数字、下划线，字母开头！</font>");
		_bsname = false;
	}else{
		$.ajax({
			type:"post",
			url:"<?=geturl('aroomv2/student/add')?>",
			dataType:'json',
			data:{'username':_value,'crid':_crid,'checkonly':1},
			async:false,
			success:function(_json){
				if(_json.code == 0){
					$("#username_msg").attr('class','emacuo');
					$("#username_msg").html("<font color='red'>"+_json.message+"</font>");
					$(".pwd_block").hide();
					_bsname = false;
				}else if(_json.code == 2){
					$("#username_msg").attr('class','emadui');
					$("#username_msg").html("<font color='green'>"+_json.message+"</font>");
					$(".pwd_block").show();
					_bsname = true;
					_bpwd = false;
					_bnewpwd = false;
				}else if(_json.code == 1){
					$("#username_msg").attr('class','emadui');
					$("#username_msg").html("<font color='green'>"+_json.message+"</font>");
					$(".pwd_block").hide();
					_bsname = true;
					_bpwd = true;
					_bnewpwd = true;
				}
			}
		});
	}
}

function chknewpwd(){
	if($("#pwd").val().length < 6 ){
		$("#pwd_msg").attr('class','emacuo');
		$("#pwd_msg").html("<font color='red'>密码不能少于6位</font>");
		_bpwd = false;
	}else{
		$("#pwd_msg").attr('class','emadui');
		$("#pwd_msg").html("");
		_bpwd = true;
	}
}
function chkconfirmnewpwd(){
	var pwd = $("#pwd").val();
	var confirmpwd = $("#confirmpwd").val();
	if(confirmpwd == ""){
		$("#confirmpwd_msg").attr('class','emacuo');
		$("#confirmpwd_msg").html("<font color='red'>请输入确认密码！</font>");
		_bnewpwd = false;
	}else if(pwd != confirmpwd){
		$("#confirmpwd_msg").attr('class','emacuo');
		$("#confirmpwd_msg").html("<font color='red'>两次密码输入不一致！</font>");
		_bnewpwd = false;
	}else{
		$("#confirmpwd_msg").attr('class','emadui');
		$("#confirmpwd_msg").html("");
		_bnewpwd = true;
	}
}

function checkrealname(){
	var _value = $("#realname").val();
	if(_value != ''){
		if ($("#realname").val().length>16) {
			$("#realname_msg").attr('class','emails');
			$("#realname_msg").html('<font color="red">请填写有效的姓名,16个字符以内!</font>');
			_rname = false;
		}else{
			$("#realname_msg").attr('class','emadui');
			$("#realname_msg").html('');
			_rname = true;
		}
	} 
}

function checkmobile(){
	var mobile =$("#mobile").val(); 
	if(mobile !=""){
        var ab = /^(((13[0-9]{1})|159|153|189)+\d{8})$/;

		if(!ab.test(mobile)){
			$("#mobile_msg").attr('class','emails');
			$("#mobile_msg").html("<font color=red>手机号码不正确！</font>");
			checkMobile = false;
		}else{
			$("#mobile_msg").attr('class','emadui');
			$("#mobile_msg").html("");
			checkMobile = true;
		}
	}else{
		$("#mobile_msg").attr('class','');
		$("#mobile_msg").html("");
		checkMobile = true;
	}
}

function checkemail(){
	var email =$("#email").val();	
	if(email != ""){
		var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!emailreg.test(email)){
			$("#email_msg").attr('class','emails');
			$("#email_msg").html("<font color=red>请填写有效的E-mail地址！</font>");
			checkEmail = false;
		}else{
			$("#email_msg").attr('class','emadui');
			$("#email_msg").html("");
			checkEmail = true;
		}
	}else{
		$("#email_msg").attr('class','');
		$("#email_msg").html("");
		checkEmail = true;
	}
}
function add_student(){
	checksname();
	if($($(".pwd_block")[0]).css("display") != 'none'){
		chknewpwd();
		chkconfirmnewpwd();
	}else{
		_bpwd = true;
		_bnewpwd = true;
	}
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	if(mobile!=''){
		checkmobile();
	}else{
		$("#mobile_msg").attr('class','');
		$("#mobile_msg").html("");
	}

	if($("#realname").val()!=""){
		checkrealname();
	}
	if(email!=''){
		checkemail();
	}else{
		$("#email_msg").attr('class','');
		$("#email_msg").html("");
	}
	if(!(_bsname && _bpwd && _bnewpwd && _rname)){
		return false;
	}
	var classid = $('#classid').val();
	if(classid=='' || classid==undefined){
		alert('还没有班级，请先添加班级!');
		return false;
	}
	if(checkMobile&&checkEmail&&checkBirth){
        return true;
    }else {
        // alert("请确认您填写的信息是否正确！");
        return false;
    }
}


</script>
<?php $this->display('aroomv2/page_footer')?>
