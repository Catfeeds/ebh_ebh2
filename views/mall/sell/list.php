<?php $this->display('mall/header') ?>
<body>
<div class="buygoods">
	<div class="buygoodson">
		<div class="work_menu delivery-title" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">销售管理</span></a></li>
			</ul>
			<span class="red"  style="*margin-top:-40px;">佣金按商品金额的 <?=empty($fee) ? 6 : $fee?>% 进行收取</span>
		</div>
        <div class="clear"></div>
            <div class="buygoodsearchitem fontsize14" style="margin-left:30px;">
                <span>订单编号</span>
                <input type="text" class="nameinput" value="<?=empty($q)? '' : $q;?>" />
                <span class="ml50">支付方式</span>
                <div class="statusorder-1 fl">
                <?php if($payfrom == 0){?>
                    <div class="nameinput goodsinput" payfrom="0">全部</div>
                <?php }elseif($payfrom == 3){?>
                    <div class="nameinput goodsinput" payfrom="3">支付宝</div>
                <?php }elseif($payfrom == 8){?>
                    <div class="nameinput goodsinput" payfrom="8">余额</div>
                <?php }else{?>
                    <div class="nameinput goodsinput" payfrom="9">微信</div>
                <?php }?>
                    <div class="statusorderlist" style="display:none;">
                        <ul>
                            <li><a href="javascript:void(0)" payfrom="0">全部</a></li>
                            <li><a href="javascript:void(0)" payfrom="9">微信</a></li>
                            <li><a href="javascript:void(0)" payfrom="3">支付宝</a></li>
                            <li><a href="javascript:void(0)" payfrom="8">余额</a></li>
                        </ul>
                    </div>
                </div>
                <a href="javascript:void(0)" class="goodsordeseach fl">订单搜索</a>
                <p class="paidmoney fr">实收金额总计：<span class="red"><?=empty($totalfee) ? '0' : $totalfee;?>元</span></p>
            </div>
            <div class="clear"></div>
            <div class="buygoodslist">
            <?php if(!empty($orderlist)){?>
                <table cellpadding="0" cellspacing="0" class="goodstable fontsize14 mt20" style="margin-left:30px">

                    <tr>
                        <th width="15%">序号</th>
                        <th width="15%">订单编号</th>
                        <th width="20%">支付方式</th>
                        <th width="18%">交易金额（元）</th>
                        <th width="17%">实际金额（元）</th>
                        <th width="15%">操作</th>
                    </tr>
                    <?php 
                    $total = 0;
                    $totalget = 0;
                    foreach ($orderlist as $key => $list) {
                        $total+= $list->money;
                        $totalget+= $list->profit;
                        ?>
                    <tr>
                        <td><?=$key+1;?></td>
                        <td><?=$list->ordernum;?></td> 
                        <td>
                        <?php 
                        if($list->payfrom == 3){
                            echo '支付宝';
                        }elseif($list->payfrom == 8){
                            echo '余额';
                        }else{
                            echo '微信';
                        }
                        ?>
                        </td>
                        <td><?=$list->money;?></td>
                        <td><?=$list->profit;?></td>
                        <td><a href="javascript:void(0)" class="contactseller" onclick="showdetail(<?=$list->ordernum;?>)">查看</a></td>
                    </tr>
                    <?php }?>
                </table>
                <?php echo $pagestr;?>
                <p class="paidmoney fr paidmoneyw930" style="margin-top:0;">交易金额（总计）：<span class="red"><?=$total;?>元</span>&nbsp;&nbsp;&nbsp;实际金额（总计）：<span class="red"><?=$totalget;?>元</span></p>
                <div class="clear"></div>
                <div class="recordpage" style="margin-top:15px;">
                    <div class="record-1">共<span class="red">&nbsp;<?=$count;?>&nbsp;</span>条记录</div>
                    <!--页码-->
                </div>
                <?php }else{?>
                    <div class="buygoodslist nobuygoods3">很抱歉，没有你要找的订单</div>
                <?php }?>
            </div>
    </div>
</div>
<script type="text/javascript">
$(".goodsinput").on('click',function(){
    $(".statusorderlist").toggle();
})
$(".statusorderlist a").on('click',function(){
    var payfrom = $(this).attr('payfrom');
    var name = $(this).html();
    $(".goodsinput").attr('payfrom',payfrom);
    $(".goodsinput").html(name);
    $(".statusorderlist").toggle();
    $(".goodsordeseach").trigger('click');
})
$(".goodsordeseach").on('click',function(){
    var q = $(".nameinput").val();
    var payfrom = $(".goodsinput").attr('payfrom');
    location.href = '/mall/sell.html?q='+q+'&payfrom='+payfrom;
})
function showdetail(ordernum){
    var url = '/mall/order/detail/'+ordernum+'.html';
    location.href = url;
}
</script>
<?php $this->display('mall/footer') ?>
