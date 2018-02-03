<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/fssqcs.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.head-logo,.head-logo a ,.current-city,.cservice img,.cbuyclass,.head-logo-text,.primg,.header-area span,.bottom');   
</script>  
<![endif]-->
</head>

<body>
<?php $this->display('common/public_header'); ?>
<div class="long">
<div class="main">
<div class="ptral">
<p>周易文化是我国劳动人民几千年的文化结晶，也是民族文化的灿烂瑰宝，研究周易是世界各国所共有的文化现象，既反映了人类对神秘阴阳五行的求知心理，也反映周易文化的神秘和博大精深。周易的精髓是阴阳、五行。大到天体，小到人体及周围环境，处处存在易学的理念。周易反映的是自然现象和客观规律，她告诫人们：顺其则生，逆其则亡。所以我们在尊重自然环境的同时，也明白一个道理：环境可以改变一个人，环境可以创造一个人。</p>
<p>风生水起是从简单的阴阳五行入手，教大家基本的周易理学和基础的应用，并可根据学员的需求，提供包括个人命理、个人运程、居家风水、公司布置、建筑环境规划、楼盘园林设计等一系列个性化服务。</p>
<h2><img src="http://static.ebanhui.com/ebh/tpl/2012/images/titsite0831.jpg" /></h2>
<ul><?php $url='http://'.$room['domain'].'.ebanhui.com'?>
<li class="email">邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="phone">电话：<?= $room['crphone']?></li>
<li class="qq">Q&nbsp; Q：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes"><?= $room['crqq']?></a></li>
<li class="uil">网址：<a title="<?= $room['crname']?>" href="<?= $url?>"><?= $url?></a></li>
<li class="site">地址：<?= $room['craddress']?></li>
</ul>
<div class="fstu"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/fstu10831.jpg" /><img src="http://static.ebanhui.com/ebh/tpl/2012/images/fstu10832.jpg" /></div>
</div>
<div class="tearal">
<h2><img src="http://static.ebanhui.com/ebh/tpl/2012/images/titintro0831.jpg" /></h2>
<ul>
<li>
<div class="leftea">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/fstu030831.jpg" />
</div>
<div class="rigtea">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/jsname10831.jpg" />
<p>祖籍山东，师从祖上，学习于山东大学周易研究中心，遍及全国十几个省市，兼顾理论与实践，在阴阳五行、人居风水、预测学、姓名学等方面，有独到的见解和实用经验。</p>
</div>
</li>
<li>
<div class="leftea">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/fstu040831.jpg" />
</div>
<div class="rigtea">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/jsname20831.jpg" />
<p>杭州申庚环境科技有限公司是以申庚老师命名的一家专业从事建筑规划、环境规划的服务咨询公司。公司本着以易学的理念为指导思想，用科学的方式合理布局。从建筑、环境风水规划，楼盘、园林风水设计，到公司、居家的风水布局、调整等。</p>
</div>
</li>
</ul>
</div>
<div class="audition">
<ul>

					<?php foreach($folderlist as $key=>$val){ ?>
						<?php if($key<4){ ?>
<li>
<a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);" class="imgbg"><img width="190" height="190" src="<?= getThumb($val['logo'],'190_190','http://static.ebanhui.com/ebh/tpl/default/images/default.jpg')?>" /></a>
<h2><a href="javascript:freeplay('<?= $val['cwsource']?>','<?= $val['cwid']?>','<?= str_replace("'"," ",$val['title'])?>',1);" title="<?= $val['title']?>"><?= shortstr($val['title'],22)?></a></h2>
<p><?= shortstr($val['summary'],85)?></p>
</li>
<?php unset($folderlist[$key ]);?>
						<?php } ?>
					<?php } ?>
</ul>
</div>	
<div class="rough">
<ul>
<li><a href="http://fssq1.ebanhui.com/" class="imgrough" title="找到自己文昌位，提升学习进程">
<h2 class="ctitle1"></h2>
<div class="lefrou ci1"></div>
<div class="rigrou">
<h3>价格：<span>2000元</span></h3>
<p>介绍：文昌星主管我们的学习成绩、事业发展趋势。每个人的出生时间、性别、居住环境不同，有不同的文昌位，本课申庚老师要教大家
找准自己文昌位。</p>
</div>
</a></li>
<li><a href="http://fssq2.ebanhui.com/" class="imgrough" title="调整文昌位(开窍先天不足，后天补齐)">
<h2 class="ctitle2"></h2>
<div class="lefrou ci2"></div>
<div class="rigrou">
<h3>价格：<span>2000元</span></h3>
<p>介绍：文昌星对孩子的学习成绩有直接影响，怎么样解决先天不足，后天调整？本课申庚老师要教大家调整文昌位的环境，提升学习能力
，提高工作能力！</p>
</div>
</a></li>
<li><a href="http://fssq3.ebanhui.com/" class="imgrough" title="选择适合户型，人宅相合万事兴">
<h2 class="ctitle3"></h2>
<div class="lefrou ci3"></div>
<div class="rigrou">
<h3>价格：<span>600元</span></h3>
<p>介绍：居住环境对人有至关重要的影响，人与宅相生相合，就能工作顺利、心情舒畅，反之亦然。本课申庚老师要教大家如何选择合适的
住宅。</p>
</div>
</a></li>
<li><a href="http://fssq4.ebanhui.com/" class="imgrough" title="2013正月初一开财运门的方法">
<h2 class="ctitle4"></h2>
<div class="lefrou ci4"></div>
<div class="rigrou">
<h3>价格：<span>10000元</span></h3>
<p>介绍：正月初一是一年之始，这天出门第一件事、第一句话、第一个东西，都关乎一年的整体运势。申庚老师根据师门秘学，首次推出
2013正月初一的开财运门方法。</p>
</div>
</a></li>
<li><a href="http://fssq5.ebanhui.com/" class="imgrough" title="进考场带什么东西能增加分数">
<h2 class="ctitle5"></h2>
<div class="lefrou ci5"></div>
<div class="rigrou">
<h3>价格：<span>2000元</span></h3>
<p>介绍：进考场时候带点小东西，也能给你增加分数？这就是周易的神奇之处！申庚老师传承师门秘学，结合流年运程，传授学生考场的必
带物品！</p></div></a>
</li>
<li><a href="http://fssq6.ebanhui.com/" class="imgrough" title="了解孩子五行，正确引导孩子发展">
<h2 class="ctitle6"></h2>
<div class="lefrou ci6"></div>
<div class="rigrou">
<h3>价格：<span>2000元</span></h3>
<p>介绍：每个人出生时间不同，五行不同，性格、喜好也会不一样。了解孩子五行，因势利导，才能让孩子健康成长，本课申庚老师要教大家看孩子的五行属性！</p>
</div>
</a></li>
</div>
<div class="message">
<div class="waiku">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/zytu10831.jpg" />
<h2><img src="http://static.ebanhui.com/ebh/tpl/2012/images/titmessage0831.jpg" /></h2>
<p>风水是人类居住的地理环境和来风来水，去风去水组成的方位时空给人类居住造成的吉凶祸福信息。风水包含了宇宙空间人文地理的综合因素。阴阳风水是我们中华民族几千年来积淀的传统文化，是我们祖先创造出的现实与精神和谐的方法和经验。它利用哲学的观念，将宇宙气场动和静的阴阳天人合一等等思维方式与建筑环境结合在一起，形成一门人类与自然和谐统一的科学理论。阴阳风水文化形成于五千年以前，延续至今，它依然焕发出辉煌灿烂的光芒，而且得到世界多个国家崇拜。它是我们中华民族的智慧，也是我们中华民族的骄傲。它是有科学性和实用性的，它属于宇宙空间自然科学。根据形体峦头水法和理气，一个好的风水气场，能使一个企业、团体，一个家庭和谐昌盛；一个坏的风水气场，能使一个团体、企业、家庭衰败，甚至灭亡。风水文化是我中华民族几千来积累的智慧和结晶。我们应该把这种文化发扬光大，很好的去传承和运用，这也是我们的责任和任务。</p></div>
<div class="waiku">
<p style="margin-left:0px;">风水不但是我们中华民族的一种文化，也是一门技术，很早以前风水分为两大派：一是峦头形势派，简称：“三合”，盛行于民间。二是形势理气派，简称为“三元”，盛行于王公贵族。所以过去有种说法，民间重于形，皇家重于气。“三合”、“三元”两者不同的是：三合讲峦头形体，布局立极定向，是用四局、纳甲、长生水法。“三元”讲的是峦头形势为体，理气为用。理气讲“三元九运理气兴衰”，就是人类居住的宅舍周边环境、理气，就是日、月、星、在不停的运转给宇宙空间带来的影响。气在天为阴阳之气，在地金木水火，在时为春夏秋冬，以寒、热、冷、暖四季定位。阴、阳五行互为制化，阳升、阴降、阴升、阳伏，空间气场的变化这叫天运。又以木星和土星每二十年相会在巳、酉、丑三个方位。每二十年为一运，分为三元九运，用河图洛书：先后天八卦、推演出吉凶祸福，按形体的空、满、虚、实、水法分为零正，合局为吉。吉者，人生安泰，财源茂盛，能使一个团体、企业、家庭和谐顺畅。反局为凶的法则断出吉凶祸福。凶者，人生灾难重重，贫困破财，能使一个团体、企业、家庭衰败，甚至灭亡。元运知福贵、流年知吉凶，是人类居住的地方趋吉避凶，达到天人合一。</p>
<img style="margin-left:12px; margin-top:8px;" src="http://static.ebanhui.com/ebh/tpl/2012/images/zytu20831.jpg" /></div>
<div class="waiku">
<img style="margin-top:10px;" src="http://static.ebanhui.com/ebh/tpl/2012/images/zytu30831.jpg" />
<p>案例1：一九八四年以后七运时期，我村黄某建阳宅一座，坐南朝北，离宅，正南偏西南十五度，丁山癸向，前面河水从西方，兑上流入东南巽方，按照天星运转，“七赤星”到东南巽方水口、形成了反局，七赤正神下水，形成零正颠倒、反局为凶，建好黄某入住后，黄某做生意大破财，他有一个儿子6岁，得了白血病、到北京医院治疗花钱数万。结果没治好而后夭亡，造成家庭衰败。</p>
<p style="margin-top:20px;">案例2：我村张某，一九九0年建造坤宅，坐西南朝东北，申山寅向，前面河水从西方来水流入东北艮方，天星运转，七赤星转移到东北艮方水口。建好张某入住后，小女有车祸之灾，因一九九0年也是七运时期，七运正神令星到东北水口艮方，形成了反局，正神下水，零正颠倒，反局为凶，家庭经济贫困，灾难重重。因我多年来利用大玄空风水为各大团体、企业和多个家庭勘察旧宅，验证过去每个企业和家庭的实际情况都应验，准确率极高。这都说明风水是人类的生活基础，只有一个好的风水环境才会使一个团体、家庭幸福和谐昌盛，不会受到损失。</p>
</div>
<div class="fotsiz">
<ul>
<li style="width:325px;">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/zytu40831.jpg" />
<p>所以三元大玄空风水学经过先贤千百年不断的演绎，总结升华而形成的结构严谨，逻辑性强，富于哲理性，科学性的一门系统学术，大玄空风水学上照应星象转移规律下顺应自然万物变化对宇宙大自然的影响，用哲学的思维方式，用科学的观点，把大玄空风水文化与地理、物理学、水文地质学、环境景观学、生态建筑学、天文星象学、地球磁场方位学、气象学、人体信息学进行科学接缘，“用一分为二”的观点，挖掘民间大玄空风水文化宝藏承传先人的智慧，解除祖先的困惑，探求自然的神秘，光大人类的科学，用大玄空风水学的科学性、哲理性改造大自然，服务于民生，推进社会和谐发展，达到“天人合一“的境界，使大玄空风水文化迈向科学通道。</p>
</li>
<li style="width:279px;">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/zytu50831.jpg" />
<p>大玄空风水学，是宇宙空间气场与峦头形体水法相结合及复合日、月、星的转移规律，它有一套既系统又完整的体系。汉朝以前被帝王所私用，到唐朝以后渐传于世。历史上曾出现了如杨均松、曾求已、郭璞、廖均卿、赖布衣、蒋大鸿等几大名师。历代先师们都把大玄空风水秘术视为天机，比较严谨，都不愿公开，历代传承都是以收徒为主，心传口授，不留文字。因此至今大玄空风水秘术知道的人很少。过去世面上流传的地理学却是一些峦头形体以及一些杂说的书籍，书的内容大多数都是虚传讹诈，糟粕很多，应验率不高，科学性不强，过于呆板，所以很多人都认为风水是种迷信。</p>
</li>
<li style="width:340px;">
<img src="http://static.ebanhui.com/ebh/tpl/2012/images/zytu60831.jpg" />
<p>古本《玄空本义》讲：“玄空由来已久，重以为玄学，而不知其科学化之学也；其论山水形胜，则地理学也，土质土色则地质学也；布局聚势，力贵向心则物理学也；俯察仰视，成象成形则天文学也，风水方位冲和则气象学也；八卦九宫、三元两片，则有不外乎数学也，地理、地质、物理、天文、气象与数学人人皆知，其为自然科学也，地学惟明此谄学之体，而且习遗期用，不惟区止诸学之全……惟形势与理气皆知，即空间与时间并重、地学之为科学化，盍亦更无可痴，科学必有假设与试验而发明，地理之学亦山川河流，千百年来万人为之假设与试验而来，并非出自玄想神话与迷信。以上这段文章是国人对玄空风水学的高度评价，也就是说玄空风水是“诸学之全”，科学中的科学，它是宇宙空间自然科学。大玄空风水学，它是易学风水中的精髓，是科学而不是迷信。</p>
</li>
</ul>
</div>
</div>
</div>
</div>
<div class="fotsite">
<p style="margin-left:165px;_margin-left:83px;width:175px;">邮箱：<a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></p>
<p style="width:150px;">电话：<?= $room['crphone']?></p>
<p style="width:110px;">QQ：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes"><?= $room['crqq']?></a></p>
<p>地址：<?= $room['craddress']?></p>
</div>
    <?php
	$this->display('common/player');
    $this->display('common/footer');
    ?>
