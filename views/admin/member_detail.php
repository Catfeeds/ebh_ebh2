<html>

<body>
<style type="text/css">
	.dv-table td{
		border:0;
	}
	.dv-label{
		font-weight:bold;
		color:#15428B;
		width:50px;
	}
</style>
<table class="dv-table" border="0" style="width:100%">
	<tbody>
		<tr>
			<td rowspan="5" style="width:60px">
				<img src="<?php echo $memberdetail['face'];?>" style="width:60px;margin-right:20px" />
			</td>
			<td class="dv-label">用户名:</td>
			<td width="100px"><?php echo $memberdetail['username'];?></td>
			<td class="dv-label">昵称:</td>
			<td width="100px"><?php echo $memberdetail['nickname'];?></td>
			<td class="dv-label">QQ:</td>
			<td width="100px"><?php echo $memberdetail['qq'];?></td>
			<td class="dv-label">出生地:</td>
			<td width="100px"><?php echo $memberdetail['native'];?></td>
		</tr>
		<tr>
			<td class="dv-label">性别:</td>
			<td><?php echo $memberdetail['sex'];?></td>
			<td class="dv-label">手机号码:</td>
			<td><?php echo $memberdetail['mobile'];?></td>
			<td class="dv-label">MSN:</td>
			<td><?php echo $memberdetail['msn'];?></td>
			<td class="dv-label">居住城市:</td>
			<td><?php echo $memberdetail['citycode'];?></td>
		</tr>
		<tr>
			<td class="dv-label">真实姓名:</td>
			<td><?php echo $memberdetail['realname'];?></td>
			<td class="dv-label">电话号码:</td>
			<td><?php echo $memberdetail['phone'];?></td>
			<td class="dv-label">积分:</td>
			<td><?php echo $memberdetail['credit'];?></td>
			<td class="dv-label">详细地址:</td>
			<td><?php echo $memberdetail['address'];?></td>
		</tr>
		<tr>
			<td class="dv-label">出生日期:</td>
			<td><?php echo date('Y-m-d',$memberdetail['birthdate']);?></td>
			<td class="dv-label">电子邮箱:</td>
			<td><?php echo $memberdetail['email'];?></td>
			<td class="dv-label"></td>
			<td></td>
			<td class="dv-label"></td>
			<td></td>
		</tr>
		<tr>
			<td class="dv-label">个人简介:</td>
			<td colspan="8"><?php echo $memberdetail['profile'];?></td>
		</tr>
	</tbody>
</table>
</body>
</html>