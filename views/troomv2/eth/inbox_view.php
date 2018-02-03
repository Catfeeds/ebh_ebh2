<?php $this->display('troomv2/page_header'); ?>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">收件箱（查看）</span></a></li>
			</ul>
		</div>
	</div>
    <div class="sjxhf">
    	<div class="sjrfa">
        	<p class="sjrs">发件人：<?=$inbox['send_user']?></p>
            <p class="sjrs mt10"><?=$inbox['message']?></p>
        </div>
        <?php if (!empty($inbox['isreply']) && !empty($replylist)) {
        	foreach ($replylist as $reply) {
        ?>
        <p class="sjrs mt25 sjrs1s">回复：<?=$reply['comment']?></p>
        <?php } }?>
        <div class="anniubtn anniubtns">
        	<a href="<?=geturl($this->input->get('rurl'))?>" class="fsanbtn">返&nbsp;回</a>
        </div>
    </div>
</div>
</body>
</html>