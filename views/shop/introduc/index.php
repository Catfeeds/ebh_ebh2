<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
	<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
	<?php }?>
    <title><?=$room['crname']?></title>
    <meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
    <meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/ebhtop.css<?=getv()?>" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/intro.css<?=getv()?>" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>" type="text/javascript"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
    <script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>
    
</head>
<body>
<?php $this->display('common/newheader');?>
<div class="introtop">
    <div class="nserint">
        <a class="a1" href="http://shop109884666.taobao.com/" target="_blank">购买软件</a>
        <a class="a2" href="http://www.ebh.net/createroom.html" target="_blank">创建网校</a>
    </div>
</div>
<div class="mainjs">
    <a class="ebhintro" href="http://svnlan.ebh.net/course/49220.html" target="_blank">
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu01.jpg" />
    </a>
    <div class="rishtdt">
        <h2 class="titrise">硬件+软件，集百项专利于一身</h2>
        <p class="eplsie prit">板会微课大师是浙江新盛蓝科技有限公司继e板会云教学互动平台后倾力打造的一款深受老师欢迎的微课录制工具，目前用户超过500万。</p>
        <p class="prit">她不但操作简单，而且功能强大。和传统的录屏式微课工具相比，e板会微课大师具有更多创新和实用功能，比如云端导入、同屏多素材同步录制、多ppt随意切换、教具、视频编辑等。</p>
        <p class="prit">另外她完美的融合了“传统黑板式教育”和“互联网移动技术”的优势，让老师方便的录制微课，投身数字化教育潮流。</p>
    </div>
</div>
<div class="shrite easingobj" id="easing1">
    <div class="nsireshi">
        <h2 class="titbsce">适用场景</h2>
        <div class="shrsre1">
            <div class="dilanbg"></div>
            <div class="shichasr">
                <p class="chst1">场景1</p>
                <p class="chst2">微课录制</p>
                <p class="chst3">用于微课的制作，教师可在白板、PPT、Word等各类素材上，边手写边讲解边录制，简单方便</p>
            </div>
        </div>
        <div class="shrsre2">
            <div class="dilanbg"></div>
            <div class="shichasr">
                <p class="chst1">场景2</p>
                <p class="chst2">作业分析</p>
                <p class="chst2">试卷讲解</p>
                <p class="chst3">教师可将作业、试卷导入软件，进行讲解录制。教师不需反复讲解，学生即可反复巩固</p>
            </div>
        </div>
        <div class="shrsre3">
            <div class="dilanbg"></div>
            <div class="shichasr">
                <p class="chst1">场景3</p>
                <p class="chst2">翻转课堂</p>
                <p class="chst3">教师可直接利用软件代替黑板，强大的素材库和编辑工具，方便教师在课堂上的图形绘制、公式编辑</p>
            </div>
        </div>
        <div class="shrsre4">
            <div class="dilanbg"></div>
            <div class="shichasr">
                <p class="chst1">场景4</p>
                <p class="chst2">公开课</p>
                <p class="chst3">进行大型公开课的时候，可用微课大师代替普通的PPT播放器，我们不仅具有PPT播放功能，更能随时在PPT上进行编辑，将你的想法分享并保存下来</p>
            </div>
        </div>
    </div>
</div>
<div class="skill easingobj">
    <div class="taiser">
        <h2 class="skilltit">技术参数</h2>
        <ul class="live-btn-boxs">
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu07.jpg">
                        </div>
                        <p>操作简单，使用方便</p>
                    </div>
                    <div class="backs">
                        <div>清晰的界面，实用的功能，让老师只需三个操作步骤，就可以在三分钟学会制作微课。另外它携带方便，无论是在办公室，家里还是在出差途中都可以进行操作</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu08.jpg">
                        </div>
                        <p>多种方式任意导入多种素材</p>
                    </div>
                    <div class="backs">
                        <div>素材可以通过本机导入，云端导入、截屏，插入附件等各种方式添进软件当中，所有可打印的文本、图片、音频、视频都可以通过以上各种方式一键添加</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu09.jpg">
                        </div>
                        <p>独有的云端导入技术</p>
                    </div>
                    <div class="backs">
                        <div>即使你的电脑没有安装office文件，通过e板会独有的云端导入技术也可以将你的ppt、word、pdf导入到软件中，并且ppt原有的动态效果依然呈现</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu10.jpg">
                        </div>
                        <p>多素材、同界面、同步录制</p>
                    </div>
                    <div class="backs">
                        <div>微课大师可以使word、ppt、pdf、flash、图片、视频等多种素材在同一界面任意切换并同步录制，不需要任何后期编辑</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers mrig0">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu11.jpg">
                        </div>
                        <p>支持在素材上进行图形绘制</p>
                    </div>
                    <div class="backs">
                        <div>录制微课的过程中，无论是在word,还是在ppt上面，都可以随意进行线条绘制，几何绘图，圆规作图，让微课和课堂教学一样活泼生动</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu12.jpg">
                        </div>
                        <p>黑板式教学，原笔迹手写</p>
                    </div>
                    <div class="backs">
                        <div>通过手写设备，让老师保持原有的书写习惯，并且加入毛笔、钢笔、圆珠笔、荧光笔等书写效果，保留老师原笔迹手写。让传统教学和互联网完美结合</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu13.jpg">
                        </div>
                        <p>支持双摄像头录制</p>
                    </div>
                    <div class="backs">
                        <div>摄像头和高拍仪同时接入，既能看到老师讲课的头像，同时可以将实验创作、线下试卷，课堂教学等画面接入软件并进行录制</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu14.jpg">
                        </div>
                        <p>各种绘图工具</p>
                    </div>
                    <div class="backs">
                        <div>支持各种直线、曲线，几何图形的绘制，以及多种填充方式，和多种填充颜色</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu15.jpg">
                        </div>
                        <p>海量资源库</p>
                    </div>
                    <div class="backs">
                        <div>数理化的公式、图形，实验等素材随意选择，并且支持添加自有资源库</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers mrig0">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu16.jpg">
                        </div>
                        <p>强大的视频编辑功能</p>
                    </div>
                    <div class="backs">
                        <div>支持微课后期的编辑，视频合成、切分、删除、转码，扩音等功能，让微课不留瑕疵</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu17.jpg">
                        </div>
                        <p>实用的教具功能</p>
                    </div>
                    <div class="backs">
                        <div>圆规，量角器，三角板，放大镜，幕布、时钟等实用教具功能在微课制作中都能方便调用</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu18.jpg">
                        </div>
                        <p>多背景选择</p>
                    </div>
                    <div class="backs">
                        <div>支持空白页，米字格、田字格、作文格，五线谱、坐标纸、笔记本等背景选择，也可以自定义背景</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu19.jpg">
                        </div>
                        <p>高压缩通用的视频格式</p>
                    </div>
                    <div class="backs">
                        <div>微课大师录制的视频格式为flv格式，视频清晰，容量小，并且所有网站通用</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu20.jpg">
                        </div>
                        <p>公式编辑器功能</p>
                    </div>
                    <div class="backs">
                        <div>软件集成e板会公式编辑器，可以输入各种公式、特殊符号等</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers mrig0 yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu21.jpg">
                        </div>
                        <p>屏幕录制</p>
                    </div>
                    <div class="backs">
                        <div>支持自定义屏幕区域录制，并且进行各种标注，书写</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu22.jpg">
                        </div>
                        <p style="margin:0;line-height:1.2;">多种截图方式及屏幕内<br />图片复制</p>
                    </div>
                    <div class="backs">
                        <div>可进行当前屏幕截图，隐藏当前屏幕截图，规则截图，不规则截图，截图透明化等操作，也可以在画布内任意文档和图片上进行图片复制和粘贴</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu23.jpg">
                        </div>
                        <p>终身在线升级</p>
                    </div>
                    <div class="backs">
                        <div>微课大师追求完美，不但会对原有的各种功能不断进行升级，另外我们还会添加各种强大功能，只要在联网状态下，我们的新版本对所有用户都会实时更新</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu24.jpg">
                        </div>
                        <p>手绘板硬件</p>
                    </div>
                    <div class="backs">
                        <div>2048级微感压，12毫米感知高度，每秒220字节读取速度，整体采用EPE高耐磨材料并进行太空纳米压制，让您的书写更加流畅，体验更细腻</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu25.jpg">
                        </div>
                        <p>双无线设计，内置存储</p>
                    </div>
                    <div class="backs">
                        <div>双无线设计，让用户在15米范围内都可以进行无线书写。为了让用户能更方便保存微课，软件内置8g大容量存储，随录随存，不怕文件丢失</div>
                    </div>
                </div>
            </li>
            <li class="flip-containers mrig0 yuanchi">
                <div class="flippers" href="#">
                    <div class="fronts">
                        <div class="btn-pics">
                            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu26.jpg">
                        </div>
                        <p>系统支持</p>
                    </div>
                    <div class="backs">
                        <div>兼容winxp、win7、win8、win10</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>    
</div>
<div class="waisre easingobj" style="height:700px;">
    <h2 class="skilltit">功能简介</h2>
	<ul>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45645.html" target="_blank" title="录制微课的简单操作步骤（一分钟学会做微课）" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys01.jpg">
				</div>
				<div class="shichangs">录制微课的简单操作步骤（一分钟学会做微课）</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45632.html" target="_blank" title="如何安装微课大师" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys02.jpg">
				</div>
				<div class="shichangs">如何安装微课大师</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45633.html" target="_blank" title="导入ppt的两种方式" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys03.jpg?v=01">
				</div>
				<div class="shichangs">导入ppt的两种方式</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45634.html" target="_blank" title="Word的导入" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys04.jpg?v=01">
				</div>
				<div class="shichangs">导入word的两种方式</div>
			</a>
		</li>
		<li class="flsries rihg0">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45635.html" target="_blank" title="多块白板的录制" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys05.jpg">
				</div>
				<div class="shichangs">多块白板的录制</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/76136.html" target="_blank" title="多素材同屏互动式微课录制" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys14.jpg?v=01">
				</div>
				<div class="shichangs">多素材同屏互动式微课录制</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/76137.html" target="_blank" title="教具功能" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys15.jpg?v=01">
				</div>
				<div class="shichangs">教具功能</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45636.html" target="_blank" title="录制微课时区域的布局" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys06.jpg">
				</div>
				<div class="shichangs">录制微课时区域的布局</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45637.html" target="_blank" title="如何把其他视频录入自己的微课" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys07.jpg">
				</div>
				<div class="shichangs">如何把其他视频录入自己的微课</div>
			</a>
		</li>
		<li class="flsries rihg0">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45638.html" target="_blank" title="笔、背景、截图和图层" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys08.jpg">
				</div>
				<div class="shichangs">笔、背景、截图和图层</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45639.html" target="_blank" title="删除微课当中的某一片段" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys09.jpg">
				</div>
				<div class="shichangs">删除微课当中的某一片段</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45640.html" target="_blank" title="切分一个课件" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys10.jpg">
				</div>
				<div class="shichangs">切分一个课件</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45641.html" target="_blank" title="如何合并课件" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys11.jpg">
				</div>
				<div class="shichangs">如何合并课件</div>
			</a>
		</li>
		<li class="flsries">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45642.html" target="_blank" title="对微课扩音" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys12.jpg">
				</div>
				<div class="shichangs">对微课扩音</div>
			</a>
		</li>
		<li class="flsries rihg0">
			<a class="ysirns" href="http://svnlan.ebh.net/course/45643.html" target="_blank" title="对微课进行格式转换" >
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png">
			</a>																																															
			<a class="openss" href="javascript:;" target="_blank">
				<div class="waksrtss">
					<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebhsys13.jpg">
				</div>
				<div class="shichangs">对微课进行格式转换</div>
			</a>
		</li>
	</ul>
</div>
<div class="waisre easingobj">
    <h2 class="skilltit">微课案例</h2>
    <ul>
        <?php if(!empty($cwinfo)){ ?>
            <?php $i = 0; ?>
        <?php foreach ($cwinfo as $cw) { $i++; ?>
        <li class="flsrie <?php if($i%4 == 0){echo 'rihg0';} ?>">
        <?php 
            $cw['url'] = empty($cw['url'])?'':$cw['url'];
            $cw['logo'] = empty($cw['logo'])?'http://static.ebanhui.com/ebh/tpl/ebh2/images/intro-tu27.jpg':$cw['logo'];
            $cw['title'] = empty($cw['title'])?'':$cw['title'];
        ?>
        <a class="ysirn" href="<?php echo $cw['url'];?>" target="_blank" title="<?php echo $cw['title'];?>"s><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png"></a>
            <a class="opens" href="javascript:;" target="_blank">            
                <div class="waksrts"><img src="<?php echo $cw['logo'];?>" ></div>
                <div class="shichang" ><?php echo $cw['title'];?></div>
            </a>
        </li>
        <?php } ?>
        <?php } ?>
    </ul>
</div>
<div class="zhusre easingobj">
    <div class="cnasrse">
        <h2 class="zhusertit">专利证书</h2>
        <div class="nhusrse1"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/certificate1.jpg?v=01" /></div>
        <div class="nhusrse2"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/certificate2.jpg?v=01" /></div>
        <div class="nhusrse3"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/certificate3.jpg?v=01" /></div>
        <div class="nhusrse4"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/certificate4.jpg?v=01" /></div>
        <div class="nhusrse5"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/certificate5.jpg?v=01" /></div>
    </div>
</div>
<div class="falsrfe">
    <div class="ebhcode"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/code.png" /><span>微信公众号“e板会”</span></div>
    <div class="ebhapp"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/code1.png" /><span>“e板会”-APP</span></div>
    <div class="srzrder">
        <ul>
            <li class="lsrret">浙江省杭州市江干区钱江新城五星路188号荣安大厦25F</li>
            <li class="ewtser">0571-87757303</li>
            <li class="reyrde">
                <a target="_blank" href="<?=geturl('about')?>">关于</a>&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="<?=geturl('conour')?>">业务联系</a>
            </li>
        </ul>
    </div>
    <div class="fldty">
        <div style="text-align:center">
            <span style="color:#555">
            <i></i>
            浙公网安备 33010602003467号
            </span>
            <a href="http://www.miibeian.gov.cn/" target="_blank" style="color:#555">浙B2-20160787</a>
            <span style="color:#555">Copyright © 2011-<?=date('Y')?> ebh.net All Rights Reserved </span>
            <br>
        </div>
    </div>
</div>


<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
<!-- 统计代码结束 -->
</body>
</html>
