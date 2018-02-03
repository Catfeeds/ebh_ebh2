<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<style>

</style>

<body>
<div class="lsitit" >
<div class="lefstr" style="padding-bottom:20px;background:white; width:998px;">
<?php 
$this->assign('selidx',1);
$this->display('college/course_nav');?>
<div class="coursecat">
	<div class="coursecatson">
    	<div class="lvjies">
            <h1 style="position:relative"><?=$folder['foldername']?></h1>
            <p class="topjie"><?=$folder['summary']?></p>
            
			<?=$folder['detail']?>
		</div>
        <div class="courselists">
        	<?php if(!empty($folder['introduce']))
			foreach($folder['introduce'] as $k=>$introduce){?>
            <div class="kecjs  mt25">
            	<h2><?=$introduce['title']?></h2>
                <p><?=$introduce['content']?></p>
            </div>
			<?php }?>
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
