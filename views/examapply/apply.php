<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>认证申请</title>
</head>
<body>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
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
.result .p3{background-position: left top;}
.result .p3 span{font-size: 15px; font-weight: normal;}
</style>
<div class="lefrig qualification" style="background:#fff;float:left;width:1000px;">
	<div class="workol" style="margin-top:0;">
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
	} elseif($apply['status'] == 2) {
		echo '<div><p class="p3">您的申请审核未通过<span>（' . $apply['verifymessage'] . '），请修改后再次提交。</span></p></div>';
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
						<div class="sczjz" id="photo_upload" <?=empty($apply['photo'])?'':'style="display:none"'?>>
							<div class="sczjz_son fl">
							<?php $Upcontrol = Ebh::app()->lib('UpcontrolLib');
	$Upcontrol->upcontrol('photo',1,array(),'pic',array('button_text'=>' ','button_width'=>78,'button_height'=>30,'button_image_url'=>'http://static.ebanhui.com/ebh/tpl/2014/images/uplooad_photo.jpg'));?>
							</div>
							<div class="fl"><p><span class="span1">*</span>（限jpg格式，分辨率300px，尺寸307px*426px）</p></div>
						</div>
						<div class="sczjz" id="photo_img" <?=empty($apply['photo'])?'style="display:none"':''?>>
                            	<div  class="fl"><img id="photo" src="<?=empty($apply['photo'])?'':$apply['photo']?>" width="92" /></div>
                            	<div  class="fl">
                                	<p><span class="span1">*</span>（限jpg格式，分辨率300px，尺寸307px*426px）</p>
                                	<div class="mt50" style="padding-top:30px; padding-left:15px;"><a href="javascript:;" onclick="reupload();" style="color:#548bf0;">重新上传</a></div>
                                </div>
                        </div>
						<div class="clear"></div>
					</td>
				</tr>
				<tr>
					<td width="32%" class="td1">姓名：</td>
					<td width="68%"><input id="realname" name="realname" class="texts" value="<?=empty($apply['realname'])?'':$apply['realname']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">姓名全拼：</td>
					<td width="68%"><input id="namespell" name="namespell" class="texts" value="<?=empty($apply['namespell'])?'':$apply['namespell']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">性别：</td>
					<td width="68%">
			   			<input id="sex0" type="radio" name="sex" value="0" <?php if(empty($apply['sex'])) echo'checked="checked"';?>/>
						<label class="man" for="sex0">男</label>
						<input id="sex1" type="radio" name="sex" value="1" <?php if(!empty($apply['sex']) && $apply['sex'] == 1) echo'checked="checked"';?>/>
						<label class="women" for="sex1">女</label>
					</td>
				</tr>
				<tr>
					<td width="32%" class="td1">出生年月：</td>
					<td width="68%" style="position:relative;">
						<div>
							<div id="birthyear" class="borndate fl"><?=empty($apply['birthyear'])?'1970':$apply['birthyear']?></div>
							<div id="birthyear_sel" class="borndates fl">
							<?php $this_year = date("Y");
							for($i=1970;$i<=$this_year;$i++){?>
								<a href="javascript:void(0)"><?=$i?></a>
							<?php }?>
							</div>
						</div>
						<div>
							<div id="birthmonth" class="borndate_son fl"><?=empty($apply['birthmonth'])?'01':$apply['birthmonth']?></div>
							<div id="birthmonth_sel" class="borndate_sons fl">
							<?php for($i=1;$i<=12;$i++){?>
								<a href="javascript:void(0)"><?=sprintf("%02d", $i);?></a>
							<?php }?>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td width="32%" class="td1">身份证号：</td>
					<td width="68%"><input id="idcard" name="idcard" class="texts" value="<?=empty($apply['idcard'])?'':$apply['idcard']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">手机号码：</td>
					<td width="68%"><input id="mobile" name="mobile" class="texts" value="<?=empty($apply['mobile'])?'':$apply['mobile']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">电子邮箱：</td>
					<td width="68%"><input id="email" name="email" class="texts" value="<?=empty($apply['email'])?'':$apply['email']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1" >收件地址：</td>
					<td width="68%" style="position:relative;">
						<div>
							<div id="provincecode" vid="0" class="receadd fl"><span><?=empty($apply['provincename'])?'请选择':$apply['provincename']?></span></div>
							<div id="provincecode_sel" class="receadds fl">
							<?php foreach($provinces as $province){?>
								<a href="javascript:void(0)" vid="<?=$province['citycode']?>"><?=$province['cityname']?></a>
							<?php }?>
							</div>
						</div>
						<div>
							<div id="citycode" vid="<?=empty($apply['citycode'])?0:$apply['citycode']?>" class="receadd_son fl"><span><?=empty($apply['cityname'])?'请选择':$apply['cityname']?></span></div>
							<div id="citycode_sel" class="receadd_sons fl">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td width="32%" class="td1"></td>
					<td width="68%"><input id="address" name="address" class="texts" style="width:425px;" value="<?=empty($apply['address'])?'':$apply['address']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">邮政编码：</td>
					<td width="68%"><input id="zipcode" name="zipcode" class="texts" value="<?=empty($apply['zipcode'])?'':$apply['zipcode']?>" /></td>
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
					<td width="68%">111<input id="schoolname" name="schoolname" class="texts" value="<?=empty($apply['schoolname'])?'':$apply['schoolname']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">所属专业：</td>
					<td width="68%"><input id="major" name="major" class="texts" value="<?=empty($apply['major'])?'':$apply['major']?>" /></td>
				</tr>
				<tr>
					<td width="32%" class="td1">学生证号：</td>
					<td width="68%"><input id="stuid" name="stuid" class="texts" value="<?=empty($apply['stuid'])?'':$apply['stuid']?>" /></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="clear"></div>
	<p style="color:#ff7070; text-align:center; line-height:35px;">*注意：以上信息均需按实际情况填写，信息内容将由教育部与人社部统一审核，审核不通过将不予考试资格，请慎重填写！</p>
	<div class="tjsq mt20"><a id="submitapply" href="javascript:void(0)">提交申请</a></div>
</div>
<div class="clear"></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/examapply.js"></script>
<script>
function resetheight(){
	var totalheight = 0;
	var height_qualification = $(".qualification") ? parseInt($('.qualification').get(0).offsetHeight):0;
	totalheight = height_qualification;
	top.resetmain(totalheight);
}
//定时器作为修正使用,防止重复刷新页面没有加载完成
var timer = setTimeout(function(){
	resetheight();
	},500)
	
$(function(){
	if (window.top != window.self){
		top.$('#mainFrame').width(1000);
		top.$('.rigksts').hide();
	}
});
</script>
</body>
</html>
