<?php $this->display('aroom/page_header')?>

<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroom/teacher')?>">教师管理</a> > 修改教师信息
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:768px;padding-left:20px;">
<form action="<?=geturl('aroom/teacher/edit')?>" method="post" onsubmit="return add_teacher()">
<div class="field">
<span class="inpqian">登录账号：</span>
<input class="shutxt" type="text" value="<?=$teacherdetail['username']?>" readonly="readonly" name="tname" id="tname">
<input type="hidden" name="uid" value="<?=$teacherdetail['uid']?>"/>
</div>
<div class="field">
<span class="inpqian" style="background:none;">教师姓名：</span>
<input class="shutxt" type="text" value="<?=$teacherdetail['realname']?>" name="realname" id="realname"/>
<em id="realname_msg"></em>
</div>
<div class="field">
<span class="inpqian" style="background:none;">联系方式：</span>
<input class="shutxt" type="text" value="<?=$teacherdetail['mobile']?>" name="mobile" id="mobile" maxlength="25">
<em id="mobile_msg"></em>
</div>
<input type="submit" class="huangbtn marlef75" value="确 认"/>
<input class="lanbtn marlef" type="button" onclick="window.history.back(-1);" value="返 回" />
</form>
</div>
<script type="text/javascript">
var _rname = false;
var _mobile = false;
$(function(){
	$("#realname").blur(function(){
		checktrealname();
	});
	//$("#mobile").blur(function(){
	//	checkmobile();
	//});
});
function checktrealname(){
	// var _value = $("#realname").val();
	var _value = $.trim(HTMLDeCode($("#realname").val()));
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
//			$("#mobile_msg").html("<font color='red'>联系方式不正确！</font>");
//			_mobile = false;
//		}else{
//			$("#mobile_msg").attr('class','emadui');
//			$("#mobile_msg").html("");
//			_mobile = true;
//		}
//	}
//}
function add_teacher(){
	//checkemail();
	checktrealname();
	//checkmobile();
	if(!( _rname )){
		return false;
	}
	return true;
}

</script>
<?php $this->display('aroom/page_footer')?>

