<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate.js<?=getv()?>"></script>
<title>课程介绍</title>
</head>
<style type="text/css">
.lvjies a.toug {
	background:#ea732f;
	color:#fff;
	cursor: pointer;
	display: block;
	height: 28px;
	line-height: 28px;
	text-align: center;
	text-decoration: none;
	width: 100px;
	font-size:14px;
	border:solid 1px #d6682a;
	position: absolute;
	right: 0px;
	top: 0px;
}
.lvjies a.dolog {
	background:#18a8f7;
	color:#fff;
	cursor: pointer;
	display: block;
	height: 28px;
	line-height: 28px;
	text-align: center;
	text-decoration: none;
	width: 100px;
	font-size:14px;
	border:solid 1px #0d9be9;
	position: absolute;
	right: 0px;
	top: 0px;
}
#footer p{
	color:#000;
}
#footer{
	background:#f2f2f2;
}
div.logDialog{text-align:left;}
.ui-dialog2-body{padding:20px;}
.ui-dialog2-button{text-align:right;}
/**免费报名弹窗样式**********************/
.baoke {
	width:515px;
	font-family:"Microsoft YaHe";
	text-align:left;
}
.imgrts {
	width:90px;
	height:54px;
	float:left;
}
.suitrna {
	float:left;
	width:400px;
	margin-left:10px;
}
.suitrna h2 {
	font-size:18px;
}
.suitrna .p1 {
	font-size:14px;
	color:#999;
}
.nasirte {
	border:solid 1px #e3e3e3;
	margin:30px 0 20px 0;
	width:510px;
	height:120px;
	float:left;
	position:relative;
}
.titses {
	top:-15px;
	left:20px;
	position:absolute;
	background:#fff;
	padding:0 3px;
	font-size:16px;
}
.paewes {
	width:478px;
	height:96px;
	padding:12px 16px;
	line-height:1.8;
	color:#666;
	font-size:14px;
	overflow-y:auto;
}
.jduste {
	float:left;;
	width:100%;
	color:#666;
	font-size:14px;
}
.cshortr {
	font-size:22px;
	font-weight:bold;
	color:#21b200;
}
.ansirrt {
	width:100%;
	text-align:right;
	height:35px;
	float:left;
	margin-top:25px;
}
a.baodbtn {
	width:112px;
	height:32px;
	line-height:32px;
	background:#619bff;
	color:#fff;
	text-align:center;
	font-size:14px;
	float:left;
	margin-left:260px;
}
a.qsrbtn {
	margin-left:30px;
	width:110px;
	height:30px;
	line-height:30px;
	background:#eee;
	color:#999;
	text-align:center;
	font-size:14px;
	float:left;
	border:solid 1px #dcdcdc;
}
</style>

<body style="background:white">
<div class="dhtopes">
<ul class="reygtds">
<li class="dhdanes" style="margin-left:90px;"><a href="/"></a></li>
<li class="dhdanes"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdanes"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdanes"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
<div style="clear:both"></div>
<div class="lvjies" style="background:white">
<h1 style="position:relative">
<?=$itemdetail['iname']?>

<?php
$roomurl = empty($itemdetail['fulldomain']) ? $itemdetail['domain'].'.ebh.net' : $itemdetail['fulldomain'];

if(empty($user)){
	if($itemdetail['iprice']==0) {
	?>
		<a href="javascript:void(0);" class="dolog dologin">免费开通</a>
	<?php }else{
	?>
		<a href="javascript:void(0);" class="toug dologin">报名付费</a><?php
	}
}elseif($user['groupid'] == 6){
	if ($itemdetail['js_item']['permission'] == 1) {
		$furl = $itemdetail['js_item']['nexturl'];
		$bclass = 'dolog';
		$label = '进入学习';
	} elseif($itemdetail['iprice'] > 0 || empty($itemdetail['js_item']['free']) && $itemdetail['fprice'] > 0) {
		$furl = $furl = 'http://'.$roomurl.'/ibuy.html?itemid='.$itemdetail['itemid'];
		$bclass = 'toug';
		$label = '报名付费';
	} elseif (!empty($itemdetail['js_item']['free'])) {
		$furl = 'javascript:;';
		$bclass = 'dolog free';
		$label = '免费开通';
	} elseif ($itemdetail['fprice'] == 0) {
		$furl = 'http://'.$roomurl.'/myroom/stusubject/'.$itemdetail['folderid'].'.html';
		$bclass = 'dolog sample';
		$label = '试听课程';
	}
	if (!empty($furl)) {
	?>
	<a class="<?=$bclass?>" href="<?=$furl?>"><?=$label?></a>
<?php }} ?>
</h1>
<p class="topjie">
<?=$itemdetail['isummary']?></p>

<h2 style="text-align:center;font-size:16px;font-weight:bold;margin:10px 0 10px 0">
<?php if(!empty($itemdetail['speaker']) && !empty($itemdetail['detail'])) 
	echo $itemdetail['speaker'];?>
</h2>
<div style="text-indent:25px;line-height:2">
<?=$itemdetail['detail']?>
</div>
<div>
<h3 class="kubiao">
课程目录
</h3>

<div class="kemul">
<?php foreach($sectionlist as $k=>$section){?>
	<h2 class="xoakr"><a href="javascript:void(0)" style="color:#0033ff;text-decoration:none" onclick="showcws('<?=$k?>')"><?=$section[0]['sname']?></a></h2>

<ul id="ul<?=$k?>">
<?php
	foreach($section as $course){
?>

<li>
<p class="tibiat"><span class="dianse">&bull;</span><?=$course['title']?></p>
<p class="etkee"><?=$course['summary']?></p>
</li>

<?php }?>
</ul>
<?php }?>
</div>


</div>
</div>
<div id="free-dialog" style="display:none">
	<div class="baoke">
		<img class="imgrts" src="" />
		<div class="suitrna">
			<h2></h2>
			<p class="p1"></p>
		</div>
		<div class="nasirte">
			<span class="titses">课程介绍</span>
			<div class="paewes"></div>
		</div>
		<div class="jduste">
			价格：<span class="cshortr">免费</span>
		</div>
	</div>
</div>
</body>
<script>
var folderid = <?=$itemdetail['folderid']?>;
var itemid = <?=$itemdetail['itemid']?>;
var item = null;
var nexturl = '';
<?php if (!empty($itemdetail['js_item']['item'])) { ?>
item = <?=json_encode($itemdetail['js_item']['item'])?>;
nexturl = '<?=$itemdetail['js_item']['nexturl']?>';
<?php }?>
(function($) {
	$.extend({
		'checkUserpermission': function() {
			var loginDia = dialog.get('artdialoglogin');
			if (loginDia) {
				loginDia.close();
			}

			$.ajax({
				'url': '/courseinfo/ajax_checkuserpermisions.html',
				'type': 'post',
				'data': { 'folderid': folderid, 'itemid': itemid },
				'dataType': 'json',
				'success': function(d) {
					if (d.errno > 0) {
						$.note(d.msg);
						return;
					}

					if (d.data.free) {
						//免费开通
						$.buyFreeItem(d.data.item, d.data.nexturl);
						return;
					}
					location.href = d.data.nexturl;
				}
			});
		},
		//提示框
		'note': function(msg, callback) {
			var dia = new dialog({
				'id':'signmsg',
				'content':'<div class="PPic"></div><p>' + msg + '</p>',
				'skin': "ui-dialog2-tip"
			});
			dia.showModal();
			setTimeout(function () {
				dia.close().remove();
				if (typeof(callback) == 'function') {
					callback();
				}
			}, 2000);
		},
		//免费课程报名框
		'buyFreeItem': function(item, nexturl) {
			var freeWindow = new dialog({
				id: 'free-window',
				title: '报名',
				fixed: true,
				padding:20,
				content: $("#free-dialog"),
				onshow: function() {
					var box = $(this.node);
					box.find('img.imgrts').attr('src', item.showimg);
					box.find('div.suitrna h2').html(item.iname);
					box.find('div.suitrna p.p1').html(item.crname);
					box.find('div.nasirte div.paewes').html(item.summary);
				},
				okValue: '去报名',
				ok: function() {
					var itemid = [];
					if (item['group_members']) {
						$.each(item['group_members'], function(index, ob) {
							itemid.push(ob.itemid);
						});
					} else {
						itemid.push(item.itemid);
					}
					$.ajax({
						url: '/ibuy/bpay.html',
						type: 'post',
						data: { 'itemid': itemid, 'totalfee': 0},
						dataType: 'json',
						success: function(ret) {
							if (ret.status == '0') {
								$.note(ret.msg);
								return;
							}
							//报名成功后进入学习页面
							location.href = nexturl;
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {
					location.reload();
				}
			});
			freeWindow.showModal();
		}
	});
	$('a.free').bind('click', function() {
		$.buyFreeItem(item, nexturl);
	});
	$('a.sample').bind('click', function() {
		var url = $(this).attr('href');
		/*url = encodeURIComponent(url);
		var exp = new Date();
		exp.setTime(exp.getTime() + 300000);
		var domain = document.location.host.substring(document.location.host.indexOf('.'));
		document.cookie = 'ebh_refer='+url+';path=/;expires=' + exp.toGMTString()+";domain="+domain+";";*/
		setCookie('ebh_refer',encodeURIComponent(url),10,'/','.<?=$this->uri->curdomain?>');
		location.href = '/myroom.html';
		return false;
	});
})(jQuery);
function showcws(ulid){
	if($('#ul'+ulid).css('display')=='none')
		$('#ul'+ulid).show();
	else
		$('#ul'+ulid).hide();
}
$(".dologin").click(function(){
	$.loginDialog(function() {
		$.checkUserpermission();
	});
});
</script>
</html>