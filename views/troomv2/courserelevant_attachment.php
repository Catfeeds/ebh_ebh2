<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
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

<div class="lefrig">
<?php
if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1){
	$nopermission = true;
}

 $this->display('troomv2/course_menu');
?>
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
	<div style="text-align:center;" class="nodata">
	</div>
	<?php }?>
	</div>
	<div class="datadoad" style="display:none;" >
		<div style="text-align:center; padding-top:15px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/none.png" /></div>
	</div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20170731001"></script>


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
$('.opbtn').click(function(){
	showDivModel(".nelame");
	$(".nelame").css("top","50px");
});
function openonline() {
	if($("#agreement").is(':checked') !=true) {
		alert("请先阅读并同意《e板会用户支付协议》。");
		return;
	}
	// var url = "<?= empty($checkurl) ? 'http://'.$roominfo['domain'].'.ebanhui.com/classactive.html' : $checkurl ?>";
	var url = '/ibuy.html?itemid=<?=$itemid?>';
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
		<a href="<?= geturl('troomv2') ?>" class="guanbibtn">返回首页</a>
	</div>
</div>
<?php } ?>
</body>
</html>
