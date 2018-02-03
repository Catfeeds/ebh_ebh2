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
	color: #505050;
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
.fgngr p{
	color: #505050;
    font-size: 14px;
    font-weight: bold;
    height: auto;
    line-height: 20px;
    padding-top: 2px;
}
.pagebtndiv {
    float: left;
    height: 150px;
    margin-left: 100px;
    width: 580px;
}

.greigd{
	display: inline-block;
    float: left;
    margin-left: 17px;
    width: 690px;
	line-height:30px;
	margin-bottom:2px;
	cursor:pointer;
}
.greigd input{
	margin-left:5px;
}
.inithide {
    display: none;
}
.brifbtn {
    background: url("http://static.ebanhui.com/edu/images/gdiubtn.jpg") no-repeat scroll;
    display: inline-block;
    float: left;
    height: 34px;
    margin: 50px 0 50px 240px;
    width: 112px;
}

.leftoutdiv {
    background: none repeat scroll 0 0 #ddd;
    border: 1px solid #bbb;
    display: none;
    left: 580px;
	top: 200px;
    position: absolute;
}


.unseltitle {
    margin-left: 5px;
}
.leftmiddlediv {
    background: none repeat scroll 0 0 #eee;
    height: 200px;
    overflow-y: auto;
    width: 150px;
}

.feeds-more {
    margin-left: 20px;
    padding-top: 10px;
}
.feeds-more a {
    border: 1px solid #dee0e2;
    border-radius: 2px;
    display: block;
    height: 45px;
    margin: 0 3px;
    text-align: center;
}
.feeds-more a span {
    color: #369;
    display: inline-block;
    font: 400 18px/45px "微软雅黑";
    height: 45px;
    padding-right: 20px;
}
.feeds-more .feeds-loading .i {
    background: url("http://static.ebanhui.com/edu/images/loading.gif") no-repeat scroll;
    display: inline-block;
    height: 16px;
    margin: 14px 10px;
    vertical-align: top;
    width: 16px;
}
.redsrt img{max-width:700px;}
</style>
<body>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('myroom/evaluate');?>">自我测评</a> > <?=$evaluate['title']?>
</div>
<div class="lefrig" style="margin-top:10px;">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/psytest.js"></script>
<div class="redsrt">
<h2 class="hrrty"> <?=$evaluate['title']?></h2>
<p class="rgiege">
<?=$evaluate['tutor']?>
</p>

<form id="mainform" action="/myroom/evaluate/saveanswer.html" method="post">
<input type="hidden" name="count" value="<?=count($questions)?>" />
<input type="hidden" name="eid" value="<?=$evaluate['eid']?>" />
<input type="hidden" id="page"  name="page" value="1"  autocomplete="off" />
<input type="hidden"  id="maxpage"  name="maxpage" value="<?=ceil(count($questions)/10)?>" autocomplete="off"  />
<ul>
<?php
$k=1;
foreach($questions as $question){
	$qitemarr = unserialize($question['qitemstr']);
	$hideclass = '';
	if($k>10){
		$hideclass = 'inithide';
	}
?>
<li class="fgngr <?=$hideclass?> page<?=ceil($k/10)?>" id="li<?=$k?>">
<p ><?=$k?>.<?=$question['qtitle']?></p>
<?php foreach($qitemarr as $qitem){?>
<label><span class="greigd"><input name="q<?=$k?>" type="radio" value="<?=$question['qid'].'_'.$qitem['iscore']?>" class="radios"/> <?=$qitem['item']?></span></label>
<?php }?>
</li>
<?php $k++;}?>
</ul>
<div class="pagebtndiv">
<div id="feeds_more" class="feeds-more" >
<a href="javascript:void(0)"><span class="feeds-loading">加载更多</span></a>
</div>
</div>
</form>
<a href="javascript:void(0)" class="brifbtn"  style="display:none" onclick="submit()"></a>
</div>
</div>
<div class="leftoutdiv" id="leftoutdiv" style="display:none">
	<span class="unseltitle">还有未选择的题目:</span>
	<div class="leftmiddlediv" style="" id="unselect"></div>
</div>
<?php $this->display('myroom/page_footer'); ?>