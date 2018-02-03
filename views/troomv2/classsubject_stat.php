<!DOCTYPE html>
<html lang="en">
	<head>
  		<meta charset="UTF-8">
  		<title></title>
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css">
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css"> 
	   	<style>
		  	*{
		    	margin: 0;
		    	padding: 0;
		    	font-family: 'Microsoft YaHei';
		  	}
	      	.nc_body{
	        	width: 960px;
	        	height: 600px;
	        	padding: 20px;
	        	overflow: hidden;
	       	 	font-family: 'Microsoft YaHei';
	      	}
	      	.nc_head{
	        	height: 36px;
	      	}
	      	.nc_head .nc_title{
	        	float: left;
	        	width: 500px;
	        	font-size: 16px;
	        	overflow: hidden;
	        	text-overflow:ellipsis;
	        	white-space: nowrap;
	        	text-align: left;
	        	font-weight: 600;
	       		font-family: 'Microsoft YaHei';
	      	}
	      	.nc_head .nc_close{
		    	float: right;
		      	padding: 0 4px;
		      	font-size: 20px;
		      	font-weight: bold;
		      	line-height: 1;
		      	color: #000;
		      	text-shadow: 0 1px 0 #FFF;
		      	cursor: pointer;
		      	background: transparent;
		      	border: 0;
		      	-webkit-appearance: none;        
		      	font-family: sans-serif;
		      	opacity: .5;
	      	}
	     	.nc_content{
	      		height: 504px;
	      	}
	      	.nc_content .filestatP{
				color: #9999AA;
				margin: 0;
				font-size: 16px;
				margin-left: 200px;
			}
			.nc_content .filestatPcou{
				margin: 0;
				margin-top: 20px;
				height: 21px;
				margin-left: 200px;
				font-size: 14px;
			}
			.nc_content .intername{
				float: left;
				color: #5E96F5;
				max-width: 297px;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}
			.nc_content .sentiment{
				background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png) no-repeat left center;
		    	padding-left: 15px;
		    	height: 20px;
		    	line-height: 20px;
		    	float: left;
		    	color: #666;
			}
	      	.nc_footer{
	      		height: 36px;
	      		padding-top: 20px;
	      	}
	 		.nc_footer .class_foot{
	 			float: right;
	    	}
	   	</style>
	</head>
<body>     
    <div class="nc_body" id="appaddStat" style="opacity: 0">
	  	<div class="nc_head">
	    	<span class="nc_title">文件统计</span>
	    	<span class="nc_close" @click="closeEvent">×</span>
	  	</div>
      	<div class="nc_content" v-loading="filestat_loading" element-loading-text="拼命加载中..."> 
      		
      		<div style="width: 100%;height: 400px;" class="echarts" ref="echartsfilestat"></div>
        	<p class="filestatP">
				<span class="size20">{{filestatData.courseNum}}</span>节课 &nbsp;&nbsp;&nbsp; 
				<span class="size20">{{filestatData.zan}}</span>个赞&nbsp;&nbsp;&nbsp;
				<span class="size20">{{filestatData.creditNum}}</span>次学习&nbsp;&nbsp;&nbsp;
				<span class="size20">{{filestatData.reNum}}</span>条评论&nbsp;&nbsp;&nbsp;
				<span class="size20">{{filestatData.cwcredit}}</span>个学分&nbsp;&nbsp;&nbsp;
				<span v-if="filestatData.ltime">时长&nbsp;<span class="size20">{{filestatData.ltime}}</span></span>
			</p>
			<p class="filestatPcou">
				<span style="float: left;width: 395px;margin-right: 10px;">
					<span style="float: left;">最受欢迎课件：</span><span class="intername" :title="filestatData.maxtitle">{{filestatData.maxtitle}}</span>
				</span>
				<span class="sentiment" title="人气值">{{filestatData.maxcwNum}}</span>
			</p>
			<p class="filestatPcou">
				<span style="float: left;width: 395px;margin-right: 10px;">
					<span style="float: left;">最受冷落课件：</span><span class="intername" :title="filestatData.mintitle">{{filestatData.mintitle}}</span>
				</span>
				<span class="sentiment" title="人气值">{{filestatData.mincwNum}}</span>
			</p>
			
      	</div>
	    <div class="nc_footer">
	      	<div class="class_foot">
	        	<el-button type="primary" @click="closeEvent">确定</el-button>
	      	</div> 
	    </div>
    </div>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/vue/vue.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/index.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/echarts.min.js"></script>
	<script>    
	    var addClassstat = new Vue({
	        el: '#appaddStat',
	        data: function() {
	            return {
	               	filestatData:{},
	               	filestat_loading:true
	            }
	        },
	        created: function() {
	            var self = this;
	            self.setIntervalEvent();
	        },
	        methods:{
	        	setIntervalEvent:function(){
	              	var self = this;
	              	self.filestat_loading = true;
	              	var inteditdata = setInterval(function(){
	                	var folderid = window.parent.$("#coursestatiframe").attr('folderid');
	                	var foldername = window.parent.$("#coursestatiframe").attr('foldername');
	                	if(folderid){
		                  	$.ajax({
		                    	type: "get",
		                    	url: "/troomv2/classsubject/fileCount.html",
		                    	dataType: "json",
		                    	data:{folderid:folderid},
		                    	success:function(res){
		                    		if(res.code == 0){
		                    			var datas = res.data;
		                    			self.filestatData = {
											courseNum : datas.courseNum,
											zan : datas.zan,
											creditNum : datas.creditNum,
											reNum : datas.reNum,
											cwcredit : datas.cwcredit,
											ltime : datas.ltime,
											maxtitle : datas.maxCredit.title,
											maxcwNum : datas.maxCredit.cwNum,
											mintitle : datas.minCredit.title,
											mincwNum : datas.minCredit.cwNum
										}
										var echartsArr = [];
										var legendArr = [];
										if(datas.zb){
											var zb = {value:datas.zb,name:'直播'};
											echartsArr.push(zb);
											legendArr.push('直播')
										}
										if(datas.other){
											var other = {value:datas.other,name:'其他'};
											echartsArr.push(other);
											legendArr.push('其他')
										}
										if(datas.flv){
											var flv = {value:datas.flv,name:'.flv'};
											echartsArr.push(flv);
											legendArr.push('.flv')
										}
										if(datas.doc){
											var doc = {value:datas.doc,name:'.doc'};
											echartsArr.push(doc);
											legendArr.push('.doc')
										}
										if(datas.ppt){
											var ppt = {value:datas.ppt,name:'.ppt'};
											echartsArr.push(ppt);
											legendArr.push('.ppt')
										}
										if(datas.pdf){
											var pdf = {value:datas.pdf,name:'.pdf'};
											echartsArr.push(pdf);
											legendArr.push('.pdf')
										}
										if(datas.mp4){
											var mp4 = {value:datas.mp4,name:'.mp4'};
											echartsArr.push(mp4);
											legendArr.push('.mp4')
										}
										if(datas.mp3){
											var mp3 = {value:datas.mp3,name:'.mp3'};
											echartsArr.push(mp3);
											legendArr.push('.mp3')
										}
										if(!echartsArr.length){
											echartsArr.push({value:0,name:'无课件'})
										}
										var echartsfilestat = echarts.init(self.$refs.echartsfilestat);
										echartsfilestat.setOption({
											title : {
										        text: foldername,
										        subtext: '文件统计',
										        x:'center'
										    },
										    tooltip : {
										        trigger: 'item',
										        formatter: "{a} <br/>{b} : {c} ({d}%)"
										    },
										    legend: {
										        orient: 'vertical',
										        left: 'left',
										        data: legendArr
										    },
										    series : [
										        {
										            name: '文件数',
										            type: 'pie',
										            radius : '55%',
										            center: ['50%', '60%'],
										            data:echartsArr,
										            itemStyle: {
										                emphasis: {
										                    shadowBlur: 10,
										                    shadowOffsetX: 0,
										                    shadowColor: 'rgba(0, 0, 0, 0.5)'
										                }
										            }
										        }
										    ]
										});
										self.filestat_loading = false;
		                    		}
		                    	}
		                  	})
	                  		clearInterval(inteditdata);
	                	}
	              	},500)
	            },
	            closeEvent:function(){
	            	var self = this;
	            	parent.window.H.get('coursestat').exec('close');
            		parent.window.$('#coursestatiframe').attr('folderid','');
            		parent.window.$('#coursestatiframe').attr('foldername','');
            		self.setIntervalEvent();
	            }
	        }
	    }) 
	    $(".nc_body").css('opacity',1);    
	</script>
</body>
</html>
