<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>-->
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css<?=getv()?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
    <title>无标题文档</title>
    <style>

        .completetime i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 <?= $sort==1?"-7px":"0"?>;}
        .totalscore i{display:inline-block;height: 8px;width: 7px;line-height: 8px;margin-left:5px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/orderbg.png) no-repeat 0 <?= $sort==3?"-7px":"0"?>;}
        .imgyuan{
            width:50px;
        }
        .workcurrent{
        	width: 105px;
        }
    </style>
</head>

<body>
<div class="lefrig">
    <h2 class="jisret"><?php echo $myexam['title']?></h2>
    <!--    <div class="klefste">-->
    <!--        <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shilitu01.jpg" />-->
    <!--    </div>-->
    <p class="kishre" style="padding-left: 300px"><span class="ksrdgae">布置时间：<?php echo date('Y-m-d H:i',$myexam['dateline'])?></span><span class="ksrdgae">总分：<?php echo $myexam['score']?></span><span class="ksrdgae">计时：<?php echo empty($myexam['limitedtime'])?'不计时':$myexam['limitedtime'].'分钟'?></span></p>
    <div class="kishre" style="padding-left: 300px">
        <span class="ksrdgae fl mt5" style="margin-right:0;">选择班级：</span>
        <div class="fl" style="width:605px;">
            <a href="javascript:;" class="bjchose cuur"><?php echo $myclass['classname']?></a>
        </div>
    </div>
    <!--    <div class="dsiters">-->
    <!--        <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shilitu02.jpg" />-->
    <!--    </div>-->
    <div class="work_mes">
        <ul class="extendul">
            <li class="workcurrent"><a href="javascript:;">学生试题批阅</a></li>
            <!--            <li><a href="#">单题批阅</a></li>-->
        </ul>
    </div>
    <div class="lishnrt">
        <a href="/troomv2/classexam/all2-0-0-0-<?php echo $myclass['classid']?>-<?php echo $myexam['eid']?>.html" class="hietse <?php echo empty($status)?'xhusre':''?>">全部</a>
        <a href='/troomv2/classexam/all2-0-0-0-<?php echo $myclass['classid']?>-<?php echo $myexam['eid']?>.html?status=1'class="hietse <?php echo $status == 1?'xhusre':''?>">已交作业</a>
        <a href='/troomv2/classexam/all2-0-0-0-<?php echo $myclass['classid']?>-<?php echo $myexam['eid']?>.html?status=2' class="hietse <?php echo $status==2?'xhusre':''?>">未交作业</a>
        <a class="jaddre" href="/troomv2/statisticanalysis/scexcel.html?eid=<?=$myexam['eid']?>" style="right:40px;top:-38px;"> 导出excel</a>
    </div>

    <div class="workdata" style="float:left;margin-top:0;">
        <table class="datatab" width="100%" cellspacing="0" cellpadding="0" style="border:none;">
            <tbody>
            <tr class="first">
                <td width="25%">个人信息</td>
                <td width="35%">提交时间/评语</td>
                <?php if($status==2){?>
                    <td width="10%" class="completetime" style="text-align: center;">用时</td>
                    <td width="10%" class="totalscore" style="text-align: center;">得分</td>
                <?php }else{?>
                    <td width="10%" class="completetime" style="text-align: center;cursor:pointer;">用时
                        <i></i>
                    </td>
                    <td width="10%" class="totalscore" style="text-align: center;cursor:pointer;">得分<i></i></td>
                <?php }?>

                <td width="20%" style="text-align: center;">操作</td>
            </tr>
            <?php if(!empty($list)){ foreach($list as $v){?>
                <tr class="">
                    <td style="word-break: break-all; word-wrap:break-word;">
                        <?php
                        if($v['sex'] == 1)
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                        else
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                        $face = empty($v['face']) ? $defaulturl:$v['face'];
                        $face = str_replace('.jpg','_50_50.jpg',$face);
                        ?>
                        <a title="<?php echo empty($v['realname'])?$v['username']:$v['realname']?>" href="javascript:;" style="float:left;">
                            <img class="imgyuan" src="<?php echo $face?>">
                        </a>
                        <p class="ghjut" style="width:160px">
                            <?php echo shortstr(empty($v['realname'])?$v['username']:$v['realname'],20)?>
                            <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/<?php if($v['sex'] ==1){ echo 'women';}else{echo 'man';}; ?>.png">
                        </p>
                        <p class="ghjut" style="width:160px;color:#999;"><?php echo shortstr($v['username'],20)?></p>
                    </td>
                    <td>
                        <p><?= (empty($v['dateline'])|| $v['status']==0)?'--':(date('Y-m-d H:i',$v['dateline'])) ?></p>
                        <p style="color:#999;" title="<?php if(!empty($v['remark']))echo $v['remark']?>"><?php if(!empty($v['remark']))echo shortstr($v['remark'],36) ?></p>
                    </td>
                    <td style="text-align: center;"><?= (!empty($v['aid']) && $v['status']!=0)?ceil($v['completetime']/60).' 分钟':'--'?></td>
                    <td style="text-align: center;"><?php if(!empty($v['totalscore'])){echo $v['totalscore'].'分';}else{ echo '--';}?></td>
                    <td>
                        <?php if(!empty($v['status'])&&!empty($v['aid'])){?>
                            <a class="waskes" href="http://exam.ebanhui.com/etmark/<?=$v['aid']?>.html?crid=<?=$roominfo['crid']?>" target="_blank">批阅</a>
                            <a class="shansge" href="javascript:;" onclick="deleteanswer('<?=$v['aid']?>','<?=$v['eid']?>','<?=$v['uid']?>')" title="删除"></a>
                        <?php }else{?>
                            <span class="jierty" style="padding-left: 45px;">未交作业</span>
                        <?php }?>
                    </td>
                </tr>
            <?php }}else{?>
                <tr>
                    <td colspan="5" style="border-bottom: none"><div class="nodata"></div></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
</body>
<script type="text/javascript">
    <?php if($status!=2){?>
    var order = '<?= $sort ?>';
    $(".completetime").click(function(){
        if(order=="1") {
            location.href='<?= geturl('troomv2/classexam/all2-0-2-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>?status=<?=$status?>';
        }else{
            location.href='<?= geturl('troomv2/classexam/all2-0-1-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>?status=<?=$status?>';
        }
    });
    $(".totalscore").click(function(){
        if(order=="3") {
            location.href='<?= geturl('troomv2/classexam/all2-0-4-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>?status=<?=$status?>';
        }else{
            location.href='<?= geturl('troomv2/classexam/all2-0-3-0-'.$myclass['classid'].'-'.$myexam['eid']) ?>?status=<?=$status?>';
        }
    });
    <?php }?>
    function deleteanswer(aid,eid,uid) {
        if(!confirm('删除后学生要重新提交作业,确定要删除吗？')){
            return false
        }
        var url = '<?= geturl('troomv2/classexam/deleteanswer') ?>';
        $.post(url,{'aid':aid,'eid':eid,'uid':uid},function(data){
            if(data==1){
                $.showmessage({
                    img		 : 'success',
                    message  :  '删除成功',
                    title    :      '删除      成功',
                    timeoutspeed    :       500,
                    callback :    function(){
                        location.reload();
                    }
                });
            }else{
                $.showmessage({
                    img		 : 'error',
                    message  :  '删除失败',
                    title    :      '删除      失败',
                    timeoutspeed    :       500
                });
            }
        });
        return false;

    }
    $(function(){
        $('.datatab tr:last td').css('border-bottom','none');
    });

</script>
</html>
