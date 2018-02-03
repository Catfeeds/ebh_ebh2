<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/courses/css/jisrn.css?version=20160629001" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?version=20160629001"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<!-- 引入xdialog弹出层控件开始 -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
<!-- 引入xdialog弹出层控件结束 -->
<style>
.fklisr{
	width:100px;
}
a.wursk{
	width:100px;
}
a.hwufhd{
	color:#fff;
}
a.lisnrwe{
	color:#fff;
	margin-left:135px;
}
a.oklsuirh{
	color:#999;
}
.fklisr a.botsder{
	width:98px;
}
.dasirwe{
	padding-left:10px;
	padding-right:10px;
}
.huetgd{
	padding-left:32px;
	padding-right:10px;
}
.iconjia,.iconjian{
	padding-right:5px;
}
</style>
</head>
<body>
<div class="cright" style="margin-top: 0">
	<div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/course.html">课程管理</a> >
        <a href="/aroomv2/jingpin.html">引入公共课程</a>
        > 选课中心
    </div>
	<div class="bsirfd">
        <div class="kostrds">
            <ul>
            	<li class="fklisr"><a class="wursk <?php if(empty($request['bsid'])){ ?>botsder<?php } ?>" href="/aroomv2/jingpin/selcourses.html">热门课程</a></li>
            	<li class="fklisr"><a class="wursk <?php if($request['bsid'] == -100){ ?>botsder<?php } ?>" href="/aroomv2/jingpin/selcourses.html?bsid=-100">猜你喜欢</a></li>
            	<?php if(!empty($sortsone)){ ?>
            	<?php foreach ($sortsone as $ftype){ ?>
                <li class="fklisr"><a href="/aroomv2/jingpin/selcourses.html?bsid=<?=$ftype['sid']?>" class="wursk <?php if($request['bsid'] == $ftype['sid']){ ?>botsder<?php } ?>"><?=$ftype['sname']?></a></li>
                <?php } ?>
                <?php }else{ ?>
                	暂无分类
                <?php } ?>
            </ul>
        </div>
        
        <!-- 热门课程、猜你喜欢隐藏分类 -->
        <div <?php if(empty($request['bsid']) || $request['bsid'] == -100 ){ ?>style="display: none" <?php } ?>>
        <?php if(!empty($nextsorts[2])){ ?>
        <?php foreach ($nextsorts[2] as $stype){ ?>
        <div class="xaiostie bomnone">
        	<div class="nisnfe bomnone">
                <a href="/aroomv2/jingpin/selcourses.html?bsid=<?=$request['bsid']?>&msid=<?=$stype['sid']?>"><span class="nstrdss"><?=$stype['sname']?>：</span></a>
                <a href="/aroomv2/jingpin/selcourses.html?bsid=<?=$request['bsid']?>&msid=<?=$stype['sid']?>" class="khrusre <?php if($stype['sid'] == $request['msid'] && empty($request['ssid'])){ ?>dianlan <?php } ?>">全部</a>
                <?php if(!empty($stype['child'])){ ?>
                	<?php foreach ($stype['child'] as $sstype){ ?>
                		<a class="khrusre <?php if($sstype['sid'] == $request['ssid']){ ?>dianlan <?php } ?>" href="/aroomv2/jingpin/selcourses.html?bsid=<?=$request['bsid']?>&msid=<?=$stype['sid']?>&ssid=<?=$sstype['sid']?>"><?=$sstype['sname']?></a>
                	<?php } ?>
                <?php }else{ ?>
                	暂无分类
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php }else{ ?>
        	暂无分类
        <?php } ?>
        </div>
    </div>
    <!-- 热门课程、猜你喜欢隐藏标签 -->
    <div id="singletags" class="lishdre bomnone" <?php if(empty($request['bsid']) || $request['bsid'] == -100 ){ ?>style="display: none" <?php }else if(empty($label)){ ?>style="margin-top:0"<?php } ?>>
        <?php if(!empty($label)){ ?>
        <span class="sherdfs">课程：</span>
        <div class="istrew">
        	<?php foreach ($label as $lb){ ?>
            	<a href="javascript:void(0);" data-sid="<?=$lb['sid']?>" class="kluehrt tagitem <?php if(in_array($lb['label'],$request['tag'])){ ?>listhfd<?php } ?>" thref="/aroomv2/jingpin/selcourses.html?bsid=<?=$request['bsid']?>&msid=<?=$stype['sid']?>&ssid=<?=$lb['sid']?>&tag[]=<?=$lb['label']?>"><?=$lb['label']?></a>
            <?php } ?>
        </div>
        <a id="mutitagselect" class="fewtfd" href="javascript:;"></a>
        <?php } ?>
    </div>
    <div id="mutitags" class="lisrtde bomnone" style="margin-top:15px;display:none">
    	<span class="sherdfs" style="font-family:Microsoft YaHei;">课程：</span>
        <div class="istrew">
        	<?php if(!empty($label)){ ?>
        		<?php foreach ($label as $lb){ ?>
           			<a class="kluehrt mutitags" href="javascript:;" style="font-family:Microsoft YaHei;"><input data-t="<?=$lb['label']?>" type="checkbox" name="checkbox2" class="leutwr" value="<?=$lb['sid']?>" <?php if(in_array($lb['label'],$request['tag'])){ ?> checked="checked" <?php } ?>><?=$lb['label']?></a>
           		<?php } ?>
            <?php }else{ ?>
            	<a class="kluehrt" style="font-family:Microsoft YaHei;">暂无标签</a>
            <?php }?>
        </div>
        <div class="istrew">
        	<a class="jisrfe" style="margin-left:285px;" href="javascript:;">确定</a>
            <a class="queses" href="javascript:;">取消</a>
        </div>
    </div>
	<div class="bsirfd">
    	<div class="gerded" style="padding-left:0">
        	<a href="<?=$baseurl?>" <?php if(empty($request['order'])){ ?> class="jiwres" <?php }else{ ?> class="luiets" <?php } ?>>综合排序</a>
            <a href="<?=$baseurl.'&order=time'?>" <?php if($request['order'] == 'time'){ ?>  class="jiwres" <?php }else{ ?>  class="luiets" <?php } ?>>最新</a>
            <a href="<?=$baseurl.'&order=viewnum'?>" <?php if($request['order'] == 'viewnum'){ ?>  class="jiwres" <?php }else{ ?>  class="luiets" <?php } ?>>人气</a>
            <a id="priceorderselect" href="javascript:;" <?php if($request['order'] == 'price_high' || $request['order'] == 'price_low'){ ?>  class="jiwres lisrhe" <?php }else{ ?>  class="luiets" <?php } ?>>价格 <img src="http://static.ebanhui.com/ebh/tpl/courses/images/lisrne.png"></a>
            <div class="lirrtds" style="display:none;left:232px;top:44px">
            	<ul>
                	<li><a href="<?=$baseurl.'&order=price_high'?>" class="luetsa">从高到低</a></li>
                    <li><a href="<?=$baseurl.'&order=price_low'?>" class="luetsa">从低到高</a></li>
                </ul>
            </div>
            <span id="onlycheckspan" style="cursor:pointer">
            	<input type="checkbox" id="onlycheckbox" name="checkbox" class="kuiets" <?php if($request['price'] == 'free'){?> checked="checked" <?php } ?>>只看免费公开课
            </span>
        </div>
		<div class="jisrtde">
        	<ul>
                <?php if(!empty($bestitems)){ ?>
               		<?php foreach ($bestitems as $k=>$v){ ?>
               			<li class="iuhni dkmars">
                		<a target="_blank" class="kuetgf" href="<?="/ke/".$v['itemid'].".html?from=aroom"?>">
                    		<img width="230px" height="136px" src="<?=empty($v['longblockimg']) ? "http://static.ebanhui.com/ebh/tpl/courses/images/shtisut.jpg" : $v['longblockimg']?>">
                    	</a>
                    	<span class="wrnssrs">共<?=$v['coursewarenum']?>课时</span>
                   	 	<h2 class="klejts"><a title="<?=$v['iname']?>" target="_blank" href="<?="/ke/".$v['itemid'].".html?from=aroom"?>"><?=shortstr($v['iname'],40)?></a></h2>
	                    <span class="renares"><?=$v['viewnum']?></span>
	                    <span class="euitsd"><?=shortstr($v['crname'],24)?></span>
	                    <?php if($v['iprice'] == 0){ ?>
	                    	<p class="lbsrver">免费</p>
	                    <?php }else{ ?>
	                    	<p class="lsirse">￥<?=$v['iprice']?></p>
	                    <?php } ?>
	                    <div class="egbdet">
	                        <a target="_blank" href="<?="/ke/".$v['itemid'].".html?from=aroom"?>" class="jistss">查看详情</a>
	                        <a data-itemid="<?=$v['itemid']?>" href="javascript:;" class="hwufhd">选课</a>
	                    </div>
                		</li>
               		<?php } ?> 
                <?php }else{ ?>
                	<li style="text-align: center">暂无课程</li>
                <?php } ?>
            </ul>
        </div>
        <?php echo $pagestr;?>
    </div>
</div>
<!-- 课程分类 -->
<div class="uasirtdss" style="display:none">
	<div class="jisrdtge">
    	<ul>
    		<?php if(!empty($mlist)){ ?>
    			<?php foreach ($mlist as $mitem){ ?>
	        	<li class="liuwrdfe">
	            	<div class="dasirwe" data-pid="<?=$mitem['pid']?>"><i class="iconjia"></i><?=$mitem['pname']?></div>
	            	<?php foreach ($tslist[$mitem['pid']] as $titem){ ?>
	                <div class="huetgd" data-sid="<?=$titem['sid']?>" style="display:block"><i class="iconxiao"></i><?=$titem['sname']?></div>
	                <?php } ?>
	            </li>
	            <?php } ?>
            <?php }else{ ?>
            	<li class="liuwrdfe">暂无分类</li>
            <?php } ?>
        </ul>
    </div>
    <input id="toitemid" type="hidden" value="0">
    <a href="javascript:;" style="margin-top:0px;" class="lisnrwe">确定</a>
    <a href="javascript:;" style="margin-top:0px;" class="oklsuirh">取消</a>
</div>

<!-- 选课成功后提示 -->
<div id="xkcg_1" class="xkcg" style="display:none">
	<div class="htitles">选课成功</div>
    <div class="kcxztsxx">该课程已存放至您的课程列表中。后续您可以在课程列表中点击"开课"按钮，将课程同步至您自己的网校首页进行销售。</div>
    <div class="xuanbtn">
    	<a id="gokaike" href="javascript:;" class="qkks">去开课</a>
        <a id="goxuanke" href="javascript:;" class="jxxk">继续选课</a>
    </div>
</div>

<!--没有创建类别-->
<div id="xkcg_2" class="xkcg" style="display:none">
    <div class="mycjkclb">您还没有创建课程类别，无法选课。</div>
    <div class="xuanbtn xuanbtn1s">
        <a href="/aroomv2/jingpin/cateset.html" class="jxxk">创建分类</a>
    </div>
</div>

<script language="javascript">
$(function(){
	//多选
	$('#mutitagselect').on('click',function(){
		$('#mutitags').toggle();
		if($('#mutitags').is(':hidden') == false){
			$('#singletags').hide();
		}
	})
	//取消
	$('.queses').on('click',function(){
		$('#singletags').show();
		$('#mutitags').hide();
	})
	//复选框点击事件
	$("input[name=checkbox2]").on('click',function(){
		if($(this).is(':checked')){
			$(this).prop('checked','');
		}else{
			$(this).prop('checked','checked');
		}
	})
	//点击文字选择或取消复选框
	$(".kluehrt.mutitags").on('click',function(){
		var checkbox = $(this).find('input');
		if(checkbox.is(':checked')){
			checkbox.prop('checked','');
		}else{
			checkbox.prop('checked','checked');
		}
	})
	//确定
	$('.jisrfe').on('click',function(){
		var chk = $('input[name=checkbox2]:checked');
		var url = "/aroomv2/jingpin/selcourses.html?bsid=<?=$request['bsid']?>&msid=<?=$request['msid']?>&ssid=<?=$request['ssid']?>";
		if(chk.length > 0){
			for(var i=0;i<chk.length;i++){
				url += "&tag[]="+$(chk[i]).attr('data-t');
			}
		}
		location.href=url;
	})
	//价格排序下拉
	$('#priceorderselect,.lirrtds').hover(
		function(){
			$('.lirrtds').show();
			return false;
		},
		function(){
			$('.lirrtds').hide();
		}
	)
	//免费课程筛选
	$('#onlycheckspan').on('click',function(){
		$('#onlycheckbox').trigger('click');
	});
	$('#onlycheckbox').on('click',function(){
		var url = "<?=$baseurl.'&order='.$request['order']?>";
		if($(this).is(':checked')){
			url += "&price=free";
		}
		location.href = url;
		return false;
	})
	//选课操作
	$('.hwufhd').on('click',function(){
		if($('.uasirtdss .dasirwe').length == 0){
			H.create(new P({
				title:'提示',
		        id:'xkdialog',
		        content:$('#xkcg_2'),
		        easy:true
		    })).exec('show');
		}else{
			var itemid = $(this).data('itemid');
			$('#toitemid').val(itemid);
			H.create(new P({
				title:'移动至',
		        id:'typedialog',
		        content:$('.uasirtdss'),
		        easy:true
		    })).exec('show');
		}
	})
	//取消选课
	$('.oklsuirh').on('click',function(){
		H.get('typedialog') && H.get('typedialog').exec('close');	
	})
	//确定选课
	$('.lisnrwe').on('click',function(){
		//确定pid和sid
		var pid = sid = 0,
			pnode = $('.dasirwe.selected'),
			snode = $('.huetgd.selected'),
			itemid = $('#toitemid').val();
		if(snode.length){
			pid = snode.parent().find('.dasirwe').data('pid');
			sid = snode.data('sid');
		}else{
			pid = pnode.data('pid');
		}
		if(pid == 0 || sid == 0){
			alert('必须选择子类，如果没有子类请添加子类后再选课！');
			return false;
		}
		$.post('/aroomv2/jingpin/dosel.html',{pid:pid,sid:sid,itemid:itemid},function(data){
			if(data.code != -4){
				H.get('typedialog') && H.get('typedialog').exec('close');
				successtip();
			}	
		},'json');		
	})
	//标签点击处理
	$('.tagitem').on('click',function(index){
		var href = $(this).attr('thref');
		if($(this).is('.listhfd')){
			$(this).removeClass('listhfd');
			//过滤下标签
			var tag = $.trim($(this).html());
			var filter = new RegExp("&tag\\[\\]="+tag,"g");
			var selarr = [];
			href = href.replace(filter,'');
			$('.istrew .listhfd').each(function(index){
				var itag = $.trim($(this).html());
				selarr.push('&tag[]='+itag);
			})
			selarr.length > 0 ? href += selarr.join('') : '';
		}
		location.href=href;
	})
	//分类的折叠与展开
	$('.liuwrdfe .dasirwe').on('click',function(){
		var self = $(this);
		$('.dasirwe,.huetgd').removeClass('selected');
		self.parent().find('.huetgd').toggle();
		$(this).addClass('selected');
		self.parent().find('.huetgd:first').is(':hidden') ? self.find('i').removeClass('iconjia').addClass('iconjian') : self.find('i').removeClass('iconjian').addClass('iconjia');
	})
	$('.liuwrdfe .huetgd').on('click',function(){
		$('.dasirwe,.huetgd').removeClass('selected');
		$(this).addClass('selected');	
	})
	//开课跳转
	$('#gokaike').on('click',function(){
		location.href="/aroomv2/jingpin.html";
	})
	//继续选课
	$('#goxuanke').on('click',function(){
		location.reload();
		H.get('tipdialog') && H.get('tipdialog').exec('close');
	})
	//选课成功后提示弹框
	function successtip(){
		H.create(new P({
			title:'提示',
	        id:'tipdialog',
	        content:$('#xkcg_1'),
	        easy:true
	    },{
   			onclose:function(){
   				location.reload();
   			 	H.get('tipdialog').exec('close');
   			}
   		})).exec('show');
	}
})
</script>
</body>
</html>