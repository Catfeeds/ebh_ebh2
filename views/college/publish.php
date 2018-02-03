<div class="rshuit">
<div class="mafe1" style="display:none">
<span class="close" id="emotionclosed">×</span>
<div class="b2">
<div>
<table cellspacing="0" class="datamis">
<thead class="tabdmis">

</thead>
</table>
</div>
</div>
</div>
	<div class="fbpls">
		<div class="pingls ping2s queteinfo" style="display:none">
			<p>
                <span class="yinyongs">引用:</span>
 				<span style="font-family: Arial; color:#ffb400;" class="floor"></span>
				<span class="name"></span>
				<span>&nbsp;发布于</span>
				<span style="font-family: Arial;" class="date"></span>
			</p>
			<p class="plnrs review" style="padding-left:55px;"></p>
			<a href="javascript:void(0)" class="delets">&#215;</a>

		</div>
		<textarea class="gieges fbplstext" name="textarea2" id="textarea2" onkeydown="keySend(event);" style="resize: none;overflow-y:auto"></textarea>
	</div>
	<div class="bqtppl">
        	<a href="javascript:;" class="biage">表情</a>
            <a href="javascript:;" id="publishbtn" class="pinglun" title="同时按下Ctrl+Enter键即可发表">发 表</a>
	</div>
  	  <div class="ketggs">
      	<ul id="imgthumlist">
    
	  	</ul>
  	  </div>
</div>

<script language="javascript">
var swf = null;
HTools.rFlash({
	id:'Button1',
	uri:'http://sns.ebh.net/static/flash/MultiImageUploadv2.swf',
	vars:{'xmlurl':'http://sns.ebh.net/static/flash/xml/webData.xml'},
	width:50,
	height:15
});

//创建文本域索引
var dataindex = 0;
$(function () {
	//表情点击
	$('#emotionclosed').on('click',function(){
		$('#textarea2').focus();
		$('.mafe1').hide();
	})
	$('.biage').on('click',function(){
		//异步加载表情
		var htmlstr = '';
		if($('.tabdmis tr').length == 0){
			$.ajax({
				type: "GET",	
				url:'/college/activity/getemotion.html',
				success: function(data){
					for(var i=0;i<data.length;i++){
						if(i == 0){
							htmlstr = '<tr>';
						}
					    htmlstr += "<td><a alt='"+data[i].tit+"' href=\"javascript:;\"><img title='"+data[i].tit+"' src=\"http://static.ebanhui.com/sns/images/qq/"+data[i].url+"\" width=\"24\" height=\"24\"/></a></td>";
					    if((i+1) % 14 == 0 && i>0){
							 htmlstr += '</tr><tr>';
						}	
					}
					$('.tabdmis').html(htmlstr);
					//绑定表情点击
					$('.tabdmis a').on('click',function(){
						$('#textarea2').insertAtCaret('['+$(this).attr('alt')+']');
					})
				},
				dataType:'json'
			})
		}
		$('#textarea2').focus();
		$('.mafe1').toggle();
	})
	
	//点击弹窗以外地方关闭
	$(document).on("click",function(e){
		if($(e.target).hasClass("biage")==false){
			//console.log($('.mafe1').is(":visible"));
	        if(($(e.target).hasClass("mafe1")==false) && $('.mafe1').is(":visible")){
		        if($(e.target).parents(".mafe1").length<=0){
		        	$('.mafe1').hide();
			        }
	        }
		}
    });
    

	//发表
	$('#publishbtn').on('click',function(){
		$('.mafe1').hide();
		var content = $('#textarea2').val().replace(/(^\s*)/g, "");
		
		
		//检测是否可以发布
		if(content == ''){
			$('#textarea2').focus();
			return false;
		}
  		if(content.length > 1000){
			alert('发布的内容长度不能超出1000字,当前字数'+content.length);
			return false;
		}
		
		
		//发布动态显示
		ajaxstart();
		$.ajax({
			type: "POST",	
			url:'/college/activity/review/publish.html',
			data:{content:content,aid:<?=$actdetail['aid']?>,upid:upid},
			success: function(data){
				if(data.success == 1){
					// $.showmessage({
						// img : 'success',
						// message:'发布成功',
						// title:'通知信息',
						// timeoutspeed:500
					// });
					location.href = '/college/activity/intro/<?=$actdetail['aid']?>-'+Math.ceil(data.floor/10)+'-0-0.html';
					$('#textarea2').val('');
					
				}else if(data.success == -1){
					var str = '';
                    $.each(data.Sensitive,function(name,value){
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
				}else{
					alert(data.message);
				}
				ajaxend();
			},			
			dataType:'json'
		})
	});

	$(".gieges").focus(function(){
		$(this).css("border","1px solid #f5b93c");
		});
	$(".gieges").blur(function(){
		$(this).css("border","1px solid #e5e5e5");
		});
});
//处理开始
function ajaxstart(){
	$('#publishbtn').text('处理中');
	$('#textarea2').val('');
	$('#publishbtn').addClass('load');
}
//处理结束
function ajaxend(){
	$('#publishbtn').text('发表');
	$('#publishbtn').removeClass('load');
}

//Ctrl+Enter发送
function keySend(e){
	var _e = e?e:window.event;
	if (_e.ctrlKey && _e.keyCode == 13) {
		$('#publishbtn').trigger("click");
		}
	}
	
//在光标处插入内容
(function ($) {
	$.fn.extend({
        insertAtCaret: function (myValue) {
            var $t = $(this)[0];
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            } else{
                if ($t.selectionStart || $t.selectionStart == '0') {
                    var startPos = $t.selectionStart;
                    var endPos = $t.selectionEnd;
                    var scrollTop = $t.scrollTop;
                    $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                    this.focus();
                    $t.selectionStart = startPos + myValue.length;
                    $t.selectionEnd = startPos + myValue.length;
                    $t.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }
            }
        }
    })
})(jQuery);
</script>