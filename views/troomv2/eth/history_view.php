<?php $this->display('troomv2/page_header'); ?>
<div class="lefrig">
    <div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发信历史（查看）</span></a></li>
			</ul>
		</div>
    </div>
    <div class="work_mes">
        <ul class="extendul">
            <li class="workcurrent">
                <a href="<?=geturl("troomv2/eth/history/".$minfo['mid'])?>">
                <span>发信历史</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/error/".$minfo['mid'])?>">
                <span>发送状态</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/tong/".$minfo['mid'])?>">
                <span>统计分析</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/reply/".$minfo['mid'])?>">
                <span>查看回复（<?=$replycount?>）</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="jiewrte">
    	<span class="hsires">时 &nbsp;间：</span>
        <div class="rihsres"><?=date("Y年m月d日",$minfo['dateline'])?>
        <?php $weekarray=array("日","一","二","三","四","五","六");?>
               （<?php echo "星期".$weekarray[date("w",$minfo['dateline'])];?>）
       <?php 
        $h=date('G',$minfo['dateline']);
        if ($h<11) echo '早上';
        else if ($h<13) echo '中午';
        else if ($h<17) echo '下午';
        else echo '晚上';
        ?>
        <?=date("h:i",$minfo['dateline'])?>
        </div>
    </div>
    <div class="jiewrte">
    	<span class="hsires">收件人：</span>
        <div class="rihsres"><?=$minfo['receive_user']?></div>
    </div>
    <div class="jiewrte">
    	<span class="hsires">主 &nbsp;题：</span>
        <div class="rihsres"><?=$minfo['subject']?></div>
    </div>
    <div class="jiewrte">
    	<span class="hsires">内 &nbsp;容：</span>
    </div>
    <div class="huerdfr">
    	<?=$minfo['message']?>
    </div>
</div>
</body>
</html>