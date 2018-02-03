<?php $this->display('aroomv2/page_header')?>
<style>
.rtyutyt {display: inline;float: left;margin: 10px 0 0 10px;}
.egory { color: #505050;float: left;font-weight: bold;margin: 10px 10px 0;width: 95px;}
.lefrig .txkels {height: 50px;margin: 20px 0 0 20px;width: 175px;}
.txkels .jifenico {background: url("http://static.ebanhui.com/ebh/tpl/default/images/jifenico.jpg") no-repeat  left top;height: 15px; line-height: 15px;
padding-left: 20px;}
</style>
<body>
<div class="cright" style="margin-top:0;">
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/student/viewnav.html">学生查看</a> >
        学霸排名
    </div>
    <?php 
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(empty($roominfo['crid'])){
        	$is_zjdlr = false;
        	$is_newzjdlr = false;
        }else{
	        $appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);        	
        }    
    ?>
    <div style="background:#fff;float:left;margin-top:15px;width:788px;" class="lefrig">
		<?php if(!empty($students)) { ?>
		<ul style="width:786px;">
			<?php foreach($students as $student) { 
				if($student['sex'] == 1) {
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				 } else {
					 $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
				 }
				$face = empty($student['face']) ? $defaulturl : $student['face'];
				$face = getthumb($face,'50_50');
			?>
				<li class="txkels fl">
					<div class="fl"><img src="<?= $face?>" style="width:50px;height:50px"></div>
					<div style="line-height:18px;" class="p2"><p style="width:95px;height:18px; overflow:hidden;"><b style="color:#333;"><?= shortstr($student['realname'],8,'')?>（<?= $student['sex']==1?'女':'男'?>）</b></p>
					<?php if(!$is_zjdlr){?>
					<p style="color:#808080;"><?=$student['jifen_data']?></p>
					<?php }else{ ?>	
					<div style="margin-top:17px;"></div>
					<?php }?>
					<p style="color:#9e9ea0 !important;" class="jifenico"><?= $student['credit']?></p></div>
				</li>
			<?php } ?> 
            
		</ul>
        <?php } ?> 

    </div>
		<?= $pagestr ?>
</div>
</body>
</html>
