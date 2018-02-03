<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>权限管理 - 操作管理</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/operation.html">浏览操作</a></td>
			<td ><a href="/admin/operation/add.html" class="add">添加操作</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
<li>操作值采用二进制编码方式，即2的n次方递增编码。</li>
</ul></td></tr></table>
<form method="post" name="listform" id="theform" action="" onsubmit="return listsubmitconfirm(this)">
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tbody class="operationbody"><tr>
<th>序号</th>
<th fieldname="i.opid">操作码</th>
<th fieldname="i.opid">二进制码</th>
<th fieldname="i.opcode">操作标识</th>
<th fieldname="i.opname">操作名称</th>
<th fieldname="i.description">说明</th>
<th fieldname="i.iscredit">积分操作</th>
<th fieldname="i.position" width="15%">适用位置</th>
<th width="5%">操作</th>
</tr>
<?php 
 	$iscredittoop=array('','加分','减分');

?>
<?php foreach($opList as $k=>$v){?>
<tr class="tr_operation" />
<th class="sn"><?=$k+1?></th>
<td class="sn"><?=$v['opid']?></td>
<td class="sn"><?=str_pad(decbin($v['opid']),31,0,STR_PAD_LEFT)?></td>
<td class="opcode"><?=$v['opcode']?></td>
<td class="opname"><?=$v['opname']?></td>
<td class="description"><?=$v['description']?></td>
<td class="sn"><font><?=$iscredittoop[$v['iscredit']]?></font></td>
<td class="sn">
<input type="checkbox" name="opvalue[]" disabled="true" value="1" <?php if($v['position']&1){echo 'checked=checked';}?> >前台
<input type="checkbox" name="opvalue[]" disabled="true" value="2" <?php if($v['position']&2){echo 'checked=checked';}?> >后台
<input type="checkbox" name="opvalue[]" disabled="true" value="4" <?php if($v['position']&4){echo 'checked=checked';}?> >系统
</td>
<td class="sn">[<a href="/admin/operation/add.html?op=edit&opid=<?=$v['opid']?>">编辑</a>]</td>
</tr>
<?php }?>
</tbody>
</table>
</form><br>
</body>


<?php $this->display('admin/footer');?>