<?php $this->display('myroom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style>
.tabhead th {
	background:#fff;
	color:#18a8f7;
	font-size:16px;
	font-weight:bold;
	border-bottom:1px solid #eee;
}
.datatab td {
  border: none;
  padding: 0px;
}
.datatab {
	margin-top:10px;
}
.waifdg {
	width:100px;float:left;line-height:90px;text-align:center;
}
.datatab a.jisnt {
	color:#fff;font-size:18px;width:60px;height:30px;line-height:30px;background:#fd8155;display:block;margin:38px 0 0 20px;
	*margin:38px 0 0 0;
}
.datatab a.fhbdf {
	color:#fff;font-size:18px;width:60px;height:30px;line-height:30px;background:#2fb5ff;display:block;margin:38px 0 0 20px;
	*margin:38px 0 0 0;
}
.jgers {
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/rsgeg.jpg) no-repeat;position: absolute;width:20px;height:20px;top:48px;left:93px;z-index: 1;
}
.fiewe {
	float:left;width:655px;border-bottom:solid 1px #eee;padding:10px 15px;border-left:solid 1px #eee;
}
.kergde {
	line-height:2;color:#999;width:570px;float:left
}
.rgerks {
	float:left;margin-right:15px;margin-left:18px;
}
.countdownspan{
	float:left;line-height:2;margin-top:6px;margin-left:6px;color:red;font-weight:bold;text-align:center;width:88px;
}

.datatab a.exceed{
	color:#fff;font-size:18px;width:60px;height:30px;line-height:30px;background:#EEE;display:block;margin:38px 0 0 20px;
	*margin:38px 0 0 0;
}
.tdexceed{
	background:#FAFAFA;
}
.circledisplay{
	display:none;
}
.picwrap .imgst {
  height: 103px;
  transition: all 1s ease 0s;
  width: 178px;
}
.picwrap:hover .imgst {
    transform: scale(1.1);
}

</style>
	<?php
		//$mediatype = array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov');
		$deflogo = 'http://static.ebanhui.com/ebh/tpl/default/images/178_kete.jpg';
	?>
	<script>
		function errorHandler(){
			var cwid = $(this).attr('cwid');
			var size = '178_103';
			var me = this;
			$.ajax({
		        type: "POST",
		        url: "<?=geturl('imghandler')?>",
		        data: {cwid:cwid,size:size,type:'courseware_logo'},
		        dataType: "json",
		        success: function(data){
		        	if(data && (data.status == 0) ){
		        		$(me).attr('src',data.url+'?v=1');//v=1 你猜这是干什么的 O(∩_∩)O哈哈~
		        	}
		        	$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
		        	$(me).unbind('error');
		        },
		        error:function(){
		        	$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
		        	$(me).unbind('error');
		        }
	    	});
		}
	</script>
	<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/stusubject') ?>">学习课程</a> > 最新课程
	</div>
	<div class="lefrig" style="background:#fff">
	<div style="margin-top:15px;">
		<?php 
		$dayarr = array('today'=>'今天','week'=>'本周','month'=>'本月','other'=>'');
		$totalcount;
		$needCDArr = array();
		foreach($newcwlist as $k=>$listbyday){
		if((!empty($listbyday) && $k!='other') || ($k=='other' && empty($newcwlist['today']) && empty($newcwlist['week']) && empty($newcwlist['month']))){
			$find = array('x','y','z');
			$replace = '';
			$k = str_replace($find,$replace,$k);
		?>
		
		<table width="100%" class="datatab" id="tb<?=$k?>" style="<?=(empty($roominfo['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':'border:none;'?>">
			<thead class="tabhead">
				<tr>
					<?php if($k!='other' || ($k=='other' && !empty($day))){?><th>
					<a href="javascript:void(0)" style="color:#18a8f7;text-decoration:none" onclick="showcws('<?=$k?>')"><?=$k?>(<?=count($listbyday)?>)</a></th>
					<?php }?>
					
				</tr>
			</thead>
			<?php if(!empty($listbyday)){
				foreach($listbyday as $cw){
//					$arr = explode('.',$cw['cwurl']);
//					$type = $arr[count($arr)-1];
//					$target=(empty($cw['cwurl']) || in_array($type,$mediatype))? '_blank' : '';
					$target='_blank';
					$url = geturl('myroom/mycourse/'.$cw['cwid']);
				?>
			<tbody>
				<tr>
				<?php 
					$tdexceed = '';
					$circledisplay = '';
					$position = 'relative';
					$timeclass = ($k=='今天')?'jisnt':'fhbdf';
					if(!empty($cw['endat']) && SYSTIME >$cw['endat']){
						$timeclass = 'exceed';
						$tdexceed = 'tdexceed';
						$circledisplay = 'circledisplay';
						$position = 'static';
					}
				?>
					<td class="<?=$tdexceed?>">
					<div style="position: <?=$position?>">
					<div class="jgers <?=$circledisplay?>"></div>
					<?php $timetitle = '';
						if(!empty($cw['submitat']) && $cw['submitat']>SYSTIME){
							$timetitle = '于 '.Date('Y-m-d H:i',$cw['truedateline']).'开课,敬请期待...';
							$needCDArr[] = array('cwid'=>$cw['cwid'],'truedateline'=>$cw['truedateline']);
						}
					?>
					<div class="waifdg"><a target="<?=$target?>" href="<?=$url?>" class="<?=$timeclass?>" title="<?=$timetitle?>"><?=Date('H:i',$cw['truedateline'])?></a>
					<?php if(!empty($cw['submitat']) && !empty($cw['cwlength']) && ($cw['submitat']+$cw['cwlength']>SYSTIME && SYSTIME>$cw['submitat'])){
					?>
					<span style="float:left;line-height:2;margin-top:6px;margin-left:20px;color:red;font-weight:bold">正在上课...</span>
					<?php
					}elseif($k=='今天'){?>
					<span class="countdownspan cw_<?=$cw['cwid']?>"></span>
					<?php }?>
					</div>
					<?php 					
					if($cw['sex'] == 1) {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					} else {
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}
					$face = empty($cw['face']) ? $defaulturl : $cw['face'];
					$face = getthumb($face,'50_50');
					?>
					<!-- =====内容开始====== -->
					<?php
						if(!empty($cw['coursewarelogo'])){
							$logo = !empty($cw['logo'])?getthumb($cw['logo'],'178_103'):$deflogo;
							$style = 'style="width:430px;"';
						}else{
							$logo = '';
							$style = '';
						}
					?>
					<div class="fiewe">
							<?php if(!empty($logo)){?>
								<a class="picwrap" href="<?=$url?>" target="<?=$target?>" style="display:block;float:left;width:200px;height:auto;text-decoration:none;">
									<img class="imgst" cwid="<?=$cw['cwid']?>" onerror="errorHandler.call(this)" src="<?=$logo?>" />
								</a>
							<?php }else{?>
								<div class="rgerks" style="float:left;">
									<img src="<?=$face?>">
								</div>
							<?php }?>
						<?php 
						if((empty($folderdate[$cw['folderid']]) || $cw['truedateline']>$folderdate[$cw['folderid']]) && SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
							<h2 style="font-size:14px;font-weight:bold;"><a style="color:#666;text-decoration:none" target="<?=$target?>" href="<?=$url?>"><?=$cw['title']?></a></h2>
						<?php }elseif(SYSTIME<$cw['submitat'] || !empty($cw['endat'])){
								if(!empty($cw['endat']) && SYSTIME >$cw['endat']){
							?>
								<h2 style="font-size:14px;font-weight:bold;"><s><a style="color:#666;text-decoration:none" target="<?=$target?>" href="<?=$url?>"><?=$cw['title']?></a></s></h2>
								<?php }else{?>
								<h2 style="font-size:14px;font-weight:bold;"><a style="color:#666;text-decoration:none" target="<?=$target?>" href="<?=$url?>"><?=$cw['title']?></a></h2>
								<?php }
							}else{?>
							<span style="color:#B5B2B2">
							<?=$cw['title']?>
							</span>(往期课件)
							<?php }?>
							<?php if(SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
								<p class="kergde" <?=$style?>> 所属课程：<a style="color:#3366cc;text-decoration: underline;" href="<?=$roominfo['iscollege']?geturl('myroom/college/study/cwlist/'.$cw['folderid']):geturl('myroom/stusubject/'.$cw['folderid'])?>" ><?=$cw['foldername']?></a>&nbsp;&nbsp;主讲：<?=$cw['realname']?> 
							<?php if(SYSTIME<=$cw['endat']){?>
								<span style="color:red;font-weight:bold">将于：<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
							<?php }?>
							<?php }elseif(empty($cw['endat']) || SYSTIME<=$cw['endat']){?>
								<p class="kergde" <?=$style?>>  所属课程：<a style="color:#3366cc;text-decoration: underline;" href="<?=$roominfo['iscollege']?geturl('myroom/college/study/cwlist/'.$cw['folderid']):geturl('myroom/stusubject/'.$cw['folderid'])?>" ><?=$cw['foldername']?></a>
								<?php if(SYSTIME<=$cw['endat']){?>
								<span style="color:red;font-weight:bold">将于：<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
							<?php }?>&nbsp;&nbsp;主讲：<?=$cw['realname']?>
							<?php }else{?>
								<p class="kergde" <?=$style?>><span style="font-weight:bold"> 已于：<?=Date('Y-m-d H:i',$cw['endat'])?> 结束! </span>&nbsp;&nbsp;主讲：<?=$cw['realname']?>
							<?php }?>
							</p>
							<?php if(!empty($cw['coursewarelogo'])){?>
								<p class="kergde" <?=$style?>><?=$cw['summary']?></p>
							<?php }else{?>
								<p class="kergde" style="margin-left:16px"><?=$cw['summary']?></p>
							<?php }?>
					</div>
					<!-- ==内容结束== -->
				</div>
				</td>
			</tr>
		</tbody>
	<?php }}?>
		</table>
		<?php }}?>
		<table width="100%" class="datatab">
			<thead class="tabhead">
				<tr>
				<?php if($roominfo['iscollege'] != 1){?>
					<th><a href="<?=geturl('myroom/stusubject/allcourse')?>">更多>></a></th>
				<?php }?>
				</tr>
			</thead>
		</table>
	</div>
	
</div>
<script type="text/javascript">
function showcws(tbid){
	if($('#tb'+tbid+' tbody').css('display')=='none')
		$('#tb'+tbid+' tbody').show();
	else
		$('#tb'+tbid+' tbody').hide();
	parent.resetmain();
}
$(function(){
	cds();
	
})
var cdarr;
function cds(){
	<?php
	if(!empty($needCDArr)){?>
	cdarr = eval(<?=json_encode($needCDArr)?>);
	setInterval('counttime()',1000);
	<?php
	}
	?>
	
}

var systime = <?=SYSTIME?>;
function counttime(){
		systime++;
		if(systime%60 == 0){
			$.ajax({
				url:'/time/gettime.html?d='+Math.random(),
				success:function(data){
					systime = data;
				}
			});
		}
		// if(countdown <= 0)
			// location.href = location.href + '?autoplay=1';
		$.each(cdarr,function(key,value){
			// console.log(key,value);
			if(value.truedateline-systime <= 0)
				location.reload(true);
			$('.cw_'+value.cwid).html(secondToStr(value.truedateline-systime));
			
		})
		
		// $('.countdownspan').html(secondToStr(countdown));
	}
	var timearr = new Object();
	timearr[1] = '秒';
	timearr[60] = '分';
	timearr[3600] = '小时';
	
	function secondToStr(time){
		var str = '';
		$.each(timearr,function(key,value){
			key = 3600/key;
			value = timearr[key];
			if (time >= key){
				str += Math.floor(time/key) +value;
			}
			time %= key;
		});
		return str;
	}
</script>
<?php $this->display('myroom/player'); ?>
<?php $this->display('myroom/page_footer'); ?>