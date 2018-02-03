<?php $this->display('myroom/page_header'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" />

<link href="http://static.ebanhui.com/ebh/tpl/2012/css/join.css" rel="stylesheet" type="text/css" />

<style type="text/css">
.zizhan {
    float: left;
}
.kefbuy {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/wangdihui.jpg) no-repeat scroll center bottom;
    float: left;
    height: 251px;
    margin-bottom: 10px;
    margin-right: 26px;
	display:inline;
    position: relative;
    width: 232px;
}
.leich {
    background-color: #ffffff;
    border: 1px solid #cdcdcd;
    height: 221px;
    padding: 12px;
    width: 206px;
}
.ketit {
    color: #299de6;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}
.zizhan .kewaik {
    border: 1px solid #cdcdcd;
    float: left;
    height: 100px;
    margin-right: 15px;
    width: 100px;
}
.rigxiaox {
    float: left;
    height: 100px;
}
.botthui {
    color: #999;
    margin-bottom: 15px;
}
.botthui {
    color: #999;
}
.xuexibtn {
    background: none repeat scroll 0 0 #36b8ff;
    border: 1px solid #108ed4;
    color: #ffffff;
    cursor: pointer;
    display: block;
    float: left;
    height: 28px;
    line-height: 26px;
    text-align: center;
    text-decoration: none;
    width: 76px;
}
.xuexibtn:hover {
    background: none repeat scroll 0 0 #18a8f7;
}
.zizhan .fottpp {
    color: #666;
    float: left;
    line-height: 2;
    margin-top: 10px;
    overflow: hidden;
    text-indent: 25px;
    width: 200px;
    word-wrap: break-word;
}
.leich1 {
    background-color: #d7f3fc;
    border: 1px solid #cdcdcd;
    height: 221px;
    padding: 12px;
    width: 206px;
}
</style>
<title>我的网校</title>
</head>

<body>
<div class="cright" style="margin-top:0">
<div class="ter_tit"> 当前位置 > 我的网校 </div>
<div class="lefrig" style="margin-top:10px;">
	<?php
		if(count($roomlist)==0){
	?>
		<div class="nojoin">
			<p>您还没有加入任何云教学网校,<a href="<?=geturl('cloudlist')?>" style="color:#ff5501;" target="_blank">立刻加入>></a>畅享知识海洋...</p>
		</div>
	<?php
	}
		else{
			foreach($roomlist as $room){
			$room['murl'] = 'http://'.$room['domain'].'.ebanhui.com/myroom.html';
				
	?>
		<div class="lc_detail">
			<ul>
				<li class="agess" style="border:solid 1px #cdcdcd;" onmouseover="this.className='agess1'" onmouseout="this.className='agess'">
				<div class="cuor">
				<a target="_blank" href="<?php echo $room['murl']?>" title="<?php echo $room['crname']?>">
				<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface'];?>
				<img src="<?=$logo?>" width="100" height="100" style="margin-top:2px; margin-left:2px;"></a></div>
				<h2 class="courtit">
				<a target="_blank" href="<?php echo $room['murl']?>" title="<?php echo $room['crname']?>"><?php echo $room['crname']?></a>
				</h2>
				<p class="yunjsh" style="word-break:break-all;"><?php echo ssubstrch($room['summary'],0,150)?></p>
				<a target="_blank" class="add" style=" color:#FFF;text-decoration: none;" href="<?php echo $room['murl']?>">进入学习</a>
				<p class="due">服务到期时间：<span style="color:#1061a7; font-weight:bold; margin-right:20px;"><?php echo empty($room['enddate'])?'无限制':Date('Y-m-d',$room['enddate'])?></span>课时数：<span style="color:#1061a7; font-weight:bold; margin-right:20px;">( <?php echo $room['coursenum']?> 课时 )</span></p>
				</li>
			
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
<?php $this->display('myroom/page_footer'); ?>