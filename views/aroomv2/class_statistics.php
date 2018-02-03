<?php $this->display('aroomv2/room_header');?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<style type="text/css">
.maines{
    float:none;
    margin: 0 auto;
}
.ranktable:hover{
    background: #F2FBFF;
}
.rheutder{
    margin:0px;
    margin-left: 40px;
}
.tsarse{
    padding-bottom: 35px;
}
</style>
<div class="maines">
	<div class="txtcenter">
    	<?php echo $classname;?>
    </div>
    <?php if(!empty($lists)){ ?>
    <table class="tsarse" cellspacing="0" cellpadding="0">
        <tbody>
            <tr class="fonsiz">
                <td width="34%">
                名称
                </td>
                <td width="33%">
                录入时间
                </td>
                <td width="33%">
                操作
                </td>
            </tr>

            <?php foreach ($lists as $list) { ?>
            <tr>
                <td width="34%">
                <?php echo $list['syname']?>学年体质健康数据
                </td>
                <td width="33%">
                <?php echo date('Y-m-d H:i',$list['dateline']) ?>
                </td>
                <td width="33%">
                <a class="lansere lookup" href="javascript:;" cid="<?php echo $list['cid']?>" syid="<?php echo $list['syid']?>">查看</a>
                <a class="lansere download" href="/aroomv2/health/outputExcel.html?cid=<?php echo $list['cid']?>&syid=<?php echo $list['syid']?>">下载</a>
                </td>
            </tr>
        <?php }?>
         
        </tbody>
    </table>
    <?php }else{?>
        <div class="nodata">
        </div>
    <?php }?>
    <div id="zdd" style="display:none">
	<div class="txtcenter txtcenter1" style="border:none;">
    	
    </div>
    <div class="xuantse">
    	<span class="lefwesi">查看项目：</span>
        <div class="rigmisr" id="field">
        	<a class="fenlan" href="javascript:;" field="total">总分</a>
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
        <div class="rigmisr" id="type">
        	<a class="fenlan" href="javascript:;" id = "grade" type="grade">等级比例图</a>
        	<a class="fenmor" href="javascript:;" id="score" type="score">得分排名表</a>
        </div>
    </div>
    <div class="nuyuasrt">
    	<div id="container">
        </div>
    </div>
    <div class="rank" style="display:none">
        <a href="javascript:;" class="husrxfe">导出Excel</a>
        <div class="rheutder">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="datatabss xmpmjf">
                    <tbody class="head">                
                </tbody></table>
            </div>
    </div>
    <div class="nodata" style="display:none">
    </div>
</div>
</div>
<script type="text/javascript">
$(function(){
var cid = 0;
var syid = 0;
var field = 'total';
var type = 'grade';
    $(".lookup").click(function(){
        cid = $(this).attr('cid');
        syid = $(this).attr('syid');
        syname = $(this).parent().prev().prev().html();
        $(".txtcenter1").html(syname);
        $("#zdd").show();
        field = 'total';
        type = 'grade';
        $("#field").find('a').each(function(){
            $(this).removeClass('fenlan');
            $(this).addClass('fenmor');
        });
        $("#type").find('a').each(function(){
            $(this).removeClass('fenlan');
            $(this).addClass('fenmor');
        });
        $("#field").find('a').eq(0).removeClass('fenmor').addClass('fenlan');
        $("#type").find('a').eq(0).removeClass('fenmor').addClass('fenlan');
        ajaxpostsend();
    });
    $(".husrxfe").click(function(){
        window.location.href = '/aroomv2/health/outputRank.html?cid='+ cid + '&syid='+ syid + '&field='+ field;
    });
    function ajaxpostsend(){
            $.ajax({
            type:'post',
            url: '/aroomv2/health/getClassStatisticsByajax.html',
            dataType:'json',
            data:{'cid':cid,'syid':syid,'field':field,'type':type},
            success:function(data){
                if(type == 'grade'){
                    $(".nuyuasrt").show();
                    $(".rank").hide();
                    showcharts(data,field);  
                }else{
                    $(".nuyuasrt").hide();
                    $(".nodata").hide();
                    $(".rank").show();
                    if(field == 'total'){
                        var unit = '分';
                    }
                    if(field == 'height'){
                        var unit = 'cm';
                    }
                    if(field == 'weight'){
                        var unit = 'kg';
                    }
                    if(field == 'vitalcapacity'){
                        var unit = 'ml';
                    }
                    if(field == 'running50'){
                        var unit = 's';
                    }
                    if(field == 'sit_and_reach'){
                        var unit = 'cm';
                    }
                    if(field == 'running50_8'){
                        var unit = 's';
                    }
                    if(field == 'situp'){
                        var unit = '次';
                    }
                    if(field == 'jump'){
                        var unit = '次';
                    }
                    var html = '<tr style="background:#fff;"><th width="40%">姓名</th><th width="40%">排名</th><th width="20%">成绩</th></tr>';
                    $.each(data,function(key,value){
                        if(key < 3 ){
                            html+='<tr class="ranktable"><td class="td1"><div class="fl mingci">'+(key+1)+'</div><div class="toxiangs fl ml15"><img width="40" height="40" src="'+value.face+'"></div><div class="fl ml10">'+value.studentname+'</div></td><td>No.'+(key+1)+'</td><td>'+value.data+unit+'</td></tr>';
                        }else{
                            html+='<tr class="ranktable"><td class="td1"><div class="toxiangs fl ml15"><img width="40" height="40" src="'+value.face+'"></div><div class="fl ml10">'+value.studentname+'</div></td><td>No.'+(key+1)+'</td><td>'+value.data+unit+'</td></tr>';
                        }
                        $('.head').find("tr").remove();
                        $('.head').append(html);
                    });
                }
            }
        });
    }
    $("#field").find("a").click(function(){
        field = $(this).attr('field');
        if(field == 'height'){
            type = 'score';
            $("#score").removeClass('fenmor');
            $("#score").addClass('fenlan');
            $("#grade").removeClass('fenlan');
            $("#grade").addClass('fenmor');
            $("#grade").hide();
        }else{
            $("#grade").show();
        }
        $("#field").find("a").each(function(){
            $(this).removeClass('fenlan');
            $(this).removeClass('fenmor');
            $(this).addClass('fenmor');
        });
        $(this).removeClass('fenmor');
        $(this).addClass('fenlan');
        ajaxpostsend();
    });
    $("#type").find("a").click(function(){
        type = $(this).attr('type');
        $("#type").find("a").each(function(){
            $(this).removeClass('fenlan');
            $(this).removeClass('fenmor');
            $(this).addClass('fenmor');
        });
        $(this).removeClass('fenmor');
        $(this).addClass('fenlan');
        ajaxpostsend();
    });
})
function showcharts(data,field){
    if(data.a == 0 && data.b == 0 && data.c ==0 && data.d == 0){
        $(".nodata").show();
        $(".nuyuasrt").hide();
        return false;
    }else{
        $(".nuyuasrt").show();
        $(".nodata").hide();
    }
    var data1 = '优秀';
    var data2 = '良好';
    var data3 = '合格';
    var data4 = '不合格';
    if(field == 'total'){
        var name = '总分';
    }
    if(field == 'weight'){
        var name = '体重';
        var data1 = '正常';
        var data2 = '超重';
        var data3 = '低体重';
        var data4 = '肥胖';
    }
    if(field == 'vitalcapacity'){
        var name = '肺活量';
    }
    if(field == 'running50'){
        var name = '50米跑';
    }
    if(field == 'sit_and_reach'){
        var name = '坐位体前屈';
    }
    if(field == 'running50_8'){
        var name = '50米X8往返跑';
    }
    if(field == 'situp'){
        var name = '一分钟仰卧起坐';
    }
    if(field == 'jump'){
        var name = '一分钟跳绳';
    }
    var data01 = parseFloat((data.a/(data.a+data.b+data.c+data.d)).toFixed(3));
    var data02 = parseFloat((data.b/(data.a+data.b+data.c+data.d)).toFixed(3));
    var data03 = parseFloat((data.c/(data.a+data.b+data.c+data.d)).toFixed(3));
    var data04 = parseFloat((data.d/(data.a+data.b+data.c+data.d)).toFixed(3));
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: name,
            data: [
                [data1,   data01],
                [data2,   data02],
                [data3,   data03],
                [data4,   data04],
            ]
        }]
    });
}
function toDecimal(x) {  
    var f = parseFloat(x);  
    if (isNaN(f)) {  
        return;  
    }  
    f = Math.round(x*100)/100;  
    return f;  
}
function downloader(cid,syid){
    var downcid = cid;
    var downsyid = syid;
    $.ajax({
            type:'post',
            url: '/aroomv2/health/outputExcel.html',
            dataType:'json',
            data:{'cid':cid,'syid':syid},
            success:function(data){

            }
        });
}
$(function(){
    $('.tsarse').find('tr').last().children('td').each(function(){
        $(this).css('border-bottom','none');
    });
})
</script>
<?php $this->display('aroomv2/page_footer')?>
<?php $this->display('troom/room_footer')?>
