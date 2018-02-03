<?php $this->display('mall/header') ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20161226142863" />
<style>
a:visited{
    color: #5e96f5;
}
</style>


<script type="text/javascript">
/*备注展开隐藏*/
$(function(){
    // 默认隐藏状态
    $(".buygoodtext1").click(function() {
        $(".buygoodsearchitem").slideToggle();  // 改变显隐状态
		 var flag = $(this).hasClass('up');
		 if(flag){
			 $(this).addClass('down');
			 $(this).removeClass('up');
		}else{
			$(this).addClass('up');
			$(this).removeClass('down');
		}
    })
})
</script>
<body>
<?php
    function getOrderScoreStatus($code){
        switch ($code) {
           
            case 1:
                return '待发货';
                break;
            case 2:
                return '待收货';
                break;
            case 3:
                return '交易成功';
                break;          
            default:
                # code...
                break;
        }
    }
    function getOrderStatus($code){
        // ：0待付款，1待发货，2待确认，3交易成功，4退款中，5退款已确认，6交易关闭',
        switch ($code) {
            case 0:
                return '待付款';
                break;
            case 1:
                return '待发货';
                break;
            case 2:
                return '待收货';
                break;
            case 3:
                return '交易成功';
                break;
            case 4:
                return '退款中';
                break;    
			case 5:
                return '退款成功';
				break;
            case 6:
                return '交易关闭';
                break;            
            default:
                # code...
                break;
        }
    }
    function getSelectScoreStatus($code){
        switch ($code) {
            case 0:
                return '全部';
                break;
            case 2:
                return '待发货';
                break;
            case 3:
                return '待收货';
                break;
            case 4:
                return '交易成功';
                break;           
            default:
                # code...
                break;
        }
    }
    function getSelectStatus($code){
        switch ($code) {
            case 0:
                return '全部';
                break;
            case 1:
                return '待付款';
                break;
            case 2:
                return '待发货';
                break;
            case 3:
                return '待收货';
                break;
            case 4:
                return '交易成功';
                break;
            case 7:
                return '交易关闭';
                break;            
            default:
                # code...
                break;
        }
    }
    function timesecondsToStr($time){
        $str = '';
        $timearr = array(86400 => '天', 3600 => '小时', 60 => '分');
        foreach ($timearr as $key => $value) {
            if ($time >= $key)
                $str .= floor($time/$key) . $value;
            $time %= $key;
        }
        return $str;
    }
    function getTimer($time){
        $totaltime = 86400*7*2;
        $pasttime = time()-$time;
        $gaptime = $totaltime-$pasttime;
        $str = timesecondsToStr($gaptime).'到账';
        return $str;
    }
?>
<div class="buygoods">
	<div class="buygoodson">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">订单管理</span></a></li>
			</ul>
			<div class="buygoodstype">
            	<a href="<?= geturl('mall/order/all').'?type=2' ?>" class="first <?php if($type == 2) echo "curr"; ?>">积分商品</a>
                <a href="<?= geturl('mall/order/all').'?type=1' ?>" class="second <?php if($type == 1) echo "curr"; ?>">普通商品</a>
            </div>
		</div>
        <div class="buygoodsearch">
            <div class="goodsnav">
                <?php if($type == 1){?>
                    <ul>
                        <li class="first <?php if($method=='all') echo 'curr'; ?>"><a href="<?= geturl('mall/order/all').'?type='.$type ?>">所有订单</a><span>|</span></li>
                        <li class="<?php if($method=='waitpay') echo 'curr'; ?>"><a href="<?= geturl('mall/order/waitpay').'?type='.$type ?>">待付款</a><span>|</span></li>
                        <li class="<?php if($method=='waitsend') echo 'curr'; ?>"><a href="<?= geturl('mall/order/waitsend').'?type='.$type ?>">待发货</a><span>|</span></li>
                        <li class="<?php if($method=='sended') echo 'curr'; ?>"><a href="<?= geturl('mall/order/sended').'?type='.$type ?>">已发货</a><span>|</span></li>
                        <li class="<?php if($method=='succeed') echo 'curr'; ?>"><a href="<?= geturl('mall/order/succeed').'?type='.$type ?>">交易成功</a><span>|</span></li>
                        <li class="<?php if($method=='closed') echo 'curr'; ?>"><a href="<?= geturl('mall/order/closed').'?type='.$type ?>">交易关闭</a></li>
                    </ul>
                <?php }else{ ?>
                     <ul>
                        <li class="first <?php if($method=='all') echo ' curr'; ?>"><a href="<?= geturl('mall/order/all').'?type='.$type ?>">所有订单</a><span>|</span></li>
                        <li class="<?php if($method=='waitsend') echo 'curr'; ?>"><a href="<?= geturl('mall/order/waitsend').'?type='.$type ?>">待发货</a><span>|</span></li>
                        <li class="<?php if($method=='sended') echo 'curr'; ?>"><a href="<?= geturl('mall/order/sended').'?type='.$type ?>">已发货</a><span>|</span></li>
                        <li class="<?php if($method=='succeed') echo 'curr'; ?>"><a href="<?= geturl('mall/order/succeed').'?type='.$type ?>">交易成功</a></li>
                    </ul>
                <?php } ?>
            </div>
        	<div class="buygoodsearch-1">
                <input type="text" class="buygoodtext" id="nameoroid" name='nameoroid' value="" />
                <input type="button" class="buygoodbutton" value="" />
                <input type="hidden" value="<?= $roominfo['crid'] ?>" name="crid"/>
                <input type="hidden" value="<?= $user['uid'] ?>" name="uid"/>
                <a href="javascript:void(0)" class="buygoodtext1 down">高级</a>
            </div>
            <div class="clear"></div>
            <?php if($type == 1){ ?>
                <div class="buygoodsearchitem" style="<?php if( isset($data['searchtype']) && $data['searchtype']==2) echo "display:block"; else echo "display:none"; ?>">
                	<span>商品名称</span>
                    <input type="text" class="nameinput <?php if(!empty($data['gname'])) echo 'blue'; ?>" name="gname" value="<?php if(!empty($data['gname'])) echo $data['gname']; ?>"/>
                    <span class="ml47">成交时间</span>
                    <input name="sdateline"  style="cursor:pointer;margin-left:8px;" class="nameinput lines closingtime <?php if(!empty($data['sdateline'])) echo 'blue'; ?>" type="text" readonly="readonly" value="<?php if(!empty($data['sdateline'])) echo $data['sdateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <span class="lines">-</span>
                    <input name="edateline"  style="cursor:pointer" class="nameinput lines closingtime <?php if(!empty($data['edateline'])) echo 'blue'; ?>" type="text" readonly="readonly" value="<?php if(!empty($data['edateline'])) echo $data['edateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <span class="ml47">订单编号</span>
                    <input type="text" class="nameinput <?php if(!empty($data['ordernum'])) echo 'blue'; ?>" name="oid" value="<?php if(!empty($data['ordernum'])) echo $data['ordernum']; ?>"/>
                    <div class="clear"></div>
                    <span>买家昵称</span>
                    <input type="text" class="nameinput <?php if(!empty($data['nickname'])) echo 'blue'; ?>" name="nickname" value="<?php if(!empty($data['nickname'])) echo $data['nickname']; ?>"/>
                    <?php if($method == 'all'){ ?>
                        <span class="ml47">订单状态</span>
                        <div class="statusorder-1">
                            <?php if($type == 1){ ?>
                                <div class="nameinput goodsinput <?php if(!empty($data['status'])) echo 'blue'; ?>" data-status="<?php if(!empty($data['status'])) echo $data['status'];else echo 0; ?>"><?= isset($data['status']) ? getSelectStatus($data['status']): '全部'; ?></div>
                                <div class="statusorderlist" style="display:none">
                                	<ul>
                                    	<li data-status="0"><a href="javascript:void(0)">全部</a></li>
                                    	<li data-status="1"><a href="javascript:void(0)">待付款</a></li>
                                        <li data-status="2"><a href="javascript:void(0)">待发货</a></li>
                                        <li data-status="3"><a href="javascript:void(0)">待收货</a></li>
                                        <li data-status="4"><a href="javascript:void(0)">交易成功</a></li>
                                        <li data-status="7"><a href="javascript:void(0)">交易关闭</a></li>
                                    </ul>
                                </div>
                            <?php }else{ ?>
                                <div class="nameinput goodsinput <?php if(!empty($data['status'])) echo 'blue'; ?>" data-status="<?php if(!empty($data['status'])) echo $data['status'];else echo 0; ?>"><?php echo getSelectStatus($data['status']); ?></div>
                                <div class="statusorderlist" style="display:none">
                                    <ul>
                                        <li data-status="0"><a href="javascript:void(0)">全部</a></li>
                                        <li data-status="2"><a href="javascript:void(0)">待发货</a></li>
                                        <li data-status="3"><a href="javascript:void(0)">已发货</a></li>
                                        <li data-status="4"><a href="javascript:void(0)">交易成功</a></li>
                                    </ul>
                                </div>
                            <?php } ?> 
                        </div>
                    <?php } ?>
                    <a href="javascript:void(0)" class="goodsordeseach">订单搜索</a>
                </div>
            <?php }else{ ?>
                <div class="buygoodsearchitem" style="<?php if(isset($data['searchtype']) && $data['searchtype']==2) echo "display:block"; else echo "display:none"; ?>">
                    <span>商品名称</span>
                    <input type="text" class="nameinput <?php if(!empty($data['gname'])) echo 'blue'; ?>" name="gname" value="<?php if(!empty($data['gname'])) echo $data['gname']; ?>"/>
                    <span class="ml47">成交时间</span>
                    <input name="sdateline"  style="cursor:pointer;margin-left:8px;" class="nameinput lines closingtime <?php if(!empty($data['sdateline'])) echo 'blue'; ?>" type="text" readonly="readonly" value="<?php if(!empty($data['sdateline'])) echo $data['sdateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <span class="lines">-</span>
                    <input name="edateline"  style="cursor:pointer" class="nameinput lines closingtime <?php if(!empty($data['edateline'])) echo 'blue'; ?>" type="text" readonly="readonly" value="<?php if(!empty($data['edateline'])) echo $data['edateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <span class="ml47">订单编号</span>
                    <input type="text" class="nameinput <?php if(!empty($data['ordernum'])) echo 'blue'; ?>" name="oid" value="<?php if(!empty($data['ordernum'])) echo $data['ordernum']; ?>"/>
                    <div class="clear"></div>
                    <span>买家昵称</span>
                    <input type="text" class="nameinput <?php if(!empty($data['nickname'])) echo 'blue'; ?>" name="nickname" value="<?php if(!empty($data['nickname'])) echo $data['nickname']; ?>"/>
                    <?php if($method == 'all'){ ?>
                    <span class="ml47">订单状态</span>
                    <div class="statusorder-1">
                        <?php if($type == 1){ ?>
                            <div class="nameinput goodsinput <?php if(!empty($data['status'])) echo 'blue'; ?>" data-status="<?php if(!empty($data['status'])) echo $data['status'];else echo 0; ?>"><?php echo getSelectStatus($data['status']); ?></div>
                            <div class="statusorderlist" style="display:none">
                                <ul>
                                    <li data-status="0"><a href="javascript:void(0)">全部</a></li>
                                    <li data-status="1"><a href="javascript:void(0)">待付款</a></li>
                                    <li data-status="2"><a href="javascript:void(0)">待发货</a></li>
                                    <li data-status="3"><a href="javascript:void(0)">待收货</a></li>
                                    <li data-status="4"><a href="javascript:void(0)">交易成功</a></li>
                                    <li data-status="7"><a href="javascript:void(0)">交易关闭</a></li>
                                </ul>
                            </div>
                        <?php }else{ ?>
                            <div class="nameinput goodsinput <?php if(!empty($data['status'])) echo 'blue'; ?>" data-status="<?php if(!empty($data['status'])) echo $data['status'];else echo 0; ?>"><?= isset($data['status']) ?  getSelectScoreStatus($data['status']) : '全部'; ?></div>
                            <div class="statusorderlist" style="display:none">
                                <ul>
                                    <li data-status="0"><a href="javascript:void(0)">全部</a></li>
                                    <li data-status="2"><a href="javascript:void(0)">待发货</a></li>
                                    <li data-status="3"><a href="javascript:void(0)">已发货</a></li>
                                    <li data-status="4"><a href="javascript:void(0)">交易成功</a></li>
                                </ul>
                            </div>
                        <?php } ?> 
                    </div>
                    <?php } ?>
                    <a href="javascript:void(0)" class="goodsordeseach">订单搜索</a>
                </div>
            <?php } ?>
        </div>
        <div class="clear"></div>
        <?php if(!empty($orders['order'])) { ?>
        <div class="buygoodslist">
            <?php foreach ($orders['order'] as $order) { ?>
                <?php if($type == 1){ ?>
                	<table cellpadding="0" cellspacing="0" class="goodstable">
                    	<tr>
                        	<th width="342" class="thfirst" colspan="2">
                                <span><?= date("Y-m-d H:i:s",$order['dateline']) ?>&nbsp;订单号：<?= $order['ordernum']?></span>
                            </th>
                            <th width="65">单价</th>
                            <th width="65">数量</th>
                            <th width="150">买家</th>
                            <th width="135">交易状态</th>
                            <th width="135">实收款</th>
                        </tr>
                        <tr>
                        	<td class="tdfirst" style="width:100px;">
        						<a target="_blank" href="<?= getgoodsurl($order['details'][0]['crid'], $order['details'][0]['gid'])?>" style='color:black'><img src="<?= $order['details'][0]['img'] ?>" class="goodscover" width="80" height="45" /></a>
                            </td>
							<td class="tdfirst"><p class="goodsint"><a target="_blank" href="<?= getgoodsurl($order['details'][0]['crid'], $order['details'][0]['gid'])?>" style='color:black'><?= $order['details'][0]['gname'] ?></a></p></td>
                            <td class="tdfirst">￥<?php if($order['is_real'] == 1 ) echo $order['details'][0]['price']; else echo $order['details'][0]['score']; ?></td>
                            <td><?= $order['details'][0]['quantity'] ?></td>
                            <td rowspan="<?= count($order['details'])?>">
                            	<img src="<?= empty($order['customer'][0]['face']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg' :$order['customer'][0]['face'] ?>" width="36" height="36" class="headimgaroud" />
                                <p class="buyname"><?= $order['customer'][0]['realname'] ?></p>
                            </td>
                            <td rowspan="<?= count($order['details'])?>" style="<?php if($order['type'] == 3) echo 'position:relative;'; ?>"> 
                            	<span class="<?php if($order['type'] == 3) echo 'showdiv'; ?>" style="<?php if($order['type'] == 6){ echo 'color:#bbb;';} elseif($order['type'] == 1){echo 'color:red;';}?>"><?= getOrderStatus($order['type']) ?></span><br>
                                <a href="/mall/order/detail/<?= $order['ordernum']?>.html" class="contactseller" style="color: rgb(94, 150, 245);">订单详情</a>
                                <?php if($order['type'] == 1){ ?>
                                    <br />
                                    <a href="/mall/shop/delivery/<?= $order['ordernum']?>.html" class="confirmreceipt promptpayment">发货</a>
                                <?php }elseif($order['type'] == 0){ ?>
                                    <br />
                                    <a href="javascript:void(0)" class="contactseller closeorder" data-ordernum="<?= $order['ordernum'] ?>">关闭交易</a>
                                <?php }elseif($order['type'] == 3){ ?>
                                    <div class="closepay red" style="display:none"><?= getTimer($order['paytime']) ?></div>
                                <?php } ?>
                            </td>
                            <td rowspan="<?= count($order['details']) ?>">￥<?php if($order['is_real'] == 1 ) echo $order['totalfee']; else echo $order['score']; ?><br><?php if($order['type']==0){?> <a href="/mall/order/change/<?= $order['orderid']?>.html" class="contactseller">修改价格</a> <?php }?></td>
                        </tr>
                        <?php if(count($order['details']) >1 ){ ?>
                            <?php unset($order['details'][0]) ;?>
                            <?php foreach($order['details'] as $goods){ ?>
                                <tr>
                                	<td class="tdfirst" style="width:100px;" >
                						<a target="_blank" href="<?= getgoodsurl($order['details'][1]['crid'], $goods['gid'])?>" style='color:black'><img src="<?= $goods['img'] ?>" class="goodscover" width="80" height="45" /></a>
                                    </td>
									<td class="tdfirst"> <p class="goodsint"><a target="_blank" href="<?= getgoodsurl($order['details'][1]['crid'], $goods['gid'])?>" style='color:black'><?= $goods['gname'] ?></a></p></td>
                                    <td class="tdfirst">￥<?php if($order['is_real'] == 1 ) echo $goods['price']; else echo $goods['iscore']; ?></td>
                                    <td><?= $goods['quantity'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?> 
                    </table>
                <?php }else{ ?>
                    <table cellpadding="0" cellspacing="0" class="goodstable">
                        <tr>
                            <th width="342" class="thfirst" colspan="2">
                                <span><?= date("Y-m-d H:i:s",$order['dateline']) ?>&nbsp;订单号：<?= $order['ordernum']?></span>
                            </th>
                            <th width="65">单价</th>
                            <th width="65">数量</th>
                            <th width="150">买家</th>
                            <th width="135">交易状态</th>
                            <th width="135">实收积分</th>
                        </tr>
                        <tr>
                            <td class="tdfirst" style="width:100px;">
                                <a target="_blank" href="<?= getgoodsurl($order['details'][0]['crid'], $order['details'][0]['gid'])?>" style='color:black'><img src="<?= $order['details'][0]['img'] ?>" class="goodscover" width="80" height="45" /></a>
                            </td>
							<td class="tdfirst"><p class="goodsint"><a target="_blank" href="<?= getgoodsurl($order['details'][0]['crid'], $order['details'][0]['gid'])?>" style='color:black'><?= $order['details'][0]['gname'] ?></a></p></td>
                            <td class="tdfirst" ><?php if($order['is_real'] == 1 ) echo $order['details'][0]['price']; else echo $order['details'][0]['iscore']; ?></td>
                            <td><?= $order['details'][0]['quantity'] ?></td>
                            <td rowspan="<?= count($order['details']) ?>">
                                <img src="<?= empty($order['customer'][0]['face']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg' :$order['customer'][0]['face'] ?>" width="36" height="36" class="headimgaroud" />
                                <p class="buyname"><?= $order['customer'][0]['realname'] ?></p>
                            </td>
                            <td rowspan="<?= count($order['details']) ?>" style="<?php if($order['type'] == 3) echo 'position:relative;'; ?>"> 
                                <span style=" <?php if($order['type'] == 6){ echo 'color:#bbb;';} elseif($order['type'] == 1){echo 'color:red;';}?>"><?= getOrderScoreStatus($order['type']) ?></span><br /><a href="/mall/order/detail/<?= $order['ordernum']?>.html" class="contactseller" style="color: rgb(94, 150, 245);">订单详情</a><br>
                                <?php if($order['type'] == 1){ ?>
                                    <a href="/mall/shop/delivery/<?= $order['ordernum']?>.html" class="confirmreceipt promptpayment">发货</a>
                                <?php }elseif($order['type'] == 0){ ?>
                                    <a href="javascript:void(0)" class="contactseller closeorder" data-ordernum="<?= $order['ordernum'] ?>">关闭交易</a>
                                <?php }elseif($order['type'] == 3){ ?>
                                <?php } ?>
                            </td>
                            <td  rowspan="<?= count($order['details'])?>"><?php if($order['is_real'] == 1 ) echo $order['totalfee']; else echo $order['score']; ?></td>
                        </tr>
                        <?php if(count($order['details']) >1 ){ ?>
                             <?php unset($order['details'][0]) ;?>
                            <?php foreach($order['details'] as $goods){ ?>
                                <tr>
                                    <td class="tdfirst" style="width:100px;">
                                        <a target="_blank" href="<?= getgoodsurl($order['details'][0]['crid'], $goods['gid'])?>" style='color:black'><img src="<?= $goods['img'] ?>" class="goodscover" width="80" height="45" /></a>
                                    </td>
									<td class="tdfirst"><p class="goodsint"><a target="_blank" href="<?= getgoodsurl($order['details'][0]['crid'], $goods['gid'])?>" style='color:black'><?= $goods['gname'] ?></a></p></td>
                                    <td class="tdfirst" ><?php if($order['is_real'] == 1 ) echo $goods['price']; else echo $goods['iscore']; ?></td>
                                    <td><?=  $goods['quantity'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?> 
                    </table>
                <?php } ?>
            <?php } ?>
        </div>
		<div style="height:65px">
            <?= $pagination ?>
		</div>
        <?php }elseif(!isset($data['fromsearch'])){ ?>
            <div class="buygoodslist nobuygoods">该列表下无订单商品！</div>
        <?php }else{ ?>
            <div class="buygoodslist nobuygoods1"></div>
        <?php }?>
    </div>
</div>
<script>
	$(function(){
        $("div .goodsinput").click(function(){
            $(".statusorderlist").toggle();
        });
        $(".statusorderlist").children('ul').children('li').each(function(){
           
            $(this).click(function(){
                var statusValue = $(this).data('status');
                var statusName = $(this).text();
                $("div .goodsinput").html(statusName);
                $("div .goodsinput").attr('data-status',statusValue);
				$(".goodsordeseach").trigger("click");
                $(".statusorderlist").hide();
            });
        });
    })
</script>
<script type="text/javascript">
    <?php 
        if(isset($data['searchtype']) && $data['searchtype'] ==1 && !empty($data['gname'])){
    ?>
        var searchtext = "<?= $data['gname'] ?>";
    <?php }else{ ?>
        var searchtext = "请输入商品名称或订单号进行搜索";
    <?php } ?>    
    $(document).ready(function(){
        if(searchtext == "请输入商品名称或订单号进行搜索"){
            $("#nameoroid").css('color','#999');
        }else{
            $("#nameoroid").css('color','#333');
        }
    })
        $(document).ready(function(){
        $("#nameoroid").val(searchtext);
    })
    $(document).ready(function(){
        $("#nameoroid").click(function(){
            var title = $("#nameoroid").val();
            if(title == "请输入商品名称或订单号进行搜索"){
                $("#nameoroid").val('');
            }
            $("#nameoroid").css('color','#333');

        })
        $("#nameoroid").blur(function(){
            var title = $("#nameoroid").val();
            if(title==''){
                $("#nameoroid").val("请输入商品名称或订单号进行搜索");
                $("#nameoroid").css('color','#999');
            }else{
                $("#nameoroid").css('color','#333');
            }
        })

    })
</script>
<script type="text/javascript">
   $(".buygoodbutton").click(function(){
        var searchtext = "请输入商品名称或订单号进行搜索";
        var nameoroid = $("input[name='nameoroid']").val();
        if(nameoroid == searchtext){
            nameoroid = '';
        }
        var crid = $("input[name='crid']").val();
        var uid = $("input[name='uid']").val();
        var url = '<?= geturl("mall/order/{$method}") ?>'+'?';
        url += 'gname='+nameoroid;
        url += '&type='+<?= $type ?>;
        url += '&ordernum='+nameoroid;
        url += '&crid='+crid;
        url += '&seller_uid='+uid;
        url += '&searchtype='+1;
        url += '&fromsearch='+1;
        window.location.href = url;
    });
   $(".goodsordeseach").click(function(){
     var url = '<?= geturl("mall/order/{$method}") ?>'+'?';
     var crid = $("input[name='crid']").val();
     var uid = $("input[name='uid']").val();
     url += 'crid='+crid;
     url += '&seller_uid='+uid;
     url += '&type='+<?= $type ?>;
     var gname = $("input[name='gname']").val();
     if(gname != ''){
         url += '&gname='+gname;
     }
     var sdateline = $("input[name='sdateline']").val();
     if(sdateline != ''){
         url += '&sdateline='+sdateline;
     }
     var edateline = $("input[name='edateline']").val();
     if(edateline != ''){
         url += '&edateline='+edateline;
     }
     var oid = $("input[name='oid']").val();
     if(oid != ''){
         url += '&ordernum='+oid;
     }
     var nickname = $("input[name='nickname']").val();
     if(nickname != ''){
         url += '&nickname='+nickname;
     }
     var status = $("div .goodsinput").attr('data-status');
     if(status != ''){
         url += '&status='+status;
     }
     url += '&searchtype='+2;
     url += '&fromsearch='+1;
     location.href = url;
   });
</script>
<script type="text/javascript">
    $(".closeorder").click(function() {
        var ordernum = $(this).data('ordernum');
        top.dialog({
            title: "关闭交易",
            content: "<p style='font-weight: bold;font-size: 16px;'>是否需要对交易进行关闭?</p>",
            okValue: "是",
            ok: function() {
                closeorder(ordernum);
            },
            cancelValue: "否",
            cancel: function() {

            },
            width: "280px"
        }).showModal();
    });
    function closeorder(ordernum){
        $.ajax({
            url:'/mall/order/closeorder.html',
            type:'post',
            dataType:'json',
            data:{ordernum:ordernum},
            success:function(data){
                if(data.status){
                    location.href = location.href;
                }
            }
        })
    }
</script>
<script type="text/javascript">
    $('.showdiv').mouseover(function(){
        $(this).parent().children('div').show();
    });
    $('.showdiv').mouseleave(function(){
        $(this).parent().children('div').hide();
    });
</script>
<?php $this->display('mall/footer') ?>
