<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>


<body>
<div>
    <div class="ter_tit">
        当前位置 > 门户配置
    </div>
    <div class="templaten mt15">
    	<ul>
            <?php if(!empty($plate)) { ?>
                <li class="mokuaipeizhi_home fl"><a href="<?=geturl('room/portfolio/custportal')?>" target="_blank"></a></li>
            <?php } else { ?>
                <li class="mokuaipeizhi_c fl"><a href="<?=geturl('aroomv2/module/custommodule')?>" target="_blank"></a></li>
            <?php } ?>
			<li class="menhupeizhiffix_c fl"><a href="<?=geturl('aroomv2/moduledit')?>"></a></li>
			<?php 
			$roominfo = Ebh::app()->room->getcurroom();
			if($roominfo['template'] == 'drag' || $roominfo['template'] == 'plate'){?>
			<li class="dmokuaipeizhi_m fl"><a href="<?=geturl('aroomv2/module/navigator')?>"></a></li>
			<?php }?>
            <li class="mokuaipeizhi_p fl"><a href="<?=geturl('aroomv2/module/manage')?>"></a></li>
            <li class="mokuaipeizhit_p fl"><a href="<?=geturl('aroomv2/module/manage')?>?tors=1"></a></li>
        </ul>
    </div>
</div>
</body>
</html>
