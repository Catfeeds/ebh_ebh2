<?php $this->display('shop/zwx/header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.vticker-min.js"></script>

<style type="text/css">   
.scroll_div {width:958px;margin:0 auto;overflow: hidden;white-space: nowrap;}
#scroll_begin, #scroll_end, #scroll_begin ul, #scroll_end ul, #scroll_begin ul li, #scroll_end ul li{display:inline;}  
#scroll_begin ul li {margin-left:15px;}

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

<?php $this->display('common/up_header'); ?>
<div class="dhtop3">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhind0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>

</ul>
</div>
</div>
<div id="edrghgh" style="position:absolute;z-index:1001;">
<!--链接地址--><a href="http://static.ebanhui.com/ebh/file/jiazhang.htm" _fcksavedurl="/" target="_blank">
<!--图片地址--><img src="http://static.ebanhui.com/ebh/tpl/default/images/edrghgh.jpg" _fcksavedurl="http://static.ebanhui.com/ebh/tpl/default/images/edrghgh.jp" border="0">
</a>
</div>
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
<div style="clear:both"></div>
<div style="background:#ffffe1;border: 1px solid #efd24c;color: #000000;font-size: 14px;height: 38px;line-height: 38px;margin: 10px auto;text-align: center;width: 958px;"> 
    <!--#####滚动区域#####-->    
    <div id="scroll_div" class="scroll_div">    
      <div id="scroll_begin">    
        <ul>    
          <li>各位同学家长，上虞新高一衔接课堂已经正式开始，还未报名的家长，抓紧时间报名，之前的课程仍然可以观看。</li>    
          <li>网络课堂最大的优点是时间自由，地点自由，可以在任何时间任何地点反复学习。同学们可以好好利用这一点更加高效的学习。</li>    
          <li>同学们，听完课后有不懂的地方，老师在答疑专区等着你来提问哦。</li>  
        </ul>    
      </div>    
      <div id="scroll_end"></div>    
    </div>    
    <!--#####滚动区域#####-->      
  <script type="text/javascript">ScrollImgLeft();</script>    
</div>
<div class="zzind">
<div class="fontxian">
<div class="lefzong">
<div class="zongjie">
<div class="leftu">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="100" height="100" />
</div>
<div class="rigjj">
<h2 class="titlan"><?= $room['crname']?></h2>
<p class="ploes"><?= shortstr($room['summary'],300)?></p>

<ul>
<li class="xinmm"><?= $teacher['realname']?></li>
<?php
if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$room['cremail'])){
	$pre = 'mailto:';
}elseif(substr($room['cremail'],0,7)!='http://'){
	$pre = 'http://';
}else{
	$pre = '';
}
?>
<li class="youxx" style="width:325px;"><a href="<?= $pre.$room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="dianhh"><?= $room['crphone']?></li>
<li class="dizz" style="width:325px;"><?= $room['craddress']?></li>
</ul>
</div>
</div>
<div class="zizhan">
	<div class="fewof" style="float:left;">
	<ul>
	<?php 
	$i = 0;
	foreach($splist as $spkey=>$sp) { ?>
		<li>
		<div id="sp_<?= $sp['pid'] ?>" class="sp_div <?= $i == 0 ?'leraten':''?>">
			<a href="#"><?= $sp['pname'] ?></a>
		</div>
		</li>
	<?php 
	$i ++;
	} ?>
		</ul>
	</div>
	<?php 
	$i = 0;
	foreach($splist as $spkey=>$sp) { ?>
	<ul id="itempid_<?= $sp['pid'] ?>" class="append_new " <?= $i == 0? '' : 'style="display:none;"' ?> >
		<?php
		foreach($sp['itemlist'] as $item) {
		?>
		<li class="kefbuy">
		<div class="leich" onmouseover="this.className='leich1'" onmouseout="this.className='leich'">
		<?php 
			$logo=empty($item['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$item['cface'];
			$cloudurl='http://'.$item['domain'].'.ebanhui.com';
		?>
		<a target="_blank" href="<?= $cloudurl?>" style=" text-decoration:none;"><h3 class="ketit"><?= shortstr($item['iname'],24,'')?></h3></a>
		<div class="kewaik">

		<a target="_blank" href="<?= $cloudurl?>"><img src="<?= $logo?>" style="width:100px;height:100px;"/></a>
		</div>
		<div class="rigxiaox" style="width:88px;height:auto;margin-left:0px;">
		<p class="botthui">课件数：<span><?= ($item['coursenum'])?></span></p>
		<p class="botthui">作业数：<span><?= ($item['examcount'])?></span></p>

		<?php 
			$cloudaddurl = "http://".$item['domain'].".ebanhui.com/classactive.html";
		?>
		<?php if($item['ispublic']==2){?>
		<a target="_blank" href="http://<?= $item['domain']?>.ebanhui.com" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 76px;font-size:14px;border:solid 1px #0d9be9">免费试听</a>
		
		<?php }elseif(empty($user)){ ?>
			<input class="xuexibtns" type="submit" value="开始学习"  onclick="javascript:;"  name='http://<?= $item['domain']?>.ebanhui.com/ibuy.html?itemid=<?= $item['itemid']?>'/>
		<?php }else{ ?>
			<?php if($user['groupid']==6){ ?>
					<input class="xuexibtn" type="submit" name="Submit" value="开始学习" onclick="location.href='http://<?= $item['domain']?>.ebanhui.com/ibuy.html?itemid=<?= $item['itemid']?>'"/>
			<?php }else{ ?>
				<input class="xuexibtn" type="submit" name="Submit" value="马上进入" onclick="location.href='<?= $cloudurl?>'"/>
			<?php } ?>
		<?php } ?>
		</div>
		<p class="fottpp"><?= shortstr($item['isummary'],80)?></p>
		</div>
		</li>
		<?php 
		}
		?>
	</ul>
<?php 
$i ++;
		} ?>
</div>
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
	<div style="float:left;margin-top:20px;"><p style="font-weight:bold;font-size:14px;"><?= $user['username'] ?></p><p>上次登录时间:</p><p><?= $user['lastlogintime']?></p></div>
	</div>
	<?php if($user['groupid'] == 6){ ?>
	<input class="msjinr" type="submit" name="Submit" value="" onclick="window.location.href='<?= geturl('myroom')?>'" />
	<?php }else{ ?>
	<input class="msjinr" type="submit" name="Submit" value="" onclick="window.location.href='<?= geturl('troom')?>'"/>
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
	<span>帐号：</span><input class="zhangh" id="username" name="username" type="text" value="" maxlength="16"/>
	</div>
	<div class="useer">
	<span>密码：</span><input class="pass" id="password" name="password" type="password" value="" maxlength="16"/>
	</div>
	<div class="fuxuan">
	<?php if(!empty($user)){ ?>
	<input id="xuangou" type="checkbox" name="checkbox" value="<?= 3600*24*14?>" checked='checked' style="margin-top:2px;float:left;" />
	<?php }else{ ?>
	<input id="xuangou" type="checkbox" name="checkbox" value="<?= 3600*24*14?>" style="margin-top:2px;float:left;" />
	<?php } ?>
	<label for="xuangou" style="float:left;color:#888;">下次自动登录</label></div>
	<input class="logobtn" type="submit" name="Submit" value="" />
	
	<?php if(empty($user)){	?>

	<div class="fotlog">
	<a href="/forget.html" style="color:#808080;">忘记密码？</a>
	</div>
	<?php }else{ ?>
	<div class="fotlog">
	<a href="/forget.html" style="color:#808080;">忘记密码？</a>
	</div>
	<?php } ?>
</form>
<?php } ?>
</div>

<?php if(!empty($mitemlist)){?>
<div class="zixunku">
<ul>
<?php foreach($mitemlist as $value){ ?>
<li><?= shortstr($value['subject'],30)?></li>
<?php } ?>
</ul>
</div>
<?php } ?>
<div class="sanad">
<a target="_blank" href="/getusername.html"><img src="http://static.ebanhui.com/ebh/tpl/default/images/chaxunbanner.gif" /></a>
<a target="_blank" style="margin:10px 0 10px 34px;float: left;" href="http://static.ebanhui.com/ebh/file/jiazhangshu.doc"><img src="http://static.ebanhui.com/ebh/tpl/default/images/keczai.jpg" /></a>
<a target="_blank" href="http://static.ebanhui.com/help/cz_issue.htm"><img src="http://static.ebanhui.com/ebh/tpl/default/images/ruhechongzhi.jpg" /></a>
<a target="_blank" href="http://static.ebanhui.com/help/bfq_install.htm"><img src="http://static.ebanhui.com/ebh/tpl/default/images/rengbuneng.jpg" /></a>
<a target="_blank" href="http://static.ebanhui.com/help/dayiru.htm"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dayiru.jpg" /></a>
<a target="_blank" href="http://www.ebanhui.com/faq.html"><img src="http://static.ebanhui.com/ebh/tpl/default/images/changjian.jpg" /></a>
<div class="news-container" style="width: 208px; margin-top:320px;*margin-top:28px;margin-left:20px;">
<ul>
<?php
foreach($opencountlist as $opencount){
	$rnlength = strlen($opencount['realname']);
	
	$realname = '*'.mb_substr($opencount['realname'],-($rnlength/3-1),2,'utf-8');
?>
	
	<li style="height:40px;"><span style="color:blue"><?= shortstr($opencount['username'], 2, '***').substr($opencount['username'],-2)?>(<?=$realname?>)</span> <br/>开通了 <?=$opencount['crname']?></li>
<?php
	}
?>
</ul>
</div>
</div>
</div>
</div>
<div class="esrkt">
<h2 class="ektert"><img src="http://static.ebanhui.com/ebh/tpl/default/images/mingtser.jpg" /></h2>
<ul>
<li class="ewkitt">
<div class="waibiank">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/tertu.jpg" />
</div>
<h3 class="ewosht">陈晓明老师&nbsp;&nbsp;主讲数学</h3>
<p style="text-indent:25px;">1968年11月生，浙江省义乌人。1992年8月参加工作，任教于义乌中学；2000年被评为浙江省教坛新秀；2002年破格晋升为中学高级教师；</p>
</li>
<li class="ewkitt">
<div class="waibiank">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/tertu.jpg" />
</div>
<h3 class="ewosht">陈晓明老师&nbsp;&nbsp;主讲数学</h3>
<p style="text-indent:25px;">1968年11月生，浙江省义乌人。1992年8月参加工作，任教于义乌中学；2000年被评为浙江省教坛新秀；2002年破格晋升为中学高级教师；</p>
</li>
<li class="ewkitt">
<div class="waibiank">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/tertu.jpg" />
</div>
<h3 class="ewosht">陈晓明老师&nbsp;&nbsp;主讲数学</h3>
<p style="text-indent:25px;">1968年11月生，浙江省义乌人。1992年8月参加工作，任教于义乌中学；2000年被评为浙江省教坛新秀；2002年破格晋升为中学高级教师；</p>
</li>
<li class="ewkitt" style="margin:0;">
<div class="waibiank">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/tertu.jpg" />
</div>
<h3 class="ewosht">陈晓明老师&nbsp;&nbsp;主讲数学</h3>
<p style="text-indent:25px;">1968年11月生，浙江省义乌人。1992年8月参加工作，任教于义乌中学；2000年被评为浙江省教坛新秀；2002年破格晋升为中学高级教师；</p>
</li>
</ul>

</div>

</div>
<div style="clear:both"></div>
<script type="text/javascript">
<!--
	$(".xuexibtns").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
	var curid = 0;
	$(document).ready(function () {
            //滚动新闻条
            $('.news-container').vTicker({
                speed: 500,
                pause: 1000,
                showItems: 12,
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
			});


        });
//-->

</script>
<?php
$this->display('common/footer');
?>