<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
<style type="text/css">
    .allson {
        overflow: hidden;
        padding-bottom: 20px;
        width: 975px;
        float: left;
    }
    .allson li {
        display: inline;
        float: left;
    }
    a.courseall {
        color: #666;
        display: inline-block;
        font-size: 15px;
        margin: 15px 15px 0;
    }
    a.courseall:hover, a.courseall.onhover {
        color: #338bff;
    }
</style>
<div>
    <div class="lefrig lefrig1s">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
        <div class="kostrds kostrds1s">
            <ul>
                <li class="fklisr"><a href="/troomv2/xuanke/msglist.html?aid=<?=$aid?>" class="wursk">选课动态</a></li>
                <li class="fklisr"><a href="/troomv2/xuanke/mycourse.html?aid=<?=$aid?>" class="wursk ">我的选课</a></li>
                <li class="fklisr"><a class="wursk botsder" href="/troomv2/xuanke/signresult.html?aid=<?=$aid?>">报名结果</a></li>
            </ul>
        </div>
        <?php if(!empty($courses)) { ?><div class="allson">
            <ul>
            <?php foreach ($courses as $item) { ?>
               <li><a class="courseall<?php if ($item['cid'] == $course['cid']) { echo ' onhover'; } ?>" href="/troomv2/xuanke/signresult.html?aid=<?=$aid?>&cid=<?=$item['cid']?>"><?=$item['coursename']?></a></li>
           <?php } ?></ul>
            </div>
        <?php }?>
        <?php if(isset($course) === true && is_array($course) === true): ?>
        <p class="kclbtitle">课程名称：<span class="textkcjs"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></span></p>
        <p class="kclbtitle" style="padding-top:0;">课程介绍：<span class="textkcjs"><?=htmlspecialchars($course['introduce'], ENT_NOQUOTES)?></span></p>
        <?php if(isset($course['images']) === true && is_array($course['images']) === true && count($course['images']) > 0): ?>
        <div class="kclbtitle" style="padding-top:5px;">
            <div class="fl"><span>课程图片：</span></div>
            <div class="xklbtp fl" style="margin-left:0;">
                <ul>
                    <?php foreach($course['images'] as $thumb => $image): ?>
                    <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <?php endif; ?>
        <p class="kclbtitle" style="*padding-top:8px;">上课日期：<span class="textkcjs"><?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?></span></p>
        <p class="kclbtitle kclbtitle1s"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：<span class="textkcjs"><?=empty($course['ap']) ? $timeRange[0] : $timeRange[$course['ap']]?></span></p>
        <p class="kclbtitle kclbtitle1s">上课时间：<span class="textkcjs"><?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?></span></p>
        <p class="kclbtitle kclbtitle1s">上课地点：<span class="textkcjs"><?=htmlspecialchars($course['place'], ENT_NOQUOTES)?></span></p>
        <p class="kclbtitle kclbtitle1s">选课人员：<span class="textkcjs"><?=$course['range']?></span></p>
        <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?=$course['classnum']?></span><span class="textkcjs"> 人</span></p>
        <p class="kclbtitle kclbtitle1s">报名情况：<span class="textkcjs" style="color:#ff3c00;"><?=$students_count?></span><span class="textkcjs"> 人</span></p>
        <div class="hdjsckanbtn"><?php if($students_count > 0): ?><a href="/troomv2/xuanke/exportexcel.html?cid=<?=$course['cid']?>&xkid=<?=$course['xkid']?>" class="tzdel tzadd">导出excel</a><?php else: ?>　<?php endif; ?></div>
        <div class="clear"></div>
        <table cellpadding="0" cellspacing="0" class="bmlist">
            <tr class="bmlistfir">
                <td width="163">学生信息</td>
                <td width="468">所属班级</td>
                <td width="143">报名时间</td>
            </tr>
            <?php if($students_count > 0): ?>
                <?php foreach($students as $index => $student): ?>
            <tr<?php if($index == $students_count - 1): ?> class="last"<?php endif;?>>
                <td>
                    <div style="float:left;padding:0 10px;">
                        <a href="javascript:;"><img class="touxyuan" src="<?=getavater($student,'50_50')?>"></a>
                    </div>
                    <div style="width:95px;float:left;">
                        <span class="renming" title="<?=htmlspecialchars($student['realname'], ENT_COMPAT)?>"><?=htmlspecialchars($this->showName($student['realname'], $student['username']), ENT_NOQUOTES)?></span>
                        <span class="<?php if($student['sex'] == 0): ?>xingbie1<?php else: ?>xingbie<?php endif; ?>"></span>
                        <div style="clear:both;"></div>
                        <span class="renming1"><?=htmlspecialchars($student['username'], ENT_NOQUOTES)?></span>
                    </div>
                </td>
                <td style="text-align:center;"><?=htmlspecialchars($student['classname'], ENT_NOQUOTES)?></td>
                <td style="text-align:center;"><?=!empty($student['sign_time']) ? date('Y-m-d H:i', $student['sign_time']) : '--'?></td>
            </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr class="last zwnr1s">
                    <td colspan="3" style="text-align:center; border:none;"><div class="nodata"></div></td>
                </tr>
            <?php endif; ?>
        </table>
            <?php else:?>
            <div class="nodata" style="text-align:center;"></div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        (function($) {
            parent.window.prev($('.xklbtplist.fl a'));
        })(jQuery);

    </script>
</div>
<?php $this->display('troomv2/page_footer'); ?>