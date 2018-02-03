<?php $this->display('college/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151021"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">

<body>
<div style="margin:0 auto; width:1000px;background:white;">
	<?php
	if(!empty($folder)){
		$this->assign('selidx',5);
		$this->display('college/course_nav');
	}
	?>
    <div class="teacherlist " style="width:918px;">
	<?php if(!empty($teacher)){ 
            foreach ($teacher as $kt => $vt) {
                   if(!empty($vt['face'])){
                        $face = getthumb($vt['face'],'120_120');
                    }else{
                        if($vt['sex']==1){
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
                        }else{
                            $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
                        }
                    
                        $face = getthumb($defaulturl,'120_120');
                    } 
        ?>
        <div class="teacherlist_son">
            <div class="mt35"  style="width:920px;">
                <div class="ttouxiang fl">
                    <img src="<?= $face?>" width="120" height="120" style="border-radius:60px;" /><span class="dengji">等级：<?=$vt['jifen_data']?></span>
                </div>
                <div class="jieshao fl">
                    <div>
                        <div class="fl"><span class="span1s"><?= empty($vt['realname'])?$vt['username']:$vt['realname'] ?></span><span class="span2s">&nbsp;老师</span></div>
                        <div class="fl ml55 xingji">
                            <ul>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                                <li class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/pijias.png" width="18" height="18" /></li>
                            </ul>
                        </div>
                        <div class="fl ml15 xingjis"><span class="span3s">5.0</span><span class="span4s">&nbsp;分</span></div>
                    </div>
                    <div class="clear"></div>
                    <div class="qiangming" title="<?= $vt['mysign']?>"><p><span>个性签名：<?= !empty($vt['mysign'])?shortstr($vt['mysign'],84):'暂无签名'?></span></p></div>
                    <div class="qiangmings" style="display:none;"><p><span>暂无签名</span></p></div>
                    <div class="mt5">
                        <table cellpadding="0" cellspacing="0" class="tables">
                            <tr>
                                <td>讲课</td>
                                <td>总课时</td>
                                <td>布置作业</td>
                                <td>解答</td>
                                <td>评论</td>
                            </tr>
                            <tr>
                                <td><span><?= $vt['coursewarecount']?></span>节</td>
                                <td><span><?= round($vt['coursewarecwlength']/60)?></span>分钟</td>
                                <td><span><?= $vt['examcount']?></span>份</td>
                                <td><span><?= $vt['askcount']?></span>次</td>
                                <td><span><?= $vt['reviewcount']?></span>次</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="fr"><a href="javascript:;" class="sixin" tid="<?=$vt['tid']?>" tname="<?= empty($vt['realname'])?$vt['username']:$vt['realname'] ?>" title="给<?=$vt['sex'] == 1 ? '她' : '他'?>发私信">私&nbsp;信</a></div>
            </div>
            <div class="clear"></div>
            <div><p class="jianjies">简介：<?= $vt['profile']?></p></div>
        </div>
	<?php }} else { ?>
        <div class="teacherlist_son nodata">
        </div>
    <?php } ?>

    </div>
</div>

<!--发送私信dialog start-->
<div class="waiyry clearfix" id="wxDialog" style="display:none;width:698px;margin:0;padding:30px 44px;">
<div class="chouad" style="height:auto">
<span class="shyten">收件人：</span>
<div class="ewater" style="height:36px;">
<ul id="wrap2"></ul>
</div>
</div>
<textarea class="txttiantl" name="summary" style="font-size:14px;"></textarea>
<div class="wtkkr" style="height:45px;">
内容不超过500字
<a id="sendmessage" class="msgsendbtn">发 送</a>
</div>

</div>
<script type="text/javascript">
$(function(){
    $("#clearmessge").click(function(){
        $("textarea.txttiantl",parent.document).val("");
    });
    
    $("#sendmessage").click(function(){
        var msg =  $.trim($("textarea.txttiantl",parent.document).val());
        var tid = $("#wrap2 li:first",parent.document).attr("tid");
        
        if($("#wrap2",parent.document).html() == ''){
            alert("收件人错误");
            return;
        }
        if(msg.length==0){
            alert('请输入内容');
            return;
        } else if(msg.length>500){
            alert('内容不超过500字');
            return;
        }
        $.ajax({
            type: "POST",
            url: "<?=geturl('myroom/msg/do_send')?>",
            data:{tid:tid, msg:msg},
            success:function(res){
                if(res=="1"){
                    parent.window.showSendSuccess();
                }else{
                    parent.window.showSendFail();
                } 
            }
        });
    });
    
    $(".sixin").click(function(){
        parent.window.H.get('wxDialog').exec('show');
        //每次打开重置收件人和信息内容
        $("#wrap2",parent.document).html("");
        $("textarea.txttiantl",parent.document).val("");
        //添加收件人
        var tid = $(this).attr("tid");
        var tname = $(this).attr("tname");
        $("#wrap2",parent.document).append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');  
        //焦点对话框
        $("textarea.txttiantl",parent.document).focus();
    });
    
    //创建dialog
    parent.window.H.remove('wxDialog');
    $('#wxDialog',parent.window.document.body).remove();
    parent.window.H.create(new P({
        id:'wxDialog',
        title:'发私信',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');
    
});

$(function(){
    var searchtext = "请输入教师姓名搜索";
    initsearch("title",searchtext);
    $("#ser").click(function(){
        var title = $("#title").val();
        if(title == searchtext) 
        title = "";
        var url = '<?= geturl('college/cwteacher') ?>' + '?q='+title;
        <?php if(!empty($folder)){
            $itemid = $this->input->get('itemid');?>
        url += '&folderid=<?=$folder['folderid']?>';
        url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
        <?php }?>
        document.location.href = url;
    });
    <?php if(!empty($folder)){?>
        $.each($('.work_menu li a'),function(k,v){
            $(this).attr('href',$(this).attr('href')+'?folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
        });
    <?php }?>
});
</script>
<!--发送私信dialog end-->
</body>
</html>
