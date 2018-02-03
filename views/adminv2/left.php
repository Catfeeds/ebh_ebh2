<div class="layui-side layui-bg-black" id="admin-side">
<div class="layui-side-scroll" id="admin-navbar-side" lay-filter="side"></div>
</div>
<script>
//黑名单配置
var navs = [{
	"title": "系统设置",
	"icon": "fa-cubes",
	"spread": true,
	"children": [{
		"title": "黑名单设置",
		"icon": "&#xe641;",
		"href": "/adminv2/black.html",
	}]
}];

var tab;

layui.config({
    base: 'http://static.ebanhui.com/adminv2/js/',
    version: new Date().getTime()
}).use(['element', 'layer', 'navbar', 'tab'], function () {
    var element = layui.element(),
        $ = layui.jquery,
        layer = layui.layer,
        navbar = layui.navbar();
    tab = layui.tab({
        elem: '.admin-nav-card' //设置选项卡容器
        ,
        //maxSetting: {
        //	max: 5,
        //	tipMsg: '只能开5个哇，不能再开了。真的。'
        //},
        contextMenu: true,
        onSwitch: function (data) {
            console.log(data.id); //当前Tab的Id
            console.log(data.index); //得到当前Tab的所在下标
            console.log(data.elem); //得到当前的Tab大容器

            console.log(tab.getCurrentTabId())
        }
    });
    //iframe自适应
    $(window).on('resize', function () {
        var $content = $('.admin-nav-card .layui-tab-content');
        $content.height($(this).height() - 147);
        $content.find('iframe').each(function () {
            $(this).height($content.height());
        });
    }).resize();



    //设置navbar
    navbar.set({
        spreadOne: true,
        elem: '#admin-navbar-side',
        cached: true,
        data: navs
		/*cached:true,
		url: 'datas/nav.json'*/
    });
    //渲染navbar
    navbar.render();
    //监听点击事件
    navbar.on('click(side)', function (data) {
        tab.tabAdd(data.field);
    });

    $('.admin-side-toggle').on('click', function () {
        var sideWidth = $('#admin-side').width();
        if (sideWidth === 200) {
            $('#admin-body').animate({
                left: '0'
            }); //admin-footer
            $('#admin-footer').animate({
                left: '0'
            });
            $('#admin-side').animate({
                width: '0'
            });
        } else {
            $('#admin-body').animate({
                left: '200px'
            });
            $('#admin-footer').animate({
                left: '200px'
            });
            $('#admin-side').animate({
                width: '200px'
            });
        }
    });
    
    //全屏-退出
    var isFullscreen = false;
    var showFullScren = function(){
		// 判断各种浏览器，找到正确的方法
    	  var element =  document.documentElement;
	  	  var requestMethod = element.requestFullScreen || //W3C
		  element.webkitRequestFullScreen ||  //Chrome等
		  element.mozRequestFullScreen || //FireFox
		  element.msRequestFullScreen; //IE11
		  if (requestMethod) {
		    requestMethod.call(element);
		    isFullscreen = true;
		  }else if (typeof window.ActiveXObject !== "undefined") {//for Internet Explorer
		    var wscript = new ActiveXObject("WScript.Shell");
		    if (wscript !== null) {
		      wscript.SendKeys("{F11}");
		      isFullscreen = true;
		    }
		  } 
    	
    };
    var closeFullScren = function(){
     	 // 判断各种浏览器，找到正确的方法
  	  var exitMethod = document.exitFullscreen || //W3C
  	  document.mozCancelFullScreen ||  //Chrome等
  	  document.webkitExitFullscreen || //FireFox
  	  document.webkitExitFullscreen; //IE11
  	  if (exitMethod) {
  	    exitMethod.call(document);
  	    isFullscreen = false;
  	  }else if (typeof window.ActiveXObject !== "undefined") {//for Internet Explorer
  	    var wscript = new ActiveXObject("WScript.Shell");
  	    if (wscript !== null) {
  	      wscript.SendKeys("{F11}");
  	      isFullscreen = false;
  	    }
  	  }
    };
    $('.admin-side-full').on('click', function () {
    	//console.log(isFullscreen);
    	if(!isFullscreen){
    		showFullScren();
    		layer.msg('按Esc即可退出全屏');
    	}else{
    		closeFullScren();
    	} 
    });
    //手机设备的简单适配
    var treeMobile = $('.site-tree-mobile'),
        shadeMobile = $('.site-mobile-shade');
    treeMobile.on('click', function () {
        $('body').addClass('site-mobile');
    });
    shadeMobile.on('click', function () {
        $('body').removeClass('site-mobile');
    });

});
</script>

