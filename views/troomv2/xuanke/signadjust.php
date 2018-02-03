<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>
<style type="text/css">
    .allson {
        overflow: hidden;
        padding-bottom: 20px;
        width: 975px;
        float: left;
    }
    .allson li {
        display: inline;
        float: left;
    }
    a.courseall {
        color: #666;
        display: inline-block;
        font-size: 15px;
        margin: 15px 15px 0;
    }
    a.courseall:hover, a.courseall.onhover {
        color: #338bff;
    }
</style>
<?php if($step == 1): ?>
    <div id="step1">
        <div class="crightbottom" style="width:1000px;margin-top:0;">
            <div class="xktitles"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></div>
            <div class="wctzbtn">完成调整</div>
            <?php if(!empty($courses)) { ?><div class="allson">
                <ul>
                    <?php foreach ($courses as $item) { ?>
                        <li><a class="courseall<?php if ($item['cid'] == $course['cid']) { echo ' onhover'; } ?>" href="/troomv2/xuanke/signadjust.html?step=<?=$step?>&cid=<?=$item['cid']?>&xkid=<?=$item['xkid']?>"><?=$item['coursename']?></a></li>
                    <?php } ?></ul>
                </div>
            <?php }?>
            <p class="kclbtitle">课程介绍：<span class="textkcjs"><?=htmlspecialchars($course['introduce'], ENT_NOQUOTES)?></span></p>
            <div class="xklbtp">
                <ul>
                    <?php if(isset($course['images']) === true && is_array($course['images'])): ?>
                    <?php foreach($course['images'] as $thumb => $image):?>
                    <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="clear"></div>
            <p class="kclbtitle" style="*padding-top:8px;">上课日期：<span class="textkcjs"><?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?></span></p>
            <p class="kclbtitle kclbtitle1s"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：<span class="textkcjs"><?=empty($course['ap']) ? $timeRange[0] : $timeRange[$course['ap']]?></span></p>
            <p class="kclbtitle kclbtitle1s">上课时间：<span class="textkcjs"><?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?></span></p>
            <p class="kclbtitle kclbtitle1s">上课地点：<span class="textkcjs"><?=htmlspecialchars($course['place'], ENT_NOQUOTES)?></span></p>
            <p class="kclbtitle kclbtitle1s">选课人员：<span class="textkcjs"><?=$course['range']?></span></p>
            <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?=$course['classnum']?></span><span class="textkcjs"> 人</span></p>
            <p class="kclbtitle kclbtitle1s">报名情况：<span class="textkcjs" style="color:#ff3c00;" id="sc"><?=$students_count?></span><span class="textkcjs"> 人</span></p>
            <table cellpadding="0" cellspacing="0" class="bmlist" style="width:1000px;">
                <?php if($students_count > 0): ?>
                <tr class="zwnr1s">
                    <td colspan="3" style="padding:0"></td>
                    <td style="padding:0;padding-left:6px;"><a href="#" class="tzdel del-all">一键删除</a></td>                 
                </tr>
                <?php endif; ?>
                <tr class="bmlistfir">
                    <td width="250">学生信息</td>
                    <td width="297">所属班级</td>
                    <td width="299">报名时间</td>
                    <td width="106">操作</td>
                </tr>
                <?php if($students_count > 0): ?>
                    <?php foreach($students as $index=>$student):?>
                        <tr<?php if($students_count == $index + 1):?> class="last"<?php endif; ?>>
                            <td>
                                <div class="fl"><input type="checkbox" class="xuanze" d="<?=$student['uid']?>" /></div>
                                <div style="float:left;padding:0 10px;">
                                    <a href="javascript:;"><img class="touxyuan" width="50" height="50" src="<?=getavater($student,'50_50')?>"></a>
                                </div>
                                <div style="width:95px;float:left;">
                                    <span class="renming" title="<?=htmlspecialchars($student['realname'], ENT_COMPAT)?>"><?=htmlspecialchars($this->showName($student['realname'], $student['username']), ENT_NOQUOTES)?></span>
                                    <span class="<?php if($student['sex'] == 0): ?>xingbie1<?php else: ?>xingbie<?php endif; ?>"></span>
                                    <div style="clear:both;"></div>
                                    <span class="renming1"><?=htmlspecialchars($student['username'], ENT_NOQUOTES)?></span>
                                </div>
                            </td>
                            <td style="text-align:center;"><?=htmlspecialchars($student['classname'], ENT_NOQUOTES)?></td>
                            <td style="text-align:center;"><?=!empty($student['sign_time']) ? date('Y-m-d H:i', $student['sign_time']) : '--'?></td>
                            <td><a href="#" class="tzdel del-one" rel="<?=$student['uid']?>">删除</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="last zwnr1s">
                        <td colspan="4" style="text-align:center; border:none"><div class="nodata"></div></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        (function($) {
            (function($) {
                parent.window.prev($('.xklbtplist.fl a'));
            })(jQuery);
            var courseId = <?=$course['cid']?>;
            var xkId = <?=$course['xkid']?>;
           $("#step1").bind("click", function(e) {
               var oTarget = $(e.target);
               var node = e.target.nodeName.toLowerCase();
               if(node == "a") {
                    if(oTarget.hasClass("del-all")) {
                        if($("input.xuanze:checked").size() == 0) {
                            dialog({
                                skin:"ui-dialog2-tip",
                                content:"<div class='PPic'></div><p>请选择要删除的学生</p>",
                                width:350,
                                onshow:function () {
                                    var that=this;
                                    setTimeout(function () {
                                        that.close().remove();
                                    }, 2000);
                                }
                            }).show();
                            return;
                        }
                        parent.window.deleteXkStudent(function(msg){
                            if(msg.length == 0) {
                                msg = '由于名额限制或其他原因，报名失败';
                            }
                            var uids = [];
                            $("input:checked").each(function() {
                                uids.push($(this).attr('d'));
                            });
                            if(uids.length == 0) {
                                return;
                            }
                            var data = {
                                'failmsg':msg,
                                'uid':uids,
                                'xkid':xkId,
                                'cid':courseId
                            };
                            $.ajax({
                                'url':'/troomv2/xuanke/ajax_delete_student.html',
                                'type':'POST',
                                'dataType':'json',
                                'data':data,
                                'success':function(d) {
                                    if(d.errno == 0) {
                                        $("input:checked").parents('tr').remove();
                                        var rl = $(".bmlist tr").size() - 2;
                                        $("#sc").html(rl);
                                        if(rl == 0) {
                                            $(".bmlist").append('<tr class="last"><td colspan="4" style="text-align:center;"><div class="nodata"></div></td></tr>');
                                            oTarget.hide();
                                        } else {
                                            $("table.bmlist tr:last-child").addClass("last");
                                        }

                                        parent.window.resetmain();
                                        dialog({
                                            skin:"ui-dialog2-tip",
                                            content:"<div class='TPic'></div><p>删除成功</p>",
                                            width:350,
                                            onshow:function () {
                                                var that=this;
                                                setTimeout(function () {
                                                    that.close().remove();
                                                }, 2000);
                                            }
                                        }).show();
                                        location.reload();
                                        $("input.xuanze").removeAttr('checked');
                                        return;
                                    }
                                    dialog({
                                        skin:"ui-dialog2-tip",
                                        content:"<div class='FPic'></div><p>"+d.msg+"</p>",
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
                        return;
                    }
                    if(oTarget.hasClass("del-one")) {
                        parent.window.deleteXkStudent(function(msg) {
                            if(msg.length == 0) {
                                msg = '由于名额限制或其他原因，报名失败';
                            }
                            var data = {
                                'failmsg':msg,
                                'uid':oTarget.attr('rel'),
                                'xkid':xkId,
                                'cid':courseId
                            };
                            $.ajax({
                                'url':'/troomv2/xuanke/ajax_delete_student.html',
                                'type':'POST',
                                'dataType':'json',
                                'data':data,
                                'success':function(d) {
                                    if(d.errno == 0) {
                                        oTarget.parents('tr').remove();
                                        var rl = $(".bmlist tr").size() - 2;
                                        $("#sc").html(rl);
                                        if(rl == 0) {
                                            $("a.del-all").hide();
                                            $(".bmlist").append('<tr class="last"><td colspan="4" style="text-align:center;"><div class="nodata"></div></td></tr>');
                                        } else {
                                            $("table.bmlist tr:last-child").addClass("last");
                                        }
                                        parent.window.resetmain();
                                        dialog({
                                            skin:"ui-dialog2-tip",
                                            content:"<div class='TPic'></div><p>删除成功</p>",
                                            width:350,
                                            onshow:function () {
                                                var that=this;
                                                setTimeout(function () {
                                                    that.close().remove();
                                                }, 2000);
                                            }
                                        }).show();
                                        return;
                                    }
                                    dialog({
                                        skin:"ui-dialog2-tip",
                                        content:"<div class='FPic'></div><p>"+d.msg+"</p>",
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
                        return;
                    }
               }
               if(node == "div" && oTarget.hasClass("wctzbtn")) {
                   //完成调整
                   location.href="/troomv2/xuanke/msglist.html?aid=<?=$xkid?>";
                   return;
               }

               if(node == "input" && oTarget.hasClass("xuanze")) {
                   if(oTarget.attr('checked')) {
                       oTarget.parents('tr').addClass('xuanzehover');
                   } else {
                       oTarget.parents('tr').removeClass('xuanzehover');
                   }
                   return;
               }
           });
        })(jQuery);
    </script>
<?php else: ?>
    <?php
    $grade_arr = array(
        0   => '其它班级',
        1   => '一年级',
        2   => '二年级',
        3   => '三年级',
        4   => '四年级',
        5   => '五年级',
        6   => '六年级',
        7   => '初一',
        8   => '初二',
        9   => '初三',
        10  => '高一',
        11  => '高二',
        12  => '高三'
    );
    ?>
    <div id="step2">
        <div class="crightbottom" style="width:1000px;margin-top:0;">
            <div class="xktitles"><?=htmlspecialchars(shortstr($course['coursename'],70), ENT_NOQUOTES)?></div>
            <div class="wctzbtn">完成调整</div>
            <p class="kclbtitle">课程介绍：<span class="textkcjs"><?=htmlspecialchars($course['introduce'], ENT_NOQUOTES)?></span></p>
            <div class="xklbtp">
                <ul>
                    <?php if(isset($course['images']) === true && is_array($course['images']) === true): ?>
                    <?php foreach($course['images'] as $thumb => $image):?>
                        <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="clear"></div>
            <p class="kclbtitle" style="*padding-top:8px;">上课日期：<span class="textkcjs"><?=date('Y-m-d', $course['starttime'])?> 至 <?=date('Y-m-d', $course['endtime'])?></span></p>
            <p class="kclbtitle kclbtitle1s"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：<span class="textkcjs"><?=empty($course['ap']) ? $timeRange[0] : $timeRange[$course['ap']]?></span></p>
            <p class="kclbtitle kclbtitle1s">上课时间：<span class="textkcjs"><?=htmlspecialchars($course['classtime'], ENT_NOQUOTES)?></span></p>
            <p class="kclbtitle kclbtitle1s">上课地点：<span class="textkcjs"><?=htmlspecialchars($course['place'], ENT_NOQUOTES)?></span></p>
            <p class="kclbtitle kclbtitle1s">选课人员：<span class="textkcjs"><?=$course['range']?></span></p>
            <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?=$course['classnum']?></span><span class="textkcjs"> 人</span></p>
            <p class="kclbtitle kclbtitle1s">报名情况：<span class="textkcjs" style="color:#ff3c00;"><?=$students_count?></span><span class="textkcjs"> 人</span></p>
            <div class="hdjsckanbtn"><?php if($course['classnum'] > $students_count): ?><a href="#" class="tzdel tzadd">添加学生</a><?php else: ?>　<?php endif; ?></div>
            <div class="clear"></div>
            <table cellpadding="0" cellspacing="0" class="bmlist">
                <tr class="bmlistfir">
                    <td width="201" style="text-align:left; padding-left:45px;">学生信息</td>
                    <td width="364">所属班级</td>
                    <td width="185">报名时间</td>
                </tr>
                <?php if($students_count > 0): ?>
                <?php foreach($students as $index=>$student):?>
                <tr<?php if($students_count == $index + 1):?> class="last"<?php endif; ?>>
                    <td>
                        <div style="float:left;padding-left:20px;padding-right:10px;">
                            <a href="javascript:;"><img width="50" height="50" class="touxyuan" src="<?=getavater($student,'50_50')?>"></a>
                        </div>
                        <div style="width:105px;float:left;">
                            <span class="renming" title="<?=htmlspecialchars($student['realname'], ENT_COMPAT)?>"><?=htmlspecialchars($this->showName($student['realname'], $student['username']), ENT_NOQUOTES)?></span>
                            <span class="<?php if($student['sex'] == 0): ?>xingbie1<?php else: ?>xingbie<?php endif; ?>"></span>
                            <div style="clear:both;"></div>
                            <span class="renming1"><?=htmlspecialchars($student['username'], ENT_NOQUOTES)?></span>
                        </div>
                    </td>
                    <td style="text-align:center;"><?=htmlspecialchars($student['classname'], ENT_NOQUOTES)?></td>
                    <td style="text-align:center;"><?=!empty($student['sign_time']) ? date('Y-m-d H:i', $student['sign_time']) : '--'?></td>
                </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="last zwnr1s">
                        <td colspan="3" style="text-align:center;border:none;"><div class="nodata"></div></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <div id="filterDialog" class="taneret" style="height:500px;display:none">
        <div class="xzxstck">
            <div class="xzxstcktop">
                <div class="xzxstckleft">
                    <div class="dile1s">
                        <input type="text" class="newsou1s" placeholder="请输入姓名" id="s-keyword" style="width:120px;" />
                        <input type="button" class="soulico1s" />
                    </div><div style="height:1em;clear:both"></div>
                    <div class="qbxsabjnj">
                        <?php foreach($grade_class as $k => $item): ?>
                            <div class="qbxs2 grade" d="<?=$k?>" lab="<?=$grade_arr[$k]?>">
                                <span class="fl qbxs1span"><?=$grade_arr[$k]?></span>
                                <a href="javascript:void(0)" class="fr mt5 xuanzq grade"></a>
                            </div>
                            <?php foreach($item as $sub): ?>
                                <div class="qbxs3 class" p="<?=$k?>" d="<?=$sub['classid']?>" lab="<?=htmlspecialchars($sub['classname'], ENT_COMPAT)?>" style="display:none;">
                                    <span class="fl qbxs3-lab" title="<?=htmlspecialchars($sub['classname'], ENT_COMPAT)?>"><?=htmlspecialchars(substr_ext($sub['classname'], 0, 8,'utf-8'), ENT_NOQUOTES) ?></span>
                                    <a href="javascript:void(0)" class="fr mt5 xuanzq class"></a>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="xzxstckright">
                    <div class="xzxslist">
                        <ul id="filter-ajax-students">
                            <!--<li class="fl t-student grade0 class1">
                                <div class="t-student"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/rtx.jpg" /></div>
                                <p class="xingmingl t-student">曲则全</p>
                                <?php /*if(false): */?>
                                <a href="#" class="t-student fr xuanzq1s onhover" ></a>
                                <?php /*endif; */?>
                            </li>-->
                        </ul>
                    </div>
                    <p style="clear:both;text-align:center;margin-top:1em;margin-bottom:1em;"><a href="javascript:;" class="jzgds" style="display:none;">加载更多...</a></p>
                </div>
                <div class="clear"></div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        (function($) {
            var filterType = <?=$course['range_type']?>;
            var xkid = <?=$xkid?>;
            var cid = <?=$course['cid']?>;

            parent.window.init($("#filterDialog"), 'filterDialog', 1, cid);


            $("#step2").bind("click", function(e) {
                var oTarget = $(e.target);
                var node = e.target.nodeName.toLowerCase();
                if(node == "a") {
                    if(oTarget.hasClass("tzadd")) {
                        parent.window.filterStudentWindow('添加学生', 0, null, function(retValue) {
                            $.ajax({
                               'url':'/troomv2/xuanke/ajax_add_students.html',
                                'type':'POST',
                                'data':{'uid':retValue,'cid':cid,'xkid':xkid},
                                'dataType':'json',
                                'success':function(d) {
                                   if(d.errno == 0|| d.errno == 1) {
                                        dialog({
                                            skin:"ui-dialog2-tip",
                                            content:"<div class='TPic'></div><p>"+d.msg+"</p>",
                                            width:350,
                                            onshow:function () {
                                                var that=this;
                                                setTimeout(function() {
                                                    location.reload();
                                                    that.close().remove();
                                                }, 1000);
                                            }
                                        }).show();
                                        return;
                                   }
                                }
                            });
                        }, function(){});
                        return;
                    }
                }
                if(node == "div" && oTarget.hasClass("wctzbtn")) {
                    //完成调整
                    location.href="/troomv2/xuanke/msglist.html?aid=<?=$xkid?>";
                    return;
                }
            });
        })(jQuery);
    </script>
<?php endif; ?>
<script type="text/javascript">
    (function($) {
        parent.window.prev($('.xklbtplist.fl a'));
    })(jQuery);

</script>
<?php $this->display('troomv2/page_footer'); ?>
