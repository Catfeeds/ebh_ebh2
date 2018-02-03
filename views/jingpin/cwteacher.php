<?php $this->display('college/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151021"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
    body{
        background: white;
    }
</style>
<body>
<div style="margin:0 auto; width:1000px;background:white;">
	<?php
	if(!empty($folder)){
		$this->assign('selidx',5);
		$this->display('jingpin/course_nav');
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
                    <img src="<?= $face?>" width="120" height="120" /><span class="dengji">等级：<?=$vt['jifen_data']?></span>
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
                
            </div>
            <div class="clear"></div>
            <div><p class="jianjies">简介：<?= $vt['profile']?></p></div>
        </div>
	<?php }} else { ?>
        <div class="teacherlist_son nodata" >
        </div>
    <?php } ?>

    </div>
</div>

</div>
<script type="text/javascript">

$(function(){
    var searchtext = "请输入教师姓名搜索";
    initsearch("title",searchtext);
    $("#ser").click(function(){
        var title = $("#title").val();
        if(title == searchtext) 
        title = "";
        var url = '<?= geturl('jingpin/cwteacher') ?>' + '?q='+title;
        <?php if(!empty($folder)){
            $itemid = $this->input->get('itemid');?>
        url += '&folderid=<?=$folder['folderid']?>';
        //url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
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
