<?php $this->display('myroom/page_header'); ?>
			
			<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/survey') ?>" >调查问卷</a> 
</div>
<div class="lefrig">

<div class="myxuan">
		<ul>
		<li class="newkec">
			<a href="<?= geturl('myroom/survey/undolist') ?>">
				<span id="newcoursespan">填问卷</span>
			</a>
		</li>
		
		<li class="mytiku">
			<a href="<?= geturl('myroom/survey') ?>">
				<span id="mycoursespan"></span>
			</a>
		</li>
		
		<li class="comtiku">
			<a href="<?= geturl('myroom/survey') ?>">
				<span id="allcoursespan"></span>
			</a>
		</li>
		
		
		</ul>
	</div>

</div>


	<script type="text/javascript">
	
	</script>

<?php $this->display('myroom/page_footer'); ?>