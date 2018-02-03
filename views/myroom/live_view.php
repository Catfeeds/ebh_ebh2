<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    
	<script type="text/javascript">
		// 加type=1没有移入效果
		function show(url,type) {
			var _iframe = '<iframe src="" id="iframeId" name="iframeId" style="display:none;" frameborder="0" width="100%" height="0" />';
			if(url == '' || typeof(url) == 'undefined'){
				$('body').html('<div id="error_url" style="display:none;">地址参数错误</div>');
				$("#error_url").fadeIn(2000);
				return;
				}
			var old_src = $("#iframeId").attr('src');
			if($('#iframeId').length == 0 || url != old_src){
				$("#iframeId").remove();
				$('#edu_div').append(_iframe);
				$("#iframeId").attr("src",url);
				old_src = url;
				}
			$("#iframeId").css('height',"100%");
			if(type){
				$("#iframeId").show();
			}else{
				$("#iframeId").fadeIn(2000);
			}				
			$('#TBMeetingFlaClient').css({'width':'0','height':'0'});
		}

		function hide() {
			$("#iframeId").fadeOut(1000); 
			$("#iframeId").height("0");
			$("#TBMeetingFlaClient").css({"width":"100%","height":"100%"});
			document.getElementById("TBMeetingFlaClient").voteReturn();
		}

		function hideFromFlash() {
            $("#iframeId").fadeOut(1000); 
            $("#iframeId").height("0");
            $("#TBMeetingFlaClient").css({"width":"100%","height":"100%"});
                
        }

		function hide1() {
			$("#iframeId").fadeOut(1000); 
			$("#iframeId").height("0");
			$("#iframeId").attr('src','');
			$("#TBMeetingFlaClient").css({"width":"100%","height":"100%"});	
		}

		function submit(){
			iframeId.window.subAnswer();
		}

		function overclass(){
			document.getElementById("TBMeetingFlaClient").voteSubmit();
		}
		
		function TbConfNotification_OnMessageRegisted(){
			document.getElementById("TBMeetingFlaClient").joinConfWithVC("techBridge");
		}
		function doloading() {
			setTimeout(hideloading,3000);	
		}
		function hideloading() {
			$(".zb_tip").hide();
		}
	</script> 
       <style type="text/css" media="screen"> 
            html, body  { height:100%; }
            body { margin:0; padding:0; overflow:auto; text-align:center; 
                   background-color: #ffffff; }   
            object:focus { outline:none; }
            #flashContent { display:none; }

        </style>
        <style>
		.zb_tip{text-align:center;font-size:14px; font-family:Microsoft Yahei,STHeiti,Arial; color:#555;}
		.zb_tip img{ vertical-align:middle; margin-right:8px;}
		</style>

        <!-- Enable Browser History by replacing useBrowserHistory tokens with two hyphens -->
        <!-- BEGIN Browser History required section -->
        <!-- END Browser History required section -->  
            
        <script type="text/javascript" src="http://static.ebanhui.com/pan/js/swfobject.js"></script>
    </head>
    <body style='overflow:auto'>
        <!-- SWFObject's dynamic embed method replaces this alternative HTML content with Flash content when enough 
             JavaScript and Flash plug-in support is available. The div is initially hidden so that it doesn't show
             when JavaScript is disabled.
        -->
	<div class="zb_tip"><img src="http://static.ebanhui.com/ebh/images/live_loading.gif" id="s1" />正在打开直播课堂，请稍后...</div>
	<div id = 'edu_div'>
			
	</div>

        <div  id="flashContent">
            <p>
                To view this page ensure that Adobe Flash Player version 
                11.1.0 or greater is installed. 
            </p>
            <script type="text/javascript"> 
                var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
                document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
                                + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
            </script> 
        </div>
        <noscript>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="TBMeetingFlaClient">
                <param name="movie" value="TBMeetingFlaClient.swf?rand=v2.101.150106.1Bate" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#ffffff" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
		        <param name="allowFullscreenInteractive" value="true" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="TBMeetingFlaClient.swf?rand=v2.101.150106.1Bate" width="100%" height="100%">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#ffffff" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
		            <param name="allowFullscreenInteractive" value="true" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                    <p> 
                        Either scripts and active content are not permitted to run or Adobe Flash Player version
                        11.1.0 or greater is not installed.
                    </p>
                <!--<![endif]-->	
                    <a href="http://www.adobe.com/go/getflashplayer">
                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
        </noscript> 
   </body>
   <script type="text/javascript">
		// For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
        var swfVersionStr = "11.1.0";
        // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
        var xiSwfUrlStr = "playerProductInstall.swf";
        var flashvars = {};
        
		/**
		* 第三方集成flash 会议版 必须传递的参数
		*/
        flashvars.nMeetingID = "<?= $course['liveid'] ?>";//会议id
        flashvars.thirdUserName = "<?= $user['username'] ?>";
        flashvars.thirdUserID = "<?= $user['uid'] ?>";//第三方userId(同thirdUserName)
		flashvars.userDisplayName = "<?= empty($user['realname']) ? $user['username'] : $user['realname'] ?>";//用户显示名
		flashvars.inNeedPwd = "1";//hostpassword
		flashvars.meetingPwd = "<?= $meetingPwd ?>";//会议秘密
		flashvars.inJoinType = "join";//jointype
	    flashvars.meetingIp = "chat3.ebh.net";//web ip
		//flashvars.logWsdl = "<?php echo $logWsdl?>";//日志服务器地址 暂时先放在配置文件中在s.php中去获取
		
		/**
		* 第三方集成flash 教育版 必须传递的参数
		*/
		flashvars.meetingTopic = "<?= $course['title'] ?>";//会议主题
		//教育版 从get中获取
	    flashvars.livePlanTime = "<?= $course['submitat'] ?>";//直播开始时间
	    flashvars.lessonDurationTime = "<?= $course['cwlength'] ?>";//直播时长
	    flashvars.teacherName = "教师01";//老师名称
		flashvars.studentsnum = "";//总人数
		flashvars.lectureStatisticsUrl = "";//统计在线时长url
        flashvars.isSynchronization = "1";//是否强制同步
		flashvars.roomListUrl = "";//获取人员列表的地址
		
		
		
		/**
		* 第三方集成flash 需要CDN模式 必须传递的参数
		*/
		
        
        var params = {};
        params.quality = "high";
        params.bgcolor = "#ffffff";
        params.allowscriptaccess = "always";
        params.allowfullscreen = "true";
        params.allowFullscreenInteractive = "true";
        var attributes = {};
        attributes.id = "TBMeetingFlaClient";
        attributes.name = "TBMeetingFlaClient";
        attributes.align = "middle";
        swfobject.embedSWF(
            "http://chat3.ebh.net/flash/TBMeetingFlaClient.swf?rand=v2.101.150106.1Bate", "flashContent", 
            "100%", "100%", 
            swfVersionStr, xiSwfUrlStr, 
            flashvars, params, attributes,doloading);
        	// JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
        swfobject.createCSS("#flashContent", "display:block;text-align:left;");
        
//		document.getElementById("TBMeetingFlaClient").style.display="none";
	</script>
</html>
