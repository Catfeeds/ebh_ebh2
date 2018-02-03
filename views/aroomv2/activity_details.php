<?php $this->display('aroomv2/page_header')?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<body>
<div class="matchs1s">
    <div style="width:590px;">
        <table class="datatabss1" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <th width="25%">时间</th>
                <th width="20%">积分</th>
                <th width="55%">说明</th>
            </tr>
            <?php if(!empty($detailslist)){ foreach($detailslist as $v){
                $description = str_replace('[w]','<span style="color:blue">'.$v['detail'].'</span>',$v['description']);?>
            <tr>
                <td width="28%" style="height: 35px;"><?php echo date('Y-m-d H:i:s',$v['dateline'])?></td>
                <td width="20%" style="height: 35px;color: <?php echo $v['action']=='+'?'green':'red'?>;"><?php echo $v['action']?><?php echo $v['credit']?></td>
                <td width="52%" style="height: 35px;"><?=$description.' '.$v['credit'].' 积分'?></td>
            </tr>
            <?php }}else{?>
                <tr>
                    <td colspan="3" align="center" style="border-bottom:none; padding-top:10px;">暂无数据</td>
                </tr>
            <?php }?>
        </table>
    </div>
</div>
<?php echo $pagestr?>
</body>
</html>