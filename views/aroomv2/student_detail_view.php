<?php $this->display('aroomv2/room_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<style type="text/css">
.maines{
    margin:0 auto;
    float:none;
}
</style>
<div class="maines">
	<div class="txtcenter">
    	<?php echo $student['realname'];?>的体测记录
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
        	<a class="fenmor" href="javascript:;" by="class">按班级排名</a>
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
    <?php }else{?>
        <div class="nodata" style="min-height: 700px;">
    </div>
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
        location = '/aroomv2/health/student/detail/<?php echo $student['uid'];?>.html?field='+field;
    });
    $('#by').find("a").click(function(){
        var by = $(this).attr('by');
        location = '/aroomv2/health/student/detail/<?php echo $student['uid'];?>.html?field=<?php echo $fieldord;?>&by='+by;
    });
})
<?php if(!empty($result)){ ?>
    $(".nodata").hide();
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
           },min:0, allowDecimals:false
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
        $(".nodata").show();
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
<?php $this->display('troom/room_footer')?>
