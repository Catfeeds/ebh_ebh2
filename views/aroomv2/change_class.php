<?php $this->display('aroomv2/page_header'); ?>
<style type="text/css">
    a:link{text-decoration: none}
    a:visited{text-decoration: none}
    a:hover{text-decoration: none}
    a:active{text-decoration: none}
    #time-range{display:none;}
    input.adclinput{width:10em;}
    a.addnewclass{padding-top:17px;}
</style>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/classes/student.html">班级学生</a> > <a href="/aroomv2/classes.html">班级管理</a> > 升班级
    </div>
    <div class="twoclass">
        <form id="form" method="post">
        <div class="shclass">
            <span class="yclass fl">原班级：&nbsp;</span>
            <span class="yclass1s fl"><input type="hidden" name="sourceid" value="<?=$class['classid']?>" /><input type="hidden" name="pid" value="<?=$r_pid?>" /><?=htmlspecialchars($class['classname'], ENT_NOQUOTES)?></span>
        </div>
        <div class="shclass mt20">
            <span class="yclass fl">升班级方式：&nbsp;</span>
            <div class="yclass1s fl">
                <div id="operate-type">
                    <a href="javascript:;" style="width:89px;" class="directsbj<?php if($r_ctype != 2) {echo ' onhover';}?>">直接升班</a>
                    <a href="javascript:;" style="width:89px;" class="directsbj ml30 self<?php if($r_ctype == 2) {echo ' onhover';}?>">自主升班</a>
                    <input type="hidden" name="ctype" value="<?=$r_ctype?>" />
                </div>
                <div class="clear"></div>
                <!--分情况显示-->
                <p class="sbts" id="sbts"><?=$r_ctype == 1 ? '直接将某班级的学生全部升至指定班级' : '在规定的时间内由学生自己选择管理员指定的若干班级中的一个班级'?></p>
            </div>
        </div>
        <div class="shclass" style="margin-top:8px;">
            <span class="yclass fl" style="margin-top:12px;">新班级：&nbsp;</span>
            <div class="yclass1s fl">
                <div class="huisre">
                    <ul id="wrap">
                        <?php if($r_ctype == 1 && $r_classid > 0) { ?>
                            <li class="lantewu"><input type="hidden" value="<?=$r_classid?>" name="classid" /><a class="languan" href="javascript:;" data-id="<?=$r_classid?>" data-name="<?=htmlspecialchars($r_classname, ENT_COMPAT)?>"></a><?=htmlspecialchars($r_classname, ENT_NOQUOTES)?></li>
                        <?php } else {
                            foreach ($r_class_arr as $classitem) {?>
                                <li class="lantewu"><input type="hidden" value="<?=$classitem['classid']?>" name="classids[]" /><a class="languan" href="javascript:;" data-id="<?=$classitem['classid']?>" data-name="<?=htmlspecialchars($classitem['classname'], ENT_COMPAT)?>"></a><?=htmlspecialchars($classitem['classname'], ENT_NOQUOTES)?></li>
                                <?php
                            }
                        } ?>
                        <li class="add-btn"><a href="javascript:;" class="addnewclass">添加</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="shclass mt20" id="time-range"<?php if($r_ctype == 2) { echo " style='display:block;'";}?>>
            <span class="yclass fl">选班时间：&nbsp;</span>
            <div class="yclass1s fl">
                <input name="starttime" type="text" class="adclinput fl"<?php if($r_ctype == 1) { ?> disabled="disabled"<?php } ?> value="<?=$r_starttime?>" />
                <span class="fl adclspan">至</span>
                <input name="endtime" type="text" class="adclinput fl"<?php if($r_ctype == 1) { ?> disabled="disabled"<?php } ?> value="<?=$r_endtime?>" />
                <div class="clear"></div>
                <p class="sbts">学生只能在指定的时间内操作</p>
            </div>
        </div>
        <a href="javascript:;" class="suresend" id="btn-post">确定并发送通知</a>
        </form>
    </div>
</div>

<div id="choseclass" style="display:none;">
    <div class="choseclass" style="max-height:400px;overflow-x:hidden;overflow-y:auto;padding:20px 30px;">
    <?php if (!empty($classes)) {
        foreach ($classes as $classitem) {
            $active = !empty($r_class_arr) && key_exists($classitem['classid'], $r_class_arr);
            ?>
        <a href="javascript:;" class="directsbj<?=$active ? ' onhover' : ''?>" d="<?=$classitem['classid']?>" title="<?=htmlspecialchars($classitem['classname'], ENT_COMPAT)?>"><?=htmlspecialchars($classitem['classname'], ENT_NOQUOTES)?></a>
            <?php
        }
    } ?>
</div>
</div>
<script type="text/javascript">
    (function($) {
        var backurl = document.referrer||'/aroomv2/classes.html';
        if (!(/\/aroomv2\/classes.html/.test(backurl))) {
            backurl = '/aroomv2/classes.html';
        }
        var pid = <?=$r_pid?>;
        var ctype = <?=$r_ctype?>;//直接升班:1，自主升班:2
        $("input.adclinput.fl").bind('focus', function() {
            WdatePicker({
                'readOnly':true,
                'dateFmt':'yyyy-MM-dd HH:mm',
                'isShowClear':true
            });
        });
        var dialogHtml = $("#choseclass");
        $("#operate-type").bind('click', function(e) {
            if (pid > 0) {
                return false;
            }
            if (e.target.nodeName.toLowerCase() == 'a') {
                var btn = $(e.target);
                if (btn.hasClass('onhover')) {
                    return false;
                }
                var timeRange = $("#time-range");
                btn.addClass('onhover');
                btn.siblings('a').removeClass('onhover');
                $("#wrap li.lantewu").remove();
                if (btn.hasClass('self')) {
                    $("input.adclinput.fl").removeAttr('disabled').val('');
                    timeRange.show();
                    $("#sbts").html('在规定的时间内由学生自己选择管理员指定的若干班级中的一个班级');
                    ctype = 2;
                } else {
                    $("input.adclinput.fl").attr('disabled', 'disabled');
                    timeRange.hide();
                    $("#sbts").html('直接将某班级的学生全部升至指定班级');
                    ctype = 1;
                }
                dialogHtml.find('a.onhover').removeClass('onhover');
                $("input[name='ctype']").val(ctype);
            }
            return false;
        });

        $("#wrap").bind('click', function(e) {
            if (e.target.nodeName.toLowerCase() != 'a') {
                return false;
            }
            var target = $(e.target);
            if(target.hasClass('addnewclass')) {
                var d = top.dialog({
                title:"选择升班班级",
                content:dialogHtml.html(),
                onshow:function(){
                    var that = this;
                    $(this.node).find('.ui-dialog2-content').bind('click', function(e) {
                        var target = $(e.target);
                        if (!target.hasClass('directsbj')) {
                            return;
                        }
                        if (ctype == 2) {
                            if (target.hasClass('onhover')) {
                                target.removeClass('onhover');
                            } else {
                                target.addClass('onhover');
                            }
                            return;
                        }

                        if (ctype == 1) {
                            $(this).find('a.onhover').removeClass('onhover');
                            target.addClass('onhover');
                            that.close();
                            that.ok();
                            return;
                        }
                    });
                },
                padding:0,
                okValue:"确定",
                cancelValue:"取消",
                ok:function(){
                    var selected = [];
                    var o = null;
                    dialogHtml = $(this.node).find('.ui-dialog2-content');
                    $("#wrap li.lantewu").remove();
                    $(this.node).find('a.onhover').each(function() {
                        selected.push({
                            'classid':$(this).attr('d'),
                            'classname':$(this).html()
                        });
                    });
                    var selectedLen = selected.length;
                    if (ctype == 1 && selectedLen > 0) {
                        o = selected[0];
                        target.parent('li').before('<li class="lantewu"><input type="hidden" value="'+o.classid+'" name="classid" /><a class="languan" href="javascript:;" data-id="'+o.classid+'" data-name="'+o.classname+'"></a>'+o.classname+'</li>');
                        o = null;
                        return;
                    }
                    for (var i = 0; i < selectedLen; i++) {
                        o = selected[i];
                        target.parent('li').before('<li class="lantewu"><input type="hidden" value="'+o.classid+'" name="classids[]" /><a class="languan" href="javascript:;" data-id="'+o.classid+'" data-name="'+o.classname+'"></a>'+o.classname+'</li>');
                    }
                    o = null;
                },
                cancel:function(){},
            });
            d.showModal();
            return false;
        }
            if(target.hasClass('languan')) {
                var removeId = target.data('id');
                dialogHtml.find('a.onhover').each(function() {
                    if ($(this).attr('d') == removeId) {
                        $(this).removeClass('onhover');
                    }
                });
                target.parent('li').remove();
            }
            return false;
        });

        $("#btn-post").bind('click', function() {
            if ($("li.lantewu").size() == 0) {
                alert("请选择目标班级");
                return false;
            }
            if (ctype == 2 && ($("input[name='starttime']").val() == '' || $("input[name='endtime']").val() == '')) {
                alert("日期设置错误");
                return false;
            }
            var data = $("#form").serialize();
            var callok = function() {};
            var dia = top.dialog({
                cancel: false,
                width:200,
                okValue:'确定',
                ok:function(){callok();},
                onshow:function(){
                    $(this.node).find('button').hide();
                }
            });

            $.ajax({
                'url':'/aroomv2/changeclass.html',
                'type':'post',
                'dataType':'json',
                'data':data,
                'success':function(d) {
                    var okbutton = $(dia.node).find("button[i-id='ok']");
                    if (d.errno > 0) {
                        okbutton.val('确定');
                        if (d.errno == 7) {
                            dia.title('升班设置失败');
                            dia.content('无修改项，升班设置失败');
                            okbutton.show();
                            return;
                        }

                        dia.title('升班设置失败');
                        dia.content(d.msg);
                        okbutton.show();
                        return;
                    }

                    dia.title('升班设置成功');
                    dia.content('2秒钟后返回班级管理页面');

                    okbutton.val('直接跳转');
                    callok = function() {
                        $("#btn-post").attr('disabled', 'disabled');
                        document.location.href=backurl;
                    };
                    okbutton.show();

                    setTimeout(function () {
                        document.location.href=backurl;
                    }, 2000);

                },
                'error':function() {
                    dia.content('网络异常，设置失败');
                    var okbutton = $(dia.node).find("button[i-id='ok']");
                    okbutton.val('确定');
                    okbutton.show();
                },
                'beforeSend': function() {
                    dia.showModal();
                }
            });
            return false;
            //$("#form").submit();
        });
    })(jQuery);
</script>
<?php $this->display('aroomv2/page_footer'); ?>
