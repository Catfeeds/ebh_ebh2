<?php $this->display('common/header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/eq/lrtlk.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebhportal.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript">
<!--
	var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
//-->
</script>
<style type="text/css">
#footer{
	line-height: 24px;
	text-align: center;
}
</style>

<div class="appxia">
</div>
 <!--学习互动客户端下载-->
    <div id="center" style="height:830px;">
    	<div id="center_top">
        	<ul class="stype-list">
            	<li class="selected fl" id="xuexi" onclick="show('xuexi')"><a href="javascript:;">学习互动客户端</a></li>    
                <li class="fl" id="qita" onclick="show('qita')"><a href="javascript:;">其他应用客户端</a></li>
            </ul>
        </div>
        <div class="clear"></div>
        <div id="center_bottom">
        	<div class="newwei">
            	<h2 class="stgdt">Android、iPhone、iPad 通用</h2>
            	<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tongyong.jpg" />
                <p class="dktgfd">【或点击“云教学平台”下载】</p>
                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/saoxia.jpg" />
            </div>
            <div class="newwei">
            	<h2 class="stgdt">移动网页版</h2>
            	<img src="http://static.ebanhui.com/ebh/tpl/2014/images/yidongye.jpg" />
                <p class="dktgfd">【网址：http://wap.ebh.net】</p>
                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/saoxia.jpg" />
            </div>
            <div class="newwei">
            	<h2 class="stgdt">公众微信号</h2>
            	<img src="http://static.ebanhui.com/ebh/tpl/2014/images/weixin.jpg" />
                <p class="dktgfd">【关注微信公众号：e板会】</p>
                <img src="http://static.ebanhui.com/ebh/tpl/2014/images/saoxia.jpg" />
            </div>
			<p style="float:left;margin-top:10px;font-size:14px;width:960px;text-indent :95px;display:inline;">或点击下面链接下载</p>
			<ul style="margin-left:86px;float:left;display:inline;">
			<li class="syitem">
				<span class="sybd">
					<a class="sybtn" target="_blank" href="https://itunes.apple.com/cn/app/id1234127044?mt=8">
						<em class="iphonelogo"></em>
					<a class="sybtn" target="_blank" href="https://itunes.apple.com/cn/app/id1247086974?mt=8">
						<em class="maclogo"></em>
					</a>
					<a class="syssbtn" target="_blank" href="http://soft.ebh.net/ebanhuipad.apk">
						<em class="andrologo"></em>
					</a>
					<a class="syssbtn" target="_blank" href="http://soft.ebh.net/ebh_tv.apk">
						<em class="television"></em>
					</a>
				</span>
			</li>
			</ul>
        </div>
		<!--其他-->
		 <div id="center_bottom_other" style="display:none;">
				<div class="newwei">
					<h2 class="stgdt">小学生知识大全</h2>
					<img src="http://static.ebanhui.com/ebh/tpl/2014/images/xuesheng.jpg" />
					<p class="dktgfd">【扫码上方二维码即可下载安装】</p>
					<img src="http://static.ebanhui.com/ebh/tpl/2014/images/saoxia.jpg" />
				</div>
				<div class="newwei">
					<h2 class="stgdt">点化网校电视版</h2>
					<img src="http://static.ebanhui.com/ebh/tpl/2014/images/tv.jpg" />
					<p class="dktgfd">【扫码上方二维码即可下载安装】</p>
					<img src="http://static.ebanhui.com/ebh/tpl/2014/images/saoxia.jpg" />
				</div>



							<p style="float:left;margin-top:10px;font-size:14px;width:960px;text-indent:195px;display:inline;"><span style="float:left;text-indent: 95px;">或点击下面链接下载</span>或点击下面链接下载</p>
			<ul style="margin-left:86px;float:left;display:inline;">
			<li class="syitem">
				<span class="sybd">
					<a class="syssbtn" target="_blank" href="http://soft.ebh.net/xxs.apk">
					<em class="andrologo"></em>
					</a>
				</span>
			</li>
			<li class="syitem" style="margin-left:170px;">
				<span class="sybd">
					<a class="syssbtn" target="_blank" href="http://soft.ebh.net/dh_tv.apk">
					<em class="andrologo"></em>
					</a>
				</span>
			</li>
			</ul>
        </div>
    </div>
    <!--底部-->
<?php $this->display('common/footer')?>
<script type="text/javascript">
<!--
	function show(id) {
	  var showxuexi = '#xuexi';
      var hidqita = '#qita';
      var xuexidiv = '#center_bottom';
      var qitadiv = '#center_bottom_other';
      if (id == "xuexi") {
         $('#qita').removeClass('selected fl');
		 $('#qita').addClass('fl');
         $('#xuexi').addClass('selected fl');
		 $('#center_bottom_other').hide();
		 $('#center_bottom').show();
         }
      if (id == "qita") {
		 $('#xuexi').removeClass('selected fl');
		 $('#xuexi').addClass('fl');
         $('#qita').addClass('selected fl');
		 $('#center_bottom').hide();
		 $('#center_bottom_other').show();
         }
  }
//-->
</script>