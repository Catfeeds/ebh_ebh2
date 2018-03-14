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
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
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
.jieresd {
    color: #666;
    float: left;
    font-size: 16px;
    margin: 10px 0 10px 20px;
    width: 725px;
}
a.jisere {
    border: 1px solid #ddd;
    float: left;
    height: 24px;
    line-height: 24px;
    margin-right: 10px;
    padding: 0 10px;
}
a.chenfse {
    background: #17a8f7 none repeat scroll 0 0;
    color: #fff;
    float: left;
    height: 26px;
    line-height: 26px;
    margin-right: 10px;
    padding: 0 10px;
}
.huisre {
    float: left;
    max-height: 105px;
    margin-left: 80px;
    margin-top: 10px;
    overflow: auto;
    width: 655px;
}
.lantewu {
    background: #ffa631 none repeat scroll 0 0;
    color: #fff;
    float: left;
    height: 22px;
    line-height: 22px;
    margin-right: 16px;
    margin-top: 12px;
    padding: 0 7px;
    position: relative;
	font-size:14px;
}
.languan {
    background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/hrsire.png) no-repeat scroll 0 0;
    height: 17px;
    position: absolute;
    right: -8px;
    top: -8px;
    width: 17px;
}
.xzxstck {
    width: 780px;
}
.xzxstckright {
    width: 572px;
    
}
</style>

<body>
<div style="width:980px; margin:0 auto;">
    <div class="ter_tit" style="width:970px;">
        当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/activity.html">活动专区</a> ><a href="/aroomv2/activity/add.html">发布活动</a>
    </div>
    
    <div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:980px; height:1150px;">
        <br/>

        <form id="upform" action="preview.html" method="post" target="_blank">
            <input type="hidden" value="" name="imgurl" id="imgurl" />
            <table  width="70%" style="border:none;margin-top:15px;">
                <tr >
                    <td width="120" style="padding_top:120px;"><span class="biaoti" style="float:right;" >活动标题：</span></td>
                    <td width="880"><div ><span class="error" id="su" style="color:#999999;">请输入活动标题,最少两个字。</span></div></td>
                </tr>
                <tr>
                    <td colspan=2><input style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-top: 5px;width: 600px; margin-bottom: 10px;  padding-left:5px; margin-left:21px;" id="subject" name="subject" type="text" maxlength="30" onblur="subjs($(this).val())" /></td>
                </tr>
                <tr>
                    <td><span style="float:right;" class="biaoti">活动时间：</span></td>
                    <td width="880"><div ><span class="error" id="timedata" style="color:#999999;"></span></div></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <input type='text' name="starttime" id="starttime" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-top: 5px;width: 150px; margin-bottom: 10px;  padding-left:5px; margin-left:21px;*float:left;" maxlength="30" />
                        <span style="*display:block; *float:left;*line-height:35px;*padding-left:5px;">至:</span>
                        <input type='text' name="endtime" id="endtime" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" style=" border: 1px solid #A0B5BB; height: 24px; line-height: 24px;margin-top: 5px;width: 150px; margin-bottom: 10px;  padding-left:5px; margin-left:5px;*float:left;" maxlength="30" />
                    </td>
                </tr>
				<tr>
                    <td colspan=2>
						<div class="jieresd">
							<span class="fl biaoti">活动限制：</span>
							<a class="chenfse jisere" id="allschool" href="javascript:void(0);">全校</a>
							<a class="jisere jisere1" href="javascript:void(0);" id="banji" onclick="showactivity()">限班级</a>
							<a class="jisere jisere1" href="javascript:void(0);" id="kecheng" onclick="showactivity()">限课程</a>
							<div class="huisre">
								<ul id="wrap">
								</ul>
							</div>
						</div>
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
                        <a title="点我上传活动图片" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey"><img style="float:left;" id="showclog" width=130px height=91px src="http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg"/></a>
                    </td>
                </tr>
                <tr>
                    <td><span style="float:right;" class="biaoti">活动摘要：</span></td>
                    <td>
                        <div style=""><span class="error" id="summ" style="color:#999999;">请输入活动摘要，字数控制在5-100个字之间。</span></div>
                    </td>
                </tr>
                <tr>
                    <td colspan=2 ><textarea class="w545" id="summary" name="summary" rows="2" maxLength="100" style="resize:none;height: 70px; width: 600px;padding:4px;float:left;margin-left:21px;  margin-bottom:10px; margin-top:5px;" onblur="nots(this.value)" ></textarea></td>
                </tr>
                <tr>
                    <td><span style="float:right;" class="biaoti" >活动内容：</span></td>
                    <td><div><em class="error" id="messa"></em></div></td>
                </tr>
                <tr>
                    <td colspan=2 >
                        <div style=" margin-bottom:10px; margin-top:5px;margin-left:21px;" class="huide"> <?php $editor->createEditor('message',"750px",'450px',$default);?></div>
                    </td>
                </tr>
            </table>
            <div class="clear"></div>
            <div class="submitBtn" style="width:400px;">
                <input id="savebtn" class="huangbtn marrig" type="button" value="保存" name="">
                <input type="submit" class="lanbtn" value="预览">
<!--                <a href="javascript:;" onclick="preview()" id="preview" class="lanbtn">预览</a>-->
            </div>
        </form>
    </div>
</div>
<div id="activityDialog" class="taneret" style="display:none">
<div class="xzxstck">
    <div class="xzxstcktop">
        <div class="xzxstckleft">
            <div class="qbxsabjnj">
                <div class="qbxs">
                    <span class="fl" onclick="chooseAll();H.get('activityDialog').exec('close');">全部学生</span>
                </div>
                <div class="qbxs1" id="type11">
                    <span class="fl qbxs1span qbxs1span1" onclick="getListByAjax(<?=$crid?>,1);" id="type1">按班级</span>
                </div>
                <div class="qbxs1" id="type12">
                    <span class="fl qbxs1span qbxs1span2" onclick="getListByAjax(<?=$crid?>,2)" id="type2">按课程</span>
                </div>
            </div>
        </div>
        <div class="xzxstckright">
        </div>
    </div>
    <div class="clear"></div>
    <div class="xuanbtn2s"><a href="javascript:void(0)" class="jxxk"  style="margin-top: 15px;"onclick="enter();H.get('activityDialog').exec('close');">确认</a></div>
</div>
</div>
<script type="text/javascript">
    <!--
    //输入字符长度
    var subje = false;
    var time = false;
    var mes = false;
    var not = false;
   initdefault();
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
  /*  function enter(){
    var fold = folderids;
    var classes = classids;
    var url = "<?= geturl('aroomv2/activity/enter')?>";
    $.ajax({
        url:url,
        type:"POST",
        data:{fold:fold,classes:classes},
        dataType:"text",
        success:function(data){
            alert($("#wrap li").html());
        }
    });
}*/
//    function preview(){
//        var data = $('#upform').serialize();
//        var url = '/aroomv2/activity/preview.html?data='+data;
//        window.open(url,'_blank')
//    }
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
            var url = "<?= geturl('aroomv2/activity/add')?>";
            $.ajax({
                url: url,
                type: "POST",
                data: $("#upform").serialize(),
                dataType: "text",
                success: function (data) {
                    var data = eval('(' + data + ')');
                    if (data.msg == 'success') {
                        parent.folderids = '';
                        parent.classids = '';
                        parent.page = 1;
                        $.showmessage({
                            img: 'success',
                            message: '添加活动成功',
                            title: '添加活动',
                            callback: function () {
                                document.location.href = "<?= geturl('aroomv2/activity') ?>";
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                            }
                        });

                    } else {
                        $.showmessage({
                            img: 'error',
                            message: '添加活动失败，请稍后再试或联系管理员',
                            title: '添加活动'
                        });
                    }
                }
            });
        }
    });

    $("#allschool").click(function(){
        $(".chenfse").removeClass('chenfse');
        $("#allschool").addClass('chenfse');
        //$("#wrap").remove();
    });
    //准备一个xPhoto实例(用时调用)
    function preparexPhoto(id,callback,initpicurl,upurl){
        var upurl = 'http://up.ebh.net/imghandler.html?type=pic&subtype=datainforpic';
        xphoto = new xPhoto({
            id:id,
            title:'图片上传',
            callback:callback,
            initpicurl:initpicurl,
            upurl:encodeURIComponent(upurl),
            cancelcallback:function(){
                xphoto.doClose();
            },
            sizearr:new Array('130_91','100_70','360_252'),
            sizemsgarr:new Array('图片尺寸为130*91','图片尺寸为100*70','图片尺寸为360*252')
        });
        xphoto.renderDialog();
    }

    $(function(){
        var imgurl = $('#showclog').attr('src');
        if(imgurl=='http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg'){
            var imgurl = '';
        }
        preparexPhoto("photouploader",callback,imgurl);
        H.create(new P({
        id:'activityDialog',
        title:'选择对象',
        easy:true,
        content:$("#activityDialog")[0]
      }),'common');
    });
    function uploadlogo(){
        xphoto.doShow();
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
        xphoto.doClose();
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
    function showactivity(){
        H.get('activityDialog').exec('show');
    }
    function removed(obj,id,type){
        if(type == 1){
            s = $("[name='classids']").val();
            s = s + ',';
            s = s.replace(id+',','');
            s = s.replace(/(^\,*)|(\,*$)/g, "");
            $("[name='classids']").val(s);
            if(s == '' || s == null){
                $("[name='classids']").remove();
                $("[name='type']").remove();
            }
            $(obj).parent().remove();
        }
        if(type == 2){
            s = $("[name='folderids']").val();
            s = s + ',';
            s = s.replace(id+',','');
            s = s.replace(/(^\,*)|(\,*$)/g, "");
            $("[name='folderids']").val(s);
            if(s == '' || s == null){
                $("[name='classids']").remove();
                $("[name='type']").remove();
            }
            $(obj).parent().remove();
            //$(".folderids").val(s);
        }
    }
	function initdefault(){
		classids = '';
		folderids = '';
		page = 1;
	}
	var folderids='';
function addFolderids(folderid,obj){
	$('.qbxs3').each(function(){
		if($(this).hasClass('onhover')){
			$(this).removeClass('onhover');
		}
	});
	if($(obj).parent().children('a').hasClass('onhover')){
		var foldarr = folderids.split(folderid+',');
		folderids = '';
		for(i=0;i<foldarr.length;i++){
			folderids+=foldarr[i];
		}
		$(obj).parent().children('a').removeClass('onhover');
	}else{
		$(obj).parent().children('a').addClass('onhover');
		folderids+=folderid+',';
		folderids = $.trim(folderids,',');
	}
	page = 1;
		var url = "<?= geturl('aroomv2/activity/getStudentListByType')?>";
		$.ajax({
			url:url,
			type:"POST",
			data:{idlist:folderids,type:2,page:page},
			dataType:"text",
			success:function(data){
				$(".xzxstckright .xzxslist").remove();
				$(".xzxstckright .clear").remove();
				$(".xzxstckright p").remove();
				$(".xzxstckright").append(data);
			}
		});
	page = 1;
}

    function enter(){
    var fold = folderids;
    var classes = classids;
    var url = "<?= geturl('aroomv2/activity/enter')?>";
    $.ajax({
        url:url,
        type:"POST",
        data:{fold:fold,classes:classes},
        dataType:"text",
        success:function(data){
        	$('.huisre').html(data);
        	if(fold == '' && classes == ''){
        		return false;
        	}
        	if(fold == ''){
        		$('.chenfse').removeClass('chenfse');
        		$('#banji').addClass('chenfse');
        	}if(classes == ''){
        		$('.chenfse').removeClass('chenfse');
        		$('#kecheng').addClass('chenfse');
        	}
        }
    });
    page = 1;

}
	function shownexts(id,obj,checkbox){
	if(checkbox == ''){
		checkbox = 0;
	}
	if($(obj).prev().hasClass('selct')){
		$(obj).prev().removeClass('selct');
	}else{
		$(obj).prev().addClass('selct');
	}
	if($(obj).parent().children('a').hasClass('onhover')){
		$(obj).parent().children('a').removeClass('onhover');
		$('[pid='+id+']').each(function(){
		var l = $(this).find('.fl').attr('id');
		$(this).children('a').removeClass('onhover');
		x = l+',';
		classids = classids.replace(x,'');
	});
		var url = "<?= geturl('aroomv2/activity/getStudentListByType')?>";
	$.ajax({
		url:url,
		type:"POST",
		data:{idlist:classids,type:1,page:1,checkbox:checkbox},
		dataType:"text",
		success:function(data){
			$(".xzxstckright .xzxslist").remove();
			$(".xzxstckright .clear").remove();
			$(".xzxstckright p").remove();
			$(".xzxstckright").append(data);
		}
	});
	}else{
		$(obj).parent().children('a').addClass('onhover');
		$('[pid='+id+']').each(function(){
		var ll = $(this).find('.fl').attr('id');
		$(this).children('a').addClass('onhover');
		classids+=ll+',';
	});
	var url = "<?= geturl('aroomv2/activity/getStudentListByType')?>";
	$.ajax({
		url:url,
		type:"POST",
		data:{idlist:classids,type:1,page:1,checkbox:checkbox},
		dataType:"text",
		success:function(data){
			$(".xzxstckright .xzxslist").remove();
			$(".xzxstckright .clear").remove();
			$(".xzxstckright p").remove();
			$(".xzxstckright").append(data);
		}
	});
	}
}
	function chooseAll(){
		$('.chenfse').removeClass('chenfse');
		$('#allschool').addClass('chenfse');
		$('#wrap').remove();
	}
	function getListByAjax(crid,type,checkbox){
	if(checkbox == ''){
		checkbox = 0;
	}
	var type1;
	if(type == 1){
		folderids= '';
	}
	if(type == 2){
		classids = '';
	}
	$(".chenfse").removeClass('chenfse');
	if(type == 1){
		$("#banji").addClass('chenfse');
	}
	if(type == 2){
		$("#kecheng").addClass('chenfse');
	}
	if($(".ui-dialog2-body #type"+type).hasClass('selct')){
		$(".ui-dialog2-body #type"+type).removeClass('selct');
		if(type == 1){
			type1 = 2;
		}else{
			type1= 1;
		}
		if($(".ui-dialog2-body #type"+type1).hasClass('selct')){
			$(".ui-dialog2-body #type"+type1).removeClass('selct');
		}
	}else{
		$(".ui-dialog2-body #type"+type).addClass('selct');
		if(type == 1){
			type1 = 2;
		}else{
			type1= 1;
		}
		if($(".ui-dialog2-body #type"+type1).hasClass('selct')){
			$(".ui-dialog2-body #type"+type1).removeClass('selct');
		}
	}

	if($(".ui-dialog2-body #type"+type).hasClass('selct')){
		var url = "<?= geturl('aroomv2/activity/getTypeListAjax')?>";
        $.ajax({
                url: url,
                type: "POST",
                data: {crid:crid,type:type,checkbox:checkbox},
                dataType: "text",
                success: function (data) {
                	var id = 'qbxs1span'+type;
                	$(".ui-dialog2-body .qbxs2").remove();
                	$(".ui-dialog2-body .qbxs3").remove();
                	$('.ui-dialog2-body #type1'+type).after(data);
                }
            });
	}else{
		$(".ui-dialog2-body .qbxs2").remove();
        $(".ui-dialog2-body .qbxs3").remove();
	}
    }
	function shownext(id,obj,checkbox){
		if($('[pid='+id+']').is(":visible")){
			$('[pid='+id+']').hide();
		}else{
			$('[pid='+id+']').show();
		}
		if($(obj).hasClass('selct')){
			$(obj).removeClass('selct');
		}else{
			$(obj).addClass('selct');
		}
		if($(obj).parent().hasClass('onhover')){
			$(obj).parent().removeClass('onhover');
		}else{
			$(obj).parent().addClass('onhover');
		}
	}
var classids = '';
function addClassids(classid,obj,checkbox){
	$('.qbxs3').each(function(){
		if($(this).hasClass('onhover')){
			$(this).removeClass('onhover');
		}
	});
	if($(obj).parent().children('a').hasClass('onhover')){
		var foldarr = classids.split(classid+',');
		classids = '';
		for(i=0;i<foldarr.length;i++){
			classids+=foldarr[i];
		}
		$(obj).parent().children('a').removeClass('onhover');
	}else{
		$(obj).parent().children('a').addClass('onhover');
		classids+=classid+',';
		classids = $.trim(classids,',');
	}
	page = 1;
	var url = "<?= geturl('aroomv2/activity/getStudentListByType')?>";
	$.ajax({
		url:url,
		type:"POST",
		data:{idlist:classids,type:1,page:page,checkbox:checkbox},
		dataType:"text",
		success:function(data){
			$(".xzxstckright .xzxslist").remove();
			$(".xzxstckright .clear").remove();
			$(".xzxstckright p").remove();
			$(".xzxstckright").append(data);
		}
	});
	page = 1;
}
var page = 1 ;
function getmore(page,checkbox){
	var page1 = page + 1;
	$(".jzgds1").hide();
	$(".jzgds2").show();
	var url = "<?= geturl('aroomv2/activity/getNextStudentListByType')?>";
	if(classids != ''){
		$.ajax({
		url:url,
		type:"POST",
		data:{idlist:classids,type:1,page:page},
		dataType:"json",
		success:function(data){
			$.each(data,function(i,value){
				html = '';
				if(i != 'next'){
                    if(checkbox==1){
                        if(value['sex'] == 0){
                            html += '<li class="fl">';
                            if(value['face']!=''){
                                html+='<div onclick="check('+value['uid']+')"><input type="checkbox" id="c'+value['uid']+'" style="display: none" name="sel" class="xuanze" value="'+value['uid']+'"/><img src="'+value['face']+'" style="width:50px;height:50px;" title="';
                                if(value['realname']!=''){
                                html+=value['realname'];

                                }else{
								html+=value['username'];
                                }
                                html+='"/></div><p class="xingmingl">';
                            }else{
                                html+='<div onclick="check('+value['uid']+')"><input type="checkbox" id="c'+value['uid']+'" style="display: none" name="sel" class="xuanze" value="'+value['uid']+'"/><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title"';
                                if(value['realname']!=''){
                                html+=value['realname'];

                                }else{
								html+=value['username'];
                                }
                                html+='"/></div><p class="xingmingl">';
                            }
                        }else{
                            html += '<li class="fl">';
                            if(value['face']!=''){
                                html+='<div onclick="check('+value['uid']+')"><input type="checkbox" id="c'+value['uid']+'" style="display: none" name="sel" class="xuanze" value="'+value['uid']+'"/><img src="'+value['face']+'" style="width:50px;height:50px;" title="';
                                if(value['realname']!=''){
                                html+=value['realname'];

                                }else{
								html+=value['username'];
                                }
                                html+='"/></div><p class="xingmingl">';
                            }else{
                               html+='<div onclick="check('+value['uid']+')"><input type="checkbox" id="c'+value['uid']+'" style="display: none" name="sel" class="xuanze" value="'+value['uid']+'"/><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title"';
                                if(value['realname']!=''){
                                html+=value['realname'];

                                }else{
								html+=value['username'];
                                }
                                html+='"/></div><p class="xingmingl">';
                            }
                        }
                    }else{
                        if(value['sex'] == 0){
                            html += '<li class="fl">';
                            if(value['face']!=''){
                                html+='<div><img src="'+value['face']+'" style="width:50px;height:50px;" title="';
                                if(value['realname'] !=''){
                                	html+=value['realname'];
                                	html+='"/></div><p class="xingmingl">';
                                }else{
                                	html+=value['username'];
                                	html+='"/></div><p class="xingmingl">';
                                }
                            }else{
                                html+='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title="';
                                if(value['realname'] !=''){
                                	html+=value['realname'];
                                	html+='"/></div><p class="xingmingl">';
                                }else{
                                	html+=value['username'];
                                	html+='"/></div><p class="xingmingl">';
                                }
                            }
                        }else{
                            html += '<li class="fl">';
                            if(value['face']!=''){
                                 html+='<div><img src="'+value['face']+'" style="width:50px;height:50px;" title="';
                                if(value['realname'] !=''){
                                	html+=value['realname'];
                                	html+='"/></div><p class="xingmingl">';
                                }else{
                                	html+=value['username'];
                                	html+='"/></div><p class="xingmingl">';
                                }
                            }else{
                                html+='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg" style="width:50px;height:50px;" title="';
                                if(value['realname'] !=''){
                                	html+=value['realname'];
                                	html+='"/></div><p class="xingmingl">';
                                }else{
                                	html+=value['username'];
                                	html+='"/></div><p class="xingmingl">';
                                }
                            }
                        }
                    }
					if(value['realname'] != ''){
						html += value['realname1'];
					}else{
						html += value['username1'];
					}
                    if(checkbox==1){
                        html+='</p><a href="javascript:;" id="i'+value['uid']+'" class="fr xuanzq1s"></a></li>';
                    }else{
                        html+='</p></li>';
                    }
						$(".xzxslist ul li:last-child").after(html);
				}else{
					html = '';
					if(value == 1){
						html += '<a href="javascript:;" class="jzgds jzgds1" onclick="getmore('+page1+','+checkbox+');">加载更多...</a><a href="javascript:;" style="display:none" class="jzgds jzgds2">正在加载中...</a>';
						$(".jzgds1").parent().html(html);
					}
					if(value == 0){
						html += '没有更多';
						$(".jzgds1").parent().html(html);
					}
				}

			});
		}
	});
	}
	if(folderids != ''){
		$.ajax({
		url:url,
		type:"POST",
		data:{idlist:folderids,type:2,page:page},
		dataType:"json",
		success:function(data){
			$.each(data,function(i,value){
				html = '';
				if(i != 'next'){
					if(value['sex'] == 0){
						html += '<li class="fl">';
						if(value['face']!=''){
							html+='<div><img src="'+value['face']+'" style="width:50px;height:50px;"title="';
							if(value['realname'] !=''){
								html+= value['realname'];
							}else{
								html+= value['username'];
							}
							html+='"/></div><p class="xingmingl">';
						}else{
							html+='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg" style="width:50px;height:50px;" title="';
							if(value['realname'] !=''){
								html+= value['realname'];
							}else{
								html+= value['username'];
							}
							html+='"/></div><p class="xingmingl">';
						}
					}else{
						html += '<li class="fl">';
						if(value['face']!=''){
							html+='<div><img src="'+value['face']+'" style="width:50px;height:50px;"title="';
							if(value['realname'] !=''){
								html+= value['realname'];
							}else{
								html+= value['username'];
							}
							html+='"/></div><p class="xingmingl">';
						}else{
							html+='<div><img src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg" style="width:50px;height:50px;" title="';
							if(value['realname'] !=''){
								html+= value['realname'];
							}else{
								html+= value['username'];
							}
							html+='"/></div><p class="xingmingl">';
						}
					}

					if(value['realname'] != ''){
						html += value['realname1'];
					}else{
						html += value['username1'];
					}
					html+='</p></li>';
						$(".xzxslist ul li:last-child").after(html);
				}else{
					html = '';
					if(value == 1){
						html += '<a href="javascript:;" class="jzgds jzgds1" onclick="getmore('+page1+');">加载更多...</a><a href="javascript:;" style="display:none" class="jzgds jzgds2">正在加载中...</a>';
						$(".jzgds1").parent().html(html);
					}
					if(value == 0){
						html += '没有更多';
						$(".jzgds1").parent().html(html);
					}
				}

			});
		}
	});
	}
}

</script>
</body>
</html>