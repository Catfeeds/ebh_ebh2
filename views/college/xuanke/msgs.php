<?php $this->display('college/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<style type="text/css">
    a.btn-base{
        border-radius: 4px;
        color:#fff;
        font-size: 14px;
        padding: 3px 16px;
        text-decoration: none;
    }
    a.sign-btn{
        background-color: #4E8CF1;
    }
    a.sign-disabled{
        background-color: #999;
    }
</style>
    <div class="busehir">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
<?php if(isset($messages) === true && is_array($messages) === true): ?>
		<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;margin-bottom:20px;">
			<ul>
				 <li class="workcurrent"><a href="/college/xuanke/msgs.html?xkid=<?=$aid?>" style="font-size:16px;line-height: 33px;border:none;"><span>选课动态</span></a></li>
				 <li><a href="/college/xuanke/mycourse.html?xkid=<?=$aid?>" style="font-size:16px;"><span>我的课程</span></a></li>
                <?php if (($activity['status'] == 3 || $activity['status'] == 5) && $rule['end_t'] > SYSTIME) { ?><li style="float:right;"><a class="btn-base <?=empty($activity['ispause']) ? 'sign-btn' : 'sign-disabled'?>" href="<?=empty($activity['ispause']) ? '/college/xuanke/sign.html?xkid='.$aid : 'javascript:;'?>">去选课</a></li><?php } ?>
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
            <p class="hjuiers"><span class="single-msg" title="<?=htmlspecialchars($msg['msg'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($msg['msg'], 70), ENT_NOQUOTES)?></span><?php if(isset($msg['str_arg']) === true):?><span class="huerses"><?=$msg['str_arg']?></span><?php endif;?></p>
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