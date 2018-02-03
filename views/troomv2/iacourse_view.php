<?php $this->display('troomv2/room_header'); ?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css" />
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<style type="text/css">
.lefrig{
    margin:0 auto;
    float: none;
}
.realstatistics ul li{
    width: 856px;
}
.classboxmore{
    border-bottom: none;
}
.yixuexifa{
    border-bottom: none;
}
.lefrig{
    margin-bottom:90px;
    padding-bottom: 100px; 
}
</style>
<body>
<div class="lefrig">
    <div style="display:inline-block;">
    	<div class="tkfktitle"><?php echo shortstr(strip_tags($icinfo['title']),50);?></div>
        <div class="classboxmore">
            <div class="yixuexifa">
                <p class="sexqueue0" style="margin-left:130px;margin-right:15px;">
                    <span class="sexqueuefull0" style="width:<?php echo ceil($icinfo['answercount']/269*100)?>%;"></span>
                </p>
                <div style="float:left; display:inline;">
                    <p class="yixuexi reks">已交<?php echo $icinfo['answercount'];?>/269</p>
                    <p class="yjxxbfb persent"><?php echo floor($icinfo['answercount']/269*100)?>%</p>
                </div>
                <div class="pjxxsc">
                    <p class="yixuexi">平均答题时长</p>
                    <p class="yjxxbfb min">
                    <?php if(empty($icinfo['answercount'])){
                        echo 0;
                    }else{
                        echo floor($icinfo['totaltime']/$icinfo['answercount']/60);
                    }
                        ?>
                    <span style="font-size:14px;">分钟</span></p>
                </div>
            </div>
        </div>
        <div class="realstatisticsfa">
        	<div class="navigation">
                <ul>
                    <li><a href="javascript:void(0)" class="curr timeans">实时统计</a></li>
                    <li><a href="javascript:void(0)" class="havestudent">已交学生(<?php echo $icinfo['answercount'];?>)</a></li>
                    <li><a href="javascript:void(0)" class="havenostudent">未交学生(30)</a></li>
                </ul>
            </div>
            <div class="realstatistics analyze" type="analyze">
            </div>
            <div class="havestudents have" type="have">

                <ul class="jisrner">

                </ul>
                <div id="page"></div>
                <div id="script"></div>
            </div>
            <div class="havestudents nohave" type="nohave">
                <div class="nostudentlist"></div>
                <div id="page"></div>
                <div id="script"></div>
            </div>
        </div>
    </div>
</div>
<div id="test"></div>
<script type="text/javascript">
var type = 'analyze';//默认显示分析页面
var icid = <?php echo $icid;?>;
var uri = '/troomv2/iacourse/detail.html';
var answertime = 0;//最近一次提交的时间
function chooseTag(){
    $(".analyze").hide();
    $(".have").hide();
    $(".nohave").hide();
    $("."+type).show();
    $.ajax({
        type:'post',
        url:'/troomv2/iacourse/getalreadyStudent.html',
        dataType:'json',
        data:{icid:icid,answertime:answertime},
        success:function(data){
             if(data.status == 1){
                $(".reks").html('已交'+data.answercount+'/'+data.totalcount);
                $('.sexqueuefull0').css('width',data.persent+'%');
                $(".persent").html(data.persent+'%');
                $(".min").html(data.time+'<span style="font-size:14px;">分钟</span>');
                $('.havestudent').html('已交学生('+data.answercount+')');
                $('.havenostudent').html('未交学生('+(data.totalcount-data.answercount)+')');
             }
        }
    });
    if(type == 'analyze'){
        $.ajax({
        type: "POST",
        url: "<?=geturl('troomv2/iacourse/detail')?>",
        dataType:'json',
        data:{icid:icid, type:type,answertime:answertime},
        success:function(res){
            if(res.status == 1){
                answertime = res.timecache;
                var html = '<ul>';
                $.each(res.data,function(k,v){
                    if(v[0]['type'] == 0 || v[0]['type'] == 1){
                        var option = '';
                        var arr = ['','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                        var flag = false;
                        $.each(v,function(key,i){
                            option+='["'+arr[i['qid']]+'选择人数：'+i['choosecount']+'人",'+i['choosecount']+'],';
                            if(i['choosecount'] != 0){
                                flag = true;
                            }
                        });
                        option = option.substring(0,option.length-1);
                        html+= '<li>'+
                    '<h4 class="realstatisticstitle"><span>Q'+v[0]['order']+'</span>';
                    if(v[0]['type'] == 0){
                        html+='(单选题)'; 
                    }else{
                        html+='(多选题)';
                    }
                    html+=v[0]['title']+'</h4>';
                    if(flag){
                        html+='<div style="width:450px;height:250px; float:left;" id="q'+v[0]['icqid']+'"></div>'+
                    '<script>'+
                    "$('#q"+v[0]['icqid']+"').highcharts({"+
                            "chart: {"+
                                "type: 'pie',"+
                                "options3d: {"+
                                    "enabled: true,"+
                                    "alpha: 45,"+
                                    "beta: 0"+
                               "}"+
                            "},"+
                            "credits: {"+
                                 "enabled: false"+
                            "},"+
                            "exporting: {"+
                            "enabled:false"+
                            "},"+
                            "title: {"+
                                "text: ''"+
                            "},"+
                            "plotOptions: {"+
                                "pie: {"+
                                    "allowPointSelect: true,"+
                                    "cursor: 'pointer',"+
                                    "depth: 35,"+
                                    "dataLabels: {"+
                                        "enabled: true,"+
                                        "format: '{point.name}'"+
                                    "}"+
                                "}"+
                            "},"+
                            "series: [{"+
                                "type: 'pie',"+
                                "name: '选择人数',"+
                                "data: ["+
                                    option+
                                "]"+
                            "}]"+
                    "})"+'<\/script>';
                    }else{
                        html+='<img src="http://static.ebanhui.com/ebh/images/pie.jpg"/>';
                    }
                    html+= '<p class="option-1">';
                    $.each(v,function(h,j){
                        var arr = ['','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                        html+= '<span><b>'+arr[j['qid']]+'.</b><i>'+j['content']+'（选择人数：'+j['choosecount']+'人）</i></span>';
                    })
                    html+='</p></li>';
                    }
                    if(v[0]['type'] == 2 || v[0]['type'] == 3){//主观题或文字题
                        html+='<li>'+
                            '<h4 class="realstatisticstitle"><span>Q'+v[0]['order']+'</span>';
                            if(v[0]['type'] == 2){
                                html+='（主观题）';
                            }else{
                                html+='（文字题）';
                            }
                            html+=v[0]['title']+'</h4>'+
                            '<p class="sumbmitnumber">上交人数：'+v[0]['count']+'/';
                            if(res.totalcount == 0){
                                html+=v[0]['count'];
                            }else{
                                html+= res.totalcount;
                            }
                            html+='</p>'+
                            '<p class="sexqueue1-1">'+
                            '<!--判断一下当进度当进度大于等于7%小于等于96%时为b添加class="jdtico"-->'+
                                '<span class="sexqueuefull1-1" style="width:';
                                if(res.totalcount == 0){
                                    if(v[0]['count'] == 0){
                                        html+='0';
                                    }else{
                                        html+='100';
                                    }
                                }else{
                                    html+=Math.ceil(v[0]['count']/res.totalcount*100);
                                }
                                html+='%;">';
                                if(Math.ceil(v[0]['count']/res.totalcount*100) >= 7 && Math.ceil(v[0]['count']/res.totalcount*100) <=96){
                                    html+='<b class="jdtico"></b>';
                                }
                                html+='</span>'+
                            '</p>'+
                            '<span class="percentage-1">';
                            if(res.totalcount == 0){
                                    if(v[0]['count'] == 0){
                                        html+='0';
                                    }else{
                                        html+='100';
                                    }
                                }else{
                                    html+=Math.ceil(v[0]['count']/res.totalcount*100);
                                }
                            html+='%</span>'+
                            '<a href="/troomv2/iacourse/detail/'+v[0]['icqid']+'.html?type='+v[0]['type']+'" target="_blank" class="seebtn">点击查看详情</a>'+
                        '</li>';
                    }
                });
                $(".analyze").html(html);
            }
        }
    });
    }
    if(type == 'have'){
        $.ajax({
        type:'post',
        url:uri,
        dataType:'json',
        data:{icid:icid, type:type,answertime:answertime},
        success:function(data){
            if(data.status == 1){
                answertime = data.timecache;
                var html = '';
                $.each(data.list,function(i,v){
                    html+= '<li style="float:left;width:196px;"><a class="husrty" href="/troomv2/iacourse/student/show/'+v['uid']+'.html?icid='+icid+'" target="_blank"><img class="imgisre" src="'+v['face']+'"><p class="ghhnur" title="'+v['realname']+'">'+v['realnameshort']+'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/';
                    if(v['sex'] == 0){
                           html+='man'; 
                        }else{
                            html+='women';
                        }
                    html+='.png"></p><p class="ghjuters" title="'+v['username']+'">'+v['usernameshort']+'</p><p class="ghjuters">'+v['totaltime']+'分钟</p></a></li>';
                });
                $(".have #page").html(data.pagestr);
                $(".jisrner").html(html);
                var script = '<script>$(".listPage a").on("click",function(){var url = $(this).attr("data");havechangepage(url)})<\/script>';
                $(".have #script").html(script);
            }else{
                if(data.status == 0){
                    var html = '<div class="nodata"></div>';
                    $(".have .jisrner").html(html); 
                }
            }       
        }
    });
    }
    if(type == 'nohave'){
        $.ajax({
        type:'post',
        url:uri,
        dataType:'json',
        data:{icid:icid, type:type,answertime:answertime},
        success:function(data){
            if(data.status == 1){
                answertime = data.timecache;
                var html = '<ul class="datatab-1">';
                $.each(data.list,function(i,v){
                    html+='<li><a href="javascript:;"><img class="imgyuan imgyuan-1" src="'+v['face']+'"></a><p class="ghjut ghjut-2" title="'+v['realname']+'">'+v['realnameshort']+'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/';
                    if(v['sex'] == 0){
                        html+='man';
                    }else{
                        html+='women';
                    }
                    html+='.png"></p><p class="ghjut ghjut-1 ghjut-2" title="'+v['username']+'">'+v['usernameshort']+'</p></li>';
                    $(".nohave #page").html(data.pagestr);
                    $(".nohave .nostudentlist").html(html);
                    var script = '<script>$(".listPage a").on("click",function(){var url = $(this).attr("data");nohavechangepage(url)})<\/script>';
                    $(".nohave #script").html(script);
                })
            }else{
                if(data.status == -1){

                }else{
                   var html = '<div class="nodata"></div>';
                    $(".nohave .nostudentlist").html(html); 
                }
            } 
        }
    });
    }
}
$('.havestudent').on('click',function(){
    type = 'have';
    $(".curr").removeClass('curr');
    $(this).addClass('curr');
    answertime = 0;
    uri = '/troomv2/iacourse/detail.html';
    chooseTag();
});
$('.havenostudent').on('click',function(){
    $(".curr").removeClass('curr');
    $(this).addClass('curr');
    type = 'nohave';
    uri = '/troomv2/iacourse/detail.html';
    answertime = 0;
    chooseTag();
})
$('.timeans').on('click',function(){
    $(".curr").removeClass('curr');
    $(this).addClass('curr');
    type = 'analyze';
    uri = '/troomv2/iacourse/detail.html';
    answertime = 0;
    chooseTag();
});

function havechangepage(url){
    if(url != '' && url != undefined){
        uri = url;
        answertime = 0;
      chooseTag();  
    }
}
function nohavechangepage(url){
    if(url != '' && url != undefined){
        uri = url;
        answertime = 0;
      chooseTag();  
    }
}
chooseTag();
setInterval('chooseTag()',5000);
</script>
</body>
</html>
