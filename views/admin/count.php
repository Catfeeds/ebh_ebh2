<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>会员管理 - 会员统计</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active" >会员统计</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="POST" action=<?php echo geturl('admin/count');?> >
<table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
<label>时间：</label>
<?=$yearSelect?>
<input type="submit" name="selectsubmit" value="查询" class="submit">        
</td></tr></table>
</form>
<form method="post" name="listform" id="theform" action="" onsubmit="return listsubmitconfirm(this)">
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable" id="listtable">
<tr>
	<th>统计时间</th>
	<th style="text-align:left;">月份</th>
	<th style="text-align:left;">新增会员数</th>
</tr> 	
<tbody class="adtbody" >
<?php for($i=0;$i<12;$i++){?>
<tr>
<td><?=$countsTime?></td>
<td style="text-align:left;"><?=(1+$i)?></td>
<td style="text-align:left;"><?=$counts[$i]?></td>
</tr>
<?php }?>
</tbody>
<tfoot class="table-merstatistic">
<tr>        
<td><?=$countsTime?></td>
<td style="text-align:left;">总计</td>
<td style="text-align:left;"><?=$total?></td>
</tr>			
</tfoot>
</table></form>
</body>
<?php $this->display('admin/footer');?>