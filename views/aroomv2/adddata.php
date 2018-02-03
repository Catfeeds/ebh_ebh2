<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002">
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" /> 
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/ebhDialog.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20160808001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />   
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<title></title>
</head>
<style type="text/css">
.xiabotm{
    margin:0 0 20px 155px;
}
.topsele{
    height: 100%;
    line-height:21px;
}
.upprogressbox{
    width: 410px;
}
a.trsires:hover ,a.lisnret:hover {
    color:#fff;
}
</style>
<body>
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a> >
        <a href="/aroomv2/health.html">体质健康管理</a>
        > 数据导入
    </div>
    <div class="lefrigs">
    <form id="inputform" action="<?=geturl('aroomv2/health/input')?>" method="post" enctype="multipart/form-data">
        <div class="topsele">
            <span class="zsrwen">选择文件：</span>
            <div style="width:850px;_margin-top:20px;margin-left:78px;">
                <?php $upcontrol->upcontrol('image',13,false,'askimage'); 
                ?>
            </div>
        </div>
        <div class="xxsauern">
            <span class="zsrwen">选择学年：</span>
          <select class="hnusrat" name="select" id="select" onchange="choose(this);">
            <?php if(!empty($sylist)){?>
                <?php foreach ($sylist as $key => $sy) { ?>
                        <option value="<?php echo $sy['syid'];?>" status="<?php echo $sy['status']?>"><?php echo $sy['syname']?>学年</option>  
                <?php } ?>
            <?php }else{?>
                <option value="0" status="1">暂无学年</option>
                <?php } ?>
          </select>
            <a class="newase" href="javascript:;" onclick="show_dialog()">新建学年</a>
            <div class="tasnre" style="display:none">
              <input class="txtyser" type="text" value="请输入年份数字" name="textfield" id="textfield" /><span class="tzrenias">学年</span>
              <a class="lisnret" href="javascript:;" onclick="saveadd()">确定</a>
              <a class="acshkont" href="javascript:;">取消</a>
            </div>
        </div>
        </form>
        <div class="jusrsae">
            <p>注意<span class="hosrne">（非常重要）</span>：</p>
            <p>1.导入系统目前支持xls格式文件，暂不支持xlsx格式文件。</p>
            <p>2.导入的excel文件必须严格按照导入模板格式。<a class="lisars" href="http://static.ebanhui.com/ebh/file/health.xls" target="_blank">导入模板下载</a></p>
            <p>2.请务必选择正确的学年导入数据。</p>
            <a class="trsires" href="javascript:;">提交</a>
        </div>
        <?php if(isset($inputresult) && $inputresult['errormsg'] == 1){?>
        <div class="xiabotm">
            <h2 class="titsezdz">以下学生数据导入失败，请核对学生在平台上是否存在。</h2>
            <?php foreach ($inputresult['errorarr'] as $key=>$value) { ?>
                <?php foreach ($value as $v) { ?>
                    <?php foreach ($v as $v1) { ?>                   
                <p class=""><span class="listsd"><?php echo $key?></span><span class="listsd"><?php echo $v1?></span></p>
                    <?php }?>
                <?php }?>
            <?php }?> 
            <?php ?>   
        </div> 
        <?php }if(isset($inputresult) && $inputresult['errormsg'] == 2){?>
        <div class="xiabotm">
            <h2 class="titsezdz">以下学生数据导入失败，以下的学生姓名重复。</h2>
            <?php foreach ($inputresult['errorarr'] as $key => $value) { ?>
                <?php 
                    $classarr = array();
                    $classarr = explode('-',$key);

                ?>
                    <?php for($i=0;$i<=$value;$i++){?>
                        <p class=""><span class="listsd"><?php echo $classarr[0];?></span><span class="listsd"><?php echo $classarr[1];?></span></p>
                        <?php }?>
            <?php } ?>
        </div>
        <?php }if(isset($inputresult) && $inputresult['errormsg'] == 3){?>
        <div class="xiabotm">
            <h2 class="titsezdz">请核对下列班级信息是否存在。</h2>
            <?php foreach ($inputresult['errorarr'] as $value) { ?>
                <p><span class="listsd" style="float:none"><?php echo $value;?></span></p>
            <?php } ?>
        </div>
        <?php }?>
            <?php if(isset($inputresult) && $inputresult['errormsg'] == 4){ ?> 
                <div class="xiabotm">
                <h2 class="titsezdz">请核对下列行班级或姓名为空。</h2> 
            <?php foreach ($inputresult['errorarr'] as $key => $value) { ?> 
                <p class=""><span class="listsd">第<?php echo $key;?>行</span><span class="listsd"></span></p>

            <?php } ?>
                </div>
        <?php }else{ ?>
            <?php if(isset($inputresult['errormsg']) && !is_numeric($inputresult['errormsg'])){?>
                <?php if(!empty($inputresult['errormsg'])){?>
        <div class="xiabotm">
            <h2 class="titsezdz"><?php echo $inputresult['errormsg'];?></h2>
        </div>
            <?php }?>
        <?php }?>
        <?php } ?>       
    </div>
    <div id="loadparent1" style="display:none">
    <div id="loadparent" style="float:left;display:inline;">
        <div id="loadimg" style="width:100px;height:100px;margin:0 auto; left:335px;top:-220px;position:relative;">
        <img title="加载中..." src="http://static.ebanhui.com/ebh/images/loading.gif"/>
        </div>
    </div>
    </div>
</body>
<script type="text/javascript">
$(function(){
    $(".newase").click(function(e){
        $(".tasnre").toggle();
        e.stopPropagation();
    });
    $(document).click(function(){
        $(".tasnre").hide();
    })
    $(".tasnre").click(function(e){
        e.stopPropagation();
    });
    $(".acshkont").click(function(){
        $(".tasnre").hide();
        $('.txtyser').val('请输入年份数字');
        $(this).css('color','#999');
    });
})
function show_dialog(){
    $(".txtyser").focus(function(){
        if($(this).val() == '请输入年份数字'){
            $(this).val('');
            $(this).css('color','#666');
        }
    });
    $(".txtyser").blur(function(){
        if($(this).val() == ''){
            $(this).val('请输入年份数字');
            $(this).css('color','#999');
        }
    });
}
function saveadd(){
    var schoolyear = $('.txtyser').val();
    if(schoolyear == '' || schoolyear == '请输入年份数字'){
        return false;
    }
    if(isNaN(schoolyear)){
        var a = $.showAlert("添加学年", "学年只能为数字！", 2000,"",false);
        return false;
    }
    var url = '<?=geturl('aroomv2/health/addschoolyear')?>'
    $.ajax({
                type:'POST',
                url:url,
                data:{'schoolyear':schoolyear},
                dataType:'json',
                success:function(data){
                    if(data.status){
                        $(".tasnre").toggle();
                        $('.txtyser').val('请输入年份数字');
                        var html = '<option value="'+data.id+'" selected="selected" status="0">'+schoolyear+'学年</option>';
                        if($('#select').find('option').first().length > 0){//判断是否存在节点
                            $('#select option:checked').removeAttr('selected');
                            $('#select').find('option').first().before(html);
                        }else{
                            $('#select').append(html);
                        }
                        $(".trsires").css('background','#5e96f5');
                        $(".trsires").unbind('click');
                        $(".trsires").click(function(){
                            if(check()){
                                $("#loadparent1").show();
                                $("#inputform").submit();
                                $(".trsires").attr('disabled','disabled');
                                $(".trsires").css('background','#666');
                            }
                                
                            }
                        );
                    }else{
                        $.showAlert("错误", data.msg, 2000,'',false);
                        setTimeout('location=location',2000);
                    }
                }
            });    
}
function choose(obj){
    var v = $(obj).val();
    var cyid = $(obj).val();
    var option = $("#select").find("option[value="+v+"]");
    var status = $(option).attr('status');
    if(status == 1){
        $(".trsires").css('background','#666');
        $(".trsires").unbind('click');
        $(".trsires").click(function(){
            $(function(){
                $.showAlert("体质健康管理",'该学年已经锁定，请重新选择或新建学年！',2000,"",false);
            })
        })
    }else{
        $(".trsires").css('background','#5e96f5');
        $(".trsires").unbind('click');
        $(".trsires").click(function(){
            if(check()){
                $("#loadparent1").show();
                $("#inputform").submit();
                $(".trsires").attr('disabled','disabled');
                $(".trsires").css('background','#666');
            }
        }
        );
        
        
    }
}
function check(){
    var file = $("#inputfile").val();
    var syid = $('#select option:checked').val();
    if(file == '' || syid == ''){
        var a = $.showAlert("错误", "学年或文件不能为空！", 2000,"",false);
        setTimeout('location=location',2000);
        return false;
    }
    return true;
}
$(function(){
    var status = $('#select option:checked').attr('status');
    if(status == 1){
        $(".trsires").css('background','#666');
        $(".trsires").click(function(){
            $(function(){
                $.showAlert("体质健康管理",'该学年已经锁定，请重新选择或新建学年！',2000,"",false);
            })
        })
    }else{
        $(".trsires").unbind('click');
        $(".trsires").click(function(){
            if(check()){
                $("#loadparent1").show();
                $("#inputform").submit();
                $(".trsires").attr('disabled','disabled');
                $(".trsires").css('background','#666');  
            }
        });
    }
});
<?php if(isset($success) && $success['status'] == 'success'){
    echo '$(function(){var data = '.$success['data'].';$.showAlert("体质健康管理", "导入成功！本次一共导入'.$success['data'].'条数据！", 2000,"",false);});';
 } ?>
</script>
<?php $this->display('aroomv2/page_footer')?>
</html>
