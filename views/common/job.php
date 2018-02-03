<?php
$this->display('common/siteinfo_header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/job.js"></script>
<div class="pageright">
	    <div class="pagetit"><img src="http://static.ebanhui.com/ebh/tpl/default/images/job.png"  /></div>
			<div class="job">
				
				<?= $itemsite[0]['message']?>
			</div>
	  </div>
	</div>
	<div class="pagebot"></div>
</div>
<?php
$this->display('common/siteinfo_footer');
?>