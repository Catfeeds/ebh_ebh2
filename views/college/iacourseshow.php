<?php $this->display('troomv2/room_header'); ?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css" />
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/survey.css?v=2016120901" rel="stylesheet" />

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

.relatediv{
    margin-left:10px;
    margin-top:10px;
    font-size:14px;
    color:#999
}
.op_content .op4{
    cursor:pointer;
}
.red {
    display: none;
    color: red;
    font-size: 14px;
    padding-bottom: 5px;
}
.fontfen .tijibtn{
    background:#5e96f5;
}
.fontfen .tijibtn:hover{
    background:#4e8bf1;
}
a.dasrbtn {
    background: #5386f9 none repeat scroll 0 0;
    border-radius: 3px;
    color: #fff;
    display: block;
    font-size: 14px;
    height: 26px;
    line-height: 26px;
    text-align: center;
    width: 70px;
    float:left;
    text-decoration:none;
    margin:103px 0 0 20px;
}
</style>
<script type="text/javascript">
$(function() {
    try{
    $('.box a').lightBox();
    }catch(error){}
});
</script>
<body>
<div class="lefrig">
    <div style="display:inline-block;">
    	<div class="tkfktitle"><?php echo shortstr(strip_tags($ics['title']),50);?></div>
        <div class="classboxmore">
            <div class="yixuexifa">
                <p class="sexqueue0" style="margin-left:130px;margin-right:15px;">
                    <span class="sexqueuefull0" ></span>
                </p>
                <div style="float:left; display:inline;">
                    <p class="yixuexi reks"></p>
                    <p class="yjxxbfb persent"></p>
                </div>
                <div class="pjxxsc">
                    <p class="yixuexi">平均学习时长</p>
                    <p class="yjxxbfb min">
                   
                    <span style="font-size:14px;">分钟</span></p>
                </div>
            </div>
        </div>
        <div class="realstatisticsfa">
        	<div class="navigation">
                <ul>
                    <li><a href="javascript:void(0)" class="curr exercise">答题详情</a></li>
                    <li><a href="javascript:void(0)" class="timeans">实时统计</a></li>
                </ul>
            </div>
            <div class="realstatistics analyze" type="analyze" style="display:none">
            </div>
            <div class="havestudents have" type="have">
                <table class="datatab-1" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        
                    </tbody>
                </table>
                <div id="page"></div>
                <div id="script"></div>
            </div>
            <div class="havestudents nohave" type="nohave">
                <div class="nostudentlist"></div>
                <div id="page"></div>
                <div id="script"></div>
            </div>
            <div class="exercises" >
                <div id="survey_content" style="padding-left:60px;">
                    <?php if (!empty($questions)) {
                        foreach ($questions as $key => $question){?>
                        <div class="topic_type" qid="<?=$question['icqid']?>">
                            <div class="topic_type_menu">
                                <div class="setup-group">
                                    <h4>Q<?=$key+1?></h4>
                                </div>
                            </div>
                            <div class="topic_type_con">
                                <div class="topic_question">
                                    <div class="th4 q_title" id="survey_question_<?=$question['icqid']?>"><?=$question['title']?></div>
                                </div>
                                <div class="red" id="tip_<?=$question['icqid']?>">请选择选项</div>
                                <ul class="unstyled">
                                <?php if($question['type'] != 3){ ?>
                                    <?php if($question['type'] == 2 && empty($question['options']) && isset($answers[$question['icqid']])){
                                        $arr = $answers[$question['icqid']];
                                        $question['options'][0] = $arr;
                                    } ?>
                                    <?php foreach ($question['options'] as $option){?>
                                        <?php 
                                            if($question['type'] == 0 || $question['type'] == 1){
                                                if(isset($answers[$question['icqid']])){
                                                    $chosen = json_decode($answers[$question['icqid']]['answercontent']);
                                                }
                                            } 
                                        ?>
                                        <li>
                                            <?php if($question['type'] == 0){?>
                                                <!-- 单选题 -->
                                                <input type="radio" name="answer_<?=$question['icqid']?>[]" id="survey_option_<?=$option['itemid']?>" value="<?=$option['itemid']?>" <?php if(isset($chosen) && $chosen && in_array($option['itemid'], $chosen)) echo 'checked'; ?>  disabled/>
                                            <?php }elseif($question['type'] == 1){?>
                                                <!-- 多选题 -->
                                                <input type="checkbox" name="answer_<?=$question['icqid']?>[]" id="survey_option_<?=$option['itemid']?>" value="<?=$option['itemid']?>" <?php if(isset($chosen) && $chosen && in_array($option['itemid'], $chosen)) echo 'checked'; ?>  disabled />
                                            <?php }elseif($question['type'] == 2){?>
                                                <!-- 主观题 -->
                                            <?php }elseif($question['type'] == 3){?>
                                                <!-- 文字题 -->
                                            <?php }?>
                                            <div class="op_content" style="overflow:hidden;">
                                                <?php if($question['type'] == 1 || $question['type'] == 0){ ?>
                                                <label for="survey_option_<?=isset($option['itemid'])? $option['itemid']: '';?>" class="op4 q_option"  <?php if(isset($chosen) && $chosen && in_array($option['itemid'], $chosen)) echo 'style="color:#3366CC"'; ?> ><?=$option['content']?></label>
                                                <?php }else{ ?>
                                                <label for="survey_option_<?= isset($option['itemid']) ? $option['itemid']: '';?>" class="op4 q_option"><?= isset($option['content']) ? $option['content'] :'';?></label>
                                                <?php } ?>
                                                <?php if($question['type'] == 2){ ?>
                                                    <div>
                                                        <?php if(isset($option['urlpath'])){?>
                                                        <div class="box">
                                                            <a href="<?= isset($option['urlpath']) ? $option['urlpath']:'' ?>"><img src="<?= $option['urlpath'] ?>" width="200" height="200" style="float:left"></a>
                                                        </div>
                                                        <?php }?>
                                                        <input type="hidden" name="answer_<?=$question['icqid']?>" value="">
                                                        <?php if(!empty($answers[$question['icqid']]['answercontent'])){?>
                                                        <div class="box">
                                                            <a href="<?=$answers[$question['icqid']]['answercontent'] ?>"><img src="<?= $answers[$question['icqid']]['answercontent'] ?>" width="200" height="200" style="float:left;margin-left:20px"></a>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php }elseif($question['type'] == 3){ ?>
                                                    <div>
                                                        <input type="hidden" name="answer_<?=$question['icqid']?>" value="">
                                                        <textarea onkeyup="show(this)" rows="6" cols="80" placeholder="请输入答案..." disabled><?= $answers[$question['icqid']]['answercontent'] ?></textarea>
                                                    </div>
                                                    
                                                <?php } ?>
                                            </div>
                                        </li>
                                    <?php }?>
                                <?php }else{ ?>
                                    <div>
                                        <input type="hidden" name="answer_<?=$question['icqid']?>" value="">
                                        <textarea onkeyup="show(this)" rows="6" cols="80" placeholder="请输入答案..." disabled><?= isset($answers[$question['icqid']]) ? $answers[$question['icqid']]['answercontent'] :''?></textarea>
                                    </div>
                                <?php }?>
                                </ul>
                            </div>
                        </div>
                    <?php } }?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="test"></div>
<script type="text/javascript">
var type = 'analyze';//默认显示分析页面
var icid = <?php echo $ics['icid'];?>;
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
                        html+='<div style="width:550px;height:350px; float:left;" id="q'+v[0]['icqid']+'"></div>'+
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
                $(".analyze").html(html).hide();
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
                var html = '<tr><th width="27%" class="padleft">个人信息</th><th width="28%">提交时间</th><th width="25%">答题时间</th><th width="20%">操作</th></tr>';
                $.each(data.list,function(i,v){
                    html+='<tr><td ><a title="" href="javascript:;"><img class="imgyuan" src="'+v['face']+'"></a><p class="ghjut">'+v['realname']+'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/';
                        if(v['sex'] == 0){
                           html+='man'; 
                        }else{
                            html+='women';
                        }
                        html+='.png"></p><p class="ghjut ghjut-1">'+v['username']+'</p></td><td>'+v['dateline']+'</td><td>'+v['totaltime']+'分钟</td><td><a class="waskes-1" href="/troomv2/iacourse/student/show/'+v['uid']+'.html?icid='+icid+'" target="_blank">查看</a></td></tr>';
                });
                $(".have #page").html(data.pagestr);
                $(".datatab-1 tbody").html(html);
                var script = '<script>$(".listPage a").on("click",function(){var url = $(this).attr("data");havechangepage(url)})<\/script>';
                $(".have #script").html(script);
            }else{
                if(data.status == 0){
                    var html = '<div class="nodata"></div>';
                    $(".have tbody").html(html); 
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
                    html+='<li><a href="javascript:;"><img class="imgyuan imgyuan-1" src="'+v['face']+'"></a><p class="ghjut ghjut-2">'+v['realname']+'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/';
                    if(v['sex'] == 0){
                        html+='man';
                    }else{
                        html+='women';
                    }
                    html+='.png"></p><p class="ghjut ghjut-1 ghjut-2">'+v['username']+'</p></li>';
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
    uri = '/college/iacourse/detail.html';
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
     $(".realstatistics").show();
     $(".exercises").hide();
     chooseTag();
    // type = 'analyze';
    // uri = '/troomv2/iacourse/detail.html';
    // answertime = 0;
    // chooseTag();
});
$('.exercise').on('click',function(){
    $(".realstatistics").hide();
    $(".curr").removeClass('curr');
    $(this).addClass('curr');
    $(".exercises").show();
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
// setInterval('chooseTag()',5000);
</script>
</body>
</html>
