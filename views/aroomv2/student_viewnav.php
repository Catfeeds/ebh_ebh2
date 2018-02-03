<?php $this->display('aroomv2/page_header')?>
	<?php $roominfo = Ebh::app()->room->getcurroom();?>
<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> > 学生查看
    </div>
    <div class="studentcheck_gf mt15">
    	<ul>
        	
        	<?php if ($roominfo['domain'] == 'www.leblue') { ?>
        		<li class="studentcheck_p_ln fl" style="background:url(http://static.ebanhui.com/ebh/tpl/aroomv2/images/studentcheck_p_ln.jpg) no-repeat center; width:231px; height:231px;"><a href="/aroomv2/student/view.html"></a></li>
				<li class="expstuleareco_p_ln fl"><a href="/aroomv2/report/ssreport.html"></a></li>
            <?php } else { ?>
            	<li class="studentcheck_p fl"><a href="/aroomv2/student/view.html"></a></li>
                <li class="expstuleareco_p fl"><a href="/aroomv2/report/ssreport.html"></a></li>
            <?php } ?>
            
			<li class="xuebapaiming_p fl"><a href="/aroomv2/student/creditlevel.html"></a></li>
			<li class="studentschcredit_p fl"><a href="/aroomv2/student/schcreditreport.html"></a></li>
        </ul>
    </div>
</div>
</body>
</html>


