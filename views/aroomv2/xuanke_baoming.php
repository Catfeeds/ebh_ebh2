<?php $this->display('troomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
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
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > 报名结果
    </div>
    <div class="crightbottom">
        <div class="xktitles" style="border-bottom:none;height:inherit"><?php echo $xuanke['name']?></div>
	<div class="work_mes">
        <ul class="extendul">
            <li><a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>"><span>活动动态</span></a></li>
            <li><a href="/aroomv2/xuanke/view.html?xkid=<?php echo $xkid?>"><span>活动详情</span></a></li>
            <li><a href="/aroomv2/xuanke/courselist.html?xkid=<?php echo $xkid?>"><span>课程列表</span></a></li>
            <li  class="workcurrent"><a href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $xkid?>"><span>报名结果</span></a></li>
            <?php if (($activity['status'] == 3 || $activity['status'] == 5) && $rule['start_t'] <= SYSTIME && $rule['end_t'] >= SYSTIME) { ?>
                <li style="float:right;margin-right:30px;"><a class="btn-base btn-status" rel="<?=intval($xuanke['ispause'])?>" href="javascript:;"><?=empty($xuanke['ispause']) ? '暂停选课' : '继续选课'?></a></li>
            <?php } ?>
        </ul>
    </div>
        <?php if(!empty($courselist)){?>
        <div class="clear"></div>
        <div class="akcaxsfl">
            <a href="javascript:;" class="ankcfl onhover">按课程</a>
            <a href="/aroomv2/xuanke/baoming_students.html?xkid=<?php echo $xkid?>" class="ankcfl">按学生</a>
        </div>
		
			<div class="hdjsckanbtn"><a href="/aroomv2/xuanke/exportexcelall.html?xkid=<?=$xkid?>" class="tzdel tzadd">全部导出</a></div>
        <div class="clear"></div>
        <!--按课程-->
        <table cellpadding="0" cellspacing="0" class="tablekclist">
            <tr class="first">
                <td width="194">课程名称</td>
                <td width="106">教师</td>
                <td width="94">名额限制</td>
                <td width="94">报名人数</td>
                <td width="106">状态</td>
                <td width="96">操作</td>
            </tr>
            <?php foreach($courselist as $course){?>
            <tr>
                <td><?php echo $course['coursename']?></td>
                <td><?php echo empty($course['realname'])?$course['username']:$course['realname']?></td>
                <td><?php echo $course['classnum']?></td>
                <td><?php echo $course['studentsnum']?></td>
                <td>完成选课</td>
                <td><a href="/aroomv2/xuanke/final_view.html?cid=<?php echo $course['cid']?>" class="xkcka" target="_blank">查看</a></td>
            </tr>
            <?php }?>
        </table>
        <?php }else{?>
            <div class="nodata"></div>
        <?php }?>
    </div>

</div>
<script>
    (function($) {
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
</body>
</html>
