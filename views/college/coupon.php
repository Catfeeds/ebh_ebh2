<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>优惠码</title>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<style>
.yhm {
    border-bottom: 1px solid #f1f1f1;
    color: #626262;
    height: 45px;
    line-height: 45px;
    padding-left: 10px;
}
.yhm span {
    color: #fd5016;
    font-family: 微软雅黑;
    font-size: 18px;
    line-height: 45px;
}
.yhm a {
    color: #999;
    line-height: 45px;
    padding-left: 8px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.js"></script>
</head>
<body>
<div class="yhm">优惠码：<span id="mycoupon"><?=empty($mycoupon)?'---':$mycoupon?></span><?php if (!empty($mycoupon)){?><a href="javascript:;" class="copycoupon">复制</a><?php }?></div>
<script language="javascript">
$(function(){
var couponFlag = true;
	//配置swf文件的路径
	ZeroClipboard.config({swfPath: "http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.swf"});
	//创建客户端
	var client = new ZeroClipboard( $('.copycoupon') );
    client.on( 'copy', function(event) {
     	var txt = $('#mycoupon').html();
     	event.clipboardData.setData('text/plain', txt);
    } );
    client.on( 'aftercopy', function(event) {
        top.dialog({
        skin:"ui-dialog2-tip",
        width:350,
        content: "<div class='TPic'></div><p>复制成功</p>",
        onshow:function () {
            var that=this;
            setTimeout(function () {
                that.close().remove();
            },1000);
        }
        }).show();
    });
	client.on( 'error', function(event) {
    	ZeroClipboard.destroy();
  	} );
});
</script>
</body>
</html>