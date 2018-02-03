 <div class="foot">
      <!-- /*module.foot*/ -->
      <?=$foot?>
      <!-- /*module.foot*/ -->
    </div>
  </div>
</body>
<script src="http://static.ebanhui.com/design/js/main.js?v=<?=getv()?>"></script>
<script>
//登录处理--暂时先写在这里 后续统一到main.js
$(function(){

	if(islogin == 1){//登录后处理
    	var afterloginhtml
		var username = lguser.showname;
		var homeurl =  (lguser.groupid == 5)  ? '/troomv2.html' : '/myroom.html';    
		if(lguser.isadmin ==1){//网校管理员
      		homeurl = '/aroomv3.html'
      		afterloginhtml = '<div class="wrap_login"><a style="margin-right:0;" href="/room/design.html">首页装扮</a><a href="/logout.html" style="">退出</a></div>';
		} else {
      		afterloginhtml = '<div class="wrap_login"><a style="margin-right:0;" href="'+homeurl+'">'+username+'</a><a href="/logout.html" style="">退出</a></div>';
    	}
        $('.loginEvent').bind('click',function(){
          window.location.href = homeurl;
        });
		/*mack开始*/
    	var userface = lguser.face;
    	var lastlogintime = lguser.lastlogintime
    	var afterloginhtmls = '<div class="risfgr"><img width="100" height="100" src="'+userface+'" style="border-radius:50px;"></div><div class="erseasd"><h2 class="waisrd">'+username+'</h2><p class="mdistr">上次登录时间：</p><p class="mdistr">'+lastlogintime+'</p></div><div style="clear: both;"></div><div class="entryandexit"><a href="/logout.html" class="exitbtn fl">退出</a><input class="signbtnexit" value="马上进入" id="enter" name="Submit" type="submit"></div></div>'
        var logintype1 = '<div class="risfgr"><img width="100" height="100" src="'+userface+'" style="border-radius:50px;"></div><div class="erseasd"><h2 class="waisrd">'+username+'</h2><p class="mdistr">上次登录时间：</p><p class="mdistr">'+lastlogintime+'</p></div><div style="clear: both;"></div><div class="entryandexit"><a href="/logout.html" class="tuichu fl"></a><a href="/troomv2.html" class="masjr fr"></a></div>'
        var carouseldata =  $('.login .denser').attr('id');
        if(carouseldata == 'logintype1'){
          $('.login .denser').empty().append(logintype1)
        }else{
          $('.login .denser').empty().append(afterloginhtmls)
        }
		$('.thirdlogin').hide();
		$("#enter").on('click', function() {
           window.location.href = homeurl;
        });
		/*mack结束*/
		$('.login_box').after(afterloginhtml).remove();
    	$('.userregistration').hide();
    	$('.forgotpassword').hide();
    
        if(lguser.groupid == 5) {//教师账号不允许报名
            $('.openState').bind('click',showlogTeacher);
          }
	}else{
		//未登录处理
		var formhtml = '<form id="form1" name="form1" action="/login.html?inajax=1&amp;login_from=classroom" onsubmit="form_submit();return false;"></form>';
		$('.login').append(formhtml);
		$('.login form').append($('.login .denser'));
		
	  	$('.loginEvent').bind('click',logindialog);
	  	$('.userregistration').bind('click',registerdialog);
		$("#nav-reginpage").bind('click',registerdialog);
		$("#nav-login").bind('click',logindialog);
	}
	
	initfooterinfo();
	switchPwd();
});


var registerWindow;
/**
 * 注册弹窗
 */
function registerdialog(){
	var ifheight;
	    $.ajax({
	        url: '/register/getbindstatus.html',
	        async: false,
	        dataType: 'json',
	        type: 'get',
	        success: function(data){
	            //console.log(data);
	            if(data.error_code == 0){
	               if(data.data.mobile_register == 1){
	                    ifheight = 650;
	               }else{
	                    ifheight = 550;
	               }
	            }else{
	                console.log("接口错误")
	            }
	        },
	        error: function(data) {
	            ifheight = 550;
	            //console.log(data);
	        }
	    });
	    

	    height = ifheight;
	    width = 650;
	    url = '/register/inpage.html';
	    var html = '<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'" style="border-radius:6px;"></iframe>';
	    registerWindow = new dialog({
	        id:'register-small-window',
	        title:'用户注册',
	        fixed:true,
	        content:html
	    });
	    registerWindow.showModal();
}

/**
 * 登录弹窗
 */
function logindialog(){
	var loginhtml = '';
	$.ajax({
		url: '<?=geturl('room/design/getajaxhtml')?>',
        async: false,
        data:{'type':'login'},
        dataType: 'html',
        type: 'get',
        success: function(json){
            var loginWindow = new dialog({
                id:'login-small-window',
                title:'用户登录',
                fixed:true,
                content:json
            });
            loginWindow.showModal();
		},
		error:function(){
				console.log('接口请求错误!');
			}       
    });
}

/*时间戳转时间*/
function filtertime(value){
	var d = new Date(parseInt(value) * 1000)
    var year = d.getFullYear(),
    month = (d.getMonth()+1) < 10 ? '0' + (d.getMonth()+1):d.getMonth()+1,
    date = d.getDate() < 10 ? '0' + d.getDate() : d.getDate(),
    hour = d.getHours() < 10 ? '0' + d.getHours() : d.getHours(),
   	minute = d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes(),
    second = d.getSeconds() < 10 ? '0' + d.getSeconds() : d.getSeconds();
    return   year+"-"+month+"-"+date+" "+hour+":"+minute; 
}

/*密码可见与否切换*/
function switchPwd() {
   var passwordeye = $('#passwordeye');
   var showPwd = $("#password");
   passwordeye.off('click').on('click',function(){
       if(passwordeye.hasClass('invisible')){
           passwordeye.removeClass('invisible').addClass('visible');//密码可见
           showPwd.prop('type','text');
       }else{
           passwordeye.removeClass('visible').addClass('invisible');//密码不可见
           showPwd.prop('type','password');
       };
   });     
}

/**
 * 教师不能报名消息弹窗
 * 
 */
function showlogTeacher(){
    var dia = new dialog({
        'id':'signmsg',
        'content':'<div class="PPic"></div><p>教师账号不能报名</p>',
        'skin': "ui-dialog2-tip"
    });
    dia.showModal();
    setTimeout(function () {
        dia.close().remove();
        if (typeof(callback) == 'function') {
            callback();
        }
    }, 2000);
  }

/**
 * 网校地址信息初始化
 */
function initfooterinfo(){
	  $('.contactwaycont .address').html('联系地址:' + roominfo.craddress?roominfo.craddress:'');
	  $('.contactwaycont .hotline').html('电话：' + roominfo.crphone?roominfo.crphone:'');
	  $('.contactwaycont .home').html('邮箱:' + roominfo.cremail?roominfo.cremail:'');
}
</script>
</html>