<?php $this->display('troom/page_header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<body>
<div>
	<div class="ter_tit">
        当前位置 > <a href="/troom/statisticanalysis.html">查询统计</a> > <a href="/troom/statisticanalysis/teach.html"> 教师统计 </a> > 任教班级 > 学生列表
    </div>
    <div class="xueshengguanli2">
    	<!--<div class="xueshengguanli2_top fr">
        	<ul>
            	<li class="fl "><a href="javascript:void(0)" onclick="addstudent()">添加学生</a></li>
            </ul>
        </div>-->
        <div class=" clear"></div>
        <div class="xueshengguanli2_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                    <td width="252">学生</td>
                	<td width="110">班级</td>
                    <td width="144">邮箱</td>
                    <td width="120">联系电话</td>
                    <td width="100">操作</td>
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
					<td width="252"><div class="fl"><img style="width:50px;height:50px" src="<?=$face?>" /></div><div class="p2" style="line-height:18px;"><p style="width:95px;height:18px; overflow:hidden;"><b><?=$user['realname']?>（<?=empty($user['sex'])?'男':'女'?>）</b></p><p style="width:95px;height:18px; overflow:hidden;"><?=$user['username']?></p><p class="jifenico" style="color:#9e9ea0 !important;"><?=$user['credit']?></span></p></div></td>
                	<td width="110"><?=$user['classname']?></td>
                    <td width="144"><?=empty($user['email'])?'':$user['email']?></td>
                    <td width="120"><?=empty($user['mobile'])?'':$user['mobile']?></td>
                    <td width="100">
                    	<!--<a target="_blank" href="/aroom/umanager/student.html?s=<?=urlencode(authcode($user['uid'],'ENCODE'))?>">进入学生首页</a>
                        <a href="javascript:void(0)" class="aedit">编辑</a>
                        <a href="javascript:void(0)" class="adel">删除</a>-->
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
		url:'<?=geturl('troom/student/editpass')?>',
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

var _xform = new xForm({
	domid:'dialogpass',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});

</script>
</body>
</html>
