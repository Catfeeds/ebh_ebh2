<?php $this->display('aroomv2/page_header')?>
<body>
<div class="studymonitoring">
	
    <div class="mt5">
    	<table cellpadding="0" cellspacing="0" class="tables">
        	<tr  >
                <td width="83" style="background:#f7faff ; border-right:1px solid #e1e1e1">课件名称</td>
                <td colspan="5" class="second"><?=Date('Y-m-d H:i:s',$cwinfo['dateline'])?> <?=$cwinfo['title']?><!--,121人已学，80人未学--></td>
            </tr>
            <tr  class="first">
                <td width="84">班级名称</td>
                <td width="184">学生</td>
                <td width="117">首次学习</td>
                <td width="117">最后学习</td>
                <td width="124">总时长</td>
                <td width="88">累计次数</td>
            </tr>
			<?php 
			$rurl = $this->input->get('rurl');
			$rrurl = $this->input->get('rrurl');
			if(!empty($playloglist)){
				foreach($playloglist as $playlog){
					$face = '';
					$face = getthumb($playlog['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($playlog['sex'])?'m_man_50_50.jpg':'m_woman_50_50.jpg');
					?>
            <tr>
                <td width="84"><?=$playlog['classname']?></td>
                <td width="184"><div class="fl"><img src="<?=$face?>" style="width:50px; height:50px;" /></div><p class="p2"><b><?=$playlog['realname']?>（<?=empty($playlog['sex'])?'男':'女'?>）</b><br /><?=$playlog['username']?></p></td>
                <td width="117"><?=Date('Y-m-d H:i:s',$playlog['startdate'])?></td>
                <td width="117"><?=Date('Y-m-d H:i:s',$playlog['lastdate'])?></td>
                <td width="124"><?=secondToStr($playlog['ltime'])?></td>
                <td width="88"><?=$playlog['logcount']?></td>
            </tr>
				<?php }
			}else{?>
				 <tr>
					<td colspan=6 style="text-align:center;">暂无学习监控记录</td>
				</tr>
			<?php } ?>
    	</table>
    </div>
    <div class="button2 fr"><?php if (!empty($rurl)) {?><a href="/<?=$rurl?>.html?rurl=<?=$rrurl?>">返 回</a><?php }?></div>
    <?=$pagestr?>
</div>
</body>
</html>
