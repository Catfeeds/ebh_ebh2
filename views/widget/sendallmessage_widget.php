<?php
/**
 * 发送私信widget
 * 用法：在view里面输入代码：
 * 1.在父窗口显示:<?php $this->widget('sendmessage_widget'); ?>
 * 2.在当前窗口显示:<?php $this->widget('sendmessage_widget', array(), array('window_type' => 'self'));?>
 * 3.教师房间调用:<?php $this->widget('sendmessage_widget', array(), array('room_type' => 'troom')); ?>
 * 4.发送成功后刷新页面:<?php $this->widget('sendmessage_widget', array(), array('reload' => 'yes')); ?>
 *
 * 需配合按钮代码使用($user 收件人信息):
 * <a class="hrelh" href="javascript:;" tid="<?=$user['uid']?>" tname="<?= empty($user['realname'])?$user['username']:$user['realname'] ?>" title="给<?=$user['sex'] == 1 ? '她' : '他'?>发私信"></a>
 */
$room_type= 'myroom';//默认学生房间调用
$window_type = 'parent';//默认父窗口显示弹出层
$reload = 'no';
if (isset($property['room_type']) && $property['room_type'] == 'troom')
{
	$room_type = 'troom';
}elseif (isset($property['room_type']) && $property['room_type'] == 'troomv2'){
	$room_type = 'troomv2';
}
if (isset($property['window_type']) && $property['window_type'] == 'self')
{
	$window_type = 'self';
}
if (isset($property['reload']) && $property['reload'] == 'yes')
{
	$reload = 'yes';
}
?>
<meta content="width=1200, user-scalable=no" name="viewport"/>
<style type="text/css">
a.hrelh {display:block;margin:1px 0 0 8px;background:url(http://static.ebanhui.com/ebh/tpl/2014/images/xiudty_s.jpg) no-repeat left center;color:#2796f0;cursor:pointer;float:left;height:14px;line-height:24px;text-align:center;text-decoration:none;padding-left:20px;}
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
<script type="text/javascript">
<?php if($window_type == 'parent') {?>
$(function(){
	$("#sendmessage").click(function(){
		var msg =  $.trim($("textarea.txttiantl",parent.document).val());
		var tid = $("#wrap2 li:first",parent.document).attr("tid");

		if($("#wrap2",parent.document).html() == ''){
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
		    url: "<?=geturl($room_type . '/msg/do_send');?>",
		    data:{tid:tid, msg:msg},
		    success:function(res){
		        if(res=="1"){
					parent.window.showSendSuccess();
					<?php if ($reload == 'yes') {?>window.location.reload();<?php }?>
				}else{
					parent.window.showSendFail();
				}
		 	}
		});
	});

	$(".hrelh").click(function(){
		parent.window.H.get('wxDialog').exec('show');
		//每次打开重置收件人和信息内容
		$("#wrap2",parent.document).html("");
		$("textarea.txttiantl",parent.document).val("");
		//添加收件人
		var tid = $(this).attr("tid");
		var tname = $(this).attr("tname");
		$("#wrap2",parent.document).append('<li tid="'+tid+'" class="lvtewu" style="display:block">'+tname+'</li>');
		//焦点对话框
		$("textarea.txttiantl",parent.document).focus();
		//焦点对话框
		$("textarea.txttiantl",parent.document).focus();
	});

	//创建dialog
    parent.window.H.remove('wxDialog');
	$('#wxDialog',parent.window.document.body).remove();
    parent.window.H.create(new P({
        id:'wxDialog',
        title:'发私信',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');

});
<?php } else {?>
$(function(){
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
		    url: "<?=geturl($room_type . '/course/sendmsgAjax');?>",
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

	$(".hrelh").click(function(){
		window.H.get('wxDialog').exec('show');
		//每次打开重置收件人和信息内容
		$("#wrap2").html("");
		$("textarea.txttiantl").val("");
		//添加收件人
		var all = $(this).attr('all');
		var cwid = $(this).attr("cwid");
		$.ajax({
			type: "POST",
		    url: "<?=geturl($room_type . '/course/getReviewUid');?>",
		    data:{cwid:cwid},
		    success:function(res){
		    	var data = JSON.parse(res);
		    	if(data.status != 0){
		    		$.each(data,function(i,item){
		    		$("#wrap2").append('<li tid="'+item.uid+'" class="lvtewu"  style="white-space: nowrap;">'+item.username+'</li>');
		    		
		    	});
		    	}else{
		    		alert('暂无可以私信的对象！');
		    		window.H.get('wxDialog').exec('hide');
		    	}
		    	
		 	}
		});
		//焦点对话框
		$("textarea.txttiantl").focus();
	});

	//创建dialog
    window.H.remove('wxDialog');
    //$('#wxDialog').remove();
    window.H.create(new P({
        id:'wxDialog',
        title:'发私信',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');

});
<?php }?>
</script>