  <style type="text/css">
.cleft {
    display: inline;
    float: left;
    height: auto !important;
    min-height: 665px;
    padding-top: 20px;
    width: 190px;
}
.cleft .menubox {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #cecece;
    float: left;
    width: 188px;
}
	.examinationsuffix{
		background: url("http://static.ebanhui.com/ebh/tpl/default/images/icoce.png") no-repeat ;
	}
	.yunjiaoyu{
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -33px transparent;
	}	
	
	.score{
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon.png) no-repeat scroll 0 -531px transparent;
	}
	
	.gobuy {
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -183px transparent;
	}
	.stuxinx {
		height:130px;
		float:left;
		width:186px;
		background:#fff;
		border-bottom: 1px solid #cecece;
	}
	.leftu {
		float:left;
		margin:10px 10px 0 10px;
		display:inline;
	}
	.menubox .menulist .stuxinx a {
	    display: inline;
	    font-size:12px;
	    height:auto;
	    line-height:normal;
	    padding:0;
	}
	.menubox .menulist .stuxinx a:hover {
		background:none;
	}
	.menulist {
	float:left;
	width:188px;
}
	.rigpxiang {
		color:#9e9ea0;
		float:left;
		margin-top:10px;
	}
	.rigpxiang p {
		line-height:20px;
		word-wrap: break-word;
	}
	.rigpxiang p.jifenico {
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/jifenico.jpg) no-repeat left center;
		padding-left:20px;
		margin-top:10px;
		height:15px;
		line-height:15px;
	}
	.touch li{
		padding-left:25px;
	}
	.ejiants {
		float:left;
		height:25px;
		width:165px;
		margin-left:15px;
		padding-top:10px;
		display:inline;
	}
	.kewate {
		height:17px;
		float:left;
		margin-right:10px;
		padding:1px;
		width:82px;
		background:url(http://static.ebanhui.com/ebh/tpl/2014/images/tuiwaibg.jpg) no-repeat;
	}
	.kewate span {
		 float: left;
	    height: 17px;
	    line-height: 13px;
		color:#315aaa;
		text-align:center;
		background:url(http://static.ebanhui.com/ebh/tpl/2014/images/tiaolibg.png)  repeat-x;
	}
	.myhome{
		margin-top:4px;
		background: url("http://static.ebanhui.com/ebh/tpl/default/images/myhome.png") no-repeat;
	}
  </style>
  <script type="text/javascript">
	function loadReady() {
		var h = demoIframe.contents().find("body").height();
		if (h < 600) h = 600;
		demoIframe.height(h);
	}

	function refresh(current){
		$(".menulist .current").removeClass("current");
		$("#li"+current).addClass('current');
	}
	$(function(){
		refresh('<?=$seak?>');
	});
  </script>
 
	<div class="cleft">
		
	
		
		<!-- 个人中心 start-->
		<div class="menubox">
		<!-- 头像信息开始 -->
		<div class="stuxinx">
					<div class="leftu">
						<?php 
							if($user['sex'] == 1)
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
							else
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
							$face = empty($user['face']) ? $defaulturl:$user['face'];
							$face = str_replace('.jpg','_78_78.jpg',$face);
						?>
						<a href="<?= geturl('home/profile/avatar') ?>" title="修改头像" target="mainFrame"><img style="width:78px;height:78px;" src="<?=$face?>" /></a>
					</div>
					<div class="rigpxiang">
						<p style="color:#5a83a9;" title="<?=$user['username']?>"><?=shortstr(empty($user['realname'])?$user['username']:$user['realname'],12,'')?></p>
						<a href="<?= geturl('home/profile') ?>" target="mainFrame"><p>个人信息</p></a>
						<a href="<?=geturl('home/score')?>" target="mainFrame" title="积分" style="color:#9e9ea0"><p class="jifenico"><?=$user['credit']?></p></a>
					</div>
					<div class="ejiants">
						<div class="kewate">
						<span style="width:<?=$percent?>%;"><?=$percent?>%</span>
						</div>
						<a href="<?= geturl('home/profile')?>" target="mainFrame" style="color:#315aaa;">完善资料 ></a>
					</div>
				</div>
					<!-- 头像信息结束 -->
			<ul class="menulist">
				<li class="liprofile" id="liprofile">
					<a target="mainFrame" onclick="refresh('profile')" href="/home/profile.html"><i class="ui_ico myprofile"></i>个人信息</a>
				</li>
				<li class="liinfocenter" id="liinfocenter" style="display:none">
					<a target="mainFrame" onclick="refresh('infocenter')" href="/home/infocenter.html"><i class="ui_ico myinfocenter"></i>学习空间</a>
				</li>
				<!--<li class="lilargedb" id="lilargedb">
					<a target="mainFrame" onclick="refresh('largedb')" href="/home/largedb.html"><i class="ui_ico mylargedb"></i>历史数据</a>
				</li>-->
				<li class="liscore" id="liscore">
					<a target="mainFrame" onclick="refresh('score')" href="/home/score.html"><i class="ui_ico myscore"></i>积分计划</a>
				</li>
				<li class="lischool" id="lischool">
					<a target="mainFrame" onclick="refresh('school')" href="/home/school.html"><i class="ui_ico myschool"></i>我的网校
					<?php if($roomcount>0){ ?><span><?= $roomcount;?></span><?php } ?></a>
				</li>										
				<li class="lihome" id="lihome">
                    <a target="_blank"  href="http://sns.ebh.net"><i class="ui_ico myhome"></i>我的空间</a>
                </li>
				
             </ul>
		</div>
		<!-- 个人中心 end -->
    
        <!-- 我的空间 start-->
      <!--  <div class="menubox" style="margin-top:10px;">
            <ul class="menulist">
                <li class="lihome" id="lihome">
                    <a target="_blank"  href="http://sns.ebh.net"><i class="ui_ico myhome"></i>我的空间</a>
                </li>
             </ul>
        </div>--/>
         <!-- 我的空间 end-->
		</div>