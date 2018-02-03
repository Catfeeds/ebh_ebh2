<?php $this->display('troomv2/page_header'); ?>
<?php $v=getv();?>
<style type="text/css">
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
	line-height: 32px;
}
.workdatabzylist1{
	border-bottom: 1px solid #efefef;
}
a:hover{text-decoration: none}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"<?=$v?>></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css"<?=$v?> media="screen" />

<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
			</ul>
			<div style="float:right;display:inline;">
				<a class="mulubgbtns" href="/troomv2/examv2/add.html" target="_blank" style="margin-top:6px;">普通作业</a>
				<a class="mulubgbtns" href="/troomv2/examv2/addsmart.html" target="_blank" style="margin-top:6px;">智能随机作业</a>
				<a class="mulubgbtns" href="/troomv2/examv2/errors.html" style="margin-top:6px;">错题集</a>
			</div>
		</div>
		<div class="diles">
			<?php
				$q= empty($q)?'':$q;
				if(!empty($q)){
					$stylestr = 'style="color:#000"';
				}else{
					$stylestr = "";
				}
			?>
			<input name="title" class="newsou" <?=$stylestr?> id="title" name="uname" value="<?= $q?>"  type="text" />
			<input id="ser" type="button" class="soulico" value="">
		</div>
		
		<div class="clear"></div>
	</div>
	<div class="workol">
		<div id="icategory" class="clearfix" style="border-top:none;">
			<dl style="float:left;display:inline; width: 768px; *width:768px;">
			<dd style="width: 760px;">
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
		
		var crid = "<?=$crid?>";
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
					folderid : folderid || ''
				},
				beforeSend:function(XMLHttpRequest){
             	 var loading = '<div style="text-align:center;width:100%;"><img style="width:32px;margin:0 482px;" src="http://static.ebanhui.com/exam/images/loading-2.gif"></div>';
             	 $('#exams').empty().append(loading);
        	 }
			}).done(function(res){
				if(res.errCode == 133){
					var cmain_bottom = '<div class="cmain_bottom " style="width: 100%;  min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto;border-bottom:none;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
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
					parent.resetmain();
				}
				
			}).fail(function(){
				console.log('req err');
			});
		}

		$(function(){
			getElist();
			$("#etype,#status").on('change',function(){
				getElist();
			})
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
	    		var classids = [];
				if(data.relationSet){
					for(var j=0;j<data.relationSet.length;j++){
						if(data.relationSet[j].classid != 0){
							classids.push(data.relationSet[j].classid)
						}
                    	
                	}
				}
	    		if (data.status == 0){
	    			var status = '<a class="bjcgs" target="_blank" href="/troomv2/examv2/edit/'+data.eid+'.html">编辑草稿</a>';
	    			str = '(草稿)';
	    		} else {
	    			var status = '<a class="bjcgs" target="_blank" href="/troomv2/examv2/alist/'+data.eid+'.html?classids='+JSON.stringify(classids)+'">批阅</a>';
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
		    		var title = '<div class="bzzytitle"><a href="/troomv2/examv2/edit/'+data.eid+'.html" title="'+data.esubject +'" target="_blank">'+sesubject+'<span>'+str+'</span></a><i class="PTicon">普</i>'+icontext+'</div>';
				
				};
		    	var fr = '<div class="fr ml25" style="width:190px;">'+status+'<a href="/troomv2/examv2/edit/'+data.eid+'.html" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png" /></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png" /></a></div>';
		    	
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
		    		var title = '<div class="bzzytitle"><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html" title="'+data.esubject +'" target="_blank">'+sesubject+'<span>'+str+'</span></a><i class="TSicon">智</i>'+icontext+'</div>';
		    		var fr = '<div class="fr ml25" style="width:190px;"><a class="bjcgs" target="_blank" href="/troomv2/examv2/smartalist/'+data.eid+'.html">'+tstatus+'</a><a href="/troomv2/examv2/editsamrt/'+data.eid+'.html" class="lasrnwe mt5 ml20" style="float:left;display:inline;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png"></a><a href="javascript:;" onclick="delexam('+data.eid+','+crid+')" class="lasrnwe mt5 ml20" style="float:left;display:inline;"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png"></a></div>';
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
		    	var middle = '<div class="fl" style="width:100%;"><div class="fbsjkc fl ml25"><p class="fl" style="width:150px;">'+data.datelineStr+ '发布</p><p class="fl" style="color:#999;">总分:'+data.examscore+'分<span style="padding:0 10px;"></span></p><p class="kkjssj">计时:'+(data.limittime == 0?'不限时':data.limittime +'分钟')+'<span style="padding:0 10px;"></span></p><p class="kkjssj cyrss">参与人数：'+answercount+'/'+(count == 0?answercount:count)+'<span style="padding:0 10px;"></span></p><p class="kkjssj cyrus">'+etype+'</p><br /><p style="    width: 720px;display: inline-block; white-space: nowrap; height: 22px;line-height:22px; overflow: hidden;text-overflow: ellipsis;" class="">关联课程：<a class="filterF"  style="color:#5e96f5;" folderid="'+folderid+'" href="javascript:void(0);" title="'+relationname+'">'+ relationnames +'</a><a class="glkc" target="_blank"></a>'+classmiddle+'</p></div>'+fr+'</div><div class="clear:both;"></div><div class="clear:both;"></div>';
				
				/* 构造下面的*/
				var bottom = '';
				
		    	if(answercount <= 0 && data.status == 1){
		    		var bottom = '<div class="hsidts1s ml25" style="float:left;display:inline;width:100%;"><a href="javascript:void(0)" onclick="getDSword('+data.eid+')"  class="lasrnwe">导出为word</a></div>';
		    	}else if (data.status == 1) {
		    	    let errorRanking = '/troomv2/examv2/errorRanking/'+ data.eid + '.html?classids='+JSON.stringify(classids)
		    	    let efenxi = '/troomv2/examv2/efenxi/'+ data.eid + '.html?classids='+JSON.stringify(classids)
		    		var bottom = '<div class="hsidts1s ml25" style="float:left;display:inline;width:100%;"><a href="javascript:void(0)" onclick="getDSword('+data.eid+')"  class="lasrnwe">导出为word</a><a class="lasrnwe" target="_blank" href="'+efenxi+'">统计分析</a><a href="'+errorRanking+'" target="_blank" class="lasrnwe">错题排名</a></div>';
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
		parent.resetmain();
	});
	function delexam(eid,crid) {
	        var url = '<?= geturl('troomv2/examv2/del') ?>';
			var d = top.dialog({
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
		var d = top.dialog({
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