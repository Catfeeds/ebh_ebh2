<?php $this->display('aroomv2/page_header');
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
$room = Ebh::app()->room->getcurroom();
?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=222"/>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<style>
.juierse{
	width: auto;
	margin-bottom: auto;
	line-height: none;
}
	.xzxstck {
    width: 780px;
}
.xzxstckright {
    width: 572px;
    
}
div.choose-btn{cursor:pointer;background-color:#5792ff;color:#fff;width:24px;height:24px;text-align:center;line-height:20px;font-size:22px;border-radius:50%;-webkit-border-radius:50%:-moz-border-radius:50%;margin-left:10px;float:left;}
ul.students{border:1px solid #ddd;padding:5px;width:80%;float:left;min-height:40px;}
ul.students li{float:left;}
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
        <span>课程设置</span>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs" style="min-height: 627px;padding-bottom: 60px;">
        <h2 class="sizrer"><?php echo $xuanke['name']?></h2>
        <div class="kostrds">
            <ul>
                <li class="fklisr"><a href="reportcoursefinish_list.html?xkid=<?php echo $xkid?>" class="wursk">课程列表</a></li>
                <li class="fklisr"><a href="reportcoursefinish_set.html?xkid=<?php echo $xkid?>" class="wursk botsder">课程设置</a></li>
                <li class="fklisr"><a href="reportcourserule.html?xkid=<?php echo $xkid?>" class="wursk">选课规则</a></li>
            </ul>
            <?php if($xuanke['status']<3){?>
            <a href="javascript:;" id="fbxk" class="husretd">发布第一轮选课</a>
            <?php }else{?>
            <a href="javascript:;" style="cursor:default;text-decoration: none" class="husretd">选课已发布</a>
            <?php }?>
        </div>
        <div class="kefens">
            <span class="kefens_lef"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：</span>
            <a href="/aroomv2/xuanke/reportcoursefinish_set.html?xkid=<?=$xuanke['xkid']?>" class="kefens_act<?=!isset($ap) ? ' activer':''?>">全部</a>
            <?php foreach ($timeRange as $rk => $rv) { ?><a class="kefens_act<?=isset($ap) && $ap == $rk ? ' activer':''?>" href="/aroomv2/xuanke/reportcoursefinish_set.html?xkid=<?=$xuanke['xkid']?>&ap=<?=$rk?>"><?=$rv?></a><?php }?>
        </div>
        <?php if(!empty($courselist)){?>
        <?php foreach($courselist as $course){?>
        <div class="jiweaes" id='course<?php echo $course['cid']?>'>
<!--            <input type="hidden" value="--><?php //echo $course['cid']?><!--">-->
            <p class="juierse">
                <span title="<?php echo $course['coursename']?>"><?php echo shortstr($course['coursename'],60)?></span><span class="nuetde">教师：<?php echo empty($course['realname'])?$course['username']:$course['realname']?></span>
            </p>
            <p class="jierset">上课日期：<span class="njuiers"><?php echo date('Y-m-d',$course['starttime'])?> 至 <?php echo date('Y-m-d',$course['endtime'])?></span></p>
            <p class="jierset" style="height: auto">
                <span class="fl"><?=count($timeRange) == 2 ? '上课时间段' : '课程分类'?>：</span><span class="nerfdr"><?=empty($course['ap']) ? $timeRange[0] : $timeRange[$course['ap']]?></span>
            </p>
            <p class="jierset" style="height: auto">上课时间：<span class="njuiers"><?php echo $course['classtime']?></span></p>
            <p class="jierset" style="height: auto">上课地点：<span class="njuiers" ><?php echo $course['place']?></span></p>
            <p class="jierset" style="height: auto">
                <span class="fl">选课限制：</span>
                <?php if(!empty($course['rangemsg'])){foreach($course['rangemsg'] as $v){?>
                    <span class="nerfdr"><?php echo $v?></span>
                <?php }}else{?>
                    <span class="nerfdr">全校学生</span>
                <?php }?>
            </p>
            <p class="jierset">名额限制：<span class="njuiers"><?php echo $course['classnum']?>人</span></p>
            <p class="jisrerss"><a href="javascript:;" onclick="edit(<?php echo $course['cid']?>)" class="huisres editbtn">修 改</a></p>
        </div>
        <?php } ?>
            <?php if(!empty($pagestr)) { ?><?=$pagestr?><?php } ?>
            <?php }else{?>
            <div class="nodata"></div>
        <?php }?>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit2" style="display: none">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close jxxk"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style=""></div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk" style="margin-left: 70px;">确定</a>
        </div>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit1" style="display: none">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="width: 280px;"></div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk">确定</a>
            <a href="javascript:;" class="qkks">取消</a>
        </div>
    </div>
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

<!--<button id="test">test</button>-->
</body>
<script type="text/javascript">
    var filterType = 0;
    var studentids = [];
    var timeRange = [];
    <?php foreach ($timeRange as $it) { ?>timeRange.push('<?=$it?>');<?php } ?>
    //点击修改,div替换
    function edit(cid){
        var cid = cid;
        $.post('/aroomv2/xuanke/getcourse.html',{cid:cid},function(data){
            var data = eval('('+data+')');
            var studentFrag = [];
            if (data.initStudents) {
                var l = data.initStudents.length;
                for (var i = 0; i < l; i++) {
                    studentFrag.push('<li class="lantewu"><a class="languan" href="javascript:void(0)" studentid="'+data.initStudents[i].uid+'"></a>'+(data.initStudents[i].realname ? data.initStudents[i].realname : data.initStudents[i].username)+'<input type="hidden" name="studentids[]" value="'+data.initStudents[i].uid+'" /></li>');
                }
            }
            var aplen = timeRange.length;
            var aphtml = [];
            for (var i = 0; i < aplen; i++) {
                aphtml.push('<a href="javascript:;" class="ap jisere'+(data.ap == i ? ' chenfse' : '')+'" rel="0" onclick="ap('+i+')">'+timeRange[i]+'</a>')
            }
            $('#course'+cid).html(
             '<form id="myform">'
                 +'<input type="hidden" name="cid" value="'+cid+'">'
//                 +'<input type="hidden" name="range_type" id="range_type" value="'+data.range_type+'">'
            +'<div class="" id="course'+cid+'" style=" ">'
            +'<p class="juierse">'
            +data.coursename+'<span class="nuetde">教师：'+data.name+'</span>'
            +'</p>'
            +'<p class="jisrerss">'
            +'<span class="fl">上课日期：</span>'
            +'<input name="starttime" type="text" id="starttime" class="xuasrne" value="'+data.starttime+'" onclick="WdatePicker({isShowClear:false,readOnly:true});" readonly="readonly" /><span style="margin:0 5px;">至</span><input class="xuasrne" name="endtime" type="text" id="endtime" value="'+data.endtime+'" onclick="WdatePicker({isShowClear:false,readOnly:true});" readonly="readonly" />'
            +'</p>'
            +'<div class="jieresd"><span class="fl">'+(timeRange.length == 2 ? '上课时间段' : '课程分类')+'：</span><input type="hidden" name="ap" id="ap" value="'+data.ap+'" />'
            +aphtml.join('')
            +'</div>'
            +'<p class="jisrerss">'
            +'上课时间：<input name="classtime" class="jisretrt" maxlength="50" type="text" placeholder="请输入上课时间" id="classtime" value="'+data.classtime+'" />'
            +'</p>'
            +'<p class="jisrerss">'
            +'上课地点：<input name="place" class="jisretrt" maxlength="50" type="text" placeholder="请输入上课地点" id="place" value="'+data.place+'" />'
            +'</p>'
            +'<div class="jieresd">'
            +'<span class="fl">选课限制：</span>'
            +'<div id="sign-range"><input type="hidden" name="range_type" id="range_type" value="'+data.range_type+'" />'
            +'<a href="javascript:;" class="jisere range-type"  id="school" rel="0">全校</a>'
            +'<a href="javascript:;" class="jisere range-type"  id="grade" rel="1">限年级</a>'
            +'<a href="javascript:;" class="jisere range-type"  id="class" rel="2">限班级</a>'
            +'</div>'
            +'<div class="huisre">'
            +'<ul id="wrap">'
//            +'<li class="lantewu" onclick="" xid="class_45">'
//            +'<a class="languan" href="javascript:void(0)"></a>'
//            +'一(2)班'
//            +'</li>'
            +(data.range_type > 0 ? data.html : '')
            +'</ul>'
            +'</div>'
            +'</div>'
             +'<p class="jierset">名额限制：<input type="text" class="asregfe" id="classnum" name="classnum" onkeyup=\'this.value=this.value.replace(/\\D/gi,"")\' value="'+data.classnum+'"> 人</p>'
                 + '<div class="jieresd">'
                 + '<span class="fl">选择学生：</span>'
                 + '<ul class="students" id="student-group">'+studentFrag.join('')+'</ul>'
                 + '<div class="choose-btn" id="choose-btn">+</div>'
                 + '</div>'
            +'<p class="jisrerss"><a href="javascript:;" onclick="savebtn()" class="huisres">保 存</a></p>'
            +'</div>'
            +'</form>'
            );
            show_range();
            $("#choose-btn").bind('click', function() {
                var d = dialog({
                    title: false,
                    content: document.getElementById("dialogedit2"),
                    cancel: false,
//            width:390,
//            height:187,
                    drag:true,
                    padding:1,
                    fixed:true
                });
                $('.jxxk').on('click',function(){
                    d.remove();
                    return;
                })

                if($('#classnum').val() == ''){
                    $('#classnum').focus();
                    $('.xzkctsxx').html('请在名额限制中填入数量');
                    d.show();
                    return false;
                }
                if($("input[name='studentids[]']").size() >= $('#classnum').val()){
                    $('#classnum').focus();
                    $('.xzkctsxx').html('学生已达到名额限制');
                    d.show();
                    return false;
                }
                filterType = 1;
                if (filterType == 1) {
                    $(".search-oper").show();
                } else {
                    $(".search-oper").hide();
                }
                var studentids = [];
                $("#student-group a").each(function() {
                    studentids.push($(this).attr('studentid'));
                });
                filterStudentWindow('选择学生', 0, studentids, function(retValue) {
                    var len = retValue.length;
                    var htmlfrage = [];
                    for(var i = 0; i < len; i++) {
                        htmlfrage.push('<li class="lantewu"><a class="languan" href="javascript:void(0)" studentid="'+retValue[i].id+'"></a>'+retValue[i].name+'<input type="hidden" name="studentids[]" value="'+retValue[i].id+'" /></li>');
                    }
                    $("#student-group").append(htmlfrage.join(''));
                }, function(){});
            });
            $("#student-group").bind('click', function(e) {
                var node = e.target.nodeName.toLowerCase();
                if (node != 'a') {
                    return false;
                }
                var t = $(e.target);
                t.parent('li').remove();
            });
        })
        $('.editbtn').hide();
//        $('#course'+cid).append($('#setcourse'));
        setTimeout('show_range()',100);


    }
    function show_range(){
        var range = $('#range_type').val();
        if(range == 1) {
            $("#grade").removeClass("jisere").addClass("chenfse");
        } else if(range == 2) {
            $("#class").removeClass("jisere").addClass("chenfse");
        } else {
            $("#school").removeClass("jisere").addClass("chenfse");
        }
    }
//
//    $('.jisere').bind('click',function(){
//        $('.chenfse').removeClass('chenfse');
//        $(this).addClass('jisere');
//    })

    //课程限制
    function range(sta){
        if(sta==0){
            $('#school').addClass('chenfse');
            $('#grade').removeClass('chenfse');
            $('#class').removeClass('chenfse');
        };
        if(sta==1){
            $('#school').removeClass('chenfse');
            $('#grade').addClass('chenfse');
            $('#class').removeClass('chenfse');
        };
        if(sta==2){
            $('#school').removeClass('chenfse');
            $('#grade').removeClass('chenfse');
            $('#class').addClass('chenfse');
        };
        $('#range_type').attr('value',sta);
//        parent.window.H.get('activityDialog').exec('show');
    }

    //保存修改
    function savebtn(){
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit2"),
            cancel: false,
//            width:390,
//            height:187,
            drag:true,
            padding:1,
            fixed:true
        });
        $('.jxxk').on('click',function(){
            d.close();
            return;
        })
        if($('#starttime').val()>$('#endtime').val()){
            $('.xzkctsxx').html('请填写正确日期');
            d.show();
            return;
        }
        if($('#classtime').val()==''||$('#place').val()==''||$('#starttime').val()==''||$('#endtime').val()==''){
            $('.xzkctsxx').html('请完善信息');
            d.show();
            return;
        }
        if($('#classnum').val()==''||$('#classnum').val()==0){
            $('.xzkctsxx').html('请输入课程名额');
            d.show();
            return;
        }
        if($("input[name='studentids[]']").size() > $('#classnum').val()){
            $('.xzkctsxx').html('学生数超过名额限制');
            d.show();
            return;
        }
        var url = "<?= geturl('aroomv2/xuanke/save_course')?>";
        $.ajax({
            url: url,
            type: "POST",
            data: $("#myform").serialize(),
            dataType: "json",
            success: function (data) {
                if (data.errno == 0) {
                    $.showmessage({
                        img: 'success',
                        message: '设置课程成功',
                        title: '设置课程',
                        callback: function () {
                            location.reload();
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: data.msg,
                        title: '设置课程'
                    });
                }
            }
        });
    }
    //发布选课
    $('#fbxk').on('click',function(){
        var url = '/aroomv2/xuanke/fbxk.html';
        var xkid = <?php echo $xkid?>;
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit1"),
            cancel: false,
            padding:1
//            fixed:true
        });
        $('.xzkctsxx').html('确定已设置选课规则和所有课程规则？');
        d.show();
        $('.qkks').on('click',function(){
            d.close();
            location.reload();
        });
        $('.jxxk').on('click',function(){
            d.close();
            $.post(url,{xkid:xkid,status:3},function(data){
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
                    $.showmessage({
                        img: 'success',
                        message: '发布选课成功',
                        title: '发布选课',
                        callback: function () {
                            document.location.href = "<?= geturl('aroomv2/xuankemanagermsg') ?>?xkid=<?php echo $xkid?>";
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: data.msg,
                        title: '发布选课'
                    });
                    if(data.msg = '请添加规则后再发布选课'){
                        setTimeout("document.location.href = \"<?= geturl('aroomv2/xuanke/reportcourserule') ?>?xkid=<?php echo $xkid?>\";",1000)
                    }
                }
            })
        });
    })

    $('.languan').live('click',function(){
        $(this).parent("li").remove();
        if($('#wrap').html()==''){
            $('#range_type').val(0);
            $(".chenfse.range-type").removeClass("chenfse").addClass("jisere");
            $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
        }
    })

    //弹框选择
    init($("#filterDialog"), 'filterDialog', 0, 0);
    $("#sign-range").live("click", function(e) {
        var wrap = $("#wrap");
        var rangeType = $("#range_type");
        if(e.target.nodeName.toLowerCase() != "a") {
            return;
        }
        filterType = 0;
        if (filterType == 1) {
            $(".search-oper").show();
        } else {
            $(".search-oper").hide();
        }
        var oTarget = $(e.target);
        if(oTarget.hasClass('range-type')) {
            var type = oTarget.attr("rel");
            if(type == "0") {
                oTarget.siblings('a.chenfse').removeClass('chenfse').addClass('jisere');
                oTarget.addClass('chenfse').removeClass('jisere');
                wrap.empty();
                rangeType.val(0);
                return;
            }
            var vArr=[];
            $("input.v").each(function() {
                vArr.push($(this).val());
            });
            if(type == "1") {
                filterStudentWindow('限年级', 1, vArr, function(retValue) {
                    var l = retValue.length;
                    wrap.empty();
                    if(l > 0) {
                        for(var i = 0; i < l; i++) {
                            wrap.append("<li class='lantewu'><a href='javascript:void(0)' class='languan'></a>"+retValue[i].k+"<input type='hidden' class='v' name='range_args[]' value='"+retValue[i].v+"' /></li>");
                        }
                        rangeType.val(1);
                        oTarget.siblings('a.chenfse').removeClass('chenfse').addClass('jisere');
                        oTarget.addClass('chenfse').removeClass('jisere');
                        return;
                    }
                    oTarget.removeClass('chenfse').addClass('jisere');
                    $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
                    rangeType.val(0);
                }, function(){});
                return;
            }
            if(type == "2") {
                filterStudentWindow('限班级', 2, vArr, function(retValue) {
                    wrap.empty();
                    var l = retValue.length;
                    if(l > 0) {
                        for(var i = 0; i < l; i++) {
                            wrap.append("<li class='lantewu'><a href='javascript:void(0)' class='languan'></a>"+retValue[i].k+"<input type='hidden' class='v' name='range_args[]' value='"+retValue[i].v+"' /></li>");
                        }
                        rangeType.val(2);
                        oTarget.siblings('a.chenfse').removeClass('chenfse').addClass('jisere');
                        oTarget.addClass('chenfse').removeClass('jisere');
                        return;
                    }

                    oTarget.removeClass('chenfse').addClass('jisere');
                    $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
                    rangeType.val(0);
                }, function() {});
            }
        }
        if(oTarget.hasClass('languan')) {
            if(wrap.html() == "") {
                $(".chenfse.range-type").removeClass("chenfse").addClass("jisere");
                $($(".range-type").get(0)).addClass("chenfse").removeClass("jisere");
                rangeType.val(0);
            }
        }
    });

$(function(){
		$('.jiweaes:last').css('border-bottom','none');
	});
//筛选类型：0选年级班级，1选学生
function ajaxStudent(postData) {
	if(courseid > 0) {
		postData['cid'] = courseid;
	}
	preData = postData;
	more.hide();
	$.ajax({
		'url':'/troomv2/xuanke/ajax_students.html',
		'type':'POST',
		'dataType':'json',
		'data':postData,
		'success':function(d) {
			if(d.errno == 0) {
				page = d.page;
				var l = d.data.length;
				var studentsBox = $("#filter-ajax-students");
                var dl = studentids.length;
				for(var i = 0; i < l; i++) {
					var ch = '';
					var htmlf = '';
					var title = '';
					if(filterType === 1) {
						ch = '<a href="javascript:;" class="t-student fr xuanzq1s" ></a>';
						if(d.data[i].signed || d.data[i].overflow) {
							ch += '<div style="background:#000;width:100%;height:100%;position:absolute;top:0;left:0;opacity:0.5;filter:alpha(opacity=50);"></div>';
						}
					}
					if(d.data[i].lab) {
						title = ' title="'+d.data[i].realname+'"';
						htmlf = '<p class="xingmingl t-student">'+d.data[i].lab+'</p>';
					} else {
						title = ' title="'+d.data[i].realname+'"';
						htmlf = '<p class="xingmingl t-student">'+d.data[i].showname+'</p>';
					}
					studentsBox.append('<li class="fl t-student-b grade'+d.data[i].grade + ' class' +
						d.data[i].classid + '" d='+d.data[i].uid+title+'><div class="t-student"><img style="width:50px;height:50px;" class="t-student" src="'+d.data[i].face+'" />'
						+'</div>'+htmlf+ch+'</li>');
				}
                for(var i = 0; i < dl; i++) {
                    //$("li.fl.t-student-b[d='"+studentids[i]+"'] a.fr").addClass('onhover');
                    $("li.fl.t-student-b[d='"+studentids[i]+"']").append('<div style="background:#000;width:100%;height:100%;position:absolute;top:0;left:0;opacity:0.5;filter:alpha(opacity=50); "></div>');
                }
				if(d.finish) {
					more.hide();
				} else {
					more.show();
				}
				more.html('加载更多...');
				if($("li.fl.t-student-b").size() == 0) {
					studentsBox.append('<li class="fl t-student-b" style="width:700px;text-align:center"><div class="nodata"></div></li>');
				}
				return;
			}
		}
	});
}
//绑定年级、班级、学生选择事件


function init(content, id, ifilterType, cid) {
	if($("#"+id)) {
		$("#"+id).unbind('click');
		$("#"+id).remove();
	}
	$("body").append(content);
	page = 1;
	courseid = cid;
	filterType = ifilterType;
    if (filterType == 1) {
        $(".search-oper").show();
    } else {
        $(".search-oper").hide();
    }
	more = $("#filterDialog a.jzgds");
	$("#filterDialog").find(".hovered").each(function(e){
		$(e).removeClass('hovered');
	});
	$("#filterDialog").bind("click", function(e){
		var t = $(e.target);
		if(t.hasClass('qbxs2') || t.hasClass('qbxs1span')) {
			//年级菜单点击事件
			var menu = t;
			if(t.hasClass('qbxs1span')) {
				menu = t.parent('div.qbxs2');
			}
			var id = menu.attr('d');
			if(menu.hasClass('ex')) {
				menu.removeClass('ex');
				menu.children('span.qbxs1span').removeClass('selct');
				menu.nextAll(".qbxs3.class[p='"+id+"']").hide();
			} else {
				menu.addClass('ex');
				menu.children('span.qbxs1span').addClass('selct');
				menu.nextAll(".qbxs3.class[p='"+id+"']").show();
			}
			$("div.hovered").removeClass('hovered');
			menu.addClass('hovered');
			if(tmpType != 1 || tmpId != id) {
				tmpType = 1;
				tmpId = id;
				page = 1
				$("li.fl.t-student-b").remove();

				if(courseid == 0) {
					var ids = [];
					$("div.qbxs3.class[p='"+id+"']").each(function() {
						ids.push($(this).attr('d'));
					});
					ajaxStudent({
						'filterType':2,
						'id':ids,
						'page':1
					});
				} else {
					ajaxStudent({
						'filterType':1,
						'id':id,
						'page':1
					});
				}
			}

			return;
		}

		if(t.hasClass('qbxs3') || t.hasClass('qbxs3-lab')) {
			//班级菜单点击事件
			var menu = t;
			if(t.hasClass('qbxs3-lab')) {
				menu = t.parent('div.qbxs3');
			}
			$("div.hovered").removeClass('hovered');
			menu.addClass('hovered');

			var id = menu.attr('d');
			if(tmpType != 2 || tmpId != id) {
				tmpType = 2;
				tmpId = id;
				page = 1
				$("li.fl.t-student-b").remove();
				ajaxStudent({
					'filterType':2,
					'id':id,
					'page':1
				});
			}
			return;
		}

		if(t.hasClass('fr') && t.hasClass('mt5') && t.hasClass('xuanzq')) {
			//选择图标点击事件
			if(t.hasClass('hovered')) {
				t.removeClass('hovered');
			} else {
				t.addClass('hovered');
			}
			return;
		}

		if(t.hasClass('jzgds')) {
			//加载更多学生
			if(t.html() == "正在加载中...") {
				return;
			}
			t.html('正在加载中...');
			preData.page = page;
			ajaxStudent(preData, 1);
			return;
		}

		if(t.hasClass('soulico1s')) {
			//搜索学生
			var keyword = $.trim($("#s-keyword").val());
			if(!keyword) {
				//return;
			}
			$("li.fl.t-student-b").remove();

			if(tmpType == 2) {
				var ids = [];
				$("div.qbxs3.class.hovered").each(function() {
					ids.push($(this).attr('d'));
				});
				ajaxStudent({
					'filterType':2,
					'id':ids,
					'keyword':keyword,
					'page':1
				});
				return;
			}
			if(tmpType == 1) {
				var ids = [];
				$("div.qbxs2.grade.hovered").each(function() {
					ids.push($(this).attr('d'));
				});
				ajaxStudent({
					'filterType':1,
					'id':ids,
					'keyword':keyword,
					'page':1
				});
				return;
			}
			ajaxStudent({
				'filterType':0,
				'keyword':keyword,
				'page':1
			});
			return;
		}
		if(t.hasClass('t-student')) {
			//选择学生
			var student = $(t.parents('li.t-student-b').find('a.xuanzq1s').get(0));
			if(student.hasClass('onhover')) {
				student.removeClass('onhover');
			} else {
				student.addClass('onhover');
			}
			return;
		}
	});
}
function ap(ap) {
    $("#ap").val(ap);
    $(".ap").removeClass('chenfse');
    $($(".ap").get(ap)).addClass('chenfse');
}
//选择年级、班级、学生
function filterStudentWindow(title, filterType, data, callback, cancel) {
	more.hide();
	$("li.fl.t-student-b").remove();
	$(".qbxs3.class.hovered").removeClass('hovered');
	$(".qbxs2.grade.hovered").removeClass('hovered');
	$(".qbxs3.class a.hovered").removeClass('hovered');
	$(".qbxs2.grade a.hovered").removeClass('hovered');
	$(".qbxs2.grade.ex").removeClass('ex');
	$("span.selct").removeClass('selct');
	$(".qbxs3.class").hide();
	tmpId = 0;
	tmpType = 1;
    studentids.length = 0;
	if(filterType == 1) {
		//年级
		$(".qbxs3.class a.fr.mt5.xuanzq").hide();
		$(".qbxs2.grade a.fr.mt5.xuanzq").show();
		var dl = data.length;
		for(var i = 0; i < dl; i++) {
			$(".qbxs2.grade[d='"+data[i]+"'] a.fr").addClass('hovered');
		}
	} else if(filterType == 2) {
		//班级
		$(".qbxs3.class a.fr.mt5.xuanzq").show();
		$(".qbxs2.grade a.fr.mt5.xuanzq").hide();
		var dl = data.length;
		var item = null;
		var parents = {};
		for(var i = 0; i < dl; i++) {
			item = $(".qbxs3.class[d='"+data[i]+"']");
			item.find("a.fr").addClass('hovered');
			if(parents['d'+item.attr('p')] == undefined) {
				$(".qbxs2.grade[d='"+item.attr('p')+"'] a.fr").addClass('ex');
				$(".qbxs2.grade[d='"+item.attr('p')+"'] span.fl").addClass('selct');
				$(".qbxs3.class[p='"+item.attr('p')+"']").show();
			}
			parents['d'+item.attr('p')] = true;
		}

	} else {
        studentids = data;
		$(".qbxs3.class a.fr.mt5.xuanzq").hide();
		$(".qbxs2.grade a.fr.mt5.xuanzq").hide();
	}

	var d = dialog({
		title: title,
		content: document.getElementById('filterDialog'),
		id:'filter_window',
		padding:0,
		fixed:true,
		'okValue':'确定',
        'onshow': function() {
            $("#s-keyword").val('');
        },
		'ok':function() {
			var retValue = [];
			if(courseid > 0) {
				$("a.t-student.fr.xuanzq1s.onhover").parent('li').each(function() {
					retValue.push($(this).attr('d'));
				});
			} else if(window.filterType == 1) {
                $("a.t-student.fr.xuanzq1s.onhover").parent('li').each(function() {
                    var that = $(this);
                    retValue.push({id:that.attr('d'),'name':that.attr('title')});
                });

            } else {
				$("a.fr.mt5.xuanzq.hovered").parent('div').each(function() {
					retValue.push({v:$(this).attr('d'),k:$(this).attr('lab')});
				});
			}

			callback(retValue);
			this.close();
		},
		'cancelValue':'取消',
		'cancel':function() {
			cancel();
			this.close();
		}
	});
	d.showModal();
}
</script>
</html>
