<?php $this->display('shop/zwx/header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css?version=20151010001" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.vticker-min.js"></script>

<style type="text/css">   
.scroll_div {width:958px;margin:0 auto;overflow: hidden;white-space: nowrap;}
#scroll_begin, #scroll_end, #scroll_begin ul, #scroll_end ul, #scroll_begin ul li, #scroll_end ul li{display:inline;}  
#scroll_begin ul li {margin-left:15px;}
.huanqiu {
	float: left;
    height: 225px;
    margin-right: 15px;
    width: 351px;
}
.huanqiu .enidet {
    border: 1px solid #d4d4d4;
    height: 220px;
    width: 351px;
	background:#fff;
}
.huanqiu .enidets {
    background-color: #eaf6fa;
    border: 1px solid #d4d4d4;
    height: 220px;
    width: 351px;
}
.huanqiu .dettu {
    float: left;
    margin-left: 12px;
    margin-top: 9px;
	width:130px;
}
.kjname{
    color: #666666;
    font-size: 14px;
    font-weight: bold;
    height: 30px;
    line-height: 30px;
	padding-left:10px;
    width: 330px;
}
.huanqiu .refdet {
    float: left;
    height: 86px;
    margin-left: 8px;
	overflow:hidden;
    margin-top: 20px;
	text-indent:30px;
    width: 90px;
	word-wrap:break-word;
}
.enidet a.mianstbtn {
	width:114px;
	height:34px;
	line-height:36px;
	display:block;
	background:#19a8f7;
	border:solid 1px #0e9be9;
	float:left;
	font-size:16px;
	font-weight:bold;
	color:#fff;
	text-align:center;
	margin-top:12px;
	margin-left:55px;
}
.enidets a.mianstbtn {
	width:114px;
	line-height:36px;
	color:#fff;	
	font-size:16px;
	font-weight:bold;
	height:34px;
	text-align:center;
	display:block;
	background:#0e9be9;
	border:solid 1px #0e9be9;
	float:left;
	margin-top:12px;
	margin-left:55px;
	 text-decoration: none;
}
.enidet a.zaixxbtn {
	width:114px;
	height:34px;
	line-height:36px;
	display:block;
	background:#ea732f;
	border:solid 1px #d6682a;
	float:left;
	font-size:16px;
	font-weight:bold;
	color:#fff;
	text-align:center;
	margin-top:12px;
	margin-left:55px;
}
.enidets a.zaixxbtn {
	width:114px;
	line-height:36px;
	color:#fff;	
	font-size:16px;
	font-weight:bold;
	height:34px;
	text-align:center;
	display:block;
	background:#d6682a;
	border:solid 1px #d6682a;
	float:left;
	margin-top:12px;
	margin-left:55px;
	text-decoration: none;
}
.xiaotiter {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/dihongx.jpg?v=20141208") no-repeat left bottom;
    height: 35px;
    line-height: 35px;
	font-size:18px;
	position: relative;
	padding-left:10px;
	width:709px;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-bottom:10px;
}

.titerl {
    border-bottom: 1px solid #12abd5;
    float: left;
    height: 34px;
    width: 598px;
}
.linewline {
	margin-bottom:10px;
}

.rigxiaox {
    float: left;
    height: 128px;
    margin-top: 10px;
	margin-left:10px;
	width:195px;
	overflow: hidden;
}
.botthui {
    color: #999;
    margin-bottom: 0;
	margin-top:0px;
	margin-left:10px;
	float:left;
	width:100px;
}
.fottpp {
    color: #666;
    float: left;
    line-height: 2;
    margin-top: 0px;
    overflow: hidden;
    text-indent: 25px;
	margin-left:0px;
    width: 195px;
    word-wrap: break-word;
}
.lefadlo .toplogo .logobtn {
	background:#18a8f7;
	width:135px;
	height:32px;
	line-height:32px;
	border:none;
	font-size:16px;
	text-align:center;
	color:#fff;
	cursor:pointer;
	margin:0 0 10px 45px ;
}
.zzind .lefadlo .toplogo .msjinr {
	background:#18a8f7;
	width:135px;
	height:32px;
	line-height:32px;
	border:none;
	cursor:pointer;
	margin:0 0 27px 45px ;
	font-size:16px;
	text-align:center;
	color:#fff;
	margin-top:22px;
}
.rigjj a.lsts {
	position: absolute;
	top:0px;
	right:0px;
}
.append_new{
	float:left;
}

.fewof .leraten1 {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/titcqbg1.jpg") no-repeat scroll;
    color: #299de6;
    height: 36px;
    left: 0;
    line-height: 38px;
    position: absolute;
    top: -4px;
    width: 239px;
}
.fewof .leraten a{
	color: red;
}
.sp_div a {
	color:#299de6;
}
.rigxiaox a.zhutk {
	font-size:12px;font-weight:bold;color:#299de6;text-decoration: underline;margin-bottom:5px;float:left;width:195px;
}
.xueping {
    float: left;
	display:inline;
    margin: 10px 0 0 50px;
    width: 110px;
}
#edrghgh a.fenstbtn {
	float:left;
	display:block;
	width:50%;
	height:149px;
}
.sbs{
	display:none;
}
</style>
<script language="javascript">    
function ScrollImgLeft(){    
var speed=30;    
    var scroll_begin = document.getElementById("scroll_begin");    
    //alert(scroll_begin.scrollWidth);    
    var scroll_end = document.getElementById("scroll_end");    
    var scroll_div = document.getElementById("scroll_div");    
    if ($(scroll_begin).width() > parseInt(document.body.clientWidth) / 2) {    
        scroll_end.innerHTML = scroll_begin.innerHTML;    
        function Marquee() {    
            if (scroll_end.offsetWidth - scroll_div.scrollLeft <= 0)    
                scroll_div.scrollLeft -= scroll_begin.offsetWidth    
            else    
                scroll_div.scrollLeft++    
        }    
        var MyMar = setInterval(Marquee, speed);    
        scroll_div.onmouseover = function() { clearInterval(MyMar) }    
        scroll_div.onmouseout = function() { MyMar = setInterval(Marquee, speed) }    
    }    
}    
</script>  
<?php $jx = $room['domain'] == 'jx';?>
<?php if(!$jx){?>
<div class="dhtop">
<?php }else{?>
<div class="dhtop4">
<?php }?>
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhind0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('cloud')?>"></a></li>
<?php if(!$jx){?>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<?php }?>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
</div>
<?php
if(!empty($roomdetail['floatadimg']) && !empty($roomdetail['floatadurl'])) {
	// $syurl = "http://static.ebanhui.com/ebh/file/syjiazhang.htm";
	// $syimg = "http://static.ebanhui.com/ebh/tpl/default/images/syjiazhangshu.jpg";
	// $syimg2 = "http://static.ebanhui.com/ebh/tpl/default/images/syjiazhangshu.jp";
	$syurl = $roomdetail['floatadurl'];
	$syimg = $roomdetail['floatadimg'];
	if(substr($syurl,0,7)!='http://')
		$syurl = 'http://'.$syurl;

?>
<?php if($roomdetail['domain'] == 'mst') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:448px;height:149px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="<?= "http://static.ebanhui.com/ebh/file/mstyi.htm" ?>" _fcksavedurl="/" target="_blank" title="致高一学生家长的一封信">
</a>
<a class="fenstbtn" href="<?= "http://static.ebanhui.com/ebh/file/mstsan.htm" ?>" _fcksavedurl="/" target="_blank" title="致高三学生家长的一封信">
</a>
</div>
<?php } else if($roomdetail['domain'] == 'rqzx') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/xszx.htm" _fcksavedurl="/" target="_blank" title="高一">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/xszxer.htm" _fcksavedurl="/" target="_blank" title="高二"> 
</a>
</div>
<?php } else if($roomdetail['domain'] == 'hztmhs') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hztmhsone.htm" _fcksavedurl="/" target="_blank" title="新高一课程安排">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/hztmhs.htm" _fcksavedurl="/" target="_blank" title="新高二课程安排"> 
</a>
</div>
<?php } else if($roomdetail['domain'] == 'gdtzzx') { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/gdtzzx.htm" _fcksavedurl="/" target="_blank" title="家长书">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/gdkb.htm" _fcksavedurl="/" target="_blank" title="课表"> 
</a>
</div>
<?php } elseif($roomdetail['domain'] == 'yywz'){?>
<div id="edrghgh" style="position:absolute;z-index:1001;width:497px;height:155px;background:url(<?= $syimg ?>) no-repeat;">
<!--链接地址-->
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/yywz.htm" _fcksavedurl="/" target="_blank" title="家长书">
</a>
<a class="fenstbtn" href="http://static.ebanhui.com/ebh/file/yywz2.htm" _fcksavedurl="/" target="_blank" title="课表"> 
</a>
</div>
<?php }else { ?>
<div id="edrghgh" style="position:absolute;z-index:1001;">
<!--链接地址--><a href="<?= $syurl ?>" _fcksavedurl="/" target="_blank">
<!--图片地址--><img src="<?= $syimg ?>" _fcksavedurl="<?= $syimg ?>" border="0">
</a>
</div>
<?php } ?>
<script>
var x = 398,y = 124
var xin = true, yin = true
var step = 1
var delay = 10
var obj=document.getElementById("edrghgh")
function floatwww_qpsh_com() {
var L=T=0
var R= $("body").width()-$("#edrghgh").width();
//var B = $("body").height()-$("#edrghgh").height();
var B = 768;
//obj.style.left = x + document.body.scrollLeft
//obj.style.top = y + document.body.scrollTop
$("#edrghgh").css("left",x+$("body").scrollLeft());
$("#edrghgh").css("top",y+$("body").scrollTop());
x = x + step*(xin?1:-1)
if (x < L) { xin = true; x = L}
if (x > R){ xin = false; x = R}
y = y + step*(yin?1:-1)
if (y < T) { yin = true; y = T }
if (y > B) { yin = false; y = B }
}
var itl= setInterval("floatwww_qpsh_com()", delay)
obj.onmouseover=function(){clearInterval(itl)}
obj.onmouseout=function(){itl=setInterval("floatwww_qpsh_com()", delay)} 
</script>
<?php } ?>
<div style="clear:both"></div>
<?php if(empty($announcementlist)) {
	$announcementlist = array();
	$announcementlist[] = array('message'=>'各位同学家长，网上学习课堂已经正式开始，还未报名的家长，抓紧时间报名，之前的课程仍然可以观看。');
	$announcementlist[] = array('message'=>'网络课堂最大的优点是时间自由，地点自由，可以在任何时间任何地点反复学习。同学们可以好好利用这一点更加高效的学习。');
	$announcementlist[] = array('message'=>'同学们，听完课后有不懂的地方，老师在答疑专区等着你来提问哦。');
}
?>
<?php if(!empty($announcementlist)){?>
<div style="background:#ffffe1;border: 1px solid #efd24c;color: #000000;font-size: 14px;height: 38px;line-height: 38px;margin: 10px auto;text-align: center;width: 958px;"> 
    <!--#####滚动区域#####-->    
    <div id="scroll_div" class="scroll_div">    
      <div id="scroll_begin">    
        <ul>    
			<?php foreach($announcementlist as $announcement){?>
          <li><?=$announcement['message']?></li> 
		  <?php }?>
        </ul>    
      </div>    
      <div id="scroll_end"></div>    
    </div>    
    <!--#####滚动区域#####-->      
  <script type="text/javascript">ScrollImgLeft();</script>    
</div>
<?php }?>
<div class="zzind">
<div class="fontxian">
<div class="lefzong">
<div class="zongjie" style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/zzjsbg0412.jpg) no-repeat;<?=empty($mitemlist)?'height:190px':''?>">
<div style="float:left;width:190px;">
<div class="leftu">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="100" height="100" />
</div>
<?php if(count($opencountlist)>2){?>
<div class="xueping">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/hdaliangx1211.png">
</div>
<?php }?>
</div>
<div class="rigjj" style="position: relative;">
<a href="javascript:void(0)" class="lsts" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/linkqq.jpg"></a>
<h2 class="titlan"><?= $room['crname']?></h2>
<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$pre = 'http://';
}else{
	$pre = '';
}
?>
<p class="youxx" style="width:450px;padding-left:25px;line-height:24px;"><a href="<?= $pre.$room['cremail']?>"><?= $room['cremail']?></a>
<?php if($room['domain'] == 'mst'){?> &nbsp;&nbsp;<font color="red">咨询电话：袁老师 15306899897</font><?php } ?></p>
<p class="ploes" style="height:105px"><?= shortstr($room['summary'],300)?></p>


<?php 
if(!empty($mitemlist)){
foreach($mitemlist as $value){
	$newsurl = geturl('dyinformation/'.$value['itemid']);
	?>
	<div class="auli" style="width:230px">
	&bull; <a style="text-decoration:underline" href="<?= $newsurl ?>" title="<?= $value['subject']?>" target="_blank"><span class="cfrgt"><?= shortstr($value['subject'],24)?></span></a>
	
	</div>
	<?php }
	} ?>


</div>
</div>


<div class="zizhan">
	<div class="fewof">
		<ul>
	<?php 
	$i = 0;
	$inittid = 0;
	//foreach($termlist as $splist){
		foreach($splist as $spkey=>$sp) { 
			if(!empty($sp['itemlist']) && is_array($sp)) {
//			if($inittid==0)
//				$inittid = $sp['tid'];
			?>
			<li class="tsub" <?= ($inittid !=0) ? 'style="display:none;"':'' ?>>
			<div id="sp_<?= $sp['pid'] ?>" class="sp_div <?= $i == 0 ?'leraten':''?>">
				<a href="javascript:void(0)" ><?= ssubstrch($sp['pname'],0,24) ?></a>
			</div>
			</li>
		<?php 
		$i ++;
			}
		}
	//}
	?>
		</ul>
	</div>
</div>

<?php 
	$i = 0;
	//foreach($termlist as $splist){
	$spshowcount = 0;
	foreach($splist as $spkey=>$sp) { 
		if(empty($sp['itemlist']) || !is_array($sp))
			continue;
		$spshowcount ++;
		?>
<div id="itempid_<?= $sp['pid'] ?>" class="append_new " <?= $i == 0? '' : 'style="display:none;"' ?> >
	<?php
	$itemi = 0;
	$lastsid = '';
	foreach($sp['itemlist'] as $k=>$item) {
		$furl = '';
		if($item['fprice'] == 0 || isset($mylist[$item['folderid']])) {
			if(empty($room['iscollege']))
				$furl = '/myroom/stusubject/'.$item['folderid'].'.html';
			else
				$furl = '/myroom.html?url=/myroom/college/study/cwlist/'.$item['folderid'].'.html';
		} else {
			
			$furl = '/ibuy.html?itemid='.$item['itemid'];
			if(!empty($item['sid']) && isset($sortlist[$item['sid']])) {
				$furl .= '&sid='.$item['sid'];
			}
			if($room['domain'] == 'yxwl') {	//易学yxwl
				$furl = '/classactive/bank.html';
			}
		}
		
		
		if($item['sid']!=$lastsid){
			$itemcount = count($sp['itemlist']);
			$speakers = '';
			for($i=$k;$i<$itemcount;$i++){
				if($item['sid'] == $sp['itemlist'][$i]['sid'])
					$speakers .= ' '.$sp['itemlist'][$i]['speaker'];
				else
					break;
			}
			
			if(empty($item['showbysort'])){
		?>
		
		<h2 class="xiaotiter" style="float:left">
			<span style="float: left; width: 719px;color:blue"><?=empty($item['sname'])?(empty($sp['itemlist'][0]['sname'])==1?'所有课程':'其他课程'):$item['sname']?></span>
		</h2>
			<?php }else{
				
				
				if(empty($user))
					$fsurl = 'href="javascript:void(0);"class="dologin" name="/ibuy.html?sid='.$item['sid'].'"';
				elseif($user['groupid'] == 6)
					$fsurl = 'href="/ibuy.html?sid='.$item['sid'].'" target="_blank"';
				else
					$fsurl = 'href="javascript:void(0);" onclick="alert(\'对不起，您是教师账号，不允许进行此操作。\')"';
				?>
			
			
			<div class=""  style="margin-top:15px;width:719px;height:195px;">
			<ul>
	<li class="huanqiu linewline" style="width:719px;margin:0;height:195px;">
		<div onmouseover="this.className='enidets'" onmouseout="this.className='enidet'" class="enidet" style="width:717px;height:190px;">
		<div style="display:inline;width:230px;height:170px;" class="dettu" >
		<?php $sortimage = '';?>
		<a href="javascript:void(0)" onclick="showundersort(<?=$item['sid']?>)">
		<img width="230" height="170" style="opacity: 1;" src="<?=$item['simg']?>">
		</a>
		</div>
<div class="rigxiaox" style="width:460px;">
		<h3 class="kjname" style="width:440px;">
		<a style="color:blue;font-size:16px;" href="javascript:void(0)" onclick="showundersort(<?=$item['sid']?>)" title="<?=$item['sname']?>"><?=$sp['pname']?> <?=$item['sname']?></a>
		</h3>
	<p><a class="zhutk" style="width:460px;" href="javascript:void(0)" onclick="showundersort(<?=$item['sid']?>)"><?=$speakers?></a></p>
	<p class="fottpp" style="width:460px;"><?=$item['content']?></p>

		</div>
				<a <?=$fsurl?> style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: right;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;margin-right:10px;">报 名</a>
				</div>
		</li>
		</ul>
	</div>
			
			
			
		<?php
			}
		$lastsid = $item['sid'];
		$itemi = 0;
		}
		if(empty($user)) {
			$sbsstr = '';
			if($item['showbysort']==1)
				$sbsstr = 'sbs sbs'.$item['sid'];
	?>
	<ul class="<?=$sbsstr?>">
		<li class="huanqiu linewline" <?= ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') ?>>
		<div class="enidet" onmouseout="this.className='enidet'" onmouseover="this.className='enidets'">
		<h3 class="kjname">
		<a href="<?= geturl('courseinfo/'.$item['itemid']) ?>" target="_blank" title="<?= $item['iname'] ?>" class="" name="<?= $furl ?>"><?= ssubstrch($item['iname'],0,28) ?></a>
		</h3>
		<div class="dettu" style="display:inline;">
		<a class="" target="_blank" href="<?= geturl('courseinfo/'.$item['itemid']) ?>" name="<?= $furl ?>">
		<img width="114" height="159" src="<?= empty($item['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' :$item['img'] ?> " style="opacity: 1;">
		</a>
		</div>
	<div class="rigxiaox">
	<p><a href="<?= geturl('courseinfo/'.$item['itemid']) ?>" class="zhutk"><?=!empty($item['speaker'])?$item['speaker']:''?></a></p>
	<p class="fottpp"><?= shortstr($item['isummary'],110)?></p>

		</div>
		<div style="width:90px;height:40px;float:left;display:block">
		<?php 
			$viewnumlib = Ebh::app()->lib('Viewnum');
			$viewnum = $viewnumlib->getViewnum('folder',$item['folderid']);
		?>
		<?php if(!empty($item['coursewarenum']) && !empty($viewnum)){?>
			<p class="botthui" style="width:82px;">
	课 时：
	<span><?= $item['coursewarenum']?></span>
	</p>
	<p class="botthui">
	人 气：
	<span><?= $viewnum?></span>
	</p>
	<?php }?>
	</div>
		<?php if($item['fprice']==0) { ?>
		<a href="javascript:void(0);" class="dologin" name="<?= $furl ?>" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;">试听课程</a>
		<?php } else {
			if(empty($item['cannotpay'])){?>
			<a href="javascript:void(0);" class="dologin" name="<?= $furl ?>" style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;">报 名</a>
			<?php }else{?>
			<a href="javascript:void(0);" class="" name="<?= $furl ?>" style="background: none repeat scroll 0 0 #888888;color: #ffffff;cursor: default;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #888888;margin-top:10px;">报 名</a>
		
			<?php }} ?>
		</div>
		</li>
		</ul>
	<?php 
		} else {
			if($user['groupid'] != 6) {
				$isteacher = 1;
				$furl = "javascript:alert('对不起，您是教师账号，不允许进行此操作。');";
			}
			$sbsstr = '';
			if($item['showbysort']==1)
				$sbsstr = 'sbs sbs'.$item['sid'];
	?>
	<ul class="<?=$sbsstr?>">
	<li class="huanqiu linewline" <?= ((($itemi +1)% 2 == 0) ?' style="margin-right:0;"':'') ?>>
		<div class="enidet" onmouseout="this.className='enidet'" onmouseover="this.className='enidets'">
		<h3 class="kjname">
		<a title="<?= $item['iname'] ?>" target="_blank" href="<?= geturl('courseinfo/'.$item['itemid']) ?>"><?= ssubstrch($item['iname'],0,28) ?></a>
		</h3>
		<div class="dettu" style="display:inline;">
		<a class="" target="_blank" href="<?= geturl('courseinfo/'.$item['itemid']) ?>">
		<img width="114" height="159" src="<?= empty($item['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' :$item['img'] ?> " style="opacity: 1;">
		</a>
		</div>
<div class="rigxiaox">
	<p><a href="<?= geturl('courseinfo/'.$item['itemid']) ?>" class="zhutk"><?=!empty($item['speaker'])?$item['speaker']:''?></a></p>
	<p class="fottpp"><?= shortstr($item['isummary'],110)?></p>


		</div>
		<div style="width:90px;height:40px;float:left;display:block;">
		<?php 
			$viewnumlib = Ebh::app()->lib('Viewnum');
			$viewnum = $viewnumlib->getViewnum('folder',$item['folderid']);
		?>
		<?php if(!empty($item['coursewarenum']) && !empty($viewnum)){?>
			<p class="botthui" style="width:82px;">
	课 时：
	<span><?= $item['coursewarenum']?></span>
	</p>
	<p class="botthui">
	人 气：
	<span><?= $viewnum?></span>
	</p>
	<?php }?>
	</div>
		<?php if($item['fprice']==0) { ?>
		<a href="<?= $furl ?>" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;">试听课程</a>
		<?php } else { 
			if(!isset($mylist[$item['folderid']])) {
				if(empty($item['cannotpay'])){
		?>
		<a href="<?= $furl ?>" <?=empty($isteacher)?'target="_blank"':''?> style="background: none repeat scroll 0 0 #ea732f;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #d6682a;margin-top:10px;">报 名</a>
				<?php }else{?>
		<a href="javascript:void(0)" <?=empty($isteacher)?'target="_blank"':''?> style="background: none repeat scroll 0 0 #888888;color: #ffffff;cursor: default;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #888888;margin-top:10px;">报 名</a>
				<?php }} else { ?>
		<a href="<?= $furl ?>" <?=empty($isteacher)?'target="_blank"':''?>target="_blank" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 100px;font-size:14px;border:solid 1px #0d9be9;margin-top:10px;">进 入</a>
		<?php } 
		}
		?>
		</div>
		</li>
		</ul>
	<?php
			}
		$itemi ++;
		}
	?>
</div><?php 
	$i ++;
	}//} 
	?>
</div>
<div class="lefadlo">
<div class="toplogo">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/usetit0217.jpg" />
<?php if(!empty($user)) { ?>
	<?php 
			$sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
		?>
	<div class="tuxiang">
	<div class="tukuang" style="margin-left:20px;margin-top:18px;_margin-left:10px;">
	<img src="<?= $facethumb ?>"/></div>
	<div style="float:left;margin-top:20px;width:105px; overflow:hidden;"><p style="font-weight:bold;font-size:14px;width:105px; overflow:hidden;max-height:22px;"><?=empty($user['realname'])?$user['username']:$user['realname'] ?></p><p>上次登录时间:</p><p><?= $user['lastlogintime']?></p></div>
	</div>
	<?php if($user['groupid'] == 6){ ?>
	<input class="msjinr" type="submit" name="Submit" value="马上进入" onclick="window.location.href='<?= geturl('myroom')?>'" />
	<?php }else{ ?>
	<input class="msjinr" type="submit" name="Submit" value="马上进入" onclick="window.location.href='<?= geturl('troom')?>'"/>
	<?php } ?>
	<div class="fotlog">
	<?php if($user['groupid'] == 6){ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<?php }else{ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<?php } ?>
	</div>
<?php }else{ ?>
<form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
		<input type="hidden" name="loginsubmit" value="1" />
	<div class="useer">
	<input class="zhangh2" id="username" name="username" type="text" value="请输入账号" onfocus="if ($('#username').val() == '请输入账号'){$('#username').val('').css('color', '#000000'); }" onblur="if ($('#username').val() == ''){$('#username').val('请输入账号').css('color', '#C3C3C3'); }" maxlength="20"/>
	</div>
	<div class="useer">
	<input class="pass2" id="password" name="password" type="password" value="" maxlength="16"/>
	</div>
	<div class="fuxuan">
	<input type="checkbox" id="cookietime" name="cookietime" value="1"  checked='checked' style="margin-top:2px;float:left;"/>
	<label for="cookietime" style="float:left;color:#888;">下次自动登录</label></div>
	<input class="logobtn" type="submit" name="Submit" value="立即登录" />
	<div class="qtlol" style="height:20px; width:210px">
	<?php if(!$jx){?>
<span style="color:#808080;">用其他账号登录：</span>
<a href="<?=getopenloginurl('qq',$currentdomain)?>">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqico0925.jpg">
</a>
<a href="<?=getopenloginurl('sina',$currentdomain)?>">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/sianico0925.jpg">
</a>
<a href="<?=getopenloginurl('wx',$currentdomain)?>">
	<img src="https://open.weixin.qq.com/zh_CN/htmledition/res/assets/res-design-download/icon16_wx_logo.png" />
</a>
	<?php }?>
</div>
	<?php if(empty($user)){	?>
	<div class="fotlog">
		<a style="color:#808080;" href="javascript:void(0)" onclick="showreg('/register/inpage.html','注册账号')">用户注册</a> |
		<a style="color:#808080;" href="/forget.html">忘记密码？</a>
	</div>
	<?php } ?>
</form>
<?php } ?>
</div>
<?php 
if(!$jx){?>
<div class="zixunku">
<ul>
<li><a target="_blank" href="http://www.ebh.net/news/7938.html">九种影响孩子一生的能力</a></li>
<li><a target="_blank" href="http://www.ebh.net/motivation/7236.html">幸福生活的智慧老子思辨哲学</a></li>
<li><a target="_blank" href="http://www.ebh.net/motivation/7618.html">文章不长，但至少价值500亿！</a></li>
<li><a target="_blank" href="http://www.ebh.net/motivation/7586.html">我最佩服的一位坐牢的75岁老人！</a></li>
<li><a target="_blank" href="http://www.ebh.net/lfk/7602.html">一图了解全国教育发展的"大数据"</a></li>
<!--
<li><a target="_blank" href="http://www.ebh.net/news/8458.html">什么是空中课堂</a></li>
<li><a target="_blank" href="http://www.ebh.net/news/8457.html">什么是“翻转课堂”</a></li>
<li><a target="_blank" href="http://www.ebh.net/news/8453.html">慕课知识普及</a></li>-->
</ul>
</div>
<?php }?>
<?php 
if($roomdetail['showusername']==1) { ?>
<div class="sanad" style="height:760px;margin-top:12px">
<a id="getusername" href="javascript:;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/chaxunbanner.gif" /></a>
<?php } else { ?>
<div class="sanad" style="height:635px;margin-top:12px">
<?php } ?>
<?php
$helpurl = 'http://static.ebanhui.com/help/cz_issue.htm';
if($room['domain'] == 'yuhuan') {
	$helpurl = 'http://static.ebanhui.com/help/yh_ktliu.htm';
}

$studyurl = 'http://static.ebanhui.com/help/bfq_install.htm';
$dayiurl = 'http://static.ebanhui.com/help/dayiru.htm';
?>
<?php if(!$jx) {?>
<a target="_blank" href="<?= $helpurl ?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/ruhechongzhi.jpg" /></a>
<?php } ?>
<a target="_blank" href="<?= $studyurl ?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/rengbuneng.jpg" /></a>
<a target="_blank" href="<?= $dayiurl ?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dayiru.jpg" /></a>

<?php if(!$jx){?>
<a target="_blank" href="http://www.ebanhui.com/faq.html"><img src="http://static.ebanhui.com/ebh/tpl/default/images/changjian.jpg" /></a>
<a target="_blank" href="http://pay.ebh.net/index.html?fromurl=http://<?= $room['domain']?>.ebh.net/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/ciafhtt.jpg" /></a>
<?php }?>
<div class="news-container" style="width: 208px; margin-left:20px;">
<ul>
<?php
foreach($opencountlist as $opencount){
	$rnlength = strlen($opencount['realname']);
	
	$realname = '*'.mb_substr($opencount['realname'],-($rnlength/3-1),2,'utf-8');
?>
	
	<li style="height:40px;"><span style="color:blue"><?= shortstr($opencount['username'], 2, '***').substr($opencount['username'],-2)?>(<?=$realname?>)</span> <br/><?='开通 '.$opencount['oname'].' 服务'?></li>
<?php
	}
?>
</ul>
</div>
<?php if($jx){?>
<div style="width:200px;line-height:1.8;margin-left:15px;margin-top:20px;color:#666;">
<p>各位家长，网校相关问题请咨询自己所在区域的老师，各区县咨询电话： </p>
<p><span style="color:red;">海宁：</span>刘阳老师   18657378788</p>
<p><span style="color:red;">平湖：</span>许艮艮老师 13067500008</p>
<p><span style="color:red;">桐乡：</span>葛潜林老师 17755645991</p>
<p><span style="color:red;">嘉善：</span>倪东东老师 15857344520</p>
<p><span style="color:red;">海盐：</span>许成旺老师 15605737778</p>
<p><span style="color:red;">南湖：</span>许彩红老师 15505731188</p>
</div>
<?php }?>
</div>
<?php if($this->uri->uri_domain() == 'sxyz') {?>
<a href="http://static.ebanhui.com/help/huokailiu.htm"><img src="http://static.ebanhui.com/ebh/images/banner1.jpg"></a>
<a href="http://static.ebanhui.com/help/zhiboliu.htm"><img src="http://static.ebanhui.com/ebh/images/banner2.jpg"></a>
<?php } ?>
<?php if($this->uri->uri_domain() == 'tb') {?>
<div class="sanad" style="margin-top:20px;">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/ad010411.jpg" class="">
</div>
<?php } ?>
</div>
</div>

</div>
<div style="clear:both"></div>
<!--用户名查询系统-->
<style type="text/css">
.fl{float:left;}
.fr{float:right;}
.clear{clear:both;}
.mt20 {margin-top: 20px;}
.ui-dialog-title{padding: 11px 15px; font-weight: normal;}
</style>
<div id="dialogdetail" style="display:none;">
	<div style="width:665px;">
		<div class="yhcxxtf">
		    <div class="yhcxxt">
		        <div>
		            <div class="tishi"><span style="color:#ff0000;">*</span>如果你已经取得账号并且修改过密码，那么用你的账号及你的密码<a id="login_btn" href="javascript:;" style="color:#ff0000;">登录</a>或者<a href="/forget.html" style="color:#ff0000;">取回密码</a></div>
		            <div class="chaxun">
		                <div class="szschool mt20">
		                    <span class="elxian fl">所在学校：</span>
		                    <select id="crname" onchange="hided()" class="fl ertyu"></select>
		                </div>
		                <div class="clear"></div>
		                <div class="names mt20">
		                    <span class="elxian fl">姓名：</span>
		                    <input class="ertyu ertyus" id="search_name" type="text" onchange="hided()" />
		                </div>
		                <a href="javascript:;" id="dosearch" class="chabtn">查&nbsp;询</a>
		            </div>
		        </div>

		        <div style="height:133px;">
		        	<input id="default_password" type="hidden" />
			        <!--查询成功-->
			        <div class="cxright" style="display:none;">
			            <p class="chenggbtn">查询成功！<span id="result_realname" style="color:#ff0000;"></span>&nbsp;同学您好，</p>
			            <p class="chenggbtns"><span class="chenggbtn1">您的账号：</span><span id="result_username" style="padding:0 8px;color:#18a8f7; font-size:30px; font-family:微软雅黑;"></span>(牢记此账号用于登录学习）</p>
			            <p class="chenggbtns p1s"><span id="result_password_span" class="chenggbtn1 fl">默认密码：</span><span id="result_password" class="span1s fl" style="padding:0 8px;"></span><a id="logbtn" href="javascript:;" class="chabtns fl">立即登录</a>&nbsp;(登录后请及时修改密码）</p>
			        </div>
			        <!--查询失败-->
			        <div class="cxfalse" style="display:none;">
			            <p class="p1">查询错误！</p>
			            <p>没有您的账号信息，请核对学校及姓名，如有</p>
			            <p>问题请及时联系客服。</p>
			        </div>
			    </div>

		        <div class="relation">
		            <div class="relation_son">
		            <?php if($room['domain'] == 'anhui') { ?>
		                <div class="yxdh">
		                    <div class="phone fl">0556-5358377 / 5275114</div>
		                    <div class="email fr">邮箱：543349578@qq.com</div>
		                </div>
		                <div class="clear"></div>
		                <div class="qq">
		                    <span class="fl" style="color:#626262; display:block;">咨询:&nbsp;</span>
		                    <a href="http://wpa.qq.com/msgrd?v=3&uin=543349578&site=qq&menu=yes" target="_blank" class="qqlx fl">客服01</a>
		                </div>
		            <?php } else { ?>
		                <div class="yxdh">
		                    <div class="phone fl">0571-88252183 / 88252153</div>
		                    <div class="email fr">ebanhui@qq.com</div>
		                </div>
		                <div class="clear"></div>
		                <div class="qq">
		                    <span class="fl" style="color:#626262; display:block;">咨询:&nbsp;</span>
		                    <a href="http://wpa.qq.com/msgrd?v=3&uin=6488479&site=qq&menu=yes" target="_blank" class="qqlx fl">客服01</a>
		                    <a href="http://wpa.qq.com/msgrd?v=3&uin=15335667&site=qq&menu=yes" target="_blank" class="qqlx fr">客服02</a>
		                </div>
		            <?php } ?>
		            </div>
		        </div>
		    </div>
		</div>

	</div>
</div>
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->
<script type="text/javascript">
$(function(){
	//打开查询对话框
	$("#getusername").click(function(){
		if(!H.get('dialogdetail')){
			H.create(new P({
				id : 'dialogdetail',
				title: '用户名查询系统',
				easy:true,
				width:665,
				padding:0,
				content:$('#dialogdetail')[0]
			}),'common');
		}

		//初始化学校列表和默认密码
		$.post("<?=geturl('getusername/getinfo')?>", function(data){
			if(data != undefined && data.crlist != undefined && data.defaultpass != undefined ){
				$("#crname").html('');
				$.each(data.crlist, function(i, n){
					$("#crname").append('<option value="'+n+'">'+n+'</option>');
				});
				if ($("#crname option").size()>1)
				{
					$("#crname").get(0).selectedIndex=0;
				}
				$("#default_password").val(data.defaultpass);
			}
		}, "json");
		H.get('dialogdetail').exec('show');
	});

	//立即登录
	$("#logbtn,#login_btn").click(function(){
		H.get('dialogdetail').exec('close');
		$.loginDialog();
		var result_username = $("#result_username").html();
		if (result_username != '') {
			$("#uname").val(result_username);
		}
	});

	//查询
	$("#dosearch").click(function(){
		var crname = $('#crname').val();
		var search_name = $('#search_name').val();
		var defaultpass = $("#default_password").val();
		$.ajax({
			url:'/getusername.html',
			type:'post',
			data:{'crname':crname,'realname':search_name},
			success:function(data){
				if(data != undefined && data == 0){
					$('.cxright').css('display','none');
					$('.cxfalse').css('display','block');
				}else{
					res = eval('('+(data)+')');
					$('.cxfalse').css('display','none');
					$('.cxright').css('display','block');
					$('#result_username').html(res.username);
					$('#result_realname').html(res.realname);
					if(res.password){
						$('#result_password_span').html('您的密码：');
						$('#result_password').html(res.password);
					}
					else{
						$('#result_password_span').html('默认密码：');
						$('#result_password').html(defaultpass);
					}
				}
			}
		});
	});

});

function hided(){
	$('.cxright').css('display','none');
	$('.cxfalse').css('display','none');
}
</script>
<script type="text/javascript">
<!--
	$(".dologin").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
	var curid = 0;
	var curidt = 0;
	var firstclick = 0;
	$(document).ready(function () {
            //滚动新闻条
            $('.news-container').vTicker({
                speed: 500,
                pause: 1000,
                showItems: 11,
                animation: 'fade',
                mousePause: false,
                height: 0,
                direction: 'up'
            });
			$(".sp_div").click(function(){
				var sp_id = $(this).attr("id");
				if(sp_id != "" && sp_id != undefined) {
					sp_id = sp_id.substring(3);
					if(sp_id != curid) {
						$(".sp_div").removeClass("leraten");
						$(this).addClass("leraten");
						$(".append_new").hide();
						$("#itempid_" + sp_id).show();
						curid = sp_id;
					}
				}
				setCookie('ebh_spselected',sp_id);
			});
			// $(".st_div").click(function(){
				// var st_id = $(this).attr("id");
				// if(st_id != "" && st_id != undefined) {
					// st_id = st_id.substring(3);
					// if(st_id != curidt) {
						// $(".st_div").removeClass("leraten1");
						// $(this).addClass("leraten1");
						// $(".tsub").hide();
						// $(".tsub_"+st_id).show();
						// $(".append_new").hide();
						// $(".sp_div").removeClass("leraten");
						// $(".tsub_"+st_id+" div:first").addClass("leraten");
						// curid = $(".tsub_"+st_id+" div:first").attr("id").substring(3);
						// $("#itempid_" + curid).show();
						// curidt = st_id;
					// }
				// }
				// if(firstclick==1)
					// setCookie('ebh_spselected',curid);
				// setCookie('ebh_stselected',st_id);
			// });
			// var historystid = getcookie('ebh_stselected');
			// if(historystid!=''){
				// $("#st_"+historystid).click();
				// firstclick = 1;
			// }
			var spcounthistory =  getcookie('ebh_spcount');
			if(spcounthistory == '' || spcounthistory != <?=$spshowcount?>){
				setCookie('ebh_spcount',<?=$spshowcount?>);
				setCookie('ebh_spselected','');
			}else{
				var historyspid = getcookie('ebh_spselected');
				if(historyspid!=''){
					$("#sp_"+historyspid).click();
				}
			}
        });
		
	function showreg(url,title){
		height = 530;
		width = 645;
		var html = '<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
		H.create(new P({
			id:'artdialogreg',
			title:title,
			content:html,
			easy:true,
			padding:10
		}),'common').exec('show');
	}
	function showundersort(sid){
		var showed = $('.sbs'+sid).css('display');
	
		if(showed == 'none')
			$('.sbs'+sid).show();
		else
			$('.sbs'+sid).hide();
	}
//-->

</script>
<?php
$this->display('common/footer');
?>