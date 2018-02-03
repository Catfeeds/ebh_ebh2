<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/courses/css/jisrn.css?version=20160608001" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<!-- 引入xdialog弹出层控件开始 -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
<!-- 引入xdialog弹出层控件结束 -->
<title>分类设置</title>
</head>

<body>
<div class="cright" style="margin-top: 0">
	<div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/course.html">课程管理</a> >
        <a href="/aroomv2/jingpin.html">引入公共课程</a>
        > 分类设置
    </div>
    <div class="bsirfd">
        <div class="gerded">
            分类设置<a id="cateseting" class="lisrchsr" href="javascript:;"></a>
        </div>
        <div class="lisrnds">
        	<ul id="coursetypeset">
        		<?php foreach ($mlist as $mitem){ ?>
        			<li class="ilshre" data-i="<?=$mitem['pid']?>">
        				<i class="iconjia"></i>
        				<div class="husirrt">
        					<?=$mitem['pname']?><a href="javascript:;" class="bistrs" data-o="main_<?=$mitem['pid']?>"></a>
        					<a href="javascript:;" class="sahsnt" data-o="main_<?=$mitem['pid']?>"></a>
        				</div>
        				<?php foreach ($tslist[$mitem['pid']] as $sitem){ ?>
        				<div class="zishre" data-s="<?=$sitem['sid']?>" style="display:block">
        					<i class="iconxiao"></i>
        					<div class="etdsgd" data-p="<?=$mitem['pid']?>">
        						<?=$sitem['sname']?><a href="javascript:;" class="bistrs" data-o="sub_<?=$sitem['sid']?>"></a>
        						<a href="javascript:;" class="sahsnt" data-o="sub_<?=$sitem['sid']?>"></a>
        					</div>
        				</div>
        				<?php } ?>
        				<div class="zishre" style="display:block">
        					<i class="iconxiao"></i>
        					<a href="javascript:;" class="jfyerd subset">点击创建课程子类别</a>
        					<?php if(empty($tslist[$mitem['pid']])){ ?><span class="jietfg">[必须创建]</span><?php } ?><!-- 如果已经有子分类隐藏必须创建 -->
        				</div>
        			</li>
        		<?php } ?>
        	</ul>
        </div>
    </div>
</div>

<div id="typedialog" style="display:none" class="lisrers">
	<p class="huietsd">您确定要删除该类别吗？</p>
    <p class="jiswrrt">删除该“课程类别”，所属该类别下的所有课程将同步删除</p>
    <a href="javascript:;" class="lisnrwe">确定</a>
    <a href="javascript:;" class="oklsuirh">取消</a>
    <input id="topid" type="hidden" value=0>
    <input id="tosid" type="hidden" value=0>
    <input id="typestr" type="hidden" value="">
</div>

<script language="javascript">
$(function(){
	$('#cateseting').on('click',function(){
		var tmpl = getMainSetTmpl();
		$('#coursetypeset li').length == 0 ? $('#coursetypeset').html(tmpl) : $('#coursetypeset li:last').after(tmpl);
	})
	$(document).on('click','.subset',function(){
		var tmpl = getSubSetTmpl();
		$(this).parent().before(tmpl);
	})
	$(document).on('focus','.husre',function(e){
		var target = e.srcElement || e.target;
		var str = $.trim($(this).val());
		if($(target).is('.mainsettype')){
			if(str == '请输入课程主类别'){
				$(target).val('');
				$(target).css({'color':'#000'});	
			}
		}else{
			if(str == '请输入课程子类别'){
				$(target).val('');
				$(target).css({'color':'#000'});	
			}
		}
	})
	$(document).on('blur','.husre',function(e){
		var target = e.srcElement || e.target;
		var str = $.trim($(this).val());
		if($(target).is('.mainsettype')){
			if(str == ''){
				$(target).val('请输入课程主类别');
				$(target).css({'color':'#999'});		
			}
			if(str.length >30){
				alert('输入字数不能超过30，请重新输入！');
				$(target).val('请输入课程主类别');	
				$(target).css({'color':'#999'});		
			}
		}else{
			if(str == ''){
				$(target).val('请输入课程子类别');
				$(target).css({'color':'#999'});	
			}
			if(str.length >30){
				alert('输入字数不能超过30，请重新输入！');
				$(target).val('请输入课程主类别');
				$(target).css({'color':'#999'});		
			}
		}
	})
	//保存数据
	$(document).on('click','.hisres',function(e){
		var target = e.srcElement || e.target;
		var str = $.trim($(target).siblings(".husre").val());
		var node = $(target).parent();
		var pid = $(this).data('p');
		var sid = pid ? pid : 0;
		if($(target).is('.savemainset')){
			//主类别设置
			if(str == '请输入课程主类别'){
				alert('请输入课程主类别');
				return false;
			}
			$.post('/aroomv2/jingpin/savemaintype.html',{str:str,pid:pid},function(data){
				node.removeClass('nudtds').addClass('husirrt');
				node.html(str+'<a href="javascript:;" class="bistrs" data-o="main_'+data.id+'"></a><a href="javascript:;" class="sahsnt" data-o="main_'+data.id+'"></a>');
				//如果是新建的大类保存完后，直接显示子类录入项
				if(parseInt(node.parent().attr('data-i')) == 0){
					node.siblings().find('.subset').trigger('click');
				}
				node.parent().attr('data-i',data.id);
			},'json');
		}else if($(target).is('.savesubset')){
			//子类别设置
			pid = $(target).parent().parent().parent().attr('data-i');
			if(pid == 0){
				alert('请先添加主类别');
				return false;
			}
			if(str == '请输入课程子类别'){
				alert('请输入课程子类别');
				return false;
			}
			$.post('/aroomv2/jingpin/savesubtype.html',{str:str,pid:pid,sid:sid},function(data){
				node.removeClass('nudtds').addClass('etdsgd');
				node.attr('data-p',pid);
				node.parent().attr('data-s',data.sid);
				node.html(str+'<a href="javascript:;" class="bistrs" data-o="sub_'+data.sid+'"></a><a href="javascript:;" class="sahsnt" data-o="sub_'+data.sid+'"></a>');
				node.parent().siblings().find('.jietfg').remove();
			},'json');
		}
	})
	//折叠
	$(document).on('click','.iconjia',function(e){
		$(this).removeClass('iconjia').addClass('iconjian');
		$(this).parent().find('.zishre').hide();
	})
	//展开
	$(document).on('click','.iconjian',function(e){
		$(this).removeClass('iconjian').addClass('iconjia');
		$(this).parent().find('.zishre').show();
	})
	//编辑
	$(document).on('click','.bistrs',function(e){	
		var target = e.srcElement || e.target,
			data = $(this).data('o'),
			arr = data.split('_'),
			id = arr[1];
		if(arr[0] == 'main'){
			var obj = $(target).parent().removeClass('husirrt').addClass('nudtds'),
				defv = $.trim(obj.text());
				obj.html('<input style="color:#000" class="husre mainsettype" name="textarea" type="text" value="'+defv+'"><a href="javascript:;" class="hisres savemainset" data-p="'+id+'">确定</a>');
				$(target).parent().find('.mainsettype').focus();
		}else if(arr[0] == 'sub'){
			var tnode = $(target).parent(),
				defv = $.trim(tnode.text()),
				obj = tnode.removeClass('etdsgd').addClass('nudtds');
				obj.html('<input style="color:#000" class="husre subsettype" name="textarea" type="text" value="'+defv+'"><a href="javascript:;" class="hisres savesubset" data-p="'+id+'">确定</a>');
				tnode.find('.subsettype').focus();
		}
	})
	//删除分类处理
	function delSort(type,pid,sid){
		var purl = type == 'main' ? '/aroomv2/jingpin/delmaintype.html' : '/aroomv2/jingpin/delsubtype.html';
		if(type == 'main' && pid >0){
			$.post(purl,{pid:pid},function(data){
				if(data.code == 0){
					$('#coursetypeset li[data-i='+pid+']').remove();
				}else{
					alert('删除失败!');
				}
			},'json');
		}else if(type == 'sub' && sid >0 && pid>0){
			$.post(purl,{sid:sid,pid:pid},function(data){
				if(data.code == 0){
					$('.zishre[data-s='+sid+']').remove();
				}else{
					alert('删除失败!');
				}
			},'json');
		}
	}
	//删除
	$(document).on('click','.sahsnt',function(e){
		var target = e.srcElement || e.target,
			data = $(this).data('o'),
			arr = data.split('_'),
			pid = 0,
			sid = 0;
		if(arr[0] == 'main'){
			pid = arr[1];	
		}else{
			pid = $(target).parent().parent().parent().data('i');
			sid = arr[1];
		}
		if(arr[0] == 'main' && pid == 0){
			$(target).parent().parent().remove();
			return false;
		}
		if(arr[0] == 'sub' && sid == 0){
			$(target).parent().parent().remove();
			return false;
		}
		$('#topid').val(pid);
		$('#tosid').val(sid);
		$('#typestr').val(arr[0]);
		
		H.create(new P({
	        id:arr[0]+'dialog',
	        content:$('#typedialog'),
	        easy:true
	    })).exec('show');
	    return false;  
	})
	//取消删除
	$('.oklsuirh').on('click',function(){
		var typestr = $('#typestr').val();
		H.get(typestr+'dialog') && H.get(typestr+'dialog').exec('close');
	})
	//确认删除
	$('.lisnrwe').on('click',function(){
		var typestr = $('#typestr').val(),
			pid = parseInt($('#topid').val()),
			sid = parseInt($('#tosid').val());
		delSort(typestr,pid,sid);
		H.get(typestr+'dialog') && H.get(typestr+'dialog').exec('close');
	})
	//单击空白处取消编辑
	$(document).on('click', function(e) {
    	var target = e.srcElement || e.target;
        if(!( $(target).is('.bistrs') || $(target).is('.subsettype') || $(target).is('.mainsettype') || $(target).is('.lisrchsr') || $(target).is('.subset'))){
        	canceledit();   
        }
    })
})

//取消编辑状态
function canceledit(){
	//暂时不启用取消编辑功能
	return false;
	$('#coursetypeset li').each(function(index){
		var self = this,
		node = $(self).find('.mainsettype'),
		meditorstr = node.val(),
		pid = node.parent().parent().attr('data-i');
		var mhtml =  meditorstr;
			mhtml += '<a href="javascript:;" class="bistrs" data-o="main_'+pid+'"></a>';
			mhtml += '<a href="javascript:;" class="sahsnt" data-o="main_'+pid+'"></a>';
		node.parent().removeClass('nudtds').addClass('husirrt').html(mhtml);

		snodes = $(self).find('.subsettype');
		snodes.each(function(idx){
			var myself = this;
				seditorstr = $(myself).val(),
				sid = $(myself).parent().parent().attr('data-s');
			var shtml = seditorstr;
				shtml += '<a href="javascript:;" class="bistrs" data-o="sub_'+sid+'"></a>';
				shtml += '<a href="javascript:;" class="sahsnt" data-o="sub_'+sid+'"></a>';	
			$(myself).parent().removeClass('nudtds').addClass('etdsgd').html(shtml);
		})
	})
}
function getMainSetTmpl(){
	var tmpl = '';
		tmpl += '<li class="ilshre" data-i="0"><i class="iconjia"></i>';
		tmpl += '<div class="nudtds"><input class="husre mainsettype" name="textarea" type="text" value="请输入课程主类别" />';
       	tmpl += '<a href="javascript:;" class="hisres savemainset" data-p="0">确定</a></div>';
       	tmpl += '<div class="zishre"><i class="iconxiao"></i><a href="javascript:;" class="jfyerd subset">点击创建课程子类别</a>';
        tmpl += '<span class="jietfg">[必须创建]</span></div>';
    return tmpl;
}
function getSubSetTmpl(){
	var tmpl = '';
		tmpl += '<div class="zishre" data-s="0"><i class="iconxiao"></i><div class="nudtds" data-p="0">';
		tmpl += '<input class="husre subsettype" name="textarea" type="text" value="请输入课程子类别" />';
		tmpl += '<a href="javascript:;" class="hisres savesubset" data-p="0">确定</a></div></div>';
	return tmpl;
}
</script>
</body>
</html>