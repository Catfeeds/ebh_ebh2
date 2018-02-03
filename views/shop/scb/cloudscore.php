<?php $this->display('shop/stores/stores_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/pingf.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<body>
<div class="main">
<div class="dtzhix">
<div class="ad">
<ul id="actor" class="imgs" style="height:72px;">
<li>
<a href="javascript:;">
<img src="http://static.ebanhui.com/ebh/citytpl/stores/images/adtop1211.jpg" width="958" height="70" />
</a>
</li>
</ul>
</div>
<div class="topkuang"></div>
<div class="zixun">
<div class="rigxiang" style="width:920px;">
<div class="tpshang">
<div class="leftp">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<div class="wangbg">
  <img src="<?= $logo?>" width="100" height="100" /> 
</div>
</div>

<?php $usertype = !empty($user['groupid'])?$user['groupid']:'\'\'';?>

<div class="rigtp">
<h3 class="titjl"><?= $classvalue['crname']?></h3>
<div class="zongp">
<p style="margin: 10px 6px 0 40px;_margin-left:20px;" class="pingff">

<span class="barbgs">
<span class="votebars" style="width:<?= round($classvalue['score'])?>0%;"></span>
</span>

</p>
<span style="font-size:24px;color:#ffb513;"><?= sprintf("%01.1f", $classvalue['score'])?></span> 分(满分10分)
</div>
<p style="float:left;width:110px;margin-left:40px;_margin-left:20px;">已有<span><?= $classvalue['viewnum']?></span>人评分</p><span style="float:left;">我的评分：</span>
<p class="pingff" style="width:59px;margin-top:3px;">

<span class="xiaobarbg">

<span class="xiaovotbg" style="width:<?= $review['score']?>0%;"></span>
</span>

</p>
<span style="float:left;margin-left:10px;"><?= $review['score']?>分</span>
</div>
</div>
</div>
<div class="dianpin">
<h2 class="titdian">我的点评：</h2>
<ul>
<li>
<p style="margin-bottom:5px;margin-top:8px;float:left;">课程与描述相符：</p>
<p class="pingff" style="margin-top:6px;">
<a style="cursor:pointer;" href="javascript:;">
<span class="barbgs1" style="width:100%; " onclick="getxy(event,this,1,1)" onmousemove="getxy(event,this,0,1)" onmouseout="setxy(1)">
<span class="hidbarbgs1" style="width:100%;" ></span></span>
<input type="hidden" name="start1" id="start1" value="10">
</a>
</p>
<span class="fenshu" id="grade1">10分</span>
</li>

<li>
<p style="margin-bottom:5px;margin-top:8px;float:left;">课程的内容质量：</p>
<p class="pingff" style="margin-top:6px;">
<a style="cursor:pointer;" href="javascript:;">
<span class="barbgs2" style="width:100%; " onclick="getxy(event,this,1,2)" onmousemove="getxy(event,this,0,2)" onmouseout="setxy(2)">
<span class="hidbarbgs2" style="width:100%;" ></span></span>
<input type="hidden" name="start2" id="start2" value="10">
</a>
</p>
<span class="fenshu" id="grade2">10分</span>
</li>
<li style="width:270px;">
<p style="margin-bottom:5px;margin-top:8px;float:left;">老师的授课态度：</p>
<p class="pingff" style="margin-top:6px;">
<a style="cursor:pointer;" href="javascript:;">
<span class="barbgs3" style="width:100%; " onclick="getxy(event,this,1,3)" onmousemove="getxy(event,this,0,3)" onmouseout="setxy(3)">
<span class="hidbarbgs3" style="width:100%;" ></span></span>
<input type="hidden" name="start3" id="start3" value="10">
</a>
</p>
<span class="fenshu" id="grade3">10分</span>
</li>
</ul>

<div class="waitxt">
<div class="leftux">
<?php if(!empty($user)){
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
?>    
  <img src="<?= $facethumb?>" width="78" height="78" /> 
<?php }else{ ?>
  <img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" width="78" height="78" /> 
<?php } ?>
  </div>
  <textarea id="subject" class="wenkss" maxlength="130" name="subject"></textarea>
</div>
<?php if(!empty($user)){ ?>
<input name="" type="button" value="发 布" onclick="submitsubject('subject','good','bad','useful',<?= $usertype?>);" class="fabubtn" />
<?php }else{ ?>
<a class="fabubtn1" href="#" style="color:#fff;text-decoration:none;">发 布</a>
<span style="margin-top:20px;float:left;color:#999;">
需要登录才能发布评论,
<a style="color:#3095c6" href="javascript:tologin('/sitecp.php?action=login&returnurl=__url__');">马上登录</a>
</span>
<?php } ?>
<p id="subject_msg" class="zishu">
<span style="color:#3093e4;font-size:20px;">130</span>
字之内
</p>
</div>

<div class="dianxian">
	<ul>


		<?php foreach($reviewlist as $rv){ 
			 if($rv['sex']==1){
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			}else{	
				$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			}
			$face = getthumb($rv['face'],'78_78',$defaulturl);
		?>
			<li class="waili">
				<div class="tuxiang">
					<img src="<?= $face?>" width="78px;" height="78px;" />
				</div>
				<div class="rigjie">
					<p style="color:#58adfd;"><?= shortstr($rv['username'],2,'***')?><?= substr($rv['username'],-2)?></p>
					<?php 
						if($rv['good']==2){
							$grade ='2分';
						}elseif($rv['good']==4){
							$grade ='4分';						
						}elseif($rv['good']==6){
							$grade ='6分';
						}elseif($rv['good']==8){
							$grade ='8分';
						}elseif($rv['good']==10){
							$grade ='10分';
						}
					?>
						<ul>
						<li>
					<span style="float:left">课程与描述相符：</span><span class="xianbg" style="float:left" title="<?= $grade?>"><span class="xianbar" title="<?= $grade?>" style="width:<?= $rv['good']?>0%;"></span></span>
					</li>
					<li>
					<?php 
						if($rv['bad']==2){ 
							$grade ='2分';
						}elseif($rv['bad']==4){
							$grade ='4分';							
						}elseif($rv['bad']==6){
							$grade ='6分';
						}elseif($rv['bad']==8){
							$grade ='8分';
						}elseif($rv['bad']==10){
							$grade ='10分';
						}
					?>
					<span style="float:left">课程的内容质量：</span><span class="xianbg" style="float:left" title="<?= $grade?>"><span class="xianbar" title="<?= $grade?>" style="width:<?= $rv['bad']?>0%;"></span></span>
					</li>
					<li>
					<?php 
						if($rv['useful']==2){ 
							$grade ='2分';
						}elseif($rv['useful']==4){
							$grade ='4分';							
						}elseif($rv['useful']==6){
							$grade ='6分';
						}elseif($rv['useful']==8){
							$grade ='8分';
						}elseif($rv['useful']==10){
							$grade ='10分';
						}
					?>
					<span style="float:left">老师的授课态度：</span><span class="xianbg" style="float:left" title="<?= $grade?>"><span class="xianbar" title="<?= $grade?>" style="width:<?= $rv['useful']?>0%;"></span></span>
					</li>
					</ul>
					<span style="color:#b5b9bc;width: 128px;float:right;"><?= date('Y-m-d H:i:s',$rv['dateline'])?></span>

					<p style="width:825px;float:left;word-wrap: break-word;overflow: hidden;"><?= $rv['subject']?></p>
					
				</div>

			</li>
		<?php } ?>
	</ul>
	
</div>

</div>
<div class="fltkuang"> </div>
</div>
</div>
<script type="text/javascript">
<!--
function getposition(obj){
	var parent = obj.offsetParent
	if(parent && parent.tagName){
		var pposition = getposition(parent);
		return {'left':obj.offsetLeft+pposition.left,'top':obj.offsetTop+pposition.top,'width':obj.clientWidth,'height':obj.clientHeight}

	}
	return {'left':obj.offsetLeft,'top':obj.offsetTop,'width':obj.clientWidth,'height':obj.clientHeight};
}

var isactive = 0;
function getxy(event,obj,isset,num){
	isactive=1;
	var oposition = getposition(obj);
	x=event.clientX
	y=event.clientY
	var spanx = Math.ceil((x-oposition.left)/oposition.width*5)*20;
	if(isset){
		 $("#start"+num).val(spanx / 10);
	}
	if(spanx==20){
		$("#grade"+num ).html('2分');
	}else if(spanx==40){
		$("#grade"+num ).html('4分');
	}else if(spanx==60){
		$("#grade"+num ).html('6分');
	}else if(spanx==80){
		$("#grade"+num).html('8分');
	}else if(spanx==100){
		$("#grade"+num ).html('10分');
	}else{
		$("#grade"+num).html('0分');
	}
	$('.hidbarbgs'+num).stop().css('width',spanx+'%') ;
}
function setxy(num){
	isactive=0;
	setTimeout(
		function(){
			if(isactive==0){
				var setspanx = parseInt($("#start"+num).val())*10;
				$('.hidbarbgs'+num).stop().animate({'width':setspanx+'%'},{'duration':1000}) ;
				if(setspanx==20){
					$("#grade"+num).html('2分');
				}else if(setspanx==40){
					$("#grade"+num).html('4分');
				}else if(setspanx==60){
					$("#grade"+num).html('6分');
				}else if(setspanx==80){
					$("#grade"+num).html('8分');
				}else if(setspanx==100){
					$("#grade"+num).html('10分');
				}else{
					$("#grade"+num).html('0分');
				}
			}
		},100)
}

$(function(){
    window.onload = function() {
        document.getElementById("subject").onkeyup = function() {
            var len = this.value.length;
            var tmp = 130 - len;
            if (tmp <= 0) {
                this.value = this.value.substring(0, 130);
                document.getElementById("subject_msg").innerHTML = "您还可以输入<span style=\"color:#3093e4;font-size:20px;\">0</span>个字符";
            } else {
                document.getElementById("subject_msg").innerHTML = "您还可以输入<span style=\"color:#3093e4;font-size:20px;\">" + tmp + "</span>个字符";
            }
        }
    }
});

function submitsubject(subject,good,bad,useful,usertype){
	var subject = $("#" + subject).val();
	var good = $("#start1").val(); //课程与描述
	var bad = $("#start2").val(); //内容质量
	var useful = $("#start3").val(); //授课态度
	if(subject==''){
		alert("请输入评论内容评论不能为空！");
		return ;
	}else if(good==0){ 
		alert("请为课程与描述评论打分!");
		return ; 
	}else if(bad==0){ 
		alert("请为内容质量评论打分！");
		return ; 
	}else if(useful==0){ 
		alert("请为授课态度评论打分！");
		return ; 
	}
	else if(usertype!=6){
		alert("请使用学生账户进行评价!");
		return ;
	}
	else{
		$.ajax({
			url:'<?= geturl('cloudscore')?>',
			type:'post',
			data:{'op':'cloudscore','subject':subject,'good':good,'bad':bad,'useful':useful,'inajax':1},
			dataType:'json',
			success:function(data){
				$.showmessage({
					img		 : data.code,
					message  :  data.message,
					title    :      '提交评论',
					callback :    function(){
						location.reload();
					}
				});
			}
		});
	}
}
//-->
</script>
<div style="clear:both;"></div>
<div style="position: relative;text-align: center;">
</div>
<?php
    $this->display('common/footer');
?>