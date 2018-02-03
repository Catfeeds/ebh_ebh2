<?php $this->display('home/page_header'); ?>
<div class="">
<!--第一个div是测试看页面的，引用头部后会自带的，要去掉的-->
<div class="ter_tit">
当前位置 > <a href="<?= geturl('home/largedb') ?>">历史数据</a> > 历史作业
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="txtname" <?=$stylestr?> class="newsou" id="txtname" value="<?= $q?>" type="text" />
	<input type="button" onclick="searchs('txtname');return false;" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
<div class="weaktil">
<span class="datek">历史作业</span>
</div>
<script type="text/javascript">
	function searchs(strname){
		var sname = $('#'+strname).val();
		if(sname=='请输入搜索关键字'){
			sname = "";
		}
		location.href='<?= geturl('home/largedb/exam')?>?q='+sname;
	}
</script>
<!--学习数据开始-->
<div class="workol">
<div class="workdata" style="float:left">
<table width="100%" style="border:none;" class="datatab">
	<tbody>
    	<?php $tcount = 0; $target='_bank'; ?>
    	<?php if(!empty($exams)) { ?>
        <?php foreach($exams as $log) { ?>
		<?php 
            if(!empty($log['face'])){
                $face = getthumb($log['face'],'50_50');
            }else{
                if($log['sex']==1){
                    $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                }else{
                    $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                }
            
                $face = getthumb($defaulturl,'50_50');
            } 
			$tcount++;
		?>  
		<tr>
        	<?php if($tcount == 1){ ?>
            <td style="border-top:none">
			<?php } else { ?>
            <td>
			<?php } ?>
				<div style="float:left;width:772px;font-family:Microsoft YaHei;">
                    <p style="width:500px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
                        <?php if($log['astatus'] == 1) { ?>
								<a style="color:#777;font-weight:bold;" href="http://exam.ebanhui.com/emark/<?= $log['eid'] ?>.html" target="<?= $target?>"><?= shortstr($log['title'],50) ?></a>
						<?php } else { ?>
								<a style="color:#777;font-weight:bold;" href="http://exam.ebanhui.com/edo/<?= $log['eid'] ?>.html" target="<?= $target?>"><?= shortstr($log['title'],50) ?></a>
						<?php } ?>
                    </p>
                    <span style="float:right;"><a href="<?=$log['murl']?>" target="_blank"><?= shortstr($log['crname'],40)?></a></span>
                    <div style="float:left;width:772px;">
                        <span style="width:134px;float:left;">出题老师：<?= shortstr($log['realname'],7) ?></span>
                        <span style="width:155px;float:left;">出题时间：<?= date('y-m-d H:i',$log['dateline'])?></span>
                        <span style="width:155px;float:left;">答题时间：<?= empty($log['adateline']) ? '暂无时间' : date('y-m-d H:i',$log['adateline'])?></span>
                        <span style="width:85px;float:left;">用时：<?= ceil($log['completetime']/60)?>分钟</span>
                        <span style="width:95px;float:left;">总分/得分：<?= $log['score']?>/<?= round($log['totalscore'],2) ?></span>
                        <span style="width:77px;float:left;">已答人数：<?= $log['answercount']?></span>
                        <span style="width:69px;float:left;">
						<?php if($log['astatus'] == 1) { ?>
								<a class="lviewbtn" href="http://exam.ebanhui.com/emark/<?= $log['eid'] ?>.html" target="<?= $target?>">查看结果</a>
						<?php } else { ?>
								<a class="previewBtn" href="http://exam.ebanhui.com/edo/<?= $log['eid'] ?>.html" target="<?= $target?>">继续答题</a>
						<?php } ?>
                        </span>
                    </div>		
				</div>
            </td>
        </tr>
        <?php } ?>
	<?php } else { ?>
		<tr><td colspan="5" align="center">暂无记录</td></tr>
	<?php } ?>	
</tbody>				
</table>
<?= $pagestr ?>
</div>
<!--学习数据结束-->
</div>
</div>
<script type="text/javascript">
$(function(){
		var searchText = "请输入搜索关键字";
		initsearch("txtname",searchText);
});
</script>
<?php $this->display('home/page_footer'); ?>