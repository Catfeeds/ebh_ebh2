<?php $this->display('troomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<style>
.ymlist{
	z-index:1000;
}
a.noreach{
	display:none;
}
</style>
<div class="lefrig" style="padding-bottom:120px;">
	<?php $this->assign('index',8);
	$this->display('troomv2/course_menu');
	$this->assign('currentindex',2);
	$this->display('troomv2/coursecount_menu');?>
	<div class="clear"></div>
	<div class="kejianzs mt20">
		<div class="nnbl">整体情况</div>
		<div class="ljzsbtfa mt25">
			<div class="ljzsbt ljzsbt1s"><span class="span1s">提问总数：<?=$askcount?>次</span></div>
			<div class="ljzsbt ljzsbt1s"><span class="span1s">回答总数：<?=$answercount?>次</span></div>
		</div>
		<div class="mt50" id="chartcontainer1" style="height:300px;margin-left:100px;"></div>
	</div>
	<div class="clear"></div>
	<div class="qzsjlb mt55" style="padding-left:40px;">
		<div class="zhqks ">
			<div class="dytjzxt">
				<div class="nnbl fl">答疑统计折线图</div>
				<div class="dytjzxtson fl">
					<div class="ayfxzcs ml40" id="monthblock">
						<a href="javascript:void(0)" class="ydlist onhover" id="bymonth">按月度</a>
						<div class="xuzjxzk fl ml20">
							<div class="xttinxzk labels"><span><?=Date('Y',SYSTIME)?></span>年</div>
							<div class="xttinxzklist ymlist" style="display:none;">
							<?php for($y = 2016;$y>=2013;$y--){?>
								<a href="javascript:void(0)" class="xttinxzklist1" value="<?=$y?>"><?=$y?></a>
							<?php }?>
							</div>
							<input class="mvalue mvaluey" type="hidden" value="<?=Date('Y',SYSTIME)?>"/>
						</div>
						<div class="xuzjxzk fl ml10">
						<?php $curmonth = Date('m',SYSTIME);?>
							<div class="xttinxzk labels" ><span><?=$curmonth?></span>月</div>
							<div class="xttinxzklist ymlist" style="display:none;">
							<?php for($m=1;$m<=12;$m++){?>
								<a href="javascript:void(0)" class="xttinxzklist1 <?=$m>$curmonth?'noreach':''?>" value="<?=$m?>"><?=$m?>月</a>
							<?php }?>
							</div>
							<input class="mvalue mvaluem" type="hidden" value="<?=Date('m',SYSTIME)?>"/>
						</div>
					</div>
					<div class="clear"></div>
					<div class="ayfxzcs fl ml40 mt15" id="yearblock">
						<a href="javascript:void(0)" class="ydlist" id="byyear">按年度</a>
						<div class="xuzjxzk fl ml20">
							<div class="xttinxzk labels"><span><?=Date('Y',SYSTIME)?></span>年</div>
							<div class="xttinxzklist ymlist" style="display:none">
								<?php for($y = 2016;$y>=2013;$y--){?>
									<a href="javascript:void(0)" class="xttinxzklist1" value="<?=$y?>"><?=$y?></a>
								<?php }?>
							</div>
							<input class="yvalue yvaluey" type="hidden" value="<?=Date('Y',SYSTIME)?>"/>
						</div>
				  </div>
				</div>
			</div>
			<div class="ml20 mt30" id="chartcontainer2" style="width:800px;height:400px;float:left"></div>
		</div>
	</div>
</body>
<script>
	var d = new Date();
	$(function(){
		var datestr = new Date(d.getFullYear(),d.getMonth()).getTime()/1000;
		getdata(datestr,'month');
	});
	$('#chartcontainer1').highcharts({
		chart: {
			type: 'bar'
		},
		series:[{
			name:'次数',
			data: [
				['提问',<?=$askcount?>],
				['回答',<?=$answercount?>]
			]
		}],
		yAxis: {
			allowDecimals:false,
			title:{
				text:null
			}
		},
		xAxis: {
			categories: ['提问','回答']
		},
		title: {
			text: null
		},
		credits:{
			enabled:false 
		},
		legend:{
			enabled:false
		}
	});
	
	$('#monthblock a').click(function(){
		if($(this).attr('class') != 'ydlist'){
			$(this).parent().next('.mvalue').val($(this).attr('value'));
			$(this).parent().prev('.labels').children('span').html($(this).attr('value'));
			$('.ydlist').removeClass('onhover');
			$(this).parents('#monthblock').children('.ydlist').addClass('onhover');
			if($('.mvaluey').val() == d.getFullYear()){
				$('.noreach').hide();
			}else{
				$('.noreach').css('display','block');
			}
		}else{
			$('.ydlist').removeClass('onhover');
			$(this).addClass('onhover');
		}
		var year = $('.mvaluey').val();
		var month = $('.mvaluem').val();
		var datestr = new Date(year,month-1).getTime()/1000;
		getdata(datestr,'month');
	});
	
	$('#yearblock a').click(function(){
		if($(this).attr('class') != 'ydlist'){
			$(this).parent().next('.yvalue').val($(this).attr('value'));
			$(this).parent().prev('.labels').children('span').html($(this).attr('value'));
			$('.ydlist').removeClass('onhover');
			$(this).parents('#yearblock').children('.ydlist').addClass('onhover');
		}else{
			$('.ydlist').removeClass('onhover');
			$(this).addClass('onhover');
		}
		var year = $('.yvaluey').val();
		var datestr = new Date(year,0).getTime()/1000;
		getdata(datestr,'year');
	});
	
	$('.labels').click(function(){
		var shows = $(this).next('.ymlist').css('display');
		$('.ymlist').hide();
		if(shows == 'none')
			$(this).next('.ymlist').show();
	});
	
	$('body').click(function(e){
		obj = e.srcElement ? e.srcElement : e.target;
		if(obj!=$('.labels')[0] && obj!=$('.labels')[1] && obj!=$('.labels')[2] && obj!=$('.labels span')[0] && obj!=$('.labels span')[1] && obj!=$('.labels span')[2] )
			$('.ymlist').hide();
			
	});
	
	
	function getdata(datestr,bywhat){
		$('.annian').css('background','#5e98f9');
		$('.annian').css('color','#fff');
		$('.anyue').css('color','#666');
		$('.anyue').css('background','#fff');
		$('.anyue').css('border','solid 1px #999')
		var year = year;
		$('#chaptersver1').hide(300);
		$('#years1 span').html(year+'年');
		$.ajax({
			'url':'/troomv2/classsubject/coursecount/ask.html?folderid=<?=$folderid?>',
			'data':{'date':datestr,'bywhat':bywhat},
			'success':function(data){
				var data = eval("("+data+")");
				
				$('#chartcontainer2').highcharts({
					title: {
						text: '',
						x: -20 //center
					},
					
					xAxis: {
						title:{
							text:bywhat=='year'?'月份':'日期'
						},
						categories: data.cats
					},
					yAxis: {
						allowDecimals:false,
						min:0,
						title: {
							text: '<br>问<br>题<br>数<br>量<br>/<br>个',
							rotation:0,
							align:'high',
							margin:20
						}
					},
					credits: {
						text: ''
					},
					tooltip: {
						valueSuffix: '次'
					},
					series: [{
						name: '提问次数',
						data: data.datas.ask
					}, {
						name: '回答次数',
						data: data.datas.answer
					}]
				});
			
			} 
		})
	}
</script>
</html>
