<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生管理</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>

<body>
<div>
    <div class="ter_tit">
        当前位置 > 学生管理
    </div>
    <div class="classmanagement mt15">
    	<ul>
		<?php if($this->uri->uri_domain() != 'zjgxedu') { ?>
        	<li class="banjiguanli_p fl"><a href="<?=geturl('aroomv2/classes')?>"></a></li>
		<?php } ?>
			<?php if($this->uri->uri_domain() == 'lcyhg') { ?>
            	<li class="xueshengguanli_p fl"><a href="<?=geturl('aroomv2/lcyhstu')?>"></a></li>
            <?php }else{ ?>
            	<li class="xueshengguanli_p fl"><a href="<?=geturl('aroomv2/student')?>"></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
</body>
</html>
