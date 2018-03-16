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
        <style type="text/css">
            table.datatab th,table.datatab td{padding:0 3px;}
            table.datatab .first{width:20%;}
            table.datatab .second{width:60%;}
        </style>
	</head>
	<body>
		<div class="checkinview">
			<div class="waitite">
				<div class="work_menu" style="position:relative;margin-top:0">
					<ul>
						<li><a href="/troomv2/attendance.html">课件列表</a></li>
                        <li class="workcurrent"><a href="javascript:;" class="title-a"><span class="jnisrso">班级列表</span></a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>
			<form action="/troomv2/attendance/classindex.html" class="checkin_form">
				<input type="text" placeholder="搜索班级或教师" name="name" id="name" value="<?=$this->input->get('name')?>" />
				<button class="search_btn" type="submit" value="搜索">搜索</button>
			</form>
			<table class="datatab" width="100%" cellspacing="0" cellpadding="0" >
				<tr style="background: #eef1f6;">
					<th class="first">班级</th>
				    <th class="second">班主任</th>
				    <th>操作</th>
				</tr>
				<?php if (!empty($list)) {
				    foreach($list as $index => $classitem) { ?>
				<tr>
					<td><?=$classitem['classname']?></td>
					<td><?=$classitem['realname'] == '' ? $classitem['username'] : $classitem['realname']?></td>
					<td><span class="turnOut_btn"><a href="/troomv2/attendance/classcount/<?=$classitem['classid']?>.html">出勤统计</a></span></td>
				</tr>
				<?php } } ?>
			</table>
			<?=$pagestr?>
		</div>
	
	</body>
<script>
$(function(){
	var mainFrame = parent.document.getElementById('mainFrame');
	var allH = document.body.offsetHeight + 50;
	mainFrame.style.height = allH + "px";
	$('.selectinput').change(function(){
		$('.checkin_form').submit();
	});
})	

</script>
</html>
