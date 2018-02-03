<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<style>

</style>

<body>
<div class="lsitit" >
<div class="lefstr" style="padding-bottom:20px;background:white; width:998px;">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css?v=20160422" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>

<style>
body{
  background: white;
}
.dtkywe {
    height: 35px;
    position: absolute;
    right: 14px;
    top: 4px;
    width: 160px;
}
.work_mes a.workbtns{ margin-left:245px;}
</style>

    <div class="stktitl">
        <div style="clear:both;"></div>
        <div class="diles" >
            <?php
                $q= empty($q)?'':$q;
                if(!empty($q)){
                    $stylestr = 'style="color:#000"';
                }else{
                    $stylestr = "";
                }
            ?>
        </div>
        
    </div>
    <?php 
        // $idx = $this->input->get('selidx');
        for($i=0;$i<7;$i++){
            if($i==1)
                $selclass[$i] = 'class="sel"';
            else
                $selclass[$i] = '';
        }
        $itemid = $this->input->get('itemid');
        $itemstr1 = empty($itemid)?'':('?itemid='.$itemid);
        $itemstr2 = empty($itemid)?'':('&itemid='.$itemid);
    ?>
    <div class="nav_list">
    <div class="nav_listson">
      <li><a <?=$selclass[0]?> href="<?=geturl('ke/study/cwlist/'.$folder['folderid']) ?>">课程目录</a></li>
      <li><a <?=$selclass[1]?> href="<?=geturl('ke/study/introduce/undercourse/'.$folder['folderid'])?>">课程介绍</a></li>
      <li><a <?=$selclass[5]?> href="<?=geturl('jingpin/cwteacher').'?folderid='.$folder['folderid'] ?>">任课教师</a></li>
      <li><a <?=$selclass[2]?> href="<?=geturl('jingpin/myexam/all').'?folderid='.$folder['folderid']?>">相关作业</a></li>
      <li><a <?=$selclass[3]?> href="<?=geturl('jingpin/myask/all').'?folderid='.$folder['folderid']?>">互动答疑</a></li>
      <li><a <?=$selclass[4]?> href="<?=geturl('jingpin/attachment').'?folderid='.$folder['folderid']?>">资料下载</a></li>
      <li><a <?=$selclass[6]?> href="<?=geturl('ke/surveylist').'?folderid='.$folder['folderid']?>">调查问卷</a></li>
    </div>
  </div>
<div class="coursecat">
    <div class="coursecatson">
        <div class="lvjies">
            <h1 style="position:relative"><?=$folder['foldername']?></h1>
            <p class="topjie"><?=$folder['summary']?></p>
            
            <?=$folder['detail']?>
        </div>
        <div class="courselists">
        <?php if(!empty($folder['introduce'])){?>
            <?php foreach($folder['introduce'] as $k=>$introduce){?>
            <div class="kecjs  mt25">
                <h2><?=$introduce['title']?></h2>
                <p><?=$introduce['content']?></p>
            </div>
            <?php }
            }?>
        </div>
    </div>
</div>
</div>
</div>
<script>
var searchtext = "请输入搜索关键字";
$(function(){
    // initsearch("title",searchtext);
    $('.diles').hide();
});
function initsearch(id,value) {
   if($("#"+id).val() == "") {
       $("#"+id).val(value);
       $("#"+id).css("color","#A5A5A5");
   }
   if($("#"+id).val() == value) {
       $("#"+id).css("color","#A5A5A5");
   }
   $("#"+id).click(function(){
       if($("#"+id).val() == value) {
           $("#"+id).val("");
           $("#"+id).css("color","#323232");
       }
   });
   $("#"+id).blur(function(){
       if($("#"+id).val() == "") {
           $("#"+id).val(value);
           $("#"+id).css("color","#A5A5A5");
       }
   });
}
</script>
</body>
</html>
