
<?php $this->display('troomv2/page_header');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css<?=getv()?>" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<body>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
			</ul>
		</div>
        <a href="/troomv2/iacourse/add.html" class="jaddre" target="_blank">新建互动</a>
         <div class="diles">
            <input class="newsou" style="<?php if(!empty($q)){echo 'color:black;';}else{echo 'color:#a5a5a5';}?>" value="<?php if(!empty($q)){echo $q;}else{echo '请输入关键字';}?>" type="text">
            <input class="soulico" type="button">
        </div>
    </div>
    <div class="clear"></div>
    <?php if(!empty($lists)){?>
        <?php foreach ($lists as $list) {?>
            <div class="interactiveclasslist">
                <?php if($list['status'] == 1){?>
            	<a href="/troomv2/iacourse/<?php echo $list['icid']?>.html" target="_blank"><h2 class="interactiveclasstitle"><?php echo shortstr(strip_tags($list['title']),90);?></h2></a>
                <?php }else{?>
                <a href="/troomv2/iacourse/edit/<?php echo $list['icid']?>.html" target="_blank"><h2 class="interactiveclasstitle"><?php echo shortstr(strip_tags($list['title']),90);?></h2></a>
                <?php }?>
                <div class="operation1s-1">
                <?php if($list['status'] == 1){?>
                    <a href="/troomv2/iacourse/<?php echo $list['icid']?>.html" style="margin-right:66px;" class="release-1 statistics-1" target="_blank">统计</a>
                <?php }else{?>
                    <a href="javascript:void(0)" class="release-1 pushlish" status="<?php echo $list['status'];?>" icid="<?php echo $list['icid']?>">发布</a>
                <?php }?>
                <?php if($list['status'] == 0){?>
                    <a href="/troomv2/iacourse/edit/<?php echo $list['icid']?>.html" class="xiaust" target="_blank"></a>
                <?php }?>
                    <a href="javascript:void(0)" class="shansge" icid="<?php echo $list['icid']?>"></a>
                </div>
                <div class="clear"></div>
                <div class="interaction-1">
                	<span class="interactiontime"><b></b>
                    <?php if($list['status'] == 0){?>
                    <?php echo timetostr($list['editdateline'],'Y-m-d')?>编辑
                    <?php }else{ ?>
                    <?php echo timetostr($list['dateline'],'Y-m-d')?>发布 
                    <?php }?>  
                    </span>
                    <span class="interactionpeople"><b></b><?php echo $list['answercount'];?>/<?php echo $list['totalcount'];?></span>
                    <span class="interactionumber"><b></b>共<?php echo $list['questioncount'];?>题</span>
                    <span class="interactionclass"><b></b>
                    <?php 
                        echo shortstr(implode('、',json_decode($list['foldernames'])),50);
                    ?>
                    </span>
                </div>
            </div>
        <?php }?>
    <?php }else{?>
    <div class="nodata">
    </div>
    <?php }?>
    <?php if(isset($pagestr)){echo $pagestr;}?>
</div>
</body>
<script type="text/javascript">
$(".interactiveclasslist").last().css('border-bottom','none');
$(".pushlish").on('click',function(){
    var icid = $(this).attr('icid');
    $.ajax({
        type:'post',
        url:'/troomv2/iacourse/publish.html',
        data:{'icid':icid},
        success:function(data){
            if(data){
                $.showmessage({
                    message:'发布成功！',
                    timeoutspeed:1000,
                    callback:function(){
                        window.location.reload();
                    }
                });
            }else{
                $.showmessage({
                    message:'发布失败！'
                });
            }           
        }
    });
});
$(".shansge").on('click',function(){
    var icid = $(this).attr('icid');
    $.ajax({
        type:'post',
        url:'/troomv2/iacourse/del.html',
        data:{'icid':icid},
        success:function(data){
            if(data){
                $.showmessage({
                    message:'删除成功！',
                    timeoutspeed:1000,
                    callback:function(){
                        window.location.href='/troomv2/iacourse.html';
                    }
                });
            }else{
                $.showmessage({
                    message:'删除失败！'
                });
            }           
        }
    });
});
$(".soulico").click(function(){
    var search = $(".newsou").val();
    if(search == '请输入关键字'){
        search = '';
    }
    var url = '/troomv2/iacourse.html?q='+search;
    location.href = url;
});
$(".newsou").on('click',function(){
    if($(this).val() == '请输入关键字'){
        $(this).val('');
        $(this).css('color','black');
    }
});
$(".newsou").on('blur',function(){
    if($(this).val() == ''){
        $(this).val('请输入关键字');
        $(this).css('color','#a5a5a5');
    }
});
</script>
</html>
