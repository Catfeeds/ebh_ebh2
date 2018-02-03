<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<body>
<div class="">
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        >
        <a href="/aroomv2/xuanke.html">选课系统</a>
        >
        <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xuanke['xkid']?>">查看</a>
        >
        <span>查看申报课程</span>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs" style="min-height: 627px;">
        <h2 class="sizrer" title="<?=htmlspecialchars($xuanke['name'], ENT_COMPAT)?>"><?php echo htmlspecialchars(shortstr($xuanke['name'],50), ENT_NOQUOTES)?></h2>
        <div class="kostrds">
            <ul>
                <li class="fklisr"><a href="reportcourse.html?xkid=<?php echo $xuanke['xkid']?>" class="wursk botsder">课程列表</a></li>
                <li class="fklisr"><a href="course_set.html?xkid=<?php echo $xuanke['xkid']?>" class="wursk ">课程设置</a></li>
            </ul>
        </div>
        <?php if(!empty($courselist)){?>
        <?php foreach($courselist as $course){?>
        <div class="jiweaes" style="width: 780px;">
            <p class="jierses" style="height: auto">
                <span class="huersw" title="<?php echo $course['coursename']?>"><?php echo shortstr($course['coursename'],40)?></span>
                <span class="jieraee">教师：<?php echo empty($course['realname'])?$course['username']:$course['realname']?></span>
                <span class="jieraee"><?php echo date('Y-m-d H:i',$course['datetime'])?></span>
            </p>
            <a href="javascript:;" onclick="del(<?php echo $course['cid']?>)" class="jieshae"></a>
            <p class="juersde">课程介绍：<?php echo $course['introduce']?></p>
            <div class="xklbtp">
                <ul id="layer-photos-demo">
                    <?php foreach($course['images'] as $thumb => $image): ?>
                        <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;margin-left: -20px;" /></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php }}else{?>
            <div class="nodata"></div>
        <?php }?>
        <?php if(!empty($pagestr)) { ?><?=$pagestr?><?php } ?>
    </div>
</div>
<div class="tanchukuangs" style="display: none" id="dialog2">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="">确定删除选中的课程？</div>
        <div class="qsryy">
            <p class="pqsryy">请输入原因：</p>
            <textarea class="sckcyysr" style="color: #000" placeholder="课程不符合本次活动"></textarea>
        </div>
        <div class="xuanbtn2s" style="margin-top:35px;">
            <a href="#" class="jxxk">确定</a>
            <a href="#" class="qkks">取消</a>
        </div>
    </div>
</div>
</body>
<script>
    function prev(jo) {
        jo.each(function() {
            $(this).lightBox();
        });
    }
    (function($) {
        prev($('.xklbtplist.fl a'));
    })(jQuery);

    function del(cid){
        var cid = cid;
        var d = dialog({
            title: false,
            content: document.getElementById("dialog2"),
            cancel: false,
//            width:390,
//            height:187,
            drag:true,
            padding:1
//            fixed:true
        });
        d.showModal();
        $('.qkks').on('click',function(){
            d.close();
            location.reload();
        })
        $('.jxxk').on('click',function(){
            var msg = $('.sckcyysr').val();
            if(msg==''){
                var msg = '课程不符合本次活动';
            }
            $.post('/aroomv2/xuanke/del.html',{cid:cid,msg:msg},function(data){
                var data = eval('(' + data + ')');
                if (data.status == 1) {
                    $.showmessage({
                        img: 'success',
                        message: '删除课程成功',
                        title: '调整课程',
                        callback: function () {
                            location.reload();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: '删除课程失败',
                        title: '调整课程'
                    });
                }
            })
        })

    }
	$(function(){
		$('.jiweaes:last').css('border-bottom','none');
	});
</script>
</html>
