<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论展示</title>
</head>
<?php
	$is_zjdlr = empty($is_zjdlr)?false:true;
	$is_newzjdlr = empty($is_newzjdlr)?false:true;
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<style type="text/css">
.lefrig-1{
    width: 1000px;
    display: inline-block;
}
</style>
<body>
<div class="lefrig">
    <div class="lefrig-1">
        <div class="navigations-1">
            <ul style="margin-left:0;">
                <li><a href="/college/review/showReview.html" class="curr">学员评论</a></li>
                <li><a href="/college/myask/all.html">答疑专区</a></li>
                <?php if($is_newzjdlr){?>
                	<li><a href="/college/myarticle.html">原创文章</a></li>
                <?php }?>
            </ul>
            <div class="dile2s-1">
                <input name="txtname" class="newsous-1" id="title" value="<?=empty($q) ? '请输入关键字' : $q;?>" style="color: rgb(153, 153, 153);" type="text">
                <input class="soulicos-1" value="" type="button">
            </div>
        </div>
        <!--评论展示-->
        <div class="reviewshows">
            <?php if(!empty($reviewlist)){ ?>
            <ul>
                <?php foreach ($reviewlist as $list) {?>
                <li>
                    <p class="reviewcontent"><?=$list['subject'];?></p>
                    <p >
                        <span class="width100"><?=date('Y-m-d',$list['dateline'])?></span>
                        <span class="width100 ml10" title="<?=$name = empty($list['realname']) ? $list['username'] : $list['realname'];?>"><?=getusername($list,10);?></span>
                        <span class="width100 ml10"><?=isset($list['classname']) ? $list['classname'] : '';?></span>
                        <a target="_blank" href="/myroom/mycourse/<?=$list['toid']?>.html" class="coursewarelink" style="color: #5e98f9;"><?=isset($list['foldername']) ? $list['foldername'] : '' ?><?=isset($list['title']) ? '>'.$list['title'] : '';?></a>
                    </p>
                </li> 
                <?php }?> 
            </ul>
            <?php }else{?>
            <div style="min-height:500px;"></div>
            <?php }?>
        </div>
        <div class="clear"></div>
        <?=$pagestr;?>  
    </div>
</div>
<script type="text/javascript">
$(".soulicos-1").on('click',function(){
    var q = $("#title").val();
    if(q == '请输入关键字'){
        q = '';
    }
    location.href = '/college/review/showReview.html?q='+q;
});
$("#title").click(function(){
    var q = $("#title").val();
    if(q == '请输入关键字'){
        $("#title").val('');
    }
    $("#title").css('color','rgb(51, 51, 51)');
});
$("#title").blur(function(){
    var q = $("#title").val();
    if(q == ''){
        $("#title").val('请输入关键字');
        $("#title").css('color','rgb(153, 153, 153)');
    }
})
$(".reviewshows li").last().css('border-bottom','none');
</script>
</body>
</html>