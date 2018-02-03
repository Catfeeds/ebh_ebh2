<?php $this->display('common/header');?>
<style type="text/css">
html {background:#f3f3f5;}
</style>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/eq/lrtlk.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<script src="http://static.ebanhui.com/ebh/js/jquery/jquery_002.js" type="text/javascript"></script>

<div class="eradle">
<div class="buycom">
    <ul class="buypic">
        <li><a href="http://soft.ebanhui.com/eq.exe" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtop10322.jpg" /></a></li>
        <li><a href="http://soft.ebanhui.com/eq.exe" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/adtop20322.jpg" /></a></li>
    </ul>
    <a class="prev" href="javascript:void(0)"></a>
    <a class="next" href="javascript:void(0)"></a>
    <div class="num">
    	<ul></ul>
    </div>
</div>
</div>
<div class="fomist">
<div class="iwrntte">
<div class="neiland">
<ul>
<li class="jiaoone">
<h2>在线教与学</h2>
<p>基于专业的在线教学系统，采用云部署技术，将e板会云教育平台的学习和教学的信息同步部署到每一个通讯终端。每一个eq客户端，都是一个在线的课堂，直接零距离对话，零距离学习。</p>
</li>
<li class="jiaotwo">
<h2>开放式沟通交流</h2>
<p>开放式沟通与交流平台，即时通讯、好友、分组、传文件、直播、语音等诸多应用。同时，可建立和加入教学圈，跨校跨区域进行教学交流。</p>
</li>
<li class="jiaother">
<h2>高效的教学办公系统</h2>
<p>采用P2P技术，按学校，企业或机构进行人员匹配。完成内部高效的通讯与教学，办公协同。</p>
</li>
<li class="jiaofour">
<h2>强大的硬件和技术支持</h2>
<p>遍布多个城市超级强大的服务器系统，各项的顶尖的压缩，下载和上行技术。可同步接收和处理所有终端所有功能的信息交流和互通。</p>
</li>
</ul>
</div>
<div class="fontert">
<ul>
<li class="sizwen1">
<h2>老师同学点对点沟通</h2>
<p>学生和老师之间，学生和学生之间边学习边沟通，答疑解惑。</p>
</li>
<li class="sizwen2">
<h2>云端学习</h2>
<p>直通e板会云教学云端，让学习和交流紧密结合。</p>
</li>
<li class="sizwen3">
<h2>直播课堂</h2>
<p>采用P2P无服务器通讯技术，传输更快捷，速度更流畅。</p>
</li>
<li class="sizwen4">
<h2>好友及分组</h2>
<p>与e板会云教育平台账号同步，可添加平台上的好友并分组管理，沟通无界。</p>
</li>
<li class="sizwen5">
<h2>手写交流</h2>
<p>支持e板会手绘系统，自由书写交流，各种符号图形，随手绘出。</p>
</li>
<li class="sizwen6">
<h2>语音通讯</h2>
<p>自主知识产权的语音压缩与传输技术，音质好，速度快。</p>
</li>
<li class="sizwen7">
<h2>学校内部通讯</h2>
<p>学校内部沟通协调一体化，多项教务功能与平台同步。</p>
</li>
<li class="sizwen8">
<h2>教学圈</h2>
<p>建立和加入自己的教学圈，实现老师跨学校跨区域的教学交流。</p>
</li>
<li class="sizwen9">
<h2>远程协助</h2>
<p>疑难杂症，远程协助，家庭教师无处不在。</p>
</li>
<li class="sizwen10">
<h2>录制课件</h2>
<p>直连e板会课件制作软件，与老师同学交流时灵感闪现，迅速进入制作界面。</p>
</li>
<li class="sizwen11">
<h2>在线公式编辑器</h2>
<p>完美的公式编辑器，所有数学符号，点点鼠标轻松输入，学习交流无障碍。</p>
</li>
<li class="sizwen12">
<h2>文件传输</h2>
<p>大文件发送，点对点文件快速传输，便捷安全。</p>
</li>
<li class="sizwen13">
<h2>屏幕截图</h2>
<p>轻松捕捉和截图桌面图像，让交流更给力。</p>
</li>
<li class="sizwen14">
<h2>屏幕分享</h2>
<p>采用高压缩屏幕分享技术，分享屏幕更加快速便捷。</p>
</li>
<li class="sizwen15">
<h2>跨平台技术</h2>
<p>提供IOS，安卓等移动平台APP客户端，畅享移动商务。</p>
</li>
</ul>
</div>
</div>
</div>


<script>
/*鼠标移过，左右按钮显示*/
$(".buycom").hover(function(){
$(this).find(".prev,.next").fadeTo("show",0.2);
},function(){
$(this).find(".prev,.next").hide();
})
/*鼠标移过某个按钮 高亮显示*/
$(".prev,.next").hover(function(){
$(this).fadeTo("show",0.7);
},function(){
$(this).fadeTo("show",0.2);
})
$(".buycom").slide({ titCell:".num ul" , mainCell:".buypic" , effect:"fold", autoPlay:true, delayTime:1200 , autoPage:true });
</script>
<?$this->display('common/footer');?>