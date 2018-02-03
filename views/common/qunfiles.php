<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />
<style type="text/css">
.enjoy {
	width:100%;
}
.titlie {
	height:50px;
	line-height:50px;
	padding:0 15px;
}
.upadbtn {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/upadbtn.jpg) no-repeat;
	width:70px;
	height:27px;
	border:none;
	cursor:pointer;
	float:right;
	margin-top:10px;
}

.titlie .leixBtnd {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/xuanzico0329.jpg) no-repeat scroll 60px 6px;
    border: 1px solid #42A2E6;
    color: #42A2E6;
    display: inline;
    height: 21px;
    width: 70px;
}
.leix {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/weixuan0329.jpg) no-repeat scroll 60px 6px;
    border: 1px solid #D0D2D1;
    float: left;
    height: 21px;
    line-height: 21px;
    margin: 12px 10px 0 0px;
    padding-left: 7px;
    text-align: left;
    width: 70px;
}
#nav{    
    overflow-y: auto;
    width: 100%;
	position:relative;
}
#nav h3{ cursor:pointer; line-height:25px; height:25px;border-top:solid 1px #e3dee2;padding-left:25px; color:#8d8d8d;font-weight:bold;background:url(http://static.ebanhui.com/ebh/tpl/default/images/xiaico.png) no-repeat 8px center #f1f1f1;}
#nav h3.cuohui {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/rightico.png) no-repeat 8px center #f1f1f1;
}
#nav .erlan{display:block;color:#000;padding:12px 0;margin-left:20px;height:40px; border-bottom:solid 1px #eeeeee;}
#nav .erlan:hover{background-color:#fffbe8; color:#000;}
.xiachabtn {
	width:120px;
	height:23px;
	float:right;
	margin-right:10px;
	margin-top:10px;
}
.erlan img {
	float:left;
}
.wenjie {
	float:left;
	margin-left:10px;
}
.xiachabtn a.xiazaibtn {
	color:#000;
	width:35px;
	display:block;
	height:21px;
	float:right;
	line-height:21px;
	border-right:solid 1px #eee;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/zaiico.png) no-repeat 5px center;
	padding-left:18px;
	text-decoration:none;
	border:solid 1px #C3BDB1;
}
.xiachabtn a.xiazaibtn:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/zaiico.png) no-repeat 5px center #e3f6f2;
}
.xiachabtn a.deletebtn {
	color:#000;
	width:35px;
	display:block;
	height:21px;
	float:right;
	line-height:21px;
	border-right:solid 1px #eee;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/deleico.png) no-repeat 5px center;
	padding-left:18px;
	text-decoration:none;
	border:solid 1px #C3BDB1;
	margin-left:5px;
}
.xiachabtn a.deletebtn:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/deleico.png) no-repeat 5px center #e3f6f2;
}
.xiasten {
	text-align:center;
	color:#666666;
	font-size:14px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript">
$(function(){
	$(".h3nav").click(function(){
		var h3id = $(this).attr("id");
		var id = h3id.substr(3);
		if($("#div_"+id).css("display") == "none") {
			$("#div_"+id).show();
		} else {
			$("#div_"+id).hide();
		}
	});
	$(".deletebtn").click(function(){
		var delid = $(this).attr("id");
		var id = delid.substr(4);
		var url="<?= geturl('qunfiles/del')?>";
		$.ajax({
			url:url,
			type:"post",
			dataType:"text",
			data:{'id':id},
			success:function(data){
				if(data == 1) {
					$("#li_"+id).remove();
				} else {
					alert("删除失败");
				}
			}
		});
	});
});
</script>
<title>群文件共享</title>
</head>

<body>
<div class="enjoy">
	<div id="nav">
		<?php if(!empty($filelist)) { 
		foreach($filelist as $ymonth=>$monthfiles) {
		?>
		<h3 class="h3nav" id="h3_<?= $ymonth ?>"><?= $monthfiles['ymonthname'] ?></h3>
   		<div class="xiand" id="div_<?= $ymonth ?>">
			<ul>
				<?php foreach($monthfiles['list'] as $file) {?>
    			<li class="erlan" id="li_<?= $file['fileid'] ?>">
					<img src="http://static.ebanhui.com/ebh/tpl/default/images/<?= isset($icons[$file['suffix']])?$icons[$file['suffix']]:'morencio.jpg'?>" />
					<div class="wenjie">
						<p style="font-size:14px;"><?= $file['name'] ?></p>
						<p><?= getSize($file['size']) ?><span style="color:#888;">&middot;<?= $file['downnum']?>次下载　<?= empty($file['realname'])?$file['username']:$file['realname']?>　<?=date('Y-m-d',$file['dateline'])?></span></p>
		 			</div>
					<div class="xiachabtn">
			 			<?php if ($file['uid'] == $user['uid'] ) { ?>
						<a href="javascript:void()" id="del_<?= $file['fileid']?>" class="deletebtn">删除</a>
						<?php } ?>
			 			<a href="<?= 'down://'.$file['fileid'].'|'.$file['name']?>" class="xiazaibtn">下载</a>
		 			</div>
	 			</li>
				<?php } ?>
			</ul>
    	</div>
		<?php } 
		} else {
		?>
		<img style="margin:40px 0 20px 190px;" src="http://static.ebanhui.com/ebh/tpl/default/images/nonetu.jpg" />
		<p class="xiasten">在这里，你可以把各种有趣的东西分享给大家</p>
		<?php } ?>
	</div>
</div>
</body>
</html>
