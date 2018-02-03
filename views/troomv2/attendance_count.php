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
						<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">出勤列表</span></a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>
			<?php if(empty($classes)){?>
			<div class="ban"></div>
			<?php } else { ?>
			<form action="/troomv2/attendance/count/<?=$cwid?>.html" class="checkin_form">
				<input type="hidden" name="export" value="0">
				<select name="classid" id="forum" style="width:130px;" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择班级</option>  
					<option value='0' <?php if(0 == $this->input->get('classid')){?>selected<?php } ?> >选择班级</option>  
					<?php foreach($classes as $class){ ?>
					<option value="<?=$class['classid']?>"  <?php if($class['classid'] == $this->input->get('classid')){?>selected<?php } ?> ><?=$class['classname']?></option>
					<?php } ?>
				</select>
				<button type="button" class="export" value="导出">导出</button>
				<button class="load" value="刷新" >刷新</button>
			</form>
			<table class="datatab" width="100%" cellspacing="0" cellpadding="0">
				<tr style="background: #eef1f6;">
					<th class="class_num">班级</th>
				    <th>应到</th>
				    <th>已到</th>
				    <th class="attend_num">出勤率</th>
				    <th>操作</th>
				</tr>
				
				<?php 
				$allstudent = 0;
				$alljoin = 0;
				foreach($list as $data){?>
				<?php if($data['student_count'] > 0){?>
				<tr>
					<td class="class_num"><?=$data['classname']?></td>
					<td><?=$data['student_count']?></td>
					<td><?=$data['join_count']?></td>
					<td class="attend_num">
						<div class="attend_box">
							<div class="num_box">
								<div class="num" style="width:<?php if($data['student_count'] > 0){?><?=intval($data['join_count']/$data['student_count'] * 100)?><?php }else{ ?>0<?php } ?>%;"></div>
							</div>
							<div class="num_txt"><?php if($data['student_count'] > 0){ ?><?=intval($data['join_count']/$data['student_count'] * 100) ?><?php }else{  ?>0<?php } ?>%</div>
						</div>
					</td>
					<td><a href="/troomv2/attendance/detail/<?=$cwid?>.html?classid=<?=$data['classid']?>">详情</a></td>
				</tr>
				<?php 
				$allstudent += $data['student_count'];
				$alljoin += $data['join_count'];
				} } ?>
				
				<tr>
					<td class="class_num">总出勤</td>
					<td><?=$allstudent?></td>
					<td><?=$alljoin?></td>
					<td class="attend_num">
						<div class="attend_box">
							<div class="num_box">
								<div class="num" style="width:<?php if($allstudent > 0){?><?=intval($alljoin/$allstudent * 100) ?><?php } else {?>0<?php } ?>%;"></div>
							</div>
							<div class="num_txt"><?php if($allstudent > 0){?><?=intval($alljoin/$allstudent * 100) ?><?php } else {?>0<?php } ?>%</div>
						</div>
					</td>
					<td></td>
				</tr>
			</table>
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
