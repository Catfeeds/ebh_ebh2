<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">教室管理 -  查看云教育留言</h1></td>
		<td class="actions" >
			
		
		</td>
	</tr>
</table>
<?php
	$statusInfo = array('未处理','已处理','不做处理','已删除');
?>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>真实姓名</th><td><?=$c['realname']?></td></tr>
<tr><th>邮箱</th><td><?=$c['email']?></td></tr>
<tr><th>电话</th><td><?=$c['phone']?></td></tr>
<tr><th>QQ</th><td><?=$c['qq']?></td></tr>
<tr><th>城市编号</th><td><?=$c['citycode']?></td></tr>
<tr><th>城市信息</th><td><?=$c['cityname']?></td></tr>
<tr><th>详细地址</th><td><?=$c['address']?></td></tr>
<tr><th>留言信息</th><td><?=$c['message']?></td></tr>
<tr><th>状态</th><td><?=$statusInfo[$c['status']]?></td></tr>
<tr><th>留言时间</th><td><?=date('Y-m-d H:i:s',$c['dateline'])?></td></tr>
<tr><th>处理时间</th><td><?php if($c['verifidateline']>0){echo date('Y-m-d H:i:s',$c['verifidateline']);}?></td></tr>
</table><div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick="window.location='/admin/cloudnote.html'">
</div><br>
</body>
<?php $this->display('admin/footer');?>