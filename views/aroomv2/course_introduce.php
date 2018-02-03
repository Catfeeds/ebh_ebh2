<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" type="text/css">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
</head>

<body>
	<div class="ter_tit">
		当前位置 > <a href="<?=geturl('aroomv2/course')?>">课程管理</a> > <a href="<?=geturl('aroomv2/course/courselist')?>">课程列表</a> > 课程介绍
		<a href="javascript:void(0)" class="dklte" onclick="showintroduce(<?=$folder['folderid']?>)">添加模块</a>
	</div>
	<div class="leftou" style="padding:20px;width:746px;">
		<h2 class="kdtug"><?=$folder['foldername']?></h2>
		<?php if(!empty($folder['introduce'])){
		foreach($folder['introduce'] as $k=>$introduce){
			?>
			<div class="introduceitem">
				<div class="ksthg">
					<span class="kstrhf"><?=$introduce['title']?></span>
					<a href="javascript:void(0)" onclick="showcourseedit(event)" class="kstbeys">[编辑]</a>
					<a href="javascript:void(0)" onclick="delm(event)" class="lsitgfd"></a>
				</div>
				<div class="dfyxc"><?=$introduce['content']?></div>
			</div>
		<?php 
			}
		}
		?>
	  <!--
    	<div class="ksthg">
        	<span class="ksdy">请点击右侧按钮进行内容编辑</span>
            <a href="#" class="kstbeys">[编辑]</a>
      </div>-->
		<div class="dfyxc btns">
		<!--
       	  <textarea class="ksyht" name="textarea" cols="45" id="textarea"></textarea>-->
			<a href="javascript:void(0)" onclick="save()" class="lstybtn">保存</a>
		</div>
		
	</div>
	
<script>
	function showintroduce(folderid){
		if (window.parent.showintroduce != undefined)
		{
			window.parent.showintroduce(folderid);
		}
	}
	function delm(e){
		var o = e.srcElement ? e.srcElement : e.target;
		$(o.parentNode.parentNode).remove();
	}
	
	function showcourseedit(e){
		if (window.parent.showcourseedit != undefined)
		{
			// var editor = UM.getEditor('courseeditor');
			var o = e.srcElement ? e.srcElement : e.target;
			var element = $(o).parent().parent().find('.dfyxc');
			var element2 = $(o).parent().find('.kstrhf');
			// $.each($('.introduceitem '),function(k,v))
				
			window.parent.showcourseedit(element,element2);
			// ue.setContent(element.html());
			// console.log($(e.target).parent().parent().find('.dfyxc').html());
		}
		// console.log($(e.target));
	}
	function save(){
		var dataarr = new Array();
		$.each($('.introduceitem'),function(k,v){
			dataarr[k] = new Object();
			dataarr[k].title = $(v).find('.kstrhf').html();
			dataarr[k].content = $(v).find('.dfyxc').html();
			// console.log(v);
			// console.log($(v));
		});
		// console.log(dataarr);
		$.ajax({
			type:'post',
			url:'/aroomv2/course/introduce/save.html',
			data:{'introducearr':dataarr,folderid:<?=$folder['folderid']?>},
			success:function(data){
				$.showmessage({
					img : 'success',
					message:'保存成功'
				});
			}
		});
	}
</script>
</body>
</html>