<?php $this->display('aroomv2/page_header');?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<body>
<div>
	<div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/classes/student')?>">班级学生</a> > <a href="<?=geturl('aroomv2/lcyhstu')?>">学生管理</a> > 学生列表
    </div>
    <div class="xueshengguanli2">
    	<div class="xueshengguanli2_top fr">
        	<ul>
            	<li class="fl "><a href="javascript:void(0)" onclick="addstudent()">添加学生</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="xueshengguanli2_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                    <td width="190">学生</td>
                	<td width="85">班级</td>
                    <td width="130">邮箱</td>
                    <td width="90">联系电话</td>
                    <td width="240">操作</td>
                </tr>
				<?php 
				$rurl = $this->input->get('rurl');
				$rrurl = $this->input->get('rrurl');
				if(!empty($roomuserlist)){
				foreach($roomuserlist as $user){
					$face = '';
					$face = getthumb($user['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($user['sex'])?'m_man_50_50.jpg':'m_woman_50_50.jpg');
					
					?>
                <tr>
					<td width="190"><div class="fl"><img style="width:50px;height:50px" src="<?=$face?>" /></div><div class="p2" style="line-height:18px;"><p style="width:130px;height:18px; overflow:hidden;"><b title="<?=$user['realname']?>"><?=shortstr(empty($user['realname'])?$user['username']:$user['realname'],12,'')?>(<?=empty($user['sex'])?'男':'女'?>)</b></p><p style="width:95px;height:18px; overflow:hidden;"><?=$user['username']?></p><p class="jifenico" style="color:#9e9ea0 !important;"><?=$user['credit']?></span></p></div></td>
                	<td width="85"><?=$user['classname']?></td>
                    <td width="130"><?=empty($user['email'])?'':$user['email']?></td>
                    <td width="90"><?=empty($user['mobile'])?'':$user['mobile']?></td>
                    <td width="240">
                    	<a target="_blank" href="/aroom/umanager/student.html?s=<?=urlencode(authcode($user['uid'],'ENCODE'))?>">进入学生首页</a>
                        <a href="javascript:void(0)" class="aedit">编辑</a>
                        <a data-classid="<?=$user['classid']?>" href="javascript:void(0)" class="adel">删除</a>
                        <a href="javascript:void(0)" class="aresetpass">重置密码</a>
						<input type="hidden" class="stuinfo" username="<?=$user['username']?>" realname="<?=$user['realname']?>" uid="<?=$user['uid']?>" sex="<?=$user['sex']?>" classid="<?=$user['classid']?>" email="<?=$user['email']?>" mobile="<?=$user['mobile']?>" classname="<?=$user['classname']?>" birthdate="<?=$user['birthdate']?>"/>
                    </td>
                </tr>
				<?php }}else{
					$q = $this->input->get('q');
					?>
				<tr><td colspan="5" style="text-align:center"><?=empty($q)?'暂无数据':'没有关于 "'.$q.'" 的搜索结果'?></td></tr>
				<?php }?>
            </table>
        </div>
    </div>
    
    <div class="button5 fr"><a href="/<?=$rurl?>.html?rurl=<?=$rrurl?>">返 回</a></div>
	<?=$pagestr?>
</div>

<!--重置密码-->
<div id="dialogpass" style="display:none;height:160px;">
<div class="resetpassword" style="height:160px;width:400px;">
<!--
	<div class="title2"><p>密码重置</p></div>
	-->
    <div class="mt15">
    	<span>登录账号：</span>
        <input id="pass_username" readonly="readonly" class="text input readonly" type="text" value="" style="color:#cdcdcd"/>
		<input id="pass_uid" type="hidden"  value=""/>
    </div>
    <div class="resetting1 mt10">
    	<span>学生姓名：</span>
        <input id="pass_realname" readonly="readonly" class="text input readonly" type="text"  value="" style="color:#cdcdcd"/>
    </div>
    <div class="resetting mt10">
    	<span>重置密码：</span>
        <input id="pass_password" class="text input" type="password"  value="" x_hit="请输入密码"/>
    </div>
    <div class="resetting1 mt10">
    	<span>确认密码：</span>
        <input id="pass_confirm" class="text input" type="password"  value="" x_hit="请输入确认密码"/>
    </div>
</div>
</div>


<!--编辑学生-->
<div id="dialogedit" style="display:none">
<div class="editstudents" style="height:280px;">
<!--
	<div class="title2"><p>编辑</p></div>
	-->
    <div class=" mt15 ml55 edus">
    	<span>登录账号：</span>
		<input id="user_edit_uid" type="hidden"/>
        <input id="user_edit_username" readonly="readonly" class="text input readonly" type="text" value="" />
    </div>
    <div class=" ml55 edus">
    	<span>学生姓名：</span>
        <input id="user_edit_realname" class="text input" type="text" value=""/>
    </div>
    <div class="xingbie ml55 edus">
     	<span >学生性别：</span>
    	
        <input id="user_edit_sex0" type="radio" class="sexedit" name="sex" value="0"/>
        <span class="span2">男</span>
        <input id="user_edit_sex1" type="radio" class="sexedit" name="sex" value="1"/>
        <span class="span2">女</span>
    </div>
	 
    <div class=" ml55 edus">
    	<span>出生年月：</span>
        <input id="user_edit_birthdate" class="text input readonly" readonly="readonly" type="text" value="" style="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:''});"/>
    </div>
    <div class=" ml55 edus">
    	<span>电子邮箱：</span>
        <input id="user_edit_email" class="text input" type="text"  value=""/>
    </div>
    <div class=" ml55 edus">
    	<span>联系电话：</span>
        <input id="user_edit_mobile" class="text input" type="text"  value=""/>
    </div>
</div>
</div>

<!--删除学生-->
<div id="dialogdel" style="display:none">
<div class="deletestudents">
<!--
	<div class="title"><p>删除学生</p></div>
	-->
    <div class="tishi"><span>你确认要删除此学生吗？</span></div>
	<input type="hidden" id="del_uid">
	<input type="hidden" id="del_classid">
</div>
</div>


<!--添加学生-->
<div id="dialogadd" style="display:none">
<div class="editstudents" style="height:260px;">
<!--
	<div class="title2"><p>添加学生</p></div>
	-->
    <div class=" ml25 mt5">
    	<span>登录账号：</span>
        <input id="user_add_username" class="text input" type="text"  value="" x_hit="请输入学生登录账号"/>
        <p class="p3" id="username_msg"></p>
    </div>
	
	<div class="pwd_block" style="display:none">
    <div class=" ml25 mt5">
    	<span>密　　码：</span>
        <input id="user_add_password" class="text input" type="password"  value="" x_hit="位数为6-16个字符，区分大小写"/>
        <p class="p3" id="pwd_msg"></p>
    </div>
    <div class=" ml25 mt5">
    	<span>确认密码：</span>
        <input id="user_add_confirm" class="text input" type="password"  value="" x_hit="请再次输入账号密码，以便确认密码输入正确">
        <p class="p3" id="confirmpwd_msg"></p>
    </div>
	</div>
	
    <div class=" ml25 mt5 ">
    	<span>姓　　名：</span>
        <input id="user_add_realname" class="text input" type="text"  value="" x_hit="请输入真实姓名"/>
        <p class="p3"></p>
    </div>
    <div class="xingbie ml25 mt5">
     	<span >性　　别：</span>
        <input id="user_add_sex0" type="radio" class="sexadd" name="sex" value="0" checked="checked"/>
        <span class="span2">男</span>
        <input id="user_add_sex1" type="radio" class="sexadd" name="sex" value="1"/>
        <span class="span2">女</span>
    </div>
    <div class=" ml25 mt5">
    	<span>所属班级：</span>
        <select class="selects" name="classid" id="user_add_classid">
		<?php foreach($classlist as $cl){?>
	    	<option value="<?=$cl['classid']?>"><?=$cl['classname']?></option>
		<?php }?>
		</select>
    </div>
</div>

<script>
$('.readonly').keydown(function(e){
	if(e.keyCode == 8)
		return false;
});
$('.aresetpass').click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savepass();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogpass').exec('close');
			return false;
		}
	});
	if(!H.get('dialogpass')){
		H.create(new P({
			id : 'dialogpass',
			title: '重置密码',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogpass')[0],
			button:button
		}),'common');
	}
	var stuinfo = $(this).parent().find('.stuinfo');
	$('#pass_username').val(stuinfo.attr('username'));
	$('#pass_realname').val(stuinfo.attr('realname'));
	$('#pass_uid').val(stuinfo.attr('uid'));
	
	H.get('dialogpass').exec('show');
});

function savepass()
{
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}
	var password = $("#pass_password").val();
	var passconf = $("#pass_confirm").val();
	var uid = $('#pass_uid').val();
	if(password!=passconf)
		H.get('xtips').exec('setContent','两次密码输入不一致！').exec('show').exec('close',500);
	else if(password == ''){
		H.get('xtips').exec('setContent','未填密码,操作取消').exec('show').exec('close',500);
		H.get('dialogpass').exec('close');
	}
	else
	{
	H.get('xtips').exec('setContent','正在修改请稍候。。。').exec('show').exec('close',500);
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/lcyhstu/editpass')?>',
		dataType:'text',
		data:{'uid':uid,'password':password},
		success:function(data){
			if(data==1 || data=='1'){
				H.get('xtips').exec('setContent','密码修改成功').exec('show').exec('close',500);
				setTimeout(function(){
					location.reload();
				},500);
			}
			else
			{
				H.get('xtips').exec('setContent','密码修改失败！请使用6位以上密码').exec('show').exec('close',800);
			}
		}
	});
	}
}

$('.aedit').click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveedit();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogedit').exec('close');
			return false;
		}
	});
	if(!H.get('dialogedit')){
		H.create(new P({
			id : 'dialogedit',
			title: '编辑',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogedit')[0],
			button:button
		}),'common');
	}
	var stuinfo = $(this).parent().find('.stuinfo');
	$('#user_edit_username').val(stuinfo.attr('username'));
	$('#user_edit_realname').val(stuinfo.attr('realname'));
	$('#user_edit_uid').val(stuinfo.attr('uid'));
	$('#user_edit_sex'+stuinfo.attr('sex')).click();
	$('#user_edit_birthdate').val(formatdate(stuinfo.attr('birthdate')));
	$('#user_edit_email').val(stuinfo.attr('email'));
	$('#user_edit_mobile').val(stuinfo.attr('mobile'));
	$('#user_edit_classid').val(stuinfo.attr('classid'));
	$('#user_edit_oldclassid').val(stuinfo.attr('classid'));
	$('#user_edit_classname').val(stuinfo.attr('classname'));
	H.get('dialogedit').exec('show');
});

function closedialog(id){
	H.get('dialog'+id).exec('close');
}

function formatdate(unixtime) {
    var timestr = new Date(parseInt(unixtime) * 1000);
	var year = timestr.getFullYear();
	var month = timestr.getMonth()+1;
	var day = timestr.getDate();
	var datetime = year+'-'+month+'-'+day;
    return datetime;
}
function saveedit(){
	var uid = $('#user_edit_uid').val();
	var realname = $('#user_edit_realname').val();
	var sex = $('.sexedit:checked').val();
	var email = $('#user_edit_email').val();
	var mobile = $('#user_edit_mobile').val();
	var birthdate = $('#user_edit_birthdate').val();
	// return;
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/lcyhstu/edit')?>',
		dataType:'text',
		data:{'uid':uid,'realname':realname,'sex':sex,'email':email,'mobile':mobile,'birthdate':birthdate},
		success:function(data){
			dialogtip();
			if(data==1){
				H.get('xtips').exec('setContent','修改成功').exec('show').exec('close',500);
			}else{
				H.get('xtips').exec('setContent','修改失败').exec('show').exec('close',500);
			}
				
		}
	});
}
$('.adel').click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savedel();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除学生',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}
	var stuinfo = $(this).parent().find('.stuinfo');
	var classid = $(this).attr('data-classid');
	$('#del_uid').val(stuinfo.attr('uid'));
	$('#del_classid').val(classid);
	H.get('dialogdel').exec('show');
});

function savedel(){
	var uid = $('#del_uid').val();
	var classid = $('#del_classid').val();
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/lcyhstu/del')?>',
		dataType:'json',
		data:{'uid':uid,'classid':classid},
		success:function(_json){
			if(_json.code == 1){
				alert(_json.message);
				location.reload(true);
			}else{
				alert(_json.message);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

function addstudent(){
	var _xform = new xForm({
			domid:'dialogadd',
			errorcss:'cuotic',
			okcss:'zhengtic',
			showokmsg:false
		});
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveadd();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogadd').exec('close');
			return false;
		}
	});
	if(!H.get('dialogadd')){
		H.create(new P({
			id : 'dialogadd',
			title: '添加学生',
			easy:true,
			width:500,
			padding:5,
			content:$('#dialogadd')[0],
			button:button
		}),'common');
	}
	$('#user_add_classid').val(<?=$classid?>);
	H.get('dialogadd').exec('show');
}
var _bsname = false;
var _bpwd = true;
var _bnewpwd = true;
function saveadd(){
	checksname();
	if($($(".pwd_block")[0]).css("display") != 'none'){
		chknewpwd();
		chkconfirmnewpwd();
	}else{
		_bpwd = true;
		_bnewpwd = true;
	}
	if(!(_bsname && _bpwd && _bnewpwd)){
		return false;
	}
	var username = $('#user_add_username').val();
	var realname = $('#user_add_realname').val()=='请输入真实姓名'?'':$('#user_add_realname').val();
	var password = $('#user_add_password').val();
	var sex = $('.sexadd:checked').val();
	var classid = $('#user_add_classid').val();
	if(classid == ''|| classid == null){
		alert('如果没有班级,请先添加班级');
		return false;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/lcyhstu/add')?>',
		dataType:'text',
		data:{'username':username,'realname':realname,'sex':sex,'password':password,'classid':classid},
		success:function(data){
			dialogtip();
			if(data==1){
				H.get('xtips').exec('setContent','添加成功').exec('show').exec('close',500);
			}
				
		}
	});
}

function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
				location.reload(true);
			}
		}),'common');
	}
}

function checksname(){
	var username = $("#user_add_username").val();
	var classid = $('#user_add_classid').val();
	if(username == ''){
		$("#username_msg").attr('class','p3 emacuo');
		$("#username_msg").html("<font color='red'>学员帐号不能为空！</font>");
		_bsname = false;
	}else if(!username.match(/^[a-zA-Z][a-z0-9A-Z_]{5,17}$/)){
		$("#username_msg").attr('class','p3 emails');
		$("#username_msg").html("<font color='red'>6~18个字符，包括字母、数字、下划线，以字母开头！</font>");
		_bsname = false;
	}else{
		$.ajax({
			type:"post",
			url:"<?=geturl('aroomv2/lcyhstu/add')?>",
			dataType:'json',
			data:{'username':username,'classid':classid,'checkonly':1},
			async:false,
			success:function(_json){
				if(_json.code == 0){
					$("#username_msg").attr('class','p3 emacuo');
					$("#username_msg").html("<font color='red'>"+_json.message+"</font>");
					$(".pwd_block").hide();
					_bsname = false;
				}else if(_json.code == 2){
					$("#username_msg").attr('class','p3 emadui');
					$("#username_msg").html("<font color='green'>"+_json.message+"</font>");
					$(".pwd_block").show();
					_bsname = true;
					_bpwd = false;
					_bnewpwd = false;
				}else if(_json.code == 1){
					$("#username_msg").attr('class','p3 emadui');
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
	if($("#user_add_password").val() != '位数为6-16个字符，区分大小写'){
		if($("#user_add_password").val().length < 6 ){
			$("#pwd_msg").attr('class','p3 emacuo');
			$("#pwd_msg").html("<font color='red'>密码不能少于6位</font>");
			_bpwd = false;
		}else{
			$("#pwd_msg").attr('class','p3 emadui');
			$("#pwd_msg").html("<font color='green'>填写正确</font>");
			_bpwd = true;
		}
	}
}
function chkconfirmnewpwd(){
	var pwd = $("#user_add_password").val();
	var confirmpwd = $("#user_add_confirm").val();
	if(confirmpwd != '请再次输入账号密码，以便确认密码输入正确'){
		if(confirmpwd == ""){
			$("#confirmpwd_msg").attr('class','p3 emacuo');
			$("#confirmpwd_msg").html("<font color='red'>请输入确认密码！</font>");
			_bnewpwd = false;
		}else if(pwd != confirmpwd){
			$("#confirmpwd_msg").attr('class','p3 emacuo');
			$("#confirmpwd_msg").html("<font color='red'>两次密码输入不一致！</font>");
			_bnewpwd = false;
		}else{
			$("#confirmpwd_msg").attr('class','p3 emadui');
			$("#confirmpwd_msg").html("<font color='green'>两次输入一致</font>");
			_bnewpwd = true;
		}
	}
}

var _xform = new xForm({
	domid:'dialogpass',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});

</script>
</body>
</html>
