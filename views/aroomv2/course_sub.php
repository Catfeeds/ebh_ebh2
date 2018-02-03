<?php $this->display('troom/page_header'); ?>

<style type="text/css">

.gray {filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(100%);}
.kejian {
	width: 786px;
	float:left;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
    display: inline;
    float: left;
    margin-left: 11px;
    margin-top: 8px;
    width: 145px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 140px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}


.noke {
	height: 480px;
	width: 744px;
	float: left;
	border: 1px solid #cdcdcd;
}
.noke p {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
	height: 120px;
	margin-top: 90px;
	margin-left: 170px;
	padding-left: 140px;
	font-size: 16px;
	padding-top: 30px;
    width: 307px;
}
.noke span {
	color: #e94f29;
}


</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(function(){
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});
	});
//-->
</SCRIPT>
<script type="text/javascript">
<!--
function delcourse(courseid,cwnum) {
	if(cwnum>0){
		alert('目录或子目录下已有课件,不能删除');
		return;
	}
	$.confirm("您确定要删除课程吗?",function(){
		$.ajax({
			type:'post',
			url:'<?=geturl('aroomv2/course/del')?>',
			dataType:'json',
			data:{'folderid':courseid},
			success:function(_json){
				if(_json.code == 1){
					alert(_json.message);
					window.location.reload();
				}else{
					alert(_json.message);
				}
			},
			error:function(){
				alert("服务器连接错误，请重试");
			}
		});
	});

}
//-->
</script>
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/course')?>">课程管理</a> >
		<?php if(!empty($uparr)){
				$upfoldercount = count($uparr);
				foreach($uparr as $k=>$upfolder){
				$index = $upfoldercount-$k-1;
			?>
			<a href="<?=geturl('aroomv2/course/sub/'.$uparr[$index]['folderid'])?>"><?=$uparr[$index]['foldername']?></a> > 
			<?php }}?>
			<?= $folder['foldername'] ?>
	
		</div>
	<div class="lefrig"  style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
	<div class="annuato tiezi_search" style="line-height:28px;padding-left:20px;position: relative;">
		<div class="tiezitool">
			<?php $search = $this->input->get('q');?>
			<?php if(empty($sectionlist) && $needsubfolder && empty($search)){?>
			<a class="mulubgbtn hongbtn" style="margin-right:10px;" href="<?=geturl('aroomv2/folder/add/'.$folder['folderid'])?>">添加目录</a>
			<?php }?>
			
		</div>

</div>
<?php if(!empty($subfolderlist)) {?>
<div class="kejian">
	<ul class="liss">
	
        <?php foreach($subfolderlist as $subject) { ?>
	<li class="danke">
	<?php if(empty($subject['hassub']) && $subject['coursewarenum']>0){?>
		<div class="showimg gray" onclick="alert('目录下已有课件,不能操作')" title="目录下已有课件,不能操作"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></div>
		<span class="spne gray" title="目录下已有课件,不能操作"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)<br/><a href="<?=geturl('aroomv2/folder/edit/'.$subject['folderid'])?>">[编辑]</a></span>
	<?php }else{?>
	<div class="showimg"><a href="<?= geturl('aroomv2/course/sub/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('aroomv2/course/sub/'.$subject['folderid']) ?>" style="text-decoration: none;" title="<?= $subject['foldername'] ?>"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)</a><br/><a href="<?=geturl('aroomv2/folder/edit/'.$subject['folderid'])?>">[编辑]</a><a href="javascript:delcourse(<?=$subject['folderid']?>,<?=$subject['coursewarenum']?>);">[删除]</a></span>
	
	<?php }?>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php } else { ?>
	<!--
	<div class="noke"><p>您还没有<span>开设任何课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>
-->
<?php } ?>

</div>
<?php $this->display('troom/page_footer'); ?>