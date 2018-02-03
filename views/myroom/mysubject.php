<script language="javascript" type="text/javascript" src="/static/js/drag.js"></script>
<link type="text/css" href="/static/css/upload.css" rel="stylesheet" />
<link type="text/css" href="/static/tpl/default/css/main.css" rel="stylesheet" />
<style type="text/css">
.kejian {
	width: 748px;
	border: 1px solid #dcdcdc;
	float: left;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-top: 8px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 128px;
	display: block;
	margin-bottom: 8px;
	margin-left: 4px;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(/static/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}

</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(function(){
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			//$(".showimg").parent().not(this).find("img").stop().animate({opacity:'1'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			//$(".showimg").parent().not(this).find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});

		$("#searchbutton").click(function(){
			var search = encodeURIComponent($('#searchvalue').val());
			if($('#searchvalue').val()=='请输入您要搜索的课件名称'){
				search='';
			}
			location.href=url;
		});
	});

	

//-->
</SCRIPT>

<div class="ter_tit">
	当前位置 > <a href="#geturl(myroom/stusubject)#">学习课程</a> > 我的课程
</div>
<div class="lefrig">
	<div class="kejian" style="margin-top:10px;">
		<div class="other_room_tit"><h2>我的课程</h2></div>
		
			<ul class="liss">
			
				<li class="danke" style="margin-left:4px; _margin-left:2px;height:220px;">
				<div class="showimg"><a href="$furl"><img src="" width="114" height="159" border="0" /></a></div>
				<span class="spne"><a href="$furl">{$fval['foldername']}</a>($fval['coursewarenum'])</span>
				</a>
				</li>
	
			</ul>
			<div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>

		<div style="clear:both;"></div>
	</div>
</div>
