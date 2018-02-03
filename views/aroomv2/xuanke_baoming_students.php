<?php $this->display('troomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > 报名结果
    </div>
    <div class="crightbottom">
        <div class="xktitles" style="border-bottom:none;"><?php echo $xuanke['name']?></div>
        <div class="work_mes">
            <ul class="extendul">
                <li><a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>"><span>活动动态</span></a></li>
                <li><a href="/aroomv2/xuanke/view.html?xkid=<?php echo $xkid?>"><span>活动详情</span></a></li>
                <li><a href="/aroomv2/xuanke/courselist.html?xkid=<?php echo $xkid?>"><span>课程列表</span></a></li>
                <li class="workcurrent"><a href="/aroomv2/xuanke/baoming_students.html?xkid=<?php echo $xkid?>"><span>报名结果</span></a></li>
				<?php $this->display('aroomv2/xuanke_pause')?>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="akcaxsfl">
            <a href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $xkid?>" class="ankcfl ">按课程</a>
            <a href="javascript:;" class="ankcfl onhover">按学生</a>
			
        </div>
		
		<div class="hdjsckanbtn"><a href="/aroomv2/xuanke/exportexcelall.html?xkid=<?=$xkid?>" class="tzdel tzadd">全部导出</a></div>
        <div class="clear"></div>
        <!--按学生-->
        <div class="axsmyfa">
            <div class="axsmyfalist">
                <div class="fl" style="width:42px;"><span class="nianji">年级：</span></div>
                <div class="fl" style="width:698px;"><a href="/aroomv2/xuanke/baoming_students.html?xkid=<?php echo $xkid;if(!empty($unsign))echo '&unsign=1' ?> " class="<?php if($gradeid<0)echo 'xzhover'?>">全部</a>
                <?php  $gradename = Ebh::app()->getConfig('')->load('grademap');$gradename[0]='其他班级'?>
                <?php if(!empty($grade)){foreach($grade as $g){if(!empty($g['grade'])){?>
                <a href="/aroomv2/xuanke/baoming_students.html?grade=<?php echo $g['grade']?>&xkid=<?php echo $xkid;if(!empty($unsign))echo '&unsign=1'?>" class="<?php if($g['grade']==$gradeid)echo 'xzhover'?>"><?php echo $gradename[$g['grade']]?></a>
                <?php }}}?>
                <?php if(isset($grade[0])){?>
                <a href="/aroomv2/xuanke/baoming_students.html?grade=0&xkid=<?php echo $xkid;if(!empty($unsign))echo '&unsign=1'?>" class="<?php if(isset($gradeid)&&$gradeid==0)echo 'xzhover'?>">其他班级</a>
                <?php }?>
<!--                <a href="javascript:;" class="xzhover">二年级</a>-->
				</div>
			<div class="clear"></div>
            </div>
            <div class="axsmyfalist" style="width: 740px;">
                <div class="fl" style="width:42px;"><span class="nianji">班级：</span></div>
                <div class="fl" style="width:698px; "><a href="/aroomv2/xuanke/baoming_students.html?xkid=<?php echo $xkid;if($gradeid>=0)echo '&grade='.$gradeid;if(!empty($unsign))echo '&unsign=1'?>" class="<?php if($classid<0)echo 'xzhover'?>">全部</a>
                <?php if($show>=0){ foreach($classes as $class){?>
                <a class="<?php if($class['classid']==$classid) echo 'xzhover'?>" style="white-space:nowrap;" href="/aroomv2/xuanke/baoming_students.html?classid=<?php echo $class['classid']?>&xkid=<?php echo $xkid;if(!empty($unsign))echo '&unsign=1'?>&grade=<?php echo $class['grade']?>"><?php echo $class['classname']?></a>
                <?php }}?>
				</div>
            </div>
			<div class="clear"></div>
            <div class="axsmyfalist">
                <span class="nianji">报名情况：</span>
                <a href="baoming_students.html?xkid=<?=$xkid?><?php if($gradeid>=0)echo '&grade='.$gradeid;if($classid>0)echo '&classid='.$classid;?>" class="<?php if(empty($unsign))echo 'xzhover'?>">已报名</a>
                <a href="baoming_students.html?unsign=1&xkid=<?=$xkid?><?php if($gradeid>=0)echo '&grade='.$gradeid;if($classid>0)echo '&classid='.$classid;?>" class="<?php if(!empty($unsign))echo 'xzhover'?>">未报名</a>
            </div>
            <div class="clear"></div>
            <?php if($classid> 0) { ?><div class="hdjsckanbtn"><a href="/aroomv2/xuanke/exportexcel.html?classid=<?=$classid?>&xkid=<?=$xkid?>" class="tzdel tzadd">导出excel</a></div><?php } ?>
        </div>
        <table cellpadding="0" cellspacing="0" class="bmlist" style="width:750px; margin-top:25px;">
            <tr class="bmlistfir">
                <td width="193">学生信息</td>
                <td width="203">所属班级</td>
                <td width="202">报名时间</td>
                <td width="116">操作</td>
            </tr>
            <?php if(!empty($studentlist)){ foreach($studentlist as $student){?>
                <tr>
                    <td>
                        <div style="float:left;padding:0 10px 0 15px;">
                            <?php
                            if($student['sex'] == 1)
                                $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                            else
                                $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                            $face = empty($student['face']) ? $defaulturl:$student['face'];
                            $face = str_replace('.jpg','_50_50.jpg',$face);
                            ?>
                            <a href="javascript:;"><img class="touxyuan" src="<?php echo $face?>"></a>
                        </div>
                        <div style="width:95px;float:left;">
                            <span class="renming" title="<?=empty($student['realname']) ? $student['username'] : $student['realname']?>"><?php echo empty($student['realname'])?shortstr($student['username'], 8):shortstr($student['realname'],8)?></span>
                            <span class="xingbie" <?php  if($student['sex']==0) echo "style=\"background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png') \"" ?>></span>
                            <div style="clear:both;"></div>
                            <span class="renming1"><?=$student['username']?></span>
                        </div>
                    </td>
                    <td style="text-align:center;"><?php echo $student['classname']?></td>
                    <td style="text-align:center;"><?php if($unsign==1){echo '--';}else{echo !empty($student['sign_time']) ? date('Y-m-d H:i',$student['sign_time']) : '--';}?></td>
                    <td style="text-align:center;">
                        <?php if($unsign==1){?>
                            -
                        <?php }else{?>
                            <a href="student_view.html?uid=<?php echo $student['uid']?>&xkid=<?php echo $xkid?>" target="_blank" class="tzdel tzadd tzadd1s">查看</a>
                        <?php }?>
                    </td>
                </tr>
            <?php }}else{?>
                <tr class="zwnr1s"><td colspan="4" style="border:none;"><div class="nodata"></div></td></tr>
            <?php }?>
        </table>
        <?php echo $pagestr?>
    </div>

</div>
<style>
span.nianji{
	line-height:27px;
}
</style>
<script>
	$(function(){
		$('.bmlist tr:last td').css('border-bottom','none');
	});
</script>
</body>
</html>
