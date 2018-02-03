<?php
$this->display('common/header');
?>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/space.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<div class="topbaad">
<div class="user-main clearfix">
	
<?php
$this->assign('menuid',2);
$this->display('member/left');
?>
<?php $key=str_replace("'",'',$this->uri->uri_attr(0));?>

<div class="cright_cher">
<div class="ter_tit">
	当前位置 > 原创空间
	<div class="diles">
	<input name="title" class="newsou" value="<?=empty($q)?'请输入您要搜索的作品名称':$q?>"  id="title" type="text" style="<?php if(!empty($q)){?>color:#000<?php }?>"/>
	<input type="button" class="soulico" value="" id="room_search_btn">
</div>
</div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">

<div class="annuato">
					<input class="questionbutton" value="新建原创作品" type="button" onclick="openplay()" style="color: #FFFFFF;font-size:14px;width:110px;float:right;" />
		</div>

<ul class="clearfix ">


<?php
	if(!empty($spacelist)){
	foreach($spacelist as $sl){
		$sl['url'] = '/'.($this->uri->codepath).'/'.$sl['id'].'.html';
		$imgurl = $showpath.$sl['image'];
		$thumburl = getthumb($imgurl,'126_126');
	?>
	
	<li class="imgli" style="margin-right:0px;">
	
	<div class="wrap">
		
		<h3 class="summary">
			<span id="sh1<?=$sl['id']?>"><a href="<?=$sl['url']?>" title="<?=$sl['title']?>" id="linka<?=$sl['id']?>"><?=$sl['title']?></a></span>	
			<span id="sh2<?=$sl['id']?>" style="display:none;">
				<input style="height:16px;width:130px;" id="showtextbox<?=$sl['id']?>" value="<?=$sl['title']?>" onblur="changeTextBox1(<?=$sl['id']?>)"  maxlength='13' />
			</span>
		</h3>
		<h2 class="sun">
		<a id="open<?=$sl['id']?>" href="javascript:playspace(<?=$sl['id']?>,'<?=$sl['title']?>')" style="color:#3095C6;">打开</a>
		<a href="javascript:shTextBox1(<?=$sl['id']?>);" style="color:#3095C6;">修改</a>
		<a id="del<?=$sl['id']?>" href="javascript:deletespace(<?=$sl['id']?>,'<?=$sl['title']?>')" style="color:#3095C6;">删除</a>
		<a href="/space/down.html?id=<?=$sl['id']?>" style="color:#3095C6;">下载</a></h2>
		<a class="autts" href="<?=$sl['url']?>" title="<?=$sl['title']?>" >
 			<img class="show_img" src="<?= $thumburl?>" />
 			<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif" />
 		</a>
		</div>
	</li>
	<?php
	}}else{
?>

<div style="background-color: #F4F4F4;border-bottom: 1px solid #E2E2E2;color: #999999;margin-top:0px;"  class="annotate">
您还未上传任何的作品，您可以使用&nbsp;<a style="color:blue" href="http://sfds.ebanhui.com/" title="e板会书法大师" target="_blank">e板会书法大师(在线购买)</a>&nbsp;或者&nbsp;<a style="color:blue" href="http://www.ebanhui.com/down.html" title="e板会云播放器" target="_blank">e板会云播放器</a>&nbsp;进行上传。<a style="color:red" href="javascript:openplay()" title="马上新建原创作品">马上新建原创作品!</a>
</div>
<?php }?> 
</ul>
<?=show_page($spacecount,$pagesize);?>	
</div>
</div>
</div>
</div>

<script type="text/javascript">
var surl = "/member/space-0-0-0-###.html";
function deletespace(id,title) {
	var result = confirm("您确定要删除您的作品 "+title+" 吗?");
	if (result) {
		var aurl = "<?=geturl('member/space/del')?>";
		$.post(aurl,{"id":id},function(result){
			if (result == 1) {//.status
				//alert(result.msg);
				document.location.href = document.location.href;
			} else {
				//alert(result.msg);
			}
		});
	}
}
$(function(){
	$("#room_search_btn").click(function(){
		var search = $('#title').val();
			search = search.replace(/,/g,"");
			search = search.replace(/\'/g,"");
			search = search.replace(/\//g,"");
			search = search.replace(/%/g,"");
			search = search.replace(/_/g,"");
			search = search.replace(/#/g,"");
			search = search.replace(/\?/g,"");
			search = search.replace(/\\/g,"");
			search = search.replace(/>/g,"");
		if($('#title').val()=='请输入您要搜索的作品名称'){
			search='';
		}
		var url = surl.replace("###",encodeURIComponent(search));
		location.href=url;
	});
	$("#title").focus(function(){
		if($('#title').val()=='请输入您要搜索的作品名称')
			$('#title').val('').css('color','#999999');
	});
	$("#title").blur(function(){
		if($('#title').val()=='')
			$('#title').val('请输入您要搜索的作品名称').css('color','#999999');
	});
});
</script>
<script type="text/javascript">
<!--
	function shTextBox1(id){
		document.getElementById("sh1"+id).style.display = "none";
		document.getElementById("sh2"+id).style.display = "block";
		}

	function changeTextBox1(id){
		var newtitle= document.getElementById("showtextbox"+id).value;
			newtitle = newtitle.replace(/,/g,"");
			newtitle = newtitle.replace(/\'/g,"");
			newtitle = newtitle.replace(/\//g,"");
			newtitle = newtitle.replace(/%/g,"");
			newtitle = newtitle.replace(/_/g,"");
			newtitle = newtitle.replace(/#/g,"");
			newtitle = newtitle.replace(/\?/g,"");
			newtitle = newtitle.replace(/\\/g,"");
			newtitle = newtitle.replace(/>/g,"");
	    if(newtitle==""){
			document.getElementById("sh2"+id).style.display = "block";
		}
		else{
			var urldata = {'title':newtitle,'id':id}
			var oldtitle = document.getElementById("linka"+id).innerHTML;
			if(oldtitle != newtitle){
				$.ajax({
					type	: "POST",
					url		: "<?=geturl('member/space/edittitle')?>",
					data	: urldata,
					datatype: 'html',
					success	: function(html){
					//alert(html);
						// strarr = html.split('|');
						 if(html==1){
							$.showmessage({message:'成功',animatespeed:500,timeoutspeed:500});
							document.getElementById("linka"+id).innerHTML=newtitle;
							var linkopen = document.getElementById("open" + id);
			                var linkdel = document.getElementById("del" + id);
			                linkopen.href = linkopen.href.replace(oldtitle, newtitle);
			                linkdel.href = linkdel.href.replace(oldtitle, newtitle);

						}
						else{
							$.showmessage({message:'失败',animatespeed:500,timeoutspeed:500});
						}
					}
				});
			}
			
			document.getElementById("sh1"+id).style.display = "block";
			document.getElementById("sh2"+id).style.display = "none";
			document.getElementById("linka"+id).innerHTML=newtitle;
			
		}
}
//-->
</script>
<?php
$this->display('common/player');
$this->display('common/footer');
?>