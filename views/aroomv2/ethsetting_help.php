<?php $this->display('aroomv2/room_header');?>
<div class="wxtszbz" style="margin-top:10px">
	<div class="title1s">
    	微校通使用帮助
        <a href="http://www.ebh.net/eth.html" target="_blank" class="smswxt">什么是微校通？</a>
    </div>
    <p class="ps1">这份文档能帮助您解决微信公众平台上的相关配置问题，使您的服务号能使用微校通功能。按照下面的步骤配置好您自己的微信服务号，并将相关数据通过
"提交配置"页面传给我们，我们的工程师就能在后台帮您的服务号开通微校通功能了。</p>
	<div class="firstbu">
    	<p class="span3s"><span class="span2s">第一步：</span>准备一个<span class="swxgzp">微信公众平台服务号</span>。</p>
        <p class="span3s p1s">如果您已有微信服务号，请阅读下一步；如果您还没有微信服务号，可以参考这篇<a href="http://jingyan.baidu.com/article/e9fb46e190a51a7521f766d7.html" class="zcjc" target="_blank">注册教程</a>完成注册。</p>
        <p class="span3s"><span class="span2s">第二步：</span>打开<a href="https://mp.weixin.qq.com/" target="_blank" class="zcjc">微信公众号平台</a>网页，登录您的微信服务号。</p>
        <a name="appid"></a>
        <p class="span3s"><span class="span2s">第三步：</span>点击左侧工具栏的 "基本配置"，再点击右侧 "修改配置"。</p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp1.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第四步：</span>
            <span>1、在URL栏中输入：<b style="padding-left:18px;"></b>http://eth.ebh.net/server.html</span>
            <span class="second1s">2、在Token栏中输入：<b style="padding-left:5px;"></b>ebanhui_wxt</span>
            <span class="second1s">3、点击"随机生成"按钮。</span>
            <span class="second1s">4、提交。</span>
            <span class="second1s" style="color:#ff2330;">请注意：务必保护好您的 URL 和 Token 信息，如果需要截图，请把相关信息抹掉。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp2.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第五步：</span>
            <span>提交成功后，页面自动跳至如下页面。</span>
            <span class="second1s">点击"启用"按钮即可。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp3.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第六步：</span>
            <span>左侧点击"接口权限"，右侧选择"网页账号"，点击"修改"。</span>
            <span class="second1s">在弹出框中输入：eth.ebh.net ，点击"确定"即可。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp4.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第七步：</span>
            <span>先点击左侧 "公众号设置"，右侧选择"功能设置"。</span>
            <span class="second1s">分别在"业务域名"和"JS接口安全域名"栏点击设置。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp5.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第八步：</span>
            <span>在弹框中，只需在"域名1"中输入：eth.ebh.net， 点击保存即可。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp6.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第九步：</span>
            <span>左侧点击"添加功能插件"，右侧选择"模板消息"，点击"开通"。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp7.jpg" class="mt5" /></div>
        <p class="span3s">
        	<span class="span2s">第十步：</span>
            <span>左侧点击刚刚添加的"模板消息"，右侧选择"模板库"，在搜索框内输入"学校通知"，点击"详情"进入开通即可。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp8.jpg" class="mt5" /></div>
        <a name="tplid"></a>
        <p class="span3s">
        	<span class="span2s">第十一步：</span>
            <span>模板开通成功后，在"我的模板"中，可查看模板ID。</span>
        </p>
        <div><img src="http://static.ebanhui.com/ebh/tpl/aroomv2/images/jctp9.jpg" class="mt5" /></div>
        <div style="height:100px;"></div>
        <p  class="ps1" style="text-align:center;">如果您已完成上述所有步骤，请点击下面的按钮。</p>
        <a href="javascript:;" onclick="gotosettting();" class="tjbtn tjbtn1s">提交配置</a>
    </div>
</div>
<script>
function setCookie(name, value) {
    var exdate = new Date();
	exdate.setTime(exdate.getTime() + (arguments.length>2?arguments[2]:7)*24*60*60*1000);   
    // exdate.setDate(exdate.getDate()+(arguments.length>2?arguments[2]:7));
    var cookie = name+"="+encodeURIComponent(value)+"; expires="+exdate.toGMTString();
    cookie += ((arguments.length>3?("; path="+arguments[3]):"") + (arguments.length>4?("; domain="+arguments[4]):""));
    document.cookie = cookie;
}

function gotosettting() {
	setCookie('ebh_refer','/aroomv2/ethsetting/setting.html',10,'/','.<?=$this->uri->curdomain?>');
	top.location='/aroomv2.html';
}
</script>
<?php $this->display('troom/room_footer')?>
