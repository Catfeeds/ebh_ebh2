<?php $this->display('aroom/page_header');
	$classid = !empty($classid)?$classid:0;
?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
		当前位置 > 学生管理
		<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="uname" <?=$stylestr?> class="newsou" id="search" type="text"  <?php if(!empty($search)){?>value="<?=str_replace("''","'",$search)?>" style="color:#000"<?php }else{?>value="请输入学生姓名或登录帐号"<?php }?>  onblur="if($('#search').val()==''){$('#search').val('请输入学生姓名或登录帐号').css('color','#CBCBCB');}" onfocus="if($('#search').val()=='请输入学生姓名或登录帐号'){$('#search').val('');}$('#search').css('color','#000');" />
	<input id="searchbutton" type="button" class="soulico" value="">
</div>
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="annuato" style="line-height:28px;border:none;position: relative;">
<div class="tiezitool">
<a class="hongbtn jiabgbtn marrig" onclick="window.location.href='<?=geturl('aroom/student/add-0-0-0-'.$classid)?>'" >添加学生</a>
<a class="hongbtn jiabgbtn <?=$room['isschool']=='7'?'marrig':'marrig'?>" onclick="window.location.href='<?=geturl('aroom/student/input')?>'" >批量导入</a>
<a class="hongbtn jiabgbtn <?=$room['isschool']=='7'?'marrig':''?>" onclick="window.location.href='<?=geturl('aroom/student/input_upgrade')?>'" >升班导入</a>
<?php if($room['isschool']==7){?>
<a class="hongbtn jiabgbtn" style="width:135px" onclick="window.location.href='<?=geturl('aroom/student/input_scb')?>'">可查询账号导入</a>
<?php }?>
</div>
</div>

<script type="text/javascript">

//点击导入excel表格数据 
$("#t_sub").click(function(){
	var height = $(parent.document).height();
	var crid = $(this).attr("name");
	// var width = $(parent.document).width();
	var ht = '<div class="diae" style="width:100%;height:'+height+'px;position:absolute;top:0;left:0;">';
	ht += '<div style="width:100%;height:'+height+'px;position:absolute;left:0;top:0;background:#808080;filter:alpha(opacity=50);opacity:0.5;z-index:999;"></div>';
	ht += '<div style="position: absolute;background-color:#eaeaea;width:450px;height:170px;z-index:1000;left:500px;top:200px;">';
	ht += '<h2 class="ketit" style="height:28px;line-height:28px;padding:0 10px;font-weight:bold;">请选择导入文件<a href="#" class="blues" style="background:url(/static/images/guanbtn0820.jpg) no-repeat; display: block; height:11px; left:425px; position:absolute; top:7px; width:11px;"></a></h2>';
	ht += '<form action="" target="mainFrame" id="eform" style="background:#fff;height:95px;padding-right:25px;" accept-charset="utf-8" method="post" enctype="multipart/form-data">';
   	
   	ht += '<input type="hidden" name="action" value="aroomstudent" />';
	ht += '<input type="hidden" name="op" value="studentimport" />';
	ht += '<input type="hidden" id="crid" name="crid" value="'+crid+'" />';

   	ht += '<input name="efile" id="t_file" type="file" style="color:#666666;background:#eeeeee;height:24px;line-height:24px;margin-top:25px;margin-left:50px;">'; 
	ht += '<p id="upmsg" style="margin-left:50px;margin-top:10px;color:#adacac;font-size:12px;">注意：请选择表格文件，如.xls，.xlsx等文件. 表中必须含有一个唯一标识的字段，如学号，学生编号。另也必须有班级字段！</p>';

	ht += '<a href="#" class="quwux" style="background:url(/static/images/quxiaobtn0820.jpg) no-repeat; width:48px; height:25px; line-height:25px; display:block; text-align:center; color:#000; text-decoration:none; float:right; margin-top:10px; margin-right:10px;position:absolute;bottom:10px;right:0px;">取消</a>';
	ht += '<input type="submit" value="确定" class="queder" style="border:none;background:url(/static/images/zhengdibtn0820.jpg) no-repeat; width:48px; height:25px; line-height:25px; display:block; text-align:center; color:#fff; text-decoration:none; float:right; margin-top:10px; margin-right:10px;position:absolute;bottom:10px;right:60px;">';
	ht += '</form>';
	ht += '</div>';
	ht += '</div>';
	if($(".diae",window.parent.document).length >0 ){
		$(".diae",window.parent.document).css("display","block");	
	}else{
		$(window.parent.document.body).append(ht);
	}
	
	$(".blues",window.parent.document).click(function(){
		$(".diae",window.parent.document).remove();
	});
	$(".quwux",window.parent.document).click(function(){
		$(".diae",window.parent.document).remove();
	});
	$(".queder",window.parent.document).click(function(){
		var file = $("#t_file",window.parent.document).val();
		if (file != '') {
			$(".diae",window.parent.document).css("display","none");	
		}else{
			$("#upmsg",window.parent.document).html("请选择上传文件");
			$("#upmsg",window.parent.document).css("color","#f00");
			return false;
		}
	});	
});
</script>
<div id="icategory" class="clearfix">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroom/student-0-0-0-0')?>">所有学生</a>
			</div>
			<?php foreach($classlist as $cl){?>
			<div>
				<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroom/student-0-0-0-'.$cl['classid']).'?rnd='.rand()?>"><?=$cl['classname']?></a>
			</div>
			<?php }?>
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
		<?php
			if(!empty($roomuserlist)){
			foreach($roomuserlist as $v){?>
		<tr>
			<td width="13%"><span style="word-wrap: break-word;float:left;width:75px;"><?=$v['classname']?></span></td>
			<td width="15%"><?=$v['username']?></td>
			<td width="11%"><?=ssubstrch($v['realname'],0,20)?></td>
			<td width="5%"><?=$v['sex']==1?'女':'男'?></td>
			<td width="18%"><span style="word-wrap: break-word;float:left;width:135px;"><?=$v['email']?></span></td>
			<td width="12%"><?=$v['mobile']?></td>
			<td style="width:300px;">
			<a class="workBtn" href="<?=geturl('aroom/student/edit/'.$v['uid'])?>">编辑</a>
			<a class="workBtn delt" uid="<?=$v['uid']?>" href="javascript:void(0);">删除</a>
			<a class="workBtn" href="javascript:editstudentpass('<?=$v['uid']?>','<?=$v['username']?>','<?=$v['cnname']?>');">密码</a>
			<?php if($room['domain']=='ykyz'){?>
			<a class="workBtn unbindbtn" style="margin-right:0px" uid="<?=$v['uid']?>" username1="<?=$v['username']?>" realname="<?=$v['realname']?>" allowip="<?=$v['allowip']?>" href="javascript:void(0)">解绑</a>
			<?php }?>
			</td>
		</tr>

		<?php }}else{?>
		<tr><td colspan="7" align="center">暂无记录</td></tr>
		<?php }?>
</tbody>
</table>
</div>

<div id="dialog" style="display:none">加载中...</div>
<?=$pagestr?>
<script type="text/javascript">
$(".delt").click(function(){
	var _uid = $(this).attr("uid");
	$.confirm("您确认要删除此学生吗？",function(){
		$.ajax({
			type:'post',
			url:'<?=geturl('aroom/student/del')?>',
			dataType:'json',
			data:{'uid':_uid},
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
function opendialog(uid,username,cnname)
{
    var objhtml="";
	
	objhtml = "<div style='margin-top:15px;margin-left:15px;'>登录账号：<span style='margin-top:5px;'> "+username+"</span><br/>"+
				"<input type='hidden' value='"+uid+"'/>"+
				"姓　　名：<span style='margin-top:5px;'> "+cnname+"</span><br/>"+
				"密　　码：<input id='password' type='password' style='border:1px solid #ddd;margin-top:5px'/><br/>"+
				"确认密码：<input id='passconf' type='password' style='border:1px solid #ddd;margin-top:5px'/><br/>"+
			"</div>";
	$("#dialog").html(objhtml);
	
	var button = new xButton();
	button.add({
		value:'保存',
		callback:function(){
			savepass(uid);
			return false;
		},
		autofocus:true
	});
	H.create(new P({
		id:'dialog',
		title:'重设密码',
		content:$("#dialog")[0],
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
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}
	var password = $("#password").val();
	var passconf = $("#passconf").val();
	if(password!=passconf)
		H.get('xtips').exec('setContent','两次密码输入不一致！').exec('show').exec('close',500);
	else
	{
	H.get('xtips').exec('setContent','正在修改请稍候。。。').exec('show').exec('close',500);
	$.ajax({
		type:'post',
		url:'<?=geturl('aroom/student/editpass')?>',
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
				H.get('xtips').exec('setContent','密码修改失败！请使用6位以上密码').exec('show').exec('close',500);
			}
		}
	});
	}
}
$(function(){
	$('#searchbutton').click(function(){
		<?php $classid = empty($classid)?'0':$classid?>
		var url = '<?=geturl('aroom/student-0-0-0-'.$classid)?>';
		

		if($("#search").val()=='请输入学生姓名或登录帐号'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入老师姓名或登录帐号'){
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
		
		href = url+"?q="+searchvalue;
		
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

$('.unbindbtn').click(function(){
	$("#dialog").dialog({
		autoOpen: false,
        resizable:false,
        title:'ip解绑',
		width: 500,
        height:230,
		modal: true	//模式对话框
	});
	
	$("#dialog").dialog('open');
	var courselist = '';
	var uid = $(this).attr('uid');
	var username = $(this).attr('username1');
	var realname = $(this).attr('realname');
	
	var allowip = $(this).attr('allowip');
	$.ajax({
		type:'post',
		url:'/aroom/student/getstuinfo.html',
		data:{uid:uid},
		async:false,
		success:function(data){
			courselist = eval('('+data+')');
		}
	});
	
	var objhtml = "<div style='margin-top:15px;margin-left:15px;'>登录账号：<span style='margin-top:5px;'> "+username+"</span><br/>"+
				"<input type='hidden' value='"+uid+"'/>"+
				"姓　　名：<span style='margin-top:5px;'> "+realname+"</span><br/>"+
				"允许的ip：<span style='margin-top:5px;'/> "+allowip+"</span><br/>"+
				"开通课程：";
				
	$.each(courselist,function(k,v){
		objhtml+= v.iname +'　';
	});
		objhtml+= '<br/>';
		objhtml+= "<input type='button' onclick='dounbind("+uid+")' value='解绑' class='orangelights' style='margin-top:50px;margin-left:185px;'/>"+
			"</div>";
	
	$("#dialog").html(objhtml);
});
function dounbind(uid){
	$.ajax({
		type:'post',
		url:'/aroom/student/unbind.html',
		data:{uid:uid},
		success:function(data){
			if(data==1){
				$.showmessage({
					img		 :'success',
					message  :'解绑成功',
					callback :function(){
						location.reload();
					}
				});
				
			}else{
				$.showmessage({
					img		 :'error',
					message  :'解绑失败'
				});
			}
		}
	});
}
</script>
<?php $this->display('aroom/page_footer')?>
