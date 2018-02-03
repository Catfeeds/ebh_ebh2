<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

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
        <span>选课规则</span>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs" style="min-height: 627px;">
        <h2 class="sizrer"><?php echo $xuanke['name']?></h2>
        <div class="kostrds">
            <ul>
                <li class="fklisr"><a href="reportcoursefinish_list.html?xkid=<?php echo $xkid?>" class="wursk">课程列表</a></li>
                <li class="fklisr"><a href="reportcoursefinish_set.html?xkid=<?php echo $xkid?>" class="wursk">课程设置</a></li>
                <li class="fklisr"><a href="reportcourserule.html?xkid=<?php echo $xkid?>" class="wursk botsder">选课规则</a></li>
            </ul>
            <?php if(!empty($rule)){?>
                <a href="javascript:;" id="fbxk" class="husretd">发布第一轮选课</a>
<!--            --><?php //}else{?>
<!--                <a href="javascript:;" style="cursor:default;text-decoration: none" class="husretd">选课已发布</a>-->
            <?php }?>
        </div>
        <div class="jiweaes" style="border:none;display: <?php if(!empty($rule)) echo 'none'?>" id="editview">
            <form id="myform">
            <input type="hidden" value="<?php echo $xkid?>" name="xkid">
            <div class="waisrhr">
                报名限制：每位学生最多选择 <input class="asregfe" type="text" name="max_sign_count" id="max_sign_count" readonly="readonly" value="<?php echo empty($rule['max_sign_count'])?'2':$rule['max_sign_count']?>" onkeyup='this.value=this.value.replace(/\D/gi,"")'/> 门课程
            </div>
            <div class="waisrhr">
                第一轮选课日期：
                <input class="erisre" type="text" name="start_t" id="start_t" value="<?php echo empty($rule['start_t'])?'':date('Y-m-d H:i',$rule['start_t'])?>" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm', 'isShowClear':true});" />
                <span style="margin:0 5px;">至</span>
                <input class="erisre" type="text" name="end_t" id="end_t" value="<?php echo empty($rule['end_t'])?'':date('Y-m-d H:i',$rule['end_t'])?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm','isShowClear':true});" readonly="readonly" />
            </div>
            <div class="hudtrke">
                <p>学生选课规则说明（第一轮）：</p>
                <textarea class="jeirew" name="remark" id="remark"><?php echo empty($rule['remark'])?'':$rule['remark']?></textarea>
            </div>
            <a class="fasres" href="javascript:;" onclick="savebtn()">保 存</a>
            </form>
        </div>
        <div class="jiweaes" style="width:750px;border:none;display: <?php if(empty($rule))echo 'none'?>" id="view">
            <div class="waisrhr">
                报名限制：每位学生最多选择 <?php echo empty($rule['max_sign_count'])?'':$rule['max_sign_count']?> 门课程
            </div>
            <div class="waisrhr">
                第一轮选课日期：<?php echo empty($rule['start_t'])?'':date('Y-m-d H:i',$rule['start_t'])?><span style="margin:0 5px;">至</span><?php echo empty($rule['end_t'])?'':date('Y-m-d H:i',$rule['end_t'])?>
            </div>
            <div class="hudtrke">
                <p>学生选课规则说明（第一轮）：</p>
                <p><?php echo empty($rule['remark'])?'':$rule['remark']?></p>
            </div>
            <a class="fasres" href="javascript:;" onclick="edit()">修 改</a>
        </div>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit2" style="display: none">
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
<div class="tanchukuangs" id="dialogedit1" style="display: none">
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
</body>
<script>

    function edit(){
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit2"),
            cancel: false,
            padding:1
//            fixed:true
        });
        $('.xzkctsxx').html('确定要编辑该活动规则吗？');
        d.show();
        $('.qkks').on('click',function(){
            d.close();
        });
        $('.jxxk').on('click',function(){
            d.close();
            $('#view').hide();
            $("#fbxk").hide();
            $('#editview').show();
        });
    }
    function savebtn(){
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit1"),
            cancel: false,
            padding:1
//            fixed:true
        });
        $('.jxxk').on('click',function(){
            d.close();
            return;
        })
        if($('#remark').val()==''||$('#start_t').val()==''||$('#end_t').val()==''){
            $('.xzkctsxx').html('请完善信息');
            d.show();
            return;
        }
        if($('#max_sign_count').val()==0){
            $('.xzkctsxx').html('最多选择课程不能为0');
            d.show();
            return;
        }
        if($('#start_t').val()>$('#end_t').val()){
            $('.xzkctsxx').html('请填写正确日期');
            d.show();
            return;
        }
        var url = "<?= geturl('aroomv2/xuanke/reportcourserule')?>";
        $.ajax({
            url: url,
            type: "POST",
            data: $("#myform").serialize(),
            dataType: "text",
            success: function (data) {
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
                    $.showmessage({
                        img: 'success',
                        message: '设置规则成功',
                        title: '设置规则',
                        callback: function () {
                            location.reload();
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: '设置规则失败，请稍后再试或联系管理员',
                        title: '设置规则'
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
            content: document.getElementById("dialogedit2"),
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
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: data.msg,
                        title: '发布选课'
                    });
                }
            })
        });
    })
</script>
</html>
