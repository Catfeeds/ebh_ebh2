<?php $this->display('aroomv2/page_header'); ?>
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
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=222"/>
<style>
.xzxstck {
    width: 780px;
}
.xzxstckright {
    width: 572px;
    
}
a.tzadd{color:#fff;}
</style>
<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $course['xkid']?>">查看</a> > <a href="/aroomv2/xuanke/secondcondition.html?step=1&xkid=<?php echo $course['xkid']?>">调整选课情况</a> > <a href="secondcondition_set.html?bout=2&cid=<?php echo $course['cid']?>">调整</a>
    </div>
    <div class="crightbottom">
        <div class="xktitles"><?php echo ssubstrch($course['coursename'],0,25)?><span class="xkjs1s">教师：<?php echo empty($course['realname'])?ssubstrch($course['username'],0,8):ssubstrch($course['realname'],0,8)?></span></div>
<!--        --><?php //if($course['isup']!=5){?>
            <div class="wctzbtn" value="<?php echo $course['cid']?>">完成调整</div>
<!--        --><?php //}?>
        <p class="kclbtitle" style="float:left;"><span style="float:left;">课程介绍：</span><span class="textkcjs" style="white-space: normal;float:left;width:660px;"><?php echo $course['introduce']?></span></p>
        <div class="xklbtp">
            <ul id="layer-photos-demo">
                <?php foreach($course['images'] as $thumb => $image): ?>
                    <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;" /></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="clear"></div>
        <p class="kclbtitle" style="*padding-top:8px;">上课日期：<span class="textkcjs"><?php echo date('Y-m-d',$course['starttime'])?> 至 <?php echo date('Y-m-d',$course['endtime'])?></span></p>
        <p class="kclbtitle kclbtitle1s" style="width: 750px;">上课时间段：<span class="textkcjs"><?=empty($course['ap']) ? $timeRange[0] : $timeRange[1]?></span></p>
        <p class="kclbtitle kclbtitle1s" style="width: 750px;">上课时间：<span class="textkcjs"><?php echo $course['classtime']?></span></p>
        <p class="kclbtitle kclbtitle1s" style="width: 750px;">上课地点：<span class="textkcjs"><?php echo $course['place']?></span></p>
        <?php $range=array(0=>'全年级',1=>'限年级',2=>'限班级')?>
        <p class="kclbtitle kclbtitle1s">选课人员：<span class="textkcjs"><?php echo $range[$course['range_type']];if($course['range_type']!=0){echo '/';};if(!empty($course['rangemsg']))echo $course['rangemsg']?></span></p>
        <p class="kclbtitle kclbtitle1s">名额限制：<span class="textkcjs" style="color:#ffa000;"><?php echo $course['classnum']?></span><span class="textkcjs"> 人</span></p>
        <p class="kclbtitle kclbtitle1s">报名情况：<span class="textkcjs" style="color:#ff3c00;"><?php echo $course['studentsnum']?></span><span class="textkcjs"> 人</span></p>
        <?php $students_count = empty($course['student']) ? 0 : count($course['student']); ?>
        <table cellpadding="0" cellspacing="0" class="bmlist" style="width:750px;">
		<?php if($course['classnum'] > $students_count): ?>
            <tr class="zwnr1s last">
                <td colspan="2" style="padding:0"></td>
                <td style="padding:0;"><a href="javascript:;" class="tzdel tzadd">添加学生</a></td>
            </tr>
			<?php else: ?>　<?php endif; ?>
            <tr class="bmlistfir">
                <td width="213">学生信息</td>
                <td width="193">所属班级</td>
                <td width="202">报名时间</td>
<!--                <td width="106">操作</td>-->
            </tr>

            <?php if(!empty($course['student'])){foreach($course['student'] as $k=>$v){?>
                <tr<?php if($students_count == $k+1):?> class="last"<?php endif; ?>>
                    <td>
                        <div style="float:left;padding:0 10px;">
                            <a href="javascript:;"><img class="touxyuan" src="<?=getavater($v,'50_50')?>"></a>
                        </div>
                        <div style="width:105px;float:left;">
                            <span class="renming" title="<?=empty($v['realname']) ? $v['username'] : $v['realname']?>"><?=empty($v['realname']) ? shortstr($v['username'], 8) : shortstr($v['realname'], 8)?></span>
                            <span class="xingbie" <?php  if($v['sex']==0) echo "style=\"background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png') \"" ?>></span>
                            <div style="clear:both;"></div>
                            <span class="renming1"><?php echo $v['username']?></span>
                        </div>
                    </td>
                    <td style="text-align:center;"><?php echo $v['classname']?></td>
                    <td style="text-align:center;"><?=!empty($v['sign_time']) ? date('Y-m-d H:i',$v['sign_time']) : '--'?></td>
                    <!--<td><a href="javascript:;" toid="<?php echo $v['uid']?>" class="tzdel tzdel_single">删除</a></td>-->
                </tr>
            <?php }}else{?>
                <tr class="last zwnr1s"><td colspan="3" style="border:none;"><div class="nodata"></div></td></tr>
            <?php }?>
        </table>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit2" style="display: none">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close jxxk"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="width: 280px;"></div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk">确定</a>
        </div>
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
                            <div class="qbxs3 class" p="<?=$k?>" d="<?=$sub['classid']?>" lab="<?=htmlspecialchars($sub['classname'],ENT_COMPAT)?>" style="display:none;">
                                <span class="fl qbxs3-lab" title="<?=htmlspecialchars($sub['classname'],ENT_COMPAT)?>"><?=htmlspecialchars(substr_ext($sub['classname'], 0, 8,'utf-8'),ENT_COMPAT) ?></span>
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

</body>
<script>
    var cid = <?=$cid?>;
    var xkid = <?=$course['xkid']?>;
    //图片预览
    (function($) {
        prev($('.xklbtplist.fl a'));
    })(jQuery);
	//图片预览
	function prev(jo) {
	    jo.each(function() {
	        $(this).lightBox();
	    });
	}
    //完成调整
    $('.wctzbtn').on('click',function(){
        var cid = $(this).attr('value');
        $.post('/aroomv2/xuanke/upfinish.html',{cid:cid,bout:<?php echo $bout?>,classnum:<?php echo $course['classnum']?>},function(data){
            var data = eval('(' + data + ')');
            if (data.msg == 'success') {
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='TPic'></div><p>完成调整</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function() {
                            that.close().remove();
                            document.location.href = "<?= geturl('aroomv2/xuanke/secondcondition')?>?xkid=<?php echo $course['xkid']?>&step=1";
                        }, 1000);
                    }
                }).show();
            } else {
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='TPic'></div><p>学生报名人数不能超过名额限制</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function() {
                            that.close().remove();
                            document.location.href = "<?= geturl('aroomv2/xuanke/secondcondition')?>?xkid=<?php echo $course['xkid']?>&step=1";
                        }, 1000);
                    }
                }).show();
            }
        })
    })

    $(function(){
        /*parent.window.H.create(new P({
            id:'activityDialog',
            title:'选择类型',
            easy:true,
            content:$("#activityDialog")[0]
        }),'common');*/
        init($("#filterDialog"), 'filterDialog', 1, cid);
    });

    //弹框
    $('.tzadd').on('click',function(){
        //parent.window.H.get('activityDialog').exec('show');
        filterStudentWindow('添加学生', 0, null, function(retValue) {
            $.ajax({
                'url':'/troomv2/xuanke/ajax_add_students.html',
                'type':'POST',
                'data':{'uid':retValue,'cid':cid,'xkid':xkid},
                'dataType':'json',
                'success':function(d) {
                    if(d.errno == 0|| d.errno == 1) {
                        var dia = dialog({
                            title: false,
                            content: document.getElementById("dialogedit2"),
                            cancel: false,
                            drag:true,
                            padding:1,
                            fixed:true
                        });
                        $('.jxxk').on('click',function(){
                            dia.close();
                            location.reload();
                        })
                        $('.xzkctsxx').html(d.msg);
                        dia.show();
//                        location.reload();
//                        return;
                    }
                }
            });
        }, function(){

        });
    })

//    //添加学生
//    $('.insert').on('click',function(){
//        var idarr = new Array();
//        $("input[name='sel']", window.parent.document).each(function(){
//            if($(this).prop("checked")==true){
//                idarr.push($(this).val());
////                $(this).removeAttr("checked");
//            }
//        });
//        if(idarr.length==0){
//            alert("请选择要添加的学生");
//            return false;
//        }
//        parent.window.H.get('activityDialog').exec('close');
//        $.post('/aroomv2/xuanke/secondcondition_set.html',{uidarr:idarr,xkid:<?php //echo $course['xkid']?>//,cid:<?php //echo $course['cid']?>//},function(data){
//            var data = eval('(' + data + ')');
//            if (data.msg == 'success') {
//                $.showmessage({
//                    img: 'success',
//                    message: '添加成功',
//                    title: '添加成功',
//                    callback: function () {
//                        top.document.location.href = "/aroomv2/xuanke/jump.html?cid=<?php //echo $course['cid']?>//";
//                    }
//                });
//            }else{
//                var d = dialog({
//                    title: false,
//                    content: document.getElementById("dialogedit2"),
//                    cancel: false,
////            width:390,
////            height:187,
//                    drag:true,
//                    padding:1,
//                    fixed:true
//                });
//                $('.jxxk').on('click',function(){
//                    d.close();
//<!--                    -->
////                    window.parent.location.reload();
//                    top.document.location.href = "/aroomv2/xuanke/jump.html?cid=<?php //echo $course['cid']?>//";
//                })
//                $('.xzkctsxx').html(data.msg);
//                d.show();
//            }
//        })
//    })

//筛选类型：0选年级班级，1选学生
var filterType = 0;
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
