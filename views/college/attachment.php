<?php $this->display('college/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=2016052001"/>
<style>
.datadoadson a.yvlan {
	border-radius:3px;
}
.datadoadson a.xiazai {
	border-radius:3px;
}
.datadoadson > h2 {
    border-bottom:solid 1px #efefef;
	margin-bottom:10px;
	height:36px;
	line-height:36px;
}
</style>

<div style="margin:0 auto; width:1000px;background:white;">
<?php
if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1)
	$nopermission = true;
if(!empty($folder)){
	$this->assign('selidx',4);
	$this->display('college/course_nav');
}?>
	<div class="datadoad" style="margin-top:25px;" >
	<?php 
	$lastcwid = 0;
	if(!empty($attlist)){
	foreach($attlist as $k=>$att){
		
		if($att['cwid'] != $lastcwid){
			$lastcwid = $att['cwid'];
		?>
		<div class="datadoadson ">
			<h2><?=$att['cwtitle']?></h2>
			<ul>
		<?php }?>
				<li>
					<p class="fl" style="font-size:14px;font-family: 微软雅黑">
					<i class=" icont <?=$att['ico']?>"></i>
					<?php 
					if(!empty($nopermission)){
					?>
					<span style="float:left;width:300px;"><a href="javascript:void(0);" class="opbtn"><?= $att['filename'] ?></a></span>
					<?php
					}else{
					if($att['suffix'] == 'swf' || $att['suffix'] == 'mp3') { ?>
						<span style="float:left;width:300px;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$att['source']:$source) ?>" title="<?= $att['filename']?>" suffix="<?= $att['suffix'] ?>" aid="<?= $att['attid'] ?>" type="button"><?= $att['filename'] ?></a></span>
					<?php } elseif($att['suffix'] == 'flv') { ?>
						<span style="float:left;width:300px;"><a class="atfalsh" href="javascript:void(0);" source="<?= (empty($source) ?$att['source']:$source) ?>" title="<?= $att['filename']?>" suffix="<?= $att['suffix'] ?>" cwid="<?= $att['cwid'] ?>" aid="<?= $att['attid'] ?>" ><?= $att['filename'] ?></a></span>
					<?php } else { ?>
						<span style="float:left;width:300px;"><a class="" href="<?=(empty($source) ?$att['source']:$source).'attach.html?attid='.$att['attid']?>"><?= $att['filename'] ?></a></span>
					<?php } 
					}?>
					<span style="float:left;width:200px;">　　大小：<?=$att['csize']?>　　</span><span style="color:#999;"><?=Date('Y-m-d',$att['dateline'])?></span></p>
					<div class="ylxz fr">
					<?php 
					if(!empty($nopermission)){
					?>
					<a href="javascript:void(0);" class="yvlan fl opbtn" >预览</a>
					<a href="javascript:void(0);" class="xiazai fr opbtn">下载</a>
					<?php }else{?>
						<?php if($att['suffix'] == 'swf' || $att['suffix'] == 'mp3') { ?>
							<a href="javascript:void(0);" class="atfalsh yvlan fl" source="<?= (empty($source) ?$att['source']:$source) ?>" title="<?= $att['filename']?>" suffix="<?= $att['suffix'] ?>" aid="<?= $att['attid'] ?>" type="button">预览</a>
						<?php } elseif($att['suffix'] == 'flv') { ?>
							<a class="atfalsh yvlan fl" href="javascript:void(0);" source="<?= (empty($source) ?$att['source']:$source) ?>" title="<?= $att['filename']?>" suffix="<?= $att['suffix'] ?>" cwid="<?= $att['cwid'] ?>" aid="<?= $att['attid'] ?>" >预览</a>
						<?php } elseif($att['ispreview']){ ?>
							<a class="yvlan fl" href = "<?= (empty($source) ?$att['source']:$source).'preview/att/'.$att['attid'].'.html' ?>" target="_blank">预览</a>
						<?php } ?>
						<a href="<?=(empty($source) ?$att['source']:$source).'attach.html?attid='.$att['attid']?>" class="xiazai fr">下载</a>
					<?php }?>
					</div>
				<div class="clear"></div>
				</li>
		<?php if(empty($attlist[$k+1]) || $attlist[$k+1]['cwid'] != $lastcwid){?>
			</ul>
		</div>
		<div class="clear"></div>
		<?php }?>
	<?php }}else{?>
	<div class="nodata">
	</div>
	<?php }?>
	</div>
	<div class="datadoad" style="display:none;" >
		<div style="text-align:center; padding-top:15px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/none.png" /></div>
	</div>
</div>
<script>
var searchtext = "请输入关键字";
$(function() {
   initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('college/attachment') ?>' + '?q='+title;
	   <?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
	   <?php }?>
       document.location.href = url;
   });
});
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?v=20170731001"></script>


<?php if (!empty($nopermission)) { ?>

<style type="text/css">
.waigme {
	width:550px;
	height:230px;
	background-color:gray;
	border-radius:10px;
	display:none;
}
.nelame {
	width:530px;
	height:306px;
	margin:10px;
	float:left;
	display:inline;
	border: 8px solid rgba(255, 255, 255, 0.2);
	border-radius: 8px;
	box-shadow: 0 0 20px #333333;
	opacity: 1;
}
.nelame .leficos {
	width:125px;
	height:265px;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0104.jpg) no-repeat 30px 32px;
}
.nelame .rigsize {
	width:375px;
	float:left;
	margin-top:25px;
}
.rigsize .tishitit {
	font-size:14px;
	color:#d31124;
	font-weight:bold;
	line-height:30px;
}
.rigsize .phuilin {
	line-height:2;
	color:#6f6f6f;
}
.nelame a.kaitongbtn {
	display:block;
	width:147px;
	height:50px;
	line-height:50px;
	background-color:#ff9c00;
	color:#fff;
	text-decoration:none;
	text-align:center;
	font-size:20px;
	float:left;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-top:20px;
	border-radius:5px;
}
.nelame a.guanbibtn {
	float:left;
	color:#939393;
	font-size:14px;
	margin:40px 0 0 12px;
}
</style>

<script type="text/javascript">
var free = <?=!empty($free) ? 'true' : 'false' ?>;
var folderid=<?=$folder['folderid']?>;
function freeBuySuccess() {
	var freeWindow = top.dialog({
		id: 'free-window',
		title: '免费开通成功',
		fixed: true,
		content: "开通成功，请重新选择操作。",
		padding: 20,
		onshow: function() {
			var box = $(this.node);
			box.find('.ui-dialog2-footer').css('text-align', 'right');
		},
		okValue: '确定',
		ok: function() {
			location.href = "/college/attachment.html?folderid="+folderid;
		},
		onclose: function() {
			location.href = "/college/attachment.html?folderid="+folderid;
		}
	});
	freeWindow.showModal();
}
function getSingleItem(itemid, callback) {
	$.ajax({
		'url' : '/room/portfolio/ajax_check_userpermisions.html',
		'type': 'post',
		'dataType': 'json',
		'data': { 'itemid': itemid },
		'success': function(d) {
			if (d.errno > 0) {
				alert(d.msg)
				return;
			}
			if (typeof(callback) == 'function') {
				callback(d.data.item);
			}
		}
	});
}
function buyFreeItem(item) {
	if (item == null) {
		return;
	}
	$.logArg = item.itemid;
	if (item.url) {
		location.href = item.url;
		return;
	}
	var freeWindow = top.dialog({
		id: 'free-window',
		title: '报名',
		fixed: true,
		content: $("#free-dialog").html(),
		padding: 20,
		onshow: function() {
			var box = $(this.node);
			box.find('.ui-dialog2-footer').css('text-align', 'right');
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
					//报名成功
					freeBuySuccess();
				}
			});
		},
		cancelValue: '取消',
		cancel: function() {

		}
	});
	freeWindow.showModal();
}

$('.opbtn').click(function(){
	if (free) {
		getSingleItem(<?=$itemid?>, buyFreeItem);
		return;
	}
	if(window.parent != undefined) {
		var url = '/ibuy.html?itemid=<?=$itemid?>';
		window.parent.setiinfo('',url);
		window.parent.opencountdiv();
	}
});
function openonline() {
	if($("#agreement").is(':checked') !=true) {
		alert("请先阅读并同意《e板会用户支付协议》。");
		return;
	}
	// var url = "<?= empty($checkurl) ? 'http://'.$roominfo['domain'].'.ebanhui.com/classactive.html' : $checkurl ?>";
	
	window.open(url);
}
function closeWindows() {
         var browserName = navigator.appName;
         var browserVer = parseInt(navigator.appVersion);
         if(browserName == "Microsoft Internet Explorer"){
             var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;  
             if (ie7)
             {  
               window.open('','_parent','');
               window.close();
             }
            else
             {
               this.focus();
               self.opener = this;
               self.close();
             }
        }else{  
            try{
                this.focus();
                self.opener = this;
                self.close();
            }
            catch(e){

            }

            try{
                window.open('','_self','');
                window.close();
            }
            catch(e){

            }
        }
    }
</script>
<div class="nelame" style="display:none;">
	<div style="width:530px;height:300px;background:#fff;">
		<div class="leficos">
		</div>
		<div class="rigsize">
		<h2 class="tishitit">对不起，您还未开通 <?= empty($payitem) ? '学习和作业功能' : $payitem['iname'] ?> 或服务已到期。</h2>
		<p style="font-weight:bold;">开通后您可以在学习课程和我的作业里进行在线学习和作业。</p>
		<p class="phuilin">在云教学网校，您可以随时随地在线学习、预习新课，复习旧知、记录和向老师提交笔记、在线做作业、在错题集里巩固错题、在线答疑、查看学习表、与老师，同学互动交流等。</p>
			<div class="czxy" style="padding-left:0px;padding-top:10px;">
				<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked" />
				<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="<?= geturl('agreement/payment') ?>" target="_blank" style="color:#00AEE7;">e板会用户支付协议</a>》
				</label>
			 </div>
		</div>

		<a href="javascript:openonline();" class="kaitongbtn">在线开通</a>
		<a href="<?= geturl('myroom') ?>" class="guanbibtn">返回首页</a>
	</div>
</div>
<?php } ?>
<?php if(!empty($free)) { ?>
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
<?php }?>
</body>
</html>
