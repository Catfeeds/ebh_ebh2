<?php $this->display('aroomv2/page_header')?>
	<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
	<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;
	$roominfo = Ebh::app()->room->getcurroom();	
	?>	
<body>
<div>
    <div class="ter_tit">
        当前位置 > 统计分析
    </div>
    <div class="statisticalanalysis mt15">
		<?php if(!empty($haspower) && $haspower == 3) { ?>
		<ul>
            <li class="coursecheck_p fl"><a href="/aroomv2/report/course.html"></a></li>
            <li class="operationview_p fl"><a href="/aroomv2/exam.html"></a></li>
            <li class="questionanswercheck_p fl"><a href="/aroomv2/ask.html"></a></li>
            <!--类名修改为studentcheck_p_qy，就变为企业版的员工查看-->
            <?php if ($roominfo['domain'] == 'www.leblue') { ?>
				<li class="studentcheck_p_ln1 fl"><a href="/aroomv2/student/viewnav.html"></a></li>
            <?php } else { ?>
                <li class="<?=($room_type == 1) ? "studentcheck_p_qy":"studentcheck_p"?> fl"><a href="/aroomv2/student/viewnav.html"></a></li>
            <?php } ?>
			
			
			<li class="curriculumview_p fl"><a href="/aroomv2/report/coursebrowse.html"></a></li>
        </ul>
		<?php } else { ?>
    	<ul>
			<?php if($this->uri->uri_domain() != 'zjgxedu') { ?>
			
			
			<?php if ($roominfo['domain'] == 'www.leblue') { ?>
				<li class='teacherstatistics_p_ln fl'><a href='/aroomv2/report/teacher.html'></a></li>	
	        	
	            <li class="teachercheck_p_ln fl"><a href="/aroomv2/teacher/viewnav.html"></a></li>
            <?php } else { ?>
                <!--类名修改为teacherstatistics_p_qy，就变为企业版的讲师统计-->	
				<li class='<?=($room_type==1) ? "teacherstatistics_p_qy":"teacherstatistics_p"?> fl'><a href='/aroomv2/report/teacher.html'></a></li>	
	        	<!--类名修改为teachercheck_p_qy，就变为企业版的讲师查看-->
	            <li class="<?=($room_type==1) ? "teachercheck_p_qy":"teachercheck_p"?> fl"><a href="/aroomv2/teacher/viewnav.html"></a></li>
            <?php } ?>
			
			
			
			
			
			<?php } ?>
            <li class="coursecheck_p fl"><a href="/aroomv2/report/course.html"></a></li>
			<?php if($this->uri->uri_domain() != 'zjgxedu') { ?>
            <li class="operationview_p fl"><a href="/aroomv2/exam.html"></a></li>
			<?php } ?>
            <li class="<?=$this->uri->uri_domain() != 'zjgxedu'?'questionanswercheck_p':'questionanswercheck_zjgxedu_p'?>  fl"><a href="/aroomv2/ask.html"></a></li>
           
            
            
            <!--类名修改为studentcheck_p_qy，就变为企业版的员工查看-->
			<?php if ($roominfo['domain'] == 'www.leblue') { ?>
				<li class="studentcheck_p_ln1 fl"><a href="/aroomv2/student/viewnav.html"></a></li>
            <?php } else { ?>
                <li class="<?=($room_type == 1) ? "studentcheck_p_qy":"studentcheck_p"?> fl"><a href="/aroomv2/student/viewnav.html"></a></li>
            <?php } ?>
			
			
			
			
			<li class="curriculumview_p fl"><a href="/aroomv2/report/coursebrowse.html"></a></li>
		<?php if(!empty($modulecredit)){ ?>
			<li class="schcreditstatistics_p fl"><a href="/aroomv2/schcreditreport.html"></a></li>
		<?php }?>
        </ul>
		<?php } ?>
    </div>
</div>
</body>
</html>

