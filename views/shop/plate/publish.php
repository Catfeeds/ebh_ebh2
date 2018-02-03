<!--修改网校发布内容为暂无内容-->
<?php if(true){ ?>
	<div class="nodata""></div>
<?php }else{ ?>
<?php
/**
 * 网校发布
 * Created by PhpStorm.
 * User: app
 * Date: 2016/11/7
 * Time: 10:04
 */
//print_r(get_defined_vars());exit;
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css?v=2016041801" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css?v=2016040501" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2016040501"/>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<style>
body {
	background-color:#8493af;
}
.wrap_footer {
	margin-top:0px;
}
    .kehtty {
        width: auto;
        margin: 0;
        margin-left: 185px;
    }
    a.etfhse:visited {
        color: #3385ff;
    }
    .descount{
        line-height:23px
    }
    span.kheter{background:none;padding-left:0;}
	
a:visited {
	color:#808080; 
	text-decoration:none;
}
a:hover { 
	color:##338bff; 
	text-decoration:none;
}
<?php if (!empty($varpool['roominfo']['isdesign'])) { ?>
.denser{margin:0 !important;}
.loginbox.username.module{padding:0;}
#username,#password {
    background:none;
    width: 100%;
    height: 100%;
    border: 0;
    font-size: inherit;
    color: inherit;
    padding-left: 0;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
}
<?php } ?>
</style>
<div class="krtgde group" style="margin-top:10px;width:1200px;background-color:#fff;">
    <div class="kfanstg group" style="padding-bottom:20px;margin:0 auto;float:none;">
        <h2 class="ketrds">Hi, 大家好，我是“<?=$varpool['roominfo']['crname']?>”，非常幸运的在<?=$varpool['agestr']?>前诞生并与您相遇</h2>
        <div class="rtuhst">
            <span class="jetbst"></span>
        </div>
        <div class="kujets">
            <img class="kehttu" src="http://static.ebanhui.com/ebh/tpl/2016/images/sithst.jpg" />
        </div>
        <?php $eventcount = 0;
        foreach($varpool['timearr'] as $date=>$event){$eventcount++;?>
            <div class="kujets">
                <span class="krehte"><?=date('Y-m-d',$date)?></span>
                <span class="khettu"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/iterfate.jpg" /></span>
                <span class="khsttu"><?=$event?></span>
            </div>
        <?php }?>

        <div class="kujets" style="">
            <span class="krehte">如今</span>
            <span class="khettu"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/iterfate1.jpg" /></span>
            <span class="khsttu descount" style="padding-top:18px">我已经拥有了<span class="hoastr"><?=$varpool['teachercount']?></span>名优秀的讲师</span>
            <?php if(!empty($varpool['iacount'])){?>
                <span class="khsttu descount"><span class="hoastr"><?=$varpool['iacount']?></span>次轻松愉快地师生互动</span>
            <?php }?>
            <?php if(!empty($varpool['roominfo']['coursenum'])){?>
                <span class="khsttu descount"><span class="hoastr"><?=$varpool['roominfo']['coursenum']?></span>节精挑细选的优秀课程</span>
            <?php }?>
        </div>

        <div class="kujets">
            <span class="krehte">未来</span>
            <span class="khettu"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/iterfate.jpg" /></span>
            <span class="khsttu">更多精彩，只等你来开启，让我们一起分享被载入历史榜的喜悦吧</span>
        </div>

        <div class="kujets">
            <img class="kehttu1" src="http://static.ebanhui.com/ebh/tpl/2016/images/letrtyt.jpg" />

        </div>



        <?php if(!empty($varpool['coursetoplist'])){?>
            <div class="rtuhst">
                <span class="jetbst"></span>
            </div>
            <h2 class="ketrds">我发现同学们最喜欢的课是：<span class="setelan">“<?=$varpool['coursetopstr']?>”</span></h2>
            <div class="kreyde" style="width: 625px;">
                <ul>
                    <?php foreach($varpool['coursetoplist'] as $k=>$course){
                        $img = show_plate_course_cover($course['img']);
                        $img = !empty($img) ? show_thumb($img, '147_86') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg'; ?>
                        <li class="khrued" style="width:147px;;height:86px">
                            <a <?=$varpool['roominfo']['isschool']==7?'href="/platform.html" target="_blank"':'href="javascript:void(0)"'?> title="<?=$course['foldername']?>"><img style="width:147px;height:86px" src="<?=$img?>" /></a>
                        </li>
                    <?php }?>
                    <?php if(!empty($varpool['coursebottom'])){
                        $img = show_plate_course_cover($varpool['coursebottom']['img']);
                        $img = !empty($img) ? show_thumb($img, '147_86') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_147_86.jpg'; ?>
                        <li class="khrued" style="width:147px;;height:86px">
                            <a <?=$varpool['roominfo']['isschool']==7?'href="/platform.html" target="_blank"':'href="javascript:void(0)"'?> title="<?=$varpool['coursebottom']['foldername']?>"><img style="width:147px;height:86px" src="<?=$img?>" /></a>
                        </li>
                        <li class="khsdtry" style="margin-top: 30px;">
                            <p class="masrbot">而 “<span class="setelan"><?=$varpool['coursebottom']['foldername']?></span>” 好像受到了冷落了</p>
                            <p><span class="setelan"><?=$varpool['coursebottom']['foldername']?>老师说：</span></p>
                            <p>欢迎同学们多提意见和建议，我会努力改进的。</p>
                        </li>
                    <?php }?>
                </ul>
            </div>
        <?php }?>

        <?php if (!empty($varpool['creditloglist'])) { ?>
            <div class="rtuhst">
                <span class="jetbst"></span>
            </div>
            <div class="waists">
                <div class="lefkst">
                    <div class="kettuda">
                        <img class="kehtty" src="http://static.ebanhui.com/ebh/tpl/2016/images/sithst.jpg" /><span class="lehts">通过学习，他们在不断的成长......</span>
                    </div>
                    <?php foreach($varpool['creditloglist'] as $k=>$cl){
                        $sex = empty($cl['sex']) ? 'man' : 'woman';
                        $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
                        $face = empty($cl['face']) ? $defaulturl : $cl['face'];
                        $facethumb = getthumb($face,'40_40');

                        $description = str_replace('[w]','<span class="denassr" title="'.$cl['detail'].'">'.shortstr($cl['detail'],18).'</span>',$cl['description']);
                        $name = $cl['realname']?$cl['realname']:$cl['username'];
                        ?>
                        <div class="kettuda">
                            <span class="kheter"><?=Date('Y-m-d',$cl['dateline'])?></span>
                            <span class="etrtyds">
                    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/tudyut<?=$k==count($varpool['creditloglist'])-1?'2':'1'?>.jpg" />
                    </span>
                            <span class="khetwe">
                    	<img class="wtetesd" src="<?=$facethumb?>" title="<?=$name?>"/><span title="<?=$name?>"><?=shortstr($name,8)?></span><?=$description.' '.'<span class="denassr">'.$cl['credit'].'</span>'.' 积分'?>
                    </span>
                        </div>
                    <?php }?>
                </div>
                <div class="rigskt">
                    <div class="kettuda">
                        <img class="rhrewrs" src="http://static.ebanhui.com/ebh/tpl/2016/images/tstuirer.jpg" /><span class="lehts">学霸养成记，下一个会是你么？</span>
                    </div>
                    <?php $k=-1;
                    if(!empty($varpool['creditlist'])){

                        $clconfig = Ebh::app()->getConfig()->load('creditlevel');
                        foreach($varpool['creditlist'] as $k=>$credit){
                            $sex = empty($credit['sex']) ? 'man' : 'woman';
                            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.$sex.'.jpg';
                            $face = empty($credit['face']) ? $defaulturl : $credit['face'];
                            $facethumb = getthumb($face,'40_40');

                            $cltitle = '';
                            foreach($clconfig as $clevel){
                                if($credit['credit']>=$clevel['min'] && $credit['credit']<=$clevel['max']){
                                    $cltitle = $clevel['title'];
                                    break;
                                }
                            }
                            $name = $credit['realname']?$credit['realname']:$credit['username'];
                            ?>
                            <div class="kettuda">
                                <span class="tekder">No.<?=$k+1?></span>
                                <span class="netrse">
                    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/yuped<?=$k==count($varpool['creditlist'])-1?'2':'1'?>.jpg" />
                    </span>
                                <span class="knrtde">
                    	<img class="wtetesd" src="<?=$facethumb?>" /><span title="<?=$name?>"><?=shortstr($name,20,'')?></span><p class="huisr"><?=$cltitle?></p>
                    </span>
                            </div>
                        <?php }
                    }?>
                    <!--
				<div class="kettuda">
                	<span class="tekder">No.<?=$k+2?></span>
                    <span class="netrse">
                    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/yuped2.jpg" />
                    </span>
                    <span class="knrtde">
                    	<img class="wtetesd" src="http://static.ebanhui.com/ebh/tpl/2014/images/touxiangn.png" />我是谁？
                    </span>
                </div>
				-->
                </div>
            </div>
            <div class="rtuhst">
                <span class="jetbst"></span>
            </div>
        <?php } ?>


        <?php $fp = empty($varpool['femalepercent']['femalepercent'])?0:$varpool['femalepercent']['femalepercent'];
        $pstr = '你为你的阵营贡献了多少力量呢？';

        ?>
        <h2 class="ketrds"><?=$pstr?></h2>
        <div class="kthrtb" style="margin-left:0">
            <div>
                <div class="nnbl">男女比例数</div>
                <div class="nnb2">男生</div>
                <div class="nnb3">女生</div>
                <div style="width:928px; margin-top:50px; position:relative;">
                    <div class="zsline"><span><?=$varpool['sexpercent'][0]?>%</span></div>
                    <div class="zsline1"><span><?=$varpool['sexpercent'][1]?>%</span></div>
                    <?php
                    $moresex = ($varpool['sexpercent'][0]>$varpool['sexpercent'][1])?0:1;
                    $varpool['sexpercent'][$moresex] = round($varpool['sexpercent'][$moresex],-1);
                    $varpool['sexpercent'][!$moresex] = 100 - $varpool['sexpercent'][$moresex];

                    ?>
                    <p class="sexqueue0" style="margin-left:110px;margin-right:10px;">
                        <span class="sexqueuefull0" style="width:<?=$varpool['sexpercent'][0]?>%;"></span>
                    </p>
                    <p class="sexqueue1">
                        <span class="sexqueuefull1" style="width:<?=$varpool['sexpercent'][1]?>%;"></span>
                    </p>

                </div>
            </div>
            <div style="clear:both;"></div>
            <div style="margin-top:50px;">
                <div class="nnbl">学业勤奋度</div>
                <div class="nnb2">男生</div>
                <div class="nnb3">女生</div>
                <div style="width:928px; margin-top:50px; position:relative;">
                    <div class="zsline"><span><?=$varpool['loginpercent'][0]?>%</span></div>
                    <div class="zsline1"><span><?=$varpool['loginpercent'][1]?>%</span></div>
                    <?php
                    $moresex = ($varpool['loginpercent'][0]>$varpool['loginpercent'][1])?0:1;
                    $varpool['loginpercent'][$moresex] = round($varpool['loginpercent'][$moresex],-1);
                    $varpool['loginpercent'][!$moresex] = 100 - $varpool['loginpercent'][$moresex];
                    ?>
                    <p class="sexqueue2" style="margin-left:105px;margin-right:20px;">
                        <span class="sexqueuefull2" style="width:<?=$varpool['loginpercent'][0]?>%;"></span>
                    </p>
                    <p class="sexqueue3">
                        <span class="sexqueuefull3" style="width:<?=$varpool['loginpercent'][1]?>%;"></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="rtuhst">
            <span class="jetbst"></span>
        </div>

        <h2 class="ketrds">看看他们的学习时段，学霸是怎样炼成的</h2>
        <div class="dtreqws">
            <div id="linecontainer" class="chartcontainer" style="">
            </div>
        </div>
        <div class="times">（时间<span style="font-size:14px">/h</span>）</div>
        <div class="baifenbi">（百分比<span style="font-size:14px">/%</span>）</div>
        <div class="rtuhst">
            <span class="jetbst"></span>
        </div>
        <h2 class="ketrds">我在不断成长，只为用自己的努力，见证你最美好的未来。</h2>

        <a href="/" class="etfhse">更多精彩，等你来开启</a>
    </div>
</div>
<script>
    var colorarr = new Array('#3385ff','#b70001');
    $('#piecontainer').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: null
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                },
                colors:colorarr
            }
        },
        series: [{
            name: '百分比',
            colorByPoint: true,
            data: [{
                name: '男学生',
                y: <?=100-$fp?>
            }, {
                name: '女学生',
                y: <?=$fp?>,
                sliced: true,
                selected: true
            }]
        }],
        credits:{
            enabled:false
        }
    });



    $('#linecontainer').highcharts({
        xAxis: {
            categories: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11' , '12' , '13' , '14' , '15' , '16' , '17' , '18' , '19' , '20' , '21' , '22' , '23' ]
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name:'百分比',
            data: [<?=$varpool['hourcountstr']?>]
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
                var hourfrom = this.x;
                hourto = this.x==23?0:parseInt(this.x)+1;

                return hourfrom+'时-'+hourto+'时<br/>百分比: <b>'+this.y+'%</b>';
            }
            // pointFormat:'{series.name}: <b>{point.y}</b><br/>',
            // valueSuffix:'%',
            // headerFormat:'{point.key}时-{point.key}+1时'
        }
    });


</script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>
<?php }?>