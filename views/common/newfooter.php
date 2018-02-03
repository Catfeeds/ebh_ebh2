<script type="text/javascript">
	var catid = "<?=empty($catid)?0:$catid?>";
	if(catid!=0){
		var $gaoliang = $('.navblock a[catid='+catid+']');
	}else{
		var uri_path = "<?=$this->uri->uri_path()?>"+'.html';
		if(uri_path!='.html'){
			var $gaoliang = $('.navblock a[href*="'+uri_path+'"]');
			if($gaoliang.length>0){
				var tag = uri_path+window.location.search;
				var $gaoliang = $('.navblock a[href*="'+tag+'"]');
			}
		}
		
	}
	$gaoliang.css({color:'#0085f6'});
	var upid = $gaoliang.attr('upid');
	if(upid!=0){
		var $gaoliang = $('.navblock a[catid='+upid+']');
		$gaoliang.css({color:'#0085f6'});
	}
	$(function(){
		$("a[href*=#]").click(function(){
			return false;
		});
	});
</script>
<div class="flotat">
<div class="footer">
<div class="flelp">
<h3><a href="/help.html">新手帮助</a></h3>
<a class="helpink" rel="nofollow" target="_blank" href="/help.html">我是学生，如何试听课件？</a>
<a class="helpink" rel="nofollow" target="_blank" href="/help.html">我是老师，如何录制课件？</a>
<a class="helpink" rel="nofollow" target="_blank" href="/help.html">如何下载题库资源？</a>
<a class="helpink" rel="nofollow" target="_blank" href="/help.html">学生如何开通网校服务？</a>
</div>
<div class="fdlink">
<div class="fdlink_title">
<h3>友情链接</h3>
<a rel="nofollow" target="_blank" href="/cloudlist-1-0-0.html">更多>></a>
</div>
<?php foreach ($flink as  $room) {?>
 	<?php $roomurl = 'http://'.$room['domain'].'.ebanhui.com';?>
	<a class="gray" target="_blank" href="<?=$roomurl?>"><?=$room['crname']?></a>
<?php }?>
</div>
</div>
</body>
</html>