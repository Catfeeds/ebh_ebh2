<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<div class="lefrig">
<div class="work_mes">
	<ul>
		<li class="workcurrent">
            <a href="">内容浏览</a>
        </li>
        <li class="">
            <a href="/troomv2/weixin/list_msg.html">发信历史</a>
        </li>
		<li>
		<a href="/troomv2/weixin/parent_send.html">家长回复</a>
		</li>
		<li class="">
		<a href="/troomv2/weixin/class_send_msg.html">班级群发</a>
		</li>
	</ul>
</div>
<div style="clear:both;"></div>
<div class="waiyry" style="float:none;">
<div class="chouad" style="height:auto;width:879px;">
<span class="shyten">收件人：</span>
<div class="ewater" style="width:800px;">
<ul id="wrap2">
<?php foreach ($msgInfo['classnames'] as $classname) {?>
  <li class="lantewu"><?=$classname?></li>
<?php }?>
<?php foreach ($msgInfo['usernames'] as $username) {?>
  <li class="lvtewu"><?=$username?></li>
<?php }?>
</ul>
</div>
</div>
<div style="width:900px; margin:0 auto;float:left;"><textarea style="width:879px;" class="txttiantl" name="summary" disabled=true><?=$msgInfo['content']?></textarea></div>
<div class="wtkkr">
<a href="javascript:window.history.go(-1)" class="tjewkc">返 回</a>
</div>
</div>
</div>
</div>
<?php $this->display('troomv2/page_footer');?>