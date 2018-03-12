<!DOCTYPE html>
<html lang="en">
	<head>
  		<meta charset="UTF-8">
  		<title>Document</title>
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css">
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css"> 
   		<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/xtree/iconfont.css" />
	   	<style>
		  	*{
		    	margin: 0;
		    	padding: 0;
		    	font-family: 'Microsoft YaHei';
		  	}
	      	.nc_body{
	        	width: 960px;
	        	height: 620px;
	        	padding: 20px;
	        	overflow: hidden;
	       	 	font-family: 'Microsoft YaHei';
	      	}
	      	.nc_head{
	        	height: 36px;
	      	}
	      	.nc_head .nc_title{
	        	float: left;
	        	font-size: 16px;
	        	font-weight: 600;
	       		font-family: 'Microsoft YaHei';
	      	}
	      	.nc_head .nc_num{
	      		float: left;
	      		font-size: 14px;
	      		margin-left: 15px;
	      		line-height: 24px;
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
	      	.nc_checked{
	      		height: 120px;
    			border: 1px solid #bfcbd9;
   				border-radius: 4px;
   				overflow-y: auto;
	      	}
	      	.nc_checked .el-tag{
			    margin: 5px 0 0 5px;
			}
	     	.nc_content{
	      		height: 452px;
	      		padding-top: 10px;
	      	}
	      	.nc_content .leftTreeCourseClass{
	      		float: left;
			    margin: 0 10px 0 0;
			    padding: 0 10px;
			    width: 180px;
			    height: 450px;
			    overflow:auto;
			    border-radius: 2px;
			    border: 1px solid #bfcbd9;
	      	}
	      	.nc_content .leftTreeCourseClass span{
		      	cursor: pointer;
		    }
	      	.img-section{ 
		       margin-left: 4px;
		       margin-top: 5px; 
		    }
		    .img-organize{       
		       margin-top: 5px; 
		    }    
		    .organize .icon-sanjiao-close,.organize .icon-sanjiao-open{  
		        margin-left: 0;
		        cursor: pointer;
		    }
		    .organize{      
		        padding: 10px 0 10px 10px;
		    }
		    .organize ul{
		        padding: 0;
		        margin: 0;
		        padding-left: 20px;
		        box-sizing:border-box;
		        -moz-box-sizing:border-box; 
		        -webkit-box-sizing:border-box; 
		    }
		    .organize li{       
		        list-style-type: none;       
		        line-height: 20px;
		        font-size: 14px;
		        margin: 5px 0;       
		    }
		    .organize li .tr{
		      position: relative;
		      line-height: 30px;
		      white-space: nowrap;
		    }
		    .organize li .tr>i.iconfont{
		      margin-left: 5px;
		    }
		    .organize li .tr:hover{
		      background-color: #eef1f6;
		      cursor: default;
		    }
		    .organize li .tr:hover .td{
		      background-color: #eef1f6;
		    }
		    .organize span{
		        display: inline-block;
		        height: 30px; 
		        line-height: 30px;      
		        margin-left: 4px;      
		    }  
		    .organize i{
		        float: left;
		        height: 20px;
		        width: 20px; 
		    }   
     		.organize i.iconfont{
       			margin-left:6px;
     		}
	      	
	      	.nc_content .rightcontent{
	      		float: left;
	      		width: 748px;
	      		height: 452px;
	      	}
	      	.rightcontent .rightClassListSearchBox{
			    height: 36px;
			    width: 748px;
	      	}
	      	.rightClassListSearchBox .el-input{
	      		float: left;
	      		width: 258px;
	      		line-height: 36px;
	      	}
	      	.rightClassListSearchBox .el-button--primary{
	      		float: left;
	      		margin-left: 10px;
	      	}
	      	
	      	.rightcontent .rightClassList{
			    width: 746px;
			    height: 404px;    
			    border-radius: 2px; 
			    border: 1px solid #bfcbd9;
			    margin-top: 10px;
	      	}
	      	.rightClassList .classListBox{
			    width: 746px;
			    height: 347px;
			    overflow-y:auto;
			    border-bottom: 1px solid #bfcbd9;
	      	}
	      	.classListBox .courseLibox{
			    float: left;
			    width: 120px;
			    height: 100px;
			    margin-right: 3px;
			}
	      	.classListBox .courseLibox img{
		    	margin: 5px auto;
		    	display:block;
		    	width: 114px;
		    	height: 68px;
		  	}
		  	.classListBox .courseLibox .el-checkbox__input{
		    	float: left;
		    	display: block;
		    	margin-left: 5px;   
		    	width: 18px;
		    	height: 18px;
		  	}
		  	.classListBox .courseLibox .el-checkbox__label{
		    	float: left;
		    	display: block;
		    	width: 90px;
		    	overflow: hidden;
		    	text-overflow: ellipsis;
		    	white-space: nowrap;
		    	height: 18px;
		    	line-height: 18px;
		  	}
	      	.rightClassList .nc_footer{
	      		height: 36px;
	      		margin-top: 10px;
	      	}
	      	.nc_footer .allselect{
	      		width: 75px;
	      		float: left;
	      		margin: 7px 510px 0 15px;
	      	}
	      	.nc_footer .el-button{
	        	float: left;
	        }
	        
	        
	        .noClass{
	        	background: url(http://static.ebanhui.com/ebh/tpl/2016/images/nodata1.png) no-repeat center;
	        }
	        
	        .selecrCenter{
			    background-color: rgba(32,160,255,.3);
			}
	   	</style>
	</head>
<body>
    <div class="nc_body" id="appaddClass" style="opacity: 0">
	  	<div class="nc_head">
	    	<span class="nc_title">选择课程</span>
	    	<span class="nc_num">已选择( <span style="color:red">{{checkedCoursesPackage.length}}</span> )</span>
	    	<span class="nc_close" @click="closeEvent">×</span>
	  	</div>
      	<div class="nc_checked">    
	        <el-tag v-for="(tag,item) in checkedCoursesPackage" :closable="true" type="primary" @close="handleCloseTag(tag.folderid)">
	          {{tag.foldername}}
	        </el-tag>
      	</div>
      	<div class="nc_content">
      		<div class="leftTreeCourseClass organize">
      			
      		</div>
      		<div class="rightcontent">
      			<div class="rightClassListSearchBox">
			        <el-input class="searchInput"
			        	icon="circle-close" 
			        	v-model="searchvalue" 
			        	placeholder="请输入关键字"
			        	@change="handlechange"
			        	@click="handleIconClick('searchvalue')"
			        	@keyup.enter.native="searchCourseList">
			        </el-input>
			        <el-button type="primary" icon="search" @click="searchCourseList">搜索</el-button>
			    </div>
			    <div class="rightClassList">
			        <div class="classListBox">
			          	<el-checkbox-group v-model="checkedCourses" @change="handleCheckedCourseChange">
			            	<div class="courseLibox" v-for="course in courses">
			              		<img :src="course.img?course.img:'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg'" >
			              		<el-checkbox :label="course" >{{course.foldername}}</el-checkbox>
			            	</div>            
			          	</el-checkbox-group>
			          	<!--<div class="nodata" slot="empty" v-if="courses.length < 1"></div>-->
			        </div>
			        <div class="nc_footer">
			          	<el-checkbox 
			          		:indeterminate="isIndeterminate"  
			          		v-if="courses.length > 0"
			          		@change="handleCheckAllChange"
			          		v-model="checkAll" 
			          		class="allselect">全选</el-checkbox>
			          	<el-button @click="closeEvent">取 消</el-button>
			          	<el-button type="primary" @click="confirmEvent">确 定</el-button>
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
	            	checkedCoursesPackage: [], 	//已经选择的tag标签
	            	searchvalue: '',			//搜索关键字
	            	checkedCourses: [],			//选中课程
	            	courses: [],				//课程对象
	            	checkAll: false,			//是否全选
	            	isIndeterminate: true,
	            	splist : [],
	            	
	            	xtree:function(element,datax){
			          var ele = $("."+element),self = this; 
			          ele.html('');                  
			          for(var i = 0,len = datax.length; i < len; i++ ){
			              var itemcount = datax[i].itemcount,
			                      pname = datax[i].pname,
			                        pid = datax[i].pid, 
			                      sorts = datax[i].sorts||false,                  
			                         li = '';
			                
			               li ='<li class='+pid+'>'
			                  +  '<div class="tr">'
			                  +    '<i class="iconfont"></i><i class="img-organize"></i><span dataid="pid,'+pid+'">'+pname+' (<span style="color:red;margin:0;">'+itemcount+'</span>)</span>'
			                  +  '</div>'
			                  +'</li>';
			               ele.append(li);
			
			              if(sorts){
			                for(var j = 0,lenj = sorts.length; j < lenj; j++){
			                  var itemcountj = sorts[j].itemcount,
			                           sname = sorts[j].sname,
			                             sid = sorts[j].sid,                               
			                              li = '';
			
			                  if($("."+pid+'>ul').length < 1){
			                        $("."+pid).find('i').eq(0).addClass('icon-sanjiao-open');
			            li  ='<ul>'
			              +  '<li >'
			              +   '<div class="tr">'
			              +    '<i></i><i class=" img-organize"></i><span dataid="sid,'+sid+'">'+sname+'(<span style="color:red;margin:0;">'+itemcountj+'</span>)</span>' 
			              +   '</div>'
			              +  '</li>'
			              +'</ul>';
			            $("."+pid).append(li); 
			                  }else{
			            li  ='<li >'
			              + '<div class="tr">'
			              +  '<i></i><i class="img-organize"></i><span dataid="sid,'+sid+'">'+sname+'(<span style="color:red;margin:0;">'+itemcountj+'</span>)</span>'
			              +  '</div>'
			              +'</li>';
			                      $("."+pid+">ul").append(li );  
			                  }
			                }
			              }  
			              
			          	}
			          	ele.find('.iconfont').click(function(e){ 
			              var self = $(this),
			              classname = self[0].classList[1];
			              self.removeClass(classname);
			              if( classname == 'icon-sanjiao-close' ){
			                  self.addClass('icon-sanjiao-open');
			                  self.parent().nextAll('ul').css('display','block');       
			              }else{
			                  self.addClass('icon-sanjiao-close'); 
			                  self.parent().nextAll('ul').css('display','none'); 
			              }
			          	})
			          	//课程分类切换
			          	ele.find('span').click(function(e) { // todo:
			            
			              var value = e.target.attributes[0].value,
			                arrtt = value.split(',');
			              var pidval = ''
			              if(arrtt[0]==='pid'){
			                self.courselist(arrtt[1]);  
			              }else if(arrtt[0]==='sid'){
			                pidval = $(e.target).parents('ul').parent().find('span').eq(0).attr('dataid').split(',')[1]
			                self.courselist(pidval,arrtt[1]); 
			              }
			              $('.selecrCenter').removeClass('selecrCenter');
			              $(this).parent().addClass('selecrCenter');                  
			          	});
			        },
	            	getcoursesort: function(showbysort,sid) { //课程分类列表
			          	var self = this;
			          	$.ajax({
	               			type:"get",
	               			url:"/aroomv3/course/coursesort.html",
	               			async:true,
	               			data:{showbysort: showbysort},
	               			dataType:"json",
	               			success:function(data){
					            if(data.code == 0) {
					              var datas = data.data;
					              if(showbysort == 0){
					                self.splist = datas;
					                self.xtree('leftTreeCourseClass',self.splist);
					              }else{
					                self.splist = datas;
					              }
					            }
	               			}
			          	});
			        },
			        courselist:function(pid,sid){
			          	var self = this;
			          	$.ajax({
	               			type:"get",
	               			url:"/aroomv3/course/courselist.html",
	               			async:true,
	               			data:{
	               				issimple:1,
				                page:1,
				                pagesize:1000,
				                pid:pid,
				                sid:sid,
				                q:self.searchvalue
	               			},
	               			dataType:"json",
	               			success:function(data){
	               				var data = data.data;
			                  	self.courses = data.courselist;
			                  	self.checkedCourses = [];
				                for(var i = 0,len = self.checkedCoursesPackage.length; i < len; i++){//获得已经选中的状态
				                    var item = self.checkedCoursesPackage[i];
				                    for(var j = 0,lenj = self.courses.length; j < lenj; j++){
				                      	var itemj = self.courses[j];
				                      	if(item.folderid == itemj.folderid){
				                        	self.checkedCourses.push(itemj);
				                      	}
				                    }                       
				                }
			                	if(self.checkedCourses.length == self.courses.length){
			                    	self.checkAll = true;
			                    	self.isIndeterminate = false;
			                	}else if(self.checkedCourses.length == 0&&self.courses.length != 0){
			                    	self.checkAll = false;
			                    	self.isIndeterminate = false;
			                	}else{
			                    	self.isIndeterminate = true;
			                  	}
	               			}
	               		});		
			        },
	            }
	        },
	        created: function() {
	        	var self = this;
	        	self.checkedCoursesPackage =[];
        		self.checkedCoursesPackage.push.apply(self.checkedCoursesPackage,window.parent.cacheTabscourse);
	        	self.getcoursesort(0);
	        	self.courselist();
	        	self.$nextTick(function() {
		          	var icon = $('.searchInput .el-input__icon');
		            icon.hide();
		          	$(".searchInput").hover(function(){
		           	 	if(self.searchvalue){
		              		icon.show();
		            	}           
		          	},function(){
		              	icon.hide();
		          	})
		        });
		        //滚动条样式
		        var e="::-webkit-scrollbar{width: 4px;height: 4px;}::-webkit-scrollbar-thumb:vertical{height: 4px;width: 4px;background-color: #20a0ff;}::-webkit-scrollbar-thumb:horizontal{ width: 4px;background-color: #20a0ff;}",d=document.createElement("style");d.id='coursescrollbar';if(document.getElementsByTagName("head")[0].appendChild(d),d.styleSheet){d.styleSheet.disabled||(d.styleSheet.cssText=e)}else{try{d.innerHTML=e}catch(f){d.innerText=e}};
	        },
	        methods:{
	        	handleCloseTag(id){//已经选择tag删除事件
	        		var self = this;
          			for(var i = 0,len = self.checkedCoursesPackage.length; i < len; i++ ){
            			var item = self.checkedCoursesPackage[i];
            			if(item.folderid == id){
              				self.checkedCoursesPackage.splice(i,1);
              				break;
            			}
          			}
		          	for(var j = 0,lenj = self.checkedCourses.length; j < lenj; j++){
		            	var item = self.checkedCourses[j];
		            	if(item.folderid == id){                          
		              		self.checkedCourses.splice(j,1);
		              		break;
		            	}
		          	}
          			if(self.checkedCourses.length == 0){
                  		self.checkAll = false;
                  		self.isIndeterminate = false;
                	}else{
                  		self.isIndeterminate = true;
                	} 
	        	},
	        	searchCourseList(){//搜索
	        		var self = this;
			        $('.leftTreeCourseClass').find('.tr').removeClass('selecrCenter');
			        self.courselist();
	        	},
	        	handleCheckedCourseChange(value){
			        var self = this,          
			        dataArr = []; 
			        for(var i = 0,len = self.courses.length; i < len; i++){
			          	var item = self.courses[i],
			            indexs= [];
			          	for(var j = 0,lenj = self.checkedCoursesPackage.length; j < lenj; j++ ){
			            	var itemj = self.checkedCoursesPackage[j];            
			            	if(item.folderid == itemj.folderid){
			              		indexs.push(j);
			            	}
			          	}
			          	for(var s = indexs.length-1; s >=0 ; s--){
			            	self.checkedCoursesPackage.splice(indexs[s],1);
			          	}
			        }         
			        self.checkedCoursesPackage.push.apply(self.checkedCoursesPackage,value);      
			        let checkedCount = value.length;
		            self.checkAll = checkedCount === self.courses.length;
		            self.isIndeterminate = checkedCount > 0 && checkedCount < self.courses.length;           
			    },
	        	handleCheckAllChange(event){
			        var self = this;
			            event.target.checked ? self.checkedCourses.push.apply(self.checkedCourses,self.courses) : self.checkedCourses =[];
			        //初始化当前的列表：checkedCoursesPackage清空当前self.courses中的项
			            for(var i = 0,len = self.courses.length; i < len; i++){
			          var item = self.courses[i],
			             indexs= [];
			          for(var j = 0,lenj = self.checkedCoursesPackage.length; j < lenj; j++ ){
			            var itemj = self.checkedCoursesPackage[j];            
			            if(item.folderid == itemj.folderid){
			              indexs.push(j);
			            }
			          }
			
			          for(var s = indexs.length-1; s >=0 ; s--){
			            self.checkedCoursesPackage.splice(indexs[s],1);
			          }
			          
			        } 
			        self.checkedCoursesPackage.push.apply(self.checkedCoursesPackage,self.checkedCourses);
			            self.isIndeterminate = false;           
			    },
	        	handlechange(val){//输入框改变函数
	        		if(val){
          				$('.searchInput .el-input__icon').show();
          			}
	        	},
	        	handleIconClick(ev){//点击输入框叉号
	        		var self = this;
		            self[ev] = ''; 
		            if(ev == "searchvalue"){
		            	self.searchCourseList();
		            } 
	        	},
	            closeEvent(){
	            	var self = this;
	            	window.parent.H.get('choiceCourse_dialog').exec('close');
	            	window.parent.$("#addcourseifr").remove();
	            },
				confirmEvent(){//弹窗层确认
					var self = this;
					window.parent.$('.openser_ul').empty();
					var onetab = "";
					for(var i=0;leni=self.checkedCoursesPackage.length,i<leni;i++){
						var itemi = self.checkedCoursesPackage[i];
	            		onetab += '<li folderid="'+itemi.folderid+'">'
	            		onetab += '<span class="tablinamecourse" title="'+itemi.foldername+'">'+itemi.foldername+'</span>'
						onetab += '<span class="delLicourse">x</span></li>'
					}
					window.parent.$('.openser_ul').append(onetab);
	            	window.parent.cacheTabscourse = self.checkedCoursesPackage;
	            	window.parent.H.get('choiceCourse_dialog').exec('close');
	            	window.parent.$("#addcourseifr").remove();
	            }
	        }
	    }) 
	    $(".nc_body").css('opacity',1);    
	</script>
</body>
</html>
