<?php $this->display('aroomv2/page_header'); ?>
<div class="ter_tit">
当前位置 > <a href="/aroomv2/information/datainfor.html">资讯管理</a> > 资讯展示</div>
<div class="dtzhix">

<div style="margin: 15px auto;width: 788px;">
<div class="rigxiang" style="background:#fff; width:758px;height: auto;padding: 25px 15px;">
	<div class="zixun">

		<div class="juxiangq" style="margin-top:0; width:760px;">
		
		<h2 class="hsiz" style="font-size: 24px;height: 35px;line-height: 35px;margin-bottom: 20px; margin-top: 20px;text-align: center;"><?= $information['subject']?></h2>
		<p style="color:#666;height:28px;line-height:28px;"><?= date('Y-m-d H:i:s',$information['dateline'])?></p>
		<p style="line-height:1.8;"><?= stripslashes($information['message'])?></p>

		</div>
	</div>
</div>
</div>
<div class="fltkuang">
</div>
</div>

</body>
</html>