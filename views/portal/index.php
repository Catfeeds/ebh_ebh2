<?php $this->display('common/header');?>
<!--广告!-->
<style type="text/css">
	.kdutg {
			left:20px;
			width:500px;
	}
	.kdutg p {
		width: 500px;
		float: left;
	}
	.fldty span i {
	background:url(http://static.ebanhui.com/portal/images/ebhbei.png) no-repeat scroll 0 0;
    display: inline-block;
    height: 20px;
    margin-right: 6px;
    margin-top: -4px;
    vertical-align: middle;
    width: 20px;
}
#kanjia{
	position:fixed;
	left:0;
	top:38%; 
	margin-top:-90px;
	z-index:1;
	font-size:16px;
	color:#333;
}	
</style>

<?php
	$this->assign('data',array('imgcount'=>5,'imgprestr'=>'http://static.ebanhui.com/portal/images/banner','imgafterstr'=>'.jpg?v=20160809001'));
	$this->display('widget/slide_widget');
?>
<!--砍价-->
<div style="" id="kanjia">
	<a href="http://www.ebh.net/news1/9636.html" onfocus="this.blur();" target="_blank"><img src="http://static.ebanhui.com/portal/images/wxkjj.png?v=20161019001" /></a>
	<a onclick="$('#kanjia').hide()" href="javascript:void(0)" style="position:absolute;bottom:7px;left:210px;"><img src="http://static.ebanhui.com/portal/images/close.png" /></a>
</div>
<!--网校特点!-->
<div class="trtcen">
	<div class="gtutsr">
		<div class="jertre bsrtd">
			<span class="jshrre" id="room" data-num="0">0</span>网校
			<p class="huistd">总有一家适合你</p>
		</div>
		<div class="jertre steers">
			<span class="jshrre"  id="teacher" data-num="0">0</span>教师
			<p class="huistd">在线随你挑选</p>
		</div>
		<div class="jertre usets">
			<span class="jshrre"  id="user" data-num="0">0</span>用户
			<p class="huistd">找志同道合一起学习的人</p>
		</div>
		<div class="jertre stzsrre">
			<span class="jshrre"  id="resource" data-num="0">0</span>资源
			<p class="huistd">帮助你成为更强的人</p>
		</div>
	</div>
</div>
<div class="rdfgket">
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese01.jpg?v=20160405001" />
<p class="listern">
独立品牌域名，模块定制化，人人创建个性化网络学校。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese02.jpg?v=20160405001" />
<p class="listern">
秒播引擎、微课产生力、万人直播、各类转码、支持所有课件文档、大并发处理、上百著作权及专利。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese03.jpg?v=20160405001" />
<p class="listern">
独特的云计算中心、多路主干宽带、CDN、数据加密多网多备存储、海量数据中心。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese04.jpg?v=20160405001" />
<p class="listern">
支持windows、Mac机、Android、iPhone、iPad、微信、钉钉、电视等在线学习。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese05.jpg?v=20160405001" />
<p class="listern">
打通网校与网校间数据共享、完善API的对外接入，可兼容各类第三方管理系统。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese06.jpg?v=20160405001" />
<p class="listern">
适用于各类学校、教育局、企业、政府开展教学、培训、补课、翻转课堂、素质教育、电子书包等多场景。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese07.jpg?v=20160405001" />
<p class="listern">
在线教学系统、支付系统、结算系统、营销系统、管理系统、大数据分析系统、客服系统。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese08.jpg?v=20160405001" />
<p class="listern">
录播&直播简易强大、作业&考试主客观题生产便捷、评论评价、游戏积分、互动答疑、海量内容、大数据分析、多角色参与等。
</p>
</div>
<div class="lstyd">
<img src="http://static.ebanhui.com/portal/images/ebh_tese09.jpg?v=20160405001" />
<p class="listern">
管理平台、教学平台、互动平台、云盘、商城、社区、发布、各类应用、大数据分析系统。
</p>
</div>
</div>
<!--入驻网校!-->
<div class="rushen" style="height:175px;">
<div class="idrtgfd">
<a href="/createroom.html" target="_blank" class="astdfht">入驻网校</a>
<div class="dygrt" style="position:relative;">
			<div class="hd" style="position:absolute;right:0;">
			<a style="height:175px;cursor:pointer;" class="next"><img style="margin-top:80px;" src="http://static.ebanhui.com/portal/images/ebh_rightico.jpg" /></a>
			</div>
	<div class="bd">
		<ul>
		<?php if(!empty($roomlists)){?>
			<?php foreach ($roomlists as $room) {?>
				<li>
					<a title="<?=$room['subject']?>" href="<?=$room['linkurl']?>" target="_blank"><img width="97" height="102" src="<?=$room['thumb']?>" /></a>
				</li>
			<?php }?>
		<?php }?>
		</ul>
	</div>
</div>
</div>
</div>
<div style="clear:both;"></div>
<div class="ryrued">
	<ul>
		<li class="lsrret">浙江省杭州市西湖区德力西大厦1号楼802F</li>
		<li class="ewtser">+86（571）88252183/ 87757303</li>
		<li class="reyrde">
			<a target="_blank" href="<?=geturl('about')?>">关于</a><b class="kshteb">
			<a target="_blank" href="<?=geturl('conour')?>">业务联系</a><b class="kshteb">
		</li>
	</ul>
	<img class="etfhtw" src="http://static.ebanhui.com/portal/images/footico4.jpg?v=20160405001" />
</div>
<!--尾部!-->
<div style="clear:both;"></div>
<div class="fldty">
<div style="text-align:center">
<span style="color:#999"><i></i>浙公网安备 33010602003467号</span>
  <a href="http://www.miibeian.gov.cn/" target="_blank" style="color:#999">浙B2-20160787</a>&nbsp;&nbsp;<span style="color:#999">Copyright &copy; 2011-<?=date('Y')?>  ebh.net All Rights Reserved </span><br>
</div>
</div>
<script>
	$("div.dygrt").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:false,scroll:6,vis:6,delayTime:1000});
	(function timerslide(count){
		var hasrender = 0;
		if(count <= 3){
			var nexttime = 5000;
		}else if(count <= 9){
			var nexttime = 10000;
		}else if(count <= 27){
			var nexttime = 20000;
		}else if(count <= 54){
			var nexttime = 40000;
		}else if(count <= 108){
			var nexttime = 80000;
		}else{
			return;
		}
		$.ajax({
			url:"<?=geturl('xnum')?>",
			type:'post',
			dataType:'json',
			success:function(nums){
				$.each(nums,function(k,o){

					$("#" + k).attr('data-num') == '0' && (function(num){
						var task,
							nextnum = 0,
							addnum,
							$dom;
						$dom = $("#" + k);
						
						$dom.attr('data-num',o);
						addnum = parseInt(new Array(Math.max((""+num).length -1  ,2)).join(1) * ( 10*Math.random() + 15) );
						task = setInterval(function(){
							nextnum += addnum;
							nextnum = nextnum < num ? nextnum : (function(){
								clearInterval(task);
								hasrender += 1;
								if(hasrender == 4){
									setTimeout(function(){
										timerslide(++count);
									},nexttime);
								}
								return num;
							})();
							$dom.html(nextnum);
						},60);
						return true;
					})(o) || (function(num){
						$("#"+k).html(num);
					})(o);
				});
			}
		});
	})(1);
</script>
<?php debug_info();?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
<!-- 统计代码结束 -->
</body>
</html>
