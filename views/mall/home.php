<?php $this->display('mall/header') ?>

<body>
<div class="buygoods">
    <div class="buygoodson">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">我的商品管理</span></a></li>
			</ul>
		</div>
        <div class="productmanagement">
			<p class="saleps">卖家管理</p>
            <div class="productmanagement-t">
                <ul>
                    <li>
                        <a class="productmanagementa" href="/mall/goods.html" target="mainFrame"></a>
                        <a class="managementa" href="javascript:void(0)" target="mainFrame">商品管理</a>
                    </li>
                    <li>
                        <a class="ordermanagement" href="/mall/order/all.html"></a>
                        <a class="managementa" href="javascript:void(0)">订单管理</a>
                    </li>
					<li>
                        <a class="salesmanagementa" href="/mall/sell.html" target="mainFrame"></a>
                        <a class="managementa" href="javascript:;" target="mainFrame">销售管理</a>
                    </li>
                </ul>
            </div>
			<p class="saleps">买家管理</p>
            <div class="productmanagement-t productmanagement-b">
                <ul>
                    <li>
                        <a class="iwantobuy" target="_blank" href="http://shop.ebh.net/<?=$roominfo['crid']?>.html"></a>
                        <a class="managementa" href="javascript:void(0)">我要买</a>
                    </li>
                    <li>
                        <a class="purchasedgoods" href="/mall/order/cgeneral.html"></a>
                        <a class="managementa" href="javascript:void(0)">已买到的商品</a>
                    </li>
                    <li>
                        <a class="addressmanagement" href="/mall/address/all.html"></a>
                        <a class="managementa" href="javascript:void(0)">地址管理</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
});
</script>
<?php $this->display('mall/footer') ?>