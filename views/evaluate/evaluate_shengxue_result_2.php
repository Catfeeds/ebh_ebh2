<?php $this->display('myroom/page_header'); ?>
</head>
<style>
.lefrig {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #cdcdcd;
    float: left;
    margin-top: 15px;
    padding-bottom: 10px;
    width: 786px;
}

.redsrt {
    background: none repeat scroll 0 0 #fff;
    float: left;
    padding-bottom: 20px;
    width: 786px;
	#height:780px;
	#overflow-y:auto;
}
.hrrty {
    background: none repeat scroll 0 0 #4fcffe;
    border-bottom: 1px solid #cecece;
    color: #fff;
    font-size: 14px;
    height: 34px;
    line-height: 34px;
    padding-left: 10px;
}

.rgiege {
    display: inline;
    float: left;
    font-size: 14px;
    line-height: 1.8;
    margin: 10px 50px 0;
    text-indent: 30px;
    width: 710px;
}
.dgeod {
    display: inline;
    float: left;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.8;
    margin: 10px 50px 0;
    width: 710px;
}

.fgngr {
    border-bottom: 1px solid #e3e3e3;
    display: inline;
    float: left;
    font-size: 14px;
    line-height: 1.8;
    margin: 10px 50px 0;
    padding: 10px 0;
    width: 710px;
}

.MsoNormal {
    display: inline;
    float: left;
    font-size: 14px;
    line-height: 1.8;
    margin: 10px 50px 0;
    text-indent: 30px;
    width: 710px;
}
.redsrt img{max-width:700px;}
</style>
<body>
<?php 
$typearray = array(
	'dongji'=>'学习动机测试',
	'xintai'=>'应考心态测评 ',
	'jiaolv'=>'焦虑心理测评 ',
	'shengxue'=>'升学择业测评 ',
)
?>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('myroom/evaluate');?>">自我测评</a> > <?=$typearray[$type]?> >测评结果
</div>
<div class="lefrig" style="margin-top:10px;">
<div class="redsrt" style="padding-bottom:20px;font-size:14px">
<h2 class="hrrty">升学择业测评结果</h2>

<p class="MsoNormal" style="text-align:center;line-height:200%;
mso-pagination:widow-orphan" align="center"><b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:red;mso-font-kerning:
0pt">测试结果 </span></b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US"></span></p>

<p class="MsoNormal" style="mso-margin-top-alt:auto;text-align:left;
text-indent:21.1pt;mso-char-indent-count:2.0;line-height:200%;mso-pagination:
widow-orphan" align="left"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">管理型：</span></b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">喜欢和人群互动，自信、有说服力、领导力，追求政治和经济上的成就。这种人喜欢支配别人，有冒险精神，自信而精力旺盛，好发表自己的见解。他们愿意从事那些为直接获得经济效益而活动的职业。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%;mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">可参考填报：<b>哲学</b>：哲学、宗教学<span lang="EN-US">;</span><b>经济学</b>：经济学、国际经济与贸易、保险<span lang="EN-US">;</span><b>法学</b>：社会学、社会工作、外交学、思想政治教育、公安学类所有专业<span lang="EN-US">;</span><b>教育学</b>：特殊教育、旅游管理与服务教育、市场营销教育<span lang="EN-US">;</span><b>文学</b>：新闻学、广播电视新闻学、广告学、导演、播音与主持艺术、广播电视编导<span lang="EN-US">;</span><b>管理学</b>：管理科学与工程类所有专业、工商管理类所有专业、公共管理类所有专业、农林经济管理类所有专业<span lang="EN-US">;</span><b>理学</b>：天文学类、地质学类、地理科学类、地球物理学类、大气科学类、海洋科学类、环境科学类、心理学类、统计学类所有专业<span lang="EN-US">;</span><b>工学</b>：航空航天类、武器类、公安技术类所有专业<span lang="EN-US">;</span><b>农学</b>：植物生产类、草业科学类、森林资源类、环境生态类、动物生产类、水产类所有专业<span lang="EN-US">;</span><b>医学</b>：法医学。<span lang="EN-US"></span></span></p>

<div class="MsoNormal">

<table width="710" height="1144" border="1" cellpadding="0" cellspacing="0" class="MsoNormalTable" style="border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
 mso-border-alt:solid windowtext .5pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
 mso-border-insideh:.5pt solid windowtext;mso-border-insidev:.5pt solid windowtext">
 <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学科<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">门类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">专业名称<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:1">
  <td rowspan="2" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">01</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0101</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">010101</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:2">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">010103K</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">宗教学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:3">
  <td rowspan="3" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">02</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">经济学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0201</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">经济学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020101</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">经济学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:4">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0203</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">金融学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020303</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">保险<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:5">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0204</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">经济与贸易类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020401</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">国际经济与贸易<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:6">
  <td rowspan="5" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">03</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0303</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">社会学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">030301</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">社会学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:7">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">030302</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">社会工作<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:8">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0302</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">政治学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">030203</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">外交学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:9">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0305</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">马克思主义理论类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">030503</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">思想政治教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:10">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0306</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">公安类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:11">
  <td rowspan="3" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">04</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="3" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0401</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040108</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">特殊教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:12">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040331</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">旅游管理与服务教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:13">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040336</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">市场营销教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:14">
  <td rowspan="4" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">05</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">文学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="4" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0503</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">新闻类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050301</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">新闻学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:15">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050303</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">广告学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:16">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050413</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">导演<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:17">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050419</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">播音与支持艺术<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:18">
  <td rowspan="8" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">07</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">理学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0704</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">天文学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:19">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0705</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">地理科学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:20">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0706</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">大气科学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:21">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0707</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">海洋科学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:22">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0708</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">地球物理学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:23">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0709</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">地质学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:24">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0711</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">心理学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:25">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0712</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">统计学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:26">
  <td rowspan="2" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">08</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">工学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0820</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">航空航天类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:27">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0821</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">兵器类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:28">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学科<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">门类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">专业名称<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:29">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">08</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">工学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0831</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">公安技术类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:30">
  <td rowspan="6" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">09</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">农学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0901</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">植物生产类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:31">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0902</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">自然保护与环境生态类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:32">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0903</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">动物生产类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:33">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0905</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">林学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:34">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0906</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">水产类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:35">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0907</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">草业类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:36;mso-yfti-lastrow:yes">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1009</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法医学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1009K</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法医学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
</tbody></table>

</div>

<p class="MsoNormal" style="text-align:center;line-height:200%" align="center"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:red">相关专业推荐介绍</span><span style="color:red" lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">为了帮助您更好地了解适合自身学习的专业，下面将根据上述测验的结果，从何时您选报的专业中选择部分专业，简要的介绍其相关的学习内容。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本报告中基本专业的专业介绍信息主要为</span><span lang="EN-US">2012</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年教育部颁布的《普通高等学校本科专业目录（</span><span lang="EN-US">2012</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">）》中对具体专业的介绍。在此特别声明：我们提供该类信息的目的在于为高考生提供更多信息作为参考，请以各高校真是公布数据为准。</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">010103K</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">宗教学（<span lang="EN-US">01</span>哲学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干课程：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">中国哲学史、外国哲学史、宗教学导论、佛教史、道教史、基督教史、伊斯兰教史、民间宗教研究、宗教社会学、宗教心理学、宗教问题社会调查与方法等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：宗教问题社会调查，一般安排<span lang="EN-US">6</span>周左右。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">修业年限：四年<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">授予学位：哲学学士<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业培养具有一定的马克思主义理论素养，具备较全面的宗教学知识，了解世界名人宗教的历史与现状，熟悉我国宗教法规和政策，能在高等院校、研究机构或政府部门从事教学、研究、宗教事务管理、理论宣传、政策调研等工作的宗教学高级专门人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">知识技能毕业生应获得以下几方面的知识和能力：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握马克思主义的基本原理和宗教学的基本理论，具有关于世界主要宗教的基本知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、掌握现代宗教学的主要研究方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解世界宗教的发展动态和宗教研究的前沿问题；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解我国的宗教法规和政策；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有独立思考、分析问题的基本能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握文献检索、社会调查的基本方法，具有初步的教学、科研和实际工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">020401</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">国际经济与贸易（<span lang="EN-US">02</span>经济学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">专业核心课程与主要实践环节：外贸英语、西方经济学、管理学、国际贸易地理、国际贸易、国际贸易实务、国际金融、国际市场营销、外贸会计、电子商务概论、中国对外贸易政策法规、国际贸易规则与惯例、模拟实训、毕业实习、毕业论文等，以及各校的主要特色课节。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">其他：该专业可获取国家商务部和人事部联合认证的外销员职业资格证书。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科与课程：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">经济学、统计学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">政治经济学、西方经济学、国际经济学、计量经济学、世界经济概论、国际贸易理论与实务、国际金融、货币银行学、财政学、会计学、统计学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">毕业与学位：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">修完培养方案规定的最低学分并达到毕业条件者准予毕业，符合学位授予条件者授予经济学学士学位。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业培养德、智、体、美全面发展人才，较系统地掌握马克思主义经济学基本原<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">国际经济与贸易教材理和国际经济、国际贸易的基本理论，掌握国际贸易的基本知识与基本技能，了解主要国家与地区的社会经济情况，具有国际贸易业务操作能力，能在涉外经济贸易部门、外资企业及政府机构从事实际业务、管理、调研和宣传策划工作的高素质复合型涉外经贸人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业培养的学生应较系统地掌握马克思主义经济学基本原理和国际经济与管理的基本理论，掌握国际贸易的基本知识与基本技能，了解当代国际经济贸易的发展现状，熟悉通行的国际贸易规则和惯例，以及中国对外贸易的政策法规，了解主要国家与地区的社会经济情况，能在涉外经济贸易部门、外资企业及政府机构从事实际业务、管理、调研和宣传策划工作的高级专门人才，具有理论分析和实务操作的基本能力，具备较强的外语能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">毕业生应具备以下几方面的知识、能力和素养：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、正确理解并执行党和国家的基本路线、方针、政策，遵纪守法，有为国家富强、民族振兴而奋斗的理想和为人民服务、勇于开拓、艰苦创业的事业心与责任感；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握经济学基本理论和方法，掌握国际经济与贸易的基本原理和设计方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有经济管理、经济贸易、市场营销、进出口贸易国际经济法的基本知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、能运用计量、统计、会计方法进行分析和研究；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解中国的经济政策和法规，了解主要国家和地区的经济发展状况及其贸易政策；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、了解国际经济、国际贸易的发展动态；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">7</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、能够熟练地掌握英语，具有较强的英语听、说、读、写能力，能利用计算机从事涉外经济工作；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">8</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有健康的体魄、良好的心理素质和健全的人格。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">9</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、基本学制<span lang="EN-US">4</span>年，本科一般实行<span lang="EN-US">3</span>～<span lang="EN-US">7</span>年弹性修业<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">030302</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">社会工作（<span lang="EN-US">03</span>法学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">专业基础课程：社会学概论、社会工作概论、社会统计学
、社会调查研究方法、个案工作、小组工作、社区工作、社会工作专业伦理、社会工作行政、社会工作实务、人类行为与环境、社会心理学，普通心理学、异常心理学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">特色课程：社会保障概论、中国社会思想史、心理咨询、犯罪心理学、组织社会学、青少年社会工作、老年社会工作、妇女社会工作、学校社会工作、残障社会工作、家庭社会工作、医务社会工作、社会问题概论、社会政策、现代社会福利思想等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">实践教学：主要实践性教学环节：课堂讨论、社会实践、社会调查，专业教学实习等，一般安排<span lang="EN-US">14-16</span>周。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">相近专业：社会学社会工作
老年学 临床心理学 人类学 女性学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">相关证书：助理社会工作师、社会工作师<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">修业年限：四年<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">授予学位法学或哲学学士<b><span lang="EN-US"></span></b></span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">毕业生应获得以下几方面的知识和能力：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、了解社会学的理念和方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、熟练掌握社会工作的各种技能和方法，善于运用理论、知识和方法帮助困难群体走出困境，从事正常生活并获得发展；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、熟练掌握社会调查方法和技能及社会统计方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解跟做好社会工作有关的重大方针、政策、法律和法规，有通过社会工作实践和社会工作研究影响社会政策的价值取向和基本能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有初步的科学研究能力，善于了解国情，善于分析各种社会现象和问题，具有较强的论文写作和语言表达能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握文献检索、资料查询的方法，具有一定的实际工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">推荐院校：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">北京师范大学、中山大学、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1471.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">北京大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、中国人民大学、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/9883.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">中华女子学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、中国青年政治学院、中国劳动关系学院、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/4613.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">云南大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、北京城市学院等。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专家建议：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">根据本专业的就业情况现状，同学们应当尽早确定自己的职业兴趣是否与专业一致。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">如果职业兴趣与专业不匹配，那意味着毕业后你必将转行。这样的话，建议你做一个职业兴趣测试，找到与你性格最匹配的行业和职业，然后再通过各种渠道搜集这些行业和职业的信息，然后再根据自身条件，尽早确定你毕业后希望从事的职业。其实，有很多社工系的学生还没毕业或一进社工系就很清楚自己不适合走社工这条路，完全不用为着自己没走社工而有罪恶感，清楚自己想要的是什么，才是真正的对自己负责，你可以根据自己的职业兴趣转往媒体、人力资源管理、保险业等薪水和前景较好的领域，或者有自己的志向所在的专业。所以请你先澄清自己是不是真的要走社工，如果拿不定主意请跟学长姐、或找个你信任的老师谈谈，不要一失足成千古恨，再回头已是百年身。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">然后，你的任务就是针对该职业的从业资历要求进行自我学习。要学什么？最简单的方式是找到与该职业最相关的大学专业的核心课程表，还有在网络上找一些该职业的招聘要求，两者结合起来分析，你就明白什么是你需要掌握的知识了。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">如果职业兴趣与专业匹配，也建议在学好社会工作专业课程的同时，另外能有一技傍身，因为，谁都无法保证你在毕业后能百分之百对口就业。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">对于专业社工来说，社会学、心理学、管理学、社会统计学、个案、小组工作等专业学科十分重要，当然，大学英语和计算机则是重中之重，因为熟练掌握英语和计算机就相当于拿到了一扇通往更高层次大门的钥匙，等于拥有让你在职业发展过程中“进可攻，退可守”的武器：如果社工职业发展不顺利，你可以在英语、数学能力强的基础上考研。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">社会工作需要大量的实习来检验理论与实践的差距，一般学校都会为本专业的学生提供一些实习机会。另外，最好能利用寒暑假期间到珠三角地区（广州、东莞、深圳、佛山、中山、珠海等地）社工体系相对完善的地区去实习，那样能积累到更多更先进的经验。需要实习生的机构联系电话和地址，一般在网上都能搜索到。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">040331</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">旅游管理与服务教育（</span><span lang="EN-US">04</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">教育学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">经济学、管理学、旅游学概论、区域旅游规划、酒店管理、旅游教学论、教育实习等旅游教育方向类课程；市场营销学、消费心理学、电子商务、项目策划、企业营销训练等旅游营销策划方向类课程；设计素描、色彩构成、建筑学基础、工程制图、城市规划原理、绿地系统规划、景区规划、景观设计等旅游景观规划设计与管理方向类课程。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">特色课程：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">旅游学概论、形体训练、旅游地理学、旅游资源学、旅游英语、饭店经营管理概论、饭店管理实务、旅游经济学、旅游心理学、旅行社经营管理概论、旅游接待礼仪、东南亚概况、第二外语、旅行社管理实务、导游基础知识、导游业务、教育心理学、教育学等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：管理学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业代码：</span><span lang="EN-US">040331</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具有扎实旅游管理与服务专业理论基础，掌握旅行社、星级酒店等旅游企业实际操作能力，掌握教育理论和教育方法，实践能力强，综合素质高，能在旅行社、星级酒店、旅游行政管理部门及相关旅游企业从事服务与经营管理、并能够在中、高等职业技术学校从事教学工作“一体化”教师的高级应用型专门人才，学业合格授予管理学学士学位。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业优势：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">该专业分三个方向：（</span><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）旅游教育方向：以中等专业学校教师和学生考研深造为主要培养方向，注重于基础理论的学习，以培养专业基础扎实、教学实践和教学适应能力强、综合性知识储备丰富、具有较高人文素养的高素质人才为中心。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">（</span><span lang="EN-US">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）景观规划与设计方向：培养能从事旅游区规划、旅游景观设计、城市绿地规划、风景园林设计方面等工作，具有相应的专业理论基础，具备现代设计意识和创新能力的旅游应用型设计专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">（</span><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）策划营销方向：通过系统的旅游及其它基本理论和营销策划基础知识的学习，接受相关市场营销及产品策划和创意的技能训练，并通过与企业合作进行实践，培养掌握旅游和其它行业营销与策划的基本技能和基本思维方法，专业素养好，并具有开拓创新精神，能在旅游企事业单位、进行产品推广的企业或企业部门、以及相关部门，从事旅游及其它行业的营销和产品策划的复合型人才。职业师范本科，学制四年，授予管理学学士学位。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">浙江师范大学、重庆理工大学、山西大学、山西师范大学、山西财经大学、太原师范学院、云南师范大学、云南民族大学、楚雄师范学院、内蒙古财经学院、河北师范大学、广东技术师范学院、兰州城市学院、河北师范大学汇华学院、延安大学西安创新学院等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">050301</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">新闻学（</span><span lang="EN-US">05</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">文学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">核心课程编辑新闻学包括新闻学方向和广播新闻与电视新闻学方向：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">新闻学方向</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">核心课程有：</span><span lang="EN-US">1.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻学概论》</span><span lang="EN-US"> 2.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《中国新闻事业史》</span><span lang="EN-US">3.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《外国新闻事业史》</span><span lang="EN-US"> 4.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻采访写作》</span><span lang="EN-US"> 5.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻评论写作》</span><span lang="EN-US"> 6.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《中外新闻作品研究》</span><span lang="EN-US">7.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻摄影》</span><span lang="EN-US">87</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《公共关系学》</span><span lang="EN-US">9.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《报纸编辑》</span><span lang="EN-US">10.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻事业管理》</span><span lang="EN-US">11</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《中国现代文学作品选》</span><span lang="EN-US">12.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《广告学（新闻类）》。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">广播与电视方向</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">核心课程有：</span><span lang="EN-US">1.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻学概论》</span><span lang="EN-US"> 2.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《中国新闻事业史》</span><span lang="EN-US">3.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《外国新闻事业史》</span><span lang="EN-US"> 4.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻采访写作》</span><span lang="EN-US"> 5.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《广播电视技术基础》</span><span lang="EN-US"> 6.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《节目策划与编导》</span><span lang="EN-US">7.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《广播新闻与电视新闻》</span><span lang="EN-US">8.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻心理学》</span><span lang="EN-US">9.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《传播学概论》</span><span lang="EN-US">10.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《文学概论（一）》</span><span lang="EN-US">11.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻摄影》</span><span lang="EN-US">12</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《主持人节目》</span><span lang="EN-US">13.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《电视摄象》</span><span lang="EN-US">14.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻事业管理》</span><span lang="EN-US">15</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《电视节目制作》</span><span lang="EN-US">16</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《新闻心理学》</span><span lang="EN-US">17.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《广告学（二）》</span><span lang="EN-US">18.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">《播音文体理论》。等</span><b><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养具有新闻学基本理论与基本知识，掌握新闻采访、写作、编辑、评论、摄影、策划、编导、制作等基本技能，具备在新闻、出版、广播、电视、宣传部门及各企事业单位从事编辑、记者、媒介经营管理、音像策划、广告制作等素质的现代传媒人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">记者、编辑、管理人才以及新闻教学和研究人才</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、应具备系统的新闻理论知识与技能；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、应具备系统宽广的文化与科学知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、应具备熟悉我国新闻、宣传政策法规，能在新闻、出版与宣传部门从事编辑、记者与管理等工作的新闻学高级专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">070503</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">人文地理与城乡规划（</span><span lang="EN-US">07</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">理学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干课程</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">城乡规划原理、区域规划、城市设计、居住区规划、小城镇规划、村庄规划、控制性详细规划、城市道路与交通、规划设计</span><span lang="EN-US">CAD</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">、城市地理学、地理信息系统、地图学、城市园林绿地系统规划、人文地理学、经济地理学、城乡规划管理与法规、建筑制图、自然地理学等</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相关学科</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">地理科学、城市规划、资源环境与城乡规划管理、自然地理与资源环境等</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">学制：四年</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">学位：理学学士</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业以素质教育为宗旨，以实践能力和创新能力培养为根本，为学生公共素质拓展与专业素质拓展提供良好的环境。培养掌握地理学、经济学、管理学、城乡规划等基本理论、基本知识和基本技能，掌握城乡规划设计、土地资源利用和规划、旅游资源规划等专业基本技能，熟悉资源与环境、城乡规划有关政策和法规，了解资源环境与城乡规划管理领域发展动态，能够从事城乡规划设计、城建管理、土地规划和管理、旅游规划和开发及相关领域工作中的高级应用型人才。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">河北师范大学、西北农林科技大学、齐齐哈尔大学、华中师范大学、西藏大学、西安外国语大学、东北农业大学、福州大学、吉林大学、东北师范大学、吉林农业大学、哈尔滨师范大学、东北石油大学、内蒙古农业大学、内蒙古师范大学、华东师范大学、南京大学、南京邮电大学、南京农业大学、江苏师范大学、南京信息工程大学、南京建筑工程学院、苏州科技学院、浙江大学、浙江农林大学、浙江财经大学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="font-size:12.0pt;line-height:200%;mso-fareast-font-family:仿宋_GB2312;
color:black;mso-font-kerning:0pt" lang="EN-US">082001</span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">航空航天工程专业（</span><span lang="EN-US">08</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">工学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>


<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">课程：空气动力学</span><span lang="EN-US">I</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、飞行器结构力学、航空航天概论、机械设计基础、电路与电子学、自动控制原理、工程热力学、飞行器总体设计、飞行器结构设计、传热学、燃烧学、流体力学、材料力学、结构强度、材料与制造工艺、航空发动机、飞行控制、通信与导航、风洞试验、可靠性与质量控制、安全救生、环境控制、航空仪表、航空宇航制造工程、航空航天动力装置、电子对抗技术、隐身技术、飞机维修等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：工程力学与航天航空工程、飞行器设计与工程、飞行器动力工程、飞行器制造工程、飞行器环境与生命保障工程</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">学生应具有扎实的数学、物理、力学、实验及计算机基础，掌握航空航天领域的多学科知识，具有全面的文化素质、合理的知识结构和较强的环境适应能力，具有良好的语言运用能力，了解本专业领域的理论前沿、应用前景和发展动态，能运用理论分析、数值模拟和实验研究等手段研究和解决航空航天领域的实际问题，能从事航空航天飞行器总体、结构和系统设计的相关工作。毕业生可直接进入航空航天部门的科研院所和工程单位工作，也可在航空航天科学与技术、力学等相关专业继续深造。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：北京大学、上海交通大学</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">090106</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">设施农业科学与工程（</span><span lang="EN-US">09</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">农学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp; </span></span></b><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：英语、计算机、植物学、植物生理学、传感与测试技术、工程力学、农业设施工程学、农业设施设计与建造、设施环境与调控、设施作物栽培学、无土栽培学、工厂化育苗、设施农业经营与管理等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：农学（</span><span lang="EN-US">090101</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、园艺（</span><span lang="EN-US">090102</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、植物保护（</span><span lang="EN-US">090103</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、茶学（</span><span lang="EN-US">090104</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、烟草（</span><span lang="EN-US">090105</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">种子科学与工程（</span><span lang="EN-US">090107</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">）、植物科学与技术（</span><span lang="EN-US">090106</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、应用生物科学（</span><span lang="EN-US">090108</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）。</span><b><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、具有一定自然科学和人文社会科学的基本知识和基本素质；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具备较扎实的数学、物理、化学、生物学等基本理论知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握现代生物科学、设施和环境工程科学的基本知识体系，具备农业可持续发展的意识和基本方法；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握设施农业科学的基础知识和基本理论，具备较熟练的设施农业与工程技术的应用能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握科技文献检索、资料查询的基本方法，了解设施农业生产和科学技术的前沿和发展趋势；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有一定的调查、科研和科技文献写作能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">就业方向：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">该专业的学生毕业后能在科学研究机构、高等院校、企事业单位及行政部门从事设施农业的生产技术、工程设计、管理、教学和科研方面工作。可选择的单位主要有：农业教育机构、教学单位（高职、中专学校）、科研单位、农业管理部门、信息咨询公司、蔬菜花卉及果品企业、大型温室及种子种苗公司、农产品外贸公司、现代农场及现代化高科技示范园等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">另外，如果想继续深造还可选择攻读园艺学、蔬菜学、农业建筑环境与工程等相关学科的硕士研究生，也可在植物科学类、工程科学类、环境科学类如作物生理生态、设施设计与改良、设施环境工程与调控、设施生产技术、无土栽培、资源综合利用等方向深造。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">可在涉及农业、设施、生物或综合性高等院校、科研单位、科技推广部门从事教学、科研、管理、技术推广和经营工作。也可通过选干或公务员考试进入各级政府相关部门从事行政管理。还可通过双向选择进入农业、设施、环境工程等部门从事科研、开发、推广及生产经营工作。</span><b><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">中国农业大学、西北农林科技大学、南京农业大学、华中农业大学、安徽农业大学、华南农业大学、内蒙古农业大学、新疆农业大学、青岛农业大学、甘肃农业大学、山东农业大学、云南农业大学、东北农业大学、河北农业大学、河北科技师范学院、沈阳农业大学、河海大学、福建农林大学、华南热带农业大学、海南大学、潍坊学院、红河学院、安徽科技学院、四川农业大学、河南农业大学等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">1009K</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">法医学（<span lang="EN-US">10</span>医学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干课程：基础医学、临床医学、法医学、法学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">除了政治、英语、体育、计算机等公共必修课外，专业必修课主要有后面几门：医药高等数学、医学物理学、医学统计学、基础化学、有机化学、医学生物学、卫生法学、解剖学、组织学与胚胎学、医学微生物学、医学细胞生物学、医学遗传学、生物化学与分子生物学、生理学、病理学、病理生理学、医学免疫学、药理学、神经科学、内科学、外科学、妇产科学、儿科学、眼科学、诊断学、医学影像学、耳鼻咽喉头颈外科学、刑事科学技术、法医临床学、法医物证学、法医毒理学、法医毒物分析、法医病理学、法医精神病学、犯罪心理学、法医人类学、法医法学、司法鉴定学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">理论学习：法学理论、人体解剖学、病理学、内科学、外科学、妇产科学、儿科学、刑事科学技术、法医病理学、法医毒理学、法医毒物分析、法医临床学、法医精神病学、法医物证学、法医人类学、法医法学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：临床实习一般安排<span lang="EN-US">12</span>周左右；专业实习（包括法医病理、法医物证及法医临床等）<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">校外基地实习一般安排<span lang="EN-US">12</span>周左右。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">修业年限：五年（某些大学七年制本硕连读或八年制本硕博连读）<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">授予学位：医学学士（医学硕士、医学博士）<b><span lang="EN-US"></span></b></span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握基础医学、临床医学、法学以及法医学的基本理论、基本知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握法医学的基本技术和案例分析的思维方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有法医学检案和鉴定的初步能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、熟悉与法医学有关的我国的各项法律以及法医工作的政策和规程；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、了解法医学的应用前景及发展动态；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握文献检索、资料查询的基本方法，具有初步的科学研究和实际工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">就业方向：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">深造方向：法医学专业研究生或临床医学专业研究生。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">就业前景：可在全国各级公安部门、检察院、司法机关、鉴定机构、医院、高等院校及保险公司等从事法医学鉴定、医疗服务、法医学及医学科研、教学、保险服务等工作。伴随着国家法制化建设进程的推进和对司法鉴定技术工作的日益重视，未来数年全国范围内对法医学专业毕业生需求量旺盛。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-align:center;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%" align="center"><b><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:red;
mso-font-kerning:0pt">使用帮助<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%;mso-outline-level:1" align="left"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">①专业选择测试为什么有六种职业兴趣类型？<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">根据我国具体国情，研发团队做了大量扎实的研究工作，经过反复验证，得出我国高中学生职业兴趣的七个类型，并将它们命名为：艺术型、传统型、管理型、研究型、现实型、社会型。这几种职业兴趣类型与霍兰德职业兴趣理论的六种类型相似，兴趣是人们活动的巨大动力，凡是具有职业兴趣的职业，都可以提高人们的积极性，促使人们积极地、愉快地从事该职业，且职业兴趣与人格之间存在很高的相关性。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp; </span><b><span style="mso-spacerun:yes">&nbsp;</span></b></span><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">②专业选择测试是否能准确测查个人的兴趣和能力特点？</span>
</b></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　科学的心理测试均有一套标准而严格的编制程序来解决测验的有效性和可靠性等一系列问题，即测验的信效度问题。“专业选择测试”是一套标准的心理测试，总共有</span><span lang="EN-US">210</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">道题，其中</span><span lang="EN-US">140</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">道题测查职业兴趣，</span><span lang="EN-US">70</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">道题测查职业胜任力。</span><span lang="EN-US"> </span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　在研发过程中，研发团队采集了上万名不同区域高中生样本进行试测分析，数据显示该测试的信度、效度都达到了比较理想的结果，其中再测信度达到了</span><span lang="EN-US">0</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">．</span><span lang="EN-US">72</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">～</span><span lang="EN-US">0</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">．</span><span lang="EN-US">8</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">之间，内部一致性信度为</span><span lang="EN-US">0</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">．</span><span lang="EN-US">89</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">～</span><span lang="EN-US">0</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">．</span><span lang="EN-US">92</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">之间，因素分析得到</span><span lang="EN-US">7</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">个因素的解释率达到</span><span lang="EN-US">45.35</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">％，均达到了心理测验所要达到的标准，因此该研究结果可以推广到全国范围内的高中生。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">同时，项目组每年对测试数据进行检验分析，对于一些指标不好的题目进行修订，保证了测试的时效性和信效度。</span><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">因此，我们说“专业选择测试”可以准确而有效的测量学生的兴趣和能力特点，并为学生在专业选择方面提供合理建议。</span><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-align:center;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%" align="center"><b><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:red;
mso-font-kerning:0pt">考高志愿填报指导<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#333333;
background:white">　</span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　虽然离高考志愿填报还有几个月时间，但是经验丰富的志愿咨询专家以及过来人们普遍认为，高考关系到未来的学业和职业生涯，那种准备用几天时间就搞定志愿填报的想法，是极不负责的，且容易出现失误。考生和家长有必要提前收集院校专业信息，了解最新政策变化和录取规则，并对自身实力、兴趣进行详细的分析，以最充分的准备进行高考志愿的填报。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　如果把高考当成一场战争的话，孩子是冲锋陷阵的战士，而家长就应是谋定战局的高参，这场战争的输赢不仅仅要依靠孩子的作战能力——即高考成绩，更需要家长提前谋划战争的布局，充分考虑孩子的成绩定位，填报志愿的方向，未来的就业等等因素。只有这样才能对孩子当下的高考之战以及未来的人生之战有一个理智、准确、全面、长远的“战略规划”，赢得一场对以后人生至关重要的战役。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　然而能谋划好毕竟是少数。因为成年人解决问题主要依靠其固有的经验、阅历及社会关系，而高考及其志愿填报对于绝大部分家长来说都是第一次，而第一次做事最易出错。又因其影响重大，身边人很难或是不敢轻易提供意见。在这事情上每个家庭都没有试错的机会，否则代价太大</span><span lang="EN-US">!</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">况且还面临着以下三大因素的影响：</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　<b>　①评判大学、专业实力的指标及方法已发生巨大变化</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　现在的高三家长很多是在</span><span lang="EN-US">80</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年代上的大学，当时的大学有重点大学和普通大学之分，但差别不明显，都是国家包分配，大家的工资也一样。当时重点大学毕业的进国家机关、大型国有企业，普通大学毕业的进市机关、市属企业，经过这么多年的发展，大家的事业各有千秋，差别不大。但目前的情况发生了变化，大学有了一本、二本、三本之分，还有提前批，即使一本的学校还分</span><span lang="EN-US">985</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大学、</span><span lang="EN-US">211</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">大学等。本地一本招生的学校，在外地可能是二本</span><span lang="EN-US">;</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">本地的二本，也可能是外地的一本学校。专业学科选择涉及国家重点学科、国家重点实验室、基地班等指标，有的学科有一级学科博士授予权，有的是二级学科授予权，有的名牌大学开设的专业竟然也没有博士授予权，甚至赶上学生毕业时，当初的专业取消了。现在选择的大学、专业对今后就业、考研、出国都有影响，这是我们孩子人生规划的第一步，而不仅仅是挑几所大学、选几十个专业那么简单。我们看到的高考失败好像就是复读，这只是显性的，还有隐性的，调查显示在校大学生</span><span lang="EN-US">65%</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">以上会觉得大学不合适或专业选择不合适，有的孩子一入学就后悔了，有的到大三、大四的时候才明白。</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　<b>　②时代不同，高考志愿填报也越来越复杂</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　平行志愿报考风险虽然降低，但填报不合理照样没学上，以下因素会影响录取结果：</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　</span><span lang="EN-US">(1)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">录取规则。被高校提档的考生，不一定</span><span lang="EN-US">100%</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">录取，对录取规则不了解，专业梯度不合适，且不服从调剂的，会被退档</span><span lang="EN-US">;</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　</span><span lang="EN-US">(2)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">梯度。虽然有多个平行志愿，但如果院校梯度不合理，再出现所报院校排名上涨的的情况，即使高分考生照样有可能落榜。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　</span><span lang="EN-US">(3)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">排名理念。如果当年考题容易，大家分数普涨，部分家长会盲目自信造成高报，即使多个平行志愿也可能同时落榜</span><span lang="EN-US">;</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">反之，高考题难的时候，会造成很多家长低报。</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　<b>　③家长对高校专业设置认识模糊，视野不宽，存在很多误区</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　有的家长认为金融学、计算机属于热门专业，盲目地给孩子填报这些专业。其实，这些专业的基础是数学，如果孩子的数学成绩不理想，就读这些专业会很吃力。还有的家长想让孩子以后当新闻记者和新闻编辑，给孩子填报新闻专业。其实，中央级、省级的新闻单位都是从其他专业挑选文字功底好的学生，培养成具有某一学科背景和深度见解的新闻人才。此外，热门专业并不一定是优势专业。比如财经类、金融类属于热门专业，北京化工大学招收这两类专业，招收的分数也不低，其实该校的优势学科专业是化学工程与工艺及高分子材料与工程专业。这两个专业虽相对冷门，但就业非常有优势，薪金待遇和发展前景都很好。像这种类似的专业设置和专业就业前景，家长往往不知情，这就需要提前为填报志愿做足准备，只有“门儿清”才能摸得着门道。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">按“分数报志愿”是个错误，可能导致选择失误</span><span lang="EN-US">!</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大学是按排名来录取的，不仅一本、二本、三本线是由排名来划定而最终得出批次线，高校在招生时也是以排名来划定投档线和录取线。高考试题的难易每年都有变化，不同年份的分数没有可比性，单纯的考生成绩是没有任何参考意义的。家长如果以“分数报志愿”，往往会造成定位的不准确，出现偏离甚至严重的失误。一些高校录取还会出现大小年现象，影响当年的录取排名。往年的录取数据你不会一两天就弄明白，需要花很多时间、精力去研究，这样才能报得科学，你还有可能“中大奖”，低分进入名牌大学。</span></p>
<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%">
<span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
mso-bidi-font-family:&quot;Times New Roman&quot;;mso-font-kerning:1.0pt;mso-ansi-language:
EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA">高考志愿填报对于每个毕业生来说都是人生中的大事，</span><span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
mso-fareast-font-family:宋体;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;
mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA"> </span><span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:
&quot;Times New Roman&quot;;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:
ZH-CN;mso-bidi-language:AR-SA">不论是学生家长、高中学校、各个高校、社会都参与进来，对高考毕业生产生或多或少的影响，这个时候，在考虑个人利益的同时也应当负责任地为高考生提供正确信息。每个高考生学会科学填报，减少失误，为今后更好的发展铺下坚固的基石。希望这份测试报告为能够为你提供一点参考。<span id="_editor_bookmark_start_44" style="display: none; line-height: 0px;">‍</span></span>
</p>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>
