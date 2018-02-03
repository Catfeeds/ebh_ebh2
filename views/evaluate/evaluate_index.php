<?php $this->display('myroom/page_header'); ?>
</head>
<style>
.reggewe {
    background: url("http://static.ebanhui.com/edu/images/fldot111.jpg") no-repeat scroll 40px 25px #fff;
    border-bottom: 1px solid #f6f6f6;
    float: left;
    height: 150px;
    width: 786px;
}
.dhthwe {
    background: url("http://static.ebanhui.com/edu/images/fldot112.jpg") no-repeat scroll 40px 25px #fff;
    border-bottom: 1px solid #f6f6f6;
    float: left;
    height: 150px;
    width: 786px;
}
.sdgbsew {
    background: url("http://static.ebanhui.com/edu/images/fldot113.jpg") no-repeat scroll 40px 25px #fff;
    border-bottom: 1px solid #f6f6f6;
    float: left;
    height: 150px;
    width: 786px;
}

.erigrg {
    background: url("http://static.ebanhui.com/edu/images/fldot114.jpg") no-repeat scroll 40px 25px #fff;
    float: left;
    height: 150px;
    width: 786px;
}
.rekidfg {
    display: inline;
    float: left;
    margin-left: 150px;
    margin-right: 20px;
    width: 480px;
}
a.edgdsbtn {
    background: none repeat scroll 0 0 #2fb5ff;
    color: #fff;
    display: block;
    float: left;
    font-size: 14px;
    height: 32px;
    line-height: 32px;
    margin-top: 60px;
    text-align: center;
    width: 118px;
}

.gdrgjs {
    color: #969696;
    line-height: 1.7;
    margin-top: 40px;
    text-indent: 25px;
}
a.askedbtn {
    background: none repeat scroll 0 0 #f39800;
    color: #fff;
    display: block;
    float: left;
    font-size: 14px;
    height: 32px;
    line-height: 32px;
    margin-top: 60px;
    text-align: center;
    width: 118px;
}
.lefrig {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #cdcdcd;
    float: left;
    margin-top: 15px;
    padding-bottom: 10px;
    width: 786px;
}
</style>
<body>
	<div class="ter_tit">
	当前位置 > 自我测评
	</div>
	<div class="lefrig" style="margin-top:10px;">
<div class="reggewe graybg" >
<div class="rekidfg">
<p class="gdrgjs">本测试系统是根据联结主义心理学家的S-R公式、海德成败归因理论和班杜拉自我效能感理论的原理，并分析中国各地中学教学安排进程等现状，综合制定的测试题，深入剖析学生学习动机的成因、学习兴趣点，帮助你更好的认识自我，更科学刺激学习动机。</p>
<p style="color:#ff0000;font-weight:bold;margin-top:5px">本项测评只能做一次，请认真填写。</p>
</div>
<?php 
	$mentalmodel = $this->model('Mentaltest');
	$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>0));
	if(!empty($result)){
?>
<a name="reggewe"  href="/myroom/evaluate/result.html?ttype=0" class="askedbtn">测评结果</a>
<?php }else{?>
<a name="reggewe"  href="/myroom/evaluate/dongji.html" class="edgdsbtn">进入测评</a>
<?php }?>

</div>
<div class="dhthwe graybg" >
<div class="rekidfg">
<p class="gdrgjs">本测试系统根据MMPI明尼苏达多项人格测试原理，对人的情绪、需求、动机、兴趣、态度、性格、气质等方面指标进行测试，发现被测试者的本质心态，深入了解其潜在才能，以及发展倾向，并对特殊潜能进行发掘，从而让被测试者及时的了解自我，适时调整。</p>
<p style="color:#ff0000;font-weight:bold;margin-top:5px">本项测评只能做一次，请认真填写。</p>
</div>
<?php 
	$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>1));
	if(!empty($result)){
?>
<a name="reggewe"  href="/myroom/evaluate/result.html?ttype=1" class="askedbtn">测评结果</a>
<?php }else{?>
<a name="dhthwe"  href="/myroom/evaluate/xintai.html" class="edgdsbtn">进入测评</a>
<?php }?>
</div>
<div class="sdgbsew graybg">
<div class="rekidfg">
<p class="gdrgjs">本测试系统根据SDS焦虑自评量表和学生内外因素，采用情景模拟法来判断学生的应考心态，通过应考心态与学习效率构成U型抛物线图分析学生焦虑程度，并提出食疗法、音乐法、自我暗示法等各种调节方式，帮助学生调整焦虑心态，从容迎考。</p>
<p style="color:#ff0000;font-weight:bold;margin-top:5px">本项测评只能做一次，请认真填写。</p>
</div>
<?php 
	$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>2));
	if(!empty($result)){
?>
<a name="reggewe"  href="/myroom/evaluate/result.html?ttype=2" class="askedbtn">测评结果</a>
<?php }else{?>
<a name="sdgbsew"  href="/myroom/evaluate/jiaolv.html" class="edgdsbtn">进入测评</a>
<?php }?>

</div>
<div class="erigrg graybg">
<div class="rekidfg">
<p class="gdrgjs">本测试系统是参照国家教育部权威发布《普通高等学校本科专业目录》和国际权威的MBTI职业性格测量表和霍德兰的SDS职业兴趣测量表而设置的专业测评题，深度剖析你的人格特质和专业兴趣，帮你清晰地了解自身特长，更科学的选择大学专业，更合理的规划未来职业。</p>
<p style="color:#ff0000;font-weight:bold;margin-top:5px">本项测评只能做一次，请认真填写。</p>
</div>
<?php 
	$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>3));
	if(!empty($result)){
?>
<a name="reggewe"  href="/myroom/evaluate/result.html?ttype=3" class="askedbtn">测评结果</a>
<?php }else{?>
<a name="erigrg"  href="/myroom/evaluate/shengxue.html" class="edgdsbtn">进入测评</a>
<?php }?>

</div>
</div>
<script>
function highdark(cn){
	$('.graybg').css('backgroundColor','#fff');
	$('.'+cn).css('backgroundColor','#f5f5f5');
	$('a:[name='+cn+']').focus();
}
</script>
<?php $this->display('myroom/page_footer'); ?>