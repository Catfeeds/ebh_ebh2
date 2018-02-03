<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $course['xkid']?>">查看</a> > <a href="/aroomv2/xuanke/firstcondition.html?xkid=<?php echo $course['xkid']?>&step=1">调整选课情况</a> > <a href="/aroomv2/xuanke/condition_set.html?cid=<?php echo $course['cid']?>&step=1">调整</a>
    </div>
    <div class="crightbottom">
        <div class="xktitles"><?php echo ssubstrch($course['coursename'],0,25)?><span class="xkjs1s">教师：<?php echo empty($course['realname'])?ssubstrch($course['username'],0,20):ssubstrch($course['realname'],0,20)?></span></div>
<!--        --><?php //if($course['isup']!=2){?>
        <div class="wctzbtn" value="<?php echo $course['cid']?>">完成调整</div>
<!--        --><?php //}?>
        <p class="kclbtitle">课程介绍：<span class="textkcjs"><?php echo $course['introduce']?></span></p>
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

        <table cellpadding="0" cellspacing="0" class="bmlist" style="width:750px;">
            <?php if(!empty($course['student'])){?>
            <tr class="zwnr1s">
                <td colspan="3" style="padding:0"></td>
                <td style="padding:0;padding-left:6px;"><a href="javascript:;" class="tzdel tzdel_all">一键删除</a></td>
            </tr>
            <?php }?>
            <tr class="bmlistfir">
                <td width="213">学生信息</td>
                <td width="193">所属班级</td>
                <td width="202">报名时间</td>
                <td width="106">操作</td>
            </tr>
            <?php if(!empty($course['student'])){$count = count($course['student']);foreach($course['student'] as $k=>$v){?>
            <tr class="<?php if($count==$k+1)echo 'last'?>">
                <td>
                    <div class="fl"><input type="checkbox" name="sel" class="xuanze sel" value="<?php echo $v['uid']?>"/></div>
                    <?php
                    if($v['sex'] == 1)
                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                    else
                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                    $face = empty($v['face']) ? $defaulturl:$v['face'];
                    $face = str_replace('.jpg','_50_50.jpg',$face);
                    ?>
                    <div style="float:left;padding:0 10px;">
                        <a href="javascript:;"><img class="touxyuan" src="<?php echo $face?>"></a>
                    </div>
                    <div style="width:95px;float:left;">
                        <span class="renming" title="<?=empty($v['realname']) ? $v['username'] : $v['realname']?>"><?php echo empty($v['realname'])?shortstr($v['username'], 8):shortstr($v['realname'],8)?></span>
                        <span class="xingbie" <?php  if($v['sex']==0) echo "style=\"background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png') \"" ?>></span>
                        <div style="clear:both;"></div>
                        <span class="renming1"><?php echo $v['username']?></span>
                    </div>
                </td>
                <td style="text-align:center;"><?php echo $v['classname']?></td>
                <td style="text-align:center;"><?=!empty($v['sign_time']) ? date('Y-m-d H:i',$v['sign_time']) : '--'?></td>
                <td><a href="javascript:;" toid="<?php echo $v['uid']?>" class="tzdel tzdel_single">删除</a></td>
            </tr>
            <?php }}else{?>
                <tr class="zwnr1s"><td colspan="4" style="border:none;"><div class="nodata"></div></td></tr>
            <?php }?>
        </table>
    </div>
</div>
<div id="multcheckdiv" style="display:none">
    <p style="height:40px"><span class="wid85">审核状态:</span>
        <label><input type="radio" name="admin_status" value="1" /> 通 过</label>
        <label style="margin-left:20px"><input type="radio" name="admin_status" value="2" /> 未通过</label>
    </p>
    <p><span class="wid85">备注信息:</span><textarea name="remark" id="multremark" style="height:140px;width:400px;margin-left:10px"></textarea></p>
</div>
<div class="tanchukuangs" style="display: none" id="dialog2">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="">确定删除选中的学生？</div>
        <div class="qsryy">
            <p class="pqsryy">请输入原因：</p>
            <textarea class="sckcyysr" style="color: #000" placeholder="由于课程名额有限,未能成功报名,请积极参与第二轮选课"></textarea>
        </div>
        <div class="xuanbtn2s" style="margin-top:35px;">
            <a href="#" class="jxxk">确定</a>
            <a href="#" class="qkks">取消</a>
        </div>
    </div>
</div>
</body>
<script>
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
    $('.tzdel_single').on('click',function(){
        var uid = $(this).attr('toid');
        var d = dialog({
            title: false,
            content: document.getElementById("dialog2"),
            cancel: false,
//            width:390,
//            height:187,
            drag:true,
            padding:1,
            fixed:true
        });
        d.show();
        $('.qkks').on('click',function(){
            d.close();
            location.reload();
            $("input.xuanze").removeAttr('checked');
        })
        $('.jxxk').on('click',function(){
            if($('.sckcyysr').val()==''){
                var msg = '由于课程名额有限,未能成功报名,请积极参与第二轮选课';
            }else{
                var msg = $('.sckcyysr').val();
            }
            d.close();
            $.post('/aroomv2/xuanke/condition_set.html',{uid:uid,bout:<?php echo $bout?>,cid:<?php echo $cid?>,failmsg:msg},function(data){
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='TPic'></div><p>删除学生成功</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function() {
                                that.close().remove();
                                location.reload();
                                $("input.xuanze").removeAttr('checked');
                            }, 1000);
                        }
                    }).show();
                } else {
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='FPic'></div><p>删除学生失败，请稍后再试或联系管理员</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function() {
                                that.close().remove();
                            }, 2000);
                        }
                    }).show();
                }
            })
        })
    })

    $('.sel').bind('click',function(){
        $(this).parent().parent().parent().toggleClass('xuanzehover')
    })

    $('.tzdel_all').on('click',function(){
        //删除学生id数组
        var idarr = new Array();
        $("input[name='sel']").each(function(){
            if($(this).prop("checked")==true){
                idarr.push($(this).val());
            }
        });
        if(idarr.length==0){
            alert("请选择要删除的学生");
            return false;
        }

        var uid = $(this).attr('toid');

        //弹框
        var d = dialog({
            title: false,
            content: document.getElementById("dialog2"),
            cancel: false,
//            width:390,
//            height:187,
            drag:true,
            padding:1,
            fixed:true
        });
        d.show();
        $('.qkks').on('click',function(){
            d.close();
            location.reload();
            $("input.xuanze").removeAttr('checked');
        })
        $('.jxxk').on('click',function() {
            d.close();
            var msg = $('.sckcyysr').val();
            $.post('/aroomv2/xuanke/condition_set.html',{uid:idarr,bout:<?php echo $bout?>,cid:<?php echo $cid?>,failmsg:msg},function(data){
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='TPic'></div><p>删除学生成功</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function() {
                                that.close().remove();
                                location.reload();
                                $("input.xuanze").removeAttr('checked');
                            }, 1000);
                        }
                    }).show();
                } else {
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='FPic'></div><p>删除学生失败，请稍后再试或联系管理员</p>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function() {
                                that.close().remove();
                            }, 2000);
                        }
                    }).show();
                }
            })
        })
    })
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
                        document.location.href = "<?= geturl('aroomv2/xuanke/'.$condition)?>?xkid=<?php echo $course['xkid']?>&step=1";
                            that.close().remove();
                        }, 2000);
                    }
                }).show();
            } else {
                dialog({
                    skin:"ui-dialog2-tip",
                    content:"<div class='PPic'></div><p>学生报名人数不能超过名额限制</p>",
                    width:350,
                    onshow:function () {
                        var that=this;
                        setTimeout(function() {
                            that.close().remove();
                        }, 2000);
                    }
                }).show();
            }
        })
    })
</script>
</html>
