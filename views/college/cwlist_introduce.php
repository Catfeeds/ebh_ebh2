<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();
if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$folder['foldername']?> 课程介绍</title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/style.css?v=2016061301"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002"/>
<style>
.studyalert{
	background:white;position:absolute;display:none;border:1px solid;width:130px;text-align:center;z-index:100
}
body {
	background:#8493af;
}
/*分页start*/
.listPage a:visited {
    background: #f9f9f9;
    border: 1px solid #f9f9f9;
    color: #323232;
    display: block;
    float: left;
    height: 26px;
    line-height: 26px;
    margin: 0 2px;
    text-align: center;
    text-decoration: none;
    width: 30px;
}
.listPage a:hover {
    border: 1px solid #0ca6df;
    text-decoration: none;
}

.listPage a {
    background: #f9f9f9;
    border: 1px solid #f9f9f9;
    color: #767676 !important;
    display: block;
    float: left;
    font-weight: bold;
    height: 26px;
    line-height: 26px;
    margin: 0 2px;
    text-align: center;
    text-decoration: none;
    width: 30px;
    cursor:pointer;
    font-size:14px;
}
.pages {
    float: right;
    height: 50px;
    padding-right: 20px;
    padding-top: 15px;
}
.listPage .none {
    background: #23a1f2 !important;
    border: 1px solid #23a1f2;
    color: #ffffff !important;
    font-weight: bold;
}
#next {
    height: 26px;
    width: 66px;
}
/*分页end*/
</style>
<body>
<div class="wrap" style="margin:0 auto!important;">
	<!--左边-->
	<div class="wrapleft fl">
        <div class="wrapleftson" style="height:auto!important">
            <div class="xxjdsee">
			<!--
                <p>
                    <span class="span1s">您上次学到：</span>
                    <span class="span2s">2.1古典诗歌发展史</span>
                    <a href="#">继续学习</a>
                </p>-->
            </div>
            <p class="p1">你有<a href="javascript:void(0)" style="cursor:default" id="unfinishedcount"></a>个课件未完成</p>
            <div class="kechenglist">
			<?php
				$unfinishedcount = 0;
				foreach($sectionlist as $k=>$section) {
					$keys = array_keys($section);
					$enabled = true;
					?>
                <div>
                    <ul class="ul0">
                        <li>
                            <div>
                                <div class="fl"><span class="span1s"><?=$section[$keys[0]]['sname']?></span></div>
                                <div class="fr"><span class="span2s">进度</span></div>
                            </div>
                            <div class="clear"></div>
                            <ul class="ul1">
                                <li>
                                    <div>
                                        <ul>
										<?php foreach($section as $cw){
											if($enabled && empty($cw['disabled']) || empty($folder['playmode']))
												$enabled = true;
											else
												$enabled = false;
											?>
                                            <li>
                                                <div  class="title fl">
												<?php if($enabled){?>
												<a class="cwlink" href="/myroom/mycourse/<?=$cw['cwid']?>.html?fromintro=1" url="/myroom/mycourse/<?=$cw['cwid']?>.html" target="mainFrame"><?=shortstr($cw['title'],34,'')?></a>
												<?php }else{?>
												<span onmouseover="$('#studyalert<?=$cw['cwid']?>').show()" onmouseout="$('#studyalert<?=$cw['cwid']?>').hide()"><?=shortstr($cw['title'],34,'')?></span>
												<div id="studyalert<?=$cw['cwid']?>" class="studyalert">请按课件顺序学习</div>
												<?php }?>
												</div>
                                                <div class="xuxijd fr">
													<?php if($cw['percent'] !=0 && $cw['percent'] != 100){$unfinishedcount++;?>
                                                        <!--正在学习-->
                                                    <div class="zzxx" style="">
                                                        <span class="zzxx_son" style="width:<?=$cw['percent']?>%"></span>
														<span style="position:relative;top:-18px;left:18px;color:white"><?=$cw['percent']?>%</span>
                                                    </div>
													<?php }elseif($cw['percent'] == 100){?>
                                                        <!--已经完成-->
                                                    <div class="ywc" >
                                                        <span><?=$cw['percent']?>%</span>
                                                    </div>
													<?php }else{ $unfinishedcount++;?>
                                                        <!--未开始学习-->
                                                    <div class="mkk" style=""></div>

													<?php }?>
                                                </div>
                                                <div class="clear"></div>
                                            </li>
										<?php }?>

                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php }?>


                <div style="clear:both;" class="group"><?=$pagestr?></div>
            </div>
        </div>
    </div>
    <!--右边-->
    <div class="wrapright fr def">
    	<div class="titles"><?=$folder['foldername']?></div>
        <div>
            <div class="fl">
                <div class="kcenroll">
				<!--
                    <a href="#" class="kecen">课程报名</a>-->
                    <p class="p1s">学校：<?=$roominfo['crname']?></p>
                    <p class="p1s" style="line-height:15px;">课时：<?=$cwcount?></p>
                </div>
            </div>
			
            <div class="fr">
                <div class="kcassess"><!--
                    <a href="#" class="kcasse">课程评价</a>
                    <p class="p1s">(40人已评价)</p>-->
					<?php
						$viewnumlib = Ebh::app()->lib('Viewnum');
						$viewnum = $viewnumlib->getViewnum('folder',$folder['folderid']);
					?>
                    <p class="p1s" style="line-height:15px;">访问数：<?=$viewnum?></p>
                </div>
            </div>
			
        </div>
        <div class="clear"></div>
        <div class="mululist" style="min-height:100px">
        	<div class="titles">目录</div>
        	<div class="mululistson">
            	<ul>
					<?php if(!empty($folder['introduce'])){
					foreach($folder['introduce'] as $k=>$introduce){?>
					
                	<li><a href="#i<?=$k?>"><?=$introduce['title']?></a></li>
					<?php }}?>
                </ul>
            </div>
        </div>
		<?php if(!empty($folder['introduce'])){
			foreach($folder['introduce'] as $k=>$introduce){?>
		<a name="i<?=$k?>"></a>
        <div class="kcjj">
        	<div class="title2"><?=$introduce['title']?></div>
            <p class="p2s"><?=$introduce['content']?></p>
        </div>
        <?php }
		}?>
    </div>
	
	<iframe id="mainFrame" name="mainFrame" frameborder="0" style="display:none;width:997px">
	</iframe>

</div>
</body>
<script>
var intro = true;
$(function(){
	// $('.def').show();
	// $('.wrap').css('width','980px');
	$('#unfinishedcount').html('<?=$unfinishedcount?>');
});
$('.cwlink').click(function(){
	// $('#mframe').attr('src',$(this).url);
	$('.wrap').css('width','1310px');
	$('#mainFrame').show();
	$('.def').hide();
});
$('#mainFrame').load(function(){
	resetmain();
});
var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	//var iframeHeight = Math.max(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+1;
	//var iframeHeight = Math.max()+1;
	var iframeHeight = $(window).height();
	iframeHeight = iframeHeight<700?700:iframeHeight;
	$(mainFrame).height(iframeHeight);
}
</script>
</html>
