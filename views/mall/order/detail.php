<?php $this->display('mall/header') ?>

<body>
<div class="buygoods">
	<div class="buygoodson" style="padding-top:10px">
    	<div class="orderdetails" style="margin:0px">订单详情</div>
        <div class="orderstatus">
            <?php if($order['type'] < 4){ ?>
            	<div class="orderstatus-t">
                	<span class="ordspan1 curr"></span>
                    <span class="ordspan2 <?php if($order['type'] >=1) echo "curr"; ?>"></span>
                    <span class="ordspan3 <?php if($order['type'] >=2) echo "curr"; ?>"></span>
                    <span class="ordspan4 <?php if($order['type'] >=3) echo "curr"; ?>"></span>
                </div>
            	<div class="orderstatus-c">
                    <span class="ordspan1">买家已拍下商品</span>
                    <span class="ordspan2">买家已付款</span>
                    <span class="ordspan3">卖家已发货</span>
                    <span class="ordspan4backnone">买家确认收货</span>
                </div>
            <?php } ?>
            <?php 
                function getStatusInfo($code){
                    switch ($code) {
                        case '0':
                            return '买家已拍下商品';
                            break;
                        case '1':
                            return '买家已付款';
                            break;
                        case '2':
                            return '卖家已发货<span class="span1">请根据物流运单号上网查看物流寄送情况</span>';
                            break;
                        case '3':
                            return '交易成功';
                            break;    
                        case '4':
                            return '退款中';
                            break;    
                        case '5':
                            return '退款成功';
                            break;    
                        case '6':
                            return '交易已关闭';
                            break;    
                        default:
                            # code...
                            break;
                    }
                }
            ?>
            <div class="orderstatus-b">当前订单状态：<?= getStatusInfo($order['type'])?></div>
        </div>
        <?php if($order['type'] == 2 || $order['type'] == 3 ){ ?>
            <div class="buyerinformation">
                <div class="buyerinformation-t">物流信息</div>
                <div class="buyerinformation-b">
                    <p class="buyeraddress"><span>发货方式：</span><?= $order['delivery'] == 1 ? '快递':'当面' ?>
					<?php if($order['delivery'] == 1){?>
					<span class="ml50">物流公司：</span><?= $order['logistic'] ?><span class="ml50">运单号：</span><?= $order['express'] ?></p>
					<?php }?>
                    <div class="buyeraddress">
                        <span class="fl">备注：</span>
                        <div class="fl remarks-1">
                            <?php if(!empty($order['remark'])) {?>
                                <a href="javascript:void(0)" class="contactseller textunder">详情展开</a>
                            <?php } ?>
                            <div class="noteinformation" style="display:none;">
                                <?= $order['remark'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        <?php } ?>    
        <div class="buyerinformation">
        	<div class="buyerinformation-t">买家信息</div>
            <div class="buyerinformation-b">
            <?php if(!$order['customer']['uid'] != $user['uid']){?>
            	<p class="buyeraddress"><span style="letter-spacing: 4px;">用户名：</span><?= getusername($order['customer']); ?></p>
            <?php }?>
            	<p class="buyeraddress"><span>收货地址：</span><?= $order['customer']['consignee'].','.$order['customer']['mobile'].','.$order['customer']['address'];?></p>
            <?php if(!$order['customer']['uid'] != $user['uid']){/*?>
                <p class="buyeraddress"><span>买家留言：</span><?= $order['customer']['remark'] ?></p>
            <?php */}?>
            </div>
        </div>
        <?php if($user['uid'] != $order['seller']['uid']){?>
        <div class="buyerinformation">
        	<div class="buyerinformation-t">卖家信息</div>
            <div class="buyerinformation-b">
				<?php $nosellerinfo = !empty($order['seller']['qq_href'])?FALSE:TRUE?>
            	<p class="buyeraddress"><span>用户名：</span><?= $order['seller']['username'] ?> <a <?= $nosellerinfo ? 'onclick="showDialogWithoutQQ()"' :'target="_blank"' ?> href="<?= $nosellerinfo ? 'javascript:void(0)':$order['seller']['qq_href'] ?>" class="contactseller qqcontent-1 <?= $nosellerinfo ? 'wsq': '' ?>">联系卖家</a> </p>
                <p class="buyeraddress"><span>真实姓名：</span><?= $order['seller']['realname'] ?><span class="ml50">城市：</span><?= $order['seller']['cityname'] ?><span class="ml50">手机号码：</span><?= $order['seller']['mobile'] ?></p>
            </div>
        </div>
        <?php }?>
         <div class="buyerinformation">
        	<div class="buyerinformation-t">订单信息</div>
            <div class="buyerinformation-b">
            	<p class="buyeraddress"><span>订单编号：</span><span class="width150"><?= $order['ordernum'] ?></span><?php if(!empty($order['paycode'])){ ?><span>交易号：</span><span class="width250"><?= $order['paycode'] ?></span><?php } ?><span>创建时间：</span><?= date("Y-m-d",$order['dateline'])?>&nbsp;<?=  date("H:i:s",$order['dateline']) ?></p>
            </div>
            <table cellpadding="0" cellspacing="0" class="goodstable goodstablew768">
            	<tr>
                	<th width="362" class="fontsize16" colspan="2">商品信息</th>
                    <th width="100">单价</th>
                    <th width="100">数量</th>
                    <th width="100">交易状态</th>
                    <th width="100">总价</th>
                </tr>
                <?php if($order['is_real'] == 1){ ?>
                    <?php foreach ($order['details'] as $goods) { ?>
                        <tr>
                        	<td style="border-right:none;width:100px;">
        						<img src="<?= $goods['img'] ?>" class="goodscover" width="80" height="45" />
                            </td>
							<td><p class="goodsint"><?= $goods['gname'] ?></p></td>
                            <td>￥<?= $goods['price'] ?></td>
                            <td><?= $goods['quantity'] ?></td>
                            <td><?= getStatusInfo($order['type'])?></td>
                            <td>￥<?= $goods['totalprice'] ?></td>
                        </tr>
                    <?php } ?>
                <?php }else{ ?>
                    <?php foreach ($order['details'] as $goods) { ?>
                       <tr>
                            <td style="border-right:none;width:100px;">
                                <img src="<?= $goods['img'] ?>" class="goodscover" width="80" height="45" />
                            </td>
							<td> <p class="goodsint"><?= $goods['gname'] ?></p></td>
                            <td><?= $goods['iscore'] ?></td>
                            <td><?= $goods['quantity'] ?></td>
                            <td><?= getStatusInfo($order['type'])?></td>
                            <td><?= $goods['totaliscore'] ?><br /><span style="color:#bbb;"></span></td>
                        </tr>
                    <?php } ?>
                <?php } ?> 
            </table>
			<div class="totalfreight">
				总运费：￥<?=$order['freight'];?> <b style="color:#999;font-weight:normal;"></b>
				<div class="freightnote"  style="display:none;"><p>不同卖家订单运费分开计算，购买同一卖家商品，每个订单运费按买家所购买商品运费最高的计算，商品数量≤3运费保持不变，商品数量＞3且≤6时运费*2，以此类推；</p>
<p>案例：A、B、C商品运费为5元、6元、7元，总运费为7元，增加D商品（运费10）时，总运费变为20，即D商品的运费*2；</p></div>
			</div>
			
            <?php if($order['is_real'] == 1){?>
                <div class="totalmoney">订单总金额: <span class="fontsize24"><?= $order['totalfee'] ?></span>元</div>
            <?php }else{ ?>
                <div class="totalmoney">订单总积分: <span class="fontsize24"><?= $order['score'] ?></span></div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    $(function(){
        $(".noteinformation").hide();  // 默认隐藏状态
        $(".textunder").click(function() {
            $(".noteinformation").slideToggle(function(){
				$(window.parent.parent.document.getElementById('mainFrame')).css('height',$('.buygoodson').outerHeight()+'px');
            });  // 改变显隐状态
            $(this).text($(this).text()=="收起"?"详情展开":"收起"); // 改变a的文字说明
        });
    });
	$(function(){
		$(".zyfico").hover(function(){
			$(".freightnote").css("display","block");
		},function(){
			$(".freightnote").css("display","none");
		}); 
	});
	function showDialogWithoutQQ(){
        top.dialog({
            title: "信息提示",
            content: "该卖家未设置QQ通讯组件",
            okValue: "确定",
            ok: function() {
               
            },
            width: "400px"
        }).showModal();
    }

</script>
<?php $this->display('mall/footer') ?>
