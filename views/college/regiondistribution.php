<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>地域分布</title>
      <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css?v=20171120001"> 
      <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/community.css?v=20170525001" />
    </head>

  <style>
  .postedfa{
    min-height: 30px;
  }
  html{
    height: 100%;
    width: 100%;
    background: #f1f2f7;
    overflow-x: hidden;
    font-family: Microsoft YaHei;
  }
  body {
      overflow: auto;
      font-weight: 400;
      -webkit-font-smoothing: antialiased;
  }
  .h1{  /*主标题*/
    margin: 45px 0 15px 0;
    font-size: 18px;
    line-height: 24px;
    color: #1f2f3d;
  }
  .h2{ 
    /*标题介绍,副标题*/
    margin: 14px 0;
    font-size: 16px;
    line-height: 21px;
    color: #5e6d82;
  }
  .h3{
    /*内容*/
    margin: 14px 0;
    font-size: 14px;
    line-height: 19px;
    color:  #5e6d82;
  }
  .h5{
    font-size: 13px;
  }
  .h1big{
    font-size: 24px;
    line-height: 24px;
    color: #ff4949;
  }
  .h1lage{
    font-size: 17px;
    line-height: 20px;
  }
  .logo{
    text-align: center;
  }
  .f-fl{
    float: left;
  }
  .f-fr{
    float: right;
  }
  .f-mr10{
    margin-right: 10px;
  }
  .colorblue{
    color: #20a0ff;
  }
  .text-center{
    text-align: center;
  }
  .relative{
    position: relative;
  }
  .text-left{
    text-align: left;
  }
  .text-right{
    text-align: right;
  }
  .bottomnone{
    border-bottom: none;
  }
  .spacing15{
    margin-bottom: 12px;
  }
  .text-indent20{text-indent: 20px;}
  .text-indent30{text-indent: 30px;}
  .colorlump{border: 1px solid #eaeefb;}
  .navmore_avatar{
    position: relative;
      display: inline-block;
      vertical-align: middle;
      margin-right: 5px;
  }
  .infolist i{
    font-size: 24px;
    color: #97a8be;
  }
  .infolist i.icon-xinxi{
    font-size: 20px;
    line-height: 37px;
  }
  .infolist i.icon-iconlingdang{
    color: #20a0ff;
    font-size: 20px;
  }
  .infolist i.el-submenu__icon-arrow{
    display: none;
  }
  .infolist sup.el-badge__content{
    top: 10px;
    height: 15px;
      line-height: 15px;
      padding: 0 3px;
  }
  .infolist .el-badge__content.is-fixed{
    right: 12px;
  }
  .el-menu--horizontal .infolist>.el-menu{
    left: -12px;
  }
  .el-tabs__header{
    margin-bottom: 0;
  }

  .el-tabs__content{
    background: #fff;
  }
  .el-input__inner:hover,.el-textarea__inner:hover{
    box-shadow: 0px 0px 3px 2px #3399ff;
    border: 1px solid #3399ff;
  }
  .clear{
    clear: both;
  }
  .ellipsis{
    display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
  }

  .nodata{
    background: url(http://static.ebanhui.com/exam/images/nodata.png) no-repeat center;
    /*background: url(http://static.ebanhui.com/ebh/tpl/2016/images/nodata.png) no-repeat center;*/
      min-height: 500px;
      min-width: 300px;
      width: 100%;
  }
  .el-table__empty-block{
    min-height: 500px;
  }
  *{
    font-family: Microsoft YaHei;
  }

  .seachClean .el-icon-circle-close{
      display: none;
  }
  .seachClean:hover .el-icon-circle-close{
     display: block;
     cursor: pointer;
  }
  .el-table td>div {
      color: #666;
  } 
  .el-table .cell p{
    color: #666;
  }
  .regiondistribution {
    /*width: 980px;*/
    background: #fff;
    padding: 4px 10px 15px 10px;
  }
  
  .regiondistribution .el-input__inner:hover,
  .regiondistribution .el-textarea__inner:hover {
    box-shadow: 0px 0px 3px 2px #3399ff;
    border: 1px solid #3399ff;
  }
  
  .regiondistribution .searchbox {
    margin: 15px 5px;
  }
  
  .regiondistribution .el-tab-pane {
    width: 980px;
    box-sizing:border-box;
    -moz-box-sizing:border-box; /* Firefox */
    -webkit-box-sizing:border-box; /* Safari */
    
  }
  
  .regiondistribution .el-tabs__header {
    margin: 0;
    border: none;
  }
  
  .regiondistribution .el-tabs__content:hover {
    box-shadow: 0 0 8px 0 rgba(232, 237, 250, .6), 0 2px 4px 0 rgba(232, 237, 250, .5)
  }
  
  .regiondistribution .el-tabs__content {
    min-height: 850px;
    border: 1px solid #d1dbe5;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
  }
    .regiondistribution .pagination {
    margin: 0px 0 15px 0;
  }
  
  .regiondistribution .allchecked {
    position: absolute;
    left: 10px;
    bottom: 50px;
  }
  
  .regiondistribution .adddialog div.el-dialog {
    width: 500px;
  }
  
  .regiondistribution .el-tabs__content:hover {
    /*box-shadow:0 0 8px 0 rgba(232,237,250,.6),0 2px 4px 0 rgba(232,237,250,.5);*/
    box-shadow: 0 3px 5px rgba(232, 237, 250, .5);
  }
  
  .regiondistribution .delbox {
    margin: 0 10px;
    position: absolute;
    bottom: 15px;
  }
  
  .regiondistribution .searchbox button.el-button {
    /*margin-left: 10px;*/
    font-family: "Microsoft YaHei";
  }
  
  .regiondistribution .el-table .cell p {
    margin: 0;
    color: #666;
    text-decoration: none;
  }
  
  .regiondistribution .el-table .cell img {
    margin-top: 4px;
    float: left;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 5px;
  }
  .regiondistribution .dayselectbox .dayselects{
    margin-right: 15px;
  }
  .regiondistribution .dayselectbox .dayselect{
    padding: 5px 15px;
  }
  .regiondistribution .dayselectbox .dayselect span{
    color: #000000;
  }
  .regiondistribution .dayselectbox .dayselectactive{
    background:#20a0ff;
    
  }
  .regiondistribution .dayselectbox .dayselectactive span{
    color: #fff;
  }
  .regiondistribution .el-table .cell .sp{
    color: #ccc;
      display: inline-block;
      text-decoration: none;
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      height: 20px;
  }
  .regiondistribution .searchbox .el-select,.regiondistribution .searchbox .el-input{
    width: 135px;
  }
  .regiondistribution .searchbox .downbutton{
    width: 20px;
    text-align: center;
    padding: 10px 1px;
  }
  .regiondistribution .searchbox .downbutton span i{
    margin-left: 0;
  }
  .regiondistribution .realname{
      display:inline-block;
      max-width:97px;   
      height: 19px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  .regiondistribution .echarts {
      width: 450px;
      height: 360px;
  }
  .regiondistribution .nodata{
    min-height: 300px;
  }
  .regiondistribution .el-table__empty-block{
    min-height: 300px;
  }
  .regiondistribution .sys-table{
    margin: 10px 0;
    font-size: 16px;
  }
  .regiondistribution .sys-table-min{
    margin: 10px 0;
    color: #999999;
    font-size: 16px;
  }
  #loadin{
    height: 30px;
    width: 1000px;
    background: #fff;
  }
</style>
</head>
<body>
  <div class="postedfa postedfama">
      <div class="post-menu">
          <ul>
              <li><a href="/college/flowrate/view.html"><span>学习环境</span></a></li>
              <li class="workcurrent"><a href="/college/loginlog.html"><span>地域分布</span></a></li>   
          </ul>
      </div>
  </div>
  <div id="loadin"></div>
  <div id="regiondistribution" class="regiondistribution" style="display: none;" >

    <el-row class="el-tab-pane">
        <el-row class="sys-table">
          <span>我的学习环境</span>
        </el-row>
        <el-row class="sys-table-min">
          <span>我所在  <span style="font-weight: bold">{{pcityname}}</span>  ， IP  <span style="font-weight: bold">{{ip}}</span></span>
        </el-row>
        <el-row class="searchbox" style="margin-left: 2px;">
          <el-col class="dayselectbox" >
            <!-- <el-col :span="1" style="line-height: 34px;">
              <span>时间:  </span>
            </el-col> -->
            <el-col >
              <!-- <el-col :span="10">
                <div style="margin-top: 6px;">
                  <el-button @click="dayselect(1)" :class="dayselectactive == 1?'dayselect dayselectactive':'dayselect'" type="text">今天</el-button>
                  <el-button @click="dayselect(2)" :class="dayselectactive == 2?'dayselect dayselectactive':'dayselect'" type="text">昨天</el-button>
                  <el-button @click="dayselect(3)" :class="dayselectactive == 3?'dayselect dayselectactive':'dayselect'" type="text">最近7天</el-button>
                  <el-button @click="dayselect(4)" :class="dayselectactive == 4?'dayselect dayselectactive dayselects':'dayselect dayselects'" type="text">最近30天</el-button>
                </div>
              </el-col> -->
              <el-col  :span="21" style="text-align: right;">
                <el-date-picker
                    v-model="starttime"
                    type="date"
                    placeholder="选择开始日期"
                    :picker-options="pickerOptionsmaploginS"
                    @change="changemaploginS">
                 </el-date-picker>
                 
                  <el-date-picker
                    v-model="endtime"
                    type="date"
                    placeholder="选择结束日期"
                    :picker-options="pickerOptionsmaploginE"
                    @change="changemaploginE">
                  </el-date-picker>
              </el-col>
              <el-col :span="3" style="text-align: right;">
                <el-button type="primary" @click="serachtime" icon="search">搜索</el-button>
                <!-- <el-button-group>
                  <el-button type="primary" @click="reportoutselect">导出</el-button>
                  <el-button class="downbutton" type="primary"><i class="el-icon-caret-bottom el-icon--right"></i></el-button>
                </el-button-group> -->
               </el-col>
              
            </el-col>
          </el-col>
        
        </el-row>
        <el-row style="margin-bottom: 15px;">
          <el-col :span="12">
            <div class="echarts" id="echarts">
            </div>
          </el-col>
          <el-col :span="12">
            <el-table @row-click="wwwww"  :data="maplogindata" v-loading="loginlogloading"  max-height="360" height="360"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="width: 100%;">
              <div class="nodata" slot="empty"></div>
              <el-table-column prop="index" label="排名" sortable width="100">
              </el-table-column>
              <el-table-column prop="name"  label="省份" show-overflow-tooltip>
              </el-table-column>
              <el-table-column  prop="count"  label="登录人次" sortable>
              </el-table-column>
              <el-table-column prop="percent"  label="占比" sortable>
                <template scope="scope">
                  {{scope.row.percent}}%
                </template>
              </el-table-column>
            </el-table>
          </el-col>
        </el-row>
        <el-row style="margin-bottom: 15px;">
          <el-col>
            <el-table :data="maplogindatas" v-loading="loginlogloadings"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="width: 100%">
              <div class="nodata" slot="empty"></div>
              <el-table-column prop="index" label="排名" sortable width="100">
              </el-table-column>
              <el-table-column  prop="cityname"  label="城市（地级市）" sortable show-overflow-tooltip>
              </el-table-column>
              <el-table-column  prop="count"  label="登录人次" sortable>
              </el-table-column>
              <el-table-column prop="percent"   label="登录占比" sortable>
                <template scope="scope">
                  {{scope.row.percent}}%
                </template>
              </el-table-column>
              <el-table-column prop="ipcount"   label="IP数" sortable>
              </el-table-column>
              <!--<el-table-column   prop="signcount"  label="签到数" sortable>
              </el-table-column>-->

            </el-table>
          </el-col>
        </el-row>
        </el-row>
  </div>
</body>
  <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/vue/vue.min.js?v=20171120001"></script>
  <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/index.js?v=20171120001"></script>
  <script src="http://static.ebanhui.com/exam/js/vue-resource.min.js?v=20171120001"></script>
  <script src="http://static.ebanhui.com/ebh/js/echarts.min.js?v=20171120001"></script>
  <script src="http://static.ebanhui.com/exam/js/china.js?v=20171120001"></script>
  <script>
    window.host = ''
    new Vue({
      el: '#regiondistribution',
      data: function() {
        return {
          dayselectactive : 1,
          starttime : '',
          pcityname : '',
          ip:'',
          maplogindata : [], //省级数据
          maplogindatas : [],   //市级数据
          loginlogloading:false, //省级数据load
          loginlogloadings : false, //市级数据load
          endtime : '',
          groupid : '',
          starttimeparse : '',
          endtimeparse : '',
          pickerOptionsmaploginE: {
          },
          pickerOptionsmaploginS: {
          },
          getDateStr:function(AddDayCount) { 
            var dd = new Date(); 
            dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期 
            var y = dd.getFullYear(); 
            var m = dd.getMonth()+1;//获取当前月份的日期 
            var d = dd.getDate(); 
            return y+"-"+m+"-"+d; 
          },
          activeName : 'first',
          getregion:function(start,end){
            var self = this;
            self.$http.get(window.host+"/college/loginlog/distributelist.html", {params:{starttime:start,endtime:end}},{emulateJSON:true}).then(function(response){
                var data = response.data;
                if(data.code == 0){
                  var datas =  data.data;
                  for(var i=0;i<datas.length;i++){
                    datas[i].name = datas[i].cityname;
                    datas[i].value = datas[i].count
                    datas[i].index = i+1
                  }
                  self.maplogindata = datas;
                  setTimeout(function(){
                    self.initchart();
                  },0)
                  
                }
            }, function(response){
              console.log(response)
            });
          },
          getlogininfo:function(){
            var self = this;
            self.$http.get(window.host+"/logininfo.html", {params:{}},{emulateJSON:true}).then(function(response){
                
                self.ip = response.data.ip;
                if(response.data.pcityname == '局域网'){
                    self.pcityname = response.data.pcityname;
                }else{
                    self.pcityname = response.data.pcityname + '-' + response.data.cityname;
                }
                document.getElementById('loadin').style.display = 'none'
                document.getElementById('regiondistribution').style.display = 'block'
                
            }, function(response){
              console.log(response)
            });
          },
          
          addmaplogindatas:function(start,end,parentcode){
            var self = this;
            self.$http.get(window.host+"/college/loginlog/distributelist.html", {params:{starttime:start,endtime:end,citycode:parentcode}},{emulateJSON:true}).then(function(response){
                var data = response.data;
                if(data.code == 0){
                  var datas =  data.data;
                  for(var i=0;i<datas.length;i++){
                    datas[i].index = i+1
                  }
                  self.maplogindatas = datas;
                  setTimeout(function(){
                    parent.resetmain('sysss')      
                  },500)
                }
            }, function(response){
              console.log(response)
            });
          }
        }
      },
      mounted: function(){
        var self = this,start,end;
        
        self.endtime = new Date();
        start = (new Date(new Date().toLocaleDateString()).getTime()/1000)-86400*29;
        end = Date.parse(new Date())/1000;
        var newDate = new Date();
        newDate.setTime(start * 1000);
        self.starttime = newDate.toString()
        self.getregion(start,end);
        self.getlogininfo();
        var myChart = echarts.init(document.getElementById('echarts'));
        myChart.on('click', function (params) {
            if(params.data != undefined){
              if(params.data.parentcode !=  undefined){
                start = Date.parse(self.starttime)/1000;
                end = (Date.parse(self.endtime)/1000) + 86400 - 1;
                self.addmaplogindatas(start,end,params.data.parentcode);
              }else{
                self.maplogindatas = [];
                setTimeout(function(){
                  parent.resetmain('sysss')      
                },500)
              }
            }else{
              self.maplogindatas = [];
              setTimeout(function(){
                parent.resetmain('sysss')      
              },500)
            }
            
          });
        setTimeout(function(){
          parent.resetmain('sysss')      
        },1000)
      },
      created: function() {
        
      },
      methods: {
        wwwww(val){
          var self = this
          var start = '';
          var end = '';
           start = Date.parse(self.starttime)/1000;
          end = (Date.parse(self.endtime)/1000) + 86400 - 1;
          self.addmaplogindatas(start,end,val.parentcode);
        },
        serachtime(){
          var self = this;
          if(self.starttime == '' || self.endtime == '' ){
                      self.$notify({
                        title: '警告',
                        message: self.starttime == '' ? '请 "选择开始日期"':'请 "选择结束日期"',
                        type: 'warning'
                      })
                  }else{
                      self.dayselectactive = 0;             
                      var start = Date.parse(self.starttime)/1000;
                      var end = (Date.parse(self.endtime)/1000) + 86400 - 1;
                      setTimeout(function(){
              self.getregion(start,end);
            },0)
                  }
        },
        initchart(){
          var self = this,start,end;
          // 基于准备好的dom，初始化echarts实例
          var myChart = echarts.init(document.getElementById('echarts'));
          // 绘制图表
          var max = [];
          if(self.maplogindata.length){
            for(var i=0;i<self.maplogindata.length;i++){
              max.push(parseInt(self.maplogindata[i].count));
            }
          }
          myChart.setOption({
            backgroundColor: '#f3f3f3',
            tooltip: {
                  trigger: 'item',
                  formatter : function(param){
                      var params = param.data;
                      if(params == undefined){
                        return [
                                    '地域: 南海群岛<br/>',
                                    '登录人次: 0<br/>',
                                    '登录占比: 0%<br/>',
                              ].join('');
                      }else{
                        return [
                                    '地域: ' + params.name+ '<br/>',
                                    '登录人次: ' + (params.value||0) + '<br/>',
                                    '登录占比: ' + (params.percent||0) + '%<br/>',
                              ].join('');
                      }
                      
                  }
              },
              
              visualMap: {
                  min: 0,
                  max: Math.max(max) || 100,
                  left: 'left',
                  top: 'bottom',
                  text: ['高','低'],           // 文本，默认为数值文本
                  calculable: true,
                  color: ['#1d7af6','#3499f9','#1065a5','#b4e3f8','#5bccff']
              },
              series: [
                  { 
                      name: '中国',
                      type: 'map',
                      mapType: 'china',
                       roam: true,
                      label: {
                          normal: {
                              show: false,
                          },
                          emphasis: {
                              show: false,
                          }
                      },
                      itemStyle: {
                          normal: {
                            //borderColor:'#686868',//省份的边框颜色
    
                          },
                           emphasis: {
                            areaColor: '#eab81e',
                            //shadowColor:'#5bccff',
                            //shadowOffsetY : 1,
                            //shadowOffsetX :　1
                        }
                      },
                      data:self.maplogindata
                  }
              ]
          });
          
        },
        changemaploginS(){
          var self = this;
                self.pickerOptionsmaploginE = {
                    disabledDate(time) {
                        var interval = time.getTime() > Date.parse(new Date());
                        return interval;
                    }
                }
        },
        changemaploginE(){
          var self = this;                
                self.pickerOptionsmaploginS = {
                    disabledDate(time) {
                        var interval = time.getTime() > Date.parse(new Date());
                        return interval;
                    }
                }
        }
      },
      watch: {

      }
    })
  </script>
</html>