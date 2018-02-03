<?php $this->display('common/header')?>

<div class="footer clearfix" style="padding-bottom:30px;">
<div class="lstgjy" style="margin:10px 0 0 0">
<h2 class="jsthhwes">免费网校</h2>
<div class="rehrti" style="border-top:none;">
<ul>
<li class="rdgfkire">
<div class="regke">
<a href="http://xxs.ebh.net" target="_blank">
<img width="277px" height="100px" src="http://static.ebanhui.com/ebh/tpl/2014/images/xxs.jpg">
</a>

</div>
<div class="risdgfh">
<a href="http://xxs.ebh.net" target="_blank"><h2 class="djgfrs">小学生知识大全
</h2></a>
<p class="retgjs" style="line-height:20px">小学生知识大全云教学平台，是针对小学生强大的知识宝库，其中涵盖小学阶段各类知识：英语、安全教育、百科知识等。用有趣的动画形式表现出丰富的知识内涵，有助于小学生的智力开发和良好习惯的培养，只要你想学，这里总有你想要的。
</p>
</div>
<div class="grtjhr">
<a href="http://xxs.ebh.net" class="alanry" target="_blank">进入学习</a>
</div>
</li>

</ul>
</div>
</div>
<div class="lstgjy" style="margin:10px 0 0 0">
<h2 class="jsthhwes">试卷库</h2>
<div class="rehrti" style="border-top:none;border-right:solid 1px #e3e3e3;width:998px;">
<ul>
<li class="teger">
<a href="/epaper.html" class="fewjre">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/xiaojuan.jpg" />
<p class="etjsds"><span class="etjsds_name">小学试卷</span>试卷数：<span class="etjsds_num">113024</span></p>
</a>
</li>
<li class="teger">
<a href="/epaper.html" class="fewjre">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/chujuan.jpg" />
<p class="etjsds"><span class="etjsds_name">初中试卷</span>试卷数：<span class="etjsds_num">139583</span></p>
</a>
</li>
<li class="teger" style="border-right:none;">
<a href="/epaper.html" class="fewjre">
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/gaojuan.jpg" />
<p class="etjsds"><span class="etjsds_name">高中试卷</span>试卷数：<span class="etjsds_num">180875</span></p>
</a>
</li>
</ul>
</div>
</div>

<div class="lstgjy" style="margin:10px 0 0 0">
<h2 class="jsthhwes">资源库</h2>
<div class="kghuus">
<ul>
<?php foreach ($resourceVersionList as $value) {?>
	<li class="ewfhfd">
        <a href="/freeresource/resource-1-0-0-<?=$value['version_id']?>-0-0.html" class="gedfvs">
            <img src="http://static.ebanhui.com/<?=$value['img_url']?>" />
            <p class="regier">资源数：<span><?=$value['resource_count'] + 100000 ?></span></p>
        </a>
    </li>
<?php }?>

</ul>
</div>
</div>
<div class="lstgjy" style="margin:10px 0 0 0">
<h2 class="jsthhwes">题库</h2>
<div class="kghuus">

<?php foreach ($gradeTypeList as $key => $value) {?>
<h2 class="etkyhrt"><a href="/freeresource/question-1-0-0-<?=$key?>.html"><?=$value['gradetypename']?>试题<span>（<?=$value['count']?>）</span></a></h2>
	<ul>
    <?php foreach ($value['child'] as $grade) {?>
    	<li class="kdrug">
			<a href="/freeresource/question-1-0-0-<?=$grade['gradetype']?>-<?=$grade['gradeid']?>.html">
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/shiti<?=$grade['gradeid']?>.jpg" />
				<h2 style="text-align:center;"><?=$grade['gradename']?>试题>></h2>
			</a>
		</li>
    <?php }?>
    </ul>
<?php }?>

</div>
</div>
</div>
<?php $this->display('common/footer');?>