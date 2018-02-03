<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>e板会后台管理系统V2.1</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/css/global.css" media="all">
		<link rel="stylesheet" href="http://static.ebanhui.com/adminv2/plugins/font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="http://static.ebanhui.com/adminv2/plugins/layui/layui.js"></script>
	</head>
	<body>
	<div class="layui-layout layui-layout-admin" style="border-bottom: solid 5px #1aa094;">
		<div class="layui-header header header-demo">
			<div class="layui-main">
				<div class="admin-login-box">
					<a class="logo" style="left: 0;" href="javascript:;">
						<span style="font-size: 22px;">EBH管理后台V2.1</span>
					</a>
					<div class="admin-side-toggle">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</div>
					<div class="admin-side-full">
						<i class="fa fa-life-bouy" aria-hidden="true"></i>
					</div>
				</div>
				<ul class="layui-nav admin-header-item">
					<li class="layui-nav-item">
						<a href="http://www.ebh.net/" target="_blank">e板会首页</a>
					</li>
					<li class="layui-nav-item">
						<a href="http://js.ebh.net/" target="_blank">结算系统</a>
					</li>
					<li class="layui-nav-item">
						<a href="http://kf.ebh.net" target="_blank">客服系统</a>
					</li>
					<li class="layui-nav-item">
						<a href="/admin.html" target="_blank">返回老版本</a>
					</li>
					<li class="layui-nav-item">
						<a href="javascript:;" class="admin-header-user">
							<span><?=$user['username']?></span>
						</a>
						<dl class="layui-nav-child">
							<dd>
								<a href="javascript:;"><i class="fa fa-user-circle" aria-hidden="true"></i> 个人信息</a>
							</dd>
							<dd>
								<a href="javascript:;"><i class="fa fa-gear" aria-hidden="true"></i> 设置</a>
							</dd>

							<dd>
								<a href="/admin.html?action=logout"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
							</dd>
						</dl>
					</li>
				</ul>
				<ul class="layui-nav admin-header-item-mobile">
					<li class="layui-nav-item">
						<a href="/admin.html?action=logout"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
					</li>
				</ul>
			</div>
		</div>