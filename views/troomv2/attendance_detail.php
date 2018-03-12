<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/common.css" />
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinview.css" />		
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinviewGai.css" />
		<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160224001" rel="stylesheet" type="text/css">
		<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	</head>
	<body>
		<div class="checkinview">
			<div class="waitite">
				<div class="work_menu" style="position:relative;margin-top:0">
					<ul>
						<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">出勤详情</span></a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>

			<form action="/troomv2/attendance/detail/<?=$cwid?>.html" class="checkin_form">
				<input type="hidden" name="export" value="0">
				<input type="hidden" name="classid" value="<?=$this->input->get('classid')?>">
				<input type="text" placeholder="搜索账号及姓名" name="name" id="name" value="<?=$this->input->get('name')?>" />
				<select name="state" id="state" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择学习状态</option>  
					<option value ="0" <?php if(0 == $this->input->get('state')){?>selected<?php } ?> >选择学习状态</option>
  					<option value ="1" <?php if(1 == $this->input->get('state')){?>selected<?php } ?> >已学习</option>
  					<option value ="2" <?php if(2 == $this->input->get('state')){?>selected<?php } ?> >未学习</option>
				</select>
				<button class="search_btn" type="button" value="搜索">搜索</button>
				<button class="export" type="button" value="导出">导出</button>
				<button class="load" value="刷新" >刷新</button>
			</form>
			<table class="datatab" width="100%" cellspacing="0" cellpadding="0">
				<tr style="background: #eef1f6;">
					<th class="class_num" style="width:10%;">班级</th>
					<th class="first" style="width:25%;">账号</th>
					<th class="phone" style="10%">手机号</th>
					<th>观看次数</th>
				    <th class="into" style="width:15%;">首次学习</th>
				    <th class="into" style="width:15%;">最后学习</th>
				    <th>视频总时长</th>
				    <th>累计时长</th>
				</tr>
				
				<?php foreach($list as $user){?>
				<tr>
					<td class="class_num checkin_list" style="width:10%;"><?=$user['classname']?></td>
					<td class="user checkin_list" style="width:25%;">
						<img class="face_img" src="<?=getavater($user)?>" alt="" />
						<div class="user_view" style="width:75%;">
							<p><span><?=$user['realname']?></span>
							
							<?php if( $user['sex'] == 0){?>
							<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png" alt="" />
							<?php } else {?>
							<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png" alt="" />
							<?php } ?>
							
							</p>
							<p class="user_txt"><?=$user['username']?></p>
						</div>
					</td>
					<td style="width:10%;"><?=empty($user['mobile']) ? '--' : $user['mobile']?></td>
					<td><?=$user['playcount']?></td>
					<td class="into checkin_list" style="width:15%;">
						<?php if($user['startdate'] > 0){ ?>
						<?=date('Y-m-d H:i:s',$user['startdate'])?>
						<?php } else { ?>
						--
						<?php } ?>
					</td>
					<td class="into checkin_list" style="width:15%;">
						<?php if($user['lastdate'] > 0){ ?>
						<?=date('Y-m-d H:i:s',$user['lastdate'])?>
						<?php } else { ?>
						--
						<?php } ?>
						
					</td>
					<td><?=intval($course['cwlength'] / 60)?>分<?=intval($course['cwlength'] % 60)?>秒</td>
					<td><?=intval($user['ltime'] / 60)?>分<?=intval($user['ltime'] % 60)?>秒</td>
				</tr>
				<?php } ?>
				
			</table>	
		</div>
	</body>
<script>
	$(function(){
		var mainFrame = parent.document.getElementById('mainFrame');
		var allH = document.body.offsetHeight + 50;
		mainFrame.style.height = allH + "px";
		$('.search_btn').on('click',function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
		$('.load').on('click',function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
		$('.export').on('click',function(){
			$('input[name="export"]').val(1);
			$('.checkin_form').submit();
		});
		$('.selectinput').change(function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
	})

</script>
</html>
