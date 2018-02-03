<?php $this->display('aroomv2/room_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />

<body>
<div style="width:1000px;margin:0 auto;">
    <div class="crightbottom" style="width:1000px;">
        <div class="xktitles"><?php echo shortstr($course['coursename'],60)?><span class="xkjs1s">教师：<?php echo empty($course['realname'])?$course['username']:$course['realname']?></span></div>
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
        <p class="kclbtitle kclbtitle1s">报名情况：<span class="textkcjs" style="color:#ff3c00;"><?php echo $course['studentsnum']?></span><span class="textkcjs"> 人</span></p>
        <?php if(!empty($course['student'])){?>
        <div class="hdjsckanbtn"><a href="/aroomv2/xuanke/exportexcel.html?cid=<?php echo $course['cid']?>&xkid=<?php echo $course['xkid']?>" class="tzdel tzadd">导出excel</a></div>
        <?php }?>
        <table cellpadding="0" cellspacing="0" class="bmlist">
            <tr class="bmlistfir">
                <td width="263">学生信息</td>
                <td width="468">所属班级</td>
                <td width="143">报名时间</td>
            </tr>
            <?php if(!empty($course['student'])){foreach($course['student'] as $v){?>
                <tr>
                    <td>
                        <?php
                        if($v['sex'] == 1)
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                        else
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                        $face = empty($v['face']) ? $defaulturl:$v['face'];
                        $face = str_replace('.jpg','_50_50.jpg',$face);
                        ?>
                        <div style="float:left;padding:0 10px;">
                            <a href="javascript:;"><img class="touxyuan" src="<?php echo $face?>"></a>
                        </div>
                        <div style="width:165px;float:left;">
                            <span class="renming" title="<?=empty($v['realname']) ? $v['username'] : $v['realname']?>"><?=empty($v['realname']) ? shortstr($v['username'],8) : shortstr($v['realname'], 8)?></span>
                            <span class="xingbie" <?php  if($v['sex']==0) echo "style=\"background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png') \"" ?>></span>
                            <div style="clear:both;"></div>
                            <span class="renming1"><?=$v['username']?></span>
                        </div>
                    </td>
                    <td style="text-align:center;"><?php echo $v['classname']?></td>
                    <td style="text-align:center;"><?=!empty($v['sign_time']) ? date('Y-m-d H:i',$v['sign_time']) : '--'?></td>
                </tr>
            <?php }}else{?>
                <tr class="zwnr1s"><td colspan="3" style="border:none;"><div class="nodata"></div></td></tr>
            <?php }?>
        </table>
        <div class="clear" style="height: 20px;"></div>
        <!--        --><?php //echo $pagestr?>
    </div>
</div>
</body>
<script>
</script>
<script>
    (function($) {
        window.prev($('.xklbtplist.fl a'));
    })(jQuery);

    function prev(jo) {
        jo.each(function() {
            $(this).lightBox();
        });
    }
	$(function(){
		$('.bmlist tr:last td').css('border-bottom','none');
	});
</script>
</html>
