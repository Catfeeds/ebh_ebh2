<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>">查看</a> > 查看评价
    </div>
    <div class="crightbottom">
        <div class="xktitles"><?php echo $xuanke['name']?></div>
        <div class="kclist">
            <p class="kclbtitle">课程列表</p>
            <table cellpadding="0" cellspacing="0" class="tablekclist">
                <tr class="first">
                    <td width="194">课程名称</td>
                    <td width="106">教师</td>
                    <td width="94">学生总数</td>
                    <td width="94">参与人数</td>
                    <td width="106">状态</td>
                    <td width="96">操作</td>
                </tr>
                <?php if(!empty($courselist)){foreach($courselist as $course){?>
                    <tr>
                        <td><?php echo $course['coursename']?></td>
                        <td><?php echo empty($course['realname'])?$course['username']:$course['realname']?></td>
                        <td><?php echo $course['studentsnum']?></td>
                        <td><?php echo empty($course['answernum'])?0:$course['answernum']?></td>
                        <td><?php if(empty($course['s_endtime'])&&empty($course['s_starttime'])){echo '问卷编辑中';}elseif($course['s_endtime']<SYSTIME){echo '评价结束';}else{echo '收集评价';}?></td>
                        <td>
                            <a href="/aroomv2/xuanke/stat/<?php echo $course['sid']?>.html" target="_blank" class="xkcka">查看</a>
                        </td>
                    </tr>
                <?php }}else{?>
                    <tr class="zwnr1s"><td colspan="6" style="border:none;"><div class="nodata"></div></td></tr>
                <?php }?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
