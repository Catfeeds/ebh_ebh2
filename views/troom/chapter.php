<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/common.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?t=1" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.confirm.js"></script>

	<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.exedit-3.5.js"></script>
<style type="text/css">
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
</style>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/classsubject')?>">课程管理</a> > 知识点浏览
</div>
<div class="lefrig" style="margin-top:15px;">
	<div class="workdata"  style="background-color:#fff;margin:0;width: 788px;">
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
			<div style="min-height: 790px;overflow-y:auto;">
				<div>
					<div id="categoryListx" style="height:700px;">
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
</div>
<script>
$(function(){

	<?php if(empty($notop)){?>
	if (top.location == self.location) {
		setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
		top.location='/troom.html';
    }else{
    	parent.window.refresh('classsubject');
    }
	<?php }?>
});
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/mychapterview.js"></script>
<?php $this->display('troom/page_footer'); ?>