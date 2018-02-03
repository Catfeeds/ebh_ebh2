<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/easyui/themes/default/easyui.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/locale/easyui-lang-zh_CN.js"></script>

					<div class="ter_tit">
						当前位置 > <a href="<?= geturl('troom/student') ?>">学员管理</a> > 开通统计
					</div>
					<div class="lefrig">
<div class="annotate">在此页面中,教师可对申请加入您教室的学员进行管理。</div>
<div class="work_menuss">
			<ul>
				<li style="margin-left:45px;"><a href="<?= geturl('troom/student') ?>"><span>所有学员</span></a></li>
				<li ><a href="<?= geturl('troom/student/check') ?>"><span>学员审核</span></a></li>
				<li class="workcurrent"><a href="<?= geturl('troom/student/opencount') ?>"><span>开通统计</span></a></li>
			</ul>
</div>
<form method="get" name="listform" id="theform" >
<div class="jizhong">
<div class="tiezis_search">
<table>
<tr>
	<td><label>会员/卡号：</label></td>
	<td><input type="text" name="q" id="keyword" value="<?= $q ?>" style="width:105px" /></td>
	<td><label>开通方式：</label></td>
	<td>
	<span id="sele">
		<select  name="payfrom" id="payfrom" >
			<option value="">开通方式</option>
			<option value="1" <?= $payfrom == 1 ? 'selected="selected"' : ''?>>年卡开通</option>
			<option value="2" <?= $payfrom == 2 ? 'selected="selected"' : ''?>>快钱开通</option>
			<option value="3" <?= $payfrom == 3 ? 'selected="selected"' : ''?>>支付宝开通</option>
		</select>
	</span>
	</td>
	<td ><label>开通时间：</label></td>
	<td>
	<input name="begintime" id="stardateline" class="easyui-datebox" style="width:100px" value="<?=$begintime ?>"/><span>-</span>
	<input name="endtime" id="enddateline" class="easyui-datebox" style="width:100px" value="<?=$endtime ?>"/>
	
	</td>
	<td>
	<a onclick="serc()"  class="souhuang" type="submit" name="listsubmit" value="" >搜 索</a>

	</td>
</tr>

</table>
</form>
</div>
</div>
<table width="100%" class="datatab">
	<thead class="tabhead">
	
	  <tr>
		<th style="text-align:center">会员</th>
		<th style="text-align:center">开通时长</th>
		<th style="text-align:center">订单号/卡号</th>
		<th style="text-align:center">开通方式</th>
		<th style="text-align:center">开通时间</th>
	  </tr>
	 </thead>
	 
         <?php if(!empty($myopenlist)) { ?>
	 <tbody>

<?php foreach($myopenlist as $myopen) { 
    $payname = '';
    if($myopen['payfrom'] == 1) 
        $payname = '年卡开通';
    else if($myopen['payfrom'] == 2) 
        $payname = '快钱开通';
    else
        $payname = '支付宝';
    ?>
	 <tr>
			<td width="25%" align="center"><?= $myopen['username'] ?></td>
			<td width="10%" align="center"><?= $myopen['addtime'] ?>个月</td>
			<td width="25%" align="center"><?= $myopen['ordernumber'] ?></td>
			<td class="money" align="center" width="20%"><?= $payname ?></td>
			<td align="center" width="20%"><?= !empty($myopen['dateline'])?date('Y-m-d H:i:s',$myopen['dateline']):''?></td>
		</tr>
<?php } ?>             

         <?php } else { ?>
		 <tr><td colspan="9" align="center">暂 无 数 据</td></tr>

         <?php }?>
		</tbody>
</table>
</div>
</br>

<?= $pagestr ?>
<script type="text/javascript">
function serc(){
    var param = $("#theform").serialize();
    var url = '<?= geturl('troom/student/opencount')?>'+"?"+param;
    window.location.href=url;
}
//-->
</script>
<?php $this->display('troom/page_footer'); ?>