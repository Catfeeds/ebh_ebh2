<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课程管理</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<body>
<!--右边-->
<div >
    <div class="ter_tit">
        当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; 本校课程
    </div>
    <div class="lessonmanage mt15">
    	<ul>
            <?php if ($room['isschool'] == 7) { ?><li class="curriculumviewlist_p fl"><a href="<?=geturl('aroomv2/coursesort')?>"></a></li><?php } ?>
            <li class="kechengguanli_p fl"><a href="<?=geturl('aroomv2/course/courselist')?>"></a></li>
            <!--<li class="kechengmulu_p fl"><a href="<?/*=geturl('aroomv2/catalog')*/?>"></a></li>-->
			<li class="zhishidian_p fl"><a href="<?=geturl('aroomv2/chapter')?>"></a></li>
        <?php if ($ischecktype) {?>
            <li class="kejianshenhe_p fl"><a href="<?=geturl('aroomv2/courseware')?>"></a></li>
        <?php }?>
			<?php if(!empty($modulecredit)){ ?>
				<li class="xuefenshezhi_p fl"><a href="<?=geturl('aroomv2/schcredit')?>"></a></li>
			<?php }?>
        </ul>
    </div>
</div>
</body>
</html>

