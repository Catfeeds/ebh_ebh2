<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/rollcall.css?<?=getv()?>">
<style>
	.select{
		position: absolute;
		top:7px;
		left: 50px;
		height:26px;
		line-height: 26px;
		font-size: 14px;
		width: 320px; 
	}
	.classgrade{
		width: 200px;
		height: 30px;
		border:1px solid #e3e3e3;
		border-radius: 2px;
		outline: 0;
		cursor: pointer;
		text-indent: 5px;
	}
	.secondTab{
		display: none;
	}
	.se_content{
		margin-top: 30px;
	}
	.left_ob,.left_mf{
		float: left;
		width: 100px;
		margin-left: 50px;
		font-size: 18px;
		font-weight: 600;
		line-height: 40px;
	}
	.right_ob,.right_mf{		
		float: left;
		width: 560px;
		border:1px solid #CCCCCC;
		border-right:0;
		border-bottom: 0;
	}
	.right_ob li,.right_mf li{
		float: left;
		list-style-type: none;
		width:140px;
		height:38px;
		line-height: 40px;
		text-align: center;
		border-right:1px solid #CCCCCC; 
		border-bottom:1px solid #CCCCCC;
		box-sizing: border-box;
	}
	.addup_thead,.myself_thead{
		background-color: #F2F2F2;
	}
	.addup_thead li,.myself_thead li{
		font-weight:600;
		font-size:15px;
	}
	.right_mf{
		width: 560px;
	}
	.right_mf li{
		width: 140px;
	}
	.right_mf .wid93{
		width: 93px;
	}
	.left_mf{
		height: 50px;
	}
	.myself{
		margin-top: 50px;
	}
	.banner{
		float: left;
		margin: 30px auto 0;
		margin-left: 180px;
		width: 420px;
		height: 20px;
	}	
	.rightcount{
		float: right;
		color: #999;
	}
	.banner .spanclass{
		color: #169BD5;
	}
	.myself_tab{
		float: left;
		position:relative;
		width: 558px;
		height: 40px;
	}
	.tab_gate{
		position: absolute;
		top:0;
		left: 0;
		width: 260px;
	}
	.tab_gate li{
		float: left;
		width: auto;
		padding:5px 15px;		
		border-radius: 4px;		
		font-size: 14px;
		cursor: pointer;
	}
	.tab_gate .on{
		background-color: #169BD5;
		color: #fff;
	}
	.myself_search_inp{
		position: absolute;
		top:0;
		right: 70px;
		width: 120px;
		height: 26px;
		border:1px solid #e3e3e3;
		text-indent: 5px;
		border-radius: 2px;
	}
	.myself_search_btn{
		position: absolute;
		top:0;
		right: 0;
		padding: 5px 15px;
		background-color: #169BD5;
		border-radius: 2px;
		cursor: pointer;
		color: #fff;
	}
	.scroll{
		max-height: 362px;
		width: 577px;
		overflow-y:auto; 
		border-bottom: 1px solid #e3e3e3;
	}
	.scroll ul li{
		width: 140px;
		overflow: hidden;
		text-overflow:ellipsis;
		white-space: nowrap;
	}
	.classList{
		overflow-y: auto;
		height: 770px;
		margin-bottom: 20px;
	}
	.class_info span{
		color: #4C88FF;
		max-width: 180px;
		display: inline-block;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.spanclass,.zuishou{
		max-width: 180px;
		display: inline-block;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.selectC{
		border-color: #E3E3E3;
		width: 100px;
		height: 28px;
		position: absolute;
		top: 0;
		right: 210px;
	}
	.courselink{
	 	color: #4C88FF;
	 	font-size: 10px;
	    max-width: 180px;
	    display: inline-block;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	}
	.courselink:visited{
		color: #4C88FF;
	}
</style>
<body>
<div class="lefrig">
	<div class="waitite waitite2">
		<div class="work_menu enterprise" style="position:relative;margin-top:0">
			<ul>
				<li class="tab tap-s" dataclass="firstTab"><a  class="title-a"><span class="jnisrso">上课计划</span></a></li>
                <li class="tab " dataclass="secondTab"><a  class="title-a"><span class="jnisrso">数据统计</span></a></li>
			</ul>
			<div class="newClass_btn">新建计划</div>
		</div>       
    </div>
    
    
    <div class="tabBox">
    	<div class="tab-pane firstTab" >
    		<div class="searchBox">
    			<!--<ul class="timeyearul" style="float: left;">
    				<li>全部</li>
    				<li>今年</li>
    				<li>本月</li>
    				<li>本周</li>
    			</ul>-->
    			<input type="text" class="inp_search" placeholder="请输入搜索关键字"><div class="icon_search"></div>
    		</div>
    		<div class="classList">    			
    		</div>
    		<div class="pages"></div>
    	</div>
    	<div class="tab-pane secondTab" >
    		<div class="searchBox" style="margin-top: 10px;">
				<div class="select">选择：
					<select class="classgrade">					
					</select>
				</div>    			
    		</div>
    		<div class="se_content">
				<div class="overall">
					<div class="left_ob">全局统计：</div>
					<div class="right_ob">
						<ul class="addup_thead">
							<li>班级人数</li>
							<li>上课次数</li>
							<li>到课总人数</li>
							<li>平均到课比</li>
						</ul>
						<ul>							
						</ul>
					</div>
					<div class="banner"><span class="zuishou">最受欢迎课程：</span><span class="spanclass">XXXXXX可测</span> <span class="rightcount"><span class="icon_attendance"></span>观看人数: <span class="countTotal">12/52</span></span></div>
					
				</div> 	
				<div class="myself">
					<div class="left_mf">个人统计：</div>
					<div class="myself_tab">
						<ul class="tab_gate">
							<li class="on" dataType= 0 >课时最多</li>
							<li dataType=1>课时最少</li>
							<!--<li dataType=2>缺勤最多</li>-->
						</ul>
						<select placeholder="选择课程" class="selectC">
							<option value = "1">选择课程</option>
						</select>
						<input type="text" class="myself_search_inp" placeholder="请输入姓名关键字">
						<div class="myself_search_btn">搜索</div>	
					</div>
					<div class="right_mf">
						<ul class="myself_thead">
							<li>姓名</li>
							<li>课程名称</li>
							<li class="wid93">总课时</li>
							<li class="wid93">已完成课时</li>
							<li class="wid93">完成率</li>
						</ul>
						<div class="scroll">
							<ul>
							</ul>
						</div>
					</div>
				</div>
    		</div>
    	</div>
    </div>
    
    
    <!--新建计划-->
    <div id="newClass" style="display:none;">
	    <style>
			.ui-dialog2{
	        	border-radius: 4px;
	      	}
	    </style>	
	    <iframe src="/troomv2/rollcall/add.html" frameborder="0" width="700" height="330"></iframe>
    </div>
    <!--新建计划-->
    <div id="editClass" style="display:none;">
	    <style>
			.ui-dialog2{
	        	border-radius: 4px;
	      	}
	    </style>	
	    <iframe src="/troomv2/rollcall/add.html?edito" frameborder="0" width="700" height="330"></iframe>			
    </div>
    
    <!--去报名-->
    <div id="addUser" style="display:none;">
	    <style>
			.ui-dialog2{
	        	border-radius: 4px;
	      	}
	   	</style>
	    <iframe id="addUserif" src="/troomv2/rollcall/adduser.html?" frameborder="0" width="700" height="500"></iframe>
    </div>
    <!--去报名-->
    <div id="addUseredit" style="display:none;">
	    <style>
			.ui-dialog2{
	        	border-radius: 4px;
	      	}
	   	</style>
	    <iframe id="addUserifedito" src="/troomv2/rollcall/adduser.html?edito" frameborder="0" width="700" height="500"></iframe>
    </div>
    
    <!--开始点名-->
    <div id="startRollCall" style="display:none;">	
    	<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/startRollCall.css?v0001">	
    	<style>
    		.table_tr p, .table_tr span{
				float: left;
				width: 135px;
				padding: 0;
			}
    	</style>
		<div class="rollcallBox">
			<div class="rc_head">
				<span class="rc_title">开始点名</span>
        		<span class="rc_close" >×</span>
			</div>
			<div class="rollcallList">
				<div class="searchColumn">
					<div class="tabRollcall">
						<div class="tab_li tab_on" dataCalled=''>全部</div>
						<div class="tab_li" dataCalled='1'>已点名</div>
						<div class="tab_li" dataCalled='0'>未点名</div>
					</div>
					<div class="rightSearch">
						<input type="text" class="inp_rightSearch" placeholder="请输入搜索关键字">
						<div class="searchBtn">搜索</div>
					</div>
				</div>
				<div class="rc_table">
					<ul class="table_head">
						<li>姓名</li>
						<li>所属</li>
						<li>点名时间</li>
						<li>操作</li>
					</ul>
					<div class="table_Content">
					</div>
				</div>
			</div>
		</div>
    </div>
    <!--重点-->
    <div id="afreshCall" style="display: none;">
    	<style>
			.ui-dialog2{
	        	border-radius: 4px;
	      	}
	    </style>	
	    <iframe src="/troomv2/rollcall/call.html" frameborder="0" width="550" height="400" class="afreshCallUrl"></iframe>
    </div>
    <!--新建成功-->
    <div id="succesDialog" style="display: none;">
    	<style>
			.box{
				width: 350px;
				height: 200px;
			}
			.tit{
				height: 120px;
				line-height: 120px;
				font-size: 24px;
			}
			.successHide{
				padding: 5px 20px;
				background-color: #169BD5;
				color: #fff;
				font-size: 16px;
				border-radius:4px;
				cursor: pointer;
			}
    	</style>
    	<div class="box">
			<div class="tit">新建成功</div>			
			<button class="successHide">确定</button>
		</div>
    </div>
    <!--编辑成功-->
    <div id="succesEditDialog" style="display: none;">
    	<style>
			.box{
				width: 350px;
				height: 200px;
			}
			.tit{
				height: 120px;
				line-height: 120px;
				font-size: 24px;
			}
			.successHide{
				padding: 5px 20px;
				background-color: #169BD5;
				color: #fff;
				font-size: 16px;
				border-radius:4px;
				cursor: pointer;
			}
    	</style>
    	<div class="box">
			<div class="tit">编辑成功</div>			
			<button class="successHide">确定</button>
		</div>
    </div>
    <!--报名成功-->
    <div id="succesupDialog" style="display: none;">
    	<style>
			.box{
				width: 350px;
				height: 200px;
			}
			.tit{
				height: 120px;
				line-height: 120px;
				font-size: 24px;
			}
			.successHide{
				padding: 5px 20px;
				background-color: #169BD5;
				color: #fff;
				font-size: 16px;
				border-radius:4px;
				cursor: pointer;
			}
    	</style>
    	<div class="box">
			<div class="tit">报名成功</div>			
			<button class="successHide">确定</button>
		</div>
    </div>
    <!--删除-->
    <div id="deleteDialog" style="display: none;">
    	<style>
			.box{
				width: 350px;
				height: 180px;
			}
			.tit{
				height: 120px;
				line-height: 120px;
				font-size: 24px;
			}
			.deleteHide,.deleteCancel{
				padding: 5px 20px;
				background-color: #169BD5;
				color: #fff;
				font-size: 16px;
				border-radius:4px;
				cursor: pointer;
			}
			.deleteCancel{
				background-color: #fff;
				border:1px solid #ccc;
				color: #333;
			}
    	</style>
    	<div class="box">
			<div class="tit">确定要删除该课程吗？</div>			
			<button class="deleteHide">确定</button>
			<button class="deleteCancel">取消</button>
		</div>
    </div>
    <!--操作成功-->
    <div id="successAllDialog" style="display: none;">
    	<style>
			.boxs{
				width: 350px;
				height: 140px;
			}
			.tit{
				height: 120px;
				line-height: 120px;
				font-size: 24px;
			}
			
    	</style>
    	<div class="boxs">
			<div class="tit">操作成功</div>	
		</div>
    </div>
	<!--操作失败-->
    <div id="failAllDialog" style="display: none;">
    	<style>
			.boxsz{
				width: 350px;
				height: 200px;
			}
			.failmsg{
				height: 120px;
				line-height: 120px;
				font-size: 22px;
			}
			.failHide{
				padding: 5px 20px;
				background-color: #169BD5;
				color: #fff;
				font-size: 16px;
				border-radius:4px;
				cursor: pointer;
			}			
    	</style>
    	<div class="boxsz">
			<div class="failmsg">操作失败</div>	
			<button class="failHide">确定</button>
		</div>
    </div>
</div>
</body>
<script>
	var grid;
	var rollcall = {
		init:function(){//初始化
			var self = this;
			self.getTimerule(); //页面一加载获取时间规则
			self.tab = $('.tab');
			self.num = 1;
			self.pagesize = 10;
			self.q = '';
			self.renderData({q:self.q,page:1,pagesize:self.pagesize},1);
			self.renderClassList();			
			self.bindEvent();
			self.pagesEvent();
			self.initNewClass();
			self.initSignUp();
			self.initEditClass();
			self.initaddUseredit();
			self.initRollCall();
			self.initAfreshCall();
			self.ininSuccesDialog();
			self.initDeleteClass();	
			self.initSuccessAllDialog();	
			self.bind=0;	
			self.$classList = $(".classList");
			self.addusertime = "";
			self.calltime = "";
			self.minusernum = "";
			self.callbtn = true;
		},
		getTimerule:function(){
			var self = this;
			$.ajax({
				type:"get",
				url:"/aroomv3/rollcall/settings.html",
				dataType:"json",
				success:function(res){
					var datas = res.data;
					self.addusertime = datas.addusertime;
					self.calltime = datas.calltime;
					self.minusernum = datas.minusernum;
				}
			});
		},
		renderData:function(obj,num){//上课列表
			var self = this,rid;
			$.ajax({
				type: "GET",
				url: "/troomv2/rollcall/lists.html",
				dataType: "json",
				data:obj,	             
				success:function(res){
					var data = res.data,
					    cwlist = data.cwlist,
					    cwcount = data.cwcount,
					    html='';
					    self.$classList.html('');
					    self.pageData(cwcount,num);	
					//当前时间
					var timestamp = (Date.parse(new Date()))/1000;
					if(cwlist.length > 0){ 
						for(var i=0,len=cwlist.length;i < len;i++){
							var item = cwlist[i],
								cwid = item.cwid,
							    rid = item.rid,
							    stime = new Date(item.starttime*1000),
							    yyr = stime.getFullYear()+'-'+((stime.getMonth()+1)<10?"0"+(stime.getMonth()+1):stime.getMonth()+1)+'-'+(stime.getDate() < 10?"0"+stime.getDate():stime.getDate()),
							    starttime = yyr+' '+(stime.getHours()<10?"0"+stime.getHours():stime.getHours())+':'+(stime.getMinutes()<10?"0"+stime.getMinutes():stime.getMinutes()),
							    etime = new Date((parseInt(item.starttime)+parseInt(item.cwlength))*1000),
							    endtime = (etime.getHours()<10?"0"+etime.getHours():etime.getHours())+':'+(etime.getMinutes()<10?"0"+etime.getMinutes():etime.getMinutes()),
							    rname = item.rname,
							    title = item.title,
							    totalcount = item.totalcount,
							    calledcount = item.calledcount,
							    _goto,_rollcall,_edit,_see,_delete,seenum,singuped,notenough,endrollcall,endsignup;
								//用类名的显示隐藏来控制每个计划的当前次状态
							    //先判断是否在去报名阶段
								
								//这个每一个计划的报名截止时间的时间戳
								var adduserend = parseInt(item.starttime) - parseInt(self.addusertime);
								
								var startcall = parseInt(item.starttime) - parseInt(self.calltime);
								var endcall = parseInt(item.starttime) + parseInt(self.calltime);
								
								if(timestamp < adduserend){  //当前时间 小于 报名结束时间
									_goto = "displayblock";
									_rollcall = "displaynone";
									_edit = "displayblock";
									_see = "displaynone";
									_delete = "displayblock";
									seenum = "displaynone";
									singuped = "displayblock";
									notenough = "displaynone";
									endrollcall = "displaynone";
									endsignup = "displaynone";
								}else{						//当前时间 大于等于 报名结束时间
									if(item.totalcount < self.minusernum){ //人数不足
										_goto = "displaynone";
										_rollcall = "displaynone";
										_edit = "displayblock";
										_see = "displaynone";
										_delete = "displayblock";
										seenum = "displaynone";
										singuped = "displayblock";
										notenough = "displayblock";
										endrollcall = "displaynone";
										endsignup = "displaynone";
									}else{
										if(timestamp <= endcall){
											if(timestamp < startcall){	//当前时间小于点名开始时间
												_goto = "displaynone";
												_rollcall = "displayblock class_disable";
												_edit = "displaynone";
												_see = "displaynone";
												_delete = "displaynone";
												seenum = "displaynone";
												singuped = "displayblock";
												notenough = "displaynone";
												endrollcall = "displaynone";
												endsignup = "block";
											}else{						// 当前时间 大于等于 点名开始时间
												_goto = "displaynone";
												_rollcall = "displayblock";
												_edit = "displaynone";
												_see = "displaynone";
												_delete = "displaynone";
												seenum = "displayblock";
												singuped = "displaynone";
												notenough = "displaynone";
												endrollcall = "displaynone";
												endsignup = "displaynone";
											}
										}else{
											_goto = "displaynone";
											_rollcall = "displaynone";
											_edit = "displaynone";
											_see = "displayblock";
											_delete = "displaynone";
											seenum = "displayblock";
											singuped = "displaynone";
											notenough = "displaynone";
											endrollcall = "displayblock";
											endsignup = "displaynone";
										}
									}
								}	
							  	
							html +='<div class="class_li">'
								 +   '<p class="class_title"><span class="icon_play"></span>'+rname+'</p>'
						         +   '<div class="class_info"><span style="color:#333;">观看课件：</span><a target="_blank" href="/troomv2/course/'+cwid+'.html" class="courselink">'+title+'</a></div>'
						         +   '<div class="class_attendance '+seenum+'"><span class="icon_attendance"></span>观看人数：'+calledcount+'/<span class="havecount">'+totalcount+'</span></div>'
						         +   '<div class="class_attendance '+singuped+'"><span class="icon_attendance"></span>已报名：<span class="havecount">'+totalcount+'</span>人</div>'
						         +   '<div class="class_time"><span class="icon_time"></span>上课时间：'+starttime+'-'+endtime+'</div>'
						         +   '<div class="class_handle">'
							     +      '<div class="class_goto '+_goto+'" dataRid='+rid+'>去报名</div>'
							     +		'<div class="'+endsignup+'" style="color:#FF0000;">报名结束</div>'
							     +      '<div class="class_rollcall '+_rollcall+'" dataRid='+rid+'>开始点名</div>'
							     +		'<div class="'+notenough+'" style="color:#FF0000">报名人数不足</div>'
							     +      '<div class="class_edit '+_edit+'" editData="'+rid+'">编辑</div>'
							     +		'<div class="'+endrollcall+'" style="color:#FF0000">点名结束</div>'
							     +      '<div class="class_see '+_see+'" editData="'+rid+'">查看</div>'
								 +      '<div class="class_delete '+_delete+'" riddata='+rid+'>删除</div>'
						         +   '</div>'
								 + '</div>';
						}	
					}else{
						html='<div class="nodata"></div>';
					}
					//				
					// ,title:'+title+',rname:'+rname+',dateline:'+item.dateline+',crid:'+item.crid+',cwid:'+item.cwid+'
					self.$classList.append(html);
					
					//去报名按钮
					$(".class_goto").on('click',function(){	
						var	rid = $(this).attr('dataRid');
						var havecount = $(this).parent().siblings(".class_attendance").children(".havecount").html();
						if(havecount > 0){
							self.rollCallSignupedito(rid);
						}else{
							self.rollCallSignup(rid);	
						}
					});
					//开始点名
					$(".class_rollcall").on('click',function(){
						if(!$(this).hasClass("class_disable")){
							grid = $(this).attr('dataRid');
							self.callbtn = true;
							self.rollCallShow(grid);
						}
					});
					//编辑					
					$('.class_edit').on('click',function(){						
						self.editClassShow();
						parent.window.$('#editClass').attr('editdata',$(this).attr('editdata'))//rodo:
					});
					//查看
					$('.class_see').on('click',function(){
						grid = $(this).attr('editData');
						self.callbtn = false;
						self.rollCallShow(grid,"see");
						
					});
					//删除
					$('.class_delete').on('click',function(){
							// /troomv2/rollcall/del.html
						parent.window.H.get('deleteDialog').exec('show');
						parent.window.$('#deleteDialog').attr('dataRid',$(this).attr('riddata'))
					});
					
					
						
					if(!self.bind){
						var tab_li = parent.window.$('.tab_li');
						tab_li.on('click',function(){//点名类型选择
							tab_li.removeClass('tab_on');
							$(this).addClass('tab_on');
							if(self.callbtn){
								self.renderRollCallList(grid,$(this).attr('dataCalled'),parent.window.$('.inp_rightSearch').val());
							}else{
								self.renderRollCallList(grid,$(this).attr('dataCalled'),parent.window.$('.inp_rightSearch').val(),"see");
							}
							

						})
						
						self.bind=1;
						var searchBtn = parent.window.$('.searchBtn');

						searchBtn.on('click',function(){//搜索按钮

							var inp_Search = parent.window.$('.inp_rightSearch').val(),
							    Called = parent.window.$('.tab_on').attr('dataCalled');
							
							if(self.callbtn){
								self.renderRollCallList(grid,Called,inp_Search);
							}else{
								self.renderRollCallList(grid,Called,inp_Search,"see");
							}    
							

						})
					}
				}
			})
		},
		bindEvent:function(){//主页注册事件
			var self = this;
			self.tab.on('click',function(){
				self.tab.removeClass('tap-s');
				$(this).addClass('tap-s');
				var dataclass = $(this).attr('dataclass');
				if(dataclass == 'firstTab'){
					$('.secondTab').hide();
					$('.firstTab').show();	
					$('.newClass_btn').show();				
				}else{
					$('.firstTab').hide();
					$('.newClass_btn').hide();	
					$('.secondTab').show();
				}
			})

			$(".newClass_btn").on('click',function(){
				self.newClassShow();
			})

			$(".icon_search").on('click',function(){
				self.q = $('.inp_search').val();
				self.renderData({q:self.q,page:1,pagesize:self.pagesize},1);
			})		
		},
		initNewClass:function(){//初始化 create dialog(#newClass)
			var self = this;
			parent.window.H.remove('newClass');
		    $('#newClass',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'newClass',
		        title:'',
		        easy:true,
		        content:$("#newClass")[0]
		    }),'common');
		},
		initSignUp:function(){//初始化 create dialog(#addUser)
			var self = this;
			parent.window.H.remove('addUser');
		    $('#addUser',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'addUser',
		        title:'',
		        easy:true,
		        content:$("#addUser")[0]
		    }),'common');
		},
		newClassShow:function(){//新建课程弹出框显示  dialog(#newClass)	

			parent.window.H.get('newClass').exec('show');
		},
		rollCallSignup:function(rid){//去报名	
			var self = this;
			parent.window.$("#addUserif").attr("rid",rid);
			parent.window.H.get('addUser').exec('show');
		},
		rollCallSignupedito:function(rid){//编辑去报名
			parent.window.$("#addUserifedito").attr("rid",rid);
			parent.window.H.get('addUseredit').exec('show');
		},
		initEditClass:function(){//初始化 dialog(#editClass)
			var self = this;
			parent.window.H.remove('editClass');
		    $('#editClass',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'editClass',
		        title:'',
		        easy:true,
		        content:$("#editClass")[0]
		    }),'common');
		},
		initaddUseredit:function(){
			var self = this;
			parent.window.H.remove('addUseredit');
		    $('#addUseredit',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'addUseredit',
		        title:'',
		        easy:true,
		        content:$("#addUseredit")[0]
		    }),'common');
		},
		editClassShow:function(){//编辑课程弹出框显示  dialog(#editClass)

			parent.window.H.get('editClass').exec('show');
		},
		initDeleteClass:function(){
			var self = this;
			parent.window.H.remove('deleteDialog');
		    $('#deleteDialog',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'deleteDialog',
		        title:'',
		        easy:true,
		        content:$("#deleteDialog")[0]
		    }),'common');

		    parent.window.$('.deleteHide').on('click',function(){
		    	var rid = parent.window.$('#deleteDialog').attr('dataRid');
		    	$.ajax({
					type: "post",
					url: "/troomv2/rollcall/del.html",
					dataType: "json",
					data:{
						rid:rid
					},	             
					success:function(res){
						parent.window.H.get('deleteDialog').exec('close');
						if(parseInt(res.code) == 0){
							parent.window.H.get('successAllDialog').exec('show');
							setTimeout(function(){
								parent.window.H.get('successAllDialog').exec('close');
								self.renderData({q:self.q,page:self.num,pagesize:self.pagesize},self.num);
							},1000)
						}
					}
				})
				
			})


			parent.window.$('.deleteCancel').on('click',function(){
				parent.window.H.get('deleteDialog').exec('close');
				// self.renderData();
			})
		},
		initSuccessAllDialog:function(){
			var self = this;
			parent.window.H.remove('successAllDialog');
		    $('#successAllDialog',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'successAllDialog',
		        title:'',
		        easy:true,
		        content:$("#successAllDialog")[0]
		    }),'common');
		},
		initRollCall:function(){//初始化 create dialog(#startRollCall)
			parent.window.H.remove('startRollCall');
		    $('#startRollCall',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'startRollCall',
		        title:'',
		        easy:true,
		        content:$("#startRollCall")[0]
		    }),'common');
		},
		rollCallShow:function(rid,status){//开始点名弹出框 dialog(#startRollCall)
			var self = this;
			parent.window.H.get('startRollCall').exec('show');
			parent.window.$('.inp_rightSearch').val('');
			
			self.renderRollCallList(rid,"","",status);

			parent.window.$('.rc_close').on('click',function(){
				self.closeEvent('startRollCall');
				self.renderData({q:self.q,page:self.num,pagesize:self.pagesize},self.num);	
			})	

			var tab_li = parent.window.$('.tab_li');
			tab_li.removeClass('tab_on');
			tab_li.eq(0).addClass('tab_on');			
		},
		renderRollCallList:function(rid,called,q,status){//渲染班级成员列表
			var self = this,param ={rid:rid,page:1,pagesize:1000};
			if(called!=''){
				param.called = called;
			}
			if(q){
				param.q = q;
			}
			$.ajax({
                type: "get",
                url: "/troomv2/rollcall/rolllist.html",
                dataType: "json",
                data:param,
                success:function(res){ 
                	var rolllist = res.data.rolllist;
                	parent.window.$(".table_Content").html('');
                	var html = '';
                	for(var i = 0, len = rolllist.length; i < len; i++){
                		var item = rolllist[i],timeLi='',toolLi='';
                		if(item.called < 1){
                			if(status == "see"){
                				timeLi='<li>--</li>';
                				toolLi='<li>--</li>';
                			}else{
                				timeLi='<li>--</li>';
                				toolLi='<li><b class="roCallBtn" datauid='+item.uid+'>点名</b></li>';
                			}
                		}else{
                			var time = new Date(item.dateline*1000),
                			    yyr = time.getFullYear()+'-'+((time.getMonth()+1)<10?"0"+(time.getMonth()+1):time.getMonth()+1)+'-'+(time.getDate()<10?"0"+time.getDate():time.getDate()),
                			    hms = (time.getHours()<10?"0"+time.getHours():time.getHours())+':'+(time.getMinutes()<10?"0"+time.getMinutes():time.getMinutes())+':'+(time.getSeconds()<10?"0"+time.getSeconds():time.getSeconds());
                			

                			timeLi='<li><p>'+yyr+'</p><span>'+hms+'</span></li>';
                			if(status == "see"){
                				toolLi='<li>已点名</li>';
//              				<b class="isclear" datauid='+item.uid+'>取消</b>
                			}else{
                				toolLi='<li>已点名</li>';
                				toolLi='<li><b class="isclear" datauid='+item.uid+'>取消</b></li>';
//              				<b class="afreshCall" datauid='+item.uid+'>重点</b>
                			}
                		}
                		var name = item.realname?item.realname:item.username;
                		html+='<ul class="table_tr">'
							+   '<li>'+name+'</li>'
							+   '<li>'+item.classname+'</li>'
							+   timeLi
							+   toolLi
							+ '</ul>';						
                	}                	
                	if(len < 1){
                		html = '<div class="nodata"></div>'
                	}
                 	parent.window.$(".table_Content").html(html);                	
                	self.bindRollCallEvent(rid);
                }
            })	
		},
		bindRollCallEvent:function(rid){
			var self = this;  

			parent.window.$(".roCallBtn").on('click',function(){//点名
				var uid = $(this).attr('datauid');
				var inp_Search = parent.window.$('.inp_rightSearch').val(),					
				    Called = parent.window.$('.tab_on').attr('dataCalled');
				
				$.ajax({
	                type: "post",
	                url: "/troomv2/rollcall/call.html",
	                dataType: "json",
	                data:{
	                  rid:rid,
					  uid:uid,
					  isclear:0
	                },
	                success:function(res){
	                	var code = res.code; 
	                	if(code < 1 ){	                		
							self.renderRollCallList(rid,Called,inp_Search);
	                	}else{
	                		parent.window.$('.failmsg').text('点名失败,'+res.msg);
	                		parent.window.H.get('failAllDialog').exec('show');	
	                	}
	                }
	            })
			})

			parent.window.$(".isclear").on('click',function(){//取消点名
				var uid = $(this).attr('datauid');
				var inp_Search = parent.window.$('.inp_rightSearch').val(),					
				    Called = parent.window.$('.tab_on').attr('dataCalled');
				
				$.ajax({
	                type: "post",
	                url: "/troomv2/rollcall/call.html",
	                dataType: "json",
	                data:{
	                  rid:rid,
					  uid:uid,
					  isclear:1,
					  dateline:Date.parse(new Date())/1000
	                },
	                success:function(res){
	                	var code = res.code; 
	                	if(code < 1 ){	                		
							self.renderRollCallList(rid,Called,inp_Search);
	                	}
	                }
	            })
			})

			parent.window.$(".afreshCall").on('click',function(){//重新点名
				var uid = $(this).attr('datauid');
				var inp_Search = parent.window.$('.inp_rightSearch').val(),					
				    Called = parent.window.$('.tab_on').attr('dataCalled');
				self.afreshCallShow(rid,uid);	
			})
		},
		afreshCallShow:function(rid,uid){
			var self = this;
			parent.window.H.get('afreshCall').exec('show');	
			parent.window.$("#afreshCall").attr({rid:rid,uid:uid});					
		},
		initAfreshCall:function(){
			parent.window.H.remove('afreshCall');
		    $('#afreshCall',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'afreshCall',
		        title:'',
		        easy:true,
		        content:$("#afreshCall")[0]
		    }),'common');
		},
		ininSuccesDialog:function(){//成功确定
			var self = this;
			parent.window.H.remove('succesDialog');
		    $('#succesDialog',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'succesDialog',
		        title:'',
		        easy:true,
		        content:$("#succesDialog")[0]
		    }),'common');

		    $('#succesEditDialog',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'succesEditDialog',
		        title:'',
		        easy:true,
		        content:$("#succesEditDialog")[0]
		    }),'common');
			
			$('#succesupDialog',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'succesupDialog',
		        title:'',
		        easy:true,
		        content:$("#succesupDialog")[0]
		    }),'common');

			$('#failAllDialog',parent.window.document.body).remove();
		    parent.window.H.create(new P({
		        id:'failAllDialog',
		        title:'',
		        easy:true,
		        content:$("#failAllDialog")[0]
		    }),'common');

		    parent.window.$('.successHide').on('click',function(){
				parent.window.H.get('succesDialog').exec('close');
				parent.window.H.get('succesEditDialog').exec('close');
				parent.window.H.get('succesupDialog').exec('close');
				self.renderData({q:self.q,page:1,pagesize:self.pagesize},1);
			})

			parent.window.$('.failHide').on('click',function(){
				parent.window.H.get('failAllDialog').exec('close');	
			})
		},
		closeEvent:function(id){//关闭 dialog(#startRollCall)
			parent.window.H.get(id).exec('close');
		},
		renderClassList:function(){
			var self = this,
			$classgrade = $('.classgrade'),
			$tab_gateli = $('.tab_gate li'),
			$searchbtn = $('.myself_search_btn'),
			$searchinp = $('.myself_search_inp');

			$.ajax({
				type: "GET",
				url: "/aroomv3/classes/lists.html",
				dataType: "json",
				data:{
					pagenum:1,
					pagesize:1000
				},	             
				success:function(res){					
					var list = res.data.list,
					    options='';
					for(var i = 0,len = list.length; i < len; i++){
						var item = list[i];
						options+='<option value="'+item.classid+'">'+item.classname+'</option>';
					}
					$classgrade.append(options);					
					self.renderStatistics($classgrade.val());
				}
			})

			$classgrade.on('change',function(e){	
				$('.tab_gate li').removeClass('on');
				$('.tab_gate li').eq(0).addClass('on');
				$('.selectC').html('<option value = "1">选择课程</option>');
				self.renderStatistics($classgrade.val());
			});

			$tab_gateli.on('click',function(){
				var bloo = $(this).hasClass('on');
				if(!bloo){
					$tab_gateli.removeClass('on');
					$(this).addClass('on');
					switch(parseInt($('.on').attr('dataType'))){
						case 0:
							//课时最多处理
							var maxList = self.getMaxCloseClassData("max");
							self.renderRight_mfData(maxList);
							break;
						case 1:
							//课时最少处理
							var minList = self.getMaxCloseClassData("min");
							self.renderRight_mfData(minList);
							break;
//						case 2:
//							var maxList = self.getMaxCloseClassData();
//							console.log(maxList)
//							self.renderRight_mfData(maxList);
//							break;
					}
				}
			})

			$searchbtn.on('click',function(){
				var list = self.getSearchKeyData($searchinp.val());
				self.renderRight_mfData(list);
			});
			
			$('.selectC').on("change",function(e){
				var list = self.selectCfun($(this).val());
				self.renderRight_mfData(list);
			});
			
		},
		renderStatistics:function(classid){
			var self = this;
			$.ajax({
				type: "GET",
				url: "/troomv2/rollcall/statsall.html",
				dataType: "json",
				data:{
					classid:classid
				},	             
				success:function(res){				
					var data = res.data,
				   usercount = data.usercount,
				  totalcount = data.totalcount,
					  rcount = data.rcount,
			   calledpercent = parseInt(data.calledpercent)==0?data.calledpercent:data.calledpercent+'%',
			        userlist = data.userlist;
			   self.userlist = data.userlist,
			           hotcw = data.hotcw;

			   	var ul = $(".overall ul").eq(1),
			   	    li='';
			   		li += '<li>'+usercount+'</li>'
					   +  '<li>'+rcount+'</li>'
					   +  '<li>'+totalcount+'</li>'
					   +  '<li>'+calledpercent+'</li>';
			   		ul.html(li);
			   	var mful = $('.right_mf ul').eq(1),mli = '',options="";
			   		self.getMaxCloseClassData('max');
			   	    for(var i = 0,len = userlist.length; i < len; i++){
			   	    	var item = userlist[i],
			   	    	name = item.realname?item.realname:item.username;
			   	    	var completion_rate = (item.calledcount / item.totalcount)*100;
			   	    	completion_rate = completion_rate.toFixed(2);
			   	    	completion_rate += '%';
				   	    mli += '<li title='+name+'>'+name+'</li>'
						    +  '<li>'+item.iname+'</li>'
						    +  '<li class="wid93">'+item.totalcount+'</li>'
						    +  '<li class="wid93">'+item.calledcount+'</li>'
						    +  '<li class="wid93">'+completion_rate+'</li>';
			   	    }
					mful.html(mli);
					if(hotcw.length < 1){
						$('.banner').hide();
					}else{
						$('.banner').show();
						if(hotcw[0]){
							$('.spanclass').text(hotcw[0].title);
							$('.countTotal').text(hotcw[0].rcount+'/'+hotcw[0].usercount);
						}else{
							$('.banner').hide();
						}
						
					}
					
					var selsctres = [];
					var json = {};
					for(var i = 0,len = userlist.length; i < len; i++){
					  	if(!json[userlist[i].iname]){
					   		selsctres.push(userlist[i]);
					   		json[userlist[i].iname] = 1;
					  	}
					}
					for(var i = 0,len = selsctres.length; i < len; i++){
						var item = selsctres[i];
						options+='<option value="'+item.iname+'">'+item.iname+'</option>';
					}
					$('.selectC').append(options);
				}
			})
		},
		renderRight_mfData:function(Data){
			//显示处理，课时最多，课时最少，搜索，选择课程
			var self = this,
			userlist = Data,
			mful = $('.right_mf ul').eq(1),
		   	mli = '';

	   	    for(var i = 0,len = userlist.length; i < len; i++){
	   	    	var item = userlist[i];
				name = item.realname?item.realname:item.username;
				var completion_rate = (item.calledcount / item.totalcount)*100;
			   	completion_rate = completion_rate.toFixed(2);
			   	completion_rate += '%';
		   	    mli += '<li title='+name+'>'+name+'</li>'
				    +  '<li>'+item.iname+'</li>'
				    +  '<li class="wid93">'+item.totalcount+'</li>'
				    +  '<li class="wid93">'+item.calledcount+'</li>'
				    +  '<li class="wid93">'+completion_rate+'</li>';
	   	    }

			mful.html(mli);
		},
		getMaxAttendClassData:function(){
			var self = this,
			maxvalue = 0,
			maxArr = [];
			for(var i = 0,len = self.userlist.length; i < len; i++){
				var calledcount = self.userlist[i].calledcount;
				if(calledcount > maxvalue){
					maxvalue = calledcount;
				}
			}

			for(var j = 0,jen = self.userlist.length; j < jen; j++){
				var item = self.userlist[j],
				calledcount = item.calledcount;

				if(calledcount == maxvalue){
					maxArr.push(item);
				}
			}
			return maxArr;
		},
		getMaxCloseClassData:function(val){
			var self = this,truwArr = [],truwArr1 = [];
			
			if($(".selectC").val() == 1 && $('.myself_search_inp').val() == ""){
				if(val == "min"){
					self.userlist.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}else{
					self.userlist.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}
				return self.userlist;
			}
			
			if($(".selectC").val() == 1 && $('.myself_search_inp').val() != ""){
				for(var i = 0,len = self.userlist.length; i < len; i++){
					var item = self.userlist[i],
					realname = item.realname;
					if(realname.indexOf($('.myself_search_inp').val()) > -1){
						truwArr.push(item);
					}
				};
				if(val == "min"){
					truwArr.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}else{
					truwArr.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}
				return truwArr;
			}
			
			if($(".selectC").val() != 1 && $('.myself_search_inp').val() == ""){
				for(var i = 0,len = self.userlist.length; i < len; i++){
					var item = self.userlist[i],
					iname = item.iname;
					if($(".selectC").val() == iname){
						truwArr.push(item);
					}
				};
				if(val == "min"){
					truwArr.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}else{
					truwArr.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}
				return truwArr;
			}
			
			if($(".selectC").val() != 1 && $('.myself_search_inp').val() != ""){
				for(var i = 0,len = self.userlist.length; i < len; i++){
					var item = self.userlist[i],
					iname = item.iname;
					if($(".selectC").val() == iname){
						truwArr.push(item);
					}
				};
				for(var i = 0,len = truwArr.length; i < len; i++){
					var item = truwArr[i],
					realname = item.realname;
					if(realname.indexOf($('.myself_search_inp').val()) > -1){
						truwArr1.push(item);
					}
				};
				return truwArr1;
			}
			
			
		},
		selectCfun:function(val){
			var self = this,
			truwArr = [],truwArr1 = [];
			if($('.myself_search_inp').val() == ""){
				if(val == 1){
					truwArr = self.userlist;
				}else{
					for(var i = 0,len = self.userlist.length; i < len; i++){
						var item = self.userlist[i],
						iname = item.iname;
						if(val == iname){
							truwArr.push(item);
						}
					};
				};
				if($($('.tab_gate li')[0]).hasClass("on")){
					truwArr.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}else{
					truwArr.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}
				return truwArr;
			}else{
				for(var i = 0,len = self.userlist.length; i < len; i++){
					var item = self.userlist[i],
					realname = item.realname;
					if(realname.indexOf($('.myself_search_inp').val()) > -1){
						truwArr.push(item);
					}
				};
				if(val == 1){
					truwArr1 = truwArr;
				}else{
					for(var i = 0,len = truwArr.length; i < len; i++){
						var item = truwArr[i],
						iname = item.iname;
						if(val == iname){
							truwArr1.push(item);
						}
					};
				}
				if($($('.tab_gate li')[0]).hasClass("on")){
					truwArr1.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}else{
					truwArr1.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}
				return truwArr1;
			}
		},
		getSearchKeyData:function(val){ //搜索姓名关键字
			var self = this,truwArr1 = [],
			truwArr = [];
			if($(".selectC").val() == 1){
				for(var i = 0,len = self.userlist.length; i < len; i++){
					var item = self.userlist[i],
					realname = item.realname;
					if(realname.indexOf(val) > -1){
						truwArr.push(item);
					}
				};
				if($($('.tab_gate li')[0]).hasClass("on")){
					truwArr.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}else{
					truwArr.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}
				return truwArr;
			}else{
				for(var i = 0,len = self.userlist.length; i < len; i++){
					var item = self.userlist[i],
					iname = item.iname;
					if($(".selectC").val() == iname){
						truwArr.push(item);
					}
				};
				for(var i = 0,len = truwArr.length; i < len; i++){
					var item = truwArr[i],
					realname = item.realname;
					if(realname.indexOf(val) > -1){
						truwArr1.push(item);
					}
				};
				if($($('.tab_gate li')[0]).hasClass("on")){
					truwArr1.sort(function(a,b){  
				        return b.totalcount - a.totalcount;  
				   	});
				}else{
					truwArr1.sort(function(a,b){  
				        return a.totalcount - b.totalcount;  
				   	});
				}
				return truwArr1;
			}
			
		},
        pageData:function(total,curr){//渲染分页
          var self = this,
          pageHtml = '',
               len = parseInt((total-1)/self.pagesize)+1;
          self.pages.html('');
            if(len==1) return false;
              pageHtml += '<div class="listPage">';
              
            if(curr > 1 ){
              pageHtml +='<a  id="next" dataStatus="pre">&lt;&lt;上一页</a>'
            }
          
            for(var i = 1;i <= len;i++){  
              if(curr == i){
                pageHtml += '<a class="none">'+i+'</a>'
              } else{
                pageHtml += '<a >'+i+'</a>';
              } 
            }                     
            if(curr != len ){
              pageHtml +='<a id="next" dataStatus="next">下一页&gt;&gt;</a>';
            }
            
            
            pageHtml += '</div>';
            self.pages.html(pageHtml);
        },
        pagesEvent:function(){//分页事件
            var self = this;
            self.pages = $(".pages");
            self.pages.on('click',function(e){//分页点击事件
              var target = e.target,
                    eleA = $(e.target),
                  status = eleA.attr('dataStatus'),
                     num = parseInt(eleA.text()),
                    numz = parseInt(self.pages.find('.none').eq(0).text());
                self.num = num;
              if(target.nodeName == 'A'){
                if(status == 'pre'){    
                	self.num = numz-1;        	 
                   	self.renderData({q:self.q,page:numz-1,pagesize:self.pagesize},numz-1);
                }else if(status == 'next'){
                	self.num = numz+1;
                    self.renderData({q:self.q,page:numz+1,pagesize:self.pagesize},numz+1);         
                }else{                   	              	
                  	self.renderData({q:self.q,page:num,pagesize:self.pagesize},num);
                }
              }
            }) 
        }
	//-------------------数据统计-------------------------------------------
	};
	rollcall.init();

//完成：
//1、新建上课
//2、点名
//3、重点
//4、取消点名
//5、新建课程成功刷新
//6、统计
//缺：
//1、
//2、编辑
//3、搜索课程
//

</script>

</html>