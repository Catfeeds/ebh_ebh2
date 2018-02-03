<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroom/teacher')?>">教师管理</a>
		<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="uname" <?=$stylestr?> class="newsou" id="search" type="text"  <?php if(!empty($search)){?>value="<?=str_replace("''","'",$search)?>" style="color:#000"<?php }else{?>value="请输入教师姓名或登录帐号"<?php }?>  onblur="if($('#search').val()==''){$('#search').val('请输入教师姓名或登录帐号').css('color','#CBCBCB');}" onfocus="if($('#search').val()=='请输入教师姓名或登录帐号'){$('#search').val('');}$('#search').css('color','#000');" />
	<input id="searchbutton" type="button" class="soulico" value="">
</div>
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
<div class="tiezitool">
<a class="hongbtn jiabgbtn marrig" onclick="window.location.href='<?=geturl('aroom/teacher/add')?>'" >添加教师</a>
<a class="hongbtn jiabgbtn" onclick="window.location.href='<?=geturl('aroom/teacher/input')?>'" >批量导入</a>
</div>
</div>



<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>登录账号</th>
<th>教师姓名</th>
<th>联系方式</th>
<th>操作</th>
</tr>
</thead>
<tbody>
	<?php if(!empty($roomteacherlist)){
		foreach($roomteacherlist as $value){?>
		<tr>
		<td width="140px"><?=$value['username']?><?php if($room['uid'] == $value['uid']){?><span style="color:red">(管理员)</span><?php }?></td>
		<td width="130px"><?=$value['realname']?></td>
		<td width="120px"><?=$value['mobile']?></td>
		<td width="140px">
		<a class="workBtn" href="<?=geturl('aroom/teacher/edit/'.$value['uid'])?>">编辑</a>
		<?php if($room['uid'] != $value['uid'] && $value['uid']!=$user['uid']){?>
		<a class="workBtn delt" tid="<?=$value['uid']?>" href="javascript:void(0);">删除</a>
		<a class="workBtn" style="margin:0px;" href="javascript:editstudentpass('<?=$value['uid']?>','<?=$value['username']?>','<?=$value['realname']?>');">密码</a>
		<a class="workBtn delt" href="/aroom/umanager/teacher.html?s=<?= urlencode(authcode($value['uid'],'ENCODE')) ?>" target="_blank">教师后台</a>
		<?php }?>
		</td>
		</tr>
	<?php }}else{?>
	<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php }?>
</tbody>
</table>
<?=$pagestr?>
</div>
<div id="dialog"></div>
<script type="text/javascript">
$(".delt").click(function(){
	//var _crid = $(this).attr("crid");
	var _tid = $(this).attr("tid");
	$.confirm("您确认要删除此教师吗？",function(){
		$.ajax({
			type:'post',
			url:'<?=geturl('aroom/teacher/deleteroomteacher')?>',
			dataType:'json',
			data:{'tid':_tid},
			success:function(_json){
				if(_json.code == 1){
					alert(_json.message);
					window.location.reload();
				}else{
					alert(_json.message);
				}
			},
			error:function(){
				alert("服务器连接错误，请重试");
			}
		});
	});
});

function editstudentpass(_uid,_username,_cnname){
	opendialog(_uid,_username,_cnname);
	H.get('dialog').exec('show');
	$("#password").focus();
}

function opendialog(uid,username,realname)
{
    var objhtml="";
	
	objhtml = "<div style='margin-top:15px;margin-left:15px;'>登录账号：<span style='margin-top:5px;'> "+username+"</span><br/>"+
				"<input type='hidden' value='"+uid+"'/>"+
				"姓　　名：<span style='margin-top:5px;'> "+realname+"</span><br/>"+
				"密　　码：<input id='password' type='password' style='border:1px solid #ddd;margin-top:5px'/><br/>"+
				"确认密码：<input id='passconf' type='password' style='border:1px solid #ddd;margin-top:5px'/><br/>"+
			"</div>";
	var button = new xButton();
	button.add({
		value:'保存',
		callback:function(){
			savepass(uid);
			//H.get('dialog').exec('close');
			return false;
		},
		autofocus:true
	});
	H.create(new P({
		id:'dialog',
		title:'重设密码',
		content:objhtml,
		easy:true,
		button:button,
		padding:10
	},{
		'onclose':function(){
			H.remove('dialog');
		}
	}),'common');
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
			$("#dialog").dialog('close');
		}
		else
		$.ajax({
			type:'post',
			url:'<?=geturl('aroom/teacher/editpass')?>',
			dataType:'text',
			data:{'uid':uid,'password':password},
			success:function(data){
			// alert(data)
				if(data==1 || data=='1'){
					$.showmessage({message:'密码修改成功！',timeoutspeed:1000,callback:function(){document.location.href = document.location.href;}});
					H.get('dialog').exec('close');
				}
				else
				{
					$.showmessage({message:'密码修改失败,请刷新页面重试！'});
				}
			}
		});
	}
}
$(function(){
	$('#searchbutton').click(function(){
		var href = '<?=geturl('aroom/teacher')?>';
		var searchvalue = $("#search").val();
		if(searchvalue=='请输入教师姓名或登录帐号'){
			searchvalue='';
		}
		searchvalue = searchvalue.replace(/,/g,"");
		searchvalue = searchvalue.replace(/\'/g,"");
		searchvalue = searchvalue.replace(/\"/g,"");
		searchvalue = searchvalue.replace(/\//g,"");
		searchvalue = searchvalue.replace(/%/g,"");
		// searchvalue = searchvalue.replace(/_/g,"");
		searchvalue = searchvalue.replace(/#/g,"");
		searchvalue = searchvalue.replace(/\?/g,"");
		searchvalue = searchvalue.replace(/\\/g,"");
		href=href+"?q="+searchvalue;
		location.href = href;
	});

});

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}
</script>
<?php $this->display('aroom/page_footer')?>
