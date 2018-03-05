<?php $this->display('myroom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css" />
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
.workdata{width:auto;}
.danke2s-1s:hover a.remove {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/ebh_cohtks.png) no-repeat;
	width:16px;
	height:16px;
	position:absolute;
	top:6px;
	right:8px;
}
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
	当前位置 > <a href="<?= geturl('myroom/stusubject')?>">学习课程</a> ><?php if($from == 1) { ?><a href="<?= geturl('myroom/stusubject/allcourse')?>">我的课程</a><?php }else{ ?><a href="<?= geturl('myroom/stusubject/allcourse') ?>">全校课程</a><?php }?> > 收藏的课程
</div>
<div class="lefrig" style="<?=(empty($roominfo['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':'border:1px solid #fff;'?>background:#fff;margin-top:15px;">
<div class="work_menu" style="margin-bottom:0px;">
    <ul>
    	<li><a href="<?= geturl('myroom/favorite') ?>"><span style="color:#666666">收藏的课件</span></a></li>
         <li class="workcurrent"><a href="<?= geturl('myroom/favorite/subject')?>"><span style="color:#2696F0">收藏的课程</span></a></li>
         
    </ul>
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
		<a href="<?= geturl('myroom/favorite') ?>">收藏的课件</a>
	</div>
	<div>
		<a href="<?= geturl('myroom/favorite/subject')?>" class="curr allwork">收藏的课程</a>
	</div>
</div>
<?php }?>
<?php if(!($is_zjdlr || $is_newzjdlr) && $roominfo['iscollege'] && $roominfo['template'] == 'plate'){?>
<div class="studycourse studycourse-2">
	<ul>
	<?php if(!empty($myfavorites)) { 
			$url = 'myroom/college/study/cwlist/';
			foreach($myfavorites as $myfavorite) { 
			$img = show_plate_course_cover($myfavorite['img']);
			$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
			?>
		<li class="fl">
			<div class="danke2s-1s">
				<a href="<?= geturl($url.$myfavorite['folderid'])?>" title="<?=$myfavorite['foldername']?>"><img src="<?=$img?>" width="212" border="0" height="125"></a>
				<div class="rateoflearnfas">
					<a href="<?= geturl($url.$myfavorite['folderid'])?>" title="<?=$myfavorite['foldername']?>" class="coursrtitle-1s">
						<p class="rateoflearnings" style="width:0%;">
						<span class="rateoflearnspans"><?= shortstr($myfavorite['foldername'],80)?></span>
						</p>
					</a>
				</div>
				<a href="javascript:;" class="remove" onclick="delfavorite(<?= $myfavorite['fid']?>)"></a>
			</div>
		</li>
            <?php }
    } else{?>
        <?=nocontent('500px')?>
    <?php }?>
	</ul>
</div>
<?php } else {?>
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
					 $url = ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) ? 'myroom/stusubject/':'myroom/subject/';
					 if($roominfo['iscollege'])
						$url = 'myroom/college/study/cwlist/';
					 ?>
						 <?php foreach($myfavorites as $myfavorite) { ?>
						  <tr id="tr<?= $myfavorite['fid'] ?>" onmouseout="this.className='yanse1'" onmouseover="this.className='yanse'"  >
							<td width="78%">
							<a href="<?= geturl($url.$myfavorite['folderid'])?>"><?= shortstr($myfavorite['foldername'],80)?></a>
							</td>
							<td width="22%">
								<a href="<?= geturl($url.$myfavorite['folderid'])?>" class="previewBtn"><span>查看详情</span></a>
								<a href="javascript:;" onclick="delfavorite(<?= $myfavorite['fid']?>)" class="tenshanchu" style="color: #8e8d8d;text-decoration: none;margin:0 5px;" ><span>取  消</span></a>
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
<?php }?>
</div>
<SCRIPT LANGUAGE="JavaScript">
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
							$("#tr"+fid).remove();
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
</SCRIPT>
</body>
</html>