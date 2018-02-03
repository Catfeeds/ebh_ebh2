<?php $this->display('troomv2/room_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css" />
<style type="text/css">
.lefrig{
    margin: 0 auto;
    float: none;
}
a.close-1{
    width: 112px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    background: #5283FC;
    color: #fff;
    font-size:13px;
    border-radius:2px;
    display: block;
    margin:0 auto;
    position: absolute;
    bottom: 20px;
    left: 56%;
    margin-left: -112px;
}
</style>
<body>
<div class="lefrig">
<div style="display:inline-block;width:100%;">
	<span class="detailtitle">题目</span>
    <div class="detailviews"><?php echo $question['title'];?></div>
	<span class="detailtitle">当前状态<b class="detailnumber">&nbsp;&nbsp;上交人数：<?php echo $question['count'];?>/<?php echo $totalcount;?></b></span>
    <p class="sexqueue1-1">
    <!--判断一下当进度当进度大于等于7%小于等于96%时为b添加class="jdtico"-->
    <?php if($totalcount == 0){
            $persent = 0;
        }else{
            $persent = ceil($question['count']/$totalcount*100);
        }
        ?>
        <span class="sexqueuefull1-1" id="sexqueuefull1-1" style="width:<?php echo $persent;?>%;">
        <?php if($persent >=7 && $persent <= 96){ ?>
        <b class="jdtico"></b>
        <?php }?>
        </span>
    </p>
    <span class="percentage-1"><?php echo $persent;?>%</span>
    <span class="detailtitle" style="float: left; width: 100%;">提交情况</span>
    <div class="havestudents">
    <?php if(!empty($answerlist)){?>
        <table class="datatab-1" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <?php foreach ($answerlist as $list) {?>
                <tr>
                    <td width="25%">
                        <a title="" href="javascript:;"><img class="imgyuan" src="<?php echo getavater($list);?>"></a>
                        <p class="ghjut"><?php echo getusername($list,10);?><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/<?php if($list['sex'] == 0){echo 'man';}else{echo 'women';}?>.png"></p>
                        <p class="ghjut ghjut-1"><?php echo $list['username']?></p>
                    </td>
                    <td width="55%"><span style="text-align:left;float:left;"><?php echo shortstr($list['answercontent'],220);?></span></td>
                    <td width="20%"><?php echo date('Y-m-d H:i:s',$list['dateline']);?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <?php }?>
    </div>
    <div id="page" style="margin-bottom:50px;">
    <?php if(!empty($pagestr)){
        echo $pagestr;
        }
        ?>
    </div>
    <a href="javascript:void(0)" class="close-1">关闭</a>
</div>
</div>
</body>
<script type="text/javascript">
var icqid = <?php echo $icqid;?>;
var page = <?php echo $page;?>;
var url = '/troomv2/iacourse/detail/'+icqid+'-'+page+'-0-0.html?type=3';
function refresh(){
    $.ajax({
        type:'post',
        url:url,
        dataType:'json',
        data:{icqid:icqid},
        success:function(data){
             if(data.status == 1){
                $("#sexqueuefull1-1").css('width',data.persent+'%');
                if(data.persent >=7 && data.persent <= 96){
                    $("#sexqueuefull1-1").html('<b class="jdtico"></b>');
                }else{
                    $("#sexqueuefull1-1").html('');
                }
                $('.detailnumber').html('&nbsp;&nbsp;上交人数：'+data.answerscount+'/'+data.totalcount);
                $('percentage-1').html(data.persent+'%');
                var html = '<table class="datatab-1" width="100%" cellspacing="0" cellpadding="0"><tbody>';
                $.each(data.answerlist,function(v,i){
                  html+='<tr><td width="25%"><a title="" href="javascript:;"><img class="imgyuan" src="'+i['face']+'"></a><p class="ghjut">'+i['realname']+'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/';
                  if(i['sex'] == 0){
                    html+='man';
                  }else{
                    html+='women';
                  }
                  html+='.png"></p><p class="ghjut ghjut-1">'+i['username']+'</p></td><td width="55%"><span style="text-align:left;float:left;" title="'+i['answercontent']+'">'+i['answercontentshort']+'</span></td><td width="20%">'+i['dateline']+'</td></tr>';  
                })
                html+='</tbody></table>';
                $('.havestudents').html(html);
                $('#page').html(data.pagestr);
             }
        }
    });
}
refresh();
$('.close-1').on('click',function(){
    window.close();
});
setInterval('refresh()',5000);
</script>
</html>
