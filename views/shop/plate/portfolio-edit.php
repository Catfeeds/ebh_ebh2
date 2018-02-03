<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$roomdetail['crname']?></title>

    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/draglayout.css<?=getv()?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/courseware.css<?=getv()?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/newindex.css?v=201705250004" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/course_type_menu_theme.css<?=getv()?>" />

    <script src="http://static.ebanhui.com/ebh/js/freewall/html5localstorage.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/freewall/json2.js"></script>
    <script src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>


    <script src="http://static.ebanhui.com/ebh/js/dad/js/jquery.dad.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/dad/css/jquery.dad.css" />
    <!--<script src="http://static.ebanhui.com/ebh/js/gridly/js/jquery.gridly.js"></script>-->


    <script src="http://static.ebanhui.com/ebh/js/freewall/freewall.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/freewall/draglayout.js<?=getv()?>"></script>

    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/home.module.set.js<?=getv()?>"></script>

    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/spectrum/spectrum.css">
    <script type="text/javascript" src="http://static.ebanhui.com/js/spectrum/spectrum.js"></script>


    <script language='javascript' type='text/javascript' src='http://static.ebanhui.com/ebh/js/xDialog/xDialog.js'></script>
    <script language='javascript' type='text/javascript' src='http://static.ebanhui.com/ebh/js/xDialog/lib/art/dialog-plus-min.js'></script>
    <link type='text/css' rel='stylesheet' href='http://static.ebanhui.com/ebh/js/xDialog/lib/art/css/ui-dialog.css' />
    <script language='javascript' type='text/javascript' src='http://static.ebanhui.com/ebh/js/xDialog/xDialog.art.js'></script>
    <script language='javascript' type='text/javascript' src='http://static.ebanhui.com/ebh/js/xDialog/vendor/swfobject.js<?=getv()?>'></script>
    <script language='javascript' type='text/javascript' src='http://static.ebanhui.com/ebh/tpl/newschoolindex/theme.js?v=20170516001'></script>

    <script type="text/javascript">
        var debug = <?=intval(IS_DEBUG)?>;
        var courseMenuBgcolor = '';
    </script>

    <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/formulav2Dialog.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/imgeditorDialog.js"></script>

    <script src="http://static.ebanhui.com/ebh/js/formulav4.js<?=getv()?>" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/module2.css?v=201708029001" />
    <style type="text/css">
        body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td
        {margin:0;padding:0}
        address,caption,cite,code,dfn,em,strong,th,var{font-style:inherit;font-weight:inherit}
        h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:inherit}q:before,q:after{content:inherit}

        div.richedit{line-height:2}
        em{font-style: italic;}
        div.richedit strong{font-weight:700;font-style:inherit;}
        div.richedit em{font-style: italic;/*font-style:oblique;*/}

        div.dl-content.richedit{line-height:inherit;line-height:auto;
    </style>
</head>

<body>
<link rel="stylesheet" href="/static/ueditor/dialogsblue.css"><!-- 弹出框样式修改 -->
<?php /*$Upcontrol = Ebh::app()->lib('UpcontrolLib');
$Upcontrol->upcontrol('wechatimg',1,array(),'pic');*/
$imagephp = geturl('uploadimage');?>
<script type="text/javascript">
    /*(function($) {
     var loadingDialog = dialog({
     id: 'sett-loading',
     content: '<img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/plate-setting-loading.gif" alt="loading" />',
     fixed: true,
     width: 500,
     onshow: function() {
     var node = $(this.node).find('.ui-dialog');
     node.css('background', 'none').css('border', '0 none').css('box-shadow', 'none');
     }
     });
     loadingDialog.showModal();
     })(jQuery);*/
    (function($) {
        $.extend({
            'setMenu': function() {
                if ($("#top-menu").size() == 0) {
                    return;
                }
                var baseLine = $("#top-menu").position().top;
                var hiddenIndexArr = [];
                var hiddenMenuHtml = [];
                var menu = $("#top-menu > a.navlista");
                var delStartIndex = -1;
                menu.each(function(index) {
                    var that = $(this);
                    if (that.position().top > baseLine) {
                        hiddenIndexArr.push(index);
                        hiddenMenuHtml.push('<span class="navlista" j-href="' + that.attr('href') + '">' + that.html() + '</span>')
                    }
                });
                var hl = hiddenIndexArr.length;
                if (hl > 0) {
                    var moreMenu = $("#more-top-menu");
                    var moreMenuBox = moreMenu.find("div.navmorelist");
                    moreMenu.css('visibility', 'visible');
                    hl--;
                    var delStartIndex = -1;
                    for (var i = hl; i >= 0; i--) {
                        $(menu.get(hiddenIndexArr[i])).remove();
                        delStartIndex = hiddenIndexArr[i];
                    }
                    if (moreMenu.position().top > baseLine) {
                        delStartIndex--;
                        var that = $(menu.get(delStartIndex));
                        hiddenMenuHtml.unshift('<span class="navlista" j-href="' + that.attr('href') + '">' + that.html() + '</span>')
                        that.remove();
                    }
                    moreMenuBox.html(hiddenMenuHtml.join(''));
                    moreMenuBox.bind('click', function(e) {
                        location.href = $(e.target).attr('j-href');
                        return false;
                    });
                    moreMenu = null;
                    moreMenuBox = null;
                }

                $(".navsMemu").mouseenter(function(){
                    $(".navmore").css("display","block");
                });
                $(".navsMemu").mouseleave(function(){
                    $(".navmore").css("display","none");
                });
            },
            'resetMenu': function() {
                var moreMenu = $("#more-top-menu");
                if (moreMenu.size() == 0) {
                    return;
                }
                moreMenu.css('visibility', 'hidden');
                var menu = $("#top-menu");
                var moreMenu = moreMenu.find("div.navmorelist span");
                if (moreMenu.size() > 0) {
                    var moreMenuBox = $("#more-top-menu");
                    moreMenuBox.remove();
                    moreMenu.each(function() {
                        menu.append('<a class="navlista" href="javascript:;">' + $(this).html() + '</a>');
                        $(this).remove();
                    });
                    menu.append(moreMenuBox);
                }
                $.setMenu();
            },
            'setCourseMenuColor': function() {
                if (courseMenuBgcolor == '') {
                    courseMenuBgcolor = 'ff1f96f2';
                }
                $("#pick-color").spectrum({
                    showPaletteOnly: true,
                    allowEmpty: true,
                    showPalette: true,
                    showAlpha: false,
                    hideAfterPaletteSelect:true,
                    color: courseMenuBgcolor,
                    appendTo: '#course-type',
                    palette: [
                        ['#9b28ae', '#663db5', '#4052b4', '#1f96f2'],
                        ['#ff753f', '#00bcd2', '#fea000', '#f2c300'],
                        ['#b7c500', '#89c34a', '#4daf51', '#009687'],
                        ['#f47d00', '#f34637', '#e71e62', '#c11759']
                    ],
                    'change': function(color) {
                        courseMenuBgcolor = color.toHex8();
                        $("#nav_ul").attr('class', $.theme(courseMenuBgcolor));
                    }
                }).spectrum('set', courseMenuBgcolor);
                $("#nav_ul").attr('class', $.theme(courseMenuBgcolor));
            }
        });
    })(jQuery);
</script>
<div class="custom">
    <div class="topnei">
        <span class="ztitse">自定义装扮</span>
        <a class="defaultbtn" href="javascript:;">恢复默认</a>
        <div class="customrig">
            <a class="exitbtn" href="/">退出</a>
            <a class="savebtn" id="save" href="javascript:;">保存装扮</a>
            <a class="savebtn" id="begin" href="javascript:;" style="display:none;">编辑</a>
        </div>
    </div>
</div>
<div class="choice">
    <h2 class="htset">选择模块添加到首页：</h2>
    <div class="waiblock">
        <ul id="waiblock">
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addlogo" href="javascript:;" rows="1" columns="4" mid="1">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular1.png" />
                </a>
                <span class="fostnse">页头</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addnavigation" href="javascript:;" rows="1" columns="4" mid="2">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular2.png" />
                </a>
                <span class="fostnse">首页导航</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addslide" href="javascript:;" rows="1" columns="4" mid="3">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular3.png" />
                </a>
                <span class="fostnse">轮播大图</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addfree" href="javascript:;" rows="1" columns="3" mid="7">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular4.png" />
                </a>
                <span class="fostnse">免费试听</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addcourselist" href="javascript:;" rows="3" columns="3" mid="11">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular5.png" />
                </a>
                <span class="fostnse">课程列表</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addfineware" href="javascript:;" rows="1" columns="4"  mid="21">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/fineware.png" />
                </a>
                <span class="fostnse">单课列表</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addcoursetype" href="javascript:;" rows="1" columns="1"  mid="0">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_menu.jpg" />
                </a>
                <span class="fostnse">课程分类</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addmanualcourse" href="javascript:;" rows="1" columns="4"  mid="23">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/manualcourse.png" />
                </a>
                <span class="fostnse">自选课程</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addcoursemenus" href="javascript:;" rows="1" columns="4"  mid="24">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/coursenav.png" />
                </a>
                <span class="fostnse">课程导航</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addbundle" href="javascript:;" rows="1" columns="4"  mid="25">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/bundle.png" />
                </a>
                <span class="fostnse">课程包</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addnotice" href="javascript:;" rows="1" columns="4" mid="4">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular7.png" />
                </a>
                <span class="fostnse">滚动通知</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addlogin" href="javascript:;" rows="1" columns="1" mid="6">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular8.png" />
                </a>
                <span class="fostnse">登录框</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addabout" href="javascript:;" rows="1" columns="3" mid="5">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular9.png" />
                </a>
                <span class="fostnse">网校介绍</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addnews" href="javascript:;" rows="1" columns="1" mid="8">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular10.png" />
                </a>
                <span class="fostnse">新闻资讯</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addrank" href="javascript:;" rows="1" columns="1"  mid="14">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular13.png" />
                </a>
                <span class="fostnse">积分排名</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addlatestreport" href="javascript:;" rows="1" columns="1"  mid="15">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular14.png" />
                </a>
                <span class="fostnse">最新报名</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="adddynamic" href="javascript:;" rows="1" columns="1"  mid="16">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular15.png" />
                </a>
                <span class="fostnse">学员动态</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="adduser" href="javascript:;" rows="1" columns="1"  mid="17">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular16.png" />
                </a>
                <span class="fostnse">获取用户名</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addsurvey" href="javascript:;" rows="1" columns="1"  mid="10">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular17.png" />
                </a>
                <span class="fostnse">调查问卷</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addhot" href="javascript:;" rows="1" columns="1"  mid="18">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular18.png" />
                </a>
                <span class="fostnse">热门标签</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addcourserank" href="javascript:;" rows="1" columns="1"  mid="19">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular19.png" />
                </a>
                <span class="fostnse">课程排行榜</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addofficial" href="javascript:;" rows="1" columns="1"  mid="13">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular20.png" />
                </a>
                <span class="fostnse">微信公众号</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addmasters" href="javascript:;" rows="1" columns="4"  mid="22">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/masters.png" />
                </a>
                <span class="fostnse">名师团队</span>
            </li>
            <li class="block">
                <span class="addico"></span>
                <a class="kuasse" data-id="addrichedit" href="javascript:;" rows="1" columns="1"  mid="20">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/richtext.png" />
                </a>
                <span class="fostnse">富文本</span>
            </li>
            <li class="block">
                <span class="addico"></span>
                <a class="kuasse" data-id="addad" href="javascript:;" rows="1" columns="1" mid="9">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular12.png" />
                </a>
                <span class="fostnse">轮播广告</span>
            </li>
            <li class="block">
                <span class="ico"></span>
                <a class="kuasse" data-id="addapp" href="javascript:;" rows="1" columns="1" mid="12">
                    <img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/modular11.png" />
                </a>
                <span class="fostnse">应用</span>
            </li>
        </ul>
    </div>
</div>
</ul>
</div>
</div>
<div class="wraps">
    <!-- 布局面板 -->
    <div class="layoutwrap layoutwrap1">
        <div class="dl-layout" id="freewall1">
        </div>
    </div>
    <div class="layoutwrap layoutwrap2">
        <div class="dl-layout" id="freewall2">
        </div>
    </div>
</div>
<div id="ad-dialog" style="display:none;">
    <div class="slide-edit-ex group unselectabled">注意：图片大小不超过2M，支持JPG、JPEG、GIF、PNG，<span class="n ad-des">最佳尺寸1200*450</span>，最多上传8张<div class="fr ebtn ad-uploader"><a class="deletepicture" href="javascript:;">添加图片</a></div></div>
    <div class="slide-edit">
        <div class="pl ebtn unselectabled"></div>
        <div class="ms unselectabled ad-edit" style="height:320px;">
            <img width="100%" height="100%" src="" class="prev" />
            <img src="" class="prevnext" />
        </div>
        <div class="pr ebtn unselectabled"></div>
    </div>
    <div class="slide-edit-ex group unselectabled">
        <input type="text" class="linkinput" placeholder="请输入链接地址" />
        <lable class="ml20">图片排序</lable>
        <input type="number" min="0" class="order" value="0" maxlength="4" />
        <span class="fr ebtn del">删除图片</span>
    </div>
</div>

<iframe id="free-courseware-dialog" width="805" height="760" frameborder="0" style="display:none">

</iframe>
<div style="height:640px;line-height:640px;margin:0 auto;text-align:center;vertical-align: middle" id="setting-loading">
    <img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/plate-setting-loading.gif" alt="loading" />
</div>
<!--选择课程面板-->
<div style="background-color:#fff;display:none;height:560px;padding:0 10px;" id="choose-courses-panel"><img style="margin:100px 300px;" src="http://static.ebanhui.com/chatroom/layui/css/modules/layer/default/loading-1.gif" /></div>
<div style="background-color:#fff;display:none;height:560px;padding:0 10px;" id="choose-bundles-panel"><img style="margin:100px 300px;" src="http://static.ebanhui.com/chatroom/layui/css/modules/layer/default/loading-1.gif" /></div>
<script type="text/javascript">
    function showsuccess() {
        var tooler = $(".dl-editBar[data-id='free']");
        var box = tooler.find('label.checkRadio');
        var size = parseInt(box.attr('data-size'));
        var freelist = tooler.prev(".dl-main");
        $.ajax({
            'url':'/room/portfolio.html?mid=7&columns='+size+"rows=1",
            'dataType':'html',
            'type':'get',
            'cache':false,
            'success':function(d)  {
                freelist.html(d);
                var baseHeight = 237;
                var freesize = $("#freesize").val();
                var len = $("#free-e ul li").not('.add').size();
                var u = Math.max(Math.ceil(len / freesize), 1);
                var h = baseHeight + ((u - 1) * 320);
                $("#free-e").height(h);
                rebuidefree();
            }
        });
    }
    $(function() {
        if (!Array.prototype.forEach) {
            Array.prototype.forEach = function forEach(callback, thisArg) {

                var T, k;

                if (this === null) {
                    throw new TypeError("this is null or not defined");
                }
                var O = Object(this);
                var len = O.length >>> 0;
                if (typeof callback !== "function") {
                    throw new TypeError(callback + " is not a function");
                }
                if (arguments.length > 1) {
                    T = thisArg;
                }
                k = 0;

                while (k < len) {

                    var kValue;
                    if (k in O) {

                        kValue = O[k];
                        callback.call(T, kValue, k, O);
                    }
                    k++;
                }
            };
        }
        var fragmentTop = screen.width - 50;
        fragmentTop = Math.max(fragmentTop, 1220);
        $("div.layoutwrap1").width(fragmentTop + 2);
        $("#freewall1").width(fragmentTop - 2);
        var ele1 = $("#freewall1")[0];
        var ele2 = $("#freewall2")[0];
        var svnDrag1 = new DragLayout(ele1, {
            selector: ".dl-section",
            cellW: fragmentTop - 4,
            cellH: 10,
            draggable: true
        });
        var svnDrag2 = new DragLayout(ele2, {
            selector: ".dl-section",
            cellW: 305,
            cellH: 330,
            draggable: true
        });
        var cfg = [];
        var storage = window.localStorage;
        var adIndex=0;
        var richEditIndex = 0;
        //可编辑模块数据 *start
        //头图编辑数据
        var logoLocalData = {};
        //二维码编辑数据
        var officialLocalData = {};
        //头部轮播图编辑数据
        var slideLocalData = {};
        //广告轮播图编辑数据
        function setEditStatus(localData) {
            if (localData.slideDataTmp.length >= 8) {
                $(localData.upBtn).eq(1).hide();
            } else {
                $(localData.upBtn).eq(1).show();
            }
            if (localData.slideDataTmp.length > 0) {
                localData.topSlidePrev.show();
            } else {
                localData.topSlidePrev.attr('src', 'http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png').hide();
                localData.linkIpt.val('');
                localData.orderIpt.val('');
            }

            if (localData.slideDataTmp.length > 1) {
                localData.toLeftBtn.show();
                localData.toRightBtn.show();
                localData.topSlideBackground.show();
            } else {
                localData.toLeftBtn.hide();
                localData.toRightBtn.hide();
                localData.topSlideBackground.hide();
            }
        }
        function initEdit(code) {
            if (code == 'logo') {
                logoLocalData.defaultImage = $("#h-top-default-log").val();
                logoLocalData.backgroundColor = $("#h-top-bgcolor").val();
                logoLocalData.backgroundColorTmp = logoLocalData.backgroundColor;
                logoLocalData.colorPicker = null;
                logoLocalData.logo = $("#h-top-logo").val();
                logoLocalData.logoTmp = logoLocalData.logo;
                $("#dl_edit_logo").bind('click', function() {
                    var logoDialog = dialog({
                        'id': 'logoDialog',
                        'title': '上传页头图片',
                        'content': $("#logo-dialog").html(),
                        'fixed': true,
                        'cancelValue': '取消',
                        'okValue': '确定',
                        'onshow': function() {
                            var window = $(this.node);
                            logoLocalData.colorPicker = window.find(".logo-color-picker").spectrum({
                                'color': "#fff",
                                'allowEmpty': true,
                                'chooseText':'确定',
                                'cancelText': '取消',
                                'preferredFormat': "hex",
                                'showInput': true,
                                'showPalette': false,
                                'showInitial':true,
                                'showSelectionPalette': true,
                                'change': function(color) {
                                    if (color) {
                                        $("#logo-edit-btn-area .webuploader-pick").css('background-color', color.toHexString());
                                        logoLocalData.backgroundColorTmp = color.toHexString();
                                    } else {
                                        $("#logo-edit-btn-area .webuploader-pick").css('background-color', '#8493af');
                                        logoLocalData.backgroundColorTmp = '#8493af';
                                    }

                                }
                            });
                            window.find('.uploadpic').attr('id', 'logo-edit-btn-area');
                            window.find('.top-slide-uploader').attr('id', 'replace-header');
                            window.find('.del.deletepicture').bind('click', function() {
                                $("#logo-edit-btn-area img.prev").attr('src', logoLocalData.defaultImage);
                                logoLocalData.logoTmp = '';
                                return true;
                            });
                            /*window.find('.replace.deletepicture').bind('click', function() {
                             $("#logo-edit-btn-area div").eq(1).find('label').trigger('click');
                             $("#logo-edit-btn-area object").trigger('click');
                             return true;
                             });*/
                            uploader.options.formData.target = '#logo-edit-btn-area';
                            uploader.addButton({
                                'id': '#logo-edit-btn-area'
                            });
                            uploader.addButton({
                                'id': '#replace-header'
                            });
                            $("#logo-edit-btn-area img.prev").bind('create', function(e, data) {
                                if (data.bgcolor) {
                                    logoLocalData.backgroundColorTmp = data.bgcolor;
                                    $("#logo-edit-btn-area .webuploader-pick").css('background-color', logoLocalData.backgroundColorTmp);
                                    logoLocalData.colorPicker.spectrum('set', logoLocalData.backgroundColorTmp);
                                }
                                logoLocalData.logoTmp = data.showurl;
                                $(this).attr('src', logoLocalData.logoTmp);
                            });

                            $("#logo-edit-btn-area .webuploader-pick").css('background-color', logoLocalData.backgroundColor);
                            $("#logo-edit-btn-area img.prev").attr('src', logoLocalData.logo || logoLocalData.defaultImage);
                            logoLocalData.colorPicker.spectrum('set', logoLocalData.backgroundColor);
                        },
                        'cancel': function() {
                        },
                        'ok': function() {
                            logoLocalData.backgroundColor = logoLocalData.backgroundColorTmp;
                            logoLocalData.logo = logoLocalData.logoTmp;
                            $("#logo-background").css('background', logoLocalData.backgroundColor);
                            $("#logo-holder").attr('src', logoLocalData.logo || logoLocalData.defaultImage);

                            var cu = JSON.parse(storage.getItem('custom-data'));
                            if (!cu) {
                                cu = {};
                            }
                            cu['logo'] = {
                                'bgcolor': logoLocalData.backgroundColor
                            };
                            if (logoLocalData.logo) {
                                cu['logo']['options'] = [{'image':logoLocalData.logo}];
                                cu['logo']['del'] = 0;
                            } else {
                                cu['logo']['del'] = 1;
                            }
                            var jcu = JSON.stringify(cu);
                            storage.setItem('custom-data', jcu);
                        }
                    });
                    logoDialog.showModal();
                });
                return true;
            }
            if (code == 'slide') {
                var initSlide = JSON.parse($("#h-top-slide-slides").val());
                slideLocalData.topSlideColorPicker = null;
                slideLocalData.backgroundColor = $("#h-top-slide-bgcolor").val();
                slideLocalData.backgroundColorTmp = slideLocalData.backgroundColor;
                slideLocalData.slideData = [];
                slideLocalData.slideDataTmp = [];
                slideLocalData.slideIndex = 0;
                slideLocalData.slidemoveing = false;

                slideLocalData.topSlideBackground = null;
                slideLocalData.topSlidePrev = null;
                slideLocalData.upBtn = null;
                slideLocalData.toLeftBtn = null;
                slideLocalData.toRightBtn = null;
                slideLocalData.linkIpt = null;
                slideLocalData.orderIpt = null;


                if (initSlide instanceof Array) {
                    var l = initSlide.length;
                    for(var i = 0; i < l; i++) {
                        slideLocalData.slideData.push({
                            'image': initSlide[i].image,
                            'href': initSlide[i].href || '',
                            'zindex': initSlide[i].zindex || 0,
                            'bgcolor': initSlide[i].bgcolor || '#8493af'
                        });
                        slideLocalData.slideDataTmp.push({
                            'image': initSlide[i].image,
                            'href': initSlide[i].href || '',
                            'zindex': initSlide[i].zindex || 0,
                            'bgcolor': initSlide[i].bgcolor || '#8493af'
                        });
                    }
                }

                $("#dl_edit_slide").bind('click', function() {
                    var topSlideDialog = dialog({
                        'id': 'topSlideDialog',
                        'title': '编辑轮播大图',
                        'fixed':true,
                        //'webuploader':true,
                        'content': $("#top-slide-dialog").html(),
                        'okValue': '确定',
                        'cancelValue': '取消',
                        'onshow': function() {
                            var window = $(this.node);
                            window.find('.top-slide-uploader').attr('id', 'top-slide-uploader');
                            window.find('.slide-edit').attr('id', 'top-slide-edit');
                            uploader.options.formData.target = '#top-slide-edit';
                            uploader.addButton({
                                'id': '#top-slide-uploader'
                            });
                            slideLocalData.upBtn = "#top-slide-uploader div";
                            slideLocalData.toLeftBtn = window.find(".ebtn.pl");
                            slideLocalData.toRightBtn = window.find(".ebtn.pr");
                            slideLocalData.linkIpt = window.find("input.link");
                            slideLocalData.orderIpt = window.find("input.order");
                            window.find(".top-slide-edit").append('<img id="top-slide-prev" class="prev" src="" style="z-index:100" width="800" height="300" /><img id="top-slide-background" src="" style="z-index:99" width="800" height="300" />');
                            slideLocalData.topSlideBackground = $("#top-slide-background");
                            slideLocalData.topSlidePrev = $("#top-slide-prev");
                            slideLocalData.topSlideColorPicker = window.find(".top-slide-color-picker").spectrum({
                                'color': slideLocalData.backgroundColor,
                                'chooseText':'确定',
                                'allowEmpty': true,
                                'cancelText': '取消',
                                'preferredFormat': "hex",
                                'showInput': true,
                                'showPalette': false,
                                'showInitial':true,
                                'showSelectionPalette': true,
                                'change': function(color) {
                                    if (color) {
                                        $("#top-slide-edit").css('background-color', color.toHexString());
                                        slideLocalData.backgroundColorTmp = color.toHexString();
                                        slideLocalData.slideDataTmp[slideLocalData.slideIndex]['bgcolor'] = color.toHexString();
                                    } else {
                                        $("#top-slide-edit").css('background-color', '#8493af');
                                        slideLocalData.backgroundColorTmp = '#8493af';
                                        slideLocalData.slideDataTmp[slideLocalData.slideIndex]['bgcolor'] = '#8493af';
                                    }
                                }
                            });
                            slideLocalData.linkIpt.bind('blur', function() {
                                if (!IsURL($(this).val())) {
                                    $(this).val('');
                                    if (slideLocalData.slideDataTmp[slideLocalData.slideIndex]) {
                                        slideLocalData.slideDataTmp[slideLocalData.slideIndex].href = '';
                                    }
                                    return false;
                                }
                                if (slideLocalData.slideDataTmp.length > 0 && slideLocalData.slideIndex > -1 &&
                                    slideLocalData.slideIndex < slideLocalData.slideDataTmp.length) {
                                    slideLocalData.slideDataTmp[slideLocalData.slideIndex].href = $(this).val();
                                }
                            });
                            slideLocalData.orderIpt.bind('blur', function() {
                                var n = $(this).val();
                                if (n == '' || isNaN(n)) {
                                    return false;
                                }
                                if (slideLocalData.slideDataTmp.length > 0 && slideLocalData.slideIndex > -1 &&
                                    slideLocalData.slideIndex < slideLocalData.slideDataTmp.length) {
                                    slideLocalData.slideDataTmp[slideLocalData.slideIndex].zindex = parseInt($(this).val());
                                    slideLocalData.slideDataTmp.sort(function(a, b) {
                                        if (a.zindex > b.zindex) {
                                            return 1;
                                        }
                                        return -1;
                                    });
                                }
                            });

                            window.bind('click', function(e) {
                                var t = $(e.target);
                                if (!slideLocalData.slidemoveing && t.hasClass('pr') && t.hasClass('ebtn')) {
                                    if (slideLocalData.slideDataTmp.length <= 0) {
                                        return false;
                                    }
                                    //下一页
                                    slideLocalData.slidemoveing = true;
                                    slideLocalData.slideIndex = (slideLocalData.slideIndex + 1) % slideLocalData.slideDataTmp.length;
                                    slideLocalData.topSlideBackground.attr('src', slideLocalData.slideDataTmp[slideLocalData.slideIndex].image);
                                    slideLocalData.topSlidePrev.animate({ 'left': '800px' }, 300, null, function() {
                                        slideLocalData.topSlidePrev.attr('src', slideLocalData.topSlideBackground.attr('src')).css('left', '0');
                                        if (slideLocalData.slideDataTmp[slideLocalData.slideIndex].href) {
                                            slideLocalData.topSlidePrev.addClass('ebtn');
                                        } else {
                                            slideLocalData.topSlidePrev.removeClass('ebtn');
                                        }
                                        slideLocalData.linkIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].href || '');
                                        slideLocalData.orderIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].zindex);
                                        $("#top-slide-edit").css('background-color', slideLocalData.slideDataTmp[slideLocalData.slideIndex].bgcolor);
                                        slideLocalData.topSlideColorPicker.spectrum('set', slideLocalData.slideDataTmp[slideLocalData.slideIndex].bgcolor);
                                        slideLocalData.slidemoveing = false;
                                    });

                                    return true;
                                }
                                if (!slideLocalData.slidemoveing && t.hasClass('pl') && t.hasClass('ebtn')) {
                                    if (slideLocalData.slideDataTmp.length <= 0) {
                                        return false;
                                    }
                                    //上一页
                                    slideLocalData.slidemoveing = true;
                                    slideLocalData.slideIndex = (slideLocalData.slideIndex + slideLocalData.slideDataTmp.length - 1) % slideLocalData.slideDataTmp.length;
                                    slideLocalData.topSlideBackground.attr('src', slideLocalData.slideDataTmp[slideLocalData.slideIndex].image);
                                    slideLocalData.topSlidePrev.animate({ 'left': '-800px' }, 300, null, function() {
                                        slideLocalData.topSlidePrev.attr('src', slideLocalData.topSlideBackground.attr('src')).css('left', '0');
                                        if (slideLocalData.slideDataTmp[slideLocalData.slideIndex].href) {
                                            slideLocalData.topSlidePrev.addClass('ebtn');
                                        } else {
                                            slideLocalData.topSlidePrev.removeClass('ebtn');
                                        }
                                        slideLocalData.linkIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].href || '');
                                        slideLocalData.orderIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].zindex);
                                        $("#top-slide-edit").css('background-color', slideLocalData.slideDataTmp[slideLocalData.slideIndex].bgcolor);
                                        slideLocalData.topSlideColorPicker.spectrum('set', slideLocalData.slideDataTmp[slideLocalData.slideIndex].bgcolor);
                                        slideLocalData.slidemoveing = false;
                                    });
                                    return true;
                                }
                                if (t.hasClass('prev') && t.hasClass('ebtn')) {
                                    //新标签页打开链接
                                    if (slideLocalData.slideIndex >= slideLocalData.slideDataTmp.length || slideLocalData.slideIndex < 0) {
                                        return false;
                                    }
                                    var a = $("<a href='" + slideLocalData.slideDataTmp[slideLocalData.slideIndex].href + "' target='_blank'>blank</a>").get(0);
                                    var e = document.createEvent('MouseEvents');
                                    e.initEvent('click', true, true);
                                    a.dispatchEvent(e);
                                    return true;
                                }
                            });
                            window.find("span.del").bind('click', function() {
                                if (slideLocalData.slideDataTmp.length <= 0 || slideLocalData.slidemoveing) {
                                    return false;
                                }

                                slideLocalData.slideDataTmp.splice(slideLocalData.slideIndex, 1);
                                setEditStatus(slideLocalData);
                                if (slideLocalData.slideDataTmp.length <= 0) {
                                    slideLocalData.slideIndex = -1;
                                    return true;
                                }
                                slideLocalData.slideIndex = Math.min(slideLocalData.slideIndex, slideLocalData.slideDataTmp.length - 1);
                                slideLocalData.linkIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].href || '');
                                slideLocalData.orderIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].zindex);
                                slideLocalData.topSlidePrev.attr('src', slideLocalData.slideDataTmp[slideLocalData.slideIndex].image);
                                $("#top-slide-edit").css('background-color', slideLocalData.slideDataTmp[slideLocalData.slideIndex].bgcolor);
                                slideLocalData.topSlideColorPicker.spectrum('set', slideLocalData.slideDataTmp[slideLocalData.slideIndex].bgcolor);
                            });


                            //$("#top-slide-edit").css('background-color', slideLocalData.backgroundColor);
                            //slideLocalData.topSlideColorPicker.spectrum('set', slideLocalData.backgroundColor);

                            if (slideLocalData.slideData.length > 0 && slideLocalData.slideData[slideLocalData.slideIndex]) {
                                slideLocalData.topSlidePrev.attr('src', slideLocalData.slideData[slideLocalData.slideIndex].image).show();
                                slideLocalData.linkIpt.val(slideLocalData.slideData[slideLocalData.slideIndex].href);
                                slideLocalData.orderIpt.val(slideLocalData.slideData[slideLocalData.slideIndex].zindex);
                                $("#top-slide-edit").css('background-color', slideLocalData.slideData[slideLocalData.slideIndex].bgcolor);
                                slideLocalData.topSlideColorPicker.spectrum('set', slideLocalData.slideData[slideLocalData.slideIndex].bgcolor);
                            }
                            slideLocalData.slideDataTmp.length = 0;
                            slideLocalData.slideDataTmp = slideLocalData.slideData.slice(0, 8);

                            slideLocalData.topSlidePrev.bind('create', function(event, data) {
                                if (slideLocalData.slideDataTmp.length >= 8) {
                                    return false;
                                }
                                var bgcolor = 'f7f7f7';
                                if (data.bgcolor) {
                                    bgcolor = data.bgcolor;
                                }
                                slideLocalData.slideDataTmp.push({
                                    'image': data.showurl,
                                    'href': '',
                                    'zindex': slideLocalData.slideDataTmp.length > 0 ? (parseInt(slideLocalData.slideDataTmp[slideLocalData.slideIndex].zindex) + 1) : 0,
                                    'bgcolor': bgcolor
                                });
                                slideLocalData.linkIpt.val('');
                                $("#top-slide-edit").css('background-color', bgcolor);
                                slideLocalData.topSlideColorPicker.spectrum('set', bgcolor);
                                if (slideLocalData.slidemoveing) {
                                    return false;
                                }
                                slideLocalData.topSlidePrev.attr('src', data.showurl);
                                if (slideLocalData.slideIndex < 0) {
                                    slideLocalData.slideIndex = 0;
                                }
                                if (slideLocalData.slideDataTmp.length > 0) {
                                    slideLocalData.slideDataTmp.sort(function(a, b) {
                                        if (a.zindex > b.zindex) {
                                            return 1;
                                        }
                                        return -1;
                                    });
                                }
                                setEditStatus(slideLocalData);
                                slideLocalData.orderIpt.val(slideLocalData.slideDataTmp[slideLocalData.slideIndex].zindex);
                            });
                            setEditStatus(slideLocalData);
                        },
                        'cancel': function() {
                            slideLocalData.slideIndex = 0;
                        },
                        'ok': function() {
                            slideLocalData.backgroundColor = slideLocalData.backgroundColorTmp;
                            slideLocalData.slideData.length = 0;
                            slideLocalData.slideData = slideLocalData.slideDataTmp.slice(0, 8);
                            //保存数据到本地
                            var cu = JSON.parse(storage.getItem('custom-data'));
                            if (!cu) {
                                cu = {};
                            }
                            var options = [];
                            for (var i = 0; i < slideLocalData.slideData.length; i++) {
                                if (slideLocalData.slideData[i]) {
                                    options.push({
                                        'image': slideLocalData.slideData[i].image,
                                        'href': slideLocalData.slideData[i].href,
                                        'zindex': slideLocalData.slideData[i].zindex,
                                        'bgcolor': slideLocalData.slideData[i].bgcolor
                                    });
                                }
                            }
                            cu['slide'] = {
                                'bgcolor': slideLocalData.backgroundColor || "",
                                'options': options || [],
                                'del': options.length > 0 ? 0 : 1
                            };
                            var jcu = JSON.stringify(cu);
                            storage.setItem('custom-data', jcu);
                            if (slideLocalData.slideData.length > 0) {
                                $("#slide-holder").attr('src', slideLocalData.topSlidePrev.attr('src')).show();
                            } else {
                                $("#slide-holder").hide();
                            }

                            $("#slide-background").css('background-color', slideLocalData.slideData[slideLocalData.slideIndex].bgcolor);
                        }
                    });
                    topSlideDialog.showModal();
                });
                return true;
            }
            if (code == 'official') {
                officialLocalData.defaultQcode = $("#h-official-default-qcode").val();
                officialLocalData.qcodeTmp = $("#h-official-qcode").val();
                officialLocalData.qcode = officialLocalData.qcodeTmp;
                $("#qcode-edit-btn-area img.prev").attr('src', officialLocalData.qcode);
                $("#dl_edit_official").bind('click', function() {
                    var qcodeDia = new dialog({
                        'id':'qcodeDia',
                        'title':'添加二维码',
                        'cancelValue':'取消',
                        'content':$("#qcode-dialog").html(),
                        'fixed':true,
                        //'webuploader':true,
                        'onshow': function() {
                            var window = $(this.node);
                            window.find('.uploadpic').attr('id', 'qcode-edit-btn-area');
                            uploader.options.formData.target = '#qcode-edit-btn-area';
                            uploader.addButton({
                                'id': '#qcode-edit-btn-area'
                            });
                            window.find("img.prev").attr('src', officialLocalData.qcode || officialLocalData.defaultQcode)
                                .bind('create', function(e, data) {
                                    officialLocalData.qcodeTmp = data.showurl;
                                    $(this).attr('src', officialLocalData.qcodeTmp);
                                });
                            //$('#qcode-dialog').removeClass('webuploader-element-invisible');
                        },
                        'cancel':function() {

                        },
                        'okValue':'确定',
                        'ok':function() {
                            officialLocalData.qcode = officialLocalData.qcodeTmp;
                            $("#qcode").attr('src', officialLocalData.qcode || officialLocalData.defaultQcode);
                            var cu = JSON.parse(storage.getItem('custom-data'));
                            if (!cu) {
                                cu = {};
                            }
                            cu['official'] = {
                                'options': [{'image': officialLocalData.qcode}]
                            };
                            var jcu = JSON.stringify(cu);
                            storage.setItem('custom-data', jcu);
                        }
                    });
                    qcodeDia.showModal();
                });
                return true;
            }
        }
        //可编辑模块数据 *end
        // storage.removeItem("freewallCfg");
        storage.removeItem('custom-data');
        /*载入*/
        // 请求获取配置信息
        $.ajax({
            type: "GET",
            url: "/room/portfolio/config.html",
            cache:false,
            dataType: "json",
            success: function(data) {

                if (data.errno > 0) {
                    return false;
                }
                cfg = data;

                loadModule(cfg);

                return;
            }
        });
        var initLoadArr = [];
        function loadModule(cfg) {

            $.each(cfg, function(i, item) {
                initLoadArr.push(item);
                /*var mid = item.mid;
                 var columns = item.columns;
                 var rows = item.rows || 1;
                 var eid = item.eid || 0;
                 loadModuleContent(item,mid,columns,rows,eid);*/
                if (item.mid == 2) {
                    courseMenuBgcolor = item.background_color;
                }
            });
            //startEdit();
            //dialog.get('sett-loading').close();
            if (initLoadArr.length > 0) {
                var module = initLoadArr.shift();
                var mid = module.mid;
                var columns = module.columns;
                var rows = module.rows || 1;
                var eid = module.eid || 0;
                var hasChildModule = parseInt(module.arg_sign) || 0;
                firstLoadModuleContent(module,mid,columns,rows,eid,hasChildModule);
            }
        }
        function firstLoadModuleContent(item,mid,columns,rows,eid,hasChildModule) {
            // 请求获取内容模块信息
            $.ajax({
                type: "GET",
                url: "/room/portfolio.html?mid=" + mid + "&columns=" + columns + "&rows=" + rows + "&eid="+eid,
                dataType: "html",
                async:true,
                cache: false,
                success: function(data) {
                    if ($("#setting-loading").size() > 0) {
                        $("#setting-loading").remove();
                    }

                    $("[data-id='add"+item.code+"']").prev().addClass("okico");
                    switch (item.show_type) {
                        case "1":
                            svnDrag1.addModule({
                                eid:item.eid,
                                id: item.code,
                                title: "",
                                content: data,
                                size: "size4",
                                cellW: fragmentTop - 4,
                                cellH: 10,
                                editBar: {
                                    editable:item.editable,
                                    size:item.area_sign
                                },
                                left: item.left,
                                top: item.top,
                                show_type: item.show_type
                            },item.mid);
                            if (item.code == 'navigation') {
                                $.setMenu();
                                if (hasChildModule) {
                                    $.ajax({
                                        type: 'GET',
                                        url: '/room/portfolio/index.html',
                                        dataType: 'text',
                                        success: function(data) {
                                            if ($("#top-menu a").size() > 0) {
                                                $(data).insertBefore("#top-menu a:first");
                                            } else {
                                                $("#top-menu").html(data);
                                            }

                                            $("a.kuasse[data-id='addcoursetype']").prev('span.ico').addClass('okico');
                                            $("#del-course-menu").bind('click', function() {
                                                $("#del-course-menu").unbind('click');
                                                $("#pick-color").unbind('click');
                                                var childModule = $("a[mid='0']");
                                                if (childModule.size() == 1) {
                                                    var icon = childModule.prev('span.ico');
                                                    icon.removeClass('okico');
                                                }
                                                $("#course-type").remove();
                                            });
                                            $.setCourseMenuColor();
                                            $.resetMenu();
                                        }
                                    });
                                }
                            }
                            initEdit(item.code);
                            break;
                        case "2":
                            if(item.code=="ad"){
                                svnDrag2.addModule({
                                    index:adIndex,
                                    eid:item.eid,
                                    id: item.code+"_"+adIndex,
                                    title:"",
                                    content: data,
                                    size: "size" + item.columns,
                                    cellW: 305,
                                    cellH: 330,
                                    renameable:item.renameable,
                                    editBar: {
                                        editable:item.editable,
                                        size:item.area_sign
                                    },
                                    left: item.left,
                                    top: item.top,
                                    show_type: item.show_type
                                },item.mid);

                                adIndex++;
                            }else{
                                svnDrag2.addModule({
                                    eid:item.eid,
                                    id: item.code,
                                    title: item.ititle || item.ctitle,
                                    content: data,
                                    size: "size" + item.columns,
                                    cellW: 305,
                                    cellH: 330,
                                    renameable:item.renameable,
                                    editBar: {
                                        editable:item.editable,
                                        size:item.area_sign
                                    },
                                    left: item.left,
                                    top: item.top,
                                    show_type: item.show_type
                                },item.mid);
                            }
                            if (item.code == 'official' || item.code == 'ad') {
                                initEdit(item.code);
                            }
                            break;
                        case "3":
                            if (item.mid == 20) {
                                svnDrag2.addModule({
                                    index:richEditIndex,
                                    eid:item.eid,
                                    id: item.code+"_"+richEditIndex,
                                    title:"",
                                    content: '<div class="richtext" style="overflow: hidden;">' + data + '</div>',
                                    size: "size" + item.columns,
                                    cellW: 305,
                                    cellH: 330,
                                    renameable:item.renameable,
                                    editBar: {
                                        editable:item.editable,
                                        size:item.area_sign
                                    },
                                    left: item.left,
                                    top: item.top,
                                    show_type: item.show_type
                                },item.mid);

                                richEditIndex++;
                                break;
                            }
                            svnDrag2.addModule({
                                eid:item.eid,
                                id: item.code,
                                title: item.ititle || item.ctitle,
                                content: data,
                                size: "size" + item.columns,
                                cellW: 305,
                                cellH: 330,
                                renameable:item.renameable,
                                editBar: {
                                    editable:item.editable,
                                    size:item.area_sign
                                },
                                left: item.left,
                                top: item.top,
                                show_type: item.show_type
                            },item.mid);
                            if(item.mid == 7){
                                //免费试听
                            }
                            if(item.mid == 22){
                                //名师团队
                                $('.team_botm').dad({  		//当名师团队dom渲染完成后调用插件实现可拖拽
                                    draggable: 'img',		//该参数表示只能在img标签内拖拽才可用
                                    callback: function(){	//拖拽完成时的回调
                                        $("#add_team_bk").show();
                                        var tidsArr = [];
                                        for(var i=0;i<$(".team_bk_t").length-1;i++){
                                            tidsArr.push($($(".team_bk_t")[i]).attr("tid"));
                                        }
                                        $.ajax({
                                            type: "post",
                                            url: '/room/portfolio/ajax_order_master.html',
                                            data:{'tids':tidsArr},
                                            async:true,
                                            dataType: 'json',
                                            success:function(data){

                                            }
                                        });
                                    }
                                });
//                          	console.log($(".delmovet"));
                                //这里做删除操作
                                $(".delmovet").on("click",function(){
                                    var tid = $(this).parent().attr("tid");
                                    $(this).parent().remove();
                                    $.ajax({
                                        type:"post",
                                        url:"/room/portfolio/ajax_remove_master.html",
                                        data:{"masterid":tid},
                                        async:true,
                                        success:function(data){
                                            var liLength = $("#master-choose li").length;
                                            for(var i=0;i<liLength;i++){
                                                if($($("#master-choose li")[i]).attr("tid") == tid){
                                                    $($("#master-choose li")[i]).remove();
                                                    continue;
                                                }
                                            }
                                            console.log(1);
                                            var alength = $("#master-all .lisnres").length;
                                            for(var j=0;j<alength;j++){
                                                if($($("#master-all .lisnres")[j]).attr("tid") == tid){
                                                    $($("#master-all .lisnres")[j]).removeClass("onlock");
                                                    return false;
                                                }
                                            }
                                        },
                                        error:function(data){
                                            console.log(data);
                                        }
                                    });
                                    rebuidemaster();
                                });


//                          	$('.team_botm').gridly();
//                          	var ele3 = $(".dl-main");
//                          	var svnDrag3 = new DragLayout(ele3, {
//			                        selector: ".team_bk_t",
//			                        cellW: 247,
//			                        cellH: 228,
//			                        draggable: true
//			                    });
                            }
                            break;
                        default:
                    }
                    if (initLoadArr.length > 0) {
                        var module = initLoadArr.shift();
                        var mid = module.mid;
                        var columns = module.columns;
                        var rows = module.rows || 1;
                        var eid = module.eid || 0;
                        var hs = parseInt(module.arg_sign) || 0;
                        firstLoadModuleContent(module,mid,columns,rows,eid,hs)
                    } else {
                        startEdit();
                    }
                }
            });
        }
        function loadModuleContent(item,mid,columns,rows,eid) {
            // 请求获取内容模块信息
            $.ajax({
                type: "GET",
                url: "/room/portfolio.html?mid=" + mid + "&columns=" + columns + "&rows=" + rows + "&eid="+eid,
                dataType: "html",
                async:false,
                cache: false,
                success: function(data) {
                    $("[data-id='add"+item.code+"']").prev().addClass("okico");
                    switch (item.show_type) {
                        case "1":
                            svnDrag1.addModule({
                                eid:item.eid,
                                id: item.code,
                                title: "",
                                content: data,
                                size: "size4",
                                cellW: fragmentTop - 4,
                                cellH: 50,
                                editBar: {
                                    editable:item.editable,
                                    size:item.area_sign
                                },
                                left: item.left,
                                top: item.top,
                                show_type: item.show_type
                            },item.mid);
                            initEdit(item.code);
                            break;
                        case "2":
                            if(item.code=="ad"){
                                svnDrag2.addModule({
                                    index:adIndex,
                                    eid:item.eid,
                                    id: item.code+"_"+adIndex,
                                    title:"",
                                    content: data,
                                    size: "size" + item.columns,
                                    cellW: 305,
                                    cellH: 330,
                                    renameable:item.renameable,
                                    editBar: {
                                        editable:item.editable,
                                        size:item.area_sign
                                    },
                                    left: item.left,
                                    top: item.top,
                                    show_type: item.show_type
                                },item.mid);

                                adIndex++;
                            }else{
                                svnDrag2.addModule({
                                    eid:item.eid,
                                    id: item.code,
                                    title: item.ititle || item.ctitle,
                                    content: data,
                                    size: "size" + item.columns,
                                    cellW: 305,
                                    cellH: 330,
                                    renameable:item.renameable,
                                    editBar: {
                                        editable:item.editable,
                                        size:item.area_sign
                                    },
                                    left: item.left,
                                    top: item.top,
                                    show_type: item.show_type
                                },item.mid);
                            }
                            if (item.code == 'official' || item.code == 'ad') {
                                initEdit(item.code);
                            }
                            break;
                        case "3":
                            if (mid == 20) {
                                svnDrag2.addModule({
                                    index:richEditIndex,
                                    eid:item.eid,
                                    id: item.code+"_"+richEditIndex,
                                    title:"",
                                    content: '<div class="richtext" style="overflow: hidden;">' + data + '</div>',
                                    size: "size" + item.columns,
                                    cellW: 305,
                                    cellH: 330,
                                    renameable:item.renameable,
                                    editBar: {
                                        editable:item.editable,
                                        size:item.area_sign
                                    },
                                    left: item.left,
                                    top: item.top,
                                    show_type: item.show_type
                                },item.mid);

                                richEditIndex++;
                                break;
                            }
                            svnDrag2.addModule({
                                eid:item.eid,
                                id: item.code,
                                title: item.ititle || item.ctitle,
                                content: data,
                                size: "size" + item.columns,
                                cellW: 305,
                                cellH: 330,
                                renameable:item.renameable,
                                editBar: {
                                    editable:item.editable,
                                    size:item.area_sign
                                },
                                left: item.left,
                                top: item.top,
                                show_type: item.show_type
                            },item.mid);
                            break;
                        default:
                    }
                }
            });
        }
        /*编辑*/
        /*$("#begin").on("click", function() {
         if ($(ele1).parent(".layoutwrap").hasClass("dl-normal")) {
         $(ele1).parent(".layoutwrap").removeClass("dl-normal");
         $(ele2).parent(".layoutwrap").removeClass("dl-normal");
         $(".choice").animate({
         "marginTop":"-250px"
         },400,"swing");
         } else {
         $(ele1).parent(".layoutwrap").addClass("dl-normal");
         $(ele2).parent(".layoutwrap").addClass("dl-normal");
         $(".choice").animate({
         "marginTop":"50px"
         },400,"swing");
         }
         });*/
        /*设置初始编辑状态*/
        function startEdit() {
            if ($(ele1).parent(".layoutwrap").hasClass("dl-normal")) {
                $(ele1).parent(".layoutwrap").removeClass("dl-normal");
                $(ele2).parent(".layoutwrap").removeClass("dl-normal");
                $(".choice").animate({
                    "marginTop": "-250px"
                }, 400, "swing");
            } else {
                $(ele1).parent(".layoutwrap").addClass("dl-normal");
                $(ele2).parent(".layoutwrap").addClass("dl-normal");
                $(".choice").animate({
                    "marginTop": "50px"
                }, 400, "swing");
            }
        }
        /*保存*/
        $("#save").on("click", function() {
            var arr = [];
            var modules = $(".dl-section");
            var len = modules.length;
            var module;
            var custom=JSON.parse(storage.getItem("custom-data"))||{};
            var copycfg=cfg.concat();
            for (var i = 0; i < len; i++) {
                module = modules.eq(i);
                for(var item in copycfg){
                    if (copycfg[item].code == module.attr("data-id").split("_")[0]) {
                        switch (parseInt(copycfg[item].show_type)) {
                            case 1:
                                if (copycfg[item].mid == 2) {
                                    var hasChild = 0;
                                    var childModule = $("a[mid='0']");
                                    if (childModule.size() == 1) {
                                        var icon = childModule.prev('span.ico');
                                        if (icon.hasClass('okico')) {
                                            hasChild = 1;
                                        }
                                    }
                                    arr.push($.extend(copycfg[item], {
                                        eid:module.attr("data-eid"),
                                        left: module.position().left,
                                        top: module.position().top,
                                        arg_sign: hasChild,
                                        background_color: courseMenuBgcolor,
                                        custom_data:custom[module.attr("data-id")]
                                    }));
                                } else {
                                    arr.push($.extend(copycfg[item], {
                                        eid:module.attr("data-eid"),
                                        left: module.position().left,
                                        top: module.position().top,
                                        custom_data:custom[module.attr("data-id")]
                                    }));
                                }
                                break;
                            case 2:
                                arr.push($.extend(copycfg[item], {
                                    index:module.attr("data-index"),
                                    eid:module.attr("data-eid"),
                                    ititle: module.find(".dl-title input").val(),
                                    left: module.position().left,
                                    top: module.position().top,
                                    width: module.outerWidth(true),
                                    height: module.outerHeight(true),
                                    columns: module.outerWidth(true) / 305,
                                    rows: module.outerHeight(true) / 330,
                                    custom_data:custom[module.attr("data-id")]
                                }));
                                break;
                            case 3:
                                var cc = custom[module.attr('data-id')];
                                if (cc) {
                                    arr.push($.extend(copycfg[item], {
                                        index:module.attr("data-index"),
                                        eid:module.attr("data-eid"),
                                        ititle: module.find(".dl-title input").val(),
                                        left: module.position().left,
                                        top: module.position().top,
                                        width: module.outerWidth(true),
                                        height: module.outerHeight(true),
                                        columns: module.outerWidth(true) / 305,
                                        rows: module.outerHeight(true) / 330,
                                        custom_data:custom[module.attr("data-id")]
                                    }));
                                } else {
                                    arr.push($.extend(copycfg[item], {
                                        index:module.attr("data-index"),
                                        eid:module.attr("data-eid"),
                                        ititle: module.find(".dl-title input").val(),
                                        left: module.position().left,
                                        top: module.position().top,
                                        width: module.outerWidth(true),
                                        height: module.outerHeight(true),
                                        columns: module.outerWidth(true) / 305,
                                        rows: module.outerHeight(true) / 330,
                                        custom_data:null
                                    }));
                                }

                                break;
                            default:
                                break;
                        }
                        delete copycfg[item];
                        break;
                    }
                }
            }
            //需要存储到数据库的JSON
            $.ajax({
                type: "POST",
                url: "/room/portfolio/save_config.html",
                data: JSON.stringify(arr),
                dataType: "json",
                success: function(data) {
                    if (data.errno > 0) {
                        var di = dialog({
                            'id':'di',
                            'content':'<div class="PPic"></div><p>'+data.msg+'</p>',
                            'skin': "ui-dialog2-tip"
                        });
                        di.showModal();
                        setTimeout(function () {
                            di.close().remove();
                        }, 2000);
                        return false;
                    }
                    var l = data.data.length;//{"errno":0,"data":["ad-0-32","ad-1-35","ad-2-34"]}
                    for(var i = 0; i < l; i++) {
                        var arg = data.data[i].split('-');
                        if (arg[1] == 'm') {
                            $(".dl-section[data-id='"+arg[0]+"']").attr('data-eid', arg[2]);
                            continue;
                        }
                        $(".dl-section[data-id='"+arg[0]+"_"+arg[1]+"']").attr('data-eid', arg[2]);
                    }

                    var fd = dialog({
                        'id':'fd',
                        'content':'<div class="TPic"></div><p>首页装扮已更新</p>',
                        'skin': "ui-dialog2-tip"
                    }).showModal();
                    setTimeout(function () {
                        fd.close().remove();
                        if (!debug) {
                            location.href="/";
                        }
                    }, 2000);
                    return false;
                }
            });
            /*缓存数据到svnfreewallAll*/
            storage.setItem("svnfreewallAll",JSON.stringify(arr));

        });

        /*尺寸变化*/
        $(".dl-editBar input[type=radio]").on("click", function() {
            var cfg = {
                id: $(this).attr("data-id"),
                columns: $(this).attr("data-size").replace("columns")
            };
            var div = moduleDataList.getModuleContent(cfg);
            $(id).find(".dl-main").html("").append(div);
        });

        /*添加模块*/
        $(".kuasse").on("click", function() {
            var mid=$(this).attr("mid");
            if($(this).prev(".ico").hasClass("okico")){
                $(this).prev(".ico").removeClass("okico");
                if (mid == 0) {
                    $("#del-course-menu").unbind('click');
                    $("#pick-color").unbind('click');
                    $("#course-type").remove();
                    $.resetMenu();
                    return;
                }
                if (mid == 2) {
                    //移除选项卡,先移除课程分类模块
                    var childModule = $("a[mid='0']");
                    if (childModule.size() == 1) {
                        var icon = childModule.prev('span.ico');
                        if (icon.hasClass('okico')) {
                            $("#del-course-menu").unbind('click');
                            $("#pick-color").unbind('click');
                            childModule.trigger('click');
                            icon.removeClass('okico');
                        }
                    }
                }
                if(mid==1||mid==2||mid==3||mid==4){
                    svnDrag1.getModule($(this).attr("data-id").replace("add", "")).remove();
                }else{
                    svnDrag2.getModule($(this).attr("data-id").replace("add", "")).remove();
                }
            }else{
                $(this).prev(".ico").addClass("okico");
                var id = $(this).attr("data-id").replace("add", "");
                var rows=$(this).attr("rows");
                var columns=$(this).attr("columns");


                if(mid == 20) {
                    //富文本模块，直接脚本处理
                    var richedit = {
                        mid: 20,
                        code: 'richedit',
                        ctitle: '富文本',
                        show_type: 3,
                        renameable: 0,
                        backgroundable: 0,
                        editable: 1,
                        area_sign: [1, 2, 3, 4],
                        rows: 1,
                        columns: 1
                    };

                    cfg.push(richedit);

                    svnDrag2.addModule({
                        index:richEditIndex,
                        eid:0,
                        id: 'richedit_'+richEditIndex,
                        title:"",
                        content: '<div class="richtext" style="overflow: hidden;"></div>',
                        size: "size" + 1,
                        renameable:false,
                        editBar: {
                            editable:true,
                            size:[1,2,3,4]
                        },
                        cellW: 305,
                        cellH: 330,
                        show_type: 3
                    },0);
                    if (!debug) {
                        var top = $("div[data-id='richedit_"+richEditIndex+"']").offset().top - 50;
                        $(window).scrollTop(top);
                    }
                    richEditIndex++;
                    return;
                }

                if (mid == 0) {
                    //添加课程分类模块，先添加选项卡模块
                    var parentModule = $("a[mid='2']");
                    if (parentModule.size() == 1) {
                        var icon = parentModule.prev('span.ico');
                        if (!icon.hasClass('okico')) {
                            $.ajax({
                                type: "GET",
                                url: "/room/portfolio/getModuleSet.html?mid=" + 2 + "&columns=" + 4,
                                dataType: "json",
                                success: function(data) {
                                    var mcfg = data;
                                    $.extend(mcfg,{
                                        rows:1,
                                        columns:4
                                    });
                                    cfg.push(mcfg);
                                    if(mcfg.code=='navigation'){
                                        var mid = mcfg.mid;
                                        $.ajax({
                                            type: "GET",
                                            url: "/room/portfolio.html?mid=" + mid + "&columns=4&rows=1",
                                            dataType: "html",
                                            cache: false,
                                            success: function(data) {
                                                svnDrag1.addModule({
                                                    eid:0,
                                                    id: mcfg.code,
                                                    title: "",
                                                    content: data,
                                                    size: "size4",
                                                    cellW: fragmentTop - 4,
                                                    cellH: 50,
                                                    editBar: {
                                                        editable:mcfg.editable,
                                                        size:mcfg.area_sign
                                                    },
                                                    show_type: mcfg.show_type
                                                },0);
                                                icon.addClass('okico');
                                                initEdit(mcfg.code);
                                                $.setMenu();
                                                if (!debug) {
                                                    var top = $("div[data-id='"+mcfg.code+"']").offset().top - 50;
                                                    $(window).scrollTop(top);
                                                }
                                                $.ajax({
                                                    type: 'GET',
                                                    url: '/room/portfolio/index.html',
                                                    dataType: 'text',
                                                    success: function(data) {
                                                        if($("#top-menu a").size() > 0) {
                                                            $(data).insertBefore("#top-menu a:first");
                                                        } else {
                                                            $("#top-menu").html(data);
                                                        }

                                                        $("#del-course-menu").bind('click', function() {
                                                            $("#del-course-menu").unbind('click');
                                                            $("#pick-color").unbind('click');
                                                            var childModule = $("a[mid='0']");
                                                            if (childModule.size() == 1) {
                                                                var icon = childModule.prev('span.ico');
                                                                icon.removeClass('okico');
                                                            }
                                                            $("#course-type").remove();
                                                        });
                                                        $.setCourseMenuColor();
                                                        $.resetMenu();
                                                    }
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                            return;
                        }
                        //$('<div id="course-type" style="float:left;border:1px solid #f00;width:200px;position:relative;background-color:#f0a30a;height:50px;"><div style="position:absolute;top:0;left:0;width:200px;z-index:999999999;border:1px solid #f00;"><div id="nav"><ul id="nav_ul"><li class="first_li"><p>全部课程</p></li></div></div></div>').insertBefore("#top-menu a:first");
                        //$.resetMenu();
                    }
                    $.ajax({
                        type: 'GET',
                        url: '/room/portfolio/index.html',
                        dataType: 'text',
                        success: function(data) {
                            if ($("#top-menu a").size() > 0) {
                                $(data).insertBefore("#top-menu a:first");
                            } else {
                                $("#top-menu").html(data);
                            }

                            $("#del-course-menu").bind('click', function() {
                                $("#del-course-menu").unbind('click');
                                $("#pick-color").unbind('click');
                                var childModule = $("a[mid='0']");
                                if (childModule.size() == 1) {
                                    var icon = childModule.prev('span.ico');
                                    icon.removeClass('okico');
                                }
                                $("#course-type").remove();
                            });
                            $.setCourseMenuColor();
                            $.resetMenu();
                        }
                    });
                    return;
                }
                $.ajax({
                    type: "GET",
                    url: "/room/portfolio/getModuleSet.html?mid=" + mid + "&columns=" + columns,
                    dataType: "json",
                    success: function(data) {
                        var mcfg = data;
                        var flag=true;
                        $.each(cfg,function (i,item) {
                            if(item.code==mcfg.code&&item.code!="ad"){
                                flag=false;
                            }
                        });
                        if(flag){
                            $.extend(mcfg,{
                                rows:rows,
                                columns:columns
                            });
                            cfg.push(mcfg);
                        }
                        if(mcfg.code==id){
                            var mid = mcfg.mid;
                            $.ajax({
                                type: "GET",
                                url: "/room/portfolio.html?mid=" + mid + "&columns=" + columns + "&rows=" + rows + "",
                                dataType: "html",
                                cache: false,
                                success: function(data) {
                                    switch (mcfg.show_type) {
                                        case "1":
                                            svnDrag1.addModule({
                                                eid:0,
                                                id: mcfg.code,
                                                title: "",
                                                content: data,
                                                size: "size4",
                                                cellW: fragmentTop - 4,
                                                cellH: 10,
                                                editBar: {
                                                    editable:mcfg.editable,
                                                    size:mcfg.area_sign
                                                },
                                                show_type: mcfg.show_type
                                            },0);
                                            if (mcfg.code == 'navigation') {
                                                $.setMenu();
                                            }
                                            initEdit(mcfg.code);
                                            if (!debug) {
                                                var top = $("div[data-id='"+mcfg.code+"']").offset().top - 50;
                                                $(window).scrollTop(top);
                                            }
                                            break;
                                        case "2":
                                            if(mcfg.mid==9){

                                                svnDrag2.addModule({
                                                    index:adIndex,
                                                    eid:0,
                                                    id: mcfg.code+"_"+adIndex,
                                                    title:"",
                                                    content: data,
                                                    size: "size" + columns,
                                                    renameable:mcfg.renameable,
                                                    editBar: {
                                                        editable:mcfg.editable,
                                                        size:mcfg.area_sign
                                                    },
                                                    cellW: 305,
                                                    cellH: 330,
                                                    show_type: mcfg.show_type
                                                },0);
                                                if (!debug) {
                                                    var top = $("div[data-id='"+mcfg.code+"_"+adIndex+"']").offset().top - 50;
                                                    $(window).scrollTop(top);
                                                }
                                                adIndex++;
                                            }else{
                                                svnDrag2.addModule({
                                                    eid:0,
                                                    id: mcfg.code,
                                                    title: mcfg.ititle || mcfg.ctitle,
                                                    content: data,
                                                    renameable:mcfg.renameable,
                                                    editBar: {
                                                        editable:mcfg.editable,
                                                        size:mcfg.area_sign
                                                    },
                                                    size: "size" + columns,
                                                    cellW: 305,
                                                    cellH: 330,
                                                    show_type: mcfg.show_type
                                                },0);
                                                if (!debug) {
                                                    var top = $("div[data-id='"+mcfg.code+"']").offset().top - 50;
                                                    $(window).scrollTop(top);
                                                }
                                            }
                                            if (mcfg.code == 'official' || mcfg.code == 'ad') {
                                                initEdit(mcfg.code);
                                            }
                                            break;
                                        case "3":
                                            svnDrag2.addModule({
                                                eid:0,
                                                id: mcfg.code,
                                                title: mcfg.ititle || mcfg.ctitle,
                                                content: data,
                                                size: "size" + columns,
                                                renameable:mcfg.renameable,
                                                editBar: {
                                                    editable:mcfg.editable,
                                                    size:mcfg.area_sign
                                                },
                                                cellW: 305,
                                                cellH: 330,
                                                show_type: mcfg.show_type
                                            },0);
                                            if(mcfg.mid == 22){
                                                $('.team_botm').dad({  		//当名师团队dom渲染完成后调用插件实现可拖拽
                                                    draggable: 'img',		//该参数表示只能在img标签内拖拽才可用
                                                    callback: function(){	//拖拽完成时的回调
                                                        $("#add_team_bk").show();
                                                        var tidsArr = [];
                                                        for(var i=0;i<$(".team_bk_t").length-1;i++){
                                                            tidsArr.push($($(".team_bk_t")[i]).attr("tid"));
                                                        }
                                                        $.ajax({
                                                            type: "post",
                                                            url: '/room/portfolio/ajax_order_master.html',
                                                            data:{'tids':tidsArr},
                                                            async:true,
                                                            dataType: 'json',
                                                            success:function(data){

                                                            }
                                                        });
                                                    }
                                                });
                                                //                          	console.log($(".delmovet"));
                                                //ele4
                                                //这里做删除操作
                                                $(".delmovet").on("click",function(){
                                                    var tid = $(this).parent().attr("tid");
                                                    $(this).parent().remove();
                                                    $.ajax({
                                                        type:"post",
                                                        url:"/room/portfolio/ajax_remove_master.html",
                                                        data:{"masterid":tid},
                                                        async:true,
                                                        success:function(data){
                                                            var liLength = $("#master-choose li").length;
                                                            for(var i=0;i<liLength;i++){
                                                                if($($("#master-choose li")[i]).attr("tid") == tid){
                                                                    $($("#master-choose li")[i]).remove();
                                                                    continue;
                                                                }
                                                            }
                                                            var alength = $("#master-all .lisnres").length;
                                                            for(var j=0;j<alength;j++){
                                                                if($($("#master-all .lisnres")[j]).attr("tid") == tid){
                                                                    $($("#master-all .lisnres")[j]).removeClass("onlock");
                                                                    return false;
                                                                }
                                                            }
                                                        },
                                                        error:function(data){
                                                            console.log(data);
                                                        }
                                                    });
                                                    rebuidemaster();
                                                });
                                            }
                                            if (!debug) {
                                                var top = $("div[data-id='"+mcfg.code+"']").offset().top - 50;
                                                $(window).scrollTop(top);
                                            }
                                            break;
                                        default:
                                    }
                                }
                            });
                        }
                    }
                });
            }

        });

        /*恢复默认*/
        $(".defaultbtn").on("click",function () {
            ele1.innerHTML="";
            ele2.innerHTML="";
            cfg=[];
            adIndex=0;
            svnDrag1 = new DragLayout(ele1, {
                selector: ".dl-section",
                cellW: fragmentTop - 4,
                cellH: 50,
                draggable: true
            });
            svnDrag2 = new DragLayout(ele2, {
                selector: ".dl-section",
                cellW: 305,
                cellH: 330,
                draggable: true
            });
            $.ajax({
                type:"GET",
                url:"/room/portfolio/config.html?tmpid=2",
                dataType:"json",
                cache:false,
                success:function (data) {
                    storage.removeItem("custom-data");
                    storage.removeItem("svnfreewallAll");
                    cfg=data;

                    svnDrag1 = new DragLayout(ele1, {
                        selector: ".dl-section",
                        cellW: fragmentTop - 4,
                        cellH: 50,
                        draggable: true
                    });
                    svnDrag2 = new DragLayout(ele2, {
                        selector: ".dl-section",
                        cellW: 305,
                        cellH: 330,
                        draggable: true
                    });
                    $("#waiblock .block").find(".ico").removeClass("okico");
                    $.each(cfg, function(i, item) {
                        var mid = item.mid;
                        var columns = item.columns;
                        var rows = item.rows || 1;
                        var eid = item.eid || 0;
                        $("[mid="+mid+"]").prev(".ico").addClass("okicon");
                        loadModuleContent(item,mid,columns,rows,eid);
                    });
                }
            });
        });

        window.rebuidefree = function() {
            var target=$("[data-id='free']")[0];
            svnDrag2.getModule("free")._rebuideModule2($(target));
        };
        window.rebuiderich = function(index) {
            var target = $("[data-id='richedit_"+index+"']")[0];
            svnDrag2.getModule("richedit_" + index)._rebuideModule2($(target));
        }
        window.rebuidemaster = function() {
            var target=$("[data-id='masters']")[0];
            svnDrag2.getModule("masters")._rebuideModule2($(target));
        }
        window.rebuidemanual = function() {
            var target=$("[data-id='manualcourse']")[0];
            svnDrag2.getModule("manualcourse")._rebuideModule2($(target));
        }
        window.rebuidebundle = function() {
            var target=$("[data-id='bundle']")[0];
            svnDrag2.getModule("bundle")._rebuideModule2($(target));
        }
    });
    (function($) {
        var imagephp = '<?=$imagephp?>';
        //广告图数据
        var slideData = [];
        var slideDataTmp = [];
        var slideIndex = 0;
        var width = 285;
        var slidemoveing = false;
        var slidePool = {};

        var topSlideBackground = null;
        var topSlidePrev = null;
        var toLeftBtn = null;
        var toRightBtn = null;
        var linkIpt = null;
        var orderIpt = null;
        var current_edit = null;

        function setEditStatus() {
            if (slideDataTmp.length >= 8) {
                $("#ad-uploader div").eq(1).hide();
            } else {
                $("#ad-uploader div").eq(1).show();
            }
            if (slideDataTmp.length > 0) {
                topSlidePrev.show();
            } else {
                topSlidePrev.attr('src', 'http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png').hide();
                linkIpt.val('');
                orderIpt.val('');
            }

            if (slideDataTmp.length > 1) {
                toLeftBtn.show();
                toRightBtn.show();
                topSlideBackground.show();
            } else {
                toLeftBtn.hide();
                toRightBtn.hide();
                topSlideBackground.hide();
            }
        }

        function resetFreeView(type) {
            var baseHeight = 237;
            var len = $("#free-e ul li").size();
            var u = Math.ceil(len / 8.0);
            var h = baseHeight + ((u - 1) * 320);
            $("#free-e").height(h);
            if (type == 1) {
                $("#free-e .exp-more").show();
            } else {

            }
            rebuidefree();
        }
        $("#freewall2").bind('click', function(e) {
            var t = $(e.target);
            if (t.hasClass('dl-edit') && t.hasClass('ad')) {
                var storage=window.localStorage;
                var index = parseInt(t.attr('index'));
                var editContentBox = t.parents('div.dl-content').find('div.dl-main');
                var columns = t.siblings('input:checked').eq(0).next('label').attr('data-size');
                if (slidePool['ad'+index]) {
                    slideData = slidePool['ad'+index];
                    slideIndex = slidePool['ad-key-'+index];
                    slideDataTmp = [];
                    slideDataTmp = slideData.slice(0, 8);
                } else {
                    slideData = [];
                    slideDataTmp = [];
                    editContentBox.find('img.hd').each(function() {
                        var slideitem = $(this);
                        slideData.push({
                            'image': slideitem.attr('src'),
                            'href': slideitem.attr('l'),
                            'zindex': slideitem.attr('z')
                        });
                        slideDataTmp.push({
                            'image': slideitem.attr('src'),
                            'href': slideitem.attr('l'),
                            'zindex': slideitem.attr('z')
                        });
                    }).remove();
                    slideDataTmp.length = slideData.length = Math.min(8, slideData.length);
                    slidePool['ad'+index] = slideData;
                    slidePool['ad-key-'+index] = 0;
                    slideIndex = 0;
                }
                var adDialog = dialog({
                    'id': 'adDialog',
                    'title': '编辑轮播广告',
                    'content': $("#ad-dialog").html(),
                    'fixed':true,
                    'okValue': '确定',
                    'cancelValue': '取消',
                    'cancel': function() {
                        slideIndex = 0;
                    },
                    'onshow': function() {
                        var window = $(this.node);
                        window.find('.ad-edit').attr('id', 'ad-edit');
                        window.find('.ad-uploader').attr('id', 'ad-uploader');
                        uploader.options.formData.target = '#ad-edit';
                        uploader.addButton({
                            'id': '#ad-uploader'
                        });

                        topSlideBackground = window.find(".prevnext");
                        topSlidePrev = window.find(".prev");
                        toLeftBtn = window.find(".ebtn.pl");
                        toRightBtn = window.find(".ebtn.pr");
                        linkIpt = window.find("input.linkinput");
                        orderIpt = window.find("input.order");

                        linkIpt.bind('blur', function() {
                            if (!IsURL($(this).val())) {
                                $(this).val('');
                                if (slideDataTmp[slideIndex]) {
                                    slideDataTmp[slideIndex].href = '';
                                }
                                return false;
                            }

                            if (slideDataTmp.length > 0 && slideIndex > -1 && slideIndex < slideDataTmp.length) {
                                slideDataTmp[slideIndex].href = $(this).val();
                            }
                        });
                        orderIpt.bind('blur', function() {
                            var n = $(this).val();
                            if (n == '' || isNaN(n)) {
                                return false;
                            }
                            if (slideDataTmp.length > 0 && slideIndex > -1 && slideIndex < slideDataTmp.length) {
                                slideDataTmp[slideIndex].zindex = parseInt($(this).val());
                                slideDataTmp.sort(function(a, b) {
                                    if (a.zindex > b.zindex) {
                                        return 1;
                                    }
                                    return -1;
                                });
                            }
                        });
                        window.bind('click', function(e) {
                            var t = $(e.target);
                            if (!slidemoveing && t.hasClass('pr') && t.hasClass('ebtn')) {
                                if (slideDataTmp.length <= 0) {
                                    return false;
                                }
                                //下一页
                                slidemoveing = true;
                                slideIndex = (slideIndex + 1) % slideDataTmp.length;
                                topSlideBackground.attr('src', slideDataTmp[slideIndex].image);
                                topSlidePrev.animate({ 'left': '800px' }, 300, null, function() {
                                    topSlidePrev.attr('src', topSlideBackground.attr('src')).css('left', '0');
                                    if (slideDataTmp[slideIndex].href) {
                                        topSlidePrev.addClass('ebtn');
                                    } else {
                                        topSlidePrev.removeClass('ebtn');
                                    }
                                    linkIpt.val(slideDataTmp[slideIndex].href || '');
                                    orderIpt.val(slideDataTmp[slideIndex].zindex);
                                    slidemoveing = false;
                                });

                                return true;
                            }
                            if (!slidemoveing && t.hasClass('pl') && t.hasClass('ebtn')) {
                                if (slideDataTmp.length <= 0) {
                                    return false;
                                }
                                //上一页
                                slidemoveing = true;
                                slideIndex = (slideIndex + slideDataTmp.length - 1) % slideDataTmp.length;
                                topSlideBackground.attr('src', slideDataTmp[slideIndex].image);
                                topSlidePrev.animate({ 'left': '-800px' }, 300, null, function() {
                                    topSlidePrev.attr('src', topSlideBackground.attr('src')).css('left', '0');
                                    if (slideDataTmp[slideIndex].href) {
                                        topSlidePrev.addClass('ebtn');
                                    } else {
                                        topSlidePrev.removeClass('ebtn');
                                    }
                                    linkIpt.val(slideDataTmp[slideIndex].href || '');
                                    orderIpt.val(slideDataTmp[slideIndex].zindex);
                                    slidemoveing = false;
                                });
                                return true;
                            }
                            if (t.hasClass('prev') && t.hasClass('ebtn')) {
                                //新标签页打开链接
                                if (slideIndex >= slideDataTmp.length || slideIndex < 0) {
                                    return false;
                                }
                                var a = $("<a href='" + slideDataTmp[slideIndex].href + "' target='_blank'>blank</a>").get(0);
                                var e = document.createEvent('MouseEvents');
                                e.initEvent('click', true, true);
                                a.dispatchEvent(e);
                                return true;
                            }
                        });
                        window.find("span.del").bind('click', function() {
                            if (slideDataTmp.length <= 0 || slidemoveing) {
                                return false;
                            }

                            slideDataTmp.splice(slideIndex, 1);
                            setEditStatus();
                            if (slideDataTmp.length <= 0) {
                                slideIndex = -1;
                                return true;
                            }
                            slideIndex = Math.min(slideIndex, slideDataTmp.length - 1);
                            linkIpt.val(slideDataTmp[slideIndex].href || '');
                            orderIpt.val(slideDataTmp[slideIndex].zindex);
                            topSlidePrev.attr('src', slideDataTmp[slideIndex].image);
                        });
                        topSlidePrev.bind('create', function(event, data) {
                            if (slideDataTmp.length >= 8) {
                                return false;
                            }
                            slideDataTmp.push({
                                'image': data.showurl,
                                'href': '',
                                'zindex': slideDataTmp.length > 0 ? (slideDataTmp[slideIndex].zindex + 1) : 0
                            });
                            linkIpt.val('');
                            setEditStatus();
                            if (slideIndex < 0) {
                                slideIndex = 0;
                            }
                            if (slideDataTmp.length > 0) {
                                slideDataTmp.sort(function(a, b) {
                                    if (a.zindex > b.zindex) {
                                        return 1;
                                    }
                                    return -1;
                                });
                            }

                            if (slidemoveing) {
                                return true;
                            }
                            topSlidePrev.attr('src', data.showurl);
                            orderIpt.val(data.zindex);
                        });

                        if (slideData.length > 0 && slideData[slideIndex]) {
                            topSlidePrev.attr('src', slideData[slideIndex].image).show();
                            linkIpt.val(slideData[slideIndex].href || '');
                            orderIpt.val(slideData[slideIndex].zindex || '0');
                        }
                        setEditStatus();

                        if (slideData.length > 0 && slideData[slideIndex]) {
                            topSlidePrev.attr('src', slideData[slideIndex].image).show();
                        }


                        if (columns == 2) {
                            width = 590;
                            window.find("span.ad-des").html('最佳尺寸320*590');
                            $("#ad-edit").css('margin', '10px 60px');
                        } else if (columns == 3) {
                            width = 895;
                            window.find("span.ad-des").html('最佳尺寸320*895');
                            $("#ad-edit").css('margin', '10px 60px');
                        } else {
                            width = 285;
                            window.find("span.ad-des").html('最佳尺寸320*285');
                            $("#ad-edit").css('margin', '10px auto');
                        }
                        $("#ad-edit").css('width',width+'px');
                        topSlidePrev.css('width',width+'px').css('height', '320px');
                        topSlideBackground.css('width',width+'px').css('height', '320px');
                    },
                    'ok': function() {
                        slideData.length = 0;
                        slideData = slideDataTmp.slice(0, 8);
                        slidePool['ad-key-'+index] = slideIndex;
                        slidePool['ad'+index] = slideData;
                        //保存数据到本地
                        var cu = JSON.parse(storage.getItem('custom-data'));
                        if (!cu) {
                            cu = {};
                        }
                        var options = [];
                        for (var i = 0; i < slideData.length; i++) {
                            if (slideData[i]) {
                                options.push({
                                    'image':slideData[i].image,
                                    'href':slideData[i].href,
                                    'zindex':slideData[i].zindex
                                });
                            }
                        }
                        cu['ad_'+index] = {
                            'options': options,
                            'del':options.length == 0 ? 1 : 0
                        };

                        var jcu = JSON.stringify(cu);
                        storage.setItem('custom-data', jcu);

                        if (slideData.length > 0) {
                            editContentBox.find("img.ad").attr('src', topSlidePrev.attr('src'));
                            return true;
                        }

                        var viewholder = editContentBox.find("img.ad");
                        viewholder.attr('src', viewholder.attr('viewholder'));
                        viewholder = null;
                    }
                });

                adDialog.showModal();
                return false;
            }
            if (t.hasClass('dl-edit') && t.hasClass('richedit')) {
                var index = parseInt(t.attr('index'));

                var editContentBox = t.parents('div.dl-content').find('div.dl-main div.richtext');
                var boxHeight = t.parents('div.dl-content').height();
                if (t.html() == "编辑") {
                    if (current_edit != null) {
                        current_edit.trigger('click');
                    }
                    current_edit = t;
                    editContentBox.css('margin', '0');
                    t.html("保存");
                    //富文本编辑事件
                    var id = 'rich-editor-'+index;
                    var richtext = editContentBox.html();
                    editContentBox.html('<div><scrip'+'t id="'+id+'" style="width:100%;" type="text/plain"></'+'script></div>');

                    var config = {
                        textarea:id, //提交表单时，服务器获取编辑器提交内容的所用的参数
                        autoHeightEnabled:false,//ture 编辑器区域根据内容自动长高。
                        toolbars: [['source','formula', 'imgeditor', 'emotion', 'undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'superscript', 'subscript', '|', 'forecolor', 'backcolor', '|', 'removeformat', '|', 'insertorderedlist', 'insertunorderedlist', '|', 'fontsize', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'image', 'link', 'unlink']]};
                    var ue = UE.getEditor(id, config);
                    /*ue.focus();
                     ue.execCommand('fontsize', '16px');*/
                    var resetHeight = boxHeight - editContentBox.find('.edui-toolbar').height() - 16;
                    editContentBox.find('.edui-editor-iframeholder').height(resetHeight);
                    ue.addListener('ready',function() {
                        ue.setContent(richtext, false);
                    });
                    return;
                }
                if (t.html() == "保存") {
                    current_edit = null;
                    t.html("编辑");
                    editContentBox.css('margin', '20px');
                    var richContent = UE.getEditor('rich-editor-'+index).getContent();
                    UE.delEditor('rich-editor-'+index);
                    editContentBox.html(richContent);
                    $(".edui-modal").remove();
                    rebuiderich(index);
                    var storage=window.localStorage;
                    var cu = JSON.parse(storage.getItem('custom-data'));
                    if (!cu) {
                        cu = {};
                    }
                    cu['richedit_' + index] = {
                        'richtext': richContent
                    };
                    var jcu = JSON.stringify(cu);
                    storage.setItem('custom-data', jcu);
                }
                return false;
            }
            if (t.hasClass('del-free-item')) {
                var cwid = t.attr('d');
                $.ajax({
                    'url': '/room/portfolio/ajax_remove_free.html',
                    'type': 'post',
                    'dataType': 'json',
                    'cache':false,
                    'data' : {'cwid': cwid },
                    'success' : function(d) {
                        if (d.errno == 0) {
                            t.parent('li').remove();
                            var freesize = $("#freesize").val();
                            var len = $("#free-e ul li").not('.add').size();
                            var u = Math.max(Math.ceil(len / freesize), 1);
                            var h = 237 + ((u - 1) * 320);

                            $("#free-e").height(h);

                            if (len % freesize == 0 && len > 0) {
                                $("#free-e ul li.add").hide();
                                $("#free-e div.exp-more").show();
                            } else {
                                $("#free-e ul li.add").show();
                                $("#free-e div.exp-more").hide();
                            }
                            rebuidefree();
                            return true;
                        }
                    }
                });
                return false;
            }
            if (t.hasClass('add-free-courseware')) {
                if (!t.parents('div.layoutwrap').hasClass('dl-normal')) {
                    return;
                }
                $("#free-courseware-dialog").attr('src','/aroomv2/module/freecourse.html');
                var addfree = dialog({
                    'id': 'add-free-courseware',
                    'title': '设置免费试听',
                    'fixed':true,
                    'content': $("#free-courseware-dialog")[0]
                });
                addfree.showModal();
                return false;
            }
            if (t.hasClass('exp-more')) {
                if (!t.parents('div.layoutwrap').hasClass('dl-normal')) {
                    return;
                }
                $("#free-courseware-dialog").attr('src','/aroomv2/module/freecourse.html');
                var addfree = dialog({
                    'id': 'add-free-courseware',
                    'title': '设置免费试听',
                    'content': $("#free-courseware-dialog")[0]
                });
                addfree.showModal();
                return false;
            }

            if (t.hasClass('master-add-btn')) {
                var masterDialog = dialog({
                    'id': 'masterDialog',
                    'title': '选择名师',
                    'content': $("#masters").html(),
                    'fixed':true,
                    'okValue': '确定',
                    'cancelValue': '取消',
                    'cancel': function() {

                    },
                    'onshow': function() {
                        var window = $(this.node);
                        window.find("#master-all").unbind().bind('click', function(e) {
                            var node = e.target.nodeName.toLowerCase();
                            var t = null;
                            if (node == 'span') {
                                t = $(e.target).parent('a.lisnres');
                            } else if (node == 'a') {
                                t = $(e.target);
                            }
                            if (!t) {
                                return false;
                            }
                            if (t.hasClass('onlock')) {
                                t.html('<span class="selectico">'+t.attr('val')+'</span>');
                                t.removeClass('onlock');
                                window.find("#master-choose li[tid='"+t.attr('tid')+"']").remove();
                            } else {
                                t.addClass('onlock');
                                t.html(t.attr('val')+'<span class="selectico"></span>');
                                var title = t.attr('urealname');
                                if (title) {
                                    title += '('+t.attr('uname')+')';
                                } else {
                                    title = t.attr('uname');
                                }
                                window.find("#master-choose").append('<li tid="'+t.attr('tid')+'"><a class="terles_lnode" title="'+title+'" href="javascript:;">'+t.attr('val')+'</a><a class="terles_labe" title="删除标签" href="javascript:;"><img src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/tstebico.png"></a></li>');
                            }
                            return false;
                        });

                        window.find("#master-choose").unbind().bind('click', function(e) {
                            var node = e.target.nodeName.toLowerCase();
                            if (node != 'img') {
                                return false;
                            }
                            var t = $(e.target);
                            t = t.parents("li");
                            var teacher = window.find("#master-all a[tid='"+t.attr('tid')+"']");
                            teacher.removeClass('onlock');
                            teacher.html('<span class="selectico">'+teacher.attr('val')+'</span>');
                            t.remove();
                        });

                        window.find("#souhuang-masters").unbind().bind('click', function() {
                            var ipt = window.find('#teachername');
                            ipt.val($.trim(ipt.val()));
                            if(ipt.val() == '') {
                                window.find("#master-all a.lisnres").show();
                                return;
                            }
                            window.find("#master-all a.lisnres").each(function() {
                                var that = $(this);
                                if (that.attr('urealname').indexOf(ipt.val()) >= 0 || that.attr('uname').indexOf(ipt.val()) >= 0) {
                                    that.show();
                                } else {
                                    that.hide();
                                }
                            });
                        });
                    },
                    'ok': function() {
                        var window = $(this.node);
                        if ($.trim($('#teachername').val()) == '') {
                            window.find('#master-all a.lisnres').show();
                        }

                        $("#masters").html(window.find('.ui-dialog-content').html());
                        var addBtn = $("#master-edit div.team_bk");
                        addBtn.siblings('.item').remove();
//						$("#team_botm").empty();
                        var masterids = [];

                        window.find("#master-all a.lisnres.onlock").each(function() {
                            var that = $(this);
                            masterids.push(that.attr('tid'));

                            addBtn.before('<div class="team_bk item team_bk_t" tid="'+that.attr('tid')+'" style="width:245px;height: 226px;border:1px solid #ccc;">'+
                                '<a href="javascript:;">'+
                                '<div class="team_hbj">'+
                                '<img src="'+that.attr('uface')+'" />'+
                                '<h3 class="team_h3">'+(that.attr('urealname') ? that.attr('urealname') : that.attr('uname'))+'</h3>'+
                                '<p class="team_p1">'+that.attr('uprofessionaltitle')+'</p>'+
                                '</div>'+
                                '<p class="team_p2">'+that.attr('uprofile')+'</p>'+
                                '</a>'+
                                '<a href="javascript:void(0)" class="tremove delmovet" ></a>'+
                                '</div>');
                        });
                        rebuidemaster();

                        $.ajax({
                            'url': '/room/portfolio/ajax_set_masters.html',
                            'type': 'post',
                            'data': { 'masterids' : masterids },
                            'dataType': 'json',
                            'success': function(ret) {

                            }
                        });
                    },
                    'onclose':function(){
                        $('.team_botm').dad({
                            draggable: 'img',
                            callback: function(){
                                $("#add_team_bk").show();
                                var tidsArr = [];
                                for(var i=0;i<$(".team_bk_t").length-1;i++){
                                    tidsArr.push($($(".team_bk_t")[i]).attr("tid"));
                                }
                                $.ajax({
                                    type: "post",
                                    url: '/room/portfolio/ajax_order_master.html',
                                    data:{'tids':tidsArr},
                                    dataType: 'json',
                                    async:true,
                                    success:function(data){

                                    }
                                });
                            }
                        });
                        //这里做删除操作
                        $(".delmovet").on("click",function(){
                            var tid = $(this).parent().attr("tid");
                            $(this).parent().remove();
                            $.ajax({
                                type:"post",
                                url:"/room/portfolio/ajax_remove_master.html",
                                data:{"masterid":tid},
                                async:true,
                                success:function(data){
                                    var liLength = $("#master-choose li").length;
                                    for(var i=0;i<liLength;i++){
                                        if($($("#master-choose li")[i]).attr("tid") == tid){
                                            $($("#master-choose li")[i]).remove();
                                            continue;
                                        }
                                    }
                                    var alength = $("#master-all .lisnres").length;
                                    for(var j=0;j<alength;j++){
                                        if($($("#master-all .lisnres")[j]).attr("tid") == tid){
                                            $($("#master-all .lisnres")[j]).removeClass("onlock");
                                            return false;
                                        }
                                    }
                                },
                                error:function(data){
                                    console.log(data);
                                }
                            });
                            rebuidemaster();
                        });
                    }
                });

                masterDialog.showModal();
                return false;
            }
            if (t.hasClass('choose-courses')) {
                //选择课程
                var cpid = t.attr('pid');
                var courseDialog = dialog({
                    id: 'choose-courses',
                    title: '自选课程',
                    content: $('#choose-courses-panel'),
                    fixed: true,
                    width: 750,
                    padding:0,
                    okValue: '确定',
                    cancelValue: '取消',
                    onshow: function() {
                        var content = $('#choose-courses-panel');
                        if (!content.hasClass('loaded')) {
                            //加载自选课程面板
                            $.ajax({
                                url: '/room/portfolio/get_manual_panel.html',
                                type: 'get',
                                dataType: 'html',
                                success: function(html) {
                                    content.html(html);
                                    content.addClass('loaded');
                                    //绑定自选课程面板事件
                                    content.bind('click', function(e) {
                                        var node = e.target.nodeName.toLowerCase();
                                        var t = $(e.target);
                                        if (node == 'span') {
                                            //来源标签事件
                                            if (t.hasClass('cur')) {
                                                return false;
                                            }
                                            content.find('span').removeClass('cur');
                                            t.addClass('cur');
                                            content.find(".packages li").removeClass('cur').hide();
                                            content.find(".packages li.a").attr('crid', '0');
                                            var packages = content.find(".packages li.item[crid='"+t.attr('crid')+"']");
                                            if (packages.size() > 0) {
                                                content.find('.package').show();
                                            } else {
                                                content.find('.package').hide();
                                                content.find('.sorts').hide();
                                                content.find(".course-items li").hide();
                                                return;
                                            }
                                            packages.show();
                                            if (packages.size() > 1) {
                                                content.find(".packages li.a").attr('crid', t.attr('crid')).show();
                                            }
                                            $(packages.get(0)).trigger('click');
                                        }
                                        if (t.hasClass('package-btn')) {
                                            //服务包点击事件
                                            if (t.hasClass('cur')) {
                                                return;
                                            }
                                            content.find(".packages li").removeClass('cur');
                                            t.addClass('cur');
                                            if (t.attr('pid') == '0') {
                                                //全部服务包
                                                content.find('.sorts li.a').attr('pid', '0');
                                                content.find('.sorts').hide();
                                                content.find('ul.course-items li').hide();
                                                content.find("ul.course-items li[crid='"+t.attr('crid')+"']").show();
                                                return;
                                            }
                                            content.find(".sorts li").hide();
                                            content.find(".sorts li.a").attr('pid', '0');
                                            var sorts = content.find(".sorts li[pid='"+t.attr('pid')+"']");
                                            sorts.removeClass('cur').show();
                                            content.find('.sorts').show();
                                            if (sorts.size() > 1) {
                                                content.find(".sorts li.a").attr('pid', t.attr('pid')).show();
                                            }
                                            $(sorts.get(0)).trigger('click');
                                        }
                                        if (t.hasClass('sort-btn')) {
                                            //分类点击事件
                                            if (t.hasClass('cur')) {
                                                return;
                                            }
                                            content.find('.sorts li').removeClass('cur');
                                            t.addClass('cur');
                                            content.find('ul.course-items li').hide();
                                            if (t.attr('sid') == '0') {
                                                //全部分类
                                                content.find("ul.course-items li[pid='"+t.attr('pid')+"']").show();
                                                return;
                                            }
                                            content.find("ul.course-items li[sid='"+t.attr('sid')+"']").show();
                                        }

                                        if (node == 'img' || node == 'div') {
                                            t = t.parent('li');
                                            if (t.attr('ati') == '1') {
                                                t.attr('ati', '0');
                                                t.find('img.manual-icon').hide();
                                            } else {
                                                t.attr('ati', '1');
                                                t.find('img.manual-icon').show();
                                                t.attr('ts', new Date().getTime());
                                            }
                                        }
                                    });
                                    if (cpid == 0) {
                                        var firstRoom = $(content.find('dt span').get(0));
                                        firstRoom.trigger('click');
                                        content.find('.package-btn.a').trigger('click');
                                        return;
                                    }
                                    var ct = $(".package-btn[pid='"+cpid+"']");
                                    content.find("dt span[crid='"+ct.attr('crid')+"']").trigger('click');
                                    ct.trigger('click');
                                }
                            });
                            return false;
                        }
                        if (cpid == 0) {
                            var firstRoom = $(content.find('dt span').get(0));
                            firstRoom.trigger('click');
                            content.find('.package-btn.a').trigger('click');
                            return;
                        }
                        var ct = $(".package-btn[pid='"+cpid+"']");
                        content.find("dt span[crid='"+ct.attr('crid')+"']").trigger('click');
                        ct.trigger('click');
                    },
                    ok: function() {
                        var window = $(this.node);
                        var adds_o = [];
                        var dels = [];
                        var adds = [];
                        $("#choose-courses-panel .course-items").find('li').each(function() {
                            var that = $(this);
                            if (that.attr('ati') != that.attr('sta')) {
                                that.attr('sta', that.attr('ati'));
                                if (that.attr('ati') == '0') {
                                    dels.push(that.attr('itemid'));
                                } else {
                                    adds_o.push({id: that.attr('itemid'), index: parseInt(that.attr('ts'))});
                                }
                            }
                        });
                        adds_o = adds_o.sort(function(a, b) {
                            if (a.index > b.index) {
                                return 1;
                            }
                            return 0;
                        });
                        var i = 0;
                        var len = adds_o.length;
                        for(i = 0; i < len; i++) {
                            adds.push(adds_o[i].id);
                        }
                        if (adds.length > 0 || dels.length > 0) {
                            //更新操作
                            $.ajax({
                                'url': '/room/portfolio/ajax_update_manualcourse.html',
                                'type': 'post',
                                'data': {'adds': adds, 'dels': dels },
                                'dataType': 'json',
                                'success': function(ret) {
                                    if (ret && ret.errno == 0) {
                                        $("a.kuasse[mid='23']").trigger('click').trigger('click');
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {
                        $("#choose-courses-panel .course-items").find('li').each(function() {
                            var that = $(this);
                            that.attr('ati', that.attr('sta'));
                            if (that.attr('ati') == '0') {
                                that.find('img.manual-icon').hide();
                            } else {
                                that.find('img.manual-icon').show();
                            }
                        });
                    }
                });
                courseDialog.showModal();
                return false;
            }
            if (t.hasClass('del-manualcourse')) {
                //删除自选课程
                var li = t.parent('li');
                var itemid = li.attr('itemid');
                var ul = li.parent('ul');
                li.remove();
                if (ul.find('li').size() < 2) {
                    ul.prev('div.coursetitlenew').remove();
                    ul.remove();
                }
                rebuidemanual();
                $.ajax({
                    'url': '/room/portfolio/ajax_del_manualcourse.html',
                    'type': 'post',
                    'data': {'itemid': itemid },
                    'dataType': 'json',
                    'success': function(ret) {
                        if (ret && ret.errno == 0) {
                            //删除成功后同步自选课程面板UI
                            var li = $("#choose-courses-panel  .course-items li[itemid='"+itemid+"']");
                            if (li.size() > 0) {
                                li.attr('sta', '0');
                                li.attr('ati', '0');
                                li.find('img.manual-icon').hide();
                            }
                        }
                    }
                });
                return false;
            }
            if (t.hasClass('s-coursemenu')) {
                //定位课程导航
                $("a.s-coursemenu.onhover").removeClass('onhover');
                t.addClass('onhover');
                var gid = parseInt(t.attr('gid'));
                if (gid == 0) {
                    $("#course-nav-set").hide();
                } else {
                    $("#course-nav-set li").hide();
                    $("#course-nav-set li[pid='"+gid+"']").show();
                    $("#course-nav-set").show();
                }
                $.ajax({
                    'url': '/room/portfolio/ajax_located_course.html',
                    'type': 'post',
                    'data': {'pid': gid },
                    'dataType': 'json',
                    'success': function(ret) {

                    }
                });
                return false;
            }

            if (t.hasClass('del-bundle')) {
                //删除课程包
                var li = t.parent('li');
                var bid = li.attr('bid');
                var ul = li.parent('ul');
                li.remove();
                rebuidebundle();
                $.ajax({
                    'url': '/room/portfolio/ajax_del_bundle.html',
                    'type': 'post',
                    'data': {'bid': bid },
                    'dataType': 'json',
                    'success': function(ret) {
                        if (ret && ret.errno == 0) {
                            //删除成功后同步自选课程面板UI
                            var li = $("#choose-bundles-panel  .bundles-items li[bid='"+bid+"']");
                            if (li.size() > 0) {
                                li.attr('sta', '0');
                                li.attr('ati', '0');
                                li.find('img.bundle-icon').hide();
                            }
                        }
                    }
                });
                return false;
            }
            if (t.hasClass('choose-bundle')) {
                //选择课程包
                var bundleDialog = dialog({
                    id: 'choose-bundles',
                    title: '课程包',
                    content: $('#choose-bundles-panel'),
                    fixed: true,
                    width: 750,
                    padding:0,
                    okValue: '确定',
                    cancelValue: '取消',
                    onshow: function() {
                        var content = $('#choose-bundles-panel');
                        if (!content.hasClass('loaded')) {
                            //加载自选课程面板
                            $.ajax({
                                url: '/room/portfolio/get_bundles_panel.html',
                                type: 'get',
                                dataType: 'html',
                                success: function(html) {
                                    content.html(html);
                                    content.addClass('loaded');
                                    //绑定自选课程面板事件
                                    content.bind('click', function(e) {
                                        var node = e.target.nodeName.toLowerCase();
                                        var t = $(e.target);
                                        if (node == 'img') {
                                            var li = $(t.parent('li'));
                                            var icon = li.find('img.bundle-icon');
                                            var ati = li.attr('ati') == '1' ? '0' : '1';
                                            li.attr('ati', ati);
                                            if (ati == '1') {
                                                icon.show();
                                            } else {
                                                icon.hide();
                                            }
                                        }
                                        if (t.hasClass('package-btn')) {
                                            var pid = t.attr('pid');
                                            $(t.siblings('.cur')).removeClass('cur');
                                            t.addClass('cur');
                                            content.find('.bundles-items li').hide();
                                            content.find(".bundles-items li[pid='"+pid+"']").show();
                                        }
                                    });
                                }
                            });
                            return false;
                        }
                    },
                    ok: function() {
                        var window = $(this.node);
                        var adds_o = [];
                        var dels = [];
                        var adds = [];
                        $("#choose-bundles-panel .bundles-items").find('li').each(function() {
                            var that = $(this);
                            if (that.attr('ati') != that.attr('sta')) {
                                that.attr('sta', that.attr('ati'));
                                if (that.attr('ati') == '0') {
                                    dels.push(that.attr('bid'));
                                } else {
                                    adds_o.push({id: that.attr('bid'), index: parseInt(that.attr('ts'))});
                                }
                            }
                        });
                        adds_o = adds_o.sort(function(a, b) {
                            if (a.index > b.index) {
                                return 1;
                            }
                            return 0;
                        });
                        var i = 0;
                        var len = adds_o.length;
                        for(i = 0; i < len; i++) {
                            adds.push(adds_o[i].id);
                        }
                        if (adds.length > 0 || dels.length > 0) {
                            //更新操作
                            $.ajax({
                                'url': '/room/portfolio/ajax_update_bundles.html',
                                'type': 'post',
                                'data': {'adds': adds, 'dels': dels },
                                'dataType': 'json',
                                'success': function(ret) {
                                    if (ret && ret.errno == 0) {
                                        $("a.kuasse[mid='25']").trigger('click').trigger('click');
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {
                        $("#choose-bundles-panel .bundles-items").find('li').each(function() {
                            var that = $(this);
                            that.attr('ati', that.attr('sta'));
                            if (that.attr('ati') == '0') {
                                that.find('img.bundle-icon').hide();
                            } else {
                                that.find('img.bundle-icon').show();
                            }
                        });
                    }
                });
                bundleDialog.showModal();
                return false;
            }
        });
    })(jQuery);
</script>
<?php $this->display('common/footer')?>
