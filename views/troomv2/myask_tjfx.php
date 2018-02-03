<?php $this->display('troomv2/page_header'); ?>
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
            width: 950px;
        }
        .category_cont1 div a.curr, .category_cont1 div a:hover, .price_cont div a:hover, .price_cont div a.curr {
            background: none repeat scroll 0 0 #5e96f5;
            color: #FFFFFF;
            text-decoration: none;
            border-radius:2px;
            padding:2px !important;
            font-size:13px;
        }
        .category_cont1 div a {
            color: #2C71AE;
            text-decoration: none;
            padding: 2px;
            cursor: pointer;
        }
        .category_cont1 div {
            float: left;
            height: 25px;
            line-height: 22px;
            overflow: hidden;
            padding:0 10px;
        }
        .key_word {
            padding: 6px 20px;
            border-bottom-width: 1px;
            border-bottom-style: solid;
            height:28px;
            border-bottom-color: #cdcdcd;
        }
        .key_word dt {
            float: left;
            line-height: 22px;
            padding-right: 5px;
            text-align: left;
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
        .workdata{
            width:1000px;
        }
        .sexqueue0{
            background: url(http://static.ebanhui.com/ebh/tpl/2014/images/sexqueuefull0.jpg) no-repeat;
            display: inline-block;
            height: 51px;
            position: relative;
            width: 355px;
            bottom: 2px;
            float:left;
        }
        .sexqueuefull0{
            background: url(http://static.ebanhui.com/ebh/tpl/2014/images/sexqueue0.jpg) no-repeat;
            display: block;
            height: 51px;
            float: left;
        }
		.workcurrent a {
			border-bottom: 2px solid #ff9500;
		}
    </style>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
    <script language="JavaScript" src="http://static.ebanhui.com/ebh/js/AnalysisCharts/JSClass/FusionCharts.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
    <div class="lefrig" style="padding-bottom:120px;">
        <div class="waitite">
			<div class="work_menu" style="position:relative;margin-top:0">
				<ul>
					<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
				</ul>
			</div>
            <a href="<?= geturl('troomv2/myask/addquestion') ?>" class="jaddre">提个问题</a>
            <div class="diles">
                <?php
                $q= empty($q)?'':$q;
                if(!empty($q)){
                    $stylestr = 'style="color:#000"';
                }else{
                    $stylestr = "";
                }
                ?>
                <input name="title" class="newsou" <?=$stylestr?> id="title" name="uname" value="<?= $q?>"  type="text" />
                <input id="ser" type="button" class="soulico" value="">
            </div>
        </div>
        <div class="workol">
            <div class="work_mes work_mesalone">
                <ul class="extendul">
                    <li><a href="<?= geturl('troomv2/myask/askme') ?>"><span>提给我的</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask') ?>"><span>课程问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/classquestion') ?>"><span>班级问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/allquestion') ?>"><span>全部问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/myquestion') ?>"><span>我的问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/myanswer') ?>"><span>我的回答</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/myfavorit') ?>"><span>我的关注</span></a></li>
                    <!-- 新增 -->
                    <li><a href="<?= geturl('troomv2/myask/settled') ?>"><span>已解决</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/hot') ?>"><span>热门</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/recommend') ?>"><span>推荐</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/wait') ?>"><span>等待回复</span></a></li>
                    <li class="workcurrent"><a href="/troomv2/myask/tjfx.html"><span style="color:#ff9500;">统计分析</span></a></li>
                </ul>
            </div>
            <div class="lishnrt">
                <a class="hietse xhusre" href="/troomv2/myask/tjfx.html">统计分析</a>
                <a class="hietse " href="/troomv2/myask/rank.html">排行榜</a>
            </div>
            <div class="clear"></div>
            <div class="qzsjlb">
                <div class="qztimes">
                    <div class="qztimeson">
                        <input name="" id="dayfrom" style="cursor:pointer" class="qisties" type="text" readonly="readonly" value="<?=Date('Y-m-d', empty($starttime)?$dateline:$starttime)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'<?=Date('Y-m-d',$dateline)?>',maxDate:'#F{$dp.$D(\'dayto\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400*1)?>\'}'});"/>
                        <div class="dsjjt"></div>
                    </div>
                    <span class="fl sjzjf">—</span>
                    <div class="qztimeson">
<!--                        <input class="qisties" type="text" id="endtime" name="endtime" value="截止时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />-->
                        <input name="" id="dayto" style="cursor:pointer" class="qisties" type="text" readonly="readonly" value="<?=Date('Y-m-d',empty($endtime)?SYSTIME:$endtime)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dayfrom\',{d:1})||\'<?=Date('Y-m-d',$dateline+86400)?>\'}',maxDate:'<?=Date('Y-m-d',SYSTIME)?>'});"/>
                        <div class="dsjjt"></div>
                    </div>
<!--                    <input type="text" id="wx_start" name="startDate" class="qisties" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="--><?//= date('Y-m-d',$starttime) ?><!--" />-->
<!--                    <span style="margin-left:5px;" class="sjzjf">—</span>-->
<!--                    <input type="text" id="wx_end" name="endDate" class="qisties" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="--><?//= date('Y-m-d',$endtime) ?><!--" />-->
                </div>
                <div class="clear"></div>
<!--                --><?php //if(!empty($info)){?>
                <div class="zhqks mt35">
                    <div class="nnbl">综合情况</div>
                    <div style="text-align:center;" id="container2"></div>
                </div>
                <div class="zhqks mt45">
                    <div class="nnbl">活跃度</div>
<!--                    <div style="text-align:center;">--><?php //$chart->chart($active,'Bar2D','d2',900,300,'','100')?><!--</div>-->
                    <div id="container" style="width:900px;height:300px;"></div>
                </div>
                <div class="zhqks mt45">
                    <div class="nnbl">男女比例数</div>
                    <div class="nnb2">男生</div>
                    <div class="nnb3">女生</div>
                    <div style="width:928px; margin:50px 0; position:relative;">
                        <div class="zsline"><span><?php echo 100-$ratio?>%</span></div>
                        <div class="zsline1"><span><?php echo $ratio?>%</span></div>
                        <p style="margin-left:110px;margin-right:10px;" class="sexqueue0"><span style="width:<?php echo $ratio?>%;" class="sexqueuefull0"></span></p>
                        <p class="sexqueue1"><span style="width:<?php echo $ratio?>%;" class="sexqueuefull1"></span></p>
                    </div>
                </div>
<!--                --><?php //}else{?>
<!--                    没有数据-->
<!--                --><?php //}?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#container2').highcharts({
                plotOptions: {
                    bar: {
                        dataLabels: {
//                            enabled: true
//                            formatter: function() {        //格式化输出显示
//                                return (this) + '%';
//                            }
                        }
                    }
                },
//                dataLabels:{
//                    enabled:true
//                },
                chart: {
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                credits: {
                    text: ''
                },
                series: [{//设置每小个饼图的颜色、名称、百分比
                    type: 'pie',
                    name: null,
                    <?php if($noquestion==1){?>
                    data: [
                        {name:'没有问题',y:1}
                    ]
                    <?php }else{?>
                    data: [
                        {name:'普通解答:<?php echo $aqcount_h?>%',y:<?php echo $aqcount?>},
                        {name:'最佳答案:<?php echo $bestqcount_h?>%',y:<?php echo $bestqcount?>},
                        {name:'没有回答:<?php echo $noanqcount_h?>%',y:<?php echo $noanqcount?>},
                    ]
                    <?php }?>
                }]
            })
            $('#container').highcharts({
                plotOptions: {
                    bar: {
                        dataLabels: {
//                            enabled: true
//                            formatter: function() {        //格式化输出显示
//                                return (this) + '%';
//                            }
                        }
                    }
                },
                dataLabels:{
                    enabled:true
                },
                credits: {
                    text: ''
                },
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['提问','回答']
                },
                tooltip: {
                    valueSuffix: '%'//标示框后缀加上%
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    tickPositions: [0,10, 20,30, 40,50,60,70,80,90,100],
                    labels: {//y轴刻度文字标签
                        formatter: function () {
                            return this.value + '%';//y轴加上%
                        }
                    }
//                    categories: ['10','20','30','40','50','60','70','80','90','100']
                },
                series: [{
                    name: '活跃度',
                    data: [<?php echo $str?>]
                }]
            });
        });
        var searchtext = "请输入关键字";
        $(function() {
            initsearch("title",searchtext);
            $("#ser").click(function(){
                var title = $("#title").val();
                var folderid = $("a.curr").attr('tag');
                if(title == searchtext)
                    title = "";
                var url = '<?= geturl('troomv2/myask') ?>' + '?folderid='+folderid+'&q='+title;
                document.location.href = url;
            });
        });

        function _search(folderid){
            var title = $("#title").val();
            if(title == searchtext)
                title = "";
            var url = '<?= geturl('troomv2/myask') ?>' + '?folderid='+folderid+'&q='+title;
            document.location.href = url;
        }
        $(function(){
            $('.datatab tr:last td').css('border-bottom','none');
        });
//        $('.test').click(function(){
//            var starttime = $('#starttime').val();
//            var endtime = $('#endtime').val();
////            if($('#starttime').val()==''||$('#endtime').val()==''||$('#starttime').val()=='起始时间'||$('#endtime').val()=='截止时间'||$('#starttime').val()>$('#endtime').val()){
////                return false;
////            }
//            location.href='/troomv2/myask/tjfx.html?starttime='+starttime+'&endtime='+endtime;
//        })
        function getcreditstat(dp){
            if(dp){
                if(dp.srcEl.id=='dayfrom'){
                    dayfromobj = dp.cal.newdate;
                    var starttime = dayfromobj.y+'-'+dayfromobj.M+'-'+dayfromobj.d;
                    var endtime = $('#dayto').val();
                    if(!endtime)
                        return;
                }else{
                    daytoobj = dp.cal.newdate;
                    var starttime = $('#dayfrom').val();
                    var endtime = daytoobj.y+'-'+daytoobj.M+'-'+daytoobj.d;
                    if(!starttime)
                        return;
                }
            }else{
                var starttime = $('#dayfrom').val();
                var endtime = $('#dayto').val();
            }
            location.href='/troomv2/myask/tjfx.html?starttime='+starttime+'&endtime='+endtime;
        }
    </script>
<?php
$this->display('troomv2/page_footer');
?>