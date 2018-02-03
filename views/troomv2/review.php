<?php $this->display('troomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery-browser.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.qqFace.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
<style>

.datatab td {
	border-top:none;
}
.coursewareview ul li{white-space: normal!important; }
.qqFace{margin-top:4px;background:#fff;padding:2px;border:1px #dfe6f6 solid;}
.qqFace table td{padding:0px;}
.qqFace table td img{cursor:pointer;border:1px #fff solid;}
.qqFace table td img:hover{border:1px #0066cc solid;}
</style>

<!--发送私信dialog start-->
<div class="waiyry clearfix" id="wxDialog" style="display:none;width:698px;margin:0;padding:30px 44px;">
<div class="chouad" style="height:auto">
<span class="shyten">收件人：</span>
<div class="ewater" style="height:36px;width: 100%">
<ul id="wrap2"></ul>
</div>
</div>
<textarea class="txttiantl" name="summary" style="font-size:14px;"></textarea>
<div class="wtkkr" style="height:45px;">
内容不超过500字
<a id="sendmessage" class="msgsendbtn">发 送</a>
</div>

</div>
<!--发送私信dialog end-->

<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">查看评论</span></a></li>
			</ul>
		</div>
		<?php $this->assign('currentindex',1);
		$this->display('troomv2/courselinkbar');?>
	</div>



	<div id="reviewdiv">
		<!--评论-->
		<!--新评论开始-->
		<div class="coursewareview">

			<div class="allcomments">

			</div>
		</div>
		<?= $pagestr ?>
		<!--新评论结束-->

	</div>
</div>

<!--新评论JS-->
<script type="text/javascript">
	//重设iframe高度
	function setIframeHeight(){
		$(window.parent.parent.document.getElementById('mainFrame')).css('height',$('.lefrig').height()+'px');
	}
	function getformatdate(timestamp)
	{
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	function frontzero(str)
	{
		str = str.toString();
		str.length==1?str="0"+str:str;
		return str;
	}
	$('#mark_score').val(0);
	//用于记录回复记录
	var reply_log = {};

	//字符统计
	$('#comment-input').bind('keyup', function() {
		if(100-$('#comment-input').val().length <= 0){
			$('#comment-input').val($('#comment-input').val().substring(0,100));
		}
		$('.inputprompt-bottom span').html(100-$('#comment-input').val().length);
	})
	//删除评论
	function del_comment(log_id,obj){
		var d = dialog({
			title: '删除评论',
			content: '您确定要删除该评论吗？删除后不可查看该评论!',
			okValue: '确定',
			ok: function () {
				var url = "<?= geturl('troomv2/review/del')?>";
				$.ajax({
					url:url,
					type:'post',
					data:{'logid':log_id},
					dataType:'json',
					success:function(result){
						if(result.status == '1'){
							var url = "/troomv2/review/getajaxpage.html";

							var $curr_page_a = $('#reviewdiv .pages .listPage a.none');

							if($curr_page_a.html() == undefined){
								page_load(1,url);
							}else{
								if($curr_page_a.length == 1){
									page = $curr_page_a.html()?$curr_page_a.html():1;
								}else{
									page = 1;
								}
								var count = $("#reviewcount").html();
								if((count-1) <= 10){
									page = 1
								}
								page_load(page,url);
							}
							
						}else{
							alert(result.msg);
						}
					}
				});
				
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}
	function get_now_tiem(){
		var unixTimestamp = new Date().getTime();

		return get_time(unixTimestamp/1000);
	}
	function replace_em(str){ 
		var emo = (str.match(/\[emo(\S{1,2})\]/g));
		var emo2 = str.match(/\[em_(\S{1,2})\]/g);
		if(emo != null){
			$.each(emo, function(i,item){     
				var temp = emo[i].replace('[emo','');
				temp = temp.replace(']','');

				str2 = '<img src="http://static.ebanhui.com/ebh/tpl/default/images/'+temp+'.gif" onload="setIframeHeight()">';
				str = str.replace(emo[i],str2);
			}); 
		}

		if(emo2 != null){
			$.each(emo2, function(i,item){     
				var temp = emo2[i].replace('[em_','');
				temp = temp.replace(']','');

				str2 = '<img src="http://static.ebanhui.com/ebh/js/qqFace/arclist/'+temp+'.gif" onload="setIframeHeight()" >';
				str = str.replace(emo2[i],str2);
			}); 
		}
		return str;
	}


	 //满意度单选点击事件
	
    $('.cstar').click(function(){
    	
    	$('#mark_score').val($(this).attr('score'));
    })
	function chose_star(obj,oEvent){
		var imgSrc = 'http://static.ebanhui.com/ebh/tpl/2016/images/stars.png';
    	var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/2016/images/stars1.png';
    	if(obj.rateFlag) return;
    	var e = oEvent || window.event;
	    var target = e.target || e.srcElement;
	    var imgArray = obj.getElementsByTagName("img");
	    for(var i=0;i<imgArray.length;i++){
	       imgArray[i]._num = i;
	       imgArray[i].onclick=function(){
	        if(obj.rateFlag) return;
	        var inputid=this.parentNode.previousSibling
	        inputid.value=this._num+1;
	       }
	    }
	    if(target.tagName=="IMG"){
	       for(var j=0;j<imgArray.length;j++){
	        if(j<=target._num){
	         imgArray[j].src=imgSrc_2;
	        } else {
	         imgArray[j].src=imgSrc;
	        }
	        target.parentNode.onmouseout=function(){
	        var imgnum=parseInt(target.parentNode.previousSibling.value);
	            for(n=0;n<imgArray.length;n++){
	                imgArray[n].src=imgSrc;
	            }
	            for(n=0;n<imgnum;n++){
	                imgArray[n].src=imgSrc_2;
	            }
	        }
	       }
	    } else {
	         return false;
	    }
	}


	$('.face').click(function(){
		if($('#comment-input').val() == '请输入你的评论。。。。'){
			$(this).css('color','#000');
			$('#comment-input').val('');
		}
				
	});

	$('#comment-input').focus(function(){
		if($(this).val() == '请输入你的评论。。。。'){
			$(this).css('color','#000');
			$(this).val('');
		}
	});
	$('#comment-input').blur(function(){
		if($(this).val() == ''){
			$(this).css('color','#999');
			$(this).val('请输入你的评论。。。。');
		}
	});
	
	//格式化时间
	function get_time(timestamp){
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	//显示所有三级评价
	function show_all(obj){
		$(obj).parent().siblings('ul').find('.replycommentli1').show();
		$(obj).parent().hide();
	}
	//获取头像
	function get_avatar(obj){
		var defaulturl = '';
		var face = '';
		if (obj.sex == 1){
			if(obj.groupid == 5){
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
			}else{
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			}
		}else{
			if(obj.groupid == 5){
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
			}else{
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			}
		}

		face = obj.face=='' ? defaulturl : obj.face;
		
		var path = face.substring(0,face.lastIndexOf('.'));
		var ext = face.substring(face.lastIndexOf('.'));
		return path+'_50_50'+ext;

	}
	//打开二级回复
	function open_reply_dialog(obj){
		//$('.commentlistsonbottom').show();
		$(obj).parent().parent().siblings('.commentlistsonbottom').show();
		$(obj).parent().hide();
		$(obj).parent().siblings('.close-reply-btn').show();
		//修复IE下重绘延迟
		$('.ul1').css('visibility','visible');
		setIframeHeight();
	}
	//关闭二级回复
	function close_reply_dialog(obj){
		$(obj).parent().parent().siblings('.commentlistsonbottom').hide();
		$(obj).parent().hide();
		$(obj).parent().siblings('.open-reply-btn').show();
		//修复IE下重绘延迟
		$('.ul1').css('visibility','inherit');
		setIframeHeight();
	}
	//弹出发送私信
	$('.hrelh1s').click(function(e){
		window.H.get('wxDialog').exec('show');
		$("#wrap2").html("");
        $("textarea.txttiantl").val("");
        //添加收件人
        var tid = $(this).attr("tid");
        var tname = $(this).attr("tname");
        $("#wrap2").append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');
        //焦点对话框
        $("textarea.txttiantl").focus();
	});
	
	
	
	function make_reply_dialog(upid,toid,obj){
		if($(obj).parent().parent().find('.commentreply').html() == undefined){
			$('.commentreply').remove();
			var html = '';
			html+='<div class="commentreply">';
	        html+='<div class="restore_arrow1 restore_arrow1tea"></div>';
	        html+='<textarea id="inputrating" class="inputrating inputrating-reply" tips="'+$(obj).attr('tips')+'">'+$(obj).attr('tips')+'</textarea>'
	        html+='<a href="javascript:;" class="face rate-face"></a>';
			html+='<a href="javascript:;" onclick="reply_review('+upid+','+toid+',this);" class="reviews publish" type="'+$(obj).attr('type')+'">发&nbsp;布</a>';
	        html+='</div>';
	        html+='<div class="clear"></div>';

	        $(obj).parents('.commentsright-bottom').after(html);
	        $('.inputrating-reply').focus(function(){
				if($(this).val() == $(this).attr('tips')){
					$(this).css('color','#000');
					$(this).val('');
				}
			});
			$('.inputrating-reply').blur(function(){
				if($(this).val() == ''){
					$(this).css('color','#999');
					$(this).val($(this).attr('tips'));
				}
			});

			$('.rate-face').qqFace({
				id : 'facebox', 
				assign:'inputrating', 
				top:'-100px',
				path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
			});

			$('.rate-face').click(function(){
				if($('.inputrating-reply').val() == $('.inputrating-reply').attr('tips')){
					$('.inputrating-reply').val('');
				}
				
			})
			//修复IE下重绘延迟
			$('.commentsright').css('visibility','visible');
		}else{
			$('.commentreply').remove();
			//修复IE下重绘延迟
			$('.commentsright').css('visibility','inherit');
		}
		setIframeHeight();

	}

	
	//回复评论
	function reply_review(upid,toid,objx){
		var msg = $(objx).siblings('.inputrating').val()
		if(msg == '' || msg == $(objx).siblings('.inputrating').attr('tips')){
			var d = dialog({
			    title: '提示',
			    content: '回复内容不能为空。',
			    cancel: false,
				okValue: '确定',
			    ok: function () {}
			});
			d.showModal();
			$(objx).siblings('.inputrating').focus();
			return false;
		}else if(msg.replace(/<[^>]*>/g,'').length>100){
			var d = dialog({
				title: '提示',
				content: '回复内容不能大于100字',
				cancel: false,
				okValue: '确定',
				ok: function () {}
			});
			d.showModal();
			$(objx).siblings('.inputrating').focus();
			return false;
		}
		

		var url = "<?= geturl('troomv2/review/reply')?>";

		var type = $(objx).attr('type');
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'upid':upid,'toid':toid,'type':type},
			dataType:'json',
			success:function(result){
				if(result.status == 1){
					var avatar_src = '<?=getavater($user,'50_50')?>';
					if(type == 'courseware_reply'){
						if($(objx).parent().siblings('.commentlist').html() == undefined){
							reply_log[upid] = {
								<?=$user['uid']?>:{
									avatar : avatar_src
								},
								count:1
							}
							var html = '';
							html+= '<div class="commentlist">';
							html+='<div class="restore_arrow2"></div>';
							html+='<div class="commentlistson">';
							html+='<div class="commentlistsontop">';
							html+='<div class="peoplereplied"><span class="reply_count">1</span>个人回复：</div>';
							html+='<ul>';
							html+='<li><img src="'+avatar_src+'" class="circular"></li>';
							html+='</ul>';
							html+='<div style="display:none;"  class="open-reply-btn"><a href="javascript:;" onclick="open_reply_dialog(this)" class="studentname open">展开&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/zhankai.png" class="openico"></a></div>';
							html+='<div class="close-reply-btn"><a href="javascript:;" onclick="close_reply_dialog(this)" class="studentname open">收起&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/shouqi.png" class="openico"></a></div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='<div class="commentlistsonbottom"">';
							html+='<ul>';
							html+='<li>';
							html+='<div class="replycomment">';
							html+='<ul>';
							html+='<li class="replycommentli last" id="comment_'+result.logid+'">';
							html+='<div class="replycommentliright">';
							html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);" >删除</a>';
							html+='</div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='</li></ul></div></li></ul></div></div></div>';
							$(objx).parent().next().after(html);
						}else{
							if(reply_log[upid][<?=$user['uid']?>] == undefined){
								reply_log[upid][<?=$user['uid']?>] = {
									avatar : avatar_src
								}
								reply_log[upid].count++;

								if(reply_log[upid].count <= 9){
									$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsontop').children('ul').append('<li><img src="'+avatar_src+'" class="circular" /></li>')
								}


							}
							var html='';
							html+='<li class="replycommentli last" id="comment_'+result.logid+'">';
							html+='<div class="replycommentliright">';
							html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>';
							html+='</div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='</li>';
							$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsonbottom').find('.replycomment').children('ul').append(html);
							
							$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsontop').children('.peoplereplied').children('.reply_count').html(reply_log[upid].count);
							
							$('#comment_'+result.logid).prev().removeClass('last');
						}
					}else{
						var toname = $(objx).parent().siblings('.studentname').html();
						if($(objx).parents('.replycommentli').find('.replycommentson').html() == undefined){
							var html = '';
							html = '<div class="replycommentson">'
							+'<ul>'
							+'<li class="replycommentli1 first" id="comment_'+result.logid+'">'
							+'<div class="replycommentliright">'
							+'<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							+'<span class="comment">回复</span>'
							+'<a href="http://sns.ebh.net/'+toid+'/main.html" target="_blank" class="studentname">'+toname+'</a>'
							+' <span class="totalscore">'+get_now_tiem()+'</span>'
							+'<div class="commentsright-center">'
							+replace_em(msg)
							+'</div>'
							+'<div class="commentsright-bottom">'
							+'<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>'
							+'</div></div></li></ul></div>'
							$(objx).parents('.replycommentli').append(html);
						}else{
							var html = '';
							html = '<li class="replycommentli1 first" id="comment_'+result.logid+'">'
							+'<div class="replycommentliright">'
							+'<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							+'<span class="comment">回复</span>'
							+'<a href="http://sns.ebh.net/'+toid+'/main.html" target="_blank" class="studentname">'+toname+'</a>'
							+' <span class="totalscore">'+get_now_tiem()+'</span>'
							+'<div class="commentsright-center">'
							+replace_em(msg)
							+'</div>'
							+'<div class="commentsright-bottom">'
							+'<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>'
							+'</div></div></li>'
							$(objx).parents('.replycommentli').find('.replycommentson>ul').append(html);
						}
					}
					$('.commentsright').css('visibility','inherit');
					//回复完成后移除回复窗口
					$('.commentreply').remove();
					setIframeHeight();
				}else if(result.status == -1){
				var str = '';
                    $.each(result.Sensitive,function(name,value){
                    	str+=value+'&nbsp;';
                    });
                    var d = dialog({
						title: '提示',
						content: '评论包含敏感词汇'+str+'！请修改后重试...',
						cancel: false,
						okValue: '确定',
						ok: function () {        
						}
					});
					d.showModal();
				}
				else
				{
					alert(result.msg);
				}
			}
		});

	}

	//课件评论异步加载
	function page_load(pagetxt,url){
		var cwid = $("#cwid").val();//课件id
        var pagetext = pagetxt;//分页按钮txt文本
        var page = 1;
        var groupid = $("#groupid").val();//用于判断是老师还是学生
        var curdomain = $("#domain").val();
        //检查文本格式 *数字 * 上一页 * 下一页 * 跳转
        if(!isNaN(pagetext)){
                page = pagetext;
       	}else if(pagetext=='下一页&gt;&gt;'){
            lastp = parseInt($(".none").html()); 
            page = lastp+1;
        }else if(pagetext=='&lt;&lt;上一页'){
            lastp = parseInt($(".none").html());
            var np = lastp-1;
            page = ((np)<=0)?1:np;
        }else if(pagetext=='跳转'){
            page = $("#gopage").attr("value");
        }

        /**ajax后台读取json数据*/
        $.post(url,{'cwid':cwid,'page':page},function(data){
        	var demohtml = '';
        	var json = data.reviews;
        	var domaina = window.location.href;
            var domain = domaina.replace("http://", "");
            var maina = domain.split('/');
            maina.splice(0, 1);
            maina.splice(maina.length - 1, 1);
            var last = maina.join("/");
            
            if(json!=''){
            	demohtml += '<div class="allcomments">'
            		+'<div class="allcommentslist">'
            		+'<ul class="ul1">';
            	//$('.allcomments').html('');
            	for (var i=0;i<json.length;i++){
 					if(i==(json.length-1)){
 						demohtml+='<li id="comment_'+json[i].logid+'" class="last">';
 					}else{
 						demohtml+='<li id="comment_'+json[i].logid+'">';
 					}
            		demohtml+='<div class="avatar-1"><img src="'+get_avatar(json[i])+'" class="circular" /></div>'
            		+'<div class="commentsright">'
            		+'<div class="commentsright-top">'
            		+'<a href="http://sns.ebh.net/'+json[i].uid+'/main.html" target="_blank" class="studentname">'+json[i].username+'（'+json[i].realname+'）</a>';

            		if(json[i].uid != <?=$user['uid']?>){
            			demohtml+='<a class="hrelh1s" href="javascript:;" title="给他发私信" tid="'+json[i].uid+'" tname="'+json[i].username+'"></a>';
            		}
            		demohtml+=getstar_new(json[i].score);
            		demohtml+='<span class="totalscore time">'+get_time(json[i].dateline)+'</span>'
            		+'</div>'
            		+'<div class="commentsright-center">'
            		+replace_em(json[i].subject)
            		+'</div>'
            		+'<div class="commentsright-bottom">';
            		if(json[i].uid != <?=$user['uid']?>){
            			demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].logid+','+json[i].uid+',this)" tips="回复给'+json[i].realname+'：" type="courseware_reply">回复</a>'
            		}
            		if(json[i].uid == <?=$user['uid']?>){
            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].logid+',this);">删除</a>';

            		}else{
            			demohtml+='<a href="javascript:shield('+json[i].toid+','+json[i].logid+');" class="shield">屏蔽</a>';
            		}
            		demohtml+='</div>';
            		//评论回复开始
            		if(json[i].children.length > 0){
            			demohtml+='<div class="commentlist">'
            			+'<div class="restore_arrow2"></div>'
            			+'<div class="commentlistson">'
            			+'<div class="commentlistsontop">';
            			var reply_arr = {count:0};
            			for (var second=0;second<json[i].children.length;second++){
            				if(typeof(reply_arr[json[i].children[second].uid]) == 'undefined'){
            					reply_arr[json[i].children[second].uid] = {
	            					avatar:get_avatar(json[i].children[second])
	            				}
	            				reply_arr.count++
            				}
            			}
            			reply_log[json[i].logid] = reply_arr;
            			demohtml+='<div class="peoplereplied"><span class="reply_count">'+reply_arr.count+'</span>个人回复：</div>'
            			+'<ul>';
            			var round = 0;
            			$.each(reply_arr,function(i,n){
            				if(i != 'count'){
            					
            					demohtml+='<li><img src="'+n.avatar+'" class="circular" /></li>'

            					if(round == 9){
            						demohtml+=' <li><img src="http://static.ebanhui.com/ebh/tpl/2016/images/more.png" class="circular" /></li>';
            						return false;
            					}
            					round++;
            				}
            			});
            			demohtml+='</ul>'
            			+'<div  class="open-reply-btn"><a href="javascript:;" onclick="open_reply_dialog(this)" class="studentname open">展开&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/zhankai.png" class="openico" /></a></div>'
            			+' <div style="display:none;" class="close-reply-btn"><a href="javascript:;" onclick="close_reply_dialog(this)" class="studentname open">收起&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/shouqi.png" class="openico" /></a></div>'
            			+'</div>'
            			+'<div class="clear"></div>'
            			+'<div class="commentlistsonbottom" style="display:none;" >'
            			+'<ul><li><div class="replycomment"><ul>';
            			//二级评论开始
            			for (var second=0;second<json[i].children.length;second++){
            				if(second == (json[i].children.length-1)){
            					demohtml+='<li class="replycommentli last" id="comment_'+json[i].children[second].logid+'">';
            				}else{
            					demohtml+='<li class="replycommentli" id="comment_'+json[i].children[second].logid+'">';
            				}
            				demohtml+='<div class="replycommentliright">'
            				+'<a href="http://sns.ebh.net/'+json[i].children[second].uid+'/main.html" target="_blank"  class="studentname">'+json[i].children[second].username+'（'+json[i].children[second].realname+'）</a>'
            				+'<span class="totalscore">'+get_time(json[i].children[second].dateline)+'</span>'
            				+'<div class="commentsright-center">'
            				+replace_em(json[i].children[second].subject)
            				+'</div>'
            				+'<div class="commentsright-bottom">';
            				if(<?=$user['uid']?> == json[i].children[second].toid){
            					demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].children[second].logid+','+json[i].children[second].uid+',this)" tips="回复给'+json[i].children[second].realname+'：" type="courseware_reply_son">回复</a>'
		            		}
		            		if(json[i].children[second].uid == <?=$user['uid']?>){
		            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].children[second].logid+',this);">删除</a>';

		            		}
		            		demohtml+='</div></div><div class="clear"></div>';
		            		//三级评论开始
		            		if(json[i].children[second].children.length > 0){
		            			demohtml+='<div class="replycommentson">'
		            			+'<ul>';
		            			for (var third=0;third<json[i].children[second].children.length;third++){
		            				
		            				if(third > 2){
		            					demohtml+='<li class="replycommentli1 first" style="display:none;" id="comment_'+json[i].children[second].children[third].logid+'">';
		            				}else{
		            					demohtml+='<li class="replycommentli1 first" id="comment_'+json[i].children[second].children[third].logid+'">';
		            				}
		            				demohtml+='<div class="replycommentliright">'
		            				+'<a href="http://sns.ebh.net/'+json[i].children[second].children[third].uid+'/main.html" target="_blank" class="studentname">'+json[i].children[second].children[third].username+'（'+json[i].children[second].children[third].realname+'）</a>'
		            				+'<span class="comment">回复</span>'
		            				+'<a href="http://sns.ebh.net/'+json[i].children[second].children[third].toid+'/main.html" target="_blank" class="studentname">'+json[i].children[second].children[third].tousername+'（'+json[i].children[second].children[third].torealname+'）</a>'
		            				+'<span class="totalscore">'+get_time(json[i].children[second].children[third].dateline)+'</span>'
		            				+'<div class="commentsright-center">'
		            				+replace_em(json[i].children[second].children[third].subject)
		            				+'</div>'
		            				+'<div class="commentsright-bottom">';
		            				if(<?=$user['uid']?> == json[i].children[second].children[third].toid){
		            					demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].children[second].logid+','+json[i].children[second].children[third].uid+',this)" tips="回复给'+json[i].children[second].children[third].realname+'：" type="courseware_reply_son">回复</a>'
				            		}
				            		if(json[i].children[second].children[third].uid == <?=$user['uid']?>){
				            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].children[second].children[third].logid+',this);">删除</a>';

				            		}
				            		demohtml+='</div>'
				            		+'</div>'
				            		+'</li>';

		            			}
		            			demohtml+='</ul>';
		            			if(json[i].children[second].children.length > 3){
		            				demohtml+='<div class="viewall"><a href="javascript:;"  onclick="show_all(this)">点击查看全部</a></div>';
		            			}
		            			

		            			demohtml+='</div>';
		            		}
		            		//三级评论结束
		            		demohtml+='</li>';


            			}
            			//二级评论结束
		            	demohtml+='</ul></div></li> </ul> </div></div> </div>'
            		}
            		//评论回复结束
            		demohtml+='</div></li>';



            	}
            	demohtml+='</ul></div></div>';
            	
            }
            $('.allcomments').html(demohtml);
            //重置iframe高度
           
            $('.allcomments').css('visibility','visible');
            	$('#reviewcount').html(data.count);
            	//弹出发送私信
				$('.hrelh1s').click(function(e){
					window.H.get('wxDialog').exec('show');
					$("#wrap2").html("");
			        $("textarea.txttiantl").val("");
			        //添加收件人
			        var tid = $(this).attr("tid");
			        var tname = $(this).attr("tname");
			        $("#wrap2").append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');
			        //焦点对话框
			        $("textarea.txttiantl").focus();
				});
            //分页处理
            $(".pages").html(data.pagestr);
            $(".pages a").unbind();

            $(".pages a").each(function(){
                $(this).removeAttr("href");
                $(this).css("cursor",'pointer');
                $(this).bind("click",function(){var pagetxt = $(this).html();page_load(pagetxt,url)});
                    //显示当前页
                var ptxt =$(this).html(); 
                if(!isNaN(ptxt) && ptxt == page){
                    $(this).addClass("none");
                }else{
                    $(this).removeClass("none");
                }
            })
            setIframeHeight();

        },'json')
	}

	//取星星
    function getstar_new(num)
    {   
    	<?php 
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(!empty($roominfo['crid'])){
            $other_config = Ebh::app()->getConfig()->load('othersetting');
            $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
            $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
            $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
            $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
        }
    	if($is_zjdlr) {?>
    		return '';
    	<?php } ?>
        var starword='';
        num=parseInt(num);
        if(num>5)
        {
            num=5;
        }
        for(i =0;i<num;i++)
        {
            starword+='<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars1.png">';
        }
        if(5-num>0)
        {
            for(j =0;j<5-num;j++)
            {
                starword+='<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png">';
            }
        }
        return starword;
    }



    //屏蔽
	function shield(cwid,logid){
			var url = "<?= geturl('troomv2/review/shield')?>";
            var obj = $("#comment_"+logid);
            var count = $("#reviewcount").html();
			var d = dialog({
			title: '屏蔽评论',
			content: '您确定要屏蔽该评论吗？屏蔽后不可查看该评论!',
			okValue: '确定',
			ok: function () {
			$.ajax({
				type:'post',
				url:url,
				dataType:'json',
				data:{'cwid':cwid,'logid':logid},
				success:function(data){
					if(data != undefined && data.status != undefined && data.status == 1) {
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>屏蔽评论信息成功！</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									that.close().remove();
								}, 1000);
							}
						}).show();
						if(obj.hasClass('last')){
                        	obj.prev().addClass('last');
                        }
                        obj.remove();

                        $("#reviewcount").html(count-1);
                        if(count == 1){
                           // alert(11);
                            var html = '<dl>';
                            html+= '<div id="nocommentdiv" style="width:100%;height:50px;">暂无任何评论</div>'
                            html+= '</dl>';
                            $(".appraise").append(html);
                        }
					} else {
						var msg = '屏蔽评论失败，请稍后再试或联系管理员。';
						if(data != undefined && data.msg != undefined)
							msg = data.msg;
						dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>"+msg+"</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									that.close().remove();
								}, 1000);
							}
						}).show();
					}
				}
			});	
			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}

	$("#sendmessage").click(function(){
		var msg =  $.trim($("textarea.txttiantl").val());
		var tid = '';
		var tid1= '';
		$('#wrap2 li').each(function(index) {
		    tid1 = $(this).attr("tid");
		    tid = tid+','+tid1;
		  });
		if($("#wrap2").html() == ''){
			// alert("收件人错误");
			dialog({
				title:"提示",
				content:"收件人错误",
				okValue:"确定",
				ok:function () {
					this.close().remove();
				}
			}).show();
			return;
		}
		if(msg.length==0){
			// alert('请输入内容');
			dialog({
				title:"提示",
				content:"请输入内容",
				okValue:"确定",
				ok:function () {
					this.close().remove();
				}
			}).show();
			return;
		} else if(msg.length>500){
			// alert('内容不超过500字');
			dialog({
				title:"提示",
				content:"内容不超过500字",
				okValue:"确定",
				ok:function () {
					this.close().remove();
				}
			}).show();
			return;
		}
		$.ajax({
			type: "POST",
		    url: "/troomv2/review/sendmsgAjax.html",
		    data:{tid:tid, msg:msg},
		    success:function(res){
		        if(res=="1"){
					dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>发送成功</p>",
			    		onshow:function () {
			    			var that=this;
			    			setTimeout(function () {
							window.H.get('wxDialog').exec('close');
			    				that.close().remove();
			    			},1000);
			    		}
					}).show();
				}else{
			    	dialog({
			    		title:"提示信息",
			    		content:"发送失败",
			    		okValue:"关闭",
			    		ok:function () {
			    			this.close().remove();
			    		}
			    	}).show();
				}
		 	}
		});
	});


    window.H.remove('wxDialog');
    //$('#wxDialog').remove();
    window.H.create(new P({
        id:'wxDialog',
        title:'发私信',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');

</script>

<script>
$(function(){
	//分页开始加载
	var page = 1;
	var url = "/troomv2/review/getajaxpage.html";
	page_load(page,url);
})
</script>
<!--新评论JS结束-->

<?php $this->display('troomv2/page_footer'); ?>
