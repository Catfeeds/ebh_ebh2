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
mso-pagination:widow-orphan;mso-outline-level:1" align="center"><b style="mso-bidi-font-weight:
normal"><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:
宋体;mso-bidi-font-family:宋体;color:red;mso-font-kerning:0pt">测试结果<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="mso-margin-top-alt:auto;text-align:left;
text-indent:21.1pt;mso-char-indent-count:2.0;line-height:200%;mso-pagination:
widow-orphan" align="left"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">传统型：</span></b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">喜欢从事资料工作，有写作或数理分析的能力，能够听从指示，完成琐细的工作。这种人易顺从，能自我抑制，想象力较差，喜欢既定、有秩序的环境。在职业选择上，他们愿意从事那些需要按照既定要求工作的、比较简单而又比较刻板的职业。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%;mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">可参考填报：<b>哲学</b>：逻辑学<span lang="EN-US">;</span><b>经济学</b>：经济学类所有专业<span lang="EN-US">;</span><b>法学</b>： 法学类所有专业、政治学与行政学、国际政治<span lang="EN-US">;</span><b>教育学</b>：人文教育、特殊教育<span lang="EN-US">;</span><b>文学</b>：中国语言文学类所有专业<span lang="EN-US">;</span><b>历史学</b>：历史学类所有专业<span lang="EN-US">;</span><b>管理学</b>：会计学、财务管理、电子商务、物流管理、劳动与保障、土地资源管理、农林经济管理、农村区域发展、图书馆学、档案学<span lang="EN-US">;</span><b>理学</b>：理学类所有专业<span lang="EN-US">;</span><b>工学</b>：仪器仪表类、能源动力类、电气信息类、水利类、测绘类、化学与制药类、交通运输类、海洋工程类、航空航天类、武器类、工程力学类、生物工程类、农业工程类、森林工程类、公安技术类所有专业<span lang="EN-US">;</span><b>农学</b>：农学类所有专业<span lang="EN-US">;</span><b>医学</b>：医学类所有专业。<span lang="EN-US"></span></span></p>
<div class="MsoNormal" style="line-height:200%">
<table width="710" height="731" border="1" cellpadding="0" cellspacing="0" class="Table" style="border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
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
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">01</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
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
  mso-font-kerning:0pt" lang="EN-US">010102</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">逻辑学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:2">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
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
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:3;height:14.6pt">
  <td rowspan="2" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.6pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">03</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.6pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0301</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">法学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.6pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
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
  mso-font-kerning:0pt" lang="EN-US">030201</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">政治学与行政学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:5;height:13.85pt">
  <td rowspan="2" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.85pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">04</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.85pt" valign="top" width="193">
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
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.85pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040103</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">人文教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:6">
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
 <tr style="mso-yfti-irow:7">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">05</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">文学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0501</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">中国语言文学类<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:8">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">06</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0601</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">060101</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">历史学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:9">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
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
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:10">
  <td rowspan="7" style="width:114.65pt;border:solid windowtext 1.0pt;
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
  mso-font-kerning:0pt" lang="EN-US">0803</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">仪器类<span lang="EN-US"></span></span></p>
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
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0805</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">能源动力类<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:12">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0807</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">电子信息类<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:13">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0811</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">水利类<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:14">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0812</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">测绘类<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:15">
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
 <tr style="mso-yfti-irow:16">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0830</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">生物工程类<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:17">
  <td style="width:114.65pt;border:solid windowtext 1.0pt;
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
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
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
 <tr style="mso-yfti-irow:18">
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
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
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
  <td rowspan="3" style="width:114.65pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="153">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">12</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">管理学<span lang="EN-US"></span></span></p>
  </td>
  <td rowspan="2" style="width:144.75pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1202</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">工商管理类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">120203K</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">会计学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:20">
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">120204</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">财务管理<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:21;mso-yfti-lastrow:yes">
  <td style="width:144.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="193">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1208</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">电子商务类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:166.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="222">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">120801</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">电子商务<span lang="EN-US"></span></span></p>
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

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">010102</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">逻辑学（</span><span lang="EN-US">01</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">哲学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">要深入认识什么是逻辑学。必须了解逻辑学的研究对象。从总体来说，逻辑学是研究思维的学科。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">思维可以分为内容和形式两个方面。思维形式也叫思维的逻辑形式。思维的逻辑形式和思维的内容是紧密联系的，但为了能够从纯粹的状态中研究思维的逻辑形式，逻辑学可以把思维内容作为无关紧要的东西放到一边，专门研究思维的形式结构。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">思维规律</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">逻辑学研究思维的逻辑形式，目的是为了使人们子啊思维过程中有效的运用各种逻辑形式，正确的认识客观世界，表达和论证思想。为达到此目的，就需要研究思维的逻辑形式本身所特有的规律。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">0201052</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">经济统计学（</span><span lang="EN-US">02</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">经济学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">【专业代码】：</span><span lang="EN-US">020102</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">【授予学位】：经济学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">【修学年限】：</span><span lang="EN-US">4 </span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">【开设课程】：数学分析、高等代数、</span><span lang="EN-US">C</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">语言程序设计、数据库原理及其应用、面向对象程序设计、微观经济学、宏观经济学、统计学原理、经济统计学、金融统计学、多元统计分析、实用回归分析、抽样调查技术、统计预测与决策、风险管理、证券期货投资技术分析、统计软件、国民经济核算等。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、具有坚实的经济学和数学基础；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握统计学的基本理论和方法，具有采集、加工和分析数据的基本能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、具备运用计算机和相关统计软件分析、解决实际问题的能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具备良好的创新意识和开拓精神；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有较强的中、英文综合运用的能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">030201</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">政治学与行政学（<span lang="EN-US">03</span>法学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：政治学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：政治学原理、行政学概论、中国政治制度史、当代中国政治制度、比较政治制度、中国政治思想史、当代西方政治思潮、西方政治思想史、西方政治制度史、西方行政学说史、当代中国政府与政治、当代中国地方政府、中国社会政治分析、比较政党制度、市政学、公共政策概论、行政法学、人事行政学、社会调查与社会统计等<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：包括社会调查、参与课题研究、教学实习等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业学生主要学习政治学、行政学、国际政治学和法学等方面的基础理论和基本知识，受到政治学研究、公共政策分析、社会调查与统计等方面的基本训练，掌握调查研究、分析判断和协调组织等方面的基本能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">毕业生应获得知识和能力<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握马克思主义基本原理和政治学、行政学、国际政治学和法学的基本理论知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握辩证唯物主义和历史唯物主义的基本观点和分析方法，以及系统分析、统计分析、调查分析等科学方法或技术；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有在党政机关、社会团体、新闻出版机构、教育及其他企事业单位从事科研、教学、行政管理以及其他有关专门业务工作的基本能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解有关政治体制、决策过程以及党政管理法律、制度、方针、政策；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解政治学及行政学、法学、国际政治学和管理科学等相关学科的发展动态；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、 掌握文献检索和资料查询的基本方法和手段，具有一定的科学研究和实际工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">推荐院校：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">北京大学、中国人民大学、中国政法大学、厦门大学、中山大学、武汉大学、南开大学、西南交通大学、天津师范大学、湘潭大学、中国青年政治学院、山东大学、西南政法大学、吉林大学、兰州大学、复旦大学、同济大学、云南大学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">040103</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">人文教育（<span lang="EN-US">04</span>教育学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">自然地理、中国地理、世界地理、人文地理、地理教材分析、地理微格教学、中国历史、中国文学史（含中国现当代文学史）、马克思主义哲学原理、世界历史、古代汉语、政治经济学、文学基本原理、史学理论与方法、法学理论与实践、中国古代文献教程、中学人文学科教学论、人文科学概论、中外历史比较研究、中国思想文化史、社会学、现代汉语、地理学概论、心理学、教育学、专业论文写作等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">适应新世纪我国社会发展需要，培养基础扎实、知识结构合理，具有现代教育思想和技能，具有一定理论素养、创新精神和实践能力，既能胜任中学综合文科“人文与社会”课程教学需要，又能适应历史、中文、政治分科教学需要，德、智、体、美全面发展的高级应用人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业的毕业生应当具有宽厚扎实的历史、中文、政治专业基础和较高的综合素质，能够胜任中学语文、历史、政治、人文与社会等课程的教学工作，具备较强的社会适应能力和继续提高和深造的基本条件。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">050101</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">汉语言文学（<span lang="EN-US">05</span>文学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：中国语言文学。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：语言学概论、现代汉语、古代汉语、中国汉字学、汉语史（或文字、声韵、训诂学）、中外语言学史、语言文字信息处理、中国文化概论、中国古代文学史、中国古代文学作品选、中国古代文论、中国古代文献学、中国现代文学史、中国当代文学史、中国现当代文学作品选、文学概论、马克思主义文论、美学、民间文学、比较文学、世界文学、西方文论、写作、文艺心理学、中国文学批评史、语文教学论、自然科学基础等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：包括教育实习、见习、教育调查、社会调查或毕业论文等，一般安排<span lang="EN-US">15</span>～<span lang="EN-US">20</span>周。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">该专业培养具备文艺理论素养和系统的汉语言文学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">汉语言文学知识，能在新闻文艺出版部门、高校、科研机构和机关企事业单位从事文学评论、汉语言文学教学与研究工作，以及文化、宣传方面的实际工作的汉语言文学高级专门人才。学生主要学习汉语和中国文学方面的基本知识，受到有关理论、发展历史、研究现状等方面的系统教育和业务能力的基本训练。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">毕业生应获得以下几方面的知识和能力：<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、掌握马克思主义的基本原理和关于语言、文学的基本理论；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握本专业的基础知识以及新闻、历史、哲学、艺术、教育等学科的相关知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有文学修养、鉴赏文学能力、较强的写作能力以及语言表达能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、了解我国关于语言文字和文学艺术的方针、政策和法规；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解本学科的前沿成就和发展前景；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、能阅读古典文献，掌握文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">7</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、具有正确的文艺观点、语言文字观点和坚实的汉语言文学基础知识，并具有处理古今语言文字材料的能力、解读和分析古今文学作品的能力、协作能力和设计实施语文教学的能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">8</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解语言文学学科的新发展，并能通过学习，不断吸收本专业和相关专业新的<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">汉语言文学研究成果，根据社会需要和教育发展的需要，拓宽专业知识，提高教学水平，在将新知识引人语文教学的实践中，富有开创精神；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">9</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解本专业及相关专业各学科学术发展的历史，重视传统文化的继承和发展。同时具有一定的哲学和自然科学素养。掌握资料收集、文献普查、社会调查、论文写作等科学研究的基本方法，逐步学会在文理渗透、学科交叉的前提下，开辟新的领域；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、熟悉教育法规，具有初步运用教育学、心理学基本理论和汉语言文学教学基本理论，运用现代教育技术从事教学工作的基本能力；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">11</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、有良好的口语和书面语表达能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="text-align:left;line-height:200%" align="left"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">060101</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">历史学（<span lang="EN-US">06</span>历史学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：中国通史、世界通史、史学导论、中国史学史、西方史学史、考古学通论、历史地理学、古代汉语、中外历史文化原典导读与选读、中国断代史<span lang="EN-US">(</span>从先秦到当代<span lang="EN-US">)</span>、专题史<span lang="EN-US">(</span>经济史、社会史、政治制度史、思想文化史等<span lang="EN-US">)</span>、世界各主要国家和地区史<span lang="EN-US">(</span>美、英、法、日、德、俄等国，拉美、非洲、中亚、南亚、东南亚等地区<span lang="EN-US">)</span>、中外关系史等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">历史学专业要求学生学习世界历史的基本知识，了解整体人类文明的一般发展历程和世界历史研究的基本方法，接受史学理论、史料学、历史地理学、国际政治学、国际经济学、国际关系学、外国语及文化人类学等方面的基本训练。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">就业方向一：行政<span lang="EN-US">/</span>后勤<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">行政<span lang="EN-US">/</span>后勤部门就是协助好上级行政领导施政行政<span lang="EN-US">,</span>当好助手。关键是要为领导分忧和服好务<span lang="EN-US">,</span>起到上传下达的作用<span lang="EN-US">!</span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">就业方向二：编辑<span lang="EN-US">/</span>文案<span lang="EN-US">/</span>作家<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">据估算，目前我国拥有网络编辑人员近<span lang="EN-US">300</span>万，而传统媒体有编辑记者<span lang="EN-US">75</span>万人，网络媒体从业人员从数量上远远超过传统媒体。同时，当下网络编辑的学科背景与六年前相比，也有了显著的变化。从<span lang="EN-US">2004</span>年开始，网络媒体从业人员与传统媒体从业人员进行大轮换，网站人力资源结构也趋向多元化方向发展，既有新闻、计算机的专业人才，也有了涉及中文、法律、财经、历史、外语等专业的人员。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">就业方向三：市场<span lang="EN-US">/</span>公关<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">企业通过媒介的介绍、传播，和观众的交流、沟通和互动，在公众面前树立并强化公司的品牌形象，在市场竞争中赢得先机。而在这一系列活动安排中，专业公关是企业的好帮手。　<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">就业方向四：学术<span lang="EN-US">/</span>科研<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">随着知识在经济发展中的作用日益显著，收入分配关系的调整显现出一些新的特征，知识劳动和知识要素正在成为按劳分配的主要依据；知识所依附的主要对象，即高技术、高技能、高素质、责任重、贡献大的人，收入明显提高，高技术、高技能、高素质人才与一般劳动者的薪酬水平的差距，在市场供需调节过程中日渐扩大，科研事业单位中集聚着大批的高科技人才，近些年来，随着我国科技体制改革的日益深入以及人才竞争的日趋激烈，科研事业单位的薪酬制度也处于快速变革之中。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">071002</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">生物技术（<span lang="EN-US">07</span>理学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;
</span></span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">专业名称：生物技术专业<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="line-height:200%"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">修业年限：四年<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">授予学位：理学学士<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">专业代码：<span lang="EN-US">070402</span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主干学科：生物学<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要课程：无机化学、有机化学、分析化学、植物学、动物学、生物化学、微生物学、药理学、药物分析学、遗传学、分子生物学、细胞生物学、免疫学、植物组织培养、生化分离技术、基因工程、细胞工程、酶工程、发酵工程等。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">主要实践性教学环节：包括教学实习、生产实习和毕业论文<span lang="EN-US">(</span>设计等，一般安排<span lang="EN-US">10-20</span>周。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">相近专业：生物科学、生物信息学、生物信息技术、生物科学与生物技术、动植物检疫、生物化学与分子生物学、医学信息学、植物生物技术、动物生物技术、生物工程、生物安全<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养目标：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">本专业旨在培养适应我国经济、社会发展需要，德智体全面发展，掌握现代生物学和生物技术的基本理论、基本知识和基本技能，获得应用基础研究和科技开发研究的初步训练，具有良好的科学素质、较强的创新意识和实践能力的生物技术高级专门人才。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">知识技能<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">1</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、掌握数学、物理、化学等方面的基本理论和基本知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">2</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握基础生物学、生物化学、分子生物学、微生物学、基因工程、发酵工程及细胞工程等方面的基本理论、基本知识和基本实验技能，以及生物技术及其产品开发的基本原理和基本方法；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-bidi-font-size:
10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">3</span><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">、了解相近专业的一般原理和知识；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">4</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、熟悉国家生物技术产业政策、知识产权及生物工程安全条例等有关政策和法规；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">5</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、了解生物技术的理论前沿、应用前景和最新发展动态，以及生物技术产业发展状况；<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-bidi-font-size:10.5pt;line-height:
200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:
0pt" lang="EN-US">6</span><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">、掌握资料查询、文献检索及运用现代信息技术获取相关信息的基本方法；具有一定的实验设计，创造实验条件，归纳、整理、分析实验结果，撰写论文，参与学术交流的能力。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">080101</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">理论与应用力学（</span><span lang="EN-US">08</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">工学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">理论力学、材料力学、结构力学、弹性力学、结构动力学、实验力学，流体力学，房屋建筑学、土木工程材料、混凝土结构、钢结构、土力学与基础工程、工程结构抗震设计，有限单元法，建筑工程施工和项目管理等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">学生毕业后可在建筑工程、岩土工程、地下工程、道路与桥梁工程等领域的设计、施工、开发、研究、教学、管理等单位从事技术或管理工作。如机械、土建、交通、材料、能源、水利、化工、航空航天等工业企业从事科学研究、技术开发、工程设计、实验研究、工程管理等工作。能够在科研机构，包括在航空航天研究所、水利设计院、建筑设计院、金属研究所、自动化研究所等院所从事理论研究和实验研究。能够在高等院校和中等专科学校从事力学教学与科研工作。</span><b><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span></b><b><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、掌握数学、物理的基础知识，具有较强的分析和演算能力；</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　</span><span lang="EN-US">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握系统的力学基本理论知识，初步掌握力学的基本实验技能和实验分析方法；掌握一定的工程背景知识，初步学会建立简单力学模型的方法；</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　　</span><span lang="EN-US">3</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解相近专业的一般原理和知识；</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">　　</span><span lang="EN-US">4</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">、对本专业范围内科学技术的新发展有所了解；</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">　　</span><span lang="EN-US">5</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解国家科技、产业政策、知识产权等有关政策和法规；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握资料查询、文献检索以及运用现代信息技术获取相关信息的基本方法；具有一定的实验设计，创造实验条件、归纳、整理、分析实验结果，撰写论文，参与学术交流的能力。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">090101</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">农学（</span><span lang="EN-US">09</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">农学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：农学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：园艺、植物保护</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：植物生理与</span><span lang="EN-US"><a href="http://baike.baidu.com/view/24503.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">生物化学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、应用概率统计、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/8907.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">遗传学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、田间试验设计、农业</span><span lang="EN-US"><a href="http://baike.baidu.com/view/71787.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">生态学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、作物栽培与耕作学、育种学、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/910839.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">种子学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/809867.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">农业经济管理</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/489676.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">农业推广</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">学。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要实践性教学环节：包括教学实习、生产实习、课程设计、毕业论文</span><span lang="EN-US">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业设计</span><span lang="EN-US">)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、科研训练、生产劳动、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/296088.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">社会实践</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">等，一般安排不少于</span><span lang="EN-US">30</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">周。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要专业实验：作物发育形态、田间诊断、作物杂交和选择、种子生产。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业生应获得以下几方面的知识和能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、具备扎实的数学、物理、化学等基本理论知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">掌握生物学科和农学学科的基本理论、基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、具备农业生产，特别是作物生产的技能和方法；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具备农业可持续发展的意识和基本知识，了解农业生产和科学技术的科学前沿和发展趋势；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">5</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、熟悉农业生产、农村工作的有关方针、政策和法规；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握科技文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">7</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、有较强的调查研究与决策、组织与管理、口头与文字表达能力，具有独立获取知识、信息处理和创新的基本能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span lang="EN-US">100201K</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">临床医学（</span><span lang="EN-US">10</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">医学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">从</span><span lang="EN-US">2015</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">年开始，高等学校临床医学专业将以“</span><span lang="EN-US">5+3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">”模式（</span><span lang="EN-US">5</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">年临床医学本科教育</span><span lang="EN-US">+3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年住院医师规范化培训）为主体，形成新的医教协同医学教育模式。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">身体条件：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">患有以下疾病者报考本专业高等学校可退档不予录取：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">《普通高等学校招生体检工作指导意见》规定学校可不予录取的疾病</span><span lang="EN-US">[1] </span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">轻度色觉异常（俗称色弱）</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">色觉异常</span><span lang="EN-US">II</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">度（俗称色盲）</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">不能准确识别红、黄、绿、兰、紫各种颜色中任何一种颜色的导线、按键、信号灯、几何图形</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">患有以下疾病者不宜报考，但高等学校不能以患有下列疾病为由退档不予录取：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">任何一眼矫正到</span><span lang="EN-US">4.8</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">镜片度数大于</span><span lang="EN-US">800</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">度</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">一眼失明另一眼矫正到</span><span lang="EN-US">4.8</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">镜片度数大于</span><span lang="EN-US">400</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">度</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">两耳听力均在</span><span lang="EN-US">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">米以内，或一耳听力在</span><span lang="EN-US">5</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">米另一耳全聋</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">斜视、嗅觉迟钝、口吃</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">文化条件：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">符合高考报名条件</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">大部分临床医学专业只收理科生</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">高考成绩达到所报考学校录取分数线</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">学制学位：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">学制五年（最长可延长到八年）</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业为大学本科学历，符合学校要求者授予医学学士学位</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">课程设置：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">有的院校分为双语班和中文班。双语班入校后强化英语教学，基础和临床课程采用双语授课和考试，使学生具备扎实的基础和专业英语功底，中文班采用中文授课和考试，第三学年开始学习专业英语。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本上，前三年在学校学习人文、自然和基础医学知识，后两年到附属医院或教学医院学习临床理论和技能。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业学生主要学习医学方面的基础理论和基本知识，受到人类疾病的诊断、治疗、预防方面的基本训练，培养对人类疾病的病因、发病机制作出分类鉴别的能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、德育和综合素质要求</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、热爱祖国，热爱社会主义，拥护中国共产党的领导</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、树立辩证唯物主义和历史唯物主义世界观</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、有理想、有道德、有文化、有纪律</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、热爱医学事业，具备良好的职业道德素质及医学人文精神，具备全心全意为病人服务、实行医学人道主义、为医学事业敬业终身的精神</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握一定的体育和军事基本知识，达到国家规定的大学生体育合格标准，能够履行建设祖国和保卫祖国的神圣义务</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">7</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有良好的心理素质、乐观向上的生活态度</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">8</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、专业素质能力要求</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">9</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握与医学相关的自然科学基本理论与方法</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">10</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握医学基础学科的基本理论与方法</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">11</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握临床医学学科的基本理论与临床技能</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">12</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握常见病、多发病诊断处理的临床基本技能</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">13</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有对急、难、重症的初步处理能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">14</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握公共卫生及医学相关方面的知识</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">15</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、熟悉国家卫生工作方针、政策和法规</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">16</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握医学文献检索、资料调查的基本方法，具有一定的科学研究和实际工作能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">17</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握计算机的基本知识和操作技能</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">18</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握一门外语</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">19</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、学习中要努力培养</span><span lang="EN-US">ASK</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">A</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">，</span><span lang="EN-US">A</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">是指态度</span><span lang="EN-US">Attitude</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">，首先必须要知道怎么尊重人，要有医德</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">S</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">，</span><span lang="EN-US">S</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">就是能力</span><span lang="EN-US">Skill</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">，要有解决问题，能够治病，能够救死扶伤的能力</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">K</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">，</span><span lang="EN-US">K</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">是知识</span><span lang="EN-US">Knowledge</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">，要掌握所有的基础和临床知识</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US">120203K</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">会计学（<span lang="EN-US">12</span>管理学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">具体地说，</span><span lang="EN-US">“</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">会计学原理</span><span lang="EN-US">”</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">主要阐述的是会计的基本理论、会计的基本知识和会计基本方法的知识体系而大学会计学首先是公共课程，也就是任何专业都要学的课程，比如</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1194935.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">马克思主义哲学原理</span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、邓</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">小</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">平理论、毛</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">泽</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">东思想概论、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1769410.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">大学生思想道德修养</span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、大学英语、体育等</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">其次是专业公共课，即经济管理类专业的学生都要学的课程，比如</span><span lang="EN-US"><a href="http://baike.baidu.com/view/31551.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">经济学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/107998.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">西方经济学</span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/20674.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">管理学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/14041.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">高等数学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">（或经济数学）、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/6293368.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">概率论及数理统计</span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">等</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">第三是专业课，这是</span><span lang="EN-US"><a href="http://baike.baidu.com/view/146411.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">会计学专业</span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">最主要的课程，从比较基础的会计学原理开始，到中等难度的</span><span lang="EN-US"><a href="http://baike.baidu.com/view/283119.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">成本会计</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、管理会计、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/228831.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">会计电算化</span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、审计、审计案例分析、经济法等，再到比较深奥的税法、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/78884.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">财务管理</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、高级成本会计、高级管理会计等课程。另外会学一些在内容上有交叉的其他专业的基础专业课，比如</span><span lang="EN-US"><a href="http://baike.baidu.com/view/50313.htm" target="http://baike.baidu.com/subview/74370/_blank"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">统计学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">第四是选修课，即根据自己的喜好，选择本专业或其他专业的一些课程，主要用来积累学分</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">，烽火猎头公司相关专家认为会计学是一门重要的实践课程，希望在校大学生多做些具体的实际内容，不能光学习理论！</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业基础课</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">《高等数学》、《概率论与数理统计》、《大学语文》、《程序设计》、《管理学导论》、《财务管理》、《运筹学》、《营销管理》、《管理信息系统》、《运营管理》、《会计软件应用》、《中级财务会计》、《成本管理会计》、《税法》、《经济法》、《西方经济学》。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业课</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">《审计学》、《高级财务会计》、《中级财务管理》、《国际会计》、《财务报表分析》。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专业选修课</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">《会计制度设计》、《文献检索》、《专业外语》、《人力资源会计》、《社会会计》、《保险学》、《税务会计》、《会计专题研究》、《会计与审计案例》、《会计职业道德》、《管理控制系统》、《行业比较会计》、《政府与非盈利组织会计》、《会计与审计法律专题》、《会计史》、《银行会计》、《管理咨询》、《会计与审计实务》、《</span><span lang="EN-US">ERP</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">原理及应用》、《应用统计软件》、《公司治理与会计信息》、《内部控制理论与实践》、《金融衍生工具》、《会计信息与资本市场》。专业实践教学内容</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">社会调查、社会实践、会计软件上级训练、课程实习、毕业实习、毕业论文。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：管理学学士</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">业务培养目标：本专业培养具备管理、经济、法律和会计学等方面的知识和能力，能在企、事业单位及政府部门从事会计实务以及教学、科研方面工作的工商管理学科高级专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">业务培养要求：本专业学生主要学习会计、审计和工商管理方面的基本理论和基本知识，受到会计方法与技巧方面的基本训练，具有分析和解决会计问题的基本能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业生应获得以下几方面的知识和能力：</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、掌握管理学、经济学和会计学的基本理论和基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握会计学的定性、定量分析方法，接受会计方法与技巧方面的基本训练；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、具有较强的语言与文字表达、人际沟通、信息获取能力及分析解决会计问题的基本能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、熟悉国内并了解国外与会计相关的方针、政策和法规及国际会计惯例；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解本学科的理论前沿，有一定的科学研究能力和较强的实际工作能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握文献检索和资料查询的基本方法；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">7</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、熟练掌握一门外语，有较强的计算机应用能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

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
mso-hansi-font-family:&quot;Times New Roman&quot;">因此，我们说“专业选择测试”可以准确而有效的测量学生的兴趣和能力特点，并为学生在专业选择方面提供合理建议。</span></p>

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
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">高考志愿填报对于每个毕业生来说都是人生中的大事，</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">不论是学生家长、高中学校、各个高校、社会都参与进来，对高考毕业生产生或多或少的影响，这个时候，在考虑个人利益的同时也应当负责任地为高考生提供正确信息。每个高考生学会科学填报，减少失误，为今后更好的发展铺下坚固的基石。希望这份测试报告为能够为你提供一点参考。</span><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span></p>

<span id="_editor_bookmark_start_22" style="display: none; line-height: 0px;">‍</span>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>
