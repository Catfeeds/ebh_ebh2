<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
   <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css">
   <style>
      *{
        margin: 0;
        padding: 0;
      }
      .nc_body{
        width: 698px;
        height: 330px;
        overflow: hidden;
        font-family: 'Microsoft YaHei';
      }
      .nc_head{
        height: 36px;
        border-bottom: 1px solid #A9A9A9;
      }
      .nc_title{
        float: left;
        height: 36px;
        width: 450px;
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
      .nc_close{
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
      .text_r{
        text-align: right;
        line-height: 30px;
        font-size: 15px;
      }
      .inp_right{
        padding-left: 8px;
      }
      .class_form .el-row{        
        margin:20px 0;
      }
      .class_form .el-input__inner{
        height: 30px;
        line-height: 30px;
      }
      .class_form .el-button{
        float: left;
        padding: 0 15px;
        margin-left: 5px;
        height: 30px;
        line-height: 30px;
        
      }
      
      .class_foot {
        padding-right: 20px;
      }
      .class_foot .el-button{
        float: none;

      }
      .el-select, .el-cascader, .el-row .el-col .el-date-editor{
        width: 100%;
      }
      
      .class_form .el-col{
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
   <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/xtree/iconfont.css">
   <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css"> 
   <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
</head>
<body>     
    <div class="nc_body" id="app" style="opacity: 0">
    	
      <div class="nc_head">
        <span class="nc_title">{{iframeTit}}</span>
        <span class="nc_close" @click="closeEvent">×</span>
      </div>
      
      
      <div class="class_form" >
      	
        <el-row>
          <el-col :span="4" class="text_r">标题：</el-col>
          <el-col :span="18" class="inp_right">
            <el-input v-model="inp_title" placeholder="请输入标题"></el-input>
            <span class="prompt" v-if="pro_title">请输入标题</span>
            <span class="prompt" v-if="pro_titleLen">标题不能超过20个字</span>
          </el-col>          
        </el-row>
        
        
        <el-row>
          <el-col :span="4" class="text_r">课程/课件：</el-col>
          <el-col :span="9" class="inp_right">
          	
          	
          	<el-select v-model="selectedOptions" placeholder="请先选择课程" @change="handleChange">
					    <el-option
					      v-for="item in curriculum"
					      :key="item.itemid"
					      :label="item.iname"
					      :value="item.itemid">
					    </el-option>
					  </el-select>
            
            <span class="prompt" v-if="pro_curriculum">请先选择课程</span>
          </el-col>
          
          <el-col :span="9" class="inp_right">
            <el-select v-model="courseName" placeholder="请选择课件" :disabled="couNamebloo" @change="courseNamechange">
              <el-option-group
                v-for="group in Courseware"
                :key="group.value"
                :label="group.label"
                :value="group.value">
                <el-option
                  v-for="item in group.options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-option-group>
            </el-select>
            <span class="prompt" v-if="pro_courseName">请选择课件</span>      
          </el-col>
        </el-row>
        
        
        
        <el-row>
          <el-col :span="4" class="text_r">选择日期：</el-col>
          <el-col :span="9" class="inp_right">
             <el-date-picker
                v-model="chooseDate"
                type="date"
                placeholder="选择日期"
                :picker-options="pickerDate"
                @change="changeDateEvent">
              </el-date-picker>
              <span class="prompt" v-if="pro_chooseDate">请选择日期：</span>
          </el-col>
        </el-row>
        
        <el-row>
          <el-col :span="4" class="text_r">选择时间：</el-col>
          <el-col :span="9" class="text_r inp_right ">
              <el-time-select
                :disabled="pastTimeshow"
                placeholder="起始时间"
                v-model="startTime"
                :picker-options="{
                  start: '00:00',
                  step: '00:30',
                  end: '24:00',
                  minTime: pastTime
                }">
              </el-time-select>
              <span class="prompt" v-if="pro_startTime">请选择起始时间</span>
          </el-col>
          <!--<el-col :span="9" class="text_r inp_right ">
              <el-time-select
                :disabled="pastTimeshow"
                placeholder="结束时间"
                v-model="endTime"
                :picker-options="{
                  start: '00:00',
                  step: '00:30',
                  end: '24:00',
                  minTime: startTime
                }">
              </el-time-select>
              <span class="prompt" v-if="pro_endTime">请选择结束时间</span>
          </el-col>-->
        </el-row>
        
        
        <el-row >
          <el-col class="class_foot text_r">
            <el-button @click="closeEvent">取消</el-button>
            <el-button type="primary" @click="hanglePost">确定</el-button>
          </el-col> 
        </el-row>
      </div>  
    </div>
    <script src="http://static.ebanhui.com/ebh/js/vue/vue.min.js"></script>
    <script src="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/index.js"></script>
    <script>    
    	var bindClass = new Vue({
          el: '#app',
          data: function() {
              return { 
                iframeTit:'新建计划',
                editdata:'',
                inp_title:'',	//标题
                pro_title:false,//标题未输入提示
                pro_titleLen:false,//标题字数长度提示
                
                curriculum:[],
                selectedOptions:[],
                pro_curriculum:false,//选择课程提示
                
                
                courseName:'',
                courseName1:'',
                couNamebloo:true, //先选择课程后才能选择课件
                
                Courseware:[],
                pro_courseName:false,//选择课件提示
                
                chooseDate:'',
                pickerDate: {
                  disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7;
                  }
                },
                pro_chooseDate:false,
                
                
                pastTimeshow:true,
                pastTime:'',
                startTime: '',
                endTime: '',
                
                pro_startTime:false,//提示
                pro_endTime:false,//提示
                
//              courseSortData:function(){//选择课程 cascader
//                var self = this;
//                  $.ajax({
//                      type: "get",
//                      url: "/aroomv3/course/coursesort.html",
//                      dataType: "json",
//                      data:{
//                        showbysort:0
//                      },
//                      success:function(res){                           
//                        var obj = [],
//                            arr = res.data;
//                        for(var i = 0,len = arr.length; i < len; i++){
//                            var item = arr[i],
//                            itemcountP = parseInt(item.itemcount, 10),
//                            items = {
//                              label:item.pname,
//                              value:'pid|'+item.pid,
//                              children:[],
//                              pid:item.pid
//                            };
//
//                            if(item.sorts){
//                              for(var j =0,jen = item.sorts.length; j < jen; j++){
//                                var jtem = item.sorts[j],
//                                    itemcountP = itemcountP - parseInt(jtem.itemcount, 10), 
//                                    jtems = {
//                                      label:jtem.sname,
//                                      value:'sid|'+jtem.sid,
//                                      children:[],
//                                      sid:jtem.sid
//                                    };
//                                if(jtem.itemcount > 0){
//                                  items.children.push(jtems);
//                                }
//                              }                                
//                            } 
//                            if(itemcountP > 0){
//                                items.children.push({label:'其它',value:'pid|'+item.pid,children:[],sid:item.pid});
//                              }
//                          if(item.itemcount > 0){
//                            obj.push(items);
//                          }                         
//                        }
//                        self.curriculum = obj;
//                      }
//                  })
//              },
                courseSortData:function(){
                	var self = this;
                	$.ajax({
                        type: "get",
                        url: "/troomv2/enterprise/teachercourse.html",
                        dataType: "json",
                        success:function(res){
                          self.curriculum = res.data.courselist;
                        }
                  })
                },
                cwlistData:function(folderid){//选择课件
                  var self = this;
//                if(location.href.indexOf('edit')>-1){
//                	self.courseName = self.courseName1;
//                }else{
//                	self.courseName = '';
//                }
                  $.ajax({
                    type: "get",
                    url: "/aroomv3/course/cwlist.html",
                    dataType: "json",
                    data:{
                      folderid:folderid,
                      page:1,
                      pagesize:1000
                    },
                    success:function(res){                          
                      var cwlist = res.data.cwlist,
                          optionData= [];
                      for(var i = 0,len = cwlist.length; i < len; i++){
                        var item = cwlist[i],
                        itemC = {
                            label:item.sname,
                            value:item.sid,
                            options:[]
                        }
                        for(var j =0,jen = item.cwlist.length;j < jen;j++){
                          var jtem = item.cwlist[j];
                          itemC.options.push({
                            label:jtem.title,
                            value:jtem.cwid
                          });
                        }
                        optionData.push(itemC);
                      }
                      self.Courseware = optionData;
                    }
                  })  
                }
             }
          },
          created: function() {
          	var self = this;
//        	self.courseSortData();
          	self.courseSortData();
          	if(location.href.indexOf('edit')>-1){
              self.iframeTit = '编辑点名课程';
              self.setIntervalEvent();
            }
          },
          methods:{
          	setIntervalEvent:function(){
              var self = this;              
              var inteditdata =  setInterval(function(){
                var editdata = parent.window.$('#editClass').attr('editdata');               
                if(editdata){
                  self.editdata = editdata;
                  $.ajax({
                    type: "GET",
                    url: "/troomv2/rollcall/lists.html",
                    dataType: "json",
                    data:{
                      rid:editdata
                    },              
                    success:function(res){
                      var item = res.data.cwlist[0];
                      self.inp_title = item.rname;
                      self.selectedOptions = item.itemid;
											self.courseName = item.cwid;
                      self.chooseDate = new Date(item.starttime*1000);
                      var stime = new Date(item.starttime*1000);
                      self.startTime = (stime.getHours()<10?"0"+stime.getHours():stime.getHours())+':'+(stime.getMinutes()<10?"0"+stime.getMinutes():stime.getMinutes());
//                    var etime = new Date(item.endtime*1000);                     
//                    self.endTime = (etime.getHours()<10?"0"+etime.getHours():etime.getHours())+':'+(etime.getMinutes()<10?"0"+etime.getMinutes():etime.getMinutes());
                    }
                  })
                  clearInterval(inteditdata);
                }
              },1000)
            },
            //关闭需要处理
            closeEvent:function(){
              var self = this;
              parent.window.H.get('newClass').exec('close');
              parent.window.H.get('editClass').exec('close');
              parent.window.$('#editClass').attr('editdata','');
              self.inp_title = '';
              self.courseName = '';
              self.chooseDate = '';
              self.selectedOptions = [];             
              self.startTime = '';
              self.endTime = '';
              self.editdata = '';
              
              self.pro_title = false;
              self.pro_curriculum = false;
              self.pro_courseName = false;
              self.pro_chooseDate = false;
              self.pro_startTime = false;
              self.pro_endTime = false;
              
              if(location.href.indexOf('edit')>-1){
                 self.setIntervalEvent();
              }
            },
            //选择课程
            handleChange:function(val){
            	var self = this,folderid;
            	for(var i=0,len=self.curriculum.length;i<len;i++){
            		if(val == self.curriculum[i].itemid){
            			folderid = self.curriculum[i].folderid;
            		}
            	}
              if(self.selectedOptions.length > 0){
                self.couNamebloo= false;
                self.cwlistData(folderid);
              }else{
                self.couNamebloo = true;
              } 
            },
           	
            changeDateEvent:function(val){
              var self = this,t;
              if(self.chooseDate){
                self.pastTimeshow = false;
                t = self.chooseDate,
                y = t.getFullYear(),
                m = t.getMonth()+1,
                d = t.getDate(),
                n = new Date(),
                ny = n.getFullYear(),
                nm = n.getMonth()+1,
                nd = n.getDate(),
                hs = n.getHours()<10?'0'+n.getHours():n.getHours(),
                ms = n.getMinutes()<10?'0'+n.getMinutes():n.getMinutes();
               
                if(y == ny&&m == nm&&d == nd){
                  self.pastTime = hs+":"+ms;
                }else{
                  self.pastTime = '';
                }
              }else{
                self.pastTimeshow = true;
                self.pastTime = '';
              }
            },
            courseNamechange(val){
            	var self = this;
            	self.courseName = val;
            },
            hanglePost:function(){
              var self = this,start,end;
              if(self.inp_title == ""){
              	self.pro_title = true;
              }else{
              	self.pro_title = false;
              }
              if(self.selectedOptions.length == 0){
              	self.pro_curriculum = true;
              }else{
              	self.pro_curriculum = false;
              }
              if(self.courseName == ""){
          			self.pro_courseName = true;
          		}else{
          			self.pro_courseName = false;
          		}
              if(self.chooseDate == ""){
              	self.pro_chooseDate = true;
              }else{
              	self.pro_chooseDate = false;
              }
              if(self.startTime == ""){
              	self.pro_startTime = true;
              }else{
              	self.pro_startTime = false;
              }
//            if(self.endTime == ""){
//            	self.pro_endTime = true;
//            }else{
//            	self.pro_endTime = false;
//            }
              
              if(!self.pro_title && !self.pro_curriculum && !self.pro_courseName && !self.pro_chooseDate && !self.pro_startTime){
		            	if(location.href.indexOf('edit') < 0){
			            	start = (Date.parse(self.chooseDate)/1000)+ self.startTime.split(':')[0]*3600+self.startTime.split(':')[1]*60;
//			            	end = (Date.parse(self.chooseDate)/1000)+ self.endTime.split(':')[0]*3600+self.endTime.split(':')[1]*60; 
			            	$.ajax({
			                  type: "post",
			                  url: "/troomv2/rollcall/add.html",
			                  dataType: "json",
			                  data:{
			                  	rname:self.inp_title,
			                  	itemid:self.selectedOptions,
			                    cwid:self.courseName,
			                    starttime:start
			                  },
			                  success:function(res){                    
			                    var code = res.code;
			                    if(code == 0){
			                      self.closeEvent();
			                      parent.window.H.get('succesDialog').exec('show');
			                    }
			                  }
			              })
			            }else{
			            	var datastring = new Date(self.chooseDate).getFullYear()+'/'+(new Date(self.chooseDate).getMonth()+1)+'/'+ new Date(self.chooseDate).getDate();
		              
			              start = (Date.parse(new Date(datastring))/1000)+ self.startTime.split(':')[0]*3600+self.startTime.split(':')[1]*60;
//			              end = (Date.parse(new Date(datastring))/1000)+ self.endTime.split(':')[0]*3600+self.endTime.split(':')[1]*60; 
			             
			              var editdata = parent.window.$('#editClass').attr('editdata');
			              $.ajax({
			                type: "post",
			                url: "/troomv2/rollcall/edit.html",
			                dataType: "json",
			                data:{
			                  rid:editdata,
			                  rname:self.inp_title,
			                  itemid:self.selectedOptions,
			                  cwid:self.courseName,
			                  starttime:start
			                },
			                success:function(res){                    
			                  var code = res.code;
			                  if(code == 0){
			                    self.closeEvent();
			                    parent.window.H.get('succesEditDialog').exec('show');
			                  }
			                }
			              })
			          	}
              }else{
              	return false;
              }
            },           
          }
        }) 
      $(".nc_body").css('opacity',1); 
    </script>
</body>
</html>
