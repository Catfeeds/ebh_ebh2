<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/common.css" />
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinview.css" />
		<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160224001" rel="stylesheet" type="text/css">
		<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	</head>
	<body>
		<div class="checkinview">
			<div class="waitite">
				<div class="work_menu" style="position:relative;margin-top:0">
					<ul>
						<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">考勤列表</span></a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>
			<?php if(empty($classes)){?>
			<div class="ban"></div>
			<?php } else { ?>
			<form action="/troomv2/attendance/check/<?=$cwid?>.html" class="checkin_form">
				<input type="hidden" name="export" value="0">
				<input type="text" placeholder="搜索账号及姓名" name="name" id="name" value="<?=$this->input->get('name')?>" />
				<select name="classid" id="forum" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择班级</option>  
					<option value='0' <?php if(0 == $this->input->get('classid')){?>selected<?php } ?> >选择班级</option>  
					<?php foreach($classes as $class){ ?>
					<option value="<?=$class['classid']?>"  <?php if($class['classid'] == $this->input->get('classid')){?>selected<?php } ?> ><?=$class['classname']?></option>
					<?php } ?>
				</select>
				<div style="float:left;width:140px;height:36px;margin:0 10px 0 0;">
					<div style="float:left; display:inline;height: 36px;">
						<input type="text" id="startTime" name="startTime" class="readonly" readonly="readonly" style="" placeholder="选择开始时间" onclick="WdatePicker({});" value="<?=$this->input->get('startTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<div style="float:left;width:140px;height:36px;margin:0 10px 0 0;">
					<div style="float:left; display:inline;height: 36px;">
						<input type="text" id="endTime" name="endTime" class="readonly" readonly="readonly" style="" placeholder="选择结束时间" onclick="WdatePicker({});" value="<?=$this->input->get('endTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<select name="state" id="state" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择学习状态</option>  
					<option value ="0" <?php if(0 == $this->input->get('state')){?>selected<?php } ?> >选择学习状态</option>
  					<option value ="1" <?php if(1 == $this->input->get('state')){?>selected<?php } ?> >已学习</option>
  					<option value ="2" <?php if(2 == $this->input->get('state')){?>selected<?php } ?> >未学习</option>
				</select>
				<button type="button" class="search_btn" value="搜索">搜索</button>
				<button type="button" class="export" value="导出">导出</button>
				<button class="load" value="刷新"  >刷新</button>
			</form>
			<table class="datatab" width="100%" cellspacing="0" cellpadding="0">
				<tr style="background: #eef1f6;">
					<th class="first">账号</th>
				    <th class="class_num">班级</th>
				    <th>学习状态</th>
				    <th class="into">进入课堂</th>
				</tr>
				<?php foreach($list as $user){ ?>
				<tr>
					<td class="user checkin_list">
						<img class="face_img" src="<?=getavater($user)?>" alt="" />
						<div class="user_view">
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
					<td class="class_num checkin_list"><?=$user['classname']?></td>
					<td>
						<?php if($user['jointime'] > 0){?>
							已学习
						<?php } else {?>
							未学习
						<?php } ?>
					</td>
					<td class="into checkin_list">
						<?php if($user['jointime'] > 0){?>
							<?=date('Y-m-d H:i:s',$user['jointime'])?>
						<?php } else {?>
							--
						<?php } ?>
					</td>
				</tr>
				<?php } ?>
				
			</table>
			<?=$pagestr?>
			<?php } ?>
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
