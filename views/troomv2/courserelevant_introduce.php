<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<div class="lefrig">
<?php $this->display('troomv2/course_menu');?>
<div class="coursecat">
	<div class="coursecatson">
    	<div class="lvjies">
            <h1 style="position:relative"><?=$folder['foldername']?></h1>
            <p class="topjie"><?=$folder['summary']?></p>
            
			<?=$folder['detail']?>
		</div>
        <div class="courselists">
        	<?php if(!empty($folder['introduce'])){ foreach($folder['introduce'] as $k=>$introduce){?>
            <div class="kecjs  mt25">
            	<h2><?=$introduce['title']?></h2>
                <p><?=$introduce['content']?></p>
            </div>
			<?php }}?>
        </div>
    </div>
</div>
</div>
</div>
<script>
var searchtext = "请输入搜索关键字";
$(function(){
	// initsearch("title",searchtext);
	$('.diles').hide();
});
function initsearch(id,value) {
   if($("#"+id).val() == "") {
       $("#"+id).val(value);
       $("#"+id).css("color","#A5A5A5");
   }
   if($("#"+id).val() == value) {
       $("#"+id).css("color","#A5A5A5");
   }
   $("#"+id).click(function(){
       if($("#"+id).val() == value) {
           $("#"+id).val("");
           $("#"+id).css("color","#323232");
       }
   });
   $("#"+id).blur(function(){
       if($("#"+id).val() == "") {
           $("#"+id).val(value);
           $("#"+id).css("color","#A5A5A5");
       }
   });
}
</script>
</body>
</html>
