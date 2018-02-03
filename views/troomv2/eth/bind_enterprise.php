<?php $this->display('troomv2/page_header'); ?>
<style>
    #icategory {
      padding: 10px 20px;
    	float:left;
      max-height: 600px;
      overflow-y:auto;
    }
    #icategory dt {
        float: left;
        line-height: 22px;
        padding-right: 5px;
        text-align: left;
    }
    #icategory dd {
        float: left;
        width: 950px;
    }
    .category_cont1 div a.curr, .category_cont1 div a:hover{
        background: none ;
        border-radius: 2px;
        color: #2c71ae;
        font-size: 14px;
    	  padding:3px;
    }
    .category_cont1 div a {
        color: #2c71ae;
    	font-size:14px;
    }
    .category_cont1 div {
        float: left;
        height: 25px;
        line-height: 22px;
        overflow: hidden;
        padding: 0 15px 0 10px;
    }
    .ghjut {
        margin: 0 0 0 10px;
        width: 165px;
    }
    .datatab td{
    	border-top:1px solid #f5f5f5;
    	border-bottom:none;
    }
</style>
<style>
    .waitite2{
        margin-left: 16px;
    }
    .enterprise{

    }
    .enterprise ul li{
        margin: 0;
        font-size: 14px;
    }
    .enterprise .workcurrent a{
        background: none;
    }
    .enterprise a.title-a .jnisrso{ 
        font-size: 14px;
        color: #777;
        background: none;
    }
    .enterprise .showtap a.title-a{
        background:url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) no-repeat right 0px;
    }
    .enterprise .showtap a.title-a .jnisrso{
        background:url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) left 0px no-repeat;
        color: #4c88ff;
    }
</style>
<body>
<style>
    #icategory{
        margin:10px 0 0 10px;        
        float: left;
        width: 25%; 
        border: 1px solid #e3e3e3; 
        padding: 10px 0;       
    }
    #icategory dl dd{
        width: 100%;
    }
    .tableinfo{
        margin:10px 0 0 10px;
        float: left;
        width: 70%;        
        border: 1px solid #e3e3e3;
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
    .ghjut{
      width: 125px;
    }
</style>
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/xtree/iconfont.css">
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css"> 
<style>
  .organize ul{
    overflow: visible;
  }
  .organize li .tr .cname{
    width: auto;
  }
  .extendul1s .count{
    display: none;
  }
  .extendul1s .workcurrent .count{
    display: inline-block;
  }
  .ghjut .overs{
    display: inline-block;
    max-width: 90px;
    overflow: hidden;
    text-overflow:ellipsis;
    white-space: nowrap;
  }
</style>
<div class="lefrig">
	<div class="waitite waitite2">
		<div class="work_menu enterprise" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent "><a href="/troomv2/eth.html" class="title-a"><span class="jnisrso">发消息</span></a></li>
                <li class="workcurrent "><a href="/troomv2/eth/history.html" class="title-a"><span class="jnisrso">详情</span></a></li>
                <li class="workcurrent "><a href="/troomv2/eth/inbox.html" class="title-a"><span class="jnisrso">收件箱</span></a></li>
                <li class="workcurrent showtap"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">绑定情况</span></a></li>
			</ul>
		</div>       
    </div>
    <div class="workol">
    	<div class="work_mes work_mes1s">
            <ul class="extendul extendul1s">
                <li class="workcurrent" dataStatus='1'><a><span>全部<span class="count"></span></span></a></li>
                <li class="" dataStatus='2'><a ><span>已绑定<span class="count"></span></span></a></li>
                <li class="" dataStatus='3'><a><span>未绑定<span class="count"></span></span></a></li>
            </ul>
        </div>
        <div id="icategory">
            <dl>
                <dd>
                    <div class="category_cont1">                       
                        <div id="classchoose2" class="organize"></div>
                    </div>
                </dd>
            </dl>
        </div>
      <!--   <div class="clear"></div> -->
        <div class="tableinfo">
            <table width="100%" style="border:none;" class="datatab">
                <thead class="tabhead">
                    <tr class="">
                        <th class="gryxdhzt">个人信息</th>
                        <th>邮箱</th>
                        <th>电话</th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tbody class="content">
                
    			      </tbody>
    		    </table>
        </div>
      <!--   <?=$pagestr?> -->
		<div class="pages"></div>
<!--    /troomv2/enterprise/department.html?staff=1 全部
        /troomv2/enterprise/department.html?bind=1 绑定
        /troomv2/enterprise/department.html?bind=2 未绑定
-->
	</div>
</div>
<script>
    $(function(){

      var bindScript = {
        init:function(){
          var self = this;
          self.content = $(".content"),//渲染成员容器
          self.pages = $(".pages"),//分页
          self.extli = $(".extendul li"),//选项卡
          self.count = $(".count"),//总人数
          self.organize = $(".organize"),//树状容器节点
          self.total = 70,//总条数
          self.boundState = 1,//选项卡标识boundState
          self.classid = 0;//防止重复加载
          self.getClass = 0;
          self.pagesize = 10;
          self.extliEvent();
          self.ajaxTree({staff:1});
          self.pagesEvent();         
        },
        extliEvent:function(){//绑定选项卡 
          var self = this;
          self.extli.on('click',function(){//选项卡 1
           
            var e = $(this);
            self.boundState = parseInt(e.attr('dataStatus'));
            self.extli.removeClass('workcurrent');         
            e.addClass('workcurrent');
                      
            switch(self.boundState)
              {
                  case 1://全部
                      self.ajaxTree({staff:1});
                      break;
                  case 2://绑定
                      self.ajaxTree({bind:1});
                      break;
                  case 3://未绑定
                      self.ajaxTree({bind:2});
                      break;
              } 

          })
        },
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
                  readerData(arrz);//
                  self.ajaxData({bind:self.boundState-1,classid:self.getClass,page:1,pagesize:self.pagesize},1)
                  self.classid = self.getClass;
                  function readerData(arr){ //渲染左侧部门树
                      $("#classchoose2").html('');
                      var userTotal = 0;
                      for(var i = 0,len = arr.length; i < len; i++){
                        var superior = arr[i].superior,
                             classid = arr[i].classid,
                           classname = arr[i].classname,
                           usercount = arr[i].usercount,
                            haspower = arr[i].haspower,                              
                                  li = '';
                           userTotal+= parseInt(usercount); 

                          self.getClass = $('.tr').eq(1).attr('isclassid');
                          $('.tr').eq(1).addClass('on');
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
                                     +     classname+' (<span style="color:red;margin:0;">'+usercount+'</span>)</a>'
                                     +   '</div>'
                                     +  '</li>'
                                     +'</ul>';
                                  $("."+superior).append(li); 
                              }else{
                                  li ='<li class='+classid+' >'
                                     + '<div class="tr '+(haspower?"":"ban")+'" isclassid="'+classid+'">'
                                     +  '<i></i><i class=" img-organize"></i>'
                                     +   '<a class="cname" >'
                                     +   classname+' (<span style="color:red;margin:0;">'+usercount+'</span>)</a>'
                                     + '</div>'
                                     +'</li>';
                                  $("."+superior+">ul").append(li );  
                              }
                          }
                      }
                     
                      self.count.eq(self.boundState-1).text('('+userTotal+')');
                      
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
                          tr.removeClass('on');
                          $(this).addClass('on');
                          var $classid = $(this).attr('isclassid'),
                                   ban = $(this).hasClass('ban');  
                                         
                          if(self.classid!= $classid&&!ban){
                            self.classid = $classid;
                            self.ajaxData({bind:self.boundState-1,classid:$(this).attr('isclassid'),page:1,pagesize:self.pagesize},1);
                          }
                          self.getClass = $(this).attr('isclassid');
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
        ajaxData:function(obj,curr){//异步渲染右侧员工列表
          var self = this,
          imgG ="http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg",
          imgB = "http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg",
          iconG = "http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png",
          iconB = "http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png";

          $.ajax({
              type: "GET",
              url: "/troomv2/enterprise/binduser.html",
              dataType: "json",
              data:obj,
              success:function(res){
                var arr = res.data.userlist,
                   html = '';  
                   //todo: total赋值                
                if(arr.length>0){                  
                    for(var i = 0,len = arr.length;i<len;i++){
                      var img = arr[i].face?arr[i].face:arr[i].sex=='1'?imgG:imgB,
                          icon = arr[i].sex=='1'?iconG:iconB;
                      html += '<tr class="last">'
                           +   '<td width="30%">'
                           +     '<a title="" href="javascript:;" style="float:left;">'
                           +     '<img src="'+img+'" class="imgyuan" style="width:40px; height:40px;"></a>'
                           +     '<p class="ghjut"><span class="overs">'+arr[i].realname+'</span>'
                           +       '<img src="'+icon+'" class="ml5">'
                           +     '</p>'
                           +     '<p class="ghjut">'+arr[i].username+'</p>'
                           +   '</td>'
                           +   '<td width="25%" style="text-align:center">'+arr[i].email+'</td>'
                           +   '<td width="20%" style="text-align:center">'+(arr[i].mobile?arr[i].mobile:arr[i].smobile?arr[i].smobile:'----')+'</td>';
                        if(arr[i].bind == 1||self.boundState == 2){
                            html +='<td width="25%" style="text-align:center; color:#5e98fb;">已绑定</td>';
                        }else{
                            html +='<td width="25%" style="text-align:center; color:#ff3333;">未绑定</td>';
                        }
                      html += '</tr>';
                    }
                }else{                    
                    html = '<tr class=last"> <td colspan="4"><div class="nodata"></div></td></tr>';
                }  
                self.total = res.data.usercount;              
                self.content.html(html);
                self.pageData(self.total,curr);
                setTimeout(function(){
                  var height = $(".lefrig").height()+30;
                  parent.window.$("#mainFrame").css('height','820px');
                },0)
              }              
            });
        },
        pageData:function(total,curr){//渲染分页
          var self = this,
          pageHtml = '',
               len = parseInt(total/self.pagesize)+1;
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
            self.pages.on('click',function(e){//分页点击事件
              var target = e.target,
                    eleA = $(e.target),
                  status = eleA.attr('dataStatus'),
                     num = parseInt(eleA.text()),
                    numz = parseInt(self.pages.find('.none').eq(0).text()); 

              if(target.nodeName == 'A'){
                if(status == 'pre'){
                  self.ajaxData({bind:self.boundState-1,classid:self.getClass,page:numz-1,pagesize:self.pagesize},numz-1)                           
                }else if(status == 'next'){              
                  self.ajaxData({bind:self.boundState-1,classid:self.getClass,page:numz+1,pagesize:self.pagesize},numz+1)             
                }else{ 
                  self.ajaxData({bind:self.boundState-1,classid:self.getClass,page:num,pagesize:self.pagesize},num);
                }
              }
            }) 
        }
      }

      bindScript.init();//执行初始化
        
    })

</script>
</body>
</html>
