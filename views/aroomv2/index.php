<?php $this->display('aroomv2/room_header');
if($this->input->cookie('refer'))
	$mainurl = urldecode($this->input->cookie('refer'));
else
	$mainurl = $haspower == 2 ? geturl('aroomv2/tlist') : geturl('aroomv2/tutorial');
$this->input->setCookie('refer','');
?>
<style>
    .ui-dialog-footer .ui-dialog-button{
        text-align:center;
        float:inherit !important;
    }

	.qbxs3.hovered,.qbxs2.hovered{
		background:#c6dafb;
	}
	.xuanzq.hovered{
		background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/xzh.png) no-repeat left center;
	}
     .grade{
         height: auto;
     }

</style>
<!--[if lte IE 6]>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
  DD_belatedPNG.fix('.menubox ul li i,.extendbox ul li i,.bottom,.cservice img,.sukan .xinke span,.sukan .zuoye span,.sukan .zhibo span,.sukan .jieda span');
</script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=222"/>
<script src="http://static.ebanhui.com/ebh/js/jquery/jquery.fileDownload.js?version=20150307001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script src="/lib/um/umeditor.config.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/feedback.js"></script>
<script type="text/javascript" src="/lib/um/umeditor.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002"/>

<style>

.xzkctsxx{
	font-size:16px;
	padding-top:25px;
	margin-top:0;
    color: #333;
    text-align: center;
	width:260px;
	margin:0 auto;
}
.ui-dialog-grid{
	font-family:微软雅黑;
	font-family::Microsoft Yahei;
}
.toolbarx a{
	text-decoration: none !important;
}
.tQRCode{
	position:relative;
	display:none;
	left: -162px;
	position: absolute;
	top: -82px;
	padding-right:19px;
	vertical-align: bottom;
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/wxxx2.png) right bottom no-repeat;
}
.tQRCode img{background-color:#fff;}
</style>
<script type="text/javascript">
var windowHeight = $(window).height();
var documentHeight = $(document).height();
var resetmain = function(hash){
	var mainFrame = document.getElementById("mainFrame");
	var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+50;
	iframeHeight = iframeHeight<665?665:iframeHeight;
	$(mainFrame).height(iframeHeight);
	documentHeight = $(document).height();
	if (hash) {
		location.hash = hash;
	}
};
var gotoHash = function(hash) {
	location.hash = hash;
};

//图片预览
function prev(jo) {
    jo.each(function() {
        $(this).lightBox();
    });
}

$(function(){
	var myroomitem_li =$(".myroomitem li");
	myroomitem_li.hover(function(){
		$(this).addClass("itemcurr");
	},function(){
		$(this).removeClass("itemcurr");
	});

})
function showdetail() {
	var src = "<?= geturl('troom/setting/upmessage') ?>";
	//src = src + "?t=" + Math.random();

	if ($("#dislog").attr("src") != src)
	{
		$("#dislog").attr("src",src);
	}

	H.create(new P({
		id:'dialogdiv',
		url:src,
		width:968,
		height:735,
		title:'平台详细介绍修改',
		easy:true
	}),'common').exec('show');

}
function closedetail(status) {
	H.get('dialogdiv').exec('close');
	$("#dislog").attr("src","about:blank");
}
function closeintroduce(status) {
	H.get('courseintroduce').exec('close');
	$("#dislog").attr("src","about:blank");
}
function showintroduce(folderid){
	var src = "/aroomv2/course/introduce/add/"+folderid+".html";
	//src = src + "?t=" + Math.random();

	if ($("#dislog").attr("src") != src)
	{
		$("#dislog").attr("src",src);
	}

	H.create(new P({
		id:'courseintroduce',
		url:src,
		width:968,
		height:720,
		title:'课程介绍',
		easy:true
	}),'common').exec('show');

}
//===========导出组件================
/**
 *依赖jquery.js common2.js?version=20150528001 jquery.fileDownload.js
 */
var exportTools = function(url){
	this.url = url;
	this.init();
}
exportTools.loadModal = function(off_on){
	if(off_on){
		if(H.get('loadDialog')){
			H.get('loadDialog').exec('setContent','正在为您导出，请耐心等待').exec('show');
		}else{
			H.create(new P({
				content:'正在为您导出，请耐心等待',
				id:'loadDialog',
				easy:true,
				padding:20
			}),'common').exec('show');
		}
	}else{
		H.get('loadDialog').exec('setContent','导出成功').exec('close',500);
	}
};
exportTools.delcookie = function(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=exportTools.getcookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
exportTools.getcookie = function(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null){
        return unescape(arr[2]);
    }else{
        return "";
    }
}
exportTools.prototype = {
	init:function(){
	},
	setUrl:function(url){
		this.url = url;
	},
	run:function(){
		this.doexport();
	},
	setSuccessCallback:function(sCallback){
		this.successCallback = sCallback;
	},
	setPrepareCallback:function(pCallback){
		this.prepareCallback = pCallback;
	},
	doexport:function (){
		var me = this;
		var tag = new Date().getTime();
		this.requrl = this.url+"&tag="+tag;
		this.prepareCallback(this.requrl);
		$.fileDownload(this.requrl,{
			'successCallback':me.successCallback,
			'cookieName':'ebh_export',
			'cookieValue':tag
		});
	},
	successCallback:function(url){
		exportTools.loadModal(0);
		exportTools.delcookie('ebh_export');
	},
	prepareCallback:function(url){
		exportTools.loadModal(1);
	}

}
//===========导出组件结束================
function closeedit(){
	H.get('courseintroduceedit').exec('close');
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course2.js"></script>
<script>
/**
*播放视频
*/
function playflv_top(source,cwid,title,isfree,num,height,width,hasbtn,callback){
	var url = source+"attach.html?examcwid="+cwid;
	url = encodeURIComponent(url);
	if(hasbtn == undefined)
		hasbtn = 0;
	var vars = {
		source: url,
		type: "video",
		streamtype: "file",
		server: "",
		duration: "52",
		poster: "",
		autostart: "false",
		logo: "",
		logoposition: "top left",
		logoalpha: "30",
		logowidth: "130",
		logolink: "http://www.ebanhui.com",
		hardwarescaling: "false",
		darkcolor: "000000",
		brightcolor: "4c4c4c",
		controlcolor: "FFFFFF",
		hovercolor: "67A8C1",
		controltype: 1,
		classover: hasbtn
	};
	H.create(new P({
		title:'视频播放',
		easy:true,
		flash:HTools.pFlash({'id':'playflv','uri':"http://static.ebanhui.com/ebh/flash/videoFlvPlayer.swf",'vars':vars})
	}),'common').exec('show');
}

function showplayDialog(source,cwid){
	if(typeof courseObj == "undefined"){
		courseObj = new Course();
	}
	if(!source || !cwid){
		return false;
	}
	courseObj.userplay(source,cwid);return false;
}
function createDialog(url){
	window.H.create(new window.P({
					title:'记录查看',
					content:$("#logdialog")[0],
					id:'slogDialog',
					easy:true
				},{
					'onshow':function(){
						$("#logframe",window.document.body).attr("src",url);
					},
					'onclose':function(){
						$("#logframe",window.document.body).attr("src","");
					}
				}),'common').exec('show');
}

var element;
var element2;
function showcourseedit(_element,_element2){
	H.create(new P({
		id:'courseintroduceedit',
		content:$('#editordiv'),
		width:968,
		height:720,
		title:'课程介绍',
		easy:true
	}),'common').exec('show');
	element = _element;
	element2 = _element2;

	$('#title').val(_element2.html());
	ue.setContent(element.html());
	// console.log(element);
}
function edite(){
	var c = UM.getEditor('courseeditor').getContent();
	var t = $('#title').val();
	element.html(c);
	element2.html(t);
	if(t=='' || t=='请填写模块名称'){
		alert('请填写模块名称');
	}else{
		closeedit();
	}
	resetmain();
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
	window.frames["mainFrame"].$(".chenfse").removeClass('chenfse');
	if(type == 1){
		window.frames["mainFrame"].$("#banji").addClass('chenfse');
	}
	if(type == 2){
		window.frames["mainFrame"].$("#kecheng").addClass('chenfse');
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
	window.frames["mainFrame"].$('.chenfse').removeClass('chenfse');
	window.frames["mainFrame"].$('#allschool').addClass('chenfse');
	window.frames["mainFrame"].$('#wrap').remove();
}
function initdefault(){
	classids = '';
	folderids = '';
	page = 1;
}
function showthis(id,obj){
	$('.qbxs2').each(function(){
		if($(this).hasClass('onhover')){
			$(this).removeClass('onhover');
		}
	});
	$('.qbxs3').each(function(){
		if($(this).hasClass('onhover')){
			$(this).removeClass('onhover');
		}
	});
	$(obj).parent().addClass('onhover');
	page = 1;
	var url = "<?= geturl('aroomv2/activity/getStudentListByType')?>";
	$.ajax({
		url:url,
		type:"POST",
		data:{idlist:id,type:1,page:page,checkbox:0},
		dataType:"text",
		success:function(data){
			$(".xzxstckright .xzxslist").remove();
			$(".xzxstckright .clear").remove();
			$(".xzxstckright p").remove();
			$(".xzxstckright").append(data);
		}
	});
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
function showthiss(id,obj){
	$('.qbxs2').each(function(){
		if($(this).hasClass('onhover')){
			$(this).removeClass('onhover');
		}
	});
	$('.qbxs3').each(function(){
		if($(this).hasClass('onhover')){
			$(this).removeClass('onhover');
		}
	});
	$(obj).parent().addClass('onhover');
	page = 1;
		var url = "<?= geturl('aroomv2/activity/getStudentListByType')?>";
		$.ajax({
			url:url,
			type:"POST",
			data:{idlist:id,type:2,page:page},
			dataType:"text",
			success:function(data){
				$(".xzxstckright .xzxslist").remove();
				$(".xzxstckright .clear").remove();
				$(".xzxstckright p").remove();
				$(".xzxstckright").append(data);
			}
		});
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
        	window.frames["mainFrame"].$('.huisre').html(data);
        	if(fold == '' && classes == ''){
        		return false;
        	}
        	if(fold == ''){
        		window.frames["mainFrame"].$('.chenfse').removeClass('chenfse');
        		window.frames["mainFrame"].$('#banji').addClass('chenfse');
        	}if(classes == ''){
        		window.frames["mainFrame"].$('.chenfse').removeClass('chenfse');
        		window.frames["mainFrame"].$('#kecheng').addClass('chenfse');
        	}
        }
    });
    page = 1;

}


function check(id){
    if($('#c'+id).prop('checked')==true){
//        $('#'+id).addClass('onhover');
        $("#c"+id).parent().next().next().replaceWith('<a href="javascript:;" id="i'+id+'" class="fr xuanzq1s"></a>');
        $("#c"+id).prop("checked",false);
    }else{
        $("#c"+id).prop("checked",true);
        $("#c"+id).parent().next().next().replaceWith('<a href="javascript:;" id="i'+id+'" class="fr xuanzq1s onhover"></a>');

    }

}

//加载学生
var page = 1;
var preData;
var courseid = 0;
var more = null;
var tmpId = 0;
var tmpType = 1;
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
			if(tmpType != 1 || tmpId !== id) {
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
				return;
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

function showbubble(left,top,html,width,height,nobg){
	var ileft = $('#mainFrame').offset().left;
	var itop = $('#mainFrame').offset().top;
	$("#bubbletip p").html(html);
	
	if(width == 0)
		width = 160;
	if(height == 0)
		height = 63;
	
	var topoffset = 40;
	var leftoffset = width/2+1;
	if(nobg){
		$('#bubbletip').css('background','none');
		$('#bubblesharp').hide();
		topoffset = 20;
		leftoffset = 0;
	}else{
		$('#bubbletip').css('background','#ffaf28');
		$('#bubblesharp').show();
	}
	$('#bubbletip').css('left',(left+ileft-leftoffset)+'px')
					.css('top',(top+itop-height-topoffset)+'px')
					.css('width',width+'px')
					.css('height',height+'px')
					.show();
	
	$('#bubblesharp').css('left',(width/2)+'px');
}
function hidebubble(){
	$("#bubbletip").hide();
}
</script>
<div class="wrap">
<div class="cmain clearfix">
<?php $this->display('aroomv2/room_left')?>
	<div class="cright">
			<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="<?=$mainurl?>"></iframe>
			<a name="areabottom" style="display:block;width:0;height:0;line-height:0"></a>
	</div>
    <!--意见反馈start-->
	<?php
	$qcode_lib = Ebh::app()->lib('Qcode');
	$qcode = $qcode_lib->get_qcode();
	?>
    <div style="width:100%;position:fixed;top:55%;display: none" id="ujdkgj" >
        <ul class="toolbarx">
            <li class="tool tFeedback"><a style="display:none" onclick="feedback()">意见反馈</a></li>
			<li class="tool tWechat"><a style="display:none">微信学习</a><div class="tQRCode"><img src="<?=htmlspecialchars($qcode, ENT_COMPAT)?>" width="141" height="141" /></div></li>
        </ul>
    </div>
    <!--意见反馈end-->
	</div>

<div id="editordiv" style="display:none">
	<table class="room_info_tab" width="100%">
		<tr>
			<td>
				<input type="text" id="title" style="width:947px; border:none; border-bottom:1px solid #cacaca;height:32px; line-height:32px; margin: 10px 5px
						10px; padding:0 5px;font-size:14px" maxlength="30"/>
			</td>
		</tr>
		<tr>
			<td>

	<?php
		$editor->xEditor('courseeditor','960px','500px');
	?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<input class="crupBtn lightbtn" style="cursor:pointer;margin-top:10px;" onclick="closeedit()" value="取消" type="button" />
				<input class="crupBtn lightbtn" style="cursor:pointer;margin-top:10px;" value="确定" type="button" onclick="edite()"/>
			</td>
		</tr>
	</table>
</div>

<div id="dialogdiv" style="display:none">
<iframe width="100%" height="100%" frameborder="0" src="about:blank" id="dislog" name="dialog"></iframe>
</div>
<div id="courseintroduceedit" style="display:none">
</div>
<div class="clear"></div>
</div>
<div id="logdialog" style="display:none;">
	<iframe id="logframe" width=800px height=600px src="" frameborder="0"></iframe>
</div>
<div class="bubbletip" id="bubbletip">
	<p style="margin: 0;"></p>
	<div class="bubblesharp" id="bubblesharp"></div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/loginlog.js<?=getv()?>" crid="<?=$room['crid']?>" id="loginlogjs"></script>
<?php $this->display('troom/room_footer')?>