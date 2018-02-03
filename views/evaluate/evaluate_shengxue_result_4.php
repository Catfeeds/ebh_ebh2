
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
line-height:200%;mso-pagination:widow-orphan" align="center"><b style="mso-bidi-font-weight:
normal"><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:
宋体;mso-bidi-font-family:宋体;color:red;mso-font-kerning:0pt">测试结果</span></b><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;
mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt" lang="EN-US"></span></b></p>

<p class="MsoNormal" style="mso-margin-top-alt:auto;text-align:left;
text-indent:21.1pt;mso-char-indent-count:2.0;line-height:200%;mso-pagination:
widow-orphan" align="left"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">现实型：</span></b><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">有运动机械操作的能力，喜欢机械、工具、植物或动物，偏好户外活动。这种人不重视社交，而重视物质的、实际的利益。他们遵守规则，喜欢安定，感情不丰富，缺乏洞察力。在职业选择上，他们希望从事有明确要求的、需要一定的技能技巧、能按一定程序进行操作的工作。<span lang="EN-US"></span></span></p>

<p class="MsoNormal" style="text-align:left;text-indent:21.0pt;
mso-char-indent-count:2.0;line-height:200%;mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;line-height:200%;font-family:宋体;mso-bidi-font-family:
宋体;color:#323E32;mso-font-kerning:0pt">可参考填报：<b>哲学</b>：逻辑学<span lang="EN-US">;</span><b>教育学</b>：教育技术学、体育教育、运动训练、社会体育、运动人体科学、民族传统体育、汽车维修工程教育、应用电子技术教育、装潢设计与工艺教育<span lang="EN-US">;</span><b>文学</b>：传播学<span lang="EN-US">;</span><b>管理学</b>信息管理与信息系统、电子商务<span lang="EN-US">;</span><b>理学</b>：理学类所有专业<span lang="EN-US">;</span><b>工学</b>：工学类所有专业<span lang="EN-US">;</span><b>农学</b>：农学类所有专业<span lang="EN-US">;</span><b>医学</b>：医学影像学、医学检验、眼视光学、康复医学、口腔医学、针灸推拿学、法医学、护理学、药学类所有专业。<span lang="EN-US"></span></span></p>

<div class="MsoNormal">
<table width="710" height="771" border="1" cellpadding="0" cellspacing="0" class="MsoNormalTable" style="border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
 mso-border-alt:solid windowtext .5pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
 mso-border-insideh:.5pt solid windowtext;mso-border-insidev:.5pt solid windowtext">
 <tbody><tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
  <td style="width:142.0pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">学科<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">门类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">专业名称<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:1">
  <td style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">01</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0101</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">哲学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">010102</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">逻辑学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:2">
  <td rowspan="6" style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">04</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0401</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040104</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育技术学类<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:3">
  <td rowspan="5" style="width:142.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0402</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">教育学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040201</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">体育教育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:4">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040202K </span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">运动训练<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:5">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040203</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">社会体育指导与管理<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:6">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040205</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">运动人体科学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:7">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">040204K</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">民族传统体育<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:8">
  <td style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">05</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">文学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">0503</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">新闻传播学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">050304</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">传播学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:9">
  <td style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">07</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">理学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:10">
  <td style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">08</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">工学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:11">
  <td style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">09</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">农学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:12">
  <td rowspan="8" style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">10</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1003</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">口腔医学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">100301K</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">口腔医学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:13">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1005</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">中医学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">100502K</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">针灸推拿学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:14">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1007</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">药学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">全部<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:15">
  <td rowspan="4" style="width:142.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1010</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学技术类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101001</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学检验技术<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:16">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101003</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">医学影像技术<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:17">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101004</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">眼视光学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:18">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101005</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">康复治疗学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:19">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1011</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">护理学类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">101101</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">护理学<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:20">
  <td rowspan="2" style="width:142.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">12</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">管理学<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1201</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">管理科学与工程类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">120102</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">信息管理与信息系统<span lang="EN-US"></span></span></p>
  </td>
 </tr>
 <tr style="mso-yfti-irow:21;mso-yfti-lastrow:yes">
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
  <p class="" style="text-align:left;line-height:200%;
  mso-pagination:widow-orphan" align="left"><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt" lang="EN-US">1208</span><span style="mso-bidi-font-size:10.5pt;
  line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
  mso-font-kerning:0pt">电子商务类<span lang="EN-US"></span></span></p>
  </td>
  <td style="width:142.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt" valign="top" width="189">
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

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">010102</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">逻辑学（</span><span lang="EN-US">01</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">哲学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具备系统的逻辑学、数学、计算机科学和哲学方面的基本理论和基础知识，一定的教学素养，以及计算机理论和操作、专业研究的能力，能在高等院校、科研单位、国家机关及企事业单位管理部门从事逻辑学的教学、科研和应用方面的工作，并能从事计算机科学及语言学的科研和应用方面相关工作的逻辑学高级专门人才。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：哲学、数学。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：数学分析、高等代数、抽象代数、概率统计、逻辑导论、数理逻辑、集合论、模态逻辑、归纳逻辑、四论导引（公理集合论、模型论、递归论、证明论）、应用逻辑、逻辑史、逻辑哲学、程序语言设计、操作系统等。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">实践教学：包括教学实习、论文写作等，一般安排</span><span lang="EN-US">6</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">周左右。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">修业时间：</span><span lang="EN-US">4</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">年。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">学位情况：哲学学士。</span></p>

<p class="MsoNormal" style="line-height:200%"><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">相关专业：哲学、数学与应用数学。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具备系统的逻辑学基础知识，一定的数学素养以及计算机理论和操作能力，能在高等院校、科研单位、国家机关及企事业管理部门从事逻辑学的教学、科研和应用方面的工作，并能从事计算机科学及语言学的科研和应用方面相关工作的逻辑学高级专门人才。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养要求：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">本专业学生主要学习逻辑学、数学、计算机科学和哲学方面的基本理论和基础知识，受到公理化方法、形式化方法和语义分析方面的基本训练，具有专业研究的基本能力。毕业生应获得以下几方面的知识和能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">1.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">掌握马克思主义的基本原理和逻辑学的基本理论、基础知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具有数学、计算机科学和哲学的基本素养；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握逻辑学研究的基本方法；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">了解现代逻辑的前沿问题与发展动态；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5..</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握文献检索、资料查询的基本方法和手段；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具有初步的教学、科研的实际工作能力。</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">040104</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">教育技术学（</span><span lang="EN-US">04</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">教育学）</span></b></p>

<p class="MsoNormal" style="line-height:200%"><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

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
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">教学<span lang="EN-US">设计</span></span></span></a></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、教学媒体理论与实践、摄影摄像、校园网建设与维护、机器人设计、教育心理学。</span></p>

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
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">毕业设计</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">（论文）、课程设计、技能训练等，并实施大学生创新培养行动计划，开展各种设计、实践活动</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
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

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">培养要求：</span></b><b><span style="mso-ansi-language:ZH-CN"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">本专业学生主要学习教育技术学方面的基本理论和基本知识，接受学习资源和学习过程的设计、开发、运用、管理和评价等方面的基本训练，掌握新技术教育应用方面的基本能力，培养适应新世纪的综合的信息素质人才。</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">本专业学生应获得以下几方面的知识和能力：</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">1</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．掌握教育技术学科的基本理论和基本知识；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．掌握教学系统分析、设计、管理、评价的方法和技术；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">3</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．具有媒体</span><span style="mso-ansi-language:
ZH-CN">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">幻灯投影、电视电声教材、计算机课件</span><span style="mso-ansi-language:ZH-CN">)</span><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;mso-ansi-language:
ZH-CN">制作的基本能力；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">4</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．具备计算机网络设计开发、常用软件熟练应用的能力以及影视编辑制作的能力；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">5</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．具备计算机硬件、局域网等小型网络维护的能力；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">6</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．熟悉国家关于教育、教育技术方面的有关方针、政策、法规；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="mso-ansi-language:ZH-CN">7</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．了解教育技术学理论前沿、应用前景、发展动态；</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">8</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">．掌握文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力。</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="mso-ansi-language:ZH-CN">9</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;;mso-ansi-language:ZH-CN">、现代教育技术在企业培训中的应用。</span><span style="mso-ansi-language:ZH-CN"></span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">050304</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">传播学（</span><span lang="EN-US">05</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">文学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：（课程设置）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">中外新闻传播史、传播学概论、新闻学</span><span lang="EN-US"><a href="http://baike.baidu.com/view/647963.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">概论</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/2653095.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">新闻采访与写作</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、舆论学、文艺美学、基础摄影、影视导论、影视</span><span lang="EN-US"><a href="http://baike.baidu.com/view/54.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">脚本</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">创作、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/188645.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">电视节目制作</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、摄像技术与艺术、电视新闻与纪录片、科教片编导创作、电视节目编辑、媒体动画与制作、网络传播与文化、多媒体应用技术、网络媒体设计、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1776819.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">网页设计与制作</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、广告学通论、广告视觉设计、媒介组织学、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1852476.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">传播学研究方法</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">等。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具备现代媒体传播的基础理论、基础知识和基本技能，适应信息化社会与</span><span lang="EN-US"><a href="http://baike.baidu.com/view/451653.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">知识经济时代</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">的要求，掌握现代电子媒体特别是电视媒体与</span><span lang="EN-US"><a href="http://baike.baidu.com/view/2386533.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">网络多媒体</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">传播的基本技能，胜任从事影视传播、新闻传播、网络传播、广告及</span><span lang="EN-US"><a href="http://baike.baidu.com/view/2116613.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">媒介经营管理</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">的高级专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">通过学习，可以具备以下几方面的</span><span lang="EN-US"><a href="http://baike.baidu.com/subview/41286/8049822.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">能力</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握</span><span lang="EN-US"><a href="http://baike.baidu.com/view/41084.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">传播学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">基本理论与基本知识。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、掌握广播电视节目策划、广告企划</span><span lang="EN-US"><a href="http://baike.baidu.com/view/228204.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">制作</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、公关活动策划与执行、媒体运营、新闻采访、写作、编辑、摄影等业务知识与技能。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、有调查研究和社会活动能力。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">、了解中外传播媒体工作现状与发展</span><span lang="EN-US"><a href="http://baike.baidu.com/subview/204171/12661388.htm" target="http://baike.baidu.com/view/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">趋势</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><b><span lang="EN-US">070103S</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">数理基础科学（</span><span lang="EN-US">07</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">理学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">该专业主要培养能从事数学、物理等基础科学教学和科研的有发展潜力的优秀人才，尤其是在数学、物理上具有创新的能力的人才，同时也为对数理基础要求高的其它学科培养有良好的数理基础的新型人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：数学分析、高等代数、解析几何、力学、热学、常微分方程、电磁学、理论力学、光学、实变函数、普通物理实验、数理统计、量子力学、数学物理方法、概率论、原子物理学等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授课方式采取的是课堂理论讲授和科研实践、毕业理论文设计相结合的方式。学生在就读的第一、二年，主要是加强数理基础的培养，学习共同基础课；从三年级开始逐步向物理学、数学及校内其它对数理基础要求较高的学科分流发展，安排基础课及部分按不同主修方向有所区别的课程，学生根据自己的志趣与能力，选定自己的发展方向。第四年安排主修方向的基础课并继续安排科研训练和毕业综合论文训练，通过毕业论文设计，强化其理论知识的运用和科研创新的能力。本科成绩达到规定要求者，可免试推荐进入研究生阶段攻读硕士或直读博士学位。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">知识技能通过学习，将具备以下几方面的能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具有扎实的数学、物理基础，受到比较严格的科学思维训练，初步掌握数学科学的思想方法；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具有应用数学、物理知识去解决实际问题，特别是建立数理模型的初步能力，了解某一应用领域的基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">能熟练使用计算机</span><span lang="EN-US">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">包括常用语言、工具及一些数学软件</span><span lang="EN-US">)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">，具有编写简单应用程序的能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">了解国家科学技术等有关政策和法规；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">了解数理基础科学的某些新发展和应用前景；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">有较强的语言表达能力，掌握资料查询、文献检索及运用现代信息技术获取相关信息的基本方法，具有一定的科学研究和教学能力。</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US">&nbsp;</span></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span lang="EN-US">080502T</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">能源与环境系统工程（</span><span lang="EN-US">08</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">工学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干课程编辑除数理化、计算机等公共基础课外，设有材料力学、理论力学、机械设计基础、工程热力学、工程流体力学、电工电子学、传热学、能源与环境系统工程基础、自动控制理论、能源与环境工程及自动化系列课程、制冷与人工环境及自动化系列课程等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：工学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：核工程与核技术</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">能源动力系统及自动化</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">工程物理</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">能源与环境系统工程</span><span lang="EN-US">? </span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">热能与动力工程</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：工程热力学（Ⅰ、Ⅱ）</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">工程流体力学（Ⅰ、Ⅱ）</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">传热学（Ⅰ、Ⅱ）</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">自动控制理论</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">能源与环境系统工程概论</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">以及能源转化</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">透平机械原理</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">热力环境控制</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">热力系统工程</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">热工信号处理技术</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">能源生产过程自动控制或制冷原理低温原理</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">人工环境设备</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">人工环境自动化</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">暖通与空调</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">特色课程：双语教学的课程：传热学</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">制冷原理</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">低温原理</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">燃烧基本原理和建模</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">低温制冷机</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">微尺度传热学</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">微尺度流体力学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">研究型课程：能源与环境技术进展</span> <span lang="EN-US">CFD</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">软件应用</span> <span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">人工环境材料</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">讨论型课程：</span> <span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">热能工程试验技术</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">基于循环经济的能源环境系统</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">超导技术与应用</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">人工环境英语</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">自学型课程：能源与环境工程综合训练</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">科研素质综合训练</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">计划学制</span><span lang="EN-US">: </span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">最低毕业学分</span><span lang="EN-US">: 160 +
4+2</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;</span></span></b><b><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">能源与环境系统工程专业研究将煤炭、石油、天然气等一次能源转化为电力、热能等二次能源的生产和利用过程；研究人工环境、制冷空调、低温生物医学等领域的科学技术问题；还研究风能、太阳能、生物质能等新能源的开发利用。伴随能源转换与利用过程排放的有害物质将造成环境污染，能源的生产必须高效、清洁。能源与环境系统专业不仅对自动化控制十分依赖，而且是一个复杂系统工程，集合了热科学、力学、材料科学、机械制造、环境科学、计算机科学、自动控制科学、系统工程科学等高新科学技术。能源与环境系统工程专业具有很宽的专业知识面，是一个能源、环境与控制三大学科交叉的复合型专业。</span></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具备宽厚热科学理论和能源与环境系统工程知识，能从事清洁能源开发、电力生产自动化、能源环境保护、制冷与低温、空调和储能、空调与人工环境等领域的设计、研究与管理的跨学科复合型高级技术人才。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-indent:24.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-size:12.0pt;line-height:200%;
mso-fareast-font-family:仿宋_GB2312;color:black" lang="EN-US">090201</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">农业资源与环境（</span><span lang="EN-US">09</span></b><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">农学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科编辑农业资源利用、环境科学与工程、生物学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程编辑土壤学、植物营养学、土地资源学、资源遥感与信息技术、农业环境学、农业气象学、生态学、水土保持学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要实践性教学环节编辑包括教学实习、生产实习、课程设计、毕业论文</span><span lang="EN-US">(</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业设计</span><span lang="EN-US">)</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、科研训练、生产劳动、社会实践等，一般安排</span><span lang="EN-US">25</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">～</span><span lang="EN-US">30</span><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">周。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要专业实验编辑土壤与农业化学分析、植物营养研究方法、环境质量分析与监测、土壤调查与制图、地质与地貌、测量与制图、气象观测</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：四年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：农学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：水土保持与荒漠化防治</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具备扎实的数学、物理、化学等基本理论知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握农业资源与环境科学的基本理论；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握农业资源的管理与利用、农业环境保护、土壤改良、生态农业建设等方面的基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握农业资源调查、环境质量评价、化学及现代仪器分析、植物营养的研究方法、科学施肥与科学灌溉、农业再生资源综合利用、土地规划与制图、资源信息管理等方面的方法与技术；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具备农业可持续发展的意识和基本知识，了解资源与环境的科学前沿及发展趋势；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">6.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">熟悉资源管理与利用、环境保护的有关方针、政策和法规；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">7.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握文献检索、资料查询的基本方法，具有一定科学研究和实际工作能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">8.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">有较强的调查研究与决策、组织与管理、口头与文字表达能力，具有独立获取知识、信息处理和创新的基本能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">四川农业大学　贵州大学　云南农业大学　甘肃农业大学　青海大学　宁夏大学　新疆农业大学　河北农业大学　山西农业大学　内蒙古农业大学　吉林农业大学　东北农业大学　扬州大学　安徽农业大学　安徽农业技术师范学院　福建农林大学　江西农业大学　山东农业大学　河南农业大学　湖南农业大学　广西大学　中国农业大学　沈阳农业大学　上海水产大学　南京农业大学　华中农业大学　华南农业大学　西北农林科技大学　西南农业大学　浙江大学　华南热带农业大学　内蒙古民族大学　长江大学　湛江海洋大学　西藏大学　浙江海洋学院　石河子大学等。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="line-height:200%;mso-outline-level:1"><b><span lang="EN-US">100101K</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">基础医学（</span><span lang="EN-US">10</span></b><b><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">医学）</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">基本信息：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：生物学、基础医学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：人体解剖学、组织胚胎学、细胞生物学、生理学、神经生理学、生物化学与分子生物学、医学遗传学、微生物学与免疫学、病理学、药理学、临床医学等</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">修业年限：五年</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">授予学位：医学学士</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">相近专业：临床医学、生物科学</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业为国家控制布点的专业</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养要求：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业学生主要学习现代自然科学和生命科学、基础医学各</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">学科的基本理论知识，一般地掌握临床医学的基本知识，受到基础医学各学科实验技能基本训练，重点掌握几类基本的生物医学实验技术。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">培养目标：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="line-height:200%"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">本专业培养具备自然科学、生命科学和医学科学基本理论知识和实验技能，能够在高等医学院校和医学科研机构等部门从事基础医学各学科的教学、科学研究及基础与临床相结合的医学实验研究工作的医学高级专门人才。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">1.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握基础医学的基本理论、基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">2.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握医学实验的分析、设计方法和操作技术；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">具有基础医学科学研究的基本能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">4.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">熟悉基础医学教学工作的基本原理和方法；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">熟悉临床医学基本知识并了解临床医学的新进展和新成就；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6.</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">掌握文献检索、资料查询的基本方法，具有一定的科学研究和实际工作能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">推荐院校：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-align:left;line-height:200%" align="left"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">南方医科大学（原第一军医大）重庆医科大学上海中医药大学北京大学复旦大学</span></p>

<p class="MsoNormal" style="text-align:left;line-height:200%" align="left"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">四川大学中山大学</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">南京大学</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">浙江大学哈尔滨医科大学</span></p>

<p class="MsoNormal" style="text-align:left;line-height:200%" align="left"><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">安徽医科大学武汉大学南华大学大连医科大学</span> <span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">湖南湘南学院</span>
<span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">九江大学</span> <span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">首都医科大学</span></p>

<p class="MsoNormal" style="line-height:200%"><b><span lang="EN-US">&nbsp;</span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt" lang="EN-US">120102</span></b><b><span style="mso-bidi-font-size:10.5pt;
line-height:200%;font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;
mso-font-kerning:0pt">信息管理与信息系统（<span lang="EN-US">12</span>管理学）<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">基本信息：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主干学科：</span><span lang="EN-US"><a href="http://baike.baidu.com/view/20674.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">管理学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/31551.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">经济学</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/35794.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">计算机科学与技术</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要课程：管理学，经济学，管理信息系统、信息经济学、信息检索、计算机开发技术，数据库原理与应用、运筹学、应用统计学、组织行为学，信息系统开发项目管理，计算机网络与通信，企业资源计划（</span><span lang="EN-US">ERP</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">）原理及应用，企业流程改造原理与实务，商法，</span><span lang="EN-US"><a href="http://baike.baidu.com/view/3609.htm" target="http://baike.baidu.com/_blank"><span style="color:windowtext;
text-decoration:none;text-underline:none">ERP</span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">原理与实施，</span><span lang="EN-US"><a href="http://baike.baidu.com/view/1738011.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">生产与运作管理</span></span></a>.</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">市场营销学，</span><span lang="EN-US"><a href="http://baike.baidu.com/view/78884.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">财务管理</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">学，</span><span lang="EN-US"><a href="http://baike.baidu.com/view/4692.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">人力资源管理</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">，会计学，</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">主要实践性教学环节：程序设计实习、管理软件实习、毕业设计等。一般安排</span><span lang="EN-US">18</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">周，其中毕业设计不少于</span><span lang="EN-US">12</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">周。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="mso-bidi-font-size:10.5pt;line-height:200%;
font-family:宋体;mso-bidi-font-family:宋体;color:#323E32;mso-font-kerning:0pt">培养要求：<span lang="EN-US"></span></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">本专业学生主要学习管理学、西方经济学、运筹学、管理信息系统、会计学基础、电子商务概论、</span><span lang="EN-US">VC/C++</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">语言程序设计、数据库原理、计算机网络、信息系统开发与管理等。</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">毕业生应获得以下几方面的知识和能力：</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">l</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">．掌握信息管理和信息系统的基本理论基本知识；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">2</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">．掌握</span><span lang="EN-US"><a href="http://baike.baidu.com/view/2670.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">管理信息系统</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">的分析方法、设计方法和实现技术；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">3</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">．具有信息组织、分析研究、传播与开发利用的基本能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span lang="EN-US">4</span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">．具有综合运用所学知识分析和解决问题的基本能力；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">5</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">．了解本专业相关领域的发展动态；</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span lang="EN-US">6</span><span style="font-family:宋体;
mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">．掌握文献检索、资料查询、收集的基本方法，具有一定的科研和实际工作能力。</span></p>

<p class="MsoNormal" style="text-indent:21.1pt;mso-char-indent-count:2.0;
line-height:200%"><b><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">报考院校推荐：</span><span lang="EN-US"></span></b></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%;mso-outline-level:1"><span style="font-family:宋体;mso-ascii-font-family:
&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;">（注：学生报考前应查明各校研究方向上的不同）</span></p>

<p class="MsoNormal" style="text-indent:21.0pt;mso-char-indent-count:2.0;
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">专门设置信息管理和信息系统专业的院校很多，如中央司法警官学院、</span><span lang="EN-US"><a href="http://baike.baidu.com/view/287749.htm" target="http://baike.baidu.com/_blank"><span style="font-family:
宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:&quot;Times New Roman&quot;;
color:windowtext;text-decoration:none;text-underline:none" lang="EN-US"><span lang="EN-US">湖南城市学院</span></span></a></span><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">、山东交通学院、中国人民大学、清华大学、浙江大学宁波理工学院、北京大学、南京大学、东南大学、天津大学、武汉大学、哈尔滨工业大学、西安交通大学、浙江大学、中国石油大学（华东）等。其中工科院校偏重对计算机应用的学习，文理院校偏重在管理上的研究。</span></p>

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
line-height:200%"><span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;
mso-hansi-font-family:&quot;Times New Roman&quot;">高考志愿填报对于每个毕业生来说都是人生中的大事，</span> <span style="font-family:宋体;mso-ascii-font-family:&quot;Times New Roman&quot;;mso-hansi-font-family:
&quot;Times New Roman&quot;">不论是学生家长、高中学校、各个高校、社会都参与进来，对高考毕业生产生或多或少的影响，这个时候，在考虑个人利益的同时也应当负责任地为高考生提供正确信息。每个高考生学会科学填报，减少失误，为今后更好的发展铺下坚固的基石。希望这份测试报告为能够为你提供一点参考。</span><span lang="EN-US"><span style="mso-spacerun:yes">&nbsp; </span></span></p>

<span id="_editor_bookmark_start_62" style="display: none; line-height: 0px;">‍</span>
</div>
</div>
<?php $this->display('myroom/page_footer'); ?>
