<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top'); $typearr=array('1'=>'课件打赏','2'=>'评论管理','3'=>'答疑打赏');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<body>
	<div class="maines" style="margin:0 auto;float:none;background:none;">
        <div class="jetke">
        <?php $this->display('homev2/purse_menu');?>
        <?php if (!$this->input->get('get')) {?>
    	<div class="mainereward">
        	<a href="/homev2/purse/gratuity.html" class="curr">赞赏记录</a>
            <a href="/homev2/purse/gratuitydetail.html">打赏明细</a>
        </div>
        <?php } else {?>
            <div class="mainereward">
            <a href="/homev2/purse/gratuity.html" >我的赞赏</a>
            <a href="/homev2/purse/gratuity.html?get=1" class="curr">收到赞赏</a>
        </div>
        <?php }?>
        <div class="clear"></div>
        <p class="myreward">我收到的赞赏：<span class="moneytotal">
        <?php 
        if(empty($rewardcount['getreward'])){
            $rewardcount['getreward'] = 0;
        }
            echo $rewardcount['getreward'];
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
                            <td width="10%">打赏方式</td>
                            <td width="10%">来源</td>
                            <td width="20%">金额/元</td>
                        </tr>
                        <?php foreach ($rewardlist as $list) { ?>
                        <tr>
                        	<td width="25%"><?php echo date('Y-m-d H:i',$list['paytime']);?></td>
                            <td width="35%">
                            	<a title="<?php echo $list['username'];?>" href="javascript:;" style="float:left;margin-left:20px;"><img class="imgyuans" src="<?php echo getavater($list);?>"/></a>
                                <?php 
                                if(empty($list['qrealname'])){
                                    $name = $list['qusername'];
                                }else{
                                    $name = $list['qrealname'];
                                }
                                ?>
                                <p class="ghjut ghjut1"><?php echo $name;?></p>
                                <p class="ghjut"><?php echo $list['title']?></p>
                            </td>
                            <td width="10%"><?php echo $typearr[$list['type']]; ?></td>
                            <td width="10%"><?php echo getusername($list);?></td>
                            <td width="20%" class="rewards">+<?php echo $list['totalfee'];?></td>
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
