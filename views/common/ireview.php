<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css">
<script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<style type="text/css">
.huisou {
	height:26px;
	line-height:26px;
	margin:10px 0;
}
.txtsou {
	width:138px;
	height:20px;
	float:left;
}
.ewping {
	width:748px;
}
.ewping .ekewen {
	width:746px;
	line-height:26px;
	background:#fefefe;
}
.grades {
    color: #515151;
    height: 35px;
    line-height: 35px;
    padding-left: 6px;
}
.dfoeew {
	color: #515151;
    line-height: 24px;
    padding-left: 6px;
}
.restore {
    margin: 2px auto 10px;
    width: 627px;
}
.restore_arrow {
    color: #e4eff4;
    height: 5px;
    line-height: 10px;
    margin-left: 32px;
    overflow: hidden;
    width: 11px;
}
.restore_cont {
    background-color: #e4eff4;
    border-radius: 5px;
    color: #d0304f;
    margin-bottom: 2px;
    padding: 10px 8px;
    width: 615px;
}
.restore_cont h1 {
    color: #1f7abc;
    display: inline;
    font-size: 12px;
    font-weight: bold;
}
</style>
<title>学生评论</title>
</head>

<body>


<div class="lefrig" style="width:100%;overflow-x:hidden;margin-left:0px;font-size:14px;">
<div class="workol">

</div>

<ul id="review">
<?php ;//$user['uid']; ?>
<?php ;//print_r($reviewlist);?>
<?php if(!empty($reviews)){ ?>
	<?php foreach($reviews as $review){ 
	//$rev = current($review['review']);
	?>
		<?php if(!empty($review['subject'])){ ?>
			<li class="ewping" style="width:100%;margin-left:5px; border-bottom: 1px solid #e3e3e3;padding-bottom: 10px;background-color:#fff;">
				<div class="ekewen" style="width:100%;">
				<?php $arr = explode('.',$review['cwurl']);
		$type = $arr[count($arr)-1]; ?>
					&nbsp;<span style="font-weight:bold;"><?= $review['title']?></span>
				</div>
					 主讲：<?= !empty($review['realname'])?$review['realname']:$review['nickname'] ?> <span style="float:right; margin-right: 10px;_margin-top:-25px;"><?= date('Y-m-d H:i:s',$review['dateline'])?></span>
					
					<p class="dfoeew" style="font-size:12px;"><?= $review['subject'] ?></p>
					<?php if(!empty($review['rsubject'])){ ?>
						<div class="restore" style="width:100%;">
							<div class="restore_arrow">◆</div>
							<div class="restore_cont" style="width:98%;">
								<h1>老师回复：</h1>
								<?= $review['rsubject'] ?>
							</div>
						</div>
					<?php } ?>
			</li>
		<?php } ?>
	<?php } ?>
<?php }else{ ?>
	<div style="margin-left:20px;">暂无评论</div>
<?php } ?>
</ul>
<div id="chakan" style="margin:0 auto;width:70px;width:100%;">
	<input class="xuexibtn" type="submit" name="Submit" value="查看更多" onclick="scroll_onclick();" style="font-size: 16px;height: 70px;background-color: #fff;border:solid 1px #fff;text-align:center;width:70px;width:100%;"/>
</div>
</div>
<script type="text/javascript">
<!--
	var count = '<?=$count?>';
	var crid = '<?= $crid ?>';
	var page = 1 ;
	$(function(){
		if (parseInt(count)==0||parseInt(count)<=20)
        {
			$("#chakan").hide();
        }
	})

	function scroll_onclick(){
		var url = "<?= geturl('ireview/onclicklist')?>"+'?k='+encodeURIComponent("<?= $k?>") ;
			page=page+1;//page：页数
			$.ajax({
				url : url,
				data:{'crid':crid,'page':page},
				type	:'post',
				dataType:'json',
				success:function(data){ 			
					var demohtml = '';					 
					if(data!=''){
						 
						for(var i in data){
 							demohtml += '<li class="ewping" style="width:100%;margin-left:5px; border-bottom: 1px solid #e3e3e3;padding-bottom: 10px;background-color:#fff;">\r\n';
 							demohtml += '<div class="ekewen" style="width:100%;">\r\n';
							demohtml += '&nbsp;<a href="javascript:;" style="font-weight:bold;">';
							demohtml +=data[i].title+'</a>\r\n';
							demohtml += '</div>\r\n';
							demohtml += '主讲：'+  (data[i].realname!=""?data[i].realname:data[i].nickname)+'<span style="float:right; margin-right: 10px;_margin-top:-25px;">';
							demohtml += data[i].dateline+'</span>\r\n';////
					        demohtml +=  '<p class="dfoeew" style="font-size:12px;">'+data[i].subject+'</p>\r\n';
							if(data[i].rsubject!=''){
								demohtml +=  '<div class="restore" style="width:100%;">\r\n';
								demohtml +=  '<div class="restore_arrow">◆</div>\r\n';
								demohtml +=  '<div class="restore_cont" style="width:98%;">\r\n';
								demohtml +=  '<h1>老师回复：</h1>\r\n';
								demohtml +=  data[i].rsubject+'\r\n';
								demohtml +=  '</div>\r\n';
								demohtml +=  '</div>\r\n';  
							}
							demohtml +=  '</li>\r\n';
						}
					}
					$("#review").append(demohtml);

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
//-->
</script>
</body>
</html>