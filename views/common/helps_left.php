<?php $showindex = 0; ?>
<div class="lefmuen">
<div><img src="http://static.ebanhui.com/ebh/tpl/2012/images/lefmenu11023.jpg" /></div>
<?php 
  $itemlib = EBH::app()->lib('Help');
  $catlist = $itemlib->getItems();
?>
 <?php foreach($catlist as $key=>$val){ ?>
		 <div id="CollapsiblePanel<? echo ($key+1)?>" class="CollapsiblePanel">
			 <div class="CollapsiblePanelTab" tabindex="0"><?= $val['catmodel']['name']?></div>  	
				<div class="CollapsiblePanelContent" style="display: none;">	 
				<ul>
					<?php foreach($val['category'] as $keyn=>$valn){ ?>
						 <li>
						 <a href="/faq-1-0-0-<?=$valn['catid']?>.html"><?= $valn['name']?></a>
						 </li>
					<?php }?>
				</ul>
				</div>
			</div>
<?php }?>

<?php 
  $catlist2 = $itemlib->getItemscenter();
?>
<div><img src="http://static.ebanhui.com/ebh/tpl/2012/images/lefmenu21023.jpg" /></div>
  <?php foreach($catlist2 as $key=>$val){ ?>
		 <div id="CollapsiblePanel<? echo ($key+1)?>" class="CollapsiblePanel">
			 <div class="CollapsiblePanelTab" tabindex="0"><?= $val['catmodel']['name']?></div>  	
				<div class="CollapsiblePanelContent" style="display: none;">	 
				<ul>
					<?php foreach($val['category'] as $keyn=>$valn){ ?>
						 <li>
						 <a href="/faq-1-0-0-<?=$valn['catid']?>.html"><?= $valn['name']?></a>
						 </li>
					<?php }?>
				</ul>
				</div>
			</div>
<?php }?>
</div>

<script type="text/javascript">
<!--
	$(function(){
		// for(var i=0;i<11;i++){
			// $("#CollapsiblePanel"+(i+1)+" .CollapsiblePanelTab").click(function(){
			$(".CollapsiblePanelTab").click(function(){
				var showdom = $(this).next('.CollapsiblePanelContent');
				if(showdom.is(':hidden')){
					showdom.slideDown('slow');
					$(this).parent().addClass('CollapsiblePanelOpen');
				}else{
					showdom.slideUp('slow');
					$(this).parent().removeClass('CollapsiblePanelOpen');
				}
			});
			// $("#CollapsiblePanel"+(i+1)+" .CollapsiblePanelContent").hide();
			$(this).parent('.CollapsiblePanelTab').find('.CollapsiblePanelContent').hide();
		// }

		(function(){
			var showdom = $("#CollapsiblePanel{$showindex} .CollapsiblePanelTab").next('.CollapsiblePanelContent');
			showdom.show();
			$("#CollapsiblePanel{$showindex} .CollapsiblePanelTab").parent().addClass('CollapsiblePanelOpen');
		})();
	});
//-->
</script>