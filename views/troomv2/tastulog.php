<?php $this->display('troomv2/page_header'); ?>
<style>
#icategory {
    background: #fff;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	font-size:14px;
}
#icategory dt {
    float: left;
    line-height: 25px;
    padding-right: 5px;
    text-align: left;
	color:#999;
}
#icategory dd {
    float: left;
    width: 845px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: #fff;
	color: #333;
	text-decoration: none;
	display:block;
	padding:2px;
}
.category_cont1 div a {
    color: #333;
    text-decoration: none;
    padding: 2px;
	display:block;
	font-size:13px;
}
.category_cont1 div a.curr, .category_cont1 div a:hover {
    background: #fff none repeat scroll 0 0;
    color: #5e98f9;
    text-decoration: none;
	padding:2px;
	font-size:13px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
	padding:0 10px;
	white-space: nowrap;
	display:block;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
.tabhead th{
	border-bottom:1px solid #eee;
	font-weight:normal;
}
.ghjut{
	width:170px;
	margin:0 0 0 10px;
}
.esukangs {
	height: 55px;
}
</style>
<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
<?php $room_type = Ebh::app()->room->getRoomType();$room_type = ($room_type == 'com') ? 1 : 0;?>
<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="<?= ($room_type==1)?'员工监察':'学生监察'?>"><?= $room_type==1?'员工监察':'学生监察'?></a>
<!-- <a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a> -->
</div>
</div>
	<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?= ($room_type==1)?'员工监察':'学生监察'?></span></a></li>
			</ul>
		</div>
		<div class="diles">
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="title" <?=$stylestr?> class="newsou" id="search" value="<?=$q?>" type="text" />
			<input name="searchbutton" id="searchbutton" type="button" class="soulico" value="">
		</div>
	</div>

<div id="icategory" class="clearfix" style="border:none;">
	<dt><?= ($room_type==1)?'所属部门：':'所属班级：'?></dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?= empty($classid) ? 'class="curr"':''?> href="<?= geturl('troomv2/tastulog') ?>"><?=($room_type==1) ? "所有员工":"所有学生"?></a>
			</div>
	
                        <?php foreach ($classlist as $myclass) { ?>
			<div>
				<a <?= ($myclass['classid'] == $classid)? 'class="curr"':''?> href="<?= geturl('troomv2/tastulog-0-0-0-'.$myclass['classid'])?>"><?= $myclass['classname'] ?></a>
			</div>
                        <?php } ?>

		</div>
	</dd>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th style="padding-left:30px;text-align: left;">个人信息</th>
<th>邮箱</th>
<th>电话</th>
<th>操作</th>
</tr>
</thead>


<tbody>
	
        <?php if(!empty($students)) { ?>

                <?php foreach ($students as $student) { ?>
		<tr>
			<?php 
			if(!empty($student['face']))
				$face = getthumb($student['face'],'50_50');
			else{
				if($student['sex']==1){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				}else{
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
				}
				$face = getthumb($defaulturl,'50_50');
			} 
			?>
							
			<td width="25%">
				<a style="float:left;" href="javascript:;" title="<?= $student['username'] ?>"><img style="width:40px; height:40px;" class="imgyuan" src="<?= $face ?>"/></a>
				<p class="ghjut"><?= $student['realname'] ?><?= $student['sex']==1?'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png" />':'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png" />' ?></p>
				<p  class="ghjut"><?= $student['username'] ?></p>
			</td>
			<td width="25%" style="text-align:center"><?=!empty($student['email'])?$student['email']:"-"?></td>
			<td width="25%" style="text-align:center"><?=!empty($student['mobile'])?$student['mobile']:"-"?></td>
			<td width="25%" style="text-align:center">
				<a class=""  target="_blank" style="text-decoration: none;text-align:center;color:#5e98fb;margin-right:20px;" href="<?= geturl('troomv2/statisticanalysis/profile/'.$student['uid']).'?classid='.$classid ?>">查看</a>
				<a class="aresetpass" style="text-decoration: none;text-align:center;color:#5e98fb;" href="javascript:;">重置密码</a>
				<input type="hidden" class="stuinfo" username="<?=$student['username']?>" realname="<?=$student['realname']?>" uid="<?=$student['uid']?>" sex="<?=$student['sex']?>" classid="<?=$student['classid']?>" email="<?=$student['email']?>" mobile="<?=$student['mobile']?>" classname="<?=$student['classname']?>"/>
			</td>
		</tr>
                <?php } ?>
		
        <?php } else { ?>

		<tr><td colspan="4" align="center" style="border-bottom:none;"><div class="nodata"></div></td></tr>
        <?php } ?>

</tbody>
</table>
<?= $pagestr ?>
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
<script type="text/javascript">
$(function(){
    initsearch("search","请输入姓名或账号");
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/tastulog-0-0-0-'.$classid) ?>';
                var searchvalue = $.trim($("#search").val());
		if(searchvalue=='请输入姓名或账号'){
			searchvalue = '';
		}
//		if(searchvalue=='请输入老师姓名或登录帐号'){
//			searchvalue='';
//		}
		href = href + "?q=" + searchvalue;
		location.href = href;
	});

});

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
	if((password == '') || (password=='请输入密码')   ){
		H.get('xtips').exec('setContent','未填密码,操作取消').exec('show').exec('close',500);
		H.get('dialogpass').exec('close');
	}else  if(password!=passconf){
		H.get('xtips').exec('setContent','两次密码输入不一致！').exec('show').exec('close',500);
	}else if(password.length < 6 || passconf.length  < 6){
		H.get('xtips').exec('setContent','密码不能少于6位！').exec('show').exec('close',500);
	}else
	{
	H.get('xtips').exec('setContent','正在修改请稍候。。。').exec('show').exec('close',500);
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/student/editpass')?>',
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

function closedialog(id){
	H.get('dialog'+id).exec('close');
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
var _bsname = false;
var _bpwd = true;
var _bnewpwd = true;

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
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>

<?php $this->display('troomv2/page_footer'); ?>