<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<style>
    .extendul li a{
        text-decoration: none;
    }
    a.btn-base{
        border-radius: 4px;
        color:#fff !important;
        font-size: 14px;
        padding: 3px 12px !important;
        text-decoration: none;
        margin-right:34px;
    }
    a.btn-status{
        background-color: #4E8CF1;
    }
</style>
<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > 课程列表
    </div>
    <div class="crightbottom">
        <div class="xktitles" style="border-bottom:none;height:inherit;"><?php echo $xuanke['name']?></div>
        <div class="work_mes">
            <ul class="extendul">
                <li><a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>"><span>活动动态</span></a></li>
                <li><a href="/aroomv2/xuanke/view.html?xkid=<?php echo $xkid?>"><span>活动详情</span></a></li>
                <li  class="workcurrent"><a href="/aroomv2/xuanke/courselist.html?xkid=<?php echo $xkid?>"><span>课程列表</span></a></li>
                <li><a href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $xkid?>"><span>报名结果</span></a></li>
                <?php if (($activity['status'] == 3 || $activity['status'] == 5) && $rule['start_t'] <= SYSTIME && $rule['end_t'] >= SYSTIME) { ?>
                    <li style="float:right;margin-right:30px;"><a class="btn-base btn-status" rel="<?=intval($xuanke['ispause'])?>" href="javascript:;"><?=empty($xuanke['ispause']) ? '暂停选课' : '继续选课'?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="clear"></div>
        <?php if(!empty($courselist)){foreach($courselist as $course){?>
        <div class="ckhdlist">
            <div class="xkfbtitle" title="<?php echo $course['coursename']?>"><?php echo shortstr($course['coursename'],60)?><span class="xkjs1s">教师：<?php echo empty($course['realname'])?$course['username']:$course['realname']?></span></div>
            <p class="kclbtitle">课程介绍：<span class="textkcjs"><?php echo $course['introduce']?></span></p>
            <?php if(empty($course['images']) === false) { ?>
            <div class="xklbtp">
                <ul id="layer-photos-demo">
                    <?php foreach($course['images'] as $thumb => $image): ?>
                        <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
                <div class="clear"></div>
            <?php } ?>

            <p class="kclbtitle">上课日期：<span class="textkcjs"><?php echo date('Y-m-d',$course['starttime'])?> 至 <?php echo date('Y-m-d',$course['endtime'])?></span></p>
            <p class="kclbtitle kclbtitle1s" style="width: 740px;">上课时间：<span class="textkcjs"><?php echo $course['classtime']?></span></p>
            <p class="kclbtitle kclbtitle1s" style="width: 740px;">上课地点：<span class="textkcjs"><?php echo $course['place']?></span></p>
            <?php $range=array(0=>'全年级',1=>'限年级',2=>'限班级')?>
            <p class="kclbtitle kclbtitle1s" style="width: 750px;">选课人员：<span class="textkcjs"><?php echo $range[$course['range_type']];if($course['range_type']!=0){echo '/';};if(!empty($course['rangemsg']))echo $course['rangemsg']?></span></p>

            <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?php echo $course['classnum']?></span><span class="textkcjs"> 人</span></p>
        </div>

        <?php } ?>
            <?php if(!empty($pagestr)) { ?><?=$pagestr?><?php } ?>
            <?php }else{?>
            <div class="nodata"></div>
        <?php }?>
    </div>

</div>
</body>
<script>
    function prev(jo) {
        jo.each(function() {
            $(this).lightBox();
        });
    }
    (function($) {
        prev($('.xklbtplist.fl a'));
        var xkid = <?=$xuanke['xkid']?>;
        $("a.btn-status").bind('click', function() {
            var t = $(this);
            var ispause = t.attr('rel');
            var cstatus = ispause == '1' ? '0' : '1';
            $.ajax({
                'url': '/aroomv2/xuanke/ajax_pause_activity.html',
                'type': 'post',
                'data': { 'xkid': xkid, 's': cstatus },
                'dataType': 'json',
                'success': function(ret) {
                    if (ret.errno > 0) {
                        return;
                    }
                    t.attr('rel', cstatus);
                    t.html(cstatus == '0' ? '暂停选课' : '继续选课');
                }
            });
        });
    })(jQuery);
</script>
</html>
