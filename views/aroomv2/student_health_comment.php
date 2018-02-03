<?php $this->display('aroomv2/room_header');?>
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" /><!--<?=getv()?>-->
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css?version=20160704001" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>


<body>
<style>
.maines{
    margin:0 auto;
}
</style>
<div style="width:1000px; margin:0 auto;">
<div class="maines">
    <div class="txtcenter">
        <?php echo $username;?>的教师评语
    </div>
    <div class="xuantse">
    <?php if(!empty($commentlist)){?>
        <table cellpadding="0" cellspacing="0" class="helathtable">
            <tr>
                <th width="70%" class="pd40">评语内容</th>
                <th width="10%">评语时间</th>
                <th width="10%">评语者</th>
                <th width="10%">操作</th>
            </tr>
            
                <?php foreach ($commentlist as $comment) { ?>
                    <?php if($comment['type'] == 0){?>
                        <tr hcid="<?php echo $comment['hcid'];?>">
                            <td width="70%" class="pd40" title="<?php echo $comment['comment'];?>"><?php echo shortstr($comment['comment'],250);?></td>
                            <td width="10%"><?php echo date('Y-m-d',$comment['dateline']);?></td>
                            <td width="10%"><?php $teachername = empty($comment['realname'])?$comment['username']:$comment['realname'];echo $teachername; ?></td>
                            <td width="10%"><a href="javascript:void(0);" class="seeview" onclick="details(<?php echo $comment['hcid'];?>)">查看详情</a></td>
                        </tr>
                    <?php }else{?>
                        <tr>
                            <td width="70%" class="pd40"><?php echo $comment['filename']?></td>
                            <td width="10%"><?php echo date('Y-m-d',$comment['dateline']);?></td>
                            <td width="10%"><?php $teachername = empty($comment['realname'])?$comment['username']:$comment['realname'];echo $teachername; ?></td>
                            <td width="10%"><a href="javascript:;" class="seeview" onclick="downloadfile(<?php echo $comment['sid'];?>)">下载</a></td>
                        </tr>
                    <?php }?>
                <?php } ?>
            
        </table>
        <?php echo $pagestr;?>
        <?php }else{?>
            <div class="nodata">
            </div>
        <?php }?>
    </div>
</div>
<div style="clear:both;"></div>
</div>
<!--弹出框 评语详情-->
<div class="pyviews" id="pyviews" style="display:none;">
    <div class="sdpy"></div>
    <div class="pymain"></div>
</div>
<script>
function details(hcid){
    var d=dialog({
        title:"评语详情",
        content:document.getElementById("pyviews"),
        padding:18
    })
    var teachername = $("[hcid ="+hcid+"]").children('td').eq(2).html();
    var comment = $("[hcid ="+hcid+"]").children('.pd40').attr('title');
    $('.sdpy').html(teachername+'的评语');
    $('.pymain').html(comment);
    d.showModal();
}

//下载方法
function downloadfile(sid){
    if(sid == '' || sid == 'undefined'){
        return false;
    }
    var url = '/troomv2/health/download/'+sid+'.html';
    window.open(url); 
}
$('.upcurpath').hide();
</script>

</body>
<?php $this->display('troomv2/room_footer');?>
</html>
