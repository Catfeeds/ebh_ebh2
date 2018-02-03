<?php $this->display('myroom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css" />
<style type="text/css">
.yanse{
	background:#EFFFFF;
}
.yanse1{
	background:#FFFFFF;
}
.work_menu li a {
	padding: 0 12px 0 0;
}
.work_menu li span {
	padding: 0 0 0 12px;
}
.workdata{ width:auto;}
.category_cont1 div {
    height: 40px;
    line-height: 40px;
	display: block;
	float: left;
	padding: 0 10px;
}
.category_cont1 div a {
    padding: 3px 10px;
    font-size: 14px;
    font-family: 微软雅黑;
	color: #666;
}
.category_cont1 div a.curr ,.category_cont1 div a:hover {
    background: none repeat scroll 0 0 #5e96f5;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 2px;
}
.kettshe:hover a.remove {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/ebh_cohtks.png) no-repeat;
	width:16px;
	height:16px;
	position:absolute;
	top:10px;
	right:10px;
}
.label-live {
    float: left;
    padding: 1px 5px;
    height: 18px;
    width: 30px;
    border: 1px solid #dbdbdb;
    margin-right: 10px;
    margin-left: 5px;
    margin-top: 3px;
    background-color: #18a8f7;
    border-radius: 0.25em;
    color: #fff;
    display: inline;
    text-align: center;
    font-style: normal;
}
.setud {
	border:none;
	border-bottom:solid 1px #efefef;
}
</style>
<?php 
if(!empty($roominfo['crid'])){
	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	$appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	$appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	$is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	$is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']); 
}
?>
<?php if($is_zjdlr || $is_newzjdlr){?>
<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/stusubject')?>">学习课程</a> ><?php if($from == 1) { ?><a href="<?= geturl('myroom/stusubject/mycourse') ?>">我的课程</a><?php }else{ ?><a href="<?= geturl('myroom/stusubject/allcourse') ?>">全校课程</a><?php }?> > 收藏的课件
</div>
<div class="lefrig" style="<?=(empty($roominfo['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':'border:1px solid #fff;'?>background:#fff;margin-top:15px;">
<div class="work_menu" style="margin-bottom:0px;">
    <ul>
    	<li class="workcurrent"><a href="<?= geturl('myroom/favorite')?>"><span style="color:#2696F0">收藏的课件</span></a></li>
        <li><a href="<?= geturl('myroom/favorite/subject')?>"><span style="color:#666666">收藏的课程</span></a></li>
         
    </ul>
</div>
<div class="workdata" style="margin-top:0px;">
	<table width="100%" class="datatab" style="border:none;">
					<thead class="tabhead">
					  <tr>
						<th width="78%">名称</th>
						<th width="22%">操作</th>
					  </tr>
					</thead>
					 <tbody>
					 <?php if(!empty($myfavorites)) { 
					 $url = 'myroom/mycourse/';
					 ?>
					 
						 <?php foreach($myfavorites as $myfavorite) { 
							$arr = explode('.',$myfavorite['cwurl']);
							$type = $arr[count($arr)-1]; 
							if($type != 'flv' && $myfavorite['ism3u8'] == 1)
								$type = 'flv';
							if($type == 'mp3')
								$type = 'flv';
						 ?>
						  <tr id="tr<?= $myfavorite['fid'] ?>" onmouseout="this.className='yanse1'" onmouseover="this.className='yanse'" <?= ($myfavorite['status']==1)?'':'style="background:#ccc;"'?>>
							<td width="78%">
							<?php if($myfavorite['status'] == 1) { ?>
							<a target="<?= (empty($myfavorite['cwurl']) || $type == 'flv') ? '_blank' : '_blank' ?>" href="<?= geturl($url.$myfavorite['cwid'])?>"><?= shortstr($myfavorite['title'],80)?></a>
							<?php } else { ?>
							<?= shortstr($myfavorite['title'],80) ?>
							<?php } ?>
							</td>
							<td width="22%">
							<?php if($myfavorite['status'] == 1) { ?>
								<a target="<?= (empty($myfavorite['cwurl']) || $type == 'flv') ? '_blank' : '_blank' ?>" href="<?= geturl($url.$myfavorite['cwid'])?>" class="previewBtn">查看详情</a>
							<?php } else { ?>
								<span style="line-height:27px;float:left;">源课件已删除</span>
							<?php } ?>
								<a href="javascript:;" onclick="delfavorite('<?= $myfavorite['fid'] ?>')" class="tenshanchu" style="color: #8e8d8d;text-decoration: none;margin-left:5px;"><span>取  消</span></a>
							</td>
						  </tr>
						  <?php } ?>
					 <?php } else { ?>
						 <tr>
							<td colspan="3" align="center"><div class="nodata"></div></td>
						</tr>
					<?php } ?>
					</tbody>
	</table>
	
</div>


<?php } else {?>
<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;overflow: initial;">
	<ul>
		 <li class=""><a href="/myroom/college/study.html" style="font-size:16px;"><span><?=empty($all)?$pagemodulename:'全校课程'?></span></a></li>
		 <li class="workcurrent"><a href="/myroom/favorite.html" style="font-size:16px;"><span>收藏夹</span></a></li>
	</ul>
</div>
<div class="category_cont1">
	<div>
		<a href="<?= geturl('myroom/favorite') ?>" class="curr allwork">收藏的课件</a>
	</div>
	<div>
		<a href="<?= geturl('myroom/favorite/subject')?>">收藏的课程</a>
	</div>
</div>

<div class="workdata" style="margin-top:0px;">
	<?php if(!empty($myfavorites)) {
			$redis = Ebh::app()->getCache('cache_redis');
			$url = 'myroom/mycourse/';
			$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov','swf');
// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
		$emptylogo = true;
			?>
	<ul>
		<?php foreach($myfavorites as $cw) {
				$arr = explode('.',$cw['cwurl']);
				$type = $arr[count($arr)-1];
				$isVideotype = in_array($type,$mediatype) || $cw['islive'];
				// $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
				$target = '_blank';
				$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($cw['islive']?'livelogo.jpg':'defaultcwimggray.png?v=20160504001');
				if($isVideotype){
					$playimg = 'kustgd2';
				}elseif(strstr($type,'ppt')){
					$playimg = 'ppt';
				}elseif(strstr($type,'doc')){
					$playimg = 'doc';
				}elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
					$playimg = 'rar';
				}elseif($type == 'mp3'){
					$playimg = 'mp3';
				}elseif($cw['islive'] == 1){
					$playimg = 'kustgd2';
				}else{
					$playimg = 'attach';
				}

				if(!empty($cw['logo']) && $isVideotype) {
					$logo = $cw['logo'];
					$emptylogo = false;
				}
				else{
					$logo = $deflogo;
				}
				$teacher = $teacherarr[$cw['uid']];
				$base_avatar = 'http://static.ebanhui.com/ebh/tpl/default/images/';
				
				$defaulturl = ($teacher['sex'] == 1)?$base_avatar."t_woman.jpg" : $base_avatar."t_man.jpg";
				$face = empty($teacher['face']) ? $defaulturl : $teacher['face'];
				$face = getthumb($face,'50_50');
			?>
		<li class="setud kettshe" style="width:970px;">
			<div class="skthgd">
				<img style="border-radius:25px;float:none" src="<?=$face?>">	<p><?=empty($teacher['realname'])?$teacher['username']:$teacher['realname']?></p>
			</div>
			<div class="ettyusr">
				<?php if($cw['status'] == 1) { ?>
				<a class="fusrets" style="color:#666" target="_blank" href="/myroom/mycourse/<?=$cw['cwid']?>.html" title="<?=$cw['title']?>">
					<?php if($iszjdlr && !empty($cw['cwtoid']) && $cw['cwtoid'] == 1){
							if(!empty($cw['logo'])){?>
							<img src="<?= $cw['logo'];?>" />
						<?php }else{?>
							<img src="http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png?v=20160504001" />
						<?php }
						}else{?>
					<img src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>"/>
					<?php }?>
				</a>
				<?php }?>
				<img src="<?=$logo?>" />
			</div>
			<div class="sktgte">
				<?php if(!empty($cw['islive'])){?>
				<i class="label-live" title="直播课件" style="<?= ($cw['truedateline']+$cw['cwlength']<=SYSTIME)?'background:#999999 !important':''?>">直播</i>
				<?php }?>
				<h2 class="" style="position:relative">
					<?php if($cw['status'] == 1) { ?>
					<a style="color:#999" target="_blank" href="/myroom/mycourse/<?=$cw['cwid']?>.html" title="<?=$cw['title']?>"><?= shortstr($cw['title'],80) ?></a>
					<?php }?>
				</h2>
				<span class="ksytde">
					<?php if(SYSTIME>=$cw['submitat'] && (empty($cw['endat']) || SYSTIME<=$cw['endat'])){?>
						<?=$iszjdlr && in_array($folderid, array($appsetting['transaction'], $appsetting['regulations'])) ? $this->format_date($cw['cwdateline']) : timetostr($cw['cwdateline']).' 发布' ?>
						<?php if(SYSTIME<=$cw['endat']){?>
							<span class="disbl">将于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
						<?php }?>
					<?php }elseif(empty($cw['endat']) || SYSTIME<=$cw['endat']){?>
						<span class="redbl">于&nbsp;<?=Date('Y-m-d H:i',$cw['submitat'])?> 开课,敬请期待!
						<?php if(SYSTIME<=$cw['endat']){?>
							<span class="redbl">将于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束 </span>
						<?php }?>
						</span>
					<?php }else{?>
						<span class="<?=$enabled?'disbl':''?>" style="color:#999">已于&nbsp;<?=Date('Y-m-d H:i',$cw['endat'])?> 结束! </span>
					<?php }?>
				</span>
				<?php $viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);?>
				<span class="ksytde">人气：<?=empty($viewnum)?$cw['viewnum']:$viewnum?></span>
				评论：<?=$cw['reviewnum']?>	<p><?=$cw['summary']?></p>
			</div>
			<a href="javascript:;" class="remove" onclick="delfavorite(<?= $cw['fid']?>)"></a>
		</li>
		<?php }?>
		
	</ul>
	<?php } else { ?>
			<div class="nodata"></div>
		<?php } ?>

<?php }?>
	<?= $pagestr ?>
</div>
</div>
<script type="text/javascript">
<!--
function delfavorite(fid){
	top.dialog({
		title: '删除确认',
		content: '您确定要取消么？',
		width:370,
		okValue: '确定',
		ok: function () {
		var url="<?= geturl('myroom/favorite/del') ?>";
		$.ajax({
			type	:'POST',
			url		:url,
			data:{'fid':fid},
			dataType:'text',
			success	:function(data){
				if(data=='success'){
					top.dialog({
					title: '提示信息',
					content: '取消成功！',
					width:370,
					cancel: false,
					okValue: '确定',
					ok: function () {
						location.reload();
					}
				}).showModal();			
				}
			}
		});
	},
	cancelValue: '取消',
    cancel: function () {}
    }).showModal();
}
//-->
</script>
<?php $this->display('myroom/page_footer'); ?>