<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebhportal.css">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebtert.css">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/courses/css/jisrn.css" />
<script type="text/javascript" src="http://static.ebanhui.com/portal/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002" />
<title>精品课堂——为你网罗所有好课。</title>
<meta name="keywords" content="精品课堂、网络课程、在线学习、互联网教育、升学课堂、兴趣特长、职业培训、名师辅导">
<meta name="description" content="精品课堂中的所有课程来自于e板会网络学校中各个知名网校提取的最新优质课程，是具有一流教师队伍、教学内容、教学方法、精美制作等特点的实战性课程。课程种类丰富，价廉物美，选课操作简单，一键报名立即学习">
<style type="text/css">
</style>
</head>
<body>
<div class="ebhcceud">
    <div class="pass_e">
        <div class="inftur">
            <div style="float:left;" class="headerleft">
                <a href="/intro/schooliswhat.html" target="_blank" class="linwen">什么是网络学校？</a>
                <a href="http://www.ebh.net/createroom.html" target="_blank" class="linwen" style="color:#17a8f7;">免费创建网校</a>
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
    <a href="/ke.html"><img src="http://static.ebanhui.com/ebh/tpl/courses/images/jkuertlog.jpg
" style="float:left;"></a>
    <div style="float:left;margin-left:200px;z-index:3;display:inline;" class="kshtfd">
        <input type="text" value="搜索网校、课程等相关内容" id="search" x_hit="搜索网校、课程等相关内容" name="search_title" class="txtlset" style="color:#999" onkeypress="entersearch();">
        <a class="lesort" onclick="dosearch()" id="searchbtn" href="javascript:void(0)">搜索</a>
        <form style="display:none;" target="_blank" id="searchhide" method="get" action="#">
            <input type="hidden" value="" name="q" id="q">
        </form>
    </div>
</div>
<div class="kuetys">
    <div class="tisrwe">
        <div class="ltsire">
            <ul>
            <?php 
            $bsid = $this->input->get('bsid');
            if(!($this->input->get('bsid'))){
                $display = 'none';
                ?>
                <li class="fklisr"><a class="wursk" href="/ke.html">热门课程</a></li>
            <?php }else{ 
                $display = '';
                ?>
                <li class="fklisr"><a class="wursk" href="/ke.html">热门课程</a></li>
               <?php } ?>
               <li class="fklisr"><a class="wursk" href="/ke/guess.html">猜你喜欢</a></li>
               <?php
                    if(!empty($sortsone)){
                    foreach ($sortsone as $key => $value) {
                        if($value['sid'] == $bsid){ ?>
                <li class="fklisr"><a class="wursk dusre" href="/ke.html?bsid=<?php echo $value['sid'];?>"><?php echo $value['sname'];?></a></li>
                        <?php }else{ ?>
                <li class="fklisr"><a class="wursk" href="/ke.html?bsid=<?php echo $value['sid'];?>"><?php echo $value['sname'];?></a></li>
                        <?php }
                    }
                }
                ?>
                <li class="fklisr"><a class="wursk dusre" href="/ke/myclass.html">我的课程</a></li>
            </ul>
        </div>
        <div class="ketds" style="margin-top: 10px;">
        <?php if(!empty($bestitems)){$i=0;?>
            <ul>
            <?php foreach($bestitems as $key=>$value){
                $value['iname'] = htmlspecialchars_decode($value['iname']);
                $value['crname'] = htmlspecialchars_decode($value['crname']);
                $i++;
                if ($i%4 == 0) {
                ?>
                <li class="iuhni" style="margin-right:0px;">
                    <a href="/ke/<?php echo $value['itemid']?>.html" title="<?php echo $value['iname']?>" class="kuetgf" target="_blank">
                    <?php if(!empty($value['longblockimg'])){?>
                        <img width="230px" height="136px" src="<?php echo $value['longblockimg'];?>" alt="<?php echo $value['iname']?>"/>
                        <?php }else{?>
                        <img width="230px" height="136px" src="http://static.ebanhui.com/ebh/tpl/courses/images/shtisut.jpg" alt="<?php echo $value['iname']?>"/>
                        <?php }?>
                    </a>
                    <span class="wrnssrs">共<?php echo $value['coursewarenum']?>课时</span>
                    <h2 class="klejts"><a  title="<?php echo $value['iname']?>" href="/ke/<?php echo $value['itemid']?>.html"><?php if(mb_strlen( $value['iname'], 'utf-8') > 30){$value['iname'] = mb_substr($value['iname'],0,29,'utf-8').'...';}echo $value['iname']?></a></h2>
                    <?php $value['viewnum'] = Ebh::app()->lib('Viewnum')->getViewnum('folder',$value['folderid']);?>
                    <span class="renares"><?php echo $value['viewnum']?></span>
                    <?php if(mb_strlen( $value['crname'], 'utf-8') > 12){
                        $value['crname'] = mb_substr($value['crname'],0,11,'utf-8').'...';
                        }?>
                    <span class="euitsd"><?php echo $value['crname']?></span>
                    <?php if($value['iprice'] == 0){?><p class="lbsrver">免费</p>
                    <?php }else{?>
                    <p class="lsirse">￥<?php echo $value['iprice'];?></p>
                    <?php }?>
                </li>
                <?php } else {?>
                    <li class="iuhni">
                    <a href="/ke/<?php echo $value['itemid']?>.html" title="<?php echo $value['iname']?>" class="kuetgf" target="_blank">
                    <?php if(!empty($value['longblockimg'])){?>
                        <img width="230px" height="136px" src="<?php echo $value['longblockimg'];?>" alt="<?php echo $value['iname']?>"/>
                        <?php }else{?>
                        <img width="230px" height="136px" src="http://static.ebanhui.com/ebh/tpl/courses/images/shtisut.jpg" alt="<?php echo $value['iname']?>"/>
                        <?php }?>
                    </a>
                    <span class="wrnssrs">共<?php echo $value['coursewarenum']?>课时</span>
                    <h2 class="klejts"><a  title="<?php echo $value['iname']?>" href="/ke/<?php echo $value['itemid']?>.html"><?php if(mb_strlen( $value['iname'], 'utf-8') > 30){$value['iname'] = mb_substr($value['iname'],0,29,'utf-8').'...';}echo $value['iname']?></a></h2>
                    <?php $value['viewnum'] = Ebh::app()->lib('Viewnum')->getViewnum('folder',$value['folderid']);?>
                    <span class="renares"><?php echo $value['viewnum']?></span>
                    <?php if(mb_strlen( $value['crname'], 'utf-8') > 12){
                        $value['crname'] = mb_substr($value['crname'],0,11,'utf-8').'...';
                        }?>
                    <span class="euitsd"><?php echo $value['crname']?></span>
                    <?php if($value['iprice'] == 0){?><p class="lbsrver">免费</p>
                    <?php }else{?>
                    <p class="lsirse">￥<?php echo $value['iprice'];?></p>
                    <?php }?>
                </li>

                <?php }?>
            
        <?php }}else{echo '<span style="font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;暂无课程！</span>';}?>
        </ul>
        </div>
  </div>
</div>
<script type="text/javascript">
    var tologin = function(url){
        url = url.replace('__url__',encodeURIComponent(location.href));
        location.href=url;
    }
    function _login(){
        tologin('/login.html?returnurl=__url__');
    }
    $(function(){
        $("#price").mouseover(function(){
            $(".lirtys").show();
        });
        $("#price").mouseleave(function(){
            $(".lirtys").hide();
        });
        $(".lirtys").mouseover(function(){
            $(".lirtys").show();
        });
        $(".lirtys").mouseleave(function(){
            $(".lirtys").hide();
        });
    });
    $(function(){
        $(".fewtfd").click(function(){
            $("#morechoose").show();
            $(".lisrtde1").hide();
        });
        $(".queses").click(function(){
            $("#morechoose").hide();
            $(".lisrtde1").show();
        });
    });
    $(function(){
        $("input:checkbox[name=checkbox]").click(function(){
            var status = $("input:checkbox[name=checkbox]").attr('checked');
            if(status){
                var url = $.UrlUpdateParams(window.location.href, "price", 'free');
            }else{
                var url = $.UrlUpdateParams(window.location.href, "price", '0');
            }
            window.location.href = url;
        })
    })
    function orderby(method){
        var bsid = $.Request('bsid');
        var msid = $.Request('msid');
        var ssid = $.Request('ssid');
        var label_filter = $.Request('label_filter');
        var search = $.Request('search');
        var price = $.Request('price');
        var url = '/ke.html?';
        if(bsid != null && bsid != ''){
            url+='bsid='+bsid;
        }
        if(msid != null && msid != ''){
            url+='&msid='+msid;
        }
        if(ssid != null && ssid != ''){
            url+='&ssid='+ssid;
        }
        if(label_filter != null && label_filter != ''){
            url+='&label_filter='+label_filter;
        }
        if(method == null || method == ''){
            url = url;

        }else{
            url+='&order='+method;
        }
        if(search != null && search!= '' ){
                url+='&search='+search;
        }
        if(price == 'free'){
            url+='&price='+price;
        }
        window.location.href = url;
    }
    $(function(){
        $(".kluehrt1").click(function(){
            if($(this).hasClass('listhfd')){
                var label_filter = '';
                $(this).removeClass('listhfd');
                $(".listhfd").each(function(){
                    label_filter+=$(this).text()+',';
                });
                label_filter=label_filter.substring(0,label_filter.length-1);
                var url = $.UrlUpdateParams(window.location.href, "label_filter", label_filter);
                window.location.href = url; 
            }else{
                $(this).parent().each(function(){
                    $(".kluehrt1").removeClass('listhfd');
                });
                $(this).addClass('listhfd');
                var label_filter = $(this).text();
                var url = $.UrlUpdateParams(window.location.href, "label_filter", label_filter);
                window.location.href = url;  
            }

            
        });
    });
    $(function(){
        var str = '';
        $(".jisrfe").click(function(){
            $('input:checkbox[name=checkbox2]:checked').each(function(i){
                str+=$(this).val();
                str+=',';     
            });
            str=str.substring(0,str.length-1);
            var url = $.UrlUpdateParams(window.location.href, "label_filter", str);
            window.location.href = url;
            str = '';
        });
    });
    (function ($) {
    $.extend({
        Request: function (m) {
            var sValue = location.search.match(new RegExp("[\?\&]" + m + "=([^\&]*)(\&?)", "i"));
            return sValue ? sValue[1] : sValue;
        },
        UrlUpdateParams: function (url, name, value) {
            var r = url;
            if (r != null && r != 'undefined' && r != "") {
                value = encodeURIComponent(value);
                var reg = new RegExp("(^|)" + name + "=([^&]*)(|$)");
                var tmp = name + "=" + value;
                if (url.match(reg) != null) {
                    r = url.replace(eval(reg), tmp);
                }
                else {
                    if (url.match("[\?]")) {
                        r = url + "&" + tmp;
                    } else {
                        r = url + "?" + tmp;
                    }
                }
            }
            return r;
        }
    });
})(jQuery);
    var label_filter = decodeURIComponent($.Request('label_filter'));
    var price = $.Request('price');
    arr = label_filter.split(',');
    $.each(arr, function(i,value){
        $(".kluehrt1").each(function(){
            text = $(this).text();
            if(value == text){
                $(this).addClass('listhfd');
            }
        });
        $('input:checkbox[name=checkbox2]').each(function(){
            var val = $(this).val();
            if(val == value){
                $(this).attr("checked","checked");
            }
        });
    });
    $(function(){
            $("#search").focus(function(){
                var search = $(this).val();
                $('#search').css('color','black');
                if(search == '搜索网校、课程等相关内容'){
                    $(this).val('');
                }
            });
            $("#search").blur(function(){
                var search = $(this).val();
                if(search == '' || search == null){
                    $(this).css('color','#999');
                    $(this).val('搜索网校、课程等相关内容');
                }
            });
        })
     function entersearch(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13)
        {
            dosearch();
        }
    }
    function dosearch(){
        var search = $("#search").val();
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
            var url = '/ke.html?search='+search;
            window.location.href = url;
        }
    }
    $(function(){
        var search = decodeURIComponent($.Request('search'));
        if(search == '' || search == 'null'){
            $('#search').css('color','#999');
        }else{
            $('#search').val(search);
            $('#search').css('color','black');
        }
    })
</script>
<?php $this->display('common/footer'); ?>

