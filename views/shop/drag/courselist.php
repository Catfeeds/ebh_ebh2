<?php $this->display('troom/page_header'); ?>

<style type="text/css">
body{
	background:#fff;
}
.kejian {
	width: 786px;
	background:#fff;
	float:left;
	border: 1px solid #dcdcdc;
	border-top:none;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-left:11px;
	display:inline;
	margin-top: 8px;
	height: 218px;
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

.kejian .liss .danke2 {
	width: 184px;
	float: left;
	margin-left:11px;
	display:inline;
	margin-top: 8px;
	height: 132px;
}
.kejian .liss .danke2 .spne {
	text-align: center;
	width: 178px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke2 .sds {
	height: 184px;
	width: 178px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { float:left;}
.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid;}


.noke {
	height: 480px;
	width: 786px;
	float: left;
	border: 1px solid #cdcdcd;
	background: #fff;
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
.ptab{
	height:33px;
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
function degroup() {
	if (!confirm("确认要删除该课程？")) {
		return false;
	}
	return true;
} 
function check_layer(_this)
{
	if(_this.foldername.value == ''){
		alert("课程名称不能为空");
		return false;
	}
	var reg =/^[1-9]\d*(\.0+)?$|^0(\.0+)?$/;
	if(_this.displayorder.value!=''){
		if(!reg.test(_this.displayorder.value)){
			alert("排序编号必须为数字");
			return false;
		}
	}else{
		alert("排序编号不能为空");
		return false;
	}
	return true;
}
function updategroup(crname,folderid,displayorder,upid)
{
	H.get('updiv').exec('show');
	$('#foldername').val(crname);
	$('#displayorder').val(displayorder);
	$('#upid').val(upid);
	$('#folderid').val(folderid);
	var ieset = navigator.userAgent;
}
function addgroup(foldername,folderid,upid){
	H.get('adddiv').exec('show');
	$('#upid').val(upid);
	if(!folderid){
		$('#upid1').val('');
		$("#folder").show();
		$("#folder1").hide();
	}else{
		$('#fname').html(foldername);
		$('#upid1').val(folderid);
		$('#upid').val('');
		$("#folder1").show();
		$("#folder").hide();
	}
	var ieset = navigator.userAgent;
}
$(function(){
	buttons = new xButton();
	buttons.add({
		value:'取消',
		callback:function(){
			H.get('updiv').exec('close');
			return false;
		},
		autoFocus:true
	});
	buttons.add({
		value:'确定',
		callback:function(){
			if(check_layer(document.getElementById('upform'))) document.getElementById('upform').submit();
			H.get('updiv').exec('close');
			return false;
		}
	});
	H.create(new P({
		id:'updiv',
		content:$("#updiv")[0],
		title:'修改课程',
		width: 360,
		height: 230,
		easy:true,
		button:buttons
	}),'common');




	buttons2 = new xButton();
	buttons2.add({
		value:'取消',
		callback:function(){
			H.get('adddiv').exec('close');
			return false;
		},
		autoFocus:true
	});
	buttons2.add({
		value:'确定',
		callback:function(){
			if(check_layer(document.getElementById('addform'))) document.getElementById('addform').submit();
			H.get('adddiv').exec('close');
			return false;
		}
	});

	H.create(new P({
		id:'adddiv',
		content:$("#adddiv")[0],
		title:'添加课程',
		width: 360,
		height: 230,
		easy:true,
		button:buttons2
	}),'common');

});
//-->
</script>
	<div class="lefrig" style="margin-top:0px;">

<?php if(!empty($folderlist)) { 
	if($roominfo['isschool'] != 7){?>
<div class="kejian">
	<ul class="liss">
	
		<?php foreach($folderlist as $folder) { ?>
	<li class="<?php if($roominfo['template'] == 'plate'){?>danke2<?php } else { ?>danke<?php } ?>">
	<div class="showimg"><a href="<?= geturl('aroomv2/module/freecourse/'.$folder['folderid']) ?>" title="<?= $folder['foldername'] ?>">
			<?php if ($roominfo['template'] == 'plate'){
			$img = show_plate_course_cover($folder['img']);
			$img = !empty($img) ? show_thumb($img, '147_86') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg'; ?>
			<img src="<?=$img ?>" width="147" height="86" border="0" /></a>
			<?php } else { ?>
			<img src="<?= empty($folder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $folder['img'] ?>" width="114" height="159" border="0" /></a>
			<?php } ?>

	</div>
	<span class="spne"><a href="<?= geturl('aroomv2/module/freecourse/'.$folder['folderid']) ?>" style="text-decoration: none;" title="<?= $folder['foldername'] ?>"><?= ssubstrch($folder['foldername'],0,20) ?>(<?= $folder['coursewarenum'] ?>)</a></span>
	</li>
		<?php } ?>

	</ul>
	</div>
	<?php }else{?>
	<div class="work_mes" style="border:1px solid #dcdcdc;border-bottom:none;height:auto">
	<ul>
	<?php $i=0;foreach($folderbypid as $k=>$package){?>
		<li class="<?=$i==0?'workcurrent':''?> ptab" id="tab<?=$k?>"><a href="javascript:void(0)" title="<?=$package[0]['pname']?>" onclick="changetab(<?=$k?>)"><span><?=$package[0]['pname']?></span></a></li>
	<?php $i++;}?>
	</ul>
	</div>
	<?php
		$i=0;
		if(!empty($folderbypid)){
		foreach($folderbypid as $k=>$package){?>
		<div class="kejian" style="<?=$i==0?'':'display:none'?>" id="pack<?=$k?>">
	<ul class="liss">
	
		<?php foreach($package as $folder) { ?>
	<li class="<?php if($roominfo['template'] == 'plate'){?>danke2<?php } else { ?>danke<?php } ?>">
	<div class="showimg"><a href="<?= geturl('aroomv2/module/freecourse/'.$folder['folderid']) ?>" title="<?= $folder['foldername'] ?>">
			<?php if ($roominfo['template'] == 'plate'){
			$img = show_plate_course_cover($folder['img']);
			$img = !empty($img) ? show_thumb($img, '147_86') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg'; ?>
			<img src="<?= $img ?>" width="147" height="86" border="0" /></a>
		<?php } else { ?>
			<img src="<?= empty($folder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $folder['img'] ?>" width="114" height="159" border="0" /></a>
		<?php } ?>
		</div>
	<span class="spne"><a href="<?= geturl('aroomv2/module/freecourse/'.$folder['folderid']) ?>" style="text-decoration: none;" title="<?= $folder['foldername'] ?>"><?= ssubstrch($folder['foldername'],0,20) ?>(<?= $folder['coursewarenum'] ?>)</a></span>
	</li>
		<?php } ?>

	</ul>
	</div>
	<?php $i++;}
		  }
	    }
	} else { ?>
	
	<div class="noke"><p>您还没有<span>开设任何课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>

<?php } ?>

</div>
<script>
function changetab(pid){
	$('.ptab').removeClass('workcurrent');
	$('#tab'+pid).addClass('workcurrent');
	$('.kejian').hide();
	$('#pack'+pid).show();
	// parent.resetmain();
}
</script>
<?php $this->display('troom/page_footer'); ?>