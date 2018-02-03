<?php $this->display('myroom/page_header'); ?>
<style>
	.kewate {
	  height: 24px;
	  float: left;
	  display: inline;
	  width: 178px;
	  background: #eee;
	  border: 1px solid #dcdcdc;
	  position: relative;
	}
	.kewate span {
	  float: left;
	  height: 24px;
	  width: 178px;
	  line-height: 24px;
	  color: #000;
	  text-align: center;
	  background: #4f8df0;
	  position: absolute;
	  top: 0;
	  left: 0;
	}
	.inline{
		display: inline;
	}
	.dtkywe {
	  height: 35px;
	  position: absolute;
	  right: 0px;
	  top: 5px;
	  width: 110px;
	}
	a.gkstgws.sel{
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaostds.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
	a.stutes.sel {
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/tyistyts.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
	a.stutes {
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/tyistyt.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
	a.gkstgws{
		background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaostd.jpg) no-repeat;
		width:32px;
		height:31px;
		float:left;
		display:block;
		margin-right:16px;
	}
</style>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/liets.css" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('myroom/stusubject') ?>">学习课程</a> > <?=$folder['foldername']?>
	<div class="dtkywe">
		<a href="?cwsmod=list" class="stutes tolist <?=($cwsmod=='list')?' sel':'' ?>"></a>
		<a href="?cwsmod=grid" class="gkstgws togrid  <?=($cwsmod=='grid')?' sel':'' ?>"></a>
	</div>
</div>
<?php if(empty($sectionlist)){?>
<div class="lstugv" style="margin-top:10px;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/stuhope.jpg"></div>
<?php exit();}?>
<script>
		function errorHandler(){
			var cwid = $(this).attr('cwid');
			var size = '178_103';
			var me = this;
			$.ajax({
		        type: "POST",
		        url: "<?=geturl('imghandler')?>",
		        data: {cwid:cwid,size:size,type:'courseware_logo'},
		        dataType: "json",
		        success: function(data){
		        	if(data && (data.status == 0) ){
		        		$(me).attr('src',data.url+'?v=1');//v=1 你猜这是干什么的 O(∩_∩)O哈哈~
		        	}
		        	$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
		        	$(me).unbind('error');
		        },
		        error:function(){
		        	$(me).removeAttr('onerror');//解绑onerror事件 防止死循环
		        	$(me).unbind('error');
		        }
	    	});
		}
	</script>
<div class="lstjds">
<?php
	//$mediatype = array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov');
	$deflogo = 'http://static.ebanhui.com/ebh/tpl/default/images/178_kete.jpg';
?>
<?php foreach ($sectionlist as $section) {?>
<h2 class="laishtw" style="clear:both;"><a href="javascript:void(0);"><?= (!empty($section[0]) and !empty($section[0]['sname']))? $section[0]['sname']:"其它2";?></a></h2>
	<?php foreach ($section as $cw) {?>
	<?php
//		$arr = explode('.',$cw['cwurl']);
//		$type = $arr[count($arr)-1];
//		$target=(empty($cw['cwurl']) || in_array($type,$mediatype))? '_blank' : '';
		$target='_blank';
		$logo = !empty($cw['logo'])?getthumb($cw['logo'],'178_103'):$deflogo;//触发火狐的onerror事件图标地址不能为空
		
		if( ( !empty($cw['endat']) && (SYSTIME>=$cw['endat']) ) || ( !empty($cw['submitat']) && (SYSTIME<$cw['submitat']) ) ){
			$sstyle = 'style="text-decoration: line-through;color:#666;overflow:hidden;"';
			$stat = 0;
		}else{//正常
			$sstyle = 'style="color:#666;overflow:hidden;"';
			$stat = 1;
		}
	?>
	<div class="gdydht" style="height:182px;">
	<div class="wraps" style="overflow: hidden;">
	<a title="<?=$cw['title']?>" href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" target="<?=$target?>" class="wraps">
		<div class="fskpctd">
			<img cwid="<?=$cw['cwid']?>" class="imgst"  onerror="errorHandler.call(this)" src="<?=$logo?>" />
		</div>
		<div class="titel">
			<h2 class="lihett f-thide" <?=$sstyle?> ><?=shortstr($cw['title'],20,'')?></h2>
		</div>
		<div class="orgname" style="margin:5px 0;">
			<span class="texrig" style="width:auto;text-align: left;float:left;"><?=$cw['realname']?></span>
			<span class="texrig" style="width:auto;text-align: right;float:right;"><?=timetostr($cw['dateline'],'Y-m-d')?></span>
		</div>
		<!-- ===进度条逻辑开始=== -->
		<?php
			$key = 'cwid_'.$cw['cwid'];
			$progress = 0;
			if (isset($playlogs) && is_array($playlogs)){
				if(array_key_exists($key, $playlogs)){
					if(!empty($playlogs[$key]['ctime'])){
						$progress = ($playlogs[$key]['ltime']/$playlogs[$key]['ctime'])*100;
					}else{
						$progress = 100;
					}
					if($progress >= 90){
						$progress = 100;
					}
				}
			}
			$progress = min($progress,100);
			$progress = intval($progress);
		?>
		<div class="kewate" style="margin-top:5px;">
			<span style="width:178px;background:none;z-index:2"><?=$progress?>%</span>
			<span style="z-index:1;width:<?=$progress?>%;"></span>
		</div>
		<!-- ===进度条逻辑结束=== -->
	</a>
	</div>
	</div>
	<?php }?>
<?php }?>
</div>
<!-- =======修复低版本浏览器点击图片a标签不跳转开始====== -->
	<script>
		function checkhHtml5() {   
			if (typeof(Worker) !== "undefined") {
				return true;
			}else{
			   	return false;
			}  
		} 

		$(function(){
			if(!checkhHtml5()){
				$('.fskpctd').addClass('inline');
			}
		});
	</script>
<!-- =======修复低版本浏览器点击图片a标签不跳转结束====== -->
</body>
</html>
