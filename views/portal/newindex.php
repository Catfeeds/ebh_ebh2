<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
    <title><?=!empty($seoInfo['title'])?$seoInfo['title']:(!empty($title)?$title:$this->get_title())?></title>
    <meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
    <meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/ebhnew.css<?=getv()?>" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>" type="text/javascript"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
</head>
</script>
<body>
<!--系统更新提示>
<div style="background:#ff8800;font-size:14px;color:#fff;z-index: 10;height:30px;line-height:30px;width:100%;text-align:center;font-family: Microsoft Yahei;"><img style="vertical-align: text-bottom;" src="http://static.ebanhui.com/ebh/tpl/2016/images/zhuyi01.jpg" />亲爱的用户：为了给您提供更优质的服务，系统将于06月28号22点30分进行升级，期间可能会出现服务中断情况，敬请谅解！</div><!-->
		<div id="video">
			<a class="tiaoto" href="#top"></a>
		</div>
		<div class="header easingobj">
	        <div class="head">
	            <ul class="nav">
	                <li><a style="color: #cfdee1;" href="http://ebhdemo.ebh.net" target="_blank">演示网校</a></li>
	                <li><a style="color: #cfdee1;" onfocus="this.blur();" href="http://www.ebh.net/createroom.html" target="_blank">免费创建网校</a></li>
	                <li>
	                	<a style="color: #cfdee1;" href="javascript:void(0)">产品介绍</a>
	                	<div class="box">
                        	<a onfocus="this.blur();" class="menu_item" href="http://www.ebh.net/intro/livesystem.html" target="_blank">
					在线直播
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/?p=1" target="_blank">
					在线录播
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/?p=2" target="_blank">
					微课工具
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/interaction.html" target="_blank">
					互动课堂
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/homework.html" target="_blank">
					作业系统
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/interactquer.html" target="_blank">
					互动答疑
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/connection.html" target="_blank">
					微校讯通
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/cloud.html" target="_blank">
					网校云盘
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/community.html" target="_blank">
					社区圈子
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/schoolshop.html" target="_blank">
					网校商城
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://www.ebh.net/intro/app.html" target="_blank">
					APP应用
					<span></span>
				</a>
                   		</div>
	                </li>
	                <li><a style="color: #cfdee1;" onfocus="this.blur();" href="http://www.ebh.net/conour.html" target="_blank">服务报价</a></li>
	                <li><a style="color: #cfdee1;" href="#bottom">渠道招商</a></li>
	            </ul>
	            <ul class="signIn">
					<li class="search">
						<input class="search" name="textarea" x_hit="搜索网校" type="text" style="color:#cfdee1;" id="searchfm" value="<?= !empty($q)?$q:'' ?>" />
						<a class="seaicon" href="javascript:;" onclick="dosearch()"> </a>
							<form action="#" method="get" id="searchhide" target="_blank" style="display:none;">
								<input id="q" type="hidden" name="q" value="<?= !empty($q)?$q:'' ?>" />
							</form>
					</li>
					<?php if(empty($user)){?>
					<li class="login"><a class="rsizer" href="javascript:void(0);" onclick="_login()"><i class="humserr"></i>登录</a></li>
					<li><a class="rsizer" target="_blank"  href="/register.html">注册</a></li>
					<?php }else{ ?>
						<?php $homeurl = geturl('homev2');?>
							<li class="login"><a class="rsizer"  target="_blank" href="<?=$homeurl?>"><i class="humserr"></i><?= substr($user['username'],0,12	)?></a></li>
							<li style="margin-right:0px;"><a class="rsizer" href="<?=geturl('logout')?>">退出</a></li>
					<?php }?>
				</ul>
	        </div>
	        <div class="banner">
	        	<a onfocus="this.blur();" href="http://www.ebh.net/createroom.html" target="_blank">
	            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_fude01.png?v=02" class="b1">
	            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_fude02.png?v=02" class="b2">
	            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_fude03.png?v=02" class="b3">
	            </a>
	            <h1 class="h1title">e 板会 SaaS 云为您提供一站式技术保障</h1>
	            <p class="desc1">在这里您可以快速搭建属于自己的个性化网络学校</p>
	            <p class="desc2">一所网络学校不只是播放视频</p>
	            <a class="gocreate" onfocus="this.blur();" href="http://www.ebh.net/createroom.html" target="_blank">免费创建网校</a>
				<a class="gocreates" onfocus="this.blur();" href="http://ebhdemo.ebh.net/course/196819.html" target="_blank">视频了解下</a>
	        </div>
	        <div class="bottom">
	            <ul class="item">
	                <li>
	                    <div class="con">
	                        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_toptu01.png" >
							<p class="tit"><span class="timer" id="count-number" data-to="10" data-speed="800"></span> 年 +</p>
	                        <p class="ds">深耕教育培训行业</p>
	                    </div>
	                    <span class="bor"></span>
	                </li>
	                <li>
	                    <div class="con">
	                        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_toptu02.png" >
	                        <p class="tit"><span class="timer" id="count-number" data-to="1000000" data-speed="5800"></span>+</p>
	                        <p class="ds">视频内容</p>
	                    </div>
	                    <span class="bor"></span>
	                </li>
	                <li>
	                    <div class="con">
	                        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_toptu03.png" >	                        
	                        <p class="tit"><span class="timer" id="count-number" data-to="30000000" data-speed="8200"></span>+</p>
	                        <p class="ds">平台用户</p>
	                    </div>
	                    <span class="bor"></span>
	                </li>
	                <li>
	                    <div class="con">
	                        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_toptu04.png" >
	                        <p class="tit"><span class="timer" id="count-number" data-to="30000" data-speed="3200"></span>+</p>
	                        <p class="ds">网络学校</p>
	                    </div>
	                    <span class="bor"></span>
	                </li>
	                <li>
	                    <div class="con">
	                        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_toptu05.png" >	                        
	                        <p class="tit"><span class="timer" id="count-number" data-to="200" data-speed="1500"></span>+</p>
	                        <p class="ds">技术研发团队</p>
	                    </div>
	                </li>
	            </ul>            
	        </div>
	    </div>
	    
		<div class="inner easingobj height600">
			<h2 class="titlese">没有技术团队也能拥有自己独立的网校平台</h2>
			<p class="ptd">致力于为个人，培训机构，政府，企业单位和学校提供一站式“互联网+教育”服务</p>
			<div class="lefyi">
				<div class="lisborder">
					<img class="threeimgs" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_rmend01.png" />
					<h3 class="listit">节省资金投入</h3>
					<p class="listxt">无需研发资金投入，无需组建研发团，<br>e板会帮您节省百万元研发费用</p>
				</div>
				<div class="lisborder">
					<img class="threeimgs" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_rmend03.png" />
					<h3 class="listit">节约时间成本</h3>
					<p class="listxt">无需半年以上研发时间，即刻布局在线<br>交易市场，抢占市场先机</p>
				</div>
			</div>
			<div class="rigyi">
				<div class="lisborder">
					<img class="threeimgs" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_rmend02.png" />
					<h3 class="listit">无需硬件设备</h3>
					<p class="listxt">无需购买服务器，机柜，机房，带宽，<br>帮您每年节省几十万</p>
				</div>
				<div class="lisborder">
					<img class="threeimgs" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_rmend04.png" />
					<h3 class="listit">终身免费升级</h3>
					<p class="listxt">用户体验和系统功能每周迭代更新，<br>专业团队24小时全方位服务</p>
				</div>
			</div>
		</div>
		<div class="inner easingobj height600">
			<h2 class="titgest">个性化品牌网校</h2>
			<p class="tdgest">配套完善的教学运营体系</p>
			<div class="gest">
				<div class="gestdiv">
					<img class="gestimg1" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding01.png" />
					<h3 class="gesth3">自主品牌和域名</h3>
					<p class="gestpl">创建一所个性化网络学校</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg2" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding02.png" />
					<h3 class="gesth3">个性化网校</h3>
					<p class="gestpl">主页、教学模块自定义</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg3" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding03.png" />
					<h3 class="gesth3">API/SDK/微信/APP</h3>
					<p class="gestpl">多终端支持二次开发</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg4" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding04.png" />
					<h3 class="gesth3">完善的支付/结算系统</h3>
					<p class="gestpl">订单交易系统实时结算</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg5" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding05.png" />
					<h3 class="gesth3">教务管理系统</h3>
					<p class="gestpl">课程、用户行为数据分析</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg6" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding06.png" />
					<h3 class="gesth3">强大的教学系统</h3>
					<p class="gestpl">提供专业的直播、录播工具</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg7" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding07.png" />
					<h3 class="gesth3">数百个教学模块</h3>
					<p class="gestpl">云盘、商城、社区、家校通</p>
				</div>
				<div class="gestdiv">
					<img class="gestimg8" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ding08.png" />
					<h3 class="gesth3">强大的云计算系统</h3>
					<p class="gestpl">秒播、万人直播、转码中心</p>
				</div>
			</div>
		</div>
		<div class="inner easingobj height850">
			<h2 class="titlese">强大的SaaS云技术平台</h2>
			<p class="ptd">通过互联网服务共享知识，让学习变得更简单</p>
			<img class="yunpt01" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg02.png" />
			<img class="yunpt02" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg03.png" />
			<img class="yunpt03" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg04.png" />
		</div>
		<div class="inner easingobj height600">
			<img class="wapyun" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg05.png" />
			<img class="rigfu1" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_wapx01.png" />
			<img class="rigfu2" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_wapx02.png" />
			<img class="rigfu3" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_wapx03.png" />
			<img class="rigfu4" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_wapx04.png" />
		</div>
		<div class="inner easingobj height560">
			<h2 class="titlese">平台连接人与人</h2>
			<p class="ptd">让技术和心理意识产生互动</p>
			<div class="bekes">
				<div class="sijers bek01">
					<h3 class="sijeh3">赞赏</h3>
					<p class="hisjepl">发个红包为辛苦</p>
					<p class="hisjepl">付出的老师表示</p>
					<p class="hisjepl">感谢</p>
				</div>
				<div class="sijers bek02">
					<h3 class="sijeh3">结算</h3>
					<p class="hisjepl">实时结算让合作</p>
					<p class="hisjepl">更加诚信更加</p>
					<p class="hisjepl">紧密</p>
				</div>
				<div class="sijers bek03">
					<h3 class="sijeh3">利益</h3>
					<p class="hisjepl">驱动一切参与者</p>
					<p class="hisjepl">得到他应该得到的</p>
				</div>
				<div class="sijers bek04">
					<h3 class="sijeh3">社交</h3>
					<p class="hisjepl">边学习边聊天</p>
					<p class="hisjepl">探讨没懂的</p>
					<p class="hisjepl">问题</p>
				</div>
				<div class="sijers bek05">
					<h3 class="sijeh3">交易</h3>
					<p class="hisjepl">你我他的商品</p>
					<p class="hisjepl">都可以互相买卖</p>
				</div>
				<div class="sijers bek06">
					<h3 class="sijeh3">服务</h3>
					<p class="hisjepl">发挥网校内5%</p>
					<p class="hisjepl">的学员服务更多</p>
					<p class="hisjepl">学员</p>
				</div>
				<div class="sijers bek07">
					<h3 class="sijeh3">消息</h3>
					<p class="hisjepl">最快的速度通知</p>
					<p class="hisjepl">他你的存在</p>
				</div>
				<div class="sijers bek08">
					<h3 class="sijeh3">优惠码</h3>
					<p class="hisjepl">分享得奖金</p>
					<p class="hisjepl">他好你也好</p>
				</div>
				<div class="sijers bek09">
					<h3 class="sijeh3">存储</h3>
					<p class="hisjepl">把最好的学习资料</p>
					<p class="hisjepl">扔进加密的云盘</p>
				</div>
				<div class="sijers bek10">
					<h3 class="sijeh3">大数据</h3>
					<p class="hisjepl">记录我的行为让</p>
					<p class="hisjepl">老师与自己更加</p>
					<p class="hisjepl">了解我</p>
				</div>
				<div class="sijers bek11">
					<h3 class="sijeh3">第三方</h3>
					<p class="hisjepl">如有需要也可以</p>
					<p class="hisjepl">监管正在学习的他</p>
				</div>
				<div class="sijers bek12">
					<h3 class="sijeh3">资料</h3>
					<p class="hisjepl">强大的转码技术让</p>
					<p class="hisjepl">页面上可以播ppt</p>
					<p class="hisjepl">看word</p>
				</div>
			</div>
		</div>
		<div class="inner easingobj height560">
			<h2 class="titlese">多终端无缝覆盖，用户在任意场景中自由切换</h2>
			<p class="ptd">多终端自由切换，学员任意选择学习方式，同一个域名实现跨平台自适应</p>
			<div class="dehelef">
				<div class="dehediv cut01">
					<img class="sehoverimg" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_cut01s.jpg" />
					<h3 class="deheh3">完善的PC网校</h3>
					<p class="dehepl">直接网页版打开，强大功能+极强的稳定性</p>
				</div>
				<div class="dehediv cut02">
					<img class="sehoverimg" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_cut02s.jpg" />
					<h3 class="deheh3">手机移动版网校</h3>
					<p class="dehepl">课程营销、在线授课、费用支付全流搞定</p>
				</div>
				<div class="dehediv cut03">
					<img class="sehoverimg" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_cut03s.jpg" />
					<h3 class="deheh3">微信平台网校</h3>
					<p class="dehepl">绑定企业微信公众号，学员随时随地轻松学习</p>
				</div>
				<div class="dehediv cut04">
					<img class="sehoverimg" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_cut04s.jpg" />
					<h3 class="deheh3">APP应用网校</h3>
					<p class="dehepl">实现碎片化网络学习，作业、测试、互动讨论</p>
				</div>
			</div>
			<img class="deheimg" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg06.png" />
		</div>
		
		<div class="inner easingobj height850">
			<h2 class="titlese">互联网+教育，势在必行</h2>
			<p class="ptd">构建网络化、数字化、个性化、终身化教育体系</p>
			<img class="wansimg rotate" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg07.png" />
		</div>
		<div class="footer easingobj height680">
			<div class="footer_top">
				<p class="h3">自主知识产权</p>
				<p class="h5">深耕八年专注在线教育，所有产品自主研发，拥有上百项的自主专利。</p>
			</div>
			<div class="zhengshu">
				<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_bg08.png" />
				<a class="botbtn" onfocus="this.blur();" href="http://www.ebh.net/createroom.html" target="_blank">免费创建网校</a>
			</div>
		</div>
		<div class="inner easingobj height600">
			<h2 class="titlese" style="margin-top: 50px;">合作政策</h2>
			<p class="ptd">通过互联网服务共享知识，让学习变得更简单，实现合作共赢</p>
			<div class="flip-containers">
				<div class="flippers">
					<div class="fronts">
						<p>合作条件</p>
						<div class="btn-pics">
							<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_cbo01.png">
						</div>
					</div>
					<div class="backs">
						<div><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_cbo04.png"/></div>
					</div>
				</div>
			</div>
			<div class="flip-containers">
				<div class="flippers">
					<div class="fronts">
						<p>合作方式</p>
						<div class="btn-pics">
							<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_cbo02.png">
						</div>
					</div>
					<div class="backs">
						<div><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_cbo05.png"/></div>
					</div>
				</div>
			</div>
			<div class="flip-containers mrig0">
				<div class="flippers">
					<div class="fronts">
						<p>合作支持</p>
						<div class="btn-pics">
							<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_cbo03.png">
						</div>
					</div>
					<div class="backs">
						<div><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_cbo06.png"/></div>
					</div>
				</div>
			</div>
			<div class="fobot">
				<span class="mar65">陈老师：13957170417</span>庞老师：13309021978</div>
		</div>
		<div class="foters" id="bottom">
			<div class="inner">
				<div class="fotzy" style="margin-left: 200px;">
					<p>e板会“APP”</p>
					<a class="aliwap" onfocus="this.blur();" target="_blank" href="https://itunes.apple.com/cn/app/id1234127044?mt=8"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_iphone.png"/></a>
					<a class="aliwap" onfocus="this.blur();" href="http://soft.ebh.net/ebanhuipad.apk"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_android.png"/></a>
					<a class="aliwap" onfocus="this.blur();" target="_blank" href="https://itunes.apple.com/cn/app/id1247086974?mt=8"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_ipad.png"/></a>
					<a class="aliwap" onfocus="this.blur();" href="http://soft.ebh.net/ebh_tv.apk"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_dianshi.png"/></a>
					<a class="aliwap" onfocus="this.blur();" href="http://soft.ebh.net/ebhbrowser.zip"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_liulan.png"/></a>
				</div>
				<div class="fotzy">
					<div class="weidiv">
						<p>网校登录</p>
						<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_wlog.png" />
					</div>
					<div class="weidiv">
						<p>微信公众号</p>
						<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh4_wx.png" />
					</div>
				</div>
				<div class="fotser">
					<p class="icon-address">浙江省杭州市江干区钱江新城五星路188号荣安中心大厦25F</p>
					<p class="icon-phone">0571-87757303</p>
					<p class="icon-about"><a target="_blank" style="color:#a4a9aa;" href="http://www.ebh.net/about.html">关于我们</a></p>
					<p style="padding: 0;"><a target="_blank" style="color:#a4a9aa;" href="http://ebhdemo.ebh.net/course/196819.html">宣传视频</a></p>
				</div>
				<div class="clear"></div>
				<div style="text-align:center;margin-top:20px">
		            <span style="color:#a4a9aa">
		            <i></i>
		           	 浙公网安备 33010602003467号
		            </span>
		            <a href="http://www.miibeian.gov.cn/" target="_blank" style="color:#a4a9aa">浙B2-20160787</a>
		            <span style="color:#a4a9aa">Copyright © 2011-<?=date('Y')?> ebh.net All Rights Reserved </span>
		            <br>
		        </div>
			</div>
		</div>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
<!-- 统计代码结束 -->
</body>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/ebh2/js/indexs.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/ebh2/js/slick.min.js"></script>
<script type="text/javascript">

    $(function(){
        $.each($('.easingobj'),function(k,v){
            if($(window).height() - ($(this).offset().top-$(window).scrollTop()) > 150)
                $(this).addClass("easing");
        })
    });
    window.onscroll = function(){
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        var top_div = document.getElementById( "video" );
		if( t >= 30 ) {
		$("#video").addClass("video-float")
    } else {
		$("#video").removeClass("video-float")
		$("#videotemp").attr('id','video');
    }
        $.each($('.easingobj'),function(k,v){
            if($(window).height() - ($(this).offset().top-$(window).scrollTop()) > 150)
                $(this).addClass("easing");
        })
    }
function closew(){
	$("#video").removeClass("video-float");
	$("#video").attr('id','videotemp');
}     
    var timer;
    $(function(){
        xForm.hit($("#searchfm"));
        $(".askter h2").attr({style:"cursor:pointer;"});
        $("div.askter").bind('mouseleave',function(){
            $(".askter").slideUp();
        }).bind('mouseover',function(){
            clearTimeout(timer);
        });
        $("#searchfm").bind('keypress',function(e){
            if(e.which == 13){
                dosearch();
            }
        });
    });
    //搜索
    function dosearch(){
        var $search = $("#searchfm");
        $search.val($.trim($search.val()));
        var q = $search.val();
        if(q == $search.attr('x_hit')){
            q = "";
        }
        if(q == ""){
            alert("请输入关键字");
            return;
        }
        $("#q").val(q);
        var url = "/searchs.html";
        xredirect(url);
    }
    function xredirect(url){
        $("#searchhide").attr("action",url);
        $("#searchhide").submit();
    }
    //登录
    function _login(){
        tologin('/login.html?returnurl=__url__');
    }
$(function () {
	var href = location.href;
	if(href=="http://intro.ebh.net/")
		$(".links a:[href='"+href+"?p=1']").addClass("onhover");
});
	//头部动态背景
    $('.banner').mousemove(function(e) {
        var xx = e.offsetX || e.layerX || 0,
            yy = e.offsetY || e.layerY || 0,
            tx1 = (parseInt(xx-600)/130),
            ty1 = (parseInt(yy-237)/130); 
            tx2 = (parseInt(xx-600)/50),
            ty2 = (parseInt(yy-237)/50); 
            tx3 = (parseInt(xx-600)/50),
            ty3 = (parseInt(yy-237)/50); 

		$(".banner .b1").css({
			'transform': 'translate3d('+tx1+'px, '+ty1+'px, 0px)', 
			'transform-style': 'preserve-3d',
			'backface-visibility': 'hidden'
		});
		$(".banner .b2").css({
			'transform': 'translate3d('+tx2+'px, '+ty2+'px, 0px)', 
			'transform-style': 'preserve-3d',
			'backface-visibility': 'hidden'
			});
		$(".banner .b3").css({
			'transform': 'translate3d('+tx3+'px, '+ty3+'px, 0px)', 
			'transform-style': 'preserve-3d',
			'backface-visibility': 'hidden'
			});
    })
	</script>
</html>
