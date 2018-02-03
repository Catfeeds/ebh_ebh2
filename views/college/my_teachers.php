<?php $this->display('college/page_header'); ?>
<?php $this->widget('sendmessage_widget'); ?>
<style type="text/css">
    a:link{text-decoration: none;}
    a:visited{text-decoration: none;}
    a:hover{text-decoration: none;}
    a:active{text-decoration: none;}
    div.myclasstitle{padding:3em 7em 2em 7em;line-height:1.4em;}
    div.pages{width:805px;margin:0 auto;float:inherit;text-align:center;}
    div.pages div.listPage{margin:0 auto;}
    div.pages div.listPage a{float:inherit;display:inline-block;}
    a.followed{color:#666}
    a.hrelh.sendsx{background:none; height:auto; margin-top:0; color:#5b96f0;}
</style>
<div class="lefrig xglefrig">
	<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
		<ul>
			 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span><?=$roominfo['property'] == 3?'我的部门':'我的班级'?></span></a></li>
		</ul>
	</div>
    <div class="myclass">
        <div class="myclasstitle"><?=htmlspecialchars($myclass['classname'], ENT_NOQUOTES)?></div>
        <div class="myclassviews">
            <div class="myclasstop">
                <div class="myclasstleft">
                    <a href="/college/myclass.html" class="clastudents"><?=$roominfo['property'] == 3?'部门同事':'班级同学'?></a>
                    <a href="javascript:;" class="clastudents onhover"><?=$roominfo['property'] == 3?'部门讲师':'班级教师'?></a>
                </div>
                <?php if(!empty($change_info)) { ?><a href="javascript:;" class="suresend" id="operate">自主升班</a><?php } ?>
            </div>
            <div class="clear"></div>
            <table cellpadding="0" cellspacing="0" class="myclasstable" id="list-table">
                <tbody>
                <tr>
                    <th width="27%" style="text-align:left;padding-left:60px;">个人信息</th>
                    <th width="28%">邮箱</th>
                    <th width="25%">电话</th>
                    <th width="20%">操作</th>
                </tr>
                <?php if (!empty($teachers)) {
                    foreach ($teachers as $teacher) {
                        ?>
                        <tr>
                            <td>
                                <div style="float:left;padding:0 10px;">
                                    <a href="javascript:;"><img class="touxyuan" src="<?=getavater($teacher,'50_50')?>"></a>
                                </div>
                                <div style="width:125px;float:left;">
                                    <span class="renming"><?=htmlspecialchars(shortstr($teacher['realname'], 8), ENT_NOQUOTES)?></span>
                                    <span class="xingbie"<?php if($teacher['sex'] == 0) {?> style="background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png')"<?php } ?>></span>
                                    <div style="clear:both;"></div>
                                    <span class="renming1"><?=shortstr($teacher['username'], 20)?></span>
                                </div>
                            </td>
                            <td><?php if (!empty($teacher['email'])) { echo $teacher['email'];} ?></td>
                            <td><?php if (!empty($teacher['mobile'])) { echo $teacher['mobile']; } ?></td>
                            <td data-id="<?=$teacher['uid']?>">
                                <a class="hrelh sendsx" tid="<?=$teacher['uid']?>" tname="<?=htmlspecialchars($teacher['username'], ENT_COMPAT)?>" href="javascript:;">发私信</a>
                                <a class="sendsx ml20 o-follow<?php if(!empty($teacher['followed'])) { echo ' followed'; }?>" href="javascript:;"><?=(empty($teacher['followed']) ? "加关注" : "已关注")?></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="4">
                            <div class="nodata"></div>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <?=$pagestr?>
        </div>

    </div>
</div>
<!--弹出框-->
<?php if(!empty($change_info)) { ?>
    <div style="display:none;" id="choseclass">
        <div class="choseclass" style="max-height:400px;overflow-x: hidden;overflow-y:auto;padding:20px 30px;">
            <?php foreach ($change_info['classes'] as $classitem) {?>
                <a href="javascript:;" class="directsbj" data-d="<?=$classitem['classid']?>" title="<?=htmlspecialchars($classitem['classname'], ENT_COMPAT)?>"><?=htmlspecialchars($classitem['classname'], ENT_NOQUOTES)?></a>
            <?php }?>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    (function($) {
        var classid=<?=!empty($change_info) ? $change_info['sourceid'] : $myclass['classid']?>;
        var changelogid = <?=!empty($change_info) ? $change_info['classid'] : 0 ?>;
        //处理关注
        $('#list-table').bind('click', function(e) {
            var node = e.target.nodeName.toLowerCase();
            if (node == 'a') {
                var target = $(e.target);
                if (target.hasClass('o-follow')) {
                    var isToActioned = target.html() == '加关注';
                    if (!isToActioned) {
                        return false;
                    }
                    var action = '/college/myclass/ajax_follow.html';
                    $.ajax({
                        'url' : action,
                        'type' : 'post',
                        'data' : {'fuid':target.parent('td').data('id')},
                        'dataType' : 'json',
                        'success' : function(d) {
                            if(d.errno > 0) {
                                return false;
                            }
                            if (isToActioned) {
                                target.html('已关注');
                                target.addClass('followed');
                                parent.refreshFollowNum();
                            } else {
                                target.html('加关注');
                            }
                        }
                    });
                    return false;
                }
            }
        });
        <?php if(!empty($change_info)) { ?>
        var dialogHtml = $("#choseclass").html();
        $("#operate").bind('click', function() {
            var d = top.dialog({
                title:"选择班级",
                content:dialogHtml,
                onshow:function(){
                    var i=$('<span style="font-size:12px;color:#999;">（请务必正确选择，否则将影响后续正常学习）</span>');
                    $(this.node).find(".ui-dialog2-title").append(i);
                    $(this.node).find('.ui-dialog2-content').bind('click', function(e) {
                        var target = $(e.target);
                        if (!target.hasClass('directsbj')) {
                            return;
                        }
                        $(this).find('a.onhover').removeClass('onhover');
                        target.addClass('onhover');
                    });
                },
                padding:0,
                okValue:"确定",
                cancelValue:"取消",
                ok:function(){
                    var o = $(this.node).find('a.onhover');
                    if (o.length > 0) {
                        var toid = o.eq(0).data('d');
                        if (toid == classid) {
                            return false;
                        }
                        $.ajax({
                            'url':'/college/myclass/ajax_change_class.html',
                            'type':'post',
                            'dataType':'json',
                            'data':{'sourceid':classid,'classid':toid, 'changelogid':changelogid},
                            'success':function(d) {
                                if (d.errno > 0) {
                                    var dia = top.dialog({
                                        content: d.msg,
                                        okValue:"确定",
                                        ok:function() {}
                                    });
                                    dia.showModal();
                                    setTimeout(function () {
                                        dia.close().remove();
                                    }, 2000);
                                    return false;
                                }
                                document.location.href='/college/myclass.html';
                            }
                        });
                    }
                },
                cancel:function(){},
            });
            d.showModal();
        });
        <?php } ?>
    })(jQuery);
</script>
<?php $this->display('myroom/page_footer'); ?>
