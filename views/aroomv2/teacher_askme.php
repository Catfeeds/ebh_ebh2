<?php $this->display('aroomv2/page_header')?>
<body>
<div>
<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
$rrurl = $this->input->get('rrurl');
?>
	<?php 
	if($rurl == 'aroomv2/ask'){?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/ask')?>"> 答疑查看 </a> > 指定提问
	<?php }else{?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/report/teacher')?>"> 教师统计 </a> > 指定提问
	<?php }?>
	</div>
<div class="toview">
	<table cellpadding="0" cellspacing="0" class="tables">
    	<tr class="second">
        	<td width="786"  colspan="7">
           		<div>
                    <div class="teacher fl"><b style="font-size:16px;">教师:</b></div>
					
                    <div class="xingming_p fl" style="font-size:16px;"><?=$tuser[0]['realname']?>　(<?=empty($tuser[0]['sex'])?'男':'女'?>)　<?=$tuser[0]['username']?></div>
                    <div class="quest fl" style="font-size:16px;"><p>　　全部：<?=$askstate['asknum']?>  已解决：<?=$askstate['bestnum']?>  未解决：<?=$askstate['asknum']-$askstate['bestnum']?></p></div>
					<?php if(!empty($startdate) || !empty($enddate)){?>
					<div style="font-size:16px;"><p>　　　时间段:<?=$startdate?>到<?=$enddate?></p></div>
					<?php } ?>
                    <ul style="padding-top:5px; maxheight:150px; overflow:auto;">
                       
                        <?php $selfolderid = $this->input->get('selfolderid');
					?>
                    <li class="fl"><a href="<?=geturl('aroomv2/teacher/askme/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>" class="<?=empty($selfolderid)?'select':''?>">不限</a></li>
					<?php
					foreach($folderlist as $folder){
					?>
                    <li class="fl"><a href="<?=geturl('aroomv2/teacher/askme/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&selfolderid=<?=$folder['folderid']?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>" class="<?=$selfolderid==$folder['folderid']?'select':''?>"><?=$folder['foldername']?></a></li>
                    <?php }?>
                    </ul>
                </div>
                <div class="clear"></div>
            </td>
		
        </tr>
		
        <tr class="first">
            <td width="150">提问人</td>
            <td width="155">问题</td>
            <td width="85">所属学科</td>
            <td width="93">提问时间</td>
            <td width="45">回答数</td>
            <td width="72">未答/已答</td>
            <td width="114">操作</td>
        </tr>
        <?php foreach($asklist as $ask){
			$face = getthumb($ask['face'],'50_50');
			if(empty($face))
				$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($ask['sex'])?'m_man_50_50.jpg':'m_woman_50_50.jpg');
			?>
        <tr>
            <td width="150"><div class="fl"><img src="<?=$face?>" style="height:50px; width:50px;" /></div><p class="p2s" style="width:90px !important;"><b><?=$ask['realname']?>(<?=empty($ask['sex'])?'男':'女'?>)</b><br /><?=$ask['username']?></p></td>
            <td width="155"><p style="width:155px;word-wrap: break-word;float:left;"><?=empty($ask['shield'])?$ask['title']:'<p style="color:#f00;">该问题已屏蔽</p>'?></p></td>
            <td width="85"><?=$ask['foldername']?></td>
            <td width="93"><?=Date('Y-m-d H:i:s',$ask['dateline'])?></td>
            <td width="45"><?=$ask['answercount']?></td>
            <td width="72"><?=($ask['answered'])?'已答':'<span style="color:#f00">未答</span>'?></td>
            <td width="114"><?php if(empty($ask['shield'])){?>
					<a href="<?=geturl('aroomv2/information/ateaask/'.$ask['qid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">
					查看详情</a>
					<a href="javascript:void(0)" onclick="qshield(<?=$ask['qid']?>,1)">
					屏蔽</a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="qshield(<?=$ask['qid']?>,-1)">
					取消屏蔽</a>
				<?php }?></td>
        </tr>
		<?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rurl?>.html">返 回</a></div>
	<?=$pagestr?>
</div>
</div>
</body>
<script>
function qshield(qid,shield){
	$.ajax({
		url:'/aroomv2/ask/qshield.html',
		type:'post',
		data:{'qid':qid,'shield':shield},
		success:function(){
			location.reload(true);
		}
		
	});
}
</script>
</html>
