<?php $this->display('troom/page_header'); ?>

<style type="text/css">
.kejian {
	width: 786px;
	background:#fff;
	float:left;
	border: 1px solid #dcdcdc;
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

.showimg {float:left;}
.showimg img { border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid ;}


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


	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/classsubject') ?>" ?>课程管理</a> > 听课反馈
	
		</div>
	<div class="lefrig" style="margin-top:10px;">
	
<?php if(!empty($subjectlist)) { ?>
<div class="kejian">
	<ul class="liss">
	
        <?php foreach($subjectlist as $subject) { ?>
	<li class="danke">
	<div class="showimg"><a href="<?= geturl('troom/feedback/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('troom/feedback/'.$subject['folderid']) ?>" style="text-decoration: none;" title="<?= $subject['foldername'] ?>"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php } else { ?>
	
	<div class="noke"><p>您还没有<span>开设任何课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>

<?php } ?>

</div>
<?php $this->display('troom/page_footer'); ?>