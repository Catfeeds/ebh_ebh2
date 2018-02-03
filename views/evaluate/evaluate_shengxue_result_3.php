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
<p class="MsoNormal" style="mso-margin-top-alt:auto;text-align:center;
line-mso-pagination:widow-orphan;mso-outline-level:1" align="center"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:red;mso-font-kerning:0pt">测试结果</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"></span></b></p>

<p class="MsoNormal" style="mso-margin-top-alt:auto;text-align:left;
text-indent:21.0pt;mso-char-indent-count:2.0;line-mso-pagination:
widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt;font-weight:bold">研究型：</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">喜欢观察、学习、研究、分析、评估和解决问题。这种人有强烈的好奇心，重分析，好内省。比较慎重。他们喜欢从事有观察、有科学分析的创造性活动和需要钻研精神的职业。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">可参考填报：<b>哲学</b>：哲学类所有专业<span lang="EN-US">;</span><b>经济学</b>：保险、金融工程、税务、网络经济学<span lang="EN-US">;</span><b>法学：</b>马克思主义理论类所有专业、社会学类所有专业、公安学类所有专业<span lang="EN-US">;</span><b>教育学</b>：教育学、学前教育、教育技术学、小学教育、艺术教育、人文教育、社会体育<span lang="EN-US">;</span><b>文学</b>汉语言文学、古典文献、外国语言文学类<span lang="EN-US">;</span><b>历史学</b>：历史学、世界历史、考古学、博物馆学、文物保护技术<span lang="EN-US">;</span><b>管理学</b>：管理科学、信息管理与信息系统、工商管理、市场营销、会计学、财务管理、人力资源管理、物流管理、行政管理、劳动与社会保障、农林经济管理、农村区域发展、档案学<span lang="EN-US">;</span><b>理学</b>：理学类所有专业<span lang="EN-US">;</span><b>工学</b>：工学类所有专业<span lang="EN-US">;</span><b>农学</b>：农学类所有专业<span lang="EN-US">;</span><b>医学</b>：基础医学、临床医学、眼视光学、康复医学、精神医学、中医学类所有专业、药学类所有专业。</span></p>
<div class="MsoNormal">
<table width="710" height="924" border="1" cellpadding="0" cellspacing="0" class="MsoNormalTable" style="border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
 mso-border-alt:solid windowtext .5pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
 mso-border-insideh:.5pt solid windowtext;mso-border-insidev:.5pt solid windowtext">
 <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学科<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">门类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">专业名称<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:1">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">01</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0101</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:2">
  <td rowspan="4" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">02</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">经济学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0201</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">财政学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020201</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">经济学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:3">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0202</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">财政学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020202</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">税收学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:4">
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0203</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">金融学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020302</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">金融工程<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:5">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">020303</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">保险学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:6">
  <td rowspan="3" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">03</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0303</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">社会学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:7">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0305</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">马克思主义理论类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:8">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0306</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">公安类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:9">
  <td rowspan="7" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">04</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="6" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0401</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040101</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:10">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040104</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育技术学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:11">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040106</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学前教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:12">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040103</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">人文教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:13">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040107</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">小学教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:14">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040105</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">艺术教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:15">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0402</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">体育学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040201</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">体育学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:16">
  <td rowspan="3" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">05</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">文学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0501</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">中国语言文学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050101</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">汉语言文学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:17">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050105</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">古典文献学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:18">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0502</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">外国语言文学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">外国语言文学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:19">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">06</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0601</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:20">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">07</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">理学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>

 </tr>
 <tr style="mso-yfti-irow:21">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">08</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">工学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:22">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">09</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">农学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:23">
  <td rowspan="5" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1001</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">基础医学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">100101K</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">基础医学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:24">
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1002</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">临床医学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">100201K</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">临床医学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:25">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">100205Tk</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">精神医学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:26">
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1010</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学技术类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101004</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">眼视光学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:27">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101005</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">康复治疗学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:28">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学科<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">门类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">专业名称<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:29">
  <td rowspan="2" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1005</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">中医学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:30;mso-yfti-lastrow:yes">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1007</span><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">药学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
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

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">010101</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">哲学（</span><span lang="EN-US">01</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">哲学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干课程：哲学概论、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1194935.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">马克思主义哲学原理</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、中国哲学史、西方哲学史、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1032195.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">科学技术哲学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、伦理学、宗教学、美学、逻辑学、心理学、中外哲学原著导读等。主要实践性教学环节：包括社会实习、社会调查、社会公益活动等，一般安排</span><span lang="EN-US">10</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">周左右。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业名称：哲学专业</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：哲学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：工商管理</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">市场营销</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">会计学</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">财务管理</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">人力资源管理</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">旅游管理</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">商品学</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">审计学</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">电子商务</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">物流管理</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">国际商务</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">导游</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">会计电算化</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">汽车营销专业</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业生应获得以下几方面的知识和能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、比较系统地掌握马克思主义哲学、中国哲学和西方哲学的理论和历史；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有一定的社会科学、人文科学、自然科学、思维科学的相关知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、掌握哲学学科的基本研究方法、治学方法和相应的社会调查能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解国内外哲学界最重要的理论前沿和发展动态；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解国内外最重大的实践问题和发展动态；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有分析和解决社会现实问题的初步能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">020302</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">金融工程（<span lang="EN-US">02</span>经济学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：经济学、管理学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：经济学模块；金融学模块；计算机模块；数学与统计模块等四大模块。开设课程有：政治经济学、微观经济学、宏观经济学、计量经济学、货币银行学、金融经济学，金融市场学，证券投资学，衍生金融工具，固定收益证券，公司金融，金融工程学，金融会计、随机过程，时间序列分析，金融统计与分析应用，商业银行经营与管理，保险与精算，博弈论与信息经济学，金融风险管理，投资银行学，国际金融，国际投资，金融法等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">特色方向<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业设有金融产品设计、开发与定价；金融衍生工具与金融风险管理；金融计量与金融决策分析；公司金融与资本运作四个特色专业方向。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">特色课程：金融经济学，固定收益证券，公司金融，衍生金融工具，金融产品定价，金融风险管理，金融工程学，金融会计、随机过程，时间序列分析，金融统计与分析应用等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">学制、学位与毕业<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">学制原则上为<span lang="EN-US">4</span>年。实行弹性学制，亦可在<span lang="EN-US">3</span>—<span lang="EN-US">6</span>年内完成学业。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">按照规定要求完成学业并符合学士学位授予条件者，授予经济学学士学位。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">完成总学分<span lang="EN-US">175</span>学分<span lang="EN-US">(</span>其中课内学分<span lang="EN-US">148</span>，实践环节学分<span lang="EN-US">15</span>，素质教育<span lang="EN-US">12)</span>，方可准予毕业。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业立足于师资力量雄厚的国家级重点学科——金融学学科点，依托经济学、法学、管理学等人文学科综合发展的优势，突出金融、经济、管理、法学互相渗透的特点，把学生培养成熟悉现代经济学的研究范式、掌握现代金融学的基本理论、基本知识和基本技能，具有扎实的数理金融、计量经济学基础，具有较强的本国语言文字表达和写作能力，熟练掌握一门外语和计算机的应用，具有较强市场意识、竞争意识和创新意识的金融工程专才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">通过本专业教学计划所规定内容的系统学习与训练，学生应达到以下培养目标：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">系统掌握马克思主义基本原理、毛泽东思想、邓小平理论及“三个代表”精神实质，认真领会党中央在社会主义市场经济建设过程中的方针、政策，具有良好的政治素养；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">掌握金融工程学的基本理论和基本技术，通晓与金融工程专业密切相关的金融学、会计学、管理学、法学等学科的基本知识，具有合理的知识结构；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">掌握定性分析与定量分析相结合的科学研究方法与技能，具有较强的金融分析、策划能力和金融创新能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">4.</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">了解我国对外方针政策、金融理论前沿和国际金融市场发展动态；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">具有扎实的数学、计量经济学基础，掌握基本的数学建模技巧和进行金融市场实证研究的技能；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">6.</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">具有较强的计算机应用能力，以及获取信息和处理信息的能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">7.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">英语通过国家大学英语六级考试，能熟练地查阅英文文献；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">8.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">具有较强的语言与文字表达能力，能胜任专业论文、各类应用文体的写作以及较强的商务谈判能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">9.</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">身心健康，达到国家规定的大学生体育锻炼标准。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">030503</span></b><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">思想政治教育（<span lang="EN-US">03</span>法学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：政治学、教育学、法学基本学科<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：马克思主义思想政治教育理论基础、马克思主义哲学、中国哲学史、西方哲学史、中国古代思想政治教育史、西方社会思潮、伦理学、教育学、管理学、<span lang="EN-US">[2] </span>心理学基础、思想政治教育学原理、思想政治教育方法论、思想政治教育史、比较思想政治教育、刑法、国际法、法学概论、思想政治道德观教育、中华人民共和国史等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：包括社会调查、专业实习以及思想政治工作实践<span lang="EN-US">(</span>如学生政治辅导员、少先队辅导员等<span lang="EN-US">)</span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">修业年限：四年<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">授予学位：一般授予法学学位，如果学校加开教育学可授予教育学学位。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">相近专业：中国革命史与中国共产党党史、政治学与行政学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业学生主要学习马克思主义、毛泽东思想、邓小平理论和思想政治教育专业的基本理论和基本知识，受到思想政治教育专业技能与方法的基本训练，掌握从事思想政治工作的基本能力，能在党政机关、学校、企事业单位从事思想政治工作的专门人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">通过学习，毕业生应获得以下几方面的知识和能力：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握思想政治教育专业的基本理论、基本知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握马克思主义的基本原理和科学分析方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有从事思想政治工作的基本能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解党和国家的有关方针、政策和法规；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解思想政治教育学科专业的理论前沿、发展动态；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握文件检索、资料查询的基本方法，具有<span lang="EN-US">-</span>定的科学研究和工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">040104</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">教育技术学（</span><span lang="EN-US">04</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">教育学）</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">学科：教育学二级学科</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">门类：教育学类</span><span lang="EN-US">/</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">计算机类</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业名称：教育技术学</span><span lang="EN-US"> (</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">这里是指中国特色的教育技术学</span><span lang="EN-US">)</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：</span><span lang="EN-US"><a href="http://baike.baidu.com/view/42751.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">教育学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、计算机科学与技术。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：教育技术学、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/182885.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">教学系统设计</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、电子模拟电路、数字模拟电路、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1071560.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">计算机文化基础</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US">C</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">程序语言、</span><span lang="EN-US">VB</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">设计、网页三剑客、动态网站建设、数据库原理与应用、网络教育应用、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/3503.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">多媒体技术</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US">Flash</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">动画设计与制作、现代远程教育、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/3177234.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">电视教材</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">设计与制作、影视艺术、</span><span lang="EN-US">premiere</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">影视制作、教育技术研究方法、教育</span><span lang="EN-US"><a href="http://baike.baidu.com/view/41084.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">传播学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、信息技术与课程整合、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/25482.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">计算机网络</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、软件工程、微机组成原理、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1213308.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">计算机辅助教育</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、企业培训设计、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/333105.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">教学设计</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、教学媒体理论与实践、摄影摄像、校园网建设与维护、机器人设计、教育心理学。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">方向主要有：</span><span lang="EN-US"><a href="http://baike.baidu.com/view/44151.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">教育信息化</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/3323.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">多媒体</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">课件开发、网络教育应用、企业</span><span lang="EN-US"><a href="http://baike.baidu.com/view/73801.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">绩效技术</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、计算机软件开发、影视媒体</span><span lang="EN-US"><a href="http://baike.baidu.com/view/28525.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">编辑</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">等等</span><span lang="EN-US">.</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要</span><span lang="EN-US"><a href="http://baike.baidu.com/view/703596.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">实践性教学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">环节：包括媒体制作实践、课程设计与开发实践、教育实习等，一般安排不少于</span><span lang="EN-US">20</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">周。教育实习（选）、毕业实习、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/21395.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">毕<span lang="EN-US">业设计</span></span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">（论文）、课程设计、技能训练等，并实施大学生创新培养行动计划，开展各种设计、实践活动</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年（</span><span lang="EN-US"><a href="http://baike.baidu.com/view/58666.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">本科</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">）</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：教育学或理学学士</span></p>

<p class="MsoNormal" style="line-mso-outline-level:1"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">培养要求：</span></b><b><span style="mso-ansi-language:ZH-CN"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">本专业学生主要学习教育技术学方面的基本理论和基本知识，接受学习资源和学习过程的设计、开发、运用、管理和评价等方面的基本训练，掌握新技术教育应用方面的基本能力，培养适应新世纪的综合的信息素质人才。</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">本专业学生应获得以下几方面的知识和能力：</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．掌握教育技术学科的基本理论和基本知识；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．掌握教学系统分析、设计、管理、评价的方法和技术；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．具有媒体</span><span style="mso-ansi-language:
ZH-CN">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">幻灯投影、电视电声教材、计算机课件</span><span style="mso-ansi-language:ZH-CN">)</span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:
ZH-CN">制作的基本能力；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">4</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．具备计算机网络设计开发、常用软件熟练应用的能力以及影视编辑制作的能力；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">5</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．具备计算机硬件、局域网等小型网络维护的能力；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">6</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．熟悉国家关于教育、教育技术方面的有关方针、政策、法规；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">7</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．了解教育技术学理论前沿、应用前景、发展动态；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">8</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．掌握文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力。</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">9</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">、现代教育技术在企业培训中的应用。</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">050101</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">汉语言文学（<span lang="EN-US">05</span>文学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：中国语言文学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：语言学概论、现代汉语、古代汉语、中国汉字学、汉语史（或文字、声韵、训诂学）、中外语言学史、语言文字信息处理、中国文化概论、中国古代文学史、中国古代文学作品选、中国古代文论、中国古代文献学、中国现代文学史、中国当代文学史、中国现当代文学作品选、文学概论、马克思主义文论、美学、民间文学、比较文学、世界文学、西方文论、写作、文艺心理学、中国文学批评史、语文教学论、自然科学基础等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：包括教育实习、见习、教育调查、社会调查或毕业论文等，一般安排<span lang="EN-US">15</span>～<span lang="EN-US">20</span>周。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">该专业培养具备文艺理论素养和系统的汉语言文学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">汉语言文学知识，能在新闻文艺出版部门、高校、科研机构和机关企事业单位从事文学评论、汉语言文学教学与研究工作，以及文化、宣传方面的实际工作的汉语言文学高级专门人才。学生主要学习汉语和中国文学方面的基本知识，受到有关理论、发展历史、研究现状等方面的系统教育和业务能力的基本训练。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">毕业生应获得以下几方面的知识和能力：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、掌握马克思主义的基本原理和关于语言、文学的基本理论；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握本专业的基础知识以及新闻、历史、哲学、艺术、教育等学科的相关知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有文学修养、鉴赏文学能力、较强的写作能力以及语言表达能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、了解我国关于语言文字和文学艺术的方针、政策和法规；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解本学科的前沿成就和发展前景；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、能阅读古典文献，掌握文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">7</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有正确的文艺观点、语言文字观点和坚实的汉语言文学基础知识，并具有处理古今语言文字材料的能力、解读和分析古今文学作品的能力、协作能力和设计实施语文教学的能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">8</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解语言文学学科的新发展，并能通过学习，不断吸收本专业和相关专业新的<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">汉语言文学研究成果，根据社会需要和教育发展的需要，拓宽专业知识，提高教学水平，在将新知识引人语文教学的实践中，富有开创精神；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">9</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解本专业及相关专业各学科学术发展的历史，重视传统文化的继承和发展。同时具有一定的哲学和自然科学素养。掌握资料收集、文献普查、社会调查、论文写作等科学研究的基本方法，逐步学会在文理渗透、学科交叉的前提下，开辟新的领域；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、熟悉教育法规，具有初步运用教育学、心理学基本理论和汉语言文学教学基本理论，运用现代教育技术从事教学工作的基本能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">11</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、有良好的口语和书面语表达能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">060102</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">世界史（<span lang="EN-US">06</span>历史学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">除常规教学环节外，本专业适当安排了一些专题讲座、学术报告、学生辩论、演讲比赛、各项体育比赛等活动，主要实践性教学环节包括：参观访问、社会调查，社会公益活动，世界历史学术交流等，一般安排<span lang="EN-US">15</span>周左右，以提高学生综合素质和实际能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">类别：历史学大类<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">历史学类修业年限：四年<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、掌握马克思主义的基本原理和世界历史的基本理论和基础知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解相关的社会科学、人文科学和自然科学知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握世界历史的基本研究方法与分析方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握文献检索、资料查询的基本方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解国内外世界历史学界最重要的理论学术前沿和发展动向趋势；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有从事世界历史研究的初步能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">推荐院校：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业为国家控制布点的专业，国内有<span lang="EN-US">10</span>多所大学开设了世界历史专业，其中排名靠前的院校有：山东大学、北京大学、武汉大学、南开大学、首都师范大学、河南师范大学、河南大学、兰州大学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

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
0pt" lang="EN-US"><img src="http://static.ebanhui.com/edu/images/rewgh.png" style="width:700px;"/></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

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

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">090502</span></b><b><span style="mso-bidi-font-size:10.5pt;line-font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">园艺（<span lang="EN-US">09</span>农学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">090502</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">园艺（</span><span lang="EN-US">09</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">农学）</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span></p>

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

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span></p>

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
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握科技文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力主干课程：植物学、生物化学、植物生理学、植物生理与生物化学、应用概率统计、遗传学、土壤学、农业生态学、园艺植物育种学、园艺植物栽培学、园艺植物病虫害防治学、园艺产品贮藏加工、农业气象学、微生物与植物病原学、植物病理学、昆虫学、植物生物技术导论、分子生物学导论、计算机农业应用、园艺作物育种学、园艺作物栽培学、设施园艺学、园艺商品学、园艺产品采后与营销等。</span></p>

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

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">101004</span></b><b><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">眼视光学（<span lang="EN-US">10</span>医学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">专业名称：眼视光学专业<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">修业年限：<span lang="EN-US"> 5</span>年或<span lang="EN-US">4</span>年<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">授予学位：医学学士或理学士<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">后者不能考执业医师资格证，在医院工作没有专门职称可评<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">医学体系：医学可分为现代医学（即通常说的西医学）和传统医学（包括中医学、藏医学、蒙医学等等）多种医学体系。不同地区和民族都有相应的一些医学体系，宗旨和目的不尽相同。印度传统医学系统也被认为很发达。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">研究领域：研究领域大方向包括基础医学、临床医学、检验医学、预防医学、保健医学、康复医学等等<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基础医学包括：医学生物数、
医学生物化学、 医学生物物理学、 人体解剖学、 医学细胞生物学、 人体生理学、 人体组织学、 人体胚胎学、医学遗传学、 人体免疫学、 医学寄生虫学、 医学微生物学、
医学病毒学、 人体病理学、 病理生理学、 药理学、 医学实验动物学、 医学心理学、 生物医学工程学、 医学信息学、 急救学、护病学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">临床医学包括：
临床诊断学、 实验诊断学、影像诊断学、 放射诊断学、超声诊断学、 核医诊断学、 临床治疗学 、职能治疗学、 化学治疗学 、生物治疗学、 血液治疗学、 组织器官治疗学
、饮食治疗学、 物理治疗学、 语言治疗学、 心理治疗学、内科学、 外科学、 泌尿科学 、妇产科学、 儿科学 、老年医学、 眼科学、 耳鼻喉科学、 口腔医学、 传染病学、
皮肤医学、 神经医学、 精神病学、 肿瘤医学、 急诊医学、 麻醉学、 护理学家庭医学、 性医学、 临终关怀学、 康复医学、 保健医学、 听力学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养具有扎实的医学专业知识及相关自然科学知识，有较强的医学实践和人际交流能力，有良好的职业道德和人文素养，具有创新、创业精神，融医疗、预防、保健、康复为一体的应用型眼视光学人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">推荐院校：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span><a href="http://baike.baidu.com/view/1023497.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">温州医学院眼视光学院</span></span></a><a name="8_1"></a><a name="sub2557868_8_1"></a><a name="开设院校_中山大学"></a><span style="mso-spacerun:yes">&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">中山大学</span><a name="8_2"></a><a name="sub2557868_8_2"></a><a name="开设院校_四川大学"></a><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">四川大学</span><a name="8_3"></a><a name="sub2557868_8_3"></a><a name="开设院校_天津医科大学"></a><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;
</span></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">天津医科大学</span><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span><span style="mso-bidi-font-size:10.5pt;
line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">北京理工大学<span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;
</span></span>上海大学<span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span>沈阳医学院<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="text-align:center;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%" align="center"><b><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:red;
mso-font-kerning:0pt">使用帮助<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.1pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><b><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">①专业选择测试为什么有六种职业兴趣类型？<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">根据我国具体国情，研发团队做了大量扎实的研究工作，经过反复验证，得出我国高中学生职业兴趣的七个类型，并将它们命名为：艺术型、传统型、管理型、研究型、现实型、社会型。这几种职业兴趣类型与霍兰德职业兴趣理论的六种类型相似，兴趣是人们活动的巨大动力，凡是具有职业兴趣的职业，都可以提高人们的积极性，促使人们积极地、愉快地从事该职业，且职业兴趣与人格之间存在很高的相关性。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%" align="left"><span style="mso-bidi-font-size:
10.5pt;line-font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp; </span><b><span style="mso-spacerun:yes">&nbsp;</span></b></span><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">②专业选择测试是否能准确测查个人的兴趣和能力特点？</span> </b></p>

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

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　<b>　①评判大学、专业实力的指标及方法已发生巨大变化</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　现在的高三家长很多是在</span><span lang="EN-US">80</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年代上的大学，当时的大学有重点大学和普通大学之分，但差别不明显，都是国家包分配，大家的工资也一样。当时重点大学毕业的进国家机关、大型国有企业，普通大学毕业的进市机关、市属企业，经过这么多年的发展，大家的事业各有千秋，差别不大。但目前的情况发生了变化，大学有了一本、二本、三本之分，还有提前批，即使一本的学校还分</span><span lang="EN-US">985</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大学、</span><span lang="EN-US">211</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">大学等。本地一本招生的学校，在外地可能是二本</span><span lang="EN-US">;</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">本地的二本，也可能是外地的一本学校。专业学科选择涉及国家重点学科、国家重点实验室、基地班等指标，有的学科有一级学科博士授予权，有的是二级学科授予权，有的名牌大学开设的专业竟然也没有博士授予权，甚至赶上学生毕业时，当初的专业取消了。现在选择的大学、专业对今后就业、考研、出国都有影响，这是我们孩子人生规划的第一步，而不仅仅是挑几所大学、选几十个专业那么简单。我们看到的高考失败好像就是复读，这只是显性的，还有隐性的，调查显示在校大学生</span><span lang="EN-US">65%</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">以上会觉得大学不合适或专业选择不合适，有的孩子一入学就后悔了，有的到大三、大四的时候才明白。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　<b>　②时代不同，高考志愿填报也越来越复杂</b></span></p>

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

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　<b>　③家长对高校专业设置认识模糊，视野不宽，存在很多误区</b></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　有的家长认为金融学、计算机属于热门专业，盲目地给孩子填报这些专业。其实，这些专业的基础是数学，如果孩子的数学成绩不理想，就读这些专业会很吃力。还有的家长想让孩子以后当新闻记者和新闻编辑，给孩子填报新闻专业。其实，中央级、省级的新闻单位都是从其他专业挑选文字功底好的学生，培养成具有某一学科背景和深度见解的新闻人才。此外，热门专业并不一定是优势专业。比如财经类、金融类属于热门专业，北京化工大学招收这两类专业，招收的分数也不低，其实该校的优势学科专业是化学工程与工艺及高分子材料与工程专业。这两个专业虽相对冷门，但就业非常有优势，薪金待遇和发展前景都很好。像这种类似的专业设置和专业就业前景，家长往往不知情，这就需要提前为填报志愿做足准备，只有“门儿清”才能摸得着门道。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">按“分数报志愿”是个错误，可能导致选择失误</span><span lang="EN-US">!</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大学是按排名来录取的，不仅一本、二本、三本线是由排名来划定而最终得出批次线，高校在招生时也是以排名来划定投档线和录取线。高考试题的难易每年都有变化，不同年份的分数没有可比性，单纯的考生成绩是没有任何参考意义的。家长如果以“分数报志愿”，往往会造成定位的不准确，出现偏离甚至严重的失误。一些高校录取还会出现大小年现象，影响当年的录取排名。往年的录取数据你不会一两天就弄明白，需要花很多时间、精力去研究，这样才能报得科学，你还有可能“中大奖”，低分进入名牌大学。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">高考志愿填报对于每个毕业生来说都是人生中的大事，</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">不论是学生家长、高中学校、各个高校、社会都参与进来，对高考毕业生产生或多或少的影响，这个时候，在考虑个人利益的同时也应当负责任地为高考生提供正确信息。每个高考生学会科学填报，减少失误，为今后更好的发展铺下坚固的基石。希望这份测试报告为能够为你提供一点参考。</span><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span></p>

</div>
</div>
<?php $this->display('myroom/page_footer'); ?>