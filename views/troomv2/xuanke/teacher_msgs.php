<?php $this->display('troomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css?version=20160704001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<style type="text/css">
    a.btn-base{
        border-radius: 4px;
        color:#fff;
        font-size: 14px;
        padding: 3px 16px;
        text-decoration: none;
    }
    a.report-btn{
        background-color: #4E8CF1;
    }
</style>
<div>
    <div class=" clear"></div>
    <div class="lefrig lefrig1s">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
        <div class="kostrds kostrds1s">
            <ul>
                <li class="fklisr"><a href="/troomv2/xuanke/msglist.html?aid=<?=$aid?>" class="wursk botsder">选课动态</a></li>
                <li class="fklisr"><a href="/troomv2/xuanke/mycourse.html?aid=<?=$aid?>" class="wursk ">我的选课</a></li>
                <li class="fklisr"><a class="wursk " href="/troomv2/xuanke/signresult.html?aid=<?=$aid?>">报名结果</a></li>
                <?php if ($activity['status'] == 1 && $activity['starttime'] <= SYSTIME && $activity['endtime'] >= SYSTIME ) { ?><li class="fklisr" style="float:right;margin-right:30px;"><a class="btn-base report-btn" href="/troomv2/xuanke/report.html?xkid=<?=$aid?>">申报课程</a></li><?php } ?>
            </ul>
        </div>
        <?php if(isset($messages) === true && is_array($messages) === true): ?>
        <?php foreach($messages as $id => $msg): ?>
        <div class="tsejier tsejier1s">
            <p class="dsirerd">
                <span class="huersde"><?=htmlspecialchars($msg['object'], ENT_NOQUOTES)?></span>
                <?php if (isset($msg['int_arg'])): ?>
                    <?php printf($msg['int_arg']['format'], "<span class=\"jliserw\">" . $msg['int_arg']['value'] . "</span>")?>
                <?php endif; ?>
            </p>
            <p class="huetwre"><?=htmlspecialchars($msg['msg_time'], ENT_NOQUOTES)?></p>
            <p class="hjuiers"><span class="single-msg" title="<?=htmlspecialchars($msg['msg'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($msg['msg'], 70), ENT_COMPAT)?></span><?php if (isset($msg['category']) && !empty($msg['guide'])) { ?><?php foreach ($msg['guide'] as $item): ?><span style="float:right;margin-right:5px;margin-top:5px;"><?=$item?></span><?php endforeach; ?><?php } ?><?php if(isset($msg['str_arg'])):?><span class="huerses"><?=$msg['str_arg']?></span><?php endif;?></p>
            <?php if(/*$id == 0 && */isset($msg['guide']) === true && is_array($msg['guide']) === true && empty($msg['category'])): ?>
            <p class="hjuiers">
                <?php foreach ($msg['guide'] as $item): ?><?=$item?><?php endforeach; ?>
            </p>
            <?php endif;?>
        </div>
        <?php endforeach;?>
        <?php endif; ?>
    </div>
</div>
<br style="clear:both" />
<?php $this->display('troomv2/page_footer'); ?>