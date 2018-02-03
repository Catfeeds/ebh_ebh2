<?php $this->display('aroom/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<style>
	a.btnx {
		background: #f57b24;
		height: 20px;
		line-height: 20px;
		width: 82px;
		border: solid 1px #e86b12;
		color: #fff;
		cursor: pointer;
		margin-top: 9px;
		margin-left:15px;
		text-align: center;
		text-decoration: none;
		display: block; 
	}
	a.btnx:hover {
		background:#e86b12;
	}
	.float_left{
		float: left;
	}
	.float_right{
		float: right;
	}
	.datainput{
		border: 1px solid #9EB7CB;
		height: 20px;
		line-height: 20px;
		padding-left: 5px;
		text-align: center;
		width:90px;
	}
	.searchbtnx {
		float:right;
		padding-right: 15px;
	}
</style>
<div class="ter_tit">
		当前位置 > 学生学习统计
		<div class="searchbtnx">
			<div class="float_left">
				<span>开始时间　</span><input type="text" class="datainput" id="starttime" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});"  value="<?=$starttime_str?>" />
			 <span>结束时间　</span><input type="text" class="datainput" id="endtime" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$endtime_str?>" />
			</div>
			<a class="btnx float_left" onclick="dosearch()">搜 索</a>
			<a class="btnx float_left" href="javascript:void(0)" onclick="doexport($(this).attr('requesturl'))" requesturl = "/aroom/report/ssexcel.html?classid=<?=$classid?>&starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>"> 导出excel</a>
		</div>
	</div>
	<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;background:#fff;position: relative;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
<!-- <div class="tiezitoolss">
<a class="excelbtn" href = "/aroom/report/ssexcel.html?classid=<?=$classid?>"> 导出excel</a>
</div> -->
</div>

<div id="icategory" class="clearfix" style="background:#fff;margin-bottom:10px;">
	<dt>所属班级：</dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroom/report/ssreport-0-0-0-0')?>?starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>">所有学生</a>
			</div>
			<?php foreach($classlist as $cl){?>
			<div>
				<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroom/report/ssreport-0-0-0-'.$cl['classid'])?>?starttime=<?=$starttime_str?>&endtime=<?=$endtime_str?>"><?=$cl['classname']?></a>
			</div>
			<?php }?>
		</div>
	</dd>
</div>

<div id="p_fct" style="display:none;"><div id="fct"></div></div>

<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>学生账号</th>
<th>姓名</th>
<th>班级</th>
<th>课程</th>
<th>学习时间</th>
<th>学习次数</th>
</tr>
</thead>
<tbody>

	<?php if(!empty($studylist)){
		$lastusername = '';
		$timesum = 0;
		$countsum = 0;
		foreach($studylist as $k=>$sl){
			$timesum += $sl['stime'];
			$countsum += $sl['scount'];
			if($k==(count($studylist)-1))
				$endflag = 1;
			if($sl['username'] != $lastusername){
				$lastusername = $sl['username'];
				
	?>
		
		<tr>
		<td width="100px" style="border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>)"><?=!empty($sl['username'])?$sl['username']:''?></a></td>
		<td width="100px" style="border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>)"><?=!empty($sl['realname'])?$sl['realname']:''?></a></td>
		<td width="100px" style="border-bottom:none;"><?=!empty($sl['classname'])?$sl['classname']:''?></td>
		<?php if(!empty($sl['tag'])){?>
			<td width="200px" style="border-bottom:none;"><span><?=!empty($sl['foldername'])?$sl['foldername']:''?></span></td>
		<?php }else{?>
			<td width="200px" style="border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>,<?=$sl['folderid']?>)"><?=!empty($sl['foldername'])?$sl['foldername']:''?></a></td>
		<?php }?>
		<td width="120px" style="border-bottom:none;"><?=!empty($sl['stime'])?secondToStr($sl['stime']):'0秒'?></td>
		<td width="80px" style="border-bottom:none;"><?=!empty($sl['scount'])?$sl['scount']:'0'?></td>
		</tr>
	<?php }else{
	?>
		<tr >
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<td width="100px" style="border-top:none;border-bottom:none;"></td>
		<td width="200px" style="border-top:none;border-bottom:none;"><a href="javascript:void(0)" onclick="showlog_dialog(<?=$sl['uid']?>,<?=$sl['folderid']?>)"><?=!empty($sl['foldername'])?$sl['foldername']:''?></a></td>
		<td width="120px" style="border-top:none;border-bottom:none;"><?=!empty($sl['stime'])?secondToStr($sl['stime']):'0秒'?></td>
		<td width="80px" style="border-top:none;border-bottom:none;"><?=!empty($sl['scount'])?$sl['scount']:'0'?></td>
		</tr>
	<?php }if(empty($studylist[$k+1]) || $sl['username']!=$studylist[$k+1]['username'] ){
		?>
		<tr>
		<td colspan="3" style="border-top:none;"></td>
		<td style="border-top:none;">总计:</td>
		<td style="border-top:none;" ><?=!empty($timesum)?secondToStr($timesum):'0秒'?></td>
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
		var url = "/aroom/report/ssreport-1-0-0-<?=!empty($classid)?$classid:0?>.html?starttime="+starttime+"&endtime="+endtime;
		location.href = url;
	}

	function showlog_dialog(uid,folderid){
		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();
		if(typeof folderid != "undefined"){
			if(folderid == 0){
				return;
			}
			var url = "/aroom/astulog/astuloglist_fordialog-1-0-0-"+uid+"-"+folderid+".html?starttime="+starttime+"&endtime="+endtime;
		}else{
			var url = "/aroom/astulog/astuloglist_fordialog-1-0-0-"+uid+".html?starttime="+starttime+"&endtime="+endtime;
		}
			if(parent.window.H.get('slogDialog')){
				parent.window.H.get('slogDialog').exec('show');
				$("#logframe",parent.window.document.body).attr("src",url);
			}else{
				parent.window.H.create(new parent.window.P({
					title:'记录查看',
					content:$("#logdialog")[0],
					id:'slogDialog',
					easy:true
				},{
					'onshow':function(){
						$("#logframe",parent.window.document.body).attr("src",url);
					},
					'onclose':function(){
						$("#logframe",parent.window.document.body).attr("src","");
					}
				}),'common').exec('show');
			}
	}

	function doexport(url){
		new parent.window.exportTools(url).run();
	}
</script>
<?php $this->display('aroom/page_footer')?>
