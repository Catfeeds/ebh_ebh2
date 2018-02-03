<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
.ter_tit a.previewBtn {display:block;float:right;margin-right:10px;margin-top:5px;*margin-top:-30px;width:67px;height:22px;line-height:22px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor: pointer;}
.ter_tit a.previewBtn:hover {background:#0d9be9;color:#fff;text-decoration: none;}

.completetime i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 <?= $sort==1?"-7px":"0"?>;}
.totalscore i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 <?= $sort==3?"-7px":"0"?>;}
.datatab {border:none;}
</style>

<div class="ter_tit">
	当前位置 > <a href="<?= geturl('troomv2/classsubject') ?>" >课程管理</a> > <a href="<?= geturl('troomv2/classsubject/'.$myfolder['folderid']) ?>"><?= $myfolder['foldername'] ?></a> > <?= $course['title'] ?> > 学习监控
	<a href="/troomv2/classcourse/jkexcel-0-0-1-<?= $course['cwid'];?>.html" class="addbtnas previewBtn" target="_blank">导 出</a>
	<a href="javascript:location.reload();" class="addbtnas previewBtn">刷 新</a>
</div>

<div class="lefrig">
<div class="workol" style="float:left; margin-top:15px;">
	<div class="work_mes">
		<ul>
			<li><a href="<?= geturl('troomv2/classcourse/jk-0-0-0-'.$course['cwid']) ?>"><span>学习跟踪</span></a></li>
			<li  class="workcurrent"><a href="<?= geturl('troomv2/classcourse/jk-0-0-1-'.$course['cwid']) ?>"><span>未学名单</span></a></li>
		</ul>
	</div>
	<div class="workol" style="float:left;">
		<div class="workdata" style="float:left;">
			<table width="100%" class="datatab">
				<thead class="tabhead">
				  <tr class="">
				<th>课件名称</th>
				<th>上传时间</th>
				<th>定时发布时间</th>
				<th>已学人数</th>
				<th>未学人数</th>
				  </tr>
				</thead>
				 <tbody>
					  <tr>
						<td width="40%"><?= $course['title'] ?></td>
						<td width="20%"><?= date('Y-m-d H:i:s',$course['dateline']) ?></td>
						<td width="20%"><?= empty($course['submitat']) ? '无' : date('Y-m-d H:i:s',$course['submitat']) ?></td>
						<td width="10%"><?= $course['learncount'] ?></td>
						<td width="10%"><?= $course['nolearncount'] ?></td>
					  </tr>
					<tr>
				</tbody>
			</table>
		</div>
		<div class="workdata" style="float:left;">
			<table width="100%" class="datatab">
				<thead class="tabhead">
				  <tr>
					<th width="15%">班级</th>
					<th width="13%">账号</th>
					<th width="14%">姓名</th>
					<th width="10%">性别</th>
				  </tr>
				</thead>
				<tbody class="classexams">

				<?php if(!empty($myuserlist)) { ?>
					 <?php foreach($myuserlist as $myuser) { 
					 ?>
					 <tr>
						<td><span class="huirenw"><?= $myuser['classname'] ?></span></td>
						<td><?= $myuser['username'] ?></td>
						<td><?= $myuser['realname'] ?></td>
						<td><?= ($myuser['sex'] == 1 ? '女':'男') ?> </td>
					 </tr>
					 <?php } ?>
					  <?php } else { ?>
						<tr>
							<td colspan="4" align="center">暂无记录</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div style="margin-top:20px;"></div>
		</div>
</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>