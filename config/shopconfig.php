<?php
$shopbase = 'http://shop.ebh.net/api';
$shopconfig =array(
	'address_list_url' => $shopbase.'/address/lists.html',//获取收货地址列表接口地址
	'address_operation_url' => $shopbase.'/address/operation.html',//收货地址添加更新操作接口地址
	'address_del_url' => $shopbase.'/address/del.html',//收货地址删除接口地址
	'address_detail_url' => $shopbase.'/address/getAddress.html',//获取收货地址详情接口地址
	'goods_operation_url' => $shopbase.'/goods/operation.html',//商品发布修改接口地址
	'goods_list_url' => $shopbase.'/goods/lists.html',//获取商品列表接口地址
	'goods_updatestatus_url' => $shopbase.'/goods/updatestatus.html',//商品上架下架操作接口地址
	'goods_detail_url' => $shopbase.'/goods/detail.html',//获取商品详情接口地址
	'goods_taglist_url' => $shopbase.'/goods/taglist.html',//获取商品标签列表接口地址
	'order_list_url' => $shopbase.'/orders/lists.html',//获取订单列表接口地址
	'order_detail_url' => $shopbase.'/orders/detail.html',//获取订单详情接口地址
	'order_close_url' => $shopbase.'/orders/closeorder.html',//关闭交易接口地址
	'order_confirm_url' => $shopbase.'/orders/confirm.html',//确认收货接口地址
	'order_modifyorder_url' => $shopbase.'/orders/modifyOrder.html',//修改订单接口地址
	'order_conreceipt_url' => $shopbase.'/orders/conreceipt.html',//确认收货，获取订单详情接口地址
	'order_check_url' => $shopbase.'/orders/checkPpassword.html',//确认支付密码接口地址
	'order_conreceiptorder_url' => $shopbase.'/orders/conreceiptOrder.html',//确认支付接口地址
	'order_sell_url' => $shopbase.'/orders/sellManage.html',//获取销售统计列表接口地址
	'order_getdetail_url' => $shopbase.'/orders/getOrderDetail.html',//获取订单详情接口地址
	'order_checkstatus_url' => $shopbase.'/orders/checkOrderStatus.html',//检查订单状态接口地址
	'order_logistic_url' => $shopbase.'/orders/getLogisticList.html',//获取物流公司接口地址
	'order_update_url' => $shopbase.'/orders/updateOrder.html',//更新订单状态接口地址
	'baseurl' => 'http://shop.ebh.net'//商城地址
);
return $shopconfig;