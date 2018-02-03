<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<body>
	<div class="maines" style="margin:0 auto;float:none;background:none;">
    <div class="jetke">
    <?php $this->display('homev2/purse_menu'); $typearr=array('1'=>'课件打赏','2'=>'评论管理','3'=>'答疑打赏');?>
    <div class="mainereward">
            <a href="/homev2/purse/gratuity.html" class="curr">我的赞赏</a>
            <a href="/homev2/purse/gratuity.html?get=1">收到赞赏</a>
        </div>
          <div class="clear"></div>
        <p class="myreward">我发出的赞赏：<span class="moneytotal">
        <?php 
        if(empty($rewardcount['sendreward'])){
            $rewardcount['sendreward'] = 0;
        }
        echo $rewardcount['sendreward'];
        ?>
        </span>元</p>
        <div class="teachercheck_top">
        	<div class="aligncen">
                <table class="tables" cellspacing="0" cellpadding="0">
                    <tbody>
                    <?php if(!empty($rewardlist)){ ?>
                        <tr class="first">
                        	<td width="25%">时间</td>
                            <td width="35%" style="text-align: left; text-indent: 50px;">主题</td>
                             <td width="10%" >打赏方式</td>
                            <td width="15%">金额/元</td>
                            <td width="15%">支付方式</td>
                        </tr>
                        <tr>
                        <?php foreach ($rewardlist as $list) {
                        ?>
                        	<td width="25%"><?php echo date('Y-m-d H:i',$list['paytime']); ?></td>
                            <td width="35%">
                            	<a title="<?php echo $list['username']; ?>" href="/myroom/mycourse/<?php echo $list['toid'];?>.html" style="float:left;margin-left:20px;"><img class="imgyuans" src="<?php echo getavater($list);?>"/></a>
                                <p class="ghjut ghjut1"><?php echo getusername($list);?></p>
                                <p class="ghjut"><?php echo $list['title'];?></p>
                            </td>
                            <td width="10%" class="rewards"><?php echo $typearr[$list['type']];?></td>
                            <td width="15%" class="rewards">-<?php echo $list['totalfee'];?></td>
                            <td width="15%">
                            <?php
                                if($list['payfrom'] == 3){
                                    $payfrom = '支付宝';
                                }else if($list['payfrom'] == 8){
                                    $payfrom = '个人钱包';
                                }else if($list['payfrom'] == 9){
                                    $payfrom = '微信';
                                }
                                echo $payfrom;
                            ?></td>
                        </tr>
                    <?php } ?>
                    <?php }else{ ?>
                        <div class="nodata"></div>
                    <?php }?>
                    </tbody>
                </table>
                <?php echo $showpage;?>
        	</div>
        </div>
	</div>
    </div>
</div>
<?php $this->display('homev2/footer');?>
