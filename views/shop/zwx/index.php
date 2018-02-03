<?php $this->display('shop/zwx/header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.lazyload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.vticker-min.js"></script>

<style type="text/css">   
.scroll_div {width:958px;margin:0 auto;overflow: hidden;white-space: nowrap;}
#scroll_begin, #scroll_end, #scroll_begin ul, #scroll_end ul, #scroll_begin ul li, #scroll_end ul li{display:inline;}  
#scroll_begin ul li {margin-left:15px;}
.yinshadow {
    -moz-box-shadow: 3px 3px 4px #cccccc;
    -webkit-box-shadow: 3px 3px 4px #cccccc;
    box-shadow: 3px 3px 4px #cccccc;
    /* For IE 8 */
    -ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#cccccc')";
    /* For IE 5.5 - 7 */
    filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#cccccc');
}
</style>

<div class="dhtop2">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhind0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
</div>

<div style="clear:both"></div>
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
<li class="youxx" style="width:325px;"><a href="mailto:<?= $room['cremail']?>"><?= $room['cremail']?></a></li>
<li class="dianhh"><?= $room['crphone']?></li>
<li class="dizz" style="width:325px;"><?= $room['craddress']?></li>
</ul>
</div>
</div>
<div class="zizhan">
<div class="ziztit">

<img src="http://static.ebanhui.com/ebh/tpl/default/images/titzizhan0411.jpg" /><span style="float:left;">共有子站 <span><?= $zwxcount['count']?></span> 个</span><a href="<?= geturl('platform')?>" class="lieico" style="text-decoration:none;display:inline;">列表</a>
</div>
<ul class="append_new">


<?php if(!empty($zwxlist)){
	 foreach($zwxlist as $v=>$k){
		if($v%3==2){ ?>
	<li class="kefbuy qiues">
		<?php }else{ ?>
	<li class="kefbuy">
		<?php } ?>
	<div class="leich" onmouseover="this.className='leich1'" onmouseout="this.className='leich'">
	<?php 
		$logo=empty($k['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$k['cface'];
		$cloudurl='http://'.$k['domain'].'.ebanhui.com';
	?>
	<a href="<?= $cloudurl?>" style=" text-decoration:none;"><h3 class="ketit"><?= shortstr($k['crname'],24,'')?></h3></a>
	<div class="kewaik">

	<a href="<?= $cloudurl?>"><img src="<?= $logo?>" style="width:100px;height:100px;"/></a>
	</div>
	<div class="rigxiaox">
	<p class="botthui">课件数：<span><?= ($k['coursenum'])?></span></p>
	<p class="botthui">作业数：<span><?= ($k['examcount'])?></span></p>

	<?php 
		$cloudaddurl = "http://".$k['domain'].".ebanhui.com/classactive.html";
	?>
	<?php if($k['ispublic']==2){?>
		<a target="_blank" href="http://<?= $k['domain']?>.ebanhui.com" style="background: none repeat scroll 0 0 #18a8f7;color: #ffffff;cursor: pointer;display: block;float: left;height: 28px;line-height: 28px;text-align: center;text-decoration: none;width: 76px;font-size:14px;border:solid 1px #0d9be9">免费试听</a>
	<?php }elseif(empty($user)){ ?>
		<input class="kaitongbtns" type="submit" value="立即开通"  onclick="javascript:;"/>
	<?php }else{ ?>
		<?php if($user['groupid']==6){ ?>
			<?php if($k['rucount']>0){ ?>
				<input class="xuexibtn" type="submit" name="Submit" value="开始学习" onclick="location.href='<?= $cloudurl?>'"/>
			<?php }else{ ?>
				<input class="kaitongbtns" type="submit" name="Submit" value="立即开通" onclick="location.href='<?= $cloudaddurl?>'"/>
			<?php } ?>
		<?php }else{ ?>
			<input class="xuexibtn" type="submit" name="Submit" value="马上进入" onclick="location.href='<?= $cloudurl?>'"/>
		<?php } ?>
	<?php } ?>
	</div>
	<p class="fottpp"><?= shortstr($k['summary'],80)?></p>
	</div>
	</li>
	 
	<?php } ?>

<?php } ?>
	<?php
		if($room['crid']=='10515'){
		$classroomlib = Ebh::app()->lib('Classroom');
		$classroomlist = $classroomlib->getClassroomdetail('10445,10447');
		if(!empty($classroomlist)){
			foreach($classroomlist as $cl){
	?>
		<li class="kefbuy">
		<div class="leich" onmouseover="this.className='leich1'" onmouseout="this.className='leich'">
				<a target="_blank" href="http://<?=$cl['domain']?>.ebanhui.com" style=" text-decoration:none;"><h3 class="ketit"><?=$cl['crname']?></h3></a>
		<div class="kewaik">

		<a target="_blank" href="http://<?=$cl['domain']?>.ebanhui.com"><img src="<?=$cl['cface']?>" style="width:100px;height:100px;"></a>
		</div>
		<div class="rigxiaox">
		<p class="botthui">课件数：<span><?=$cl['coursenum']?></span></p>
		<p class="botthui">作业数：<span><?=$cl['examcount']?></span></p>

							<input class="xuexibtns" type="submit" value="开始学习" onclick="location.href='http://<?=$cl['domain']?>.ebanhui.com'">
				</div>
		<p class="fottpp"><?= shortstr($cl['summary'],80)?></p>
		</div>
		</li>
	<?php
			}
		}
	}
	?>
</ul>
<script type="text/javascript">
	var crid = "<?= $room['crid']?>" ;
	var page = 1 ;
	
	$(document).ready(function(){
		$(window).scroll(scroll_load);
	});
	
	function scroll_load(){
		var stop = document.body.scrollTop | document.documentElement.scrollTop;
		if ($(".jiazai").offset().top < ($(window).height() + stop - 74)) {
				$(window).unbind('scroll'); 
				page=page+1;//page：页数
				$.ajax({
					url : "<?= geturl('platform/scrolllist')?>",
					data:{'crid':crid,'page':page},
					dataType:'text',
					type	:'post',
					dataType:'json',
					success:function(json){
		//alert(json);
					if(json==''){
						$(".jiazai").hide();
					}
					else{
						var lihtml = "";
						var demohtml = "<!--li-->" +
								   "<div class=\"leich\" onmouseover=\"this.className='leich1'\" onmouseout=\"this.className='leich'\">\r\n" +
								   "<a style=\"text-decoration:none;\" href=\"http://<!--domain-->.ebanhui.com\"><h3 class=\"ketit\"><!--crname--></h3></a>\r\n" +
								   "<div class=\"kewaik\"><a href=\"http://<!--domain-->.ebanhui.com\">\r\n" +
								   "<img style=\"width:100px;height:100px;\" src=\"<!--images-->\" /></a></div>\r\n" +
								   "<div class=\"rigxiaox\">\r\n" +
								   "<p class=\"botthui\">课件数：<span><!--coursenum--></span></p>\r\n" +
								   "<p class=\"botthui\">作业数：<span><!--examcount--></span></p>\r\n" +
								   "<!--input-->" +
								   "</div>\r\n" +
								   "<p class=\"fottpp\"><!--summary--></p>\r\n" +
								   "</div>\r\n</li>";
								for(var i=0;i<json.length;i++){
									lihtml+=demohtml;
									
									if(json[i].cface!="" && json[i].cface!=null)
										lihtml=lihtml.replace("<!--images-->",json[i].cface);
									else
										lihtml=lihtml.replace("<!--images-->",'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg');
											
									if("<?= empty($user)?>"){
										lihtml=lihtml.replace("<!--input-->",'<input class="kaitongbtns" type="submit" name="Submit" value="立即开通" onclick="location.href=\'http://<!--domain-->.ebanhui.com/classactive.html\'"/>');

									}else{
										if("<?= $user['groupid'] == 5?>")
										{
											lihtml=lihtml.replace("<!--input-->",'<input class="xuexibtn" type="submit" name="Submit" value="马上进入" onclick="location.href=\'http://<!--domain-->.ebanhui.com\'"/>');
										}else{
										if(json[i].rucount!=null&&json[i].rucount>0)
											{
											lihtml=lihtml.replace("<!--input-->",'<input class="xuexibtn" type="submit" name="Submit" value="开始学习" onclick="location.href=\'http://<!--domain-->.ebanhui.com\'"/>');
											}
										else
											{
											lihtml=lihtml.replace("<!--input-->",'<input class="kaitongbtns" type="submit" name="Submit" value="立即开通" onclick="location.href=\'http://<!--domain-->.ebanhui.com/classactive.html\'"/>');
											}
										}
									}
									lihtml=lihtml.replace(/<!--domain-->/ig,json[i].domain);
									lihtml=lihtml.replace(/<!--crname-->/ig,json[i].crname);
									lihtml=lihtml.replace(/<!--coursenum-->/ig,json[i].coursenum);
									lihtml=lihtml.replace(/<!--examcount-->/ig,json[i].examcount);

									lihtml=lihtml.replace("<!--li-->",'<li class=\"'+((i%3)==2?'kefbuy qiues':'kefbuy')+'\">');
									lihtml=lihtml.replace(/<!--summary-->/ig,json[i].summary.substring(0,40)+"..." );
								} 
								$(".append_new").append(lihtml);
								// 重新加载
								$(window).scroll(scroll_load);

						}
					}
				});
		
			}
	}
</script>
<div class="jiazai" id="show">数据加载中，请稍后......</div>
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
	<? }else{ ?>
	<input class="msjinr" type="submit" name="Submit" value="" onclick="window.location.href='<?= geturl('troom')?>'"/>
	<? } ?>
	<div class="fotlog">
	<?php if($user['groupid'] == 6){ ?>
	<a href="/classactive.html" style="color:#808080;">开通服务</a> | <a href="/logout.html" style="color:#808080;">退出</a>
	<? }else{ ?>
	<a href="/logout.html" style="color:#808080;">退出</a>
	<? } ?>
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
	<input id="xuangou" type="checkbox" name="checkbox" value="<?= 3600*24*14?>" checked='checked' style="margin-top:4px;_margin-top:-2px;float:left;" />
	<?php }else{ ?>
	<input id="xuangou" type="checkbox" name="checkbox" value="<?= 3600*24*14?>" style="margin-top:4px;_margin-top:-2px;float:left;" />
	<?php } ?>
	<label for="xuangou" style="float:left;color:#888;">下次自动登录</label></div>
	<input class="logobtn" type="submit" name="Submit" value="" />
	<div class="qtlol">
	<span style="color:#808080;">用其他账号登录：</span>
	<a href="<?=geturl('otherlogin/qq')?>">
	<img src="http://static.ebanhui.com/ebh/tpl/default/images/qqico0925.jpg" />
	</a>
	<a href="<?=geturl('otherlogin/sina')?>">
	<img src="http://static.ebanhui.com/ebh/tpl/default/images/sianico0925.jpg" />
	</a>
	</div>
	<?php if(empty($user)){	?>

	<div class="fotlog">
	<a href="/login.html" style="color:#808080;">用户注册</a> | <a href="/forget.html" style="color:#808080;">忘记密码？</a>
	</div>
	<?php }else{ ?>
	<div class="fotlog">
	<a href="/register.html" style="color:#808080;">用户注册</a> | <a href="/forget.html" style="color:#808080;">忘记密码？</a>
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
<div class="sanad" >
<img src="http://static.ebanhui.com/ebh/tpl/default/images/ad010411.jpg" />
</div>
</div>
</div>
</div>
<div style="clear:both"></div>
<script type="text/javascript">
<!--
	$(".kaitongbtns").live('click',function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});

//-->
</script>
<?php
$this->display('common/footer');
?>