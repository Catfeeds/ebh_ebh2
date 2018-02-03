<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>">查看</a> > 查看选课情况
    </div>
    <div class="crightbottom">
        <div class="xktitles"><?php echo shortstr($xuanke['name'],50)?></div>
        <div class="wctzbtn" id="fbxk" style="font-size:13px;display: <?php if($step!=1)echo 'none'?>;top: ">发布第二轮选课</div>
        <div class="kclist">
            <p class="kclbtitle">课程列表</p>
            <table cellpadding="0" cellspacing="0" class="tablekclist">
                <tr class="first">
                    <td width="194">课程名称</td>
                    <td width="106">教师</td>
                    <td width="94">名额限制</td>
                    <td width="94">报名人数</td>
                    <td width="106">状态</td>
                    <td width="96">操作</td>
                </tr>
                <?php if(!empty($courselist)){foreach($courselist as $course){?>
                <tr>
                    <td><?php echo $course['coursename']?></td>
                    <td><?php echo empty($course['realname'])?$course['username']:$course['realname']?></td>
                    <td><?php echo $course['classnum']?></td>
                    <td><?php echo $course['studentsnum']?></td>
                    <?php $status=array(0=>'等待调整',1=>'已调整',2=>'调整完成',3=>'调整完成',4=>'选课中',5=>'完成调整')?>
                    <td><?php if($course['status']==2){echo '完成选课';}else{echo $status[$course['isup']];} ?></td>
                    <td>
                        <?php if($step==1){?>
                        <a href="condition_set.html?cid=<?php echo $course['cid']?>&step=1" class="xkcka">调整</a>
                        <?php }else{?>
                        <a href="condition_detail.html?cid=<?php echo $course['cid']?>" target="_blank" class="xkcka">查看</a>
                        <?php }?>
                        </td>
                </tr>
                <?php }}else{?>
                    <tr class="zwnr1s"><td colspan="6" style="border:none;"><div class="nodata"></div></td></tr>
                <?php }?>
            </table>
        </div>
        <?php if($step==1){?>
        <form id="myform">
        <input type="hidden" name="step" value="2">
        <input type="hidden" name="status" value="5">
        <input type="hidden" name="xkid" value="<?php echo $xkid?>">
        <div class="kclist">
            <p class="kclbtitle">第二轮选课日期：</p>
            <div class="delxkrq">
                <input type="text" class="txtinputxk" id="start_t" name="start_t" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',isShowClear:true});" readonly="readonly" />
                <span class="sjzjx">至</span>
                <input type="text" class="txtinputxk" id="end_t" name='end_t' onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',isShowClear:true});" readonly="readonly"/>
            </div>
        </div>
        <div class="kclist">
            <p class="kclbtitle">学生选课规则说明（第二轮）：</p>
            <div class="xsxkgzsmfa">
                <textarea class="xsxkgzsm" name="remark" id="remark"></textarea>
            </div>
        </div>
        </form>
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
        <div class="xzkctsxx" style=""></div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk">确定</a>
            <a href="javascript:;" class="qkks">取消</a>
        </div>
    </div>
</div>
</body>
<script>
    //发布选课
    $('#fbxk').on('click',function(){
//        var d = dialog({
//            title: false,
//            content: document.getElementById("dialogedit2"),
//            cancel: false,
////            width:390,
////            height:187,
//            drag:true,
//            padding:1,
//            fixed:true
//        });
//        $('.jxxk').on('click',function(){
//            d.close();
//        })
//        if($('#start_t').val()>$('#end_t').val()){
//            $('.xzkctsxx').html('请填写正确日期');
//            d.show();
//            return;
//        }
//        if($('#remark').val()==''||$('#start_t').val()==''||$('#end_t').val()==''){
//            $('.xzkctsxx').html('请完善信息');
//            d.show();
//            return;
//        }
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit1"),
            cancel: false,
            padding:1
//            fixed:true
        });
        if(<?php echo $finish?>==1){
            $('.xzkctsxx').html('所有课程报名人数已符合选课限制,可直接完成选课。');
            d.show();
        }else{
            $('.xzkctsxx').html('确定已调整完第一轮选课结果及第二轮选课规则？');
            d.show();
        }


        $('.qkks').on('click',function(){
            d.close();
            location.reload();
        });
        $('.jxxk').on('click',function(){
            d.close();
            var url = '/aroomv2/xuanke/fbxk.html';
            $.ajax({
                url: url,
                type: "POST",
                data: $("#myform").serialize(),
                dataType: "text",
                success: function (data) {
                    var data = eval('(' + data + ')');
                    if (data.status == 1) {
                        $.showmessage({
                            img: 'success',
                            message: data.msg,
                            title: '发布选课',
                            callback: function () {
//                            location.reload();
                                document.location.href = "/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>";
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                            }
                        });
                    } else {
                        $.showmessage({
                            img: 'error',
                            message: data.msg,
                            title: '发布选课',
                            callback:function(){
                                location.reload();
                            }
                        });
                    }
                }
            });
        })
    })
</script>
</html>
