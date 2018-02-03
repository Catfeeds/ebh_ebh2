<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebhportal.css">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebtert.css">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/courses/css/jisrn.css" />
<script type="text/javascript" src="http://static.ebanhui.com/portal/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160414001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002" />
<title><?php echo $item['iname'];?>—精品课堂</title>
<meta name="keywords" content="<?php echo $item['iname'];?>、<?php echo $sorts[0][0]['sname']; ?>、<?php echo $sorts[1][0]['sname']; ?>、<?php echo $sorts[2][0]['sname']; ?>、<?php echo $item['crname']?>">
<meta name="description" content=" <?php echo $item['iname'];?>是网校名称精心制作的精品课程，是具有一流教师队伍、教学内容、教学方法、精美制作等特点的实战性课程，非常适合想要学习<?php echo $sorts[2][0]['sname']; ?>的学生报名学习。">
</head>
<body>
<div class="ebhcceud">
    <div class="pass_e baifff">
        <div class="inftur">
            <div style="float:left;" class="headerleft">
                <a href="/intro/schooliswhat.html" target="_blank" class="linwen">什么是网络学校？</a>
                <a href="http://www.ebh.net/createroom.html" target="_blank" class="linwen">免费创建网校</a>
                <a href="http://ebhdemo.ebh.net" target="_blank" class="linwen">演示网校</a>
            </div>
            <ul class="quick-menu">
               <?php if(empty($user)){?>
                <li class="">
                <a class="linwen" href="javascript:void(0);" onclick="_login()">登录</a>
                </li>
                <li class="">
                <a class="linwen" target="_blank" href="/register.html">免费注册</a>
                </li>
                <?php }else{?>
                <li class="">
                <a class="linwen" style="color: #777;" href="javascript:void(0)">您好 <?= $user['username']?> 欢迎来到e板会！</a>
                </li>
                <?php $homeurl = geturl('homev2');?>
                <li class="">
                <a class="linwen" target="_blank" href="<?=$homeurl?>">个人中心</a>
                </li>
                <li class="">
                <a class="linwen" href="<?=geturl('logout')?>">安全退出</a>
                </li>
                <?php }?>
                <li class="">
                    <a href="/moreapp.html" id="moreapp" class="linwen">更多...</a>
                </li>
            </ul>
            <div style="display:none;" class="askter">
                <ul>
                    <li class="dsldt">
                        <h2 style="cursor:pointer;">教学软件<img src="http://static.ebanhui.com/portal/images/ebh_duoico.png"></h2>
                        <a href="http://intro.ebh.net" target="_blank">微课大师</a>
                        <a href="/intro/livesystem.html" target="_blank">屏幕直播</a>
                        <a href="/intro/examsystem.html" target="_blank">作业组卷</a>
                        <a href="http://soft.ebh.net/ebhbrowser.exe" target="_blank">锁屏浏览器</a>
                        <a href="http://jiazhang.ebh.net/" target="_blank">家长监督</a>
                    </li>
                    <li class="dsldt">
                        <h2 onclick="xredirect('/freeresource.html')" style="cursor:pointer;">免费资源<img src="http://static.ebanhui.com/portal/images/ebh_duoico.png"></h2>
                        <a href="http://xxs.ebh.net" target="_blank">免费网校</a>
                        <a href="/epaper.html" target="_blank">试卷库</a>
                        <a href="/freeresource.html#source" target="_blank">资源库</a>
                        <a href="/freeresource.html#paper" target="_blank">题库</a>
                        <a href="/free.html" target="_blank">视频</a>
                    </li>
                    <li class="dsldt">
                        <h2 onclick="xredirect('/cnews.html')" style="cursor:pointer;">新闻资讯<img src="http://static.ebanhui.com/portal/images/ebh_duoico.png"></h2>
                        <a href="/news.html" target="_blank">新闻动态</a>
                        <a href="/school.html" target="_blank">校园在线</a>
                        <a href="/lfk.html" target="_blank">趣味百科</a>
                        <a href="/itschool.html" target="_blank">网络教学</a>
                        <a href="/motivation.html" target="_blank">成长励志</a>
                    </li>
                    <li class="dsldt">
                        <h2 style="cursor:pointer;">平台应用<img src="http://static.ebanhui.com/portal/images/ebh_duoico.png"></h2>
                        <a href="http://edu.ebh.net" target="_blank">志愿填报</a>
                        <a href="http://pay.ebh.net" target="_blank">充值中心</a>
                        <a href="/intro/app.html" target="_blank">APP应用</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="pass_e2"></div>
<div class="header swbgt">
    <a href="/ke.html">
    <img src="http://static.ebanhui.com/ebh/tpl/courses/images/jkuertlog.jpg" style="float:left;">
    </a>
    <div style="float:left;margin-left:200px;z-index:3;display:inline;" class="kshtfd">
        <input type="text" value="搜索网校、课程等相关内容" id="search" x_hit="搜索网校、课件等相关内容" name="search_title" class="txtlset" style="color:#999" onkeypress="entersearch();">
        <a class="lesort" onclick="dosearch()" id="searchbtn" href="javascript:void(0)">搜索</a>
        <form style="display:none;" target="_blank" id="searchhide" method="get" action="#">
            <input type="hidden" value="" name="q" id="q">
        </form>
    </div>
</div>
<div class="wiasrdn">
    <div class="jfeitd">
        <div class="ter_tits"> <a href="/ke.html">全部课程</a> > <a href="/ke.html?bsid=<?php echo $item['bsid']?>"><?php echo $sorts[0][0]['sname']; ?></a> >  <a href="/ke.html?bsid=<?php echo $item['bsid']?>&misd=<?php echo $item['msid']?>"><?php echo $sorts[1][0]['sname']; ?></a> > <a href="/ke.html?bsid=<?php echo $item['bsid']?>&misd=<?php echo $item['msid']?>&ssid=<?php echo $item['ssid']?>"><?php echo $sorts[2][0]['sname']; ?></a>
        </div>
        <?php if(!empty($item['longblockimg'])){?>
        <img width="414px" height="245px" class="kluisr" src="<?php echo $item['longblockimg']?>" />
        <?php }else{?>
        <img width="414px" height="245px" class="kluisr" src="http://static.ebanhui.com/ebh/tpl/courses/images/shtisut1.jpg" />
        <?php }?>
        <div class="ietjsd" style="margin-bottom: 25px;">
            <h2 class="kuwres"><?php $item['iname'] = htmlspecialchars_decode($item['iname']);if(mb_strlen( $item['iname'], 'utf-8') > 26){$item['iname'] = mb_substr($item['iname'],0,25,'utf-8').'...';} echo $item['iname']?></h2>
            <span class="ketebn">人气：<?php echo $item['viewnum']?></span>
            <span class="kheter">总课时：<?php echo $item['coursewarenum']?>课时</span>
            <p class="uiwerr">来源于<span class="kehtfd"><?php echo $item['crname']?></span></p>
            <p class="egrdze"><span class="hrewrd">￥</span><?php echo $item['iprice']?></p>
            <?php if(empty($aroom)){?>
            <?php if(!empty($permisson)){?>
            <p class="rryfge">有效期至<span class="ndejtr"><?php echo date('Y-m-d',$permisson['enddate'])?></span></p>
            <?php }else{?>
            <p class="rryfge">自报班之日起<span class="ndejtr"><?php if($item['iday'] == 0){echo $item['imonth'].'个月';}else{echo $item['iday'].'天';}?></span>有效期</p>
            <?php }}?>
            <?php if(empty($aroom)){?>
            <?php if(!empty($permisson)){?>
            <a href="javascript:void" class="kehtfs" style="margin-right: 30px;background:#999;">已报名</a>
            <?php }else{?>
            <?php if($item['iprice'] == 0){?>
            <a href="javascript:void" onclick="addPermission(<?php echo $item['itemid']?>)" class="kehtfs dologin" style="margin-right: 30px">立即报名</a>
            <?php }else{?>
            <a href="/jbuy.html?itemid=<?php echo $item['itemid']?>" class="kehtfs dologin" style="margin-right: 30px">立即报名</a>
            <?php }}}?>
            <?php if(empty($aroom)){ $margin = '0px';?>
            <div class="msired">
             
                    <!-- Baidu Button BEGIN -->
                    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>
    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                <!-- Baidu Button END -->
            </div>
            <?php }else{$margin = '21px';}?>
        </div>
       <iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="/ke/study/cwlist/<?php echo $item['folderid']?>.html" style="margin-top: <?php echo $margin;?>"></iframe>        
    </div>
</div>
<script type="text/javascript">
        function _login(){
            tologin('/login.html?returnurl=__url__');
        }
        
        var resetmain = function(){
            var mainFrame = document.getElementById("mainFrame");
            var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+1;
            iframeHeight = iframeHeight<830?830:iframeHeight;
            $(mainFrame).height(iframeHeight);
        }
        $(function(){
            $("#search").focus(function(){
                var search = $(this).val();
                $("#search").css('color','black');
                if(search == '搜索网校、课程等相关内容'){
                    $(this).val('');
                }
            });
            $("#search").blur(function(){
                var search = $(this).val();
                if(search == '' || search == null){
                    $(this).val('搜索网校、课程等相关内容');
                    $(this).css('color','#999');
                }
            });
        });
        function entersearch(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13)
        {
            dosearch();
        }
    }  
    function dosearch(){
            var search = $("#search").val();
            var url = '';
            if(search == '' || search == null || search == '搜索网校、课程等相关内容'){
                //alert('搜索条件不能为空！');
				var d = dialog({
					title:"信息提示",
					content:"搜索条件不能为空！",
					cancel:false,
					width:350,
					okValue:'确定',
					ok: function () {}
				});
				d.showModal();
            }else{
                var url ='/ke.html?search='+search;
                window.location.href = url;
            }
        }
        function addPermission(itemid){
            var itemid = itemid;
            $.ajax({
                type: 'POST',
                url: "<?=geturl('ke/addpermisson')?>",
                data: {itemid:itemid},
                dataType: 'json',
                success: function(data){
                    if(data['status'] == 1){
                         window.location.href=window.location.href;
                    }else if(data['status'] == -1){
                        var message = data['message'];
                        alert(message);
                        window.location.href=window.location.href;
                    }else{
                        var message = data['message'];
                        alert(message);
                        _login()
                    }
                }
            });
        } 
</script>
<?php $this->display('common/footer'); ?>