<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="http://static.ebanhui.com/ebh/js/jquery.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/stbact.css" />
<title>历史记录</title>
</head>

<body>
<div class="eawut">
<div class="topnbg">
  <?php $q=empty($q)?"输入关键字":$q?>
  <input class="shoute" name="textarea" type="text" id="textarea" value="<?=$q?>"/>
  <a href="javascript:void(0)" class="wrutsel"></a>
</div>
<div id="content">

<?php if(!empty($msglist)){?>
<?php foreach($msglist as $msg){;?>
<?php 
	$face = getthumb($msg['face'],'50_50');
	if(empty($face)){
		if($msg['sex']==1){
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
		 }else{ 
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
		 }

		 $face = getthumb($defaulturl,'50_50');
	}
?>
<div class="lietas">
<div class="wtekss">
<img src="<?=$face?>" />
</div>
<h2 class="toust"><?= empty($msg['realname']) ? $msg['username'] : $msg['realname'] ?><span style="float:right;font-size:14px;"><?= date("Y年m月d日H:i",$msg['dateline']);?></span></h2>
<a href="/wxbind/wxdetail.html?frompage=1&batchid=<?=$msg['batchid']?>&weixin_name=<?=$msg['weixin_name']?>&htype=<?=$msg['htype']?>"><p class="sneitx" style=""><?=shortstr($msg['weixin_content'],60)?></p></a>
</div>
<?php }?>
<?php } else {?>
<?php 
	$tip = '您还未收到任何消息。';
	if(!empty($q)){
		$tip = '没有找到符合条件的信息。';
	}
?>
<div style="text-align:center;color:#787878"><?=$tip?></div>
<?php } ?>
</div>
</div>
<?php if(!empty($msglist)){?>
<div class="chade">查看更多</div>
<?php }?>
</body>
<script type="text/javascript">
var num = 1;
$(function(){
	$(".chade").click(function(){
		var isload = $(".chade").attr('isloading');
		if(isload == undefined || isload == "") {
			loadmore();
		}
	});

	$(".wrutsel").click(function(){
		var q = $.trim($("#textarea").val());
		if(q == "输入关键字"){
			q="";
		}
		var url = "/wxbind/wxlist.html?frompage=1&ocode=<?= $openid ?>&q="+q;
		// var url = "/wxbind/wxlist.html?ocode=o5TnfjmDmAq0mO7h4OlkEl1pMYXI&q="+q;
		location.href = url;
	});

	$(".shoute").blur(function(){
		if($(this).val()==""){
			$(this).val("输入关键字");
		}
	}).focus(function(){
		if($(this).val()=="输入关键字"){
			$(this).val("");
		}
	});
});
function loadmore() {
	num ++;
	$(".chade").text("正在加载数据...");
	$(".chade").css("color","black");
	$(".chade").attr("isloading","1");
	var q = $.trim($("#textarea").val());
	if(q == "输入关键字"){
		q="";
	}
	var url = "/wxbind/wxlist.html?ocode=<?= $openid ?>&state=123&q="+q;
	$.ajax({
		url:url,
		type: "POST",
		data:{'num':num},
		dataType:"json",
		success: function(data){
			if(data != null && data != undefined) {
				var i = 0;
				var html = "";
				for(i = 0; i < data.length; i ++ ) {
					html+='<div class="lietas">'+
					'<div class="wtekss">'+
					'<img src="'+data[i].face+'" />'+
					'</div>'+
					'<h2 class="toust">'+data[i].uname+'<span style="float:right;font-size:14px;">'+data[i].date+'</span></h2>'+
					'<a href="/wxbind/wxdetail.html?batchid='+data[i].batchid+'&weixin_name='+data[i].weixin_name+'&htype='+data[i].htype+'"><p class="sneitx" style="">'+data[i].content+'</p></a>'+
					'</div>';
				}
				if(data.length == 0) {
					$(".chade").remove();
				} else {
					$(".chade").text("查看更多");
					$(".chade").css("color","#787878");
					$(".chade").removeAttr("isloading");
				}
				$("#content").append(html);
			}
		}
	});
}
</script>
</html>
