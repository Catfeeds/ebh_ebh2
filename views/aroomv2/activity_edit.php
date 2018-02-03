<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
    <meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
    <meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>


    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20151103001"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
    <link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
    <link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xPhoto.js?v=3"></script>
    <script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
</head>

<style>
    table .biaoti{ font-size:14px; color:#333; font-weight:bold;}
    .submitBtn{ padding:15px 20px 0 0;}
    .edui-container{}
    .huide em{
        font-style: italic;

    }
    .huide strong em{
        font-weight: bold;
    }
    .huide em strong{
        font-style: italic;
    }
    .huide strong{
        font-weight: bold;
    }
</style>

<body>
<div style="width:980px; margin:0 auto;">
    <div class="ter_tit" style="width:970px;">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/activity.html">活动专区</a> >
        <?php if(empty($info)){?> <a href="/aroomv2/activity/add.html">发布活动</a><?php }else{?>
            编辑活动
        <?php }?>
    </div>
    <div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:980px;">
        <div id='atsrc' style="display: none;"></div>
        <br/>

        <form id="upform" action="preview.html" method="post" target="_blank">
            <input type="hidden" name="crid" value="<?php echo $info['crid']?>">
            <input type="hidden" name="aid" value="<?php echo $info['aid']?>">
            <input type="hidden" id="imgurl" name="imgurl" value="<?php echo $info['imgurl']?>">
            <table  width="70%" style="border:none;margin-top:15px;">
                <tr >
                    <td width="120" style="padding_top:120px;"><span class="biaoti" style="float:right;" >活动标题：</span></td>
                    <td width="880"><div ><span class="error" id="su" style="color:#999999;">请输入活动标题,最少两个字。</span></div></td>
                </tr>
                <tr>
                    <td colspan=2><input value="<?php echo $info['subject']?>" style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-top: 5px;width: 600px; margin-bottom: 10px;  padding-left:5px; margin-left:21px;" id="subject" name="subject" type="text" maxlength="30" onblur="subjs($(this).val())" /></td>
                </tr>
                <tr>
                    <td><span style="float:right;" class="biaoti">活动时间：</span></td>
                    <td width="880"><div ><span class="error" id="timedata" style="color:#999999;">请输入活动时间。</span></div></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <input type='text' value="<?php echo $info['starttime']?>" name="starttime" id="starttime" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-top: 5px;width: 150px; margin-bottom: 10px;  padding-left:5px; margin-left:21px;*float:left;" maxlength="30" />
                        <span style="*display:block; *float:left;*line-height:35px;*padding-left:5px;">至:</span>
                        <input type='text' value="<?php echo $info['endtime']?>" name="endtime" id="endtime" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-top: 5px;width: 150px; margin-bottom: 10px;  padding-left:5px; margin-left:5px;*float:left;" maxlength="30" />
                    </td>
                </tr>
                <tr>
                    <td ><span style="float:right;" class="biaoti">活动图片：</span></td>
                    <td >
                        <div><label style="color:#999" id="guang">限JPG、PNG、GIF格式，图片清晰</label></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a title="点我上传活动图片" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey"><img style="float:left;" id="showclog" width=130px height=98px src="<?php echo !empty($info['imgurl']) ? $info['imgurl'] : 'http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg'?>"/></a>
                    </td>
                </tr>
                <tr>
                    <td><span style="float:right;" class="biaoti">活动摘要：</span></td>
                    <td>
                        <div style=""><span class="error" id="summ" style="color:#999999;">请输入活动摘要，字数控制在5-100个字之间。</span></div>
                    </td>
                </tr>
                <tr>
                    <td colspan=2 ><textarea class="w545" id="summary" name="summary" rows="2" maxLength="100" style="resize:none;height: 70px; width: 600px;padding:4px;float:left;margin-left:21px;  margin-bottom:10px; margin-top:5px;" onblur="nots(this.value)" ><?php echo $info['summary']?></textarea></td>
                </tr>
                <tr>
                <tr>
                    <td><span style="float:right;" class="biaoti" >活动内容：</span></td>
                    <td><div><em class="error" id="messa"></em></div></td>
                </tr>
                <tr>
                    <td colspan=2 >
                        <div style=" margin-bottom:10px; margin-top:5px;margin-left:21px;" class="huide"> <?php $editor->createEditor('message',"750px",'450px',$info['message']);?></div>
                    </td>
                </tr>
            </table>
            <div class="clear"></div>
            <div class="submitBtn" style="width:400px;">
                <input id="savebtn" class="huangbtn marrig" type="button" value="保存" name="">
<!--                <a class="lanbtn" href="/aroomv2/activity/preview.html?" target="_blank" >预览</a>-->
                <input class="lanbtn" type="submit" value="预览">
<!--                <a href="javascript:;" onclick="preview()" id="preview" class="lanbtn">预览</a>-->
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    <!--
    //输入字符长度
    var subje = false;
    var time = false;
    var mes = false;
    var not = false;
    function submit(){
        subjs($("#subject").val());
        times($("#starttime").val(),$("#endtime").val());
        mess();
        nots($("#summary").val());
        if(subje&&time&&mes&&not){
            return true;
        }else{
            return false;
        }
    }
    function checkansilen(inputString){
        return inputString.replace(/[\u0391-\uFFE5]/g,'**').length;
    }
    function subjs(subject){
        if(subject == "" || checkansilen(subject)<4){
            $("#su").html("请输入活动标题,最少两个字。");
            $("#su").css('color','red');
            subje = false;

        }else{
            $("#su").html("请输入活动标题,最少两个字。");
            $("#su").css('color','#999999');
            subje = true;
        }
    }
    function times(start,end){
        if(start == '' || end == '' || end < start){
            $('#timedata').html('请输入正确的活动时间');
            $('#timedata').css('color','red');
            time = false;
        }else{
            $('#timedata').html('请输入活动时间');
            $('#timedata').css('color','#999999');
            time = true;
        }
    }
    function mess(){
        var message = ue.getContent();
        if(message == ""){
            $("#messa").html("请输入活动内容。");
            $("#messa").css('color','red');
            mes = false;
        }else{
            $("#messa").html("");
            mes = true;
        }
    }
    function nots(note){
        if(note == "" || checkansilen(note)<10 || checkansilen(note)>200){
            $("#summ").css('color','red');
            not = false;

        }
        else{
            $("#summ").css('color','#999999');
            not = true;
        }
    }
    function preview(){
        var data = $('#upform').serialize();
        var url = '/aroomv2/activity/preview.html?data='+data;
        window.open(url,'_blank')
    }
    //    $(function(){
    //        $("#note").keyup(function(){
    //            var num =$("#note").val();
    //            if(num.length>100){
    //                document.getElementById("note").value = document.getElementById("note").value.substring(0, 100);
    //            }
    //            return false;
    //        })
    //    })
    //-->
    $("#savebtn").click(function(){
        if(submit()){
            var url = "<?= geturl('aroomv2/activity/edit')?>";
            $.ajax({
                url: url,
                type: "POST",
                data: $("#upform").serialize(),
                dataType: "text",
                success: function (data) {
                    var data = eval('(' + data + ')');
                    if (data.msg == 'success') {
                        $.showmessage({
                            img: 'success',
                            message: '编辑活动成功',
                            title: '编辑活动',
                            callback: function () {
                                document.location.href = "<?= geturl('aroomv2/activity') ?>";
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                            }
                        });
                    } else {
                        $.showmessage({
                            img: 'error',
                            message: '编辑活动失败，请稍后再试或联系管理员',
                            title: '编辑活动'
                        });
                    }
                }
            });
        }
    });


    //准备一个xPhoto实例(用时调用)
    function preparexPhoto(id,callback,initpicurl,upurl){
        var upurl = 'http://up.ebh.net/imghandler.html?type=pic&subtype=datainforpic';
        window.xphoto = new xPhoto({
            id:id,
            title:'图片上传',
            callback:callback,
            initpicurl:initpicurl,
            upurl:encodeURIComponent(upurl),
            cancelcallback:function(){
                window.xphoto.doClose();
            },
            sizearr:new Array('130_98','100_75','300_226'),
            sizemsgarr:new Array('图片尺寸为130*98','图片尺寸为100*75','图片尺寸为300*226')
        });
        window.xphoto.renderDialog();
    }

    $(function(){
        var imgurl = $('#showclog').attr('src');
        if(imgurl=='http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg'){
            var imgurl = '';
        }
        window.preparexPhoto("photouploader",callback,imgurl);
    });
    function uploadlogo(){
        window.xphoto.doShow();
    }
    //flash消息通知处理接口
    function callback(res){
        res = $.parseJSON(res);
        msghandle(res);
    };
    function msghandle(res){
        if(res && res.status == 0){
            $('#showclog').attr('src',res.url);
            $('a.jnlihrey').attr('title','点我重新上传');
            $("#imgurl").val(res.url);
            //$("#showlogo,#dellogo").show();
            alert("上传成功");
        }else{
            alert("上传失败");
        }
        window.xphoto.doClose();
    }

    //function showlogo(){
    //	var src = $("#logo").val();
    //	window.HTools.hShow("<img src='"+src+"'>",true);
    //}
    //function dellogo(){
    //	$("#logo").val('');
    //	$("#showlogo,#dellogo").hide();
    //}

    $('.readonly').keydown(function(e){
        return false;
    });
</script>
</body>
</html>