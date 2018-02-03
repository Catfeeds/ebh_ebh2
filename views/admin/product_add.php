<?php 
  $this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">产品管理 -  添加产品</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/product.html">浏览产品</a></td>
			<td  class="active"><a href="/admin/product/add.html" class="add">添加产品</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/product/handle.html" onsubmit="return $(this).form('validate')">
  <input type="hidden" name="op" value="<?=$op?>">
  <input type="hidden" name="productid" value="<?=$productid?>">

<style type="text/css">
body{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin-left:20px;}
strong{font-size:12px;}
aink{color:#0066CC;}
a:hover{color:#FF6600;}
aisited{color:#003366;}
a:active{color:#9DCC00;}
</style>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
  <th>产品号<em>*</em></th>
  <td><input type="text" class="w300" name="productno" id="productno"  maxlength="25" value="<?=$product['productno']?>"   onblur=""  ></input></td>
</tr>
<tr>
  <th>产品名称<em>*</em></th>
  <td><input type="text" class="w300" name="productname" id="productname"  maxlength="25" value="<?=$product['productname']?>"   onblur=""  ></input></td>
</tr>
<tr>
  <th>品牌名称</th>
  <td><input type="text" class="w300" name="brand"   maxlength="25" value="<?=$product['brand']?>"></input></td>
</tr>
<tr>
  <th>礼品规格</th>
  <td><input type="text" class="w300" name="specification"   maxlength="25" value="<?=$product['specification']?>"></input></td>
</tr>
<tr>
  <th>供应商名称</th>
  <td><input type="text" class="w300" name="vendorname"   maxlength="25" value="<?=$product['vendorname']?>"></input>
  </td>
</tr>
<tr>
  <th>工厂名称</th>
  <td><input type="text" class="w300" name="factoryname"   maxlength="25" value="<?=$product['factoryname']?>"></input></td>
</tr>
<tr>
  <th>原价<em>*</em></th>
  <td><input type="text" class="w300" name="marketprice" id="marketprice"  maxlength="25" value="<?=$product['marketprice']?>"   onblur=""  ></input></td>
</tr>
<tr>
  <th>会员价格<em>*</em></th>
  <td><input type="text" class="w300" name="memberprice" id="memberprice"  maxlength="25" value="<?=$product['memberprice']?>"   onblur=""  ></input></td>
</tr>
<tr><th>兑换积分<em>*</em></th>
  <td><input type="text" class="w300" name="credit" id="credit"   maxlength="25" value="<?=$product['credit']?>"   onblur=""  ></input></td>
</tr>
<tr><th>重量</th><td><input type="text" class="w300" name="weight"   maxlength="25" value="<?=$product['weight']?>"></input></td></tr>
<tr><th>销售数量</th><td><input type="text" class="w300" name="sellqty" id="sellqty"  maxlength="25" value="<?=$product['sellqty']?>"></input></td></tr>

<tr>
  <th>库存数量<em>*</em><p>产品库存数量。</p></th>
  <td><input type="text"  class="w300" name="stockqty" id="stockqty" value="<?=$product['stockqty']?>"   onblur=""  ></input></td>
</tr>
<tr>
  <th>库存量<p>库存量。</p></th>
  <td><input type="text" class="w300" name="stockmin"  value="<?=$product['stockmin']?>"></input></td>
</tr>
<tr>
  <th>产品颜色</th>
  <td><input type="text" class="w300" name="color"   maxlength="25" value="<?=$product['color']?>" /></td>
</tr>

<tr>
  <th>投放时间<p>即该产品投放的时间段，如果不指定投放时间段，则一直投放。</p></th>
  <td>从 <input type="text" id="dateline" name="dateline" class="w100" onfocus="$(this).datebox({showSeconds:false});" value="<?php $product['begintime']=empty($product['begintime'])?time():$product['begintime']; echo date('Y-m-d',$product['begintime']);?>" /> 开始到 <input type="text" id="endtime" name="endtime"   class="w100" onfocus="$(this).datebox({showSeconds:false});" onchange="" value="<?php $product['endtime']=empty($product['endtime'])?time():$product['endtime']; echo date('Y-m-d',$product['endtime']);?>" /> 结束</td>
</tr>
<tr>
<th>新品级别</th>
<td> <input type="radio" name="new" value="0" checked />非新品</input>
 <input type="radio" name="new" value="1"  <?php if($product['new']==1)echo 'checked=checked';?> />新品Ⅰ</input>
 <input type="radio" name="new" value="2"  <?php if($product['new']==2)echo 'checked=checked';?> />新品Ⅱ</input>
 <input type="radio" name="new" value="3"  <?php if($product['new']==3)echo 'checked=checked';?>/>新品Ⅲ</input>
</td></tr>                                                                                                          
 <tr><th>热卖级别</th><td>
 <input type="radio" name="hot" value="0" checked />非热卖</input>
 <input type="radio" name="hot" value="1"  <?php if($product['hot']==1)echo 'checked=checked';?> />热卖Ⅰ</input>
 <input type="radio" name="hot" value="2"  <?php if($product['hot']==2)echo 'checked=checked';?> />热卖Ⅱ</input>
 <input type="radio" name="hot" value="3"  <?php if($product['hot']==3)echo 'checked=checked';?> />热卖Ⅲ</input>
 </td></tr> 
<tr><th>特性</th><td><input type="text" class="w300" name="special"   maxlength="25" value="<?=$product['special']?>"></input></td></tr>

<tr><th>产品图片<em></em><p>请将产品图片上传</p></th><td>
<?php
  if(empty($product['image'])){
    $Upcontrol->upcontrol('image',1,null,'pic');
  }else{
    $Upcontrol->upcontrol('image',1,array('upfilepath'=>$product['image']),'pic');
  }
?>
</td></tr>

<tr><th>产品简介<p>请输入产品的简介信息。</p></th>
    <td colspan="2" style="padding: 0;">
       <textarea class="p98" name="summary" id="summary"><?=$product['summary']?></textarea>
    </td>
</tr>
<tr>
  <th>产品详细介绍<p>请输入产品的详细介绍资料。</p></th>
  <td>
    
    <?php $editor->createEditor('message',"100%",'300px',$product['message']); ?>
    <font style="color: green;">&nbsp;&nbsp;&nbsp;&nbsp;</font>
  </td>
</tr>
<tr>
  <th>排序号<em>*</em><p>请输入此产品的排序号，越小越靠前,默认为0</p></th>
  <td><input type="text" class="w300" name="displayorder" id="displayorder"  maxlength="25" value="<?=$product['displayorder']?>"   onblur=""  ></input></td>
</tr>
<tr>
  <th>类型<em></em></th>
  <td>
    <select id="type" name="type"  onblur=""  >
      <option value=""  selected=selected>请选择</option>
      <option value="0"  <?php if($product['type']==='0')echo 'selected=selected';?> >实物产品</option>
      <option value="1"  <?php if($product['type']==='1')echo 'selected=selected';?> >虚拟产品</option>
    </select>
  </td>
</tr>
<tr>
  <th id="setcrid">所属电子教室编号</th>
  <td>
    <?php $this->widget('classroom_widget',array('selected'=>$product['crid'])); ?>
  </td>
</tr>

<tr>
  <th>开通天数</th>
  <td><input type="text" class="w300" name="days"   maxlength="25" value="<?=$product['days']?>"   onblur=""  ></input></td></tr>
<tr>
  <th>状态<em>*</em></th>
<td>  
 <input type="radio" name="status" value="0" <?php if($product['status']==0)echo 'checked=checked';?> />正常</input>
 <input type="radio" name="status" value="1" <?php if($product['status']==1)echo 'checked=checked';?> />下架</input>
 <input type="radio" name="status" value="-1" <?php if($product['status']==-1)echo 'checked=checked';?> />已删除</input>
</td></tr>
</table>
<script type="text/javascript">

</script>
<div id="dialog"></div><div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div>
</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
<script type="text/javascript">
  $.extend($.fn.validatebox.defaults.rules, {    
    price: {    
        validator: function(value, param){    
            return /^\d+(\.\d{2})?$/.test(value);    
        },    
        message: '价格格式不对!'   
    },
    number: {
        validator: function(value,param){
          return /^\d+$/.test(value);
        }
    }    
  }); 
  $(function(){
    $(":input").blur(function(){
      $(this).val($.trim($(this).val()));
    });
    $("#dateline,#endtime").trigger('focus');
  });

  $('#productno').validatebox({    
    required: true,    
    validType: 'length[2,50]',
    missingMessage:'商品编号不能为空',
    invalidMessage:'请填写2-50个文字'
  });
  $('#productname').validatebox({    
    required: true,    
    validType: 'length[2,50]',
    missingMessage:'商品名称不能为空',
    invalidMessage:'请填写2-50个文字'
  }); 
  $("#marketprice,#memberprice").validatebox({
    required: true,
    validType :'price',
    missingMessage:'价格不能为空'
  });
  $('#credit').validatebox({    
    required: true,    
    validType: 'number',
    missingMessage:'积分不能为空',
    invalidMessage:'积分类型错误，积分必须为正整数'
  }); 
  $('#stockqty').validatebox({
    required: true,
    validType: 'number',
    missingMessage:'数量不能为空',
    invalidMessage:'数量类型错误，数量必须为数字'
  });
  $('#displayorder').validatebox({
    required: true,
    validType: 'number',
    missingMessage:'排序不能为空',
    invalidMessage:'排序必须为非负整数'
  });

</script>
<?php 
  $this->display('admin/footer');
?>