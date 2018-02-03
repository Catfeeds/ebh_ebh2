
<?php $this->display('troomv2/page_header'); ?>
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


    <link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />


<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>"/>

    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=2016060131"></script>
<style type="text/css">
    span.siznwer{float:inherit;margin-left:20px;}
    a.remove-img{position:absolute;top:5px;right:5px;display:none;width:17px;height:17px;border:0 none;text-decoration:none;}
    a.remove-img:link{display:none;width:17px;height:17px;border:0 none;text-decoration:none;}
    a.remove-img:visited{display:none;width:17px;height:17px;border:0 none;text-decoration:none;}
    a.remove-img:hover{display:none;width:17px;height:17px;border:0 none;text-decoration:none;}
    a.remove-img:active{display:none;width:17px;height:17px;border:0 none;text-decoration:none;}
	div.choose-btn{cursor:pointer;background-color:#5792ff;color:#fff;width:24px;height:24px;text-align:center;line-height:20px;font-size:22px;border-radius:50%;-webkit-border-radius:50%:-moz-border-radius:50%;margin-left:10px;float:left;}
	ul.students{border:1px solid #ddd;padding:5px;width:80%;float:left;min-height:40px;}
	ul.students li{float:left;}
</style>
<div class="lefrig lefrig1s">
    <div class="xktitles"><?=htmlspecialchars($activity['name'], ENT_NOQUOTES)?></div>
    <form method="post" id="report-form" name="datas">
        <input type="hidden" name="isedit" id="isedit" value="<?php echo empty($course)?0:1?>">
        <table width="100%" style="border:none;margin-top:15px;" class="jsxkxt">
            <tbody>
            <tr>
                <td width="125" valign="center"><span class="siznwer">课程名称：</span></td>
                <td><input name="coursename" type="text" class="txtshur" style="width:500px;" value="<?php if(!empty($course)) { echo $course['coursename']; }?>" placeholder="请输入课程名称" autocomplete="off" maxlength="50" required></td>
            </tr>
            <tr>
                <td valign="top"><span class="siznwer">课程介绍：</span></td>
                <td><textarea name="introduce" id="summary" class="txtdasr" maxlength="200" rows="2" placeholder="请输入课程介绍" maxlength="500" required><?php if(!empty($course)) { echo $course['introduce']; }?></textarea></td>
                </td>
            </tr>
            <tr>
                <td valign="top"><span class="siznwer">课程图片：</span></td>
                <td >
                    <ul class="sckcfm" id="logo-box">
                        <?php if(!empty($course['images'])){foreach($course['images'] as $image_k=>$image){?>
                            <li class="fl" style="position:relative;"><img r="0" src="<?php $image=explode('.',$image);$image[2]=$image[2].'_th'; echo implode('.',$image)?>" style="cursor:pointer;width:180px;height:110px;" title="点我重新上传"/><input type="hidden" name="images[]" value="<?php echo $image_k?>"/><a href="#" class="remove-img languan" style="display: block;"></a></li>
                        <?php }}?>
                        <li class="fl" style="position:relative;"><img r="0" src="http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg" style="cursor:pointer;width:180px;height:110px;" /><input type="hidden" name="images[]" /><a href="#" class="remove-img languan"></a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td valign="top"><span class="siznwer" style="padding-top:0;">上课日期：</span></td>
                <td style="padding-top:0;">
                    <p class="jisrerss">
                        <input name="starttime" type="text" value="<?php if(!empty($course['starttime'])) echo date('Y-m-d',$course['starttime'])?>" class="xuasrne" id="textfield" onFocus="WdatePicker({isShowClear:false,readOnly:true})" required><span style="margin:0 5px;">至</span><input name="endtime" type="text" value="<?php if(!empty($course['starttime'])) echo date('Y-m-d',$course['endtime'])?>" id="textfield" class="xuasrne" onFocus="WdatePicker({isShowClear:false,readOnly:true})" required>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top"><span class="siznwer"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：</span><input type="hidden" name="ap" id="ap" value="<?=isset($course['ap']) ? intval($course['ap']) : '0'?>" /></td>
                <td>
                    <?php foreach ($timeRange as $tk => $tv) {
                        $ap = empty($course['ap']) ? 0 : $course['ap'];?>
                        <a href="javascript:;" class="ap jisere<?=$ap == $tk ? ' chenfse' : ''?>" rel="<?=$tk?>"><?=$tv?></a>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td valign="top" style="padding-top:13px;"><span class="siznwer">上课时间：</span></td>
                <td>
                    <p class="jisrerss"><input name="classtime" type="text" value="<?php if(!empty($course)) { echo $course['classtime']; }?>" id="textfield" class="jisretrt" autocomplete="off" maxlength="30" required></p>
                </td>
            </tr>
            <tr>
                <td valign="top" style="padding-top:13px;"><span class="siznwer">上课地点：</span></td>
                <td>
                    <p class="jisrerss"><input name="place" type="text" class="txtshur" value="<?php if(!empty($course)) { echo $course['place']; }?>" style="width:500px" autocomplete="off" maxlength="30" required></p>
                    <div class="clear"></div>
                    <p style="color:#999;">注：最终的上课日期、时间和地点，由管理员统一调整后确定。</p>
                </td>
            </tr>
            <tr>
                <td valign="top"><span class="siznwer">选课限制：</span></td>
                <td>
                    <div class="jieresd" id="sign-range"><input type="hidden" name="range_type" id="range_type" value="<?php if(!empty($course)) { echo $course['range_type']; }?>" />
                        <a class="<?php if(empty($course['range_type']))echo 'chenfse'?> jisere range-type" href="#" rel="0">全校</a>
                        <a class="<?php if(!empty($course) && $course['range_type']==1)echo 'chenfse'?> jisere range-type" href="#" rel="1">限年级</a>
                        <a class="<?php if(!empty($course) && $course['range_type']==2)echo 'chenfse'?> jisere range-type" href="#" rel="2">限班级</a>
                        <div class="huisre">
                            <ul id="wrap">
                                <?php if(!empty($course['rangemsg'])){foreach($course['rangemsg'] as $key=>$value){?>
                                    <li class="lantewu">
                                        <a class="languan" href="javascript:void(0)"></a>
                                        <?php echo $value?>
                                        <input type="hidden" class="v" name="range_args[]" value="<?php echo $key?>" />
                                    </li>
                                <?php }}?>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top" style="padding-top:13px;"><span class="siznwer">名额限制：</span></td>
                <td><input name="classnum" type="text" class="txtshur txtshur1s" value="<?php if(!empty($course)) { echo $course['classnum']; }?>" autocomplete="off" maxlength="10" required min="1"><span style="color:#333; font-size:16px;">&nbsp;人</span></td>
            </tr>
            <tr>
                <td valign="top"><span class="siznwer">选择学生：</span></td>
                <td class="group">
                    <ul class="students group" id="student-group">
                    <?php if (!empty($course['initStudents'])) {
                        foreach ($course['initStudents'] as $student) { ?>
                            <li class="lantewu"><a class="languan" href="javascript:void(0)" studentid="<?=$student['uid']?>"></a><?=!empty($student['realname']) ? $student['realname'] : $student['username']?><input type="hidden" name="studentids[]" value="<?=$student['uid']?>" /></li>
                        <?php }
                    } ?>
					</ul>
                    <div class="choose-btn" id="choose-btn">+</div>
                </td>
            </tr>
            </tbody>
        </table>
        <?php if(empty($course)){?>
        <input type="hidden" value="0" name="ajax" /><a id="report-post" class="huisres" href="javascript:void(0)" style="margin-left:450px; margin-top:40px;">申 报</a>
        <?php }else{?>
        <input type="hidden" value="0" name="ajax" /><a id="report-post" class="huisres" href="javascript:void(0)" style="margin-left:450px; margin-top:40px;">保 存</a>
        <input type="hidden" name="cid" id="cid" value="<?php echo $cid?>">
        <?php }?>
    </form>
</div>
<div id="filterDialog" class="taneret" style="height:500px;display:none">
        <div class="xzxstck">
            <div class="xzxstcktop">
                <div class="xzxstckleft">
                    <div class="dile1s search-oper">
                        <input type="text" class="newsou1s" placeholder="请输入姓名" id="s-keyword" style="width:120px;" />
                        <input type="button" class="soulico1s" />
                    </div><div style="height:1em;clear:both"></div>
                    <div class="qbxsabjnj">
                        <?php foreach($grade_class as $k => $item): ?>
                            <div class="qbxs2 grade" d="<?=$k?>" lab="<?=$grade_arr[$k]?>">
                                <span class="fl qbxs1span"><?=$grade_arr[$k]?></span>
                                <a href="javascript:void(0)" class="fr<?php if($k > 0):?> mt5 xuanzq<?php endif; ?> grade"></a>
                            </div>
                            <?php foreach($item as $sub): ?>
                                <div class="qbxs3 class" p="<?=$k?>" d="<?=$sub['classid']?>" lab="<?=htmlspecialchars($sub['classname'],ENT_COMPAT)?>" style="display:none;">
                                    <span class="fl qbxs3-lab" title="<?=htmlspecialchars($sub['classname'],ENT_COMPAT)?>"><?=htmlspecialchars(substr_ext($sub['classname'], 0, 8, 'utf-8'),ENT_COMPAT) ?></span>
                                    <a href="javascript:void(0)" class="fr mt5 xuanzq class"></a>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="xzxstckright">
                    <div class="xzxslist">
                        <ul id="filter-ajax-students">
                            <!--<li class="fl t-student-b grade0 class1">
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
    var imageServer = '<?=$image_server?>';
    var logoTarget = null;
    var logoBox = $("#logo-box");
    var xkid = <?=$activity['xkid']?>;

    $(function(){
        parent.window.preparexMulPhoto("mulphotouploader",callback);
    });
    function uploadlogo(){
        parent.window.xmulphoto.doShow();
    }

    function msghandle(res){
        if(res && res.status == 0){
            logoTarget.attr('src', imageServer+res.data.thumb);
            logoTarget.attr('title', '点我重新上传');

            var next = logoTarget.nextAll('input');
            $(next.get(0)).val(res.data.url);
            var del = logoTarget.nextAll('a.remove-img').css('display','block');
            if(logoTarget.attr('r') == '0') {
                if($("#logo-box li.fl").size() < 20) {
                    logoBox.append("<li class=\"fl\" style=\"position:relative;\"><img r=\"0\" src=\"http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg\" style=\"cursor:pointer;width:180px;height:110px;\" /><input type=\"hidden\" name=\"images[]\" /><a href=\"#\" class=\"remove-img languan\"></a></li>");
                    parent.window.resetmain();
                }
            }
            logoTarget.attr('r', '1');
        }else{
            alert("上传失败");
        }
        parent.window.xmulphoto.doClose();
    }

    //flash消息通知处理接口(处理此函数的执行环境是父级框架,也就是说this为 parent.window)
    function callback(res){
        res = $.parseJSON(res);
        document.getElementById('mainFrame').contentWindow.msghandle(res);
    };

    (function($) {
        parent.window.init($("#filterDialog"), 'filterDialog', 0, 0);
        var wrap = $("#wrap");
        var rangeType = $("#range_type");

      logoBox.bind("click", function(e) {
          var target = e.target;
          var node = target.nodeName.toLowerCase();
          var oTarget = $(target);
          if (node == "img") {
              logoTarget = $(target);
              uploadlogo();
              return;
          }
          if(node == "a" && oTarget.hasClass('remove-img')) {
              var l = $("#logo-box li").size();
              oTarget.parents('li').remove();
              if(l == 20) {
                  logoBox.append("<li class=\"fl\" style=\"position:relative;\"><img r=\"0\" src=\"http://static.ebanhui.com/ebh/tpl/selcur/images/kcfmadd.jpg\" style=\"cursor:pointer;width:180px;height:110px;\" /><input type=\"hidden\" name=\"images[]\" /><a href=\"#\" class=\"remove-img languan\"></a></li>");
              }
              parent.window.resetmain();
          }
      });
        var requireData = [
            {'o':$("input[name='coursename']"),'t':'课程名称','s':'str'},
            {'o':$("textarea[name='introduce']"),'t':'课程介绍','s':'str'},
            {'o':$("input[name='starttime']"),'t':'上课开始日期','s':'date'},
            {'o':$("input[name='endtime']"),'t':'上课结束日期','s':'date'},
            {'o':$("input[name='classtime']"),'t':'上课时间','s':'str'},
            {'o':$("input[name='place']"),'t':'上课地点','s':'str'},
            {'o':$("input[name='classnum']"),'t':'名额限制','s':'int'},
        ];
        var compareData = [
            {'small':$("input[name='starttime']"), 'big':$("input[name='endtime']"),'msg':'上课日期范围设置错误' }
        ];
        var requireLen = requireData.length;
        var comparaLen = compareData.length;
        var submit_enabled = true;
        $("#report-post").bind("click", function() {
            for(var i = 0; i < requireLen; i++) {
                requireData[i].o.val($.trim(requireData[i].o.val()));
                if(requireData[i].o.val() == '') {
                    requireData[i].o.focus();
                    top.dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='PPic'></div><p>请输入"+requireData[i].t+"</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function () {
                                that.close().remove();
                            }, 1000);
                        }
                    }).show();
                    return false;
                }
                if(requireData[i].s == 'int') {
                    if(isNaN(requireData[i].o.val()) || requireData[i].o.val() < 1) {
                        requireData[i].o.val('');
                        requireData[i].o.focus();
                        return false;
                    }
                }
            }

            for(var i = 0; i < comparaLen; i++) {
                var small = null;
                var big = null;
                if(isNaN(compareData[i].small.val()) === false) {
                    small = parseInt(compareData[i].small.val());
                } else {
                    small = compareData[i].small.val();
                }
                if(isNaN(compareData[i].big.val()) === false) {
                    big = parseInt(compareData[i].big.val());
                } else {
                    big = compareData[i].big.val();
                }

                if(small > big) {
                    compareData[i].small.focus();
                    parent.window.showMsg(compareData[i].msg);
                    return false;
                }
            }

            /*if($("input[name='images[]']").size() == 1) {
                parent.window.showMsg('请设置课程图片');
                return false;
            }*/
            if ($("input[name='studentids[]'").size() > $("input[name='classnum']").val()) {
                $("input[name='classnum']").focus();
                parent.window.showMsg('学生超过名额限制');
                return false;
            }

            if (!submit_enabled) {
                //return false;
            }
            submit_enabled = false;
            $("input[name='ajax']").val('1');
            var data = $("#report-form").serialize();
            if($('#isedit').val()==1){
                var url = '/troomv2/xuanke/edit.html?xkid='+xkid;
            }else{
                var url = '/troomv2/xuanke/report.html?xkid='+xkid;
            }
            $.ajax({
                'url': url,
                'data':data,
                'type':'post',
                'dataType':'json',
                'success':function(d) {
                    if(d.errno == 0) {
//                        parent.window.showMsg("课程申请成功，查看课程", function() {
                            location.href="/troomv2/xuanke/mycourse.html?t=v&aid="+xkid;
//                        });
                        return false;
                    }
                    if(d.errno == 2) {
//                        parent.window.showMsg("课程保存成功，查看课程", function() {
                            location.href="/troomv2/xuanke/mycourse.html?t=v&aid="+xkid;
//                        });
                        return false;
                    }

                    submit_enabled = true;
                    parent.window.showMsg(d.msg);
                }
            });
            //$("#report-form").submit();
        });
        $("#sign-range").bind("click", function(e) {
            if(e.target.nodeName.toLowerCase() != "a") {
                return;
            }
            var oTarget = $(e.target);
            parent.window.resetArg(0);
            if(oTarget.hasClass('range-type')) {
                var type = oTarget.attr("rel");
                if(type == "0") {
                    //不限
                    wrap.empty();
                    rangeType.val(0);
                    oTarget.siblings('a.chenfse').removeClass('chenfse').addClass('jisere');
                    oTarget.addClass('chenfse').removeClass('jisere');
                    return;
                }
                var vArr=[];
                $("input.v").each(function() {
                   vArr.push($(this).val());
                });
                if(type == "1") {
                    parent.window.filterStudentWindow('限年级', 1, vArr, function(retValue) {
                        wrap.empty();
                        var l = retValue.length;
                        if(l > 0) {
                            for(var i = 0; i < l; i++) {
                                wrap.append("<li class='lantewu'><a href='javascript:void(0)' class='languan'></a>"+retValue[i].k+"<input type='hidden' class='v' name='range_args[]' value='"+retValue[i].v+"' /></li>");
                            }
                            rangeType.val(1);
                            oTarget.siblings('a.chenfse').removeClass('chenfse').addClass('jisere');
                            oTarget.addClass('chenfse').removeClass('jisere');
                            parent.window.resetmain();
                            return;
                        }
                        oTarget.removeClass('chenfse').addClass('jisere');
                        $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
                        rangeType.val(0);
                        parent.window.resetmain();
                    }, function(){});
                    return;
                }
                if(type == "2") {
                    parent.window.filterStudentWindow('限班级', 2, vArr, function(retValue) {
                        wrap.empty();
                        var l = retValue.length;
                        if(l > 0) {
                            for(var i = 0; i < l; i++) {
                                wrap.append("<li class='lantewu'><a href='javascript:void(0)' class='languan'></a>"+retValue[i].k+"<input type='hidden' class='v' name='range_args[]' value='"+retValue[i].v+"' /></li>");
                            }
                            rangeType.val(2);
                            oTarget.siblings('a.chenfse').removeClass('chenfse').addClass('jisere');
                            oTarget.addClass('chenfse').removeClass('jisere');
                            parent.window.resetmain();
                            return;
                        }
                        oTarget.removeClass('chenfse').addClass('jisere');
                        $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
                        rangeType.val(0);
                        parent.window.resetmain();
                    }, function() {});
                }
            }
            if(oTarget.hasClass('languan')) {
                //删除选项
                oTarget.parent("li").remove();
                if(wrap.html() == "") {
                    $(".chenfse.range-type").removeClass("chenfse").addClass("jisere");
                    $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
                    rangeType.val(0);
                }
                parent.window.resetmain();
            }
        });
        $("a.ap").bind('click', function() {
           $("a.ap").removeClass('chenfse');
           $(this).addClass('chenfse');
           $("#ap").val($(this).attr('rel'));
        });
		$("#choose-btn").bind('click', function() {
            if ($("input[name='classnum']").val() == '') {
                $("input[name='classnum']").focus();
                parent.window.showMsg('请在名额限制中填入数量');
                return false;
            }
            if ($("input[name='studentids[]']").size() >= $("input[name='classnum']").val()) {
                $("input[name='classnum']").focus();
                parent.window.showMsg('学生已达到名额限制');
                return false;
            }
            parent.window.resetArg(1);
            var studentids = [];
            $("#student-group a").each(function() {
               studentids.push($(this).attr('studentid'));
            });
            parent.window.filterStudentWindow('选择学生', 0, studentids, function(retValue) {
                var len = retValue.length;
                var htmlfrage = [];
                for(var i = 0; i < len; i++) {
                    htmlfrage.push('<li class="lantewu"><a class="languan" href="javascript:void(0)" studentid="'+retValue[i].id+'"></a>'+retValue[i].name+'<input type="hidden" name="studentids[]" value="'+retValue[i].id+'" /></li>');
                }
                $("#student-group").append(htmlfrage.join(''));
                parent.window.resetmain();
            }, function(){});
		});
        $("#student-group").bind('click', function(e) {
            var node = e.target.nodeName.toLowerCase();
            if (node != 'a') {
                return false;
            }
            var t = $(e.target);
            t.parent('li').remove();
            parent.window.resetmain();
        });
    })(jQuery);

</script>
<?php $this->display('troomv2/page_footer'); ?>