<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教师管理</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>

<body>
<!--右边-->
<div>
    <div class="ter_tit">
        当前位置 > 教师管理
    </div>
    <div class="teachermanage mt15">
    	<ul>
			<?php if($this->uri->uri_domain() != 'zjgxedu') { ?>
        	<li class="jiaoyanzu_p fl"><a href="/aroomv2/teacher/groups.html"></a></li>
			<?php } ?>
            <li class="jiaoshiguanli_p fl"><a href="/aroomv2/teacher/manages.html"></a></li>
        </ul>
    </div>
</div>
</body>
</html>
