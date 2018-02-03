<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/aroom/admin.css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<style>
	a.btnx {
		background: #5e96f5;
		padding:3px 20px;
		color: #fff;
		cursor: pointer;
		margin-top: 10px;
		margin-left:20px;
		text-align: center;
		text-decoration: none;
		display: block; 
		border-radius:3px;
		line-height:21px;
	}
	a.btnx:hover {
		background:#4e8bf1;
	}
	.float_left{
		float: left;
	}
	.float_right{
		float: right;
	}
	.datainput{
		border: 1px solid #9EB7CB;
		height: 28px;
		line-height: 20px;
		text-align: center;
		width:100px;
		border-radius:3px;
	}
	.searchbtnx {
		float:right;
		padding-right: 15px;
	}
	.float_left span{
		font-size:12px;
	}
	.lefrig{
		font-family:微软雅黑;
		font-family:Microsoft YaHei;
	}
	.category_cont1 div a{
		padding:2px;
	}
	.category_cont1 div a.curr, .category_cont1 div a:hover{
		padding:2px;
	}
</style>
<div class="ter_tit">
		<div style="float:left;">当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/teacher/viewnav.html">教师查看</a> > 教师上课统计</div>
		
	</div>
	<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;background:#fff;position: relative; height:70px; margin-top:15px;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
<!-- <div class="tiezitoolss">
<a class="excelbtn" href = "/aroom/report/ssexcel.html?classid=<?=$classid?>"> 导出excel</a>
</div> -->
		<div class="searchbtnx" style="float:left; width:540px">
			<div class="float_left" style="margin-top:9px;">
				<span>开始时间　</span><input type="text" class="datainput" id="starttime" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});"  value="<?=$starttime_str?>" />
			 <span>结束时间　</span><input type="text" class="datainput" id="endtime" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$endtime_str?>" />
			</div>
			<a class="btnx float_left" onclick="dosearch()">搜 索</a>
			<a class="btnx float_left" href="javascript:void(0)" onclick="doexport($(this).attr('requesturl'))" requesturl = "/aroomv2/report/tcexcel.html?classid=<?=$classid?>&starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>"> 导出excel</a>
		</div>
</div>


<div id="icategory" class="clearfix" style="background:#fff;border:none; margin-bottom:10px;">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroomv2/report/tcreport-0-0-0-0')?>?starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>">所有班级</a>
			</div>
			<?php foreach($classlist as $cl){?>
			<div>
				<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroomv2/report/tcreport-0-0-0-'.$cl['classid'])?>?starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>"><?=$cl['classname']?></a>
			</div>
			<?php }?>
		</div>
	</dd>
</div>

<div id="p_fct" style="display:none;"><div id="fct"></div></div>

<table class="datatab" width="100%">
<thead class="tabhead">
<tr style="">
<th>教师姓名</th>
<th>课程</th>
<th>课件名称</th>
<th>发布时间</th>
<th>课件时长</th>
<th>点击次数</th>
</tr>
</thead>
<tbody>

	<?php if(!empty($datalist)){
		$lastusername = '';
		$timesum = 0;
		$countsum = 0;
		foreach($datalist as $k=>$sl){
			$timesum += $sl['cwlength'];
			$countsum += $sl['viewnum'];
			if($k==(count($datalist)-1))
				$endflag = 1;
			if($sl['username'] != $lastusername){
				$lastusername = $sl['username'];
				
	?>
		
		<tr>
		<td width="100px" style="border-bottom:none;"><p style="width:100px;word-wrap: break-word;float:left;"><?=$sl['name']?></p></td>
		<td width="100px" style="border-bottom:none;"><p style="width:100px;word-wrap: break-word;float:left;"><?=$sl['foldername']?></p></td>
		<td width="200px" style="border-bottom:none;"><p style="width:200px;word-wrap: break-word;float:left;"><?=$sl['title']?></p></td>
		<td width="120px" style="border-bottom:none;"><?=date('Y-m-d H:i',$sl['dateline'])?></td>
		<td width="100px" style="border-bottom:none;"><?=$sl['cwlength']?></td>
		<td width="80px" style="border-bottom:none;"><?=!empty($sl['viewnum'])?$sl['viewnum']:'0'?></td>
		</tr>
		<?php $foldername = $sl['foldername'];?>
	<?php }else{
	?>
		<tr >
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<?php if(!empty($foldername) && ($sl['foldername']!=$foldername) ){?>
			<td width="100px" style="border-top:none;border-bottom:none;"><?=$sl['foldername']?></td>
		<?php }else{?>
			<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<?php }?>
		<td width="200px" style="border-top:none;border-bottom:none;"><?=$sl['title']?></td>
		<td width="120px" style="border-top:none;border-bottom:none;"><?=date('Y-m-d H:i',$sl['dateline'])?></td>
		<td width="100px" style="border-top:none;border-bottom:none;"><?=$sl['cwlength']?></td>
		<td width="80px" style="border-top:none;border-bottom:none;"><?=!empty($sl['viewnum'])?$sl['viewnum']:'0'?></td>
		</tr>
		<?php $foldername = $sl['foldername'];?>
	<?php }if(empty($datalist[$k+1]) || $sl['username']!=$datalist[$k+1]['username'] ){
		?>
		<tr>
		<td colspan="3" style="border-top:none;"></td>
		<td style="border-top:none;">总计:</td>
		<td style="border-top:none;" ><?=secondToStr($timesum)?></td>
		<td style="border-top:none;"><?=$countsum?></td>
		</tr>
	<?php
		$timesum = 0;
		$countsum = 0;
		}
	}?>
	
	<?php }else{?>

	<tr><td colspan="6" align="center">暂无记录</td></tr>
	<?php }?>

</tbody>
</table>
<?=$pagestr?>
</div>

<id id="export"></id>
<div id="logdialog" style="display:none;">
	<iframe id="logframe" width=800px height=600px src="" frameborder="0"></iframe>
</div>
<script>
	function dosearch(){
		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();
		var url = "/aroomv2/report/tcreport-1-0-0-<?=!empty($classid)?$classid:0?>.html?starttime="+starttime+"&endtime="+endtime;
		location.href = url;
	}

	function showlog_dialog(uid,folderid){
		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();
		if(folderid){
			var url = "/aroom/astulog/astuloglist_fordialog-1-0-0-"+uid+"-"+folderid+".html?starttime="+starttime+"&endtime="+endtime;
		}else{
			var url = "/aroom/astulog/astuloglist_fordialog-1-0-0-"+uid+".html?starttime="+starttime+"&endtime="+endtime;
		}
		
		$("#logframe").attr("src",url);
		parent.window.showslogDialog("#logdialog",uid);
	}

	function doexport(url){
		new parent.window.exportTools(url).run();
	}
</script>
<?php $this->display('aroomv2/page_footer')?>
