<?php $this->display('aroom/page_header')?>


<?php $sexed[$studentdetail['sex']] = 'checked="checked"'?>
<?php $classed[$studentdetail['classid']] = 'selected'?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/easyui/themes/default/easyui.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroom/student')?>">学生管理</a> > 修改学生信息
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:768px;padding-left:20px;">
<form action="<?=geturl('aroom/student/edit')?>" method="post" onsubmit="return add_student()">
	<input type="hidden" name="uid" value="<?=$studentdetail['uid']?>"/>
	<input type="hidden" name="oldclassid" value="<?=$studentdetail['classid']?>"/>
	<div class="field">
	<span class="inpqian">登录账号：</span>
	<input class="shutxt" type="text" value="<?=$studentdetail['username']?>" readonly="readonly" name="username" id="username"/>
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">学生姓名：</span>
	<input class="shutxt" type="text" onblur="checkrealname()" value="<?=$studentdetail['realname']?>" name="realname" id="realname"/>
	<em id="realname_msg"></em>
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">性　　别：</span>
	  <input name="sex" type="radio" id="sex" style="top:3px;position:relative;" value="0" <?=!empty($sexed[0])?$sexed[0]:''?> />男
	  <input style="top:3px;position:relative;" type="radio" name="sex" id="sex" value="1" <?=!empty($sexed[1])?$sexed[1]:''?> />女
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">出生年月：</span>
	<input id="datebox" name="birthdate" class="easyui-datebox" value="<?=isset($studentdetail['birthdate'])?Date('Y-m-d',$studentdetail['birthdate']):''?>">
	
	<em id="birthdate_msg">
	</em>
	</div>
	<div class="field">
	<span class="inpqian" style="background:none;">手机号码：</span>
	<input class="shutxt" type="text" value="<?=$studentdetail['mobile']?>" name="mobile" id="mobile">
	<em id="mobile_msg"></em></div>
	<div class="field">
	<span class="inpqian" style="background:none;">电子邮箱：</span>
	<input class="shutxt" type="text" value="<?=$studentdetail['email']?>" name="email" id="email">
	<em id="email_msg"></em>
	</div>
	
	<div class="field">
	<span class="inpqian" style="background:none;">所属班级：</span>
	
	<select class="selects" name="classid" id="classid">
		<?php foreach($classlist as $cl){?>
	    	<option value="<?=$cl['classid']?>" <?=!empty($classed[$cl['classid']])?$classed[$cl['classid']]:''?>><?=$cl['classname']?></option>
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
            $("#mobile_msg").html("<font color='red'>手机号码格式不正确！</font>");
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
            $("#email_msg").html("<font color='red'>邮箱格式不正确！</font>");
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
            $("#birthdate_msg").html("<font color='red'>出生日期不正确，请核对！</font>");
            checkBirth = false;
        }else{
            $("#birthdate_msg").empty();
            checkBirth = true;
        }
        //console.log(now.getYear()+1900-5,'nian',now.getMonth()+1,'yue',now.getDate());
    })
})
// var _bsname = false;
var _bpwd = true;
var _bnewpwd = true;
var _rname = true;
$(function(){
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
		// var ab = /^(1[3-9]{1}[0-9]{9})$/;
		//var ab = /^(((13[0-9]{1})|159|153)+\d{8})$/;
		var ab = /^1[3-8]{1}\d{9}$/;//和个人中心的对应
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
			checkEmail =false;
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

	var mobile = $("#mobile").val();
	var email = $("#email").val();
	if(mobile!=''){
		checkmobile();        
	}else{
		$("#mobile_msg").attr('class','');
		$("#mobile_msg").html("");
	}
	if(email!=''){
		checkemail();
	}else{
		$("#email_msg").attr('class','');
		$("#email_msg").html("");
	}
	// alert(_bsname+":"+_bpwd+":"+_bnewpwd+":"+_rname);
	if(!(_bpwd && _bnewpwd && _rname)){
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
<?php $this->display('aroom/page_footer')?>