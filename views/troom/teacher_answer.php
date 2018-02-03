<?php $this->display('troom/page_header')?>
<body>
<div>
<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
?>
	<?php
	if($rurl == 'aroomv2/teacher/teacherlist'){?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/teacher/viewnav')?>"> 教师查看 </a> > <a href="<?=geturl('aroomv2/teacher/teacherlist')?>"> 教师列表 </a> > 答疑查看
	<?php }else{?>
		当前位置 > <a href="/troom/statisticanalysis.html">查询统计</a> > <a href="/troom/statisticanalysis/teach.html"> 教师统计 </a> > 答疑查看
	<?php }?>
	</div>

<div class="queanswcheck">
	<table cellpadding="0" cellspacing="0" class="tables" >
    	<tr  class="second">
        	<td width="786"  colspan="7">
           		<div>
                     <div class="teacher fl"><b style="font-size:16px;">教师:</b></div>					
                    <div class="xingming_p fl" style="font-size:16px;"><?=$tuser[0]['realname']?>　(<?=empty($tuser[0]['sex'])?'男':'女'?>)　<?=$tuser[0]['username']?></div>
                    <div class="quest fl" style="font-size:16px;"><p>　　该教师共回答了 <?= empty($totalanswercount)?0:$totalanswercount ?> 个问题</p></div>
                        <ul style="padding-top:5px;">
							<?php $selfolderid = $this->input->get('selfolderid');
							
							?>
							<li class="fl"><a href="<?=geturl('aroomv2/teacher/answer/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>" class="<?=empty($selfolderid)?'select':''?>">不限</a></li>
							<?php
							foreach($folderlist as $folder){
							?>
							<li class="fl"><a href="<?=geturl('aroomv2/teacher/answer/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&selfolderid=<?=$folder['folderid']?>" class="<?=$selfolderid==$folder['folderid']?'select':''?>"><?=$folder['foldername']?></a></li>
							<?php }?>
						</ul>
                    
                </div>
                <div class="clear"></div>
            </td>
        </tr>
        <tr   class="first">
            <td width="215">问题</td>
            <td width="111">所属课程</td>
            <td width="148">提问时间</td>
            <td width="55">回答数</td>
            <td width="58">问题状态</td>
            <td width="127">查看详情</td>
        </tr>
		<?php foreach($answerlist as $answer){?>
        <tr >
            <td width="215"><p style="word-wrap: break-word;float:left;"><?=empty($answer['shield'])?$answer['title']:'<p style="color:#f00;">该问题已屏蔽</p>'?></p></td>
            <td width="111"><?=$answer['foldername']?></td>
            <td width="148"><?=Date('Y-m-d H:i:s',$answer['dateline'])?></td>
            <td width="55"><?=$answer['answercount']?></td>
            <td width="58">
			<?php if(empty($answer['hasbest'])){?>
			<p style="color:#f00;">未解决</p>
			<?php }else{?>
			<p >已解决</p>
			<?php }?>
			</td>
            <td width="127">
				<?php if(empty($answer['shield'])){?>
					<a href="<?=geturl('troom/myask/'.$answer['qid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">
					查看详情</a>
					<a href="javascript:void(0)" onclick="qshield(<?=$answer['qid']?>,1)">
					屏蔽</a>
				<?php }else{?>
					<a href="javascript:void(0)" onclick="qshield(<?=$answer['qid']?>,-1)">
					取消屏蔽</a>
				<?php }?>
			</td>
        </tr>
		<?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rurl?>.html?rurl=">返 回</a></div>
    
	<?=$pagestr?>
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
