<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/courses/css/jisrn.css?version=20160629001" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<!-- 引入xdialog弹出层控件开始 -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
<!-- 引入xdialog弹出层控件结束 -->
<style>
a.lisnrwe{
	color:#fff;
	margin-left:135px;
}
a.oklsuirh{
	color:#999;
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
        <a href="<?=geturl('aroomv2/course')?>">课程管理</a>
        > 引入公共课程
    </div>
	<div class="bsirfd">
    	<div class="gerded">
        	课程分类<a href="<?=geturl('aroomv2/jingpin/cateset')?>" class="fenfds">分类设置</a>
        </div>
		<?php if(empty($mlist)){ ?>
		<div class="jisrtde" style="font-size:13px;color:#666;">
        	<p style="text-align:center">暂无分类</p>
			<p style="text-align:center">温馨提示：快点击右上角“分类设置”按钮，创建完课程类别之后才能选课哦！</p>
		</div>
        <?php }else{ ?>
        <div class="derwdgh">
        	<span class="lefstwe">课程主类别：</span>
            <div class="risfds">
            	<a href="/aroomv2/jingpin.html?pid=0" class="hisrwe maintype <?php if($pid == 0){ ?>uetlans<?php } ?>">全部</a>
                <?php foreach ($mlist as $mitem){ ?>
                	<a href="/aroomv2/jingpin.html?pid=<?=$mitem['pid']?>" class="hisrwe maintype <?php if($pid == $mitem['pid']){ ?>uetlans<?php } ?>"><?=$mitem['pname']?></a>
                <?php } ?>
            </div>
        </div>
        <div class="derwdgh">
        	<span class="lefstwe">课程子类别：</span>
            <div class="risfds">
            	<a href="/aroomv2/jingpin.html?pid=<?=$pid?>" class="hisrwe subtype <?php if($sid == 0){ ?>uetlans<?php } ?>">全部</a>
                <?php foreach ($tslist as $sk=>$sitem){ ?>
                	<?php foreach ($sitem as $ssitem){ ?>
                		<a href="/aroomv2/jingpin.html?pid=<?=$sk?>&sid=<?=$ssitem['sid']?>" class="hisrwe subtype <?php if($pid == $sk && $sid == $ssitem['sid']){ ?>uetlans<?php } ?>" <?php if($sk != $pid){ ?> style="display:none" <?php } ?>><?=$ssitem['sname']?></a>
                	<?php } ?>
               	<?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
	<div class="bsirfd">
    	<div class="gerded">
        	课程列表<a href="<?=geturl('aroomv2/jingpin/selcourses')?>" class="fenfds">选课中心</a>
        </div>
         
		<div class="jisrtde">
        	<ul id="courselist">
        		<?php if(!empty($courses)){ ?>
        			<?php foreach ($courses as $citem){ ?>
        				<?php 
        					$viewurl = $itemids[$citem['itemid']]['iskk'] == 1 ? '/courseinfo/'.$itemids[$citem['itemid']]['topayitemid'].'.html' : '/ke/'.$citem['itemid'].'.html?from=aroom';
							$thumb = empty($citem['longblockimg']) ? "http://static.ebanhui.com/ebh/tpl/courses/images/shtisut.jpg" : $citem['longblockimg']; 
						?>
        				<li class="iuhni dkmars">
        					<a target="_blank" class="kuetgf" href="<?=$viewurl?>">
				 				<img width="230px" height="136px" src="<?=$thumb?>">
				 			</a>
				 			<span class="wrnssrs">共<?=$citem['coursewarenum']?>课时</span>
				 			<h2 class="klejts"><a title="<?=$citem['iname']?>" target="_blank" href="<?=$viewurl?>"><?=shortstr($citem['iname'],40)?></a></h2>
				 			<span class="renares"><?=$citem['viewnum']?></span>
				 			<span class="euitsd"><?=shortstr($citem['crname'],24)?></span>
				 			<?php if($itemids[$citem['itemid']]['iskk'] == 0){ ?>
				 				<?php if($citem['iprice'] == 0){ ?>
				 					<p class="lbsrver">免费</p>
				 				<?php }else{ ?>
				 					<p class="lsirse">￥<?=$citem['iprice']?></p>
				 				<?php } ?>
				 					<div class="egbdet">
				 						<a href="javascript:;" class="hissre" data-itemid="<?=$citem['itemid']?>">删除</a>
				 						<a href="javascript:;" class="buewers" data-sid="<?=$itemids[$citem['itemid']]['sid']?>" data-pid="<?=$itemids[$citem['itemid']]['pid']?>" data-itemid="<?=$citem['itemid']?>">分类</a>
				 						<a href="javascript:;" data-itemid="<?=$citem['itemid']?>" class="hwufhd">开课</a>
				 			<?php }else{ ?>
				 				<?php if($citem['iprice'] == 0){ ?>
				 					<p class="lbsrver" style="width:78px">免费</p>
				 				<?php }else{ ?>
				 					<p class="lsirse" style="width:78px">￥<?=$citem['iprice']?></p>
				 				<?php } ?>
				 					<div class="egbdet" style="width:152px">
				 						<a href="javascript:;" class="hissre" data-itemid="<?=$citem['itemid']?>">删除</a>
				 						<a href="javascript:;" class="buewers iopen" style="background:#e5e5e5;color:#999;" data-sid="<?=$itemids[$citem['itemid']]['sid']?>" data-pid="<?=$itemids[$citem['itemid']]['pid']?>" data-itemid="<?=$citem['itemid']?>">分类</a>
				 						<a href="javascript:;" class="husiret">已开课</a>
				 			<?php } ?>
        				</div></li>
        			<?php } ?>
        		<?php }else{ ?>
        			<li style="text-align:center;font-size:13px;color:#666;">暂无课程</li>
					<li style="text-align:center;font-size:13px;color:#666;">温馨提示：创建完课程类别后，再点击右上角“选课中心”，就可以去选课了！</li>
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
	            	<?php if(!empty($tslist[$mitem['pid']])){
					foreach ($tslist[$mitem['pid']] as $titem){ ?>
	                <div class="huetgd" data-sid="<?=$titem['sid']?>" style="display:block"><i class="iconxiao"></i><?=$titem['sname']?></div>
	                <?php } }?>
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

<script language="javascript">
$(function(){
	//分类初始化
	function initcate(itemid,pid,sid){
		$('#toitemid').val(itemid);
		$('.dasirwe,.huetgd').removeClass('selected');
		$('.liuwrdfe .dasirwe').each(function(index){
			if($(this).data('pid') == pid){
				if(sid == 0){
					$(this).addClass('selected');
				}else{
					$(this).siblings('[data-sid='+sid+']').addClass('selected');
				}
				$(this).find('.iconjian').removeClass('iconjian').addClass('iconjia');
				$(this).siblings().show();
				return false;
			}
		})
	}
	//更改分类操作
	$(document).on('click','.buewers',function(e){
		if($(this).is('.iopen')){
			return false;
		}
		var itemid = $(this).data('itemid'),
			pid = $(this).attr('data-pid'),
			sid = $(this).attr('data-sid');
		initcate(itemid,pid,sid);
		H.create(new P({
			title:'移动至',
	        id:'typedialog',
	        content:$('.uasirtdss'),
	        easy:true
	    })).exec('show');
	})
	//取消移动
	$('.oklsuirh').on('click',function(){
		H.get('typedialog') && H.get('typedialog').exec('close');	
	})
	//确定移动
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
			alert('移动失败，必须移动到子类');
			return false;
		}
		$.post('/aroomv2/jingpin/domove.html',{pid:pid,sid:sid,itemid:itemid},function(data){
			H.get('typedialog') && H.get('typedialog').exec('close');
			if(data.code == 0){
				alert('移动成功！');
				$('.buewers[data-itemid='+itemid+']').attr('data-pid',pid);
				$('.buewers[data-itemid='+itemid+']').attr('data-sid',sid);
			}else{
				alert('移动失败！')
			}
		},'json');		
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
	//删除操作
	$(document).on('click','.hissre',function(){
		var itemid = $(this).data('itemid'),
			node = $(this).parent().parent();
		$.post('/aroomv2/jingpin/dodelete.html',{itemid:itemid},function(data){
			if(data.code == 0){
				alert(data.msg);
				location.reload();
			}else{
				alert(data.msg);
			}
		},'json');
	})
	//开课操作
	$(document).on('click','.hwufhd',function(){
		var itemid = $(this).data('itemid'),
			self = $(this);
		$.post('/aroomv2/jingpin/dokk.html',{itemid:itemid},function(data){
			alert(data.msg);
			if(data.code == 0){
				self.css({'background':'#e5e5e5','color':'#999'});
				self.html('已开课');
				self.siblings(".buewers").css({'background':'#e5e5e5','color':'#999'});
				self.siblings(".buewers").addClass("iopen");
			}
		},'json');
	})
})
</script>
</body>
</html>