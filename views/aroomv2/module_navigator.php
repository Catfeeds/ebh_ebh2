<?=$this->display('aroomv2/page_header');?>
<body>
<style>
input.addsnav{float:right; background:#5e96f5; padding:3px 15px; margin-right:10px; margin-bottom:10px; color:#fff; height:auto; border:none; cursor:pointer; border-radius:3px;display:inline;font-family:微软雅黑;font-family:Microsoft YaHei;}
input.addsnav:hover{background:#4e8bf1;}
.tables div.kaiqi:hover {background: #fff;}
.editnick,.nickname,.cmedit,.navdel{
	font-size:14px;
}
.studentspeizhi .tables .imgas{
	right:24px;
}
.datatr{float:left;display:inline}
.tables div.first .td{
	padding:0 6px !important;
}
.urlspan{display:inline-block;height:24px;width:190px;overflow:hidden; float:left;}
</style>
<div>
	<div class="ter_tit">
		<div style="float:left; display:inline;">当前位置 ><a href="<?=geturl('aroomv2/module')?>">门户配置</a> > 网校导航配置</div>
	</div>
	<div style="clear:both;"></div>
	<div class="studentspeizhi mt10">		
		<input type="button" class="addsnav" value="新增导航" onclick="addnavpre()">
		<div style="clear:both;"></div>
		<form id="mainform" autocomplete="off">
			<div  class="tables" id="listtable">
				<div class="first">
					<div class="td" style="width:312px;">名称</div>
					<div class="td" style="width:60px;">分类</div>
					<div class="td" style="width:240px;">编辑</div>
					<div class="td" style="width:68px;">操作</div>
					<div class="td" style="width:48px;">排序</div>
				</div>
				
				<?php foreach($navigatorlist as $k=>$nav){
					$notsys = !in_array($nav['code'],$defaultnav);?>
				<div class="datatr">
					<input type="hidden" name="name[]" value="<?=$nav['name']?>"/>
					<input type="hidden" name="url[]" value="<?=empty($nav['url'])?'':$nav['url']?>"/>
					<input type="hidden" name="target[]" value="<?=empty($nav['target'])?'':$nav['target']?>"/>
					<input type="hidden" <?=$notsys?'class="index"':''?> name="code[]" value="<?=$nav['code']?>"/>
					
					<div class="td" style="width:312px;">
						<span class="editnick" style="display:block;width:300px;cursor:text; color:#6287d5;" title="" ><?=empty($nav['nickname'])?$nav['name']:$nav['nickname']?></span>
						<input type="text" class="nickname" name="nickname[]" style="display:none;width:280px;border:1px solid #9eb7cb;height:21px;line-height:21px;padding:0 5px;" maxlength="10" value="<?=empty($nav['nickname'])?$nav['name']:$nav['nickname']?>">
					</div>
					<div class="td" style="width:60px;"><?=$notsys?(empty($nav['url'])?'资讯':'自定义'):'系统'?></div>
					<div class="td oplinks" style="width:240px;">
						<?php if($notsys && empty($nav['url'])){?>
						<a href="javascript:void(0)" class="cmedit">导读内容</a>
						<a href="javascript:void(0)" class="subn">添加二级菜单</a>
						<a href="javascript:void(0)" class="navdel">删除</a>
						<a href="javascript:void(0)" class="conman">资讯管理</a>
						<?php }elseif($notsys && !empty($nav['url'])){?>
						<a href="javascript:void(0)" class="navdel" style="float:left;padding-right:5px;">删除</a>
						<span class="urlspan" title="<?=$nav['url']?>"><?=shortstr($nav['url'],28)?></span>
						<?php }?>
					</div>
					<div class="td" style="width:68px;">
						<label>
						<input type="hidden" name="available[]" class="available" value="<?=empty($nav['available'])?0:$nav['available']?>"/>
						<input class="seta" type="checkbox" value="1" style="position: relative;top: 3px; margin-right:5px;width:17px;height:17px" <?=(!empty($nav['available']))?'checked="checked"':''?> /><span style="font-size:14px">启用</span> 
						</label>
						
					</div>
					<div class="td" style="width:48px;min-height:26px;">
						<?php if($nav['code']!='index'){?>
						<a href="javascript:void(0)" class="imges moveup"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png"  /></a>
						<a href="javascript:void(0)" class="imgas movedown"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png"  /></a>
						<?php }else{?>
							<span style="height:26px;display:block"> </span>
						<?php }?>
					</div>
					
					
					<?php if(!empty($nav['subnav'])){
						foreach($nav['subnav'] as $k=>$subnav){?>
					<div class="datatr subdatatr" style="padding-left:50px">
						<input type="hidden" name="parentindex[]" class="pindex" value="<?=$nav['code']?>"/>
						<input type="hidden" class="index subindex" name="<?=$nav['code']?>subcode[]" value="<?=$subnav['subcode']?>"/>
						<div class="td" style="width:262px;">
							<span class="editnick" style="display:block;width:250px;cursor:text; color:#6287d5;" title="" ><?=$subnav['subnickname']?></span>
							<input type="text" class="nickname" name="<?=$nav['code']?>subnickname[]" style="display:none;width:260px;border:1px solid #9eb7cb;height:21px;line-height:21px;padding:0 5px;" maxlength="10" value="<?=$subnav['subnickname']?>">
						</div>
						<div class="td" style="width:60px;">二级资讯</div>
						<div class="td" style="width:240px;">
							<a href="javascript:void(0)" class="navdel">删除</a>
							<a href="javascript:void(0)" class="conman">资讯管理</a>
						</div>
						<div class="td" style="width:68px;">
							<label>
							<input type="hidden" name="<?=$nav['code']?>subavailable[]" class="available" value="<?=$subnav['subavailable']?>"/>
							<input class="seta" type="checkbox" value="1" style="position: relative;top: 3px; margin-right:5px;width:15px;height:15px" <?=(!empty($subnav['subavailable']))?'checked="checked"':''?> /><span style="font-size:14px">启用</span> 
							</label>
						</div>
						<div class="td" style="width:48px;min-height:26px;">
							<a href="javascript:void(0)" class="imges submoveup"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png"  /></a>
							<a href="javascript:void(0)" class="imgas submovedown"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png"  /></a>
						</div>
					</div>
					<?php }
					}?>
				</div>
				<?php }?>
				
				
			</div>
		</form>
		<!--
		<div class="button2 fr"><a href="javascript:void(0)" onclick="savenavigator()">保 存</a></div>
		-->
		<br>
		<b style="color:#FF5252">注: 单击模块名称进行修改</b>
	</div>
</div>
<div id="delnav" class="tanchukuang" style="display:none;height:160px;">
	<div class="tishi" style="padding-top:20px;"><span style=" line-height:127px;">你确定要删除该导航吗？</span></div>
</div>
<div id="addnav" class="tanchukuang" style="display:none;height:auto;">
	<span>导航名称：</span><input id="newnav" maxlength="10" style="border:1px solid #e1e1e1; width:318px; height:24px; line-height:24px; padding-left:5px; color:#333; margin-top:15px;">
	<div style="clear:both; margin-top:10px;text-align:left;padding-left:8px;">
		<span>导航类型：</span>
		<label>
		<input type="radio" name="navtype" value="0" checked="checked"/>
		资讯</label>
		<label>
		<input type="radio" name="navtype" value="1" style="margin-left:10px;" />
		自定义链接</label>
	</div>
	<div class="cusdiv" style="display:none">
		<span style="clear:both;">链接地址：</span><input id="theurl" style="border:1px solid #e1e1e1; width:318px; height:24px; line-height:24px; padding-left:5px; color:#333; margin-top:15px;">
		<div style="clear:both; margin-top:10px;text-align:left;padding-left:8px;">
			<span>打开方式：</span>
			<label>
			<input type="radio" name="navtarget" value="0" checked="checked"/>
			新页面</label>
			<label>
			<input type="radio" name="navtarget" value="1" style="margin-left:10px;"/>
			本页面</label>
		</div>
	</div>
</div>
<div id="addsub" class="tanchukuang" style="display:none;height:40px;">
	<input id="newsub" maxlength="10" style="border:1px solid #e1e1e1; width:385px; height:24px; line-height:24px; padding-left:5px; color:#333; margin-top:15px;">
</div>
</body>
<script>
var namearr = new Array();
$('.editnick').live('click',function(){
	$(this).hide();
	$(this).next().show();
	$(this).next().focus();
});
$('.nickname').live('blur',function(){
	$(this).hide();
	var nickname = $(this).val();
	if($.trim(nickname) != ''){
		// nickname = '单击输入别名';
		$(this).prev().html(nickname);
	}
	$(this).prev().show();
	savenavigator();
});

function savenavigator(){
	$.each($('.datatr'),function(k,v){
		if(k==1){
			$(v).find('.moveup').hide();
			$(v).find('.movedown').css('right','0');
		}else if(k==2){
			$(v).find('.moveup').show();
			$(v).find('.movedown').css('right','24px');
			return ;
		}
	});
	
	$.post('/aroomv2/module/savenavigator.html',$('#mainform').serialize(),function(data){
		
		if(data==1){
			// H.get('xtips').exec('setContent','保存成功').exec('show').exec('close',700);
		}else{
			H.get('xtips').exec('setContent','保存失败，导航数量过多').exec('show').exec('close',1000);
		}
	});
	
}

$('.moveup').live('click',function(){
	$(this).parent().parent().prev('.datatr').before($(this).parent().parent());
	savenavigator();
});
$('.movedown').live('click',function(){
	$(this).parent().parent().next('.datatr').after($(this).parent().parent());
	savenavigator();
});
$('.submoveup').live('click',function(){
	$(this).parent().parent().prev('.subdatatr').before($(this).parent().parent());
	savenavigator();
});
$('.submovedown').live('click',function(){
	$(this).parent().parent().next('.subdatatr').after($(this).parent().parent());
	savenavigator();
});
$('.seta').live('click',function(){
	if($(this).attr('checked') == 'checked')
		$(this).prev('.available').val(1);
	else
		$(this).prev('.available').val(0);
	savenavigator();
})
$('.navdel').live('click',function(){
	curtr = $(this).parents('.datatr:first');
	index = curtr.find('.index:not(.subindex)').val();
	if(index){
		var nsindexobj = $('.subindex[name="'+index+'subcode[]"]');
		if(nsindexobj.length){
			alert('有二级菜单,不能删除');
			return;
		}
	}
	if(!H.get('delnav')){
		H.create(new P({
			id : 'delnav',
			title: '删除导航',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#delnav')[0]
		}),'common').exec('show');
		
	}else{
		H.get('delnav').exec('show');
	}
});
var curtr;
$('.subn').live('click',function(){
	
	curtr = $(this).parents('.datatr');
	if(!H.get('addsub')){
		H.create(new P({
			id : 'addsub',
			title: '添加二级菜单',
			easy:true,
			width:420,
			padding:5,
			button:button3,
			content:$('#addsub')[0]
		}),'common').exec('show');
		
	}else{
		H.get('addsub').exec('show');
	}
});
function addsub(){
	// $('#editorblock').show();
	// $('#listtable').hide();
	
	index = curtr.find('.index:not(.subindex)').val();
	
	var nsindex = 0;
	var newnav = $('#newsub').val();
	var nsindexobj = $('.subindex[name="'+index+'subcode[]"]');
	var existarr = new Array();
	if(nsindexobj.length){
		$.each(nsindexobj,function(k,v){
			
			// console.log('n'+index+'s');
			curindex = parseInt(v.value.replace(index+'s',''));
			existarr[curindex] = 1;
			// if(curindex>nsindex)
				// nsindex = curindex;
			
		});
	}else{
		// nsindex = 0;
	}
	for(i=1;i<=99;i++){
		if(existarr[i] != 1){
			nsindex = i;
			break;
		}
	}
	// console.log(nsindex);
	
	var trstr = '<div class="datatr subdatatr" style="padding-left:50px">'+
				'	<input type="hidden" name="parentindex[]" class="pindex" value="'+index+'"/>'+
				'	<input type="hidden" class="index subindex" name="'+index+'subcode[]" value="'+index+'s'+nsindex+'"/>'+	
				'	<div class="td" style="width:262px;">'+
				'		<span class="editnick" style="display:block;width:250px;cursor:text; color:#6287d5;" title="" >'+newnav+'</span>'+
				'		<input type="text" class="nickname" name="'+index+'subnickname[]" style="display:none;width:260px;border:1px solid #9eb7cb;height:21px;line-height:21px;padding:0 5px;" maxlength="10" value="'+newnav+'">'+
				'	</div>'+
				'	<div class="td" style="width:60px;">二级资讯</div>'+
				'	<div class="td" style="width:240px;">'+
				'		<a href="javascript:void(0)" class="navdel">删除</a>'+
				'		<a href="javascript:void(0)" class="conman">资讯管理</a>'+
				'	</div>'+
				'	<div class="td" style="width:68px;">'+
				'		<label>'+
				'		<input type="hidden" name="'+index+'subavailable[]" class="available" value="0"/>'+
				'		<input class="seta" type="checkbox" value="1" style="position: relative;top: 3px; margin-right:5px;width:15px;height:15px" /><span style="font-size:14px">启用</span> '+
				'		</label>'+
				'	</div>'+
				'	<div class="td" style="width:48px;min-height:26px;">'+
				'		<a href="javascript:void(0)" class="imges submoveup"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png"  /></a>'+
				'		<a href="javascript:void(0)" class="imgas submovedown"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png"  /></a>'+
				'	</div>'+
				'</div>';
	if(nsindex == 1)
		curtr.append(trstr);
	else
		$('.pindex[value="'+index+'"]').parents('.datatr:not(.subdatatr)').append(trstr);
	savenavigator();
	top.resetmain();
	$('#newsub').val('');
	H.get('addsub').exec('close');
}

$('.cmedit').live('click',function(){
	
	curtr = $(this).parents('.datatr');
	
	index = curtr.find('.index').val();
	window.open('/aroomv2/module/navcm.html?index='+index);
	
});
$('.conman').live('click',function(){
	
	curtr = $(this).parents('.datatr:first');
	
	index = curtr.find('.index').val();
	window.open('/aroomv2/information/datainfor.html?navcode='+index);
	// location.href = '/aroomv2/information/datainfor.html?navcode='+index;
	
});
var reloadit = true;
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
				if(reloadit)
					location.reload(true);
				reloadit = true;
			}
		}),'common');
	}
}
var nindex=0;
	
function addnav(){
	// if($('.datatr:not(.subdatatr)').length == 10){
		// H.get('xtips').exec('setContent','最多10个导航栏目').exec('show').exec('close',1000);
		// return;
	// }
	var existarr = new Array();
	var nindexobj = $('.index:not(.subindex)');
	if(nindexobj.length){
		$.each(nindexobj,function(k,v){
			
			// console.log('n'+index+'s');
			curindex = parseInt(v.value.replace('n',''));
			existarr[curindex] = 1;
			// if(curindex>nsindex)
				// nsindex = curindex;
			
		});
	}else{
		// 
	}
	for(i=1;i<=99;i++){
		if(existarr[i] != 1){
			nindex = i;
			break;
		}
	}
	
	var newnav = $('#newnav').val();
	if($.trim(newnav) == ''){
		reloadit = false;
		H.get('xtips').exec('setContent','请填写导航模块名称').exec('show').exec('close',700);
		return;
	}
	var url = '';
	var target = '';
	var navtype = '资讯';
	if($('input[name=navtype]:checked').val()==1){
		url = $('#theurl').val();
		if($.trim(url) == ''){
			reloadit = false;
			H.get('xtips').exec('setContent','请填写链接地址').exec('show').exec('close',700);
			return;
		}
		var targetvalue = $('input[name=navtarget]:checked').val();
		target = targetvalue==0?'_blank':'_self';
		navtype = '自定义';
	}
	var trstr = '<div class="datatr">'+
				'	<input type="hidden" name="name[]" value="新内容"/>'+
				'	<input type="hidden" class="index" name="code[]" value="n'+nindex+'"/>'+
				'	<input type="hidden" class="index" name="url[]" value="'+url+'"/>'+
				'	<input type="hidden" class="index" name="target[]" value="'+target+'"/>'+
				'	<div class="td" style="width:312px;">'+
				'		<span class="editnick" style="display:block;width:300px;cursor:text; color:#6287d5;" title="" >'+newnav+'</span>'+
				'		<input type="text" class="nickname" name="nickname[]" style="display:none;width:280px;border:1px solid #9eb7cb;height:21px;line-height:21px;padding:0 5px;" maxlength="10" value="'+newnav+'">'+
				'	</div>'+
				'	<div class="td" style="width:60px;">'+navtype+'</div>'+
				'	<div class="td" style="width:240px;">'+
					(url==''?(
				'		<a href="javascript:void(0)" class="cmedit">导读内容</a>'+
				'		<a href="javascript:void(0)" class="subn">添加二级菜单</a>'+
				'		<a href="javascript:void(0)" class="navdel">删除</a>'+
				'		<a href="javascript:void(0)" class="conman">资讯管理</a>'):
					'<a href="javascript:void(0)" class="navdel" style="float:left;padding-right:5px;">删除</a>'+
					' <span class="urlspan" title="'+url+'">'+SetSub(url,24)+'</span>'
					)+
				'	</div>'+
				'	<div class="td" style="width:68px;">'+
				'		<label>'+
				'		<input type="hidden" name="available[]" class="available" value="0"/>'+
				'		<input class="seta" type="checkbox" value="1" style="position: relative;top: 3px; margin-right:5px;width:17px;height:17px" /><span style="font-size:14px">启用</span> '+
				'		</label>'+
				'	</div>'+
				'	<div class="td" style="width:48px;">'+
				'		<a href="javascript:void(0)" class="imges moveup"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png"  /></a>'+
				'		<a href="javascript:void(0)" class="imgas movedown"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png"  /></a>'+
				'	</div>'+
				'</div>';
				
	$('#listtable').append(trstr);
	savenavigator();
	top.resetmain();
	$('#newnav').val('');
	H.get('addnav').exec('close');
}
var button = new xButton();
var button2 = new xButton();
var button3 = new xButton();
$(function(){
	button.add({
		value:"确定",
		callback:function(e){
			// console.log(curtr);
			curtr.remove();
			savenavigator();
			delcm();
			H.get('delnav').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('delnav').exec('close');
			return false;
		}
	});
	
	
	button2.add({
		value:"确定",
		callback:function(e){
			addnav();
			return false;
		},
		autofocus:true
	});

	button2.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('addnav').exec('close');
			return false;
		}
	});
	
	button3.add({
		value:"确定",
		callback:function(e){
			addsub();
			return false;
		},
		autofocus:true
	});

	button3.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('addsub').exec('close');
			return false;
		}
	});
	
	// $.each($('.index:not(.subindex)'),function(k,v){
		// var temp = v.value.replace('n','');
		// if(temp>nindex)
			// nindex = temp;
	// });
	$.each($('.datatr'),function(k,v){
		if(k==1){
			$(v).find('.moveup').hide();
			$(v).find('.movedown').css('right','0');
		}else if(k==2){
			$(v).find('.moveup').show();
			$(v).find('.movedown').css('right','24px');
			return ;
		}
	});
	dialogtip();
});

function delcm(){
	index = curtr.find('.index').val();
	$.ajax({
		type:'post',
		data:{'index':index},
		url:'/aroomv2/module/delcm.html',
		success:function(){
			
		}
	});
}
function addnavpre(){
	if(!H.get('addnav')){
		H.create(new P({
			id : 'addnav',
			title: '添加导航',
			easy:true,
			width:420,
			padding:5,
			button:button2,
			content:$('#addnav')[0]
		}),'common').exec('show');
		
	}else{
		H.get('addnav').exec('show');
	}
}
$('input[name=navtype]').click(function(){
	if($(this).val() == 1){
		$('.cusdiv').show();
	}else{
		$('.cusdiv').hide();
	}
})
function SetSub(str,n){  
   var strReg=/[^\x00-\xff]/g;  
   var _str=str.replace(strReg,"**");  
   var _len=_str.length;  
   if(_len>n){  
     var _newLen=Math.floor(n/2);  
     var _strLen=str.length;  
     for(var i=_newLen;i<_strLen;i++){  
         var _newStr=str.substr(0,i).replace(strReg,"**");  
         if(_newStr.length>=n){
             return str.substr(0,i)+"...";  
             break;  
        }  
     }  
   }else{  
     return str;  
   }  
}  
</script>
</html>
