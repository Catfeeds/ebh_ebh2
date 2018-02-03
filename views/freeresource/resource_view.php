<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  style="background-color:#f5f5f5;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=empty($seoInfo['title'])?$this->get_title():$seoInfo['title']?></title>
<meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
<meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/epaper/base.css" media="screen" />
<link href="http://static.ebanhui.com/portal/css/ebhportal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.topreg {
width:100%;
border-top:solid 2px #25a0cc;
}
.neigtop {
width:950px;
margin:0 auto;
background:url(http://static.ebanhui.com/ebh/images/epaper/banner.jpg) repeat-x;
height:47px;
padding-top:36px;
padding-left:10px;
}
.maiwfle {
background-color:#fff;
width:958px;
margin:10px auto 0;
border:solid 1px #dedede;
}
.maiwfle a.lvbtnl {
width:120px;
height:38px;
display:block;
background-color:#82c617;
line-height:38px;
text-align:center;
font-size:14px;
text-decoration:none;
margin:20px 0 5px 20px;
}
.maiwfle a.lvbtnl:hover {
background-color:#83d601;
color:#3D3D3D;
}
</style>
</head>
<body>
<div class="topreg">
<div class="neigtop">
<!-- <img src="http://static.ebanhui.com/ebh/images/epaper/titjinp.jpg" /> -->
</div>

<div class="rgkjer" style="width:960px">
<h2 class="kjsgf"><?=$resource['title']?></h2>
<span class="dskfre"><span class="sizfes">类型：</span><?=$resource['restype']?></span>
<span class="dskfre"><span class="sizfes">格式：</span><?=$resource['resfileext']?></span>
<span class="dskfre"><span class="sizfes">浏览：</span><?=$resource['viewnum']?>次</span>
<span class="dskfre"><span class="sizfes">下载：</span><?=$resource['downloadnum']?>次</span>
<span class="dskfre"><span class="sizfes">作者：</span>系统管理员</span>
<span class="dskfre"><span class="sizfes">上传时间：</span><?=$resource['date']?></span>
<span class="dskfre"><span class="sizfes">适用对象：</span><?=$resource['usertype']?></span>
<span class="dskfre"><span class="sizfes">大小：</span><?=$resource['ressize']?></span>
</div>

<div class="maiwfle">
<a href="/freeresource/resource/attach.html?attachid=<?=$resource['resid']?>" class="lvbtnl">下载资源</a>

<?php if($hasPreview) {?>
<div style="border-top:solid 2px #82c617;width:918px;margin:0 20px">

<!-- <div> -->
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="918" height="600" id="Main">
                <param name="movie" value="/freeresource/resource/preview/<?=$resource['resid']?>.html" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#869ca7" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <!--
                <param name="wmode" value="opaque" />
                -->
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="/freeresource/resource/preview/<?=$resource['resid']?>.html" width="918" height="600">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#869ca7" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                	<p> 
                		Either scripts and active content are not permitted to run or Adobe Flash Player version
                		10.0.0 or greater is not installed.
                	</p>
                <!--<![endif]-->
                    <a href="http://www.adobe.com/go/getflashplayer">
                        <img src="/static/images/get_flash_player.gif" alt="Get Adobe Flash Player" />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>

<!-- </div> -->
</div>
<?php }?>
</div>
</div>

</body>
</html>