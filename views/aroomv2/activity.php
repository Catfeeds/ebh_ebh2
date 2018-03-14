<?php $this->display('aroomv2/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style type="text/css">
    .dialogcont{
        height: 100px;
        margin: 0 auto;
        text-align: center;
        width: 339px;
    }
    .dialogcont .tishi{
        background: url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/ico.jpg") no-repeat scroll 40px center;
        height: 36px;
        margin-left: 0;
        text-align: left;
        width: 339px;
    }
    .dialogcont .tishi p {
        padding-left: 90px; font-size: 16px; line-height: 35px;
    }
    .tables td a.taa{
        color: #666 !important;
        text-decoration: none;
    }
    .tables .handle a{
        color:#36648B !important;;
        text-decoration: none;
    }
</style>
<div class="ter_tit">
    当前位置 > <a href="<?=geturl('aroomv2/more')?>">更多应用</a> > <a href="<?php echo geturl('aroomv2/activity')?>">活动专区</a>
</div>
<div class="kechengguanli">
    <div class="kechengguanli_top fr">
        <ul>
            <li class="fl"><a href="/aroomv2/activity/add.html" target="">发布活动</a></li>
        </ul>
    </div>
    <div class=" clear"></div>
    <div class="lefrig lefrigs">
        <table cellpadding="0" cellspacing="0" class="tables datatab2s">
            <tr class="first" width="100%">
                <td width="50%">活动内容</td>
                <td width="10%">发布时间</td>
                <td width="10%">活动状态</td>
                <td width="30%">操作</td>
            </tr>
            <?php if(!empty($list)){
                foreach($list as $v){?>
                    <tr>
                        <td width="52%">
                            <div class="matchlists">
                                <div class="matchlistpics fl"><a href="/aroomv2/activity/view.html?aid=<?=$v['aid']?>"><img src="<?php echo empty($v['imgurl'])?'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg':$v['imgurl']?>" width="100" height="70" /></a></div>
                                <div class="matchlistnrs fl">
                                    <div class="fl matchlistnrsons">
                                        <a href="/aroomv2/activity/view.html?aid=<?=$v['aid']?>" class="hdnames taa"><?=$v['subject']?></a>
                                        <p class="hdtime">时间：<?php echo date('Y-m-d',$v['starttime'])?> — <?php echo date('Y-m-d',$v['endtime'])?></p>
                                        <?php $mes = strip_tags($v['summary']); $message = ssubstrch($mes,0,30)?>
                                        <p class="hdtime">活动摘要:<?php echo $message?><?php if($mes>$message) echo '...'?></p>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="gxqcj">
                                        <p class="fl gxqs"><span class="joinscj"><?php echo $v['parter']?></span>人参加</p>
                                        <p class="fl gxqs ml25"><span class="joinscj"><?php echo $v['viewnum']?></span>人感兴趣</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php $now = time();?>
                        <td><?php echo date('Y-m-d',$v['date'])?></td>
                        <td width="88"><?php echo $v['isgoing']==1?'<label style="color: #f5a932">进行中</label>':'已结束'?></td>
                        <td width="160" class="handle">
                            <a href="/aroomv2/activity/view.html?aid=<?php echo $v['aid']?>">查看</a>
                            <a href="/aroomv2/activity/edit.html?aid=<?php echo $v['aid']?>">编辑</a>
                            <?php if(!empty($v['parter'])&&$now<$v['endtime']+86400){?>
                            <label class="jzsc" style="color: #a09d9d; padding:0 4px;position: relative;top: -1px;">删除</label>
                            <?php }else{?>
                            <a href="javascript:;" onclick="delsurvey(<?=$v['aid']?>);">删除</a>
                            <?php }?>
                            <a href="/aroomv2/activity/stat.html?aid=<?php echo $v['aid']?>">统计</a>
                        </td>
                    </tr>
                <?php }
            }else{?>
                <tr><td colspan="5" align="center">暂无记录</td></tr>
            <?php }?>
        </table>
    </div>
</div>
<?=$pagestr?>

<!--编辑问卷对话框-->
<div id="dialogedit" style="display:none">
    <input type="hidden" id="current_id" value="0" />
    <div class="dialogcont">
        <div class="tishi mt40"><p>确定要编辑该活动吗?</p></div>
    </div>
</div>
<!--删除问卷对话框-->
<div id="dialogdel" style="display:none">
    <div class="dialogcont">
        <div class="tishi mt40"><p>确定要删除该活动吗?</p></div>
    </div>
</div>
<script>
//    function editsurvey(id) {
//        $("#current_id").val(id);
////        $.ajax({
////            type:'post',
////            url:'<?////=geturl('aroomv2/activity/edit')?>////',
////            dataType:'json',
////            data:{'id':id},
////            success:function(data){
////                if(data!=undefined && data!=null){
////                    var msg = '';
////                    if(data>0)
////                        msg = '你的问卷已收集 '+data+' 份投票，编辑问卷会影响已收集的投票。<br />';
////                    msg += '确定要编辑该问卷吗?';
////                    $("#dialogedit .tishi p").html(msg);
////                }
////            },
////            error:function(){
////                alert("服务器连接错误，请重试");
////            }
////        });
//
//        var button = new xButton();
//        button.add({
//            value:"确定",
//            callback:function(){
//                H.get('dialogedit').exec('close');
//                var current_id = $("#current_id").val();
//                location.href = "/aroomv2/activity/edit.html?aid="+current_id;
//                return false;
//            },
//            autofocus:true
//        });
//
//        button.add({
//            value:"取消",
//            callback:function(){
//                H.get('dialogedit').exec('close');
//                return false;
//            }
//        });
//        if(!H.get('dialogedit')){
//            H.create(new P({
//                id : 'dialogedit',
//                title: '编辑活动',
//                easy:true,
//                width:400,
//                padding:5,
//                content:$('#dialogedit')[0],
//                button:button
//            }),'common');
//        }
//
//        H.get('dialogedit').exec('show');
//    }
    function delsurvey(sid) {
        $("#current_id").val(sid);
//        $.ajax({
//            type:'post',
//            url:'<?//=geturl('aroomv2/activity/getparter_num')?>//',
//            dataType:'json',
//            data:{'sid':sid},
//            success:function(data){
//                if(data!=undefined && data!=null){
//                    var msg = '';
//                    if(data>0)
//                        msg = '你的活动已有 '+data+' 人参加，删除活动会影响已参加的学生。<br />';
//                    msg += '确定要删除该活动吗?';
//                    $("#dialogdel .tishi p").html(msg);
//                }
//            },
//            error:function(){
//                alert("服务器连接错误，请重试");
//            }
//        });
        var button = new xButton();
        button.add({
            value:"确定",
            callback:function(){
                savedel();
                return false;
            },
            autofocus:true
        });

        button.add({
            value:"取消",
            callback:function(){
                H.get('dialogdel').exec('close');
                return false;
            }
        });
        if(!H.get('dialogdel')){
            H.create(new P({
                id : 'dialogdel',
                title: '删除活动',
                easy:true,
                width:400,
                padding:5,
                content:$('#dialogdel')[0],
                button:button
            }),'common');
        }

        H.get('dialogdel').exec('show');
    }

    function savedel(){
        var current_id = $("#current_id").val();
        $.ajax({
            type:'post',
            url:'<?=geturl('aroomv2/activity/del')?>',
            dataType:'json',
            data:{'aid':current_id},
            success:function(data){
                dialogtip();
                if(data!=undefined && data!=null && data==1){
                    H.get('xtips').exec('setContent','删除成功').exec('show').exec('close',500);
//                    window.location.reload();
                }else{
                    H.get('xtips').exec('setContent','删除失败').exec('show').exec('close',500);
                }
            },
            error:function(){
                H.get('xtips').exec('setContent','删除失败').exec('show').exec('close',500);
            }
        });
    }
    function dialogtip(){
        if(!H.get('xtips')){
            H.create(new P({
                id:'xtips',
                easy:true,
                padding:10
            },{
                onclose:function(){
                    location.reload(true);
                }
            }),'common');
        }
    }
</script>
<?php $this->display('aroomv2/page_footer'); ?>
