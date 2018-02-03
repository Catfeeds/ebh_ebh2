<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$roominfo['crname']?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="/static/mui/css/mui.min.css">
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="/static/mui/css/app.css"/>
		<style text/css>
			body {background:#fff;}
			.stwts {
			    height: 40px;
			    line-height: 40px;
			    border-bottom: solid 1px #eee;
			    background: #fff;
			    font-size: 15px;
			    display: block;
			    margin: 0 10px;
			}
			.rigimg {
			    float: right;
			    margin-top: 10px;
			    width: 50px;
			    height: 50px;
			    border-radius:100%;
			}
			.hesere {
				color:#999;
				float: right;
			}
			.grzxbottom {
				position: fixed;
				border-top:solid 1px #eee;
				width:100%;
				height: 40px;
				line-height: 40px;
				bottom:0px;
				text-align: center;
			}
			button.mui-btn-outlined {
				height: 39px;
				line-height: 39px;
				padding:0;
				width: 100%;
				border: none;
				color:#20A0FF;
				font-size: 16px;
			}
			.mui-popup-inner {
				padding:30px 15px;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
			<h1 class="mui-title">个人资料</h1>
		</header>
		<div class="mui-content" style="background:#fff;">
			<div class="stwts" style="height:70px;line-height: 70px;">
				头像<img class="rigimg" src="">
			</div>
			<div class="stwts">
				账号<span id="myuser" class="hesere"></span>
			</div>
			<div class="stwts">
				姓名<span id="myname" class="hesere"></span>
			</div>
			<div class="stwts">
				性别<span id="mysex" class="hesere"></span>
			</div>
			<div class="grzxbottom">
				<button id="confirmBtn" type="button" class="mui-btn mui-btn-outlined">退出登录</button>
	
			</div>
		</div>
	</body>
	<script src="http://static.ebanhui.com/wap/js/jquery/jquery-1.11.0.min.js"></script>
	<script src="/static/mui/js/mui.min.js"></script>
	<script>
		mui.init({
			swipeBack:true //启用右滑关闭功能
		});
		document.getElementById("confirmBtn").addEventListener('tap', function() {
			var btnArray = ['取消', '确定'];
			mui.confirm('', '确定退出登录？', btnArray, function(e) {
				if (e.index == 0) {
				} else {
					location.href='/logout.html'
				}
			})
		});
		$.ajax({
			type:"get",
			url:"/myroom/default/getUserInfo.html",
			async:true,
			data:{},
			dataType:"json",
			success:function(data){
				var src = data.face;
				$(".rigimg").attr("src",src);
				$("#myuser").html(data.mysign);		
				$("#myname").html(data.realname);
				if(data.sex==0){
					data.sex=('男');
				}else {
					data.sex=('女');
				}
				$("#mysex").html(data.sex);
			}
		});
	</script>
</html>