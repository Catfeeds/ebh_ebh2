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
        height: 500px;
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
      .text_l{
        text-align: left;
        line-height: 30px;
        font-size: 15px;
      }   
      .text_l span{
        color: red;
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
      
      .partakeBox{
        margin:0 auto;
        width:660px;
        height: 318px;
        border: 1px solid #A9A9A9; 
        border-radius: 4px;
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
   </style>
   <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/xtree/iconfont.css">
   <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css"> 
   <style content="leftTree">
      .leftTree {
          float: left;
          width: 180px;
          height: 320px;
          border-right: 1px solid #A9A9A9; 
          overflow-y:auto;
      }
      .leftTree div a.curr, .leftTree div a:hover{
          background: none ;
          border-radius: 2px;
          color: #2c71ae;
          font-size: 14px;
          padding:3px;
      }
      .leftTree div a {
          color: #2c71ae;
          font-size:14px;
      }
      .leftTree div {
          float: left;
          height: 25px;
          line-height: 22px;
          overflow: hidden;
          padding: 0 15px 0 10px;
      }

      #classchoose2{
          height: auto;
          overflow: visible; 
      }
      .organize li .tr{
          height: 30px;
          min-width: 100%;
          width: 100%;
          overflow: visible;
          white-space: nowrap;
      }
      .organize li .ban{ 
        cursor:not-allowed!important;
      }
      .organize li .ban a{ 
        color: #ccc;       
        cursor:not-allowed!important;
      }
      .organize li .on{
        background:#92caf8;
      }
      .organize ul{
         overflow: visible;
      }
      .organize li .tr .cname{
        padding-left: 3px;
         width: auto;
      }
      .rightMan{
        position: relative;
        float: left;
        width: 478px;
        height: 320px;
        overflow-y: auto;

      }
      .partakeBox{
        position: relative;
      }
      .botCheckAll{
        position: absolute;
        bottom: -26px;
        left: 185px;
      }
      .rightMan .el-checkbox{
        height: 25px;
        margin: 5px 5px;
      }
      .rightMan .el-checkbox__input{
        float: left;
        margin-top:4px;
      }
      .rightMan .el-checkbox__label{
        display: inline-block;
        width: 80px;
        line-height: 25px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
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
   <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
</head>
<body>     
    <div class="nc_body" id="appaddUser" style="opacity: 0">
    	
      <div class="nc_head">
        <span class="nc_title">{{iframeTit}}</span>
        <span class="nc_close" @click="closeEvent">×</span>
      </div>
      
      <div class="class_form" >
        <el-row>
          <el-col :span="4" class="text_r" >参与人员：</el-col>  
          <el-col :span="9" class="text_l inp_right " >
          已选择(<span class="chooseCount">{{chooseCount}}</span>)
          <span class="prompt" v-if="pro_count">请选择参与人员</span>
          </el-col>          
          <el-col :span="9" class="text_r inp_right ">
            <el-input v-model="inp_searchStaff"  icon="search" @change="hangleChangeSreach" placeholder="请输入搜索关键字"></el-input>            
          </el-col>
          <!--<el-col :span="3" class="text_r" style="margin-top: 1px;">
            <el-button type="primary" @click="hangleChangeSreach">搜索</el-button>
          </el-col> -->
        </el-row>
        
        
        <el-row>
          <div class="partakeBox">
            <div class="leftTree">
              <div id="classchoose2" class="organize"></div>
            </div>
            <div class="rightMan">
                <el-checkbox-group v-model="checkedStudents" @change="handleCheckedStudentsChange">
                  <el-checkbox v-for="single in students" :label="single" :key="single">{{single.realname?single.realname:single.username}}</el-checkbox>
                </el-checkbox-group>                                
            </div>
            <div class="botCheckAll">
                  <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
            </div>
          </div>
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
    var bindClass1 = new Vue({
          el: '#appaddUser',
          data: function() {
             return { 
                iframeTit:'报名',
                chooseCount:0,//已选择人数 
                pro_count:false,//选择参与人员提示
                inp_searchStaff:'',
                
                checkedStudents:[],
                students:[],
                saveStudent:[],
                cacheStudents:{},
                isIndeterminate:false,
                checkAll:false,
                defaultClassid:0,
                ajaxTree:function(obj){//异步获取并渲染左侧部门树
                  var self = this;
                  $.ajax({
                      type: "GET",
                      url: "/troomv2/enterprise/department.html",
                      dataType: "json",
                      data:obj,
                      success:function(data){
                        var arr = data.data,
                           arrz = [],
                           obj  = {'0':'true'};

                          diedai(arr,obj);
                          readerData(arrz);                       
                          function readerData(arr){ //渲染左侧部门树
                              $("#classchoose2").html('');                          
                              for(var i = 0,len = arr.length; i < len; i++){
                                var superior = arr[i].superior,
                                     classid = arr[i].classid,
                                   classname = arr[i].classname,                                   
                                    haspower = arr[i].haspower,                              
                                          li = '';

                                  if( superior == 0 ){                             
                                      li='<li class='+classid+' >'
                                        +  '<div class="tr '+(haspower?"":"ban")+'" isclassid="'+classid+'">'
                                        +    '<i></i><i class=" img-section"></i><a class="cname" >'+classname+'</a>'
                                        +  '</div>'
                                        +'</li>';
                                      $("#classchoose2").append(li);                      
                                  }else{                           
                                      if($("."+superior+'>ul').length < 1){
                                          $("."+superior).find('i').eq(0).addClass('iconfont icon-sanjiao-open');
                                          li ='<ul>'
                                             +  '<li class='+classid+' >'
                                             +   '<div class="tr '+(haspower?"":"ban")+'" isclassid="'+classid+'">'
                                             +    '<i></i><i class=" img-organize"></i>'
                                             +     '<a class="cname" >'
                                             +     classname+'</a>'
                                             +   '</div>'
                                             +  '</li>'
                                             +'</ul>';
                                          $("."+superior).append(li); 
                                      }else{
                                          li ='<li class='+classid+' >'
                                             + '<div class="tr '+(haspower?"":"ban")+'" isclassid="'+classid+'">'
                                             +  '<i></i><i class=" img-organize"></i>'
                                             +   '<a class="cname" >'
                                             +   classname+'</a>'
                                             + '</div>'
                                             +'</li>';
                                          $("."+superior+">ul").append(li );  
                                      }
                                  }
                              }
                              var tr1 = $('.tr').eq(1);
                              tr1.addClass('on');
                              self.defaultClassid = tr1.attr('isclassid')
                              self.ajaxData(self.defaultClassid);                              
                              $("#classchoose2").find('.iconfont').click(function(e){ //部门树显示或收缩事件
                                  var s = $(this),
                                  classname = s[0].classList[1];
                                  s.removeClass(classname);
                                  if( classname == 'icon-sanjiao-close' ){
                                      s.addClass('icon-sanjiao-open');
                                      s.parent().nextAll('ul').css('display','block');       
                                  }else{
                                      s.addClass('icon-sanjiao-close'); 
                                      s.parent().nextAll('ul').css('display','none'); 
                                  }
                              })

                              var tr =  $('.tr');
                              tr.on('click',function(){//部门树点击右侧根据条件显示员工列表                                 
                                  var $classid = $(this).attr('isclassid'),
                                           ban = $(this).hasClass('ban');
                                  if(!ban){
                                    tr.removeClass('on');
                                    $(this).addClass('on'); 
                                  }
                                  
                                                 
                                  if(self.classid!= $classid&&!ban){
                                    self.classid = $classid;
                                    self.ajaxData($classid);
                                  }
                                  // self.getClass = $(this).attr('isclassid');
                              })
                          }
                          function diedai(arr,supobj){//迭代返回数组
                            var objfor = [];       
                            if(arr.length == arrz.length) return false;
                            for(var i = 0,len = arr.length; i < len; i++ ){        
                              var superior = arr[i].superior,
                                   classid = arr[i].classid;
                              if(supobj[superior]){
                                  arrz.push(arr[i]);             
                                  objfor[classid] = true;
                              }          
                            }       
                            diedai(arr,objfor);
                          }
                      }
                  });
                },
                ajaxData:function(key){
                  var self = this;
                  $.ajax({
                    type: "GET",
                    url: "/troomv2/enterprise/binduser.html",
                    dataType: "json",
                    data:{
                      bind:0,
                      classid:key,
                      page:1,
                      pagesize:1000
                    },
                    success:function(res){
                      var arr = res.data.userlist;
                      self.students = arr;
                      self.saveStudent = arr;
                      self.checkedStudents = [];
                      for(var i = 0,len = arr.length; i < len; i++ ){
                          var item = arr[i],
                               uid = item.uid;
                            if(self.cacheStudents[uid]){
                              self.checkedStudents.push(item)
                            }
                      }
                     
                      if(self.checkedStudents.length == 0){
                        self.isIndeterminate = false;
                        self.checkAll = false;
                      }else if(self.checkedStudents.length == arr.length){
                        self.isIndeterminate = false;
                        self.checkAll = true;                        
                      }else{
                        self.isIndeterminate = true;
                        self.checkAll = false;
                      }
                    }
                  })
                },
             }
          },
          created: function() {
            var self = this;            
            self.ajaxTree();
            if(location.href.indexOf('edit')>-1){
              self.iframeTit = '编辑报名';
              	self.setIntervalEvent();
            }
          },
          methods:{
          	setIntervalEvent:function(){
              var self = this;
              var inteditdata =  setInterval(function(){
                var rid = window.parent.$("#addUserifedito").attr('rid');
                if(rid){
                  $.ajax({
                    type: "get",
                    url: "/troomv2/rollcall/rolllist.html",
                    dataType: "json",
                    data:{
                      rid:rid,page:1,pagesize:1000
                    },
                    success:function(res){
                      // self.chooseCount = res.data.rollcount;
                      self.hangleCacheStudents(res.data.rolllist,[]);
                      var arr = self.students;
                      self.checkedStudents = [];
                      for(var i = 0,len = arr.length; i < len; i++ ){
                          var item = arr[i],
                               uid = item.uid;
                            if(self.cacheStudents[uid]){
                              self.checkedStudents.push(item)
                            }
                      }
                     
                      if(self.checkedStudents.length == 0){
                        self.isIndeterminate = false;
                        self.checkAll = false;
                      }else if(self.checkedStudents.length == arr.length){
                        self.isIndeterminate = false;
                        self.checkAll = true;                        
                      }else{
                        self.isIndeterminate = true;
                        self.checkAll = false;
                      }                     
                    }
                  })
                  clearInterval(inteditdata);
                }
              },1000)
            },
            closeEvent:function(){
            	var self = this;
            	parent.window.H.get('addUser').exec('close');
            	parent.window.H.get('addUseredit').exec('close');
            	parent.window.$('#addUserifedito').attr('rid','');
            	self.chooseCount = 0;
	            self.cacheStudents = {};
	            self.checkedStudents = [];
	            self.isIndeterminate = false;
	            self.checkAll = false; 
	          	if(location.href.indexOf('edit')>-1){
                 self.setIntervalEvent();
              }   
            },
            hangleCacheStudents(stu,stuAll){//本地保存
              var self = this;             
              for(var j = 0,jen = stuAll.length; j < jen; j++){
                var uid = stuAll[j].uid;
                delete self.cacheStudents[uid];                    
              }

              for(var i = 0,len = stu.length; i < len; i++){
                var item = stu[i],
                     uid = item.uid;
                self.cacheStudents[uid] = item;                    
              }

              var count = 0;
              for(var z in self.cacheStudents){
                count++;
              }
              self.chooseCount = count;
            },
            hangleChangeSreach(val){
              var self = this,
                   arr = [];
                          
              for(var i = 0,len = self.saveStudent.length;i < len; i++){
                var item = self.saveStudent[i];               
                if(item.realname.indexOf(val)>-1||item.username.indexOf(val)>-1){
                  arr.push(item);
                }
              }
              self.students = arr;
           },
           handleCheckedStudentsChange:function(value){//单选
            	"use strict";
              var self = this;
              let checkedCount = value.length;
              self.checkAll = checkedCount === self.students.length;
              self.isIndeterminate = checkedCount > 0 && checkedCount < self.students.length;
              self.hangleCacheStudents(value,self.students);
           },
           handleCheckAllChange:function(event){//全选
              var self = this;
              self.checkedStudents = event.target.checked ? self.students : [];
              self.isIndeterminate = false;
              if(event.target.checked){
                self.hangleCacheStudents(self.students,self.students);
              }else{
                self.hangleCacheStudents([],self.students)
              }
           },
           hanglePost:function(){
              	var self = this,uida =[],uids='';
              	var rid;
              	if(location.href.indexOf('edit')>-1){
		             	rid = window.parent.$("#addUserifedito").attr('rid');
		            }else{
		            	rid = window.parent.$("#addUserif").attr('rid');
		            }
              	for( var i in self.cacheStudents){
                	uida.push(i);
              	}
              	uids = uida.join(",");
	            $.ajax({
	              type: "post",
	              url: "/troomv2/rollcall/adduser.html",
	              dataType: "json",
	              data:{
	              	rid:rid,
	                uids:uids,
	              },
	              success:function(res){                    
	                var code = res.code;
	                if(code == 0){
	                  self.closeEvent();
	                  if(location.href.indexOf('edit')>-1){
				              parent.window.H.get('succesEditDialog').exec('show');
				            }else{
				            	parent.window.H.get('succesupDialog').exec('show');
				            }
	                  
	                }else{
	                	parent.window.H.get('failAllDialog').exec('show');
	                }
	              }
	            })
            },    
         }
      }) 
      $(".nc_body").css('opacity',1);    
    </script>
</body>
</html>
