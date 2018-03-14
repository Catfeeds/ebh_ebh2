<?php $this->display('aroomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
    .huide em{
        font-style: italic;

    }
    .huide strong em{
        font-weight: bold;
    }
    .huide em strong{
        font-style: italic;
    }
    .huide strong{
        font-weight: bold;
    }
    /*.moresbms{*/
        /*float: right;*/
    /*}*/
    .wxename{
        width:670px;
    }
.allcou{
	width:788px;
}
</style>
<body>
<div class="ter_tit">
    当前位置 &gt; <a href="/aroomv2/more.html">更多应用</a>&gt; <a href="/aroomv2/activity.html">活动专区</a> &gt; 活动详情
</div>
<div class="allcou lefrig lefrigs" style="width:788px;">
    <input type="hidden" value="<?php echo $parter['count']?>" id="partercount">
    <input type="hidden" value="<?php echo $info['aid']?>" id="actid">
    <div class="matchtitle"><?php echo $info['subject']?></div>
    <div class="titles">
        <a href="javascript:;"  class="aall curs" style="text-decoration: none">活动介绍</a>
		<a href="/aroomv2/activity/descriptions.html?aid=<?php echo $info['aid']?>"  class="aall" style="text-decoration: none">积分规则</a>
		<a href="/aroomv2/activity/stat.html?aid=<?php echo $info['aid']?>"  class="aall" style="text-decoration: none">统计</a>
    </div>
    <div class="matchs1">
        <div class="matchlist" style="border-bottom:none;">
            <div class="matchlistpics matchlistpics1 fl" style="width: 360px;height: 252px;"><img src="<?php echo !empty($info['imgurl']) ? $info['imgurl'] : 'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg'?>" width="360" height="252" /></div>
            <div class="matchlistnrs fl" style="width:340px;">
                <div class="fl matchlistnrson matchlistnrson1" style="width:390px;">
                    <p class="mt5">时间：<?php echo date('Y-m-d',$info['starttime'])?> -- <?php echo date('Y-m-d',$info['endtime'])?></p>
                    <?php $now = time()?>
                    <p>状态：<?php echo $info['isgoing']==1?'<b style="color: red">进行中</b>':'已结束'?></p>
                </div>
                <div class="clear"></div>
                <div class="gxqcj gxqcj1" style="width:390px;">
                    <p><span style="font-weight:bold;"><?php echo $info['parter']?></span>人参加</p>
                    <p><span style="font-weight:bold;"><?php echo $info['viewnum']?></span>人感兴趣</p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="hdnrs huide">
            <h2>活动内容</h2>
            <?php echo $info['message']?>
        </div>
        <div class="hdnrs mt15">
            <div>
                <h2 class="fl">报名信息(<?php echo $info['parter']?>)</h2>
                <?php if($parter['count']>10){?>
                    <?php if(!empty($more)){?>
                        <a href="/aroomv2/activity/view.html?aid=<?php echo $info['aid']?>" id="getmorep" class="moresbm fr">查看评论>></a>
                    <?php }else{?>
                        <a href="/aroomv2/activity/view.html?more=1&aid=<?php echo $info['aid']?>" id="getmorep" class="moresbm fr">更多>></a>
                    <?php }?>
                <?php }?>
            </div>
            <div class="clear"></div>
            <?php unset($parter['count']); if(!empty($parter)){?>
            <div class="bmxxlist">
                <?php foreach($parter as $key=>$value){?>
                    <?php if($key%10==0){?>
                        <div class="fl bmxxlist1">
                    <?php }else{?>
                        <div class='ml25 fl bmxxlist1'>
                    <?php }?>
                    <?php
                    if($value['sex'] == 1)
                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                    else
                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                    $face = empty($value['face']) ? $defaulturl:$value['face'];
                    $face = str_replace('.jpg','_50_50.jpg',$face);
                    ?>
                    <div><img src='<?php echo $face?>' height='50' width='50'></div>
                    <div class='touxiangt'><span style='color:#fff;'><?php echo !empty($value['realname'])?$this->displace($value['realname']):'--';?></span></div>
                </div>
                <?php }?>
            </div>
            <?php }else{?>
                <div class="" align="center">无信息</div>
            <?php }?>
        </div>
        <div class="clear"></div>
        <div class="hdnrs mt25" id="reviews" <?php echo empty($request['more'])?'':'hidden'?>>
            <h2>评论</h2>
            <div class="pilunlist">
                <?php if(!empty($reviews)){foreach($reviews as $k=>$v){?>
                <div class="pilunlist1">
                    <div class="pilunlist1son">
                        <?php
                        if($v['sex'] == 1)
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                        else
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                        $face = empty($v['face']) ? $defaulturl:$v['face'];
                        $face = str_replace('.jpg','_50_50.jpg',$face);
                        ?>
                        <div class="toxiangs fl"><img src="<?php echo $face?>" height="50" width="50"></div>
                        <div class="wxename fl ml5">
                            <div style="width:670px;">
                                <span class="names fl"><?php echo !empty($v['realname'])?$this->displace($v['realname']):'--';?></span>
                                <span class="datime fl">&nbsp;<?php echo date('Y-m-d',$v['date'])?></span>
                                <span class="datime fr"><?php echo max(0,($page['page']-1))*$page['pagesize']+$k+1?>F</span>
                            </div>
                            <div class="clear"></div>
                            <p class="plnrs"><?php echo emotionreplace($v['review'])?></p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php if($v['isshield']==1){?>
                        <a class="moresbms" style="color: #999999;cursor:default;text-decoration: none">已屏蔽</a>
                        <?php }else{?>
                    <a href="javascript:;" onclick="shield(<?php echo $v['cid']?>)" class="moresbms">屏蔽</a>
                        <?php }?>
                </div>
                <?php }}else{?>
                    <div align="center">没有评论</div>
                <?php }?>
            </div>
            <?php echo $pagestr?>
        </div>

<!--        <div class="clear"></div>-->
<!--        <div class="fbplss">-->
<!--            <textarea class="fbplstexts"></textarea>-->
<!--        </div>-->
<!--        <div class="bqtppl">-->
<!--            <a href="javascript:;" class="biage">表情</a>-->
<!--            <a href="javascript:;" class="biage tupge">图片</a>-->
<!--            <a href="javascript:;" class="pinglun">评&nbsp;论</a>-->
<!--        </div>-->
    </div>
</div>
</body>
<script>
    function shield(aid){
        if(!window.confirm('是否屏蔽评论')){
            return false;
        }
        var aid = aid;
        $.post('/aroomv2/activity/shield.html',{aid:aid},function(data){
            var data = eval('('+data+')');
            if (data.stat) {
                $.showmessage({
                    img : 'success',
                    message:'屏蔽成功',
                    title:'消息通知'
                })
                setTimeout(function(){
                    location.reload();
                },1000)
            } else {
                $.showmessage({
                    img : 'error',
                    message:'屏蔽失败',
                    title:'消息通知'
                })
                setTimeout(function(){
                    location.reload();
                },1000)
            }
        })
    }
//    $('#getmorep').click(function(){
//        var count = $('#partercount').val();
//        var actid = $('#actid').val();
//        $.post('/aroomv2/activity/view.html',{count:count,aid:actid},function(data){
////            var data = eval('('+data+')');
//            $.each(data,function(name,value){
//                $('.bmxxlist').append(' <div class="fl bmxxlist1 ml25">'
//                +'<div><img src='+value["face"]+' height="50" width="50"></div>'
//                +'<div class="touxiangt"><span style="color:#fff;">'+value["realname"]+'</span></div>'
//                +'</div>');
//            })
//        },'json')
//        $('#reviews').hide();
//        $('.moresbm').hide();
//
//    })
</script>
</html>
