<?php $this->display('troomv2/room_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/interactive.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
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
<script type="text/javascript">
$(function() {
    try{
    $('.box a').lightBox();
    }catch(error){}
});
</script>
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
    <div class="submittedlist-1">
    <?php if(!empty($answerlist)){?>
        <ul class="imglist">
        <?php foreach ($answerlist as $list) {?>
            <li>
                <div class="box"><a href="<?php echo $list['answercontent'];?>"><img src="<?php echo $list['answercontent'];?>" style="width:132px;height:132px;background-color:white;"></a><span></span></div>
                <p class="p1s"><?php echo getusername($list,10);?></p>
                <p class="p1s"><?php echo date('Y-m-d H:i:s',$list['dateline']);?></p>
            </li>
        <?php }?>
         </ul>
         <?php } ?>
    </div>
    <div id="page" style="margin-bottom:50px;"><?php if(!empty($pagestr)){echo $pagestr;}?></div>
    <a href="javascript:void(0)" class="close-1">关闭</a>
</div>
</div>
<script type="text/javascript">
var icqid = <?php echo $icqid;?>;
var page = <?php echo $page;?>;
var url = '/troomv2/iacourse/detail/'+icqid+'-'+page+'-0-0.html?type=2';
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
                var html = '<ul class="imglist">';
                $.each(data.answerlist,function(v,i){
                  html+='<li><div class="box"><a href="'+i['answercontent']+'"><img src="'+i['answercontent']+'" style="width:132px;height:132px;background-color:white;"></a><span></span></div><p class="p1s">'+i['realname']+'</p><p class="p1s">'+i['dateline']+'</p></li>';  
                })
                html+='</ul>';
                $('.submittedlist-1').html(html);
                imgdialog();
                $('#page').html(data.pagestr);
             }
        }
    });
}
refresh();
function imgdialog(){
    $('.box a').lightBox();
}
$('.close-1').on('click',function(){
    window.close();
});
setInterval('refresh()',5000);
</script>
</body>
</html>
