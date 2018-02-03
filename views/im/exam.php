<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=1000, user-scalable=no" name="viewport"/>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title>推送作业</title>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico');
</script>
<![endif]-->

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?version=20160224001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160224001" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=getv()?>"/>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20160606001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js?version=20150825001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

</head>
<body>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<?php $v=getv();?>
<style type="text/css">
body{
	background: #fff!important;
}
#icategory{
	background:#fff;
	padding:6px 10px;
}
.category_cont1 div{
	height:40px;
	line-height:40px;
	
}
.fbsjkc .kkjssj{
	width:auto;
	float:left;
}
.fbsjkc .cyrss{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png) no-repeat left center;
	padding-left: 15px;
}
.fbsjkc .cyrus{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renyuan.png) no-repeat left center;
	padding-left: 15px;
}
.bzzytitle a{
    font-family: 微软雅黑;
    font-weight: bold;
    color: #333;
    font-size: 16px;
}
.diles{
	top:55px;
}
.cuotiji{
	margin-right:11px !important;
}
div::after, ul::after, dl::after{
	display: inline;
}
i.TSicon,i.PTicon,i.homeicon,i.classicon,i.examinicon{
	display: inline-block!important;
	width:20px;
	height: 20px;
	background: #19a6f8;
	color:#fff;
	border-radius: 2px;
	margin: 0 5px;
	font-style:normal;
	text-align: center;
	line-height: 20px;
	font-weight: 400;
	font-size: 11px;
	
}
.category_cont1 div a{
	padding: 3px 10px;
	font-size: 14px;
}
.fbsjkc{
	line-height: 60px;
}
.workdatabzylist1{
	border-bottom: 1px solid #efefef;
	height:auto!important;
	overflow:hidden;
	position:relative;
	padding-bottom:10px;
}
a:hover{text-decoration: none}
.lefrig{
	margin:0!important;
	float:none!important;
}
.push{
	display:block;
	float: left;
	border-radius:5px;
	margin:0 10px 0 4px;
	width:100px;
	height:30px;
	background:#22c485;
	color:#fff;
	text-align:center;
	line-height:30px;
	font-size:14px;	
}
.cancel{
	display:block;
	width:45px;
	height:30px;
	float:left;
	background:#ef8f00;
	color:#fff;
	text-align:center;
	line-height:30px;
	font-size:14px;
	border-radius:5px;
}
.canceled{
	background:#ccc;
}
.push:hover{
	color:#fff;
}
.cancel:hover{
	color:#fff;
}
.nodata{
	position:relative;
	margin-top:50px;
}
.data_tip{
	width:100%;
	text-align: center;
	position:absolute;
	font-size:30px;
	color:red;
	left:0;
	top:100px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"<?=$v?>></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css"<?=$v?> media="screen" />

<div class="lefrig">
	<div class="workol" style="margin:0;">
		<div id="icategory" class="clearfix" style="border-top:none;">
			<dl style="float:left;display:inline; width: 100%;">
			<dd style="width: 100%;">
				<div class="category_cont1">
				                   
				</div>
			</dd>
			</dl>
		</div>
		<div class="workdata" style="float:left;margin-top:0px;">
			<div class="workdatabzylist" id="exams">
					
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="mpage" style="height:60px;clear:both;"></div>
</div>
	<script type="text/javascript">
		var ws = null;
		var exam = [];
		var crid = "<?=$crid?>";
		var pushMark = "";    //标记推送id
		var cancelMark = "";  //标记取消id
		var uid = <?=$user['uid']?>;
		var teacherId = <?=$course['uid']?>;
		if(uid != teacherId){
			var target = "_self";
		}else{
			var target = "_blank";
		}
		var urlSign = "?soft=true"
		function getElist(folderid,estype,url){   //获取作业列表 分页
			if(typeof url == "undefined") {
				url = '/troomv2/examv2/elistAjax.html';
			}
			var title = $("#title").val();			
			if(title == searchtext){
				title = "";
				
			}
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					q : title || '',
					etype:$("#etype").val(),
					estype:estype,
					status:$("#status").val(),
					folderid : folderid || '',
					cwid:<?=$cwid?>,
					action:1,
					recuid:teacherId
				},
				beforeSend:function(XMLHttpRequest){
             	 var loading = '<div style="text-align:center;width:100%;"><img style="width:32px;margin:0 482px;" src="http://static.ebanhui.com/exam/images/loading-2.gif"></div>';
             	 $('#exams').empty().append(loading);
        	 }
			}).done(function(res){
				if(res.errCode == 133){
					//判断是否为全部选项
					if(estype > 0){
						var cmain_bottom = '<div class="cmain_bottom " style="width: 100%;  min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto;border-bottom:none;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
					}else{
						var cmain_bottom = '<div class="cmain_bottom " style="width: 100%;  min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto;border-bottom:none;">' +
							'<div class="nodata"></div>'+
							'<p class="data_tip">直播课没有布置作业，请到管理平台布置</p>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
					}
					
		        	$('#mpage').empty();
		        	$("#exams").empty().append(cmain_bottom);
				}else{
					var $pagedom = $(res.datas.pagestr);
					$pagedom.find('.listPage a').bind('click',function(){
						var url = $(this).attr('data');
						var estype = $('.curr').attr('data');
						if(!!url) {
							getElist(folderid,estype,url);
						}
					});
					$("#mpage").empty().append($pagedom);
					renderExamList(res.datas.examList);
				}
				
			}).fail(function(){
				console.log('req err');
			});
		}
		var onmessage = function(e){
			var data = eval("(" + e.data + ")");
                switch (data['type']) {
                	case 'ping':
						var pong = {};
	                    pong.type = 'pong';
						ws.send(JSON.stringify(pong));
	                    break;
	                case 'init':
	                	exam = data.exam;
	                	getElist();
						$("#etype,#status").on('change',function(){
							getElist();
						});
						break;
					case 'pushexam':
						exam = data.exam;
						var eid = data.eid;
						$('.fr[eid="'+ eid +'"]').find(".push").html("已推送");
						$('.fr[eid="'+ eid +'"]').find(".push").attr("state","false");
						$('.fr[eid="'+ eid +'"]').find(".cancel").css("background","#ef8f00");
						$('.fr[eid="'+ eid +'"]').find(".cancel").attr("state","true");
						if(eid == pushMark){
							var tips = dialog({
								title: '作业推送',
								content: '推送成功！',
								cancel: false
							});
							tips.show();
							setTimeout(function () {
								tips.close().remove();
							}, 2000);
						}
						break;
					case 'unpushexam':
						exam = data.exam;
						var eid = data.eid;
						$('.fr[eid="'+ eid +'"]').find(".cancel").css("background","#ccc");
						$('.fr[eid="'+ eid +'"]').find(".cancel").attr("state","false");
						$('.fr[eid="'+ eid +'"]').find(".push").html("推送作业");
						$('.fr[eid="'+ eid +'"]').find(".push").attr("state","true");
						if(eid == cancelMark){
							var tips = dialog({
								title: '取消推送',
								content: '取消成功！',
								cancel: false
							});
							tips.show();
							setTimeout(function () {
								tips.close().remove();
							}, 2000);
						}
						break;		
                }
		}
		//推送作业
		var pushed = function (_this,id){
			var state = $(_this).attr("state");
			if(state == "true"){
				var d = window.dialog({
					title: '推送确认',
					content: '是否推送作业？',
					okValue: '确定',
					ok: function(){
						var login_data = {
					        type: 'pushexam',
					        eid: id
					    }
					    ws.send(JSON.stringify(login_data));
					    pushMark = id;
					},
					cancelValue: '取消',
					cancel: function () {
						d.close().remove();
					}
				});
				d.showModal();
			}
		}
		//取消推送
		var cancelWork = function(_this,id){
			var state = $(_this).attr("state");
			if(state == "true"){
				var d = window.dialog({
					title: '取消作业推送',
					content: '是否取消作业推送？',
					okValue: '确定',
					ok: function(){
						var login_data = {
					        type: 'unpushexam',
					        eid: id
					    }
					    ws.send(JSON.stringify(login_data));
					    cancelMark = id;
					},
					cancelValue: '取消',
					cancel: function () {
						d.close().remove();
					}
				});
				d.showModal();	
			}
		}
		$(function(){
			<?php 
				$websocket_config = Ebh::app()->getConfig()->load('pushwebsocket');	
			?>
			var WebSocketAddr = '<?=$websocket_config[0]?>';
			ws = new WebSocket(WebSocketAddr);
            ws.onopen = function() {
                var login_data = {
                    type: 'login',
                    auth: '<?=$key?>',
                    room_id: <?=$cwid?>
                }
                ws.send(JSON.stringify(login_data));
            };
            // 当有消息时根据消息类型显示不同信息
            ws.onmessage = onmessage;
		});

		//渲染教师布置的作业
		function renderExamList(examList){
			$("#exams").empty();
			for(var i = 0,len = examList.length; i<len; i++) {
				var data = examList[i];
				if(data.esubject.length>40){
				    var  sesubject = data.esubject.substring(0,40)+"...";
				}else{
					var  sesubject = data.esubject;
				}
				var userAnswer = examList[i].userAnswer;
				var classarr = '';
				var classlist = [];
	    		for(var j=0;j<data.relationSet.length;j++){
	    			if(data.relationSet[j].ttype == 'CLASS'){
	    				classlist.push(data.relationSet[j].tid)
	    				if(j+1 != data.relationSet.length ){
	    					classarr += data.relationSet[j].relationname+','
	    				}else{
	    					classarr += data.relationSet[j].relationname+''
	    				}
	    			}
	    		}
	    		if(uid == data.uid){
	    			if (data.status == 0){
		    			var status = '<a class="bjcgs" target='+ target +' href="/troomv2/examv2/edit/'+data.eid+'.html'+ urlSign +'">编辑草稿</a>';
		    			str = '(草稿)';
		    		} else {
		    			var status = '<a class="bjcgs" target='+ target +' href="/troomv2/examv2/alist/'+data.eid+'.html'+ urlSign +'">批阅</a>';
		    			str = '';
		    		}
	    		}else{
	    			var status = '';
		    		str = '';
	    		}
	    		
	    		var answercount = data.answercount;
	    		if (data.count != undefined) {
	    			var count = data.count;
	    		} else {
	    			var count = 0;
	    		}
		    	/* 构造中间的*/
		    	if (data.datelineStr == null)
		    		data.datelineStr = '刚刚';
		    	var etype = '普通作业';
		    	/*构造tile*/
		    	if(data.etype == 'COMMON'){
		    		if(data.estype == ''){
		    			var icontext = '';
		    		}else{
		    			var icontext ='<i class="classicon">'+data.estype.substr(0,1) +'</i>' ;
		    		};
		    		if(uid == data.uid){
		    			var title = '<div class="bzzytitle"><a href="/troomv2/examv2/edit/'+data.eid+'.html'+ urlSign +'" title="'+data.esubject +'" target='+ target +'>'+sesubject+'<span>'+str+'</span></a><i class="PTicon">普</i>'+icontext+'</div>';
		    		}else{
		    			var title = '<div class="bzzytitle"><a href="javascript:return false;" title="'+data.esubject +'" target='+ target +'>'+sesubject+'<span>'+str+'</span></a><i class="PTicon">普</i>'+icontext+'</div>';
		    		}
		    		
				
				};
				if(exam.indexOf(data.eid) == -1){
					var pushState = "true";
					var cancelState = "false";
					var txt = "推送作业";
					var backStyle = "background:#ccc;";
				}else{
					var pushState = "false";
					var cancelState = "true";
					var txt = "已推送";
					var backStyle = "background:#ef8f00;";
				}
				if(uid == data.uid){
					if(data.status == 0){
						var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'">'+status+'<a href="/troomv2/examv2/edit/'+data.eid+'.html'+ urlSign +'" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target='+ target +'><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png" /></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png" /></a></div>';
					}else{
						var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'">'+status+'<a href="/troomv2/examv2/edit/'+data.eid+'.html'+ urlSign +'" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target='+ target +'><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png" /></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png" /></a><a class="push" state='+ pushState +' onclick="pushed(this,'+ data.eid +')">'+ txt +'</a><a class="cancel" state='+ cancelState +' onclick="cancelWork(this,'+ data.eid +')" style="'+ backStyle +'">取消</a></div>';
					}
				}else{
					if(data.status == 0){
						var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'">'+status+'</div>';
					}else{
						var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'">'+status+'<a class="push" state='+ pushState +' onclick="pushed(this,'+ data.eid +')">'+ txt +'</a><a class="cancel" state='+ cancelState +' onclick="cancelWork(this,'+ data.eid +')" style="'+ backStyle +'">取消</a></div>';
					}
					
				}
		    	
		    	if (data.etype == 'TSMART') {
		    		if (data.status == 0){
		    			var tstatus = '编辑草稿';
		    			str = '(草稿)';
		    		} else {
		    			var tstatus = '批阅';
		    			str = '';
		    		}
		    		var etype = '智能作业';
		    		if(data.estype == ''){
		    			var icontext = '';
		    		}else{
		    			var icontext ='<i class="classicon">'+data.estype.substr(0,1) +'</i>' ;
		    		};
		    		if(exam.indexOf(data.eid) == -1){
						var pushState = "true";
						var cancelState = "false";
						var txt = "推送作业";
						var backStyle = "background:#ccc;";
					}else{
						var pushState = "false";
						var cancelState = "true";
						var txt = "已推送";
						var backStyle = "background:#ef8f00;";
					}
		    		var title = '<div class="bzzytitle"><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html'+ urlSign +'" title="'+data.esubject +'" target='+target+'>'+sesubject+'<span>'+str+'</span></a><i class="TSicon">智</i>'+icontext+'</div>';
		    		if(uid == data.uid){
		    			if(data.status == 0){
		    				var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'"><a class="bjcgs" target='+ target +' href="/troomv2/examv2/smartalist/'+data.eid+'.html'+ urlSign +'">'+tstatus+'</a><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html'+ urlSign +'" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target='+ target +'><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png"></a></div>';
		    			}else{
		    				var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'"><a class="bjcgs" target='+ target +' href="/troomv2/examv2/smartalist/'+data.eid+'.html'+ urlSign +'">'+tstatus+'</a><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html'+ urlSign +'" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target='+ target +'><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png"></a><a class="push" state='+ pushState +' onclick="pushed(this,'+ data.eid +')">'+ txt +'</a><a class="cancel" state='+ cancelState +' onclick="cancelWork(this,'+ data.eid +')" style="'+ backStyle +'">取消</a></div>';
		    			}
		    		}else{
		    			if(data.status == 0){
		    				var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'"></div>';
		    			}else{
		    				var fr = '<div class="fr ml25" style="width:190px;" eid="'+ data.eid +'"><a class="push" state='+ pushState +' onclick="pushed(this,'+ data.eid +')">'+ txt +'</a><a class="cancel" state='+ cancelState +' onclick="cancelWork(this,'+ data.eid +')" style="'+ backStyle +'">取消</a></div>';
		    			}
		    		}
		    		
		    	}
		    	
		    	var  relationname = '' ;
				var folderid = '';
	    		if(data.relationSet.length >=2 && data.relationSet[0].ttype == 'FOLDER'){
					if(data.relationSet[1].ttype == 'COURSE'){
		    			FOLDER = data.relationSet[0].relationname;
		    			COURSE = data.relationSet[1].relationname?data.relationSet[1].relationname:'';
		    			relationname = FOLDER+ '>' + COURSE;
		    			folderid = data.relationSet[0].tid;
		    		}else{
		    			relationname = data.relationSet[0].relationname;
    					folderid = data.relationSet[0].tid;
		    		}
			    }else{
			    	if(data.relationSet[0].ttype == 'FOLDER'){
			    			relationname = data.relationSet[0].relationname;
	    					folderid = data.relationSet[0].tid;
		    		}else{
		    			relationname = '';
	    				folderid = '';
		    		}	
			    };
			    
		    	if(relationname.length>30){
				    var  relationnames = relationname.substring(0,30)+"...";
				}else{
					var  relationnames = relationname;
				};
				var classmiddle = '';
				if(classarr != ''){
					classmiddle = '<span title="'+classarr+'" style="margin-left:10px">关联班级：' + classarr + ' </span>'
				}
		    	var middle = '<div class="fl" style="width:100%;"><div class="fbsjkc fl ml25"><p class="fl" style="width:150px;">'+data.datelineStr+ '发布</p><p class="fl" style="color:#999;">总分:'+data.examscore+'分<span style="padding:0 10px;"></span></p><p class="kkjssj">计时:'+(data.limittime == 0?'不限时':data.limittime +'分钟')+'<span style="padding:0 10px;"></span></p><p class="kkjssj cyrss">参与人数：'+answercount+'/'+(count == 0?answercount:count)+'<span style="padding:0 10px;"></span></p><p class="kkjssj cyrus">'+etype+'</p><br /></div>'+fr+'</div><div class="clear:both;"></div><div class="clear:both;"></div>';
				
				/* 构造下面的*/
				var bottom = '';
				if(uid == data.uid){
					if (data.status == 1) {
			    		var bottom = '<div class="hsidts1s ml25" style="position:absolute;bottom:0;left:16px;"><a href="javascript:void(0)" onclick="getDSword('+data.eid+')"  class="lasrnwe">导出为word</a><a class="lasrnwe" target='+ target +' href="/troomv2/examv2/efenxi/'+ data.eid + '.html'+ urlSign +'">统计分析</a><a href="/troomv2/examv2/errorRanking/'+ data.eid + '.html'+ urlSign +'" target='+ target +' class="lasrnwe">错题排名</a></div>';
			    	}
				}else{
					var bottom = '';
				}
		    	
				var $dom = $('<div class="workdatabzylist1">'+title + middle + bottom + '</div>');
				$("#exams").append($dom);	
			}	
			$('.workdatabzylist1:last').css('border-bottom','none');
		}
			
		
	</script>

<script type="text/javascript">
	var searchtext = "请输入搜索关键词";
	$(function(){
		initsearch("title",searchtext);
		$("#ser").on('click',function(){
		   	getElist();
		});
	});
	function delexam(eid,crid) {
	        var url = '<?= geturl('troomv2/examv2/del') ?>';
			var d = window.dialog({
			title: '删除确认',
			content: '作业删除后，此作业下的学生答题记录也会删除，确定要删除吗？',
			okValue: '确定',
			ok: function () {
	        $.ajax({
	            url:url,
	            type:'post',
	            data:{'eid':eid},
	            dataType:'text',
	            success:function(data){
	                if(data==1){
	                    var d = dialog({
								title: '作业删除',
								content: '作业删除成功！',
								cancel: false
							});
						d.show();
						setTimeout(function () {
							location.reload();
							d.close().remove();
						}, 2000);
	                }else{
	                    var d = dialog({
							title: '作业删除',
							content: '作业删除失败，请稍后再试或联系管理员！',
							cancel: false
						});
						d.show();
						setTimeout(function () {
							d.close().remove();
						}, 2000);
	                }
	            }
	        });
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}
	function getDSword(eid){
		var wordsel = '<p style="text-align:left">生成视频解析二维码</p><ul  style="text-align:left;font-size:13px;"><li style="line-height: 36px;"><input id="FullVolume" name="asdas" type="checkbox"/><label for="FullVolume">整卷二维码（扫码查看本卷所有视频解析）</lable></li><li><input id="SingleItem" type="checkbox"/><label  for="SingleItem">单题二维码（扫码查看试题对应的视频解析）</lable></li></ul>';
		var d = window.dialog({
			title: '导出为word',
			content: wordsel,
			okValue: '导出',
			ok: function () {
				var flag = 0;
				if(parent.$('#FullVolume').prop('checked') == true && parent.$('#SingleItem').prop('checked') == true ){
					flag = 3;
				}else if(parent.$('#FullVolume').prop('checked') == true && parent.$('#SingleItem').prop('checked') == false){
					flag = 1;
				}else if(parent.$('#FullVolume').prop('checked') == false && parent.$('#SingleItem').prop('checked') == true){
					flag = 2;
				};
	            window.open('/troomv2/word/outword/'+eid+'.html?flag='+ flag);
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}
	
	function getEstypeList(){     //作业类型
		var Elist = '';
		$.ajax({
			type:"POST",
			url:'/troomv2/estype/getEstypeList.html',
			data:{},
			dataType:'json',
			success:function(result){
				Elist += '<div><a data="" class="curr allwork" onclick="getElist()">全部</a></div>';
				for(var i=0;i<result.length;i++){
					var estype = result[i].estype;
					Elist+='<div><a data="'+result[i].id+'" onclick="getElist(\'\',$(this).attr(\'data\'))">'+estype+'</a></div>';
				}
				$('.category_cont1').html(Elist);
				$('.category_cont1').find('div a').each(function(){
					$(this).click(function(){
						$('.category_cont1').find('div a').removeClass('curr');
						$(this).addClass('curr');
					})
				})
			}
		});
	}
	
	$(function(){
	  	getEstypeList();
	  	$('.filterF').live('click',function(){
	  		var estype = $('.category_cont1').find('.curr').attr('data') || '';
			getElist($(this).attr('folderid'),estype);
	  	});
	});
</script>
<?php $this->display('troomv2/page_footer'); ?>