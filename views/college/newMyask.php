<?php $this->display('college/page_header'); ?>
	
<?php
$roominfo = Ebh::app()->room->getcurroom();
$roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
if(!empty($roominfo['crid'])){
    $other_config = Ebh::app()->getConfig()->load('othersetting');
    $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
    $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
    $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
    $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
}
?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/echarts.min.js"></script>

<style type="text/css">
    .voice-player{
        margin-top:0px ;
        margin-left:0px;
    }
</style>
<script type="text/javascript">
    var searchtext = "请输入关键字";
    $(document).ready(function(){
        $('.listPage').css('display','none');
        $("#title").css('color','#999');
    })
    <?php
    if(!empty($q)){

    ?>
    var text = '<?=$q?>';

    $(document).ready(function(){
        $("#title").val(text);
    })
    <?php
    }else{
    ?>
    $(document).ready(function(){
        $("#title").val(searchtext);
    })
    $(document).ready(function(){
        $("#title").click(function(){
            var title = $("#title").val();
            if(title == searchtext){
                $("#title").val('');
            }
            $("#title").css('color','#333');

        })
        $("#title").blur(function(){
            var title = $("#title").val();
            if(title==''){
                $("#title").val(searchtext);
            }
        })

    })
    <?php
    }
    ?>
    $(document).ready(function(){
        $(".soulicos-1").click(function(){
            var title = $("#title").val();
            if(title == searchtext)
                title = "";
            var url = '<?= geturl("college/myask/{$method}") ?>'+ '?q='+title;
            document.location.href = url;
        });
        $('#content .li').last().css('border-bottom','0px');
    })

</script>

<div class="lefrig">
    <div class="lefrig-1" style="display: inline-block;width:100%; min-height:500px;">
	<?php if(!($is_zjdlr)){?>
	<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
		<ul>
			 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;"><span><?php echo (isset($pagemodulename)?$pagemodulename:'互动答疑');?></span></a></li>
		</ul>
	</div>
        <!--问题导航-->
  <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="main" style="width: 320px;height:230px;margin-left:20px;margin-top:15px;"></div>
	<div class="rigtose">
		<p class="yosret">
			<span class="shater"></span>
			<span class="zantion">个</span>
			<a href="<?= geturl('college/myask/addquestion') ?>" class="iwantasks" id="nonum">提 问</a>
			<span class="iwantasknum" id="yesnum">我要提问<span id="numback">999</span>s</span>
		</p>
		<div id="mains" style="width: 660px;height:200px;margin-top:10px;"></div>
	</div>
	<?php }?>
<script type="text/javascript">
    //异步获取数据
    var url = '<?= geturl("myroom/myask/getRateToJson") ?>';
    <?php if(!($is_zjdlr)){?>
    $.ajax({
        url:url,
        type:'POST',
        data:{},
        dataType:'json',
        success:function(r){
            if(r.code == 0){
                var list = r.data.list;
                var rate = r.data.rate;
                var $data = [];
                for(var key in list){

                    $data.push([list[key][0],list[key][1]]);
                }
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('main'));

                // 指定图表的配置项和数据

                var option = {
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        x: 'left',
                        data:['未解答','已解答','悬赏的']
                    },
                    series: [
                        {
                            name:rate.username,
                            type:'pie',
                            radius: ['50%', '70%'],
                            avoidLabelOverlap: false,
                            label: {
                                normal: {
                                    show: false,
                                    position: 'center'
                                },
                                emphasis: {
                                    show: true,
                                    textStyle: {
                                        fontSize: '30',
                                        fontWeight: 'bold'
                                    }
                                }
                            },
                            labelLine: {
                                normal: {
                                    show: false
                                }
                            },
                            data:[
                                {value:rate.notNumber, name:'未解答'},
                                {value:rate.solveNumber, name:'已解答'},
                                {value:rate.rewardNumber, name:'悬赏的'}
                            ]
                        }
                    ]
                };
                //点赞
                $('.shater').html(rate.reward+'元');
                $('.zantion').html(rate.praise+'个');
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);

                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('mains'));

                // 指定图表的配置项和数据


//data = [["2000-06-05",116],["2000-06-06",129],["2000-06-07",135],["2000-06-08",86],["2000-06-09",73],["2000-06-10",85],["2000-06-11",73],["2000-06-12",68],["2000-06-13",92],["2000-06-14",130],["2000-06-15",145],["2000-06-16",139],["2000-06-17",115],["2000-06-18",111],["2000-06-19",109],["2000-06-20",106],["2000-06-21",137],["2000-06-22",128],["2000-06-23",85],["2000-06-24",94],["2000-06-25",71],["2000-06-26",106],["2000-06-27",84],["2000-06-28",93],["2000-06-29",85],["2000-06-30",73],["2000-07-01",83],["2000-07-02",125],["2000-07-03",107],["2000-07-04",82],["2000-07-05",44]];




                var dateList = $data.map(function (item) {
                    return item[0];
                });
                var valueList = $data.map(function (item) {
                    return item[1];

              });

                var optione = {

                    // Make gradient line here
                    visualMap: [{
                        show: false,
                        type: 'continuous',
                        seriesIndex: 0,
                        min: 0,
                        max: 400
                    }],
                    title: [{
                        left: 'center',
                        text: '问答数'
                    }],
                    tooltip: {
                        trigger: 'axis'
                    },
                    xAxis: [{
                        data: dateList
                    }],
                    yAxis: [{
                        splitLine: {show: false}
                    }],
                    series: [{
                        type: 'line',
                        showSymbol: false,
                        data:valueList
                    }]
                };
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(optione);

            
            }
        }
    });
	<?php }?>
</script>
        <?php if(!$is_zjdlr){ ?>
			<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
	            <ul>
	                <li <?php if($method == 'all'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/all') ?>" style="font-size:16px;"><span>全部问题</span></a></li>
	                <li <?php if($method == 'hot'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/hot') ?>" style="font-size:16px;"><span>热门</span></a></li>
	                <?php if(!$is_zjdlr){?>
					<li <?php if($method == 'recommend'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/recommend') ?>" style="font-size:16px;"><span>推荐</span></a></li>
	                <?php }?>
	                <li <?php if($method == 'wait'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/wait') ?>" style="font-size:16px;"><span>等待答复</span></a></li>
	                <?php if(!$is_zjdlr){?>
	                    <li <?php if($method == 'settled'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/settled') ?>" style="font-size:16px;"><span>已解决</span></a></li>
	                <?php }?>
	                <?php if($is_zjdlr){?>
	                    <li <?php if($method == 'tome'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/tome') ?>" style="font-size:16px;"><span>给我的问题</span></a></li>
	                <?php }?>
	                <li <?php if($method == 'myquestion'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/myquestion') ?>" style="font-size:16px;"><span>我的问题</span></a></li>
	                <li <?php if($method == 'myanswer'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/myanswer') ?>" style="font-size:16px;"><span>我的回答</span></a></li>
	                <li <?php if($method == 'myfavorit'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/myfavorit') ?>" style="font-size:16px;"><span>我的关注</span></a></li>
					<?php if(!($is_zjdlr)){?>
	                <li <?php if($method == 'sortname'){echo "class='workcurrent'";}?>><a href="<?= geturl('college/myask/sortname') ?>" style="font-size:16px;"><span>排名</span></a></li>
					<?php }?>
					<div class="dile2s-1">
						<input name="txtname" class="newsous-1" id="title" placeholder="" type="text">
						<input class="soulicos-1" value="" type="button">
					</div>
					
	            </ul>
			</div>
        <?php }else{?>
			<div class="navigations-1">
	            <ul style="margin-left:0;width:1000px;">
	                <li><a href="/college/review/showReview.html">学员评论</a></li>
	                <li><a href="/college/myask/all.html" class="curr">答疑专区</a></li>
	                <?php if($is_newzjdlr){?>
	                	<li><a href="/college/myarticle.html">原创文章</a></li>
	                <?php }?>
					<div class="dile2s-1">
						<input name="txtname" class="newsous-1" id="title" placeholder="" type="text">
						<input class="soulicos-1" value="" type="button">
					</div>
					<a href="<?= geturl('college/myask/addquestion') ?>" class="iwantask" id="nonum">我要提问</a>
					<span class="iwantask" id="yesnum" style="display:none;line-height:28px;color:#fff;text-align:center;background: #999;width:84px;height:28px;float: right;margin-top: 5px;border-radius: 5px;">我要提问<span id="numback">999</span>s</span>
	            </ul>
			</div>
        <?php }?>
		

        <div class="clear"></div>
<!--排名-->
    <?php if(isset($isSort)){?>
        <div class="asktop">
            <a class="<?php echo ($this->input->get('type')==2?'dapais':'tipais')?>" href="<?php echo geturl('college/myask/sortname') ?>?type=1">提问排名</a>
            <a class="<?php echo ($this->input->get('type')==2?'tipais':'dapais')?>" href="<?php echo geturl('college/myask/sortname') ?>?type=2">解答排名</a>
        </div>
        <div class="oetute">
            <ul id="ranklist">
                <?php foreach ($list as $value) {
                    echo '<li class="dtuwrs">';
                    echo '<a href="/sns/feeds/'.$value['uid'].'.html" class="destgy">';
                    echo '<img class="imgrdu" src="' . (empty($value['face']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_'.($value['sex']==0?'man':'woman').'_50_50.jpg"' : $value['face']) . '" title="' . (empty($value['realname'])?$value['username']:$value['realname']) . '">';
                    echo '</a>';
                    echo '<span class="srusdyt">' . (empty($value['realname'])?$value['username']:$value['realname'])  . '</span>';
                    echo '<span class="srusdyt">' . ($this->input->get('type') == 2 ? '回答' : '提问') . ':' . $value['number'] . '次</span>';

                }
                ?>

            </ul>
        </div>
        <?php }?>
        <!--问题列表-->
        <?php if(!isset($isSort)){ ?>
        <div class="problemslist ">
            <?php if($is_zjdlr){?>
            <div class="problemslist" >
                <div class="problemslistnav">
                    <a href="<?= geturl('college/myask/all') ?>" <?php if($method == 'all'){echo "class='curr'";}?>>全部问题</a>
                    <a href="<?= geturl('college/myask/myquestion') ?>" <?php if($method == 'myquestion'){echo "class='curr'";}?>>我的问题</a>
                    <a href="<?= geturl('college/myask/myanswer') ?>" <?php if($method == 'myanswer'){echo "class='curr'";}?>>我的回答</a>
                </div>
                <div class="clear"></div>
            </div>
            <?php }?>
            <?php
            if(empty($asks) && !$is_zjdlr){
                echo " <div class=\"nodata\"></div>";
            }else{
                ?>
                <ul id="content">
                    <?php
                    $j = 0; //audioplayer属性动态名
                    foreach ($asks as $v) {
                        $j++;
                        $v['coverimg'] = json_decode($v['coverimg'],true);
                        if(!empty($v['coverimg'])){
                            $v['pic'] = $v['coverimg'];
                        }else{
                            $v['pic'] = explode(",",$v['imagesrc']);
                        }
                        $v['pic'] = array_filter($v['pic']);
                        $picNum = count($v['pic']);
                        $audiosrc = empty($v['audiosrc'])? '':json_decode($v['audiosrc'],true);
                        $audiotime = empty($v['audiotime'])? '':json_decode($v['audiotime'],true);
                        ?>
                        <li class="li">
                            <h2 class="problemstitle">
                                <span class="<?php if($v['hasbest'] == 1){echo "problemstitleico";}?>" title="<?php if($v['hasbest']==1){echo "已有正确答案";}?>"></span>
                                <a href="<?= geturl("/college/myask/{$v['qid']}.html") ?>" target="_blank" ><?php if($v['hasbest']==0 && isset($v['reward'])&&!empty($v['reward'])){?><span class="rewardpoints" title="悬赏<?=$v['reward']?>积分"><?=$v['reward']?></span><?php }?><?=$v['title']?></a>
                            </h2>
                            <?php
                            if($picNum ==1 && !empty($audiosrc) && is_array($audiosrc) ){
                                $i = 0;
                                foreach ($audiosrc as $audioK=>$item) {
                                    $i++;
                                    if (!empty($item) && !empty($audiotime[$audioK]) ) {
                                        echo "<div class='audioplayer' id='audioplayer_$j$i' style='margin-top:7px;margin-bottom:20px '></div>";
                                        ?>
                                        <script type="text/javascript">
                                            $(function () {
                                                voicePlayer({
                                                    box: $("#audioplayer_<?=$j.$i?>"),
                                                    src: "<?php echo $item;?>",
                                                    time: <?php echo $audiotime[$audioK];?>
                                                }).show();
                                            })
                                        </script>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <div style="*clear:both;"></div>
                            <div class="problemdetail">
                                <?php
                                if($picNum ==1){
                                    ?>
                                    <a href="<?= geturl("/college/myask/{$v['qid']}.html") ?>"  class="imgfl" target="_blank"><img src="<?php echo $v['pic'][0];?>" width="180px" height="100px" /></a>
                                    <a href="<?= geturl("/college/myask/{$v['qid']}.html" )?>" class="widthquestdetail" target="_blank"><?php if(!empty($v['message'])){$v['message'] = strip_tags($v['message']);echo shortstr($v['message'],400);}?></a>
                                    <?php
                                }else{
                                    ?>
                                    <a href="<?= geturl("/college/myask/{$v['qid']}.html" )?>" target="_blank"><?php if(!empty($v['message'])){$v['message'] = strip_tags($v['message']);echo shortstr($v['message'],300);}?></a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="answernumber">
                                <span class="answernumberspan">回答数</span>
                                <span><b class="b1"><?=$v['answercount']?></b><b class="b2">/</b><b class="b3"><?=$v['viewnum']?></b></span>
                            </div>
                            <?php
                            if($picNum > 1 && !empty($audiosrc) && is_array($audiosrc)){
                                $i = 0;
                                foreach ($audiosrc as $audioK=>$item) {
                                    $i++;
                                    if (!empty($item) && !empty($audiotime[$audioK]) ) {
                                        echo "<div class='audioplayer' id='audioplayer_$j$i' style='margin-top:7px;margin-bottom:20px '></div>";
                                        ?>
                                        <script type="text/javascript">
                                            $(function () {
                                                voicePlayer({
                                                    box: $("#audioplayer_<?=$j.$i?>"),
                                                    src: "<?php echo $item;?>",
                                                    time: <?php echo $audiotime[$audioK];?>
                                                }).show();
                                            })
                                        </script>
                                        <?php
                                    }
                                }
                            }
                            ?>

                            <?php if($picNum>1){ ?>
                                <ul class="questionerpic-1">
                                    <?php
                                    for ($i=0;$i<4;$i++){
                                        if(!empty($v['pic'][$i])){
                                            ?>
                                            <li><a href="<?= geturl("/college/myask/{$v['qid']}.html") ?>" target="_blank"><img width="180px" height="100px" src="<?=$v['pic'][$i]?>"/></a></li>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            <?php }?>
                            <div class="questinformation-1">
                                <?php
                                $timetostr = timetostr($v['dateline']);
                                preg_match('/[\d]{4}-[\d]{2}-[\d]{2}/',$timetostr,$matches);
                                if(!empty($matches)){
                                    $timetostr = $matches[0];
                                    echo " <span class=\"questiontime-2\" >$timetostr</span>";
                                }else{
                                    echo " <span class=\"questiontime-1\" >$timetostr</span>";
                                }
                                if($v['sex']==1){
                                    if($v['groupid']==5){
                                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
                                    }else{
                                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                                    }
                                }else{
                                    if($v['groupid']==5){
                                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
                                    }else{
                                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                                    }
                                }
                                if(!empty($v['face'])){
                                    $defaulturl = $v['face'];
                                }
                                $defaulturl = getthumb($defaulturl,'50_50');
                                ?>

                                <img class="questionerhead" src="<?=$defaulturl?>"  <?php $name = empty($v['realname'])?$v['username']:$v['realname'];$name = trim($name); if(strlen($name) > 8) echo "title='{$name}'" ;?> />
                                <span class="questioner" <?php $name = empty($v['realname'])?$v['username']:$v['realname'];$name = trim($name); if(strlen($name) > 8) echo "title='{$name}'" ;?> ><?=shortstr(empty($v['realname'])?$v['username']:$v['realname'],8)?></span>
                                <p class="coursewarelink"><a href="javascript:void(0)"><?= $v['foldername'] ?></a> <?php if(!empty($v['cwname'])){ echo ">" ?> <a href="javascript:void(0)"><?= $v['cwname'] ?></a><?php }?></p>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            <?php }?>
        </div>
    </div>
        <?php } ?>
        <div style=" color: rgb(102, 102, 102); line-height: 32px; font-size: 14px;overflow: hidden;position: absolute;left: 50%;margin-left: -53px;display: none" id="onloading";>
            <img src="http://static.ebanhui.com/ebh/images/live_loading.gif"style="float: left"> <div style="height:32px;line-height:32px;float: left;margin-left: 4px;">正在加载中</div>
        </div>
        <?php if(!empty($asks)) echo $pagestr; ?>
    </div>
</div>
<script type="text/javascript">
	
	function delCookie(name){	//删除cookie
	    var exp = new Date();
	    exp.setTime(exp.getTime() - 1);
	    var cval=getCookie(name);
	    if(cval!=null)
	        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}
	function getCookie(name){	//读取cookie
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	    if(arr=document.cookie.match(reg))
	        return (arr[2]);
	    else
	        return null;
	}
	
	
	var $numback = $("#numback");
	var endtimecuo = getCookie('username');
	var nowtimecuo = Date.parse(new Date())/1000;
	var resttime = endtimecuo - nowtimecuo; 
	if(endtimecuo == null){
		$('#nonum').css("display","block");
		$('#yesnum').css("display","none");
	}else{
		if(resttime<=0){
			$('#nonum').css("display","block");
			$('#yesnum').css("display","none");
		}else{
			$('#nonum').css("display","none");
			$('#yesnum').css("display","block");
			$numback.html(resttime);
			var backtime = setInterval(function(){
				nowtimecuo = Date.parse(new Date())/1000;
				resttime = endtimecuo - nowtimecuo;
				$numback.html(resttime);
				if(resttime <= 0){
					clearInterval(backtime);
					delCookie('username');
					$('#nonum').css("display","block");
					$('#yesnum').css("display","none");
				}
			},1000);
		}
	}
	
	
	
    var url = window.location.href;
    var reg = /-(\d)-\d-\d\.html/;
    var page = url.match(reg);
    if(page){
        page = page[1];
    }else{
        page = 1;
    }
    page = parseInt(page);
    page = (page-1)*3+1;
    var isajax = 0;//是否在执行
    var pageAjaxNum = 0;//ajax已执行次数
    var ajaxNum = 2; // ajax需要执行次数
    <?php
    if(empty($asks)){
    ?>
    $('#content li').last().css('border-bottom','0px');
    <?php
    }
    ?>
    /*  if(ajaxNum == 2){
     $('.li-1').last().css('border-bottom','0px');

     }else{
     $('.listPage').css('display','none');
     }*/
    //告诉父窗口来调pageCondition
    top.window.scrollInit();
    // 滚动条生效条件
    function pageCondition(pageC){
        if((pageC == 1) && (isajax == 0) && (pageAjaxNum < ajaxNum)){
            isajax = 1;
            scrollshow2();
        }
    }
    //显示正在加载
    function showflower(){
        var len = $('#content .li').length;
        if(len%15 == 0){
            $("#onloading").show();
        }
    }
    //关闭正在加载
    function closeflower(){
        $("#onloading").hide();
    }

    function scrollshow2(){
        pageAjaxNum+=1;
        if(pageAjaxNum <=ajaxNum){
            var len = $('#content .li').length;
            showflower();
            if(len%15 != 0){
                $('#content .li').last().css('border-bottom','0px');
                $('.listPage').css('display','block');
                isajax = 0;
            }else{
                ajaxurl();
            }
        }
    }
    // ajax请求
    /*function ajaxurl(){
     html = '';
     for(var i=0;i<15;i++){
     html +="<li>";
     html +="<h2 class='problemstitle'><a href='javascript:void(0)'>关于氧化还原反应的问题</a></h2>";
     html +="<div class='problemdetail'><a href='javascript:void(0)'>请问在不知道化学方程式的情况下亚铁离子和溴离子的氧化性强弱根据什么判断?</a></div>";
     html +=" <div class='answernumber'>";
     html +=" <span class='answernumberspan'>回答数</span>";
     html +="<span><b class='b1'>10</b><b class='b2'>/</b><b class='b3'>56</b></span>";
     html +="</div>";
     html +="<div class='questinformation-1'>";
     html +="<span  class='questiontime-1'>3小时前</span>";
     html +="<img class='questionerhead' src='http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg' />";
     html +="<span class='questioner'>王铭君</span>";
     html +="<p class='coursewarelink'><a href='javascript:void(0)'>2016年秋季高一化学</a> > <a href='javascript:void(0)'>第四讲：氧化还原反应</a></p>";
     html +="</div>";
     html +="</li>";
     }
     $('#content').append(html);

     }*/
    function ajaxurl(){
        var search =  $("#title").val();
        if(search == searchtext){
            search ='';
        }
        var curpage = page+pageAjaxNum;
        $.ajax({
            type: 'POST',
            url: '/college/myask/<?php echo $method;?>-'+curpage+
            '-0-0.html?q='+search ,
            dataType: 'json',
            success: function (data) {
                var html = '';
                var audiosrcArrayout = new Array();
                var audiotimeArrayout = new Array();
                if(data.error==0){
                    var content = data.msg;
                    var len = content.length;
                    for(var j=0;j<len;j++){
                        var hasbest = content[j]['hasbest'];
                        var reward =  parseInt(content[j]['reward']);
                        var audiosrc = content[j]['audiosrc'];
                        var audiotime  =  content[j]['audiotime'];
                        audiosrc = issetpic(audiosrc);
                        if(audiosrc[0]==1){
                            audiosrc = audiosrc[1];
                        }else{
                            audiosrc = new Array();
                        }
                        audiotime = issetpic(audiotime);
                        if(audiotime[0]==1){
                            audiotime = audiotime[1];
                        }else{
                            audiotime = new Array();
                        }

                        var coverpic = content[j]['coverimg'];
                        var imagepic = content[j]['imagesrc'];
                        var username = content[j]['username'];
                        var realname = content[j]['realname'];
                        var usernamefull = content[j]['username_full'];
                        var realnamefull = content[j]['realname_full'];
                        if (realname == ''){
                            realname = username;
                            realnamefull = usernamefull;
                        }

                        var cwname = content[j]['cwname'];
                        html+="<li class='li'>";
                        html+="<h2 class='problemstitle'>";
                        if(hasbest == 1){
                            html+="<span class='problemstitleico' title='已有正确答案'></span>";
                        }
                        html+="<a href="+geturl("/college/myask/"+content[j]['qid']+".html")+" target='_blank' >";
                        if(hasbest == 0 && reward > 0){
                            html+="<span class='rewardpoints' title='悬赏"+reward+"积分'>"+reward+"</span>";
                        }
                        html+=content[j]['title']+"</a></h2>";

                        var  iscoverpic = issetpic(coverpic);
                        var pic = new Array();
                        if(iscoverpic[0] == 0){
                            var isimagepic =  issetpic(imagepic);
                            if(isimagepic[0]==1){
                                pic = isimagepic[1];
                            }
                        }else{
                            pic = iscoverpic[1];
                        }
                        if(pic.length == 1){
                            var audiosrcArrayin = new Array();
                            var audiotimeArrayin = new Array();
                            for( var i=0;i<audiosrc.length;i++){
                                audiosrcArrayin.push(audiosrc[i]);
                                audiotimeArrayin.push(audiotime[i]);
                                html+="<div class='audioplayer audioplayerx_"+curpage+"'"+"style='margin-top:7px;margin-bottom:20px '></div>";
                            }
                            audiosrcArrayout.push(audiosrcArrayin);
                            audiotimeArrayout.push(audiotimeArrayin);
                        }
                        html+= "<div class='problemdetail'>";
                        if(pic.length == 1){
                            html+= "<a href='"+geturl("/college/myask/"+content[j]['qid']+".html'")+"  class='imgfl' target='_blank'><img src='"+pic[0]+"' width='180px' height='100px' /></a>";
                            html+= "<a href='"+geturl("/college/myask/"+content[j]['qid']+".html'" )+" class='widthquestdetail' target='_blank'>"+content[j]['message_400']+"</a>";
                        }else{
                            html+= "<a href='"+geturl("/college/myask/"+content[j]['qid']+".html'" )+" target='_blank'>"+content[j]['message_300']+"</a>";
                        }
                        html+="</div>";
                        html+= "<div class='answernumber'>";
                        html+= "<span class='answernumberspan'>回答数</span>";
                        html+= "<span><b class='b1'>"+content[j]['answercount']+"</b><b class='b2'>/</b><b class='b3'>"+content[j]['viewnum']+"</b></span>";
                        html+="</div>";
                        if(pic.length > 1){
                            var audiosrcArrayin = new Array();
                            var audiotimeArrayin = new Array();
                            for( var i=0;i<audiosrc.length;i++){
                                audiosrcArrayin.push(audiosrc[i]);
                                audiotimeArrayin.push(audiotime[i]);
                                html+="<div class='audioplayer audioplayerx_"+curpage+"'"+"style='margin-top:7px;margin-bottom:20px '></div>";
                            }
                            audiosrcArrayout.push(audiosrcArrayin);
                            audiotimeArrayout.push(audiotimeArrayin);
                        }

                        if(pic.length > 1){
                            html+= "<ul class='questionerpic-1'>";
                            for(var i=0;i<pic.length;i++){
                                html+="<li><a href='"+geturl("/college/myask/"+content[j]['qid']+".html'")+ " target='_blank'><img width='180px' height='100px' src='"+pic[i]+"' /></a></li>";
                            }
                          /*  if(pic.length > 4){
                                html+=" <li class='questpicmore-1'><a href='" +geturl("/college/myask/"+content[j]['qid']+".html'")+" target='_blank'>更<br/>多</a></li>";
                            }*/
                            html+= "</ul>";
                        }

                        html+= "<div class='questinformation-1'>";
                        if(content[j]['matches'] == 1){
                            html+= "<span class='questiontime-2' >" +content[j]['timestr'] +"</span>";
                        }else{
                            html+="<span class='questiontime-1' >"+content[j]['timestr']+"</span>";
                        }
                        if(realnamefull.length > 8){
                            html+="<img class='questionerhead' src='"+content[j]['defaulturl']+"' title='"+realnamefull+"'/>";
                            html+="<span class='questioner' title='"+realnamefull+"'>"+realname+"</span>";
                        }else{
                            html+="<img class='questionerhead' src='"+ content[j]['defaulturl']+"'/>";
                            html+="<span class='questioner' title='"+realnamefull+"'>"+realname+"</span>";
                        }


                        html+="<p class='coursewarelink'><a href='javascript:void(0)'> "+content[j]['foldername']+"</a>";
                        if(cwname == ''){
                            html+="</p>";
                        }else{
                            html+=" > <a href='javascript:void(0)'>"+cwname+"</a></p>";
                        }
                        html+= "</div>";
                        html+="</li>";
                    }

                    $('#content').append(html);
                }else{
                    $('#content .li').last().css('border-bottom','0px');
                }
                closeflower();
                var audiosrcnum =0;
                for(var i=0;i<audiosrcArrayout.length;i++){
                    for(var j=0;j<audiosrcArrayout[i].length;j++){
                        voicePlayer({
                            box: $($('.audioplayerx_'+curpage).get(audiosrcnum)) ,
                            src: audiosrcArrayout[i][j],
                            time:audiotimeArrayout[i][j]
                        }).show();
                        audiosrcnum+=1;
                    }
                }

                if(pageAjaxNum == ajaxNum){//显示分页
                    $('.listPage').css('display','block');
                    $('#content .li').last().css('border-bottom','0px');
                    $('.listPage a').click(function(){
                        window.top.topSet();
                    })
                }
                top.resetmain();
                isajax = 0;
            },
            error:function (data) {
                $('#content .li').last().css('border-bottom','0px');
                closeflower();
                isajax = 0;
            }
        })
    }

    // 判断图片是否存在
    function issetpic(pic){
        if(pic !=''){
            try {
                pic = JSON.parse(pic);
            } catch(err) {

            }
            if(typeof(pic) == 'object'){
                pic = array_filter(pic);
                if(pic.length != 0){
                    return [1,pic];//存在
                }
            }
        }
        return [0];
    }
    //过滤空数组
    function array_filter(param){
        var newArr = new Array();
        for (var i in param) {
            if(param[i] !=''){
                newArr.push(param[i]);
            }
        }
        return newArr;
    }

    //获取url
    function geturl(name) {
        if (name.indexOf( 'http://') !== false || name.indexOf('.html') !== false) {
            var url = name;
        } else{
            var url = '/' +name + '.html';
        }
        return url;
    }

</script>

</body>
</html>
