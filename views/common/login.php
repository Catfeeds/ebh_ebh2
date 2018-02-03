<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $this->get_title() ?></title>
<meta name="keywords" content="<?= $this->get_keywords() ?>" />
<meta name="description" content="<?= $this->get_description() ?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/yhdl.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<style type="text/css">
.errorLayer {
    font-size: 12px;
    width: 218px;
}
.errorLayer .login_top {
    background: transparent url("http://static.ebanhui.com/ebh/tpl/default/images/errorLayer_03.gif") no-repeat scroll 0 0;
    height: 2px;
    overflow: hidden;
}
.errorLayer .login_mid {
    background: #fff;
    overflow: hidden;
    padding: 8px 20px;
    position: relative;
	border-left:1px solid #ccc;
	border-right:1px solid #ccc;
}
.errorLayer .login_bot {
    background: transparent url("http://static.ebanhui.com/ebh/tpl/default/images/errorLayer_16.gif") no-repeat scroll 0 0;
    height: 7px;
    overflow: hidden;
}
.errorLayer .login_mid .conn {
    overflow: hidden;
    width: 187px;
}
.errorLayer .login_mid .conn .bigtxt {
	color: #f16771;
    background: url('http://static.ebanhui.com/ebh/tpl/2016/images/errorts.png') no-repeat left center;
    padding-left: 23px;
    height: 25px;
    line-height: 25px;
}
.errorLayer .login_mid .conn .stxt {
    line-height: 18px;
    padding-left: 20px;
}
.errorLayer .login_mid .conn .stxt2 {
    line-height: 18px;
    padding-left: 2px;
}
.login_mid .tips_close {
    color: #666666;
    cursor: pointer;
    font-family: "黑体";
    font-size: 16px;
    font-weight: bold;
    position: absolute;
    right: 10px;
    top: 0;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/pan/js/slideBox.js"></script>
<script language="javascript">
<!--
$(function(){

    $("#mod_login_close").click(function(){
        $("#mod_login_tip").fadeOut();
    });

    //下次自动登录
    $("#remember").toggle(function(){
    	$(this).removeClass("choose");
    	$("#cookietime").val("0");
    },function(){
    	$(this).addClass("choose");
    	$("#cookietime").val("1");
    });

    $(".yuzhanghao").click(function(){
    	$(this).children("input").focus();
    });

	initPlaceholder();
	checkiframe();
});
/**
 * 防止登录页面被iframe嵌套
 */
function checkiframe(){
	if (self == top) {
	    var theBody = document.getElementsByTagName('body')[0];
	    theBody.style.display = "block";
	} else {
	    top.location = self.location;
	}
}


//初始化placeholder
function initPlaceholder(){
	var n = "placeholder" in $("<input>")[0];
	if(!n){
		$(".yuzhanghao input").each(function(){
			var s = $(this);
			var o = s.prev(".placeholder");
			var i = function() {
				0 == s.val().length ? o.show() : o.hide()
			};
			if (0 == o.length) {
				o = $('<span>');
				o.addClass("placeholder").html(s.attr("placeholder")).attr("unselectable", "on");
				s.before(o).attr("data-placeholder", s.attr("placeholder"));
				s[0].removeAttribute("placeholder");

				s.bind("focus", function(){
			    	$(this).parent().removeClass("errorts").addClass("shuru");
			    	$(this).prev(".placeholder").hide();
			    });
			    s.bind("blur", function(){
					$(this).parent().removeClass("shuru");
					$(this).val().length == 0 ? $(this).prev(".placeholder").show() : $(this).prev(".placeholder").hide();
			    });
			    s.bind("input propertychange", function() {
			    	$(this).prev(".placeholder").hide();
			    });
			}
			var h = 3,
				p = setInterval(function() {
					--h <= 0 && clearInterval(p), i()
				}, 300);
			i()
		});
	}
}

//错误提示
function tipname_message(message,high){
    if ($("#mod_login_tip").is(":visible")){
        $("#mod_login_tip").stop(true, true).animate({"top":high}, " slow", "swing", function(){
            $("#mod_login_tip").fadeOut("fast", function(){
                $("#mod_login_title").text(message);
                $("#mod_login_tip").fadeIn("slow");
            });
        });
    } else{
         $("#mod_login_title").text(message);
         $("#mod_login_tip").css("top",high).fadeIn("slow");
    }
}

function form_submit(){
	//清空之前错误提示
	$("#mod_login_tip").fadeOut();
    if ($('#username').val() == '' || $('#username').val () == '用户名'){
        tipname_message('用户名不能为空',17);
        $("#username").parent().addClass("errorts");
        return;
    }
    if ($("#password").val () == ''){
        tipname_message('密码不能为空',71);
        $("#password").parent().addClass("errorts");
        return;
    }
    var url = '<?= geturl('login').'?inajax=1&returnurl='.(($this->input->get('returnurl') == NULL) ? '' : urlencode($this->input->get('returnurl'))).'&type='.$this->input->get('type') ?>';
	var screen = (window.screen.width || 0) + "x" + (window.screen.height || 0);
	var data = $("#form1").serialize();
	data += '&screen='+screen;
    $.ajax({
        url:url,
        data:data,
        type:'POST',
        dataType:'json',
        success	:function(json){
            if (json['code'] == 1){
				if((json['durl'] != undefined) && (json['durl'] !='')) {
					dosso(json['durl'],json["returnurl"]);
				} else {
					location.href = json["returnurl"];
				}
            } else{
                tipname_message(json["message"],17);
        		$("#password").parent().addClass("errorts");
            }
            return false;
        }
    });
}
function dosso(durl,returnurl,callback) {
	window.allimgcount = 0;
	window.curimgcount = 0;
	var durls = durl.split(',');
	window.allimgcount = durls.length;
	for(var i = 0; i < durls.length; i ++) {
		var idurl = durls[i];
		var img = new Image();
		img.src = idurl+"&" + Math.random();
		$(img).appendTo("body");
		if(img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
			window.curimgcount ++;
			if(window.allimgcount == window.curimgcount && returnurl != undefined && returnurl != "") {
				location.href = returnurl;
			} else if(typeof(callback) == 'function') {
				callback();
			}
			return; // 直接返回，不用再处理onload事件
		}
		img.onload = function () { //图片下载完毕时异步调用callback函数。
			window.curimgcount ++;
			if(window.allimgcount == window.curimgcount && returnurl != undefined && returnurl != "") {
				location.href = returnurl;
			} else if(typeof(callback) == 'function') {
				callback();
			}
		};
	}
}
//-->
</script>

<style>
.top {
    width: 100%;
    height: 437px;
    overflow: hidden;
    margin: 0 auto;
	opacity: 1;
	background:#222045 url('http://static.ebanhui.com/ebh/tpl/2016/images/banner1.jpg')  no-repeat center;
}
</style>
</head>
<body>
<div class="header swbgt">
    <a class="logoebh" href="/" style="margin:0 20px 0 0;width:85px;"><img src="http://static.ebanhui.com/portal/images/ebh_logo.jpg"></a>
    <img style="float:left;" src="http://static.ebanhui.com/portal/images/ebh_wenlogo.jpg">
</div>
<div class="lsitrs">
    <div id="IndexBanner" class="top"></div>
<?php
$url = geturl('login') . '?inajax=1&returnurl=' . $this->input->get('returnurl');
?>
    <div class="loginfa">
	    <div><a href="<?=geturl('createroom')?>" class="nowjoin" style="display: none"></a></div>
		<div class="slide-point-box">
			<span data-index="1" class="cur-point"></span>
			<span data-index="2" class=""></span>
		</div>

        <div class="logins">
		<form id="form1" method="post" name="form1" action="<?= $url ?>" onsubmit="form_submit(); return false;">
		    <input type="hidden" name="loginsubmit" value="1" />
			<input type="hidden" name="sharp" value="<?=$sharp?>"/>
			<input type="hidden" name="cookietime" id="cookietime" value="1" />
            <div class="loginson">
                <div class="title">用户登录</div>
                <div class="yuzhanghao"><span class="ypspan1s fl"></span><input name="username" type="text" class="ypinput fl" id="username" tabindex="1" title="请输入用户名" value="<?=!empty($un)?$un:''?>" placeholder="用户名" /></div>
                <div class="clear"></div>
                <div class="yuzhanghao"><span class="ypspan2s fl"></span><input name="password" type="password" class="ypinput fl" id="password" tabindex="2" title="请输入密码" value="" placeholder="密码" /></div>
                <div class="clear"></div>
                <div class="xczddl mt10"><a class="choose" href="javascript:;" id="remember">下次自动登录</a></div>
                <div class="clear"></div>
                <div class="dlbtn mt10"><input value="登录" class="logbtn" type="submit"></div>
                <div class="lofo mt5">
                    <div class="zhuce fl"><a href="<?=geturl('register')?>">立即注册</a></div>
                    <div class="wjmm fr"><a href="<?= geturl('forget')?>">忘记密码</a></div>
                </div>
                <div class="clear"></div>
                <div class="thirddl mt25">
                    <div class="thirddlson ml35 mt15">
                        <a href="<?=geturl('otherlogin/qq')?><?=($this->input->get('returnurl'))?"?returnurl=".urlencode($this->input->get('returnurl')):""?>"><img src="http://static.ebanhui.com/pan/images/qq.png"></a>
                        <a href="<?=geturl('otherlogin/sina')?><?=($this->input->get('returnurl'))?"?returnurl=".urlencode($this->input->get('returnurl')):""?>"><img src="http://static.ebanhui.com/pan/images/xlwb.png"></a>
                        <a href="<?=geturl('otherlogin/wx')?><?=($this->input->get('returnurl'))?"?returnurl=".urlencode($this->input->get('returnurl')):""?>"><img src="http://static.ebanhui.com/pan/images/wx.png"></a>
                    </div>
                </div>

				<div id="mod_login_tip" class="errorLayer" style="visibility: visible; position: absolute; left: 62px; z-index: 1010; display:none;">
		            <div class="login_top"></div>
		            <div class="login_mid">
		                <div id="mod_login_close" class="tips_close">x</div>
		                <div class="conn">
		                    <p id="mod_login_title" class="bigtxt"></p>
		                </div>
		            </div>
		            <div class="login_bot"></div>
		        </div>
            </div>
		</form>
        </div>
    </div>
</div>
<div class="kshut">
	<div class="heyrty">
    	<h2 class="ksthry">热门应用</h2>
        <ul>
        	<li class="ksfets"><a href="http://intro.ebh.net"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur1.jpg" /></a></li>
            <li class="ksfets"><a href="http://pan.ebh.net/"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur4.jpg" /></a></li>
            <li class="ksfets"><a href="http://www.ebh.net/intro/app.html"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur6.jpg" /></a></li>
            <li class="ksfets"><a href="http://www.ebh.net/coupon.html"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur9.jpg" /></a></li>
        	<li class="ksfets"><a href="http://www.ebh.net/intro/livesystem.html"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur2.jpg" /></a></li>
            <li class="ksfets"><a href="http://pay.ebh.net/ipay.html"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur8.jpg" /></a></li>
        </ul>
    </div>
</div>

<script language="JavaScript">
    //定时器
	var timer ;
var BodyHeight,BodyWidth;
	var yon = 0;                    
	var xon = 0;
	var step = 1;
	var Hoffset = 0;                    
	var Woffset = 0; 
	var imgcount = 2;
	$(function(){
		timer = setInterval(function(){rotateBanner(1)},5000);
		// $(".slider_menu").hover(function(){
			// clearInterval(timer);
		// }, function(){
			// timer = setInterval(function(){rotateBanner(1)},5000);
		// });
       // BodyHeight=parseInt(document.body.clientHeight);
       // BodyWidth=parseInt(document.body.clientWidth);
            //alert(BodyWidth);
	});
	// begin:首页视觉区效果
	var _img = 1;
	function rotateBanner(step){
		_img+=step;
		if (_img>imgcount) {
			_img=1;
		} else if (_img<=0) {
			_img=imgcount;
		}
		if(_img == 2)
			$(".nowjoin").show();
		else
			$(".nowjoin").hide();
		$("#IndexBanner").stop().animate({opacity: 0},300, function(){
			$(this).css("background-image", "url(http://static.ebanhui.com/ebh/tpl/2016/images/banner"+_img+".jpg?v=20160328)").animate({opacity: 1},300);
		});
		
		$('.slide-point-box span').removeClass('cur-point');
		$('.slide-point-box span[data-index='+_img+']').addClass('cur-point');
		// $(".slider").stop().animate({backgroundPositionY: 99}, 300, function(){
			// $(this).css("background-image", "url(images/bar_0"+_img+".png)").animate({backgroundPositionY: 0}, 200);
		// });
	}
	// end
	$('.slide-point-box span').click(function(){
		rotateBanner($(this).attr('data-index')-_img);
		// $('.slide-point-box span').removeClass('cur-point');
		// $(this).addClass('cur-point');
		clearInterval(timer);
		timer = setInterval(function(){rotateBanner(1)},5000);
	});
</script>
<?php
$this->display('common/footer');
?>