<?php $this->display('myroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160415001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css"/>
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
            <span class="jieraee" style="color:#666;line-height:32px;"><?=date('Y-m-d', $rule['start_t'])?> 至 <?=date('Y-m-d', $rule['end_t'])?></span>
        </p>
        <p class="juersde jwwid" style="line-height:24px;"><span class="jiwrese">课程规则：</span><?=htmlspecialchars($rule['remark'], ENT_NOQUOTES)?></p>
        <p class="newdsre">
            <span class="jiwrese">课程列表：</span>
        </p>
    </div>
    <?php if(isset($courselist) === true && is_array($courselist) === true): ?>
        <?php foreach($courselist as $course): ?>
            <div class="jiweaes">
                <?php if(isset($course['signed']) === true && $course['signed'] === true): ?>
                    <a href="javascript:;" class="qusrfe" rel="<?=$course['cid']?>">取消报名</a>					
                <?php elseif(isset($course['signed_finish']) === true && $course['signed_finish'] === true): ?>
                    <a href="javascript:;" class="huisea meym1s">已成功报名</a>
                <?php elseif($course['status'] == 2 || $step == 1 && $course['classapplynum'] <= $course['studentsnum'] || $step == 2 && $course['classnum'] <= $course['studentsnum']): ?>			
                    <a href="javascript:;" class="huisea meym1s" style="cursor:default;text-decoration:none;">名额已满</a>
                <?php elseif($valid === true): ?>
                    <a href="javascript:;" class="lanseasre" rel="<?=$course['cid']?>">报 名</a>
                <?php endif; ?>
                <p class="jierses jwwid acount">
                    <span class="huersw"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></span>
                    <span class="jieraee">教师：<?=htmlspecialchars($course['realname'], ENT_NOQUOTES)?></span>
                    <?php if($step == 2): ?><span class="jieraee cl" title="报名名额：<?=$course['classnum']?>，已报名人数：<?=$course['studentsnum']?>">名额：<span class="chencolor cc"><?=$course['studentsnum']?>/<?=$course['classnum']?></span></span><?php endif; ?>
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
    <?php else: ?>
        <div style="text-align:center;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/zanwujilu3.png" /></div>
    <?php endif; ?>

</div>
<script type="text/javascript">
    (function($) {
        var step = <?=$step?>;
        parent.window.prev($('a.uewrdse'))
        var xkid=<?=$activity['xkid']?>;
        $("#bt-action").bind("click", function(e){
           var node = e.target.nodeName.toLowerCase();
            if(node !== 'a') {
                return;
            }
            var oTarget = $(e.target);
            if(oTarget.hasClass('lanseasre')) {
                var coursename = $(oTarget.next('p.jierses')).find('span.huersw').html();
                parent.window.dialogConfig('报名《'+coursename+'》课程？', function() {
                    $.ajax({
                        'url':'/myroom/xuanke/ajax_sign.html',
                        'type':'POST',
                        'dataType':'json',
                        'data':{'cid':oTarget.attr('rel'), 'xkid':xkid},
                        'success':function(d) {
                            if(d.errno == 0) {
                                oTarget.html("取消报名").addClass("qusrfe").removeClass("lanseasre");
                                if(step > 1) {
                                    changedate(oTarget, 1);
                                }
                                return;
                            }

                            if(d.errno == 2) {
                                oTarget.html("名额已满").addClass("huisea").removeClass("lanseasre");
                            }

                            parent.window.showMsg(d.msg);
                        }
                    });
                });

                return;
            }
            if(oTarget.hasClass('qusrfe')) {
                var coursename = $(oTarget.next('p.jierses')).find('span.huersw').html();
                parent.window.dialogConfig('取消报名《'+coursename+'》课程？', function() {
                    $.ajax({
                        'url':'/myroom/xuanke/ajax_cancel_sign.html',
                        'type':'POST',
                        'dataType':'json',
                        'data':{'cid':oTarget.attr('rel'), 'xkid':xkid},
                        'success':function(d) {
                            if(d.errno == 0) {
                                oTarget.html("报 名").addClass("lanseasre").removeClass("qusrfe");
                                if(step > 1) {
                                    changedate(oTarget,-1);
                                }
                                return;
                            }
                            var d = dialog({
                                title: '信息提示',
                                content: '<div style="text-align:center;padding:1em 2em;font-size:14px;">取消报名失败</div>',
                                id:'alert',
                                width:400,
                                height:100,
                                padding:0,
                                fixed:true,
                                quickClose:true
                            });
                            d.show();
                            setTimeout(function () {
                                d.close().remove();
                            }, 2000);
                        }
                    });
                });
            }
        });
        function changedate(oTarget,step) {
            var number_show = $(oTarget.next('p.acount'));
            var cl = number_show.find('span.cl');
            var cc = number_show.find('span.cc');
            var ac = cc.html().split('/');
            ac[0] = parseInt(ac[0]) + parseInt(step);
            cl.attr("title","报名名额："+ac[1]+"，已报名人数："+ac[0]);
            cc.html(ac.join('/'));
        }
    })(jQuery);
</script>
<?php $this->display('myroom/page_footer'); ?>
