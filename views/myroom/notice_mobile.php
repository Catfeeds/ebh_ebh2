<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$roominfo['crname']?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="/static/mui/css/mui.min.css">
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="/static/mui/css/app.css"/>
		<script src="http://static.ebanhui.com/wap/js/jquery/jquery-1.11.0.min.js"></script>
		<style text/css>
			body {background:#fff;}
			.title {
			    margin: 10px 15px 0px;
			    color: #6d6d72;
			    font-size: 15px;
			}
			.mui-input-row img {margin:10px 0;}
			.mui-input-row {word-wrap:break-word;color:#999;}
			.tisese {
				font-size: 15px;
				text-align: center;
				padding:5px 10px;
				line-height: 1.5;
				margin-bottom:0;
				color: #666;
			}
			.fastre {
				text-align: center;
				margin:0;
				color: #999;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav" style="background:#fff;">
			<h3 class="mui-title">详情</h3>
		</header>
		<div class="mui-content" style="background:#fff;">
			<h2 class="tisese">关于标题的</h2>
			<p class="fastre"></p>
			<div class="mui-input-row" style="padding:10px;">
				
				<img src="http://ss.ebh.net/static/ueditor/dialogs/emotion/images/jx2/j_0003.gif">
			</div>			
		</div>
	</body>
	<script src="/static/mui/js/mui.min.js"></script>
	<script>
		mui.init({
			swipeBack:true //启用右滑关闭功能
		});
		var noticeid=<?=$noticeid?>;
		$.ajax({
			type:"get",
			url:"/myroom/default/getNoticeDetail.html",
			async:true,
			data:{'noticeid':noticeid},
			dataType:"json",
			success:function(data){
				var time2 = new Date(data.data.dateline * 1000).Format("yyyy-MM-dd hh:mm");
				$(".tisese").html(data.data.title);	
				$(".fastre").html(data.data.realname+'&nbsp&nbsp'+time2+'发布');
				fiximg($(".mui-input-row").html(data.data.message));
				
	        }
		});
		$(".mui-input-row p").each(function(){
			alert(1);
		  //var xx=$(this).html();  
		  //$(this).replaceWith(xx);
		});
		function fiximg(){
			var _w = parseInt($(window).width());//获取浏览器的宽度
			$(".mui-input-row img").each(function(i){
				var img = $(this);
				var realWidth;//真实的宽度
				var realHeight;//真实的高度
					//这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
					$("<img/>").attr("src", $(img).attr("src")).load(function() {
					realWidth = this.width;
					realHeight = this.height;
					//如果真实的宽度大于浏览器的宽度就按照100%显示
					if(realWidth>=_w){
						$(img).css("width","100%").css("height","auto");
					}
					else{//如果小于浏览器的宽度按照原尺寸显示
						$(img).css("width",realWidth+'px').css("height",realHeight+'px');
					}
				});
			});
		}
		//转换时间格式
		Date.prototype.Format = function (fmt) { //author: meizz 
		    var o = {
		        "M+": this.getMonth() + 1, //月份 
		        "d+": this.getDate(), //日 
		        "h+": this.getHours(), //小时 
		        "m+": this.getMinutes(), //分 
		        "s+": this.getSeconds(), //秒 
		        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
		        "S": this.getMilliseconds() //毫秒 
		    };
		    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
		    for (var k in o)
		    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
		    return fmt;
		}
	</script>
</html>