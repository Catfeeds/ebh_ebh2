<div class="foot">
	<p class="botnav">
	<?php
		$catlib = Ebh::app()->lib('Category');
		if(empty($room))
		$room = Ebh::app()->room->getcurroom();
		$cats = $catlib->getCateByPos(2);
	?>
		
		<?php
		foreach($cats as $key=>$value){
			if($key!=0)
				echo '|';
		?>
		  	<a href="<?=$value['caturl']?>" title="<?=$value['name']?>" target="_blank"><?=$value['name']?></a>
		<?php }?>
		</p>
		<P style="color: #666666"><a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; <?= (date('Y')-1).'-'.date('Y')?> ebh.net All Rights Reserved </P>
</div>
<?php
debug_info();
?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu')?>
<!-- 统计代码结束 -->
</body>
</html>
