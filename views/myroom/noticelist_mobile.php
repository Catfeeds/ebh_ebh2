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
		<style text/css>
			.title {
			    margin: 10px 15px 0px;
			    color: #6d6d72;
			    font-size: 15px;
			}
			.bacfer {
				margin:10px;
				padding:10px;
				background: #fff;
				border-radius:6px;
			}
			.chusrt {
				font-weight: bold;
				color: #666;
				font-size: 15px;
			}
			.scusrte p {
				margin-bottom: 0;
				white-space: normal;
				display: -webkit-box;
				-webkit-box-orient: vertical;
				-webkit-line-clamp: 3;
				overflow: hidden;
				word-wrap:break-word;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav" style="background:#fff;">
			<h1 class="mui-title"><a href="http://www.baidu.com">消息通知</a></h1>
		</header>
		<div id="pullrefresh" class="mui-content mui-scroll-wrapper">
			<div class="mui-scroll">
				<div id="content-tz">

				</div>
			</div>
		</div>
	</body>
	<script src="http://static.ebanhui.com/wap/js/jquery/jquery-1.11.0.min.js"></script>
	<script src="/static/mui/js/mui.min.js"></script>
	<script>
		mui.init({
			swipeBack:true //启用右滑关闭功能
		});
		var page = 1
		platformlist(page);
		function platformlist(page){
			$.ajax({
				type:"get",
				url:"/myroom/default/getNoticeList.html",
				async:true,
				data:{'page':page,},
				dataType:"json",
				success:function(data){
					var list = [];
					list = data.list;
					var htmltz = '';
					for(var i=0;i<list.length;i++){
						if (list[i].message==null) {
							list[i].message = '';
						}
						var time2 = new Date(list[i].dateline * 1000).Format("yyyy-MM-dd hh:mm");
						var htmltz ='<div class="title">'+time2+'</div>'
							htmltz +='<div class="bacfer">'
							htmltz +=	'<a href="/myroom/default/notice/'+list[i].noticeid+'.html">'
							htmltz +=		'<p class="mui-ellipsis chusrt">'+list[i].title+'</p>'
							htmltz +=		'<div class="mui-ellipsis scusrte">'+list[i].message+'</div>'
							htmltz +=	'</a>'
							htmltz +='</div>'
							htmltz +=	'</div>';
							$("#content-tz").append(htmltz);
						$("img").each(function(){  
						  var xx=$(this).html();  
						  $(this).replaceWith(xx);  
						});
					}
					mui('#pullrefresh').pullRefresh().endPullupToRefresh(list.length == 0);
				}
			});
		}
		mui.init({
			pullRefresh: {
				container: '#pullrefresh',
				up: {
					contentrefresh: '正在加载...',
					callback: function(){
						page = page+1;
						platformlist(page)
					}	
				}
			}
		});
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
		//a标签链接点击没反应问题
		mui('.mui-scroll-wrapper').on('tap','a' ,function(){location.href = this.getAttribute('href')})
	</script>
</html>