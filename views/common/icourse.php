<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery.base64.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<style>
	#playbth{
		float:right;
		margin-top: -7px;
		margin-right: 20px;
		margin-bottom: 15px;
	}
</style>
</head>
<body>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<div class="cright" style="float:none;display: block;margin: 0 auto;width:100%;margin-bottom:20px;border:none;box-shadow: 0 0 0px #fff;font-size:14px;">
<div class="lefrig" style="margin:0px;">
			<div class="classbox" style="width:100%;background: #FFF;border:#FFF;min-height: 120px;">
				<div style="color: #333333;font-size: 14px;line-height: 34px;padding-left: 15px;font-size:18px; font-weight: bold;height:none;folat:left;"><?= $course['title']?></div>
				<div class="classboxmore" style="width:92%;">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $course['viewnum']?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
				</div>

					<div style="margin-left:10px;">
			
						<?php 
							$arr = explode('.',$course['cwurl']);
							$type = $arr[count($arr)-1];
							if(!empty($_SERVER['HTTP_USER_AGENT'])){
							    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
							    $is_android = (strpos($agent, 'android')) ? true : false;
							}else{
							    $is_android = false;
							}
							$audiotype = array('wma','mmf','mp3','mid','amr','wav');
							$videotype = array('mpg','flv','mp4','rmvb','avi');
							$doctype = array('ppt','excel','xls','wps','pdf','doc','docx','pptx','xlsx','txt');
							$ziptype = array('zip','rar','7z');
							$htype = 0;
							if($course['ism3u8'] || in_array($type, $videotype)){
								$htype = 1;//视频文件
							}else if(in_array($type, $audiotype)){
								$htype = 2;//音频文件
							}else if(in_array($type, $doctype)){
								$htype = 3;//文本文件
							}else if(in_array($type, $ziptype)){
								$htype = 4;//压缩文件
							}else{
								$htype = 5;//其他文件不要处理
							}
							$mime = getMime($type);
							if(in_array($type, $audiotype)){
								$dlbtn = "播 放";
							}else{
								$dlbtn = "下 载";
							}
						?>
						<?php if ($course['islive'] == 1 && !in_array($tag, array(1,3))) { ?>
							<div style="padding-right: 10px">
								<video id="_video" src="<?=$purl?>" poster="<?=$course['thumb']?>" width="100%" controls="controls">
									您的浏览器不支持播放该视频！
								</video>
							</div>
						<?php } elseif (!$course['ism3u8'] && !empty($course['cwurl'])) { ?>
							<?php if(!$is_android){?>
								<a href="javascript:void(0)" onclick="redirect(0)" class="huangbtn marrig" style="margin-bottom:10px;float:right;" ><?=$dlbtn?></a>
							<?php }else{?>
		                    	<a href="<?=$purl?>" class="huangbtn marrig" style="margin-bottom:10px;float:right;" ><?=$dlbtn?></a>
		                    <?php }?>
		                    <?php if(!empty($course['apppreview'])){?>
		                    	<a href="<?=geturl('preview/pdf/'.$course['cwid'])?>?k=<?=$k?>" class="huangbtn marrig" style="margin-bottom:10px;float:right;" >预 览</a>
							<?php }?>
						<? } else if($course['ism3u8']){?>
							<a id="playbth" href="javascript:void(0)" class="huangbtn marrig" <?=($tag==1 || $tag ==3)?'style="display:none;"':''?> onclick="onlineplay(<?=$submitat?>)" >开始学习</a>
						<?php }?>
					</div>
			</div>


			
				<div id='atsrc' style="display: none;"></div>
		<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:0px;width:100%;margin-bottom:5px;">
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
			  	<div class="incont" style="width:96%;padding-left:10px;">
					<?= $course['message'] ?>
				</div>
			</div>
		<?php } ?>
			<a name="fujian" href="javascript:void(0);"></a>
<script>
$(function(){
	$("#showface").click(function(e){
		$('#face').toggle();
	})
	//展示效果
	$(".emotionbtn").parent().parent().hover(function(){		 
		$("#showimg").attr("src",$(this).find(".emotionbtn").attr("src"));
		$("#showtitle").html($(this).find("a").attr("title"));
		$("#showimg").show();
        $("#showtitle").show();
	},function(){		 
		$("#showimg").attr("src","");
		$("#showimg").hide();
		$("#showtitle").hide();
	});
	//点击事件
	$('.emotionbtn').parent().parent().click(function(){
		var code = $(this).find(".emotionbtn").attr("code");
		var title =$(this).find("a").attr("title");
		//just show text
		//$("#comm").append("["+title+"]"); 
		//just show image
		$("#comm").val($("#comm").val()+code); 
		$('#face').toggle();
		$('#comm').focus();
	})

})
</script>
<?php if($tag == 1){?>
<div id="countdownwrap" style="background: white; border: 1px solid rgb(221, 221, 221); border-image: none; width:100%; height: auto;overflow:hidden; text-align: center;">
	<span style="width:100%; font-size: 20px; margin-top: 20px; float: left;">课程将于 <?=date('Y-m-d H:i',$submitat)?> 开始</span>
	<span style="width:100%; font-size: 20px; margin-top: 20px; float: left;">倒计时：<span id="countdown"></span></span> 
	<span style="width: 100%; font-size: 20px; margin-top: 20px;margin-bottom:20px; float: left;">请耐心等候...</span>
</div>
<?php }else if($tag == 3){?>
<div style="background: white; border: 1px solid rgb(221, 221, 221); border-image: none; width:100%; height: 200px;overflow:hidden; text-align: center;">
	<span style="width:100%;line-height:200px; font-size: 20px; float: left;">课程已于 <?=date('Y-m-d H:i',$endat)?> 结束</span>
</div>
<?php }?>

			
				<div class="introduce" style="float:left;width:100%;">
					<div class="intitle"><h2><a id="rid">课件评论</a></h2></div>
					  <div class="appraise">
							
						<?php if (!empty($reviews)) { ?>
							<?php foreach ($reviews as $review) { ?>
							   <?php
								if ($review['sex'] == 1)
									$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
								else
									$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
								$face = empty($review['face']) ? $defaulturl : $review['face'];
								$face = getthumb($face, '50_50');
								?>
							<dl>
								<dt style="width:18%;"><div class="userimg"><img width="50px" height="50px" src="<?= $face ?>" alt="<?= $review['realname'] ?>" /></div></dt>
								<dd style="width:75%;">
								<div class="apptit" style="width:101%;"><span><?= date('Y-m-d H:i:s', $review['dateline']) ?></span><b><?= $review['realname']?></b></div>
								<div class="grade">总体评分: 
								<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>', $review['score']) ?>
								<?= str_repeat('<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>', 5 - intval($review['score'])) ?>
								</div>
								<p><?= $review['subject'] ?></p>
								<?php if (!empty($review['rsubject'])) { ?>
								<div class="restore" style="width:auto;">
									<div class="restore_arrow" style="width:auto;" >◆</div>
									<div class="restore_cont" style="width:auto;"><h1>老师回复：</h1><?= $review['rsubject'] ?></div>
								</div>
								<?php } ?>
								</dd>
							</dl>
							<?php } ?>
						<?php } else { ?>
								<div id="nocommentdiv" style="width:auto;height:50px;margin-left:10px;">暂无任何评论</div>
						<?php } ?>
							<div id="commentlastdiv" class="clear"></div>	
							
					  </div>
							 
				<div id="chakan" style="margin:0 auto;width:70px; border-top: 1px solid #eeeeee;width:100%;float:left;">
					<input class="xuexibtn" type="submit" name="Submit" value="查看更多" onclick="scroll_onclick();" style="font-size: 16px;height: 70px;background-color: #fff;border:solid 1px #fff;text-align:center;width:70px;width:100%;"/>
				</div>
				
		<div style="height:390px;width:745px; position:relative;float:left;display:none;">			  
			<div class="mafe" id="face" style="display:none;position:absolute;top:-132px;left:248px;">
				<div id="b2">
				<div>

				<table class="datamis" cellspacing="0">
				<thead class="tabdmis">
					<?php
						foreach($emotionarr as $x=>$emotion){
							if(($x)%13==0){
								echo '<tr>';
							}
					?>
					<td><a href="javascript:;" title="<?=$emotion?>"><img class="emotionbtn" width="24" height="24" src="http://static.ebanhui.com/ebh/tpl/default/images/<?=$x?>.gif" code="[emo<?=$x?>]"></a></td>
					
					<?php if(($x+1)%13==0){
							echo '</tr>';
						}
					}
					?>
				  
					<tr>
					<td colspan="13" style="height:63px;">
					<span style="float:right;margin:5px 10px 5px 0;"><span id="showtitle" style="float: left;font-size: 16px;font-weight: bold;margin-right: 5px;margin-top: 18px;display:none;"></span>
						<img id="showimg" style="width:48px;height:48px;display:none;" src=""> </span></td>
					</tr>
				  </thead>
				</table>
				</div>
				</div>

			</div>			
		</div>

	</div>

<script defer="defer" type="text/javascript">

//继续加载
	var count = '<?= $count?>';
	var cwid = '<?= $course['cwid'] ?>';
	var page = 1 ;

	$(function(){
		if (parseInt(count)==0||parseInt(count)<=20)
        {
			$("#chakan").hide();
        }
	})
	function scroll_onclick(){
		var url = "<?= geturl('icourse/onclicklist')?>"+'?k=<?= $k?>';
			page=page+1;//page：页数
			$.ajax({
				url : url,
				data:{'cwid':cwid,'page':page},
				type	:'post',
				dataType:'json',
				success:function(data){
					var demohtml = '';					 
					if(data!=''){

						for(var i in data){
							demohtml += '<dl>';
							demohtml += '<dt style="width:18%;"><div class="userimg"><img width="50px" height="50px" src="'+data[i].face+'" alt="'+data[i].realname+'" /></div></dt>';
							demohtml += '<dd style="width:75%;">';
							demohtml += '<div class="apptit" style="width:101%;"><span>'+data[i].dateline+'</span><b>'+data[i].realname+'</b></div>';
							demohtml += '<div class="grade">总体评分: ';
								var score ="";							
								var scores ="";//星星
								for(var num=0;num<parseInt(data[i].score);num++)								    
									score +='<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif"/>';
								for(var num=0;num<5-parseInt(data[i].score);num++)
									scores +='<img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif"/>';
						
							demohtml += score+scores+'</div>';
							demohtml += '<p>'+data[i].subject+'</p>';
								if(data[i].rsubject){
									demohtml += '<div class="restore" style="width:auto;"><div class="restore_arrow" style="width:auto;" >◆</div>';
									demohtml += '<div class="restore_cont" style="width:auto;"><h1>老师回复：</h1>'+data[i].rsubject+'</div>';
									demohtml += '</div>';
								}
							demohtml += '</dd></dl>';
							} 
						}
					$(".appraise").append(demohtml);
					}
					
				});
				if (parseInt(count)>0 || parseInt(count)<=20)
					 {
						count=parseInt(count);
						if(count%20==0&&(count/20<=page))
						$("#chakan").hide();
						else if(count%20!=0&&(count/20+1<=page))
						$("#chakan").hide();			
						
					}
	}

function CurentTime()
{ 
    var now = new Date();
   
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
   
    var hh = now.getHours();            //时
    var mm = now.getMinutes();          //分
    var ss = now.getSeconds();          //秒
    var clock = year + "-";
   
    if(month < 10)
        clock += "0";
   
    clock += month + "-";
   
    if(day < 10)
        clock += "0";
       
    clock += day + " ";
   
    if(hh < 10)
        clock += "0";
       
    clock += hh + ":";
    if (mm < 10) clock += '0'; 
    clock += mm+":"; 
    clock+= ss;
    return(clock); 
} 
//取星星
function getstar(num)
{	
	var starword='';
	num=parseInt(num);
	if(num>5)
	{
		num=5;
	}
	for(i =0;i<num;i++)
	{
		starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif'/>";
	}
	if(5-num>0)
	{
		for(j =0;j<5-num;j++)
		{
			starword+="<img src='http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif'/>";
		}
	}
	return starword;
	
}
	

function rate(obj,oEvent){
	var imgSrc = 'http://static.ebanhui.com/ebh/tpl/default/images/icon_star_1.gif';
	var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif';
	if(obj.rateFlag) return;
	var e = oEvent || window.event;
	var target = e.target || e.srcElement;
	var imgArray = obj.getElementsByTagName("img");
	for(var i=0;i<imgArray.length;i++){
	   imgArray[i]._num = i;
	   imgArray[i].onclick=function(){
	    if(obj.rateFlag) return;
		var inputid=this.parentNode.previousSibling
		inputid.value=this._num+1;
	   }
	}
	if(target.tagName=="IMG"){
	   for(var j=0;j<imgArray.length;j++){
	    if(j<=target._num){
	     imgArray[j].src=imgSrc_2;
	    } else {
	     imgArray[j].src=imgSrc;
	    }
		target.parentNode.onmouseout=function(){
		var imgnum=parseInt(target.parentNode.previousSibling.value);
			for(n=0;n<imgArray.length;n++){
				imgArray[n].src=imgSrc;
			}
			for(n=0;n<imgnum;n++){
				imgArray[n].src=imgSrc_2;
			}
		}
	   }
	} else {
		 return false;
	}
	}	
function fiterscr(str)
{	
		
	while (str.indexOf('>') >= 0)
	{
	   str = str.replace('>', '&gt');
	}
	while (str.indexOf('<') >= 0)
	{
	   str = str.replace('<', '&lt');
	}
	return str;
}

<?php if($tag == 1){?>
	//还没有开课执行倒计时逻辑
	var timearr = new Object();
	timearr[1] = '秒';
	timearr[60] = '分';
	timearr[3600] = '小时';
	timearr[86400] = '天';
	
	keyarr = Array();
	keyarr[1] = 86400;
	keyarr[60] = 3600;
	keyarr[3600] = 60;
	keyarr[86400] = 1;
	function secondToStr(time){
		var str = '';
		$.each(timearr,function(key,value){
			key = keyarr[key];
			value = timearr[key]; 
			if (time >= key){
				str += Math.floor(time/key) +value;
			}
			time %= key;
		});
		return str;
	}

	var countdown = "<?= ($submitat-time() )?>";
	(function t(){
		if(countdown%60 == 0){
			$.ajax({
				url:'/time/gettime.html?d='+Math.random(),
				success:function(data){
					countdown = <?=$submitat?> - data;
				}
			});
		}
		if(countdown <= 0){
			$("#playbth").show();
			$("#countdownwrap").hide();
			redirect();
			return;
		}
		$("#countdown").html(secondToStr(countdown--));
		setTimeout(t,1000);
	})();
<?php }?>

//判断是否安卓产品
function validandroid(){
	var result = 0;
	var userAgent = navigator.userAgent.toLowerCase(); 
	if ( userAgent.indexOf("android") != -1)
	{
		result = 1;
	}
	return result;
}

//判断是否苹果产品
function validapple(){
	var result = 0;
	var userAgent = navigator.userAgent.toLowerCase(); 
	if (userAgent.indexOf("ipad") != -1 || userAgent.indexOf("iphone") != -1)
	{
		result = 1;
	}
	return result;
}
function redirect(skip){
	var isandroid = validandroid();
	var purl = "<?=$purl?>";
	if(!skip){
		skip = 0;
	}
	if (isandroid==1)
	{
		var jsonPara = '{"method":"play","skip":"'+skip+'","purl":"'+purl+'","id":"<?=$course['cwid']?>","suffix":"<?=$type?>","mimetype":"<?=$mime?>","htype":"<?=$htype?>"}';
		window.location = "ebhp://"+jsonPara;
	} else {	//苹果调用
		var jsonPara = '{"skip":"'+skip+'","purl":"'+purl+'","id":"<?=$course['cwid']?>","suffix":"<?=$type?>","mimetype":"<?=$mime?>","htype":"<?=$htype?>"}';
		window.location = "Ebhinterface://play#"+$.base64.encode(jsonPara);
	}
}
function onlineplay(submitat){
	var skip = 0;
	if(submitat){
		skip = (parseInt( (new Date().getTime())/1000)) - submitat;
	}
	redirect(skip);
}

function preview(){
	var isandroid = validandroid();
	var purl = "http://www.ebh.net<?=geturl('preview/pdf/'.$course['cwid'])?>?k=<?=$k?>";
	if (isandroid==1)
	{
		var jsonPara = '{"method":"preview","purl":"'+purl+'","suffix":"<?=$type?>"}';
		window.location = "ebhp://"+jsonPara;
	} else {	//苹果调用
		var jsonPara = '{"purl":"'+purl+'","suffix":"<?=$type?>"}';
		window.location = "Ebhinterface://preview#"+$.base64.encode(jsonPara);
	}
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
	<script type="text/javascript">
		var resetmain = function(){
			var mainFrame = document.getElementById("mainFrame");
			var iframeHeight = Math.max(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+1;
			iframeHeight = iframeHeight<700?700:iframeHeight;
			$(mainFrame).height(iframeHeight);
		}
		function showimage(selector) {
			$(selector,document.getElementById('mainFrame').contentWindow.document).lightBox();
		}
	</script>
	</div>
	</body>
</html>