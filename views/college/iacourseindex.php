<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/lnclass.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css?v=20161118103" />
<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/jquery.min.js"></script>
<title>互动课堂</title>
</style>
</head>

<body style="background-color: white;">
<div class="maines">
	<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
		<ul>
			 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;"><span>互动课堂</span></a></li>
		</ul>
        <div class="diles" style="margin-top:0px;">
            <input id="title" class="newsou" style="<?php if(!empty($q)){echo 'color:black;';}else{echo 'color:#a5a5a5';}?>" value="<?php if(!empty($q)){echo $q;}else{echo '请输入关键字';}?>" name="title" type="text">
            <input id="ser" class="soulico" value="" type="button" style="position:absolute">
            <input id="crid"  value="<?= $roominfo['crid'] ?>" type="hidden">
            <input id="uid"  value="<?= $user['uid'] ?>" type="hidden">
        </div>
    </div>
    <div id="lists">
        <?php if(empty($lists)) { ?>
            <div class="nodata">
            </div>
        <?php }else{ ?>
            <?php foreach ($lists as $key => $item) { ?>
                
                <div class="kstrnet" <?php if($key == count($lists)-1){?> style="border-bottom: 1px solid white;" <?php } ?> >
                <?php if(!$item['hasJoined']){?>
                	<h2 class="hosrnet"><a class="bisrrt" href="/college/iacourse/answer.html?icid=<?= $item['icid'] ?>" target="_blank"><?= strip_tags($item['title']); ?></a></h2>
                <?php }else{?>
                    <h2 class="hosrnet"><a class="bisrrt" href="/college/iacourse/show.html?icid=<?= $item['icid'] ?>" target="_blank"><?= strip_tags($item['title']); ?></a></h2>
                <?php }?>
                    <?php if(!$item['hasJoined']){ ?>
                        <a class="chsrlan" href="/college/iacourse/answer.html?icid=<?= $item['icid'] ?>" target="_blank">参与互动</a>
                    <?php }else{ ?>
                        <a class="cahsrt" href="/college/iacourse/show.html?icid=<?= $item['icid'] ?>" target="_blank">查看结果</a>
                    <?php } ?>
                	<p class="husrrts">
                    	<span><?= timetostr($item['dateline'],'Y-m-d') ?></span>
                        <span class="tersr"><?= shortstr($item['teacher'], 10) ?></span>
                        <span class="tsierr"><?=  $item['answercount'].'/'. $item['studentNums'] ?></span>
                        <span class="spert">共<?= $item['questioncount']; ?>题</span>
                    </p>
                </div>

            <?php } ?>
        <?php }?>
    </div>
    <?php if(isset($paginate)) echo $paginate; ?>
</div>
<script type="text/javascript">
    //ajax 关键词搜索
    $(function(){
        $("#ser").click(function(){
            var keywords = $("input[name='title']").val();
            if(keywords == '请输入关键字'){
                keywords = '';
            }
            var url = '/college/iacourse.html?q='+keywords;
            location.href = url;
        });
    });
    $('#title').on('click',function(){
        var title = $('#title').val();
        if(title == '请输入关键字'){
            $('#title').val('');
            $(this).css('color','black');
        }
    })
    $('#title').on('blur',function(){
        var title = $('#title').val();
        if(title == ''){
            $('#title').val('请输入关键字');
            $('#title').css('color','#a5a5a5');
        }
    })
    function renderLists(lists){
        $("#lists").empty();
        if(lists.length){

            for(var i = 0,len = lists.length; i<len; i++) {
                if(len-1 == i){
                    var html = ' <div class="kstrnet" style="border-bottom: 1px solid white;">';
                    if(!lists[i].hasJoined){
                        var h2 = '<h2 class="hosrnet"><a class="bisrrt" href="/college/iacourse/answer.html?icid='+lists[i].icid+'" target="_blank">'+lists[i].title+'</a></h2>';
                    }else{
                        var h2 = '<h2 class="hosrnet"><a class="bisrrt" href="/college/iacourse/show.html?icid='+lists[i].icid+'" target="_blank">'+lists[i].title+'</a></h2>';
                    }
                    var a = '';
                    if(!lists[i].hasJoined){
                        a = '<a class="chsrlan" href="/college/iacourse/answer.html?icid='+lists[i].icid+'" target="_blank">参与互动</a>';
                    }else{
                        a = '<a class="cahsrt" href="/college/iacourse/show.html?icid='+lists[i].icid+'" target="_blank">查看结果</a>';
                    }
                    var p = '<p class="husrrts"><span>'+lists[i].dateline+'</span><span class="tersr">'+lists[i].teacher+'</span><span class="tsierr">'+lists[i].answercount+'/'+lists[i].studentNums+'</span><span class="spert">共'+lists[i].questioncount+'题</span></p></div>';
                    html += h2+a+p;
                    $("#lists").append(html);
                }else{
                    var html = ' <div class="kstrnet">';
                    if(!lists[i].hasJoined){
                        var h2 = '<h2 class="hosrnet"><a class="bisrrt" href="/college/iacourse/answer.html?icid='+lists[i].icid+'" target="_blank">'+lists[i].title+'</a></h2>';
                    }else{
                        var h2 = '<h2 class="hosrnet"><a class="bisrrt" href="/college/iacourse/show.html?icid='+lists[i].icid+'" target="_blank">'+lists[i].title+'</a></h2>';
                    }
                    var a = '';
                    if(!lists[i].hasJoined){
                        a = '<a class="chsrlan" href="/college/iacourse/answer.html?icid='+lists[i].icid+'" target="_blank">参与互动</a>';
                    }else{
                        a = '<a class="cahsrt" href="/college/iacourse/show.html?icid='+lists[i].icid+'" target="_blank">查看结果</a>';
                    }
                    var p = '<p class="husrrts"><span>'+lists[i].dateline+'</span><span class="tersr">'+lists[i].teacher+'</span><span class="tsierr">'+lists[i].answercount+'/'+lists[i].studentNums+'</span><span class="spert">共'+lists[i].questioncount+'题</span></p></div>';
                    html += h2+a+p;
                    $("#lists").append(html);
                }
                
            }
        }else{
            var html = '<div class="nodata"></div>';
            $("#lists").append(html);
        }
    }
</script>
</body>
</html>
