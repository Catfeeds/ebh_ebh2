<?php $this->display('aroomv2/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

<style>
    .kefens {
        width: 100%;
        height: 50px;
    }
    .kefens_lef {
        float:left;
        font-size: 16px;
        margin-left: 20px;
        height: 50px;
        line-height: 50px;
    }
    a.kefens_act {
        margin-right: 10px;
        border: solid 1px #cdcdcd;
        padding: 3px 10px;
        float: left;
        margin-top: 12px;
        color: #444;
    }
    a.activer {
        background: #4280fc;
        color: #fff;
    }
</style>
<body>
<div class="">
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        >
        <a href="/aroomv2/xuanke.html">选课系统</a>
        >
        <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xuanke['xkid']?>">查看</a>
        >
        <span>查看申报课程</span>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs" style="min-height: 627px;">
        <h2 class="sizrer" title="<?=htmlspecialchars($xuanke['name'], ENT_COMPAT)?>"><?php echo htmlspecialchars(shortstr($xuanke['name'],50), ENT_NOQUOTES)?></h2>
        <div class="kostrds">
            <ul>
                <li class="fklisr"><a href="reportcourse.html?xkid=<?php echo $xuanke['xkid']?>" class="wursk">课程列表</a></li>
                <li class="fklisr"><a href="" class="wursk botsder">课程设置</a></li>
            </ul>
        </div>
        <div class="kefens">
            <span class="kefens_lef"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：</span>
            <a href="/aroomv2/xuanke/course_set.html?xkid=<?=$xuanke['xkid']?>" class="kefens_act<?=!isset($ap) ? ' activer':''?>">全部</a>
            <?php foreach ($timeRange as $rk => $rv) { ?><a class="kefens_act<?=isset($ap) && $ap == $rk ? ' activer':''?>" href="/aroomv2/xuanke/course_set.html?xkid=<?=$xuanke['xkid']?>&ap=<?=$rk?>"><?=$rv?></a><?php }?>
        </div>

        <?php if(!empty($courselist)){ foreach($courselist as $course){?>
        <div class="jiweaes">
            <p class="juierse">
                <?php echo shortstr($course['coursename'],70)?><span class="nuetde">教师：<?php echo empty($course['realname'])?$course['username']:$course['realname']?></span>
            </p>
            <p class="jierset">上课日期：<span class="njuiers"><?php echo date('Y-m-d',$course['starttime'])?> 至 <?php echo date('Y-m-d',$course['endtime'])?></span></p>
			<div class="jierset" style="height: auto">
			<span class="fl"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：</span><span class="nerfdr" href="javascript:;"><?=$timeRange[$course['ap']]?></span>
			</div>
            <p class="jierset">上课时间：<span class="njuiers"><?php echo $course['classtime']?></span></p>
            <p class="jierset">上课地点：<span class="njuiers"><?php echo $course['place']?></span></p>
            <div class="jierset" style="height: auto">
                <div class="fl" style="width:80px;"><span class="fl">选课限制：</span></div>
                <div class="fl" style="width:645px;"><?php if(!empty($course['rangemsg'])){foreach($course['rangemsg'] as $v){?>
                <span class="nerfdr"><?php echo $v?></span>
                <?php }}else{?>
                    <span class="nerfdr">全校学生</span>
                <?php }?>
				</div>
            </div>
			<div class="clear"></div>
            <p class="jierset">名额限制：<span class="njuiers"><?php echo $course['classnum']?>人</span></p>
        </div>
        <?php } ?>
            <?php if(!empty($pagestr)) {?><?=$pagestr?><?php  } ?>
            <?php }else{?>
            <div class="nodata"></div>
        <?php }?>
    </div>
</div>
</body>
<script>
$(function(){
		$('.jiweaes:last').css('border-bottom','none');
	});
</script>
</html>
