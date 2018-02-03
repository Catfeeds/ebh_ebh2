<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/file.js"></script>
<style>
	.ialoglist{
		width:162px;
		height: 180px;
		float: left;
		display:inline;
		margin: 0 0 20px 21px;
		overflow: hidden;
	}
	.ialoglist img{
		width: 160px;
		float:left;
		height: 120px;
	}
.align_box .newku {
	border: 1px solid #CDCDCD;
	float: left;
	font-size: 0;
	height: 126px;
	margin-left: 25px;
	display: inline;
	padding: 2px 0;
	text-align: center;
	width: 130px;
}
.align_box li .alpha_img {
	height: 100%;
	width: 1px;
	vertical-align: middle;
}
.align_box li .show_img {
	vertical-align: middle;
}
.newzuo {
	float: left;
	height: 190px;
	width: 186px;
}
</style>
<div class="ter_tit" style="width:928px;margin:0 auto;">
	
</div>
	<div class="lefrig" style="background:#fff;margin-top:15px;width:938px;">
		<div class="workol" style="overflow:hidden;">
			<div style="width:100%;height:30px;line-height:30px;margin:15px 0 10px 24px;font-size:14px;">互动标题：<span style="color:#2696F0;"><?=$ia['title']?></span></div>
			<div style="width:100%;height:30px;line-height:30px;margin-left:24px;margin-bottom:15px;font-size:14px;">当前状态：已有<span id="answercount" style="color:red;font-weight:bold;font-size:18px;"> <?=count($answerList)?> </span>名学生提交 还剩<span id="notanswercount" style="color:red;font-weight:bold;font-size:18px;"> <?=($stunumAll-count($answerList))?> </span>名学生未提交</div>
			
			<div class="fotwaim" id="div2">
				<ul id="ialog">
					<?php foreach ($answerList as $key => $answer) {?>

					<li class="newzuo ">
			  			<ul class="align_box"> 
							<li class="newku"> 
								<a href="<?=$answer['img']?>">
									<img class="show_img" src="<?=getthumb($answer['img'],'126_126')?>">
									<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"> 
								</a>
							</li> 
			  			</ul>
				 		<div style="text-align:center;margin:5px 0;float:left;width:182px;"><?=empty($answer['realname'])?$answer['username']:$answer['realname'];?>（<?=$answer['username']?>）</div>
						<div style="text-align:center;"><?=date("Y-m-d H:i:s",$answer['lastpost'])?></div>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
</div>

<script type="text/javascript">
	$(function(){
		try{
			$('#ialog a').lightBox();
		}catch(error){
			
		}
		setInterval(getLogs,5000);
	});

	function getformatdate(timestamp){
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	function frontzero(str){
		str = str.toString();
		str.length==1?str="0"+str:str;
		return str;
	}
	function getLogs(){
		$.ajax({
			'type':'POST',
			'url':'/troom/iaclassroom/getDetailAjax.html',
			'data':{'icid':<?=$ia['icid']?>},
			'dataType':'json',
			'success':function(data){
				render(data);
			}
		});
	}

	function render(data){
		var length = data.length;
		var lis = new Array();
		for(var i=0;i<length;i++){
			lis.push('<li class="newzuo ">');
			lis.push('<ul class="align_box"> ');
			lis.push('<li class="newku"> ');
			lis.push('<a href='+data[i].img+'>');
			lis.push('<img class="show_img" src='+GetThumb(data[i].img,"126_126")+'>');
			lis.push('<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"> ');
			lis.push('</a>');
			lis.push('</li>');
			lis.push('</ul>');
			lis.push('<div style="text-align:center;margin:5px 0;float:left;width:182px;">'+(data[i].realname||data[i].username)+'（'+data[i].username+'）</div>');
			lis.push('<div style="text-align:center;">'+getformatdate(data[i].lastpost)+'</div>');
			lis.push('</li>');
		}
		$("#ialog").html(lis.join(''));
		$("#answercount").html(' '+length+' ');
		$("#notanswercount").html(' '+(<?=$stunumAll?>-length)+' ');
		try{
			$('#ialog a').lightBox();
		}catch(error){
			
		}
	}
</script>

<?php $this->display('troom/page_footer'); ?>