<?php $this->display('admin/header');?>
<link rel="stylesheet" href="http://js.ebh.net/static/css/content.css">
<script type="text/javascript">
$(function(){
	//鼠标经过变色
	$('.tablist table tr').unbind();
});
//-->
</script>
<body>
<?php $payfrom = array('全部','支付宝','微信支付','农业银行','中国银联');?>
<div class="tabcones">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="4" style="color:#075587;text-align:center;" class="tabtit">订单支付信息</td></tr>
  <tr>
    <td class="txtlft">订单名称：</td>
    <td><?=$order['ordername']?></td>
    <td class="txtlft">订单卡号：</td>
    <td><?=!empty($order['ordernumber'])?$order['ordernumber']:"无"?></td>    
  </tr>
  <tr>
    <td class="txtlft">付款时间：</td>
    <td><?=!empty($order['paytime']) ? date("Y-m-d H:i:s",$order['paytime']) : '无'?></td>    
    <td class="txtlft">账号：</td>
    <td><?=$order['username']?></td>    
  </tr>
 <tr>
    <td class="txtlft">真实姓名：</td>
    <td><?=!empty($order['realname'])?$order['realname']:"无"?></td>    
    <td class="txtlft">支付方式：</td>
    <td><?=$payfrom[$order['payfrom']]?></td>    
  </tr>
  <tr>
    <td class="txtlft">金额(元)：</td>
    <td><?=$order['totalfee']?></td>    
    <td class="txtlft">所属网校：</td>
    <td><?=$order['crname']?></td>    
  </tr>
  <tr>
    <td class="txtlft">下单ip：</td>
    <td><?=$order['ip']?></td>    
    <td class="txtlft">支付ip：</td>
    <td><?=$order['payip']?></td>    
  </tr>
  <tr>
    <td class="txtlft">备注：</td>
    <td colspan="3"><?=$order['remark']?></td>    
  </tr>
  <tr><td colspan="4" align="center"><input type="button"  value="关闭" class="combtn cbtn_4 form_submit"/></td></tr>		 
 </table>
</div>
</body>
<script type="text/javascript">
$(function(){
	$(".form_submit").click(function(){
		parent.window.rmorderview();
	});
	
})
</script>
</html>    