<?php $this->display('shop/plate/headernew');?>
<style>
/**样式**/
.course_img{
	float:left;
	margin-right:9px;
	position: relative;
	overflow:hidden;
}
.mui-table-view .mui-media-object.mui-pull-left{
	margin-right:0;
}
.mui-table-view .mui-media-object{
	max-width: 120px!important;
	min-width: 120px!important;
	height:70px!important;
	line-height: 70px!important;
}
.mui-table-view:before{
	height:0!important;
}
.mui-table-view-cell:last-child:after, .mui-table-view-cell:last-child:before{
	height:0!important;
}
.mui-table-view:after{
	height:0!important;
}
.mui-table-view-cell:after{
	height:0!important;
}
.mui-ellipsis{
	margin-top: 7px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}
span.mui-icon {
	font-size: 14px;
	color: #007aff;
	margin-left: -15px;
	padding-right: 10px;
}
.mui-table-view:before{
	height: 0!important;
}
.mui-table-view:after{
	height: 0!important;
}
.folder_once:after{
	height:0!important;
}
.mui-table-view-cell:after{
	right:12px!important;
	left:12px!important;
}
.mui-plus header.mui-bar {
	display: none!important;
}
.mui-plus .mui-bar-nav~.mui-content {
	padding: 0!important;
}

.mui-plus .plus{
	display: inline;
}
.plus{
	display: none;
}
span.mui-icon {
	font-size: 14px;
	color: #007aff;
	margin-left: -15px;
	padding-right: 10px;
}
.mui-popover {
	height: 300px;
}
.mui-table-view-cell {
	padding-right:25px;
}
.title {
    margin: 20px 15px 10px;
    color: #6d6d72;
    font-size: 15px;
}
.mui-off-canvas-wrap .mui-bar-nav {
    top: 0;
    -webkit-box-shadow: 0 1px 6px #ccc;
    box-shadow: 0 1px 6px #ccc;
}
.mui-control-content {
	background-color: white;
	min-height: 215px;
}
.mui-control-content .mui-loading {
	margin-top: 50px;
}
.mui-bar-nav~.mui-content .mui-slider.mui-fullscreen {
	top:45px;
}
.mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell {
	padding-left: 15px;
}
.mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell:after {
	left:0px;
}
.mui-table-view-cell.mui-collapse.mui-active .mui-table-view-cell>a:not(.mui-btn).mui-active{margin-left:-31px;padding-left:31px}
.mui-table-view-cell:after {background:#c8c7cc;}
.mui-table-view .mui-media-object {max-width:70px;}
.husrrtas {
    margin-top: 0px;
}
.btn-rig {
	float:right;
}
.mui-scroll {
	z-index:10;
}
.mui-bar-nav~.mui-content.mui-scroll-wrapper .mui-scrollbar-vertical {top:0px;}
</style>
<div class="toptitl" style="position: absolute;z-index: 999;top:<?php if(!empty($settings['top'])) { echo $settings['top'];}else { echo 0;}?>rem;">
	<a class="rigtopalik" href="javascript:;">
		<i class="botjt topjt"></i>
		<span class="husner">全部</span>
	</a>
	<span class="rigmeke">共<span id="coursenum"></span>门课程</span>
</div>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="background:#fff;top:<?php if(!empty($settings['top'])) {$rem=$settings['top']+1;echo $rem.'rem';}else { echo '40px';}?>">
	<div class="mui-scroll">
		<ul class="mui-table-view mui-table-view-chevron" id="content-panel">
			
		</ul>
	</div>
</div>

<!--课程筛选!-->
<div class="foldercourse_box" style="display: none;">
	<div class="mui-scroll-wrapper" id="folder" 
style="top:<?php if(!empty($settings['top'])) {$rem=$settings['top']+1;echo $rem.'rem';}else { echo '40px';}?>;width:45%!important;background: #f3f3f3;left:0;height:70%;z-index: 999;"> 
		<div class="mui-scroll" style="width: 100%;">
			<ul id="left-panel" class="mui-table-view" style="background: #f3f3f3;width:100%;">
				
			</ul>
		</div>
	</div>
	<div class="mui-scroll-wrapper" id="course" style="top:<?php if(!empty($settings['top'])) {$rem=$settings['top']+1;echo $rem.'rem';}else { echo '40px';}?>;width:55%!important;background: #fff;left:45%;height:70%;z-index: 999;">
		<div class="mui-scroll">
			<ul class="mui-table-view" id="right-panel">
					
			</ul>
		</div>
	</div>
</div>

<div class="mui-popup-backdrop mui-active" style="display: none;"></div>

<script type="text/javascript">
	var page = 1,pid=<?=intval($this->input->get('pid'))?>,sid=-1;    	//参数
    <?php if ($this->input->get('sid') !== null) { ?>
        sid=<?=intval($this->input->get('sid'))?>;
    <?php }?>
	var packageListdata = [];		//用于保存分类列表数据
	platformlist(pid,sid,page);
	function platformlist(pid,sid,page){
		$.ajax({
			type:"get",
			url:"/platform.html",
			async:true,
			data:{'pid':pid,'sid':sid,'page':page,'ajax': 1},
			dataType:"json",
			success:function(data){
				if(data.code == 0){
					var courselist = data.data.items;
					$("#coursenum").html(data.data.count);
					for(var i=0;i<courselist.length;i++){
					var price = courselist[i].price;
					if (courselist[i]['t'] == 2) {
						courselist[i]['detailurl'] = '/bundle/'+courselist[i]['id']+'.html';
					} else if (courselist[i]['tagged']) {
						courselist[i]['detailurl'] = '/room/portfolio/bundle/'+courselist[i]['id']+'.html';
					} else {
						courselist[i]['detailurl'] = '/courseinfo/'+courselist[i]['itemid']+'.html';
					}
					var	htmlfrage = '<li class="mui-table-view-cell mui-media" style="padding: 0;border-bottom:solid 1px #eee">'
						htmlfrage +=	'<a href="'+courselist[i].detailurl+'" style="margin: 0;padding:8px 12px;">'
						htmlfrage +=		'<div class="course_img">'
						htmlfrage +=			'<img class="mui-media-object mui-pull-left" src="'+courselist[i].cover+'">'
						htmlfrage +=		'</div>'
						htmlfrage +=		'<div class="mui-media-body">'
						htmlfrage +=			'<p class="mui-ellipsis course_name">'+courselist[i].title+'</p>'
						htmlfrage +=			'<p class="mui-ellipsis course_price">'
						htmlfrage +=				'讲师：'+courselist[i].speaker+''
						htmlfrage +=			'</p>'
						htmlfrage +=			'<p class="mui-ellipsis course_price course_label">'
						htmlfrage +=				'<span class="man_img"></span>'
						htmlfrage +=				'<span class="man_num">'+courselist[i].viewnum+'</span>'
						htmlfrage +=				'<span class="time_img"></span>'
						htmlfrage +=				'<span class="time_num">'+courselist[i].coursewarenum+'</span>'
						if(price == 0){
							htmlfrage +=			'<span class="price_num"><span style="float: right;font-size:16px;color:#66CC00;">免费</span</span>'
						} else {
							htmlfrage +=			'<span class="price_num">￥'+courselist[i].price+'</span>'
						}
						htmlfrage +=			'</p>'
						htmlfrage +=		'</div>'
						htmlfrage +=	'</a>'
						htmlfrage += '</li>';
						$("#content-panel").append(htmlfrage);
					}
				}
				mui('#pullrefresh').pullRefresh().endPullupToRefresh(data.data.items.length == 0);
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
					platformlist(pid,sid,page)
				}	
			}
		}
	});
	
	
	//点击出现分类列表弹窗
	$(".rigtopalik").on("tap",function(){
		if($(this).find('i').hasClass("botjt")){
			$(".foldercourse_box").show();
			$(".mui-popup-backdrop").show();
			$(this).find('i').removeClass("botjt");
		}else{
			$(".foldercourse_box").hide();
			$(".mui-popup-backdrop").hide();
			$(this).find('i').addClass("botjt");
		}
	}); 
	
	//加载分类列表
	getMorePackageList();
	function getMorePackageList(){
		$("#left-panel").empty();
		$("#right-panel").empty();
		$.ajax({
			type: 'get',
			url: '/room/portfolio/getMorePackageList.html',
			data: {  'ajax': 1, },
			dataType: 'json',
			success:function(data){
				if(data.code == 0){
					var datas = data.data;
					packageListdata = datas;
					var htmlleftall = '<li class="mui-table-view-cell folder_once">全部</li>';
					$("#left-panel").append(htmlleftall);
					for(var i=0;i<datas.length;i++){
						var htmlleft = '<li class="mui-table-view-cell folder_once" pid="'+datas[i].pid+'" pname="'+datas[i].pname+'">'+datas[i].pname+'</li>';
						$("#left-panel").append(htmlleft);
					}
					var righthtmlall = '<li class="mui-table-view-cell course_once" pid="0" sid="-1" pname="全部">全部</li>';
					$("#right-panel").append(righthtmlall);
				}
                if (pid > 0) {
                    $("#left-panel li[pid='"+pid+"']").trigger('tap');
                    $(".husner").html($("#right-panel li[sid='"+sid+"']").attr('pname'));
                }
			}
		});
	}
	
	//点击弹窗左边主类事件
	$("#left-panel").on("tap",".folder_once",function(){
		var pid = $(this).attr('pid');
		var pname = $(this).attr('pname');
		$(this).addClass("clicked");
		$(this).siblings().removeClass("clicked");
		$("#right-panel").empty();
		if($(this).html() != "全部"){
			var righthtmlall = '<li class="mui-table-view-cell course_once" pname="'+pname+'" sid="-1" pid="'+pid+'">全部</li>';
			$("#right-panel").append(righthtmlall);
			var towlistdata = [];
			for(var i=0;i<packageListdata.length;i++){
				if(pid == packageListdata[i].pid){
					towlistdata = packageListdata[i].sorts;
				}
			}
			for(var j=0;j<towlistdata.length;j++){
				var righthtml = '<li sid="'+towlistdata[j].sid+'" pid="'+towlistdata[j].pid+'" class="mui-table-view-cell course_once" pname="'+towlistdata[j].sname+'">'+towlistdata[j].sname+'</li>';
				$("#right-panel").append(righthtml);
			}
			//var righthtmlqita = '<li class="mui-table-view-cell course_once" sid="0" pid="'+pid+'" pname="其他">其他</li>';
			//$("#right-panel").append(righthtmlqita);
		}else{
			var righthtmlall = '<li class="mui-table-view-cell course_once" pname="全部" sid="-1" pid="0">全部</li>';
			$("#right-panel").append(righthtmlall);
		}
	});

	
	//点击弹窗右边子类事件
	$("#right-panel").on("tap",".course_once",function(){
		$("#content-panel").empty();
		$(".foldercourse_box").hide();
		$(".mui-popup-backdrop").hide();
		$(".rigtopalik").find('i').addClass("botjt");
		var pname = $(this).attr('pname');
		$(".husner").html(pname);
		pid = $(this).attr('pid');
		sid = $(this).attr('sid');
		page = 1;
		platformlist(pid,sid,page);
		mui('#pullrefresh').pullRefresh().refresh(true);
	});

	
	//点击阴影背景隐藏选择框
	$(".mui-popup-backdrop").on("tap",function(){
		$(".foldercourse_box").hide();
		$(".mui-popup-backdrop").hide();
		$(".rigtopalik").find('i').addClass("botjt");
	});
	
	
	
	
	
mui.init({
	swipeBack: true, //启用右滑关闭功能
});
(function($) {
	$('.mui-scroll-wrapper').scroll({
		indicators: false, //是否显示滚动条
	});
})(mui);


	
</script>
<?php $this->display('shop/plate/footers');?>