<?php $this->display('myroom/page_header'); ?>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<STYLE TYPE="text/css">
.kejian {
	width: 748px;
	border: 1px solid #dcdcdc;
	background-color:##F4F4F4;
}
.kejian li{
	width:170px;
	margin-left:15px;
	_margin-left:7px;
	margin-top:10px;
}
.danke label {
	float:left;
	_margin-top:8px;
	*margin-top:6px;
}
.active{
	color:red;
}
.xiaquan {
	width:748px;
	border-top:solid 1px #cdcdcd;
	height:35px;
	line-height:35px;
}
.duoxuan {
	float:left;
	margin:4px 5px 0;
}
.shouxuan {
	float:left;
	margin:10px 10px 0;
}
</STYLE>


<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/myroom') ?>">我的教室</a> > 选择课程
	</div>
	<div class="lefrig">
		<div class="annotate">请勾选要学习的课程（所选的课程会在<a href="<?= geturl('myroom/subject') ?>" style="font-weight:normal;">所有课程</a>中优先显示，方便下次学习）。</div>
<form id="folderform">
<input type="hidden" name="choose" value="1" />
<?php if(!empty($folders)) { ?>
<div class="kejian">
<ul class="liss" style="clear:both;min-height: 150px;_height:150px;">
<?php foreach($folders as $folder) { ?>
<li class="danke" style="float:left;">
<span class="spne">
<input class="duoxuan" type="checkbox" class="folderid" name="folderid[]" value="<?= $folder['folderid'] ?>" id="folderid<?= $folder['folderid'] ?>"  <?= $folder['fid']>0?'checked="checked"':'' ?>>
<label for="folderid<?= $folder['folderid'] ?>"><?= $folder['foldername'].'('.$folder['coursewarenum'].')'?></label>
</span>
</li>
<?php } ?>
</ul>
	<div class="xiaquan">
	<input class="shouxuan" type="checkbox" id="chooseall"><label style="color:#3366CC;" for="chooseall">全选</label>
	</div>
	<div style="clear:both;"></div>
<?php } else { ?>
暂时没有有课件的课程
<?php } ?>
</form>
</div>
<div style="float: right;margin-top: 10px;">
<input class="huangbtn" type="button" value="完成"/>
<a class="lanbtn marlef" href="javascript:history.go(-1);">返回</a>
</div>
</div>
<script type="text/javascript">
$(function(){
	$("#chooseall").click(function(){
		if($(this).attr('checked') == "checked")
			$(".duoxuan").attr("checked","checked");
		else
			$(".duoxuan").removeAttr("checked");
	});
	$(".huangbtn").click(function(){
		var url = "<?= geturl('myroom/subject/choose') ?>";
		$.ajax({
			url:url,
			type:"post",
			data:$("#folderform").serialize(),
			dataType:"text",
			success:function(data) {
				if(data == "success") {
					$.showmessage({
                        img : 'success',
                        message:'选择课程成功',
                            title:'选择课程',
                            callback :function(){
                                 document.location.href = "<?= geturl('myroom/subject') ?>";
                            }
                        });
				} else {
					$.showmessage({
                            img : 'error',
                            message:'选择课程失败，请稍后再试或联系管理员。',
                            title:'选择课程'
                        });
				}
			}
		});
	});
});
</script>
<?php $this->display('myroom/page_footer'); ?>