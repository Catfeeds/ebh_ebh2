<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>浏览器不兼容</title>
	<style>
		*{
			margin: 0;padding: 0;
		}
		body,html{
			width: 100%;
			height: 100%;
		}
		.content{
			width: 100%;
			height: 100%;
			background: url(http://static.ebanhui.com/ebh/tpl/newschoolindex/images/nocompatible.png) no-repeat center center;
		}
		.content img{
			border: 0 none;
		}
		.googleBox,.firefoxBox,.e360Box{
			display: block;
			text-decoration: none;
			width: 128px;
			height: 150px;
			position: absolute;
			top: 50%;
		}
		.e360Box{
			left: 30%;
		}
		.googleBox{
			left: 46%;
		}
		.firefoxBox{
			left: 62%;
		}
		.googleBox p, .firefoxBox p, .e360Box p{
			margin: 0;
			widows: 128px;
			text-align: center;
			font-family: "microsoft yahei";
			font-size: 16px;
			color: #999;
		}
	</style>
</head>
<body>
	<div class="content">
		<a href="http://chrome.360.cn/" class="e360Box">
			<img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/e360.png" alt="" />
			<p>360浏览器</p>
		</a>
		<a href="http://rj.baidu.com/soft/detail/14744.html?ald" class="googleBox">
			<img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/google.png" alt="" />
			<p>谷歌浏览器</p>
		</a>
		<a href="http://www.firefox.com.cn/" class="firefoxBox">
			<img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/firefox.png" alt="" />
			<p>火狐浏览器</p>
		</a>
	</div>
</body>

</html>