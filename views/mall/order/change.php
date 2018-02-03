<?php $this->display('mall/header') ?>
<body>
<div class="buygoods">
	<div class="buygoodson">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">修改价格</span></a></li>
			</ul>
		</div>
        <div class="buygoodslist">
        	<p class="originalprice">订单原价（含运费）：<span><?= empty($orderlist) ? 0 : $orderlist[0]['totalfee'];?>元</span></p>
        <?php if(!empty($orderlist)){ ?>
        	<table cellpadding="0" cellspacing="0" class="goodstable">
            	<tr>
                	<th width="340" colspan="2">商品名称</th>
                    <th width="95">单价</th>
                    <th width="95">数量</th>
                    <th width="107">价格调整</th>
                    <th width="80">调整后价格</th>
                    <th width="107">运费</th>
					<th width="78">调整后运费</th>
                </tr>
                <?php foreach ($orderlist as $key => $order) { ?>
                <tr>
                	<td class="tdfirst" width="100">
						<img src="<?=$order['img'];?>" class="goodscover" width="80" height="80" />
                    </td>
					<td class="tdfirst"><p class="goodsint"><?=$order['gname'];?></p></td>
                    <td class="tdfirst">￥<?=$order['price'];?></td>
                    <td class="quantity"><?=$order['quantity'];?></td>
                    <td>
                        <div class="adjustprice">
                            <span class="addico minus" topprice="<?=$order['price'];?>" type="price"></span>
                            <input type="text" gid="<?=$order['gid'];?>" class="pricechange" value="0" topprice="<?=$order['price'];?>" date="price" />
                            <span class="addico add" topprice="<?=$order['price'];?>"></span>
                        </div>
                    </td>
                    <td class="spanblue">￥<span><?=$order['price'];?></span></td>
                    <?php 
                        $total = count($orderlist);
                    ?>
                    <?php if($key == 0){?>
                    <td rowspan="<?= $total ?>">
                        <div class="adjustprice">
                            <span class="addico minus" topprice="<?=$order['freight'];?>" type="freight"></span>
                            <input type="text" class="pricechange" gid="0" value="0" topprice="<?=$order['freight'];?>" date="freight" />
                            <span class="addico add" topprice="<?=$order['freight'];?>"></span>
                        </div>
                    </td>
                    <td rowspan="<?= $total ?>" class="spangreen">￥<span><?=$order['freight'];?></span></td>
                    <?php }?>
                </tr>
                <?php }?>
            </table>
            <p class="fontsize12">收货地址：<?=empty($orderlist) ? '' : $orderlist[0]['address'];?></p>
        <?php }else{?>
            <div class="buygoodslist nobuygoods3">订单失效或不存在</div>
        <?php }?>
            
            <div class="buyerpaid" >
            <?php if(!empty($orderlist)){?>
            	<p class="fontsize12-1 fl">买家实付：
                <?php foreach ($orderlist as $list) { ?>
                <span class="spanblue"><?=$list['price'];?></span>×<?=$list['quantity'];?>+
                <?php }?>
                <span class="spangreen"><?=$orderlist[0]['freight']?></span>=<span style="color:#ffa400;"><?=$orderlist[0]['totalfee'];?></span>元
                </p>
                <p class="totalprice fr">总金额:<span> <?=$orderlist[0]['totalfee'];?>元</span></p>
            </div>
            <div class="clear"></div>
            <a href="javascript:void(0)" class="sumbitedit">提交</a>
            <?php }?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(".minus").on('click',function(){
    var type = $(this).attr('type');
    $(this).removeClass('addico-1');
    var price = $(this).attr('topprice');
    var nowprice = $(this).next().val();
    if(isNaN(nowprice)){
        nowprice = 0;
    }
    nowprice-=1;
    if(type == 'price'){
        if((parseFloat(nowprice) + parseFloat(price)) <= 1){
            nowprice = 1 - price;
            $(this).addClass('addico-1');
        }
    }else{
        if((parseFloat(nowprice) + parseFloat(price)) <= 0){
            nowprice = 0 - price;
            $(this).addClass('addico-1');
        }
    }
    $(this).next().val(changeTwoDecimal_f(nowprice));
    newprice = parseFloat(price) + parseFloat(nowprice);
    $(this).parent().parent().next().html('￥<span>'+changeTwoDecimal_f(newprice)+'</span>');
    getNewMoney();
});
$(".pricechange").on('keyup blur',function(){
    var price = $(this).attr('topprice');
    var nowprice = $(this).val();
    var type = $(this).attr('date');
    if(isNaN(nowprice) && nowprice != '-'){
        nowprice = 0;
        $(this).val(nowprice);
    }
    if(nowprice == '' || nowprice == '-'){
        return false;
    }
    newprice = parseFloat(price) + parseFloat(nowprice);
    if(type == 'price'){
        if(newprice <= 1){
            nowprice = 0;
            $(this).val(changeTwoDecimal_f(nowprice));
            newprice = price;
        }
        if(newprice == 1){
            $(this).prev().addClass('addico-1');
        }
    }else{
        if(newprice < 0){
            nowprice = 0;
            $(this).val(changeTwoDecimal_f(nowprice));
            newprice = price;
        }
        if(newprice == 0){
            $(this).prev().addClass('addico-1');
        }
    }
    $(this).parent().parent().next().html('￥<span>'+changeTwoDecimal_f(newprice)+'</span>');
    getNewMoney();
})
$(".pricechange").on('blur',function(){
    var price = $(this).attr('topprice');
    var nowprice = $(this).val();
    if(nowprice == '' || nowprice == '-'){
        nowprice = 0;
        $(this).val(nowprice);
    }
    newprice = parseFloat(price) + parseFloat(nowprice);
    if(newprice < 0){
        nowprice = 0;
        $(this).val(nowprice);
        newprice = price;
    }
    if(newprice == 0){
        $(this).prev().addClass('addico-1');
    }
    $(this).parent().parent().next().html('￥<span>'+changeTwoDecimal_f(newprice)+'</span>');
    getNewMoney();
})
$(".add").on('click',function(){
    $(this).prev().prev().removeClass('addico-1');
    var price = $(this).attr('topprice');
    var nowprice = $(this).prev().val();
    if(isNaN(nowprice)){
        nowprice = 0;
    }
    nowprice = parseFloat(nowprice) + 1;
    $(this).prev().val(changeTwoDecimal_f(nowprice));
    newprice = parseFloat(price) + parseFloat(nowprice);
    $(this).parent().parent().next().html('￥<span>'+changeTwoDecimal_f(newprice)+'</span>');
    getNewMoney();
})
//保留2位小数
function changeTwoDecimal_f(x) {
    var f_x = parseFloat(x);
    if (isNaN(f_x)) {
        return false;
    }
    var f_x = Math.round(x * 100) / 100;
    var s_x = f_x.toString();
    var pos_decimal = s_x.indexOf('.');
    if (pos_decimal < 0) {
        pos_decimal = s_x.length;
        s_x += '.';
    }
    while (s_x.length <= pos_decimal + 2) {
        s_x += '0';
    }
    return s_x;
}
function getNewMoney(){
    var money = new Array();
    var quantity = new Array();
    var freight = $(".spangreen span").html();
    var total = 0;
    $(".goodstable .spanblue").each(function(){
        money.push($(this).find('span').html());
    })
    $(".quantity").each(function(){
        quantity.push($(this).html());
    })
    var html = '<p class="fontsize12-1 fl">买家实付：';
    $.each(money,function(i,v){
        total+= parseFloat(v*quantity[i]);
        html+= '<span class="spanblue">'+v+'</span>×'+quantity[i]+'+';
    });
    total+= parseFloat(freight);
    total = changeTwoDecimal_f(total);
    html+='<span class="spangreen">'+freight+'</span>';
    html+='=<span style="color:#ffa400;">'+total+'</span>元';
    html+='<p class="totalprice fr">总金额:<span>'+total+'元</span></p>';
    $(".buyerpaid").html(html);
}
$(".sumbitedit").on('click',function(){
    var gid = new Array();
    var price = new Array();
    $(".pricechange").each(function(){
        price.push($(this).val());
        gid.push($(this).attr('gid'));
    });
    var url = '/mall/order/change/<?=$orderid;?>.html';
    $.ajax({
        url:url,
        dataType:'json',
        type:'post',
        data:{gid:gid,price:price},
        success:function(res){
			var content = '';
            if(res.status == true){
                content = '修改成功！';
            } else {
				content = '修改失败！';
			}
			top.dialog({
				id: "abc", //可选
				title: "提示",
				content: content,
				okValue: "确定",
				ok: function() {
					location.href = location.href;
				},
				cancel: false,
				onshow:function(){
					var that=this;
					setTimeout(function () {
					that.close().remove();
					location.href = location.href;
					}, 2500);
				},
				width : "400"
			}).showModal();
			return;
        }
    })
})
</script>
<?php $this->display('mall/footer') ?>
