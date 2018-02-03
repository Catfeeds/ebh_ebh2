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

    #search-course{margin:0 auto 10px auto;width:805px;zoom:1}
    #search-course:after{
        clear: both;
        content: " ";
        display: block;
        height: 0;
        line-height: 0;
        visibility: hidden;}

    div.search-group{float:right;vertical-align: middle;display:block;}
    div.search-group .soulico {
        background: rgba(0, 0, 0, 0) url("http://static.ebanhui.com/ebh/tpl/newschoolindex/images/newsolico.jpg") no-repeat scroll left center;
        border: medium none;
        cursor: pointer;
        float: left;
        height: 28px;
        width: 23px;
    }
    div.search-group .newsou {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #dcdcdc -moz-use-text-color #dcdcdc #dcdcdc;
        border-image: none;
        border-radius: 2px 0 0 2px;
        border-style: solid none solid solid;
        border-width: 1px medium 1px 1px;
        color: #333;
        display: inline;
        float: left;
        font-family: 微软雅黑;
        font-size: 12px;
        height: 26px;
        line-height: 26px;
        padding: 0 6px;
        width: 164px;
        outline:0 none;
    }


    .statusorder-1 {
        float:left;
        position: relative;
    }
    .c-sel {
        border: 1px solid #bababa;
        height: 26px;
        line-height: 26px;
        padding: 0 12px 0 8px;
        width: 200px;
        background:url(http://static.ebanhui.com/ebh/images/ico.png) no-repeat 204px center;
        cursor: pointer;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .statusorderlist{
        border: 1px solid #bababa;
        width: 220px;
        border-top:none;
        line-height:26px;
        background:#fff;
        position:absolute;
        top:26px;
        left:0;
    }
    .statusorderlist ul li a {
        color: #333;
        display: block;
        font-size: 12px;
        height: 26px;
        line-height: 26px;
        padding: 0 8px;
        width: 204px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .statusorderlist ul li a:hover {
        background: #5e8cf1;
        color: #fff;
    }


</style>
<div class="lefrig xglefrig">
	<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
		<ul>
			 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span><?=$roominfo['property'] == 3?'我的部门':'我的班级'?></span></a></li>
		</ul>
	</div>
	<?php if (!empty($myclass)) { ?>
    <div class="myclass">
        <div class="myclasstitle"><?=htmlspecialchars($myclass['classname'], ENT_NOQUOTES)?></div>
        <div class="myclassviews">
            <?php if (empty($is_zjdlr)) { ?>
                <div class="myclasstop">
                    <div class="myclasstleft">
                        <a href="javascript:;" class="clastudents onhover"><?=$roominfo['property'] == 3?'部门同事':'班级同学'?></a>
                        <a href="/college/myclass/teachers.html" class="clastudents"><?=$roominfo['property'] == 3?'部门讲师':'班级教师'?></a>
                    </div>
                    <?php if(!empty($change_info)) { ?><a href="javascript:;" class="suresend" id="operate">自主升班</a><?php } ?>
                </div>
            <?php }?>
            <?php if (!empty($is_zjdlr)) { ?>
                <form class="group" method="get" action="/college/myclass.html" id="search-course">
                    <div class="statusorder-1">
                        <div id="class-select" class="c-sel" data-id="<?=$classid?>"><?=empty($classid)? '-' : $classes[$classid]['classname'] ?></div>
                        <div class="statusorderlist" style="display: none;z-index:1000">
                            <ul>
                                <?php if (!empty($classes)) {
                                    foreach ($classes as $classitem) { ?>
                                        <li data-id="<?=$classitem['classid']?>"><a href="javascript:;"><?=htmlspecialchars($classitem['classname'], ENT_NOQUOTES)?></a></li>
                                    <?php }
                                }?>
                            </ul>
                        </div>
                    </div>
                    <div class="search-group">
                        <input type="hidden" name="classid" id="classid" value="<?=empty($classid)? 0 : $classid ?>" />
                        <input name="q" class="newsou" id="search-keyword" placeholder="请输入关键字搜索" autocomplete="off" value="<?=!empty($q) ? $q : ''?>" type="text">
                        <input class="soulico" value="" type="submit">
                    </div>
                </form>

            <?php }?>
            <div class="clear"></div>
            <table cellpadding="0" cellspacing="0" class="myclasstable" id="list-table">
                <tbody>
                <tr>
                    <th width="27%" style="text-align:left;padding-left:60px;">个人信息</th>
                    <th width="28%">手机</th>
                    <th width="25%">电话</th>
                    <th width="20%">操作</th>
                </tr>
                <?php if (!empty($students)) {
                    foreach ($students as $student) {
                        ?>
                        <tr>
                            <td>
							<?php if(empty($is_zjdlr)){?>
								<div style="float:left;padding:0 10px;">
                                    <a href="javascript:;"><img gender="<?=intval($student['sex'])?>" class="touxyuan" src="<?=getavater($student,'50_50')?>"></a>
                                </div>
							<?php }else{?>
								<div style="float:left;padding:0 10px;width:40px;height:10px;">
                                </div>
							<?php }?>
                                <div style="width:125px;float:left;">
                                    <span class="renming" title="<?=htmlspecialchars($student['realname'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($student['realname'], 8), ENT_NOQUOTES)?></span>
                                    <span class="xingbie"<?php if($student['sex'] == 0) {?> style="background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png')"<?php } ?>></span>
                                    <div style="clear:both;"></div>
									<?php if(empty($is_zjdlr)){?>
										<span class="renming1" title="<?=htmlspecialchars($student['username'], ENT_COMPAT)?>"><?=shortstr($student['username'], 16)?></span>
									<?php }?>
                                    
                                </div>
                            </td>
                            <td><?php if (!empty($student['mobile'])) { echo $student['mobile']; } ?></td>
                            <td><?php if (!empty($student['phone'])) { echo $student['phone'];} ?></td>
                            <td data-id="<?=$student['uid']?>">
                                <a class="hrelh sendsx"<?php if (!empty($is_zjdlr)) { ?> style="padding-left:0;float:inherit;"<?php } ?> tid="<?=$student['uid']?>" tname="<?=htmlspecialchars($student['realname'], ENT_COMPAT)?>" href="javascript:;">发私信</a>
                        <?php if (empty($is_zjdlr)) { ?><a class="sendsx ml20 o-follow<?php if(!empty($student['followed'])) { echo ' followed'; }?>" href="javascript:;"><?=(empty($student['followed']) ? "加关注" : "已关注")?></a><?php } ?>
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
    <?php } else { ?>
		<div style="margin: 20px;">对不起，您还有没加入任何班级。</div>
	<?php } ?>
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
        var girl = "<?=getavater(array('sex' => 0, 'groupid' => 6),'50_50')?>";
        var boy = "<?=getavater(array('sex' => 1, 'groupid' => 6),'50_50')?>";
        var classid=<?=!empty($change_info) ? $change_info['sourceid'] : $myclass['classid']?>;
        var changelogid = <?=!empty($change_info) ? $change_info['classid'] : 0 ?>;
        <?php if (empty($is_zjdlr)) { ?>
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
        <?php } ?>
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
                                document.location.reload();
                            }
                        });
                    }
                },
                cancel:function(){},
            });
            d.showModal();
        });
        <?php }
        if (!empty($is_zjdlr)) { ?>

        $("#class-select").bind('click', function() {
            $("div.statusorderlist").show();
            return false;
        });
        $("div.statusorderlist").bind('click', function(e) {
            var node = e.target.nodeName.toLowerCase();
            var label = '';
            var classid = 0;
            var t = $(e.target);
            if (node == 'a') {
                label = t.html();
                classid = t.parent('li').data('id');
            } else if (node == 'li') {
                classid = t.data('id');
                label = t.find('a').html();
            } else {
                $(this).hide();
                return true;
            }
            $("#class-select").html(label).attr('data-id', classid);
            $("#classid").val(classid);
            $("#search-keyword").val('');
            $("#search-course").trigger('submit');
            $(this).hide();
            return false;
        });
        $(window).bind('blur', function() {
            $("div.statusorderlist").hide();
        }).bind('click', function() {
            $("div.statusorderlist").hide();
        });
        $("input.soulico").bind('click', function() {
            $("#classid").val('0');
        });
<?php } ?>
        $("img.touxyuan").bind('error', function() {
            var t = $(this);
            t.attr('src', t.attr('gender') == '0' ? girl : boy);
            t.unbind('error');
            t = null;
        });
    })(jQuery);
</script>
<?php $this->display('myroom/page_footer'); ?>
