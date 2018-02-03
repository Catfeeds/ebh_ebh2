<?php 
  $this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1 style="width:550px;">产品管理 -  查看产品</h1></td>
    <td class="actions" >
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
      <tr>
      <td ><a href="/admin/product.html">浏览产品</a></td>
      <td ><a href="/admin/product/add.html" class="add">添加产品</a></td>
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
<br /><br />


<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>产品号</th><td><?=$p['productno']?></td></tr>
<tr><th>产品号</th><td><?=$p['productname']?></td></tr>
<tr><th>品牌名称</th><td><?=$p['brand']?></td></tr>
<tr><th>礼品规格</th><td><?=$p['specification']?></td></tr>
<tr><th>供应商名称</th><?=$p['vendorname']?><td></td></tr>
<tr><th>工厂名称</th><td><?=$p['factoryname']?></td></tr>
<tr><th>原价</th><td><?=$p['marketprice']?></td></tr>

<tr><th>会员价格</th><td><?=$p['memberprice']?></td></tr>
<tr><th>兑换积分</th><td><?=$p['credit']?></td></tr>
<tr><th>重量</th><td><?=$p['weight']?></td></tr>
<tr><th>销售数量</th><td><?=$p['sellqty']?></td></tr>
<tr><th>库存数量</th><td><?=$p['stockmin']?></td></tr>
<tr><th>库存量</th><td><?=$p['stockmin']?></td></tr>
<tr><th>产品颜色</th><td><?=$p['color']?></td></tr>
<tr><th>添加时间</th><td><?php echo date('Y-m-d',$p['dateline'])?></td></tr>
<tr><th>结束时间</th><td><?php echo date('Y-m-d',$p['endtime'])?></td></tr>
<tr><th>查看数</th><td><?=$p['viewnum']?></td></tr>
<tr><th>新品级别</th><td><?=$p['new']?></td></tr>
<tr><th>热卖级别</th><td><?=$p['hot']?></td></tr>
<tr><th>特性</th><td><?=$p['special']?></td></tr>
<tr><th>排序号</th><td><?=$p['displayorder']?></td></tr>
<tr><th>类型</th><td><?php if($p['type']==1){echo '虚拟产品';}else{echo '实物产品';}?></td></tr>
<tr><th>状态</th><td><?php if($p['status']==1){echo '已下架';}elseif($p['status']==-1){echo '已删除';}else{echo '正常';}?></td></tr>
</table>

<div id="dialog"></div><div class="buttons">
<input type="reset"  name="valuereset" value="返回" onclick='window.location.href="/admin/product.html"'>
 
</div>
</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
<?php 
  $this->display('admin/footer');
?>
