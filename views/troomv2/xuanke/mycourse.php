
<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
<style type="text/css">
    a.btn-base{
        border-radius: 4px;
        color:#fff;
        font-size: 14px;
        padding: 3px 16px;
        text-decoration: none;
    }
    a.sign-remove{
        background-color: #FF0000;
    }
    a.sign-modify{
        background-color: #4E8CF1;
    }
    a.report-btn{
        background-color: #4E8CF1;
    }
</style>
<div>
    <div class="lefrig lefrig1s">
        <h2 class="sizrer"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
        <div class="kostrds kostrds1s">
            <ul>
                <li class="fklisr"><a href="/troomv2/xuanke/msglist.html?aid=<?=$aid?>" class="wursk">选课动态</a></li>
                <li class="fklisr"><a href="/troomv2/xuanke/mycourse.html?aid=<?=$aid?>" class="wursk botsder">我的选课</a></li>
                <li class="fklisr"><a class="wursk " href="/troomv2/xuanke/signresult.html?aid=<?=$aid?>">报名结果</a></li>
            </ul>
        </div>
        <?php if (!empty($courses)) {
            foreach ($courses as $course) { ?>
                <div class="course-unit"><a href="#c<?=$course['cid']?>" name="c<?=$course['cid']?>"></a>
        <p class="kclbtitle">课程名称：<span class="textkcjs"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></span></p>
        <p class="kclbtitle" style="padding-top:0;">课程介绍：<span class="textkcjs"><?=htmlspecialchars($course['introduce'], ENT_NOQUOTES)?></span></p>
            <?php if(empty($course['images']) === false && is_array($course['images'])): ?>
        <div class="kclbtitle" style="padding-top:5px;">
                <div class="fl"><span>课程图片：</span></div>
                <div class="xklbtp fl" style="margin-left:0;">
                    <ul id="layer-photos-demo">
                            <?php foreach($course['images'] as $thumb => $image): ?>
                                <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                            <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="clear"></div>
        <p class="kclbtitle kclbtitle1s">上课日期：<span class="textkcjs"><?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?></span></p>
        <p class="kclbtitle kclbtitle1s"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：<span class="textkcjs"><?=empty($course['ap']) ? $timeRange[0] : $timeRange[$course['ap']]?></span></p>
        <p class="kclbtitle kclbtitle1s">上课时间：<span class="textkcjs"><?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?></span></p>
        <p class="kclbtitle kclbtitle1s">上课地点：<span class="textkcjs"><?=htmlspecialchars($course['place'], ENT_NOQUOTES)?></span></p>
        <p class="kclbtitle kclbtitle1s">选课人员：<span class="textkcjs"><?=$course['range']?></span></p>
        <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?=$course['classnum']?></span><span class="textkcjs"> 人</span></p>
                <div style="padding:20px;"><?php if ($activity['status'] == 1 && $activity['starttime'] <= SYSTIME && $activity['endtime'] >= SYSTIME) { ?><a class="btn-base sign-remove" href="javascript:;" rel="<?=$course['cid']?>">删除</a>
                    <a class="btn-base sign-modify" href="/troomv2/xuanke/report.html?xkid=<?=$course['xkid']?>&cid=<?=$course['cid']?>&t=1">修改</a><?php } ?>
                    <a class="btn-base report-btn" href="/troomv2/xuanke/signresult.html?aid=<?=$course['xkid']?>&cid=<?=$course['cid']?>">报名结果</a>
                </div></div>
            <?php }} else { ?>
            <div class="nodata"></div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        parent.window.prev($('.xklbtplist.fl a'));
        $("a.sign-remove").bind('click', function() {
            var coursename = 'xx';
            var t = $(this);
            top.dialog({
                title: '信息提示',
                content: '<div class="sckj1s" style="padding:0"><div class="xzkctsxx" style="">确定要删除课程吗？</div></div>',
                id: 'dialog-config',
                fixed: true,
                'okValue': '确定',
                'ok': function() {
                    $.ajax({
                        'url': '/troomv2/xuanke/ajax_remove_course.html',
                        'type': 'post',
                        'data': { 'cid' : t.attr('rel') },
                        'dataType': 'json',
                        'success': function(ret) {
                            if (ret.errno > 0) {
                                top.dialog({
                                    skin:"ui-dialog2-tip",
                                    content:"<div class='FPic'></div><p>"+(ret.msg||"删除课程失败")+"</p>",
                                    width:350,
                                    onshow:function () {
                                        var that=this;
                                        setTimeout(function () {
                                            that.close().remove();
                                        }, 2000);
                                    }
                                }).showModal();
                                return;
                            }
                            $(t.parents('div.course-unit')).remove();
                            parent.window.resetmain();
                        }
                    });
                },
                'cancelValue': '取消',
                'cancel': function () {

                }
            }).showModal();
        });
    })(jQuery);

</script>
<?php $this->display('troomv2/page_footer'); ?>