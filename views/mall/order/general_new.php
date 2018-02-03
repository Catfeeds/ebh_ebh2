<?php $this->display('mall/header') ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20161226142863" />

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150821001"></script>
<style>
.goodstable .zeser {
	padding-right:10px;
	font-size:14px;
}
a.lifuse {
	float:right;
	color:#fff;
	background:#FF9900;
	width:105px;
	height:38px;
	line-height:38px;
	text-align:center;
	border-radius:4px;
}
a.dedis {
	float:right;
	color:#666;
	background:#fff;
	width:103px;
	height:36px;
	line-height:36px;
	border:solid 1px #cdcdcd;
	margin:0 10px 0 30px;
	text-align:center;
	border-radius:4px;
}
</style>
<script type="text/javascript">
/*备注展开隐藏*/
$(function(){
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
$(function(){
    if (top.location == self.location) {
        setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
        top.location='/myroom.html';
    }
	top.resetmain()
});
</script>
<body>
    <?php
    function getPayUrl($crid,$ordernum){
        return "http://shop.ebh.net/".$crid."/shopbuy.html?ordernum=".$ordernum;
    }
    function getOrderScoreStatus($code){
        switch ($code) {
           
            case 1:
                return '待发货';
                break;
            case 2:
                return '待收货';
                break;
            case 3:
                return '兑换成功';
                break;          
            default:
                # code...
                break;
        }
    }
    function getOrderStatus($code,$dateline,$nowdate){
        // ：0待付款，1待发货，2待确认，3交易成功，4退款中，5退款已确认，6交易关闭',
        switch ($code) {
            case 0:
                if(($nowdate - $dateline) > 1800){
                    return '支付超时';
                }else{
                    return '待付款';
                }
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
        $totaltime = 86400*15;
        $pasttime = time()-$time;
        $gaptime = $totaltime-$pasttime;
        $str = timesecondsToStr($gaptime);
        return $str;
    }
?>
<div class="buygoods">
    <div class="buygoodson">
		<div class="work_menu delivery-title" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">已买到的商品</span></a></li>
			</ul>
			<div class="buygoodstype">
                <a href="/mall/order/cscore.html" class="first">积分商品</a>
                <a href="/mall/order/cgeneral.html" class="second curr">普通商品</a>
            </div>
		</div>
        <div class="buygoodsearch">
            <div class="buygoodsearch-1">
                <input type="text" class="buygoodtext" id="nameoroid" name='nameoroid' value="" />
                <input type="button" class="buygoodbutton" value="" />
                <input type="hidden" value="<?= $roominfo['crid'] ?>" name="crid"/>
                <input type="hidden" value="<?= $user['uid'] ?>" name="uid"/>
                <a href="javascript:void(0)" class="buygoodtext1 down">高级</a>
            </div>
            <div class="goodsnav">
                <ul>
                        <li class="first <?php if($method=='cgeneral') echo 'curr'; ?>"><a href="<?= geturl('mall/order/cgeneral')?>">所有订单</a><span>|</span></li>
                        <li class="<?php if($method=='cwaitpay') echo 'curr'; ?>"><a href="<?= geturl('mall/order/cwaitpay')?>">待付款</a><span>|</span></li>
                        <li class="<?php if($method=='cwaitsend') echo 'curr'; ?>"><a href="<?= geturl('mall/order/cwaitsend')?>">待发货</a><span>|</span></li>
                        <li class="<?php if($method=='csended') echo 'curr'; ?>"><a href="<?= geturl('mall/order/csended') ?>">待收货</a><span>|</span></li>
                        <li class="<?php if($method=='csucceed') echo 'curr'; ?>"><a href="<?= geturl('mall/order/csucceed') ?>">交易成功</a><span>|</span></li>
                        <li class="<?php if($method=='cclosed') echo 'curr'; ?>"><a href="<?= geturl('mall/order/cclosed') ?>">交易关闭</a></li>
                    </ul>
            </div>
            <div class="clear"></div>
            <div class="buygoodsearchitem" style="<?php if(isset($data['searchtype']) && $data['searchtype']==2) echo "display:block"; else echo "display:none"; ?>">
                <span>商品名称</span>
                <input type="text" class="nameinput <?php if(!empty($data['gname'])) echo 'blue'; ?>" name="gname" value="<?php if(!empty($data['gname'])) echo $data['gname']; ?>"/>
               <span class="ml47">订单编号</span>
               <input type="text" class="nameinput <?php if(!empty($data['oid'])) echo 'blue'; ?>" name="oid" value="<?php if(!empty($data['oid'])) echo $data['oid']; ?>"/>
               <?php if($method == 'cgeneral'){ ?>
                    <span class="ml50">订单状态</span>
                    <div class="statusorder-1">
                        <div class="nameinput goodsinput <?php if(!empty($data['status'])) echo 'blue'; ?>" data-status="<?php if(!empty($data['status'])) echo $data['status'];else echo 0; ?>"><?= isset($data['status']) ? getSelectStatus($data['status']) : '全部'; ?></div>
                        <div class="statusorderlist" style="display:none">
                            <ul >
                                <li data-status="0"><a href="javascript:void(0)">全部</a></li>
                                <li data-status="1"><a href="javascript:void(0)">待付款</a></li>
                                <li data-status="2"><a href="javascript:void(0)">待发货</a></li>
                                <li data-status="3"><a href="javascript:void(0)">待收货</a></li>
                                <li data-status="4"><a href="javascript:void(0)">交易成功</a></li>
                                <li data-status="7"><a href="javascript:void(0)">交易关闭</a></li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <div class="clear"></div>
                <span>成交时间</span>
                <input name="sdateline"  style="cursor:pointer" class="nameinput lines closingtime <?php if(!empty($data['sdateline'])) echo 'blue'; ?>" type="text" readonly="readonly" value="<?php if(!empty($data['sdateline'])) echo $data['sdateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                <span class="lines">-</span>
                <input name="edateline"  style="cursor:pointer" class="nameinput lines closingtime <?php if(!empty($data['edateline'])) echo 'blue'; ?>" type="text" readonly="readonly" value="<?php if(!empty($data['edateline'])) echo $data['edateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                <a href="javascript:void(0)" class="goodsordeseach">订单搜索</a>
            </div>
        </div>
        <div class="clear"></div>
        <?php if(!empty($orders['order'])) {?>
        <div class="buygoodslist">
            <?php foreach ($orders['order'] as $order) { ?>
                <table cellpadding="0" cellspacing="0" class="goodstable">
                    <tr>
                        <th width="338" class="thfirst" colspan="2">
                            <?php if($method =='csended'){ ?>
                                <input type="checkbox" class="chkone" data-oid="<?= $order['mergenum'] ?>"/>
                            <?php } ?>
                            <label><?= date("Y-m-d H:i:s",$order['dateline']) ?><br>订单号：<?= $order['mergenum']?></label>
                        </th>
                        <th width="80">单价</th>
                        <th width="80">数量</th>
                        <th width="100">商品操作</th>
                        <th width="120">实付款</th>
                        <th width="180">交易状态</th>
                    </tr>
					
					<?php $theseller = array();
					$sellerindex = 0;
					$goodscount = 0;
					$paytype = 1;
					foreach($order['details'] as $selleruid=>$sellergoods){
						$sellerindex ++;
						$goods = $sellergoods['goods'];
							foreach($goods as $goodindex=>$good){
								$goodscount+= $good['quantity'];
								$paytype *= $good['type'];
								?>
                    <tr>
                        <td class="tdfirst" style="width:100px;">
                            <a target="_blank" href="<?= getgoodsurl($good['crid'], $good['gid'])?>" style='color:black'><img src="<?= $good['img'] ?>" class="goodscover" width="80" height="45" /></a>
                        </td>
						<td class="tdfirst"><p class="goodsint"><a target="_blank" href="<?= getgoodsurl($good['crid'], $good['gid'])?>" style='color:black'><?= $good['gname'] ?></a></p></td>
                        <td class="tdfirst">￥<?php if($order['is_real'] == 1 ) echo $good['price']; else echo $good['score']; ?></td>
                        <td><?= $good['quantity'] ?></td>
						
						<?php if(!isset($theseller[$selleruid])){//按卖家分开
							$theseller[$selleruid] = 1;
							?>
                        <td rowspan="<?= count($goods) ?>" class="qq_href">
						<?php 
						$nosellerinfo = !empty($orders['seller'][$selleruid]['qq_href'])?FALSE:TRUE?>
						<a  <?= $nosellerinfo ? 'onclick="showDialogWithoutQQ()"' :'target="_blank"' ?> href="<?= $nosellerinfo ? 'javascript:void(0)' : $orders['seller'][$selleruid]['qq_href']?>" class="contactseller qqcontent-1 <?= $nosellerinfo ? 'wsq': '' ?>">联系卖家</a>
						</td>
                        <td rowspan="<?= count($goods)?>">￥<?php echo $sellergoods['totalfee']; ?><br />（含运费<?php echo $sellergoods['freight']; ?>）</td>
                        <td rowspan="<?= count($goods)?>"><?= getOrderStatus($good['type'],$order['dateline'],SYSTIME) ?><br /><a href="/mall/order/detail/<?= $good['ordernum']?>.html" class="contactseller" style="color: rgb(94, 150, 245);">订单详情</a>
						
						
						<?php if($order['type'] == 0 && (SYSTIME - $order['dateline']) <= 1800){ ?>
                                
                            <?php }elseif($good['type'] ==2 ){ ?>
								<div class="display:block;">
                                <?php if( getTimer($good['paytime'])){ ?>
                                    <span style="color:#ff0000;width:100%;text-align:center;float:left;">还剩<br><?php echo getTimer($good['paytime'])?></span>
                                <?php } ?>
                                <a href="javascript:void(0)" class="confirmreceipt" data-oid="<?= $good['ordernum'] ?>" onclick="confirm(this)">确认收货</a>
								</div>
                            <?php }?>  
						</td>
						<?php }?>
						<?php if($sellerindex ==1 && $goodindex == 0){?>
							
						<?php }?>
                    </tr>
					<?php }}?>
                   
				   
					<?php if($paytype == 0 && (SYSTIME - $order['dateline']) <= 1800){?>
						<tr>
							<td colspan="7" class="zeser" style="text-align:right;">
								<a target="_blank" href="<?= getPayUrl($order['crid'], $order['mergenum'])?>" class="lifuse">立即付款</a>
								<a href="javascript:void(0)" class="corder dedis" data-ordernum="<?= $order['mergenum']?>">取消订单</a>
								<div class="fr">
								总额：<span style="color:#FF9900;font-weight:bold;">￥<?=$order['totalfee']?></span>
								<p style="color:#999;">（含运费<?=$order['freight']?>）</p>
								</div>
							</td>
						</tr>
					<?php }else{ ?>
							<tr>
								<td colspan="7" class="zeser" style="text-align:right;">共<?=$goodscount?>件商品 总额：<span style="color:#FF9900;font-weight:bold;">￥<?=$order['totalfee']?></span>（含运费<?=$order['freight']?>）</td>
							</tr>
							
					<?php }?>
                </table>
            <?php } ?>
			<div style="height:60px;width:100%">
            <?= $pagination ?>
			</div>
        </div>
        <div class="buygoodsfoot">
            <?php if($method =='csended' && !empty($orders)){ ?>
                <input type="checkbox" class="chkAll"/>
                <label class="allchose">全选</label>
                <a href="javascript:void(0)" class="confirmreceipt ml10 allconfirm">批量确认收货</a>
            <?php } ?>
        </div>
       <?php }elseif(!isset($data['fromsearch'])){ ?>
            <div class="buygoodslist nobuygoods">该列表下无订单商品！</div>
        <?php }else{ ?>
            <div class="buygoodslist nobuygoods1"></div>
        <?php }?>
    </div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/popupWindow.js"></script>
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
        // url += '&type='+<?= $type ?>;
        url += '&oid='+nameoroid;
        url += '&crid='+crid;
        url += '&searchtype='+1;
        url += '&fromsearch='+1;
        window.location.href = url;
    });
   $(".goodsordeseach").click(function(){
         var url = '<?= geturl("mall/order/{$method}") ?>'+'?';
         var crid = $("input[name='crid']").val();
         var uid = $("input[name='uid']").val();
         url += 'crid='+crid;
         // url += '&type='+<?= $type ?>;
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
             url += '&oid='+oid;
         }
         var status = $("div .goodsinput").attr('data-status');
         if(status != '' && status != undefined){
             url += '&status='+status;
         }
         url += '&searchtype='+2;
         url += '&fromsearch='+1;
         location.href = url;
   });
</script>
<script type="text/javascript">
    $('.chkAll').click(function(){
//      console.log($(this).is(':checked'));
        if($(this).is(':checked')){
            $('.chkone').each(function(){
                $(this).prop('checked',true);
            });  
        }else{
            $('.chkone').each(function(){
                $(this).prop('checked',false);
            });  
        }   
    });
    function confirm(objCur){
        var oid = $(objCur).data('oid');
//      console.log(oid);
        top.dialog({
            title: "信息提示",
            content: "<p style='font-weight:bold;font-size:16px;text-align:center;'>请确认是否已收到货？</p>",
            okValue: "确认",
            ok: function() {
                $.post('/mall/order/confirm.html',{
                        oids:oid
                    },function(data){
                        if(data.status){
                            location.reload();
                        }else{
                            alert('添加失败');
                            return false;
                        }
                    },'json');
            },
            cancelValue: "取消",
            cancel: function() {

            },
            width: "280px"
        }).showModal();
    }
</script>
<script type="text/javascript">
    $('.allconfirm').click(function(){
        var oids = '';
        $('.chkone').each(function(){
            if($(this).is(":checked")){
                if(oids == ''){
                    oids += $(this).data('oid');  
                }else{
                    oids += ','+$(this).data('oid');
                }
            }
        });
        if(oids == ''){
            top.dialog({
                title: "信息提示",
                content: "请勾选需要批量收货的商品",
                okValue: "确认",
                ok: function() {
                   
                },
                width: "280px"
            }).showModal();
        }else{
            top.dialog({
                title: "信息提示",
                content: "<p style='font-weight:bold;font-size:16px'>是否确认收货?</p>",
                okValue: "是",
                ok: function() {
                    $.post('/mall/order/confirm.html',{
                            oids:oids
                        },function(data){
                            if(data.status){
                                location.reload();
                            }else{
                                alert('添加失败');
                                return false;
                            }
                        },'json');
                },
                cancelValue: "否",
                cancel: function() {

                },
                width: "280px"
            }).showModal();
        }
    });
    $(".corder").click(function(){
        var ordernum = $(this).data('ordernum');
        top.dialog({
            title: "信息提示",
            content: "<p style='font-weight:bold;font-size:16px;text-align:center;'>是否取消订单?</p>",
            okValue: "是",
            ok: function() {
                $.post('/mall/order/closeorder.html',{
                        ordernum:ordernum
                    },function(data){
                        if(data.status){
                            location.reload();
                        }else{
                            alert('添加失败');
                            return false;
                        }
                    },'json');
            },
            cancelValue: "否",
            cancel: function() {

            },
            width: "280px"
        }).showModal();
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
