<?php $this->display('troomv2/room_header');?>
<style>
    #icategory {
        background: none repeat scroll 0 0 #F7FAFF;
        border-top: 1px solid #E1E7F5;
        padding: 6px 20px;
        _margin-bottom:-5px;
    }
    #icategory dt {
        float: left;
        line-height: 22px;
        padding-right: 5px;
        text-align: left;
    }
    #icategory dd {
        float: left;
        width: 645px;
    }
    .category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
        background: none repeat scroll 0 0 #FF5400;
        color: #FFFFFF;
        text-decoration: none;
    }
    .category_cont1 div a {
        color: #2C71AE;
        text-decoration: none;
        padding: 2px;
    }
    .category_cont1 div {
        float: left;
        height: 25px;
        line-height: 22px;
        overflow: hidden;
        padding:0 10px;
    }
    .pbtns {
        background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
        border: medium none;
        color: #333333;
        height: 20px;
        vertical-align: middle;
        width: 40px;
        cursor:pointer;
    }
</style>
<!--<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">-->
<!--    <div class="esukangs">-->
<!--        <a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>-->
<!--         <a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a> -->
<!--    </div>-->
<!--</div>-->
<div class="lefrig" style="float: none;margin-top: 10px;">
<?php
$this->assign('data_index',6);
$this->display('troomv2/data_menu');
?>
<style type="text/css">
    .card-body {width:900px;padding: 20px 30px 50px;; margin:0 auto;}
    .essinfor_top{ height:27px; line-height:27px;width:900px;margin:0; border-bottom:1px solid #e1e1e1; padding-bottom:10px;}
    .essinfor_top .title{ width:595px; padding:0 !important;}
    .essinfor_top .title h3{ color:#333; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/pico1.jpg") no-repeat left center; padding-left:30px; height:27px; font-size:14px; font-weight:bold;}
    .essinfor_top a.hrelh {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg") no-repeat left center;color: #2796f0;display: block;float: right;height: 24px;line-height: 24px;padding-left: 20px;text-align: center;text-decoration: none;width: 45px;}
    .essinfor_bottom{ line-height:32px; font-size:14px; min-height:210px;}
    .essinfor_bottom ul li{ width:360px; }
    .essinfor_bottom .span1{ color:#333;margin-left:0px;font-family:"微软雅黑";}
    .essinfor_bottom .span2{ color:#666;font-weight:normal;}
    ul li.essinfor_bottoms{ width:684px; border:1px solid #e6e6e6; padding:10px 20px;}
    .essinfor_tops{ height:27px; line-height:27px; padding-bottom:10px;margin:0px;width:900px;}
    .essinfor_tops .title{ width:595px; padding:0 !important;}
    .essinfor_tops .title h3{ font-size:14px; font-weight:bold;color:#333; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/pico2.jpg") no-repeat left center; padding-left:30px; height:27px;}
    .essinfor_tops a.hrelh {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg") no-repeat left center;color: #2796f0;display: block;float: right;height: 24px;line-height: 24px;padding-left: 20px;text-align: center;text-decoration: none;width: 45px;}
    .essinfor_bottoms .date{ font-weight:bold; font-size:14px; color:#333; display:block; padding-bottom:7px;}
    .essinfor_bottoms .olddescription{ font-size:13px; color:#606060; word-wrap: break-word; width:696px;}
    .essinfor_bottoms .action {display: none;}
    .essinfor_bottoms .action .icons {background-color: #abc0e9;border-radius: 2px;color: #fff;cursor: pointer;font-size: 12px;line-height: 18px;margin-left: 10px;padding: 3px 7px;}
    .essinfor_bottom .span1s{ position:relative; top:-50px;}
    .essinfor_bottom textarea{ font-size:14px;  padding:10px; line-height:23px;letter-spacing: 2px;}
    .card-body .essinfor input{ width:260px; border:1px solid #e1e1e1; height:24px; line-height:24px; padding-left:5px;}
    .fkrer { display: inline;float: right; height: 50px;padding: 10px 0 0;}
    .fkrer a.huibtn {border: none;color: #fff;cursor: pointer;display: block;float: left;font-size: 14px;height: 32px;line-height: 32px;text-align: center;text-decoration: none; width: 87px;}
    .fkrer a.lanbtn {background: #18a8f7 ;border: medium none;color: #fff;cursor: pointer;display: block;float: left;font-size: 14px;font-weight: bold;height: 32px;line-height: 32px;text-align: center;text-decoration: none; width: 87px;}
    .essinfor_bottoms{ font-size:14px; font-family:"微软雅黑";}
    .neirongs{ border:1px solid #e1e1e1; width:684px; height:100px; padding:10px 20px; color:#666;}
    .span2s{ position:relative; top:-25px;}
    .xqah .essinfor_bottom ul li{ height:64px;}
    .expedit{font-size: 13px;}
    .expedit input{ width:240px; border:1px solid #e1e1e1; height:24px; line-height:24px; padding-left:5px;}
    .xqahs .essinfor_bottom ul li{*margin-top:10px;}
    .xqahs .essinfor_bottom ul li{ line-height:18px;}
</style>
<body>
<div class="czjl">
    <div class="czjlson">成长记录</div>
    <div class="lsrey">
        <div class="hrthd">
            <ul>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['credit']?></p>
                    <p style="font-size:12px; color:#999;">积分</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['signlogcount']?></p>
                    <p style="font-size:12px; color:#999;">签到</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['mystudycount']?></p>
                    <p style="font-size:12px; color:#999;">学习</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr" title="已完成<?=$baseinfo['myexamcount']?>份,总共<?=$baseinfo['myallexamcount']?>份"><?=$baseinfo['myexamcount']?>/<?=$baseinfo['myallexamcount']?></p>
                    <p style="font-size:12px; color:#999;">作业</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['myaskcount']?></p>
                    <p style="font-size:12px; color:#999;">提问</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['myanscount']?></p>
                    <p style="font-size:12px; color:#999;">答疑</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['myreviewcount']?></p>
                    <p style="font-size:12px; color:#999;">评论</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['mythankcount']?></p>
                    <p style="font-size:12px; color:#999;">感谢</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['myfeedscount']?></p>
                    <p style="font-size:12px; color:#999;">新鲜事</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['myarticlescount']?></p>
                    <p style="font-size:12px; color:#999;">日志</p>
                </li>
                <li class="sktdsw">
                    <p class="zhonsr"><?=$baseinfo['myfanscount']?></p>
                    <p style="font-size:12px; color:#999;">粉丝</p>
                </li>
                <li class="sktdsw" style="border:none;">
                    <p class="zhonsr"><?=$baseinfo['myfavoritcount']?></p>
                    <p style="font-size:12px; color:#999;">关注</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="czjlson cztj">成长统计</div>
    <?php $ia = $ialogsCount == 0 ? 0 : ceil($ialogsCount_c/$ialogsCount*100);$homework = $baseinfo['myallexamcount'] == 0 ? 0 : ceil($baseinfo['myexamcount']/$baseinfo['myallexamcount']*100);
    $all = ($ia+$homework+$study)/3;
    if($all>80){
    ?>
    <p class="xxqks"><span>学习情况：&nbsp;勤奋</span><span class="ml25">评语：&nbsp;你的努力程度超越了大部分同学，一份努力一份收获，请继续保持哦！</span></p>
    <?php }elseif($all>50){?>
    <p class="xxqks"><span>学习情况：&nbsp;活跃</span><span class="ml25">评语：&nbsp;你的学习情况比较活跃，但仍有提高空间哦，请继续努力！</span></p>
    <?php }else{?>
    <p class="xxqks"><span>学习情况：&nbsp;懒惰</span><span class="ml25">评语：&nbsp;你的学习状况比较糟糕，目前落后于大部分同学，请努力加油，争取早日超越同学！</span></p>
    <?php }?>
    <div class="xxhdzydy">
        <div class="xxtjs">
            <div class="xxtjtb"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xxtj.png" /></div>
            <div class="xxtjtitle">学习统计</div>
            <div class="xxtjbfb"><?php echo $study?>%</div>
            <div class="xxqks xxqks1">课件总时长：<?php echo $coursewarelenth?></div>
            <div class="xxqks xxqks1">学习总时长：<?php echo $time?></div>
        </div>
        <div class="xxtjs">
            <div class="xxtjtb"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/hdtj.png" /></div>
            <div class="xxtjtitle">互动统计</div>
            <div class="xxtjbfb"><?php echo $ia?>%</div>
            <div class="xxqks xxqks1">互动总次数：<?php echo $ialogsCount?>次</div>
            <div class="xxqks xxqks1">参与的互动：<?php echo $ialogsCount_c?>次</div>
        </div>
        <div class="xxtjs">
            <div class="xxtjtb"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/zytj.png" /></div>
            <div class="xxtjtitle">作业统计</div>
            <div class="xxtjbfb"><?php echo $homework?>%</div>
            <div class="xxqks xxqks1">收到的作业：<?=$baseinfo['myallexamcount']?>份</div>
            <div class="xxqks xxqks1">完成的作业：<?=$baseinfo['myexamcount']?>份</div>
        </div>
        <div class="xxtjs">
            <div class="xxtjtb"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/dttj.png" /></div>
            <div class="xxtjtitle">答疑统计</div>
            <div class="xxtjbfb"><?php echo $baseinfo['myaskcount']?>/<?php echo $baseinfo['myanscount']?></div>
            <div class="xxqks xxqks1">提出的问题：<?php echo $baseinfo['myaskcount']?>个</div>
            <div class="xxqks xxqks1">回答的问题：<?php echo $baseinfo['myanscount']?>个</div>
        </div>
    </div>
</div>
<div  class="clear"></div>
</div>
</body>
</html>