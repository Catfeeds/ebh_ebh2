<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
    <style type="text/css">
.siznwer {
    font-size: 14px;
}
</style>
<body>
<div class="">
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        >
        <a href="/aroomv2/xuanke.html">选课系统</a>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs">
        <form id="myform">
        <table width="100%" style="border:none;margin-top:15px;">
            <tbody>
            <tr>
                <td width="120">
                    <span class="siznwer">选课活动名称：</sp0an>
                </td>
                <td width="656">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input style="color: #000" type="text" class="txtshur" id="subject" name="activityname" maxlength="40" placeholder="例：2016第一学期选修课活动" maxlength="40">
                </td>
            </tr>
            <tr>
                <td width="120">
                    <span class="siznwer">选课活动说明：</span>
                </td>
                <td width="656">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea id="summary" class="txtdasr" maxlength="800" rows="2" name="summary" style="color: #000" placeholder="请简要介绍本次选修课活动的目的、期望效果、注意事项等相关内容。"></textarea>
                </td>
            </tr>
            <tr>
                <td width="120">
                    <span class="siznwer">教师申报日期：</span>
                </td>
                <td width="656">
                    <div>
                        <span id="timedata" class="error" style="color:#999999;">教师只能在该时间段内申报选修课程。</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input id="starttime" class="tsstime" type="text" maxlength="30" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',isShowClear:true});" readonly="readonly" name="starttime">
                    <span style="display:block;float:left;line-height:35px;margin-left:10px;">至:</span>
                    <input id="endtime" class="tsstime" type="text" maxlength="30" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',isShowClear:true});" readonly="readonly" name="endtime">
                </td>
            </tr>
            </tbody>
        </table>
        </form>
        <a href="javascript:;" id="submit"  class="fasres" style="*float:left;*display:inline-block;">发 布</a>
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
</body>
<script>
//    $('#summary').on('click',function(){
//        if(this.value=='请简要介绍本次选修课活动的目的、期望效果、注意事项等相关内容。'){
//            $('#summary').val();
//        }
//    })
$("#submit").click(function(){
    var d = dialog({
        title: false,
        content: document.getElementById("dialogedit2"),
        cancel: false,
//            width:390,
//            height:187,
        drag:true,
        padding:1,
        drag:true
    });
    $('.jxxk').on('click',function(){
        d.close();
    })

    if($('#starttime').val()>$('#endtime').val()){
        $('.xzkctsxx').html('请填写正确日期');
        d.show();
        return;
    }
    if($('#subject').val()==''||$('#summary').val()==''||$('#starttime').val()==''||$('#endtime').val()==''){
        $('.xzkctsxx').html('请完善信息');
        d.show();
        return;
    }
    var subject = $('#subject').val();
    var summary = $('#summary').val();
    if($.trim(subject)==''|| $.trim(summary)==''){
        $('.xzkctsxx').html('请完善信息');
        d.show();
        return;
    }
    $('#submit').hide();
        var url = "<?= geturl('aroomv2/xuanke/xuanke_add')?>";
        $.ajax({
            url: url,
            type: "POST",
            data: $("#myform").serialize(),
            dataType: "text",
            success: function (data) {
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
//                    $.showmessage({
//                        img: 'success',
//                        message: '添加活动成功',
//                        title: '添加活动',
//                        callback: function () {
                            document.location.href = "<?= geturl('aroomv2/xuanke') ?>";
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
//                        }
//                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: '添加活动失败',
                        title: '添加活动'
                    });
                }
            }
        });
});</script>
</html>
