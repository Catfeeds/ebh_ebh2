<?=$this->display('aroomv2/page_header');?>
<body>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css<?=getv()?>"/>
<style>
.editnick,.nickname{
	font-size:14px;
}
.renametip{
	background:white;position:absolute;display:none;border:1px solid;width:110px;text-align:center;z-index:100;
}
.inouttip{
	background:white;position:absolute;display:none;border:1px solid;text-align:center;z-index:100;
	right:10px;margin-top:40px;padding:0 5px;
}
<?php if($tors==1){?>
.modulename1{
	width:470px;
}
.modulename2{
	width:170px;
}
.modulename3{
	width:100px;
}
<?php }?>
</style>
<div>
	<div class="ter_tit">
		当前位置 ><a href="<?=geturl('aroomv2/module')?>">门户配置</a> > <?=$tors?'老师':'学生'?>模块配置
		
	</div>
	<div class="studentspeizhi mt15">
		<form id="mainform" autocomplete="off">
		<div class="tables">
		
				<div class="first">
					<div class="modulename modulename1">模块名称</div>
					<div class="modulename modulename2">操作</div>
					<div class="modulename modulename3">排序</div>
					<?php if($tors==0){?>
					<div class="modulename modulename4">移动</div>
					<?php }?>
				</div>
				
				<?php foreach($modulelist as $k=>$module){?>
				<div class="datatr <?=$module['modulecode']=='more'?'moretr':''?>">
					<input type="hidden" name="moduleid[]" value="<?=$module['moduleid']?>"/>
					<input type="hidden" name="modulename[]" value="<?=$module['modulename']?>"/>
					<input type="hidden" name="modulecode[]" value="<?=$module['modulecode']?>"/>
					<input type="hidden" class="ismore" name="ismore[]" value="<?=$module['ismore']?>"/>
					<div class="modulename modulename1">
						<span class="editnick" style="display:block;width:400px;cursor:text; color:#6287d5;" title="" onmouseover="$('#renametip<?=$module['moduleid']?>').show()" onmouseout="$('#renametip<?=$module['moduleid']?>').hide()"><?=empty($module['nickname'])?($tors?$module['modulename_t']:$module['modulename']):$module['nickname']?></span>
						<input type="text" class="nickname" name="nickname[]" style="display:none;width:400px;border:1px solid #9eb7cb;height:22px;line-height:22px;padding:0 5px;" maxlength="100" value="<?=empty($module['nickname'])?($tors?$module['modulename_t']:$module['modulename']):$module['nickname']?>">
						<div id="renametip<?=$module['moduleid']?>" class="renametip">单击编辑模块名称</div>
					</div>
					<div class="modulename modulename2">
						<label>
						<input type="hidden" name="available[]" class="available" value="<?=empty($module['available']) && (!$onlysystem || $module['moduleid']==6 && $tors==1)?0:1?>"/>
						<input class="seta" type="checkbox" value="1" style="position: relative;top: 3px; margin-right:5px;width:18px;height:18px" <?=empty($module['available']) && (!$onlysystem || ($module['moduleid']==6 && $tors==1))?'':'checked="checked"'?>/><span style="font-size:14px">启用</span> 
						</label>
					</div>
					<div class="modulename modulename3">
						<?php if($module['modulecode'] != 'more'){?>
						<a href="javascript:void(0)" class="imges moveup"></a>
						<a href="javascript:void(0)" class="imgas movedown"></a>
						<?php }?>
					</div>
					
					<?php if($tors==0){?>
					<div class="modulename modulename4">
						<?php if($module['modulecode'] != 'more'){?>
						<a href="javascript:void(0)" class="inmore" moduleid="<?=$module['moduleid']?>"></a>
						<?php }?>
					</div>
					<div id="inouttip<?=$module['moduleid']?>" class="inouttip">移动到更多</div>
					<?php }?>
					
					<?php if($module['modulecode'] == 'more' && !empty($morelist)){
						foreach($morelist as $more){?>
						<div class="datatr subdatatr">
							<input type="hidden" name="moduleid[]" value="<?=$more['moduleid']?>"/>
							<input type="hidden" name="modulename[]" value="<?=$more['modulename']?>"/>
							<input type="hidden" name="modulecode[]" value="<?=$more['modulecode']?>"/>
							<input type="hidden" class="ismore" name="ismore[]" value="<?=$more['ismore']?>"/>
							<div class="modulename modulename1">
								<span class="editnick" style="display:block;width:400px;cursor:text; color:#6287d5;" title="" onmouseover="$('#renametip<?=$more['moduleid']?>').show()" onmouseout="$('#renametip<?=$more['moduleid']?>').hide()"><?=empty($more['nickname'])?($tors?$more['modulename_t']:$more['modulename']):$more['nickname']?></span>
								<input type="text" class="nickname" name="nickname[]" style="display:none;width:400px;border:1px solid #9eb7cb;height:22px;line-height:22px;padding:0 5px;" maxlength="100" value="<?=empty($more['nickname'])?($tors?$more['modulename_t']:$more['modulename']):$more['nickname']?>">
								<div id="renametip<?=$more['moduleid']?>" class="renametip">单击编辑模块名称</div>
							</div>
							<div class="modulename modulename2">
								<label>
								<input type="hidden" name="available[]" class="available" value="<?=empty($more['available']) && (!$onlysystem || $more['moduleid']==6)?0:1?>"/>
								<input class="seta" type="checkbox" value="1" style="position: relative;top: 3px; margin-right:5px;width:18px;height:18px" <?=empty($more['available']) && (!$onlysystem || ($more['moduleid']==6 && $tors==1))?'':'checked="checked"'?>/><span style="font-size:14px">启用</span> 
								</label>
							</div>
							<div class="modulename modulename3">
								<a href="javascript:void(0)" class="imges moveup"></a>
								<a href="javascript:void(0)" class="imgas movedown"></a>
							</div>
							<div class="modulename modulename4"><a href="javascript:void(0)" class="outmore" moduleid="<?=$more['moduleid']?>"></a></div>
							<div id="inouttip<?=$more['moduleid']?>" class="inouttip">移出更多</div>
						</div>
						<?php }
						}?>
						
				</div>
				
					
				<?php }?>
				
			</div>
		</form>
		<div class="button2 fr"><a href="javascript:void(0)" onclick="savemodule()">保 存</a></div>
	</div>
</div>
</body>
<script>
var namearr = new Array();
$('.editnick').click(function(){
	$(this).hide();
	$(this).next().show();
	$(this).next().focus();
});
$('.nickname').blur(function(){
	$(this).hide();
	var nickname = $(this).val();
	if($.trim(nickname) != ''){
		// nickname = '单击输入别名';
		$(this).prev().html(nickname);
	}
	$(this).prev().show();
});
function savemodule(){
	dialogtip();
	if(!ischecked()){
		H.get('xtips').exec('setContent','至少选择一个模块!').exec('show').exec('close',1000);
		setTimeout(function(){
			location.reload();
		},500);
		return false;
	}
	
	$.post('/aroomv2/module/savemodule.html?tors=<?=$tors?>',$('#mainform').serialize(),function(data){
		
		if(data==1){
			H.get('xtips').exec('setContent','保存成功').exec('show').exec('close',500);
		}else{
			H.get('xtips').exec('setContent','保存失败').exec('show').exec('close',500);
		}
	});
	
}
function ischecked(){
	var c = false;
	$.each($('.available'),function(k,v){
		if(v.value == 1){
			c = true;
			return ;
		}
	});
	return c;
}
$(function(){
	setnodown();
});
function setnodown(){
	<?php if($tors ==0){?>
	var modulelist = $('.datatr:not(.subdatatr)');
	modulelist.find('.movedown').show();
	modulelist.find('.moveup').css('top','1px');
	$(modulelist[modulelist.length-2]).find('.movedown').hide();
	$(modulelist[modulelist.length-2]).find('.moveup').css('top','9px');
	<?php }?>
}
$('.moveup').click(function(){
	$(this).parents('.datatr:first').prevAll('.datatr:first').before($(this).parents('.datatr:first'));
	$(this).trigger('mouseout');
	setnodown();
});
$('.movedown').click(function(){
	$(this).parents('.datatr:first').nextAll('.datatr:first').after($(this).parents('.datatr:first'));
	$(this).trigger('mouseout');
	setnodown();
});
$('.inmore').live('click',function(){
	$('.moretr').append($(this).parents('.datatr'));
	$(this).parent().prevAll('.ismore:first').val(1);
	$(this).parents('.datatr:first').addClass('subdatatr');
	$(this).attr('class','outmore');
	$(this).trigger('mouseout');
	setnodown();
});
$('.outmore').live('click',function(){
	$('.moretr').before($(this).parents('.datatr:first'));
	$(this).parent().prevAll('.ismore:first').val(0);
	$(this).parents('.subdatatr:first').removeClass('subdatatr');
	$(this).attr('class','inmore');
	$(this).trigger('mouseout');
	setnodown();
});
$('.inmore,.outmore').mouseover(function(){
	var moduleid = $(this).attr('moduleid');
	var text = '';
	if($(this).attr('class') == 'inmore')
		text = '移动到更多';
	else
		text = '移出更多';
	$('#inouttip'+moduleid).text(text);
	$('#inouttip'+moduleid).show();
});
$('.inmore,.outmore').mouseout(function(){
	var moduleid = $(this).attr('moduleid');
	$('#inouttip'+moduleid).hide();
});
$('.seta').click(function(){
	if($(this).attr('checked') == 'checked')
		$(this).prev('.available').val(1);
	else
		$(this).prev('.available').val(0);
})
$('.moveup').mouseover(function(){
	$(this).addClass('moveuphover');
}).mouseout(function(){
	$(this).removeClass('moveuphover');
})
$('.movedown').mouseover(function(){
	$(this).addClass('movedownhover');
}).mouseout(function(){
	$(this).removeClass('movedownhover');
})
$('.datatr').mouseover(function(){
	$(this).addClass('datatrhover');
}).mouseout(function(){
	$(this).removeClass('datatrhover');
})
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		}),'common');
	}
}
</script>
</html>
