<?php
if (! defined ( 'IN_EBH' )) {
	exit ( 'Access Denied' );
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=no" name="viewport"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线作业</title>
<?php $v=getv();?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/exam/css/public.bak.css<?=$v?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/zujuan.css<?=$v?>"/>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/dtree.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/common.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/exam.js<?=$v?>"></script>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
global $_SGLOBAL;
?>
var isMobile = '<?php echo $isMobile; ?>';
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var examobj= new Exam();//【超级全局变量 】试卷类  变量名不可更改
var eid = '<?=$eid?>';
var crid=<?=$crid?>;
var flag = '<?=$flag?>';
$(function(){
	examobj.outWordByEid(eid,flag);
});
</script>
</head>
<body>

<div class="sheet-con">
<div id="desk" class="layoutContainer" style="margin:-115px 0 0 0; position:relative;">
    <div id="center">
    	<div id="webEditor">
            <div id="viewcontent" class="font12px fontSimsum jqtransformdone">              
                <div id="loadimg" style="width:100px;height:100px;margin:0 auto;"><img style="margin:0 auto;" title="加载中..." src="/static/images/loading.gif"/></div>
            </div>
        </div>
    </div>
</div>
</div>
<input type="hidden" id="crid" value="<?php echo $crid;?>" />
</body>
</html>