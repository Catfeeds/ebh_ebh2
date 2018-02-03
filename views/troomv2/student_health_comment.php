<?php $this->display('troomv2/room_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css<?=getv()?>" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css<?getv()?>">
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/ebhDialog.js"></script>
<style>
.maines{
    margin:0 auto;
}
body{
	background:#f2f2f2;
}
</style>
<div style="width:1000px; margin:0 auto;">
<div class="maines">
	<div class="txtcenter">
    	<?php echo $username;?>的教师评语
    </div>
    <a href="javascript:lrpyfa()" class="lrpy" >录入评语</a>
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
                        <tr hcid="<?php echo $comment['hcid']?>">
                            <td width="70%" class="pd40" title="<?php echo $comment['comment'];?>"><?php echo shortstr($comment['comment'],250);?></td>
                            <td width="10%"><?php echo date('Y-m-d',$comment['dateline']);?></td>
                            <td width="10%"><?php $teachername = empty($comment['realname'])?$comment['username']:$comment['realname'];echo $teachername; ?></td>
                            <td width="10%"><a href="javascript:void(0);" class="seeview" onclick="details(<?php echo $comment['hcid']?>)">查看详情</a></td>
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
    <div class="pymain" id="commentdetail"></div>
</div>
<!--弹出框 录入评语-->
<div class="pyviews" id="lrpy" style="display:none;">
	<div class="lrpyfs">
    	<span>录入方式：</span>
    	<select id="choose">
        	<option value="0">直接录入</option>
            <option value="1">上传文档</option>
        </select>
    </div>
    <div id="upload" style="display:none;margin-left:85px;float:left;height:292px">
    <?php 
    $accept = array('jpg','png','gif','doc','xls','xlsx','docx','ppt','rar','zip');
    Ebh::app()->lib('Webuploader')->renderHtml('picker',false,array(),array('fileSizeLimit'=>20971520,'acceptextensions'=>$accept));?>
    <span id="msg">请选择要上传的文件，文件大小不超过20M。</span>
    </div>
    <textarea class="pymain" id="comment" style="width:613px"></textarea>
</div>
<script>
function details(hcid){
	var d=dialog({
		title:"评语详情",
		content:document.getElementById("pyviews"),
		padding:18
	});
    var teachername = $("[hcid ="+hcid+"]").children('td').eq(2).html();
    var comment = $("[hcid ="+hcid+"]").children('.pd40').attr('title');
    $('.sdpy').html(teachername+'的评语');
    $('#commentdetail').html(comment);
	d.showModal();
}
var type = 0;
function lrpyfa(){
	var d=dialog({
		title:"录入评语",
		content:document.getElementById("lrpy"),
		padding:18,
		okValue:"提交",
		ok:function(){
            if(type == 0){
                var comment = $('#comment').val();
                comment = $.trim(comment);
                var url = '/troomv2/health/comment/add.html';
                var tid = <?php echo $user['uid'];?>;
                var studentid = <?php echo $studentid;?>;
                if(comment.length >800){
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='PPic'></div><span>评语字数不能超过800字！</span>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function () {
                                that.close().remove();
                            }, 2000);
                        }
                    }).showModal(); 
                    setTimeout('lrpyfa()',2000);
                    return;
                }
                if(comment.length == 0){
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='PPic'></div><span>评语不能为空！</span>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function () {
                                that.close().remove();
                            }, 2000);
                        }
                    }).showModal(); 
                    setTimeout('lrpyfa()',2000);
                    return;
                }
                $.ajax({
                    url:url,
                    type:'post',
                    data:{'tid':tid,'studentid':studentid,'comment':comment,'type':type},
                    dataType:'json',
                    success:function(data){
                        if(data.status == 1){
                           window.location.href = location.href;
                        }else{
                            dialog({
                            skin:"ui-dialog2-tip",
                            content:"<div class='PPic'></div><span>添加失败，请重试</span>",
                            width:350,
                            onshow:function () {
                                var that=this;
                                setTimeout(function () {
                                    that.close().remove();
                                }, 2000);
                        }
                    }).showModal(); 
                                setTimeout('lrpyfa()',2000);
                                return;
                        }
                    }
                });
            }else{
                var sid = $('.picker_file_list').children('li').first().children('input').first().val();
                var filename = $('.picker_file_list').children('li').first().children('input').eq(2).val();
                var url = '/troomv2/health/comment/add.html';
                var tid = <?php echo $user['uid'];?>;
                var studentid = <?php echo $studentid;?>;
                if((sid == '' || sid == undefined) || (filename == '' || filename == undefined)){
                    dialog({
                        skin:"ui-dialog2-tip",
                        content:"<div class='PPic'></div><span>上传资源不能为空</span>",
                        width:350,
                        onshow:function () {
                            var that=this;
                            setTimeout(function () {
                                that.close().remove();
                            }, 2000);
                        }
                    }).showModal();
                    if ((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
                            setTimeout('reflash()',2000);   
                            return;
                        }else{
                            setTimeout('lrpyfa()',2000);
                            return;
                    }
                }
                $.ajax({
                    url:url,
                    type:'post',
                    data:{'tid':tid,'studentid':studentid,'sid':sid,'type':type,'filename':filename},
                    dataType:'json',
                    success:function(data){
                        if(data.status == 1){
                          window.location.href = location.href;
                        }
                    }
                });
            }
        }
	});
	d.showModal();
}
function reflash(){
    window.location.href = location.href;
}
$("#choose").change(function(){
    type = $(this).val();
    if(type == 0){
        $('#upload').hide();
        $('#comment').show();
    }
    if(type == 1){
        $('#upload').show();
        $('#comment').hide();
    }
    $('.webuploader-pick').next().css('height','32px');
});

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
<?php $this->display('troomv2/room_footer');?>
</body>

</html>
