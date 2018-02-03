<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jqPaginator.js"></script>
<style>
	.wordent{
		font-family: "微软雅黑";
	} 
	.wordent .head_tr{
		width: 100%;
		height: 40px;
		line-height: 40px;
		font-weight: 600;
		font-size: 15px;
		text-align: center;
		position: relative;
	}
	.wordent .recordlist{
		line-height: 60px;
		font-size: 15px;
		text-align: center;
	}
	.wordent .time{
		float: left;
		width: 20%;
	}
	.wordent .shuom{
		overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
		float: left;
		width: 40%;
		text-align: left;
	}
	.shuom em{
		color: red;
	}
	.wordent .pay{
		float: left;
		width: 10%;
	}
	.wordent .money{
		float: left;
		width: 10%;
	}
	.wordent .yumoney{
		float: left;
		width: 20%;
	}
	
	.select_mk{
		width: 100px;
		height: 40px;
		line-height: 40px;
		text-align: center;
	}
	.select_mk .default{
		display: block;
	    width: 100px;
	    height: 40px;
	    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/recorddown.png) no-repeat;
	    background-size: 18px;
    	background-position: 72px 16px;
	    text-indent: 10px;
	    text-align: left;
	}
	.select_mk .select_box{
		display: none;
	}
	.select_mk .select_box a{
		display: block;
		width: 100px;
		height: 30px;
		line-height: 30px;
		font-weight: 500;
		background: #f3f3f3;
		border-top: 1px solid #fff;
	}
	.select_mk:hover .select_box{
		display: block;
	}
	.select_mk .select_box a.avtive{
		color: red;
	}
	.paginationbox{
		width: 500px;
		float: right;
	}
	.paginationbox .pagination{
		float: right;
		margin-right: 20px;
	}
	.pagination li{
		float: left;
		list-style: none;
	}
	.pagination>li>a {
	  	margin-right: 5px;
	  	border-radius: 2px;
	  	background: #f9f9f9;
	  	color: #767676;
	  	border-color: #f9f9f9;
	  	padding: 6px 15px;
	  	font-weight: bold;
	}
	.pagination>li>a:hover,
	.pagination>li>a:focus {
	  	color: #FFFFFF;
	  	background: #23a1f2;
	  	border-color: #23a1f2;
	  	font-weight: bold;
	}
	.pagination>.active>a,
	.pagination>.active>a:hover,
	.pagination>.active>a:focus {
	  	color: #FFFFFF;
	  	background: #23a1f2;
	  	border-color: #23a1f2;
	  	font-weight: bold;
	}
	.pagination .prev  {
	    background: none;
	    width: inherit;
	    height: inherit;
	}
	.pagination .next{
	  	background: none;
	  	width: inherit;
	  	height: inherit;
	}
	.pagination li.disabled{
	  	display: none;
	}
	a.mytitle {
    float: left;
    height: 24px;
    line-height: 24px;
    margin: 10px 0 0 20px;;
    padding: 0 10px;
	color:#666;
	font-size:14px;
	font-family: 微软雅黑;
}
a.fenlan {
    background: #5E96F5 none repeat scroll 0 0;
    color: #fff;
}
</style>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
<?php if ($share) {?>
<a class="mytitle  fenlan" style="margin-left:45px" href="/homev2/purse/charge.html?share=1" >分销收益</a>
<a class="mytitle" href="/homev2/purse/charge.html" >其他收益</a>
<?php } else{?>
<a class="mytitle " style="margin-left:45px" href="/homev2/purse/charge.html?share=1" >分销收益</a>
<a class="mytitle fenlan" href="/homev2/purse/charge.html" >其他收益</a>
<?php }?>
         <div class="wordent">
          <div class="wordent">
    		<div class="head_tr">
    			<div class="time">时间</div>
    			<div class="shuom">商品说明</div>
    			<div class="pay">
    				<div class="select_mk">
						<ul>
							<li>
								<a class="default" type="0" href="javascript:void(0);">付款方式</a>
								<div class="select_box">
								<?php if(empty($share)) {?>
								    <a type="0" href="javascript:void(0);">全部</a>
									<a type="9" href="javascript:void(0);">微信</a>
									<a type="2" href="javascript:void(0);">支付宝</a>
									<a type="10" href="javascript:void(0);">现金奖励</a>
									<a type="4" href="javascript:void(0);">中国农业银行</a>
									<a type="3" href="javascript:void(0);">银联</a>
									<a type="11" href="javascript:void(0);">退款</a>
								<?php } else {?>
									<a type="0" href="javascript:void(0);">全部</a>
									<a type="9" href="javascript:void(0);">微信</a>
									<a type="3" href="javascript:void(0);">支付宝</a>
									<a type="8" href="javascript:void(0);">余额支付</a>
									<a type="6" href="javascript:void(0);">中国农业银行</a>
									<a type="7" href="javascript:void(0);">银联</a>
								<?php }?>
								</div>
							</li>
						</ul>
					</div>
				</div>
    			<div class="money">金额/元</div>
    			<div class="yumoney">当前余额</div>
    		</div>
    		<div class="recordlist">
    		</div>
    		<div class="paginationbox">
    			<div id="paginator" class="pagination"></div>
    		</div>
    	</div>
        </div>
        
    </div>
</div>
<script>
	var share = <?php echo empty($share)?0:1; ?>;
	console.log(share);
	var count = 0;
	$(function(){
		getjl(0,1)
		$('.select_mk a').on('click',function(){
			var type = $(this).attr('type');
			if(type == '0'){
				$('.select_mk .select_box a').removeClass('avtive');
			}else{
				$('.select_mk .select_box a').removeClass('avtive');
				$(this).addClass('avtive');
			}
			getjl(type,1)
		})
	})
	
	function getjl(type,pagenum){
		if (share) {
			var url = '/homev2/purse/charge.html?share=1';
		} else {
			var url = '/homev2/purse/charge.html';
		}
		$.ajax({	
			url:url,
			method:'get',
			dataType:'json',
			data:{
				type : type,
				pagesize : 20,
				page : pagenum
			}
		}).done(function(res){
			
			if(!res.list.length){
				$('.recordlist').empty().append('<div class="nodata"></div>')
			}else if(res.count <= 20){
				getjlo(type,1)
			}
			if(res.count > 20){
				$('#paginator').jqPaginator({
				    totalCounts: parseInt(res.count),
				    pageSize : 20,
				    visiblePages: 10,
				    currentPage: 1,
				    disableClass :'disabled',
				    first: '',
				    prev: '<li class="prev"><a href="javascript:void(0);">上一页</a></li>',
				    next: '<li class="next"><a href="javascript:void(0);">下一页</a></li>',
				    last: '',
				    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
				    onPageChange: function (num) {
						getjlo(type,num)
				    }
				});
			}else{
				$('#paginator').empty()
			}
			
			
		}).fail(function(){});
	}
	function getjlo(type,pagenum){
		if (share) {
			var url = '/homev2/purse/charge.html?share=1';
		} else {
			var url = '/homev2/purse/charge.html';
		}
		$.ajax({	
			url:url,
			method:'get',
			dataType:'json',
			data:{
				type : type,
				pagesize : 20,
				page : pagenum
			}
		}).done(function(res){
			var list = res.list;
			$('.recordlist').empty();
			if(list.length){
				for(var i=0;i<list.length;i++){
					var time = times(list[i].dateline)
					var pay;
					var explain;
					if (share) {
						console.log(list);
						if(list[i].buyer_info == "9"){
							pay = '微信';
						}else if(list[i].buyer_info == "3"){
							pay = '支付宝'
						}else if(list[i].buyer_info == "6"){
							pay = '中国农业银行'
						}else if(list[i].buyer_info == "7"){
							pay = '银联'
						}else if(list[i].buyer_info == "8"){
							pay = '余额支付'
						} else {
							pay = '不明'
						}
					} else {
						if(list[i].type == "9"){
							pay = '微信';
						}else if(list[i].type == "2"){
							pay = '支付宝'
						}else if(list[i].type == "11"){
							pay = '退款'
						}else if(list[i].type == "4"){
							pay = '中国农业银行'
						}else if(list[i].type == "3"){
							pay = '银联'
						}else if(list[i].type == "10"){
							pay = '现金奖励'
						}else if(list[i].type == "12"){
							pay = '分销所得'
						}
					}
					
					if(list[i].type == "11" || list[i].type == "12"){
						explain = list[i].cardno;
					}else if(list[i].type == "10"){
						explain = '奖学金发放';
						
					}else{
						explain = '退款';
					}
					var title = explain.replace(/<em>|<\/em>/g,'');
					var mvalue = list[i].value;
					if (mvalue>0) {
						mvalue = '+'+mvalue;
					} 
					var listhtml = '<div class="list">'
						+'<div class="time">'+time+'</div>'
		    			+'<div class="shuom" title="'+title+'">'+explain+'</div>'
		    			+'<div class="pay">'+pay+'</div>'
		    			+'<div class="money"><span style="color: red;">'+mvalue+'</span></div>'
		    			+'<div class="yumoney">'+list[i].curvalue+'</div>'
					+'</div>';
					$('.recordlist').append(listhtml)
				}	
			}else{
				$('.recordlist').empty();
			}
		}).fail(function(){});
	}
	
	function times(value){
		var d = new Date(parseInt(value) * 1000)
	    var year = d.getFullYear(),
	    month = (d.getMonth()+1) < 10 ? '0' + (d.getMonth()+1):d.getMonth()+1,
	    date = d.getDate() < 10 ? '0' + d.getDate() : d.getDate(),
	    hour = d.getHours() < 10 ? '0' + d.getHours() : d.getHours(),
	   	minute = d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes(),
	    second = d.getSeconds() < 10 ? '0' + d.getSeconds() : d.getSeconds();
	
	    return   year+"-"+month+"-"+date+"   "+hour+":"+minute+":"+second;  
	}
</script>
<?php $this->display('homev2/footer');?>