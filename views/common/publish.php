<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css?v=2016041801" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css?v=2016040501" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2016040501"/>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$roominfo['crname']?></title>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
</head>
<style>
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
.nodata{
	margin: auto;
	width:960px;
}
</style>
<body style="background:#f9f9f9;">
<div class="topbar">
		<div class="top-bd clearfix">
            <div class="login-info">
			<?php 
			$crname = empty($roominfo) ? 'e板会' : $roominfo['crname'];
			?>
			<?php if(empty($user)){?>
			<span style="width:170px; ">您好 欢迎来到<?= $crname ?>！ </span>
			<?php if(empty($roominfo['domain']) || $roominfo['domain'] != 'victor') {?>
			<a href="javascript:tologin('/login.html?returnurl=__url__');">登录</a>
			<a href="javascript:toregister('/register.html?returnurl=__url__');">注册</a>
			<?php } ?>
			<?php }else{?>
			<span style="width:170px; ">您好 <?=$user['username']?> 欢迎来到<?= $crname ?>！ </span><a href="/logout.html">安全退出</a><a href="/" >首页</a>
			<?php }?>
			</div>
			
		</div>
	</div>
<!-- 新加头部 -->
<div class="banner" style="background:none;height:auto">
<?php
	$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
?>
</div>
<div class="clear"></div>
<?php 
	$navlib = Ebh::app()->lib('Navigator');
	$navlib->getnavigator();
?>
<!--修改网校发布内容为暂无内容---start--->
<?php if(true){ $fp=0;//男女比例默认为0,处理错误提示?>
	<div class="nodata""></div>
<?php }else{ ?>
<div class="krtgde">
	<div class="kfanstg" style="padding-bottom:20px;">
    	<h2 class="ketrds">Hi, 大家好，我是“<?=$roominfo['crname']?>”，非常幸运的在<?=$agestr?>前诞生并与您相遇</h2>
        <div class="rtuhst">
        	<span class="jetbst"></span>
        </div>
        <div class="kujets">
        	<img class="kehttu" src="http://static.ebanhui.com/ebh/tpl/2016/images/sithst.jpg" />
        </div>
		<?php $eventcount = 0;
		foreach($timearr as $date=>$event){$eventcount++;?>
        <div class="kujets">
        	<span class="krehte"><?=date('Y-m-d',$date)?></span>
            <span class="khettu"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/iterfate.jpg" /></span>
            <span class="khsttu"><?=$event?></span>
        </div>
		<?php }?>
        
        <div class="kujets" style="">
        	<span class="krehte">如今</span>
            <span class="khettu"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/iterfate1.jpg" /></span>
            <span class="khsttu descount" style="padding-top:18px">我已经拥有了<span class="hoastr"><?=$teachercount?></span>名优秀的讲师</span>
			<?php if(!empty($iacount)){?>
			<span class="khsttu descount"><span class="hoastr"><?=$iacount?></span>次轻松愉快地师生互动</span>
			<?php }?>
			<?php if(!empty($roominfo['coursenum'])){?>
            <span class="khsttu descount"><span class="hoastr"><?=$roominfo['coursenum']?></span>节精挑细选的优秀课程</span>
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
		
		
		
		<?php if(!empty($coursetoplist)){?>
        <div class="rtuhst">
        	<span class="jetbst"></span>
        </div>
        <h2 class="ketrds">我发现同学们最喜欢的课是：<span class="setelan">“<?=$coursetopstr?>”</span></h2>
        <div class="kreyde">
        	<ul>
				<?php foreach($coursetoplist as $k=>$course){?>
            	<li class="khrued">
                	<a <?=$roominfo['isschool']==7?'href="/platform.html" target="_blank"':'href="javascript:void(0)"'?> title="<?=$course['foldername']?>"><img style="width:114px;height:159px" src="<?=$course['img']?$course['img']:'http://static.ebanhui.com/ebh/images/nopic.jpg'?>" /></a>
                </li>
				<?php }?>
				<?php if(!empty($coursebottom)){?>
                <li class="khrued">
                	<a <?=$roominfo['isschool']==7?'href="/platform.html" target="_blank"':'href="javascript:void(0)"'?> title="<?=$coursebottom['foldername']?>"><img style="width:114px;height:159px" src="<?=$coursebottom['img']?$coursebottom['img']:'http://static.ebanhui.com/ebh/images/nopic.jpg'?>" /></a>
                </li>
                <li class="khsdtry">
                	<p class="masrbot">而 “<span class="setelan"><?=$coursebottom['foldername']?></span>” 好像受到了冷落了</p>
                    <p><span class="setelan"><?=$coursebottom['foldername']?>老师说：</span></p>
					<p>欢迎同学们多提意见和建议，我会努力改进的。</p>
                </li>
				<?php }?>
            </ul>
        </div>
		<?php }?>
		
		
        <div class="rtuhst">
        	<span class="jetbst"></span>
        </div>
        <div class="waists">
        	<div class="lefkst">
            	<div class="kettuda">
                	<img class="kehtty" src="http://static.ebanhui.com/ebh/tpl/2016/images/sithst.jpg" /><span class="lehts">通过学习，他们在不断的成长......</span>
                </div>
				<?php foreach($creditloglist as $k=>$cl){
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
                    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/tudyut<?=$k==count($creditloglist)-1?'2':'1'?>.jpg" />
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
				if(!empty($creditlist)){
					
				$clconfig = Ebh::app()->getConfig()->load('creditlevel');
				foreach($creditlist as $k=>$credit){
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
                    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/yuped<?=$k==count($creditlist)-1?'2':'1'?>.jpg" />
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
		
		<?php $fp = empty($femalepercent['femalepercent'])?0:$femalepercent['femalepercent'];
			$pstr = '你为你的阵营贡献了多少力量呢？';
			
		?>
		<h2 class="ketrds"><?=$pstr?></h2>
		<div class="kthrtb" style="margin-left:0">
			<div>
				<div class="nnbl">男女比例数</div>
				<div class="nnb2">男生</div>
				<div class="nnb3">女生</div>
				<div style="width:928px; margin-top:50px; position:relative;">
				<div class="zsline"><span><?=$sexpercent[0]?>%</span></div>
					<div class="zsline1"><span><?=$sexpercent[1]?>%</span></div>
					<?php 
						$moresex = ($sexpercent[0]>$sexpercent[1])?0:1;
						$sexpercent[$moresex] = round($sexpercent[$moresex],-1);
						$sexpercent[!$moresex] = 100 - $sexpercent[$moresex];
							
					?>
					<p class="sexqueue0" style="margin-left:110px;margin-right:10px;">
						<span class="sexqueuefull0" style="width:<?=$sexpercent[0]?>%;"></span>
					</p>
					<p class="sexqueue1">
						<span class="sexqueuefull1" style="width:<?=$sexpercent[1]?>%;"></span>
					</p>
					
				</div>
			</div>
			<div style="clear:both;"></div>
			<div style="margin-top:50px;">
				<div class="nnbl">学业勤奋度</div>
				<div class="nnb2">男生</div>
				<div class="nnb3">女生</div>
				<div style="width:928px; margin-top:50px; position:relative;">
					<div class="zsline"><span><?=$loginpercent[0]?>%</span></div>
					<div class="zsline1"><span><?=$loginpercent[1]?>%</span></div>
					<?php 
						$moresex = ($loginpercent[0]>$loginpercent[1])?0:1;
						$loginpercent[$moresex] = round($loginpercent[$moresex],-1);
						$loginpercent[!$moresex] = 100 - $loginpercent[$moresex];
					?>
					<p class="sexqueue2" style="margin-left:105px;margin-right:20px;">
						<span class="sexqueuefull2" style="width:<?=$loginpercent[0]?>%;"></span>
					</p>
					<p class="sexqueue3">
						<span class="sexqueuefull3" style="width:<?=$loginpercent[1]?>%;"></span>
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
<?php }?>
<!--修改网校发布内容为暂无内容---end--->
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->
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
            data: [<?php if(!empty($hourcountstr)){echo $hourcountstr;}else{echo 0;} ?>]
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

	var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}

</script>
<?php $this->display('common/footer');?>
