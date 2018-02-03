<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/dayi.css" rel="stylesheet" />
<style>
.iradio{
	height:20px;
	width:20px;
}
.ilabel{
	margin-right:50px;
	font-size:20px;
}
h2{
	font-size:16px;
	font-weight:bold;
	margin-top:10px;
}
.contentspan{
	font-size:16px;
}
.quesdiv{
	width:756px;
	margin-left:10px;
	margin-top:10px;
}
.relatediv{
	margin-left:10px;
	margin-top:10px;
	font-size:14px;
	color:#999
}
</style>
<div style="width:825px;margin:0 auto;">
<div class="lefrig">

	<div style="float:left;margin-top:20px;background:#fff;border:1px solid #cdcdcd">
		<h2 style="width:820px;text-align:center"><?=$survey['title']?></h2>
		<?php if(!empty($relateinfo)){?>
		<div class="relatediv">
		本问卷为 <?=$relateinfo['type']?> - <span style="color:red" ><?=$relateinfo['title']?></span> 的关联问卷
		</div>
		<?php }?>
		<form id="mainform" action="/myroom/survey/doit.html" method="post" onsubmit="return asubmit()">
		<input type="hidden" name="sid" value="<?=$survey['sid']?>"/>
		<?php $iArr = array('A','B','C','D');?>
		<div id="quescontent" style="">
			<?php foreach($survey['content'] as $k=>$content){?>
			<div style="" class="quesdiv">
				<label class="contentspan"><?=($k+1)?>.</label>
				<span class="contentspan"><?=$content['title']?></span>
				<div style="margin-top:5px">
					<?php $l=0;
					foreach($content['item'] as $item){
						if(trim($item,' ') != ''){
						?>
					<label class="ilabel"><input class="iradio" type="radio" name="<?=$k?>[]" value="<?=$l?>"/> <span><?=chr(65+$l).'.'.$item?></span></label>
					<?php $l++;}
					}?>
				</div>
			</div>
			<?php }?>
			
		</div>
		
		
		<div style="float:left;padding-bottom:20px" class="fontfen">
			<input style="margin-left:370px" type="submit" class="tijibtn" value="提交">
		</div>
		</form>
	</div>

</div>
</div>

	<script type="text/javascript">
	function asubmit(){
		if(!checkform()){
			return false;
		}
		// return false;
	}
	function checkform(){
		var finished = true;
		$.each($('.quesdiv'),function(k,v){
			$(this).css('border','none');
			$(this).css('padding-left','0px');
			if($(this).find(':radio:checked').length == 0){
				finished = false;
				$(this).find(':radio:first').focus();
				$(this).css('border','1px solid red');
				$(this).css('padding-left','10px');
				return false;
			}
		});
		if(finished)
			return true;
		return false;
	}
	</script>

<?php $this->display('myroom/page_footer'); ?>