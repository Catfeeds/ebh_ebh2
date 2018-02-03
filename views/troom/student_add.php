<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.datatab td{
	padding: 3px 7px;
} 
</style>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/easyui/themes/default/easyui.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troom/student') ?>">学员管理</a> > 添加学员
</div>
<div class="lefrig">
		<div class="annotate">在此页面中,教师可创建一个学生账号并加入到教室。</div>
		<form id="addform" method="post">
			<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width=100><label>学员帐号：</label></th>
				<td colspan="3">
					<input class="uipt w343" name="sname" id="sname" maxlength="18" type="text" />
					<span id="sname_msg" class="ts2"></span>
				</td>
			  </tr>
			  <tr class="pwd_block" style="display:none;">
				<th><label>学员密码：</label></th>
				<td colspan="3">
					<input class="uipt w343" name="pwd" id="pwd" maxlength="18" type="password" />
					<span id="pwd_msg" class="ts2"></span>
				</td>
			  </tr>
			  <tr class="pwd_block" style="display:none;">
				<th><label>确认密码：</label></th>
				<td colspan="3">
					<input class="uipt w343" name="newpwd" id="newpwd" maxlength="18" type="password" />
					<span id="newpwd_msg" class="ts2"></span>
				</td>
			  </tr>
		    <tr>
				<td colspan="4" style="padding:5px 0px;"><div style="border-bottom:1px dashed #C3C3C3; width:100%; "></div></td>
			 </tr>
			  <tr>
				<th><label>真实姓名：</label></th>
				<td colspan="3">
					<input class="uipt w343" maxlength="12" name="cnname" id="cnname" type="text" />
					<span id="cnname_msg" class="ts2"></span>
				</td>
			  </tr>

			  <tr>
				<th><label>性别：</label></th>
				<td colspan="3" style="padding-top:10px;">
					<input type="radio" name="sex" value="0" checked />男
					<input type="radio" name="sex" value="1" />女
				</td>
			  </tr>
			  
			  <tr>
				<th><label>出生年月：</label></th>
				<td colspan="3">
					<input class="uipt w156 easyui-datebox" type="text" id="birthday" name="birthday" />
					<span id="birthday_msg" class="ts2"></span>
				</td>
				
			  </tr>
			  <tr>
			  <th><label>手机号码：</label></th>
				<td colspan="2">
					<input class="uipt w156" name="mobile" id="mobile" maxlength="11" />
					<span id="mobile_msg" class="ts2"></span>
				</td>
				</tr>
			  <tr>
				<th><label>电子邮箱：</label></th>
				<td colspan="3">
					<input class="uipt w156" name="email" id="email" />
					<span id="email_msg" class="ts2"></span>
				</td>
			  </tr>
			  
			  <tr>
			  	<th></th>
				<td colspan="3"><input class="lanbtn" name="" value="添加学员" type="button" /></td>
			  </tr>
			 </table>
		 </form>
<script type="text/javascript">
var checkMobile = true;
var checkEmail = true;
var checkBirth = true;
$(function(){
    $(".datebox :text").attr("readonly","readonly");
    $("#mobile").blur(function(){
        var reg = /^1[3-8]+\d{9}/; 
        var mobile = $(this).val();
        if(!reg.test(mobile) && mobile!=''){
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
        var reg = /^[a-zA-Z0-9][a-zA-Z0-9_]{4,13}@[a-zA-Z0-9_]{2,8}\.[a-zA-Z]{2,5}$/; 
        var email = $(this).val();
        if(!reg.test(email) && email!=''){
            $("#email_msg").empty();
            $("#email_msg").css({color:"red"});
            $("#email_msg").html("邮箱格式不正确！");
            checkEmail = false;
        }else{
            $("#email_msg").empty();
            checkEmail = true;
        }
    })
    $("#birthday").blur(function(){
        var choose = $(this).val();
        var date = choose.split('-');
        // alert(date[0]);
        var now = new Date();
        if(date[0]>=now.getYear()+1900 && choose!=''){
            $("#birthday_msg").empty();
            $("#birthday_msg").css({color:"red"});
            $("#birthday_msg").html("出生日期不正确，请核对！");
            checkBirth = false;
        }else{
            $("#birthday_msg").empty();
            checkBirth = true;
        }
        //console.log(now.getYear()+1900-5,'nian',now.getMonth()+1,'yue',now.getDate());
    })

    $("#checkopen").click(function(){
		if($(this).attr("checked")){
			$(".checkopen").show();
		}else{
			$(".checkopen").hide();
		}
		top.resetmain();
	});
	$("#sname").blur(function(){
		checksname(this);
		top.resetmain();
	});
	$("#pwd").blur(function(){
		checkpwd(this);
	});
	$("#newpwd").blur(function(){
		checknewpwd(this);
	});
        $(".lanbtn").click(function(){
            submit_add();
        });
        
});
//提交
function submit_add() {
    if(add_student('add')) {    //验证
        var url = "<?= geturl('troom/student/add') ?>";
	$.ajax({
            type:"post",
            url:url,
            dataType:'json',
            data:$("#addform").serialize(),
            success:function(data){
                if(data != null && data != undefined && data.status == 1) {
                         $.showmessage({
                            img : 'success',
                            message:'添加学员成功',
                            title:'添加学员',
                            callback :function(){
                                 document.location.href = "<?= geturl('troom/student') ?>";
                            }
                        });
                    } else {
                        $.showmessage({
                            img : 'error',
                            message:'添加学员失败，请稍后再试或联系管理员。',
                            title:'添加学员'
                        });
                    }
           }
       });
    }
}
function uppassword(uid,cname)
{
	$('#uppass').dialog("open");
	$('#cname').text(cname);
	$('#rmemberid').val(uid);
	var ieset = navigator.userAgent;
}

$(function(){
	buttons = {"取消": function() { $(this).dialog("close");   },"确定": function() {if(submit_check(document.getElementById('upform'))) document.getElementById('upform').submit();}};
	$('#uppass').dialog({
		autoOpen: false,
		buttons:buttons,
		title:'修改学员密码',
		width: 400,
		height: 230,
		resizable:false,
		type:'post',
		modal: true//模式对话框
	});
});

function chknewpwd(newpwd){
	if(newpwd.length < 6 ){
		$("#newpwd1").html("密码位数不能低于6位！");
		bnewpwd = false;
	}else{
		$("#newpwd1").html("");
		$("#newpasstip").show();
		bnewpwd = true;
	}
}
function chkconfirmnewpwd(confirmnewpwd){
	if(confirmnewpwd == ""){
		$("#confirmnewpwd1").html("请输入确认密码！");
		bconfirmpwd = false;
	}else if(confirmnewpwd != $("#newpwd").val()){
		$("#confirmnewpwd1").html("两次密码输入不一致！");
		bconfirmpwd = false;
	}else{
		$("#confirmnewpwd1").html("");
		bconfirmpwd = true;
	}
}
function submit_check(){
	chknewpwd($("#newpwd").val());
	chkconfirmnewpwd($("#confirmnewpwd").val());
	if(!(bnewpwd && bconfirmpwd)){
		return false;
	}
	return true;
}


var _bpwd = true;
var _bnewpwd = true;

function checksname(_this){

	var _value = '';
	var _crname = $("#crname").val();
	if(typeof(_this) == 'object'){
		_value = $(_this).val();
	}else{
		_value = $("#"+_this).val();
	}
	if(_value == ''){
		$("#sname_msg").html("<font color='red'>学员帐号不能为空！</font>");
		_bsname = false;
	}else if(!_value.match(/^[a-zA-Z][a-z0-9A-Z_]{5,17}$/)){
		$("#sname_msg").html("<font color='red'>6~18个字符，包括字母、数字、下划线，字母开头！</font>");
		_bsname = false;
	}else{
            var url = "<?= geturl('troom/student/checkname') ?>";
		$.ajax({
			type:"post",
			url:url,
			dataType:'json',
			data:{'sname':_value},
			async:false,
			success:function(_json){
				if(_json.code == 0){
					$("#sname_msg").html("<font color='red'>"+_json.message+"</font>");
					$(".pwd_block").hide();
					_bsname = false;
				}else if(_json.code == 2){
					$("#sname_msg").html("<font color='green'>"+_json.message+"</font>");
					$(".pwd_block").show();
					_bsname = true;
					_bpwd = false;
					_bnewpwd = false;
				}else if(_json.code == 1){
					$("#sname_msg").html("<font color='green'>"+_json.message+"</font>");
					$(".pwd_block").hide();
					_bsname = true;
					_bpwd = true;
					_bnewpwd = true;
				}
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
	if(_value == ''){
		$("#pwd_msg").html("<font color='red'>请设置密码！</font>");
		_bpwd = false;
	}else if(_value.length < 6){
		$("#pwd_msg").html("<font color='red'>密码长度至少6位！</font>");
		_bpwd = false;
	}else{
		$("#pwd_msg").html("");
		_bpwd = true;
	}
}
function checknewpwd(_this){
	var _value = '';
	if(typeof(_this) == 'object'){
		_value = $(_this).val();
	}else{
		_value = $("#"+_this).val();
	}
	if(_value == ''){
		$("#newpwd_msg").html("<font color='red'>确认密码不能为空！</font>");
		_bnewpwd = false;
	}else if(_value != $("#pwd").val()){
		$("#newpwd_msg").html("<font color='red'>两次密码不同，请重新确认！</font>");
		_bnewpwd = false;
	}else{
		$("#newpwd_msg").html("");
		_bnewpwd = true;
	}
}
function checktime(){
	if($("#begintime").val() == ''){
		$("#begintime").focus();
		return false;
	}
	if($("#endtime").val() == ''){
		$("#endtime").focus();
		return false;
	}
	return true;
}

function add_student(type){
	checksname('sname');
	if($($(".pwd_block")[0]).css("display") != 'none'){
		checkpwd("pwd");
		checknewpwd("newpwd");
	}else{
		_bpwd = true;
		_bnewpwd = true;
	}
	var _time = true;


	if($("#checkopen").attr("checked")){
		_time = checktime(); 
	}
	
    var _b = _bsname && _bpwd && _bnewpwd && _time;

    

    if($("#mobile").val()=="" && $("#email").val()=="" && $("#birthday").val==""){
    	_d = false;
    }else{
    	_d =true;
    }
    var _c = checkMobile&&checkEmail&&checkBirth&&_b&&_d;
    // alert(_b+":"+_d+":"+_c+":"+_bsname+":"+_bpwd+":"+_bnewpwd+":"+_time+":"+checkMobile+":"+checkEmail+":"+checkBirth);
    // return false;
    if(_c){
        return true;
    }else {
        // alert("请确认您填写的信息是否正确！");
        return false;
    }
}
</script>
<?php $this->display('troom/page_footer'); ?>