<?php $this->display('mall/header') ?>
<body>
<div class="buygoods">
	<div class="buygoodson">
    	<div class="delivery-title">确认收货</div>
        <div class="buygoodslist">
        <?php if(!empty($orderlist)){?>
        	<table cellpadding="0" cellspacing="0" class="goodstable mt25">
            	<tr>
                	<th width="402" colspan="2">商品名称</th>
                	<th width="100">单价</th>
                    <th width="100">数量</th>
                    <th width="100">状态</th>
                    <th width="100">运送费</th>
                    <th width="100">总价</th>
                </tr>
                <?php foreach ($orderlist as $key => $list) { ?>
                <tr>
                	<td>
						<img src="<?=$list['cover'];?>" class="goodscover" width="80" height="80" />
                    </td>
					<td><p class="goodsint"><?=$list['gname'];?></p></td>
                	<td>￥<?=$list['price'];?></td>
                    <td><?=$list['quantity'];?></td>
                    <td><?=$list['type'] == 2 ? '已发货': '';?></td>
                    <?php if($key == 0){?>
                    <td colspan = "<?=count($orderlist)?>">￥<?=$list['freight'];?></td>
                    <td colspan = "<?=count($orderlist)?>">￥<?=$list['totalfee'];?></td>
                    <?php }?>
                </tr>
                <?php }?>
            </table>
        <?php }?>
            <div class="receivinginformation">
            	<span class="receinfspan">订单号：</span>
                <span><?=$orderlist[0]['ordernum'];?></span>
                <span class="ml20">成交时间：</span>
                <span><?=date('Y-m-d H:i:s',$orderlist[0]['paytime'])?></span>
            </div>
            <div class="receivinginformation">
            	<span class="receinfspan">卖家用户名：</span>
                <span><?=empty($user['realname']) ? $user['username'] : $user['realname'];?></span>
                <a href="javascript:void(0)" class="contact-seller">联系卖家</a>
            </div>
            <div class="receivinginformation">
            	<span class="receinfspan">收货信息：</span>
                <span><?=$address['fulladdress'];?>&nbsp;&nbsp;<?=$address['consignee'];?>收&nbsp;&nbsp;<?=$address['mobile'];?></span>
            </div>
            <div class="receivinginformation">
            	<span class="receinfspan red">请收到货后，</span>
                <span class="red">再确认收货！否则您将钱货两空！</span>
            </div>
            <div class="receivinginformation">
            	<span class="receinfspan fl">请输入平台支付密码：</span>
                <div class="fl platformpassword">
                	<input type="password" class="passwordinputs" maxlength="1" />
                    <input type="password" class="passwordinputs" maxlength="1"/>
                    <input type="password" class="passwordinputs" maxlength="1"/>
                    <input type="password" class="passwordinputs" maxlength="1"/>
                    <input type="password" class="passwordinputs" maxlength="1"/>
                    <input type="password" class="passwordinputs" maxlength="1" style="border-right:none;" />
                </div>
                <a href="javascript:void(0)" class="passwordforget">忘记密码？</a>
                <a href="javascript:void(0)" class="passwordforget whatis">
                什么是平台密码？
                <div class="passwordplatm" style="display:none;" >平台支付密码是在买家在收到货物后付款输入的密码，为了保护买家的资金安全，买家填写后方可以将钱打入到卖家账户中。</div>
                </a>
            </div>
            <div class="clear"></div>
            <div class="receivinginformation">
            	<span class="receinfspan"></span>
                <input type="checkbox" id="box" />
                <label for="box">我已经同意<a href="javascript:void(0)" class="passwordforget padd0">《网校商城服务协议》</a></label>
            </div>
            <div class="receivinginformation">
            	<span class="receinfspan"></span>
                <a href="javascript:void(0)" class="confirmpayment">确认付款</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(".platformpassword input").each(function(){
    var that = $(this);
    that.keydown(function(oEvent){
        if(oEvent.keyCode == 8){
            setTimeout(function(){focuspre(that)},5);
        }else{
            setTimeout(function(){focusnext(that)},5);
        }
    });
});
//选中下一个密码框
function focusnext(obj){
    if(obj.val() != ''){
        obj.next('input').focus();
    }
}
//密码框删除键
function focuspre(obj){
    if(obj.val() == ''){
        obj.prev('input').focus();
    }
}
$(function(){
    if($("#box").is(':checked')){
        $(".confirmpayment").removeClass('unconfirmpayment');
    }else{
        $(".confirmpayment").addClass('unconfirmpayment');
    }
    $("#box").on('change',function(){
        if($("#box").is(':checked')){
            $(".confirmpayment").removeClass('unconfirmpayment');
        }else{
            $(".confirmpayment").addClass('unconfirmpayment');
        }
    })
})
$(".whatis").on('click',function(){
    $(".passwordplatm").show();
})
var flag = true;
$(".confirmpayment").on('click',function(){
    var ppassword = '';
    $(".platformpassword input").each(function(){
        ppassword+=$(this).val();
    });
    if(ppassword.length < 6){
        return;
    }
    if($("#box").is(":checked")){
        if(flag == true){
            flag = false;
            var ordernum = <?=$ordernum?>;
            $.ajax({
                url:'/mall/order/conreceiptOrder.html',
                dataType:'json',
                type:'post',
                data:{ordernum:ordernum,ppassword:ppassword},
                success:function(res){
                    if(res.status){
                        
                    }
                }
            })
        }
    }
})
</script>
<?php $this->display('mall/footer') ?>
