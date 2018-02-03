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
	      		height: 474px;
	      	}
	      	.nc_content .checked_tabs{
	      		width: 100%;
	      		height: 180px;
	      		border-bottom: 1px dashed #999;
	      	}
	      	.nc_content .havetabs{
	      		width: 100%;
	      		height: 180px;
	      		overflow-y: auto;
	      	}
	      	.nc_content .nocehckedTips{
	      		width: 100%;
	     		text-align: center;
	     		font-size: 14px;
	     		color: #48576a;
	     	}
	      	.nc_content .checked_tabs .el-tag--primary{
	      		margin: 5px;
	      	}
	      	.nc_content .tochoose{
	      		height: 300px;
	     	}
	      	.nc_content .tochoose .seachtool{
	      		height: 30px;
	      		padding: 13px 0;
	      	}
	      	.seachtool .seachtool_name{
	      		float: left;
	      		font-size: 14px;
	      		color: #333;
	      		line-height: 30px;
	      		margin-right: 10px;
	      	}
	      	.seachtool .el-input--small{
	      		float: left;
	      		width: 160px;
	      		margin-right: 10px;
	      	}
	      	.seachtool .seachtool_ser{
	      		float: left;
	      		margin-top: 1px;
	      	}
	     	.tochoose .tochoose_tabs{
	     		height: 244px;
	     		overflow-y: auto;
	     	}
	      	.tochoose .tochoose_tabs .el-checkbox{
	      		width: 31%;
			    margin: 0 8px 0 5px;
			    height: 23px;
			    display: block;
			    white-space: nowrap;
			    overflow: hidden;
			    text-overflow: ellipsis;
			    float: left;
	      	}
	    	.tochooseStu{
	    		height: 300px;
	    		border-bottom: 1px solid #d7d7d7;
	    	}
	    	.tochooseStu .classList{
	    		margin-top: 10px;
	    		float: left;
	    		width: 149px;
	    		height: 290px;
	    		overflow-y: auto;
	    		border-right: 1px solid #d7d7d7;
	    		list-style: none;
	    	}
	    	.tochooseStu .classList .stuli{
	    		width: 132px;
	    		height: 36px;
	    		line-height: 36px;
	    		text-indent: 20px;
	    		cursor: pointer;
	    		font-size: 14px;
	    		color: #333;
	    		overflow: hidden;
	    		text-overflow: ellipsis;
	    		white-space: nowrap;
	    	}
	    	.stuchecked{
	    		background: #F2F2F2;
	    	}
	    	.tochooseStu .stubox{
	    		width: 470px;
	    		height: 290px;
	    		margin-top: 10px;
	    		float: left;
	    	}
	    	.tochooseStu .stubox .stutochoose{
	    		width: 450px;
	    		height: 240px;
	    		overflow-y: auto;
	    		padding-left: 20px;
	    	}
	    	.tochooseStu .stubox .stutochoose .el-checkbox{
	    		width: 30%;
			    margin: 0 8px 0 0px;
			    height: 23px;
			    display: block;
			    white-space: nowrap;
			    overflow: hidden;
			    text-overflow: ellipsis;
			    float: left;
	    	}
	      	.nc_footer{
	      		height: 36px;
	      		padding-top: 20px;
	      	}
	 		.nc_footer .class_foot{
		 		width: 135px;
		 		height: 36px;
		 		padding-left: 485px;
	    	}
	   	</style>
	</head>
<body>     
    <div class="nc_body" id="appaddClass" style="opacity: 0">
	  	<div class="nc_head">
	    	<span class="nc_title">{{iframeTitle}}</span>
	    	<span class="nc_close" @click="closeEvent">×</span>
	  	</div>
      	<div class="nc_content">
      		<div class="checked_tabs">
	      		<div class="havetabs" v-if="checkedTabs.length">
	      			<el-tag v-if="plustype == 1" v-for="item in checkedTabs" :closable="true" type="primary" @close="handleClose(item)">
						{{item.classname}}
					</el-tag>
					<el-tag v-if="plustype == 2" v-for="item in checkedTabs" :closable="true" type="primary" @close="handleClosestu(item.uid)">
						{{item.realname?item.realname:item.username}}
					</el-tag>
					<el-tag v-if="plustype == 3" v-for="item in checkedTabs" :closable="true" type="primary" @close="handleClose(item)">
						{{item.realname}}
					</el-tag>
	      		</div>
      			<div class="nocehckedTips" v-if="!checkedTabs.length">{{nocehckedTips}}</div>
      		</div>
      		<div class="tochoose" v-if="plustype != 2">
      			<div class="seachtool">
      				<span class="seachtool_name">{{seachtoolname}}</span>
					<el-input :placeholder="placeholder" v-model="q" size="small"></el-input>
					<el-button class="seachtool_ser" size="small" @click="seachtool_ser">搜索</el-button>
				</div>
				<div class="tochoose_tabs">
					<el-checkbox-group v-model="checkedTabs" v-if="plustype == 1">
						<el-checkbox :disabled="item.hasperson == 0" v-for="item in classlist" :label="item">{{item.classname}}</el-checkbox>
					</el-checkbox-group>
					
					<el-checkbox-group v-model="checkedTabs" v-if="plustype == 3">
						<el-checkbox v-for="item in tealist" :label="item">{{item.realname}}</el-checkbox>
					</el-checkbox-group>
				</div>
      		</div>
      		<div class="tochooseStu" v-if="plustype == 2">
      			<ul class="classList"></ul>
      			<div class="stubox">
      				<div class="seachtool" style="height: 36px;margin-left: 20px;">
	      				<span class="seachtool_name">{{seachtoolname}}</span>
						<el-input :placeholder="placeholder" v-model="q" size="small"></el-input>
						<el-button class="seachtool_ser" size="small" @click="seachtool_ser">搜索</el-button>
					</div>
					<div class="stutochoose">
						<!--学生待选-->
						<el-checkbox-group v-model="stuTabs" @change="stuChange">
							<el-checkbox :disabled="item.permission == 0" v-for="item in stulist" :label="item">{{item.realname?item.realname:item.username}}</el-checkbox>
						</el-checkbox-group>
					</div>
      			</div>
      		</div>
      	</div>
	    <div class="nc_footer">
	      	<div class="class_foot">
	        	<el-button @click="closeEvent">取消</el-button>
	        	<el-button type="primary" @click="confirmEvent">确定</el-button>
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
	             	plustype:0,								//当前弹窗类型
	                iframeTitle:'报名',						//弹窗title
	               	seachtoolname:'班级列表',					//搜索工具中的描述	
	               	placeholder:'',							//搜索框placeholder
	               	q:'',									//搜索框关键字
	               	checkedTabs:[],							//已选中tabs	
	               	classlist:[],							//待选列表班级				
	               	tealist:[],								//待选列表教师
	               	stulist:[],								//待选列表学生
	               	stuTabs:[],								//学生选中
	               	listBackup:[],							//待选列表备份
	               	nocehckedTips:'还没设置任何任课教师',			//还未选中任何项时的提示语
	               	classid:'',
	               	//获取班级
	               	getClasses:function(){	
	               		var folderid = window.parent.$('#folderid').val();				
	               		var self = this;
	               		$.ajax({
	               			type:"post",
	               			url:"/troomv2/examv2/getTeacherClasses.html",
	               			async:true,
	               			data:{folderid:folderid},
	               			dataType:"json",
	               			success:function(data){
	               				self.classlist = data;
	               				self.listBackup = data;
	               				var $plustab_class = window.parent.$('.plustab_class');
	               				var checkedTabs = [];
				            	if($plustab_class.length > 0){
				            		for(var i=0,len=$plustab_class.length;i<len;i++){
										for(var j=0;j<data.length;j++){
											if($($plustab_class[i]).attr('classid') == data[j].classid){
												checkedTabs.push(data[j])
											}
										}
									}
				            		self.checkedTabs = checkedTabs;
				            	}
	               			}
	               		});
	               	},
	               	//获取学生弹窗中的班级列表
	               	getStudentClass:function(){
	               		var folderid = window.parent.$('#folderid').val();
	               		$(".classList").empty();
	               		var self = this;
	               		$.ajax({
	               			type:"post",
	               			url:"/troomv2/examv2/getTeacherClasses.html",
	               			async:true,
	               			data:{folderid:folderid},
	               			dataType:"json",
	               			success:function(data){
	               				var oLi = "";
	               				for(var i in data){
	               					if(data[i].hasperson == 1){
	               						oLi += '<li class="stuli" classid="'+data[i].classid+'" title="'+data[i].classname+'">'+data[i].classname+'</li>'
	               					}
	               				}
	               				$(".classList").append(oLi);
	               				$($(".stuli")[0]).addClass("stuchecked");
	               				//这里是第一次加载学生，默认第一个班级classid
	               				self.classid = $($(".stuli")[0]).attr("classid");
	               				self.getStudent();
	               				$(".stuli").on("click",function(){
	               					$(this).addClass("stuchecked");
	               					$(this).siblings().removeClass("stuchecked");
	               					self.classid = $(this).attr("classid");
	               					self.getStudent();
	               				});
	               			}
	               		});
	               	},
	               	//获取指定班级学生
	               	getStudent:function(){
	               		var folderid = window.parent.$('#folderid').val();
	               		var self = this;
	               		$.ajax({
	               			type:"get",
	               			url:"/troomv2/examv2/studentlist.html",
	               			dataType:"json",
	               			data:{folderid:folderid,classid:self.classid,q:self.q,pagesize:5000,pagenum:1},
	               			async:true,
	               			success:function(data){
	               				if(data.errCode == 0){
	               					var datas = data.datas.list;
	               					self.stulist = datas;
	               			
	               					self.stuTabs = [];
	               					for(var i = 0,len = self.checkedTabs.length; i < len; i++){//获得已经选中的状态
					                    var item = self.checkedTabs[i];
					                    for(var j = 0,lenj = self.stulist.length; j < lenj; j++){
					                      	var itemj = self.stulist[j];
					                      	if(item.uid == itemj.uid){
					                        	self.stuTabs.push(itemj);
					                      	}
					                    }                       
					                }
	               				}
	               			}
	               		});
	               	},
	               	//获取老师
	               	getTeacher:function(){
	               		var self = this;
	               		var folderid = window.parent.$('#folderid').val();
	               		let $plustab_class = window.parent.$('.plustab_class');
	               		var classidArr = [];
	               		for(var i=0;i<$plustab_class.length;i++){
	               			classidArr.push($($plustab_class[i]).attr('classid'))
	               		}
	               		$.ajax({
	               			type:"get",
	               			url:"/troomv2/examv2/teacherlist.html",
	               			async:true,
	               			data:{pagesize:5000,pagenum:1,classid:classidArr,folderid:folderid},
	               			dataType:"json",
	               			success:function(data){
	               				self.tealist = data.datas;
	               				self.listBackup = data.datas;
	               				var $plustabtea = window.parent.$('.plustabtea');
	               				var checkedTabs = [];
				            	if($plustabtea.length > 0){
				            		for(var i=0,len=$plustabtea.length;i<len;i++){
										for(var j=0;j<self.tealist.length;j++){
											if($($plustabtea[i]).attr('uid') == self.tealist[j].uid){
												checkedTabs.push(self.tealist[j])
											}
										}
									}
				            		self.checkedTabs = checkedTabs;
				            	}
	               			}
	               		});
	               	}
	            }
	        },
	        created: function() {
	            var self = this;
	            self.plustype = window.parent.$("#addclassifr").attr('plustype');
	            if(self.plustype == 1){
	            	self.iframeTitle = '选择班级';
	               	self.seachtoolname = '班级列表';
	               	self.nocehckedTips = '还没选择任何班级';
	               	self.placeholder = '请输入班级名称';
	            	self.getClasses();
	            }else if(self.plustype == 2){
	            	self.iframeTitle = '选择学生';
	               	self.seachtoolname = '学生列表';
	               	self.nocehckedTips = '还没选择任何学生';
	               	self.placeholder = '请输入学生姓名';
	               	self.checkedTabs =[];
	        		self.checkedTabs.push.apply(self.checkedTabs,window.parent.wTabs);
	            	self.getStudentClass();
	            }else if(self.plustype == 3){
	            	self.iframeTitle = '选择教师';
	               	self.seachtoolname = '教师列表';
	               	self.nocehckedTips = '还没选择任何教师';
	               	self.placeholder = '请输入教师姓名';
	               	self.getTeacher();
	            }
	        },
	        methods:{
	        	//搜索
	            seachtool_ser(){
	            	var self = this,lists = [];
	            	if(self.plustype == 1){
	            		if(self.q == ''){
							self.classlist =  self.listBackup;
							return;
						}
						for(var i=0;i<self.listBackup.length;i++){
							if(self.listBackup[i].classname.indexOf(self.q) >= 0){
				                lists.push(self.listBackup[i]);
				            }
						}
						self.classlist = lists;
	            	}else if(self.plustype == 2){
	            		self.getStudent();
	            	}else{
	            		if(self.q == ''){
							self.tealist =  self.listBackup;
							return;
						}
						for(var i=0;i<self.listBackup.length;i++){
							if(self.listBackup[i].realname.indexOf(self.q) >= 0){
				                lists.push(self.listBackup[i]);
				            }
						}
						self.tealist = lists;
	            	}
	            },
	            //弹窗层确认
	            confirmEvent:function(){
	            	var self = this;
	            	if(self.plustype == 1){
	            		window.parent.$('.plusclassbox').empty();
		            	var onetab = "";
		            	for(var i in self.checkedTabs){
		            		onetab += '<li class="plustab plustab_class" classname='+self.checkedTabs[i].classname+' classid='+self.checkedTabs[i].classid+'>'
							onetab += '<span class="plustabclass">'+self.checkedTabs[i].classname+'</span>'
							onetab += '<span class="plusdel">x</span>'
							onetab += '</li>'
		            	}
		            	window.parent.$('.plusclassbox').append(onetab);
		            	
		            	window.parent.$("#haveteacher").hide();
						window.parent.$(".plustabteabox").empty();
	            	}else if(self.plustype == 2){
	            		window.parent.$('.plusstubox').empty();
	            		window.parent.wTabs = self.checkedTabs;
		            	var onetab = "";
		            	for(var i in self.checkedTabs){
		            		var item = self.checkedTabs[i],
		            		 	name = item.realname?item.realname:item.username;
		            		onetab += '<li class="plustab plustab_stu" uid='+item.uid+'>'
							onetab += '<span class="plustabclass">'+name+'</span>'
							onetab += '<span class="plusdel">x</span>'
							onetab += '</li>'
		            	}
		            	window.parent.$('.plusstubox').append(onetab);
	            	}else{
	            		window.parent.$('.plustabteabox').empty();
		            	var onespan = "";
		            	for(var i in self.checkedTabs){
		            		onespan += '<span uid="'+self.checkedTabs[i].uid+'" class="plustabtea">'+self.checkedTabs[i].realname+'</span>'
		            	}
		            	window.parent.$('.plustabteabox').append(onespan);
		            	if(onespan != ""){
		            		window.parent.$('#haveteacher').show();
		            	}else{
		            		window.parent.$('#haveteacher').hide();
		            	}
	            	}
	            	window.parent.H.get('addclass').exec('close');
	            	window.parent.$("#addclassifr").remove();
	            },
	            closeEvent:function(){
	            	var self = this;
	            	window.parent.H.get('addclass').exec('close');
	            	window.parent.$("#addclassifr").remove();
	            },    
	            handleClosestu(id) {
	            	var self = this;
			        for(var i = 0,len = self.checkedTabs.length; i < len; i++ ){
			            var item = self.checkedTabs[i];
			            if(item.uid == id){
			              self.checkedTabs.splice(i,1);
			              break;
			            }
			        }
			        for(var j = 0,lenj = self.stuTabs.length; j < lenj; j++){
			            var item = self.stuTabs[j];
			            if(item.uid == id){                          
			              	self.stuTabs.splice(j,1);
			              	break;
			            }
			        }
				},
				handleClose(tag){
					var self = this;
					self.checkedTabs.splice(self.checkedTabs.indexOf(tag), 1);
				},
				stuChange(value){
					var self = this,          
			        dataArr = [];
			        for(var i = 0,len = self.stulist.length; i < len; i++){
			          	var item = self.stulist[i],
			             	indexs= [];
			          	for(var j = 0,lenj = self.checkedTabs.length; j < lenj; j++ ){
			            	var itemj = self.checkedTabs[j];            
			            	if(item.uid == itemj.uid){
			              		indexs.push(j);
			            	}
			          	}
			          	for(var s = indexs.length-1; s >=0 ; s--){
			            	self.checkedTabs.splice(indexs[s],1);
			          	}
			        }         
			        self.checkedTabs.push.apply(self.checkedTabs,value);
				}
	        }
	    }) 
	    $(".nc_body").css('opacity',1);    
	</script>
</body>
</html>
