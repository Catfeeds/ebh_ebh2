<?php
$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">网校管理 -  查看网校信息</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/classroom.html">浏览网校信息</a></td>
			<td  class="active"><a href="/admin/classroom/add.html" class="add">添加网校</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable"> 
<tr><th>网校名</th><td><?=$c['crname']?></td></tr>
<tr><th>所属教师</th><td><?=$c['username']?></td></tr>
<tr><th>所属分类</th><td><?=$c['catid']?></td></tr>
<tr><th>所属城市</th><td id="city"></td></tr>
<tr><th>网校摘要</th><td><?=htmlspecialchars($c['summary'])?></td></tr>
<tr><th>容量</th><td><?=$c['maxnum']?></td></tr>
<tr><th>开始时间</th><td><?=date('Y-m-d H:i',$c['begindate'])?></td></tr>
<tr><th>结束时间</th><td><?=date('Y-m-d H:i',$c['enddate'])?></td></tr>
<tr><th>添加时间</th><td><?=date('Y-m-d H:i',$c['dateline'])?></td></tr>
<tr><th>状态</th><td><?php if($c['status']==1){echo '正常';}else{echo '锁定';}?></td></tr>
<tr><th>是否同步课堂</th><td><?php if($c['isschool']==1){echo '已同步';}else{echo '否';}?></td></tr>
</table>
<div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="/admin/classroom.html"'>
 
</div>
<script type="text/javascript">
$(function(){
	$.post('/admin/cities/getAddrText.html',{citycode:"<?=$c['citycode']?>"},function(message){
		$('#city').html(message);
	})
});
	
</script>
</body>


<?php
$this->display('admin/footer');
?>