<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js"></script>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css<?=getv()?>"/>
<style type="text/css">
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
    _margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 950px;
}
.category_cont1 div a.curr, .category_cont1 div a:hover, .price_cont div a:hover, .price_cont div a.curr {
    background: none repeat scroll 0 0 #5e96f5;
    color: #FFFFFF;
    text-decoration: none;
    border-radius:2px;
    padding:2px !important;
    font-size:14px;
}
.category_cont1 div a {
    color: #397DC1;
    text-decoration: none;
    padding: 2px;
    cursor: pointer;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
    padding:0 10px;
}
.workcurrent a span{
    color: #408BEB;
}
.voice-player{
    margin-top:0;
    margin-bottom:10px; 
}
body{
	font-family:微软雅黑;
}
.rewardpoints{
    font-weight: bold;
}
</style>
<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
<?php $room_type = Ebh::app()->room->getRoomType();$room_type = ($room_type == 'com') ? 1 : 0;?>
<body>
<div class="waitite" style="background-color:white;">
	<div class="work_menu" style="position:relative;margin-top:0">
		<ul>
			<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
		</ul>
	</div>
	<a href="<?= geturl('troomv2/myask/addquestion') ?>" class="jaddre">提个问题</a>
	<div class="diles">
		<?php
			$q= empty($q)?'':$q;
			if(!empty($q)){
				$stylestr = 'style="color:#000"';
			}else{
				$stylestr = "";
			}
		?>
		<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=$q = empty($q) ? '请输入关键字':$q;?>" type="text" />
		<input id="ser" type="button" class="soulico" value="" onclick="_search(<?= $checkfolderid = empty($checkfolderid) ? 0 : $checkfolderid;?>)">
	</div>
</div>
<div class="lefrig">
    <div class="lefrig-1" style="display: inline-block;width:100%;">
        <!--问题导航-->
        <div class="work_mes work_mesalone">
        <ul class="extendul">
            <li <?php if($method == 'askme'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/askme') ?>"><span>提给我的</span></a></li>
            <li <?php if($method == 'index'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask') ?>"><span>课程问题</span></a></li>
            <li <?php if($method == 'classquestion'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/classquestion') ?>"><span><?= $room_type==1?'部门问题':'班级问题'?></span></a></li>
            <li <?php if($method == 'allquestion'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/allquestion') ?>"><span>全部问题</span></a></li>
            <li <?php if($method == 'myquestion'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/myquestion') ?>"><span>我的问题</span></a></li>
            <li <?php if($method == 'myanswer'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/myanswer') ?>"><span>我的回答</span></a></li>
            <li <?php if($method == 'myfavorit'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/myfavorit') ?>"><span>我的关注</span></a></li>
            <!-- 新增 -->
            <li <?php if($method == 'settled'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/settled') ?>"><span>已解决</span></a></li>
            <li <?php if($method == 'hot'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/hot') ?>"><span>热门</span></a></li>
            <li <?php if($method == 'recommend'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/recommend') ?>"><span>推荐</span></a></li>
            <li <?php if($method == 'wait'){echo 'class="workcurrent"';}?>><a href="<?= geturl('troomv2/myask/wait') ?>"><span>等待回复</span></a></li>
            <li><a href="/troomv2/myask/tjfx.html"><span style="color:#ff9500;">统计分析</span></a></li>
        </ul>
    </div>
        <div class="clear"></div>
        <?php if($method == 'index'){?>
        <div id="icategory" class="clearfix" style="border-top:none;">
            <dl>
            <dd>
                <div class="category_cont1">
                    <div>
                        <a tag=0 onclick="_search(0)" <?= empty($checkfolderid) ? 'class="curr"' : ''?> >所有课程</a>
                    </div>
                    
                                <?php foreach ($folders as $folder) { ?>
                    <div>
                        <a  <?php  if(!empty($checkfolderid)&&($checkfolderid==$folder['folderid'])){echo 'class=curr';}?> onclick="_search(<?=$folder['folderid']?>)" tag="<?=$folder['folderid']?>" ><?=$folder['foldername']?></a>
                    </div>
                                <?php } ?>

                </div>
            </dd>
            </dl>
        </div>
        <?php }else if($method == 'classquestion'){?>
            <div id="icategory" class="clearfix" style="border-top:none;">
                <dt></dt>
                <dd>
                    <div class="category_cont1">
                        <div>
                            <a tag=0 onclick="_searchclass(0)" <?= empty($checkclassid) ? 'class="curr"' : ''?> >所有班级</a>
                        </div>
                        
                                    <?php foreach ($tClasses as $tClasse) { ?>
                        <div>
                            <a  <?php  if(!empty($checkclassid)&&($checkclassid==$tClasse['classid'])){echo 'class=curr';}?> onclick="_searchclass(<?=$tClasse['classid']?>)" tag="<?=$tClasse['classid']?>" ><?=$tClasse['classname']?></a>
                        </div>
                                    <?php } ?>

                    </div>
                </dd>
            </div>
        <?php }?>
        <!--问题列表-->
        <div class="problemslist ">
            <?php
            if(empty($asks)){
              echo " <div class=\"nodata\"></div>";
            }else{
            ?>
            <ul>
            <?php foreach ($asks as $k => $ask) { ?>
                <?php 
                $coverimg = array();
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                 ?>
                 <?php if(count($coverimg) != 1){?>
                <li>
                    <h2 class="problemstitle">
                    <?php if($ask['hasbest']){?>
                        <span class="problemstitleico" title="已有正确答案"></span>
                    <?php }?>
                    <?php if(!empty($ask['reward'])){ ?>
                        <span class="rewardpoints" title="悬赏<?= $ask['reward']?>积分"><?php echo $ask['reward'];?></span>
                    <?php }?>
                    <a href="/troomv2/myask/<?= $ask['qid'];?>.html" target="_blank"><?php echo $ask['title'];?></a></h2>
                    <div class="problemdetail"><a href="/troomv2/myask/<?= $ask['qid'];?>.html"  target="_blank" title="<?=strip_tags($ask['message']);?>"><?php echo shortstr(strip_tags($ask['message']),300);?></a></div>
                    <div class="answernumber">
                        <span class="answernumberspan">回答数</span>
                        <span><b class="b1"><?php echo $ask['answercount'];?></b><b class="b2">/</b><b class="b3"><?php echo $ask['viewnum']?></b></span>
                    </div>
                    <?php if(!empty($audio)){?>
                        <?php foreach ($audio as $j => $au) { ?>
                    <div class='audioplayer' id='audioplayer_<?php echo $k?>_<?php echo $j?>'></div>
                    <script type="text/javascript">
                        $(function () {
                            voicePlayer({
                                box: $("#audioplayer_<?php echo $k?>_<?php echo $j?>"),
                                src: "<?php echo $au['src'];?>",
                                time: <?php echo $au['time'];?>
                            }).show();
                        })
                    </script>
                        <?php }?>
                    <?php }?>
                    <?php if(!empty($coverimg)){?>                    
                    <ul class="questionerpic-1">
                    <?php foreach ($coverimg as $img) { ?>
                        <li><a href="/troomv2/myask/<?= $ask['qid'];?>.html" target="_blank"><img style="width:180px;height:100px;" src="<?php echo $img;?>" /></a></li>
                        <?php }?>
                    </ul>
                    <?php }?>
                    <div class="questinformation-1">
                    
                        <span  class="questiontime-<?php if((SYSTIME - $ask['dateline']) > (86400*3) ){echo '2';}else{echo '1';}?>"><?php echo timetostr($ask['dateline'],'Y-m-d');?></span>
                        <img class="questionerhead" src="<?php echo getavater($ask);?>" />
                        <span class="questioner" title="<?= getusername($ask)?>"><?php echo getusername($ask,8)?></span>
                        <p class="coursewarelink">
                        <?php 
                        if(!empty($ask['foldername'])){ ?>
                            <a href="javascript:void(0)">
                            <?php echo $ask['foldername'];?>
                            </a>
                            <?php } ?>
                        <?php if(!empty($ask['cwid'])){ ?>
                         > <a href="javascript:void(0)"><?php echo $cwarr[$ask['cwid']];?> </a>
                        <?php } ?>
                        </p>
                    </div>
                </li>
                <?php }else{ ?>
                     <li>
                        <h2 class="problemstitle">
                        <?php if($ask['hasbest']){?>
                            <span class="problemstitleico" title="已有正确答案"></span>
                        <?php }?>
                        <?php if(!empty($ask['reward'])){ ?>
                        <span class="rewardpoints" title="悬赏<?= $ask['reward']?>积分"><?php echo $ask['reward'];?></span>
                    <?php }?><a href="/troomv2/myask/<?= $ask['qid'];?>.html" target="_blank"><?php echo $ask['title'];?></a></h2>
                        <?php if(!empty($audio)){?>
                            <?php foreach ($audio as $j => $au) { ?>
                        <div class='audioplayer' id='audioplayer_<?php echo $k?>_<?php echo $j?>'></div>
                        <script type="text/javascript">
                            $(function () {
                                voicePlayer({
                                    box: $("#audioplayer_<?php echo $k?>_<?php echo $j?>"),
                                    src: "<?php echo $au['src'];?>",
                                    time: <?php echo $au['time'];?>
                                }).show();
                            })
                        </script>
                            <?php }?>
                        <?php }?>
						<div style="*clear:both;"></div>
                        <div class="problemdetail">
                            <a href="/troomv2/myask/<?= $ask['qid'];?>.html"  target="_blank" class="imgfl"><img style="width:180px;height:100px;" src="<?php echo $coverimg[0];?>" /></a>
                            <a href="/troomv2/myask/<?= $ask['qid'];?>.html"  target="_blank" class="widthquestdetail"  title="<?=strip_tags($ask['message']);?>"><?php echo shortstr(strip_tags($ask['message']),400);?></a>
                        </div>
                        <div class="answernumber">
                            <span class="answernumberspan">回答数</span>
                            <span><b class="b1"><?php echo $ask['answercount'];?></b><b class="b2">/</b><b class="b3"><?php echo $ask['viewnum'];?></b></span>
                        </div>
                        <div class="questinformation-1">
                            <span  class="questiontime-<?php if((SYSTIME - $ask['dateline']) > (86400*3) ){echo '2';}else{echo '1';}?>"><?php echo timetostr($ask['dateline'],'Y-m-d');?></span>
                            <img class="questionerhead" src="<?php echo getavater($ask);?>" />
                            <span class="questioner" title="<?= getusername($ask)?>"><?php echo getusername($ask,8)?></span>
                            <p class="coursewarelink">
                            <?php 
                        if(!empty($ask['foldername'])){ ?>
                            <a href="javascript:void(0)">
                            <?php echo $ask['foldername'];?>
                            </a>
                            <?php } ?>
                        <?php if(!empty($ask['cwid'])){ ?>
                         > <a href="javascript:void(0)"><?php echo $cwarr[$ask['cwid']];?> </a>
                        <?php } ?></p>
                        </div>
                    </li>
                <?php }?>
                <?php }?>
            </ul>
            <?php }?>
        </div>
        <div style="text-align: center;color: #666;line-height: 32px;font-size: 14px;width:115px; margin:0 auto;display:none;" id="onloading" ><img class="ml5 fl" src="http://static.ebanhui.com/ebh/images/live_loading.gif" /><span class="fl">正在加载中</span></div>
        <div class="fl"></div>
        <?php if($pageflag){?>
        <div class="page" ><?php echo $pagestr;?></div>
        <?php }else{?>
        <div class="page" style="display:none;"><?php echo $pagestr;?></div>   
        <?php }?>
    </div>
</div>
<script type="text/javascript">
    //告诉父窗口来调pageCondition
    var p = 1;
    var flag = false;
    top.window.scrollInit();
    // 滚动条生效条件
    <?php if(!$pageflag){?>
    function pageCondition(pageC){
       if(pageC == 1){
            if($('.page').is(':hidden')){
                showflower();
                t=setTimeout("scrollshow()",1000);  
            }
       }
    }
    <?php }?>
   //显示正在加载
    function showflower(){
        $("#onloading").css('display','block');
        top.resetmain();
   }
    //关闭正在加载
   function closeflower(){
       $("#onloading").css('display','none');
       top.resetmain();
   }
    //滚动条显示
    function scrollshow(){
        if(flag == false && p < 3){
            clearTimeout(t);
            flag = true;
            if(search == undefined || search == '请输入关键字'){
                search = '';
            }
            $.ajax({
                type: 'POST',
                'url': '/troomv2/myask/<?php echo $method;?>-'+<?php echo $p?>+'-0-0.html?q='+search+'&folderid='+folderid+'&classid='+classid,
                data: {'p': p},
                dataType:'json',
                success: function (data) {
                    if(data.status == 1){
                        var html = '';
                        $.each(data.data,function(i,v){
                            if(v['cover'].length == 1){
                                html+='<li>'+
                        '<h2 class="problemstitle">';
                        if(v['hasbest'] == '1'){
                            html+='<span class="problemstitleico" title="已有正确答案"></span>';
                        }
                        if(v['reward'] != '0'){
                            html+='<span class="rewardpoints" title="悬赏'+v['reward']+'积分">'+v['reward']+'</span>';
                        }
                        html+='<a href="/troomv2/myask/'+v['qid']+'.html" target="_blank">'+v['title']+'</a></h2>';
                        if(v['audio'].length > 0){
                            $.each(v['audio'],function(j,val){
                                html+= '<div class="audioplayer" id="audioplayer_'+v['qid']+'_'+j+'"></div>'+'<script type="text/javascript">'+'$(function () {'+'voicePlayer({'+'box: $("#audioplayer_'+v['qid']+'_'+j+'"),'+'src: "'+val['src']+'",time: '+val['time']+'}).show();'+'})'+'<\/script>';
                            });
                        }
                        html+='<div class="problemdetail">'+'<a href="/troomv2/myask/'+v['qid']+'.html" target="_blank" class="imgfl"><img style="width:180px;height:100px;" src="'+v['cover'][0]+'" /></a>'+
                            '<a href="/troomv2/myask/'+v['qid']+'.html" target="_blank" class="widthquestdetail" title="'+v['message']+'">'+v['message'].substring(0,200)+'</a>'+'</div>'+'<div class="answernumber">'+'<span class="answernumberspan">回答数</span>'+'<span><b class="b1">'+v['answercount']+'</b><b class="b2">/</b><b class="b3">'+v['viewnum']+'</b></span>'+'</div>'+'<div class="questinformation-1">'+'<span class="questiontime-';
                            if(v['threeago'] == 1){
                                html+='2';
                            }else{
                                html+='1';
                            }
                            html+='">'+v['dateline']+'</span>'+
                            '<img class="questionerhead" src="'+v['face']+'" />'+
                            '<span class="questioner" title="'+v['realname']+'">'+v['realnameshort']+'</span>'+'<p class="coursewarelink">';
                            if(v['foldername'] != '' && v['foldername'] != null){
                                html+= '<a href="javascript:void(0)">'+v['foldername']+'</a>';
                            }
                            if(v['cwname'] != 0 && v['cwname'] != undefined){
                                html+= '> <a href="javascript:void(0)">'+v['cwname']+'</a>';
                            }
                            html+='</p>';
                        html+='</div>'+'</li>';
                            }else{
                            html+='<li>'+
                    '<h2 class="problemstitle">';
                    if(v['hasbest'] == '1'){
                        html+= '<span class="problemstitleico" title="已有正确答案"></span>';
                    }
                    if(v['reward'] != '0'){
                        html+='<span class="rewardpoints" title="悬赏'+v['reward']+'积分">'+v['reward']+'</span>';
                    }
                    html+='<a href="/troomv2/myask/'+v['qid']+'.html" target="_blank">'+v['title']+'</a></h2>'+'<div class="problemdetail"><a href="/troomv2/myask/'+v['qid']+'.html" target="_blank" title="'+v['message']+'">'+v['message'].substring(0,150)+'</a></div>'+'<div class="answernumber">'+'<span class="answernumberspan">回答数</span>'+'<span><b class="b1">'+v['answercount']+'</b><b class="b2">/</b><b class="b3">'+v['viewnum']+'</b></span>'+'</div>';
                    if(v['audio'].length > 0){
                        $.each(v['audio'],function(j,val){
                            html+= '<div class="audioplayer" id="audioplayer_'+v['qid']+'_'+j+'"></div>'+'<script type="text/javascript">'+'$(function () {'+'voicePlayer({'+'box: $("#audioplayer_'+v['qid']+'_'+j+'"),'+'src: "'+val['src']+'",time: '+val['time']+'}).show();'+'})'+'<\/script>';
                        });
                    }
                    if(v['cover'].length > 0){
                        html+='<ul class="questionerpic-1">';
                        $.each(v['cover'],function(k,vl){
                            html+='<li><a href="/troomv2/myask/'+v['qid']+'.html" target="_blank"><img style="width:180px;height:100px;" src="'+vl+'" /></a></li>';
                        });
                        html+='</ul>';
                    }
                    html+='<div class="questinformation-1"><span class="questiontime-';
                    if(v['threeago'] == 1){
                        html+='2';
                    }else{
                        html+='1';
                    }
                    html+='">'+v['dateline']+'</span>'+'<img class="questionerhead" src="'+v['face']+'" />'+'<span class="questioner" title="'+v['realname']+'">'+v['realnameshort']+'</span>'+'<p class="coursewarelink">';
                    if(v['foldername'] != '' && v['foldername'] != null){
                        html+= '<a href="javascript:void(0)">'+v['foldername']+'</a>';
                    }
                    if(v['cwname'] != 0 && v['cwname'] != undefined){
                        html+= '> <a href="javascript:void(0)">'+v['cwname']+'</a>';
                    }
                    html+='</p>'+'</div>'+'</li>';
                            }
                        });
                    $(".problemslist").children('ul').children('li').last().after(html);
                    }
                    removeLastClass();                   
                    if(p == 2){
                        $(".page").show();
                    }
                    if(data.pageflag == true){
                        $(".page").show();
                    }else{
                        setTimeout("flag = false;p+=1;",1000);
                    }
                    closeflower();
                }
            });  
        }    
    }
$(".listPage a").on('click',function(){
    top.topSet();
});
var searchtext = "请输入关键字";
var search = <?php echo '\''.$q.'\'';?>;
var folderid = <?= $checkfolderid = empty($checkfolderid) ? 0 : $checkfolderid;?>;
var classid = <?= $checkclassid = empty($checkclassid) ? 0 :$checkclassid;?>;
function _search(fid){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       folderid = fid;
       var url = "/troomv2/myask/<?= $method?>.html" + '?folderid='+folderid+'&q='+title;
       document.location.href = url;
}
function _searchclass(cid){
    var title = $("#title").val();
    if(title == searchtext)
        title = '';
    classid = cid;
    var url = '<?= geturl('troomv2/myask/classquestion') ?>' + '?classid='+classid+'&q='+title;
    document.location.href = url;
}
//去掉最后一个列表项的横线
function removeLastClass(){
    $(".problemslist").children('ul').children('li').css('border-bottom','1px solid #ececec');
    $(".problemslist").children('ul').children('li').last().css('border-bottom','0px');
}
removeLastClass();
$('#title').on('click',function(){
    if($(this).val() == '请输入关键字'){
        $(this).val('');
        $(this).css('color','#000');
    }
});
$('#title').on('blur',function(){
    if($(this).val() == ''){
        $(this).val('请输入关键字');
        $(this).css('color','#d2d2d2');
    }
});
</script>

</body>
</html>
