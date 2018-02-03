<?php $this->display('shop/plate/headernew');?>
<style>
/*跨webview需要手动指定位置*/
.mui-plus header.mui-bar {
    display: none!important;
}
.mbaobtn.plate-sign-disabled,.mbaobtn.plate-sign-unallow,.baobtn.plate-sign-disabled,.baobtn.plate-sign-unallow{background-color:#e7e7e7;color:#999}
.mui-plus .mui-bar-nav~.mui-content {
    padding: 0!important;
}
.mui-table-view:after ,.mui-table-view:before {
    height:0px;
}
.mbaobtn{
    background: #FF6600;
    float: right;
    color: #fff;
    font-size: 14px;
    height: 42px;
    line-break: 42px;
    width: 117px;
    text-align: center;
}
.erhuise {
    background: url(http://static.ebanhui.com/ebh/tpl/2016/images/erhuise.png) no-repeat left center;
    font-size: 16px;
    color: #999;
    height: 35px;
    line-height: 35px;
    display: inline-block;
	padding-left:28px;
    width: 70px;
    border: none;
	margin-left:10px;
}
.hsiers {background:#fff;}
.freestatus {
	font-size:14px;
	white-space: normal;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
	word-wrap:break-word
}

.mui-media-body {font-size:17px;}
.huiser ,.other-1 {font-size:17px;}
</style>
<ol class="breadcrumb open-course-breadcrumb">
    <li><a href="/">首页</a></li>
    <li><?=htmlspecialchars(!empty($inner_data['pay_item']['iname'])?$inner_data['pay_item']['iname']:'', ENT_NOQUOTES)?></li>
</ol>
<div>
    <?php
    //课程封面调用原图
    if (strpos($inner_data['pay_item']['showimg'], 'tpl/default/images/folderimgs/course_cover_default_') !== false) {
        $cover = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
        //print_r($inner_data);exit;
    } else {
        $cover = str_replace('_th', '', $inner_data['pay_item']['showimg']);
        $cover = preg_replace('/_\d+_\d+/', '', $cover);
        //print_r($inner_data);exit;
    }
    ?>
    <div class="mui-table-view" >
        <div class="mui-input-row align_box">
            <img src="<?=htmlspecialchars($cover, ENT_COMPAT)?>" >
        </div>
        <div style="padding: 10px 0 10px 20px;">
            <?php $viewnumlib = Ebh::app()->lib('Viewnum');
            $viewnum = $viewnumlib->getViewnum('folder',empty( $inner_data['pay_item']['folderid'])?0: $inner_data['pay_item']['folderid']);
                if (empty($viewnum)) {
                    $viewnum = $inner_data['pay_item']['viewnum'];
                }
            ?>
            <span class="ketebn"><?=intval($viewnum)?>人学习</span>
            <span class="kheter"><?=(empty($inner_data['pay_item']['coursewarenum'])?0:$inner_data['pay_item']['coursewarenum'])?>课时</span>
			<span class="erhuise">分享</span>
        </div>
		<?php
                $roominfoSetting = Ebh::app()->room->getSystemSetting();
                $appsetting = Ebh::app()->getConfig()->load('othersetting');
                $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
                $szlz = $appsetting['szlz'] == $roominfoSetting['crid'];
                if (!empty($inner_data['pay_item']['allow'])) {
                    $label = $szlz ? '立即观看' : '进入学习';
                } else if ($inner_data['pay_item']['url'] === 0 || (isset($inner_data['pay_item']['iprice']) && $inner_data['pay_item']['iprice'] == 0)) {
                    $label = $szlz ? '点击观看' : '免费开通';
                } else {
                    $label = '购买课程';
                }
             ?>
        <div class="botbst">
			<?php if(!empty($inner_data['pay_item']['islimit']) && $inner_data['pay_item']['limitnum']>0){
			//限制了报名人数的
				$color = $inner_data['pay_item']['opencount'] == $inner_data['pay_item']['limitnum']?'#66cc00':'#FF0000';
			?>
			<p class="huiser"><span class="redsrt"><span class="font16">￥</span><?php echo $inner_data['pay_item']['iprice'];?></span></p>
			<p class="huiser">已报名:<span style="color:<?=$color?>;"><?=$inner_data['pay_item']['opencount']?></span>/<?=$inner_data['pay_item']['limitnum']?></p>
			<?php } else {?>
            <p class="huiser">平台使用费
            <?php if ($inner_data['pay_item']['url'] === 0) { ?>
                <span class="redsrt"><span class="font16">免费</span>
            <?php } else {?>
                <span class="redsrt"><span class="font16">￥</span><?=sprintf("%01.2f", isset($inner_data['pay_item']['iprice']) ? $inner_data['pay_item']['iprice'] : '')?></span>
            <?php } ?>
            </p>
			<?php }?>
            <a id="plate-btn" style="color:#fff;" class="<?php if ($inner_data['pay_item']['url'] === 0 || $inner_data['pay_item']['iprice'] == 0) {echo 'm';}?>baobtn<?=$inner_data['pay_item']['sign_status']?>" href="javascript:;" class="kehtfs<?=$inner_data['pay_item']['sign_status']?><?php if(!empty($inner_data['surveyid'])) { echo ' survey'; } ?>" folderid ="<?=(isset($inner_data['pay_item']['folderid'])?$inner_data['pay_item']['folderid']:0)?>" itemid="<?=(isset($inner_data['pay_item']['itemid'])?$inner_data['pay_item']['itemid']:0)?>"><?=$label?></a>
        </div>
        <p class="repic" style="margin-top:10px;">
            <a href="javascript:;" class="emaillock cur">介绍</a>
            <a href="javascript:;" class="cellock">目录</a>
        </p>
        <div >
            <div class="showno">
                <div class="mui-input-row" style="padding: 15px;">
                    <div class="courselists">
                     <div class="lvjies">
                                <?=isset($inner_data['pay_item']['detail']) ? $inner_data['pay_item']['detail'] : '' ?>
                    </div>
                        <?php if(!empty($inner_data['pay_item']['introduce'])){
                            $inner_data['pay_item']['introduce'] = (array)unserialize($inner_data['pay_item']['introduce']);
                            ?> 
                            <?php foreach($inner_data['pay_item']['introduce'] as $k=>$introduce){?>
                                <div class="kecjs mt25">
                                    <h2><?=$introduce['title']?></h2>
                                    <p><?=$introduce['content']?></p>
                                </div>
                            <?php }
                        }?>
                    </div>
                </div>
                <div class="hsiers">
                    <div class="titles"><?php echo empty($isSzlz) ? '最新报名': '最近观看';?></div>
                    <div class="panel-body">
                        <ul class="mui-table-view">
                            <?php if (!empty($inner_data['latest_sign'])) {
                                foreach ($inner_data['latest_sign'] as $index => $item) { ?>
                            <li>
                                <a href="javascript:;" class="nsewes" title="<?=half_hide_name(getusername($item))?>">
                                    <img class="mui-media-object" src="<?=getavater($item,'50_50')?>">
                                    <div class="rankname"><?=half_hide_name(getusername($item))?></div>
                                </a>
                            </li>
                             <?php } }?>
                        </ul>
                    </div>
                </div>
                <div class="hsiers">
                <div class="titles">最新动态</div>
                    <ul class="mui-table-view">
                            <?php if (!empty($inner_data['dynamic'])) {
                                foreach ($inner_data['dynamic'] as $index => $item) { ?>
                            <li class="mui-table-view-cell">
                                <a class="font14" href="javascript:;"><?=half_hide_name(getusername($item))?> <span style="color:#999;">完成了</span> <span class="sicolr"><?=htmlspecialchars(shortstr($item['title'], 18), ENT_NOQUOTES)?></span></a>
                            </li>
                             <?php } }?>
                    </ul>
                </div>
            </div>
            <div class="showno" style="display: none;" >
                <ul class="mui-table-view" id="content-panel"> 
                    
                </ul>
               
            </div>
        </div>
    </div>
</div>

<div class="mui-backdrop mui-active" id="showqcode" style="display: none;">
    <img style="position: absolute;right: 20%;left: 26%;bottom: 20%;height: 180px;width: 180px;top: 37%;z-index:2;" id="qcode" src="">
    <?php if ($roominfo['crid']==13603) {//就比昂有背景图?>
	<img style="position: absolute;right: 0;left: 0;bottom:0;top:0;height: 100%;width: 100%;" id="betu" src="http://static.ebanhui.com/ebh/tpl/2016/images/betu01.jpg" />
    <?php }?>
</div>

<script src="../static/mui/js/mui.zoom.js"></script>
<script src="../static/mui/js/mui.previewimage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/raphael-2.1.0-min.js'></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/qrcodesvg.js'></script>
<script>
        $(".erhuise").on("tap",function(){
            if(<?php $user = Ebh::app()->user->getloginuser();echo empty($user)?1:0;?>){
                location.href = "http://wap.ebh.net/login.html?redirecturl="+encodeURIComponent(location.href);
                return false;
            }else{
                var usersharekey = '';
                var schoolsharekey = '';
                if(usersharekey=="" || usersharekey=="0" || schoolsharekey=="" || schoolsharekey=="0"){
                    sharekey = getsharekey();
                    usersharekey = sharekey.coursesharekey;
                    schoolsharekey = sharekey.schoolsharekey;
                }
                //console.log(usersharekey);
                if(usersharekey=="0"){
                    alert('获取分享码失败')
                    return false;
                }else{
                    sharecourse(usersharekey,schoolsharekey);
                } 
            }
        });
        var $share_course = $("#share_course")[0];
        $("#qcode,#showqcode,#betu").on("tap",function(){
            $("#showqcode").css('display','none');
			$("#betu").css('display','none');
        });
        function sharecourse(usersharekey,schoolsharekey){
            //生产链接url
            var baseurl = 'http://up.ebh.net/qrcode.html';
            //课程分享
            var coursename = '<?php echo isset($inner_data['pay_item']['iname']) ? $inner_data['pay_item']['iname'] : ''; ?>';
            var shareitemid = <?=(isset($inner_data['pay_item']['itemid'])?$inner_data['pay_item']['itemid']:0)?>;
            var sharekey = usersharekey;
            var url = window.location.href;
            if (url.indexOf('?') < 0) {
                var wapcourseurl = window.location.href+'?sharekey='+sharekey;
            } else {
                var wapcourseurl = url.substr(0,url.indexOf('?'))+'?sharekey='+sharekey;
            }
            
            //console.log(wapcourseurl)
            var content_course = escape(encodeURIComponent(wapcourseurl));
            var showcoursesrc = baseurl+'?content='+content_course+'&show=1&size=6';
            //打印输出
            
            $('.showqr_course').attr('src',showcoursesrc);
            
            var download256_course = baseurl+ '?content='+content_course+'&down=1'+ '&size=8';
            var download512_course = baseurl+ '?content='+content_course+'&down=1'+ '&size=16';
            var download1024_course = baseurl+ '?content='+content_course+'&down=1'+ '&size=32';
            $($('.qrload_course')[0]).attr('href',download256_course);
            $($('.qrload_course')[1]).attr('href',download512_course);
            $($('.qrload_course')[2]).attr('href',download1024_course);
            
            var sharecourse = "<div class='sharecourse'></div>";
            $('.sharecoursebox').append(sharecourse);
            $('.sharecourse').share({
                url: wapcourseurl,
                source: coursename,
                title: coursename,
                description: coursename,
                summary: coursename,
                image: showcoursesrc,
                sites: ['wechat','weibo']
            });

            $("#qcode").attr('src',showcoursesrc);
            $("#showqcode").css('display','block');
			$("#betu").css('display','block');
            $("#topPopover").css('display','none');
            $("#topPopover").removeClass('mui-active');
            $(".mui-backdrop").eq(1).remove();
        }
        
        function getsharekey(){
            var itemid = <?=(isset($inner_data['pay_item']['itemid'])?$inner_data['pay_item']['itemid']:0)?>;
            var sharekey = {coursesharekey:'0',schoolsharekey:'0'};
            $.ajax({
                'url':'/room/share/getsharekeyajax.html',
                type:'post',    
                dataType:'json',
                async: false,
                data:{'itemid':itemid,'crid':<?php echo $roominfo['crid'];?>,'uid':<?php echo empty($user['uid'])?0:$user['uid'];?>},
                
                success:function(json){
                    if(json.code){
                        alert(json.data.msg);
                        return false;
                    }else{
                        sharekey = json.data;
                        }
                    },
                error:function(){
                    console.log('获取分享key失败,请刷新后重试');
                    }   
                });
            return sharekey;
            }
        function createSvg(content){
            var qrcodesvg = new Qrcodesvg(content, "svg-wrap", 250);
            qrcodesvg.draw();
            qrcodesvg.createSquare();
            
            var svgXml = $('.svg-wrap').html();
            var image = new Image();
            image.src = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svgXml))); //给图片对象写入base64编码的svg流
            var a = document.createElement('a');
            a.href = image.src; //直接导出SVG
            a.download = mathRand(); //设定下载名称
            a.click(); //点击触发下载 
            // 随机生成数字
            function mathRand() {
                var num = "";
                for(var i = 0; i < 6; i++) {
                    num += Math.floor(Math.random() * 10);
                }
                return num;
            }
        }
    var allow = <?=!empty($inner_data['pay_item']['allow']) ? 'true' : 'false'?>;
    var crid = <?=$roominfo['crid']?>;
$(window).scroll(function () {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
    pullupRefresh();
  //此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作

//var page = Number($("#redgiftNextPage").attr('currentpage')) + 1;
//redgiftList(page);
//$("#redgiftNextPage").attr('currentpage', page + 1);

    }
});

$("#plate-btn").bind('tap', function() {
    var t = $(this);
    if (t.hasClass('plate-sign-unlogin')) {
        location.href = 'http://wap.ebh.net/login.html?redirecturl='+encodeURIComponent(location.href);
        return false;
    }
    if (t.hasClass('plate-sign-unallow')) {
        alert('教师账号，不允许进行此操作。');
        return false;
    }

    if (!allow && t.hasClass('plate-sign-disabled')) {
        return false;
    }
    var url = '';
    if (allow) {
        url = 'http://wap.ebh.net/myroom/folder/common/'+t.attr('folderid')+'.html?crid='+crid;
    } else if (t.hasClass('plate-sign-free')) {
        url = 'http://wap.ebh.net/ibuy/dobuy.html?client=1&itemid='+t.attr('itemid')+'&fid='+t.attr('folderid')+'&crid='+crid;
        //url = 'http://wap.ebh.net/sharecourse/'+t.attr('itemid')+'.html';
    } else {
        var sharekey = '<?php $sharekey=$this->input->get('sharekey');echo empty($sharekey)?'':$sharekey;?>'
        url = 'http://wap.ebh.net/ibuy/'+t.attr('itemid')+'.html?client=1&crid='+crid+'&sharekey='+sharekey;
    }
    location.href = url;
    return false;
});

mui.init({
    swipeBack: true //启用右滑关闭功能
});
var page = 0;
var folderid = <?=(isset($inner_data['pay_item']['folderid'])?$inner_data['pay_item']['folderid']:0)?>;

/**
 * 滚动条加载具体业务实现
 */
var lastSectionAdd = '';//上次加载的章节名
function pullupRefresh() {
    $.ajax({
        url: '/room/portfolio/course_directory_mobile.html',
        type: 'get',
        data: { 'page': ++page, 'isAjax': 1, 'folderid': folderid ,'crid':<?php echo $roominfo['crid'];?>},
        dataType: 'json',
        success: function(ret) {
            if (ret) {
                var len = ret.length;
                var htmlfrage = '';
                var con = false;
                //开通直接跳转
                <?php if(empty($data['permission'])) {?>
                for(i = 0; i < len; i++) {
                    if (lastSectionAdd != ret[i]['section']) {
                       htmlfrage += '<div class="other-1" style="padding-left:18px;"><a href="javascript:;">'+ret[i]['section']+'</a> </div>';  
                    }
                    var plength = ret[i]['items'].length;
                    for(var p = 0; p < plength; p++) {
                        htmlfrage += '<li class="mui-table-view-cell"><a ><img style="max-width: 100px;height:62px;" class="mui-media-object mui-pull-left" src="'+ret[i]['items'][p].logo+'"><div class="mui-media-body mui-ellipsis">'+ret[i]['items'][p].title+'<p class="mui-ellipsis freestatus">'+ret[i]['items'][p].summary+'</p></div></a></li>';
                    }
                }
                if (ret.length) {
                    lastSectionAdd = ret[ret.length-1]['section'];
                }
                <?php }else{?>
                    for(i = 0; i < len; i++) {
                        if (lastSectionAdd != ret[i]['section']) {
                           htmlfrage += '<div class="other-1" style="padding-left:18px;"><a href="javascript:;">'+ret[i]['section']+'</a> </div>';  
                        }
                         var plength = ret[i]['items'].length;
                        for(var p = 0; p < plength; p++) {
                            htmlfrage += '<li class="mui-table-view-cell"><a href="/myroom/course/'+ret[i]['items'][p].cwid+'.html"><img style="max-width: 100px;height:62px;" class="mui-media-object mui-pull-left" src="'+ret[i]['items'][p].logo+'"><div class="mui-media-body mui-ellipsis">'+ret[i]['items'][p].title+'<p class="mui-ellipsis freestatus">'+ret[i]['items'][p].summary+'</p></div></a></li>';
                        }
                    }
                    if (ret.length) {
                        lastSectionAdd = ret[ret.length-1]['section'];
                    }
                 <?php }?>
                $("#content-panel").append(htmlfrage);
            }
            //mui('#pullrefresh').pullRefresh().endPullupToRefresh(!ret || ret.length == 0);
        }
    });
}
mui('.mui-scroll-wrapper').scroll();
$(".repic a").click(function(){
    $(this).addClass("cur");
    $(this).siblings().removeClass("cur");
    $(".showno").eq($(this).index()).show().siblings().hide();
});
var _w = parseInt($(window).width());//获取浏览器的宽度
$(".mui-input-row img").each(function(i){
    var img = $(this);
    var realWidth;//真实的宽度
    var realHeight;//真实的高度
        //这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
        $("<img/>").attr("src", $(img).attr("src")).load(function() {
        realWidth = this.width;
        realHeight = this.height;
        //如果真实的宽度大于浏览器的宽度就按照100%显示
        if(realWidth>=_w){
            $(img).css("width","100%").css("height","auto");
        }
        else{//如果小于浏览器的宽度按照原尺寸显示
            $(img).css("width",realWidth+'px').css("height",realHeight+'px');
        }
    });
});
$(function(){
    pullupRefresh();
});
</script>
<?php $this->display('shop/plate/footers');?>