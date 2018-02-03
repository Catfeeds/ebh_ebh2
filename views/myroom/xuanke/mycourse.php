<?php $this->display('myroom/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">
    <div class="busehir">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
        <div class="kostrds qanwid" style="margin-bottom:20px;">
            <ul>
                <li class="fklisr">
                    <a class="wursk" href="/myroom/xuanke/msgs.html?xkid=<?=$aid?>">选课动态</a>
                </li>
                <li class="fklisr">
                    <a class="wursk botsder" href="/myroom/xuanke/mycourse.html?xkid=<?=$aid?>">我的课程</a>
                </li>
            </ul>
        </div>
        <?php if(isset($courselist) === true && is_array($courselist) === true): ?>
            <?php foreach($courselist as $course): ?>
                <div class="jiweaes">
                    <p class="jierses jwwid">
                        <span class="huersw"><?=htmlspecialchars($course['coursename'], ENT_NOQUOTES)?></span>
                        <span class="jieraee">教师：<?=htmlspecialchars($course['realname'], ENT_NOQUOTES)?></span>
                    </p>
                    <p class="juersde jwwid"><span class="jiwrese">课程介绍：</span><span style="float: left;white-space: normal;width: 860px;"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></span></p>
                    <?php if(isset($course['images']) === true && is_array($course['images']) === true): ?>
                        <?php foreach($course['images'] as $thumb => $img): ?>
                            <a class="uewrdse fl" href="<?=$img?>"><img src="<?=$thumb?>" style="width:180px;height:110px;"></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <p class="newdsre">
                        上课日期：<?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?> | 上课时间：<?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?> | 上课地点：<?=htmlspecialchars($course['place'], ENT_NOQUOTES)?>
                    </p>
                    <?php if($course['join'] != 1 && $course['s_endtime'] > SYSTIME): ?>
                        <a class="lanseasre" href="/myroom/xuanke/isjoin.html?sid=<?php echo $course['sid']?>">评价问卷</a>
                    <?php elseif(isset($course['s_starttime']) === true && $course['s_starttime'] < SYSTIME): ?>
                        <a class="lanseasre" target="_blank" href="/college/survey/stat/<?=$course['sid']?>.html">查看评价</a>
                    <?php endif; ?>
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