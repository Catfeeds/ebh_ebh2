<?php $this->display('common/site_header');?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css" rel="stylesheet" type="text/css" />
<style>
.main .slst .suc{border:none;}
.main .slst .suc .dengl {background: url(http://static.ebanhui.com/ebh/tpl/2016/images/anniu1.png) no-repeat;height: 30px;width: 110px;}
.hqyhm{color:#ff4444;font-size:24px;font-family: Microsoft Yahei;text-align: center;}
.hqyhm a{color:#999;font-size:14px; padding-left:5px;}
.hqyhm a:hover{color:#17a8f7;}
.fxz{width:405px; margin:0 auto;}
.fxz .title{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/fxz.png) no-repeat; height:12px; margin-top:30px;}
.fxlist{width:235px; margin:0 auto;}
.fxlist ul li{float:left;display:inline;}
.fxlist .social-share a{height: 37px;width: 37px;display: block;float:left;}
.fxlist a.icon-qzone{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktkj.png) no-repeat;}
.fxlist a.icon-qzone:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktkjhover.png) no-repeat;}
.fxlist a.icon-wechat{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwx.png) no-repeat;margin-left:60px;}
.fxlist a.icon-wechat:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwxhover.png) no-repeat;}
.fxlist a.icon-weibo{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwb.png) no-repeat;margin-left:60px;}
.fxlist a.icon-weibo:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwbhover.png) no-repeat;}
p.tishis{color:#626262; line-height:24px; padding-top:20px; padding-left:72px;}
p.tishis a{color:#17a8f7;}
.main .slst .suc{height:145px;}
.help{width: auto;border-right: none;height: auto;float: none;}
</style>
<!-- 引入分享代码 -->
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>

<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat-y scroll 0 0; height:auto;">
<div class="main" style="height:500px;overflow:hidden;">
<div class="aed"><p>欢迎开通【网校公共课程运营】服务</p></div>
<div class="slst"><p style="font-weight: bold;padding-top: 15px;padding-left: 35px; color:#666666">帐号开通流程： </p>
    <label>
    <input class="tianxie2" style="cursor:pointer" type="submit" name="tianxie" value="1、填写个人资料" />
    <img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />    </label>
    <label>
    <input class="xuanze" style="cursor:pointer" type="submit" name="xuanze" value="2、选择开通方式" />
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />
    </label>
    <label>
    <input class="kaitong2" style="cursor:pointer" type="submit" name="kaitong" value="3、开通成功" />
    </label>
	<div class="suc"><p style="padding-top:50px;">您好 <?= $user['username'] ?> ，您已成功开通网校公共课程运营服务。</p>
	<p style="line-height:3">现在您可以立即进入<label>
	<input style="cursor:pointer;margin:0;" type="button" onclick="window.location.href='<?='/aroomv2.html'?>'" name="dengl" class="dengl"  value="管理平台"/>
	</label>进行选课。</p>
	</div>
</div>
</div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2012/images/doot5111.jpg">
</div>
</div>
<div style="clear:both;"></div>
<?php $this->display('common/site_footer'); ?>