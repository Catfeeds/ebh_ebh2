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
	      	.nc_content .nodata{
	      		background: url(http://static.ebanhui.com/ebh/tpl/2016/images/nodata.png) no-repeat center;
			    min-height: 460px;
			    min-width: 300px;
			    width: 100%;
	      	}
	      	.nc_content .imgbox{
				float: left;
				width: 40px;
				height: 40px;
				overflow: hidden;
				padding: 5px 0;
				overflow: hidden;
				margin-left: 10px;
				margin-right: 5px;
			}
			.nc_content .imgbox img{
				width: 40px;
				height: 40px;
				float: left;
				margin: 0 !important;
				border-radius: 50%;
			}
			.nc_content .usernamebox{
				width: 100px;
				height: 40px;
				float: left;
			}
			.nc_content p{
				margin: 0;
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
    <div class="nc_body" id="appaddRank" style="opacity: 0">
	  	<div class="nc_head">
	    	<span class="nc_title">学习排名</span>
	    	<span class="nc_close" @click="closeEvent">×</span>
	  	</div>
      	<div class="nc_content" v-loading="studyrank_loading" element-loading-text="拼命加载中...">
      		<el-table :data="studyrankData" stripe highlight-current-row style="width: 100%;" height="501" :default-sort="{prop: 'data'}" @sort-change="sortchange">
				<!--<div class="nodata" v-if="ifstudyrank" slot="empty"></div>
				<div v-if="!ifstudyrank" slot="empty"></div>-->
				<el-table-column label="学习账号" width="200" show-overflow-tooltip>
					<template scope="scope">
						<span class="imgbox">
							<img :src="scope.row.face" v-if="scope.row.face!=''" >
		                    <img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg" v-else-if="scope.row.sex=='0'" >
		                    <img src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg" v-else-if="scope.row.sex=='1'" >
						</span> 
						<div class="usernamebox">
							<div>
								<span style="float: left;max-width: 80px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" class="singleinterception" :title="scope.row.realname">{{scope.row.realname}}</span>
								<span style="float: left;" v-if = "scope.row.sex === '1'"><i class="icon iconfont icon-ttpodicon" style="float: left;"></i></span>
	            				<span style="float: left;" v-else><i class="icon iconfont icon-shouyezhuyetubiao06" style="float: left;"></i></span>
							</div>
							<br />
							<div style="width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" :title="scope.row.username">{{scope.row.username}}</div> 
						</div>
					</template>
				</el-table-column>
				<el-table-column label="所在班级" width="150">
					<template scope="scope">
						<p>{{scope.row.classname}}</p>
					</template>
				</el-table-column>
				<el-table-column label="注册时间" width="120">
					<template scope="scope">
						<p>{{scope.row.dateline != 0?new Date(scope.row.dateline*1000).getFullYear()+'-'+(new Date(scope.row.dateline*1000).getMonth()+1)+'-'+new Date(scope.row.dateline*1000).getDate():"---"}}</p>
			      		<p v-if="scope.row.dateline != 0">{{new Date(scope.row.dateline*1000).getHours()+':'+new Date(scope.row.dateline*1000).getMinutes()+':'+new Date(scope.row.dateline*1000).getSeconds()}}</p>
					</template>
				</el-table-column>
				<el-table-column label="注册地" width="150">
					<template scope="scope">
						<p>{{scope.row.province}}-{{scope.row.city}}</p>
			      		<p>{{scope.row.ip}}</p>
					</template>
				</el-table-column>
				<el-table-column label="积分" width="110" prop="credit" sortable="custom">
					<template scope="scope">
						<p>{{scope.row.credit}}</p>
					</template>
				</el-table-column>
				<el-table-column label="学分" width="110" prop="score" sortable="custom">
					<template scope="scope">
						<p>{{scope.row.score}}</p>
					</template>
				</el-table-column>
				<el-table-column label="学时" prop="ltime" sortable="custom">
					<template scope="scope">
						<p>{{scope.row.ltime}}</p>
					</template>
				</el-table-column>
			</el-table>
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
	<script>    
	    var addClassrank = new Vue({
	        el: '#appaddRank',
	        data: function() {
	            return {
	               	studyrankData:[],
	               	ifstudyrank:false,
	               	rankfolderid:"",
	               	rankorderBy:0,
	               	studyrank_loading:true
	            }
	        },
	        created: function() {
	            var self = this;
	            self.setIntervalEvent();
	        },
	        methods:{
	        	setIntervalEvent:function(){
	              	var self = this;
	              	self.studyrank_loading = true;
	              	var inteditdata = setInterval(function(){
	                	self.rankfolderid = window.parent.$("#courserankiframe").attr('folderid');
	                	if(self.rankfolderid){
		                  	$.ajax({
		                    	type: "get",
		                    	url: "/troomv2/classsubject/studentRanking.html",
		                    	dataType: "json",
		                    	data:{folderid:self.rankfolderid,orderBy:self.rankorderBy},
		                    	success:function(res){
		                    		if(res.code == 0){
		                    			var datas = res.data;
		                    			self.studyrankData = datas.list;
		                    			self.ifstudyrank = true;
		                    			self.studyrank_loading = false;
		                    		}
		                    	}
		                  	})
	                  		clearInterval(inteditdata);
	                	}
	              	},500)
	            },
	            closeEvent:function(){
	            	var self = this;
	            	parent.window.H.get('courserank').exec('close');
            		parent.window.$('#courserankiframe').attr('folderid','');
            		self.setIntervalEvent();
	            },
	            sortchange(obj){
	            	var self = this;
		        	if(obj.prop == "credit"){
		        		if(obj.order == "descending"){
		        			self.rankorderBy = 1;
		        		}else if(obj.order == "ascending"){
		        			self.rankorderBy = 2;
		        		}else{
		        			self.rankorderBy = 0;
		        		}
		        	}else if(obj.prop == "score"){
		        		if(obj.order == "descending"){
		        			self.rankorderBy = 3;
		        		}else if(obj.order == "ascending"){
		        			self.rankorderBy = 4;
		        		}else{
		        			self.rankorderBy = 0;
		        		}
		        	}else{
		        		if(obj.order == "descending"){
		        			self.rankorderBy = 5;
		        		}else if(obj.order == "ascending"){
		        			self.rankorderBy = 6;
		        		}else{
		        			self.rankorderBy = 0;
		        		}
		        	}
		        	self.studyrank_loading = true;
		        	$.ajax({
                    	type: "get",
                    	url: "/troomv2/classsubject/studentRanking.html",
                    	dataType: "json",
                    	data:{folderid:self.rankfolderid,orderBy:self.rankorderBy},
                    	success:function(res){
                    		if(res.code == 0){
                    			var datas = res.data;
                    			self.studyrankData = datas.list;
                    			self.ifstudyrank = true;
                    			self.studyrank_loading = false;
                    		}
                    	}
                  	})
	            }
	        }
	    }) 
	    $(".nc_body").css('opacity',1);    
	</script>
</body>
</html>
