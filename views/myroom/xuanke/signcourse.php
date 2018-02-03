<?php $this->display('myroom/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">
    <div class="busehir">
    <h2 class="sizrers"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
    <?php if(isset($courselist) === true && is_array($courselist)): ?>
    <?php foreach($courselist as $course): ?>
    <div class="jiweaes">
        <p class="jierses jwwid">
            <span class="huersw"><?=htmlspecialchars($course['coursename'], ENT_NOQUOTES)?></span>
            <span class="jieraee">教师：<?=htmlspecialchars($course['realname'], ENT_NOQUOTES)?></span>
        </p>
        <p class="juersde jwwid"><span class="jiwrese">课程介绍：</span><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></p>
        <?php if(isset($course['images']) === true && is_array($course['images']) === true): ?>
        <?php foreach($course['images'] as $thumb => $img): ?>
        <a class="uewrdse fl" href="<?=$img?>"><img src="<?=$thumb?>" style="width:180px;height:110px;"></a>
        <?php endforeach; ?>
        <?php endif; ?>
        <p class="newdsre">
            上课日期：<?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?> | 上课时间：<?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?> | 上课地点：<?=htmlspecialchars($course['place'], ENT_NOQUOTES)?>
        </p>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div style="text-align:center;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu3.png" /></div>
    <?php endif; ?>
    </div>
    <script type="text/javascript">
        (function($) {
            parent.window.prev($('.uewrdse.fl'));
        })(jQuery);

    </script>
<?php $this->display('myroom/page_footer'); ?>