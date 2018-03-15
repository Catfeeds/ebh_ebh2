<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $v=getv();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20170718001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=$v?>" />

</head>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2016/css/titlecs.css<?=$v?>" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/courseware.css<?=$v?>" />

<?php //最新课程,今天起的7天内
	if(!empty($newcwlist)){
?>
<div class="jijiangkk" style="margin-bottom:10px;float:right">
	<h2 style="border-bottom: 1px solid #efefef;">最新课程</h2>
    <div class="jijiangkk_son">
		<?php $i=0;
		$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');
		// $deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
		$lineimgarr[1]['todayunstart'] = 1;
		$lineimgarr[1]['now'] = 7;
		$lineimgarr[1]['unstart'] = 4;
		$lineimgarr[1]['end'] = 5;
		
		$lineimgarr[0]['todayunstart'] = 3;
		$lineimgarr[0]['now'] = 8;
		$lineimgarr[0]['unstart'] = 2;
		$lineimgarr[0]['end'] = 6;
		foreach($newcwlist as $k=>$listbyday){
			$find = array('x','y','z');
			$replace = '';
			$k = str_replace($find,$replace,$k);
			foreach($listbyday as $cw){
				$i++;
				$lineimgtype = intval(($i-1)%$pagesize==0); //第一位还是其他
				$page = ceil($i/$pagesize);
				$arr = explode('.',$cw['cwurl']);
				$type = $arr[count($arr)-1];
				$isVideotype = in_array($type,$mediatype) || $cw['islive'] == 1;
				// $target=(empty($cw['cwurl']) || $isVideotype) ? '_blank' : '_blank';
				$target = '_blank';
				$deflogo = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.($isVideotype?($cw['islive']?'livelogo.jpg':'defaultcwimggray.png'):'kustgd2.png');
				if($isVideotype){
					$playimg = 'kustgd2';
				}elseif(strstr($type,'ppt')){
					$playimg = 'ppt';
				}elseif(strstr($type,'doc')){
					$playimg = 'doc';
				}elseif($type == 'rar' || $type == 'zip' || $type == '7z'){
					$playimg = 'rar';
				}elseif($type == 'mp3'){
					$playimg = 'mp3';
				}elseif($cw['islive'] == 1){
					$playimg = 'kustgd';
				}else{
					$playimg = 'attach';
				}
				
				$logo = (!empty($cw['logo']) && $isVideotype)?$cw['logo']:$deflogo;
			
		?>
    	<div class="jjikk_sons cwlistpage cwlistpage<?=$page?>" <?=$page>1?'style="display:none"':''?>>
    	
			<?php if($k=='今天'){?>
			<!-- 正在上课 当前时间在课程发布时间+课件时间范围内 显示正在上课 -->
			<!-- 即将开始上课  当前时间还未到课件发布时间的 显示橙色 -->
			<!-- 已经结束的  当前时间已经超过课件发布+播放时间 显示灰色-->
			<?php 
			$starttime = $cw['truedateline'];
			$cwlenth = $cw['cwlength'];//课件时长
			$nowtime = SYSTIME;
			$html = '';
			if($nowtime <= $starttime){
			    //即将开始
			    $html = '<div class="fl jjikk_sons_l">'.date('H:i',$starttime).'&nbsp;</div>';
				$lineimg = $lineimgarr[$lineimgtype]['todayunstart'];
			}elseif(!empty($cwlenth) && ($nowtime>=$starttime) && (($starttime+$cwlenth) >= $nowtime) && (empty($cw['endat']) || $cw['endat']>=$nowtime)){
			    //正在上课
			    $html = '<div class="fl jjikk_sons_l starting">正在上课...&nbsp;</div>';
				$lineimg = $lineimgarr[$lineimgtype]['now'];
			}elseif($nowtime > ($starttime+$cwlenth) || (!empty($cw['endat']) && $nowtime>$cw['endat'])){
			    //已结束
			    $html = '<div class="fl jjikk_sons_l '.(($starttime<SYSTIME)?'expired':'').'">'.date('H:i',$starttime).'&nbsp;</div>';
				$lineimg = $lineimgarr[$lineimgtype]['end'];
			}
 
			echo  $html;
			?>
        	
        	
			<?php }else{
				$lineimg = $lineimgarr[$lineimgtype]['unstart'];?>
        	<div class="fl jjikk_sons_l jjikk_sons_ls"><span style="font-family:微软雅黑;font-size:12px;"><?=$k?>&nbsp;</span><br /><?=Date('H:i',$cw['truedateline'])?>&nbsp;</div>
			<?php }?>
			<div class="fl"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/jijiangkk<?=$lineimg?>.png?v=20170718001" width="24" height="143" /></div>
            <div class="fl jjikk_sons_r">           	
            	<div class="fl jjkkkc">
					<a class="kustgd" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank" class="opens viewc"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/<?=$playimg?>.png"></a>
					<div class="kcbj"><img width="167" height="100" src="<?=$logo?>"></div>
				</div>
                <div class="kcjsnr fl">
					<h2><a href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="_blank" title="<?=$cw['title']?>"><?=shortstr($cw['title'],66)?></a></h2>
					<p title="<?=$cw['summary']?>"><?=shortstr($cw['summary'],200)?></p>
                    <p class="zjlsp">主讲：<?=$cw['realname']?></p>
                </div>
            </div>
        </div>
		<div class="clear"></div>
		<?php }
		}?>
        
    </div>
	
</div>
<script>
var cwtotalpage = <?=ceil($listcount/$pagesize)?>;
$(function(){
	getPagestr();
})
$(document).on('click','.listPage a',function(){
	var lastpage = parseInt($('.listPage .none').attr('data'));
	var curpage = $(this).attr('data');
	
	if($(this).attr('id') == 'next'){//上一页，下一页
		// console.log(lastpage);
		curpage = lastpage+parseInt($(this).attr('data'));
		if(curpage>cwtotalpage){
			curpage = cwtotalpage;
		}else if(curpage<=0){
			curpage = 1;
		}
	}
	if(lastpage == curpage){
		return;
	}
	$('.listPage .none').removeClass('none');
	$('.listPage .normalpage[data='+curpage+']').addClass('none');

    var scroll_top = top.window.pageYOffset  //用于FF
                || top.document.documentElement.scrollTop  
                || top.document.body.scrollTop  
                || 0;
	var beforeChange = scroll_top - $('.normalpages').position().top;

	$('.cwlistpage').hide();
	$('.cwlistpage'+curpage).show();
	top.resetmain();
	var offset = top.$('#mainFrame').offset();
	var afterChange = beforeChange + $('.normalpages').position().top;
	
	if(cwtotalpage>10){//保持当前页在分页条中间
		// var headpage = (36-$('.normalpages').css('left').replace('px',''))/36;
		var headpage = curpage-4;
		if(headpage<1)
			headpage = 1;
		if(headpage>cwtotalpage-9)
			headpage = cwtotalpage - 9;
		var animateleft = -(headpage-1)*36;
		$('.normalpages').animate({'left':animateleft+'px'});
	}
	//保持分页条在当前浏览位置不乱跑（最后一页和倒数二页数据相差大时）
	parent.window.scrollTo(offset.left,afterChange);
});
//拼接分页
function getPagestr(){
	if(cwtotalpage == 1){
		return;
	}
	var pagestr = '<div class="pages"><div class="listPage"><a href="javascript:void(0)" data="-1" class="prevbtn" id="next">上一页&lt;&lt;</a><div class="pagescroll"><div class="normalpages">';
	for(var i=1;i<=cwtotalpage;i++){
		pagestr+= '<a href="javascript:void(0)" class="normalpage '+(i==1?'none':'')+'" data="'+i+'">'+i+'</a>';
	}
	pagestr+= '</div></div><a href="javascript:void(0)" data="1" class="nextbtn" id="next">下一页&gt;&gt</a></div></div>'
	$('.jijiangkk').append(pagestr);
}
</script>
<?php $displaypages = ceil($listcount/$pagesize);
$totalblockwidth = 36*$displaypages;
$pageblockwidth = 36*($displaypages>10?10:$displaypages);
?>
<style>
.normalpages{
	height:28px;
	width:<?=$totalblockwidth?>px;
	position: relative;
	float:left;
	display:block;
}
.pagescroll{
	width:<?=$pageblockwidth?>px;
	height:28px;
	float: left;
	display:block;
	overflow: hidden;
}
</style>
<?php }?>
<?php $this->display('college/calendar');?>
            <!--通知-->
            <div class="cmain_center_r fr" style="height:330px">
            	<h3>通知</h3>
				<?php if(!empty($notices)){?>
                <ul>
					<?php 
					$typearr = array('','');
					foreach($notices as $notice){
						$titlestyle = '';
						if((SYSTIME-$notice['dateline'])<86400*7){
							$titlestyle = 'color:red';
						}?>
					
                	<li>
                		<a target="_blank" style="<?=$titlestyle?>" title="<?=$notice['title']?>" href="<?=geturl('college/notice/'.$notice['noticeid'])?>"><?=shortstr($notice['title'],30,'')?></a>
                		<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
						<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>	
                		<p class="p2s"><?=timetostr($notice['dateline'],'Y-m-d H:i')?>（<?= $notice['type']==1?shortstr($notice['realname'],12):(($room_type==1) ? "公司":"学校")?>）</p>
                	</li>
					<?php }?>
                </ul>
				
                <a href="<?=geturl('college/notice')?>" class="fr" style="color:#999; line-height:25px;position:absolute;bottom:5px;right:10px">更多&nbsp;>></a>
				<?php }else{?>
				<div style="text-align:center;margin-top:30px">
				<img src="http://static.ebanhui.com/ebh/tpl/2014/images/nonotice.jpg"/>
				</div>
				<?php }?>
            </div>
			
			<!--调查问卷-->
            <div class="cmain_center_r fr" style="margin-top:10px;height:220px;">
            	<h3>调查问卷</h3>		
				<ul>
				<?php if(!empty($surveys)){
					foreach($surveys as $k => $survey){?>
					<li>
						<div class="">
						<?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
							<a href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank">
						<?php }else{?>
							<a href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank">
						<?php }?><?=strip_tags($survey['title'])?></a>
							<p class="p2s">有效期：<?=empty($survey['startdate'])?'':date('Y-m-d',$survey['startdate'])?><?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d',$survey['enddate'])?></p>
						</div>
					</li>
				<?php }?>
				</ul>
                <a href="<?=geturl('college/survey/surveylist')?>" class="fr" style="color:#999; line-height:25px;position:absolute;bottom:5px;right:10px">更多&nbsp;>></a>
				<?php }else{?>
				<div style="text-align:center;margin-top:10px">
				<img src="http://static.ebanhui.com/ebh/tpl/2016/images/wenjuanwu.png?v=01" style="width:150px;height:139px;"/>
				</div>
				<?php }?>
            </div>
	<div class="cmain_center fr">
		
            <div class="cmain_center_l fl" style="min-height:670px;width:1000px;">
                <h2>学习历史</h2>
				<?php if(!empty($creditlist)){
					$k=0;?>
				<div class="grow_chenr">
					<?php foreach($creditlist as $date){$k++;?>
						<h3 class="grow_h3"><?=$date[0]['date']?></h3>
						<?php foreach($date as $credit){
							$description = str_replace('[w]','<span style="color:#4db3ff">'.shortstr($credit['detail'],30).'</span>',$credit['description']);
							?>
							<p class="grow_txt <?=$k==count($creditlist)?'grow_txts':''?>"><?=$description?><span class="ndejtr"><?=$credit['credit']?></span>积分</p>
						<?php }?>
					<?php } ?>
				</div>
					<?php if(empty($more) && count($creditlist)<=50){?>
					<div style="float:left;height:30px;width:100%;"><a class="fr" href="<?=geturl('home/score/credit')?>?more=1" style="color:#999; line-height:25px;margin-right:10px;">更多 >></a></div>
					<?php }?>
				<?php }else {?>
					<div class="nodata"></div>
					<?php }?>
			</div>

        </div>
        <div class="clear"></div>
		
		
		
        </div>
        <div class="clear"></div>
		
	
</body>
<style>
body{
	font-family: microsoft yahei;

}
html,body{
	height: auto
}
a {color: #3d3d3d;text-decoration: none;}
.cmain_bottom .study .xialas{top:-5px;}
.cmain_bottom .study_bottom ul li{ margin-bottom:10px;}

.grow_chenr {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_xian.png) repeat-y;
	float:left;
	margin-top:6px;
	margin-left:10px;
}
.grow_h3 {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_quan.png) no-repeat;
	float:left;
	padding-left:30px;
	width:620px;
	height:23px;
	line-height:23px;
	font-size:16px;
	color:#999;
}
.grow_txt {
	color:#999;
	font-size:14px;
	padding-left:107px;
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_xing.png) no-repeat 85px center;
	float:left;
	width:588px;	
	height: 40px;
    line-height: 40px;
    margin: 0;

}
.grow_txts  {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/grow_xing.png) no-repeat 85px center #fff;	
}
.grow_colt {
	color:#444;
}
.ndejtr {
	color:#ff7f00;
}
.expired {
    background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dates2.png?v=02) no-repeat scroll center center;
    color: #fff;
    font-family: Arial;
    font-size: 14px;
    font-weight: bold;
    height: 28px;
    left: 2px;
    line-height: 28px;
    position: relative;
    text-align: center;
    top: 50px;
    width: 93px;
}
.starting {
	background:url(http://static.ebanhui.com/ebh/tpl/2016/images/dates3.png?v=02) no-repeat scroll center center;
    color: #fff;
    font-family: Arial;
    font-size: 12px;
    font-weight: bold;
    height: 28px;
    left: 2px;
    line-height: 28px;
    position: relative;
    text-align: center;
    top: 50px;
    width: 93px;
}
</style>


<script>
function resetheight(){
	var totalheight = 0;
	var height_top = $(".indexW") ? parseInt($('.indexW').get(0).offsetHeight):0;
	var height_bottom = $(".grow_chenr") ? parseInt($('.grow_chenr').get(0).offsetHeight):0;
	totalheight = height_top + height_bottom + 100;
	top.resetmain(totalheight);
}
//定时器作为修正使用,防止重复刷新页面没有加载完成
var timer = setTimeout(function(){
	resetheight();
	},500)
	
$(function(){
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();
});

    //定义Cookie  
    function setCookie(name, value, expire) {  
        window.document.cookie = name + "=" + escape(value) + ((expire == null) ? "" : ("; expires=" + expire.toGMTString()));  
    }  
    function getCookie(Name) {  
        var search = Name + "=";  
        if (window.document.cookie.length > 0) {   
        // 如果没有则下一个   
            offset = window.document.cookie.indexOf(search);  
            if (offset != -1) {  
             // 如果找到   
                offset += search.length;  
                // 设置开始   
                end = window.document.cookie.indexOf(";", offset)  
                // 结束  
                if (end == -1)  
                    end = window.document.cookie.length;  
                return unescape(window.document.cookie.substring(offset, end));  
            }  
        }  
        return null;  
    }  
    function register(name) {  
        var today = new Date();  
        var expires = new Date();  
        expires.setTime(today.getTime() + 1000 * 60 * 60 * 24);  
        setCookie("ItDoor", name, expires);  
    }  
    
    function openWin() {  
        var c = getCookie("ItDoor");  
        if (c != null) {  
            return;  
        }  
        register();  
		//通知弹窗
	 $.ajax({  
			dataType:"json",
			type:"get",  
			url:"<?=geturl('myroom/default/getnoticeRemind')?>",//接口服务器地址  
			success:function(data){
				if (data.code == 1) {
					//console.log(data);
					top.dialog({
						id: "abc", //可选
						title: "通知",
						content: "您有新的通知还未查看",
						okValue: "前往查看",
						ok: function() {
							window.location.href="/college/notice.html"
						},
						cancelValue: "",
					}).showModal(); //show:无遮罩层,showModal:有遮罩层，需要全屏显示请在dialog前加上top,例：top.dialog({....}).showModal()
				}
				else {
					return false;
				}
			}
		})
    }  
    openWin();  
    window.focus()  


</script>
</html>