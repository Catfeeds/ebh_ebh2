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
<div class="lefrig" style="margin-top: 10px;float:none">
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
    <div class="lefrig" style="height: 700px">
        <div class="juierse">
            <a href="/troomv2/statisticanalysis/statistical/<?php echo $uid?>.html">课件学习统计</a>
            <a href="/troomv2/statisticanalysis/homework/<?php echo $uid?>.html" class="jierla">作业统计</a>
            <a href="/troomv2/statisticanalysis/ask/<?php echo $uid?>.html">答疑统计</a>
            <a href="/troomv2/statisticanalysis/iaclassroom/<?php echo $uid?>.html">互动统计</a>
        </div>
        <div class="waisrrdr">
            <div class="jiswref">
                整体情况
            </div>
            <div class="juerrtse">
            <span class="hjuers">
                <span class="juerse" style="width: <?php echo ceil($info['myexamcount']/$info['myallexamcount']*100)?>%"></span>
            </span>
                <p class="huerae">收到的作业：<?php echo $info['myallexamcount']?>份</p>
                <p class="huerae">完成的作业：<?php echo $info['myexamcount']?>份</p>
                <p class="huerae">完成情况：<?php echo ceil($info['myexamcount']/$info['myallexamcount']*100)?>%</p>
            </div>
        </div>
        <div class="waisrrdr">
            <div class="jiswref">
                作业统计折线图
            </div>
            <div class="juerrtse">
                <a href="javascript:;" onclick="page()" class="jietlef"></a>
                <span class="jierfew">当前<kbd id="num">15</kbd>份作业走势图</span>
                <a href="javascript:;" onclick="page2()" class="jisrrig"></a>
                <input id="page" value="<?php echo $page?>" style="display: none">
                <input id="count" value="<?php echo $count?>" style="display: none">
            </div>
        </div>
        <div id="container" style="height: 300px"></div>
    </div>

    <div  class="clear"></div>
</div>
</body>
<script>
var exampower = "<?=$examPower?>";
    $(document).ready(function() {
    	if(exampower !='1'){
    		homework(1);
    	}else{
    		homeworkv2(1);
    	}
        var page = $('#count').val();
        if(page==1){
            $('.jietlef').css('background-image','url(http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr3.png)');
        }
    });
    function page(){
        var num = 1;
        var page = Number($('#page').val())+num;
        if(page><?php echo $count?>){
//            page = <?php //echo $count?>//;
            return;
        }
        if(page==2){
            $('.jisrrig').css('background-image','url(http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr2.png)');
        }
        if(page==<?php echo $count?>){
            $('.jietlef').css('background-image','url(http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr3.png)');
        }
        $('#page').val(page)
        
        if(exampower !='1'){
    		homework(page);
    	}else{
    		homeworkv2(page)
    	}
        
        
    }
    function page2(){
        var num = 1;
        var page = Number($('#page').val())-num;
        if(page<1){
            return;
        }
        if(page==1){
            $('.jisrrig').css('background','#fff url(http://static.ebanhui.com/ebh/tpl/troomv2/images/dqsyfzstr.png) no-repeat scroll;')
        }
        if(page == <?php echo $count-1?>){
            $('.jietlef').css('background-image','url(http://static.ebanhui.com/ebh/tpl/troomv2/images/lefter.jpg)');
        }

        $('#page').val(page)
        if(exampower !='1'){
    		homework(page);
    	}else{
    		homeworkv2(page)
    	}
    }

    function homework(page){
       var page = page
//        $('#chaptersver2').hide(300);
//        $('#month span').html(month+'月');
        $.post('/troomv2/statisticanalysis/homework/<?php echo $uid?>.html',{page:page},function(data){
            var data = eval("("+data+")");
            $('#num').html(data.num);
            $('#container').highcharts({
                title: {
                    text:''
                },
//            subtitle: {
//                text: 'Source: WorldClimate.com',
//                x: -20
//            },
                xAxis: {
                    title:{
                        text:''
                    },
                    categories: data.x,
                    labels: {
                        enabled: false
                    }
                },
                yAxis: {
                    min:0,
                    title: {
                        text: '<br>作<br>业<br>得<br>分<br>率<br>%',
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
                    valueSuffix: '%'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '得分率',
                    data: data.score
                }]
            });
        })
    }
    
    function homeworkv2(page,url){
    	if(typeof url == "undefined") {
			url = '/troomv2/examv2/getStuExamsAjax.html';
		}
    	$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				uid : <?php echo $uid?>,
				page:page
			}
		}).done(function(res){
			var categories = [];
			var score = [];
			var examlist =  res.datas.examList;
			for(var i=0;i<examlist.length;i++){
				categories.push(examlist[i].exam.esubject);
				score.push(Math.round((examlist[i].userAnswer.anstotalscore/examlist[i].exam.examtotalscore)*100) )
			}
			$('#container').highcharts({
                title: {
                    text:''
                },
                xAxis: {
                    title:{
                        text:''
                    },
                    categories: categories,
                    labels: {
                        enabled: false
                    }
                },
                yAxis: {
                    min:0,
                    title: {
                        text: '<br>作<br>业<br>得<br>分<br>率<br>%',
                        rotation:0,
                        align:'high',
                        margin:20,
                        style: {
                            fontFamily:"Microsoft YaHei",
                            fontSize:'13px'
                        }
                    }
                },
                credits: {
                    text: ''
                },
                tooltip: {
                    valueSuffix: '%'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '得分率',
                    data: score
                }]
            });
		}).fail(function(){
			console.log('req err');
		});
    }
    
</script>
</html>