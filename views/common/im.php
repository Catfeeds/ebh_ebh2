<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>测试IM</title>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" media="all">
<script type="text/javascript" src="/static/layui/layui.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script></head>

<body>
<script>
layui.use('layim', function(layim){
  //基础配置
  layim.config({
  
    //获取主面板列表信息
    init: {
      url: '/im/members.html' //接口地址（返回的数据格式见下文）
      ,type: 'get' //默认get，一般可不填
      ,data: {} //额外参数
    }
    
    //配置我的信息（如果设定了该参数，则优先读取该参数，如果没有，这读取init返回的mine信息）
    ,mine: {
      "username": "林闲云" //我的昵称
      ,"id": "100000123" //我的ID
      ,"status": "online" //在线状态 online：在线、hide：隐身
      ,"sign": "测试签名" //我的签名
      ,"avatar": "http://img.ebanhui.com/avatar/2016/09/01/1472710401_78_78.jpg" //我的头像
    }
    //获取群员接口
    ,members: {
      url: '/im/members.html' //接口地址（返回的数据格式见下文）
      ,type: 'get' //默认get，一般可不填
      ,data: {} //额外参数
    }
    
    //上传图片接口（返回的数据格式见下文）
//    ,uploadImage: {
//      url: '' //接口地址（返回的数据格式见下文）
//      ,type: 'post' //默认post
//    } 
    
    //上传文件接口（返回的数据格式见下文）
//    ,uploadFile: {
//      url: '' //接口地址（返回的数据格式见下文）
//      ,type: 'post' //默认post
//    } 
    
    //增加皮肤选择，如果不想增加，可以剔除该项
//    ,skin: [ 
//      'http://xxx.com/skin.jpg', 
//    ] 
    
    ,brief: false //是否简约模式（默认false，如果只用到在线客服，且不想显示主面板，可以设置 true）
    ,title: '我的LayIM' //主面板最小化后显示的名称
    ,min: false //用于设定主面板是否在页面打开时，始终最小化展现。默认false，即记录上次展开状态。
    ,minRight: null //【默认不开启】用户控制聊天面板最小化时、及新消息提示层的相对right的px坐标，如：minRight: '200px'
    ,maxLength: 3000 //最长发送的字符长度，默认3000
    ,isfriend: true //是否开启好友（默认true，即开启）
    ,isgroup: true //是否开启群组（默认true，即开启）
    ,right: '0px' //默认0px，用于设定主面板右偏移量。该参数可避免遮盖你页面右下角已经的bar。
//    ,chatLog: '/chat/log/' //聊天记录地址（如果未填则不显示）
//    ,find: '/find/' //查找好友/群的地址（如果未填则不显示）
    ,copyright: true //是否授权，如果通过官网捐赠获得LayIM，此处可填true
  });
   //面板外的操作
  var $ = layui.jquery, active = {
    chat: function(){
      //创造一个临时会话
      layim.chat({
        name: '小闲'
        ,type: 'friend'
        ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.180.180.180/7f5f6861jw1e8qgp5bmzyj2050050aa8.jpg'
        ,id: 1008612
      });
      layer.msg('也就是说，此人可以不在好友面板里');
    }
    ,message: function(){
      //制造一个好友发过来的消息
      layim.getMessage({
        username: "贤心"
        ,avatar: "http://tp1.sinaimg.cn/1571889140/180/40030060651/1"
        ,id: "100001"
        ,type: "friend"
        ,content: "嗨，你好！欢迎体验LayIM。演示标记："+ new Date().getTime()
        ,timestamp: new Date().getTime()
      });
    }
    ,messageTemp: function(){
      //制造一个临时会话消息
      layim.getMessage({
        username: "小酱"
        ,avatar: "http://tva1.sinaimg.cn/crop.7.0.736.736.50/bd986d61jw8f5x8bqtp00j20ku0kgabx.jpg"
        ,id: "198909151014"
        ,type: "friend"
        ,content: "临时："+ new Date().getTime()
      });
    }
    ,addFriend: function(){
      layer.msg('已成功把[冲田杏梨]添加到好友【网红】组里', {
        icon: 1
      });
      //增加一个好友
      layim.addList({
        type: 'friend'
        ,avatar: "http://tp2.sinaimg.cn/2386568184/180/40050524279/0"
        ,username: '冲田杏梨'
        ,groupid: 2
        ,id: "1233333312121212"
        ,remark: "本人冲田杏梨将结束AV女优的工作"
      });
    }
    ,addGroup: function(){
      layer.msg('已成功把[Angular开发]添加到群组里', {
        icon: 1
      });
      //增加一个群组
      layim.addList({
        type: 'group'
        ,avatar: "http://tva3.sinaimg.cn/crop.64.106.361.361.50/7181dbb3jw8evfbtem8edj20ci0dpq3a.jpg"
        ,groupname: 'Angular开发'
        ,id: "12333333"
        ,members: 0
      });
    }
    ,removeFriend: function(){
      layer.msg('已成功删除[凤姐]', {
        icon: 1
      });
      //删除一个好友
      layim.removeList({
        id: 121286
        ,type: 'friend'
      });
    }
    ,removeGroup: function(){
      layer.msg('已成功删除[前端群]', {
        icon: 1
      });
      //删除一个群组
      layim.removeList({
        id: 101
        ,type: 'group'
      });
    }
  };
  $("#initmem").on("click",function(){
	
      //增加一个好友
      layim.addList({
        type: 'friend'
        ,avatar: "http://tp2.sinaimg.cn/2386568184/180/40050524279/0"
        ,username: '冲田杏梨'
        ,groupid: 0
        ,id: "1233333312121212"
        ,remark: "本人冲田杏梨将结束AV女优的工作"
      });
	  layer.msg('已成功把[冲田杏梨]添加到好友【网红】组里', {
        icon: 1
      });
  });
  $('.site-demo-layim').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});      
//$(function(){
//	$("#initmem").on("click",initmembers);
//});
//function initmembers() {
//	layer.msg('已成功把[冲田杏梨]添加到好友【网红】组里', {
//        icon: 1
//      });
//      //增加一个好友
//      layim.addList({
//        type: 'friend'
//        ,avatar: "http://tp2.sinaimg.cn/2386568184/180/40050524279/0"
//        ,username: '冲田杏梨'
//        ,groupid: 2
//        ,id: "1233333312121212"
//        ,remark: "本人冲田杏梨将结束AV女优的工作"
//      });
//}
</script>
<p>
<input type="button" id="initmem" value="初始化成员" />
<div class="site-demo-button">
  <button class="layui-btn site-demo-layim" data-type="chat">创造一个临时会话</button>
  <button class="layui-btn site-demo-layim" data-type="message">制造一个好友发过来的消息</button>
  <button class="layui-btn site-demo-layim" data-type="messageTemp">制造一个临时会话消息</button>
  <button class="layui-btn site-demo-layim" data-type="addFriend">增加一个好友</button>
  <button class="layui-btn site-demo-layim" data-type="addGroup">增加一个群组</button>
  <button class="layui-btn site-demo-layim" data-type="removeFriend">删除一个好友</button>
  <button class="layui-btn site-demo-layim" data-type="removeGroup">删除一个群组</button>
  <br>
  <a href="http://layim.layui.com/kefu.html" class="layui-btn site-demo-layim" target="_blank">客服模式</a>
</div>
</body>
</html>