<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<!--<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css?version=20160426001"/>-->
<style>
    em{
        font-style: italic;

    }
    .huide strong em{
        font-weight: bold;
    }
    .huide em strong{
        font-style: italic;
    }
    strong{
        font-weight: bold;
    }
</style>
<body>
<div class="allcou">
    <div class="matchtitle"><?php echo $info['subject']?></div>
    <div class="title">
        <a href="#"  class="aall curs">活动介绍</a>
    </div>
    <div class="match matchs">
        <div class="matchlist" style="border-bottom:none;">
            <div class="matchlistpics fl"><img src="<? echo empty($info['imgurl'])?'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg':$info['imgurl']?>" width="300" height="226" /></div>
            <div class="matchlistnrs fl" style="width:620px;">
                <div class="fl matchlistnrson">
                    <p class="mt5">时间：<?php echo $info['starttime']?>——<?php echo $info['endtime']?></p>
                    <?php $now = time()?>
                    <p>状态：<?php echo $now>strtotime($info['endtime'])+86400?'已结束':'进行中'?></p>
                </div>
                <div class="clear"></div>
                <div class="gxqcj">
                    <p><span style="font-weight:bold;"><?php echo !empty($info['parter'])?$info['parter']:0?></span>人参加</p>
                    <p><span style="font-weight:bold;"><?php echo !empty($info['viewnum'])?$info['viewnum']:0?></span>人感兴趣</p>
                </div>
                <div class="joins" style="position:relative;">
                    <a href="#" class="wycj">我要参加</a>
                    <a href="#" class="hdjs" style="display:none;">活动结束</a>
                    <a href="#" class="hdjs" style="display:none;">已参加</a>
                    <div class="ycjs" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/bmcg.png" width="118" height="42"/></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="hdnrs huide" style="line-height: 30px">
            <h2>活动内容</h2>
            <?php echo $info['message']?>
        </div>
        <div class="hdnrs mt15">
            <div>
                <h2 class="fl">报名信息</h2>
            </div>
            <div class="clear"></div>
            <div class="bmxxlist">
            </div>
        </div>
        <div class="clear"></div>
        <div class="hdnrs mt25">
            <h2>评论</h2>
        </div>
        <div class="clear"></div>
        <div class="fbpls">
            <textarea class="fbplstext"></textarea>
        </div>
        <div>&nbsp</div>
        <div class="bqtppl">
            <a href="javascript:;" class="biage">表情</a>
            <a href="javascript:;" class="pinglun">评&nbsp;论</a>
        </div>
    </div>
</div>
</body>
<script>
//    $('.biage').click(function(){
//        var button = new xButton();
//        H.create(new P({
//            id : 'ss',
//            title: '表情列表',
//            width:300,
//            padding:10,
//            content:'<a href="javascript:;" id="test"><img src="http://static.ebanhui.com/sns/images/qq/0.gif"></a>',
//            button:button
//        }),'common');
//        H.get('ss').exec('show');
//        $('#test').click(function(){
//            $('.fbplstext').html('11');
//        })
//    })
</script>
</html>
