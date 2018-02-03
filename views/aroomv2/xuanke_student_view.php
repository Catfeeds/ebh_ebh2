<?php $this->display('aroomv2/room_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />


<body>
<div style="width:1000px;margin:0 auto;">
    <div class="crightbottom" style="width:1000px;">
        <div class="xktitles" style="border-bottom:none;"><?php echo $xuanke['name']?>——<?php echo $name?></div>
        <?php foreach($courselist as $course){?>
        <div class="xkfbtitle"><?php echo $course['coursename']?><span class="xkjs1s">教师：<?php echo empty($course['realname_t'])?$course['username_t']:$course['realname_t']?></span></div>
        <p class="kclbtitle">课程介绍：<span class="textkcjs"><?php echo $course['introduce']?></span></p>
        <div class="xklbtp">
            <ul id="layer-photos-demo">
                <?php foreach($course['images'] as $thumb => $image): ?>
                    <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="clear"></div>
        <p class="kclbtitle" style="*padding-top:8px;">上课日期：<span class="textkcjs"><?php echo date('Y-m-d',$course['starttime'])?> 至 <?php echo date('Y-m-d',$course['endtime'])?></span></p>
        <p class="kclbtitle kclbtitle1s">上课时间：<span class="textkcjs"><?php echo $course['classtime']?></span></p>
        <p class="kclbtitle kclbtitle1s">上课地点：<span class="textkcjs"><?php echo $course['place']?></span></p>
        <?php $range=array(0=>'全年级',1=>'限年级',2=>'限班级')?>
        <p class="kclbtitle kclbtitle1s">选课人员：<span class="textkcjs"><?php echo $range[$course['range_type']];if($course['range_type']!=0){echo '/';};if(!empty($course['rangemsg']))echo $course['rangemsg']?></span></p>
        <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?php echo $course['classnum']?></span><span class="textkcjs"> 人</span></p>
        <?php }?>
    </div>
</div>
</body>
<script>
    (function($) {
        window.prev($('.xklbtplist.fl a'));
    })(jQuery);

    function prev(jo) {
        jo.each(function() {
            $(this).lightBox();
        });
    }
</script>
</html>
