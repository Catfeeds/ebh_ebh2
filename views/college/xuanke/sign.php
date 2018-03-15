<?php $this->display('college/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
<style type="text/css">
    .ui-dialog-footer{
        padding:20px;
    }
    .ui-dialog-footer .ui-dialog-button{
        text-align:center;
        float:inherit !important;
    }
	a.meym1s:hover{
		cursor:default;
		text-decoration:none;
	}
	.jiweaes{
		padding-bottom:8px;
	}
</style>
<div class="busehir" id="bt-action">
    <h2 class="sizrers"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></h2>
    <div class="jiweaes">
        <p class="jierses jwwid">
            <span class="huersw" style="margin-right:0;"><?php if($step == 1):?>第一轮<?php else: ?>第二轮<?php endif; ?>选课日期：</span>
            <span class="jieraee" style="color:#666;line-height:32px;"><?=date('Y-m-d H:i', $rule['start_t'])?> 至 <?=date('Y-m-d H:i', $rule['end_t'])?></span>
        </p>
        <p class="juersde jwwid" style="line-height:24px;"><span class="jiwrese">选课规则：</span><?=htmlspecialchars($rule['remark'], ENT_NOQUOTES)?></p>
        <p class="newdsre">
            <span class="jiwrese">课程列表：</span><a class="jisere<?php if(!isset($ap)) {?> chenfse<?php } ?>" href="/college/xuanke/sign.html?xkid=<?=$activity['xkid']?>">全部</a><?php foreach ($timeRange as $rk => $rv) {?><a class="jisere<?php if(isset($ap) && $ap == $rk) {?> chenfse<?php } ?>" href="/college/xuanke/sign.html?xkid=<?=$activity['xkid']?>&ap=<?=$rk?>"><?=$rv?></a><?php } ?>
        </p>
    </div>
    <?php if(isset($courselist) === true && is_array($courselist) === true): ?>
        <?php foreach($courselist as $course): ?>
            <div class="jiweaes">
                <?php if(isset($course['signed']) === true && $course['signed'] === true): ?>
                    <a href="javascript:;" <?php if ($course['sign_type'] == 2 || !empty($activity['ispause'])) { ?>class="huisea qusrfe" style="cursor:default;text-decoration:none;"<?php } else { ?>class="qusrfe"<?php } ?> rel="<?=$course['cid']?>">取消报名</a>
                <?php elseif(isset($course['signed_finish']) === true && $course['signed_finish'] === true): ?>
                    <a href="javascript:;" class="huisea meym1s">已成功报名</a>
                <?php elseif($course['status'] == 2 || $course['classnum'] <= $course['studentsnum']): ?>
                    <a href="javascript:;" class="huisea meym1s" style="cursor:default;text-decoration:none;">名额已满</a>
                <?php elseif($valid === true): ?>
                    <a href="javascript:;" <?php if (in_array($course['ap'], $aps)) { ?>class="huisea lanseasre" style="cursor:default;text-decoration:none;background-color:#e7e7e7;color:#999;"<?php } else { ?>class="lanseasre"<?php } ?> rel="<?=$course['cid']?>">报 名</a>
                <?php endif; ?>
                <p class="jierses jwwid acount">
                    <span class="huersw"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></span>
                    <span class="jieraee">教师：<?=htmlspecialchars($course['realname'], ENT_NOQUOTES)?></span>
                    <span class="jieraee cl" title="报名名额：<?=$course['classnum']?><?php if ($activity['status'] == 3 && $rule['start_t'] <= SYSTIME || $activity['status'] > 3) { ?>，已报名人数：<?=$course['studentsnum']?><?php } ?>">名额：<span class="chencolor cc"><?php if ($activity['status'] == 3 && $rule['start_t'] <= SYSTIME || $activity['status'] > 3) { ?><?=$course['studentsnum']?>/<?php } ?><?=$course['classnum']?></span></span>
                </p>
                <p class="juersde jwwid"><span class="jiwrese">课程介绍：</span><span style="float: left;white-space: normal;width: 860px;line-height:24px;"><?=htmlspecialchars($course['introduce'], ENT_NOQUOTES)?><span></p>
                <?php if(isset($course['images']) === true && is_array($course['images']) === true): ?>
                <?php foreach($course['images'] as $thumb => $image): ?>
                    <a class="uewrdse" href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;"></a>
                <?php endforeach; ?>
                <?php endif; ?>
                <p class="newdsre" style="word-break:break-all;">
                    上课日期：<?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?>&nbsp;&nbsp;|&nbsp;&nbsp;上课时间：<?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?>&nbsp;&nbsp;|&nbsp;&nbsp;上课地点：<?=htmlspecialchars($course['place'], ENT_NOQUOTES)?>
                </p>
            </div>
        <?php endforeach;?>
        <?php if (!empty($pagestr)): ?><?=$pagestr?><?php endif; ?>
    <?php else: ?>
        <div class="nodata"></div>
    <?php endif; ?>

</div>
<script type="text/javascript">
    (function($) {

        var step = <?=$step?>;
        /*parent.window.*/prev($('a.uewrdse'));
        var xkid=<?=$activity['xkid']?>;
        $("#bt-action").bind("click", function(e){
           var node = e.target.nodeName.toLowerCase();
            if(node !== 'a') {
                return;
            }
            var oTarget = $(e.target);
            if(oTarget.hasClass('lanseasre') && !oTarget.hasClass('huisea')) {
                var coursename = $(oTarget.next('p.jierses')).find('span.huersw').html();
                /*parent.window.*/dialogConfig('报名《'+coursename+'》课程？', function() {
                    $.ajax({
                        'url':'/college/xuanke/ajax_sign.html',
                        'type':'POST',
                        'dataType':'json',
                        'data':{'cid':oTarget.attr('rel'), 'xkid':xkid},
                        'success':function(d) {
                            if(d.errno == 0) {
                                oTarget.html("取消报名").addClass("qusrfe").removeClass("lanseasre");
                                /*parent.window.*/showConfigMsg('报名成功', function() {
                                    changedate(oTarget, 1);
                                });
                                return;
                            }
                            if(d.errno == 2) {
                                oTarget.html("名额已满").addClass("huisea").removeClass("lanseasre");
                            }
                            /*top.*/dialog({
                                skin:"ui-dialog2-tip",
                                content:"<div class='FPic'></div><p>"+d.msg+"</p>",
                                width:350,
                                onshow:function () {
                                    var that=this;
                                    setTimeout(function () {
                                        that.close().remove();
                                    }, 1000);
                                }
                            }).show();
                        }
                    });
                });

                return;
            }
            if(oTarget.hasClass('qusrfe') && !oTarget.hasClass('huisea')) {
                var coursename = $(oTarget.next('p.jierses')).find('span.huersw').html();
                /*parent.window.*/dialogConfig('取消报名《'+coursename+'》课程？', function() {
                    $.ajax({
                        'url':'/college/xuanke/ajax_cancel_sign.html',
                        'type':'POST',
                        'dataType':'json',
                        'data':{'cid':oTarget.attr('rel'), 'xkid':xkid},
                        'success':function(d) {
                            if(d.errno == 0) {
                                oTarget.html("报 名").addClass("lanseasre").removeClass("qusrfe");
                                changedate(oTarget,-1);
                                return;
                            }
                            /*top.*/dialog({
                                skin:"ui-dialog2-tip",
                                content:"<div class='FPic'></div><p>"+(d.msg||"取消报名失败")+"</p>",
                                width:350,
                                onshow:function () {
                                    var that=this;
                                    setTimeout(function () {
                                        that.close().remove();
                                    }, 2000);
                                }
                            }).show();
                        }
                    });
                });
            }
        });
        function changedate(oTarget,step) {
            location.reload();
            var number_show = $(oTarget.next('p.acount'));
            var cl = number_show.find('span.cl');
            var cc = number_show.find('span.cc');
            var ac = cc.html().split('/');
            ac[0] = parseInt(ac[0]) + parseInt(step);
            cl.attr("title","报名名额："+ac[1]+"，已报名人数："+ac[0]);
            cc.html(ac.join('/'));
        }
        //config
        function dialogConfig(msg, callback) {
            var d = dialog({
                title: '信息提示',
                content: '<div class="sckj1s" style="padding:0"><div class="xzkctsxx" style="">' + msg + '</div></div>',
                id: 'dialog-config',
                fixed: true,
                'okValue': '确定',
                'ok': callback,
                'cancelValue': '取消',
                'cancel': function () {

                }
            });
            d.showModal();
        }
        function showConfigMsg(msg, callback) {
            var d = dialog({
                title: '信息提示',
                content: '<div class="sckj1s" style="padding:0;width:200px;"><div class="xzkctsxx" style="width:200px">' + msg + '</div></div>',
                id: 'dialog-config',
                fixed: true,
                'okValue': '确定',
                'ok': callback,
                cancel:false
                //quickClose: true
            });
            d.showModal();
            setTimeout(function () {
                d.close().remove();
                callback();
            }, 2000);
        }
        function prev(jo) {
            jo.each(function () {
                $(this).lightBox();
            });
        }
    })(jQuery);
</script>
<?php $this->display('myroom/page_footer'); ?>
