<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>认证申请</title>
</head>
<body>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20151026" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<style>
.selected{
	color:#fff!important;
	background:#98DAFF;
}
#photo_upprogressbox{
	display:none!important;
}
.man,.women{cursor:pointer;}
.input_error_msg{clear:both;padding:0 2px;color:#ff0000;}
</style>
<div class="lefrig" style="background:#fff;float:left;width:1000px;">
	<div class="workol">
		<div class="work_menu" style="position:relative;">
			<ul>
				<li class="workcurrent"><a href="<?=geturl('examapply/apply')?>"><span>认证申请</span></a></li>
				<li><a href="<?=geturl('examapply/exam/examlist')?>"><span>认证考核</span></a></li>
				<li><a href="<?=geturl('examapply/exam/examresult')?>"><span>查看结果</span></a></li>
			</ul>
		</div>
		<div class="result">
<?php
if(!empty($apply)){
	if($apply['status'] == 0){
		echo '<div><p class="p1">您的申请已提交，等待审核...</p><span class="span1">(审核周期在15个工作日内)</span></div>';
	} elseif($apply['status'] == 1) {
		echo '<div><p class="p2">您的申请已审核通过，<a href="'.geturl('examapply/exam/examlist').'">进入考试</a></p></div>';
	}
}
?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="mt10 zgrz">
		<div class="essinfor_top">
			<div class="title fl"><h3>基本信息（必填）</h3></div>
		</div>
		<div>
			<input type="hidden" id="applyid" value="<?=empty($apply['applyid'])?0:$apply['applyid']?>">
			<table cellpadding="0" cellspacing="0" class="tables mt20" width="100%" >
				<tr>
					<td width="32%" class="td1">证件照：</td>
					<td width="68%">
						<div class="sczjz" id="photo_img">
                            	<div  class="fl"><img id="photo" src="<?=empty($apply['photo'])?'':$apply['photo']?>" width="92" /></div>
                        </div>
						<div class="clear"></div>
					</td>
				</tr>
				<tr>
					<td width="32%" class="td1">姓名：</td>
					<td width="68%"><?=empty($apply['realname'])?'':$apply['realname']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">姓名全拼：</td>
					<td width="68%"><?=empty($apply['namespell'])?'':$apply['namespell']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">性别：</td>
					<td width="68%"><?=$apply['sex'] == 1 ? '女':'男'?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">出生年月：</td>
					<td width="68%"><?=$apply['birthyear']?>年<?=$apply['birthmonth']?>月</td>
				</tr>
				<tr>
					<td width="32%" class="td1">身份证号：</td>
					<td width="68%"><?=empty($apply['idcard'])?'':$apply['idcard']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">手机号码：</td>
					<td width="68%"><?=empty($apply['mobile'])?'':$apply['mobile']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">电子邮箱：</td>
					<td width="68%"><?=empty($apply['email'])?'':$apply['email']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1" >收件地址：</td>
					<td width="68%" style="position:relative;"><?=empty($apply['provincename'])?'':$apply['provincename']?> <?=empty($apply['cityname'])?'':$apply['cityname']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1"></td>
					<td width="68%"><?=empty($apply['address'])?'':$apply['address']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">邮政编码：</td>
					<td width="68%"><?=empty($apply['zipcode'])?'':$apply['zipcode']?></td>
				</tr>
			</table>
			
		</div>
	</div>
	<div class="clear"></div>
	<div class="mt10 zgrz">
		<div class="essinfor_tops">
			<div class="title fl"><h3>学校信息（非在校生可不填）</h3></div>
		</div>
		<div>
			<table cellpadding="0" cellspacing="0" class="tables mt20" width="100%" >
				<tr>
					<td width="32%" class="td1">学校名称：</td>
					<td width="68%"><?=empty($apply['schoolname'])?'':$apply['schoolname']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">所属专业：</td>
					<td width="68%"><?=empty($apply['major'])?'':$apply['major']?></td>
				</tr>
				<tr>
					<td width="32%" class="td1">学生证号：</td>
					<td width="68%"><?=empty($apply['stuid'])?'':$apply['stuid']?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="clear"></div>
	<p style="color:#ff7070; text-align:center; line-height:35px;">*注意：以上信息均需按实际情况填写，信息内容将由教育部与人社部统一审核，审核不通过将不予考试资格，请慎重填写！</p>
	<div class="cxsq mt20"><a id="cancelapply" href="javascript:void(0)">撤销申请</a></div>
</div>
<div class="clear"></div>
<script>
$(function(){
	$("#cancelapply").click(function(){
		$.confirm( "撤销申请确认","确定要撤销申请吗？",function(){
			var applyid = $("#applyid").val();
			$.ajax({
				type: 'POST',
				url: '/examapply/apply/cancel.html',
				data: {applyid:applyid},
				dataType: 'json',
				success: function(data){
					if(data != undefined && data != null & data.status ==1){
						alert('已撤销申请。');
						window.location.reload();
					}
					else{
						alert(data.msg);
					}
				}
			});
		});
	});
});
</script>
<script>
$(function(){
	if (window.top != window.self){
		top.$('#mainFrame').width(1000);
		top.$('.rigksts').hide();
	}
});
</script>
</body>
</html>
