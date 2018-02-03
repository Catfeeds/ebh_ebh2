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
<p class="MsoNormal" style="text-align:center;line-
mso-pagination:widow-orphan" align="center"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:red;mso-font-kerning:
0pt">测试结果</span></b><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US"></span></b></p>

<p class="MsoNormal" style="mso-margin-top-alt:auto;text-align:left;
line-mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">　　<b>艺术型：</b>有艺术、直觉、创造的能力，喜欢运用想象力和创造力，在自由的环境中工作。这种人想象力丰富，有理想，易冲动，好独创。他们喜欢从事非系统的、自由的、要求有一定艺术修养的职业。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;line-
mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt">　　可参考填报：<b>教育学</b>：学前教育、艺术教育、装潢设计与工艺教育 <b>文学</b>汉语言文学、汉语言、对外汉语、中国少数民族语言、外国语言文学、新闻传播学类所有专业、<b>艺术学</b>类所有专业<span lang="EN-US">;</span><b>历史学</b>：民族学、文物保护技术<span lang="EN-US">;</span><b>管理学</b>：旅游管理<span lang="EN-US">;</span><b>理学：地理科学类所有专业</b><span lang="EN-US">;</span><b>工学</b>：广播电视工程、土建类所有专业、测绘类所有专业、轻工纺织食品类所有专业、航空航天类所有专业、宝石及材料工艺学<span lang="EN-US">;</span><b>农学</b>：园艺、园林<span lang="EN-US">;</span><b>医学</b>： 医学影像学。<span lang="EN-US"></span></span></p>

<div class="MsoNormal" style="line-height:200%">

<table width="710" height="984" border="1" cellpadding="0" cellspacing="0" class="MsoNormalTable" style="border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
 mso-border-alt:solid windowtext .25pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
 mso-border-insideh:.25pt solid windowtext;mso-border-insidev:.25pt solid windowtext">
 <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.6pt">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学科<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">门类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">专业名称<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:1;height:15.6pt">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">03</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0304</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">民族学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">030401</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">民族学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:2;height:15.6pt">
  <td rowspan="3" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">04</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0401</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040105</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">艺术教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:3;height:15.6pt">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040106</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学前教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:4;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0403</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="line-height:200%"><span lang="EN-US">040330</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
  &quot;Times New Roman&quot;">装潢设计与工艺教育</span><span style="mso-bidi-font-size:
  10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US"></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:5;height:15.6pt">
  <td rowspan="6" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">05</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">文学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="4" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0501</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">中国语言文学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050101</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">汉语言文学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:6;height:15.6pt">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050102</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">汉语言<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:7;height:15.6pt">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050103</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">对外汉语<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:8;height:15.6pt">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050104</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">中国少数民族语言<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:9;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0502</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">外国语言文学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:10;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0503</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">新闻传播学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:11;height:15.6pt">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">06</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0601</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">060105T</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">文物保护技术<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:12;height:15.6pt">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">07</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">理学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0705</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">地理学科类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">070502</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">自然地理与资源环境<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:13;height:15.6pt">
  <td rowspan="7" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">08</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">工学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0804</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">材料类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">080410T</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">宝石及材料工艺学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:14;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0807</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">电子信息类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">080701</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">广播电视工程<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:15;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0810</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">土木类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:16;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0812</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">测绘类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:17;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0816</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">纺织类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:18;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0817</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">轻工类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:19;height:15.6pt">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0820</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">航空航天类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:20;height:15.6pt">
  <td rowspan="2" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">09</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">农学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0905</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">林学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">090501</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">林学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:21;height:15.6pt">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">090502</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">园艺<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:22;height:15.6pt">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1010</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学技术类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101003</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学影像学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:23;mso-yfti-lastrow:yes;height:15.6pt">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .25pt;mso-border-alt:
  solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:15.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">12</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">管理学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1209</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">旅游管理类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .25pt;mso-border-left-alt:solid windowtext .25pt;
  mso-border-alt:solid windowtext .25pt;padding:0cm 5.4pt 0cm 5.4pt;height:
  15.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span lang="EN-US">120904T</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
  &quot;Times New Roman&quot;">旅游管理与服务教育</span><span style="mso-bidi-font-size:
  10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US"></span></p>
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

<p class="MsoNormal" style="line-mso-outline-level:1"><b><span lang="EN-US">030401</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">民族学（</span><span lang="EN-US">03</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">法学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">以</span><span lang="EN-US"><a href="http://baike.baidu.com/view/2907.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">民族</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">为研究对象的</span><span lang="EN-US"><a href="http://baike.baidu.com/view/145919.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">学科</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">。它把民族这一族体作为整体进行全面的考察，研究民族的起源、发展以及消亡的过程，研究各族体的</span><span lang="EN-US"><a href="http://baike.baidu.com/view/4844.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">生产力</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">和生产关系、经济基础和上层建筑。它是</span><span lang="EN-US"><a href="http://baike.baidu.com/view/50546.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">社会科<span lang="EN-US">学</span></span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">中一门独立学科。属于法学类，专业代码：</span><span lang="EN-US">030401</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">对原始社会史的研究。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">对民族起源问题的研究。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">人类学（指体质人类学）与民族学的相结合。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">重视对国外民族的研究。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">对西方民族学的批评。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">重视对民族学理论问题的研究。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">7.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">对物质文化和精神文化进行了十分细致的研究</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">8.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">对经济文化类型和历史民族区的研究。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">040330</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">装潢设计与工艺教育（</span><span lang="EN-US">04</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">教育学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">专业名称：装潢设计与工艺教育</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：</span> <span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">教育学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业代码：</span><span lang="EN-US">040330</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">课程设置：素描，色彩写生，平面构成，色彩构成，立体构成，装饰画，标志设计，书籍装帧，装潢</span><span lang="EN-US">CAD</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">，广告设计，包装设计，室内设计，</span><span lang="EN-US">CI</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">设计等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要实践性教学环节有：艺术实践、专业实习、教育实习、艺术考察、毕业论文、毕业创作等。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标编辑装潢设计与工艺教育专业的学生主要学习艺术设计方面的基本理论和基本知识，使学生通过艺术设计理论思维能力，造型艺术基础及设计原理与方法的基本训练，具有了解艺术设计的历史现状和进行理论研究、创新设计的基本素质。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">通过学习，将具备以下几方面的能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、掌握装潢设计与工艺教育基础理论、基本知识和基本技能；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、熟练装璜设计与工艺专业所需的相应的计算机技能及运用技巧；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、应了解国内外设计艺术与工艺教育发展的前沿动态，具备审美鉴赏和设计艺术的创作能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握科学的教育理论、教学方法和现代化教育技术手段，接受教师基本素质和基本能力的训练，胜任中等学校的美术教学工作；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有独立思考的能力和创新能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">广东技术师范学院（</span><span lang="EN-US">10588</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、吉林工程技术师范学院（</span><span lang="EN-US">10204</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、湖南师范大学（</span><span lang="EN-US">10542</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、内蒙古农业大学（</span><span lang="EN-US">10129</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、河南科技学院（</span><span lang="EN-US">10467</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、云南民族大学（</span><span lang="EN-US">10691</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、华中师范大学汉口分校（</span><span lang="EN-US">11800</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">广东海洋大学寸金学院（</span><span lang="EN-US">12622</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">）、河南科技学院新科学院（</span><span lang="EN-US">13506</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、北京理工大学珠海学院（</span><span lang="EN-US">13675</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、华中师范大学（</span><span lang="EN-US">10511</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、陕西师范大学（</span><span lang="EN-US">10718</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、河北师范大学（</span><span lang="EN-US">10094</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、鲁东大学（</span><span lang="EN-US">10451</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">050103</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">对外汉语（</span><span lang="EN-US">05</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">文学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：中国语言文学、外国语言文学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：基础英语、英语写作、英汉翻译、现代、古代汉语、中国文学、外国文学、中国文化通论、西方文化与礼仪、国外汉学研究；语言学概论、对外汉语教学概论等、计算机辅助教学。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要实践性教学环节：包括参观访问、社会调查和教学实习等，一般安排</span><span lang="EN-US">8</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">周左右。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：文学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：汉语言文学汉语言中国少数民族语言文学古典文献中国语言文化应用语言学华文教育文秘</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养要求：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业学生主要学习语言学和第二语言教育的基本理论，掌握扎实的汉语言文学基本理论和知识，受到中国文学、比较文学、英语语言文学、中西比较文化等方面的基本训练，熟练地掌握英语，具有从事语言或文化研究的基本能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业生应获得以下几方面的知识和能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握汉语言文学学科的基本理论和基本知识，对有关的社会科学、人文科学与自然科学有一定的了解</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span lang="EN-US">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、掌握对外汉语教学的基本理论与方法，能进行课堂与教学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有相应的社会调查研究能力、一定的创造性思维能力和初步从事科学研究的能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span lang="EN-US">4</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、有较全面的英语听、说、读、写、译的能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解对外交往的有关方针、政策和法规，具有一定的外事活动能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解本学科的理论前沿、应用前景与发展动态。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养学生熟练运用汉语的能力，掌握相应的语言要素、言语技能，使其具备扎实的汉语基础知识和一定的专业理论与基本的中国人文知识，成为熟悉中国国情和文化背景的适应现代国际社会需求的全面发展的应用汉语人才。本专业注重汉英（或另一种外语或少数民族语言，则以下有关用语作相应调整）双语教学，培养具有较扎实的汉语和英语基础，对中国文学、中国文化及中外文化交往有较全面了解，有进一步培养潜能的高层次对外汉语专门人才；</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">对外汉语专业为国家控制布点的专业，开设有此专业的高校有北京外国语大学、北京语言大学、北京第二外国语学院、湖南师范大学、华东师范大学、上海财经大学、上海外国语大学、上海师范大学、南京师范大学、四川外语学院、天津外国语大学、浙江大学、浙江师范大学、华东师范大学、四川大学、中山大学、暨南大学、山东大学、南京晓庄学院、河南师范大学、中原工学院、西北大学、黑龙江大学、东北农业大学，陕西师范大学、西安外事学院、贵州师范大学、广西师范大学、广西大学等。北京语言大学是我国进行对外汉语教学最著名的高校，是专门承担对外汉语教学的大学，在我国设立对外汉语本科专业，学校的老师大都在国外从事过汉语教学工作。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">060105T</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">文物保护技术（<span lang="EN-US">06</span>历史学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">文物保护技术（代码：</span><span lang="EN-US">060106T</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）属于历史学大类，考古学类。文物保护技术专业是目前我国高等学校中惟一的文物保护技术本科专业，最早由西北大学于</span><span lang="EN-US">1989</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年创办。该专业教育的特点是文、理科交叉与理、工科渗透，现代科学技术与人文科学知识相结合。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干课程</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">文物保护导论、无机化学及实验、有机化学及实验、分析化学及实验、普通物理学、中国</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">考古学通论、中国古代史、文物学概论、博物馆学概论、科技考古学（国家精品课程、陕西省精品课程）、无机质文物保护、有机质文物保护、土遗址保护、文物保</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">护材料学、文物修复与保护实验、古建筑保护与维修、文物分析技术、文物与环境等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">课程设置</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">文物保护导论、无机质文物保护、有机质文物保护、土遗址保护概论、文物保护材料学、文物材质分析、文物保护与修复实验、古建筑保护、壁画保护、馆藏文物与环境、田野考古技术、低温技术与应用、计算机原理及应用、管理信息系统、网络应用基础、普通物理学、工程力学、高等数学、无机化学、有机化学、分析化学、中国古代史、中国考古学通论、文物学概论、博物馆学概论等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">历史学（</span><span lang="EN-US">060101</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、世界历史（</span><span lang="EN-US">060102*</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、考古学（</span><span lang="EN-US">060103</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、博物馆学（</span><span lang="EN-US">060104</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、民族学（</span><span lang="EN-US">060105*</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、文物保护技术（</span><span lang="EN-US">060106W</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、社会学（</span><span lang="EN-US">030301*</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业旨在培养能正确掌握文物保护所必需的文史及数理化等学科基础知识，掌握一般文物学、博</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">物馆学、考古学的基本知识；正确掌握文物保护技术的基本理论、一般程序、方法步骤，正确进行实际操作，具备一般文物保护技术的科研能力。能从事文物保护科学研究和实际工作，以及专业管理方面的文、理、工相互交叉的高级综合性专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">通过学习，将具备了以下几方面的能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、掌握数理化等学科的基本知识和历史、文物考古的一般知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握文物保护材料应用、文物材质分析和文物保护修复等实际操作技能；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、对社会科学、人文科学、自然科学都有一定的了解；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有较强的创新意识、创新能力和实践能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有从事历史文物研究的初步能力和较强的口头表达和文字表达能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">北京大学（</span><span lang="EN-US">10001</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">）、西北大学（</span><span lang="EN-US">10697</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）、首都师范大学、同济大学、吉林大学、中国防卫科技学院、西北民族大学、哈尔滨师范大学、山西大同大学</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">070502</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">自然地理与资源环境（<span lang="EN-US">07</span>理学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：地理学<span lang="EN-US">,</span>环境学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">相关学科：生态学、规划学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：地质学、自然地理学、国土规划、地图学、遥感应用、管理科学、环境科学、环境监测、环境经济学、土地评价与土地管理、资源学、水资源计算与管理、景观生态学、生态环境规划、环境化学、地理信息系统、计量地理学、地质学、地貌学地理信息系统、遥感与数字图像处理。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要包括课堂实践、专业实习、课程设计、课程实习（含长短途）四个环节<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">课堂实践<span lang="EN-US">:</span>地球概论实验、地图学实验、地质学实验、地图学实验、物理实验、化学实验、综合自然地理实验、水环境化学实验、水力学实验、微生物及水生生物学实验、仪器分析实验等<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">专业实习<span lang="EN-US">:</span>水环境与水生态监测及分析、水生态保护与修复实习、水土保持原理与技术实习等<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">课程设计<span lang="EN-US">:</span>工程水文学课程设计、水资源评价与管理课程设计等<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">课程实习<span lang="EN-US">:</span>测量教学实习、地质地貌认识实习、地图学教学实习、区域资源调查实习、地理信息系统应用实习、遥感实习、地理专业实习等<b><span lang="EN-US"></span></b></span></p>

<p class="MsoNormal" style="text-indent:0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US"><img src="http://static.ebanhui.com/edu/images/rewgh.png" style="width:700px"></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">­­</span></b><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具备自然地理与资源环境的基本理论、知识和技能，具有创新意识和实践能力，接受严格科学思维和训练和良好的专业技能训练，具有一定的开展科学研究的能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">立足于地球表层特征及其变化、自然资源管理、环境保护、</span><span lang="EN-US">3S</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">技术，能在企事业单位从事自然地理过程、环境变化研究和资源管理、环境保护或应用的高素质复合型专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">推荐院校：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">北京：北京师范大学、北京大学、北京林业大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">天津：天津师范大学、天津理工大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">上海：上海师范大学、华东师范大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">江苏：南京信息工程大学、江苏师范大学、南京大学、南京师范大学、盐城师范学院、南通大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">云南：云南大学、云南师范大学、玉溪师范学院<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">西藏：西藏大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">陕西：西北大学、陕西师范大学、长安大学、西安科技大学、宝鸡文理学院<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">甘肃：兰州大学、甘肃农业大学、西北师范大学、天水师范学院<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">青海：青海师范大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">新疆：新疆大学、石河子大学、新疆师范大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">080410T</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">宝石及材料工艺学（<span lang="EN-US">08</span>工学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干课程：材料科学概论、地质学基础、结晶学与矿物学、岩石学（含晶体光学）、物理化学、宝石鉴定原理和方法、宝石加工学、宝石包裹体，有色宝石学、钻石学、材料工艺学、宝石改善、晶体生长与合成宝石、中国玉器概论、宝石商贸等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">该专业的主要实践性教学环节包括：计算机课程设计、地质认知实习、珠宝认知实习、宝石加工实习、宝石鉴定综合实习、珠宝商贸见习、首饰设计课程采风、生产实习、毕业设计等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">宝石及材料工艺学专业是培养适应社会主义现代化建设需要，德、智、体、美全面发展，具备宝石及材料工艺学专业的科学理论、基本知识和较强的实践技能，基础扎实、知识面宽、能力强、素质高，富有创新精神和实践能力，能在宝石及材料工艺学专业领域和部门从事教学、鉴定、质量评价、分级、定价、款式设计、首饰加工、改善、宝石合成及优化、贸易、市场营销和资产评估等方面工作的高素质应用型人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">知识技能：通过学习，将具备以下几方面的能力：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有扎实的外语和计算机基础，掌握一定的人文社科与自然科学基本理论与基本知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、系统掌握宝石学的基本理论和基本知识，掌握与宝石学相关的知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握宝石学的基本研究方法，初步具有独立进行宝石学科学研究的能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、掌握宝石鉴定的基本技能，具有宝石鉴定和检测的初步能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握美术设计基本原理和方法，具有从事首饰设计的初步能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握宝石加工、首饰制作的基本原理和技能，具有珠宝生产加工的初步能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">7</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握一定的商贸管理知识，了解珠宝商贸或珠宝生产经营管理的方法。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">推荐院校：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">天津商业大学</span> <span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">中国地质大学（武汉）</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">昆明理工大学</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">长春工程学院</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">桂林理工大学</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">石家庄经济学院</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">上海建桥学院</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">中国地质大学（北京）</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">中国地质大学长城学院</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">华南理工大学广州学院</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">山东轻工业学院</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">中国地质大学江城学院</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">中国地质大学长城学院</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">华南理工大学广州学院</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">同济大学同科学院</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">金陵科技学院</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">陕西服装工程学院</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">090502</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">园艺（<span lang="EN-US">09</span>农学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：园艺学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干课程：植物学、生物化学、植物生理学、植物生理与生物化学、应用概率统计、遗传学、土壤学、农业生态学、园艺植物育种学、园艺植物栽培学、园艺植物病虫害防治学、园艺产品贮藏加工、农业气象学、微生物与植物病原学、植物病理学、昆虫学、植物生物技术导论、分子生物学导论、计算机农业应用、园艺作物育种学、园艺作物栽培学、设施园艺学、园艺商品学、园艺产品采后与营销等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要实践性教学环节：包括教学实习、生产实习、课程设计、毕业论文</span><span lang="EN-US">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业设计</span><span lang="EN-US">)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、科研训练、生产劳动、社会实践等，一般安排不少于</span><span lang="EN-US">30</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">周。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：农学学士</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具备扎实的数学、物理、化学等基本理论知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握生物学和园艺学的基本理论、基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握园艺场</span><span lang="EN-US">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">园</span><span lang="EN-US">)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">的规划设计、园艺作物栽培、种质资源保护、品种选育和良种繁育、病虫草害防治、园艺产品商品化处理等方面技能；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、熟悉农业生产、农村工作和与园艺植物生产相关的有关方针、政策和法规；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具备农业可持续发展的意识和基本知识，了解园艺生产和科学技术的科学前沿和发展趋势；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握科技文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">101003</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">医学影像学（<span lang="EN-US">10</span>医学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业名称：医学影像学专业</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">学</span> <span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">科：医学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">门　</span> <span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">类：临床医学与医学技术类</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：五年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：医学学士</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：基础医学、临床医学、医学影像学。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：物理学、电子学基础、计算机原理与接口、影像设备结构与维修、医学成像技术、摄影学、人体解剖学、诊断学、内科学、影像诊断学、影像物理、超声诊断、放射诊断、核素诊断、介入放射学、核医学、医学影像解剖学、肿瘤放疗治疗学、</span><span lang="EN-US">B</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">超诊断学。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具有基础医学、临床医学和现代医学影像学的基本理论知识及能力，能在医疗卫生单位从事医学影像诊断、介入放射学和医学成像技术等方面的医学高级专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握基础医学、临床医学、电子学的基本理论、基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握医学影像学范畴内各项技术</span><span lang="EN-US">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">包括常规放射学、</span><span lang="EN-US">CT</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、核磁共振、</span><span lang="EN-US">DSA</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、超声学、核医学、影像学等</span><span lang="EN-US">)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">及计算机的基本理论和操作技能；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有运用各种影像诊断技术进行疾病诊断的能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、熟悉有关放射防护的方针，政策和方法，熟悉相关的医学伦理学；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解医学影像学各专业分支的理论前沿和发展动态；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握文献检索、资料查询、计算机应用的基本方法，具有一定的科学研究和实际工作能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><b><span lang="EN-US">120904T</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">旅游管理与服务教育（</span><span lang="EN-US">12</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">管理学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">旅游管理与服务教育</span><span lang="EN-US">[</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">分三个方向：旅游教育（师范）、景观规划与设计、策划营销（非师范），</span><span lang="EN-US">2+2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">培养模式，即前两年进行专业基础教育，后两年分方向培养，文理兼招</span><span lang="EN-US">]</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">本专业</span><span lang="EN-US">2007</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">年由国家教育部批准为第一批国家级特色建设专业。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：管理学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业代码：</span><span lang="EN-US">040331</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业优势：专业分三个方向：（</span><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）旅游教育方向：以中等专业学校教师和学生考研深造为主要培养方向，注重于基础理论的学习，以培养专业基础扎实、教学实践和教学适应能力强、综合性知识储备丰富、具有较高人文素养的高素质人才为中心。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">（</span><span lang="EN-US">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）景观规划与设计方向：培养能从事旅游区规划、旅游景观设计、城市绿地规划、风景园林设计方面等工作，具有相应的专业理论基础，具备现代设计意识和创新能力的旅游应用型设计专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">（</span><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）策划营销方向：通过系统的旅游及其它基本理论和营销策划基础知识的学习，接受相关市场营销及产品策划和创意的技能训练，并通过与企业合作进行实践，培养掌握旅游和其它行业营销与策划的基本技能和基本思维方法，专业素养好，并具有开拓创新精神，能在旅游企事业单位、进行产品推广的企业或企业部门、以及相关部门，从事旅游及其它行业的营销和产品策划的复合型人才。职业师范本科，学制四年，授予管理学学士学位。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">课程设置：主要课程</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">经济学、管理学、旅游学概论、区域旅游规划、酒店管理、旅游教学论、教育实习等旅游教育方向类课程；市场营销学、消费心理学、电子商务、项目策划、企业营销训练等旅游营销策划方向类课程；设计素描、色彩构成、建筑学基础、工程制图、城市规划原理、绿地系统规划、景区规划、景观设计等旅游景观规划设计与管理方向类课程。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">特色课程</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">旅游学概论、形体训练、旅游地理学、旅游资源学、旅游英语、饭店经营管理概论、饭店管理实务、旅游经济学、旅游心理学、旅行社经营管理概论、旅游接待礼仪、东南亚概况、第二外语、旅行社管理实务、导游基础知识、导游业务、教育心理学、教育学等。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具有扎实旅游管理与服务专业理论基础，掌握旅行社、星级酒店等旅游企业实际操作能力，掌握教育理论和教育方法，实践能力强，综合素质高，能在旅行社、星级酒店、旅游行政管理部门及相关旅游企业从事服务与经营管理、并能够在中、高等职业技术学校从事教学工作“一体化”教师的高级应用型专门人才，学业合格授予管理学学士学位。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US"><a href="http://baike.baidu.com/view/16724.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">浙江师范大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1496672.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">重庆理工大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/4495.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">山西大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/19504.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">山西师范大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/18528.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">山西财经大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/20913.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">太原师范学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/4670.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">云南师范大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/4850.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">云南民族大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/266812.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">楚雄师范学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/36446.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">内蒙古财经学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/8859.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">河北师范大学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/209741.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">广东<span lang="EN-US">技术师范学院</span></span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/113455.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">兰州城市学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/245785.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">河北师范大学汇华学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/218948.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">延安大学西安创新学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">等。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-align:center;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%" align="center"><b><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:red;
mso-font-kerning:0pt">使用帮助<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.1pt;
mso-char-indent-count:2.0;line-mso-outline-level:1" align="left"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">①专业选择测试为什么有六种职业兴趣类型？<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">根据我国具体国情，研发团队做了大量扎实的研究工作，经过反复验证，得出我国高中学生职业兴趣的七个类型，并将它们命名为：艺术型、传统型、管理型、研究型、现实型、社会型。这几种职业兴趣类型与霍兰德职业兴趣理论的六种类型相似，兴趣是人们活动的巨大动力，凡是具有职业兴趣的职业，都可以提高人们的积极性，促使人们积极地、愉快地从事该职业，且职业兴趣与人格之间存在很高的相关性。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp; </span><b><span style="mso-spacerun:yes">&nbsp;</span></b></span><b><span style="font-family:宋体;
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
mso-hansi-font-family:&quot;Times New Roman&quot;">因此，我们说“专业选择测试”可以准确而有效的测量学生的兴趣和能力特点，并为学生在专业选择方面提供合理建议。</span><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-align:center;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%" align="center"><b><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:red;
mso-font-kerning:0pt">考高志愿填报指导<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#333333;
background:white">　</span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　虽然离高考志愿填报还有几个月时间，但是经验丰富的志愿咨询专家以及过来人们普遍认为，高考关系到未来的学业和职业生涯，那种准备用几天时间就搞定志愿填报的想法，是极不负责的，且容易出现失误。考生和家长有必要提前收集院校专业信息，了解最新政策变化和录取规则，并对自身实力、兴趣进行详细的分析，以最充分的准备进行高考志愿的填报。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　如果把高考当成一场战争的话，孩子是冲锋陷阵的战士，而家长就应是谋定战局的高参，这场战争的输赢不仅仅要依靠孩子的作战能力——即高考成绩，更需要家长提前谋划战争的布局，充分考虑孩子的成绩定位，填报志愿的方向，未来的就业等等因素。只有这样才能对孩子当下的高考之战以及未来的人生之战有一个理智、准确、全面、长远的“战略规划”，赢得一场对以后人生至关重要的战役。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　然而能谋划好毕竟是少数。因为成年人解决问题主要依靠其固有的经验、阅历及社会关系，而高考及其志愿填报对于绝大部分家长来说都是第一次，而第一次做事最易出错。又因其影响重大，身边人很难或是不敢轻易提供意见。在这事情上每个家庭都没有试错的机会，否则代价太大</span><span lang="EN-US">!</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">况且还面临着以下三大因素的影响：</span></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　<b>　①评判大学、专业实力的指标及方法已发生巨大变化</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　现在的高三家长很多是在</span><span lang="EN-US">80</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年代上的大学，当时的大学有重点大学和普通大学之分，但差别不明显，都是国家包分配，大家的工资也一样。当时重点大学毕业的进国家机关、大型国有企业，普通大学毕业的进市机关、市属企业，经过这么多年的发展，大家的事业各有千秋，差别不大。但目前的情况发生了变化，大学有了一本、二本、三本之分，还有提前批，即使一本的学校还分</span><span lang="EN-US">985</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大学、</span><span lang="EN-US">211</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">大学等。本地一本招生的学校，在外地可能是二本</span><span lang="EN-US">;</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">本地的二本，也可能是外地的一本学校。专业学科选择涉及国家重点学科、国家重点实验室、基地班等指标，有的学科有一级学科博士授予权，有的是二级学科授予权，有的名牌大学开设的专业竟然也没有博士授予权，甚至赶上学生毕业时，当初的专业取消了。现在选择的大学、专业对今后就业、考研、出国都有影响，这是我们孩子人生规划的第一步，而不仅仅是挑几所大学、选几十个专业那么简单。我们看到的高考失败好像就是复读，这只是显性的，还有隐性的，调查显示在校大学生</span><span lang="EN-US">65%</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">以上会觉得大学不合适或专业选择不合适，有的孩子一入学就后悔了，有的到大三、大四的时候才明白。</span></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
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

<p class="MsoNormal" style="line-mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　<b>　③家长对高校专业设置认识模糊，视野不宽，存在很多误区</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　有的家长认为金融学、计算机属于热门专业，盲目地给孩子填报这些专业。其实，这些专业的基础是数学，如果孩子的数学成绩不理想，就读这些专业会很吃力。还有的家长想让孩子以后当新闻记者和新闻编辑，给孩子填报新闻专业。其实，中央级、省级的新闻单位都是从其他专业挑选文字功底好的学生，培养成具有某一学科背景和深度见解的新闻人才。此外，热门专业并不一定是优势专业。比如财经类、金融类属于热门专业，北京化工大学招收这两类专业，招收的分数也不低，其实该校的优势学科专业是化学工程与工艺及高分子材料与工程专业。这两个专业虽相对冷门，但就业非常有优势，薪金待遇和发展前景都很好。像这种类似的专业设置和专业就业前景，家长往往不知情，这就需要提前为填报志愿做足准备，只有“门儿清”才能摸得着门道。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">按“分数报志愿”是个错误，可能导致选择失误</span><span lang="EN-US">!</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大学是按排名来录取的，不仅一本、二本、三本线是由排名来划定而最终得出批次线，高校在招生时也是以排名来划定投档线和录取线。高考试题的难易每年都有变化，不同年份的分数没有可比性，单纯的考生成绩是没有任何参考意义的。家长如果以“分数报志愿”，往往会造成定位的不准确，出现偏离甚至严重的失误。一些高校录取还会出现大小年现象，影响当年的录取排名。往年的录取数据你不会一两天就弄明白，需要花很多时间、精力去研究，这样才能报得科学，你还有可能“中大奖”，低分进入名牌大学。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;line-height:200%">
<span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
mso-bidi-font-family:&quot;Times New Roman&quot;;mso-font-kerning:1.0pt;mso-ansi-language:
EN-US;mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA">高考志愿填报对于每个毕业生来说都是人生中的大事，</span><span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
mso-fareast-font-family:宋体;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;
mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA"> </span><span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:
&quot;Times New Roman&quot;;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;mso-fareast-language:
ZH-CN;mso-bidi-language:AR-SA">不论是学生家长、高中学校、各个高校、社会都参与进来，对高考毕业生产生或多或少的影响，这个时候，在考虑个人利益的同时也应当负责任地为高考生提供正确信息。每个高考生学会科学填报，减少失误，为今后更好的发展铺下坚固的基石。希望这份测试报告为能够为你提供一点参考。</span><span style="font-size:10.5pt;mso-bidi-font-size:12.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
mso-fareast-font-family:宋体;mso-font-kerning:1.0pt;mso-ansi-language:EN-US;
mso-fareast-language:ZH-CN;mso-bidi-language:AR-SA" lang="EN-US">
<span style="mso-spacerun:yes">&nbsp; </span></span>
</p>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>
