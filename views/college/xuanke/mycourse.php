<?php $this->display('college/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
    <div class="busehir">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
		<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;margin-bottom:20px;">
			<ul>
				 <li><a href="/college/xuanke/msgs.html?xkid=<?=$aid?>" style="font-size:16px;line-height: 33px;border:none;"><span>选课动态</span></a></li>
				 <li class="workcurrent"><a href="/college/xuanke/mycourse.html?xkid=<?=$aid?>" style="font-size:16px;"><span>我的课程</span></a></li>
			</ul>
		</div>
        <?php if(isset($courselist) === true && is_array($courselist) === true): ?>
            <?php foreach($courselist as $course): ?>
                <div class="jiweaes">
                    <p class="jierses jwwid">
                        <span class="huersw"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></span>
                        <span class="jieraee">教师：<?=htmlspecialchars($course['realname'], ENT_NOQUOTES)?></span>
                    </p>
                    <p class="juersde jwwid"><span class="jiwrese">课程介绍：</span><span style="float: left;white-space: normal;width: 860px;"><?=htmlspecialchars(shortstr($course['introduce'],70), ENT_NOQUOTES)?></span></p>
                    <?php if(isset($course['images']) === true && is_array($course['images']) === true): ?>
                        <?php foreach($course['images'] as $thumb => $img): ?>
                            <a class="uewrdse fl" href="<?=$img?>"><img src="<?=$thumb?>" style="width:180px;height:110px;"></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <p class="newdsre">
                        上课日期：<?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?> | 上课时间：<?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?> | 上课地点：<?=htmlspecialchars($course['place'], ENT_NOQUOTES)?>
                    </p>
                    <?php if(isset($course['join'])&&$course['join'] != 1 &&isset($course['s_endtime']) && $course['s_endtime'] > SYSTIME): ?>
                        <a class="lanseasre" target="_blank" href="/college/xuanke/isjoin.html?sid=<?php echo $course['sid']?>">评价问卷</a>
                    <?php elseif(isset($course['s_starttime']) === true && $course['s_starttime'] < SYSTIME): ?>
                        <a class="lanseasre" target="_blank" href="/college/survey/stat/<?=$course['sid']?>.html">查看评价</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="nodata"></div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        (function($) {
            parent.window.prev($('.uewrdse.fl'));
        })(jQuery);

    </script>
<?php $this->display('myroom/page_footer'); ?>