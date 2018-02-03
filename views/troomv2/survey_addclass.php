<!DOCTYPE html>
<html lang="en">
	<head>
  		<meta charset="UTF-8">
  		<title>Document</title>
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css">
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css"> 
	   	<style>
		  	*{
		    	margin: 0;
		    	padding: 0;
		    	font-family: 'Microsoft YaHei';
		  	}
	      	.nc_body{
	        	width: 620px;
	        	height: 570px;
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
	      		height: 534px;
	      	}
	      	
	      	.nc_content .checked_tabs{
	      		width: 618px;
	      		height: 180px;
	      		border: 1px solid #ccc;
	      	}
	      	.nc_content .havetabs{
	      		width: 598px;
	      		height: 170px;
	      		overflow-y: auto;
	      		padding: 5px 10px;
	      	}
	      	.havetabs .el-tag--primary{
	      		margin: 5px;
	      		color: #fff;
	      	}
	      	.nc_content .nocehckedTips{
	      		width: 100%;
	     		text-align: center;
	     		font-size: 14px;
	     		color: #48576a;
	     	}
	     	
	      	.nc_content .checking_tabs{
	      		width: 100%;
	      		height: 342px;
	      		margin-top: 10px;
	      	}
	      	.checking_tabs .grade_ul{
	      		float: left;
	      		width: 178px;
	      		height: 340px;
	      		margin-right: 10px;
	      		border: 1px solid #ccc;
	      	}
	      	.grade_ul li{
	      		width: 100%;
	      		height: 34px;
	      		line-height: 34px;
	      		list-style: none;
	      		text-align: center;
	      		color: #333;
	      		font-size: 14px;
	      		cursor: pointer;
	      	}
	      	.bgcF9{
	      		background: #f9f9f9;
	      	}
	      	.checking_tabs .class_box{
	      		float: left;
	      		width: 430px;
	      		height: 342px;
	      	}
	      	.class_box .search_box{
	      		width: 100%;
	      		height: 30px;
	      		margin-bottom: 10px;
	      	}
	      	.search_box .el-input--small{
	      		float: left;
	      		width: 200px;
	      		margin-right: 10px;
	      	}
	      	.search_box .seachtool_ser{
	      		float: left;
	      		margin-top: 1px;
	      	}
	      	.checking_tabs .class_detail {
	      		width: 410px;
	      		height: 230px;
	      		padding: 10px;
	      		border: 1px solid #ccc;
	      		margin-bottom: 10px;
	      	}
	      	.class_detail .el-checkbox{
	      		width: 30%;
			    margin: 0 5px 5px 5px;
			    height: 23px;
			    display: block;
			    white-space: nowrap;
			    overflow: hidden;
			    text-overflow: ellipsis;
			    float: left;
	      	}
	      	.checking_tabs .nc_footer{
	      		height: 35px;
	      		padding-top: 5px;
	      	}
	        .nc_footer .el-checkbox{
	        	float: left;
	        }
	        .nc_footer .el-button--primary{
	        	float: right;
	        }
	        .noClass{
	        	background: url(http://static.ebanhui.com/ebh/tpl/2016/images/nodata1.png) no-repeat center;
	        }
	   	</style>
	</head>
<body>
    <div class="nc_body" id="appaddClass" style="opacity: 0">
	  	<div class="nc_head">
	    	<span class="nc_title">选择班级/年级</span>
	    	<span class="nc_close" @click="closeEvent">×</span>
	  	</div>
      	<div class="nc_content">
      		<div class="checked_tabs">
	      		<div class="havetabs noClass">
	      			<el-tag v-for="item in checkedTabs_all" color="#F39800" :closable="true" type="primary" @close="handleCloseall(item)">
						{{item.name}}
					</el-tag>
					<el-tag v-for="item in checkedTabs" color="#AFC44B" :closable="true" type="primary" @close="handleClose(item)">
						{{item.classname}}
					</el-tag>
	      		</div>
      		</div>
      		<div class="checking_tabs">
      			<ul class="grade_ul"></ul>
      			<div class="class_box">
      				<div class="search_box">
      					<el-input placeholder="请输入班级名称" @change="seachtool_ser" v-model="k" size="small"></el-input>
						<el-button class="seachtool_ser" type="primary" size="small" @click="seachtool_ser">搜索</el-button>
      				</div>
      				<div class="class_detail" v-loading="class_loading" element-loading-text="拼命加载中">
      					<el-checkbox-group v-model="classTabs" @change="classChange">
							<el-checkbox
								v-for="item in classlist" 
								:label="item">
									{{item.classname}}
							</el-checkbox>
						</el-checkbox-group>
      				</div>
      				<div class="nc_footer">
      					<el-checkbox :disabled="noallchecked" v-model="allchecked" @change="checkAll">全选</el-checkbox>
      					<el-button type="primary" @click="confirmEvent">确定</el-button>
      				</div>
      			</div>
      		</div>
      	</div>
    </div>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/vue/vue.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/index.js"></script>
	<script>    
	    var addClassorstu = new Vue({
	        el: '#appaddClass',
	        data: function() {
	            return {
	            	roominfo: '<?=$roominfo["grade"]?>',
	            	
	               	k:'',									//搜索框关键字
	               	
	               	checkedTabs_all:[],
	               	nowgradename:'',						//当前选中的年级名字
	               	nowgradecode:'',						
	               	
	               	checkedTabs:[],							//已选中tabs
	               	classlist:[],							//待选班级列表
	               	classlistclone:[],
	               	classTabs:[],							//班级选中
	               	class_loading: true,
	               	
	              	checkedTabscache:{},					//数据暂存
	              	noallchecked: false,					//是否禁用全选
	               	allchecked: false,						//当前是否全选
	               	getClasses:function(grade,type){			
	               		var self = this;
	               		self.class_loading = true;
	               		self.classTabs = [];
	               		self.classlistclone = [];
	               		self.classlist = [];
	               		self.k = '';
	               		if(type == '1'){
       						if(window.parent.cacheTabs && window.parent.cacheTabs != {}){
       							self.checkedTabscache = window.parent.cacheTabs
       						}
       						var gradeli = window.parent.$(".gradeli");
       						for(var i=0;i<gradeli.length;i++){
       							var allname = {
									name: $(gradeli[i]).find(".tabliname").html(),
									grade: $(gradeli[i]).attr('grade')
								}
								self.checkedTabs_all.push(allname);
       						}
       						var classli = window.parent.$(".classli");
       						for(var i=0;i<classli.length;i++){
       							var onename = {
       								classname: $(classli[i]).find(".tabliname").html(),
									classid: $(classli[i]).attr('classid')
       							}
       							self.checkedTabs.push(onename)
       						}
       					}
	               		var alchecked = self.checkedTabscache[grade];
	               		$.ajax({
	               			type:"post",
	               			url:"/troomv2/survey/getroomlist.html",
	               			async:true,
	               			data:{k:self.k,grade:grade},
	               			dataType:"json",
	               			success:function(data){
	               				if(data.code == 0){
	               					var datas = data.data
	               					
	               					if(datas.length){
	               						$('.class_detail').removeClass("noClass");
	               						self.classlist = datas;
	               						self.classlistclone = datas;
										if(alchecked != undefined){
											for(var i = 0,len = alchecked.length; i < len; i++){
							                    var itemi = alchecked[i];
							                    for(var j = 0,lenj = self.classlist.length; j < lenj; j++){
							                      	var itemj = self.classlist[j];
							                      	if(itemi.classid == itemj.classid){
							                        	self.classTabs.push(itemj);
							                      	}
							                    }                       
							               }
										}
										
										if(self.classTabs.length == self.classlist.length){
											self.allchecked = true;
										}else{
											self.allchecked = false;
										}
										self.noallchecked = false;
	               					}else{
	               						$('.class_detail').addClass("noClass");
	               						self.allchecked = false;
	               						self.noallchecked = true;//禁用全选
	               					}
	               					self.class_loading = false;
	               				}else{
	               					console.log("接口返回错误")
	               				}
	               			}
	               		});
	               	}
	            }
	        },
	        created: function() {
	            var self = this,
	        		oLi = "";
	        	switch (self.roominfo){
	        		case 1:
	        			oLi = oLi + "<li class='gradeli bgcF9' grade='1'>一年级</li>"
	        					  + "<li class='gradeli' grade='2'>二年级</li>"
	        				      + "<li class='gradeli' grade='3'>三年级</li>"
	        				      + "<li class='gradeli' grade='4'>四年级</li>"
	        				      + "<li class='gradeli' grade='5'>五年级</li>"
	        				      + "<li class='gradeli' grade='6'>六年级</li>";
	        			self.nowgradename = "一年级";
	        			self.nowgradecode = '1';
	        			self.getClasses(1,'1');
	        			break;
	        		case 7:
	        			oLi = oLi + "<li class='gradeli bgcF9' grade='7'>初一</li>"
	        					  + "<li class='gradeli' grade='8'>初二</li>"
	        				      + "<li class='gradeli' grade='9'>初三</li>";
	        			self.nowgradename = "初一";
	        			self.nowgradecode = '7';
	        			self.getClasses(7,'1');
	        			break;
	        		case 9:
	        			oLi = oLi + "<li class='gradeli bgcF9' grade='1'>一年级</li>"
	        					  + "<li class='gradeli' grade='2'>二年级</li>"
	        				      + "<li class='gradeli' grade='3'>三年级</li>"
	        				      + "<li class='gradeli' grade='4'>四年级</li>"
	        				      + "<li class='gradeli' grade='5'>五年级</li>"
	        				      + "<li class='gradeli' grade='6'>六年级</li>"
	        				      + "<li class='gradeli' grade='7'>初一</li>"
	        				      + "<li class='gradeli' grade='8'>初二</li>"
	        				      + "<li class='gradeli' grade='9'>初三</li>";
	        			self.nowgradename = "一年级";
	        			self.nowgradecode = '1';
	        			self.getClasses(1,'1');
	        			break;
	        		default:
	        			oLi = oLi + "<li class='gradeli bgcF9' grade='10'>高一</li>"
	        					  + "<li class='gradeli' grade='11'>高二</li>"
	        				      + "<li class='gradeli' grade='12'>高三</li>";
	        			self.nowgradename = "高一";
	        			self.nowgradecode = '10';
	        			self.getClasses(10,'1');
	        	}
	        	$(".grade_ul").empty().append(oLi);
	        	self.$nextTick( () => {
		        	$(".gradeli").on("click",function(){
		        		if(!$(this).hasClass("bgcF9")){
		        			$(this).addClass("bgcF9");
		        			$(this).siblings().removeClass("bgcF9");
		        			self.getClasses($(this).attr('grade'),'0');
		        			self.nowgradename = $(this).html();
		        			self.nowgradecode = $(this).attr('grade');
		        		}
		        	});
		        });
	        },
	        methods:{
	        	//搜索
	            seachtool_ser(){
	            	var self = this,arr = [];  
		            for(var i = 0,len = self.classlistclone.length;i < len; i++){
		                var itemi = self.classlistclone[i];               
		                if(itemi.classname.indexOf(self.k) > -1){
		                  	arr.push(itemi);
		                }
		            }
		            if(!arr.length){
		            	$('.class_detail').addClass("noClass");
		            }else{
		            	$('.class_detail').removeClass("noClass");
		            }
              		self.classlist = arr;
	            },
	            closeEvent(){
	            	var self = this;
	            	window.parent.H.get('addclass_dialog').exec('close');
	            	window.parent.$("#addclassifr").remove();
	            },
				classChange(val){//下tab选择函数
					var self = this;
					//如果下tab选中的长度等于列表的长度，表示全部选中
					if(self.classTabs.length == self.classlistclone.length){
						self.allchecked = true;
						//添加全选标签
						var allname = {
							name: self.nowgradename,
							grade: self.nowgradecode
						}
						self.checkedTabs_all.push(allname);
						//去除单一标签
						for(var i=0;i<self.classlistclone.length;i++){
							var itemi = self.classlistclone[i];
							for(var j=0;j<self.checkedTabs.length;j++){
								var itemj = self.checkedTabs[j];
								if(itemi.classid == itemj.classid){
									self.checkedTabs.splice(j,1);
								}
							}
						}
					}else{
						self.allchecked = false;
						//移除当相应的总和标签
						for(var i=0;i<self.checkedTabs_all.length;i++){
							var itemi = self.checkedTabs_all[i];
							if(self.nowgradecode == itemi.grade){
								self.checkedTabs_all.splice(i,1)
							}
						}
						//去重并添加到单一标签
						for(var i = 0,len = self.classlistclone.length; i < len; i++){
			          		var item = self.classlistclone[i],indexs= [];
				          	for(var j = 0,lenj = self.checkedTabs.length; j < lenj; j++ ){
				            	var itemj = self.checkedTabs[j];
				            	if(item.classid == itemj.classid){
				              		indexs.push(j);
				            	}
				          	}
				          	for(var s = indexs.length-1; s >=0 ; s--){
				            	self.checkedTabs.splice(indexs[s],1);
				          	}
				        }         
				        self.checkedTabs.push.apply(self.checkedTabs,val);
					}
					//添加到缓存
					self.checkedTabscache[self.nowgradecode] = val;
					//判断是否为空显示缺省图
			       	if(self.checkedTabs.length || self.checkedTabs_all.length){
			        	$(".havetabs").removeClass("noClass");
			        }else{
			        	$(".havetabs").addClass("noClass");
			        }
				},
				handleCloseall(obj){//总和标签关闭函数
	            	var self = this;
	            	//移除当前相应总和标签
			        for(var i = 0,len = self.checkedTabs_all.length; i < len; i++ ){
			            var itemi = self.checkedTabs_all[i];
			            if(itemi.name == obj.name){
			              self.checkedTabs_all.splice(i,1);
			              break;
			            }
			        }
			        //如果当前显示的就是移除的总和标签则将显示选中取消，并将全选取消
			        if(self.nowgradecode == obj.grade){ 
			        	self.classTabs = [];
			        	self.allchecked = false;
			        }
			        //更新缓存对象
					self.checkedTabscache[obj.grade] = [];	
					//判断是否为空显示缺省图
			        if(self.checkedTabs.length || self.checkedTabs_all.length){
			        	$(".havetabs").removeClass("noClass");
			        }else{
			        	$(".havetabs").addClass("noClass");
			        }
	            },
	            handleClose(obj) {//单一标签关闭函数
	            	var self = this;
	            	//删除相应单一标签
			        for(var i = 0,len = self.checkedTabs.length; i < len; i++ ){
			            var itemi = self.checkedTabs[i];
			            if(itemi.classid == obj.classid){
			              self.checkedTabs.splice(i,1);
			              break;
			            }
			        }
			        //并且同步删除下tab选中的标签
			        for(var j = 0,lenj = self.classTabs.length; j < lenj; j++){
			            var itemj = self.classTabs[j];
			            if(itemj.classid == obj.classid){                          
			              	self.classTabs.splice(j,1);
			              	break;
			            }
			        }
			        //更新缓存对象
			        for(var i in self.checkedTabscache[obj.grade]){
						if(obj.classid == self.checkedTabscache[obj.grade][i].classid){
							self.checkedTabscache[obj.grade].splice(i,1);
							break;
						}
					}
			        //判断是否为空显示缺省图
			        if(self.checkedTabs.length || self.checkedTabs_all.length){
			        	$(".havetabs").removeClass("noClass");
			        }else{
			        	$(".havetabs").addClass("noClass");
			        }
				},
				checkAll(){//全选
					var self = this;
					if(self.allchecked){
						//当点击全选选中时，当前下tab全部选中
						self.classTabs = self.classlistclone;
						var allname = { //生成总和标签
							name: self.nowgradename,
							grade: self.nowgradecode
						}
						self.checkedTabs_all.push(allname);
						//移除单一标签
						for(var i=0,leni=self.classTabs.length;i<leni;i++){
							var itemi = self.classTabs[i];
							for(var j = 0,lenj = self.checkedTabs.length; j < lenj; j++ ){
					            var itemj = self.checkedTabs[j];
					            if(itemi.classid == itemj.classid){
					              self.checkedTabs.splice(j,1);
					              break;
					            }
					        }
						}
					}else{
						self.classTabs = [];//清空当前下tab选中
						//移除相应总和标签
						for(var i = 0,len = self.checkedTabs_all.length; i < len; i++ ){
				            var item = self.checkedTabs_all[i];
				            if(item.name == self.nowgradename){
				              self.checkedTabs_all.splice(i,1);
				              break;
				            }
				        }
					}
					//缓存对象更新
					self.checkedTabscache[self.nowgradecode] = self.classTabs;
					//判断是否为空显示缺省图
					if(self.checkedTabs.length || self.checkedTabs_all.length){
			        	$(".havetabs").removeClass("noClass");
			        }else{
			        	$(".havetabs").addClass("noClass");
			        }
				},
				confirmEvent(){//弹窗层确认
	            	var self = this;
	            	var confirmarr = [];
					var classids = [];
					var onetab = "";
					window.parent.$('.classlist_ul').empty();
					if(self.checkedTabs_all.length){
		            	jQuery.each(self.checkedTabscache, function(i, val) {
							var temp = true;
							for(var j=0;lenj=self.checkedTabs_all.length,j<lenj;j++){
		            			var itemj = self.checkedTabs_all[j];
		            			if(i == itemj.grade){
		            				temp = false;
		            				break;
		            			}
		            		}
							if(temp){
								confirmarr.push(self.checkedTabscache[i])
							}
						});
						for(var i in self.checkedTabs_all){
		            		var item = self.checkedTabs_all[i];
		            		onetab += '<li class="gradeli colF39800" grade='+item.grade+'>'
		            		onetab += '<span class="tabliname" title="'+item.name+'">'+item.name+'</span>'
							onetab += '<span class="delLi colF39800">x</span></li>'
		            	}
					}else{
						jQuery.each(self.checkedTabscache, function(i, val) {
							confirmarr.push(self.checkedTabscache[i]);
						});
					}
            		for(var j in confirmarr){
	            		for(var k in confirmarr[j]){
	            			var itemk = confirmarr[j][k];
	            			onetab += '<li class="classli colAFC44B" grade='+itemk.grade+' classid='+itemk.classid+'>'
	            			onetab += '<span class="tabliname" title="'+itemk.classname+'">'+itemk.classname+'</span>'
							onetab += '<span class="delLi colAFC44B">x</span></li>'
	            		}
	            	}
	            	window.parent.$('.classlist_ul').append(onetab);
	            	window.parent.cacheTabs = self.checkedTabscache;
	            	window.parent.H.get('addclass_dialog').exec('close');
	            	window.parent.$("#addclassifr").remove();
	            }
	        }
	    }) 
	    $(".nc_body").css('opacity',1);    
	</script>
</body>
</html>
