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
        <span>设置课程</span>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs" style="min-height: 627px;">
        <h2 class="sizrer"><?php echo $xuanke['name']?></h2>
        <div class="kostrds">
            <ul>
                <li class="fklisr"><a href="reportcoursefinish_list.html?xkid=<?php echo $xkid?>" class="wursk botsder">课程列表</a></li>
                <li class="fklisr"><a href="reportcoursefinish_set.html?xkid=<?php echo $xkid?>" class="wursk ">课程设置</a></li>
                <li class="fklisr"><a href="reportcourserule.html?xkid=<?php echo $xkid?>" class="wursk">选课规则</a></li>
            </ul>

            <?php if($xuanke['status']<3){?>
                <a href="javascript:;" id="fbxk" class="husretd">发布第一轮选课</a>
            <?php }else{?>
                <a href="javascript:;" style="cursor:default;text-decoration: none" class="husretd">选课已发布</a>
            <?php }?>
        </div>
        <?php if(!empty($courselist)){foreach($courselist as $course){?>
        <div class="jiweaes" style="width: 780px;">
            <p class="jierses">
                <span class="huersw" title="<?php echo $course['coursename']?>"><?php echo shortstr($course['coursename'],60)?></span>
                <span class="jieraee">教师：<?php echo empty($course['realname'])?$course['username']:$course['realname']?></span>
            </p>
            <a href="javascript:;" onclick="sug(<?php echo $course['cid']?>)" class="jieshae"></a>
            <p class="juersde">课程介绍：<?php echo $course['introduce']?></p>
            <div class="xklbtp">
                <ul id="layer-photos-demo">
                    <?php foreach($course['images'] as $thumb => $image): ?>
                        <li class="fl xklbtplist"><a href="<?=$image?>"><img src="<?=$thumb?>" style="cursor:pointer;width:180px;height:110px;margin-left: -20px;" /></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php } ?>
            <?php if(!empty($pagestr)) { ?><?=$pagestr?><?php } ?>
            <?php }else{?>
            <div class="nodata"></div>
        <?php }?>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit2" style="display: none">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="width: 280px;"></div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk">确定</a>
            <a href="javascript:;" class="qkks">取消</a>
        </div>
    </div>
</div>
<div class="tanchukuangs" style="display: none" id="dialog2">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style=""><?php if($count==1){echo '确定删除最后一门课程?系统将同步删除本次活动。';}else{echo '确定删除选中的课程？';}?></div>
        <div class="qsryy" style="display: <?php if($count==1)echo 'none;';?>;">
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
        window.prev($('.xklbtplist.fl a'));
    })(jQuery);
    //发布选课
    $('#fbxk').on('click',function(){
        var url = '/aroomv2/xuanke/fbxk.html';
        var xkid = <?php echo $xkid?>;
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit2"),
            cancel: false,
            padding:1
//            fixed:true
        });
        $('.xzkctsxx').html('确定已设置选课规则和所有课程规则？');
        d.show();
        $('.qkks').on('click',function(){
            d.close();
            location.reload();
        });
        $('.jxxk').on('click',function(){
            d.close();
            $.post(url,{xkid:xkid,status:3},function(data){
                var data = eval('(' + data + ')');
                if (data.msg == 'success') {
                    $.showmessage({
                        img: 'success',
                        message: '发布选课成功',
                        title: '发布选课',
                        callback: function () {
                            document.location.href = "<?= geturl('aroomv2/xuankemanagermsg') ?>?xkid=<?php echo $xkid?>";
//                                var opened=parent.window.open(' ','_self');
//                                opened.close();
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: data.msg,
                        title: '发布选课'
                    });
                    if(data.msg = '请添加规则后再发布选课'){
                        setTimeout("document.location.href = \"<?= geturl('aroomv2/xuanke/reportcourserule') ?>?xkid=<?php echo $xkid?>\";",1000)
                    }
                }
            })
        });
    })


    function sug(cid){
        var cid = cid;
        var d = dialog({
            title: false,
            content: document.getElementById("dialog2"),
            cancel: false,
            id: 'art_d',
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
            return false;
        })
        $('.jxxk').bind('click',function(){
            del(cid);
            d.close();
        })
    }


    function del(cid){
            var msg = $('.sckcyysr').val();
            if(msg==''){
                var msg = '课程不符合本次活动';
            }
            $.post('/aroomv2/xuanke/del.html',{cid:cid,msg:msg,delactive:1},function(data){
                var data = eval('(' + data + ')');
                if (data.status != 0) {
                    $.showmessage({
                        img: 'success',
                        message: data.msg,
                        title: '调整课程',
                        callback: function () {
                            if(data.status==1){
                                location.reload();
                            }else{
                                document.location.href = "<?= geturl('aroomv2/xuanke') ?>";
                            }
                        }
                    });
                } else {
                    $.showmessage({
                        img: 'error',
                        message: '删除课程失败，请稍后再试或联系管理员',
                        title: '调整课程'
                    });
                }
            })

    }
$(function(){
		$('.jiweaes:last').css('border-bottom','none');
	});

</script>
</html>
