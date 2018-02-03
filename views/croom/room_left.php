  <script type="text/javascript">

	function refresh(current){
		$(".menulist .current").removeClass("current");
		$("#li"+current).addClass('current');
	}

	$(function(){
		refresh('creport');
		$(".extendlist li").click(function(){$(".menulist .current").removeClass("current");$(this).addClass("current");});
	});
	</script>
<div class="cleft">
	<div class="leku"></div>
	<div class="menubox">
		<ul class="menulist">
			<li id="licode">
				<a href="<?=geturl('teacher/setting/rprofile')?>"  target="mainFrame" onclick="refresh('code');" ><i class="ui_ico codesuffix"></i>个人信息</a>	
			</li>
			<li id="licreport"><a href="<?=geturl('croom/creport')?>" target="mainFrame" onclick="refresh('creport');"><i class="ui_ico fcreportsuffix"></i>网校信息统计</a></li>
			<li id="lidreport"><a href="<?=geturl('croom/dreport')?>" target="mainFrame" onclick="refresh('dreport');"><i class="ui_ico tcreportsuffix"></i>网校数据查看</a></li>
			<li><a href="<?=geturl('logout')?>"><i class="ui_ico cereportsuffix"></i>退出</a></li>
		</ul>
	</div>
</div>
