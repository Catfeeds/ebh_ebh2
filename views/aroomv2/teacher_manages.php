<?php
$this->display('aroomv2/page_header');
?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/teacher.html">教师管理</a> > 教师管理
    </div>
    <div class="jiaoshiguanli">
		 <div class="diles diles-1">
			<input type="text" id="searchkey" value="<?=empty($q)?'请输入教师账号或姓名':$q?>" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入教师账号或姓名')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入教师账号或姓名');$(this).css('color','#999')}"/>
			<input type="button" class="soulico" onclick="_search()">
		</div>
		<div class="jiaoshiguanli_top fr">
        	<ul>
            	<li class="fl "><a href="javascript:;" class="cjmt13" onclick="addteacher();">添加教师</a></li>
                <li class="fl ml20"><a href="/aroomv2/manage/input.html" class="cjmt13" >批量导入</a></li>
            </ul>
        </div>
		<div class="clear"></div>
        <div class="jiaoshiguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr bgcolor="#f1f1f1" class="first">
                	<td width="214" colspan="2">账号</td>
                    
                    <td width="58">性别</td>
                    <td width="140">联系方式</td>
                    <td width="264">操作</td>
                </tr>
				
			<?php if(!empty($roomteacherlist)){
				foreach($roomteacherlist as $value){?>
                <tr>
				<?php 
					if(!empty($value['face']))
						$face = getthumb($value['face'],'50_50');
					else{
						if($value['sex']==1){
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
						}else{
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
						}
					
						$face = getthumb($defaulturl,'50_50');
					} 
				?>	         
                	<td width="50" style="padding-left:10px;"><img src="<?= $face?>"></td>
					<td width="214"><span><?=$value['username']?></span><br/><span><?=$value['realname']?></span><br/><p class="jifenico" style="color:#9e9ea0 !important;"><?=$value['credit']?></p></td>

                    <td width="58"><?=$value['sex']==1?'女':'男'?></td>
                    <td width="140"><?=$value['mobile']?></td>
                    <td width="264">
                    	<a target="_blank" href="/aroom/umanager/teacher.html?s=<?=urlencode(authcode($value['uid'],'ENCODE'))?>" class="backstage">进入老师首页</a>
					<?php if($room['uid'] != $value['uid']){?>
                        <a href="javascript:;" onclick="editstudentpass('<?=$value['uid']?>','<?=$value['username']?>');">密码重置</a>
                        <a target="mainFrame" href="/teacher/setting/rprofile/<?=$value['teacherid']?>.html">编辑</a>
                        <a href="javascript:showdelgroup(<?=$value['teacherid']?>);">删除</a>
					<?php }?>
                    </td>
                </tr>
			<?php }}else{?>
				<tr><td colspan="5" align="center">暂无记录</td></tr>
			<?php }?>
            </table>
        </div>
    </div>
   <?= $pagestr?>


<!--添加教师-->
	<!--<div id="addthdiv" class="editstudents" style="height:365px; display:none;">-->
	<div id="addthdiv" class="editstudents" style="height:265px; display:none;">
		<div id="etname" class="  mt10 height ">
			<span>教师账号：</span>
			<input name="tname" id="tname" class="text input" type="text"  value="" x_hit="请输入教师账号"/>
			<p id="tname_msg" style="width:inherit;margin-left:75px; font-size:12px;width:280px;"></p>
		 </div>

		<div id="onlytname" class="  mt10 height " style="display:none">
			<span>教师账号：</span>
			<input name="utname" id="utname" class="text input readonly" type="text"  value="" readonly="readonly"/>
			<p id="tname_msg" style="width:auto;margin-left:75px;"></p>
		 </div>

		<div class='clear'></div>


		<div id="hid">
			<div id="hidpwd">
				 <div class=" height ">
					<span>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</span>
					<input name="pwd" id="pwd" class="text input" type="password"  value="" x_hit="位数为6-16个字符，区分大小写"/>
					<p id="pwd_msg" style="margin-left:75px;"></p>
				 </div>
				 <div class=" mt5 height">
					<span>确认密码：</span>
					<input name="confirmpwd" id="confirmpwd" class="text input" type="password"  value="" x_hit="请再次输入账号密码，以便确认密码输入正确">
					<p id="confirmpwd_msg" style="margin-left:75px;"></p>
				 </div>
			</div>
		 <div class=" height ">
			<span>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</span>
			<input name="realname" id="realname" class="text input" type="text"  value="" x_hit="请输入老师真实姓名"/>
			<p id="realname_msg" style="margin-left:75px;"></p>
		 </div>
		 <div id="hidsex">
			 <div class="xingbie height">
				<span >性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</span>
				<input id="user_add_sex0" class="sexadd" type="radio" checked="checked" value="0" name="sex">
				<span class="span2">男</span>
				<input id="user_add_sex1" class="sexadd" type="radio" value="1" name="sex">
				<span class="span2">女</span>
			 </div>
		 </div>
		 <div id="chedkedsex">
		  <div class="xingbie height">
				<span >性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</span>
				<input id="user_edit_sex0" class="sexadd" type="radio" value="0" name="sex">
				<span class="span2">男</span>
				<input id="user_edit_sex1" class="sexadd" type="radio" value="1" name="sex">
				<span class="span2">女</span>
			</div>
		 </div>
		 
		 <!--<div class=" height ">
			<span>联系方式：</span>
			<input name="mobile" id="mobile" class="text input" type="text"  value="" x_hit="请输入老师的联系方式"/>-->
			<!--<p id="mobile_msg" style="margin-left:75px;"></p>-->
		 <!--</div>-->
		 
	</div>


<!--删除教师-->
<div id="delteacher" class="tanchukuang" style="display:none;height:130px;">
    <div class="tishi"><span>你确定要删除该教师吗？</span></div>
</div>

<!--密码重置-->
<div id="updatepassdiv" class="tanchukuang" style="display:none;height:130px;">
    <div class=" mt15">
    	<span>登陆账号：</span>
        <input id="username"  readonly="readonly" class="text" type="text" value="" style="color:#cdcdcd"/>
		<input id="uid" type="hidden"  value=""/>
     </div>
     <div class="resetting"  >
    	<span>重置密码：</span>
        <input id="password" class="text" type="password"  value="" x_hit="请输入密码" />
     </div>
     <div class="resetting1" >
    	<span>确认密码：</span>
        <input id="passconf" class="text" type="password"  value="" x_hit="请输入确认密码" />
     </div>
</div>

</body>
</html>
 <script type="text/javascript">
 <!--

 function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入教师账号或姓名')
		searchkey = '';
	location.href = '/aroomv2/teacher/manages.html?q='+searchkey;
}

 $('.readonly').keydown(function(e){
	if(e.keyCode == 8)
		return false;
});
 //添加教师
	function addteacher(){
		$("#utname").val("");
		$("#realname").val("");
//		$("#mobile").val("");
		$("#chedkedsex").hide();
		var _xform = new xForm({
			domid:'addthdiv',
			errorcss:'cuotic',
			okcss:'zhengtic',
			showokmsg:false
		});
		var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				add_teacher();
				//H.get('addthdiv').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('addthdiv').exec('close');
				return true;
			}
		});

		if(!H.get('addthdiv')){
			H.create(new P({
				id : 'addthdiv',
				title: '添加教师',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#addthdiv')[0]
			},{
				onclose:function(){
					location.reload();
				}
			}),'common').exec('show');
			
		}else{
			H.get('addthdiv').exec('show');
		}
				
}


var _bname = false;
var _bpwd = true;
var _bcpwd = true;
var _rname = false;
var _mobile = false;
$(function(){
	$("#tname").blur(function(){
		checktname('tname');
	});
//	$(".jiance").click(function(){
//		checktname('tname');
//	});
	$("#pwd").blur(function(){
		checkpwd(this);
	});
	$("#confirmpwd").blur(function(){
		checkcpwd(this);
	});
	$("#realname").blur(function(){
		checktrealname();
	});
//	$("#mobile").blur(function(){
//		checkmobile();
//	});
});


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
	var _value = ($("#realname").val()=='请输入老师真实姓名')?'':$("#realname").val();
	//var _value = $.trim(HTMLDeCode($("#realname").val()));
	//var _value = _value.replace(/(^\s+)|(\s+$)/g,"");
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
					$("#hid").show();
					top.resetmain();
					_bname = true;
					_bpwd = false;
					_bcpwd = false;
				}else if(_json.code == 2){
					$("#tname_msg").attr('class','emacuo');
					$("#tname_msg").html('<font color="red">'+_json.message+'</font>');
					$("#hid").hide();
					top.resetmain();
					_bname = false;
					_bpwd = false;
					_bcpwd = false;
				}else{
					$("#tname_msg").attr('class','emadui');
					$("#tname_msg").html('');
					$("#hid").hide();
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


function add_teacher(){
	checktname("tname");	
	if($("#hid").css("display") != 'none'){
		checkpwd("pwd");
		checkcpwd("confirmpwd");
	}
	checktrealname();
//checkmobile(); 
	var value = $("#tname").val();
	var sex = $("input[name='sex']:checked").val();
	var uid = <?= $room['uid']?>;
	var pwd = $("#pwd").val();
	var realname = $("#realname").val();
	var mobile = ( $("#mobile").val()=='请输入老师的联系方式')?'': $("#mobile").val();
	//if(_bname && _bpwd && _bcpwd && _rname){
			if($("#hid").css("display") != 'none'){
				if(_bname && _bpwd && _bcpwd && _rname){
					$.ajax({
						type:'post',
						url:'<?=geturl('aroomv2/teacher/add')?>',
						dataType:'json',
						data:{'uid':uid,'tname':value,'pwd':pwd,'sex':sex,'realname':realname,'mobile':mobile},
						success:function(data){
							 
							if(data.code == 1) {
							  $.showmessage({
								img : 'success',
								message:'添加教师成功',
								title:'添加教师',
								callback :function(){
								  document.location.reload();
								}
							  });
							} else {
							  $.showmessage({
								img : 'error',
								message:'添加教师失败，请稍后再试<br />',
								title:'添加教师'
							  });
							}
						}
					});
				}
			}else{
				$.ajax({
					type:'post',
					url:'<?=geturl('aroomv2/teacher/add')?>',
					dataType:'json',
					data:{'tname':value,'checkonly':""},
					success:function(data){
						 
						if(data.code == 1) {
						  $.showmessage({
							img : 'success',
							message:'添加教师成功',
							title:'添加教师',
							callback :function(){
							   document.location.href = location.href;
							}
						  });
						} else {
						  $.showmessage({
							img : 'error',
							message:'添加教师失败，请稍后再试<br />',
							title:'添加教师'
						  });
						}
					}
				});
			}
		
	//}
	
}

$(function(){
	$("#realname").blur(function(){
		checktrealname();
	});
});

//修改密码
function editstudentpass(uid,username){
	
	var _xform = new xForm({
		domid:'updatepassdiv',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});
	var button = new xButton();
		button.add({
			value:"确定",
			callback:function(){
				savepass(uid);
			//	H.get('updatepassdiv').exec('close');
				return false;
			},
			autofocus:true
		});

		button.add({
			value:"取消",
			callback:function(){
				// location.reload();
				H.get('updatepassdiv').exec('close');
				$("#username").val("");
				return false;
			}
		});

		if(!H.get('updatepassdiv')){
			H.create(new P({
				id : 'updatepassdiv',
				title: '密码重置',
				easy:true,
				width:420,
				padding:5,
				button:button,
				content:$('#updatepassdiv')[0]
			}),'common').exec('show');
			$("#username").val(username);
		}else{
			H.get('updatepassdiv').exec('show');			 
			$("#username").val(username);
		}
		
	}

function savepass(uid)
{
	var password = $("#password").val();
	var passconf = $("#passconf").val();
	if(password!=passconf)
		$.showmessage({message:'两次密码输入不一致！'});
	else
	{
		if(password == ''){
			$.showmessage({message:'密码未修改'});
			//$("#dialog").dialog('close');
		}
		else
		$.ajax({
			type:'post',
			url:'<?=geturl('aroomv2/teacher/editpass')?>',
			dataType:'text',
			data:{'uid':uid,'password':password},
			success:function(data){
			// alert(data)
				if(data==1 || data=='1'){
					$.showmessage({message:'密码修改成功！',timeoutspeed:1000,callback:function(){document.location.href = document.location.href;}});
					
				}
				else
				{
					$.showmessage({message:'密码修改失败,请刷新页面重试！'});
				}
			}
		});
	}
}



//删除
function showdelgroup(teacherid){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			delteach(teacherid);
			H.get('delteacher').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('delteacher').exec('close');
			return false;
		}
	});

	if(!H.get('delteacher')){
		H.create(new P({
			id : 'delteacher',
			title: '删除教师',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#delteacher')[0]
		}),'common').exec('show');
		
	}else{
		H.get('delteacher').exec('show');
	}


}

function delteach(teacherid){

	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/teacher/deleteroomteacher')?>',
		dataType:'text',
		data:{'tid':teacherid},
		success:function(res){
			if(res){
				 $.showmessage({
						img : 'success',
						message:'教师删除成功',
						title:'删除教师',
						callback :function(){
							 document.location.reload();
						}
					});
			}else{
				$.showmessage({
						img : 'error',
						message:'删除失败，请稍后再试或联系管理员。',
						title:'删除教师'
					});
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

 //-->
 </script>