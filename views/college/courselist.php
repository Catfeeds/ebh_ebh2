<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	$v=getv();
    $appsetting = Ebh::app()->getConfig()->load('othersetting');
    $appsetting['szlz'] = empty($appsetting['szlz'])?0:$appsetting['szlz'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css<?=$v?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=$v?>" />

<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2016/css/titlecs.css<?=$v?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/courseware.css<?=$v?>" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.silver_track.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/simpletree.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/echarts.min.js"></script>
</head>
<style>
.cmain_bottom .study .xialas{top:28px;position: absolute;}
a.sees{display:block; width:114px; margin:5px auto 0; text-align:center; height:24px; line-height:24px; background:#0099ff; color:#fff; }
.cmain_bottom .study_top{ }
.other_room_tit{ border-bottom:none;}
.showimg > a{display:block; height:155px;}
.kejian .showimg{ margin-left:15px;}
.kejian .liss{
	padding-bottom:10px;
}
.kejian .liss .danke .spne{ margin-left:10px; line-height:30px;}
.piaoyin{ left:15px;}
.danke2s:hover{ box-shadow:0 0 5px #ccc;}
.cmain_bottom {padding-bottom:10px;}
.danke2s{ padding-bottom:10px; display:inline-block; width:146px;}
.piaoyin{ position:relative; *position:absolute;top:5px; min-height:159px; height:auto;}
.imges img,.kewates{ margin-left:15px;}
.kejian li.li1 .piaoyin{ position:relative; *position:absolute;top:5px; width:212px; height:125px; left:0px;top:0; min-height:125px;}
.kejian li.li1 .showimg{
	margin-left:0;
}
.kejian li.li1 .showimg > a{
	height:125px;
}
.kejian li.li1 .showimg img{
	padding:0;
	left:0;
}
.kejian{
	font-family:微软雅黑;
}
.cmain_bottom .study .xialas ul li {
    padding: 6px 6px 0;
	margin:0;
}
.work_menu ul li {
    display: inline;
    float: left;
    font-size: 16px;
    line-height: 33px;
    margin: 0 15px;
    padding: 9px 0 0;
}

.piaoyin a.btnxlick.btn{z-index:100;width:70px;height:70px;position:absolute;bottom:0;right:0;}
    div.sort-panel{
        height: auto;
        background: #F6F6F6;
        display: block;
        margin-bottom: 20px;
        margin-left:20px;
        margin-right:20px;
        line-height: 40px;}
    a.saitemsort{font-size:15px;margin:0 10px;display:inline-block;}
a.saitemsort:hover,a.csur{color:#338bff;}
.other_room_tit h2 {color:#4c88ff;font-size:16px;font-weight:normal;}
body{
    font-family: microsoft yahei;
}
a {color: #3d3d3d;text-decoration: none;}
.cmain_bottom .study .xialas{top:-5px;}
.cmain_bottom .study_bottom ul li{ margin-bottom:10px;}

.grow_chenr {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_xian.png) repeat-y;
    float:left;
    margin-top:6px;
    margin-left:10px;
}
.grow_h3 {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_quan.png) no-repeat;
    float:left;
    padding-left:30px;
    width:620px;
    height:23px;
    line-height:23px;
    font-size:16px;
    color:#999;
}
.grow_txt {
    color:#999;
    font-size:14px;
    padding-left:107px;
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_xing.png) no-repeat 85px center;
    float:left;
    width:588px;
    height: 40px;
    line-height: 40px;
    margin: 0;

}
.grow_txts  {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_xing.png) no-repeat 85px center #fff;
}
.grow_colt {
    color:#444;
}
.ndejtr {
    color:#ff7f00;
}
.expired {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dates2.png?v=02) no-repeat scroll center center;
    color: #fff;
    font-family: Arial;
    font-size: 14px;
    font-weight: bold;
    height: 28px;
    left: 2px;
    line-height: 28px;
    position: relative;
    text-align: center;
    top: 50px;
    width: 93px;
}
.starting {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dates3.png?v=02) no-repeat scroll center center;
    color: #fff;
    font-family: Arial;
    font-size: 12px;
    font-weight: bold;
    height: 28px;
    left: 2px;
    line-height: 28px;
    position: relative;
    text-align: center;
    top: 50px;
    width: 93px;
}
.studycourse-2 {position: relative;width: 1000px;
float: left;}
.lihide{display:none}
.danke2s-1s {position: relative;}
</style>
<body>
<?php
//判断国土
$roominfo = Ebh::app()->room->getcurroom();
$roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
if(!empty($roominfo['crid'])){
	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	$appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	$appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	$is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	$is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
}
?>
	<div class="lsitit" >
		<div class="clear"></div>
		<div class="cmain_bottom ">
<!--       最新课程     -->
            <?php //最新课程,今天起的7天内
            if(!empty($newcwlist)){
                ?>
                <div class="jijiangkk" style="margin-bottom:10px">
                    <h2 style="border-bottom: 1px solid #efefef;">最新课程</h2>
                    <div class="jijiangkk_son">
                        <?php $i=0;
                        $mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
                        // $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
                        $lineimgarr[1]['todayunstart'] = 1;
                        $lineimgarr[1]['now'] = 7;
                        $lineimgarr[1]['unstart'] = 4;
                        $lineimgarr[1]['end'] = 5;

                        $lineimgarr[0]['todayunstart'] = 3;
                        $lineimgarr[0]['now'] = 8;
                        $lineimgarr[0]['unstart'] = 2;
                        $lineimgarr[0]['end'] = 6;
						$cwnum = 0;
                        foreach($newcwlist as $k=>$listbyday){
                            $find = array('x','y','z');
                            $replace = '';
                            $k = str_replace($find,$replace,$k);
                            foreach($listbyday as $cw){
                                $i++;
                                $lineimgtype = intval($i==1); //第一位还是其他
                                $arr = explode('.',$cw['cwurl']);
                                $type = $arr[count($arr)-1];
                                $isVideotype = in_array($type,$mediatype) || $cw['islive'] == 1;
                                // $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
                                $target = '_blank';
                                $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($isVideotype?($cw['islive']?'livelogo.jpg':'defaultcwimggray.png'):'kustgd2.png');
                                if($isVideotype){
                                    $playimg = 'kustgd2';
                                }elseif(strstr($type,'ppt')){
                                    $playimg = 'ppt';
                                }elseif(strstr($type,'doc')){
                                    $playimg = 'doc';
                                }elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
                                    $playimg = 'rar';
                                }elseif($type == 'mp3'){
                                    $playimg = 'mp3';
                                }elseif($cw['islive'] == 1){
                                    $playimg = 'kustgd';
                                }else{
                                    $playimg = 'attach';
                                }

                                $logo = (!empty($cw['logo']) && $isVideotype)?$cw['logo']:$deflogo;

                                ?>
                                <div class="jjikk_sons">

                                    <?php if($k=='今天'){?>
                                        <!-- 正在上课 当前时间在课程发布时间+课件时间范围内 显示正在上课 -->
                                        <!-- 即将开始上课  当前时间还未到课件发布时间的 显示橙色 -->
                                        <!-- 已经结束的  当前时间已经超过课件发布+播放时间 显示灰色-->
                                        <?php
                                        $starttime = $cw['truedateline'];
                                        $cwlenth = $cw['cwlength'];//课件时长
                                        $nowtime = SYSTIME;
                                        $html = '';
                                        if($nowtime <= $starttime){
                                            //即将开始
                                            $html = '<div class="fl jjikk_sons_l">'.date('H:i',$starttime).'&nbsp;</div>';
                                            $lineimg = $lineimgarr[$lineimgtype]['todayunstart'];
                                        }elseif(!empty($cwlenth) && ($nowtime>=$starttime) && (($starttime+$cwlenth) >= $nowtime) && (empty($cw['endat']) || $cw['endat']>=$nowtime)){
                                            //正在上课
                                            $html = '<div class="fl jjikk_sons_l starting">正在上课...&nbsp;</div>';
                                            $lineimg = $lineimgarr[$lineimgtype]['now'];
                                        }elseif($nowtime > ($starttime+$cwlenth) || (!empty($cw['endat']) && $nowtime>$cw['endat'])){
                                            //已结束
                                            $html = '<div class="fl jjikk_sons_l '.(($starttime<SYSTIME)?'expired':'').'">'.date('H:i',$starttime).'&nbsp;</div>';
                                            $lineimg = $lineimgarr[$lineimgtype]['end'];
                                        }

                                        echo  $html;
                                        ?>


                                    <?php }else{
                                        $lineimg = $lineimgarr[$lineimgtype]['unstart'];?>
                                        <div class="fl jjikk_sons_l jjikk_sons_ls"><span style="font-family:微软雅黑;font-size:12px;"><?=$k?>&nbsp;</span><br /><?=Date('H:i',$cw['truedateline'])?>&nbsp;</div>
                                    <?php }?>
                                    <div class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/jijiangkk<?=$lineimg?>.png?v=20170718001" width="24" height="143" /></div>
                                    <div class="fl jjikk_sons_r">
                                        <div class="fl jjkkkc">
                                            <a class="kustgd" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank" class="opens viewc"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png"></a>
                                            <div class="kcbj"><img width="167" height="100" src="<?=$logo?>"></div>
                                        </div>
                                        <div class="kcjsnr fl">
                                            <h2><a href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank" title="<?=$cw['title']?>"><?=shortstr($cw['title'],66)?></a></h2>
                                            <p title="<?=$cw['summary']?>"><?=shortstr($cw['summary'],200)?></p>
                                            <p class="zjlsp">主讲：<?=$cw['realname']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            <?php
							 $cwnum++;
							if ($cwnum >= $maxCwCount) {
								break;
							}
							}
							if ($cwnum >= $maxCwCount) {
								break;
							}
                        }?>

                    </div>
                </div>
            <?php }?>
<!--        最新课程结束    -->



        	<!--学习-->
            <div class="study fl" style="<?=$roominfo['isschool']==7?'background:none;':''?> border-bottom:none; padding-bottom:0;">
				<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;overflow: initial;">
					<ul>
						 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;"><span><?=empty($all)?$pagemodulename:'全校课程'?></span></a></li>
						 <?php if (!($is_newzjdlr||$is_zjdlr)) {?>
						 <li class=""><a href="/myroom/favorite.html" style="font-size:16px;"><span>收藏夹</span></a></li>
					</ul>
					<div class="fr" style="width:160px;margin-top:10px;">
						<a href="/college/record.html" class="studyjl">学习记录</a>
						<a href="javascript:void(0)" class="more ml15">更多</a>
					</div>
					<?php } else {?>
					</ul>
					<div class="fr" style="width:230px;margin-top:10px;">
						<a href="/college/record.html" class="studyjl">学习记录</a>
						<a href="/myroom/favorite.html" class="shoucang">收藏夹</a>
						<a href="javascript:void(0)" class="more ml15">更多</a>
					</div>
					<?php }?>
                    <div class="clear"></div>
                    <div class="xialas xialas<?=$roominfo['isschool']==7?'2':'4'?>" style="display:none;">
                		<ul >
                            <li style="padding-top:8px;"><a href="/college/notes.html">听课笔记</a></li>
							<li><a href="/college/review/student.html">我的评论</a></li>
							<?php if($roominfo['isschool']!=7){?>
							<li><a href="/myroom/college/allcourse.html">全校课程</a></li>
							<li><a href="/myroom/college/allteachers.html">全校老师</a></li>
							<?php }?>
                        </ul>
                	</div>
                </div>
                <div class="clear"></div>
                <div class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-2' : 'study_bottom' ?>" style="position: relative;">
				<?php if (!($is_newzjdlr||$is_zjdlr)) {?>
					<div id="main" style="width: 400px;height:300px;margin-bottom:-50px;"></div>
					<div id="mains" style="width: 600px;height:120px;position: absolute;top:50px;right:0px;"></div>
					<?php if($roominfo['template'] == 'plate'){?>
					<div class="diles" style="top:210px;">
						<input name="txtname" class="newsou nsearchtext" id="txtname" value="请输入关键字" style="color: #A5A5A5;" type="text">
						<input onclick="" class="soulico nsearchbtn" value="" type="button">
					</div>
					<?php }?>
				<?php }?>
<script type="text/javascript">
    //用AJAX异步加载图形界面,国土摒弃改功能
    <?php if (!$is_zjdlr) {?>
        var url = "<?=geturl('myroom/college/getProgressAndRatetoJson')?>";
        $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            async:true,
            data:{},
            success:function (r) {

                if(r.code == 0){
                    // 基于准备好的dom，初始化echarts实例
                    var studyInfo = r.data;
                    if(!$('#main').length){
                        return false;
                    }
                    var myChart = echarts.init(document.getElementById('main'));

                    // 指定图表的配置项和数据

                    var option = {
                        tooltip : {
                            formatter: "{a} <br/>{b} : {c}%"
                        },
                        series: [
                            {
                                name: studyInfo.realName,
                                type: 'gauge',
                                detail: {formatter:'{value}%'},
                                data: [{value: studyInfo['progress'], name: '学习进度'}]
                            }
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('mains'));

                    // 指定图表的配置项和数据

                    var optione = {
                        tooltip : {
                            trigger: 'axis',
                            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                            }
                        },
                        legend: {
                            data: ['直播课', '视频课','PPT','Word','其他']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis:  {
                            type: 'value'
                        },
                        yAxis: {
                            type: 'category',
                            data: ['课程']
                        },
                        series: [
                            {
                                name: '直播课',
                                type: 'bar',
                                stack: '总量',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'insideRight'
                                    }
                                },
                                itemStyle: {
                                    normal: {
                                        color: '#4595ce'
                                    }
                                },
                                data: [studyInfo['rate']['broadcast']]
                            },
                            {
                                name: '视频课',
                                type: 'bar',
                                stack: '总量',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'insideRight'
                                    }
                                },
                                itemStyle: {
                                    normal: {
                                        color: '#eb8144'
                                    }
                                },
                                data:[studyInfo['rate']['video']]
                            },
                            {
                                name: 'PPT',
                                type: 'bar',
                                stack: '总量',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'insideRight'
                                    }
                                },
                                itemStyle: {
                                    normal: {
                                        color: '#f5bf53'
                                    }
                                },
                                data: [studyInfo['rate']['ppt']]
                            },
                            {
                                name: 'Word',
                                type: 'bar',
                                stack: '总量',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'insideRight'
                                    }
                                },
                                itemStyle: {
                                    normal: {
                                        color: '#13b5b1'
                                    }
                                },
                                data: [studyInfo['rate']['word']]
                            },
                            {
                                name: '其他',
                                type: 'bar',
                                stack: '总量',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'insideRight'
                                    }
                                },
                                itemStyle: {
                                    normal: {
                                        color: '#59c2e2'
                                    }
                                },
                                data: [studyInfo['rate']['other']]
                            }
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(optione);
                }
            },
            error:function (e) {

            }

        });
    <?php }?>

</script>
				<?php
				if(!empty($schoolfreelist)){
					?>
					<div class="kejian" style="margin-top:0px; width:1000px; border:none;">
						<div class="other_room_tit"><h2>全校免费</h2></div>
						<ul class="liss">
						<?php
						if ($roominfo['template'] == 'plate') {
							foreach($schoolfreelist as $sf){
								if($sf['showmode'] !=3 ){
									$folderurl = geturl('myroom/college/study/cwlist/'.$sf['folderid']);
									$target = '';
								}
								else{
									$folderurl = geturl('myroom/college/study/introduce/'.$sf['folderid']);
									$target = 'target="_blank"';
								}

								$img = show_plate_course_cover($sf['img']);
								$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
								?>
								<li class="fl">
									<div class=" danke2s-1">
										<a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>" class="coursrtitle-1"><?= $sf['foldername']?><?=!empty($sf['coursewarenum'])?'('.$sf['coursewarenum'].')':''?>
										<div class="bordershadow"></div></a>
										<a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
										<div style="clear:both;"></div>
									</div>
								</li>
							<?php }
						} else {
						foreach($schoolfreelist as $sf){
							if($sf['showmode'] !=3 ){
								$folderurl = geturl('myroom/college/study/cwlist/'.$sf['folderid']);
								$target = '';
							}
							else{
								$folderurl = geturl('myroom/college/study/introduce/'.$sf['folderid']);
								$target = 'target="_blank"';
							}

							?>
							<li class="danke" style="margin-left:11px; _margin-left:2px;height:auto; text-align:left;margin-right:9px;">
								<div class="danke2s" style="height:auto;padding-bottom:10px;"><span class="spne" style="height:25px;font-size:14px"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>"><?= shortstr($sf['foldername'],16,'')?><?=!empty($sf['coursewarenum'])?'('.$sf['coursewarenum'].')':''?></a></span>
									<div class="clear"></div>
									<div class="showimg"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>"><img src="<?= empty($sf['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$sf['img']?>" width="114" height="159" border="0" /></a></div>
									<div style="clear:both;"></div>
								</div>
							</li>
						<?php }
						}
						?>
						</ul>
						</div>

				<?php }
				?>

				<?php if($roominfo['template'] == 'plate'){?>
				</div>
				<?php }?>

				<?php if(!empty($bestitem)){?>
						<div class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-2' : 'kejian' ?>" style="margin-top:0px; width:1000px; border:none;">
						<div class="other_room_tit"><h2>精品课</h2></div>
						<ul class="liss">
						<?php
						if ($roominfo['template'] != 'plate') {
							foreach($bestitem as $key=>$sf){
								$folderurl = geturl('myroom/college/study/cwlist/'.$sf['folderid']);
								$target = '';
								$img = show_plate_course_cover($sf['img']);
								$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
								?>
								<li class="fl">
									<div class=" danke2s-1">
										<a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['iname']?>" class="coursrtitle-1"><?=$sf['iname']?><?=!empty($sf['coursewarenum'])?'('.$sf['coursewarenum'].')':''?>
										<div class="bordershadow"></div></a>
										<div style="clear:both;"></div>
										<a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['foldername']?>"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
									</div>
									<div style="clear:both;"></div>
								</li>
							<?php }
						} else {
						foreach($bestitem as $key=>$sf){
							$folderurl = geturl('myroom/college/study/cwlist/'.$sf['folderid']);
							$target = '';
							?>
							<li class="danke" style="margin-left:11px; _margin-left:2px;height:auto; text-align:left;margin-right:9px;">
								<div class="danke2s" style="height:auto;padding-bottom:10px;"><span class="spne" style="height:25px;font-size:14px"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['iname']?>"><?= shortstr($sf['iname'],16,'')?><?=!empty($sf['coursewarenum'])?'('.$sf['coursewarenum'].')':''?></a></span>
									<div class="clear"></div>
									<div class="showimg"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$sf['iname']?>"><img src="<?= empty($sf['longblockimg'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$sf['longblockimg']?>" width="114" height="159" border="0" /></a></div>
									<div style="clear:both;"></div>
								</div>
							</li>
						<?php }
						}?>
						</ul>
						</div>
					<?php }?>
				<?php
					if($roominfo['isschool'] != 7){//非7,我的课程
						$allclear = true;?>
                	<ul class="mt15">
					<?php
					if ($roominfo['template'] == 'plate') {
						foreach($folders as $folder){
							if($folder['showmode'] !=3 ){
								$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
								$target = '';
							}
							else{
								$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
								$target = 'target="_blank"';
							}
							if(empty($folder['creditmode'])){
								$percent = empty($folder['percent'])?'0':$folder['percent'];
							}else{
								$percent = round($folder['sumtime']/$folder['credittime']*100,2);
								$percent = $percent>=100?100:$percent;
							}
							$img = show_plate_course_cover($folder['img']);
							$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
							?>

							<?php if (!($is_newzjdlr||$is_zjdlr)) {?>
							<li class="fl">
								<div class=" danke2s-1s">
									<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?=$img?>" height="125" width="212" /></a>
									<div class="rateoflearnfas">
									<a href="<?= $folderurl ?>" <?=$target?> title="<?=$folder['foldername']?>" class="coursrtitle-1s">
										<p class="rateoflearnings" style="width:<?=$percent?>%;">
											<span class="rateoflearnspans"><?=$folder['foldername']?></span>
										</p>
									</a>
									</div>
									<?php if(empty($folder['creditmode'])){
										if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
											$allclear = false;
										}
										?>
										<div class="fenset">
											<div class="coursrtitle-1s" >
												<?php if($folder['credit']!=0|| !empty($folder['creditget'])) {?>
												<span class="span-1s"><?=$folder['credit']?>分/</span><span class="span-2s"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span>
												<?php }?>
											</div>
										</div>
									<?php }else{
										if($folder['sumtime']>=$folder['credittime']){
											$creditget = $folder['credit'];
										}else{
											$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
											$allclear = false;
										}?>
										<div class="fenset">
											<div class="coursrtitle-1s" >
												<?php if($folder['credit']!=0|| !empty($folder['creditget'])) {?>
												<span class="span-1s"><?=$folder['credit']?>分/</span><span class="span-2s"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span>
												<?php }?>
											</div>
										</div>
										<div class="clear"></div>
										<?php if(!empty($folder['sumtime'])){?>
											<div style="color:#777;line-height:18px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>
									<?php }?>
								</div>
							</li>
							<?php } else {?>
							<li class="fl" style="height:200px;">
								<div class=" danke2s-1">
									<a href="<?= $folderurl ?>" <?=$target?> title="<?=$folder['foldername']?>" class="coursrtitle-1"><?=$folder['foldername']?>
									<div class="bordershadow"></div></a>
									<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?=$img?>" height="125" width="212" /></a>
									<div class="rateoflearnfa">
										<p class="rateoflearning" style="width:<?=$percent?>%;">
											<span class="rateoflearnspan"><?=$percent?>%</span>
										</p>
									</div>
									<?php if(empty($folder['creditmode'])){
										if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
											$allclear = false;
										}
										?>
										<div ><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span></div>
									<?php }else{
										if($folder['sumtime']>=$folder['credittime']){
											$creditget = $folder['credit'];
										}else{
											$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
											$allclear = false;
										}?>
										<div ><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=$creditget?>分</span></div>
										<div class="clear"></div>
										<?php if(!empty($folder['sumtime'])){?>
											<div style="color:#777;line-height:18px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>
									<?php }?>
								</div>
							</li>
							<?php }?>
							<?php

						}
					} else {
						foreach($folders as $folder){
							if($folder['showmode'] !=3 ){
								$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
								$target = '';
							}
							else{
								$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
								$target = 'target="_blank"';
							}
							if($is_zjdlr){
								if($folder['folderid'] == 12870){
									$folderurl = '/college/myask/all.html';
									$target = 'target="mainFrame"';
								}
							}

                            if(empty($folder['creditmode'])){
                                if ($is_zjdlr) {
                                    if (intval($folder['credit']) == 0) {
                                        $percent = 0;
                                    } else {
                                        $getscore = empty($folder['creditget'])?'0':$folder['creditget'];
                                        $percent = round($getscore/$folder['credit']*100);
                                    }

                                } else {
                                    $percent = empty($folder['percent'])?'0':$folder['percent'];
                                }
                            }else{
                                if ($is_zjdlr) {
                                    if (intval($folder['credit']) == 0) {
                                        $percent = 0;
                                    } else {
                                        if($folder['sumtime']>=$folder['credittime']){
                                            $getscore = $folder['credit'];
                                        }else{
                                            $getscore = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
                                        }
                                        $percent = round($getscore/$folder['credit']*100);
                                    }

                                } else {
                                    $percent = round($folder['sumtime']/$folder['credittime']*100,2);
                                }

                            }
                            $percent = $percent>=100?100:$percent;


							?>
							<li class="fl" style="height:255px;">
								<div class="danke2s">
									<div class="title" style="line-height:27px;">
										<a href="<?=$folderurl?>" <?=$target?> style="font-size:14px; color:#333;" title="<?=$folder['foldername']?>"><?=shortstr($folder['foldername'],16,'')?></a>
									</div>
									<div class="imges">
										<a id="folder<?=$folder['folderid']?>" href="<?=$folderurl?>" <?=$target?> title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" height="159" width="114" /></a>
									</div>
									<div class="kewates mt5" style="position: absolute;left: 10px;top: 166px;
                                    <?php if($folder['folderid'] == 12870) { echo 'display: none;';} ?>"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>
									<?php if(empty($folder['creditmode'])){
										if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
											$allclear = false;
										}
										?>

                                        <?php if($folder['folderid'] == 12870){
                                            $user = Ebh::app()->user->getloginuser();
                                            $askscore = $this->model('Roomcourse')->getNotFoldersScore($user['uid'],$roominfo['crid']);
                                        ?>
                                                <div class="mt5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span2ss"><?=empty($askscore['score'])?'0':$askscore['score']?>分</span></div>

                                        <?php } else {?>
                                            <div class="mt5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span></div>
                                        <?php }?>

									<?php }else{
										if($folder['sumtime']>=$folder['credittime']){
											$creditget = $folder['credit'];
										}else{
											$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
											$allclear = false;
										}?>
										<div class="mt5" style="text-align:left;margin-left:26px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=$creditget?>分</span></div>
										<div class="clear"></div>
										<?php if(!empty($folder['sumtime'])){?>
											<div style="color:#777;padding-left:25px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
										<?php }?>
									<?php }?>
								</div>
							</li>
							<?php

						}
					}
					?>
                    </ul>
					<?php }//else{//7,全校课程
					$allclear = true;
					if(!empty($spfolders))
						if ($roominfo['template'] == 'plate') {
							foreach($spfolders as $k=>$package){
								?>
								<div class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-2' : 'kejian' ?>" style="margin-top:0px; width:1000px; border:none;">
									<div class="other_room_tit"><h2><?=$package['pname']?></h2></div>
									<ul class="<?=$roominfo['template'] == 'plate' ? '' : 'liss' ?>">
										<?php
										$folderi = 0;
										$hasArr = array();
										foreach($package['itemlist'] as $folder) {
											if(!in_array($folder['folderid'],$hasArr)){
												if($folder['showmode'] !=3 ){
													$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
													$target = '';
												}
												else{
													$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
													$target = 'target="_blank"';
												}
												$folderi ++;
												if(empty($folder['creditmode'])){
													$percent = empty($folder['percent'])?'0':$folder['percent'];
												}else{
													$percent = round($folder['sumtime']/$folder['credittime']*100,2);
													$percent = $percent>=100?100:$percent;
												}
												$img = show_plate_course_cover($folder['img']);
												$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
												?>
												<?php if (!($is_newzjdlr||$is_zjdlr)) {?>
												<li class="fl">
													<div class=" danke2s-1s">

														<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
														<div class="rateoflearnfas">
															<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>" class="coursrtitle-1s">
																<p class="rateoflearnings" style="width:<?=$percent?>%;">
																<span class="rateoflearnspans"><?=$folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></span>
																</p>
															</a>
														</div>
														<?php if(empty($folder['creditmode'])){
															if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
																$allclear = false;
															}
															?>
															<div class="fenset">
																<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>" class="coursrtitle-1s">
																<?php if($folder['credit']!=0|| !empty($folder['creditget'])) {?>
																	<span class="span-1s"><?=$folder['credit']?>分/</span><span class="span-2s"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span>
																	<?php }?>
																</a>

															</div>
														<?php }else{
															if($folder['sumtime']>=$folder['credittime']){
																$creditget = $folder['credit'];
															}else{
																$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
																$allclear = false;
															}
															?>
															<div class="fenset"><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=$creditget?>分</span></div>
															<div class="clear"></div>
															<!--<?php if(!empty($folder['sumtime'])){?>
																<div style="color:#777;line-height:18px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
															<?php }?>-->
														<?php }?>
													</div>
												</li>
												<?php } else {?>
												<li class="fl" style="height:200px;">
													<div class=" danke2s-1">
														<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>" class="coursrtitle-1"><?=$folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?>
														<div class="bordershadow"></div></a>
														<a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
														<div class="rateoflearnfa">
															<p class="rateoflearning" style="width:<?=$percent?>%;">
																<span class="rateoflearnspan"><?=$percent?>%</span>
															</p>
														</div>
														<?php if(empty($folder['creditmode'])){
															if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
																$allclear = false;
															}
															?>
															<div><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span></div>
														<?php }else{
															if($folder['sumtime']>=$folder['credittime']){
																$creditget = $folder['credit'];
															}else{
																$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
																$allclear = false;
															}
															?>
															<div><span class="span-1"><?=$folder['credit']?>分/</span><span class="span-2"><?=$creditget?>分</span></div>
															<div class="clear"></div>
															<!--<?php if(!empty($folder['sumtime'])){?>
																<div style="color:#777;line-height:18px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
															<?php }?>-->
														<?php }?>
													</div>
												</li>
												<?php }?>
												<?php $hasArr[]= $folder['folderid'];}} ?>
									</ul>
								</div>
							<?php }
						} else {
							foreach($spfolders as $k=>$package){
								?>
								<div class="kejian" style="margin-top:0px; width:1000px; border:none;">
									<div class="other_room_tit"><h2><?=$package['pname']?></h2>

									</div>
									<ul class="liss">
										<?php
										$folderi = 0;
										$hasArr = array();
										foreach($package['itemlist'] as $folder) {
											if(!in_array($folder['folderid'],$hasArr)){
												if($folder['showmode'] !=3 ){
													$folderurl = geturl('myroom/college/study/cwlist/'.$folder['folderid']);
													$target = '';
												}
												else{
													$folderurl = geturl('myroom/college/study/introduce/'.$folder['folderid']);
													$target = 'target="_blank"';
												}
												$folderi ++;
												if(empty($folder['creditmode'])){
                                                    if ($is_zjdlr) {
                                                        if (intval($folder['credit']) == 0) {
                                                            $percent = 0;
                                                        } else {
                                                            $getscore = empty($folder['creditget'])?'0':$folder['creditget'];
                                                         $percent = round($getscore/$folder['credit']*100);
                                                        }

                                                    } else {
                                                        $percent = empty($folder['percent'])?'0':$folder['percent'];
                                                    }
                                                }else{
                                                    if ($is_zjdlr) {
                                                       if (intval($folder['credit']) == 0) {
                                                            $percent = 0;
                                                        } else {
                                                            if($folder['sumtime']>=$folder['credittime']){
                                                                $getscore = $folder['credit'];
                                                            }else{
                                                                $getscore = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
                                                                }
                                                            $percent = round($getscore/$folder['credit']*100);
                                                         }

                                                    } else {
                                                        $percent = round($folder['sumtime']/$folder['credittime']*100,2);
                                                    }

                                                }
                                                $percent = $percent>=100?100:$percent;
												?>

												<li class="danke" style="margin-left:11px; _margin-left:2px;height:255px;*height:250px; text-align:left;margin-right:9px;">
													<div class="danke2s" style="height:auto;"><span class="spne" style="height:25px;font-size:14px; line-height:30px;"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><?= shortstr($folder['foldername'],16,'')?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
														<div class="clear"></div>
														<div class="showimg"><a <?=$target?> href="<?= $folderurl ?>" title="<?=$folder['foldername']?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
														<div style="clear:both;"></div>
														<div class="kewates mt5 ml5" style="position:absolute;margin-left:15px;top:166px; left:0;"><p class="jifenicos" style="width:<?=$percent?>%"><span style="position:absolute;width:100px;top:0px;left:10px"><?=$percent?>%</span></p></div>
														<?php if(empty($folder['creditmode'])){
															if(empty($folder['creditget']) || $folder['creditget']<$folder['credit']){
																$allclear = false;
															}
															?>
															<div class="mt5 ml5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=empty($folder['creditget'])?'0':$folder['creditget']?>分</span></div>
														<?php }else{
															if($folder['sumtime']>=$folder['credittime']){
																$creditget = $folder['credit'];
															}else{
																$creditget = round($folder['sumtime']/$folder['credittime']*$folder['credit'],2);
																$allclear = false;
															}
															?>
															<div class="mt5 ml5" style="text-align:left;margin-left:15px;float:left;display:inline;"><span class="span1ss"><?=$folder['credit']?>分/</span><span class="span2ss"><?=$creditget?>分</span></div>
															<div class="clear"></div>
															<?php if(!empty($folder['sumtime'])){?>
																<div style="color:#777;padding-left:10px;text-align:left">已经学习 <?=secondToStr($folder['sumtime'])?></div>
															<?php }?>
														<?php }?>
													</div>

												</li>
												<?php $hasArr[]= $folder['folderid'];}} ?>
									</ul>
								</div>
							<?php }
						}
					?>
				</div>
                </div>


				<?php
				// var_dump($splist);
			if(!empty($splist) || !empty($cwlist)){
				$showunopen = false;
				if(empty($splist))
					$splist = array();
				if(!empty($cwlist)) //精品课件（单课收费）
					$showunopen = true;
				foreach($splist as $h=>$package){
					if(count($package['itemlist'])>0){
						$showunopen = true;
						break;
					}
				}
				?>

				<?php if(!empty($paidcws)){?>
				<div class="studycourse" style="margin-top:0px; width:1000px; border:none;">
					<div class="other_room_tit" style="height:10px;"></div>
					<ul class="liss">
					<?php if (!($is_newzjdlr||$is_zjdlr)) {?>
						<li class="fl" style="margin-left:10px;margin-top:10px;position: relative;height:145px">
							<div class=" danke2s-1s">
								<a href="/myroom/college/study/mycws.html" title="我的单课列表"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/mycw.jpg" width="212" height="125" border="0" /></a>
								<div class="rateoflearnfas">
									<a href="/myroom/college/study/mycws.html" title="我的单课列表" class="coursrtitle-1s">
										<p class="rateoflearnings" style="width:0%;">
											<span class="rateoflearnspans">我的单课列表(<?=$paidcws?>)</span>
										</p>
									</a>
								</div>
								<div style="clear:both;"></div>
							</div>
						</li>
					<?php } else{ ?>
						<li class="fl" style="margin-left:10px;margin-top:10px">
							<div class=" danke2s-1">
								<a href="/myroom/college/study/mycws.html" title="我的单课列表" class="coursrtitle-1">我的单课列表(<?=$paidcws?>)
								</a>
								<a href="/myroom/college/study/mycws.html" title="我的单课列表"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/mycw.jpg" width="212" height="125" border="0" /></a>
								<div style="clear:both;"></div>
							</div>
						</li>
				<?php }?>
					</ul>
				</div>
				<?php }?>
		<div class="kejian unopen" style="margin-top:0px; width:1000px; border:none;<?=empty($showunopen)?'display:none':''?>">
		<a name="classactive" style="display：none"></a>
<ul class="liss" <?= ( !empty($folderi) && $folderi > 0) ?'style="padding-top:10px;padding-bottom:10px;"' : '' ?>>
				<div class="track example-1">
					<div class="inner">
						<div class="view-port">
							<div class="slider-container" id="example-1">
				<?php if(!empty($cwlist) && !empty($cwpay)){?>
				<div class="packatab packagetab item" onclick="showpackage('cwlist')"><a href="javascript:void(0)"><span>单课列表
</span></a></div>
				<?php }?>
				<?php
					$idx = 0;
					$curp = 0;
					foreach($splist as $h=>$package){
						if(count($package['itemlist'])>0){
				?>
					<div class="<?=($idx==0 && (empty($cwlist) || empty($cwpay)))?'packatab':''?> packagetab item" onclick="showpackage(<?=$h?>, <?=$package['csid']?>)"><a href="javascript:void(0)"><span><?=$package['pname']?></span></a></div>


				<?php $idx++;
						if($curp == 0 && (empty($cwlist) || empty($cwpay)))
						$curp=$h;
					}
				}?>
							</div>
						</div>
					</div>
					<div class="pagination">
						<a href="#" class="prev disabled"></a>
						<a href="#" class="next disabled"></a>
					</div>
				</div>
				<?php if(!empty($cwpay)){
					$this->assign('my',false);
					$this->display('college/cwlist_cwpay');
				}?>
    <div class="sort-panel" style="margin-top:20px;">
        <?php foreach ($splist as $jj => $pck) {
            if (isset($pck['sorts'])) {
            foreach ($pck['sorts'] as $sort) { ?>
                <a class="saitemsort<?php if($sort['sid'] == $pck['csid']){ ?> csur<?php }?>" style="<?=($curp!=$jj)?'display:none;':''?>" spid="<?=$pck['pid']?>" ssid="<?=$sort['sid']?>"><?=$sort['sname']?></a>
            <?php }}
        } ?>
    </div>
				<?php
					foreach($splist as $j=>$package){ ?>
					<div class="package package<?=$j?>" style="<?=($curp!=$j)?'display:none;':''?>">
					<?php
					if ($roominfo['template'] == 'plate') {
						foreach($package['itemlist'] as $k=>$folder) {
                            if (!empty($package['sorts'][$folder['sid']]['showbysort']) && $package['sorts'][$folder['sid']]['showbysort'] == '1') {
                                $folderurl = '/room/portfolio/bundle/'.$folder['sid'] .'.html';
                            } else {
                                $folderurl = '/courseinfo/'.$folder['itemid'] .'.html';
                            }
							$img = show_plate_course_cover($folder['img']);
							$img = !empty($img) ? show_thumb($img, '212_125') : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
							?>
						<?php if (!($is_newzjdlr||$is_zjdlr)) {?>
							<li class="fl li1 sort<?=$folder['sid']?>" style="height:150px;<?php if($package['csid'] != $folder['sid']) { ?>display:none;<?php } ?>">
								<div class=" danke2s-1s">
								<div class="rateoflearnfas">
									<a target="_blank" href="<?=$folderurl?>" title="点击立即开通" class="tuslick">
										<p class="rateoflearnings" style="width:0%;">
											<span class="rateoflearnspans"><?=$folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></span>
										</p>
									</a>
								</div>


									<div style="clear:both;"></div>

									<?php if(empty($folder['cannotpay'])){?>
										<div class="showimg">
											<?php if(!empty($folder['ptype'])) { ?>
												<a target="_blank" href="<?= $folderurl ?>" title="<?= $folder['foldername'] ?>"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
											<?php } else { ?>
												<a href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
											<?php } ?>
										</div>
									<?php }else{?>
										<div class="showimg"><a href="javascript:;" style="cursor:default" title="点击立即开通"><img src="<?=$img?>" width="212" height="125" border="0" /></a></div>
									<?php }?>

									<?php if(!empty($folder['ptype'])) { ?>

									<a class="btnxlick btn" href="/ibuy.html?itemid=918" target="_blank" title="点击立即开通" itemid="918"><img src="http://static.ebanhui.com/ebh/tpl/default/images/buy-btn.png" width="70" height="70"></a>
									<div class="showimg" style="*top:30px;">
										<?php } else {
										if (!empty($folder['cannotpay'])) {
											$backimg = 'http://static.ebanhui.com/ebh/tpl/default/images/dicen_02.png?v=20161123001';
										} else {
											$backimg = 'http://static.ebanhui.com/ebh/tpl/default/images/buy-black.png';
											//$backimg = $folder['iprice'] > 0 ? 'http://static.ebanhui.com/ebh/tpl/default/images/dicen_01.png?v=20161123001' : 'http://static.ebanhui.com/ebh/tpl/default/images/free_s.png';
										}
										if (($folder['iprice'] == 0 || !empty($folder['isschoolfree']) && !empty($userin))) {
											$btn_img = 'http://static.ebanhui.com/ebh/tpl/default/images/free-btn.png';
											if ($roominfo['crid'] == $appsetting['szlz'])
												$btn_img = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/szlzfree.png';
											if (!empty($vis_sorts[$folder['sid']]['showbysort'])) {
												$buy_url = '/ibuy.html?itemid='.$folder['itemid'];//geturl('courseinfo/college/'.$folder['itemid']);
												if ($folder['sid'] > 0) {
													$buy_url .= '&sid='.$folder['sid'];
												}
												$target = ' target="_blank"';
												if ($roominfo['domain'] == 'yxwl') {
													$buy_url = '/classactive/bank.html';
												}
                                                if (!empty($survey_id)) {
                                                    $target = '';
                                                }
											} else {
												$buy_url = 'javascript:;';
												$target = '';
											}

										} else {
											$btn_img = 'http://static.ebanhui.com/ebh/tpl/default/images/buy-btn.png';
											$buy_url = '/ibuy.html?itemid='.$folder['itemid'];//geturl('courseinfo/college/'.$folder['itemid']);
											if ($folder['sid'] > 0) {
												$buy_url .= '&sid='.$folder['sid'];
											}
											$target = ' target="_blank"';
											if ($roominfo['domain'] == 'yxwl') {
												$buy_url = '/classactive/bank.html';
											}
											if (!empty($survey_id)) {
                                                $target = '';
                                            }
										}
										?>
										<div class="piaoyin" style="position:relative;top:1px;*top:30px;background:url(http://static.ebanhui.com/ebh/tpl/default/images/buy-black.png) right bottom no-repeat;">

											<?php } ?>
											<?php if(empty($folder['cannotpay'])){?>
												<?php if(empty($folder['ptype'])) { ?>
													<a target="_blank" href="<?=$folderurl?>" title="点击立即开通" class="tuslick"></a>
													<a class="btnxlick btn<?php if(!empty($survey_id)) { echo ' survey'; } ?>" href="<?=$buy_url?>"<?=$target?> title="点击立即开通" itemid="<?=$folder['itemid']?>"><img width="70" height="70" src="<?=$btn_img?>" /></a>
												<?php } ?>
											<?php }else{?>
											<a class="btnxlick btn" href="<?=$folderurl?>" target="_blank" title="点击立即开通"><img src="http://static.ebanhui.com/ebh/tpl/default/images/buy-btn1.png" width="70" height="70"></a>
												<a target="_blank" href="<?=$folderurl?>" style="" title="点击立即开通" class="tuslick"></a>
												<a class="btnxlick" href="javascript:;" style="cursor:default;display:none;" title="点击立即开通"></a>
												<a href="javascript:;" class="sees" style="display:none;">课程介绍</a>
											<?php }?>
										</div>
									</div>
							</li>
						<?php }else{?>
							<li class="fl li1 sort<?=$folder['sid']?>"<?php if($package['csid'] != $folder['sid']) { ?> style="display:none;"<?php } ?>>
								<div class=" danke2s-1">
									<a target="_blank" href="<?= $folderurl ?>" title="<?= $folder['foldername']?>" class="coursrtitle-1"><?=$folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?>
										<div class="bordershadow"></div></a>
									<div style="clear:both;"></div>

									<?php if(empty($folder['cannotpay'])){?>
										<div class="showimg">
											<?php if(!empty($folder['ptype'])) { ?>
												<a target="_blank" href="<?= $folderurl ?>" title="<?= $folder['foldername'] ?>"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
											<?php } else { ?>
												<a href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通"><img src="<?=$img?>" width="212" height="125" border="0" /></a>
											<?php } ?>
										</div>
									<?php }else{?>
										<div class="showimg"><a href="javascript:;" style="cursor:default" title="点击立即开通"><img src="<?=$img?>" width="212" height="125" border="0" /></a></div>
									<?php }?>

									<?php if(!empty($folder['ptype'])) { ?>
									<div class="showimg" style="*top:30px;">
										<?php } else {
										if (!empty($folder['cannotpay'])) {
											$backimg = 'http://static.ebanhui.com/ebh/tpl/default/images/dicen_02.png?v=20161123001';
										} else {
											$backimg = 'http://static.ebanhui.com/ebh/tpl/default/images/buy-black.png';
											//$backimg = $folder['iprice'] > 0 ? 'http://static.ebanhui.com/ebh/tpl/default/images/dicen_01.png?v=20161123001' : 'http://static.ebanhui.com/ebh/tpl/default/images/free_s.png';
										}
										if (($folder['iprice'] == 0 || !empty($folder['isschoolfree']) && !empty($userin))) {
											$btn_img = 'http://static.ebanhui.com/ebh/tpl/default/images/free-btn.png';
											if ($roominfo['crid'] == $appsetting['szlz'])
												$btn_img = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/szlzfree.png';
											if (!empty($vis_sorts[$folder['sid']]['showbysort'])) {
												$buy_url = '/ibuy.html?itemid='.$folder['itemid'];//geturl('courseinfo/college/'.$folder['itemid']);
												if ($folder['sid'] > 0) {
													$buy_url .= '&sid='.$folder['sid'];
												}
												$target = ' target="_blank"';
												if ($roominfo['domain'] == 'yxwl') {
													$buy_url = '/classactive/bank.html';
												}
                                                if (!empty($survey_id)) {
                                                    $target = '';
                                                }
											} else {
												$buy_url = 'javascript:;';
												$target = '';
											}

										} else {
											$btn_img = 'http://static.ebanhui.com/ebh/tpl/default/images/buy-btn.png';
											$buy_url = '/ibuy.html?itemid='.$folder['itemid'];//geturl('courseinfo/college/'.$folder['itemid']);
											if ($folder['sid'] > 0) {
												$buy_url .= '&sid='.$folder['sid'];
											}
											$target = ' target="_blank"';
											if ($roominfo['domain'] == 'yxwl') {
												$buy_url = '/classactive/bank.html';
											}
											if (!empty($survey_id)) {
                                                $target = '';
                                            }
										}
										?>
										<div class="piaoyin" style="position:relative;top:1px;*top:30px;background:url(<?=$backimg?>) right bottom no-repeat;">
											<?php } ?>
											<?php if(empty($folder['cannotpay'])){?>
												<?php if(empty($folder['ptype'])) { ?>
													<a target="_blank" href="<?=$folderurl?>" title="点击立即开通" class="tuslick"></a>
													<a class="btnxlick btn<?php if(!empty($survey_id)) { echo ' survey'; } ?>" href="<?=$buy_url?>"<?=$target?> title="点击立即开通" itemid="<?=$folder['itemid']?>"><img width="70" height="70" src="<?=$btn_img?>" /></a>
												<?php } ?>
											<?php }else{?>
												<a target="_blank" href="<?=$folderurl?>" style="" title="点击立即开通" class="tuslick"></a>
												<a class="btnxlick" href="javascript:;" style="cursor:default;display:none;" title="点击立即开通"></a>
												<a href="javascript:;" class="sees" style="display:none;">课程介绍</a>
											<?php }?>
										</div>
									</div>
							</li>
						<?php }?>

						<?php }
					} else {
						foreach($package['itemlist'] as $k=>$folder) {
                            $folderurl = "/courseinfo/college/{$folder['itemid']}.html";
							?>
							<li class="danke sort<?=$folder['sid']?>" style="margin-left:11px; _margin-left:2px;height:225px;margin-right:9px;">
								<div class="danke2s"><span class="spne" style="height:25px;font-size:14px"><a target="_blank" href="<?= $folderurl ?>" title="<?= $folder['foldername']?>"><?= shortstr($folder['foldername'],16,'')?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
									<div style="clear:both;"></div>
									<?php if(empty($folder['cannotpay'])){?>
										<div class="showimg">
											<?php if(!empty($folder['ptype'])) { ?>
												<a target="_blank" href="<?= $folderurl ?>" title="<?= $folder['foldername'] ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a>
											<?php } else { ?>
												<a href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a>
											<?php } ?>
										</div>
									<?php }else{?>
										<div class="showimg"><a href="javascript:;" style="cursor:default" title="点击立即开通"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
									<?php }?>

									<?php if(!empty($folder['ptype'])) { ?>
									<div class="showimg" style="*top:30px;">
										<?php } else { ?>
										<div class="piaoyin" style="*top:30px;<?=empty($folder['cannotpay'])?'background:url(http://static.ebanhui.com/ebh/tpl/default/images/buy-black2.png)':'background:url(http://static.ebanhui.com/ebh/tpl/default/images/diceng_1.png?v=20160412001)'?>">
											<?php } ?>

											<?php if(empty($folder['cannotpay'])){
												if ($folder['iprice'] == 0 || !empty($folder['isschoolfree']) && !empty($userin)) {
													$btn_img = 'http://static.ebanhui.com/ebh/tpl/default/images/free-btn.png';
													if ($roominfo['crid'] == $appsetting['szlz'])
														$btn_img = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/szlzfree.png';
													if (!empty($vis_sorts[$folder['sid']]['showbysort'])) {
														$buy_url = '/ibuy.html?itemid='.$folder['itemid'];//geturl('courseinfo/college/'.$folder['itemid']);
														if ($folder['sid'] > 0) {
															$buy_url .= '&sid='.$folder['sid'];
														}
														$target = ' target="_blank"';
														if ($roominfo['domain'] == 'yxwl') {
															$buy_url = '/classactive/bank.html';
														}
													} else {
														$buy_url = 'javascript:;';
														$target = '';
													}
												} else {
													$btn_img = 'http://static.ebanhui.com/ebh/tpl/default/images/buy-btn.png';
													$buy_url = '/ibuy.html?itemid='.$folder['itemid'];//geturl('courseinfo/college/'.$folder['itemid']);
													if ($folder['sid'] > 0) {
														$buy_url .= '&sid='.$folder['sid'];
													}
													$target = ' target="_blank"';
													if ($roominfo['domain'] == 'yxwl') {
														$buy_url = '/classactive/bank.html';
													}
												}
												?>
												<?php if(empty($folder['ptype'])) { ?>
													<a href="<?= geturl('courseinfo/college/'.$folder['itemid']) ?>" target="_blank" title="点击立即开通" class="tuslick"></a>
													<a class="btnxlick btn" href="<?=$buy_url?>"<?=$target?> title="点击立即开通" itemid="<?=$folder['itemid']?>"><img width="70" height="70" src="<?=$btn_img?>" /></a>
												<?php } ?>
											<?php }else{?>
												<a href="javascript:void(0)" style="cursor:default" title="点击立即开通" class="tuslick"></a>
												<a class="btnxlick" href="javascript:void(0)" style="cursor:default" title="点击立即开通"></a>
												<a target="_blank" href="/courseinfo/college/<?=$folder['itemid']?>.html" class="sees">课程介绍</a>
											<?php }?>

										</div>
									</div>
							</li>
						<?php }
					}
					 ?>
					</div>
					<?php }?>

				</ul>
				</div>
	<?php }?>



		<div id="schsourceunopen" style="width:1000px; border:none;">
		</div>
            </div>
        </div>


</div>
	<div id="free-dialog" style="display:none">
		<div class="baoke">
			<img class="imgrts" src="" />
			<div class="suitrna">
				<h2></h2>
				<p class="p1"></p>
			</div>
			<div class="nasirte">
				<span class="titses">课程介绍</span>
				<div class="paewes"></div>
			</div>
			<div class="jduste">
			<?php if ($roominfo['crid'] != $appsetting['szlz']) {?>
				价格：<span class="cshortr">免费</span>
			<?php }?>
			</div>
		</div>
	</div>

</body>
<script>
	var surveyMessage = "<?= $roominfo['crid'] != $appsetting['szlz'] ? '为了更好的服务您，我们诚挚邀请您参与问卷调查，填写并提交成功便有机会获得礼物哦。':'为了更好的服务您，我们诚挚邀请您参与问卷调查，填写并提交成功便能观看精彩视频！' ?>";
	var buyFreeTitle = "<?= $roominfo['crid'] != $appsetting['szlz'] ? '报名':'信息提醒' ?>";
	var buyFreeAttend = "<?= $roominfo['crid'] != $appsetting['szlz'] ? '报名':'去观看' ?>";
	// (function($) {
    var surveyId = <?=!empty($survey_id) ? intval($survey_id) : '0' ?>;
		function getSingleItem(itemid, callback) {
			$.ajax({
				'url' : '/room/portfolio/ajax_check_userpermisions.html',
				'type': 'post',
				'dataType': 'json',
				'data': { 'itemid': itemid },
				'success': function(d) {
					if (d.errno > 0) {
						alert(d.msg)
						return;
					}
					if (typeof(callback) == 'function') {
						callback(d.data.item);
					}
				}
			});
		}
		function buyFreeItem(item,iscw) {
			if (item == null) {
				return;
			}
			$.logArg = item.itemid;
			if (item.url) {
				location.href = item.url;
				return;
			}
			var freeWindow = top.dialog({
				id: 'free-window',
				title: buyFreeTitle,
				fixed: true,
				content: $("#free-dialog").html(),
				padding: 20,
				onshow: function() {
					var box = $(this.node);
					box.find('.ui-dialog2-footer').css('text-align', 'right');
					box.find('img.imgrts').attr('src', item.showimg);
					box.find('div.suitrna h2').html(item.iname);
					box.find('div.suitrna p.p1').html(item.crname);
					box.find('div.nasirte div.paewes').html(item.summary);
				},
				okValue: buyFreeAttend,
				ok: function() {
					if(!iscw){
						var itemid = [];
						if (item['group_members']) {
							$.each(item['group_members'], function(index, ob) {
								itemid.push(ob.itemid);
							});
						} else {
							itemid.push(item.itemid);
						}
						var postdata = { 'itemid': itemid, 'totalfee': 0};
					}else{
						var postdata = { 'cwid':item.cwid,'totalfee':0}
					}
					$.ajax({
						url: '/ibuy/bpay.html',
						type: 'post',
						data: postdata,
						dataType: 'json',
						success: function(ret) {
							if (ret.status == '0') {
								alert('报名失败,请重试');
							}
							//有开通服务后问卷则跳转
							if(ret.surveysid){
								var oUrl = "/survey/"+ret.surveysid+".html";
								top.location.href = oUrl;
                              	return;
                            }
							//报名成功后进入学习页面
							location.reload();
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {

				}
			});
			freeWindow.showModal();
		}
		function surveyDialog(returnUrl) {
            var surveyWindow = top.dialog({
                id:'survey',
                title:'信息提示',
                fixed:true,
                content: surveyMessage,
                okValue: '确定',
                width: 300,
                ok: function() {
                    if (returnUrl != 'javascript:;') {
                        var url = "/survey/"+surveyId+".html?return=" + encodeURIComponent(returnUrl);
                        var a = $("<a href='"+url+"' target='_blank'>ebh</a>").get(0);
                        if (document.createEvent) {
                            var e = document.createEvent('MouseEvents');
                            e.initEvent( 'click', true, true );
                            a.dispatchEvent(e);
                        }
                        a.click();
                    } else {
                        var url = "/survey/"+surveyId+".html?return=blank";
                        var a = $("<a href='"+url+"' target='_blank'>ebh</a>").get(0);
                        if (document.createEvent) {
                            var e = document.createEvent('MouseEvents');
                            e.initEvent( 'click', true, true );
                            a.dispatchEvent(e);
                        }
                        a.click();
                    }
                },
                cancelValue: '取消',
                cancel: function() {

                }
            });
            surveyWindow.showModal();
        }
		$('a.btnxlick').bind('click', function(e) {
			var that;
			if (e.target.nodeName.toLowerCase() == 'img') {
				that = $(e.target).parent('a');
			} else {
				that = $(this);
			}
			if (that.hasClass('survey')) {
			    if (that.attr('href') == 'javascript:;') {
                    $.ajax({
                        'url': '/room/portfolio/ajax_check_surveryed.html',
                        'type': 'post',
                        'dataType': 'text',
                        'success': function(ret) {
                            if (ret != '0') {
                                surveyDialog(that.attr('href'));
                                return;
                            }
                            getSingleItem(that.attr('itemid'), buyFreeItem);
                        }
                    });
			        return false;
                }
                surveyDialog(that.attr('href'));
			    return false;
            }
			if (that.attr('href') == 'javascript:;') {
				getSingleItem(that.attr('itemid'), buyFreeItem);
			}
		});
	// })(jQuery);
$('.more,.xialas').mouseover(function(){
	$('.xialas').show();
});
$('.more,.xialas').mouseout(function(){
	$('.xialas').hide();
});
$(function(){
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();

	var url = '<?= geturl('myroom/userstate/folder')?>';
	var type = 6;
	var folderids = '<?=empty($folderids)?'':$folderids?>';
	if (folderids != '')
	{
		$.ajax({
			type:'POST',
			url:url,
			data:{"type":type,'folderids':folderids},
			dataType:"json",
			success:function(data) {
				$.each(data,function(k,v){
					if (v.count > 99) {
						v.count = 99;
					}
					$('#folder'+v.folderid).append('<span class="coursetishi">'+v.count+'</span>');
				});
			}
		});
	}

	<?php if($allclear && $roominfo['domain']=='zjgxedu'){?>
		if(top.showallclear != undefined){
			top.showallclear();
		}
	<?php }?>


	if($('.slider-container').width()<960)
		$('.pagination .next').addClass('disabled');

	<?php if($roominfo['isschool'] == 7){?>
		getSchsource();
	<?php }?>
	$('.nsearchtext').trigger('keyup');
});
$(document).on('keyup','.nsearchtext',function(){
	var searchtext = $.trim($('.nsearchtext').val());
	$('.studycourse li').show();
	$('.studycourse ul').css('padding-bottom','10px');
	$('.other_room_tit').show();
	var cflag = false;
	if(searchtext == '' || searchtext == '请输入关键字'){

	} else {
		$('.studycourse li').hide();
		$('.studycourse ul').css('padding-bottom','0');
		$('.other_room_tit').hide();
		$.each($('.studycourse li .danke2s-1s>a,.studycourse li .danke2s-1>a'),function(){
			var ttitle = $(this).attr('title');
			if(ttitle.indexOf(searchtext) == -1){
				return true;
			}
			cflag = true;
			$(this).parents('li').show();
			$(this).parents('ul').css('padding-bottom','10px');

			$(this).parents('.studycourse').find('.other_room_tit').show();

		});
	}
}).on('click','.nsearchbtn',function(){
	$('.nsearchtext').trigger('keyup');
}).on('focus','.nsearchtext',function(){
	var searchtext = $.trim($('.nsearchtext').val());
	if(searchtext == '请输入关键字'){
		$('.nsearchtext').val('');
		$('.nsearchtext').css('color','#323232');
	}
}).on('blur','.nsearchtext',function(){
	var searchtext = $.trim($('.nsearchtext').val());
	if(searchtext == '' || searchtext == '请输入关键字'){
		$('.nsearchtext').val('请输入关键字');
		$('.nsearchtext').css('color','#A5A5A5');
	}
})

$('.packagetab').click(function(){
	$('.packatab').removeClass('packatab');
	$(this).addClass('packatab');
	//var subheight = window.document.body.scrollHeight;
	//console.log(subheight)
	resetheight();
	//parent.resetmain();
});
function showpackage(pid, sid){
	$('.package').hide();
    $('.package li').hide();
    $('.package'+pid).show();
	if (sid === undefined) {

    } else {
        $('.package'+pid).show();
        $('a.saitemsort').removeClass('csur').hide();
        $("a.saitemsort[spid='"+pid+"']").show();
        $("a.saitemsort[ssid='"+sid+"']").addClass('csur');
        if (sid < 0) {
            $('.package'+pid+' li').show();
            return;
        }
        $('.package'+pid+' li.sort'+sid).show();
    }
}
$("div.sort-panel").bind('click', function(e) {
   var node = e.target.nodeName.toLowerCase();
   if (node == 'a') {
       var t = $(e.target);
       var pid = t.attr('spid');
       var sid = t.attr('ssid');
       $('a.saitemsort').removeClass('csur');
       $("a.saitemsort[ssid='"+sid+"']").addClass('csur');
       if (sid == -1) {
           $('.package'+pid+' li').show();
           resetheight();

           //parent.resetmain();
           return;
       }
       $('.package'+pid+' li').hide();
       $('.package'+pid+' li.sort'+sid).show();
       resetheight();
       //parent.resetmain();
   }
});

var track = $(".slider-container").silverTrack();
var theparent = track.container.parents(".track");

// 左右箭头
track.install(new SilverTrack.Plugins.Navigator({
  prev: $("a.prev", theparent),
  next: $("a.next", theparent)
}));
track.start();


function paycw(cwid){
	var payurl = '/ibuy.html?cwid='+cwid;
	var cprice;
	var cw;
	$.ajax({
		url:'/myroom/college/getcwpaydetail.html',
		data:{'cwid':cwid},
		dataType:'json',
		async:false,
		success:function(data){
			cprice = data.cprice;
			cw = data;
		}
	})
	if(cw){
		if(cprice == 0)
			buyFreeItem(cw,true);
		else
			window.open(payurl);
	}
}
$("a.removebtn.survey").bind('click', function() {
    var that = $(this);
    if (that.attr('price') == 0) {
        $.ajax({
            'url': '/room/portfolio/ajax_check_surveryed.html',
            'type': 'post',
            'dataType': 'text',
            'success': function(ret) {
                if (ret != '0') {
                    surveyDialog(that.attr('href'));
                    return;
                }
                paycw(that.attr('cwid'));
            }
        });
        return;
    }
    var surveyWindow = top.dialog({
        id:'survey',
        title:'信息提示',
        fixed:true,
        content: surveyMessage,
        okValue: '确定',
        width: 300,
        ok: function() {
            if (that.attr('price') > 0) {
                var url = "/survey/"+surveyId+".html?return=" + encodeURIComponent('/ibuy.html?cwid='+that.attr('cwid'));
                var a = $("<a href='"+url+"' target='_blank'>ebh</a>").get(0);
                if (document.createEvent) {
                    var e = document.createEvent('MouseEvents');
                    e.initEvent( 'click', true, true );
                    a.dispatchEvent(e);
                }

                a.click();
            } else {
                var url = "/survey/"+surveyId+".html?return=blank";
                var a = $("<a href='"+url+"' target='_blank'>ebh</a>").get(0);
                if (document.createEvent) {
                    var e = document.createEvent('MouseEvents');
                    e.initEvent( 'click', true, true );
                    a.dispatchEvent(e);
                }

                a.click();
            }
        },
        cancelValue: '取消',
        cancel: function() {

        }
    });
    surveyWindow.showModal();
   return false;
});
<?php if($roominfo['isschool'] == 7){?>
function getSchsource(){
	$.ajax({
		url:'/college/schsource.html?d='+Math.random(),
		type:'GET',
		success:function(data){
			$('#schsourceunopen').html(data);
            $('#schsourceunopen .kejian').after('<div class="clear"></div>')
			resetheight();
			//top.resetmain();
		}
	});
}
<?php }?>
//修复学习中心高度读取不到bug
function resetheight(){
	var totalheight = 0;
	//学习中心高度
	var newCour     = $('.jijiangkk').length > 0? parseInt($('.jijiangkk').get(0).offsetHeight):0;
	var studyheight = $('.study') ?  parseInt($('.study').get(0).offsetHeight):0;
	//课件高度
	var kejianheight = 0;
	$(".kejian").each(function(kejian){
		var hh = $(this).get(0).offsetHeight
		kejianheight+=hh;
		});
	totalheight =  kejianheight+studyheight+50+newCour;

	top.resetmain(totalheight);
}
//定时器作为修正使用,防止重复刷新页面没有加载完成
var timer = setTimeout(function(){
	resetheight();
	},500)



</script>
<?php $this->display('myroom/page_footer'); ?>