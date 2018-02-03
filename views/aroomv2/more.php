<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更多应用</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<style>
    .lessonmanage .huodongzhuanqu_p{ background:url(http://static.ebanhui.com/ebh/tpl/aroomv2/images/hdzq.jpg) no-repeat center; width:231px; height:231px;}
    .lessonmanage .xuanke_p{ background:url(http://static.ebanhui.com/ebh/tpl/selcur/images/xuankest.jpg) no-repeat center; width:231px; height:231px;}
    .lessonmanage .health_p{ background:url(http://static.ebanhui.com/ebh/tpl/2016/images/health.jpg) no-repeat center; width:231px; height:231px;  
    }
    .lessonmanage .forum_p{ background:url(http://static.ebanhui.com/forum/img/sign.jpg) no-repeat center; width:231px; height:231px;  
    }
</style>
<body>
<!--右边-->
<div >
    <div class="ter_tit">
        当前位置 > 更多应用
    </div>
    <div class="lessonmanage mt15">
    	<ul>
            <li class="wenjuandiaocha_p fl"><a href="<?=geturl('aroomv2/more/survey')?>"></a></li>
			<?php $selectcourse = Ebh::app()->getConfig()->load('selectcourse');
				if (!empty($moduleselectcourse) && in_array($room['crid'], $selectcourse['crids'])) {?>
				<li class="xuankeguanli_p fl"><a href="<?=geturl('aroomv2/selectcourse/courselist')?>"></a></li>
			<?php }?>
			<?php if (!empty($moduleyunpan)){?>
				<li class="yunpanguanli_p fl"><a href="<?=geturl('aroomv2/yunpan')?>"></a></li>
			<?php }?>
            <?php if (!empty($moduleactivity)) { ?>
                <li class="huodongzhuanqu_p fl"><a href="/aroomv2/activity.html"></a></li>
            <?php } ?>
            <?php if (!empty($moduleeth)){?>
				<li class="wxtsz_p fl"><a href="<?=geturl('aroomv2/ethsetting')?>"></a></li>
			<?php } ?>
            <?php if (!empty($modulexuanke)){?>
                <li class="xuanke_p fl"><a href="xuanke.html"></a></li>
            <?php }?>
            <?php if(!empty($modulehealth)){?>
                <li class="health_p fl"><a href="/aroomv2/health.html"></a></li>
            <?php }?>


            <?php if(!empty($moduleforum)){?>
                <li class="forum_p fl"><a href="/aroomv2/forum.html"></a></li>
            <?php }?>
        </ul>
    </div>
</div>
</body>
</html>
