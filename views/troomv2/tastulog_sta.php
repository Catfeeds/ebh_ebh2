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
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>

<!--<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">-->
<!--    <div class="esukangs">-->
<!--        <a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>-->
<!--         <a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a> -->
<!--    </div>-->
<!--</div>-->
<div class="lefrig" style="float: none;margin-top: 10px;">
    <?php
    $this->assign('data_index',8);
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
    <div class="lefrig">
        <div class="juierse">
            <a href="/troomv2/statisticanalysis/statistical/<?php echo $uid?>.html" class="jierla">课件学习统计</a>
            <a href="/troomv2/statisticanalysis/homework/<?php echo $uid?>.html">作业统计</a>
            <a href="/troomv2/statisticanalysis/ask/<?php echo $uid?>.html">答疑统计</a>
            <a href="/troomv2/statisticanalysis/iaclassroom/<?php echo $uid?>.html">互动统计</a>
        </div>
        <div class="waisrrdr">
            <div class="jiswref">
                整体情况
            </div>
            <div class="juerrtse">
            <span class="hjuers" >
                <span class="juerse" style="width: <?php echo $study>100?100:$study?>%"></span>
            </span>
                <p class="huerae">课件总时长：<?php echo $coursewarelenth?></p>
                <p class="huerae">学习总时长：<?php echo $time?></p>
                <p class="huerae">完成情况：<?php echo $study?>%</p>
            </div>
        </div>
        <div class="waisrrdr">
            <div class="jiswref">
                课件学习统计折线图
            </div>
            <div class="juerrtse" style="width: 780px">
                <a href="javascript:;" class="anyue">按月度</a>
                <div class="kdhtygs">
                    <div class="kstdg xchaptervertit" id="years">
                        <span class="xchapterverselected" tag="0"><?php echo date('Y',time())?>年</span>
                    </div>
                    <div id="chaptersver" class="xchaptersver" style="display: none;">
<!--                        <a class="chver_option" href="javascript:;" chapterid="5" onclick="choose(2016)">2016年</a>-->
<!--                        <a class="chver_option" href="javascript:;" chapterid="4" onclick="choose(2015)">2015年</a>-->
<!--                        <a class="chver_option" href="javascript:;" chapterid="6" onclick="choose(2014)">2014年</a>-->
<!--                        <a class="chver_option" href="javascript:;" chapterid="109" onclick="choose(2013)">2013年</a>-->
                        <?php foreach($data_y as $y){?>
                            <a class="chver_option" href="javascript:;" chapterid="109" onclick="choose(<?php echo $y?>)"><?php echo $y?>年</a>
                        <?php }?>
                    </div>
                </div>
                <div class="kdhtygs">
                    <div class="kstdg xchaptervertit" id="month">
                        <span class="xchapterverselected" tag="0"><?php echo date('m')?>月</span>
                    </div>
                    <div id="chaptersver2" class="xchaptersver" style="display: none;height: 100px" >
                        <?php foreach($data_m as $m){?>
                            <a class="chver_option" href="javascript:;" chapterid="109" onclick="month(<?php echo $m?>)"><?php echo $m?>月</a>
                        <?php }?>
                    </div>
                    <div id="chaptersver3" class="xchaptersver" style="display: none;height: 100px" >
                        <?php for($i=1;$i<13;$i++){?>
                            <a class="chver_option" href="javascript:;" chapterid="109" onclick="month(<?php echo $i?>)"><?php echo $i?>月</a>
                        <?php }?>
                    </div>
                    <input style="display: none" id="Year_m" value="<?php echo date('Y',time())?>">
                </div>
                <div class="juerrtse" style="margin-top:15px;">
                    <a href="javascript:;" class="annian">按年度</a>
                    <div class="kdhtygs">
                        <div class="kstdg xchaptervertit" id="years1">
                            <span class="xchapterverselected" tag="0"><?php echo date('Y',time())?>年</span>
                        </div>
                        <div id="chaptersver1" class="xchaptersver" style="display: none;">
<!--                            <a class="chver_option" href="javascript:;" chapterid="5" onclick="years(2016)">2016年</a>-->
<!--                            <a class="chver_option" href="javascript:;" chapterid="4" onclick="years(2015)">2015年</a>-->
<!--                            <a class="chver_option" href="javascript:;" chapterid="6" onclick="years(2014)">2014年</a>-->
<!--                            <a class="chver_option" href="javascript:;" chapterid="109" onclick="years(2013)">2013年</a>-->
                            <?php foreach($data_y as $v){?>
                                <a class="chver_option" href="javascript:;" chapterid="109" onclick="years(<?php echo $v?>)"><?php echo $v?>年</a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="clear"></div>
    <div id="container2" style="height: 300px;"></div>
</div>
</body>
<script>
    $(document).ready(function() {
        month(<?php echo date('m',time())?>);
    });
    $('#month').click(function(){
        var year = $('#Year_m').val();
        if(year==<?php echo date('Y',time())?>){
            $('#chaptersver2').toggle(500);
            $('#chaptersver3').hide();
        }else{
            $('#chaptersver3').toggle(500);
            $('#chaptersver2').hide();
        }

    })
    $('#years1').click(function(){
        $('#chaptersver1').toggle(500)
    })
    $('#years').click(function(){
        $('#chaptersver').toggle(500)
    })
    $('.annian').click(function(){
//        $(this).removeClass("annian");
//        $(this).addClass("anyue");
        $(this).css('background','#5e98f9');
        $(this).css('color','#fff');
        $('.anyue').css('color','#666');
        $('.anyue').css('background','#fff');
        $('.anyue').css('border','solid 1px #999')
        years(<?php echo date('Y',time())?>);
    })
    $('.anyue').click(function(){
        $(this).css('background','#5e98f9');
        $(this).css('color','#fff');
        $('.annian').css('color','#666');
        $('.annian').css('background','#fff');
        month(<?php echo date('m',time())?>);
    })

    //按月度选择年份
    function choose(year){
        var year = year;
        $('#chaptersver').hide(300);
        $('#years span').html(year+'年');
        $('#Year_m').val(year);
    }
    //按年度
    function years(year){
        $('.annian').css('background','#5e98f9');
        $('.annian').css('color','#fff');
        $('.anyue').css('color','#666');
        $('.anyue').css('background','#fff');
        $('.anyue').css('border','solid 1px #999')
        var year = year;
        $('#chaptersver1').hide(300);
        $('#years1 span').html(year+'年');
        $.post('/troomv2/statisticanalysis/statistical/<?php echo $uid?>.html',{year:year},function(data){
            var data = eval("("+data+")");
            $('#container2').highcharts({
                title: {
                    text: '',
                    x: -20 //center
                },
//            subtitle: {
//                text: 'Source: WorldClimate.com',
//                x: -20
//            },
                xAxis: {
                    title:{
                        text:'月份'
                    },
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    min:0,
                    title: {
                        text: '<br>听<br>课<br>时<br>长<br>/<br>小<br>时',
                        rotation:0,
                        align:'high',
                        margin:20,
                        style: {
                            fontFamily:"Microsoft YaHei",
                            fontSize:'13px'
                        }
                    }
//                plotLines: [{
//                    value: 0,
//                    width: 2,
//                    color: '#808080'
//                }]
                },
                credits: {
                    text: ''
                },
                tooltip: {
                    valueSuffix: '小时'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '听课时长',
                    data: data.homework
                }]
            });
        })
    }
    //按月度
    function month(month){
        $('.anyue').css('background','#5e98f9');
        $('.anyue').css('color','#fff');
        $('.annian').css('color','#666');
        $('.annian').css('background','#fff');
        var month = month;
        var year = $('#Year_m').val();
        $('#chaptersver2').hide(300);
        $('#chaptersver3').hide(300);
        $('#month span').html(month+'月');
        $.post('/troomv2/statisticanalysis/statistical/<?php echo $uid?>.html',{year:year,month:month},function(data){
            var data = eval("("+data+")");
            $('#container2').highcharts({
//                chart:{
//                  marginLeft:150,
//                    marginRight:150
//                },
                title: {
                    text: '',
                    x: -20 //center
                },
//            subtitle: {
//                text: 'Source: WorldClimate.com',
//                x: -20
//            },
                xAxis: {
                    title:{
                        text:'日期'
                    },
                    categories: data.x
                },
                yAxis: {
                    min:0,
                    title: {
                        text: '<br>听<br>课<br>时<br>长<br>/<br>分<br>钟',
                        rotation:0,
                        align:'high',
                        margin:20,
                        style: {
                            fontFamily:"Microsoft YaHei",
                            fontSize:'13px'
                        }

                    }
//                plotLines: [{
//                    value: 0,
//                    width: 2,
//                    color: '#808080'
//                }]
                },
                credits: {
                    text: ''
                },
                tooltip: {
                    valueSuffix: '分钟'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '听课时长',
                    data: data.homework
                }]
            });
        })
    }
</script>
</html>