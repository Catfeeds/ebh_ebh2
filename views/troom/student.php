<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
					<div class="ter_tit">
						当前位置 > <a href="<?= geturl('troom/student') ?>">学员管理</a> > 所有学员
					</div>
					<div class="lefrig">
		<div id='uppass' style="display: none;">
				<div id="layer">
					<form id="upform" name="upform" action="" method="post">
						<div class="layer_body">
							<input type="hidden" value="teacher" name="action" />
							<input type="hidden" value="update" name="op" />
							<input type="hidden" name="type" value="upmemberpass" />
							<input type="hidden" id="rmemberid" name="rmemberid" />
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<th><span style="margin-left:60px;">学员帐号：&nbsp;&nbsp;&nbsp;</span></th>
									<td><label id="cname"></label></td>
								</tr>
								<tr>
							    	<th><span class="star"></span>&nbsp;新　密码：</th>
								    <td>
										<input class="uipt w135" type="password" id="newpwd" name="newpwd" onblur="chknewpwd(this.value)" maxlength="18" />
										<em class="error" id="newpwd1"></em>
									</td>
							  	</tr>
							  	<tr>
							  		<th></th>
							  		<td><span id="newpasstip" class="ts2">密码长度为6-18位，建议英文和数字组合。</span></td>
							  	</tr>
							  	<tr>
							    	<th><span class="star"></span>&nbsp;确认密码：</th>
							    	<td>
							    		<input class="uipt w135" type="password" id="confirmnewpwd" name="confirmnewpwd" onblur="chkconfirmnewpwd(this.value)" maxlength="18" />
							    		<em class="error" id="confirmnewpwd1"></em>
							    	</td>
							  	</tr>
							  	<tr>
							  		<th></th>
							  		<td><span id="newpassstip" class="ts2">再次输入您的新密码。</span></td>
							  	</tr>
								
							</table>
						</div>
					</form>
				</div>
		</div>
		<div id="addtime" style="display: none;background-color: #E7F4FC;">
				<div id="layer">
					<form id="addusertime" name="addusertime"  method="post">
						<div class="layer_body">
							<input type="hidden" name="t" id="t" value="" />
							<input type="hidden" value="teacher" name="action" />
							<input type="hidden" value="add" name="op" />
							<input type="hidden" name="type" value="addusertime" />
							<input type="hidden" id="mid" name="mid" />
							<input type="hidden" id="crid" name="crid" value="$crid" />
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="height:26px;">
									<th style="text-align: right; padding-right:10px;">&nbsp;&nbsp;学员帐号：</th>
									<td><label id="uname"></label></td>
								</tr>
								<tr style="height:26px;">
							    	<th style="text-align: right; padding-right: 10px; width: 145px;">&nbsp;&nbsp;添加时间：</th>
								    <td><label>1年</label></td>
							  	</tr>
							</table>
							<p style="color: red; text-align: center; margin-top: 20px;"> 你是否要把<label id="usname"></label>到期时间修改成<label id="utime"></label></p>
						</div>
					</form>
				</div>
		</div>
		
		<div class="annotate"> 在此页面中,教师可对申请加入您教室的学员进行管理。</div>

		<div class="work_menuss">
			<ul>
				<li class="workcurrent" style="margin-left:45px;"><a href="<?= geturl('troom/student') ?>"><span>所有学员</span></a></li>
				<li ><a href="<?= geturl('troom/student/check') ?>"><span>学员审核</span></a></li>
				<li ><a href="<?= geturl('troom/student/opencount') ?>"><span>开通统计</span></a></li>
				<li></li>				
			</ul>
		</div>
		<div class="annuato">
		<span style="float:left;line-height:23px;">关键字：</span>
		<input type="text" name="search" value="<?= $q ?>" id="searchvalue" style="width:350px;" class="shurulan">
		<input class="souhuang" id="searchbutton" type="button" name="searchbutton" value="搜 索" />
				<div class="tiezitool">
					<a class="hongbtn jiabgbtn" href="<?= geturl('troom/student/add')?>">添加学员</a>
				</div>
		</div>
			
		
			<table width="100%" class="datatab">
				<thead class="tabhead">
					<tr>
						<th width="15%">帐号</th>
						<th width="10%">姓名</th>
						<th width="10%">开通时间</th>
						<th width="10%">到期时间</th>
						<th width="%">联系方式</th>
						<th width="%">状态</th>
						<th width="%" colspan="2">修改操作</th>
					</tr>
				</thead>
				<tbody>
				
                                <?php if(!empty($students)) { ?>
                                <?php foreach($students as $student) { ?>
		
			  	<tr>
			  <?php
                          $style = 'style="color:#a7a7a7;"';
                          if($student['cstatus'] == 1 && ( $student['enddate']>SYSTIME || empty($student['enddate'])))
                              $style = '';
                          ?>
                            <td width=""><a href="<?= geturl('troom/student/'.$student['uid'])?>" <?= $style ?> ><?= $student['username'] ?></a></td>
                            <td <?= $style ?> width=""><span style="width:60px;float: left;word-wrap: break-word;"><?= $student['realname'] ?></span></td>
                            <td width="" <?= $style ?>><?= empty($student['begindate']) ? '' : date('Y-m-d',$student['begindate']) ?></td>
                            <td <?= $style ?> width=""><?= empty($student['enddate']) ? '' : date('Y-m-d',$student['enddate']) ?></td>
                            <td <?= $style ?> width=""><?= $student['mobile'] ?></br><?= ssubstrch($student['email'],0,18) ?></td>
			    <td width="">
			    	
                                <?php if($student['enddate']< SYSTIME && !empty($student['enddate'])) { ?>
		    			<font color="#a7a7a7">已过期</font>
	    	
                                <?php } else if($student['cstatus'] ==0) { ?>
                                <font color="#a7a7a7">已锁定</font>
                                <?php } else if (empty($student['enddate'])) { ?>
                                <font color="#008000">无限制</font>
                                <?php } else { ?>
                                <font color="#008000">正常</font>
                                <?php } ?>
			    </td>
			    <td width="" style="padding-right:0;">
					<a class="previewBtn" href="javascript:void(0);" onclick="uppassword(<?= $student['uid'] ?>,'<?= empty($student['realname']) ? $student['username']:$student['realname'] ?>');">修改密码</a>
			    	<a class="btnjia" href="javascript:void(0);" onclick="addutime(<?= $student['uid'] ?>,'<?= empty($student['realname']) ? $student['username']:$student['realname'] ?>','<?= (!empty($student['enddate']))?date('Y-m-d',strtotime('+1 years',$student['enddate'])):''?>');" >添加时间</a>
    			
                                <a class="btnsuo" href="javascript:change_status(<?= $student['uid'] ?>,<?= $student['cstatus'] ?>)"><?php if($student['cstatus']==1) { ?>锁定<?php } else { ?>解锁<?php } ?></a>
			    	<a style="margin:0;" class="btnshan" href="javascript:;" onclick="delcfm('<?= empty($student['realname']) ? $student['username']:$student['realname'] ?>',<?= $student['uid'] ?>)">删除</a>
			    </td>
			  </tr>
			 
                                <?php } ?>
		
                                <?php } else { ?>
			  <tr><td colspan="9" align="center">暂 无 数 据</td></tr>
                                <?php } ?>
	
			  </tbody>
			</table>
		<div style="margin-top:20px;"><?= $pagestr ?></div>
		</div>
<script type="text/javascript">
function delcfm(name,memberid) {
    $.confirm("确认要删除此教室下的该学员("+name+")吗？",function(){
        var url="<?= geturl('troom/student/upinfo') ?>"
    	$.ajax({
		type:"post",
		url:url,
		data:{'memid':memberid,'type':'del'},
		dataType:"json",
		success:function(data){
			if(data != undefined && data.status == 1){
				window.location.reload();
			}else{
				return false;
			}
		}
	});
    });
}
function change_status(memberid,status)
{
	var _url = "<?= geturl('troom/student/upinfo')?>";
	if(status == 0){
		status = 1;
	}else{
		status = 0;
	}
	$.ajax({
		type:"post",
		url:_url,
		data:{'memid':memberid,'status':status},
		dataType:"json",
		success:function(data){
			if(data != undefined && data.status == 1){
				window.location.reload();
			}else{
				return false;
			}
		}
	});
}

function uppassword(uid,cname)
{
	H.get('uppass').exec('show');
	$('#cname').text(cname);
	$('#rmemberid').val(uid);
}

function addutime(uid,uname,utime){
	
	$('#uname').text(uname);
	$('#usname').text(uname);
	$('#mid').val(uid);
	
	if(utime!=''){
		$('#utime').text(utime);
	}else{
		var date = new Date();
		var year = date.getFullYear();
		var month = date.getMonth()+1; 
		var date1 = date.getDate(); 
		var endtime = year+1+'-'+month+'-'+date1;
		$('#utime').text(endtime);
	}
	H.get('addtime').exec('show');
}

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

var _bsname = false;
var _bpwd = true;
var _bnewpwd = true;
var searchtext = "请输入学员帐号";
$(function(){
    initsearch("searchvalue",searchtext);

	$("#pwd").blur(function(){
		checkpwd(this);
	});
	$("#newpwd").blur(function(){
		checknewpwd(this);
	});

        
        $('#searchbutton').click(function(){
		var url = '<?= geturl('troom/student')?>';
                
		var searchvalue = $("#searchvalue").val();
		if(searchvalue=='请输入学员帐号'){
			searchvalue='';
		}
                url += '?q='+searchvalue;
		location.href = url;
	});

        var button = new xButton();
        button.add({
        	value:'确定',
        	calback:function(){
        		if(submit_check()) {
                     var url = '<?= geturl('troom/student/upinfo') ?>';
                     var memid = $('#rmemberid').val();
                     var newpwd = $("#newpwd").val();
                     var confirmnewpwd = $("#confirmnewpwd").val();
                     $.ajax({
                         url:url,
                        type: "POST",
                        data:{'memid':memid,'newpwd':newpwd,'confirmnewpwd':confirmnewpwd},
                        dataType:"json",
                        success:function(data) {
                            if(data != undefined && data.status == 1) {
                                alert("密码修改成功");
                                H.get('uppass').exec('close');
                            }
                        }
                     });
                }
        		return false;
        	},
        	autofocus:true
        });
        button.add({
        	value:'取消',
        	callback:function(){
        		H.get('uppass').exec('close');
        		$("#newpwd").val('');
        		$("#confirmnewpwd").val('');
        		$("#newpwd1").html('');
        		$("#confirmnewpwd1").html('');
        	}
        });
     
    H.create(new P({
    	id:'uppass',
    	content:$("#uppass")[0],
    	button:button,
    	title:'修改学员密码',
		easy:true,
		padding:5
    }),'common');

    var button2 = new xButton();
    button2.add({
    	value:'确定',
    	callback:function(){
    		 var url = '<?= geturl('troom/student/upinfo') ?>';
             var memid = $('#mid').val();
             $.ajax({
                 url:url,
                type: "POST",
                data:{'memid':memid,'type':'addtime'},
                dataType:"json",
                success:function(data) {
                    if(data != undefined && data.status == 1) {
                        alert("添加时间成功");
                        document.location.reload();
                    }
                }
             });
             return false;
    	},
    	autofocus:true
    });
    button2.add({
    	value:'取消',
    	callback:function(){
    		H.get('addtime').exec('close');
    		return false;
    	}
    });
    H.create(new P({
    	id:'addtime',
    	title:'添加学员时间',
    	content:$('#addtime')[0],
    	width: 300,
		button:button2,
		easy:true,
		padding:5
    }),'common');

	$("#addressinfo").blur(function(){
		checkaddress();
	});
});

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

</script>
<?php $this->display('troom/page_footer'); ?>