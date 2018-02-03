<?php 
	$this->display('admin/header');
?>
<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">代理商管理 -  代理商详情</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/agent.html">浏览代理商</a></td>
            <td ><a href="/admin/agent/add.html" class="add">添加代理商</a></td>
            <td ><a href="/admin/agent/batchadd.html" class="add">批量生成代理商</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>登录名</th><td><?=$oneAgent['username']?></td></tr>
<tr><th>合同编号</th><td><?=$oneAgent['contractno']?></td></tr>
<tr><th>上级代理</th><td><?=$agentname?></td></tr>
<tr><th>开始代理时间</th><td><?=date('Y-m-d',$oneAgent['agentdate'])?></td></tr>
</table>



<div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="/admin/agent.html"'>
<br />

<?
	$this->display('admin/footer');
?>