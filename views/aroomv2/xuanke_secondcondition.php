<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>">查看</a> >查看选课情况
    </div>
    <div class="crightbottom">
        <div class="xktitles"><?php echo shortstr($xuanke['name'],50)?></div>
        <div class="wctzbtn" id="fbxk" style="font-size:13px;display: <?php if($step!=1)echo 'none'?>">发布结果</div>
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
                        <?php $status=array(0=>'等待调整',1=>'等待调整',2=>'等待调整',3=>'已调整',4=>'等待调整',5=>'调整完成',6=>'选课中')?>
                        <td><?php if($course['status']==2||$course['classnum']==$course['studentsnum']){echo '完成选课';}else{echo $status[$course['isup']];}?></td>
                        <td>
                            <?php if($step==1){?>
                                <?php if($course['status']==2||$course['classnum']==$course['studentsnum']){?>
                                    <a href="condition_detail.html?cid=<?php echo $course['cid']?>&bout=2" target="_blank" class="xkcka">查看</a>
                                <?php }else{?>
                                    <a href="secondcondition_set.html?cid=<?php echo $course['cid']?>&bout=2" class="xkcka">调整</a>
                                <?php }?>
                                <?php }else{?>
                                <a href="condition_detail.html?cid=<?php echo $course['cid']?>&bout=2" target="_blank" class="xkcka">查看</a>
                            <?php }?>
                        </td>
                    </tr>
                <?php }}else{?>
                    <tr class="zwnr1s"><td colspan="6" style="border:none;"><div class="notada"></div></td></tr>
                <?php }?>
            </table>
        </div>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit2" style="display: none">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="width: 300px;"></div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk">确定</a>
            <a href="javascript:;" class="qkks">取消</a>
        </div>
    </div>
</div>
</body>
<script>
    $('#fbxk').on('click',function(){
        var xkid = <?php echo $xkid?>;
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit2"),
            cancel: false,
            padding:1
//            fixed:true
        });
        $('.xzkctsxx').html('发布结果之后将不能更改,确定发布结果?');
        d.show();
        $('.qkks').on('click',function(){
            d.close();
            location.reload();
        });
        $('.jxxk').on('click',function(){
            $.post('/aroomv2/xuanke/fbjg.html',{xkid:xkid},function(data){
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
                    $.showmessage({
                        img: 'success',
                        message: '发布结果成功',
                        title: '发布结果',
                        callback: function () {
                            document.location.href = "<?= geturl('aroomv2/xuankemanagermsg')?>?xkid="+xkid;
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: data.msg,
                        title: '发布结果'
                    });
                }
            })
        })
    })
    function jump(cid){
        var cid = cid;
        top.document.location.href = "/aroomv2/xuanke/jump.html?cid="+cid;
    }
</script>
</html>
