<?php $this->display('college/room_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/shop/css/shopmall.css"/>

<body>
<div class="buygoods">
	<div class="buygoodson">
    	<div class="orderdetails">查看</div>
        <div class="buygoodslist">
        <?php if(!empty($orderlist)){?>
			<table cellpadding="0" cellspacing="0" class="goodstable w950">
                <tr>
                    <th width="20%">序号</th>
                    <th width="30%">商品名称</th>
                    <th width="20%">金额</th>
                    <th width="15%">数量</th>
                    <th width="15%">卖家真实姓名</th>
                </tr>
                <?php foreach ($orderlist as $key => $list) {?>
                <tr>
                    <td><?=$key+1;?></td>
                    <td style="text-align:left;"><?=$list->gname;?></td> 
                    <td>￥<?=$list->price;?></td>
                    <td><?=$list->quantity;?></td>
                    <td><?= empty($list->realname) ? $list->username :$list->realname;?></td>
                </tr>
                <?php }?>
            </table>
            <?php }?>
        </div>
    </div>
</div>
<?php $this->display('mall/footer') ?>
