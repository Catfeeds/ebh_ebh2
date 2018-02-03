<?php $this->display('aroomv2/page_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<body>
<div >
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/classes/student')?>">班级学生</a> > 学生管理
    </div>
    <div class="xueshengguanli">
    	<div class="xueshengguanli2_top fr">
            <ul>
                <li class="fl "><a href="javascript:addlcyhgstu()">添加学生</a></li>
                <li class="fl ml20"><a href="/aroomv2/lcyhstu/input.html">批量导入</a></li>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="diles">
			<input type="text" id="searchkey" value="<?=empty($q)?'请输入学生账号或姓名':$q?>" id="search" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入学生账号或姓名')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入学生账号或姓名');$(this).css('color','#999')}"/>
			<input type="button" class="soulico" onclick="_search()">
		</div>
        <div class="clear"></div>
        <div class="xueshengguanli_bottom mt10">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr  class="first">
                	<td width="132">班级名称</td>
                    <td width="75">班级人数</td>
                    <td width="449">任教老师</td>
                    <td width="82">学生管理</td>
                </tr>
				<?php $rurl = $this->uri->path;
				foreach($classlist as $class){?>
                <tr >
                	<td width="132" ><b><p style="width:130px;word-wrap: break-word;float:left;"><?=$class['classname']?></p></b></td>
                    <td width="75"><?=$class['stunum']?></td>
                    <td width="449"><p style="width:430px;word-wrap: break-word;float:left;"><?php if(!empty($class['teachers']))echo $class['teachers']?></p></td>
                    <td width="82"><a href="<?=geturl('aroomv2/lcyhstu/list_view').'?classid='.$class['classid'].'&rurl='.$rurl?>">学生管理</a></td>
                </tr>
				<?php }?>
                
            </table>
            <?=$pagestr?>
        </div>
    </div>
    
	
</div>

<!--添加学生-->
<div id="dialogadd" style="display:none">
<div class="editstudents" style="height:260px;">
<!--
	<div class="title2"><p>添加学生</p></div>
	-->
    <div class=" ml25 mt10">
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
	
    <div class=" ml25 mt5">
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
</body>
<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入学生账号或姓名')
		searchkey = '';
	location.href = '/aroomv2/lcyhstu/list_view.html?classid=0&rurl=<?=$rurl?>&q='+searchkey;
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
	H.get('dialogadd').exec('show');
}
//绿城育华添加学习
function addlcyhgstu(){
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
			savelcyhgadd();
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
	if(classid == '' || classid == null){
		alert('如果没有班级,请先添加班级');
		return false;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/student/add')?>',
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
//绿城育华添加学习
function savelcyhgadd(){
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
	if(classid == '' || classid == null){
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
			data:{'username':username,classid:classid,'checkonly':1},
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
					$(".pwd_block").show();
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
</script>
</html>
