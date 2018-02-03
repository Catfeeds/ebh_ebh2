<?php $this->display('common/header');?>
<style>
	body {
		background:#fff;
	}
</style>
<div class="wrapper">
<?php if(!empty($ads_nav[0])){?>
<div class="admb">
<!-- 通栏广告 -->
<a target=_blank href="<?=$ads_nav[0]['linkurl']?>">
<img width="1000px" height="80px" src="<?=$ads_nav[0]['thumb']?>" />
</a>
</div>
<?php }?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<div class="newscon">
<h2 class="toplitit"><?=$nav?></h2>
<div class="sbtomm"><span class="lefhuang"></span><span class="riglan"></span></div>
<div class="titbiaot">
<h2><?=ssubstrch($article['subject'],0,70)?></h2>
<p class="etyue">来源：<?=empty($article['source'])?'e板会':$article['source']?>　人气指数：<?=$article['viewnum']?>　时间：<?=date('Y-m-d',$article['dateline'])?></p>
	<!-- Baidu Button BEGIN -->
	<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="float:left;margin-top:0px;">
	<span class="bds_more">分享到：</span>
	<a class="bds_tsina"></a>
	<a class="bds_qzone"></a>
	<a class="shareCount"></a>
	</div>
	<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6704542" ></script>
	<script type="text/javascript" id="bdshell_js"></script>
	<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
	</script>
	<!-- Baidu Button END -->

</div>
<style>
.newsav strong{
	font-weight:bold;
}
</style>
<div class="newsav">
	<?=stripslashes($article['message'])?>
</div>
<div class="plunte" style="clear:both">
<h2 class="titplun"><span>>></span>我要评论</h2>
<?php $content = $this->input->get('content');?>
<textarea  id="txtreu" class="txtrweu" cols="" rows=""><?=empty($content)?'':$content?></textarea>
<div class="ptuege">
<p style="float:left;width:857px;">发表对这篇文章的看法（150字以内）</p>
<a href="javascript:" onclick="return  _review($('#txtreu').val())" class="plunbtn">发表评论</a>
</div>
<div class="intitle">
<h2>网友评论</h2>
</div>
<ul id="pl">

<?php foreach($reviews as $review){?>
	<?php
	if(!empty($review['face']))
		$face = getthumb($review['face'],'50_50');
	else{
		 if($review['sex']==1){
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
		 }else{ 
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
		 }

		 $face = getthumb($defaulturl,'50_50');
	} ?>

	<li class="liplun">
	<div class="ewtweie">
	<img width="50px" height="50px" src="<?=$face?>" />
	</div>
	<p style="color:#2b9bce;"><?=$review['username']?></p>
	<p style="word-wrap: break-word;"><?=$review['subject']?></p>
	<p style="margin-top:12px;"><?=date('Y-m-d H:i:s',$review['dateline'])?></p>
	</li>
<?php }?>
</ul>
</div>
</div>
</div>
<input type="hidden" id="formhash" name="formhash" />
<input type="hidden" id="token" name="token" value="<?=createToken()?>"/>
<?php
if(!empty($user['face']))
		$uface = getthumb($user['face'],'50_50');
	else{
		 if($user['sex']==1){
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
		 }else{ 
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
		 }

		 $uface = getthumb($defaulturl,'50_50');
	}
?>
<script type="text/javascript">
function _review(){
	$.post('/portal/reviews/getHashCodeAjax.html',{itemid:"<?=$article['itemid']?>"},function(message){
			$("#formhash").val(message);
			if(_check($('#txtreu').val())==true){
				$.post('/portal/reviews/addOneReview.html',{itemid:"<?=$article['itemid']?>",formhash:$("#formhash").val(),subject:$('#txtreu').val(),token:$('#token').val()},function(message){
					if(message=="1"){
					$.showmessage({
						message:'评论成功！',
						callback :function(){
                           review_refresh();
                        }});
					}else{
						$.showmessage({message:'评论失败！'});
					}	
				});
				
			}
		});
	return false;
}

function _check(content){
	if($("#formhash").val()==0){
		// tologinn('/login.html?returnurl=__url__');
		var url = location.href+'?content='+$('#txtreu').val();
		$.loginDialog(url);
		return false;
	}
	if($.trim(content).length>150||$.trim(content).length<1){
		$.showmessage({message:'评论长度必须为1-150!'});
		return false;
	}
	return true;
}
function review_refresh(){
	var newreview = new Array();
	newreview.push('<li class="liplun">');
	newreview.push('<div class="ewtweie">');
	newreview.push('<img width="50px" height="50px" src="<?=$uface?>" />');
	newreview.push('</div>');
	newreview.push('<p style="color:#2b9bce;"><?=$user['username']?></p>');
	newreview.push('<p style="word-wrap: break-word;">'+$('#txtreu').val()+'</p>');
	newreview.push('<p style="margin-top:12px;"><?=date('Y-m-d H:i:s',time())?></p>');
	newreview.push('</li>');
	if($('#p1 li').length>5){
		$('#pl li:last').remove();
	}
	$('#pl').prepend(newreview.join(''));
	$('#txtreu').val('');
}
</script>
<?php $this->display('common/footer');?>