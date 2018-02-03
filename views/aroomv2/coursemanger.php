<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>知识点管理</title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<body>
<!--右边-->
<div >
    <div class="ter_tit">
        当前位置 &gt; 课程管理
    </div>
    <div class="lessonmanage mt15">
    	<ul>
            <li class="keshcut fl"><a href="<?=geturl('aroomv2/course/courses')?>"></a></li>
            <?php //if($this->uri->uri_domain() == 'test' || $this->uri->uri_domain() == 'demo'){ ?><!-- 测试专用链接入口，上线后去掉 -->
            <li class="yisnrf fl">
            <?php if(!empty($sys) && $sys['service'] == 1){ ?>
            	<a href="<?=geturl('aroomv2/jingpin')?>"></a>
            <?php }else{ ?>
            	<a target="_blank" href="/jingpin/yyxz.html"></a>
            <?php } ?>
            </li>
            <?php //} ?>
        </ul>
    </div>
</div>
</body>
</html>