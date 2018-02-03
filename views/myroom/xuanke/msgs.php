<?php $this->display('myroom/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">
    <div class="busehir">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
<?php if(isset($messages) === true && is_array($messages) === true): ?>
        <div class="kostrds qanwid" style="margin-bottom:20px;">
            <ul>
                <li class="fklisr">
                    <a class="wursk botsder" href="/myroom/xuanke/msgs.html?xkid=<?=$aid?>">选课动态</a>
                </li>
                <li class="fklisr">
                    <a class="wursk " href="/myroom/xuanke/mycourse.html?xkid=<?=$aid?>">我的课程</a>
                </li>
            </ul>
        </div>
    <?php foreach($messages as $id => $msg): ?>
        <div class="tsejier tsejier1s">
            <p class="dsirerd">
                <span class="huersde"><?=htmlspecialchars($msg['object'], ENT_NOQUOTES)?></span>
                <?php if (isset($msg['int_arg']) === true && is_array($msg['int_arg']) === true): ?>
                    <?php printf($msg['int_arg']['format'], "<span class=\"jliserw\">" . $msg['int_arg']['value'] . "</span>")?>
                <?php endif; ?>
            </p>
            <p class="huetwre"><?=htmlspecialchars($msg['msg_time'], ENT_NOQUOTES)?></p>
            <p class="hjuiers"><span class="single-msg" title="<?=htmlspecialchars($msg['msg'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($msg['msg'], 50), ENT_NOQUOTES)?></span><?php if(isset($msg['str_arg']) === true):?><span class="huerses"><?=$msg['str_arg']?></span><?php endif;?></p>
            <?php if($id == 0 && isset($msg['guide']) === true && is_array($msg['guide']) === true): ?>
                <p class="hjuiers">
                    <?php foreach ($msg['guide'] as $item): ?><?=$item?><?php endforeach; ?>
                </p>
            <?php endif;?>
        </div>
    <?php endforeach;?>
        <?php else: ?>
            <div style="text-align:center;margin:60px 0;"><img src="http://static.ebanhui.com/ebh/images/zanwukc.jpg" /></div>
        <?php endif; ?>
    </div>
<?php $this->display('myroom/page_footer'); ?>