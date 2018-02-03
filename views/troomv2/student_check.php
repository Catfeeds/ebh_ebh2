<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
    当前位置 > <a href="<?= geturl('troomv2/student') ?>">学员管理</a> > 学员审核
</div>
<div class="lefrig">
    
    <div class="annotate">在此页面中,教师可对申请加入您教室的学员进行管理.</div>
    <div class="work_menuss">
        <ul>
            <li style="margin-left:45px;"><a href="<?= geturl('troomv2/student') ?>"><span>所有学员</span></a></li>
            <li class="workcurrent"><a href="<?= geturl('troomv2/student/check') ?>"><span>学员审核</span></a></li>
            <li ><a href="<?= geturl('troomv2/student/opencount') ?>"><span>开通统计</span></a></li>				
        </ul>
    </div>
    <div class="annuato">
        <span style="float:left;line-height:23px;">关键字：</span>
       
        <input type="text" name="search" value="<?= $q ?>" id="searchvalue" style="width:350px;" class="shurulan">
        <input class="souhuang" id="searchbutton" type="button" name="searchbutton" value="搜 索" />
        <div class="tiezitool">
            <a class="hongbtn jiabgbtn" href="<?= geturl('troomv2/student/add') ?>">添加学员</a>
        </div>
    </div>
    <form id="applyform">
        <table class="datatab" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="tabhead">
                <th width="5%"></th>
                <th>姓名</th>
                <th>电子邮箱</th>
                <th>手机</th>
                <th>QQ</th>
                <th>留言</th>
            </tr>

            <?php if (!empty($applys)) { ?>
                <?php
                foreach ($applys as $apply) {
                    $info = empty($apply['message']) ? '' : unserialize($apply['message']);
                    ?>
                    <tr>
                        <td><input type="checkbox" class="apply" name="apply[]" value="<?= $apply['applyid'] ?>" /></td>
                        <td width="85px;"><?= $apply['realname'] ?></td>
                        <td><?= $apply['email'] ?></td>
                        <td><?= $apply['phone'] ?></td>
                        <td><?= $apply['qq'] ?></td>
                        <td><?= empty($info['applyremarks']) ? '' : $info['applyremarks'] ?></td>
                    </tr>

    <?php } ?>
                <tr>
                    <td><input name="" align="bottom" onclick="checkall(this, 'apply')" type="checkbox" value="" /></td>
                    <td colspan="6">
                        <input type="radio" id="rdioagree" name="agree" class="rdio" checked value="1" />同意
                        <input type="radio" id="rdiorefuse" name="agree" class="rdio" value="-1" />拒绝
                        <input class="saveBtn" type="button" style="cursor:pointer;" value="提交"/>
                    </td>
                </tr>

            <?php } else { ?>
                <tr><td align="center" colspan="7">暂无数据</td></tr>
<?php } ?>
        </table>
        <input type="hidden" id="refuse_msg" name="refuse_msg" />
        <div id='msgbox' style="display: none;">
            <div id="layer">
                <div class="layer_body">
                <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
                <td align="center"><textarea cols="50" rows="5" id="themsg"></textarea></td>
                <tr><td colspan="2" style="padding-top:5px; padding-left:12px; color:#666666;">温馨提示：请输入你的拒绝理由，方便学生查看拒绝信息</td></tr>
                </table></div>
            </div>
        </div>
    </form>
    <?= $pagestr ?>
</div>
<script type="text/javascript">
<!--
    function checkall(obj, classname) {
        var clickdo = $(obj);
        if (clickdo.attr('checked') == 'checked') {
            $("." + classname).attr('checked', 'checked');
        } else {
            $("." + classname).removeAttr('checked');
        }
    }
    function submitapply() {
        var url = "<?= geturl('troomv2/student/check') ?>";
        $.ajax({
            url: url,
            type: 'post',
            data: $("#applyform").serialize(),
            dataType: 'text',
            success: function(data) {
                if (data == 'success') {
                    $.showmessage({
                        img: 'success',
                        message: '批量审核成功',
                        title: '学员批量审核信息 接受',
                        callback: function() {
                            location.reload();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: '批量审核失败',
                        title: '学员批量审核信息 接受'
                    });
                }
            }
        });
    }
    $(function() {
        $('#searchbutton').click(function() {
            var href = '<?= geturl('troomv2/student/check') ?>';
            var searchvalue = $("#searchvalue").val();
            if (searchvalue == '请输入学员帐号') {
                searchvalue = '';
            }
            href += "?q=" + searchvalue;
            location.href = href;
        });
        $(".datebox :text").attr("readonly", "readonly");
        $(".saveBtn").click(function() {
            if ($(".apply:checked").length == 0) {
                alert("请选择要操作的学员！");
                return;
            }
            ;
            if ($("#rdiorefuse").attr("checked") == "checked") {
                //showheard();
                submitapply();
            } else {
                submitapply();
            }
        });
    });
    function close() {
        $('#msgbox').dialog("close");
    }
    function showheard()
    {
        buttons = {"取消": function() {
                $(this).dialog("close");
            }, "确定": function() {
                $("#refuse_msg").val($("#themsg").val());
                submitapply();
            }};
        $('#msgbox').dialog({
            autoOpen: false,
            title: '请输入拒绝理由',
            buttons: buttons,
            width: 360,
            resizable: false,
            type: 'post',
            modal: true//模式对话框
        });
        $('#msgbox').dialog("open");
    }
</script>
<?php $this->display('troomv2/page_footer'); ?>