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
            table.datatab .today{color:#f00;}
        </style>
	</head>
	<body>
		<div class="checkinview">
			<div class="waitite">
				<div class="work_menu" style="position:relative;margin-top:0">
					<ul>
						<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">课件列表</span></a></li>
                        <li><a href="/troomv2/attendance/classindex.html">班级列表</a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>
			
			
						
			<form action="/troomv2/attendance.html" class="checkin_form">
				<select name="folderid" id="forum" class="selectinput">
					<option value='' disabled selected style='display:none;'>选择课程</option>  
					<option value ="0" <?php if(0 == $this->input->get('folderid')){?>selected<?php } ?> >选择课程</option>
					<?php
						
						foreach($folders as $folder){
							
					?>
					<option value ="<?=$folder['folderid']?>" <?php if($folder['folderid'] == $this->input->get('folderid')){?>selected<?php } ?> ><?=$folder['foldername']?></option>
					<?php 
						
						 } ?>
					
				</select>
				<div style="float:left;width:140px;height:24px;margin:0 20px 0 0;">
					<div style="float:left; display:inline;height: 24px;">
						<input type="text" id="startTime" name="startTime" class="readonly" readonly="readonly" style="" placeholder="选择开始时间" onclick="WdatePicker({});" value="<?=$this->input->get('startTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<div style="float:left;width:140px;height:24px;margin:0 20px 0 0;">
					<div style="float:left; display:inline;height: 24px;">
						<input type="text" id="endTime" name="endTime" class="readonly" readonly="readonly" style="" placeholder="选择结束时间" onclick="WdatePicker({});" value="<?=$this->input->get('endTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<input type="text" placeholder="搜索课件" name="name" id="name" value="<?=$this->input->get('name')?>" />
				<button class="search_btn" type="submit" value="搜索">搜索</button>			
				<?php if($roominfo['uid'] == $user['uid']){?>
					<button class="exportBtn export" type="button" value="导出">导出</button>
				<?php }?>
			</form>
			<table class="datatab" width="100%" cellspacing="0" cellpadding="0" >
				<tr style="background: #eef1f6;">
					<th class="first">序号</th>
				    <th class="second">课件名称</th>
				    <th class="third">课程</th>
				    <th class="fourth">课件开始时间</th>
				    <th class="fifth">课件发布者</th>
				    <th class="sixth">操作</th>
				</tr>
				<?php
                    $now = SYSTIME - SYSTIME % 86400;
					foreach($list as $index=>$course){
					    $time = !empty($course['truedateline']) ? $course['truedateline'] : $course['submitat'];
					    $istoday = ($time - $time % 86400) == $now;
				?>
				<tr>
					<td class="first"><?=$index+1+(($page-1) * 20)?></td>
					<td class="second<?php if ($istoday) { ?> today<?php } ?>"><?=$course['title']?></td>
					<td class="third"><?=$course['foldername']?></td>
					<td class="fourth"><?=$course['submitat'] > 0 ? date('Y-m-d H:i:s',$course['submitat']) : '--'?></td>
					<td class="fifth"><?=$course['realname']?></td>
					<td class="sixth"><span class="check_btn"><a href="/troomv2/attendance/check/<?=$course['cwid']?>.html">实时考勤</a></span><span class="turnOut_btn"><a href="/troomv2/attendance/count/<?=$course['cwid']?>.html">出勤统计</a></span></td>
				</tr>
				<?php } ?>
				
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
		$('input[name="export"]').val(0);
		$('.checkin_form').submit();
	});
	<?php if($roominfo['uid'] == $user['uid']){?>
	$('.exportBtn').on('click', function () {
		var iframe = document.createElement("iframe"); 
		var folderid = $('#forum').val();
		var foldername = $('#forum').find("option:selected").text()
		var startTime = $('#startTime').val();
		var endTime = $('#endTime').val();
		var name = $("#name").val();	
        iframe.src =  "/troomv2/attendance/exportall.html?folderid=" + folderid + "&foldername" + foldername + "&startTime=" + startTime + "&endTime="+ endTime +"&name=" + name;
        iframe.style.display = "none";               
        document.body.appendChild(iframe);
	})
	<?php }?>
})	

</script>
</html>
