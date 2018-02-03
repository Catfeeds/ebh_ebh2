<?php $this->display('troom/page_header');?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001"></script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
		<div class="ter_tit">
		当前位置 > <?php if($helpcrid != $moduleid) { ?><a href="<?= geturl('troom/fullcourse-0-0-0-'.$moduleid) ?>">所有课程</a> > <?php } ?><?=$course['foldername']?> > <?= $course['title'] ?>
		</div>
	<div class="lefrig" style="margin-top:15px;">

			<div class="classbox">
				<h1>课件名:<?= $course['title'] ?></h1>
				<div class="classboxmore">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname']?>    <span>时间：<?=  date('Y.m.d',$course['dateline'])?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px 0;">
					<?php if( preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) { ?>
						<?php if ($roominfo['isschool'] == 4) { ?>
						<input name="" onclick="playdemand('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>',1,0)" class="huangbtn marrig" value="开始听课" type="button" />
						<?php } else { ?>
						<input name="" onclick="freeplay('<?=$course['cwsource']?>','<?=$course['cwid']?>','<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
						<?php } ?>
				
					<?php } else if(!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
				
						<input name="" onclick="location.href='<?= $course['cwsource'].'attach.html?cwid='.$course['cwid'].'&fromid='.$roominfo['crid']?>'" class="lanbtn marrig" value="下载文件" type="button" />
					<?php } ?>
					<input name="" class="lanbtn" onclick="javascript:history.back();" value="返回" type="button" />
					</p>
				</div>
			</div>
			
			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])){?>
				<div style=" position: relative;height:600px;z-index:601;float:left;margin-left:20px;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
		
			<?php if(!empty($exams)) { ?>
			<div class="work_menuss">
					<ul>
					<li class="workcurrent"><a style="font-size:12px;"><span>在线测评</span></a></li>
					</ul>
			</div>
				<div class="incont">
						<table width="100%" class="datatab">
							<thead class="tabhead">
								<tr>
									<th>作业名称</th>
									<th>出题时间</th>
									<th>总分</th>
									<th>操作</th>
							 	</tr>
							  </thead>
								<tbody>

											 <?php foreach($exams as $exam) { ?>
											  <tr>
												<td width="65%"><?= $exam['title'] ?></td>
												<td width="18%"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
												<td width="7%"><?= $exam['score'] ?></td>
												<td width="10%">
														<a class="previewBtn" href="http://exam.ebanhui.com/do/<?= $exam['eid'] ?>.html" target="_blank"><span>在线答题</span></a>
												</td>
											  </tr>
											  <?php } ?>
											
							  </tbody>
						</table>
				</div>
			<?php } ?>
			<div class="work_mes" style="border:none;">
					<ul>
					<li class="workcurrent"><a style="font-size:12px;"><span>课件介绍</span></a></li>
					</ul>
			</div>
			<div class="incont">
					<?= $course['message'] ?>
			</div>
			<div id='atsrc' style="display: none;"></div>
			
<style>
.work_menuss{
	width:788px; 
	border:none; 
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/workmenubg_003.jpg);
	padding-top:0;
}
.incont{
	background:#fff;
	width:788px;
}
</style>
<script defer="defer" type="text/javascript">	
$(function(){
     $(".atfalsh").click(function(){
		var attid = $(this).attr('aid');
		var source = $(this).attr('source');
		var suffix = $(this).attr('suffix');
		var title = $(this).attr('title');
		playatt(source,attid,suffix,title);
	});
});
    $(function(){
		var cwid = <?= $course['cwid'] ?>;
		var source = "<?= $course['cwsource'] ?>";
        var isfree = <?= $course['isfree'] ?>;
        var num = 1; //教室内
        playflv(source,cwid, '', isfree, num, '562', '750');
    });
function closeLightFun(opens){	//开关灯方法
	
	$("#showdiv").css("height", $(document).height());
		if(opens==1){
			$("#showdiv").toggle();  
		}
		else if((opens==2)){
			$("#showdiv").toggle(); 
		}
}
</script>
<div style="display:none;" class="Offl" id="showdiv"></div>

<?php 
$this->display('common/player');
$this->display('troom/page_footer');
?>