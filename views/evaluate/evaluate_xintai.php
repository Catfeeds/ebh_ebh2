<div class="redsrt">
<h2 class="hrrty">应考心态测评</h2>
<p class="rgiege">心态，是心理状态，是体现人最本质、最内在的东西。心理过程是不断变化着、暂时性的，个性心理特征是稳固的，而心理状态是介于二者之间的，既有暂时性、又有稳固性，是心理过程与个性心理特征统一的表现。不同的心态，会导致不同的学习风格、不同的决策倾向。很多时候，我们并不能完全的看透自己，所以，心态测试应运而生，请试试下面的这些题目，进一步了解自己吧。</p>
<form id="mainform" action="/myroom/evaluate/result.html?ttype=1" method="post">
<ul>
<?php
foreach($evaluate_xintai as $k=>$q){
	
	$hideclass = '';
	if($k/10 > 1)
		$hideclass = 'inithide';
?>
<li class="fgngr" id="li<?=$k?>">
<p><?=$k?>.<?=$q['question']?></p>
<?php 
$i = 0;
foreach($q['selections'] as $l=>$sel){?>
<label><span class="greigd"><input name="q<?=$k?>" type="radio" value="<?=$q['scores'][$l]?>" class="radios"/> <?=$sel?></span></label>
<?php $i++;}?>
</li>
<?php
}
?>
</ul>

</form>
<a href="javascript:void(0)" class="brifbtn" onclick="submit()"></a>
</div>

<script>
function check(){
	$('#unselect').html('');
	$.each($('input[type=radio][value=6]'),function(k,v){
		var ischecked = false;
		$.each($('input[name=q'+(k+1)+']'),function(sk,sv){
			if(sv.checked){
				ischecked = true;
				return false;
			}
		});
		if(!ischecked)
			$('#unselect').append('<a href="javascript:void(0)" onclick="locate('+(k+1)+')"><div class="leftqdiv">第'+(k+1)+'题</div></a>');
	});
	
}
function submit(){
	$('.leftoutdiv').show();
	check();
	if($('#unselect').html()){
		return false;
	}
	else{
		$('#mainform').submit();
	}
}
function locate(qid){
	
	$('input[name=q'+qid+']:first').focus();
	locatestyle(qid);
}
function locatestyle(qid){
	$('input[name=q'+qid+']:first').focus();
	$('.fgngr').css('border','none');
	$('.fgngr').css('border-bottom','solid 1px #e3e3e3');
	$('.fgngr').css('padding-left','0px');
	$('#li'+qid).css('border','1px solid red');
	$('#li'+qid).css('padding-left','10px');
}
$('.radios').click(function(){
	var qid = $(this).attr('name').replace('q','');
	$('#li'+qid).css('border','none');
	$('#li'+qid).css('border-bottom','solid 1px #e3e3e3');
	$('#li'+qid).css('padding-left','0px');
	check();
})
//模拟fixed
$(parent.window).scroll(function(){
	  $('#leftoutdiv').css({
	    top : $(parent.window).scrollTop()
	  });
	});
//焦点滚动换色
$(".greigd").mouseover(function(){
	$(this).css({background:'#EDEDED'});
}).mouseout(function(){
	$(this).css({background:'#fff'});
});
//选中标识红色
$(".greigd").bind("click",function(){
	$(".greigd").css({color:'#000'});
	$(".greigd").each(function(){
		var len = $(this).find(":radio:checked").length;
		if(len>0){
			$(this).css({color:'#f00'});
		}
	});
});
</script>
