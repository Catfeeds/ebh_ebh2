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
<?php 
$typearray = array(
	'dongji'=>'学习动机测试',
	'xintai'=>'应考心态测评 ',
	'jiaolv'=>'焦虑心理测评 ',
	'shengxue'=>'升学择业测评 ',
)
?>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('myroom/evaluate');?>">自我测评</a> > <?=$typearray[$type]?>
</div>
<div class="lefrig" style="margin-top:10px;">
<?php if($type=="dongji"){?>
	<?php $this->display("evaluate/evaluate_dongji");?>
<?php }elseif($type=="xintai"){?>
	<?php $this->display("evaluate/evaluate_xintai");?>
<?php }elseif ($type=="jiaolv"){?>
	<?php $this->display("evaluate/evaluate_jiaolv");?>
<?php }elseif($type=="shengxue"){?>
	<?php $this->display("evaluate/evaluate_shengxue");?>
<?php }?>
</div>
<div class="leftoutdiv" id="leftoutdiv" style="display:none">
	<span class="unseltitle">还有未选择的题目:</span>
	<div class="leftmiddlediv" style="" id="unselect"></div>
</div>
<?php $this->display('myroom/page_footer'); ?>