<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troomv2/teacher') ?>">教师管理</a> > 添加老师
</div>
<div class="lefrig">
<div class="annotate">请输入要加入本教室的教师账号,如该账号不存在,请输入该账号密码,同时请为该教师分配操作权限和授权范围。</div>

  <SCRIPT LANGUAGE="JavaScript">
  
  <!--
	function loadReady() {
		var h = demoIframe.contents().find("body").height();
		if (h < 600) h = 600;
		demoIframe.height(h);
	}

  //-->
  </SCRIPT>
		<form id="addform">
		<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<th><label>教师账号：</label></th>
			<td><input class="uipt w340" name="tname" id="tname" type="text" /><span class="ts2" id="tname_msg"></span>
			</td>
		  </tr>
		   <tr class="block_pwd" style="display:none;">
			<th><label>密码：</label></th>
			<td>
				<input class="uipt w340" id="pwd" name="pwd" maxlength="18" type="password" />
				<span id="pwd_msg"></span>
			</td>
		  </tr>
		  <tr class="block_pwd" style="display:none;">
		  	<th><label>确认密码：</label></th>
		  	<td>
		  		<input class="uipt w340" id="confirmpwd" name="confirmpwd" maxlength="18" type="password" />
		  		<span id="confirmpwd_msg"></span>
		  	</td>
		  </tr>
		  <tr class="block_pwd" style="display:none;">
			<th><label>教师姓名：</label></th>
			<td><input class="uipt w340" name="realname" id="realame" type="text" /><span class="ts2" id="realname_msg"></span>
			</td>
		  </tr>
		  <tr>
			<th><label>教师权限：</label></th>
			<td>
			
		
                                <?php foreach ($modulelist as $module) { ?>
				
				<label><input type="checkbox" name="module[]" value="<?= $module['catid']?>" style="margin-top:2px;*margin-top:-2px;float:left;" /><span style="float:left;margin-left:2px;"><?= $module['name']?></span></label>
                                <?php } ?>
			</td>
		  </tr>
		  <tr>
			<th><label>授权范围：</label></th>
			<td>
				<div class="fenzu">
                                    <ul id="tree1" class="tree" style="width:356px; _height:293px; min-height:293px; overflow:auto; overflow-y:hidden; padding-bottom:15px;">
                                        <?php foreach($folders as $folder) { ?>
                                        <li style="float:left;width:320px;line-height: 28px;font-size: 14px;"><input type="checkbox" id="folderid_<?= $folder['folderid']?>" name="folder[]" value="<?= $folder['folderid']?>" style="margin-top:7px;*margin-top:3px;float:left;margin-left: 5px;"><span style="float:left;margin-left:2px;width:300px;"><label for="folderid_<?= $folder['folderid']?>" style="width:290px;"><?= $folder['foldername'] ?></label></span></li>
                                        <?php } ?>
                                    </ul>
				</div>							
			</td>
			
		  </tr>
		  <tr>
		  <td></td>
		  	<td>
		  	<input class="lanbtn" type="button" value="保 存" style="cursor:pointer;" name="addteacher">
		 	<input class="huibtn marlef" type="button" onclick="window.history.back(-1);" value="取 消" />
		  	</td>
		  </tr>
		 </table>
		</form>

<script type="text/javascript">
var _bname = false;
var _bpwd = true;
var _bcpwd = true;
$(function(){
	$("#tname").blur(function(){
		checktname(this);
	});
	$("#realname").blur(function(){
		checktrealname(this);
	});
	$("#pwd").blur(function(){
		checkpwd(this);
	});
	$("#confirmpwd").blur(function(){
		checkcpwd(this);
	});
        $(".lanbtn").click(function(){
           if(add_new()) {
               var url = "<?= geturl('troomv2/teacher/add') ?>";
		$.ajax({
			type:'post',
			url:url,
			dataType:'json',
			data:$("#addform").serialize(),
			success:function(data){
                            if(data != null && data != undefined && data.status == 1) {
                                $.showmessage({
                                   img : 'success',
                                   message:'教师添加成功',
                                   title:'添加教师',
                                   callback :function(){
                                        document.location.href = "<?= geturl('troomv2/teacher') ?>";
                                   }
                               });
                           } else {
                           var message = "教师添加失败，请稍后再试或联系管理员。";
                           if(data != null && data != undefined && data.message == undefined)
                            message = data.message;
                               $.showmessage({
                                   img : 'error',
                                   message:message,
                                   title:'添加教师'
                               });
                           }
                        }
                });
           } 
        });
});

function checktname(_this){
	var _value = '';
	if(typeof(_this) == 'object'){
		_value = $(_this).val();
	}else{
		_value = $("#"+_this).val();
	}
	if(_value == ''){
		$("#tname_msg").html('<font color="red">教师账号不能为空</font>');
		_bname = false;
	}else if(!_value.match(/^[a-zA-Z][a-z0-9A-Z_]{5,15}$/)){
		$("#tname_msg").html('<font color="red">6~16个字符，包括字母、数字、下划线，以字母开头</font>');
		_bname = false;
	}else{
	//	alert('#getsitecpurl()#?action=teacher&op=teacheraddteacher&inajax=1');
                var url = "<?= geturl('troomv2/teacher/checkname') ?>";
		$.ajax({
			type:'post',
			url:url,
			dataType:'json',
			data:{'sname':_value},
			async:false,
			success:function(_json){
				if(_json.code == 1){
					$("#tname_msg").html('<font color="green">'+_json.message+'</font>');
					$(".block_pwd").show();
					top.resetmain();
					_bname = true;
					_rname = true;
					_bpwd = false;
					_bcpwd = false;
				}else if(_json.code == 2){
					$("#tname_msg").html('<font color="red">'+_json.message+'</font>');
					$(".block_pwd").hide();
					top.resetmain();
					_bname = false;
					_rname = false;
					_bpwd = false;
					_bcpwd = false;
				}else{
					$("#tname_msg").html('');
					$(".block_pwd").hide();
					top.resetmain();
					_bname = true;
					_rname = true;
					_bpwd = true;
					_bcpwd = true;
				}
			},
			error:function(){
				$("#tname_msg").html('<font color="red">服务器请求出错了,请稍后重试</font>');
				_bname = false;
			}
//			error：function (XMLHttpRequest, textStatus, errorThrown){
//				alert(XMLHttpRequest);
//				alert(textStatus);
//				alert(errorThrown);
//			}
			
		});
	}
}
function checktrealname(_this){
	var _value = '';
	if(typeof(_this) == 'object'){
		_value = $(_this).val();
	}else{
		_value = $("#"+_this).val();
	}
	if(_value == ''){
		$("#realname_msg").html('<font color="red">教师姓名不能为空</font>');
		_rname = false;
	} else {
		_rname = true;
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
		$("#pwd_msg").html("<font color='red'>密码不能少于6位</font>");
		_bpwd = false;
	}else{
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
		$("#confirmpwd_msg").html("<font color='red'>请确认密码</font>");
		_bcpwd = false;
	}else if(_value != $("#pwd").val()){
		$("#confirmpwd_msg").html("<font color='red'>两次密码不同，请重新确认</font>");
		_bcpwd = false;
	}else{
		$("#confirmpwd_msg").html("");
		_bcpwd = true;
	}
}

function add_new(){
	checktname("tname");
	checktrealname("realname");
	if($($(".block_pwd")[0]).css("display") != 'none'){
		checkpwd("pwd");
		checkcpwd("confirmpwd");
	}
	if(!(_bname &&_rname && _bpwd && _bcpwd)){
		return false;
	}
        return true;
}
</script>

<?php $this->display('troomv2/page_footer'); ?>