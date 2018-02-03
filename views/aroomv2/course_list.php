<?php if(!empty($loading)) {
	if(empty($courselist)){
		return '';
	}
	if ($room['template'] == 'plate') {
		foreach($courselist as $course) {
			$viewnumlib = Ebh::app()->lib('Viewnum');
			$viewnum = $viewnumlib->getViewnum('folder', $course['folderid']);
			$viewnum = empty($viewnum) ? $course['viewnum'] : $viewnum;
			if (!empty($course['teachers'])) {
				$count = substr_count($course['teachers'], ',');
			} else {
				$count = 0;
			} ?>
			<tr>
				<td class="subject" style="position:relative; padding:20px 6px 10px 20px!important; ">
					<div class="fl"><?php $img = show_plate_course_cover($course['img']); ?><img style="width:147px;height:86px; padding-right:10px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg':show_thumb($img, '147_86')?>" /></div>
					<p class="fl width550 fonts1"><?=$course['foldername']?></p>
					<p class="fl width550 fonts2" title="<?=!empty($course['teachers'])?$course['teachers']:''?>"><?=!empty($course['teachers'])?shortstr($course['teachers'],140):''?></p>
					<p class="fl width550"><span class="address-2" title="课件：<?=$course['coursewarenum']?>个"><?=$course['coursewarenum']?></span><span class="nianji-2" title="人气：<?=$viewnum?>人"><?=$viewnum?></span></p>
					<div class="width100 fl">
						<a href="<?=geturl('aroomv2/course/edit/'.$course['folderid'])?>" class="moreoperatea-1">编辑</a>
						<a href="javascript:chooseteacher(<?=$course['folderid']?>)" class="moreoperatea-1">选择教师</a>
						<input type="hidden" id="teacherids_<?=$course['folderid']?>" value="<?=!empty($course['teachers'])?$course['teacherids']:''?>" />
						<a href="<?=geturl('aroomv2/course/introduce/'.$course['folderid'])?>" class="moreoperatea-1">课程介绍</a>
						<a href="javascript:setsection(<?=$course['folderid']?>)" class="moreoperatea-1">设置章节</a>
						<a href="javascript:;" class="moreoperatea-1" onclick="selectchapter(<?=$course['folderid']?>,<?=$course['chapterid']?>,<?=$course['versionid']?>,'<?=!empty($course['chapterpath']) ? $course['chapterpath'] : ""?>')" <?php if(!empty($course['chapterid'])) echo 'title="已关联&nbsp;&nbsp;'.$course['chapterfullname'].'"';?>>关联知识点 <?php if(!empty($course['chapterid'])) {?><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/tick.png" title="已关联&nbsp;&nbsp;<?=$course['chapterfullname']?>" /></a><?php }?>
						<a href="<?=geturl('aroomv2/course/cwlist/'.$course['folderid'])?>" class="moreoperatea-1" >查看</a>
			<?php if (empty($course['ordered'])) { ?><a href="javascript:delcourse(<?=$course['folderid']?>,<?=$course['coursewarenum']?>);" class="moreoperatea-1">删除</a><?php } ?>
					</div>
					<div class="move-1 width20" style="display:none;">
						<a class="imges moveup" href="javascript:void(0)" title="上移" onclick="movefolder(<?=$course['folderid']?>,1)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png" /></a>
						<a class="imgas movedown" href="javascript:void(0)" title="下移" onclick="movefolder(<?=$course['folderid']?>,0)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png" /></a>
					</div>
					<!---->
				</td>
			</tr>
		<?php }
		return;
	}
	foreach($courselist as $course) {
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnum = $viewnumlib->getViewnum('folder', $course['folderid']);
		$viewnum = empty($viewnum) ? $course['viewnum'] : $viewnum;
		if (!empty($course['teachers'])) {
			$count = substr_count($course['teachers'], ',');
		} else {
			$count = 0;
		} ?>
	<tr>
		<td class="subject">
			<div class="fl"><img style="width:63px;height:86px; padding-right:5px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" /></div>
			<p class="fl titlecourse"><?=$course['foldername']?></p>
			<p class="datadd fl"><span class="datapeople-1"><?= ($count==0&&empty($course['teachers']))?$count:$count+1?></span><span class="address-1"><?=$course['coursewarenum']?></span><span class="nianji-1"><?=$viewnum?></span></p>
		</td>
		<td><p style="width:200px;word-wrap: break-word;float:left;"><?=!empty($course['teachers'])?$course['teachers']:''?></p></td>
		<td style="position: relative;" class="oper">
			<!---->
			<div class="managementfa">
				<div href="javascript:void(0)" class="management-1">管理
					<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jt-1.png" width="11" height="5" />
					<div class="moreoperate-1" style="display: none;">
						<a href="<?=geturl('aroomv2/course/introduce/'.$course['folderid'])?>" class="moreoperatea">课程介绍</a>
						<a href="javascript:setsection(<?=$course['folderid']?>)" class="moreoperatea">设置章节</a>
						<a href="javascript:chooseteacher(<?=$course['folderid']?>)" class="moreoperatea">选择教师</a>
						<input type="hidden" id="teacherids_<?=$course['folderid']?>" value="<?=!empty($course['teachers'])?$course['teacherids']:''?>" />
						<a href="<?=geturl('aroomv2/course/edit/'.$course['folderid'])?>" class="moreoperatea">编辑</a>
		<?php if (empty($course['ordered'])) { ?><a href="javascript:delcourse(<?=$course['folderid']?>,<?=$course['coursewarenum']?>);" class="moreoperatea">删除</a><?php } ?>
						<a href="javascript:;" class="moreoperatea" onclick="selectchapter(<?=$course['folderid']?>,<?=$course['chapterid']?>,<?=$course['versionid']?>,'<?=!empty($course['chapterpath']) ? $course['chapterpath'] : ""?>')" <?php if(!empty($course['chapterid'])) echo 'title="已关联&nbsp;&nbsp;'.$course['chapterfullname'].'"';?>>关联知识点 <?php if(!empty($course['chapterid'])) {?><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/tick.png" title="已关联&nbsp;&nbsp;<?=$course['chapterfullname']?>" /></a><?php }?>
						<a href="<?=geturl('aroomv2/course/cwlist/'.$course['folderid'])?>" class="moreoperatea" >查看</a>
					</div>
				</div>
				<div class="move-1" style="display:none;">
					<a class="imges moveup" href="javascript:void(0)" title="上移" onclick="movefolder(<?=$course['folderid']?>,1)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png" /></a>
					<a class="imgas movedown" href="javascript:void(0)" title="下移" onclick="movefolder(<?=$course['folderid']?>,0)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png" /></a>
				</div>
			</div>
			<!---->
		</td>
	</tr>
	<?php }
	return;
} ?>
<?php $this->display('aroomv2/page_header');?>

<style>
.terlie li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B2D9F0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
    width: auto;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}

.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}

.terwai {
    background-color: #FFF;
    border: 1px solid #DEDEDE;
    float: right;
    font-size: 14px;
    margin-right: 0px;
    margin-top: 10px;
    min-height: 153px;
    padding: 0 10px 10px;
    width: 590px;
}
.terwai .ternei {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/aroom/xiangtop0222.jpg") no-repeat scroll center top transparent;
    margin-top: -9px;
    min-height: 13px;
    width: 590px;
	position:static;
}
.terlie {
    border-bottom: 1px dashed #CDCDCD;
    float: left;
    margin-bottom: 15px;
    padding-bottom: 15px;
    padding-top: 10px;
    width: 590px;
}
.xianquan {
    float: left;
    width: 590px;
    max-height:290px;
    _height:290px;
    overflow-y:auto;
}


.xianquan li {
    float: left;
    height: 30px;
    line-height: 30px;
    width: 188px;
	overflow: hidden;
}
/*设置章节*/
#categoryBody {
    background: none repeat scroll 0 0 #FFFFFF;
    color: #444444;
    margin: 0;
    padding: 11px 17px 0;
    width: 460px;
}
#categoryHead {
    background: none repeat scroll 0 0 #FFFFFF;
    margin: 5px auto;
    padding: 5px 0 0;
}
.categoryName {
	border: 1px solid #C2C3BD;
	font-size: 12px;
	margin-right: 7px;
	width: 155px;
	height:21px;
	line-height:21px;
	padding-left:4px;
}
.CJsub cite {
	background-image:url(http://static.ebanhui.com/ebh/tpl/default/images/sn_btnb.gif);
	color: #333399;
	background-repeat: no-repeat;
	font-size: 12px !important;
	height: 23px;
	line-height: 23px;
	min-width: 48px;
	overflow-x: visible;
	text-align: center;
	white-space: nowrap;
	width: 71px;
	display: block;
	cursor:pointer;
	text-decoration: none;
	font-style: normal;
    font-weight: normal;
}
.CJsub:hover{
	text-decoration:none;
}
#errTips {
    color: #CC0000;
    font-weight: bold;
    margin-bottom: 10px;
    padding-left: 6px;
}
#categoryList {
    margin: 10px 0 0;
}
#categoryList li {
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_2.gif) repeat-x scroll left top transparent;
    clear: both;
    display: block;
    float: left;
    font-family: simsun;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    width: 100%;
}
#categoryList li.cline {
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_1.gif) repeat-x scroll left top transparent;
	    clear: both;
    display: block;
    float: left;
    font-family: simsun;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    width: 100%;
}
#categoryList li span.htit {
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_3.gif) no-repeat scroll 11px 13px transparent;
    height: 28px;
    overflow: hidden;
    padding-left: 20px;
    width: 270px;
}
#categoryList li span {
    float: left;
}
#categoryList li span.control {
    float: right;
}
#categoryList li span.control .manage {
    float: left;
    width: 170px;
}
.control .manage .CP_a_fuc {
	color: #333399;
	text-decoration: none;
}

a.CP_a_fuc cite {
	cursor: pointer !important;
	font-family: Verdana;
	text-decoration:none;
	color: #333399;
	font-style: normal;
    font-weight: normal;
}
a.CP_a_fuc:hover cite {
	text-decoration:underline;
	color:#FF0000;
}
#categoryBody #categoryList .clearfix .control .manage .CP_a_fuc:hover {
	color: #FF0000;
	text-decoration: none;
}
.CP_w a:link, .CP_w a:visited {
    color: #2E3092;
}
#categoryBottom {
	height: 60px;
	padding-top: 20px;
	text-align: center;
	background-image: url(http://static.ebanhui.com/ebh/tpl/default/images/layertype_2.gif);
	background-repeat: repeat-x;
}
.bcun {
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/sn_btnb.gif) no-repeat;
	height: 23px;
	width: 71px;
	color: #333399;
	border:none;
	cursor:pointer;
}
#categoryBody{
	text-align:left;
}
#categoryBody #categoryList .clearfix .vbuo input {
	margin-top: 4px;
}
	td.oper a{display:inline-block;}
</style>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.exedit-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/simpletree.js"></script>
<style type="text/css">
/*ztree*/
.ztree .button {float: none;}
.ztree li span.button.add {
  margin-left: 10px;
  background-position: -144px 0;
  vertical-align: top;
}
.ztree li span.button.edit {
	margin-left: 10px;
}
.ztree li span.button.remove {
	margin-left: 10px;
}
.ztree *{
	font-size:14px;
}
.ztree li{
	padding: 2px;
}
.ztree li a{
	padding:5px;
	height: 16px;
	text-decoration: none;
	cursor: pointer;
}
.ztree li a.curSelectedNode,.ztree li a:hover{
	padding:5px;
	background-color: #FFE6B0;
	color: black;
	 height: 16px; 
	border: 0;
	opacity: 0.8;
	text-decoration: none;
	cursor: pointer;
}
.ztree li a input.rename{
	height:20px;
	font-size: 18px;
	padding: 2px;
	width: 500px;
	margin-left: 5px;
	margin-top: -4px;
	margin-right: -8px;
	border: 0;
}
.ztree li span.button.chk {
    cursor: auto;
    height: 13px;
    margin: 6px 3px 0 0;
    width: 13px;
}
/*----下拉----*/
.kstdg {
    background: #fff url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/huatlea.jpg") no-repeat scroll right center;
    border: 1px solid #c3c3c3;
    color: #5e5e5e;
    cursor: pointer;
    display: inline;
    float: left;
    height: 24px;
    line-height: 24px;
    min-width: 120px;
    padding: 0 25px 0 10px;
    position: relative;
    z-index: 999;
}
.kdhtyg .distd {
    background: #f0f0f0 url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/huatlea1.jpg") no-repeat scroll right center;
    border: 1px solid #d9d9d9;
}
.liawtlet {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #d9d9d9;
    display: none;
    left: -1px;
    margin-bottom: 10px;
    position: absolute;
    top: 24px;
    width: 100%;
    z-index: 1;
}
.liawtlet a,.noversiontip {
    color: #5e5e5e;
    display: block;
    float: left;
    overflow: hidden;
    padding: 3px 0;
    text-decoration: none;
    text-indent: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
.liawtlet a:hover {
    background: #376ede none repeat scroll 0 0;
    color: #fff;
}
/***********************/
.pack-sort{position:relative;float:left;height:32px;line-height:32px;width:360px;margin-top:13px;text-align:left;  }
.pack-sort-cur{border:solid 1px #ddd;overflow:hidden;text-overflow: ellipsis;white-space: nowrap;cursor:pointer;height:32px;line-height:32px;width:330px;padding:0 20px 0 10px;background:#fff url("http://static.ebanhui.com/ebh/images/ico.png") 344px center no-repeat;}
.pack-sort-list{padding-left:20px;box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.2);border-left:solid 1px #ddd;display:none;overflow:auto;width:100%;max-height:400px;position:absolute;top:34px;left:1px;background-color:#fff;z-index:100;_height:400px;}
.pack-sort-list .spblock{margin-top:10px;zoom:1;white-space:nowrap;clear:both; }
.pack-sort-list .spblock:after{content:'\20';clear:both;display:block;height:0;visibility:hidden;line-height:0}
.pack-sort-list .itemlabel{width:inherit;padding:0 10px 0 5px;cursor:pointer;}

.loading-animation{text-align:center;padding:10px 0;visibility:hidden;}

.closed{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/classify02.png) no-repeat scroll 0 0!important;}

.nochild{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/classify04.png) no-repeat scroll 0 0!important;}
.subclosed{display:none}
.subblock{
	float: left;
	margin: 7px 0 0 22px;

}
.sortblock{
	color: #999;
	display: inline;
	float: left;
	height: 26px;
	line-height: 26px;
	position: relative;
	font-size: 12px;
    clear:both;
}

.showtoggle {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/classify03.png) no-repeat scroll 0 0;
	cursor: pointer;
	float: left;
	height: 13px;
	margin: 9px 5px 0 0;
	width: 13px;
    white-space:nowrap;
}


.itemlabel{
	float: left;
	height: 26px;
	line-height: 26px;
	padding-left: 5px;
	position: relative;
	border: none;
	color: #999;
    white-space:nowrap; }
.labelsp {
	display: inline;
	font-size: 14px;
	height: 28px;
	line-height: 28px;
	padding-left: 5px;
	position: relative;
	margin-top:2px;
    white-space:nowrap;
}
.labelpane{
	float: left;
}
.labelsort{display:inline;}
.subblock{display:inline;clear:both;}
.editpane{display:none}
.alwaysshow .editpane{display:inline-block}
.alwaysshow{background:#ebeff5}
.tempshow .editpane{display:inline-block}
.tempshow{background:#ebeff5}

.editing .itemlabel{display:none}
.editing .editpane{display:none}
.editing .inputpane{display:block}

.editpane a{display: block;height: 15px;
	width: 15px;float:left}
.editpane{
	float:left
}
.addbtn{background:url(http://static.ebanhui.com/ebh/tpl/2016/images/classify05.png) no-repeat scroll 0 0;}
.editbtn{background:url(http://static.ebanhui.com/ebh/tpl/2016/images/classify06.png) no-repeat scroll 0 0;}
.delbtn{background:url(http://static.ebanhui.com/ebh/tpl/2016/images/classify07.png) no-repeat scroll 0 0;}
.splist{
	float: left;
	height: 800px;
	overflow: auto;
	width: 788px;
}
.sortmainc{
	background: #fff none repeat scroll 0 0;
	float: left;
	font-family: 微软雅黑;
	padding-bottom: 20px;
	width: 788px;
}
.xiasxur {
	background:url("http://static.ebanhui.com/ebh/tpl/2016/images/xutan.png") no-repeat scroll center bottom;
	height: 26px;
	left: -15px;
	position: absolute;
	top: -10px;
	width: 13px;
}
</style>
<div  style="width:778px;">
    <div class="ter_tit">
        当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; 课程列表
    </div>
    <div class="kechengguanli">
		<?php if ($room['isschool'] == 7) { ?>
			<div class="pack-sort">
				<div class="pack-sort-cur" id="pack-sort-cur"><?php if (!empty($pay_package)) { echo $pay_package['pname']; } if (!empty($pay_sort)){ echo '&nbsp;&gt;&nbsp;' . $pay_sort['sname']; } if (empty($pay_package) && empty($pay_sort)){ echo '查看全部课程'; }?></div>
				<div class="pack-sort-list" id="pack-sort-list"></div>
			</div>
		<?php } ?>
		<div class="diles diles-1" ><form method="get" id="search">
			<input type="text" name="q" id="searchkey" value="<?=empty($q)?'请输入课程名称':$q?>" class="newsous" name="title" style="color:#999; background:#fff;" onfocus="if($(this).val()=='请输入课程名称')$(this).val('');$(this).css('color','#333')" onblur="if($.trim($(this).val())==''){$(this).val('请输入课程名称');$(this).css('color','#999')}"/><?php if (!empty($pay_package)){ ?><input type="hidden" value="<?=$pay_package['pid']?>" name="pid" /><?php }?><?php if (!empty($pay_sort)) { ?><input type="hidden" value="<?=$pay_sort['sid']?>" name="sid" /><?php } ?>
			<button type="submit" class="soulico"></button></form>
		</div>
    	<div class="kechengguanli_top fr">
        	<ul>
            	<li class="fl "><a href="<?=geturl('aroomv2/course/add')?>" class="cjmt13">开设课程</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom" style="padding-bottom:50px;">
        	<table cellpadding="0" cellspacing="0" class="tables" id="dtable">
				<?php if ($room['template'] == 'plate') { ?>
					<tr class="first">
						<td colspan="3" style="height:0;padding:0 !important;"></td>
					</tr>
				<?php } else { ?>
					<tr class="first">
						<td width="353">课程</td>
						<td width="283">授课教师</td>
						<td width="116">操作</td>
					</tr>
				<?php } ?>
				<?php 
				if(!empty($courselist)){
					foreach($courselist as $course){
						$viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('folder',$course['folderid']);
						$viewnum = empty($viewnum)?$course['viewnum']:$viewnum;
						if(!empty($course['teachers'])){
							$count = substr_count($course['teachers'],',');
						}else{
							$count = 0;
						}
					?>
						<?php if ($room['template'] == 'plate') { ?>
							<tr>
								<td class="subject" style="position:relative; padding:20px 6px 10px 20px!important; ">
									<div class="fl"><?php $img = show_plate_course_cover($course['img']); ?><img style="width:147px;height:86px; padding-right:10px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg':show_thumb($img, '147_86')?>" /></div>
									<p class="fl width550 fonts1"><?=$course['foldername']?></p>
									<p class="fl width550 fonts2" title="<?=!empty($course['teachers'])?$course['teachers']:''?>"><?=!empty($course['teachers'])?shortstr($course['teachers'],140):''?></p>
									<p class="fl width550"><span class="address-2" title="课件：<?=$course['coursewarenum']?>个"><?=$course['coursewarenum']?></span><span class="nianji-2" title="人气：<?=$viewnum?>人"><?=$viewnum?></span></p>
									<div class="width100 fl">
										<a href="<?=geturl('aroomv2/course/edit/'.$course['folderid'])?>" class="moreoperatea-1">编辑</a>
										<a href="javascript:chooseteacher(<?=$course['folderid']?>)" class="moreoperatea-1">选择教师</a>
										<input type="hidden" id="teacherids_<?=$course['folderid']?>" value="<?=!empty($course['teachers'])?$course['teacherids']:''?>" />
										<a href="<?=geturl('aroomv2/course/introduce/'.$course['folderid'])?>" class="moreoperatea-1">课程介绍</a>
										<a href="javascript:setsection(<?=$course['folderid']?>)" class="moreoperatea-1">设置章节</a>
										<a href="javascript:;" class="moreoperatea-1" onclick="selectchapter(<?=$course['folderid']?>,<?=$course['chapterid']?>,<?=$course['versionid']?>,'<?=!empty($course['chapterpath']) ? $course['chapterpath'] : ""?>')" <?php if(!empty($course['chapterid'])) echo 'title="已关联&nbsp;&nbsp;'.$course['chapterfullname'].'"';?>>关联知识点 <?php if(!empty($course['chapterid'])) {?><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/tick.png" title="已关联&nbsp;&nbsp;<?=$course['chapterfullname']?>" /></a><?php }?>
										<a href="<?=geturl('aroomv2/course/cwlist/'.$course['folderid'])?>" class="moreoperatea-1" >查看</a>
										<a href="javascript:delcourse(<?=$course['folderid']?>,<?=$course['coursewarenum']?>);" class="moreoperatea-1">删除</a>
									</div>
									<div class="move-1 width20" style="display:none;">
										<a class="imges moveup" href="javascript:void(0)" title="上移" onclick="movefolder(<?=$course['folderid']?>,1)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png" /></a>
										<a class="imgas movedown" href="javascript:void(0)" title="下移" onclick="movefolder(<?=$course['folderid']?>,0)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png" /></a>
									</div>
									<!---->
								</td>
							</tr>
						<?php } else { ?>
							<tr>
								<td class="subject">
									<div class="fl"><img style="width:63px;height:86px; padding-right:5px;" src="<?=empty($course['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$course['img']?>" /></div>
									<p class="fl titlecourse"><?=$course['foldername']?></p>
									<p class="datadd fl"><span class="datapeople-1"><?= ($count==0&&empty($course['teachers']))?$count:$count+1?></span><span class="address-1"><?=$course['coursewarenum']?></span><span class="nianji-1"><?=$viewnum?></span></p>
								</td>
								<td><p style="width:200px;word-wrap: break-word;float:left;"><?=!empty($course['teachers'])?$course['teachers']:''?></p></td>
								<td style="position: relative;" class="oper">
									<!---->
									<div class="managementfa">
										<div href="javascript:void(0)" class="management-1">管理
											<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jt-1.png" width="11" height="5" />
											<div class="moreoperate-1" style="display: none;">
												<a href="<?=geturl('aroomv2/course/introduce/'.$course['folderid'])?>" class="moreoperatea">课程介绍</a>
												<a href="javascript:setsection(<?=$course['folderid']?>)" class="moreoperatea">设置章节</a>
												<a href="javascript:chooseteacher(<?=$course['folderid']?>)" class="moreoperatea">选择教师</a>
												<input type="hidden" id="teacherids_<?=$course['folderid']?>" value="<?=!empty($course['teachers'])?$course['teacherids']:''?>" />
												<a href="<?=geturl('aroomv2/course/edit/'.$course['folderid'])?>" class="moreoperatea">编辑</a>
												<a href="javascript:delcourse(<?=$course['folderid']?>,<?=$course['coursewarenum']?>);" class="moreoperatea">删除</a>
												<a href="javascript:;" class="moreoperatea" onclick="selectchapter(<?=$course['folderid']?>,<?=$course['chapterid']?>,<?=$course['versionid']?>,'<?=!empty($course['chapterpath']) ? $course['chapterpath'] : ""?>')" <?php if(!empty($course['chapterid'])) echo 'title="已关联&nbsp;&nbsp;'.$course['chapterfullname'].'"';?>>关联知识点 <?php if(!empty($course['chapterid'])) {?><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/tick.png" title="已关联&nbsp;&nbsp;<?=$course['chapterfullname']?>" /></a><?php }?>
												<a href="<?=geturl('aroomv2/course/cwlist/'.$course['folderid'])?>" class="moreoperatea" >查看</a>
											</div>
										</div>
										<div class="move-1" style="display:none;">
											<a class="imges moveup" href="javascript:void(0)" title="上移" onclick="movefolder(<?=$course['folderid']?>,1)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png" /></a>
											<a class="imgas movedown" href="javascript:void(0)" title="下移" onclick="movefolder(<?=$course['folderid']?>,0)"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png" /></a>
										</div>
									</div>
									<!---->
								</td>
							</tr>
						<?php }
						  }
				}else{?>
				<tr><td colspan="3" style="text-align:center"><?=empty($q)?'暂无数据':'没有关于 "'.$q.'" 的搜索结果'?></td></tr>
				<?php }?>
            </table>
			<div id="loading-animation" class="loading-animation"><img src="http://static.ebanhui.com/ebh/images/live_loading.gif" /></div>
        </div>
    </div>
	
	<?=!empty($pagestr) ? $pagestr : ''?>
    
</div>
<!--课件上移下移star-->
<!--课件上移下移end-->
<!--设置章节-->
<div id='sectiondiv' style="display: none;"></div>
<!--删除课程-->
<div id="dialogdel" style="display:none">
<div class="deletecourse" style="height:70px;">
    <div class="tishi mt40"><p style="padding-left: 90px; font-size: 16px; line-height: 35px;">确定要删除该课程吗?</p></div>
    
</div>
</div>
<!--选择教师-->
<div id="dialogct" style="display:none">
<div class="chooseteacher" style="display:none">
	<div class="terwai">
	<div class="ternei">
	</div>
	<span id="choosettitle" style="color:#0068b7;"></span>
	<div id="" class="terlie">
			<div id="noteacher">还未设置任何任课教师</div>
			<ul id="choosetsimp" style="display:none">
			</ul>  
		</div>
		<div style="" class="xiansuoyout">
		<span style="float:left;margin-right:60px;line-height:22px;display: inherit;height:22px;"> 教师列表</span>
		<div style="height:26px;float:left;">
		<input type="text" onclick="this.value=''" id="teachername" class="soutxt" value="请输入老师姓名或账号" name="search" style="width:180px;">
		<input type="button" onclick="allteacher($('#teachername').val())" class="souhuang" value="搜 索" name="searchbutton">
		</div>
		</div>
		<div class="xianquan">
		<ul style="" id="choosetall">
		<?php foreach($roomteacherlist as $teacher){?>
		<li id="all<?=$teacher['uid']?>"><input type="checkbox" id="allteacheri<?=$teacher['uid']?>" onclick="choose('<?=$teacher['uid']?>','<?=$teacher['realname']?>(<?=$teacher['username']?>)',this)" value="<?=$teacher['uid']?>" style="top:2px;" ><label title="<?=$teacher['realname']?>(<?=$teacher['username']?>)" id="teachername_<?=$teacher['uid']?>" for="allteacheri<?=$teacher['uid']?>" style="margin-left:4px;_margin-left:2px;"><?=$teacher['realname']?>(<?=$teacher['username']?>)</label></li>
		<?php }?>
		</ul>
		</div>
	</div>
</div>
</div>
<!--关联知识点start-->
<div id="dialogchapter" style="display:none;height:380px;overflow-y:auto;">
	<input type="hidden" id="sc_folderid" value="0" />
	<div style="height: 28px;padding: 15px 0 0 10px;">
		<div class="kdhtyg">
			<div class="kstdg" id="versionselect">
				<span vid="0" class="xtitle" id="versionselecttitle">请选择版本</span>
				<div class="liawtlet">
				<?php if(empty($versionlist)) {?>
					<div class="noversiontip">暂无版本。</div>
				<?php }else {foreach ($versionlist as $version) {?>
					<a href="javascript:void(0)" vid="<?=$version['chapterid']?>"><?=$version['chaptername']?></a>
				<?php } }?>
				</div>
			</div>
		</div>
    </div>
	<div id='chapterdiv'>
		<div style="height:330px;">
			<div>
				<div id="categoryListx" style="height:330px;">
						<div class="zTreeDemoBackground left">
							<ul id="treeDemo" class="ztree"></ul>
						</div>
					<div class="SG_j_linedot"></div>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/mychapterselect.js?version=20151127001"></script>
<script type="text/javascript">
	var sorteable = true;
<?php if ($room['isschool'] == 7) { ?>
	var pid = <?=!empty($pay_package) ? "{$pay_package['pid']}" : "0" ?>;
	var sid = <?=isset($pay_sort) ? "{$pay_sort['sid']}" : "-1" ?>;
	//是否启用排序
	sorteable = sid > -1;
<?php } ?>
/*展开操作选项*/
$(function () {
	$(".management-1").mouseenter(function(){
		$(this).find(".moreoperate-1").css("display","block");
	});
	$(".management-1").mouseleave(function(){
		$(this).find(".moreoperate-1").css("display","none");
	});
});
$(function () {
	$(".tables tr").mouseenter(function(){
		if (!sorteable) {
			return;
		}
		$(this).find(".move-1").css("display","block");
	});
	$(".tables tr").mouseleave(function(){
		if (!sorteable) {
			return;
		}
		$(this).find(".move-1").css("display","none");
	});
});
/**
 * 展开所有父节点
 */
function expendParent(treeNode){
	var zTree = $.fn.zTree.getZTreeObj("treeDemo");
	var parent_node = treeNode.getParentNode();
	if (parent_node != null) {
		zTree.expandNode(parent_node, true);
		expendParent(parent_node);
	}
}

function selectchapter(folderid,chapterid,versionid,chapterpath){
	$("#sc_folderid").val(folderid);
	//设置版本和知识点树
	$.fn.zTree.destroy();
	if (versionid > 0) {
		mychapter.loadchecked(versionid,chapterid,chapterpath);
	} else {
		mychapter.init();
	}

	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveselectchapter();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogchapter').exec('close');
			return false;
		}
	});
	if(!H.get('dialogchapter')){
		H.create(new P({
			id : 'dialogchapter',
			title: '关联知识点',
			easy:true,
			width:680,
			padding:5,
			content:$('#dialogchapter')[0],
			button:button
		}),'common');
	}

	H.get('dialogchapter').exec('show');
}

function saveselectchapter() {
	var folderid = $("#sc_folderid").val();
	var zTree = $.fn.zTree.getZTreeObj("treeDemo");
	var nodes = zTree.getCheckedNodes(true);//获取 被勾选 的节点集合
	var chapterid = 0;
	if (nodes.length > 0)
		var chapterid = nodes[0].id;
	$.ajax({
		type: "POST",
		url: "<?=geturl('aroomv2/course/selectchapter')?>",
		data:{folderid:folderid,chapterid:chapterid},
		dataType: "json",
		success: function(data){
			var msg = '操作失败';
			if (data!=null && data!=undefined && data=='1')
				var msg = '操作成功';
			H.remove('selectchapter');
			H.create(new P({
				content:msg,
				padding:10,
				easy:true
			},{
				onclose:function(){
					location.reload();
				}
			}),'common').exec('show').exec('close',500);
		}
	});
}
</script>
<!--关联知识点end-->
<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入课程名称')
		searchkey = '';
	location.href = '/aroomv2/course/courselist.html?q='+searchkey;
}
$("#search").bind('submit', function() {
    var searchkey = $.trim($('#searchkey').val());
    if(searchkey == '请输入课程名称') {
        $('#searchkey').val('');
    }
});
function delcourse(courseid,coursewarenum) {
	if(coursewarenum>0){
		alert('该课程下还有课件，如要删除，请先删除课件!');
		return ;
	}
	var deleteDalig = top.dialog({
		id: 'delete-course',
		title: '删除课程',
		content: $('#dialogdel').html(),
		okValue: '删除',
		cancelValue: '取消',
		padding: 20,
		fixed: true,
		ok: function() {
			savedel(courseid);
		},
		cancel: function() {

		},
		onshow: function() {
			var node = $(this.node);
			node.find('.deletecourse').css('margin', '0 auto').css('text-align', 'center').width(339);
			node.find('.tishi').css('background', 'url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/ico.jpg") no-repeat scroll 40px center;')
				.css('padding', '0').css('font-weight', '400').css('color', '#000').css('margin-left', '0')
				.css('margin-top', '40px').css('text-align', 'left').height(36).width(280);
		}
	});
	deleteDalig.showModal();

	return;
	var button = new xButton();
	button.add({
		value:"删除",
		callback:function(){
			savedel(courseid);
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除课程',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}
		
	H.get('dialogdel').exec('show');
}

var allteachers = <?=json_encode($roomteacherlist)?>;
var current_courseid;
function chooseteacher(courseid) {
	current_courseid = courseid;
	var teacherdis = $("#teacherids_"+courseid).val();
	$("#choosetsimp").empty();
	if(teacherdis == "") {
		$("#noteacher").html("还未设置任何任课教师");
	}
	$("#choosetall li input").removeAttr("checked");
	
	var button = new xButton();
	button.add({
		value:"保存",
		callback:function(){
			saveteacher();
			// location.reload(true);
			// H.get('chooseteacher').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('chooseteacher').exec('close');
			return false;
		}
	});
	if(teacherdis != "") {
		teacherids = teacherdis + ',';
		for(var j = 0; j < allteachers.length; j ++) {
			var t = allteachers[j];
			if(teacherdis.indexOf(t.uid) != -1) {
				$("#noteacher").css("display","none");
				$("#choosetsimp").css("display","block");
				var teachername = t.realname+"("+t.username+")";
				var listr = '<li  id="simp'+t.uid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel">';
				listr += '<a class="labelnode" title="'+teachername+'" href="#">'+teachername+'</a>';
				listr += '<a class="labeldel" title="删除标签" onclick="removelabel(\''+t.uid+'\')" href="javascript:void(0)">';
				listr += '<img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif">';
				listr += '</a>';
				listr += '<input type="hidden" value="'+t.uid+'" name="simteacher[]" />';
				listr += '</li>';
				$("#choosetsimp").append(listr);


			}
		}
		$("#choosetall li input").each(function(){
			if(teacherids.indexOf($(this).val()+",") != -1) {
				var tid = $(this).val(); 
				
				$("#allteacheri"+tid).prop("checked","checked");
			}
			
		});
	}
	H.create(new P({
		id:'chooseteacher',
		content:$('.chooseteacher')[0],
		title:'选择任课老师',
		easy:true,
		
		button:button
	},{
		'onshow':function(){
			$(this).focus();
			return false;
		}
	}),'common').exec('show');
}

var allteacher = function(uname){
	var uid = $('.dilan :checked').val();
	if(uname == "请输入老师姓名或账号")
		uname = "";
		
	$.ajax({
		type: "GET",
		url:'<?=geturl('aroomv2/classes/getroomteachers')?>',
		data:{'q':uname},
		dataType:'json',
		success: function(json){
			$('.terwai').show();
			$('#choosetall').empty();
			$(json).each(function(index,item){
				var tid = item['uid'];
				var uname = item['realname'] == ""?item['username']:(item['realname']+"("+item['username']+")");
				var checkstatus = '';
				if($("#simp"+tid).length > 0)
					checkstatus = 'checked="checked"';
				var itemstr = '<li><input type="checkbox" style="top:2px;" value="'
				+item['teacherid']+'" ' + checkstatus + ' onclick="choose(\''+item['teacherid']+'\',\''+uname+'\',this)" id="allteacheri'
				+item['teacherid']+'" '+checkstatus
				+'/><label style="margin-left:4px;_margin-left:2px;" id="teachername_"'+item['teacherid']+' for="allteacheri'+item['teacherid']
				+'" title="'+item['realname']+'('+item['username']+')">'+item['realname']+'('+item['username']+')</label></li>';

				$('#choosetall').append(itemstr);

			});
		}
	}); 
}
var choose = function(teacherid,teachername,dom){
		if($(dom).prop("checked")){
			$("#noteacher").css("display","none");
			$("#choosetsimp").css("display","block");
			var listr = '<li  id="simp'+teacherid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel">';
			listr += '<a class="labelnode" title="'+teachername+'" href="#">'+teachername+'</a>';
			listr += '<a class="labeldel" title="删除标签" onclick="removelabel(\''+teacherid+'\')" href="javascript:void(0)">';
			listr += '<img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif">';
			listr += '</a>';
			listr += '<input type="hidden" value="'+teacherid+'" name="simteacher[]" />';
			listr += '</li>';
			$("#choosetsimp").append(listr);
		}else{
			$("#simp"+teacherid).remove();
			if($("#choosetsimp li").length == 0) {
				$("#choosetsimp").css("display","none");
				$("#noteacher").css("display","block");
			}
		}
	}
	function removelabel(tid){
		$("#simp"+tid).remove();
		$("#allteacheri"+tid).removeAttr("checked");
		if($("#choosetsimp li").length == 0) {
			$("#choosetsimp").css("display","none");
			$("#noteacher").css("display","block");
		}
	}
function saveteacher() {
		courseid = current_courseid;
		var teacherids = "";
		var simp = $("#choosetsimp").children();
		for(var i = 0; i <simp.length; i++) {
			var teacherid = $(simp[i]).attr("id");
			teacherid = teacherid.substring("simp".length);
			if(i == 0)
				teacherids = teacherid;
			else
				teacherids += ","+teacherid;
		}
		$.ajax({
			type: "POST",
			url: "<?=geturl('aroomv2/course/chooseteacher')?>",
			data:{'courseid':courseid,'teacherids':teacherids},
			dataType:'json',
			success: function(json){
				H.remove('chooseteacher');
		   		H.create(new P({
		   			content:'操作成功',
		   			padding:10,
		   			easy:true
		   		},{
		   			onclose:function(){
		   				location.reload();
		   			}
		   		}),'common').exec('show').exec('close',500);
		   }
		}); 
	}
	
function movefolder(folderid,flag){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}

	var data;
	if (pid !== undefined && sid !== undefined) {
		data = { 'pid': pid, 'sid': sid, 'folderid': folderid, 'flag':flag };
	} else {
		data = { 'folderid':folderid,'flag':flag };
	}
	//return;
	$.ajax({
		url:"/aroomv2/course/move.html",
		type:'post',
		data: data,
		dataType:'json',
		success:function(data){
			if(data==1){
				//H.get('xtips').exec('setContent','移动成功').exec('show').exec('close',500);
				top.dialog({
					id: 'note',
					content: '<div class="PPic"></div><p>移动成功</p>',
					skin: "ui-dialog2-tip",
					onshow: function() {
						$(this.node).find('div.ui-dialog2-content').css('display', 'block').width(100);
						$(this.node).find('div.PPic').css('margin', '0 auto 10px')
							.css('background', '#fff url(http://static.ebanhui.com/ebh/tpl/2016/images/yjfsprompt.png) no-repeat center')
							.css('float', 'left').height(26).width(26);
					}
				}).showModal();
				setTimeout(function(){
					location.reload();
				},500);
			}else{
				if(flag == 1)
					alert('已在顶部');
				else
					alert('已在底部');
			}
		}
	});

}
function savedel(courseid){
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
}


// ==================================
// 设置章节
$(function(){
	H.create(new P({
		id : 'sectiondiv',
	    title: '设置章节',
	    padding:2,
	    easy:true,
	    content:$('#sectiondiv')[0]
	}),'common');

});

var current_folderid;
function setsection(folderid){
	current_folderid = folderid;
	updatesection();
}

function section(){
    var folderid = current_folderid;
	$.ajax({
		url:"<?= geturl('troom/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			$('#dnone').css('display',"");
			$('#sectionid').empty();
			$.each(data,function(key,value){
				$('#sectionid').append('<option value="'+value.sid+'">'+value.sname+'</option>');
			});
			try{
			window.parent.resetmain();
			}catch(error){}
		}
	});
}

function edittitle(val){
	var title = $("#"+val+"name").val();
	$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="50" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction('+val+');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\')" class="bcun" value="取消" /><div></div>');
}
function editclose(title,val){
	$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">[<cite>向下</cite>]</a></div></span><div></div>');
}
//编辑章节
function saction(val){
	var title =$('#'+val+'title').val();
	$.ajax({
		url:"<?= geturl('troom/section/edit') ?>",
		type:'post',
		data:{'sid':val,'title':title},
		dataType:'json',
		success:function(data){
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+val+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+val+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+val+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+val+')">[<cite>向下</cite>]</a></div></span><div></div>');
			$("#sname").val("");
		}
	});
}
//删除章节
function delsction(val){
	if (!confirm("确认要删除该章节？")) {
		return false;
	}
	$.ajax({
		url:"<?= geturl('troom/section/del') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tr"+data.sid).html('');
				updatesection();
				$("#sname").val("");
				//section()
			}
		}
	});
}
//添加章节
function addsction(val){
	var sname = $('#'+val).val();
	if (sname.length>50 || sname.length<1) {
		$(".SG_txtc").html('<font color="red">1-50个字符，包括中文,字母,数字</font>');
		return false;
	};
        var folderid = current_folderid;
	$.ajax({
		url:"<?= geturl('troom/section/add') ?>",
		type:'post',
		data:{'sname':sname,'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+data.sid+')">[<cite>编辑</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+data.sid+')">[<cite>删除</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+data.sid+')">[<cite>向上</cite>]</a><a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+data.sid+')">[<cite>向下</cite>]</a></div></span><div></div></li>');
				$("#sname").val("");
				//section();
			}
		}
	});
}

function moveup(val){
	if($("#tr"+val).prev().size()==0){
		return;
	}
	$.ajax({
		url:"<?= geturl('troom/section/moveup') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

function movedown(val){
	if($("#tr"+val).next().size()==0){
		return;
	}
        var folderid = current_folderid;
	$.ajax({
		url:"<?= geturl('troom/section/movedown') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

var updatesection = function(){
    var folderid = current_folderid;
	$.ajax({
		url:"<?= geturl('troom/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			var objhtml='<div style="width:520px;">'
				objhtml+='<div id="categoryBody" style="width:485px">'
				objhtml+='<div id="categoryHead">'
				objhtml+='<table style="border:none !important;">'
				objhtml+='<tbody>'
				objhtml+='<tr>'
				objhtml+='<td>'
				objhtml+='<input class="categoryName" style="height:22px;padding:0px;" type="text" name="sname" id="sname" maxlength="50">'
				objhtml+='</td>'
				objhtml+='<td width="80">'
				objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
				objhtml+='<cite>创建章节</cite>'
				objhtml+='</a>'
				objhtml+='</td>'
				objhtml+='<td>'
				objhtml+='<span class="SG_txtc" style="margin-left:5px;width:240px;display:block;color:#999;">请用中文,英文或数字.1-50个字符!</span>'
				objhtml+='</td>'
				objhtml+='</tr>'
				objhtml+='</tbody>'
				objhtml+='</table>'
				objhtml+='<div id="errTips"></div>'
				objhtml+='</div>'
				objhtml+='<form name="form" method="post">'
				objhtml+='<div id="categoryList">'
				objhtml+='<ul class="clearfix" id="tsection">'
				$.each(data,function(k,v){
					objhtml+='<li id="tr'+v.sid+'">'
					objhtml+='<span class="htit" id="'+v.sid+'catitle" ><input type="hidden" id="'+v.sid+'name" value="'+v.sname+'" />'+v.sname+'</span>'
					objhtml+='<span class="control" STYLE="FLOAT:RIGHT">'
					objhtml+='<div class="manage">'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="edittitle('+v.sid+')">'
					objhtml+='[<cite>编辑</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
					objhtml+='[<cite>删除</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
					objhtml+='[<cite>向上</cite>]</a>'
					objhtml+='<a class="CP_a_fuc" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
					objhtml+='[<cite>向下</cite>]</a>'
					objhtml+='</div>'
					objhtml+='</span>'
					objhtml+='</li>'
				});
				objhtml+='</ul>'
				objhtml+='<div class="SG_j_linedot"></div>'
				objhtml+='</div>'
				objhtml+='</form>'
				objhtml+='</div>'
				objhtml+='</div>'
				$("#sectiondiv").html(objhtml);
				H.get('sectiondiv').exec('show');
			return;
		}
	});
}
<?php if ($room['isschool'] == 7) { ?>
if (pid > 0) {
	//添加全部选项
	$("#pack-sort-list").append('<div class="spblock"><div class="labelpane labelsp" idtype="sp" idval="-1" pid="0" style="margin-left:0;padding-left:0;font-weight:700"><span class="itemlabel">查看全部分类</span><input value="查看全部分类" class="inputpane hide"></div><div id="sp0" class="subblock sub opened"></div></div>');
}
var simpletree = new Simpletree();
simpletree.init('pack-sort-list',true).toSimple().start(true);
// ==================================
(function($) {
	var page = 1;
	var loadeable = <?=!empty($loadmore) ? 'true' : 'false' ?>;
	var loading = false;
	function loadmore() {
		page++;
		var d = { loading: true, page: page, pid: pid };
		if (sid > -1) {
			d.sid = sid;
		}
		$.ajax({
			url: '/aroomv2/course/courselist.html',
			type: 'get',
			dataType: 'html',
			data: d,
			beforeSend: function() {
				$("#loading-animation").css('visibility', 'visible');
				loading = true;
			},
			success: function(html) {
				$("#loading-animation").css('visibility', 'hidden');
				if (html == '') {
					//全部加载完成，卸载父窗滚动加载事件
					$(top).unbind('scroll');
					return;
				}
				$("#dtable").append(html);
				$(".management-1").mouseenter(function(){
					$(this).find(".moreoperate-1").css("display","block");
				});
				$(".management-1").mouseleave(function(){
					$(this).find(".moreoperate-1").css("display","none");
				});
				top.resetmain();
				loading = false;
			}
		});
	}
	function topListen() {
		$(top).bind('scroll', function() {
			if (loading) {
				return;
			}
			var jwindow = $(this);
			var scrollTop = jwindow.scrollTop();
			var scrollHeight = $(top.document).height();
			var windowHeight = jwindow.height();
			if(scrollTop + windowHeight + 100 >= scrollHeight){
				loadmore();
			}
		})
	}

	$("div.pack-sort").bind('mouseleave', function() {
	 	$("#pack-sort-list").hide();
	 });
	$("#pack-sort-cur").bind('click', function(e) {
		$("#pack-sort-list").show();//.toggle();
	});
	simpletree.setCallBack(function(idtype, idval, pid) {
		$("#pack-sort-list").hide();
		if (idtype == 'sort') {
			sorteable = true;
			document.location.href = "/aroomv2/course/courselist.html?pid=" + pid + "&sid=" + idval;
			return;
		}
		if (idtype == 'sp') {
			sorteable = false;
			var url = "/aroomv2/course/courselist.html";
			if (pid > 0) {
				url += "?pid=" + pid;
			}
			document.location.href = url;
		}
	})
	$(window).bind('unload', function() {
		$(top).unbind('scroll');
	}).bind('load', function() {
		if (!loadeable) {
			return;
		}
		$(top).scrollTop(0);
		topListen();
	});
})(jQuery);
<?php } ?>
</script>
</body>
</html>
