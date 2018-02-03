<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		*{
			margin:0;
			padding: 0;
		}
		#app,.afreshCallBox{
			width: 550px;
			height: 200px;			
		}
		.afreshCallBox{
			/*display: none;*/
		}
	</style>
	<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css">	
	<style>
		.ac_head{
			height: 36px;
			border-bottom: 1px solid #A9A9A9;
		}
		.ac_title{
	        float: left;
	        height: 36px;
	        width: 400px;
	        line-height: 36px;
	        font-size: 16px;
	        overflow: hidden;
	        text-overflow:ellipsis;
	        white-space: nowrap;
	        text-align: left;
	        text-indent: 20px;
	        font-weight: 600;
	        font-family: 'Microsoft YaHei';
	     }
		.ac_close{
			float: right;
			margin: 5px;
			padding: 0 4px;
			font-size: 24px;
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
		.ac_con{
			width: 500px;
			margin: 40px auto;
			font-size: 14px;
			line-height: 36px;
		}
		.text_r{
			text-align: right;
		}
		.class_foot{
			margin-top: 210px;
		}
		.ac_con .el-col{
	        position: relative;
	    }
		.prompt{
			position: absolute;
			bottom: -14px;
			left: 10px;               
			height: 13px;
			line-height: 13px;
			font-size: 13px;
			color: red; 
		}
	</style>
</head>
<body>
	<div id="app">
		
    	<div class="afreshCallBox">
			<div class="ac_head">
				<span class="ac_title">重新点名</span>
        		<span class="ac_close" @click="closeEvent">×</span>
			</div>
			<div class="ac_con">
				<el-row>
		          	<el-col :span="4" class="text_r">选择日期：</el-col>
			        <el-col :span="10" class="inp_right">
						<el-date-picker
							v-model="chooseDate"
							type="date"
							placeholder="选择日期"
							:picker-options="pickerDate">
						</el-date-picker>
						<span class="prompt" v-if="pro_chooseDate">请选择日期：</span>
			        </el-col>
			        <el-col :span="10" class="text_r inp_right ">
			              <el-time-select
			                placeholder="起始时间"
			                v-model="startTime"
			                :picker-options="{
			                  start: '08:30',
			                  step: '00:15',
			                  end: '18:30'
			                }">
			              </el-time-select>
			              <span class="prompt" v-if="pro_startTime">请选择时间</span>
			        </el-col>				
		        </el-row>
		        <el-row >
		          <el-col class="class_foot text_r">
		            <el-button @click="closeEvent">取消</el-button>
		            <el-button type="primary" @click="hanglePost">确定</el-button>
		          </el-col> 
		        </el-row>
	        </div>
    	</div>
	</div>
</body>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/vue/vue.min.js"></script>
<script src="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/index.js"></script>
<script>
	new Vue({
          el: '#app',
          data: function() {
              return {   
              	chooseDate:'',
              	startTime:'',
              	pro_chooseDate:false,
              	pro_startTime:false,
                pickerDate: {
                  disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7 || time.getTime() > Date.now() + 86400000  - 8.64e7;
                  }
                }
              }
          }, 
          created: function() {
            var self = this;
          },
          methods:{
          	closeEvent:function(){
          		parent.window.H.get('afreshCall').exec('close');
          	},
          	hanglePost:function(){
          		var self = this;
          		self.pro_chooseDate = false;
          		self.pro_startTime = false;
          		if(self.chooseDate == ''){
	                self.pro_chooseDate = true;
	                return false;                
	            }else if(self.startTime.length < 1){
	                self.pro_startTime = true; 
	                return false;
	            }

	            var dateline = (Date.parse(self.chooseDate)/1000)+self.startTime.split(':')[0]*3600+self.startTime.split(':')[1]*60,
            		rid = parent.window.$("#afreshCall").attr('rid'),
           			uid = parent.window.$("#afreshCall").attr('uid');

		            $.ajax({
		                type: "post",
		                url: "/troomv2/rollcall/call.html",
		                dataType: "json",
		                data:{
		                  rid:rid,
						  uid:uid,
						  isclear:0,
						  dateline:dateline
		                },
		                success:function(res){
		                	var code = res.code; 
		                	if(code < 1 ){	
		                		self.closeEvent();
		                		var inp_Search = parent.window.$('.inp_rightSearch').val(),
				    			Called = parent.window.$('.tab_on').attr('dataCalled');
		                		         		
								 self.renderRollCallList(rid,Called,inp_Search);
		                	}
		                }
		            })

          	},
          	renderRollCallList:function(rid,called,q){//渲染班级成员列表
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
	                			timeLi='<li>--</li>';
	                			toolLi='<li><b class="roCallBtn" datauid='+item.uid+'>点名</b></li>';
	                		}else{
	                			var time = new Date(item.dateline*1000),
                			    yyr = time.getFullYear()+'-'+((time.getMonth()+1)<10?"0"+(time.getMonth()+1):time.getMonth()+1)+'-'+(time.getDate()<10?"0"+time.getDate():time.getDate()),
                			    hms = (time.getHours()<10?"0"+time.getHours():time.getHours())+':'+(time.getMinutes()<10?"0"+time.getMinutes():time.getMinutes())+':'+(time.getSeconds()<10?"0"+time.getSeconds():time.getSeconds());

                				timeLi='<li><p>'+yyr+'</p><span>'+hms+'</span></li>';
	                			toolLi='<li><b class="isclear" datauid='+item.uid+'>取消</b></li>';
//	                			<b class="afreshCall" datauid='+item.uid+'>重点</b>
	                		}

	                		html+='<ul class="table_tr">'
								+   '<li>'+item.realname+'</li>'
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

			parent.window.$(".afreshCall").on('click',function(){//取消点名
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
		}
          }
        })
	$('.afreshCallBox').show();
</script>
</html>