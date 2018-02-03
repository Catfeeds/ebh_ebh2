<?php $this->display('troom/page_header'); ?>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 21px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	height:28px;
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
</style>
	<div class="ter_tit">
		当前位置 > 班级学生管理
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
	<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
</div>
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">

<div id="icategory" class="clearfix" style="border:none;">
	<dt>所属班级：</dt>
	<dd style="width:681px;">
		<div class="category_cont1">
			<div>
				<a <?= empty($cid) ? 'class="curr"' : ''?> href="<?= geturl('troom/classstudent') ?>">所有学生</a>
			</div>
			
                        <?php foreach ($classlist as $myclass) { ?>
			<div>
				<a <?= $cid == $myclass['classid'] ? 'class="curr"':'' ?> href="<?= geturl('troom/classstudent-0-0-0-'.$myclass['classid']) ?>"><?= $myclass['classname'] ?></a>
			</div>
                        <?php } ?>

		</div>
	</dd>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>学生班级</th>
<th>登录账号</th>
<th>学生姓名</th>
<th>性别</th>
<th>邮箱</th>
<th>电话</th>
<th>操作</th>
</tr>
</thead>


<tbody>
	
        <?php if(!empty($students)) { ?>
                <?php foreach ($students as $student) { ?>
		<tr>
			<td width="20%"><?= $student['classname'] ?></td>
			<td width="15%"><span class="huirenw"><?= $student['username'] ?></span></td>
			<td width="15%"><?= $student['realname'] ?></td>
			<td width="10%"><?= $student['sex']==1?'女':'男'?></td>
			<td width="15%"><?= $student['email'] ?></td>
			<td width="15%"><?= $student['mobile'] ?></td>
			<td width="10%"><?php if(!empty($headclass) && in_array($student['classid'], $headclass)){?><a href="javascript:;" class="workBtn aresetpass" style="width:69px;">重置密码</a><?php }?>
				<input type="hidden" class="stuinfo" username="<?=$student['username']?>" realname="<?=$student['realname']?>" uid="<?=$student['uid']?>" /></td>
		</tr>
                <?php } ?>

        <?php } else { ?>
		<tr><td colspan="6" align="center">暂无记录</td></tr>
        <?php } ?>
</tbody>
</table>
</div>
<?= $pagestr ?>

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
    initsearch("search","请输入学生姓名或登录帐号");
	$('#searchbutton').click(function(){
                if($("#search").val()=='请输入学生姓名或登录帐号'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		var href = '<?= geturl('troom/classstudent-0-0-0-'.$cid)?>';
                href += '?q=' + searchvalue;
		location.href = href;
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
			url:'<?=geturl('troom/classstudent/editpass')?>',
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
});
</script>
<?php $this->display('troom/page_footer'); ?>