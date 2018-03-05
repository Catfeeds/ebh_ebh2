<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=20160810001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css?version=20160704001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<title>无标题文档</title>
</head>
<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
<?php $room_type = Ebh::app()->room->getRoomType();$room_type = ($room_type == 'com') ? 1 : 0;?>	


<body>
<div class="maines">
	<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
		<ul>
			 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span>体质健康</span></a></li>
		</ul>
	</div>
    <div class="xuantse">
    	<span class="lefwesi">查看项目：</span>
        <div class="rigmisr" id="field">
            <a class="fenmor" href="javascript:;" field="total">总分</a>
            <a class="fenmor" href="javascript:;" field="height">身高</a>
            <a class="fenmor" href="javascript:;" field="weight">体重</a>
            <a class="fenmor" href="javascript:;" field="vitalcapacity">肺活量</a>
            <a class="fenmor" href="javascript:;" field="running50">50米跑</a>
            <a class="fenmor" href="javascript:;" field="sit_and_reach">坐位体前屈</a>
            <a class="fenmor" href="javascript:;" field="running50_8">50米X8往返跑</a>
            <a class="fenmor" href="javascript:;" field="situp">一分钟仰卧起坐</a>
            <a class="fenmor" href="javascript:;" field="jump">一分钟跳绳</a>        
        </div>
    </div>
    <div class="xuantse">
    	<span class="lefwesi">查看方式：</span>
        <div class="rigmisr" id="by">
            <a class="fenmor" href="javascript:;" by="data">按数据</a>
            <?php if($fieldord != 'total' && $fieldord != 'height'){?>
            <a class="fenmor" id="height" href="javascript:;" by="score">按评分</a>
            <?php }?>
            <a class="fenmor" href="javascript:;" by="class"><?=($room_type == 1)?'按部门排名':'按班级排名'?></a>
        </div>
    </div>
    <div class="ttomfla">
        <div id="linecontainer" class="chartcontainer" style="">
        </div>
    </div>
    <div class="nodata" style="display:none">
    </div>
    <div style="display:none">
    <?php if(!empty($result)){?>
        <?php foreach ($result as $res) { ?>
        <div class="syname" id = "<?php echo $res['syname']?>">
            <div class="data1"><?php echo $res[$field]?></div>
            <?php if($field == 'total' || $field == 'height'){?>
            <div class="data2"></div>
            <?php }else{?>
                <?php 
                if(strstr($field,'_score')){
                    $field1 = strstr($field,'_score',true);
                }else{
                    $field1 = $field.'_score';
                }
                ?>
            <div class="data2"><?php echo $res[$field1]?></div>
            <?php }?>
            <div class="rank"><?php echo $res['rank']?></div>
            <div class="type"><?php echo $field;?></div>
        </div>
        <?php }?>
    <?php }?>
    </div>
</div>
<script>
$(function(){
    $('#field').find("a").click(function(){
        var field = $(this).attr('field');
        if(field == 'total' || field == 'height'){
            $('#height').hide();
        } 
        location = '/college/health.html?field='+field;
    });
    $('#by').find("a").click(function(){
        var by = $(this).attr('by');
        location = '/college/health.html?field=<?php echo $fieldord;?>&by='+by;
    });
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
})
<?php if(!empty($result)){ ?>
$('#linecontainer').highcharts({
        xAxis: {
            categories: [<?php if(!empty($xAxis)){echo $xAxis;}?>]
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name:'成绩',
            data: [<?php if(!empty($result) && $by != 'class'){
                $str = '';
                foreach ($result as $key => $value) {
                    $str.= $value[$field].',';
                }
                $str = rtrim($str,',');
                echo $str;
            }else{
               $str = '';
                foreach ($result as $key => $value) {
                    $str.= $value['rank'].',';
                }
                $str = rtrim($str,','); 
                echo $str;
            }?>]
        }],
        title:{
            text:null
        },
        credits:{
            enabled:false 
        },
        yAxis:{
           title:{
               text:null
           },min:0
        },
        legend: {
            enabled: false
        },
        tooltip:{
            formatter:function(){
                var x = this.x;
                var data1 = $("#"+x).find('.data1').html();
                var data2 = $("#"+x).find('.data2').html();
                var rank = $("#"+x).find('.rank').html();
                var type =  $("#"+x).find('.type').html(); 
                if(type == 'total'){
                    return '总分：'+data1+'分;排名:'+rank;
                }
                if(type == 'height'){
                    return '身高：'+data1+'cm;排名:'+rank;
                }
                if(type == 'weight'){
                    return '体重：'+data1+'kg;评分：'+data2+';排名:'+rank;
                }
                if(type == 'weight_score'){
                    return '体重：'+data2+'kg;评分：'+data1+';排名:'+rank;
                }
                if(type == 'vitalcapacity'){
                    return '肺活量：'+data1+'ml;评分：'+data2+';排名:'+rank;
                }
                if(type == 'vitalcapacity_score'){
                    return '肺活量：'+data2+'ml;评分：'+data1+';排名:'+rank;
                }
                if(type == 'running50'){
                    return '50米跑：'+data1+'s;评分：'+data2+';排名:'+rank;
                }
                if(type == 'running50_score'){
                    return '50米跑：'+data2+'s;评分：'+data1+';排名:'+rank;
                }
                if(type == 'sit_and_reach'){
                    return '坐位体前屈：'+data1+'cm;评分：'+data2+';排名:'+rank;
                }
                if(type == 'sit_and_reach_score'){
                    return '坐位体前屈：'+data2+'cm;评分：'+data1+';排名:'+rank;
                }
                if(type == 'running50_8'){
                    return '50米×8往返跑：'+data1+'s;评分：'+data2+';排名:'+rank;
                }
                if(type == 'running50_8_score'){
                    return '50米×8往返跑：'+data2+'s;评分：'+data1+';排名:'+rank;
                }
                if(type == 'situp'){
                    return '一分钟仰卧起坐：'+data1+'次;评分：'+data2+';排名:'+rank;
                }
                if(type == 'situp_score'){
                    return '一分钟仰卧起坐：'+data2+'次;评分：'+data1+';排名:'+rank;
                }
                if(type == 'jump'){
                    return '一分钟跳绳：'+data1+'次;评分：'+data2+';排名:'+rank;
                }
                if(type == 'jump_score'){
                    return '一分钟跳绳：'+data2+'次;评分：'+data1+';排名:'+rank;
                }

            }
        }
    });
<?php }else{ ?>
    $(function(){
        $('.nodata').css('min-height','700px');
        $('.nodata').show();
    })
<?php }?>
$(function(){
    <?php if(strstr($field,'_score')){
        $field2 = strstr($field,'_score',true);
    }else{
        $field2 = $field;
    }?>
    var field = "<?php echo $field2;?>";
    $("#field").find('a').each(function(){
        $(this).removeClass('fenlan');
        if($(this).attr('field') == field){
            $(this).removeClass('fenmor');
            $(this).addClass('fenlan');
        }
    });
    var field1 = "<?php echo $by;?>";
    if(field1 == ''){
        field1 = 'data';
    }
    $("#by").find('a').each(function(){
        $(this).removeClass('fenlan');
        if($(this).attr('by') == field1){
            $(this).removeClass('fenmor');
            $(this).addClass('fenlan');
        }
    });
})
</script>
</body>
</html>
