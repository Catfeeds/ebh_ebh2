<?php $this->display('myroom/page_header'); ?>
</head>
<style>
.reggewe {
   background:  40px 25px #fff;
	
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
    margin-left: 20px;
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
    margin-top: 25px;
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
    margin-top: 55px;
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
	当前位置 > <a href="<?= geturl('myroom/analysis') ?>">学习分析表</a> > 自我测评
	</div>
	<div class="lefrig" style="margin-top:10px;">
	<?php if($evaluates){foreach($evaluates as $evaluate){?>
		<div class="reggewe graybg" >
		<span style="margin-left:20px;margin-top:20px;float:left">
		<img src="<?=$evaluate['logo']?>" style="height: 71px;width:83px;"  />
		</span>
		
		<div class="rekidfg">
		<p class="gdrgjs"><?=$evaluate['descr']?></p>
		<p style="color:#ff0000;font-weight:bold;margin-top:5px">本项测评只能做一次，请认真填写。</p>
		</div>
		<?php if($evaluate['tested']==true){ ?>
		<a name="reggewe"  href="/myroom/evaluate/result.html?eid=<?=$evaluate['eid']?>" class="askedbtn">测评结果</a>
		<?php }else{?>
		<a name="reggewe"  href="/myroom/evaluate/dotest.html?eid=<?=$evaluate['eid']?>" class="edgdsbtn">进入测评</a>
		<?php }?>
		
		</div>
	<?php }}?>

</div>
<script>
function highdark(cn){
	$('.graybg').css('backgroundColor','#fff');
	$('.'+cn).css('backgroundColor','#f5f5f5');
	$('a:[name='+cn+']').focus();
}
</script>
<?php $this->display('myroom/page_footer'); ?>