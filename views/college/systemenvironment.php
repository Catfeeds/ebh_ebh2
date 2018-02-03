<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>学习环境</title>
      <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/theme-default/index.css?v=20171120001"> 
      <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/community.css?v=20170525001" />     
    </head>
  <style>
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
  .systemenvironment {
    width: 1000px;
    padding: 4px 0px 15px 0px;
    background: #fff;
  }
  .systemenvironment .el-input__inner:hover,
  .systemenvironment .el-textarea__inner:hover {
    box-shadow: 0px 0px 3px 2px #3399ff;
    border: 1px solid #3399ff;
  }
  
  .systemenvironment .searchbox {
    margin: 15px 5px;
  }
  
  .systemenvironment .el-tab-pane {
    padding: 0 20px;
    width: 940px;
  }
  
  .systemenvironment .el-tabs__header {
    margin: 0;
    border: none;
  }
  
  .systemenvironment .el-tabs__content:hover {
    box-shadow: 0 0 8px 0 rgba(232, 237, 250, .6), 0 2px 4px 0 rgba(232, 237, 250, .5)
  }
  
  .systemenvironment .el-tabs__content {
    min-height: 850px;
    border: 1px solid #d1dbe5;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
  }
    .systemenvironment .pagination {
    margin: 0px 0 15px 0;
  }
  
  .systemenvironment .allchecked {
    position: absolute;
    left: 10px;
    bottom: 50px;
  }
  
  .systemenvironment .adddialog div.el-dialog {
    width: 500px;
  }
  
  .systemenvironment .el-tabs__content:hover {
    /*box-shadow:0 0 8px 0 rgba(232,237,250,.6),0 2px 4px 0 rgba(232,237,250,.5);*/
    box-shadow: 0 3px 5px rgba(232, 237, 250, .5);
  }
  
  .systemenvironment .delbox {
    margin: 0 10px;
    position: absolute;
    bottom: 15px;
  }
  
  .systemenvironment .searchbox button.el-button {
    /*margin-left: 10px;*/
    font-family: "Microsoft YaHei";
  }
  
  .systemenvironment .el-table .cell p {
    margin: 0;
    color: #666;
    text-decoration: none;
  }
  
  .systemenvironment .el-table .cell img {
    margin-top: 4px;
    float: left;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 5px;
  }
  .systemenvironment .dayselectbox .dayselects{
    margin-right: 15px;
  }
  .systemenvironment .dayselectbox .dayselect{
    padding: 5px 15px;
  }
  .systemenvironment .dayselectbox .dayselect span{
    color: #000000;
  }
  .systemenvironment .dayselectbox .dayselectactive{
    background:#20a0ff;
    
  }
  .systemenvironment .dayselectbox .dayselectactive span{
    color: #fff;
  }
  .systemenvironment .el-table .cell .sp{
    color: #ccc;
      display: inline-block;
      text-decoration: none;
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      height: 20px;
  }
  .systemenvironment .searchbox .el-select,.systemenvironment .searchbox .el-input{
    width: 135px;
  }
  .systemenvironment .searchbox .downbutton{
    width: 20px;
    text-align: center;
    padding: 10px 1px;
  }
  .systemenvironment .searchbox .downbutton span i{
    margin-left: 0;
  }
  .systemenvironment .realname{
      display:inline-block;
      max-width:97px;   
      height: 19px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
  }
  .systemenvironment .resolution, .systemenvironment .provider{
    width: 900px;
    height: 500px;
  }
  .systemenvironment .echarts {
      height: 320px;
      width: 470px;
  }
  .systemenvironment .equipment{
      text-align: center;
  }
  .systemenvironment .equipment span.pc{
      background: url(http://static.ebanhui.com/exam/images/pc-icon.png) no-repeat;
      background-size: 12%;
      background-position-x: 185px;
  }
  .systemenvironment .equipment span.phone{
      background: url(http://static.ebanhui.com/exam/images/phone-iocn.png) no-repeat;
      background-size: 12%;
      background-position-x: 185px;
  }
  .systemenvironment .equipment span{
      display: block;
      padding-left: 65px;
      height: 60px;
      line-height: 60px;
      color: #3399FF;
      font-size: 18px;
      font-weight: bold;
      
  }
  .systemenvironment .equipmentnum{
      padding-left: 180px;
  }
  .systemenvironment .equipmentnum span{
      color: #3399FF;
  }
  .systemenvironment .sys-table{
    margin: 10px 0;
    font-size: 16px;
  }
  .systemenvironment .sys-table span{
    margin-left: 15px;
  }
  .systemenvironment .sys-table-min{
    margin: 10px 0;
    margin-left: 15px;
    color: #999999;
    font-size: 16px;
  }
  .systemenvironment .myxuex{
    width: 990px;
    height: 154px;
    border:1px solid #999999;
    border-top: none;
    border-right: none;
    box-sizing:border-box;
    -moz-box-sizing:border-box; /* Firefox */
    -webkit-box-sizing:border-box; /* Safari */
    margin-left: 5px;
  }
  .systemenvironment .myxuex .myxuexlist{
    border-top: 1px solid #999999;
    height: 38px;
    line-height: 38px;
    box-sizing:border-box;
    -moz-box-sizing:border-box; /* Firefox */
    -webkit-box-sizing:border-box; /* Safari */
  }
  .systemenvironment .myxuex .myxuexlist .el-col{
    width: 20%;
    box-sizing:border-box;
    -moz-box-sizing:border-box; /* Firefox */
    -webkit-box-sizing:border-box; /* Safari */
    border-right: 1px solid #999999;
  }
  .systemenvironment .myxuex .myxuexlist .el-col-60{
    width: 60%;
  }
  .systemenvironment .myxuex .myxuexlist .el-col span{
    padding-left: 10px;
    padding-right: 10px;
    box-sizing: border-box;
    text-overflow: ellipsis;
  }
  .systemenvironment .myxuex .myxuexlistheader{
    font-size: 14px;
    color: #1f2d3d;
    font-weight: bold;
  }
  .postedfa{
    min-height: 30px;
  }
  #loadin{
    height: 30px;
    width: 1000px;
    background: #fff;
  }
</style>
</head>
<body >
  <div class="postedfa postedfama">
      <div class="post-menu">
          <ul>
              <li class="workcurrent"><a href="/college/flowrate/view.html"><span>学习环境</span></a></li>
              <li ><a href="/college/loginlog.html"><span>地域分布</span></a></li>
          </ul>
      </div>
  </div>
  <div id="loadin"></div>
  <div id="systemenvironment" class="systemenvironment" style="display: none;">
    
    <el-row class="sys-table">
      <span>我的学习系统环境</span>
    </el-row>
    <el-row class="myxuex">
      <el-col class="myxuexlist myxuexlistheader">
        <el-col><span>浏览器</span></el-col>
        <el-col><span>版本</span></el-col>
        <el-col><span>内核</span></el-col>
        <el-col><span>语言</span></el-col>
        <el-col><span>分辨率</span></el-col>
      </el-col>
      <el-col class="myxuexlist">
        <el-col><span>{{browser}}</span></el-col>
        <el-col><span>{{broversion}}</span></el-col>
        <el-col><span>{{vendor}}</span></el-col>
        <el-col><span>{{userLanguage}}</span></el-col>
        <el-col><span>{{screen}}</span></el-col>
      </el-col>
      <el-col class="myxuexlist myxuexlistheader">
        <el-col><span>系统</span></el-col>
        <el-col class="el-col-60"><span>IP地址</span></el-col>
        <el-col><span>宽带</span></el-col>
      </el-col>
      <el-col class="myxuexlist">
        <el-col><span>{{system}}</span></el-col>
        <el-col class="el-col-60"><span>{{pcityname}}  {{ip}}</span></el-col>
        <el-col><span>{{ispname}}</span></el-col>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <el-row class="sys-table">
          <span>操作系统及浏览器</span>
        </el-row>
        <el-row class="sys-table-min">
          <span>操作系统占比</span>
        </el-row>
      </el-col>
      <el-col :span="16">
        <el-row class="searchbox" style="margin-left: 2px;">
          <el-col class="dayselectbox" >
            <el-col style="text-align: right;">
              <el-col :span="21">
                <el-date-picker
                    v-model="starttime"
                    type="date"
                    placeholder="选择开始日期"
                    :picker-options="pickerOptionsbrowserS"
                    @change="dateStartChangebrowserS">
                 </el-date-picker>
                  <el-date-picker
                    v-model="endtime"
                    type="date"
                    placeholder="选择结束日期"
                    :picker-options="pickerOptionsbrowserE"
                    @change="dateStartChangebrowserE">
                  </el-date-picker>
              </el-col>
              <el-col :span="3">
                <el-button type="primary" @click="searchselect('browser')" icon="search">搜索</el-button>
               </el-col>
            </el-col>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
    <el-row style="margin-bottom: 15px;">
      <el-col :span="12" >
        <p class="equipment"><span class="pc">pc端</span></p>
        <p class="equipmentnum">
          人次：<span>{{ospcCount || 0}}</span><br>
          占比：<span>{{ospcScale || 0}}%</span>
        </p>
        <div class="echarts" ref="echartsequipmentpc">
        </div>
        <el-table  :data="ospc" v-loading="loginlogloading"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="width: 80%;margin-left: 10%;margin-top: 15px;">
          <div class="nodata" slot="empty"></div>
          <el-table-column prop="name" label="pc端系统" sortable width="280" show-overflow-tooltip>
          </el-table-column>
          <el-table-column  label="占比" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.scale}}%
            </template>
          </el-table-column>
        </el-table>
      </el-col>
      <el-col :span="12">
        <p class="equipment"><span  class="phone">移动端</span></p>
        <p class="equipmentnum">
          人次：<span>{{osmobileCount || 0}}</span><br>
          占比：<span>{{osmobileScale || 0}}%</span>
        </p>
        <div class="echarts"  ref="echartsequipmentphone">
        </div>
        <el-table  :data="osmobile" v-loading="loginlogloading"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="width: 80%;margin-left: 10%;margin-top: 15px;">
          <div class="nodata" slot="empty"></div>
          <el-table-column prop="name" label="移动端系统" sortable width="280" show-overflow-tooltip>
            
          </el-table-column>
          <el-table-column  label="占比" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.scale}}%
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-row class="sys-table-min">
      <span>浏览器占比</span>
    </el-row>
    <el-row style="margin-bottom: 15px;">
      <el-col :span="12" >
        <p class="equipment"><span class="pc">pc端</span></p>
        <div class="echarts" ref="echartsbrowerpc"></div>
        <el-table  :data="browserpc" v-loading="loginlogloading"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="width: 80%;margin-left: 10%;margin-top: 15px;">
          <div class="nodata" slot="empty"></div>
          <el-table-column prop="name" label="pc端系统" width="280" show-overflow-tooltip>
          </el-table-column>
          <el-table-column  label="占比" show-overflow-tooltip >
            <template scope="scope">
              {{scope.row.scale}}%
            </template>
          </el-table-column>
        </el-table>
      </el-col>
      <el-col :span="12">
        <p class="equipment"><span  class="phone">移动端</span></p>
        <div class="echarts" ref="echartsbrowerphone"></div>
        <el-table  :data="browsermobile" v-loading="loginlogloading"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="width: 80%;margin-left: 10%;margin-top: 15px;">
          <div class="nodata" slot="empty"></div>
          <el-table-column prop="name" label="移动端系统" width="280" show-overflow-tooltip>
            
          </el-table-column>
          <el-table-column  label="占比" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.scale}}%
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-row class="sys-table-min">
      <span>屏幕分辨率占比</span>
    </el-row>
    <el-row style="margin-bottom: 15px;">
      <el-col :span="24" v-if="ResonxAxisData.length > 0">            
        <div class="resolution" id="resolution">
        </div>            
      </el-col>
      <el-col :span="24">
        <el-table  :data="resolutionData" v-loading="loginlogloading"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="margin:15px 0 0 50px;width:850px;">
          <div class="nodata" slot="empty"></div>
          <el-table-column label="排名"  width="180" show-overflow-tooltip>
            <template scope="scope">
              {{scope.$index+1}}
            </template>
          </el-table-column>
          <el-table-column  label="分辨率" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.screen}}
            </template>
          </el-table-column>
          <el-table-column  label="登录人次" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.count}}
            </template>
          </el-table-column>
          <el-table-column  label="登录占比" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.scale}}%
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-row class="sys-table-min">
      <span>宽带供应商占比</span>
    </el-row>
    <el-row style="margin-bottom: 15px;">
      <el-col :span="24" v-if="ProerxAxisData.length > 0">            
        <div class="provider" id="provider">
        </div>            
      </el-col>
      <el-col :span="24">
        <el-table  :data="ProviderData" v-loading="loginlogloading"  element-loading-text="加载中..." ref="loginlogdata" reserve-selection="false" stripe :default-sort="{prop: 'data'}" style="margin:15px 0 0 50px;width:850px;">
          <div class="nodata" slot="empty"></div>
          <el-table-column label="排名" width="280" show-overflow-tooltip>
            <template scope="scope">
              {{scope.$index+1}}
            </template>
          </el-table-column>
          <el-table-column  label="网络提供商" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.isp}}
            </template>
          </el-table-column>
          <el-table-column  label="登录人次" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.count}}
            </template>
          </el-table-column>
          <el-table-column  label="登录占比" show-overflow-tooltip>
            <template scope="scope">
              {{scope.row.scale}}%
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
  </div>
</body>
  <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/vue/vue.min.js?v=20171120001"></script>
  <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/troomv2/element-ui/lib/index.js?v=20171120001"></script>
  <script src="http://static.ebanhui.com/exam/js/vue-resource.min.js?v=20171120001"></script>
  <script src="http://static.ebanhui.com/ebh/js/echarts.min.js?v=20171120001"></script>
  <script>
    window.host = ''
    new Vue({
      el: '#systemenvironment',
      data: function() {
        return {
        loading:false,
          //浏览器数据
        browsermobileCount:0,
        browsermobileScale:0,
        browserpc : [],
        browsermobile : [],
        browserpcCount : 0,
        browserpcScale : 0,
        //浏览器数据 -------结束
        //网络设备类型数据
        osmobileCount:0,
        osmobileScale:0,
        ospc : [],
        osmobile : [],
        ospcCount : 0,
        ospcScale : 0,
        //网络设备类型数据 -------结束
        dayselectactive : 1,
        starttime : '',
        endtime : '',
        loginlogloading:false, //省级数据load
        loginlogloadings : false, //市级数据load
        pickerOptionsbrowserE: {
        },
        pickerOptionsbrowserS: {
        },
        pickerOptionsosE: {
        },
        pickerOptionsosS: {
        },
        pickerOptions4S:{
        },
        pickerOptions4E:{
        },
        ip : '',
        pcityname : '',
        browser : '',
        broversion:'',
        screen : '',
        system:'',
        ispname : '',
        userLanguage : '',
        vendor : '',
        getVendorPrefix:function () {
  		    // 使用body是为了避免在还需要传入元素
  		    var body = document.body || document.documentElement,
  		    style = body.style,
  		    vendor = ['webkit', 'khtml', 'moz', 'ms', 'o'],
  		    i = 0;

  		    while (i < vendor.length) {
  		    // 此处进行判断是否有对应的内核前缀
  		      if (typeof style[vendor[i] + 'Transition'] === 'string') {
  		        return vendor[i];
  		      }
  		      i++;
  		    }
  		},
	    getlogininfo:function(){
        var self = this;
        self.$http.get(window.host+"/logininfo.html", {params:{}},{emulateJSON:true}).then(function(response){
            self.broversion = response.data.broversion;
            self.ip = response.data.ip;
            self.system = response.data.system;
            self.screen = window.screen.width+ "×" + window.screen.height
            self.browser = response.data.browser;
            self.ispname = response.data.ispname || '---';
            self.userLanguage   = navigator.language;
            if(response.data.pcityname == '局域网'){
                self.pcityname = response.data.pcityname;
            }else{
                self.pcityname = response.data.pcityname + '-' + response.data.cityname;
            }
            self.vendor = self.getVendorPrefix();
            
            document.getElementById('loadin').style.display = 'none'
            document.getElementById('systemenvironment').style.display = 'block'
            
            
        }, function(response){
          console.log(response)
        });
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
        getbrowser:function(start,end,imports){
          var self = this;
          self.$http.get(window.host+"/college/flowrate/browser.html", {params:{starttime:start,endtime:end,import:imports}},{emulateJSON:true}).then(function(response){
              var data = response.data;
              if(data.code == 0){
                var datas =  data.data;
                var browserpc = [];
                var browserpcname = [];
                var browsermobile = [];
                var browsermobilename = [];
                self.browsermobileCount =  datas.mobileCount;
                self.browsermobileScale = datas.mobileScale;
                self.browserpcCount =  datas.pcCount;
                self.browserpcScale =  datas.pcScale;
                if(datas.pc){
                  for(var i=0;i< datas.pc.length;i++){
                    browserpcname.push(datas.pc[i].browser);
                    browserpc.push({
                      value :datas.pc[i].count,
                      name : datas.pc[i].browser,
                      scale : datas.pc[i].scale
                    })
                  }
                }
                if(datas.mobile){
                  for(var i=0;i< datas.mobile.length;i++){
                    browsermobilename.push(datas.mobile[i].browser);
                    browsermobile.push({
                      value :datas.mobile[i].count || 0, 
                      name : datas.mobile[i].browser || '其他',
                      scale : datas.mobile[i].scale
                    })
                  }
                }
                self.browserpcname =  browserpcname;
                self.browserpc =  browserpc;
                self.browsermobilename =  browsermobilename;
                self.browsermobile =  browsermobile;
                setTimeout(function(){
                  self.setOptionbrower();
                },0)
              }
          }, function(response){
            console.log(response)
          });
        },
        getos:function(start,end,imports){
          var self = this;
          self.$http.get(window.host+"/college/flowrate/os.html", {params:{starttime:start,endtime:end,import:imports}},{emulateJSON:true}).then(function(response){
              var data = response.data;
              if(data.code == 0){
                var datas =  data.data;
                var ospc = [];
                var ospcname = [];
                var osmobile = [];
                var osmobilename = [];
                self.osmobileCount =  datas.mobileCount;
                self.osmobileScale = datas.mobileScale;
                self.ospcCount =  datas.pcCount;
                self.ospcScale =  datas.pcScale;
                if(datas.pc){
                  for(var i=0;i< datas.pc.length;i++){
                    ospcname.push(datas.pc[i].system);
                    ospc.push({
                      value :datas.pc[i].count,
                      name : datas.pc[i].system,
                      scale : datas.pc[i].scale
                    })
                  }
                }
                if(datas.mobile){
                  for(var i=0;i< datas.mobile.length;i++){
                    osmobilename.push(datas.mobile[i].system);
                    osmobile.push({
                      value :datas.mobile[i].count || 0, 
                      name : datas.mobile[i].system || '其他',
                      scale : datas.mobile[i].scale
                    })
                  }
                }
                self.ospcname =  ospcname;
                self.ospc =  ospc;
                self.osmobilename =  osmobilename;
                self.osmobile =  osmobile;
                setTimeout(function(){
                  self.setOptionos();
                },0)
              }
          }, function(response){
            console.log(response)
          });
        },
      //-------------------Resolution--------------------
          dayResolution:1,
          startResonTime:'',
          endResonTime:'',
          pickerOptionsResonS:{},
          pickerOptionsResonE:{},
          ResonxAxisData:[],
          ResonSeriesData:[],
          resolutionData:[],
                httpget:function(getParam){//封装的异步get请求数据
                    var self = this;                  
                    self.$http.get(window.host + getParam.url,{ params:getParam.params }).then((response) => {                       
                        var code = response.body.code;
                        if( code > 0 ){
                            self.$notify.error({
                              title: '错误',
                              message: msg+" 账户未登录,无法获得数据",
                              duration: 0
                            });
                            return;
                        }
                        getParam.fun(response);
                    }).catch(function(response) {                       
                        self.$notify.error({
                            title: '错误',
                            message: '网络连接错误,接口异常'
                        });
                    }); 
                },
                screenData:function(start,end){
                    var self = this,
                        param = {
                            url:'/college/flowrate/screen.html',
                            params:{
                                starttime:start,
                                endtime:end
                            },
                            fun:function(res){
                                var data = res.body.data,
                                    code = res.body.code,
                                    arr = [],
                                    arrData = []; 

                                for(var i = 0,len = data.length; i < len; i++){
                                  var list = data[i];
                                  arr.push(list.screen);
                                  arrData.push(list.scale);
                                }
                                self.resolutionData = data; 
                                self.ResonxAxisData = arr;
                                self.ResonSeriesData = arrData;
                                if(data.length > 0){
                                  setTimeout(function(){
                                    self.drawResolution();
                                  },0)                                  
                                }                                                                    
                            }
                        }
                    self.httpget(param);
                },
            //-------------------Provider----------------------------
              dayProvider:1,
          startProerTime:'',
          endProerTime:'',
          pickerOptionsProerS:{},
          pickerOptionsProerE:{},
          ProerxAxisData:[],
          ProerSeriesData:[],
          ProviderData:[],
                NetworkData:function(start,end){
                    
                    var self = this,
                        param = {
                            url:'/college/flowrate/isp.html',
                            params:{
                                starttime:start,
                                endtime:end
                            },
                            fun:function(res){
                                var data = res.body.data,
                                    code = res.body.code,
                                    arr = [],
                                    arrData = []; 

                                for(var i = 0,len = data.length; i < len; i++){
                                  var list = data[i];
                                  arr.push(list.isp);
                                  arrData.push(list.scale);
                                }
                                self.ProviderData = data;
                                self.ProerxAxisData = arr;
                                self.ProerSeriesData = arrData;
                                if(data.length > 0){
                                  setTimeout(function(){
                                    self.drawProvider();
                                  },0)                                  
                                }     
                            }
                        }
                    self.httpget(param);
                },
                getLocalTime: function(nS) {     
           return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
        }     
        }
      },
      mounted: function(){

        
      },
      created: function() {
        var self = this,start,end;
        self.endtime = new Date();
        start = (new Date(new Date().toLocaleDateString()).getTime()/1000)-86400*29;
        end = Date.parse(new Date())/1000;
        var newDate = new Date();
        newDate.setTime(start * 1000);
        self.starttime = newDate.toString()
        self.getbrowser(start,end);
        self.getos(start,end);
        self.screenData(start,end);
        self.NetworkData(start,end);
        self.getlogininfo();
        setTimeout(function(){
          parent.resetmain()      
        },1000)
        
      },
      methods: {
      searchselect(tab){
        var self = this;
        if(self.starttime == '' || self.endtime == '' ){
          self.$notify({
            title: '警告',
            message: self.starttime == '' ? '请 "选择开始日期"':'请 "选择结束日期"',
            type: 'warning'
          })
        }else{
          //self.dayselectactive = 0;             
          var start = Date.parse(self.starttime)/1000;
          var end = (Date.parse(self.endtime)/1000) + 86400 - 1;
          /*switch(tab)
          {
            case 'browser':*/
            self.getbrowser(start,end);
           /* break;
            case 'os': */ 
            self.getos(start,end);

            self.screenData(start,end);
            self.NetworkData(start,end);
            /*break;
          }*/
        }
      },
      setOptionbrower(){
        var self = this;
        // 基于准备好的dom，初始化echarts实例
        var echartsbrowerpc = echarts.init(self.$refs.echartsbrowerpc);
        var echartsbrowerphone = echarts.init(self.$refs.echartsbrowerphone);
        // 绘制图表
        
        echartsbrowerpc.setOption({
          color:['#7CB5EC','#434348','#90ED7D','#F7A35C','#8085E9','#F15C80'],
            tooltip : {
                trigger: 'item',
                formatter : function(param){
                    var params = param.data;
                    return [
                                '访问来源: ' + params.name+ '<br/>',
                                '访问人次: ' + (params.value||0) + '<br/>',
                                '访问占比: ' + (params.scale||0) + '%<br/>',
                          ].join('');
                    
                }
            },
            legend: {
                x : 'center',
                y : 'bottom',
                data: self.browserpcname.length?self.browserpcname:['暂无数据']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '70%',
                    center: ['50%', '48%'],
                    data:self.browserpc.length?self.browserpc:[{name:'暂无数据',value:0}],
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
        echartsbrowerphone.setOption({
          color:['#7CB5EC','#434348','#90ED7D','#F7A35C','#8085E9','#F15C80'],
            tooltip : {
                trigger: 'item',
                formatter : function(param){
                    var params = param.data;
                    return [
                                '访问来源: ' + params.name+ '<br/>',
                                '访问人次: ' + (params.value||0) + '<br/>',
                                '访问占比: ' + (params.scale||0) + '%<br/>',
                          ].join('');
                    
                }
            },
            legend: {
                x : 'center',
                y : 'bottom',
                data: self.browsermobilename.length?self.browsermobilename:['暂无数据']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '70%',
                    center: ['50%', '45%'],
                    data:self.browsermobile.length?self.browsermobile:[{name:'暂无数据',value:0}],
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
      },
      setOptionos(){
        var self = this;
        var echartsequipmentpc = echarts.init(self.$refs.echartsequipmentpc);
        var echartsequipmentphone = echarts.init(self.$refs.echartsequipmentphone);
            echartsequipmentpc.setOption({
          color:['#7CB5EC','#434348','#90ED7D','#F7A35C','#8085E9','#F15C80'],
            tooltip : {
                trigger: 'item',
                formatter : function(param){
                    var params = param.data;
                    return [
                                '访问来源: ' + params.name+ '<br/>',
                                '访问人次: ' + (params.value||0) + '<br/>',
                                '访问占比: ' + (params.scale||0) + '%<br/>',
                          ].join('');
                    
                }
            },
            legend: {
                x : 'center',
                y : 'bottom',
                data: self.ospcname.length?self.ospcname:['暂无数据']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '70%',
                    center: ['50%', '45%'],
                    data:self.ospc.length?self.ospc:[{name:'暂无数据',value:0}],
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
        echartsequipmentphone.setOption({
          color:['#7CB5EC','#434348','#90ED7D','#F7A35C','#8085E9','#F15C80'],
            tooltip : {
                trigger: 'item',
                formatter : function(param){
                    var params = param.data;
                    return [
                               '访问来源: ' + params.name+ '<br/>',
                                '访问人次: ' + (params.value||0) + '<br/>',
                                '访问占比: ' + (params.scale||0) + '%<br/>',
                          ].join('');
                    
                }
            },
            legend: {
                x : 'center',
                y : 'bottom',
                data: self.osmobilename.length?self.osmobilename:['暂无数据']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '70%',
                    center: ['50%', '45%'],
                    data:self.osmobile.length?self.osmobile:[{name:'暂无数据',value:0}],
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
      },
    //-------------------Resolution-----------------
      drawResolution(){
        var self = this,
          chartRn = echarts.init(document.getElementById('resolution'));
          chartRn.setOption({
            tooltip : {
                trigger: 'item',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: "{b} : {c}%"
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : self.ResonxAxisData,
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    type:'bar',
                    barWidth: '60px',
                    data:self.ResonSeriesData,
                    itemStyle: {
                        normal: {
                            color: function(params) {
                                var colorList = [
                                    '#7CB5EC','#434348', '#90ED7D', '#F7A35C',
                                    '#8085E9','#F15C80','#E4D354','#A287B7'
                                ];
                                return colorList[params.dataIndex]
                            }
                        }
                    },
                    label: {
                        normal: {
                            show: true,
                            position: 'top',
                            formatter: '{c}%'
                        }
                    }
                }
            ]
          });
      },
      drawProvider(){
        var self = this,
          chartRn = echarts.init(document.getElementById('provider'));

          chartRn.setOption({
            tooltip : {
                trigger: 'item',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                },
                formatter: "{b} : {c}%"
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : self.ProerxAxisData,
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {                      
                    type:'bar',
                    barWidth: '60px',
                    data:self.ProerSeriesData,
                    itemStyle: {
                        normal: {
                            color: function(params) {
                                var colorList = [
                                    '#7CB5EC','#434348', '#90ED7D', '#F7A35C',
                                    '#8085E9','#F15C80','#E4D354','#A287B7'
                                ];
                                return colorList[params.dataIndex]
                            }
                        }
                    },
                    label: {
                        normal: {
                            show: true,
                            position: 'top',
                            formatter: '{c}%'
                        }
                    }
                }
            ]
          });
      },
      dateStartChangebrowserS(){
        var self = this;
          self.pickerOptionsbrowserE = {
              disabledDate(time) {
                  var interval = time.getTime() > Date.parse(new Date());
                  return interval;
              }
          }
      },
      dateStartChangebrowserE(){
        var self = this;                
          self.pickerOptionsbrowserS = {
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